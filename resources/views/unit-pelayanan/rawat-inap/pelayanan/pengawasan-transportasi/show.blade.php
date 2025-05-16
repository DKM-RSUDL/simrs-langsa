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
                            <h4 class="header-asesmen">Pengawasan Transportasi</h4>
                        </div>

                        <div class="px-3">
                            {{-- INFO UMUM --}}
                            <div class="section-separator">
                                <h4 class="fw-semibold">INFORMASI UMUM</h4>

                                <div class="form-group">
                                    <label for="asal_keberangkatan">Asal Keberangkatan</label>
                                    <input type="text" class="form-control" id="asal_keberangkatan"
                                        name="asal_keberangkatan" value="{{ $pengawasan->asal_keberangkatan }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="keperluan">Keperluan</label>
                                    <select name="keperluan" id="keperluan" class="form-select" required>
                                        <option value="">--Pilih--</option>
                                        <option value="1" @selected($pengawasan->keperluan == 1)>Rujuk ke RS</option>
                                        <option value="2" @selected($pengawasan->keperluan == 2)>Masuk/alih rawat inap
                                        </option>
                                        <option value="3" @selected($pengawasan->keperluan == 3)>Pindah RS</option>
                                        <option value="4" @selected($pengawasan->keperluan == 4)>Pra/pasca tindakan</option>
                                        <option value="5" @selected($pengawasan->keperluan == 5)>Penjemputan</option>
                                        <option value="6" @selected($pengawasan->keperluan == 6)>Evakuasi</option>
                                    </select>
                                </div>

                                <div class="form-group" id="rs-tujuan-wrap">
                                    <label for="rs_rujuk">RS Tujuan Rujuk</label>
                                    <input type="text" name="rs_rujuk" id="rs_rujuk" class="form-control"
                                        value="{{ $pengawasan->rs_rujuk }}" required>
                                </div>
                            </div>

                            {{-- KEBERANGKATAN --}}
                            <div class="section-separator">
                                <h4 class="fw-semibold">DATA KEBERANGKATAN</h4>

                                <div class="form-group">
                                    <label for="tanggal_berangkat">Tanggal Berangkat</label>
                                    <input type="text" name="tanggal_berangkat" id="tanggal_berangkat"
                                        class="form-control date"
                                        value="{{ date('Y-m-d', strtotime($pengawasan->tanggal_berangkat)) }}" required
                                        readonly>
                                </div>

                                <div class="form-group">
                                    <label for="jam_berangkat">Jam Berangkat</label>
                                    <input type="time" name="jam_berangkat" id="jam_berangkat" class="form-control"
                                        value="{{ date('H:i', strtotime($pengawasan->jam_berangkat)) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="catatan_khusus_berangkat">Catatan Khusus</label>
                                    <textarea name="catatan_khusus_berangkat" id="catatan_khusus_berangkat" class="form-control">{{ $pengawasan->catatan_khusus_berangkat }}</textarea>
                                </div>

                                <div class="">
                                    <label>Tek. Darah</label>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sistole_berangkat">Sistole</label>
                                                <input type="number" name="sistole_berangkat"
                                                    value="{{ $pengawasan->sistole_berangkat }}" id="sistole_berangkat"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="diastole_berangkat">Diastole</label>
                                                <input type="number" name="diastole_berangkat"
                                                    value="{{ $pengawasan->diastole_berangkat }}" id="diastole_berangkat"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nadi_berangkat">Nadi</label>
                                    <input type="number" name="nadi_berangkat" value="{{ $pengawasan->nadi_berangkat }}"
                                        id="nadi_berangkat" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="nafas_berangkat">Nafas</label>
                                    <input type="number" name="nafas_berangkat" value="{{ $pengawasan->nafas_berangkat }}"
                                        id="nafas_berangkat" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="suhu_berangkat">Suhu</label>
                                    <input type="number" name="suhu_berangkat" value="{{ $pengawasan->suhu_berangkat }}"
                                        id="suhu_berangkat" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="skala_nyeri_berangkat">Skala nyeri (VAS)</label>
                                    <input type="number" name="skala_nyeri_berangkat"
                                        value="{{ $pengawasan->skala_nyeri_berangkat }}" id="skala_nyeri_berangkat"
                                        class="form-control">
                                </div>

                                <div class="">
                                    <p>Glasgow Coma Scale (GCS)</p>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gcs_e_berangkat">Respon Mata (E)</label>
                                                <select name="gcs_e_berangkat" id="gcs_e_berangkat" class="form-select">
                                                    <option value="">--Pilih--</option>
                                                    <option value="4" @selected($pengawasan->gcs_e_berangkat == 4)>4 - Spontan
                                                    </option>
                                                    <option value="3" @selected($pengawasan->gcs_e_berangkat == 3)>3 - Terhadap
                                                        Suara</option>
                                                    <option value="2" @selected($pengawasan->gcs_e_berangkat == 2)>2 - Terhadap
                                                        Nyeri</option>
                                                    <option value="1" @selected($pengawasan->gcs_e_berangkat == 1)>1 - Tidak Ada
                                                        Respon</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gcs_m_berangkat">Respon Motorik (M)</label>
                                                <select name="gcs_m_berangkat" id="gcs_m_berangkat" class="form-select">
                                                    <option value="">--Pilih--</option>
                                                    <option value="6" @selected($pengawasan->gcs_m_berangkat == 6)>6 - Mengikuti
                                                        Perintah</option>
                                                    <option value="5" @selected($pengawasan->gcs_m_berangkat == 5)>5 -
                                                        Melokalisasi Nyeri</option>
                                                    <option value="4" @selected($pengawasan->gcs_m_berangkat == 4)>4 -
                                                        Widthdrawal</option>
                                                    <option value="3" @selected($pengawasan->gcs_m_berangkat == 3)>3 - Fleksi
                                                        Abnormal</option>
                                                    <option value="2" @selected($pengawasan->gcs_m_berangkat == 2)>2 - Ekstensi
                                                        Abnormal</option>
                                                    <option value="1" @selected($pengawasan->gcs_m_berangkat == 1)>1 - Tidak Ada
                                                        Respon</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gcs_v_berangkat">Respon Verbal (V)</label>
                                                <select name="gcs_v_berangkat" id="gcs_v_berangkat" class="form-select">
                                                    <option value="">--Pilih--</option>
                                                    <option value="5" @selected($pengawasan->gcs_v_berangkat == 5)>5 - Orientasi
                                                        Baik</option>
                                                    <option value="4" @selected($pengawasan->gcs_v_berangkat == 4)>4 - Bingung
                                                    </option>
                                                    <option value="3" @selected($pengawasan->gcs_v_berangkat == 3)>3 - Kata-Kata
                                                        tidak jelas</option>
                                                    <option value="2" @selected($pengawasan->gcs_v_berangkat == 2)>2 - Suara
                                                        tidak jelas</option>
                                                    <option value="1" @selected($pengawasan->gcs_v_berangkat == 1)>1 - tidak ada
                                                        respon</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="resiko_nafas_berangkat">Skor resiko nafas</label>
                                    <select name="resiko_nafas_berangkat" id="resiko_nafas_berangkat"
                                        class="form-select">
                                        <option value="">--Pilih--</option>
                                        <option value="1" @selected($pengawasan->resiko_nafas_berangkat == 1)>Tidak beresiko</option>
                                        <option value="2" @selected($pengawasan->resiko_nafas_berangkat == 2)>Resiko rendah</option>
                                        <option value="3" @selected($pengawasan->resiko_nafas_berangkat == 3)>Resiko tinggi</option>
                                    </select>
                                </div>
                            </div>

                            {{-- DATA TRANSPORTASI --}}
                            <div class="section-separator">
                                <h4 class="fw-semibold">TRANSPORTASI</h4>

                                <div class="form-group">
                                    <label for="kriteria">Kriteria transportasi</label>
                                    <select name="kriteria" id="kriteria" class="form-select" required>
                                        <option value="">--Pilih--</option>
                                        <option value="1" @selected($pengawasan->kriteria == 1)>Emergensi</option>
                                        <option value="2" @selected($pengawasan->kriteria == 2)>Urgensi</option>
                                        <option value="3" @selected($pengawasan->kriteria == 3)>Non-urgensi</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="kd_dokter">Dokter</label>
                                    <select name="kd_dokter" id="kd_dokter" class="form-select select2">
                                        <option value="">--Pilih--</option>
                                        @foreach ($dokter as $dok)
                                            <option value="{{ $dok->kd_dokter }}" @selected($pengawasan->kd_dokter == $dok->kd_dokter)>
                                                {{ $dok->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="kd_perawat">Perawat</label>
                                    <select name="kd_perawat" id="kd_perawat" class="form-select select2">
                                        <option value="">--Pilih--</option>
                                        @foreach ($perawat as $prw)
                                            <option value="{{ $prw->kd_karyawan }}" @selected($pengawasan->kd_perawat == $prw->kd_karyawan)>
                                                {{ "$prw->kd_karyawan | $prw->gelar_depan " . str()->title($prw->nama) . " $prw->gelar_belakang" }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="kd_pramuhusada">Pramu husada</label>
                                    <select name="kd_pramuhusada" id="kd_pramuhusada" class="form-select select2">
                                        <option value="">--Pilih--</option>
                                        @foreach ($petugas as $ptg)
                                            <option value="{{ $ptg->kd_karyawan }}" @selected($pengawasan->kd_pramuhusada == $ptg->kd_karyawan)>
                                                {{ "$ptg->kd_karyawan | $ptg->gelar_depan " . str()->title($ptg->nama) . " $ptg->gelar_belakang" }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="kd_pengemudi">Pengemudi</label>
                                    <select name="kd_pengemudi" id="kd_pengemudi" class="form-select select2">
                                        <option value="">--Pilih--</option>
                                        @foreach ($petugas as $ptg)
                                            <option value="{{ $ptg->kd_karyawan }}" @selected($pengawasan->kd_pengemudi == $ptg->kd_karyawan)>
                                                {{ "$ptg->kd_karyawan | $ptg->gelar_depan " . str()->title($ptg->nama) . " $ptg->gelar_belakang" }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="cara_transportasi">Cara Transportasi</label>
                                    <select name="cara_transportasi" id="cara_transportasi" class="form-select">
                                        <option value="">--Pilih--</option>
                                        <option value="1" @selected($pengawasan->cara_transportasi == 1)>Kursi Roda</option>
                                        <option value="2" @selected($pengawasan->cara_transportasi == 2)>Brankar RJP</option>
                                        <option value="3" @selected($pengawasan->cara_transportasi == 3)>Brankar non RJP</option>
                                        <option value="4" @selected($pengawasan->cara_transportasi == 4)>Ambulans</option>
                                        <option value="5" @selected($pengawasan->cara_transportasi == 5)>Gawat darurat</option>
                                        <option value="6" @selected($pengawasan->cara_transportasi == 6)>Non gawat darurat</option>
                                    </select>
                                </div>

                                <div class="form-group" id="plat-ambulans-wrap">
                                    <label for="plat_ambulans">No Plat Ambulans</label>
                                    <input type="text" class="form-control" name="plat_ambulans"
                                        value="{{ $pengawasan->plat_ambulans }}" id="plat_ambulans" required>
                                </div>
                            </div>

                            {{-- PENGAWASAN --}}
                            <div class="section-separator">
                                <h4 class="fw-semibold">PENGAWASAN SELAMA TRANSPORTASI</h4>

                                <div class="form-group">
                                    <label for="masalah">Masalah</label>
                                    <textarea name="masalah" id="masalah" class="form-control">{{ $pengawasan->masalah }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="tindakan">Tindakan</label>
                                    <textarea name="tindakan" id="tindakan" class="form-control">{{ $pengawasan->tindakan }}</textarea>
                                </div>

                                @foreach ($pengawasan->detail as $detail)
                                    <div id="vitalsign-wrap">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="jam_pengawasan">Jam</label>
                                                    <input type="time" class="form-control" name="jam_pengawasan[]"
                                                        id="jam_pengawasan"
                                                        value="{{ date('H:i', strtotime($detail->jam_pengawasan)) }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="">Tek. Darah</label>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="sistole_pengawasan">Sistole</label>
                                                                <input type="number" name="sistole_pengawasan[]"
                                                                    value="{{ $detail->sistole_pengawasan }}"
                                                                    id="sistole_pengawasan" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="diastole_pengawasan">Diastole</label>
                                                                <input type="number" name="diastole_pengawasan[]"
                                                                    value="{{ $detail->diastole_pengawasan }}"
                                                                    id="diastole_pengawasan" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="nadi_pengawasan">Frek. Nadi</label>
                                                    <input type="number" name="nadi_pengawasan[]"
                                                        value="{{ $detail->nadi_pengawasan }}" id="nadi_pengawasan"
                                                        class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="nafas_pengawasan">Frek. Nafas</label>
                                                    <input type="number" name="nafas_pengawasan[]"
                                                        value="{{ $detail->nafas_pengawasan }}" id="nafas_pengawasan"
                                                        class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="suhu_pengawasan">Frek. Suhu</label>
                                                    <input type="number" name="suhu_pengawasan[]"
                                                        value="{{ $detail->suhu_pengawasan }}" id="suhu_pengawasan"
                                                        class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="skala_nyeri_pengawasan">Skor Nyeri (1-10)</label>
                                                    <input type="number" name="skala_nyeri_pengawasan[]"
                                                        value="{{ $detail->skala_nyeri_pengawasan }}"
                                                        id="skala_nyeri_pengawasan" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label>Glasgow Coma Scale (GCS)</label>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="gcs_e_pengawasan">Respon Mata (E)</label>
                                                                <select name="gcs_e_pengawasan[]" id="gcs_e_pengawasan"
                                                                    class="form-select">
                                                                    <option value="">--Pilih--</option>
                                                                    <option value="4" @selected($detail->gcs_e_pengawasan == 4)>4
                                                                        - Spontan
                                                                    </option>
                                                                    <option value="3" @selected($detail->gcs_e_pengawasan == 3)>3
                                                                        - Terhadap Suara
                                                                    </option>
                                                                    <option value="2" @selected($detail->gcs_e_pengawasan == 2)>2
                                                                        - Terhadap Nyeri
                                                                    </option>
                                                                    <option value="1" @selected($detail->gcs_e_pengawasan == 1)>1
                                                                        - Tidak Ada
                                                                        Respon
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="gcs_m_pengawasan">Respon Motorik
                                                                    (M)
                                                                </label>
                                                                <select name="gcs_m_pengawasan[]" id="gcs_m_pengawasan"
                                                                    class="form-select">
                                                                    <option value="">--Pilih--</option>
                                                                    <option value="6" @selected($detail->gcs_m_pengawasan == 6)>6
                                                                        - Mengikuti
                                                                        Perintah
                                                                    </option>
                                                                    <option value="5" @selected($detail->gcs_m_pengawasan == 5)>5
                                                                        - Melokalisasi
                                                                        Nyeri
                                                                    </option>
                                                                    <option value="4" @selected($detail->gcs_m_pengawasan == 4)>4
                                                                        - Widthdrawal
                                                                    </option>
                                                                    <option value="3" @selected($detail->gcs_m_pengawasan == 3)>3
                                                                        - Fleksi
                                                                        Abnormal</option>
                                                                    <option value="2" @selected($detail->gcs_m_pengawasan == 2)>2
                                                                        - Ekstensi
                                                                        Abnormal
                                                                    </option>
                                                                    <option value="1" @selected($detail->gcs_m_pengawasan == 1)>1
                                                                        - Tidak Ada
                                                                        Respon
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="gcs_v_pengawasan">Respon Verbal (V)</label>
                                                                <select name="gcs_v_pengawasan[]" id="gcs_v_pengawasan"
                                                                    class="form-select">
                                                                    <option value="">--Pilih--</option>
                                                                    <option value="5" @selected($detail->gcs_v_pengawasan == 5)>5
                                                                        - Orientasi Baik
                                                                    </option>
                                                                    <option value="4" @selected($detail->gcs_v_pengawasan == 4)>4
                                                                        - Bingung
                                                                    </option>
                                                                    <option value="3" @selected($detail->gcs_v_pengawasan == 3)>3
                                                                        - Kata-Kata
                                                                        tidak jelas
                                                                    </option>
                                                                    <option value="2" @selected($detail->gcs_v_pengawasan == 2)>2
                                                                        - Suara tidak
                                                                        jelas
                                                                    </option>
                                                                    <option value="1" @selected($detail->gcs_v_pengawasan == 1)>1
                                                                        - tidak ada
                                                                        respon
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-end">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- SAMPAI --}}
                            <div class="section-separator">
                                <h4 class="fw-semibold">DATA SAMPAI TUJUAN</h4>

                                <div class="form-group">
                                    <label for="tanggal_sampai">Tanggal Sampai</label>
                                    <input type="text" name="tanggal_sampai" id="tanggal_sampai"
                                        class="form-control date"
                                        value="{{ date('Y-m-d', strtotime($pengawasan->tanggal_sampai)) }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="jam_sampai">Jam Sampai</label>
                                    <input type="time" name="jam_sampai" id="jam_sampai" class="form-control"
                                        value="{{ date('H:i', strtotime($pengawasan->jam_sampai)) }}">
                                </div>

                                <div class="form-group">
                                    <label for="petugas_penerima">Petugas Penerima</label>
                                    <input type="text" name="petugas_penerima" id="petugas_penerima"
                                        class="form-control" value="{{ $pengawasan->petugas_penerima }}">
                                </div>

                                <div class="form-group">
                                    <label for="catatan_khusus_sampai">Catatan Khusus</label>
                                    <textarea name="catatan_khusus_sampai" id="catatan_khusus_sampai" class="form-control">{{ $pengawasan->catatan_khusus_sampai }}</textarea>
                                </div>

                                <div class="">
                                    <label>Tek. Darah</label>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sistole_sampai">Sistole</label>
                                                <input type="number" name="sistole_sampai"
                                                    value="{{ $pengawasan->sistole_sampai }}" id="sistole_sampai"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="diastole_sampai">Diastole</label>
                                                <input type="number" name="diastole_sampai"
                                                    value="{{ $pengawasan->diastole_sampai }}" id="diastole_sampai"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nadi_sampai">Nadi</label>
                                    <input type="number" name="nadi_sampai" value="{{ $pengawasan->nadi_sampai }}"
                                        id="nadi_sampai" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="nafas_sampai">Nafas</label>
                                    <input type="number" name="nafas_sampai" value="{{ $pengawasan->nafas_sampai }}"
                                        id="nafas_sampai" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="suhu_sampai">Suhu</label>
                                    <input type="number" name="suhu_sampai" value="{{ $pengawasan->suhu_sampai }}"
                                        id="suhu_sampai" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="skala_nyeri_sampai">Skala nyeri (VAS)</label>
                                    <input type="number" name="skala_nyeri_sampai"
                                        value="{{ $pengawasan->skala_nyeri_sampai }}" id="skala_nyeri_sampai"
                                        class="form-control">
                                </div>

                                <div class="">
                                    <p>Glasgow Coma Scale (GCS)</p>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gcs_e_sampai">Respon Mata (E)</label>
                                                <select name="gcs_e_sampai" id="gcs_e_sampai" class="form-select">
                                                    <option value="">--Pilih--</option>
                                                    <option value="4" @selected($pengawasan->gcs_e_sampai == 4)>4 - Spontan
                                                    </option>
                                                    <option value="3" @selected($pengawasan->gcs_e_sampai == 3)>3 - Terhadap
                                                        Suara</option>
                                                    <option value="2" @selected($pengawasan->gcs_e_sampai == 2)>2 - Terhadap
                                                        Nyeri</option>
                                                    <option value="1" @selected($pengawasan->gcs_e_sampai == 1)>1 - Tidak Ada
                                                        Respon</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gcs_m_sampai">Respon Motorik (M)</label>
                                                <select name="gcs_m_sampai" id="gcs_m_sampai" class="form-select">
                                                    <option value="">--Pilih--</option>
                                                    <option value="6" @selected($pengawasan->gcs_m_sampai == 6)>6 - Mengikuti
                                                        Perintah</option>
                                                    <option value="5" @selected($pengawasan->gcs_m_sampai == 5)>5 -
                                                        Melokalisasi Nyeri</option>
                                                    <option value="4" @selected($pengawasan->gcs_m_sampai == 4)>4 -
                                                        Widthdrawal</option>
                                                    <option value="3" @selected($pengawasan->gcs_m_sampai == 3)>3 - Fleksi
                                                        Abnormal</option>
                                                    <option value="2" @selected($pengawasan->gcs_m_sampai == 2)>2 - Ekstensi
                                                        Abnormal</option>
                                                    <option value="1" @selected($pengawasan->gcs_m_sampai == 1)>1 - Tidak Ada
                                                        Respon</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gcs_v_sampai">Respon Verbal (V)</label>
                                                <select name="gcs_v_sampai" id="gcs_v_sampai" class="form-select">
                                                    <option value="">--Pilih--</option>
                                                    <option value="5" @selected($pengawasan->gcs_v_sampai == 5)>5 - Orientasi
                                                        Baik</option>
                                                    <option value="4" @selected($pengawasan->gcs_v_sampai == 4)>4 - Bingung
                                                    </option>
                                                    <option value="3" @selected($pengawasan->gcs_v_sampai == 3)>3 - Kata-Kata
                                                        tidak jelas</option>
                                                    <option value="2" @selected($pengawasan->gcs_v_sampai == 2)>2 - Suara
                                                        tidak jelas</option>
                                                    <option value="1" @selected($pengawasan->gcs_v_sampai == 1)>1 - tidak ada
                                                        respon</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="resiko_nafas_sampai">Skor resiko nafas</label>
                                    <select name="resiko_nafas_sampai" id="resiko_nafas_sampai" class="form-select">
                                        <option value="">--Pilih--</option>
                                        <option value="1" @selected($pengawasan->resiko_nafas_sampai == 1)>Tidak beresiko</option>
                                        <option value="2" @selected($pengawasan->resiko_nafas_sampai == 2)>Resiko rendah</option>
                                        <option value="3" @selected($pengawasan->resiko_nafas_sampai == 3)>Resiko tinggi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('input,select,textarea').prop('disabled', true);
        });
    </script>
@endpush
