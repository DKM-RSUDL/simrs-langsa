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
                                    <h4 class="header-asesmen">Asesmen Medis Geriatri</h4>
                                    <p>
                                        Isikan Asesmen medis dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- FORM ASESMEN MEDIS GERIATRI --}}
                        <form method="POST"
                            action="{{ route('rawat-inap.asesmen.medis.geriatri.index', [
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
                                                <input type="date" class="form-control" name="tanggal_masuk" id="tanggal_masuk" value="{{ date('Y-m-d') }}">
                                                <input type="time" class="form-control" name="jam_masuk" id="jam_masuk" value="{{ date('H:i') }}">
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
                                                    <input type="number" class="form-control" name="sistole"
                                                        placeholder="120" min="70" max="300">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Diastole</label>
                                                    <input type="number" class="form-control"
                                                        name="diastole" placeholder="80" min="40"
                                                        max="150">
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

                                        {{-- TAMBAHAN VITAL SIGN: BB, TB, IMT --}}
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Berat Badan (Kg)</label>
                                            <input type="number" class="form-control" name="berat_badan" id="berat_badan" 
                                                placeholder="70" step="0.1" min="10" max="300">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Tinggi Badan (Cm)</label>
                                            <input type="number" class="form-control" name="tinggi_badan" id="tinggi_badan" 
                                                placeholder="170" step="0.1" min="50" max="250">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">IMT (Kg/m²)</label>
                                            <input type="number" class="form-control" name="imt" id="imt" 
                                                placeholder="Otomatis terhitung" step="0.1" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Kategori IMT</label>
                                            <div class="d-flex flex-column gap-2" style="width: 100%;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="kategori_imt[]" value="Underweight" id="underweight">
                                                    <label class="form-check-label" for="underweight">
                                                        Underweight (< 18,0)
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="kategori_imt[]" value="Normoweight" id="normoweight">
                                                    <label class="form-check-label" for="normoweight">
                                                        Normoweight (18,0 - 22,9)
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="kategori_imt[]" value="Overweight" id="overweight">
                                                    <label class="form-check-label" for="overweight">
                                                        Overweight (23,0 - 24,9)
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="kategori_imt[]" value="Obese" id="obese">
                                                    <label class="form-check-label" for="obese">
                                                        Obese (25,0 - 30,0)
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="kategori_imt[]" value="Morbid Obese" id="morbid_obese">
                                                    <label class="form-check-label" for="morbid_obese">
                                                        Morbid Obese (> 30)
                                                    </label>
                                                </div>
                                            </div>
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

                                    </div>

                                    {{-- DATA PSIKOLOGI DAN SOSIAL EKONOMI --}}
                                    <div class="section-separator" id="psikologi-sosial">
                                        <h5 class="section-title">4. Data Psikologi dan Sosial Ekonomi</h5>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Kondisi Psikologi</label>
                                            <select class="form-select" name="kondisi_psikologi">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Tenang">Tenang</option>
                                                <option value="Cemas">Cemas</option>
                                                <option value="Agitasi">Agitasi</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Kondisi Sosial Ekonomi</label>
                                            <select class="form-select" name="kondisi_sosial_ekonomi">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Kurang">Kurang</option>
                                                <option value="Cukup">Cukup</option>
                                                <option value="Baik">Baik</option>
                                            </select>
                                        </div>

                                    </div>

                                    {{-- ASESMEN GERIATRI KHUSUS --}}
                                    <div class="section-separator" id="asesmen-geriatri">
                                        <h5 class="section-title">5. Asesmen Geriatri</h5>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">ADL (Activities of Daily Living)</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="adl[]" value="Mandiri" id="adl_mandiri">
                                                    <label class="form-check-label" for="adl_mandiri">
                                                        Mandiri
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="adl[]" value="Ketergantungan" id="adl_ketergantungan">
                                                    <label class="form-check-label" for="adl_ketergantungan">
                                                        Ketergantungan
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Kognitif</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="kognitif[]" value="Normal" id="kognitif_normal">
                                                    <label class="form-check-label" for="kognitif_normal">
                                                        Normal
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="kognitif[]" value="Gangguan Kognitif" id="kognitif_gangguan">
                                                    <label class="form-check-label" for="kognitif_gangguan">
                                                        Gangguan Kognitif
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Depresi</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="depresi[]" value="Normal" id="depresi_normal">
                                                    <label class="form-check-label" for="depresi_normal">
                                                        Normal
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="depresi[]" value="Depresi" id="depresi_ada">
                                                    <label class="form-check-label" for="depresi_ada">
                                                        Depresi
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Inkontinensia</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="inkontinensia[]" value="Tidak Ada Inkontinensia" id="inkontinensia_tidak">
                                                    <label class="form-check-label" for="inkontinensia_tidak">
                                                        Tidak Ada Inkontinensia
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="inkontinensia[]" value="Inkontinensia" id="inkontinensia_ada">
                                                    <label class="form-check-label" for="inkontinensia_ada">
                                                        Inkontinensia
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Insomnia</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="insomnia[]" value="Normal" id="insomnia_normal">
                                                    <label class="form-check-label" for="insomnia_normal">
                                                        Normal
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="insomnia[]" value="Insomnia" id="insomnia_ada">
                                                    <label class="form-check-label" for="insomnia_ada">
                                                        Insomnia
                                                    </label>
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
                                                        <td colspan="5" class="text-center text-muted">Tidak ada data alergi</td>
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

                                    {{-- <div class="section-separator" id="diagnosis">
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
                                    </div> --}}

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
@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-geriatri.modal-create-alergi')
@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-geriatri.include')