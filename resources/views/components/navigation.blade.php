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
            'link' => route('cppt.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
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
            'link' => route('labor.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        ],
        [
            'icon' => 'microbeam_radiation_therapy.png',
            'label' => 'Radiologi',
            'link' => route('radiologi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        ],
        [
            'icon' => 'pill.png',
            'label' => 'Farmasi',
            'link' => route('farmasi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
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
            'link' => route('resume.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
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
