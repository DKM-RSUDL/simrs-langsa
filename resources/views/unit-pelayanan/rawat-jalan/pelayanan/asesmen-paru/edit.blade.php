@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.rawat-jalan.pelayanan.asesmen-paru.edit-include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-asesmen-tht')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-info mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form method="POST" enctype="multipart/form-data" action="{{ route('rawat-jalan.asesmen.medis.paru.update', [
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
                                                <td class="label-col">Dyspnea</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-check-group">
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
                                                <td class="label-col">Oedema</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-check-group">
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
                                                <td class="label-col">Icterus</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-check-group">
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
                                                                        <input class="form-check-input" type="radio" name="paru_kepala" value="1" id="paru_kepala_normal"
                                                                            {{ ($pemeriksaanFisikParu->paru_kepala ?? 1) == 1 ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="paru_kepala_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="paru_kepala" value="0" id="paru_kepala_tidak_normal"
                                                                            {{ ($pemeriksaanFisikParu->paru_kepala ?? 1) == 0 ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="paru_kepala_tidak_normal">Tidak Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="paru_kepala_keterangan" id="paru_kepala_keterangan"
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
                                                                        <input class="form-check-input" type="radio" name="paru_mata" value="1" id="paru_mata_normal"
                                                                            {{ ($pemeriksaanFisikParu->paru_mata ?? 1) == 1 ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="paru_mata_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="paru_mata" value="0" id="paru_mata_tidak_normal"
                                                                            {{ ($pemeriksaanFisikParu->paru_mata ?? 1) == 0 ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="paru_mata_tidak_normal">Tidak Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="paru_mata_keterangan" id="paru_mata_keterangan"
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
                                                                        <input class="form-check-input" type="radio" name="paru_tht" value="1" id="paru_tht_normal"
                                                                            {{ ($pemeriksaanFisikParu->paru_tht ?? 1) == 1 ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="paru_tht_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="paru_tht" value="0" id="paru_tht_tidak_normal"
                                                                            {{ ($pemeriksaanFisikParu->paru_tht ?? 1) == 0 ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="paru_tht_tidak_normal">Tidak Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="paru_tht_keterangan" id="paru_tht_keterangan"
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
                                                                        <input class="form-check-input" type="radio" name="paru_leher" value="1" id="paru_leher_normal"
                                                                            {{ ($pemeriksaanFisikParu->paru_leher ?? 1) == 1 ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="paru_leher_normal">Normal</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="paru_leher" value="0" id="paru_leher_tidak_normal"
                                                                            {{ ($pemeriksaanFisikParu->paru_leher ?? 1) == 0 ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="paru_leher_tidak_normal">Tidak Normal</label>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="paru_leher_keterangan" id="paru_leher_keterangan"
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
                                                                                    <input class="form-check-input" type="radio" name="paru_jantung" value="1" id="paru_jantung_normal"
                                                                                        {{ ($pemeriksaanFisikParu->paru_jantung ?? 1) == 1 ? 'checked' : '' }}>
                                                                                    <label class="form-check-label" for="paru_jantung_normal">Normal</label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input" type="radio" name="paru_jantung" value="0" id="paru_jantung_tidak_normal"
                                                                                        {{ ($pemeriksaanFisikParu->paru_jantung ?? 1) == 0 ? 'checked' : '' }}>
                                                                                    <label class="form-check-label" for="paru_jantung_tidak_normal">Tidak Normal</label>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="paru_jantung_keterangan" id="paru_jantung_keterangan"
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
                                                                                    <label class="text-muted">Inspeksi</label>
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                    <div class="d-flex align-items-center gap-2">
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input" type="radio" name="paru_inspeksi" value="simetris" id="paru_inspeksi_simetris"
                                                                                                {{ ($pemeriksaanFisikParu->paru_inspeksi ?? 'simetris') == 'simetris' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="paru_inspeksi_simetris">Simetris</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input" type="radio" name="paru_inspeksi" value="asimetris" id="paru_inspeksi_asimetris"
                                                                                                {{ ($pemeriksaanFisikParu->paru_inspeksi ?? '') == 'asimetris' ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="paru_inspeksi_asimetris">Asimetris</label>
                                                                                        </div>
                                                                                        <span>-</span>
                                                                                        <input type="text" class="form-control input-inline" name="paru_inspeksi_keterangan" id="paru_inspeksi_keterangan"
                                                                                            placeholder="Keterangan" value="{{ $pemeriksaanFisikParu->paru_inspeksi_keterangan ?? '' }}">
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
                                                                                        <input type="text" class="form-control" name="paru_palpasi" placeholder="Hasil palpasi"
                                                                                            value="{{ $pemeriksaanFisikParu->paru_palpasi ?? '' }}">
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
                                                                                        <input type="text" class="form-control" name="paru_perkusi" placeholder="Hasil perkusi"
                                                                                            value="{{ $pemeriksaanFisikParu->paru_perkusi ?? '' }}">
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
                                                                                        <input type="text" class="form-control" name="paru_auskultasi" placeholder="Hasil auskultasi"
                                                                                            value="{{ $pemeriksaanFisikParu->paru_auskultasi ?? '' }}">
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
                                                                                        @php
                                                                                            $suaraPernafasanData = [];
                                                                                            if($pemeriksaanFisikParu && $pemeriksaanFisikParu->paru_suara_pernafasan) {
                                                                                                $suaraPernafasanData = json_decode($pemeriksaanFisikParu->paru_suara_pernafasan, true) ?: [];
                                                                                            }
                                                                                        @endphp
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-pernafasan" type="checkbox" value="vesikuler" id="sp_vesikuler"
                                                                                                {{ in_array('vesikuler', $suaraPernafasanData) ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="sp_vesikuler">Vesikuler</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-pernafasan" type="checkbox" value="vesikuler_melemah" id="sp_vesikuler_melemah"
                                                                                                {{ in_array('vesikuler_melemah', $suaraPernafasanData) ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="sp_vesikuler_melemah">Vesikuler Melemah</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-pernafasan" type="checkbox" value="ekspirasi_memanjang" id="sp_ekspirasi_memanjang"
                                                                                                {{ in_array('ekspirasi_memanjang', $suaraPernafasanData) ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="sp_ekspirasi_memanjang">Ekspirasi Memanjang</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-pernafasan" type="checkbox" value="vesikuler_mengeras" id="sp_vesikuler_mengeras"
                                                                                                {{ in_array('vesikuler_mengeras', $suaraPernafasanData) ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="sp_vesikuler_mengeras">Vesikuler Mengeras</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-pernafasan" type="checkbox" value="bronkial" id="sp_bronkial"
                                                                                                {{ in_array('bronkial', $suaraPernafasanData) ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="sp_bronkial">Bronkial</label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Hidden input untuk menampung JSON -->
                                                                                    <input type="hidden" name="paru_suara_pernafasan" id="paru_suara_pernafasan_json"
                                                                                        value="{{ $pemeriksaanFisikParu->paru_suara_pernafasan ?? '' }}">
                                                                                </div>
                                                                            </div>

                                                                            <!-- Suara Tambahan (ST) -->
                                                                            <div class="row mb-2">
                                                                                <div class="col-md-3">
                                                                                    <label class="text-muted">Suara Tambahan (ST):</label>
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                    <div class="d-flex flex-wrap gap-3">
                                                                                        @php
                                                                                            $suaraTambahanData = [];
                                                                                            if($pemeriksaanFisikParu && $pemeriksaanFisikParu->paru_suara_tambahan) {
                                                                                                $suaraTambahanData = json_decode($pemeriksaanFisikParu->paru_suara_tambahan, true) ?: [];
                                                                                            }
                                                                                        @endphp
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-tambahan" type="checkbox" value="rhonkhi_basah_halus" id="st_rhonkhi_basah_halus"
                                                                                                {{ in_array('rhonkhi_basah_halus', $suaraTambahanData) ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="st_rhonkhi_basah_halus">Rhonkhi Basah Halus</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-tambahan" type="checkbox" value="rhonkhi_basah_kasar" id="st_rhonkhi_basah_kasar"
                                                                                                {{ in_array('rhonkhi_basah_kasar', $suaraTambahanData) ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="st_rhonkhi_basah_kasar">Rhonkhi Basah Kasar</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-tambahan" type="checkbox" value="rhonkhi_kering" id="st_rhonkhi_kering"
                                                                                                {{ in_array('rhonkhi_kering', $suaraTambahanData) ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="st_rhonkhi_kering">Rhonkhi Kering</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-tambahan" type="checkbox" value="wheezing" id="st_wheezing"
                                                                                                {{ in_array('wheezing', $suaraTambahanData) ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="st_wheezing">Wheezing</label>
                                                                                        </div>
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input paru-suara-tambahan" type="checkbox" value="amforik" id="st_amforik"
                                                                                                {{ in_array('amforik', $suaraTambahanData) ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="st_amforik">Amforik</label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Hidden input untuk menampung JSON -->
                                                                                    <input type="hidden" name="paru_suara_tambahan" id="paru_suara_tambahan_json"
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
                                                    <button type="button" class="btn btn-outline-success" id="paruUpdateMarking" style="display: none;">
                                                        <i class="ti-check"></i> Update Penandaan
                                                    </button>
                                                    <button type="button" class="btn btn-outline-warning" id="paruUndoLast">
                                                        <i class="ti-back-left"></i> Undo Terakhir
                                                    </button>
                                                    <button type="button" class="btn btn-outline-secondary" id="paruCancelEdit" style="display: none;">
                                                        <i class="ti-close"></i> Batal Edit
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
                                    <input type="hidden" name="site_marking_paru_data" id="siteMarkingParuData" value="{{ $siteMarkingParuData ?? '' }}">
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
                                            KGDS</label>
                                        <input type="checkbox" name="kgds" value="1" class="form-check-input" id="kgds" {{ ($rencanaKerja->kgds ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">f.</span> Pemeriksaan faal hati (LFT)</label>
                                        <input type="checkbox" name="faal_hati" value="1" class="form-check-input"
                                            id="faal_hati" {{ ($rencanaKerja->faal_hati ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">g.</span> Pemeriksaan faal
                                            ginjal (RFG)</label>
                                        <input type="checkbox" name="faal_ginjal" value="1" class="form-check-input"
                                            id="faal_ginjal" {{ ($rencanaKerja->faal_ginjal ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">h.</span> Pemeriksaan
                                            elektrolit</label>
                                        <input type="checkbox" name="elektrolit" value="1" class="form-check-input"
                                            id="elektrolit" {{ ($rencanaKerja->elektrolit ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">i.</span> Pemeriksaan
                                            albumin</label>
                                        <input type="checkbox" name="albumin" value="1" class="form-check-input"
                                            id="albumin" {{ ($rencanaKerja->albumin ?? 0) ? 'checked' : '' }}>
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
                                        <label style="min-width: 300px;"><span class="fw-bold">q.</span> Biopsi Kelenjar</label>
                                        <input type="checkbox" name="biopsi_kelenjar" value="1" class="form-check-input"
                                            id="biopsi_kelenjar" {{ ($rencanaKerja->biopsi_kelenjar ?? 0) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">r.</span> Mantoux Tes</label>
                                        <input type="checkbox" name="mantoux_tes" value="1" class="form-check-input" id="mantoux_tes"
                                            {{ ($rencanaKerja->mantoux_tes ?? 0) ? 'checked' : '' }}>
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

                                <div class="mb-4">
                                    <label class="text-primary fw-semibold">Prognosis</label>

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
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Tambah Data Alergi</h6>
                    </div>
                    <div class="card-body">
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            //====================================================================================//
            // ALERGI - EDIT MODE
            //====================================================================================//

            // Array untuk menyimpan data alergi sementara
            let alergiDataArray = [];

            // Load existing alergi data from PHP
            try {
                const existingAlergiData = @json($alergiPasien ?? []);
                alergiDataArray = existingAlergiData.map(item => ({
                    jenis_alergi: item.jenis_alergi || '',
                    alergen: item.nama_alergi || '',
                    reaksi: item.reaksi || '',
                    tingkat_keparahan: item.tingkat_keparahan || '',
                    is_existing: true,
                    id: item.id || null
                }));
            } catch (e) {
                console.log('Data alergi tidak tersedia');
                alergiDataArray = [];
            }

            // Event listeners untuk alergi
            const openAlergiModal = document.getElementById('openAlergiModal');
            if (openAlergiModal) {
                openAlergiModal.addEventListener('click', function() {
                    updateModalAlergiList();
                });
            }

            const addToAlergiList = document.getElementById('addToAlergiList');
            if (addToAlergiList) {
                addToAlergiList.addEventListener('click', function() {
                    const jenisAlergi = document.getElementById('modal_jenis_alergi')?.value?.trim();
                    const alergen = document.getElementById('modal_alergen')?.value?.trim();
                    const reaksi = document.getElementById('modal_reaksi')?.value?.trim();
                    const tingkatKeparahan = document.getElementById('modal_tingkat_keparahan')?.value
                        ?.trim();

                    if (!jenisAlergi || !alergen || !reaksi || !tingkatKeparahan) {
                        alert('Harap isi semua field alergi');
                        return;
                    }

                    const isDuplicate = alergiDataArray.some(item =>
                        item.jenis_alergi === jenisAlergi &&
                        item.alergen.toLowerCase() === alergen.toLowerCase()
                    );

                    if (isDuplicate) {
                        alert('Data alergi sudah ada');
                        return;
                    }

                    alergiDataArray.push({
                        jenis_alergi: jenisAlergi,
                        alergen: alergen,
                        reaksi: reaksi,
                        tingkat_keparahan: tingkatKeparahan,
                        is_existing: false
                    });

                    updateModalAlergiList();
                    resetAlergiForm();
                });
            }

            const saveAlergiData = document.getElementById('saveAlergiData');
            if (saveAlergiData) {
                saveAlergiData.addEventListener('click', function() {
                    updateMainAlergiTable();
                    updateHiddenAlergiInput();

                    const alergiModal = document.getElementById('alergiModal');
                    if (alergiModal && typeof bootstrap !== 'undefined') {
                        const modalInstance = bootstrap.Modal.getInstance(alergiModal);
                        if (modalInstance) modalInstance.hide();
                    }
                });
            }

            // Functions untuk alergi
            function updateModalAlergiList() {
                const tbody = document.getElementById('modalAlergiList');
                const noDataMessage = document.getElementById('noAlergiMessage');
                const countBadge = document.getElementById('alergiCount');

                if (!tbody) return;

                tbody.innerHTML = '';

                if (alergiDataArray.length === 0) {
                    if (noDataMessage) noDataMessage.style.display = 'block';
                    const table = tbody.closest('table');
                    if (table) table.style.display = 'none';
                } else {
                    if (noDataMessage) noDataMessage.style.display = 'none';
                    const table = tbody.closest('table');
                    if (table) table.style.display = 'table';

                    alergiDataArray.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.jenis_alergi}</td>
                            <td>${item.alergen}</td>
                            <td>${item.reaksi}</td>
                            <td>
                                <span class="badge ${getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                    ${item.tingkat_keparahan}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeAlergiFromModal(${index})">
                                    <i class="bi bi-trash"></i>
                                </button>
                                ${item.is_existing ? '<small class="text-muted d-block">Dari DB</small>' : '<small class="text-success d-block">Baru</small>'}
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }

                if (countBadge) countBadge.textContent = alergiDataArray.length;
            }

            function updateMainAlergiTable() {
                const tbody = document.querySelector('#createAlergiTable tbody');
                const noAlergiRow = document.getElementById('no-alergi-row');

                if (!tbody || !noAlergiRow) return;

                const existingRows = tbody.querySelectorAll('tr:not(#no-alergi-row)');
                existingRows.forEach(row => row.remove());

                if (alergiDataArray.length === 0) {
                    noAlergiRow.style.display = 'table-row';
                } else {
                    noAlergiRow.style.display = 'none';

                    alergiDataArray.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.jenis_alergi}</td>
                            <td>${item.alergen}</td>
                            <td>${item.reaksi}</td>
                            <td>
                                <span class="badge ${getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                    ${item.tingkat_keparahan}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeAlergiFromMain(${index})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }
            }

            function updateHiddenAlergiInput() {
                const hiddenInput = document.getElementById('alergisInput');
                if (hiddenInput) {
                    hiddenInput.value = JSON.stringify(alergiDataArray);
                }
            }

            function resetAlergiForm() {
                const fields = ['modal_jenis_alergi', 'modal_alergen', 'modal_reaksi', 'modal_tingkat_keparahan'];
                fields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) field.value = '';
                });
            }

            function getKeparahanBadgeClass(keparahan) {
                switch (keparahan.toLowerCase()) {
                    case 'ringan':
                        return 'bg-success';
                    case 'sedang':
                        return 'bg-warning';
                    case 'berat':
                        return 'bg-danger';
                    default:
                        return 'bg-secondary';
                }
            }

            // Global functions untuk onclick events
            window.removeAlergiFromModal = function(index) {
                alergiDataArray.splice(index, 1);
                updateModalAlergiList();
            };

            window.removeAlergiFromMain = function(index) {
                alergiDataArray.splice(index, 1);
                updateMainAlergiTable();
                updateHiddenAlergiInput();
            };

            // Initial load untuk alergi
            updateMainAlergiTable();
            updateHiddenAlergiInput();

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
        const updateBtn = document.getElementById('paruUpdateMarking');
        const cancelEditBtn = document.getElementById('paruCancelEdit');
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
        let isEditing = false;
        let editingMarkingId = null;

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

        // Update existing marking
        updateBtn.addEventListener('click', function() {
            if (!isEditing || !editingMarkingId) {
                alert('Tidak ada penandaan yang sedang diedit.');
                return;
            }

            if (allStrokes.length === 0) {
                alert('Tidak ada gambar untuk diupdate. Silakan gambar ulang atau batalkan edit.');
                return;
            }

            const note = markingNote.value.trim() || `Penandaan Paru ${markingCounter}`;

            // Find and update the marking
            const markingIndex = savedMarkings.findIndex(m => m.id === editingMarkingId);
            if (markingIndex !== -1) {
                savedMarkings[markingIndex] = {
                    ...savedMarkings[markingIndex],
                    strokes: JSON.parse(JSON.stringify(allStrokes)),
                    note: note,
                    timestamp: new Date().toISOString()
                };

                // Update display
                updateParuHiddenInput();
                rebuildMarkingsList();

                // Exit edit mode
                exitEditMode();

                alert('Penandaan berhasil diupdate!');
            }
        });

        // Cancel edit mode
        cancelEditBtn.addEventListener('click', function() {
            if (confirm('Batalkan edit? Perubahan yang belum disimpan akan hilang.')) {
                exitEditMode();
            }
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
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-warning btn-sm" onclick="editParuMarking('${marking.id}')">
                            <i class="ti-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteParuMarking('${marking.id}')">
                            <i class="ti-trash"></i>
                        </button>
                    </div>
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
                    rebuildMarkingsList();
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

        function rebuildMarkingsList() {
            markingsList.innerHTML = '<div class="text-muted text-center py-3" id="paruEmptyState"><i class="ti-info-alt"></i> Belum ada penandaan</div>';
            savedMarkings.forEach(marking => {
                addToParuMarkingsList(marking);
            });
        }

        function enterEditMode(markingId) {
            isEditing = true;
            editingMarkingId = markingId;

            // Find the marking
            const marking = savedMarkings.find(m => m.id === markingId);
            if (marking) {
                // Load the marking data for editing
                markingNote.value = marking.note;
                allStrokes = JSON.parse(JSON.stringify(marking.strokes)); // Deep copy
                currentStroke = [];

                // Redraw canvas with the marking to edit
                redrawParuCanvas();

                // Show/hide appropriate buttons
                saveBtn.style.display = 'none';
                updateBtn.style.display = 'inline-block';
                cancelEditBtn.style.display = 'inline-block';

                // Disable other controls during edit
                undoBtn.disabled = false;
                clearAllBtn.disabled = true;
            }
        }

        function exitEditMode() {
            isEditing = false;
            editingMarkingId = null;

            // Clear current drawing
            allStrokes = [];
            currentStroke = [];
            markingNote.value = '';

            // Redraw canvas
            redrawParuCanvas();

            // Reset buttons
            saveBtn.style.display = 'inline-block';
            updateBtn.style.display = 'none';
            cancelEditBtn.style.display = 'none';

            // Re-enable controls
            undoBtn.disabled = false;
            clearAllBtn.disabled = false;
        }

        // Global function for edit
        window.editParuMarking = function(markingId) {
            if (isEditing) {
                if (confirm('Anda sedang mengedit penandaan lain. Batalkan edit sebelumnya?')) {
                    exitEditMode();
                } else {
                    return;
                }
            }

            enterEditMode(markingId);
        };

        // Global function for delete
        window.deleteParuMarking = function(markingId) {
            if (isEditing && editingMarkingId === markingId) {
                alert('Tidak dapat menghapus penandaan yang sedang diedit. Batalkan edit terlebih dahulu.');
                return;
            }

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
