@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-medis-neonatologi.create-include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-asesmen-tht')
        </div>

        <div class="col-md-9">
            <x-content-card>
            <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Asesmen Pengkajian Awal Medis Neonatologi Bayi Sakit',
                    'description' => 'Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan',
                ])

            <form method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="kd_pasien" value="{{ $dataMedis->kd_pasien }}">
                <input type="hidden" name="kd_unit" value="{{ $dataMedis->kd_unit }}">
                <input type="hidden" name="tgl_masuk" value="{{ $dataMedis->tgl_masuk }}">
                <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">

                <div class="section-separator mt-0" id="data-masuk">
                    <h5 class="section-title">1. Data masuk</h5>

                    <div class="form-group">
                        <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                        <div class="d-flex gap-3" style="width: 100%;">
                            <input type="date" class="form-control" name="tanggal"
                                value="{{ date('Y-m-d') }}">
                            <input type="time" class="form-control" name="jam"
                                value="{{ date('H:i') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="min-width: 200px;">Nama keluarga yang bisa </br> dihubungi No Hp/
                            Telp</label>
                        <div class="d-flex gap-3" style="width: 100%;">
                            <input type="text" class="form-control" name="no_hp">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="min-width: 200px; vertical-align: top;">Transportasi waktu
                                    datang:</label>
                                <div class="mt-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="transportasi[]"
                                            id="kendaraan_pribadi" value="kendaraan_pribadi">
                                        <label class="form-check-label" for="kendaraan_pribadi">
                                            Kendaraan pribadi
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="transportasi[]"
                                            id="ambulance" value="ambulance">
                                        <label class="form-check-label" for="ambulance">
                                            Ambulance
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="transportasi[]"
                                            id="kendaraan_lainnya" value="kendaraan_lainnya">
                                        <label class="form-check-label" for="kendaraan_lainnya">
                                            Kendaraan lainnya:
                                        </label>
                                        <input type="text" class="form-control mt-2"
                                            name="kendaraan_lainnya_detail" placeholder="Sebutkan lainnya">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-separator" id="alergi">
                    <h5 class="section-title">2. Alergi</h5>
                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3" id="openAlergiModal"
                        data-bs-toggle="modal" data-bs-target="#alergiModal">
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
                                    <td colspan="5" class="text-center text-muted">Tidak ada data alergi
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @push('modals')
                        @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-medis-neonatologi.modal-create-alergi')
                    @endpush
                </div>

                <div class="section-separator" id="">
                    <h5 class="section-title">3. Anamnesis</h5>

                    <div class="form-group">
                        <label style="min-width: 200px;">Anamnesis</label>
                        <textarea class="form-control" name="anamnesis" rows="3" placeholder="Anamnesis"></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="min-width: 200px; vertical-align: top;">Lahir:</label>
                                <div class="mt-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="lahir"
                                            id="lahir_rsudlangsa" value="1">
                                        <label class="form-check-label" for="lahir_rsudlangsa">
                                            Lahir di RSU Langsa
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="lahir"
                                            id="lahir_rs_lain" value="0">
                                        <label class="form-check-label" for="lahir_rs_lain">
                                            Luar RSU Langsa:
                                        </label>
                                    </div>
                                    <input type="text" class="form-control mt-2" name="lahir_rs_lain"
                                        placeholder="Sebutkan lainnya">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="min-width: 200px;">Keluhan Bayi</label>
                        <textarea class="form-control" name="keluahan_bayi" rows="3" placeholder="Keluhan Bayi"></textarea>
                    </div>

                </div>

                <div class="section-separator" id="riwayat-antenatal">
                    <h5 class="section-title">4. Riwayat Antenatal</h5>

                    <div class="container-fluid">
                        <!-- Anak ke -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Anak ke:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" class="form-control" name="anak_ke" min="1"
                                    placeholder="1">
                            </div>
                        </div>

                        <!-- ANC -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">ANC:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="anc"
                                        id="anc_tidak" value="0">
                                    <label class="form-check-label" for="anc_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="anc"
                                        id="anc_ya" value="1">
                                    <label class="form-check-label" for="anc_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- USG -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">USG:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="usg_kali"
                                    placeholder="Berapa kali">
                            </div>
                        </div>

                        <!-- HPHT -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">HPHT:</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="hpht_tanggal">
                            </div>
                        </div>

                        <!-- Taksiran persalinan -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Taksiran persalinan:</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="taksiran_tanggal">
                            </div>
                        </div>

                        <!-- Nyeri BAK -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Nyeri BAK:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="nyeri_bak"
                                        id="nyeri_bak_tidak" value="0">
                                    <label class="form-check-label" for="nyeri_bak_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="nyeri_bak"
                                        id="nyeri_bak_ya" value="1">
                                    <label class="form-check-label" for="nyeri_bak_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Keputihan -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Keputihan:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="keputihan"
                                        id="keputihan_tidak" value="0">
                                    <label class="form-check-label" for="keputihan_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="keputihan"
                                        id="keputihan_ya" value="1">
                                    <label class="form-check-label" for="keputihan_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Header Riwayat Intranatal -->
                        <div class="row mb-3 mt-4">
                            <div class="col-12">
                                <h6 class="text-center bg-secondary text-white p-2 mb-0">Riwayat Intranatal
                                </h6>
                            </div>
                        </div>

                        <!-- Perdarahan -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Perdarahan:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="perdarahan"
                                        id="perdarahan_tidak" value="0">
                                    <label class="form-check-label" for="perdarahan_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="perdarahan"
                                        id="perdarahan_ya" value="1">
                                    <label class="form-check-label" for="perdarahan_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Ketuban pecah -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Ketuban pecah:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ketuban_pecah"
                                        id="ketuban_tidak" value="0">
                                    <label class="form-check-label" for="ketuban_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ketuban_pecah"
                                        id="ketuban_ya" value="1">
                                    <label class="form-check-label" for="ketuban_ya">Ya</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <input type="time" class="form-control" name="ketuban_jam"
                                    placeholder="Jam">
                            </div>
                        </div>

                        <!-- Gawat janin -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Gawat janin:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gawat_janin"
                                        id="gawat_janin_tidak" value="0">
                                    <label class="form-check-label" for="gawat_janin_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gawat_janin"
                                        id="gawat_janin_ya" value="1">
                                    <label class="form-check-label" for="gawat_janin_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Demam -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Demam:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="demam"
                                        id="demam_tidak" value="0">
                                    <label class="form-check-label" for="demam_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="demam"
                                        id="demam_ya" value="1">
                                    <label class="form-check-label" for="demam_ya">Ya</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="demam_suhu"
                                        placeholder="36.5">
                                    <span class="input-group-text">°C</span>
                                </div>
                            </div>
                        </div>

                        <!-- Riwayat terapi deksametason -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Riwayat terapi deksametason:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="terapi_deksametason"
                                        id="deksametason_tidak" value="0">
                                    <label class="form-check-label" for="deksametason_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="terapi_deksametason"
                                        id="deksametason_ya" value="1">
                                    <label class="form-check-label" for="deksametason_ya">Ya</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="deksametason_kali"
                                        min="0" placeholder="0">
                                    <span class="input-group-text">kali</span>
                                </div>
                            </div>
                        </div>

                        <!-- Riwayat terapi lain -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Riwayat terapi lain:</label>
                            </div>
                            <div class="col-md-8">
                                <textarea class="form-control" name="terapi_lain" rows="3"
                                    placeholder="Sebutkan riwayat terapi lainnya jika ada..."></textarea>
                            </div>
                        </div>

                        <!-- Header Riwayat Penyakit Ibu -->
                        <div class="row mb-3 mt-4">
                            <div class="col-12">
                                <h6 class="text-center bg-secondary text-white p-2 mb-0">Riwayat Penyakit Ibu
                                </h6>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="riwayat_penyakit_ibu[]" id="riwayat_penyakit_ibu_dm"
                                        value="dm">
                                    <label class="form-check-label" for="riwayat_penyakit_ibu_dm">DM</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="riwayat_penyakit_ibu[]" id="riwayat_penyakit_ibu_hepatitis"
                                        value="hepatitisb">
                                    <label class="form-check-label"
                                        for="riwayat_penyakit_ibu_hepatitis">Hepatitis B</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="riwayat_penyakit_ibu[]" id="riwayat_penyakit_ibu_ekimosis"
                                        value="ekimosis">
                                    <label class="form-check-label"
                                        for="riwayat_penyakit_ibu_ekimosis">Ekimosis</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="riwayat_penyakit_ibu[]" id="riwayat_penyakit_ibu_tb"
                                        value="tb">
                                    <label class="form-check-label" for="riwayat_penyakit_ibu_tb">TB</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="riwayat_penyakit_ibu[]" id="riwayat_penyakit_ibu_hypertensi"
                                        value="hypertensi">
                                    <label class="form-check-label"
                                        for="riwayat_penyakit_ibu_hypertensi">Hypertensi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="riwayat_penyakit_ibu[]" id="riwayat_penyakit_ibu_hiv"
                                        value="hiv_aids">
                                    <label class="form-check-label" for="riwayat_penyakit_ibu_hiv">HIV/
                                        AIDS</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="riwayat_penyakit_ibu[]" id="riwayat_penyakit_ibu_jantung"
                                        value="jantung">
                                    <label class="form-check-label"
                                        for="riwayat_penyakit_ibu_jantung">Jantung</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="riwayat_penyakit_ibu[]" id="riwayat_penyakit_ibu_asthma"
                                        value="asthma">
                                    <label class="form-check-label"
                                        for="riwayat_penyakit_ibu_asthma">Asthma</label>
                                </div>
                            </div>
                            <label class="form-check-label mt-2" for="lainnya">Lainnya</label>
                            <input type="text" class="form-control" name="riwayat_penyakit_ibu_lain"
                                placeholder="lainnya">
                        </div>

                    </div>
                </div>

                <div class="section-separator" id="pemeriksaan-fisik">
                    <h5 class="section-title">5. Pemeriksaan Fisik</h5>
                    <h6>ST. PRESENT</h6>

                    <div class="container-fluid">
                        <!-- Postur tubuh -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Postur tubuh:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="postur_tubuh"
                                    placeholder="Jelaskan postur tubuh pasien">
                            </div>
                        </div>

                        <!-- Tangis -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Tangis:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="tangis"
                                    placeholder="Jelaskan kondisi tangisan">
                            </div>
                        </div>

                        <!-- Anemia -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Anemia:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="anemia"
                                        id="anemia_tidak" value="0">
                                    <label class="form-check-label" for="anemia_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="anemia"
                                        id="anemia_ya" value="1">
                                    <label class="form-check-label" for="anemia_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Dispnoe -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Dispnoe:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="dispnoe"
                                        id="dispnoe_tidak" value="0">
                                    <label class="form-check-label" for="dispnoe_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="dispnoe"
                                        id="dispnoe_ya" value="1">
                                    <label class="form-check-label" for="dispnoe_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Edema -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Edema:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="edema"
                                        id="edema_tidak" value="0">
                                    <label class="form-check-label" for="edema_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="edema"
                                        id="edema_ya" value="1">
                                    <label class="form-check-label" for="edema_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Ikterik -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Ikterik:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ikterik"
                                        id="ikterik_tidak" value="0">
                                    <label class="form-check-label" for="ikterik_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ikterik"
                                        id="ikterik_ya" value="1">
                                    <label class="form-check-label" for="ikterik_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Sianosis -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Sianosis:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sianosis"
                                        id="sianosis_tidak" value="0">
                                    <label class="form-check-label" for="sianosis_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sianosis"
                                        id="sianosis_ya" value="1">
                                    <label class="form-check-label" for="sianosis_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Denyut jantung -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Denyut jantung:</label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="denyut_jantung"
                                        placeholder="0">
                                    <span class="input-group-text">x/mnt</span>
                                </div>
                            </div>
                        </div>

                        <!-- Nadi -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Nadi:</label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="nadi"
                                        placeholder="0">
                                    <span class="input-group-text">x/mnt</span>
                                </div>
                            </div>
                        </div>

                        <!-- Respirasi -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Respirasi:</label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="respirasi"
                                        placeholder="0">
                                    <span class="input-group-text">x/mnt</span>
                                </div>
                            </div>
                        </div>

                        <!-- SpO -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">SpO:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" class="form-control" name="spo" placeholder="0">
                            </div>
                        </div>

                        <!-- Merintih -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Merintih:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="merintih"
                                        id="merintih_tidak" value="0">
                                    <label class="form-check-label" for="merintih_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="merintih"
                                        id="merintih_ya" value="1">
                                    <label class="form-check-label" for="merintih_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Temperatur -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Temperatur:</label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="temperatur"
                                        step="0.1" placeholder="36.5">
                                    <span class="input-group-text">°C</span>
                                </div>
                            </div>
                        </div>

                        <!-- BBL/PBL -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">BBL/PBL:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="bbl_pbl"
                                    placeholder="Berat badan lahir / Panjang badan lahir">
                            </div>
                        </div>

                        <!-- LK/LD -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">LK/LD:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="lk_ld"
                                    placeholder="Lingkar kepala / Lingkar dada">
                            </div>
                        </div>

                        <!-- BB sekarang -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">BB sekarang:</label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="bb_sekarang"
                                        step="0.01" min="0" placeholder="0.00">
                                    <span class="input-group-text">kg</span>
                                </div>
                            </div>
                        </div>

                        <!-- PB sekarang -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">PB sekarang:</label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="pb_sekarang"
                                        step="0.1" min="0" placeholder="0.0">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                        </div>

                        <!-- LK sekarang -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">LK sekarang:</label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="lk_sekarang"
                                        step="0.1" min="0" placeholder="0.0">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                        </div>

                        <!-- Bollard score -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Bollard score:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" class="form-control" name="bollard_score"
                                    min="0" placeholder="0">
                            </div>
                        </div>

                        <!-- Skor nyeri -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Skor nyeri:</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="skor_nyeri"
                                        id="skor_nyeri_5" value="<5">
                                    <label class="form-check-label" for="skor_nyeri_5">
                                        < 5</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="skor_nyeri"
                                        id="skor_nyeri_5_9" value="5-9">
                                    <label class="form-check-label" for="skor_nyeri_5_9">5-9</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="skor_nyeri"
                                        id="skor_nyeri_10" value=">=10">
                                    <label class="form-check-label" for="skor_nyeri_10">>= 10</label>
                                </div>
                            </div>
                        </div>

                        <!-- Down score -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Down score:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="down_score"
                                    placeholder="Masukkan down score">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. Status Generalis -->
                <div class="section-separator" id="pemeriksaan-fisik">
                    <h5 class="section-title">6. Status Generalis</h5>
                    <div class="card-body">

                        <!-- 1. Kepala -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">1. KEPALA</h6>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">a. Bentuk:</label>
                                <input type="text" class="form-control" name="kepala_bentuk"
                                    placeholder="Normal/Abnormal">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">b. UUB:</label>
                                <input type="text" class="form-control" name="kepala_uub"
                                    placeholder="Datar/Cembung/Cekung">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">c. UUK:</label>
                                <input type="text" class="form-control" name="kepala_uuk"
                                    placeholder="Terbuka/Tertutup">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">d. Caput sucedaneum:</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="caput_sucedaneum" id="caput_tidak" value="0">
                                        <label class="form-check-label" for="caput_tidak">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="caput_sucedaneum" id="caput_ya" value="1">
                                        <label class="form-check-label" for="caput_ya">Ya</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">e. Cephalohematom:</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cephalohematom"
                                            id="cepha_tidak" value="0">
                                        <label class="form-check-label" for="cepha_tidak">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cephalohematom"
                                            id="cepha_ya" value="1">
                                        <label class="form-check-label" for="cepha_ya">Ya</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Ø:</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="kepala_lp"
                                        step="0.1" placeholder="0">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">f. Lainnya:</label>
                                <input type="text" class="form-control" name="kepala_lain"
                                    placeholder="Isi keterangan lainnya">
                            </div>
                        </div>

                        <hr>

                        <!-- 2. Mata -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">2. MATA</h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="mata_pucat"
                                            id="mata_pucat" value="1">
                                        <label class="form-check-label" for="mata_pucat">Pucat</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="mata_ikterik"
                                            id="mata_ikterik" value="1">
                                        <label class="form-check-label" for="mata_ikterik">Ikterik</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pupil:</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pupil"
                                            id="pupil_isokor" value="isokor">
                                        <label class="form-check-label" for="pupil_isokor">Isokor</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pupil"
                                            id="pupil_anisokor" value="anisokor">
                                        <label class="form-check-label" for="pupil_anisokor">Anisokor</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Refleks Cahaya:</label>
                                <input type="text" class="form-control" name="refleks_cahaya"
                                    placeholder="( ... / ... )">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Refleks Kornea:</label>
                                <input type="text" class="form-control" name="refleks_kornea"
                                    placeholder="( ... / ... )">
                            </div>

                        </div>

                        <hr>

                        <!-- 3. Hidung -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">3. HIDUNG</h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nafas cuping hidung:</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="nafas_cuping"
                                            id="nafas_cuping_ya" value="1">
                                        <label class="form-check-label" for="nafas_cuping_ya">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="nafas_cuping"
                                            id="nafas_cuping_tidak" value="0">
                                        <label class="form-check-label" for="nafas_cuping_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lain-lain:</label>
                                <input type="text" class="form-control" name="hidung_lain"
                                    placeholder="Lainnya">
                            </div>
                        </div>

                        <hr>

                        <!-- 4. Telinga -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">4. TELINGA</h6>
                            </div>

                            <div class="col-12 mb-3">
                                <input type="text" class="form-control" name="telinga_keterangan"
                                    placeholder="Masukkan keterangan telinga">
                            </div>
                        </div>

                        <hr>

                        <!-- 5. Mulut -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">5. Mulut</h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Bibir/lidah sianosis:</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mulut_sianosis"
                                            id="mulut_sianosis_ya" value="1">
                                        <label class="form-check-label" for="mulut_sianosis_ya">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mulut_sianosis"
                                            id="mulut_sianosis_tidak" value="0">
                                        <label class="form-check-label"
                                            for="mulut_sianosis_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lidah:</label>
                                <input type="text" class="form-control" name="mulut_lidah"
                                    placeholder="Isi keterangan lidah">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tenggorokan:</label>
                                <input type="text" class="form-control" name="mulut_tenggorokan"
                                    placeholder="Isi keterangan tenggorokan">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lain-lain:</label>
                                <input type="text" class="form-control" name="mulut_lain"
                                    placeholder="Isi keterangan lain-lain mulut">
                            </div>
                        </div>
                        <hr>

                        <!-- 6. Leher -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">6. LEHER</h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">KGB:</label>
                                <input type="text" class="form-control" name="leher_kgb"
                                    placeholder="Keterangan KGB">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">TVJ:</label>
                                <input type="text" class="form-control" name="leher_tvj"
                                    placeholder="Keterangan TVJ">
                            </div>
                        </div>

                        <hr>

                        <!-- 7. Thoraks -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">7. THORAKS</h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">a. Bentuk:</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="thoraks_bentuk[]" id="thoraks_simetris" value="simetris">
                                        <label class="form-check-label"
                                            for="thoraks_simetris">Simetris</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="thoraks_bentuk[]" id="thoraks_asimetris" value="asimetris">
                                        <label class="form-check-label"
                                            for="thoraks_asimetris">Asimetris</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Areola mamae ∅:</label>
                                <input type="text" class="form-control" name="thoraks_areola_mamae"
                                    placeholder="Diameter areola">
                            </div>

                            <label class="form-label fw-bold">b. Jantung:</label> <br>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small">HR:</label>
                                <input type="text" class="form-control" name="thoraks_hr"
                                    placeholder="Heart Rate">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Murmur:</label>
                                <input type="text" class="form-control" name="thoraks_murmur"
                                    placeholder="Ada/Tidak">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bunyi jantung:</label>
                                <input type="text" class="form-control" name="thoraks_bunyi_jantung"
                                    placeholder="Normal/Abnormal">
                            </div>

                            <label class="form-label fw-bold">c. Paru:</label><br>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small">Retraksi:</label>
                                <input type="text" class="form-control" name="thoraks_retraksi"
                                    placeholder="Ada/Tidak">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Merintih:</label>
                                <input type="text" class="form-control" name="thoraks_merintih"
                                    placeholder="Ada/Tidak">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">RR:</label>
                                <input type="text" class="form-control" name="thoraks_rr"
                                    placeholder="Respiratory Rate">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Suara pernafasan:</label>
                                <input type="text" class="form-control" name="thoraks_suara_nafas"
                                    placeholder="Vesikuler/Bronkial">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Suara nafas tambahan:</label>
                                <input type="text" class="form-control" name="thoraks_suara_tambahan"
                                    placeholder="Ronki/Wheezing">
                            </div>
                        </div>

                        <hr>

                        <!-- 8. Abdomen -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">8. ABDOMEN</h6>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">a. Distensi:</label>
                                <input type="text" class="form-control" name="abdomen_distensi"
                                    placeholder="Ada/Tidak">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">b. Bising usus:</label>
                                <input type="text" class="form-control" name="abdomen_bising_usus"
                                    placeholder="Normal/Hiperaktif">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">c. Venektasi:</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="abdomen_venektasi" id="abdomen_venektasi_tidak"
                                            value="0">
                                        <label class="form-check-label"
                                            for="abdomen_venektasi_tidak">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="abdomen_venektasi" id="abdomen_venektasi_ya"
                                            value="1">
                                        <label class="form-check-label"
                                            for="abdomen_venektasi_ya">Ya</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">d. Hepar:</label>
                                <input type="text" class="form-control" name="abdomen_hepar"
                                    placeholder="Teraba/Tidak teraba">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lien:</label>
                                <input type="text" class="form-control" name="abdomen_lien"
                                    placeholder="Teraba/Tidak teraba">
                            </div>

                            <!-- e. Tali pusat -->
                            <div class="col-12 mb-3">
                                <label class="form-label">e. Tali pusat:</label>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="abdomen_tali_pusat[]" id="abdomen_segar"
                                                value="segar">
                                            <label class="form-check-label"
                                                for="abdomen_segar">Segar</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="abdomen_tali_pusat[]" id="abdomen_layu"
                                                value="layu">
                                            <label class="form-check-label" for="abdomen_layu">Layu</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="abdomen_tali_pusat[]" id="abdomen_bau"
                                                value="bau">
                                            <label class="form-check-label" for="abdomen_bau">Bau</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="abdomen_tali_pusat[]" id="abdomen_kering"
                                                value="kering">
                                            <label class="form-check-label"
                                                for="abdomen_kering">Kering</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="abdomen_tali_pusat[]" id="abdomen_basah"
                                                value="basah">
                                            <label class="form-check-label"
                                                for="abdomen_basah">Basah</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Arteri dan Vena -->
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Arteri:</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="abdomen_arteri" id="abdomen_arteri_1"
                                                    value="1">
                                                <label class="form-check-label"
                                                    for="abdomen_arteri_1">1</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="abdomen_arteri" id="abdomen_arteri_2"
                                                    value="2">
                                                <label class="form-check-label"
                                                    for="abdomen_arteri_2">2</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Vena:</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="abdomen_vena" id="abdomen_vena_1" value="1">
                                            <label class="form-check-label" for="abdomen_vena_1">1</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Kelainan:</label>
                                        <input type="text" class="form-control" name="abdomen_kelainan"
                                            placeholder="Kelainan">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- 9. Genetalia -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">9. GENETALIA</h6>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="genetalia"
                                            id="genetalia_laki" value="laki-laki">
                                        <label class="form-check-label"
                                            for="genetalia_laki">Laki-laki</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="genetalia"
                                            id="genetalia_perempuan" value="perempuan">
                                        <label class="form-check-label"
                                            for="genetalia_perempuan">Perempuan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="genetalia"
                                            id="genetalia_ambigus" value="ambigus">
                                        <label class="form-check-label"
                                            for="genetalia_ambigus">Ambigus</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- 10. Anus -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">10. ANUS</h6>
                            </div>

                            <div class="col-12 mb-3">
                                <input type="text" class="form-control" name="anus_keterangan"
                                    placeholder="Normal/Atresia/Stenosis">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Mekonium:</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="anus_mekonium" id="anus_mekonium_tidak" value="0">
                                        <label class="form-check-label"
                                            for="anus_mekonium_tidak">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="anus_mekonium" id="anus_mekonium_ya" value="1">
                                        <label class="form-check-label" for="anus_mekonium_ya">Ya</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- 11. Ekstremitas -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">11. EKSTREMITAS</h6>
                            </div>

                            <!-- Plantar Creases -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Plantar Creases:</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="plantar_creases[]" id="plantar_1_3_anterior"
                                                value="1/3 anterior">
                                            <label class="form-check-label" for="plantar_1_3_anterior">1/3
                                                anterior</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="plantar_creases[]" id="plantar_2_3_anterior"
                                                value="2/3 anterior">
                                            <label class="form-check-label" for="plantar_2_3_anterior">2/3
                                                anterior</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="plantar_creases[]" id="plantar_lebih_2_3_anterior"
                                                value=">2/3 anterior">
                                            <label class="form-check-label"
                                                for="plantar_lebih_2_3_anterior">>2/3 anterior</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Waktu pengisian kapiler -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Waktu pengisian kapiler:</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="waktu_pengisian_kapiler" id="kapiler_kurang_2"
                                            value="<2">
                                        <label class="form-check-label" for="kapiler_kurang_2">&lt;2</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="waktu_pengisian_kapiler" id="kapiler_lebih_2"
                                            value=">2">
                                        <label class="form-check-label" for="kapiler_lebih_2">&gt;2</label>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-md-6 mb-3">
                                <label class="form-label">Refleks:</label>
                                <input type="text" class="form-control" name="ekstremitas_refleks" placeholder="Normal/Lemah/Hiperaktif">
                            </div> --}}
                        </div>

                        <hr>

                        <!-- 12. Kulit -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">12. KULIT</h6>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kulit[]"
                                            id="kulit_pucat" value="pucat">
                                        <label class="form-check-label" for="kulit_pucat">Pucat</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kulit[]"
                                            id="kulit_ikterik" value="ikterik">
                                        <label class="form-check-label" for="kulit_ikterik">Ikterik</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kulit[]"
                                            id="kulit_mottled" value="mottled">
                                        <label class="form-check-label" for="kulit_mottled">Mottled</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kulit[]"
                                            id="kulit_ptekie" value="ptekie">
                                        <label class="form-check-label" for="kulit_ptekie">Ptekie</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kulit[]"
                                            id="kulit_ekimosis" value="ekimosis">
                                        <label class="form-check-label"
                                            for="kulit_ekimosis">Ekimosis</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kulit[]"
                                            id="kulit_hematoma" value="hematoma">
                                        <label class="form-check-label"
                                            for="kulit_hematoma">Hematoma</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kulit[]"
                                            id="kulit_sklerema" value="sklerema">
                                        <label class="form-check-label"
                                            for="kulit_sklerema">Sklerema</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Lainnya:</label>
                                <input type="text" class="form-control" name="kulit_lainnya"
                                    placeholder="Isi keterangan lainnya">
                            </div>
                        </div>

                        <hr>

                        <!-- 13. Kuku -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">13. KUKU</h6>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kuku[]"
                                            id="kuku_sianosis" value="sianosis">
                                        <label class="form-check-label" for="kuku_sianosis">Sianosis</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kuku[]"
                                            id="kuku_meconium" value="meconium stain">
                                        <label class="form-check-label" for="kuku_meconium">Meconium
                                            stain</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kuku[]"
                                            id="kuku_panjang" value="panjang">
                                        <label class="form-check-label" for="kuku_panjang">Panjang</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">lainnya:</label>
                                <input type="text" class="form-control" name="kuku_lainnya"
                                    placeholder="Isi keterangan lainnya">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="section-separator" id="apgar-score">
                    <h5 class="section-title">7. Apgar Skor</h5>

                    <div class="container-fluid">
                        <!-- Appearance (warna kulit) -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    Appearance (warna kulit):
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">1 menit:</label>
                                <select class="form-select" name="appearance_1">
                                    <option value="">Pilih skor</option>
                                    <option value="0">0 - Pucat</option>
                                    <option value="1">1 - Badan merah, ekstermitas biru</option>
                                    <option value="2">2 - Seluruh tubuh kemerah-merahan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">5 menit:</label>
                                <select class="form-select" name="appearance_5">
                                    <option value="">Pilih skor</option>
                                    <option value="0">0 - Pucat</option>
                                    <option value="1">1 - Badan merah, ekstermitas biru</option>
                                    <option value="2">2 - Seluruh tubuh kemerah-merahan</option>
                                </select>
                            </div>
                        </div>

                        <!-- Pulse (Nadi) -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    Pulse (Nadi):
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">1 menit:</label>
                                <select class="form-select" name="pulse_1">
                                    <option value="">Pilih skor</option>
                                    <option value="0">0 - Tidak ada</option>
                                    <option value="1">1 - < 100</option>
                                    <option value="2">2 - > 100</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">5 menit:</label>
                                <select class="form-select" name="pulse_5">
                                    <option value="">Pilih skor</option>
                                    <option value="0">0 - Tidak ada</option>
                                    <option value="1">1 - < 100</option>
                                    <option value="2">2 - > 100</option>
                                </select>
                            </div>
                        </div>

                        <!-- Grimace (Reaksi rangsangan) -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    Grimace (Reaksi rangsangan):
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">1 menit:</label>
                                <select class="form-select" name="grimace_1">
                                    <option value="">Pilih skor</option>
                                    <option value="0">0 - Tidak ada</option>
                                    <option value="1">1 - Sedikit gerakan mimik</option>
                                    <option value="2">2 - Batuk/ bersin</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">5 menit:</label>
                                <select class="form-select" name="grimace_5">
                                    <option value="">Pilih skor</option>
                                    <option value="0">0 - Tidak ada</option>
                                    <option value="1">1 - Sedikit gerakan mimik</option>
                                    <option value="2">2 - Batuk/ bersin</option>
                                </select>
                            </div>
                        </div>

                        <!-- Activity -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    Activity:
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">1 menit:</label>
                                <select class="form-select" name="activity_1">
                                    <option value="">Pilih skor</option>
                                    <option value="0">0 - Tidak ada</option>
                                    <option value="1">1 - Ekstremitas dalam sedikit fleksi</option>
                                    <option value="2">2 - Gerakan aktif</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">5 menit:</label>
                                <select class="form-select" name="activity_5">
                                    <option value="">Pilih skor</option>
                                    <option value="0">0 - Tidak ada</option>
                                    <option value="1">1 - Ekstremitas dalam sedikit fleksi</option>
                                    <option value="2">2 - Gerakan aktif</option>
                                </select>
                            </div>
                        </div>

                        <!-- Respiration -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    Respiration:
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">1 menit:</label>
                                <select class="form-select" name="respiration_1">
                                    <option value="">Pilih skor</option>
                                    <option value="0">0 - Tidak ada</option>
                                    <option value="1">1 - Lemah/ tidak teratur</option>
                                    <option value="2">2 - Baik/ menangis</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">5 menit:</label>
                                <select class="form-select" name="respiration_5">
                                    <option value="">Pilih skor</option>
                                    <option value="0">0 - Tidak ada</option>
                                    <option value="1">1 - Lemah/ tidak teratur</option>
                                    <option value="2">2 - Baik/ menangis</option>
                                </select>
                            </div>
                        </div>

                        <!-- Total Score -->
                        <div class="row mt-4 pt-3 border-top">
                            <div class="col-md-12">
                                <label class="form-label fw-bold mb-3">TOTAL SKOR:</label>
                                <div class="d-flex justify-content-center gap-3 flex-wrap">
                                    <div class="text-center">
                                        <div class="fw-semibold">1 menit:</div>
                                        <span id="total_1_minute_display"
                                            class="badge bg-primary fs-5">0</span>
                                    </div>
                                    <div class="text-center">
                                        <div class="fw-semibold">5 menit:</div>
                                        <span id="total_5_minute_display"
                                            class="badge bg-primary fs-5">0</span>
                                    </div>
                                    <div class="text-center">
                                        <div class="fw-semibold">Total Gabungan:</div>
                                        <span id="total_combined_display"
                                            class="badge bg-success fs-5">0</span>
                                    </div>
                                </div>

                                <!-- Hidden inputs untuk menyimpan data -->
                                <input type="hidden" id="total_1_minute" name="total_1_minute"
                                    value="0">
                                <input type="hidden" id="total_5_minute" name="total_5_minute"
                                    value="0">
                                <input type="hidden" id="total_combined" name="total_combined"
                                    value="0">
                                <input type="hidden" id="apgar_data" name="apgar_data" value="{}">
                                <input type="hidden" id="apgar_interpretation"
                                    name="apgar_interpretation" value="">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="section-separator" id="diagnosisIbu">
                    <h5 class="section-title">8. Diagnosis</h5>
                    <!-- Diagnosis IBU -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">Diagnosis Ibu</h6>

                            <!-- Nomor diagnosis -->
                            <div class="mb-4">
                                <div class="row">
                                    <div class="col-1"><strong>1</strong></div>
                                    <div class="col-11">
                                        <input type="text" class="form-control" name="diagnosis_ibu_1"
                                            placeholder="Diagnosis 1">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-1"><strong>2</strong></div>
                                    <div class="col-11">
                                        <input type="text" class="form-control" name="diagnosis_ibu_2"
                                            placeholder="Diagnosis 2">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-1"><strong>3</strong></div>
                                    <div class="col-11">
                                        <input type="text" class="form-control" name="diagnosis_ibu_3"
                                            placeholder="Diagnosis 3">
                                    </div>
                                </div>
                            </div>

                            <!-- Cara Persalinan -->
                            <h6 class="text-primary mb-3">Cara Persalinan</h6>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="cara_persalinan[]" id="spontan" value="spontan">
                                        <label class="form-check-label" for="spontan">Spontan</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="cara_persalinan[]" id="sc" value="sc">
                                        <label class="form-check-label" for="sc">SC</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="cara_persalinan[]" id="vacum" value="vacum">
                                        <label class="form-check-label" for="vacuum">Vacum</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="cara_persalinan[]" id="forceps" value="forceps">
                                        <label class="form-check-label" for="forceps">Forceps</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Indikasi -->
                            <div class="mb-4">
                                <label class="form-label"><strong>Indikasi:</strong></label>
                                <textarea class="form-control" name="indikasi" rows="3" placeholder="Masukkan indikasi..."></textarea>
                            </div>

                            <!-- Faktor Resiko IBU -->
                            <h6 class="text-primary mb-3">Faktor Resiko Ibu</h6>

                            <!-- Mayor -->
                            <div class="mb-3">
                                <label class="form-label"><strong>Mayor:</strong></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_mayor[]" id="demam"
                                                value="demam">
                                            <label class="form-check-label" for="demam">Demam (T>38
                                                °C)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_mayor[]" id="kpd_18"
                                                value="kpd_18">
                                            <label class="form-check-label" for="kpd_18">KPD > 18
                                                Jam</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_mayor[]" id="korioamnionitis"
                                                value="korioamnionitis">
                                            <label class="form-check-label"
                                                for="korioamnionitis">Korioamnionitis</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_mayor[]" id="fetal_distress"
                                                value="fetal_distress">
                                            <label class="form-check-label" for="fetal_distress">Fetal
                                                distress, DJJ > 160 x/″</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_mayor[]" id="ketuban_berbau"
                                                value="ketuban_berbau">
                                            <label class="form-check-label" for="ketuban_berbau">Ketuban
                                                berbau</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Minor -->
                            <div class="mb-3">
                                <label class="form-label"><strong>Minor:</strong></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_minor[]" id="kpd_12"
                                                value="kpd_12">
                                            <label class="form-check-label" for="kpd_12">KPD > 12
                                                Jam</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_minor[]" id="apgar_skor"
                                                value="apgar_skor">
                                            <label class="form-check-label" for="apgar_skor">APGAR Skor 1'<5
                                                    atau 5'< 7</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_minor[]" id="bblsr"
                                                value="bblsr">
                                            <label class="form-check-label" for="bblsr">BBLSR (<1500
                                                    g)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_minor[]" id="gestasi"
                                                value="gestasi">
                                            <label class="form-check-label" for="gestasi">Gestasi < 37
                                                    mggu</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_minor[]" id="gemelli"
                                                value="gemelli">
                                            <label class="form-check-label" for="gemelli">Gemelli</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_minor[]" id="keputihan_tdk_diobati"
                                                value="keputihan_tdk_diobati">
                                            <label class="form-check-label"
                                                for="keputihan_tdk_diobati">Keputihan tdk diobati</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_minor[]" id="isk_susp_isk"
                                                value="isk_susp_isk">
                                            <label class="form-check-label" for="isk_susp_isk">ISK/ Susp.
                                                ISK</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_minor[]" id="ibu_demam"
                                                value="ibu_demam">
                                            <label class="form-check-label" for="ibu_demam">Ibu demam > 38
                                                °C</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-separator" id="refleksPrimitif">
                    <h5 class="section-title">11. Refleks Primitif</h5>

                    <!-- Refleks Primitif -->
                    <div class="row mb-4">
                        <div class="col-12">

                            <!-- Baris 1: Refleks moro dan Refleks rooting -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <label class="form-label">Refleks moro</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_moro" id="refleks_moro_ya"
                                                        value="1">
                                                    <label class="form-check-label"
                                                        for="refleks_moro_ya">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_moro" id="refleks_moro_tidak"
                                                        value="0">
                                                    <label class="form-check-label"
                                                        for="refleks_moro_tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <label class="form-label">Refleks rooting</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_rooting" id="refleks_rooting_ya"
                                                        value="1">
                                                    <label class="form-check-label"
                                                        for="refleks_rooting_ya">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_rooting" id="refleks_rooting_tidak"
                                                        value="0">
                                                    <label class="form-check-label"
                                                        for="refleks_rooting_tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Baris 2: Refleks palmar grasping dan Refleks sucking -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <label class="form-label">Refleks palmar grasping</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_palmar_grasping"
                                                        id="refleks_palmar_grasping_ya" value="1">
                                                    <label class="form-check-label"
                                                        for="refleks_palmar_grasping_ya">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_palmar_grasping"
                                                        id="refleks_palmar_grasping_tidak" value="0">
                                                    <label class="form-check-label"
                                                        for="refleks_palmar_grasping_tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <label class="form-label">Refleks sucking</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_sucking" id="refleks_sucking_ya"
                                                        value="1">
                                                    <label class="form-check-label"
                                                        for="refleks_sucking_ya">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_sucking" id="refleks_sucking_tidak"
                                                        value="0">
                                                    <label class="form-check-label"
                                                        for="refleks_sucking_tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Baris 3: Refleks plantar grasping dan Refleks tonic neck -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <label class="form-label">Refleks plantar grasping</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_plantar_grasping"
                                                        id="refleks_plantar_grasping_ya" value="1">
                                                    <label class="form-check-label"
                                                        for="refleks_plantar_grasping_ya">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_plantar_grasping"
                                                        id="refleks_plantar_grasping_tidak" value="0">
                                                    <label class="form-check-label"
                                                        for="refleks_plantar_grasping_tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <label class="form-label">Refleks tonic neck</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_tonic_neck" id="refleks_tonic_neck_ya"
                                                        value="1">
                                                    <label class="form-check-label"
                                                        for="refleks_tonic_neck_ya">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_tonic_neck"
                                                        id="refleks_tonic_neck_tidak" value="0">
                                                    <label class="form-check-label"
                                                        for="refleks_tonic_neck_tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-separator" id="kelainanBawaan">
                    <h5 class="section-title">10. Kelainan Bawaan</h5>

                    <!-- Kelainan Bawaan -->
                    <div class="row mb-4">
                        <div class="col-12">

                            <div class="row">
                                <div class="col-1"><strong>1</strong></div>
                                <div class="col-11">
                                    <input type="text" class="form-control mb-2"
                                        name="kelainan_bawaan_1" placeholder="Kelainan bawaan 1">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-1"><strong>2</strong></div>
                                <div class="col-11">
                                    <input type="text" class="form-control mb-2"
                                        name="kelainan_bawaan_2" placeholder="Kelainan bawaan 2">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-1"><strong>3</strong></div>
                                <div class="col-11">
                                    <input type="text" class="form-control mb-2"
                                        name="kelainan_bawaan_3" placeholder="Kelainan bawaan 3">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-1"><strong>4</strong></div>
                                <div class="col-11">
                                    <input type="text" class="form-control mb-2"
                                        name="kelainan_bawaan_4" placeholder="Kelainan bawaan 4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-separator">
                    <h5 class="section-title">11. Hasil Pemeriksaan Penunjang</h5>
                    <div class="form-floating">
                        <textarea class="form-control" name="hasil_laboratorium" placeholder="hasil Laboratorium" id="laboratorium"
                            style="height: 100px"></textarea>
                        <label for="laboratorium">1. Laboratorium</label>
                    </div>
                    <div class="form-floating mt-3">
                        <textarea class="form-control" name="hasil_radiologi" placeholder="hasil Radiologi" id="radiologi"
                            style="height: 100px"></textarea>
                        <label for="radiologi">2. Radiologi</label>
                    </div>
                    <div class="form-floating mt-3">
                        <textarea class="form-control" name="hasil_lainnya" placeholder="hasil Lainnya" id="lainnya"
                            style="height: 100px"></textarea>
                        <label for="lainnya">3. Lainnya</label>
                    </div>
                </div>

                <div class="section-separator" id="diagnosis">
                    <h5 class="fw-semibold mb-4">12. Diagnosis</h5>
                    <!-- Diagnosis Banding -->
                    <div class="mb-4">
                        <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                            diagnosis banding,
                            apabila tidak ada, Pilih tanda tambah untuk menambah
                            keterangan diagnosis banding yang tidak ditemukan.</small>

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-secondary"></i>
                            </span>
                            <input type="text" id="diagnosis-banding-input"
                                class="form-control border-start-0 ps-0"
                                placeholder="Cari dan tambah Diagnosis Banding">
                            <span class="input-group-text bg-white" id="add-diagnosis-banding">
                                <i class="bi bi-plus-circle text-primary"></i>
                            </span>
                        </div>

                        <div id="diagnosis-banding-list" class="diagnosis-list bg-light p-3 rounded">
                            <!-- Diagnosis items will be added here dynamically -->
                        </div>

                        <!-- Hidden input to store JSON data -->
                        <input type="hidden" id="diagnosis_banding" name="diagnosis_banding"
                            value="[]">
                    </div>

                    <!-- Diagnosis Kerja -->
                    <div class="mb-4">
                        <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                            diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah
                            keterangan diagnosis kerja yang tidak ditemukan.</small>

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-secondary"></i>
                            </span>
                            <input type="text" id="diagnosis-kerja-input"
                                class="form-control border-start-0 ps-0"
                                placeholder="Cari dan tambah Diagnosis Kerja">
                            <span class="input-group-text bg-white" id="add-diagnosis-kerja">
                                <i class="bi bi-plus-circle text-primary"></i>
                            </span>
                        </div>

                        <div id="diagnosis-kerja-list" class="diagnosis-list bg-light p-3 rounded">
                            <!-- Diagnosis items will be added here dynamically -->
                        </div>

                        <!-- Hidden input to store JSON data -->
                        <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja"
                            value="[]">
                    </div>
                </div>

                <div class="section-separator" id="diagnosisIbu">
                    <h5 class="section-title">13. Rencana Penatalaksanaan dan Pengobatan</h5>
                    <textarea class="form-control" name="rencana_pengobatan" rows="4"
                        placeholder="Rencana Penatalaksanaan Dan Pengobatan"></textarea>
                </div>

                <div class="section-separator" id="prognosis">
                    <h5 class="section-title">14. Prognosis</h5>
                    <select class="form-select" name="prognosis">
                        <option value="" selected disabled>--Pilih Prognosis--</option>
                        @forelse ($satsetPrognosis as $item)
                            <option value="{{ $item->prognosis_id }}">
                                {{ $item->value ?? 'Field tidak ditemukan' }}
                            </option>
                        @empty
                            <option value="" disabled>Tidak ada data</option>
                        @endforelse
                    </select>
                </div>

                <div class="section-separator" id="discharge-planning">
                    <h5 class="section-title">15. Perencanaan Pulang Pasien (Discharge Planning)</h5>
                    <div class="card-body">

                        <!-- 1. Usia yang menarik bayi di rumah -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Ada yang  merawat bayi dirumah</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio"
                                            name="usia_menarik_bayi" id="usia_ya" value="ya">
                                        <label class="form-check-label" for="usia_ya">Ya: Ibu/ Ayah/
                                            Keluarga lainnya</label>
                                    </div>
                                    <input type="text" class="form-control" name="keterangan_usia"
                                        placeholder="Sebutkan siapa..." disabled>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio"
                                            name="usia_menarik_bayi" id="usia_tidak" value="tidak">
                                        <label class="form-check-label" for="usia_tidak">Tidak,
                                            jelaskan</label>
                                    </div>
                                    <input type="text" class="form-control"
                                        name="keterangan_tidak_usia" placeholder="Jelaskan alasan..."
                                        disabled>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Antisipasi terhadap masalah saat pulang -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Antisipasi terhadap masalah saat pulang</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="masalah_pulang" id="masalah_tidak" value="tidak">
                                        <label class="form-check-label" for="masalah_tidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio"
                                            name="masalah_pulang" id="masalah_ya" value="ya">
                                        <label class="form-check-label" for="masalah_ya">Ya,
                                            jelaskan</label>
                                    </div>
                                    <textarea class="form-control" name="keterangan_masalah_pulang" rows="2"
                                        placeholder="Jelaskan masalah yang mungkin terjadi..." disabled></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Beresiko finansial -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Beresiko finansial</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="beresiko_finansial" id="finansial_tidak" value="tidak">
                                    <label class="form-check-label" for="finansial_tidak">Tidak</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="beresiko_finansial" id="finansial_ya" value="ya">
                                    <label class="form-check-label" for="finansial_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Edukasi diperlukan dalam hal -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Edukasi diperlukan dalam hal</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="edukasi[]"
                                            id="edukasi_menyusui" value="menyusui">
                                        <label class="form-check-label"
                                            for="edukasi_menyusui">Menyusui</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="edukasi[]"
                                            id="edukasi_memandikan" value="memandikan">
                                        <label class="form-check-label"
                                            for="edukasi_memandikan">Memandikan</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="edukasi[]"
                                            id="edukasi_berpakaian" value="berpakaian">
                                        <label class="form-check-label"
                                            for="edukasi_berpakaian">Berpakaian</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="edukasi[]"
                                            id="edukasi_perawatan_bayi" value="perawatan_bayi_dasar">
                                        <label class="form-check-label"
                                            for="edukasi_perawatan_bayi">Perawatan bayi dasar (basic infant
                                            care)</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="edukasi[]"
                                            id="edukasi_mengukur_suhu" value="mengukur_suhu">
                                        <label class="form-check-label" for="edukasi_mengukur_suhu">Mengukur
                                            suhu</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="edukasi[]"
                                            id="edukasi_perawatan_kulit" value="perawatan_kulit_kelamin">
                                        <label class="form-check-label"
                                            for="edukasi_perawatan_kulit">Perawatan kulit/ kelamin</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="edukasi[]"
                                            id="edukasi_lainnya" value="lainnya">
                                        <label class="form-check-label"
                                            for="edukasi_lainnya">Lainnya</label>
                                    </div>
                                    <input type="text" class="form-control"
                                        name="edukasi_lainnya_keterangan"
                                        placeholder="Sebutkan edukasi lainnya..." disabled>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Ada yang membantu keperluan di atas -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Ada yang membantu keperluan di atas?</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ada_membantu"
                                            id="membantu_tidak" value="tidak">
                                        <label class="form-check-label" for="membantu_tidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="ada_membantu"
                                            id="membantu_ada" value="ada">
                                        <label class="form-check-label" for="membantu_ada">Ada,
                                            siapa</label>
                                    </div>
                                    <input type="text" class="form-control" name="keterangan_membantu"
                                        placeholder="Sebutkan siapa yang membantu..." disabled>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Perkiraan lama hari dirawat -->
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Perkiraan lama hari dirawat</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control"
                                            name="perkiraan_lama_rawat" placeholder="0" min="0">
                                        <span class="input-group-text">Hari</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Rencana Tanggal Pulang</label>
                                    <input type="date" class="form-control"
                                        name="rencana_tanggal_pulang">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-end">
                    <x-button-submit />
                </div>

            </form>
        </x-content-card>
        </div>
    </div>
@endsection
