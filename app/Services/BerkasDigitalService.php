<?php

namespace App\Services;

use App\Models\AsalIGD;
use App\Models\RmeAsesmen;
use App\Models\DataTriase;
use App\Models\RmeAlergiPasien;
use App\Models\SegalaOrder;
use App\Models\RmeMasterDiagnosis;
use App\Models\RmeMasterImplementasi;
use App\Models\SatsetPrognosis;
use App\Models\RMEResume;
use App\Models\ListTindakanPasien;
use App\Models\RmeAsesmenPemeriksaanFisik;
use App\Models\RmeFaktorPemberat;
use App\Models\RmeFaktorPeringan;
use App\Models\RmeFrekuensiNyeri;
use App\Models\RmeJenisNyeri;
use App\Models\RmeKualitasNyeri;
use App\Models\RmeMenjalar;
use App\Models\Agama;
use App\Models\Pendidikan;
use App\Models\Pekerjaan;
use App\Models\MrItemFisik;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Services\AsesmenService;

class BerkasDigitalService
{
    private $kdUnit = 3; // Gawat Darurat

    public function getAsesmenData($dataMedis)
    {
        try {
            // Cek apakah ini rawat inap dengan asal IGD
            $asalIGD = AsalIGD::where('kd_kasir', $dataMedis->kd_kasir)
                ->where('no_transaksi', $dataMedis->no_transaksi)
                ->first();

            // Jika ada asal IGD, ambil data dari kunjungan IGD
            if ($asalIGD) {
                $baseService = new BaseService();
                $kunjunganIGD = $baseService->getDataMedisbyTransaksi(
                    $asalIGD->kd_kasir_asal,
                    $asalIGD->no_transaksi_asal
                );

                if ($kunjunganIGD) {
                    // Gunakan data dari kunjungan IGD
                    $tglMasuk = $kunjunganIGD->tgl_transaksi ?? $kunjunganIGD->tgl_masuk;
                    $kdPasien = $kunjunganIGD->kd_pasien;
                    $urutMasuk = $kunjunganIGD->urut_masuk;
                    $kdUnit = $this->kdUnit;
                } else {
                    return $this->getAsesmenDataFallback($dataMedis);
                }
            } else {
                // Tidak ada asal IGD, gunakan data medis langsung (untuk kunjungan IGD langsung)
                $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;
                $kdPasien = $dataMedis->kd_pasien;
                $urutMasuk = $dataMedis->urut_masuk;
                $kdUnit = $this->kdUnit;
            }

            // STRATEGI 1: Cari dengan urut_masuk dan tanpa filter kategori
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
                ->where('kd_pasien', $kdPasien)
                ->where('kd_unit', $kdUnit)
                ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
                ->where('urut_masuk', $urutMasuk)
                ->orderBy('waktu_asesmen', 'desc')
                ->first();

            // STRATEGI 2: Jika tidak ada, cari tanpa urut_masuk
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
                    ->where('kd_pasien', $kdPasien)
                    ->where('kd_unit', $kdUnit)
                    ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
                    ->orderBy('waktu_asesmen', 'desc')
                    ->first();
            }

            // STRATEGI 3: Cari di semua unit untuk pasien ini pada tanggal tersebut
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
                    ->where('kd_pasien', $kdPasien)
                    ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
                    ->orderBy('waktu_asesmen', 'desc')
                    ->first();
            }

