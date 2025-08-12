@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <style>
        .header-asesmen {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px 15px;
            border-radius: 8px;
            border-left: 5px solid #28a745;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(135deg, #28a745 0%, #20923a 100%);
            color: white;
            padding: 12px 15px;
            font-weight: 600;
            border-radius: 8px 8px 0 0 !important;
            font-size: 0.95rem;
        }

        .card-body {
            padding: 15px;
        }

        .form-control:disabled,
        .form-control[readonly] {
            background-color: #f8f9fa;
            border-color: #e9ecef;
            color: #495057;
            opacity: 1;
        }

        .form-select:disabled {
            background-color: #f8f9fa;
            border-color: #e9ecef;
            color: #495057;
            opacity: 1;
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
            border-bottom: 2px solid #28a745;
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

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20923a 100%);
            border: none;
            color: white;
            font-weight: 500;
            padding: 10px 25px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.4);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ff9500 100%);
            border: none;
            color: #212529;
            font-weight: 500;
            padding: 10px 25px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(255, 193, 7, 0.3);
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(255, 193, 7, 0.4);
        }

        /* Trix Editor Customization - Read Only */
        .trix-editor {
            border: 1px solid #e9ecef;
            border-radius: 4px;
            min-height: 120px;
            max-height: 300px;
            overflow-y: auto;
            padding: 5px;
            font-size: 12px;
            line-height: 1.5;
            background-color: #f8f9fa;
            color: #495057;
        }

        .trix-editor[contenteditable="false"] {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }

        .trix-toolbar {
            display: none !important;
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

        /* Section Layout */
        .examination-section {
            background: #fdfdfd;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .examination-section h5 {
            color: #495057;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #28a745;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 15px;
        }

        .status-complete {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-incomplete {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status-partial {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
            border: 1px solid #ffeaa7;
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

            .header-asesmen {
                border-left: none;
                background: white !important;
            }
        }

        /* Print styles */
        .print-section {
            page-break-inside: avoid;
            margin-bottom: 20px;
        }

        .no-print {
            display: block;
        }

        @media print {
            .no-print {
                display: none !important;
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
                <div class="mb-3 no-print">
                    <a href="{{ route('forensik.unit.pelayanan.visum-exit.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                        class="btn btn-outline-primary">
                        <i class="ti-arrow-left"></i> <span class="d-none d-sm-inline">Kembali</span>
                    </a>
                    <a href="{{ route('forensik.unit.pelayanan.visum-exit.print-pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $visumExit->id]) }}" type="button" class="btn btn-success" target="_black">
                        <i class="ti-printer"></i> <span class="d-none d-sm-inline">Cetak</span>
                    </a>
                </div>

                <div class="shadow-sm">
                    <div class="card-body">
                        <!-- Header Section -->
                        <div class="text-center mb-4">
                            <div class="header-asesmen">
                                <h3 class="font-weight-bold mb-2">VISUM ET REPERTUM</h3>
                                <p class="mb-1"><strong>No. VeR:</strong> {{ $visumExit->nomor_ver }}</p>
                            </div>
                        </div>

                        <!-- Basic Information Section -->
                        <div class="mb-4 print-section">
                            <div class="card-header">
                                <i class="ti-calendar"></i> Informasi Dasar Pemeriksaan
                            </div>
                            <div class="card-body">
                                <div class="datetime-container">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="tanggal" class="form-label">Tanggal Pemeriksaan</label>
                                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                                    value="{{ $visumExit->tanggal ? $visumExit->tanggal->format('Y-m-d') : '' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="jam" class="form-label">Jam Pemeriksaan</label>
                                                <input type="time" class="form-control" id="jam" name="jam"
                                                    value="{{ $visumExit->jam ? \Carbon\Carbon::parse($visumExit->jam)->format('H:i') : '' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                            <div class="mb-3">
                                                <label for="nomor_ver" class="form-label">Nomor VeR</label>
                                                <input type="text" class="form-control" id="nomor_ver" name="nomor_ver"
                                                    value="{{ $visumExit->nomor_ver }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="mb-3">
                                            <label for="permintaan" class="form-label">Permintaan Dari</label>
                                            <textarea class="form-control" id="permintaan" name="permintaan" rows="3"
                                                disabled>{{ $visumExit->permintaan }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="mb-3">
                                            <label for="nomor_surat" class="form-label">Nomor Surat</label>
                                            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat"
                                                value="{{ $visumExit->nomor_surat }}" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="registrasi" class="form-label">Nomor Registrasi</label>
                                            <input type="text" class="form-control" id="registrasi" name="registrasi"
                                                value="{{ $visumExit->registrasi }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="menerangkan" class="form-label">Menerangkan pada tanggal</label>
                                    <textarea class="form-control" id="menerangkan" name="menerangkan" rows="2"
                                        disabled>{{ $visumExit->menerangkan }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Patient Information Section -->
                        <div class="mb-4 print-section">
                            <div class="card-header">
                                <i class="ti-user"></i> Data Pasien/Korban
                            </div>
                            <div class="card-body">
                                <div class="patient-info-card">
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Nama</span>
                                        <span class="patient-info-value" style="margin-left: 25px">:
                                            {{ $dataMedis->pasien->nama ?? '-' }}</span>
                                    </div>
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Tempat/Tanggal Lahir</span>
                                        <span class="patient-info-value" style="margin-left: 25px">:
                                            {{ $dataMedis->pasien->tempat_lahir ?? '-' }} /
                                            ({{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : 'Tidak Diketahui' }})
                                        </span>
                                    </div>
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Jenis Kelamin</span>
                                        <span class="patient-info-value" style="margin-left: 25px">:
                                            {{ $dataMedis->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                    </div>
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Suku/Agama</span>
                                        <span class="patient-info-value" style="margin-left: 25px">:
                                            {{ $dataMedis->pasien->suku->suku ?? '-' }} /
                                            {{ $dataMedis->pasien->agama->agama ?? '-' }}</span>
                                    </div>
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Pekerjaan</span>
                                        <span class="patient-info-value" style="margin-left: 25px">:
                                            {{ $dataMedis->pasien->pekerjaan->pekerjaan ?? '-' }}</span>
                                    </div>
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Alamat</span>
                                        <span class="patient-info-value" style="margin-left: 25px">:
                                            {{ $dataMedis->pasien->alamat ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Interview Section -->
                        @if($visumExit->wawancara)
                            <div class="mb-4 print-section">
                                <div class="card-header">
                                    <i class="ti-comment"></i> WAWANCARA
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="wawancara" class="form-label fw-bold">Hasil Wawancara</label>
                                        <div class="trix-editor" contenteditable="false">
                                            {!! $visumExit->wawancara !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- External Examination Section -->
                        <div class="mb-4 print-section">
                            <div class="card-header">
                                <i class="ti-search"></i> PEMERIKSAAN LUAR
                            </div>
                            <div class="card-body">
                                <div class="examination-section">
                                    @if($visumExit->label_mayat)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Label Mayat</label>
                                            <div class="trix-editor" contenteditable="false">
                                                {!! $visumExit->label_mayat !!}
                                            </div>
                                        </div>
                                    @endif

                                    @if($visumExit->pembungkus_mayat)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pembungkus Mayat</label>
                                            <div class="trix-editor" contenteditable="false">
                                                {!! $visumExit->pembungkus_mayat !!}
                                            </div>
                                        </div>
                                    @endif

                                    @if($visumExit->benda_disamping)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Benda di Samping Mayat</label>
                                            <div class="trix-editor" contenteditable="false">
                                                {!! $visumExit->benda_disamping !!}
                                            </div>
                                        </div>
                                    @endif

                                    @if($visumExit->penutup_mayat)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Penutup Mayat</label>
                                            <div class="trix-editor" contenteditable="false">
                                                {!! $visumExit->penutup_mayat !!}
                                            </div>
                                        </div>
                                    @endif

                                    @if($visumExit->pakaian_mayat)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pakaian Mayat</label>
                                            <div class="trix-editor" contenteditable="false">
                                                {!! $visumExit->pakaian_mayat !!}
                                            </div>
                                        </div>
                                    @endif

                                    @if($visumExit->perhiasan_mayat)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Perhiasan Mayat</label>
                                            <div class="trix-editor" contenteditable="false">
                                                {!! $visumExit->perhiasan_mayat !!}
                                            </div>
                                        </div>
                                    @endif

                                    @if($visumExit->identifikasi_umum)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Identifikasi Umum</label>
                                            <div class="trix-editor" contenteditable="false">
                                                {!! $visumExit->identifikasi_umum !!}
                                            </div>
                                        </div>
                                    @endif

                                    @if($visumExit->identifikasi_khusus)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Identifikasi Khusus</label>
                                            <div class="trix-editor" contenteditable="false">
                                                {!! $visumExit->identifikasi_khusus !!}
                                            </div>
                                        </div>
                                    @endif

                                    @if($visumExit->tanda_kematian)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tanda-tanda Kematian</label>
                                            <div class="trix-editor" contenteditable="false">
                                                {!! $visumExit->tanda_kematian !!}
                                            </div>
                                        </div>
                                    @endif

                                    @if($visumExit->gigi_geligi)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Gigi-geligi</label>
                                            <div class="trix-editor" contenteditable="false">
                                                {!! $visumExit->gigi_geligi !!}
                                            </div>
                                        </div>
                                    @endif

                                    @if($visumExit->luka_luka)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Luka-luka</label>
                                            <div class="trix-editor" contenteditable="false">
                                                {!! $visumExit->luka_luka !!}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Conclusion Section -->
                        <div class="mb-4 print-section">
                            <div class="card-header">
                                <i class="ti-clipboard"></i> KESIMPULAN
                            </div>
                            <div class="card-body">

                                @if($visumExit->pada_jenazah)
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Pada Jenazah</label>
                                        <div class="trix-editor" contenteditable="false">
                                            {!! $visumExit->pada_jenazah !!}
                                        </div>
                                    </div>
                                @endif

                                @if($visumExit->pemeriksaan_luar_kesimpulan)
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Pada Pemeriksaan Luar</label>
                                        <div class="trix-editor" contenteditable="false">
                                            {!! $visumExit->pemeriksaan_luar_kesimpulan !!}
                                        </div>
                                    </div>
                                @endif

                                @if($visumExit->dijumpai_kesimpulan)
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Dijumpai</label>
                                        <div class="trix-editor" contenteditable="false">
                                            {!! $visumExit->dijumpai_kesimpulan !!}
                                        </div>
                                    </div>
                                @endif

                                @if($visumExit->hasil_kesimpulan)
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Hasil Kesimpulan</label>
                                        <div class="trix-editor" contenteditable="false">
                                            {!! $visumExit->hasil_kesimpulan !!}
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Dokter Pemeriksa</label>
                                            <input type="text" class="form-control"
                                                value="{{ $visumExit->dokter->nama_lengkap ?? $visumExit->dokter_pemeriksa ?? '-' }}"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-wrap justify-content-end mt-4 no-print">
                            <div class="mb-2">
                                <a href="{{ route('forensik.unit.pelayanan.visum-exit.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $visumExit->id]) }}"
                                    class="btn btn-warning mb-2">
                                    <i class="ti-pencil"></i> Edit
                                </a>
                                <a href="{{ route('forensik.unit.pelayanan.visum-exit.print-pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $visumExit->id]) }}" class="btn btn-success mb-2 ms-2" target="_black">
                                    <i class="ti-printer"></i> Cetak PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Disable all Trix editors and hide toolbars
            document.querySelectorAll('trix-editor').forEach(function (editor) {
                editor.setAttribute('contenteditable', 'false');
                editor.style.backgroundColor = '#f8f9fa';
                editor.style.cursor = 'default';

                // Hide toolbar if exists
                const toolbar = editor.previousElementSibling;
                if (toolbar && toolbar.classList.contains('trix-toolbar')) {
                    toolbar.style.display = 'none';
                }
            });

            // Disable all form controls
            document.querySelectorAll('input, select, textarea, button[type="submit"]').forEach(function (element) {
                if (!element.classList.contains('no-disable')) {
                    element.disabled = true;
                }
            });

            // Add readonly attribute to form controls
            document.querySelectorAll('input[type="text"], input[type="date"], input[type="time"], textarea').forEach(function (element) {
                element.readOnly = true;
            });

            // Smooth scroll for long documents
            if (window.location.hash) {
                const target = document.querySelector(window.location.hash);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });

        // Add keyboard shortcuts
        document.addEventListener('keydown', function (e) {
            // Ctrl+P for print
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                printDocument();
            }

            // Ctrl+E for edit
            if (e.ctrlKey && e.key === 'e') {
                e.preventDefault();
                window.location.href = document.querySelector('a[href*="edit"]').href;
            }

            // Escape to go back
            if (e.key === 'Escape') {
                e.preventDefault();
                window.location.href = document.querySelector('a[href*="index"]').href;
            }
        });

        // Add tooltips for better UX
        document.addEventListener('DOMContentLoaded', function () {
            // Add title attributes for accessibility
            document.querySelectorAll('.form-control[disabled]').forEach(function (element) {
                if (element.value) {
                    element.title = element.value;
                }
            });

            // Show completion percentage in different colors
            const completionElements = document.querySelectorAll('.status-badge');
            completionElements.forEach(function (element) {
                const text = element.textContent;
                if (text.includes('Lengkap')) {
                    element.style.background = 'linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%)';
                } else if (text.includes('%')) {
                    const percentage = parseInt(text.match(/\d+/)[0]);
                    if (percentage >= 80) {
                        element.style.background = 'linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%)';
                    } else if (percentage >= 50) {
                        element.style.background = 'linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%)';
                    } else {
                        element.style.background = 'linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%)';
                    }
                }
            });
        });

        // Enhanced print functionality with page breaks
        window.addEventListener('beforeprint', function () {
            // Add page break classes before printing
            document.querySelectorAll('.print-section').forEach(function (section, index) {
                if (index > 0 && index % 2 === 0) {
                    section.style.pageBreakBefore = 'always';
                }
            });
        });

        window.addEventListener('afterprint', function () {
            // Remove page break classes after printing
            document.querySelectorAll('.print-section').forEach(function (section) {
                section.style.pageBreakBefore = 'auto';
            });
        });
    </script>
@endpush
