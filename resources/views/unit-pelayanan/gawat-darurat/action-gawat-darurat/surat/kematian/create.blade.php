@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            font-size: 0.95rem;
            font-weight: 500;
            color: #333;
            margin-bottom: 0.4rem;
        }


        .form-label {
            font-size: 0.95rem;
            font-weight: 500;
            color: #333;
            margin-bottom: 0.4rem;
        }

        .required::after {
            color: #dc3545;
            margin-left: 0.3rem;
        }

        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .card-body {
            padding: 2rem;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a3c34;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 0.5rem 1.5rem;
            border-radius: 0.4rem;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-outline-secondary {
            padding: 0.4rem 1rem;
            border-radius: 0.4rem;
            font-weight: 500;
        }

        .form-control {
            border-radius: 0.4rem;
            border: 1px solid #ced4da;
            padding: 0.5rem 0.75rem;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
        }

        .invalid-feedback {
            font-size: 0.85rem;
        }

        .row.g-3 {
            margin-bottom: 0.5rem;
        }

        .section-separator {
            margin-top: 1rem;
            margin-bottom: 1.5rem;
            border-top: 1px solid #e9ecef;
            padding-top: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1a3c34;
            margin-bottom: 1rem;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        {{-- Patient Card Column --}}
        <div class="col-md-3">
            @include('components.patient-card', ['dataMedis' => $dataMedis])
        </div>

        {{-- Form Column --}}
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    {{-- Back Button --}}
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mb-4">
                        <i class="ti-arrow-left"></i> Kembali
                    </a>

                    <h5 class="card-title mb-4">Form Tambah Surat Kematian Pasien</h5>
                    <p class="text-muted mb-4">Lengkapi data berikut untuk membuat surat kematian pasien.</p>

                    {{-- The Form --}}
                    <form
                        action="{{ route('surat-kematian.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                        method="POST">
                        @csrf

                        {{-- Section 1: Data Kematian --}}
                        <div class="section-separator" id="data-kematian">
                            <div class="row g-3">
                                {{-- Tanggal Kematian --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_kematian" class="form-label required">Tanggal Kematian</label>
                                        <input type="date"
                                            class="form-control @error('tanggal_kematian') is-invalid @enderror"
                                            id="tanggal_kematian" name="tanggal_kematian"
                                            value="{{ old('tanggal_kematian', date('Y-m-d')) }}" required>
                                        @error('tanggal_kematian')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Jam Kematian --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jam_kematian" class="form-label required">Jam Kematian</label>
                                        <input type="time"
                                            class="form-control @error('jam_kematian') is-invalid @enderror"
                                            id="jam_kematian" name="jam_kematian"
                                            value="{{ old('jam_kematian', date('H:i')) }}" required>
                                        @error('jam_kematian')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                {{-- Dokter --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dokter" class="form-label required">Dokter</label>
                                        <input type="text" class="form-control @error('dokter') is-invalid @enderror"
                                            id="dokter" name="dokter" value="{{ old('dokter') }}" required>
                                        @error('dokter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Spesialis --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="spesialis" class="form-label required">Spesialis</label>
                                        <input type="text" class="form-control @error('spesialis') is-invalid @enderror"
                                            id="spesialis" name="spesialis" value="{{ old('spesialis') }}" required>
                                        @error('spesialis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                {{-- Nomor Surat --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nomor_surat" class="form-label required">Nomor Surat</label>
                                        <input type="text"
                                            class="form-control @error('nomor_surat') is-invalid @enderror" id="nomor_surat"
                                            name="nomor_surat" value="{{ old('nomor_surat') }}"
                                            placeholder="Masukkan nomor surat Jika sudah ada" required>
                                        @error('nomor_surat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                {{-- Tempat Kematian --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tempat_kematian" class="form-label required">Tempat Kematian</label>
                                        <input type="text"
                                            class="form-control @error('tempat_kematian') is-invalid @enderror"
                                            id="tempat_kematian" name="tempat_kematian"
                                            value="{{ old('tempat_kematian') }}" required>
                                        @error('tempat_kematian')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Kab/Kota --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kab_kota" class="form-label required">Kabupaten/Kota</label>
                                        <input type="text" class="form-control @error('kab_kota') is-invalid @enderror"
                                            id="kab_kota" name="kab_kota" value="{{ old('kab_kota') }}" required>
                                        @error('kab_kota')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label required">Umur</label>
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <input type="number"
                                                    class="form-control @error('umur_tahun') is-invalid @enderror"
                                                    id="umur_tahun" name="umur_tahun" value="{{ old('umur_tahun') }}"
                                                    placeholder="Tahun" min="0">
                                                @error('umur_tahun')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number"
                                                    class="form-control @error('umur_bulan') is-invalid @enderror"
                                                    id="umur_bulan" name="umur_bulan" value="{{ old('umur_bulan') }}"
                                                    placeholder="Bulan" min="0" max="11">
                                                @error('umur_bulan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number"
                                                    class="form-control @error('umur_hari') is-invalid @enderror"
                                                    id="umur_hari" name="umur_hari" value="{{ old('umur_hari') }}"
                                                    placeholder="Hari" min="0" max="30">
                                                @error('umur_hari')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number"
                                                    class="form-control @error('umur_jam') is-invalid @enderror"
                                                    id="umur_jam" name="umur_jam" value="{{ old('umur_jam') }}"
                                                    placeholder="Jam/Menit" min="0">
                                                @error('umur_jam')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="section-separator">
                            
                        </div>


                        {{-- Submit Button --}}
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
