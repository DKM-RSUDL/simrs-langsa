@extends('layouts.administrator.master')
@include('unit-pelayanan.hemodialisa.pelayanan.hasil-ekg.include')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-hemodialisa')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Detail Hasil Pemeriksaan Elektrokardiografi (EKG)',
                ])

                <form action="" method="">
                    @csrf
                    <div class="card-body">
                        <!-- Lead EKG Section -->
                        <div class="card mb-4 border-success mt-4">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><i class="fas fa-chart-line me-2"></i>Hasil Lead EKG</h6>
                            </div>
                            <div class="card-body">
                                <!-- Lead Standar -->
                                <h6 class="text-muted mb-3 mt-2">Lead Standar</h6>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">LEAD I</label>
                                    <textarea class="form-control @error('lead_i') is-invalid @enderror" name="lead_i" rows="4"
                                        style="min-height: 100px;" disabled>{{ old('lead_i', $hasilEkg->lead_i) }}</textarea>
                                    @error('lead_i')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">LEAD II</label>
                                    <textarea class="form-control @error('lead_ii') is-invalid @enderror" name="lead_ii" rows="4"
                                        style="min-height: 100px;" disabled>{{ old('lead_ii', $hasilEkg->lead_ii) }}</textarea>
                                    @error('lead_ii')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">LEAD III</label>
                                    <textarea class="form-control @error('lead_iii') is-invalid @enderror" name="lead_iii" rows="4"
                                        style="min-height: 100px;" disabled>{{ old('lead_iii', $hasilEkg->lead_iii) }}</textarea>
                                    @error('lead_iii')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Lead Augmented -->
                                <h6 class="text-muted mb-3">Lead Augmented</h6>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">LEAD AVR</label>
                                    <textarea class="form-control @error('lead_avr') is-invalid @enderror" name="lead_avr" rows="4"
                                        style="min-height: 100px;" disabled>{{ old('lead_avr', $hasilEkg->lead_avr) }}</textarea>
                                    @error('lead_avr')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">LEAD AVL</label>
                                    <textarea class="form-control @error('lead_avl') is-invalid @enderror" name="lead_avl" rows="4"
                                        style="min-height: 100px;" disabled>{{ old('lead_avl', $hasilEkg->lead_avl) }}</textarea>
                                    @error('lead_avl')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">LEAD AVF</label>
                                    <textarea class="form-control @error('lead_avf') is-invalid @enderror" name="lead_avf" rows="4"
                                        style="min-height: 100px;" disabled>{{ old('lead_avf', $hasilEkg->lead_avf) }}</textarea>
                                    @error('lead_avf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Lead Precordial V1-V3 -->
                                <h6 class="text-muted mb-3">Lead Precordial V1-V3</h6>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">LEAD V1</label>
                                    <textarea class="form-control @error('lead_v1') is-invalid @enderror" name="lead_v1" rows="4"
                                        style="min-height: 100px;" disabled>{{ old('lead_v1', $hasilEkg->lead_v1) }}</textarea>
                                    @error('lead_v1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">LEAD V2</label>
                                    <textarea class="form-control @error('lead_v2') is-invalid @enderror" name="lead_v2" rows="4"
                                        style="min-height: 100px;" disabled>{{ old('lead_v2', $hasilEkg->lead_v2) }}</textarea>
                                    @error('lead_v2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">LEAD V3</label>
                                    <textarea class="form-control @error('lead_v3') is-invalid @enderror" name="lead_v3" rows="4"
                                        style="min-height: 100px;" disabled>{{ old('lead_v3', $hasilEkg->lead_v3) }}</textarea>
                                    @error('lead_v3')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Lead Precordial V4-V6 -->
                                <h6 class="text-muted mb-3">Lead Precordial V4-V6</h6>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">LEAD V4</label>
                                    <textarea class="form-control @error('lead_v4') is-invalid @enderror" name="lead_v4" rows="4"
                                        style="min-height: 100px;" disabled>{{ old('lead_v4', $hasilEkg->lead_v4) }}</textarea>
                                    @error('lead_v4')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">LEAD V5</label>
                                    <textarea class="form-control @error('lead_v5') is-invalid @enderror" name="lead_v5" rows="4"
                                        style="min-height: 100px;" disabled>{{ old('lead_v5', $hasilEkg->lead_v5) }}</textarea>
                                    @error('lead_v5')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">LEAD V6</label>
                                    <textarea class="form-control @error('lead_v6') is-invalid @enderror" name="lead_v6" rows="4"
                                        style="min-height: 100px;" disabled>{{ old('lead_v6', $hasilEkg->lead_v6) }}</textarea>
                                    @error('lead_v6')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Diagnosis dan Hasil -->
                        <div class="card mb-4 border-warning">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0"><i class="fas fa-stethoscope me-2"></i>Diagnosis dan Hasil</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-clipboard-check me-1"></i>Diagnosis
                                        </label>
                                        <textarea class="form-control diagnosis-textarea @error('diagnosis') is-invalid @enderror" name="diagnosis"
                                            rows="10" style="min-height: 250px; resize: vertical;" disabled>{{ old('diagnosis', $hasilEkg->diagnosis) }}</textarea>
                                        @error('diagnosis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row g-3 mt-3">
                                    <!-- Tanggal -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-calendar me-1"></i>Tanggal <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                            name="tanggal" value="{{ old('tanggal', $hasilEkg->tanggal) }}" required
                                            disabled>
                                        @error('tanggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Jam -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-clock me-1"></i>Jam <span class="text-danger">*</span>
                                        </label>
                                        <input type="time" class="form-control @error('jam') is-invalid @enderror"
                                            name="jam"
                                            value="{{ old('jam', $hasilEkg->jam ? date('H:i', strtotime($hasilEkg->jam)) : '') }}"
                                            required disabled>
                                        @error('jam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Petugas Section -->
                        <div class="card mb-4 border-secondary">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0"><i class="fas fa-user-md me-2"></i>Informasi Petugas</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-user-nurse me-1"></i>Nama Perawat
                                        </label>
                                        <select class="form-control select2" style="width: 100%" name="kd_perawat"
                                            disabled>
                                            <option value="">Pilih Perawat</option>
                                            @foreach ($perawat as $staff)
                                                <option value="{{ $staff->kd_karyawan }}"
                                                    {{ old('kd_perawat', $hasilEkg->kd_perawat) == $staff->kd_karyawan ? 'selected' : '' }}>
                                                    {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                    ({{ $staff->profesi ?? 'Perawat' }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kd_perawat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-user-md me-1"></i>Nama Dokter
                                        </label>
                                        <select name="kd_dokter" id="dokter_pelaksana" class="form-select select2"
                                            disabled>
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $item)
                                                <option value="{{ $item->kd_dokter }}"
                                                    {{ old('kd_dokter', $hasilEkg->kd_dokter) == $item->kd_dokter ? 'selected' : '' }}
                                                    disabled>
                                                    {{ $item->nama_lengkap }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kd_dokter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
        </div>
        </form>
        </x-content-card>
    </div>
    </div>
@endsection

@push('js')
    <script>
        // Auto-resize textareas with enhanced functionality
        document.querySelectorAll('textarea').forEach(textarea => {
            // Set minimum height for diagnosis textarea
            if (textarea.name === 'diagnosis') {
                textarea.style.minHeight = '250px';
            }

            // Auto-resize function
            const autoResize = function() {
                this.style.height = 'auto';
                const minHeight = textarea.name === 'diagnosis' ? 250 : parseInt(getComputedStyle(this)
                    .lineHeight) * 3;
                this.style.height = Math.max(this.scrollHeight, minHeight) + 'px';
            };

            // Apply auto-resize on input and initial load
            textarea.addEventListener('input', autoResize);
            textarea.addEventListener('focus', autoResize);
            autoResize.call(textarea); // Initial call
        });

        // Enhanced form validation before submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const tanggal = document.querySelector('input[name="tanggal"]').value;
            const jam = document.querySelector('input[name="jam"]').value;

            // Basic validation
            if (!tanggal || !jam) {
                e.preventDefault();
                alert('Tanggal dan Jam wajib diisi!');
                return false;
            }

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan Perubahan...';
        });

        // Auto-dismiss success alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-success');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Enhanced visual feedback for filled fields
        document.querySelectorAll('textarea, input[type="text"], input[type="date"], input[type="time"]').forEach(field => {
            // Check on blur (when field loses focus)
            field.addEventListener('blur', function() {
                if (this.value.trim()) {
                    this.classList.add('border-success');
                    this.classList.remove('border-danger');
                } else {
                    this.classList.remove('border-success');
                    if (this.hasAttribute('required')) {
                        this.classList.add('border-danger');
                    }
                }
            });

            // Remove error styling on focus
            field.addEventListener('focus', function() {
                this.classList.remove('border-danger');
            });

            // Real-time validation for required fields
            field.addEventListener('input', function() {
                if (this.hasAttribute('required') && this.value.trim()) {
                    this.classList.remove('border-danger');
                }
            });
        });

        // Character counter for diagnosis textarea
        const diagnosisTextarea = document.querySelector('textarea[name="diagnosis"]');
        if (diagnosisTextarea) {
            const charCounter = document.createElement('div');
            charCounter.className = 'form-text text-end';
            charCounter.style.marginTop = '5px';
            diagnosisTextarea.parentNode.appendChild(charCounter);

            const updateCharCount = function() {
                const length = this.value.length;
                charCounter.textContent = length + ' karakter';
                charCounter.style.color = length > 1000 ? '#dc3545' : '#6c757d';
            };

            diagnosisTextarea.addEventListener('input', updateCharCount);
            updateCharCount.call(diagnosisTextarea); // Initial call
        }

        // Enhanced keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+S to save
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                document.querySelector('form').dispatchEvent(new Event('submit', {
                    cancelable: true
                }));
            }

            // Escape to cancel
            if (e.key === 'Escape') {
                window.location.href =
                    "{{ route('hemodialisa.pelayanan.hasil-ekg.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $hasilEkg->id]) }}";
            }
        });

        // Initialize Select2 if available
        if (typeof $.fn.select2 !== 'undefined') {
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
        }

        // Form change detection
        let originalFormData = new FormData(document.querySelector('form'));
        let hasChanged = false;

        document.querySelectorAll('input, textarea, select').forEach(field => {
            field.addEventListener('change', function() {
                hasChanged = true;
            });
        });

        // Warn before leaving if form has changes
        window.addEventListener('beforeunload', function(e) {
            if (hasChanged) {
                e.preventDefault();
                e.returnValue = 'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
            }
        });

        // Don't warn when submitting form
        document.querySelector('form').addEventListener('submit', function() {
            hasChanged = false;
        });
    </script>
@endpush

@push('css')
    <style>
        /* Custom styling for diagnosis textarea */
        .diagnosis-textarea {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            line-height: 1.5;
        }

        /* Smooth transition for form elements */
        .form-control,
        .form-select {
            transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        /* Custom focus state */
        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
        }

        /* Success state styling */
        .form-control.border-success {
            border-color: #198754 !important;
        }

        .form-control.border-success:focus {
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
        }

        /* Error state styling */
        .form-control.border-danger {
            border-color: #dc3545 !important;
        }

        .form-control.border-danger:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }

        /* Enhanced card styling */
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        /* Button hover effects */
        .btn-warning:hover {
            transform: translateY(-1px);
            box-shadow: 0 0.375rem 0.75rem rgba(0, 0, 0, 0.15);
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .diagnosis-textarea {
                min-height: 200px !important;
            }

            .btn-lg {
                font-size: 1rem;
                padding: 0.5rem 1rem;
            }
        }
    </style>
@endpush
