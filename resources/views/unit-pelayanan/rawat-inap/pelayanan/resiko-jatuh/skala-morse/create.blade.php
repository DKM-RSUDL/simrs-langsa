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
                    'title' => 'Tambah Pengkajian Resiko Jatuh - Skala Morse',
                    'description' =>
                        'Tambah data pengkajian resiko jatuh - skala morse pasien rawat inap dengan mengisi formulir di bawah ini.',
                ])

                <form id="resikoJatuh_form" method="POST"
                    action="{{ route('rawat-inap.resiko-jatuh.morse.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                    @csrf

                    <!-- Data Dasar -->
                    <div class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Hari ke <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="hari_ke" value="{{ old('hari_ke') }}"
                                    min="1" placeholder="Masukkan hari ke..." required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Shift <span class="text-danger">*</span></label>
                                <select class="form-select" id="shift" name="shift" required>
                                    <option value="">Pilih Shift</option>
                                    <option value="PG" {{ old('shift') == 'PG' ? 'selected' : '' }}>Pagi (PG)</option>
                                    <option value="SI" {{ old('shift') == 'SI' ? 'selected' : '' }}>Siang (SI)</option>
                                    <option value="ML" {{ old('shift') == 'ML' ? 'selected' : '' }}>Malam (ML)</option>
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
                        <input type="hidden" name="existing_riwayat_jatuh" value="{{ $lastAssessment->riwayat_jatuh }}">
                        <input type="hidden" name="existing_diagnosa_sekunder"
                            value="{{ $lastAssessment->diagnosa_sekunder }}">
                        <input type="hidden" name="existing_bantuan_ambulasi"
                            value="{{ $lastAssessment->bantuan_ambulasi }}">
                        <input type="hidden" name="existing_terpasang_infus"
                            value="{{ $lastAssessment->terpasang_infus }}">
                        <input type="hidden" name="existing_gaya_berjalan" value="{{ $lastAssessment->gaya_berjalan }}">
                        <input type="hidden" name="existing_status_mental" value="{{ $lastAssessment->status_mental }}">
                        <input type="hidden" name="existing_skor_total" value="{{ $lastAssessment->skor_total }}">
                        <input type="hidden" name="existing_kategori_resiko"
                            value="{{ $lastAssessment->kategori_resiko }}">
                    @else
                        <input type="hidden" name="use_existing_assessment" id="use_existing_assessment" value="0">
                    @endif

                    <!-- Penilaian Resiko Jatuh -->
                    <div id="penilaianSection" class="mb-4"
                        style="display: {{ !isset($lastAssessment) ? 'block' : 'none' }};">
                        <h5 class="mb-3">Penilaian Resiko Jatuh (Skala Morse)</h5>

                        <!-- Riwayat Jatuh -->
                        <div class="mb-3">
                            <label class="fw-bold d-block mb-2">1. Riwayat Jatuh:</label>
                            <label for="resikoJatuh_riwayat_tidak" class="form-check bg-light p-3 rounded mb-2"
                                data-group="riwayat_jatuh">
                                <div class="form-check-label d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input" type="radio" name="riwayat_jatuh"
                                            id="resikoJatuh_riwayat_tidak" value="0">
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
                                            id="resikoJatuh_riwayat_ya" value="25">
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
                                            id="resikoJatuh_diagnosa_tidak" value="0">
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
                                            id="resikoJatuh_diagnosa_ya" value="15">
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
                                            id="resikoJatuh_ambulasi_tidak" value="0">
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
                                            id="resikoJatuh_ambulasi_kruk" value="15">
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
                                            id="resikoJatuh_ambulasi_meja" value="30">
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
                                            id="resikoJatuh_infus_tidak" value="0">
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
                                            id="resikoJatuh_infus_ya" value="20">
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
                                            id="resikoJatuh_berjalan_normal" value="0">
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
                                            id="resikoJatuh_berjalan_lemah" value="10">
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
                                            id="resikoJatuh_berjalan_terganggu" value="20">
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
                                            id="resikoJatuh_mental_orientasi" value="0">
                                        <span>
                                            a. Berorientasi pada kemampuannya
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
                                            id="resikoJatuh_mental_lupa" value="15">
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
                            value="{{ $lastAssessment->skor_total ?? '' }}">
                        <input type="hidden" name="kategori_resiko" id="resikoJatuh_kategoriResikoInput"
                            value="{{ $lastAssessment->kategori_resiko ?? '' }}">
                    </div> <!-- INTERVENSI RESIKO RENDAH (RR) -->
                    <div id="resikoJatuh_intervensiRR" class="mb-4" style="display: none;">
                        <h5 class="mb-3">INTERVENSI PENCEGAHAN JATUH - RESIKO RENDAH/STANDAR (RR)</h5>

                        <div class="alert alert-success">
                            <strong>INFORMASI:</strong> Beri tanda cek (√) pada tindakan yang dilakukan
                            <ol class="mb-0 mt-2">
                                <li>RT: intervensi setiap shift dan dinilai ulang setiap 2 hari</li>
                                <li>RS: intervensi setiap pagi dan dinilai ulang tiap 3 hari</li>
                                <li>RR: intervensi setiap pagi dan dinilai ulang tiap 3 hari</li>
                            </ol>
                        </div>

                        <label class="fw-bold d-block mb-3 text-success">Pilih Intervensi yang Akan Dilakukan:</label>

                        <label for="rr_intervensi_1" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_1"
                                value="tingkatkan_observasi">
                            <div class="form-check-label">
                                <strong>1. Tingkatkan observasi bantuan yang sesuai saat ambulasi</strong>
                            </div>
                        </label>

                        <label for="rr_intervensi_2" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_2"
                                value="orientasi_pasien">
                            <div class="form-check-label">
                                <strong>2. Orientasikan pasien terhadap lingkungan dan rutinitas RS:</strong>
                                <ol type="a" class="mt-2 mb-0 small">
                                    <li>Tunjukkan lokasi kamar mandi</li>
                                    <li>Jika pasien linglung, orientasi dilaksanakan bertahap</li>
                                    <li>Tempatkan bel ditempat yang mudah dicapai</li>
                                    <li>Instruksikan meminta bantuan perawat sebelum turun dari tempat tidur</li>
                                </ol>
                            </div>
                        </label>

                        <label for="rr_intervensi_3" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_3"
                                value="pagar_pengaman">
                            <div class="form-check-label">
                                <strong>3. Pagar pengaman tempat tidur dinaikkan</strong>
                            </div>
                        </label>

                        <label for="rr_intervensi_4" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_4"
                                value="tempat_tidur_rendah">
                            <div class="form-check-label">
                                <strong>4. Tempat tidur dalam posisi rendah terkunci</strong>
                            </div>
                        </label>

                        <label for="rr_intervensi_5" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_5"
                                value="edukasi_perilaku">
                            <div class="form-check-label">
                                <strong>5. Edukasi perilaku yang lebih aman saat jatuh atau transfer</strong>
                            </div>
                        </label>

                        <label for="rr_intervensi_6" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_6"
                                value="monitor_kebutuhan_pasien">
                            <div class="form-check-label">
                                <strong>6. Monitor kebutuhan pasien secara berkala (minimalnya tiap 2 jam)</strong>
                            </div>
                        </label>

                        <label for="rr_intervensi_7" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_7"
                                value="anjurkan_tidak_menggunakan_kaus">
                            <div class="form-check-label">
                                <strong>7. Anjurkan pasien tidak menggunakan kaus kaki atau sepatu yang licin</strong>
                            </div>
                        </label>

                        <label for="rr_intervensi_8" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rr[]" id="rr_intervensi_8"
                                value="lantai_kamar_mandi">
                            <div class="form-check-label">
                                <strong>8. Lantai kamar mandi dengan karpet antislip, tidak licin</strong>
                            </div>
                        </label>
                    </div>

                    <!-- INTERVENSI RESIKO SEDANG (RS) -->
                    <div id="resikoJatuh_intervensiRS" class="mb-4" style="display: none;">
                        <h5 class="mb-3">INTERVENSI PENCEGAHAN JATUH - RESIKO SEDANG (RS)</h5>

                        <div class="alert alert-warning">
                            <strong>PERHATIAN:</strong> Beri tanda cek (√) pada tindakan yang dilakukan
                            <ol class="mb-0 mt-2">
                                <li>RT: intervensi setiap shift dan dinilai ulang setiap 2 hari</li>
                                <li>RS: intervensi setiap pagi dan dinilai ulang tiap 3 hari</li>
                                <li>RR: intervensi setiap pagi dan dinilai ulang tiap 3 hari</li>
                            </ol>
                        </div>

                        <label class="fw-bold d-block mb-3 text-warning">Pilih Intervensi yang Akan Dilakukan:</label>

                        <label for="rs_intervensi_1" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_1"
                                value="lakukan_semua_intervensi_rendah">
                            <div class="form-check-label">
                                <strong>1. Lakukan SEMUA intervensi jatuh resiko rendah / standar</strong>
                            </div>
                        </label>

                        <label for="rs_intervensi_2" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_2"
                                value="pakai_gelang_risiko">
                            <div class="form-check-label">
                                <strong>2. Pakailah gelang risiko jatuh berwarna kuning</strong>
                            </div>
                        </label>

                        <label for="rs_intervensi_3" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_3"
                                value="pasang_gambar_risiko">
                            <div class="form-check-label">
                                <strong>3. Pasang gambar risiko jatuh diatas tempat tidur pasien dan pada pintu kamar
                                    pasien</strong>
                            </div>
                        </label>

                        <label for="rs_intervensi_4" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_4"
                                value="tempatkan_risiko_jatuh">
                            <div class="form-check-label">
                                <strong>4. Tempatkan tanda resiko pasien jatuh pada daftar nama pasien (warna
                                    kuning)</strong>
                            </div>
                        </label>

                        <label for="rs_intervensi_5" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_5"
                                value="pertimbangkan_riwayat_obat">
                            <div class="form-check-label">
                                <strong>5. Pertimbangkan riwayat obat-obatan dan suplemen untuk mengevaluasi
                                    pengobatan</strong>
                            </div>
                        </label>

                        <label for="rs_intervensi_6" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_6"
                                value="gunakan_alat_bantu">
                            <div class="form-check-label">
                                <strong>6. Gunakan alat bantu jalan (walker, handrail)</strong>
                            </div>
                        </label>

                        <label for="rs_intervensi_7" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rs[]" id="rs_intervensi_7"
                                value="dorong_partisipasi_keluarga">
                            <div class="form-check-label">
                                <strong>7. Dorong partisipasi keluarga dalam keselamatan pasien</strong>
                            </div>
                        </label>
                    </div>

                    <!-- INTERVENSI RESIKO TINGGI (RT) -->
                    <div id="resikoJatuh_intervensiRT" class="mb-4" style="display: none;">
                        <h5 class="mb-3">INTERVENSI PENCEGAHAN JATUH - RESIKO TINGGI (RT)</h5>

                        <div class="alert alert-danger">
                            <strong>PERHATIAN:</strong> Beri tanda cek (√) pada tindakan yang dilakukan
                            <ol class="mb-0 mt-2">
                                <li>RT: intervensi setiap shift dan dinilai ulang setiap 2 hari</li>
                                <li>RS: intervensi setiap pagi dan dinilai ulang tiap 3 hari</li>
                                <li>RR: intervensi setiap pagi dan dinilai ulang tiap 3 hari</li>
                            </ol>
                        </div>

                        <label class="fw-bold d-block mb-3 text-danger">Pilih Intervensi yang Akan Dilakukan:</label>

                        <label for="rt_intervensi_1" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rt[]" id="rt_intervensi_1"
                                value="lakukan_semua_intervensi">
                            <div class="form-check-label">
                                <strong>1. Lakukan SEMUA intervensi jatuh resiko rendah / standar dan resiko sedang</strong>
                            </div>
                        </label>

                        <label for="rt_intervensi_2" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rt[]" id="rt_intervensi_2"
                                value="jangan_tinggalkan_pasien">
                            <div class="form-check-label">
                                <strong>2. Jangan tinggalkan pasien saat di ruangan diagnostic atau tindakan</strong>
                            </div>
                        </label>

                        <label for="rt_intervensi_3" class="form-check bg-light p-3 rounded mb-2">
                            <input class="form-check-input" type="checkbox" name="intervensi_rt[]" id="rt_intervensi_3"
                                value="penempatan_dekat_nurse_station">
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
                            <div class="card-body">
                                <h6 class="card-title fw-bold">Kategori Risiko:</h6>
                                <ul class="mb-0" style="list-style: none;">
                                    <li class="mb-2">
                                        <span class="badge bg-success me-2">RR</span>
                                        <strong>Resiko Rendah (0 - 24)</strong>
                                    </li>
                                    <li class="mb-2">
                                        <span class="badge bg-warning text-dark me-2">RS</span>
                                        <strong>Resiko Sedang (25 - 44)</strong>
                                    </li>
                                    <li>
                                        <span class="badge bg-danger me-2">RT</span>
                                        <strong>Resiko Tinggi (≥ 45)</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title fw-bold">Pengkajian resiko jatuh dilakukan pada waktu:</h6>
                                <ol type="a" class="mb-0">
                                    <li class="mb-1">Saat pasien masuk RS / Initial Assessment (IA)</li>
                                    <li class="mb-1">Saat kondisi pasien berubah atau ada perubahan dalam terapi
                                        medik / Change Of Condition (CC)</li>
                                    <li class="mb-1">Saat pasien dipindahkan ke Unit lain / Ward Transfer (WT)</li>
                                    <li>Setelah kejadian jatuh / Post Fall (PF)</li>
                                </ol>
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

            // Fungsi untuk menampilkan intervensi berdasarkan kategori (aturan: RT -> hanya RT, RS -> RS+RR, RR -> RR)
            function tampilkanIntervensi(kategori) {
                const k = (kategori || '').toString().trim().toUpperCase();
                let code = '';
                if (k === 'RR' || k.includes('RENDAH')) code = 'RR';
                else if (k === 'RS' || k.includes('SEDANG')) code = 'RS';
                else if (k === 'RT' || k.includes('TINGGI')) code = 'RT';

                // sembunyikan semua dulu
                $('#resikoJatuh_intervensiRR, #resikoJatuh_intervensiRS, #resikoJatuh_intervensiRT').hide();

                if (code === 'RR') {
                    $('#resikoJatuh_intervensiRR').show();
                } else if (code === 'RS') {
                    // RS menampilkan RS + RR
                    $('#resikoJatuh_intervensiRS').show();
                    $('#resikoJatuh_intervensiRR').show();
                } else if (code === 'RT') {
                    // RT kumulatif: tampilkan RT + RS + RR
                    $('#resikoJatuh_intervensiRT').show();
                    $('#resikoJatuh_intervensiRS').show();
                    $('#resikoJatuh_intervensiRR').show();
                } else {
                    // tidak dinilai — sembunyikan semua
                    $('#resikoJatuh_intervensiRR, #resikoJatuh_intervensiRS, #resikoJatuh_intervensiRT').hide();
                }
            }

            // Event listener untuk checkbox enable penilaian
            $('#enableResikoJatuh').on('change', function() {
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
                    const existingSkor = $('input[name="existing_skor_total"]').val();
                    const existingKategori = $('input[name="existing_kategori_resiko"]').val();

                    if (existingSkor && existingKategori) {
                        $('#resikoJatuh_skorTotal').text(existingSkor);
                        $('#resikoJatuh_kategoriResiko').text(existingKategori);
                        $('#resikoJatuh_skorTotalInput').val(existingSkor);
                        $('#resikoJatuh_kategoriResikoInput').val(existingKategori);
                        tampilkanIntervensi(existingKategori);
                    } else {
                        hitungSkorDanKategori();
                    }
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
            if (skorTotalInput && kategoriInput) {
                // Jika ada lastAssessment, gunakan skor dan kategori dari sana
                $('#resikoJatuh_skorTotal').text(skorTotalInput);
                $('#resikoJatuh_kategoriResiko').text(kategoriInput);
                tampilkanIntervensi(kategoriInput);
                $('#hasilSection').show();
            } else {
                // Jika tidak ada, hitung dari penilaian
                hitungSkorDanKategori();
                if ($('#enableResikoJatuh').is(':checked')) {
                    $('#hasilSection').show();
                } else {
                    $('#hasilSection').hide();
                }
            }
        });
    </script>
@endpush
