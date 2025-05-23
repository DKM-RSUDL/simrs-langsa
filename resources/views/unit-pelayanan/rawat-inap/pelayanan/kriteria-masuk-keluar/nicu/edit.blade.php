@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .card-header {
            font-weight: bold;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.3rem;
        }

        .required::after {
            content: '*';
            color: red;
            margin-left: 0.2rem;
        }

        .invalid-feedback {
            display: none;
        }

        .is-invalid~.invalid-feedback {
            display: block;
        }

        .form-section {
            max-width: 100%;
        }

        .section-title {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 1rem;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 0.5rem;
        }

        .criteria-table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #dee2e6;
        }

        .criteria-table th,
        .criteria-table td {
            border: 1px solid #dee2e6;
            padding: 12px;
            vertical-align: top;
        }

        .criteria-table th {
            background-color: #f8f9fa;
            font-weight: 700;
            text-align: center;
        }

        .criteria-no {
            text-align: center;
            width: 50px;
            font-weight: 700;
        }

        .criteria-desc {
            width: 45%;
        }

        .check-col {
            text-align: center;
            width: 80px;
        }

        .keterangan-col {
            width: 40%;
        }

        .main-criteria {
            font-weight: bold;
            margin-bottom: 8px;
        }

        .sub-criteria-row {
            border-left: 3px solid #e9ecef;
            background-color: #fafafa;
        }

        .sub-criteria-text {
            margin-left: 20px;
            font-size: 0.95rem;
        }

        .form-control-textarea {
            min-height: 60px;
            resize: vertical;
            width: 100%;
        }

        .vital-signs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Edit Kriteria Masuk & Keluar NICU</h5>
            </div>

            <hr>

            <div class="form-section">
                <form
                    action="{{ route('rawat-inap.kriteria-masuk-keluar.nicu.update', [
                        'kd_unit' => $kd_unit,
                        'kd_pasien' => $kd_pasien,
                        'tgl_masuk' => $tgl_masuk,
                        'urut_masuk' => $urut_masuk,
                    ]) }}"
                    method="post" id="nicuCriteriaForm">
                    @csrf
                    @method('PUT')

                    <!-- Section Tanggal & Waktu -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="section-title mb-0">Tanggal & Waktu</h6>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <small class="text-warning mb-2">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    Pastikan jam diisi dengan benar untuk keakuratan dokumentasi medis
                                </small>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal" id="tanggal"
                                            value="{{ old('tanggal', $dataNicu->tanggal ?? date('Y-m-d')) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Jam</label>
                                        <input type="time" class="form-control" name="jam" id="jam"
                                            value="{{ old('jam', $dataNicu->jam ? date('H:i', strtotime($dataNicu->jam)) : date('H:i')) }}"
                                            required>
                                        <div class="invalid-feedback" id="timeError">
                                            Pastikan format jam benar (HH:MM)
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Dokter</label>
                                        <select name="kd_dokter" id="kd_dokter" class="form-select select2"
                                            style="width: 100%" required>
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $dok)
                                                <option value="{{ $dok->kd_dokter }}"
                                                    {{ old('kd_dokter', $dataNicu->kd_dokter ?? '') == $dok->kd_dokter ? 'selected' : '' }}>
                                                    {{ $dok->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Kriteria Masuk NICU -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="section-title mb-0">Kriteria Masuk NICU</h6>
                        </div>
                        <div class="card-body p-0">
                            <table class="criteria-table">
                                <thead>
                                    <tr>
                                        <th class="criteria-no">No</th>
                                        <th class="criteria-desc">Kriteria Masuk</th>
                                        <th class="check-col">Check List</th>
                                        <th class="keterangan-col">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- 1. BBLR (1000-1500 gram dengan komplikasi respirasi sindrome) -->
                                    <tr>
                                        <td class="criteria-no">1.</td>
                                        <td class="criteria-desc">
                                            <strong>BBLR (1000-1500 gram dengan komplikasi respirasi sindrome)</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="1" id="check_1"
                                                {{ $dataNicu && $dataNicu->kriteria_1 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[1]" placeholder="Keterangan...">{{ old('keterangan.1', $dataNicu->keterangan_1 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <!-- 2. Masa gestasi kurang dari 28 minggu dengan komplikasi respirasi distress sindrome (RDS) -->
                                    <tr>
                                        <td class="criteria-no">2.</td>
                                        <td class="criteria-desc">
                                            <strong>Masa gestasi kurang dari 28 minggu dengan komplikasi respirasi distress
                                                sindrome (RDS)</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="2" id="check_2"
                                                {{ $dataNicu && $dataNicu->kriteria_2 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[2]" placeholder="Keterangan...">{{ old('keterangan.2', $dataNicu->keterangan_2 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <!-- 3. Post Date : dengan tanda-tanda Sepsis, masa ehamilan 42 minggu dengan RDS -->
                                    <tr>
                                        <td class="criteria-no">3.</td>
                                        <td class="criteria-desc">
                                            <strong>Post Date : dengan tanda-tanda Sepsis, masa ehamilan 42 minggu dengan
                                                RDS</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="3" id="check_3"
                                                {{ $dataNicu && $dataNicu->kriteria_3 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[3]" placeholder="Keterangan...">{{ old('keterangan.3', $dataNicu->keterangan_3 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <!-- 4. Bayi dengan kelainan kongenital: -->
                                    <tr>
                                        <td class="criteria-no">4.</td>
                                        <td class="criteria-desc">
                                            <div class="main-criteria">Bayi dengan kelainan kongenital:</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="4_main" id="check_4_main"
                                                {{ $dataNicu && $dataNicu->kriteria_4_main ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[4_main]" placeholder="Keterangan...">{{ old('keterangan.4_main', $dataNicu->keterangan_4_main ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Bibir sumbing</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="4_bibir" id="check_4_bibir"
                                                {{ $dataNicu && $dataNicu->kriteria_4_bibir ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[4_bibir]" placeholder="Keterangan...">{{ old('keterangan.4_bibir', $dataNicu->keterangan_4_bibir ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Atresia ani</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="4_atresia" id="check_4_atresia"
                                                {{ $dataNicu && $dataNicu->kriteria_4_atresia ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[4_atresia]" placeholder="Keterangan...">{{ old('keterangan.4_atresia', $dataNicu->keterangan_4_atresia ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• An acephali</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="4_acephali" id="check_4_acephali"
                                                {{ $dataNicu && $dataNicu->kriteria_4_acephali ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[4_acephali]" placeholder="Keterangan...">{{ old('keterangan.4_acephali', $dataNicu->keterangan_4_acephali ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Polidactily</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="4_polidactily" id="check_4_polidactily"
                                                {{ $dataNicu && $dataNicu->kriteria_4_polidactily ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[4_polidactily]" placeholder="Keterangan...">{{ old('keterangan.4_polidactily', $dataNicu->keterangan_4_polidactily ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <!-- 5. Asfiksia berat : -->
                                    <tr>
                                        <td class="criteria-no">5.</td>
                                        <td class="criteria-desc">
                                            <div class="main-criteria">Asfiksia berat :</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="5_main" id="check_5_main"
                                                {{ $dataNicu && $dataNicu->kriteria_5_main ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[5_main]" placeholder="Keterangan...">{{ old('keterangan.5_main', $dataNicu->keterangan_5_main ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• RR: > 70 x/m</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="5_rr" id="check_5_rr"
                                                {{ $dataNicu && $dataNicu->kriteria_5_rr ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[5_rr]" placeholder="Keterangan...">{{ old('keterangan.5_rr', $dataNicu->keterangan_5_rr ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Takipnoe</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="5_takipnoe" id="check_5_takipnoe"
                                                {{ $dataNicu && $dataNicu->kriteria_5_takipnoe ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[5_takipnoe]" placeholder="Keterangan...">{{ old('keterangan.5_takipnoe', $dataNicu->keterangan_5_takipnoe ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Apgar score : 0-3</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="5_apgar" id="check_5_apgar"
                                                {{ $dataNicu && $dataNicu->kriteria_5_apgar ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[5_apgar]" placeholder="Keterangan...">{{ old('keterangan.5_apgar', $dataNicu->keterangan_5_apgar ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Retraksi dinding dada</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="5_retraksi" id="check_5_retraksi"
                                                {{ $dataNicu && $dataNicu->kriteria_5_retraksi ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[5_retraksi]" placeholder="Keterangan...">{{ old('keterangan.5_retraksi', $dataNicu->keterangan_5_retraksi ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Sianosis</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="5_sianosis" id="check_5_sianosis"
                                                {{ $dataNicu && $dataNicu->kriteria_5_sianosis ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[5_sianosis]" placeholder="Keterangan...">{{ old('keterangan.5_sianosis', $dataNicu->keterangan_5_sianosis ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Merintih</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="5_merintih" id="check_5_merintih"
                                                {{ $dataNicu && $dataNicu->kriteria_5_merintih ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[5_merintih]" placeholder="Keterangan...">{{ old('keterangan.5_merintih', $dataNicu->keterangan_5_merintih ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <!-- 6. Sepsis neonatorum : -->
                                    <tr>
                                        <td class="criteria-no">6.</td>
                                        <td class="criteria-desc">
                                            <div class="main-criteria">Sepsis neonatorum :</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="6_main" id="check_6_main"
                                                {{ $dataNicu && $dataNicu->kriteria_6_main ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[6_main]" placeholder="Keterangan...">{{ old('keterangan.6_main', $dataNicu->keterangan_6_main ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Leukocyte : >20.000</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="6_leukocyte" id="check_6_leukocyte"
                                                {{ $dataNicu && $dataNicu->kriteria_6_leukocyte ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[6_leukocyte]" placeholder="Keterangan...">{{ old('keterangan.6_leukocyte', $dataNicu->keterangan_6_leukocyte ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• RR 70</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="6_rr" id="check_6_rr"
                                                {{ $dataNicu && $dataNicu->kriteria_6_rr ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[6_rr]" placeholder="Keterangan...">{{ old('keterangan.6_rr', $dataNicu->keterangan_6_rr ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Temp : >38°C / <36 °C</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="6_temp" id="check_6_temp"
                                                {{ $dataNicu && $dataNicu->kriteria_6_temp ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[6_temp]" placeholder="Keterangan...">{{ old('keterangan.6_temp', $dataNicu->keterangan_6_temp ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• HR : >160 x/m atau <100 x/i</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="6_hr" id="check_6_hr"
                                                {{ $dataNicu && $dataNicu->kriteria_6_hr ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[6_hr]" placeholder="Keterangan...">{{ old('keterangan.6_hr', $dataNicu->keterangan_6_hr ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                    <tr class="sub-criteria-row">
                                        <td class="criteria-no"></td>
                                        <td class="criteria-desc">
                                            <div class="sub-criteria-text">• Malas minum</div>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="6_malas" id="check_6_malas"
                                                {{ $dataNicu && $dataNicu->kriteria_6_malas ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[6_malas]" placeholder="Keterangan...">{{ old('keterangan.6_malas', $dataNicu->keterangan_6_malas ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <!-- 7. Distres nafas berat -->
                                    <tr>
                                        <td class="criteria-no">7.</td>
                                        <td class="criteria-desc">
                                            <strong>Distres nafas berat</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="7" id="check_7"
                                                {{ $dataNicu && $dataNicu->kriteria_7 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[7]" placeholder="Keterangan...">{{ old('keterangan.7', $dataNicu->keterangan_7 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <!-- 8. Tetanus neonatorum -->
                                    <tr>
                                        <td class="criteria-no">8.</td>
                                        <td class="criteria-desc">
                                            <strong>Tetanus neonatorum</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="8" id="check_8"
                                                {{ $dataNicu && $dataNicu->kriteria_8 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[8]" placeholder="Keterangan...">{{ old('keterangan.8', $dataNicu->keterangan_8 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <!-- 9. Kejang pada bayi / neonatal seizure -->
                                    <tr>
                                        <td class="criteria-no">9.</td>
                                        <td class="criteria-desc">
                                            <strong>Kejang pada bayi / neonatal seizure</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="9" id="check_9"
                                                {{ $dataNicu && $dataNicu->kriteria_9 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[9]" placeholder="Keterangan...">{{ old('keterangan.9', $dataNicu->keterangan_9 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <!-- 10. Bayi diare -->
                                    <tr>
                                        <td class="criteria-no">10.</td>
                                        <td class="criteria-desc">
                                            <strong>Bayi diare</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list[]" value="10" id="check_10"
                                                {{ $dataNicu && $dataNicu->kriteria_10 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan[10]" placeholder="Keterangan...">{{ old('keterangan.10', $dataNicu->keterangan_10 ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Section Kriteria Keluar NICU -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="section-title mb-0">Kriteria Keluar NICU</h6>
                        </div>
                        <div class="card-body p-0">
                            <table class="criteria-table">
                                <thead>
                                    <tr>
                                        <th class="criteria-no">No</th>
                                        <th class="criteria-desc">Kriteria Keluar</th>
                                        <th class="check-col">Check List</th>
                                        <th class="keterangan-col">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- 1. BBLR bayi sudah normal berat badannya ≥ 1800 gr -->
                                    <tr>
                                        <td class="criteria-no">1.</td>
                                        <td class="criteria-desc">
                                            <strong>BBLR bayi sudah normal berat badannya ≥ 1800 gr</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="1" id="check_keluar_1"
                                                {{ $dataKeluarNicu && $dataKeluarNicu->kriteria_keluar_1 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[1]" placeholder="Keterangan...">{{ old('keterangan_keluar.1', $dataKeluarNicu->keterangan_keluar_1 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <!-- 2. Kondisi Yang Sudah Membaik -->
                                    <tr>
                                        <td class="criteria-no">2.</td>
                                        <td class="criteria-desc">
                                            <strong>Kondisi Yang Sudah Membaik</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="2" id="check_keluar_2"
                                                {{ $dataKeluarNicu && $dataKeluarNicu->kriteria_keluar_2 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[2]" placeholder="Keterangan...">{{ old('keterangan_keluar.2', $dataKeluarNicu->keterangan_keluar_2 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <!-- 3. Apgar Score 7-10 -->
                                    <tr>
                                        <td class="criteria-no">3.</td>
                                        <td class="criteria-desc">
                                            <strong>Apgar Score 7-10</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="3" id="check_keluar_3"
                                                {{ $dataKeluarNicu && $dataKeluarNicu->kriteria_keluar_3 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[3]" placeholder="Keterangan...">{{ old('keterangan_keluar.3', $dataKeluarNicu->keterangan_keluar_3 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <!-- 4. Kadar bilirubin normal -->
                                    <tr>
                                        <td class="criteria-no">4.</td>
                                        <td class="criteria-desc">
                                            <strong>Kadar bilirubin normal</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="4" id="check_keluar_4"
                                                {{ $dataKeluarNicu && $dataKeluarNicu->kriteria_keluar_4 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[4]" placeholder="Keterangan...">{{ old('keterangan_keluar.4', $dataKeluarNicu->keterangan_keluar_4 ?? '') }}</textarea>
                                        </td>
                                    </tr>

                                    <!-- 5. Gerakan aktif, refleks isap kuat -->
                                    <tr>
                                        <td class="criteria-no">5.</td>
                                        <td class="criteria-desc">
                                            <strong>Gerakan aktif, refleks isap kuat</strong>
                                        </td>
                                        <td class="check-col">
                                            <input type="checkbox" name="check_list_keluar[]" value="5" id="check_keluar_5"
                                                {{ $dataKeluarNicu && $dataKeluarNicu->kriteria_keluar_5 ? 'checked' : '' }}>
                                        </td>
                                        <td class="keterangan-col">
                                            <textarea class="form-control form-control-textarea" name="keterangan_keluar[5]" placeholder="Keterangan...">{{ old('keterangan_keluar.5', $dataKeluarNicu->keterangan_keluar_5 ?? '') }}</textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                            <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/kriteria-masuk-keluar/nicu") }}"
                                class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Function to handle checkbox interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Handle kriteria masuk checkboxes
            const checkboxesMasuk = document.querySelectorAll('input[name="check_list[]"]');

            checkboxesMasuk.forEach(function(checkbox) {
                const row = checkbox.closest('tr');
                const keteranganTextarea = row.querySelector('textarea[name^="keterangan["]');

                // Set initial state based on checkbox
                if (checkbox.checked) {
                    keteranganTextarea.setAttribute('required', 'required');
                    keteranganTextarea.style.borderColor = '#dc3545';
                    keteranganTextarea.parentElement.classList.add('required-field');
                } else {
                    keteranganTextarea.removeAttribute('required');
                    keteranganTextarea.style.borderColor = '#ced4da';
                    keteranganTextarea.parentElement.classList.remove('required-field');
                }

                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        keteranganTextarea.setAttribute('required', 'required');
                        keteranganTextarea.style.borderColor = '#dc3545';
                        keteranganTextarea.parentElement.classList.add('required-field');
                    } else {
                        keteranganTextarea.removeAttribute('required');
                        keteranganTextarea.style.borderColor = '#ced4da';
                        keteranganTextarea.parentElement.classList.remove('required-field');
                    }
                });
            });

            // Handle kriteria keluar checkboxes
            const checkboxesKeluar = document.querySelectorAll('input[name="check_list_keluar[]"]');

            checkboxesKeluar.forEach(function(checkbox) {
                const row = checkbox.closest('tr');
                const keteranganTextarea = row.querySelector('textarea[name^="keterangan_keluar["]');

                // Set initial state based on checkbox
                if (checkbox.checked) {
                    keteranganTextarea.setAttribute('required', 'required');
                    keteranganTextarea.style.borderColor = '#dc3545';
                    keteranganTextarea.parentElement.classList.add('required-field');
                } else {
                    keteranganTextarea.removeAttribute('required');
                    keteranganTextarea.style.borderColor = '#ced4da';
                    keteranganTextarea.parentElement.classList.remove('required-field');
                }

                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        keteranganTextarea.setAttribute('required', 'required');
                        keteranganTextarea.style.borderColor = '#dc3545';
                        keteranganTextarea.parentElement.classList.add('required-field');
                    } else {
                        keteranganTextarea.removeAttribute('required');
                        keteranganTextarea.style.borderColor = '#ced4da';
                        keteranganTextarea.parentElement.classList.remove('required-field');
                    }
                });
            });

            // Form validation before submit
            document.getElementById('nicuCriteriaForm').addEventListener('submit', function(e) {
                let hasError = false;

                // Check kriteria masuk
                checkboxesMasuk.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        const row = checkbox.closest('tr');
                        const textarea = row.querySelector('textarea[name^="keterangan["]');

                        if (!textarea.value.trim()) {
                            hasError = true;
                            textarea.style.borderColor = '#dc3545';
                            textarea.focus();
                        }
                    }
                });

                // Check kriteria keluar
                checkboxesKeluar.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        const row = checkbox.closest('tr');
                        const textarea = row.querySelector('textarea[name^="keterangan_keluar["]');

                        if (!textarea.value.trim()) {
                            hasError = true;
                            textarea.style.borderColor = '#dc3545';
                            textarea.focus();
                        }
                    }
                });

                if (hasError) {
                    e.preventDefault();
                    alert('Harap isi keterangan untuk semua kriteria yang dipilih.');
                }
            });
        });
    </script>
@endpush