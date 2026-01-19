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
                    'title' => 'Edit Asesmen Medis Kulit dan Kelamin',
                    'description' => 'Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan',
                ])

                {{-- FORM ASESMEN MEDIS KULIT DAN KELAMIN --}}
                <form method="POST"
                    action="{{ route('rawat-inap.asesmen.medis.kulit-kelamin.update', [
                        'kd_unit' => $kd_unit,
                        'kd_pasien' => $kd_pasien,
                        'tgl_masuk' => $tgl_masuk,
                        'urut_masuk' => $urut_masuk,
                        'id' => $id,
                    ]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="px-3">
                        <div>

                            <div class="section-separator mt-0" id="data-masuk">
                                <h5 class="section-title">1. Data masuk</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tanggal Dan Jam Pengisian</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        @php
                                            $waktuMasuk = Carbon\Carbon::parse($asesmen->waktu_asesmen);
                                        @endphp
                                        <input type="date" class="form-control" name="tanggal_masuk"
                                            id="tanggal_masuk" value="{{ $waktuMasuk->format('Y-m-d') }}">
                                        <input type="time" class="form-control" name="jam_masuk" id="jam_masuk"
                                            value="{{ $waktuMasuk->format('H:i') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Kondisi Masuk</label>
                                    <select class="form-select" name="kondisi_masuk">
                                        <option selected disabled>Pilih</option>
                                        <option value="Mandiri"
                                            {{ $asesmenKulitKelamin->kondisi_masuk == 'Mandiri' ? 'selected' : '' }}>
                                            Mandiri</option>
                                        <option value="Jalan Kaki"
                                            {{ $asesmenKulitKelamin->kondisi_masuk == 'Jalan Kaki' ? 'selected' : '' }}>
                                            Jalan Kaki</option>
                                        <option value="Kursi Roda"
                                            {{ $asesmenKulitKelamin->kondisi_masuk == 'Kursi Roda' ? 'selected' : '' }}>
                                            Kursi Roda</option>
                                        <option value="Brankar"
                                            {{ $asesmenKulitKelamin->kondisi_masuk == 'Brankar' ? 'selected' : '' }}>
                                            Brankar</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Diagnosis Masuk</label>
                                    <input type="text" class="form-control" name="diagnosis_masuk"
                                        value="{{ $asesmenKulitKelamin->diagnosis_masuk }}">
                                </div>
                            </div>

                            <div class="section-separator" id="anamnesis">
                                <h5 class="section-title">2. Anamnesis</h5>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Anamnesis</label>
                                    <input type="text" class="form-control" name="anamnesis"
                                        placeholder="Masukkan anamnesis" value="{{ $asesmen->anamnesis }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Keluhan Utama/Alasan Masuk RS</label>
                                    <textarea class="form-control" name="keluhan_utama" rows="4"
                                        placeholder="Masukkan keluhan utama atau alasan masuk rumah sakit">{{ $asesmenKulitKelamin->keluhan_utama }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Sensorium</label>
                                    <select class="form-select" name="sensorium">
                                        <option value=""
                                            {{ !$asesmenKulitKelamin->sensorium ? 'selected' : '' }} disabled>
                                            --Pilih--</option>
                                        <option value="Compos Mentis"
                                            {{ $asesmenKulitKelamin->sensorium == 'Compos Mentis' ? 'selected' : '' }}>
                                            Compos Mentis</option>
                                        <option value="Apatis"
                                            {{ $asesmenKulitKelamin->sensorium == 'Apatis' ? 'selected' : '' }}>
                                            Apatis</option>
                                        <option value="Somnolen"
                                            {{ $asesmenKulitKelamin->sensorium == 'Somnolen' ? 'selected' : '' }}>
                                            Somnolen</option>
                                        <option value="Sopor"
                                            {{ $asesmenKulitKelamin->sensorium == 'Sopor' ? 'selected' : '' }}>
                                            Sopor</option>
                                        <option value="Coma"
                                            {{ $asesmenKulitKelamin->sensorium == 'Coma' ? 'selected' : '' }}>Coma
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Tekanan Darah (mmHg)</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <div class="flex-grow-1">
                                            <label class="form-label">Sistole</label>
                                            <input type="number" class="form-control" name="tekanan_darah_sistole"
                                                placeholder="120"
                                                value="{{ $asesmenKulitKelamin->tekanan_darah_sistole }}">
                                        </div>
                                        <div class="flex-grow-1">
                                            <label class="form-label">Diastole</label>
                                            <input type="number" class="form-control" name="tekanan_darah_diastole"
                                                placeholder="80"
                                                value="{{ $asesmenKulitKelamin->tekanan_darah_diastole }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Suhu (°C)</label>
                                    <input type="text" class="form-control" name="suhu"
                                        placeholder="36.5"
                                        value="{{ $asesmenKulitKelamin->suhu }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Respirasi (Per Menit)</label>
                                    <input type="number" class="form-control" name="respirasi" placeholder="20"
                                        value="{{ $asesmenKulitKelamin->respirasi }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Nadi (Per Menit)</label>
                                    <input type="number" class="form-control" name="nadi" placeholder="80"
                                        value="{{ $asesmenKulitKelamin->nadi }}">
                                </div>

                            </div>

                            <div class="section-separator" id="riwayat-kesehatan">
                                <h5 class="section-title">3. Riwayat Kesehatan</h5>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Riwayat Penyakit Sekarang</label>
                                    <textarea class="form-control" name="riwayat_penyakit_sekarang" rows="4"
                                        placeholder="Masukkan riwayat penyakit sekarang">{{ $asesmenKulitKelamin->riwayat_penyakit_sekarang }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Riwayat Penyakit Terdahulu</label>
                                    <input type="text" class="form-control" name="riwayat_penyakit_terdahulu"
                                        placeholder="Masukkan riwayat penyakit terdahulu"
                                        value="{{ $asesmenKulitKelamin->riwayat_penyakit_terdahulu }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 220px;">Riwayat Kesehatan Keluarga</label>
                                    <div class="w-100">
                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            data-bs-toggle="modal" data-bs-target="#riwayatKeluargaModal">
                                            <i class="ti-plus"></i> Tambah
                                        </button>
                                        <div id="selectedRiwayatList" class="d-flex flex-column gap-2">
                                            <!-- Data akan dimuat dari JavaScript -->
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
                                                placeholder="1-10" value="{{ $asesmen->skala_nyeri }}">
                                        </div>

                                        @php
                                            $nilai = $asesmen->skala_nyeri ?? 0;
                                            $kategori = match (true) {
                                                $nilai >= 1 && $nilai <= 3 => 'Nyeri Ringan',
                                                $nilai >= 4 && $nilai <= 6 => 'Nyeri Sedang',
                                                $nilai >= 7 && $nilai <= 9 => 'Nyeri Berat',
                                                $nilai == 10 => 'Nyeri Tak Tertahankan',
                                                default => ''
                                            };
                                        @endphp 
                                       
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kategori Nyeri</label>
                                            <input type="text" class="form-control" name="kategori_nyeri"
                                                id="kategori_nyeri" readonly placeholder="Akan terisi otomatis"
                                                value="{{ $kategori }}">
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
                                                            @php
                                                                $pemeriksaanData = $pemeriksaanFisik->get(
                                                                    $item->id,
                                                                );
                                                                $isNormal = $pemeriksaanData
                                                                    ? $pemeriksaanData->is_normal
                                                                    : false;
                                                                $keterangan = $pemeriksaanData
                                                                    ? $pemeriksaanData->keterangan
                                                                    : '';
                                                            @endphp
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
                                                                            {{ $isNormal ? 'checked' : '' }}>
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
                                                                    style="display:{{ !$isNormal && $keterangan ? 'block' : 'none' }};">
                                                                    <input type="text" class="form-control"
                                                                        name="{{ $item->id }}_keterangan"
                                                                        placeholder="Tambah keterangan jika tidak normal..."
                                                                        value="{{ $keterangan }}">
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
                                <h5 class="section-title">7.1. Site Marking - Penandaan Anatomi</h5>
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
                                    value="{{ $asesmenKulitKelamin->site_marking_data  }}">
                            </div>
                            {{-- @php
                                dd($asesmenKulitKelamin->site_marking_data);
                            @endphp
                             --}}

                            <div class="section-separator" id="diagnosis">
                                <h5 class="fw-semibold mb-4">8. Diagnosis</h5>

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
                                        value="{{ $asesmenKulitKelamin->diagnosis_banding ?? '[]' }}">
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
                                        value="{{ $asesmenKulitKelamin->diagnosis_kerja ?? '[]' }}">
                                </div>
                            </div>

                            <div class="section-separator" id="rencana_pengobatan">
                                <h5 class="fw-semibold mb-4">9. Rencana Penatalaksanaan dan Pengobatan</h5>
                                <textarea class="form-control" name="rencana_pengobatan" rows="4"
                                    placeholder="Rencana Penatalaksanaan Dan Pengobatan">{{ old('rencana_pengobatan', isset($asesmenKulitKelamin) ? $asesmenKulitKelamin->rencana_pengobatan : '') }}</textarea>
                            </div>

                            <div class="section-separator" id="prognosis">
                                <h5 class="fw-semibold mb-4">10. Prognosis</h5>
                                <select class="form-select" name="prognosis">
                                    <option value="">--Pilih Prognosis--</option>
                                    @forelse ($satsetPrognosis as $item)
                                        <option value="{{ $item->prognosis_id }}"
                                            {{ isset($asesmenKulitKelamin->prognosis) && $asesmenKulitKelamin->prognosis == $item->prognosis_id ? 'selected' : '' }}>
                                            {{ $item->value ?? 'Field tidak ditemukan' }}
                                        </option>
                                    @empty
                                        <option value="" disabled>Tidak ada data</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="section-separator" id="discharge-planning">
                                <h5 class="section-title">11. Discharge Planning</h5>

                                {{-- <div class="mb-4">
                                    <label class="form-label">Diagnosis medis</label>
                                    <input type="text" class="form-control" name="diagnosis_medis"
                                        placeholder="Diagnosis"
                                        value="{{ $rencanaPulang->diagnosis_medis ?? '' }}">
                                </div> --}}

                                <div class="mb-4">
                                    <label class="form-label">Usia lanjut</label>
                                    <select class="form-select" name="usia_lanjut" id="usia_lanjut">
                                        <option value=""
                                            {{ !isset($rencanaPulang->usia_lanjut) ? 'selected' : '' }} disabled>
                                            --Pilih--</option>
                                        <option value="0"
                                            {{ isset($rencanaPulang->usia_lanjut) && $rencanaPulang->usia_lanjut == '0' ? 'selected' : '' }}>
                                            Ya</option>
                                        <option value="1"
                                            {{ isset($rencanaPulang->usia_lanjut) && $rencanaPulang->usia_lanjut == '1' ? 'selected' : '' }}>
                                            Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Hambatan mobilisasi</label>
                                    <select class="form-select" name="hambatan_mobilisasi"
                                        id="hambatan_mobilisasi">
                                        <option value=""
                                            {{ !isset($rencanaPulang->hambatan_mobilisasi) ? 'selected' : '' }}
                                            disabled>--Pilih--</option>
                                        <option value="0"
                                            {{ isset($rencanaPulang->hambatan_mobilisasi) && $rencanaPulang->hambatan_mobilisasi == '0' ? 'selected' : '' }}>
                                            Ya</option>
                                        <option value="1"
                                            {{ isset($rencanaPulang->hambatan_mobilisasi) && $rencanaPulang->hambatan_mobilisasi == '1' ? 'selected' : '' }}>
                                            Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Membutuhkan penggunaan media berkelanjutan</label>
                                    <select class="form-select" name="penggunaan_media_berkelanjutan"
                                        id="penggunaan_media_berkelanjutan">
                                        <option value=""
                                            {{ !isset($rencanaPulang->membutuhkan_pelayanan_medis) ? 'selected' : '' }}
                                            disabled>--Pilih--</option>
                                        <option value="ya"
                                            {{ isset($rencanaPulang->membutuhkan_pelayanan_medis) && $rencanaPulang->membutuhkan_pelayanan_medis == 'ya' ? 'selected' : '' }}>
                                            Ya</option>
                                        <option value="tidak"
                                            {{ isset($rencanaPulang->membutuhkan_pelayanan_medis) && $rencanaPulang->membutuhkan_pelayanan_medis == 'tidak' ? 'selected' : '' }}>
                                            Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Ketergantungan dengan orang lain dalam aktivitas
                                        harian</label>
                                    <select class="form-select" name="ketergantungan_aktivitas"
                                        id="ketergantungan_aktivitas">
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="ya">Ya</option>
                                        <option value="tidak">Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Pasien / Keluarga Memerlukan Keterampilan Khusus
                                        Setelah Pulang</label>
                                    <select class="form-select" name="keterampilan_khusus"
                                        id="keterampilan_khusus">
                                        <option value=""
                                            {{ !isset($rencanaPulang->memerlukan_keterampilan_khusus) ? 'selected' : '' }}
                                            disabled>--Pilih--</option>
                                        <option value="ya"
                                            {{ isset($rencanaPulang->memerlukan_keterampilan_khusus) && $rencanaPulang->memerlukan_keterampilan_khusus == 'ya' ? 'selected' : '' }}>
                                            Ya</option>
                                        <option value="tidak"
                                            {{ isset($rencanaPulang->memerlukan_keterampilan_khusus) && $rencanaPulang->memerlukan_keterampilan_khusus == 'tidak' ? 'selected' : '' }}>
                                            Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Pasien Memerlukan Alat Bantu Setelah Keluar Rumah
                                        Sakit</label>
                                    <select class="form-select" name="alat_bantu" id="alat_bantu">
                                        <option value=""
                                            {{ !isset($rencanaPulang->memerlukan_alat_bantu) ? 'selected' : '' }}
                                            disabled>--Pilih--</option>
                                        <option value="ya"
                                            {{ isset($rencanaPulang->memerlukan_alat_bantu) && $rencanaPulang->memerlukan_alat_bantu == 'ya' ? 'selected' : '' }}>
                                            Ya</option>
                                        <option value="tidak"
                                            {{ isset($rencanaPulang->memerlukan_alat_bantu) && $rencanaPulang->memerlukan_alat_bantu == 'tidak' ? 'selected' : '' }}>
                                            Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Pasien Memiliki Nyeri Kronis Dan / Kebiasaan Setelah
                                        Pulang</label>
                                    <select class="form-select" name="nyeri_kronis" id="nyeri_kronis">
                                        <option value=""
                                            {{ !isset($rencanaPulang->memiliki_nyeri_kronis) ? 'selected' : '' }}
                                            disabled>--Pilih--</option>
                                        <option value="ya"
                                            {{ isset($rencanaPulang->memiliki_nyeri_kronis) && $rencanaPulang->memiliki_nyeri_kronis == 'ya' ? 'selected' : '' }}>
                                            Ya</option>
                                        <option value="tidak"
                                            {{ isset($rencanaPulang->memiliki_nyeri_kronis) && $rencanaPulang->memiliki_nyeri_kronis == 'tidak' ? 'selected' : '' }}>
                                            Tidak</option>
                                    </select>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Perkiraan lama hari dirawat</label>
                                        <input type="text" class="form-control" name="perkiraan_hari"
                                            placeholder="hari"
                                            value="{{ $rencanaPulang->perkiraan_lama_dirawat ?? '' }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Rencana Tanggal Pulang</label>
                                        <input type="date" class="form-control" name="tanggal_pulang"
                                            value="{{ $rencanaPulang->rencana_pulang ? \Carbon\Carbon::parse($rencanaPulang->rencana_pulang)->format('Y-m-d') : '' }}">
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="form-label">KESIMPULAN</label>
                                    <div class="d-flex flex-column gap-2" id="kesimpulan-alerts">
                                        <div class="alert alert-info" id="alert-info" style="display: none;">
                                            Pilih semua Planning
                                        </div>
                                        <div class="alert alert-warning" id="alert-warning"
                                            style="display: none;">
                                            Mebutuhkan rencana pulang khusus
                                        </div>
                                        <div class="alert alert-success" id="alert-success"
                                            style="display: none;">
                                            Tidak mebutuhkan rencana pulang khusus
                                        </div>
                                    </div>
                                    <input type="hidden" id="kesimpulan" name="kesimpulan_planing"
                                        value="{{ $rencanaPulang->kesimpulan ?? 'Pilih semua Planning' }}">
                                </div>
                            </div>

                            {{-- Bagian lain akan ditambahkan secara bertahap --}}
                            <div class="text-end">
                                <x-button-submit>Perbarui</x-button-submit>
                            </div>

                        </div>
                    </div>
                </form>
            </x-content-card>
        </div>
    </div>
@endsection

<!-- Modal for adding family health history -->
<div class="modal fade" id="riwayatKeluargaModal" tabindex="-1" aria-labelledby="riwayatKeluargaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="riwayatKeluargaModalLabel">Tambah Riwayat Kesehatan Keluarga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="riwayatInput" class="form-label">Riwayat Kesehatan</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="riwayatInput"
                            placeholder="Masukkan riwayat kesehatan">
                        <button class="btn btn-outline-secondary" type="button" id="tambahKeListRiwayat">
                            <i class="ti-plus"></i>
                        </button>
                    </div>
                </div>
                <!-- Temporary list in modal -->
                <div id="modalRiwayatList" class="d-flex flex-column gap-2">
                    <div id="modalEmptyStateRiwayat"
                        class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                        <p class="mb-0">Belum ada riwayat dalam list sementara</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanRiwayat"
                    data-bs-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Riwayat Obat -->
<div class="modal fade" id="obatModal" tabindex="-1" aria-labelledby="obatModalLabel" aria-hidden="true"
    style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="obatModalLabel">Tambah Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRiwayatObat">
                    <div class="mb-3">
                        <label class="form-label">Nama Obat</label>
                        <input type="text" class="form-control" id="namaObat" placeholder="Nama obat">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Aturan Pakai</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label small">Frekuensi/interval</label>
                                <select class="form-select" id="frekuensi">
                                    <option value="1 x 1 hari">1 x 1 hari</option>
                                    <option value="2 x 1 hari">2 x 1 hari</option>
                                    <option value="3 x 1 hari" selected>3 x 1 hari</option>
                                    <option value="4 x 1 hari">4 x 1 hari</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Keterangan</label>
                                <select class="form-select" id="keterangan">
                                    <option value="Sebelum Makan">Sebelum Makan</option>
                                    <option value="Sesudah Makan" selected>Sesudah Makan</option>
                                    <option value="Saat Makan">Saat Makan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Dosis sekali minum</label>
                            <select class="form-select" id="dosis">
                                <option value="1/4">1/4</option>
                                <option value="1/2" selected>1/2</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="satuan" value="Tablet">
                        </div>
                    </div>
                </form>

                <h6 class="fw-bold mt-4">Daftar Riwayat Obat</h6>
                <ul id="listObat"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnTambahObat">Tambah Obat</button>
                <button type="button" class="btn btn-success" id="btnSaveObat">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- TAMBAHKAN SETELAH MODAL OBAT --}}

