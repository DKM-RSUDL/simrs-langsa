@extends('layouts.administrator.master')

@push('css')
    <style>
        /* Minimal custom styling */
        .checklist-card {
            transition: background-color 0.2s;
        }

        .checklist-card:hover {
            background-color: #f9f9f9;
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-3">
        <div class="row g-3">
            <!-- Patient Info Card -->
            <div class="col-md-3">
                @include('components.patient-card')
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Tambah Checklist Keselamatan (Time Out)</h5>
                            <a href="{{ route('operasi.pelayanan.ceklist-keselamatan.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                class="btn btn-outline-primary btn-sm">
                                <i class="ti-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <div class="card-body bg-light">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" id="timeOutForm"
                            action="{{ route('operasi.pelayanan.ceklist-keselamatan.store-timeout', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- Two cards in a row: Medical Staff & Date/Time -->
                            <div class="row g-3 mb-3 mt-2">
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-white">
                                            <h6 class="mb-0">Informasi Tim Medis</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Ahli Bedah</label>
                                                <select class="form-select" name="ahli_bedah" required>
                                                    <option value="" disabled selected>Pilih Ahli Bedah</option>
                                                    @foreach ($dokter as $d)
                                                        <option value="{{ $d->kd_dokter }}">{{ $d->nama_lengkap }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Dokter Anestesi</label>
                                                <select class="form-select" name="dokter_anastesi" required>
                                                    <option value="" disabled selected>Pilih Dokter Anestesi</option>
                                                    @foreach ($dokterAnastesi as $dokter)
                                                        <option value="{{ $dokter->kd_dokter }}">{{ $dokter->dokter->nama_lengkap }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="form-label">Perawat</label>
                                                <select class="form-select" name="perawat" required>
                                                    <option value="" disabled selected>Pilih Perawat</option>
                                                    @foreach ($perawat as $p)
                                                        <option value="{{ $p->kd_perawat }}">{{ $p->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-white">
                                            <h6 class="mb-0">Waktu Time Out</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Time Out</label>
                                                <input type="date" class="form-control" name="tgl_timeout"
                                                    value="{{ date('Y-m-d') }}" required>
                                            </div>
                                            <div>
                                                <label class="form-label">Jam Time Out</label>
                                                <input type="time" class="form-control" name="jam_timeout"
                                                    value="{{ date('H:i') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Checklist Section -->
                            <div class="card mb-3">
                                <div class="card-header bg-white">
                                    <h6 class="mb-0">Checklist Keselamatan Pasien</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Section 1 -->
                                    <div class="card mb-3 checklist-card">
                                        <div class="card-header bg-light py-2">
                                            <strong>1. Konfirmasi seluruh anggota tim telah memperkenalkan nama dan peran</strong>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    name="konfirmasi_tim" value="1" id="konfirmasiTimYa"
                                                    required>
                                                <label class="form-check-label"
                                                    for="konfirmasiTimYa">Ya</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    name="konfirmasi_tim" value="0"
                                                    id="konfirmasiTimTidak">
                                                <label class="form-check-label"
                                                    for="konfirmasiTimTidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section 2 -->
                                    <div class="card mb-3 checklist-card">
                                        <div class="card-header bg-light py-2">
                                            <strong>2. Dokter bedah, dokter anestesi dan Perawat melakukan konfirmasi secara Verbal</strong>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td width="60%">a. Nama pasien</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="konfirmasi_nama" value="1" id="konfirmasiNamaYa"
                                                                    required>
                                                                <label class="form-check-label"
                                                                    for="konfirmasiNamaYa">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="konfirmasi_nama" value="0"
                                                                    id="konfirmasiNamaTidak">
                                                                <label class="form-check-label"
                                                                    for="konfirmasiNamaTidak">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>b. Prosedur</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="konfirmasi_prosedur" value="1" id="konfirmasiProsedurYa" required>
                                                                <label class="form-check-label" for="konfirmasiProsedurYa">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="konfirmasi_prosedur" value="0" id="konfirmasiProsedurTidak">
                                                                <label class="form-check-label"
                                                                    for="konfirmasiProsedurTidak">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>c. Lokasi dimana insisi akan dibuat/posisi</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="konfirmasi_lokasi" value="1" id="konfirmasiLokasiYa" required>
                                                                <label class="form-check-label" for="konfirmasiLokasiYa">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="konfirmasi_lokasi" value="0" id="konfirmasiLokasiTidak">
                                                                <label class="form-check-label"
                                                                    for="konfirmasiLokasiTidak">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Section 3 -->
                                    <div class="card mb-3 checklist-card">
                                        <div class="card-header bg-light py-2">
                                            <strong>3. Apakah antibiotik profilaksis sudah diberikan sebelumnya?</strong>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="antibiotik_profilaksis" value="1" id="antibiotikYa"
                                                        required>
                                                    <label class="form-check-label"
                                                        for="antibiotikYa">Ya</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="antibiotik_profilaksis" value="0"
                                                        id="antibiotikTidak">
                                                    <label class="form-check-label"
                                                        for="antibiotikTidak">Tidak</label>
                                                </div>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">a. Nama antibiotik yang diberikan</label>
                                                    <input type="text" class="form-control" name="nama_antibiotik">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">b. Dosis antibiotik yang diberikan</label>
                                                    <input type="text" class="form-control" name="dosis_antibiotik">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Section 4 -->
                                    <div class="card mb-3 checklist-card">
                                        <div class="card-header bg-light py-2">
                                            <strong>4. Antisipasi Kejadian Kritis</strong>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">a. Review dokter bedah: langkah apa yang akan dilakukan bila kondisi kritis atau kejadian yang tidak diharapkan lamanya operasi, antisipasi kehilangan darah?</label>
                                                <textarea class="form-control" name="review_bedah" rows="3"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">b. Review tim anastesi: apakah ada hal khusus yang perlu diperhatikan pada pasien?</label>
                                                <textarea class="form-control" name="review_anastesi" rows="3"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">c. Review tim perawat: apakah peralatan sudah steril, adakah alat-alat yang perlu diperhatikan khusus atau dalam masalah?</label>
                                                <textarea class="form-control" name="review_perawat" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Section 5 -->
                                    <div class="card mb-3 checklist-card">
                                        <div class="card-header bg-light py-2">
                                            <strong>5. Apakah foto rontgen/CT-Scan dan MRI telah ditayangkan?</strong>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    name="foto_rontgen" value="1" id="fotoRontgenYa"
                                                    required>
                                                <label class="form-check-label"
                                                    for="fotoRontgenYa">Ya</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    name="foto_rontgen" value="0"
                                                    id="fotoRontgenTidak">
                                                <label class="form-check-label"
                                                    for="fotoRontgenTidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Tanda Tangan Tim -->
                                    <div class="card mb-3">
                                        <div class="card-header bg-white">
                                            <h6 class="mb-0">Tanda Tangan Tim</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="text-muted mb-3">Catatan: Tanda tangan akan ditambahkan secara digital saat menyimpan form.</p>
                                            
                                            <table class="table table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="30%">Tim</th>
                                                        <th width="40%">Nama</th>
                                                        <th width="30%">Tanda tangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Ahli Bedah</td>
                                                        <td>
                                                            <span class="text-muted">Diisi otomatis saat disimpan</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">Digital</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ahli Anestesi</td>
                                                        <td>
                                                            <span class="text-muted">Diisi otomatis saat disimpan</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">Digital</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Perawat</td>
                                                        <td>
                                                            <span class="text-muted">Diisi otomatis saat disimpan</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">Digital</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Form Actions -->
                                <div class="d-flex justify-content-between p-4">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="ti-save me-1"></i> Simpan Checklist
                                    </button>
                                    <a href="{{ route('operasi.pelayanan.ceklist-keselamatan.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                        class="btn btn-outline-secondary">
                                        <i class="ti-arrow-left me-1"></i> Batal
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;">
        <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border-radius:5px; text-align:center;">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 mb-0">Sedang menyimpan data...</p>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Loading effect when submitting form
        document.getElementById('timeOutForm').addEventListener('submit', function(e) {
            if (confirm('Apakah data checklist sudah benar?')) {
                // Show loading overlay
                document.getElementById('loadingOverlay').style.display = 'block';
                
                // Disable submit button and update text
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="ti-reload me-1"></i> Menyimpan...';
            } else {
                e.preventDefault();
            }
        });
    </script>
@endpush
