@php
    $currentUrl = url()->current();

    // Prepare navigation items
    $tglMasukData = date('Y-m-d', strtotime($dataMedis->tgl_masuk));

    $navItems = [
        [
            'icon' => 'tools.png',
            'label' => 'Tindakan Rajal',
            'link' => route('rawat-inap.konsultasi.rincian.tindakan.indexTindakan', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
                $urut_konsul,
            ]),
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Echocardiography Rajal',
            'link' => route('rawat-inap.konsultasi.rincian.echocardiography.indexEchocardiography', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
                $urut_konsul,
            ]),
        ],
    ];

    $kdUnitNow = $dataMedis->kd_unit;
    $namaUnitNow = $dataMedis->unit->nama_unit;

    if ($dataMedis->unit->kd_bagian == 1) {
        $nginap = \App\Models\Nginap::join('unit as u', 'nginap.kd_unit_kamar', '=', 'u.kd_unit')
            ->where('nginap.kd_pasien', $dataMedis->kd_pasien)
            ->where('nginap.kd_unit', $dataMedis->kd_unit)
            ->where('nginap.tgl_masuk', $dataMedis->tgl_masuk)
            ->where('nginap.urut_masuk', $dataMedis->urut_masuk)
            ->where('nginap.akhir', 1)
            ->first();

        if (!empty($nginap)) {
            $kdUnitNow = $nginap->kd_unit_kamar;
            $namaUnitNow = $nginap->nama_unit;
        }
    }

    if (in_array($kdUnitNow, ['10015', '10016', '10131', '10132'])) {
        $navItems[] = [
            'icon' => 'monitoring.png',
            'label' => 'Monitoring ' . $namaUnitNow,
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

        $urlKriteria = '#';

        if ($dataMedis->kd_unit == '10015') {
            $urlKriteria = route('rawat-inap.kriteria-masuk-keluar.iccu.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]);
        }

        if ($dataMedis->kd_unit == '10016') {
            $urlKriteria = route('rawat-inap.kriteria-masuk-keluar.icu.masuk.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]);
        }

        if ($dataMedis->kd_unit == '10132') {
            $urlKriteria = route('rawat-inap.kriteria-masuk-keluar.picu.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]);
        }

        if ($dataMedis->kd_unit == '10131') {
            $urlKriteria = route('rawat-inap.kriteria-masuk-keluar.nicu.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]);
        }

        $navItems[] = [
            'icon' => 'monitoring.png',
            'label' => 'K. Masuk/Keluar',
            'link' => $urlKriteria,
        ];
    }

@endphp

<x-navigation-action :nav-items="$navItems" :current-url="$currentUrl" :data-medis="$dataMedis" />
