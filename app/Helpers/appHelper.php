<?php

use App\Models\Kunjungan;
use App\Models\Navigation;
use App\Models\OrderHD;
use App\Models\OrderRehabMedik;
use App\Models\RmeMasterTindakLanjut;
use App\Models\RmeSerahTerima;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

if (!function_exists('getMenus')) {
    function getMenus()
    {
        $cacheKey = "rme_menus";

        $menus = Cache::remember($cacheKey, 3600, function () {
            return Navigation::with('subMenus')->orderBy('sort', 'asc')->get();
        });

        return $menus;
    }
}

if (!function_exists('getParentMenus')) {
    function getParentMenus($url)
    {
        $cacheKey = "rme_menu_$url";

        $menu = Cache::remember($cacheKey, 3600, function () use ($url) {
            return Navigation::where('url', $url)->first();
        });

        if ($menu) {
            $parentMenu = Cache::remember("rme_parentmenu_$url", 300, function () use ($menu) {
                return Navigation::select('name')->where('id', $menu->main_menu)->first();
            });

            return $parentMenu->name ?? '';
        }
        return '';
    }
}

if (!function_exists('getRoles')) {
    function getRoles()
    {
        // return Role::where('name', '!=', 'admin')->get();
        return Role::all();
    }
}

if (!function_exists('getKategoriAsesmen')) {
    function getKategoriAsesmen($kategori, $subKategori, $kd_unit = null)
    {
        $kategoriLabel = '';
        $subKategoriLabel = '';

        switch ($kategori) {
            case 1:
                $kategoriLabel = 'Medis';
                break;
            case 2:
                $kategoriLabel = 'Keperawatan';
                break;
        }

        switch ($subKategori) {
            case 1:
                $subKategoriLabel = 'Umum/Dewasa';
                if ($kd_unit == 3) $subKategoriLabel = 'Gawat Darurat';
                break;
            case 2:
                $subKategoriLabel = 'Perinatologi';
                break;
            case 3:
                $subKategoriLabel = 'Neurologi';
                break;
            case 4:
                $subKategoriLabel = 'Obstetrik';
                break;
            case 5:
                $subKategoriLabel = 'THT';
                break;
            case 6:
                $subKategoriLabel = 'Opthamologi';
                break;
            case 7:
                $subKategoriLabel = 'Anak';
                break;
            case 8:
                $subKategoriLabel = 'Paru';
                break;
            case 9:
                $subKategoriLabel = 'Ginekologik';
                break;
            case 10:
                $subKategoriLabel = 'Kulit Kelamin';
                break;
            case 11:
                $subKategoriLabel = 'Psikiatri';
                break;
            case 12:
                $subKategoriLabel = 'Geriatri';
                break;
            case 13:
                $subKategoriLabel = 'Terminal & Keluarga';
                break;
            case 14:
                $subKategoriLabel = 'Neonatologi';
                break;
        }

        return "$kategoriLabel $subKategoriLabel";
    }
}

if (!function_exists('selisihHari')) {
    function selisihHari($tanggalMulai, $tanggalAkhir)
    {
        $mulai = new DateTime($tanggalMulai);
        $akhir = new DateTime($tanggalAkhir);
        $selisih = $mulai->diff($akhir);

        return $selisih->days; // Mengembalikan jumlah hari
    }
}

if (!function_exists('tindakLanjutLabel')) {
    // function tindakLanjutLabel($tlCode)
    // {
    //     $label = '-';

    //     switch ($tlCode) {
    //         case 1:
    //             $label = 'Rawat Inap';
    //             break;
    //         case 2:
    //             $label = 'Kontrol Ulang';
    //             break;
    //         case 3:
    //             $label = 'Selesai di Unit';
    //             break;
    //         case 4:
    //             $label = 'Rujuk Internal';
    //             break;
    //         case 5:
    //             $label = 'Rujuk RS Lain';
    //             break;
    //         case 6:
    //             $label = 'Pulang';
    //             break;
    //         case 7:
    //             $label = 'Kamar Operasi';
    //             break;
    //         case 8:
    //             $label = 'Berobat Jalan Ke Poli';
    //             break;
    //         case 9:
    //             $label = 'Menolak Rawat Inap';
    //             break;
    //         case 10:
    //             $label = 'Meninggal Dunia';
    //             break;
    //         case 11:
    //             $label = 'Doa (Death On Arrive)';
    //             break;
    //     }


    //     return $label;
    // }

    function tindakLanjutLabel($tlCode)
    {
        $tindakLanjut = RmeMasterTindakLanjut::where('kode', $tlCode)->first();
        return $tindakLanjut->nama ?? '-';
    }
}

