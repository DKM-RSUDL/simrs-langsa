@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-pengkajian-awal-medis.create-include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-asesmen-tht')
        </div>

        <div class="col-md-9">
            <x-content-card>
            <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Asesmen Pengkajian Awal Medis',
                    'description' => 'Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan',
                ])

                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="kd_pasien" value="{{ $dataMedis->kd_pasien }}">
                    <input type="hidden" name="kd_unit" value="{{ $dataMedis->kd_unit }}">
                    <input type="hidden" name="tgl_masuk" value="{{ $dataMedis->tgl_masuk }}">
                    <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">

                        <!-- FORM ASESMEN -->
                        <div class="px-3">
                            <div class="section-separator" id="data-masuk">
                                <h5 class="section-title">1. Data masuk</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <input type="date" class="form-control" name="tanggal"
                                            value="{{ date('Y-m-d') }}">
                                        <input type="time" class="form-control" name="jam_masuk"
                                            value="{{ date('H:i') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="section-separator" id="">
                                <h5 class="section-title">2. Anamnesis</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Keluhan Utama</label>
                                    <textarea class="form-control" name="keluhan_utama" rows="3" placeholder="Keluhan utama pasien"></textarea>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Riwayat penyakit sekarang</label>
                                    <textarea class="form-control" name="riwayat_penyakit_sekarang" rows="4" placeholder="Riwayat penyakit sekarang"></textarea>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Riwayat penyakit terdahulu</label>
                                    <textarea class="form-control" name="riwayat_penyakit_terdahulu" rows="4"
                                        placeholder="Riwayat penyakit terdahulu"></textarea>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Riwayat penyakit keluarga</label>
                                    <textarea class="form-control" name="riwayat_penyakit_keluarga" rows="4"
                                        placeholder="Riwayat penyakit dalam keluarga"></textarea>
                                </div>
                            </div>

                            <div class="section-separator" id="riwayatObat">
                                <h5 class="section-title">3. Riwayat Penggunaan Obat</h5>

                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3" id="openObatModal">
                                    <i class="ti-plus"></i> Tambah
                                </button>
                                <input type="hidden" name="riwayat_penggunaan_obat" id="riwayatObatData" value="[]">
                                <div class="table-responsive">
                                    <table class="table" id="createRiwayatObatTable">
                                        <thead>
                                            <tr>
                                                <th>Nama Obat</th>
                                                <th>Dosis</th>
                                                <th>Aturan Pakai</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Table content will be dynamically populated -->
                                        </tbody>
                                    </table>
                                </div>
                                @push('modals')
                                    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-pengkajian-awal-medis.modal-create-obat')
                                @endpush
                            </div>

                            <div class="section-separator" id="alergi">
                                <h5 class="section-title">4. Alergi</h5>
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
                                    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-pengkajian-awal-medis.modal-create-alergi')
                                @endpush
                            </div>


                            <div class="section-separator" id="riwayat-pengobatan">
                                <h5 class="section-title">5. Status present</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tek. Darah (mmHg)</label>
                                    <div class="d-flex gap-3" style="width: 100%;">

                                        <div class="flex-grow-1">
                                            <label class="form-label">Sistole</label>
                                            <input type="number" class="form-control" name="sistole"
                                                placeholder="Sistole"
                                                value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->sistole : '' }}">
                                        </div>

                                        <div class="flex-grow-1">
                                            <label class="form-label">Diastole</label>
                                            <input type="number" class="form-control" name="diastole"
                                                placeholder="Diastole"
                                                value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->diastole : '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Respirasi (x/menit)</label>
                                    <input type="number" class="form-control" name="respirasi"
                                        placeholder="Respirasi per menit"
                                        value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->respiration : '' }}">
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 200px;">Suhu (C)</label>
                                    <input type="text" class="form-control" name="suhu" placeholder="Suhu"
                                    value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->suhu : '' }}">
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 200px;">Nadi (x/menit)</label>
                                    <input type="number" class="form-control" name="nadi" placeholder="Nadi"
                                    value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->nadi : '' }}">
                                </div>

                            </div>

                            <!-- 6. Pemeriksaan Fisik -->
                            <div class="section-separator" id="pemeriksaan-fisik">
                                <h5 class="section-title">6. Pemeriksaan Fisik</h5>
                                <div class="" id="pemeriksaan-fisik-paru">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-asesmen">
                                            <tbody>
                                                <!-- Kepala -->
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="fw-semibold">a. Kepala:</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_kepala" value="1"
                                                                            id="pengkajian_kepala_normal" checked>
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_kepala_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_kepala" value="0"
                                                                            id="pengkajian_kepala_tidak_normal">
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_kepala_tidak_normal">Tidak
                                                                            Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="pengkajian_kepala_keterangan"
                                                                        id="pengkajian_kepala_keterangan"
                                                                        placeholder="Keterangan jika tidak normal..."
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Mata -->
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="fw-semibold">b. Mata:</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_mata" value="1"
                                                                            id="pengkajian_mata_normal" checked>
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_mata_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_mata" value="0"
                                                                            id="pengkajian_mata_tidak_normal">
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_mata_tidak_normal">Tidak
                                                                            Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="pengkajian_mata_keterangan"
                                                                        id="pengkajian_mata_keterangan"
                                                                        placeholder="Keterangan jika tidak normal..."
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- THT -->
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="fw-semibold">c. THT:</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_tht" value="1"
                                                                            id="pengkajian_tht_normal" checked>
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_tht_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_tht" value="0"
                                                                            id="pengkajian_tht_tidak_normal">
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_tht_tidak_normal">Tidak
                                                                            Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="pengkajian_tht_keterangan"
                                                                        id="pengkajian_tht_keterangan"
                                                                        placeholder="Keterangan jika tidak normal..."
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Leher -->
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="fw-semibold">d. Leher:</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_leher" value="1"
                                                                            id="pengkajian_leher_normal" checked>
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_leher_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_leher" value="0"
                                                                            id="pengkajian_leher_tidak_normal">
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_leher_tidak_normal">Tidak
                                                                            Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="pengkajian_leher_keterangan"
                                                                        id="pengkajian_leher_keterangan"
                                                                        placeholder="Keterangan jika tidak normal..."
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Mulut -->
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="fw-semibold">e. Mulut:</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_mulut" value="1"
                                                                            id="pengkajian_mulut_normal" checked>
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_mulut_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_mulut" value="0"
                                                                            id="pengkajian_mulut_tidak_normal">
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_mulut_tidak_normal">Tidak
                                                                            Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="pengkajian_mulut_keterangan"
                                                                        id="pengkajian_mulut_keterangan"
                                                                        placeholder="Keterangan jika tidak normal..."
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Jantung dan pembuluh darah -->
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="fw-semibold">f. Jantung dan pembuluh
                                                                    darah:</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_jantung" value="1"
                                                                            id="pengkajian_jantung_normal" checked>
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_jantung_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_jantung" value="0"
                                                                            id="pengkajian_jantung_tidak_normal">
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_jantung_tidak_normal">Tidak
                                                                            Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="pengkajian_jantung_keterangan"
                                                                        id="pengkajian_jantung_keterangan"
                                                                        placeholder="Keterangan jika tidak normal..."
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Thorax -->
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="fw-semibold">g. Thorax:</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_thorax" value="1"
                                                                            id="pengkajian_thorax_normal" checked>
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_thorax_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_thorax" value="0"
                                                                            id="pengkajian_thorax_tidak_normal">
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_thorax_tidak_normal">Tidak
                                                                            Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="pengkajian_thorax_keterangan"
                                                                        id="pengkajian_thorax_keterangan"
                                                                        placeholder="Keterangan jika tidak normal..."
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Abdomen -->
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="fw-semibold">h. Abdomen:</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_abdomen" value="1"
                                                                            id="pengkajian_abdomen_normal" checked>
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_abdomen_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_abdomen" value="0"
                                                                            id="pengkajian_abdomen_tidak_normal">
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_abdomen_tidak_normal">Tidak
                                                                            Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="pengkajian_abdomen_keterangan"
                                                                        id="pengkajian_abdomen_keterangan"
                                                                        placeholder="Keterangan jika tidak normal..."
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Tulang belakang dan anggota gerak -->
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="fw-semibold">i. Tulang belakang dan anggota
                                                                    gerak:</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_tulang_belakang"
                                                                            value="1"
                                                                            id="pengkajian_tulang_belakang_normal" checked>
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_tulang_belakang_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_tulang_belakang"
                                                                            value="0"
                                                                            id="pengkajian_tulang_belakang_tidak_normal">
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_tulang_belakang_tidak_normal">Tidak
                                                                            Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="pengkajian_tulang_belakang_keterangan"
                                                                        id="pengkajian_tulang_belakang_keterangan"
                                                                        placeholder="Keterangan jika tidak normal..."
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Sistem Syaraf -->
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="fw-semibold">j. Sistem Syaraf:</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_sistem_syaraf" value="1"
                                                                            id="pengkajian_sistem_syaraf_normal" checked>
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_sistem_syaraf_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_sistem_syaraf" value="0"
                                                                            id="pengkajian_sistem_syaraf_tidak_normal">
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_sistem_syaraf_tidak_normal">Tidak
                                                                            Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="pengkajian_sistem_syaraf_keterangan"
                                                                        id="pengkajian_sistem_syaraf_keterangan"
                                                                        placeholder="Keterangan jika tidak normal..."
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Genetalia -->
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="fw-semibold">k. Genetalia:</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_genetalia" value="1"
                                                                            id="pengkajian_genetalia_normal" checked>
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_genetalia_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_genetalia" value="0"
                                                                            id="pengkajian_genetalia_tidak_normal">
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_genetalia_tidak_normal">Tidak
                                                                            Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="pengkajian_genetalia_keterangan"
                                                                        id="pengkajian_genetalia_keterangan"
                                                                        placeholder="Keterangan jika tidak normal..."
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Status Lokasi -->
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="fw-semibold">l. Status Lokasi:</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_status_lokasi" value="1"
                                                                            id="pengkajian_status_lokasi_normal" checked>
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_status_lokasi_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="pengkajian_status_lokasi" value="0"
                                                                            id="pengkajian_status_lokasi_tidak_normal">
                                                                        <label class="form-check-label"
                                                                            for="pengkajian_status_lokasi_tidak_normal">Tidak
                                                                            Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="pengkajian_status_lokasi_keterangan"
                                                                        id="pengkajian_status_lokasi_keterangan"
                                                                        placeholder="Keterangan jika tidak normal..."
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="section-separator">
                                <h5 class="section-title">7. Skala Nyeri</h5>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-start gap-4">
                                            <div class="d-flex align-items-center gap-3" style="min-width: 350px;">
                                                <!-- Input utama untuk skala nyeri -->
                                                <input type="number"
                                                    class="form-control @error('skala_nyeri') is-invalid @enderror"
                                                    name="skala_nyeri" style="width: 100px;"
                                                    value="{{ old('skala_nyeri', 0) }}" min="0" max="10"
                                                    placeholder="0-10">

                                                @error('skala_nyeri')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                                <!-- Button status nyeri -->
                                                <button type="button" class="btn btn-sm btn-success" id="skalaNyeriBtn"
                                                    style="min-width: 150px;">
                                                    Tidak Nyeri
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Hidden input untuk nilai skala nyeri (jika diperlukan backend) -->
                                        <input type="hidden" name="skala_nyeri_nilai"
                                            value="{{ old('skala_nyeri_nilai', 0) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Pain Scale Images - Tampil langsung -->
                                        <div id="wongBakerScale" class="pain-scale-image">
                                            <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}"
                                                alt="Wong Baker Pain Scale" class="img-fluid"
                                                style="max-width: auto; height: auto;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 7. Diagnosis -->
                            <div class="section-separator" id="diagnosis">
                                <h5 class="fw-semibold mb-4">8. Diagnosis</h5>

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
                                    <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja" value="[]">
                                </div>
                            </div>

                            <div class="section-separator" id="rencana_pengobatan">
                                <h5 class="fw-semibold mb-4">9. Rencana Penatalaksanaan Dan Pengobatan</h5>
                                <div class="form-group">
                                    <textarea class="form-control" name="rencana_pengobatan" rows="4"
                                        placeholder="Rencana Penatalaksanaan Dan Pengobatan"></textarea>
                                </div>
                            </div>

                            <div class="section-separator" id="prognosis">
                                <h5 class="fw-semibold mb-4">10. Prognosis</h5>
                                <div class="mb-4">
                                    <select class="form-select" name="paru_prognosis">
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
                            </div>

                            <!-- 9. Perencanaan Pulang Pasien -->
                            <div class="section-separator" id="discharge-planning">
                                <h5 class="section-title">11. Perencanaan Pulang Pasien (Discharge Planning)</h5>

                                {{-- <div class="mb-4">
                                    <label class="form-label">Diagnosis medis</label>
                                    <input type="text" class="form-control" name="diagnosis_medis" placeholder="Diagnosis">
                                </div> --}}

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

                                <!-- Tombol Reset (Opsional) -->
                                <div class="mt-3">
                                    <button type="button" class="btn btn-secondary" onclick="resetDischargePlanning()">
                                        Reset Discharge Planning
                                    </button>
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


