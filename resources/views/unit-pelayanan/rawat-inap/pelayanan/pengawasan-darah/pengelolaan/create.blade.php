@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .card-header {
                font-weight: bold;
            }

            .form-label {
                font-weight: 600;
                margin-bottom: 0.3rem;
            }

            .required::after {
                content: '*';
                color: red;
                margin-left: 0.2rem;
            }

            .verification-item {
                border: 1px solid #e3e6f0;
                border-radius: 6px;
                padding: 15px;
                margin-bottom: 12px;
                background-color: #fff;
            }

            .verification-label {
                font-weight: 500;
                margin-bottom: 8px;
                color: #5a5c69;
                font-size: 14px;
            }

            .radio-group {
                display: flex;
                gap: 25px;
            }

            .radio-item {
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .radio-item input[type="radio"] {
                width: 18px;
                height: 18px;
                margin: 0;
            }

            .radio-item label {
                margin: 0;
                font-size: 14px;
                cursor: pointer;
            }

            /* Select2 Custom Styling */
            .select2-container--default .select2-selection--single {
                height: 38px;
                border: 1px solid #ced4da;
                border-radius: 4px;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: #495057;
                line-height: 36px;
                padding-left: 12px;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 36px;
                right: 10px;
            }

            .select2-dropdown {
                border: 1px solid #ced4da;
                border-radius: 4px;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Tambah Data Pengelolaan Pengawasan Darah</h5>
            </div>

            <hr>

            <div class="form-section">
                <form
                    action="{{ route('rawat-inap.pengawasan-darah.pengelolaan.store', [
                        'kd_unit' => $dataMedis->kd_unit,
                        'kd_pasien' => $dataMedis->kd_pasien,
                        'tgl_masuk' => date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                        'urut_masuk' => $dataMedis->urut_masuk,
                    ]) }}"
                    method="post" id="pengelolaanForm">
                    @csrf

                    <!-- Informasi Dasar -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Informasi Dasar</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label required">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal" 
                                               value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label required">Jam</label>
                                        <input type="time" class="form-control" name="jam" 
                                               value="{{ date('H:i') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label required">Transfusi Ke</label>
                                        <input type="number" class="form-control" name="transfusi_ke" 
                                               placeholder="Masukkan urutan transfusi" min="1" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label required">Nomor Seri Kantong Darah</label>
                                        <input type="text" class="form-control" name="nomor_seri_kantong" 
                                               placeholder="Masukkan nomor seri" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Verifikasi Keamanan Darah -->
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0"><i class="bi bi-shield-check me-2"></i>Verifikasi Keamanan Darah</h6>
                        </div>
                        <div class="card-body">

                            <!-- Riwayat Komponen Darah -->
                            <div class="verification-item">
                                <div class="verification-label">
                                    1. Riwayat Alergi Transufusi Darah sebelumnya
                                </div>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input type="radio" name="riwayat_alergi_sebelumnya" value="1" id="riwayat_ya" required>
                                        <label for="riwayat_ya" class="text-success">Ya</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" name="riwayat_alergi_sebelumnya" value="0" id="riwayat_tidak" required>
                                        <label for="riwayat_tidak" class="text-danger">Tidak</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Riwayat Komponen Darah -->
                            <div class="verification-item">
                                <div class="verification-label">
                                    2. Komponen darah sesuai instruksi dokter
                                </div>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input type="radio" name="riwayat_komponen_sesuai" value="1" id="komponen_ya" required>
                                        <label for="komponen_ya" class="text-success">Ya</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" name="riwayat_komponen_sesuai" value="0" id="komponen_tidak" required>
                                        <label for="komponen_tidak" class="text-danger">Tidak</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Identitas Label Darah -->
                            <div class="verification-item">
                                <div class="verification-label">
                                    3. Identitas label darah sesuai dengan barcode
                                </div>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input type="radio" name="identitas_label_sesuai" value="1" id="label_ya" required>
                                        <label for="label_ya" class="text-success">Ya</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" name="identitas_label_sesuai" value="0" id="label_tidak" required>
                                        <label for="label_tidak" class="text-danger">Tidak</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Golongan Darah Pasien -->
                            <div class="verification-item">
                                <div class="verification-label">
                                    4. Golongan darah pasien sesuai dengan produk darah yang tersedia
                                </div>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input type="radio" name="golongan_darah_sesuai" value="1" id="golongan_ya" required>
                                        <label for="golongan_ya" class="text-success">Ya</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" name="golongan_darah_sesuai" value="0" id="golongan_tidak" required>
                                        <label for="golongan_tidak" class="text-danger">Tidak</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Volume Darah -->
                            <div class="verification-item">
                                <div class="verification-label">
                                    5. Volume darah sesuai dengan instruksi
                                </div>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input type="radio" name="volume_sesuai" value="1" id="volume_ya" required>
                                        <label for="volume_ya" class="text-success">Ya</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" name="volume_sesuai" value="0" id="volume_tidak" required>
                                        <label for="volume_tidak" class="text-danger">Tidak</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Kantong Darah Utuh -->
                            <div class="verification-item">
                                <div class="verification-label">
                                    6. Kantong darah utuh (tidak bocor)
                                </div>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input type="radio" name="kantong_utuh" value="1" id="kantong_ya" required>
                                        <label for="kantong_ya" class="text-success">Ya</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" name="kantong_utuh" value="0" id="kantong_tidak" required>
                                        <label for="kantong_tidak" class="text-danger">Tidak</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Darah Tidak Expired -->
                            <div class="verification-item">
                                <div class="verification-label">
                                    7. Darah tidak expired
                                </div>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input type="radio" name="tidak_expired" value="1" id="expired_ya" required>
                                        <label for="expired_ya" class="text-success">Ya</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" name="tidak_expired" value="0" id="expired_tidak" required>
                                        <label for="expired_tidak" class="text-danger">Tidak</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Petugas -->
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="bi bi-people me-2"></i>Petugas Verifikasi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Petugas 1</label>
                                        <select name="petugas_1" class="form-select select2" required>
                                            <option value="">--Pilih--</option>
                                            @foreach ($perawat as $prwt)
                                            <option value="{{ $prwt->kd_karyawan }}">
                                                {{ "$prwt->gelar_depan $prwt->nama $prwt->gelar_belakang" }}
                                            </option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Petugas 2</label>
                                        <select name="petugas_2" class="form-select select2" required>
                                            <option value="">--Pilih--</option>
                                            @foreach ($perawat as $prwt)
                                                <option value="{{ $prwt->kd_karyawan }}">
                                                    {{ "$prwt->gelar_depan $prwt->nama $prwt->gelar_belakang" }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Button Actions -->
                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan Data Pengelolaan
                            </button>
                            <a href="{{ route('rawat-inap.pengawasan-darah.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}?tab=pengelolaan"
                                class="btn btn-secondary ms-2">
                                <i class="ti-arrow-left"></i> Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Select2
            $('.select2-petugas').select2({
                placeholder: 'Pilih Petugas',
                allowClear: true,
                width: '100%'
            });

            // Validasi form sebelum submit
            document.getElementById('pengelolaanForm').addEventListener('submit', function(e) {
                const requiredRadios = [
                    'riwayat_komponen_sesuai',
                    'identitas_label_sesuai', 
                    'golongan_darah_sesuai',
                    'volume_sesuai',
                    'kantong_utuh',
                    'tidak_expired'
                ];

                let allValid = true;
                requiredRadios.forEach(name => {
                    if (!document.querySelector(`input[name="${name}"]:checked`)) {
                        allValid = false;
                    }
                });

                if (!allValid) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Validasi Gagal',
                        text: 'Mohon lengkapi semua verifikasi keamanan darah',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validasi petugas tidak boleh sama
                const petugas1 = document.querySelector('select[name="petugas_1"]').value;
                const petugas2 = document.querySelector('select[name="petugas_2"]').value;

                if (petugas1 && petugas2 && petugas1 === petugas2) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Peringatan',
                        text: 'Petugas 1 dan Petugas 2 tidak boleh sama',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
            });

            // Prevent same petugas selection on change
            $('.select2-petugas').on('change', function() {
                const petugas1 = $('select[name="petugas_1"]').val();
                const petugas2 = $('select[name="petugas_2"]').val();

                if (petugas1 && petugas2 && petugas1 === petugas2) {
                    Swal.fire({
                        title: 'Peringatan',
                        text: 'Petugas 1 dan Petugas 2 tidak boleh sama',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Reset yang baru dipilih
                        $(this).val('').trigger('change');
                    });
                }
            });
        });
    </script>
@endpush