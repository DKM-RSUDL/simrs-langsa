@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>

    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            {{-- @include('components.navigation-ranap') --}}

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">

                        <a href="{{ url()->previous() }}" class="btn">
                            <i class="ti-arrow-left"></i> Kembali
                        </a>

                        <p class="text-muted mb-4">
                            <i class="bi bi-info-circle me-2"></i>
                            Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayananc
                        </p>

                        <div class="card-body">
                            <div class="mb-4">
                                <h5 class="mb-0">ANAMNESIS</h5>
                                <div class="card-body">
                                    <!-- Form group untuk semua input -->
                                    <div class="form-group">
                                        <!-- Keluhan Utama -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="bi bi-file-medical me-1 text-primary"></i>
                                                Keluhan utama/ Alasan masuk RS mulai, lama, pencetus:
                                            </label>
                                            <textarea class="form-control" id="keluhan_utama" name="keluhan_utama" rows="2"
                                                placeholder="Tuliskan keluhan utama dan alasan pasien masuk RS..."></textarea>
                                        </div>

                                        <!-- Riwayat Penyakit Sekarang -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="bi bi-clipboard-plus me-1 text-primary"></i>
                                                Riwayat penyakit sekarang:
                                            </label>
                                            <textarea class="form-control" id="riwayat_penyakit_sekarang" name="riwayat_penyakit_sekarang" rows="3"
                                                placeholder="Tuliskan riwayat penyakit yang sedang dialami..."></textarea>
                                        </div>

                                        <!-- Riwayat Penyakit Terdahulu -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="bi bi-calendar-minus me-1 text-primary"></i>
                                                Riwayat penyakit terdahulu:
                                            </label>
                                            <textarea class="form-control" id="riwayat_penyakit_terdahulu" name="riwayat_penyakit_terdahulu" rows="2"
                                                placeholder="Tuliskan riwayat penyakit yang pernah dialami sebelumnya..."></textarea>
                                        </div>

                                        <!-- Riwayat Penyakit Keluarga -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="bi bi-people me-1 text-primary"></i>
                                                Riwayat penyakit dalam keluarga:
                                            </label>
                                            <textarea class="form-control" id="riwayat_penyakit_keluarga" name="riwayat_penyakit_keluarga" rows="2"
                                                placeholder="Tuliskan riwayat penyakit yang ada dalam keluarga..."></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-4">

                                        <!-- Riwayat Pengobatan -->
                                        <h6 class="text-dark">Riwayat Pengobatan</h6>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="riwayat_pengobatan"
                                                        id="tidak_ada" value="tidak_ada" checked>
                                                    <label class="form-check-label" for="tidak_ada">Tidak ada</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="riwayat_pengobatan"
                                                        id="ada" value="ada">
                                                    <label class="form-check-label" for="ada">Ada</label>
                                                </div>
                                            </div>

                                            <div id="detail_pengobatan" class="mt-3" style="display: none;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light">Keterangan</span>
                                                            <textarea class="form-control" id="riwayat_pengobatan_text" rows="2"
                                                                placeholder="Tuliskan detail riwayat pengobatan pasien..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Riwayat Alergi -->
                                        <div class="mb-3">
                                            <h6 class="text-dark">Riwayat Alergi</h6>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-primary"
                                                id="btn-add-elergi-neurologi">
                                                <i class="fas fa-plus"></i> Tambah Alergi
                                            </a>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Jenis</th>
                                                        <th>Alergen</th>
                                                        <th>Reaksi</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="list-alergi">
                                                    <!-- Data will be populated here -->
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Status Present -->
                                        <h6 class="mb-0">STATUS PRESENT</h6>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <!-- Tekanan Darah -->
                                                <div class="col-md-6 mb-3">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text bg-light text-dark fw-bold"
                                                            style="width: 150px;">
                                                            Tek. Darah
                                                        </span>
                                                        <input type="text" class="form-control text-center"
                                                            id="tekanan_darah" name="tekanan_darah" placeholder="0">
                                                        <span class="input-group-text">mmHg</span>
                                                    </div>
                                                </div>

                                                <!-- Respirasi -->
                                                <div class="col-md-6 mb-3">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text bg-light text-dark fw-bold"
                                                            style="width: 150px;">
                                                            Respirasi
                                                        </span>
                                                        <input type="text" class="form-control text-center"
                                                            id="respirasi" name="respirasi" placeholder="0">
                                                        <span class="input-group-text">x/menit</span>
                                                    </div>
                                                </div>

                                                <!-- Suhu -->
                                                <div class="col-md-6 mb-3">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text bg-light text-dark fw-bold"
                                                            style="width: 150px;">
                                                            Suhu
                                                        </span>
                                                        <input type="text" class="form-control text-center"
                                                            id="suhu" name="suhu" placeholder="0">
                                                        <span class="input-group-text">°C</span>
                                                    </div>
                                                </div>

                                                <!-- Nadi -->
                                                <div class="col-md-6 mb-3">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text bg-light text-dark fw-bold"
                                                            style="width: 150px;">
                                                            Nadi
                                                        </span>
                                                        <input type="text" class="form-control text-center"
                                                            id="nadi" name="nadi" placeholder="0">
                                                        <span class="input-group-text">x/menit</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="border-3 border-primary">

                                        <h5 class="mb-0">PEMERIKSAAN FISIK:</h5>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- a. Kepala -->
                                                    <div class="mb-3 border-bottom pb-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-3">
                                                                <label class="form-label fw-bold">a. Kepala</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="kepala" id="kepala_normal" value="normal">
                                                                    <label class="form-check-label"
                                                                        for="kepala_normal">Normal</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="kepala" id="kepala_tidak_normal"
                                                                        value="tidak_normal">
                                                                    <label class="form-check-label"
                                                                        for="kepala_tidak_normal">Tidak Normal,
                                                                        jelaskan:</label>
                                                                </div>
                                                                <div class="mt-2 collapse" id="kepala_keterangan">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Jelaskan:">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- b. Mata -->
                                                    <div class="mb-3 border-bottom pb-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-3">
                                                                <label class="form-label fw-bold">b. Mata</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="mata" id="mata_normal" value="normal">
                                                                    <label class="form-check-label"
                                                                        for="mata_normal">Normal</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="mata" id="mata_tidak_normal"
                                                                        value="tidak_normal">
                                                                    <label class="form-check-label"
                                                                        for="mata_tidak_normal">Tidak Normal,
                                                                        jelaskan:</label>
                                                                </div>
                                                                <div class="mt-2 collapse" id="mata_keterangan">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Jelaskan:">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- c. THT -->
                                                    <div class="mb-3 border-bottom pb-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-3">
                                                                <label class="form-label fw-bold">c. THT</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="tht" id="tht_normal" value="normal">
                                                                    <label class="form-check-label"
                                                                        for="tht_normal">Normal</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="tht" id="tht_tidak_normal"
                                                                        value="tidak_normal">
                                                                    <label class="form-check-label"
                                                                        for="tht_tidak_normal">Tidak Normal,
                                                                        jelaskan:</label>
                                                                </div>
                                                                <div class="mt-2 collapse" id="tht_keterangan">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Jelaskan:">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- d. Leher -->
                                                    <div class="mb-3 border-bottom pb-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-3">
                                                                <label class="form-label fw-bold">d. Leher</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="leher" id="leher_normal" value="normal">
                                                                    <label class="form-check-label"
                                                                        for="leher_normal">Normal</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="leher" id="leher_tidak_normal"
                                                                        value="tidak_normal">
                                                                    <label class="form-check-label"
                                                                        for="leher_tidak_normal">Tidak Normal,
                                                                        jelaskan:</label>
                                                                </div>
                                                                <div class="mt-2 collapse" id="leher_keterangan">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Jelaskan:">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- e. Mulut -->
                                                    <div class="mb-3 border-bottom pb-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-3">
                                                                <label class="form-label fw-bold">e. Mulut</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="mulut" id="mulut_normal" value="normal">
                                                                    <label class="form-check-label"
                                                                        for="mulut_normal">Normal</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="mulut" id="mulut_tidak_normal"
                                                                        value="tidak_normal">
                                                                    <label class="form-check-label"
                                                                        for="mulut_tidak_normal">Tidak Normal,
                                                                        jelaskan:</label>
                                                                </div>
                                                                <div class="mt-2 collapse" id="mulut_keterangan">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Jelaskan:">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- f. Jantung -->
                                                    <div class="mb-3 border-bottom pb-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-3">
                                                                <label class="form-label fw-bold">f. Jantung dan
                                                                    pembuluh darah</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="jantung" id="jantung_normal"
                                                                        value="normal">
                                                                    <label class="form-check-label"
                                                                        for="jantung_normal">Normal</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="jantung" id="jantung_tidak_normal"
                                                                        value="tidak_normal">
                                                                    <label class="form-check-label"
                                                                        for="jantung_tidak_normal">Tidak Normal,
                                                                        jelaskan:</label>
                                                                </div>
                                                                <div class="mt-2 collapse" id="jantung_keterangan">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Jelaskan:">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- g. Thorax -->
                                                    <div class="mb-3 border-bottom pb-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-3">
                                                                <label class="form-label fw-bold">g. Thorax</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="thorax" id="thorax_normal" value="normal">
                                                                    <label class="form-check-label"
                                                                        for="thorax_normal">Normal</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="thorax" id="thorax_tidak_normal"
                                                                        value="tidak_normal">
                                                                    <label class="form-check-label"
                                                                        for="thorax_tidak_normal">Tidak Normal,
                                                                        jelaskan:</label>
                                                                </div>
                                                                <div class="mt-2 collapse" id="thorax_keterangan">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Jelaskan:">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- h. Abdomen -->
                                                    <div class="mb-3 border-bottom pb-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-3">
                                                                <label class="form-label fw-bold">h. Abdomen</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="abdomen" id="abdomen_normal"
                                                                        value="normal">
                                                                    <label class="form-check-label"
                                                                        for="abdomen_normal">Normal</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="abdomen" id="abdomen_tidak_normal"
                                                                        value="tidak_normal">
                                                                    <label class="form-check-label"
                                                                        for="abdomen_tidak_normal">Tidak Normal,
                                                                        jelaskan:</label>
                                                                </div>
                                                                <div class="mt-2 collapse" id="abdomen_keterangan">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Jelaskan:">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- i. Tulang Belakang -->
                                                    <div class="mb-3 border-bottom pb-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-3">
                                                                <label class="form-label fw-bold">i. Tulang Belakang
                                                                    dan Anggota gerak</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="tulang" id="tulang_normal" value="normal">
                                                                    <label class="form-check-label"
                                                                        for="tulang_normal">Normal</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="tulang" id="tulang_tidak_normal"
                                                                        value="tidak_normal">
                                                                    <label class="form-check-label"
                                                                        for="tulang_tidak_normal">Tidak Normal,
                                                                        jelaskan:</label>
                                                                </div>
                                                                <div class="mt-2 collapse" id="tulang_keterangan">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Jelaskan:">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- j. Genetalia -->
                                                    <div class="mb-3 border-bottom pb-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-3">
                                                                <label class="form-label fw-bold">j. Genetalia</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="genetalia" id="genetalia_normal"
                                                                        value="normal">
                                                                    <label class="form-check-label"
                                                                        for="genetalia_normal">Normal</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="genetalia" id="genetalia_tidak_normal"
                                                                        value="tidak_normal">
                                                                    <label class="form-check-label"
                                                                        for="genetalia_tidak_normal">Tidak Normal,
                                                                        jelaskan:</label>
                                                                </div>
                                                                <div class="mt-2 collapse" id="genetalia_keterangan">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Jelaskan:">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- k. Status lokasi -->
                                                    <div class="mb-3 border-bottom pb-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-3">
                                                                <label class="form-label fw-bold">k. Status
                                                                    lokasi</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="status_lokasi" id="status_lokasi_normal"
                                                                        value="normal">
                                                                    <label class="form-check-label"
                                                                        for="status_lokasi_normal">Normal</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="status_lokasi"
                                                                        id="status_lokasi_tidak_normal"
                                                                        value="tidak_normal">
                                                                    <label class="form-check-label"
                                                                        for="status_lokasi_tidak_normal">Tidak Normal,
                                                                        jelaskan:</label>
                                                                </div>
                                                                <div class="mt-2 collapse" id="status_lokasi_keterangan">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Jelaskan:">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <hr class="border-3 border-primary">

                                        <div class="card-body">
                                            <h5 class="fw-bold mb-4">I. Sistem Syaraf</h5>

                                            <!-- Kesadaran -->
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label>Kesadaran Kualitatif</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label>Kesadaran Kuantitatif</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="input-group">
                                                        <span class="input-group-text">E:</span>
                                                        <input type="text" class="form-control">
                                                        <span class="input-group-text">M:</span>
                                                        <input type="text" class="form-control">
                                                        <span class="input-group-text">V:</span>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Pupil -->
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label>Pupil</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="input-group">
                                                        <span class="input-group-text">Isokor/anisokor:</span>
                                                        <input type="text" class="form-control">
                                                        <span class="input-group-text">Ø:</span>
                                                        <input type="text" class="form-control" style="width: 60px">
                                                        <span class="input-group-text">mm</span>
                                                    </div>
                                                    <div class="mt-2 d-flex gap-4">
                                                        <!-- Refleks Cahaya -->
                                                        <div class="d-flex align-items-center">
                                                            <div class="form-check me-2">
                                                                <label class="form-check-label" for="refleks_cahaya">
                                                                    Refleks cahaya:
                                                                </label>
                                                            </div>
                                                            <div class="input-group" style="width: 150px;">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Kiri">
                                                                <span class="input-group-text">/</span>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Kanan">
                                                            </div>
                                                        </div>

                                                        <!-- Refleks Kornea -->
                                                        <div class="d-flex align-items-center">
                                                            <div class="form-check me-2">
                                                                <label class="form-check-label" for="refleks_kornea">
                                                                    Refleks kornea:
                                                                </label>
                                                            </div>
                                                            <div class="input-group" style="width: 150px;">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Kiri">
                                                                <span class="input-group-text">/</span>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Kanan">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Nervus Cranialis -->
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label>Nervus Cranialis</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>

                                            <!-- Ekstremitas -->
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label>Ekstremitas</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Gerakan:</label>
                                                            <div class="border p-3 text-center">
                                                                <img src="{{ asset('assets/img/icons/gerakan_neurologi.png') }}"
                                                                    alt="gerakan neurologi" width="30">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Kekuatan:</label>
                                                            <div class="border p-3 text-center">
                                                                <img src="{{ asset('assets/img/icons/gerakan_neurologi.png') }}"
                                                                    alt="gerakan neurologi" width="30">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Refleks -->
                                            <div class="row mb-3">
                                                <div class="col-md-2"></div>
                                                <div class="col-md-10">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Refleks Fisiologis:</label>
                                                            <div class="border p-3 text-center">
                                                                <img src="{{ asset('assets/img/icons/gerakan_neurologi.png') }}"
                                                                    alt="gerakan neurologi" width="30">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Refleks Patologis:</label>
                                                            <div class="border p-3 text-center">
                                                                <img src="{{ asset('assets/img/icons/gerakan_neurologi.png') }}"
                                                                    alt="gerakan neurologi" width="30">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="">
                                                <!-- Section 1: -->
                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label fw-medium">Klonus</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Kiri">
                                                                <span class="input-group-text border-secondary">/</span>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Kanan">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label fw-medium">Laseque</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Kiri">
                                                                <span class="input-group-text border-secondary">/</span>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Kanan">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label fw-medium">Patrick</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Kiri">
                                                                <span class="input-group-text border-secondary">/</span>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Kanan">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label class="form-label fw-medium">Kontra Patrick</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Kiri">
                                                                <span class="input-group-text border-secondary">/</span>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Kanan">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Section 2: -->
                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-medium">Kaku Kuduk</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                placeholder="Hasil pemeriksaan">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-medium">Tes Brudzinski</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                placeholder="Hasil pemeriksaan">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-medium">Tanda Kernig</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                placeholder="Hasil pemeriksaan">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Section 3: -->
                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label">Nistagmus</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                placeholder="Hasil pemeriksaan">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Dismitri</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                placeholder="Hasil pemeriksaan">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Disdiadokokinesis</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                placeholder="Hasil pemeriksaan">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Section 4: -->
                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-medium">Tes Romberg</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                placeholder="Hasil tes">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-medium">Ataksia</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                placeholder="Ada/Tidak">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-medium">Cara Berjalan</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                placeholder="Deskripsi cara berjalan">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Section 5: -->
                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Tremor</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                placeholder="Ada/Tidak">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Khorea</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                placeholder="Ada/Tidak">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Balismus</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                placeholder="Ada/Tidak">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Atetose</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                placeholder="Ada/Tidak">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Sensibilitas -->
                                                <div class="row mb-3">
                                                    <div class="col-md-2">
                                                        <label>Sensibilitas:</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>

                                                <!-- Fungsi Vegetatif -->
                                                <div class="row mb-3">
                                                    <div class="col-md-2">
                                                        <label>Fungsi Vegetatif:</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="input-group">
                                                            <span class="input-group-text">Miksi:</span>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                        <div class="input-group mt-2">
                                                            <span class="input-group-text">Defekasi:</span>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <hr class="border-3 border-primary">

                                        <div class="card-body">
                                            <h5 class="fw-bold mb-4">m. Intensitas Nyeri</h5>

                                            <div class="row mt-4">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <p class="fw-bold">
                                                            Skala Nyeri
                                                        </p>
                                                        <input type="number" name="skala_nyeri"
                                                            class="form-control @error('skala_nyeri') is-invalid @enderror"
                                                            min="0" max="10" style="width: 200px;"
                                                            value="{{ old('skala_nyeri', 0) }}">
                                                        @error('skala_nyeri')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                        <button type="button" class="btn btn-sm btn-success mt-2"
                                                            id="skalaNyeriBtn">
                                                            Tidak Nyeri
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <img src="{{ asset('assets/img/cppt/cppt.jpeg') }}" alt="Skala Nyeri"
                                                        class="img-fluid">
                                                </div>
                                            </div>

                                            <!-- Diagnosis Banding -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="bi bi-file-medical me-1 text-primary"></i>
                                                    Diagnosis Banding:
                                                </label>
                                                <textarea class="form-control form-control-sm" id="diagnosis_banding" name="diagnosis_banding" rows="2"></textarea>
                                            </div>

                                            <!-- Diagnosis Kerja -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="bi bi-clipboard2-pulse me-1 text-primary"></i>
                                                    Diagnosis Kerja:
                                                </label>
                                                <textarea class="form-control form-control-sm" id="diagnosis_kerja" name="diagnosis_kerja" rows="2"></textarea>
                                            </div>

                                            <!-- Rencana Penatalaksanaan -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="bi bi-clipboard2-check me-1 text-primary"></i>
                                                    Rencana Penatalaksanaan Dan Pengobatan:
                                                </label>
                                                <textarea class="form-control form-control-sm" id="rencana_penatalaksanaan" name="rencana_penatalaksanaan"
                                                    rows="4"></textarea>
                                            </div>

                                            <!-- Prognosis -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="bi bi-graph-up me-1 text-primary"></i>
                                                    Prognosis:
                                                </label>
                                                <textarea class="form-control form-control-sm" id="prognosis" name="prognosis" rows="2"></textarea>
                                            </div>

                                        </div>

                                        <hr class="border-3 border-primary">

                                        <div class="border-0">
                                            <!-- Header Section -->
                                            <h6 class="mb-0 fw-bold text-primary">
                                                <i class="bi bi-hospital me-2"></i>
                                                PERENCANAAN PULANG PASIEN (DISCHARGE PLANNING)
                                            </h6>

                                            <!-- Main Content -->
                                            <div class="card-body pt-4">
                                                <!-- Checklist Questions -->
                                                <div class="row g-4">
                                                    <!-- Usia Lanjut -->
                                                    <div class="col-lg-6">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between border-bottom pb-2">
                                                            <label class="form-check-label">Usia lanjut (> 60 th)</label>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <input type="radio" class="btn-check"
                                                                    name="usia_lanjut" id="usia_ya" value="ya">
                                                                <label class="btn btn-outline-primary px-4"
                                                                    for="usia_ya">Ya</label>
                                                                <input type="radio" class="btn-check"
                                                                    name="usia_lanjut" id="usia_tidak" value="tidak">
                                                                <label class="btn btn-outline-primary px-4"
                                                                    for="usia_tidak">Tidak</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Hambatan Mobilisasi -->
                                                    <div class="col-lg-6">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between border-bottom pb-2">
                                                            <label class="form-check-label">Hambatan mobilisasi</label>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <input type="radio" class="btn-check"
                                                                    name="hambatan_mobilisasi" id="hambatan_ya"
                                                                    value="ya">
                                                                <label class="btn btn-outline-primary px-4"
                                                                    for="hambatan_ya">Ya</label>
                                                                <input type="radio" class="btn-check"
                                                                    name="hambatan_mobilisasi" id="hambatan_tidak"
                                                                    value="tidak">
                                                                <label class="btn btn-outline-primary px-4"
                                                                    for="hambatan_tidak">Tidak</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Membutuhkan pelayanan -->
                                                    <div class="col-lg-6">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between border-bottom pb-2">
                                                            <label class="form-check-label">Membutuhkan pelayanan medis
                                                                berkelanjutan</label>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <input type="radio" class="btn-check"
                                                                    name="pelayanan_medis" id="pelayanan_ya"
                                                                    value="ya">
                                                                <label class="btn btn-outline-primary px-4"
                                                                    for="pelayanan_ya">Ya</label>
                                                                <input type="radio" class="btn-check"
                                                                    name="pelayanan_medis" id="pelayanan_tidak"
                                                                    value="tidak">
                                                                <label class="btn btn-outline-primary px-4"
                                                                    for="pelayanan_tidak">Tidak</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Ketergantungan -->
                                                    <div class="col-lg-6">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between border-bottom pb-2">
                                                            <label class="form-check-label">Ketergantungan dengan orang
                                                                lain dalam aktivitas harian</label>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <input type="radio" class="btn-check"
                                                                    name="ketergantungan" id="ketergantungan_ya"
                                                                    value="ya">
                                                                <label class="btn btn-outline-primary px-4"
                                                                    for="ketergantungan_ya">Ya</label>
                                                                <input type="radio" class="btn-check"
                                                                    name="ketergantungan" id="ketergantungan_tidak"
                                                                    value="tidak">
                                                                <label class="btn btn-outline-primary px-4"
                                                                    for="ketergantungan_tidak">Tidak</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Info Alert -->
                                                <div class="alert alert-warning bg-opacity-10 border border-warning border-opacity-25 mt-4 mb-4"
                                                    id="discharge-planning-label">
                                                    <small class="d-flex align-items-center">
                                                        Tidak membutuhkan rencana pulang
                                                        khusus
                                                    </small>
                                                </div>

                                                <!-- Tambahkan id dan name yang spesifik untuk form fields -->
                                                <div class="mb-4">
                                                    <label class="form-label fw-semibold mb-2">Rencana Pulang
                                                        Khusus:</label>
                                                    <textarea class="form-control bg-light" id="rencana_pulang_khusus" name="rencana_pulang_khusus" rows="3"
                                                        placeholder="Tuliskan rencana pulang khusus jika diperlukan..." style="resize: none;" disabled></textarea>
                                                </div>

                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label fw-semibold mb-2">Rencana Lama
                                                                Perawatan:</label>
                                                            <input type="text" class="form-control bg-light"
                                                                id="rencana_lama_perawatan" name="rencana_lama_perawatan"
                                                                placeholder="Contoh: 7 hari" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label fw-semibold mb-2">Rencana Tanggal
                                                                Pulang:</label>
                                                            <input type="date" class="form-control bg-light"
                                                                id="rencana_tanggal_pulang" name="rencana_tanggal_pulang"
                                                                disabled>
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
            </div>
        </div>
    </div>
