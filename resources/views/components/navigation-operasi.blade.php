@push('css')
    <style>
        .nav-icons {
            display: flex;
            gap: 5px;
            padding: 5px;
            background: white;
        }

        .nav-icons .nav-item {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 2px 2px;
            text-decoration: none;
            color: #ffffff;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .nav-icons .nav-item:hover {
            background-color: #e9ecef;
        }

        .nav-icons .nav-item.active {
            background-color: #0d6efd;
        }

        .nav-icons .nav-item.active span {
            color: white;
        }

        .nav-icons .nav-item.active img {
            filter: none;
        }
    </style>
@endpush

@php
    $currentUrl = url()->current();

    $tglMasukData = date('Y-m-d', strtotime($dataMedis->tgl_masuk));

    $navItems = [
        [
            'icon' => 'check.svg',
            'label' => 'Asesmen',
            'link' => route('operasi.pelayanan.asesmen.index', [$dataMedis->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        [
            'icon' => 'check.svg',
            'label' => 'Site Marking',
            'link' => '#',
        ],
        [
            'icon' => 'check.svg',
            'label' => 'Cek List Keselamatan',
            'link' => '#',
        ],
        [
            'icon' => 'check.svg',
            'label' => 'Laporan Operatif',
            'link' => '#',
        ],
        [
            'icon' => 'check.svg',
            'label' => 'Laporan Anestesi',
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
            'link' => '#',
        ],
        [
            'icon' => 'microbeam_radiation_therapy.png',
            'label' => 'Radiologi',
            'link' => '#',
        ],
        [
            'icon' => 'pill.png',
            'label' => 'Farmasi',
            'link' => '#',
        ],
    ];
@endphp

<div class="header-background">
    <div class="nav-icons shadow-sm">
        @foreach ($navItems as $item)
            <a href="{{ $item['link'] }}" class="nav-item {{ $currentUrl === $item['link'] ? 'active' : '' }}">
                <img id="image" src="{{ asset('assets/img/icons/' . $item['icon']) }}" alt="{{ $item['label'] }} Icon"
                    width="20">
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</div>