@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to toggle input fields based on radio button selection
            function toggleInputFields(radioName, inputIds, yesValue = 'ya') {
                const radios = document.getElementsByName(radioName);
                const inputs = inputIds.map(id => document.getElementById(id));

                // Initialize state based on current selection
                const selectedValue = Array.from(radios).find(radio => radio.checked)?.value;
                inputs.forEach(input => {
                    input.disabled = selectedValue !== yesValue;
                    if (selectedValue !== yesValue) {
                        input.value = ''; // Clear input when disabled
                    }
                });

                // Add event listeners to radio buttons
                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        inputs.forEach(input => {
                            input.disabled = this.value !== yesValue;
                            if (this.value !== yesValue) {
                                input.value = ''; // Clear input when disabled
                                input.classList.remove(
                                    'is-invalid'); // Remove validation error styling
                            }
                        });
                    });
                });
            }

            // Toggle inputs for Merokok
            toggleInputFields('merokok', ['merokok_jumlah', 'merokok_lama']);

            // Toggle inputs for Alkohol
            toggleInputFields('alkohol', ['alkohol_jumlah']);

            // Toggle inputs for Obat-obatan
            toggleInputFields('obat_obatan', ['obat_jenis']);

            // Client-side validation on form submission
            document.querySelector('form').addEventListener('submit', function(event) {
                let errors = [];

                // Check Merokok
                const merokok = document.querySelector('input[name="merokok"]:checked')?.value;
                if (merokok === 'ya') {
                    const jumlah = document.getElementById('merokok_jumlah').value;
                    const lama = document.getElementById('merokok_lama').value;
                    if (!jumlah || jumlah < 0) {
                        errors.push('Jumlah batang/hari harus diisi dan tidak boleh negatif.');
                        document.getElementById('merokok_jumlah').classList.add('is-invalid');
                    }
                    if (!lama || lama < 0) {
                        errors.push('Lama merokok harus diisi dan tidak boleh negatif.');
                        document.getElementById('merokok_lama').classList.add('is-invalid');
                    }
                }

                // Check Alkohol
                const alkohol = document.querySelector('input[name="alkohol"]:checked')?.value;
                if (alkohol === 'ya' && !document.getElementById('alkohol_jumlah').value.trim()) {
                    errors.push('Jumlah konsumsi alkohol harus diisi.');
                    document.getElementById('alkohol_jumlah').classList.add('is-invalid');
                }

                // Check Obat-obatan
                const obat = document.querySelector('input[name="obat_obatan"]:checked')?.value;
                if (obat === 'ya' && !document.getElementById('obat_jenis').value.trim()) {
                    errors.push('Jenis obat-obatan harus diisi.');
                    document.getElementById('obat_jenis').classList.add('is-invalid');
                }

                // If there are errors, prevent form submission and show alert
                if (errors.length > 0) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        html: errors.join('<br>'),
                        confirmButtonColor: '#3085d6',
                    });
                }
            });
        });


        // Pemeriksaan Fisik - JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Function to toggle keterangan input based on radio selection
            function toggleKeteranganInput(radioName, keteranganId) {
                const radios = document.getElementsByName(radioName);
                const keteranganInput = document.getElementById(keteranganId);

                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        if (this.value === '0') { // Tidak Normal
                            keteranganInput.disabled = false;
                            keteranganInput.focus();
                        } else { // Normal
                            keteranganInput.disabled = true;
                            keteranganInput.value = null;
                        }
                    });
                });

                // Initialize state saat pertama kali load
                const selectedRadio = Array.from(radios).find(radio => radio.checked);
                if (selectedRadio) {
                    if (selectedRadio.value === '0') {
                        keteranganInput.disabled = false;
                    } else {
                        keteranganInput.disabled = true;
                        keteranganInput.value = null;
                    }
                }
            }

            // Apply toggle functionality ke semua item pemeriksaan fisik
            // Sesuaikan dengan name yang ada di HTML
            toggleKeteranganInput('pengkajian_kepala', 'pengkajian_kepala_keterangan');
            toggleKeteranganInput('pengkajian_mata', 'pengkajian_mata_keterangan');
            toggleKeteranganInput('pengkajian_tht', 'pengkajian_tht_keterangan');
            toggleKeteranganInput('pengkajian_leher', 'pengkajian_leher_keterangan');
            toggleKeteranganInput('pengkajian_mulut', 'pengkajian_mulut_keterangan');
            toggleKeteranganInput('pengkajian_jantung', 'pengkajian_jantung_keterangan');
            toggleKeteranganInput('pengkajian_thorax', 'pengkajian_thorax_keterangan');
            toggleKeteranganInput('pengkajian_abdomen', 'pengkajian_abdomen_keterangan');
            toggleKeteranganInput('pengkajian_tulang_belakang', 'pengkajian_tulang_belakang_keterangan');
            toggleKeteranganInput('pengkajian_sistem_syaraf', 'pengkajian_sistem_syaraf_keterangan');
            toggleKeteranganInput('pengkajian_genetalia', 'pengkajian_genetalia_keterangan');
            toggleKeteranganInput('pengkajian_status_lokasi', 'pengkajian_status_lokasi_keterangan');

            // Function untuk update JSON hidden input based on checkbox selections (jika ada)
            function updateCheckboxJSON(checkboxClass, hiddenInputId) {
                const checkboxes = document.querySelectorAll('.' + checkboxClass);
                const hiddenInput = document.getElementById(hiddenInputId);

                // Cek apakah element ada sebelum diproses
                if (!hiddenInput || checkboxes.length === 0) return;

                function updateJSON() {
                    const selectedValues = [];
                    checkboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            selectedValues.push(checkbox.value);
                        }
                    });

                    hiddenInput.value = selectedValues.length > 0 ? JSON.stringify(selectedValues) : '';
                    console.log(`${hiddenInputId}:`, hiddenInput.value);
                }

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateJSON);
                });

                updateJSON();
            }

            // Apply checkbox JSON functionality (jika diperlukan)
            updateCheckboxJSON('paru-suara-pernafasan', 'paru_suara_pernafasan_json');
            updateCheckboxJSON('paru-suara-tambahan', 'paru_suara_tambahan_json');

            // Form validation sebelum submit
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Validasi tambahan jika diperlukan
                    console.log('Form submitted with pemeriksaan fisik data');
                });
            }
        });

        // Skala Nyeri - JavaScript yang disederhanakan
        function initSkalaNyeri() {
            const input = $('input[name="skala_nyeri"]');
            const hiddenInput = $('input[name="skala_nyeri_nilai"]');
            const button = $('#skalaNyeriBtn');

            // Trigger saat pertama kali load
            const initialValue = parseInt(input.val()) || 0;
            updateButton(initialValue);

            // Sinkronkan hidden input dengan input utama
            hiddenInput.val(initialValue);

            // Event handler untuk input utama
            input.on('input change', function() {
                let nilai = parseInt($(this).val()) || 0;

                // Batasi nilai antara 0-10
                nilai = Math.min(Math.max(nilai, 0), 10);
                $(this).val(nilai);

                // Sinkronkan dengan hidden input
                hiddenInput.val(nilai);

                updateButton(nilai);
            });

            // Event handler untuk hidden input (jika diubah manual)
            hiddenInput.on('input change', function() {
                let nilai = parseInt($(this).val()) || 0;

                // Batasi nilai antara 0-10
                nilai = Math.min(Math.max(nilai, 0), 10);
                $(this).val(nilai);

                // Sinkronkan dengan input utama
                input.val(nilai);

                updateButton(nilai);
            });

            // Fungsi untuk update button
            function updateButton(nilai) {
                let buttonClass, textNyeri;

                if (nilai === 0) {
                    buttonClass = 'btn-success';
                    textNyeri = 'Tidak Nyeri';
                } else if (nilai >= 1 && nilai <= 3) {
                    buttonClass = 'btn-success';
                    textNyeri = 'Nyeri Ringan';
                } else if (nilai >= 4 && nilai <= 5) {
                    buttonClass = 'btn-warning';
                    textNyeri = 'Nyeri Sedang';
                } else if (nilai >= 6 && nilai <= 7) {
                    buttonClass = 'btn-warning';
                    textNyeri = 'Nyeri Berat';
                } else if (nilai >= 8 && nilai <= 9) {
                    buttonClass = 'btn-danger';
                    textNyeri = 'Nyeri Sangat Berat';
                } else if (nilai >= 10) {
                    buttonClass = 'btn-danger';
                    textNyeri = 'Nyeri Tak Tertahankan';
                }

                button
                    .removeClass('btn-success btn-warning btn-danger')
                    .addClass(buttonClass)
                    .text(textNyeri);
            }
        }

        // Inisialisasi saat dokumen ready
        $(document).ready(function() {
            initSkalaNyeri();
        });
    </script>
@endpush
