<?php

namespace App\Services;

use App\Models\RmeAsesmen;
use App\Models\DataTriase;
use App\Models\RmeAlergiPasien;
use App\Models\SegalaOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BerkasDigitalService
{
    private $kdUnit = 3; // Gawat Darurat

    public function getAsesmenData($dataMedis)
    {
        // Tentukan field tanggal yang akan digunakan
        // Jika dataMedis dari Transaksi, gunakan tgl_transaksi
        // Jika dataMedis dari Kunjungan, gunakan tgl_masuk
        $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;
        // Selalu gunakan unit IGD untuk berkas digital
        $kdUnit = $this->kdUnit;

        // Ambil data asesmen IGD dengan semua relasi yang diperlukan
        $asesmen = RmeAsesmen::with([
            'pasien',
            'menjalar',
            'frekuensiNyeri',
            'kualitasNyeri',
            'faktorPemberat',
            'faktorPeringan',
            'efekNyeri',
            'tindaklanjut',
            'tindaklanjut.spri',
            'pemeriksaanFisik',
            'pemeriksaanFisik.itemFisik',
            'user'
        ])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $kdUnit)
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('waktu_asesmen', 'desc')
            ->first();

        // Jika tidak ada asesmen dengan urut_masuk, cari yang paling baru untuk pasien ini
        if (!$asesmen) {
            $asesmen = RmeAsesmen::with([
                'pasien',
                'menjalar',
                'frekuensiNyeri',
                'kualitasNyeri',
                'faktorPemberat',
                'faktorPeringan',
                'efekNyeri',
                'tindaklanjut',
                'tindaklanjut.spri',
                'pemeriksaanFisik',
                'pemeriksaanFisik.itemFisik',
                'user'
            ])
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->where('kd_unit', $kdUnit)
                ->orderBy('waktu_asesmen', 'desc')
                ->first();
        }

        // Format triase data
        $triase = $this->getTriaseData($dataMedis, $asesmen);

        // Ambil riwayat alergi dari tabel RmeAlergiPasien
        $riwayatAlergi = [];
        if ($asesmen) {
            $riwayatAlergi = RmeAlergiPasien::where('kd_pasien', $asesmen->kd_pasien)->get();
        }

        // Ambil data laboratorium
        $laborData = $this->getLabor($dataMedis->kd_pasien, $tglMasuk, $dataMedis->urut_masuk);

        // Ambil data radiologi
        $radiologiData = $this->getRadiologi($dataMedis->kd_pasien, $tglMasuk, $dataMedis->urut_masuk);

        // Ambil riwayat obat
        $riwayatObat = $this->getRiwayatObat($dataMedis->kd_pasien, $tglMasuk, $dataMedis->urut_masuk);
        $retriaseData = collect([]);
        if ($asesmen) {
            $retriaseData = DataTriase::where('id_asesmen', $asesmen->id)->get();
        }

        return compact('asesmen', 'triase', 'riwayatAlergi', 'laborData', 'radiologiData', 'riwayatObat', 'retriaseData');
    }

    private function getTriaseData($dataMedis, $asesmen = null)
    {
        $triaselabel = '-';
        $triasename = '-';

        switch ($dataMedis->kd_triase) {
            case '1':
                $triaselabel = 'FALSE EMERGENCY';
                $triasename = 'HIJAU';
                break;
            case '2':
                $triaselabel = 'URGNET';
                $triasename = 'KUNING';
                break;
            case '3':
                $triaselabel = 'EMERGENCY';
                $triasename = 'MERAH';
                break;
            case '4':
                $triaselabel = 'RESUSITASI';
                $triasename = 'MERAH';
                break;
            case '5':
                $triaselabel = 'DOA';
                $triasename = 'HITAM';
                break;
        }

        return [
            'label' => $triaselabel,
            'warna' => $triasename,
        ];
    }

    private function getRiwayatObat($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $tglMasukFormatted = date('Y-m-d', strtotime($tgl_masuk));

        return DB::table('MR_RESEP')
            ->join('DOKTER', 'MR_RESEP.KD_DOKTER', '=', 'DOKTER.KD_DOKTER')
            ->leftJoin('MR_RESEPDTL', 'MR_RESEP.ID_MRRESEP', '=', 'MR_RESEPDTL.ID_MRRESEP')
            ->leftJoin('APT_OBAT', 'MR_RESEPDTL.KD_PRD', '=', 'APT_OBAT.KD_PRD')
            ->where('MR_RESEP.KD_PASIEN', $kd_pasien)
            ->whereDate('MR_RESEP.tgl_masuk', $tglMasukFormatted)
            ->where('MR_RESEP.urut_masuk', $urut_masuk)
            ->where('MR_RESEP.kd_unit', $this->kdUnit)
            ->select(
                'MR_RESEP.TGL_ORDER',
                'DOKTER.NAMA_LENGKAP as NAMA_DOKTER',
                'MR_RESEP.ID_MRRESEP',
                'MR_RESEP.STATUS',
                'MR_RESEPDTL.CARA_PAKAI',
                'MR_RESEPDTL.JUMLAH',
                'MR_RESEPDTL.KET',
                'MR_RESEPDTL.JUMLAH_TAKARAN',
                'MR_RESEPDTL.SATUAN_TAKARAN',
                'APT_OBAT.NAMA_OBAT'
            )
            ->distinct()
            ->orderBy('MR_RESEP.TGL_ORDER', 'desc')
            ->get();
    }

    protected function getLabData($kd_order, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $results = DB::table('SEGALA_ORDER as so')
            ->select([
                'so.kd_order',
                'so.kd_pasien',
                'so.tgl_order',
                'so.tgl_masuk',
                'sod.kd_produk',
                'p.deskripsi as nama_produk',
                'kp.klasifikasi',
                'lt.item_test',
                'sod.jumlah',
                'sod.status',
                'lh.hasil',
                'lh.satuan',
                'lh.nilai_normal',
                'lh.tgl_masuk',
                'lh.KD_UNIT',
                'lh.URUT_MASUK',
                'lt.kd_test'
            ])
            ->join('SEGALA_ORDER_DET as sod', 'so.kd_order', '=', 'sod.kd_order')
            ->join('PRODUK as p', 'sod.kd_produk', '=', 'p.kd_produk')
            ->join('KLAS_PRODUK as kp', 'p.kd_klas', '=', 'kp.kd_klas')
            ->join('LAB_HASIL as lh', function ($join) {
                $join->on('p.kd_produk', '=', 'lh.kd_produk')
                    ->on('so.kd_pasien', '=', 'lh.kd_pasien')
                    ->on('so.tgl_masuk', '=', 'lh.tgl_masuk');
            })
            ->join('LAB_TEST as lt', function ($join) {
                $join->on('lh.kd_lab', '=', 'lt.kd_lab')
                    ->on('lh.kd_test', '=', 'lt.kd_test');
            })
            ->where([
                'so.tgl_masuk' => $tgl_masuk,
                'so.kd_order' => $kd_order,
                'so.kd_pasien' => $kd_pasien,
                'so.kd_unit' => $this->kdUnit,
                'so.urut_masuk' => $urut_masuk
            ])
            ->orderBy('lt.kd_test')
            ->get();

        // Group results by nama_produk and include klasifikasi
        return collect($results)->groupBy('nama_produk')->map(function ($group) {
            $klasifikasi = $group->first()->klasifikasi;
            return [
                'klasifikasi' => $klasifikasi,
                'tests' => $group->map(function ($item) {
                    return [
                        'item_test' => $item->item_test ?? '-',
                        'hasil' => $item->hasil ?? '-',
                        'satuan' => $item->satuan ?? '',
                        'nilai_normal' => $item->nilai_normal ?? '-',
                        'kd_test' => $item->kd_test
                    ];
                })
            ];
        });
    }

    private function getLabor($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Mengambil data hasil pemeriksaan laboratorium
        $dataLabor = SegalaOrder::with(['details.produk', 'produk.labHasil'])
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tgl_masuk)))
            ->where('urut_masuk', $urut_masuk)
            ->where('kd_unit', $this->kdUnit)
            ->whereHas('details.produk', function ($query) {
                $query->where('KD_KAT', 'LB');
            })
            ->orderBy('tgl_order', 'desc')
            ->get();

        // Transform lab results
        $dataLabor->transform(function ($item) {
            foreach ($item->details as $detail) {
                $labResults = $this->getLabData(
                    $item->kd_order,
                    $item->kd_pasien,
                    $item->tgl_masuk,
                    $item->urut_masuk
                );
                $detail->labResults = $labResults;
            }
            return $item;
        });

        return $dataLabor;
    }

    private function getRadiologi($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $tglMasukFormatted = date('Y-m-d', strtotime($tgl_masuk));
        return SegalaOrder::with(['details.produk', 'dokter'])
            ->where('kd_pasien', $kd_pasien)
            ->whereDate('tgl_masuk', $tglMasukFormatted)
            ->where('urut_masuk', $urut_masuk)
            ->where('kd_unit', $this->kdUnit)
            ->where('kategori', 'RD')
            ->orderBy('tgl_order', 'desc')
            ->get()
            ->map(function ($order) {
                $namaPemeriksaan = $order->details->map(function ($detail) {
                    return $detail->produk->deskripsi ?? '';
                })->filter()->implode(', ');

                return [
                    'Tanggal-Jam' => Carbon::parse($order->tgl_order)->format('d M Y H:i'),
                    'Nama Pemeriksaan' => $namaPemeriksaan,
                    'Status' => $this->getStatusOrderRadiologi($order->status_order),
                ];
            });
    }

    private function getStatusOrderRadiologi($statusOrder)
    {
        switch ($statusOrder) {
            case 0:
                return '<span class="text-warning">Diproses</span>';
            case 1:
                return '<span class="text-secondary">Diorder</span>';
            case 2:
                return '<span class="text-success">Selesai</span>';
            default:
                return '<span class="text-secondary">Unknown</span>';
        }
    }
}
