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
                    'title' => 'Perbarui Pengkajian Resiko Jatuh - Skala Morse',
                    'description' =>
                        'Perbarui data pengkajian resiko jatuh - skala morse pasien rawat inap dengan mengisi formulir di bawah ini.',
                ])

                <form id="resikoJatuh_form" method="POST"
                    action="{{ route('rawat-inap.resiko-jatuh.morse.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $skalaMorse->id]) }}">
                    @csrf
                    @method('PUT')

                    <!-- Data Dasar -->
                    <div class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" id="tanggal"
                                    value="{{ old('tanggal', $skalaMorse->tanggal ? $skalaMorse->tanggal->format('Y-m-d') : '') }}"
                                    required>
                                @error('tanggal')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="hari_ke" class="form-label">Hari Ke</label>
                                <input type="number" class="form-control" name="hari_ke" id="hari_ke" min="1"
                                    value="{{ old('hari_ke', $skalaMorse->hari_ke) }}" required>
                                @error('hari_ke')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="shift" class="form-label">Shift</label>
                                <select class="form-select" name="shift" id="shift" required>
                                    <option value="">Pilih Shift</option>
                                    <option value="PG" {{ old('shift', $skalaMorse->shift) == 'PG' ? 'selected' : '' }}>
                                        Pagi</option>
                                    <option value="SI" {{ old('shift', $skalaMorse->shift) == 'SI' ? 'selected' : '' }}>
                                        Siang</option>
                                    <option value="ML" {{ old('shift', $skalaMorse->shift) == 'ML' ? 'selected' : '' }}>
                                        Malam</option>
                                </select>
                                @error('shift')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Checkbox Enable Penilaian -->
                    <div class="mb-4">
                        <label for="enableResikoJatuh" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" id="enableResikoJatuh">
                            <div class="form-check-label">
                                Ceklis jika akan membuat penilaian resiko jatuh
                            </div>
                        </label>
                    </div>

                    <!-- Hidden inputs untuk data penilaian saat tidak membuat penilaian baru -->
                    <input type="hidden" name="use_existing_assessment" id="use_existing_assessment" value="1">
                    <input type="hidden" name="existing_riwayat_jatuh" value="{{ $skalaMorse->riwayat_jatuh }}">
                    <input type="hidden" name="existing_diagnosa_sekunder" value="{{ $skalaMorse->diagnosa_sekunder }}">
                    <input type="hidden" name="existing_bantuan_ambulasi" value="{{ $skalaMorse->bantuan_ambulasi }}">
                    <input type="hidden" name="existing_terpasang_infus" value="{{ $skalaMorse->terpasang_infus }}">
                    <input type="hidden" name="existing_gaya_berjalan" value="{{ $skalaMorse->gaya_berjalan }}">
                    <input type="hidden" name="existing_status_mental" value="{{ $skalaMorse->status_mental }}">
                    <input type="hidden" name="existing_skor_total" value="{{ $skalaMorse->skor_total }}">
                    <input type="hidden" name="existing_kategori_resiko" value="{{ $skalaMorse->kategori_resiko }}">

                    <!-- Penilaian Resiko Jatuh -->
                    <div id="penilaianSection" class="mb-4" style="display: none;">
                        <h5 class="mb-3">Penilaian Resiko Jatuh (Skala Morse)</h5>

                        <!-- Riwayat Jatuh -->
                        <div class="mb-3">
                            <label class="fw-bold d-block mb-2">1. Riwayat Jatuh:</label>
                            <label for="resikoJatuh_riwayat_tidak" class="form-check bg-light p-3 rounded mb-2"
                                data-group="riwayat_jatuh">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="radio" name="riwayat_jatuh"
                                            id="resikoJatuh_riwayat_tidak" value="0"
                                            {{ old('riwayat_jatuh', $skalaMorse->riwayat_jatuh) == '0' ? 'checked' : '' }}>
                                        <span>
                                            a. Tidak
                                        </span>
                                    </div>
                                    <span class="badge bg-primary">Skor: 0</span>
                                </div>
                            </label>
                            <label for="resikoJatuh_riwayat_ya" class="form-check bg-light p-3 rounded"
                                data-group="riwayat_jatuh">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="radio" name="riwayat_jatuh"
                                            id="resikoJatuh_riwayat_ya" value="25"
                                            {{ old('riwayat_jatuh', $skalaMorse->riwayat_jatuh) == '25' ? 'checked' : '' }}>
                                        <span>
                                            b. Ya
                                        </span>
                                    </div>
                                    <span class="badge bg-primary">Skor: 25</span>
                                </div>
                            </label>
                        </div>

                        <!-- Diagnosa Sekunder -->
                        <div class="mb-3">
                            <label class="fw-bold d-block mb-2">2. Diagnosa Sekunder:</label>
                            <label for="resikoJatuh_diagnosa_tidak" class="form-check bg-light p-3 rounded mb-2"
                                data-group="diagnosa_sekunder">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="radio" name="diagnosa_sekunder"
                                            id="resikoJatuh_diagnosa_tidak" value="0"
                                            {{ old('diagnosa_sekunder', $skalaMorse->diagnosa_sekunder) == '0' ? 'checked' : '' }}>
                                        <span>
                                            a. Tidak
                                        </span>
                                    </div>
                                    <span class="badge bg-primary">Skor: 0</span>
                                </div>
                            </label>
                            <label for="resikoJatuh_diagnosa_ya" class="form-check bg-light p-3 rounded"
                                data-group="diagnosa_sekunder">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="radio" name="diagnosa_sekunder"
                                            id="resikoJatuh_diagnosa_ya" value="15"
                                            {{ old('diagnosa_sekunder', $skalaMorse->diagnosa_sekunder) == '15' ? 'checked' : '' }}>
                                        <span>
                                            b. Ya
                                        </span>
                                    </div>
                                    <span class="badge bg-primary">Skor: 15</span>
                                </div>
                            </label>
                        </div>

                        <!-- Bantuan Ambulasi -->
                        <div class="mb-3">
                            <label class="fw-bold d-block mb-2">3. Bantuan Ambulasi:</label>
                            <label for="resikoJatuh_ambulasi_tidak" class="form-check bg-light p-3 rounded mb-2"
                                data-group="bantuan_ambulasi">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="radio" name="bantuan_ambulasi"
                                            id="resikoJatuh_ambulasi_tidak" value="0"
                                            {{ old('bantuan_ambulasi', $skalaMorse->bantuan_ambulasi) == '0' ? 'checked' : '' }}>
                                        <span>
                                            a. Tidak ada / bed rest / bantuan perawat
                                        </span>
                                    </div>
                                    <span class="badge bg-primary">Skor: 0</span>
                                </div>
                            </label>
                            <label for="resikoJatuh_ambulasi_kruk" class="form-check bg-light p-3 rounded mb-2"
                                data-group="bantuan_ambulasi">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="radio" name="bantuan_ambulasi"
                                            id="resikoJatuh_ambulasi_kruk" value="15"
                                            {{ old('bantuan_ambulasi', $skalaMorse->bantuan_ambulasi) == '15' ? 'checked' : '' }}>
                                        <span>
                                            b. Kruk / tongkat / alat bantu berjalan
                                        </span>
                                    </div>
                                    <span class="badge bg-primary">Skor: 15</span>
                                </div>
                            </label>
                            <label for="resikoJatuh_ambulasi_meja" class="form-check bg-light p-3 rounded"
                                data-group="bantuan_ambulasi">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="radio" name="bantuan_ambulasi"
                                            id="resikoJatuh_ambulasi_meja" value="30"
                                            {{ old('bantuan_ambulasi', $skalaMorse->bantuan_ambulasi) == '30' ? 'checked' : '' }}>
                                        <span>
                                            c. Meja / kursi
                                        </span>
                                    </div>
                                    <span class="badge bg-primary">Skor: 30</span>
                                </div>
                            </label>
                        </div>

                        <!-- Terpasang Infus -->
                        <div class="mb-3">
                            <label class="fw-bold d-block mb-2">4. Terpasang Infus:</label>
                            <label for="resikoJatuh_infus_tidak" class="form-check bg-light p-3 rounded mb-2"
                                data-group="terpasang_infus">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="radio" name="terpasang_infus"
                                            id="resikoJatuh_infus_tidak" value="0"
                                            {{ old('terpasang_infus', $skalaMorse->terpasang_infus) == '0' ? 'checked' : '' }}>
                                        <span>
                                            a. Tidak
                                        </span>
                                    </div>
                                    <span class="badge bg-primary">Skor: 0</span>
                                </div>
                            </label>
                            <label for="resikoJatuh_infus_ya" class="form-check bg-light p-3 rounded"
                                data-group="terpasang_infus">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="radio" name="terpasang_infus"
                                            id="resikoJatuh_infus_ya" value="20"
                                            {{ old('terpasang_infus', $skalaMorse->terpasang_infus) == '20' ? 'checked' : '' }}>
                                        <span>
                                            b. Ya
                                        </span>
                                    </div>
                                    <span class="badge bg-primary">Skor: 20</span>
                                </div>
                            </label>
                        </div>

                        <!-- Cara/Gaya Berjalan -->
                        <div class="mb-3">
                            <label class="fw-bold d-block mb-2">5. Cara / gaya berjalan:</label>
                            <label for="resikoJatuh_berjalan_normal" class="form-check bg-light p-3 rounded mb-2"
                                data-group="gaya_berjalan">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="radio" name="gaya_berjalan"
                                            id="resikoJatuh_berjalan_normal" value="0"
                                            {{ old('gaya_berjalan', $skalaMorse->gaya_berjalan) == '0' ? 'checked' : '' }}>
                                        <span>
                                            a. Normal / bed rest / kursi roda
                                        </span>
                                    </div>
                                    <span class="badge bg-primary">Skor: 0</span>
                                </div>
                            </label>
                            <label for="resikoJatuh_berjalan_lemah" class="form-check bg-light p-3 rounded mb-2"
                                data-group="gaya_berjalan">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="radio" name="gaya_berjalan"
                                            id="resikoJatuh_berjalan_lemah" value="10"
                                            {{ old('gaya_berjalan', $skalaMorse->gaya_berjalan) == '10' ? 'checked' : '' }}>
                                        <span>
                                            b. Lemah
                                        </span>
                                    </div>
                                    <span class="badge bg-primary">Skor: 10</span>
                                </div>
                            </label>
                            <label for="resikoJatuh_berjalan_terganggu" class="form-check bg-light p-3 rounded"
                                data-group="gaya_berjalan">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="radio" name="gaya_berjalan"
                                            id="resikoJatuh_berjalan_terganggu" value="20"
                                            {{ old('gaya_berjalan', $skalaMorse->gaya_berjalan) == '20' ? 'checked' : '' }}>
                                        <span>
                                            c. Terganggu
                                        </span>
                                    </div>
                                    <span class="badge bg-primary">Skor: 20</span>
                                </div>
                            </label>
                        </div>

                        <!-- Status Mental -->
                        <div class="mb-3">
                            <label class="fw-bold d-block mb-2">6. Status Mental:</label>
                            <label for="resikoJatuh_mental_orientasi" class="form-check bg-light p-3 rounded mb-2"
                                data-group="status_mental">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="radio" name="status_mental"
                                            id="resikoJatuh_mental_orientasi" value="0"
                                            {{ old('status_mental', $skalaMorse->status_mental) == '0' ? 'checked' : '' }}>
                                        <span>
                                            a. Orientasi baik terhadap kemampuan diri
                                        </span>
                                    </div>
                                    <span class="badge bg-primary">Skor: 0</span>
                                </div>
                            </label>
                            <label for="resikoJatuh_mental_lupa" class="form-check bg-light p-3 rounded"
                                data-group="status_mental">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="radio" name="status_mental"
                                            id="resikoJatuh_mental_lupa" value="15"
                                            {{ old('status_mental', $skalaMorse->status_mental) == '15' ? 'checked' : '' }}>
                                        <span>
                                            b. Lupa akan keterbatasannya
                                        </span>
                                    </div>
                                    <span class="badge bg-primary">Skor: 15</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Hasil Skor -->
                    <div id="hasilSection" class="mb-4">
                        <h5 class="mb-3">Hasil Penilaian</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <label class="form-label fw-bold">Skor Total</label>
                                        <p id="resikoJatuh_skorTotal" class="form-control-plaintext fs-2 fw-bold">0</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <label class="form-label fw-bold">Kategori Resiko</label>
                                        <p id="resikoJatuh_kategoriResiko" class="form-control-plaintext fs-2 fw-bold">
                                            Belum Dinilai
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="skor_total" id="resikoJatuh_skorTotalInput"
                            value="{{ old('skor_total', $skalaMorse->skor_total) }}">
                        <input type="hidden" name="kategori_resiko" id="resikoJatuh_kategoriResikoInput"
                            value="{{ old('kategori_resiko', $skalaMorse->kategori_resiko) }}">
                    </div>

                    @php
                        // Mendapatkan data intervensi yang sudah tersimpan
                        $intervensiRR = $skalaMorse->intervensi_rr ?? [];
                        $intervensiRS = $skalaMorse->intervensi_rs ?? [];
                        $intervensiRT = $skalaMorse->intervensi_rt ?? [];

                        // Pastikan dalam format array dan decode jika perlu
                        if (is_string($intervensiRR)) {
                            $intervensiRR = json_decode($intervensiRR, true) ?? [];
                        }
                        if (is_string($intervensiRS)) {
                            $intervensiRS = json_decode($intervensiRS, true) ?? [];
                        }
                        if (is_string($intervensiRT)) {
                            $intervensiRT = json_decode($intervensiRT, true) ?? [];
                        }

                        // Jika masih string (terkadang double encode), decode lagi
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
                    <div id="resikoJatuh_intervensiRR" class="mb-4"
                        style="display: {{ $currentKategori == 'RR' ? 'block' : 'none' }};">
                        <h5 class="mb-3">INTERVENSI PENCEGAHAN JATUH - RESIKO RENDAH/STANDAR (RR)</h5>

                        <div class="alert alert-success">
                            <strong>INFORMASI:</strong> Beri tanda cek (√) pada tindakan yang dilakukan
                            <ol class="mb-0 mt-2">
                                <li>Lakukan semua tindakan pencegahan risiko rendah</li>
                                <li>Lengkapi lembar observasi risiko jatuh pasien pada format yang tersedia</li>
                                <li>Monitor setiap 4 jam dan dokumentasikan</li>
                            </ol>
                        </div>

                        <label class="fw-bold d-block mb-3 text-success">Pilih Intervensi yang Akan Dilakukan:</label>

                        <label for="rr_intervensi_1" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_1"
                                value="tingkatkan_observasi"
                                {{ in_array('tingkatkan_observasi', old('intervensi_rr', $intervensiRR)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <i class="ti-check text-success"></i>
                                Tingkatkan observasi dan bimbingan kepada pasien
                            </div>
                        </label>

                        <label for="rr_intervensi_2" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_2"
                                value="orientasi_pasien"
                                {{ in_array('orientasi_pasien', old('intervensi_rr', $intervensiRR)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <i class="ti-check text-success"></i>
                                Orientasi pasien tentang tempat tidur rendah, posisi kunci roda tempat tidur,
                                penggunaan rel tempat tidur, tersedianya lampu penerangan yang adekuat,
                                bebas dari hambatan/barang-barang dilantai, posisi bel mudah dijangkau
                            </div>
                        </label>

                        <label for="rr_intervensi_3" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_3"
                                value="pagar_pengaman"
                                {{ in_array('pagar_pengaman', old('intervensi_rr', $intervensiRR)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <i class="ti-check text-success"></i>
                                Mengunci roda dan memasang pagar pengaman tempat tidur
                            </div>
                        </label>

                        <label for="rr_intervensi_4" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_4"
                                value="tempat_tidur_rendah"
                                {{ in_array('tempat_tidur_rendah', old('intervensi_rr', $intervensiRR)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <i class="ti-check text-success"></i>
                                Tempatkan pasien pada tempat tidur yang rendah
                            </div>
                        </label>

                        <label for="rr_intervensi_5" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_5"
                                value="edukasi_perilaku"
                                {{ in_array('edukasi_perilaku', old('intervensi_rr', $intervensiRR)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <i class="ti-check text-success"></i>
                                Edukasi pasien dan keluarga tentang perilaku pencegahan jatuh
                            </div>
                        </label>

                        <label for="rr_intervensi_6" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_6"
                                value="monitor_kebutuhan_pasien"
                                {{ in_array('monitor_kebutuhan_pasien', old('intervensi_rr', $intervensiRR)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <i class="ti-check text-success"></i>
                                Monitor kebutuhan pasien secara berkala
                            </div>
                        </label>

                        <label for="rr_intervensi_7" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_7"
                                value="anjurkan_tidak_menggunakan_kaus"
                                {{ in_array('anjurkan_tidak_menggunakan_kaus', old('intervensi_rr', $intervensiRR)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <i class="ti-check text-success"></i>
                                Anjurkan pasien untuk tidak menggunakan kaus kaki atau menggunakan kaus kaki anti slip
                            </div>
                        </label>

                        <label for="rr_intervensi_8" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_8"
                                value="lantai_kamar_mandi"
                                {{ in_array('lantai_kamar_mandi', old('intervensi_rr', $intervensiRR)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <i class="ti-check text-success"></i>
                                Pastikan lantai kamar mandi tidak licin dan kering
                            </div>
                        </label>
                    </div>

                    <!-- INTERVENSI RESIKO SEDANG (RS) -->
                    <div id="resikoJatuh_intervensiRS" class="mb-4"
                        style="display: {{ $currentKategori == 'RS' ? 'block' : 'none' }};">
                        <h5 class="mb-3">INTERVENSI PENCEGAHAN JATUH - RESIKO SEDANG (RS)</h5>

                        <div class="alert alert-warning">
                            <strong>PERHATIAN:</strong> Beri tanda cek (√) pada tindakan yang dilakukan
                            <ol class="mb-0 mt-2">
                                <li>Lakukan semua tindakan pencegahan risiko rendah</li>
                                <li>Lengkapi lembar observasi risiko jatuh pasien pada format yang tersedia</li>
                                <li>Monitor setiap 4 jam dan dokumentasikan</li>
                            </ol>
                        </div>

                        <label class="fw-bold d-block mb-3 text-warning">Pilih Intervensi yang Akan Dilakukan:</label>

                        <label for="rs_intervensi_1" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_1"
                                value="lakukan_semua_intervensi_rendah"
                                {{ in_array('lakukan_semua_intervensi_rendah', old('intervensi_rs', $intervensiRS)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <i class="ti-check text-warning"></i>
                                Lakukan semua intervensi risiko rendah
                            </div>
                        </label>

                        <label for="rs_intervensi_2" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_2"
                                value="pakai_gelang_risiko"
                                {{ in_array('pakai_gelang_risiko', old('intervensi_rs', $intervensiRS)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <i class="ti-check text-warning"></i>
                                Identifikasi pasien dengan menggunakan gelang risiko jatuh berwarna kuning
                            </div>
                        </label>

                        <label for="rs_intervensi_3" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_3"
                                value="pasang_gambar_risiko"
                                {{ in_array('pasang_gambar_risiko', old('intervensi_rs', $intervensiRS)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <i class="ti-check text-warning"></i>
                                Pasang gambar/label risiko jatuh di tempat tidur pasien
                            </div>
                        </label>

                        <label for="rs_intervensi_4" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_4"
                                value="tempatkan_risiko_jatuh"
                                {{ in_array('tempatkan_risiko_jatuh', old('intervensi_rs', $intervensiRS)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <i class="ti-check text-warning"></i>
                                Tempatkan pasien di kamar yang dekat dengan nurse station
                            </div>
                        </label>

                        <label for="rs_intervensi_5" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_5"
                                value="pertimbangkan_riwayat_obat"
                                {{ in_array('pertimbangkan_riwayat_obat', old('intervensi_rs', $intervensiRS)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <i class="ti-check text-warning"></i>
                                Pertimbangkan riwayat obat yang dapat menyebabkan pasien jatuh
                            </div>
                        </label>

                        <label for="rs_intervensi_6" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_6"
                                value="orientasi_ulang"
                                {{ in_array('orientasi_ulang', old('intervensi_rs', $intervensiRS)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <i class="ti-check text-warning"></i>
                                Lakukan orientasi ulang terhadap lingkungan kamar pasien
                            </div>
                        </label>

                        <label for="rs_intervensi_7" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_7"
                                value="dampingi_mobilisasi"
                                {{ in_array('dampingi_mobilisasi', old('intervensi_rs', $intervensiRS)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <i class="ti-check text-warning"></i>
                                Dampingi pasien saat melakukan mobilisasi
                            </div>
                        </label>
                    </div>

                    <!-- INTERVENSI RESIKO TINGGI (RT) -->
                    <div id="resikoJatuh_intervensiRT" class="mb-4"
                        style="display: {{ $currentKategori == 'RT' ? 'block' : 'none' }};">
                        <h5 class="mb-3">INTERVENSI PENCEGAHAN JATUH - RESIKO TINGGI (RT)</h5>

                        <div class="alert alert-danger">
                            <strong>PENTING:</strong> Beri tanda cek (√) pada tindakan yang dilakukan
                            <ol class="mb-0 mt-2">
                                <li>Lakukan semua tindakan pencegahan risiko rendah dan sedang</li>
                                <li>Lengkapi lembar observasi risiko jatuh pasien pada format yang tersedia</li>
                                <li>Monitor setiap 2 jam dan dokumentasikan</li>
                            </ol>
                        </div>

                        <label class="fw-bold d-block mb-3 text-danger">Pilih Intervensi yang Akan Dilakukan:</label>

                        <label for="rt_intervensi_1" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rt[]" id="rt_intervensi_1"
                                value="lakukan_semua_intervensi"
                                {{ in_array('lakukan_semua_intervensi', old('intervensi_rt', $intervensiRT)) || in_array('lakukan_semua_intervensi_sedang', old('intervensi_rt', $intervensiRT)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <strong>1. Lakukan SEMUA intervensi jatuh resiko rendah / standar dan resiko sedang</strong>
                            </div>
                        </label>

                        <label for="rt_intervensi_2" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rt[]" id="rt_intervensi_2"
                                value="jangan_tinggalkan_pasien"
                                {{ in_array('jangan_tinggalkan_pasien', old('intervensi_rt', $intervensiRT)) || in_array('satu_banding_satu', old('intervensi_rt', $intervensiRT)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <strong>2. Jangan tinggalkan pasien saat di ruangan diagnostic atau tindakan</strong>
                            </div>
                        </label>

                        <label for="rt_intervensi_3" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rt[]" id="rt_intervensi_3"
                                value="penempatan_dekat_nurse_station"
                                {{ in_array('penempatan_dekat_nurse_station', old('intervensi_rt', $intervensiRT)) || in_array('kolaborasi_keluarga', old('intervensi_rt', $intervensiRT)) ? 'checked' : '' }}>
                            <div class="form-check-label">
                                <strong>3. Penempatan pasien dekat nurse station untuk memudahkan observasi (24-48
                                    jam)</strong>
                            </div>
                        </label>
                    </div>

                    <div class="text-end">
                        <x-button-submit />
                    </div>
                </form>

            </x-content-card>
            <x-content-card>
                <!-- Keterangan -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Interpretasi Skor</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <span class="badge bg-success me-2">0 - 24</span>
                                        <strong>Risiko Rendah (RR)</strong>
                                    </li>
                                    <li class="mb-2">
                                        <span class="badge bg-warning me-2">25 - 44</span>
                                        <strong>Risiko Sedang (RS)</strong>
                                    </li>
                                    <li class="mb-2">
                                        <span class="badge bg-danger me-2">≥ 45</span>
                                        <strong>Risiko Tinggi (RT)</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Informasi</h6>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-0">
                                    <strong>Skala Morse Fall Scale</strong> digunakan untuk mengidentifikasi
                                    pasien yang berisiko jatuh. Semakin tinggi skor, semakin tinggi risiko
                                    jatuh. Intervensi yang tepat harus dilakukan berdasarkan kategori risiko.
                                </p>
                            </div>
                        </div>
                    </div>
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

            // Fungsi untuk menghitung skor dan kategori
            function hitungSkorDanKategori() {
                const groups = [
                    'riwayat_jatuh',
                    'diagnosa_sekunder',
                    'bantuan_ambulasi',
                    'terpasang_infus',
                    'gaya_berjalan',
                    'status_mental'
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
                $('#resikoJatuh_skorTotal').text(isNaN(skor) ? 0 : skor);
                $('#resikoJatuh_skorTotalInput').val(isNaN(skor) ? '' : String(skor));

                // Set kategori (0–24 RR, 25–44 RS, >=45 RT)
                let kategori = '';
                if (lengkap && !isNaN(skor)) {
                    if (skor <= 24) kategori = 'RR';
                    else if (skor <= 44) kategori = 'RS';
                    else kategori = 'RT';
                }

                $('#resikoJatuh_kategoriResiko').text(kategori ? kategori : 'Belum Dinilai');
                $('#resikoJatuh_kategoriResikoInput').val(kategori);

                // Tampilkan intervensi sesuai kategori
                tampilkanIntervensi(kategori);
            }

            // Fungsi untuk menampilkan intervensi berdasarkan kategori (kumulatif: RT -> RT+RS+RR, RS -> RS+RR, RR -> RR)
            function tampilkanIntervensi(kategori) {
                const k = (kategori || '').toString().trim().toUpperCase();
                let code = '';
                if (k === 'RR' || k.includes('RENDAH')) code = 'RR';
                else if (k === 'RS' || k.includes('SEDANG')) code = 'RS';
                else if (k === 'RT' || k.includes('TINGGI')) code = 'RT';

                $('#resikoJatuh_intervensiRR, #resikoJatuh_intervensiRS, #resikoJatuh_intervensiRT').hide();

                if (code === 'RR') {
                    // only RR
                    $('#resikoJatuh_intervensiRR').show();
                } else if (code === 'RS') {
                    // RS -> show RS and RR
                    $('#resikoJatuh_intervensiRS').show();
                    $('#resikoJatuh_intervensiRR').show();
                } else if (code === 'RT') {
                    // RT -> show RT, RS and RR (cumulative)
                    $('#resikoJatuh_intervensiRT').show();
                    $('#resikoJatuh_intervensiRS').show();
                    $('#resikoJatuh_intervensiRR').show();
                } else {
                    $('#resikoJatuh_intervensiRR, #resikoJatuh_intervensiRS, #resikoJatuh_intervensiRT').hide();
                }
            }

            // Event listener untuk checkbox enable penilaian
            $('#enableResikoJatuh').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#penilaianSection, #hasilSection').show();
                    $('#use_existing_assessment').val('0');

                    // Hitung skor dari radio button yang ter-check
                    hitungSkorDanKategori();
                } else {
                    $('#penilaianSection').hide();
                    $('#hasilSection').show();
                    $('#use_existing_assessment').val('1');

                    // Reset semua radio button
                    $('input[type="radio"]').prop('checked', false);
                    // Reset visual state
                    $('.form-check[data-group]').removeClass('selected');
                    lastChecked = {};

                    // Gunakan data existing untuk hasil
                    const existingSkor = $('input[name="existing_skor_total"]').val();
                    const existingKategori = $('input[name="existing_kategori_resiko"]').val();

                    $('#resikoJatuh_skorTotal').text(existingSkor || '0');
                    $('#resikoJatuh_kategoriResiko').text(existingKategori || 'Belum Dinilai');
                    $('#resikoJatuh_skorTotalInput').val(existingSkor);
                    $('#resikoJatuh_kategoriResikoInput').val(existingKategori);

                    tampilkanIntervensi(existingKategori);
                }
            });

            // Event listener untuk radio button dengan fitur uncheck
            $('input[type="radio"][name="riwayat_jatuh"], input[type="radio"][name="diagnosa_sekunder"], input[type="radio"][name="bantuan_ambulasi"], input[type="radio"][name="terpasang_infus"], input[type="radio"][name="gaya_berjalan"], input[type="radio"][name="status_mental"]')
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
            $('input[name^="intervensi_"]').on('change', function() {
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

            // Inisialisasi
            const skorTotalInput = $('#resikoJatuh_skorTotalInput').val();
            const kategoriInput = $('#resikoJatuh_kategoriResikoInput').val();

            // Set nilai awal berdasarkan data dari database
            if (skorTotalInput && kategoriInput) {
                $('#resikoJatuh_skorTotal').text(skorTotalInput);
                $('#resikoJatuh_kategoriResiko').text(kategoriInput);
                tampilkanIntervensi(kategoriInput);
                $('#hasilSection').show();

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
                $('#penilaianSection, #hasilSection').show();
                $('#use_existing_assessment').val('0');
            }
        });
    </script>
@endpush
