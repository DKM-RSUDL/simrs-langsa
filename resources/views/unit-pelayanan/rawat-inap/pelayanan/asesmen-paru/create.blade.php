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
                            <!-- 1. Data masuk -->
                            <div class="section-separator" id="data-masuk">
                                <h5 class="section-title">1. Data masuk</h5>
                                <div class="form-group">
                                    <label>Ruangan</label>
                                    <input type="text" class="form-control" name="ruangan" placeholder="Nama ruangan">
                                </div>
                            </div>

                            <!-- 2. Anamnesis -->
                            <div class="section-separator" id="anamnesis">
                                <h5 class="section-title">2. Anamnesis</h5>

                                <div class="form-group">
                                    <label>ALERGI</label>
                                    <textarea class="form-control" name="alergi" rows="3"
                                        placeholder="Sebutkan alergi pasien jika ada"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>ANAMNESA (auto/allo)</label>
                                    <textarea class="form-control" name="anamnesa" rows="3"
                                        placeholder="Keluhan utama pasien"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Keluhan utama</label>
                                    <select class="form-select" name="keluhan_utama">
                                        <option value="">Pilih</option>
                                        <option value="batuk">batuk</option>
                                        <option value="batuk_darah">batuk darah</option>
                                        <option value="nyeri_dada">nyeri dada</option>
                                        <option value="demam">demam</option>
                                        <option value="keringat_dingin">keringat dingin</option>
                                        <option value="nafsu_makan">nafsu makan</option>
                                        <option value="bb">BB</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Riwayat penyakit</label>
                                    <textarea class="form-control" name="riwayat_penyakit" rows="4"
                                        placeholder="Riwayat penyakit sekarang"></textarea>
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
                                                    <div class="form-check-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="merokok"
                                                                value="tidak" id="merokok_tidak">
                                                            <label class="form-check-label"
                                                                for="merokok_tidak">Tidak</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="merokok"
                                                                value="ya" id="merokok_ya">
                                                            <label class="form-check-label" for="merokok_ya">Ya,
                                                                jumlah:</label>
                                                        </div>
                                                        <input type="number" class="form-control input-inline input-sm"
                                                            name="merokok_jumlah">
                                                        <span>batang/hari</span>
                                                        <span class="ms-3">Lama:</span>
                                                        <input type="number" class="form-control input-inline input-sm"
                                                            name="merokok_lama">
                                                        <span>tahun</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col">b. Alkohol</td>
                                                <td>
                                                    <div class="form-check-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="alkohol"
                                                                value="tidak" id="alkohol_tidak">
                                                            <label class="form-check-label"
                                                                for="alkohol_tidak">Tidak</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="alkohol"
                                                                value="ya" id="alkohol_ya">
                                                            <label class="form-check-label" for="alkohol_ya">Ya,
                                                                jumlah:</label>
                                                        </div>
                                                        <input type="text" class="form-control input-inline input-lg"
                                                            name="alkohol_jumlah">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col">c. Obat-obatan</td>
                                                <td>
                                                    <div class="form-check-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="obat_obatan"
                                                                value="tidak" id="obat_tidak">
                                                            <label class="form-check-label" for="obat_tidak">Tidak</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="obat_obatan"
                                                                value="ya" id="obat_ya">
                                                            <label class="form-check-label" for="obat_ya">Ya</label>
                                                        </div>
                                                        <input type="text" class="form-control input-inline input-lg"
                                                            name="obat_jenis">
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
                                                        <input type="text" class="form-control input-inline input-md"
                                                            name="tekanan_darah">
                                                        <span>mmHg</span>
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

                                <div class="mt-5">
                                    <div class="form-group">
                                        <label>gambar radiologi paru</label>
                                        <input type="file" class="form-control" name="gambar_radiologi_paru"
                                            placeholder="gambar radiologi paru">
                                    </div>
                                    <div class="form-group">
                                        <label>diagnosis banding</label>
                                        <textarea class="form-control" name="diagnosis_banding" rows="4"
                                            placeholder="diagnosis banding"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>diagnosis kerja</label>
                                        <textarea class="form-control" name="diagnosis_kerja" rows="4"
                                            placeholder="diagnosis kerja"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- 7. Rencana Kerja Dan Penatalaksanaan -->
                            <div class="section-separator" id="rencana-kerja">
                                <h5 class="section-title">7. Rencana Kerja Dan Penatalaksanaan</h5>
                                <div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">a.</span> Foto thorax</label>
                                        <input type="checkbox" name="foto_thoraks">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">b.</span> Pemeriksaan darah rutin</label>
                                        <input type="checkbox" name="darah_rutin">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">c.</span> Pemeriksaan LED</label>
                                        <input type="checkbox" name="led">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">d.</span> Pemeriksaan sputum BTA</label>
                                        <input type="checkbox" name="sputum_bta">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">e.</span> Pemeriksaan IGDS</label>
                                        <input type="checkbox" name="igds">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">f.</span> Pemeriksaan faal ginjal (RFG)</label>
                                        <input type="checkbox" name="faal_ginjal">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">g.</span> Pemeriksaan elektrolit</label>
                                        <input type="checkbox" name="elektrolit">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">h.</span> Pemeriksaan albumin</label>
                                        <input type="checkbox" name="albumin">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">i.</span> CT Scan thorax</label>
                                        <input type="checkbox" name="ct_scan_thorax">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">j.</span> Memeriksaan asam urat</label>
                                        <input type="checkbox" name="asam_urat">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">k.</span> Faal paru ( APE, spirometri )</label>
                                        <input type="checkbox" name="faal_paru">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">l.</span> CT Scan thoraks</label>
                                        <input type="checkbox" name="ct_scan_thoraks">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">m.</span> Bronchoscopy</label>
                                        <input type="checkbox" name="bronchoscopy">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">n.</span> Proef Punctie</label>
                                        <input type="checkbox" name="proef_punctie">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">o.</span> Aspirasi cairan pleura</label>
                                        <input type="checkbox" name="aspirasi_cairan_pleura">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">p.</span> Penanganan WSD</label>
                                        <input type="checkbox" name="penanganan_wsd">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">q.</span> Penanganan penyakit</label>
                                        <input type="checkbox" name="penanganan_penyakit">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">r.</span> Konsul Tes</label>
                                        <input type="checkbox" name="konsul">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 300px;"><span class="fw-bold">s.</span> Lainnya</label>
                                        <input type="text" class="form-control" name="lainnya">
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <div class="form-group">
                                        <label>Prognosis</label>
                                        <textarea class="form-control" name="prognosis" rows="4"
                                            placeholder="prognosis"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- 8. Perencanaan Pulang Pasien -->
                            <div class="section-separator" id="rencana-kerja">
                                <h5 class="section-title">8. Perencanaan Pulang Pasien (Discharge Planning)</h5>
                                <p>Jika salah satu jawaban "Ya" maka perencanaan penuh/khusus</p>
                                <div class="form-group">
                                    <label style="min-width: 500px;">Usia lanjut (>60 th)</label>
                                    <div>
                                        <input type="radio" name="usia_lanjut" value="Ya"> Ya
                                        <input type="radio" name="usia_lanjut" value="Tidak"> Tidak
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 500px;">Hambatan mobilitas</label>
                                    <div>
                                        <input type="radio" name="hambatan_mobilitas" value="Ya"> Ya
                                        <input type="radio" name="hambatan_mobilitas" value="Tidak"> Tidak
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 500px;">Membutuhkan pelayanan meds berkelanjutan</label>
                                    <div>
                                        <input type="radio" name="pelayanan_meds_berkelanjutan" value="Ya"> Ya
                                        <input type="radio" name="pelayanan_meds_berkelanjutan" value="Tidak"> Tidak
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 500px;">Keteraturan dalam mengonsumsi obat dalam aktivitas harian</label>
                                    <div>
                                        <input type="radio" name="keteraturan_obat" value="Ya"> Ya
                                        <input type="radio" name="keteraturan_obat" value="Tidak"> Tidak
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 500px;">Rencana Pulang Khusus: :</label>
                                    <input type="text" class="form-control" name="rencana_pulang_khusus:">
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 500px;">Renacana Lama Perawatan :</label>
                                    <input type="text" class="form-control" name="renacana_lama_perawatan">
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 500px;">Rencana Tanggal Pulang :</label>
                                    <input type="date" class="form-control">
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
                </div>
            </form>
        </div>
    </div>
@endsection
