@php
    $currentUrl = url()->current();
    $tglMasukData = date('Y-m-d', strtotime($dataMedis->tgl_masuk));

    $navItems = [
        [
            'icon' => 'verified_badge.png',
            'label' => 'Asesmen',
            'link' => route('rawat-jalan.asesmen.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'positive_dynamic.png',
            'label' => 'CPPT',
            'link' => route('rawat-jalan.cppt.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.cppt',
        ],
        [
            'icon' => 'tools.png',
            'label' => 'Tindakan',
            'link' => route('rawat-jalan.tindakan.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.tindakan',
        ],
        [
            'icon' => 'agree.png',
            'label' => 'Konsultasi',
            'link' => route('rawat-jalan.konsultasi.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.konsultasi',
        ],
        [
            'icon' => 'test_tube.png',
            'label' => 'Labor',
            'link' => route('rawat-jalan.lab-patologi-klinik.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.lab-patologi-klinik',
        ],
        [
            'icon' => 'microbeam_radiation_therapy.png',
            'label' => 'Radiologi',
            'link' => route('rawat-jalan.radiologi.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.radiologi',
        ],
        [
            'icon' => 'pill.png',
            'label' => 'Farmasi',
            'link' => route('rawat-jalan.farmasi.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.farmasi',
        ],
        [
            'icon' => 'info.png',
            'label' => 'Edukasi',
            'link' => route('rawat-jalan.edukasi.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.edukasi',
        ],
        [
            'icon' => 'goal.png',
            'label' => 'Care Plan',
            'link' => '#',
        ],
        [
            'icon' => 'cv.png',
            'label' => 'Resume',
            'link' => route('rawat-jalan.rawat-jalan-resume.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.rawat-jalan-resume',
        ],
        [
            'icon' => 'cv.png',
            'label' => 'PRMRJ',
            'link' => route('rawat-jalan.prmrj.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.prmrj',
        ],
        [
            'icon' => 'cv.png',
            'label' => 'Konseling HIV',
            'link' => route('rawat-jalan.konseling-hiv.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.konseling-hiv',
        ],
        [
            'icon' => 'info.png',
            'label' => 'HIV ART',
            'link' => route('rawat-jalan.hiv_art.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.hiv_art',
        ],
        [
            'icon' => 'info.png',
            'label' => 'Gizi',
            'link' => route('rawat-jalan.gizi.anak.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.gizi.anak',
        ],
        [
            'icon' => 'observasi.png',
            'label' => 'EWS',
            'link' => route('rawat-jalan.ews-pasien-dewasa.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.ews-pasien-dewasa',
        ],
        [
            'icon' => 'agree.png',
            'label' => 'Catatan Poliklinik',
            'link' => route('rawat-jalan.catatan-poliklinik.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.catatan-poliklinik',
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'MPP',
            'link' => route('rawat-jalan.mpp.form-a.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.mpp.form-a',
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Resiko Jatuh',
            'link' => route('rawat-jalan.resiko-jatuh.morse.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.resiko-jatuh.morse',
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Status Fungsional',
            'link' => route('rawat-jalan.status-fungsional.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.status-fungsional',
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Status Nyeri',
            'link' => route('rawat-jalan.status-nyeri.skala-numerik.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.status-nyeri.skala-numerik',
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Resiko Decubitus',
            'link' => route('rawat-jalan.resiko-decubitus.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.resiko-decubitus',
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Echocardiography',
            'link' => route('rawat-jalan.echocardiography.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.echocardiography',
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Audiometri',
            'link' => route('rawat-jalan.audiometri.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.audiometri',
        ],
        [
            'icon' => 'tools.png',
            'label' => 'L. Rehab Medik',
            'link' => route('rawat-jalan.layanan-rehab-medik.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.layanan-rehab-medik',
        ],
        [
            'icon' => 'tools.png',
            'label' => 'KFR Rehab Medik',
            'link' => route('rawat-jalan.tindakan-rehab-medik.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
            'route-name' => 'rawat-jalan.tindakan-rehab-medik',
        ],
    ];
@endphp

<x-navigation-action :nav-items="$navItems" :current-url="$currentUrl" :data-medis="$dataMedis" />
