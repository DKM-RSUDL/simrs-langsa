@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-section {
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
        }

        .section-header {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-bottom: 1px solid #dee2e6;
            font-weight: bold;
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .patient-id-boxes {
            display: flex;
            gap: 5px;
        }

        .id-box {
            width: 30px;
            height: 30px;
            text-align: center;
            border: 1px solid #ccc;
        }

        .vital-signs-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .vital-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Animation styles */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .was-validated .form-control:invalid {
            border-color: #dc3545;
        }

        .was-validated .form-control:valid {
            border-color: #198754;
        }
    </style>
@endpush

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
                                            <label class="form-label">NIK</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="nik"
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
                                            <label class="form-label">Alamat dan No. Telp. Pasien</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="alamat_telp" rows="2"
                                                placeholder="Alamat dan No. Telp. Pasien"></textarea>
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
                                            <label class="form-label">Alamat dan No. Telp. PMO</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="alamat_no_telp_pmo"
                                                placeholder="Alamat dan No. Telp. PMO">
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
                                                <input class="form-check-input" type="checkbox" value="kia" id="kia"
                                                    name="entry_point[]">
                                                <label class="form-check-label" for="kia">
                                                    1. KIA
                                                </label>
                                            </div>

                                            <!-- 2-Rujukan Jalan dengan input tambahan -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="rujukan_jalan_tb"
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
                                                <input class="form-check-input" type="checkbox" value="rujukan_rawat_inap"
                                                    id="kia_rawat_inap" name="kia_details[]">
                                                <label class="form-check-label" for="kia_rawat_inap">
                                                    3. Rawat Inap
                                                </label>
                                            </div>

                                            <!-- 4-Praktek Swasta -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="praktek_swasta"
                                                    id="kia_praktek_swasta" name="kia_details[]">
                                                <label class="form-check-label" for="kia_praktek_swasta">
                                                    4. Praktek Swasta
                                                </label>
                                            </div>

                                            <!-- 5-Jangkauan dengan input tambahan -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="jangkauan"
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
                                                <input class="form-check-input" type="checkbox" value="lsm" id="kia_lsm"
                                                    name="kia_details[]">
                                                <label class="form-check-label" for="kia_lsm">
                                                    6. LSM
                                                </label>
                                            </div>

                                            <!-- 7-Datang sendiri -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="datang_sendiri"
                                                    id="kia_datang_sendiri" name="kia_details[]">
                                                <label class="form-check-label" for="kia_datang_sendiri">
                                                    7. Datang sendiri
                                                </label>
                                            </div>

                                            <!-- 8-Lainnya dengan input tambahan -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="lainnya_uraikan"
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
                                                <option value="sma">SMA</option>
                                                <option value="smp">SMP</option>
                                                <option value="sd">SD</option>
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
                                                <option value="tni">TNI</option>
                                                <option value="IT">IT</option>
                                                <option value="dokter">Dokter</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Faktor Risiko</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" name="faktor_risiko">
                                                <option value="">--pilih--</option>
                                                <option value="Seks Vaginal Berisiko">Seks Vaginal Berisiko</option>
                                                <option value="Seks Anal Berisiko">Seks Anal Berisiko</option>
                                                <option value="Perinatal">Perinatal</option>
                                                <option value="Transfusi Darah">Transfusi Darah</option>
                                                <option value="NAPZA Suntik">NAPZA Suntik</option>
                                                <option value="Lain-lainnya">lain-lainnya</option>
                                            </select>
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
                                                            <th width="15%">HIV</th>
                                                            <th width="15%">ART</th>
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
                                            <label class="form-label">Pernah Menerima ART</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="menerima_art1" value="Ya"
                                                    name="menerima_art">
                                                <label class="form-check-label" for="menerima_art1">Ya</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="menerima_art2"
                                                    value="Tidak" name="menerima_art">
                                                <label class="form-check-label" for="menerima_art2">Tidak</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Jika ya -->
                                    <div class="row mb-3" id="art_details" style="display: none;">
                                        <div class="col-md-3">
                                            <label class="form-label">Jika ya</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="ppia" value="1-Pinjam"
                                                    name="jenis_art[]">
                                                <label class="form-check-label" for="ppia">1.PPIA</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="art" value="2-ART"
                                                    name="jenis_art[]">
                                                <label class="form-check-label" for="art">2.ART</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="ppp" value="3-PMTCT"
                                                    name="jenis_art[]">
                                                <label class="form-check-label" for="ppp">3.PPP</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3" id="jenis_tempat_row" style="display: none;">
                                        <div class="col-md-3">
                                            <label class="form-label">Tempat ART Dulu</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="rs_pemerintah"
                                                    value="RS Pemerintah" name="jenis_tempat">
                                                <label class="form-check-label" for="rs_pemerintah">1.Rs Pemerintah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="rs_swasta"
                                                    value="RS Swasta" name="jenis_tempat">
                                                <label class="form-check-label" for="rs_swasta">2.Rs Swasta </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="pkm" value="pkm"
                                                    name="jenis_tempat">
                                                <label class="form-check-label" for="pkm">3.PKM</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Jenis ART -->
                                    <div class="row mb-3" id="obat_art_row" style="display: none;">
                                        <div class="col-md-3">
                                            <label class="form-label">Jenis ART</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" name="obat_art">
                                                <option value="">Pilih Jenis ART</option>
                                                <option value="TDF+3TC+EFV">TDF+3TC+EFV</option>
                                                <option value="AZT+3TC+NVP">AZT+3TC+NVP</option>
                                                <option value="AZT+3TC+EFV">AZT+3TC+EFV</option>
                                                <option value="TDF+3TC+NVP">TDF+3TC+NVP</option>
                                                <option value="ABC+3TC+EFV">ABC+3TC+EFV</option>
                                                <option value="TDF+FTC+EFV">TDF+FTC+EFV</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Jenis ART Lainnya -->
                                    <div class="row mb-3" id="obat_art_lainnya_row" style="display: none;">
                                        <div class="col-md-3">
                                            <label class="form-label">Sebutkan Jenis ART Lainnya</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="obat_art_lainnya"
                                                placeholder="Sebutkan jenis ART lainnya">
                                        </div>
                                    </div>

                                    <!-- Lama Penggunaannya -->
                                    <div class="row mb-3" id="lama_penggunaannya_row" style="display: none;">
                                        <div class="col-md-3">
                                            <label class="form-label">Lama Penggunaannya</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="lama_penggunaannya" rows="3"
                                                placeholder="Sebutkan alasan putus terapi (jika ada)"></textarea>
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
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.modal-create-alergi')
    @include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.modal-datakeluarga-mitra')
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM loaded, initializing scripts...');

            // ===== BAGIAN 1: Entry Point Handlers =====
            function handleCheckboxWithDetails(checkboxId, detailsId) {
                const checkbox = document.getElementById(checkboxId);
                const details = document.getElementById(detailsId);

                console.log('Setting up handler for:', checkboxId, detailsId);
                console.log('Checkbox found:', checkbox);
                console.log('Details found:', details);

                if (checkbox && details) {
                    checkbox.addEventListener('change', function () {
                        console.log('Checkbox changed:', checkboxId, this.checked);
                        if (this.checked) {
                            details.classList.remove('d-none');
                        } else {
                            details.classList.add('d-none');
                            const textarea = details.querySelector('textarea');
                            if (textarea) {
                                textarea.value = '';
                            }
                        }
                    });
                } else {
                    console.warn('Element not found:', checkboxId, detailsId);
                }
            }

            // Initialize entry point handlers
            handleCheckboxWithDetails('kia_rujukan_jalan_tb', 'rujukan-details');
            handleCheckboxWithDetails('kia_jangkauan', 'jangkauan-details');
            handleCheckboxWithDetails('kia_lainnya', 'lainnya-kia-details');
        });

        // Bagian : 4. Riwayat Terapi Antiretroviral
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Riwayat Terapi Antiretroviral script initialized');

            // Handle radio button change for "Pernah Menerima ART"
            const artRadios = document.querySelectorAll('input[name="menerima_art"]');
            const artDetails = document.getElementById('art_details');
            const jenisTempatRow = document.getElementById('jenis_tempat_row');
            const obatArtRow = document.getElementById('obat_art_row');
            const obatArtLainnyaRow = document.getElementById('obat_art_lainnya_row');
            const alasanPutusRow = document.getElementById('lama_penggunaannya_row');

            // Function to show/hide ART details
            function toggleArtDetails(show) {
                const rows = [artDetails, jenisTempatRow, obatArtRow, alasanPutusRow];

                rows.forEach(row => {
                    if (row) { // Check if element exists
                        if (show) {
                            row.style.display = 'flex';
                        } else {
                            row.style.display = 'none';
                            // Clear form values when hiding
                            const inputs = row.querySelectorAll('input, select, textarea');
                            inputs.forEach(input => {
                                if (input.type === 'checkbox' || input.type === 'radio') {
                                    input.checked = false;
                                } else {
                                    input.value = '';
                                }
                            });
                        }
                    }
                });

                // Always hide "Lainnya" row initially when toggling
                if (obatArtLainnyaRow && !show) {
                    obatArtLainnyaRow.style.display = 'none';
                }
            }

            // Add event listeners to ART radio buttons
            artRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    console.log('ART radio changed:', this.value);
                    if (this.value === 'Ya') {
                        toggleArtDetails(true);
                    } else {
                        toggleArtDetails(false);
                    }
                });
            });

            // Handle "Jenis ART" dropdown change
            const obatArtSelect = document.querySelector('select[name="obat_art"]');
            if (obatArtSelect) {
                obatArtSelect.addEventListener('change', function () {
                    console.log('Jenis ART changed:', this.value);
                    if (this.value === 'Lainnya') {
                        if (obatArtLainnyaRow) {
                            obatArtLainnyaRow.style.display = 'flex';
                        }
                    } else {
                        if (obatArtLainnyaRow) {
                            obatArtLainnyaRow.style.display = 'none';
                            const lainnyaInput = document.querySelector('input[name="obat_art_lainnya"]');
                            if (lainnyaInput) {
                                lainnyaInput.value = '';
                            }
                        }
                    }
                });
            }

            // Debug: Log all required elements
            console.log('Elements found:');
            console.log('- artDetails:', artDetails);
            console.log('- jenisTempatRow:', jenisTempatRow);
            console.log('- obatArtRow:', obatArtRow);
            console.log('- obatArtLainnyaRow:', obatArtLainnyaRow);
            console.log('- alasanPutusRow:', alasanPutusRow);
            console.log('- obatArtSelect:', obatArtSelect);

            console.log('Riwayat Terapi Antiretroviral script initialized successfully');
        });
    </script>
@endpush