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
            border: 1px solid #cecece;
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
            'icon' => 'verified_badge.png',
            'label' => 'Pelayanan',
            'link' => route('rehab-medis.pelayanan.layanan', [
                'kd_pasien' => $dataMedis->kd_pasien,
                'tgl_masuk' => $tglMasukData,
                'urut_masuk' => $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'tools.png',
            'label' => 'Tindakan',
            'link' => route('rehab-medis.pelayanan.tindakan.index', [
                'kd_pasien' => $dataMedis->kd_pasien,
                'tgl_masuk' => $tglMasukData,
                'urut_masuk' => $dataMedis->urut_masuk,
            ]),
        ],
    ];
@endphp

<div class="header-background">
    <div class="card" style="height: auto;">
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                @foreach ($navItems as $item)
                    <a href="{{ $item['link'] }}"
                        class="btn {{ $currentUrl === $item['link'] ? 'btn-primary' : 'btn-light' }} d-flex align-items-center"
                        style="font-size: 14px;">
                        <img src="{{ asset('assets/img/icons/' . $item['icon']) }}" alt="{{ $item['label'] }} Icon"
                            width="20" class="me-1">
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
