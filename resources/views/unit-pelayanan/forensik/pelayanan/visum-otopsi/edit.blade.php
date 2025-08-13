@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <style>
        .header-asesmen {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px 15px;
            border-radius: 8px;
            border-left: 5px solid #007bff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .card {
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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

        .required {
            color: #dc3545;
        }

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
            box-shadow: 0 2px 4px rgba(0,123,255,0.3);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,123,255,0.4);
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

        .datetime-container {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 10px;
            }
            
            .header-asesmen {
                padding: 15px 10px;
                text-align: center;
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
        }

        @media print {
            .btn, .card-header {
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

                <form id="visumForm" method="POST"
                    action="{{ route('forensik.unit.pelayanan.visum-otopsi.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $visumOtopsi->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <!-- Header Section -->
                            <div class="text-center mb-4">
                                <div class="header-asesmen">
                                    <h3 class="font-weight-bold mb-2">EDIT VISUM ET REPERTUM OTOPSI</h3>
                                    <p class="mb-1 text-muted">INSTALASI KEDOKTERAN FORENSIK</p>
                                    <p class="mb-0 text-muted">RUMAH SAKIT UMUM DAERAH LANGSA</p>
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
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="tanggal" class="form-label" required>Tanggal Pengisian</label>
                                                    @error('tanggal')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                    <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                                           value="{{ old('tanggal', $visumOtopsi->tanggal) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="jam" class="form-label" required>Jam Pengisian</label>
                                                    @error('jam')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                    <input type="time" class="form-control" id="jam" name="jam" 
                                                           value="{{ date('H:i', strtotime($visumOtopsi->jam)) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="nomor" class="form-label">Nomor</span></label>
                                                    @error('nomor')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                    <input type="text" class="form-control" id="nomor" name="nomor" 
                                                           placeholder="Masukkan nomor visum" value="{{ old('nomor', $visumOtopsi->nomor) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="perihal" class="form-label">Perihal</label>
                                                @error('perihal')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                                <input type="text" class="form-control" id="perihal" name="perihal" 
                                                       value="{{ old('perihal', $visumOtopsi->perihal) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="lampiran" class="form-label">Lampiran</label>
                                                @error('lampiran')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                                <input type="text" class="form-control" id="lampiran" name="lampiran" 
                                                       placeholder="B/49/XII/2024/LL" value="{{ old('lampiran', $visumOtopsi->lampiran) }}">
                                            </div>
                                        </div>
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
                                            <span class="patient-info-label">Nama:</span>
                                            <span class="patient-info-value">{{ $dataMedis->pasien->nama ?? '-' }}</span>
                                        </div>
                                        <div class="patient-info-item">
                                            <span class="patient-info-label">Tempat/Tanggal Lahir:</span>
                                            <span class="patient-info-value">{{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Thn
            ({{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : 'Tidak Diketahui' }})</span>
                                        </div>
                                        <div class="patient-info-item">
                                            <span class="patient-info-label">Jenis Kelamin:</span>
                                            <span class="patient-info-value">{{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}</span>
                                        </div>
                                        <div class="patient-info-item">
                                            <span class="patient-info-label">Agama:</span>
                                            <span class="patient-info-value">{{ $dataMedis->pasien->agama->agama ?? '-' }}</span>
                                        </div>
                                        <div class="patient-info-item">
                                            <span class="patient-info-label">Alamat:</span>
                                            <span class="patient-info-value">{{ $dataMedis->pasien->alamat ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Visum et Repertum Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="ti-file-text"></i> VISUM ET REPERTUM
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="visum_et_repertum" class="form-label">Visum et Repertum</label>
                                        @error('visum_et_repertum')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="visum_et_repertum" type="hidden" name="visum_et_repertum" value="{{ old('visum_et_repertum', $visumOtopsi->visum_et_repertum) }}">
                                        <trix-editor input="visum_et_repertum" placeholder="Masukkan isi visum et repertum..."></trix-editor>
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
                                        <label for="wawancara" class="form-label">Hasil Wawancara</label>
                                        @error('wawancara')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="wawancara" type="hidden" name="wawancara" value="{{ old('wawancara', $visumOtopsi->wawancara) }}">
                                        <trix-editor input="wawancara" placeholder="Masukkan hasil wawancara dengan keluarga/saksi..."></trix-editor>
                                    </div>
                                </div>
                            </div>

                            <!-- External Examination Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="ti-search"></i> PEMERIKSAAN LUAR
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="penutup_mayat" class="form-label">Penutup Mayat</label>
                                        @error('penutup_mayat')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="penutup_mayat" type="hidden" name="penutup_mayat" value="{{ old('penutup_mayat', $visumOtopsi->penutup_mayat) }}">
                                        <trix-editor input="penutup_mayat" placeholder="Keterangan penutup mayat..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="label_mayat" class="form-label">Label Mayat</label>
                                        @error('label_mayat')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="label_mayat" type="hidden" name="label_mayat" value="{{ old('label_mayat', $visumOtopsi->label_mayat) }}">
                                        <trix-editor input="label_mayat" placeholder="Keterangan tentang label mayat..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="pakaian_mayat" class="form-label">Pakaian Mayat</label>
                                        @error('pakaian_mayat')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="pakaian_mayat" type="hidden" name="pakaian_mayat" value="{{ old('pakaian_mayat', $visumOtopsi->pakaian_mayat) }}">
                                        <trix-editor input="pakaian_mayat" placeholder="Detail pakaian yang dikenakan mayat..."></trix-editor>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="benda_disamping" class="form-label">Benda di Samping Mayat</label>
                                                @error('benda_disamping')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                                <textarea class="form-control" id="benda_disamping" name="benda_disamping" rows="4" 
                                                          placeholder="Benda-benda yang ditemukan di samping mayat...">{{ old('benda_disamping', $visumOtopsi->benda_disamping) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="aksesoris" class="form-label">Aksesoris</label>
                                                @error('aksesoris')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                                <textarea class="form-control" id="aksesoris" name="aksesoris" rows="4" 
                                                          placeholder="Aksesoris yang ditemukan pada mayat...">{{ old('aksesoris', $visumOtopsi->aksesoris) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Identifikasi Umum Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="ti-id-badge"></i> IDENTIFIKASI UMUM
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="identifikasi_umum_keterangan" class="form-label">Keterangan</label>
                                        @error('identifikasi_umum_keterangan')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="identifikasi_umum_keterangan" type="hidden" name="identifikasi_umum_keterangan" value="{{ old('identifikasi_umum_keterangan', $visumOtopsi->identifikasi_umum_keterangan) }}">
                                        <trix-editor input="identifikasi_umum_keterangan" placeholder="Deskripsi umum mayat (tinggi, postur, rambut, kulit, dll)..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanda_kematian" class="form-label">Tanda-tanda Kematian</label>
                                        @error('tanda_kematian')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="tanda_kematian" type="hidden" name="tanda_kematian" value="{{ old('tanda_kematian', $visumOtopsi->tanda_kematian) }}">
                                        <trix-editor input="tanda_kematian" placeholder="Lebam mayat, kaku mayat, suhu tubuh, kondisi mata, dll..."></trix-editor>
                                    </div>
                                </div>
                            </div>

                            <!-- Identifikasi Khusus Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="ti-fingerprint"></i> IDENTIFIKASI KHUSUS
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="identifikasi_khusus_keterangan" class="form-label">Keterangan</label>
                                        @error('identifikasi_khusus_keterangan')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="identifikasi_khusus_keterangan" type="hidden" name="identifikasi_khusus_keterangan" value="{{ old('identifikasi_khusus_keterangan', $visumOtopsi->identifikasi_khusus_keterangan) }}">
                                        <trix-editor input="identifikasi_khusus_keterangan" placeholder="Tanda-tanda khusus (tato, bekas luka, dll)..."></trix-editor>
                                    </div>
                                </div>
                            </div>

                            <!-- Hasil Pemeriksaan Luar Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="ti-eye"></i> HASIL PEMERIKSAAN LUAR
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="kepala_luar" class="form-label">Kepala</label>
                                        @error('kepala_luar')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="kepala_luar" type="hidden" name="kepala_luar" value="{{ old('kepala_luar', $visumOtopsi->kepala_luar) }}">
                                        <trix-editor input="kepala_luar" placeholder="Pemeriksaan bagian kepala dari luar..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="wajah" class="form-label">Wajah</label>
                                        @error('wajah')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="wajah" type="hidden" name="wajah" value="{{ old('wajah', $visumOtopsi->wajah) }}">
                                        <trix-editor input="wajah" placeholder="Pemeriksaan bagian wajah..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mata" class="form-label">Mata</label>
                                        @error('mata')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="mata" type="hidden" name="mata" value="{{ old('mata', $visumOtopsi->mata) }}">
                                        <trix-editor input="mata" placeholder="Pemeriksaan bagian mata..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mulut" class="form-label">Mulut</label>
                                        @error('mulut')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="mulut" type="hidden" name="mulut" value="{{ old('mulut', $visumOtopsi->mulut) }}">
                                        <trix-editor input="mulut" placeholder="Pemeriksaan bagian mulut..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="leher_luar" class="form-label">Leher</label>
                                        @error('leher_luar')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="leher_luar" type="hidden" name="leher_luar" value="{{ old('leher_luar', $visumOtopsi->leher_luar) }}">
                                        <trix-editor input="leher_luar" placeholder="Pemeriksaan bagian leher dari luar..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="dada_luar" class="form-label">Dada</label>
                                        @error('dada_luar')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="dada_luar" type="hidden" name="dada_luar" value="{{ old('dada_luar', $visumOtopsi->dada_luar) }}">
                                        <trix-editor input="dada_luar" placeholder="Pemeriksaan bagian dada dari luar..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="punggung" class="form-label">Punggung</label>
                                        @error('punggung')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="punggung" type="hidden" name="punggung" value="{{ old('punggung', $visumOtopsi->punggung) }}">
                                        <trix-editor input="punggung" placeholder="Pemeriksaan bagian punggung..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="perut_luar" class="form-label">Perut</label>
                                        @error('perut_luar')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="perut_luar" type="hidden" name="perut_luar" value="{{ old('perut_luar', $visumOtopsi->perut_luar) }}">
                                        <trix-editor input="perut_luar" placeholder="Pemeriksaan bagian perut dari luar..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="anggota_gerak_atas" class="form-label">Anggota Gerak Atas</label>
                                        @error('anggota_gerak_atas')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="anggota_gerak_atas" type="hidden" name="anggota_gerak_atas" value="{{ old('anggota_gerak_atas', $visumOtopsi->anggota_gerak_atas) }}">
                                        <trix-editor input="anggota_gerak_atas" placeholder="Pemeriksaan anggota gerak atas (lengan, tangan)..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="anggota_gerak_bawah" class="form-label">Anggota Gerak Bawah</label>
                                        @error('anggota_gerak_bawah')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="anggota_gerak_bawah" type="hidden" name="anggota_gerak_bawah" value="{{ old('anggota_gerak_bawah', $visumOtopsi->anggota_gerak_bawah) }}">
                                        <trix-editor input="anggota_gerak_bawah" placeholder="Pemeriksaan anggota gerak bawah (kaki, tungkai)..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="kemaluan" class="form-label">Kemaluan</label>
                                        @error('kemaluan')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="kemaluan" type="hidden" name="kemaluan" value="{{ old('kemaluan', $visumOtopsi->kemaluan) }}">
                                        <trix-editor input="kemaluan" placeholder="Pemeriksaan bagian kemaluan..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="anus" class="form-label">Anus</label>
                                        @error('anus')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="anus" type="hidden" name="anus" value="{{ old('anus', $visumOtopsi->anus) }}">
                                        <trix-editor input="anus" placeholder="Pemeriksaan bagian anus..."></trix-editor>
                                    </div>
                                </div>
                            </div>

                            <!-- Hasil Pemeriksaan Dalam Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="ti-layers"></i> HASIL PEMERIKSAAN DALAM
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="kepala_dalam" class="form-label">Kepala</label>
                                        @error('kepala_dalam')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="kepala_dalam" type="hidden" name="kepala_dalam" value="{{ old('kepala_dalam', $visumOtopsi->kepala_dalam) }}">
                                        <trix-editor input="kepala_dalam" placeholder="Pemeriksaan bagian kepala dari dalam (otak, tengkorak)..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="leher_dalam" class="form-label">Leher</label>
                                        @error('leher_dalam')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="leher_dalam" type="hidden" name="leher_dalam" value="{{ old('leher_dalam', $visumOtopsi->leher_dalam) }}">
                                        <trix-editor input="leher_dalam" placeholder="Pemeriksaan bagian leher dari dalam (otot, pembuluh darah, saluran napas)..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="dada_dalam" class="form-label">Dada</label>
                                        @error('dada_dalam')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="dada_dalam" type="hidden" name="dada_dalam" value="{{ old('dada_dalam', $visumOtopsi->dada_dalam) }}">
                                        <trix-editor input="dada_dalam" placeholder="Pemeriksaan bagian dada dari dalam (jantung, paru-paru)..."></trix-editor>
                                    </div>

                                    <div class="mb-3">
                                        <label for="perut_dalam" class="form-label">Perut</label>
                                        @error('perut_dalam')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="perut_dalam" type="hidden" name="perut_dalam" value="{{ old('perut_dalam', $visumOtopsi->perut_dalam) }}">
                                        <trix-editor input="perut_dalam" placeholder="Pemeriksaan bagian perut dari dalam (organ-organ internal)..."></trix-editor>
                                    </div>
                                </div>
                            </div>

                            <!-- Kesimpulan Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="ti-check-box"></i> KESIMPULAN
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="kesimpulan" class="form-label">Kesimpulan</label>
                                        @error('kesimpulan')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <input id="kesimpulan" type="hidden" name="kesimpulan" value="{{ old('kesimpulan', $visumOtopsi->kesimpulan) }}">
                                        <trix-editor input="kesimpulan" placeholder="Kesimpulan hasil visum et repertum otopsi..."></trix-editor>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex flex-wrap justify-content-between mt-4">
                                <div class="mb-2">
                                    <button type="button" class="btn btn-warning mb-2" id="reset_form">
                                        <i class="ti-reload"></i> Reset
                                    </button>
                                </div>
                                <div class="mb-2">
                                    <button type="submit" class="btn btn-primary mb-2" id="simpan">
                                        <i class="ti-save"></i> Update Visum Otopsi
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
            document.addEventListener('trix-initialize', function(event) {
                const editor = event.target;
                editor.style.minHeight = '120px';
            });

            // Reset confirmation
            const resetButton = document.getElementById('reset_form');
            if (resetButton) {
                resetButton.addEventListener('click', function (e) {
                    if (confirm('Apakah Anda yakin ingin mereset seluruh form ini? Data yang sudah diubah akan kembali ke data asli.')) {
                        // Reset all form inputs to original values
                        document.getElementById('tanggal').value = '{{ $visumOtopsi->tanggal }}';
                        document.getElementById('jam').value = '{{ $visumOtopsi->jam }}';
                        document.getElementById('nomor').value = '{{ $visumOtopsi->nomor }}';
                        document.getElementById('perihal').value = '{{ $visumOtopsi->perihal }}';
                        document.getElementById('lampiran').value = '{{ $visumOtopsi->lampiran }}';
                        document.getElementById('benda_disamping').value = '{{ $visumOtopsi->benda_disamping }}';
                        document.getElementById('aksesoris').value = '{{ $visumOtopsi->aksesoris }}';
                        
                        // Reset all Trix editors to original values
                        const trixData = {
                            'visum_et_repertum': '{!! addslashes($visumOtopsi->visum_et_repertum ?? '') !!}',
                            'wawancara': '{!! addslashes($visumOtopsi->wawancara ?? '') !!}',
                            'penutup_mayat': '{!! addslashes($visumOtopsi->penutup_mayat ?? '') !!}',
                            'label_mayat': '{!! addslashes($visumOtopsi->label_mayat ?? '') !!}',
                            'pakaian_mayat': '{!! addslashes($visumOtopsi->pakaian_mayat ?? '') !!}',
                            'identifikasi_umum_keterangan': '{!! addslashes($visumOtopsi->identifikasi_umum_keterangan ?? '') !!}',
                            'tanda_kematian': '{!! addslashes($visumOtopsi->tanda_kematian ?? '') !!}',
                            'identifikasi_khusus_keterangan': '{!! addslashes($visumOtopsi->identifikasi_khusus_keterangan ?? '') !!}',
                            'kepala_luar': '{!! addslashes($visumOtopsi->kepala_luar ?? '') !!}',
                            'wajah': '{!! addslashes($visumOtopsi->wajah ?? '') !!}',
                            'mata': '{!! addslashes($visumOtopsi->mata ?? '') !!}',
                            'mulut': '{!! addslashes($visumOtopsi->mulut ?? '') !!}',
                            'leher_luar': '{!! addslashes($visumOtopsi->leher_luar ?? '') !!}',
                            'dada_luar': '{!! addslashes($visumOtopsi->dada_luar ?? '') !!}',
                            'punggung': '{!! addslashes($visumOtopsi->punggung ?? '') !!}',
                            'perut_luar': '{!! addslashes($visumOtopsi->perut_luar ?? '') !!}',
                            'anggota_gerak_atas': '{!! addslashes($visumOtopsi->anggota_gerak_atas ?? '') !!}',
                            'anggota_gerak_bawah': '{!! addslashes($visumOtopsi->anggota_gerak_bawah ?? '') !!}',
                            'kemaluan': '{!! addslashes($visumOtopsi->kemaluan ?? '') !!}',
                            'anus': '{!! addslashes($visumOtopsi->anus ?? '') !!}',
                            'kepala_dalam': '{!! addslashes($visumOtopsi->kepala_dalam ?? '') !!}',
                            'leher_dalam': '{!! addslashes($visumOtopsi->leher_dalam ?? '') !!}',
                            'dada_dalam': '{!! addslashes($visumOtopsi->dada_dalam ?? '') !!}',
                            'perut_dalam': '{!! addslashes($visumOtopsi->perut_dalam ?? '') !!}',
                            'kesimpulan': '{!! addslashes($visumOtopsi->kesimpulan ?? '') !!}'
                        };

                        Object.keys(trixData).forEach(key => {
                            const editor = document.querySelector(`trix-editor[input="${key}"]`);
                            if (editor && editor.editor) {
                                editor.editor.loadHTML(trixData[key]);
                            }
                        });
                    }
                });
            }

            // Form submission confirmation
            const form = document.getElementById('visumForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Apakah Anda yakin ingin menyimpan perubahan Visum Otopsi ini?')) {
                        e.preventDefault();
                    }
                });
            }

            // Validation for required fields
            const requiredFields = document.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                field.addEventListener('blur', function() {
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
                input.addEventListener('input', function() {
                    clearTimeout(autoSaveTimeout);
                    autoSaveTimeout = setTimeout(function() {
                        console.log('Auto-saving draft...');
                    }, 30000); // Auto-save after 30 seconds of inactivity
                });
            });

            // Custom validation messages
            document.addEventListener('invalid', function(e) {
                e.target.setCustomValidity('');
                if (!e.target.validity.valid) {
                    switch(e.target.type) {
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
                        default:
                            e.target.setCustomValidity('Field ini tidak valid');
                    }
                }
            }, true);

            // Clear custom validity on input
            document.addEventListener('input', function(e) {
                e.target.setCustomValidity('');
            });
        });

        // Prevent accidental page refresh
        window.addEventListener('beforeunload', function(e) {
            const form = document.getElementById('visumForm');
            if (!form) return;
            
            // Check if form has been modified
            let hasChanges = false;
            
            // Check regular form fields
            const originalData = {
                tanggal: '{{ $visumOtopsi->tanggal }}',
                jam: '{{ $visumOtopsi->jam }}',
                nomor: '{{ $visumOtopsi->nomor }}',
                perihal: '{{ $visumOtopsi->perihal }}',
                lampiran: '{{ $visumOtopsi->lampiran }}',
                benda_disamping: '{{ $visumOtopsi->benda_disamping }}',
                aksesoris: '{{ $visumOtopsi->aksesoris }}'
            };

            Object.keys(originalData).forEach(key => {
                const element = document.getElementById(key);
                if (element && element.value !== originalData[key]) {
                    hasChanges = true;
                }
            });
            
            // Check Trix editors if no changes found yet
            if (!hasChanges) {
                const trixEditors = document.querySelectorAll('trix-editor');
                trixEditors.forEach(editor => {
                    if (editor.editor) {
                        const currentContent = editor.editor.getDocument().toString().trim();
                        const originalContent = editor.querySelector('input[type="hidden"]').value || '';
                        if (currentContent !== originalContent.replace(/<[^>]*>/g, '').trim()) {
                            hasChanges = true;
                        }
                    }
                });
            }
            
            if (hasChanges) {
                e.preventDefault();
                e.returnValue = 'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
            }
        });
    </script>
@endpush