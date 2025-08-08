@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: #2c3e50;
        }

        .header-asesmen {
            margin-top: 0.5rem;
            font-size: 1.5rem;
            font-weight: 600;
            color: #00223b;
            text-align: center;
            margin-bottom: 1rem;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        .form-section {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            border-bottom: 2px solid #097dd6;
            padding-bottom: 0.25rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.3rem;
            display: block;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #ced4da;
            padding: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        .datetime-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .datetime-item label {
            font-weight: 500;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .radio-item {
            display: flex;
            align-items: center;
            background-color: white;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .radio-item:hover {
            border-color: #097dd6;
            background-color: #f8f9fa;
        }

        .radio-item input[type="radio"] {
            margin-right: 0.5rem;
            margin-bottom: 0;
            transform: scale(1.2);
            cursor: pointer;
        }

        .radio-item label {
            margin-bottom: 0;
            cursor: pointer;
            font-weight: 500;
            color: #495057;
            flex: 1;
        }

        .radio-item input[type="radio"]:checked+label {
            color: #097dd6;
            font-weight: 600;
        }

        .radio-item:has(input[type="radio"]:checked) {
            border-color: #097dd6;
            background-color: #e3f2fd;
        }

        /* Card-based styling untuk mengganti table */
        .tindakan-card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .tindakan-card:hover {
            box-shadow: 0 4px 12px rgba(9, 125, 214, 0.15);
            border-color: #097dd6;
        }

        .tindakan-header {
            background: linear-gradient(135deg, #097dd6 0%, #0056b3 100%);
            color: white;
            padding: 1rem;
            border-radius: 10px 10px 0 0;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tindakan-header .badge {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.3rem 0.6rem;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .sub-tindakan {
            border: 2px solid #f1f3f4;
            border-radius: 8px;
            margin: 1rem;
            background: #fafbfc;
            transition: all 0.3s ease;
        }

        .sub-tindakan:hover {
            border-color: #097dd6;
            background: #f8fdff;
        }

        .sub-tindakan.active {
            border-color: #097dd6;
            background: #e3f2fd;
        }

        .sub-tindakan-header {
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 0.75rem 1rem;
            font-weight: 600;
            color: #495057;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 6px 6px 0 0;
        }

        .sub-tindakan-header .toggle-indicator {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .sub-tindakan.active .toggle-indicator {
            background: #097dd6;
            border-color: #097dd6;
            color: white;
        }

        .sub-tindakan-body {
            padding: 1rem;
            display: none;
        }

        .sub-tindakan.active .sub-tindakan-body {
            display: block;
        }

        .field-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .field-item {
            display: flex;
            flex-direction: column;
        }

        .field-item label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 0.3rem;
        }

        .field-item input {
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 0.5rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .field-item input:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
            outline: none;
        }

        .field-item.full-width {
            grid-column: 1 / -1;
        }

        .date-range-group {
            display: grid;
            grid-template-columns: 1fr auto 1fr auto;
            gap: 0.5rem;
            align-items: end;
        }

        .date-range-separator {
            font-weight: bold;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .info-badge {
            display: inline-flex;
            align-items: center;
            background: #e3f2fd;
            color: #0277bd;
            padding: 0.25rem 0.5rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 500;
            margin-left: 0.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
            font-style: italic;
        }

        .sub-tindakan.has-custom-data {
            border-color: #28a745 !important;
            background: #f8fff9 !important;
        }

        .sub-tindakan-header input[type="text"] {
            transition: all 0.3s ease;
        }

        .sub-tindakan-header input[type="text"]:focus {
            border-color: #097dd6 !important;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25) !important;
            outline: none;
        }

        .form-label-small {
            font-weight: 500;
            margin-bottom: 0.3rem;
            color: #495057;
            font-size: 0.85rem;
        }

        .room-transfer-item {
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .room-transfer-item:hover {
            border-color: #097dd6;
            background-color: #f0f8ff;
        }

        .room-transfer-item.multiple {
            background-color: #fff3cd;
            border-color: #ffc107;
        }

        .btn-remove-room {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .btn-remove-room:hover {
            background-color: #c82333;
            border-color: #bd2130;
            color: white;
        }

        .room-transfer-header {
            font-size: 0.9rem;
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 0.5rem;
            padding-bottom: 0.25rem;
            border-bottom: 1px solid #dee2e6;
        }

        @media (max-width: 768px) {
            .room-transfer-item .row {
                margin: 0;
            }
            
            .room-transfer-item .col-md-5,
            .room-transfer-item .col-md-2 {
                padding: 0 0.25rem;
                margin-bottom: 0.5rem;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .datetime-group {
                grid-template-columns: 1fr;
            }

            .radio-group {
                flex-direction: column;
                gap: 0.25rem;
            }

            .radio-item {
                min-width: 100%;
            }

            .field-group {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .date-range-group {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .tindakan-header {
                padding: 0.75rem;
                font-size: 1rem;
            }

            .sub-tindakan {
                margin: 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .form-section {
                padding: 0.5rem;
            }

            .tindakan-card {
                margin-bottom: 1rem;
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
            <a href="{{ route('rawat-inap.surveilans-ppi.a1.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form id="painAssessmentForm" method="POST"
                action="{{ route('rawat-inap.surveilans-ppi.a1.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $surveilans->id]) }}">
                @csrf
                @method('PUT')

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="header-asesmen">Edit Form Surveilans PPI (PENCEGAHAN DAN PENGENDALIAN INFEKSI) A1</h4>

                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <h5 class="section-title">Informasi Dasar</h5>

                            <div class="form-group">
                                <label class="form-label">Tanggal dan Jam Implementasi</label>
                                <div class="datetime-group">
                                    <div class="datetime-item">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_implementasi"
                                            id="tanggal_implementasi" value="{{ $surveilans->tanggal_implementasi }}" required>
                                    </div>
                                    <div class="datetime-item">
                                        <label>Jam</label>
                                        <input type="time" class="form-control" name="jam_implementasi"
                                            id="jam_implementasi" value="{{ date('H:i:s', strtotime($surveilans->jam_implementasi)) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Cara Dirawat</label>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input type="radio" name="cara_dirawat" id="emergency" value="Emergency" 
                                            {{ $surveilans->cara_dirawat == 'Emergency' ? 'checked' : '' }} required>
                                        <label for="emergency">Emergency</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" name="cara_dirawat" id="elektif" value="Elektif" 
                                            {{ $surveilans->cara_dirawat == 'Elektif' ? 'checked' : '' }} required>
                                        <label for="elektif">Elektif</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Asal Masuk</label>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input type="radio" name="asal_masuk" id="dari_rumah" value="Dari rumah" 
                                            {{ $surveilans->asal_masuk == 'Dari rumah' ? 'checked' : '' }} required>
                                        <label for="dari_rumah">Dari Rumah</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" name="asal_masuk" id="rujukan" value="Rujukan" 
                                            {{ $surveilans->asal_masuk == 'Rujukan' ? 'checked' : '' }} required>
                                        <label for="rujukan">Rujukan</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Pindah ke Ruangan</label>
                                <div id="room-transfer-container">
                                    <!-- Room transfer fields will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>

                        <!-- Faktor Resiko Section -->
                        <div class="form-section">
                            <h5 class="section-title">Faktor Risiko Selama Dirawat</h5>

                            <!-- 1. Intra Vena Kateter -->
                            <div class="tindakan-card">
                                <div class="tindakan-header">
                                    <span class="badge">1</span>
                                    <i class="fas fa-syringe"></i>
                                    Intra Vena Kateter
                                </div>

                                <!-- a. Vena Sentral -->
                                <div class="sub-tindakan">
                                    <div class="sub-tindakan-header">
                                        <span>a. Vena Sentral</span>
                                        <div class="toggle-indicator">+</div>
                                    </div>
                                    <div class="sub-tindakan-body">
                                        <div class="field-group">
                                            <div class="field-item">
                                                <label>Lokasi</label>
                                                <input type="text" name="lokasi_vena_sentral"
                                                    placeholder="Masukkan lokasi">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan Mulai</label>
                                                <input type="date" name="tgl_mulai_vena_sentral">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan s/d</label>
                                                <input type="date" name="tgl_selesai_vena_sentral">
                                            </div>
                                            <div class="field-item">
                                                <label>Total Hari</label>
                                                <input type="text" name="total_hari_vena_sentral"
                                                    placeholder="Auto calculated" readonly>
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Infeksi</label>
                                                <input type="date" name="tgl_infeksi_vena_sentral">
                                            </div>
                                            <div class="field-item full-width">
                                                <label>Catatan</label>
                                                <input type="text" name="catatan_vena_sentral"
                                                    placeholder="Masukkan catatan tambahan">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- b. Vena Perifer -->
                                <div class="sub-tindakan">
                                    <div class="sub-tindakan-header">
                                        <span>b. Vena Perifer</span>
                                        <div class="toggle-indicator">+</div>
                                    </div>
                                    <div class="sub-tindakan-body">
                                        <div class="field-group">
                                            <div class="field-item">
                                                <label>Lokasi</label>
                                                <input type="text" name="lokasi_vena_perifer"
                                                    placeholder="Masukkan lokasi">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan Mulai</label>
                                                <input type="date" name="tgl_mulai_vena_perifer">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan s/d</label>
                                                <input type="date" name="tgl_selesai_vena_perifer">
                                            </div>
                                            <div class="field-item">
                                                <label>Total Hari</label>
                                                <input type="text" name="total_hari_vena_perifer"
                                                    placeholder="Auto calculated" readonly>
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Infeksi</label>
                                                <input type="date" name="tgl_infeksi_vena_perifer">
                                            </div>
                                            <div class="field-item full-width">
                                                <label>Catatan</label>
                                                <input type="text" name="catatan_vena_perifer"
                                                    placeholder="Masukkan catatan tambahan">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- c. Heparin Log -->
                                <div class="sub-tindakan">
                                    <div class="sub-tindakan-header">
                                        <span>c. Heparin Log</span>
                                        <div class="toggle-indicator">+</div>
                                    </div>
                                    <div class="sub-tindakan-body">
                                        <div class="field-group">
                                            <div class="field-item">
                                                <label>Lokasi</label>
                                                <input type="text" name="lokasi_heparin_log"
                                                    placeholder="Masukkan lokasi">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan Mulai</label>
                                                <input type="date" name="tgl_mulai_heparin_log">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan s/d</label>
                                                <input type="date" name="tgl_selesai_heparin_log">
                                            </div>
                                            <div class="field-item">
                                                <label>Total Hari</label>
                                                <input type="text" name="total_hari_heparin_log"
                                                    placeholder="Auto calculated" readonly>
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Infeksi</label>
                                                <input type="date" name="tgl_infeksi_heparin_log">
                                            </div>
                                            <div class="field-item full-width">
                                                <label>Catatan</label>
                                                <input type="text" name="catatan_heparin_log"
                                                    placeholder="Masukkan catatan tambahan">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- d. Umbilikal -->
                                <div class="sub-tindakan">
                                    <div class="sub-tindakan-header">
                                        <span>d. Umbilikal</span>
                                        <div class="toggle-indicator">+</div>
                                    </div>
                                    <div class="sub-tindakan-body">
                                        <div class="field-group">
                                            <div class="field-item">
                                                <label>Lokasi</label>
                                                <input type="text" name="lokasi_umbilikal"
                                                    placeholder="Masukkan lokasi">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan Mulai</label>
                                                <input type="date" name="tgl_mulai_umbilikal">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan s/d</label>
                                                <input type="date" name="tgl_selesai_umbilikal">
                                            </div>
                                            <div class="field-item">
                                                <label>Total Hari</label>
                                                <input type="text" name="total_hari_umbilikal"
                                                    placeholder="Auto calculated" readonly>
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Infeksi</label>
                                                <input type="date" name="tgl_infeksi_umbilikal">
                                            </div>
                                            <div class="field-item full-width">
                                                <label>Catatan</label>
                                                <input type="text" name="catatan_umbilikal"
                                                    placeholder="Masukkan catatan tambahan">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Kateter -->
                            <div class="tindakan-card">
                                <div class="tindakan-header">
                                    <span class="badge">2</span>
                                    <i class="fas fa-procedures"></i>
                                    Kateter
                                </div>

                                <!-- a. Kateter Urine -->
                                <div class="sub-tindakan">
                                    <div class="sub-tindakan-header">
                                        <span>a. Kateter Urine</span>
                                        <div class="toggle-indicator">+</div>
                                    </div>
                                    <div class="sub-tindakan-body">
                                        <div class="field-group">
                                            <div class="field-item">
                                                <label>Lokasi</label>
                                                <input type="text" name="lokasi_kateter_urine"
                                                    placeholder="Masukkan lokasi">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan Mulai</label>
                                                <input type="date" name="tgl_mulai_kateter_urine">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan s/d</label>
                                                <input type="date" name="tgl_selesai_kateter_urine">
                                            </div>
                                            <div class="field-item">
                                                <label>Total Hari</label>
                                                <input type="text" name="total_hari_kateter_urine"
                                                    placeholder="Auto calculated" readonly>
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Infeksi</label>
                                                <input type="date" name="tgl_infeksi_kateter_urine">
                                            </div>
                                            <div class="field-item full-width">
                                                <label>Catatan</label>
                                                <input type="text" name="catatan_kateter_urine"
                                                    placeholder="Masukkan catatan tambahan">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- b. Custom Kateter -->
                                <div class="sub-tindakan">
                                    <div class="sub-tindakan-header">
                                        <div style="display: flex; align-items: center; gap: 10px; width: 100%;">
                                            <input type="text" name="nama_kateter_custom"
                                                placeholder="Masukkan jenis kateter (misal: Kateter Epidural, CVP, dll)"
                                                style="flex: 1; border: 1px solid #ced4da; border-radius: 4px; padding: 5px 10px; font-size: 14px;"
                                                onchange="updateSubTindakanHeader(this)">
                                            <small style="color: #6c757d; font-style: italic;">Opsional</small>
                                        </div>
                                        <div class="toggle-indicator">+</div>
                                    </div>
                                    <div class="sub-tindakan-body">
                                        <div class="field-group">
                                            <div class="field-item">
                                                <label>Lokasi</label>
                                                <input type="text" name="lokasi_kateter_b"
                                                    placeholder="Masukkan lokasi">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan Mulai</label>
                                                <input type="date" name="tgl_mulai_kateter_b">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan s/d</label>
                                                <input type="date" name="tgl_selesai_kateter_b">
                                            </div>
                                            <div class="field-item">
                                                <label>Total Hari</label>
                                                <input type="text" name="total_hari_kateter_b"
                                                    placeholder="Auto calculated" readonly>
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Infeksi</label>
                                                <input type="date" name="tgl_infeksi_kateter_b">
                                            </div>
                                            <div class="field-item full-width">
                                                <label>Catatan</label>
                                                <input type="text" name="catatan_kateter_b"
                                                    placeholder="Masukkan catatan tambahan">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Ventilasi Mekanik -->
                            <div class="tindakan-card">
                                <div class="tindakan-header">
                                    <span class="badge">3</span>
                                    <i class="fas fa-lungs"></i>
                                    Ventilasi Mekanik
                                </div>

                                <!-- a. Endotrakeal Tube -->
                                <div class="sub-tindakan">
                                    <div class="sub-tindakan-header">
                                        <span>a. Endotrakeal Tube</span>
                                        <div class="toggle-indicator">+</div>
                                    </div>
                                    <div class="sub-tindakan-body">
                                        <div class="field-group">
                                            <div class="field-item">
                                                <label>Lokasi</label>
                                                <input type="text" name="lokasi_endotrakeal"
                                                    placeholder="Masukkan lokasi">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan Mulai</label>
                                                <input type="date" name="tgl_mulai_endotrakeal">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan s/d</label>
                                                <input type="date" name="tgl_selesai_endotrakeal">
                                            </div>
                                            <div class="field-item">
                                                <label>Total Hari</label>
                                                <input type="text" name="total_hari_endotrakeal"
                                                    placeholder="Auto calculated" readonly>
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Infeksi</label>
                                                <input type="date" name="tgl_infeksi_endotrakeal">
                                            </div>
                                            <div class="field-item full-width">
                                                <label>Catatan</label>
                                                <input type="text" name="catatan_endotrakeal"
                                                    placeholder="Masukkan catatan tambahan">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- b. Trakeostomi -->
                                <div class="sub-tindakan">
                                    <div class="sub-tindakan-header">
                                        <span>b. Trakeostomi</span>
                                        <div class="toggle-indicator">+</div>
                                    </div>
                                    <div class="sub-tindakan-body">
                                        <div class="field-group">
                                            <div class="field-item">
                                                <label>Lokasi</label>
                                                <input type="text" name="lokasi_trakeostomi"
                                                    placeholder="Masukkan lokasi">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan Mulai</label>
                                                <input type="date" name="tgl_mulai_trakeostomi">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan s/d</label>
                                                <input type="date" name="tgl_selesai_trakeostomi">
                                            </div>
                                            <div class="field-item">
                                                <label>Total Hari</label>
                                                <input type="text" name="total_hari_trakeostomi"
                                                    placeholder="Auto calculated" readonly>
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Infeksi</label>
                                                <input type="date" name="tgl_infeksi_trakeostomi">
                                            </div>
                                            <div class="field-item full-width">
                                                <label>Catatan</label>
                                                <input type="text" name="catatan_trakeostomi"
                                                    placeholder="Masukkan catatan tambahan">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- c. T. Piece -->
                                <div class="sub-tindakan">
                                    <div class="sub-tindakan-header">
                                        <span>c. T. Piece</span>
                                        <div class="toggle-indicator">+</div>
                                    </div>
                                    <div class="sub-tindakan-body">
                                        <div class="field-group">
                                            <div class="field-item">
                                                <label>Lokasi</label>
                                                <input type="text" name="lokasi_tpiece" placeholder="Masukkan lokasi">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan Mulai</label>
                                                <input type="date" name="tgl_mulai_tpiece">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan s/d</label>
                                                <input type="date" name="tgl_selesai_tpiece">
                                            </div>
                                            <div class="field-item">
                                                <label>Total Hari</label>
                                                <input type="text" name="total_hari_tpiece"
                                                    placeholder="Auto calculated" readonly>
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Infeksi</label>
                                                <input type="date" name="tgl_infeksi_tpiece">
                                            </div>
                                            <div class="field-item full-width">
                                                <label>Catatan</label>
                                                <input type="text" name="catatan_tpiece"
                                                    placeholder="Masukkan catatan tambahan">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Lain-lain -->
                            <div class="tindakan-card">
                                <div class="tindakan-header">
                                    <span class="badge">4</span>
                                    <i class="fas fa-plus-circle"></i>
                                    Lain-lain
                                    <span class="info-badge">Drain/WSD dan lainnya</span>
                                </div>

                                <!-- Lain-lain (Drain/WSD) -->
                                <div class="sub-tindakan">
                                    <div class="sub-tindakan-header">
                                        <div style="display: flex; align-items: center; gap: 10px; width: 100%;">
                                            <span style="color: #6c757d;">Lain-lain:</span>
                                            <input type="text" name="nama_lain_lain"
                                                placeholder="Masukkan jenis tindakan (misal: Drain Thorax, WSD, NGT, dll)"
                                                style="flex: 1; border: 1px solid #ced4da; border-radius: 4px; padding: 5px 10px; font-size: 14px;"
                                                onchange="updateSubTindakanHeader(this)">
                                        </div>
                                        <div class="toggle-indicator">+</div>
                                    </div>
                                    <div class="sub-tindakan-body">
                                        <div class="field-group">
                                            <div class="field-item">
                                                <label>Lokasi</label>
                                                <input type="text" name="lokasi_lain_lain"
                                                    placeholder="Masukkan lokasi">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan Mulai</label>
                                                <input type="date" name="tgl_mulai_lain_lain">
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Pemasangan s/d</label>
                                                <input type="date" name="tgl_selesai_lain_lain">
                                            </div>
                                            <div class="field-item">
                                                <label>Total Hari</label>
                                                <input type="text" name="total_hari_lain_lain"
                                                    placeholder="Auto calculated" readonly>
                                            </div>
                                            <div class="field-item">
                                                <label>Tanggal Infeksi</label>
                                                <input type="date" name="tgl_infeksi_lain_lain">
                                            </div>
                                            <div class="field-item full-width">
                                                <label>Catatan</label>
                                                <input type="text" name="catatan_lain_lain"
                                                    placeholder="Masukkan catatan tambahan">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-l px-2" id="simpan">
                                <i class="ti-save mr-2"></i> Update Data
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function updateSubTindakanHeader(input) {
            const headerDiv = input.closest('.sub-tindakan-header').querySelector('div');
            const value = input.value.trim();

            if (value) {
                // Update tampilan header dengan nilai yang diinput + tombol edit
                if (input.name === 'nama_kateter_custom') {
                    headerDiv.innerHTML = `
                        <span style="font-weight: 600; color: #097dd6;">b. ${value}</span>
                        <button type="button" 
                                onclick="editCustomName(this, 'nama_kateter_custom', '${value}')" 
                                style="background: none; border: none; color: #6c757d; cursor: pointer; margin-left: 10px; padding: 2px 6px; border-radius: 3px; font-size: 12px;"
                                title="Edit nama">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <small style="color: #6c757d; font-style: italic; margin-left: 5px;">Custom</small>
                    `;
                } else if (input.name === 'nama_lain_lain') {
                    headerDiv.innerHTML = `
                        <span style="font-weight: 600; color: #097dd6;">${value}</span>
                        <button type="button" 
                                onclick="editCustomName(this, 'nama_lain_lain', '${value}')" 
                                style="background: none; border: none; color: #6c757d; cursor: pointer; margin-left: 10px; padding: 2px 6px; border-radius: 3px; font-size: 12px;"
                                title="Edit nama">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <small style="color: #6c757d; font-style: italic; margin-left: 5px;">Custom</small>
                    `;
                }

                // Auto expand jika ada input
                const subTindakan = input.closest('.sub-tindakan');
                if (!subTindakan.classList.contains('active')) {
                    subTindakan.classList.add('active');
                    subTindakan.querySelector('.toggle-indicator').textContent = '−';
                }
            }
        }

        function editCustomName(button, fieldName, currentValue) {
            const headerDiv = button.closest('div');

            if (fieldName === 'nama_kateter_custom') {
                headerDiv.innerHTML = `
                    <input type="text" 
                        name="nama_kateter_custom" 
                        value="${currentValue}"
                        placeholder="Masukkan jenis kateter (misal: Kateter Epidural, CVP, dll)" 
                        style="flex: 1; border: 1px solid #ced4da; border-radius: 4px; padding: 5px 10px; font-size: 14px;"
                        onchange="updateSubTindakanHeader(this)"
                        onblur="updateSubTindakanHeader(this)"
                        autofocus>
                    <small style="color: #6c757d; font-style: italic;">Opsional</small>
                `;
            } else if (fieldName === 'nama_lain_lain') {
                headerDiv.innerHTML = `
                    <span style="color: #6c757d;">Lain-lain:</span>
                    <input type="text" 
                        name="nama_lain_lain" 
                        value="${currentValue}"
                        placeholder="Masukkan jenis tindakan (misal: Drain Thorax, WSD, NGT, dll)" 
                        style="flex: 1; border: 1px solid #ced4da; border-radius: 4px; padding: 5px 10px; font-size: 14px;"
                        onchange="updateSubTindakanHeader(this)"
                        onblur="updateSubTindakanHeader(this)"
                        autofocus>
                `;
            }

            // Focus ke input yang baru dibuat
            setTimeout(() => {
                headerDiv.querySelector('input').focus();
                headerDiv.querySelector('input').select(); // Select all text untuk mudah edit
            }, 100);
        }

        $(document).ready(function() {
            let roomTransferIndex = 0;

            // Data dari server untuk populate form
            const intraVenaKateter = @json($intraVenaKateter ?? []);
            const kateter = @json($kateter ?? []);
            const ventilasiMekanik = @json($ventilasiMekanik ?? []);
            const lainLain = @json($lainLain ?? []);
            const pindahKeRuangan = @json($pindahKeRuangan ?? []);

            // Populate Intra Vena Kateter Data
            if (intraVenaKateter.vena_sentral) {
                const data = intraVenaKateter.vena_sentral;
                $('input[name="lokasi_vena_sentral"]').val(data.lokasi || '');
                $('input[name="tgl_mulai_vena_sentral"]').val(data.tgl_mulai || '');
                $('input[name="tgl_selesai_vena_sentral"]').val(data.tgl_selesai || '');
                $('input[name="total_hari_vena_sentral"]').val(data.total_hari || '');
                $('input[name="tgl_infeksi_vena_sentral"]').val(data.tgl_infeksi || '');
                $('input[name="catatan_vena_sentral"]').val(data.catatan || '');
            }

            if (intraVenaKateter.vena_perifer) {
                const data = intraVenaKateter.vena_perifer;
                $('input[name="lokasi_vena_perifer"]').val(data.lokasi || '');
                $('input[name="tgl_mulai_vena_perifer"]').val(data.tgl_mulai || '');
                $('input[name="tgl_selesai_vena_perifer"]').val(data.tgl_selesai || '');
                $('input[name="total_hari_vena_perifer"]').val(data.total_hari || '');
                $('input[name="tgl_infeksi_vena_perifer"]').val(data.tgl_infeksi || '');
                $('input[name="catatan_vena_perifer"]').val(data.catatan || '');
            }

            if (intraVenaKateter.heparin_log) {
                const data = intraVenaKateter.heparin_log;
                $('input[name="lokasi_heparin_log"]').val(data.lokasi || '');
                $('input[name="tgl_mulai_heparin_log"]').val(data.tgl_mulai || '');
                $('input[name="tgl_selesai_heparin_log"]').val(data.tgl_selesai || '');
                $('input[name="total_hari_heparin_log"]').val(data.total_hari || '');
                $('input[name="tgl_infeksi_heparin_log"]').val(data.tgl_infeksi || '');
                $('input[name="catatan_heparin_log"]').val(data.catatan || '');
            }

            if (intraVenaKateter.umbilikal) {
                const data = intraVenaKateter.umbilikal;
                $('input[name="lokasi_umbilikal"]').val(data.lokasi || '');
                $('input[name="tgl_mulai_umbilikal"]').val(data.tgl_mulai || '');
                $('input[name="tgl_selesai_umbilikal"]').val(data.tgl_selesai || '');
                $('input[name="total_hari_umbilikal"]').val(data.total_hari || '');
                $('input[name="tgl_infeksi_umbilikal"]').val(data.tgl_infeksi || '');
                $('input[name="catatan_umbilikal"]').val(data.catatan || '');
            }

            // Populate Kateter Data
            if (kateter.kateter_urine) {
                const data = kateter.kateter_urine;
                $('input[name="lokasi_kateter_urine"]').val(data.lokasi || '');
                $('input[name="tgl_mulai_kateter_urine"]').val(data.tgl_mulai || '');
                $('input[name="tgl_selesai_kateter_urine"]').val(data.tgl_selesai || '');
                $('input[name="total_hari_kateter_urine"]').val(data.total_hari || '');
                $('input[name="tgl_infeksi_kateter_urine"]').val(data.tgl_infeksi || '');
                $('input[name="catatan_kateter_urine"]').val(data.catatan || '');
            }

            if (kateter.kateter_custom) {
                const data = kateter.kateter_custom;
                $('input[name="nama_kateter_custom"]').val(data.nama || '');
                $('input[name="lokasi_kateter_b"]').val(data.lokasi || '');
                $('input[name="tgl_mulai_kateter_b"]').val(data.tgl_mulai || '');
                $('input[name="tgl_selesai_kateter_b"]').val(data.tgl_selesai || '');
                $('input[name="total_hari_kateter_b"]').val(data.total_hari || '');
                $('input[name="tgl_infeksi_kateter_b"]').val(data.tgl_infeksi || '');
                $('input[name="catatan_kateter_b"]').val(data.catatan || '');
                
                // Update header untuk custom kateter
                if (data.nama) {
                    updateSubTindakanHeader($('input[name="nama_kateter_custom"]')[0]);
                }
            }

            // Populate Ventilasi Mekanik Data
            if (ventilasiMekanik.endotrakeal) {
                const data = ventilasiMekanik.endotrakeal;
                $('input[name="lokasi_endotrakeal"]').val(data.lokasi || '');
                $('input[name="tgl_mulai_endotrakeal"]').val(data.tgl_mulai || '');
                $('input[name="tgl_selesai_endotrakeal"]').val(data.tgl_selesai || '');
                $('input[name="total_hari_endotrakeal"]').val(data.total_hari || '');
                $('input[name="tgl_infeksi_endotrakeal"]').val(data.tgl_infeksi || '');
                $('input[name="catatan_endotrakeal"]').val(data.catatan || '');
            }

            if (ventilasiMekanik.trakeostomi) {
                const data = ventilasiMekanik.trakeostomi;
                $('input[name="lokasi_trakeostomi"]').val(data.lokasi || '');
                $('input[name="tgl_mulai_trakeostomi"]').val(data.tgl_mulai || '');
                $('input[name="tgl_selesai_trakeostomi"]').val(data.tgl_selesai || '');
                $('input[name="total_hari_trakeostomi"]').val(data.total_hari || '');
                $('input[name="tgl_infeksi_trakeostomi"]').val(data.tgl_infeksi || '');
                $('input[name="catatan_trakeostomi"]').val(data.catatan || '');
            }

            if (ventilasiMekanik.tpiece) {
                const data = ventilasiMekanik.tpiece;
                $('input[name="lokasi_tpiece"]').val(data.lokasi || '');
                $('input[name="tgl_mulai_tpiece"]').val(data.tgl_mulai || '');
                $('input[name="tgl_selesai_tpiece"]').val(data.tgl_selesai || '');
                $('input[name="total_hari_tpiece"]').val(data.total_hari || '');
                $('input[name="tgl_infeksi_tpiece"]').val(data.tgl_infeksi || '');
                $('input[name="catatan_tpiece"]').val(data.catatan || '');
            }

            // Populate Lain-lain Data
            if (lainLain && Object.keys(lainLain).length > 0) {
                $('input[name="nama_lain_lain"]').val(lainLain.nama || '');
                $('input[name="lokasi_lain_lain"]').val(lainLain.lokasi || '');
                $('input[name="tgl_mulai_lain_lain"]').val(lainLain.tgl_mulai || '');
                $('input[name="tgl_selesai_lain_lain"]').val(lainLain.tgl_selesai || '');
                $('input[name="total_hari_lain_lain"]').val(lainLain.total_hari || '');
                $('input[name="tgl_infeksi_lain_lain"]').val(lainLain.tgl_infeksi || '');
                $('input[name="catatan_lain_lain"]').val(lainLain.catatan || '');
                
                // Update header untuk lain-lain
                if (lainLain.nama) {
                    updateSubTindakanHeader($('input[name="nama_lain_lain"]')[0]);
                }
            }

            // Populate Pindah ke Ruangan (Multiple)
            if (pindahKeRuangan && pindahKeRuangan.length > 0) {
                // Clear container dulu
                $('#room-transfer-container').empty();
                
                pindahKeRuangan.forEach(function(room, index) {
                    if (index === 0) {
                        // First item
                        const firstItem = `
                            <div class="room-transfer-item" data-index="0">
                                <div class="row align-items-end mb-2">
                                    <div class="col-md-5">
                                        <label class="form-label-small">Ruangan Tujuan</label>
                                        <input type="text" class="form-control" name="pindah_ke_ruangan[]" 
                                               value="${room.ruangan || ''}" placeholder="Masukkan ruangan tujuan">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label-small">Tanggal Pindah</label>
                                        <input type="date" class="form-control" name="tanggal_pindah_ruangan[]"
                                               value="${room.tanggal || ''}">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-success btn-sm w-100" 
                                                onclick="addRoomTransfer()" title="Tambah ruangan">
                                            <i class="fas fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#room-transfer-container').append(firstItem);
                    } else {
                        // Additional items
                        const additionalItem = `
                            <div class="room-transfer-item multiple" data-index="${index}">
                                <div class="room-transfer-header">
                                    Perpindahan Ruangan #${index + 1}
                                </div>
                                <div class="row align-items-end mb-2">
                                    <div class="col-md-5">
                                        <label class="form-label-small">Ruangan Tujuan</label>
                                        <input type="text" class="form-control" name="pindah_ke_ruangan[]" 
                                               value="${room.ruangan || ''}" placeholder="Masukkan ruangan tujuan">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label-small">Tanggal Pindah</label>
                                        <input type="date" class="form-control" name="tanggal_pindah_ruangan[]"
                                               value="${room.tanggal || ''}">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-remove-room btn-sm w-100" 
                                                onclick="removeRoomTransfer(this)" title="Hapus ruangan">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#room-transfer-container').append(additionalItem);
                        roomTransferIndex = index; // Update counter
                    }
                });
                
                updateFirstItemButton();
            } else {
                // Initialize default room transfer field jika tidak ada data
                const defaultItem = `
                    <div class="room-transfer-item" data-index="0">
                        <div class="row align-items-end mb-2">
                            <div class="col-md-5">
                                <label class="form-label-small">Ruangan Tujuan</label>
                                <input type="text" class="form-control" name="pindah_ke_ruangan[]"
                                    placeholder="Masukkan ruangan tujuan">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label-small">Tanggal Pindah</label>
                                <input type="date" class="form-control" name="tanggal_pindah_ruangan[]">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-success btn-sm w-100"
                                    onclick="addRoomTransfer()" title="Tambah ruangan">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                $('#room-transfer-container').append(defaultItem);
            }

            // Toggle functionality untuk sub-tindakan
            $('.sub-tindakan-header').click(function() {
                const subTindakan = $(this).closest('.sub-tindakan');
                const indicator = $(this).find('.toggle-indicator');

                if (subTindakan.hasClass('active')) {
                    subTindakan.removeClass('active');
                    indicator.text('+');
                } else {
                    subTindakan.addClass('active');
                    indicator.text('−');
                }
            });

            // Auto calculate total hari when dates are selected
            $('input[type="date"]').on('change', function() {
                const name = $(this).attr('name');
                if (name && name.startsWith('tgl_mulai_')) {
                    const prefix = name.replace('tgl_mulai_', '');
                    const startDate = $(this).val();
                    const endDate = $(`input[name="tgl_selesai_${prefix}"]`).val();

                    if (startDate && endDate) {
                        const start = new Date(startDate);
                        const end = new Date(endDate);
                        const diffTime = Math.abs(end - start);
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                        $(`input[name="total_hari_${prefix}"]`).val(diffDays);
                    }
                } else if (name && name.startsWith('tgl_selesai_')) {
                    const prefix = name.replace('tgl_selesai_', '');
                    const endDate = $(this).val();
                    const startDate = $(`input[name="tgl_mulai_${prefix}"]`).val();

                    if (startDate && endDate) {
                        const start = new Date(startDate);
                        const end = new Date(endDate);
                        const diffTime = Math.abs(end - start);
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                        $(`input[name="total_hari_${prefix}"]`).val(diffDays);
                    }
                }
            });

            // Auto-expand sub-tindakan ketika user mulai mengisi data
            $('input[type="text"], input[type="date"]').on('focus', function() {
                const subTindakan = $(this).closest('.sub-tindakan');
                const indicator = subTindakan.find('.toggle-indicator');

                if (!subTindakan.hasClass('active')) {
                    subTindakan.addClass('active');
                    indicator.text('−');
                }
            });

            // Highlight active cards
            $('input[type="text"], input[type="date"]').on('input change', function() {
                const card = $(this).closest('.tindakan-card');
                const hasData = card.find('input[type="text"], input[type="date"]').filter(function() {
                    return $(this).val() !== '';
                }).length > 0;

                if (hasData) {
                    card.addClass('has-data');
                } else {
                    card.removeClass('has-data');
                }
            });

            // Auto-focus untuk custom input fields
            $('input[name="nama_kateter_custom"], input[name="nama_lain_lain"]').on('focus', function() {
                const subTindakan = $(this).closest('.sub-tindakan');
                if (!subTindakan.hasClass('active')) {
                    subTindakan.addClass('active');
                    subTindakan.find('.toggle-indicator').text('−');
                }
            });

            // Highlight ketika ada input di custom fields
            $('input[name="nama_kateter_custom"], input[name="nama_lain_lain"]').on('input', function() {
                const subTindakan = $(this).closest('.sub-tindakan');
                if ($(this).val().trim()) {
                    subTindakan.addClass('has-custom-data');
                } else {
                    subTindakan.removeClass('has-custom-data');
                }
            });

            // ==================== ROOM TRANSFER FUNCTIONS ====================
            
            // Function to add new room transfer
            window.addRoomTransfer = function() {
                roomTransferIndex++;
                const newItem = `
                    <div class="room-transfer-item multiple" data-index="${roomTransferIndex}">
                        <div class="room-transfer-header">
                            Perpindahan Ruangan #${roomTransferIndex + 1}
                        </div>
                        <div class="row align-items-end mb-2">
                            <div class="col-md-5">
                                <label class="form-label-small">Ruangan Tujuan</label>
                                <input type="text" class="form-control" name="pindah_ke_ruangan[]" 
                                       placeholder="Masukkan ruangan tujuan">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label-small">Tanggal Pindah</label>
                                <input type="date" class="form-control" name="tanggal_pindah_ruangan[]">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-remove-room btn-sm w-100" 
                                        onclick="removeRoomTransfer(this)" title="Hapus ruangan">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                $('#room-transfer-container').append(newItem);
                updateFirstItemButton();
                
                // Focus on the new room input
                setTimeout(function() {
                    $(`[data-index="${roomTransferIndex}"] input[name="pindah_ke_ruangan[]"]`).focus();
                }, 100);
            };

            // Function to remove room transfer
            window.removeRoomTransfer = function(button) {
                $(button).closest('.room-transfer-item').remove();
                updateRoomNumbers();
                updateFirstItemButton();
            };

            // Function to update room numbers
            function updateRoomNumbers() {
                $('.room-transfer-item.multiple').each(function(index) {
                    $(this).find('.room-transfer-header').text(`Perpindahan Ruangan #${index + 2}`);
                    $(this).attr('data-index', index + 1);
                });
            }

            // Function to update first item button
            function updateFirstItemButton() {
                const firstItem = $('.room-transfer-item[data-index="0"]');
                const hasMultipleItems = $('.room-transfer-item').length > 1;
                
                if (firstItem.length) {
                    const buttonCol = firstItem.find('.col-md-2');
                    if (hasMultipleItems) {
                        buttonCol.html(`
                            <button type="button" class="btn btn-outline-success btn-sm w-100 mb-1" 
                                    onclick="addRoomTransfer()" title="Tambah ruangan">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                            <button type="button" class="btn btn-remove-room btn-sm w-100" 
                                    onclick="removeRoomTransfer(this)" title="Hapus ruangan">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        `);
                    } else {
                        buttonCol.html(`
                            <button type="button" class="btn btn-outline-success btn-sm w-100" 
                                    onclick="addRoomTransfer()" title="Tambah ruangan">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        `);
                    }
                }
            }

            // Auto-expand sections yang memiliki data saat load
            $('.tindakan-card').each(function() {
                const card = $(this);
                const hasData = card.find('input[type="text"], input[type="date"]').filter(function() {
                    return $(this).val() !== '';
                }).length > 0;

                if (hasData) {
                    card.addClass('has-data');
                    // Auto-expand sub-tindakan yang memiliki data
                    card.find('.sub-tindakan').each(function() {
                        const subTindakan = $(this);
                        const hasSubData = subTindakan.find('input[type="text"], input[type="date"]').filter(function() {
                            return $(this).val() !== '';
                        }).length > 0;

                        if (hasSubData) {
                            subTindakan.addClass('active');
                            subTindakan.find('.toggle-indicator').text('−');
                        }
                    });
                }
            });

            // Initialize room transfer functionality
            updateFirstItemButton();
        });
    </script>
@endpush