<!-- Modal Alergi -->
<div class="modal fade" id="alergiModal" tabindex="-1" aria-labelledby="alergiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alergiModalLabel">Manajemen Data Alergi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Input Alergi -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Tambah Data Alergi</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="modal_jenis_alergi" class="form-label">Jenis Alergi</label>
                                <select class="form-select" id="modal_jenis_alergi">
                                    <option value="">-- Pilih Jenis Alergi --</option>
                                    <option value="Obat">Obat</option>
                                    <option value="Makanan">Makanan</option>
                                    <option value="Udara">Udara</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modal_alergen" class="form-label">Alergen</label>
                                <input type="text" class="form-control" id="modal_alergen"
                                    placeholder="Contoh: Paracetamol, Seafood, Debu">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modal_reaksi" class="form-label">Reaksi</label>
                                <input type="text" class="form-control" id="modal_reaksi"
                                    placeholder="Contoh: Gatal, Ruam, Sesak nafas">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modal_tingkat_keparahan" class="form-label">Tingkat Keparahan</label>
                                <select class="form-select" id="modal_tingkat_keparahan">
                                    <option value="">-- Pilih Tingkat Keparahan --</option>
                                    <option value="Ringan">Ringan</option>
                                    <option value="Sedang">Sedang</option>
                                    <option value="Berat">Berat</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-primary btn-sm" id="addToAlergiList">
                                <i class="bi bi-plus"></i> Tambah ke Daftar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Daftar Alergi -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">Daftar Alergi Pasien</h6>
                        <span class="badge bg-primary" id="alergiCount">0</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th width="20%">Jenis Alergi</th>
                                        <th width="25%">Alergen</th>
                                        <th width="25%">Reaksi</th>
                                        <th width="20%">Tingkat Keparahan</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="modalAlergiList">
                                    <!-- Data akan ditampilkan di sini -->
                                </tbody>
                            </table>
                        </div>
                        <div id="noAlergiMessage" class="text-center text-muted py-3" style="display: none;">
                            <i class="bi bi-info-circle"></i> Belum ada data alergi
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveAlergiData">
                    <i class="bi bi-check"></i> Simpan Data Alergi
                </button>
            </div>
        </div>
    </div>
