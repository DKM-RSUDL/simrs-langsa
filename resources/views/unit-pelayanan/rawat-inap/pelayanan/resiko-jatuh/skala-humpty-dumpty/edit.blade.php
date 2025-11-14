@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-check.selected {
            background-color: #cfe2ff !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Perbarui Pengkajian Resiko Jatuh - Humpty Dumpty',
                    'description' =>
                        'Perbarui data pengkajian resiko jatuh - humpty dumpty pasien rawat inap dengan mengisi formulir di bawah ini.',
                ])

                <form id="humptyDumptyForm" method="POST"
                    action="{{ route('rawat-inap.resiko-jatuh.humpty-dumpty.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $dataHumptyDumpty->id]) }}">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information Section -->
                    <div class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="tanggal_implementasi" class="form-label">Tanggal Implementasi</label>
                                <input type="date" class="form-control" name="tanggal_implementasi"
                                    id="tanggal_implementasi"
                                    value="{{ date('Y-m-d', strtotime($dataHumptyDumpty->tanggal_implementasi)) }}"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label for="jam_implementasi" class="form-label">Jam Implementasi</label>
                                <input type="time" class="form-control" name="jam_implementasi" id="jam_implementasi"
                                    value="{{ date('H:i', strtotime($dataHumptyDumpty->jam_implementasi)) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="shift" class="form-label">Shift</label>
                                <select class="form-control" id="shift" name="shift" required>
                                    <option value="">Pilih Shift</option>
                                    <option value="PG" {{ $dataHumptyDumpty->shift == 'PG' ? 'selected' : '' }}>
                                        Pagi (PG)
                                    </option>
                                    <option value="SI" {{ $dataHumptyDumpty->shift == 'SI' ? 'selected' : '' }}>
                                        Siang (SI)
                                    </option>
                                    <option value="ML" {{ $dataHumptyDumpty->shift == 'ML' ? 'selected' : '' }}>
                                        Malam (ML)
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Checkbox Enable Penilaian -->
                    <div class="mb-4">
                        <label for="enableResikoJatuh" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" id="enableResikoJatuh">
                            <div class="form-check-label">
                                <strong>Ceklis jika akan membuat penilaian resiko jatuh baru</strong>
                            </div>
                        </label>
                    </div>

                    <!-- Hidden input untuk mode -->
                    <input type="hidden" name="use_existing_assessment" id="use_existing_assessment" value="1">

                    <!-- Hidden inputs untuk data existing (untuk fallback) -->
                    <input type="hidden" name="existing_usia" value="{{ $dataHumptyDumpty->usia }}">
                    <input type="hidden" name="existing_jenis_kelamin" value="{{ $dataHumptyDumpty->jenis_kelamin }}">
                    <input type="hidden" name="existing_diagnosis" value="{{ $dataHumptyDumpty->diagnosis }}">
                    <input type="hidden" name="existing_gangguan_kognitif"
                        value="{{ $dataHumptyDumpty->gangguan_kognitif }}">
                    <input type="hidden" name="existing_faktor_lingkungan"
                        value="{{ $dataHumptyDumpty->faktor_lingkungan }}">
                    <input type="hidden" name="existing_pembedahan_sedasi"
                        value="{{ $dataHumptyDumpty->pembedahan_sedasi }}">
                    <input type="hidden" name="existing_penggunaan_medikamentosa"
                        value="{{ $dataHumptyDumpty->penggunaan_medikamentosa }}">
                    <input type="hidden" name="existing_total_skor" value="{{ $dataHumptyDumpty->total_skor }}">
                    <input type="hidden" name="existing_kategori_risiko" value="{{ $dataHumptyDumpty->kategori_risiko }}">

                    <!-- Assessment Criteria Section -->
                    <div id="penilaianSection" class="form-section" style="display: none;">
                        <h5 class="section-title">Kriteria Penilaian Humpty Dumpty</h5>

                        <div class="form-group">
                            <label class="fw-bold d-block mb-2">1. Usia</label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="usia_1">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="usia_1" name="usia" value="4"
                                            class="form-check-input me-2 assessment-field" data-field="usia"
                                            {{ $dataHumptyDumpty->usia == 4 ? 'checked' : '' }}>
                                        <span>&lt;3 tahun</span>
                                    </div>
                                    <span class="badge bg-primary">4</span>
                                </div>
                            </label>

                            <label class="form-check bg-light p-3 rounded mb-2" for="usia_2">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="usia_2" name="usia" value="3"
                                            class="form-check-input me-2 assessment-field" data-field="usia"
                                            {{ $dataHumptyDumpty->usia == 3 ? 'checked' : '' }}>
                                        <span>3 sampai 7 tahun</span>
                                    </div>
                                    <span class="badge bg-primary">3</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="usia_3">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="usia_3" name="usia" value="2"
                                            class="form-check-input me-2 assessment-field" data-field="usia"
                                            {{ $dataHumptyDumpty->usia == 2 ? 'checked' : '' }}>
                                        <span>7 sampai 13 tahun</span>
                                    </div>
                                    <span class="badge bg-primary">2</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="usia_4">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="usia_4" name="usia" value="1"
                                            class="form-check-input me-2 assessment-field" data-field="usia"
                                            {{ $dataHumptyDumpty->usia == 1 ? 'checked' : '' }}>
                                        <span>&gt;13 tahun</span>
                                    </div>
                                    <span class="badge bg-primary">1</span>
                                </div>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="fw-bold d-block mb-2">2. Jenis Kelamin:</label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="jk_1">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="jk_1" name="jenis_kelamin" value="2"
                                            class="form-check-input me-2 assessment-field" data-field="jenis_kelamin"
                                            {{ $dataHumptyDumpty->jenis_kelamin == 2 ? 'checked' : '' }}>
                                        <span>Laki-laki</span>
                                    </div>
                                    <span class="badge bg-primary">2</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="jk_2">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="jk_2" name="jenis_kelamin" value="1"
                                            class="form-check-input me-2 assessment-field" data-field="jenis_kelamin"
                                            {{ $dataHumptyDumpty->jenis_kelamin == 1 ? 'checked' : '' }}>
                                        <span>Perempuan</span>
                                    </div>
                                    <span class="badge bg-primary">1</span>
                                </div>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="fw-bold d-block mb-2">3. Diagnosis:</label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="diagnosis_1">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="diagnosis_1" name="diagnosis" value="3"
                                            class="form-check-input me-2 assessment-field" data-field="diagnosis"
                                            {{ $dataHumptyDumpty->diagnosis == 3 ? 'checked' : '' }}>
                                        <span>Perubahan oksigenasi (diagnosis respiratorik, dehidrasi, anemia, syncope,
                                            pusing)</span>
                                    </div>
                                    <span class="badge bg-primary">3</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="diagnosis_2">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="diagnosis_2" name="diagnosis" value="2"
                                            class="form-check-input me-2 assessment-field" data-field="diagnosis"
                                            {{ $dataHumptyDumpty->diagnosis == 2 ? 'checked' : '' }}>
                                        <span>Gangguan perilaku / psikiatri</span>
                                    </div>
                                    <span class="badge bg-primary">2</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="diagnosis_3">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="diagnosis_3" name="diagnosis" value="1"
                                            class="form-check-input me-2 assessment-field" data-field="diagnosis"
                                            {{ $dataHumptyDumpty->diagnosis == 1 ? 'checked' : '' }}>
                                        <span>Diagnosis lainnya</span>
                                    </div>
                                    <span class="badge bg-primary">1</span>
                                </div>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="fw-bold d-block mb-2">4. Gangguan Kognitif:</label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="kognitif_1">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="kognitif_1" name="gangguan_kognitif" value="3"
                                            class="form-check-input me-2 assessment-field" data-field="gangguan_kognitif"
                                            {{ $dataHumptyDumpty->gangguan_kognitif == 3 ? 'checked' : '' }}>
                                        <span>Tidak menyadari keterbatasan dirinya</span>
                                    </div>
                                    <span class="badge bg-primary">3</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="kognitif_2">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="kognitif_2" name="gangguan_kognitif" value="2"
                                            class="form-check-input me-2 assessment-field" data-field="gangguan_kognitif"
                                            {{ $dataHumptyDumpty->gangguan_kognitif == 2 ? 'checked' : '' }}>
                                        <span>Lupa akan adanya keterbatasan</span>
                                    </div>
                                    <span class="badge bg-primary">2</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="kognitif_3">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="kognitif_3" name="gangguan_kognitif" value="1"
                                            class="form-check-input me-2 assessment-field" data-field="gangguan_kognitif"
                                            {{ $dataHumptyDumpty->gangguan_kognitif == 1 ? 'checked' : '' }}>
                                        <span>Orientasi baik terhadap diri sendiri</span>
                                    </div>
                                    <span class="badge bg-primary">1</span>
                                </div>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="fw-bold d-block mb-2">5. Faktor Lingkungan:</label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="lingkungan_1">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="lingkungan_1" name="faktor_lingkungan" value="4"
                                            class="form-check-input me-2 assessment-field" data-field="faktor_lingkungan"
                                            {{ $dataHumptyDumpty->faktor_lingkungan == 4 ? 'checked' : '' }}>
                                        <span>Riwayat jatuh / bayi diletakkan di tempat tidur dewasa</span>
                                    </div>
                                    <span class="badge bg-primary">4</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="lingkungan_2">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="lingkungan_2" name="faktor_lingkungan" value="3"
                                            class="form-check-input me-2 assessment-field" data-field="faktor_lingkungan"
                                            {{ $dataHumptyDumpty->faktor_lingkungan == 3 ? 'checked' : '' }}>
                                        <span>Pasien menggunakan alat bantu / bayi diletakkan di tempat tidur bayi /
                                            perabot rumah</span>
                                    </div>
                                    <span class="badge bg-primary">3</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="lingkungan_3">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="lingkungan_3" name="faktor_lingkungan" value="2"
                                            class="form-check-input me-2 assessment-field" data-field="faktor_lingkungan"
                                            {{ $dataHumptyDumpty->faktor_lingkungan == 2 ? 'checked' : '' }}>
                                        <span>Pasien diletakkan di tempat tidur</span>
                                    </div>
                                    <span class="badge bg-primary">2</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="lingkungan_4">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="lingkungan_4" name="faktor_lingkungan" value="1"
                                            class="form-check-input me-2 assessment-field" data-field="faktor_lingkungan"
                                            {{ $dataHumptyDumpty->faktor_lingkungan == 1 ? 'checked' : '' }}>
                                        <span>Area diluar rumah</span>
                                    </div>
                                    <span class="badge bg-primary">1</span>
                                </div>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="fw-bold d-block mb-2">6. Pembedahan/Sedasi/Anestesi:</label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="bedah_1">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="bedah_1" name="pembedahan_sedasi" value="3"
                                            class="form-check-input me-2 assessment-field" data-field="pembedahan_sedasi"
                                            {{ $dataHumptyDumpty->pembedahan_sedasi == 3 ? 'checked' : '' }}>
                                        <span>Dalam 24 jam</span>
                                    </div>
                                    <span class="badge bg-primary">3</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="bedah_2">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="bedah_2" name="pembedahan_sedasi" value="2"
                                            class="form-check-input me-2 assessment-field" data-field="pembedahan_sedasi"
                                            {{ $dataHumptyDumpty->pembedahan_sedasi == 2 ? 'checked' : '' }}>
                                        <span>Dalam 48 jam</span>
                                    </div>
                                    <span class="badge bg-primary">2</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="bedah_3">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="bedah_3" name="pembedahan_sedasi" value="1"
                                            class="form-check-input me-2 assessment-field" data-field="pembedahan_sedasi"
                                            {{ $dataHumptyDumpty->pembedahan_sedasi == 1 ? 'checked' : '' }}>
                                        <span>&gt;48 jam atau tidak menjalani pembedahan/sedasi/anestesi</span>
                                    </div>
                                    <span class="badge bg-primary">1</span>
                                </div>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="fw-bold d-block mb-2">7. Penggunaan Medikamentosa:</label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="obat_1">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="obat_1" name="penggunaan_medikamentosa"
                                            value="3" class="form-check-input me-2 assessment-field"
                                            data-field="penggunaan_medikamentosa"
                                            {{ $dataHumptyDumpty->penggunaan_medikamentosa == 3 ? 'checked' : '' }}>
                                        <span>Penggunaan multiple: sedative, obat hipnosis, barbiturate, fenotiazi,
                                            antidepresan, pencahar, diuretik, narkose</span>
                                    </div>
                                    <span class="badge bg-primary">3</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="obat_2">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="obat_2" name="penggunaan_medikamentosa"
                                            value="2" class="form-check-input me-2 assessment-field"
                                            data-field="penggunaan_medikamentosa"
                                            {{ $dataHumptyDumpty->penggunaan_medikamentosa == 2 ? 'checked' : '' }}>
                                        <span>Penggunaan salah satu obat di atas</span>
                                    </div>
                                    <span class="badge bg-primary">2</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="obat_3">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="obat_3" name="penggunaan_medikamentosa"
                                            value="1" class="form-check-input me-2 assessment-field"
                                            data-field="penggunaan_medikamentosa"
                                            {{ $dataHumptyDumpty->penggunaan_medikamentosa == 1 ? 'checked' : '' }}>
                                        <span>Penggunaan medikasi lainnya/tidak ada medikasi</span>
                                    </div>
                                    <span class="badge bg-primary">1</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Score Display Section -->
                    <div id="scoreDisplay" class="mb-4">
                        <h5 class="mb-3">Hasil Penilaian Resiko Jatuh Humpty Dumpty</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <label class="form-label fw-bold">Skor Total</label>
                                        <p class="form-control-plaintext fs-2 fw-bold" id="totalScore">
                                            {{ $dataHumptyDumpty->total_skor }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <label class="form-label fw-bold">Kategori Risiko</label>
                                        <p class="form-control-plaintext fs-2 fw-bold" id="riskCategory">
                                            {{ $dataHumptyDumpty->kategori_risiko }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden inputs for score -->
                    <input type="hidden" name="total_skor" id="totalScoreInput"
                        value="{{ $dataHumptyDumpty->total_skor }}">
                    <input type="hidden" name="kategori_risiko" id="kategoriRisikoInput"
                        value="{{ $dataHumptyDumpty->kategori_risiko }}">

                    <!-- Intervention Section -->
                    <div class="form-section" id="interventionSection">
                        <h5 class="section-title">Intervensi Pencegahan Jatuh</h5>

                        <!-- Intervensi untuk Risiko Rendah -->
                        <div id="lowRiskInterventions"
                            style="{{ $dataHumptyDumpty->kategori_risiko == 'Risiko Rendah' ? 'display: block;' : 'display: none;' }}">
                            <div class="alert alert-info mb-3">
                                <i class="ti-info-circle"></i> <strong>Intervensi untuk Risiko Rendah</strong>
                            </div>

                            <label for="observasi_ambulasi" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="observasi_ambulasi"
                                        name="observasi_ambulasi" value="1"
                                        {{ $dataHumptyDumpty->observasi_ambulasi ? 'checked' : '' }}>
                                    <span><strong>1. Tingkatkan observasi bantuan yang sesuai saat ambulasi</strong></span>
                                </div>
                            </label>

                            <label for="orientasi_rs" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="orientasi_rs" name="orientasi_rs"
                                    value="1"
                                    {{ $dataHumptyDumpty->orientasi_kamar_mandi || $dataHumptyDumpty->orientasi_bertahap || $dataHumptyDumpty->tempatkan_bel || $dataHumptyDumpty->instruksi_bantuan ? 'checked' : '' }}>
                                <div class="form-check-label">
                                    <strong>2. Orientasikan pasien terhadap lingkungan dan rutinitas RS</strong>
                                    <ul class="mb-0 mt-2" style="list-style-type: none;">
                                        <li>Tunjukkan lokasi kamar mandi</li>
                                        <li>Jika pasien linglung, orientasi dilaksanakan bertahap</li>
                                        <li>Tempatkan bel ditempat yang mudah dicapai</li>
                                        <li>Instruksikan meminta bantuan perawat sebelum turun dari tempat tidur</li>
                                    </ul>
                                </div>
                            </label>

                            <label for="pagar_pengaman" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="pagar_pengaman"
                                        name="pagar_pengaman" value="1"
                                        {{ $dataHumptyDumpty->pagar_pengaman ? 'checked' : '' }}>
                                    <span><strong>3. Pagar pengaman tempat tidur dinaikkan, kaji agar kaki/ tangan tidak
                                            tersangkut</strong></span>
                                </div>
                            </label>

                            <label for="tempat_tidur_rendah" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="tempat_tidur_rendah"
                                        name="tempat_tidur_rendah" value="1"
                                        {{ $dataHumptyDumpty->tempat_tidur_rendah ? 'checked' : '' }}>
                                    <span><strong>4. Tempat tidur dalam posisi rendah dan terkunci</strong></span>
                                </div>
                            </label>

                            <label for="edukasi_perilaku" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="edukasi_perilaku"
                                        name="edukasi_perilaku" value="1"
                                        {{ $dataHumptyDumpty->edukasi_perilaku ? 'checked' : '' }}>
                                    <span><strong>5. Edukasi perilaku yang lebih aman saat jatuh atau
                                            transfer</strong></span>
                                </div>
                            </label>

                            <label for="monitor_berkala" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="monitor_berkala"
                                        name="monitor_berkala" value="1"
                                        {{ $dataHumptyDumpty->monitor_berkala ? 'checked' : '' }}>
                                    <span><strong>6. Monitor kebutuhan pasien secara berkala (minimalnya tiap 2
                                            jam)</strong></span>
                                </div>
                            </label>

                            <label for="anjuran_kaus_kaki" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="anjuran_kaus_kaki"
                                        name="anjuran_kaus_kaki" value="1"
                                        {{ $dataHumptyDumpty->anjuran_kaus_kaki ? 'checked' : '' }}>
                                    <span><strong>7. Anjurkan pasien tidak menggunakan kaus kaki atau sepatu yang
                                            licin</strong></span>
                                </div>
                            </label>

                            <label for="lantai_antislip" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="lantai_antislip"
                                        name="lantai_antislip" value="1"
                                        {{ $dataHumptyDumpty->lantai_antislip ? 'checked' : '' }}>
                                    <span><strong>8. Lantai kamar mandi dengan karpet antislip, tidak licin</strong></span>
                                </div>
                            </label>
                        </div>

                        <!-- Intervensi untuk Risiko Tinggi -->
                        <div id="highRiskInterventions"
                            style="{{ $dataHumptyDumpty->kategori_risiko == 'Risiko Tinggi' ? 'display: block;' : 'display: none;' }}" class="mt-5">
                            <div class="alert alert-danger mb-3">
                                <i class="ti-alert-triangle"></i> <strong>Intervensi untuk Risiko Tinggi</strong>
                            </div>

                            <label for="semua_intervensi_rendah" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="semua_intervensi_rendah"
                                        name="semua_intervensi_rendah" value="1"
                                        {{ $dataHumptyDumpty->semua_intervensi_rendah ? 'checked' : '' }}>
                                    <span><strong>1. Lakukan SEMUA intervensi jatuh resiko rendah / standar</strong></span>
                                </div>
                            </label>

                            <label for="gelang_kuning" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="gelang_kuning"
                                        name="gelang_kuning" value="1"
                                        {{ $dataHumptyDumpty->gelang_kuning ? 'checked' : '' }}>
                                    <span><strong>2. Pakailah gelang risiko jatuh berwarna kuning</strong></span>
                                </div>
                            </label>

                            <label for="pasang_gambar" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="pasang_gambar"
                                        name="pasang_gambar" value="1"
                                        {{ $dataHumptyDumpty->pasang_gambar ? 'checked' : '' }}>
                                    <span><strong>3. Pasang gambar risiko jatuh diatas tempat tidur pasien dan pada pintu
                                            kamar pasien</strong></span>
                                </div>
                            </label>

                            <label for="tanda_daftar_nama" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="tanda_daftar_nama"
                                        name="tanda_daftar_nama" value="1"
                                        {{ $dataHumptyDumpty->tanda_daftar_nama ? 'checked' : '' }}>
                                    <span><strong>4. Beri tanda pada daftar nama pasien dan jadwal kegiatan dengan stiker
                                            atau kode khusus</strong></span>
                                </div>
                            </label>

                            <label for="pertimbangkan_obat" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="pertimbangkan_obat"
                                        name="pertimbangkan_obat" value="1"
                                        {{ $dataHumptyDumpty->pertimbangkan_obat ? 'checked' : '' }}>
                                    <span><strong>5. Pertimbangkan riwayat obat-obatan dan suplemen untuk mengevaluasi
                                            pengobatan</strong></span>
                                </div>
                            </label>

                            <label for="alat_bantu_jalan" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="alat_bantu_jalan"
                                        name="alat_bantu_jalan" value="1"
                                        {{ $dataHumptyDumpty->alat_bantu_jalan ? 'checked' : '' }}>
                                    <span><strong>6. Gunakan alat bantu jalan (walker, handrail)</strong></span>
                                </div>
                            </label>

                            <label for="pintu_terbuka" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="pintu_terbuka"
                                        name="pintu_terbuka" value="1"
                                        {{ $dataHumptyDumpty->pintu_terbuka ? 'checked' : '' }}>
                                    <span><strong>7. Biarkan pintu ruangan terbuka kecuali untuk tujuan
                                            isolasi</strong></span>
                                </div>
                            </label>

                            <label for="jangan_tinggalkan" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="jangan_tinggalkan"
                                        name="jangan_tinggalkan" value="1"
                                        {{ $dataHumptyDumpty->jangan_tinggalkan ? 'checked' : '' }}>
                                    <span><strong>8. Jangan tinggalkan pasien saat di ruangan diagnostic atau
                                            tindakan</strong></span>
                                </div>
                            </label>

                            <label for="dekat_nurse_station" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="dekat_nurse_station"
                                        name="dekat_nurse_station" value="1"
                                        {{ $dataHumptyDumpty->dekat_nurse_station ? 'checked' : '' }}>
                                    <span><strong>9. Penempatan pasien dekat nurse station untuk memudahkan observasi (24-48
                                            jam)</strong></span>
                                </div>
                            </label>

                            <label for="bed_posisi_rendah" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="bed_posisi_rendah"
                                        name="bed_posisi_rendah" value="1"
                                        {{ $dataHumptyDumpty->bed_posisi_rendah ? 'checked' : '' }}>
                                    <span><strong>10. Posisi Bed atur ke posisi paling rendah</strong></span>
                                </div>
                            </label>

                            <label for="edukasi_keluarga" class="form-check bg-light p-3 rounded mb-2">
                                <div class="form-check-label d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="edukasi_keluarga"
                                        name="edukasi_keluarga" value="1"
                                        {{ $dataHumptyDumpty->edukasi_keluarga ? 'checked' : '' }}>
                                    <span><strong>11. Edukasi pasien/ keluarga yang harus diperhatikan sesuai
                                            protokol</strong></span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="text-end">
                        <x-button-submit id="simpan">Perbarui</x-button-submit>
                    </div>
                </form>
            </x-content-card>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            let lastChecked = {}; // Untuk menyimpan radio button yang terakhir diklik

            // Set initial state - populate lastChecked dengan data yang sudah ada
            $('input[type="radio"]:checked').each(function() {
                lastChecked[this.name] = this;
                $(this).closest('label.form-check').addClass('selected');
            });

            // Fungsi untuk menghitung skor dan kategori
            function hitungSkorDanKategori() {
                const groups = [
                    'usia',
                    'jenis_kelamin',
                    'diagnosis',
                    'gangguan_kognitif',
                    'faktor_lingkungan',
                    'pembedahan_sedasi',
                    'penggunaan_medikamentosa'
                ];

                let skor = 0;
                let lengkap = true;

                groups.forEach(name => {
                    const checked = $(`input[name="${name}"]:checked`);
                    if (checked.length === 0) {
                        lengkap = false;
                    }
                    skor += parseInt(checked.val() || '0', 10);
                });

                // Update skor total
                $('#totalScore').text(isNaN(skor) ? 0 : skor);
                $('#totalScoreInput').val(isNaN(skor) ? '' : String(skor));

                // Set kategori Humpty Dumpty (6-11 Rendah, >=12 Tinggi)
                let kategori = '';
                if (lengkap && !isNaN(skor)) {
                    if (skor >= 6 && skor <= 11) {
                        kategori = 'Risiko Rendah';
                    } else if (skor >= 12) {
                        kategori = 'Risiko Tinggi';
                    } else {
                        kategori = 'Skor Tidak Valid';
                    }
                } else {
                    kategori = 'Belum Dinilai';
                }

                // Update tampilan kategori
                $('#riskCategory').text(kategori);
                $('#kategoriRisikoInput').val(kategori);

                // Tampilkan intervensi sesuai kategori
                tampilkanIntervensi(kategori);
            }

            // Fungsi untuk menampilkan intervensi berdasarkan kategori
            function tampilkanIntervensi(kategori) {
                $('#lowRiskInterventions, #highRiskInterventions').hide();

                if (kategori === 'Risiko Rendah') {
                    $('#lowRiskInterventions').show();
                } else if (kategori === 'Risiko Tinggi') {
                    $('#lowRiskInterventions').show();
                    $('#highRiskInterventions').show();
                }
            }

            // Function untuk mengecek duplikasi (exclude current record)
            function checkDuplicateDateTime() {
                const tanggal = $('#tanggal_implementasi').val();
                const shift = $('#shift').val();
                const currentId = '{{ $dataHumptyDumpty->id }}';

                if (tanggal && shift) {
                    $.ajax({
                        url: "{{ route('rawat-inap.resiko-jatuh.humpty-dumpty.check-duplicate', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            tanggal_implementasi: tanggal,
                            shift: shift,
                            exclude_id: currentId
                        },
                        success: function(response) {
                            if (response.exists) {
                                showDuplicateWarning(true);
                                $('#simpan').prop('disabled', true);
                            } else {
                                showDuplicateWarning(false);
                                $('#simpan').prop('disabled', false);
                            }
                        },
                        error: function() {
                            showDuplicateWarning(false);
                            $('#simpan').prop('disabled', false);
                        }
                    });
                } else {
                    showDuplicateWarning(false);
                    $('#simpan').prop('disabled', false);
                }
            }

            // Function untuk menampilkan/menyembunyikan warning
            function showDuplicateWarning(show) {
                if (show) {
                    if ($('#duplicate-warning').length === 0) {
                        const warningHtml = `
                            <div id="duplicate-warning" class="alert alert-warning mt-2" style="border-left: 4px solid #ffc107;">
                                <i class="ti-alert-triangle"></i>
                                <strong>Peringatan:</strong> Data dengan tanggal dan shift ini sudah ada!
                            </div>
                        `;
                        $('#shift').closest('.form-group').after(warningHtml);
                    }
                    $('#duplicate-warning').show();
                } else {
                    $('#duplicate-warning').hide();
                }
            }

            // Event listener untuk radio button dengan fitur uncheck
            $('input[type="radio"][name="usia"], input[type="radio"][name="jenis_kelamin"], input[type="radio"][name="diagnosis"], input[type="radio"][name="gangguan_kognitif"], input[type="radio"][name="faktor_lingkungan"], input[type="radio"][name="pembedahan_sedasi"], input[type="radio"][name="penggunaan_medikamentosa"]')
                .on('click', function(e) {
                    const groupName = $(this).attr('name');

                    // Jika radio button yang sama diklik lagi, uncheck
                    if (lastChecked[groupName] === this && $(this).is(':checked')) {
                        $(this).prop('checked', false);
                        lastChecked[groupName] = null;

                        // Remove selected state dari radio button ini
                        $(this).closest('label.form-check').removeClass('selected');

                        hitungSkorDanKategori();
                        return;
                    }

                    // Simpan radio button yang diklik sebagai yang terakhir
                    lastChecked[groupName] = this;

                    // Update visual selected state hanya untuk grup ini
                    $(`input[name="${groupName}"]`).each(function() {
                        $(this).closest('label.form-check').removeClass('selected');
                    });
                    $(this).closest('label.form-check').addClass('selected');

                    hitungSkorDanKategori();
                });

            // Event listener untuk checkbox enable penilaian
            $('#enableResikoJatuh').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#penilaianSection, #scoreDisplay').show();
                    $('#use_existing_assessment').val('0');

                    // Hitung skor dari radio button yang ter-check
                    hitungSkorDanKategori();
                } else {
                    $('#penilaianSection').hide();
                    $('#scoreDisplay').show();
                    $('#use_existing_assessment').val('1');

                    // Reset semua radio button
                    $('input[type="radio"]').prop('checked', false);
                    // Reset visual state
                    $('label.form-check').removeClass('selected');
                    lastChecked = {};

                    // Gunakan data existing untuk hasil
                    const existingTotal = $('input[name="existing_total_skor"]').val();
                    const existingKategori = $('input[name="existing_kategori_risiko"]').val();

                    $('#totalScore').text(existingTotal || '0');
                    $('#riskCategory').text(existingKategori || 'Belum Dinilai');
                    $('#totalScoreInput').val(existingTotal);
                    $('#kategoriRisikoInput').val(existingKategori);

                    tampilkanIntervensi(existingKategori);
                }
            });

            // Form validation
            $('#humptyDumptyForm').on('submit', function(e) {
                let isValid = true;
                let errorMessage = '';

                const requiredFields = [{
                        element: $('#tanggal_implementasi'),
                        name: 'Tanggal Implementasi'
                    },
                    {
                        element: $('#jam_implementasi'),
                        name: 'Jam Implementasi'
                    },
                    {
                        element: $('#shift'),
                        name: 'Shift'
                    }
                ];

                requiredFields.forEach(function(field) {
                    if (!field.element.val()) {
                        isValid = false;
                        field.element.addClass('is-invalid');
                        errorMessage += '- ' + field.name + '\n';
                    } else {
                        field.element.removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi field berikut:\n' + errorMessage);
                    return false;
                }

                return true;
            });

            // Remove invalid class on input
            $('input, select').on('input change', function() {
                $(this).removeClass('is-invalid');
            });

            // Event listeners untuk tanggal dan shift
            $('#tanggal_implementasi, #shift').on('change', function() {
                checkDuplicateDateTime();
            });

            // Handle checkbox intervensi
            $('input[type="checkbox"]').on('change', function() {
                // Skip checkbox enable penilaian
                if ($(this).attr('id') === 'enableResikoJatuh') return;

                const formCheck = $(this).closest('.form-check');
                if ($(this).is(':checked')) {
                    formCheck.addClass('selected');
                } else {
                    formCheck.removeClass('selected');
                }
            });

            // Set initial visual state berdasarkan data yang sudah ada
            $('input[type="radio"]:checked').each(function() {
                $(this).closest('label.form-check').addClass('selected');
                lastChecked[$(this).attr('name')] = this;
            });

            $('input[type="checkbox"]:checked').each(function() {
                if ($(this).attr('id') !== 'enableResikoJatuh') {
                    $(this).closest('.form-check').addClass('selected');
                }
            });

            // Inisialisasi
            const totalScoreInput = $('#totalScoreInput').val();
            const kategoriInput = $('#kategoriRisikoInput').val();

            console.log('Init - totalScoreInput:', totalScoreInput);
            console.log('Init - kategoriInput:', kategoriInput);

            // Set nilai awal berdasarkan data dari database
            if (totalScoreInput && kategoriInput) {
                $('#totalScore').text(totalScoreInput);
                $('#riskCategory').text(kategoriInput);
                tampilkanIntervensi(kategoriInput);
                $('#scoreDisplay').show();

                // Jangan check checkbox secara default, biarkan user memilih
                $('#enableResikoJatuh').prop('checked', false);
                $('#penilaianSection').hide();

                // Set use_existing_assessment ke 1 karena menggunakan data existing
                $('#use_existing_assessment').val('1');

                // Pastikan checkbox intervensi yang sudah ada ter-check
                $('input[type="checkbox"]:checked').each(function() {
                    $(this).closest('.form-check').addClass('selected');
                });
            } else {
                // Jika tidak ada data, hitung dari penilaian
                hitungSkorDanKategori();
                $('#enableResikoJatuh').prop('checked', true);
                $('#penilaianSection, #scoreDisplay').show();
                $('#use_existing_assessment').val('0');
            }
        });
    </script>
@endpush
