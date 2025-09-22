@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum") }}"
                class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <h4 class="header-asesmen">Asesmen Medis Kulit dan Kelamin</h4>
                                    <p>
                                        Isikan Asesmen medis dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- FORM ASESMEN MEDIS KULIT DAN KELAMIN --}}
                        <form method="POST"
                            action="{{ route('rawat-inap.asesmen.medis.kulit-kelamin.index', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                            ]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="px-3">
                                <div>

                                    <div class="section-separator" id="data-masuk">
                                        <h5 class="section-title">1. Data masuk</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <input type="date" class="form-control" name="tanggal_masuk"
                                                    id="tanggal_masuk" value="{{ date('Y-m-d') }}">
                                                <input type="time" class="form-control" name="jam_masuk" id="jam_masuk"
                                                    value="{{ date('H:i') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kondisi Masuk</label>
                                            <select class="form-select" name="kondisi_masuk">
                                                <option selected disabled>Pilih</option>
                                                <option value="Mandiri">Mandiri</option>
                                                <option value="Jalan Kaki">Jalan Kaki</option>
                                                <option value="Kursi Roda">Kursi Roda</option>
                                                <option value="Brankar">Brankar</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Diagnosis Masuk</label>
                                            <input type="text" class="form-control" name="diagnosis_masuk">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="anamnesis">
                                        <h5 class="section-title">2. Anamnesis</h5>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Anamnesis</label>
                                            <input type="text" class="form-control" name="anamnesis"
                                                placeholder="Masukkan anamnesis" required>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Keluhan Utama/Alasan Masuk RS</label>
                                            <textarea class="form-control" name="keluhan_utama" rows="4"
                                                placeholder="Masukkan keluhan utama atau alasan masuk rumah sakit" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Sensorium</label>
                                            <select class="form-select" name="sensorium">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Compos Mentis">Compos Mentis</option>
                                                <option value="Apatis">Apatis</option>
                                                <option value="Somnolen">Somnolen</option>
                                                <option value="Sopor">Sopor</option>
                                                <option value="Coma">Coma</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Tekanan Darah (mmHg)</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Sistole</label>
                                                    <input type="number" class="form-control" name="tekanan_darah_sistole"
                                                        placeholder="120" min="70" max="300">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Diastole</label>
                                                    <input type="number" class="form-control" name="tekanan_darah_diastole"
                                                        placeholder="80" min="40" max="150">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Suhu (°C)</label>
                                            <input type="number" class="form-control" name="suhu" step="0.1"
                                                placeholder="36.5" min="30" max="45">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Respirasi (Per Menit)</label>
                                            <input type="number" class="form-control" name="respirasi" placeholder="20"
                                                min="10" max="50">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Nadi (Per Menit)</label>
                                            <input type="number" class="form-control" name="nadi" placeholder="80"
                                                min="40" max="200">
                                        </div>

                                    </div>

                                    <div class="section-separator" id="riwayat-kesehatan">
                                        <h5 class="section-title">3. Riwayat Kesehatan</h5>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Riwayat Penyakit Sekarang</label>
                                            <textarea class="form-control" name="riwayat_penyakit_sekarang" rows="4"
                                                placeholder="Masukkan riwayat penyakit sekarang"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Riwayat Penyakit Terdahulu</label>
                                            <input type="text" class="form-control" name="riwayat_penyakit_terdahulu"
                                                placeholder="Masukkan riwayat penyakit terdahulu">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Riwayat Kesehatan Keluarga</label>
                                            <div class="w-100">
                                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                                    data-bs-toggle="modal" data-bs-target="#riwayatKeluargaModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>
                                                <div id="selectedRiwayatList" class="d-flex flex-column gap-2">
                                                    <!-- Empty state message -->
                                                    <div id="emptyStateRiwayat"
                                                        class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                        <i class="ti-info-circle mb-2"></i>
                                                        <p class="mb-0">Belum ada riwayat kesehatan keluarga yang
                                                            ditambahkan.</p>
                                                    </div>
                                                </div>
                                                <!-- Hidden input to store the JSON data -->
                                                <input type="hidden" name="riwayat_kesehatan_keluarga"
                                                    id="riwayatKesehatanInput">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="section-separator" id="riwayatObat">
                                        <h5 class="section-title">4. Riwayat Penggunaan Obat</h5>

                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            id="openObatModal">
                                            <i class="ti-plus"></i> Tambah
                                        </button>
                                        <input type="hidden" name="riwayat_penggunaan_obat" id="riwayatObatData"
                                            value="[]">
                                        <div class="table-responsive">
                                            <table class="table" id="createRiwayatObatTable">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Obat</th>
                                                        <th>Dosis</th>
                                                        <th>Aturan Pakai</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Table content will be dynamically populated -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="skala-nyeri">
                                        <h5 class="section-title">5. Skala Nyeri</h5>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="min-width: 200px;">Skala Nyeri (1-10)</label>
                                                    <input type="number" class="form-control" name="skala_nyeri"
                                                        id="skala_nyeri" min="1" max="10"
                                                        placeholder="1-10">
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 200px;">Kategori Nyeri</label>
                                                    <input type="text" class="form-control" name="kategori_nyeri"
                                                        id="kategori_nyeri" readonly placeholder="Akan terisi otomatis">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="text-center">
                                                    <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}"
                                                        alt="Skala Nyeri Visual" class="img-fluid mb-3"
                                                        style="max-height: 200px;">
                                                    <img src="{{ asset('assets/img/asesmen/numerik.png') }}"
                                                        alt="Skala Nyeri Numerik" class="img-fluid"
                                                        style="max-height: 150px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="alergi">
                                        <h5 class="section-title">6. Alergi</h5>

                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            id="openAlergiModal" data-bs-toggle="modal" data-bs-target="#alergiModal">
                                            <i class="ti-plus"></i> Tambah Alergi
                                        </button>
                                        <input type="hidden" name="alergis" id="alergisInput" value="[]">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="createAlergiTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="20%">Jenis Alergi</th>
                                                        <th width="25%">Alergen</th>
                                                        <th width="25%">Reaksi</th>
                                                        <th width="20%">Tingkat Keparahan</th>
                                                        <th width="10%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="no-alergi-row">
                                                        <td colspan="5" class="text-center text-muted">Tidak ada data
                                                            alergi</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="pemeriksaan-fisik">
                                        <h5 class="section-title">7. Pemeriksaan Fisik</h5>
                                        <div class="row g-3">
                                            <div class="pemeriksaan-fisik">
                                                <h6>Pemeriksaan Fisik</h6>
                                                <p class="text-small">Centang normal jika fisik yang dinilai
                                                    normal,
                                                    pilih tanda tambah
                                                    untuk menambah keterangan fisik yang ditemukan tidak normal.
                                                    Jika
                                                    tidak dipilih salah satunya, maka pemeriksaan tidak
                                                    dilakukan.
                                                </p>
                                                <div class="row">
                                                    @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                        <div class="col-md-6">
                                                            <div class="d-flex flex-column gap-3">
                                                                @foreach ($chunk as $item)
                                                                    <div class="pemeriksaan-item">
                                                                        <div
                                                                            class="d-flex align-items-center border-bottom pb-2">
                                                                            <div class="flex-grow-1">
                                                                                {{ $item->nama }}
                                                                            </div>
                                                                            <div class="form-check me-3">
                                                                                <input type="checkbox"
                                                                                    class="form-check-input"
                                                                                    id="{{ $item->id }}-normal"
                                                                                    name="{{ $item->id }}-normal"
                                                                                    checked>
                                                                                <label class="form-check-label"
                                                                                    for="{{ $item->id }}-normal">Normal</label>
                                                                            </div>
                                                                            <button
                                                                                class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                                type="button"
                                                                                data-target="{{ $item->id }}-keterangan">
                                                                                <i class="bi bi-plus"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="keterangan mt-2"
                                                                            id="{{ $item->id }}-keterangan"
                                                                            style="display:none;">
                                                                            <input type="text" class="form-control"
                                                                                name="{{ $item->id }}_keterangan"
                                                                                placeholder="Tambah keterangan jika tidak normal...">
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="section-separator" id="site-marking">
                                        <h5 class="section-title">Site Marking - Penandaan Anatomi</h5>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="site-marking-container position-relative">
                                                    <img src="{{ asset('assets/images/sitemarking/kulit-kelamin.png') }}"
                                                        id="anatomyImage" class="img-fluid" style="max-width: 100%;">
                                                    <canvas id="markingCanvas" class="position-absolute top-0 start-0"
                                                        style="cursor: crosshair; z-index: 10;">
                                                    </canvas>
                                                </div>
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        <strong>Cara Pakai:</strong> Pilih warna, klik dan drag untuk
                                                        membuat panah di area yang ingin ditandai.
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="marking-controls">
                                                    <h6>Kontrol Penandaan</h6>

                                                    <!-- Pilihan Warna -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Pilih Warna:</label>
                                                        <div class="d-flex flex-wrap gap-2">
                                                            <button type="button" class="color-btn active"
                                                                data-color="#dc3545"
                                                                style="background: #dc3545;"></button>
                                                            <button type="button" class="color-btn" data-color="#198754"
                                                                style="background: #198754;"></button>
                                                            <button type="button" class="color-btn" data-color="#0d6efd"
                                                                style="background: #0d6efd;"></button>
                                                            <button type="button" class="color-btn" data-color="#fd7e14"
                                                                style="background: #fd7e14;"></button>
                                                            <button type="button" class="color-btn" data-color="#6f42c1"
                                                                style="background: #6f42c1;"></button>
                                                            <button type="button" class="color-btn" data-color="#000000"
                                                                style="background: #000000;"></button>
                                                        </div>
                                                    </div>

                                                    <!-- Keterangan -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Keterangan (opsional):</label>
                                                        <input type="text" id="markingNote" class="form-control"
                                                            placeholder="Contoh: Ruam merah">
                                                    </div>

                                                    <!-- Tombol Kontrol -->
                                                    <div class="d-grid gap-2">
                                                        <button type="button" class="btn btn-outline-danger"
                                                            id="clearAllMarking">
                                                            <i class="ti-trash"></i> Hapus Semua Penandaan
                                                        </button>
                                                    </div>

                                                    <!-- Daftar Penandaan -->
                                                    <div class="marking-list mt-3">
                                                        <h6>Daftar Penandaan (<span id="markingCount">0</span>):</h6>
                                                        <div id="markingsList" class="list-group"
                                                            style="max-height: 250px; overflow-y: auto;">
                                                            <div class="text-muted text-center py-3" id="emptyState">
                                                                <i class="ti-info-alt"></i> Belum ada penandaan
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="site_marking_data" id="siteMarkingData"
                                            value="[]">
                                    </div>

                                    <div class="section-separator" id="discharge-planning">
                                        <h5 class="section-title">8. Discharge Planning</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Diagnosis medis</label>
                                            <input type="text" class="form-control" name="diagnosis_medis"
                                                placeholder="Diagnosis">
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Usia lanjut</label>
                                            <select class="form-select" name="usia_lanjut">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="0">Ya</option>
                                                <option value="1">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Hambatan mobilisasi</label>
                                            <select class="form-select" name="hambatan_mobilisasi">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="0">Ya</option>
                                                <option value="1">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Membutuhkan penggunaan media berkelanjutan</label>
                                            <select class="form-select" name="penggunaan_media_berkelanjutan">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Ketergantungan dengan orang lain dalam aktivitas
                                                harian</label>
                                            <select class="form-select" name="ketergantungan_aktivitas">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Pasien / Keluarga Memerlukan Keterampilan Khusus
                                                Setelah
                                                Pulang</label>
                                            <select class="form-select" name="keterampilan_khusus">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Pasien Memerlukan Alat Bantu Setelah Keluar Rumah
                                                Sakit</label>
                                            <select class="form-select" name="alat_bantu">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Pasien Memiliki Nyeri Kronis Dan / Kebiasaan Setelah
                                                Pulang</label>
                                            <select class="form-select" name="nyeri_kronis">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label">Perkiraan lama hari dirawat</label>
                                                <input type="text" class="form-control" name="perkiraan_hari"
                                                    placeholder="hari">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Rencana Tanggal Pulang</label>
                                                <input type="date" class="form-control" name="tanggal_pulang">
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <label class="form-label">KESIMPULAN</label>
                                            <div class="d-flex flex-column gap-2">
                                                <div class="alert alert-info">
                                                    Pilih semua Planning
                                                </div>
                                                <div class="alert alert-warning">
                                                    Mebutuhkan rencana pulang khusus
                                                </div>
                                                <div class="alert alert-success">
                                                    Tidak mebutuhkan rencana pulang khusus
                                                </div>
                                            </div>
                                            <input type="hidden" id="kesimpulan" name="kesimpulan_planing"
                                                value="Tidak mebutuhkan rencana pulang khusus">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="diagnosis">
                                        <h5 class="fw-semibold mb-4">9. Diagnosis</h5>

                                        <!-- Diagnosis Banding -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis banding, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan diagnosis banding yang tidak ditemukan.</small>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="diagnosis-banding-input"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Diagnosis Banding">
                                                <span class="input-group-text bg-white" id="add-diagnosis-banding">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>

                                            <div id="diagnosis-banding-list" class="diagnosis-list bg-light p-3 rounded">
                                                <!-- Diagnosis items will be added here dynamically -->
                                            </div>

                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="diagnosis_banding" name="diagnosis_banding"
                                                value="[]">
                                        </div>

                                        <!-- Diagnosis Kerja -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan diagnosis kerja yang tidak ditemukan.</small>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="diagnosis-kerja-input"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Diagnosis Kerja">
                                                <span class="input-group-text bg-white" id="add-diagnosis-kerja">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>

                                            <div id="diagnosis-kerja-list" class="diagnosis-list bg-light p-3 rounded">
                                                <!-- Diagnosis items will be added here dynamically -->
                                            </div>

                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja"
                                                value="[]">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="implemetasi" style="margin-bottom: 2rem;">
                                        <h5 class="fw-semibold mb-4">10. Implementasi</h5>

                                        <!-- Rencana Penatalaksanaan dan Pengobatan -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold">Rencana Penatalaksanaan dan
                                                Pengobatan</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                rencana, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                                rencana Penatalaksanaan dan Pengobatan kerja yang tidak ditemukan.</small>
                                        </div>

                                        <!-- Observasi Section -->
                                        <div class="mb-4">
                                            <label class="fw-semibold mb-2">Observasi</label>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="observasi-input"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Observasi">
                                                <span class="input-group-text bg-white" id="add-observasi">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>
                                            <div id="observasi-list" class="list-group mb-2 bg-light">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="observasi" name="observasi" value="[]">
                                        </div>

                                        <!-- Terapeutik Section -->
                                        <div class="mb-4">
                                            <label class="fw-semibold mb-2">Terapeutik</label>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="terapeutik-input"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Terapeutik">
                                                <span class="input-group-text bg-white" id="add-terapeutik">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>
                                            <div id="terapeutik-list" class="list-group mb-2">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="terapeutik" name="terapeutik" value="[]">
                                        </div>

                                        <!-- Edukasi Section -->
                                        <div class="mb-4">
                                            <label class="fw-semibold mb-2">Edukasi</label>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="edukasi-input"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Edukasi">
                                                <span class="input-group-text bg-white" id="add-edukasi">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>
                                            <div id="edukasi-list" class="list-group mb-2">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="edukasi" name="edukasi" value="[]">
                                        </div>

                                        <!-- Kolaborasi Section -->
                                        <div class="mb-4">
                                            <label class="fw-semibold mb-2">Kolaborasi</label>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="kolaborasi-input"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Kolaborasi">
                                                <span class="input-group-text bg-white" id="add-kolaborasi">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>
                                            <div id="kolaborasi-list" class="list-group mb-2">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="kolaborasi" name="kolaborasi" value="[]">
                                        </div>

                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold">Prognosis</label>

                                            <select class="form-select" name="prognosis">
                                                <option value="">--Pilih Prognosis--</option>
                                                @forelse ($satsetPrognosis as $item)
                                                    <option value="{{ $item->prognosis_id }}">
                                                        {{ $item->value ?? 'Field tidak ditemukan' }}
                                                    </option>
                                                @empty
                                                    <option value="" disabled>Tidak ada data</option>
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label style="min-width: 200px;">Rencana Penatalaksanaan <br> Dan
                                                Pengobatan</label>
                                            <textarea class="form-control" name="rencana_pengobatan" rows="4"
                                                placeholder="Rencana Penatalaksanaan Dan Pengobatan"></textarea>
                                        </div>


                                    </div>


                                    <div class="text-end mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti-check"></i> Simpan
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-kulitkelamin.modal-create-alergi')
@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-kulitkelamin.modal-riwayatkeluarga')
@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-kulitkelamin.modal-create-obat')
@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-kulitkelamin.include')
