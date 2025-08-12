@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <style>
        .header-asesmen {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px 15px;
            border-radius: 8px;
            border-left: 5px solid #007bff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card {
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 12px 15px;
            font-weight: 600;
            border-radius: 8px 8px 0 0 !important;
            font-size: 0.95rem;
        }

        .card-body {
            padding: 15px;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-control-plaintext {
            padding-top: calc(0.375rem + 1px);
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 8px 12px;
        }

        .section-title {
            color: #495057;
            font-weight: 600;
            border-bottom: 2px solid #007bff;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label,
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .required {
            color: #dc3545;
        }

        /* Error message styling */
        .text-danger {
            color: #dc3545 !important;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }

        .form-control.is-invalid,
        .trix-editor.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .form-control.is-valid,
        .trix-editor.is-valid {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .patient-info-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 15px;
        }

        .patient-info-item {
            display: flex;
            margin-bottom: 8px;
            align-items: flex-start;
        }

        .patient-info-label {
            font-weight: 600;
            min-width: 180px;
            color: #495057;
            flex-shrink: 0;
        }

        .patient-info-value {
            color: #212529;
            flex: 1;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            padding: 10px 25px;
            font-weight: 500;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid #007bff;
            color: #007bff;
            font-weight: 500;
            padding: 8px 20px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: #007bff;
            color: white;
            transform: translateY(-1px);
        }

        /* Trix Editor Customization */
        .trix-editor {
            border: 1px solid #ced4da;
            border-radius: 4px;
            min-height: 120px;
            max-height: 300px;
            overflow-y: auto;
            padding: 10px;
            font-size: 14px;
            line-height: 1.5;
        }

        .trix-editor:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .trix-editor--focus {
            border-color: #80bdff !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
        }

        .trix-content {
            padding: 5px 0;
        }

        .datetime-container {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
            color: #495057;
        }

        /* Section Layout */
        .examination-section {
            background: #fdfdfd;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .examination-section h5 {
            color: #495057;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff;
        }

        /* Two column layout for forms */
        .form-row-custom {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .form-col-half {
            flex: 0 0 50%;
            max-width: 50%;
            padding-right: 15px;
            padding-left: 15px;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .card-body {
                padding: 10px;
            }

            .header-asesmen {
                padding: 15px 10px;
                text-align: center;
            }

            .card-header {
                padding: 10px 12px;
                font-size: 0.9rem;
            }

            .datetime-container {
                padding: 10px;
                margin-bottom: 15px;
            }

            .patient-info-item {
                flex-direction: column;
                margin-bottom: 12px;
            }

            .patient-info-label {
                min-width: unset;
                margin-bottom: 2px;
                font-weight: 600;
            }

            .form-col-half {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 15px;
            }

            .trix-editor {
                min-height: 100px;
            }
        }

        @media (max-width: 576px) {
            .header-asesmen h3 {
                font-size: 1.3rem;
            }

            .header-asesmen p {
                font-size: 0.85rem;
                margin-bottom: 0.3rem;
            }

            .form-group label {
                font-size: 0.9rem;
                font-weight: 600;
            }

            .form-control {
                font-size: 0.9rem;
            }

            .btn {
                font-size: 0.85rem;
                padding: 8px 15px;
            }
        }

        @media print {

            .btn,
            .card-header {
                display: none !important;
            }

            .card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
@endpush

@section('content')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.edukasi.include')

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-12 mb-3">
                @include('components.patient-card')
            </div>

            <div class="col-xl-9 col-lg-8 col-md-12">
                <div class="mb-3">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                        <i class="ti-arrow-left"></i> <span class="d-none d-sm-inline">Kembali</span>
                    </a>
                </div>

                <form id="edukasiForm" method="POST"
                    action="{{ route('forensik.unit.pelayanan.visum-exit.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                    @csrf

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <!-- Header Section -->
                            <div class="text-center mb-4">
                                <div class="header-asesmen">
                                    <h3 class="font-weight-bold mb-2">VISUM EXIT REPERTUM</h3>
                                </div>
                            </div>

                            <!-- Basic Information Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="ti-calendar"></i> Informasi Dasar Pemeriksaan
                                </div>
                                <div class="card-body">
                                    <div class="datetime-container">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="mb-3">
                                                    <label for="tanggal" class="form-label">Tanggal Pemeriksaan</label>
                                                    @error('tanggal')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                    <input type="date" class="form-control" id="tanggal" name="tanggal"
                                                        value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="mb-3">
                                                    <label for="jam" class="form-label">Jam Pemeriksaan</label>
                                                    @error('jam')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                    <input type="time" class="form-control" id="jam" name="jam"
                                                        value="{{ old('jam', date('H:i')) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <div class="mb-3">
                                                    <label for="nomor_ver" class="form-label">Nomor VeR</label>
                                                    @error('nomor_ver')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                    <input type="text" class="form-control" id="nomor_ver" name="nomor_ver"
                                                        placeholder="VeR/003/I/2025" value="{{ old('nomor_ver') }}"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="mb-3">
                                                <label for="permintaan" class="form-label">Permintaan Dari</label>
                                                @error('permintaan')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                                <textarea class="form-control" id="permintaan" name="permintaan" rows="3"
                                                    placeholder="Kepolisian Resor Langsa">{{ old('permintaan') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="mb-3">
                                                <label for="nomor_surat" class="form-label">Nomor Surat</label>
                                                @error('nomor_surat')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                                <input type="text" class="form-control" id="nomor_surat" name="nomor_surat"
                                                    placeholder="B/49/XII/2024/LL" value="{{ old('nomor_surat') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="registrasi" class="form-label">Nomor Registrasi</label>
                                                @error('registrasi')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                                <input type="text" class="form-control" id="registrasi" name="registrasi"
                                                    value="{{ $dataMedis->kd_pasien ?? '' }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="menerangkan" class="form-label">Menerangkan pada tanggal</label>
                                        @error('menerangkan')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <textarea class="form-control" id="menerangkan" name="menerangkan" rows="2"
                                            placeholder="Menerangkan pada tanggal...">{{ old('menerangkan') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Patient Information Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="ti-user"></i> Data Pasien/Korban
                                </div>
                                <div class="card-body">
                                    <div class="patient-info-card">
                                        <div class="patient-info-item">
                                            <span class="patient-info-label">Nama</span>
                                            <span class="patient-info-value" style="margin-left: 25px">: {{ $dataMedis->pasien->nama ?? '-' }}</span>
                                        </div>
                                        <div class="patient-info-item">
                                            <span class="patient-info-label">Tempat/Tanggal Lahir</span>
                                            <span class="patient-info-value" style="margin-left: 25px">: {{ $dataMedis->pasien->tempat_lahir ?? '-' }} /
                                                ({{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : 'Tidak Diketahui' }})
                                            </span>
                                        </div>
                                        <div class="patient-info-item">
                                            <span class="patient-info-label">Jenis Kelamin</span>
                                            <span
                                                class="patient-info-value" style="margin-left: 25px">: {{ $dataMedis->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                        </div>
                                        <div class="patient-info-item">
                                            <span class="patient-info-label">Suku/Agama</span>
                                            <span class="patient-info-value" style="margin-left: 25px">: {{ $dataMedis->pasien->suku->suku ?? '-' }} /
                                                {{ $dataMedis->pasien->agama->agama ?? '-' }}</span>
                                        </div>
                                        <div class="patient-info-item">
                                            <span class="patient-info-label">Pekerjaan</span>
                                            <span class="patient-info-value" style="margin-left: 25px">: {{ $dataMedis->pasien->pekerjaan->pekerjaan ?? '-' }}</span>
                                        </div>
                                        <div class="patient-info-item">
                                            <span class="patient-info-label">Alamat</span>
                                            <span class="patient-info-value" style="margin-left: 25px">: {{ $dataMedis->pasien->alamat ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Interview Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="ti-comment"></i> WAWANCARA
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="wawancara" class="form-label fw-bold">Hasil Wawancara</label>
                                        @error('wawancara')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="wawancara" type="hidden" name="wawancara" value="{{ old('wawancara') }}">
                                        <trix-editor input="wawancara"
                                            placeholder="Masukkan hasil wawancara dengan keluarga/saksi..."></trix-editor>
                                    </div>
                                </div>
                            </div>

                            <!-- External Examination Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="ti-search"></i> PEMERIKSAAN LUAR
                                </div>
                                <div class="card-body">
                                    <!-- Single Column Layout for External Examination -->
                                    <div class="examination-section">
                                        <div class="mb-3">
                                            <label for="label_mayat" class="form-label fw-bold">Label Mayat</label>
                                            @error('label_mayat')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            <input id="label_mayat" type="hidden" name="label_mayat"
                                                value="{{ old('label_mayat') }}">
                                            <trix-editor input="label_mayat"
                                                placeholder="Keterangan tentang label mayat..."></trix-editor>
                                        </div>

                                        <div class="mb-3">
                                            <label for="pembungkus_mayat" class="form-label fw-bold">Pembungkus Mayat</label>
                                            @error('pembungkus_mayat')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            <input id="pembungkus_mayat" type="hidden" name="pembungkus_mayat"
                                                value="{{ old('pembungkus_mayat') }}">
                                            <trix-editor input="pembungkus_mayat"
                                                placeholder="Deskripsi pembungkus mayat..."></trix-editor>
                                        </div>

                                        <div class="mb-3">
                                            <label for="benda_disamping" class="form-label fw-bold">Benda di Samping Mayat</label>
                                            @error('benda_disamping')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            <input id="benda_disamping" type="hidden" name="benda_disamping"
                                                value="{{ old('benda_disamping') }}">
                                            <trix-editor input="benda_disamping"
                                                placeholder="Benda-benda yang ditemukan di samping mayat..."></trix-editor>
                                        </div>

                                        <div class="mb-3">
                                            <label for="penutup_mayat" class="form-label fw-bold">Penutup Mayat</label>
                                            @error('penutup_mayat')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            <input id="penutup_mayat" type="hidden" name="penutup_mayat"
                                                value="{{ old('penutup_mayat') }}">
                                            <trix-editor input="penutup_mayat"
                                                placeholder="Keterangan penutup mayat..."></trix-editor>
                                        </div>

                                        <div class="mb-3">
                                            <label for="pakaian_mayat" class="form-label fw-bold">Pakaian Mayat</label>
                                            @error('pakaian_mayat')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            <input id="pakaian_mayat" type="hidden" name="pakaian_mayat"
                                                value="{{ old('pakaian_mayat') }}">
                                            <trix-editor input="pakaian_mayat"
                                                placeholder="Detail pakaian yang dikenakan mayat..."></trix-editor>
                                        </div>

                                        <div class="mb-3">
                                            <label for="perhiasan_mayat" class="form-label fw-bold">Perhiasan Mayat</label>
                                            @error('perhiasan_mayat')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            <input id="perhiasan_mayat" type="hidden" name="perhiasan_mayat"
                                                value="{{ old('perhiasan_mayat') }}">
                                            <trix-editor input="perhiasan_mayat"
                                                placeholder="Perhiasan yang ditemukan pada mayat..."></trix-editor>
                                        </div>

                                        <div class="mb-3">
                                            <label for="identifikasi_umum" class="form-label fw-bold">Identifikasi Umum</label>
                                            @error('identifikasi_umum')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            <input id="identifikasi_umum" type="hidden" name="identifikasi_umum"
                                                value="{{ old('identifikasi_umum') }}">
                                            <trix-editor input="identifikasi_umum"
                                                placeholder="Deskripsi umum mayat (tinggi, postur, rambut, kulit, dll)..."></trix-editor>
                                        </div>

                                        <div class="mb-3">
                                            <label for="identifikasi_khusus" class="form-label fw-bold">Identifikasi Khusus</label>
                                            @error('identifikasi_khusus')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            <input id="identifikasi_khusus" type="hidden" name="identifikasi_khusus"
                                                value="{{ old('identifikasi_khusus') }}">
                                            <trix-editor input="identifikasi_khusus"
                                                placeholder="Tanda-tanda khusus (tato, bekas luka, dll)..."></trix-editor>
                                        </div>

                                        <div class="mb-3">
                                            <label for="tanda_kematian" class="form-label fw-bold">Tanda-tanda Kematian</label>
                                            @error('tanda_kematian')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            <input id="tanda_kematian" type="hidden" name="tanda_kematian"
                                                value="{{ old('tanda_kematian') }}">
                                            <trix-editor input="tanda_kematian"
                                                placeholder="Lebam mayat, kaku mayat, suhu tubuh, kondisi mata, dll..."></trix-editor>
                                        </div>

                                        <div class="mb-3">
                                            <label for="gigi_geligi" class="form-label fw-bold">Gigi-geligi</label>
                                            @error('gigi_geligi')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            <input id="gigi_geligi" type="hidden" name="gigi_geligi"
                                                value="{{ old('gigi_geligi') }}">
                                            <trix-editor input="gigi_geligi"
                                                placeholder="Kondisi gigi dan rongga mulut..."></trix-editor>
                                        </div>

                                        <div class="mb-3">
                                            <label for="luka_luka" class="form-label fw-bold">Luka-luka</label>
                                            @error('luka_luka')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            <input id="luka_luka" type="hidden" name="luka_luka"
                                                value="{{ old('luka_luka') }}">
                                            <trix-editor input="luka_luka"
                                                placeholder="Deskripsi detail luka-luka yang ditemukan..."></trix-editor>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Conclusion Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="ti-clipboard"></i> KESIMPULAN
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="pada_jenazah" class="form-label fw-bold">Pada Jenazah</label>
                                        @error('pada_jenazah')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="pada_jenazah" type="hidden" name="pada_jenazah"
                                            value="{{ old('pada_jenazah') }}">
                                        <trix-editor input="pada_jenazah"
                                            placeholder="Kesimpulan umum tentang jenazah..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="pemeriksaan_luar_kesimpulan" class="form-label fw-bold">Pada Pemeriksaan
                                            Luar</label>
                                        @error('pemeriksaan_luar_kesimpulan')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="pemeriksaan_luar_kesimpulan" type="hidden"
                                            name="pemeriksaan_luar_kesimpulan"
                                            value="{{ old('pemeriksaan_luar_kesimpulan') }}">
                                        <trix-editor input="pemeriksaan_luar_kesimpulan"
                                            placeholder="Kesimpulan dari pemeriksaan luar..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="dijumpai_kesimpulan" class="form-label fw-bold">Dijumpai</label>
                                        @error('dijumpai_kesimpulan')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="dijumpai_kesimpulan" type="hidden" name="dijumpai_kesimpulan"
                                            value="{{ old('dijumpai_kesimpulan') }}">
                                        <trix-editor input="dijumpai_kesimpulan"
                                            placeholder="Temuan-temuan penting..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="hasil_kesimpulan" class="form-label fw-bold">Hasil Kesimpulan</label>
                                        @error('hasil_kesimpulan')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="hasil_kesimpulan" type="hidden" name="hasil_kesimpulan"
                                            value="{{ old('hasil_kesimpulan') }}">
                                        <trix-editor input="hasil_kesimpulan"
                                            placeholder="Kesimpulan akhir mengenai perkiraan lama kematian, cara kematian, dan penyebab kematian..."></trix-editor>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="dokter_pemeriksa" class="form-label fw-bold">Dokter Pemeriksa</label>
                                                @error('dokter_pemeriksa')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                                <select id="dokter_pemeriksa" name="dokter_pemeriksa" class="form-select select2" required>
                                                    <option value="">--Pilih Dokter Pemeriksa--</option>
                                                    @foreach ($dokter as $item)
                                                        <option value="{{ $item->kd_dokter }}">
                                                            {{ $item->nama_lengkap }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex flex-wrap justify-content-end mt-4">
                                <div class="mb-2">
                                    <button type="submit" class="btn btn-primary mb-2">
                                        <i class="ti-save"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Trix editors
            document.addEventListener('trix-initialize', function (event) {
                const editor = event.target;
                editor.style.minHeight = '120px';
            });

            // Generate VeR number automatically
            const generateVerNumber = function () {
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const romanMonth = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'][today.getMonth()];

                // This should be generated based on your database sequence
                const sequence = '000'; // This should come from backend

                const verNumber = `VeR/${sequence}/${romanMonth}/${year}`;

                if (!document.getElementById('nomor_ver').value) {
                    document.getElementById('nomor_ver').value = verNumber;
                }
            };

            // Generate VeR number on page load
            generateVerNumber();

            // Validation for required fields
            const requiredFields = document.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                field.addEventListener('blur', function () {
                    if (!this.value.trim()) {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });
            });

            // Auto-save functionality (optional)
            let autoSaveTimeout;
            const formInputs = document.querySelectorAll('input, select, textarea');

            formInputs.forEach(input => {
                input.addEventListener('input', function () {
                    clearTimeout(autoSaveTimeout);
                    autoSaveTimeout = setTimeout(function () {
                        // Auto-save logic can be implemented here
                        console.log('Auto-saving draft...');
                    }, 30000); // Auto-save after 30 seconds of inactivity
                });
            });

            // Trix editor event handlers
            document.addEventListener('trix-change', function () {
                clearTimeout(autoSaveTimeout);
                autoSaveTimeout = setTimeout(function () {
                    console.log('Auto-saving draft...');
                }, 30000);
            });

            // Improve Trix editor styling and functionality
            document.addEventListener('trix-initialize', function (event) {
                const toolbarElement = event.target.previousElementSibling;
                if (toolbarElement && toolbarElement.classList.contains('trix-toolbar')) {
                    toolbarElement.style.border = '1px solid #ced4da';
                    toolbarElement.style.borderBottom = 'none';
                    toolbarElement.style.borderRadius = '4px 4px 0 0';
                    toolbarElement.style.backgroundColor = '#f8f9fa';
                }
            });
        });


        // Custom validation messages
        document.addEventListener('invalid', function (e) {
            e.target.setCustomValidity('');
            if (!e.target.validity.valid) {
                switch (e.target.type) {
                    case 'date':
                        e.target.setCustomValidity('Tanggal harus diisi');
                        break;
                    case 'time':
                        e.target.setCustomValidity('Jam harus diisi');
                        break;
                    case 'text':
                        if (e.target.hasAttribute('required')) {
                            e.target.setCustomValidity('Field ini wajib diisi');
                        }
                        break;
                    case 'select-one':
                        e.target.setCustomValidity('Pilih salah satu opsi');
                        break;
                    default:
                        e.target.setCustomValidity('Field ini tidak valid');
                }
            }
        }, true);

        // Clear custom validity on input
        document.addEventListener('input', function (e) {
            e.target.setCustomValidity('');
        });
    </script>
@endpush
