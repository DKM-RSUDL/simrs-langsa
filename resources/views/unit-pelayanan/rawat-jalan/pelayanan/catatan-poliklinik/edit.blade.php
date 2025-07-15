@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .header-section {
            background: linear-gradient(135deg, #ff7675 0%, #e17055 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }

        .header-section h3 {
            font-weight: 700;
            margin-bottom: 5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-section p {
            margin: 0;
            opacity: 0.9;
        }

        .datetime-section {
            background: #f8f9fa;
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .datetime-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .soap-info {
            background: linear-gradient(135deg, #fd79a8 0%, #e84393 100%);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            text-align: center;
        }

        .soap-info h6 {
            margin-bottom: 8px;
            font-weight: 600;
        }

        .soap-info small {
            opacity: 0.9;
            line-height: 1.4;
        }

        .soap-section {
            padding: 30px;
        }

        .soap-item {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .soap-item:hover {
            border-color: #ff7675;
            box-shadow: 0 5px 15px rgba(255, 118, 117, 0.1);
        }

        .soap-label {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            font-weight: 600;
            color: #2d3436;
        }

        .soap-badge {
            background: linear-gradient(135deg, #ff7675 0%, #e17055 100%);
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            margin-right: 12px;
            font-weight: 700;
            font-size: 14px;
            min-width: 40px;
            text-align: center;
        }

        .soap-textarea {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            font-size: 14px;
            line-height: 1.6;
            transition: border-color 0.3s ease;
            resize: vertical;
            min-height: 100px;
        }

        .soap-textarea:focus {
            border-color: #ff7675;
            box-shadow: 0 0 0 0.2rem rgba(255, 118, 117, 0.15);
            outline: none;
        }

        .soap-textarea::placeholder {
            color: #6c757d;
            font-style: italic;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #ff7675;
            box-shadow: 0 0 0 0.2rem rgba(255, 118, 117, 0.15);
        }

        .btn-group-custom {
            background: #f8f9fa;
            padding: 20px;
            border-top: 1px solid #e9ecef;
        }

        .btn {
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff7675 0%, #e17055 100%);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(255, 118, 117, 0.3);
        }

        .btn-outline-primary {
            border: 2px solid #ff7675;
            color: #ff7675;
        }

        .btn-outline-primary:hover {
            background: #ff7675;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }

        .back-btn {
            background: white;
            border: 2px solid #e9ecef;
            color: #495057;
            border-radius: 10px;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .back-btn:hover {
            border-color: #ff7675;
            color: #ff7675;
            transform: translateX(-2px);
            text-decoration: none;
        }

        .datetime-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .edit-notice {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #ffeaa7;
        }

        .edit-notice i {
            color: #f39c12;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }

        .form-group.has-error .form-control,
        .form-group.has-error .soap-textarea {
            border-color: #dc3545;
        }

        @media (max-width: 768px) {
            .soap-section {
                padding: 20px;
            }

            .datetime-section {
                padding: 15px;
            }

            .header-section {
                padding: 20px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-rajal')

            <!-- Back Button -->
            <a href="{{ route('rawat-jalan.catatan-poliklinik.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                class="back-btn">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>

            <form id="editCatatanKlinikForm" method="POST"
                action="{{ route('rawat-jalan.catatan-poliklinik.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $catatanPoliklinik->id]) }}">
                @csrf
                @method('PUT')

                <div class="card main-card">
                    <!-- Header -->
                    <div class="header-section">
                        <h3><i class="fas fa-edit me-2"></i>EDIT CATATAN KLINIK</h3>
                        <p>PASIEN RAWAT JALAN</p>
                    </div>

                    <!-- Date & Time Section -->
                    <div class="datetime-section">
                        <div class="datetime-card">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="datetime-label">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i>Tanggal Pemeriksaan
                                    </label>
                                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                        name="tanggal" value="{{ old('tanggal', $catatanPoliklinik->tanggal) }}" required>
                                    @error('tanggal')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="datetime-label">
                                        <i class="fas fa-clock me-2 text-primary"></i>Jam Pemeriksaan
                                    </label>
                                    <input type="time" class="form-control @error('jam') is-invalid @enderror"
                                        name="jam" value="{{ \Carbon\Carbon::parse($catatanPoliklinik->jam)->format('H:i') }}" required>
                                    @error('jam')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SOAP Content -->
                    <div class="soap-section">
                        <!-- Info SOAP -->
                        <div class="soap-info">
                            <h6><i class="fas fa-info-circle me-2"></i>Panduan Pengisian SOAP</h6>
                            <small>
                                Ditulis berdasarkan prinsip S-O-A-P<br>
                                Minimal anamnesis, hasil pemeriksaan fisik & penunjang, diagnosis, rencana
                                penatalaksanaan dan pengobatan, tindakan dan catatan lainnya
                            </small>
                        </div>

                        <!-- S - Subjective -->
                        <div class="soap-item">
                            <div class="soap-label">
                                <span class="soap-badge">S</span>
                                <span>Subjective</span>
                            </div>
                            <textarea class="form-control soap-textarea @error('subjective') is-invalid @enderror" name="subjective" rows="4">{{ old('subjective', $catatanPoliklinik->subjective) }}</textarea>
                            @error('subjective')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- O - Objective -->
                        <div class="soap-item">
                            <div class="soap-label">
                                <span class="soap-badge">O</span>
                                <span>Objective</span>
                            </div>
                            <textarea class="form-control soap-textarea @error('objective') is-invalid @enderror" name="objective" rows="4">{{ old('objective', $catatanPoliklinik->objective) }}</textarea>
                            @error('objective')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- A - Assessment -->
                        <div class="soap-item">
                            <div class="soap-label">
                                <span class="soap-badge">A</span>
                                <span>Assessment</span>
                            </div>
                            <textarea class="form-control soap-textarea @error('assessment') is-invalid @enderror" name="assessment" rows="3">{{ old('assessment', $catatanPoliklinik->assessment) }}</textarea>
                            @error('assessment')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- P - Plan -->
                        <div class="soap-item">
                            <div class="soap-label">
                                <span class="soap-badge">P</span>
                                <span>Plan</span>
                            </div>
                            <textarea class="form-control soap-textarea @error('plan') is-invalid @enderror" name="plan" rows="4">{{ old('plan', $catatanPoliklinik->plan) }}</textarea>
                            @error('plan')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Buttons -->
                    <div class="btn-group-custom">
                        <div class="d-flex justify-content-end align-items-center">
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Catatan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('js')
    <script>

        // Auto-resize textareas
        document.querySelectorAll('.soap-textarea').forEach(textarea => {
            // Initial resize
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';

            // Add event listener for future changes
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        });

        // Form validation
        document.getElementById('editCatatanKlinikForm').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = '#dc3545';
                    isValid = false;
                } else {
                    field.style.borderColor = '#e9ecef';
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang diperlukan!');
            }
        });

        // Character counter for textareas
        document.querySelectorAll('.soap-textarea').forEach(textarea => {
            const wrapper = textarea.parentElement;
            const counter = document.createElement('small');
            counter.className = 'text-muted mt-1 d-block text-end';
            counter.textContent = `${textarea.value.length} karakter (maksimal 255)`;
            wrapper.appendChild(counter);

            textarea.addEventListener('input', function() {
                const length = this.value.length;
                counter.textContent = `${length} karakter (maksimal 255)`;

                if (length > 255) {
                    counter.style.color = '#dc3545';
                    this.style.borderColor = '#dc3545';
                } else if (length > 200) {
                    counter.style.color = '#ffc107';
                    this.style.borderColor = '#ffc107';
                } else {
                    counter.style.color = '#6c757d';
                    this.style.borderColor = '#e9ecef';
                }
            });
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
@endpush