@endsection

@include('unit-pelayanan.rawat-inap.pelayanan.neurologi.modal-create-elergi')
@push('js')
    <script>
        $(document).ready(function() {
            // Fungsi untuk Status Present - validasi input numerik
            function initStatusPresent() {
                const statusInputs = ['#tekanan_darah', '#respirasi', '#suhu', '#nadi'];
                statusInputs.forEach(input => {
                    $(input).on('input', function(e) {
                        this.value = this.value.replace(/[^0-9.]/g, '');
                    });

                    $(input).on('blur', function(e) {
                        if (this.value !== '') {
                            this.value = parseFloat(this.value).toFixed(1);
                        }
                    });
                });
            }

            // Fungsi untuk Textarea Auto-resize
            function initTextareaAutoResize() {
                $('textarea.form-control').on('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
            }

            // Fungsi untuk Auto-save draft
            function initAutosave() {
                let timeoutId;
                $('textarea.form-control').on('input', function() {
                    const element = this;
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(() => {
                        localStorage.setItem(element.id, element.value);
                    }, 1000);
                });

                // Load saved drafts
                $('textarea.form-control').each(function() {
                    const savedValue = localStorage.getItem(this.id);
                    if (savedValue) {
                        this.value = savedValue;
                        this.style.height = 'auto';
                        this.style.height = (this.scrollHeight) + 'px';
                    }
                });
            }

            // Fungsi untuk Riwayat Pengobatan
            function initRiwayatPengobatan() {
                $('input[name="riwayat_pengobatan"]').change(function() {
                    const detailPengobatan = $('#detail_pengobatan');
                    const textArea = $('#riwayat_pengobatan_text');

                    if ($(this).val() === 'ada') {
                        detailPengobatan.slideDown();
                        textArea.focus();
                    } else {
                        detailPengobatan.slideUp();
                        textArea.val('');
                    }
                });
            }

            // Fungsi Pemeriksaan Fisik
            function initPemeriksaanFisik() {
                $('input[type="radio"]').on('change', function() {
                    const name = $(this).attr('name');
                    const keteranganDiv = $('#' + name + '_keterangan');
                    if ($(this).val() === 'tidak_normal') {
                        keteranganDiv.addClass('show');
                    } else {
                        keteranganDiv.removeClass('show');
                    }
                });
            }

            // Fungsi Skala Nyeri
            function initSkalaNyeri() {
                $('input[name="skala_nyeri"]').on('input change', function() {
                    let nilai = parseInt($(this).val()) || 0;

                    // Batasi nilai antara 0-10
                    if (nilai > 10) {
                        nilai = 10;
                        $(this).val(10);
                    }
                    if (nilai < 0) {
                        nilai = 0;
                        $(this).val(0);
                    }

                    // Tentukan class dan text berdasarkan nilai
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

                    // Update button
                    $('#skalaNyeriBtn')
                        .removeClass('btn-success btn-warning btn-danger')
                        .addClass(buttonClass)
                        .text(textNyeri);
                });
            }

            // DISCHARGE PLANNING
            function initDischargePlanning() {
                // Ambil semua radio button dan form fields yang terkait
                const radioButtons = $(
                    'input[type="radio"][name^="usia_lanjut"], input[type="radio"][name^="hambatan_mobilisasi"], input[type="radio"][name^="pelayanan_medis"], input[type="radio"][name^="ketergantungan"]'
                );
                const rencanaPulangField = $('textarea.form-control.bg-light');
                const rencanaLamaField = $('input.form-control.bg-light[type="text"]');
                const rencanaTanggalField = $('input.form-control.bg-light[type="date"]');

                // Fungsi untuk mengecek apakah ada jawaban "ya"
                function checkYesAnswers() {
                    let hasYes = false;
                    radioButtons.filter(':checked').each(function() {
                        if ($(this).val() === 'ya') {
                            hasYes = true;
                            return false; // Break loop
                        }
                    });
                    return hasYes;
                }

                // Fungsi untuk mengatur status form fields
                function updateFormFields() {
                    const needsSpecialPlan = checkYesAnswers();
                    const fields = [rencanaPulangField, rencanaLamaField, rencanaTanggalField];
                    let dclabel = $('#discharge-planning-label');

                    fields.forEach(field => {
                        if (needsSpecialPlan) {
                            field.prop('disabled', false)
                                .removeClass('bg-light')
                                .addClass('bg-white')
                                .prop('required', true);

                            // remove and add class label
                            $(dclabel).removeClass('alert-warning');
                            $(dclabel).addClass('alert-success');

                            $(dclabel).removeClass('border-warning');
                            $(dclabel).addClass('border-success');

                            $(dclabel).find('small').text('Membutuhkan rencana pulang khusus')
                        } else {
                            field.prop('disabled', true)
                                .removeClass('bg-white')
                                .addClass('bg-light')
                                .prop('required', false)
                                .val(''); // Clear values when disabled

                            // remove and add class label
                            $(dclabel).removeClass('alert-success');
                            $(dclabel).addClass('alert-warning');

                            $(dclabel).removeClass('border-success');
                            $(dclabel).addClass('border-warning');

                            $(dclabel).find('small').text('Tidak membutuhkan rencana pulang khusus')
                        }
                    });
                }

                // Event listener untuk radio buttons
                radioButtons.on('change', updateFormFields);

                // Set default state untuk form fields (semua disabled)
                radioButtons.filter('[value="tidak"]').prop('checked', true);
                updateFormFields();
            }

            // Initialize all functions
            function init() {
                initStatusPresent();
                initTextareaAutoResize();
                initAutosave();
                initRiwayatPengobatan();
                initPemeriksaanFisik();
                initSkalaNyeri();
                initDischargePlanning();
            }

            // Run initialization
            init();

            // Trigger initial value untuk skala nyeri
            $('input[name="skala_nyeri"]').trigger('input');
        });
    </script>
@endpush