</div>

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .section-separator {
            border-top: 2px solid #097dd6;
            margin: 2rem 0;
            padding-top: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
        }

        .form-group label {
            margin-right: 1rem;
            padding-top: 0.5rem;
        }

        /* TAMBAHKAN DI CSS SECTION */

        #discharge-planning {
            background-color: #fff;
            border-radius: 8px;
        }

        #discharge-planning .form-select {
            transition: all 0.3s ease;
        }

        #discharge-planning .form-select:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        #discharge-planning .form-select.is-invalid {
            border-color: #dc3545;
            background-color: #fff5f5;
        }

        #kesimpulan-alerts {
            transition: all 0.3s ease;
        }

        #kesimpulan-alerts .alert {
            margin-bottom: 0.5rem;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            font-weight: 500;
        }

        #kesimpulan-alerts .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }

        #kesimpulan-alerts .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeaa7;
            color: #856404;
        }

        #kesimpulan-alerts .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .row .col-md-6 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        /* TAMBAHKAN DI CSS SECTION */

        .diagnosis-section {
            margin-top: 1.5rem;
        }

        .diagnosis-list {
            min-height: 80px;
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }

        .diagnosis-item {
            transition: all 0.2s ease;
            border: 1px solid #e3e6f0 !important;
        }

        .diagnosis-item:hover {
            background-color: #f8f9fa !important;
            border-color: #097dd6 !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .suggestions-list {
            max-height: 200px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            background: white;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .suggestion-item {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #f1f1f1;
            transition: background-color 0.2s ease;
        }

        .suggestion-item:hover {
            background-color: #f8f9fa;
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .suggestion-item.text-primary:hover {
            background-color: #e3f2fd;
        }

        .input-group-text {
            background-color: white;
            border-color: #ced4da;
        }

        .input-group .form-control {
            border-color: #ced4da;
        }

        .input-group:focus-within .input-group-text {
            border-color: #097dd6;
        }

        .input-group:focus-within .form-control {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        #add-diagnosis-banding,
        #add-diagnosis-kerja {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        #add-diagnosis-banding:hover,
        #add-diagnosis-kerja:hover {
            background-color: #097dd6 !important;
            color: white !important;
        }

        #add-diagnosis-banding:hover .bi-plus-circle,
        #add-diagnosis-kerja:hover .bi-plus-circle {
            color: white !important;
        }

        .diagnosis-item .btn {
            transition: all 0.2s ease;
        }

        .diagnosis-item .btn:hover {
            background-color: #dc3545;
            color: white;
            transform: scale(1.1);
        }

        /* TAMBAHKAN DI CSS SECTION */

        #implementasi {
            background-color: #fff;
            border-radius: 8px;
        }

        #implementasi .list-group {
            min-height: 80px;
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }

        #implementasi .list-group-item {
            transition: all 0.2s ease;
            cursor: default;
        }

        #implementasi .list-group-item:hover {
            background-color: #f8f9fa !important;
            border-color: #097dd6 !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
        }

        #implementasi .input-group-text {
            background-color: white;
            border-color: #ced4da;
            transition: all 0.2s ease;
        }

        #implementasi .input-group .form-control {
            border-color: #ced4da;
        }

        #implementasi .input-group:focus-within .input-group-text {
            border-color: #097dd6;
        }

        #implementasi .input-group:focus-within .form-control {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        #add-observasi,
        #add-terapeutik,
        #add-edukasi,
        #add-kolaborasi,
        #add-rencana {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        #add-observasi:hover,
        #add-terapeutik:hover,
        #add-edukasi:hover,
        #add-kolaborasi:hover,
        #add-rencana:hover {
            background-color: #097dd6 !important;
            color: white !important;
        }

        #add-observasi:hover .bi-plus-circle,
        #add-terapeutik:hover .bi-plus-circle,
        #add-edukasi:hover .bi-plus-circle,
        #add-kolaborasi:hover .bi-plus-circle,
        #add-rencana:hover .bi-plus-circle {
            color: white !important;
        }

        #implementasi .btn-link {
            transition: all 0.2s ease;
        }

        #implementasi .btn-link:hover {
            background-color: #dc3545 !important;
            color: white !important;
            border-radius: 4px !important;
            transform: scale(1.1);
        }

        #implementasi .suggestions-list {
            max-height: 200px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            background: white;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #implementasi .suggestion-item {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #f1f1f1;
            transition: background-color 0.2s ease;
        }

        #implementasi .suggestion-item:hover {
            background-color: #f8f9fa;
        }

        #implementasi .suggestion-item:last-child {
            border-bottom: none;
        }

        #implementasi .suggestion-item.text-primary:hover {
            background-color: #e3f2fd;
        }

        .fw-semibold {
            font-weight: 600;
        }

        .text-secondary {
            color: #6c757d !important;
        }

        .text-primary {
            color: #097dd6 !important;
        }


        /* Site Marking Styles */
        .site-marking-container {
            border: 2px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            background: #f8f9fa;
            position: relative;
        }

        .color-btn {
            width: 35px;
            height: 35px;
            border: 2px solid #dee2e6;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .color-btn:hover {
            transform: scale(1.1);
            border-color: #6c757d;
        }

        .color-btn.active {
            border-color: #fff;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.3);
            transform: scale(1.1);
        }

        .marking-list-item {
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            margin-bottom: 8px;
            background: #fff;
            transition: background-color 0.2s;
        }

        .marking-list-item:hover {
            background: #f8f9fa;
        }

        #markingCanvas {
            pointer-events: auto;
        }

        #anatomyImage {
            display: block;
            max-width: 100%;
            height: auto;
        }
    </style>
@endpush