if (!function_exists('alasanPulangLabel')) {
    function alasanPulangLabel($code)
    {
        $label = '-';

        switch ($code) {
            case 1:
                $label = 'Sembuh';
                break;
            case 2:
                $label = 'Indikasi Medis';
                break;
            case 3:
                $label = 'Atas Permintaan Sendiri';
                break;
        }

        return $label;
    }
}

if (!function_exists('kondisiPulangLabel')) {
    function kondisiPulangLabel($code)
    {
        $label = '-';

        switch ($code) {
            case 1:
                $label = 'Mandiri';
                break;
            case 2:
                $label = 'Tidak Mandiri';
                break;
        }

        return $label;
    }
}

if (!function_exists('alasanRujukLabel')) {
    function alasanRujukLabel($code)
    {
        $label = '-';

        switch ($code) {
            case 1:
                $label = 'Indikasi Medis';
                break;
            case 2:
                $label = 'Kamar Penuh';
                break;
            case 3:
                $label = 'Permintaan Pasien';
                break;
        }

        return $label;
    }
}

if (!function_exists('transportasiRujukLabel')) {
    function transportasiRujukLabel($code)
    {
        $label = '-';

        switch ($code) {
            case 1:
                $label = 'Ambulance';
                break;
            case 2:
                $label = 'Kendaraan Pribadi';
                break;
            case 3:
                $label = 'Lainnya';
                break;
        }

        return $label;
    }
}

if (!function_exists('kategoriAsesmenOKlabel')) {
    function kategoriAsesmenOKlabel($kategori)
    {
        $kategoriLabel = '';

        switch ($kategori) {
            case 1:
                $kategoriLabel = 'Pra Operatif Medis';
                break;
            case 2:
                $kategoriLabel = 'Pra Operatif Perawat';
                break;
            case 3:
                $kategoriLabel = 'Edukasi Anestesi';
                break;
        }

        return $kategoriLabel;
    }
}

// STATISTIK/COUNTER RANAP

if (!function_exists('countAktivePatientRanap')) {
    function countAktivePatientRanap($kd_unit)
    {
        $cacheKey = "count_active_ranap_$kd_unit";

        $result = Cache::remember($cacheKey, 300, function () use ($kd_unit) {

            $count = Kunjungan::join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
                ->join('nginap', function ($q) {
                    $q->on('kunjungan.kd_pasien', '=', 'nginap.kd_pasien');
                    $q->on('kunjungan.kd_unit', '=', 'nginap.kd_unit');
                    $q->on('kunjungan.tgl_masuk', '=', 'nginap.tgl_masuk');
                    $q->on('kunjungan.urut_masuk', '=', 'nginap.urut_masuk');
                })
                ->join('pasien_inap as pi', function ($q) {
                    $q->on('t.kd_kasir', '=', 'pi.kd_kasir');
                    $q->on('t.no_transaksi', '=', 'pi.no_transaksi');
                })
                ->where('nginap.kd_unit_kamar', $kd_unit)
                ->where('nginap.akhir', 1)
                ->where(function ($q) {
                    $q->whereNull('kunjungan.status_inap');
                    $q->orWhere('kunjungan.status_inap', 1);
                })
                ->whereNull('kunjungan.tgl_pulang')
                ->whereNull('kunjungan.jam_pulang')
                ->whereYear('kunjungan.tgl_masuk', '>=', 2025)
                ->count();

            return $count;
        });


        return $result;
    }
}

