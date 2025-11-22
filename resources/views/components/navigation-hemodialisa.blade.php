@php
    $currentUrl = url()->current();

    $tglMasukData = date('Y-m-d', strtotime($dataMedis->tgl_masuk));

    $navItems = [
        [
            'icon' => 'verified_badge.png',
            'label' => 'Asesmen',
            'link' => route('hemodialisa.pelayanan.asesmen.index', [
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'info.png',
            'label' => 'Data Umum',
            'link' => route('hemodialisa.pelayanan.data-umum.index', [
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'positive_dynamic.png',
            'label' => 'BBK',
            'link' => route('hemodialisa.pelayanan.berat-badan-kering.index', [
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'tools.png',
            'label' => 'Malnutrisi Inflamasi',
            'link' => route('hemodialisa.pelayanan.malnutrition-inflammation-score.index', [
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'info.png',
            'label' => 'Edukasi',
            'link' => route('hemodialisa.pelayanan.edukasi.index', [
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'agree.png',
            'label' => 'Tindakan Khusus',
            'link' => route('hemodialisa.pelayanan.tindakan-khusus.index', [
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'agree.png',
            'label' => 'Hasil EKG',
            'link' => route('hemodialisa.pelayanan.hasil-ekg.index', [
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'agree.png',
            'label' => 'Traveling Dialysis',
            'link' => route('hemodialisa.pelayanan.traveling-dialysis.index', [
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'agree.png',
            'label' => 'Hasil Lab',
            'link' => route('hemodialisa.pelayanan.hasil-lab.index', [
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'agree.png',
            'label' => 'Persetujuan Tindakan',
            'link' => route('hemodialisa.pelayanan.persetujuan.tindakan-hd.index', [
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'check.svg',
            'label' => 'Transfer Pasien',
            'link' => route('hemodialisa.pelayanan.transfer-pasien.index', [
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        // [
        // 'icon' => 'test_tube.png',
        // 'label' => 'Labor',
        // 'link' => '#',
        // ],
        // [
        // 'icon' => 'microbeam_radiation_therapy.png',
        // 'label' => 'Radiologi',
        // 'link' => '#',
        // ],
        // [
        // 'icon' => 'pill.png',
        // 'label' => 'Farmasi',
        // 'link' => '#',
        // ],
        // [
        // 'icon' => 'goal.png',
        // 'label' => 'Care Plan',
        // 'link' => '#',
        // ],
        // [
        // 'icon' => 'cv.png',
        // 'label' => 'Resume',
        // 'link' => '#',
        // ],
    ];
@endphp

<x-navigation-action :nav-items="$navItems" :current-url="$currentUrl" :data-medis="$dataMedis" />
