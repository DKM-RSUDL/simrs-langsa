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
use App\Models\RmeEfekNyeri;
use App\Models\Agama;
use App\Models\Pendidikan;
use App\Models\Pekerjaan;
use App\Models\MrItemFisik;
use App\Models\RmeAsesmenGeriatri;
use App\Models\RmeAsesmenGeriatriRencanaPulang;
use App\Models\RmeAsesmenPsikiatri;
use App\Models\RmeAsesmenPsikiatriDtl;
use App\Models\RmeSuratKematian;
use App\Models\RmePaps;
use App\Models\PernyataanDPJP;
use App\Models\RmeRohani;
use App\Models\RmeAsesmenTerminal;
use App\Models\RmeAsesmenTerminalFmo;
use App\Models\RmeAsesmenTerminalUsk;
use App\Models\RmeAsesmenTerminalAf;
use App\Models\RmePermintaanPrivasi;
use App\Models\RmePenundaanPelayanan;
use App\Models\RmeDnr;
use Illuminate\Support\Carbon;
use App\Services\AsesmenService;

use App\Models\EWSPasienDewasa;
use App\Models\EWSPasienAnak;
use App\Models\EwsPasienObstetrik;
use Illuminate\Support\Facades\DB;

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
        ];
    }

    /**
     * Get Asesmen Opthamology (Rawat Inap) data untuk ditampilkan di berkas digital
     * Menyusun variabel yang diperlukan oleh blade print opthamology
     */
    public function getAsesmenOpthamologyData($dataMedis)
    {
        try {
            // Tentukan tanggal masuk
            $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

            $asesmenOpthamology = RmeAsesmen::with([
                'rmeAsesmenKepOphtamology',
                'rmeAsesmenKepOphtamologyKomprehensif',
                'rmeAsesmenKepOphtamologyFisik',
                'rmeAsesmenKepOphtamologyRencanaPulang',
                'user'
            ])
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->where('kd_unit', $dataMedis->kd_unit)
                ->whereDate('tgl_masuk', $tglMasuk)
                ->where('urut_masuk', $dataMedis->urut_masuk)
                ->where('kategori', 1)
                ->where('sub_kategori', 6)
                ->first();

            if (!$asesmenOpthamology) {
                $asesmenOpthamology = RmeAsesmen::with([
                    'rmeAsesmenKepOphtamology',
                    'rmeAsesmenKepOphtamologyKomprehensif',
                    'rmeAsesmenKepOphtamologyFisik',
                    'rmeAsesmenKepOphtamologyRencanaPulang',
                    'user'
                ])
                    ->where('kd_pasien', $dataMedis->kd_pasien)
                    ->where('kd_unit', $dataMedis->kd_unit)
                    ->whereDate('tgl_masuk', $tglMasuk)
                    ->where('kategori', 1)
                    ->where('sub_kategori', 6)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            if (!$asesmenOpthamology) {
                $asesmenOpthamology = RmeAsesmen::with([
                    'rmeAsesmenKepOphtamology',
                    'rmeAsesmenKepOphtamologyKomprehensif',
                    'rmeAsesmenKepOphtamologyFisik',
                    'rmeAsesmenKepOphtamologyRencanaPulang',
                    'user'
                ])
                    ->where('kd_pasien', $dataMedis->kd_pasien)
                    ->whereDate('tgl_masuk', $tglMasuk)
                    ->where('kategori', 1)
                    ->where('sub_kategori', 6)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            if (!$asesmenOpthamology) {
                $asesmenOpthamology = RmeAsesmen::with([
                    'rmeAsesmenKepOphtamology',
                    'rmeAsesmenKepOphtamologyKomprehensif',
                    'rmeAsesmenKepOphtamologyFisik',
                    'rmeAsesmenKepOphtamologyRencanaPulang',
                    'user'
                ])
                    ->where('kd_pasien', $dataMedis->kd_pasien)
                    ->where('kategori', 1)
                    ->where('sub_kategori', 6)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            // Jika masih tidak ada, return data kosong
            if (!$asesmenOpthamology) {
                return $this->emptyAsesmenOpthamologyData($dataMedis);
            }

            // Ambil data tambahan seperti di controller opthamologi
            $faktorpemberat = RmeFaktorPemberat::all();
            $menjalar = RmeMenjalar::all();
            $frekuensinyeri = RmeFrekuensiNyeri::all();
            $kualitasnyeri = RmeKualitasNyeri::all();
            $faktorperingan = RmeFaktorPeringan::all();
            $efeknyeri = RmeEfekNyeri::all();
            $jenisnyeri = RmeJenisNyeri::all();
            $itemFisik = MrItemFisik::orderby('urut')->get();
            $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
            $rmeMasterImplementasi = RmeMasterImplementasi::all();
            $satsetPrognosis = SatsetPrognosis::all();

            return compact(
                'asesmenOpthamology',
                'faktorpemberat',
                'menjalar',
                'frekuensinyeri',
                'kualitasnyeri',
                'faktorperingan',
                'efeknyeri',
                'jenisnyeri',
                'itemFisik',
                'rmeMasterDiagnosis',
                'rmeMasterImplementasi',
                'satsetPrognosis'
            );
        } catch (\Exception $e) {
            return $this->emptyAsesmenOpthamologyData($dataMedis);
        }
    }

    /**
     * Return empty data structure untuk asesmen opthamology
     */
    private function emptyAsesmenOpthamologyData($dataMedis)
    {
        return [
            'asesmenOpthamology' => null,
            'faktorpemberat' => collect([]),
            'menjalar' => collect([]),
            'frekuensinyeri' => collect([]),
            'kualitasnyeri' => collect([]),
            'faktorperingan' => collect([]),
            'efeknyeri' => collect([]),
            'jenisnyeri' => collect([]),
            'itemFisik' => collect([]),
            'rmeMasterDiagnosis' => collect([]),
            'rmeMasterImplementasi' => collect([]),
            'satsetPrognosis' => collect([]),
        ];
    }

    /**
     * Get Asesmen Medis Anak data untuk ditampilkan di berkas digital dokumen
     * Menyusun variabel yang diperlukan oleh blade print asesmen-medis-anak
     */
    public function getAsesmenMedisAnakData($dataMedis)
    {
        // Tentukan tanggal masuk
        $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

        // Ambil data asesmen medis anak (kategori=1, sub_kategori=7)
        $asesmenMedisAnak = RmeAsesmen::with([
            'asesmenMedisAnak',
            'asesmenMedisAnakFisik',
            'asesmenMedisAnakDtl',
            'user'
        ])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', $tglMasuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kategori', 1)
            ->where('sub_kategori', 7)
            ->first();

        // Jika tidak ada, return data kosong
        if (!$asesmenMedisAnak) {
            return null;
        }

        // Ambil master data yang diperlukan untuk print asesmen medis anak
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();
        $satsetPrognosis = SatsetPrognosis::all();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $dataMedis->kd_pasien)->get();

        return compact(
            'asesmenMedisAnak',
            'rmeMasterDiagnosis',
            'rmeMasterImplementasi',
            'satsetPrognosis',
            'alergiPasien'
        );
    }

    /**
     * Get Asesmen Obstetri Maternitas data untuk ditampilkan di berkas digital dokumen
     * Menyusun variabel yang diperlukan oleh blade print asesmen-obstetri-maternitas
     */
    public function getAsesmenObstetriData($dataMedis)
    {
        // Tentukan tanggal masuk
        $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

        // Ambil data asesmen obstetri (kategori=1, sub_kategori=4)
        $asesmenObstetri = RmeAsesmen::with([
            'asesmenObstetri',
            'rmeAsesmenObstetriPemeriksaanFisik',
            'rmeAsesmenObstetriStatusNyeri',
            'rmeAsesmenObstetriRiwayatKesehatan',
            'rmeAsesmenObstetriDiagnosisImplementasi',
            'rmeAsesmenObstetriDischargePlanning',
            'pemeriksaanFisik',
            'user'
        ])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', $tglMasuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kategori', 1)
            ->where('sub_kategori', 4)
            ->first();

        // Jika tidak ada, return null
        if (!$asesmenObstetri) {
            return null;
        }

        // Ambil master data yang diperlukan untuk print asesmen obstetri
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();
        $satsetPrognosis = SatsetPrognosis::all();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $dataMedis->kd_pasien)->get();

        return compact(
            'asesmenObstetri',
            'rmeMasterDiagnosis',
            'rmeMasterImplementasi',
            'satsetPrognosis',
            'alergiPasien'
        );
    }

    /**
     * Get Asesmen THT Medis data untuk ditampilkan di berkas digital dokumen
     * Menyusun variabel yang diperlukan oleh blade print asesmen-tht
     */
    public function getAsesmenThtData($dataMedis)
    {
        // Tentukan tanggal masuk
        $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

        // Ambil data asesmen THT (kategori=1, sub_kategori=5)
        $asesmenTht = RmeAsesmen::with([
            'rmeAsesmenTht',
            'rmeAsesmenThtPemeriksaanFisik',
            'rmeAsesmenThtRiwayatKesehatanObatAlergi',
            'rmeAsesmenThtDischargePlanning',
            'rmeAsesmenThtDiagnosisImplementasi',
            'user'
        ])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kategori', 1)
            ->where('sub_kategori', 5)
            ->orderBy('waktu_asesmen', 'desc')
            ->first();

        // Jika tidak ada, return null
        if (!$asesmenTht) {
            return null;
        }

        // Ambil master data yang diperlukan untuk print asesmen THT
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();
        $satsetPrognosis = SatsetPrognosis::all();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $dataMedis->kd_pasien)->get();
        $itemFisik = MrItemFisik::orderby('urut')->get();

        return compact(
            'asesmenTht',
            'rmeMasterDiagnosis',
            'rmeMasterImplementasi',
            'satsetPrognosis',
            'alergiPasien',
            'itemFisik'
        );
    }

    /**
     * Get Asesmen Paru data untuk ditampilkan di berkas digital dokumen
     * Menyusun variabel yang diperlukan oleh blade print asesmen-paru
     */
    public function getAsesmenParuData($dataMedis)
    {
        // Tentukan tanggal masuk
        $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

        // Ambil data asesmen Paru (kategori=1, sub_kategori=8)
        $asesmenParu = RmeAsesmen::with([
            'user',
            'rmeAsesmenParu',
            'rmeAsesmenParuRencanaKerja',
            'rmeAsesmenParuPerencanaanPulang',
            'rmeAsesmenParuDiagnosisImplementasi',
            'rmeAsesmenParuPemeriksaanFisik',
            'rmeAlergiPasien',
            'pemeriksaanFisik' => function ($query) {
                $query->orderBy('id_item_fisik');
            },
        ])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kategori', 1)
            ->where('sub_kategori', 8)
            ->orderBy('waktu_asesmen', 'desc')
            ->first();

        // Jika tidak ada, return null
        if (!$asesmenParu) {
            return null;
        }

        // Ambil master data yang diperlukan untuk print asesmen Paru
        $satsetPrognosis = SatsetPrognosis::all();

        // Get KebiasaanData (inline logic dari controller)
        $KebiasaanData = [
            'alkohol' => [
                'status' => 'tidak',
                'jenis' => null,
            ],
            'merokok' => [
                'status' => 'tidak',
                'detail' => [],
            ],
            'obat' => [
                'status' => 'tidak',
                'detail' => [],
            ],
        ];

        // Ambil data kebiasaan dari rmeAsesmenParu jika ada
        if ($asesmenParu->rmeAsesmenParu) {
            $kebiasaanPasien = $asesmenParu->rmeAsesmenParu;

            $isAlkohol = $kebiasaanPasien->alkohol == 'ya' ? true : false;
            $isMerokok = $kebiasaanPasien->merokok == 'ya' ? true : false;
            $isObat = $kebiasaanPasien->obat == 'ya' ? true : false;

            // Format ulang data untuk KebiasaanData
            $KebiasaanData['alkohol'] = [
                'status' => $isAlkohol ? 'ya' : 'tidak',
                'jenis' => $kebiasaanPasien->alkohol_jenis,
            ];
            $KebiasaanData['merokok'] = [
                'status' => $isMerokok ? 'ya' : 'tidak',
                'detail' => $kebiasaanPasien->merokok_data,
            ];
            $KebiasaanData['obat'] = [
                'status' => $isObat ? 'ya' : 'tidak',
                'detail' => $kebiasaanPasien->obat_data,
            ];
        }

        return compact(
            'asesmenParu',
            'satsetPrognosis',
            'KebiasaanData'
        );
    }

    /**
     * Get Asesmen Ginekologik data untuk ditampilkan di berkas digital dokumen
     * Menyusun variabel yang diperlukan oleh blade print asesmen-ginekologik
     */
    public function getAsesmenGinekologikData($dataMedis)
    {
        // Tentukan tanggal masuk
        $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

        // Ambil data asesmen Ginekologik (kategori=1, sub_kategori=9)
        $asesmenGinekologik = RmeAsesmen::with([
            'user',
            'rmeAsesmenGinekologik',
            'rmeAsesmenGinekologikTandaVital',
            'rmeAsesmenGinekologikPemeriksaanFisik',
            'rmeAsesmenGinekologikEkstremitasGinekologik',
            'rmeAsesmenGinekologikPemeriksaanDischarge',
            'rmeAsesmenGinekologikDiagnosisImplementasi',
            'pemeriksaanFisik' => function ($query) {
                $query->orderBy('id_item_fisik');
            },
        ])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kategori', 1)
            ->where('sub_kategori', 9)
            ->orderBy('waktu_asesmen', 'desc')
            ->first();

        // Jika tidak ada, return null
        if (!$asesmenGinekologik) {
            return null;
        }

        // Ambil master data yang diperlukan untuk print asesmen Ginekologik
        $satsetPrognosis = SatsetPrognosis::all();

        // Ambil data relasi untuk kemudahan akses di blade
        $rmeAsesmenGinekologik = $asesmenGinekologik->rmeAsesmenGinekologik;
        $rmeAsesmenGinekologikTandaVital = $asesmenGinekologik->rmeAsesmenGinekologikTandaVital;
        $rmeAsesmenGinekologikPemeriksaanFisik = $asesmenGinekologik->rmeAsesmenGinekologikPemeriksaanFisik;
        $rmeAsesmenGinekologikEkstremitasGinekologik = $asesmenGinekologik->rmeAsesmenGinekologikEkstremitasGinekologik;
        $rmeAsesmenGinekologikPemeriksaanDischarge = $asesmenGinekologik->rmeAsesmenGinekologikPemeriksaanDischarge;
        $rmeAsesmenGinekologikDiagnosisImplementasi = $asesmenGinekologik->rmeAsesmenGinekologikDiagnosisImplementasi;

        return compact(
            'asesmenGinekologik',
            'rmeAsesmenGinekologik',
            'rmeAsesmenGinekologikTandaVital',
            'rmeAsesmenGinekologikPemeriksaanFisik',
            'rmeAsesmenGinekologikEkstremitasGinekologik',
            'rmeAsesmenGinekologikPemeriksaanDischarge',
            'rmeAsesmenGinekologikDiagnosisImplementasi',
            'satsetPrognosis'
        );
    }

    /**
     * Get Asesmen Geriatri (Rawat Inap) data untuk ditampilkan di berkas digital
     * Menyusun variabel yang diperlukan oleh blade print asesmen-geriatri
     */
    public function getAsesmenGeriatriData($dataMedis)
    {
        $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

        $asesmen = RmeAsesmen::with(['user'])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kategori', 1)
            ->where('sub_kategori', 12)
            ->orderBy('waktu_asesmen', 'desc')
            ->first();

        if (!$asesmen) {
            return null;
        }

        $asesmenGeriatri = RmeAsesmenGeriatri::where('id_asesmen', $asesmen->id)->first();
        if (!$asesmenGeriatri) {
            return null;
        }

        $pemeriksaanFisik = RmeAsesmenPemeriksaanFisik::with('itemFisik')
            ->where('id_asesmen', $asesmen->id)
            ->get()
            ->keyBy('id_item_fisik');

        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $dataMedis->kd_pasien)->get();
        $rencanaPulang = RmeAsesmenGeriatriRencanaPulang::where('id_asesmen', $asesmen->id)->first();
        $itemFisik = MrItemFisik::orderby('urut')->get();

        $diagnosisBanding = json_decode($asesmenGeriatri->diagnosis_banding ?? '[]', true);
        $diagnosisKerja = json_decode($asesmenGeriatri->diagnosis_kerja ?? '[]', true);
        $adl = json_decode($asesmenGeriatri->adl ?? '[]', true);
        $kognitif = json_decode($asesmenGeriatri->kognitif ?? '[]', true);
        $depresi = json_decode($asesmenGeriatri->depresi ?? '[]', true);
        $inkontinensia = json_decode($asesmenGeriatri->inkontinensia ?? '[]', true);
        $insomnia = json_decode($asesmenGeriatri->insomnia ?? '[]', true);
        $kategoriImt = json_decode($asesmenGeriatri->kategori_imt ?? '[]', true);

        return compact(
            'asesmen',
            'asesmenGeriatri',
            'dataMedis',
            'pemeriksaanFisik',
            'itemFisik',
            'rencanaPulang',
            'alergiPasien',
            'diagnosisBanding',
            'diagnosisKerja',
            'adl',
            'kognitif',
            'depresi',
            'inkontinensia',
            'insomnia',
            'kategoriImt'
        );
    }

    /**
     * Get Asesmen Psikiatri data untuk ditampilkan di berkas digital dokumen
     * Menyusun variabel yang diperlukan oleh blade print asesmen-psikiatri
     */
    public function getAsesmenPsikiatriData($dataMedis)
    {
        // Tentukan tanggal masuk
        $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

        // Ambil data asesmen Psikiatri (kategori=1, sub_kategori=11)
        $asesmen = RmeAsesmen::with(['user'])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kategori', 1)
            ->where('sub_kategori', 11)
            ->orderBy('waktu_asesmen', 'desc')
            ->first();

        // Jika tidak ada, return null
        if (!$asesmen) {
            return null;
        }

        // Ambil data relasi psikiatri
        $asesmenPsikiatri = RmeAsesmenPsikiatri::where('id_asesmen', $asesmen->id)->first();
        $asesmenPsikiatriDtl = RmeAsesmenPsikiatriDtl::where('id_asesmen', $asesmen->id)->first();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $dataMedis->kd_pasien)->get();

        return compact(
            'asesmen',
            'asesmenPsikiatri',
            'asesmenPsikiatriDtl',
            'alergiPasien'
        );
    }

    /**
     * Get Asesmen Medis Neonatologi (Rawat Inap) data untuk ditampilkan di berkas digital dokumen
     * Menyusun variabel yang diperlukan oleh blade print asesmen-medis-neonatologi
     */
    public function getAsesmenMedisNeonatologiData($dataMedis)
    {
        // Tentukan tanggal masuk
        $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

        // Ambil data asesmen medis neonatologi (kategori=1, sub_kategori=14)
        $asesmen = RmeAsesmen::with([
            'asesmenMedisNeonatologi',
            'asesmenMedisNeonatologiFisikGeneralis',
            'asesmenMedisNeonatologiDtl'
        ])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kategori', 1)
            ->where('sub_kategori', 14)
            ->orderBy('waktu_asesmen', 'desc')
            ->first();

        // Jika tidak ada, return null
        if (!$asesmen) {
            return null;
        }

        // Ambil master data yang diperlukan untuk print asesmen medis neonatologi
        $rmeMasterDiagnosis = RmeMasterDiagnosis::all();
        $rmeMasterImplementasi = RmeMasterImplementasi::all();
        $satsetPrognosis = SatsetPrognosis::all();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $dataMedis->kd_pasien)->get();

        return compact(
            'asesmen',
            'dataMedis',
            'rmeMasterDiagnosis',
            'rmeMasterImplementasi',
            'satsetPrognosis',
            'alergiPasien'
        );
    }

    /**
     * Get Asesmen Keperawatan Anak (Rawat Inap) data untuk ditampilkan di berkas digital dokumen
     * Menyusun variabel yang diperlukan oleh blade print asesmen-anak
     */
    public function getAsesmenKepAnakData($dataMedis)
    {
        try {
            $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

            $asesmen = RmeAsesmen::with([
                'rmeAsesmenKepAnak',
                'rmeAsesmenKepAnakFisik',
                'rmeAsesmenKepAnakStatusNyeri',
                'rmeAsesmenKepAnakRiwayatKesehatan',
                'rmeAsesmenKepAnakRisikoJatuh',
                'rmeAsesmenKepAnakResikoDekubitus',
                'rmeAsesmenKepAnakStatusPsikologis',
                'rmeAsesmenKepAnakSosialEkonomi',
                'rmeAsesmenKepAnakGizi',
                'rmeAsesmenKepAnakStatusFungsional',
                'rmeAsesmenKepAnakRencanaPulang',
                'rmeAsesmenKepAnakKeperawatan',
                'pemeriksaanFisik',
                'pemeriksaanFisik.itemFisik',
                'user'
            ])
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
                ->where('urut_masuk', $dataMedis->urut_masuk)
                ->where('kategori', 2)
                ->where('sub_kategori', 7)
                ->orderBy('waktu_asesmen', 'desc')
                ->first();

            if (!$asesmen) {
                return $this->emptyAsesmenKepAnakData($dataMedis);
            }

            return compact('asesmen', 'dataMedis');
        } catch (\Exception $e) {
            return $this->emptyAsesmenKepAnakData($dataMedis);
        }
    }

    /**
     * Return empty data structure untuk asesmen keperawatan anak
     */
    private function emptyAsesmenKepAnakData($dataMedis)
    {
        return [
            'asesmen' => null,
            'dataMedis' => $dataMedis,
        ];
    }

    /**
     * Get Asesmen Keperawatan Perinatology (Rawat Inap) data untuk ditampilkan di berkas digital dokumen
     * Menyusun variabel yang diperlukan oleh blade print asesmen-perinatology
     */
    public function getAsesmenKepPerinatologyData($dataMedis)
    {
        try {
            $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

            $asesmen = RmeAsesmen::with([
                'rmeAsesmenPerinatology',
                'rmeAsesmenPerinatologyFisik',
                'rmeAsesmenPerinatologyPemeriksaanLanjut',
                'rmeAsesmenPerinatologyRiwayatIbu',
                'rmeAsesmenPerinatologyStatusNyeri',
                'rmeAsesmenPerinatologyRisikoJatuh',
                'rmeAsesmenPerinatologyResikoDekubitus',
                'rmeAsesmenPerinatologyGizi',
                'rmeAsesmenPerinatologyStatusFungsional',
                'rmeAsesmenPerinatologyRencanaPulang',
                'rmeAsesmenKepPerinatologyKeperawatan',
                'pemeriksaanFisik',
                'pemeriksaanFisik.itemFisik',
                'user'
            ])
                ->where('kd_unit', $dataMedis->kd_unit)
                ->where('kd_pasien', $dataMedis->kd_pasien)
                ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
                ->where('urut_masuk', $dataMedis->urut_masuk)
                ->where('kategori', 2)
                ->where('sub_kategori', 2)
                ->orderBy('waktu_asesmen', 'desc')
                ->first();

            if (!$asesmen) {
                return $this->emptyAsesmenKepPerinatologyData($dataMedis);
            }

            return compact('asesmen', 'dataMedis');
        } catch (\Exception $e) {
            return $this->emptyAsesmenKepPerinatologyData($dataMedis);
        }
    }

    /**
     * Return empty data structure untuk asesmen keperawatan perinatology
     */
    private function emptyAsesmenKepPerinatologyData($dataMedis)
    {
        return [
            'asesmen' => null,
            'dataMedis' => $dataMedis,
        ];
    }

    /**
     * Get Asesmen Keperawatan Terminal data
     */
    public function getAsesmenKeperawatanTerminalData($dataMedis)
    {
        $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

        $asesmen = RmeAsesmen::with([
            'rmeAsesmenTerminal',
            'rmeAsesmenTerminalFmo',
            'rmeAsesmenTerminalUsk',
            'rmeAsesmenTerminalAf',
            'user.karyawan'
        ])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', $tglMasuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kategori', 2)
            ->where('sub_kategori', 13) // Asesmen Terminal
            ->orderBy('waktu_asesmen', 'desc')
            ->first();

        if (!$asesmen) {
            return $this->emptyAsesmenKeperawatanTerminalData($dataMedis);
        }

        return compact('asesmen', 'dataMedis');
    }

    /**
     * Return empty data structure untuk asesmen keperawatan terminal
     */
    private function emptyAsesmenKeperawatanTerminalData($dataMedis)
    {
        return [
            'asesmen' => null,
            'dataMedis' => $dataMedis,
        ];
    }

    /**
     * Get Asesmen Awal Keperawatan Dewasa Rawat Inap data untuk ditampilkan di berkas digital dokumen
     */
    public function getAsesmenAwalKeperawatanDewasaData($dataMedis)
    {
        // Tentukan tanggal masuk
        $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

        // Ambil data asesmen awal keperawatan rawat inap (kategori=2, sub_kategori=1)
        $asesmen = RmeAsesmen::with([
            'asesmenKetDewasaRanap',
            'asesmenKetDewasaRanapRiwayatPasien',
            'asesmenKetDewasaRanapFisik',
            'asesmenKetDewasaRanapStatusNutrisi',
            'asesmenKetDewasaRanapSkalaNyeri',
            'asesmenKetDewasaRanapResikoJatuh',
            'asesmenKetDewasaRanapPengkajianEdukasi',
            'asesmenKetDewasaRanapDischargePlanning',
            'asesmenKetDewasaRanapDietKhusus',
            'asesmenKetDewasaRanapDiagnosisKeperawatan',
            'pasien',
            'user'
        ])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->whereDate('tgl_masuk', date('Y-m-d', strtotime($tglMasuk)))
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->where('kategori', 2) // Kategori Keperawatan
            ->where('sub_kategori', 1) // Sub kategori Pengkajian Awal
            ->orderBy('waktu_asesmen', 'desc')
            ->first();

        // Jika tidak ada, return data kosong
        if (!$asesmen) {
            return [
                'asesmen' => null,
                'dataMedis' => $dataMedis,
                'masterData' => [
                    'rmeMasterDiagnosis' => collect([]),
                    'rmeMasterImplementasi' => collect([]),
                    'satsetPrognosis' => collect([]),
                    'alergiPasien' => collect([]),
                    'dokter' => collect([]),
                ]
            ];
        }

        // Ambil master data yang diperlukan untuk print
        $masterData = [
            'rmeMasterDiagnosis' => RmeMasterDiagnosis::all(),
            'rmeMasterImplementasi' => RmeMasterImplementasi::all(),
            'satsetPrognosis' => SatsetPrognosis::all(),
            'alergiPasien' => RmeAlergiPasien::where('kd_pasien', $dataMedis->kd_pasien)->get(),
            'dokter' => \App\Models\Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get(),
        ];

        return compact('asesmen', 'dataMedis', 'masterData');
    }

    /**
     * Get Surat Kematian data untuk ditampilkan di berkas digital dokumen
     * Hanya untuk pasien yang sudah meninggal dunia
     */
    public function getSuratKematianData($dataMedis)
    {
        // Ambil data surat kematian berdasarkan kunjungan
        $suratKematian = RmeSuratKematian::where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->where('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->with(['detailType1', 'detailType2', 'dokter'])
            ->first();

        return compact('suratKematian');
    }

    /**
     * Get EWS Pasien Dewasa data untuk ditampilkan di berkas digital dokumen
     */
    public function getEWSPasienDewasaData($dataMedis)
    {
        // Ambil semua data EWS Pasien Dewasa untuk kunjungan ini
        $ewsRecords = EWSPasienDewasa::where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->get();

        // Jika ada records, ambil yang pertama sebagai ewsPasienDewasa utama (untuk info umum)
        $ewsPasienDewasa = $ewsRecords->first();

        // Hitung skor total dan risiko untuk setiap record
        $ewsRecords->transform(function ($record) {
            $skor = 0;

            // Hitung skor berdasarkan parameter
            if ($record->avpu == 'P' || $record->avpu == 'U') $skor += 3;
            if ($record->saturasi_o2 >= 96) $skor += 0;
            elseif ($record->saturasi_o2 >= 94) $skor += 1;
            elseif ($record->saturasi_o2 >= 92) $skor += 2;
            else $skor += 3;

            $sistolik = explode('/', $record->tekanan_darah)[0] ?? 0;
            if ($sistolik <= 90 || $sistolik >= 220) $skor += 3;
            elseif ($sistolik <= 100 || $sistolik >= 200) $skor += 2;
            elseif ($sistolik <= 110 || $sistolik >= 180) $skor += 1;

            if ($record->nadi <= 40 || $record->nadi >= 130) $skor += 3;
            elseif ($record->nadi <= 50 || $record->nadi >= 120) $skor += 2;
            elseif ($record->nadi <= 60 || $record->nadi >= 100) $skor += 1;

            if ($record->nafas <= 8 || $record->nafas >= 30) $skor += 3;
            elseif ($record->nafas <= 10 || $record->nafas >= 25) $skor += 2;
            elseif ($record->nafas <= 12 || $record->nafas >= 21) $skor += 1;

            if ($record->temperatur <= 35.0 || $record->temperatur >= 39.1) $skor += 3;
            elseif (($record->temperatur >= 35.1 && $record->temperatur <= 35.9) || ($record->temperatur >= 38.1 && $record->temperatur <= 39.0)) $skor += 1;

            $record->total_skor = $skor;

            // Tentukan risiko
            if ($skor >= 7) {
                $record->risiko = 'Tinggi';
                $record->risk_class = 'hasil-high';
                $record->risk_text = 'RISIKO TINGGI';
            } elseif ($skor >= 5 || ($skor >= 3 && in_array($record->avpu, ['P', 'U']))) {
                $record->risiko = 'Sedang';
                $record->risk_class = 'hasil-medium';
                $record->risk_text = 'RISIKO SEDANG';
            } else {
                $record->risiko = 'Rendah';
                $record->risk_class = 'hasil-low';
                $record->risk_text = 'RISIKO RENDAH';
            }

            return $record;
        });

        return compact('ewsRecords', 'ewsPasienDewasa');
    }

    /**
     * Get EWS Pasien Anak data untuk ditampilkan di berkas digital
     */
    public function getEWSPasienAnakData($dataMedis)
    {
        // Ambil semua data EWS Pasien Anak untuk kunjungan ini
        $ewsRecords = EWSPasienAnak::where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->get();

        // Jika ada records, ambil yang pertama sebagai ewsPasienAnak utama (untuk info umum)
        $ewsPasienAnak = $ewsRecords->first();

        return compact('ewsRecords', 'ewsPasienAnak');
    }

    /**
     * Get EWS Pasien Obstetrik data untuk ditampilkan di berkas digital
     */
    public function getEWSPasienObstetrikData($dataMedis)
    {
        // Ambil semua data EWS Pasien Obstetrik untuk kunjungan ini
        $ewsRecords = EwsPasienObstetrik::where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->get();

        // Jika ada records, ambil yang pertama sebagai ewsPasienObstetrik utama (untuk info umum)
        $ewsPasienObstetrik = $ewsRecords->first();

        return compact('ewsRecords', 'ewsPasienObstetrik');
    }

    /**
     * Get Pernyataan DPJP data untuk ditampilkan di berkas digital
     */
    public function getPernyataanDPJPData($dataMedis)
    {
        return PernyataanDPJP::with('dokter')
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * Get Meninggalkan Perawatan data untuk ditampilkan di berkas digital
     */
    public function getMeninggalkanPerawatanData($dataMedis)
    {
        return \App\Models\RmeMeninggalkanPerawatan::with(['dokter'])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->get();
    }

    public function getPapsData($dataMedis)
    {
        return RmePaps::with('detail')
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    /**
     * Get Data Permintaan Pelayanan Rohani
     * Multiple data bisa ada untuk 1 pasien dalam 1 kunjungan
     */
    public function getRohaniData($dataMedis)
    {
        $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

        $rohani = RmeRohani::with(['penyetuju', 'keluargaAgama'])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->whereDate('tgl_masuk', $tglMasuk)
            ->get();

        return $rohani;
    }

    /**
     * Get Data Permintaan Privasi
     * Multiple data bisa ada untuk 1 pasien dalam 1 kunjungan
     */
    public function getPermintaanPrivasiData($dataMedis)
    {
        $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

        $privasi = RmePermintaanPrivasi::with(['userCreate'])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->whereDate('tgl_masuk', $tglMasuk)
            ->get();

        return $privasi;
    }

    /**
     * Get Penundaan Pelayanan data untuk ditampilkan di berkas digital
     * Menampilkan semua surat penundaan pelayanan untuk pasien ini
     */
    public function getPenundaanPelayananData($dataMedis)
    {
        $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

        $penundaan = RmePenundaanPelayanan::with(['userCreate', 'dokter'])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->whereDate('tgl_masuk', $tglMasuk)
            ->get();

        return $penundaan;
    }

    /**
     * Get Penolakan Resusitasi (DNR) data untuk ditampilkan di berkas digital
     * Menampilkan semua surat penolakan resusitasi untuk pasien ini
     */
    public function getDnrData($dataMedis)
    {
        $tglMasuk = isset($dataMedis->tgl_transaksi) ? $dataMedis->tgl_transaksi : $dataMedis->tgl_masuk;

        $dnr = RmeDnr::with(['dokter'])
            ->where('kd_pasien', $dataMedis->kd_pasien)
            ->where('kd_unit', $dataMedis->kd_unit)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->whereDate('tgl_masuk', $tglMasuk)
            ->get();

        return $dnr;
    }
}
