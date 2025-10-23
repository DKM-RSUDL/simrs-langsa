@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: #2c3e50;
            font-size: 0.85rem;
        }

        .header-asesmen {
            margin-top: 0.5rem;
            font-size: 1.3rem;
            font-weight: 600;
            color: #0c82dc;
            text-align: center;
            margin-bottom: 1.2rem;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        .form-section {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1.2rem;
        }

        .section-title {
            font-weight: 600;
            color: #004b85;
            margin-bottom: 1rem;
            font-size: 1rem;
            border-bottom: 2px solid #097dd6;
            padding-bottom: 0.3rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.3rem;
            display: block;
            font-size: 0.8rem;
        }

        .form-control {
            border-radius: 4px;
            border: 1px solid #ced4da;
            padding: 0.5rem;
            font-size: 0.85rem;
            height: auto;
        }

        .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.15rem rgba(9, 125, 214, 0.25);
        }

        .datetime-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
        }

        .datetime-item label {
            font-weight: 500;
            color: #6c757d;
            font-size: 0.75rem;
        }

        .row {
            margin-left: -0.5rem;
            margin-right: -0.5rem;
        }

        .row>[class*="col-"] {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        @media (max-width: 768px) {
            .datetime-group {
                grid-template-columns: 1fr;
            }

            .form-section {
                padding: 0.8rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Tambah Data Tindakan HD',
                    'description' =>
                        'Tambah Data Tindakan HD Pasien Hemodialisis dengan mengisi formulir di bawah ini.',
                ])

                <form id="consentForm" method="POST"
                    action="{{ route('hemodialisa.pelayanan.persetujuan.tindakan-medis.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                    @csrf
                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <h5 class="section-title">Informasi Dasar</h5>

                        <div class="form-group">
                            <label class="form-label">Tanggal dan Jam Implementasi</label>
                            <div class="datetime-group">
                                <div class="datetime-item">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal_implementasi"
                                        id="tanggal_implementasi">
                                </div>
                                <div class="datetime-item">
                                    <label>Jam</label>
                                    <input type="time" class="form-control" name="jam_implementasi"
                                        id="jam_implementasi">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tipe_penerima" class="form-label">Yang Menerima Informasi/Memberikan
                                Persetujuan</label>
                            <select class="form-control" id="tipe_penerima" name="tipe_penerima">
                                <option value="">Pilih...</option>
                                <option value="pasien">Pasien</option>
                                <option value="keluarga">Keluarga</option>
                            </select>
                        </div>

                        <!-- Section untuk Pasien -->
                        <div id="section_pasien" class="form-group" style="display: none;">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Nama Pasien</label>
                                        <input type="text" class="form-control" id="nama_pasien" name="nama_pasien"
                                            value="{{ $dataMedis->pasien->nama ?? '' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Tempat/Tgl Lahir</label>
                                        <input type="text" class="form-control" id="tempat_tgl_lahir_pasien"
                                            name="tempat_tgl_lahir_pasien"
                                            value="{{ ($dataMedis->pasien->tempat_lahir ?? '') . ($dataMedis->pasien->tempat_lahir && $dataMedis->pasien->tgl_lahir ? ', ' : '') . ($dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d-m-Y') : '') }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <input type="text" class="form-control" id="jk_pasien" name="jk_pasien"
                                            value="{{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">Umur</label>
                                        <input type="text" class="form-control" id="umur_pasien" name="umur_pasien"
                                            value="{{ $dataMedis->pasien->umur ?? '' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">Alamat</label>
                                        <input type="text" class="form-control" id="alamat_pasien" name="alamat_pasien"
                                            value="{{ $dataMedis->pasien->alamat ?? '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section untuk Keluarga -->
                        <div id="section_keluarga" style="display: none;">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="nama_keluarga" class="form-label">Nama Keluarga</label>
                                        <input type="text" class="form-control" id="nama_keluarga" name="nama_keluarga"
                                            placeholder="Nama lengkap keluarga">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tempat_tgl_lahir_keluarga" class="form-label">Tempat/Tgl
                                            Lahir</label>
                                        <input type="text" class="form-control" id="tempat_tgl_lahir_keluarga"
                                            name="tempat_tgl_lahir_keluarga" placeholder="Contoh: Jakarta, 15-01-1980">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="jk_keluarga" class="form-label">Jenis Kelamin</label>
                                        <select class="form-control" id="jk_keluarga" name="jk_keluarga">
                                            <option value="">Pilih</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="status_keluarga" class="form-label">Hubungan</label>
                                        <select class="form-control" id="status_keluarga" name="status_keluarga">
                                            <option value="">Pilih Status</option>
                                            <option value="Suami">Suami</option>
                                            <option value="Istri">Istri</option>
                                            <option value="Ayah">Ayah</option>
                                            <option value="Ibu">Ibu</option>
                                            <option value="Anak">Anak</option>
                                            <option value="Saudara Kandung">Saudara Kandung</option>
                                            <option value="Kakek">Kakek</option>
                                            <option value="Nenek">Nenek</option>
                                            <option value="Cucu">Cucu</option>
                                            <option value="Menantu">Menantu</option>
                                            <option value="Mertua">Mertua</option>
                                            <option value="Keponakan">Keponakan</option>
                                            <option value="Sepupu">Sepupu</option>
                                            <option value="Wali">Wali</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="alamat_keluarga" class="form-label">Alamat</label>
                                        <input type="text" class="form-control" id="alamat_keluarga"
                                            name="alamat_keluarga" placeholder="Alamat lengkap">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tindakan Yang Dilakukan Section -->
                    <div class="form-section">
                        <h5 class="section-title">Tindakan Yang Dilakukan</h5>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tindakan[]" value="hemodialisis"
                                    id="hemodialisis" checked>
                                <label class="form-check-label" for="hemodialisis">HEMODIALISIS</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tindakan[]"
                                    value="akses_vascular_fmoralis" id="akses_vascular_fmoralis" checked>
                                <label class="form-check-label" for="akses_vascular_fmoralis">AKSES VASCULAR
                                    FMORALIS</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tindakan[]"
                                    value="akses_vascular_subclavicula" id="akses_vascular_subclavicula" checked>
                                <label class="form-check-label" for="akses_vascular_subclavicula">AKSES VASCULAR
                                    SUBCLAVICULA CATHETER</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tindakan[]"
                                    value="akses_vascular_cimino" id="akses_vascular_cimino" checked>
                                <label class="form-check-label" for="akses_vascular_cimino">AKSES VASCULAR
                                    ANTERIOR VENOUS FISTULA (CIMINO)</label>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <x-button-submit-confirm label="Simpan" confirmTitle="Sudah Yakin?"
                            confirmText="Pastikan semua data sudah lengkap sebelum disimpan. Lanjutkan menyimpan?"
                            confirmOk="Simpan" confirmCancel="Batal" :spinner="true" loadingLabel="Menyimpan..."
                            loadingOverlay="#loadingOverlay" />
                    </div>
        </div>
    </div>
    </form>
    </x-content-card>
    </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Set tanggal dan jam saat ini
            const now = new Date();
            const today = now.toISOString().split('T')[0];
            const currentTime = now.toTimeString().split(' ')[0].substring(0, 5);

            $('#tanggal_implementasi').val(today);
            $('#jam_implementasi').val(currentTime);

            // Handle tipe penerima informasi
            $('#tipe_penerima').on('change', function() {
                const tipe = $(this).val();

                // Hide semua section
                $('#section_pasien').hide();
                $('#section_keluarga').hide();

                // Show section yang dipilih
                if (tipe === 'pasien') {
                    $('#section_pasien').show();
                } else if (tipe === 'keluarga') {
                    $('#section_keluarga').show();
                }
            });
        });
    </script>
@endpush
