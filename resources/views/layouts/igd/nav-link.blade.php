@php
    // Array that stores the navigation data
    $navItems = [
        ['icon' => 'verified_badge.png', 'label' => 'Asesmen', 'link' => route('medis-gawat-darurat.asesmen', $dataMedis->pasien->kd_pasien)],
        ['icon' => 'positive_dynamic.png', 'label' => 'CPPT', 'link' => '#'],
        ['icon' => 'tools.png', 'label' => 'Tindakan', 'link' => '#'],
        ['icon' => 'agree.png', 'label' => 'Konsultasi', 'link' => '#'],
        ['icon' => 'test_tube.png', 'label' => 'Labor', 'link' => '#'],
        ['icon' => 'microbeam_radiation_therapy.png', 'label' => 'Radiologi', 'link' => '#'],
        ['icon' => 'pill.png', 'label' => 'Farmasi', 'link' => '#'],
        ['icon' => 'info.png', 'label' => 'Edukasi', 'link' => '#'],
        ['icon' => 'goal.png', 'label' => 'Care Plan', 'link' => '#'],
        ['icon' => 'cv.png', 'label' => 'Resume', 'link' => '#'],
    ];
@endphp

@foreach ($navItems as $item)
    <a href="{{ $item['link'] }}">
        <img src="{{ asset('assets/img/icons/' . $item['icon']) }}" alt="{{ $item['label'] }} Icon" width="25">
        <span>{{ $item['label'] }}</span>
    </a>
@endforeach
