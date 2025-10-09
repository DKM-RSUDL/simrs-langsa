@php
    $currentUrl = url()->current();

    $tglMasukData = date('Y-m-d', strtotime($dataMedis->tgl_masuk));

    $navItems = [
        [
            'validate' => false,
            'icon' => 'verified_badge.png',
            'label' => 'Asesmen',
            'link' => route('asesmen.index', [$dataMedis->pasien->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            // 'link' => route('asesmen.index', [$dataMedis->pasien->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        // [
        //     'icon' => 'positive_dynamic.png',
        //     'label' => 'CPPT',
        //     'link' => route('cppt.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        // ],
        [
            'validate' => false,
            'icon' => 'tools.png',
            'label' => 'Tindakan',
            'link' => route('tindakan.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        ],
        [
            'validate' => false,
            'icon' => 'agree.png',
            'label' => 'Konsultasi',
            'link' => route('konsultasi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        [
            'validate' => false,
            'icon' => 'test_tube.png',
            'label' => 'Labor',
            'link' => route('labor.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        ],
        [
            'validate' => false,
            'icon' => 'microbeam_radiation_therapy.png',
            'label' => 'Radiologi',
            'link' => route('radiologi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        ],
        [
            'validate' => false,
            'icon' => 'pill.png',
            'label' => 'Farmasi',
            'link' => route('farmasi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        ],
        [
            'validate' => true,
            'icon' => 'info.png',
            'label' => 'Edukasi',
            'link' => route('edukasi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        [
            'validate' => true,
            'icon' => 'info.png',
            'label' => 'MPP',
            'link' => route('mpp.form-a.index', [$dataMedis->pasien->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        // [
        //     'icon' => 'goal.png',
        //     'label' => 'Care Plan',
        //     'link' => route('careplan.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        // ],
        [
            'validate' => true,
            'icon' => 'observasi.png',
            'label' => 'EWS',
            'link' => route('ews-pasien-dewasa.index', [
                $dataMedis->pasien->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'validate' => false,
            'icon' => 'cv.png',
            'label' => 'Resume',
            'link' => route('resume.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        ],
        [
            'validate' => true,
            'icon' => 'verified_badge.png',
            'label' => 'Resiko Jatuh',
            'link' => route('resiko-jatuh.morse.index', [
                $dataMedis->pasien->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'validate' => true,
            'icon' => 'verified_badge.png',
            'label' => 'Status Nyeri',
            'link' => route('status-nyeri.skala-numerik.index', [
                $dataMedis->pasien->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'validate' => true,
            'icon' => 'verified_badge.png',
            'label' => 'Decubitus',
            'link' => route('resiko-decubitus.index', [
                $dataMedis->pasien->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'validate' => true,
            'icon' => 'verified_badge.png',
            'label' => 'Status Fungsional',
            'link' => route('status-fungsional.index', [
                $dataMedis->pasien->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'validate' => true,
            'icon' => 'verified_badge.png',
            'label' => 'Echocardiography',
            'link' => route('echocardiography.index', [
                $dataMedis->pasien->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'validate' => true,
            'icon' => 'verified_badge.png',
            'label' => 'Audiometri',
            'link' => route('audiometri.index', [$dataMedis->pasien->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
    ];
@endphp

<x-navigation-action :nav-items="$navItems" :current-url="$currentUrl" :data-medis="$dataMedis" />
