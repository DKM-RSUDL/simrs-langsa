@extends('layouts.administrator.master')

@section('content')
@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.include')

<div class="row">
    <div class="col-md-3">
        @include('components.patient-card-keperawatan')
    </div>

    <div class="col-md-9">
        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">
            <i class="ti-arrow-left"></i> Kembali
        </a>
        <div class="">
            <div class="card-body">
                <h4 class="header-asesmen">Asesmen Awal Keperawatan Rawat Inap Dewasa</h4>
                <p class="text-muted">
                    Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                </p>

                <form method="POST" action="{{ route('rawat-inap.asesmen.keperawatan.umum.index', [
                        'kd_unit' => $kd_unit,
                        'kd_pasien' => $kd_pasien,
                        'tgl_masuk' => $tgl_masuk,
                        'urut_masuk' => $urut_masuk,
                    ]) }}" class="mt-4">
                    @csrf
                    <div class="section-separator" id="data-umum">
                        <h5 class="section-title">1. DATA UMUM</h5>

                        <!-- Tanggal dan Jam Masuk -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Tanggal dan Jam Masuk:</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" name="tanggal" id="tanggal_masuk"
                                            value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="time" class="form-control" name="jam" id="jam_masuk"
                                            value="{{ date('H:i') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vital Signs -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Nadi:</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-2">
                                    <input type="number" class="form-control" name="nadi" placeholder="Nadi">
                                    <span class="input-group-text">kali/mnt</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Sistole:</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-2">
                                    <input type="number" class="form-control" name="sistole" placeholder="120">
                                    <span class="input-group-text">mmHg</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Distole:</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-2">
                                    <input type="number" class="form-control" name="distole" placeholder="80">
                                    <span class="input-group-text">mmHg</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Nafas:</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-2">
                                    <input type="number" class="form-control" name="nafas" placeholder="Nafas">
                                    <span class="input-group-text">kali/mnt</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Suhu:</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-2">
                                    <input type="text" step="0.1" class="form-control" name="suhu" placeholder="36.5">
                                    <span class="input-group-text">°C</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">SaO2:</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-2">
                                    <input type="number" class="form-control" name="sao2" placeholder="98">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">TB:</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-2">
                                    <input type="number" class="form-control" name="tb" placeholder="170">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">BB:</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-2">
                                    <input type="number" step="0.1" class="form-control" name="bb" placeholder="70">
                                    <span class="input-group-text">Kg</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Status:</label>
                            <div class="col-sm-9">
                                <div class="mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="status[]" id="berdiri"
                                            value="berdiri">
                                        <label class="form-check-label" for="berdiri">Berdiri</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="status[]" id="tidur"
                                            value="tidur">
                                        <label class="form-check-label" for="tidur">Tidur</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="status[]" id="duduk"
                                            value="duduk">
                                        <label class="form-check-label" for="duduk">Duduk</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kondisi saat masuk -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Kondisi saat masuk:</label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kondisi_masuk" id="mandiri"
                                        value="mandiri">
                                    <label class="form-check-label" for="mandiri">Mandiri</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kondisi_masuk" id="tempat_tidur"
                                        value="tempat_tidur">
                                    <label class="form-check-label" for="tempat_tidur">Tempat tidur</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kondisi_masuk"
                                        id="lainnya_kondisi" value="lainnya">
                                    <label class="form-check-label" for="lainnya_kondisi">Lainnya:</label>
                                    <input type="text" class="form-control d-inline-block ms-2"
                                        name="kondisi_masuk_lainnya" style="width: 300px;" placeholder="Sebutkan...">
                                </div>
                            </div>
                        </div>

                        <!-- Dokter DPJP -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Dokter (DPJP):</label>
                            <div class="col-sm-9">
                            <select name="kd_dokter" id="kd_dokter" class="form-select select2" required>
                                <option value="">--Pilih--</option>
                                @foreach ($dokter as $dok)
                                    <option value="{{ $dok->kd_dokter }}">{{ $dok->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                        <!-- Diagnosis masuk -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Diagnosis masuk:</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="diagnosis_masuk" rows="3"
                                    placeholder="Diagnosis masuk pasien"></textarea>
                            </div>
                        </div>

                        <!-- Keluhan utama -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Keluhan utama:</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="keluhan_utama" rows="3"
                                    placeholder="Keluhan utama pasien"></textarea>
                            </div>
                        </div>

                        <!-- Jenis reaksi -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Jenis reaksi:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="jenis_reaksi"
                                    placeholder="Jenis reaksi alergi">
                            </div>
                        </div>

                        <!-- Barang berharga -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Barang berharga:</label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="barang_berharga" id="perhiasan"
                                        value="perhiasan">
                                    <label class="form-check-label" for="perhiasan">Perhiasan</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="barang_berharga" id="uang"
                                        value="uang">
                                    <label class="form-check-label" for="uang">Uang</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="barang_berharga"
                                        id="lainnya_barang" value="lainnya">
                                    <label class="form-check-label" for="lainnya_barang">Lainnya:</label>
                                    <input type="text" class="form-control d-inline-block ms-2"
                                        name="barang_berharga_lainnya" style="width: 200px;" placeholder="Sebutkan...">
                                </div>
                            </div>
                        </div>

                        <!-- Alat bantu yang digunakan -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Alat bantu yang digunakan:</label>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="alat_bantu[]" id="kacamata"
                                        value="kacamata">
                                    <label class="form-check-label" for="kacamata">Kacamata</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="alat_bantu[]"
                                        id="lensa_kontak" value="lensa_kontak">
                                    <label class="form-check-label" for="lensa_kontak">Lensa kontak</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="alat_bantu[]" id="gigi_palsu"
                                        value="gigi_palsu">
                                    <label class="form-check-label" for="gigi_palsu">Gigi palsu</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="alat_bantu[]"
                                        id="alat_bantu_dengar" value="alat_bantu_dengar">
                                    <label class="form-check-label" for="alat_bantu_dengar">Alat bantu dengar</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-separator" id="alergi">
                        <h5 class="section-title">2. Alergi</h5>
                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                            id="openAlergiModal" data-bs-toggle="modal" data-bs-target="#alergiModal">
                            <i class="ti-plus"></i> Tambah Alergi
                        </button>
                        <input type="hidden" name="alergis" id="alergisInput" value="[]">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="createAlergiTable">
                                <thead class="table-light">
                                    <tr>
                                        <th width="20%">Jenis Alergi</th>
                                        <th width="25%">Alergen</th>
                                        <th width="25%">Reaksi</th>
                                        <th width="20%">Tingkat Keparahan</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="no-alergi-row">
                                        <td colspan="5" class="text-center text-muted">Tidak ada data alergi</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @push('modals')
                            @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.modal-create-alergi')
                        @endpush
                    </div>

                    <div class="section-separator" id="riwayat-pasien">
                        <h5 class="section-title">3. RIWAYAT PASIEN</h5>

                        <div class="col-12 mb-3">
                            <h6 class="fw-bold">Riwayat pasien: (penyakit utama/ operasi/ cidera mayor)</h6>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                        id="riwayat_pasien_hypertensi" value="hypertensi">
                                    <label class="form-check-label" for="riwayat_pasien_hypertensi">Hypertensi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                        id="riwayat_pasien_infark_myiokard" value="infark_myiokard">
                                    <label class="form-check-label" for="riwayat_pasien_infark_myiokard">Infark
                                        myiokard</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                        id="riwayat_pasien_stroke" value="stroke">
                                    <label class="form-check-label" for="riwayat_pasien_stroke">Stroke</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                        id="riwayat_pasien_jantung_koroner" value="jantung_koroner">
                                    <label class="form-check-label" for="riwayat_pasien_jantung_koroner">Jantung
                                        koroner</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                        id="riwayat_pasien_opok" value="opok">
                                    <label class="form-check-label" for="riwayat_pasien_opok">PPOK</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                        id="riwayat_pasien_asthma" value="asthma">
                                    <label class="form-check-label" for="riwayat_pasien_asthma">Asthma</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                        id="riwayat_pasien_tb" value="tb">
                                    <label class="form-check-label" for="riwayat_pasien_tb">TB</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                        id="riwayat_pasien_penyakit_paru_lainnya" value="penyakit_paru_lainnya">
                                    <label class="form-check-label" for="riwayat_pasien_penyakit_paru_lainnya">Penyakit
                                        paru lainnya</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                        id="riwayat_pasien_diabetes_mellitus" value="diabetes_mellitus">
                                    <label class="form-check-label" for="riwayat_pasien_diabetes_mellitus">Diabetes
                                        Mellitus</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                        id="riwayat_pasien_hepatitis" value="hepatitis">
                                    <label class="form-check-label" for="riwayat_pasien_hepatitis">Hepatitis</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                        id="riwayat_pasien_ulkus" value="ulkus">
                                    <label class="form-check-label" for="riwayat_pasien_ulkus">Ulkus</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                        id="riwayat_pasien_gagal_ginjal" value="gagal_ginjal">
                                    <label class="form-check-label" for="riwayat_pasien_gagal_ginjal">Gagal
                                        ginjal</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                        id="riwayat_pasien_kanker" value="kanker">
                                    <label class="form-check-label" for="riwayat_pasien_kanker">Kanker</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                        id="riwayat_pasien_kejang" value="kejang">
                                    <label class="form-check-label" for="riwayat_pasien_kejang">Kejang</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                        id="riwayat_pasien_jiwa" value="jiwa">
                                    <label class="form-check-label" for="riwayat_pasien_jiwa">Jiwa</label>
                                </div>

                            </div>
                            <label class="form-check-label mt-2" for="lainnya">Lainnya</label>
                            <input type="text" class="form-control" name="riwayat_pasien_lain" placeholder="lainnya">
                        </div>

                        <!-- Riwayat Alkohol/Obat dan Merokok -->
                        <div class="col-12 mb-3 section-separator">
                            <h6 class="fw-bold">Riwayat Konsumsi</h6>

                            <!-- Alkohol/Obat -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Alkohol/obat:</label>
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="alkohol_obat"
                                                id="alkohol_tidak" value="tidak">
                                            <label class="form-check-label" for="alkohol_tidak">Tidak</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="alkohol_obat"
                                                id="alkohol_ya" value="ya">
                                            <label class="form-check-label" for="alkohol_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="alkohol_obat"
                                                id="alkohol_berhenti" value="berhenti">
                                            <label class="form-check-label" for="alkohol_berhenti">Berhenti</label>
                                        </div>
                                    </div>

                                    <!-- Detail untuk alkohol/obat jika Ya dipilih -->
                                    <div class="alkohol-detail" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label class="form-label">Jenis:</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="alkohol_jenis" placeholder="Jenis alkohol/obat">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label class="form-label">Jumlah/hari:</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="alkohol_jumlah" placeholder="Jumlah per hari">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Merokok -->
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Merokok:</label>
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="merokok"
                                                id="merokok_tidak" value="tidak">
                                            <label class="form-check-label" for="merokok_tidak">Tidak</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="merokok" id="merokok_ya"
                                                value="ya">
                                            <label class="form-check-label" for="merokok_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="merokok"
                                                id="merokok_berhenti" value="berhenti">
                                            <label class="form-check-label" for="merokok_berhenti">Berhenti</label>
                                        </div>
                                    </div>

                                    <!-- Detail untuk merokok jika Ya dipilih -->
                                    <div class="merokok-detail" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label class="form-label">Jenis:</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="merokok_jenis" placeholder="Jenis rokok">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label class="form-label">Jumlah/hari:</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="merokok_jumlah" placeholder="Batang per hari">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Riwayat Keluarga -->
                        <div class="col-12 mb-3 section-separator">
                            <h6 class="fw-bold">Riwayat keluarga</h6>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                        id="riwayat_keluarga_penyakit_jantung" value="penyakit_jantung">
                                    <label class="form-check-label" for="riwayat_keluarga_penyakit_jantung">Penyakit
                                        jantung</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                        id="riwayat_keluarga_hypertensi" value="hypertensi">
                                    <label class="form-check-label" for="riwayat_keluarga_hypertensi">Hypertensi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                        id="riwayat_keluarga_stroke" value="stroke">
                                    <label class="form-check-label" for="riwayat_keluarga_stroke">Stroke</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                        id="riwayat_keluarga_asthma" value="asthma">
                                    <label class="form-check-label" for="riwayat_keluarga_asthma">Asthma</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                        id="riwayat_keluarga_gangguan_jiwa" value="gangguan_jiwa">
                                    <label class="form-check-label" for="riwayat_keluarga_gangguan_jiwa">Gangguan
                                        jiwa</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                        id="riwayat_keluarga_gagal_ginjal" value="gagal_ginjal">
                                    <label class="form-check-label" for="riwayat_keluarga_gagal_ginjal">Gagal
                                        ginjal</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                        id="riwayat_keluarga_lainnya_checkbox" value="lainnya">
                                    <label class="form-check-label"
                                        for="riwayat_keluarga_lainnya_checkbox">Lainnya</label>
                                </div>
                            </div>

                            <!-- Baris kedua -->
                            <div class="d-flex flex-wrap gap-3 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                        id="riwayat_keluarga_kanker" value="kanker">
                                    <label class="form-check-label" for="riwayat_keluarga_kanker">Kanker</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                        id="riwayat_keluarga_kejang" value="kejang">
                                    <label class="form-check-label" for="riwayat_keluarga_kejang">Kejang</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                        id="riwayat_keluarga_gangguan_hematologi" value="gangguan_hematologi">
                                    <label class="form-check-label" for="riwayat_keluarga_gangguan_hematologi">Gangguan
                                        hematologi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                        id="riwayat_keluarga_diabetes" value="diabetes">
                                    <label class="form-check-label" for="riwayat_keluarga_diabetes">Diabetes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                        id="riwayat_keluarga_hepatitis" value="hepatitis">
                                    <label class="form-check-label" for="riwayat_keluarga_hepatitis">Hepatitis</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                        id="riwayat_keluarga_tb" value="tb">
                                    <label class="form-check-label" for="riwayat_keluarga_tb">TB</label>
                                </div>
                            </div>

                            <!-- Input untuk Diabetes Lainnya -->
                            <div class="mt-2">
                                <label class="form-label">Diabetes Lainnya:</label>
                                <input type="text" class="form-control" name="diabetes_lainnya"
                                    placeholder="Sebutkan jenis diabetes lainnya jika ada">
                            </div>
                        </div>

                        <!-- Psikososial/Ekonomi -->
                        <div class="section-separator" id="psikososial-ekonomi">
                            <h5 class="section-title">Psikososial/ ekonomi</h5>

                            <!-- Status pernikahan -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Status pernikahan:</label>
                                <div class="col-sm-9">
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status_pernikahan"
                                                id="menikah" value="menikah">
                                            <label class="form-check-label" for="menikah">Menikah</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status_pernikahan"
                                                id="belum_menikah" value="belum_menikah">
                                            <label class="form-check-label" for="belum_menikah">Belum menikah</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status_pernikahan"
                                                id="duda_janda" value="duda_janda">
                                            <label class="form-check-label" for="duda_janda">Duda/janda</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Keluarga -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Keluarga:</label>
                                <div class="col-sm-9">
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="keluarga"
                                                id="tinggal_serumah" value="tinggal_serumah">
                                            <label class="form-check-label" for="tinggal_serumah">Tinggal
                                                serumah</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="keluarga"
                                                id="tinggal_sendiri" value="tinggal_sendiri">
                                            <label class="form-check-label" for="tinggal_sendiri">Tinggal
                                                sendiri</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tempat tinggal -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Tempat tinggal:</label>
                                <div class="col-sm-9">
                                    <div class="d-flex flex-wrap gap-3 align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tempat_tinggal"
                                                id="rumah" value="rumah">
                                            <label class="form-check-label" for="rumah">Rumah</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tempat_tinggal"
                                                id="panti_asuhan" value="panti_asuhan">
                                            <label class="form-check-label" for="panti_asuhan">Panti asuhan</label>
                                        </div>
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input" type="radio" name="tempat_tinggal"
                                                id="tempat_tinggal_lainnya" value="lainnya">
                                            <label class="form-check-label me-2"
                                                for="tempat_tinggal_lainnya">Lainnya:</label>
                                            <input type="text" class="form-control form-control-sm"
                                                name="tempat_tinggal_lainnya_detail" style="width: 200px;"
                                                placeholder="Sebutkan...">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pekerjaan -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Pekerjaan:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="pekerjaan"
                                        placeholder="Pekerjaan pasien">
                                </div>
                            </div>

                            <!-- Aktivitas -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Aktivitas:</label>
                                <div class="col-sm-9">
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="aktivitas[]"
                                                id="purnawaktu" value="purnawaktu">
                                            <label class="form-check-label" for="purnawaktu">Purnawaktu</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="aktivitas[]"
                                                id="paruh_waktu" value="paruh_waktu">
                                            <label class="form-check-label" for="paruh_waktu">Paruh waktu</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="aktivitas[]"
                                                id="pensiunan" value="pensiunan">
                                            <label class="form-check-label" for="pensiunan">Pensiunan</label>
                                        </div>
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" name="aktivitas[]"
                                                id="aktivitas_lainnya" value="lainnya">
                                            <label class="form-check-label me-2"
                                                for="aktivitas_lainnya">Lainnya:</label>
                                            <input type="text" class="form-control form-control-sm"
                                                name="aktivitas_lainnya_detail" style="width: 150px;"
                                                placeholder="Sebutkan...">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-3 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="aktivitas[]"
                                                id="aktivitas_mandiri" value="mandiri">
                                            <label class="form-check-label" for="aktivitas_mandiri">Mandiri</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="aktivitas[]"
                                                id="tongkat" value="tongkat">
                                            <label class="form-check-label" for="tongkat">Tongkat</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="aktivitas[]"
                                                id="kursi_roda" value="kursi_roda">
                                            <label class="form-check-label" for="kursi_roda">Kursi roda</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="aktivitas[]"
                                                id="tirah_baring" value="tirah_baring">
                                            <label class="form-check-label" for="tirah_baring">Tirah baring</label>
                                        </div>
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" name="aktivitas[]"
                                                id="aktivitas_lainnya2" value="lainnya2">
                                            <label class="form-check-label me-2"
                                                for="aktivitas_lainnya2">Lainnya:</label>
                                            <input type="text" class="form-control form-control-sm"
                                                name="aktivitas_lainnya2_detail" style="width: 150px;"
                                                placeholder="Sebutkan...">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Curiga penganiayaan/penelantaran -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Curiga penganiayaan/penelantaran:</label>
                                <div class="col-sm-9">
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="curiga_penganiayaan"
                                                id="curiga_ya" value="ya">
                                            <label class="form-check-label" for="curiga_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="curiga_penganiayaan"
                                                id="curiga_tidak" value="tidak">
                                            <label class="form-check-label" for="curiga_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status emosional -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Status emosional:</label>
                                <div class="col-sm-9">
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status_emosional"
                                                id="kooperatif" value="kooperatif">
                                            <label class="form-check-label" for="kooperatif">Kooperatif</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status_emosional"
                                                id="cemas" value="cemas">
                                            <label class="form-check-label" for="cemas">Cemas</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status_emosional"
                                                id="depresi" value="depresi">
                                            <label class="form-check-label" for="depresi">Depresi</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status_emosional"
                                                id="ingin_mengakhiri_hidup" value="ingin_mengakhiri_hidup">
                                            <label class="form-check-label" for="ingin_mengakhiri_hidup">Ingin
                                                mengakhiri hidup</label>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input" type="radio" name="status_emosional"
                                                id="status_emosional_lainnya" value="lainnya">
                                            <label class="form-check-label me-2"
                                                for="status_emosional_lainnya">Lainnya:</label>
                                            <input type="text" class="form-control form-control-sm d-inline-block"
                                                name="status_emosional_lainnya_detail" style="width: 300px;"
                                                placeholder="Sebutkan status emosional lainnya...">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Keluarga terdekat -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Keluarga terdekat:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="keluarga_terdekat_nama"
                                        placeholder="Nama">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Hubungan:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="keluarga_terdekat_hubungan"
                                        placeholder="Hubungan">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Telepon:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="keluarga_terdekat_telepon"
                                        placeholder="No. telepon">
                                </div>
                            </div>


                            <!-- Informasi didapat dari -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Informasi didapat dari:</label>
                                <div class="col-sm-9">
                                    <div class="d-flex flex-wrap gap-3 align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="informasi_didapat_dari"
                                                id="pasien" value="pasien">
                                            <label class="form-check-label" for="pasien">Pasien</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="informasi_didapat_dari"
                                                id="keluarga_info" value="keluarga">
                                            <label class="form-check-label" for="keluarga_info">Keluarga</label>
                                        </div>
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input" type="radio" name="informasi_didapat_dari"
                                                id="informasi_lainnya" value="lainnya">
                                            <label class="form-check-label me-2"
                                                for="informasi_lainnya">Lainnya:</label>
                                            <input type="text" class="form-control form-control-sm"
                                                name="informasi_didapat_dari_lainnya" style="width: 200px;"
                                                placeholder="Sebutkan...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Spiritual -->
                        <div class="col-12 mb-3 section-separator">
                            <h6 class="fw-bold">Spiritual</h6>

                            <!-- Agama -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Agama:</label>
                                <div class="col-sm-10">
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="agama[]"
                                                id="agama_islam" value="islam">
                                            <label class="form-check-label" for="agama_islam">Islam</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="agama[]"
                                                id="agama_katolik" value="katolik">
                                            <label class="form-check-label" for="agama_katolik">Katolik</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="agama[]"
                                                id="agama_protestan" value="protestan">
                                            <label class="form-check-label" for="agama_protestan">Protestan</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="agama[]"
                                                id="agama_budha" value="budha">
                                            <label class="form-check-label" for="agama_budha">Budha</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="agama[]"
                                                id="agama_hindu" value="hindu">
                                            <label class="form-check-label" for="agama_hindu">Hindu</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="agama[]"
                                                id="agama_konghucu" value="konghucu">
                                            <label class="form-check-label" for="agama_konghucu">Konghucu</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pandangan spiritual pasien terhadap penyakitnya -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Pandangan spiritual pasien terhadap
                                    penyakitnya:</label>
                                <div class="col-sm-10">
                                    <div class="d-flex flex-wrap gap-3 align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pandangan_spiritual"
                                                id="pandangan_takdir" value="takdir">
                                            <label class="form-check-label" for="pandangan_takdir">Takdir</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pandangan_spiritual"
                                                id="pandangan_hukuman" value="hukuman">
                                            <label class="form-check-label" for="pandangan_hukuman">Hukuman</label>
                                        </div>
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input" type="radio" name="pandangan_spiritual"
                                                id="pandangan_lainnya" value="lainnya">
                                            <label class="form-check-label me-2"
                                                for="pandangan_lainnya">Lainnya:</label>
                                            <input type="text" class="form-control form-control-sm"
                                                name="pandangan_spiritual_lainnya" style="width: 300px;"
                                                placeholder="Sebutkan pandangan spiritual lainnya...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="section-separator" id="pemeriksaan-fisik">
                        <h5 class="section-title">4. PEMERIKSAAN FISIK</h5>

                        <!-- Pemeriksaan mata, telinga, hidung, tenggorokan -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0">Pemeriksaan mata, telinga, hidung, tenggorokan</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="mata_telinga_hidung_normal"
                                        id="mata_telinga_hidung_normal" value="normal">
                                    <label class="form-check-label fw-bold" for="mata_telinga_hidung">Normal</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="mata_telinga_hidung_normal[]" id="gangguan_visus"
                                                value="gangguan_visus">
                                            <label class="form-check-label" for="gangguan_visus">Gangguan visus</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="mata_telinga_hidung_normal[]" id="galucoma" value="galucoma">
                                            <label class="form-check-label" for="galucoma">Galucoma</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="mata_telinga_hidung_normal[]" id="sulit_mendengar"
                                                value="sulit_mendengar">
                                            <label class="form-check-label" for="sulit_mendengar">Sulit
                                                mendengar</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="mata_telinga_hidung_normal[]" id="gusi" value="gusi">
                                            <label class="form-check-label" for="gusi">Gusi</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="mata_telinga_hidung_normal[]" id="kemerahan" value="kemerahan">
                                            <label class="form-check-label" for="kemerahan">Kemerahan</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="mata_telinga_hidung_normal[]" id="drainase" value="drainase">
                                            <label class="form-check-label" for="drainase">Drainase</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="mata_telinga_hidung_normal[]" id="buta" value="buta">
                                            <label class="form-check-label" for="buta">Buta</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="mata_telinga_hidung_normal[]" id="tuli" value="tuli">
                                            <label class="form-check-label" for="tuli">Tuli</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="mata_telinga_hidung_normal[]" id="gigi" value="gigi">
                                            <label class="form-check-label" for="gigi">Gigi</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="mata_telinga_hidung_normal[]" id="rasa_terbakar"
                                                value="rasa_terbakar">
                                            <label class="form-check-label" for="rasa_terbakar">Rasa terbakar</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="mata_telinga_hidung_normal[]" id="luka" value="luka">
                                            <label class="form-check-label" for="luka">Luka</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="mata_telinga_hidung_normal[]" id="lainnya" value="lainnya">
                                            <label class="form-check-label" for="lainnya">Lainnya</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label fw-bold">Catatan:</label>
                                    <textarea class="form-control" name="mata_telinga_hidung_normal_catatan" rows="2"
                                        placeholder="Catatan pemeriksaan"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Pemeriksaan paru (kecepatan, kedalaman, pola, suara nafas) -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0">Pemeriksaan paru (kecepatan, kedalaman, pola, suara nafas)</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_paru_normal"
                                        id="pemeriksaan_paru_normal" value="normal">
                                    <label class="form-check-label fw-bold" for="pemeriksaan_paru_normal">Normal</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="asimetris" value="asimetris">
                                            <label class="form-check-label" for="asimetris">Asimetris</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="takipnea" value="takipnea">
                                            <label class="form-check-label" for="takipnea">Takipnea</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="ronki" value="ronki">
                                            <label class="form-check-label" for="ronki">Ronki</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="kiri_1" value="kiri_1">
                                            <label class="form-check-label" for="kiri_1">Kiri</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="kanan_1" value="kanan_1">
                                            <label class="form-check-label" for="kanan_1">Kanan</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="batuk" value="batuk">
                                            <label class="form-check-label" for="batuk">Batuk</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="barrel_chest" value="barrel_chest">
                                            <label class="form-check-label" for="barrel_chest">Barrel chest</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="bradipnea_1" value="bradipnea_1">
                                            <label class="form-check-label" for="bradipnea_1">Bradipnea</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="mengi_wheezing" value="mengi_wheezing">
                                            <label class="form-check-label" for="mengi_wheezing">Mengi/ wheezing</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="kiri_2" value="kiri_2">
                                            <label class="form-check-label" for="kiri_2">Kiri</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="kanan_2" value="kanan_2">
                                            <label class="form-check-label" for="kanan_2">Kanan</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="warna_dahak" value="warna_dahak">
                                            <label class="form-check-label" for="warna_dahak">Warna dahak</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="sesak" value="sesak">
                                            <label class="form-check-label" for="sesak">Sesak</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="dangkal" value="dangkal">
                                            <label class="form-check-label" for="dangkal">Dangkal</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="menghilang" value="menghilang">
                                            <label class="form-check-label" for="menghilang">Menghilang</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="kiri_3" value="kiri_3">
                                            <label class="form-check-label" for="kiri_3">Kiri</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="kanan_3" value="kanan_3">
                                            <label class="form-check-label" for="kanan_3">Kanan</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                                id="lainnya_paru" value="lainnya">
                                            <label class="form-check-label" for="lainnya_paru">Lainnya</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label fw-bold">Catatan:</label>
                                    <textarea class="form-control" name="pemeriksaan_paru_catatan" rows="2"
                                        placeholder="Catatan pemeriksaan"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Pemeriksaan Gastrointestinal -->
                        <div class="form-section mt-3">
                            <div class="section-header d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Pemeriksaan gastrointestinal</span>
                                <div class="form-check normal-checkbox">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal_normal" id="pemeriksaan_gastrointestinal_normal" value="normal">
                                    <label class="form-check-label fw-bold" for="pemeriksaan_gastrointestinal_normal">Normal</label>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]" id="pemeriksaan_gastrointestinal_distensi" value="distensi">
                                    <label class="form-check-label" for="pemeriksaan_gastrointestinal_distensi">Distensi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]" id="pemeriksaan_gastrointestinal_bisingususmenurun" value="bising_usus_menurun">
                                    <label class="form-check-label" for="pemeriksaan_gastrointestinal_bisingususmenurun">Bising usus menurun</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]" id="pemeriksaan_gastrointestinal_anoreksia" value="anoreksia">
                                    <label class="form-check-label" for="pemeriksaan_gastrointestinal_anoreksia">Anoreksia</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]" id="pemeriksaan_gastrointestinal_disfagia" value="disfagia">
                                    <label class="form-check-label" for="pemeriksaan_gastrointestinal_disfagia">Disfagia</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]" id="pemeriksaan_gastrointestinal_diare" value="diare">
                                    <label class="form-check-label" for="pemeriksaan_gastrointestinal_diare">Diare</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]" id="pemeriksaan_gastrointestinal_klismagliserin" value="klisma_sput_gliserin">
                                    <label class="form-check-label" for="pemeriksaan_gastrointestinal_klismagliserin">Klisma sput gliserin</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]" id="pemeriksaan_gastrointestinal_mual" value="mual_muntah">
                                    <label class="form-check-label" for="pemeriksaan_gastrointestinal_mual">Mual/muntah</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]" id="pemeriksaan_gastrointestinal_bisingusmenurun2" value="bising_usus_menurun2">
                                    <label class="form-check-label" for="pemeriksaan_gastrointestinal_bisingusmenurun2">Bising usus menurun</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]" id="pemeriksaan_gastrointestinal_intoleransidiet" value="intoleransi_diet">
                                    <label class="form-check-label" for="pemeriksaan_gastrointestinal_intoleransidiet">Intoleransi diet</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]" id="pemeriksaan_gastrointestinal_konstipasi" value="konstipasi">
                                    <label class="form-check-label" for="pemeriksaan_gastrointestinal_konstipasi">Konstipasi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]" id="pemeriksaan_gastrointestinal_babberakhir" value="bab_berakhir">
                                    <label class="form-check-label" for="pemeriksaan_gastrointestinal_babberakhir">BAB terakhir:</label>
                                </div>
                                <div class="form-check">
                                    <input type="text" class="form-control" name="pemeriksaan_gastrointestinal_bab_terakhir" placeholder="BAB terakhir">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-12">
                                    <label class="form-label">Diet khusus:</label>
                                    <input type="text" class="form-control" name="diet_khusus" placeholder="Diet khusus">
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Catatan:</label>
                                <textarea class="form-control" name="pemeriksaan_gastrointestinal_catatan" rows="2" placeholder="Catatan pemeriksaan"></textarea>
                            </div>
                        </div>

                        <!-- Pemeriksaan Kardiovaskular -->
                        <div class="form-section mt-3">
                            <div class="section-header d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Pemeriksaan Kardiovaskular</span>
                                <div class="form-check normal-checkbox">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular_normal" id="pemeriksaan_kardiovaskular_normal" value="normal">
                                    <label class="form-check-label fw-bold" for="pemeriksaan_kardiovaskular_normal">Normal</label>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]" id="pemeriksaan_kardiovaskular_takikardi" value="takikardi">
                                    <label class="form-check-label" for="pemeriksaan_kardiovaskular_takikardi">Takikardi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]" id="pemeriksaan_kardiovaskular_iregular" value="iregular">
                                    <label class="form-check-label" for="pemeriksaan_kardiovaskular_iregular">Iregular</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]" id="pemeriksaan_kardiovaskular_tingling" value="tingling">
                                    <label class="form-check-label" for="pemeriksaan_kardiovaskular_tingling">Tingling</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]" id="pemeriksaan_kardiovaskular_edema" value="edema">
                                    <label class="form-check-label" for="pemeriksaan_kardiovaskular_edema">Edema</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]" id="pemeriksaan_kardiovaskular_denyutnadilemah" value="denyut_nadi_lemah">
                                    <label class="form-check-label" for="pemeriksaan_kardiovaskular_denyutnadilemah">Denyut nadi lemah</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]" id="pemeriksaan_kardiovaskular_bradikardi" value="bradikardi">
                                    <label class="form-check-label" for="pemeriksaan_kardiovaskular_bradikardi">Bradikardi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]" id="pemeriksaan_kardiovaskular_murmur" value="murmur">
                                    <label class="form-check-label" for="pemeriksaan_kardiovaskular_murmur">Murmur</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]" id="pemeriksaan_kardiovaskular_baal" value="baal">
                                    <label class="form-check-label" for="pemeriksaan_kardiovaskular_baal">Baal</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]" id="pemeriksaan_kardiovaskular_fatique" value="fatique">
                                    <label class="form-check-label" for="pemeriksaan_kardiovaskular_fatique">Fatique</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]" id="pemeriksaan_kardiovaskular_denyuttidakada" value="denyut_tidak_ada">
                                    <label class="form-check-label" for="pemeriksaan_kardiovaskular_denyuttidakada">Denyut tidak ada</label>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Catatan:</label>
                                <textarea class="form-control" name="pemeriksaan_kardiovaskular_catatan" rows="2" placeholder="Catatan pemeriksaan"></textarea>
                            </div>
                        </div>

                        <!-- Pemeriksaan Genitourinaria dan Ginekologi -->
                        <div class="mb-4 mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0">Pemeriksaan Genitourinaria dan Ginekologi</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_genitourinaria_ginekologi_normal" id="pemeriksaan_genitourinaria_ginekologi_normal" value="normal">
                                    <label class="form-check-label fw-bold" for="pemeriksaan_genitourinaria_ginekologi_normal">Normal</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_genitourinaria_ginekologi[]" id="pemeriksaan_genitourinaria_ginekologi_kateteri" value="kateter">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_ginekologi_kateteri">Kateter</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_genitourinaria_ginekologi[]" id="pemeriksaan_genitourinaria_ginekologi_hesitansi" value="hesitansi">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_ginekologi_hesitansi">Hesitansi</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_genitourinaria_ginekologi[]" id="pemeriksaan_genitourinaria_ginekologi_hematuria" value="hematuria">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_ginekologi_hematuria">Hematuria</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_genitourinaria_ginekologi[]" id="pemeriksaan_genitourinaria_ginekologi_menopouse" value="menopouse">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_ginekologi_menopouse">Menopouse</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_genitourinaria_ginekologi[]" id="pemeriksaan_genitourinaria_ginekologi_sekret_abnormal" value="sekret_abnormal">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_ginekologi_sekret_abnormal">Sekret abnormal</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_genitourinaria_ginekologi[]" id="pemeriksaan_genitourinaria_ginekologi_urostomy" value="urostomy">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_ginekologi_urostomy">Urostomy</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_genitourinaria_ginekologi[]" id="pemeriksaan_genitourinaria_inkontinesia" value="inkontinesia">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_inkontinesia">Inkontinesia</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_genitourinaria_ginekologi[]" id="pemeriksaan_genitourinaria_nokturia" value="nokturia">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_nokturia">Nokturia</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_genitourinaria_ginekologi[]" id="pemeriksaan_genitourinaria_disuria" value="disuria">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_disuria">Disuria</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_genitourinaria_ginekologi[]" id="pemeriksaan_genitourinaria_menstruasi_terakhir" value="menstruasi_terakhir">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_menstruasi_terakhir">Menstruasi terakhir</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_genitourinaria_ginekologi[]" id="pemeriksaan_genitourinaria_hamil" value="hamil">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_hamil">Hamil</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label fw-bold">Catatan:</label>
                                    <textarea class="form-control" name="pemeriksaan_genitourinaria_ginekologi_catatan" rows="2" placeholder="Catatan pemeriksaan"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Pemeriksaan Neurologi (orientasi, verbal, kekuatan) -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0">Pemeriksaan Neurologi (orientasi, verbal, kekuatan)</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi_normal" id="pemeriksaan_neurologi_normal" value="normal">
                                    <label class="form-check-label fw-bold" for="pemeriksaan_neurologi_normal">Normal</label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]" id="pemeriksaan_neurologi_dalam_sedasi" value="dalam_sedasi">
                                            <label class="form-check-label" for="pemeriksaan_neurologi_dalam_sedasi">Dalam sedasi</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]" id="pemeriksaan_neurologi_vertigo" value="vertigo">
                                            <label class="form-check-label" for="pemeriksaan_neurologi_vertigo">Vertigo</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]" id="pemeriksaan_neurologi_afasia" value="afasia">
                                            <label class="form-check-label" for="pemeriksaan_neurologi_afasia">Afasia</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]" id="pemeriksaan_neurologi_tremor" value="tremor">
                                            <label class="form-check-label" for="pemeriksaan_neurologi_tremor">Tremor</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]" id="pemeriksaan_neurologi_tidak_stabil" value="tidak_stabil">
                                            <label class="form-check-label" for="pemeriksaan_neurologi_tidak_stabil">Tidak stabil</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]" id="pemeriksaan_neurologi_letargi" value="letargi">
                                            <label class="form-check-label" for="pemeriksaan_neurologi_letargi">Letargi</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]" id="pemeriksaan_genitourinaria_sakit_kepala" value="sakit_kepala">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_sakit_kepala">Sakit kepala</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]" id="pemeriksaan_genitourinaria_Bicara_tidak_jelas" value="Bicara_tidak_jelas">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_Bicara_tidak_jelas">Bicara tidak jelas</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]" id="pemeriksaan_genitourinaria_baal" value="baal">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_baal">Baal</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]" id="pemeriksaan_genitourinaria_paralisis" value="paralisis">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_paralisis">Paralisis</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]" id="pemeriksaan_genitourinaria_semi_koma" value="semi_koma">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_semi_koma">Semi koma</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]" id="pemeriksaan_genitourinaria_pupil_tidak_reaktif" value="pupil_tidak_reaktif">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_pupil_tidak_reaktif">Pupil tidak reaktif</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]" id="pemeriksaan_genitourinaria_kejang" value="kejang">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_kejang">Kejang</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]" id="pemeriksaan_genitourinaria_tingling" value="tingling">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_tingling">Tingling</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]" id="pemeriksaan_genitourinaria_genggaman_lemah" value="genggaman_lemah">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_genggaman_lemah">Genggaman lemah</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]" id="pemeriksaan_genitourinaria_lainnya" value="lainnya">
                                            <label class="form-check-label" for="pemeriksaan_genitourinaria_lainnya">Lainnya</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label fw-bold">Catatan:</label>
                                    <textarea class="form-control" name="pemeriksaan_neurologi_catatan" rows="2" placeholder="Catatan pemeriksaan"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Kesadaran -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Kesadaran:</label>
                            <div class="col-sm-10">
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kesadaran[]"
                                            id="kesadaran_compos_mentis" value="compos_mentis">
                                        <label class="form-check-label" for="kesadaran_compos_mentis">Compos mentis</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kesadaran[]"
                                            id="kesadaran_apatis" value="apatis">
                                        <label class="form-check-label" for="kesadaran_apatis">Apatis</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kesadaran[]"
                                            id="kesadaran_somnolen" value="somnolen">
                                        <label class="form-check-label" for="kesadaran_somnolen">Somnolen</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kesadaran[]"
                                            id="kesadaran_sopor_koma" value="sopor_koma">
                                        <label class="form-check-label" for="kesadaran_sopor_koma">Sopor Koma</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kesadaran[]"
                                            id="kesadaran_koma" value="koma">
                                        <label class="form-check-label" for="kesadaran_koma">Koma</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">GCS</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="vital_sign[gcs]"
                                    id="gcsInput" placeholder="Contoh: 15 E4 V5 M6" readonly>
                                <button type="button" class="btn btn-outline-primary"
                                    onclick="openGCSModal()" title="Buka Kalkulator GCS">
                                    <i class="ti-calculator"></i> Hitung GCS
                                </button>
                            </div>
                            @push('modals')
                                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.gcs-modal')
                            @endpush
                        </div>
                    </div>

                    <div class="section-separator" id="pemeriksaan-fisik">
                        <h5 class="section-title">5.  PENGKAJIAN STATUS NUTRISI</h5>

                        <div class="card-body">
                            <!-- Pertanyaan 1 -->
                            <div class="mb-4">
                                <div class="d-flex align-items-start">
                                    <span class="badge bg-primary me-3 mt-1">1</span>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-3">Apakah pasien mengalami penurunan BB yang tidak diinginkan dalam 6 bulan terakhir?</h6>

                                        <div class="mb-3">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="bb_turun" id="bb_tidak_ada" value="0">
                                                <label class="form-check-label" for="bb_tidak_ada">
                                                    Tidak ada <span class="badge bg-secondary ms-2">Skor: 0</span>
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="bb_turun" id="bb_tidak_yakin" value="2">
                                                <label class="form-check-label" for="bb_tidak_yakin">
                                                    Tidak yakin / tidak tahu / terasa baju longgar <span class="badge bg-secondary ms-2">Skor: 2</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="ms-3">
                                            <p class="text-muted mb-2"><em>Jika "Ya" berapa penurunan berat badan tersebut:</em></p>
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="bb_turun_range" id="bb_1_5kg" value="1">
                                                        <label class="form-check-label" for="bb_1_5kg">
                                                            1 sd 5 Kg <span class="badge bg-secondary ms-2">Skor: 1</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="bb_turun_range" id="bb_6_10kg" value="2">
                                                        <label class="form-check-label" for="bb_6_10kg">
                                                            6 sd 10 Kg <span class="badge bg-secondary ms-2">Skor: 2</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="bb_turun_range" id="bb_11_15kg" value="3">
                                                        <label class="form-check-label" for="bb_11_15kg">
                                                            11 sd 15 Kg <span class="badge bg-secondary ms-2">Skor: 3</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="bb_turun_range" id="bb_lebih_15kg" value="4">
                                                        <label class="form-check-label" for="bb_lebih_15kg">
                                                            > 15 Kg <span class="badge bg-secondary ms-2">Skor: 4</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- Pertanyaan 2 -->
                            <div class="mb-4">
                                <div class="d-flex align-items-start">
                                    <span class="badge bg-primary me-3 mt-1">2</span>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-3">Apakah asupan makanan berkurang karena tidak nafsu makan?</h6>

                                        <div class="mb-3">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="nafsu_makan" id="nafsu_tidak" value="0">
                                                <label class="form-check-label" for="nafsu_tidak">
                                                    Tidak <span class="badge bg-secondary ms-2">Skor: 0</span>
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="nafsu_makan" id="nafsu_ya" value="1">
                                                <label class="form-check-label" for="nafsu_ya">
                                                    Ya <span class="badge bg-secondary ms-2">Skor: 1</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- Pertanyaan 3 -->
                            <div class="mb-4">
                                <div class="d-flex align-items-start">
                                    <span class="badge bg-primary me-3 mt-1">3</span>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-3">Pasien dengan diagnosa khusus:</h6>

                                        <div class="mb-3">
                                            <div class="form-check form-check-inline me-4">
                                                <input class="form-check-input" type="radio" name="diagnosa_khusus" id="diagnosa_ya" value="ya">
                                                <label class="form-check-label" for="diagnosa_ya">Ya</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="diagnosa_khusus" id="diagnosa_tidak" value="tidak">
                                                <label class="form-check-label" for="diagnosa_tidak">Tidak</label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label text-muted">
                                                <em>(Diabetes, Kemo, HD, geriatri, penurunan imun, dll sebutkan:</em>
                                            </label>
                                            <textarea class="form-control" rows="2" placeholder="Sebutkan diagnosa khusus jika ada..."></textarea>
                                        </div>

                                        <div class="mb-3 text-center">
                                            <h6 class="card-title mb-2">TOTAL SKOR</h6>
                                            <div class="display-1 text-primary fw-bold" id="total_skor_display">0</div>
                                            <input type="hidden" id="total_skor_nutrisi" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="section-separator">
                        <h5 class="section-title">6. Skala Nyeri</h5>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-4">
                                    <div class="d-flex align-items-center gap-3" style="min-width: 350px;">
                                        <input type="number"
                                            class="form-control flex-grow-1 @error('skala_nyeri') is-invalid @enderror"
                                            name="skala_nyeri" id="skalaNyeriInput" style="width: 100px;"
                                            value="{{ old('skala_nyeri', $asesmenMedis->skala_nyeri ?? 0) }}" min="0" max="10">

                                        <!-- Input Hidden untuk menyimpan tipe skala (Numeric/Wong Baker) -->
                                        <input type="hidden" name="tipe_skala_nyeri" id="tipeSkalaHidden"
                                            value="{{ old('tipe_skala_nyeri', $asesmenMedis->tipe_skala_nyeri ?? 'numeric') }}">

                                        @error('skala_nyeri')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <button type="button" class="btn btn-sm btn-success" id="skalaNyeriBtn">
                                            Tidak Nyeri
                                        </button>
                                    </div>
                                </div>

                                <!-- Debug Info (hapus saat production) -->
                                <div class="mt-2">
                                    <small class="text-muted">
                                        Nilai: <span id="debugNilai">0</span> |
                                        Tipe: <span id="debugTipe">numeric</span>
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Button Controls -->
                                <div class="btn-group mb-3" role="group">
                                    <button type="button" class="btn btn-sm btn-primary" id="numericBtn" data-scale="numeric">
                                        A. Numeric Rating Pain Scale
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="wongBakerBtn" data-scale="wong-baker">
                                        B. Wong Baker Faces Pain Scale
                                    </button>
                                </div>

                                <!-- Pain Scale Images -->
                                <div class="pain-scale-container">
                                    <!-- Numeric Scale Image -->
                                    <div id="numericScale" class="pain-scale-image" style="display: block;">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Numeric Rating Pain Scale</h6>
                                                <img src="{{ asset('assets/img/asesmen/numerik.png') }}"
                                                    alt="Numeric Pain Scale"
                                                    class="img-fluid"
                                                    style="max-width: auto; height: auto;"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                <!-- Fallback jika gambar tidak ditemukan -->
                                                <div style="display: none; padding: 20px;">
                                                    <p><strong>Skala Nyeri Numerik (0-10)</strong></p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span>0</span><span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mt-2">
                                                        <small>Tidak Nyeri</small>
                                                        <small>Nyeri Sedang</small>
                                                        <small>Nyeri Terburuk</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Wong Baker Scale Image -->
                                    <div id="wongBakerScale" class="pain-scale-image" style="display: none;">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Wong Baker Faces Pain Scale</h6>
                                                <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}"
                                                    alt="Wong Baker Pain Scale"
                                                    class="img-fluid"
                                                    style="max-width: auto; height: auto;"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                <!-- Fallback jika gambar tidak ditemukan -->
                                                <div style="display: none; padding: 20px;">
                                                    <p><strong>Wong Baker Faces Pain Rating Scale</strong></p>
                                                    <div class="row">
                                                        <div class="col-2 text-center">
                                                            <div style="font-size: 24px;">😊</div>
                                                            <small>0<br>No Pain</small>
                                                        </div>
                                                        <div class="col-2 text-center">
                                                            <div style="font-size: 24px;">🙂</div>
                                                            <small>2<br>Hurts Little</small>
                                                        </div>
                                                        <div class="col-2 text-center">
                                                            <div style="font-size: 24px;">😐</div>
                                                            <small>4<br>Hurts Little More</small>
                                                        </div>
                                                        <div class="col-2 text-center">
                                                            <div style="font-size: 24px;">😣</div>
                                                            <small>6<br>Hurts Even More</small>
                                                        </div>
                                                        <div class="col-2 text-center">
                                                            <div style="font-size: 24px;">😖</div>
                                                            <small>8<br>Hurts Whole Lot</small>
                                                        </div>
                                                        <div class="col-2 text-center">
                                                            <div style="font-size: 24px;">😭</div>
                                                            <small>10<br>Hurts Worst</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lokasi nyeri -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Lokasi nyeri:</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="lokasi_nyeri" id="lokasi_nyeri"
                                    value="{{ old('lokasi_nyeri', $asesmenMedis->lokasi_nyeri ?? '') }}"
                                    placeholder="Sebutkan lokasi nyeri...">
                            </div>
                        </div>

                        <!-- Jenis nyeri -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Jenis nyeri:</label>
                            <div class="col-sm-10">
                                <div class="d-flex flex-wrap gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jenis_nyeri[]"
                                            id="jenis_nyeri_akut" value="Akut"
                                            {{ (is_array(old('jenis_nyeri', $asesmenMedis->jenis_nyeri ?? [])) && in_array('Akut', old('jenis_nyeri', $asesmenMedis->jenis_nyeri ?? []))) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="jenis_nyeri_akut">Akut</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jenis_nyeri[]"
                                            id="jenis_nyeri_kronik" value="Kronik"
                                            {{ (is_array(old('jenis_nyeri', $asesmenMedis->jenis_nyeri ?? [])) && in_array('Kronik', old('jenis_nyeri', $asesmenMedis->jenis_nyeri ?? []))) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="jenis_nyeri_kronik">Kronik</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Frekuensi nyeri -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Frekuensi nyeri:</label>
                            <div class="col-sm-10">
                                <div class="d-flex flex-wrap gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="frekuensi_nyeri[]"
                                            id="frekuensi_jarang" value="Jarang"
                                            {{ (is_array(old('frekuensi_nyeri', $asesmenMedis->frekuensi_nyeri ?? [])) && in_array('Jarang', old('frekuensi_nyeri', $asesmenMedis->frekuensi_nyeri ?? []))) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="frekuensi_jarang">Jarang</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="frekuensi_nyeri[]"
                                            id="frekuensi_hilang_timbul" value="Hilang timbul"
                                            {{ (is_array(old('frekuensi_nyeri', $asesmenMedis->frekuensi_nyeri ?? [])) && in_array('Hilang timbul', old('frekuensi_nyeri', $asesmenMedis->frekuensi_nyeri ?? []))) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="frekuensi_hilang_timbul">Hilang timbul</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="frekuensi_nyeri[]"
                                            id="frekuensi_terus_menerus" value="Terus menerus"
                                            {{ (is_array(old('frekuensi_nyeri', $asesmenMedis->frekuensi_nyeri ?? [])) && in_array('Terus menerus', old('frekuensi_nyeri', $asesmenMedis->frekuensi_nyeri ?? []))) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="frekuensi_terus_menerus">Terus menerus</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Durasi nyeri:</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="durasi_nyeri" id="durasi_nyeri"
                                    placeholder="Sebutkan Durasi nyeri...">
                            </div>
                        </div>

                        <!-- Menjalar -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Menjalar:</label>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="durasi_nyeri_menjalar"
                                                id="durasi_menjalar_tidak" value="Tidak"
                                                {{ old('durasi_nyeri_menjalar', $asesmenMedis->durasi_nyeri_menjalar ?? '') == 'Tidak' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="durasi_menjalar_tidak">Tidak</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="durasi_nyeri_menjalar"
                                                id="durasi_menjalar_ya" value="Ya"
                                                {{ old('durasi_nyeri_menjalar', $asesmenMedis->durasi_nyeri_menjalar ?? '') == 'Ya' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="durasi_menjalar_ya">Ya, ke:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="durasi_nyeri_lokasi"
                                            id="durasi_nyeri_lokasi" placeholder="Sebutkan lokasi..."
                                            value="{{ old('durasi_nyeri_lokasi', $asesmenMedis->durasi_nyeri_lokasi ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kualitas nyeri -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Kualitas nyeri:</label>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="kualitas_nyeri[]"
                                                id="kualitas_nyeri_tumpul" value="Nyeri tumpul"
                                                {{ (is_array(old('kualitas_nyeri', $asesmenMedis->kualitas_nyeri ?? [])) && in_array('Nyeri tumpul', old('kualitas_nyeri', $asesmenMedis->kualitas_nyeri ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="kualitas_nyeri_tumpul">Nyeri tumpul</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="kualitas_nyeri[]"
                                                id="kualitas_nyeri_tajam" value="Nyeri tajam"
                                                {{ (is_array(old('kualitas_nyeri', $asesmenMedis->kualitas_nyeri ?? [])) && in_array('Nyeri tajam', old('kualitas_nyeri', $asesmenMedis->kualitas_nyeri ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="kualitas_nyeri_tajam">Nyeri tajam</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="kualitas_nyeri[]"
                                                id="kualitas_nyeri_panas" value="Panas/terbakar"
                                                {{ (is_array(old('kualitas_nyeri', $asesmenMedis->kualitas_nyeri ?? [])) && in_array('Panas/terbakar', old('kualitas_nyeri', $asesmenMedis->kualitas_nyeri ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="kualitas_nyeri_panas">Panas/terbakar</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Faktor pemberat -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Faktor pemberat:</label>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="faktor_pemberat[]"
                                                id="faktor_pemberat_cahaya" value="Cahaya"
                                                {{ (is_array(old('faktor_pemberat', $asesmenMedis->faktor_pemberat ?? [])) && in_array('Cahaya', old('faktor_pemberat', $asesmenMedis->faktor_pemberat ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="faktor_pemberat_cahaya">Cahaya</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="faktor_pemberat[]"
                                                id="faktor_pemberat_gelap" value="Gelap"
                                                {{ (is_array(old('faktor_pemberat', $asesmenMedis->faktor_pemberat ?? [])) && in_array('Gelap', old('faktor_pemberat', $asesmenMedis->faktor_pemberat ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="faktor_pemberat_gelap">Gelap</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="faktor_pemberat[]"
                                                id="faktor_pemberat_berbaring" value="Berbaring"
                                                {{ (is_array(old('faktor_pemberat', $asesmenMedis->faktor_pemberat ?? [])) && in_array('Berbaring', old('faktor_pemberat', $asesmenMedis->faktor_pemberat ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="faktor_pemberat_berbaring">Berbaring</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="faktor_pemberat[]"
                                                id="faktor_pemberat_gerakan" value="Gerakan"
                                                {{ (is_array(old('faktor_pemberat', $asesmenMedis->faktor_pemberat ?? [])) && in_array('Gerakan', old('faktor_pemberat', $asesmenMedis->faktor_pemberat ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="faktor_pemberat_gerakan">Gerakan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Faktor peringan -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Faktor peringan:</label>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="faktor_peringan[]"
                                                id="faktor_peringan_cahaya" value="Cahaya"
                                                {{ (is_array(old('faktor_peringan', $asesmenMedis->faktor_peringan ?? [])) && in_array('Cahaya', old('faktor_peringan', $asesmenMedis->faktor_peringan ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="faktor_peringan_cahaya">Cahaya</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="faktor_peringan[]"
                                                id="faktor_peringan_gelap" value="Gelap"
                                                {{ (is_array(old('faktor_peringan', $asesmenMedis->faktor_peringan ?? [])) && in_array('Gelap', old('faktor_peringan', $asesmenMedis->faktor_peringan ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="faktor_peringan_gelap">Gelap</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="faktor_peringan[]"
                                                id="faktor_peringan_sunyii" value="Sunyi"
                                                {{ (is_array(old('faktor_peringan', $asesmenMedis->faktor_peringan ?? [])) && in_array('Sunyi', old('faktor_peringan', $asesmenMedis->faktor_peringan ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="faktor_peringan_sunyii">Sunyi</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="faktor_peringan[]"
                                                id="faktor_peringan_dingin" value="Dingin"
                                                {{ (is_array(old('faktor_peringan', $asesmenMedis->faktor_peringan ?? [])) && in_array('Dingin', old('faktor_peringan', $asesmenMedis->faktor_peringan ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="faktor_peringan_dingin">Dingin</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="faktor_peringan[]"
                                                id="faktor_peringan_lainnya" value="Lainnya"
                                                {{ (is_array(old('faktor_peringan', $asesmenMedis->faktor_peringan ?? [])) && in_array('Lainnya', old('faktor_peringan', $asesmenMedis->faktor_peringan ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="faktor_peringan_lainnya">Lainnya:</label>
                                            <input type="text" class="form-control mt-2" name="faktor_peringan_lainnya_text"
                                                id="faktor_peringan_lainnya_text" placeholder="Sebutkan..."
                                                value="{{ old('faktor_peringan_lainnya_text', $asesmenMedis->faktor_peringan_lainnya_text ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Efek nyeri -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Efek nyeri:</label>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="efek_nyeri[]"
                                                id="efek_nyeri_mual" value="Mual/muntah"
                                                {{ (is_array(old('efek_nyeri', $asesmenMedis->efek_nyeri ?? [])) && in_array('Mual/muntah', old('efek_nyeri', $asesmenMedis->efek_nyeri ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="efek_nyeri_mual">Mual/muntah</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="efek_nyeri[]"
                                                id="efek_nyeri_tidur" value="Tidur"
                                                {{ (is_array(old('efek_nyeri', $asesmenMedis->efek_nyeri ?? [])) && in_array('Tidur', old('efek_nyeri', $asesmenMedis->efek_nyeri ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="efek_nyeri_tidur">Tidur</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="efek_nyeri[]"
                                                id="efek_nyeri_nafsu_makan" value="Nafsu makan"
                                                {{ (is_array(old('efek_nyeri', $asesmenMedis->efek_nyeri ?? [])) && in_array('Nafsu makan', old('efek_nyeri', $asesmenMedis->efek_nyeri ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="efek_nyeri_nafsu_makan">Nafsu makan</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="efek_nyeri[]"
                                                id="efek_nyeri_muntah" value="Muntah"
                                                {{ (is_array(old('efek_nyeri', $asesmenMedis->efek_nyeri ?? [])) && in_array('Muntah', old('efek_nyeri', $asesmenMedis->efek_nyeri ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="efek_nyeri_muntah">Muntah</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="efek_nyeri[]"
                                                id="efek_nyeri_emosi" value="Emosi"
                                                {{ (is_array(old('efek_nyeri', $asesmenMedis->efek_nyeri ?? [])) && in_array('Emosi', old('efek_nyeri', $asesmenMedis->efek_nyeri ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="efek_nyeri_emosi">Emosi</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="efek_nyeri[]"
                                                id="efek_nyeri_lainnya_efek" value="Lainnya"
                                                {{ (is_array(old('efek_nyeri', $asesmenMedis->efek_nyeri ?? [])) && in_array('Lainnya', old('efek_nyeri', $asesmenMedis->efek_nyeri ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="efek_nyeri_lainnya_efek">Lainnya:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="efek_nyeri[]"
                                                id="efek_nyeri_aktivitas" value="Aktivitas"
                                                {{ (is_array(old('efek_nyeri', $asesmenMedis->efek_nyeri ?? [])) && in_array('Aktivitas', old('efek_nyeri', $asesmenMedis->efek_nyeri ?? []))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="efek_nyeri_aktivitas">Aktivitas</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="efek_nyeri_lainnya_text"
                                            id="efek_nyeri_lainnya_text" placeholder="Sebutkan efek lainnya..."
                                            value="{{ old('efek_nyeri_lainnya_text', $asesmenMedis->efek_nyeri_lainnya_text ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Risiko Jatuh -->
                    <div class="section-separator" id="risiko_jatuh">
                        <h5 class="section-title">7. Risiko Jatuh</h5>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Pilih jenis penilaian risiko jatuh sesuai dengan kondisi pasien:</label>
                            <select class="form-select custom-select" id="risikoJatuhSkala" name="resiko_jatuh_jenis" onchange="showForm(this.value)">
                                <option value="">--Pilih Skala--</option>
                                <option value="1">Skala Umum</option>
                                <option value="2">Skala Morse</option>
                                {{-- <option value="3">Skala Humpty-Dumpty / Pediatrik</option> --}}
                                <option value="4">Skala Ontario Modified Stratify Sydney / Lansia</option>
                                <option value="5">Lainnya</option>
                            </select>
                        </div>

                        <!-- Form Skala Umum -->
                        <div id="skala_umumForm" class="risk-form" style="display: none;">
                            <h5 class="mb-4 text-center">Penilaian Risiko Jatuh Skala Umum</h5>

                            <div class="question-card">
                                <div class="question-text">Apakah pasien berusia < dari 2 tahun?</div>
                                <select class="form-select custom-select" name="risiko_jatuh_umum_usia" onchange="updateConclusion('umum')">
                                    <option value="">Pilih jawaban</option>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>

                            <div class="question-card">
                                <div class="question-text">Apakah pasien dalam kondisi sebagai geriatri, dizziness, vertigo, gangguan keseimbangan, gangguan penglihatan, penggunaan obat sedasi, status kesadaran dan atau kejiwaan, konsumsi alkohol?</div>
                                <select class="form-select custom-select" onchange="updateConclusion('umum')" name="risiko_jatuh_umum_kondisi_khusus">
                                    <option value="">Pilih jawaban</option>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>

                            <div class="question-card">
                                <div class="question-text">Apakah pasien didiagnosis sebagai pasien dengan penyakit parkinson?</div>
                                <select class="form-select custom-select" onchange="updateConclusion('umum')" name="risiko_jatuh_umum_diagnosis_parkinson">
                                    <option value="">Pilih jawaban</option>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>

                            <div class="question-card">
                                <div class="question-text">Apakah pasien sedang mendapatkan obat sedasi, riwayat tirah baring lama, perubahan posisi yang akan meningkatkan risiko jatuh?</div>
                                <select class="form-select custom-select" onchange="updateConclusion('umum')" name="risiko_jatuh_umum_pengobatan_berisiko">
                                    <option value="">Pilih jawaban</option>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>

                            <div class="question-card">
                                <div class="question-text">Apakah pasien saat ini sedang berada pada salah satu lokasi ini: rehab medik, ruangan dengan penerangan kurang dan bertangga?</div>
                                <select class="form-select custom-select" onchange="updateConclusion('umum')" name="risiko_jatuh_umum_lokasi_berisiko">
                                    <option value="">Pilih jawaban</option>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>

                            <div class="conclusion alert alert-success">
                                <h6 class="fw-bold mb-2">Kesimpulan Penilaian:</h6>
                                <p class="conclusion-text mb-0 fs-5"><span id="kesimpulanUmum">Tidak berisiko jatuh</span></p>
                                <input type="hidden" name="risiko_jatuh_umum_kesimpulan" id="risiko_jatuh_umum_kesimpulan" value="Tidak berisiko jatuh">
                            </div>
                        </div>

                        <!-- Form Skala Morse -->
                        <div id="skala_morseForm" class="risk-form" style="display: none;">
                            <h5 class="mb-4 text-center">6.A. PENGKAJIAN RESIKO JATUH SKALA MORSE (USIA 19 s.d 59 Tahun)</h5>

                            <div class="factor-card">
                                <div class="factor-title">Riwayat Jatuh</div>
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <select class="form-select custom-select" name="risiko_jatuh_morse_riwayat_jatuh" onchange="updateConclusion('morse')">
                                            <option value="">Pilih kondisi</option>
                                            <option value="0">Tidak (Skor: 0)</option>
                                            <option value="25">Ya (Skor: 25)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="score-badge" id="score_riwayat_jatuh">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="factor-card">
                                <div class="factor-title">Diagnosis Sekunder (> 2 diagnosis)</div>
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <select class="form-select custom-select" name="risiko_jatuh_morse_diagnosis_sekunder" onchange="updateConclusion('morse')">
                                            <option value="">Pilih kondisi</option>
                                            <option value="0">Tidak (Skor: 0)</option>
                                            <option value="15">Ya (Skor: 15)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="score-badge" id="score_diagnosis_sekunder">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="factor-card">
                                <div class="factor-title">Alat Bantu</div>
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <select class="form-select custom-select" name="risiko_jatuh_morse_bantuan_ambulasi" onchange="updateConclusion('morse')">
                                            <option value="">Pilih kondisi</option>
                                            <option value="0">Tidak ada / bedrest / bantuan perawat (Skor: 0)</option>
                                            <option value="15">Kruk / tongkat / alat bantu berjalan (Skor: 15)</option>
                                            <option value="30">Meja / kursi (Skor: 30)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="score-badge" id="score_bantuan_ambulasi">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="factor-card">
                                <div class="factor-title">Terpasang Infus</div>
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <select class="form-select custom-select" name="risiko_jatuh_morse_terpasang_infus" onchange="updateConclusion('morse')">
                                            <option value="">Pilih kondisi</option>
                                            <option value="0">Tidak (Skor: 0)</option>
                                            <option value="20">Ya (Skor: 20)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="score-badge" id="score_terpasang_infus">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="factor-card">
                                <div class="factor-title">Gaya Berjalan</div>
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <select class="form-select custom-select" name="risiko_jatuh_morse_cara_berjalan" onchange="updateConclusion('morse')">
                                            <option value="">Pilih kondisi</option>
                                            <option value="0">Normal / bedrest / kursi roda (Skor: 0)</option>
                                            <option value="10">Lemah (Skor: 10)</option>
                                            <option value="20">Terganggu (Skor: 20)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="score-badge" id="score_cara_berjalan">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="factor-card">
                                <div class="factor-title">Status Mental</div>
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <select class="form-select custom-select" name="risiko_jatuh_morse_status_mental" onchange="updateConclusion('morse')">
                                            <option value="">Pilih kondisi</option>
                                            <option value="0">Berorientasi pada kemampuannya (Skor: 0)</option>
                                            <option value="15">Lupa akan keterbatasannya (Skor: 15)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="score-badge" id="score_status_mental">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="total-score-card">
                                <h4 class="mb-3">TOTAL SKOR</h4>
                                <div class="score-display" id="totalSkorMorse">0</div>
                            </div>

                            <div class="risk-level-cards">
                                <div class="risk-card risk-low" id="resikoRendahMorse">
                                    <div>Resiko Rendah</div>
                                    <div>(0-24)</div>
                                </div>
                                <div class="risk-card risk-medium" id="resikoSedangMorse">
                                    <div>Resiko Sedang</div>
                                    <div>(25-44)</div>
                                </div>
                                <div class="risk-card risk-high" id="resikoTinggiMorse">
                                    <div>Resiko Tinggi</div>
                                    <div>(>45)</div>
                                </div>
                            </div>

                            <div class="conclusion alert alert-success">
                                <h6 class="fw-bold mb-2">Kesimpulan Penilaian:</h6>
                                <p class="conclusion-text mb-0 fs-5"><span id="kesimpulanMorse">Risiko Rendah</span></p>
                                <input type="hidden" name="risiko_jatuh_morse_kesimpulan" id="risiko_jatuh_morse_kesimpulan" value="Risiko Rendah">
                            </div>
                        </div>

                        <!-- Form Skala Ontario -->
                        <div id="skala_ontarioForm" class="risk-form" style="display: none;">
                            <h5 class="mb-4 text-center">6.B. PENGKAJIAN RESIKO JATUH KHUSUS LANSIA/ GERIATRI (Usia > 60 Thn)</h5>

                            <div class="parameter-section">
                                <div class="parameter-title">1. Riwayat Jatuh</div>
                                <div class="sub-question-card">
                                    <div class="question-text">Apakah pasien datang ke rumah sakit karena jatuh?</div>
                                    <select class="form-select custom-select" name="ontario_jatuh_saat_masuk" onchange="updateConclusion('ontario')">
                                        <option value="">Pilih jawaban</option>
                                        <option value="6">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="sub-question-card">
                                    <div class="question-text">Jika tidak, apakah pasien mengalami jatuh dalam 2 bulan terakhir ini?</div>
                                    <select class="form-select custom-select" name="ontario_jatuh_2_bulan" onchange="updateConclusion('ontario')">
                                        <option value="">Pilih jawaban</option>
                                        <option value="6">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="text-muted small">Keterangan: Salah satu jawaban ya = 6</div>
                                <div class="text-end mt-2">
                                    <span class="score-badge" id="skor_riwayat_jatuh">0</span>
                                </div>
                            </div>

                            <div class="parameter-section">
                                <div class="parameter-title">2. Status Mental</div>
                                <div class="sub-question-card">
                                    <div class="question-text">Apakah pasien delirium? (Tidak dapat membuat keputusan, pola pikir tidak terorganisir, gangguan daya ingat)</div>
                                    <select class="form-select custom-select" name="ontario_delirium" onchange="updateConclusion('ontario')">
                                        <option value="">Pilih jawaban</option>
                                        <option value="14">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="sub-question-card">
                                    <div class="question-text">Apakah pasien disorientasi? (salah menyebutkan waktu, tempat atau orang)</div>
                                    <select class="form-select custom-select" name="ontario_disorientasi" onchange="updateConclusion('ontario')">
                                        <option value="">Pilih jawaban</option>
                                        <option value="14">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="sub-question-card">
                                    <div class="question-text">Apakah pasien mengalami agitasi? (keresahan, gelisah, dan cemas)</div>
                                    <select class="form-select custom-select" name="ontario_agitasi" onchange="updateConclusion('ontario')">
                                        <option value="">Pilih jawaban</option>
                                        <option value="14">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="text-muted small">Keterangan: Salah satu jawaban ya = 14</div>
                                <div class="text-end mt-2">
                                    <span class="score-badge" id="skor_status_mental">0</span>
                                </div>
                            </div>

                            <div class="parameter-section">
                                <div class="parameter-title">3. Penglihatan</div>
                                <div class="sub-question-card">
                                    <div class="question-text">Apakah pasien memakai kacamata?</div>
                                    <select class="form-select custom-select" name="ontario_kacamata" onchange="updateConclusion('ontario')">
                                        <option value="">Pilih jawaban</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="sub-question-card">
                                    <div class="question-text">Apakah pasien mengalami adanya penglihatan buram?</div>
                                    <select class="form-select custom-select" name="ontario_penglihatan_buram" onchange="updateConclusion('ontario')">
                                        <option value="">Pilih jawaban</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="sub-question-card">
                                    <div class="question-text">Apakah pasien mempunyai Glaukoma/katarak/degenerasi makula?</div>
                                    <select class="form-select custom-select" name="ontario_glaukoma" onchange="updateConclusion('ontario')">
                                        <option value="">Pilih jawaban</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="text-muted small">Keterangan: Salah satu jawaban ya = 1</div>
                                <div class="text-end mt-2">
                                    <span class="score-badge" id="skor_penglihatan">0</span>
                                </div>
                            </div>

                            <div class="parameter-section">
                                <div class="parameter-title">4. Kebiasaan berkemih</div>
                                <div class="sub-question-card">
                                    <div class="question-text">Apakah terdapat perubahan perilaku berkemih? (frekuensi, urgensi, inkontinensia, noktura)</div>
                                    <select class="form-select custom-select" name="ontario_berkemih" onchange="updateConclusion('ontario')">
                                        <option value="">Pilih jawaban</option>
                                        <option value="2">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="text-muted small">Keterangan: Ya = 2</div>
                                <div class="text-end mt-2">
                                    <span class="score-badge" id="skor_berkemih">0</span>
                                </div>
                            </div>

                            <div class="parameter-section">
                                <div class="parameter-title">5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke tempat tidur)</div>
                                <div class="sub-question-card">
                                    <div class="question-text">Kemampuan Transfer Pasien:</div>
                                    <select class="form-select custom-select" name="ontario_transfer" onchange="updateConclusion('ontario')">
                                        <option value="">Pilih kondisi</option>
                                        <option value="0">Mandiri (boleh memakai alat bantu jalan)</option>
                                        <option value="1">Memerlukan sedikit bantuan (1 orang) / dalam pengawasan</option>
                                        <option value="2">Memerlukan bantuan yang nyata (2 orang)</option>
                                        <option value="3">Tidak dapat duduk dengan seimbang, perlu bantuan total</option>
                                    </select>
                                </div>
                                <div class="text-muted small">
                                    <div>0 = Mandiri</div>
                                    <div>1 = Bantuan 1 orang</div>
                                    <div>2 = Bantuan 2 orang</div>
                                    <div>3 = Bantuan total</div>
                                </div>
                            </div>

                            <div class="parameter-section">
                                <div class="parameter-title">6. Mobilitas</div>
                                <div class="sub-question-card">
                                    <div class="question-text">Kemampuan Mobilitas Pasien:</div>
                                    <select class="form-select custom-select" name="ontario_mobilitas" onchange="updateConclusion('ontario')">
                                        <option value="">Pilih kondisi</option>
                                        <option value="0">Mandiri (boleh menggunakan alat bantu jalan)</option>
                                        <option value="1">Berjalan dengan bantuan 1 orang (verbal/fisik)</option>
                                        <option value="2">Menggunakan kursi roda</option>
                                        <option value="3">Imobilisasi</option>
                                    </select>
                                </div>
                                <div class="text-muted small">
                                    <div>0 = Mandiri</div>
                                    <div>1 = Bantuan 1 orang</div>
                                    <div>2 = Kursi roda</div>
                                    <div>3 = Imobilisasi</div>
                                    <div class="mt-2 fw-bold">Jumlah nilai transfer dan mobilitas:</div>
                                    <div>Jika nilai total 0 s/d 6, maka skor = 0</div>
                                    <div>Jika nilai > 6, maka skor = 3</div>
                                </div>
                                <div class="text-end mt-2">
                                    <span class="score-badge" id="skor_transfer_mobilitas">0</span>
                                </div>
                            </div>

                            <div class="total-score-card">
                                <h4 class="mb-3">TOTAL SKOR</h4>
                                <div class="score-display" id="totalSkorOntario">0</div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center mb-3">
                                        <strong>Keterangan skor:</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="risk-level-cards">
                                <div class="risk-card risk-low" id="resikoRendahOntario">
                                    <div>Resiko Rendah</div>
                                    <div>(0-5)</div>
                                </div>
                                <div class="risk-card risk-medium" id="resikoSedangOntario">
                                    <div>Resiko Sedang</div>
                                    <div>(6-16)</div>
                                </div>
                                <div class="risk-card risk-high" id="resikoTinggiOntario">
                                    <div>Resiko Tinggi</div>
                                    <div>(17-30)</div>
                                </div>
                            </div>

                            <div class="conclusion alert alert-success">
                                <h6 class="fw-bold mb-2">Kesimpulan Penilaian:</h6>
                                <p class="conclusion-text mb-0 fs-5"><span id="kesimpulanOntario">Risiko Rendah</span></p>
                                <input type="hidden" name="risiko_jatuh_lansia_kesimpulan" id="risiko_jatuh_lansia_kesimpulan" value="Risiko Rendah">
                            </div>
                        </div>
                    </div>

                    <!-- Risiko Decubitus -->
                    <div class="section-separator" id="risiko_decubitus">
                        <h5 class="section-title">8. PENGKAJIAN RISIKO DECUBITUS (SKALA NORTON)</h5>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Pilih jenis penilaian risiko decubitus:</label>
                            <select class="form-select custom-select" id="risikoDecubitusSkala" name="resiko_decubitus_jenis" onchange="showDecubitusForm(this.value)">
                                <option value="">--Pilih Skala--</option>
                                <option value="norton">Skala Norton</option>
                            </select>
                        </div>

                        <!-- Form Skala Norton -->
                        <div id="skala_nortonForm" class="risk-form" style="display: none;">
                            <h5 class="mb-4 text-center">8. PENGKAJIAN RISIKO DECUBITUS (SKALA NORTON)</h5>

                            <div class="factor-card">
                                <div class="factor-title">Kondisi Fisik</div>
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <select class="form-select custom-select" name="norton_kondisi_fisik" onchange="updateConclusion('norton')">
                                            <option value="">Pilih kondisi</option>
                                            <option value="4">Baik (Skor: 4)</option>
                                            <option value="3">Cukup (Skor: 3)</option>
                                            <option value="2">Buruk (Skor: 2)</option>
                                            <option value="1">Sangat buruk (Skor: 1)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="score-badge" id="skor_kondisi_fisik">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="factor-card">
                                <div class="factor-title">Kondisi Mental</div>
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <select class="form-select custom-select" name="norton_kondisi_mental" onchange="updateConclusion('norton')">
                                            <option value="">Pilih kondisi</option>
                                            <option value="4">Compos mentis (Skor: 4)</option>
                                            <option value="3">Apatis (Skor: 3)</option>
                                            <option value="2">Delirium (Skor: 2)</option>
                                            <option value="1">Stupor (Skor: 1)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="score-badge" id="skor_kondisi_mental">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="factor-card">
                                <div class="factor-title">Aktivitas</div>
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <select class="form-select custom-select" name="norton_aktivitas" onchange="updateConclusion('norton')">
                                            <option value="">Pilih kondisi</option>
                                            <option value="4">Mandiri (Skor: 4)</option>
                                            <option value="3">Dipapah (Skor: 3)</option>
                                            <option value="2">Kursi roda (Skor: 2)</option>
                                            <option value="1">Tirah baring (Skor: 1)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="score-badge" id="skor_aktivitas">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="factor-card">
                                <div class="factor-title">Mobilitas</div>
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <select class="form-select custom-select" name="norton_mobilitas" onchange="updateConclusion('norton')">
                                            <option value="">Pilih kondisi</option>
                                            <option value="4">Baik (Skor: 4)</option>
                                            <option value="3">Agak terbatas (Skor: 3)</option>
                                            <option value="2">Sangat terbatas (Skor: 2)</option>
                                            <option value="1">Immobilisasi (Skor: 1)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="score-badge" id="skor_mobilitas">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="factor-card">
                                <div class="factor-title">Inkontinensia</div>
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <select class="form-select custom-select" name="norton_inkontinensia" onchange="updateConclusion('norton')">
                                            <option value="">Pilih kondisi</option>
                                            <option value="4">Tidak (Skor: 4)</option>
                                            <option value="3">Terkadang (Skor: 3)</option>
                                            <option value="2">Sering (Skor: 2)</option>
                                            <option value="1">Selalu (Skor: 1)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="score-badge" id="skor_inkontinensia">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="total-score-card">
                                <h4 class="mb-3">TOTAL SKOR</h4>
                                <div class="score-display" id="totalSkorNorton">0</div>
                            </div>

                            <div class="risk-level-cards">
                                <div class="risk-card risk-low" id="resikoRendahNorton">
                                    <div>Resiko Rendah</div>
                                    <div>(16-20)</div>
                                </div>
                                <div class="risk-card risk-medium" id="resikoSedangNorton">
                                    <div>Resiko Sedang</div>
                                    <div>(12-15)</div>
                                </div>
                                <div class="risk-card risk-high" id="resikoTinggiNorton">
                                    <div>Resiko Tinggi</div>
                                    <div>(&lt; 12)</div>
                                </div>
                            </div>

                            <div class="conclusion alert alert-success">
                                <h6 class="fw-bold mb-2">Kesimpulan Penilaian:</h6>
                                <p class="conclusion-text mb-0 fs-5"><span id="kesimpulanNorton">Risiko Rendah</span></p>
                                <input type="hidden" name="risiko_norton_kesimpulan" id="risiko_norton_kesimpulan" value="Risiko Rendah">
                            </div>
                        </div>
                    </div>

                    <!-- Aktivitas Harian -->
                    <div class="section-separator" id="aktivitas_harian">
                        <h5 class="section-title">9. PENGKAJIAN AKTIVITAS HARIAN (ADL)</h5>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Pilih penilaian aktivitas harian:</label>
                            <select class="form-select custom-select" id="aktivitasHarianSkala" name="aktivitas_harian_jenis" onchange="showADLForm(this.value)">
                                <option value="">--Pilih Skala--</option>
                                <option value="adl">Pengkajian ADL</option>
                            </select>
                        </div>

                        <!-- Form ADL -->
                        <div id="skala_adlForm" class="risk-form" style="display: none;">
                            <h5 class="mb-4 text-center">9. PENGKAJIAN AKTIVITAS HARIAN (ADL)</h5>

                            <div class="factor-card">
                                <div class="factor-title">Makan / Memakai baju</div>
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <select class="form-select custom-select" name="adl_makan" onchange="updateConclusion('adl')">
                                            <option value="">Pilih kondisi</option>
                                            <option value="0">Mandiri (Skor: 0)</option>
                                            <option value="1">25% Dibantu (Skor: 1)</option>
                                            <option value="2">50% Dibantu (Skor: 2)</option>
                                            <option value="3">75% Dibantu (Skor: 3)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="score-badge" id="skor_makan">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="factor-card">
                                <div class="factor-title">Berjalan</div>
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <select class="form-select custom-select" name="adl_berjalan" onchange="updateConclusion('adl')">
                                            <option value="">Pilih kondisi</option>
                                            <option value="0">Mandiri (Skor: 0)</option>
                                            <option value="1">25% Dibantu (Skor: 1)</option>
                                            <option value="2">50% Dibantu (Skor: 2)</option>
                                            <option value="3">75% Dibantu (Skor: 3)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="score-badge" id="skor_berjalan">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="factor-card">
                                <div class="factor-title">Mandi / buang air</div>
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <select class="form-select custom-select" name="adl_mandi" onchange="updateConclusion('adl')">
                                            <option value="">Pilih kondisi</option>
                                            <option value="0">Mandiri (Skor: 0)</option>
                                            <option value="1">25% Dibantu (Skor: 1)</option>
                                            <option value="2">50% Dibantu (Skor: 2)</option>
                                            <option value="3">75% Dibantu (Skor: 3)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="score-badge" id="skor_mandi">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="total-score-card">
                                <h4 class="mb-3">TOTAL SKOR</h4>
                                <div class="score-display" id="totalSkorADL">0</div>
                            </div>

                            <div class="conclusion alert alert-success">
                                <h6 class="fw-bold mb-2">Kesimpulan Penilaian:</h6>
                                <p class="conclusion-text mb-0 fs-5"><span id="kesimpulanADL">Mandiri (Skor: 0)</span></p>
                                <input type="hidden" name="adl_kesimpulan" id="adl_kesimpulan" value="Mandiri">
                            </div>
                        </div>
                    </div>

                    <!-- PENGKAJIAN EDUKASI/ PENDIDIKAN DAN PENGAJARAN -->
                    <div class="section-separator" id="pengkajian_edukasi">
                        <h5 class="section-title">10. PENGKAJIAN EDUKASI/ PENDIDIKAN DAN PENGAJARAN</h5>

                        <!-- Bicara -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Bicara:</label>
                            <div class="col-sm-10">
                                <div class="d-flex flex-wrap gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="bicara[]" id="bicara_normal" value="normal">
                                        <label class="form-check-label" for="bicara_normal">Normal</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="bicara[]" id="bicara_tidak_normal" value="tidak_normal">
                                        <label class="form-check-label" for="bicara_tidak_normal">Tidak normal</label>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <input type="text" class="form-control" name="bicara_lainnya" placeholder="Lainnya, sebutkan...">
                                </div>
                            </div>
                        </div>

                        <!-- Bahasa sehari-hari -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Bahasa sehari-hari:</label>
                            <div class="col-sm-10">
                                <div class="d-flex flex-wrap gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="bahasa_sehari[]" id="bahasa_sehari_indonesia" value="indonesia">
                                        <label class="form-check-label" for="bahasa_sehari_indonesia">Indonesia (aktif/ pasif)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="bahasa_sehari[]" id="bahasa_sehari_daerah" value="daerah">
                                        <label class="form-check-label" for="bahasa_sehari_daerah">Daerah</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="bahasa_sehari[]" id="bahasa_sehari_asing" value="asing">
                                        <label class="form-check-label" for="bahasa_sehari_asing">Bahasa asing</label>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <input type="text" class="form-control" name="bahasa_sehari_lainnya" placeholder="Sebutkan bahasa lainnya...">
                                </div>
                            </div>
                        </div>

                        <!-- Perlu penerjemah -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Perlu penerjemah:</label>
                            <div class="col-sm-10">
                                <div class="d-flex flex-wrap gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="penerjemah[]" id="tidak_perlu_penerjemah" value="tidak">
                                        <label class="form-check-label" for="tidak_perlu_penerjemah">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="penerjemah[]" id="perlu_penerjemah_ya" value="ya">
                                        <label class="form-check-label" for="perlu_penerjemah_ya">Ya, bahasa</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="penerjemah[]" id="perlu_penerjemah_bahasa_isyarat" value="bahasa_isyarat">
                                        <label class="form-check-label" for="perlu_penerjemah_bahasa_isyarat">Bahasa isyarat</label>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <input type="text" class="form-control" name="penerjemah_bahasa" placeholder="Bahasa...">
                                </div>
                            </div>
                        </div>

                        <!-- Hambatan komunikasi/ belajar -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Hambatan komunikasi/ belajar:</label>
                            <div class="col-sm-10">
                                <div class="d-flex flex-wrap gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hambatan[]" id="belajar_bahasa_hambatan" value="bahasa">
                                        <label class="form-check-label" for="belajar_bahasa_hambatan">Bahasa</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hambatan[]" id="belajar_menulis" value="menulis">
                                        <label class="form-check-label" for="belajar_menulis">Menulis</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hambatan[]" id="belajar_cemas" value="cemas">
                                        <label class="form-check-label" for="belajar_cemas">Cemas</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="hambatan[]" id="belajar_lain_hambatan" value="lain">
                                        <label class="form-check-label" for="belajar_lain_hambatan">lain-lain</label>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <input type="text" class="form-control" name="hambatan_lainnya" placeholder="Sebutkan hambatan lainnya...">
                                </div>
                            </div>
                        </div>

                        <!-- Cara komunikasi yang disukai -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Cara komunikasi yang disukai:</label>
                            <div class="col-sm-10">
                                <div class="d-flex flex-wrap gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cara_komunikasi[]" id="komunikasi_audio_visual" value="audio_visual">
                                        <label class="form-check-label" for="komunikasi_audio_visual">Audio-visual/ gambar</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cara_komunikasi[]" id="komunikasi_diskusi" value="diskusi">
                                        <label class="form-check-label" for="komunikasi_diskusi">Diskusi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cara_komunikasi[]" id="komunikasi_lain_komunikasi" value="lain">
                                        <label class="form-check-label" for="komunikasi_lain_komunikasi">Lain-lain</label>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <input type="text" class="form-control" name="cara_komunikasi_lainnya" placeholder="Sebutkan cara komunikasi lainnya...">
                                </div>
                            </div>
                        </div>

                        <!-- Tingkat pendidikan -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Tingkat pendidikan:</label>
                            <div class="col-sm-10">
                                <div class="d-flex flex-wrap gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="pendidikan[]" id="pendidikan_tk" value="tk">
                                        <label class="form-check-label" for="pendidikan_tk">TK</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="pendidikan[]" id="pendidikan_sd" value="sd">
                                        <label class="form-check-label" for="pendidikan_sd">SD</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="pendidikan[]" id="pendidikan_smp" value="smp">
                                        <label class="form-check-label" for="pendidikan_smp">SMP</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="pendidikan[]" id="pendidikan_smu" value="smu">
                                        <label class="form-check-label" for="pendidikan_smu">SMU</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="pendidikan[]" id="pendidikan_akademi" value="akademi">
                                        <label class="form-check-label" for="pendidikan_akademi">Akademi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="pendidikan[]" id="pendidikan_sarjana" value="sarjana">
                                        <label class="form-check-label" for="pendidikan_sarjana">Sarjana</label>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <input type="text" class="form-control" name="pendidikan_detail" placeholder="( S-1 / S-2 / S-3 )">
                                </div>
                            </div>
                        </div>

                        <!-- Potensi kebutuhan pembelajaran -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Potensi kebutuhan pembelajaran:</label>
                            <div class="col-sm-10">
                                <div class="d-flex flex-wrap gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="potensi_pembelajaran[]" id="potensi_proses_penyakit" value="proses_penyakit">
                                        <label class="form-check-label" for="potensi_proses_penyakit">Proses penyakit</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="potensi_pembelajaran[]" id="potensi_pengobatan_tindakan" value="pengobatan_tindakan">
                                        <label class="form-check-label" for="potensi_pengobatan_tindakan">Pengobatan/tindakan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="potensi_pembelajaran[]" id="potensi_terapi_obat" value="terapi_obat">
                                        <label class="form-check-label" for="potensi_terapi_obat">Terapi/obat</label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="potensi_pembelajaran[]" id="potensi_nutrisi" value="nutrisi">
                                            <label class="form-check-label" for="potensi_nutrisi">Nutrisi</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="potensi_pembelajaran[]" id="lain_pembelajaran" value="lain">
                                            <label class="form-check-label" for="lain_pembelajaran">Lain-lain</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <input type="text" class="form-control" name="potensi_pembelajaran_lainnya" placeholder="Sebutkan lainnya...">
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Khusus -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Catatan Khusus:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="catatan_khusus" rows="4" placeholder="Tulis catatan khusus di sini..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Perencanaan Pulang Pasien (Discharge Planning) -->
                    <div class="section-separator" id="discharge-planning">
                        <h5 class="section-title">11. Perencanaan Pulang Pasien (Discharge Planning)</h5>

                        <div class="mb-4">
                            <label class="form-label">Diagnosis medis</label>
                            <input type="text" class="form-control" name="diagnosis_medis" placeholder="Diagnosis">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Usia lanjut (>60 th)</label>
                            <select class="form-select" name="usia_lanjut">
                                <option value="" selected disabled>--Pilih--</option>
                                <option value="0">Ya</option>
                                <option value="1">Tidak</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Hambatan mobilitas</label>
                            <select class="form-select" name="hambatan_mobilisasi">
                                <option value="" selected disabled>--Pilih--</option>
                                <option value="0">Ya</option>
                                <option value="1">Tidak</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Membutuhkan pelayanan medis berkelanjutan</label>
                            <select class="form-select" name="penggunaan_media_berkelanjutan">
                                <option value="" selected disabled>--Pilih--</option>
                                <option value="ya">Ya</option>
                                <option value="tidak">Tidak</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Keteraturan dalam mengonsumsi obat dalam aktivitas
                                harian</label>
                            <select class="form-select" name="ketergantungan_aktivitas">
                                <option value="" selected disabled>--Pilih--</option>
                                <option value="ya">Ya</option>
                                <option value="tidak">Tidak</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Rencana Pulang Khusus</label>
                            <input type="text" class="form-control" name="rencana_pulang_khusus"
                                placeholder="Rencana Pulang Khusus">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Rencana Lama Perawatan</label>
                            <input type="text" class="form-control" name="rencana_lama_perawatan"
                                placeholder="Rencana Lama Perawatan">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Rencana Tanggal Pulang</label>
                            <input type="date" class="form-control" name="rencana_tgl_pulang">
                        </div>

                        <div class="mt-4">
                            <label class="form-label">KESIMPULAN</label>
                            <div class="d-flex flex-column gap-2">
                                <div class="alert alert-info d-none">
                                    <!-- Alasan akan ditampilkan di sini -->
                                </div>
                                <div class="alert alert-warning d-none">
                                    Membutuhkan rencana pulang khusus
                                </div>
                                <div class="alert alert-success">
                                    Tidak membutuhkan rencana pulang khusus
                                </div>
                            </div>
                            <input type="hidden" id="kesimpulan" name="kesimpulan_planing"
                                value="Tidak membutuhkan rencana pulang khusus">
                        </div>

                    </div>

                    <!-- Diet Khusus -->
                    <div class="section-separator" id="diet_khusus">
                        <h5 class="section-title">12. Diet Khusus</h5>
                        <div class="mb-4">
                            <label class="form-label">Diet Khusus:</label>
                            <input type="text" class="form-control" name="diet_khusus" placeholder="Diet Khusus">
                        </div>

                        <!-- Ada pengaruh perawatan terhadap -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Ada pengaruh perawatan terhadap:</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pengaruh_perawatan[]" id="pasien_keluarga" value="pasien_keluarga">
                                            <label class="form-check-label" for="pasien_keluarga">1. Pasien/ Keluarga</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="pengaruh_ya_tidak_1" id="pengaruh_ya_1" value="ya">
                                                <label class="form-check-label" for="pengaruh_ya_1">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="pengaruh_ya_tidak_1" id="pengaruh_tidak_1" value="tidak">
                                                <label class="form-check-label" for="pengaruh_tidak_1">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pengaruh_perawatan[]" id="pelayanan" value="pelayanan">
                                            <label class="form-check-label" for="pelayanan">2. Pelayanan</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="pengaruh_ya_tidak_2" id="pengaruh_ya_2" value="ya">
                                                <label class="form-check-label" for="pengaruh_ya_2">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="pengaruh_ya_tidak_2" id="pengaruh_tidak_2" value="tidak">
                                                <label class="form-check-label" for="pengaruh_tidak_2">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pengaruh_perawatan[]" id="keuangan" value="keuangan">
                                            <label class="form-check-label" for="keuangan">3. Keuangan</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="pengaruh_ya_tidak_3" id="pengaruh_ya_3" value="ya">
                                                <label class="form-check-label" for="pengaruh_ya_3">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="pengaruh_ya_tidak_3" id="pengaruh_tidak_3" value="tidak">
                                                <label class="form-check-label" for="pengaruh_tidak_3">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Apakah pasien hidup/tinggal sendiri -->
                        <div class="row mb-3">
                            <label class="col-sm-6 col-form-label">Apakah pasien hidup/tinggal sendiri setelah keluar dari rumah sakit?</label>
                            <div class="col-sm-6">
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="hidup_sendiri" id="hidup_ya" value="ya">
                                        <label class="form-check-label" for="hidup_ya">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="hidup_sendiri" id="hidup_tidak" value="tidak">
                                        <label class="form-check-label" for="hidup_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Antisipasi terhadap masalah saat pulang -->
                        <div class="row mb-3">
                            <label class="col-sm-6 col-form-label">Antisipasi terhadap masalah saat pulang:</label>
                            <div class="col-sm-6">
                                <div class="d-flex gap-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="antisipasi_masalah" id="antisipasi_tidak" value="tidak">
                                        <label class="form-check-label" for="antisipasi_tidak">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="antisipasi_masalah" id="antisipasi_ya" value="ya">
                                        <label class="form-check-label" for="antisipasi_ya">Ya</label>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="antisipasi_jelaskan" placeholder="Jelaskan:">
                            </div>
                        </div>

                        <!-- Memerlukan bantuan dalam hal -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Memerlukan bantuan dalam hal:</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="bantuan_hal[]" id="makan_minum" value="makan_minum">
                                            <label class="form-check-label" for="makan_minum">Makan/ minum</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="bantuan_hal[]" id="konsumsi_obat" value="konsumsi_obat">
                                            <label class="form-check-label" for="konsumsi_obat">Konsumsi obat</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="bantuan_hal[]" id="berpakaian" value="berpakaian">
                                            <label class="form-check-label" for="berpakaian">Berpakaian</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="bantuan_hal[]" id="perawatan_luka" value="perawatan_luka">
                                            <label class="form-check-label" for="perawatan_luka">Perawatan luka</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="bantuan_hal[]" id="mandi_berpakaian" value="mandi_berpakaian">
                                            <label class="form-check-label" for="mandi_berpakaian">Mandi & Berpakaian</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="bantuan_hal[]" id="menyiapkan_makanan" value="menyiapkan_makanan">
                                            <label class="form-check-label" for="menyiapkan_makanan">Menyiapkan makanan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="bantuan_hal[]" id="edukasi_kesehatan" value="edukasi_kesehatan">
                                            <label class="form-check-label" for="edukasi_kesehatan">Edukasi Kesehatan</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="bantuan_hal[]" id="lainnya_bantuan" value="lainnya">
                                            <label class="form-check-label" for="lainnya_bantuan">Lainnya</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <input type="text" class="form-control" name="bantuan_lainnya" placeholder="Jelaskan lainnya...">
                                </div>
                            </div>
                        </div>

                        <!-- Apakah pasien menggunakan peralatan medis -->
                        <div class="row mb-3">
                            <label class="col-sm-6 col-form-label">Apakah pasien menggunakan peralatan medis di rumah setelah keluar rumah sakit (Kateter, NGT, Double lumen, Oksigen dll)?</label>
                            <div class="col-sm-6">
                                <div class="d-flex gap-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="peralatan_medis" id="peralatan_tidak" value="tidak">
                                        <label class="form-check-label" for="peralatan_tidak">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="peralatan_medis" id="peralatan_ya" value="ya">
                                        <label class="form-check-label" for="peralatan_ya">Ya</label>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="peralatan_jelaskan" placeholder="Jelaskan:">
                            </div>
                        </div>

                        <!-- Apakah pasien memerlukan alat bantu -->
                        <div class="row mb-3">
                            <label class="col-sm-6 col-form-label">Apakah pasien memerlukan alat bantu setelah keluar rumah sakit (ex: kursi roda, tongkat, walker dll)?</label>
                            <div class="col-sm-6">
                                <div class="d-flex gap-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="alat_bantu" id="alat_bantu_tidak" value="tidak">
                                        <label class="form-check-label" for="alat_bantu_tidak">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="alat_bantu" id="alat_bantu_ya" value="ya">
                                        <label class="form-check-label" for="alat_bantu_ya">Ya</label>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="alat_bantu_jelaskan" placeholder="Jelaskan:">
                            </div>
                        </div>

                        <!-- Apakah pasien memerlukan bantuan perawatan khusus -->
                        <div class="row mb-3">
                            <label class="col-sm-6 col-form-label">Apakah memerlukan bantuan /perawatan khusus di rumah setelah keluar rumah sakit (homecare, home visit)?</label>
                            <div class="col-sm-6">
                                <div class="d-flex gap-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="perawatan_khusus" id="perawatan_khusus_tidak" value="tidak">
                                        <label class="form-check-label" for="perawatan_khusus_tidak">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="perawatan_khusus" id="perawatan_khusus_ya" value="ya">
                                        <label class="form-check-label" for="perawatan_khusus_ya">Ya</label>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="perawatan_khusus_jelaskan" placeholder="Jelaskan:">
                            </div>
                        </div>

                        <!-- Apakah pasien memiliki nyeri kronis -->
                        <div class="row mb-3">
                            <label class="col-sm-6 col-form-label">Apakah pasien memiliki nyeri kronis dan kelelahan setelah keluar dari rumah sakit?</label>
                            <div class="col-sm-6">
                                <div class="d-flex gap-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="nyeri_kronis" id="nyeri_kronis_tidak" value="tidak">
                                        <label class="form-check-label" for="nyeri_kronis_tidak">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="nyeri_kronis" id="nyeri_kronis_ya" value="ya">
                                        <label class="form-check-label" for="nyeri_kronis_ya">Ya</label>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="nyeri_kronis_jelaskan" placeholder="Jelaskan:">
                            </div>
                        </div>

                        <!-- Apakah pasien/ keluarga memerlukan keterampilan khusus -->
                        <div class="row mb-3">
                            <label class="col-sm-6 col-form-label">Apakah pasien/ keluarga memerlukan keterampilan khusus setelah keluar dari rumah sakit (perawatan luka, injeksi, perawatan bayi, dll)?</label>
                            <div class="col-sm-6">
                                <div class="d-flex gap-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="keterampilan_khusus" id="keterampilan_tidak" value="tidak">
                                        <label class="form-check-label" for="keterampilan_tidak">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="keterampilan_khusus" id="keterampilan_ya" value="ya">
                                        <label class="form-check-label" for="keterampilan_ya">Ya</label>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="keterampilan_jelaskan" placeholder="Jelaskan:">
                            </div>
                        </div>

                        <!-- Apakah pasien perlu dirujuk ke komunitas -->
                        <div class="row mb-3">
                            <label class="col-sm-6 col-form-label">Apakah pasien perlu dirujuk ke komunitas?</label>
                            <div class="col-sm-6">
                                <div class="d-flex gap-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="dirujuk_komunitas" id="dirujuk_tidak" value="tidak">
                                        <label class="form-check-label" for="dirujuk_tidak">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="dirujuk_komunitas" id="dirujuk_ya" value="ya">
                                        <label class="form-check-label" for="dirujuk_ya">Ya</label>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="dirujuk_jelaskan" placeholder="Jelaskan:">
                            </div>
                        </div>

                        <!-- Catatan Khusus -->
                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label">CATATAN KHUSUS:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="catatan_khusus_diet" rows="4" placeholder="Tulis catatan khusus di sini..."></textarea>
                            </div>
                        </div>

                    </div>

                    <!-- MASALAH/ DIAGNOSIS KEPERAWATAN  -->
                    <div class="section-separator" id="masalah_diagnosis">
                        <h5 class="section-title">13. MASALAH/ DIAGNOSIS KEPERAWATAN</h5>
                        <p class="text-muted mb-4">(Diisi berdasarkan hasil asesmen dan berurut sesuai masalah yang dominan terlebih dahulu)</p>

                        <!-- Diagnosis Keperawatan Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="50%">DIAGNOSA KEPERAWATAN</th>
                                        <th width="50%">RENCANA KEPERAWATAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- 1. Bersihan Jalan Nafas Tidak Efektif -->
                                    <tr>
                                        <td class="align-top">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input rencana-perawatan-row-1" type="checkbox" name="diagnosis[]" value="bersihan_jalan_nafas" id="diag_bersihan_jalan_nafas">
                                                <label class="form-check-label" for="diag_bersihan_jalan_nafas">
                                                    <strong>Bersihan jalan nafas tidak efektif</strong> berhubungan dengan spasme jalan nafas, hipersekresi jalan nafas,adanya benda asing pada jalan nafas, secret tertahan di saluran nafas, proses infeksi.
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input rencana-perawatan-row-1" type="checkbox" name="diagnosis[]" value="risiko_aspirasi" id="diag_risiko_aspirasi">
                                                <label class="form-check-label" for="diag_risiko_aspirasi">
                                                    <strong>Risiko aspirasi</strong>  berhubungan dengan tingkat kesadaran, penurunan reflek muntah dan/ atau batuk, gangguan menelan, terpasang slang nasogastrik, dan ketidak matangan koordinasi menghisap,menelan dan bernafas.
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input rencana-perawatan-row-1" type="checkbox" name="diagnosis[]" value="pola_nafas_tidak_efektif" id="diag_pola_nafas_tidak_efektif">
                                                <label class="form-check-label" for="diag_pola_nafas_tidak_efektif">
                                                    <strong>Pola nafas tidak efekti</strong>  berhubungan dengan depresi pusat pernafasan, hambatan upaya nafas, deformitas tulang dada, posisi tubuh yang menghambat ekspansi paru, kecemasan.
                                                </label>
                                            </div>
                                        </td>
                                        <td class="align-top">
                                            <div id="rencana_bersihan_jalan_nafas" style="display: none;">
                                                <strong>Observasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_pola_nafas">
                                                    <label class="form-check-label">Monitor pola nafas ( frekuensi , kedalaman, usaha nafas )</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_bunyi_nafas">
                                                    <label class="form-check-label">Monitor bunyi nafas tambahan ( mengi, wheezing, rhonchi )</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_sputum">
                                                    <label class="form-check-label">Monitor sputum ( jumlah, warna, aroma )</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_tingkat_kesadaran">
                                                    <label class="form-check-label">Monitor tingkat kesadaran, batuk, muntah dan kemampuan menelan</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_kemampuan_batuk">
                                                    <label class="form-check-label">Monitor kemampuan batuk efektif</label>
                                                </div>

                                                <strong>Terapeutik:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="pertahankan_kepatenan">
                                                    <label class="form-check-label">Pertahankan kepatenan jalan nafas dengan head-tilt dan chin -lift ( jaw – thrust jika curiga trauma servikal ) </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="posisikan_semi_fowler">
                                                    <label class="form-check-label">Posisikan semi fowler atau fowler</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="berikan_minum_hangat">
                                                    <label class="form-check-label">Berikan minum hangat</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="fisioterapi_dada">
                                                    <label class="form-check-label">Lakukan fisioterapi dada, jika perlu</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="keluarkan_benda_padat">
                                                    <label class="form-check-label">Keluarkan benda padat dengan forcep</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="penghisapan_lendir">
                                                    <label class="form-check-label">Lakukan penghisapan lendir</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="berikan_oksigen">
                                                    <label class="form-check-label">Berikan oksigen</label>
                                                </div>

                                                <strong>Edukasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="anjuran_asupan_cairan">
                                                    <label class="form-check-label">Anjuran asupan cairan 2000 ml/hari, jika tidak kontra indikasi</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="ajarkan_teknik_batuk">
                                                    <label class="form-check-label">Ajarkan teknik batuk efektif</label>
                                                </div>

                                                <strong>Kolaborasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="kolaborasi_pemberian_obat">
                                                    <label class="form-check-label">Kolaborasi pemberian bronkodilator, ekspektoran, mukolitik, jika perlu</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 2. Penurunan Curah Jantung -->
                                    <tr>
                                        <td class="align-top">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="diagnosis[]" value="penurunan_curah_jantung" id="diag_penurunan_curah_jantung" onchange="toggleRencana('penurunan_curah_jantung')">
                                                <label class="form-check-label" for="diag_penurunan_curah_jantung">
                                                    <strong>Penurunan curah jantung</strong> berhubungan dengan perubahan irama jantung, perubahan frekuensi jantung.
                                                </label>
                                            </div>
                                        </td>
                                        <td class="align-top">
                                            <div id="rencana_penurunan_curah_jantung" style="display: none;">
                                                <strong>Observasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="identifikasi_tanda_gejala">
                                                    <label class="form-check-label">Identifikasi tanda/gejala primer penurunan curah jantung (meliputi dipsnea, kelelahan, edema)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_tekanan_darah">
                                                    <label class="form-check-label">Monitor tekanan darah</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_intake_output">
                                                    <label class="form-check-label">Monitor intake dan output cairan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_saturasi_oksigen">
                                                    <label class="form-check-label">Monitor saturasi oksigen</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_keluhan_nyeri">
                                                    <label class="form-check-label">Monitor keluhan nyeri dada (intensitas, lokasi, durasi, presivitasi yang mengurangi nyeri)</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_aritmia">
                                                    <label class="form-check-label">Monitor aritmia (kelainan irama dan frekuensi)</label>
                                                </div>

                                                <strong>Terapeutik:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="posisikan_pasien">
                                                    <label class="form-check-label">Posisikan pasien semi fowler atau fowler dengan kaki kebawah atau posisi nyaman</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="berikan_terapi_relaksasi">
                                                    <label class="form-check-label">Berikan therapi relaksasi untuk mengurangi stres, jika perlu</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="berikan_dukungan_emosional">
                                                    <label class="form-check-label">Berikan dukungan emosional dan spirital</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="berikan_oksigen_saturasi">
                                                    <label class="form-check-label">Berikan oksigen untuk mempertahankan saturasi oksigen >94%</label>
                                                </div>

                                                <strong>Edukasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="anjurkan_beraktifitas">
                                                    <label class="form-check-label">Anjurkan beraktifitas fisik sesuai toleransi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="anjurkan_berhenti_merokok">
                                                    <label class="form-check-label">Anjurkan berhenti merokok</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="ajarkan_mengukur_intake">
                                                    <label class="form-check-label">Ajarkan pasien dan keluarga mengukur intake dan output cairan harian</label>
                                                </div>

                                                <strong>Kolaborasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="kolaborasi_pemberian_terapi">
                                                    <label class="form-check-label">Koborasi pemberian therapi</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 3. Perfusi Perifer Tidak Efektif -->
                                    <tr>
                                        <td class="align-top">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="diagnosis[]" value="perfusi_perifer" id="diag_perfusi_perifer" onchange="toggleRencana('perfusi_perifer')">
                                                <label class="form-check-label" for="diag_perfusi_perifer">
                                                    <strong>Perfusi perifer tidak efektif</strong> berhubungan dengan hyperglikemia, penurunan konsentrasi hemoglobin, peningkatan tekanan darah, kekurangan volume cairan, penurunan aliran arteri dan/atau vena, kurang terpapar informasi tentang proses penyakit (misal: diabetes melitus, hiperlipidmia).
                                                </label>
                                            </div>
                                        </td>
                                        <td class="align-top">
                                            <div id="rencana_perfusi_perifer" style="display: none;">
                                                <strong>Observasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="periksa_sirkulasi">
                                                    <label class="form-check-label">Periksa sirkulasi perifer (edema, pengisian kapiler/CRT, suhu)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="identifikasi_faktor_risiko">
                                                    <label class="form-check-label">Identifikasi faktor risiko gangguan sirkulasi (diabetes, perokok, hipertensi, kadar kolesterol tinggi)</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="monitor_suhu_kemerahan">
                                                    <label class="form-check-label">Monitor suhu, kemerahan, nyeri atau bengkak pada ekstremitas.</label>
                                                </div>

                                                <strong>Terapeutik:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="hindari_pemasangan_infus">
                                                    <label class="form-check-label">Hindari pemasangan infus atau pengambilan darah di area keterbatasan perfusi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="hindari_pengukuran_tekanan">
                                                    <label class="form-check-label">Hindari pengukuran tekanan darah pada ekstremitas dengan keterbatasan perfusi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="hindari_penekanan">
                                                    <label class="form-check-label">Hindari penekanan dan pemasangan tourniqet pada area yang cedera</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="lakukan_pencegahan_infeksi">
                                                    <label class="form-check-label">Lakukan pencegahan infeksi</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="perawatan_kaki_kuku">
                                                    <label class="form-check-label">Lakukan perawatan kaki dan kuku</label>
                                                </div>

                                                <strong>Edukasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="anjurkan_berhenti_merokok_perfusi">
                                                    <label class="form-check-label">Anjurkan berhenti merokok</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="anjurkan_berolahraga">
                                                    <label class="form-check-label">Anjurkan berolahraga rutin</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="anjurkan_minum_obat">
                                                    <label class="form-check-label">Anjurkan minum obat pengontrol tekanan darah secara teratur</label>
                                                </div>

                                                <strong>Kolaborasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="kolaborasi_terapi_perfusi">
                                                    <label class="form-check-label">Koborasi pemberian therapi</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 4. Hipovolemia -->
                                    <tr>
                                        <td class="align-top">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="diagnosis[]" value="hipovolemia" id="diag_hipovolemia" onchange="toggleRencana('hipovolemia')">
                                                <label class="form-check-label" for="diag_hipovolemia">
                                                    <strong>Hipovolemia</strong> berhubungan dengan kehilangan cairan aktif, peningkatan permeabilitas kapiler, kekurangan intake cairan, evaporasi.
                                                </label>
                                            </div>
                                        </td>
                                        <td class="align-top">
                                            <div id="rencana_hipovolemia" style="display: none;">
                                                <strong>Observasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="periksa_tanda_gejala">
                                                    <label class="form-check-label">Periksa tanda dan gejala hipovolemia (frekuensi nadi meningkat, nadi teraba lemah, tekanan darah penurun, turgor kulit menurun, membran mukosa kering, volume urine menurun, haus, lemah)</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="monitor_intake_output_hipovolemia">
                                                    <label class="form-check-label">Monitor intake dan output cairan</label>
                                                </div>

                                                <strong>Terapeutik:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="berikan_asupan_cairan">
                                                    <label class="form-check-label">Berikan asupan cairan oral</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="posisi_trendelenburg">
                                                    <label class="form-check-label">Posisi modified trendelenburg</label>
                                                </div>

                                                <strong>Edukasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="anjurkan_memperbanyak_cairan">
                                                    <label class="form-check-label">Anjurkan memperbanyak asupan cairan oral</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="hindari_perubahan_posisi">
                                                    <label class="form-check-label">Anjurkan menghindari perubahan posisi mendadak</label>
                                                </div>

                                                <strong>Kolaborasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="kolaborasi_terapi_hipovolemia">
                                                    <label class="form-check-label">Koborasi pemberian therapi</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 5. Hipervolemia -->
                                    <tr>
                                        <td class="align-top">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="diagnosis[]" value="hipervolemia" id="diag_hipervolemia" onchange="toggleRencana('hipervolemia')">
                                                <label class="form-check-label" for="diag_hipervolemia">
                                                    <strong>Hipervolemia</strong> berhubungan dengan kelebihan asupan cairan, kelebihan asupan natrium, gangguan aliran balik vena.
                                                </label>
                                            </div>
                                        </td>
                                        <td class="align-top">
                                            <div id="rencana_hipervolemia" style="display: none;">
                                                <strong>Observasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="periksa_tanda_hipervolemia">
                                                    <label class="form-check-label">Periksa tanda dan gejala hipervolemia (dipsnea, edema, suara nafas tambahan)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="identifikasi_penyebab_hipervolemia">
                                                    <label class="form-check-label">Identifikasi penyebab hipervolemia</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="monitor_hemodinamik">
                                                    <label class="form-check-label">Monitor status hemodinamik (frekuensi jantung, tekanan darah)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="monitor_intake_output_hipervolemia">
                                                    <label class="form-check-label">Monitor intake dan output cairan</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="monitor_efek_diuretik">
                                                    <label class="form-check-label">Monitor efek samping diuretik (hipotensi ortostatik, hipovolemia, hipokalemia, hiponatremia)</label>
                                                </div>

                                                <strong>Terapeutik:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="timbang_berat_badan">
                                                    <label class="form-check-label">Timbang berat badan setiap hari pada waktu yang sama</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="batasi_asupan_cairan">
                                                    <label class="form-check-label">Batasi asupan cairan dan garam</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="tinggi_kepala_tempat_tidur">
                                                    <label class="form-check-label">Tinggi kepala tempat tidur 30 – 40 º</label>
                                                </div>

                                                <strong>Edukasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="ajarkan_mengukur_cairan">
                                                    <label class="form-check-label">Ajarkan cara mengukur dan mencatat asupan dan haluaran cairan</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="ajarkan_membatasi_cairan">
                                                    <label class="form-check-label">Ajarkan cara membatasi cairan</label>
                                                </div>

                                                <strong>Kolaborasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="kolaborasi_terapi_hipervolemia">
                                                    <label class="form-check-label">Koborasi pemberian therapi</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 6. Diare -->
                                    <tr>
                                        <td class="align-top">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="diagnosis[]" value="diare" id="diag_diare" onchange="toggleRencana('diare')">
                                                <label class="form-check-label" for="diag_diare">
                                                    <strong>Diare</strong> berhubungan dengan inflamasi gastrointestinal, iritasi gastrointestinal, proses infeksi, malabsorpsi.
                                                </label>
                                            </div>
                                        </td>
                                        <td class="align-top">
                                            <div id="rencana_diare" style="display: none;">
                                                <strong>Observasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="identifikasi_penyebab_diare">
                                                    <label class="form-check-label">Identifikasi penyebab diare (inflamasi gastrointestinal, iritasi gastrointestinal, proses infeksi, malabsorpsi, ansietas, stres, efek samping obat)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="identifikasi_riwayat_makanan">
                                                    <label class="form-check-label">Identifikasi riwayat pemberian makanan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="identifikasi_gejala_invaginasi">
                                                    <label class="form-check-label">Identifikasi riwayat gejala invaginasi (tangisan keras, kepucatan pada bayi)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="monitor_warna_volume_tinja">
                                                    <label class="form-check-label">Monitor warna, volume, frekuensi dan konsistensi tinja</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="monitor_tanda_hipovolemia">
                                                    <label class="form-check-label">Monitor tanda dan gejala hipovolemia (takikardi, nadi teraba lemah, tekanan darah turun, turgor kulit turun, mukosa mulit kering, CRT melambat, BB menurun)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="monitor_iritasi_kulit">
                                                    <label class="form-check-label">Monitor iritasi dan ulserasi kulit di daerah perianal</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="monitor_jumlah_diare">
                                                    <label class="form-check-label">Monitor jumlah pengeluaran diare</label>
                                                </div>

                                                <strong>Terapeutik:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="berikan_asupan_cairan_oral">
                                                    <label class="form-check-label">Berikan asupan cairan oral (larutan garam gula, oralit, pedialyte)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="pasang_jalur_intravena">
                                                    <label class="form-check-label">Pasang jalur intravena</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="berikan_cairan_intravena">
                                                    <label class="form-check-label">Berikan cairan intravena</label>
                                                </div>

                                                <strong>Edukasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="anjurkan_makanan_porsi_kecil">
                                                    <label class="form-check-label">Anjurkan makanan porsi kecil dan sering secara bertahap</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="hindari_makanan_gas">
                                                    <label class="form-check-label">Anjurkan menghindari makanan pembentuk gas, pedas dan mengandung laktosa</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="lanjutkan_asi">
                                                    <label class="form-check-label">Anjurkan melanjutkan pemberian ASI</label>
                                                </div>

                                                <strong>Kolaborasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="kolaborasi_terapi_diare">
                                                    <label class="form-check-label">Koborasi pemberian therapi</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 7. Retensi Urine -->
                                    <tr>
                                        <td class="align-top">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="diagnosis[]" value="retensi_urine" id="diag_retensi_urine" onchange="toggleRencana('retensi_urine')">
                                                <label class="form-check-label" for="diag_retensi_urine">
                                                    <strong>Retensi urine</strong> berhubungan dengan peningkatan tekanan uretra, kerusakan arkus refleks, Blok spingter, disfungsi neurologis (trauma, penyakit saraf), efek agen farmakologis (atropine, belladona, psikotropik, antihistamin, opiate).
                                                </label>
                                            </div>
                                        </td>
                                        <td class="align-top">
                                            <div id="rencana_retensi_urine" style="display: none;">
                                                <strong>Observasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="identifikasi_tanda_retensi">
                                                    <label class="form-check-label">Identifikasi tanda dan gejala retensi atau inkontinensia urine</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="identifikasi_faktor_penyebab">
                                                    <label class="form-check-label">Identifikasi faktor yang menyebabkan retensi atau inkontinensia urine</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="monitor_eliminasi_urine">
                                                    <label class="form-check-label">Monitor eliminasi urine (frekuensi, konsistensi, aroma, volume dan warna)</label>
                                                </div>

                                                <strong>Terapeutik:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="catat_waktu_berkemih">
                                                    <label class="form-check-label">Catat waktu-waktu dan haluaran berkemih</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="batasi_asupan_cairan">
                                                    <label class="form-check-label">Batasi asupan cairan, jika perlu</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ambil_sampel_urine">
                                                    <label class="form-check-label">Ambil sampel urine tengah (midstream) atau kultur</label>
                                                </div>

                                                <strong>Edukasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_tanda_infeksi">
                                                    <label class="form-check-label">Ajarkan tanda dan gejala infeksi saluran kemih</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_mengukur_asupan">
                                                    <label class="form-check-label">Ajarkan mengukur asupan cairan dan haluaran urine</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_spesimen_midstream">
                                                    <label class="form-check-label">Ajarkan mengambil spesimen urine midstream</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_tanda_berkemih">
                                                    <label class="form-check-label">Ajarkan mengenali tanda berkemih dan waktu yang tepat untuk berkemih</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_minum_cukup">
                                                    <label class="form-check-label">Ajarkan minum yang cukup, jika tidak ada kontraindikasi</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="kurangi_minum_tidur">
                                                    <label class="form-check-label">Anjurkan mengurangi minum menjelang tidur</label>
                                                </div>

                                                <strong>Kolaborasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="kolaborasi_supositoria">
                                                    <label class="form-check-label">Kolaborasi pemberian obat supositoria uretra, jika perlu</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 8. Nyeri Akut -->
                                    <tr>
                                        <td class="align-top">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="diagnosis[]" value="nyeri_akut" id="diag_nyeri_akut" onchange="toggleRencana('nyeri_akut')">
                                                <label class="form-check-label" for="diag_nyeri_akut">
                                                    <strong>Nyeri akut</strong> b.d agen pencedera fisiologis (inflamsi, iskemia, neoplasma), agen pencedera kimiawi (terbakar, bahan kimia iritan), agen pencedera fisik (abses, amputasi, terbakar, terpotong, mengangkat berat, prosedur operasi, trauma, latihan fisik berlebihan).
                                                </label>
                                            </div>
                                        </td>
                                        <td class="align-top">
                                            <div id="rencana_nyeri_akut" style="display: none;">
                                                <strong>Observasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_lokasi_nyeri">
                                                    <label class="form-check-label">Identifikasi lokasi, karakteristik, durasi, frekuensi, kualitas, intensitas nyeri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_skala_nyeri">
                                                    <label class="form-check-label">Identifikasi skala nyeri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_respons_nonverbal">
                                                    <label class="form-check-label">Identifikasi respons nyeri non verbal</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_faktor_nyeri">
                                                    <label class="form-check-label">Identifikasi faktor yang memperberat dan memperingan nyeri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_pengetahuan_nyeri">
                                                    <label class="form-check-label">Identifikasi pengetahuan dan keyaninan tentang nyeri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_pengaruh_budaya">
                                                    <label class="form-check-label">Identifikasi pengaruh budaya terhadap respon nyeri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_pengaruh_kualitas_hidup">
                                                    <label class="form-check-label">Identifikasi pengaruh nyeri pada kualitas hidup</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="monitor_keberhasilan_terapi">
                                                    <label class="form-check-label">Monitor keberhasilan terapi komplementer yang sudah diberikan</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="monitor_efek_samping_analgetik">
                                                    <label class="form-check-label">Monitor efek samping penggunaan analgetil</label>
                                                </div>

                                                <strong>Terapeutik:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="berikan_teknik_nonfarmakologis">
                                                    <label class="form-check-label">Berikan teknik nonfarmakologis untuk mengurangi rasa nyeri (TENS, hipnosis, akupresur, terapi musik, biofeedback, terapi pijat, aromaterapi, teknik imajinasi terbimbing, kompres hangat/dingin, terapi bermain)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="kontrol_lingkungan_nyeri">
                                                    <label class="form-check-label">Kontrol lingkungan yang memperberat rasa nyeri (suhu ruangan, pencahayaan, kebisingan)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="fasilitasi_istirahat">
                                                    <label class="form-check-label">Fasilitasi istirahat dan tidur</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="pertimbangkan_strategi_nyeri">
                                                    <label class="form-check-label">Pertimbangkan jenis dan sumber nyeri dalam pemilihan strategi meredakan nyeri</label>
                                                </div>

                                                <strong>Edukasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="jelaskan_penyebab_nyeri">
                                                    <label class="form-check-label">Jelaskan penyebab, periode, dan pemicu nyeri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="jelaskan_strategi_nyeri">
                                                    <label class="form-check-label">Jelaskan strategi meredakan nyeri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="anjurkan_monitor_nyeri">
                                                    <label class="form-check-label">Anjurkan memonitor nyeri secara mandiri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="anjurkan_analgetik">
                                                    <label class="form-check-label">Anjurkan menggunakan analgetik secara tepat</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="ajarkan_teknik_nonfarmakologis">
                                                    <label class="form-check-label">Ajarkan teknik nonfarmakologis untuk mengurangin rasa nyeri</label>
                                                </div>

                                                <strong>Kolaborasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="kolaborasi_analgetik">
                                                    <label class="form-check-label">Kolaborasi pemberian analgetik, jika perlu</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 9. Nyeri Kronis -->
                                    <tr>
                                        <td class="align-top">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="diagnosis[]" value="nyeri_kronis" id="diag_nyeri_kronis" onchange="toggleRencana('nyeri_kronis')">
                                                <label class="form-check-label" for="diag_nyeri_kronis">
                                                    <strong>Nyeri kronis</strong> b.d kondisi muskuloskeletal kronis, kerusakan sistem saraf, penekanan saraf, infiltrasi tumor, ketidakseimbangan neurotransmiter, neuromodulator, dan reseptor, gangguan imunitas, (neuropati terkait HIV, virus varicella-zoster), gangguan fungsi metabolik, riwayat posisi kerja statis, peningkatan indeks masa tubuh, kondisi pasca trauma, tekanan emosional, riwayat penganiayaan (fisik, psikologis, seksual), riwayat penyalahgunaan obat/zat.
                                                </label>
                                            </div>
                                        </td>
                                        <td class="align-top">
                                            <div id="rencana_nyeri_kronis" style="display: none;">
                                                <strong>Observasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_lokasi_nyeri_kronis">
                                                    <label class="form-check-label">Identifikasi lokasi, karakteristik, durasi, frekuensi, kualitas, intensitas nyeri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_skala_nyeri_kronis">
                                                    <label class="form-check-label">Identifikasi skala nyeri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_respons_nonverbal_kronis">
                                                    <label class="form-check-label">Identifikasi respons nyeri non verbal</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_faktor_nyeri_kronis">
                                                    <label class="form-check-label">Identifikasi faktor yang memperberat dan memperingan nyeri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_pengetahuan_nyeri_kronis">
                                                    <label class="form-check-label">Identifikasi pengetahuan dan keyaninan tentang nyeri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_pengaruh_budaya_kronis">
                                                    <label class="form-check-label">Identifikasi pengaruh budaya terhadap respon nyeri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_pengaruh_kualitas_hidup_kronis">
                                                    <label class="form-check-label">Identifikasi pengaruh nyeri pada kualitas hidup</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="monitor_keberhasilan_terapi_kronis">
                                                    <label class="form-check-label">Monitor keberhasilan terapi komplementer yang sudah diberikan</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="monitor_efek_samping_analgetik_kronis">
                                                    <label class="form-check-label">Monitor efek samping penggunaan analgetil</label>
                                                </div>

                                                <strong>Terapeutik:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="berikan_teknik_nonfarmakologis_kronis">
                                                    <label class="form-check-label">Berikan teknik nonfarmakologis untuk mengurangi rasa nyeri (TENS, hipnosis, akupresur, terapi musik, biofeedback, terapi pijat, aromaterapi, teknik imajinasi terbimbing, kompres hangat/dingin, terapi bermain)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="kontrol_lingkungan_nyeri_kronis">
                                                    <label class="form-check-label">Kontrol lingkungan yang memperberat rasa nyeri (suhu ruangan, pencahayaan, kebisingan)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="fasilitasi_istirahat_kronis">
                                                    <label class="form-check-label">Fasilitasi istirahat dan tidur</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="pertimbangkan_strategi_nyeri_kronis">
                                                    <label class="form-check-label">Pertimbangkan jenis dan sumber nyeri dalam pemilihan strategi meredakan nyeri</label>
                                                </div>

                                                <strong>Edukasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="jelaskan_penyebab_nyeri_kronis">
                                                    <label class="form-check-label">Jelaskan penyebab, periode, dan pemicu nyeri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="jelaskan_strategi_nyeri_kronis">
                                                    <label class="form-check-label">Jelaskan strategi meredakan nyeri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="anjurkan_monitor_nyeri_kronis">
                                                    <label class="form-check-label">Anjurkan memonitor nyeri secara mandiri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="anjurkan_analgetik_kronis">
                                                    <label class="form-check-label">Anjurkan menggunakan analgetik secara tepat</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="ajarkan_teknik_nonfarmakologis_kronis">
                                                    <label class="form-check-label">Ajarkan teknik nonfarmakologis untuk mengurangin rasa nyeri</label>
                                                </div>

                                                <strong>Kolaborasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="kolaborasi_analgetik_kronis">
                                                    <label class="form-check-label">Kolaborasi pemberian analgetik, jika perlu</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 10. Hipertermia -->
                                    <tr>
                                        <td class="align-top">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="diagnosis[]" value="hipertermia" id="diag_hipertermia" onchange="toggleRencana('hipertermia')">
                                                <label class="form-check-label" for="diag_hipertermia">
                                                    <strong>Hipertermia</strong> b.d dehidrasi, terpapar lingkungan panas, peroses penyakit (infeksi, kanker), ketidaksesuaian pakaian dengan suhu lingkungan, peningkatan laju metabolisme, respon trauma, aktivitas berlebihan, penggunaan inkubator.
                                                </label>
                                            </div>
                                        </td>
                                        <td class="align-top">
                                            <div id="rencana_hipertermia" style="display: none;">
                                                <strong>Observasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="identifikasi_penyebab_hipertermia">
                                                    <label class="form-check-label">Identifikasi penyebab hipertermia (dehidrasi, terpapar lingkungan panas, penggunaan inkubator)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="monitor_suhu_tubuh">
                                                    <label class="form-check-label">Monitor suhu tubuh</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="monitor_kadar_elektrolit">
                                                    <label class="form-check-label">Monitor kadar elektrolit</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="monitor_haluaran_urine">
                                                    <label class="form-check-label">Monitor haluaran urine</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="monitor_komplikasi_hipertermia">
                                                    <label class="form-check-label">Monitor komplikasi akibat hipertermia</label>
                                                </div>

                                                <strong>Terapeutik:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="sediakan_lingkungan_dingin">
                                                    <label class="form-check-label">Sediakan lingkungan yang dingin</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="longgarkan_pakaian">
                                                    <label class="form-check-label">Longgarkan atau lepaskan pakaian</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="basahi_kipasi_tubuh">
                                                    <label class="form-check-label">Basahi dan kipasi permukaan tubuh</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="berikan_cairan_oral_hipertermia">
                                                    <label class="form-check-label">Berikan cairan oral</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="ganti_linen_hiperhidrosis">
                                                    <label class="form-check-label">Ganti linen setiap hari atau lebih sering jika mengalami hiperhidrosis (keringat berlebih)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="pendinginan_eksternal">
                                                    <label class="form-check-label">Lakukan pendinginan eksternal (selimut hipotermia atau kompres dingin pada dahi, leher, dada, abdomen, aksila)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="hindari_antipiretik">
                                                    <label class="form-check-label">Hindari pemberian antipiretik atau aspirin</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="berikan_oksigen_hipertermia">
                                                    <label class="form-check-label">Berikan oksigen, jika perlu</label>
                                                </div>

                                                <strong>Edukasi:</strong>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="anjurkan_tirah_baring">
                                                    <label class="form-check-label">Anjurkan tirah baring</label>
                                                </div>

                                                <strong>Kolaborasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="kolaborasi_cairan_elektrolit">
                                                    <label class="form-check-label">Kolaborasi pemberian cairan dan elektrolit intravena, jika perlu</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 11. Gangguan Mobilitas Fisik -->
                                    <tr>
                                        <td class="align-top">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="diagnosis[]" value="gangguan_mobilitas_fisik" id="diag_gangguan_mobilitas_fisik" onchange="toggleRencana('gangguan_mobilitas_fisik')">
                                                <label class="form-check-label" for="diag_gangguan_mobilitas_fisik">
                                                    <strong>Gangguan mobilitas fisik</strong> b.d kerusakan intergritas struktur tulang, perubahan metabolisme, ketidakbugaran fisik, penurunan kendali otot, penurunan massa otot, penurunan kekuatan otot, keterlambatan perkembangan, kekakuan sendi, kontraktur, malnutrisi, gangguan muskuloskeletal, gangguan neuromuskular, indeks masa tubuh diatas persentil ke-75 seusai usia, efek agen farmakologis, program pembatasan gerak, nyeri, kurang terpapar informasi tentang aktivitas fisik, kecemasan, gangguan kognitif, keengganan melakukan pergerakan, gangguan sensoripersepsi.
                                                </label>
                                            </div>
                                        </td>
                                        <td class="align-top">
                                            <div id="rencana_gangguan_mobilitas_fisik" style="display: none;">
                                                <strong>Observasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="identifikasi_nyeri_keluhan">
                                                    <label class="form-check-label">Indentifikasi adanya nyeri atau keluhan fisik lainnya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="identifikasi_toleransi_ambulasi">
                                                    <label class="form-check-label">Indetifikasi toleransi fisik melakukan ambulasi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="monitor_frekuensi_jantung_ambulasi">
                                                    <label class="form-check-label">Monitor frekuensi jantung dan tekanan darah sebelum memulai ambulasi</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="monitor_kondisi_umum_ambulasi">
                                                    <label class="form-check-label">Monitor kondiri umum selama melakukan ambulasi</label>
                                                </div>

                                                <strong>Terapeutik:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="fasilitasi_aktivitas_ambulasi">
                                                    <label class="form-check-label">Fasilitasi aktivitas ambulasi dengan alat bantu (tongkat, kruk)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="fasilitasi_mobilisasi_fisik">
                                                    <label class="form-check-label">Fasilitasi melakukan mobilisasi fisik, jika perlu</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="libatkan_keluarga_ambulasi">
                                                    <label class="form-check-label">Libatkan keluarga untuk membantu pasien dalam meningkatkan ambulasi</label>
                                                </div>

                                                <strong>Edukasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="jelaskan_tujuan_ambulasi">
                                                    <label class="form-check-label">Jelaskan tujuan dan prosedur ambulasi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="anjurkan_ambulasi_dini">
                                                    <label class="form-check-label">Anjurkan melakukan ambulasi dini</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="ajarkan_ambulasi_sederhana">
                                                    <label class="form-check-label">Ajarkan ambulasi sederhana yang harus dilakukan (berjalan dari tempat tidur ke kursi roda, berjalan dari tempat tidur ke kamar mandi, berjalan sesuai toleransi)</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 12. Resiko Infeksi -->
                                    <tr>
                                        <td class="align-top">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="diagnosis[]" value="resiko_infeksi" id="diag_resiko_infeksi" onchange="toggleRencana('resiko_infeksi')">
                                                <label class="form-check-label" for="diag_resiko_infeksi">
                                                    <strong>Resiko infeksi</strong> b.d efek prosedur invasif, penyakit kronis (diabetes melitus), malnutrisi, peningkatan paparan organisme patogen lingkungan, ketidakadekuatan pertahanan tubuh primer (gangguan persitaltik, kerusakan integritas kulit, perubahan sekresi PH, penurunan kerja siliaris, ketuban pecah lama, ketuban pecah sebelum waktunya, merokok, statis cairan tubuh), ketidakadekuatan pertahanan tubuh sekunder (penurunan hemoglobin, imununosupresi, leukopenia, supresi respon inflamasi, vaksinasi tidak adekuat).
                                                </label>
                                            </div>
                                        </td>
                                        <td class="align-top">
                                            <div id="rencana_resiko_infeksi" style="display: none;">
                                                <strong>Observasi:</strong>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="monitor_tanda_infeksi_sistemik">
                                                    <label class="form-check-label">Monitor tanda dan gejala infeksi lokal dan sistemik</label>
                                                </div>

                                                <strong>Terapeutik:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="batasi_pengunjung">
                                                    <label class="form-check-label">Batasi jumlah pengunjung</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="perawatan_kulit_edema">
                                                    <label class="form-check-label">Berikan perawatan kulit pada area edema</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="cuci_tangan_kontak">
                                                    <label class="form-check-label">Cuci tangan sebelum dan sesudah kontak dengan pasien dan lingkungan pasien</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="pertahankan_teknik_aseptik">
                                                    <label class="form-check-label">Pertahankan teknik aseptik pada pasien beresiko tinggi</label>
                                                </div>

                                                <strong>Edukasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="jelaskan_tanda_infeksi_edukasi">
                                                    <label class="form-check-label">Jelaskan tanda dan gejala infeksi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="ajarkan_cuci_tangan">
                                                    <label class="form-check-label">Ajarkan cara mencuci tangan dengan benar</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="ajarkan_etika_batuk">
                                                    <label class="form-check-label">Ajarkan etika batuk</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="ajarkan_periksa_luka">
                                                    <label class="form-check-label">Ajarkan cara memeriksa kondisi luka atau luka operasi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="anjurkan_asupan_nutrisi">
                                                    <label class="form-check-label">Anjurkan meningkatkan asupan nutrisi</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="anjurkan_asupan_cairan_infeksi">
                                                    <label class="form-check-label">Anjurkan meningkatkan asupan cairan</label>
                                                </div>

                                                <strong>Kolaborasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="kolaborasi_imunisasi">
                                                    <label class="form-check-label">Kolaborasi pemberian imunisasi, jika perlu.</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 13. Konstipasi -->
                                    <tr>
                                        <td class="align-top">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="diagnosis[]" value="konstipasi" id="diag_konstipasi" onchange="toggleRencana('konstipasi')">
                                                <label class="form-check-label" for="diag_konstipasi">
                                                    <strong>Konstipasi</strong> b.d penurunan motilitas gastrointestinal, ketidaadekuatan pertumbuhan gigi, ketidakcukupan diet, ketidakcukupan asupan serat, ketidakcukupan asupan serat, ketidakcukupan asupan cairan, aganglionik (penyakit Hircsprung), kelemahan otot abdomen.
                                                </label>
                                            </div>
                                        </td>
                                        <td class="align-top">
                                            <div id="rencana_konstipasi" style="display: none;">
                                                <strong>Observasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="periksa_tanda_gejala_konstipasi">
                                                    <label class="form-check-label">Periksa tanda dan gejala</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="periksa_pergerakan_usus">
                                                    <label class="form-check-label">Periksa pergerakan usus, karakteristik feses</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="identifikasi_faktor_risiko_konstipasi">
                                                    <label class="form-check-label">Identifikasi faktor risiko konstipasi</label>
                                                </div>

                                                <strong>Terapeutik:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="anjurkan_diet_tinggi_serat">
                                                    <label class="form-check-label">Anjurkan diet tinggi serat</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="masase_abdomen">
                                                    <label class="form-check-label">Lakukan masase abdomen, jika perlu</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="evakuasi_feses_manual">
                                                    <label class="form-check-label">Lakukan evakuasi feses secara manual, jika perlu</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="berikan_enema">
                                                    <label class="form-check-label">Berikan enema atau intigasi, jika perlu</label>
                                                </div>

                                                <strong>Edukasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="jelaskan_etiologi_konstipasi">
                                                    <label class="form-check-label">Jelaskan etiologi masalah dan alasan tindakan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="anjurkan_peningkatan_cairan_konstipasi">
                                                    <label class="form-check-label">Anjurkan peningkatan asupan cairan, jika tidak ada kontraindikasi</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="ajarkan_mengatasi_konstipasi">
                                                    <label class="form-check-label">Ajarkan cara mengatasi konstipasi/impaksi</label>
                                                </div>

                                                <strong>Kolaborasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="kolaborasi_obat_pencahar">
                                                    <label class="form-check-label">Kolaborasi penggunaan obat pencahar, jika perlu</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 14. Resiko Jatuh -->
                                    <tr>
                                        <td class="align-top">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="diagnosis[]" value="resiko_jatuh" id="diag_resiko_jatuh" onchange="toggleRencana('resiko_jatuh')">
                                                <label class="form-check-label" for="diag_resiko_jatuh">
                                                    <strong>Resiko jatuh</strong> b.d usia lebih dari sama dengan 65 tahun (pada dewasa) atau kurang dari sama dengan 2 tahun (pada anak) Riwayat jatuh, anggota gerak bawah prostesis (buatan), penggunaan alat bantu berjalan, penurunan tingkat kesadaran, perubahan fungsi kognitif, lingkungan tidak aman (licin, gelap, lingkungan asing), kondisi pasca operasi, hipotensi ortostatik, perubahan kadar glukosa darah, anemia, kekuatan otot menurun, gangguan pendengaran, gangguan keseimbangan, gangguan penglihatan (glaukoma, katarak, ablasio retina, neuritis optikus), neuropati, efek agen farmakologis (sedasi, alkohol, anastesi umum).
                                                </label>
                                            </div>
                                        </td>
                                        <td class="align-top">
                                            <div id="rencana_resiko_jatuh" style="display: none;">
                                                <strong>Observasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="identifikasi_faktor_risiko_jatuh">
                                                    <label class="form-check-label">Identifikasi faktor risiko jatuh (usia >65 tahun, penurunan tingkat kesadaran, defisit kognitif, hipotensi ortostatik, gangguan keseimbangan, gangguan penglihatan, neuropati)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="identifikasi_risiko_setiap_shift">
                                                    <label class="form-check-label">Identifikasi risiko jatuh setidaknya sekali setiap shift atau sesuai dengan kebijakan institusi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="identifikasi_faktor_lingkungan">
                                                    <label class="form-check-label">Identifikasi faktor lingkungan yang meningkatkan risiko jatuh (lantai licin, penerangan kurang)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="hitung_risiko_jatuh">
                                                    <label class="form-check-label">Hitung risiko jatuh dengan menggunakan skala (Fall Morse Scale, humpty dumpty scale), jika perlu</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="monitor_kemampuan_berpindah">
                                                    <label class="form-check-label">Monitor kemampuan berpindah dari tempat tidur ke kursi roda dan sebaliknya</label>
                                                </div>

                                                <strong>Terapeutik:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="orientasikan_ruangan">
                                                    <label class="form-check-label">Orientasikan ruangan pada pasien dan keluarga</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="pastikan_roda_terkunci">
                                                    <label class="form-check-label">Pastikan roda tempat tidur dan kursi roda selalu dalam kondisi terkunci</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="pasang_handrail">
                                                    <label class="form-check-label">Pasang handrail tempat tidur</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="atur_tempat_tidur">
                                                    <label class="form-check-label">Atur tempat tidur mekanis pada posisi terendah</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="tempatkan_dekat_perawat">
                                                    <label class="form-check-label">Tempatkan pasien berisiko tinggi jatuh dekat dengan pantauan perawat dari nurse station</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="gunakan_alat_bantu">
                                                    <label class="form-check-label">Gunakan alat bantu berjalan (kursi roda, walker)</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="dekatkan_bel">
                                                    <label class="form-check-label">Dekatkan bel pemanggil dalam jangkauan pasien</label>
                                                </div>

                                                <strong>Edukasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="anjurkan_memanggil_perawat">
                                                    <label class="form-check-label">Anjurkan memanggil perawat jika membutuhkan bantuan untuk berpindah</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="anjurkan_alas_kaki">
                                                    <label class="form-check-label">Anjurkan menggunakan alas kaki yang tidak licin</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="anjurkan_berkonsentrasi">
                                                    <label class="form-check-label">Anjurkan berkonsentrasi untuk menjaga keseimbangan tubuh</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="anjurkan_melebarkan_jarak">
                                                    <label class="form-check-label">Anjurkan melebarkan jarak kedua kaki untuk meningkatkan keseimbangan saat berdiri</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="ajarkan_bel_pemanggil">
                                                    <label class="form-check-label">Ajarkan cara menggunakan bel pemanggil untuk memanggil perawat</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 15. Gangguan Integritas Kulit/Jaringan -->
                                    <tr>
                                        <td class="align-top">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="diagnosis[]" value="gangguan_integritas_kulit" id="diag_gangguan_integritas_kulit" onchange="toggleRencana('gangguan_integritas_kulit')">
                                                <label class="form-check-label" for="diag_gangguan_integritas_kulit">
                                                    <strong>Gangguan integritas kulit/jaringan</strong> b.d perubahan sirkulasi, perubahan status nutrisi (kelebihan atau kekurangan), kekurangan/kelebihan volume cairan, penurunan mobilitas, bahan kimia iritatif, suhu lingkungan yang ekstream, faktor mekanis (penekanan pada tonjolan tulang, gesekan) atau faktor elektris (elektrodiatermi, energi listrik bertegangan tinggi), efek samping terapi radiasi, kelembapan, proses penuaan, neuropati perifer, perubahan pigmentasi, perubahan hormonal, kurang terpapar informasi tentang upaya mempertahankan/melindungi integritas jaringan.
                                                </label>
                                            </div>
                                        </td>
                                        <td class="align-top">
                                            <div id="rencana_gangguan_integritas_kulit" style="display: none;">
                                                <strong>Observasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="monitor_karakteristik_luka">
                                                    <label class="form-check-label">Monitor karakteristik luka</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="monitor_tanda_infeksi">
                                                    <label class="form-check-label">Monitor tanda-tanda infeksi</label>
                                                </div>

                                                <strong>Terapeutik:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="lepaskan_balutan">
                                                    <label class="form-check-label">Lepaskan balutan dan plester secara perlahan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="bersihkan_nacl">
                                                    <label class="form-check-label">Bersihkan dengan cairan NaCl atau pembersih nontoksik</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="bersihkan_jaringan_nekrotik">
                                                    <label class="form-check-label">Bersihkan jaringan nekrotik</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="berikan_salep">
                                                    <label class="form-check-label">Berikan salep yang sesuai ke kulit/lesi, jika perlu</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="pasang_balutan">
                                                    <label class="form-check-label">Pasang balutan sesuai jenis luka</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="pertahankan_teknik_steril">
                                                    <label class="form-check-label">Pertahankan teknik steril saat melakukan perawatan luka</label>
                                                </div>

                                                <strong>Edukasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="jelaskan_tanda_infeksi">
                                                    <label class="form-check-label">Jelaskan tanda dan gejala infeksi</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="anjurkan_makanan_tinggi_protein">
                                                    <label class="form-check-label">Anjurkan mengkonsumsi makanan tinggi kalori dan protein</label>
                                                </div>

                                                <strong>Kolaborasi:</strong>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="kolaborasi_debridement">
                                                    <label class="form-check-label">Kolaborasi prosedur debridement</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="kolaborasi_antibiotik">
                                                    <label class="form-check-label">Kolaborasi pemberian antibiotik</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>


                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
