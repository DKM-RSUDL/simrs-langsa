@extends('layouts.administrator.master')

@push('css')
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
                    'title' => 'Tambah Pengkajian Resiko Jatuh - Humpty Dumpty',
                    'description' =>
                        'Tambah data pengkajian resiko jatuh - humpty dumpty pasien rawat inap dengan mengisi formulir di bawah ini.',
                ])
                <form id="humptyDumptyForm" method="POST"
                    action="{{ route('rawat-inap.resiko-jatuh.humpty-dumpty.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                    @csrf

                    <!-- Basic Information Section -->
                    <div class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal_implementasi"
                                    id="tanggal_implementasi"
                                    value="{{ old('tanggal_implementasi', now()->format('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Hari ke<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="hari_ke" name="hari_ke"
                                    value="{{ old('hari_ke') }}" min="1" placeholder="Masukkan hari ke..." required>
                            </div>
                            <div class="col-md-4">
                                <label for="shift" class="form-label">Shift</label>
                                <select class="form-control" id="shift" name="shift" required>
                                    <option value="">Pilih Shift</option>
                                    <option value="PG" {{ old('shift') == 'PG' ? 'selected' : '' }}>Pagi</option>
                                    <option value="SI" {{ old('shift') == 'SI' ? 'selected' : '' }}>Siang</option>
                                    <option value="ML" {{ old('shift') == 'ML' ? 'selected' : '' }}>Malam</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Checkbox Enable Penilaian -->
                    <div class="mb-4">
                        <label for="enableResikoJatuh" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" id="enableResikoJatuh"
                                {{ !isset($lastAssessment) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                Ceklis jika akan membuat penilaian resiko jatuh
                            </div>
                        </label>
                    </div>

                    @if (isset($lastAssessment))
                        <!-- Hidden inputs untuk data penilaian existing -->
                        <input type="hidden" name="use_existing_assessment" id="use_existing_assessment" value="1">
                        <input type="hidden" name="existing_usia" value="{{ $lastAssessment->usia }}">
                        <input type="hidden" name="existing_jenis_kelamin" value="{{ $lastAssessment->jenis_kelamin }}">
                        <input type="hidden" name="existing_diagnosis" value="{{ $lastAssessment->diagnosis }}">
                        <input type="hidden" name="existing_gangguan_kognitif"
                            value="{{ $lastAssessment->gangguan_kognitif }}">
                        <input type="hidden" name="existing_faktor_lingkungan"
                            value="{{ $lastAssessment->faktor_lingkungan }}">
                        <input type="hidden" name="existing_pembedahan_sedasi"
                            value="{{ $lastAssessment->pembedahan_sedasi }}">
                        <input type="hidden" name="existing_penggunaan_medikamentosa"
                            value="{{ $lastAssessment->penggunaan_medikamentosa }}">
                        <input type="hidden" name="existing_total_skor" value="{{ $lastAssessment->total_skor }}">
                        <input type="hidden" name="existing_kategori_risiko"
                            value="{{ $lastAssessment->kategori_risiko }}">
                    @else
                        <input type="hidden" name="use_existing_assessment" id="use_existing_assessment" value="0">
                    @endif

                    <!-- Assessment Criteria Section -->
                    <div id="penilaianSection" class="form-section"
                        style="display: {{ !isset($lastAssessment) ? 'block' : 'none' }};">
                        <h5 class="section-title">Kriteria Penilaian Humpty Dumpty</h5>

                        <div class="form-group">
                            <label class="fw-bold d-block mb-2">1. Usia</label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="usia_1">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="usia_1" name="usia" value="4"
                                            class="form-check-input me-2 assessment-field" data-field="usia">
                                        <span>&lt;3 tahun</span>
                                    </div>
                                    <span class="badge bg-primary">4</span>
                                </div>
                            </label>

                            <label class="form-check bg-light p-3 rounded mb-2" for="usia_2">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="usia_2" name="usia" value="3"
                                            class="form-check-input me-2 assessment-field" data-field="usia">
                                        <span>3 sampai 7 tahun</span>
                                    </div>
                                    <span class="badge bg-primary">3</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="usia_3">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="usia_3" name="usia" value="2"
                                            class="form-check-input me-2 assessment-field" data-field="usia">
                                        <span>7 sampai 13 tahun</span>
                                    </div>
                                    <span class="badge bg-primary">2</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="usia_4">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="usia_4" name="usia" value="1"
                                            class="form-check-input me-2 assessment-field" data-field="usia">
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
                                            class="form-check-input me-2 assessment-field" data-field="jenis_kelamin">
                                        <span>Laki-laki</span>
                                    </div>
                                    <span class="badge bg-primary">2</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="jk_2">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="jk_2" name="jenis_kelamin" value="1"
                                            class="form-check-input me-2 assessment-field" data-field="jenis_kelamin">
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
                                            class="form-check-input me-2 assessment-field" data-field="diagnosis">
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
                                            class="form-check-input me-2 assessment-field" data-field="diagnosis">
                                        <span>Gangguan perilaku / psikiatri</span>
                                    </div>
                                    <span class="badge bg-primary">2</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="diagnosis_3">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="diagnosis_3" name="diagnosis" value="1"
                                            class="form-check-input me-2 assessment-field" data-field="diagnosis">
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
                                            class="form-check-input me-2 assessment-field" data-field="gangguan_kognitif">
                                        <span>Tidak menyadari keterbatasan dirinya</span>
                                    </div>
                                    <span class="badge bg-primary">3</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="kognitif_2">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="kognitif_2" name="gangguan_kognitif" value="2"
                                            class="form-check-input me-2 assessment-field" data-field="gangguan_kognitif">
                                        <span>Lupa akan adanya keterbatasan</span>
                                    </div>
                                    <span class="badge bg-primary">2</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="kognitif_3">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="kognitif_3" name="gangguan_kognitif" value="1"
                                            class="form-check-input me-2 assessment-field" data-field="gangguan_kognitif">
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
                                            class="form-check-input me-2 assessment-field" data-field="faktor_lingkungan">
                                        <span>Riwayat jatuh / bayi diletakkan di tempat tidur dewasa</span>
                                    </div>
                                    <span class="badge bg-primary">4</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="lingkungan_2">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="lingkungan_2" name="faktor_lingkungan" value="3"
                                            class="form-check-input me-2 assessment-field" data-field="faktor_lingkungan">
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
                                            class="form-check-input me-2 assessment-field" data-field="faktor_lingkungan">
                                        <span>Pasien diletakkan di tempat tidur</span>
                                    </div>
                                    <span class="badge bg-primary">2</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="lingkungan_4">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="lingkungan_4" name="faktor_lingkungan" value="1"
                                            class="form-check-input me-2 assessment-field" data-field="faktor_lingkungan">
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
                                            class="form-check-input me-2 assessment-field" data-field="pembedahan_sedasi">
                                        <span>Dalam 24 jam</span>
                                    </div>
                                    <span class="badge bg-primary">3</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="bedah_2">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="bedah_2" name="pembedahan_sedasi" value="2"
                                            class="form-check-input me-2 assessment-field" data-field="pembedahan_sedasi">
                                        <span>Dalam 48 jam</span>
                                    </div>
                                    <span class="badge bg-primary">2</span>
                                </div>
                            </label>
                            <label class="form-check bg-light p-3 rounded mb-2" for="bedah_3">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" id="bedah_3" name="pembedahan_sedasi" value="1"
                                            class="form-check-input me-2 assessment-field" data-field="pembedahan_sedasi">
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
                                            data-field="penggunaan_medikamentosa">
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
                                            data-field="penggunaan_medikamentosa">
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
                                            data-field="penggunaan_medikamentosa">
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
                                        <label class="form-label fw-bold">Total Skor</label>
                                        <p id="totalScore" class="form-control-plaintext fs-2 fw-bold">
                                            {{ $lastAssessment->total_skor ?? '0' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <label class="form-label fw-bold">Kategori Risiko</label>
                                        <p id="riskCategory" class="form-control-plaintext fs-2 fw-bold">
                                            {{ $lastAssessment->kategori_risiko ?? 'Belum Dinilai' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden inputs for existing score -->
                    <input type="hidden" name="total_skor" id="totalScoreInput"
                        value="{{ $lastAssessment->total_skor ?? '' }}">
                    <input type="hidden" name="kategori_risiko" id="kategoriRisikoInput"
                        value="{{ $lastAssessment->kategori_risiko ?? '' }}">

                    <!-- Intervention Section -->
                    <div class="mb-4" id="interventionSection">
                        <!-- Intervensi untuk Risiko Rendah -->
                        <div id="lowRiskInterventions" style="display: none;">
                            <h5 class="mb-3">INTERVENSI PENCEGAHAN JATUH - RESIKO RENDAH</h5>

                            <div class="alert alert-success">
                                <strong>INFORMASI:</strong> Beri tanda cek (√) pada tindakan yang dilakukan
                            </div>

                            <label for="observasi_ambulasi" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="observasi_ambulasi"
                                    name="observasi_ambulasi" value="1">
                                <div class="form-check-label">
                                    <strong>1. Tingkatkan observasi bantuan yang sesuai saat ambulasi</strong>
                                </div>
                            </label>

                            <label for="orientasi_rs" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="orientasi_rs" name="orientasi_rs"
                                    value="1">
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
                                <input class="form-check-input" type="checkbox" id="pagar_pengaman"
                                    name="pagar_pengaman" value="1">
                                <div class="form-check-label">
                                    <strong>3. Pagar pengaman tempat tidur dinaikkan, kaji agar kaki/ tangan tidak
                                        tersangkut</strong>
                                </div>
                            </label>

                            <label for="tempat_tidur_rendah" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="tempat_tidur_rendah"
                                    name="tempat_tidur_rendah" value="1">
                                <div class="form-check-label">
                                    <strong>4. Tempat tidur dalam posisi rendah dan terkunci</strong>
                                </div>
                            </label>

                            <label for="edukasi_perilaku" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="edukasi_perilaku"
                                    name="edukasi_perilaku" value="1">
                                <div class="form-check-label">
                                    <strong>5. Edukasi perilaku yang lebih aman saat jatuh atau transfer</strong>
                                </div>
                            </label>

                            <label for="monitor_berkala" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="monitor_berkala"
                                    name="monitor_berkala" value="1">
                                <div class="form-check-label">
                                    <strong>6. Monitor kebutuhan pasien secara berkala (minimalnya tiap 2 jam)</strong>
                                </div>
                            </label>

                            <label for="anjuran_kaus_kaki" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="anjuran_kaus_kaki"
                                    name="anjuran_kaus_kaki" value="1">
                                <div class="form-check-label">
                                    <strong>7. Anjurkan pasien tidak menggunakan kaus kaki atau sepatu yang licin</strong>
                                </div>
                            </label>

                            <label for="lantai_antislip" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="lantai_antislip"
                                    name="lantai_antislip" value="1">
                                <div class="form-check-label">
                                    <strong>8. Lantai kamar mandi dengan karpet antislip, tidak licin</strong>
                                </div>
                            </label>
                        </div>

                        <!-- Intervensi untuk Risiko Tinggi -->
                        <div id="highRiskInterventions" style="display: none;" class="mt-5">
                            <h5 class="mb-3">INTERVENSI PENCEGAHAN JATUH - RESIKO TINGGI</h5>

                            <div class="alert alert-danger">
                                <strong>PENTING:</strong> Beri tanda cek (√) pada tindakan yang dilakukan
                            </div>

                            <label for="semua_intervensi_rendah" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="semua_intervensi_rendah"
                                    name="semua_intervensi_rendah" value="1">
                                <div class="form-check-label">
                                    <strong>1. Lakukan SEMUA intervensi jatuh resiko rendah / standar</strong>
                                </div>
                            </label>

                            <label for="gelang_kuning" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="gelang_kuning" name="gelang_kuning"
                                    value="1">
                                <div class="form-check-label">
                                    <strong>2. Pakailah gelang risiko jatuh berwarna kuning</strong>
                                </div>
                            </label>

                            <label for="pasang_gambar" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="pasang_gambar" name="pasang_gambar"
                                    value="1">
                                <div class="form-check-label">
                                    <strong>3. Pasang gambar risiko jatuh diatas tempat tidur pasien dan pada pintu kamar
                                        pasien</strong>
                                </div>
                            </label>

                            <label for="tanda_daftar_nama" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="tanda_daftar_nama"
                                    name="tanda_daftar_nama" value="1">
                                <div class="form-check-label">
                                    <strong>4. Tempatkan tanda resiko pasien jatuh pada daftar nama pasien (warna
                                        kuning)</strong>
                                </div>
                            </label>

                            <label for="pertimbangkan_obat" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="pertimbangkan_obat"
                                    name="pertimbangkan_obat" value="1">
                                <div class="form-check-label">
                                    <strong>5. Pertimbangkan riwayat obat-obatan dan suplemen untuk mengevaluasi
                                        pengobatan</strong>
                                </div>
                            </label>

                            <label for="alat_bantu_jalan" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="alat_bantu_jalan"
                                    name="alat_bantu_jalan" value="1">
                                <div class="form-check-label">
                                    <strong>6. Gunakan alat bantu jalan (walker, handrail)</strong>
                                </div>
                            </label>

                            <label for="pintu_terbuka" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="pintu_terbuka" name="pintu_terbuka"
                                    value="1">
                                <div class="form-check-label">
                                    <strong>7. Biarkan pintu ruangan terbuka kecuali untuk tujuan isolasi</strong>
                                </div>
                            </label>

                            <label for="jangan_tinggalkan" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="jangan_tinggalkan"
                                    name="jangan_tinggalkan" value="1">
                                <div class="form-check-label">
                                    <strong>8. Jangan tinggalkan pasien saat di ruangan diagnostic atau tindakan</strong>
                                </div>
                            </label>

                            <label for="dekat_nurse_station" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="dekat_nurse_station"
                                    name="dekat_nurse_station" value="1">
                                <div class="form-check-label">
                                    <strong>9. Penempatan pasien dekat nurse station untuk memudahkan observasi (24-48
                                        jam)</strong>
                                </div>
                            </label>

                            <label for="bed_posisi_rendah" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="bed_posisi_rendah"
                                    name="bed_posisi_rendah" value="1">
                                <div class="form-check-label">
                                    <strong>10. Posisi Bed atur ke posisi paling rendah</strong>
                                </div>
                            </label>

                            <label for="edukasi_keluarga" class="form-check bg-light p-3 rounded mb-2">
                                <input class="form-check-input" type="checkbox" id="edukasi_keluarga"
                                    name="edukasi_keluarga" value="1">
                                <div class="form-check-label">
                                    <strong>11. Edukasi pasien/ keluarga yang harus diperhatikan sesuai protokol</strong>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="text-end">
                        <x-button-submit id="simpan" />
                    </div>
                </form>
            </x-content-card>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            let lastChecked = {};

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
                        return;
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
                    // hanya rendah
                    $('#lowRiskInterventions').show();
                } else if (kategori === 'Risiko Tinggi') {
                    // kumulatif: tampilkan rendah + tinggi
                    $('#lowRiskInterventions').show();
                    $('#highRiskInterventions').show();
                }
            }

            // Event listener untuk checkbox enable penilaian
            $('#enableResikoJatuh').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#penilaianSection, #scoreDisplay').show();
                    $('#use_existing_assessment').val('0');

                    // Hitung ulang skor dari penilaian yang ada
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

                    // Gunakan data existing untuk hasil (jika ada)
                    const existingTotal = $('input[name="existing_total_skor"]').val();
                    const existingKategori = $('input[name="existing_kategori_risiko"]').val();

                    if (existingTotal && existingKategori && existingTotal !== '' && existingKategori !==
                        '') {
                        $('#totalScore').text(existingTotal);
                        $('#riskCategory').text(existingKategori);
                        $('#totalScoreInput').val(existingTotal);
                        $('#kategoriRisikoInput').val(existingKategori);
                        tampilkanIntervensi(existingKategori);
                    } else {
                        // Reset score jika tidak ada data existing
                        $('#totalScore').text('0');
                        $('#riskCategory').text('Belum Dinilai');
                        $('#totalScoreInput').val('');
                        $('#kategoriRisikoInput').val('');
                        $('#lowRiskInterventions, #highRiskInterventions').hide();
                    }
                }
            });

            // Event listener untuk radio button dengan fitur uncheck
            $('.assessment-field').on('click', function(e) {
                const groupName = $(this).attr('name');

                // Jika radio button yang sama diklik lagi, uncheck
                if (lastChecked[groupName] === this && $(this).is(':checked')) {
                    $(this).prop('checked', false);
                    lastChecked[groupName] = null;

                    // Update visual state
                    $('label.form-check').removeClass('selected');
                    $('.assessment-field:checked').each(function() {
                        $(this).closest('label.form-check').addClass('selected');
                    });

                    hitungSkorDanKategori();
                    return;
                }

                // Simpan radio button yang diklik sebagai yang terakhir
                lastChecked[groupName] = this;

                // Update visual selected state
                $('label.form-check').removeClass('selected');
                $('.assessment-field:checked').each(function() {
                    $(this).closest('label.form-check').addClass('selected');
                });

                hitungSkorDanKategori();
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
            $('.assessment-field:checked').each(function() {
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
            const enabledCheckbox = $('#enableResikoJatuh').is(':checked');

            if (totalScoreInput && kategoriInput) {
                // Jika ada lastAssessment, gunakan skor dan kategori dari sana
                $('#totalScore').text(totalScoreInput);
                $('#riskCategory').text(kategoriInput);

                tampilkanIntervensi(kategoriInput);
                $('#scoreDisplay').show();
            } else if (!enabledCheckbox) {
                // Jika checkbox tidak dicentang tapi tidak ada lastAssessment, coba ambil dari existing
                const existingTotal = $('input[name="existing_total_skor"]').val();
                const existingKategori = $('input[name="existing_kategori_risiko"]').val();

                if (existingTotal && existingKategori) {
                    $('#totalScore').text(existingTotal);
                    $('#riskCategory').text(existingKategori);
                    $('#totalScoreInput').val(existingTotal);
                    $('#kategoriRisikoInput').val(existingKategori);
                    tampilkanIntervensi(existingKategori);
                    $('#scoreDisplay').show();
                } else {
                    $('#scoreDisplay').hide();
                }
            } else {
                // Jika tidak ada, hitung dari penilaian
                hitungSkorDanKategori();
                if (enabledCheckbox) {
                    $('#scoreDisplay').show();
                } else {
                    $('#scoreDisplay').hide();
                }
            }

            // Set tanggal dan jam otomatis
            const now = new Date();
            const currentDate = now.toISOString().split('T')[0];
            const currentTime = now.toTimeString().split(' ')[0].substring(0, 5);

            $('#tanggal_implementasi').val(currentDate);
        });
    </script>
@endpush
