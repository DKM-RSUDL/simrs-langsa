@php
    $currentUrl = url()->current();

    $tglMasukData = date('Y-m-d', strtotime($dataMedis->tgl_masuk));

    $navItems = [
        [
            'icon' => 'verified_badge.png',
            'label' => 'Terapi',
            'link' => route('rehab-medis.pelayanan.terapi', [
                'kd_pasien' => $dataMedis->kd_pasien,
                'tgl_masuk' => $tglMasukData,
                'urut_masuk' => $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'tools.png',
            'label' => 'KFR/Asesmen',
            'link' => route('rehab-medis.pelayanan.tindakan.index', [
                'kd_pasien' => $dataMedis->kd_pasien,
                'tgl_masuk' => $tglMasukData,
                'urut_masuk' => $dataMedis->urut_masuk,
            ]),
        ],
    ];
@endphp

<x-navigation-action :nav-items="$navItems" :current-url="$currentUrl" :data-medis="$dataMedis" />
