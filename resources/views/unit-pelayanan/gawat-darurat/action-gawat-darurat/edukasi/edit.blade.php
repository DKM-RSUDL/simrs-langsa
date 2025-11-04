@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.edukasi.include')


    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>


        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Perbarui Edukasi Pasien dan Keluarga Terintegrasi',
                    'description' =>
                        'Perbarui data edukasi pasien dan keluarga terintegrasi pasien gawat darurat dengan mengisi formulir di bawah ini.',
                ])
                @php
                    // Helper functions untuk menampilkan data yang sudah ada
                    function getEditExistingValue($model, $field, $default = '')
                    {
                        return isset($model) && isset($model->$field) ? $model->$field : old($field, $default);
                    }

                    function getEditExistingJsonArray($model, $field, $default = [])
                    {
                        if (!isset($model) || !isset($model->$field)) {
                            return old($field, $default);
                        }
                        $decoded = json_decode($model->$field, true);
                        return is_array($decoded) ? $decoded : ($decoded ? [$decoded] : $default);
                    }

                    function isEditExistingChecked($model, $field, $value)
                    {
                        $data = getEditExistingJsonArray($model, $field, []);
                        return in_array($value, $data);
                    }
                @endphp

                <form id="edukasiForm" method="POST"
                    action="{{ route('edukasi.update', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $edukasi->id]) }}">
                    @csrf
                    @method('PUT')



                    <?php
                    // Helper function untuk check array values dalam JSON
                    function isCheckedInJson($jsonData, $value)
                    {
                        if (!$jsonData) {
                            return false;
                        }
                        $data = json_decode($jsonData, true);
                        if (!is_array($data)) {
                            return false;
                        }
                        return in_array($value, $data);
                    }

                    // Helper function untuk get value dari relasi dengan null check
                    function getRelationValue($relation, $field, $default = '')
                    {
                        return isset($relation) && isset($relation->$field) ? $relation->$field : $default;
                    }
                    ?>
                    <!-- 1. Kebutuhan Penerjemah -->
                    <div class="section-separator mt-0" id="kebutuhan-penerjemah">
                        <h5 class="section-title">1. Kebutuhan Penerjemah</h5>
                        <div class="form-group">
                            <label style="min-width: 200px;">Kebutuhan Penerjemah</label>
                            <div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="penerjemah_tidak"
                                        name="kebutuhan_penerjemah" value="0"
                                        {{ old('kebutuhan_penerjemah', getRelationValue($edukasi->edukasiPasien, 'kebutuhan_penerjemah')) == '0'
                                            ? 'checked'
                                            : '' }}>
                                    <label class="form-check-label" for="penerjemah_tidak">Tidak</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="penerjemah_ya"
                                        name="kebutuhan_penerjemah" value="1"
                                        {{ old('kebutuhan_penerjemah', getRelationValue($edukasi->edukasiPasien, 'kebutuhan_penerjemah')) == '1'
                                            ? 'checked'
                                            : '' }}>
                                    <label class="form-check-label" for="penerjemah_ya">Ya, bahasa</label>
                                    <input type="text"
                                        class="form-control mt-2 @error('penerjemah_bahasa') is-invalid @enderror"
                                        name="penerjemah_bahasa" id="penerjemah_bahasa_input"
                                        value="{{ old('penerjemah_bahasa', getRelationValue($edukasi->edukasiPasien, 'penerjemah_bahasa')) }}"
                                        style="{{ old('kebutuhan_penerjemah', getRelationValue($edukasi->edukasiPasien, 'kebutuhan_penerjemah')) == '1' ? 'display: block;' : 'display: none;' }}">
                                    @error('penerjemah_bahasa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Pendidikan -->
                    <div class="section-separator" id="pendidikan">
                        <h5 class="section-title">2. Pendidikan</h5>
                        <div class="form-group">
                            <label style="min-width: 200px;">Tingkat Pendidikan</label>
                            <select class="form-select" name="pendidikan">
                                <option value="">--Pilih--</option>
                                @foreach ($pendidikan as $didikan)
                                    <option value="{{ $didikan->kd_pendidikan }}"
                                        {{ isset($edukasi->edukasiPasien) && $edukasi->edukasiPasien->pendidikan == $didikan->kd_pendidikan
                                            ? 'selected'
                                            : '' }}>
                                        {{ $didikan->pendidikan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- 3. Kemampuan Baca Tulis -->
                    <div class="section-separator" id="kemampuan-baca-tulis">
                        <h5 class="section-title">3. Kemampuan Baca Tulis</h5>
                        <div class="form-group">
                            <label style="min-width: 200px;">Kemampuan Baca Tulis</label>
                            <select class="form-select" name="kemampuan_baca_tulis">
                                <option value="">--Pilih--</option>
                                <option value="baik"
                                    {{ isset($edukasi->edukasiPasien) && $edukasi->edukasiPasien->kemampuan_baca_tulis == 'baik' ? 'selected' : '' }}>
                                    Baik</option>
                                <option value="kurang"
                                    {{ isset($edukasi->edukasiPasien) && $edukasi->edukasiPasien->kemampuan_baca_tulis == 'kurang'
                                        ? 'selected'
                                        : '' }}>
                                    Kurang</option>
                                <option value="tidak_mampu"
                                    {{ isset($edukasi->edukasiPasien) && $edukasi->edukasiPasien->kemampuan_baca_tulis == 'tidak_mampu'
                                        ? 'selected'
                                        : '' }}>
                                    Tidak mampu</option>
                            </select>
                        </div>
                    </div>

                    <!-- 4. Tipe Pembelajaran -->
                    <div class="section-separator" id="tipe-pembelajaran">
                        <h5 class="section-title">4. Tipe Pembelajaran</h5>
                        <div class="form-group">
                            <label style="min-width: 200px;">Tipe Pembelajaran</label>
                            <div>
                                <?php
                                $tipe_pembelajaran = [];
                                if (isset($edukasi->edukasiPasien) && $edukasi->edukasiPasien->tipe_pembelajaran) {
                                    $decoded = json_decode($edukasi->edukasiPasien->tipe_pembelajaran, true);
                                    $tipe_pembelajaran = is_array($decoded) ? $decoded : [$decoded];
                                }
                                ?>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input tipe-pembelajaran" id="tipe_verbal"
                                        name="tipe_pembelajaran[]" value="verbal"
                                        {{ in_array('verbal', old('tipe_pembelajaran', $tipe_pembelajaran)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tipe_verbal">Verbal</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input tipe-pembelajaran" id="tipe_tulisan"
                                        name="tipe_pembelajaran[]" value="tulisan"
                                        {{ in_array('tulisan', old('tipe_pembelajaran', $tipe_pembelajaran)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tipe_tulisan">Tulisan</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Hambatan Komunikasi -->
                    <div class="section-separator" id="hambatan-komunikasi">
                        <h5 class="section-title">5. Hambatan Komunikasi</h5>
                        <div class="form-group">
                            <label style="min-width: 200px;">Hambatan Komunikasi</label>
                            <div>
                                <?php
                                $hambatan_komunikasi = [];
                                if (isset($edukasi->edukasiPasien) && $edukasi->edukasiPasien->hambatan_komunikasi) {
                                    $decoded = json_decode($edukasi->edukasiPasien->hambatan_komunikasi, true);
                                    $hambatan_komunikasi = is_array($decoded) ? $decoded : [$decoded];
                                }
                                ?>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input hambatan-komunikasi"
                                        id="hambatan_tidak_ada" name="hambatan_komunikasi[]" value="tidak_ada"
                                        {{ in_array('tidak_ada', old('hambatan_komunikasi', $hambatan_komunikasi)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="hambatan_tidak_ada">Tidak ada</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input hambatan-komunikasi"
                                        id="hambatan_penglihatan" name="hambatan_komunikasi[]" value="penglihatan"
                                        {{ in_array('penglihatan', old('hambatan_komunikasi', $hambatan_komunikasi)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="hambatan_penglihatan">Penglihatan
                                        terganggu</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input hambatan-komunikasi" id="hambatan_bahasa"
                                        name="hambatan_komunikasi[]" value="bahasa"
                                        {{ in_array('bahasa', old('hambatan_komunikasi', $hambatan_komunikasi)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="hambatan_bahasa">Bahasa</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input hambatan-komunikasi"
                                        id="hambatan_kognitif" name="hambatan_komunikasi[]" value="kognitif"
                                        {{ in_array('kognitif', old('hambatan_komunikasi', $hambatan_komunikasi)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="hambatan_kognitif">Kognitif</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input hambatan-komunikasi"
                                        id="hambatan_motivasi" name="hambatan_komunikasi[]" value="motivasi"
                                        {{ in_array('motivasi', old('hambatan_komunikasi', $hambatan_komunikasi)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="hambatan_motivasi">Kurang
                                        motivasi</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Kebutuhan Edukasi (Menggunakan Kartu Vertikal) -->
                    <div class="section-separator" id="kebutuhan-edukasi-table">
                        <h5 class="section-title">Kebutuhan Edukasi</h5>
                        <div class="edukasi-cards">
                            <!-- 1. Kondisi medis, diagnosis, rencana perawatan dan terapi yang diberikan -->
                            <div class="card edukasi-card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title">1. Kondisi medis, diagnosis, rencana perawatan dan
                                        terapi yang diberikan</h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Keterangan</label>
                                        <input type="text" class="form-control" name="ket_Kondisi_medis_1"
                                            value="{{ getEditExistingValue($edukasi->kebutuhanEdukasi, 'ket_kondisi_medis_1') }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_1"
                                            value="{{ getEditExistingValue($edukasi->kebutuhanEdukasi, 'tanggal_1') }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sasaran</label>
                                        <input type="text" class="form-control" name="sasaran_nama_1"
                                            value="{{ getEditExistingValue($edukasi->kebutuhanEdukasi, 'sasaran_nama_1') }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Edukator</label>
                                        <input type="text" class="form-control" name="edukator_nama_1"
                                            value="{{ getEditExistingValue($edukasi->kebutuhanEdukasi, 'edukator_nama_1') }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pemahaman Awal</label>
                                        @php
                                            $pemahaman_awal_1 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->pemahaman_awal_1
                                                    ? json_decode($edukasi->kebutuhanEdukasi->pemahaman_awal_1)
                                                    : [];
                                            if (!is_array($pemahaman_awal_1)) {
                                                $pemahaman_awal_1 = [$pemahaman_awal_1];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_1_hal_baru" name="pemahaman_awal_1[]"
                                                    value="hal_baru"
                                                    {{ in_array('hal_baru', $pemahaman_awal_1) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pemahaman_awal_1_hal_baru">Hal
                                                    Baru</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_1_edukasi_ulang" name="pemahaman_awal_1[]"
                                                    value="edukasi_ulang"
                                                    {{ in_array('edukasi_ulang', $pemahaman_awal_1) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="pemahaman_awal_1_edukasi_ulang">Edukasi Ulang</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Metode</label>
                                        @php
                                            $metode_1 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->metode_1
                                                    ? json_decode($edukasi->kebutuhanEdukasi->metode_1)
                                                    : [];
                                            if (!is_array($metode_1)) {
                                                $metode_1 = [$metode_1];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_1_lisan"
                                                    name="metode_1[]" value="lisan"
                                                    {{ in_array('lisan', $metode_1) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="metode_1_lisan">Lisan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_1_demonstrasi"
                                                    name="metode_1[]" value="demonstrasi"
                                                    {{ in_array('demonstrasi', $metode_1) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="metode_1_demonstrasi">Demonstrasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media</label>
                                        @php
                                            $media_1 =
                                                isset($edukasi->kebutuhanEdukasi) && $edukasi->kebutuhanEdukasi->media_1
                                                    ? json_decode($edukasi->kebutuhanEdukasi->media_1)
                                                    : [];
                                            if (!is_array($media_1)) {
                                                $media_1 = [$media_1];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_1_leaflet"
                                                    name="media_1[]" value="leaflet"
                                                    {{ in_array('leaflet', $media_1) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_1_leaflet">Leaflet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_1_booklet"
                                                    name="media_1[]" value="booklet"
                                                    {{ in_array('booklet', $media_1) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_1_booklet">Booklet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_1_audiovisual"
                                                    name="media_1[]" value="audiovisual"
                                                    {{ in_array('audiovisual', $media_1) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="media_1_audiovisual">Audiovisual</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Evaluasi/Edukasi Ulang</label>
                                        @php
                                            $evaluasi_1 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->evaluasi_1
                                                    ? json_decode($edukasi->kebutuhanEdukasi->evaluasi_1)
                                                    : [];
                                            if (!is_array($evaluasi_1)) {
                                                $evaluasi_1 = [$evaluasi_1];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_1_sudah_paham" name="evaluasi_1[]" value="sudah_paham"
                                                    {{ in_array('sudah_paham', $evaluasi_1) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="evaluasi_1_sudah_paham">Sudah
                                                    Paham</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_1_re_demonstrasi" name="evaluasi_1[]"
                                                    value="re_demonstrasi"
                                                    {{ in_array('re_demonstrasi', $evaluasi_1) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_1_re_demonstrasi">Re-demonstrasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_1_re_edukasi" name="evaluasi_1[]" value="re_edukasi"
                                                    {{ in_array('re_edukasi', $evaluasi_1) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_1_re_edukasi">Re-edukasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lama Edukasi</label>
                                        <input type="text" class="form-control" name="lama_edukasi_1"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->lama_edukasi_1 : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Kemungkinan hasil yang tidak dapat diantisipasi dari terapi dan perawatan -->
                            <div class="card edukasi-card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title">2. Kemungkinan hasil yang tidak dapat diantisipasi
                                        dari terapi dan perawatan</h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_2"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->tanggal_2 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sasaran</label>
                                        <input type="text" class="form-control" name="sasaran_nama_2"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->sasaran_nama_2 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Edukator</label>
                                        <input type="text" class="form-control" name="edukator_nama_2"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->edukator_nama_2 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pemahaman Awal</label>
                                        @php
                                            $pemahaman_awal_2 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->pemahaman_awal_2
                                                    ? json_decode($edukasi->kebutuhanEdukasi->pemahaman_awal_2)
                                                    : [];
                                            if (!is_array($pemahaman_awal_2)) {
                                                $pemahaman_awal_2 = [$pemahaman_awal_2];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_2_hal_baru" name="pemahaman_awal_2[]"
                                                    value="hal_baru"
                                                    {{ in_array('hal_baru', $pemahaman_awal_2) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pemahaman_awal_2_hal_baru">Hal
                                                    Baru</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_2_edukasi_ulang" name="pemahaman_awal_2[]"
                                                    value="edukasi_ulang"
                                                    {{ in_array('edukasi_ulang', $pemahaman_awal_2) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="pemahaman_awal_2_edukasi_ulang">Edukasi Ulang</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Metode</label>
                                        @php
                                            $metode_2 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->metode_2
                                                    ? json_decode($edukasi->kebutuhanEdukasi->metode_2)
                                                    : [];
                                            if (!is_array($metode_2)) {
                                                $metode_2 = [$metode_2];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_2_lisan"
                                                    name="metode_2[]" value="lisan"
                                                    {{ in_array('lisan', $metode_2) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="metode_2_lisan">Lisan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_2_demonstrasi"
                                                    name="metode_2[]" value="demonstrasi"
                                                    {{ in_array('demonstrasi', $metode_2) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="metode_2_demonstrasi">Demonstrasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media</label>
                                        @php
                                            $media_2 =
                                                isset($edukasi->kebutuhanEdukasi) && $edukasi->kebutuhanEdukasi->media_2
                                                    ? json_decode($edukasi->kebutuhanEdukasi->media_2)
                                                    : [];
                                            if (!is_array($media_2)) {
                                                $media_2 = [$media_2];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_2_leaflet"
                                                    name="media_2[]" value="leaflet"
                                                    {{ in_array('leaflet', $media_2) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_2_leaflet">Leaflet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_2_booklet"
                                                    name="media_2[]" value="booklet"
                                                    {{ in_array('booklet', $media_2) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_2_booklet">Booklet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_2_audiovisual"
                                                    name="media_2[]" value="audiovisual"
                                                    {{ in_array('audiovisual', $media_2) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="media_2_audiovisual">Audiovisual</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Evaluasi/Edukasi Ulang</label>
                                        @php
                                            $evaluasi_2 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->evaluasi_2
                                                    ? json_decode($edukasi->kebutuhanEdukasi->evaluasi_2)
                                                    : [];
                                            if (!is_array($evaluasi_2)) {
                                                $evaluasi_2 = [$evaluasi_2];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_2_sudah_paham" name="evaluasi_2[]" value="sudah_paham"
                                                    {{ in_array('sudah_paham', $evaluasi_2) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="evaluasi_2_sudah_paham">Sudah
                                                    Paham</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_2_re_demonstrasi" name="evaluasi_2[]"
                                                    value="re_demonstrasi"
                                                    {{ in_array('re_demonstrasi', $evaluasi_2) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_2_re_demonstrasi">Re-demonstrasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_2_re_edukasi" name="evaluasi_2[]" value="re_edukasi"
                                                    {{ in_array('re_edukasi', $evaluasi_2) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_2_re_edukasi">Re-edukasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lama Edukasi</label>
                                        <input type="text" class="form-control" name="lama_edukasi_2"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->lama_edukasi_2 : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Manfaat obat-obatan, efek samping, serta interaksi obat dan makanan yang diberikan -->
                            <div class="card edukasi-card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title">3. Manfaat obat-obatan, efek samping, serta interaksi
                                        obat dan makanan yang diberikan</h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_3"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->tanggal_3 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sasaran</label>
                                        <input type="text" class="form-control" name="sasaran_nama_3"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->sasaran_nama_3 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Edukator</label>
                                        <input type="text" class="form-control" name="edukator_nama_3"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->edukator_nama_3 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pemahaman Awal</label>
                                        @php
                                            $pemahaman_awal_3 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->pemahaman_awal_3
                                                    ? json_decode($edukasi->kebutuhanEdukasi->pemahaman_awal_3)
                                                    : [];
                                            if (!is_array($pemahaman_awal_3)) {
                                                $pemahaman_awal_3 = [$pemahaman_awal_3];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_3_hal_baru" name="pemahaman_awal_3[]"
                                                    value="hal_baru"
                                                    {{ in_array('hal_baru', $pemahaman_awal_3) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pemahaman_awal_3_hal_baru">Hal
                                                    Baru</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_3_edukasi_ulang" name="pemahaman_awal_3[]"
                                                    value="edukasi_ulang"
                                                    {{ in_array('edukasi_ulang', $pemahaman_awal_3) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="pemahaman_awal_3_edukasi_ulang">Edukasi Ulang</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Metode</label>
                                        @php
                                            $metode_3 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->metode_3
                                                    ? json_decode($edukasi->kebutuhanEdukasi->metode_3)
                                                    : [];
                                            if (!is_array($metode_3)) {
                                                $metode_3 = [$metode_3];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_3_lisan"
                                                    name="metode_3[]" value="lisan"
                                                    {{ in_array('lisan', $metode_3) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="metode_3_lisan">Lisan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_3_demonstrasi"
                                                    name="metode_3[]" value="demonstrasi"
                                                    {{ in_array('demonstrasi', $metode_3) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="metode_3_demonstrasi">Demonstrasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media</label>
                                        @php
                                            $media_3 =
                                                isset($edukasi->kebutuhanEdukasi) && $edukasi->kebutuhanEdukasi->media_3
                                                    ? json_decode($edukasi->kebutuhanEdukasi->media_3)
                                                    : [];
                                            if (!is_array($media_3)) {
                                                $media_3 = [$media_3];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_3_leaflet"
                                                    name="media_3[]" value="leaflet"
                                                    {{ in_array('leaflet', $media_3) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_3_leaflet">Leaflet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_3_booklet"
                                                    name="media_3[]" value="booklet"
                                                    {{ in_array('booklet', $media_3) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_3_booklet">Booklet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_3_audiovisual"
                                                    name="media_3[]" value="audiovisual"
                                                    {{ in_array('audiovisual', $media_3) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="media_3_audiovisual">Audiovisual</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Evaluasi/Edukasi Ulang</label>
                                        @php
                                            $evaluasi_3 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->evaluasi_3
                                                    ? json_decode($edukasi->kebutuhanEdukasi->evaluasi_3)
                                                    : [];
                                            if (!is_array($evaluasi_3)) {
                                                $evaluasi_3 = [$evaluasi_3];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_3_sudah_paham" name="evaluasi_3[]" value="sudah_paham"
                                                    {{ in_array('sudah_paham', $evaluasi_3) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="evaluasi_3_sudah_paham">Sudah
                                                    Paham</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_3_re_demonstrasi" name="evaluasi_3[]"
                                                    value="re_demonstrasi"
                                                    {{ in_array('re_demonstrasi', $evaluasi_3) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_3_re_demonstrasi">Re-demonstrasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_3_re_edukasi" name="evaluasi_3[]" value="re_edukasi"
                                                    {{ in_array('re_edukasi', $evaluasi_3) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_3_re_edukasi">Re-edukasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lama Edukasi</label>
                                        <input type="text" class="form-control" name="lama_edukasi_3"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->lama_edukasi_3 : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Program diet dan nutrisi sebutkan... -->
                            <div class="card edukasi-card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title">4. Program diet dan nutrisi sebutkan...</h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Keterangan</label>
                                        <input type="text" class="form-control" name="ket_program_4"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->ket_program_4 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_4"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->tanggal_4 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sasaran</label>
                                        <input type="text" class="form-control" name="sasaran_nama_4"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->sasaran_nama_4 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Edukator</label>
                                        <input type="text" class="form-control" name="edukator_nama_4"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->edukator_nama_4 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pemahaman Awal</label>
                                        @php
                                            $pemahaman_awal_4 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->pemahaman_awal_4
                                                    ? json_decode($edukasi->kebutuhanEdukasi->pemahaman_awal_4)
                                                    : [];
                                            if (!is_array($pemahaman_awal_4)) {
                                                $pemahaman_awal_4 = [$pemahaman_awal_4];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_4_hal_baru" name="pemahaman_awal_4[]"
                                                    value="hal_baru"
                                                    {{ in_array('hal_baru', $pemahaman_awal_4) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pemahaman_awal_4_hal_baru">Hal
                                                    Baru</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_4_edukasi_ulang" name="pemahaman_awal_4[]"
                                                    value="edukasi_ulang"
                                                    {{ in_array('edukasi_ulang', $pemahaman_awal_4) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="pemahaman_awal_4_edukasi_ulang">Edukasi Ulang</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Metode</label>
                                        @php
                                            $metode_4 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->metode_4
                                                    ? json_decode($edukasi->kebutuhanEdukasi->metode_4)
                                                    : [];
                                            if (!is_array($metode_4)) {
                                                $metode_4 = [$metode_4];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_4_lisan"
                                                    name="metode_4[]" value="lisan"
                                                    {{ in_array('lisan', $metode_4) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="metode_4_lisan">Lisan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_4_demonstrasi"
                                                    name="metode_4[]" value="demonstrasi"
                                                    {{ in_array('demonstrasi', $metode_4) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="metode_4_demonstrasi">Demonstrasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media</label>
                                        @php
                                            $media_4 =
                                                isset($edukasi->kebutuhanEdukasi) && $edukasi->kebutuhanEdukasi->media_4
                                                    ? json_decode($edukasi->kebutuhanEdukasi->media_4)
                                                    : [];
                                            if (!is_array($media_4)) {
                                                $media_4 = [$media_4];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_4_leaflet"
                                                    name="media_4[]" value="leaflet"
                                                    {{ in_array('leaflet', $media_4) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_4_leaflet">Leaflet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_4_booklet"
                                                    name="media_4[]" value="booklet"
                                                    {{ in_array('booklet', $media_4) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_4_booklet">Booklet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_4_audiovisual"
                                                    name="media_4[]" value="audiovisual"
                                                    {{ in_array('audiovisual', $media_4) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="media_4_audiovisual">Audiovisual</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Evaluasi/Edukasi Ulang</label>
                                        @php
                                            $evaluasi_4 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->evaluasi_4
                                                    ? json_decode($edukasi->kebutuhanEdukasi->evaluasi_4)
                                                    : [];
                                            if (!is_array($evaluasi_4)) {
                                                $evaluasi_4 = [$evaluasi_4];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_4_sudah_paham" name="evaluasi_4[]" value="sudah_paham"
                                                    {{ in_array('sudah_paham', $evaluasi_4) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="evaluasi_4_sudah_paham">Sudah
                                                    Paham</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_4_re_demonstrasi" name="evaluasi_4[]"
                                                    value="re_demonstrasi"
                                                    {{ in_array('re_demonstrasi', $evaluasi_4) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_4_re_demonstrasi">Re-demonstrasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_4_re_edukasi" name="evaluasi_4[]" value="re_edukasi"
                                                    {{ in_array('re_edukasi', $evaluasi_4) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_4_re_edukasi">Re-edukasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lama Edukasi</label>
                                        <input type="text" class="form-control" name="lama_edukasi_4"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->lama_edukasi_4 : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- 5. Manajemen Nyeri kemungkinan timbulnya nyeri setelah menerima terapi/prosedur/perawatan medis/Pilihan tatalaksana Nyeri -->
                            <div class="card edukasi-card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title">5. Manajemen Nyeri kemungkinan timbulnya nyeri
                                        setelah menerima terapi/prosedur/perawatan medis/Pilihan tatalaksana
                                        Nyeri</h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_5"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->tanggal_5 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sasaran</label>
                                        <input type="text" class="form-control" name="sasaran_nama_5"
                                            value="{{ getEditExistingValue($edukasi->kebutuhanEdukasi, 'sasaran_nama_5') }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Edukator</label>
                                        <input type="text" class="form-control" name="edukator_nama_5"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->edukator_nama_5 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pemahaman Awal</label>
                                        @php
                                            $pemahaman_awal_5 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->pemahaman_awal_5
                                                    ? json_decode($edukasi->kebutuhanEdukasi->pemahaman_awal_5)
                                                    : [];
                                            if (!is_array($pemahaman_awal_5)) {
                                                $pemahaman_awal_5 = [$pemahaman_awal_5];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_5_hal_baru" name="pemahaman_awal_5[]"
                                                    value="hal_baru"
                                                    {{ in_array('hal_baru', $pemahaman_awal_5) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pemahaman_awal_5_hal_baru">Hal
                                                    Baru</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_5_edukasi_ulang" name="pemahaman_awal_5[]"
                                                    value="edukasi_ulang"
                                                    {{ in_array('edukasi_ulang', $pemahaman_awal_5) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="pemahaman_awal_5_edukasi_ulang">Edukasi Ulang</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Metode</label>
                                        @php
                                            $metode_5 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->metode_5
                                                    ? json_decode($edukasi->kebutuhanEdukasi->metode_5)
                                                    : [];
                                            if (!is_array($metode_5)) {
                                                $metode_5 = [$metode_5];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_5_lisan"
                                                    name="metode_5[]" value="lisan"
                                                    {{ in_array('lisan', $metode_5) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="metode_5_lisan">Lisan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_5_demonstrasi"
                                                    name="metode_5[]" value="demonstrasi"
                                                    {{ in_array('demonstrasi', $metode_5) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="metode_5_demonstrasi">Demonstrasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media</label>
                                        @php
                                            $media_5 =
                                                isset($edukasi->kebutuhanEdukasi) && $edukasi->kebutuhanEdukasi->media_5
                                                    ? json_decode($edukasi->kebutuhanEdukasi->media_5)
                                                    : [];
                                            if (!is_array($media_5)) {
                                                $media_5 = [$media_5];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_5_leaflet"
                                                    name="media_5[]" value="leaflet"
                                                    {{ in_array('leaflet', $media_5) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_5_leaflet">Leaflet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_5_booklet"
                                                    name="media_5[]" value="booklet"
                                                    {{ in_array('booklet', $media_5) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_5_booklet">Booklet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_5_audiovisual"
                                                    name="media_5[]" value="audiovisual"
                                                    {{ in_array('audiovisual', $media_5) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="media_5_audiovisual">Audiovisual</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Evaluasi/Edukasi Ulang</label>
                                        @php
                                            $evaluasi_5 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->evaluasi_5
                                                    ? json_decode($edukasi->kebutuhanEdukasi->evaluasi_5)
                                                    : [];
                                            if (!is_array($evaluasi_5)) {
                                                $evaluasi_5 = [$evaluasi_5];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_5_sudah_paham" name="evaluasi_5[]" value="sudah_paham"
                                                    {{ in_array('sudah_paham', $evaluasi_5) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="evaluasi_5_sudah_paham">Sudah
                                                    Paham</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_5_re_demonstrasi" name="evaluasi_5[]"
                                                    value="re_demonstrasi"
                                                    {{ in_array('re_demonstrasi', $evaluasi_5) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_5_re_demonstrasi">Re-demonstrasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_5_re_edukasi" name="evaluasi_5[]" value="re_edukasi"
                                                    {{ in_array('re_edukasi', $evaluasi_5) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_5_re_edukasi">Re-edukasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lama Edukasi</label>
                                        <input type="text" class="form-control" name="lama_edukasi_5"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->lama_edukasi_5 : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- 6. Cuci tangan (Hand Hygiene) -->
                            <div class="card edukasi-card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title">6. Cuci tangan (Hand Hygiene)</h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_6"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->tanggal_6 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sasaran</label>
                                        <input type="text" class="form-control" name="sasaran_nama_6"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->sasaran_nama_6 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Edukator</label>
                                        <input type="text" class="form-control" name="edukator_nama_6"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->edukator_nama_6 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pemahaman Awal</label>
                                        @php
                                            $pemahaman_awal_6 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->pemahaman_awal_6
                                                    ? json_decode($edukasi->kebutuhanEdukasi->pemahaman_awal_6)
                                                    : [];
                                            if (!is_array($pemahaman_awal_6)) {
                                                $pemahaman_awal_6 = [$pemahaman_awal_6];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_6_hal_baru" name="pemahaman_awal_6[]"
                                                    value="hal_baru"
                                                    {{ in_array('hal_baru', $pemahaman_awal_6) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pemahaman_awal_6_hal_baru">Hal
                                                    Baru</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_6_edukasi_ulang" name="pemahaman_awal_6[]"
                                                    value="edukasi_ulang"
                                                    {{ in_array('edukasi_ulang', $pemahaman_awal_6) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="pemahaman_awal_6_edukasi_ulang">Edukasi Ulang</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Metode</label>
                                        @php
                                            $metode_6 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->metode_6
                                                    ? json_decode($edukasi->kebutuhanEdukasi->metode_6)
                                                    : [];
                                            if (!is_array($metode_6)) {
                                                $metode_6 = [$metode_6];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_6_lisan"
                                                    name="metode_6[]" value="lisan"
                                                    {{ in_array('lisan', $metode_6) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="metode_6_lisan">Lisan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_6_demonstrasi"
                                                    name="metode_6[]" value="demonstrasi"
                                                    {{ in_array('demonstrasi', $metode_6) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="metode_6_demonstrasi">Demonstrasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media</label>
                                        @php
                                            $media_6 =
                                                isset($edukasi->kebutuhanEdukasi) && $edukasi->kebutuhanEdukasi->media_6
                                                    ? json_decode($edukasi->kebutuhanEdukasi->media_6)
                                                    : [];
                                            if (!is_array($media_6)) {
                                                $media_6 = [$media_6];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_6_leaflet"
                                                    name="media_6[]" value="leaflet"
                                                    {{ in_array('leaflet', $media_6) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_6_leaflet">Leaflet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_6_booklet"
                                                    name="media_6[]" value="booklet"
                                                    {{ in_array('booklet', $media_6) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_6_booklet">Booklet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_6_audiovisual"
                                                    name="media_6[]" value="audiovisual"
                                                    {{ in_array('audiovisual', $media_6) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="media_6_audiovisual">Audiovisual</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Evaluasi/Edukasi Ulang</label>
                                        @php
                                            $evaluasi_6 =
                                                isset($edukasi->kebutuhanEdukasi) &&
                                                $edukasi->kebutuhanEdukasi->evaluasi_6
                                                    ? json_decode($edukasi->kebutuhanEdukasi->evaluasi_6)
                                                    : [];
                                            if (!is_array($evaluasi_6)) {
                                                $evaluasi_6 = [$evaluasi_6];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_6_sudah_paham" name="evaluasi_6[]" value="sudah_paham"
                                                    {{ in_array('sudah_paham', $evaluasi_6) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="evaluasi_6_sudah_paham">Sudah
                                                    Paham</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_6_re_demonstrasi" name="evaluasi_6[]"
                                                    value="re_demonstrasi"
                                                    {{ in_array('re_demonstrasi', $evaluasi_6) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_6_re_demonstrasi">Re-demonstrasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_6_re_edukasi" name="evaluasi_6[]" value="re_edukasi"
                                                    {{ in_array('re_edukasi', $evaluasi_6) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_6_re_edukasi">Re-edukasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lama Edukasi</label>
                                        <input type="text" class="form-control" name="lama_edukasi_6"
                                            value="{{ isset($edukasi->kebutuhanEdukasi) ? $edukasi->kebutuhanEdukasi->lama_edukasi_6 : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- 7. Waktu kontrol dan penggunaan obat-obatan di rumah -->
                            <div class="card edukasi-card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title">7. Waktu kontrol dan penggunaan obat-obatan di rumah
                                    </h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_7"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->tanggal_7 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sasaran</label>
                                        <input type="text" class="form-control" name="sasaran_nama_7"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->sasaran_nama_7 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Edukator</label>
                                        <input type="text" class="form-control" name="edukator_nama_7"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->edukator_nama_7 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pemahaman Awal</label>
                                        @php
                                            $pemahaman_awal_7 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_7
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_7)
                                                    : [];
                                            if (!is_array($pemahaman_awal_7)) {
                                                $pemahaman_awal_7 = [$pemahaman_awal_7];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_7_hal_baru" name="pemahaman_awal_7[]"
                                                    value="hal_baru"
                                                    {{ in_array('hal_baru', $pemahaman_awal_7) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pemahaman_awal_7_hal_baru">Hal
                                                    Baru</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_7_edukasi_ulang" name="pemahaman_awal_7[]"
                                                    value="edukasi_ulang"
                                                    {{ in_array('edukasi_ulang', $pemahaman_awal_7) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="pemahaman_awal_7_edukasi_ulang">Edukasi Ulang</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Metode</label>
                                        @php
                                            $metode_7 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->metode_7
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->metode_7)
                                                    : [];
                                            if (!is_array($metode_7)) {
                                                $metode_7 = [$metode_7];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_7_lisan"
                                                    name="metode_7[]" value="lisan"
                                                    {{ in_array('lisan', $metode_7) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="metode_7_lisan">Lisan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_7_demonstrasi"
                                                    name="metode_7[]" value="demonstrasi"
                                                    {{ in_array('demonstrasi', $metode_7) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="metode_7_demonstrasi">Demonstrasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media</label>
                                        @php
                                            $media_7 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->media_7
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->media_7)
                                                    : [];
                                            if (!is_array($media_7)) {
                                                $media_7 = [$media_7];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_7_leaflet"
                                                    name="media_7[]" value="leaflet"
                                                    {{ in_array('leaflet', $media_7) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_7_leaflet">Leaflet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_7_booklet"
                                                    name="media_7[]" value="booklet"
                                                    {{ in_array('booklet', $media_7) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_7_booklet">Booklet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_7_audiovisual"
                                                    name="media_7[]" value="audiovisual"
                                                    {{ in_array('audiovisual', $media_7) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="media_7_audiovisual">Audiovisual</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Evaluasi/Edukasi Ulang</label>
                                        @php
                                            $evaluasi_7 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->evaluasi_7
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->evaluasi_7)
                                                    : [];
                                            if (!is_array($evaluasi_7)) {
                                                $evaluasi_7 = [$evaluasi_7];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_7_sudah_paham" name="evaluasi_7[]" value="sudah_paham"
                                                    {{ in_array('sudah_paham', $evaluasi_7) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="evaluasi_7_sudah_paham">Sudah
                                                    Paham</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_7_re_demonstrasi" name="evaluasi_7[]"
                                                    value="re_demonstrasi"
                                                    {{ in_array('re_demonstrasi', $evaluasi_7) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_7_re_demonstrasi">Re-demonstrasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_7_re_edukasi" name="evaluasi_7[]" value="re_edukasi"
                                                    {{ in_array('re_edukasi', $evaluasi_7) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_7_re_edukasi">Re-edukasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lama Edukasi</label>
                                        <input type="text" class="form-control" name="lama_edukasi_7"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->lama_edukasi_7 : '' }}">
                                    </div>
                                </div>
                            </div>

                            {{-- <!-- 8. Waktu kontrol dan penggunaan obat-obatan di rumah -->
                                    <div class="card edukasi-card mb-4">
                                        <div class="card-body">
                                            <h6 class="card-title">8. Waktu kontrol dan penggunaan obat-obatan di rumah
                                            </h6>
                                            <div class="form-group">
                                                <label style="min-width: 200px;">Tanggal</label>
                                                <input type="date" class="form-control" name="tanggal_8"
                                                    value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->tanggal_8 : '' }}">
                                            </div>
                                            <div class="form-group">
                                                <label style="min-width: 200px;">Sasaran</label>
                                                <input type="text" class="form-control" name="sasaran_nama_8"
                                                    value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->sasaran_nama_8 : '' }}">
                                            </div>
                                            <div class="form-group">
                                                <label style="min-width: 200px;">Edukator</label>
                                                <input type="text" class="form-control" name="edukator_nama_8"
                                                    value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->edukator_nama_8 : '' }}">
                                            </div>
                                            <div class="form-group">
                                                <label style="min-width: 200px;">Tingkat Pemahaman Awal</label>
                                                @php
                                                $pemahaman_awal_8 = isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_8 ?
                                                json_decode($edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_8) : [];
                                                if (!is_array($pemahaman_awal_8)) {
                                                $pemahaman_awal_8 = [$pemahaman_awal_8];
                                                }
                                                @endphp
                                                <div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_8_hal_baru" name="pemahaman_awal_8[]"
                                                            value="hal_baru" {{ in_array('hal_baru', $pemahaman_awal_8)
                                                            ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="pemahaman_awal_8_hal_baru">Hal Baru</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_8_edukasi_ulang"
                                                            name="pemahaman_awal_8[]" value="edukasi_ulang" {{
                                                            in_array('edukasi_ulang', $pemahaman_awal_8) ? 'checked'
                                                            : '' }}>
                                                        <label class="form-check-label"
                                                            for="pemahaman_awal_8_edukasi_ulang">Edukasi Ulang</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label style="min-width: 200px;">Metode</label>
                                                @php
                                                $metode_8 = isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->metode_8 ?
                                                json_decode($edukasi->kebutuhanEdukasiLanjutan->metode_8) : [];
                                                if (!is_array($metode_8)) {
                                                $metode_8 = [$metode_8];
                                                }
                                                @endphp
                                                <div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_8_lisan" name="metode_8[]" value="lisan" {{
                                                            in_array('lisan', $metode_8) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="metode_8_lisan">Lisan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_8_demonstrasi" name="metode_8[]"
                                                            value="demonstrasi" {{ in_array('demonstrasi', $metode_8)
                                                            ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="metode_8_demonstrasi">Demonstrasi</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label style="min-width: 200px;">Media</label>
                                                @php
                                                $media_8 = isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->media_8 ?
                                                json_decode($edukasi->kebutuhanEdukasiLanjutan->media_8) : [];
                                                if (!is_array($media_8)) {
                                                $media_8 = [$media_8];
                                                }
                                                @endphp
                                                <div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_8_leaflet" name="media_8[]" value="leaflet" {{
                                                            in_array('leaflet', $media_8) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_8_leaflet">Leaflet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_8_booklet" name="media_8[]" value="booklet" {{
                                                            in_array('booklet', $media_8) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_8_booklet">Booklet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_8_audiovisual" name="media_8[]"
                                                            value="audiovisual" {{ in_array('audiovisual', $media_8)
                                                            ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_8_audiovisual">Audiovisual</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label style="min-width: 200px;">Evaluasi/Edukasi Ulang</label>
                                                @php
                                                $evaluasi_8 = isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->evaluasi_8 ?
                                                json_decode($edukasi->kebutuhanEdukasiLanjutan->evaluasi_8) : [];
                                                if (!is_array($evaluasi_8)) {
                                                $evaluasi_8 = [$evaluasi_8];
                                                }
                                                @endphp
                                                <div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_8_sudah_paham" name="evaluasi_8[]"
                                                            value="sudah_paham" {{ in_array('sudah_paham', $evaluasi_8)
                                                            ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_8_sudah_paham">Sudah Paham</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_8_re_demonstrasi" name="evaluasi_8[]"
                                                            value="re_demonstrasi" {{ in_array('re_demonstrasi',
                                                            $evaluasi_8) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_8_re_demonstrasi">Re-demonstrasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_8_re_edukasi" name="evaluasi_8[]"
                                                            value="re_edukasi" {{ in_array('re_edukasi', $evaluasi_8)
                                                            ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_8_re_edukasi">Re-edukasi</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label style="min-width: 200px;">Lama Edukasi</label>
                                                <input type="text" class="form-control" name="lama_edukasi_8"
                                                    value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->lama_edukasi_8 : '' }}">
                                            </div>
                                        </div>
                                    </div> --}}

                            <!-- 9. Teknik Rehabilitasi -->
                            <div class="card edukasi-card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title">9. Teknik Rehabilitasi</h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Keterangan</label>
                                        <input type="text" class="form-control" name="ket_teknik_rehabilitasi_9"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->ket_teknik_rehabilitasi_9 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_9"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->tanggal_9 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Detail Teknik Rehabilitasi</label>
                                        <input type="text" class="form-control" name="teknik_rehabilitasi_9"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->teknik_rehabilitasi_9 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sasaran</label>
                                        <input type="text" class="form-control" name="sasaran_nama_9"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->sasaran_nama_9 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Edukator</label>
                                        <input type="text" class="form-control" name="edukator_nama_9"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->edukator_nama_9 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pemahaman Awal</label>
                                        @php
                                            $pemahaman_awal_9 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_9
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_9)
                                                    : [];
                                            if (!is_array($pemahaman_awal_9)) {
                                                $pemahaman_awal_9 = [$pemahaman_awal_9];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_9_hal_baru" name="pemahaman_awal_9[]"
                                                    value="hal_baru"
                                                    {{ in_array('hal_baru', $pemahaman_awal_9) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pemahaman_awal_9_hal_baru">Hal
                                                    Baru</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_9_edukasi_ulang" name="pemahaman_awal_9[]"
                                                    value="edukasi_ulang"
                                                    {{ in_array('edukasi_ulang', $pemahaman_awal_9) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="pemahaman_awal_9_edukasi_ulang">Edukasi Ulang</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Metode</label>
                                        @php
                                            $metode_9 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->metode_9
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->metode_9)
                                                    : [];
                                            if (!is_array($metode_9)) {
                                                $metode_9 = [$metode_9];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_9_lisan"
                                                    name="metode_9[]" value="lisan"
                                                    {{ in_array('lisan', $metode_9) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="metode_9_lisan">Lisan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="metode_9_demonstrasi" name="metode_9[]" value="demonstrasi"
                                                    {{ in_array('demonstrasi', $metode_9) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="metode_9_demonstrasi">Demonstrasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media</label>
                                        @php
                                            $media_9 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->media_9
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->media_9)
                                                    : [];
                                            if (!is_array($media_9)) {
                                                $media_9 = [$media_9];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_9_leaflet"
                                                    name="media_9[]" value="leaflet"
                                                    {{ in_array('leaflet', $media_9) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_9_leaflet">Leaflet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_9_booklet"
                                                    name="media_9[]" value="booklet"
                                                    {{ in_array('booklet', $media_9) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_9_booklet">Booklet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="media_9_audiovisual" name="media_9[]" value="audiovisual"
                                                    {{ in_array('audiovisual', $media_9) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="media_9_audiovisual">Audiovisual</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Evaluasi/Edukasi Ulang</label>
                                        @php
                                            $evaluasi_9 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->evaluasi_9
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->evaluasi_9)
                                                    : [];
                                            if (!is_array($evaluasi_9)) {
                                                $evaluasi_9 = [$evaluasi_9];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_9_sudah_paham" name="evaluasi_9[]"
                                                    value="sudah_paham"
                                                    {{ in_array('sudah_paham', $evaluasi_9) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="evaluasi_9_sudah_paham">Sudah
                                                    Paham</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_9_re_demonstrasi" name="evaluasi_9[]"
                                                    value="re_demonstrasi"
                                                    {{ in_array('re_demonstrasi', $evaluasi_9) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_9_re_demonstrasi">Re-demonstrasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_9_re_edukasi" name="evaluasi_9[]" value="re_edukasi"
                                                    {{ in_array('re_edukasi', $evaluasi_9) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_9_re_edukasi">Re-edukasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lama Edukasi</label>
                                        <input type="text" class="form-control" name="lama_edukasi_9"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->lama_edukasi_9 : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- 10. Penggunaan peralatan medis secara efektif dan aman -->
                            <div class="card edukasi-card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title">10. Penggunaan peralatan medis secara efektif dan
                                        aman</h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_10"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->tanggal_10 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sasaran</label>
                                        <input type="text" class="form-control" name="sasaran_nama_10"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->sasaran_nama_10 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Edukator</label>
                                        <input type="text" class="form-control" name="edukator_nama_10"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->edukator_nama_10 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pemahaman Awal</label>
                                        @php
                                            $pemahaman_awal_10 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_10
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_10)
                                                    : [];
                                            if (!is_array($pemahaman_awal_10)) {
                                                $pemahaman_awal_10 = [$pemahaman_awal_10];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_10_hal_baru" name="pemahaman_awal_10[]"
                                                    value="hal_baru"
                                                    {{ in_array('hal_baru', $pemahaman_awal_10) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pemahaman_awal_10_hal_baru">Hal
                                                    Baru</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_10_edukasi_ulang" name="pemahaman_awal_10[]"
                                                    value="edukasi_ulang"
                                                    {{ in_array('edukasi_ulang', $pemahaman_awal_10) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="pemahaman_awal_10_edukasi_ulang">Edukasi Ulang</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Metode</label>
                                        @php
                                            $metode_10 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->metode_10
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->metode_10)
                                                    : [];
                                            if (!is_array($metode_10)) {
                                                $metode_10 = [$metode_10];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_10_lisan"
                                                    name="metode_10[]" value="lisan"
                                                    {{ in_array('lisan', $metode_10) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="metode_10_lisan">Lisan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="metode_10_demonstrasi" name="metode_10[]" value="demonstrasi"
                                                    {{ in_array('demonstrasi', $metode_10) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="metode_10_demonstrasi">Demonstrasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media</label>
                                        @php
                                            $media_10 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->media_10
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->media_10)
                                                    : [];
                                            if (!is_array($media_10)) {
                                                $media_10 = [$media_10];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_10_leaflet"
                                                    name="media_10[]" value="leaflet"
                                                    {{ in_array('leaflet', $media_10) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_10_leaflet">Leaflet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_10_booklet"
                                                    name="media_10[]" value="booklet"
                                                    {{ in_array('booklet', $media_10) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_10_booklet">Booklet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="media_10_audiovisual" name="media_10[]" value="audiovisual"
                                                    {{ in_array('audiovisual', $media_10) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="media_10_audiovisual">Audiovisual</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Evaluasi/Edukasi Ulang</label>
                                        @php
                                            $evaluasi_10 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->evaluasi_10
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->evaluasi_10)
                                                    : [];
                                            if (!is_array($evaluasi_10)) {
                                                $evaluasi_10 = [$evaluasi_10];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_10_sudah_paham" name="evaluasi_10[]"
                                                    value="sudah_paham"
                                                    {{ in_array('sudah_paham', $evaluasi_10) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="evaluasi_10_sudah_paham">Sudah
                                                    Paham</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_10_re_demonstrasi" name="evaluasi_10[]"
                                                    value="re_demonstrasi"
                                                    {{ in_array('re_demonstrasi', $evaluasi_10) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_10_re_demonstrasi">Re-demonstrasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_10_re_edukasi" name="evaluasi_10[]"
                                                    value="re_edukasi"
                                                    {{ in_array('re_edukasi', $evaluasi_10) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_10_re_edukasi">Re-edukasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lama Edukasi</label>
                                        <input type="text" class="form-control" name="lama_edukasi_10"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->lama_edukasi_10 : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- 11. Jenis Pelayanan -->
                            <div class="card edukasi-card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title">11. Jenis Pelayanan</h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_11"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->tanggal_11 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sasaran</label>
                                        <input type="text" class="form-control" name="sasaran_nama_11"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->sasaran_nama_11 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Edukator</label>
                                        <input type="text" class="form-control" name="edukator_nama_11"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->edukator_nama_11 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pemahaman Awal</label>
                                        @php
                                            $pemahaman_awal_11 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_11
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_11)
                                                    : [];
                                            if (!is_array($pemahaman_awal_11)) {
                                                $pemahaman_awal_11 = [$pemahaman_awal_11];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_11_hal_baru" name="pemahaman_awal_11[]"
                                                    value="hal_baru"
                                                    {{ in_array('hal_baru', $pemahaman_awal_11) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pemahaman_awal_11_hal_baru">Hal
                                                    Baru</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_11_edukasi_ulang" name="pemahaman_awal_11[]"
                                                    value="edukasi_ulang"
                                                    {{ in_array('edukasi_ulang', $pemahaman_awal_11) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="pemahaman_awal_11_edukasi_ulang">Edukasi Ulang</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Metode</label>
                                        @php
                                            $metode_11 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->metode_11
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->metode_11)
                                                    : [];
                                            if (!is_array($metode_11)) {
                                                $metode_11 = [$metode_11];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_11_lisan"
                                                    name="metode_11[]" value="lisan"
                                                    {{ in_array('lisan', $metode_11) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="metode_11_lisan">Lisan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="metode_11_demonstrasi" name="metode_11[]" value="demonstrasi"
                                                    {{ in_array('demonstrasi', $metode_11) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="metode_11_demonstrasi">Demonstrasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media</label>
                                        @php
                                            $media_11 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->media_11
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->media_11)
                                                    : [];
                                            if (!is_array($media_11)) {
                                                $media_11 = [$media_11];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_11_leaflet"
                                                    name="media_11[]" value="leaflet"
                                                    {{ in_array('leaflet', $media_11) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_11_leaflet">Leaflet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_11_booklet"
                                                    name="media_11[]" value="booklet"
                                                    {{ in_array('booklet', $media_11) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_11_booklet">Booklet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="media_11_audiovisual" name="media_11[]" value="audiovisual"
                                                    {{ in_array('audiovisual', $media_11) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="media_11_audiovisual">Audiovisual</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Evaluasi/Edukasi Ulang</label>
                                        @php
                                            $evaluasi_11 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->evaluasi_11
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->evaluasi_11)
                                                    : [];
                                            if (!is_array($evaluasi_11)) {
                                                $evaluasi_11 = [$evaluasi_11];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_11_sudah_paham" name="evaluasi_11[]"
                                                    value="sudah_paham"
                                                    {{ in_array('sudah_paham', $evaluasi_11) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="evaluasi_11_sudah_paham">Sudah
                                                    Paham</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_11_re_demonstrasi" name="evaluasi_11[]"
                                                    value="re_demonstrasi"
                                                    {{ in_array('re_demonstrasi', $evaluasi_11) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_11_re_demonstrasi">Re-demonstrasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_11_re_edukasi" name="evaluasi_11[]"
                                                    value="re_edukasi"
                                                    {{ in_array('re_edukasi', $evaluasi_11) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_11_re_edukasi">Re-edukasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lama Edukasi</label>
                                        <input type="text" class="form-control" name="lama_edukasi_11"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->lama_edukasi_11 : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- 12. Perkiraan Biaya -->
                            <div class="card edukasi-card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title">12. Perkiraan Biaya</h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_12"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->tanggal_12 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sasaran</label>
                                        <input type="text" class="form-control" name="sasaran_nama_12"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->sasaran_nama_12 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Edukator</label>
                                        <input type="text" class="form-control" name="edukator_nama_12"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->edukator_nama_12 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pemahaman Awal</label>
                                        @php
                                            $pemahaman_awal_12 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_12
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_12)
                                                    : [];
                                            if (!is_array($pemahaman_awal_12)) {
                                                $pemahaman_awal_12 = [$pemahaman_awal_12];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_12_hal_baru" name="pemahaman_awal_12[]"
                                                    value="hal_baru"
                                                    {{ in_array('hal_baru', $pemahaman_awal_12) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pemahaman_awal_12_hal_baru">Hal
                                                    Baru</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_12_edukasi_ulang" name="pemahaman_awal_12[]"
                                                    value="edukasi_ulang"
                                                    {{ in_array('edukasi_ulang', $pemahaman_awal_12) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="pemahaman_awal_12_edukasi_ulang">Edukasi Ulang</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Metode</label>
                                        @php
                                            $metode_12 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->metode_12
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->metode_12)
                                                    : [];
                                            if (!is_array($metode_12)) {
                                                $metode_12 = [$metode_12];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_12_lisan"
                                                    name="metode_12[]" value="lisan"
                                                    {{ in_array('lisan', $metode_12) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="metode_12_lisan">Lisan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="metode_12_demonstrasi" name="metode_12[]" value="demonstrasi"
                                                    {{ in_array('demonstrasi', $metode_12) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="metode_12_demonstrasi">Demonstrasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media</label>
                                        @php
                                            $media_12 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->media_12
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->media_12)
                                                    : [];
                                            if (!is_array($media_12)) {
                                                $media_12 = [$media_12];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_12_leaflet"
                                                    name="media_12[]" value="leaflet"
                                                    {{ in_array('leaflet', $media_12) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_12_leaflet">Leaflet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_12_booklet"
                                                    name="media_12[]" value="booklet"
                                                    {{ in_array('booklet', $media_12) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_12_booklet">Booklet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="media_12_audiovisual" name="media_12[]" value="audiovisual"
                                                    {{ in_array('audiovisual', $media_12) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="media_12_audiovisual">Audiovisual</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Evaluasi/Edukasi Ulang</label>
                                        @php
                                            $evaluasi_12 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->evaluasi_12
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->evaluasi_12)
                                                    : [];
                                            if (!is_array($evaluasi_12)) {
                                                $evaluasi_12 = [$evaluasi_12];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_12_sudah_paham" name="evaluasi_12[]"
                                                    value="sudah_paham"
                                                    {{ in_array('sudah_paham', $evaluasi_12) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="evaluasi_12_sudah_paham">Sudah
                                                    Paham</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_12_re_demonstrasi" name="evaluasi_12[]"
                                                    value="re_demonstrasi"
                                                    {{ in_array('re_demonstrasi', $evaluasi_12) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_12_re_demonstrasi">Re-demonstrasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_12_re_edukasi" name="evaluasi_12[]"
                                                    value="re_edukasi"
                                                    {{ in_array('re_edukasi', $evaluasi_12) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_12_re_edukasi">Re-edukasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lama Edukasi</label>
                                        <input type="text" class="form-control" name="lama_edukasi_12"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->lama_edukasi_12 : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- 13. Hasil Pelayanan yang Diharapkan -->
                            <div class="card edukasi-card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title">13. Hasil Pelayanan yang Diharapkan</h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_13"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->tanggal_13 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sasaran</label>
                                        <input type="text" class="form-control" name="sasaran_nama_13"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->sasaran_nama_13 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Edukator</label>
                                        <input type="text" class="form-control" name="edukator_nama_13"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->edukator_nama_13 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pemahaman Awal</label>
                                        @php
                                            $pemahaman_awal_13 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_13
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_13)
                                                    : [];
                                            if (!is_array($pemahaman_awal_13)) {
                                                $pemahaman_awal_13 = [$pemahaman_awal_13];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_13_hal_baru" name="pemahaman_awal_13[]"
                                                    value="hal_baru"
                                                    {{ in_array('hal_baru', $pemahaman_awal_13) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pemahaman_awal_13_hal_baru">Hal
                                                    Baru</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_13_edukasi_ulang" name="pemahaman_awal_13[]"
                                                    value="edukasi_ulang"
                                                    {{ in_array('edukasi_ulang', $pemahaman_awal_13) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="pemahaman_awal_13_edukasi_ulang">Edukasi Ulang</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Metode</label>
                                        @php
                                            $metode_13 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->metode_13
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->metode_13)
                                                    : [];
                                            if (!is_array($metode_13)) {
                                                $metode_13 = [$metode_13];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_13_lisan"
                                                    name="metode_13[]" value="lisan"
                                                    {{ in_array('lisan', $metode_13) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="metode_13_lisan">Lisan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="metode_13_demonstrasi" name="metode_13[]" value="demonstrasi"
                                                    {{ in_array('demonstrasi', $metode_13) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="metode_13_demonstrasi">Demonstrasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media</label>
                                        @php
                                            $media_13 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->media_13
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->media_13)
                                                    : [];
                                            if (!is_array($media_13)) {
                                                $media_13 = [$media_13];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_13_leaflet"
                                                    name="media_13[]" value="leaflet"
                                                    {{ in_array('leaflet', $media_13) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_13_leaflet">Leaflet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_13_booklet"
                                                    name="media_13[]" value="booklet"
                                                    {{ in_array('booklet', $media_13) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_13_booklet">Booklet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="media_13_audiovisual" name="media_13[]" value="audiovisual"
                                                    {{ in_array('audiovisual', $media_13) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="media_13_audiovisual">Audiovisual</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Evaluasi/Edukasi Ulang</label>
                                        @php
                                            $evaluasi_13 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->evaluasi_13
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->evaluasi_13)
                                                    : [];
                                            if (!is_array($evaluasi_13)) {
                                                $evaluasi_13 = [$evaluasi_13];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_13_sudah_paham" name="evaluasi_13[]"
                                                    value="sudah_paham"
                                                    {{ in_array('sudah_paham', $evaluasi_13) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="evaluasi_13_sudah_paham">Sudah
                                                    Paham</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_13_re_demonstrasi" name="evaluasi_13[]"
                                                    value="re_demonstrasi"
                                                    {{ in_array('re_demonstrasi', $evaluasi_13) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_13_re_demonstrasi">Re-demonstrasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_13_re_edukasi" name="evaluasi_13[]"
                                                    value="re_edukasi"
                                                    {{ in_array('re_edukasi', $evaluasi_13) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_13_re_edukasi">Re-edukasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lama Edukasi</label>
                                        <input type="text" class="form-control" name="lama_edukasi_13"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->lama_edukasi_13 : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- 14. Hambatan Pemberian Edukasi -->
                            <div class="card edukasi-card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title">14. Hambatan Pemberian Edukasi</h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Detail Hambatan</label>
                                        <input type="text" class="form-control" name="ket_hambatan_14"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->ket_hambatan_14 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_14"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->tanggal_14 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sasaran</label>
                                        <input type="text" class="form-control" name="sasaran_nama_14"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->sasaran_nama_14 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Edukator</label>
                                        <input type="text" class="form-control" name="edukator_nama_14"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->edukator_nama_14 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pemahaman Awal</label>
                                        @php
                                            $pemahaman_awal_14 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_14
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_14)
                                                    : [];
                                            if (!is_array($pemahaman_awal_14)) {
                                                $pemahaman_awal_14 = [$pemahaman_awal_14];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_14_hal_baru" name="pemahaman_awal_14[]"
                                                    value="hal_baru"
                                                    {{ in_array('hal_baru', $pemahaman_awal_14) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pemahaman_awal_14_hal_baru">Hal
                                                    Baru</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_14_edukasi_ulang" name="pemahaman_awal_14[]"
                                                    value="edukasi_ulang"
                                                    {{ in_array('edukasi_ulang', $pemahaman_awal_14) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="pemahaman_awal_14_edukasi_ulang">Edukasi Ulang</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Metode</label>
                                        @php
                                            $metode_14 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->metode_14
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->metode_14)
                                                    : [];
                                            if (!is_array($metode_14)) {
                                                $metode_14 = [$metode_14];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_14_lisan"
                                                    name="metode_14[]" value="lisan"
                                                    {{ in_array('lisan', $metode_14) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="metode_14_lisan">Lisan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="metode_14_demonstrasi" name="metode_14[]" value="demonstrasi"
                                                    {{ in_array('demonstrasi', $metode_14) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="metode_14_demonstrasi">Demonstrasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media</label>
                                        @php
                                            $media_14 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->media_14
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->media_14)
                                                    : [];
                                            if (!is_array($media_14)) {
                                                $media_14 = [$media_14];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_14_leaflet"
                                                    name="media_14[]" value="leaflet"
                                                    {{ in_array('leaflet', $media_14) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_14_leaflet">Leaflet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_14_booklet"
                                                    name="media_14[]" value="booklet"
                                                    {{ in_array('booklet', $media_14) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_14_booklet">Booklet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="media_14_audiovisual" name="media_14[]" value="audiovisual"
                                                    {{ in_array('audiovisual', $media_14) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="media_14_audiovisual">Audiovisual</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Evaluasi/Edukasi Ulang</label>
                                        @php
                                            $evaluasi_14 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->evaluasi_14
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->evaluasi_14)
                                                    : [];
                                            if (!is_array($evaluasi_14)) {
                                                $evaluasi_14 = [$evaluasi_14];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_14_sudah_paham" name="evaluasi_14[]"
                                                    value="sudah_paham"
                                                    {{ in_array('sudah_paham', $evaluasi_14) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="evaluasi_14_sudah_paham">Sudah
                                                    Paham</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_14_re_demonstrasi" name="evaluasi_14[]"
                                                    value="re_demonstrasi"
                                                    {{ in_array('re_demonstrasi', $evaluasi_14) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_14_re_demonstrasi">Re-demonstrasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_14_re_edukasi" name="evaluasi_14[]"
                                                    value="re_edukasi"
                                                    {{ in_array('re_edukasi', $evaluasi_14) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_14_re_edukasi">Re-edukasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lama Edukasi</label>
                                        <input type="text" class="form-control" name="lama_edukasi_14"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->lama_edukasi_14 : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- 15. Pertanyaan Pasien -->
                            <div class="card edukasi-card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title">15. Pertanyaan Pasien</h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Detail Pertanyaan</label>
                                        <input type="text" class="form-control" name="ket_pertanyaan_15"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->ket_pertanyaan_15 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_15"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->tanggal_15 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sasaran</label>
                                        <input type="text" class="form-control" name="sasaran_nama_15"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->sasaran_nama_15 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Edukator</label>
                                        <input type="text" class="form-control" name="edukator_nama_15"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->edukator_nama_15 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pemahaman Awal</label>
                                        @php
                                            $pemahaman_awal_15 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_15
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_15)
                                                    : [];
                                            if (!is_array($pemahaman_awal_15)) {
                                                $pemahaman_awal_15 = [$pemahaman_awal_15];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_15_hal_baru" name="pemahaman_awal_15[]"
                                                    value="hal_baru"
                                                    {{ in_array('hal_baru', $pemahaman_awal_15) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pemahaman_awal_15_hal_baru">Hal
                                                    Baru</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_15_edukasi_ulang" name="pemahaman_awal_15[]"
                                                    value="edukasi_ulang"
                                                    {{ in_array('edukasi_ulang', $pemahaman_awal_15) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="pemahaman_awal_15_edukasi_ulang">Edukasi Ulang</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Metode</label>
                                        @php
                                            $metode_15 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->metode_15
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->metode_15)
                                                    : [];
                                            if (!is_array($metode_15)) {
                                                $metode_15 = [$metode_15];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_15_lisan"
                                                    name="metode_15[]" value="lisan"
                                                    {{ in_array('lisan', $metode_15) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="metode_15_lisan">Lisan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="metode_15_demonstrasi" name="metode_15[]" value="demonstrasi"
                                                    {{ in_array('demonstrasi', $metode_15) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="metode_15_demonstrasi">Demonstrasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media</label>
                                        @php
                                            $media_15 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->media_15
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->media_15)
                                                    : [];
                                            if (!is_array($media_15)) {
                                                $media_15 = [$media_15];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_15_leaflet"
                                                    name="media_15[]" value="leaflet"
                                                    {{ in_array('leaflet', $media_15) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_15_leaflet">Leaflet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_15_booklet"
                                                    name="media_15[]" value="booklet"
                                                    {{ in_array('booklet', $media_15) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_15_booklet">Booklet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="media_15_audiovisual" name="media_15[]" value="audiovisual"
                                                    {{ in_array('audiovisual', $media_15) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="media_15_audiovisual">Audiovisual</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Evaluasi/Edukasi Ulang</label>
                                        @php
                                            $evaluasi_15 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->evaluasi_15
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->evaluasi_15)
                                                    : [];
                                            if (!is_array($evaluasi_15)) {
                                                $evaluasi_15 = [$evaluasi_15];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_15_sudah_paham" name="evaluasi_15[]"
                                                    value="sudah_paham"
                                                    {{ in_array('sudah_paham', $evaluasi_15) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="evaluasi_15_sudah_paham">Sudah
                                                    Paham</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_15_re_demonstrasi" name="evaluasi_15[]"
                                                    value="re_demonstrasi"
                                                    {{ in_array('re_demonstrasi', $evaluasi_15) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_15_re_demonstrasi">Re-demonstrasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_15_re_edukasi" name="evaluasi_15[]"
                                                    value="re_edukasi"
                                                    {{ in_array('re_edukasi', $evaluasi_15) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_15_re_edukasi">Re-edukasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lama Edukasi</label>
                                        <input type="text" class="form-control" name="lama_edukasi_15"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->lama_edukasi_15 : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- 16. Preferensi Pasien -->
                            <div class="card edukasi-card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title">16. Preferensi Pasien (Keinginan/Permintaan Pasien)
                                    </h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Detail Preferensi</label>
                                        <input type="text" class="form-control" name="ket_preferensi_16"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->ket_preferensi_16 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_16"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->tanggal_16 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sasaran</label>
                                        <input type="text" class="form-control" name="sasaran_nama_16"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->sasaran_nama_16 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Edukator</label>
                                        <input type="text" class="form-control" name="edukator_nama_16"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->edukator_nama_16 : '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pemahaman Awal</label>
                                        @php
                                            $pemahaman_awal_16 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_16
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->pemahaman_awal_16)
                                                    : [];
                                            if (!is_array($pemahaman_awal_16)) {
                                                $pemahaman_awal_16 = [$pemahaman_awal_16];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_16_hal_baru" name="pemahaman_awal_16[]"
                                                    value="hal_baru"
                                                    {{ in_array('hal_baru', $pemahaman_awal_16) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pemahaman_awal_16_hal_baru">Hal
                                                    Baru</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="pemahaman_awal_16_edukasi_ulang" name="pemahaman_awal_16[]"
                                                    value="edukasi_ulang"
                                                    {{ in_array('edukasi_ulang', $pemahaman_awal_16) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="pemahaman_awal_16_edukasi_ulang">Edukasi Ulang</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Metode</label>
                                        @php
                                            $metode_16 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->metode_16
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->metode_16)
                                                    : [];
                                            if (!is_array($metode_16)) {
                                                $metode_16 = [$metode_16];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="metode_16_lisan"
                                                    name="metode_16[]" value="lisan"
                                                    {{ in_array('lisan', $metode_16) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="metode_16_lisan">Lisan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="metode_16_demonstrasi" name="metode_16[]" value="demonstrasi"
                                                    {{ in_array('demonstrasi', $metode_16) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="metode_16_demonstrasi">Demonstrasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media</label>
                                        @php
                                            $media_16 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->media_16
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->media_16)
                                                    : [];
                                            if (!is_array($media_16)) {
                                                $media_16 = [$media_16];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_16_leaflet"
                                                    name="media_16[]" value="leaflet"
                                                    {{ in_array('leaflet', $media_16) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_16_leaflet">Leaflet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="media_16_booklet"
                                                    name="media_16[]" value="booklet"
                                                    {{ in_array('booklet', $media_16) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="media_16_booklet">Booklet</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="media_16_audiovisual" name="media_16[]" value="audiovisual"
                                                    {{ in_array('audiovisual', $media_16) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="media_16_audiovisual">Audiovisual</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Evaluasi/Edukasi Ulang</label>
                                        @php
                                            $evaluasi_16 =
                                                isset($edukasi->kebutuhanEdukasiLanjutan) &&
                                                $edukasi->kebutuhanEdukasiLanjutan->evaluasi_16
                                                    ? json_decode($edukasi->kebutuhanEdukasiLanjutan->evaluasi_16)
                                                    : [];
                                            if (!is_array($evaluasi_16)) {
                                                $evaluasi_16 = [$evaluasi_16];
                                            }
                                        @endphp
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_16_sudah_paham" name="evaluasi_16[]"
                                                    value="sudah_paham"
                                                    {{ in_array('sudah_paham', $evaluasi_16) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="evaluasi_16_sudah_paham">Sudah
                                                    Paham</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_16_re_demonstrasi" name="evaluasi_16[]"
                                                    value="re_demonstrasi"
                                                    {{ in_array('re_demonstrasi', $evaluasi_16) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_16_re_demonstrasi">Re-demonstrasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="evaluasi_16_re_edukasi" name="evaluasi_16[]"
                                                    value="re_edukasi"
                                                    {{ in_array('re_edukasi', $evaluasi_16) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="evaluasi_16_re_edukasi">Re-edukasi</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lama Edukasi</label>
                                        <input type="text" class="form-control" name="lama_edukasi_16"
                                            value="{{ isset($edukasi->kebutuhanEdukasiLanjutan) ? $edukasi->kebutuhanEdukasiLanjutan->lama_edukasi_16 : '' }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="text-end">
                        <x-button-submit id="update">Perbarui</x-button-submit>
                    </div>
                </form>
            </x-content-card>
        </div>
    </div>
@endSection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle translator language input visibility
            const penerjemahYa = document.getElementById('penerjemah_ya');
            const penerjemahTidak = document.getElementById('penerjemah_tidak');
            const penerjemahBahasaInput = document.getElementById('penerjemah_bahasa_input');

            function togglePenerjemahInput() {
                if (penerjemahYa && penerjemahYa.checked) {
                    penerjemahBahasaInput.style.display = 'block';
                } else {
                    penerjemahBahasaInput.style.display = 'none';
                }
            }

            // Initial check on page load
            togglePenerjemahInput();

            // Add event listeners
            if (penerjemahYa) penerjemahYa.addEventListener('change', togglePenerjemahInput);
            if (penerjemahTidak) penerjemahTidak.addEventListener('change', togglePenerjemahInput);

            // Handle mutual exclusive checkboxes for communication barriers
            const hambaranTidakAda = document.getElementById('hambatan_tidak_ada');
            const hambaranLainnya = document.querySelectorAll('.hambatan-komunikasi:not(#hambatan_tidak_ada)');

            if (hambaranTidakAda) {
                hambaranTidakAda.addEventListener('change', function() {
                    if (this.checked) {
                        hambaranLainnya.forEach(checkbox => {
                            checkbox.checked = false;
                        });
                    }
                });
            }

            hambaranLainnya.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked && hambaranTidakAda) {
                        hambaranTidakAda.checked = false;
                    }
                });
            });
        });
    </script>
@endpush