            // STRATEGI 4: Ambil asesmen terbaru untuk pasien ini (tanpa batasan tanggal)
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
                    ->where('kd_pasien', $kdPasien)
                    ->where('kd_unit', $kdUnit)
                    ->orderBy('waktu_asesmen', 'desc')
                    ->first();
            }

            // Jika asesmen ditemukan tapi data inti kosong, cari asesmen lain yang memiliki data
            if ($asesmen && $this->isAsesmenCoreEmpty($asesmen)) {
                $asesmenWithData = RmeAsesmen::with([
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
                    ->where('kd_pasien', $kdPasien)
                    ->where('kd_unit', $kdUnit)
                    ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
                    ->where('urut_masuk', $urutMasuk)
                    ->where(function ($query) {
                        $query->whereNotNull('tindakan_resusitasi')
                            ->orWhereNotNull('anamnesis');
                    })
                    ->orderBy('waktu_asesmen', 'desc')
                    ->first();

                if ($asesmenWithData) {
                    $asesmen = $asesmenWithData;
                }
            }

            // Jika masih tidak ada data asesmen
            if (!$asesmen) {
                return $this->emptyAsesmenData($dataMedis);
            }

            // Format triase data
            $triase = $this->getTriaseData($dataMedis, $asesmen);

            // Ambil riwayat alergi dari tabel RmeAlergiPasien
            $riwayatAlergi = RmeAlergiPasien::where('kd_pasien', $asesmen->kd_pasien)->get();

            // Ambil data laboratorium
            $laborData = $this->getLabor($kdPasien, $tglMasuk, $urutMasuk);

            // Ambil data radiologi
            $radiologiData = $this->getRadiologi($kdPasien, $tglMasuk, $urutMasuk);

            // Ambil riwayat obat
            $riwayatObat = $this->getRiwayatObat($kdPasien, $tglMasuk, $urutMasuk);

            $retriaseData = DataTriase::where('id_asesmen', $asesmen->id)->get();

            return compact('asesmen', 'triase', 'riwayatAlergi', 'laborData', 'radiologiData', 'riwayatObat', 'retriaseData');
        } catch (\Exception $e) {
            \Log::error('Error in getAsesmenData: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return $this->emptyAsesmenData($dataMedis);
        }
    }

    private function getAsesmenDataFallback($dataMedis)
    {
        $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

        // Coba cari asesmen di unit rawat inap
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
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('waktu_asesmen', 'desc')
            ->first();

        if (!$asesmen) {
            return $this->emptyAsesmenData($dataMedis);
        }

        $triase = $this->getTriaseData($dataMedis, $asesmen);
        $riwayatAlergi = RmeAlergiPasien::where('kd_pasien', $asesmen->kd_pasien)->get();
        $laborData = $this->getLabor($dataMedis->kd_pasien, $tglMasuk, $dataMedis->urut_masuk);
        $radiologiData = $this->getRadiologi($dataMedis->kd_pasien, $tglMasuk, $dataMedis->urut_masuk);
        $riwayatObat = $this->getRiwayatObat($dataMedis->kd_pasien, $tglMasuk, $dataMedis->urut_masuk);
        $retriaseData = DataTriase::where('id_asesmen', $asesmen->id)->get();

        return compact('asesmen', 'triase', 'riwayatAlergi', 'laborData', 'radiologiData', 'riwayatObat', 'retriaseData');
    }

    /**
     * Return empty data structure untuk asesmen
     */
    private function emptyAsesmenData($dataMedis)
    {
        return [
            'asesmen' => null,
            'triase' => ['label' => '-', 'warna' => '-'],
            'riwayatAlergi' => collect([]),
            'laborData' => collect([]),
            'radiologiData' => collect([]),
            'riwayatObat' => collect([]),
            'retriaseData' => collect([]),
        ];
    }

    // Cek apakah data inti asesmen kosong sehingga perlu fallback
    private function isAsesmenCoreEmpty($asesmen)
    {
        if (!$asesmen) {
            return true;
        }

        $tindakan = $asesmen->tindakan_resusitasi;
        $anamnesis = $asesmen->anamnesis;

        $tindakanEmpty = empty($tindakan) || $tindakan === '{}' || $tindakan === '[]';
        $anamnesisEmpty = is_null($anamnesis) || trim((string) $anamnesis) === '';

        return $tindakanEmpty && $anamnesisEmpty;
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

    /**
     * Get Resume Medis (Rawat Inap) data untuk ditampilkan di berkas digital dokumen
     * Menyusun variabel yang diperlukan oleh blade print resume-medis
     */
    public function getResumeMedisData($dataMedis)
    {
        $resume = RMEResume::with(['pasien', 'rmeResumeDet', 'rmeResumeDet.unitRajal', 'unit'])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($dataMedis->tgl_masuk)))
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->orderBy('tgl_masuk', 'desc')
            ->first();

        $hasilKonpas = '-';
        $labor = collect([]);
        $radiologi = collect([]);
        $tindakan = collect([]);
        $pemeriksaanFisik = collect([]);
        $resepRawat = collect([]);
        $resepPulang = collect([]);

        if ($resume) {
            // Vital sign terakhir
            $asesmenService = new AsesmenService();
            $vitalSign = $asesmenService->getVitalSignData($dataMedis->kd_kasir, $dataMedis->no_transaksi);

            $sistole = $vitalSign->sistole ?? '-';
            $diastole = $vitalSign->diastole ?? '-';
            $td = "TD : {$sistole}/{$diastole} mmHg";

            $rrVal = $vitalSign->respiration ?? '-';
            $rr = "RR : {$rrVal} x/mnt";

            $nadiVal = $vitalSign->nadi ?? '-';
            $nadi = "Nadi : {$nadiVal} x/mnt";

            $suhuVal = $vitalSign->suhu ?? '-';
            $suhu = "Suhu : {$suhuVal} C";

            $tbVal = $vitalSign->tinggi_badan ?? '-';
            $tb = "TB : {$tbVal} cm";

            $bbVal = $vitalSign->berat_badan ?? '-';
            $bb = "BB : {$bbVal} kg";

            $hasilKonpas = "{$td}, {$rr}, {$nadi}, {$suhu}, {$tb}, {$bb}";

            // Penunjang Laboratorium dan Radiologi untuk unit rawat inap
            $labor = SegalaOrder::with(['details'])
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->where('kd_unit', $dataMedis->kd_unit)
                ->whereDate('tgl_masuk', date('Y-m-d', strtotime($dataMedis->tgl_masuk)))
                ->where('urut_masuk', $dataMedis->urut_masuk)
                ->where('kategori', 'LB')
                ->orderBy('tgl_order', 'desc')
                ->get();

            $radiologi = SegalaOrder::with(['details'])
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->where('kd_unit', $dataMedis->kd_unit)
                ->whereDate('tgl_masuk', date('Y-m-d', strtotime($dataMedis->tgl_masuk)))
                ->where('urut_masuk', $dataMedis->urut_masuk)
                ->where('kategori', 'RD')
                ->orderBy('tgl_order', 'desc')
                ->get();

            // Tindakan
            $tindakan = ListTindakanPasien::with(['produk'])
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->where('kd_unit', $dataMedis->kd_unit)
                ->whereDate('tgl_masuk', date('Y-m-d', strtotime($dataMedis->tgl_masuk)))
                ->where('urut_masuk', $dataMedis->urut_masuk)
                ->get();

            // Pemeriksaan fisik dari pengkajian awal medis rawat inap
            $lastAsesmen = RmeAsesmen::with(['pemeriksaanFisik'])
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->where('kd_unit', $dataMedis->kd_unit)
                ->whereDate('tgl_masuk', date('Y-m-d', strtotime($dataMedis->tgl_masuk)))
                ->where('urut_masuk', $dataMedis->urut_masuk)
                ->where('kategori', 1)
                ->where('sub_kategori', 1)
                ->orderBy('waktu_asesmen', 'desc')
                ->first();

            $pemeriksaanFisik = RmeAsesmenPemeriksaanFisik::with(['itemFisik'])
                ->where('id_asesmen', ($lastAsesmen->id ?? 0))
                ->where('is_normal', 0)
                ->get();

            // Obat rawat dan pulang
            $resepRawat = $this->getRiwayatObatHariIniRanap($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk);
            $resepPulang = $this->getObatPulangRanap($dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk);
        }

        return compact('resume', 'hasilKonpas', 'labor', 'radiologi', 'tindakan', 'pemeriksaanFisik', 'resepRawat', 'resepPulang');
    }

    private function getRiwayatObatHariIniRanap($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        return DB::table('MR_RESEP')
            ->join('DOKTER', 'MR_RESEP.KD_DOKTER', '=', 'DOKTER.KD_DOKTER')
            ->leftJoin('MR_RESEPDTL', 'MR_RESEP.ID_MRRESEP', '=', 'MR_RESEPDTL.ID_MRRESEP')
            ->leftJoin('APT_OBAT', 'MR_RESEPDTL.KD_PRD', '=', 'APT_OBAT.KD_PRD')
            ->where('MR_RESEP.kd_pasien', $kd_pasien)
            ->whereDate('MR_RESEP.tgl_masuk', $tgl_masuk)
            ->where('MR_RESEP.urut_masuk', $urut_masuk)
            ->where('MR_RESEP.kd_unit', $kd_unit)
            ->where(function ($query) {
                $query->where('MR_RESEP.RESEP_PULANG', '!=', 1)
                    ->orWhereNull('MR_RESEP.RESEP_PULANG');
            })
            ->select(
                'MR_RESEP.TGL_ORDER',
                DB::raw('DOKTER.NAMA as nama_dokter'),
                'MR_RESEP.ID_MRRESEP',
                'MR_RESEP.STATUS',
                DB::raw('MR_RESEPDTL.CARA_PAKAI as cara_pakai'),
                DB::raw('MR_RESEPDTL.JUMLAH as jumlah'),
                DB::raw('MR_RESEPDTL.KET as ket'),
                DB::raw('MR_RESEPDTL.JUMLAH_TAKARAN as jumlah_takaran'),
                DB::raw('MR_RESEPDTL.SATUAN_TAKARAN as satuan_takaran'),
                DB::raw('APT_OBAT.NAMA_OBAT as nama_obat')
            )
            ->distinct()
            ->orderBy('MR_RESEP.TGL_ORDER', 'desc')
            ->get();
    }

    private function getObatPulangRanap($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        return DB::table('MR_RESEP')
            ->join('DOKTER', 'MR_RESEP.KD_DOKTER', '=', 'DOKTER.KD_DOKTER')
            ->leftJoin('MR_RESEPDTL', 'MR_RESEP.ID_MRRESEP', '=', 'MR_RESEPDTL.ID_MRRESEP')
            ->leftJoin('APT_OBAT', 'MR_RESEPDTL.KD_PRD', '=', 'APT_OBAT.KD_PRD')
            ->where('MR_RESEP.kd_pasien', $kd_pasien)
            ->whereDate('MR_RESEP.tgl_masuk', $tgl_masuk)
            ->where('MR_RESEP.urut_masuk', $urut_masuk)
            ->where('MR_RESEP.kd_unit', $kd_unit)
            ->where('MR_RESEP.RESEP_PULANG', 1)
            ->select(
                'MR_RESEP.TGL_ORDER',
                DB::raw('DOKTER.NAMA as nama_dokter'),
                'MR_RESEP.ID_MRRESEP',
                'MR_RESEP.STATUS',
                DB::raw('MR_RESEPDTL.CARA_PAKAI as cara_pakai'),
                DB::raw('MR_RESEPDTL.JUMLAH as jumlah'),
                DB::raw('MR_RESEPDTL.KET as ket'),
                DB::raw('MR_RESEPDTL.JUMLAH_TAKARAN as jumlah_takaran'),
                DB::raw('MR_RESEPDTL.SATUAN_TAKARAN as satuan_takaran'),
                DB::raw('APT_OBAT.NAMA_OBAT as nama_obat')
            )
            ->distinct()
            ->orderBy('MR_RESEP.TGL_ORDER', 'desc')
            ->get();
    }
    /**
     * Get Pengkajian Awal Medis (Rawat Inap) data
     * Untuk ditampilkan di berkas digital dokumen
     */
    public function getPengkajianAwalMedisData($dataMedis)
    {
        // Tentukan tanggal masuk
        $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

        // Ambil data pengkajian awal medis rawat inap (kategori=1, sub_kategori=1)
        $pengkajianAsesmen = RmeAsesmen::with([
            'pasien',
            'asesmenMedisRanap',
            'asesmenMedisRanapFisik',
            'user'
        ])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kategori', 1) // Kategori Medis
            ->where('sub_kategori', 1) // Sub kategori Pengkajian Awal
            ->orderBy('waktu_asesmen', 'desc')
            ->first();

        // Jika tidak ada, return data kosong
        if (!$pengkajianAsesmen) {
            return [
                'pengkajianAsesmen' => null,
                'rmeMasterDiagnosis' => collect([]),
                'rmeMasterImplementasi' => collect([]),
                'satsetPrognosis' => collect([]),
                'alergiPasien' => collect([]),
            ];
        }

        // Ambil master data yang diperlukan untuk print pengkajian awal medis
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();
        $satsetPrognosis = SatsetPrognosis::all();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $dataMedis->kd_pasien)->get();

        return compact(
            'pengkajianAsesmen',
            'rmeMasterDiagnosis',
            'rmeMasterImplementasi',
            'satsetPrognosis',
            'alergiPasien'
        );
    }

    /**
     * Get Triase IGD data untuk ditampilkan di berkas digital
     * Fungsi ini mengambil data triase dari IGD berdasarkan asal IGD rawat inap
     */
    public function getTriaseIGD($dataMedis)
    {
        try {
            // GET ASAL IGD - Cari asal IGD berdasarkan kd_kasir dan no_transaksi rawat inap
            $asalIGD = AsalIGD::where('kd_kasir', $dataMedis->kd_kasir)
                ->where('no_transaksi', $dataMedis->no_transaksi)
                ->first();

            if (!$asalIGD) {
                return ['triase' => null];
            }

            // Get data kunjungan IGD dari asal IGD
            $baseService = new BaseService();
            $kunjunganIGD = $baseService->getDataMedisbyTransaksi($asalIGD->kd_kasir_asal, $asalIGD->no_transaksi_asal);

            if (!$kunjunganIGD) {
                return ['triase' => null];
            }

            // Get data triase dari IGD dengan dokter
            $triase = DataTriase::with(['dokter'])
                ->find($kunjunganIGD->triase_id);

            if (!$triase) {
                return ['triase' => null];
            }

            // Decode JSON data
            $triase->triase = json_decode($triase->triase, true) ?? [];
            $triase->vital_sign = json_decode($triase->vital_sign, true) ?? [];

            return compact('triase');
        } catch (\Exception $e) {
            // Return null data jika ada error
            return ['triase' => null];
        }
    }

    /**
     * Get Asesmen Keperawatan (IGD) data untuk ditampilkan di berkas digital
     * Menyusun variabel yang diperlukan oleh blade print-pdf keperawatan
     */
    public function getAsesmenKeperawatanData($dataMedis)
    {
        try {
            // GET ASAL IGD - Cari asal IGD berdasarkan kd_kasir dan no_transaksi rawat inap
            $asalIGD = AsalIGD::where('kd_kasir', $dataMedis->kd_kasir)
                ->where('no_transaksi', $dataMedis->no_transaksi)
                ->first();

            // Jika tidak ada asal IGD, return null
            if (!$asalIGD) {
                return $this->emptyAsesmenKeperawatanData($dataMedis);
            }

            // Get data kunjungan IGD dari asal IGD
            $baseService = new BaseService();
            $kunjunganIGD = $baseService->getDataMedisbyTransaksi($asalIGD->kd_kasir_asal, $asalIGD->no_transaksi_asal);

            if (!$kunjunganIGD) {
                return $this->emptyAsesmenKeperawatanData($dataMedis);
            }

            $tglMasuk = $kunjunganIGD->tgl_transaksi;
            $kdUnit = 3; // IGD

            // Ambil asesmen keperawatan dengan semua relasi
            $asesmen = RmeAsesmen::with([
                'asesmenKepUmum',
                'asesmenKepUmumBreathing',
                'asesmenKepUmumCirculation',
                'asesmenKepUmumDisability',
                'asesmenKepUmumExposure',
                'asesmenKepUmumSkalaNyeri',
                'asesmenKepUmumRisikoJatuh',
                'asesmenKepUmumSosialEkonomi',
                'asesmenKepUmumGizi'
            ])
                ->where('kd_pasien', $kunjunganIGD->kd_pasien)
                ->where('kd_unit', $kdUnit)
                ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
                ->where('urut_masuk', $kunjunganIGD->urut_masuk)
                ->where('kategori', 2) // Kategori Keperawatan
                ->where('sub_kategori', 1) // Sub kategori Pengkajian Awal
                ->orderBy('waktu_asesmen', 'desc')
                ->first();

            if (!$asesmen) {
                return $this->emptyAsesmenKeperawatanData($dataMedis);
            }

            // Ambil master data yang diperlukan (cache untuk performa)
            $faktorPemberatData = cache()->remember('faktor_pemberat', 3600, function () {
                return RmeFaktorPemberat::select('id', 'name')->pluck('name', 'id');
            });

            $kualitasNyeriData = cache()->remember('kualitas_nyeri', 3600, function () {
                return RmeKualitasNyeri::select('id', 'name')->pluck('name', 'id');
            });

            $menjalarData = cache()->remember('menjalar', 3600, function () {
                return RmeMenjalar::select('id', 'name')->pluck('name', 'id');
            });

            $faktorPeringanData = cache()->remember('faktor_peringan', 3600, function () {
                return RmeFaktorPeringan::select('id', 'name')->pluck('name', 'id');
            });

            $frekuensiNyeriData = cache()->remember('frekuensi_nyeri', 3600, function () {
                return RmeFrekuensiNyeri::select('id', 'name')->pluck('name', 'id');
            });

            $jenisNyeriData = cache()->remember('jenis_nyeri', 3600, function () {
                return RmeJenisNyeri::select('id', 'name')->pluck('name', 'id');
            });

            $pekerjaanData = cache()->remember('pekerjaan', 3600, function () {
                return Pekerjaan::select('kd_pekerjaan', 'pekerjaan')->pluck('pekerjaan', 'kd_pekerjaan');
            });

            $agamaData = cache()->remember('agama', 3600, function () {
                return Agama::select('kd_agama', 'agama')->pluck('agama', 'kd_agama');
            });

            $pendidikanData = cache()->remember('pendidikan', 3600, function () {
                return Pendidikan::select('kd_pendidikan', 'pendidikan')->pluck('pendidikan', 'kd_pendidikan');
            });

            $asesmenTanggal = $asesmen->created_at ?? now();
            $tglMasukFormatted = $kunjunganIGD->tgl_masuk ?? now();

            return [
                'asesmen' => $asesmen,
                'pasien' => $kunjunganIGD->pasien ?? $dataMedis->pasien ?? null,
                'dataMedis' => $kunjunganIGD,
                'asesmenKepUmum' => $asesmen->asesmenKepUmum ?? null,
                'asesmenBreathing' => $asesmen->asesmenKepUmumBreathing ?? null,
                'asesmenCirculation' => $asesmen->asesmenKepUmumCirculation ?? null,
                'asesmenDisability' => $asesmen->asesmenKepUmumDisability ?? null,
                'asesmenExposure' => $asesmen->asesmenKepUmumExposure ?? null,
                'asesmenSkalaNyeri' => $asesmen->asesmenKepUmumSkalaNyeri ?? null,
                'asesmenRisikoJatuh' => $asesmen->asesmenKepUmumRisikoJatuh ?? null,
                'asesmenSosialEkonomi' => $asesmen->asesmenKepUmumSosialEkonomi ?? null,
                'asesmenStatusGizi' => $asesmen->asesmenKepUmumGizi ?? null,
                'asesmenTanggal' => $asesmenTanggal,
                'tglMasukFormatted' => $tglMasukFormatted,
                'faktorPemberatData' => $faktorPemberatData,
                'kualitasNyeriData' => $kualitasNyeriData,
                'menjalarData' => $menjalarData,
                'faktorPeringanData' => $faktorPeringanData,
                'frekuensiNyeriData' => $frekuensiNyeriData,
                'jenisNyeriData' => $jenisNyeriData,
                'pekerjaanData' => $pekerjaanData,
                'agamaData' => $agamaData,
                'pendidikanData' => $pendidikanData,
            ];
        } catch (\Exception $e) {
            return $this->emptyAsesmenKeperawatanData($dataMedis);
        }
    }

    /**
     * Return empty data structure untuk asesmen keperawatan
     */
    private function emptyAsesmenKeperawatanData($dataMedis)
    {
        return [
            'asesmen' => null,
            'pasien' => $dataMedis->pasien ?? null,
            'dataMedis' => $dataMedis,
            'asesmenKepUmum' => null,
            'asesmenBreathing' => null,
            'asesmenCirculation' => null,
            'asesmenDisability' => null,
            'asesmenExposure' => null,
            'asesmenSkalaNyeri' => null,
            'asesmenRisikoJatuh' => null,
            'asesmenSosialEkonomi' => null,
            'asesmenStatusGizi' => null,
            'asesmenTanggal' => null,
            'tglMasukFormatted' => null,
            'faktorPemberatData' => collect([]),
            'kualitasNyeriData' => collect([]),
            'menjalarData' => collect([]),
            'faktorPeringanData' => collect([]),
            'frekuensiNyeriData' => collect([]),
            'jenisNyeriData' => collect([]),
            'pekerjaanData' => collect([]),
            'agamaData' => collect([]),
            'pendidikanData' => collect([]),
        ];
    }

    /**
     * Get Asesmen Neurologi (Rawat Inap) data untuk ditampilkan di berkas digital
     * Menyusun variabel yang diperlukan oleh blade print neurologi
     */
    public function getAsesmenNeurologiData($dataMedis)
    {
        try {
            $tglMasuk = $dataMedis->tgl_masuk;
            $kdUnit = $dataMedis->kd_unit;

            // Ambil asesmen neurologi dengan semua relasi (kategori 1, sub_kategori 3)
            $asesmen = RmeAsesmen::with([
                'rmeAsesmenNeurologi',
                'rmeAsesmenNeurologiSistemSyaraf',
                'rmeAsesmenNeurologiIntensitasNyeri',
                'rmeAsesmenNeurologiDischargePlanning',
                'pemeriksaanFisik',
                'pemeriksaanFisik.itemFisik'
            ])
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->where('kd_unit', $kdUnit)
                ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
                ->where('urut_masuk', $dataMedis->urut_masuk)
                ->where('kategori', 1) // Kategori Medis
                ->where('sub_kategori', 3) // Sub kategori Neurologi
                ->orderBy('waktu_asesmen', 'desc')
                ->first();

            if (!$asesmen) {
                return $this->emptyAsesmenNeurologiData($dataMedis);
            }

            // Ambil master data yang diperlukan
            $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
            $rmeMasterImplementasi = RmeMasterImplementasi::all();
            $satsetPrognosis = SatsetPrognosis::all();
            $alergiPasien = RmeAlergiPasien::where('kd_pasien', $dataMedis->kd_pasien)->get();
            $itemFisik = MrItemFisik::orderby('urut')->get();

            return [
                'asesmen' => $asesmen,
                'dataMedis' => $dataMedis,
                'rmeMasterDiagnosis' => $rmeMasterDiagnosis,
                'rmeMasterImplementasi' => $rmeMasterImplementasi,
                'satsetPrognosis' => $satsetPrognosis,
                'alergiPasien' => $alergiPasien,
                'itemFisik' => $itemFisik,
            ];
        } catch (\Exception $e) {
            return $this->emptyAsesmenNeurologiData($dataMedis);
        }
    }

    /**
     * Return empty data structure untuk asesmen neurologi
     */
    private function emptyAsesmenNeurologiData($dataMedis)
    {
        return [
            'asesmen' => null,
            'dataMedis' => $dataMedis,
            'rmeMasterDiagnosis' => collect([]),
            'rmeMasterImplementasi' => collect([]),
            'satsetPrognosis' => collect([]),
            'alergiPasien' => collect([]),
            'itemFisik' => collect([]),
        ];
    }
}
