@extends('layouts.administrator.master')


@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <h4 class="header-asesmen">Asesmen Awal Keperawatan Anak</h4>
                                    <p>
                                        Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <div class="progress-wrapper">
                                        <div class="progress-status">
                                            <span class="progress-label">Progress Pengisian</span>
                                            <span class="progress-percentage">60%</span>
                                        </div>
                                        <div class="custom-progress">
                                            <div class="progress-bar-custom" style="width: 60%"></div>
                                        </div>
                                        <div class="mt-2">
                                            <small class="text-muted">6/10 bagian telah diisi</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FORM ASESMEN AWAL KEPERATAWAN --}}

                        <div class="px-3">
                            <div>
                                <div class="section-separator" id="data-masuk">
                                    <h5 class="section-title">1. Data masuk</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <input type="date" class="form-control" name="tanggal_masuk">
                                            <input type="time" class="form-control" name="jam_masuk">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tiba Di Ruang Rawat Dengan Cara</label>
                                        <select class="form-select" name="cara_masuk">
                                            <option selected disabled>Pilih</option>
                                            <option value="Jalan Kaki">Jalan Kaki</option>
                                            <option value="Kursi Roda">Kursi Roda</option>
                                            <option value="Brankar">Brankar</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kasus Trauma</label>
                                        <select class="form-select" name="kasus_trauma">
                                            <option selected disabled>Pilih</option>
                                            <option value="Ya">Ya</option>
                                            <option value="Tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Jenis Trauma</label>
                                        <select class="form-select" name="jenis_trauma">
                                            <option selected disabled>Pilih</option>
                                            <option value="Kecelakaan">Kecelakaan</option>
                                            <option value="Terjatuh">Terjatuh</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="section-separator" id="anamnesis">
                                    <h5 class="section-title">2. Anamnesis</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Anamnesis</label>
                                        <textarea class="form-control" name="anamnesis" rows="4"
                                            placeholder="keluhan utama dan riwayat penyakit sekarang"></textarea>
                                    </div>
                                </div>

                                <div class="section-separator" id="pemeriksaan-fisik">
                                    <h5 class="section-title">3. Pemeriksaan fisik</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tek. Darah (mmHg)</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <input type="text" class="form-control" name="sistole"
                                                    placeholder="Sistole">
                                            </div>
                                            <div class="flex-grow-1">
                                                <input type="text" class="form-control" name="diastole"
                                                    placeholder="Diastole">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nadi (Per Menit)</label>
                                        <input type="text" class="form-control" name="nadi"
                                            placeholder="frekuensi nadi per menit">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nafas (Per Menit)</label>
                                        <input type="text" class="form-control" name="nafas"
                                            placeholder="frekuensi nafas per menit">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Suhu (C)</label>
                                        <input type="text" class="form-control" name="suhu"
                                            placeholder="suhu dalam celcius">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Saturasi Oksigen (%)</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <input type="text" class="form-control" name="saturasi_o2_tanpa"
                                                    placeholder="Tanpa bantuan O2">
                                            </div>
                                            <div class="flex-grow-1">
                                                <input type="text" class="form-control" name="saturasi_o2_dengan"
                                                    placeholder="Dengan bantuan O2">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kesadaran</label>
                                        <select class="form-select" name="kesadaran">
                                            <option value="" selected disabled>pilih</option>
                                            <!-- Add options here -->
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">AVPU</label>
                                        <select class="form-select" name="avpu">
                                            <option value="" selected disabled>pilih</option>
                                            <!-- Add options here -->
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Penglihatan</label>
                                        <select class="form-select" name="penglihatan">
                                            <option value="" selected disabled>pilih</option>
                                            <!-- Add options here -->
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pendengaran</label>
                                        <select class="form-select" name="pendengaran">
                                            <option value="" selected disabled>pilih</option>
                                            <!-- Add options here -->
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Bicara</label>
                                        <select class="form-select" name="bicara">
                                            <option value="" selected disabled>pilih</option>
                                            <!-- Add options here -->
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Refleks Menelan</label>
                                        <select class="form-select" name="refleks_menelan">
                                            <option value="" selected disabled>pilih</option>
                                            <!-- Add options here -->
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Luka</label>
                                        <select class="form-select" name="luka">
                                            <option value="" selected disabled>pilih</option>
                                            <!-- Add options here -->
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Defekasi</label>
                                        <select class="form-select" name="defekasi">
                                            <option value="" selected disabled>pilih</option>
                                            <!-- Add options here -->
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Miksi</label>
                                        <select class="form-select" name="miksi">
                                            <option value="" selected disabled>pilih</option>
                                            <!-- Add options here -->
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Gastrointestinal</label>
                                        <select class="form-select" name="gastrointestinal">
                                            <option value="" selected disabled>pilih</option>
                                            <!-- Add options here -->
                                        </select>
                                    </div>

                                    <div class="mt-4">
                                        <h6>Antropometri</h6>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tinggi Badan (Kg)</label>
                                            <input type="text" class="form-control" name="tinggi_badan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Berat Badan (Kg)</label>
                                            <input type="text" class="form-control" name="berat_badan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lingkar Kepala (Cm)</label>
                                            <input type="text" class="form-control" name="lingkar_kepala">
                                        </div>
                                    </div>

                                    <div class="alert alert-info mb-3 mt-4">
                                        <p class="mb-0 small">
                                            <i class="bi bi-info-circle me-2"></i>
                                            Centang normal jika fisik yang dinilai normal, pilih tanda tambah untuk menambah
                                            keterangan fisik yang ditemukan tidak normal.
                                            Jika tidak dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                        </p>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Kolom Kiri -->
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column gap-3">
                                                <!-- Item Pemeriksaan -->
                                                <div class="pemeriksaan-item">
                                                    <div class="d-flex align-items-center border-bottom pb-2">
                                                        <div class="flex-grow-1">Kepala</div>
                                                        <div class="form-check me-3">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="kepala-normal">
                                                            <label class="form-check-label"
                                                                for="kepala-normal">Normal</label>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                            type="button" data-target="kepala-keterangan">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="keterangan mt-2" id="kepala-keterangan"
                                                        style="display:none;">
                                                        <input type="text" class="form-control"
                                                            name="kepala_keterangan"
                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                    </div>
                                                </div>

                                                <div class="pemeriksaan-item">
                                                    <div class="d-flex align-items-center border-bottom pb-2">
                                                        <div class="flex-grow-1">Mata</div>
                                                        <div class="form-check me-3">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="mata-normal">
                                                            <label class="form-check-label"
                                                                for="mata-normal">Normal</label>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                            type="button" data-target="mata-keterangan">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="keterangan mt-2" id="mata-keterangan"
                                                        style="display:none;">
                                                        <input type="text" class="form-control" name="mata_keterangan"
                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                    </div>
                                                </div>
                                                <div class="pemeriksaan-item">
                                                    <div class="d-flex align-items-center border-bottom pb-2">
                                                        <div class="flex-grow-1">Kepala</div>
                                                        <div class="form-check me-3">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="kepala-normal">
                                                            <label class="form-check-label"
                                                                for="kepala-normal">Normal</label>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                            type="button" data-target="kepala-keterangan">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="keterangan mt-2" id="kepala-keterangan"
                                                        style="display:none;">
                                                        <input type="text" class="form-control"
                                                            name="kepala_keterangan"
                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                    </div>
                                                </div>

                                                <div class="pemeriksaan-item">
                                                    <div class="d-flex align-items-center border-bottom pb-2">
                                                        <div class="flex-grow-1">Mata</div>
                                                        <div class="form-check me-3">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="mata-normal">
                                                            <label class="form-check-label"
                                                                for="mata-normal">Normal</label>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                            type="button" data-target="mata-keterangan">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="keterangan mt-2" id="mata-keterangan"
                                                        style="display:none;">
                                                        <input type="text" class="form-control" name="mata_keterangan"
                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Kolom Kanan -->
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column gap-3">
                                                <div class="pemeriksaan-item">
                                                    <div class="d-flex align-items-center border-bottom pb-2">
                                                        <div class="flex-grow-1">Telinga</div>
                                                        <div class="form-check me-3">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="telinga-normal">
                                                            <label class="form-check-label"
                                                                for="telinga-normal">Normal</label>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                            type="button" data-target="telinga-keterangan">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="keterangan mt-2" id="telinga-keterangan"
                                                        style="display:none;">
                                                        <input type="text" class="form-control"
                                                            name="telinga_keterangan"
                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                    </div>
                                                </div>

                                                <div class="pemeriksaan-item">
                                                    <div class="d-flex align-items-center border-bottom pb-2">
                                                        <div class="flex-grow-1">Hidung</div>
                                                        <div class="form-check me-3">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="hidung-normal">
                                                            <label class="form-check-label"
                                                                for="hidung-normal">Normal</label>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                            type="button" data-target="hidung-keterangan">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="keterangan mt-2" id="hidung-keterangan"
                                                        style="display:none;">
                                                        <input type="text" class="form-control"
                                                            name="hidung_keterangan"
                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                    </div>
                                                </div>
                                                <div class="pemeriksaan-item">
                                                    <div class="d-flex align-items-center border-bottom pb-2">
                                                        <div class="flex-grow-1">Telinga</div>
                                                        <div class="form-check me-3">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="telinga-normal">
                                                            <label class="form-check-label"
                                                                for="telinga-normal">Normal</label>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                            type="button" data-target="telinga-keterangan">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="keterangan mt-2" id="telinga-keterangan"
                                                        style="display:none;">
                                                        <input type="text" class="form-control"
                                                            name="telinga_keterangan"
                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                    </div>
                                                </div>

                                                <div class="pemeriksaan-item">
                                                    <div class="d-flex align-items-center border-bottom pb-2">
                                                        <div class="flex-grow-1">Hidung</div>
                                                        <div class="form-check me-3">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="hidung-normal">
                                                            <label class="form-check-label"
                                                                for="hidung-normal">Normal</label>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                            type="button" data-target="hidung-keterangan">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="keterangan mt-2" id="hidung-keterangan"
                                                        style="display:none;">
                                                        <input type="text" class="form-control"
                                                            name="hidung_keterangan"
                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator" id="status-nyeri">
                                    <h5 class="section-title">4. Status nyeri</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Jenis Skala NYERI</label>
                                        <select class="form-select" name="jenis_skala_nyeri">
                                            <option value="" selected disabled>pilih</option>
                                            <option value="NRS">Numeric Rating Scale (NRS)</option>
                                            <option value="FLACC">FLACC Scale</option>
                                            <option value="Wong-Baker">Wong-Baker FACES Scale</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nilai Skala Nyeri</label>
                                        <select class="form-select" name="nilai_skala_nyeri">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kesimpulan Nyeri</label>
                                        <div class="alert alert-success">
                                            Nyeri Ringan
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6 class="mb-3">Karakteristik Nyeri</h6>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Lokasi</label>
                                                <input type="text" class="form-control bg-light" name="lokasi_nyeri">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Durasi</label>
                                                <input type="text" class="form-control bg-light" name="durasi_nyeri">
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Jenis nyeri</label>
                                                <select class="form-select bg-light" name="jenis_nyeri">
                                                    <option value="" selected disabled>Pilih</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Frekuensi</label>
                                                <select class="form-select bg-light" name="frekuensi_nyeri">
                                                    <option value="" selected disabled>Pilih</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Menjalar?</label>
                                                <select class="form-select bg-light" name="nyeri_menjalar">
                                                    <option value="" selected disabled>Pilih</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Kualitas</label>
                                                <select class="form-select bg-light" name="kualitas_nyeri">
                                                    <option value="" selected disabled>Pilih</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Faktor pemberat</label>
                                                <select class="form-select bg-light" name="faktor_pemberat">
                                                    <option value="" selected disabled>Pilih</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Faktor peringan</label>
                                                <select class="form-select bg-light" name="faktor_peringan">
                                                    <option value="" selected disabled>Pilih</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <label class="form-label">Efek Nyeri</label>
                                                <select class="form-select bg-light" name="efek_nyeri">
                                                    <option value="" selected disabled>Pilih</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator" id="riwayat-kesehatan">
                                    <h5 class="section-title">5. Riwayat Kesehatan</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Penyakit Yang Pernah Diderita</label>
                                        <input type="text" class="form-control bg-light" name="penyakit_diderita">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Riwayat Kecelakaan</label>
                                        <select class="form-select bg-light" name="riwayat_kecelakaan">
                                            <option value="" selected disabled>Pilih</option>
                                            <option value="Ya">Ya</option>
                                            <option value="Tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Jika Ya, Apa Jenis Kecelakaanya</label>
                                        <select class="form-select bg-light" name="jenis_kecelakaan">
                                            <option value="" selected disabled>Pilih</option>
                                            <!-- Add accident type options -->
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Riwayat Rawat Inap</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <select class="form-select bg-light flex-grow-1" name="riwayat_rawat_inap">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="Ya">Ya</option>
                                                <option value="Tidak">Tidak</option>
                                            </select>
                                            <input type="date" class="form-control bg-light" name="tanggal_rawat_inap"
                                                style="width: 200px;">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Riwayat Operasi</label>
                                        <select class="form-select bg-light" name="riwayat_operasi">
                                            <option value="" selected disabled>pilih</option>
                                            <option value="Ya">Ya</option>
                                            <option value="Tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Jenis/Nama Operasi</label>
                                        <input type="text" class="form-control bg-light" name="jenis_operasi">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Konsumsi Obat-Obatan (Jika Ada)</label>
                                        <input type="text" class="form-control bg-light" name="konsumsi_obat">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tumbuh Kembang Dibanding
                                            Saudara-Saudaranya</label>
                                        <select class="form-select bg-light" name="tumbuh_kembang">
                                            <option value="" selected disabled>pilih</option>
                                            <!-- Add growth comparison options -->
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Riwayat Kesehatan Keluarga</label>
                                        <textarea class="form-control bg-light" name="riwayat_kesehatan_keluarga" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="section-separator" id="alergi">
                                    <h5 class="section-title">6. Alergi</h5>

                                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                        id="openAlergiModal">
                                        <i class="ti-plus"></i> Tambah
                                    </button>

                                    <div class="table-responsive">
                                        <table class="table" id="createAlergiTable">
                                            <thead>
                                                <tr>
                                                    <th>Alergen</th>
                                                    <th>Reaksi</th>
                                                    <th>Severe</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Table content will be dynamically populated -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-create-alergi')

                                <div class="section-separator" id="risiko-jatuh">
                                    <h5 class="section-title">7. Risiko jatuh</h5>
                                    <p class="text-muted">Pilih jenis Skala Risiko Jatuh sesuai kondisi pasien</p>

                                    <div class="form-group mb-4">
                                        <select class="form-select" id="skalaRisikoJatuh" name="jenis_skala">
                                            <option value="" selected disabled>Pilih jenis skala</option>
                                            <option value="umum">Skala Umum</option>
                                            <option value="humdty">Skala Humdty Dumpty/ Pediatrik</option>
                                            <option value="morse">Morse Fall Scale</option>
                                            <option value="ontario">Ontario Modified Stratify</option>
                                        </select>
                                    </div>

                                    <!-- Form Skala Umum -->
                                    <div id="formUmum" class="risk-form" style="display: none;">
                                        <h6 class="mb-4">Penilaian Risiko Jatuh Skala Umum</h6>

                                        <div class="mb-4">
                                            <label class="form-label">Apakah pasien berusia < dari 2 tahun</label>
                                                    <select class="form-select bg-light" name="usia_dibawah_2">
                                                        <option value="" selected disabled>pilih</option>
                                                        <option value="ya">Ya</option>
                                                        <option value="tidak">Tidak</option>
                                                    </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Apakah pasien dalam kondisi sebagai geriatri,
                                                dizzines, vertigo, gangguan keseimbangan, gangguan penglihatan, penggunaan
                                                obat sedasi, status kesadaran dan atau kejiwaan, konsumsi alkohol?</label>
                                            <select class="form-select bg-light" name="kondisi_khusus">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Apakah pasien didiagnosis sebagai pasien dengan
                                                penyakit parkinson?</label>
                                            <select class="form-select bg-light" name="diagnosis_parkinson">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Apakah pasien sedang mendapatkan obat sedasi, riwayat
                                                tirah baring lama, perubahan posisi yang akan meningkatkan risiko
                                                jatuh?</label>
                                            <select class="form-select bg-light" name="obat_sedasi">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Apakah pasien saat ini sedang berada pada salah satu
                                                lokasi ini: rehab medik, ruangan dengan penerangan kurang dan
                                                bertangga?</label>
                                            <select class="form-select bg-light" name="lokasi_berisiko">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mt-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="fw-bold">Kesimpulan :</span>
                                                <div class="alert alert-success mb-0 flex-grow-1" id="kesimpulanUmum">
                                                    Tidak berisiko jatuh/Berisiko jatuh
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Humdty Dumpty -->
                                    <div id="formHumdty" class="risk-form" style="display: none;">
                                        <!-- Add Humdty Dumpty form fields -->
                                    </div>

                                    <!-- Form Morse -->
                                    <div id="formMorse" class="risk-form" style="display: none;">
                                        <!-- Add Morse form fields -->
                                    </div>

                                    <!-- Form Ontario -->
                                    <div id="formOntario" class="risk-form" style="display: none;">
                                        <!-- Add Ontario form fields -->
                                    </div>
                                </div>

                                <div class="section-separator" id="decubitus">
                                    <h5 class="section-title">8. Risiko dekubitus</h5>
                                    <p class="text-muted">Pilih jenis Skala Risiko Dekubitus sesuai kondisi pasien</p>

                                    <div class="form-group mb-4">
                                        <select class="form-select" id="skalaRisikoDekubitus"
                                            name="jenis_skala_dekubitus">
                                            <option value="" selected disabled>Pilih skala Decubitus</option>
                                            <option value="norton">Skala Norton</option>
                                            <option value="braden">Skala Braden</option>
                                            <option value="waterlow">Skala Waterlow</option>
                                        </select>
                                    </div>

                                    <!-- Form Skala Norton -->
                                    <div id="formNorton" class="decubitus-form" style="display: none;">
                                        <h6 class="mb-4">Penilaian Risiko DECUBITUS Skala Norton</h6>

                                        <div class="mb-4">
                                            <label class="form-label">Kondisi Fisik</label>
                                            <select class="form-select bg-light" name="kondisi_fisik">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="4">Baik</option>
                                                <option value="3">Sedang</option>
                                                <option value="2">Buruk</option>
                                                <option value="1">Sangat Buruk</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Kondisi mental</label>
                                            <select class="form-select bg-light" name="kondisi_mental">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="4">Sadar</option>
                                                <option value="3">Apatis</option>
                                                <option value="2">Bingung</option>
                                                <option value="1">Stupor</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Aktivitas</label>
                                            <select class="form-select bg-light" name="aktivitas">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="4">Aktif</option>
                                                <option value="3">Jalan dengan bantuan</option>
                                                <option value="2">Terbatas di kursi</option>
                                                <option value="1">Terbatas di tempat tidur</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Mobilitas</label>
                                            <select class="form-select bg-light" name="mobilitas">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="4">Bebas bergerak</option>
                                                <option value="3">Agak terbatas</option>
                                                <option value="2">Sangat terbatas</option>
                                                <option value="1">Tidak dapat bergerak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Inkontinensia</label>
                                            <select class="form-select bg-light" name="inkontinensia">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="4">Tidak ada</option>
                                                <option value="3">Kadang-kadang</option>
                                                <option value="2">Biasanya urin</option>
                                                <option value="1">Urin dan feses</option>
                                            </select>
                                        </div>

                                        <div class="mt-4">
                                            <div class="d-flex gap-2">
                                                <span class="fw-bold">Kesimpulan :</span>
                                                <div id="kesimpulanNorton" class="alert alert-success mb-0 flex-grow-1">
                                                    Risiko Rendah
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Skala Braden -->
                                    <div id="formBraden" class="decubitus-form" style="display: none;">
                                        <!-- Add Braden scale form fields -->
                                    </div>

                                    <!-- Form Skala Waterlow -->
                                    <div id="formWaterlow" class="decubitus-form" style="display: none;">
                                        <!-- Add Waterlow scale form fields -->
                                    </div>
                                </div>

                                <div class="section-separator" id="statusPsikologis">
                                    <h5 class="section-title">9. Status Psikologis</h5>

                                    <div class="mb-4">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <label>Kondisi Psikologis</label>
                                            <div class="dropdown-wrapper">
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    id="btnKondisiPsikologis">
                                                    <i class="ti-plus"></i>
                                                </button>
                                                <div class="dropdown-menu" id="dropdownKondisiPsikologis"
                                                    style="display: none; position: absolute; z-index: 1000;">
                                                    <div class="p-2">
                                                        <div class="fw-bold mb-2">STATUS PSIKOLOGIS PASIEN</div>
                                                        <div class="kondisi-options">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Tidak ada kelainan" id="kondisi1">
                                                                <label class="form-check-label" for="kondisi1">Tidak ada
                                                                    kelainan</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Cemas" id="kondisi2">
                                                                <label class="form-check-label"
                                                                    for="kondisi2">Cemas</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Takut" id="kondisi3">
                                                                <label class="form-check-label"
                                                                    for="kondisi3">Takut</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Marah" id="kondisi4">
                                                                <label class="form-check-label"
                                                                    for="kondisi4">Marah</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Sedih" id="kondisi5">
                                                                <label class="form-check-label"
                                                                    for="kondisi5">Sedih</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Tenang" id="kondisi6">
                                                                <label class="form-check-label"
                                                                    for="kondisi6">Tenang</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Tidak semangat" id="kondisi7">
                                                                <label class="form-check-label" for="kondisi7">Tidak
                                                                    semangat</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Tertekan" id="kondisi8">
                                                                <label class="form-check-label"
                                                                    for="kondisi8">Tertekan</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Depresi" id="kondisi9">
                                                                <label class="form-check-label"
                                                                    for="kondisi9">Depresi</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Sulit tidur" id="kondisi10">
                                                                <label class="form-check-label" for="kondisi10">Sulit
                                                                    tidur</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="selectedKondisiPsikologis" class="d-flex gap-2 flex-wrap">
                                                <!-- Selected items will be displayed here as badges -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Potensi menyakiti diri sendiri/orang lain</label>
                                        <select class="form-select" name="potensi_menyakiti">
                                            <option value="" selected disabled>pilih</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Lainnya</label>
                                        <input type="text" class="form-control" name="psikologis_lainnya">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.modal-tindakankeperawatan')
