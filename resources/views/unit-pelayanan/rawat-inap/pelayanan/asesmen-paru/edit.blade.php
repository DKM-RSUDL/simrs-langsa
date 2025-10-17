@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-paru.edit-include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-asesmen-tht')
        </div>

        <div class="col-md-9">
            <x-content-card>
            <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Edit Asesmen Awal Medis Paru',
                    'description' => 'Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan',
                ])

            <form method="POST" enctype="multipart/form-data"
                action="{{ route('rawat-inap.asesmen.medis.paru.update', [
                    'kd_unit' => request()->route('kd_unit'),
                    'kd_pasien' => request()->route('kd_pasien'),
                    'tgl_masuk' => request()->route('tgl_masuk'),
                    'urut_masuk' => request()->route('urut_masuk'),
                    'id' => $asesmen->id,
                ]) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="kd_pasien" value="{{ $dataMedis->kd_pasien }}">
                <input type="hidden" name="kd_unit" value="{{ $dataMedis->kd_unit }}">
                <input type="hidden" name="tgl_masuk" value="{{ $dataMedis->tgl_masuk }}">
                <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">

                <!-- FORM ASESMEN -->
                <div class="px-3">
                    <!-- 1. Data masuk -->
                    <div class="section-separator" id="data-masuk">
                        <h5 class="section-title">1. Data masuk</h5>

                        <div class="form-group">
                            <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                            <div class="d-flex gap-3" style="width: 100%;">
                                <input type="date" class="form-control" name="tanggal"
                                    value="{{ $asesmen->rmeAsesmenParu->tanggal ? date('Y-m-d', strtotime($asesmen->rmeAsesmenParu->tanggal)) : date('Y-m-d') }}">
                                <input type="time" class="form-control" name="jam_masuk"
                                    value="{{ $asesmen->rmeAsesmenParu->jam_masuk ? \Carbon\Carbon::parse($asesmen->rmeAsesmenParu->jam_masuk)->format('H:i') : date('H:i') }}">
                            </div>
                        </div>
                    </div>

                    <!-- 2. Anamnesis -->
                    <div class="section-separator" id="anamnesis">
                        <h5 class="section-title">2. Anamnesis</h5>

                        <div class="form-group">
                            <label>Anamnesa</label>
                            <textarea class="form-control" name="anamnesa" rows="3" placeholder="Keluhan utama pasien">{{ $asesmen->rmeAsesmenParu->anamnesa ?? '' }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Riwayat penyakit</label>
                            <textarea class="form-control" name="riwayat_penyakit" rows="4" placeholder="Riwayat penyakit sekarang">{{ $asesmen->rmeAsesmenParu->riwayat_penyakit ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="section-separator" id="alergi">

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
                                        <td colspan="5" class="text-center text-muted">Tidak ada data
                                            alergi</td>
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
                                            <textarea class="form-control border-0 rounded-0" name="riwayat_penyakit_terdahulu" rows="5"
                                                placeholder="Tuliskan riwayat penyakit terdahulu..." style="resize: none; min-height: 120px;">{{ $asesmen->rmeAsesmenParu->riwayat_penyakit_terdahulu ?? '' }}</textarea>
                                        </td>
                                        <td class="p-0">
                                            <textarea class="form-control border-0 rounded-0" name="riwayat_penggunaan_obat" rows="5"
                                                placeholder="Tuliskan riwayat penggunaan obat..." style="resize: none; min-height: 120px;">{{ $asesmen->rmeAsesmenParu->riwayat_penggunaan_obat ?? '' }}</textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                  
                    <!-- 4. Kebiasaan -->
                    <div class="section-separator" id="kebiasaan">
                        <h5 class="section-title">4. Kebiasaan</h5>
                         @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-paru.KebiasaanForm.index',['KebiasaanData'=> !empty($KebiasaanData) ? $KebiasaanData : null])
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
                                                @php $currentSensorium = $asesmen->rmeAsesmenParu->sensorium ?? ''; @endphp
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="sensorium" value="cm" id="sensorium_cm"
                                                        {{ $currentSensorium == 'cm' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="sensorium_cm">CM</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="sensorium" value="cm_lemah" id="sensorium_cm_lemah"
                                                        {{ $currentSensorium == 'cm_lemah' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="sensorium_cm_lemah">CM
                                                        lemah</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="sensorium" value="somnolen" id="sensorium_somnolen"
                                                        {{ $currentSensorium == 'somnolen' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="sensorium_somnolen">Somnolen</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="sensorium" value="soporus" id="sensorium_soporus"
                                                        {{ $currentSensorium == 'soporus' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="sensorium_soporus">Soporus</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="sensorium" value="coma" id="sensorium_coma"
                                                        {{ $currentSensorium == 'coma' ? 'checked' : '' }}>
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
                                                @php $currentKeadaanUmum = $asesmen->rmeAsesmenParu->keadaan_umum ?? ''; @endphp
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="keadaan_umum" value="baik" id="keadaan_baik"
                                                        {{ $currentKeadaanUmum == 'baik' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="keadaan_baik">Baik</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="keadaan_umum" value="sedang" id="keadaan_sedang"
                                                        {{ $currentKeadaanUmum == 'sedang' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="keadaan_sedang">Sedang</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="keadaan_umum" value="jelek" id="keadaan_jelek"
                                                        {{ $currentKeadaanUmum == 'jelek' ? 'checked' : '' }}>
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
                                                                name="darah_sistole" placeholder="Sistole"
                                                                value="{{ $asesmen->rmeAsesmenParu->darah_sistole ?? '' }}">
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <input type="number" class="form-control"
                                                                name="darah_diastole" placeholder="Diastole"
                                                                value="{{ $asesmen->rmeAsesmenParu->darah_diastole ?? '' }}">
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
                                                            class="form-control input-inline input-sm"
                                                            name="nadi"
                                                            value="{{ $asesmen->rmeAsesmenParu->nadi ?? '' }}">
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
                                                            name="frekuensi_pernafasan"
                                                            value="{{ $asesmen->rmeAsesmenParu->frekuensi_pernafasan ?? '' }}">
                                                        <span>x/menit</span>
                                                        <select class="form-select input-inline input-md"
                                                            name="pernafasan_tipe">
                                                            <option value="">Pilih</option>
                                                            <option value="reguler"
                                                                {{ ($asesmen->rmeAsesmenParu->pernafasan_tipe ?? '') == 'reguler' ? 'selected' : '' }}>
                                                                Reguler</option>
                                                            <option value="irreguler"
                                                                {{ ($asesmen->rmeAsesmenParu->pernafasan_tipe ?? '') == 'irreguler' ? 'selected' : '' }}>
                                                                Irreguler
                                                            </option>
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
                                                            name="temperatur" step="0.1"
                                                            value="{{ $asesmen->rmeAsesmenParu->temperatur ?? '' }}">
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
                                                            name="saturasi_oksigen" min="0" max="100"
                                                            value="{{ $asesmen->rmeAsesmenParu->saturasi_oksigen ?? '' }}">
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
                                                        @php $currentCyanose = $asesmen->rmeAsesmenParu->cyanose ?? 'tidak'; @endphp
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="cyanose" value="tidak" id="cyanose_tidak"
                                                                {{ $currentCyanose == 'tidak' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="cyanose_tidak">Tidak</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="cyanose" value="ya" id="cyanose_ya"
                                                                {{ $currentCyanose == 'ya' ? 'checked' : '' }}>
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
                                                        @php $currentDyspnoe = $asesmen->rmeAsesmenParu->dyspnoe ?? 'tidak'; @endphp
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="dyspnoe" value="tidak" id="dyspnoe_tidak"
                                                                {{ $currentDyspnoe == 'tidak' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="dyspnoe_tidak">Tidak</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="dyspnoe" value="ya" id="dyspnoe_ya"
                                                                {{ $currentDyspnoe == 'ya' ? 'checked' : '' }}>
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
                                                        @php $currentOedema = $asesmen->rmeAsesmenParu->oedema ?? 'tidak'; @endphp
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="oedema" value="tidak" id="oedema_tidak"
                                                                {{ $currentOedema == 'tidak' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="oedema_tidak">Tidak</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="oedema" value="ya" id="oedema_ya"
                                                                {{ $currentOedema == 'ya' ? 'checked' : '' }}>
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
                                                        @php $currentIcterus = $asesmen->rmeAsesmenParu->icterus ?? 'tidak'; @endphp
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="icterus" value="tidak" id="icterus_tidak"
                                                                {{ $currentIcterus == 'tidak' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="icterus_tidak">Tidak</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="icterus" value="ya" id="icterus_ya"
                                                                {{ $currentIcterus == 'ya' ? 'checked' : '' }}>
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
                                                        @php $currentAnemia = $asesmen->rmeAsesmenParu->anemia ?? 'tidak'; @endphp
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="anemia" value="tidak" id="anemia_tidak"
                                                                {{ $currentAnemia == 'tidak' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="anemia_tidak">Tidak</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="anemia" value="ya" id="anemia_ya"
                                                                {{ $currentAnemia == 'ya' ? 'checked' : '' }}>
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

                    <!-- 6. Pemeriksaan Fisik - PERBAIKAN -->
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
                                                            @php
                                                                $pemeriksaanFisikParu = $asesmen->rmeAsesmenParuPemeriksaanFisik->first();
                                                            @endphp
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="paru_kepala" value="1"
                                                                    id="paru_kepala_normal"
                                                                    {{ ($pemeriksaanFisikParu->paru_kepala ?? 1) == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="paru_kepala_normal">Normal</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="paru_kepala" value="0"
                                                                    id="paru_kepala_tidak_normal"
                                                                    {{ ($pemeriksaanFisikParu->paru_kepala ?? 1) == 0 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="paru_kepala_tidak_normal">Tidak
                                                                    Normal</label>
                                                            </div>
                                                            <input type="text" class="form-control"
                                                                name="paru_kepala_keterangan"
                                                                id="paru_kepala_keterangan"
                                                                placeholder="Keterangan jika tidak normal..."
                                                                value="{{ $pemeriksaanFisikParu->paru_kepala_keterangan ?? '' }}"
                                                                {{ ($pemeriksaanFisikParu->paru_kepala ?? 1) == 1 ? 'disabled' : '' }}>
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
                                                                    name="paru_mata" value="1"
                                                                    id="paru_mata_normal"
                                                                    {{ ($pemeriksaanFisikParu->paru_mata ?? 1) == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="paru_mata_normal">Normal</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="paru_mata" value="0"
                                                                    id="paru_mata_tidak_normal"
                                                                    {{ ($pemeriksaanFisikParu->paru_mata ?? 1) == 0 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="paru_mata_tidak_normal">Tidak
                                                                    Normal</label>
                                                            </div>
                                                            <input type="text" class="form-control"
                                                                name="paru_mata_keterangan"
                                                                id="paru_mata_keterangan"
                                                                placeholder="Keterangan jika tidak normal..."
                                                                value="{{ $pemeriksaanFisikParu->paru_mata_keterangan ?? '' }}"
                                                                {{ ($pemeriksaanFisikParu->paru_mata ?? 1) == 1 ? 'disabled' : '' }}>
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
                                                                    name="paru_tht" value="1"
                                                                    id="paru_tht_normal"
                                                                    {{ ($pemeriksaanFisikParu->paru_tht ?? 1) == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="paru_tht_normal">Normal</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="paru_tht" value="0"
                                                                    id="paru_tht_tidak_normal"
                                                                    {{ ($pemeriksaanFisikParu->paru_tht ?? 1) == 0 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="paru_tht_tidak_normal">Tidak
                                                                    Normal</label>
                                                            </div>
                                                            <input type="text" class="form-control"
                                                                name="paru_tht_keterangan"
                                                                id="paru_tht_keterangan"
                                                                placeholder="Keterangan jika tidak normal..."
                                                                value="{{ $pemeriksaanFisikParu->paru_tht_keterangan ?? '' }}"
                                                                {{ ($pemeriksaanFisikParu->paru_tht ?? 1) == 1 ? 'disabled' : '' }}>
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
                                                                    name="paru_leher" value="1"
                                                                    id="paru_leher_normal"
                                                                    {{ ($pemeriksaanFisikParu->paru_leher ?? 1) == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="paru_leher_normal">Normal</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="paru_leher" value="0"
                                                                    id="paru_leher_tidak_normal"
                                                                    {{ ($pemeriksaanFisikParu->paru_leher ?? 1) == 0 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="paru_leher_tidak_normal">Tidak
                                                                    Normal</label>
                                                            </div>
                                                            <input type="text" class="form-control"
                                                                name="paru_leher_keterangan"
                                                                id="paru_leher_keterangan"
                                                                placeholder="Keterangan jika tidak normal..."
                                                                value="{{ $pemeriksaanFisikParu->paru_leher_keterangan ?? '' }}"
                                                                {{ ($pemeriksaanFisikParu->paru_leher ?? 1) == 1 ? 'disabled' : '' }}>
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
                                                                            <input class="form-check-input"
                                                                                type="radio" name="paru_jantung"
                                                                                value="1"
                                                                                id="paru_jantung_normal"
                                                                                {{ ($pemeriksaanFisikParu->paru_jantung ?? 1) == 1 ? 'checked' : '' }}>
                                                                            <label class="form-check-label"
                                                                                for="paru_jantung_normal">Normal</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                type="radio" name="paru_jantung"
                                                                                value="0"
                                                                                id="paru_jantung_tidak_normal"
                                                                                {{ ($pemeriksaanFisikParu->paru_jantung ?? 1) == 0 ? 'checked' : '' }}>
                                                                            <label class="form-check-label"
                                                                                for="paru_jantung_tidak_normal">Tidak
                                                                                Normal</label>
                                                                        </div>
                                                                        <input type="text" class="form-control"
                                                                            name="paru_jantung_keterangan"
                                                                            id="paru_jantung_keterangan"
                                                                            placeholder="Keterangan jika tidak normal..."
                                                                            value="{{ $pemeriksaanFisikParu->paru_jantung_keterangan ?? '' }}"
                                                                            {{ ($pemeriksaanFisikParu->paru_jantung ?? 1) == 1 ? 'disabled' : '' }}>
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
                                                                    <!-- Inspeksi - FIXED -->
                                                                    <div class="row mb-2">
                                                                        <div class="col-md-3">
                                                                            <label
                                                                                class="text-muted">Inspeksi</label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <div
                                                                                class="d-flex align-items-center gap-2">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        type="radio"
                                                                                        name="paru_inspeksi"
                                                                                        value="simetris"
                                                                                        id="paru_inspeksi_simetris"
                                                                                        {{ ($pemeriksaanFisikParu->paru_inspeksi ?? 'simetris') == 'simetris' ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                        for="paru_inspeksi_simetris">Simetris</label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        type="radio"
                                                                                        name="paru_inspeksi"
                                                                                        value="asimetris"
                                                                                        id="paru_inspeksi_asimetris"
                                                                                        {{ ($pemeriksaanFisikParu->paru_inspeksi ?? '') == 'asimetris' ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                        for="paru_inspeksi_asimetris">Asimetris</label>
                                                                                </div>
                                                                                <span>-</span>
                                                                                <input type="text"
                                                                                    class="form-control input-inline"
                                                                                    name="paru_inspeksi_keterangan"
                                                                                    id="paru_inspeksi_keterangan"
                                                                                    placeholder="Keterangan"
                                                                                    value="{{ $pemeriksaanFisikParu->paru_inspeksi_keterangan ?? '' }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Palpasi -->
                                                                    <div class="row mb-2">
                                                                        <div class="col-md-3">
                                                                            <label
                                                                                class="text-muted">Palpasi</label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <div
                                                                                class="d-flex align-items-center gap-2">
                                                                                <span>:</span>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="paru_palpasi"
                                                                                    placeholder="Hasil palpasi"
                                                                                    value="{{ $pemeriksaanFisikParu->paru_palpasi ?? '' }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Perkusi -->
                                                                    <div class="row mb-2">
                                                                        <div class="col-md-3">
                                                                            <label
                                                                                class="text-muted">Perkusi</label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <div
                                                                                class="d-flex align-items-center gap-2">
                                                                                <span>:</span>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="paru_perkusi"
                                                                                    placeholder="Hasil perkusi"
                                                                                    value="{{ $pemeriksaanFisikParu->paru_perkusi ?? '' }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Auskultasi -->
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-3">
                                                                            <label
                                                                                class="text-muted">Auskultasi</label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <div
                                                                                class="d-flex align-items-center gap-2">
                                                                                <span>:</span>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="paru_auskultasi"
                                                                                    placeholder="Hasil auskultasi"
                                                                                    value="{{ $pemeriksaanFisikParu->paru_auskultasi ?? '' }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Suara Pernafasan (SP) -->
                                                                    <div class="row mb-2">
                                                                        <div class="col-md-3">
                                                                            <label class="text-muted">Suara
                                                                                Pernafasan (SP):</label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <div class="d-flex flex-wrap gap-3">
                                                                                @php
                                                                                    $suaraPernafasanData = [];
                                                                                    if (
                                                                                        $pemeriksaanFisikParu &&
                                                                                        $pemeriksaanFisikParu->paru_suara_pernafasan
                                                                                    ) {
                                                                                        $suaraPernafasanData =
                                                                                            json_decode(
                                                                                                $pemeriksaanFisikParu->paru_suara_pernafasan,
                                                                                                true,
                                                                                            ) ?:
                                                                                            [];
                                                                                    }
                                                                                @endphp
                                                                                <div class="form-check">
                                                                                    <input
                                                                                        class="form-check-input paru-suara-pernafasan"
                                                                                        type="checkbox"
                                                                                        value="vesikuler"
                                                                                        id="sp_vesikuler"
                                                                                        {{ in_array('vesikuler', $suaraPernafasanData) ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                        for="sp_vesikuler">Vesikuler</label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                    <input
                                                                                        class="form-check-input paru-suara-pernafasan"
                                                                                        type="checkbox"
                                                                                        value="vesikuler_melemah"
                                                                                        id="sp_vesikuler_melemah"
                                                                                        {{ in_array('vesikuler_melemah', $suaraPernafasanData) ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                        for="sp_vesikuler_melemah">Vesikuler
                                                                                        Melemah</label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                    <input
                                                                                        class="form-check-input paru-suara-pernafasan"
                                                                                        type="checkbox"
                                                                                        value="ekspirasi_memanjang"
                                                                                        id="sp_ekspirasi_memanjang"
                                                                                        {{ in_array('ekspirasi_memanjang', $suaraPernafasanData) ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                        for="sp_ekspirasi_memanjang">Ekspirasi
                                                                                        Memanjang</label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                    <input
                                                                                        class="form-check-input paru-suara-pernafasan"
                                                                                        type="checkbox"
                                                                                        value="vesikuler_mengeras"
                                                                                        id="sp_vesikuler_mengeras"
                                                                                        {{ in_array('vesikuler_mengeras', $suaraPernafasanData) ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                        for="sp_vesikuler_mengeras">Vesikuler
                                                                                        Mengeras</label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                    <input
                                                                                        class="form-check-input paru-suara-pernafasan"
                                                                                        type="checkbox"
                                                                                        value="bronkial"
                                                                                        id="sp_bronkial"
                                                                                        {{ in_array('bronkial', $suaraPernafasanData) ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                        for="sp_bronkial">Bronkial</label>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Hidden input untuk menampung JSON -->
                                                                            <input type="hidden"
                                                                                name="paru_suara_pernafasan"
                                                                                id="paru_suara_pernafasan_json"
                                                                                value="{{ $pemeriksaanFisikParu->paru_suara_pernafasan ?? '' }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Suara Tambahan (ST) -->
                                                                    <div class="row mb-2">
                                                                        <div class="col-md-3">
                                                                            <label class="text-muted">Suara
                                                                                Tambahan (ST):</label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <div class="d-flex flex-wrap gap-3">
                                                                                @php
                                                                                    $suaraTambahanData = [];
                                                                                    if (
                                                                                        $pemeriksaanFisikParu &&
                                                                                        $pemeriksaanFisikParu->paru_suara_tambahan
                                                                                    ) {
                                                                                        $suaraTambahanData =
                                                                                            json_decode(
                                                                                                $pemeriksaanFisikParu->paru_suara_tambahan,
                                                                                                true,
                                                                                            ) ?:
                                                                                            [];
                                                                                    }
                                                                                @endphp
                                                                                <div class="form-check">
                                                                                    <input
                                                                                        class="form-check-input paru-suara-tambahan"
                                                                                        type="checkbox"
                                                                                        value="rhonkhi_basah_halus"
                                                                                        id="st_rhonkhi_basah_halus"
                                                                                        {{ in_array('rhonkhi_basah_halus', $suaraTambahanData) ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                        for="st_rhonkhi_basah_halus">Rhonkhi
                                                                                        Basah Halus</label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                    <input
                                                                                        class="form-check-input paru-suara-tambahan"
                                                                                        type="checkbox"
                                                                                        value="rhonkhi_basah_kasar"
                                                                                        id="st_rhonkhi_basah_kasar"
                                                                                        {{ in_array('rhonkhi_basah_kasar', $suaraTambahanData) ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                        for="st_rhonkhi_basah_kasar">Rhonkhi
                                                                                        Basah Kasar</label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                    <input
                                                                                        class="form-check-input paru-suara-tambahan"
                                                                                        type="checkbox"
                                                                                        value="rhonkhi_kering"
                                                                                        id="st_rhonkhi_kering"
                                                                                        {{ in_array('rhonkhi_kering', $suaraTambahanData) ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                        for="st_rhonkhi_kering">Rhonkhi
                                                                                        Kering</label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                    <input
                                                                                        class="form-check-input paru-suara-tambahan"
                                                                                        type="checkbox"
                                                                                        value="wheezing"
                                                                                        id="st_wheezing"
                                                                                        {{ in_array('wheezing', $suaraTambahanData) ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                        for="st_wheezing">Wheezing</label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                    <input
                                                                                        class="form-check-input paru-suara-tambahan"
                                                                                        type="checkbox"
                                                                                        value="amforik"
                                                                                        id="st_amforik"
                                                                                        {{ in_array('amforik', $suaraTambahanData) ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                        for="st_amforik">Amforik</label>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Hidden input untuk menampung JSON -->
                                                                            <input type="hidden"
                                                                                name="paru_suara_tambahan"
                                                                                id="paru_suara_tambahan_json"
                                                                                value="{{ $pemeriksaanFisikParu->paru_suara_tambahan ?? '' }}">
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

                        <div class="mt-4">
                            <h6>Site Marking - Penandaan Anatomi Paru</h6>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="site-marking-container position-relative">
                                        <img src="{{ asset('assets/images/sitemarking/paru.jpg') }}"
                                            id="paruAnatomyImage" class="img-fluid" style="max-width: 100%;">
                                        <canvas id="paruMarkingCanvas" class="position-absolute top-0 start-0"
                                            style="cursor: crosshair; z-index: 10;">
                                        </canvas>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <strong>Cara Pakai:</strong> Pilih warna, klik dan drag untuk membuat
                                            coret/marking di area yang ingin ditandai.
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
                                                <button type="button" class="paru-color-btn active"
                                                    data-color="#dc3545"
                                                    style="background: #dc3545; width: 35px; height: 35px; border: 2px solid #dee2e6; border-radius: 6px; cursor: pointer;"></button>
                                                <button type="button" class="paru-color-btn"
                                                    data-color="#198754"
                                                    style="background: #198754; width: 35px; height: 35px; border: 2px solid #dee2e6; border-radius: 6px; cursor: pointer;"></button>
                                                <button type="button" class="paru-color-btn"
                                                    data-color="#0d6efd"
                                                    style="background: #0d6efd; width: 35px; height: 35px; border: 2px solid #dee2e6; border-radius: 6px; cursor: pointer;"></button>
                                                <button type="button" class="paru-color-btn"
                                                    data-color="#fd7e14"
                                                    style="background: #fd7e14; width: 35px; height: 35px; border: 2px solid #dee2e6; border-radius: 6px; cursor: pointer;"></button>
                                                <button type="button" class="paru-color-btn"
                                                    data-color="#6f42c1"
                                                    style="background: #6f42c1; width: 35px; height: 35px; border: 2px solid #dee2e6; border-radius: 6px; cursor: pointer;"></button>
                                                <button type="button" class="paru-color-btn"
                                                    data-color="#000000"
                                                    style="background: #000000; width: 35px; height: 35px; border: 2px solid #dee2e6; border-radius: 6px; cursor: pointer;"></button>
                                            </div>
                                        </div>

                                        <!-- Ketebalan Brush -->
                                        <div class="mb-3">
                                            <label class="form-label">Ketebalan Brush:</label>
                                            <input type="range" id="paruBrushSize" class="form-range"
                                                min="1" max="5" value="2" step="0.5">
                                            <small class="text-muted">Ukuran: <span
                                                    id="paruBrushSizeValue">2</span>px</small>
                                        </div>

                                        <!-- Keterangan -->
                                        <div class="mb-3">
                                            <label class="form-label">Keterangan (opsional):</label>
                                            <input type="text" id="paruMarkingNote" class="form-control"
                                                placeholder="Contoh: Ronkhi basah, Wheezing">
                                        </div>

                                        <!-- Tombol Kontrol -->
                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-outline-primary"
                                                id="paruSaveMarking">
                                                <i class="ti-save"></i> Simpan Penandaan
                                            </button>
                                            <button type="button" class="btn btn-outline-success"
                                                id="paruUpdateMarking" style="display: none;">
                                                <i class="ti-check"></i> Update Penandaan
                                            </button>
                                            <button type="button" class="btn btn-outline-warning"
                                                id="paruUndoLast">
                                                <i class="ti-back-left"></i> Undo Terakhir
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary"
                                                id="paruCancelEdit" style="display: none;">
                                                <i class="ti-close"></i> Batal Edit
                                            </button>
                                            <button type="button" class="btn btn-outline-danger"
                                                id="paruClearAll">
                                                <i class="ti-trash"></i> Hapus Semua
                                            </button>
                                        </div>

                                        <!-- Daftar Penandaan -->
                                        <div class="paru-marking-list mt-3">
                                            <h6>Daftar Penandaan (<span id="paruMarkingCount">0</span>):</h6>
                                            <div id="paruMarkingsList" class="list-group"
                                                style="max-height: 250px; overflow-y: auto;">
                                                <div class="text-muted text-center py-3" id="paruEmptyState">
                                                    <i class="ti-info-alt"></i> Belum ada penandaan
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="site_marking_paru_data" id="siteMarkingParuData"
                                value="{{ $siteMarkingParuData ?? '' }}">
                        </div>
                        {{-- end baru --}}
                        {{-- <div class="row g-3">
                            <div class="pemeriksaan-fisik">
                                <p class="text-small">Centang normal jika fisik yang dinilai normal,
                                    pilih tanda tambah untuk menambah keterangan fisik yang ditemukan tidak normal.
                                    Jika tidak dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                </p>
                                <div class="row">
                                    @php
                                        // PERBAIKAN: Buat mapping pemeriksaan fisik berdasarkan id_item_fisik
                                        $pemeriksaanFisikMap = [];
                                        foreach ($asesmen->pemeriksaanFisik as $item) {
                                            $pemeriksaanFisikMap[$item->id_item_fisik] = $item;
                                        }
                                    @endphp
                                    @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column gap-3">
                                                @foreach ($chunk as $item)
                                                    @php
                                                        // PERBAIKAN: Cek apakah item ini ada dalam pemeriksaan
                                                        $pemeriksaanItem = $pemeriksaanFisikMap[$item->id] ?? null;
                                                        $isNormal = $pemeriksaanItem ? ($pemeriksaanItem->is_normal == 1) : true;
                                                        $keterangan = $pemeriksaanItem->keterangan ?? '';
                                                        $showKeterangan = !$isNormal && !empty($keterangan);
                                                    @endphp
                                                    <div class="pemeriksaan-item">
                                                        <div class="d-flex align-items-center border-bottom pb-2">
                                                            <div class="flex-grow-1">{{ $item->nama }}</div>
                                                            <div class="form-check me-3">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="{{ $item->id }}-normal"
                                                                    name="{{ $item->id }}-normal" {{ $isNormal ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="{{ $item->id }}-normal">Normal</label>
                                                            </div>
                                                            <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                type="button" data-target="{{ $item->id }}-keterangan">
                                                                <i class="bi bi-plus"></i>
                                                            </button>
                                                        </div>
                                                        <div class="keterangan mt-2" id="{{ $item->id }}-keterangan"
                                                            style="display:{{ $showKeterangan ? 'block' : 'none' }};">
                                                            <input type="text" class="form-control"
                                                                name="{{ $item->id }}_keterangan"
                                                                placeholder="Tambah keterangan jika tidak normal..."
                                                                value="{{ $keterangan }}">
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
                            @php $rencanaKerja = $asesmen->rmeAsesmenParuRencanaKerja; @endphp
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">a.</span> Foto
                                    thorax</label>
                                <input type="checkbox" name="foto_thoraks" value="1"
                                    class="form-check-input" id="foto_thoraks"
                                    {{ $rencanaKerja->foto_thoraks ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">b.</span> Pemeriksaan darah
                                    rutin</label>
                                <input type="checkbox" name="darah_rutin" value="1"
                                    class="form-check-input" id="darah_rutin"
                                    {{ $rencanaKerja->darah_rutin ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">c.</span> Pemeriksaan
                                    LED</label>
                                <input type="checkbox" name="led" value="1" class="form-check-input"
                                    id="led" {{ $rencanaKerja->led ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">d.</span> Pemeriksaan
                                    sputum
                                    BTA</label>
                                <input type="checkbox" name="sputum_bta" value="1" class="form-check-input"
                                    id="sputum_bta" {{ $rencanaKerja->sputum_bta ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">e.</span> Pemeriksaan
                                    KGDS</label>
                                <input type="checkbox" name="kgds" value="1" class="form-check-input"
                                    id="kgds" {{ $rencanaKerja->kgds ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">f.</span> Pemeriksaan faal
                                    hati (LFT)</label>
                                <input type="checkbox" name="faal_hati" value="1" class="form-check-input"
                                    id="faal_hati" {{ $rencanaKerja->faal_hati ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">g.</span> Pemeriksaan faal
                                    ginjal (RFG)</label>
                                <input type="checkbox" name="faal_ginjal" value="1"
                                    class="form-check-input" id="faal_ginjal"
                                    {{ $rencanaKerja->faal_ginjal ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">h.</span> Pemeriksaan
                                    elektrolit</label>
                                <input type="checkbox" name="elektrolit" value="1" class="form-check-input"
                                    id="elektrolit" {{ $rencanaKerja->elektrolit ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">i.</span> Pemeriksaan
                                    albumin</label>
                                <input type="checkbox" name="albumin" value="1" class="form-check-input"
                                    id="albumin" {{ $rencanaKerja->albumin ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">j.</span> Pemeriksaan asam
                                    urat</label>
                                <input type="checkbox" name="asam_urat" value="1" class="form-check-input"
                                    id="asam_urat" {{ $rencanaKerja->asam_urat ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">k.</span> Faal paru (APE,
                                    spirometri)</label>
                                <input type="checkbox" name="faal_paru" value="1" class="form-check-input"
                                    id="faal_paru" {{ $rencanaKerja->faal_paru ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">l.</span> CT Scan
                                    thoraks</label>
                                <input type="checkbox" name="ct_scan_thoraks" value="1"
                                    class="form-check-input" id="ct_scan_thoraks"
                                    {{ $rencanaKerja->ct_scan_thoraks ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">m.</span>
                                    Bronchoscopy</label>
                                <input type="checkbox" name="bronchoscopy" value="1"
                                    class="form-check-input" id="bronchoscopy"
                                    {{ $rencanaKerja->bronchoscopy ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">n.</span> Proef
                                    Punctie</label>
                                <input type="checkbox" name="proef_punctie" value="1"
                                    class="form-check-input" id="proef_punctie"
                                    {{ $rencanaKerja->proef_punctie ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">o.</span> Aspirasi cairan
                                    pleura</label>
                                <input type="checkbox" name="aspirasi_cairan_pleura" value="1"
                                    class="form-check-input" id="aspirasi_cairan_pleura"
                                    {{ $rencanaKerja->aspirasi_cairan_pleura ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">p.</span> Penanganan
                                    WSD</label>
                                <input type="checkbox" name="penanganan_wsd" value="1"
                                    class="form-check-input" id="penanganan_wsd"
                                    {{ $rencanaKerja->penanganan_wsd ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">q.</span> Biopsi
                                    Kelenjar</label>
                                <input type="checkbox" name="biopsi_kelenjar" value="1"
                                    class="form-check-input" id="biopsi_kelenjar"
                                    {{ $rencanaKerja->biopsi_kelenjar ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">r.</span> Mantoux
                                    Tes</label>
                                <input type="checkbox" name="mantoux_tes" value="1"
                                    class="form-check-input" id="mantoux_tes"
                                    {{ $rencanaKerja->mantoux_tes ?? 0 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group d-flex align-items-center gap-3">
                                <label style="min-width: 300px;"><span class="fw-bold">s.</span> Lainnya</label>
                                <div class="d-flex gap-2 align-items-center">
                                    <input type="checkbox" name="lainnya_check" value="1"
                                        class="form-check-input" id="lainnya_check"
                                        {{ $rencanaKerja->lainnya_check ?? 0 ? 'checked' : '' }}>
                                    <input type="text" class="form-control" name="lainnya" id="lainnya"
                                        placeholder="Masukkan rencana lainnya"
                                        value="{{ $rencanaKerja->lainnya ?? '' }}"
                                        {{ !($rencanaKerja->lainnya_check ?? 0) ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 9. Diagnosis - PERBAIKAN -->
                    <div class="section-separator" id="diagnosis">
                        <h5 class="fw-semibold mb-4">9. Diagnosis</h5>

                        @php
                            // PERBAIKAN: Parse existing diagnosis data dengan aman
                            $diagnosisImplementasi = $asesmen->rmeAsesmenParuDiagnosisImplementasi;
                            $diagnosisBandingList = [];
                            $diagnosisKerjaList = [];

                            if ($diagnosisImplementasi) {
                                $diagnosisBandingList =
                                    json_decode($diagnosisImplementasi->diagnosis_banding ?? '[]', true) ?: [];
                                $diagnosisKerjaList =
                                    json_decode($diagnosisImplementasi->diagnosis_kerja ?? '[]', true) ?: [];
                            }
                        @endphp

                        <!-- Diagnosis Banding -->
                        <div class="mb-4">
                            <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                diagnosis banding, apabila tidak ada, Pilih tanda tambah untuk menambah
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
                                @foreach ($diagnosisBandingList as $index => $diagnosis)
                                    <div
                                        class="diagnosis-item d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                                        <span>{{ $index + 1 }}. {{ $diagnosis }}</span>
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger remove-diagnosis">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Hidden input for form submission -->
                            <input type="hidden" id="diagnosis_banding" name="diagnosis_banding"
                                value="{{ json_encode($diagnosisBandingList) }}">
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
                                @foreach ($diagnosisKerjaList as $index => $diagnosis)
                                    <div
                                        class="diagnosis-item d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                                        <span>{{ $index + 1 }}. {{ $diagnosis }}</span>
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger remove-diagnosis">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Hidden input for form submission -->
                            <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja"
                                value="{{ json_encode($diagnosisKerjaList) }}">
                        </div>
                    </div>

                    <div class="section-separator" id="prognosis">
                        <h5 class="fw-semibold mb-4">9. Prognosis</h5>
                        <select class="form-select" name="paru_prognosis">
                            <option value="" disabled>--Pilih Prognosis--</option>
                            @forelse ($satsetPrognosis as $item)
                                <option value="{{ $item->prognosis_id }}"
                                    {{ old('paru_prognosis', $asesmen->rmeAsesmenParu->paru_prognosis ?? '') == $item->prognosis_id ? 'selected' : '' }}>
                                    {{ $item->value ?? 'Field tidak ditemukan' }}
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada data</option>
                            @endforelse
                        </select>
                    </div>
                    <!-- 8. Perencanaan Pulang Pasien -->
                    <div class="section-separator" id="discharge-planning">
                        <h5 class="section-title">8. Perencanaan Pulang Pasien (Discharge Planning)</h5>

                        @php
                            $dischargePlanning = $asesmen->rmeAsesmenParuPerencanaanPulang;
                            // PERBAIKAN: Pastikan ada data default jika null
                            $diagnosisMedis = $dischargePlanning->diagnosis_medis ?? '';
                            $usiaLanjut = $dischargePlanning->usia_lanjut ?? '';
                            $hambatanMobilisasi = $dischargePlanning->hambatan_mobilisasi ?? '';
                            $penggunaanMediaBerkelajutan =
                                $dischargePlanning->penggunaan_media_berkelanjutan ?? '';
                            $ketergantunganAktivitas = $dischargePlanning->ketergantungan_aktivitas ?? '';
                            $rencanaPulangKhusus = $dischargePlanning->rencana_pulang_khusus ?? '';
                            $rencanaLamaPerawatan = $dischargePlanning->rencana_lama_perawatan ?? '';
                            $rencanaTglPulang = $dischargePlanning->rencana_tgl_pulang ?? '';
                            $kesimpulanPlaning =
                                $dischargePlanning->kesimpulan_planing ??
                                'Tidak membutuhkan rencana pulang khusus';
                        @endphp

                        {{-- <div class="mb-4">
                            <label class="form-label">Diagnosis medis</label>
                            <input type="text" class="form-control" name="diagnosis_medis" placeholder="Diagnosis"
                                value="{{ $diagnosisMedis }}">
                        </div> --}}

                        <div class="mb-4">
                            <label class="form-label">Usia lanjut (>60 th)</label>
                            <select class="form-select" name="usia_lanjut" id="usia_lanjut">
                                <option value="">--Pilih--</option>
                                <option value="0"
                                    {{ $usiaLanjut === '0' || $usiaLanjut === 0 ? 'selected' : '' }}>Ya
                                </option>
                                <option value="1"
                                    {{ $usiaLanjut === '1' || $usiaLanjut === 1 ? 'selected' : '' }}>Tidak
                                </option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Hambatan mobilitas</label>
                            <select class="form-select" name="hambatan_mobilisasi" id="hambatan_mobilisasi">
                                <option value="">--Pilih--</option>
                                <option value="0"
                                    {{ $hambatanMobilisasi === '0' || $hambatanMobilisasi === 0 ? 'selected' : '' }}>
                                    Ya</option>
                                <option value="1"
                                    {{ $hambatanMobilisasi === '1' || $hambatanMobilisasi === 1 ? 'selected' : '' }}>
                                    Tidak</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Membutuhkan pelayanan medis berkelanjutan</label>
                            <select class="form-select" name="penggunaan_media_berkelanjutan"
                                id="penggunaan_media_berkelanjutan">
                                <option value="">--Pilih--</option>
                                <option value="ya"
                                    {{ $penggunaanMediaBerkelajutan === 'ya' ? 'selected' : '' }}>Ya
                                </option>
                                <option value="tidak"
                                    {{ $penggunaanMediaBerkelajutan === 'tidak' ? 'selected' : '' }}>Tidak
                                </option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Keteraturan dalam mengonsumsi obat dalam aktivitas
                                harian</label>
                            <select class="form-select" name="ketergantungan_aktivitas"
                                id="ketergantungan_aktivitas">
                                <option value="">--Pilih--</option>
                                <option value="ya"
                                    {{ $ketergantunganAktivitas === 'ya' ? 'selected' : '' }}>Ya
                                </option>
                                <option value="tidak"
                                    {{ $ketergantunganAktivitas === 'tidak' ? 'selected' : '' }}>
                                    Tidak</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Rencana Pulang Khusus</label>
                            <input type="text" class="form-control" name="rencana_pulang_khusus"
                                placeholder="Rencana Pulang Khusus" value="{{ $rencanaPulangKhusus }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Rencana Lama Perawatan</label>
                            <input type="text" class="form-control" name="rencana_lama_perawatan"
                                placeholder="Rencana Lama Perawatan" value="{{ $rencanaLamaPerawatan }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Rencana Tanggal Pulang</label>
                            <input type="date" class="form-control" name="rencana_tgl_pulang"
                                value="{{ $rencanaTglPulang ? date('Y-m-d', strtotime($rencanaTglPulang)) : '' }}">
                        </div>

                        <div class="mt-4">
                            <label class="form-label">KESIMPULAN</label>
                            <div class="d-flex flex-column gap-2">
                                <!-- Alert untuk alasan -->
                                <div class="alert alert-info d-none" id="alert-info">
                                    <strong>Alasan:</strong><br>
                                    <span id="reasons-list"></span>
                                </div>

                                <!-- Alert warning -->
                                <div class="alert alert-warning d-none" id="alert-warning">
                                    Membutuhkan rencana pulang khusus
                                </div>

                                <!-- Alert success -->
                                <div class="alert alert-success" id="alert-success">
                                    Tidak membutuhkan rencana pulang khusus
                                </div>
                            </div>
                            <input type="hidden" id="kesimpulan" name="kesimpulan_planing"
                                value="{{ $kesimpulanPlaning }}">
                        </div>

                        <!-- Tombol Reset (Opsional) -->
                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary"
                                onclick="resetDischargePlanningEdit()">
                                Reset Discharge Planning
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-end">
                    <x-button-submit>Perbarui</x-button-submit>
                </div>
            </form>
        </x-content-card>
        </div>
    </div>
@endsection


<!-- Modal Alergi -->
<div class="modal fade" id="alergiModal" tabindex="-1" aria-labelledby="alergiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alergiModalLabel">Manajemen Data Alergi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Input Alergi -->
                <div class="card" style="height: auto;">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Tambah Data Alergi</h6>
                    </div>
                    <div class="card-body bg-primary">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="modal_jenis_alergi" class="form-label">Jenis Alergi</label>
                                <select class="form-select" id="modal_jenis_alergi">
                                    <option value="">-- Pilih Jenis Alergi --</option>
                                    <option value="Obat">Obat</option>
                                    <option value="Makanan">Makanan</option>
                                    <option value="Udara">Udara</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modal_alergen" class="form-label">Alergen</label>
                                <input type="text" class="form-control" id="modal_alergen"
                                    placeholder="Contoh: Paracetamol, Seafood, Debu">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modal_reaksi" class="form-label">Reaksi</label>
                                <input type="text" class="form-control" id="modal_reaksi"
                                    placeholder="Contoh: Gatal, Ruam, Sesak nafas">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modal_tingkat_keparahan" class="form-label">Tingkat Keparahan</label>
                                <select class="form-select" id="modal_tingkat_keparahan">
                                    <option value="">-- Pilih Tingkat Keparahan --</option>
                                    <option value="Ringan">Ringan</option>
                                    <option value="Sedang">Sedang</option>
                                    <option value="Berat">Berat</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-primary btn-sm" id="addToAlergiList">
                                <i class="bi bi-plus"></i> Tambah ke Daftar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Daftar Alergi -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">Daftar Alergi Pasien</h6>
                        <span class="badge bg-primary" id="alergiCount">0</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th width="20%">Jenis Alergi</th>
                                        <th width="25%">Alergen</th>
                                        <th width="25%">Reaksi</th>
                                        <th width="20%">Tingkat Keparahan</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="modalAlergiList">
                                    <!-- Data akan ditampilkan di sini -->
                                </tbody>
                            </table>
                        </div>
                        <div id="noAlergiMessage" class="text-center text-muted py-3" style="display: none;">
                            <i class="bi bi-info-circle"></i> Belum ada data alergi
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveAlergiData">
                    <i class="bi bi-check"></i> Simpan Data Alergi
                </button>
            </div>
        </div>
    </div>
</div>
@push('js')
      @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-paru.manage-create-edit.index')
@endpush


