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
        
        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6;
        }
        
        textarea.form-control {
            min-height: 100px;
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
                            <h5 class="mb-0">Tambah Checklist Keselamatan (Sign Out)</h5>
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

                        <form method="POST" id="signOutForm"
                            action="{{ route('operasi.pelayanan.ceklist-keselamatan.store-signout', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
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
                                            <h6 class="mb-0">Waktu Sign Out</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Sign Out</label>
                                                <input type="date" class="form-control" name="tgl_signout"
                                                    value="{{ date('Y-m-d') }}" required>
                                            </div>
                                            <div>
                                                <label class="form-label">Jam Sign Out</label>
                                                <input type="time" class="form-control" name="jam_signout"
                                                    value="{{ date('H:i') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Checklist Section -->
                            <div class="card mb-3">
                                <div class="card-header bg-white">
                                    <h6 class="mb-0">Checklist Keselamatan Pasien (Sign Out)</h6>
                                    <small class="text-muted">Diisi oleh Perawat, Dokter Anastesi dan Operator Sebelum Tutup Luka Operasi</small>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="5%">NO</th>
                                                    <th width="65%">KETERANGAN</th>
                                                    <th width="15%">YA</th>
                                                    <th width="15%">TIDAK</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Item 1 -->
                                                <tr>
                                                    <td class="text-center">1</td>
                                                    <td>
                                                        <strong>Perawat melakukan konfirmasi secara verbal dengan tim:</strong>
                                                    </td>
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>a. Nama prosedur tindakan telah dicatat</td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input" type="radio" name="konfirmasi_prosedur" value="1" id="konfirmasiProsedurYa" required>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input" type="radio" name="konfirmasi_prosedur" value="0" id="konfirmasiProsedurTidak">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>b. Instrument, sponge, dan jarum telah dihitung dengan benar</td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input" type="radio" name="konfirmasi_instrumen" value="1" id="konfirmasiInstrumenYa" required>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input" type="radio" name="konfirmasi_instrumen" value="0" id="konfirmasiInstrumenTidak">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>c. Spesimen telah diberi label (termasuk nama pasien dan asal jaringan specimen)</td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input" type="radio" name="konfirmasi_spesimen" value="1" id="konfirmasiSpesimenYa" required>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input" type="radio" name="konfirmasi_spesimen" value="0" id="konfirmasiSpesimenTidak">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>d. Adakah masalah dengan peralatan selama operasi?</td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input" type="radio" name="masalah_peralatan" value="1" id="masalahPeralatanYa" required>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input" type="radio" name="masalah_peralatan" value="0" id="masalahPeralatanTidak">
                                                        </div>
                                                    </td>
                                                </tr>
                                                
                                                <!-- Item 2 -->
                                                <tr>
                                                    <td class="text-center">2</td>
                                                    <td>
                                                        <strong>Dokter bedah, dokter Anastesi, dan perawat melakukan review masalah utama apa yang harus diperhatikan untuk penyembuhan dan manajemen pasien selanjutnya.</strong>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input" type="radio" name="review_tim" value="1" id="reviewTimYa" required>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input class="form-check-input" type="radio" name="review_tim" value="0" id="reviewTimTidak">
                                                        </div>
                                                    </td>
                                                </tr>
                                                
                                                <!-- Item 3 -->
                                                <tr>
                                                    <td class="text-center">3</td>
                                                    <td>
                                                        <strong>Hal-hal yang harus diperhatikan:</strong>
                                                    </td>
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <textarea class="form-control" name="catatan_penting" rows="4" placeholder="Tuliskan hal-hal yang harus diperhatikan..."></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <!-- Tanda Tangan Tim -->
                                    <div class="card mt-4">
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
        document.getElementById('signOutForm').addEventListener('submit', function(e) {
            if (confirm('Apakah data checklist sudah benar?')) {
                // Show loading overlay
                document.getElementById('loadingOverlay').style.display = 'block';
                
                // Disable submit button
                document.getElementById('submitBtn').disabled = true;
                document.getElementById('submitBtn').innerHTML = '<i class="ti-reload me-1"></i> Menyimpan...';
            } else {
                e.preventDefault();
            }
        });
    </script>
@endpush