@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        :root {
            --primary-color: #097dd6;
            --secondary-color: #2c3e50;
            --bg-light: #f8f9fa;
            --border-radius: 8px;
            --transition: all 0.3s ease;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--secondary-color);
            min-width: 180px;
        }

        .header-asesmen {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-color);
            text-align: center;
            margin: 1.5rem 0;
        }

        .section-separator {
            border-top: 3px solid var(--primary-color);
            margin: 2rem 0;
            padding-top: 1.5rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--secondary-color);
            background: var(--bg-light);
            padding: 0.75rem 1rem;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
        }

        .section-title:hover {
            background: #e9ecef;
        }

        .form-group {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
        }

        .form-check {
            padding-left: 2rem;
            transition: var(--transition);
            border-radius: 4px;
        }

        .form-check:hover {
            background-color: #f1f5f9;
        }

        .form-check-input {
            cursor: pointer;
            margin-top: 0.3rem;
        }

        .form-check-label {
            cursor: pointer;
            font-size: 0.95rem;
            margin-left: 0.5rem;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            transition: var(--transition);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .table-edukasi {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        .table-edukasi th,
        .table-edukasi td {
            border: 1px solid #dee2e6;
            padding: 0.75rem;
            font-size: 0.9rem;
            vertical-align: middle;
        }

        .table-edukasi th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            text-align: center;
        }

        .table-edukasi tr:nth-child(even) {
            background-color: var(--bg-light);
        }

        .table-edukasi tr:hover {
            background-color: #e9ecef;
        }

        .form-control-sm {
            height: calc(1.5em + 0.6rem + 2px);
            padding: 0.3rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 6px;
            transition: var(--transition);
        }

        .form-control-sm:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 5px rgba(9, 125, 214, 0.3);
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            padding: 0.5rem;
            border-radius: 6px;
        }

        .hambatan-details {
            display: none;
            margin-top: 0.5rem;
            padding: 1rem;
            background: var(--bg-light);
            border-radius: 6px;
            transition: var(--transition);
        }

        .hambatan-details.show {
            display: block;
        }

        .tooltip-icon {
            color: #6c757d;
            margin-left: 0.5rem;
            cursor: help;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .form-group {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-label {
                min-width: unset;
            }

            .table-edukasi {
                font-size: 0.85rem;
            }

            .table-edukasi th,
            .table-edukasi td {
                padding: 0.5rem;
            }
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-hemodialisa')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form
                action="{{ route('hemodialisa.pelayanan.edukasi.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                method="post">
                @csrf

                <div class="card w-100 shadow-sm">
                    <div class="card-body">
                        <div class="px-4 py-3">
                            <h4 class="header-asesmen">Formulir Edukasi Pasien dan Keluarga Pasien HD</h4>

                            <div class="section-separator">
                                <h5 class="section-title">1. Data Pasien</h5>

                                @php
                                    $tinggalBersamaOptions = [
                                        ['value' => 'Anak', 'label' => 'Anak'],
                                        ['value' => 'Orang Tua', 'label' => 'Orang Tua'],
                                        ['value' => 'Sendiri', 'label' => 'Sendiri'],
                                    ];
                                @endphp
                                <div class="form-group">
                                    <label class="form-label">Tinggal Bersama <i class="fas fa-info-circle tooltip-icon"
                                            data-bs-toggle="tooltip" title="Pilih dengan siapa pasien tinggal"></i></label>
                                    <div class="checkbox-group">
                                        @foreach ($tinggalBersamaOptions as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tinggal_bersama[]"
                                                    value="{{ $option['value'] }}"
                                                    id="tinggal_{{ str_replace(' ', '_', strtolower($option['value'])) }}">
                                                <label class="form-check-label"
                                                    for="tinggal_{{ str_replace(' ', '_', strtolower($option['value'])) }}">{{ $option['label'] }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                @php
                                    $kemampuanBahasaOptions = [
                                        ['value' => 'Indonesia', 'label' => 'Indonesia'],
                                        [
                                            'value' => 'Daerah',
                                            'label' => 'Daerah',
                                            'has_detail' => true,
                                            'detail_name' => 'bahasa_daerah_detail',
                                            'placeholder' => 'Sebutkan',
                                        ],
                                        [
                                            'value' => 'Asing',
                                            'label' => 'Asing',
                                            'has_detail' => true,
                                            'detail_name' => 'bahasa_asing_detail',
                                            'placeholder' => 'Sebutkan',
                                        ],
                                    ];
                                @endphp
                                <div class="form-group">
                                    <label class="form-label">Kemampuan Bahasa <i class="fas fa-info-circle tooltip-icon"
                                            data-bs-toggle="tooltip" title="Pilih bahasa yang dikuasai pasien"></i></label>
                                    <div class="checkbox-group">
                                        @foreach ($kemampuanBahasaOptions as $option)
                                            <div class="form-check">
                                                <input class="form-check-input bahasa-checkbox" type="checkbox"
                                                    name="kemampuan_bahasa[]" value="{{ $option['value'] }}"
                                                    id="bahasa_{{ str_replace(' ', '_', strtolower($option['value'])) }}"
                                                    data-target="{{ isset($option['detail_name']) ? $option['detail_name'] : '' }}">
                                                <label class="form-check-label"
                                                    for="bahasa_{{ str_replace(' ', '_', strtolower($option['value'])) }}">{{ $option['label'] }}</label>
                                                @if (isset($option['has_detail']) && $option['has_detail'])
                                                    <input type="text"
                                                        class="form-control form-control-sm ms-2 detail-input"
                                                        name="{{ $option['detail_name'] }}"
                                                        id="{{ $option['detail_name'] }}"
                                                        placeholder="{{ $option['placeholder'] }}" disabled>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                @php
                                    $perluPenerjemahOptions = [
                                        ['value' => '0', 'label' => 'Tidak'],
                                        ['value' => '1', 'label' => 'Ya'],
                                    ];
                                @endphp
                                <div class="form-group">
                                    <label class="form-label">Perlu Penerjemah <i class="fas fa-info-circle tooltip-icon"
                                            data-bs-toggle="tooltip"
                                            title="Apakah pasien memerlukan penerjemah?"></i></label>
                                    <div class="checkbox-group">
                                        @foreach ($perluPenerjemahOptions as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="perlu_penerjemah"
                                                    value="{{ $option['value'] }}"
                                                    id="penerjemah_{{ strtolower($option['value']) }}">
                                                <label class="form-check-label"
                                                    for="penerjemah_{{ strtolower($option['value']) }}">{{ $option['label'] }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                @php
                                    $bacaTulisOptions = [
                                        ['value' => '1', 'label' => 'Bisa'],
                                        ['value' => '0', 'label' => 'Tidak'],
                                    ];
                                @endphp
                                <div class="form-group">
                                    <label class="form-label">Baca Tulis <i class="fas fa-info-circle tooltip-icon"
                                            data-bs-toggle="tooltip"
                                            title="Apakah pasien dapat membaca dan menulis?"></i></label>
                                    <div class="checkbox-group">
                                        @foreach ($bacaTulisOptions as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="baca_tulis"
                                                    value="{{ $option['value'] }}"
                                                    id="baca_tulis_{{ strtolower($option['value']) }}">
                                                <label class="form-check-label"
                                                    for="baca_tulis_{{ strtolower($option['value']) }}">{{ $option['label'] }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                @php
                                    $caraEdukasiOptions = [
                                        ['value' => 'Lisan', 'label' => 'Lisan'],
                                        ['value' => 'Tulisan', 'label' => 'Tulisan'],
                                        ['value' => 'Brosur/leaflet', 'label' => 'Brosur/leaflet'],
                                        ['value' => 'Audiovisual', 'label' => 'Audiovisual'],
                                    ];
                                @endphp
                                <div class="form-group">
                                    <label class="form-label">Cara Edukasi <i class="fas fa-info-circle tooltip-icon"
                                            data-bs-toggle="tooltip"
                                            title="Pilih metode edukasi yang digunakan"></i></label>
                                    <div class="checkbox-group">
                                        @foreach ($caraEdukasiOptions as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="cara_edukasi[]"
                                                    value="{{ $option['value'] }}"
                                                    id="cara_{{ str_replace('/', '_', strtolower($option['value'])) }}">
                                                <label class="form-check-label"
                                                    for="cara_{{ str_replace('/', '_', strtolower($option['value'])) }}">{{ $option['label'] }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                @php
                                    $hambatanStatusOptions = [
                                        ['value' => '1', 'label' => 'Ada'],
                                        ['value' => '0', 'label' => 'Tidak', 'checked' => true],
                                    ];
                                    $hambatanOptions = [
                                        'Gangguan pendengaran',
                                        'Gangguan emosi',
                                        'Motivasi kurang/buruk',
                                        'Memori hilang',
                                        'Secara fisiologis tidak mampu belajar',
                                        'Perokok aktif/pasif',
                                    ];
                                @endphp
                                <div class="form-group">
                                    <label class="form-label">Hambatan <i class="fas fa-info-circle tooltip-icon"
                                            data-bs-toggle="tooltip"
                                            title="Pilih apakah ada hambatan yang dialami pasien"></i></label>
                                    <div class="checkbox-group">
                                        @foreach ($hambatanStatusOptions as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="hambatan_status"
                                                    value="{{ $option['value'] }}"
                                                    id="hambatan_status_{{ strtolower($option['value']) }}"
                                                    {{ isset($option['checked']) && $option['checked'] ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="hambatan_status_{{ strtolower($option['value']) }}">{{ $option['label'] }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="hambatan-details" id="hambatan-details">
                                        <div class="checkbox-group">
                                            @foreach ($hambatanOptions as $hambatan)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="hambatan[]"
                                                        value="{{ $hambatan }}"
                                                        id="hambatan_{{ str_replace(' ', '_', strtolower($hambatan)) }}">
                                                    <label class="form-check-label"
                                                        for="hambatan_{{ str_replace(' ', '_', strtolower($hambatan)) }}">{{ $hambatan }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $ketersediaanEdukasiOptions = [
                                        ['value' => '1', 'label' => 'Ya'],
                                        ['value' => '0', 'label' => 'Tidak'],
                                    ];
                                @endphp
                                <div class="form-group">
                                    <label class="form-label">Ketersediaan Menerima Edukasi <i
                                            class="fas fa-info-circle tooltip-icon" data-bs-toggle="tooltip"
                                            title="Apakah pasien bersedia menerima edukasi?"></i></label>
                                    <div class="checkbox-group">
                                        @foreach ($ketersediaanEdukasiOptions as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="ketersediaan_edukasi" value="{{ $option['value'] }}"
                                                    id="ketersediaan_{{ strtolower($option['value']) }}">
                                                <label class="form-check-label"
                                                    for="ketersediaan_{{ strtolower($option['value']) }}">{{ $option['label'] }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="section-separator">
                                <h5 class="section-title">2. Kebutuhan Edukasi</h5>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="kebutuhan_edukasi[]"
                                                    value="kebutuhan_hak_berpartisipasi_pada_proses_pelayanan"
                                                    id="kebutuhan_hak_berpartisipasi_pada_proses_pelayanan">
                                                <label class="form-check-label"
                                                    for="kebutuhan_hak_berpartisipasi_pada_proses_pelayanan">Hak
                                                    berpartisipasi
                                                    pada proses pelayanan</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="kebutuhan_edukasi[]"
                                                    value="kebutuhan_prosedur_pemeriksaan_penunjang"
                                                    id="kebutuhan_prosedur_pemeriksaan_penunjang">
                                                <label class="form-check-label"
                                                    for="kebutuhan_prosedur_pemeriksaan_penunjang">Prosedur pemeriksaan
                                                    penunjang</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="kebutuhan_edukasi[]"
                                                    value="kebutuhan_kondisi_kesehatan_daignosis_dan_penatalaksanaannya"
                                                    id="kebutuhan_kondisi_kesehatan_daignosis_dan_penatalaksanaannya">
                                                <label class="form-check-label"
                                                    for="kebutuhan_kondisi_kesehatan_daignosis_dan_penatalaksanaannya">Kondisi
                                                    kesehatan, diagnosis, dan penatalaksanaannya</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="kebutuhan_edukasi[]"
                                                    value="kebutuhan_proses_pemberian_informed_concent"
                                                    id="kebutuhan_proses_pemberian_informed_concent">
                                                <label class="form-check-label"
                                                    for="kebutuhan_proses_pemberian_informed_concent">Proses pemberian
                                                    informed
                                                    consent</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="kebutuhan_edukasi[]" value="kebutuhan_diet_dan_nutrisi"
                                                    id="kebutuhan_diet_dan_nutrisi">
                                                <label class="form-check-label" for="kebutuhan_diet_dan_nutrisi">Diet dan
                                                    nutrisi</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="kebutuhan_edukasi[]"
                                                    value="kebutuhan_pengguanaan_obat_secara_efektif_dan_aman_serta_efek_samping_serta_interaksinya"
                                                    id="kebutuhan_pengguanaan_obat_secara_efektif_dan_aman_serta_efek_samping_serta_interaksinya">
                                                <label class="form-check-label"
                                                    for="kebutuhan_pengguanaan_obat_secara_efektif_dan_aman_serta_efek_samping_serta_interaksinya">Penggunaan
                                                    obat secara efektif dan aman serta efek samping serta
                                                    interaksinya</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="kebutuhan_edukasi[]"
                                                    value="kebutuhan_penggunaan_alat_medis_yang_aman"
                                                    id="kebutuhan_penggunaan_alat_medis_yang_aman">
                                                <label class="form-check-label"
                                                    for="kebutuhan_penggunaan_alat_medis_yang_aman">Penggunaan alat medis
                                                    yang
                                                    aman</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="kebutuhan_edukasi[]" value="kebutuhan_manajemen_nyeri"
                                                    id="kebutuhan_manajemen_nyeri">
                                                <label class="form-check-label" for="kebutuhan_manajemen_nyeri">Manajemen
                                                    nyeri</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="kebutuhan_edukasi[]" value="kebutuhan_teknik_rehabilitasi"
                                                    id="kebutuhan_teknik_rehabilitasi">
                                                <label class="form-check-label" for="kebutuhan_teknik_rehabilitasi">Teknik
                                                    rehabilitasi</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="kebutuhan_edukasi[]" value="kebutuhan_cuci_tangan_yang_benar"
                                                    id="kebutuhan_cuci_tangan_yang_benar">
                                                <label class="form-check-label"
                                                    for="kebutuhan_cuci_tangan_yang_benar">Cuci
                                                    tangan yang benar</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="kebutuhan_edukasi[]" value="kebutuhan_bahaya_merokok"
                                                    id="kebutuhan_bahaya_merokok">
                                                <label class="form-check-label" for="kebutuhan_bahaya_merokok">Bahaya
                                                    merokok</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="kebutuhan_edukasi[]" value="kebutuhan_rujukan_edukasi"
                                                    id="kebutuhan_rujukan_edukasi">
                                                <label class="form-check-label" for="kebutuhan_rujukan_edukasi">Rujukan
                                                    edukasi</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="kebutuhan_edukasi[]" value="kebutuhan_perawatan_av_shunt"
                                                    id="kebutuhan_perawatan_av_shunt">
                                                <label class="form-check-label"
                                                    for="kebutuhan_perawatan_av_shunt">Perawatan
                                                    AV-Shunt</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="kebutuhan_edukasi[]" value="kebutuhan_perawatan_cdl"
                                                    id="kebutuhan_perawatan_cdl">
                                                <label class="form-check-label" for="kebutuhan_perawatan_cdl">Perawatan
                                                    CDL</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="kebutuhan_edukasi[]" value="kebutuhan_kepatuhan_minum_obat"
                                                    id="kebutuhan_kepatuhan_minum_obat">
                                                <label class="form-check-label"
                                                    for="kebutuhan_kepatuhan_minum_obat">Kepatuhan
                                                    minum obat</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox"
                                                    name="kebutuhan_edukasi[]"
                                                    value="kebutuhan_perawatan_luka_akses_femoralis"
                                                    id="kebutuhan_perawatan_luka_akses_femoralis">
                                                <label class="form-check-label"
                                                    for="kebutuhan_perawatan_luka_akses_femoralis">Perawatan luka akses
                                                    femoralis</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section-separator">
                                <h5 class="section-title">3. Edukasi Pasien</h5>
                                @php
                                    $hasilVerifikasiOptions = ['Sudah mengerti', 'Re-demonstrasi', 'Re-edukasi'];
                                @endphp
                                <div class="row row-cols-1 row-cols-md-2 g-4">
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Hak dan Kewajiban pasien dan Keluarga</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_1" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[hak_kewajiban_pasien][tgl_jam]" id="tgl_jam_1">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[hak_kewajiban_pasien][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_1_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_1_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_1" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[hak_kewajiban_pasien][tgl_reedukasi]"
                                                        id="tgl_reedukasi_1">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_1" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[hak_kewajiban_pasien][edukator_kd]" id="edukator_1">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_1" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[hak_kewajiban_pasien][pasien_nama]"
                                                        id="pasien_nama_1" placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Identitas pasien (gelang warna hijau, merah muda,
                                                kuning, merah, ungu)</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_2" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[identitas_pasien_gelang][tgl_jam]" id="tgl_jam_2">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[identitas_pasien_gelang][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_2_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_2_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_2" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[identitas_pasien_gelang][tgl_reedukasi]"
                                                        id="tgl_reedukasi_2">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_2" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[identitas_pasien_gelang][edukator_kd]"
                                                        id="edukator_2">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_2" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[identitas_pasien_gelang][pasien_nama]"
                                                        id="pasien_nama_2" placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Penyebab gagal ginjal</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_3" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[penyebab_gagal_ginjal][tgl_jam]" id="tgl_jam_3">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[penyebab_gagal_ginjal][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_3_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_3_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_3" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[penyebab_gagal_ginjal][tgl_reedukasi]"
                                                        id="tgl_reedukasi_3">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_3" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[penyebab_gagal_ginjal][edukator_kd]"
                                                        id="edukator_3">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_3" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[penyebab_gagal_ginjal][pasien_nama]"
                                                        id="pasien_nama_3" placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Arti dan Kegunaan Hemodialisis</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_4" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[arti_kegunaan_hemodialisis][tgl_jam]"
                                                        id="tgl_jam_4">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[arti_kegunaan_hemodialisis][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_4_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_4_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_4" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[arti_kegunaan_hemodialisis][tgl_reedukasi]"
                                                        id="tgl_reedukasi_4">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_4" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[arti_kegunaan_hemodialisis][edukator_kd]"
                                                        id="edukator_4">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_4" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[arti_kegunaan_hemodialisis][pasien_nama]"
                                                        id="pasien_nama_4" placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Jumlah/jam hemodialisis dan frekuensi hemodialisi
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_5" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[jumlah_jam_hemodialisis][tgl_jam]" id="tgl_jam_5">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[jumlah_jam_hemodialisis][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_5_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_5_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_5" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[jumlah_jam_hemodialisis][tgl_reedukasi]"
                                                        id="tgl_reedukasi_5">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_5" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[jumlah_jam_hemodialisis][edukator_kd]"
                                                        id="edukator_5">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_5" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[jumlah_jam_hemodialisis][pasien_nama]"
                                                        id="pasien_nama_5" placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Meningkatkan Kepatuhan intake cairan pasien</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_6" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[kepatuhan_intake_cairan][tgl_jam]" id="tgl_jam_6">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[kepatuhan_intake_cairan][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_6_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_6_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_6" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[kepatuhan_intake_cairan][tgl_reedukasi]"
                                                        id="tgl_reedukasi_6">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_6" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[kepatuhan_intake_cairan][edukator_kd]"
                                                        id="edukator_6">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_6" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[kepatuhan_intake_cairan][pasien_nama]"
                                                        id="pasien_nama_6" placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Makanan yang tidak boleh dimakan</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_7" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[makanan_tidak_boleh][tgl_jam]" id="tgl_jam_7">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[makanan_tidak_boleh][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_7_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_7_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_7" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[makanan_tidak_boleh][tgl_reedukasi]"
                                                        id="tgl_reedukasi_7">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_7" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[makanan_tidak_boleh][edukator_kd]" id="edukator_7">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_7" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[makanan_tidak_boleh][pasien_nama]"
                                                        id="pasien_nama_7" placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Cara mengkonsumsi buah-buahan dan sayur-sayuran</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_8" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[cara_konsumsi_buah][tgl_jam]" id="tgl_jam_8">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[cara_konsumsi_buah][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_8_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_8_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_8" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[cara_konsumsi_buah][tgl_reedukasi]"
                                                        id="tgl_reedukasi_8">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_8" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[cara_konsumsi_buah][edukator_kd]" id="edukator_8">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_8" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[cara_konsumsi_buah][pasien_nama]" id="pasien_nama_8"
                                                        placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Komplikasi hemodialisis</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_9" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[komplikasi_hemodialisis][tgl_jam]" id="tgl_jam_9">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[komplikasi_hemodialisis][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_9_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_9_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_9" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[komplikasi_hemodialisis][tgl_reedukasi]"
                                                        id="tgl_reedukasi_9">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_9" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[komplikasi_hemodialisis][edukator_kd]"
                                                        id="edukator_9">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_9" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[komplikasi_hemodialisis][pasien_nama]"
                                                        id="pasien_nama_9" placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Penyebab anemis pada pasien gagal ginjal</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_10" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[penyebab_anemis][tgl_jam]" id="tgl_jam_10">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[penyebab_anemis][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_10_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_10_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_10" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[penyebab_anemis][tgl_reedukasi]"
                                                        id="tgl_reedukasi_10">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_10" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[penyebab_anemis][edukator_kd]" id="edukator_10">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_10" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[penyebab_anemis][pasien_nama]" id="pasien_nama_10"
                                                        placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Monitor tekanan darah</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_11" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[monitor_tekanan_darah][tgl_jam]" id="tgl_jam_11">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[monitor_tekanan_darah][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_11_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_11_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_11" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[monitor_tekanan_darah][tgl_reedukasi]"
                                                        id="tgl_reedukasi_11">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_11" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[monitor_tekanan_darah][edukator_kd]"
                                                        id="edukator_11">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_11" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[monitor_tekanan_darah][pasien_nama]"
                                                        id="pasien_nama_11" placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Kepatuhan pasien dalam menjalani proses hemodialisis
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_12" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[kepatuhan_proses_hd][tgl_jam]" id="tgl_jam_12">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[kepatuhan_proses_hd][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_12_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_12_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_12" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[kepatuhan_proses_hd][tgl_reedukasi]"
                                                        id="tgl_reedukasi_12">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_12" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[kepatuhan_proses_hd][edukator_kd]" id="edukator_12">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_12" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[kepatuhan_proses_hd][pasien_nama]"
                                                        id="pasien_nama_12" placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Kenaikan BB pasien</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_13" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[kenaikan_bb_pasien][tgl_jam]" id="tgl_jam_13">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[kenaikan_bb_pasien][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_13_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_13_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_13" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[kenaikan_bb_pasien][tgl_reedukasi]"
                                                        id="tgl_reedukasi_13">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_13" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[kenaikan_bb_pasien][edukator_kd]" id="edukator_13">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_13" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[kenaikan_bb_pasien][pasien_nama]"
                                                        id="pasien_nama_13" placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Kualitas hidup pasien</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_14" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[kualitas_hidup_pasien][tgl_jam]" id="tgl_jam_14">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[kualitas_hidup_pasien][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_14_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_14_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_14" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[kualitas_hidup_pasien][tgl_reedukasi]"
                                                        id="tgl_reedukasi_14">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_14" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[kualitas_hidup_pasien][edukator_kd]"
                                                        id="edukator_14">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_14" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[kualitas_hidup_pasien][pasien_nama]"
                                                        id="pasien_nama_14" placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Kegunaan cimino, femoral, double lumen catheter</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_15" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[kegunaan_cimino_femoral][tgl_jam]" id="tgl_jam_15">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[kegunaan_cimino_femoral][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_15_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_15_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_15" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[kegunaan_cimino_femoral][tgl_reedukasi]"
                                                        id="tgl_reedukasi_15">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_15" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[kegunaan_cimino_femoral][edukator_kd]"
                                                        id="edukator_15">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_15" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[kegunaan_cimino_femoral][pasien_nama]"
                                                        id="pasien_nama_15" placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Cara perawatan cimino dan kateter double lumen</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_16" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[cara_perawatan_cimino][tgl_jam]" id="tgl_jam_16">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[cara_perawatan_cimino][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_16_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_16_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_16" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[cara_perawatan_cimino][tgl_reedukasi]"
                                                        id="tgl_reedukasi_16">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_16" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[cara_perawatan_cimino][edukator_kd]"
                                                        id="edukator_16">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_16" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[cara_perawatan_cimino][pasien_nama]"
                                                        id="pasien_nama_16" placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Kepatuhan minum obat</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_17" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[kepatuhan_minum_obat][tgl_jam]" id="tgl_jam_17">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[kepatuhan_minum_obat][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_17_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_17_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_17" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[kepatuhan_minum_obat][tgl_reedukasi]"
                                                        id="tgl_reedukasi_17">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_17" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[kepatuhan_minum_obat][edukator_kd]"
                                                        id="edukator_17">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_17" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[kepatuhan_minum_obat][pasien_nama]"
                                                        id="pasien_nama_17" placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Cara cuci tangan yang benar</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_18" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[cara_cuci_tangan][tgl_jam]" id="tgl_jam_18">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[cara_cuci_tangan][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_18_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_18_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_18" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[cara_cuci_tangan][tgl_reedukasi]"
                                                        id="tgl_reedukasi_18">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_18" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[cara_cuci_tangan][edukator_kd]" id="edukator_18">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_18" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[cara_cuci_tangan][pasien_nama]"
                                                        id="pasien_nama_18" placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header">Kepatuhan dalam membawa rujukan</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="tgl_jam_19" class="form-label">Tgl/Jam Edukasi</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="edukasi[kepatuhan_membawa_rujukan][tgl_jam]"
                                                        id="tgl_jam_19">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Hasil Verifikasi</label>
                                                    <div class="checkbox-group">
                                                        @foreach ($hasilVerifikasiOptions as $hasil)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edukasi[kepatuhan_membawa_rujukan][hasil_verifikasi]"
                                                                    value="{{ $hasil }}"
                                                                    id="verifikasi_19_{{ str_replace('-', '_', strtolower($hasil)) }}">
                                                                <label class="form-check-label"
                                                                    for="verifikasi_19_{{ str_replace('-', '_', strtolower($hasil)) }}">{{ $hasil }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_reedukasi_19" class="form-label">Tgl Rencana
                                                        Reedukasi/Redemonstrasi</label>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="edukasi[kepatuhan_membawa_rujukan][tgl_reedukasi]"
                                                        id="tgl_reedukasi_19">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edukator_19" class="form-label">Edukator</label>
                                                    <select class="foem-control select2" style="width: 100%"
                                                        name="edukasi[kepatuhan_membawa_rujukan][edukator_kd]"
                                                        id="edukator_19">
                                                        <option value="" selected disabled>Pilih Edukator</option>
                                                        @foreach ($perawat as $staff)
                                                            <option value="{{ $staff->kd_karyawan }}">
                                                                {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                                ({{ $staff->profesi ?? 'Perawat' }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pasien_nama_19" class="form-label">Pasien/Keluarga <i
                                                            class="fas fa-info-circle tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            title="Masukkan nama pasien atau anggota keluarga yang menerima edukasi"></i></label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="edukasi[kepatuhan_membawa_rujukan][pasien_nama]"
                                                        id="pasien_nama_19" placeholder="Nama Keluarga">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="text-end mt-5">
                            <button type="submit" class="btn btn-primary shadow-sm">Simpan</button>
                        </div>
                    </div>

            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
        // Enable/disable detail inputs based on checkbox state
        document.addEventListener('DOMContentLoaded', function() {
            // Handle bahasa checkbox change
            document.querySelectorAll('.bahasa-checkbox').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const targetName = this.getAttribute('data-target');
                    if (targetName) {
                        const targetInput = document.getElementById(targetName);
                        if (targetInput) {
                            if (this.checked) {
                                targetInput.disabled = false;
                                targetInput.focus();
                            } else {
                                targetInput.disabled = true;
                                targetInput.value = '';
                            }
                        }
                    }
                });
            });
        });

        // Toggle hambatan details based on radio selection
        const hambatanRadios = document.querySelectorAll('input[name="hambatan_status"]');
        const hambatanDetails = document.getElementById('hambatan-details');
        hambatanRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                hambatanDetails.classList.toggle('show', radio.value === '1');
                if (radio.value !== '1') {
                    document.querySelectorAll('input[name="hambatan[]"]').forEach(cb => cb.checked = false);
                }
            });
        });

        // Initialize Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', () => {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
        });

        // Smooth scroll to section on click
        const sectionTitles = document.querySelectorAll('.section-title');
        sectionTitles.forEach(title => {
            title.addEventListener('click', () => {
                title.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });

        // Initialize Select2 for all select elements
        document.addEventListener('DOMContentLoaded', () => {
            $('.select2').select2({
                placeholder: 'Pilih Edukator',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush
