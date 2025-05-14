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

    // Prepare navigation items
    $tglMasukData = date('Y-m-d', strtotime($dataMedis->tgl_masuk));

    $navItems = [
        [
            'icon' => 'verified_badge.png',
            'label' => 'Asesmen',
            'link' => route('rawat-inap.asesmen.medis.umum.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'positive_dynamic.png',
            'label' => 'CPPT',
            'link' => route('rawat-inap.cppt.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'tools.png',
            'label' => 'Tindakan',
            'link' => route('rawat-inap.tindakan.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'agree.png',
            'label' => 'Konsultasi',
            'link' => route('rawat-inap.konsultasi.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'test_tube.png',
            'label' => 'Labor',
            'link' => route('rawat-inap.lab-patologi-klinik.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'microbeam_radiation_therapy.png',
            'label' => 'Radiologi',
            'link' => route('rawat-inap.radiologi.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'pill.png',
            'label' => 'Farmasi',
            'link' => route('rawat-inap.farmasi.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'info.png',
            'label' => 'Edukasi',
            'link' => route('rawat-inap.edukasi.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'info.png',
            'label' => 'Intake Cairan',
            'link' => route('rawat-inap.intake-cairan.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'observasi.png',
            'label' => 'Observasi',
            'link' => route('rawat-inap.observasi.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],[
            'icon' => 'observasi.png',
            'label' => 'Pengawasan',
            'link' => route('rawat-inap.pengawasan.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'goal.png',
            'label' => 'Care Plan',
            'link' => '#',
        ],
        [
            'icon' => 'cv.png',
            'label' => 'Resume',
            'link' => route('rawat-inap.rawat-inap-resume.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
    ];

    if (in_array($dataMedis->kd_unit, ['10015', '10016', '10131', '10132'])) {
        $navItems[] = [
            'icon' => 'monitoring.png',
            'label' => 'Monitoring ' . $dataMedis->unit->nama_unit,
            'link' => route('rawat-inap.monitoring.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ];

        $navItems[] = [
            'icon' => 'monitoring.png',
            'label' => 'K. Istimewa',
            'link' => route('rawat-inap.kontrol-istimewa.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ];
    }

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
            <a href="{{ $item['link'] }}">
                <img src="{{ asset('assets/img/icons/' . $item['icon']) }}" alt="{{ $item['label'] }} Icon" width="25">
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</div> --}}