if (!function_exists('countAktivePatientAllRanap')) {
    function countAktivePatientAllRanap()
    {
        $cacheKey = "count_active_all_ranap";

        $result = Cache::remember($cacheKey, 300, function () {

            $count = Kunjungan::join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
                ->join('unit as u', 'kunjungan.kd_unit', '=', 'u.kd_unit')
                ->join('nginap', function ($q) {
                    $q->on('kunjungan.kd_pasien', '=', 'nginap.kd_pasien');
                    $q->on('kunjungan.kd_unit', '=', 'nginap.kd_unit');
                    $q->on('kunjungan.tgl_masuk', '=', 'nginap.tgl_masuk');
                    $q->on('kunjungan.urut_masuk', '=', 'nginap.urut_masuk');
                })
                ->where(function ($q) {
                    $q->whereNull('kunjungan.status_inap');
                    $q->orWhere('kunjungan.status_inap', 1);
                })
                ->whereNull('kunjungan.tgl_pulang')
                ->whereNull('kunjungan.jam_pulang')
                ->whereYear('kunjungan.tgl_masuk', '>=', 2025)
                ->where('u.kd_bagian', 1)
                ->count();

            return $count;
        });


        return $result;
    }
}

if (!function_exists('countPendingPatientRanap')) {
    function countPendingPatientRanap($kd_unit)
    {

        // $cacheKey = "count_pending_ranap_$kd_unit";

        // $result = Cache::remember($cacheKey, 300, function () use ($kd_unit) {

            $count = RmeSerahTerima::where('kd_unit_tujuan', $kd_unit)
                ->where('status', 1)
                ->count();

            return $count;
        // });

        // return $result;
    }
}

//============================================


// STATISTIK/COUNTER RAJAL

if (!function_exists('countActivePatientAllRajal')) {
    function countActivePatientAllRajal()
    {
        $cacheKey = "count_active_all_rajal";

        $result = Cache::remember($cacheKey, 300, function () {

            $count = Kunjungan::join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
                ->join('unit as u', 'kunjungan.kd_unit', '=', 'u.kd_unit')
                ->where('u.aktif', 1)
                ->where('u.kd_bagian', 2)
                ->whereDate('kunjungan.tgl_masuk', '>=', now()->subDay()->format('Y-m-d'))
                ->whereDate('kunjungan.tgl_masuk', '<=', now()->endOfDay()->format('Y-m-d'))
                ->count();

            return $count;
        });

        return $result;
    }
}

if (!function_exists('countActivePatientRajal')) {
    function countActivePatientRajal($kd_unit)
    {
        $cacheKey = "counter_active_rajal_$kd_unit";

        $result = Cache::remember($cacheKey, 300, function () use ($kd_unit) {

            $count = Kunjungan::join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
                ->where('kunjungan.kd_unit', $kd_unit)
                ->whereDate('kunjungan.tgl_masuk', '>=', now()->subDay()->format('Y-m-d'))
                ->whereDate('kunjungan.tgl_masuk', '<=', now()->endOfDay()->format('Y-m-d'))
                ->count();

            return $count;
        });

        return $result;
    }
}

if (!function_exists('countUnfinishedPatientRajal')) {
    function countUnfinishedPatientRajal($kd_unit)
    {
        $cacheKey = "counter_unfinished_rajal_$kd_unit";

        $result = Cache::remember($cacheKey, 300, function () use ($kd_unit) {

            $count = Kunjungan::join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('t.Dilayani', 0)
                ->whereDate('kunjungan.tgl_masuk', '>=', now()->subDay()->format('Y-m-d'))
                ->whereDate('kunjungan.tgl_masuk', '<=', now()->endOfDay()->format('Y-m-d'))
                ->count();

            return $count;
        });

        return $result;
    }
}

if (!function_exists('countFinishedPatientRajal')) {
    function countFinishedPatientRajal($kd_unit)
    {
        $cacheKey = "counter_finished_rajal_$kd_unit";

        $result = Cache::remember($cacheKey, 300, function () use ($kd_unit) {

            $count = Kunjungan::join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
                ->where('kunjungan.kd_unit', $kd_unit)
                ->where('t.Dilayani', 1)
                ->whereDate('kunjungan.tgl_masuk', '>=', now()->subDay()->format('Y-m-d'))
                ->whereDate('kunjungan.tgl_masuk', '<=', now()->endOfDay()->format('Y-m-d'))
                ->count();

            return $count;
        });

        return $result;
    }
}


//======================================================

// STATISTIK/COUNTER IGD

