@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .section-separator {
            border-top: 2px solid #097dd6;
            margin: 2rem 0;
            padding-top: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-check {
            margin: 0;
            padding-left: 1.5rem;
            min-height: auto;
        }

        .form-check-input {
            margin-top: 0.3rem;
        }

        .form-check label {
            margin-right: 0;
            padding-top: 0;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        /* Styling untuk kartu edukasi */
        .edukasi-cards {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .edukasi-card {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        .edukasi-card .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .edukasi-card .form-group {
            margin-bottom: 1.5rem;
        }

        .edukasi-card .form-check {
            margin-bottom: 0.5rem;
        }

        .edukasi-card .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .edukasi-card .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 5px rgba(9, 125, 214, 0.3);
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <form id="edukasiForm" method="POST"
                action="{{ route('rawat-inap.meninggalkan-perawatan.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen">Tambah Pernyataan Meninggalkan Perawatan</h4>
                            </div>

                            <div class="px-3">

                                {{-- Info Umum --}}
                                <div class="section-separator">
                                    <div class="form-group">
                                        <label for="tanggal" style="min-width: 200px;">Tanggal</label>
                                        <input type="text" name="tanggal" id="tanggal" class="form-control date"
                                            value="{{ date('Y-m-d') }}" required readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="keperluan" style="min-width: 200px;">Keperluan</label>
                                        <textarea name="keperluan" id="keperluan" class="form-control" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="tgl_awal" style="min-width: 200px;">Tanggal Awal</label>
                                        <input type="text" name="tgl_awal" id="tgl_awal" class="form-control date"
                                            required readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="jam_awal" style="min-width: 200px;">Jam Awal</label>
                                        <input type="time" name="jam_awal" id="jam_awal" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="tgl_akhir" style="min-width: 200px;">Tanggal Akhir</label>
                                        <input type="text" name="tgl_akhir" id="tgl_akhir" class="form-control date"
                                            required readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="jam_akhir" style="min-width: 200px;">Jam Akhir</label>
                                        <input type="time" name="jam_akhir" id="jam_akhir" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="kd_dokter" style="min-width: 200px;">DPJP</label>
                                        <select name="kd_dokter" id="kd_dokter" class="form-select select2" required>
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $dok)
                                                <option value="{{ $dok->kd_dokter }}">{{ $dok->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="tgl_keluar" style="min-width: 200px;">Tanggal Keluar</label>
                                        <input type="text" name="tgl_keluar" id="tgl_keluar" class="form-control date"
                                            required readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="jam_keluar" style="min-width: 200px;">Jam Keluar</label>
                                        <input type="time" name="jam_keluar" id="jam_keluar" class="form-control"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="tgl_masuk_kembali" style="min-width: 200px;">Tanggal Masuk
                                            Kembali</label>
                                        <input type="text" name="tgl_masuk_kembali" id="tgl_masuk_kembali"
                                            class="form-control date" required readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="jam_masuk_kembali" style="min-width: 200px;">Jam Masuk Kembali</label>
                                        <input type="time" name="jam_masuk_kembali" id="jam_masuk_kembali"
                                            class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
