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

            .mpp-table {
                border-collapse: collapse;
                width: 100%;
                border: 1px solid #dee2e6;
            }

            .mpp-table th,
            .mpp-table td {
                border: 1px solid #dee2e6;
                padding: 6px;
                vertical-align: top;
            }

            .mpp-table th {
                background-color: #f8f9fa;
                font-weight: 700;
                text-align: center;
            }

            .datetime-column {
                width: 150px;
                text-align: center;
            }

            .criteria-column {
                width: 75%;
            }

            .datetime-inputs {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .datetime-inputs input {
                font-size: 0.85rem;
                padding: 0.375rem 0.5rem;
            }

            .form-control-textarea {
                min-height: 100px;
                resize: vertical;
                width: 100%;
                border: 1px solid #ced4da;
                border-radius: 0.375rem;
                padding: 0.5rem;
            }

            .section-header {
                background-color: #ffffff;
                font-weight: bold;
                text-align: center;
            }

            .rencana-row {
                background-color: #fff9f080;
            }

            .monitoring-row {
                background-color: #f0fff473;
            }

            .koordinasi-row {
                background-color: #f0f8ff7e;
            }

            .advokasi-row {
                background-color: #fff0f57c;
            }

            .hasil-row {
                background-color: #f8f9fa68;
            }

            .terminasi-row {
                background-color: #fdf2e983;
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
                cursor: pointer;
            }

            .criteria-label {
                flex: 1;
                font-size: 0.9rem;
                line-height: 1.4;
                color: #495057;
                cursor: pointer;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">FORM B - CATATAN IMPLEMENTASI MPP</h5>
            </div>

            <hr>

            <div class="form-section">
                <form
                    action="{{ route('rawat-inap.mpp.form-b.store', [
                        'kd_unit' => $kd_unit,
                        'kd_pasien' => $kd_pasien,
                        'tgl_masuk' => $tgl_masuk,
                        'urut_masuk' => $urut_masuk,
                    ]) }}"
                    method="post" id="mppImplementationForm">
                    @csrf

                    <!-- Section Dokter -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="section-title mb-0">Informasi Dokter dan Petugas</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">DPJP Utama</label>
                                        <select name="dpjp_utama" class="form-select select2" style="width: 100%">
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $dok)
                                                <option value="{{ $dok->kd_dokter }}">{{ $dok->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Dokter 1</label>
                                        <select name="dokter_1" class="form-select select2" style="width: 100%">
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $dok)
                                                <option value="{{ $dok->kd_dokter }}">{{ $dok->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Dokter 2</label>
                                        <select name="dokter_2" class="form-select select2" style="width: 100%">
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $dok)
                                                <option value="{{ $dok->kd_dokter }}">{{ $dok->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Dokter 3</label>
                                        <select name="dokter_3" class="form-select select2" style="width: 100%">
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $dok)
                                                <option value="{{ $dok->kd_dokter }}">{{ $dok->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Petugas Terkait 1</label>
                                        <select name="petugas_terkait_1" class="form-select select2" style="width: 100%">
                                            <option value="">--Pilih--</option>
                                            @foreach ($perawat as $prwt)
                                                <option value="{{ $prwt->kd_karyawan }}">
                                                    {{ "$prwt->gelar_depan $prwt->nama $prwt->gelar_belakang" }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Petugas Terkait 2</label>
                                        <select name="petugas_terkait_2" class="form-select select2" style="width: 100%">
                                            <option value="">--Pilih--</option>
                                            @foreach ($perawat as $prwt)
                                                <option value="{{ $prwt->kd_karyawan }}">
                                                    {{ "$prwt->gelar_depan $prwt->nama $prwt->gelar_belakang" }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Implementation Table -->
                    <div class="card mb-4">
                        <div class="card-body p-0">
                            <table class="mpp-table">
                                <thead>
                                    <tr>
                                        <th class="datetime-column">TANGGAL DAN JAM</th>
                                        <th class="criteria-column">CATATAN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- 1. Rencana Pelayanan Pasien -->
                                    <tr class="rencana-row">
                                        <td class="datetime-column">
                                            <div class="datetime-inputs">
                                                <input type="text" name="rencana_date"
                                                    class="form-control form-control-sm rencana-date date"
                                                    placeholder="yyyy/mm/dd" readonly>
                                                <input type="time" name="rencana_time"
                                                    class="form-control form-control-sm rencana-time">
                                            </div>
                                        </td>
                                        <td class="criteria-column">
                                            <strong>1. Rencana Pelayanan Pasien</strong><br><br>
                                            <textarea name="rencana_pelayanan" class="form-control-textarea" placeholder="Tuliskan rencana pelayanan pasien..."></textarea>
                                        </td>
                                    </tr>

                                    <!-- 2. Monitoring Pelayanan/Asuhan Pasien -->
                                    <tr class="monitoring-row">
                                        <td class="datetime-column">
                                            <div class="datetime-inputs">
                                                <input type="text" name="monitoring_date"
                                                    class="form-control form-control-sm monitoring-date date"
                                                    placeholder="yyyy/mm/dd" readonly>
                                                <input type="time" name="monitoring_time"
                                                    class="form-control form-control-sm monitoring-time">
                                            </div>
                                        </td>
                                        <td class="criteria-column">
                                            <strong>2. Monitoring Pelayanan/Asuhan Pasien Seluruh PPA</strong><br>
                                            <small class="text-muted">(Perkembangan, Kolaborasi, Verifikasi respon terhadap
                                                intervensi yang diberikan, revisi rencana asuhan termasuk preferensi
                                                perubahan, transisi pelayanan dan kendala pelayanan)</small><br><br>
                                            <textarea name="monitoring_pelayanan" class="form-control-textarea"
                                                placeholder="Tuliskan hasil monitoring pelayanan/asuhan pasien..."></textarea>
                                        </td>
                                    </tr>

                                    <!-- 3. Koordinasi Komunikasi dan Kolaborasi -->
                                    <tr class="koordinasi-row">
                                        <td class="datetime-column">
                                            <div class="datetime-inputs">
                                                <input type="text" name="koordinasi_date"
                                                    class="form-control form-control-sm koordinasi-date date"
                                                    placeholder="yyyy/mm/dd" readonly>
                                                <input type="time" name="koordinasi_time"
                                                    class="form-control form-control-sm koordinasi-time">
                                            </div>
                                        </td>
                                        <td class="criteria-column">
                                            <strong>3. Koordinasi Komunikasi dan Kolaborasi</strong><br><br>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="koordinasi[]" value="konsultasi_kolaborasi"
                                                    class="criteria-checkbox koordinasi-checkbox" id="k1">
                                                <label class="criteria-label" for="k1">Konsultasi/Kolaborasi</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="koordinasi[]" value="second_opinion"
                                                    class="criteria-checkbox koordinasi-checkbox" id="k2">
                                                <label class="criteria-label" for="k2">Second Opinion</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="koordinasi[]" value="rawat_bersama"
                                                    class="criteria-checkbox koordinasi-checkbox" id="k3">
                                                <label class="criteria-label" for="k3">Rawat Bersama/Alih
                                                    Rawat</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="koordinasi[]" value="komunikasi_edukasi"
                                                    class="criteria-checkbox koordinasi-checkbox" id="k4">
                                                <label class="criteria-label" for="k4">Komunikasi/Edukasi</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="koordinasi[]" value="rujukan"
                                                    class="criteria-checkbox koordinasi-checkbox" id="k5">
                                                <label class="criteria-label" for="k5">Rujukan</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 4. Advokasi Pelayanan Pasien -->
                                    <tr class="advokasi-row">
                                        <td class="datetime-column">
                                            <div class="datetime-inputs">
                                                <input type="text" name="advokasi_date"
                                                    class="form-control form-control-sm advokasi-date date"
                                                    placeholder="yyyy/mm/dd" readonly>
                                                <input type="time" name="advokasi_time"
                                                    class="form-control form-control-sm advokasi-time">
                                            </div>
                                        </td>
                                        <td class="criteria-column">
                                            <strong>4. Advokasi Pelayanan Pasien</strong><br><br>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="advokasi[]" value="diskusi_ppa"
                                                    class="criteria-checkbox advokasi-checkbox" id="a1">
                                                <label class="criteria-label" for="a1">Diskusi dengan PPA staf lain
                                                    tentang kebutuhan pasien</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="advokasi[]" value="fasilitasi_akses"
                                                    class="criteria-checkbox advokasi-checkbox" id="a2">
                                                <label class="criteria-label" for="a2">Memfasilitasi akses ke
                                                    pelayanan sesuai kebutuhan pasien berkoordinasi dengan PPA dan pemangku
                                                    kepentingan</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="advokasi[]" value="kemandirian_keputusan"
                                                    class="criteria-checkbox advokasi-checkbox" id="a3">
                                                <label class="criteria-label" for="a3">Meningkatkan kemandirian
                                                    untuk menentukan pilihan/pengambilan keputusan</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="advokasi[]" value="pencegahan_disparitas"
                                                    class="criteria-checkbox advokasi-checkbox" id="a4">
                                                <label class="criteria-label" for="a4">Mengenali, mencegah,
                                                    menghindari disparitas untuk mengakses mutu dan hasil pelayanan terkait
                                                    dengan ras, etnik, agama, gender, budaya, status pernikahan, usia,
                                                    politik, disabilitas fisik mental-kognitif</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="advokasi[]" value="pemenuhan_kebutuhan"
                                                    class="criteria-checkbox advokasi-checkbox" id="a5">
                                                <label class="criteria-label" for="a5">Pemenuhan kebutuhan pelayanan
                                                    yang berkembang/bertambah karena perubahan kondisi</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 5. Hasil Pelayanan -->
                                    <tr class="hasil-row">
                                        <td class="datetime-column">
                                            <div class="datetime-inputs">
                                                <input type="text" name="hasil_date"
                                                    class="form-control form-control-sm hasil-date date"
                                                    placeholder="yyyy/mm/dd" readonly>
                                                <input type="time" name="hasil_time"
                                                    class="form-control form-control-sm hasil-time">
                                            </div>
                                        </td>
                                        <td class="criteria-column">
                                            <strong>5. Hasil Pelayanan</strong><br><br>
                                            <textarea name="hasil_pelayanan" class="form-control-textarea" placeholder="Tuliskan hasil pelayanan..."></textarea>
                                        </td>
                                    </tr>

                                    <!-- 6. Terminasi Manajemen Pelayanan -->
                                    <tr class="terminasi-row">
                                        <td class="datetime-column">
                                            <div class="datetime-inputs">
                                                <input type="text" name="terminasi_date"
                                                    class="form-control form-control-sm terminasi-date date"
                                                    placeholder="yyyy/mm/dd" readonly>
                                                <input type="time" name="terminasi_time"
                                                    class="form-control form-control-sm terminasi-time">
                                            </div>
                                        </td>
                                        <td class="criteria-column">
                                            <strong>6. Terminasi Manajemen Pelayanan Pasien, Catatan kepuasan
                                                pasien/keluarga dengan MPP</strong><br>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="terminasi[]" value="puas"
                                                    class="criteria-checkbox terminasi-checkbox" id="t1">
                                                <label class="criteria-label" for="t1">Puas</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="terminasi[]" value="tidak_puas"
                                                    class="criteria-checkbox terminasi-checkbox" id="t2">
                                                <label class="criteria-label" for="t2">Tidak Puas</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="terminasi[]" value="abstain"
                                                    class="criteria-checkbox terminasi-checkbox" id="t3">
                                                <label class="criteria-label" for="t3">Abstain</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="terminasi[]" value="konflik_komplain"
                                                    class="criteria-checkbox terminasi-checkbox" id="t4">
                                                <label class="criteria-label" for="t4">Konflik/Komplain</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="terminasi[]" value="keuangan"
                                                    class="criteria-checkbox terminasi-checkbox" id="t5">
                                                <label class="criteria-label" for="t5">Masalah Keuangan</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="terminasi[]" value="pulang_sembuh"
                                                    class="criteria-checkbox terminasi-checkbox" id="t6">
                                                <label class="criteria-label" for="t6">Pasien Pulang Sembuh</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="terminasi[]" value="rujuk"
                                                    class="criteria-checkbox terminasi-checkbox" id="t7">
                                                <label class="criteria-label" for="t7">Rujuk</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="terminasi[]" value="meninggal"
                                                    class="criteria-checkbox terminasi-checkbox" id="t8">
                                                <label class="criteria-label" for="t8">Meninggal</label>
                                            </div>
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
                            <a href="{{ route('rawat-inap.mpp.form-b.index', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                            ]) }}"
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
            // Initialize Select2 if available
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    placeholder: '--Pilih--'
                });
            }

            // Form validation
            document.getElementById('mppImplementationForm').addEventListener('submit', function(e) {
                let isValid = true;

                // Define sections for validation
                const sections = [{
                        textareaName: 'rencana_pelayanan',
                        dateClass: 'rencana-date',
                        timeClass: 'rencana-time'
                    },
                    {
                        textareaName: 'monitoring_pelayanan',
                        dateClass: 'monitoring-date',
                        timeClass: 'monitoring-time'
                    },
                    {
                        checkboxClass: 'koordinasi-checkbox',
                        dateClass: 'koordinasi-date',
                        timeClass: 'koordinasi-time'
                    },
                    {
                        checkboxClass: 'advokasi-checkbox',
                        dateClass: 'advokasi-date',
                        timeClass: 'advokasi-time'
                    },
                    {
                        textareaName: 'hasil_pelayanan',
                        dateClass: 'hasil-date',
                        timeClass: 'hasil-time'
                    },
                    {
                        checkboxClass: 'terminasi-checkbox',
                        dateClass: 'terminasi-date',
                        timeClass: 'terminasi-time'
                    }
                ];

                sections.forEach(section => {
                    const dateInput = document.querySelector(`.${section.dateClass}`);
                    const timeInput = document.querySelector(`.${section.timeClass}`);
                    let hasContent = false;

                    if (section.textareaName) {
                        const textarea = document.querySelector(
                            `textarea[name="${section.textareaName}"]`);
                        hasContent = textarea.value.trim();
                    } else if (section.checkboxClass) {
                        const checkboxes = document.querySelectorAll(
                            `.${section.checkboxClass}:checked`);
                        hasContent = checkboxes.length > 0;
                    }

                    if (hasContent) {
                        if (!dateInput.value.trim()) {
                            dateInput.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            dateInput.classList.remove('is-invalid');
                        }
                        if (!timeInput.value.trim()) {
                            timeInput.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            timeInput.classList.remove('is-invalid');
                        }
                    } else {
                        dateInput.classList.remove('is-invalid');
                        timeInput.classList.remove('is-invalid');
                    }
                });

                // Time format validation
                document.querySelectorAll('input[type="time"]').forEach(timeInput => {
                    if (timeInput.value && !/^([01]\d|2[0-3]):([0-5]\d)$/.test(timeInput.value)) {
                        timeInput.classList.add('is-invalid');
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert(
                        'Mohon lengkapi tanggal dan jam untuk setiap seksi yang memiliki data yang diisi.'
                    );
                }
            });

            // Real-time validation
            const sections = [{
                    textareaName: 'rencana_pelayanan',
                    dateClass: 'rencana-date',
                    timeClass: 'rencana-time'
                },
                {
                    textareaName: 'monitoring_pelayanan',
                    dateClass: 'monitoring-date',
                    timeClass: 'monitoring-time'
                },
                {
                    checkboxClass: 'koordinasi-checkbox',
                    dateClass: 'koordinasi-date',
                    timeClass: 'koordinasi-time'
                },
                {
                    checkboxClass: 'advokasi-checkbox',
                    dateClass: 'advokasi-date',
                    timeClass: 'advokasi-time'
                },
                {
                    textareaName: 'hasil_pelayanan',
                    dateClass: 'hasil-date',
                    timeClass: 'hasil-time'
                },
                {
                    checkboxClass: 'terminasi-checkbox',
                    dateClass: 'terminasi-date',
                    timeClass: 'terminasi-time'
                }
            ];

            sections.forEach(section => {
                const dateInput = document.querySelector(`.${section.dateClass}`);
                const timeInput = document.querySelector(`.${section.timeClass}`);

                if (section.textareaName) {
                    const textarea = document.querySelector(`textarea[name="${section.textareaName}"]`);
                    textarea.addEventListener('input', function() {
                        const hasContent = this.value.trim();
                        if (hasContent) {
                            if (!dateInput.value.trim()) {
                                dateInput.classList.add('is-invalid');
                            }
                            if (!timeInput.value.trim()) {
                                timeInput.classList.add('is-invalid');
                            }
                        } else {
                            dateInput.classList.remove('is-invalid');
                            timeInput.classList.remove('is-invalid');
                        }
                    });
                }

                if (section.checkboxClass) {
                    const checkboxes = document.querySelectorAll(`.${section.checkboxClass}`);
                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            const anyChecked = Array.from(checkboxes).some(cb => cb
                                .checked);
                            if (anyChecked) {
                                if (!dateInput.value.trim()) {
                                    dateInput.classList.add('is-invalid');
                                }
                                if (!timeInput.value.trim()) {
                                    timeInput.classList.add('is-invalid');
                                }
                            } else {
                                dateInput.classList.remove('is-invalid');
                                timeInput.classList.remove('is-invalid');
                            }
                        });
                    });
                }

                // Date and time input validation
                dateInput.addEventListener('change', function() {
                    let hasContent = false;
                    if (section.textareaName) {
                        const textarea = document.querySelector(
                            `textarea[name="${section.textareaName}"]`);
                        hasContent = textarea.value.trim();
                    } else if (section.checkboxClass) {
                        const checkboxes = document.querySelectorAll(`.${section.checkboxClass}`);
                        hasContent = Array.from(checkboxes).some(cb => cb.checked);
                    }
                    if (hasContent && this.value.trim()) {
                        this.classList.remove('is-invalid');
                    } else if (hasContent && !this.value.trim()) {
                        this.classList.add('is-invalid');
                    }
                });

                timeInput.addEventListener('change', function() {
                    let hasContent = false;
                    if (section.textareaName) {
                        const textarea = document.querySelector(
                            `textarea[name="${section.textareaName}"]`);
                        hasContent = textarea.value.trim();
                    } else if (section.checkboxClass) {
                        const checkboxes = document.querySelectorAll(`.${section.checkboxClass}`);
                        hasContent = Array.from(checkboxes).some(cb => cb.checked);
                    }
                    if (hasContent && this.value.trim() && /^([01]\d|2[0-3]):([0-5]\d)$/.test(this
                            .value)) {
                        this.classList.remove('is-invalid');
                    } else if (hasContent && !this.value.trim()) {
                        this.classList.add('is-invalid');
                    }
                });
            });
        });
    </script>
@endpush
