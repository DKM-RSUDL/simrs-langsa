@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <style>
            .badge {
                width: 30px;
                height: 30px;
                border-radius: 50%;
            }

            .badge-triage-yellow {
                background-color: #ffeb3b;
            }

            .badge-triage-red {
                background-color: #f44336;
            }

            .badge-triage-green {
                background-color: #4caf50;
            }

            /* Custom CSS for profile */
            .profile {
                display: flex;
                align-items: center;
            }

            .profile img {
                margin-right: 10px;
                border-radius: 50%;
            }

            .profile .info {
                display: flex;
                flex-direction: column;
            }

            .profile .info strong {
                font-size: 14px;
            }

            .profile .info span {
                font-size: 12px;
                color: #777;
            }

            .select2-container {
                z-index: 9999;
            }

            .modal-dialog {
                z-index: 1050 !important;
            }

            .modal-content {
                overflow: visible !important;
            }

            .select2-dropdown {
                z-index: 99999 !important;
            }

            /* Menghilangkan elemen Select2 yang tidak diinginkan */
            .select2-container+.select2-container {
                display: none;
            }

            /* Menyamakan tampilan Select2 dengan Bootstrap */
            .select2-container--default .select2-selection--single {
                height: calc(1.5em + 0.75rem + 2px);
                padding: 0.375rem 0.75rem;
                font-size: 1rem;
                font-weight: 400;
                line-height: 1.5;
                color: #495057;
                background-color: #fff;
                border: 1px solid #ced4da;
                border-radius: 0.25rem;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 1.5;
                padding-left: 0;
                padding-right: 0;
                color: #495057;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: calc(1.5em + 0.75rem);
                position: absolute;
                top: 1px;
                right: 1px;
                width: 20px;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow b {
                border-color: #6c757d transparent transparent transparent;
            }

            .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
                border-color: transparent transparent #6c757d transparent;
            }

            .select2-container--default .select2-dropdown {
                border-color: #80bdff;
                border-radius: 0.25rem;
            }

            .select2-container--default .select2-results__option--highlighted[aria-selected] {
                background-color: #007bff;
            }

            /* Fokus */
            .select2-container--default.select2-container--focus .select2-selection--single {
                border-color: #80bdff;
                outline: 0;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }

            .emergency__container {
                display: flex;
                align-items: center;
                gap: 20px;
            }

            .custom__card {
                background: linear-gradient(to bottom, #e0f7ff, #a5d8ff);
                border: 2px solid #a100c9;
                border-radius: 15px;
                padding: 8px 15px;
                width: fit-content;
                min-width: 150px;
                display: flex;
                align-items: center;
                gap: 20px;
            }

            .user__icon {
                width: 40px;
                height: 40px;
            }

            .dropdown-submenu {
                position: relative;
            }

            .dropdown-submenu>.dropdown-menu {
                top: 0;
                left: 100%;
                margin-top: -6px;
                margin-left: -1px;
            }

            .dropdown-submenu:hover>.dropdown-menu {
                display: block;
            }

            .dropdown-submenu>a.dropdown-toggle {
                position: relative;
                padding-right: 30px;
            }

            .dropdown-submenu>a.dropdown-toggle::after {
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
            }

            .dropdown-submenu:hover>a.dropdown-toggle::after {
                transform: translateY(-50%) rotate(-90deg);
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-12">
            <div class="emergency__container">
                <h4 class="fw-bold">Gawat Darurat</h4>
                <div class="custom__card">
                    <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="User Icon" class="user__icon">
                    <div class="text-center">
                        <p class="m-0 p-0">Aktif</p>
                        <p class="m-0 p-0 fs-4 fw-bold">{{ countActivePatientIGD() }}</p>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end align-items-end gap-3">
                <div class="d-flex align-items-center">
                    <label for="dokterSelect" class="form-label me-2">Dokter:</label>
                    <select class="form-select" id="dokterSelect" aria-label="Pilih dokter">
                        <option value="" selected>Semua</option>
                        @foreach ($dokter as $d)
                            <option value="{{ $d->dokter->kd_dokter }}">{{ $d->dokter->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>

                @canany(['is-admin', 'is-dokter-umum'])
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addPatientTriage">
                        <i class="ti-plus"></i> Tambah Data
                    </button>
                @endcanany
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="table-responsive text-left">
                <table class="table table-bordered dataTable" id="rawatDaruratTable">
                    <thead>
                        <tr>
                            <th width="100px">Aksi</th>
                            <th>Pasien</th>
                            <th>Triase</th>
                            <th>Bed</th>
                            <th>No RM / Reg</th>
                            <th>Alamat</th>
                            <th>Jaminan</th>
                            <th>Tgl Masuk</th>
                            <th>Dokter</th>
                            <th>Instruksi</th>
                            <th>Del</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Tabel diisi oleh DataTables --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addPatientTriage" tabindex="-1" aria-labelledby="addPatientTriageLabel" aria-hidden="true">
        <div class="container-fluid">
            <div class="modal-dialog modal-fullscreen h-auto w-100">
                <div class="modal-content">
                    <form action="{{ route('gawat-darurat.store-triase') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="addPatientTriageLabel">
                                Triase Pasien Gawat Darurat
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-3">

                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="text-primary fw-bold">Identitas Awal Pasien</h5>
                                                    <p>Isikan minimal nama, JK dan usia pasien</p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="">
                                                        <p>
                                                            <strong class="text-primary">No RM : </strong>
                                                            <span id="no_rm_label"></span>
                                                        </p>
                                                        <input type="hidden" name="no_rm" id="no_rm">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="#dokter_triase">
                                                            <p class="text-primary m-0 p-0">
                                                                <strong>Dokter Triase :</strong>
                                                            </p>
                                                        </label>
                                                        <select name="dokter_triase" id="dokter_triase"
                                                            class="form-select @error('dokter_triase') is-invalid @enderror"
                                                            required>
                                                            <option value="">--Pilih Dokter--</option>
                                                            @foreach ($dokter as $dok)
                                                                <option value="{{ $dok->dokter->kd_dokter }}"
                                                                    @selected($dok->dokter->kd_karyawan == auth()->user()->kd_karyawan)>
                                                                    {{ $dok->dokter->nama_lengkap }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group mt-3">
                                                        <label for="">
                                                            <p class="text-primary m-0 p-0">
                                                                <strong>Tanggal dan Jam Masuk :</strong>
                                                            </p>
                                                        </label>
                                                        <div class="d-flex">
                                                            <input type="date" name="tgl_masuk" id="tgl_masuk"
                                                                class="form-control @error('tgl_masuk') is-invalid @enderror"
                                                                value="{{ old('tgl_masuk', date('Y-m-d')) }}" required>
                                                            <input type="time" name="jam_masuk" id="jam_masuk"
                                                                class="form-control @error('jam_masuk') is-invalid @enderror ms-2"
                                                                value="{{ old('jam_masuk', date('H:i')) }}" required>
                                                        </div>

                                                        @error('tgl_masuk')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror

                                                        @error('jam_masuk')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group mt-3">
                                                        <label for="#nik_pasien">
                                                            <p class="text-primary m-0 p-0">
                                                                <strong>NIK Pasien :</strong>
                                                            </p>
                                                        </label>
                                                        <div class="input-group mb-3">
                                                            <input type="text" name="nik_pasien" id="nik_pasien"
                                                                class="form-control" placeholder="Nik Pasien"
                                                                aria-label="Nik Pasien"
                                                                aria-describedby="button-nik-pasien"
                                                                value="{{ old('nik_pasien') }}">
                                                            <button class="btn btn-outline-secondary" type="button"
                                                                id="button-nik-pasien">
                                                                <i class="ti ti-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mt-3">
                                                        <label for="#nama_pasien">
                                                            <p class="text-primary m-0 p-0">
                                                                <strong>Nama Pasien :</strong>
                                                            </p>
                                                        </label>
                                                        <input type="text" name="nama_pasien" id="nama_pasien"
                                                            class="form-control @error('nama_pasien') is-invalid @enderror"
                                                            value="{{ old('nama_pasien') }}" required>

                                                        @error('nama_pasien')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group mt-3">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                <label for="#jenis_kelamin">
                                                                    <p class="text-primary m-0 p-0">
                                                                        <strong>Jenis Kelamin:</strong>
                                                                    </p>
                                                                </label>
                                                                <select name="jenis_kelamin" id="jenis_kelamin"
                                                                    class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                                                    required>
                                                                    <option value="">--Pilih--</option>
                                                                    <option value="1" @selected(old('jenis_kelamin') == '1')>
                                                                        Laki-laki</option>
                                                                    <option value="0" @selected(old('jenis_kelamin') == '0')>
                                                                        Perempuan</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-4">
                                                                <label for="#usia_tahun">
                                                                    <p class="text-primary m-0 p-0">
                                                                        <strong>Usia (Tahun):</strong>
                                                                    </p>
                                                                </label>
                                                                <input type="number" name="usia_tahun" id="usia_tahun"
                                                                    class="form-control" value="{{ old('usia_tahun') }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <label for="#usia_bulan">
                                                                    <p class="text-primary m-0 p-0">
                                                                        <strong>Bulan:</strong>
                                                                    </p>
                                                                </label>
                                                                <input type="number" name="usia_bulan" id="usia_bulan"
                                                                    min="0" max="11" class="form-control"
                                                                    value="{{ old('usia_bulan') }}">
                                                            </div>
                                                        </div>

                                                        @error('jenis_kelamin')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                        @error('usia_bulan')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group mt-3">
                                                        <div class="d-flex align-items-center">
                                                            <p class="text-primary fw-bold m-0 p-0">Rujukan</p>
                                                            <div class="form-check mx-5">
                                                                <input
                                                                    class="form-check-input @error('rujukan') is-invalid @enderror"
                                                                    type="radio" name="rujukan" id="rujukan_yes"
                                                                    value="1" @checked(old('rujukan') == '1') required>
                                                                <label class="form-check-label" for="rujukan_yes">
                                                                    Ya
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input
                                                                    class="form-check-input @error('rujukan') is-invalid @enderror"
                                                                    type="radio" name="rujukan" id="rujukan_no"
                                                                    value="0" @checked(old('rujukan') == '0') required>
                                                                <label class="form-check-label" for="rujukan_no">
                                                                    Tidak
                                                                </label>
                                                            </div>
                                                        </div>

                                                        @error('rujukan')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group mt-1">
                                                        <label for="#rujukan_ket" class="text-primary">Jika ya,
                                                            dari</label>
                                                        <input type="text" name="rujukan_ket" id="rujukan_ket"
                                                            class="form-control" value="{{ old('rujukan_ket') }}">
                                                    </div>

                                                    <div class="form-group mt-3 w-100">
                                                        <p class="text-primary fw-bold m-0 p-0">Foto Pasien</p>

                                                        <div id="fotoPasienlabel" tabindex="0"
                                                            class="form-control px-5 @error('foto_pasien') is-invalid @enderror">
                                                            <div class="text-center py-5">
                                                                <img src="{{ asset('assets/images/avatar1.png') }}"
                                                                    alt="" width="150">
                                                            </div>
                                                            <p class="fw-bold">
                                                                <i class="bi bi-camera-fill text-primary"></i>
                                                                Upload gambar pasien
                                                            </p>
                                                        </div>

                                                        <input type="file" name="foto_pasien" id="foto_pasien"
                                                            class="d-none">
                                                        @error('foto_pasien')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-9">

                                    <div class="card">
                                        <div class="card-header bg-primary">
                                            <h4 class="text-white mb-2">Triase Pasien Gawat Darurat (Skala ATS)</h4>
                                            <p class="text-white m-0 p-0 fw-light">Isikan triase pada saat pasien masuk</p>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mt-5">
                                                <div class="col-12">
                                                    <div class="card mb-3">
                                                        <div class="card-header border-bottom">
                                                            <p class="m-0 p-0 fw-bold">Vital Sign</p>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row mt-2">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="sistole">TD (Sistole)</label>
                                                                        <input type="number" name="sistole" id="sistole" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="diastole">TD (Diastole)</label>
                                                                        <input type="number" name="diastole" id="diastole" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="nadi">Nadi (x/mnt)</label>
                                                                        <input type="number" name="nadi" id="nadi" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="respiration">Resp (x/mnt)</label>
                                                                        <input type="number" name="respiration" id="respiration" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="suhu">Suhu &deg;C</label>
                                                                        <input type="number" name="suhu" id="suhu" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-2">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="spo2_tanpa_o2">SpO2 (tanpa O2)</label>
                                                                        <input type="number" name="spo2_tanpa_o2" id="spo2_tanpa_o2" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="spo2_dengan_o2">SpO2 (dengan O2)</label>
                                                                        <input type="number" name="spo2_dengan_o2" id="spo2_dengan_o2" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="tinggi_badan">TB (cm)</label>
                                                                        <input type="number" name="tinggi_badan" id="tinggi_badan" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="berat_badan">BB (cm)</label>
                                                                        <input type="number" name="berat_badan" id="berat_badan" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-5">
                                                <div class="col-3">

                                                    <div class="card mb-3">
                                                        <div class="card-header border-bottom">
                                                            <p class="m-0 p-0 fw-bold">Air Way</p>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="form-check mt-3">
                                                                <input class="form-check-input false-emergency-check"
                                                                    type="checkbox" name="airway[]" value="Bebas"
                                                                    id="airway_bebas">
                                                                <label class="form-check-label" for="airway_bebas">
                                                                    Bebas
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input emergency-check"
                                                                    type="checkbox" name="airway[]" value="Ancaman"
                                                                    id="airway_ancaman">
                                                                <label class="form-check-label" for="airway_ancaman">
                                                                    Ancaman
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input resusitasi-check"
                                                                    type="checkbox" name="airway[]" value="Sumbatan"
                                                                    id="airway_sumbatan">
                                                                <label class="form-check-label" for="airway_sumbatan">
                                                                    Sumbatan
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input doa-check" type="checkbox"
                                                                    name="airway[]"
                                                                    value="Tidak ada tanda-tanda kehidupan"
                                                                    id="airway_mati">
                                                                <label class="form-check-label" for="airway_mati">
                                                                    Tidak ada tanda-tanda kehidupan
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-3">

                                                    <div class="card mb-3">
                                                        <div class="card-header border-bottom">
                                                            <p class="m-0 p-0 fw-bold">Breathing</p>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="form-check mt-3">
                                                                <input class="form-check-input false-emergency-check"
                                                                    type="checkbox" name="breathing[]" value="Normal"
                                                                    id="breathing_normal">
                                                                <label class="form-check-label" for="breathing_normal">
                                                                    Normal
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input urgent-check"
                                                                    type="checkbox" name="breathing[]" value="Mengi"
                                                                    id="breathing_Mengi">
                                                                <label class="form-check-label" for="breathing_Mengi">
                                                                    Mengi
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input emergency-check"
                                                                    type="checkbox" name="breathing[]" value="Takipnoe"
                                                                    id="breathing_takipnoe">
                                                                <label class="form-check-label" for="breathing_takipnoe">
                                                                    Takipnoe
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input emergency-check"
                                                                    type="checkbox" name="breathing[]"
                                                                    value="RR > 20 X/mnt" id="breathing_rr">
                                                                <label class="form-check-label" for="breathing_rr">
                                                                    RR > 20 X/mnt
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input resusitasi-check"
                                                                    type="checkbox" name="breathing[]"
                                                                    value="Henti Nafas" id="breathing_henti_nafas">
                                                                <label class="form-check-label"
                                                                    for="breathing_henti_nafas">
                                                                    Henti Nafas
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input resusitasi-check"
                                                                    type="checkbox" name="breathing[]" value="Bradipnoe"
                                                                    id="breathing_bradipnoe">
                                                                <label class="form-check-label" for="breathing_bradipnoe">
                                                                    Bradipnoe
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input doa-check" type="checkbox"
                                                                    name="breathing[]" value="Tidak ada denyut nadi"
                                                                    id="breathing_mati">
                                                                <label class="form-check-label" for="breathing_mati">
                                                                    Tidak ada denyut nadi
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-3">

                                                    <div class="card mb-3">
                                                        <div class="card-header border-bottom">
                                                            <p class="m-0 p-0 fw-bold">Circulation</p>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="form-check mt-3">
                                                                <input class="form-check-input false-emergency-check"
                                                                    type="checkbox" name="circulation[]"
                                                                    value="Nadi Kuat" id="circulation_nadi_kuat">
                                                                <label class="form-check-label"
                                                                    for="circulation_nadi_kuat">
                                                                    Nadi Kuat
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input false-emergency-check"
                                                                    type="checkbox" name="circulation[]"
                                                                    value="Frekuensi Normal"
                                                                    id="circulation_frekuensi_normal">
                                                                <label class="form-check-label"
                                                                    for="circulation_frekuensi_normal">
                                                                    Frekuensi Normal
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input false-emergency-check"
                                                                    type="checkbox" name="circulation[]"
                                                                    value="TD sistole 90-159 mmHg"
                                                                    id="circulation_sistole_90_159">
                                                                <label class="form-check-label"
                                                                    for="circulation_sistole_90_159">
                                                                    TD sistole 90-159 mmHg
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input urgent-check"
                                                                    type="checkbox" name="circulation[]"
                                                                    value="TD sistole >= 160 atau <= 90"
                                                                    id="circulation_sistole_160_90">
                                                                <label class="form-check-label"
                                                                    for="circulation_sistole_160_90">
                                                                    TD sistole >= 160 atau <= 90 </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input emergency-check"
                                                                    type="checkbox" name="circulation[]"
                                                                    value="Nadi Lemah" id="circulation_nadi_lemah">
                                                                <label class="form-check-label"
                                                                    for="circulation_nadi_lemah">
                                                                    Nadi Lemah
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input emergency-check"
                                                                    type="checkbox" name="circulation[]"
                                                                    value="Bradikardia" id="circulation_bradikardia">
                                                                <label class="form-check-label"
                                                                    for="circulation_bradikardia">
                                                                    Bradikardia
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input emergency-check"
                                                                    type="checkbox" name="circulation[]"
                                                                    value="Takikardi" id="circulation_takikardi">
                                                                <label class="form-check-label"
                                                                    for="circulation_takikardi">
                                                                    Takikardi
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input emergency-check"
                                                                    type="checkbox" name="circulation[]" value="Pucat"
                                                                    id="circulation_pucat">
                                                                <label class="form-check-label" for="circulation_pucat">
                                                                    Pucat
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input emergency-check"
                                                                    type="checkbox" name="circulation[]"
                                                                    value="CRT > 2 detik" id="circulation_crt">
                                                                <label class="form-check-label" for="circulation_crt">
                                                                    CRT > 2 detik
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input emergency-check"
                                                                    type="checkbox" name="circulation[]"
                                                                    value="Tanda-tanda dehidrasi sedang-berat"
                                                                    id="circulation_dehidrasi">
                                                                <label class="form-check-label"
                                                                    for="circulation_dehidrasi">
                                                                    Tanda-tanda dehidrasi sedang-berat
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input emergency-check"
                                                                    type="checkbox" name="circulation[]"
                                                                    value="Suhu > 40 C" id="circulation_suhu">
                                                                <label class="form-check-label" for="circulation_suhu">
                                                                    Suhu > 40 C
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input resusitasi-check"
                                                                    type="checkbox" name="circulation[]"
                                                                    value="Henti Jantung / Ketiadaan Sirkulasi"
                                                                    id="circulation_henti_jantung">
                                                                <label class="form-check-label"
                                                                    for="circulation_henti_jantung">
                                                                    Henti Jantung / Ketiadaan Sirkulasi
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input resusitasi-check"
                                                                    type="checkbox" name="circulation[]"
                                                                    value="Nadi tak teraba"
                                                                    id="circulation_nadi_tak_teraba">
                                                                <label class="form-check-label"
                                                                    for="circulation_nadi_tak_teraba">
                                                                    Nadi tak teraba
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input resusitasi-check"
                                                                    type="checkbox" name="circulation[]" value="Sianosis"
                                                                    id="circulation_cianosis">
                                                                <label class="form-check-label"
                                                                    for="circulation_cianosis">
                                                                    Sianosis
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-3">

                                                    <div class="card mb-3">
                                                        <div class="card-header border-bottom">
                                                            <p class="m-0 p-0 fw-bold">Disability</p>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="form-check mt-3">
                                                                <input class="form-check-input false-emergency-check"
                                                                    type="checkbox" name="disability[]" value="Sadar"
                                                                    id="disability_sadar">
                                                                <label class="form-check-label" for="disability_sadar">
                                                                    Sadar
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input false-emergency-check"
                                                                    type="checkbox" name="disability[]" value="GCS 15"
                                                                    id="disability_gcs_15">
                                                                <label class="form-check-label" for="disability_gcs_15">
                                                                    GCS 15
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input urgent-check"
                                                                    type="checkbox" name="disability[]" value="GCS >= 12"
                                                                    id="disability_gcs_12">
                                                                <label class="form-check-label" for="disability_gcs_12">
                                                                    GCS >= 12
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input emergency-check"
                                                                    type="checkbox" name="disability[]" value="GCS 9-12"
                                                                    id="disability_gcs_9_12">
                                                                <label class="form-check-label" for="disability_gcs_9_12">
                                                                    GCS 9-12
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input emergency-check"
                                                                    type="checkbox" name="disability[]" value="Gelisah"
                                                                    id="disability_gelisah">
                                                                <label class="form-check-label" for="disability_gelisah">
                                                                    Gelisah
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input emergency-check"
                                                                    type="checkbox" name="disability[]"
                                                                    value="Nyeri Dada" id="disability_nyeri_dada">
                                                                <label class="form-check-label"
                                                                    for="disability_nyeri_dada">
                                                                    Nyeri Dada
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input emergency-check"
                                                                    type="checkbox" name="disability[]"
                                                                    value="Hemiparese Akut"
                                                                    id="disability_hemiparese_akut">
                                                                <label class="form-check-label"
                                                                    for="disability_hemiparese_akut">
                                                                    Hemiparese Akut
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input resusitasi-check"
                                                                    type="checkbox" name="disability[]" value="GCS < 9"
                                                                    id="disability_gcs_under_9">
                                                                <label class="form-check-label"
                                                                    for="disability_gcs_under_9">
                                                                    GCS < 9 </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input resusitasi-check"
                                                                    type="checkbox" name="disability[]"
                                                                    value="Tidak ada respon" id="disability_no_respon">
                                                                <label class="form-check-label"
                                                                    for="disability_no_respon">
                                                                    Tidak ada respon
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input resusitasi-check"
                                                                    type="checkbox" name="disability[]" value="Kejang"
                                                                    id="disability_kejang">
                                                                <label class="form-check-label" for="disability_kejang">
                                                                    Kejang
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="row mt-5">
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center w-100">
                                                        <p class="fw-medium text-primary m-0 p-0">Kesimpulan Triase :</p>
                                                        <button type="button" id="triaseStatusLabel"
                                                            class="btn btn-block ms-3 w-100"></button>
                                                        <input type="hidden" name="kd_triase" id="kd_triase">
                                                        <input type="hidden" name="ket_triase" id="ket_triase">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var gawatDaruratIndexUrl = "{{ route('gawat-darurat.index') }}";
        var medisGawatDaruratIndexUrl = "{{ url('unit-pelayanan/gawat-darurat/pelayanan/') }}/";

        $(document).ready(function() {
            $('#rawatDaruratTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: gawatDaruratIndexUrl,
                    data: function(d) {
                        d.dokter = $('#dokterSelect').val();
                    }
                },
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `<div class="d-flex justify-content-center">
                                        <a href="${medisGawatDaruratIndexUrl + row.kd_pasien}/${row.tgl_masuk}" class="edit btn btn-outline-primary btn-sm">
                                                <i class="ti-pencil-alt"></i>
                                        </a>

                                        <div class="dropdown mx-1">
                                            <button class="btn btn-outline-secondary btn-sm btn-dropdown" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>

                                            <ul class="dropdown-menu shadow-lg">
                                                <li><a class="dropdown-item m-1" href="#">Update Informasi Pasien</a></li>
                                                <li><a class="dropdown-item m-1" href="#">Identitas Pasien</a></li>
                                                <li><a class="dropdown-item m-1" href="${medisGawatDaruratIndexUrl + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/general-consent'}">General Concent</a></li>
                                                <li><a class="dropdown-item m-1" href="#">Edukasi dan Informasi</a></li>
                                                <li><a class="dropdown-item m-1" href="#">Jaminan/Asuransi</a></li>
                                                <li><a class="dropdown-item m-1" href="#">Pengantar Rawat Inap</a></li>
                                                <li><a class="dropdown-item m-1" href="${medisGawatDaruratIndexUrl + row.kd_pasien}/${row.tgl_masuk}/${row.urut_masuk}/transfer-rwi">Registrasi Rawat Inap</a></li>
                                                <li class="dropdown-submenu">
                                                    <a class="dropdown-item m-1 dropdown-toggle" href="#">Mutasi Pasien</a>
                                                    <ul class="dropdown-menu shadow-lg">
                                                        <li><a class="dropdown-item m-1" href="${medisGawatDaruratIndexUrl + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/serah-terima-pasien'}">Pindah Ruangan / Rawat Inap</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Pulangkan (Berobat Jalan)</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Pulangkan (APS)</a></li>
                                                        <li><a class="dropdown-item m-1" href="${medisGawatDaruratIndexUrl + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/rujuk-antar-rs'}">Rujuk Keluar RS</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Meninggal Dunia</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Batal Berobat</a></li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown-submenu">
                                                    <a class="dropdown-item m-1 dropdown-toggle" href="#">Order Pelayanan</a>
                                                    <ul class="dropdown-menu shadow-lg">
                                                        <li><a class="dropdown-item m-1" href="#">Operasi</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Rehabilitasi Medis</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Hemodialisa</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Forensik</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Cath Lab</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Rujukan/Ambulance</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Tindakan Klinik</a></li>
                                                    </ul>
                                                </li>
                                                <li><a class="dropdown-item m-1" href="#">Billing System</a></li>
                                                <li><a class="dropdown-item m-1" href="#">Finalisasi</a></li>
                                                <li><a class="dropdown-item m-1" href="#">Status Pasien</a></li>
                                                <li><a class="dropdown-item m-1" href="${medisGawatDaruratIndexUrl + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/permintaan-darah'}">Permintaan Darah</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    `;
                        }
                    },
                    {
                        data: 'profile',
                        name: 'profile',
                        render: function(data, type, row) {
                            let imageUrl = row.foto_pasien ? "{{ asset('storage/') }}" + '/' + row
                                .foto_pasien : "{{ asset('assets/images/avatar1.png') }}";
                            let gender = row.pasien.jenis_kelamin == '1' ? 'Laki-Laki' :
                                'Perempuan';
                            return `
                                <div class="profile">
                                    <img src="${imageUrl}" alt="Profile" width="50" height="50" class="rounded-circle"/>
                                    <div class="info">
                                        <strong>${row.pasien.nama}</strong>
                                        <span>${gender} / ${row.umur} Tahun</span>
                                    </div>
                                </div>
                            `;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'triase',
                        name: 'triase',
                        render: function(data, type, row) {
                            let kdTriase = row.kd_triase;
                            let classEl = '';

                            if (kdTriase == 5) classEl = 'bg-dark';
                            if (kdTriase == 4 || kdTriase == 3) classEl = 'bg-danger';
                            if (kdTriase == 2) classEl = 'bg-warning';
                            if (kdTriase == 1) classEl = 'bg-success';

                            return `<div class="rounded-circle ${classEl}" style="width: 35px; height: 35px;"></div>`;
                        },
                        defaultContent: 'null'
                    },
                    {
                        data: 'bed',
                        name: 'bed',
                        defaultContent: ''
                    },
                    {
                        data: 'kd_pasien',
                        name: 'kd_pasien',
                        render: function(data, type, row) {
                            // Assuming row.kd_pasien is the "RM" and row.reg_number is the "Reg" value
                            return `
                            <div class="rm-reg">
                                RM: ${row.kd_pasien ? row.kd_pasien : 'N/A'}<br>
                                Reg: ${row.reg_number ? row.reg_number : 'N/A'}
                            </div>
                        `;
                        },
                        defaultContent: ''
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                        defaultContent: ''
                    },
                    {
                        data: 'jaminan',
                        name: 'jaminan',
                        defaultContent: ''
                    },
                    {
                        data: 'waktu_masuk',
                        name: 'tgl_masuk',
                        defaultContent: 'null'
                    },
                    {
                        data: 'kd_dokter',
                        name: 'kd_dokter',
                        defaultContent: 'null'
                    },
                    {
                        data: 'instruksi',
                        name: 'instruksi',
                        defaultContent: ''
                    },
                    {
                        data: 'del',
                        name: 'del',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<a href="#" class="edit btn btn-danger btn-sm"><i class="bi bi-x-circle"></i></a>';
                        }
                    },
                ],
                paging: true,
                lengthChange: true,
                searching: true,
                orderCellsTop: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
            });

            initSelect2();

            let rujukanVal = $('#addPatientTriage input[name="rujukan"]').val();
            if (rujukanVal == '1') $('#addPatientTriage #rujukan_ket').prop('required', true);


            $('.dropdown-submenu').hover(
                function() {
                    $(this).find('.dropdown-menu').addClass('show');
                },
                function() {
                    $(this).find('.dropdown-menu').removeClass('show');
                }
            );
        });


        // Foto Upload
        $('#fotoPasienlabel').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#foto_pasien').trigger('click');
        });

        $('#foto_pasien').on('change', function(e) {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    if (e.target && e.target.result) {
                        $('#fotoPasienlabel .text-center').html(`<img src="${e.target.result}" width="200">`);
                    } else {
                        showToast('error', 'Terjadi kesalahan server saat memilih file gambar!');
                    }
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Triase Item Check
        // Perubahan pada checkbox DOA
        $('#addPatientTriage .doa-check').change(function(e) {
            // kalau ada checkbox doa yang di check disable semua checkbox non DOA
            let doaChecked = $('#addPatientTriage .doa-check:checked').length > 0;
            $('#addPatientTriage input[type="checkbox"]').not('.doa-check').prop('disabled', doaChecked);

            updateTriaseStatus();
        });

        // perubahan pada checkbox non DOA
        $('#addPatientTriage input[type="checkbox"]').not('.doa-check').change(function(e) {
            // kalau ada checkbox non doa di check maka disable semua checkbox doa
            let nonDoaChecked = $('#addPatientTriage input[type="checkbox"]:checked').not('.doa-check').length > 0;
            $('#addPatientTriage input[type="checkbox"].doa-check').prop('disabled', nonDoaChecked);

            updateTriaseStatus();
        });

        function updateTriaseStatus() {
            var status = '';
            var kode_triase = '';

            // Menetapkan prioritas dari tinggi ke rendah
            if ($('#addPatientTriage .doa-check:checked').length > 0) {
                status = 'DOA';
                kode_triase = 5;
            } else if ($('#addPatientTriage .resusitasi-check:checked').length > 0) {
                status = 'RESUSITASI (segera)';
                kode_triase = 4;
            } else if ($('#addPatientTriage .emergency-check:checked').length > 0) {
                status = 'EMERGENCY (10 menit)';
                kode_triase = 3;
            } else if ($('#addPatientTriage .urgent-check:checked').length > 0) {
                status = 'URGENT (30 menit)';
                kode_triase = 2;
            } else if ($('#addPatientTriage .false-emergency-check:checked').length > 0) {
                status = 'FALSE EMERGENCY (60 menit)';
                kode_triase = 1;
            }

            $('#addPatientTriage #triaseStatusLabel').text(status).attr('class', determineClass(status));
            $('#addPatientTriage #kd_triase').val(kode_triase);
            $('#addPatientTriage #ket_triase').val(status);
        }

        function determineClass(status) {
            switch (status) {
                case 'RESUSITASI (segera)':
                    return 'btn btn-block btn-danger ms-3 w-100';
                case 'EMERGENCY (10 menit)':
                    return 'btn btn-block btn-danger ms-3 w-100';
                case 'URGENT (30 menit)':
                    return 'btn btn-block btn-warning ms-3 w-100';
                case 'FALSE EMERGENCY (60 menit)':
                    return 'btn btn-block btn-success ms-3 w-100';
                case 'DOA':
                    return 'btn btn-block btn-dark ms-3 w-100';
                default:
                    return 'btn btn-block ms-3 w-100';
            }
        }

        // Input Rujukan Change
        $('#addPatientTriage input[name="rujukan"]').change(function(e) {
            let $this = $(this);
            let rujukanValue = $this.val();


            // kalau value y input rujukan ket required, kalau n input rujukan ket disabled
            if (rujukanValue == '1') {
                $('#addPatientTriage #rujukan_ket').prop('required', true);
                $('#addPatientTriage #rujukan_ket').prop('readonly', false);
            } else {
                $('#addPatientTriage #rujukan_ket').val('');
                $('#addPatientTriage #rujukan_ket').prop('required', false);
                $('#addPatientTriage #rujukan_ket').prop('readonly', true);
            }
        });

        // Reinisialisasi Select2 ketika modal dibuka
        $('#addPatientTriage').on('shown.bs.modal', function() {
            let $this = $(this);

            @cannot('is-admin')
                @cannot('is-perawat')
                    @cannot('is-bidan')
                        $this.find('#dokter_triase').mousedown(function(e) {
                            e.preventDefault();
                        });
                    @endcannot
                @endcannot
            @endcannot

            // Destroy existing Select2 instance before reinitializing
            initSelect2();
        });

        function initSelect2() {
            $('#addPatientTriage .select2').select2({
                dropdownParent: $('#addPatientTriage'),
                width: '100%'
            });
        }

        function isNumber(value) {
            return !isNaN(parseFloat(value)) && isFinite(value);
        }

        function hitungUmur(tanggalLahir) {
            // Parsing tanggal lahir
            const tglLahir = new Date(tanggalLahir);

            // Tanggal hari ini
            const hariIni = new Date();

            // Menghitung selisih tahun
            let tahun = hariIni.getFullYear() - tglLahir.getFullYear();
            let bulan = hariIni.getMonth() - tglLahir.getMonth();

            // Menyesuaikan jika bulan lahir belum terlewati tahun ini
            if (bulan < 0 || (bulan === 0 && hariIni.getDate() < tglLahir.getDate())) {
                tahun--;
                bulan += 12;
            }

            // Menghitung sisa bulan
            bulan = bulan % 12;

            return {
                tahun,
                bulan
            };
        }

        function getWaktuSekarang() {
            const sekarang = new Date();

            // Format tanggal (Y-m-d)
            const tahun = sekarang.getFullYear();
            const bulan = String(sekarang.getMonth() + 1).padStart(2, '0');
            const tanggal = String(sekarang.getDate()).padStart(2, '0');
            const formatTanggal = `${tahun}-${bulan}-${tanggal}`;

            // Format waktu (H:i)
            const jam = String(sekarang.getHours()).padStart(2, '0');
            const menit = String(sekarang.getMinutes()).padStart(2, '0');
            const formatWaktu = `${jam}:${menit}`;

            return {
                formatTanggal,
                formatWaktu
            };
        }

        // Search Nik
        $('#addPatientTriage #button-nik-pasien').click(function(e) {
            let $this = $(this);
            let $nikEl = $('#addPatientTriage #nik_pasien');
            let nikPasien = $nikEl.val();

            if (nikPasien == '' || nikPasien.length != 16 || !isNumber(nikPasien)) {
                showToast('error', 'NIK pasien harus di isi 16 angka!');

                $('#addPatientTriage #no_rm_label').text('');
                $('#addPatientTriage input, select').not('input[name="rujukan"], input[type="checkbox"]').val('');
                $('#addPatientTriage input, select').prop('readonly', false);

                let nowDate = getWaktuSekarang();
                $('#addPatientTriage #nik_pasien').val(nikPasien);
                $('#addPatientTriage #tgl_masuk').val(nowDate.formatTanggal);
                $('#addPatientTriage #jam_masuk').val(nowDate.formatWaktu);
                return false;
            }

            $.ajax({
                type: "post",
                url: "{{ route('gawat-darurat.get-patient-bynik-ajax') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'nik': nikPasien
                },
                dataType: "json",
                beforeSend: function() {
                    // Ubah teks tombol dan tambahkan spinner
                    $nikEl.prop('disabled', true);
                    $this.html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                    );
                    $this.prop('disabled', true); // Nonaktifkan tombol selama proses berlangsung
                },
                complete: function() {
                    // Ubah teks tombol jadi icon search dan disable nonaktif
                    $nikEl.prop('disabled', false);
                    $this.html('<i class="ti ti-search"></i>');
                    $this.prop('disabled', false);
                },
                success: function(res) {
                    showToast(res.status, res.message);

                    if (res.status == 'success') {
                        let data = res.data;
                        console.log(data);

                        // set value
                        $('#addPatientTriage #no_rm_label').text(data.kd_pasien);
                        $('#addPatientTriage #no_rm').val(data.kd_pasien);

                        $('#addPatientTriage #nama_pasien').val(data.nama);
                        $('#addPatientTriage #nama_pasien').prop('readonly', true);

                        $('#addPatientTriage #jenis_kelamin').val(data.jenis_kelamin);
                        $('#addPatientTriage #jenis_kelamin').prop('readonly', true);

                        let umur = hitungUmur(data.tgl_lahir);
                        $('#addPatientTriage #usia_tahun').val(umur.tahun);
                        $('#addPatientTriage #usia_bulan').val(umur.bulan);
                        $('#addPatientTriage #usia_tahun').prop('readonly', true);
                        $('#addPatientTriage #usia_bulan').prop('readonly', true);
                    }
                },
                error: function(xhr, status, error) {
                    showToast('error', 'Internal server error');
                }
            });


        });

        $('#dokterSelect').on('change', function() {
            $('#rawatDaruratTable').DataTable().ajax.reload();
        });
    </script>
@endpush
