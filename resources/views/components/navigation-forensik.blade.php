@php
    $currentUrl = url()->current();

    // Prepare navigation items
    $tglMasukData = date('Y-m-d', strtotime($dataMedis->tgl_masuk));

    $jenisPemeriksaan = 'pemeriksaan-';
    if ($dataMedis->kd_unit == 228) {
        $jenisPemeriksaan .= 'klinik';
    }

    if ($dataMedis->kd_unit == 76) {
        $jenisPemeriksaan .= 'patologi';
    }

    $navItems = [
        [
            'icon' => 'verified_badge.png',
            'label' => 'Asesmen',
            'link' => route("forensik.unit.pelayanan.$jenisPemeriksaan.index", [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Visum Exit',
            'link' => route('forensik.unit.pelayanan.visum-exit.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Visum Otopsi',
            'link' => route('forensik.unit.pelayanan.visum-otopsi.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
    ];

@endphp

{{-- <div class="header-background">
    <div class="nav-icons">
        @foreach ($navItems as $item)
            <a href="{{ $item['link'] }}" class="nav-item {{ $currentUrl === $item['link'] ? 'active' : '' }}">
                <img id="image" src="{{ asset('assets/img/icons/' . $item['icon']) }}" alt="{{ $item['label'] }} Icon"
                    width="20">
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</div> --}}

<x-navigation-action :nav-items="$navItems" :current-url="$currentUrl" :data-medis="$dataMedis" />