@push('js')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-kulitkelamin.include')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            //====================================================================================//
            // RIWAYAT KESEHATAN KELUARGA - EDIT MODE
            //====================================================================================//

            // Arrays to store the health history
            let riwayatList = [];
            let tempRiwayatList = [];

            // Load existing data from PHP
            try {
                const existingRiwayatKeluarga = @json(json_decode($asesmenKulitKelamin->riwayat_penyakit_keluarga ?? '[]', true));
                if (Array.isArray(existingRiwayatKeluarga)) {
                    riwayatList = existingRiwayatKeluarga;
                }
            } catch (e) {
                console.log('Data riwayat keluarga tidak valid atau kosong');
                riwayatList = [];
            }

            // Function to update the main UI and hidden input
            function updateRiwayatList() {
                const listContainer = document.getElementById('selectedRiwayatList');
                const hiddenInput = document.getElementById('riwayatKesehatanInput');

                // Clear the current list
                listContainer.innerHTML = '';

                if (riwayatList.length === 0) {
                    const emptyState = document.createElement('div');
                    emptyState.className =
                        'border border-dashed border-secondary rounded p-3 text-center text-muted';
                    emptyState.innerHTML =
                        '<i class="ti-info-circle mb-2"></i><p class="mb-0">Belum ada riwayat kesehatan keluarga yang ditambahkan.</p>';
                    listContainer.appendChild(emptyState);
                } else {
                    // Add each health history to the list
                    riwayatList.forEach((riwayat, index) => {
                        const item = document.createElement('div');
                        item.className =
                            'p-2 bg-light rounded d-flex justify-content-between align-items-center';
                        item.innerHTML = `
                            <span>${riwayat}</span>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeRiwayat(${index})">
                                <i class="ti-trash"></i>
                            </button>
                        `;
                        listContainer.appendChild(item);
                    });
                }

                // Update hidden input with JSON string
                hiddenInput.value = JSON.stringify(riwayatList);
            }

            // Function to update the modal's temporary list
            function updateModalRiwayatList() {
                const modalList = document.getElementById('modalRiwayatList');

                // Clear the current list
                modalList.innerHTML = '';

                if (tempRiwayatList.length === 0) {
                    const modalEmptyState = document.createElement('div');
                    modalEmptyState.className =
                        'border border-dashed border-secondary rounded p-3 text-center text-muted';
                    modalEmptyState.innerHTML = '<p class="mb-0">Belum ada riwayat dalam list sementara</p>';
                    modalList.appendChild(modalEmptyState);
                } else {
                    // Add each health history to the temporary list
                    tempRiwayatList.forEach((riwayat, index) => {
                        const item = document.createElement('div');
                        item.className =
                            'p-2 bg-light rounded d-flex justify-content-between align-items-center';
                        item.innerHTML = `
                            <span>${riwayat}</span>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeTempRiwayat(${index})">
                                <i class="ti-trash"></i>
                            </button>
                        `;
                        modalList.appendChild(item);
                    });
                }
            }

            // Function to add a new health history to temporary list
            function addToTempRiwayatList() {
                const input = document.getElementById('riwayatInput');
                const riwayat = input.value.trim();

                if (riwayat) {
                    tempRiwayatList.push(riwayat);
                    updateModalRiwayatList();
                    input.value = '';
                    input.focus();
                }
            }

            // Function to save temporary list to main list
            function saveRiwayat() {
                if (tempRiwayatList.length > 0) {
                    riwayatList = [...riwayatList, ...tempRiwayatList];
                    tempRiwayatList = []; // Clear temporary list
                    updateRiwayatList();
                    updateModalRiwayatList();
                }
            }

            // Global functions
            window.removeRiwayat = function(index) {
                riwayatList.splice(index, 1);
                updateRiwayatList();
            };

            window.removeTempRiwayat = function(index) {
                tempRiwayatList.splice(index, 1);
                updateModalRiwayatList();
            };

            // Add event listeners
            document.getElementById('tambahKeListRiwayat').addEventListener('click', addToTempRiwayatList);
            document.getElementById('simpanRiwayat').addEventListener('click', saveRiwayat);

            // Add event listener for enter key in input
            document.getElementById('riwayatInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addToTempRiwayatList();
                }
            });

            // Reset temporary list when modal is opened
            document.getElementById('riwayatKeluargaModal').addEventListener('show.bs.modal', function() {
                tempRiwayatList = [];
                updateModalRiwayatList();
                document.getElementById('riwayatInput').value = '';
            });

            //====================================================================================//
            // RIWAYAT PENGGUNAAN OBAT - EDIT MODE
            //====================================================================================//

            var obatModal = new bootstrap.Modal(document.getElementById('obatModal'));
            var obatTable = document.querySelector('#createRiwayatObatTable tbody');
            var listObat = document.getElementById('listObat');
            var riwayatObat = [];

            // Load existing data from PHP
            try {
                const existingRiwayatObat = @json(json_decode($asesmenKulitKelamin->riwayat_penggunaan_obat ?? '[]', true));
                if (Array.isArray(existingRiwayatObat)) {
                    riwayatObat = existingRiwayatObat;
                }
            } catch (e) {
                console.log('Data riwayat obat tidak valid atau kosong');
                riwayatObat = [];
            }

            function updateMainView() {
                if (riwayatObat.length === 0) {
                    obatTable.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center py-3">
                                <div class="text-muted">
                                    <i class="bi bi-exclamation-circle mb-2" style="font-size: 1.5rem;"></i>
                                    <p class="mb-0">Belum ada data riwayat obat</p>
                                </div>
                            </td>
                        </tr>
                    `;
                } else {
                    obatTable.innerHTML = riwayatObat.map((o, index) => `
                        <tr>
                            <td>${o.namaObat}</td>
                            <td>${o.dosis} ${o.satuan}</td>
                            <td>${o.frekuensi} (${o.keterangan})</td>
                            <td>
                                <button class="btn btn-sm btn-link delete-obat" data-index="${index}">
                                    <i class="ti-trash text-danger"></i>
                                </button>
                            </td>
                        </tr>
                    `).join('');
                }
                // Update hidden input
                document.getElementById('riwayatObatData').value = JSON.stringify(riwayatObat);
            }

            function updateModalView() {
                if (riwayatObat.length === 0) {
                    listObat.innerHTML = `
                        <div class="text-center text-muted p-3">
                            <i class="bi bi-exclamation-circle mb-2" style="font-size: 1.5rem;"></i>
                            <p class="mb-0">Belum ada data riwayat obat</p>
                        </div>
                    `;
                } else {
                    listObat.innerHTML = riwayatObat.map(o => `
                        <li class="mb-2">
                            <span class="fw-bold">${o.namaObat}</span> -
                            <span class="text-muted">${o.dosis} ${o.satuan}</span>
                            <span class="badge bg-warning">${o.frekuensi} (${o.keterangan})</span>
                        </li>
                    `).join('');
                }
            }

            document.getElementById('openObatModal').addEventListener('click', function() {
                updateModalView();
                obatModal.show();
            });

            document.getElementById('btnTambahObat').addEventListener('click', function() {
                var namaObat = document.getElementById('namaObat').value.trim();
                var frekuensi = document.getElementById('frekuensi').value;
                var keterangan = document.getElementById('keterangan').value;
                var dosis = document.getElementById('dosis').value;
                var satuan = document.getElementById('satuan').value.trim();

                if (namaObat !== '' && satuan !== '') {
                    riwayatObat.push({
                        namaObat: namaObat,
                        frekuensi: frekuensi,
                        keterangan: keterangan,
                        dosis: dosis,
                        satuan: satuan
                    });
                    updateModalView();

                    // Reset form kecuali satuan (default "Tablet")
                    document.getElementById('namaObat').value = '';
                    document.getElementById('frekuensi').value = '3 x 1 hari';
                    document.getElementById('keterangan').value = 'Sesudah Makan';
                    document.getElementById('dosis').value = '1/2';
                } else {
                    alert('Harap isi Nama Obat dan Satuan');
                }
            });

            document.getElementById('btnSaveObat').addEventListener('click', function() {
                updateMainView();
                obatModal.hide();
            });

            obatTable.addEventListener('click', function(e) {
                if (e.target.closest('.delete-obat')) {
                    var row = e.target.closest('tr');
                    var index = Array.from(row.parentElement.children).indexOf(row);
                    riwayatObat.splice(index, 1);
                    updateMainView();
                }
            });

            // Initial load
            updateRiwayatList();
            updateMainView();

            // TAMBAHKAN DI DALAM script tag yang sudah ada, setelah kode riwayat obat

            //====================================================================================//
            // SKALA NYERI - EDIT MODE
            //====================================================================================//

            // Function untuk update kategori nyeri otomatis
            document.getElementById('skala_nyeri').addEventListener('input', function() {
                const nilai = parseInt(this.value);
                const kategoriField = document.getElementById('kategori_nyeri');

                if (nilai >= 1 && nilai <= 3) {
                    kategoriField.value = 'Nyeri Ringan';
                } else if (nilai >= 4 && nilai <= 6) {
                    kategoriField.value = 'Nyeri Sedang';
                } else if (nilai >= 7 && nilai <= 9) {
                    kategoriField.value = 'Nyeri Berat';
                } else if (nilai === 10) {
                    kategoriField.value = 'Nyeri Tak Tertahankan';
                } else {
                    kategoriField.value = '';
                }
            });

            // Trigger event untuk set kategori nyeri pada load jika ada nilai
            const initialSkalaNyeri = document.getElementById('skala_nyeri').value;
            if (initialSkalaNyeri) {
                document.getElementById('skala_nyeri').dispatchEvent(new Event('input'));
            }

            //====================================================================================//
            // ALERGI - EDIT MODE
            //====================================================================================//

            // Array untuk menyimpan data alergi sementara
            let alergiDataArray = [];

            // Load existing alergi data from PHP
            try {
                const existingAlergiData = @json($alergiPasien ?? []);
                alergiDataArray = existingAlergiData.map(item => ({
                    jenis_alergi: item.jenis_alergi || '',
                    alergen: item.nama_alergi || '',
                    reaksi: item.reaksi || '',
                    tingkat_keparahan: item.tingkat_keparahan || '',
                    is_existing: true,
                    id: item.id || null
                }));
            } catch (e) {
                console.log('Data alergi tidak tersedia');
                alergiDataArray = [];
            }

            // Event listeners untuk alergi
            const openAlergiModal = document.getElementById('openAlergiModal');
            if (openAlergiModal) {
                openAlergiModal.addEventListener('click', function() {
                    updateModalAlergiList();
                });
            }

            const addToAlergiList = document.getElementById('addToAlergiList');
            if (addToAlergiList) {
                addToAlergiList.addEventListener('click', function() {
                    const jenisAlergi = document.getElementById('modal_jenis_alergi')?.value?.trim();
                    const alergen = document.getElementById('modal_alergen')?.value?.trim();
                    const reaksi = document.getElementById('modal_reaksi')?.value?.trim();
                    const tingkatKeparahan = document.getElementById('modal_tingkat_keparahan')?.value
                        ?.trim();

                    if (!jenisAlergi || !alergen || !reaksi || !tingkatKeparahan) {
                        alert('Harap isi semua field alergi');
                        return;
                    }

                    const isDuplicate = alergiDataArray.some(item =>
                        item.jenis_alergi === jenisAlergi &&
                        item.alergen.toLowerCase() === alergen.toLowerCase()
                    );

                    if (isDuplicate) {
                        alert('Data alergi sudah ada');
                        return;
                    }

                    alergiDataArray.push({
                        jenis_alergi: jenisAlergi,
                        alergen: alergen,
                        reaksi: reaksi,
                        tingkat_keparahan: tingkatKeparahan,
                        is_existing: false
                    });

                    updateModalAlergiList();
                    resetAlergiForm();
                });
            }

            const saveAlergiData = document.getElementById('saveAlergiData');
            if (saveAlergiData) {
                saveAlergiData.addEventListener('click', function() {
                    updateMainAlergiTable();
                    updateHiddenAlergiInput();

                    const alergiModal = document.getElementById('alergiModal');
                    if (alergiModal && typeof bootstrap !== 'undefined') {
                        const modalInstance = bootstrap.Modal.getInstance(alergiModal);
                        if (modalInstance) modalInstance.hide();
                    }
                });
            }

            // Functions untuk alergi
            function updateModalAlergiList() {
                const tbody = document.getElementById('modalAlergiList');
                const noDataMessage = document.getElementById('noAlergiMessage');
                const countBadge = document.getElementById('alergiCount');

                if (!tbody) return;

                tbody.innerHTML = '';

                if (alergiDataArray.length === 0) {
                    if (noDataMessage) noDataMessage.style.display = 'block';
                    const table = tbody.closest('table');
                    if (table) table.style.display = 'none';
                } else {
                    if (noDataMessage) noDataMessage.style.display = 'none';
                    const table = tbody.closest('table');
                    if (table) table.style.display = 'table';

                    alergiDataArray.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.jenis_alergi}</td>
                            <td>${item.alergen}</td>
                            <td>${item.reaksi}</td>
                            <td>
                                <span class="badge ${getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                    ${item.tingkat_keparahan}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeAlergiFromModal(${index})">
                                    <i class="bi bi-trash"></i>
                                </button>
                                ${item.is_existing ? '<small class="text-muted d-block">Dari DB</small>' : '<small class="text-success d-block">Baru</small>'}
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }

                if (countBadge) countBadge.textContent = alergiDataArray.length;
            }

            function updateMainAlergiTable() {
                const tbody = document.querySelector('#createAlergiTable tbody');
                const noAlergiRow = document.getElementById('no-alergi-row');

                if (!tbody || !noAlergiRow) return;

                const existingRows = tbody.querySelectorAll('tr:not(#no-alergi-row)');
                existingRows.forEach(row => row.remove());

                if (alergiDataArray.length === 0) {
                    noAlergiRow.style.display = 'table-row';
                } else {
                    noAlergiRow.style.display = 'none';

                    alergiDataArray.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.jenis_alergi}</td>
                            <td>${item.alergen}</td>
                            <td>${item.reaksi}</td>
                            <td>
                                <span class="badge ${getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                    ${item.tingkat_keparahan}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeAlergiFromMain(${index})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }
            }

            function updateHiddenAlergiInput() {
                const hiddenInput = document.getElementById('alergisInput');
                if (hiddenInput) {
                    hiddenInput.value = JSON.stringify(alergiDataArray);
                }
            }

            function resetAlergiForm() {
                const fields = ['modal_jenis_alergi', 'modal_alergen', 'modal_reaksi', 'modal_tingkat_keparahan'];
                fields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) field.value = '';
                });
            }

            function getKeparahanBadgeClass(keparahan) {
                switch (keparahan.toLowerCase()) {
                    case 'ringan':
                        return 'bg-success';
                    case 'sedang':
                        return 'bg-warning';
                    case 'berat':
                        return 'bg-danger';
                    default:
                        return 'bg-secondary';
                }
            }

            // Global functions untuk onclick events
            window.removeAlergiFromModal = function(index) {
                alergiDataArray.splice(index, 1);
                updateModalAlergiList();
            };

            window.removeAlergiFromMain = function(index) {
                alergiDataArray.splice(index, 1);
                updateMainAlergiTable();
                updateHiddenAlergiInput();
            };

            // Initial load untuk alergi
            updateMainAlergiTable();
            updateHiddenAlergiInput();


            //====================================================================================//
            // PEMERIKSAAN FISIK - EDIT MODE
            //====================================================================================//

            // Event listener untuk tombol tambah keterangan
            document.querySelectorAll('.tambah-keterangan').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const keteranganDiv = document.getElementById(targetId);
                    const normalCheckbox = this.closest('.pemeriksaan-item')?.querySelector(
                        '.form-check-input');

                    if (keteranganDiv && normalCheckbox) {
                        if (keteranganDiv.style.display === 'none') {
                            keteranganDiv.style.display = 'block';
                            normalCheckbox.checked = false;
                            // Focus pada input keterangan
                            const input = keteranganDiv.querySelector('input');
                            if (input) {
                                setTimeout(() => input.focus(), 100);
                            }
                        } else {
                            keteranganDiv.style.display = 'block';
                        }
                    }
                });
            });

            // Event listener untuk checkbox normal
            document.querySelectorAll('.pemeriksaan-item .form-check-input').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const keteranganDiv = this.closest('.pemeriksaan-item')?.querySelector(
                        '.keterangan');

                    if (keteranganDiv && this.checked) {
                        // Jika checkbox normal diceklis, sembunyikan keterangan dan kosongkan input
                        keteranganDiv.style.display = 'none';
                        const input = keteranganDiv.querySelector('input');
                        if (input) {
                            input.value = '';
                        }
                    }
                });
            });

            // Event listener untuk input keterangan - jika diisi, uncheck normal
            document.querySelectorAll('.keterangan input').forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value.trim() !== '') {
                        const normalCheckbox = this.closest('.pemeriksaan-item')?.querySelector(
                            '.form-check-input');
                        if (normalCheckbox) {
                            normalCheckbox.checked = false;
                        }
                    }
                });
            });

            // Fungsi untuk memvalidasi pemeriksaan fisik sebelum submit
            function validatePemeriksaanFisik() {
                let hasError = false;
                const pemeriksaanItems = document.querySelectorAll('.pemeriksaan-item');

                pemeriksaanItems.forEach(item => {
                    const checkbox = item.querySelector('.form-check-input');
                    const keteranganInput = item.querySelector('.keterangan input');
                    const itemName = item.querySelector('.flex-grow-1').textContent.trim();

                    const isNormalChecked = checkbox && checkbox.checked;
                    const hasKeterangan = keteranganInput && keteranganInput.value.trim() !== '';

                    // Jika tidak ada yang dipilih (tidak normal dan tidak ada keterangan)
                    if (!isNormalChecked && !hasKeterangan) {
                        // Tambahkan visual indicator untuk item yang belum diisi
                        item.style.backgroundColor = '#fff3cd';
                        item.style.border = '1px solid #ffc107';
                        item.style.borderRadius = '4px';
                        item.style.padding = '8px';

                        hasError = true;
                    } else {
                        // Hapus visual indicator jika sudah diisi
                        item.style.backgroundColor = '';
                        item.style.border = '';
                        item.style.borderRadius = '';
                        item.style.padding = '';
                    }
                });

                if (hasError) {
                    alert(
                        'Mohon lengkapi semua pemeriksaan fisik. Pilih "Normal" atau isi keterangan untuk setiap item.'
                    );
                    // Scroll ke pemeriksaan fisik
                    document.getElementById('pemeriksaan-fisik').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    return false;
                }

                return true;
            }

            // Tambahkan validasi pada form submit
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!validatePemeriksaanFisik()) {
                        e.preventDefault();
                        return false;
                    }
                });
            }

            console.log('Pemeriksaan Fisik Edit Mode: Loaded with existing data');

            //====================================================================================//
            // DISCHARGE PLANNING - EDIT MODE
            //====================================================================================//

            const dischargePlanningSection = document.getElementById('discharge-planning');
            const planningSelects = [
                'usia_lanjut',
                'hambatan_mobilisasi',
                'penggunaan_media_berkelanjutan',
                'ketergantungan_aktivitas',
                'keterampilan_khusus',
                'alat_bantu',
                'nyeri_kronis'
            ];

            const alertInfo = document.getElementById('alert-info');
            const alertWarning = document.getElementById('alert-warning');
            const alertSuccess = document.getElementById('alert-success');
            const kesimpulanInput = document.getElementById('kesimpulan');

            function updateDischargePlanningConclusion() {
                let needsSpecialPlan = false;
                let allSelected = true;

                // Cek semua select yang relevan untuk kesimpulan
                const relevantSelects = [
                    'usia_lanjut',
                    'hambatan_mobilisasi',
                    'penggunaan_media_berkelanjutan',
                    'keterampilan_khusus',
                    'alat_bantu',
                    'nyeri_kronis'
                ];

                relevantSelects.forEach(selectId => {
                    const select = document.getElementById(selectId);
                    if (select) {
                        if (!select.value) {
                            allSelected = false;
                        } else if (select.value === 'ya' || select.value === '0') {
                            needsSpecialPlan = true;
                        }
                    }
                });

                // Hide semua alert dulu
                alertInfo.style.display = 'none';
                alertWarning.style.display = 'none';
                alertSuccess.style.display = 'none';

                // Show alert sesuai kondisi
                if (!allSelected) {
                    alertInfo.style.display = 'block';
                    kesimpulanInput.value = 'Pilih semua Planning';
                } else if (needsSpecialPlan) {
                    alertWarning.style.display = 'block';
                    kesimpulanInput.value = 'Mebutuhkan rencana pulang khusus';
                } else {
                    alertSuccess.style.display = 'block';
                    kesimpulanInput.value = 'Tidak mebutuhkan rencana pulang khusus';
                }
            }

            // Add event listeners untuk semua select
            planningSelects.forEach(selectId => {
                const select = document.getElementById(selectId);
                if (select) {
                    select.addEventListener('change', updateDischargePlanningConclusion);
                }
            });

            // Load initial state berdasarkan data existing
            function initializeDischargePlanning() {
                // Set nilai untuk ketergantungan_aktivitas jika belum ada di database
                // Karena field ini tidak ada di database, default ke kosong

                // Trigger update kesimpulan untuk pertama kali
                updateDischargePlanningConclusion();

                console.log('Discharge Planning Edit Mode: Initialized with existing data');
            }

            // Validation function untuk discharge planning
            function validateDischargePlanning() {
                let isValid = true;
                const requiredSelects = [
                    'usia_lanjut',
                    'hambatan_mobilisasi',
                    'penggunaan_media_berkelanjutan',
                    'keterampilan_khusus',
                    'alat_bantu',
                    'nyeri_kronis'
                ];

                requiredSelects.forEach(selectId => {
                    const select = document.getElementById(selectId);
                    if (select && !select.value) {
                        select.style.borderColor = '#dc3545';
                        select.style.backgroundColor = '#fff5f5';
                        isValid = false;
                    } else if (select) {
                        select.style.borderColor = '';
                        select.style.backgroundColor = '';
                    }
                });

                if (!isValid) {
                    alert('Mohon lengkapi semua pilihan Discharge Planning');
                    document.getElementById('discharge-planning').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }

                return isValid;
            }

            // Tambahkan validasi discharge planning ke form submit
            const existingForm = document.querySelector('form');
            if (existingForm) {
                // Hapus event listener lama jika ada
                const newForm = existingForm.cloneNode(true);
                existingForm.parentNode.replaceChild(newForm, existingForm);

                // Tambahkan event listener baru yang mencakup semua validasi
                newForm.addEventListener('submit', function(e) {
                    let isValid = true;

                    // Validasi pemeriksaan fisik (jika function ada)
                    if (typeof validatePemeriksaanFisik === 'function') {
                        isValid = validatePemeriksaanFisik() && isValid;
                    }

                    // Validasi discharge planning
                    isValid = validateDischargePlanning() && isValid;

                    if (!isValid) {
                        e.preventDefault();
                        return false;
                    }
                });
            }

            // Initialize discharge planning
            initializeDischargePlanning();


            //====================================================================================//
            // DIAGNOSIS - EDIT MODE
            //====================================================================================//

            // Initialize diagnosis management for both types
            initDiagnosisManagementEdit('diagnosis-banding', 'diagnosis_banding');
            initDiagnosisManagementEdit('diagnosis-kerja', 'diagnosis_kerja');

            function initDiagnosisManagementEdit(prefix, hiddenFieldId) {
                console.log(prefix)
                const inputField = document.getElementById(`${prefix}-input`);
                const addButton = document.getElementById(`add-${prefix}`);
                const listContainer = document.getElementById(`${prefix}-list`);
                const hiddenInput = document.getElementById(hiddenFieldId);
                const suggestionsList = document.createElement('div');

                // Style suggestions list
                suggestionsList.className = 'suggestions-list position-absolute bg-white border rounded shadow';
                suggestionsList.style.zIndex = '1000';
                suggestionsList.style.maxHeight = '200px';
                suggestionsList.style.overflowY = 'auto';
                suggestionsList.style.width = 'calc(100% - 30px)';
                suggestionsList.style.display = 'none';

                
                // Insert suggestions list after input
                console.log(inputField)
                inputField.parentNode.insertBefore(suggestionsList, inputField.nextSibling);

                // Database options
                const dbMasterDiagnosis = {!! json_encode($rmeMasterDiagnosis->pluck('nama_diagnosis')) !!};

                // Prepare options array
                const diagnosisOptions = dbMasterDiagnosis.map(text => ({
                    id: text.toLowerCase().replace(/\s+/g, '_'),
                    text: text
                }));

                // Load initial data from hidden input (existing data)
                let diagnosisList = [];
                try {
                    const existingData = hiddenInput.value;
                    if (existingData && existingData !== '[]') {
                        diagnosisList = JSON.parse(existingData);
                    }
                    renderDiagnosisList();
                } catch (e) {
                    console.log(`Error parsing ${prefix} data:`, e);
                    diagnosisList = [];
                    updateHiddenInput();
                }

                // Input event listener for suggestions
                inputField.addEventListener('input', function() {
                    const inputValue = this.value.trim().toLowerCase();

                    if (inputValue) {
                        // Filter database options
                        const filteredOptions = diagnosisOptions.filter(option =>
                            option.text.toLowerCase().includes(inputValue)
                        );

                        // Show suggestions
                        showSuggestions(filteredOptions, inputValue);
                    } else {
                        // Hide suggestions if input is empty
                        suggestionsList.style.display = 'none';
                    }
                });

                // Function to show suggestions
                function showSuggestions(options, inputValue) {
                    suggestionsList.innerHTML = '';

                    if (options.length > 0) {
                        // Render existing options
                        options.forEach(option => {
                            const suggestionItem = document.createElement('div');
                            suggestionItem.className = 'suggestion-item p-2 cursor-pointer hover:bg-light';
                            suggestionItem.style.cursor = 'pointer';

                            // Highlight matching text
                            const text = option.text;
                            const lowerText = text.toLowerCase();
                            const lowerInput = inputValue.toLowerCase();
                            const index = lowerText.indexOf(lowerInput);

                            if (index >= 0) {
                                const before = text.substring(0, index);
                                const match = text.substring(index, index + inputValue.length);
                                const after = text.substring(index + inputValue.length);
                                suggestionItem.innerHTML = `${before}<strong>${match}</strong>${after}`;
                            } else {
                                suggestionItem.textContent = text;
                            }

                            suggestionItem.addEventListener('click', () => {
                                addDiagnosis(option.text);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(suggestionItem);
                        });

                        // Add option to create new if no exact match
                        if (!options.some(opt => opt.text.toLowerCase() === inputValue)) {
                            const newOptionItem = document.createElement('div');
                            newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                            newOptionItem.style.cursor = 'pointer';
                            newOptionItem.innerHTML =
                                `<i class="bi bi-plus-circle me-1"></i> Tambah "${inputValue}"`;
                            newOptionItem.addEventListener('click', () => {
                                addDiagnosis(inputValue);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(newOptionItem);
                        }

                        suggestionsList.style.display = 'block';
                    } else {
                        // If no options, show add new option
                        const newOptionItem = document.createElement('div');
                        newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                        newOptionItem.style.cursor = 'pointer';
                        newOptionItem.innerHTML = `<i class="bi bi-plus-circle me-1"></i> Tambah "${inputValue}"`;
                        newOptionItem.addEventListener('click', () => {
                            addDiagnosis(inputValue);
                            suggestionsList.style.display = 'none';
                        });
                        suggestionsList.appendChild(newOptionItem);
                        suggestionsList.style.display = 'block';
                    }
                }

                // Add diagnosis when plus button is clicked
                addButton.addEventListener('click', function() {
                    const diagnosisText = inputField.value.trim();
                    if (diagnosisText) {
                        addDiagnosis(diagnosisText);
                    }
                });

                // Add diagnosis when Enter key is pressed
                inputField.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const diagnosisText = this.value.trim();
                        if (diagnosisText) {
                            addDiagnosis(diagnosisText);
                        }
                    }
                });

                // Close suggestions when clicking outside
                document.addEventListener('click', function(e) {
                    if (!inputField.contains(e.target) && !suggestionsList.contains(e.target)) {
                        suggestionsList.style.display = 'none';
                    }
                });

                function addDiagnosis(diagnosisText) {
                    // Check for duplicates
                    if (!diagnosisList.includes(diagnosisText)) {
                        diagnosisList.push(diagnosisText);
                        inputField.value = '';
                        renderDiagnosisList();
                        updateHiddenInput();
                        suggestionsList.style.display = 'none';

                        // Show success feedback
                        showFeedback(`"${diagnosisText}" berhasil ditambahkan`, 'success');
                    } else {
                        // Show duplicate feedback
                        showFeedback(`"${diagnosisText}" sudah ada dalam daftar`, 'warning');
                    }
                }

                function renderDiagnosisList() {
                    listContainer.innerHTML = '';

                    if (diagnosisList.length === 0) {
                        const emptyMessage = document.createElement('div');
                        emptyMessage.className = 'text-muted text-center py-3';
                        emptyMessage.innerHTML =
                            '<i class="bi bi-info-circle me-2"></i>Belum ada diagnosis yang ditambahkan';
                        listContainer.appendChild(emptyMessage);
                    } else {
                        diagnosisList.forEach((diagnosis, index) => {
                            const diagnosisItem = document.createElement('div');
                            diagnosisItem.className =
                                'diagnosis-item d-flex justify-content-between align-items-center mb-2 p-2 bg-white rounded border';

                            const diagnosisSpan = document.createElement('span');
                            diagnosisSpan.innerHTML = `<strong>${index + 1}.</strong> ${diagnosis}`;

                            const deleteButton = document.createElement('button');
                            deleteButton.className = 'btn btn-sm text-danger';
                            deleteButton.innerHTML = '<i class="bi bi-trash"></i>';
                            deleteButton.type = 'button';
                            deleteButton.title = 'Hapus diagnosis';
                            deleteButton.addEventListener('click', function() {
                                diagnosisList.splice(index, 1);
                                renderDiagnosisList();
                                updateHiddenInput();
                                showFeedback(`Diagnosis "${diagnosis}" berhasil dihapus`, 'info');
                            });

                            diagnosisItem.appendChild(diagnosisSpan);
                            diagnosisItem.appendChild(deleteButton);
                            listContainer.appendChild(diagnosisItem);
                        });
                    }
                }

                function updateHiddenInput() {
                    hiddenInput.value = JSON.stringify(diagnosisList);
                }

                function showFeedback(message, type) {
                    // Create feedback element
                    const feedback = document.createElement('div');
                    feedback.className = `alert alert-${type} alert-dismissible fade show mt-2`;
                    feedback.innerHTML = `
                        <small>${message}</small>
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                    `;

                    // Insert after list container
                    listContainer.parentNode.insertBefore(feedback, listContainer.nextSibling);

                    // Auto-dismiss after 3 seconds
                    setTimeout(() => {
                        if (feedback.parentNode) {
                            feedback.classList.remove('show');
                            setTimeout(() => {
                                if (feedback.parentNode) {
                                    feedback.parentNode.removeChild(feedback);
                                }
                            }, 150);
                        }
                    }, 3000);
                }

                // Initialize with existing data
                console.log(`${prefix} initialized with ${diagnosisList.length} items`);
            }

            //====================================================================================//
            // IMPLEMENTASI - EDIT MODE
            //====================================================================================//

            // Initialize all implementation sections
            initImplementationSectionEdit('observasi', 'observasi', 'observasi');
            initImplementationSectionEdit('terapeutik', 'terapeutik', 'terapeutik');
            initImplementationSectionEdit('edukasi', 'edukasi', 'edukasi');
            initImplementationSectionEdit('kolaborasi', 'kolaborasi', 'kolaborasi');

            function initImplementationSectionEdit(prefix, hiddenFieldId, dbColumn) {
                const inputField = document.getElementById(`${prefix}-input`);
                const addButton = document.getElementById(`add-${prefix}`);
                const listContainer = document.getElementById(`${prefix}-list`);
                const hiddenInput = document.getElementById(hiddenFieldId);
                const suggestionsList = document.createElement('div');

                // Style suggestions list
                suggestionsList.className = 'suggestions-list position-absolute bg-white border rounded shadow';
                suggestionsList.style.zIndex = '1000';
                suggestionsList.style.maxHeight = '200px';
                suggestionsList.style.overflowY = 'auto';
                suggestionsList.style.width = 'calc(100% - 40px)';
                suggestionsList.style.display = 'none';

                // Insert suggestions list after input
                console.log(inputField)
                console.log(`${prefix}-input`)

                
                if (!inputField) {
                    console.warn(`Input ${prefix}-input tidak ditemukan`);
                    return;
                }
                inputField.parentNode.insertBefore(suggestionsList, inputField.nextSibling);

                // Get database options
                const rmeMasterImplementasi = {!! json_encode($rmeMasterImplementasi) !!};

                // Filter out non-null values for this column
                let optionsFromDb = [];
                if (rmeMasterImplementasi && rmeMasterImplementasi.length > 0) {
                    optionsFromDb = rmeMasterImplementasi
                        .filter(item => item[dbColumn] !== null &&
                            item[dbColumn] !== '(N/A)' &&
                            item[dbColumn] !== '(Null)' &&
                            item[dbColumn] !== '')
                        .map(item => item[dbColumn]);
                }

                // Remove duplicates
                const uniqueOptions = [...new Set(optionsFromDb)];

                // Prepare options array
                const options = uniqueOptions.map(text => ({
                    id: text.toLowerCase().replace(/\s+/g, '_'),
                    text: text
                }));

                // Load initial data from hidden input (existing data)
                let itemsList = [];
                try {
                    const existingData = hiddenInput.value;
                    if (existingData && existingData !== '[]') {
                        itemsList = JSON.parse(existingData);
                    }
                    renderItemsList();
                } catch (e) {
                    console.log(`Error parsing ${prefix} data:`, e);
                    itemsList = [];
                    updateHiddenInput();
                }

                // Input event listener for suggestions
                inputField.addEventListener('input', function() {
                    const inputValue = this.value.trim().toLowerCase();

                    if (inputValue) {
                        const filteredOptions = options.filter(option =>
                            option.text.toLowerCase().includes(inputValue)
                        );

                        const exactMatch = options.some(opt =>
                            opt.text.toLowerCase() === inputValue
                        );

                        showSuggestions(filteredOptions, inputValue, exactMatch);
                    } else {
                        suggestionsList.style.display = 'none';
                    }
                });

                // Function to show suggestions
                function showSuggestions(filtered, inputValue, exactMatch) {
                    suggestionsList.innerHTML = '';

                    if (filtered.length > 0) {
                        filtered.forEach(option => {
                            const suggestionItem = document.createElement('div');
                            suggestionItem.className = 'suggestion-item p-2 cursor-pointer hover:bg-light';
                            suggestionItem.style.cursor = 'pointer';

                            const text = option.text;
                            const lowerText = text.toLowerCase();
                            const lowerInput = inputValue.toLowerCase();
                            const index = lowerText.indexOf(lowerInput);

                            if (index >= 0) {
                                const before = text.substring(0, index);
                                const match = text.substring(index, index + inputValue.length);
                                const after = text.substring(index + inputValue.length);
                                suggestionItem.innerHTML = `${before}<strong>${match}</strong>${after}`;
                            } else {
                                suggestionItem.textContent = text;
                            }

                            suggestionItem.addEventListener('click', () => {
                                addItem(option.text);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(suggestionItem);
                        });

                        // Add option to create new if no exact match
                        if (!exactMatch) {
                            const newOptionItem = document.createElement('div');
                            newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                            newOptionItem.style.cursor = 'pointer';
                            newOptionItem.innerHTML =
                                `<i class="bi bi-plus-circle me-1"></i> Tambah "${inputValue}"`;
                            newOptionItem.addEventListener('click', () => {
                                addItem(inputValue);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(newOptionItem);
                        }

                        suggestionsList.style.display = 'block';
                    } else {
                        // If no options, show add new option
                        const newOptionItem = document.createElement('div');
                        newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                        newOptionItem.style.cursor = 'pointer';
                        newOptionItem.innerHTML = `<i class="bi bi-plus-circle me-1"></i> Tambah "${inputValue}"`;
                        newOptionItem.addEventListener('click', () => {
                            addItem(inputValue);
                            suggestionsList.style.display = 'none';
                        });
                        suggestionsList.appendChild(newOptionItem);
                        suggestionsList.style.display = 'block';
                    }
                }

                // Add item when plus button is clicked
                addButton.addEventListener('click', function() {
                    const itemText = inputField.value.trim();
                    if (itemText) {
                        addItem(itemText);
                    }
                });

                // Add item when Enter key is pressed
                inputField.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const itemText = this.value.trim();
                        if (itemText) {
                            addItem(itemText);
                        }
                    }
                });

                // Close suggestions when clicking outside
                document.addEventListener('click', function(e) {
                    if (!inputField.contains(e.target) && !suggestionsList.contains(e.target)) {
                        suggestionsList.style.display = 'none';
                    }
                });

                /**
                 * Add item to the list
                 */
                function addItem(itemText) {
                    // Check for duplicates
                    if (!itemsList.includes(itemText)) {
                        itemsList.push(itemText);
                        inputField.value = '';
                        renderItemsList();
                        updateHiddenInput();
                        suggestionsList.style.display = 'none';

                        // Show success feedback
                        showImplementationFeedback(
                            `"${itemText}" berhasil ditambahkan ke ${getDisplayName(prefix)}`, 'success',
                            listContainer);
                    } else {
                        // Show duplicate feedback
                        showImplementationFeedback(`"${itemText}" sudah ada dalam daftar ${getDisplayName(prefix)}`,
                            'warning', listContainer);
                    }
                }

                /**
                 * Render items list in the container
                 */
                function renderItemsList() {
                    listContainer.innerHTML = '';

                    if (itemsList.length === 0) {
                        const emptyMessage = document.createElement('div');
                        emptyMessage.className = 'text-muted text-center py-3';
                        emptyMessage.innerHTML =
                            `<i class="bi bi-info-circle me-2"></i>Belum ada data ${getDisplayName(prefix)}`;
                        listContainer.appendChild(emptyMessage);
                    } else {
                        itemsList.forEach((item, index) => {
                            const itemElement = document.createElement('div');
                            itemElement.className =
                                'list-group-item d-flex justify-content-between align-items-center border-0 ps-0 bg-white rounded mb-2 shadow-sm';
                            itemElement.style.border = '1px solid #e3e6f0';
                            itemElement.style.padding = '12px';

                            const itemSpan = document.createElement('span');
                            itemSpan.innerHTML = `<strong>${index + 1}.</strong> ${item}`;

                            const deleteButton = document.createElement('button');
                            deleteButton.className = 'btn btn-link text-danger p-0';
                            deleteButton.type = 'button';
                            deleteButton.innerHTML = '<i class="bi bi-trash"></i>';
                            deleteButton.title = `Hapus ${getDisplayName(prefix)}`;
                            deleteButton.addEventListener('click', function() {
                                itemsList.splice(index, 1);
                                renderItemsList();
                                updateHiddenInput();
                                showImplementationFeedback(
                                    `Item "${item}" berhasil dihapus dari ${getDisplayName(prefix)}`,
                                    'info', listContainer);
                            });

                            itemElement.appendChild(itemSpan);
                            itemElement.appendChild(deleteButton);
                            listContainer.appendChild(itemElement);
                        });
                    }
                }

                /**
                 * Update hidden input with JSON data
                 */
                function updateHiddenInput() {
                    hiddenInput.value = JSON.stringify(itemsList);
                }

                function getDisplayName(prefix) {
                    const displayNames = {
                        'rencana': 'Prognosis',
                        'observasi': 'Observasi',
                        'terapeutik': 'Terapeutik',
                        'edukasi': 'Edukasi',
                        'kolaborasi': 'Kolaborasi'
                    };
                    return displayNames[prefix] || prefix;
                }

                // Initialize with existing data
                console.log(`${prefix} initialized with ${itemsList.length} items`);
            }

            // Shared feedback function for implementation sections
            function showImplementationFeedback(message, type, container) {
                // Create feedback element
                const feedback = document.createElement('div');
                feedback.className = `alert alert-${type} alert-dismissible fade show mt-2`;
                feedback.innerHTML = `
                    <small>${message}</small>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                `;

                // Insert after container
                container.parentNode.insertBefore(feedback, container.nextSibling);

                // Auto-dismiss after 3 seconds
                setTimeout(() => {
                    if (feedback.parentNode) {
                        feedback.classList.remove('show');
                        setTimeout(() => {
                            if (feedback.parentNode) {
                                feedback.parentNode.removeChild(feedback);
                            }
                        }, 150);
                    }
                }, 3000);
            }

            console.log('All Implementation sections initialized in edit mode');


            //====================================================================================//
            // SITE MARKING - EDIT MODE
            //====================================================================================//

            function initSiteMarkingEdit() {
                const image = document.getElementById('anatomyImage');
                const canvas = document.getElementById('markingCanvas');
                const ctx = canvas.getContext('2d');
                const markingsList = document.getElementById('markingsList');
                const siteMarkingData = document.getElementById('siteMarkingData');
                const markingNote = document.getElementById('markingNote');
                const clearAllBtn = document.getElementById('clearAllMarking');
                const markingCount = document.getElementById('markingCount');
                const emptyState = document.getElementById('emptyState');

                console.log(siteMarkingData)

                let markings = [];
                let markingCounter = 1;
                let currentColor = '#dc3545';
                let isDrawing = false;
                let startX = 0;
                let startY = 0;

                // Initialize color selection
                initColorSelectionEdit();

                // Setup canvas
                setupCanvasEdit();

                // Load existing data
                loadExistingDataEdit();

                function setupCanvasEdit() {
                    function updateCanvasSize() {
                        const rect = image.getBoundingClientRect();
                        canvas.width = image.offsetWidth;
                        canvas.height = image.offsetHeight;
                        canvas.style.width = image.offsetWidth + 'px';
                        canvas.style.height = image.offsetHeight + 'px';

                        // Redraw all markings
                        redrawCanvasEdit();
                    }

                    // Update canvas size when image loads
                    image.onload = updateCanvasSize;

                    // Update canvas size when window resizes
                    window.addEventListener('resize', updateCanvasSize);

                    // Initial setup
                    if (image.complete) {
                        updateCanvasSize();
                    }
                }

                function initColorSelectionEdit() {
                    document.querySelectorAll('.color-btn').forEach(btn => {
                        btn.addEventListener('click', function() {
                            currentColor = this.getAttribute('data-color');
                            updateColorSelectionEdit();
                        });
                    });
                }

                function updateColorSelectionEdit() {
                    document.querySelectorAll('.color-btn').forEach(btn => {
                        btn.classList.remove('active');
                    });

                    const selectedBtn = document.querySelector(`[data-color="${currentColor}"]`);
                    if (selectedBtn) {
                        selectedBtn.classList.add('active');
                    }
                }

                // Mouse events for drawing
                canvas.addEventListener('mousedown', function(e) {
                    isDrawing = true;
                    const rect = canvas.getBoundingClientRect();
                    startX = e.clientX - rect.left;
                    startY = e.clientY - rect.top;
                });

                canvas.addEventListener('mousemove', function(e) {
                    if (!isDrawing) return;

                    const rect = canvas.getBoundingClientRect();
                    const endX = e.clientX - rect.left;
                    const endY = e.clientY - rect.top;

                    // Clear canvas and redraw all markings
                    redrawCanvasEdit();

                    // Draw preview arrow
                    drawArrowEdit(ctx, startX, startY, endX, endY, currentColor, true);
                });

                canvas.addEventListener('mouseup', function(e) {
                    if (!isDrawing) return;

                    const rect = canvas.getBoundingClientRect();
                    const endX = e.clientX - rect.left;
                    const endY = e.clientY - rect.top;

                    // Only create arrow if there's actual movement
                    const distance = Math.sqrt(Math.pow(endX - startX, 2) + Math.pow(endY - startY, 2));
                    if (distance > 10) { // Minimum distance
                        addMarkingEdit(startX, startY, endX, endY);
                    }

                    isDrawing = false;
                    redrawCanvasEdit();
                });

                function addMarkingEdit(startX, startY, endX, endY) {
                    const note = markingNote.value.trim() || `Penandaan ${markingCounter}`;

                    // Convert to percentage for responsiveness
                    const startXPercent = (startX / canvas.width) * 100;
                    const startYPercent = (startY / canvas.height) * 100;
                    const endXPercent = (endX / canvas.width) * 100;
                    const endYPercent = (endY / canvas.height) * 100;

                    const marking = {
                        id: `mark_${Date.now()}`,
                        startX: startXPercent,
                        startY: startYPercent,
                        endX: endXPercent,
                        endY: endYPercent,
                        color: currentColor,
                        note: note,
                        timestamp: new Date().toISOString()
                    };

                    markings.push(marking);

                    // Add to list
                    addToMarkingsListEdit(marking);

                    // Update hidden input and counter
                    updateHiddenInputEdit();
                    updateMarkingCountEdit();

                    // Clear note input
                    markingNote.value = '';
                    markingCounter++;

                    // Redraw canvas
                    redrawCanvasEdit();
                }

                function drawArrowEdit(ctx, startX, startY, endX, endY, color, isPreview = false) {
                    ctx.strokeStyle = color;
                    ctx.fillStyle = color;
                    ctx.lineWidth = isPreview ? 2 : 3;
                    ctx.lineCap = 'round';

                    // Draw line
                    ctx.beginPath();
                    ctx.moveTo(startX, startY);
                    ctx.lineTo(endX, endY);
                    ctx.stroke();

                    // Calculate arrow head
                    const angle = Math.atan2(endY - startY, endX - startX);
                    const arrowLength = 15;
                    const arrowAngle = Math.PI / 6;

                    // Draw arrow head
                    ctx.beginPath();
                    ctx.moveTo(endX, endY);
                    ctx.lineTo(
                        endX - arrowLength * Math.cos(angle - arrowAngle),
                        endY - arrowLength * Math.sin(angle - arrowAngle)
                    );
                    ctx.moveTo(endX, endY);
                    ctx.lineTo(
                        endX - arrowLength * Math.cos(angle + arrowAngle),
                        endY - arrowLength * Math.sin(angle + arrowAngle)
                    );
                    ctx.stroke();
                }

                function redrawCanvasEdit() {
                    // Clear canvas
                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                    // Draw all markings
                    markings.forEach(marking => {
                        const startX = (marking.startX / 100) * canvas.width;
                        const startY = (marking.startY / 100) * canvas.height;
                        const endX = (marking.endX / 100) * canvas.width;
                        const endY = (marking.endY / 100) * canvas.height;

                        drawArrowEdit(ctx, startX, startY, endX, endY, marking.color);
                    });
                }

                function addToMarkingsListEdit(marking) {
                    // Hide empty state
                    emptyState.style.display = 'none';

                    const listItem = document.createElement('div');
                    listItem.className = 'marking-list-item';
                    listItem.setAttribute('data-marking-id', marking.id);

                    listItem.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">${marking.note}</div>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <span class="badge" style="background-color: ${marking.color}; color: white; font-size: 10px;">PANAH</span>
                                    <small class="text-muted">${new Date(marking.timestamp).toLocaleTimeString('id-ID')}</small>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteMarkingEdit('${marking.id}')">
                                <i class="ti-trash"></i>
                            </button>
                        </div>
                    `;

                    markingsList.appendChild(listItem);
                }

                function updateMarkingCountEdit() {
                    markingCount.textContent = markings.length;

                    // Show/hide empty state
                    if (markings.length === 0) {
                        emptyState.style.display = 'block';
                    } else {
                        emptyState.style.display = 'none';
                    }
                }

                function updateHiddenInputEdit() {
                    siteMarkingData.value = JSON.stringify(markings);
                }

                function loadExistingDataEdit() {
                    try {
                        const existingData = JSON.parse(siteMarkingData.value || '[]');
                        console.log(existingData)
                        if (existingData.length > 0) {
                            markings = existingData;
                            markingCounter = markings.length + 1;

                            // Rebuild list
                            markingsList.innerHTML =
                                '<div class="text-muted text-center py-3" id="emptyState"><i class="ti-info-alt"></i> Belum ada penandaan</div>';
                            markings.forEach(marking => {
                                addToMarkingsListEdit(marking);
                            });

                            updateMarkingCountEdit();

                            // Redraw canvas after a short delay
                            setTimeout(() => {
                                redrawCanvasEdit();
                            }, 100);
                        }
                    } catch (e) {
                        console.error('Error loading existing marking data:', e);
                    }
                }

                // Clear all markings
                clearAllBtn.addEventListener('click', function() {
                    if (markings.length === 0) return;

                    if (confirm('Hapus semua penandaan?')) {
                        markings = [];
                        markingsList.innerHTML =
                            '<div class="text-muted text-center py-3" id="emptyState"><i class="ti-info-alt"></i> Belum ada penandaan</div>';
                        updateHiddenInputEdit();
                        updateMarkingCountEdit();
                        redrawCanvasEdit();
                        markingCounter = 1;
                    }
                });

                // Global function for delete
                window.deleteMarkingEdit = function(markingId) {
                    if (confirm('Hapus penandaan ini?')) {
                        // Remove from array
                        markings = markings.filter(m => m.id !== markingId);

                        // Remove from list
                        const listElement = markingsList.querySelector(`[data-marking-id="${markingId}"]`);
                        if (listElement) {
                            markingsList.removeChild(listElement);
                        }

                        updateHiddenInputEdit();
                        updateMarkingCountEdit();
                        redrawCanvasEdit();
                    }
                };
            }

            // Initialize site marking for edit mode
            initSiteMarkingEdit();

            console.log('Site Marking Edit Mode: Initialized');


        });
    </script>
@endpush
