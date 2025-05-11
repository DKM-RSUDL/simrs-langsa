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
                action="{{ route('rawat-inap.dnr.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, encrypt($dnr->id)]) }}">
                @csrf
                @method('put')

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen">Edit Penolakan Resusitasi</h4>
                            </div>

                            <div class="px-3">

                                {{-- Info Umum --}}
                                <div class="section-separator">
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal</label>
                                        <input type="text" name="tanggal" id="tanggal" class="form-control date"
                                            value="{{ date('Y-m-d', strtotime($dnr->tanggal)) }}" required readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="kd_dokter">Dokter</label>
                                        <select name="kd_dokter" id="kd_dokter" class="form-select select2" required>
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $dok)
                                                <option value="{{ $dok->kd_dokter }}" @selected($dok->kd_dokter == $dnr->kd_dokter)>
                                                    {{ $dok->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="no_hp_dokter">No HP dokter</label>
                                        <input type="text" class="form-control" id="no_hp_dokter" name="no_hp_dokter"
                                            value="{{ $dnr->no_hp_dokter }}" required>
                                    </div>
                                </div>

                                {{-- INTSTRUKSI --}}
                                <div class="section-separator">
                                    <h4>INTRUKSI</h4>

                                    <div class="form-control">
                                        <input type="radio" name="instruksi" id="instruksi" class="form-check-input me-1"
                                            value="1" @checked($dnr->instruksi == 1) required>
                                        <label for="instruksi">
                                            Usaha komprehensif untuk mencegah henti napas atau henti jantung
                                            <strong>TANPA</strong> melakukan
                                            intubasi. DNR jika henti napas atau henti jantung terjadi.
                                            <strong>TIDAK</strong> melakukan CPR.
                                        </label>
                                    </div>

                                    <div class="form-control mt-2">
                                        <input type="radio" name="instruksi" id="intruksi1" class="form-check-input me-1"
                                            value="2" @checked($dnr->instruksi == 2) required>
                                        <label for="intruksi1">
                                            Usaha suportif sebelum terjadi henti napas atau henti jantung yang meliputi
                                            pembukaan jalan napas secara non-invasif, pemberian oksigen, mengontrol
                                            perdarahan, memposisikan pasien dengan nyaman bidai, obat-obatan anti-nyeri.
                                            <strong>TIDAK</strong> melakukan CPR bila henti napas atau henti jantung
                                            terjadi.
                                        </label>
                                    </div>
                                </div>

                                {{-- INTSTRUKSI --}}
                                <div class="section-separator">
                                    <h4>ASAL INFORMED CONSENT</h4>

                                    <div class="form-control">
                                        <input type="radio" name="keputusan" id="keputusan1" class="form-check-input me-1"
                                            value="1" @checked($dnr->keputusan == 1) required>
                                        <label for="keputusan1">
                                            Pasien sendiri
                                        </label>
                                    </div>

                                    <div class="form-control mt-2">
                                        <input type="radio" name="keputusan" id="keputusan2" class="form-check-input me-1"
                                            value="2" @checked($dnr->keputusan == 2) required>
                                        <label for="keputusan2">
                                            Tenaga kesehatan yang ditunjuk pasien
                                        </label>
                                    </div>

                                    <div class="form-control mt-2">
                                        <input type="radio" name="keputusan" id="keputusan3" class="form-check-input me-1"
                                            value="3" @checked($dnr->keputusan == 3) required>
                                        <label for="keputusan3">
                                            Wali yang sah atas pasien (termasuk yang ditunjuk pengadilan)
                                        </label>
                                    </div>

                                    <div class="form-control mt-2">
                                        <input type="radio" name="keputusan" id="keputusan4" class="form-check-input me-1"
                                            value="4" @checked($dnr->keputusan == 4) required>
                                        <label for="keputusan4">
                                            Anggota keluarga pasien
                                        </label>
                                    </div>
                                </div>

                                {{-- DASAR KEPUTUSAN --}}
                                <div class="section-separator">
                                    <h4>DASAR KEPUTUSAN</h4>

                                    <div class="form-control">
                                        <input type="radio" name="dasar_perintah" id="perintah1"
                                            class="form-check-input me-1" value="1" @checked($dnr->dasar_perintah == 1)
                                            required>
                                        <label for="perintah1">
                                            Instruksi pasien sebelumnya
                                        </label>
                                    </div>

                                    <div class="form-control">
                                        <input type="radio" name="dasar_perintah" id="perintah2"
                                            class="form-check-input me-1" value="2" @checked($dnr->dasar_perintah == 2)
                                            required>
                                        <label for="perintah2">
                                            Keputusan dua orang dokter bahwa CPR akan memberikan hasil yang tidak efektif
                                        </label>
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
