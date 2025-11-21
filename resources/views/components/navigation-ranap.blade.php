@php
    $currentUrl = url()->current();

    // Prepare navigation items
    $tglMasukData = date('Y-m-d', strtotime($dataMedis->tgl_masuk));

    $navItems = [
          [
            'validate' => false,
            'icon' => 'tools.png',
            'label' => 'Triase',
            'link' => route('rawat-inap.triase.show', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
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
            'label' => 'Konsultasi Rajal',
            'link' => route('rawat-inap.konsultasi.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
            'active' => 'rawat-inap.konsultasi.*',
        ],

        [
            'icon' => 'agree.png',
            'label' => 'Konsultasi Spesialis',
            'link' => route('rawat-inap.konsultasi-spesialis.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
            'active' => 'rawat-inap.konsultasi-spesialis.*',
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
            'icon' => 'info.png',
            'label' => 'Gizi',
            'link' => route('rawat-inap.gizi.anak.index', [
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
        ],
        [
            'icon' => 'observasi.png',
            'label' => 'Pengawasan',
            'link' => route('rawat-inap.pengawasan-perinatology.index', [
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
            'icon' => 'observasi.png',
            'label' => 'EWS',
            'link' => route('rawat-inap.ews-pasien-dewasa.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'MPP',
            'link' => route('rawat-inap.mpp.form-a.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Pra Anestesi',
            'link' => route('rawat-inap.asesmen-pra-anestesi.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Resiko Jatuh',
            'link' => route('rawat-inap.resiko-jatuh.morse.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Status Nyeri',
            'link' => route('rawat-inap.status-nyeri.skala-numerik.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Decubitus',
            'link' => route('rawat-inap.resiko-decubitus.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Status Fungsional',
            'link' => route('rawat-inap.status-fungsional.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Surveilans PPI',
            'link' => route('rawat-inap.surveilans-ppi.a1.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Pneumonia',
            'link' => route('rawat-inap.pneumonia.psi.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Echocardiography',
            'link' => route('rawat-inap.echocardiography.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Audiometri',
            'link' => route('rawat-inap.audiometri.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
        ],
        [
            'icon' => 'monitoring.png',
            'label' => 'K. Istimewa',
            'link' => route('rawat-inap.kontrol-istimewa.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
],
        [
            'icon' => 'verified_badge.png',
            'label' => 'Implementasi Askep',
            'link' => route('rawat-inap.asuhan-keperawatan.index', [
                $dataMedis->kd_unit,
                $dataMedis->kd_pasien,
                $tglMasukData,
                $dataMedis->urut_masuk,
            ]),
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

        // $navItems[] = [
        //     'icon' => 'monitoring.png',
        //     'label' => 'K. Istimewa',
        //     'link' => route('rawat-inap.kontrol-istimewa.index', [
        //         $dataMedis->kd_unit,
        //         $dataMedis->kd_pasien,
        //         $tglMasukData,
        //         $dataMedis->urut_masuk,
        //     ]),
        // ];

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
