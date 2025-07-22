@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-inap.pelayanan.covid-19.include')
@include('unit-pelayanan.rawat-inap.pelayanan.covid-19.include-create')


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
                                Data Saksi
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

                        <!-- Persetujuan -->
                        <div class="consent-section">
                            <div class="consent-title fw-bold">
                                <i class="fas fa-question-circle"></i>
                                Pernyataan Persetujuan Informed Consent COVID-19
                            </div>
                            <p>
                                Dengan ini Saya telah mendapat penjelasan dan memahami penjelasan tersebut di atas dan menyatakan:
                            </p>
                            <div class="radio-group">
                                <div class="radio-item">
                                    <input type="radio" id="setuju" name="persetujuan" value="setuju" {{ old('persetujuan') == 'setuju' ? 'checked' : '' }} required>
                                    <label for="setuju" class="radio-label">
                                        <i class="fas fa-check-circle"></i><br>
                                        <strong>YA, SETUJU</strong>
                                    </label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" id="tidak_setuju" name="persetujuan" value="tidak_setuju" {{ old('persetujuan') == 'tidak_setuju' ? 'checked' : '' }} required>
                                    <label for="tidak_setuju" class="radio-label">
                                        <i class="fas fa-times-circle"></i><br>
                                        <strong>TIDAK SETUJU</strong>
                                    </label>
                                </div>
                            </div>
                            @error('persetujuan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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
