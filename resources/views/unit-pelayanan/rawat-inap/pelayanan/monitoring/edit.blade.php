@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
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

            .invalid-feedback {
                display: none;
            }

            .is-invalid~.invalid-feedback {
                display: block;
            }

            .form-section {
                max-width: 100%;
            }
            /* Tambahkan CSS ini di bagian style yang sudah ada di edit form */

            .konsulen-item {
                position: relative;
            }

            .konsulen-item .input-group {
                display: flex;
                align-items: stretch;
            }

            .konsulen-item .form-select {
                flex: 1;
            }

            .konsulen-item .btn {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                z-index: 1;
            }

            .select2-konsulen + .select2-container {
                width: calc(100% - 42px) !important;
            }

            .konsulen-item .input-group .select2-container {
                flex: 1;
            }

            .konsulen-item .input-group .select2-container .select2-selection {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
                height: calc(2.25rem + 2px);
                border-right: 0;
            }

            .konsulen-item .input-group .btn {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }

        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        {{-- Dynamic Title Based on kd_unit --}}
        @php
            $unitTitles = [
                '10015' => 'Monitoring Intensive Coronary Care Unit (ICCU)',
                '10016' => 'Monitoring Intensive Care Unit (ICU)',
                '10131' => 'Monitoring Neonatal Intensive Care Unit (NICU)',
                '10132' => 'Monitoring Pediatric Intensive Care Unit (PICU)',
            ];
            $title = isset($unitTitles[$dataMedis->kd_unit])
                ? $unitTitles[$dataMedis->kd_unit]
                : 'Monitoring Intensive Care';
        @endphp

        @php
        $unitTitlesss = [
            '10015' => 'ICCU',
            '10016' => 'ICU',
            '10131' => 'NICU',
            '10132' => 'PICU',
        ];
        $subTitle = isset($unitTitlesss[$dataMedis->kd_unit])
            ? $unitTitlesss[$dataMedis->kd_unit]
            : 'Monitoring Intensive Care';
        @endphp

        <div class="col-md-9">
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Edit {{ $title }}</h5>
            </div>

            <hr>

            <div class="form-section">
                <form action="{{ route('rawat-inap.monitoring.update', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                                'id' => $monitoring->id
                            ]) }}" method="post" id="iccuForm">
                    @csrf
                    @method('PUT')

                    <!-- Form Date and Time Section with Validation -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-12 mb-3">
                                    <div class="d-flex justify-content-between">
                                        <small class="text-warning">
                                            <i class="bi bi-exclamation-triangle-fill"></i>
                                            Pastikan jam diisi dengan benar untuk keakuratan dokumentasi medis
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold required">Tanggal Implementasi</label>
                                        <input type="date" class="form-control" name="tgl_implementasi"
                                            id="tgl_implementasi" value="{{ $monitoring->tgl_implementasi }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold required">Jam Implementasi</label>
                                        <div class="input-group">
                                            <input type="time" class="form-control" name="jam_implementasi"
                                                id="jam_implementasi" value="{{ \Carbon\Carbon::parse($monitoring->jam_implementasi)->format('H:i') }}" required>
                                            <div class="invalid-feedback" id="timeError">
                                                Pastikan format jam benar (HH:MM)
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Patient Information Section -->
                    <!-- Patient Information Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="bi bi-person-lines-fill me-2"></i>
                                Informasi Pasien
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info mb-3 mt-3" role="alert">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                <small>Data di bawah ini diambil dari pengisian terakhir. Jangan diubah jika tidak diperlukan.</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    @if(in_array($dataMedis->kd_unit, ['10015', '10016', '10132']))
                                        <div class="mb-3">
                                            <label class="form-label fw-bold required">Indikasi {{ $subTitle }}</label>
                                            <textarea class="form-control bg-light" name="indikasi_iccu" rows="3" required>{{ $monitoring->indikasi_iccu }}</textarea>
                                        </div>
                                    @endif
                                </div>

                                {{-- Field khusus untuk NICU --}}
                                @if($dataMedis->kd_unit == '10131')
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Hari Rawat Ke-</label>
                                                    <div class="input-group">
                                                        <input type="number" min="1" class="form-control bg-light" name="hari_rawat" value="{{ $monitoring->hari_rawat ?? '' }}">
                                                        <span class="input-group-text bg-light" data-bs-toggle="tooltip" title="Hari Rawat Kunjungan">
                                                            <i class="bi bi-info-circle"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Usia Kelahiran</label>
                                                    <div class="input-group">
                                                        <input type="number" min="0" max="365" class="form-control bg-light" name="usia_kelahiran" placeholder="Hari" value="{{ $monitoring->usia_kelahiran ?? '' }}">
                                                        <span class="input-group-text">hari</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Umur Bayi</label>
                                                    <div class="input-group">
                                                        <input type="number" min="0" max="365" class="form-control bg-light" name="umur_bayi" placeholder="Hari" value="{{ $monitoring->umur_bayi ?? '' }}">
                                                        <span class="input-group-text">hari</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Umur Gestasi</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control bg-light" name="umur_gestasi" placeholder="Minggu" value="{{ $monitoring->umur_gestasi ?? '' }}">
                                                        <span class="input-group-text">minggu</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Berat Badan Lahir</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.1" class="form-control bg-light" name="berat_badan_lahir" placeholder="Berat lahir" value="{{ $monitoring->berat_badan_lahir ?? '' }}">
                                                        <span class="input-group-text">gram</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Cara Persalinan</label>
                                                    <select class="form-select bg-light" name="cara_persalinan">
                                                        <option value="">- Pilih Cara Persalinan -</option>
                                                        <option value="Normal" {{ ($monitoring->cara_persalinan ?? '') == 'Normal' ? 'selected' : '' }}>Normal/Spontan</option>
                                                        <option value="Vacuum" {{ ($monitoring->cara_persalinan ?? '') == 'Vacuum' ? 'selected' : '' }}>Vacuum</option>
                                                        <option value="Forceps" {{ ($monitoring->cara_persalinan ?? '') == 'Forceps' ? 'selected' : '' }}>Forceps</option>
                                                        <option value="SC" {{ ($monitoring->cara_persalinan ?? '') == 'SC' ? 'selected' : '' }}>Sectio Caesarea (SC)</option>
                                                        <option value="Prematur" {{ ($monitoring->cara_persalinan ?? '') == 'Prematur' ? 'selected' : '' }}>Prematur</option>
                                                        <option value="Lainnya" {{ ($monitoring->cara_persalinan ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                {{-- End field khusus NICU --}}

                                @if(in_array($dataMedis->kd_unit, ['10015', '10016', '10132']))
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Berat Badan (kg)</label>
                                                    <input type="number" step="0.1" min="0" class="form-control bg-light" name="berat_badan" placeholder="kg" value="{{ $monitoring->berat_badan ? number_format($monitoring->berat_badan, 1) : '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Tinggi Badan (cm)</label>
                                                    <input type="number" step="1" min="0" class="form-control bg-light" name="tinggi_badan" placeholder="cm" value="{{ $monitoring->tinggi_badan ? number_format($monitoring->tinggi_badan, 0) : '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Hari Rawat Ke-</label>
                                                    <div class="input-group">
                                                        <input type="number" min="1" class="form-control bg-light" name="hari_rawat" value="{{ $monitoring->hari_rawat ?? '' }}">
                                                        <span class="input-group-text bg-light" data-bs-toggle="tooltip" title="Hari Rawat Kunjungan">
                                                            <i class="bi bi-info-circle"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold required">Diagnosa</label>
                                                    <input type="text" class="form-control bg-light" name="diagnosa" value="{{ $monitoring->diagnosa }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label class="form-label fw-bold" for="alergi">Alergi</label>
                                    <div class="input-group">
                                        <input type="text" name="alergi_display" id="alergi_display" class="form-control" placeholder="Alergi pasien (jika ada)" value="{{ $allergiesDisplay ?? '' }}" readonly>
                                        <input type="hidden" name="alergi" id="alergi" value="{{ $allergiesJson ?? '' }}">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#alergiModal">
                                            <i class="ti-plus"></i> Tambah Alergi
                                        </button>
                                    </div>
                                </div>
                                @include('unit-pelayanan.rawat-inap.pelayanan.monitoring.alergi')
                            </div>
                            
                            <!-- Informasi Tenaga Medis -->
                            <!-- Informasi Tenaga Medis - Updated untuk Semua Unit -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h6 class="mb-3 border-bottom pb-2 fw-bold">
                                        <i class="bi bi-people-fill me-1"></i> Informasi Tenaga Medis
                                    </h6>
                                </div>

                                <!-- Dokter (Single Selection) -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Dokter</label>
                                        <select class="form-select select2 bg-light" style="width: 100%" name="dokter">
                                            <option value="">- Pilih -</option>
                                            @foreach ($dokter as $d)
                                                <option value="{{ $d->kd_dokter }}"
                                                    {{ $monitoring->dokter == $d->kd_dokter ? 'selected' : '' }}>
                                                    {{ $d->nama_lengkap }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Konsulen (Multiple Selection) -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Konsulen</label>
                                        <div id="konsulen-container">
                                            @if(isset($monitoring->konsulen_array) && count($monitoring->konsulen_array) > 0)
                                                @foreach($monitoring->konsulen_array as $index => $konsulenId)
                                                    <div class="konsulen-item mb-2" data-index="{{ $index }}">
                                                        <div class="input-group">
                                                            <select name="konsulen[]" class="form-select select2-konsulen bg-light">
                                                                <option value="">- Pilih -</option>
                                                                @foreach ($dokter as $d)
                                                                    <option value="{{ $d->kd_dokter }}" 
                                                                        {{ $konsulenId == $d->kd_dokter ? 'selected' : '' }}>
                                                                        {{ $d->nama_lengkap }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <button type="button" class="btn btn-outline-danger remove-konsulen" 
                                                                    {{ $index == 0 ? 'style=display:none;' : '' }}>
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="konsulen-item mb-2" data-index="0">
                                                    <div class="input-group">
                                                        <select name="konsulen[]" class="form-select select2-konsulen bg-light">
                                                            <option value="">- Pilih -</option>
                                                            @foreach ($dokter as $d)
                                                                <option value="{{ $d->kd_dokter }}">{{ $d->nama_lengkap }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" class="btn btn-outline-danger remove-konsulen" style="display: none;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-konsulen">
                                            <i class="bi bi-plus"></i> Tambah Konsulen
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Monitoring ICCU Parameters -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">
                                <i class="bi bi-heart-pulse-fill me-2"></i>
                                Monitoring {{ $subTitle }} Parameters
                            </h6>
                        </div>
                        <div class="card-body mt-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label required">Sistolik (mmHg)</label>
                                        <input type="number" class="form-control" name="sistolik" id="sistolik"
                                            value="{{ $monitoring->detail->sistolik ? number_format($monitoring->detail->sistolik, 0) : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Diastolik (mmHg)</label>
                                        <input type="number" class="form-control" name="diastolik" id="diastolik"
                                            value="{{ $monitoring->detail->diastolik ? number_format($monitoring->detail->diastolik, 0) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">MAP</label>
                                        <input type="number" class="form-control" name="map" id="map"
                                            value="{{ $monitoring->detail->map ? number_format($monitoring->detail->map, 0) : '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Heart Rate (HR) <small>bpm</small></label>
                                        <input type="number" class="form-control" name="hr"
                                            value="{{ $monitoring->detail->hr ? number_format($monitoring->detail->hr, 0) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Resp. Rate (RR) <small>x/menit</small></label>
                                        <input type="number" class="form-control" name="rr"
                                            value="{{ $monitoring->detail->rr ? number_format($monitoring->detail->rr, 0) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Suhu (°C)</label>
                                        <input type="number" step="0.1" class="form-control" name="temp"
                                            value="{{ $monitoring->detail->temp ? number_format($monitoring->detail->temp, 1) : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">CVP (Cm H2O)</label>
                                        <input type="number" step="0.1" class="form-control" name="cvp"
                                            value="{{ $monitoring->detail->cvp ? number_format($monitoring->detail->cvp, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">EKG Record</label>
                                        <select class="form-select" name="ekg_record">
                                            <option value="">- Pilih -</option>
                                            <option value="1" {{ $monitoring->detail->ekg_record == 'Ada' ? 'selected' : '' }}>Ada</option>
                                            <option value="2" {{ $monitoring->detail->ekg_record == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Therapy Obat Input -->
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="bi bi-capsule me-2"></i>
                                Pemberian Terapi Obat
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info mb-3 mt-3" role="alert">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                Masukkan jumlah obat yang diberikan dalam satuan cc/ml untuk setiap terapi obat yang telah ditambahkan.
                            </div>

                            <!-- Terapi Oral -->
                            <div class="mb-4">
                                <h6 class="mb-3 border-bottom pb-2 fw-bold">Terapi Oral</h6>
                                @if ($therapies->where('jenis_terapi', 1)->isEmpty())
                                    <div class="text-center text-muted">
                                        Tidak ada obat untuk jenis terapi ini.
                                    </div>
                                @else
                                    <div class="row">
                                        @foreach ($therapies->where('jenis_terapi', 1) as $therapy)
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">{{ $therapy->nama_obat }}</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.1" min="0" class="form-control"
                                                            name="therapy_doses[{{ $therapy->id }}]"
                                                            value="{{ $therapy->dose ? number_format($therapy->dose->nilai, 1) : '' }}"
                                                            placeholder="Jumlah dalam cc/ml">
                                                        <span class="input-group-text">cc/ml</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <!-- Terapi Injeksi -->
                            <div class="mb-4">
                                <h6 class="mb-3 border-bottom pb-2 fw-bold">Terapi Injeksi</h6>
                                @if ($therapies->where('jenis_terapi', 2)->isEmpty())
                                    <div class="text-center text-muted">
                                        Tidak ada obat untuk jenis terapi ini.
                                    </div>
                                @else
                                    <div class="row">
                                        @foreach ($therapies->where('jenis_terapi', 2) as $therapy)
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">{{ $therapy->nama_obat }}</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.1" min="0" class="form-control"
                                                            name="therapy_doses[{{ $therapy->id }}]"
                                                            value="{{ $therapy->dose ? number_format($therapy->dose->nilai, 1) : '' }}"
                                                            placeholder="Jumlah dalam cc/ml">
                                                        <span class="input-group-text">cc/ml</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <!-- Terapi Drip -->
                            <div class="mb-4">
                                <h6 class="mb-3 border-bottom pb-2 fw-bold">Terapi Drip</h6>
                                @if ($therapies->where('jenis_terapi', 3)->isEmpty())
                                    <div class="text-center text-muted">
                                        Tidak ada obat untuk jenis terapi ini.
                                    </div>
                                @else
                                    <div class="row">
                                        @foreach ($therapies->where('jenis_terapi', 3) as $therapy)
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">{{ $therapy->nama_obat }}</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.1" min="0" class="form-control"
                                                            name="therapy_doses[{{ $therapy->id }}]"
                                                            value="{{ $therapy->dose ? number_format($therapy->dose->nilai, 1) : '' }}"
                                                            placeholder="Jumlah dalam cc/ml">
                                                        <span class="input-group-text">cc/ml</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <!-- Terapi Cairan -->
                            <div class="mb-4">
                                <h6 class="mb-3 border-bottom pb-2 fw-bold">Terapi Cairan</h6>
                                @if ($therapies->where('jenis_terapi', 4)->isEmpty())
                                    <div class="text-center text-muted">
                                        Tidak ada obat untuk jenis terapi ini.
                                    </div>
                                @else
                                    <div class="row">
                                        @foreach ($therapies->where('jenis_terapi', 4) as $therapy)
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">{{ $therapy->nama_obat }}</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.1" min="0" class="form-control"
                                                            name="therapy_doses[{{ $therapy->id }}]"
                                                            value="{{ $therapy->dose ? number_format($therapy->dose->nilai, 1) : '' }}"
                                                            placeholder="Jumlah dalam cc/ml">
                                                        <span class="input-group-text">cc/ml</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="mb-3 border-bottom pb-2">Enteral</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Oral</label>
                                        <input type="number" step="1" class="form-control" name="oral" value="{{ $monitoring->detail->oral }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">NGT</label>
                                        <input type="number" step="1" class="form-control" name="ngt" value="{{ $monitoring->detail->ngt }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Output -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="mb-3 border-bottom pb-2">Output</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">BAB (x)</label>
                                        <input type="nunmber" class="form-control" name="bab" value="{{ $monitoring->detail->bab }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Urine (ml)</label>
                                        <input type="nunmber" class="form-control" name="urine" value="{{ $monitoring->detail->urine }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">IWL (ml)</label>
                                        <input type="nunmber" class="form-control" name="iwl" value="{{ $monitoring->detail->iwl }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Muntahan/CMS (ml)</label>
                                        <input type="nunmber" class="form-control" name="muntahan_cms" value="{{ $monitoring->detail->muntahan_cms }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Drain (ml)</label>
                                        <input type="nunmber" class="form-control" name="drain" value="{{ $monitoring->detail->drain }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Neurologis Section (GCS and Pupil) -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- GCS Section -->
                            <h6 class="mb-3 border-bottom pb-2">Glasgow Coma Scale (GCS)</h6>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Respon Mata (E)</label>
                                        <select class="form-select gcs-component" name="gcs_eye" id="gcs_eye">
                                            <option value="">- Pilih -</option>
                                            <option value="4" {{ $monitoring->detail->gcs_eye == 4 ? 'selected' : '' }}>4 - Spontan</option>
                                            <option value="3" {{ $monitoring->detail->gcs_eye == 3 ? 'selected' : '' }}>3 - Terhadap Suara</option>
                                            <option value="2" {{ $monitoring->detail->gcs_eye == 2 ? 'selected' : '' }}>2 - Terhadap Nyeri</option>
                                            <option value="1" {{ $monitoring->detail->gcs_eye == 1 ? 'selected' : '' }}>1 - Tidak Ada Respon</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Respon Verbal (V)</label>
                                        <select class="form-select gcs-component" name="gcs_verbal" id="gcs_verbal">
                                            <option value="">- Pilih -</option>
                                            <option value="5" {{ $monitoring->detail->gcs_verbal == 5 ? 'selected' : '' }}>5 - Orientasi Baik</option>
                                            <option value="4" {{ $monitoring->detail->gcs_verbal == 4 ? 'selected' : '' }}>4 - Bingung</option>
                                            <option value="3" {{ $monitoring->detail->gcs_verbal == 3 ? 'selected' : '' }}>3 - Kata-kata Tidak Jelas</option>
                                            <option value="2" {{ $monitoring->detail->gcs_verbal == 2 ? 'selected' : '' }}>2 - Suara Tidak Jelas</option>
                                            <option value="1" {{ $monitoring->detail->gcs_verbal == 1 ? 'selected' : '' }}>1 - Tidak Ada Respon</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Respon Motorik (M)</label>
                                        <select class="form-select gcs-component" name="gcs_motor" id="gcs_motor">
                                            <option value="">- Pilih -</option>
                                            <option value="6" {{ $monitoring->detail->gcs_motor == 6 ? 'selected' : '' }}>6 - Mengikuti Perintah</option>
                                            <option value="5" {{ $monitoring->detail->gcs_motor == 5 ? 'selected' : '' }}>5 - Melokalisasi Nyeri</option>
                                            <option value="4" {{ $monitoring->detail->gcs_motor == 4 ? 'selected' : '' }}>4 - Withdrawal</option>
                                            <option value="3" {{ $monitoring->detail->gcs_motor == 3 ? 'selected' : '' }}>3 - Fleksi Abnormal</option>
                                            <option value="2" {{ $monitoring->detail->gcs_motor == 2 ? 'selected' : '' }}>2 - Ekstensi Abnormal</option>
                                            <option value="1" {{ $monitoring->detail->gcs_motor == 1 ? 'selected' : '' }}>1 - Tidak Ada Respon</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Total GCS</label>
                                        <input type="number" class="form-control" name="gcs_total" id="gcs_total"
                                            value="{{ $monitoring->detail->gcs_total ?? '' }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Pupil Section -->
                            <h6 class="mb-3 border-bottom pb-2">Status Pupil</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pupil Kanan</label>
                                        <select class="form-select" name="pupil_kanan">
                                            <option value="">- Pilih -</option>
                                            <option value="isokor" {{ $monitoring->detail->pupil_kanan == 'isokor' ? 'selected' : '' }}>Isokor</option>
                                            <option value="anisokor" {{ $monitoring->detail->pupil_kanan == 'anisokor' ? 'selected' : '' }}>Anisokor</option>
                                            <option value="midriasis" {{ $monitoring->detail->pupil_kanan == 'midriasis' ? 'selected' : '' }}>Midriasis</option>
                                            <option value="miosis" {{ $monitoring->detail->pupil_kanan == 'miosis' ? 'selected' : '' }}>Miosis</option>
                                            <option value="pinpoint" {{ $monitoring->detail->pupil_kanan == 'pinpoint' ? 'selected' : '' }}>Pinpoint</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pupil Kiri</label>
                                        <select class="form-select" name="pupil_kiri">
                                            <option value="">- Pilih -</option>
                                            <option value="isokor" {{ $monitoring->detail->pupil_kiri == 'isokor' ? 'selected' : '' }}>Isokor</option>
                                            <option value="anisokor" {{ $monitoring->detail->pupil_kiri == 'anisokor' ? 'selected' : '' }}>Anisokor</option>
                                            <option value="midriasis" {{ $monitoring->detail->pupil_kiri == 'midriasis' ? 'selected' : '' }}>Midriasis</option>
                                            <option value="miosis" {{ $monitoring->detail->pupil_kiri == 'miosis' ? 'selected' : '' }}>Miosis</option>
                                            <option value="pinpoint" {{ $monitoring->detail->pupil_kiri == 'pinpoint' ? 'selected' : '' }}>Pinpoint</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AGD and Other Parameters -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- AGD Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Analisis Gas Darah (AGD)</h6>
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">pH</label>
                                        <input type="number" step="0.01" class="form-control" name="ph"
                                            value="{{ $monitoring->detail->ph ? number_format($monitoring->detail->ph, 2) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">PO<sub>2</sub> (mmHg)</label>
                                        <input type="number" step="0.1" class="form-control" name="po2"
                                            value="{{ $monitoring->detail->po2 ? number_format($monitoring->detail->po2, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">PCO<sub>2</sub> (mmHg)</label>
                                        <input type="number" step="0.1" class="form-control" name="pco2"
                                            value="{{ $monitoring->detail->pco2 ? number_format($monitoring->detail->pco2, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">BE (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="be"
                                            value="{{ $monitoring->detail->be ? number_format($monitoring->detail->be, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">HCO<sub>3</sub> (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="hco3"
                                            value="{{ $monitoring->detail->hco3 ? number_format($monitoring->detail->hco3, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Saturasi O<sub>2</sub> (%)</label>
                                        <input type="number" step="0.1" class="form-control" name="saturasi_o2"
                                            value="{{ $monitoring->detail->saturasi_o2 ? number_format($monitoring->detail->saturasi_o2, 1) : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Elektrolit Parameters -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Na (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="na"
                                            value="{{ $monitoring->detail->na ? number_format($monitoring->detail->na, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">K (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="k"
                                            value="{{ $monitoring->detail->k ? number_format($monitoring->detail->k, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Cl (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="cl"
                                            value="{{ $monitoring->detail->cl ? number_format($monitoring->detail->cl, 1) : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Renal Function Parameters -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ureum (mg/dL)</label>
                                        <input type="number" step="0.1" class="form-control" name="ureum"
                                            value="{{ $monitoring->detail->ureum ? number_format($monitoring->detail->ureum, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Creatinin (mg/dL)</label>
                                        <input type="number" step="0.01" class="form-control" name="creatinin"
                                            value="{{ $monitoring->detail->creatinin ? number_format($monitoring->detail->creatinin, 2) : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Hematology Parameters -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Hb (g/dL)</label>
                                        <input type="number" step="0.1" class="form-control" name="hb"
                                            value="{{ $monitoring->detail->hb ? number_format($monitoring->detail->hb, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Ht (%)</label>
                                        <input type="number" step="0.1" class="form-control" name="ht"
                                            value="{{ $monitoring->detail->ht ? number_format($monitoring->detail->ht, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Leukosit (10³/µL)</label>
                                        <input type="number" step="0.01" class="form-control" name="leukosit"
                                            value="{{ $monitoring->detail->leukosit ? number_format($monitoring->detail->leukosit, 2) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Trombosit (10³/µL)</label>
                                        <input type="number" class="form-control" name="trombosit"
                                            value="{{ $monitoring->detail->trombosit ? number_format($monitoring->detail->trombosit, 0) : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Liver Function Parameters -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SGOT (U/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="sgot"
                                            value="{{ $monitoring->detail->sgot ? number_format($monitoring->detail->sgot, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SGPT (U/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="sgpt"
                                            value="{{ $monitoring->detail->sgpt ? number_format($monitoring->detail->sgpt, 1) : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Other Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Parameter Tambahan</h6>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">KDGS (mg/dL)</label>
                                        <input type="number" step="1" class="form-control" name="kdgs"
                                            value="{{ $monitoring->detail->kdgs ? number_format($monitoring->detail->kdgs, 0) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Terapi Oksigen</label>
                                        <input type="text" class="form-control" name="terapi_oksigen"
                                            value="{{ $monitoring->detail->terapi_oksigen }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Albumin (g/dL)</label>
                                        <input type="number" step="0.1" class="form-control" name="albumin"
                                            value="{{ $monitoring->detail->albumin ? number_format($monitoring->detail->albumin, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Kesadaran</label>
                                        <select class="form-select" name="kesadaran">
                                            <option value="">- Pilih -</option>
                                            <option value="1" {{ $monitoring->detail->kesadaran == '1' ? 'selected' : '' }}>Compos Mentis</option>
                                            <option value="2" {{ $monitoring->detail->kesadaran == '2' ? 'selected' : '' }}>Somnolence</option>
                                            <option value="3" {{ $monitoring->detail->kesadaran == '3' ? 'selected' : '' }}>Sopor</option>
                                            <option value="4" {{ $monitoring->detail->kesadaran == '4' ? 'selected' : '' }}>Coma</option>
                                            <option value="5" {{ $monitoring->detail->kesadaran == '5' ? 'selected' : '' }}>Delirium</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ventilator Parameters -->
                    <div class="card mb-4">
                        <div class="card-body">
                            @if ($dataMedis->kd_unit == '10131')
                                <h6 class="mb-3 border-bottom pb-2">Parameter CPAP</h6>
                            @elseif(in_array($dataMedis->kd_unit, ['10015', '10016', '10132']))
                                <h6 class="mb-3 border-bottom pb-2">Parameter Ventilator</h6>
                            @endif
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Mode</label>
                                        <input type="text" class="form-control" name="ventilator_mode"
                                            value="{{ $monitoring->detail->ventilator_mode }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">MV (L/min)</label>
                                        <input type="number" step="0.1" class="form-control" name="ventilator_mv"
                                            value="{{ $monitoring->detail->ventilator_mv ? number_format($monitoring->detail->ventilator_mv, 1) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">TV (mL)</label>
                                        <input type="number" step="1" class="form-control" name="ventilator_tv"
                                            value="{{ $monitoring->detail->ventilator_tv ? number_format($monitoring->detail->ventilator_tv, 0) : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">FiO2 (%)</label>
                                        <input type="number" step="1" class="form-control" name="ventilator_fio2"
                                            value="{{ $monitoring->detail->ventilator_fio2 ? number_format($monitoring->detail->ventilator_fio2, 0) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">I:E Ratio</label>
                                        <input type="text" class="form-control" name="ventilator_ie_ratio"
                                            value="{{ $monitoring->detail->ventilator_ie_ratio }}" placeholder="e.g., 1:2">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">P Max (cmH2O)</label>
                                        <input type="number" step="1" class="form-control" name="ventilator_pmax"
                                            value="{{ $monitoring->detail->ventilator_pmax ? number_format($monitoring->detail->ventilator_pmax, 0) : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">PEEP/PS (cmH2O)</label>
                                        <input type="number" step="1" class="form-control" name="ventilator_peep_ps"
                                            value="{{ $monitoring->detail->ventilator_peep_ps ? number_format($monitoring->detail->ventilator_peep_ps, 0) : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Medical Device Parameters -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="mb-3 border-bottom pb-2">Parameter Perangkat Medis Tambahan</h6>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">ETT No</label>
                                        <input type="text" class="form-control" name="ett_no"
                                            value="{{ $monitoring->detail->ett_no }}" placeholder="Nomor ETT">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Batas Bibir (cm)</label>
                                        <input type="number" step="0.1" class="form-control" name="batas_bibir"
                                            min="0" value="{{ $monitoring->detail->batas_bibir ? number_format($monitoring->detail->batas_bibir, 1) : '' }}"
                                            placeholder="cm">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">NGT No</label>
                                        <input type="text" class="form-control" name="ngt_no"
                                            value="{{ $monitoring->detail->ngt_no }}" placeholder="Nomor NGT">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">CVC</label>
                                        <input type="text" class="form-control" name="cvc"
                                            value="{{ $monitoring->detail->cvc }}" placeholder="Jenis CVC">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Urine Catch No</label>
                                        <input type="text" class="form-control" name="urine_catch_no"
                                            value="{{ $monitoring->detail->urine_catch_no }}"
                                            placeholder="Nomor Urine Catch">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">IV Line</label>
                                        <input type="text" class="form-control" name="iv_line"
                                            value="{{ $monitoring->detail->iv_line }}" placeholder="Jenis IV Line">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                            <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/monitoring") }}"
                                class="btn">
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
        $(document).ready(function() {


            // Tambahkan JavaScript ini di dalam $(document).ready(function() { yang sudah ada

            // Konsulen Management for Edit Form
            let konsulenIndex = document.querySelectorAll('.konsulen-item').length;

            // Store doctor options for konsulen
            const doctorOptions = [];
            @foreach ($dokter as $dok)
                doctorOptions.push({
                    value: '{{ addslashes($dok->kd_dokter) }}', 
                    text: '{{ addslashes($dok->nama_lengkap) }}'
                });
            @endforeach

            // Function to build konsulen options HTML
            function buildKonsulenOptionsHtml(selectedValue = '') {
                let html = '<option value="">- Pilih -</option>';
                doctorOptions.forEach(function(doctor) {
                    const selected = selectedValue === doctor.value ? 'selected' : '';
                    html += `<option value="${doctor.value}" ${selected}>${doctor.text}</option>`;
                });
                return html;
            }

            // Function to initialize Select2 for konsulen elements
            function initializeKonsulenSelect2(element) {
                if (typeof $.fn.select2 !== 'undefined') {
                    $(element).select2({
                        theme: 'bootstrap-5',
                        placeholder: '- Pilih -',
                        width: '100%'
                    });
                }
            }

            // Function to reinitialize existing konsulen selects
            function reinitializeExistingKonsulenSelects() {
                $('.select2-konsulen').each(function() {
                    const currentValue = $(this).val();
                    
                    // Destroy existing Select2 if exists
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        $(this).select2('destroy');
                    }
                    
                    // Rebuild options with current value preserved
                    $(this).html(buildKonsulenOptionsHtml(currentValue));
                    
                    // Re-initialize Select2
                    initializeKonsulenSelect2(this);
                });
            }

            // Initialize existing Select2 elements
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    placeholder: '- Pilih -'
                });
                
                // Fix existing konsulen selects after a short delay
                setTimeout(function() {
                    reinitializeExistingKonsulenSelects();
                }, 100);
            }

            // Add new Konsulen
            $(document).on('click', '#add-konsulen', function() {
                const container = document.getElementById('konsulen-container');
                const newItem = document.createElement('div');
                newItem.className = 'konsulen-item mb-2';
                newItem.setAttribute('data-index', konsulenIndex);
                
                newItem.innerHTML = `
                    <div class="input-group">
                        <select name="konsulen[]" class="form-select select2-konsulen bg-light">
                            ${buildKonsulenOptionsHtml()}
                        </select>
                        <button type="button" class="btn btn-outline-danger remove-konsulen">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
                
                container.appendChild(newItem);
                
                // Initialize Select2 for the new element
                const newSelect = newItem.querySelector('select');
                initializeKonsulenSelect2(newSelect);
                
                konsulenIndex++;
                updateRemoveKonsulenButtons();
            });

            // Remove Konsulen
            $(document).on('click', '.remove-konsulen', function(e) {
                const button = e.target.classList.contains('remove-konsulen') ? e.target : e.target.closest('.remove-konsulen');
                const item = button.closest('.konsulen-item');
                
                // Destroy Select2 before removing element
                const select = item.querySelector('select');
                if (typeof $.fn.select2 !== 'undefined' && $(select).hasClass('select2-hidden-accessible')) {
                    $(select).select2('destroy');
                }
                
                item.remove();
                updateRemoveKonsulenButtons();
            });

            // Update remove buttons visibility for konsulen
            function updateRemoveKonsulenButtons() {
                const items = document.querySelectorAll('.konsulen-item');
                items.forEach((item, index) => {
                    const removeBtn = item.querySelector('.remove-konsulen');
                    if (index === 0 && items.length === 1) {
                        removeBtn.style.display = 'none';
                    } else {
                        removeBtn.style.display = 'block';
                    }
                });
            }

            // Initial update of remove buttons for konsulen
            updateRemoveKonsulenButtons();


            // Validasi jam
            $('#jam_implementasi').on('change', function() {
                const timePattern = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
                const timeValue = $(this).val();

                if (!timePattern.test(timeValue)) {
                    $(this).addClass('is-invalid');
                    $('#timeError').show();
                } else {
                    $(this).removeClass('is-invalid');
                    $('#timeError').hide();
                }
            });

            // Kalkulasi MAP (Mean Arterial Pressure)
            $('#sistolik, #diastolik').on('input', function() {
                const sistolik = parseFloat($('#sistolik').val()) || 0;
                const diastolik = parseFloat($('#diastolik').val()) || 0;

                // Only calculate MAP if both values are provided and within reasonable ranges
                if (sistolik > 0 && sistolik <= 300 && diastolik > 0 && diastolik <= 200) {
                    const map = Math.round((sistolik + 2 * diastolik) / 3);
                    $('#map').val(map);
                } else {
                    $('#map').val('');
                }
            });

            // Kalkulasi total GCS
            $('.gcs-component').on('change', function() {
                calculateGCS();
            });

            function calculateGCS() {
                const eyeValue = parseInt($('#gcs_eye').val()) || 0;
                const verbalValue = parseInt($('#gcs_verbal').val()) || 0;
                const motorValue = parseInt($('#gcs_motor').val()) || 0;

                // Only calculate if all three components are selected
                if (eyeValue > 0 && verbalValue > 0 && motorValue > 0) {
                    const totalGCS = eyeValue + verbalValue + motorValue;
                    if (totalGCS >= 3 && totalGCS <= 15) {
                        $('#gcs_total').val(totalGCS);
                    } else {
                        $('#gcs_total').val('');
                    }
                } else {
                    $('#gcs_total').val('');
                }
            }

            // Validasi form sebelum submit
            $('#iccuForm').on('submit', function(e) {
            // Remove empty konsulen values before submission
            const konsulenSelects = document.querySelectorAll('select[name="konsulen[]"]');
            konsulenSelects.forEach(select => {
                if (!select.value || select.value === '') {
                    select.remove();
                }
            });

            // Updated required fields - remove unit-specific requirements
            const requiredFields = [
                'tgl_implementasi',
                'jam_implementasi',
                'sistolik' // Keep only common required fields
            ];

            // Add conditional required fields based on unit
            @if(in_array($dataMedis->kd_unit, ['10015', '10016', '10132']))
                requiredFields.push('indikasi_iccu');
                requiredFields.push('diagnosa');
            @endif

            let isValid = true;

            requiredFields.forEach(function(field) {
                const fieldValue = $(`[name="${field}"]`).val();
                if (!fieldValue || fieldValue.trim() === '') {
                    $(`[name="${field}"]`).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(`[name="${field}"]`).removeClass('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi data yang wajib diisi!');
            }
        });
        });
    </script>
@endpush