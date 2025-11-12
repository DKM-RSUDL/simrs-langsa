@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Tambah Pengkajian Resiko Jatuh - Skala Geriatri',
                    'description' =>
                        'Tambah data pengkajian resiko jatuh - skala geriatri pasien rawat inap dengan mengisi formulir di bawah ini.',
                ])

                <form id="formGeriatri" method="POST"
                    action="{{ route('rawat-inap.resiko-jatuh.geriatri.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                    @csrf

                    {{-- Informasi Dasar --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tanggal_implementasi" class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal_implementasi') is-invalid @enderror"
                                id="tanggal_implementasi" name="tanggal_implementasi"
                                value="{{ old('tanggal_implementasi') }}" required>
                            @error('tanggal_implementasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="jam_implementasi" class="form-label">Jam</label>
                            <input type="time" class="form-control @error('jam_implementasi') is-invalid @enderror"
                                id="jam_implementasi" name="jam_implementasi" value="{{ old('jam_implementasi') }}"
                                required>
                            @error('jam_implementasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="shift" class="form-label">Shift</label>
                            <select class="form-control @error('shift') is-invalid @enderror" id="shift" name="shift"
                                required>
                                <option value="">Pilih Shift</option>
                                <option value="PG" {{ old('shift') == 'PG' ? 'selected' : '' }}>Pagi (PG)</option>
                                <option value="SI" {{ old('shift') == 'SI' ? 'selected' : '' }}>Siang (SI)</option>
                                <option value="ML" {{ old('shift') == 'ML' ? 'selected' : '' }}>Malam (ML)</option>
                            </select>
                            @error('shift')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="duplicate-warning" class="alert alert-warning mt-2" style="display: none;">
                                <i class="bi bi-exclamation-triangle"></i> Data dengan tanggal dan shift ini sudah
                                ada!
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Checkbox Enable Penilaian --}}
                    <div class="mb-4">
                        <label for="enableGeriatri" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" id="enableGeriatri"
                                {{ !isset($lastAssessment) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                Ceklis jika akan membuat penilaian resiko jatuh
                            </div>
                        </label>
                    </div>

                    @if (isset($lastAssessment))
                        {{-- Hidden inputs untuk data penilaian existing --}}
                        <input type="hidden" name="use_existing_assessment" id="use_existing_assessment" value="1">
                        <input type="hidden" name="existing_riwayat_jatuh_1a"
                            value="{{ $lastAssessment->riwayat_jatuh_1a }}">
                        <input type="hidden" name="existing_riwayat_jatuh_1b"
                            value="{{ $lastAssessment->riwayat_jatuh_1b }}">
                        <input type="hidden" name="existing_status_mental_2a"
                            value="{{ $lastAssessment->status_mental_2a }}">
                        <input type="hidden" name="existing_status_mental_2b"
                            value="{{ $lastAssessment->status_mental_2b }}">
                        <input type="hidden" name="existing_status_mental_2c"
                            value="{{ $lastAssessment->status_mental_2c }}">
                        <input type="hidden" name="existing_penglihatan_3a" value="{{ $lastAssessment->penglihatan_3a }}">
                        <input type="hidden" name="existing_penglihatan_3b" value="{{ $lastAssessment->penglihatan_3b }}">
                        <input type="hidden" name="existing_penglihatan_3c" value="{{ $lastAssessment->penglihatan_3c }}">
                        <input type="hidden" name="existing_kebiasaan_berkemih_4a"
                            value="{{ $lastAssessment->kebiasaan_berkemih_4a }}">
                        <input type="hidden" name="existing_transfer" value="{{ $lastAssessment->transfer }}">
                        <input type="hidden" name="existing_mobilitas" value="{{ $lastAssessment->mobilitas }}">
                        <input type="hidden" name="existing_total_skor" value="{{ $lastAssessment->total_skor }}">
                        <input type="hidden" name="existing_kategori_risiko"
                            value="{{ $lastAssessment->kategori_risiko }}">
                    @else
                        <input type="hidden" name="use_existing_assessment" id="use_existing_assessment" value="0">
                    @endif

                    {{-- Penilaian Resiko Jatuh --}}
                    <div id="penilaianSection" class="mb-4"
                        style="display: {{ !isset($lastAssessment) ? 'block' : 'none' }};">
                        <h5 class="mb-3">Penilaian Resiko Jatuh (Skala Geriatri)</h5>

                        {{-- 1. Riwayat Jatuh --}}
                        <div class="mb-4">
                            <label class="fw-bold d-block mb-2">1. Riwayat Jatuh:</label>

                            <div class="mb-3">
                                <label class="form-label fw-medium">a. Apakah pasien datang kerumah sakit karena
                                    jatuh?</label>
                                <label for="riwayat_jatuh_1a_tidak" class="form-check bg-light p-3 rounded mb-2"
                                    data-group="riwayat_jatuh_1a">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="riwayat_jatuh_1a"
                                                id="riwayat_jatuh_1a_tidak" value="0">
                                            <span>Tidak</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 0</span>
                                    </div>
                                </label>
                                <label for="riwayat_jatuh_1a_ya" class="form-check bg-light p-3 rounded"
                                    data-group="riwayat_jatuh_1a">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="riwayat_jatuh_1a"
                                                id="riwayat_jatuh_1a_ya" value="6">
                                            <span>Ya</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 6</span>
                                    </div>
                                </label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">b. Jika tidak, apakah pasien mengalami jatuh dalam 2
                                    bulan
                                    terakhir ini?</label>
                                <label for="riwayat_jatuh_1b_tidak" class="form-check bg-light p-3 rounded mb-2"
                                    data-group="riwayat_jatuh_1b">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="riwayat_jatuh_1b"
                                                id="riwayat_jatuh_1b_tidak" value="0">
                                            <span>Tidak</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 0</span>
                                    </div>
                                </label>
                                <label for="riwayat_jatuh_1b_ya" class="form-check bg-light p-3 rounded"
                                    data-group="riwayat_jatuh_1b">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="riwayat_jatuh_1b"
                                                id="riwayat_jatuh_1b_ya" value="6">
                                            <span>Ya</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 6</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- 2. Status Mental --}}
                        <div class="mb-4">
                            <label class="fw-bold d-block mb-2">2. Status Mental:</label>

                            <div class="mb-3">
                                <label class="form-label fw-medium">a. Apakah pasien delirium? (Tidak dapat membuat
                                    keputusan, pola
                                    pikir tidak terorganisir, gangguan daya ingat)</label>
                                <label for="status_mental_2a_tidak" class="form-check bg-light p-3 rounded mb-2"
                                    data-group="status_mental_2a">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="status_mental_2a"
                                                id="status_mental_2a_tidak" value="0">
                                            <span>Tidak</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 0</span>
                                    </div>
                                </label>
                                <label for="status_mental_2a_ya" class="form-check bg-light p-3 rounded"
                                    data-group="status_mental_2a">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="status_mental_2a"
                                                id="status_mental_2a_ya" value="14">
                                            <span>Ya</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 14</span>
                                    </div>
                                </label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">b. Apakah pasien disorientasi? (salah menyebutkan
                                    waktu, tempat
                                    atau orang)</label>
                                <label for="status_mental_2b_tidak" class="form-check bg-light p-3 rounded mb-2"
                                    data-group="status_mental_2b">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="status_mental_2b"
                                                id="status_mental_2b_tidak" value="0">
                                            <span>Tidak</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 0</span>
                                    </div>
                                </label>
                                <label for="status_mental_2b_ya" class="form-check bg-light p-3 rounded"
                                    data-group="status_mental_2b">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="status_mental_2b"
                                                id="status_mental_2b_ya" value="14">
                                            <span>Ya</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 14</span>
                                    </div>
                                </label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">c. Apakah pasien mengalami agitasi? (ketakutan,
                                    gelisah, tidak
                                    cemas)</label>
                                <label for="status_mental_2c_tidak" class="form-check bg-light p-3 rounded mb-2"
                                    data-group="status_mental_2c">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="status_mental_2c"
                                                id="status_mental_2c_tidak" value="0">
                                            <span>Tidak</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 0</span>
                                    </div>
                                </label>
                                <label for="status_mental_2c_ya" class="form-check bg-light p-3 rounded"
                                    data-group="status_mental_2c">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="status_mental_2c"
                                                id="status_mental_2c_ya" value="14">
                                            <span>Ya</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 14</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- 3. Penglihatan --}}
                        <div class="mb-4">
                            <label class="fw-bold d-block mb-2">3. Penglihatan:</label>

                            <div class="mb-3">
                                <label class="form-label fw-medium">a. Apakah pasien memakai kacamata?</label>
                                <label for="penglihatan_3a_tidak" class="form-check bg-light p-3 rounded mb-2"
                                    data-group="penglihatan_3a">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="penglihatan_3a"
                                                id="penglihatan_3a_tidak" value="0">
                                            <span>Tidak</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 0</span>
                                    </div>
                                </label>
                                <label for="penglihatan_3a_ya" class="form-check bg-light p-3 rounded"
                                    data-group="penglihatan_3a">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="penglihatan_3a"
                                                id="penglihatan_3a_ya" value="1">
                                            <span>Ya</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 1</span>
                                    </div>
                                </label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">b. Apakah pasien mengeluh adanya penglihatan
                                    buram?</label>
                                <label for="penglihatan_3b_tidak" class="form-check bg-light p-3 rounded mb-2"
                                    data-group="penglihatan_3b">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="penglihatan_3b"
                                                id="penglihatan_3b_tidak" value="0">
                                            <span>Tidak</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 0</span>
                                    </div>
                                </label>
                                <label for="penglihatan_3b_ya" class="form-check bg-light p-3 rounded"
                                    data-group="penglihatan_3b">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="penglihatan_3b"
                                                id="penglihatan_3b_ya" value="1">
                                            <span>Ya</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 1</span>
                                    </div>
                                </label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">c. Apakah pasien mempunyai Glaukoma/ Katarak/
                                    degenerasi
                                    makula?</label>
                                <label for="penglihatan_3c_tidak" class="form-check bg-light p-3 rounded mb-2"
                                    data-group="penglihatan_3c">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="penglihatan_3c"
                                                id="penglihatan_3c_tidak" value="0">
                                            <span>Tidak</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 0</span>
                                    </div>
                                </label>
                                <label for="penglihatan_3c_ya" class="form-check bg-light p-3 rounded"
                                    data-group="penglihatan_3c">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="penglihatan_3c"
                                                id="penglihatan_3c_ya" value="1">
                                            <span>Ya</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 1</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- 4. Kebiasaan Berkemih --}}
                        <div class="mb-4">
                            <label class="fw-bold d-block mb-2">4. Kebiasaan Berkemih:</label>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Apakah terdapat perubahan perilaku berkemih?
                                    (frekuensi,
                                    urgensi, inkontinensia, nokturia)</label>
                                <label for="kebiasaan_berkemih_4a_tidak" class="form-check bg-light p-3 rounded mb-2"
                                    data-group="kebiasaan_berkemih_4a">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="kebiasaan_berkemih_4a"
                                                id="kebiasaan_berkemih_4a_tidak" value="0">
                                            <span>Tidak</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 0</span>
                                    </div>
                                </label>
                                <label for="kebiasaan_berkemih_4a_ya" class="form-check bg-light p-3 rounded"
                                    data-group="kebiasaan_berkemih_4a">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="kebiasaan_berkemih_4a"
                                                id="kebiasaan_berkemih_4a_ya" value="2">
                                            <span>Ya</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 2</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- 5. Transfer --}}
                        <div class="mb-4">
                            <label class="fw-bold d-block mb-2">5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke
                                tempat tidur):</label>
                            <div class="mb-3">
                                <label for="transfer_0" class="form-check bg-light p-3 rounded mb-2"
                                    data-group="transfer">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="transfer"
                                                id="transfer_0" value="0">
                                            <span>Mandiri (boleh memakai alat bantu jalan)</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 0</span>
                                    </div>
                                </label>
                                <label for="transfer_1" class="form-check bg-light p-3 rounded mb-2"
                                    data-group="transfer">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="transfer"
                                                id="transfer_1" value="1">
                                            <span>Memerlukan sedikit bantuan (1 orang) / dalam pengawasan</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 1</span>
                                    </div>
                                </label>
                                <label for="transfer_2" class="form-check bg-light p-3 rounded mb-2"
                                    data-group="transfer">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="transfer"
                                                id="transfer_2" value="2">
                                            <span>Memerlukan bantuan yang nyata (2 orang)</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 2</span>
                                    </div>
                                </label>
                                <label for="transfer_3" class="form-check bg-light p-3 rounded" data-group="transfer">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="transfer"
                                                id="transfer_3" value="3">
                                            <span>Tidak dapat duduk dengan seimbang, perlu bantuan total</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 3</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- 6. Mobilitas --}}
                        <div class="mb-4">
                            <label class="fw-bold d-block mb-2">6. Mobilitas:</label>
                            <div class="mb-3">
                                <label for="mobilitas_0" class="form-check bg-light p-3 rounded mb-2"
                                    data-group="mobilitas">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="mobilitas"
                                                id="mobilitas_0" value="0">
                                            <span>Mandiri (boleh menggunakan alat bantu jalan)</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 0</span>
                                    </div>
                                </label>
                                <label for="mobilitas_1" class="form-check bg-light p-3 rounded mb-2"
                                    data-group="mobilitas">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="mobilitas"
                                                id="mobilitas_1" value="1">
                                            <span>Berjalan dengan bantuan 1 orang (verbal / fisik)</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 1</span>
                                    </div>
                                </label>
                                <label for="mobilitas_2" class="form-check bg-light p-3 rounded mb-2"
                                    data-group="mobilitas">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="mobilitas"
                                                id="mobilitas_2" value="2">
                                            <span>Menggunakan kursi roda</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 2</span>
                                    </div>
                                </label>
                                <label for="mobilitas_3" class="form-check bg-light p-3 rounded" data-group="mobilitas">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="mobilitas"
                                                id="mobilitas_3" value="3">
                                            <span>Imobilisasi</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 3</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Hasil Penilaian --}}
                    <div id="hasilSection" class="mb-4">
                        <h5 class="mb-3">Hasil Penilaian</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <label class="fw-bold d-block mb-2">Skor Total</label>
                                        <p id="geriatri_skorTotal" class="form-control-plaintext fs-2 fw-bold">0</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <label class="fw-bold d-block mb-2">Kategori Risiko</label>
                                        <p id="geriatri_kategoriResiko" class="form-control-plaintext fs-2 fw-bold">Belum
                                            Dinilai</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="total_skor" id="geriatri_skorTotalInput" value="">
                        <input type="hidden" name="kategori_risiko" id="geriatri_kategoriResikoInput" value="">
                    </div>

                    {{-- Intervensi RR --}}
                    <div id="geriatri_intervensiRR" style="display: none;">
                        <h5 class="mb-3">INTERVENSI PENCEGAHAN JATUH - RESIKO RENDAH (RR)</h5>

                        <div class="alert alert-success">
                            <strong>INFORMASI:</strong> Beri tanda cek (√) pada tindakan yang dilakukan
                        </div>

                        <label class="fw-bold d-block mb-3 text-success">Pilih Intervensi yang Akan Dilakukan:</label>

                        <label for="rr_observasi_ambulasi" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rr_observasi_ambulasi"
                                id="rr_observasi_ambulasi" value="1">
                            <div class="form-check-label">
                                1. Tingkatkan observasi bantuan yang sesuai saat ambulasi
                            </div>
                        </label>

                        <label for="rr_orientasi_kamar_mandi" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rr_orientasi_kamar_mandi"
                                id="rr_orientasi_kamar_mandi" value="1">
                            <div class="form-check-label">
                                2. Orientasikan pasien terhadap lingkungan (kamar mandi, tombol panggil perawat)
                            </div>
                        </label>

                        <label for="rr_pagar_pengaman" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rr_pagar_pengaman"
                                id="rr_pagar_pengaman" value="1">
                            <div class="form-check-label">
                                3. Pagar pengaman tempat tidur dinaikkan
                            </div>
                        </label>

                        <label for="rr_tempat_tidur_rendah" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rr_tempat_tidur_rendah"
                                id="rr_tempat_tidur_rendah" value="1">
                            <div class="form-check-label">
                                4. Tempat tidur dalam posisi rendah terkunci
                            </div>
                        </label>

                        <label for="rr_edukasi_perilaku" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rr_edukasi_perilaku"
                                id="rr_edukasi_perilaku" value="1">
                            <div class="form-check-label">
                                5. Edukasi perilaku yang lebih aman saat jatuh atau transfer
                            </div>
                        </label>

                        <label for="rr_monitor_berkala" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rr_monitor_berkala"
                                id="rr_monitor_berkala" value="1">
                            <div class="form-check-label">
                                6. Monitor kebutuhan pasien secara berkala (minimalnya tiap 2 jam)
                            </div>
                        </label>

                        <label for="rr_anjuran_kaus_kaki" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rr_anjuran_kaus_kaki"
                                id="rr_anjuran_kaus_kaki" value="1">
                            <div class="form-check-label">
                                7. Anjurkan pasien tidak menggunakan kaus kaki atau sepatu yang licin
                            </div>
                        </label>

                        <label for="rr_lantai_antislip" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rr_lantai_antislip"
                                id="rr_lantai_antislip" value="1">
                            <div class="form-check-label">
                                8. Lantai kamar mandi dengan karpet antislip, tidak licin
                            </div>
                        </label>

                    </div>

                    {{-- Intervensi RS --}}
                    <div id="geriatri_intervensiRS" style="display: none;">
                        <h5 class="mb-3">INTERVENSI PENCEGAHAN JATUH - RESIKO SEDANG (RS)</h5>

                        <div class="alert alert-warning">
                            <strong>PERHATIAN:</strong> Beri tanda cek (√) pada tindakan yang dilakukan
                        </div>

                        <label class="fw-bold d-block mb-3 text-warning">Pilih Intervensi yang Akan Dilakukan:</label>

                        <label for="rs_semua_intervensi_rendah" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rs_semua_intervensi_rendah"
                                id="rs_semua_intervensi_rendah" value="1">
                            <div class="form-check-label">
                                1. Lakukan SEMUA intervensi jatuh resiko rendah / standar
                            </div>
                        </label>

                        <label for="rs_gelang_kuning" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rs_gelang_kuning"
                                id="rs_gelang_kuning" value="1">
                            <div class="form-check-label">
                                2. Pakailah gelang risiko jatuh berwarna kuning
                            </div>
                        </label>

                        <label for="rs_pasang_gambar" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rs_pasang_gambar"
                                id="rs_pasang_gambar" value="1">
                            <div class="form-check-label">
                                3. Pasang gambar risiko jatuh diatas tempat tidur pasien dan pada pintu kamar
                                pasien
                            </div>
                        </label>

                        <label for="rs_tanda_daftar_nama" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rs_tanda_daftar_nama"
                                id="rs_tanda_daftar_nama" value="1">
                            <div class="form-check-label">
                                4. Tempatkan tanda resiko pasien jatuh pada daftar nama pasien (warna kuning)
                            </div>
                        </label>

                        <label for="rs_pertimbangkan_obat" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rs_pertimbangkan_obat"
                                id="rs_pertimbangkan_obat" value="1">
                            <div class="form-check-label">
                                5. Pertimbangkan riwayat obat-obatan dan suplemen untuk mengevaluasi pengobatan
                            </div>
                        </label>

                        <label for="rs_alat_bantu_jalan" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rs_alat_bantu_jalan"
                                id="rs_alat_bantu_jalan" value="1">
                            <div class="form-check-label">
                                6. Gunakan alat bantu jalan (walker, handrail)
                            </div>
                        </label>
                    </div>

                    {{-- Intervensi RT --}}
                    <div id="geriatri_intervensiRT" style="display: none;">
                        <h5 class="mb-3">INTERVENSI PENCEGAHAN JATUH - RESIKO TINGGI (RT)</h5>

                        <div class="alert alert-danger">
                            <strong>PERHATIAN:</strong> Beri tanda cek (√) pada tindakan yang dilakukan
                        </div>

                        <label class="fw-bold d-block mb-3 text-danger">Pilih Intervensi yang Akan Dilakukan:</label>

                        <label for="rt_semua_intervensi_rendah_sedang" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rt_semua_intervensi_rendah_sedang"
                                id="rt_semua_intervensi_rendah_sedang" value="1">
                            <div class="form-check-label">
                                1. Lakukan SEMUA intervensi jatuh resiko rendah / standar dan resiko sedang
                            </div>
                        </label>

                        <label for="rt_jangan_tinggalkan" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rt_jangan_tinggalkan"
                                id="rt_jangan_tinggalkan" value="1">
                            <div class="form-check-label">
                                2. Jangan tinggalkan pasien saat di ruangan diagnostic atau tindakan
                            </div>
                        </label>

                        <label for="rt_dekat_nurse_station" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rt_dekat_nurse_station"
                                id="rt_dekat_nurse_station" value="1">
                            <div class="form-check-label">
                                3. Penempatan pasien dekat nurse station untuk memudahkan observasi (24-48 jam)
                            </div>
                        </label>
                    </div>

                    {{-- Buttons --}}
                    <div class="text-end">
                        <x-button-submit />
                    </div>
                </form>
            </x-content-card>

            <x-content-card>
                <!-- Keterangan -->
                <div class="row g-3">
                    <h6 class="card-title fw-bold">Kategori Risiko:</h6>
                    <ul class="mb-0" style="list-style: none;">
                        <li><strong>Risiko Rendah:</strong> Skor 0 - 5</li>
                        <li><strong>Risiko Sedang:</strong> Skor 6 - 16</li>
                        <li><strong>Risiko Tinggi:</strong> Skor ≥ 17</li>
                    </ul>
                </div>
            </x-content-card>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .form-check.selected {
            background-color: #cfe2ff !important;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            let lastChecked = {};

            // Set tanggal dan jam otomatis
            function setCurrentDateTime() {
                const now = new Date();
                const date = now.toISOString().split('T')[0];
                const time = now.toTimeString().slice(0, 5);
                $('#tanggal_implementasi').val(date);
                $('#jam_implementasi').val(time);
            }

            // Event listener untuk checkbox enable penilaian
            $('#enableGeriatri').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#penilaianSection, #hasilSection').show();
                    $('#use_existing_assessment').val('0');
                } else {
                    $('#penilaianSection').hide();
                    $('#hasilSection').show();
                    $('#use_existing_assessment').val('1');

                    // Reset semua radio button
                    $('input[type="radio"]').prop('checked', false);
                    // Reset visual state
                    $('.form-check[data-group]').removeClass('selected');
                    lastChecked = {};

                    // Gunakan data existing untuk hasil (jika ada)
                    const existingSkor = $('input[name="existing_total_skor"]').val();
                    const existingKategori = $('input[name="existing_kategori_risiko"]').val();

                    if (existingSkor && existingKategori) {
                        $('#geriatri_skorTotal').text(existingSkor);
                        $('#geriatri_kategoriResiko').text(existingKategori);
                        $('#geriatri_skorTotalInput').val(existingSkor);
                        $('#geriatri_kategoriResikoInput').val(existingKategori);
                        tampilkanIntervensi(existingKategori);
                    } else {
                        hitungSkorDanKategori();
                    }
                }
            });

            // Fungsi untuk menghitung skor dan kategori
            function hitungSkorDanKategori() {
                let categoryScores = {};
                let filledCount = 0;

                // Ambil nilai dari setiap field
                const fields = [
                    'riwayat_jatuh_1a', 'riwayat_jatuh_1b',
                    'status_mental_2a', 'status_mental_2b', 'status_mental_2c',
                    'penglihatan_3a', 'penglihatan_3b', 'penglihatan_3c',
                    'kebiasaan_berkemih_4a',
                    'transfer', 'mobilitas'
                ];

                fields.forEach(function(field) {
                    const checkedInput = $(`input[name="${field}"]:checked`);
                    if (checkedInput.length > 0) {
                        categoryScores[field] = parseInt(checkedInput.val());
                        filledCount++;
                    }
                });

                // Kalkulasi skor khusus untuk Geriatri
                let totalSkor = 0;

                // 1. Riwayat Jatuh - salah satu Ya = 6
                let riwayatJatuhScore = 0;
                const riwayat1a = categoryScores['riwayat_jatuh_1a'];
                const riwayat1b = categoryScores['riwayat_jatuh_1b'];
                if (riwayat1a === 6 || riwayat1b === 6) {
                    riwayatJatuhScore = 6;
                }
                totalSkor += riwayatJatuhScore;

                // 2. Status Mental - salah satu Ya = 14
                let statusMentalScore = 0;
                const mental2a = categoryScores['status_mental_2a'];
                const mental2b = categoryScores['status_mental_2b'];
                const mental2c = categoryScores['status_mental_2c'];
                if (mental2a === 14 || mental2b === 14 || mental2c === 14) {
                    statusMentalScore = 14;
                }
                totalSkor += statusMentalScore;

                // 3. Penglihatan - salah satu Ya = 1
                let penglihatanScore = 0;
                const penglihatan3a = categoryScores['penglihatan_3a'];
                const penglihatan3b = categoryScores['penglihatan_3b'];
                const penglihatan3c = categoryScores['penglihatan_3c'];
                if (penglihatan3a === 1 || penglihatan3b === 1 || penglihatan3c === 1) {
                    penglihatanScore = 1;
                }
                totalSkor += penglihatanScore;

                // 4. Kebiasaan Berkemih
                totalSkor += categoryScores['kebiasaan_berkemih_4a'] || 0;

                // 5. Transfer + Mobilitas (0-3 = 0, 4-6 = 7)
                let transferValue = categoryScores['transfer'] || 0;
                let mobilitasValue = categoryScores['mobilitas'] || 0;
                let totalTransferMobilitas = transferValue + mobilitasValue;
                let transferMobilitasScore = (totalTransferMobilitas >= 0 && totalTransferMobilitas <= 3) ? 0 : 7;
                totalSkor += transferMobilitasScore;

                // Update skor total
                $('#geriatri_skorTotal').text(isNaN(totalSkor) ? 0 : totalSkor);
                $('#geriatri_skorTotalInput').val(isNaN(totalSkor) ? '' : String(totalSkor));

                // Set kategori (0-5 RR, 6-16 RS, >=17 RT)
                let kategori = '';
                if (filledCount === fields.length && !isNaN(totalSkor)) {
                    if (totalSkor <= 5) kategori = 'Risiko Rendah';
                    else if (totalSkor <= 16) kategori = 'Risiko Sedang';
                    else kategori = 'Risiko Tinggi';
                }

                $('#geriatri_kategoriResiko').text(kategori ? kategori : 'Belum Dinilai');
                $('#geriatri_kategoriResikoInput').val(kategori);

                // Tampilkan intervensi sesuai kategori
                tampilkanIntervensi(kategori);
            }

            // Fungsi untuk menampilkan intervensi berdasarkan kategori
            function tampilkanIntervensi(kategori) {
                $('#geriatri_intervensiRR, #geriatri_intervensiRS, #geriatri_intervensiRT').hide();

                if (kategori === 'Risiko Rendah') {
                    $('#geriatri_intervensiRR').show();
                } else if (kategori === 'Risiko Sedang') {
                    $('#geriatri_intervensiRS').show();
                } else if (kategori === 'Risiko Tinggi') {
                    $('#geriatri_intervensiRT').show();
                }
            }

            // Event listener untuk radio button dengan fitur uncheck
            $('input[type="radio"][name="riwayat_jatuh_1a"], input[type="radio"][name="riwayat_jatuh_1b"], input[type="radio"][name="status_mental_2a"], input[type="radio"][name="status_mental_2b"], input[type="radio"][name="status_mental_2c"], input[type="radio"][name="penglihatan_3a"], input[type="radio"][name="penglihatan_3b"], input[type="radio"][name="penglihatan_3c"], input[type="radio"][name="kebiasaan_berkemih_4a"], input[type="radio"][name="transfer"], input[type="radio"][name="mobilitas"]')
                .on('click', function(e) {
                    const groupName = $(this).attr('name');

                    // Jika radio button yang sama diklik lagi, uncheck
                    if (lastChecked[groupName] === this && $(this).is(':checked')) {
                        $(this).prop('checked', false);
                        lastChecked[groupName] = null;

                        // Update visual state
                        $(`[data-group="${groupName}"]`).removeClass('selected');

                        hitungSkorDanKategori();
                        return;
                    }

                    // Simpan radio button yang diklik sebagai yang terakhir
                    lastChecked[groupName] = this;

                    // Update visual selected state
                    $(`[data-group="${groupName}"]`).removeClass('selected');
                    $(this).closest('.form-check').addClass('selected');

                    hitungSkorDanKategori();
                });

            // Handle checkbox intervensi
            $('input[name^="rr_"], input[name^="rs_"], input[name^="rt_"]').on('change', function() {
                const formCheck = $(this).closest('.form-check');
                if ($(this).is(':checked')) {
                    formCheck.addClass('selected');
                } else {
                    formCheck.removeClass('selected');
                }
            });

            // Set initial visual state berdasarkan data yang sudah ada
            $('input[type="radio"]:checked').each(function() {
                $(this).closest('.form-check').addClass('selected');
                lastChecked[$(this).attr('name')] = this;
            });

            $('input[type="checkbox"]:checked').each(function() {
                $(this).closest('.form-check').addClass('selected');
            });

            // Function untuk check duplicate
            function checkDuplicate() {
                const tanggal = $('#tanggal_implementasi').val();
                const shift = $('#shift').val();

                if (tanggal && shift) {
                    $.ajax({
                        url: "{{ route('rawat-inap.resiko-jatuh.geriatri.check-duplicate', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            tanggal_implementasi: tanggal,
                            shift: shift
                        },
                        success: function(response) {
                            if (response.exists) {
                                $('#duplicate-warning').show();
                                $('#btnSubmit').prop('disabled', true);
                            } else {
                                $('#duplicate-warning').hide();
                                $('#btnSubmit').prop('disabled', false);
                            }
                        }
                    });
                }
            }

            // Event listener untuk cek duplikasi
            $('#tanggal_implementasi, #shift').on('change', checkDuplicate);

            // Inisialisasi
            setCurrentDateTime();

            // Cek apakah ada existing assessment dari lastAssessment
            const existingSkor = $('input[name="existing_total_skor"]').val();
            const existingKategori = $('input[name="existing_kategori_risiko"]').val();

            if (existingSkor && existingKategori) {
                // Jika ada lastAssessment, tampilkan hasil dan intervensi dari data existing
                $('#geriatri_skorTotal').text(existingSkor);
                $('#geriatri_kategoriResiko').text(existingKategori);
                $('#geriatri_skorTotalInput').val(existingSkor);
                $('#geriatri_kategoriResikoInput').val(existingKategori);
                tampilkanIntervensi(existingKategori);
                $('#hasilSection').show();
            } else {
                // Jika tidak ada lastAssessment, hitung dari penilaian
                hitungSkorDanKategori();
                if ($('#enableGeriatri').is(':checked')) {
                    $('#hasilSection').show();
                } else {
                    $('#hasilSection').hide();
                }
            }
        });
    </script>
@endpush
