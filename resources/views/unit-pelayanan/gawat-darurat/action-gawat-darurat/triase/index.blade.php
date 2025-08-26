@extends('layouts.administrator.master')

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

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <form action="{{ route('gawat-darurat.store-triase') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">

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
                                                        class="form-select select2 @error('dokter_triase') is-invalid @enderror"
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
                                                            class="form-control"
                                                            placeholder="NIK / No RM Pasien (Cth: 0-00-00-00)"
                                                            aria-label="Nik Pasien" aria-describedby="button-nik-pasien"
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

                                                    <div class="input-group mb-3">
                                                        <input type="text" name="nama_pasien" id="nama_pasien"
                                                            class="form-control" placeholder="Nama Pasien"
                                                            value="{{ old('nama_pasien') }}">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            id="button-nama-pasien">
                                                            <i class="ti ti-search"></i>
                                                        </button>
                                                    </div>

                                                    @error('nama_pasien')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="form-group mt-3">
                                                    <label for="#alamat_pasien">
                                                        <p class="text-primary m-0 p-0">
                                                            <strong>Alamat Pasien :</strong>
                                                        </p>
                                                    </label>

                                                    <div class="input-group mb-3">
                                                        {{-- <input type="text" name="alamat_pasien" id="alamat_pasien"
                                                            class="form-control" placeholder="Nama Pasien"
                                                            value="{{ old('alamat_pasien') }}"> --}}
                                                        <textarea name="alamat_pasien" id="alamat_pasien" class="form-control">{{ old('alamat_pasien') }}</textarea>
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            id="button-alamat-pasien">
                                                            <i class="ti ti-search"></i>
                                                        </button>
                                                    </div>

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

                            <div class="col-md-9">

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
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="sistole">TD (Sistole)</label>
                                                                    <input type="number" name="sistole" id="sistole"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="diastole">TD (Diastole)</label>
                                                                    <input type="number" name="diastole" id="diastole"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="nadi">Nadi (x/mnt)</label>
                                                                    <input type="number" name="nadi" id="nadi"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="respiration">Resp (x/mnt)</label>
                                                                    <input type="number" name="respiration"
                                                                        id="respiration" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="suhu">Suhu &deg;C</label>
                                                                    <input type="text" name="suhu" id="suhu"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="spo2_tanpa_o2">SpO2 (tanpa O2)</label>
                                                                    <input type="number" name="spo2_tanpa_o2"
                                                                        id="spo2_tanpa_o2" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="spo2_dengan_o2">SpO2 (dengan
                                                                        O2)</label>
                                                                    <input type="number" name="spo2_dengan_o2"
                                                                        id="spo2_dengan_o2" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="tinggi_badan">TB (cm)</label>
                                                                    <input type="number" name="tinggi_badan"
                                                                        id="tinggi_badan" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="berat_badan">BB (cm)</label>
                                                                    <input type="number" name="berat_badan"
                                                                        id="berat_badan" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-5">
                                            <div class="col-md-3">

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
                                                                name="airway[]" value="Tidak ada tanda-tanda kehidupan"
                                                                id="airway_mati">
                                                            <label class="form-check-label" for="airway_mati">
                                                                Tidak ada tanda-tanda kehidupan
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-3">

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
                                                            <input class="form-check-input urgent-check" type="checkbox"
                                                                name="breathing[]" value="Mengi" id="breathing_Mengi">
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
                                                                type="checkbox" name="breathing[]" value="RR > 20 X/mnt"
                                                                id="breathing_rr">
                                                            <label class="form-check-label" for="breathing_rr">
                                                                RR > 20 X/mnt
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input resusitasi-check"
                                                                type="checkbox" name="breathing[]" value="Henti Nafas"
                                                                id="breathing_henti_nafas">
                                                            <label class="form-check-label" for="breathing_henti_nafas">
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
                                            <div class="col-md-3">

                                                <div class="card mb-3">
                                                    <div class="card-header border-bottom">
                                                        <p class="m-0 p-0 fw-bold">Circulation</p>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-check mt-3">
                                                            <input class="form-check-input false-emergency-check"
                                                                type="checkbox" name="circulation[]" value="Nadi Kuat"
                                                                id="circulation_nadi_kuat">
                                                            <label class="form-check-label" for="circulation_nadi_kuat">
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
                                                            <input class="form-check-input urgent-check" type="checkbox"
                                                                name="circulation[]" value="TD sistole >= 160 atau <= 90"
                                                                id="circulation_sistole_160_90">
                                                            <label class="form-check-label"
                                                                for="circulation_sistole_160_90">
                                                                TD sistole >= 160 atau <= 90 </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input emergency-check"
                                                                type="checkbox" name="circulation[]" value="Nadi Lemah"
                                                                id="circulation_nadi_lemah">
                                                            <label class="form-check-label" for="circulation_nadi_lemah">
                                                                Nadi Lemah
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input emergency-check"
                                                                type="checkbox" name="circulation[]" value="Bradikardia"
                                                                id="circulation_bradikardia">
                                                            <label class="form-check-label" for="circulation_bradikardia">
                                                                Bradikardia
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input emergency-check"
                                                                type="checkbox" name="circulation[]" value="Takikardi"
                                                                id="circulation_takikardi">
                                                            <label class="form-check-label" for="circulation_takikardi">
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
                                                            <label class="form-check-label" for="circulation_dehidrasi">
                                                                Tanda-tanda dehidrasi sedang-berat
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input emergency-check"
                                                                type="checkbox" name="circulation[]" value="Suhu > 40 C"
                                                                id="circulation_suhu">
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
                                                                value="Nadi tak teraba" id="circulation_nadi_tak_teraba">
                                                            <label class="form-check-label"
                                                                for="circulation_nadi_tak_teraba">
                                                                Nadi tak teraba
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input resusitasi-check"
                                                                type="checkbox" name="circulation[]" value="Sianosis"
                                                                id="circulation_cianosis">
                                                            <label class="form-check-label" for="circulation_cianosis">
                                                                Sianosis
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-3">

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
                                                            <input class="form-check-input urgent-check" type="checkbox"
                                                                name="disability[]" value="GCS >= 12"
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
                                                                type="checkbox" name="disability[]" value="Nyeri Dada"
                                                                id="disability_nyeri_dada">
                                                            <label class="form-check-label" for="disability_nyeri_dada">
                                                                Nyeri Dada
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input emergency-check"
                                                                type="checkbox" name="disability[]"
                                                                value="Hemiparese Akut" id="disability_hemiparese_akut">
                                                            <label class="form-check-label"
                                                                for="disability_hemiparese_akut">
                                                                Hemiparese Akut
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input resusitasi-check"
                                                                type="checkbox" name="disability[]" value="GCS < 9"
                                                                id="disability_gcs_under_9">
                                                            <label class="form-check-label" for="disability_gcs_under_9">
                                                                GCS < 9 </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input resusitasi-check"
                                                                type="checkbox" name="disability[]"
                                                                value="Tidak ada respon" id="disability_no_respon">
                                                            <label class="form-check-label" for="disability_no_respon">
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
                                                        class="btn btn-block ms-3 w-100" data-bs-toggle="modal"
                                                        data-bs-target="#kodeTriaseModal"></button>
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
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="daftarPasienTriaseModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="daftarPasienTriaseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="daftarPasienTriaseModalLabel">Daftar Pasien</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped" id="list-pasien-triase">
                                    <thead>
                                        <tr align="middle">
                                            <th>NO</th>
                                            <th>NO RM</th>
                                            <th>NAMA</th>
                                            <th>NIK</th>
                                            <th>USIA</th>
                                            <th>ALAMAT</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Kode Triase -->
    <div class="modal fade" id="kodeTriaseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="kodeTriaseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="kodeTriaseModalLabel">Kode Triase</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-success d-block w-100 mb-3 btn-triase-label"
                                data-triase="FALSE EMERGENCY (60 menit)" data-kode="1">
                                FALSE EMERGENCY (60 menit)
                            </button>
                            <button class="btn btn-warning d-block w-100 mb-3 btn-triase-label"
                                data-triase="URGENT (30 menit)" data-kode="2">
                                URGENT (30 menit)
                            </button>
                            <button class="btn btn-danger d-block w-100 mb-3 btn-triase-label"
                                data-triase="EMERGENCY (10 menit)" data-kode="3">
                                EMERGENCY (10 menit)
                            </button>
                            <button class="btn btn-danger d-block w-100 mb-3 btn-triase-label"
                                data-triase="RESUSITASI (segera)" data-kode="4">
                                RESUSITASI (segera)
                            </button>
                            <button class="btn btn-dark d-block w-100 mb-3 btn-triase-label" data-triase="DOA"
                                data-kode="5">
                                DOA
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
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
        $('.doa-check').change(function(e) {
            // kalau ada checkbox doa yang di check disable semua checkbox non DOA
            let doaChecked = $('.doa-check:checked').length > 0;
            $('input[type="checkbox"]').not('.doa-check').prop('disabled', doaChecked);

            updateTriaseStatus();
        });

        // perubahan pada checkbox non DOA
        $('input[type="checkbox"]').not('.doa-check').change(function(e) {
            // kalau ada checkbox non doa di check maka disable semua checkbox doa
            let nonDoaChecked = $('input[type="checkbox"]:checked').not('.doa-check').length > 0;
            $('input[type="checkbox"].doa-check').prop('disabled', nonDoaChecked);

            updateTriaseStatus();
        });

        function updateTriaseStatus() {
            var status = '';
            var kode_triase = '';

            // Menetapkan prioritas dari tinggi ke rendah
            if ($('.doa-check:checked').length > 0) {
                status = 'DOA';
                kode_triase = 5;
            } else if ($('.resusitasi-check:checked').length > 0) {
                status = 'RESUSITASI (segera)';
                kode_triase = 4;
            } else if ($('.emergency-check:checked').length > 0) {
                status = 'EMERGENCY (10 menit)';
                kode_triase = 3;
            } else if ($('.urgent-check:checked').length > 0) {
                status = 'URGENT (30 menit)';
                kode_triase = 2;
            } else if ($('.false-emergency-check:checked').length > 0) {
                status = 'FALSE EMERGENCY (60 menit)';
                kode_triase = 1;
            }

            $('#triaseStatusLabel').text(status).attr('class', determineClass(status));
            $('#kd_triase').val(kode_triase);
            $('#ket_triase').val(status);
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

        $('#kodeTriaseModal .btn-triase-label').click(function() {
            let $this = $(this);
            let triaseLabel = $this.attr('data-triase');
            let kdTriase = $this.attr('data-kode');

            $('#triaseStatusLabel').text(triaseLabel).attr('class', determineClass(triaseLabel));
            $('#kd_triase').val(kdTriase);
            $('#ket_triase').val(triaseLabel);

            $('#kodeTriaseModal').modal('hide');
        });

        // Input Rujukan Change
        $('input[name="rujukan"]').change(function(e) {
            let $this = $(this);
            let rujukanValue = $this.val();


            // kalau value y input rujukan ket required, kalau n input rujukan ket disabled
            if (rujukanValue == '1') {
                $('#rujukan_ket').prop('required', true);
                $('#rujukan_ket').prop('readonly', false);
            } else {
                $('#rujukan_ket').val('');
                $('#rujukan_ket').prop('required', false);
                $('#rujukan_ket').prop('readonly', true);
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
        $('#button-nik-pasien').click(function(e) {

            let $this = $(this);
            let $nikEl = $('#nik_pasien');
            let nikPasien = $nikEl.val();


            if (nikPasien.length == 16 || nikPasien.length == 10) {
                let nowDate = getWaktuSekarang();
                $('#nik_pasien').val(nikPasien);
                $('#tgl_masuk').val(nowDate.formatTanggal);
                $('#jam_masuk').val(nowDate.formatWaktu);

            } else {
                showToast('error', 'NIK pasien harus di isi 16 angka atau No RM dengan format 0-00-00-00!');

                $('#no_rm_label').text('');
                $('input, select').not('input[name="rujukan"], input[type="checkbox"]').val('');
                $('input, select').prop('readonly', false);

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

                        // set value
                        $('#no_rm_label').text(data.kd_pasien);
                        $('#no_rm').val(data.kd_pasien);

                        $('#nama_pasien').val(data.nama);
                        $('#nama_pasien').prop('readonly', true);

                        $('#alamat_pasien').val(data.alamat);
                        $('#alamat_pasien').prop('readonly', true);

                        $('#jenis_kelamin').val(data.jenis_kelamin);
                        $('#jenis_kelamin').prop('readonly', true);

                        let umur = hitungUmur(data.tgl_lahir);
                        $('#usia_tahun').val(umur.tahun);
                        $('#usia_bulan').val(umur.bulan);
                        $('#usia_tahun').prop('readonly', true);
                        $('#usia_bulan').prop('readonly', true);
                    }
                },
                error: function(xhr, status, error) {
                    showToast('error', 'Internal server error');
                }
            });


        });

        // Search name
        $('#button-nama-pasien').click(function(e) {

            let $this = $(this);
            let $namaEl = $('#nama_pasien');
            let namaPasien = $namaEl.val();

            if (namaPasien.length > 0) {
                let nowDate = getWaktuSekarang();
                $('#tgl_masuk').val(nowDate.formatTanggal);
                $('#jam_masuk').val(nowDate.formatWaktu);

            } else {
                showToast('error', 'Nama Pasien tidak boleh kosong!');

                $('#no_rm_label').text('');
                $('input, select').not('input[name="rujukan"], input[type="checkbox"]').val('');
                $('input, select').prop('readonly', false);

                return false;
            }


            $.ajax({
                type: "post",
                url: "{{ route('gawat-darurat.get-patient-bynama-ajax') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'nama': namaPasien
                },
                dataType: "json",
                beforeSend: function() {
                    // Ubah teks tombol dan tambahkan spinner
                    $namaEl.prop('disabled', true);
                    $this.html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                    );
                    $this.prop('disabled', true); // Nonaktifkan tombol selama proses berlangsung
                },
                complete: function() {
                    // Ubah teks tombol jadi icon search dan disable nonaktif
                    $namaEl.prop('disabled', false);
                    $this.html('<i class="ti ti-search"></i>');
                    $this.prop('disabled', false);
                },
                success: function(res) {
                    showToast(res.status, res.message);


                    if (res.status == 'success') {
                        let data = res.data;

                        let html = '';
                        $.each(data, function(i, e) {
                            html += `<tr>
                                        <td align="middle">${i+1}</td>
                                        <td align="middle">${e.kd_pasien}</td>
                                        <td>${e.nama}</td>
                                        <td align="middle">${e.no_pengenal != null ? e.no_pengenal : '-'}</td>
                                        <td align="middle">${hitungUmur(e.tgl_lahir).tahun}</td>
                                        <td>${e.alamat}</td>
                                        <td align="middle">
                                            <button class="btn btn-sm btn-success btn-select-pasien" data-rm="${e.kd_pasien}" data-nama="${e.nama}" data-lahir="${e.tgl_lahir}" data-alamat="${e.alamat}" data-nik="${e.no_pengenal == null ? '' : e.no_pengenal}" data-gender="${e.jenis_kelamin}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>
                                    </tr>`;

                        });

                        $('#daftarPasienTriaseModal table tbody').html(html);
                        $('#list-pasien-triase').dataTable();
                        $('#daftarPasienTriaseModal').modal('show');

                        // let umur = hitungUmur(data.tgl_lahir);
                        // $('#usia_tahun').val(umur.tahun);
                        // $('#usia_bulan').val(umur.bulan);
                        // $('#usia_tahun').prop('readonly', true);
                        // $('#usia_bulan').prop('readonly', true);
                    }
                },
                error: function(xhr, status, error) {
                    showToast('error', 'Internal server error');
                }
            });
        });

        // Search name
        $('#button-alamat-pasien').click(function(e) {

            let $this = $(this);
            let $alamatEl = $('#alamat_pasien');
            let alamatPasien = $alamatEl.val();

            if (alamatPasien.length > 0) {
                let nowDate = getWaktuSekarang();
                $('#tgl_masuk').val(nowDate.formatTanggal);
                $('#jam_masuk').val(nowDate.formatWaktu);

            } else {
                showToast('error', 'Alamat Pasien tidak boleh kosong!');

                $('#no_rm_label').text('');
                $('input, select').not('input[name="rujukan"], input[type="checkbox"]').val('');
                $('input, select').prop('readonly', false);

                return false;
            }


            $.ajax({
                type: "post",
                url: "{{ route('gawat-darurat.get-patient-byalamat-ajax') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'alamat': alamatPasien
                },
                dataType: "json",
                beforeSend: function() {
                    // Ubah teks tombol dan tambahkan spinner
                    $alamatEl.prop('disabled', true);
                    $this.html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                    );
                    $this.prop('disabled', true); // Nonaktifkan tombol selama proses berlangsung
                },
                complete: function() {
                    // Ubah teks tombol jadi icon search dan disable nonaktif
                    $alamatEl.prop('disabled', false);
                    $this.html('<i class="ti ti-search"></i>');
                    $this.prop('disabled', false);
                },
                success: function(res) {
                    showToast(res.status, res.message);


                    if (res.status == 'success') {
                        let data = res.data;

                        let html = '';
                        $.each(data, function(i, e) {
                            html += `<tr>
                                        <td align="middle">${i+1}</td>
                                        <td align="middle">${e.kd_pasien}</td>
                                        <td>${e.nama}</td>
                                        <td align="middle">${e.no_pengenal != null ? e.no_pengenal : '-'}</td>
                                        <td align="middle">${hitungUmur(e.tgl_lahir).tahun}</td>
                                        <td>${e.alamat}</td>
                                        <td align="middle">
                                            <button class="btn btn-sm btn-success btn-select-pasien" data-rm="${e.kd_pasien}" data-nama="${e.nama}" data-lahir="${e.tgl_lahir}" data-alamat="${e.alamat}" data-nik="${e.no_pengenal == null ? '' : e.no_pengenal}" data-gender="${e.jenis_kelamin}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>
                                    </tr>`;

                        });

                        $('#daftarPasienTriaseModal table tbody').html(html);
                        $('#list-pasien-triase').dataTable();
                        $('#daftarPasienTriaseModal').modal('show');

                        // let umur = hitungUmur(data.tgl_lahir);
                        // $('#usia_tahun').val(umur.tahun);
                        // $('#usia_bulan').val(umur.bulan);
                        // $('#usia_tahun').prop('readonly', true);
                        // $('#usia_bulan').prop('readonly', true);
                    }
                },
                error: function(xhr, status, error) {
                    showToast('error', 'Internal server error');
                }
            });
        });

        $('#daftarPasienTriaseModal').on('click', '.btn-select-pasien', function() {
            let $this = $(this);
            let rm = $this.attr('data-rm');
            let nama = $this.attr('data-nama');
            let lahir = $this.attr('data-lahir');
            let alamat = $this.attr('data-alamat');
            let nik = $this.attr('data-nik');
            let gender = $this.attr('data-gender');

            // set value
            $('#no_rm_label').text(rm);
            $('#no_rm').val(rm);

            $('#nama_pasien').val(nama);
            $('#nama_pasien').prop('readonly', true);

            $('#alamat_pasien').val(alamat);
            $('#alamat_pasien').prop('readonly', true);

            $('#jenis_kelamin').val(gender);
            $('#jenis_kelamin').prop('readonly', true);

            let umur = hitungUmur(lahir);
            $('#usia_tahun').val(umur.tahun);
            $('#usia_bulan').val(umur.bulan);
            $('#usia_tahun').prop('readonly', true);
            $('#usia_bulan').prop('readonly', true);

            $('#daftarPasienTriaseModal').modal('hide');
        });
    </script>
@endpush
