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

            .previous-data {
                background-color: #f8f9fa;
                border: 1px solid #dee2e6;
                border-radius: 0.25rem;
                padding: 0.75rem;
                margin-bottom: 1rem;
                font-size: 0.875rem;
            }

            .previous-data strong {
                color: #6c757d;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold"> Edit Pengawasan Khusus Perinatology</h5>
            </div>

            <hr>

            <!-- Display Previous Data if exists -->
            @if($lastPerinatologyData)
            <div class="previous-data">
                <h6 class="mb-2"><i class="bi bi-clock-history"></i> Data Sebelumnya (Selain Yang Sedang Diedit):</h6>
                <div class="row">
                    <div class="col-md-4">
                        <strong>BBL:</strong> {{ $lastPerinatologyData->bbl ?? '-' }} gram
                    </div>
                    <div class="col-md-4">
                        <strong>BB Saat Ini:</strong> {{ $lastPerinatologyData->bbs ?? '-' }} gram
                    </div>
                    <div class="col-md-4">
                        <strong>Gestasi:</strong> {{ $lastPerinatologyData->gestasi ?? '-' }} minggu
                    </div>
                </div>
            </div>
            @endif

            <div class="form-section">
                <form action="{{ route('rawat-inap.pengawasan-perinatology.update-pengawasan-perinatology', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                                'id' => $perinatologyData->id
                            ]) }}" method="post" id="perinatologyForm">
                    @csrf
                    @method('PUT')

                    <!-- Section Informasi Pasien -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="section-title mb-0">Informasi Pasien</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label required">Berat Badan Saat Lahir (BBL)</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control" name="bbl" 
                                                id="bbl" placeholder="0.00" 
                                                value="{{ old('bbl', $perinatologyData->bbl) }}" required>
                                            <span class="input-group-text">gram</span>
                                        </div>
                                        @if($lastPerinatologyData && $lastPerinatologyData->bbl)
                                            <small class="text-muted">Sebelumnya: {{ $lastPerinatologyData->bbl }} gram</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label required">Berat Badan Saat Ini</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control" name="bb_saat_ini" 
                                                id="bb_saat_ini" placeholder="0.00" 
                                                value="{{ old('bb_saat_ini', $perinatologyData->bbs) }}" required>
                                            <span class="input-group-text">gram</span>
                                        </div>
                                        @if($lastPerinatologyData && $lastPerinatologyData->bbs)
                                            <small class="text-muted">Sebelumnya: {{ $lastPerinatologyData->bbs }} gram</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label required">Gestasi</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="gestasi" 
                                                id="gestasi" placeholder="0" 
                                                value="{{ old('gestasi', $perinatologyData->gestasi) }}" required>
                                            <span class="input-group-text">minggu</span>
                                        </div>
                                        @if($lastPerinatologyData && $lastPerinatologyData->gestasi)
                                            <small class="text-muted">Sebelumnya: {{ $lastPerinatologyData->gestasi }} minggu</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Date and Time Section -->
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
                                        <label class="form-label required">Tanggal Implementasi</label>
                                        <input type="date" class="form-control" name="tgl_implementasi"
                                            id="tgl_implementasi" 
                                            value="{{ old('tgl_implementasi', date('Y-m-d', strtotime($perinatologyData->tgl_implementasi))) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Jam Implementasi</label>
                                        <input type="time" class="form-control" name="jam_implementasi"
                                            id="jam_implementasi" 
                                            value="{{ old('jam_implementasi', date('H:i', strtotime($perinatologyData->jam_implementasi))) }}" required>
                                        <div class="invalid-feedback" id="timeError">
                                            Pastikan format jam benar (HH:MM)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Observasi -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="section-title mb-0">Observasi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Kesadaran</label>
                                        <select class="form-control" name="kesadaran" id="kesadaran" required>
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="Compos Mentis" {{ old('kesadaran', $perinatologyData->detail->kesadaran ?? '') == 'Compos Mentis' ? 'selected' : '' }}>Compos Mentis</option>
                                            <option value="Apatis" {{ old('kesadaran', $perinatologyData->detail->kesadaran ?? '') == 'Apatis' ? 'selected' : '' }}>Apatis</option>
                                            <option value="Sopor" {{ old('kesadaran', $perinatologyData->detail->kesadaran ?? '') == 'Sopor' ? 'selected' : '' }}>Sopor</option>
                                            <option value="Coma" {{ old('kesadaran', $perinatologyData->detail->kesadaran ?? '') == 'Coma' ? 'selected' : '' }}>Coma</option>
                                            <option value="Somnolen" {{ old('kesadaran', $perinatologyData->detail->kesadaran ?? '') == 'Somnolen' ? 'selected' : '' }}>Somnolen</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">TD/CRT</label>
                                        <input type="text" class="form-control" name="td_crt" 
                                            id="td_crt" placeholder="Masukkan TD/CRT" 
                                            value="{{ old('td_crt', $perinatologyData->detail->td_crt ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label required">Nadi</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="nadi" 
                                                id="nadi" placeholder="0" 
                                                value="{{ old('nadi', $perinatologyData->detail->nadi ?? '') }}" required>
                                            <span class="input-group-text">x/mnt</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label required">Nafas</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="nafas" 
                                                id="nafas" placeholder="0" 
                                                value="{{ old('nafas', $perinatologyData->detail->nafas ?? '') }}" required>
                                            <span class="input-group-text">x/mnt</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label required">Suhu</label>
                                        <div class="input-group">
                                            <input type="number" step="0.1" class="form-control" name="suhu" 
                                                id="suhu" placeholder="36.5" 
                                                value="{{ old('suhu', $perinatologyData->detail->suhu ?? '') }}" required>
                                            <span class="input-group-text">°C</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Ventilasi -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="section-title mb-0">Ventilasi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Modus</label>
                                        <input type="text" class="form-control" name="modus" id="modus" 
                                            placeholder="Masukkan Modus" value="{{ old('modus', $perinatologyData->detail->modus ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">PEP</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control" name="pep" 
                                                id="pep" placeholder="0.00" 
                                                value="{{ old('pep', $perinatologyData->detail->pep ?? '') }}">
                                            <span class="input-group-text">CM H2O</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Bubble</label>
                                        <input type="text" class="form-control" name="bubble" 
                                            id="bubble" placeholder="Masukkan nilai bubble" 
                                            value="{{ old('bubble', $perinatologyData->detail->bubble ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">FI O2</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control" name="fi_o2" 
                                                id="fi_o2" placeholder="0.00" 
                                                value="{{ old('fi_o2', $perinatologyData->detail->fi_o2 ?? '') }}">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Flow</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control" name="flow" 
                                                id="flow" placeholder="0.00" 
                                                value="{{ old('flow', $perinatologyData->detail->flow ?? '') }}">
                                            <span class="input-group-text">liter/mnt</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">SPO2</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="spo2" 
                                                id="spo2" placeholder="0" 
                                                value="{{ old('spo2', $perinatologyData->detail->spo2 ?? '') }}">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">AIR</label>
                                        <input type="text" class="form-control" name="air" 
                                            id="air" placeholder="Masukkan AIR" 
                                            value="{{ old('air', $perinatologyData->detail->air ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Suhu (Ventilator)</label>
                                        <div class="input-group">
                                            <input type="number" step="0.1" class="form-control" name="suhu_ventilator" 
                                                id="suhu_ventilator" placeholder="36.5" 
                                                value="{{ old('suhu_ventilator', $perinatologyData->detail->suhu_ventilator ?? '') }}">
                                            <span class="input-group-text">°C</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i> Update
                            </button>
                            <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/pengawasan-perinatology") }}" class="btn btn-secondary">
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
            // Time validation
            document.getElementById('jam_implementasi').addEventListener('change', function() {
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

            // Form submission validation
            document.getElementById('perinatologyForm').addEventListener('submit', function(e) {
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

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua field yang wajib diisi');
                }
            });

            // Number input validation
            const numberInputs = document.querySelectorAll('input[type="number"]');
            numberInputs.forEach(input => {
                input.addEventListener('keypress', function(e) {
                    // Allow numbers, decimal point, and control keys
                    if (!/[\d.]/.test(e.key) && !['Backspace', 'Delete', 'Tab', 'Enter'].includes(e.key)) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endpush