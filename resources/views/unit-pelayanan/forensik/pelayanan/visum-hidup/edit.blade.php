@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
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
                <div class="mb-3">
                    <a href="{{ route('forensik.unit.pelayanan.visum-hidup.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" class="btn btn-outline-primary">
                        <i class="ti-arrow-left"></i> <span class="d-none d-sm-inline">Kembali</span>
                    </a>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form id="visumHidupEditForm" method="POST"
                    action="{{ route('forensik.unit.pelayanan.visum-hidup.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $visumHidup->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <!-- Header Section -->
                            <div class="text-center mb-4">
                                <div class="header-asesmen">
                                    <h3 class="font-weight-bold mb-2">EDIT VISUM HIDUP REPERTUM</h3>
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
                                                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                                           id="tanggal" name="tanggal"
                                                           value="{{ old('tanggal', $visumHidup->tanggal ? $visumHidup->tanggal->format('Y-m-d') : '') }}" required>
                                                    @error('tanggal')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="mb-3">
                                                    <label for="jam" class="form-label">Jam Pemeriksaan</label>
                                                    <input type="time" class="form-control @error('jam') is-invalid @enderror" 
                                                           id="jam" name="jam"
                                                           value="{{ old('jam', $visumHidup->jam ? \Carbon\Carbon::parse($visumHidup->jam)->format('H:i') : '') }}" required>
                                                    @error('jam')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <div class="mb-3">
                                                    <label for="nomor_ver" class="form-label">Nomor VeR</label>
                                                    <input type="text" class="form-control @error('nomor_ver') is-invalid @enderror" 
                                                           id="nomor_ver" name="nomor_ver"
                                                           placeholder="VeR/003/I/2025" 
                                                           value="{{ old('nomor_ver', $visumHidup->nomor_ver) }}" required>
                                                    @error('nomor_ver')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="mb-3">
                                                <label for="permintaan" class="form-label">Permintaan Dari</label>
                                                <textarea class="form-control @error('permintaan') is-invalid @enderror" 
                                                          id="permintaan" name="permintaan" rows="3"
                                                          placeholder="Kepolisian Resor Langsa">{{ old('permintaan', $visumHidup->permintaan) }}</textarea>
                                                @error('permintaan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="mb-3">
                                                <label for="nomor_surat" class="form-label">Nomor Surat</label>
                                                <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" 
                                                       id="nomor_surat" name="nomor_surat"
                                                       placeholder="B/49/XII/2024/LL" value="{{ old('nomor_surat', $visumHidup->nomor_surat) }}">
                                                @error('nomor_surat')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <input type="hidden" class="form-control" id="registrasi" name="registrasi"
                                                       value="{{ old('registrasi', $visumHidup->registrasi) }}" readonly>
                                                @error('registrasi')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="menerangkan" class="form-label">Menerangkan pada tanggal</label>
                                        <textarea class="form-control @error('menerangkan') is-invalid @enderror" 
                                                  id="menerangkan" name="menerangkan" rows="2"
                                                  placeholder="Menerangkan pada tanggal...">{{ old('menerangkan', $visumHidup->menerangkan) }}</textarea>
                                        @error('menerangkan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                            <span class="patient-info-label">Umur</span>
                                            <span class="patient-info-value" style="margin-left: 25px">: 
                                                {{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Tahun
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
                                        <div class="patient-info-item">
                                            <span class="patient-info-label">No. Rekam Medis</span>
                                            <span class="patient-info-value" style="margin-left: 25px">: {{ $dataMedis->pasien->kd_pasien ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Examination Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="ti-comment"></i> HASIL PEMERIKSAAN
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="hasil_pemeriksaan" class="form-label fw-bold">Hasil Pemeriksaan</label>
                                        <input id="hasil_pemeriksaan" type="hidden" name="hasil_pemeriksaan" 
                                               value="{{ old('hasil_pemeriksaan', $visumHidup->hasil_pemeriksaan) }}">
                                        <trix-editor input="hasil_pemeriksaan"
                                            placeholder="Masukkan hasil pemeriksaan dengan keluarga/saksi..."></trix-editor>
                                        @error('hasil_pemeriksaan')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
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
                                        <label for="hasil_kesimpulan" class="form-label fw-bold">Hasil Kesimpulan</label>
                                        <input id="hasil_kesimpulan" type="hidden" name="hasil_kesimpulan"
                                               value="{{ old('hasil_kesimpulan', $visumHidup->hasil_kesimpulan) }}">
                                        <trix-editor input="hasil_kesimpulan"
                                            placeholder="Kesimpulan akhir mengenai perkiraan lama kematian, cara kematian, dan penyebab kematian..."></trix-editor>
                                        @error('hasil_kesimpulan')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="dokter_pemeriksa" class="form-label fw-bold">Dokter Pemeriksa</label>
                                                <select id="dokter_pemeriksa" name="dokter_pemeriksa" 
                                                        class="form-select @error('dokter_pemeriksa') is-invalid @enderror" required>
                                                    <option value="">--Pilih Dokter Pemeriksa--</option>
                                                    @foreach ($dokter as $item)
                                                        <option value="{{ $item->kd_dokter }}" 
                                                                {{ old('dokter_pemeriksa', $visumHidup->dokter_pemeriksa) == $item->kd_dokter ? 'selected' : '' }}>
                                                            {{ $item->nama_lengkap }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('dokter_pemeriksa')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex flex-wrap justify-content-between mt-4">
                                <div class="mb-2">
                                    <a href="{{ route('forensik.unit.pelayanan.visum-hidup.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $visumHidup->id]) }}" 
                                       class="btn btn-info mb-2">
                                        <i class="ti-eye"></i> Lihat Detail
                                    </a>
                                </div>
                                <div class="mb-2">
                                    <button type="submit" class="btn btn-primary mb-2">
                                        <i class="ti-save"></i> Update
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
                
                // Style the toolbar
                const toolbarElement = editor.previousElementSibling;
                if (toolbarElement && toolbarElement.classList.contains('trix-toolbar')) {
                    toolbarElement.style.border = '1px solid #ced4da';
                    toolbarElement.style.borderBottom = 'none';
                    toolbarElement.style.borderRadius = '4px 4px 0 0';
                    toolbarElement.style.backgroundColor = '#f8f9fa';
                }
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
        });
    </script>
@endpush