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
            'icon' => 'check.svg',
            'label' => 'Asesmen',
            'link' => route('operasi.pelayanan.asesmen.index', [
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'rrrr.png',
            'label' => 'Site Marking',
            'link' => route('operasi.pelayanan.site-marking.index', [
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'ceklis.png',
            'label' => 'Cek List Keselamatan',
            'link' => route('operasi.pelayanan.ceklist-keselamatan.index', [
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'check.svg',
            'label' => 'Laporan Operatif',
            'link' => route('operasi.pelayanan.laporan-operasi.index', [
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'check.svg',
            'label' => 'Laporan Anestesi',
            'link' => route('operasi.pelayanan.laporan-anastesi.index', [
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
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
    <div class="card" style="height: fit-content; margin-bottom:10px !important;">
        <div class="card-body p-2">
            <div class="d-flex flex-wrap gap-2">
                @foreach ($navItems as $item)
                    <a href="{{ $item['link'] }}"
                        class="btn {{ $currentUrl === $item['link'] ? 'btn-primary' : 'btn-light' }} d-flex align-items-center"
                        style="font-size: 14px;">
                        <img src="{{ asset('assets/img/icons/' . $item['icon']) }}" alt="{{ $item['label'] }}"
                            width="18" height="18" class="me-1">
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
