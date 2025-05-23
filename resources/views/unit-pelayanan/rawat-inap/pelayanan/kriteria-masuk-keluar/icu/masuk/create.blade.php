@extends('layouts.administrator.master')

@section('content')
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

            .priority-table {
                border-collapse: collapse;
                width: 100%;
                border: 1px solid #dee2e6;
            }

            .priority-table th,
            .priority-table td {
                border: 1px solid #dee2e6;
                padding: 12px;
                vertical-align: top;
            }

            .priority-table th {
                background-color: #f8f9fa;
                font-weight: 700;
                text-align: center;
            }

            .priority-no {
                text-align: center;
                width: 60px;
                font-weight: 700;
            }

            .priority-desc {
                width: 40%;
                font-weight: 600;
                color: #2c3e50;
            }

            .priority-criteria {
                width: 60%;
            }

            .criteria-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .criteria-item {
                display: flex;
                align-items: flex-start;
                margin-bottom: 8px;
                padding: 4px 0;
            }

            .criteria-item:last-child {
                margin-bottom: 0;
            }

            .criteria-checkbox {
                margin-right: 8px;
                margin-top: 2px;
                flex-shrink: 0;
            }

            .criteria-label {
                flex: 1;
                font-size: 0.9rem;
                line-height: 1.4;
                color: #495057;
            }

            .vital-signs-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
            }

            .priority-1-row {
                background-color: #fff5f5;
            }

            .priority-2-row {
                background-color: #fffbf0;
            }

            .priority-3-row {
                background-color: #f0fff4;
            }

            .priority-4-row {
                background-color: #f8f9fa;
            }

            .priority-5-row {
                background-color: #faf5ff;
            }

            .form-control-textarea {
                min-height: 100px;
                resize: vertical;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Kriteria Masuk Ruang ICU</h5>
            </div>

            <hr>

            <div class="form-section">
                <form
                    action="{{ route('rawat-inap.kriteria-masuk-keluar.icu.masuk.store', [
                        'kd_unit' => $kd_unit,
                        'kd_pasien' => $kd_pasien,
                        'tgl_masuk' => $tgl_masuk,
                        'urut_masuk' => $urut_masuk,
                    ]) }}"
                    method="post" id="icuCriteriaForm">
                    @csrf

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
                                            value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Jam</label>
                                        <input type="time" class="form-control" name="jam" id="jam"
                                            value="{{ old('jam', date('H:i')) }}" required>
                                        <div class="invalid-feedback" id="timeError">
                                            Pastikan format jam benar (HH:MM)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Tanda Vital -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="section-title mb-0">Tanda-Tanda Vital</h6>
                        </div>
                        <div class="card-body">
                            <div class="vital-signs-grid">
                                <div class="mb-3">
                                    <label class="form-label">Respon Mata (E)</label>
                                    <select class="form-control form-select" name="gcs_mata" id="gcs_mata" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="1" {{ old('gcs_mata') == '1' ? 'selected' : '' }}>1 - Tidak ada
                                            respon</option>
                                        <option value="2" {{ old('gcs_mata') == '2' ? 'selected' : '' }}>2 - Respon
                                            terhadap rangsang nyeri</option>
                                        <option value="3" {{ old('gcs_mata') == '3' ? 'selected' : '' }}>3 - Respon
                                            terhadap rangsang suara</option>
                                        <option value="4" {{ old('gcs_mata') == '4' ? 'selected' : '' }}>4 - Membuka
                                            mata spontan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Respon Verbal (V)</label>
                                    <select class="form-control form-select" name="gcs_verbal" id="gcs_verbal" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="1" {{ old('gcs_verbal') == '1' ? 'selected' : '' }}>1 - Tidak
                                            ada respon</option>
                                        <option value="2" {{ old('gcs_verbal') == '2' ? 'selected' : '' }}>2 -
                                            Mengeluarkan suara</option>
                                        <option value="3" {{ old('gcs_verbal') == '3' ? 'selected' : '' }}>3 -
                                            Kata-kata tidak sesuai</option>
                                        <option value="4" {{ old('gcs_verbal') == '4' ? 'selected' : '' }}>4 -
                                            Percakapan kacau</option>
                                        <option value="5" {{ old('gcs_verbal') == '5' ? 'selected' : '' }}>5 -
                                            Orientasi baik</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Respon Motorik (M)</label>
                                    <select class="form-control form-select" name="gcs_motorik" id="gcs_motorik" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="1" {{ old('gcs_motorik') == '1' ? 'selected' : '' }}>1 - Tidak
                                            ada respon</option>
                                        <option value="2" {{ old('gcs_motorik') == '2' ? 'selected' : '' }}>2 -
                                            Ekstensi abnormal</option>
                                        <option value="3" {{ old('gcs_motorik') == '3' ? 'selected' : '' }}>3 - Fleksi
                                            abnormal</option>
                                        <option value="4" {{ old('gcs_motorik') == '4' ? 'selected' : '' }}>4 -
                                            Menghindari rangsang nyeri</option>
                                        <option value="5" {{ old('gcs_motorik') == '5' ? 'selected' : '' }}>5 -
                                            Melokalisir nyeri</option>
                                        <option value="6" {{ old('gcs_motorik') == '6' ? 'selected' : '' }}>6 -
                                            Menuruti perintah</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label required">Total GCS</label>
                                    <input type="number" class="form-control" name="gcs_total" id="gcs_total"
                                        value="{{ old('gcs_total') }}" min="3" max="15" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label required">TD Sistole (mmHg)</label>
                                    <input type="number" class="form-control" name="td_sistole" id="td_sistole"
                                        value="{{ old('td_sistole') }}" placeholder="Contoh: 120" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label required">TD Diastole (mmHg)</label>
                                    <input type="number" class="form-control" name="td_diastole" id="td_diastole"
                                        value="{{ old('td_diastole') }}" placeholder="Contoh: 80" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label required">Nadi (x/mnt)</label>
                                    <input type="number" class="form-control" name="nadi" id="nadi"
                                        value="{{ old('nadi') }}" placeholder="Contoh: 80" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label required">RR (x/mnt)</label>
                                    <input type="number" class="form-control" name="rr" id="rr"
                                        value="{{ old('rr') }}" placeholder="Contoh: 20" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label required">Suhu (°C)</label>
                                    <input type="number" class="form-control" name="suhu" step="0.1"
                                        id="suhu" value="{{ old('suhu') }}" placeholder="Contoh: 36.5" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Kriteria Prioritas -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="section-title mb-0">Kriteria Prioritas Pasien ICU</h6>
                        </div>
                        <div class="card-body p-0">
                            <table class="priority-table">
                                <thead>
                                    <tr>
                                        <th class="priority-no">No</th>
                                        <th class="priority-desc">Prioritas</th>
                                        <th class="priority-criteria">Kriteria</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Prioritas 1 -->
                                    <tr class="priority-1-row">
                                        <td class="priority-no">1</td>
                                        <td class="priority-desc">
                                            <strong>Pasien prioritas 1 (satu)</strong><br>
                                            Pasien kritis, tidak stabil, yang memerlukan terapi intensif / tertitrasi
                                        </td>
                                        <td class="priority-criteria">
                                            <div class="criteria-list">
                                                <div class="criteria-item">
                                                    <input type="checkbox" class="criteria-checkbox" name="prioritas_1[]"
                                                        value="ventilasi_dukungan" id="p1_ventilasi">
                                                    <label class="criteria-label" for="p1_ventilasi">
                                                        Butuh dukungan / bantuan ventilasi dan alat bantu suportif organ /
                                                        sistem lain (ventilator, masker NRM, masker RM, dll)
                                                    </label>
                                                </div>
                                                <div class="criteria-item">
                                                    <input type="checkbox" class="criteria-checkbox" name="prioritas_1[]"
                                                        value="infus_vasoaktif" id="p1_infus">
                                                    <label class="criteria-label" for="p1_infus">
                                                        Butuh infus/obat-obat vasoaktif kontinyu (Dopamin, Dobutamin,
                                                        Vascon, Adrenalin)
                                                    </label>
                                                </div>
                                                <div class="criteria-item">
                                                    <input type="checkbox" class="criteria-checkbox" name="prioritas_1[]"
                                                        value="anti_aritmia" id="p1_aritmia">
                                                    <label class="criteria-label" for="p1_aritmia">
                                                        Obat anti aritmia kontinyu
                                                    </label>
                                                </div>
                                                <div class="criteria-item">
                                                    <input type="checkbox" class="criteria-checkbox" name="prioritas_1[]"
                                                        value="bedah_kardiothorasik" id="p1_bedah">
                                                    <label class="criteria-label" for="p1_bedah">
                                                        Pasien bedah kardiotorasik
                                                    </label>
                                                </div>
                                                <div class="criteria-item">
                                                    <input type="checkbox" class="criteria-checkbox" name="prioritas_1[]"
                                                        value="sepsis_berat" id="p1_sepsis">
                                                    <label class="criteria-label" for="p1_sepsis">
                                                        Pasien sepsis berat
                                                    </label>
                                                </div>
                                                <div class="criteria-item">
                                                    <input type="checkbox" class="criteria-checkbox" name="prioritas_1[]"
                                                        value="gangguan_asam_basa" id="p1_asam_basa">
                                                    <label class="criteria-label" for="p1_asam_basa">
                                                        Gangguan keseimbangan asam basa dan elektrolit yang mengancam nyawa
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Prioritas 2 -->
                                    <tr class="priority-2-row">
                                        <td class="priority-no">2</td>
                                        <td class="priority-desc">
                                            <strong>Pasien prioritas 2 (dua)</strong><br>
                                            Memerlukan pelayanan pemantauan ICU, dengan kondisi medis yang senantiasa
                                            berubah
                                        </td>
                                        <td class="priority-criteria">
                                            <div class="criteria-list">
                                                <div class="criteria-item">
                                                    <input type="checkbox" class="criteria-checkbox" name="prioritas_2[]"
                                                        value="gagal_jantung_paru" id="p2_jantung">
                                                    <label class="criteria-label" for="p2_jantung">
                                                        Pasien gagal jantung paru
                                                    </label>
                                                </div>
                                                <div class="criteria-item">
                                                    <input type="checkbox" class="criteria-checkbox" name="prioritas_2[]"
                                                        value="gagal_ginjal_akut" id="p2_ginjal">
                                                    <label class="criteria-label" for="p2_ginjal">
                                                        Pasien gagal ginjal akut dan berat
                                                    </label>
                                                </div>
                                                <div class="criteria-item">
                                                    <input type="checkbox" class="criteria-checkbox" name="prioritas_2[]"
                                                        value="pembedahan_mayor" id="p2_bedah">
                                                    <label class="criteria-label" for="p2_bedah">
                                                        Telah mengalami pembedahan mayor
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Prioritas 3 -->
                                    <tr class="priority-3-row">
                                        <td class="priority-no">3</td>
                                        <td class="priority-desc">
                                            <strong>Pasien prioritas 3 (tiga)</strong><br>
                                            Pasien kritis, tidak stabil, kemungkinan sembuh dan atau manfaat terapi di ICU
                                            sangat kecil
                                        </td>
                                        <td class="priority-criteria">
                                            <div class="criteria-list">
                                                <div class="criteria-item">
                                                    <input type="checkbox" class="criteria-checkbox" name="prioritas_3[]"
                                                        value="keganasan_metastatik" id="p3_keganasan">
                                                    <label class="criteria-label" for="p3_keganasan">
                                                        Keganasan metastatik disertai penyulit infeksi
                                                    </label>
                                                </div>
                                                <div class="criteria-item">
                                                    <input type="checkbox" class="criteria-checkbox" name="prioritas_3[]"
                                                        value="pericardial_tamponade" id="p3_tamponade">
                                                    <label class="criteria-label" for="p3_tamponade">
                                                        Pericardial tamponade
                                                    </label>
                                                </div>
                                                <div class="criteria-item">
                                                    <input type="checkbox" class="criteria-checkbox" name="prioritas_3[]"
                                                        value="sumbatan_jalan_napas" id="p3_sumbatan">
                                                    <label class="criteria-label" for="p3_sumbatan">
                                                        Sumbatan jalan napas
                                                    </label>
                                                </div>
                                                <div class="criteria-item">
                                                    <input type="checkbox" class="criteria-checkbox" name="prioritas_3[]"
                                                        value="penyakit_jantung" id="p3_jantung">
                                                    <label class="criteria-label" for="p3_jantung">
                                                        Pasien penyakit jantung
                                                    </label>
                                                </div>
                                                <div class="criteria-item">
                                                    <input type="checkbox" class="criteria-checkbox" name="prioritas_3[]"
                                                        value="penyakit_paru_terminal" id="p3_paru">
                                                    <label class="criteria-label" for="p3_paru">
                                                        Penyakit paru terminal disertai komplikasi penyakit akut berat
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Prioritas 4 -->
                                    <tr class="priority-4-row">
                                        <td class="priority-no">4</td>
                                        <td class="priority-desc">
                                            <strong>Pengecualian (bisa masuk ICU, tetapi harus bisa dikeluarkan dari ICU
                                                agar pasien prioritas 1, 2 dan 3 bisa masuk)</strong>
                                        </td>
                                        <td class="priority-criteria">
                                            <div class="criteria-list">
                                                <div class="criteria-item">
                                                    <input type="checkbox" class="criteria-checkbox" name="prioritas_4[]"
                                                        value="pasien_memenuhi_kriteria" id="p4_memenuhi">
                                                    <label class="criteria-label" for="p4_memenuhi">
                                                        Pasien yang memenuhi kriteria masuk tetapi menolak terapi tunjangan
                                                        hidup agresif dan pasien dengan DNR (Do Not Resuscitate)
                                                    </label>
                                                </div>
                                                <div class="criteria-item">
                                                    <input type="checkbox" class="criteria-checkbox" name="prioritas_4[]"
                                                        value="vegetatif_permanen" id="p4_vegetatif">
                                                    <label class="criteria-label" for="p4_vegetatif">
                                                        Pasien dalam keadaan vegetatif permanen
                                                    </label>
                                                </div>
                                                <div class="criteria-item">
                                                    <input type="checkbox" class="criteria-checkbox" name="prioritas_4[]"
                                                        value="mati_batang_otak" id="p4_mati_otak">
                                                    <label class="criteria-label" for="p4_mati_otak">
                                                        Pasien mati batang otak, untuk menunjang fungsi organ, hanya untuk
                                                        kepentingan donor organ
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Prioritas 5 -->
                                    <tr class="priority-5-row">
                                        <td class="priority-no">5</td>
                                        <td class="priority-desc">
                                            <strong>Berdasarkan kriteria diatas, maka pasien tersebut memenuhi kriteria
                                                untuk masuk ICU dengan diagnosa :</strong>
                                        </td>
                                        <td class="priority-criteria">
                                            <textarea class="form-control form-control-textarea" name="diagnosa_kriteria" id="diagnosa_kriteria" rows="5"
                                                placeholder="Tulis diagnosa dan alasan pasien memenuhi kriteria masuk ICU...">{{ old('diagnosa_kriteria') }}</textarea>
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
                            <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk") }}"
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
        document.addEventListener('DOMContentLoaded', function() {
            // GCS calculation function
            function calculateGCS() {
                const mata = parseInt(document.getElementById('gcs_mata').value) || 0;
                const verbal = parseInt(document.getElementById('gcs_verbal').value) || 0;
                const motorik = parseInt(document.getElementById('gcs_motorik').value) || 0;

                const total = mata + verbal + motorik;
                document.getElementById('gcs_total').value = total > 0 ? total : '';

                // Add validation styling based on total
                const totalInput = document.getElementById('gcs_total');
                if (total > 0) {
                    if (total < 3 || total > 15) {
                        totalInput.classList.add('is-invalid');
                    } else {
                        totalInput.classList.remove('is-invalid');
                    }
                }
            }

            // Add event listeners to GCS components
            document.getElementById('gcs_mata').addEventListener('change', calculateGCS);
            document.getElementById('gcs_verbal').addEventListener('change', calculateGCS);
            document.getElementById('gcs_motorik').addEventListener('change', calculateGCS);

            // Time validation
            document.getElementById('jam').addEventListener('change', function() {
                const timeInput = this;
                const timeError = document.getElementById('timeError');

                if (timeInput.value) {
                    const timePattern = /^([01]\d|2[0-3]):([0-5]\d)$/;
                    if (!timePattern.test(timeInput.value)) {
                        timeInput.classList.add('is-invalid');
                        timeError.style.display = 'block';
                    } else {
                        timeInput.classList.remove('is-invalid');
                        timeError.style.display = 'none';
                    }
                }
            });

            // Form validation
            document.getElementById('icuCriteriaForm').addEventListener('submit', function(e) {
                const requiredFields = this.querySelectorAll('input[required], select[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                // Validate GCS total
                const gcsTotal = parseInt(document.getElementById('gcs_total').value);
                if (!gcsTotal || gcsTotal < 3 || gcsTotal > 15) {
                    document.getElementById('gcs_total').classList.add('is-invalid');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    alert(
                    'Mohon lengkapi semua field yang wajib diisi dan pastikan nilai GCS benar (3-15)');
                }
            });

            // Initial calculation on page load
            calculateGCS();
        });
    </script>
@endpush
