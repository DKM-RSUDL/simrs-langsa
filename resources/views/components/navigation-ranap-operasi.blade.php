@php
    $currentUrl = url()->current();

    $tglMasukData = date('Y-m-d', strtotime($dataMedis->tgl_masuk));

    $navItems = [
        [
            'icon' => 'check.svg',
            'label' => 'Asesmen Pra Operatif Perawat',
            'link' => route('rawat-inap.operasi.asesmen.pra-operatif-perawat.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                $dataMedis->urut_masuk,
                $operasi->tgl_op,
                $operasi->jam_op,
                $tglMasukData,
            ]),
        ],
        [
            'icon' => 'rrrr.png',
            'label' => 'Site Marking',
            'link' => route('operasi.pelayanan.site-marking.index', [
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
    ];
@endphp

<x-navigation-action :nav-items="$navItems" :current-url="$currentUrl" :data-medis="$dataMedis" />
