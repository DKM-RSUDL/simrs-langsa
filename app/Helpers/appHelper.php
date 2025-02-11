<?php

use App\Models\Navigation;
use App\Models\Role;

if (!function_exists('getMenus')) {
    function getMenus()
    {
        return Navigation::with('subMenus')->orderBy('sort', 'desc')->get();
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
        return Role::where('name', '!=', 'admin')->get();
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
