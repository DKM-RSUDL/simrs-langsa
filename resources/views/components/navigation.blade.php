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
            'icon' => 'verified_badge.png',
            'label' => 'Asesmen',
            'link' => route('asesmen.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        ],
        // [
        //     'icon' => 'positive_dynamic.png',
        //     'label' => 'CPPT',
        //     'link' => route('cppt.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        // ],
        [
            'icon' => 'tools.png',
            'label' => 'Tindakan',
            'link' => route('tindakan.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        ],
        [
            'icon' => 'agree.png',
            'label' => 'Konsultasi',
            'link' => route('konsultasi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
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
            'link' => route('edukasi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        [
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
            'icon' => 'observasi.png',
            'label' => 'EWS',
            'link' => route('ews-pasien-dewasa.index', [$dataMedis->pasien->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        [
            'icon' => 'cv.png',
            'label' => 'Resume',
            'link' => route('resume.index', [$dataMedis->pasien->kd_pasien, $tglMasukData]),
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Resiko Jatuh',
            'link' => route('resiko-jatuh.morse.index', [$dataMedis->pasien->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Status Nyeri',
            'link' => route('status-nyeri.skala-numerik.index', [$dataMedis->pasien->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Decubitus',
            'link' => route('resiko-decubitus.index', [$dataMedis->pasien->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Status Fungsional',
            'link' => route('status-fungsional.index', [$dataMedis->pasien->kd_pasien, $tglMasukData, $dataMedis->urut_masuk]),
        ],
    ];
@endphp

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
