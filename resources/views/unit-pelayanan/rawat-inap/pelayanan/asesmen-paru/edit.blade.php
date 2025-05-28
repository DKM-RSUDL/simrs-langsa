@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-paru.edit-include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-asesmen-tht')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-info mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form method="POST" enctype="multipart/form-data" action="{{ route('rawat-inap.asesmen.medis.paru.update', [
        'kd_unit' => request()->route('kd_unit'),
        'kd_pasien' => request()->route('kd_pasien'),
        'tgl_masuk' => request()->route('tgl_masuk'),
        'urut_masuk' => request()->route('urut_masuk'),
        'id' => $asesmen->id
    ]) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="kd_pasien" value="{{ $dataMedis->kd_pasien }}">
                <input type="hidden" name="kd_unit" value="{{ $dataMedis->kd_unit }}">
                <input type="hidden" name="tgl_masuk" value="{{ $dataMedis->tgl_masuk }}">
                <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">

                <div class="card">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <h4 class="header-asesmen">Edit Asesmen Awal Medis Paru</h4>
                                    <p class="text-muted">
                                        Edit Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>
                            </div>
                        </div>

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
                                        <input type="time" class="form-control" name="jam_masuk" value="{{ $asesmen->rmeAsesmenParu->jam_masuk ? \Carbon\Carbon::parse($asesmen->rmeAsesmenParu->jam_masuk)->format('H:i') : date('H:i') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Anamnesis -->
                            <div class="section-separator" id="anamnesis">
                                <h5 class="section-title">2. Anamnesis</h5>

                                <div class="form-group">
                                    <label>Anamnesa</label>
                                    <textarea class="form-control" name="anamnesa" rows="3"
                                        placeholder="Keluhan utama pasien">{{ $asesmen->rmeAsesmenParu->anamnesa ?? '' }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Riwayat penyakit</label>
                                    <textarea class="form-control" name="riwayat_penyakit" rows="4"
                                        placeholder="Riwayat penyakit sekarang">{{ $asesmen->rmeAsesmenParu->riwayat_penyakit ?? '' }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="alergi">Alergi</label>
                                    @php
                                        $allergiesDisplay = '';
                                        $allergiesJson = '[]';
                                        if ($asesmen->rmeAsesmenParu->alergi) {
                                            $allergies = json_decode($asesmen->rmeAsesmenParu->alergi, true);
                                            if (is_array($allergies)) {
                                                $allergiesDisplay = collect($allergies)->pluck('nama_alergi')->join(', ');
                                                $allergiesJson = $asesmen->rmeAsesmenParu->alergi;
                                            }
                                        }
                                    @endphp
                                    <div class="input-group">
                                        <input type="text" name="alergi_display" id="alergi_display" class="form-control"
                                            placeholder="Alergi pasien (jika ada)" value="{{ $allergiesDisplay }}" readonly>
                                        <input type="hidden" name="alergi" id="alergi" value="{{ $allergiesJson }}">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#alergiModal">
                                            <i class="ti-plus"></i> Tambah Alergi
                                        </button>
                                    </div>
                                </div>
                                @push('modals')
                                    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-paru.alergi')
                                @endpush
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
                                                        style="resize: none; min-height: 120px;">{{ $asesmen->rmeAsesmenParu->riwayat_penyakit_terdahulu ?? '' }}</textarea>
                                                </td>
                                                <td class="p-0">
                                                    <textarea class="form-control border-0 rounded-0"
                                                        name="riwayat_penggunaan_obat" rows="5"
                                                        placeholder="Tuliskan riwayat penggunaan obat..."
                                                        style="resize: none; min-height: 120px;">{{ $asesmen->rmeAsesmenParu->riwayat_penggunaan_obat ?? '' }}</textarea>
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
                                                            <input class="form-check-input" type="radio" name="merokok"
                                                                value="tidak" id="merokok_tidak" {{ ($asesmen->rmeAsesmenParu->merokok ?? 'tidak') == 'tidak' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="merokok_tidak">Tidak</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="merokok"
                                                                value="ya" id="merokok_ya" {{ ($asesmen->rmeAsesmenParu->merokok ?? '') == 'ya' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="merokok_ya">Ya,
                                                                jumlah:</label>
                                                        </div>
                                                        <input type="number"
                                                            class="form-control input-inline input-sm @error('merokok_jumlah') is-invalid @enderror"
                                                            name="merokok_jumlah" id="merokok_jumlah" min="0"
                                                            placeholder="0"
                                                            value="{{ $asesmen->rmeAsesmenParu->merokok_jumlah ?? '' }}" {{ ($asesmen->rmeAsesmenParu->merokok ?? '') != 'ya' ? 'disabled' : '' }}>
                                                        <span>batang/hari</span>
                                                        <span class="ms-2">Lama:</span>
                                                        <input type="number"
                                                            class="form-control input-inline input-sm @error('merokok_lama') is-invalid @enderror"
                                                            name="merokok_lama" id="merokok_lama" min="0" placeholder="0"
                                                            value="{{ $asesmen->rmeAsesmenParu->merokok_lama ?? '' }}" {{ ($asesmen->rmeAsesmenParu->merokok ?? '') != 'ya' ? 'disabled' : '' }}>
                                                        <span>tahun</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col">b. Alkohol</td>
                                                <td>
                                                    <div class="form-check-group d-flex align-items-center gap-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="alkohol"
                                                                value="tidak" id="alkohol_tidak" {{ ($asesmen->rmeAsesmenParu->alkohol ?? 'tidak') == 'tidak' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="alkohol_tidak">Tidak</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="alkohol"
                                                                value="ya" id="alkohol_ya" {{ ($asesmen->rmeAsesmenParu->alkohol ?? '') == 'ya' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="alkohol_ya">Ya,
                                                                jumlah:</label>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control input-inline input-lg @error('alkohol_jumlah') is-invalid @enderror"
                                                            name="alkohol_jumlah" id="alkohol_jumlah"
                                                            placeholder="Jumlah konsumsi"
                                                            value="{{ $asesmen->rmeAsesmenParu->alkohol_jumlah ?? '' }}" {{ ($asesmen->rmeAsesmenParu->alkohol ?? '') != 'ya' ? 'disabled' : '' }}>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col">c. Obat-obatan</td>
                                                <td>
                                                    <div class="form-check-group d-flex align-items-center gap-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="obat_obatan"
                                                                value="tidak" id="obat_tidak" {{ ($asesmen->rmeAsesmenParu->obat_obatan ?? 'tidak') == 'tidak' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="obat_tidak">Tidak</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="obat_obatan"
                                                                value="ya" id="obat_ya" {{ ($asesmen->rmeAsesmenParu->obat_obatan ?? '') == 'ya' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="obat_ya">Ya, jenis:</label>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control input-inline input-lg @error('obat_jenis') is-invalid @enderror"
                                                            name="obat_jenis" id="obat_jenis" placeholder="Jenis obat"
                                                            value="{{ $asesmen->rmeAsesmenParu->obat_jenis ?? '' }}" {{ ($asesmen->rmeAsesmenParu->obat_obatan ?? '') != 'ya' ? 'disabled' : '' }}>
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
                                                        @php $currentSensorium = $asesmen->rmeAsesmenParu->sensorium ?? ''; @endphp
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="sensorium"
                                                                value="cm" id="sensorium_cm" {{ $currentSensorium == 'cm' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="sensorium_cm">CM</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="sensorium"
                                                                value="cm_lemah" id="sensorium_cm_lemah" {{ $currentSensorium == 'cm_lemah' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="sensorium_cm_lemah">CM
                                                                lemah</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="sensorium"
                                                                value="somnolen" id="sensorium_somnolen" {{ $currentSensorium == 'somnolen' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="sensorium_somnolen">Somnolen</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="sensorium"
                                                                value="soporus" id="sensorium_soporus" {{ $currentSensorium == 'soporus' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="sensorium_soporus">Soporus</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="sensorium"
                                                                value="coma" id="sensorium_coma" {{ $currentSensorium == 'coma' ? 'checked' : '' }}>
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
                                                            <input class="form-check-input" type="radio" name="keadaan_umum"
                                                                value="baik" id="keadaan_baik" {{ $currentKeadaanUmum == 'baik' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="keadaan_baik">Baik</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="keadaan_umum"
                                                                value="sedang" id="keadaan_sedang" {{ $currentKeadaanUmum == 'sedang' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="keadaan_sedang">Sedang</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="keadaan_umum"
                                                                value="jelek" id="keadaan_jelek" {{ $currentKeadaanUmum == 'jelek' ? 'checked' : '' }}>
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
                                                                    class="form-control input-inline input-sm" name="nadi"
                                                                    value="{{ $asesmen->rmeAsesmenParu->nadi ?? '' }}">
                                                                <span>x/menit</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-check-group">
                                                                <span>Dyspnoe</span>
                                                                @php $currentDyspnoe = $asesmen->rmeAsesmenParu->dyspnoe ?? 'tidak'; @endphp
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="dyspnoe" value="tidak" id="dyspnoe_tidak" {{ $currentDyspnoe == 'tidak' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="dyspnoe_tidak">Tidak</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="dyspnoe" value="ya" id="dyspnoe_ya" {{ $currentDyspnoe == 'ya' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="dyspnoe_ya">Ya</label>
                                                                </div>
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
                                                                    <option value="reguler" {{ ($asesmen->rmeAsesmenParu->pernafasan_tipe ?? '') == 'reguler' ? 'selected' : '' }}>Reguler</option>
                                                                    <option value="irreguler" {{ ($asesmen->rmeAsesmenParu->pernafasan_tipe ?? '') == 'irreguler' ? 'selected' : '' }}>Irreguler
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-check-group">
                                                                <span>Cyanose</span>
                                                                @php $currentCyanose = $asesmen->rmeAsesmenParu->cyanose ?? 'tidak'; @endphp
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="cyanose" value="tidak" id="cyanose_tidak" {{ $currentCyanose == 'tidak' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="cyanose_tidak">Tidak</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="cyanose" value="ya" id="cyanose_ya" {{ $currentCyanose == 'ya' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="cyanose_ya">Ya</label>
                                                                </div>
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
                                                        <div class="col-lg-6">
                                                            <div class="form-check-group">
                                                                <span>Oedema</span>
                                                                @php $currentOedema = $asesmen->rmeAsesmenParu->oedema ?? 'tidak'; @endphp
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="oedema" value="tidak" id="oedema_tidak" {{ $currentOedema == 'tidak' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="oedema_tidak">Tidak</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="oedema" value="ya" id="oedema_ya" {{ $currentOedema == 'ya' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="oedema_ya">Ya</label>
                                                                </div>
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
                                                        <div class="col-lg-4">
                                                            <div class="form-check-group">
                                                                <span>Icterus</span>
                                                                @php $currentIcterus = $asesmen->rmeAsesmenParu->icterus ?? 'tidak'; @endphp
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="icterus" value="tidak" id="icterus_tidak" {{ $currentIcterus == 'tidak' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="icterus_tidak">Tidak</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="icterus" value="ya" id="icterus_ya" {{ $currentIcterus == 'ya' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="icterus_ya">Ya</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-check-group">
                                                                <span>Anemia</span>
                                                                @php $currentAnemia = $asesmen->rmeAsesmenParu->anemia ?? 'tidak'; @endphp
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="anemia" value="tidak" id="anemia_tidak" {{ $currentAnemia == 'tidak' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="anemia_tidak">Tidak</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="anemia" value="ya" id="anemia_ya" {{ $currentAnemia == 'ya' ? 'checked' : '' }}>
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
                                <div class="row g-3">
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
                                </div>
                            </div>

                            <!-- 7. Rencana Kerja Dan Penatalaksanaan -->
                            <div class="section-separator" id="rencana-kerja">
                                <h5 class="section-title">7. Rencana Kerja Dan Penatalaksanaan</h5>
                                <div>
                                    @php $rencanaKerja = $asesmen->rmeAsesmenParuRencanaKerja; @endphp
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">a.</span> Foto thorax</label>
                                        <input type="checkbox" name="foto_thoraks" value="1" class="form-check-input"
                                            id="foto_thoraks" {{ ($rencanaKerja->foto_thoraks ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">b.</span> Pemeriksaan darah
                                            rutin</label>
                                        <input type="checkbox" name="darah_rutin" value="1" class="form-check-input"
                                            id="darah_rutin" {{ ($rencanaKerja->darah_rutin ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">c.</span> Pemeriksaan
                                            LED</label>
                                        <input type="checkbox" name="led" value="1" class="form-check-input" id="led" {{ ($rencanaKerja->led ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">d.</span> Pemeriksaan sputum
                                            BTA</label>
                                        <input type="checkbox" name="sputum_bta" value="1" class="form-check-input"
                                            id="sputum_bta" {{ ($rencanaKerja->sputum_bta ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">e.</span> Pemeriksaan
                                            IGDS</label>
                                        <input type="checkbox" name="igds" value="1" class="form-check-input" id="igds" {{ ($rencanaKerja->igds ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">f.</span> Pemeriksaan faal
                                            ginjal (RFG)</label>
                                        <input type="checkbox" name="faal_ginjal" value="1" class="form-check-input"
                                            id="faal_ginjal" {{ ($rencanaKerja->faal_ginjal ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">g.</span> Pemeriksaan
                                            elektrolit</label>
                                        <input type="checkbox" name="elektrolit" value="1" class="form-check-input"
                                            id="elektrolit" {{ ($rencanaKerja->elektrolit ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">h.</span> Pemeriksaan
                                            albumin</label>
                                        <input type="checkbox" name="albumin" value="1" class="form-check-input"
                                            id="albumin" {{ ($rencanaKerja->albumin ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">i.</span> CT Scan
                                            thorax</label>
                                        <input type="checkbox" name="ct_scan_thorax" value="1" class="form-check-input"
                                            id="ct_scan_thorax" {{ ($rencanaKerja->ct_scan_thorax ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">j.</span> Pemeriksaan asam
                                            urat</label>
                                        <input type="checkbox" name="asam_urat" value="1" class="form-check-input"
                                            id="asam_urat" {{ ($rencanaKerja->asam_urat ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">k.</span> Faal paru (APE,
                                            spirometri)</label>
                                        <input type="checkbox" name="faal_paru" value="1" class="form-check-input"
                                            id="faal_paru" {{ ($rencanaKerja->faal_paru ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">l.</span> CT Scan
                                            thoraks</label>
                                        <input type="checkbox" name="ct_scan_thoraks" value="1" class="form-check-input"
                                            id="ct_scan_thoraks" {{ ($rencanaKerja->ct_scan_thoraks ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">m.</span>
                                            Bronchoscopy</label>
                                        <input type="checkbox" name="bronchoscopy" value="1" class="form-check-input"
                                            id="bronchoscopy" {{ ($rencanaKerja->bronchoscopy ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">n.</span> Proef
                                            Punctie</label>
                                        <input type="checkbox" name="proef_punctie" value="1" class="form-check-input"
                                            id="proef_punctie" {{ ($rencanaKerja->proef_punctie ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">o.</span> Aspirasi cairan
                                            pleura</label>
                                        <input type="checkbox" name="aspirasi_cairan_pleura" value="1"
                                            class="form-check-input" id="aspirasi_cairan_pleura" {{ ($rencanaKerja->aspirasi_cairan_pleura ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">p.</span> Penanganan
                                            WSD</label>
                                        <input type="checkbox" name="penanganan_wsd" value="1" class="form-check-input"
                                            id="penanganan_wsd" {{ ($rencanaKerja->penanganan_wsd ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">q.</span> Penanganan
                                            penyakit</label>
                                        <input type="checkbox" name="penanganan_penyakit" value="1" class="form-check-input"
                                            id="penanganan_penyakit" {{ ($rencanaKerja->penanganan_penyakit ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">r.</span> Konsul Tes</label>
                                        <input type="checkbox" name="konsul" value="1" class="form-check-input" id="konsul"
                                            {{ ($rencanaKerja->konsul ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">s.</span> Lainnya</label>
                                        <div class="d-flex gap-2 align-items-center">
                                            <input type="checkbox" name="lainnya_check" value="1" class="form-check-input"
                                                id="lainnya_check" {{ ($rencanaKerja->lainnya_check ?? 0) ? 'checked' : '' }}>
                                            <input type="text" class="form-control" name="lainnya" id="lainnya"
                                                placeholder="Masukkan rencana lainnya"
                                                value="{{ $rencanaKerja->lainnya ?? '' }}" {{ !($rencanaKerja->lainnya_check ?? 0) ? 'disabled' : '' }}>
                                        </div>
                                    </div>
                                </div>
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
                                    $penggunaanMediaBerkelajutan = $dischargePlanning->penggunaan_media_berkelanjutan ?? '';
                                    $ketergantunganAktivitas = $dischargePlanning->ketergantungan_aktivitas ?? '';
                                    $rencanaPulangKhusus = $dischargePlanning->rencana_pulang_khusus ?? '';
                                    $rencanaLamaPerawatan = $dischargePlanning->rencana_lama_perawatan ?? '';
                                    $rencanaTglPulang = $dischargePlanning->rencana_tgl_pulang ?? '';
                                    $kesimpulanPlaning = $dischargePlanning->kesimpulan_planing ?? 'Tidak membutuhkan rencana pulang khusus';
                                @endphp

                                <div class="mb-4">
                                    <label class="form-label">Diagnosis medis</label>
                                    <input type="text" class="form-control" name="diagnosis_medis" placeholder="Diagnosis"
                                        value="{{ $diagnosisMedis }}">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Usia lanjut (>60 th)</label>
                                    <select class="form-select" name="usia_lanjut" id="usia_lanjut">
                                        <option value="">--Pilih--</option>
                                        <option value="0" {{ $usiaLanjut === '0' || $usiaLanjut === 0 ? 'selected' : '' }}>Ya
                                        </option>
                                        <option value="1" {{ $usiaLanjut === '1' || $usiaLanjut === 1 ? 'selected' : '' }}>Tidak
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Hambatan mobilitas</label>
                                    <select class="form-select" name="hambatan_mobilisasi" id="hambatan_mobilisasi">
                                        <option value="">--Pilih--</option>
                                        <option value="0" {{ $hambatanMobilisasi === '0' || $hambatanMobilisasi === 0 ? 'selected' : '' }}>Ya</option>
                                        <option value="1" {{ $hambatanMobilisasi === '1' || $hambatanMobilisasi === 1 ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Membutuhkan pelayanan medis berkelanjutan</label>
                                    <select class="form-select" name="penggunaan_media_berkelanjutan"
                                        id="penggunaan_media_berkelanjutan">
                                        <option value="">--Pilih--</option>
                                        <option value="ya" {{ $penggunaanMediaBerkelajutan === 'ya' ? 'selected' : '' }}>Ya
                                        </option>
                                        <option value="tidak" {{ $penggunaanMediaBerkelajutan === 'tidak' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Keteraturan dalam mengonsumsi obat dalam aktivitas
                                        harian</label>
                                    <select class="form-select" name="ketergantungan_aktivitas"
                                        id="ketergantungan_aktivitas">
                                        <option value="">--Pilih--</option>
                                        <option value="ya" {{ $ketergantunganAktivitas === 'ya' ? 'selected' : '' }}>Ya
                                        </option>
                                        <option value="tidak" {{ $ketergantunganAktivitas === 'tidak' ? 'selected' : '' }}>
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
                                    <button type="button" class="btn btn-secondary" onclick="resetDischargePlanningEdit()">
                                        Reset Discharge Planning
                                    </button>
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
                                        $diagnosisBandingList = json_decode($diagnosisImplementasi->diagnosis_banding ?? '[]', true) ?: [];
                                        $diagnosisKerjaList = json_decode($diagnosisImplementasi->diagnosis_kerja ?? '[]', true) ?: [];
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
                                        @foreach($diagnosisBandingList as $index => $diagnosis)
                                            <div class="diagnosis-item d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                                                <span>{{ $index + 1 }}. {{ $diagnosis }}</span>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-diagnosis">
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
                                        @foreach($diagnosisKerjaList as $index => $diagnosis)
                                            <div class="diagnosis-item d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                                                <span>{{ $index + 1 }}. {{ $diagnosis }}</span>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-diagnosis">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Hidden input for form submission -->
                                    <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja"
                                        value="{{ json_encode($diagnosisKerjaList) }}">
                                </div>

                                <div class="mt-5">
                                    <div class="form-group">
                                        <label>Gambar radiologi paru</label>
                                        @if($diagnosisImplementasi && $diagnosisImplementasi->gambar_radiologi_paru)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $diagnosisImplementasi->gambar_radiologi_paru) }}"
                                                    alt="Gambar Radiologi Paru" class="img-thumbnail" style="max-width: 200px;">
                                                <small class="d-block text-muted">Gambar saat ini</small>
                                            </div>
                                        @endif
                                        <input type="file" class="form-control" name="gambar_radiologi_paru"
                                            placeholder="gambar radiologi paru">
                                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                                    </div>
                                </div>
                            </div>

                            <!-- 10. Implementasi - PERBAIKAN -->
                            <div class="section-separator" id="implementasi" style="margin-bottom: 2rem;">
                                <h5 class="fw-semibold mb-4">10. Implementasi</h5>

                                @php
                                    // PERBAIKAN: Parse existing implementation data dengan aman
                                    $observasiList = [];
                                    $terapeutikList = [];
                                    $edukasiList = [];
                                    $kolaborasiList = [];
                                    $prognosisList = [];

                                    if ($diagnosisImplementasi) {
                                        $observasiList = json_decode($diagnosisImplementasi->observasi ?? '[]', true) ?: [];
                                        $terapeutikList = json_decode($diagnosisImplementasi->terapeutik ?? '[]', true) ?: [];
                                        $edukasiList = json_decode($diagnosisImplementasi->edukasi ?? '[]', true) ?: [];
                                        $kolaborasiList = json_decode($diagnosisImplementasi->kolaborasi ?? '[]', true) ?: [];
                                        $prognosisList = json_decode($diagnosisImplementasi->prognosis ?? '[]', true) ?: [];
                                    }
                                @endphp

                                <!-- Rencana Penatalaksanaan dan Pengobatan -->
                                <div class="mb-4">
                                    <label class="text-primary fw-semibold">Rencana Penatalaksanaan dan Pengobatan</label>
                                    <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                        rencana, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                        rencana Penatalaksanaan dan Pengobatan kerja yang tidak ditemukan.</small>
                                </div>

                                <!-- Observasi Section -->
                                <div class="mb-4">
                                    <label class="fw-semibold mb-2">Observasi</label>
                                    <div class="input-group mt-2">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-secondary"></i>
                                        </span>
                                        <input type="text" id="observasi-input" class="form-control border-start-0 ps-0"
                                            placeholder="Cari dan tambah Observasi">
                                        <span class="input-group-text bg-white" id="add-observasi">
                                            <i class="bi bi-plus-circle text-primary"></i>
                                        </span>
                                    </div>
                                    <div id="observasi-list" class="list-group mb-2 bg-light p-3 rounded">
                                        @foreach($observasiList as $index => $item)
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <span>{{ $index + 1 }}. {{ $item }}</span>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Hidden input to store JSON data -->
                                    <input type="hidden" id="observasi" name="observasi" value="{{ json_encode($observasiList) }}">
                                </div>

                                <!-- Terapeutik Section -->
                                <div class="mb-4">
                                    <label class="fw-semibold mb-2">Terapeutik</label>
                                    <div class="input-group mt-2">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-secondary"></i>
                                        </span>
                                        <input type="text" id="terapeutik-input" class="form-control border-start-0 ps-0"
                                            placeholder="Cari dan tambah Terapeutik">
                                        <span class="input-group-text bg-white" id="add-terapeutik">
                                            <i class="bi bi-plus-circle text-primary"></i>
                                        </span>
                                    </div>
                                    <div id="terapeutik-list" class="list-group mb-2 bg-light p-3 rounded">
                                        @foreach($terapeutikList as $index => $item)
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <span>{{ $index + 1 }}. {{ $item }}</span>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Hidden input to store JSON data -->
                                    <input type="hidden" id="terapeutik" name="terapeutik" value="{{ json_encode($terapeutikList) }}">
                                </div>

                                <!-- Edukasi Section -->
                                <div class="mb-4">
                                    <label class="fw-semibold mb-2">Edukasi</label>
                                    <div class="input-group mt-2">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-secondary"></i>
                                        </span>
                                        <input type="text" id="edukasi-input" class="form-control border-start-0 ps-0"
                                            placeholder="Cari dan tambah Edukasi">
                                        <span class="input-group-text bg-white" id="add-edukasi">
                                            <i class="bi bi-plus-circle text-primary"></i>
                                        </span>
                                    </div>
                                    <div id="edukasi-list" class="list-group mb-2 bg-light p-3 rounded">
                                        @foreach($edukasiList as $index => $item)
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <span>{{ $index + 1 }}. {{ $item }}</span>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Hidden input to store JSON data -->
                                    <input type="hidden" id="edukasi" name="edukasi" value="{{ json_encode($edukasiList) }}">
                                </div>

                                <!-- Kolaborasi Section -->
                                <div class="mb-4">
                                    <label class="fw-semibold mb-2">Kolaborasi</label>
                                    <div class="input-group mt-2">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-secondary"></i>
                                        </span>
                                        <input type="text" id="kolaborasi-input" class="form-control border-start-0 ps-0"
                                            placeholder="Cari dan tambah Kolaborasi">
                                        <span class="input-group-text bg-white" id="add-kolaborasi">
                                            <i class="bi bi-plus-circle text-primary"></i>
                                        </span>
                                    </div>
                                    <div id="kolaborasi-list" class="list-group mb-2 bg-light p-3 rounded">
                                        @foreach($kolaborasiList as $index => $item)
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <span>{{ $index + 1 }}. {{ $item }}</span>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Hidden input to store JSON data -->
                                    <input type="hidden" id="kolaborasi" name="kolaborasi" value="{{ json_encode($kolaborasiList) }}">
                                </div>

                                <!-- Prognosis Section -->
                                <div class="mb-4">
                                    <label class="text-primary fw-semibold">Prognosis</label>
                                    <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                        Prognosis, apabila tidak ada, Pilih tanda tambah untuk menambah
                                        keterangan Prognosis yang tidak ditemukan.</small>
                                    <!-- sudah terlanjut buat ke rpp jadi yang di ubah hanya name sesuai DB saja ke prognosis -->
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-secondary"></i>
                                        </span>
                                        <input type="text" id="rencana-input" class="form-control border-start-0 ps-0"
                                            placeholder="Cari dan tambah Rencana Penatalaksanaan">
                                        <span class="input-group-text bg-white" id="add-rencana">
                                            <i class="bi bi-plus-circle text-primary"></i>
                                        </span>
                                    </div>

                                    <div id="rencana-list" class="list-group mb-3 bg-light p-3 rounded">
                                        @foreach($prognosisList as $index => $item)
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <span>{{ $index + 1 }}. {{ $item }}</span>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Hidden input to store JSON data -->
                                    <input type="hidden" id="rencana_penatalaksanaan" name="prognosis" value="{{ json_encode($prognosisList) }}">
                                </div>
                            </div>

                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Update
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // PERBAIKAN: Pemeriksaan Fisik Logic
            document.querySelectorAll('.tambah-keterangan').forEach(button => {
                button.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const targetDiv = document.getElementById(targetId);
                    const itemId = targetId.replace('-keterangan', '');
                    const checkbox = document.querySelector(`input[name="${itemId}-normal"]`);

                    if (targetDiv.style.display === 'none' || targetDiv.style.display === '') {
                        targetDiv.style.display = 'block';
                        // Uncheck normal when adding keterangan
                        if (checkbox) checkbox.checked = false;
                    } else {
                        targetDiv.style.display = 'none';
                        // Clear the input when hiding
                        const input = targetDiv.querySelector('input');
                        if (input) input.value = '';
                    }
                });
            });

            // PERBAIKAN: Handle normal checkbox changes
            document.querySelectorAll('input[type="checkbox"][id$="-normal"]').forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const itemId = this.id.replace('-normal', '');
                    const keteranganDiv = document.getElementById(itemId + '-keterangan');
                    const keteranganInput = keteranganDiv ? keteranganDiv.querySelector('input') : null;

                    if (this.checked) {
                        // Hide keterangan when normal is checked
                        if (keteranganDiv) {
                            keteranganDiv.style.display = 'none';
                            if (keteranganInput) keteranganInput.value = '';
                        }
                    }
                });
            });

            // PERBAIKAN: Function to toggle input fields based on radio button selection
            function toggleInputFields(radioName, inputIds, yesValue = 'ya') {
                const radios = document.getElementsByName(radioName);
                const inputs = inputIds.map(id => document.getElementById(id)).filter(input => input !== null);

                // Initialize state based on current selection
                const selectedValue = Array.from(radios).find(radio => radio.checked)?.value;
                inputs.forEach(input => {
                    input.disabled = selectedValue !== yesValue;
                });

                // Add event listeners to radio buttons
                radios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        inputs.forEach(input => {
                            input.disabled = this.value !== yesValue;
                            if (this.value !== yesValue) {
                                input.value = ''; // Clear input when disabled
                                input.classList.remove('is-invalid');
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

            // PERBAIKAN: Toggle 'lainnya' input based on checkbox
            const lainnyaCheck = document.getElementById('lainnya_check');
            const lainnyaInput = document.getElementById('lainnya');

            if (lainnyaCheck && lainnyaInput) {
                // Initialize state
                lainnyaInput.disabled = !lainnyaCheck.checked;

                // Add event listener to checkbox
                lainnyaCheck.addEventListener('change', function () {
                    lainnyaInput.disabled = !this.checked;
                    if (!this.checked) {
                        lainnyaInput.value = '';
                        lainnyaInput.classList.remove('is-invalid');
                    }
                });
            }

            // PERBAIKAN: Client-side validation on form submission
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function (event) {
                    let errors = [];

                    // Check Merokok
                    const merokok = document.querySelector('input[name="merokok"]:checked')?.value;
                    if (merokok === 'ya') {
                        const jumlah = document.getElementById('merokok_jumlah');
                        const lama = document.getElementById('merokok_lama');

                        if (jumlah && (!jumlah.value || jumlah.value < 0)) {
                            errors.push('Jumlah batang/hari harus diisi dan tidak boleh negatif.');
                            jumlah.classList.add('is-invalid');
                        }
                        if (lama && (!lama.value || lama.value < 0)) {
                            errors.push('Lama merokok harus diisi dan tidak boleh negatif.');
                            lama.classList.add('is-invalid');
                        }
                    }

                    // Check Alkohol
                    const alkohol = document.querySelector('input[name="alkohol"]:checked')?.value;
                    const alkoholJumlah = document.getElementById('alkohol_jumlah');
                    if (alkohol === 'ya' && alkoholJumlah && !alkoholJumlah.value.trim()) {
                        errors.push('Jumlah konsumsi alkohol harus diisi.');
                        alkoholJumlah.classList.add('is-invalid');
                    }

                    // Check Obat-obatan
                    const obat = document.querySelector('input[name="obat_obatan"]:checked')?.value;
                    const obatJenis = document.getElementById('obat_jenis');
                    if (obat === 'ya' && obatJenis && !obatJenis.value.trim()) {
                        errors.push('Jenis obat-obatan harus diisi.');
                        obatJenis.classList.add('is-invalid');
                    }

                    // Validate 'lainnya' field
                    if (lainnyaCheck && lainnyaInput) {
                        if (lainnyaCheck.checked && !lainnyaInput.value.trim()) {
                            errors.push('Rencana lainnya wajib diisi jika dicentang.');
                            lainnyaInput.classList.add('is-invalid');
                        } else {
                            lainnyaInput.classList.remove('is-invalid');
                        }
                    }

                    // If there are errors, prevent form submission and show alert
                    if (errors.length > 0) {
                        event.preventDefault();
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Data Belum Lengkap',
                                html: errors.join('<br>'),
                                confirmButtonColor: '#3085d6',
                            });
                        } else {
                            alert('Data Belum Lengkap:\n' + errors.join('\n'));
                        }
                    }
                });
            }
        });
    </script>
@endpush
