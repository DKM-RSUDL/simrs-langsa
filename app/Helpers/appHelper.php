<?php

use App\Models\Kunjungan;
use App\Models\Navigation;
use App\Models\Role;

if (!function_exists('getMenus')) {
    function getMenus()
    {
        return Navigation::with('subMenus')->orderBy('sort', 'asc')->get();
    }
}

if (!function_exists('getParentMenus')) {
    function getParentMenus($url)
    {
        $menu = Navigation::where('url', $url)->first();
        if ($menu) {
            $parentMenu = Navigation::select('name')->where('id', $menu->main_menu)->first();
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
    function getKategoriAsesmen($kategori, $subKategori)
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
    function tindakLanjutLabel($tlCode)
    {
        $label = '-';

        switch ($tlCode) {
            case 1:
                $label = 'Rawat Inap';
                break;
            case 2:
                $label = 'Kontrol Ulang';
                break;
            case 3:
                $label = 'Selesai di Unit';
                break;
            case 4:
                $label = 'Rujuk Internal';
                break;
            case 5:
                $label = 'Rujuk RS Lain';
                break;
            case 6:
                $label = 'Pulang';
                break;
            case 7:
                $label = 'Kamar Operasi';
                break;
            case 8:
                $label = 'Berobat Jalan Ke Poli';
                break;
            case 9:
                $label = 'Menolak Rawat Inap';
                break;
            case 10:
                $label = 'Meninggal Dunia';
                break;
            case 11:
                $label = 'Doa (Death On Arrive)';
                break;
        }


        return $label;
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

if (!function_exists('countAktivePatientRanap')) {
    function countAktivePatientRanap($kd_unit)
    {
        $result = Kunjungan::join('transaksi as t', function ($join) {
            $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
            $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
            $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
            $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
        })
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where(function ($q) {
                $q->whereNull('kunjungan.status_inap');
                $q->orWhere('kunjungan.status_inap', 1);
            })
            ->whereNull('kunjungan.tgl_pulang')
            ->whereNull('kunjungan.jam_pulang')
            ->whereYear('kunjungan.tgl_masuk', '>=', 2024)
            ->count();


        return $result;
    }
}

if (!function_exists('countAktivePatientAllRanap')) {
    function countAktivePatientAllRanap()
    {
        $result = Kunjungan::join('transaksi as t', function ($join) {
            $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
            $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
            $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
            $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
        })
        ->join('unit as u', 'kunjungan.kd_unit', '=', 'u.kd_unit')
            ->where(function ($q) {
                $q->whereNull('kunjungan.status_inap');
                $q->orWhere('kunjungan.status_inap', 1);
            })
            ->whereNull('kunjungan.tgl_pulang')
            ->whereNull('kunjungan.jam_pulang')
            ->whereYear('kunjungan.tgl_masuk', '>=', 2024)
            ->where('u.kd_bagian', 1) 
            ->count();


        return $result;
    }
}

if (!function_exists('countActivePatientAllRajal')) {
    function countActivePatientAllRajal()
    {
        $result = Kunjungan::join('transaksi as t', function ($join) {
            $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
            $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
            $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
            $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
        })
            ->join('unit as u', 'kunjungan.kd_unit', '=', 'u.kd_unit')
            ->whereDate('kunjungan.tgl_masuk', date('Y-m-d'))
            ->where('u.aktif', 1)
            ->where('u.kd_bagian', 2) 
            ->count();

        return $result;
    }
}

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

if (!function_exists('countPendingPatientRanap')) {
    function countPendingPatientRanap($kd_unit)
    {
        $result = Kunjungan::join('transaksi as t', function ($join) {
            $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
            $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
            $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
            $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
        })
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.status_inap', 0)
            ->count();

        return $result;
    }
}

if (!function_exists('countActivePatientRajal')) {
    function countActivePatientRajal($kd_unit)
    {
        $result = Kunjungan::join('transaksi as t', function ($join) {
            $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
            $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
            $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
            $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
        })
            ->where('kunjungan.kd_unit', $kd_unit)
            ->count();

        return $result;
    }
}

if (!function_exists('countUnfinishedPatientRajal')) {
    function countUnfinishedPatientRajal($kd_unit)
    {
        $result = Kunjungan::join('transaksi as t', function ($join) {
            $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
            $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
            $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
            $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
        })
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('t.Dilayani', 0)
            ->whereYear('kunjungan.tgl_masuk', '>=', 2024)
            ->count();

        return $result;
    }
}

if (!function_exists('countFinishedPatientRajal')) {
    function countFinishedPatientRajal($kd_unit)
    {
        $result = Kunjungan::join('transaksi as t', function ($join) {
            $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
            $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
            $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
            $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
        })
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('t.Dilayani', 1)
            ->count();

        return $result;
    }
}

if (!function_exists('countUnfinishedPatientWithTglKeluar')) {
    function countUnfinishedPatientWithTglKeluar($kd_unit)
    {
        $result = Kunjungan::join('transaksi as t', function ($join) {
            $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
            $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
            $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
            $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
        })
            ->where('kunjungan.kd_unit', $kd_unit)
            ->whereNull('kunjungan.tgl_keluar')
            ->whereNull('kunjungan.jam_keluar')
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
