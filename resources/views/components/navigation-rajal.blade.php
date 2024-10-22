@php
    // Prepare navigation items
    $tglMasukData = date('Y-m-d', strtotime($dataMedis->tgl_masuk));

    $navItems = [
        [
            'icon' => 'verified_badge.png',
            'label' => 'Asesmen',
            'link' => route('asesmen.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        ],
        [
            'icon' => 'positive_dynamic.png',
            'label' => 'CPPT',
            'link' => route('rawat-jalan.cppt.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        [
            'icon' => 'tools.png',
            'label' => 'Tindakan',
            'link' => route('tindakan.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        ],
        [
            'icon' => 'agree.png',
            'label' => 'Konsultasi',
            'link' => route('konsultasi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        ],
        [
            'icon' => 'test_tube.png',
            'label' => 'Labor',
            'link' => route('rawat-jalan.lab-patologi-klinik.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        [
            'icon' => 'microbeam_radiation_therapy.png',
            'label' => 'Radiologi',
            'link' => route('rawat-jalan.radiologi.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        [
            'icon' => 'pill.png',
            'label' => 'Farmasi',
            'link' => route('rawat-jalan.farmasi.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        [
            'icon' => 'info.png',
            'label' => 'Edukasi',
            'link' => route('edukasi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        ],
        [
            'icon' => 'goal.png',
            'label' => 'Care Plan',
            'link' => route('careplan.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        ],
        [
            'icon' => 'cv.png',
            'label' => 'Resume',
            'link' => route('rawat-jalan.rawat-jalan-resume.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
    ];

@endphp

<div class="header-background">
    <div class="nav-icons shadow-sm">
        @foreach ($navItems as $item)
            <a href="{{ $item['link'] }}">
                <img src="{{ asset('assets/img/icons/' . $item['icon']) }}" alt="{{ $item['label'] }} Icon" width="25">
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</div>
