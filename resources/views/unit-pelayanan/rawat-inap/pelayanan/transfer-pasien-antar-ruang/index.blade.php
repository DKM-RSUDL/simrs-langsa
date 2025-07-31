@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .header-background {
                height: 100%;
                background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
            }

            .form-section {
                border: 1px solid #dee2e6;
                margin-bottom: 1rem;
                border-radius: 0.375rem;
            }

            .section-header {
                background-color: #f8f9fa;
                padding: 12px 15px;
                border-bottom: 1px solid #dee2e6;
                font-weight: 600;
                color: #495057;
                border-radius: 0.375rem 0.375rem 0 0;
            }

            .section-content {
                padding: 15px;
            }

            .checkbox-group {
                margin-bottom: 0.75rem;
            }

            .checkbox-inline {
                display: inline-flex;
                align-items: center;
                margin-right: 20px;
                margin-bottom: 8px;
            }

            .vital-signs {
                background-color: #f8f9fa;
                border-radius: 0.375rem;
                padding: 15px;
                margin-bottom: 1rem;
            }

            .table-status th {
                background-color: #e9ecef;
                font-weight: 600;
                text-align: center;
                vertical-align: middle;
            }

            .table-status td {
                text-align: center;
                vertical-align: middle;
            }

            .signature-box {
                border: 1px solid #dee2e6;
                height: 100px;
                background-color: #f8f9fa;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #6c757d;
                border-radius: 0.375rem;
            }

        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="text-center mt-1 mb-3">
                <h4 class="text-primary fw-bold">FORM TRANSFER PASIEN ANTAR RUANG</h4>
            </div>

            <form action="" method="post">
                @csrf
                @method('put')

                <!-- Informasi Dasar Transfer -->
                <div class="row form-section">
                    <div class="col-6">
                        {{-- <div class="mb-4">
                            <h5 class="fw-bold">SBAR</h5>
                            <div class="row g-3">
                                <div class="col-12 mb-3">
                                    <label>Subjective</label>
                                    <textarea name="subjective" placeholder="Data subjektif" class="form-control" rows="5"
                                        required>{{ old('subjective') }}</textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <label>Background</label>
                                    <textarea name="background" placeholder="Background" class="form-control" rows="5"
                                        required>{{ old('background') }}</textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <label>Assessment</label>
                                    <textarea name="assessment" placeholder="Assessment" class="form-control" rows="5"
                                        required>{{ old('assessment') }}</textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <label>Recommendation</label>
                                    <textarea name="recomendation" placeholder="Recommendation" class="form-control"
                                        rows="5" required>{{ old('recomendation') }}</textarea>
                                </div>
                            </div>
                        </div> --}}

                        <div class="mb-4">
                            <h5 class="fw-bold">Yang Menyerahkan:</h5>
                            {{-- <div class="mb-3">
                                <label for="kd_unit_asal">Dari Unit/ Ruang</label>
                                <select name="kd_unit_asal" id="kd_unit_asal" class="form-select select2" disabled>
                                    <option value="">--Pilih--</option>
                                    @foreach ($unit as $item)
                                        <option value="{{ $item->kd_unit }}" @selected($item->kd_unit == $dataMedis->kd_unit)>
                                            {{ $item->nama_unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kd_unit_tujuan">Tujuan ke Unit/ Ruang</label>
                                <select name="kd_unit_tujuan" id="kd_unit_tujuan" class="form-select select2">
                                    <option value="">--Pilih--</option>
                                    @foreach ($unitTujuan as $item)
                                        <option value="{{ $item->kd_unit }}">
                                            {{ $item->nama_unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <label for="#no_kamar" class="form-label">Kamar</label>
                                <select name="no_kamar" id="no_kamar" class="form-select select2" required>
                                    <option value="">--Pilih Kamar--</option>
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <label for="#sisa_bed" class="form-label">Sisa Bed</label>
                                <input class="form-control" name="sisa_bed" type="text" id="sisa_bed" value="0" readonly>
                            </div> --}}

                            <!-- Unit Asal -->
                            <div class="mb-3">
                                <label for="kd_unit_asal" class="form-label">Dari Unit/ Ruang</label>
                                <select name="kd_unit_asal" id="kd_unit_asal" class="form-select select2" disabled>
                                    <option value="">--Pilih--</option>
                                    @foreach ($unit as $item)
                                        <option value="{{ $item->kd_unit }}" @selected($item->kd_unit == $dataMedis->kd_unit)>
                                            {{ $item->nama_unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Unit Tujuan -->
                            <div class="mb-3">
                                <label for="kd_unit_tujuan" class="form-label">Tujuan ke Unit/ Ruang <span class="text-danger">*</span></label>
                                <select name="kd_unit_tujuan" id="kd_unit_tujuan" class="form-select select2" required>
                                    <option value="">--Pilih--</option>
                                    @foreach ($unitTujuan as $item)
                                        <option value="{{ $item->kd_unit }}">
                                            {{ $item->nama_unit }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Silakan pilih unit tujuan
                                </div>
                            </div>

                            <!-- Kamar -->
                            <div class="form-group mt-3">
                                <label for="no_kamar" class="form-label">Kamar <span class="text-danger">*</span></label>
                                <select name="no_kamar" id="no_kamar" class="form-select select2" required>
                                    <option value="">--Pilih Kamar--</option>
                                </select>
                                <div class="invalid-feedback">
                                    Silakan pilih kamar
                                </div>
                                <small class="form-text text-muted">Pilih unit tujuan terlebih dahulu</small>
                            </div>

                            <!-- Loading indicator (hidden by default) -->
                            <div id="loading-indicator" class="text-center mt-2" style="display: none;">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <span class="ms-2 text-muted">Memuat data...</span>
                            </div>

                            <div class="mb-3">
                                <label for="petugas_menyerahkan">Petugas yang Menyerahkan</label>
                                <select name="petugas_menyerahkan" id="petugas_menyerahkan" class="form-select select2">
                                    <option value="">--Pilih--</option>
                                    <option value="{{ auth()->user()->kd_karyawan }}" selected>
                                        {{ auth()->user()->karyawan->gelar_depan . ' ' .
        str()->title(auth()->user()->karyawan->nama) . ' ' .
        auth()->user()->karyawan->gelar_belakang }}
                                    </option>

                                    @foreach ($petugas as $item)
                                        @if ($item->kd_karyawan != auth()->user()->kd_karyawan)
                                                                <option value="{{ $item->kd_karyawan }}">
                                                                    {{ $item->gelar_depan . ' ' . str()->title($item->nama) . ' ' .
                                            $item->gelar_belakang }}
                                                                </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-md-6">
                                    <label>Tanggal</label>
                                    <input type="date" name="tanggal_menyerahkan" value="{{ date('Y-m-d') }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Jam</label>
                                    <input type="time" name="jam_menyerahkan" value="{{ date('H:i') }}" class="form-control"
                                        required>
                                </div>
                            </div>
                            {{-- <button type="button" class="btn btn-primary w-100">Validasi petugas yang menerima</button>
                            --}}
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="mb-4">
                            <h5 class="fw-bold">Yang Menerima:</h5>
                            <div class="mb-3">
                                <label>Diterima di Ruang/ Unit Pelayanan</label>
                                <input type="text" class="form-control" value="" disabled>
                            </div>
                            <div class="mb-3">
                                <label>Petugas yang Menerima</label>
                                <input type="text" class="form-control" value="" disabled>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-6">
                                    <label>Tanggal</label>
                                    <input type="date" value="" class="form-control" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label>Jam</label>
                                    <input type="time" value="" class="form-control" disabled>
                                </div>
                            </div>
                            {{-- <button type="button" class="btn btn-primary w-100">Validasi petugas yang menerima</button>
                            --}}
                        </div>
                    </div>
                </div>

                <!-- Informasi Medis -->
                <div class="form-section">
                    <div class="section-header">Informasi Medis</div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label class="form-label">Dokter yang Merawat</label>
                                    <select name="dokter_merawat" class="form-select select2">
                                        @foreach ($dokter as $item)
                                            <option value="">--Pilih--</option>
                                            <option value="{{ $item->kd_dokter }}">
                                                {{ $item->nama_lengkap }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('dokter_merawat')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Diagnosis Utama</label>
                                    <textarea name="diagnosis_utama" class="form-control" rows="3"
                                        placeholder="Tuliskan diagnosis utama pasien"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Diagnosis Sekunder</label>
                                    <textarea name="diagnosis_sekunder" class="form-control" rows="3"
                                        placeholder="Tuliskan diagnosis sekunder jika ada"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">DPJP (Dokter Penanggung Jawab Pelayanan)</label>
                                    <select name="dpjp" class="form-select select2">
                                        @foreach ($dokter as $item)
                                            <option value="">--Pilih--</option>
                                            <option value="{{ $item->kd_dokter }}">
                                                {{ $item->nama_lengkap }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('dpjp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div>
                                    <label class="form-label fw-bold">Perlu Menjadi Perhatian:</label>
                                    <div class="mb-3">
                                        <label for="mrsa" class="form-label">MRSA:</label>
                                        <input type="text" name="mrsa" class="form-control" placeholder="Detail MRSA">
                                    </div>
                                    <div class="mb-3">
                                        <label for="lainnya_perhatian" class="form-label">Lainnya:</label>
                                        <input type="text" name="lainnya_perhatian" class="form-control" placeholder="Sebutkan lainnya">
                                    </div>
                                </div>
                            </div>

                            <div class="section-separator" id="alergi">
                                <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-allergies"></i> Alergi</h6>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="openAlergiModal"
                                    data-bs-toggle="modal" data-bs-target="#alergiModal">
                                    <i class="ti-plus"></i> Tambah Alergi
                                </button>
                                <input type="hidden" name="alergis" id="alergisInput" value="[]">
                                <div class="table-responsive mt-2">
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
                                                <td colspan="5" class="text-center text-muted">Tidak ada
                                                    data alergi</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Persetujuan Pasien/Keluarga -->
                <div class="form-section">
                    <div class="section-header">Persetujuan dan Alasan Pemindahan</div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Pasien/keluarga mengetahui dan menyetujui
                                        pemindahan:</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="persetujuan" value="ya"
                                            id="setuju_ya">
                                        <label class="form-check-label" for="setuju_ya">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="persetujuan" value="tidak"
                                            id="setuju_tidak">
                                        <label class="form-check-label" for="setuju_tidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Bila pemberi persetujuan adalah keluarga:</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Nama</label>
                                            <input type="text" name="nama_keluarga" class="form-control"
                                                placeholder="Nama keluarga">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Hubungan</label>
                                            <input type="text" name="hubungan_keluarga" class="form-control"
                                                placeholder="Hubungan dengan pasien">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Alasan Pemindahan:</label>
                                <div class="checkbox-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="alasan[]" value="kondisi"
                                            id="kondisi">
                                        <label class="form-check-label" for="kondisi">
                                            Kondisi pasien: memburuk/stabil/tidak ada perubahan
                                        </label>
                                    </div>
                                </div>
                                <div class="checkbox-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="alasan[]" value="fasilitas"
                                            id="fasilitas">
                                        <label class="form-check-label" for="fasilitas">
                                            Fasilitas: kurang memadai/butuh peralatan yang lebih baik
                                        </label>
                                    </div>
                                </div>
                                <div class="checkbox-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="alasan[]" value="tenaga"
                                            id="tenaga">
                                        <label class="form-check-label" for="tenaga">
                                            Tenaga: membutuhkan tenaga yang lebih ahli/tenaga kurang
                                        </label>
                                    </div>
                                </div>
                                <div class="checkbox-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="alasan[]"
                                            value="lainnya_alasan" id="lainnya_alasan">
                                        <label class="form-check-label" for="lainnya_alasan">Lainnya:</label>
                                        <input type="text" name="lainnya_alasan_detail"
                                            class="form-control form-control-sm mt-1" placeholder="Sebutkan alasan lainnya">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Metode Pemindahan:</label>
                            <div class="checkbox-group d-flex gap-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="metode[]" value="kursi_roda"
                                        id="kursi_roda">
                                    <label class="form-check-label" for="kursi_roda">Kursi Roda</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="metode[]" value="brankar"
                                        id="brankar">
                                    <label class="form-check-label" for="brankar">Brankar</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="metode[]" value="tempat_tidur"
                                        id="tempat_tidur">
                                    <label class="form-check-label" for="tempat_tidur">Tempat Tidur</label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Keadaan pasien saat pindah -->
                <div class="form-section">
                    <div class="section-header">Keadaan Pasien Saat Pindah</div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Hubungan</label>
                                    <input type="text" name="keadaan_umum" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="kesadaran" class="form-label">Kesadaran</label>
                                    <select name="kesadaran" id="kesadaran" class="form-select select2" required>
                                        <option value="">--Pilih--</option>
                                        <option value="Compos Mentis">Compos Mentis</option>
                                        <option value="Apatis">Apatis</option>
                                        <option value="Sopor">Sopor</option>
                                        <option value="Coma">Coma</option>
                                        <option value="Somnolen">Somnolen</option>                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tekanan Darah</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="tekanan_darah_sistole" class="form-label">Sistole</label>
                                            <input type="number" class="form-control" name="tekanan_darah_sistole"
                                                id="tekanan_darah_sistole" placeholder="Sistole (mmHg)" min="50" max="250"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tekanan_darah_diastole" class="form-label">Diastole</label>
                                            <input type="number" class="form-control" name="tekanan_darah_diastole"
                                                id="tekanan_darah_diastole" placeholder="Diastole (mmHg)" min="30" max="150"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="nadi" class="form-label">Nadi</label>
                                            <input type="number" class="form-control" name="nadi" id="nadi"
                                                placeholder="Nadi (bpm)" min="30" max="200" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="suhu" class="form-label">Suhu</label>
                                            <input type="number" step="0.1" class="form-control" name="suhu" id="suhu"
                                                placeholder="Suhu (°C)" min="34" max="42" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="resp" class="form-label">Respirasi</label>
                                            <input type="number" class="form-control" name="resp" id="resp"
                                                placeholder="Respirasi (x/menit)" min="8" max="40" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="status_nyeri" class="form-label">Status Nyeri</label>
                                            <select name="status_nyeri" id="status_nyeri" class="form-select select2"
                                                required>
                                                <option value="">--Pilih--</option>
                                                <option value="tidak_ada">Tidak Ada</option>
                                                <option value="ringan">Ringan</option>
                                                <option value="sedang">Sedang</option>
                                                <option value="berat">Berat</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Medis dan Peralatan yang menyertai saat pindah -->
                <div class="form-section">
                    <div class="section-header">Informasi Medis dan Peralatan yang Menyertai Saat Pindah</div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Informasi Medis:</label>
                                <div class="checkbox-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="info_medis[]"
                                            value="disabilitas" id="disabilitas">
                                        <label class="form-check-label" for="disabilitas">Disabilitas</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="info_medis[]" value="amputasi"
                                            id="amputasi">
                                        <label class="form-check-label" for="amputasi">Amputasi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="info_medis[]"
                                            value="paralisis" id="paralisis">
                                        <label class="form-check-label" for="paralisis">Paralisis</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="info_medis[]"
                                            value="kontraktur" id="kontraktur">
                                        <label class="form-check-label" for="kontraktur">Kontraktur</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="info_medis[]"
                                            value="ulkus_dekubitus" id="ulkus_dekubitus">
                                        <label class="form-check-label" for="ulkus_dekubitus">Ulkus Dekubitus</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="info_medis[]" value="lainnya"
                                            id="lainnya_info_medis"
                                            onchange="toggleOtherInput('lainnya_info_medis', 'info_medis_lainnya_input')">
                                        <label class="form-check-label" for="lainnya_info_medis">Lainnya:</label>
                                        <input type="text" name="info_medis_lainnya" id="info_medis_lainnya_input"
                                            class="form-control form-control-sm mt-1" placeholder="Spesifikasi lainnya"
                                            style="display: none;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Peralatan yang Menyertai Saat Pindah:</label>
                                <div class="checkbox-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="peralatan[]"
                                            value="portable_o2" id="portable_o2"
                                            onchange="toggleOtherInput('portable_o2', 'o2_kebutuhan_input')">
                                        <label class="form-check-label" for="portable_o2">Portable O2</label>
                                        <input type="text" name="o2_kebutuhan" id="o2_kebutuhan_input"
                                            class="form-control form-control-sm mt-1" placeholder="Kebutuhan (l/menit)"
                                            style="display: none;">
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="peralatan[]" value="ngt"
                                            id="ngt">
                                        <label class="form-check-label" for="ngt">NGT</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="peralatan[]"
                                            value="alat_penghisap" id="alat_penghisap">
                                        <label class="form-check-label" for="alat_penghisap">Alat Penghisap</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="peralatan[]"
                                            value="ventilator" id="ventilator">
                                        <label class="form-check-label" for="ventilator">Ventilator</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="peralatan[]" value="bagging"
                                            id="bagging">
                                        <label class="form-check-label" for="bagging">Bagging</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="peralatan[]"
                                            value="kateter_urin" id="kateter_urin">
                                        <label class="form-check-label" for="kateter_urin">Kateter Urin</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="peralatan[]"
                                            value="pompa_infus" id="pompa_infus">
                                        <label class="form-check-label" for="pompa_infus">Pompa Infus</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="peralatan[]" value="lainnya"
                                            id="lainnya_peralatan"
                                            onchange="toggleOtherInput('lainnya_peralatan', 'peralatan_lainnya_input')">
                                        <label class="form-check-label" for="lainnya_peralatan">Lainnya:</label>
                                        <input type="text" name="peralatan_lainnya" id="peralatan_lainnya_input"
                                            class="form-control form-control-sm mt-1" placeholder="Spesifikasi lainnya"
                                            style="display: none;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gangguan dan Inkontinensia -->
                <div class="form-section">
                    <div class="section-header">Gangguan dan Kondisi Khusus</div>
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Gangguan:</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="gangguan[]" value="mental"
                                                id="mental">
                                            <label class="form-check-label" for="mental">Mental</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="gangguan[]"
                                                value="pendengaran" id="pendengaran">
                                            <label class="form-check-label" for="pendengaran">Pendengaran</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="gangguan[]"
                                                value="sensasi" id="sensasi">
                                            <label class="form-check-label" for="sensasi">Sensasi</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="gangguan[]" value="bicara"
                                                id="bicara">
                                            <label class="form-check-label" for="bicara">Bicara</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="gangguan[]"
                                                value="penglihatan" id="penglihatan">
                                            <label class="form-check-label" for="penglihatan">Penglihatan</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="gangguan[]"
                                                value="lainnya" id="lainnya_gangguan"
                                                onchange="toggleOtherInput('lainnya_gangguan', 'gangguan_lainnya_input')">
                                            <label class="form-check-label" for="lainnya_gangguan">Lainnya:</label>
                                            <input type="text" name="gangguan_lainnya" id="gangguan_lainnya_input"
                                                class="form-control form-control-sm mt-1" placeholder="Spesifikasi lainnya"
                                                style="display: none;">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label class="form-label fw-bold">Inkontinensia:</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="inkontinensia[]"
                                                    value="urine" id="urine">
                                                <label class="form-check-label" for="urine">Urine</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="inkontinensia[]"
                                                    value="saliva" id="saliva">
                                                <label class="form-check-label" for="saliva">Saliva</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="inkontinensia[]"
                                                    value="alvi" id="alvi">
                                                <label class="form-check-label" for="alvi">Alvi</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="inkontinensia[]"
                                                    value="lainnya" id="lainnya_inkontinensia"
                                                    onchange="toggleOtherInput('lainnya_inkontinensia', 'inkontinensia_lainnya_input')">
                                                <label class="form-check-label" for="lainnya_inkontinensia">Lainnya:</label>
                                                <input type="text" name="inkontinensia_lainnya"
                                                    id="inkontinensia_lainnya_input"
                                                    class="form-control form-control-sm mt-1"
                                                    placeholder="Spesifikasi lainnya" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label class="form-label fw-bold">Potensi untuk Dilakukan Rehabilitasi:</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rehabilitasi" value="baik"
                                            id="rehab_baik">
                                        <label class="form-check-label" for="rehab_baik">Baik</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rehabilitasi" value="sedang"
                                            id="rehab_sedang">
                                        <label class="form-check-label" for="rehab_sedang">Sedang</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rehabilitasi" value="buruk"
                                            id="rehab_buruk">
                                        <label class="form-check-label" for="rehab_buruk">Buruk</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rehabilitasi" value="lainnya"
                                            id="lainnya_rehabilitasi"
                                            onchange="toggleOtherInputRadio('lainnya_rehabilitasi', 'rehabilitasi_lainnya_input', 'rehabilitasi')">
                                        <label class="form-check-label" for="lainnya_rehabilitasi">Lainnya:</label>
                                        <input type="text" name="rehabilitasi_lainnya" id="rehabilitasi_lainnya_input"
                                            class="form-control form-control-sm mt-1" placeholder="Spesifikasi lainnya"
                                            style="display: none;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mt-3">
                                    <label class="form-label fw-bold">Pendamping saat pasien pindah:</label>
                                    <div class="mb-2">
                                        <label class="form-label">Nama petugas 1:</label>
                                        <select name="petugas1" class="form-select select2">
                                            @foreach ($petugas as $item)
                                                @if ($item->kd_karyawan != auth()->user()->kd_karyawan)
                                                    <option value="">--Pilih DPJP--</option>
                                                    <option value="{{ $item->kd_karyawan }}">
                                                        {{ $item->gelar_depan . ' ' . str()->title($item->nama) . ' ' .
                                                    $item->gelar_belakang }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Nama petugas 2:</label>
                                        <select name="petugas2" class="form-select select2">
                                            @foreach ($petugas as $item)
                                                @if ($item->kd_karyawan != auth()->user()->kd_karyawan)
                                                    <option value="">--Pilih DPJP--</option>
                                                    <option value="{{ $item->kd_karyawan }}">
                                                        {{ $item->gelar_depan . ' ' . str()->title($item->nama) . ' ' .
                                                    $item->gelar_belakang }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Nama petugas 3:</label>
                                        <select name="petugas3" class="form-select select2">
                                            @foreach ($petugas as $item)
                                                @if ($item->kd_karyawan != auth()->user()->kd_karyawan)
                                                    <option value="">--Pilih DPJP--</option>
                                                    <option value="{{ $item->kd_karyawan }}">
                                                        {{ $item->gelar_depan . ' ' . str()->title($item->nama) . ' ' .
                                                    $item->gelar_belakang }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="form-label fw-bold">Pemeriksaan Fisik:</label>
                                    <div class="mb-3">
                                        <label class="form-label">Status generalis (temuan yang signifikan):</label>
                                        <textarea name="status_generalis" class="form-control" rows="3"
                                            placeholder="Tuliskan temuan pemeriksaan fisik generalis yang signifikan"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status lokalis (temuan yang signifikan):</label>
                                        <textarea name="status_lokalis" class="form-control" rows="3"
                                            placeholder="Tuliskan temuan pemeriksaan fisik lokalis yang signifikan"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Kemandirian -->
                <div class="form-section">
                    <div class="section-header">STATUS KEMANDIRIAN</div>
                    <div class="section-content">
                        <p class="text-muted small">(Berikan tanda centang (✓) pada kolom yang sesuai)</p>
                        <div class="table-responsive">
                            <table class="table table-bordered table-status">
                                <thead>
                                    <tr>
                                        <th width="30%"></th>
                                        <th width="23%" class="text-center">Mandiri</th>
                                        <th width="23%" class="text-center">Butuh bantuan</th>
                                        <th width="24%" class="text-center">Tidak dapat melakukan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Aktivitas di tempat tidur</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Berguling</td>
                                        <td class="text-center"><input type="radio" name="berguling" value="mandiri"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="berguling" value="bantuan"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="berguling" value="tidak_bisa"
                                                class="form-check-input"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Duduk</td>
                                        <td class="text-center"><input type="radio" name="duduk" value="mandiri"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="duduk" value="bantuan"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="duduk" value="tidak_bisa"
                                                class="form-check-input"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Higiene pribadi</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Wajah, rambut, tangan</td>
                                        <td class="text-center"><input type="radio" name="higiene_wajah" value="mandiri"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="higiene_wajah" value="bantuan"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="higiene_wajah" value="tidak_bisa"
                                                class="form-check-input"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Tubuh, perineum</td>
                                        <td class="text-center"><input type="radio" name="higiene_tubuh" value="mandiri"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="higiene_tubuh" value="bantuan"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="higiene_tubuh" value="tidak_bisa"
                                                class="form-check-input"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Ekstremitas bawah</td>
                                        <td class="text-center"><input type="radio" name="higiene_ekstremitas_bawah"
                                                value="mandiri" class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="higiene_ekstremitas_bawah"
                                                value="bantuan" class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="higiene_ekstremitas_bawah"
                                                value="tidak_bisa" class="form-check-input"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Berpakaian</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Traktus digestivus</td>
                                        <td class="text-center"><input type="radio" name="traktus_digestivus"
                                                value="mandiri" class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="traktus_digestivus"
                                                value="bantuan" class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="traktus_digestivus"
                                                value="tidak_bisa" class="form-check-input"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Traktus urinarius</td>
                                        <td class="text-center"><input type="radio" name="traktus_urinarius" value="mandiri"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="traktus_urinarius" value="bantuan"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="traktus_urinarius"
                                                value="tidak_bisa" class="form-check-input"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Ekstremitas atas</td>
                                        <td class="text-center"><input type="radio" name="pakaian_atas" value="mandiri"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="pakaian_atas" value="bantuan"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="pakaian_atas" value="tidak_bisa"
                                                class="form-check-input"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Batang tubuh</td>
                                        <td class="text-center"><input type="radio" name="pakaian_tubuh" value="mandiri"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="pakaian_tubuh" value="bantuan"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="pakaian_tubuh" value="tidak_bisa"
                                                class="form-check-input"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Ekstremitas bawah</td>
                                        <td class="text-center"><input type="radio" name="pakaian_bawah" value="mandiri"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="pakaian_bawah" value="bantuan"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="pakaian_bawah" value="tidak_bisa"
                                                class="form-check-input"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Makan</strong></td>
                                        <td class="text-center"><input type="radio" name="makan" value="mandiri"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="makan" value="bantuan"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="makan" value="tidak_bisa"
                                                class="form-check-input"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Pergerakan</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Jalan kaki</td>
                                        <td class="text-center"><input type="radio" name="jalan_kaki" value="mandiri"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="jalan_kaki" value="bantuan"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="jalan_kaki" value="tidak_bisa"
                                                class="form-check-input"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Kursi roda</td>
                                        <td class="text-center"><input type="radio" name="kursi_roda" value="mandiri"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="kursi_roda" value="bantuan"
                                                class="form-check-input"></td>
                                        <td class="text-center"><input type="radio" name="kursi_roda" value="tidak_bisa"
                                                class="form-check-input"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <div class="mb-3">
                                <label class="form-label">Pemeriksaan penunjang diagnostik yang sudah dilakukan (EKG, Lab,
                                    dll):</label>
                                <textarea name="pemeriksaan_penunjang" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Intervensi/ tindakan yang sudah dilakukan:</label>
                                <textarea name="intervensi" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Diet:</label>
                                <textarea name="diet" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rencana perawatan selanjutnya:</label>
                                <textarea name="rencana_perawatan" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terapi Saat Pindah Section -->
                <div class="form-section">
                    <div class="card-header">
                        <h5 class="mb-0">TERAPI SAAT PINDAH</h5>
                    </div>
                    <div class="card-body">
                        <!-- Button Tambah Terapi -->
                        <div class="mb-3">
                            <button type="button" class="btn btn-success btn-sm" onclick="bukaModal()">
                                + Tambah Terapi Obat
                            </button>
                        </div>

                        <!-- Tabel Display Terapi -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th>Jumlah</th>
                                        <th>Dosis</th>
                                        <th>Frekuensi</th>
                                        <th>Cara Pemberian</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tabelData">
                                    <tr id="barisKosong">
                                        <td colspan="6" class="text-center text-muted py-4">
                                            Belum ada data terapi obat
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal Form -->
                <div class="modal fade" id="modalForm" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="judulModal">Tambah Terapi Obat</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Obat</label>
                                        <input type="text" class="form-control" id="namaObat"
                                            placeholder="Masukkan nama obat">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Jumlah</label>
                                        <input type="text" class="form-control" id="jumlah" placeholder="Contoh: 10 tablet">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Dosis</label>
                                        <input type="text" class="form-control" id="dosis" placeholder="Contoh: 500 mg">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Frekuensi</label>
                                        <input type="text" class="form-control" id="frekuensi" placeholder="Contoh: 3x sehari">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Cara Pemberian</label>
                                    <select class="form-select" id="cara">
                                        <option value="">-- Pilih Cara Pemberian --</option>
                                        <option value="Oral">Oral (diminum)</option>
                                        <option value="IV">IV (Intravena)</option>
                                        <option value="IM">IM (Intramuskular)</option>
                                        <option value="SC">SC (Subkutan)</option>
                                        <option value="Topikal">Topikal (oles)</option>
                                        <option value="Inhalasi">Inhalasi (hirup)</option>
                                        <option value="Rektal">Rektal (dubur)</option>
                                        <option value="Sublingual">Sublingual (bawah lidah)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary" onclick="simpanData()">
                                    <span id="textSimpan">Simpan</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Hapus -->
                <div class="modal fade" id="modalHapus" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <h6>Hapus data terapi ini?</h6>
                                <p><strong id="namaHapus"></strong></p>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-danger" onclick="konfirmasiHapus()">Ya, Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Petugas pendamping -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="derajat_pasien" class="form-label">Derajat Pasien </label>
                            <select name="derajat_pasien" id="derajat_pasien" class="form-select" required>
                                <option value="">--Pilih--</option>
                                <option value="Derajat 1">Derajat 1 - Transporter - Perawat</option>
                                <option value="Derajat 2">Derajat 1 - Transporter - Perawat - Dokter</option>
                                <option value="Derajat 3">Derajat 1 - Transporter - Perawat - Dokter yang kompeten</option>
                                <option value="Derajat 4">Derajat 1 - Transporter - Perawat - Dokter yang kompeten menangani pasien
                                    kritis dan berpengalaman minimal 6 bulan bekerja di IGD/ ICU</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="reset" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Form Transfer</button>
                </div>
            </form>
        </div>
    </div>
    @include('unit-pelayanan.rawat-inap.pelayanan.transfer-pasien-antar-ruang.modal-create-alergi')
@endsection

@push('js')
    <script>
        @cannot('is-admin')
        $('#petugas_menyerahkan').on('mousedown focusin touchstart', function (e) {
            e.preventDefault();
        });
        @endcannot

        // Persetujuan dan Alasan Pemindahan
        document.addEventListener('DOMContentLoaded', function () {
            const setujuYa = document.getElementById('setuju_ya');
            const setujuTidak = document.getElementById('setuju_tidak');
            const namaKeluarga = document.querySelector('input[name="nama_keluarga"]');
            const hubunganKeluarga = document.querySelector('input[name="hubungan_keluarga"]');
            const keluargaSection = document.querySelector('.mb-3 .row');

            // Initially hide the family input section
            keluargaSection.style.display = 'none';

            // Enable/disable inputs based on radio button selection
            function toggleInputs() {
                if (setujuYa.checked) {
                    keluargaSection.style.display = 'block';
                    namaKeluarga.disabled = false;
                    hubunganKeluarga.disabled = false;
                } else {
                    keluargaSection.style.display = 'none';
                    namaKeluarga.disabled = true;
                    hubunganKeluarga.disabled = true;
                    // Clear inputs when hidden
                    namaKeluarga.value = '';
                    hubunganKeluarga.value = '';
                }
            }

            // Add event listeners to radio buttons
            setujuYa.addEventListener('change', toggleInputs);
            setujuTidak.addEventListener('change', toggleInputs);

            // Run on page load to set initial state
            toggleInputs();
        });

        // Informasi Medis dan Peralatan yang Menyertai Saat Pindah
        function toggleOtherInput(checkboxId, inputId) {
            const checkbox = document.getElementById(checkboxId);
            const input = document.getElementById(inputId);

            if (checkbox.checked) {
                input.style.display = 'block';
                input.focus();
            } else {
                input.style.display = 'none';
                input.value = '';
            }
        }

        // Gangguan dan Kondisi Khusus
        function toggleOtherInput(checkboxId, inputId) {
            const checkbox = document.getElementById(checkboxId);
            const input = document.getElementById(inputId);

            if (checkbox.checked) {
                input.style.display = 'block';
                input.focus();
            } else {
                input.style.display = 'none';
                input.value = '';
            }
        }

        function toggleOtherInputRadio(radioId, inputId, radioName) {
            const radio = document.getElementById(radioId);
            const input = document.getElementById(inputId);
            const allRadios = document.querySelectorAll(`input[name="${radioName}"]`);

            // Hide all related inputs first
            allRadios.forEach(r => {
                if (r.id !== radioId) {
                    const relatedInput = document.getElementById(r.id.replace(r.id.split('_')[1], 'lainnya_input'));
                    if (relatedInput && relatedInput.id.includes('lainnya')) {
                        relatedInput.style.display = 'none';
                        relatedInput.value = '';
                    }
                }
            });

            if (radio.checked) {
                input.style.display = 'block';
                input.focus();
            } else {
                input.style.display = 'none';
                input.value = '';
            }
        }

        // Add event listeners for radio buttons to hide "lainnya" input when other options are selected
        document.addEventListener('DOMContentLoaded', function () {
            const rehabilitasiRadios = document.querySelectorAll('input[name="rehabilitasi"]');
            rehabilitasiRadios.forEach(radio => {
                if (radio.id !== 'lainnya_rehabilitasi') {
                    radio.addEventListener('change', function () {
                        if (this.checked) {
                            const lainnyaInput = document.getElementById('rehabilitasi_lainnya_input');
                            lainnyaInput.style.display = 'none';
                            lainnyaInput.value = '';
                        }
                    });
                }
            });
        });

        // TERAPI SAAT PINDAH
        var dataObat = [];
        var indexEdit = -1;
        var indexHapus = -1;

        // Fungsi buka modal
        function bukaModal() {
            console.log('Buka modal tambah');
            document.getElementById('judulModal').textContent = 'Tambah Terapi Obat';
            document.getElementById('textSimpan').textContent = 'Simpan';
            kosongkanForm();
            indexEdit = -1;

            var modal = new bootstrap.Modal(document.getElementById('modalForm'));
            modal.show();
        }

        // Fungsi kosongkan form
        function kosongkanForm() {
            document.getElementById('namaObat').value = '';
            document.getElementById('jumlah').value = '';
            document.getElementById('dosis').value = '';
            document.getElementById('frekuensi').value = '';
            document.getElementById('cara').value = '';
        }

        // Fungsi simpan data - SANGAT SEDERHANA
        function simpanData() {
            console.log('=== MULAI SIMPAN ===');

            // Ambil nilai langsung - TANPA VALIDASI RUMIT
            var nama = document.getElementById('namaObat').value || '';
            var jml = document.getElementById('jumlah').value || '';
            var dos = document.getElementById('dosis').value || '';
            var frek = document.getElementById('frekuensi').value || '';
            var caraPemberian = document.getElementById('cara').value || '';

            console.log('Data input:', { nama, jml, dos, frek, caraPemberian });

            // Buat object data
            var objData = {
                namaObat: nama,
                jumlah: jml,
                dosis: dos,
                frekuensi: frek,
                cara: caraPemberian
            };

            console.log('Object data:', objData);

            // Simpan ke array
            if (indexEdit >= 0) {
                dataObat[indexEdit] = objData;
                indexEdit = -1;
                console.log('Data diupdate');
            } else {
                dataObat.push(objData);
                console.log('Data ditambah');
            }

            console.log('Total data:', dataObat.length);
            console.log('Array data:', dataObat);

            // Refresh tabel
            tampilkanTabel();

            // Tutup modal
            var modal = bootstrap.Modal.getInstance(document.getElementById('modalForm'));
            if (modal) {
                modal.hide();
            }

            alert('Data berhasil disimpan!');
            console.log('=== SELESAI SIMPAN ===');
        }

        // Fungsi tampilkan tabel - SANGAT SEDERHANA
        function tampilkanTabel() {
            console.log('=== MULAI TAMPIL TABEL ===');
            console.log('Data yang akan ditampilkan:', dataObat);

            var tbody = document.getElementById('tabelData');
            var barisKosong = document.getElementById('barisKosong');

            // Hapus semua baris kecuali baris kosong
            var rows = tbody.querySelectorAll('tr:not(#barisKosong)');
            rows.forEach(function (row) {
                row.remove();
            });

            // Jika ada data
            if (dataObat.length > 0) {
                barisKosong.style.display = 'none';

                dataObat.forEach(function (item, index) {
                    var baris = document.createElement('tr');
                    baris.innerHTML = `
                            <td><strong>${item.namaObat || '-'}</strong></td>
                            <td>${item.jumlah || '-'}</td>
                            <td>${item.dosis || '-'}</td>
                            <td>${item.frekuensi || '-'}</td>
                            <td><span class="badge bg-info">${item.cara || '-'}</span></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm me-1" onclick="editData(${index})">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="hapusData(${index})">
                                    Hapus
                                </button>
                            </td>
                        `;
                    tbody.appendChild(baris);
                });
            } else {
                barisKosong.style.display = '';
            }

            console.log('=== SELESAI TAMPIL TABEL ===');
        }

        // Fungsi edit data
        function editData(index) {
            console.log('Edit data index:', index);

            var item = dataObat[index];
            if (!item) return;

            indexEdit = index;

            // Isi form
            document.getElementById('namaObat').value = item.namaObat || '';
            document.getElementById('jumlah').value = item.jumlah || '';
            document.getElementById('dosis').value = item.dosis || '';
            document.getElementById('frekuensi').value = item.frekuensi || '';
            document.getElementById('cara').value = item.cara || '';

            // Ubah judul
            document.getElementById('judulModal').textContent = 'Edit Terapi Obat';
            document.getElementById('textSimpan').textContent = 'Update';

            // Buka modal
            var modal = new bootstrap.Modal(document.getElementById('modalForm'));
            modal.show();
        }

        // Fungsi hapus data
        function hapusData(index) {
            console.log('Hapus data index:', index);

            var item = dataObat[index];
            if (!item) return;

            indexHapus = index;
            document.getElementById('namaHapus').textContent = item.namaObat || 'Data ini';

            var modal = new bootstrap.Modal(document.getElementById('modalHapus'));
            modal.show();
        }

        // Fungsi konfirmasi hapus
        function konfirmasiHapus() {
            console.log('Konfirmasi hapus index:', indexHapus);

            if (indexHapus >= 0) {
                dataObat.splice(indexHapus, 1);
                indexHapus = -1;

                tampilkanTabel();

                var modal = bootstrap.Modal.getInstance(document.getElementById('modalHapus'));
                if (modal) {
                    modal.hide();
                }

                alert('Data berhasil dihapus!');
            }
        }

        // Inisialisasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Halaman dimuat, inisialisasi...');

            // Tampilkan tabel kosong
            tampilkanTabel();

            console.log('Inisialisasi selesai');
        });

        // Test function untuk debugging
        function testData() {
            dataObat = [
                { namaObat: 'Paracetamol', jumlah: '10 tablet', dosis: '500mg', frekuensi: '3x sehari', cara: 'Oral' },
                { namaObat: 'Amoxicillin', jumlah: '21 kapsul', dosis: '250mg', frekuensi: '3x sehari', cara: 'Oral' }
            ];
            tampilkanTabel();
        }


        // bagain Yang Menyerahkan
        $(document).ready(function() {
            // Event listener untuk perubahan unit tujuan
            $('#kd_unit_tujuan').change(function(e) {
                let $this = $(this);
                let kdUnit = $this.val();

                // Reset kamar dan sisa bed
                $('#no_kamar').html('<option value="">--Pilih Kamar--</option>').trigger('change');
                $('#sisa_bed').val('0');

                if (!kdUnit) {
                    $('#no_kamar').next('.form-text').text('Pilih unit tujuan terlebih dahulu');
                    return;
                }

                // Show loading
                $('#loading-indicator').show();
                $('#no_kamar').html('<option value="">Loading...</option>').prop('disabled', true);

                $.ajax({
                    type: "POST",
                    url: "{{ route('rawat-inap.transfer-pasien-antar-ruang.get-kamar-ruang-ajax', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kd_unit: kdUnit
                    },
                    dataType: "json",
                    success: function(res) {
                        $('#loading-indicator').hide();
                        $('#no_kamar').prop('disabled', false);

                        if (res.status == 'error') {
                            $('#no_kamar').html('<option value="">--Pilih Kamar--</option>');
                            $('#no_kamar').next('.form-text').text('Error: ' + res.message).addClass('text-danger');

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message
                            });
                            return;
                        }

                        $('#no_kamar').html(res.data);

                        if (res.count > 0) {
                            $('#no_kamar').next('.form-text').text('Tersedia ' + res.count + ' kamar').removeClass('text-danger').addClass('text-success');
                        } else {
                            $('#no_kamar').next('.form-text').text('Tidak ada kamar tersedia').removeClass('text-success').addClass('text-warning');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#loading-indicator').hide();
                        $('#no_kamar').prop('disabled', false);
                        $('#no_kamar').html('<option value="">--Pilih Kamar--</option>');
                        $('#no_kamar').next('.form-text').text('Kamar gagal dimuat').addClass('text-danger');

                        console.error('AJAX Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Kamar gagal dimuat. Silakan coba lagi.'
                        });
                    }
                });
            });


            // Initialize select2 jika ada
            if ($.fn.select2) {
                $('#kd_unit_tujuan').select2({
                    placeholder: '--Pilih--',
                    allowClear: true
                });

                $('#no_kamar').select2({
                    placeholder: '--Pilih Kamar--',
                    allowClear: true
                });
            }
        });
    </script>
@endpush
