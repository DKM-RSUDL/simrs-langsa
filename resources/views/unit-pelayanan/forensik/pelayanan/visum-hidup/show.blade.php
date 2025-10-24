@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <style>
        .trix-editor[contenteditable="false"] {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }
    </style>
@endpush

@section('content')
    @include('unit-pelayanan.forensik.pelayanan.visum-hidup.include-visum-hidup')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.edukasi.include')

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-12 mb-3">
                @include('components.patient-card')
            </div>

            <div class="col-xl-9 col-lg-8 col-md-12">
                <x-content-card>
                    <div class="d-flex gap-2">
                        <x-button-previous />
                        <a target="_blank"
                            href="{{ route('forensik.unit.pelayanan.visum-hidup.print-pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $visumHidup->id]) }}"
                            class="btn btn-info">
                            <i class="fas fa-print me-1"></i> Cetak
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form id="visumHidupShowForm" method="" action="">
                        @csrf


                        <!-- Header Section -->
                        <div class="text-center mb-4">
                            <div class="header-asesmen">
                                <h3 class="font-weight-bold mb-2">DETAIL VISUM HIDUP REPERTUM</h3>
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
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="tanggal" class="form-label">Tanggal Pemeriksaan</label>
                                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                                    value="{{ $visumHidup->tanggal ? $visumHidup->tanggal->format('Y-m-d') : '' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="jam" class="form-label">Jam Pemeriksaan</label>
                                                <input type="time" class="form-control" id="jam" name="jam"
                                                    value="{{ $visumHidup->jam ? \Carbon\Carbon::parse($visumHidup->jam)->format('H:i') : '' }}"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                            <div class="mb-3">
                                                <label for="nomor_ver" class="form-label">Nomor VeR</label>
                                                <input type="text" class="form-control" id="nomor_ver" name="nomor_ver"
                                                    placeholder="VeR/003/I/2025" value="{{ $visumHidup->nomor_ver }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="mb-3">
                                            <label for="permintaan" class="form-label">Permintaan Dari</label>
                                            <textarea class="form-control" id="permintaan" name="permintaan" rows="3" placeholder="Kepolisian Resor Langsa"
                                                disabled>{{ $visumHidup->permintaan }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="mb-3">
                                            <label for="nomor_surat" class="form-label">Nomor Surat</label>
                                            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat"
                                                placeholder="B/49/XII/2024/LL" value="{{ $visumHidup->nomor_surat }}"
                                                disabled>
                                        </div>
                                        <div class="mb-3">
                                            <input type="hidden" class="form-control" id="registrasi" name="registrasi"
                                                value="{{ $visumHidup->registrasi }}" readonly disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="menerangkan" class="form-label">Menerangkan pada tanggal</label>
                                    <textarea class="form-control" id="menerangkan" name="menerangkan" rows="2"
                                        placeholder="Menerangkan pada tanggal..." disabled>{{ $visumHidup->menerangkan }}</textarea>
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
                                        <span class="patient-info-value" style="margin-left: 25px">:
                                            {{ $dataMedis->pasien->nama ?? '-' }}</span>
                                    </div>
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Umur</span>
                                        <span class="patient-info-value" style="margin-left: 25px">:
                                            {{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Tahun
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
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">No. Rekam Medis</span>
                                        <span class="patient-info-value" style="margin-left: 25px">:
                                            {{ $dataMedis->pasien->kd_pasien ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Examination Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="ti-comment"></i> HASIL PEMERIKSAAN
                            </div>
                            @if ($visumHidup->hasil_pemeriksaan)
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Hasil Pemeriksaan</label>
                                        <div class="trix-editor" contenteditable="false">
                                            {!! $visumHidup->hasil_pemeriksaan !!}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Conclusion Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="ti-clipboard"></i> KESIMPULAN
                            </div>
                            <div class="card-body">
                                @if ($visumHidup->hasil_kesimpulan)
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Hasil Kesimpulan</label>
                                            <div class="trix-editor" contenteditable="false">
                                                {!! $visumHidup->hasil_kesimpulan !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="dokter_pemeriksa" class="form-label fw-bold">Dokter
                                                Pemeriksa</label>
                                            <select id="dokter_pemeriksa" name="dokter_pemeriksa" class="form-select"
                                                disabled>
                                                <option value="">--Pilih Dokter Pemeriksa--</option>
                                                @foreach ($dokter as $item)
                                                    <option value="{{ $item->kd_dokter }}"
                                                        {{ $visumHidup->dokter_pemeriksa == $item->kd_dokter ? 'selected' : '' }}>
                                                        {{ $item->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
        </form>
        </x-content-card>
    </div>
    </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle disabled Trix editors
            document.addEventListener('trix-before-initialize', function(event) {
                const editor = event.target;

                // Check if this is a disabled editor
                if (editor.classList.contains('disabled-editor')) {
                    // Prevent normal initialization
                    event.preventDefault();

                    // Get the content from hidden input
                    const input = document.querySelector(`input[id="${editor.getAttribute('input')}"]`);
                    const content = input ? input.value : '';

                    // Set content directly and make it read-only
                    editor.innerHTML = content || '<div>Tidak ada data</div>';
                    editor.setAttribute('contenteditable', 'false');
                    editor.style.minHeight = '120px';
                    editor.style.backgroundColor = '#f8f9fa';
                    editor.style.border = '1px solid #e9ecef';
                    editor.style.color = '#495057';
                    editor.style.cursor = 'not-allowed';
                    editor.style.padding = '10px';

                    // Hide the toolbar
                    const toolbar = editor.previousElementSibling;
                    if (toolbar && toolbar.classList.contains('trix-toolbar')) {
                        toolbar.classList.add('trix-toolbar-disabled');
                    }
                }
            });

            // Initialize normal Trix editors (if any)
            document.addEventListener('trix-initialize', function(event) {
                const editor = event.target;

                // Only style non-disabled editors
                if (!editor.classList.contains('disabled-editor')) {
                    editor.style.minHeight = '120px';

                    // Style the toolbar
                    const toolbarElement = editor.previousElementSibling;
                    if (toolbarElement && toolbarElement.classList.contains('trix-toolbar')) {
                        toolbarElement.style.border = '1px solid #ced4da';
                        toolbarElement.style.borderBottom = 'none';
                        toolbarElement.style.borderRadius = '4px 4px 0 0';
                        toolbarElement.style.backgroundColor = '#f8f9fa';
                    }
                }
            });

            // Prevent any interaction with disabled editors
            document.addEventListener('click', function(event) {
                if (event.target.closest('.disabled-editor')) {
                    event.preventDefault();
                    event.stopPropagation();
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.target.closest('.disabled-editor')) {
                    event.preventDefault();
                    event.stopPropagation();
                }
            });
        });
    </script>
@endpush
