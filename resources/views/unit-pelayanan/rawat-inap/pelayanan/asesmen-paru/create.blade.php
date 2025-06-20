@extends('layouts.administrator.master')

@section('content')


    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-paru.create-include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-asesmen-tht')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-info mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="kd_pasien" value="{{ $dataMedis->kd_pasien }}">
                <input type="hidden" name="kd_unit" value="{{ $dataMedis->kd_unit }}">
                <input type="hidden" name="tgl_masuk" value="{{ $dataMedis->tgl_masuk }}">
                <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">

                <div class="card">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <h4 class="header-asesmen">Asesmen Awal Medis Paru</h4>
                                    <p class="text-muted">
                                        Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- FORM ASESMEN -->
                        <div class="px-3">
                            <div class="section-separator" id="data-masuk">
                                <h5 class="section-title">1. Data masuk</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}">
                                        <input type="time" class="form-control" name="jam_masuk" value="{{ date('H:i') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="section-separator" id="alergi">
                                <h5 class="section-title">2. Anamnesis</h5>

                                <div class="form-group">
                                    <label>Anamnesa</label>
                                    <textarea class="form-control" name="anamnesa" rows="3"
                                        placeholder="Keluhan utama pasien"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Riwayat penyakit</label>
                                    <textarea class="form-control" name="riwayat_penyakit" rows="4"
                                        placeholder="Riwayat penyakit sekarang"></textarea>
                                </div>
                            </div>

                            <div class="section-separator" id="alergi">

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
                            </div>
                            

                            <!-- 3. Riwayat Penyakit Terdahulu Dan Riwayat Pengobatan -->
                            <div class="section-separator" id="riwayat-pengobatan">
                                <h5 class="section-title">3. Riwayat Penyakit Terdahulu Dan Riwayat Pengobatan</h5>

                                <div class="table-responsive">
                                    <table class="table table-asesmen">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 50%;">Riwayat Penyakit Terdahulu (RPT)
                                                </th>
                                                <th class="text-center" style="width: 50%;">Riwayat Penggunaan Obat (RPO)
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="p-0">
                                                    <textarea class="form-control border-0 rounded-0"
                                                        name="riwayat_penyakit_terdahulu" rows="5"
                                                        placeholder="Tuliskan riwayat penyakit terdahulu..."
                                                        style="resize: none; min-height: 120px;"></textarea>
                                                </td>
                                                <td class="p-0">
                                                    <textarea class="form-control border-0 rounded-0"
                                                        name="riwayat_penggunaan_obat" rows="5"
                                                        placeholder="Tuliskan riwayat penggunaan obat..."
                                                        style="resize: none; min-height: 120px;"></textarea>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- 4. Kebiasaan -->
                            <div class="section-separator" id="kebiasaan">
                                <h5 class="section-title">4. Kebiasaan</h5>

                                <div class="table-responsive">
                                    <table class="table table-asesmen">
                                        <tbody>
                                            <tr>
                                                <td class="label-col">a. Merokok</td>
                                                <td>
                                                    <div class="form-check-group d-flex align-items-center gap-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="merokok" value="tidak" id="merokok_tidak" checked>
                                                            <label class="form-check-label" for="merokok_tidak">Tidak</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="merokok" value="ya" id="merokok_ya">
                                                            <label class="form-check-label" for="merokok_ya">Ya, jumlah:</label>
                                                        </div>
                                                        <input type="number" class="form-control input-inline input-sm @error('merokok_jumlah') is-invalid @enderror"
                                                            name="merokok_jumlah" id="merokok_jumlah" min="0" placeholder="0" disabled>
                                                        <span>batang/hari</span>
                                                        <span class="ms-2">Lama:</span>
                                                        <input type="number" class="form-control input-inline input-sm @error('merokok_lama') is-invalid @enderror"
                                                            name="merokok_lama" id="merokok_lama" min="0" placeholder="0" disabled>
                                                        <span>tahun</span>
                                                        @error('merokok_jumlah')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        @error('merokok_lama')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col">b. Alkohol</td>
                                                <td>
                                                    <div class="form-check-group d-flex align-items-center gap-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="alkohol" value="tidak" id="alkohol_tidak" checked>
                                                            <label class="form-check-label" for="alkohol_tidak">Tidak</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="alkohol" value="ya" id="alkohol_ya">
                                                            <label class="form-check-label" for="alkohol_ya">Ya, jumlah:</label>
                                                        </div>
                                                        <input type="text" class="form-control input-inline input-lg @error('alkohol_jumlah') is-invalid @enderror"
                                                            name="alkohol_jumlah" id="alkohol_jumlah" placeholder="Jumlah konsumsi" disabled>
                                                        @error('alkohol_jumlah')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col">c. Obat-obatan</td>
                                                <td>
                                                    <div class="form-check-group d-flex align-items-center gap-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="obat_obatan" value="tidak" id="obat_tidak" checked>
                                                            <label class="form-check-label" for="obat_tidak">Tidak</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="obat_obatan" value="ya" id="obat_ya">
                                                            <label class="form-check-label" for="obat_ya">Ya, jenis:</label>
                                                        </div>
                                                        <input type="text" class="form-control input-inline input-lg @error('obat_jenis') is-invalid @enderror"
                                                            name="obat_jenis" id="obat_jenis" placeholder="Jenis obat" disabled>
                                                        @error('obat_jenis')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- 5. Tanda-Tanda Vital -->
                            <div class="section-separator" id="tanda-vital">
                                <h5 class="section-title">5. Tanda-Tanda Vital</h5>

                                <div class="table-responsive">
                                    <table class="table table-asesmen">
                                        <tbody>
                                            <tr>
                                                <td class="label-col">a. Sensorium</td>
                                                <td>
                                                    <div class="form-check-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="sensorium"
                                                                value="cm" id="sensorium_cm">
                                                            <label class="form-check-label" for="sensorium_cm">CM</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="sensorium"
                                                                value="cm_lemah" id="sensorium_cm_lemah">
                                                            <label class="form-check-label" for="sensorium_cm_lemah">CM
                                                                lemah</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="sensorium"
                                                                value="somnolen" id="sensorium_somnolen">
                                                            <label class="form-check-label"
                                                                for="sensorium_somnolen">Somnolen</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="sensorium"
                                                                value="soporus" id="sensorium_soporus">
                                                            <label class="form-check-label"
                                                                for="sensorium_soporus">Soporus</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="sensorium"
                                                                value="coma" id="sensorium_coma">
                                                            <label class="form-check-label"
                                                                for="sensorium_coma">Coma</label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col">b. Keadaan umum</td>
                                                <td>
                                                    <div class="form-check-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="keadaan_umum"
                                                                value="baik" id="keadaan_baik">
                                                            <label class="form-check-label" for="keadaan_baik">Baik</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="keadaan_umum"
                                                                value="sedang" id="keadaan_sedang">
                                                            <label class="form-check-label"
                                                                for="keadaan_sedang">Sedang</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="keadaan_umum"
                                                                value="jelek" id="keadaan_jelek">
                                                            <label class="form-check-label"
                                                                for="keadaan_jelek">Jelek</label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col">c. Tekanan darah</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="form-group">
                                                            <div class="d-flex gap-3" style="width: 100%;">
                                                                <div class="flex-grow-1">
                                                                    <input type="number" class="form-control"
                                                                        name="darah_sistole" placeholder="Sistole">
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <input type="number" class="form-control"
                                                                        name="darah_diastole" placeholder="Diastole">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col">d. Nadi/pulse</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <input type="number"
                                                                    class="form-control input-inline input-sm" name="nadi">
                                                                <span>x/menit</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col">e. Frekuensi Pernafasan</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <input type="number"
                                                                    class="form-control input-inline input-sm"
                                                                    name="frekuensi_pernafasan">
                                                                <span>x/menit</span>
                                                                <select class="form-select input-inline input-md"
                                                                    name="pernafasan_tipe">
                                                                    <option value="">Pilih</option>
                                                                    <option value="reguler">Reguler</option>
                                                                    <option value="irreguler">Irreguler</option>
                                                                </select>
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col">f. Temperatur</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <input type="number"
                                                                    class="form-control input-inline input-sm"
                                                                    name="temperatur" step="0.1">
                                                                <span>°C</span>
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col">g. Saturasi Oksigen</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <input type="number"
                                                                    class="form-control input-inline input-sm"
                                                                    name="saturasi_oksigen" min="0" max="100">
                                                                <span>%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col">Cyanosis</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-check-group">                                                                
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="cyanose" value="tidak" id="cyanose_tidak">
                                                                    <label class="form-check-label"
                                                                        for="cyanose_tidak">Tidak</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="cyanose" value="ya" id="cyanose_ya">
                                                                    <label class="form-check-label"
                                                                        for="cyanose_ya">Ya</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col">Dyspnea</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-check-group">                                                                
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="dyspnoe" value="tidak" id="dyspnoe_tidak">
                                                                    <label class="form-check-label"
                                                                        for="dyspnoe_tidak">Tidak</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="dyspnoe" value="ya" id="dyspnoe_ya">
                                                                    <label class="form-check-label"
                                                                        for="dyspnoe_ya">Ya</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>                                            
                                            <tr>
                                                <td class="label-col">Oedema</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-check-group">                                                                
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="oedema" value="tidak" id="oedema_tidak">
                                                                    <label class="form-check-label"
                                                                        for="oedema_tidak">Tidak</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="oedema" value="ya" id="oedema_ya">
                                                                    <label class="form-check-label"
                                                                        for="oedema_ya">Ya</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col">Icterus</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-check-group">                                                                
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="icterus" value="tidak" id="icterus_tidak">
                                                                    <label class="form-check-label"
                                                                        for="icterus_tidak">Tidak</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="icterus" value="ya" id="icterus_ya">
                                                                    <label class="form-check-label"
                                                                        for="icterus_ya">Ya</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col">Anemia</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-check-group">                                                                
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="anemia" value="tidak" id="anemia_tidak">
                                                                    <label class="form-check-label"
                                                                        for="anemia_tidak">Tidak</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="anemia" value="ya" id="anemia_ya">
                                                                    <label class="form-check-label"
                                                                        for="anemia_ya">Ya</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- 6. Pemeriksaan Fisik -->
                            <div class="section-separator" id="pemeriksaan-fisik">
                                <h5 class="section-title">6. Pemeriksaan Fisik</h5>
                                {{-- baru --}}
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
                                                                        <input class="form-check-input" type="radio" name="paru_kepala" value="1" id="paru_kepala_normal" checked>
                                                                        <label class="form-check-label" for="paru_kepala_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="paru_kepala" value="0" id="paru_kepala_tidak_normal">
                                                                        <label class="form-check-label" for="paru_kepala_tidak_normal">Tidak Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="paru_kepala_keterangan" id="paru_kepala_keterangan" 
                                                                        placeholder="Keterangan jika tidak normal..." disabled>
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
                                                                        <input class="form-check-input" type="radio" name="paru_mata" value="1" id="paru_mata_normal" checked>
                                                                        <label class="form-check-label" for="paru_mata_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="paru_mata" value="0" id="paru_mata_tidak_normal">
                                                                        <label class="form-check-label" for="paru_mata_tidak_normal">Tidak Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="paru_mata_keterangan" id="paru_mata_keterangan" 
                                                                        placeholder="Keterangan jika tidak normal..." disabled>
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
                                                                        <input class="form-check-input" type="radio" name="paru_tht" value="1" id="paru_tht_normal" checked>
                                                                        <label class="form-check-label" for="paru_tht_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="paru_tht" value="0" id="paru_tht_tidak_normal">
                                                                        <label class="form-check-label" for="paru_tht_tidak_normal">Tidak Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="paru_tht_keterangan" id="paru_tht_keterangan" 
                                                                        placeholder="Keterangan jika tidak normal..." disabled>
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
                                                                        <input class="form-check-input" type="radio" name="paru_leher" value="1" id="paru_leher_normal" checked>
                                                                        <label class="form-check-label" for="paru_leher_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="paru_leher" value="0" id="paru_leher_tidak_normal">
                                                                        <label class="form-check-label" for="paru_leher_tidak_normal">Tidak Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="paru_leher_keterangan" id="paru_leher_keterangan" 
                                                                        placeholder="Keterangan jika tidak normal..." disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Thoraks -->
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="fw-semibold">e. Thoraks</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <!-- Jantung -->
                                                                <div class="mb-3">
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label class="fw-medium">Jantung:</label>
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <div class="d-flex align-items-center gap-3">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input" type="radio" name="paru_jantung" value="1" id="paru_jantung_normal" checked>
                                                                                    <label class="form-check-label" for="paru_jantung_normal">Normal</label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input" type="radio" name="paru_jantung" value="0" id="paru_jantung_tidak_normal">
                                                                                    <label class="form-check-label" for="paru_jantung_tidak_normal">Tidak Normal</label>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="paru_jantung_keterangan" id="paru_jantung_keterangan" 
                                                                                    placeholder="Keterangan jika tidak normal..." disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Paru -->
                                                                <div class="mb-3">
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label class="fw-medium">Paru:</label>
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <!-- Inspeksi -->
                                                                            <div class="row mb-2">
                                                                                <div class="col-md-3">
                                                                                    <label class="text-muted">Inspeksi</label>
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                    <div class="d-flex align-items-center gap-2">
                                                                                        <span>:</span>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input" type="radio" name="paru_inspeksi" value="simetris" id="paru_inspeksi_simetris">
                                                                                            <label class="form-check-label" for="paru_inspeksi_simetris">Simetris</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input" type="radio" name="paru_inspeksi" value="asimetris" id="paru_inspeksi_asimetris">
                                                                                            <label class="form-check-label" for="paru_inspeksi_asimetris">Asimetris</label>
                                                                                        </div>
                                                                                        <span>:</span>
                                                                                        <input type="text" class="form-control input-inline" name="paru_inspeksi_keterangan" placeholder="Keterangan">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Palpasi -->
                                                                            <div class="row mb-2">
                                                                                <div class="col-md-3">
                                                                                    <label class="text-muted">Palpasi</label>
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                    <div class="d-flex align-items-center gap-2">
                                                                                        <span>:</span>
                                                                                        <input type="text" class="form-control" name="paru_palpasi" placeholder="Hasil palpasi">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Perkusi -->
                                                                            <div class="row mb-2">
                                                                                <div class="col-md-3">
                                                                                    <label class="text-muted">Perkusi</label>
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                    <div class="d-flex align-items-center gap-2">
                                                                                        <span>:</span>
                                                                                        <input type="text" class="form-control" name="paru_perkusi" placeholder="Hasil perkusi">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Auskultasi -->
                                                                            <div class="row mb-3">
                                                                                <div class="col-md-3">
                                                                                    <label class="text-muted">Auskultasi</label>
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                    <div class="d-flex align-items-center gap-2">
                                                                                        <span>:</span>
                                                                                        <input type="text" class="form-control" name="paru_auskultasi" placeholder="Hasil auskultasi">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Suara Pernafasan (SP) -->
                                                                            <div class="row mb-2">
                                                                                <div class="col-md-3">
                                                                                    <label class="text-muted">Suara Pernafasan (SP):</label>
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                    <div class="d-flex flex-wrap gap-3">
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-pernafasan" type="checkbox" value="vesikuler" id="sp_vesikuler">
                                                                                            <label class="form-check-label" for="sp_vesikuler">Vesikuler</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-pernafasan" type="checkbox" value="vesikuler_melemah" id="sp_vesikuler_melemah">
                                                                                            <label class="form-check-label" for="sp_vesikuler_melemah">Vesikuler Melemah</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-pernafasan" type="checkbox" value="ekspirasi_memanjang" id="sp_ekspirasi_memanjang">
                                                                                            <label class="form-check-label" for="sp_ekspirasi_memanjang">Ekspirasi Memanjang</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-pernafasan" type="checkbox" value="vesikuler_mengeras" id="sp_vesikuler_mengeras">
                                                                                            <label class="form-check-label" for="sp_vesikuler_mengeras">Vesikuler Mengeras</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-pernafasan" type="checkbox" value="bronkial" id="sp_bronkial">
                                                                                            <label class="form-check-label" for="sp_bronkial">Bronkial</label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Hidden input untuk menampung JSON -->
                                                                                    <input type="hidden" name="paru_suara_pernafasan" id="paru_suara_pernafasan_json">
                                                                                </div>
                                                                            </div>

                                                                            <!-- Suara Tambahan (ST) -->
                                                                            <div class="row mb-2">
                                                                                <div class="col-md-3">
                                                                                    <label class="text-muted">Suara Tambahan (ST):</label>
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                    <div class="d-flex flex-wrap gap-3">
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-tambahan" type="checkbox" value="rhonkhi_basah_halus" id="st_rhonkhi_basah_halus">
                                                                                            <label class="form-check-label" for="st_rhonkhi_basah_halus">Rhonkhi Basah Halus</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-tambahan" type="checkbox" value="rhonkhi_basah_kasar" id="st_rhonkhi_basah_kasar">
                                                                                            <label class="form-check-label" for="st_rhonkhi_basah_kasar">Rhonkhi Basah Kasar</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-tambahan" type="checkbox" value="rhonkhi_kering" id="st_rhonkhi_kering">
                                                                                            <label class="form-check-label" for="st_rhonkhi_kering">Rhonkhi Kering</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-tambahan" type="checkbox" value="wheezing" id="st_wheezing">
                                                                                            <label class="form-check-label" for="st_wheezing">Wheezing</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-tambahan" type="checkbox" value="amforik" id="st_amforik">
                                                                                            <label class="form-check-label" for="st_amforik">Amforik</label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Hidden input untuk menampung JSON -->
                                                                                    <input type="hidden" name="paru_suara_tambahan" id="paru_suara_tambahan_json">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
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

                            <div class="mt-4">
                                <h6>Site Marking - Penandaan Anatomi Paru</h6>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="site-marking-container position-relative">
                                            <img src="{{ asset('assets/images/sitemarking/paru.jpg') }}" 
                                                 id="paruAnatomyImage" 
                                                 class="img-fluid" 
                                                 style="max-width: 100%;">
                                            <canvas id="paruMarkingCanvas" 
                                                    class="position-absolute top-0 start-0" 
                                                    style="cursor: crosshair; z-index: 10;">
                                            </canvas>
                                        </div>
                                        <div class="mt-2">
                                            <small class="text-muted">
                                                <strong>Cara Pakai:</strong> Pilih warna, klik dan drag untuk membuat coret/marking di area yang ingin ditandai.
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="marking-controls">
                                            <h6>Kontrol Penandaan Paru</h6>
                                            
                                            <!-- Pilihan Warna -->
                                            <div class="mb-3">
                                                <label class="form-label">Pilih Warna:</label>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <button type="button" class="paru-color-btn active" data-color="#dc3545" style="background: #dc3545; width: 35px; height: 35px; border: 2px solid #dee2e6; border-radius: 6px; cursor: pointer;"></button>
                                                    <button type="button" class="paru-color-btn" data-color="#198754" style="background: #198754; width: 35px; height: 35px; border: 2px solid #dee2e6; border-radius: 6px; cursor: pointer;"></button>
                                                    <button type="button" class="paru-color-btn" data-color="#0d6efd" style="background: #0d6efd; width: 35px; height: 35px; border: 2px solid #dee2e6; border-radius: 6px; cursor: pointer;"></button>
                                                    <button type="button" class="paru-color-btn" data-color="#fd7e14" style="background: #fd7e14; width: 35px; height: 35px; border: 2px solid #dee2e6; border-radius: 6px; cursor: pointer;"></button>
                                                    <button type="button" class="paru-color-btn" data-color="#6f42c1" style="background: #6f42c1; width: 35px; height: 35px; border: 2px solid #dee2e6; border-radius: 6px; cursor: pointer;"></button>
                                                    <button type="button" class="paru-color-btn" data-color="#000000" style="background: #000000; width: 35px; height: 35px; border: 2px solid #dee2e6; border-radius: 6px; cursor: pointer;"></button>
                                                </div>
                                            </div>
                                            
                                            <!-- Ketebalan Brush -->
                                            <div class="mb-3">
                                                <label class="form-label">Ketebalan Brush:</label>
                                                <input type="range" id="paruBrushSize" class="form-range" min="1" max="5" value="2" step="0.5">
                                                <small class="text-muted">Ukuran: <span id="paruBrushSizeValue">2</span>px</small>
                                            </div>
                                            
                                            <!-- Keterangan -->
                                            <div class="mb-3">
                                                <label class="form-label">Keterangan (opsional):</label>
                                                <input type="text" id="paruMarkingNote" class="form-control" placeholder="Contoh: Ronkhi basah, Wheezing">
                                            </div>
                                            
                                            <!-- Tombol Kontrol -->
                                            <div class="d-grid gap-2">
                                                <button type="button" class="btn btn-outline-primary" id="paruSaveMarking">
                                                    <i class="ti-save"></i> Simpan Penandaan
                                                </button>
                                                <button type="button" class="btn btn-outline-warning" id="paruUndoLast">
                                                    <i class="ti-back-left"></i> Undo Terakhir
                                                </button>
                                                <button type="button" class="btn btn-outline-danger" id="paruClearAll">
                                                    <i class="ti-trash"></i> Hapus Semua
                                                </button>
                                            </div>
                                            
                                            <!-- Daftar Penandaan -->
                                            <div class="paru-marking-list mt-3">
                                                <h6>Daftar Penandaan (<span id="paruMarkingCount">0</span>):</h6>
                                                <div id="paruMarkingsList" class="list-group" style="max-height: 250px; overflow-y: auto;">
                                                    <div class="text-muted text-center py-3" id="paruEmptyState">
                                                        <i class="ti-info-alt"></i> Belum ada penandaan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="site_marking_paru_data" id="siteMarkingParuData" value="">
                            </div>
                                {{-- end baru --}}
                                {{-- <div class="row g-3">
                                    <div class="pemeriksaan-fisik">
                                        <p class="text-small">Centang normal jika fisik yang dinilai
                                            normal,
                                            pilih tanda tambah
                                            untuk menambah keterangan fisik yang ditemukan tidak normal.
                                            Jika
                                            tidak dipilih salah satunya, maka pemeriksaan tidak
                                            dilakukan.
                                        </p>
                                        <div class="row">
                                            @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-column gap-3">
                                                        @foreach ($chunk as $item)
                                                            <div class="pemeriksaan-item">
                                                                <div class="d-flex align-items-center border-bottom pb-2">
                                                                    <div class="flex-grow-1">{{ $item->nama }}
                                                                    </div>
                                                                    <div class="form-check me-3">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="{{ $item->id }}-normal"
                                                                            name="{{ $item->id }}-normal" checked>
                                                                        <label class="form-check-label"
                                                                            for="{{ $item->id }}-normal">Normal</label>
                                                                    </div>
                                                                    <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                        type="button" data-target="{{ $item->id }}-keterangan">
                                                                        <i class="bi bi-plus"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="keterangan mt-2" id="{{ $item->id }}-keterangan"
                                                                    style="display:none;">
                                                                    <input type="text" class="form-control"
                                                                        name="{{ $item->id }}_keterangan"
                                                                        placeholder="Tambah keterangan jika tidak normal...">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div> --}}
                            </div>


                            <!-- 7. Rencana Kerja Dan Penatalaksanaan -->
                            <div class="section-separator" id="rencana-kerja">
                                <h5 class="section-title">7. Rencana Kerja Dan Penatalaksanaan</h5>
                                <div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">a.</span> Foto thoraks</label>
                                        <input type="checkbox" name="foto_thoraks" value="1" class="form-check-input" id="foto_thoraks">
                                        @error('foto_thoraks')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">b.</span> Pemeriksaan darah rutin</label>
                                        <input type="checkbox" name="darah_rutin" value="1" class="form-check-input" id="darah_rutin">
                                        @error('darah_rutin')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">c.</span> Pemeriksaan LED</label>
                                        <input type="checkbox" name="led" value="1" class="form-check-input" id="led">
                                        @error('led')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">d.</span> Pemeriksaan sputum BTA</label>
                                        <input type="checkbox" name="sputum_bta" value="1" class="form-check-input" id="sputum_bta">
                                        @error('sputum_bta')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">e.</span> Pemeriksaan KGDS</label>
                                        <input type="checkbox" name="kgds" value="1" class="form-check-input" id="kgds">
                                        @error('igds')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">f.</span> Pemeriksaan faal hati (LFT)</label>
                                        <input type="checkbox" name="faal_hati" value="1" class="form-check-input" id="faal_hati">
                                        @error('faal_ginjal')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">g.</span> Pemeriksaan faal ginjal (RFT)</label>
                                        <input type="checkbox" name="faal_ginjal" value="1" class="form-check-input" id="faal_ginjal">
                                        @error('faal_ginjal')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">h.</span> Pemeriksaan elektrolit</label>
                                        <input type="checkbox" name="elektrolit" value="1" class="form-check-input" id="elektrolit">
                                        @error('elektrolit')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">i.</span> Pemeriksaan albumin</label>
                                        <input type="checkbox" name="albumin" value="1" class="form-check-input" id="albumin">
                                        @error('albumin')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">j.</span> Pemeriksaan asam urat</label>
                                        <input type="checkbox" name="asam_urat" value="1" class="form-check-input" id="asam_urat">
                                        @error('asam_urat')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">k.</span> Faal paru (APE, spirometri)</label>
                                        <input type="checkbox" name="faal_paru" value="1" class="form-check-input" id="faal_paru">
                                        @error('faal_paru')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">l.</span> CT Scan thoraks</label>
                                        <input type="checkbox" name="ct_scan_thoraks" value="1" class="form-check-input" id="ct_scan_thoraks">
                                        @error('ct_scan_thoraks')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">m.</span> Bronchoscopy</label>
                                        <input type="checkbox" name="bronchoscopy" value="1" class="form-check-input" id="bronchoscopy">
                                        @error('bronchoscopy')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">n.</span> Proef Punctie</label>
                                        <input type="checkbox" name="proef_punctie" value="1" class="form-check-input" id="proef_punctie">
                                        @error('proef_punctie')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">o.</span> Aspirasi cairan pleura</label>
                                        <input type="checkbox" name="aspirasi_cairan_pleura" value="1" class="form-check-input" id="aspirasi_cairan_pleura">
                                        @error('aspirasi_cairan_pleura')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">p.</span> Penanganan WSD</label>
                                        <input type="checkbox" name="penanganan_wsd" value="1" class="form-check-input" id="penanganan_wsd">
                                        @error('penanganan_wsd')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">q.</span> Biopsi Kelenjar</label>
                                        <input type="checkbox" name="biopsi_kelenjar" value="1" class="form-check-input" id="penanganan_penyakit">
                                        @error('penanganan_penyakit')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">r.</span> Mantoux Tes</label>
                                        <input type="checkbox" name="mantoux_tes" value="1" class="form-check-input" id="konsul">
                                        @error('konsul')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">s.</span> Lainnya</label>
                                        <div class="d-flex gap-2 align-items-center">
                                            <input type="checkbox" name="lainnya_check" value="1" class="form-check-input" id="lainnya_check">
                                            <input type="text" class="form-control @error('lainnya') is-invalid @enderror" name="lainnya" id="lainnya" placeholder="Masukkan rencana lainnya" disabled>
                                            @error('lainnya')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- 8. Perencanaan Pulang Pasien -->
                            <div class="section-separator" id="discharge-planning">
                                <h5 class="section-title">8. Perencanaan Pulang Pasien (Discharge Planning)</h5>

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

                                <!-- Tombol Reset (Opsional) -->
                                <div class="mt-3">
                                    <button type="button" class="btn btn-secondary" onclick="resetDischargePlanning()">
                                        Reset Discharge Planning
                                    </button>
                                </div>
                            </div>

                            <!-- 9. Diagnosis -->
                            <div class="section-separator" id="diagnosis">
                                <h5 class="fw-semibold mb-4">9. Diagnosis</h5>

                                <div class="mb-4">
                                    <label class="text-primary fw-semibold">Prognosis</label>
                                    
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
                                    <input type="hidden" id="diagnosis_banding" name="diagnosis_banding" value="[]">
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

                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-kulitkelamin.modal-create-alergi')


