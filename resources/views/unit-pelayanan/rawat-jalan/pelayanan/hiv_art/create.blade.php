@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.include')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Patient Card -->
            <div class="col-lg-3 col-md-4 mb-4">
                @include('components.patient-card')
            </div>

            <!-- Main Form -->
            <div class="col-lg-9 col-md-8">
                <div class="d-flex align-items-center mb-3">
                    <a href="{{ route('rawat-jalan.hiv_art.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                        class="btn btn-outline-primary btn-sm me-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <form id="praAnestesiForm" method="POST"
                    action="{{ route('rawat-jalan.hiv_art.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                    @csrf

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h5 class="mb-0 font-weight-bold">IKHTISAR PERAWATAN PASIEN HIV DAN TERAPI ANTIRETROVIRAL (ART)
                            </h5>
                        </div>

                        <div class="card-body p-4">

                            <!-- Waktu -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-clock me-2"></i>Waktu</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tanggal</label>
                                                <input type="date" class="form-control" name="tanggal"
                                                    value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jam</label>
                                                <input type="time" class="form-control" name="jam"
                                                    value="{{ date('H:i') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Alergi -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-allergies"></i> Alergi</h6>
                                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3 mt-2"
                                        id="openAlergiModal" data-bs-toggle="modal" data-bs-target="#alergiModal">
                                        <i class="ti-plus"></i> Tambah Alergi
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="section-separator" id="alergi">
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
                                                                <td colspan="5" class="text-center text-muted">Tidak ada
                                                                    data alergi</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Identitas Pasien -->
                            <div class="card mb-4 shadow-sm">
                                <div class="section-header">
                                    1. Data Identitas Pasien
                                </div>
                                <div class="p-3">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">No Reg Nas</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="no_reg_nas"
                                                placeholder="No registrasi Nasional">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">NIK</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="nik"
                                                placeholder="Nomor Indok Kependudukan">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Nama Ibu Kandung</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="nama_ibu_kandung"
                                                placeholder="Nama Ibu Kandung">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Alamat</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="alamat_telp" rows="2"
                                                placeholder="Alamat Pasien"></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">No. Telp. Pasien</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="no_telp_pasien"
                                                placeholder="No. Telp. Pasien">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Nama Pengawas Minum Obat (PMO)</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="pmo"
                                                placeholder="Nama Pengawas Minum Obat">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Hubungannya dgn Pasien</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="hubungan_pasien"
                                                placeholder="Hubungan dengan Pasien">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Alamat PMO</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="alamat_no_telp_pmo"
                                                placeholder="Alamat">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">No. Telp. PMO</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="no_telp_pmo" placeholder="No telp pmo">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Tanggal Konfirmasi tes HIV</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control" name="tgl_tes_hiv">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Tempat</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="tempat_tes_hiv"
                                                placeholder="Tempat Tes HIV">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold"><i>Entry Point</i></label>
                                        </div>
                                        <div class="col-md-9">
                                            <!-- 1. KIA -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" value="kia" id="kia"
                                                    name="kia_details[]">
                                                <label class="form-check-label" for="kia">
                                                    1. KIA
                                                </label>
                                            </div>

                                            <!-- 2-Rujukan Jalan dengan input tambahan -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" value="rujukan_jalan_tb"
                                                    id="kia_rujukan_jalan_tb" name="kia_details[]">
                                                <label class="form-check-label" for="kia_rujukan_jalan_tb">
                                                    2. Rujukan Jalan (TB, Anak, Penyakit Dalam, MIS, Lainnya...)
                                                </label>
                                            </div>
                                            <div id="rujukan-details" class="d-none bg-light p-3 mb-3 rounded">
                                                <textarea class="form-control" name="rujukan_keterangan" rows="2"
                                                    placeholder="Sebutkan detail..."></textarea>
                                            </div>

                                            <!-- 3-Rawat Inap -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" value="rujukan_rawat_inap"
                                                    id="kia_rawat_inap" name="kia_details[]">
                                                <label class="form-check-label" for="kia_rawat_inap">
                                                    3. Rawat Inap
                                                </label>
                                            </div>

                                            <!-- 4-Praktek Swasta -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" value="praktek_swasta"
                                                    id="kia_praktek_swasta" name="kia_details[]">
                                                <label class="form-check-label" for="kia_praktek_swasta">
                                                    4. Praktek Swasta
                                                </label>
                                            </div>

                                            <!-- 5-Jangkauan dengan input tambahan -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" value="jangkauan"
                                                    id="kia_jangkauan" name="kia_details[]">
                                                <label class="form-check-label" for="kia_jangkauan">
                                                    5. Jangkauan (Penasun, WPS, LSL, ...)
                                                </label>
                                            </div>
                                            <div id="jangkauan-details" class="d-none bg-light p-3 mb-3 rounded">
                                                <textarea class="form-control" name="jangkauan_keterangan" rows="2"
                                                    placeholder="Sebutkan detail jangkauan..."></textarea>
                                            </div>

                                            <!-- 6-LSM -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" value="lsm" id="kia_lsm"
                                                    name="kia_details[]">
                                                <label class="form-check-label" for="kia_lsm">
                                                    6. LSM
                                                </label>
                                            </div>

                                            <!-- 7-Datang sendiri -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" value="datang_sendiri"
                                                    id="kia_datang_sendiri" name="kia_details[]">
                                                <label class="form-check-label" for="kia_datang_sendiri">
                                                    7. Datang sendiri
                                                </label>
                                            </div>

                                            <!-- 8-Lainnya dengan input tambahan -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" value="lainnya_uraikan"
                                                    id="kia_lainnya" name="kia_details[]">
                                                <label class="form-check-label" for="kia_lainnya">
                                                    8. Lainnya, uraikan...
                                                </label>
                                            </div>
                                            <div id="lainnya-kia-details" class="d-none bg-light p-3 mb-3 rounded">
                                                <textarea class="form-control" name="lainnya_kia_keterangan" rows="2"
                                                    placeholder="Sebutkan lainnya..."></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Data Riwayat Pribadi -->
                            <div class="card mb-4 shadow-sm">
                                <div class="section-header">
                                    2. Data Riwayat Pribadi
                                </div>
                                <div class="p-3">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Pendidikan</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" name="pendidikan">
                                                <option value="">--pilih--</option>
                                                <option value="0">Tidak Sekolah</option>
                                                <option value="1">SD</option>
                                                <option value="2">SMP</option>
                                                <option value="3">SMU</option>
                                                <option value="4">Akademi/PT</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Kerja</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" name="pekerjaan">
                                                <option value="">--pilih--</option>
                                                <option value="0">Tidak Bekerja</option>
                                                <option value="1">Bekerja</option>
                                                <option value="2">lainnya</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Faktor Risiko</label>
                                        </div>
                                        <div class="col-md-9">
                                            <!-- Seks Vaginal Berisiko -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                    value="Seks Vaginal Berisiko" id="seks_vaginal" name="faktor_risiko[]">
                                                <label class="form-check-label" for="seks_vaginal">
                                                    Seks Vaginal Berisiko
                                                </label>
                                            </div>

                                            <!-- Seks Anal Berisiko -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="Seks Anal Berisiko"
                                                    id="seks_anal" name="faktor_risiko[]">
                                                <label class="form-check-label" for="seks_anal">
                                                    Seks Anal Berisiko
                                                </label>
                                            </div>

                                            <!-- Perinatal -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="Perinatal"
                                                    id="perinatal" name="faktor_risiko[]">
                                                <label class="form-check-label" for="perinatal">
                                                    Perinatal
                                                </label>
                                            </div>

                                            <!-- Transfusi Darah -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="Transfusi Darah"
                                                    id="transfusi_darah" name="faktor_risiko[]">
                                                <label class="form-check-label" for="transfusi_darah">
                                                    Transfusi Darah
                                                </label>
                                            </div>

                                            <!-- NAPZA Suntik -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="NAPZA Suntik"
                                                    id="napza_suntik" name="faktor_risiko[]">
                                                <label class="form-check-label" for="napza_suntik">
                                                    NAPZA Suntik
                                                </label>
                                            </div>

                                            <!-- Lain-lainnya dengan input tambahan -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="Lain-lainnya"
                                                    id="lain_lainnya" name="faktor_risiko[]">
                                                <label class="form-check-label" for="lain_lainnya">
                                                    Lain-lain, Uraikan...
                                                </label>
                                            </div>
                                            <div id="lain-lainnya-details" class="d-none bg-light p-3 mb-3 rounded">
                                                <textarea class="form-control" name="lain_lainnya_keterangan" rows="2"
                                                    placeholder="Sebutkan faktor risiko lainnya..."></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Data Riwayat Keluarga / Mitra Seksual / Mitra Penasun -->
                            <div class="card mb-4 shadow-sm">
                                <div class="section-header">
                                    3. Riwayat Keluarga / Mitra Seksual / Mitra Penasun
                                </div>
                                <div class="p-3">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Status Pernikahan</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="inlineCheckbox1"
                                                    name="status_pernikahan" value="Menikah">
                                                <label class="form-check-label" for="inlineCheckbox1">Menikah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="inlineCheckbox2"
                                                    name="status_pernikahan" value="Belum Menikah">
                                                <label class="form-check-label" for="inlineCheckbox2">Belum Menikah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="inlineCheckbox3"
                                                    name="status_pernikahan" value="Janda/Duda">
                                                <label class="form-check-label" for="inlineCheckbox3">Janda/Duda</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0">Data Keluarga / Mitra</h6>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#tambahMitraModal">
                                                    <i class="fas fa-plus"></i> Tambah
                                                </button>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover" id="mitraTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th width="20%">Nama</th>
                                                            <th width="10%">Hub</th>
                                                            <th width="10%">Umur</th>
                                                            <th width="15%">HIV +/-</th>
                                                            <th width="15%">ART Y/T</th>
                                                            <th width="20%">NoRegNas</th>
                                                            <th width="10%">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr id="no-data-row">
                                                            <td colspan="7" class="text-center text-muted">Tidak ada data
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!-- Hidden input untuk mengirim JSON ke backend -->
                                                <input type="hidden" name="data_keluarga" id="dataKeluargaInput" value="">
                                                <input type="hidden" id="existing-mitra-data"
                                                    value="{{ isset($existingRecord) ? json_encode($existingRecord->data_keluarga_json ?? []) : '[]' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Riwayat Terapi Antiretroviral -->
                            <div class="card mb-4 shadow-sm">
                                <div class="section-header">
                                    4. Riwayat Terapi Antiretroviral
                                </div>
                                <div class="p-3">
                                    <!-- Pernah Menerima ART -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold">Pernah menerima ART?</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="menerima_art_ya" value="Ya"
                                                    name="menerima_art">
                                                <label class="form-check-label" for="menerima_art_ya">1. Ya</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="menerima_art_tidak"
                                                    value="Tidak" name="menerima_art">
                                                <label class="form-check-label" for="menerima_art_tidak">2. Tidak</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Detail ART (hidden by default) -->
                                    <div id="art_details" class="art-details" style="display: none;">
                                        <!-- Jika ya, pilih jenis -->
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">Jika ya</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="ppia" value="PPIA"
                                                        name="jenis_art">
                                                    <label class="form-check-label" for="ppia">1. PPIA</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="art" value="ART"
                                                        name="jenis_art">
                                                    <label class="form-check-label" for="art">2. ART</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="ppp" value="PPP"
                                                        name="jenis_art">
                                                    <label class="form-check-label" for="ppp">3. PPP</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tempat ART Dulu -->
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">Tempat ART dulu</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="rs_pemerintah"
                                                        value="RS Pemerintah" name="tempat_art">
                                                    <label class="form-check-label" for="rs_pemerintah">1. RS Pem</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="rs_swasta"
                                                        value="RS Swasta" name="tempat_art">
                                                    <label class="form-check-label" for="rs_swasta">2. RS Swasta</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="pkm" value="PKM"
                                                        name="tempat_art">
                                                    <label class="form-check-label" for="pkm">3. PKM</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Nama, dosis ARV & lama penggunaannya (Free text) -->
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">Nama, dosis ARV & lama
                                                    penggunaannya</label>
                                            </div>
                                            <div class="col-md-9">
                                                <textarea class="form-control" name="nama_dosis_arv" rows="4"
                                                    placeholder="Sebutkan nama obat ARV, dosis, dan lama penggunaan secara detail..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Pemeriksaan Klinis dan Laboratorium -->
                            <div class="card shadow-sm">
                                <div class="section-header">
                                    <h5 class="mb-0">
                                        5. Data Pemeriksaan Klinis dan Laboratorium
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <!-- Info Panel -->
                                    <div class="alert alert-info border-0 mb-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <div>
                                                <strong>Petunjuk Pengisian:</strong><br>
                                                <small>Isi data pemeriksaan pada setiap tahap kunjungan pasien. Tidak semua
                                                    kolom wajib diisi.</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Grid -->
                                    <div class="row g-4">
                                        <!-- Kunjungan Pertama -->
                                        <div class="col-12">
                                            <div class="card border-start border-success border-4">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0 text-success">
                                                        <i class="fas fa-calendar-plus me-2"></i>
                                                        Kunjungan Pertama
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Tanggal Kunjungan</label>
                                                            <input type="date" name="kunjungan_pertama_tanggal"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Stad. Klinis</label>
                                                            <input type="text" name="kunjungan_pertama_klinis"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">BB</label>
                                                            <div class="input-group">
                                                                <input type="number" name="kunjungan_pertama_bb"
                                                                    class="form-control" placeholder="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Status Fungsional
                                                                <br>
                                                                <small class="text-muted">1 = kerja / 2 = ambulatori / 3 =
                                                                    baring</small>
                                                            </label>
                                                            <input type="text" name="kunjungan_pertama_status_fungsional"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">JumlahCD4
                                                                <br><small class="text-muted">(CD4 % pd
                                                                    anak)</small></label>
                                                            <input type="number" name="kunjungan_pertama_cd4"
                                                                class="form-control" placeholder="0">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Lain-lain</label>
                                                            <textarea name="kunjungan_pertama_lain" class="form-control"
                                                                rows="2" placeholder="Isi Lainnya..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Memenuhi syarat medis utk ART -->
                                        <div class="col-12">
                                            <div class="card border-start border-warning border-4">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0 text-warning">
                                                        <i class="fas fa-check-circle me-2"></i>
                                                        Memenuhi syarat medis utk ART
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Tanggal</label>
                                                            <input type="date" name="memenuhi_syarat_tanggal"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Stad. Klinis</label>
                                                            <input type="text" name="memenuhi_syarat_klinis"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">BB</label>
                                                            <div class="input-group">
                                                                <input type="number" name="memenuhi_syarat_bb"
                                                                    class="form-control" placeholder="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Status Fungsional
                                                                <br>
                                                                <small class="text-muted">1 = kerja / 2 = ambulatori / 3 =
                                                                    baring</small>
                                                            </label>
                                                            <input type="text" name="memenuhi_syarat_status_fungsional"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">JumlahCD4
                                                                <br><small class="text-muted">(CD4 % pd
                                                                    anak)</small></label>
                                                            <input type="number" name="memenuhi_syarat_cd4"
                                                                class="form-control" placeholder="0">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Lain-lain</label>
                                                            <textarea name="memenuhi_syarat_lain" class="form-control"
                                                                rows="2" placeholder="Isi Lainnya..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Saat mulai ART -->
                                        <div class="col-12">
                                            <div class="card border-start border-primary border-4">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0 text-primary">
                                                        <i class="fas fa-play-circle me-2"></i>
                                                        Saat mulai ART
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Tanggal</label>
                                                            <input type="date" name="saat_mulai_art_tanggal"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Stad. Klinis</label>
                                                            <input type="text" name="saat_mulai_art_klinis"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">BB</label>
                                                            <div class="input-group">
                                                                <input type="number" name="saat_mulai_art_bb"
                                                                    class="form-control" placeholder="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Status Fungsional
                                                                <br>
                                                                <small class="text-muted">1 = kerja / 2 = ambulatori / 3 =
                                                                    baring</small>
                                                            </label>
                                                            <input type="text" name="saat_mulai_art_status_fungsional"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">JumlahCD4
                                                                <br><small class="text-muted">(CD4 % pd
                                                                    anak)</small></label>
                                                            <input type="number" name="saat_mulai_art_cd4"
                                                                class="form-control" placeholder="0">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Lain-lain</label>
                                                            <textarea name="saat_mulai_art_lain" class="form-control"
                                                                rows="2" placeholder="Isi Lainnya..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Setelah 6 bulan ART -->
                                        <div class="col-12">
                                            <div class="card border-start border-info border-4">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0 text-info">
                                                        <i class="fas fa-calendar-check me-2"></i>
                                                        Setelah 6 bulan ART
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Tanggal</label>
                                                            <input type="date" name="setelah_6_bulan_tanggal"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Stad. Klinis</label>
                                                            <input type="text" name="setelah_6_bulan_klinis"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">BB</label>
                                                            <div class="input-group">
                                                                <input type="number" name="setelah_6_bulan_bb"
                                                                    class="form-control" placeholder="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Status Fungsional
                                                                <br>
                                                                <small class="text-muted">1 = kerja / 2 = ambulatori / 3 =
                                                                    baring</small>
                                                            </label>
                                                            <input type="text" name="setelah_6_bulan_status_fungsional"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">JumlahCD4
                                                                <br><small class="text-muted">(CD4 % pd
                                                                    anak)</small></label>
                                                            <input type="number" name="setelah_6_bulan_cd4"
                                                                class="form-control" placeholder="0">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Lain-lain</label>
                                                            <textarea name="setelah_6_bulan_lain" class="form-control"
                                                                rows="2" placeholder="Isi Lainnya..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Setelah 12 bulan ART -->
                                        <div class="col-12">
                                            <div class="card border-start border-secondary border-4">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0 text-secondary">
                                                        <i class="fas fa-calendar-alt me-2"></i>
                                                        Setelah 12 bulan ART
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Tanggal</label>
                                                            <input type="date" name="setelah_12_bulan_tanggal"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Stad. Klinis</label>
                                                            <input type="text" name="setelah_12_bulan_klinis"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">BB</label>
                                                            <div class="input-group">
                                                                <input type="number" name="setelah_12_bulan_bb"
                                                                    class="form-control" placeholder="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Status Fungsional
                                                                <br>
                                                                <small class="text-muted">1 = kerja / 2 = ambulatori / 3 =
                                                                    baring</small>
                                                            </label>
                                                            <input type="text" name="setelah_12_bulan_status_fungsional"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">JumlahCD4
                                                                <br><small class="text-muted">(CD4 % pd
                                                                    anak)</small></label>
                                                            <input type="number" name="setelah_12_bulan_cd4"
                                                                class="form-control" placeholder="0">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Lain-lain</label>
                                                            <textarea name="setelah_12_bulan_lain" class="form-control"
                                                                rows="2" placeholder="Isi Lainnya..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Setelah 24 bulan ART -->
                                        <div class="col-12">
                                            <div class="card border-start border-dark border-4">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0 text-dark">
                                                        <i class="fas fa-calendar me-2"></i>
                                                        Setelah 24 bulan ART
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Tanggal</label>
                                                            <input type="date" name="setelah_24_bulan_tanggal"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Stad. Klinis</label>
                                                            <input type="text" name="setelah_24_bulan_klinis"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">BB</label>
                                                            <div class="input-group">
                                                                <input type="number" name="setelah_24_bulan_bb"
                                                                    class="form-control" placeholder="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Status Fungsional
                                                                <br>
                                                                <small class="text-muted">1 = kerja / 2 = ambulatori / 3 =
                                                                    baring</small>
                                                            </label>
                                                            <input type="text" name="setelah_24_bulan_status_fungsional"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">JumlahCD4
                                                                <br><small class="text-muted">(CD4 % pd
                                                                    anak)</small></label>
                                                            <input type="number" name="setelah_24_bulan_cd4"
                                                                class="form-control" placeholder="0">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold">Lain-lain</label>
                                                            <textarea name="setelah_24_bulan_lain" class="form-control"
                                                                rows="2" placeholder="Isi Lainnya..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data api Antiretroviral (ART) -->
                            <div class="card shadow-sm">
                                <div class="section-header">
                                    <h5 class="mb-0">
                                        6. Terapi Antiretroviral (ART)
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <!-- Info Panel -->
                                    <div class="alert alert-info border-0 mb-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <div>
                                                <strong>Petunjuk Pengisian:</strong><br>
                                                <small>Pilih nama paduan ART dan isi data substitusi/switch jika diperlukan.
                                                    Gunakan tombol "Tambah ART Baru" untuk menambah riwayat terapi.</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dynamic ART Sections -->
                                    <div id="artSections">
                                        <!-- Initial ART Section -->
                                        <div class="art-section mb-4" data-section="1">
                                            <div class="card border-start border-primary border-4">
                                                <div class="card-header bg-body-secondary d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0 text-primary">
                                                        <i class="fas fa-pills me-2"></i>
                                                        Terapi ART #1
                                                    </h6>
                                                    <button type="button" class="btn btn-outline-danger btn-sm d-none remove-art-btn" onclick="removeArtSection(1)">
                                                        <i class="fas fa-trash me-1"></i>
                                                        Hapus
                                                    </button>
                                                </div>
                                                <div class="card-body">
                                                    <!-- Nama Paduan ART -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-bold text-dark">Nama Paduan ART Original</label>
                                                            <div class="bg-light-subtle">
                                                                <div class="card-body p-3">
                                                                    <div class="form-check mb-2">
                                                                        <input class="form-check-input" type="radio" name="nama_paduan_art_1" value="TDF+3TC+EFV" id="art1_1">
                                                                        <label class="form-check-label" for="art1_1">
                                                                            1. TDF+3TC+EFV
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check mb-2">
                                                                        <input class="form-check-input" type="radio" name="nama_paduan_art_1" value="TDF+FTC+EFV" id="art2_1">
                                                                        <label class="form-check-label" for="art2_1">
                                                                            2. TDF+FTC+EFV
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check mb-2">
                                                                        <input class="form-check-input" type="radio" name="nama_paduan_art_1" value="TDF+3TC+NVP" id="art3_1">
                                                                        <label class="form-check-label" for="art3_1">
                                                                            3. TDF+3TC+NVP
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check mb-2">
                                                                        <input class="form-check-input" type="radio" name="nama_paduan_art_1" value="TDF+FTC+NVP" id="art4_1">
                                                                        <label class="form-check-label" for="art4_1">
                                                                            4. TDF+FTC+NVP
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check mb-2">
                                                                        <input class="form-check-input" type="radio" name="nama_paduan_art_1" value="AZT+3TC+EFV" id="art5_1">
                                                                        <label class="form-check-label" for="art5_1">
                                                                            5. AZT+3TC+EFV
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check mb-2">
                                                                        <input class="form-check-input" type="radio" name="nama_paduan_art_1" value="AZT+3TC+NVP" id="art6_1">
                                                                        <label class="form-check-label" for="art6_1">
                                                                            6. AZT+3TC+NVP
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check mb-3">
                                                                        <input class="form-check-input" type="radio" name="nama_paduan_art_1" value="lainnya" id="art7_1">
                                                                        <label class="form-check-label" for="art7_1">
                                                                            7. Lainnya
                                                                        </label>
                                                                    </div>
                                                                    <div id="lainnya-art-details-1" class="d-none">
                                                                        <input type="text" name="art_lainnya_1" class="form-control form-control-sm" placeholder="Sebutkan nama paduan ART lainnya">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <label class="form-label fw-bold text-dark">SUBSTITUSI dalam lini-1, SWITCH ke lini-2, STOP</label>
                                                            <div class="row g-3">
                                                                <div class="col-md-4">
                                                                    <label class="form-label fw-bold">Tanggal</label>
                                                                    <input type="date" name="substitusi_tanggal_1" class="form-control">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label fw-bold">Substitusi</label>
                                                                    <input type="text" name="substitusi_1" class="form-control">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label fw-bold">Switch</label>
                                                                    <input type="text" name="switch_1" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="row g-3">
                                                                <div class="col-md-4">
                                                                    <label class="form-label fw-bold">Stop</label>
                                                                    <input type="text" name="stop_1" class="form-control">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label fw-bold">Restart</label>
                                                                    <input type="text" name="restart_1" class="form-control">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label fw-bold">Alasan</label>
                                                                    <select name="alasan_1" class="form-select">
                                                                        <option value="">Pilih alasan</option>
                                                                        <option value="1">1. Toksisitas/efek samping</option>
                                                                        <option value="2">2. Hamil</option>
                                                                        <option value="3">3. Risiko hamil</option>
                                                                        <option value="4">4. TB baru</option>
                                                                        <option value="5">5. Ada obat baru</option>
                                                                        <option value="6">6. Stok obat habis</option>
                                                                        <option value="7">7. Alasan lain</option>
                                                                        <option value="8">8. Gagal pengobatan klinis</option>
                                                                        <option value="9">9. Gagal imunologis</option>
                                                                        <option value="10">10. Gagal virologis</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Nama Paduan Baru</label>
                                                                    <input type="text" name="nama_paduan_baru_1" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Add New ART Button -->
                                    <div class="text-center mb-4">
                                        <button type="button" class="btn btn-success btn-sm" onclick="addArtSection()">
                                            <i class="fas fa-plus-circle me-2"></i>
                                            Tambah ART Baru
                                        </button>
                                    </div>

                                    <!-- Hidden Inputs -->
                                    <input type="hidden" name="data_terapi_art" id="dataARTInput" value="">
                                    <input type="hidden" id="existing-art-data" value="{{ json_encode($existingRecord->data_terapi_art_json ?? []) }}">

                                    <!-- Keterangan Alasan -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="bg-info-subtle border-0">
                                                <div class="card-header">
                                                    <h6 class="mb-0 text-primary">
                                                        <i class="fas fa-info-circle me-2"></i>
                                                        Keterangan Alasan
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <h6 class="text-warning">Alasan Substitusi/Switch:</h6>
                                                            <ul class="list-unstyled small">
                                                                <li><strong>1.</strong> Toksisitas/efek samping</li>
                                                                <li><strong>2.</strong> Hamil</li>
                                                                <li><strong>3.</strong> Risiko hamil</li>
                                                                <li><strong>4.</strong> TB baru</li>
                                                                <li><strong>5.</strong> Ada obat baru</li>
                                                                <li><strong>6.</strong> Stok obat habis</li>
                                                                <li><strong>7.</strong> Alasan lain (uraikan)</li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <h6 class="text-info">Alasan hanya untuk SWITCH:</h6>
                                                            <ul class="list-unstyled small">
                                                                <li><strong>8.</strong> Gagal pengobatan klinis</li>
                                                                <li><strong>9.</strong> Gagal imunologis</li>
                                                                <li><strong>10.</strong> Gagal virologis</li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <h6 class="text-danger">Alasan STOP:</h6>
                                                            <ul class="list-unstyled small">
                                                                <li><strong>1.</strong> Toksisitas/efek samping</li>
                                                                <li><strong>2.</strong> Hamil</li>
                                                                <li><strong>3.</strong> Gagal pengobatan</li>
                                                                <li><strong>4.</strong> Adherens buruk</li>
                                                                <li><strong>5.</strong> Sakit/MRS</li>
                                                                <li><strong>6.</strong> Kekurangan biaya</li>
                                                                <li><strong>7.</strong> Alasan lain</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Pengobatan TB selama perawatan HIV -->
                            <div class="card shadow-sm">
                                <div class="section-header">
                                    <h5 class="mb-0">
                                        7. Pengobatan TB selama perawatan HIV
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <!-- Tanggal Terapi -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tgl. Mulai terapi TB</label>
                                                <input type="date" class="form-control" name="tgl_mulai_terapi_tb"
                                                    placeholder="Pilih tanggal mulai terapi">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tgl. Selesai terapi TB</label>
                                                <input type="date" class="form-control" name="tgl_selesai_terapi_tb"
                                                    placeholder="Pilih tanggal selesai terapi">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form Grid -->
                                    <div class="row g-4">
                                        <!-- Klasifikasi TB -->
                                        <div class="col-md-6">
                                            <div class="border-start">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0 text-warning">
                                                        <i class="fas fa-lungs me-2"></i>
                                                        Klasifikasi TB (pilih)
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="klasifikasi_tb"
                                                            value="tb_paru" id="tb_paru">
                                                        <label class="form-check-label fw-bold" for="tb_paru">
                                                            <i class="fas fa-lungs text-danger me-2"></i>
                                                            1. TB Paru
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="klasifikasi_tb"
                                                            value="tb_ekstra_paru" id="tb_ekstra_paru">
                                                        <label class="form-check-label fw-bold" for="tb_ekstra_paru">
                                                            <i class="fas fa-user-injured text-warning me-2"></i>
                                                            2. TB Ekstra Paru
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="klasifikasi_tb"
                                                            value="tidak_ada" id="tidak_ada">
                                                        <label class="form-check-label fw-bold" for="tidak_ada">
                                                            <i class="fas fa-times-circle text-success me-2"></i>
                                                            Tidak Ada
                                                        </label>
                                                    </div>
                                                    <div id="lokasi_tb_ekstra" class="d-none mt-3">
                                                        <label class="form-label fw-bold text-warning">Lokasi TB Ekstra
                                                            Paru:</label>
                                                        <input type="text" name="lokasi_tb_ekstra" class="form-control"
                                                            placeholder="Sebutkan lokasi TB ekstra paru">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Paduan TB -->
                                        <div class="col-md-6">
                                            <div class="border-start">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0 text-success">
                                                        <i class="fas fa-pills me-2"></i>
                                                        Paduan TB
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="paduan_tb"
                                                            value="kategori_1" id="kategori_1">
                                                        <label class="form-check-label fw-bold" for="kategori_1">
                                                            <span class="badge bg-success me-2">1</span>
                                                            Kategori I
                                                            <i class="fas fa-info-circle text-muted ms-2"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Untuk TB baru (belum pernah diobati)"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="paduan_tb"
                                                            value="kategori_2" id="kategori_2">
                                                        <label class="form-check-label fw-bold" for="kategori_2">
                                                            <span class="badge bg-warning me-2">2</span>
                                                            Kategori II
                                                            <i class="fas fa-info-circle text-muted ms-2"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Untuk TB kambuh/putus berobat"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="paduan_tb"
                                                            value="kategori_anak" id="kategori_anak">
                                                        <label class="form-check-label fw-bold" for="kategori_anak">
                                                            <span class="badge bg-info me-2">3</span>
                                                            Kategori Anak
                                                            <i class="fas fa-info-circle text-muted ms-2"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Untuk pasien anak - Dosis disesuaikan dengan berat badan"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="paduan_tb"
                                                            value="oat_lini_2" id="oat_lini_2">
                                                        <label class="form-check-label fw-bold" for="oat_lini_2">
                                                            <span class="badge bg-danger me-2">4</span>
                                                            OAT Lini 2 (MDR)
                                                            <i class="fas fa-info-circle text-muted ms-2"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Untuk TB resistan obat - Pengobatan khusus dengan obat lini kedua"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tipe TB -->
                                        <div class="col-md-6">
                                            <div class="border-start">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0 text-primary">
                                                        <i class="fas fa-stethoscope me-2"></i>
                                                        Tipe TB
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="tipe_tb"
                                                            value="baru" id="tb_baru">
                                                        <label class="form-check-label fw-bold" for="tb_baru">
                                                            <i class="fas fa-plus-circle text-success me-2"></i>
                                                            1. Baru
                                                            <i class="fas fa-info-circle text-muted ms-2"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Belum pernah diobati sebelumnya atau sudah diobati kurang dari 1 bulan"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="tipe_tb"
                                                            value="kambuh" id="tb_kambuh">
                                                        <label class="form-check-label fw-bold" for="tb_kambuh">
                                                            <i class="fas fa-redo text-warning me-2"></i>
                                                            2. Kambuh
                                                            <i class="fas fa-info-circle text-muted ms-2"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Sudah sembuh dari TB sebelumnya, kemudian sakit TB lagi"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="tipe_tb"
                                                            value="default" id="tb_default">
                                                        <label class="form-check-label fw-bold" for="tb_default">
                                                            <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                                                            3. Default
                                                            <i class="fas fa-info-circle text-muted ms-2"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Putus berobat lebih dari 2 bulan berturut-turut"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="tipe_tb"
                                                            value="gagal" id="tb_gagal">
                                                        <label class="form-check-label fw-bold" for="tb_gagal">
                                                            <i class="fas fa-times-circle text-danger me-2"></i>
                                                            4. Gagal
                                                            <i class="fas fa-info-circle text-muted ms-2"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Tidak sembuh setelah menjalani pengobatan lengkap sesuai kategori"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tempat Pengobatan -->
                                        <div class="col-md-6">
                                            <div class="border-start">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0 text-info">
                                                        <i class="fas fa-hospital me-2"></i>
                                                        Tempat Pengobatan TB
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold">Kabupaten:</label>
                                                            <input type="text" name="kabupaten_tb" class="form-control"
                                                                placeholder="Nama kabupaten tempat pengobatan">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold">Nama Sarana Kesehatan:</label>
                                                            <input type="text" name="nama_sarana_kesehatan"
                                                                class="form-control"
                                                                placeholder="Nama Puskesmas/RS tempat pengobatan">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold">No Reg TB
                                                                Kabupaten/Kota:</label>
                                                            <input type="text" name="no_reg_tb" class="form-control"
                                                                placeholder="Nomor registrasi TB">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <!-- Data Indiksi Inisiasi ART -->
                            <div class="card shadow-sm">
                                <div class="section-header">
                                    <h5 class="mb-0">
                                        8. Indikasi Inisiasi ART
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <!-- Info Panel -->
                                    <div class="alert alert-info border-0 mb-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <div>
                                                <strong>Petunjuk Pengisian:</strong><br>
                                                <small>Pilih salah satu indikasi yang sesuai dengan kondisi pasien untuk
                                                    memulai terapi ART.</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Radio Button Options -->
                                    <div class="row">
                                        <!-- Baris 1 -->
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check p-3 border rounded">
                                                <input class="form-check-input" type="radio" name="indikasi_inisiasi_art"
                                                    value="penasun" id="penasun">
                                                <label class="form-check-label fw-bold" for="penasun">
                                                    <i class="fas fa-syringe text-danger me-2"></i>
                                                    Penasun
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-check p-3 border rounded">
                                                <input class="form-check-input" type="radio" name="indikasi_inisiasi_art"
                                                    value="lsl" id="lsl">
                                                <label class="form-check-label fw-bold" for="lsl">
                                                    <i class="fas fa-male text-info me-2"></i>
                                                    LSL
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-check p-3 border rounded">
                                                <input class="form-check-input" type="radio" name="indikasi_inisiasi_art"
                                                    value="pasien_ko_infeksi_tb_hiv" id="pasien_ko_infeksi_tb_hiv">
                                                <label class="form-check-label fw-bold" for="pasien_ko_infeksi_tb_hiv">
                                                    <i class="fas fa-lungs text-danger me-2"></i>
                                                    Pasien Ko-Infeksi TB-HIV
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Baris 2 -->
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check p-3 border rounded">
                                                <input class="form-check-input" type="radio" name="indikasi_inisiasi_art"
                                                    value="wps" id="wps">
                                                <label class="form-check-label fw-bold" for="wps">
                                                    <i class="fas fa-female text-warning me-2"></i>
                                                    WPS
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-check p-3 border rounded">
                                                <input class="form-check-input" type="radio" name="indikasi_inisiasi_art"
                                                    value="waria" id="waria">
                                                <label class="form-check-label fw-bold" for="waria">
                                                    <i class="fas fa-transgender text-info me-2"></i>
                                                    Waria
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-check p-3 border rounded">
                                                <input class="form-check-input" type="radio" name="indikasi_inisiasi_art"
                                                    value="pasien_ko_infeksi_hepatitis_b_hiv"
                                                    id="pasien_ko_infeksi_hepatitis_b_hiv">
                                                <label class="form-check-label fw-bold"
                                                    for="pasien_ko_infeksi_hepatitis_b_hiv">
                                                    <i class="fas fa-virus text-warning me-2"></i>
                                                    Pasien Ko-Infeksi Hepatitis B-HIV
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Baris 3 -->
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check p-3 border rounded">
                                                <input class="form-check-input" type="radio" name="indikasi_inisiasi_art"
                                                    value="odha_dengan_pasangan_negatif" id="odha_dengan_pasangan_negatif">
                                                <label class="form-check-label fw-bold" for="odha_dengan_pasangan_negatif">
                                                    <i class="fas fa-heart text-danger me-2"></i>
                                                    ODHA dengan Pasangan Negatif
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-check p-3 border rounded">
                                                <input class="form-check-input" type="radio" name="indikasi_inisiasi_art"
                                                    value="ibu_hamil" id="ibu_hamil">
                                                <label class="form-check-label fw-bold" for="ibu_hamil">
                                                    <i class="fas fa-baby text-success me-2"></i>
                                                    Ibu Hamil
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="form-check p-3 border rounded">
                                                <input class="form-check-input" type="radio" name="indikasi_inisiasi_art"
                                                    value="lainnya" id="lainnya_indikasi">
                                                <label class="form-check-label fw-bold" for="lainnya_indikasi">
                                                    <i class="fas fa-plus-circle text-secondary me-2"></i>
                                                    Lainnya (Stadium Klinis 3 atau 4 / CD4&lt;350)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Form Buttons -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.modal-create-alergi')
    @include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.modal-datakeluarga-mitra')
@endsection
