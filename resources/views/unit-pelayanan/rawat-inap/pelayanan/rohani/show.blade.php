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

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100 shadow-sm">
                    <div class="card-body">
                        <div class="px-3">
                            <h4 class="header-asesmen">Permintaan Pelayanan Rohani</h4>
                        </div>

                        <div class="px-3">

                            {{-- Info Umum --}}
                            <div class="section-separator">
                                <div class="form-group">
                                    <label for="tanggal" style="min-width: 200px;">Tanggal</label>
                                    <input type="text" name="tanggal" id="tanggal" class="form-control date"
                                        value="{{ date('Y-m-d', strtotime($rohani->tanggal)) }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="kd_penyetuju" style="min-width: 200px;">PPA Yang Menyetujui</label>
                                    <select name="kd_penyetuju" id="kd_penyetuju" class="form-select select2" disabled>
                                        <option value="">--Pilih--</option>
                                        @foreach ($pegawai as $peg)
                                            <option value="{{ $peg->kd_karyawan }}" @selected($peg->kd_karyawan == $rohani->kd_penyetuju)>
                                                {{ "$peg->kd_karyawan | $peg->gelar_depan " . str()->title($peg->nama) . " $peg->gelar_belakang" }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- IDENTITAS KELUARGA --}}
                            <div class="section-separator" id="identitas-keluarga">
                                <h4 class="fw-semibold">IDENTITAS KELUARGA</h4>

                                <div class="form-group">
                                    <label for="keluarga_nama" style="min-width: 200px;">Nama</label>
                                    <input type="text" name="keluarga_nama" id="keluarga_nama" class="form-control"
                                        value="{{ $rohani->keluarga_nama }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="keluarga_tempat_lahir" style="min-width: 200px;">Tempat Lahir</label>
                                    <input type="text" name="keluarga_tempat_lahir" id="keluarga_tempat_lahir"
                                        class="form-control" value="{{ $rohani->keluarga_tempat_lahir }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="keluarga_tgl_lahir" style="min-width: 200px;">Tanggal Lahir</label>
                                    <input type="text" name="keluarga_tgl_lahir" id="keluarga_tgl_lahir"
                                        class="form-control date"
                                        value="{{ date('Y-m-d', strtotime($rohani->keluarga_tgl_lahir)) }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="keluarga_jenis_kelamin" style="min-width: 200px;">Jenis
                                        Kelamin</label>
                                    <select name="keluarga_jenis_kelamin" id="keluarga_jenis_kelamin" class="form-select"
                                        disabled>
                                        <option value="">--Pilih--</option>
                                        <option value="0" @selected($rohani->keluarga_jenis_kelamin == 0)>Perempuan</option>
                                        <option value="1" @selected($rohani->keluarga_jenis_kelamin == 1)>Laki-Laki</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="keluarga_hubungan_pasien" style="min-width: 200px;">Hubungan dengan
                                        pasien</label>
                                    <input type="text" name="keluarga_hubungan_pasien" id="keluarga_hubungan_pasien"
                                        class="form-control" value="{{ $rohani->keluarga_hubungan_pasien }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="keluarga_agama" style="min-width: 200px;">Agama</label>
                                    <select name="keluarga_agama" id="keluarga_agama" class="form-select" disabled>
                                        <option value="">--Pilih--</option>
                                        @foreach ($agama as $agm)
                                            <option value="{{ $agm->kd_agama }}" @selected($agm->kd_agama == $rohani->keluarga_agama)>
                                                {{ $agm->agama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            {{-- KONDISI PASIEN --}}
                            <div class="section-separator" id="identitas-keluarga">
                                <h4 class="fw-semibold">KONDISI PASIEN</h4>

                                <div class="form-group">
                                    <div class="d-flex">
                                        <label style="min-width: 200px;">Kondisi Pasien</label>
                                        <div class="">
                                            <div class="">
                                                <input type="checkbox" name="kondisi_pasien[]" id="pre_operasi"
                                                    class="form-check-input" value="Pre Operasi Besar"
                                                    @checked(in_array('Pre Operasi Besar', $rohani->kondisi_pasien)) disabled>
                                                <label for="pre_operasi">Pre Operasi Besar</label>
                                            </div>
                                            <div class="">
                                                <input type="checkbox" name="kondisi_pasien[]" id="kritis"
                                                    class="form-check-input" value="Kritis" @checked(in_array('Kritis', $rohani->kondisi_pasien))
                                                    disabled>
                                                <label for="kritis">Kritis</label>
                                            </div>
                                            <div class="">
                                                <input type="checkbox" name="kondisi_pasien[]" id="menjelang_ajal"
                                                    class="form-check-input" value="Menjelang Ajal"
                                                    @checked(in_array('Menjelang Ajal', $rohani->kondisi_pasien)) disabled>
                                                <label for="menjelang_ajal">Menjelang Ajal</label>
                                            </div>
                                            <div class="">
                                                <input type="checkbox" name="kondisi_pasien[]" id="penyakit_terminal"
                                                    class="form-check-input"
                                                    value="Penyakit terminal: Kanker, GGK stage V, HIV"
                                                    @checked(in_array('Penyakit terminal: Kanker, GGK stage V, HIV', $rohani->kondisi_pasien)) disabled>
                                                <label for="penyakit_terminal">Penyakit terminal: Kanker, GGK stage V,
                                                    HIV</label>
                                            </div>
                                            <div class="">
                                                <input type="checkbox" name="kondisi_pasien[]" id="pasien_cemas"
                                                    class="form-check-input" value="Pasien cemas/ gangguan emosi"
                                                    @checked(in_array('Pasien cemas/ gangguan emosi', $rohani->kondisi_pasien)) disabled>
                                                <label for="pasien_cemas">Pasien cemas/ gangguan emosi</label>
                                            </div>
                                            <div class="">
                                                <input type="checkbox" name="kondisi_pasien[]" id="perhatian_keluarga"
                                                    class="form-check-input" value="Kurang mendapat perhatian keluarga"
                                                    @checked(in_array('Kurang mendapat perhatian keluarga', $rohani->kondisi_pasien)) disabled>
                                                <label for="perhatian_keluarga">Kurang mendapat perhatian
                                                    keluarga</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
