@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.edukasi.include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            @php
                    $hasExistingData = !empty($existingEdukasi);
                    $edukasiPasien = $hasExistingData ? $existingEdukasi->edukasiPasien : null;
                    $kebutuhanEdukasi = $hasExistingData ? $existingEdukasi->kebutuhanEdukasi : null;
                    $kebutuhanEdukasiLanjutan = $hasExistingData ? $existingEdukasi->kebutuhanEdukasiLanjutan : null;
                @endphp

                <!-- Function helper untuk create/edit view -->
                @php
                    function getExistingValue($model, $field, $default = '') {
                        return isset($model) && isset($model->$field) ? $model->$field : old($field, $default);
                    }

                    function getExistingJsonArray($model, $field, $default = []) {
                        if (!isset($model) || !isset($model->$field)) {
                            return old($field, $default);
                        }
                        $decoded = json_decode($model->$field, true);
                        return is_array($decoded) ? $decoded : [$decoded];
                    }

                    function isExistingChecked($model, $field, $value) {
                        $data = getExistingJsonArray($model, $field, []);
                        return in_array($value, $data);
                    }
                @endphp

            <form id="edukasiForm" method="POST"
                    action="{{ $hasExistingData ?
                    route('rawat-inap.edukasi.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $existingEdukasi->id]) :
                    route('rawat-inap.edukasi.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf
                @if($hasExistingData)
                    @method('PUT')
                @endif
            {{-- <form id="edukasiForm" method="POST"
                action="{{ route('rawat-inap.edukasi.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf --}}

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen">Edukasi Pasien dan Keluarga Terintegrasi</h4>
                                <p>Isikan data edukasi pasien dan keluarga terintegrasi</p>
                            </div>

                            <div class="px-3">

                                <input type="hidden" name="role" value="{{ $role }}">
                                <!-- 1. Kebutuhan Penerjemah -->
                                <div class="section-separator" id="kebutuhan-penerjemah">
                                    <h5 class="section-title">1. Kebutuhan Penerjemah</h5>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kebutuhan Penerjemah</label>
                                        <div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="penerjemah_tidak"
                                                    name="kebutuhan_penerjemah" value="0" required
                                                    {{ getExistingValue($edukasiPasien, 'kebutuhan_penerjemah') == '0' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="penerjemah_tidak">Tidak</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="penerjemah_ya"
                                                    name="kebutuhan_penerjemah" value="1"
                                                    {{ getExistingValue($edukasiPasien, 'kebutuhan_penerjemah') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="penerjemah_ya">Ya, bahasa</label>
                                                <input type="text" class="form-control mt-2" name="penerjemah_bahasa"
                                                    placeholder="Masukkan bahasa" id="penerjemah_bahasa_input"
                                                    value="{{ getExistingValue($edukasiPasien, 'penerjemah_bahasa') }}"
                                                    style="{{ getExistingValue($edukasiPasien, 'kebutuhan_penerjemah') == '1' ? 'display: block;' : 'display: none;' }}">
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
                                                        {{ getExistingValue($edukasiPasien, 'pendidikan') == $didikan->kd_pendidikan ? 'selected' : '' }}>
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
                                            <option value="baik" {{ getExistingValue($edukasiPasien, 'kemampuan_baca_tulis') == 'baik' ? 'selected' : '' }}>
                                                Baik
                                            </option>
                                            <option value="kurang" {{ getExistingValue($edukasiPasien, 'kemampuan_baca_tulis') == 'kurang' ? 'selected' : '' }}>
                                                Kurang
                                            </option>
                                            <option value="tidak_mampu" {{ getExistingValue($edukasiPasien, 'kemampuan_baca_tulis') == 'tidak_mampu' ? 'selected' : '' }}>
                                                Tidak mampu
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- 4. Tipe Pembelajaran -->
                                <div class="section-separator" id="tipe-pembelajaran">
                                    <h5 class="section-title">4. Tipe Pembelajaran</h5>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tipe Pembelajaran</label>
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input tipe-pembelajaran"
                                                    id="tipe_verbal" name="tipe_pembelajaran[]" value="verbal"
                                                    {{ isExistingChecked($edukasiPasien, 'tipe_pembelajaran', 'verbal') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="tipe_verbal">Verbal</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input tipe-pembelajaran"
                                                    id="tipe_tulisan" name="tipe_pembelajaran[]" value="tulisan"
                                                    {{ isExistingChecked($edukasiPasien, 'tipe_pembelajaran', 'tulisan') ? 'checked' : '' }}>
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
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input hambatan-komunikasi"
                                                    id="hambatan_tidak_ada" name="hambatan_komunikasi[]" value="tidak_ada"
                                                    {{ isExistingChecked($edukasiPasien, 'hambatan_komunikasi', 'tidak_ada') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="hambatan_tidak_ada">Tidak ada</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input hambatan-komunikasi"
                                                    id="hambatan_penglihatan" name="hambatan_komunikasi[]" value="penglihatan"
                                                    {{ isExistingChecked($edukasiPasien, 'hambatan_komunikasi', 'penglihatan') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="hambatan_penglihatan">Penglihatan terganggu</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input hambatan-komunikasi"
                                                    id="hambatan_bahasa" name="hambatan_komunikasi[]" value="bahasa"
                                                    {{ isExistingChecked($edukasiPasien, 'hambatan_komunikasi', 'bahasa') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="hambatan_bahasa">Bahasa</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input hambatan-komunikasi"
                                                    id="hambatan_kognitif" name="hambatan_komunikasi[]" value="kognitif"
                                                    {{ isExistingChecked($edukasiPasien, 'hambatan_komunikasi', 'kognitif') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="hambatan_kognitif">Kognitif</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input hambatan-komunikasi"
                                                    id="hambatan_motivasi" name="hambatan_komunikasi[]" value="motivasi"
                                                    {{ isExistingChecked($edukasiPasien, 'hambatan_komunikasi', 'motivasi') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="hambatan_motivasi">Kurang motivasi</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian Kebutuhan Edukasi (Menggunakan Kartu Vertikal) -->
                                <div class="section-separator" id="kebutuhan-edukasi-table">
                                    <h5 class="section-title">Kebutuhan Edukasi ({{ str()->title($role) }})</h5>
                                    <div class="edukasi-cards">

                                                                                @if (in_array(1, $sectionAccess))
                                        <div class="card edukasi-card mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">1. Kondisi medis, diagnosis, rencana perawatan dan terapi yang diberikan</h6>

                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <input type="text" class="form-control" name="ket_Kondisi_medis_1"
                                                        placeholder="Masukkan keterangan"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'ket_Kondisi_medis_1') }}">
                                                </div>

                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal_1"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'tanggal_1') }}">
                                                </div>

                                                <div class="form-group">
                                                    <label>Sasaran</label>
                                                    <input type="text" class="form-control" name="sasaran_nama_1"
                                                        placeholder="Nama dan hubungan dengan pasien"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'sasaran_nama_1') }}">
                                                </div>

                                                <div class="form-group">
                                                    <label>Edukator</label>
                                                    <input type="text" class="form-control" name="edukator_nama_1"
                                                        placeholder="Nama & profesi edukator"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'edukator_nama_1') }}">
                                                </div>

                                                <div class="form-group">
                                                    <label>Tingkat Pemahaman Awal</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_1_hal_baru" name="pemahaman_awal_1[]" value="hal_baru"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'pemahaman_awal_1', 'hal_baru') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pemahaman_awal_1_hal_baru">Hal Baru</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_1_edukasi_ulang" name="pemahaman_awal_1[]" value="edukasi_ulang"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'pemahaman_awal_1', 'edukasi_ulang') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pemahaman_awal_1_edukasi_ulang">Edukasi Ulang</label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Metode</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="metode_1_lisan"
                                                            name="metode_1[]" value="lisan"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'metode_1', 'lisan') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="metode_1_lisan">Lisan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_1_demonstrasi" name="metode_1[]" value="demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'metode_1', 'demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="metode_1_demonstrasi">Demonstrasi</label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Media</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_1_leaflet"
                                                            name="media_1[]" value="leaflet"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'media_1', 'leaflet') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="media_1_leaflet">Leaflet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_1_booklet"
                                                            name="media_1[]" value="booklet"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'media_1', 'booklet') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="media_1_booklet">Booklet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_1_audiovisual" name="media_1[]" value="audiovisual"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'media_1', 'audiovisual') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="media_1_audiovisual">Audiovisual</label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Evaluasi/Edukasi Ulang</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_1_sudah_paham" name="evaluasi_1[]" value="sudah_paham"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_1', 'sudah_paham') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="evaluasi_1_sudah_paham">Sudah Paham</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_1_re_demonstrasi" name="evaluasi_1[]" value="re_demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_1', 're_demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="evaluasi_1_re_demonstrasi">Re-demonstrasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_1_re_edukasi" name="evaluasi_1[]" value="re_edukasi"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_1', 're_edukasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="evaluasi_1_re_edukasi">Re-edukasi</label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Lama Edukasi</label>
                                                    <input type="text" class="form-control" name="lama_edukasi_1"
                                                        placeholder="Masukkan lama edukasi"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'lama_edukasi_1') }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if (in_array(2, $sectionAccess))
                                        <!-- 2. Kemungkinan hasil yang tidak dapat diantisipasi dari terapi dan perawatan -->
                                        <div class="card edukasi-card mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">2. Kemungkinan hasil yang tidak dapat diantisipasi
                                                    dari terapi dan perawatan</h6>
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal_2"
                                                    value="{{ getExistingValue($kebutuhanEdukasi, 'tanggal_2') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Sasaran</label>
                                                    <input type="text" class="form-control" name="sasaran_nama_2"
                                                        placeholder="Nama dan hubungan dengan pasien"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'sasaran_nama_2') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Edukator</label>
                                                    <input type="text" class="form-control" name="edukator_nama_2"
                                                        placeholder="Nama & profesi edukator"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'edukator_nama_2') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat Pemahaman Awal</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_2_hal_baru" name="pemahaman_awal_2[]"
                                                            value="hal_baru"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'pemahaman_awal_2', 'hal_baru') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pemahaman_awal_2">Hal
                                                            Baru</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_2_edukasi_ulang" name="pemahaman_awal_2[]"
                                                            value="edukasi_ulang"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'pemahaman_awal_2', 'edukasi_ulang') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="pemahaman_awal_2_edukasi_ulang">Edukasi Ulang</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Metode</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="metode_2_lisan"
                                                            name="metode_2[]" value="lisan"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'metode_2', 'lisan') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="metode_2_lisan">Lisan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_2_demonstrasi" name="metode_2[]" value="demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'metode_2', 'demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="metode_2_demonstrasi">Demonstrasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Media</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_2_leaflet"
                                                            name="media_2[]" value="leaflet"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'media_2', 'leaflet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_2_leaflet">Leaflet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_2_booklet"
                                                            name="media_2[]" value="booklet"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'media_2', 'booklet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_2_booklet">Booklet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_2_audiovisual" name="media_2[]" value="audiovisual"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'media_2', 'audiovisual') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_2_audiovisual">Audiovisual</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Evaluasi/Edukasi Ulang</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_2_sudah_paham" name="evaluasi_2[]"
                                                            value="sudah_paham"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_2', 'sudah_paham') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="evaluasi_2_sudah_paham">Sudah
                                                            Paham</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_2_re_demonstrasi" name="evaluasi_2[]"
                                                            value="re_demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_2', 're_demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_2_re_demonstrasi">Re-demonstrasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_2_re_edukasi" name="evaluasi_2[]"
                                                            value="re_edukasi"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_2', 're_edukasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_2_re_edukasi">Re-edukasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lama Edukasi</label>
                                                    <input type="text" class="form-control" name="lama_edukasi_2"
                                                        placeholder="Masukkan lama edukasi"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'lama_edukasi_2') }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if (in_array(3, $sectionAccess))
                                        <!-- 3. Manfaat obat-obatan, efek samping, serta interaksi obat dan makanan yang diberikan -->
                                        <div class="card edukasi-card mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">3. Manfaat obat-obatan, efek samping, serta interaksi
                                                    obat dan makanan yang diberikan</h6>
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal_3"
                                                    value="{{ getExistingValue($kebutuhanEdukasi, 'tanggal_3') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Sasaran</label>
                                                    <input type="text" class="form-control" name="sasaran_nama_3"
                                                        placeholder="Nama dan hubungan dengan pasien"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'sasaran_nama_3') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Edukator</label>
                                                    <input type="text" class="form-control" name="edukator_nama_3"
                                                        placeholder="Nama & profesi edukator"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'edukator_nama_3') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat Pemahaman Awal</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_3_hal_baru" name="pemahaman_awal_3[]"
                                                            value="hal_baru"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'pemahaman_awal_3', 'hal_baru') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pemahaman_awal_3_hal_baru">Hal
                                                            Baru</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_3_edukasi_ulang" name="pemahaman_awal_3[]"
                                                            value="edukasi_ulang"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'pemahaman_awal_3', 'edukasi_ulang') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="pemahaman_awal_3_edukasi_ulang">Edukasi Ulang</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Metode</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="metode_3_lisan"
                                                            name="metode_3[]" value="lisan"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'metode_3', 'lisan') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="metode_3_lisan">Lisan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_3_demonstrasi" name="metode_3[]" value="demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'metode_3', 'demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="metode_3_demonstrasi">Demonstrasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Media</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_3_leaflet"
                                                            name="media_3[]" value="leaflet"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'media_3', 'leaflet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_3_leaflet">Leaflet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_3_booklet"
                                                            name="media_3[]" value="booklet"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'media_3', 'booklet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_3_booklet">Booklet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_3_audiovisual" name="media_3[]" value="audiovisual"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'media_3', 'audiovisual') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_3_audiovisual">Audiovisual</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Evaluasi/Edukasi Ulang</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_3_sudah_paham" name="evaluasi_3[]"
                                                            value="sudah_paham"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_3', 'sudah_paham') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="evaluasi_3_sudah_paham">Sudah
                                                            Paham</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_3_re_demonstrasi" name="evaluasi_3[]"
                                                            value="re_demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_3', 're_demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_3_re_demonstrasi">Re-demonstrasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_3_re_edukasi" name="evaluasi_3[]"
                                                            value="re_edukasi"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_3', 're_edukasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_3_re_edukasi">Re-edukasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lama Edukasi</label>
                                                    <input type="text" class="form-control" name="lama_edukasi_3"
                                                        placeholder="Masukkan lama edukasi"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'lama_edukasi_3') }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if (in_array(4, $sectionAccess))
                                        <!-- 4. Program diet dan nutrisi sebutkan... -->
                                        <div class="card edukasi-card mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">4. Program diet dan nutrisi sebutkan...</h6>
                                                <div class="form-group">
                                                    <label>keterangan</label>
                                                    <input type="text" class="form-control" name="ket_program_4"
                                                        placeholder="Masukkan keterangan"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'ket_program_4') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal_4"
                                                    value="{{ getExistingValue($kebutuhanEdukasi, 'tanggal_4') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Sasaran</label>
                                                    <input type="text" class="form-control" name="sasaran_nama_4"
                                                        placeholder="Nama dan hubungan dengan pasien"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'sasaran_nama_4') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Edukator</label>
                                                    <input type="text" class="form-control" name="edukator_nama_4"
                                                        placeholder="Nama & profesi edukator"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'edukator_nama_4') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat Pemahaman Awal</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_4_hal_baru" name="pemahaman_awal_4[]"
                                                            value="hal_baru"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'pemahaman_awal_4', 'hal_baru') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pemahaman_awal_4_hal_baru">Hal
                                                            Baru</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_4_edukasi_ulang" name="pemahaman_awal_4[]"
                                                            value="edukasi_ulang"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'pemahaman_awal_4', 'edukasi_ulang') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="pemahaman_awal_4_edukasi_ulang">Edukasi Ulang</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Metode</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="metode_4_lisan"
                                                            name="metode_4[]" value="lisan"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'metode_4', 'lisan') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="metode_4_lisan">Lisan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_4_demonstrasi" name="metode_4[]" value="demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'metode_4', 'demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="metode_4_demonstrasi">Demonstrasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Media</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_4_leaflet"
                                                            name="media_4[]" value="leaflet"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'media_4', 'leaflet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_4_leaflet">Leaflet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_4_booklet"
                                                            name="media_4[]" value="booklet"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'media_4', 'booklet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_4_booklet">Booklet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_4_audiovisual" name="media_4[]" value="audiovisual"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'media_4', 'audiovisual') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_4_audiovisual">Audiovisual</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Evaluasi/Edukasi Ulang</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_4_sudah_paham" name="evaluasi_4[]"
                                                            value="sudah_paham"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_4', 'sudah_paham') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="evaluasi_4_sudah_paham">Sudah
                                                            Paham</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_4_re_demonstrasi" name="evaluasi_4[]"
                                                            value="re_demonstrasi" {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_4', 're_demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_4_re_demonstrasi">Re-demonstrasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_4_re_edukasi" name="evaluasi_4[]"
                                                            value="re_edukasi" value="re_demonstrasi" {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_4', 're_edukasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_4_re_edukasi">Re-edukasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lama Edukasi</label>
                                                    <input type="text" class="form-control" name="lama_edukasi_4"
                                                        placeholder="Masukkan lama edukasi" value="{{ getExistingValue($kebutuhanEdukasi, 'lama_edukasi_4') }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if (in_array(5, $sectionAccess))
                                        <!-- 5. Manajemen Nyeri kemungkinan timbulnya nyeri setelah menerima terapi/prosedur/perawatan medis/Pilihan tatalaksana Nyeri -->
                                        <div class="card edukasi-card mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">5. Manajemen Nyeri kemungkinan timbulnya nyeri
                                                    setelah menerima terapi/prosedur/perawatan medis/Pilihan tatalaksana
                                                    Nyeri</h6>
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal_5" placeholder="Masukkan lama edukasi" value="{{ getExistingValue($kebutuhanEdukasi, 'tanggal_5') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Sasaran</label>
                                                    <input type="text" class="form-control" name="sasaran_nama_5"
                                                        placeholder="Nama dan hubungan dengan pasien"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'sasaran_nama_5') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Edukator</label>
                                                    <input type="text" class="form-control" name="edukator_nama_5"
                                                        placeholder="Nama & profesi edukator"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'edukator_nama_5') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat Pemahaman Awal</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_5_hal_baru" name="pemahaman_awal_5[]"
                                                            value="hal_baru"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_4', 're_edukasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pemahaman_awal_5_hal_baru">Hal
                                                            Baru</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_5_edukasi_ulang" name="pemahaman_awal_5[]"
                                                            value="edukasi_ulang"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_4', 're_edukasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="pemahaman_awal_5_edukasi_ulang">Edukasi Ulang</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Metode</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="metode_5_lisan"
                                                            name="metode_5[]" value="lisan"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'metode_5', 'lisan') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="metode_5_lisan">Lisan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_5_demonstrasi" name="metode_5[]" value="demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'metode_5', 'demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="metode_5_demonstrasi">Demonstrasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Media</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_5_leaflet"
                                                            name="media_5[]" value="leaflet"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'metode_5', 'leaflet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_5_leaflet">Leaflet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_5_booklet"
                                                            name="media_5[]" value="booklet"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'media_5', 'booklet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_5_booklet">Booklet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_5_audiovisual" name="media_5[]" value="audiovisual"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'media_5', 'audiovisual') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_5_audiovisual">Audiovisual</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Evaluasi/Edukasi Ulang</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_5_sudah_paham" name="evaluasi_5[]"
                                                            value="sudah_paham"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_5', 'sudah_paham') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="evaluasi_5_sudah_paham">Sudah
                                                            Paham</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_5_re_demonstrasi" name="evaluasi_5[]"
                                                            value="re_demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_5', 're_demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_5_re_demonstrasi">Re-demonstrasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_5_re_edukasi" name="evaluasi_5[]"
                                                            value="re_edukasi"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_5', 're_edukasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_5_re_edukasi">Re-edukasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lama Edukasi</label>
                                                    <input type="text" class="form-control" name="lama_edukasi_5"
                                                        placeholder="Masukkan lama edukasi"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'lama_edukasi_5') }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if (in_array(6, $sectionAccess))
                                        <!-- 6. Cuci tangan (Hand Hygiene) -->
                                        <div class="card edukasi-card mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">6. Cuci tangan (Hand Hygiene)</h6>
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal_6"
                                                    value="{{ getExistingValue($kebutuhanEdukasi, 'tanggal_6') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Sasaran</label>
                                                    <input type="text" class="form-control" name="sasaran_nama_6"
                                                        placeholder="Nama dan hubungan dengan pasien"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'sasaran_nama_6') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Edukator</label>
                                                    <input type="text" class="form-control" name="edukator_nama_6"
                                                        placeholder="Nama & profesi edukator"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'edukator_nama_6') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat Pemahaman Awal</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_6_hal_baru" name="pemahaman_awal_6[]"
                                                            value="hal_baru"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'pemahaman_awal_6', 'hal_baru') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pemahaman_awal_6_hal_baru">Hal
                                                            Baru</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_6_edukasi_ulang" name="pemahaman_awal_6[]"
                                                            value="edukasi_ulang"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'pemahaman_awal_6', 'edukasi_ulang') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="pemahaman_awal_6_edukasi_ulang">Edukasi Ulang</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Metode</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="metode_6_lisan"
                                                            name="metode_6[]" value="lisan"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'metode_6', 'lisan') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="metode_6_lisan">Lisan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_6_demonstrasi" name="metode_6[]" value="demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'metode_6', 'demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="metode_6_demonstrasi">Demonstrasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Media</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_6_leaflet"
                                                            name="media_6[]" value="leaflet"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'media_6', 'leaflet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_6_leaflet">Leaflet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_6_booklet"
                                                            name="media_6[]" value="booklet"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'media_6', 'booklet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_6_booklet">Booklet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_6_audiovisual" name="media_6[]" value="audiovisual"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'media_6', 'audiovisual') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_6_audiovisual">Audiovisual</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Evaluasi/Edukasi Ulang</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_6_sudah_paham" name="evaluasi_6[]"
                                                            value="sudah_paham"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_6', 'sudah_paham') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="evaluasi_6_sudah_paham">Sudah
                                                            Paham</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_6_re_demonstrasi" name="evaluasi_6[]"
                                                            value="re_demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_6', 're_demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_6_re_demonstrasi">Re-demonstrasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_6_re_edukasi" name="evaluasi_6[]"
                                                            value="re_edukasi"
                                                            {{ isExistingChecked($kebutuhanEdukasi, 'evaluasi_6', 're_edukasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_6_re_edukasi">Re-edukasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lama Edukasi</label>
                                                    <input type="text" class="form-control" name="lama_edukasi_6"
                                                        placeholder="Masukkan lama edukasi"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'lama_edukasi_6') }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if (in_array(7, $sectionAccess))
                                        <!-- 7. Waktu kontrol dan penggunaan obat-obatan di rumah -->
                                        <div class="card edukasi-card mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">7. Waktu kontrol dan penggunaan obat-obatan di rumah
                                                </h6>
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal_7"
                                                    value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'tanggal_7') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Sasaran</label>
                                                    <input type="text" class="form-control" name="sasaran_nama_7"
                                                        placeholder="Nama dan hubungan dengan pasien"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'sasaran_nama_7') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Edukator</label>
                                                    <input type="text" class="form-control" name="edukator_nama_7"
                                                        placeholder="Nama & profesi edukator"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'edukator_nama_7') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat Pemahaman Awal</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_7_hal_baru" name="pemahaman_awal_7[]"
                                                            value="hal_baru"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_7', 'hal_baru') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pemahaman_awal_7_hal_baru">Hal
                                                            Baru</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_7_edukasi_ulang" name="pemahaman_awal_7[]"
                                                            value="edukasi_ulang"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_7', 'edukasi_ulang') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="pemahaman_awal_7_edukasi_ulang">Edukasi Ulang</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Metode</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="metode_7_lisan"
                                                            name="metode_7[]" value="lisan"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_7', 'lisan') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="metode_7_lisan">Lisan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_7_demonstrasi" name="metode_7[]" value="demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_7', 'demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="metode_7_demonstrasi">Demonstrasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Media</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_7_leaflet"
                                                            name="media_7[]" value="leaflet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_7', 'leaflet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_7_leaflet">Leaflet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_7_booklet"
                                                            name="media_7[]" value="booklet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_7', 'booklet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_7_booklet">Booklet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_7_audiovisual" name="media_7[]" value="audiovisual"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_7', 'audiovisual') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_7_audiovisual">Audiovisual</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Evaluasi/Edukasi Ulang</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_7_sudah_paham" name="evaluasi_7[]"
                                                            value="sudah_paham"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_7', 'sudah_paham') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="evaluasi_7_sudah_paham">Sudah
                                                            Paham</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_7_re_demonstrasi" name="evaluasi_7[]"
                                                            value="re_demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_7', 're_demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_7_re_demonstrasi">Re-demonstrasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_7_re_edukasi" name="evaluasi_7[]"
                                                            value="re_edukasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_7', 're_edukasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_7_re_edukasi">Re-edukasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lama Edukasi</label>
                                                    <input type="text" class="form-control" name="lama_edukasi_7"
                                                        placeholder="Masukkan lama edukasi"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'lama_edukasi_7') }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        {{-- @if (in_array(8, $sectionAccess))
                                        <!-- 8. Waktu kontrol dan penggunaan obat-obatan di rumah -->
                                        <div class="card edukasi-card mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">8. Waktu kontrol dan penggunaan obat-obatan di rumah
                                                </h6>
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal_8">
                                                </div>
                                                <div class="form-group">
                                                    <label>Sasaran</label>
                                                    <input type="text" class="form-control" name="sasaran_nama_8"
                                                        placeholder="Nama dan hubungan dengan pasien">
                                                </div>
                                                <div class="form-group">
                                                    <label>Edukator</label>
                                                    <input type="text" class="form-control" name="edukator_nama_8"
                                                        placeholder="Nama & profesi edukator">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat Pemahaman Awal</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_8_hal_baru" name="pemahaman_awal_8[]"
                                                            value="hal_baru">
                                                        <label class="form-check-label" for="pemahaman_awal_8_hal_baru">Hal
                                                            Baru</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_8_edukasi_ulang" name="pemahaman_awal_8[]"
                                                            value="edukasi_ulang">
                                                        <label class="form-check-label"
                                                            for="pemahaman_awal_8_edukasi_ulang">Edukasi Ulang</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Metode</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="metode_8_lisan"
                                                            name="metode_8[]" value="lisan">
                                                        <label class="form-check-label" for="metode_8_lisan">Lisan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_8_demonstrasi" name="metode_8[]" value="demonstrasi">
                                                        <label class="form-check-label"
                                                            for="metode_8_demonstrasi">Demonstrasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Media</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_8_leaflet"
                                                            name="media_8[]" value="leaflet">
                                                        <label class="form-check-label"
                                                            for="media_8_leaflet">Leaflet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_8_booklet"
                                                            name="media_8[]" value="booklet">
                                                        <label class="form-check-label"
                                                            for="media_8_booklet">Booklet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_8_audiovisual" name="media_8[]" value="audiovisual">
                                                        <label class="form-check-label"
                                                            for="media_8_audiovisual">Audiovisual</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Evaluasi/Edukasi Ulang</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_8_sudah_paham" name="evaluasi_8[]"
                                                            value="sudah_paham">
                                                        <label class="form-check-label" for="evaluasi_8_sudah_paham">Sudah
                                                            Paham</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_8_re_demonstrasi" name="evaluasi_8[]"
                                                            value="re_demonstrasi">
                                                        <label class="form-check-label"
                                                            for="evaluasi_8_re_demonstrasi">Re-demonstrasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_8_re_edukasi" name="evaluasi_8[]"
                                                            value="re_edukasi">
                                                        <label class="form-check-label"
                                                            for="evaluasi_8_re_edukasi">Re-edukasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lama Edukasi</label>
                                                    <input type="text" class="form-control" name="lama_edukasi_8"
                                                        placeholder="Masukkan lama edukasi">
                                                </div>
                                            </div>
                                        </div>
                                        @endif --}}

                                        @if (in_array(9, $sectionAccess))
                                        <!-- 9. Teknik Rehabilitasi -->
                                        <div class="card edukasi-card mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">9. Teknik Rehabilitasi</h6>
                                                <div class="form-group">
                                                    <label>keterangan</label>
                                                    <input type="text" class="form-control" name="ket_teknik_rehabilitasi_9"
                                                        placeholder="Masukkan keterangan"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'ket_teknik_rehabilitasi_9') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal_9"
                                                    value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'tanggal_9') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Detail Teknik Rehabilitasi</label>
                                                    <input type="text" class="form-control" name="teknik_rehabilitasi_9"
                                                        placeholder="Masukkan detail teknik rehabilitasi"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'teknik_rehabilitasi_9') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Sasaran</label>
                                                    <input type="text" class="form-control" name="sasaran_nama_9"
                                                        placeholder="Nama dan hubungan dengan pasien"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'sasaran_nama_9') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Edukator</label>
                                                    <input type="text" class="form-control" name="edukator_nama_9"
                                                        placeholder="Nama & profesi edukator"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'edukator_nama_9') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat Pemahaman Awal</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_9_hal_baru" name="pemahaman_awal_9[]"
                                                            value="hal_baru"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_9', 'hal_baru') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pemahaman_awal_9_hal_baru">Hal
                                                            Baru</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_9_edukasi_ulang" name="pemahaman_awal_9[]"
                                                            value="edukasi_ulang"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_9', 'edukasi_ulang') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="pemahaman_awal_9_edukasi_ulang">Edukasi Ulang</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Metode</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="metode_9_lisan"
                                                            name="metode_9[]" value="lisan"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_9', 'lisan') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="metode_9_lisan">Lisan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_9_demonstrasi" name="metode_9[]" value="demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_9', 'demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="metode_9_demonstrasi">Demonstrasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Media</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_9_leaflet"
                                                            name="media_9[]" value="leaflet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_9', 'leaflet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_9_leaflet">Leaflet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="media_9_booklet"
                                                            name="media_9[]" value="booklet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_9', 'booklet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_9_booklet">Booklet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_9_audiovisual" name="media_9[]" value="audiovisual"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_9', 'audiovisual') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_9_audiovisual">Audiovisual</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Evaluasi/Edukasi Ulang</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_9_sudah_paham" name="evaluasi_9[]"
                                                            value="sudah_paham"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_9', 'sudah_paham') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="evaluasi_9_sudah_paham">Sudah
                                                            Paham</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_9_re_demonstrasi" name="evaluasi_9[]"
                                                            value="re_demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_9', 're_demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_9_re_demonstrasi">Re-demonstrasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_9_re_edukasi" name="evaluasi_9[]"
                                                            value="re_edukasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_9', 're_edukasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_9_re_edukasi">Re-edukasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lama Edukasi</label>
                                                    <input type="text" class="form-control" name="lama_edukasi_9"
                                                        placeholder="Masukkan lama edukasi"
                                                        value="{{ getExistingValue($kebutuhanEdukasi, 'lama_edukasi_9') }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if (in_array(10, $sectionAccess))
                                        <!-- 10. Penggunaan peralatan medis secara efektif dan aman -->
                                        <div class="card edukasi-card mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">10. Penggunaan peralatan medis secara efektif dan
                                                    aman</h6>
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal_10"
                                                    value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'tanggal_10') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Sasaran</label>
                                                    <input type="text" class="form-control" name="sasaran_nama_10"
                                                        placeholder="Nama dan hubungan dengan pasien"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'sasaran_nama_10') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Edukator</label>
                                                    <input type="text" class="form-control" name="edukator_nama_10"
                                                        placeholder="Nama & profesi edukator"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'edukator_nama_10') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat Pemahaman Awal</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_10_hal_baru" name="pemahaman_awal_10[]"
                                                            value="hal_baru"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_10', 'hal_baru') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pemahaman_awal_10_hal_baru">Hal
                                                            Baru</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_10_edukasi_ulang" name="pemahaman_awal_10[]"
                                                            value="edukasi_ulang"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_10', 'edukasi_ulang') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="pemahaman_awal_10_edukasi_ulang">Edukasi Ulang</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Metode</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="metode_10_lisan"
                                                            name="metode_10[]" value="lisan"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_10', 'lisan') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="metode_10_lisan">Lisan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_10_demonstrasi" name="metode_10[]"
                                                            value="demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_10', 'demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="metode_10_demonstrasi">Demonstrasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Media</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_10_leaflet" name="media_10[]" value="leaflet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_10', 'leaflet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_10_leaflet">Leaflet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_10_booklet" name="media_10[]" value="booklet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_10', 'booklet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_10_booklet">Booklet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_10_audiovisual" name="media_10[]" value="audiovisual"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_10', 'audiovisual') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_10_audiovisual">Audiovisual</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Evaluasi/Edukasi Ulang</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_10_sudah_paham" name="evaluasi_10[]"
                                                            value="sudah_paham"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_10', 'sudah_paham') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="evaluasi_10_sudah_paham">Sudah
                                                            Paham</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_10_re_demonstrasi" name="evaluasi_10[]"
                                                            value="re_demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_10', 're_demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_10_re_demonstrasi">Re-demonstrasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_10_re_edukasi" name="evaluasi_10[]"
                                                            value="re_edukasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_10', 're_edukasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_10_re_edukasi">Re-edukasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lama Edukasi</label>
                                                    <input type="text" class="form-control" name="lama_edukasi_10"
                                                        placeholder="Masukkan lama edukasi"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'lama_edukasi_10') }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if (in_array(11, $sectionAccess))
                                        <!-- 11. Jenis Pelayanan -->
                                        <div class="card edukasi-card mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">11. Jenis Pelayanan</h6>
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal_11"
                                                    value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'tanggal_11') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Sasaran</label>
                                                    <input type="text" class="form-control" name="sasaran_nama_11"
                                                        placeholder="Nama dan hubungan dengan pasien"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'sasaran_nama_11') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Edukator</label>
                                                    <input type="text" class="form-control" name="edukator_nama_11"
                                                        placeholder="Nama & profesi edukator"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'edukator_nama_11') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat Pemahaman Awal</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_11_hal_baru" name="pemahaman_awal_11[]"
                                                            value="hal_baru"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_11', 'hal_baru') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pemahaman_awal_11_hal_baru">Hal
                                                            Baru</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_11_edukasi_ulang" name="pemahaman_awal_11[]"
                                                            value="edukasi_ulang"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_11', 'edukasi_ulang') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="pemahaman_awal_11_edukasi_ulang">Edukasi Ulang</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Metode</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="metode_11_lisan"
                                                            name="metode_11[]" value="lisan"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_11', 'lisan') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="metode_11_lisan">Lisan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_11_demonstrasi" name="metode_11[]"
                                                            value="demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_11', 'demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="metode_11_demonstrasi">Demonstrasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Media</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_11_leaflet" name="media_11[]" value="leaflet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_11', 'leaflet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_11_leaflet">Leaflet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_11_booklet" name="media_11[]" value="booklet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_11', 'booklet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_11_booklet">Booklet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_11_audiovisual" name="media_11[]" value="audiovisual"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_11', 'audiovisual') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_11_audiovisual">Audiovisual</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Evaluasi/Edukasi Ulang</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_11_sudah_paham" name="evaluasi_11[]"
                                                            value="sudah_paham"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_11', 'sudah_paham') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="evaluasi_11_sudah_paham">Sudah
                                                            Paham</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_11_re_demonstrasi" name="evaluasi_11[]"
                                                            value="re_demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_11', 're_demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_11_re_demonstrasi">Re-demonstrasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_11_re_edukasi" name="evaluasi_11[]"
                                                            value="re_edukasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_11', 're_edukasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_11_re_edukasi">Re-edukasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lama Edukasi</label>
                                                    <input type="text" class="form-control" name="lama_edukasi_11"
                                                        placeholder="Masukkan lama edukasi"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'lama_edukasi_11') }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if (in_array(12, $sectionAccess))
                                        <!-- 12. Perkiraan Biaya -->
                                        <div class="card edukasi-card mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">12. Perkiraan Biaya</h6>
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal_12"
                                                    value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'tanggal_12') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Sasaran</label>
                                                    <input type="text" class="form-control" name="sasaran_nama_12"
                                                        placeholder="Nama dan hubungan dengan pasien"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'sasaran_nama_12') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Edukator</label>
                                                    <input type="text" class="form-control" name="edukator_nama_12"
                                                        placeholder="Nama & profesi edukator"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'edukator_nama_12') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat Pemahaman Awal</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_12_hal_baru" name="pemahaman_awal_12[]"
                                                            value="hal_baru"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_12', 'hal_baru') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pemahaman_awal_12_hal_baru">Hal
                                                            Baru</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_12_edukasi_ulang" name="pemahaman_awal_12[]"
                                                            value="edukasi_ulang"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_12', 'edukasi_ulang') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="pemahaman_awal_12_edukasi_ulang">Edukasi Ulang</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Metode</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="metode_12_lisan"
                                                            name="metode_12[]" value="lisan"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_12', 'lisan') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="metode_12_lisan">Lisan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_12_demonstrasi" name="metode_12[]"
                                                            value="demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_12', 'demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="metode_12_demonstrasi">Demonstrasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Media</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_12_leaflet" name="media_12[]" value="leaflet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_12', 'leaflet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_12_leaflet">Leaflet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_12_booklet" name="media_12[]" value="booklet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_12', 'booklet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_12_booklet">Booklet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_12_audiovisual" name="media_12[]" value="audiovisual"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_12', 'audiovisual') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_12_audiovisual">Audiovisual</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Evaluasi/Edukasi Ulang</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_12_sudah_paham" name="evaluasi_12[]"
                                                            value="sudah_paham"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_12', 'sudah_paham') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="evaluasi_12_sudah_paham">Sudah
                                                            Paham</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_12_re_demonstrasi" name="evaluasi_12[]"
                                                            value="re_demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_12', 're_demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_12_re_demonstrasi">Re-demonstrasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_12_re_edukasi" name="evaluasi_12[]"
                                                            value="re_edukasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_12', 're_edukasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_12_re_edukasi">Re-edukasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lama Edukasi</label>
                                                    <input type="text" class="form-control" name="lama_edukasi_12"
                                                        placeholder="Masukkan lama edukasi"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'lama_edukasi_12') }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if (in_array(13, $sectionAccess))
                                        <!-- 13. Hasil Pelayanan yang Diharapkan -->
                                        <div class="card edukasi-card mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">13. Hasil Pelayanan yang Diharapkan</h6>
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal_13"
                                                    value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'tanggal_13') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Sasaran</label>
                                                    <input type="text" class="form-control" name="sasaran_nama_13"
                                                        placeholder="Nama dan hubungan dengan pasien"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'sasaran_nama_13') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Edukator</label>
                                                    <input type="text" class="form-control" name="edukator_nama_13"
                                                        placeholder="Nama & profesi edukator"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'edukator_nama_13') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat Pemahaman Awal</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_13_hal_baru" name="pemahaman_awal_13[]"
                                                            value="hal_baru"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_13', 'hal_baru') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pemahaman_awal_13_hal_baru">Hal
                                                            Baru</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_13_edukasi_ulang" name="pemahaman_awal_13[]"
                                                            value="edukasi_ulang"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_13', 'edukasi_ulang') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="pemahaman_awal_13_edukasi_ulang">Edukasi Ulang</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Metode</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="metode_13_lisan"
                                                            name="metode_13[]" value="lisan"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_13', 'lisan') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="metode_13_lisan">Lisan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_13_demonstrasi" name="metode_13[]"
                                                            value="demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_13', 'demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="metode_13_demonstrasi">Demonstrasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Media</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_13_leaflet" name="media_13[]" value="leaflet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_13', 'leaflet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_13_leaflet">Leaflet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_13_booklet" name="media_13[]" value="booklet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_13', 'booklet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_13_booklet">Booklet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_13_audiovisual" name="media_13[]" value="audiovisual"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_13', 'audiovisual') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_13_audiovisual">Audiovisual</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Evaluasi/Edukasi Ulang</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_13_sudah_paham" name="evaluasi_13[]"
                                                            value="sudah_paham"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_13', 'sudah_paham') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="evaluasi_13_sudah_paham">Sudah
                                                            Paham</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_13_re_demonstrasi" name="evaluasi_13[]"
                                                            value="re_demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_13', 're_demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_13_re_demonstrasi">Re-demonstrasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_13_re_edukasi" name="evaluasi_13[]"
                                                            value="re_edukasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_13', 're_edukasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_13_re_edukasi">Re-edukasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lama Edukasi</label>
                                                    <input type="text" class="form-control" name="lama_edukasi_13"
                                                        placeholder="Masukkan lama edukasi"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'lama_edukasi_13') }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if (in_array(14, $sectionAccess))
                                        <!-- 14. Hambatan Pemberian Edukasi -->
                                        <div class="card edukasi-card mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">14. Hambatan Pemberian Edukasi</h6>
                                                <div class="form-group">
                                                    <label>Detail Hambatan</label>
                                                    <input type="text" class="form-control"
                                                        name="ket_hambatan_14"
                                                        placeholder="Masukkan hambatan pemberian edukasi"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'ket_hambatan_14') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal_14"
                                                    value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'tanggal_14') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Sasaran</label>
                                                    <input type="text" class="form-control" name="sasaran_nama_14"
                                                        placeholder="Nama dan hubungan dengan pasien"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'sasaran_nama_14') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Edukator</label>
                                                    <input type="text" class="form-control" name="edukator_nama_14"
                                                        placeholder="Nama & profesi edukator"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'edukator_nama_14') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat Pemahaman Awal</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_14_hal_baru" name="pemahaman_awal_14[]"
                                                            value="hal_baru"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_14', 'hal_baru') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pemahaman_awal_14_hal_baru">Hal
                                                            Baru</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_14_edukasi_ulang" name="pemahaman_awal_14[]"
                                                            value="edukasi_ulang"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_14', 'edukasi_ulang') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="pemahaman_awal_14_edukasi_ulang">Edukasi Ulang</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Metode</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="metode_14_lisan"
                                                            name="metode_14[]" value="lisan"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_14', 'lisan') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="metode_14_lisan">Lisan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_14_demonstrasi" name="metode_14[]"
                                                            value="demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_14', 'demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="metode_14_demonstrasi">Demonstrasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Media</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_14_leaflet" name="media_14[]" value="leaflet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_14', 'leaflet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_14_leaflet">Leaflet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_14_booklet" name="media_14[]" value="booklet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_14', 'booklet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_14_booklet">Booklet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_14_audiovisual" name="media_14[]" value="audiovisual"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_14', 'audiovisual') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_14_audiovisual">Audiovisual</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Evaluasi/Edukasi Ulang</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_14_sudah_paham" name="evaluasi_14[]"
                                                            value="sudah_paham"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_14', 'sudah_paham') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="evaluasi_14_sudah_paham">Sudah
                                                            Paham</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_14_re_demonstrasi" name="evaluasi_14[]"
                                                            value="re_demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_14', 're_demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_14_re_demonstrasi">Re-demonstrasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_14_re_edukasi" name="evaluasi_14[]"
                                                            value="re_edukasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_14', 're_edukasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_14_re_edukasi">Re-edukasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lama Edukasi</label>
                                                    <input type="text" class="form-control" name="lama_edukasi_14"
                                                        placeholder="Masukkan lama edukasi"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'lama_edukasi_14') }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if (in_array(15, $sectionAccess))
                                        <!-- 15. Pertanyaan Pasien -->
                                        <div class="card edukasi-card mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">15. Pertanyaan Pasien</h6>
                                                <div class="form-group">
                                                    <label>Detail Pertanyaan</label>
                                                    <input type="text" class="form-control" name="ket_pertanyaan_15"
                                                        placeholder="Masukkan pertanyaan pasien"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'ket_pertanyaan_15') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal_15"
                                                    value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'tanggal_15') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Sasaran</label>
                                                    <input type="text" class="form-control" name="sasaran_nama_15"
                                                        placeholder="Nama dan hubungan dengan pasien"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'sasaran_nama_15') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Edukator</label>
                                                    <input type="text" class="form-control" name="edukator_nama_15"
                                                        placeholder="Nama & profesi edukator"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'edukator_nama_15') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat Pemahaman Awal</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_15_hal_baru" name="pemahaman_awal_15[]"
                                                            value="hal_baru"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_15', 'hal_baru') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pemahaman_awal_15_hal_baru">Hal
                                                            Baru</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_15_edukasi_ulang" name="pemahaman_awal_15[]"
                                                            value="edukasi_ulang"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_15', 'edukasi_ulang') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="pemahaman_awal_15_edukasi_ulang">Edukasi Ulang</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Metode</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="metode_15_lisan"
                                                            name="metode_15[]" value="lisan"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_15', 'lisan') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="metode_15_lisan">Lisan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_15_demonstrasi" name="metode_15[]"
                                                            value="demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_15', 'demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="metode_15_demonstrasi">Demonstrasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Media</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_15_leaflet" name="media_15[]" value="leaflet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_15', 'leaflet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_15_leaflet">Leaflet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_15_booklet" name="media_15[]" value="booklet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_15', 'booklet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_15_booklet">Booklet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_15_audiovisual" name="media_15[]" value="audiovisual"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_15', 'audiovisual') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_15_audiovisual">Audiovisual</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Evaluasi/Edukasi Ulang</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_15_sudah_paham" name="evaluasi_15[]"
                                                            value="sudah_paham"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_15', 'sudah_paham') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="evaluasi_15_sudah_paham">Sudah
                                                            Paham</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_15_re_demonstrasi" name="evaluasi_15[]"
                                                            value="re_demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_15', 're_demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_15_re_demonstrasi">Re-demonstrasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_15_re_edukasi" name="evaluasi_15[]"
                                                            value="re_edukasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_15', 're_edukasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_15_re_edukasi">Re-edukasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lama Edukasi</label>
                                                    <input type="text" class="form-control" name="lama_edukasi_15"
                                                        placeholder="Masukkan lama edukasi"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'lama_edukasi_15') }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if (in_array(16, $sectionAccess))
                                        <!-- 16. Preferensi Pasien -->
                                        <div class="card edukasi-card mb-4">
                                            <div class="card-body">
                                                <h6 class="card-title">16. Preferensi Pasien (Keinginan/Permintaan Pasien)
                                                </h6>
                                                <div class="form-group">
                                                    <label>Detail Preferensi</label>
                                                    <input type="text" class="form-control" name="ket_preferensi_16"
                                                        placeholder="Masukkan preferensi pasien"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'ket_preferensi_16') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal_16"
                                                    value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'tanggal_16') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Sasaran</label>
                                                    <input type="text" class="form-control" name="sasaran_nama_16"
                                                        placeholder="Nama dan hubungan dengan pasien"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'sasaran_nama_16') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Edukator</label>
                                                    <input type="text" class="form-control" name="edukator_nama_16"
                                                        placeholder="Nama & profesi edukator"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'edukator_nama_16') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tingkat Pemahaman Awal</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_16_hal_baru" name="pemahaman_awal_16[]"
                                                            value="hal_baru"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_16', 'hal_baru') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pemahaman_awal_16_hal_baru">Hal
                                                            Baru</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pemahaman_awal_16_edukasi_ulang" name="pemahaman_awal_16[]"
                                                            value="edukasi_ulang"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'pemahaman_awal_16', 'edukasi_ulang') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="pemahaman_awal_16_edukasi_ulang">Edukasi Ulang</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Metode</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="metode_16_lisan"
                                                            name="metode_16[]" value="lisan"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_16', 'lisan') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="metode_16_lisan">Lisan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="metode_16_demonstrasi" name="metode_16[]"
                                                            value="demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'metode_16', 'demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="metode_16_demonstrasi">Demonstrasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Media</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_16_leaflet" name="media_16[]" value="leaflet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_16', 'leaflet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_16_leaflet">Leaflet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_16_booklet" name="media_16[]" value="booklet"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_16', 'booklet') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_16_booklet">Booklet</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="media_16_audiovisual" name="media_16[]" value="audiovisual"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'media_16', 'audiovisual') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="media_16_audiovisual">Audiovisual</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Evaluasi/Edukasi Ulang</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_16_sudah_paham" name="evaluasi_16[]"
                                                            value="sudah_paham"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_16', 'sudah_paham') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="evaluasi_16_sudah_paham">Sudah
                                                            Paham</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_16_re_demonstrasi" name="evaluasi_16[]"
                                                            value="re_demonstrasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_16', 're_demonstrasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_16_re_demonstrasi">Re-demonstrasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="evaluasi_16_re_edukasi" name="evaluasi_16[]"
                                                            value="re_edukasi"
                                                            {{ isExistingChecked($kebutuhanEdukasiLanjutan, 'evaluasi_16', 're_edukasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="evaluasi_16_re_edukasi">Re-edukasi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lama Edukasi</label>
                                                    <input type="text" class="form-control" name="lama_edukasi_16"
                                                        placeholder="Masukkan lama edukasi"
                                                        value="{{ getExistingValue($kebutuhanEdukasiLanjutan, 'lama_edukasi_16') }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .section-separator {
            border-top: 2px solid #097dd6;
            margin: 2rem 0;
            padding-top: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-check {
            margin: 0;
            padding-left: 1.5rem;
            min-height: auto;
        }

        .form-check-input {
            margin-top: 0.3rem;
        }

        .form-check label {
            margin-right: 0;
            padding-top: 0;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        /* Styling untuk kartu edukasi */
        .edukasi-cards {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .edukasi-card {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        .edukasi-card .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .edukasi-card .form-group {
            margin-bottom: 1.5rem;
        }

        .edukasi-card .form-check {
            margin-bottom: 0.5rem;
        }

        .edukasi-card .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .edukasi-card .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 5px rgba(9, 125, 214, 0.3);
        }
    </style>
@endpush

@push('js')
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const penerjemahYa = document.getElementById('penerjemah_ya');
            const penerjemahTidak = document.getElementById('penerjemah_tidak');
            const bahasaInput = document.getElementById('penerjemah_bahasa_input');

            function toggleBahasaInput() {
                bahasaInput.style.display = penerjemahYa.checked ? 'block' : 'none';
            }

            penerjemahYa.addEventListener('change', toggleBahasaInput);
            penerjemahTidak.addEventListener('change', toggleBahasaInput);

            // Initialize state on page load
            toggleBahasaInput();
        });
    </script>
@endpush