@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                radio.addEventListener('change', function () {
                    inputs.forEach(input => {
                        input.disabled = this.value !== yesValue;
                        if (this.value !== yesValue) {
                            input.value = ''; // Clear input when disabled
                            input.classList.remove('is-invalid'); // Remove validation error styling
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
        document.querySelector('form').addEventListener('submit', function (event) {
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


    document.addEventListener('DOMContentLoaded', function () {
        // Toggle 'lainnya' input based on checkbox
        const lainnyaCheck = document.getElementById('lainnya_check');
        const lainnyaInput = document.getElementById('lainnya');

        // Initialize state
        lainnyaInput.disabled = !lainnyaCheck.checked;
        if (!lainnyaCheck.checked) {
            lainnyaInput.value = '';
        }

        // Add event listener to checkbox
        lainnyaCheck.addEventListener('change', function () {
            lainnyaInput.disabled = !this.checked;
            if (!this.checked) {
                lainnyaInput.value = '';
                lainnyaInput.classList.remove('is-invalid');
            }
        });

        // Client-side validation on form submission
        document.querySelector('form').addEventListener('submit', function (event) {
            let errors = [];

            // Validate 'lainnya' field
            if (lainnyaCheck.checked && !lainnyaInput.value.trim()) {
                errors.push('Rencana lainnya wajib diisi jika dicentang.');
                lainnyaInput.classList.add('is-invalid');
            } else {
                lainnyaInput.classList.remove('is-invalid');
            }

            // If there are errors, prevent submission and show alert
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

    // pemeriksaan fisik baru
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
                        keteranganInput.value = '';
                    }
                });
            });

            // Initialize state
            const selectedRadio = Array.from(radios).find(radio => radio.checked);
            if (selectedRadio) {
                keteranganInput.disabled = selectedRadio.value !== '0';
            }
        }

        // Apply toggle functionality to all pemeriksaan fisik items
        toggleKeteranganInput('paru_kepala', 'paru_kepala_keterangan');
        toggleKeteranganInput('paru_mata', 'paru_mata_keterangan');
        toggleKeteranganInput('paru_tht', 'paru_tht_keterangan');
        toggleKeteranganInput('paru_leher', 'paru_leher_keterangan');
        toggleKeteranganInput('paru_jantung', 'paru_jantung_keterangan');

        // Function to update JSON hidden input based on checkbox selections
        function updateCheckboxJSON(checkboxClass, hiddenInputId) {
            const checkboxes = document.querySelectorAll('.' + checkboxClass);
            const hiddenInput = document.getElementById(hiddenInputId);
            
            function updateJSON() {
                const selectedValues = [];
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedValues.push(checkbox.value);
                    }
                });
                
                // Update hidden input dengan format JSON yang diinginkan: ["vesikuler","wheezing"]
                hiddenInput.value = selectedValues.length > 0 ? JSON.stringify(selectedValues) : '';
                
                // Debug log untuk melihat hasil
                console.log(`${hiddenInputId}:`, hiddenInput.value);
            }
            
            // Add event listeners to all checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateJSON);
            });
            
            // Initialize on page load
            updateJSON();
        }

        // Apply checkbox JSON functionality
        updateCheckboxJSON('paru-suara-pernafasan', 'paru_suara_pernafasan_json');
        updateCheckboxJSON('paru-suara-tambahan', 'paru_suara_tambahan_json');

        // Form validation before submit
        document.querySelector('form').addEventListener('submit', function(e) {
            // Update JSON values one more time before submit
            const paruSuaraPernafasanCheckboxes = document.querySelectorAll('.paru-suara-pernafasan:checked');
            const paruSuaraTambahanCheckboxes = document.querySelectorAll('.paru-suara-tambahan:checked');
            
            const suaraPernafasanValues = Array.from(paruSuaraPernafasanCheckboxes).map(cb => cb.value);
            const suaraTambahanValues = Array.from(paruSuaraTambahanCheckboxes).map(cb => cb.value);
            
            document.getElementById('paru_suara_pernafasan_json').value = suaraPernafasanValues.length > 0 ? JSON.stringify(suaraPernafasanValues) : '';
            document.getElementById('paru_suara_tambahan_json').value = suaraTambahanValues.length > 0 ? JSON.stringify(suaraTambahanValues) : '';
            
            console.log('Final Suara Pernafasan:', document.getElementById('paru_suara_pernafasan_json').value);
            console.log('Final Suara Tambahan:', document.getElementById('paru_suara_tambahan_json').value);
        });
    });

    // Inisialisasi Site Marking Paru - letakkan di bagian akhir JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        initParuSiteMarking();
    });

    function initParuSiteMarking() {
        const image = document.getElementById('paruAnatomyImage');
        const canvas = document.getElementById('paruMarkingCanvas');
        
        // Check if elements exist
        if (!image || !canvas) {
            console.error('Paru site marking elements not found');
            return;
        }
        
        const ctx = canvas.getContext('2d');
        const markingsList = document.getElementById('paruMarkingsList');
        const siteMarkingData = document.getElementById('siteMarkingParuData');
        const markingNote = document.getElementById('paruMarkingNote');
        const clearAllBtn = document.getElementById('paruClearAll');
        const undoBtn = document.getElementById('paruUndoLast');
        const saveBtn = document.getElementById('paruSaveMarking');
        const markingCount = document.getElementById('paruMarkingCount');
        const emptyState = document.getElementById('paruEmptyState');
        const brushSizeSlider = document.getElementById('paruBrushSize');
        const brushSizeValue = document.getElementById('paruBrushSizeValue');
        
        let savedMarkings = []; // Array untuk menyimpan penandaan yang sudah disimpan
        let currentStroke = []; // Array untuk stroke yang sedang digambar
        let allStrokes = []; // Array untuk semua stroke (termasuk yang belum disimpan)
        let markingCounter = 1;
        let currentColor = '#dc3545';
        let currentBrushSize = 2;
        let isDrawing = false;
        let lastX = 0;
        let lastY = 0;
        
        // Initialize
        initParuColorSelection();
        setupParuCanvas();
        loadParuExistingData();
        
        function setupParuCanvas() {
            function updateCanvasSize() {
                const rect = image.getBoundingClientRect();
                canvas.width = image.offsetWidth;
                canvas.height = image.offsetHeight;
                canvas.style.width = image.offsetWidth + 'px';
                canvas.style.height = image.offsetHeight + 'px';
                
                // Redraw all strokes
                redrawParuCanvas();
            }
            
            // Update canvas size when image loads
            image.onload = updateCanvasSize;
            
            // Update canvas size when window resizes
            window.addEventListener('resize', updateCanvasSize);
            
            // Initial setup
            if (image.complete) {
                updateCanvasSize();
            }
        }
        
        function initParuColorSelection() {
            document.querySelectorAll('.paru-color-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    currentColor = this.getAttribute('data-color');
                    updateParuColorSelection();
                });
            });
        }
        
        function updateParuColorSelection() {
            document.querySelectorAll('.paru-color-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            const selectedBtn = document.querySelector(`.paru-color-btn[data-color="${currentColor}"]`);
            if (selectedBtn) {
                selectedBtn.classList.add('active');
            }
        }
        
        // Brush size slider
        brushSizeSlider.addEventListener('input', function() {
            currentBrushSize = parseFloat(this.value);
            brushSizeValue.textContent = currentBrushSize;
        });
        
        // Mouse events for drawing
        canvas.addEventListener('mousedown', function(e) {
            isDrawing = true;
            const rect = canvas.getBoundingClientRect();
            lastX = e.clientX - rect.left;
            lastY = e.clientY - rect.top;
            
            // Start new stroke
            currentStroke = [{
                x: (lastX / canvas.width) * 100,
                y: (lastY / canvas.height) * 100,
                color: currentColor,
                size: currentBrushSize
            }];
        });
        
        canvas.addEventListener('mousemove', function(e) {
            if (!isDrawing) return;
            
            const rect = canvas.getBoundingClientRect();
            const currentX = e.clientX - rect.left;
            const currentY = e.clientY - rect.top;
            
            // Add point to current stroke dengan interpolasi untuk smooth line
            const distance = Math.sqrt(Math.pow(currentX - lastX, 2) + Math.pow(currentY - lastY, 2));
            
            // Hanya tambah point jika jarak cukup untuk menghindari point yang terlalu rapat
            if (distance > 1) {
                currentStroke.push({
                    x: (currentX / canvas.width) * 100,
                    y: (currentY / canvas.height) * 100,
                    color: currentColor,
                    size: currentBrushSize
                });
                
                // Draw smooth line dengan quadratic curve
                ctx.globalCompositeOperation = 'source-over';
                ctx.strokeStyle = currentColor;
                ctx.lineWidth = currentBrushSize;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.globalAlpha = 0.8; // Sedikit transparansi untuk efek natural
                
                // Menggunakan quadratic curve untuk smooth line
                const midX = (lastX + currentX) / 2;
                const midY = (lastY + currentY) / 2;
                
                ctx.beginPath();
                ctx.moveTo(lastX, lastY);
                ctx.quadraticCurveTo(lastX, lastY, midX, midY);
                ctx.stroke();
                
                lastX = currentX;
                lastY = currentY;
            }
        });
        
        canvas.addEventListener('mouseup', function(e) {
            if (!isDrawing) return;
            isDrawing = false;
            
            // Add current stroke to all strokes if it has points
            if (currentStroke.length > 1) {
                allStrokes.push([...currentStroke]);
            }
        });
        
        // Save current drawing as a marking
        saveBtn.addEventListener('click', function() {
            if (allStrokes.length === 0) {
                alert('Tidak ada penandaan untuk disimpan. Silakan gambar terlebih dahulu.');
                return;
            }
            
            const note = markingNote.value.trim() || `Penandaan Paru ${markingCounter}`;
            
            const marking = {
                id: `paru_mark_${Date.now()}`,
                strokes: JSON.parse(JSON.stringify(allStrokes)), // Deep copy
                note: note,
                timestamp: new Date().toISOString()
            };
            
            savedMarkings.push(marking);
            
            // Add to list
            addToParuMarkingsList(marking);
            
            // Update hidden input and counter
            updateParuHiddenInput();
            updateParuMarkingCount();
            
            // Clear note input and current drawing
            markingNote.value = '';
            allStrokes = [];
            currentStroke = [];
            markingCounter++;
            
            // Clear canvas and redraw only saved markings
            redrawParuCanvas();
            
            alert('Penandaan berhasil disimpan!');
        });
        
        // Undo last stroke
        undoBtn.addEventListener('click', function() {
            if (allStrokes.length === 0) {
                alert('Tidak ada stroke untuk di-undo.');
                return;
            }
            
            allStrokes.pop();
            redrawParuCanvas();
        });
        
        // Clear all markings
        clearAllBtn.addEventListener('click', function() {
            if (savedMarkings.length === 0 && allStrokes.length === 0) {
                alert('Tidak ada penandaan untuk dihapus.');
                return;
            }
            
            if (confirm('Hapus semua penandaan? Tindakan ini tidak dapat dibatalkan.')) {
                savedMarkings = [];
                allStrokes = [];
                currentStroke = [];
                markingsList.innerHTML = '<div class="text-muted text-center py-3" id="paruEmptyState"><i class="ti-info-alt"></i> Belum ada penandaan</div>';
                updateParuHiddenInput();
                updateParuMarkingCount();
                redrawParuCanvas();
                markingCounter = 1;
            }
        });
        
        function redrawParuCanvas() {
            // Clear canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // Draw all saved markings
            savedMarkings.forEach(marking => {
                drawStrokesOnCanvas(marking.strokes);
            });
            
            // Draw current unsaved strokes
            drawStrokesOnCanvas(allStrokes);
        }
        
        function drawStrokesOnCanvas(strokesArray) {
            strokesArray.forEach(stroke => {
                if (stroke.length < 2) return;
                
                ctx.strokeStyle = stroke[0].color;
                ctx.lineWidth = stroke[0].size;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.globalAlpha = 0.8; // Transparansi untuk efek natural
                
                ctx.beginPath();
                const firstPoint = stroke[0];
                ctx.moveTo(
                    (firstPoint.x / 100) * canvas.width,
                    (firstPoint.y / 100) * canvas.height
                );
                
                // Menggunakan smooth curve untuk redraw
                for (let i = 1; i < stroke.length - 1; i++) {
                    const currentPoint = stroke[i];
                    const nextPoint = stroke[i + 1];
                    
                    const currentX = (currentPoint.x / 100) * canvas.width;
                    const currentY = (currentPoint.y / 100) * canvas.height;
                    const nextX = (nextPoint.x / 100) * canvas.width;
                    const nextY = (nextPoint.y / 100) * canvas.height;
                    
                    const midX = (currentX + nextX) / 2;
                    const midY = (currentY + nextY) / 2;
                    
                    ctx.quadraticCurveTo(currentX, currentY, midX, midY);
                }
                
                // Terakhir, gambar ke point terakhir
                if (stroke.length > 1) {
                    const lastPoint = stroke[stroke.length - 1];
                    ctx.lineTo(
                        (lastPoint.x / 100) * canvas.width,
                        (lastPoint.y / 100) * canvas.height
                    );
                }
                
                ctx.stroke();
                ctx.globalAlpha = 1; // Reset alpha
            });
        }
        
        function addToParuMarkingsList(marking) {
            // Hide empty state
            const emptyStateEl = document.getElementById('paruEmptyState');
            if (emptyStateEl) {
                emptyStateEl.style.display = 'none';
            }
            
            const listItem = document.createElement('div');
            listItem.className = 'paru-marking-list-item';
            listItem.setAttribute('data-marking-id', marking.id);
            
            listItem.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-semibold">${marking.note}</div>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <span class="badge bg-secondary" style="font-size: 10px;">CORET</span>
                            <small class="text-muted">${new Date(marking.timestamp).toLocaleTimeString('id-ID')}</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteParuMarking('${marking.id}')">
                        <i class="ti-trash"></i>
                    </button>
                </div>
            `;
            
            markingsList.appendChild(listItem);
        }
        
        function updateParuMarkingCount() {
            markingCount.textContent = savedMarkings.length;
            
            // Show/hide empty state
            const emptyStateEl = document.getElementById('paruEmptyState');
            if (emptyStateEl) {
                if (savedMarkings.length === 0) {
                    emptyStateEl.style.display = 'block';
                } else {
                    emptyStateEl.style.display = 'none';
                }
            }
        }
        
        function updateParuHiddenInput() {
            siteMarkingData.value = JSON.stringify(savedMarkings);
        }
        
        function loadParuExistingData() {
            try {
                const existingData = JSON.parse(siteMarkingData.value || '[]');
                if (existingData.length > 0) {
                    savedMarkings = existingData;
                    markingCounter = savedMarkings.length + 1;
                    
                    // Rebuild list
                    markingsList.innerHTML = '<div class="text-muted text-center py-3" id="paruEmptyState"><i class="ti-info-alt"></i> Belum ada penandaan</div>';
                    savedMarkings.forEach(marking => {
                        addToParuMarkingsList(marking);
                    });
                    
                    updateParuMarkingCount();
                    
                    // Redraw canvas after a short delay
                    setTimeout(() => {
                        redrawParuCanvas();
                    }, 100);
                }
            } catch (e) {
                console.error('Error loading existing paru marking data:', e);
            }
        }
        
        // Global function for delete
        window.deleteParuMarking = function(markingId) {
            if (confirm('Hapus penandaan ini?')) {
                // Remove from array
                savedMarkings = savedMarkings.filter(m => m.id !== markingId);
                
                // Remove from list
                const listElement = markingsList.querySelector(`[data-marking-id="${markingId}"]`);
                if (listElement) {
                    markingsList.removeChild(listElement);
                }
                
                updateParuHiddenInput();
                updateParuMarkingCount();
                redrawParuCanvas();
            }
        };
    }

    </script>
@endpush
