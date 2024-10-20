@php
    // Prepare navigation items
    $tglMasukData = date('Y-m-d', strtotime($dataMedis->tgl_masuk));

    $navItems = [
        [
            'icon' => 'verified_badge.png',
            'label' => 'Asesmen',
            'link' => '#',
        ],
        [
            'icon' => 'positive_dynamic.png',
            'label' => 'CPPT',
            'link' => route('rawat-inap.cppt.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        [
            'icon' => 'tools.png',
            'label' => 'Tindakan',
            'link' => '#',
        ],
        [
            'icon' => 'agree.png',
            'label' => 'Konsultasi',
            'link' => '#',
        ],
        [
            'icon' => 'test_tube.png',
            'label' => 'Labor',
            'link' => route('rawat-inap.lab-patologi-klinik.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        [
            'icon' => 'microbeam_radiation_therapy.png',
            'label' => 'Radiologi',
            'link' => route('rawat-inap.radiologi.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        [
            'icon' => 'pill.png',
            'label' => 'Farmasi',
            'link' => route('rawat-inap.farmasi.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        [
            'icon' => 'info.png',
            'label' => 'Edukasi',
            'link' => '#',
        ],
        [
            'icon' => 'goal.png',
            'label' => 'Care Plan',
            'link' => '#',
        ],
        [
            'icon' => 'cv.png',
            'label' => 'Resume',
            'link' => '#',
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