if (!function_exists('countActivePatientAllIGD')) {
    function countActivePatientAllIGD()
    {
        $tglBatasData = date('Y-m-d', strtotime('-2 days', strtotime(date('Y-m-d'))));

        $result = Kunjungan::join('transaksi as t', function ($join) {
            $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
            $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
            $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
            $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
        })
            ->join('unit as u', 'kunjungan.kd_unit', '=', 'u.kd_unit')
            ->where('t.co_status', 0)
            ->whereNull('kunjungan.tgl_keluar')
            ->whereNull('kunjungan.jam_keluar')
            ->whereDate('kunjungan.tgl_masuk', '>=', $tglBatasData)
            ->where('u.kd_bagian', 3)
            ->count();

        return $result;
    }
}

if (!function_exists('countActivePatientIGD')) {
    function countActivePatientIGD()
    {
        $tglBatasData = date('Y-m-d', strtotime('-2 days', strtotime(date('Y-m-d'))));

        $result = Kunjungan::join('transaksi as t', function ($join) {
            $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
            $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
            $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
            $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
        })
            ->where('kunjungan.kd_unit', 3)
            // ->where('t.Dilayani', 0)
            ->where('t.co_status', 0)
            ->whereNull('kunjungan.tgl_keluar')
            ->whereNull('kunjungan.jam_keluar')
            ->whereDate('kunjungan.tgl_masuk', '>=', $tglBatasData)
            ->count();

        return $result;
    }
}

//======================================================

if (!function_exists('countUnfinishedPatientWithTglKeluar')) {
    function countUnfinishedPatientWithTglKeluar($kd_unit)
    {

        $cacheKey = "count_unfinished_with_outdate_$kd_unit";

        $result = Cache::remember($cacheKey, 300, function () use ($kd_unit) {

            $count = Kunjungan::join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
                ->where('kunjungan.kd_unit', $kd_unit)
                ->whereNull('kunjungan.tgl_keluar')
                ->whereNull('kunjungan.jam_keluar')
                ->whereYear('kunjungan.tgl_masuk', '>=', 2025)
                ->count();

            return $count;
        });

        return $result;
    }
}

if (!function_exists('countPendingOrderHD')) {
    function countPendingOrderHD()
    {
        $result = OrderHD::where('status', 0)->count();
        return $result;
    }
}

if (!function_exists('countPendingOrderRehabMedik')) {
    function countPendingOrderRehabMedik()
    {
        $result = OrderRehabMedik::where('status', 0)->count();
        return $result;
    }
}

if (!function_exists('hitungUmur')) {
    function hitungUmur($tanggalLahir)
    {
        // Mengkonversi tanggal lahir menjadi objek DateTime
        $lahir = new DateTime($tanggalLahir);

        // Mendapatkan tanggal hari ini
        $sekarang = new DateTime('now');

        // Menghitung selisih antara tanggal lahir dan tanggal sekarang
        $selisih = $sekarang->diff($lahir);

        // Mengembalikan umur dalam tahun
        return $selisih->y;
    }
}

if (!function_exists('carbon_parse')) {
    /**
     * Parse a date/time into a Carbon instance or formatted string.
     *
     * Usage:
     *  - carbon_parse('2025-10-22') -> Carbon instance
     *  - carbon_parse(null) -> Carbon::now()
     *  - carbon_parse('2025-10-22', 'Asia/Jakarta', 'd-m-Y') -> formatted string
     *
     * @param mixed $value
     * @param string|null $tz
     * @param string|null $format
     * @return \Carbon\Carbon|string|null
     */
    function carbon_parse($value = null, $tz = null, $format = null)
    {
        try {
            if (is_null($value)) {
                $dt = Carbon::now($tz ?? config('app.timezone'));
            } else {
                $dt = Carbon::parse($value, $tz ?? config('app.timezone'));
            }

            if ($format) {
                return $dt->format($format);
            }

            return $dt;
        } catch (\Throwable $e) {
            // Return null on parse failure to avoid breaking callers; caller can handle null.
            return null;
        }
    }
}


/*============================================*/
        /* QR CODE GENERATE HELPER */
/*============================================*/

if(!function_exists('generateQrCode')) {
    function generateQrCode($text, $size = 100, $type = 'text')
    {
        $qrCode = null;

        if($type == 'text') $qrCode = base64_encode(QrCode::format('png')->size($size)->errorCorrection('H')->generate($text));

        return $qrCode;
    }
}