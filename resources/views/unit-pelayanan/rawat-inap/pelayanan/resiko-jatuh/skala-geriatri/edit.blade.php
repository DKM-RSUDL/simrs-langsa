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
                    'title' => 'Perbarui Pengkajian Resiko Jatuh - Khusus Lansia (Geriatri)',
                    'description' =>
                        'Perbarui data pengkajian resiko jatuh - geriatri pasien rawat inap dengan mengisi formulir di bawah ini.',
                ])

                <form id="humptyDumptyForm" method="POST"
                    action="{{ route('rawat-inap.resiko-jatuh.geriatri.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $dataSkalaGeriatri->id]) }}">
                    @csrf
                    @method('PUT')



                    {{-- Informasi Dasar --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tanggal_implementasi" class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal_implementasi') is-invalid @enderror"
                                id="tanggal_implementasi" name="tanggal_implementasi"
                                value="{{ date('Y-m-d', strtotime($dataSkalaGeriatri->tanggal_implementasi)) }}" required>
                            @error('tanggal_implementasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="jam_implementasi" class="form-label">Jam</label>
                            <input type="time" class="form-control @error('jam_implementasi') is-invalid @enderror"
                                id="jam_implementasi" name="jam_implementasi"
                                value="{{ date('H:i', strtotime($dataSkalaGeriatri->jam_implementasi)) }}" required>
                            @error('jam_implementasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="shift" class="form-label">Shift</label>
                            <select class="form-control @error('shift') is-invalid @enderror" id="shift" name="shift"
                                required>
                                <option value="">Pilih Shift</option>
                                <option value="PG" {{ $dataSkalaGeriatri->shift == 'PG' ? 'selected' : '' }}>Pagi (PG)
                                </option>
                                <option value="SI" {{ $dataSkalaGeriatri->shift == 'SI' ? 'selected' : '' }}>Siang (SI)
                                </option>
                                <option value="ML" {{ $dataSkalaGeriatri->shift == 'ML' ? 'selected' : '' }}>Malam (ML)
                                </option>
                            </select>
                            @error('shift')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="duplicate-warning" class="alert alert-warning mt-2" style="display: none;">
                                <i class="bi bi-exclamation-triangle"></i> Data dengan tanggal dan shift ini sudah ada!
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Checkbox Enable Penilaian --}}
                    <div class="mb-4">
                        <label for="enableGeriatri" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" id="enableGeriatri">
                            <div class="form-check-label">
                                Ceklis jika akan membuat penilaian resiko jatuh baru
                            </div>
                        </label>
                    </div>

                    {{-- Hidden inputs untuk data penilaian existing --}}
                    <input type="hidden" name="use_existing_assessment" id="use_existing_assessment" value="1">
                    <input type="hidden" name="existing_riwayat_jatuh_1a"
                        value="{{ $dataSkalaGeriatri->riwayat_jatuh_1a }}">
                    <input type="hidden" name="existing_riwayat_jatuh_1b"
                        value="{{ $dataSkalaGeriatri->riwayat_jatuh_1b }}">
                    <input type="hidden" name="existing_status_mental_2a"
                        value="{{ $dataSkalaGeriatri->status_mental_2a }}">
                    <input type="hidden" name="existing_status_mental_2b"
                        value="{{ $dataSkalaGeriatri->status_mental_2b }}">
                    <input type="hidden" name="existing_status_mental_2c"
                        value="{{ $dataSkalaGeriatri->status_mental_2c }}">
                    <input type="hidden" name="existing_penglihatan_3a" value="{{ $dataSkalaGeriatri->penglihatan_3a }}">
                    <input type="hidden" name="existing_penglihatan_3b" value="{{ $dataSkalaGeriatri->penglihatan_3b }}">
                    <input type="hidden" name="existing_penglihatan_3c" value="{{ $dataSkalaGeriatri->penglihatan_3c }}">
                    <input type="hidden" name="existing_kebiasaan_berkemih_4a"
                        value="{{ $dataSkalaGeriatri->kebiasaan_berkemih_4a }}">
                    <input type="hidden" name="existing_transfer" value="{{ $dataSkalaGeriatri->transfer }}">
                    <input type="hidden" name="existing_mobilitas" value="{{ $dataSkalaGeriatri->mobilitas }}">
                    <input type="hidden" name="existing_total_skor" value="{{ $dataSkalaGeriatri->total_skor }}">
                    <input type="hidden" name="existing_kategori_risiko"
                        value="{{ $dataSkalaGeriatri->kategori_risiko }}">

                    {{-- Penilaian Resiko Jatuh --}}
                    <div id="penilaianSection" class="mb-4" style="display: none;">
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
                                                id="riwayat_jatuh_1a_tidak" value="0"
                                                {{ $dataSkalaGeriatri->riwayat_jatuh_1a == 0 ? 'checked' : '' }}>
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
                                                id="riwayat_jatuh_1a_ya" value="6"
                                                {{ $dataSkalaGeriatri->riwayat_jatuh_1a == 6 ? 'checked' : '' }}>
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
                                                id="riwayat_jatuh_1b_tidak" value="0"
                                                {{ $dataSkalaGeriatri->riwayat_jatuh_1b == 0 ? 'checked' : '' }}>
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
                                                id="riwayat_jatuh_1b_ya" value="6"
                                                {{ $dataSkalaGeriatri->riwayat_jatuh_1b == 6 ? 'checked' : '' }}>
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
                                                id="status_mental_2a_tidak" value="0"
                                                {{ $dataSkalaGeriatri->status_mental_2a == 0 ? 'checked' : '' }}>
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
                                                id="status_mental_2a_ya" value="14"
                                                {{ $dataSkalaGeriatri->status_mental_2a == 14 ? 'checked' : '' }}>
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
                                                id="status_mental_2b_tidak" value="0"
                                                {{ $dataSkalaGeriatri->status_mental_2b == 0 ? 'checked' : '' }}>
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
                                                id="status_mental_2b_ya" value="14"
                                                {{ $dataSkalaGeriatri->status_mental_2b == 14 ? 'checked' : '' }}>
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
                                                id="status_mental_2c_tidak" value="0"
                                                {{ $dataSkalaGeriatri->status_mental_2c == 0 ? 'checked' : '' }}>
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
                                                id="status_mental_2c_ya" value="14"
                                                {{ $dataSkalaGeriatri->status_mental_2c == 14 ? 'checked' : '' }}>
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
                                                id="penglihatan_3a_tidak" value="0"
                                                {{ $dataSkalaGeriatri->penglihatan_3a == 0 ? 'checked' : '' }}>
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
                                                id="penglihatan_3a_ya" value="1"
                                                {{ $dataSkalaGeriatri->penglihatan_3a == 1 ? 'checked' : '' }}>
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
                                                id="penglihatan_3b_tidak" value="0"
                                                {{ $dataSkalaGeriatri->penglihatan_3b == 0 ? 'checked' : '' }}>
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
                                                id="penglihatan_3b_ya" value="1"
                                                {{ $dataSkalaGeriatri->penglihatan_3b == 1 ? 'checked' : '' }}>
                                            <span>Ya</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 1</span>
                                    </div>
                                </label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">c. Apakah pasien mempunyai Glaukoma/Katarak/degenerasi
                                    makula?</label>
                                <label for="penglihatan_3c_tidak" class="form-check bg-light p-3 rounded mb-2"
                                    data-group="penglihatan_3c">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="penglihatan_3c"
                                                id="penglihatan_3c_tidak" value="0"
                                                {{ $dataSkalaGeriatri->penglihatan_3c == 0 ? 'checked' : '' }}>
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
                                                id="penglihatan_3c_ya" value="1"
                                                {{ $dataSkalaGeriatri->penglihatan_3c == 1 ? 'checked' : '' }}>
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
                                                id="kebiasaan_berkemih_4a_tidak" value="0"
                                                {{ $dataSkalaGeriatri->kebiasaan_berkemih_4a == 0 ? 'checked' : '' }}>
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
                                                id="kebiasaan_berkemih_4a_ya" value="2"
                                                {{ $dataSkalaGeriatri->kebiasaan_berkemih_4a == 2 ? 'checked' : '' }}>
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
                                                id="transfer_0" value="0"
                                                {{ $dataSkalaGeriatri->transfer == 0 ? 'checked' : '' }}>
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
                                                id="transfer_1" value="1"
                                                {{ $dataSkalaGeriatri->transfer == 1 ? 'checked' : '' }}>
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
                                                id="transfer_2" value="2"
                                                {{ $dataSkalaGeriatri->transfer == 2 ? 'checked' : '' }}>
                                            <span>Memerlukan bantuan yang nyata (2 orang)</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 2</span>
                                    </div>
                                </label>
                                <label for="transfer_3" class="form-check bg-light p-3 rounded" data-group="transfer">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="transfer"
                                                id="transfer_3" value="3"
                                                {{ $dataSkalaGeriatri->transfer == 3 ? 'checked' : '' }}>
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
                                                id="mobilitas_0" value="0"
                                                {{ $dataSkalaGeriatri->mobilitas == 0 ? 'checked' : '' }}>
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
                                                id="mobilitas_1" value="1"
                                                {{ $dataSkalaGeriatri->mobilitas == 1 ? 'checked' : '' }}>
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
                                                id="mobilitas_2" value="2"
                                                {{ $dataSkalaGeriatri->mobilitas == 2 ? 'checked' : '' }}>
                                            <span>Menggunakan kursi roda</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 2</span>
                                    </div>
                                </label>
                                <label for="mobilitas_3" class="form-check bg-light p-3 rounded" data-group="mobilitas">
                                    <div class="form-check-label d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input" type="radio" name="mobilitas"
                                                id="mobilitas_3" value="3"
                                                {{ $dataSkalaGeriatri->mobilitas == 3 ? 'checked' : '' }}>
                                            <span>Imobilisasi</span>
                                        </div>
                                        <span class="badge bg-primary">Skor: 3</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Hasil Penilaian -->
                    <div id="hasilSection" class="mb-4">
                        <h5 class="mb-3">Hasil Penilaian</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <label class="fw-bold d-block mb-2">Skor Total</label>
                                        <p id="geriatri_skorTotal" class="form-control-plaintext fs-2 fw-bold">
                                            {{ $dataSkalaGeriatri->total_skor }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <label class="fw-bold d-block mb-2">Kategori Risiko</label>
                                        <p id="geriatri_kategoriResiko" class="form-control-plaintext fs-2 fw-bold">
                                            {{ $dataSkalaGeriatri->kategori_risiko }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="total_skor" id="geriatri_skorTotalInput"
                            value="{{ $dataSkalaGeriatri->total_skor }}">
                        <input type="hidden" name="kategori_risiko" id="geriatri_kategoriResikoInput"
                            value="{{ $dataSkalaGeriatri->kategori_risiko }}">
                    </div>

                    <!-- Intervensi RR -->
                    <div id="geriatri_intervensiRR"
                        style="{{ $dataSkalaGeriatri->kategori_risiko == 'Risiko Rendah' ? 'display: block;' : 'display: none;' }}">
                        <h5 class="mb-3">INTERVENSI PENCEGAHAN JATUH - RESIKO RENDAH (RR)</h5>

                        <div class="alert alert-success">
                            <strong>INFORMASI:</strong> Beri tanda cek (√) pada tindakan yang dilakukan
                        </div>

                        <label class="fw-bold d-block mb-3 text-success">Pilih Intervensi yang Akan Dilakukan:</label>

                        <label for="rr_observasi_ambulasi" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rr_observasi_ambulasi"
                                id="rr_observasi_ambulasi" value="1"
                                {{ $dataSkalaGeriatri->rr_observasi_ambulasi ? 'checked' : '' }}>
                            <div class="form-check-label">
                                Tingkatkan observasi bantuan yang sesuai saat ambulasi
                            </div>
                        </label>

                        <label for="rr_orientasi_kamar_mandi" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rr_orientasi_kamar_mandi"
                                id="rr_orientasi_kamar_mandi" value="1"
                                {{ $dataSkalaGeriatri->rr_orientasi_kamar_mandi ? 'checked' : '' }}>
                            <div class="form-check-label">
                                2. Orientasikan pasien terhadap lingkungan (kamar mandi, tombol panggil perawat)
                            </div>
                        </label>

                        <label for="rr_pagar_pengaman" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rr_pagar_pengaman"
                                id="rr_pagar_pengaman" value="1"
                                {{ $dataSkalaGeriatri->rr_pagar_pengaman ? 'checked' : '' }}>
                            <div class="form-check-label">
                                3. Pagar pengaman tempat tidur dinaikkan
                            </div>
                        </label>

                        <label for="rr_tempat_tidur_rendah" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rr_tempat_tidur_rendah"
                                id="rr_tempat_tidur_rendah" value="1"
                                {{ $dataSkalaGeriatri->rr_tempat_tidur_rendah ? 'checked' : '' }}>
                            <div class="form-check-label">
                                4. Tempat tidur dalam posisi rendah terkunci
                            </div>
                        </label>

                        <label for="rr_edukasi_perilaku" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rr_edukasi_perilaku"
                                id="rr_edukasi_perilaku" value="1"
                                {{ $dataSkalaGeriatri->rr_edukasi_perilaku ? 'checked' : '' }}>
                            <div class="form-check-label">
                                5. Edukasi perilaku yang lebih aman saat jatuh atau transfer
                            </div>
                        </label>

                        <label for="rr_monitor_berkala" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rr_monitor_berkala"
                                id="rr_monitor_berkala" value="1"
                                {{ $dataSkalaGeriatri->rr_monitor_berkala ? 'checked' : '' }}>
                            <div class="form-check-label">
                                6. Monitor kebutuhan pasien secara berkala (minimalnya tiap 2 jam)
                            </div>
                        </label>

                        <label for="rr_anjuran_kaus_kaki" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rr_anjuran_kaus_kaki"
                                id="rr_anjuran_kaus_kaki" value="1"
                                {{ $dataSkalaGeriatri->rr_anjuran_kaus_kaki ? 'checked' : '' }}>
                            <div class="form-check-label">
                                7. Anjurkan pasien tidak menggunakan kaus kaki atau sepatu yang licin
                            </div>
                        </label>

                        <label for="rr_lantai_antislip" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rr_lantai_antislip"
                                id="rr_lantai_antislip" value="1"
                                {{ $dataSkalaGeriatri->rr_lantai_antislip ? 'checked' : '' }}>
                            <div class="form-check-label">
                                8. Lantai kamar mandi dengan karpet antislip, tidak licin
                            </div>
                        </label>

                    </div> {{-- Intervensi RS --}}
                    <div id="geriatri_intervensiRS"
                        style="{{ $dataSkalaGeriatri->kategori_risiko == 'Risiko Sedang' ? 'display: block;' : 'display: none;' }}">
                        <h5 class="mb-3">INTERVENSI PENCEGAHAN JATUH - RESIKO SEDANG (RS)</h5>

                        <div class="alert alert-warning">
                            <strong>PERHATIAN:</strong> Beri tanda cek (√) pada tindakan yang dilakukan
                        </div>

                        <label class="fw-bold d-block mb-3 text-warning">Pilih Intervensi yang Akan Dilakukan:</label>

                        <label for="rs_semua_intervensi_rendah" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rs_semua_intervensi_rendah"
                                id="rs_semua_intervensi_rendah" value="1"
                                {{ $dataSkalaGeriatri->rs_semua_intervensi_rendah ? 'checked' : '' }}>
                            <div class="form-check-label">
                                1. Lakukan SEMUA intervensi jatuh resiko rendah / standar
                            </div>
                        </label>

                        <label for="rs_gelang_kuning" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rs_gelang_kuning"
                                id="rs_gelang_kuning" value="1"
                                {{ $dataSkalaGeriatri->rs_gelang_kuning ? 'checked' : '' }}>
                            <div class="form-check-label">
                                2. Pakailah gelang risiko jatuh berwarna kuning
                            </div>
                        </label>

                        <label for="rs_pasang_gambar" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rs_pasang_gambar"
                                id="rs_pasang_gambar" value="1"
                                {{ $dataSkalaGeriatri->rs_pasang_gambar ? 'checked' : '' }}>
                            <div class="form-check-label">
                                3. Pasang gambar risiko jatuh diatas tempat tidur pasien dan pada pintu kamar pasien
                            </div>
                        </label>

                        <label for="rs_tanda_daftar_nama" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rs_tanda_daftar_nama"
                                id="rs_tanda_daftar_nama" value="1"
                                {{ $dataSkalaGeriatri->rs_tanda_daftar_nama ? 'checked' : '' }}>
                            <div class="form-check-label">
                                4. Tempatkan tanda resiko pasien jatuh pada daftar nama pasien (warna kuning)
                            </div>
                        </label>

                        <label for="rs_pertimbangkan_obat" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rs_pertimbangkan_obat"
                                id="rs_pertimbangkan_obat" value="1"
                                {{ $dataSkalaGeriatri->rs_pertimbangkan_obat ? 'checked' : '' }}>
                            <div class="form-check-label">
                                5. Pertimbangkan riwayat obat-obatan dan suplemen untuk mengevaluasi pengobatan
                            </div>
                        </label>

                        <label for="rs_alat_bantu_jalan" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rs_alat_bantu_jalan"
                                id="rs_alat_bantu_jalan" value="1"
                                {{ $dataSkalaGeriatri->rs_alat_bantu_jalan ? 'checked' : '' }}>
                            <div class="form-check-label">
                                6. Gunakan alat bantu jalan (walker, handrail)
                            </div>
                        </label>
                    </div>

                    {{-- Intervensi RT --}}
                    <div id="geriatri_intervensiRT"
                        style="{{ $dataSkalaGeriatri->kategori_risiko == 'Risiko Tinggi' ? 'display: block;' : 'display: none;' }}">
                        <h5 class="mb-3">INTERVENSI PENCEGAHAN JATUH - RESIKO TINGGI (RT)</h5>

                        <div class="alert alert-danger">
                            <strong>PERHATIAN:</strong> Beri tanda cek (√) pada tindakan yang dilakukan
                        </div>

                        <label class="fw-bold d-block mb-3 text-danger">Pilih Intervensi yang Akan Dilakukan:</label>

                        <label for="rt_semua_intervensi_rendah_sedang" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rt_semua_intervensi_rendah_sedang"
                                id="rt_semua_intervensi_rendah_sedang" value="1"
                                {{ $dataSkalaGeriatri->rt_semua_intervensi_rendah_sedang ? 'checked' : '' }}>
                            <div class="form-check-label">
                                1. Lakukan SEMUA intervensi jatuh resiko rendah / standar dan resiko sedang
                            </div>
                        </label>

                        <label for="rt_jangan_tinggalkan" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rt_jangan_tinggalkan"
                                id="rt_jangan_tinggalkan" value="1"
                                {{ $dataSkalaGeriatri->rt_jangan_tinggalkan ? 'checked' : '' }}>
                            <div class="form-check-label">
                                2. Jangan tinggalkan pasien saat di ruangan diagnostic atau tindakan
                            </div>
                        </label>

                        <label for="rt_dekat_nurse_station" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="rt_dekat_nurse_station"
                                id="rt_dekat_nurse_station" value="1"
                                {{ $dataSkalaGeriatri->rt_dekat_nurse_station ? 'checked' : '' }}>
                            <div class="form-check-label">
                                3. Penempatan pasien dekat nurse station untuk memudahkan observasi (24-48 jam)
                            </div>
                        </label>
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
                    $('.radio-item').removeClass('selected');
                    lastChecked = {};

                    // Gunakan data existing untuk hasil
                    const existingSkor = $('input[name="existing_total_skor"]').val();
                    const existingKategori = $('input[name="existing_kategori_risiko"]').val();

                    if (existingSkor && existingKategori) {
                        $('#geriatri_skorTotal').text(existingSkor);
                        $('#geriatri_kategoriResiko').text(existingKategori);
                        $('#geriatri_skorTotalInput').val(existingSkor);
                        $('#geriatri_kategoriResikoInput').val(existingKategori);
                        tampilkanIntervensi(existingKategori);
                    } else {
                        calculateScore();
                    }
                }
            });

            // Set initial state - populate lastChecked dengan data yang sudah ada
            $('input[type="radio"]:checked').each(function() {
                lastChecked[this.name] = this;
                $(this).closest('.form-check').addClass('selected');
            });

            // Calculate initial score
            calculateScore();

            // Initialize checkbox styling for pre-checked items
            $('.form-check-input[type="checkbox"]:checked').each(function() {
                $(this).closest('.form-check').addClass('selected');
            });

            // Function to calculate total score
            function calculateScore() {
                let totalScore = 0;
                let filledCount = 0;

                // Hitung skor untuk setiap kategori
                const categories = [
                    'riwayat_jatuh_1a', 'riwayat_jatuh_1b',
                    'status_mental_2a', 'status_mental_2b', 'status_mental_2c',
                    'penglihatan_3a', 'penglihatan_3b', 'penglihatan_3c',
                    'kebiasaan_berkemih_4a',
                    'transfer', 'mobilitas'
                ];

                let categoryScores = {};

                // Ambil nilai dari setiap field yang terisi
                categories.forEach(function(category) {
                    const checkedInput = $('input[type="radio"][name="' + category + '"]:checked');
                    if (checkedInput.length > 0) {
                        categoryScores[category] = parseInt(checkedInput.val());
                        filledCount++;
                    }
                });

                // Kalkulasi skor khusus
                // 1. Riwayat Jatuh - jika salah satu atau kedua "Ya" = 6, jika kedua "Tidak" = 0
                let riwayatJatuhScore = 0;
                const riwayat1a = categoryScores['riwayat_jatuh_1a'];
                const riwayat1b = categoryScores['riwayat_jatuh_1b'];

                if ((riwayat1a !== undefined && riwayat1a === 6) || (riwayat1b !== undefined && riwayat1b === 6)) {
                    riwayatJatuhScore = 6;
                } else if (riwayat1a !== undefined && riwayat1b !== undefined) {
                    riwayatJatuhScore = 0;
                }
                totalScore += riwayatJatuhScore;

                // 2. Status Mental - jika salah satu atau lebih "Ya" = 14, jika semua "Tidak" = 0
                let statusMentalScore = 0;
                const mental2a = categoryScores['status_mental_2a'];
                const mental2b = categoryScores['status_mental_2b'];
                const mental2c = categoryScores['status_mental_2c'];

                if ((mental2a !== undefined && mental2a === 14) ||
                    (mental2b !== undefined && mental2b === 14) ||
                    (mental2c !== undefined && mental2c === 14)) {
                    statusMentalScore = 14;
                } else if (mental2a !== undefined && mental2b !== undefined && mental2c !== undefined) {
                    statusMentalScore = 0;
                }
                totalScore += statusMentalScore;

                // 3. Penglihatan - jika salah satu atau lebih "Ya" = 1, jika semua "Tidak" = 0
                let penglihatanScore = 0;
                const penglihatan3a = categoryScores['penglihatan_3a'];
                const penglihatan3b = categoryScores['penglihatan_3b'];
                const penglihatan3c = categoryScores['penglihatan_3c'];

                if ((penglihatan3a !== undefined && penglihatan3a === 1) ||
                    (penglihatan3b !== undefined && penglihatan3b === 1) ||
                    (penglihatan3c !== undefined && penglihatan3c === 1)) {
                    penglihatanScore = 1;
                } else if (penglihatan3a !== undefined && penglihatan3b !== undefined && penglihatan3c !==
                    undefined) {
                    penglihatanScore = 0;
                }
                totalScore += penglihatanScore;

                // 4. Kebiasaan Berkemih
                totalScore += categoryScores['kebiasaan_berkemih_4a'] || 0;

                // 5. Transfer + Mobilitas - logika khusus
                let transferMobilitasScore = 0;
                let transferValue = categoryScores['transfer'] || 0;
                let mobilitasValue = categoryScores['mobilitas'] || 0;
                let totalTransferMobilitas = transferValue + mobilitasValue;

                if (totalTransferMobilitas >= 0 && totalTransferMobilitas <= 3) {
                    transferMobilitasScore = 0;
                } else if (totalTransferMobilitas >= 4 && totalTransferMobilitas <= 6) {
                    transferMobilitasScore = 7;
                }
                totalScore += transferMobilitasScore;

                if (filledCount > 0) {
                    updateScoreDisplay(totalScore, filledCount, categories.length);
                } else {
                    $('#scoreDisplay').hide();
                    $('#interventionSection').hide();
                }
            }

            // Function to update score display
            function updateScoreDisplay(score, filledCount, totalFields) {
                $('#geriatri_skorTotal').text(score);
                $('#geriatri_skorTotalInput').val(score);

                $('#geriatri_intervensiRR').hide();
                $('#geriatri_intervensiRS').hide();
                $('#geriatri_intervensiRT').hide();

                let kategoriRisiko = '';

                if (filledCount < totalFields) {
                    kategoriRisiko = 'Skor Sementara';
                    $('#geriatri_kategoriResiko').text(kategoriRisiko);
                } else {
                    if (score >= 0 && score <= 5) {
                        kategoriRisiko = 'Risiko Rendah';
                        $('#geriatri_kategoriResiko').text(kategoriRisiko).removeClass('text-warning text-danger')
                            .addClass('text-success');
                        $('#geriatri_intervensiRR').show();
                    } else if (score >= 6 && score <= 16) {
                        kategoriRisiko = 'Risiko Sedang';
                        $('#geriatri_kategoriResiko').text(kategoriRisiko).removeClass('text-success text-danger')
                            .addClass('text-warning');
                        $('#geriatri_intervensiRS').show();
                    } else if (score >= 17 && score <= 30) {
                        kategoriRisiko = 'Risiko Tinggi';
                        $('#geriatri_kategoriResiko').text(kategoriRisiko).removeClass('text-success text-warning')
                            .addClass('text-danger');
                        $('#geriatri_intervensiRT').show();
                    } else {
                        kategoriRisiko = 'Skor Tidak Valid';
                        $('#geriatri_kategoriResiko').text(kategoriRisiko).removeClass(
                            'text-success text-warning text-danger');
                    }
                }

                $('#geriatri_kategoriResikoInput').val(kategoriRisiko);
            }

            // Function untuk menampilkan intervensi berdasarkan kategori risiko
            function tampilkanIntervensi(kategori) {
                // Sembunyikan semua intervensi terlebih dahulu
                $('#geriatri_intervensiRR').hide();
                $('#geriatri_intervensiRS').hide();
                $('#geriatri_intervensiRT').hide();

                // Tampilkan intervensi sesuai kategori
                if (kategori === 'Risiko Rendah') {
                    $('#geriatri_intervensiRR').show();
                } else if (kategori === 'Risiko Sedang') {
                    $('#geriatri_intervensiRS').show();
                } else if (kategori === 'Risiko Tinggi') {
                    $('#geriatri_intervensiRT').show();
                }
            }

            // Function untuk mengecek duplikasi (exclude current record)
            function checkDuplicateDateTime() {
                const tanggal = $('#tanggal_implementasi').val();
                const shift = $('#shift').val();
                const currentId = '{{ $dataSkalaGeriatri->id }}';

                if (tanggal && shift) {
                    $.ajax({
                        url: "{{ route('rawat-inap.resiko-jatuh.geriatri.check-duplicate', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
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

            // ======= HANYA INI YANG PERLU UNTUK RADIO BUTTON =======
            // Event handler untuk fitur uncheck pada radio button
            $('input[type="radio"]').on('click', function() {
                const groupName = this.name;

                // Jika radio yang sama diklik lagi, uncheck
                if (lastChecked[groupName] === this && this.checked) {
                    this.checked = false;
                    lastChecked[groupName] = null;
                } else {
                    lastChecked[groupName] = this;
                }

                // Update visual selected state
                $('.form-check').removeClass('selected');
                $('input[type="radio"]:checked').each(function() {
                    $(this).closest('.form-check').addClass('selected');
                });

                // Calculate score
                calculateScore();
            });
            // ======= AKHIR RADIO BUTTON HANDLER =======

            // Event listener untuk checkbox intervention styling
            $('.form-check-input[type="checkbox"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).closest('.form-check').addClass('selected');
                } else {
                    $(this).closest('.form-check').removeClass('selected');
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

            // Tambahkan CSS untuk medium-risk jika belum ada
            if (!$('style:contains("medium-risk")').length) {
                $('<style>').text(`
                    .score-category.medium-risk {
                        color: #fd7e14;
                    }
                `).appendTo('head');
            }

        });
    </script>
@endpush
