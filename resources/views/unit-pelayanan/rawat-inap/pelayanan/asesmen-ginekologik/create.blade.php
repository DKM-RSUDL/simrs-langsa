@extends('layouts.administrator.master')

@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-ginekologik.include')

@push('css')
    <style>
        #status-ginekologik .card {
            transition: all 0.3s ease;
        }

        #status-ginekologik .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #status-ginekologik textarea {
            min-height: 100px;
            resize: vertical;
        }

        #status-ginekologik .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .character-counter {
            margin-top: 5px;
            font-size: 0.875rem;
        }

        #status-ginekologik .border-success {
            border-color: #28a745 !important;
        }

        #status-ginekologik .border-warning {
            border-color: #ffc107 !important;
        }

        /* Pemeriksaan Fisik */
        .table-asesmen {
            font-size: 0.9rem;
        }

        .section-title {
            color: #495057;
            font-weight: 600;
            margin-bottom: 1rem;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 0.5rem;
        }

        .form-check-input {
            margin-top: 0.2rem;
        }

        .form-check-label {
            cursor: pointer;
            font-size: 0.9rem;
        }

        .keterangan-input {
            width: 200px;
            font-size: 0.85rem;
        }

        .item-label {
            font-weight: 500;
            min-width: 100px;
            display: inline-block;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .row-item {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .row-item:last-child {
            border-bottom: none;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum") }}"
                class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <h4 class="header-asesmen">Asesmen Medis Ginekologik</h4>
                                    <p>
                                        Isikan Asesmen medis dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- FORM ASESMEN MEDIS GINEKOLOGIK --}}
                        <form method="POST"
                            action="{{ route('rawat-inap.asesmen.medis.ginekologik.index', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                            ]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="px-3">
                                <div>

                                    <div class="section-separator" id="data-masuk">
                                        <h5 class="section-title">1. Data masuk</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <input type="date" class="form-control" name="tanggal" id="tanggal_masuk"
                                                    value="{{ date('Y-m-d') }}">
                                                <input type="time" class="form-control" name="jam_masuk" id="jam_masuk"
                                                    value="{{ date('H:i') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kondisi Masuk</label>
                                            <select class="form-select" name="kondisi_masuk">
                                                <option selected disabled>Pilih</option>
                                                <option value="Mandiri">Mandiri</option>
                                                <option value="Jalan Kaki">Jalan Kaki</option>
                                                <option value="Kursi Roda">Kursi Roda</option>
                                                <option value="Brankar">Brankar</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Diagnosis Masuk</label>
                                            <input type="text" class="form-control" name="diagnosis_masuk">
                                        </div>
                                    </div>

                                    {{-- 2. G/P/A (GRAVIDA, PARA, ABORTUS) --}}
                                    <div class="section-separator" id="gpa">
                                        <h5 class="section-title">2. G/P/A (Gravida, Para, Abortus)</h5>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>G</label>
                                                    <input type="number" class="form-control" name="gravida"
                                                        placeholder="0" min="0" max="20">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>P</label>
                                                    <input type="number" class="form-control" name="para"
                                                        placeholder="0" min="0" max="20">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>A</label>
                                                    <input type="number" class="form-control" name="abortus"
                                                        placeholder="0" min="0" max="20">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- 3. KELUHAN UTAMA --}}
                                    <div class="section-separator" id="keluhan-utama">
                                        <h5 class="section-title">3. Keluhan Utama</h5>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Keluhan Utama/Alasan Masuk RS</label>
                                            <textarea class="form-control" name="keluhan_utama" rows="4"
                                                placeholder="Masukkan keluhan utama atau alasan masuk rumah sakit"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Riwayat Penyakit</label>
                                            <input type="text" class="form-control" name="riwayat_penyakit"
                                                placeholder="Masukkan riwayat penyakit">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Riwayat Haid</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <!-- Siklus -->
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Siklus</label>
                                                    <div class="input-group">
                                                        <input type="number" name="siklus" class="form-control"
                                                            placeholder="Hari" min="1" value="28">
                                                        <span class="input-group-text">Hari</span>
                                                    </div>
                                                </div>

                                                <!-- HPHT -->
                                                <div class="flex-grow-1">
                                                    <label class="form-label">HPHT</label>
                                                    <input type="date" class="form-control" name="hpht"
                                                        id="hpht" value="{{ date('Y-m-d') }}"
                                                        onchange="hitungUsiaKehamilan()">
                                                </div>

                                                <!-- Usia Kehamilan -->
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Usia Kehamilan</label>
                                                    <div class="row g-2">
                                                        <div class="col-6">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control"
                                                                    name="usia_minggu" id="usiaMinggu" placeholder="0"
                                                                    min="0" max="42" readonly>
                                                                <span class="input-group-text">Minggu</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control"
                                                                    name="usia_hari" id="usiaHari" placeholder="0"
                                                                    min="0" max="6" readonly>
                                                                <span class="input-group-text">Hari</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted mt-1 d-block" id="displayUsia">
                                                        Pilih tanggal HPHT untuk menghitung
                                                    </small>

                                                    <!-- Hidden inputs untuk form submission -->
                                                    <input type="hidden" name="usia_kehamilan_total_hari"
                                                        id="totalHari">
                                                    <input type="hidden" name="usia_kehamilan_display" id="usiaDisplay">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Perkawinan</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Jumlah</label>
                                                    <div class="input-group">
                                                        <input type="number" name="jumlah" class="form-control"
                                                            placeholder="Total" min="1">
                                                        <span class="input-group-text">Kali</span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Dengan Suami Sekarang</label>
                                                    <div class="input-group">
                                                        <select class="form-select" name="tahun">
                                                            <option selected disabled>Pilih</option>
                                                            <option value="bulan">Bulan</option>
                                                            <option value="tahun">Tahun</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Jumlah Suami</label>
                                                    <div class="input-group">
                                                        <input type="number" name="jumlah_suami" class="form-control"
                                                            placeholder="Total" min="1">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- 4. RIWAYAT OBSTETRIK --}}
                                <div class="section-separator" id="riwayat-obstetrik">
                                    <h5 class="section-title">4. Riwayat Obstetrik</h5>

                                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                        id="openObstetrikModal">
                                        <i class="ti-plus"></i> Tambah Riwayat Obstetrik
                                    </button>
                                    <input type="hidden" name="riwayat_obstetrik" id="obstetrikInput">
                                    <div class="table-responsive">
                                        <table class="table" id="obstetrikTable">
                                            <thead>
                                                <tr>
                                                    <th>Keadaan</th>
                                                    <th>Kehamilan</th>
                                                    <th>Cara Persalinan</th>
                                                    <th>Keadaan Nifas</th>
                                                    <th>Tanggal Lahir</th>
                                                    <th>Keadaan Anak</th>
                                                    <th>Tempat dan Penolong</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Table content will be dynamically populated -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- 5. Riwayat Penaykit terdahulu --}}
                                <div class="section-separator" id="riwayat-penyakit-terdahulu">
                                    <h5 class="section-title">5. Riwayat penyakit dahulu/ termasuk operasi dan Keluarga
                                        Berencana</h5>
                                    <div class="form-group">
                                        <textarea class="form-control" name="riwayat_penyakit_dahulu" rows="5"
                                            placeholder="Masukkan riwayat penyakit dahulu"></textarea>
                                    </div>
                                </div>

                                {{-- 6. Tanda Vital --}}
                                <div class="section-separator">
                                    <h5 class="section-title">6. Tanda Vital</h5>
                                    <div class="form-group">
                                        <label style="min-width: 220px;">Tekanan Darah (mmHg)</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <label class="form-label">Sistole</label>
                                                <input type="number" class="form-control" name="tekanan_darah_sistole">
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="form-label">Diastole</label>
                                                <input type="number" class="form-control" name="tekanan_darah_diastole">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 220px;">Suhu (°C)</label>
                                        <input type="text" class="form-control" name="suhu" step="0.1">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 220px;">Respirasi (Per Menit)</label>
                                        <input type="number" class="form-control" name="respirasi">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 220px;">Nadi (Per Menit)</label>
                                        <input type="number" class="form-control" name="nadi">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 220px;">saturasi oksigen</label>
                                        <input type="number" class="form-control" name="nafas">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 220px;">Berat Badan (Kg)</label>
                                        <input type="number" class="form-control" name="berat_badan">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 220px;">Tinggi Badan (Cm)</label>
                                        <input type="number" class="form-control" name="tinggi_badan">
                                    </div>
                                </div>

                                {{-- 7. Pemeriksaan Fisik --}}
                                <div class="section-separator" id="pemeriksaan-fisik">
                                    <h5 class="section-title">7. Pemeriksaan FIsik</h5>
                                    <form id="pemeriksaanFisikForm">
                                        <!-- Kesadaran -->
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-2">
                                                <span class="fw-medium">Kesadaran</span>
                                            </div>
                                            <div class="col-10">
                                                <select class="form-select" name="paru_kesadaran" style="width: 200px;">
                                                    <option value="" selected>--pilih--</option>
                                                    <option value="Compos Mentis">Compos Mentis</option>
                                                    <option value="Apatis">Apatis</option>
                                                    <option value="Sopor">Sopor</option>
                                                    <option value="Coma">Coma</option>
                                                    <option value="Somnolen">Somnolen</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Kepala -->
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-2">
                                                <span class="fw-medium">Kepala</span>
                                            </div>
                                            <div class="col-10">
                                                <div class="d-flex gap-3 align-items-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="kepala"
                                                            value="1" id="kepala_normal" checked>
                                                        <label class="form-check-label" for="kepala_normal">Normal</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="kepala"
                                                            value="0" id="kepala_abnormal">
                                                        <label class="form-check-label"
                                                            for="kepala_abnormal">Abnormal:</label>
                                                    </div>
                                                    <input type="text" class="form-control" name="kepala_keterangan"
                                                        id="kepala_keterangan" placeholder="Keterangan..." disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hidung -->
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-2">
                                                <span class="fw-medium">Hidung</span>
                                            </div>
                                            <div class="col-10">
                                                <div class="d-flex gap-3 align-items-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="hidung"
                                                            value="1" id="hidung_normal" checked>
                                                        <label class="form-check-label" for="hidung_normal">Normal</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="hidung"
                                                            value="0" id="hidung_abnormal">
                                                        <label class="form-check-label"
                                                            for="hidung_abnormal">Abnormal:</label>
                                                    </div>
                                                    <input type="text" class="form-control" name="hidung_keterangan"
                                                        id="hidung_keterangan" placeholder="Keterangan..." disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Mata -->
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-2">
                                                <span class="fw-medium">Mata</span>
                                            </div>
                                            <div class="col-10">
                                                <div class="d-flex gap-3 align-items-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="mata"
                                                            value="1" id="mata_normal" checked>
                                                        <label class="form-check-label" for="mata_normal">Normal</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="mata"
                                                            value="0" id="mata_abnormal">
                                                        <label class="form-check-label"
                                                            for="mata_abnormal">Abnormal:</label>
                                                    </div>
                                                    <input type="text" class="form-control" name="mata_keterangan"
                                                        id="mata_keterangan" placeholder="Keterangan..." disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Leher -->
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-2">
                                                <span class="fw-medium">Leher</span>
                                            </div>
                                            <div class="col-10">
                                                <div class="d-flex gap-3 align-items-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="leher"
                                                            value="1" id="leher_normal" checked>
                                                        <label class="form-check-label" for="leher_normal">Normal</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="leher"
                                                            value="0" id="leher_abnormal">
                                                        <label class="form-check-label"
                                                            for="leher_abnormal">Abnormal:</label>
                                                    </div>
                                                    <input type="text" class="form-control" name="leher_keterangan"
                                                        id="leher_keterangan" placeholder="Keterangan..." disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tenggorokan -->
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-2">
                                                <span class="fw-medium">Tenggorokan</span>
                                            </div>
                                            <div class="col-10">
                                                <div class="d-flex gap-3 align-items-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="tenggorokan"
                                                            value="1" id="tenggorokan_normal" checked>
                                                        <label class="form-check-label"
                                                            for="tenggorokan_normal">Normal</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="tenggorokan"
                                                            value="0" id="tenggorokan_abnormal">
                                                        <label class="form-check-label"
                                                            for="tenggorokan_abnormal">Abnormal:</label>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        name="tenggorokan_keterangan" id="tenggorokan_keterangan"
                                                        placeholder="Keterangan..." disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Dada -->
                                        <div class="row mb-2 align-items-start">
                                            <div class="col-2">
                                                <span class="fw-medium">Dada</span>
                                            </div>
                                            <div class="col-10">
                                                <!-- Jantung -->
                                                <div class="row mb-2 align-items-center">
                                                    <div class="col-2">
                                                        <span class="text-muted">Jantung</span>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="d-flex gap-3 align-items-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jantung" value="1" id="jantung_normal"
                                                                    checked>
                                                                <label class="form-check-label"
                                                                    for="jantung_normal">Normal</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jantung" value="0" id="jantung_abnormal">
                                                                <label class="form-check-label"
                                                                    for="jantung_abnormal">Abnormal:</label>
                                                            </div>
                                                            <input type="text" class="form-control"
                                                                name="jantung_keterangan" id="jantung_keterangan"
                                                                placeholder="Keterangan..." disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Paru -->
                                                <div class="row mb-2 align-items-center">
                                                    <div class="col-2">
                                                        <span class="text-muted">Paru</span>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="d-flex gap-3 align-items-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="paru" value="1" id="paru_normal"
                                                                    checked>
                                                                <label class="form-check-label"
                                                                    for="paru_normal">Normal</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="paru" value="0" id="paru_abnormal">
                                                                <label class="form-check-label"
                                                                    for="paru_abnormal">Abnormal:</label>
                                                            </div>
                                                            <input type="text" class="form-control"
                                                                name="paru_keterangan" id="paru_keterangan"
                                                                placeholder="Keterangan..." disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Perut -->
                                        <div class="row mb-2 align-items-start">
                                            <div class="col-2">
                                                <span class="fw-medium">Perut</span>
                                            </div>
                                            <div class="col-10">
                                                <!-- Hati -->
                                                <div class="row mb-2 align-items-center">
                                                    <div class="col-2">
                                                        <span class="text-muted">Hati</span>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="d-flex gap-3 align-items-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="hati" value="1" id="hati_normal"
                                                                    checked>
                                                                <label class="form-check-label"
                                                                    for="hati_normal">Normal</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="hati" value="0" id="hati_abnormal">
                                                                <label class="form-check-label"
                                                                    for="hati_abnormal">Abnormal:</label>
                                                            </div>
                                                            <input type="text" class="form-control"
                                                                name="hati_keterangan" id="hati_keterangan"
                                                                placeholder="Keterangan..." disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Limpa -->
                                                <div class="row mb-2 align-items-center">
                                                    <div class="col-2">
                                                        <span class="text-muted">Limpa</span>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="d-flex gap-3 align-items-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="limpa" value="1" id="limpa_normal"
                                                                    checked>
                                                                <label class="form-check-label"
                                                                    for="limpa_normal">Normal</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="limpa" value="0" id="limpa_abnormal">
                                                                <label class="form-check-label"
                                                                    for="limpa_abnormal">Abnormal:</label>
                                                            </div>
                                                            <input type="text" class="form-control"
                                                                name="limpa_keterangan" id="limpa_keterangan"
                                                                placeholder="Keterangan..." disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Kulit -->
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-2">
                                                <span class="fw-medium">Kulit</span>
                                            </div>
                                            <div class="col-10">
                                                <div class="d-flex gap-3 align-items-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="kulit"
                                                            value="1" id="kulit_normal" checked>
                                                        <label class="form-check-label" for="kulit_normal">Normal</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="kulit"
                                                            value="0" id="kulit_abnormal">
                                                        <label class="form-check-label"
                                                            for="kulit_abnormal">Abnormal:</label>
                                                    </div>
                                                    <input type="text" class="form-control" name="kulit_keterangan"
                                                        id="kulit_keterangan" placeholder="Keterangan..." disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Mulut/ gigi -->
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-2">
                                                <span class="fw-medium">Mulut/ gigi</span>
                                            </div>
                                            <div class="col-10">
                                                <div class="d-flex gap-3 align-items-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="mulut_gigi"
                                                            value="1" id="mulut_gigi_normal" checked>
                                                        <label class="form-check-label"
                                                            for="mulut_gigi_normal">Normal</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="mulut_gigi"
                                                            value="0" id="mulut_gigi_abnormal">
                                                        <label class="form-check-label"
                                                            for="mulut_gigi_abnormal">Abnormal:</label>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        name="mulut_gigi_keterangan" id="mulut_gigi_keterangan"
                                                        placeholder="Keterangan..." disabled>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                    {{-- <div class="row g-3">
                                            <div class="pemeriksaan-fisik">
                                                <h6>Pemeriksaan Fisik</h6>
                                                <p class="text-small">Centang normal jika fisik yang dinilai
                                                    normal,
                                                    pilih tanda tambah
                                                    untuk menambah keterangan fisik yang ditemukan tidak normal.
                                                    Jika
                                                    tidak dipilih salah satunya, maka pemeriksaan tidak
                                                    dilakukan.
                                                </p>
                                                <div class="row">
                                                    @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                    <div class="col-md-6">
                                                        <div class="d-flex flex-column gap-3">
                                                            @foreach ($chunk as $item)
                                                            <div class="pemeriksaan-item">
                                                                <div class="d-flex align-items-center border-bottom pb-2">
                                                                    <div class="flex-grow-1">
                                                                        {{ $item->nama }}
                                                                    </div>
                                                                    <div class="form-check me-3">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="{{ $item->id }}-normal"
                                                                            name="{{ $item->id }}-normal" checked>
                                                                        <label class="form-check-label"
                                                                            for="{{ $item->id }}-normal">Normal</label>
                                                                    </div>
                                                                    <button
                                                                        class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                        type="button"
                                                                        data-target="{{ $item->id }}-keterangan">
                                                                        <i class="bi bi-plus"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="keterangan mt-2" id="{{ $item->id }}-keterangan"
                                                                    style="display:none;">
                                                                    <input type="text" class="form-control"
                                                                        name="{{ $item->id }}_keterangan"
                                                                        placeholder="Tambah keterangan jika tidak normal...">
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div> --}}

                                </div>

                                {{-- 8. PEMERIKSAAN EKSTREMITAS --}}
                                <div class="section-separator" id="pemeriksaan-ekstremitas">
                                    <h5 class="section-title">8. Pemeriksaan Ekstremitas</h5>

                                    <div class="row">
                                        {{-- Ekstremitas Atas --}}
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0 fw-semibold">Ekstremitas Atas</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Edema</label>
                                                        <div class="d-flex gap-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edema_atas" id="edema_atas_ada" value="ada">
                                                                <label class="form-check-label" for="edema_atas_ada">
                                                                    Ada
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edema_atas" id="edema_atas_tidak"
                                                                    value="tidak">
                                                                <label class="form-check-label" for="edema_atas_tidak">
                                                                    Tidak
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Varises</label>
                                                        <div class="d-flex gap-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="varises_atas" id="varises_atas_ada"
                                                                    value="ada">
                                                                <label class="form-check-label" for="varises_atas_ada">
                                                                    Ada
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="varises_atas" id="varises_atas_tidak"
                                                                    value="tidak">
                                                                <label class="form-check-label" for="varises_atas_tidak">
                                                                    Tidak
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-0">
                                                        <label class="form-label fw-semibold">Refleks</label>
                                                        <div class="d-flex gap-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="refleks_atas" id="refleks_atas_positif"
                                                                    value="positif">
                                                                <label class="form-check-label"
                                                                    for="refleks_atas_positif">
                                                                    Positif
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="refleks_atas" id="refleks_atas_negatif"
                                                                    value="negatif">
                                                                <label class="form-check-label"
                                                                    for="refleks_atas_negatif">
                                                                    Negatif
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Ekstremitas Bawah --}}
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0 fw-semibold">Ekstremitas Bawah</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Edema</label>
                                                        <div class="d-flex gap-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edema_bawah" id="edema_bawah_ada"
                                                                    value="ada">
                                                                <label class="form-check-label" for="edema_bawah_ada">
                                                                    Ada
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="edema_bawah" id="edema_bawah_tidak"
                                                                    value="tidak">
                                                                <label class="form-check-label" for="edema_bawah_tidak">
                                                                    Tidak
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Varises</label>
                                                        <div class="d-flex gap-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="varises_bawah" id="varises_bawah_ada"
                                                                    value="ada">
                                                                <label class="form-check-label" for="varises_bawah_ada">
                                                                    Ada
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="varises_bawah" id="varises_bawah_tidak"
                                                                    value="tidak">
                                                                <label class="form-check-label" for="varises_bawah_tidak">
                                                                    Tidak
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-0">
                                                        <label class="form-label fw-semibold">Refleks</label>
                                                        <div class="d-flex gap-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="refleks_bawah" id="refleks_bawah_positif"
                                                                    value="positif">
                                                                <label class="form-check-label"
                                                                    for="refleks_bawah_positif">
                                                                    Positif
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="refleks_bawah" id="refleks_bawah_negatif"
                                                                    value="negatif">
                                                                <label class="form-check-label"
                                                                    for="refleks_bawah_negatif">
                                                                    Negatif
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Summary Status (Optional) --}}
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="fw-semibold mb-3">Catatan Tambahan</h6>
                                                    <textarea class="form-control" name="catatan_ekstremitas" rows="3"
                                                        placeholder="Masukkan catatan tambahan tentang pemeriksaan ekstremitas jika diperlukan..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- 9. STATUS GINEKOLOGIK DAN PEMERIKSAAN --}}
                                <div class="section-separator" id="status-ginekologik">
                                    <h5 class="section-title">9. Status Ginekologik dan Pemeriksaan</h5>

                                    <div class="row">
                                        {{-- Column 1 --}}
                                        <div class="col-md-12">
                                            <div class="card mb-3">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0 fw-semibold">Status Umum</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Keadaan Umum</label>
                                                        <input type="text" class="form-control" name="keadaan_umum"
                                                            placeholder="Masukkan keadaan umum pasien">
                                                    </div>

                                                    {{-- <div class="mb-3">
                                                            <label class="form-label fw-semibold">Status
                                                                Ginekologik</label>
                                                            <input type="text" class="form-control"
                                                                name="status_ginekologik"
                                                                placeholder="Masukkan status ginekologik">
                                                        </div>

                                                        <div class="mb-0">
                                                            <label class="form-label fw-semibold">Pemeriksaan</label>
                                                            <input type="text" class="form-control" name="pemeriksaan"
                                                                placeholder="Masukkan hasil pemeriksaan">
                                                        </div> --}}
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Inspekulo</label>
                                                        <textarea class="form-control" name="inspekulo" rows="4" placeholder="Hasil pemeriksaan inspekulo..."></textarea>
                                                        <small class="text-muted">Pemeriksaan dengan spekulum</small>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">VT (Vaginal
                                                            Toucher)</label>
                                                        <textarea class="form-control" name="vt" rows="4" placeholder="Hasil pemeriksaan VT/vaginal toucher..."></textarea>
                                                        <small class="text-muted">Pemeriksaan dalam per vagina</small>
                                                    </div>

                                                    <div class="mb-0">
                                                        <label class="form-label fw-semibold">RT (Rectal
                                                            Toucher)</label>
                                                        <textarea class="form-control" name="rt" rows="4" placeholder="Hasil pemeriksaan RT/rectal toucher..."></textarea>
                                                        <small class="text-muted">Pemeriksaan dalam per rektal</small>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        {{-- Column 2 --}}
                                    </div>
                                </div>

                                {{-- 10. HASIL PEMERIKSAAN PENUNJANG --}}
                                <div class="section-separator" id="pemeriksaan-penunjang">
                                    <h5 class="section-title">10. Hasil Pemeriksaan Penunjang</h5>

                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">1. Laboratorium</label>
                                            <textarea class="form-control" name="laboratorium" rows="6"
                                                placeholder="Masukkan hasil pemeriksaan laboratorium..."></textarea>
                                            <small class="text-muted">Hasil lab darah, urin, dan pemeriksaan
                                                laboratorium lainnya</small>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">2. USG</label>
                                            <textarea class="form-control" name="usg" rows="6" placeholder="Masukkan hasil pemeriksaan USG..."></textarea>
                                            <small class="text-muted">Hasil USG abdomen, transvaginal, atau USG
                                                lainnya</small>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">3. Radiologi</label>
                                            <textarea class="form-control" name="radiologi" rows="6"
                                                placeholder="Masukkan hasil pemeriksaan radiologi..."></textarea>
                                            <small class="text-muted">Hasil X-Ray, CT Scan, MRI, dan pemeriksaan
                                                radiologi lainnya</small>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">4. Lainnya</label>
                                            <textarea class="form-control" name="penunjang_lainnya" rows="6"
                                                placeholder="Masukkan hasil pemeriksaan penunjang lainnya..."></textarea>
                                            <small class="text-muted">Hasil pemeriksaan penunjang lain yang belum
                                                tercantum di atas</small>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="section-separator" id="discharge-planning">
                                    <h5 class="section-title">11. Perencanaan Pulang Pasien (Discharge Planning)</h5>

                                    <div class="mb-4">
                                        <label class="form-label">Diagnosis medis</label>
                                        <input type="text" class="form-control" name="diagnosis_medis"
                                            placeholder="Diagnosis">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Usia lanjut</label>
                                        <select class="form-select" name="usia_lanjut">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="0">Ya</option>
                                            <option value="1">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Hambatan mobilisasi</label>
                                        <select class="form-select" name="hambatan_mobilisasi">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="0">Ya</option>
                                            <option value="1">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Membutuhkan penggunaan media berkelanjutan</label>
                                        <select class="form-select" name="penggunaan_media_berkelanjutan">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Ketergantungan dengan orang lain dalam aktivitas
                                            harian</label>
                                        <select class="form-select" name="ketergantungan_aktivitas">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Pasien / Keluarga Memerlukan Keterampilan Khusus
                                            Setelah
                                            Pulang</label>
                                        <select class="form-select" name="keterampilan_khusus">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Pasien Memerlukan Alat Bantu Setelah Keluar Rumah
                                            Sakit</label>
                                        <select class="form-select" name="alat_bantu">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Pasien Memiliki Nyeri Kronis Dan / Kebiasaan Setelah
                                            Pulang</label>
                                        <select class="form-select" name="nyeri_kronis">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Perkiraan lama hari dirawat</label>
                                            <input type="text" class="form-control" name="perkiraan_hari"
                                                placeholder="hari">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Rencana Tanggal Pulang</label>
                                            <input type="date" class="form-control" name="tanggal_pulang">
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <label class="form-label">KESIMPULAN</label>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="alert alert-info">
                                                Pilih semua Planning
                                            </div>
                                            <div class="alert alert-warning">
                                                Mebutuhkan rencana pulang khusus
                                            </div>
                                            <div class="alert alert-success">
                                                Tidak mebutuhkan rencana pulang khusus
                                            </div>
                                        </div>
                                        <input type="hidden" id="kesimpulan" name="kesimpulan_planing"
                                            value="Tidak mebutuhkan rencana pulang khusus">
                                    </div>
                                </div> --}}

                                <div class="section-separator" id="diagnosis">
                                    <h5 class="fw-semibold mb-4">11. Diagnosis</h5>

                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold">Prognosis</label>

                                        <select class="form-select" name="paru_prognosis">
                                            <option value="" selected disabled>--Pilih Prognosis--</option>
                                            @forelse ($satsetPrognosis as $item)
                                                <option value="{{ $item->prognosis_id }}">
                                                    {{ $item->value ?? 'Field tidak ditemukan' }}
                                                </option>
                                            @empty
                                                <option value="" disabled>Tidak ada data</option>
                                            @endforelse
                                        </select>
                                    </div>

                                    <!-- Diagnosis Banding -->
                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                            diagnosis banding, apabila tidak ada, Pilih tanda tambah untuk menambah
                                            keterangan diagnosis banding yang tidak ditemukan.</small>

                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" id="diagnosis-banding-input"
                                                class="form-control border-start-0 ps-0"
                                                placeholder="Cari dan tambah Diagnosis Banding">
                                            <span class="input-group-text bg-white" id="add-diagnosis-banding">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>

                                        <div id="diagnosis-banding-list" class="diagnosis-list bg-light p-3 rounded">
                                            <!-- Diagnosis items will be added here dynamically -->
                                        </div>

                                        <!-- Hidden input to store JSON data -->
                                        <input type="hidden" id="diagnosis_banding" name="diagnosis_banding"
                                            value="[]">
                                    </div>

                                    <!-- Diagnosis Kerja -->
                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                            diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah
                                            keterangan diagnosis kerja yang tidak ditemukan.</small>

                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" id="diagnosis-kerja-input"
                                                class="form-control border-start-0 ps-0"
                                                placeholder="Cari dan tambah Diagnosis Kerja">
                                            <span class="input-group-text bg-white" id="add-diagnosis-kerja">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>

                                        <div id="diagnosis-kerja-list" class="diagnosis-list bg-light p-3 rounded">
                                            <!-- Diagnosis items will be added here dynamically -->
                                        </div>

                                        <!-- Hidden input to store JSON data -->
                                        <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja"
                                            value="[]">
                                    </div>
                                </div>

                                <div class="section-separator" id="implemetasi" style="margin-bottom: 2rem;">
                                    <h5 class="fw-semibold mb-4">12. Implementasi</h5>

                                    <!-- Rencana Penatalaksanaan dan Pengobatan -->
                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold">Rencana Penatalaksanaan dan
                                            Pengobatan</label>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                            rencana, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                            rencana Penatalaksanaan dan Pengobatan kerja yang tidak ditemukan.</small>
                                    </div>

                                    <!-- Observasi Section -->
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2">Observasi</label>
                                        <div class="input-group mt-2">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" id="observasi-input"
                                                class="form-control border-start-0 ps-0"
                                                placeholder="Cari dan tambah Observasi">
                                            <span class="input-group-text bg-white" id="add-observasi">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>
                                        <div id="observasi-list" class="list-group mb-2 bg-light">
                                            <!-- Items will be added here dynamically -->
                                        </div>
                                        <!-- Hidden input to store JSON data -->
                                        <input type="hidden" id="observasi" name="observasi" value="[]">
                                    </div>

                                    <!-- Terapeutik Section -->
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2">Terapeutik</label>
                                        <div class="input-group mt-2">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" id="terapeutik-input"
                                                class="form-control border-start-0 ps-0"
                                                placeholder="Cari dan tambah Terapeutik">
                                            <span class="input-group-text bg-white" id="add-terapeutik">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>
                                        <div id="terapeutik-list" class="list-group mb-2">
                                            <!-- Items will be added here dynamically -->
                                        </div>
                                        <!-- Hidden input to store JSON data -->
                                        <input type="hidden" id="terapeutik" name="terapeutik" value="[]">
                                    </div>

                                    <!-- Edukasi Section -->
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2">Edukasi</label>
                                        <div class="input-group mt-2">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" id="edukasi-input"
                                                class="form-control border-start-0 ps-0"
                                                placeholder="Cari dan tambah Edukasi">
                                            <span class="input-group-text bg-white" id="add-edukasi">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>
                                        <div id="edukasi-list" class="list-group mb-2">
                                            <!-- Items will be added here dynamically -->
                                        </div>
                                        <!-- Hidden input to store JSON data -->
                                        <input type="hidden" id="edukasi" name="edukasi" value="[]">
                                    </div>

                                    <!-- Kolaborasi Section -->
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2">Kolaborasi</label>
                                        <div class="input-group mt-2">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" id="kolaborasi-input"
                                                class="form-control border-start-0 ps-0"
                                                placeholder="Cari dan tambah Kolaborasi">
                                            <span class="input-group-text bg-white" id="add-kolaborasi">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>
                                        <div id="kolaborasi-list" class="list-group mb-2">
                                            <!-- Items will be added here dynamically -->
                                        </div>
                                        <!-- Hidden input to store JSON data -->
                                        <input type="hidden" id="kolaborasi" name="kolaborasi" value="[]">
                                    </div>

                                    <!-- Kolaborasi Section -->
                                    <div class="form-group mb-4">
                                        <label style="min-width: 200px;">Rencana Penatalaksanaan <br> Dan
                                            Pengobatan</label>
                                        <textarea class="form-control" name="rencana_pengobatan" rows="4"
                                            placeholder="Rencana Penatalaksanaan Dan Pengobatan"></textarea>
                                    </div>
                                </div>


                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti-check"></i> Simpan
                                    </button>
                                </div>

                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-ginekologik.modal-create-alergi')

    <!-- JavaScript untuk interaksi form -->
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function untuk mengatur warna card berdasarkan selection
            function updateCardStatus() {
                const cards = document.querySelectorAll('#pemeriksaan-ekstremitas .card');

                cards.forEach(function(card) {
                    const radioButtons = card.querySelectorAll('input[type="radio"]');
                    let hasSelection = false;
                    let hasAbnormal = false;

                    radioButtons.forEach(function(radio) {
                        if (radio.checked) {
                            hasSelection = true;
                            // Check jika ada nilai abnormal (ada, positif)
                            if (radio.value === 'ada' || radio.value === 'positif') {
                                hasAbnormal = true;
                            }
                        }
                    });

                    // Reset classes
                    card.classList.remove('border-success', 'border-warning', 'border-danger');

                    // Apply appropriate border color
                    if (hasSelection) {
                        if (hasAbnormal) {
                            card.classList.add('border-warning');
                        } else {
                            card.classList.add('border-success');
                        }
                    }
                });
            }

            // Add event listeners to all radio buttons
            const allRadios = document.querySelectorAll('#pemeriksaan-ekstremitas input[type="radio"]');
            allRadios.forEach(function(radio) {
                radio.addEventListener('change', updateCardStatus);
            });

            // Validation helper
            function validateEkstremitas() {
                const requiredGroups = [
                    'edema_atas', 'varises_atas', 'refleks_atas',
                    'edema_bawah', 'varises_bawah', 'refleks_bawah'
                ];

                let incompleteFields = [];

                requiredGroups.forEach(function(groupName) {
                    const checked = document.querySelector(`input[name="${groupName}"]:checked`);
                    if (!checked) {
                        incompleteFields.push(groupName.replace('_', ' ').toUpperCase());
                    }
                });

                return {
                    isValid: incompleteFields.length === 0,
                    missingFields: incompleteFields
                };
            }

            // Expose validation function globally if needed
            window.validateEkstremitas = validateEkstremitas;

            // Initial status update
            updateCardStatus();

            // Optional: Add summary display
            function updateSummary() {
                const summary = document.getElementById('ekstremitas-summary');
                if (summary) {
                    let summaryText = '';

                    // Check ekstremitas atas
                    const edemaAtas = document.querySelector('input[name="edema_atas"]:checked');
                    const varisesAtas = document.querySelector('input[name="varises_atas"]:checked');
                    const refleksAtas = document.querySelector('input[name="refleks_atas"]:checked');

                    if (edemaAtas && varisesAtas && refleksAtas) {
                        summaryText +=
                            `Ekstremitas Atas: Edema ${edemaAtas.value}, Varises ${varisesAtas.value}, Refleks ${refleksAtas.value}. `;
                    }

                    // Check ekstremitas bawah
                    const edemaBawah = document.querySelector('input[name="edema_bawah"]:checked');
                    const varisesBawah = document.querySelector('input[name="varises_bawah"]:checked');
                    const refleksBawah = document.querySelector('input[name="refleks_bawah"]:checked');

                    if (edemaBawah && varisesBawah && refleksBawah) {
                        summaryText +=
                            `Ekstremitas Bawah: Edema ${edemaBawah.value}, Varises ${varisesBawah.value}, Refleks ${refleksBawah.value}.`;
                    }

                    summary.textContent = summaryText;
                }
            }

            // Update summary on radio change
            allRadios.forEach(function(radio) {
                radio.addEventListener('change', updateSummary);
            });


            //-------------------------------------------------------------------------//
            // Function untuk auto-resize textarea
            function autoResize(element) {
                element.style.height = 'auto';
                element.style.height = element.scrollHeight + 'px';
            }

            // Apply auto-resize to all textareas in ginekologik section
            const textareas = document.querySelectorAll('#status-ginekologik textarea');
            textareas.forEach(function(textarea) {
                // Initial resize
                autoResize(textarea);

                // Add event listener for dynamic resizing
                textarea.addEventListener('input', function() {
                    autoResize(this);
                });

                // Add focus effect
                textarea.addEventListener('focus', function() {
                    this.parentNode.querySelector('.form-label').classList.add('text-primary');
                });

                textarea.addEventListener('blur', function() {
                    this.parentNode.querySelector('.form-label').classList.remove('text-primary');
                });
            });

            // Function untuk validation
            function validateGinekologik() {
                const fields = [{
                        name: 'keadaan_umum',
                        label: 'Keadaan Umum'
                    },
                    {
                        name: 'status_ginekologik',
                        label: 'Status Ginekologik'
                    },
                    {
                        name: 'pemeriksaan',
                        label: 'Pemeriksaan'
                    },
                    {
                        name: 'inspekulo',
                        label: 'Inspekulo'
                    },
                    {
                        name: 'vt',
                        label: 'VT'
                    },
                    {
                        name: 'rt',
                        label: 'RT'
                    }
                ];

                let emptyFields = [];

                fields.forEach(function(field) {
                    const element = document.querySelector(`[name="${field.name}"]`);
                    if (element && !element.value.trim()) {
                        emptyFields.push(field.label);
                    }
                });

                return {
                    isValid: emptyFields.length === 0,
                    emptyFields: emptyFields
                };
            }

            // Add validation indicators
            const inputs = document.querySelectorAll('#status-ginekologik input, #status-ginekologik textarea');
            inputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    if (this.value.trim()) {
                        this.classList.remove('border-warning');
                        this.classList.add('border-success');
                    } else {
                        this.classList.remove('border-success');
                        this.classList.add('border-warning');
                    }
                });

                // Initial state
                if (input.value.trim()) {
                    input.classList.add('border-success');
                }
            });

            // Character counter for textareas (optional)
            function addCharCounter(textarea, maxLength = 500) {
                const counter = document.createElement('small');
                counter.className = 'text-muted character-counter';
                counter.style.float = 'right';
                textarea.parentNode.insertBefore(counter, textarea.nextSibling);

                function updateCounter() {
                    const remaining = maxLength - textarea.value.length;
                    counter.textContent = `${textarea.value.length}/${maxLength} karakter`;

                    if (remaining < 50) {
                        counter.classList.add('text-warning');
                    } else {
                        counter.classList.remove('text-warning');
                    }
                }

                textarea.addEventListener('input', updateCounter);
                updateCounter();
            }

            // Add character counters to textareas
            textareas.forEach(function(textarea) {
                if (textarea.name !== 'catatan_ginekologik') {
                    addCharCounter(textarea);
                }
            });

            // Expose validation function globally
            window.validateGinekologik = validateGinekologik;

            // Auto-capitalize first letter untuk text inputs
            const textInputs = document.querySelectorAll('#status-ginekologik input[type="text"]');
            textInputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    let value = this.value;
                    if (value.length > 0) {
                        this.value = value.charAt(0).toUpperCase() + value.slice(1);
                    }
                });
            });

        });

        // Riwayat Penyakit
        // Set tanggal hari ini saat halaman load
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('hpht').value = today;
            hitungUsiaKehamilan();
        });

        // Fungsi untuk menghitung usia kehamilan dari HPHT
        function hitungUsiaKehamilan() {
            const hphtInput = document.getElementById('hpht').value;

            if (!hphtInput) {
                clearUsiaKehamilan();
                return;
            }

            const hphtDate = new Date(hphtInput);
            const today = new Date();

            // Reset waktu ke 00:00:00 untuk perhitungan yang akurat
            hphtDate.setHours(0, 0, 0, 0);
            today.setHours(0, 0, 0, 0);

            // Hitung selisih hari
            const diffTime = today.getTime() - hphtDate.getTime();
            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays < 0) {
                // HPHT di masa depan
                document.getElementById('displayUsia').innerHTML =
                    '<span class="text-warning">HPHT tidak boleh di masa depan</span>';
                clearUsiaKehamilan();
                return;
            }

            // Konversi ke minggu dan hari
            const weeks = Math.floor(diffDays / 7);
            const days = diffDays % 7;

            // Update input fields
            document.getElementById('usiaMinggu').value = weeks;
            document.getElementById('usiaHari').value = days;
            document.getElementById('totalHari').value = diffDays;

            // Format display
            let displayText = '';
            if (weeks === 0 && days === 0) {
                displayText = 'Hari ini (HPHT)';
            } else if (weeks === 0) {
                displayText = `${days} hari`;
            } else if (days === 0) {
                displayText = `${weeks} minggu`;
            } else {
                displayText = `${weeks} minggu ${days} hari`;
            }

            document.getElementById('usiaDisplay').value = displayText;
            document.getElementById('displayUsia').innerHTML =
                `<span class="text-success"><strong>${displayText}</strong></span>`;

            // Update informasi tambahan
            updateInfoTambahan(weeks, days, diffDays, hphtDate);

            // Tampilkan info tambahan
            document.getElementById('infoTambahan').style.display = 'block';
        }

        // Update informasi tambahan
        function updateInfoTambahan(weeks, days, totalDays, hphtDate) {
            // Tentukan trimester
            let trimester = '';
            if (weeks < 13) {
                trimester = 'I (0-12 minggu)';
            } else if (weeks < 27) {
                trimester = 'II (13-26 minggu)';
            } else {
                trimester = 'III (27+ minggu)';
            }

            document.getElementById('trimester').textContent = trimester;
            document.getElementById('totalHariDisplay').textContent = totalDays + ' hari';

            // Hitung perkiraan tanggal lahir (HPHT + 280 hari)
            const perkiraanLahir = new Date(hphtDate);
            perkiraanLahir.setDate(perkiraanLahir.getDate() + 280);

            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            document.getElementById('perkiraanLahir').textContent =
                perkiraanLahir.toLocaleDateString('id-ID', options);
        }

        // Clear usia kehamilan
        function clearUsiaKehamilan() {
            document.getElementById('usiaMinggu').value = '';
            document.getElementById('usiaHari').value = '';
            document.getElementById('totalHari').value = '';
            document.getElementById('usiaDisplay').value = '';
            document.getElementById('displayUsia').textContent = 'Pilih tanggal HPHT untuk menghitung';
            document.getElementById('infoTambahan').style.display = 'none';
        }

        // pemeriksaan fisik baru
        document.addEventListener('DOMContentLoaded', function() {
            // Function to toggle keterangan input based on radio selection
            function toggleKeteranganInput(radioName, keteranganId) {
                const radios = document.getElementsByName(radioName);
                const keteranganInput = document.getElementById(keteranganId);

                if (!keteranganInput) return;

                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        if (this.value === '0') { // Abnormal
                            keteranganInput.disabled = false;
                            keteranganInput.focus();
                        } else { // Normal
                            keteranganInput.disabled = true;
                            keteranganInput.value = '';
                        }
                    });
                });

                // Initialize state
                const selectedRadio = Array.from(radios).find(radio => radio.checked);
                if (selectedRadio) {
                    keteranganInput.disabled = selectedRadio.value !== '0';
                }
            }

            // Apply toggle functionality
            toggleKeteranganInput('kepala', 'kepala_keterangan');
            toggleKeteranganInput('hidung', 'hidung_keterangan');
            toggleKeteranganInput('mata', 'mata_keterangan');
            toggleKeteranganInput('leher', 'leher_keterangan');
            toggleKeteranganInput('tenggorokan', 'tenggorokan_keterangan');
            toggleKeteranganInput('jantung', 'jantung_keterangan');
            toggleKeteranganInput('paru', 'paru_keterangan');
            toggleKeteranganInput('hati', 'hati_keterangan');
            toggleKeteranganInput('limpa', 'limpa_keterangan');
            toggleKeteranganInput('tenggorokan2', 'tenggorokan2_keterangan');
            toggleKeteranganInput('kulit', 'kulit_keterangan');
            toggleKeteranganInput('mulut_gigi', 'mulut_gigi_keterangan');

        });
    </script>
@endpush
