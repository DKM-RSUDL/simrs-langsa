@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-morse.include')
@include('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-morse.include-edit')

@section('content')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ route('rawat-inap.resiko-jatuh.morse.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                class="btn btn-outline-primary resiko_jatuh__btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form id="resikoJatuh_form" method="POST"
                action="{{ route('rawat-inap.resiko-jatuh.morse.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $skalaMorse->id]) }}">
                @csrf
                @method('PUT')

                <div class="resiko_jatuh__fade-in">
                    <div class="resiko_jatuh__header-asesmen text-center">
                        <h4 class="mb-2">
                            <i class="ti-pencil mr-2"></i>
                            EDIT PENGKAJIAN RESIKO JATUH - SKALA MORSE
                        </h4>
                        <small>DEWASA (19 - 59 Tahun)</small>
                    </div>

                    <!-- Data Dasar -->
                    <div class="resiko_jatuh__section-separator">
                        <h5><i class="ti-calendar mr-2"></i> Data Pengkajian</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group resiko_jatuh__form-group">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control resiko_jatuh__form-control" name="tanggal" id="tanggal"
                                        value="{{ old('tanggal', date('Y-m-d', strtotime($skalaMorse->tanggal))) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group resiko_jatuh__form-group">
                                    <label>Hari ke</label>
                                    <input type="number" class="form-control resiko_jatuh__form-control" name="hari_ke"
                                        min="1" placeholder="Masukkan hari ke..." value="{{ old('hari_ke', $skalaMorse->hari_ke) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group resiko_jatuh__form-group">
                                    <label>Shift</label>
                                    <select class="form-control resiko_jatuh__form-control" name="shift" id="shift" required>
                                        <option value="">Pilih Shift</option>
                                        <option value="PG" {{ old('shift', $skalaMorse->shift) == 'PG' ? 'selected' : '' }}>🌅 Pagi (PG)</option>
                                        <option value="SI" {{ old('shift', $skalaMorse->shift) == 'SI' ? 'selected' : '' }}>☀️ Siang (SI)</option>
                                        <option value="ML" {{ old('shift', $skalaMorse->shift) == 'ML' ? 'selected' : '' }}>🌙 Malam (ML)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Penilaian Resiko Jatuh -->
                    <div class="resiko_jatuh__section-separator">
                        <h5><i class="ti-list-ol mr-2"></i>PENILAIAN RESIKO JATUH (SKALA MORSE)</h5>

                        <!-- Riwayat Jatuh -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">1. Riwayat Jatuh:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check {{ old('riwayat_jatuh', $skalaMorse->riwayat_jatuh) == '0' ? 'selected' : '' }}" data-group="riwayat_jatuh">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="riwayat_jatuh" id="resikoJatuh_riwayat_tidak" value="0"
                                    {{ old('riwayat_jatuh', $skalaMorse->riwayat_jatuh) == '0' ? 'checked' : '' }} required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_riwayat_tidak">
                                    a. Tidak
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check {{ old('riwayat_jatuh', $skalaMorse->riwayat_jatuh) == '25' ? 'selected' : '' }}" data-group="riwayat_jatuh">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="riwayat_jatuh" id="resikoJatuh_riwayat_ya" value="25"
                                    {{ old('riwayat_jatuh', $skalaMorse->riwayat_jatuh) == '25' ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_riwayat_ya">
                                    b. Ya
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        25</span>
                                </label>
                            </div>
                        </div>

                        <!-- Diagnosa Sekunder -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">2. Diagnosa Sekunder:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check {{ old('diagnosa_sekunder', $skalaMorse->diagnosa_sekunder) == '0' ? 'selected' : '' }}" data-group="diagnosa_sekunder">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="diagnosa_sekunder" id="resikoJatuh_diagnosa_tidak" value="0"
                                    {{ old('diagnosa_sekunder', $skalaMorse->diagnosa_sekunder) == '0' ? 'checked' : '' }} required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_diagnosa_tidak">
                                    a. Tidak
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check {{ old('diagnosa_sekunder', $skalaMorse->diagnosa_sekunder) == '15' ? 'selected' : '' }}" data-group="diagnosa_sekunder">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="diagnosa_sekunder" id="resikoJatuh_diagnosa_ya" value="15"
                                    {{ old('diagnosa_sekunder', $skalaMorse->diagnosa_sekunder) == '15' ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_diagnosa_ya">
                                    b. Ya
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        15</span>
                                </label>
                            </div>
                        </div>

                        <!-- Bantuan Ambulasi -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">3. Bantuan Ambulasi:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check {{ old('bantuan_ambulasi', $skalaMorse->bantuan_ambulasi) == '0' ? 'selected' : '' }}" data-group="bantuan_ambulasi">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="bantuan_ambulasi" id="resikoJatuh_ambulasi_tidak" value="0"
                                    {{ old('bantuan_ambulasi', $skalaMorse->bantuan_ambulasi) == '0' ? 'checked' : '' }} required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_ambulasi_tidak">
                                    a. Tidak ada / bed rest / bantuan perawat
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check {{ old('bantuan_ambulasi', $skalaMorse->bantuan_ambulasi) == '15' ? 'selected' : '' }}" data-group="bantuan_ambulasi">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="bantuan_ambulasi" id="resikoJatuh_ambulasi_kruk" value="15"
                                    {{ old('bantuan_ambulasi', $skalaMorse->bantuan_ambulasi) == '15' ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_ambulasi_kruk">
                                    b. Kruk / tongkat / alat bantu berjalan
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        15</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check {{ old('bantuan_ambulasi', $skalaMorse->bantuan_ambulasi) == '30' ? 'selected' : '' }}" data-group="bantuan_ambulasi">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="bantuan_ambulasi" id="resikoJatuh_ambulasi_meja" value="30"
                                    {{ old('bantuan_ambulasi', $skalaMorse->bantuan_ambulasi) == '30' ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_ambulasi_meja">
                                    c. Meja / kursi
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        30</span>
                                </label>
                            </div>
                        </div>

                        <!-- Terpasang Infus -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">4. Terpasang Infus:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check {{ old('terpasang_infus', $skalaMorse->terpasang_infus) == '0' ? 'selected' : '' }}" data-group="terpasang_infus">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="terpasang_infus" id="resikoJatuh_infus_tidak" value="0"
                                    {{ old('terpasang_infus', $skalaMorse->terpasang_infus) == '0' ? 'checked' : '' }} required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_infus_tidak">
                                    a. Tidak
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check {{ old('terpasang_infus', $skalaMorse->terpasang_infus) == '20' ? 'selected' : '' }}" data-group="terpasang_infus">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="terpasang_infus" id="resikoJatuh_infus_ya" value="20"
                                    {{ old('terpasang_infus', $skalaMorse->terpasang_infus) == '20' ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_infus_ya">
                                    b. Ya
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        20</span>
                                </label>
                            </div>
                        </div>

                        <!-- Cara/Gaya Berjalan -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">5. Cara / gaya berjalan:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check {{ old('gaya_berjalan', $skalaMorse->gaya_berjalan) == '0' ? 'selected' : '' }}" data-group="gaya_berjalan">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="gaya_berjalan" id="resikoJatuh_berjalan_normal" value="0"
                                    {{ old('gaya_berjalan', $skalaMorse->gaya_berjalan) == '0' ? 'checked' : '' }} required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_berjalan_normal">
                                    a. Normal / bed rest / kursi roda
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check {{ old('gaya_berjalan', $skalaMorse->gaya_berjalan) == '10' ? 'selected' : '' }}" data-group="gaya_berjalan">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="gaya_berjalan" id="resikoJatuh_berjalan_lemah" value="10"
                                    {{ old('gaya_berjalan', $skalaMorse->gaya_berjalan) == '10' ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_berjalan_lemah">
                                    b. Lemah
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        10</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check {{ old('gaya_berjalan', $skalaMorse->gaya_berjalan) == '20' ? 'selected' : '' }}" data-group="gaya_berjalan">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="gaya_berjalan" id="resikoJatuh_berjalan_terganggu" value="20"
                                    {{ old('gaya_berjalan', $skalaMorse->gaya_berjalan) == '20' ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_berjalan_terganggu">
                                    c. Terganggu
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        20</span>
                                </label>
                            </div>
                        </div>

                        <!-- Status Mental -->
                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold">6. Status Mental:</label>
                            <div class="form-check resiko_jatuh__criteria-form-check {{ old('status_mental', $skalaMorse->status_mental) == '0' ? 'selected' : '' }}" data-group="status_mental">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="status_mental" id="resikoJatuh_mental_orientasi" value="0"
                                    {{ old('status_mental', $skalaMorse->status_mental) == '0' ? 'checked' : '' }} required>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_mental_orientasi">
                                    a. Berorientasi pada kemampuannya
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        0</span>
                                </label>
                            </div>
                            <div class="form-check resiko_jatuh__criteria-form-check {{ old('status_mental', $skalaMorse->status_mental) == '15' ? 'selected' : '' }}" data-group="status_mental">
                                <input class="form-check-input resiko_jatuh__criteria-form-check-input" type="radio"
                                    name="status_mental" id="resikoJatuh_mental_lupa" value="15"
                                    {{ old('status_mental', $skalaMorse->status_mental) == '15' ? 'checked' : '' }}>
                                <label class="form-check-label resiko_jatuh__criteria-form-check-label"
                                    for="resikoJatuh_mental_lupa">
                                    b. Lupa akan keterbatasannya
                                    <span
                                        class="badge resiko_jatuh__badge resiko_jatuh__badge-info resiko_jatuh__score-badge">Skor:
                                        15</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Hasil Skor -->
                    <div class="resiko_jatuh__section-separator">
                        <h5><i class="ti-stats-up mr-2"></i>Hasil Penilaian</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card resiko_jatuh__card resiko_jatuh__result-card bg-light">
                                    <div class="card-body">
                                        <h5>SKOR TOTAL</h5>
                                        <div id="resikoJatuh_skorTotal" class="resiko_jatuh__score-total">{{ old('skor_total', $skalaMorse->skor_total) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card resiko_jatuh__card resiko_jatuh__result-card
                                    @switch(old('kategori_resiko', $skalaMorse->kategori_resiko))
                                        @case('RR') bg-success text-white @break
                                        @case('RS') bg-warning text-dark @break
                                        @case('RT') bg-danger text-white @break
                                    @endswitch" id="resikoJatuh_hasilResiko">
                                    <div class="card-body">
                                        <h5>Kategori Resiko</h5>
                                        <h4 id="resikoJatuh_kategoriResiko">
                                            @switch(old('kategori_resiko', $skalaMorse->kategori_resiko))
                                                @case('RR') RESIKO RENDAH (RR) @break
                                                @case('RS') RESIKO SEDANG (RS) @break
                                                @case('RT') RESIKO TINGGI (RT) @break
                                                @default Belum Dinilai
                                            @endswitch
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="skor_total" id="resikoJatuh_skorTotalInput" value="{{ old('skor_total', $skalaMorse->skor_total) }}">
                        <input type="hidden" name="kategori_resiko" id="resikoJatuh_kategoriResikoInput" value="{{ old('kategori_resiko', $skalaMorse->kategori_resiko) }}">
                    </div>

                    @php
                        // Mendapatkan data intervensi yang sudah tersimpan
                        $intervensiRR = $skalaMorse->intervensi_rr ?? [];
                        $intervensiRS = $skalaMorse->intervensi_rs ?? [];
                        $intervensiRT = $skalaMorse->intervensi_rt ?? [];

                        // Pastikan dalam format array
                        if (is_string($intervensiRR)) {
                            $intervensiRR = json_decode($intervensiRR, true) ?? [];
                        }
                        if (is_string($intervensiRS)) {
                            $intervensiRS = json_decode($intervensiRS, true) ?? [];
                        }
                        if (is_string($intervensiRT)) {
                            $intervensiRT = json_decode($intervensiRT, true) ?? [];
                        }

                        $currentKategori = old('kategori_resiko', $skalaMorse->kategori_resiko);
                    @endphp

                    <!-- INTERVENSI RESIKO RENDAH (RR) -->
                    <div class="resiko_jatuh__section-separator resiko_jatuh__intervensi-rr" id="resikoJatuh_intervensiRR"
                         style="display: {{ $currentKategori == 'RR' ? 'block' : 'none' }};">
                        <h5><i class="ti-shield mr-2"></i> INTERVENSI PENCEGAHAN JATUH - RESIKO RENDAH/STANDAR (RR)</h5>

                        <div class="alert alert-success">
                            <strong><i class="ti-info-alt mr-2"></i>INFORMASI:</strong>
                            Beri tanda cek (√) pada tindakan yang dilakukan <br>
                            1. RT: intervensi setiap shift dan dinilai ulang setiap 2 hari) <br>
                            2. RS: intervensi setiap pagi dan dinilai ulang tiap 3 hari) <br>
                            3. RR: intervensi setiap pagi dan dinilai ulang tiap 3 hari )
                        </div>

                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold text-success">
                                <i class="ti-list mr-2"></i>Pilih Intervensi yang Akan Dilakukan:
                            </label>

                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('tingkatkan_observasi', old('intervensi_rr', $intervensiRR)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_1"
                                    value="tingkatkan_observasi" {{ in_array('tingkatkan_observasi', old('intervensi_rr', $intervensiRR)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rr_intervensi_1">
                                    <strong>1. Tingkatkan observasi bantuan yang sesuai saat ambulasi</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('orientasi_pasien', old('intervensi_rr', $intervensiRR)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_2"
                                    value="orientasi_pasien" {{ in_array('orientasi_pasien', old('intervensi_rr', $intervensiRR)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rr_intervensi_2">
                                    <strong>2. Orientasikan pasien terhadap lingkungan dan rutinitas RS:</strong>
                                    <ul class="mt-2 ml-3" style="font-size: 13px;">
                                        <li>a. Tunjukkan lokasi kamar mandi</li>
                                        <li>b. Jika pasien linglung, orientasi dilaksanakan bertahap</li>
                                        <li>c. Tempatkan bel ditempat yang mudah dicapai</li>
                                        <li>d. Instruksikan meminta bantuan perawat sebelum turun dari tempat tidur</li>
                                    </ul>
                                </label>
                            </div>

                            <!-- Continue dengan checkbox lainnya yang sudah ada sebelumnya -->
                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('pagar_pengaman', old('intervensi_rr', $intervensiRR)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_3"
                                    value="pagar_pengaman" {{ in_array('pagar_pengaman', old('intervensi_rr', $intervensiRR)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rr_intervensi_3">
                                    <strong>3. Pagar pengaman tempat tidur dinaikkan</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('tempat_tidur_rendah', old('intervensi_rr', $intervensiRR)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_4"
                                    value="tempat_tidur_rendah" {{ in_array('tempat_tidur_rendah', old('intervensi_rr', $intervensiRR)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rr_intervensi_4">
                                    <strong>4. Tempat tidur dalam posisi rendah terkunci</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('edukasi_perilaku', old('intervensi_rr', $intervensiRR)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_5"
                                    value="edukasi_perilaku" {{ in_array('edukasi_perilaku', old('intervensi_rr', $intervensiRR)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rr_intervensi_5">
                                    <strong>5. Edukasi perilaku yang lebih aman saat jatuh atau transfer</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('monitor_kebutuhan_pasien', old('intervensi_rr', $intervensiRR)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_6"
                                    value="monitor_kebutuhan_pasien" {{ in_array('monitor_kebutuhan_pasien', old('intervensi_rr', $intervensiRR)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rr_intervensi_6">
                                    <strong>6. Monitor kebutuhan pasien secara berkala (minimalnya tiap 2 jam)</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('anjurkan_tidak_menggunakan_kaus', old('intervensi_rr', $intervensiRR)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_7"
                                    value="anjurkan_tidak_menggunakan_kaus" {{ in_array('anjurkan_tidak_menggunakan_kaus', old('intervensi_rr', $intervensiRR)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rr_intervensi_7">
                                    <strong>7. Anjurkan pasien tidak menggunakan kaus kaki atau sepatu yang licin</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('lantai_kamar_mandi', old('intervensi_rr', $intervensiRR)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_8"
                                    value="lantai_kamar_mandi" {{ in_array('lantai_kamar_mandi', old('intervensi_rr', $intervensiRR)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rr_intervensi_8">
                                    <strong>8. Lantai kamar mandi dengan karpet antislip, tidak licin</strong>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- INTERVENSI RESIKO SEDANG (RS) -->
                    <div class="resiko_jatuh__section-separator resiko_jatuh__intervensi-rs" id="resikoJatuh_intervensiRS"
                         style="display: {{ $currentKategori == 'RS' ? 'block' : 'none' }};">
                        <h5><i class="ti-alert mr-2"></i>INTERVENSI PENCEGAHAN JATUH - RESIKO SEDANG (RS)</h5>

                        <div class="alert alert-warning">
                            <strong><i class="ti-info-alt mr-2"></i>PERHATIAN:</strong>
                            Beri tanda cek (√) pada tindakan yang dilakukan <br>
                            1. RT: intervensi setiap shift dan dinilai ulang setiap 2 hari) <br>
                            2. RS: intervensi setiap pagi dan dinilai ulang tiap 3 hari) <br>
                            3. RR: intervensi setiap pagi dan dinilai ulang tiap 3 hari )
                        </div>

                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold text-warning">
                                <i class="ti-list mr-2"></i>Pilih Intervensi yang Akan Dilakukan:
                            </label>

                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('lakukan_semua_intervensi_rendah', old('intervensi_rs', $intervensiRS)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_1"
                                    value="lakukan_semua_intervensi_rendah" {{ in_array('lakukan_semua_intervensi_rendah', old('intervensi_rs', $intervensiRS)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rs_intervensi_1">
                                    <strong>1. Lakukan <span class="text-bold">SEMUA</span> intervensi jatuh resiko rendah /
                                        standar</strong>
                                </label>
                            </div>

                            <!-- Continue dengan checkbox RS lainnya... -->
                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('pakai_gelang_risiko', old('intervensi_rs', $intervensiRS)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_2"
                                    value="pakai_gelang_risiko" {{ in_array('pakai_gelang_risiko', old('intervensi_rs', $intervensiRS)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rs_intervensi_2">
                                    <strong>2. Pakailah gelang risiko jatuh berwarna kuning</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('pasang_gambar_risiko', old('intervensi_rs', $intervensiRS)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_3"
                                    value="pasang_gambar_risiko" {{ in_array('pasang_gambar_risiko', old('intervensi_rs', $intervensiRS)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rs_intervensi_3">
                                    <strong>3. Pasang gambar risiko jatuh diatas tempat tidur pasien dan pada pintu kamar
                                        pasien</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('tempatkan_risiko_jatuh', old('intervensi_rs', $intervensiRS)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_4"
                                    value="tempatkan_risiko_jatuh" {{ in_array('tempatkan_risiko_jatuh', old('intervensi_rs', $intervensiRS)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rs_intervensi_4">
                                    <strong>4. Tempatkan tanda resiko pasien jatuh pada daftar nama pasien (warna
                                        kuning)</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('pertimbangkan_riwayat_obat', old('intervensi_rs', $intervensiRS)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_5"
                                    value="pertimbangkan_riwayat_obat" {{ in_array('pertimbangkan_riwayat_obat', old('intervensi_rs', $intervensiRS)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rs_intervensi_5">
                                    <strong>5. Pertimbangkan riwayat obat-obatan dan suplemen untuk mengevaluasi
                                        pengobatan</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('gunakan_alat_bantu', old('intervensi_rs', $intervensiRS)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_6"
                                    value="gunakan_alat_bantu" {{ in_array('gunakan_alat_bantu', old('intervensi_rs', $intervensiRS)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rs_intervensi_6">
                                    <strong>6. Gunakan alat bantu jalan (walker, handrail)</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('dorong_partisipasi_keluarga', old('intervensi_rs', $intervensiRS)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_7"
                                    value="dorong_partisipasi_keluarga" {{ in_array('dorong_partisipasi_keluarga', old('intervensi_rs', $intervensiRS)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rs_intervensi_7">
                                    <strong>7. Dorong partisipasi keluarga dalam keselamatan pasien</strong>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- INTERVENSI RESIKO TINGGI (RT) -->
                    <div class="resiko_jatuh__section-separator resiko_jatuh__intervensi-rt" id="resikoJatuh_intervensiRT"
                         style="display: {{ $currentKategori == 'RT' ? 'block' : 'none' }};">
                        <h5><i class="ti-alert mr-2"></i>INTERVENSI PENCEGAHAN JATUH - RESIKO TINGGI (RT)</h5>

                        <div class="alert alert-danger">
                            <strong><i class="ti-info-alt mr-2"></i>PERHATIAN:</strong>
                            Beri tanda cek (√) pada tindakan yang dilakukan <br>
                            1. RT: intervensi setiap shift dan dinilai ulang setiap 2 hari) <br>
                            2. RS: intervensi setiap pagi dan dinilai ulang tiap 3 hari) <br>
                            3. RR: intervensi setiap pagi dan dinilai ulang tiap 3 hari )
                        </div>

                        <div class="resiko_jatuh__criteria-section">
                            <label class="resiko_jatuh__font-weight-bold text-danger">
                                <i class="ti-shield mr-2"></i>Pilih Intervensi yang Akan Dilakukan:
                            </label>

                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('lakukan_semua_intervensi', old('intervensi_rt', $intervensiRT)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rt[]" id="rt_intervensi_1"
                                    value="lakukan_semua_intervensi" {{ in_array('lakukan_semua_intervensi', old('intervensi_rt', $intervensiRT)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rt_intervensi_1">
                                    <strong>1. Lakukan <span class="text-bold">SEMUA</span> intervensi jatuh resiko rendah /
                                        standar dan resiko sedang</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('jangan_tinggalkan_pasien', old('intervensi_rt', $intervensiRT)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rt[]" id="rt_intervensi_2"
                                    value="jangan_tinggalkan_pasien" {{ in_array('jangan_tinggalkan_pasien', old('intervensi_rt', $intervensiRT)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rt_intervensi_2">
                                    <strong>2. Jangan tinggalkan pasien saat di ruangan diagnostic atau tindakan</strong>
                                </label>
                            </div>

                            <div class="form-check resiko_jatuh__criteria-form-check {{ in_array('penempatan_dekat_nurse_station', old('intervensi_rt', $intervensiRT)) ? 'selected' : '' }}">
                                <input class="form-check-input" type="checkbox" name="intervensi_rt[]" id="rt_intervensi_3"
                                    value="penempatan_dekat_nurse_station" {{ in_array('penempatan_dekat_nurse_station', old('intervensi_rt', $intervensiRT)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="rt_intervensi_3">
                                    <strong>3. Penempatan pasien dekat nurse station untuk memudahkan observasi (24-48
                                        jam)</strong>
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-success resiko_jatuh__btn-primary" id="resikoJatuh_simpan">
                            <i class="ti-save mr-2"></i> Update Data
                        </button>
                    </div>
                </div>
            </form>

            <!-- Keterangan -->
            <div class="resiko_jatuh__section-separator mt-3">
                <h5><i class="ti-info mr-2"></i> Keterangan</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="resiko_jatuh__keterangan-box">
                            <h6 class="resiko_jatuh__keterangan-title"><strong>Keterangan :</strong></h6>
                            <ul class="resiko_jatuh__keterangan-list">
                                <li>
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-success mr-2">RR</span>
                                    <strong>Resiko Rendah (0 - 24)</strong>
                                </li>
                                <li>
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-warning mr-2">RS</span>
                                    <strong>Resiko Sedang (25 - 44)</strong>
                                </li>
                                <li>
                                    <span class="badge resiko_jatuh__badge resiko_jatuh__badge-danger mr-2">RT</span>
                                    <strong>Resiko Tinggi (45 dan lebih)</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="resiko_jatuh__keterangan-box">
                            <h6 class="resiko_jatuh__keterangan-title"><strong>Pengkajian resiko jatuh dilakukan pada waktu
                                    :</strong></h6>
                            <ul class="resiko_jatuh__keterangan-list">
                                <li>
                                    <strong>a.</strong> Saat pasien masuk RS / Initial Assessment (IA)
                                </li>
                                <li>
                                    <strong>b.</strong> Saat kondisi pasien berubah atau ada suatu perubahan dalam terapi
                                    medik yang dapat resiko jatuh / Change Of Condition (CC)
                                </li>
                                <li>
                                    <strong>c.</strong> Saat pasien dipindahkan ke Unit lain / on Ward Transfer (WT)
                                </li>
                                <li>
                                    <strong>d.</strong> Setelah kejadian jatuh / Post Fall (PF)
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

