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

                                <div class="form-group">
                                        <label for="alergi">Alergi</label>
                                        <div class="input-group">
                                            <input type="text" name="alergi_display" id="alergi_display"
                                                class="form-control" placeholder="Alergi pasien (jika ada)"
                                                value="{{ $allergiesDisplay ?? '' }}" readonly>
                                            <input type="hidden" name="alergi" id="alergi"
                                                value="{{ $allergiesJson ?? '' }}">
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
                                                        <div class="col-lg-6">
                                                            <div class="form-check-group">
                                                                <span>Dyspnoe</span>
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
                                                        <div class="col-lg-6">
                                                            <div class="form-check-group">
                                                                <span>Cyanose</span>
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
                                                        <div class="col-lg-6">
                                                            <div class="form-check-group">
                                                                <span>Oedema</span>
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
                                                        <div class="col-lg-4">
                                                            <div class="form-check-group">
                                                                <span>Icterus</span>
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
                                                        <div class="col-lg-4">
                                                            <div class="form-check-group">
                                                                <span>Anemia</span>
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
                                <div class="row g-3">
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
                                </div>
                            </div>


                            <!-- 7. Rencana Kerja Dan Penatalaksanaan -->
                            <div class="section-separator" id="rencana-kerja">
                                <h5 class="section-title">7. Rencana Kerja Dan Penatalaksanaan</h5>
                                <div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">a.</span> Foto thorax</label>
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
                                        <label style="min-width: 300px;"><span class="fw-bold">e.</span> Pemeriksaan IGDS</label>
                                        <input type="checkbox" name="igds" value="1" class="form-check-input" id="igds">
                                        @error('igds')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">f.</span> Pemeriksaan faal ginjal (RFG)</label>
                                        <input type="checkbox" name="faal_ginjal" value="1" class="form-check-input" id="faal_ginjal">
                                        @error('faal_ginjal')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">g.</span> Pemeriksaan elektrolit</label>
                                        <input type="checkbox" name="elektrolit" value="1" class="form-check-input" id="elektrolit">
                                        @error('elektrolit')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">h.</span> Pemeriksaan albumin</label>
                                        <input type="checkbox" name="albumin" value="1" class="form-check-input" id="albumin">
                                        @error('albumin')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">i.</span> CT Scan thorax</label>
                                        <input type="checkbox" name="ct_scan_thorax" value="1" class="form-check-input" id="ct_scan_thorax">
                                        @error('ct_scan_thorax')
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
                                        <label style="min-width: 300px;"><span class="fw-bold">q.</span> Penanganan penyakit</label>
                                        <input type="checkbox" name="penanganan_penyakit" value="1" class="form-check-input" id="penanganan_penyakit">
                                        @error('penanganan_penyakit')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <label style="min-width: 300px;"><span class="fw-bold">r.</span> Konsul Tes</label>
                                        <input type="checkbox" name="konsul" value="1" class="form-check-input" id="konsul">
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

                                <div class="mt-5">
                                    <div class="form-group">
                                        <label>gambar radiologi paru</label>
                                        <input type="file" class="form-control" name="gambar_radiologi_paru"
                                            placeholder="gambar radiologi paru">
                                    </div>
                                </div>
                            </div>

                            <div class="section-separator" id="implemetasi" style="margin-bottom: 2rem;">
                                <h5 class="fw-semibold mb-4">10. Implementasi</h5>

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
                                    <div id="observasi-list" class="list-group mb-2 bg-light">
                                        <!-- Items will be added here dynamically -->
                                    </div>
                                    <!-- Hidden input to store JSON data -->
                                    <input type="hidden" id="observasi" name="observasi" value="[]">
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
                                    <div id="terapeutik-list" class="list-group mb-2">
                                        <!-- Items will be added here dynamically -->
                                    </div>
                                    <!-- Hidden input to store JSON data -->
                                    <input type="hidden" id="terapeutik" name="terapeutik" value="[]">
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
                                    <div id="edukasi-list" class="list-group mb-2">
                                        <!-- Items will be added here dynamically -->
                                    </div>
                                    <!-- Hidden input to store JSON data -->
                                    <input type="hidden" id="edukasi" name="edukasi" value="[]">
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
                                    <div id="kolaborasi-list" class="list-group mb-2">
                                        <!-- Items will be added here dynamically -->
                                    </div>
                                    <!-- Hidden input to store JSON data -->
                                    <input type="hidden" id="kolaborasi" name="kolaborasi" value="[]">
                                </div>

                                <!-- Kolaborasi Section -->
                                <div class="mb-4">
                                    <label class="text-primary fw-semibold">Prognosis</label>
                                    <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                        Prognosis, apabila tidak ada, Pilih tanda tambah untuk menambah
                                        keterangan
                                        Prognosis yang tidak ditemukan.</small>
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

                                    <div id="rencana-list" class="list-group mb-3">
                                        <!-- Items will be added here dynamically -->
                                    </div>
                                    <!-- Hidden input to store JSON data -->
                                    <input type="hidden" id="rencana_penatalaksanaan" name="prognosis" value="[]">
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
    </script>
@endpush
