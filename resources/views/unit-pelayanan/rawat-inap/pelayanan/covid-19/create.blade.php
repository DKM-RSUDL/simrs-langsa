@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-inap.pelayanan.covid-19.include')
@include('unit-pelayanan.rawat-inap.pelayanan.covid-19.include-create')

@push('css')
    <style>
        .covid-form {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom: 4px solid #5a67d8;
        }

        .form-header h4 {
            margin: 0;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .form-section {
            margin-bottom: 30px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }

        .section-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-content {
            padding: 20px;
        }

        .symptom-item, .risk-item, .comorbid-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .symptom-item:hover, .risk-item:hover, .comorbid-item:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
            transform: translateY(-1px);
        }

        .form-check-input:checked {
            background-color: #48bb78;
            border-color: #48bb78;
        }

        .form-check-input:checked + .form-check-label {
            color: #2d3748;
            font-weight: 500;
        }

        .date-input {
            background: #fff;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 15px;
            transition: border-color 0.3s ease;
        }

        .date-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .assessment-section {
            background: #f7fafc;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .assessment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .assessment-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .assessment-card:hover {
            border-color: #cbd5e0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .assessment-card.selected {
            border-color: #48bb78;
            background: #f0fff4;
        }

        .assessment-card.suggested {
            border-color: #fbbf24;
            background: #fffbeb;
        }

        .assessment-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .assessment-desc {
            font-size: 0.9em;
            color: #4a5568;
            line-height: 1.5;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .btn-secondary-custom {
            background: #e2e8f0;
            color: #4a5568;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary-custom:hover {
            background: #cbd5e0;
            color: #2d3748;
        }

        .alert-info-custom {
            background: linear-gradient(135deg, #e6fffa 0%, #b2f5ea 100%);
            border: 1px solid #81e6d9;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .icon-symptom { color: #e53e3e; }
        .icon-risk { color: #d69e2e; }
        .icon-comorbid { color: #3182ce; }
        .icon-assessment { color: #805ad5; }

        .section-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .section-title {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            justify-content: center;
            padding: 20px;
            flex-wrap: wrap;
        }

        .radio-item {
            position: relative;
        }

        .radio-item input[type="radio"] {
            display: none;
        }

        .radio-label {
            display: block;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px 35px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            color: #4a5568;
            min-width: 150px;
        }

        .radio-label i {
            font-size: 2rem;
            margin-bottom: 8px;
            color: #667eea;
        }

        .radio-label:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .radio-item input[type="radio"]:checked + .radio-label {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .radio-item input[type="radio"]:checked + .radio-label i {
            color: white;
        }

        .hidden-section {
            display: none;
        }

        .section-card .row {
            padding: 0 20px;
        }

        .section-card .row:last-child {
            padding-bottom: 20px;
        }

        .conclusion-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin-top: 15px;
            text-align: center;
        }

        .conclusion-card.kontak-erat {
            border-color: #fbbf24;
            background: #fffbeb;
        }

        .conclusion-card.suspek {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .conclusion-card.non-suspek {
            border-color: #10b981;
            background: #f0fdf4;
        }

        @media (max-width: 768px) {
            .assessment-grid {
                grid-template-columns: 1fr;
            }

            .radio-group {
                flex-direction: column;
                gap: 10px;
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
            <div class="d-flex justify-content-start mb-3">
                <a href="{{ route('rawat-inap.covid-19.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                    class="btn btn-outline-primary">
                    <i class="ti-arrow-left"></i> Kembali
                </a>
            </div>

            <form id="covid_form" method="POST"
                action="{{ route('rawat-inap.covid-19.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="covid-form">
                    <!-- Header -->
                    <div class="form-header">
                        <h5><i class="fas fa-virus"></i> FORMULIR DETEKSI DINI CORONA VIRUS DISEASE (COVID-19) REVISI 5</h5>
                    </div>

                    <div class="p-4">
                        <!-- Alert Info -->
                        <div class="alert-info-custom">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Petunjuk:</strong> Berikan tanda centang (✓) pada kolom yang sesuai dengan kondisi pasien saat ini.
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Gejala Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-thermometer-half icon-symptom"></i>
                                <span>GEJALA</span>
                            </div>
                            <div class="section-content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="symptom-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="gejala[demam]" id="demam" value="1" {{ old('gejala.demam') ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="demam">
                                                    <i class="fas fa-thermometer-three-quarters me-2"></i>
                                                    Demam (≥ 38° C) / Riwayat demam
                                                </label>
                                            </div>
                                        </div>

                                        <div class="symptom-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="gejala[ispa]" id="ispa" value="1" {{ old('gejala.ispa') ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="ispa">
                                                    <i class="fas fa-lungs me-2"></i>
                                                    Batuk/Pilek/Nyeri tenggorokan/Sesak Nafas (ISPA)
                                                </label>
                                            </div>
                                        </div>

                                        <div class="symptom-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="gejala[sakit_kepala]" id="sakit_kepala" value="1" {{ old('gejala.sakit_kepala') ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="sakit_kepala">
                                                    <i class="fas fa-head-side-cough me-2"></i>
                                                    Sakit kepala/ Lemah (Malaise)/ Nyeri otot
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="symptom-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="gejala[ispa_berat]" id="ispa_berat" value="1" {{ old('gejala.ispa_berat') ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="ispa_berat">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                                    ISPA Berat/ Pneumonia Berat
                                                </label>
                                            </div>
                                        </div>

                                        <div class="symptom-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="gejala[gejala_lain]" id="gejala_lain" value="1" {{ old('gejala.gejala_lain') ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="gejala_lain">
                                                    <i class="fas fa-notes-medical me-2"></i>
                                                    Gejala lainnya:
                                                </label>
                                                <small class="d-block text-muted mt-1">
                                                    Gangguan pemciuman/ Gangguan pengecapan/ Mual/ Muntah/ Nyeri perut/ Diare
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-calendar-alt me-2"></i>
                                            Tanggal pertama timbul gejala:
                                        </label>
                                        <input type="date" class="form-control" name="tgl_gejala" id="tgl_gejala" value="{{ old('tgl_gejala') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Faktor Risiko Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-exclamation-circle icon-risk"></i>
                                <span>FAKTOR RISIKO PENULARAN</span>
                            </div>
                            <div class="section-content">
                                <div class="risk-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="faktor_risiko[perjalanan]" id="perjalanan" value="1" {{ old('faktor_risiko.perjalanan') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="perjalanan">
                                            <i class="fas fa-plane me-2"></i>
                                            Riwayat perjalanan/ tinggal di daerah transmisi lokal dalam < 14 hari terakhir
                                        </label>
                                    </div>
                                    <div class="mt-2" id="lokasi_perjalanan" style="{{ old('faktor_risiko.perjalanan') ? 'display: block;' : 'display: none;' }}">
                                        <label class="form-label">Sebutkan Negara/ Propinsi/ Kota:</label>
                                        <input type="text" class="form-control" name="lokasi_perjalanan" placeholder="Contoh: Jakarta, Malaysia, dll" value="{{ old('lokasi_perjalanan') }}">
                                    </div>
                                </div>

                                <div class="risk-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="faktor_risiko[kontak_erat]" id="kontak_erat" value="1" {{ old('faktor_risiko.kontak_erat') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="kontak_erat">
                                            <i class="fas fa-users me-2"></i>
                                            Kontak erat* dengan kasus konformasi** /Suspek***/Probable**** COVID-19 dalam 14 hari terakhir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Faktor Komorbid Section -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-heartbeat icon-comorbid"></i>
                                <span>FAKTOR KOMORBID</span>
                            </div>
                            <div class="section-content">
                                <p class="fw-bold mb-3">Mempunyai riwayat:</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="comorbid-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="komorbid[hipertensi]" id="hipertensi" value="1" {{ old('komorbid.hipertensi') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="hipertensi">
                                                    <i class="fas fa-heart me-2"></i>Hipertensi
                                                </label>
                                            </div>
                                        </div>

                                        <div class="comorbid-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="komorbid[diabetes]" id="diabetes" value="1" {{ old('komorbid.diabetes') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="diabetes">
                                                    <i class="fas fa-tint me-2"></i>Diabetes Mellitus
                                                </label>
                                            </div>
                                        </div>

                                        <div class="comorbid-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="komorbid[jantung]" id="jantung" value="1" {{ old('komorbid.jantung') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="jantung">
                                                    <i class="fas fa-heartbeat me-2"></i>Jantung
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="comorbid-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="komorbid[ginjal]" id="ginjal" value="1" {{ old('komorbid.ginjal') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="ginjal">
                                                    <i class="bi-heart-fill me-2"></i>Ginjal
                                                </label>
                                            </div>
                                        </div>

                                        <div class="comorbid-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="komorbid[hemodialisis]" id="hemodialisis" value="1" {{ old('komorbid.hemodialisis') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="hemodialisis">
                                                    <i class="fas fa-filter me-2"></i>Riwayat hemodialisis
                                                </label>
                                            </div>
                                        </div>

                                        <div class="comorbid-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="komorbid[usia_50]" id="usia_50" value="1" {{ old('komorbid.usia_50') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="usia_50">
                                                    <i class="fas fa-user-clock me-2"></i>Usia > 50 Tahun
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pilihan Persetujuan -->
                        <div class="section-card">
                            <div class="section-title">
                                <i class="fas fa-user-check"></i>
                                Persetujuan Untuk
                            </div>
                            <div class="radio-group">
                                <div class="radio-item">
                                    <input type="radio" id="diri_sendiri" name="persetujuan_untuk" value="diri_sendiri" {{ old('persetujuan_untuk') == 'diri_sendiri' ? 'checked' : '' }} required>
                                    <label for="diri_sendiri" class="radio-label">
                                        <i class="fas fa-user"></i><br>
                                        Diri Sendiri
                                    </label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" id="keluarga" name="persetujuan_untuk" value="keluarga" {{ old('persetujuan_untuk') == 'keluarga' ? 'checked' : '' }} required>
                                    <label for="keluarga" class="radio-label">
                                        <i class="fas fa-users"></i><br>
                                        Keluarga/Wali
                                    </label>
                                </div>
                            </div>
                            @error('persetujuan_untuk')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Data Keluarga (Hidden by default) -->
                        <div id="keluarga-section" class="section-card hidden-section"
                            style="{{ old('persetujuan_untuk') == 'keluarga' ? 'display: block;' : 'display: none;' }}">
                            <div class="section-title">
                                <i class="fas fa-users"></i>
                                Data Keluarga/Wali
                            </div>
                            <small class="fw-bold">Saya yang bertanda tangan di bawah ini :</small>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama_keluarga" name="nama_keluarga"
                                            value="{{ old('nama_keluarga') }}" placeholder="Masukkan nama lengkap">
                                        @error('nama_keluarga')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tgl_lahir_keluarga"
                                            name="tgl_lahir_keluarga" value="{{ old('tgl_lahir_keluarga') }}">
                                        @error('tgl_lahir_keluarga')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat_keluarga" name="alamat_keluarga" rows="2"
                                            placeholder="Masukkan alamat lengkap">{{ old('alamat_keluarga') }}</textarea>
                                        @error('alamat_keluarga')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" id="jk_keluarga" name="jk_keluarga">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="1" {{ old('jk_keluarga') == '1' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="0" {{ old('jk_keluarga') == '0' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jk_keluarga')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">No. Telepon</label>
                                        <input type="tel" class="form-control" id="no_telp_keluarga" name="no_telp_keluarga"
                                            value="{{ old('no_telp_keluarga') }}" placeholder="Contoh: 08226742xxxx" maxlength="12">
                                        @error('no_telp_keluarga')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">No. KTP/SIM</label>
                                        <input type="text" class="form-control" id="no_ktp_keluarga" name="no_ktp_keluarga"
                                            value="{{ old('no_ktp_keluarga') }}" placeholder="Masukkan nomor KTP/SIM" maxlength="16">
                                        @error('no_ktp_keluarga')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Hubungan dengan pihak yang diwakili</label>
                                        <input type="text" class="form-control" id="hubungan_keluarga"
                                            name="hubungan_keluarga" value="{{ old('hubungan_keluarga') }}"
                                            placeholder="Contoh: Suami/Istri/Anak/Orang Tua/Wali">
                                        @error('hubungan_keluarga')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Saksi 1 -->
                        <div class="section-card">
                            <div class="section-title">
                                <i class="fas fa-user-tie"></i>
                                Data Saksi 1
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama_saksi1" name="nama_saksi1"
                                            value="{{ old('nama_saksi1') }}" placeholder="Masukkan nama lengkap saksi 1">
                                        @error('nama_saksi1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tgl_lahir_saksi1"
                                            name="tgl_lahir_saksi1" value="{{ old('tgl_lahir_saksi1') }}">
                                        @error('tgl_lahir_saksi1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat_saksi1" name="alamat_saksi1" rows="2"
                                            placeholder="Masukkan alamat lengkap">{{ old('alamat_saksi1') }}</textarea>
                                        @error('alamat_saksi1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" id="jk_saksi1" name="jk_saksi1">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="1" {{ old('jk_saksi1') == '1' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="0" {{ old('jk_saksi1') == '0' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jk_saksi1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">No. Telepon</label>
                                        <input type="tel" class="form-control" id="no_telp_saksi1" name="no_telp_saksi1"
                                            value="{{ old('no_telp_saksi1') }}" placeholder="Contoh: 08226742xxxx" maxlength="12">
                                        @error('no_telp_saksi1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">No. KTP/SIM</label>
                                        <input type="text" class="form-control" id="no_ktp_saksi1" name="no_ktp_saksi1"
                                            value="{{ old('no_ktp_saksi1') }}" placeholder="Masukkan nomor KTP/SIM" maxlength="16">
                                        @error('no_ktp_saksi1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Assessment Section -->
                        <div class="assessment-section">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-clipboard-check icon-assessment me-2"></i>
                                <h6 class="mb-0 fw-bold">CARA PENILAIAN (Cocokan dengan temuan pada gejala dan faktor risiko)</h6>
                            </div>

                            <div class="assessment-grid">
                                <div class="assessment-card" data-value="kontak_erat">
                                    <div class="assessment-title">
                                        <i class="fas fa-user-friends text-warning"></i>
                                        KONTAK ERAT
                                    </div>
                                    <div class="assessment-desc">
                                        Tanpa gejala + Faktor risiko utama no. 2 (Kasus konfirmasi*/ Probable**)
                                    </div>
                                    <input type="radio" name="cara_penilaian" value="kontak_erat" class="d-none assessment-radio">
                                </div>

                                <div class="assessment-card" data-value="suspek">
                                    <div class="assessment-title">
                                        <i class="fas fa-exclamation-triangle text-danger"></i>
                                        SUSPEK
                                    </div>
                                    <div class="assessment-desc">
                                        <ul style="margin-left: 5px">
                                            <li>Gejala No.1 atau No.2 + Faktor risiko utama No.1 atau No.2</li>
                                            <li>Gejala No.1 atau No.2 + Faktor risiko utama No.2 (kasus konfirmasi*)</li>
                                            <li>Gejala No.4 DAN tidak ada penyebab lain berdasarkan gambaran klinis yang meyakinkan.</li>
                                        </ul>
                                    </div>
                                    <input type="radio" name="cara_penilaian" value="suspek" class="d-none assessment-radio">
                                </div>

                                <div class="assessment-card" data-value="non_suspek">
                                    <div class="assessment-title">
                                        <i class="fas fa-check-circle text-success"></i>
                                        NON SUSPEK
                                    </div>
                                    <div class="assessment-desc">
                                        Tidak memenuhi kriteria kontak erat, kasus suspek.
                                    </div>
                                    <input type="radio" name="cara_penilaian" value="non_suspek" class="d-none assessment-radio">
                                </div>
                            </div>
                        </div>

                        <!-- Kesimpulan Section -->
                        <div class="assessment-section">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-clipboard-check icon-assessment me-2"></i>
                                <h5 class="mb-0 fw-bold">KESIMPULAN</h5>
                            </div>

                            <p class="text-muted mb-3">Kesimpulan berdasarkan gejala dan faktor risiko yang telah diisi:</p>

                            <div class="conclusion-card" id="conclusion-card">
                                <div class="assessment-title" id="conclusion-title">
                                    <i class="fas fa-spinner fa-spin" id="conclusion-icon"></i>
                                    Menghitung...
                                </div>
                                <div class="assessment-desc" id="conclusion-desc">
                                    Silakan isi gejala dan faktor risiko untuk melihat kesimpulan.
                                </div>
                                <input type="hidden" name="kesimpulan" id="kesimpulan" value="">
                            </div>
                        </div>

                        <!-- Tindak Lanjut -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-route"></i>
                                <span>TINDAK LANJUT</span>
                            </div>
                            <div class="section-content">
                                <div class="alert alert-info">
                                    <strong>Panduan Tindak Lanjut:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li><strong>Kontak Erat:</strong> Rujuk ke pelayanan COVID-19 (IGD PIE)</li>
                                        <li><strong>Suspek:</strong> Rujuk ke pelayanan COVID-19 (IGD PIE)</li>
                                        <li><strong>Non Suspek:</strong> Lanjut ke pelayanan Non COVID-19 (IGD/Poliklinik/Rawat Inap Non PIE)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <a href="{{ route('rawat-inap.covid-19.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                class="btn btn-secondary-custom">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="fas fa-save me-2"></i> Simpan Formulir
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
        $(document).ready(function() {
            console.log('COVID-19 Form loaded');

            // Show/hide keluarga section based on persetujuan_untuk selection
            $('input[name="persetujuan_untuk"]').change(function() {
                if ($(this).val() === 'keluarga') {
                    $('#keluarga-section').slideDown();
                    // Make keluarga fields required when selected
                    $('#nama_keluarga, #hubungan_keluarga').attr('required', true);
                } else {
                    $('#keluarga-section').slideUp();
                    // Remove required attribute and clear values
                    $('#keluarga-section input, #keluarga-section select, #keluarga-section textarea')
                        .removeAttr('required').val('');
                }
            });

            // Show/hide location input when travel history is checked
            $('#perjalanan').change(function() {
                if (this.checked) {
                    $('#lokasi_perjalanan').slideDown();
                } else {
                    $('#lokasi_perjalanan').slideUp();
                    $('input[name="lokasi_perjalanan"]').val('');
                }
            });

            // Assessment card selection - PERBAIKAN UTAMA
            $('.assessment-card').click(function() {
                console.log('Assessment card clicked:', $(this).data('value'));

                // Remove selected class from all cards
                $('.assessment-card').removeClass('selected');

                // Add selected class to clicked card
                $(this).addClass('selected');

                // Update the radio button value
                const selectedValue = $(this).data('value');
                $(this).find('.assessment-radio').prop('checked', true);

                // Update cara_penilaian dan kesimpulan
                updateConclusionManual(selectedValue);
            });

            // Function to update conclusion manually
            function updateConclusionManual(value) {
                const title = $('#conclusion-title');
                const desc = $('#conclusion-desc');
                const kesimpulanInput = $('#kesimpulan');
                const conclusionCard = $('#conclusion-card');

                // Remove all conclusion classes
                conclusionCard.removeClass('kontak-erat suspek non-suspek');

                switch(value) {
                    case 'kontak_erat':
                        title.html('<i class="fas fa-user-friends text-warning"></i> KONTAK ERAT');
                        desc.text('Tanpa gejala + Faktor risiko utama no. 2 (Kasus konfirmasi/Probable*)');
                        kesimpulanInput.val('kontak_erat');
                        conclusionCard.addClass('kontak-erat');
                        break;
                    case 'suspek':
                        title.html('<i class="fas fa-exclamation-triangle text-danger"></i> SUSPEK');
                        desc.html('• Gejala No.1 atau No.2 + Faktor risiko utama No.1 atau No.2<br>• Gejala No.4 DAN tidak ada penyebab lain berdasarkan gambaran klinis yang meyakinkan');
                        kesimpulanInput.val('suspek');
                        conclusionCard.addClass('suspek');
                        break;
                    case 'non_suspek':
                        title.html('<i class="fas fa-check-circle text-success"></i> NON SUSPEK');
                        desc.text('Tidak memenuhi kriteria kontak erat atau kasus suspek');
                        kesimpulanInput.val('non_suspek');
                        conclusionCard.addClass('non-suspek');
                        break;
                }

                console.log('Conclusion updated to:', value);
            }

            // Auto-assessment based on symptoms and risk factors
            function autoAssessment() {
                const demam = $('#demam').is(':checked');
                const ispa = $('#ispa').is(':checked');
                const ispaBerat = $('#ispa_berat').is(':checked');
                const kontakErat = $('#kontak_erat').is(':checked');
                const perjalanan = $('#perjalanan').is(':checked');

                // Clear previous suggestions
                $('.assessment-card').removeClass('suggested');

                let suggestedValue = null;

                if (!demam && !ispa && !ispaBerat && kontakErat) {
                    // Suggest kontak erat
                    suggestedValue = 'kontak_erat';
                } else if ((demam || ispa) && (kontakErat || perjalanan)) {
                    // Suggest suspek
                    suggestedValue = 'suspek';
                } else if (ispaBerat) {
                    // Suggest suspek for severe symptoms
                    suggestedValue = 'suspek';
                } else if (!kontakErat && !perjalanan && !(demam || ispa || ispaBerat)) {
                    // Suggest non-suspek
                    suggestedValue = 'non_suspek';
                }

                if (suggestedValue) {
                    $(`.assessment-card[data-value="${suggestedValue}"]`).addClass('suggested');
                    console.log('Auto-suggested:', suggestedValue);
                }

                return suggestedValue;
            }

            // Function to update conclusion automatically
            function updateConclusionAuto() {
                const suggestedValue = autoAssessment();

                if (suggestedValue) {
                    // Auto-select the suggested assessment
                    $(`.assessment-card[data-value="${suggestedValue}"]`).click();
                } else {
                    // Reset conclusion if no clear assessment
                    const title = $('#conclusion-title');
                    const desc = $('#conclusion-desc');
                    const kesimpulanInput = $('#kesimpulan');
                    const conclusionCard = $('#conclusion-card');

                    title.html('<i class="fas fa-question-circle text-muted"></i> Belum Ditentukan');
                    desc.text('Silakan pilih penilaian manual atau isi gejala dan faktor risiko untuk penilaian otomatis.');
                    kesimpulanInput.val('');
                    conclusionCard.removeClass('kontak-erat suspek non-suspek');
                }
            }

            // Trigger auto assessment when checkboxes change
            $('input[type="checkbox"]').change(function() {
                console.log('Checkbox changed:', this.id, this.checked);
                setTimeout(updateConclusionAuto, 100);
            });

            // Form validation - PERBAIKAN VALIDASI
            $('#covid_form').submit(function(e) {
                console.log('Form submitted');

                // Check if any symptoms are checked
                let hasSymptoms = false;
                $('input[name^="gejala"]').each(function() {
                    if ($(this).is(':checked')) {
                        hasSymptoms = true;
                        return false;
                    }
                });

                // Check if kesimpulan is filled
                const kesimpulanValue = $('#kesimpulan').val();
                console.log('Kesimpulan value:', kesimpulanValue);

                // Check if persetujuan_untuk is selected
                const hasPersetujuanUntuk = $('input[name="persetujuan_untuk"]:checked').length > 0;

                // Validate kesimpulan
                if (!kesimpulanValue || kesimpulanValue === '') {
                    e.preventDefault();
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Kesimpulan Diperlukan!',
                            text: 'Mohon pilih salah satu cara penilaian (Kontak Erat, Suspek, atau Non Suspek).',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        alert('Mohon pilih cara penilaian terlebih dahulu!');
                    }
                    return false;
                }

                // Validate persetujuan_untuk
                if (!hasPersetujuanUntuk) {
                    e.preventDefault();
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Persetujuan Untuk Siapa?',
                            text: 'Mohon pilih persetujuan untuk diri sendiri atau keluarga/wali.',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        alert('Mohon pilih persetujuan untuk siapa!');
                    }
                    return false;
                }

                // Validate keluarga section if selected
                if ($('input[name="persetujuan_untuk"]:checked').val() === 'keluarga') {
                    const namaKeluarga = $('#nama_keluarga').val().trim();
                    const hubunganKeluarga = $('#hubungan_keluarga').val().trim();

                    if (!namaKeluarga || !hubunganKeluarga) {
                        e.preventDefault();
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Data Keluarga/Wali Tidak Lengkap!',
                                text: 'Mohon lengkapi minimal nama dan hubungan keluarga/wali.',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            alert('Mohon lengkapi data keluarga/wali!');
                        }
                        return false;
                    }
                }

                console.log('Form validation passed');
                return true;
            });

            // Initialize auto assessment on page load
            updateConclusionAuto();
        });
    </script>
@endpush
