{{-- @push('css')
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
@endpush --}}

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
        // [
        //     'icon' => 'test_tube.png',
        //     'label' => 'Labor',
        //     'link' => '#',
        // ],
        // [
        //     'icon' => 'microbeam_radiation_therapy.png',
        //     'label' => 'Radiologi',
        //     'link' => '#',
        // ],
        // [
        //     'icon' => 'pill.png',
        //     'label' => 'Farmasi',
        //     'link' => '#',
        // ],
        // [
        //     'icon' => 'goal.png',
        //     'label' => 'Care Plan',
        //     'link' => '#',
        // ],
        // [
        //     'icon' => 'cv.png',
        //     'label' => 'Resume',
        //     'link' => '#',
        // ],
    ];
@endphp

<div class="card" style="height: fit-content; margin-bottom:10px !important;">
    <div class="card-body p-2">
        <div class="d-flex flex-wrap gap-2">
            @foreach ($navItems as $item)
                <a href="{{ $item['link'] }}"
                    class="btn {{ $currentUrl === $item['link'] ? 'btn-primary' : 'btn-light' }} d-flex align-items-center"
                    style="border-radius: 20px; padding: 6px 12px; font-size: 14px;">
                    <img src="{{ asset('assets/img/icons/' . $item['icon']) }}" alt="{{ $item['label'] }}" width="18"
                        height="18" class="{{ $currentUrl === $item['link'] ? '' : '' }} me-1">
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

{{-- <div class="header-background">
    <div class="nav-icons shadow-sm">
        @foreach ($navItems as $item)
            <a href="{{ $item['link'] }}" class="nav-item {{ $currentUrl === $item['link'] ? 'active' : '' }}">
                <img id="image" src="{{ asset('assets/img/icons/' . $item['icon']) }}" alt="{{ $item['label'] }} Icon"
                    width="20">
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</div> --}}
