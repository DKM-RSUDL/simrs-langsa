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
                <h5 class="text-secondary fw-bold">{{ $title }}</h5>
            </div>

            <hr>

            <div class="form-section">
                <form
                    action="{{ route('rawat-inap.monitoring.store', [
                        'kd_unit' => $kd_unit,
                        'kd_pasien' => $kd_pasien,
                        'tgl_masuk' => $tgl_masuk,
                        'urut_masuk' => $urut_masuk,
                    ]) }}"
                    method="post" id="iccuForm">
                    @csrf

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
                                        @if ($latestMonitoring)
                                            <small class="text-info">
                                                <i class="bi bi-clock-history"></i>
                                                Pengisian terakhir:
                                                {{ date('d-m-Y H:i', strtotime($latestMonitoring->tgl_implementasi . ' ' . $latestMonitoring->jam_implementasi)) }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold required">Tanggal Implementasi</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" name="tgl_implementasi"
                                                id="tgl_implementasi" value="{{ date('Y-m-d') }}" required>
                                            @if ($latestMonitoring)
                                                <span class="input-group-text bg-light">
                                                    <i class="bi bi-calendar-check"></i>
                                                </span>
                                                <span class="input-group-text bg-light text-muted">
                                                    Terakhir:
                                                    {{ date('d-m-Y', strtotime($latestMonitoring->tgl_implementasi)) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold required">Jam Implementasi</label>
                                        <div class="input-group">
                                            <input type="time" class="form-control" name="jam_implementasi"
                                                id="jam_implementasi" value="{{ date('H:i') }}" required>
                                            @if ($latestMonitoring)
                                                <span class="input-group-text bg-light">
                                                    <i class="bi bi-clock"></i>
                                                </span>
                                                <span class="input-group-text bg-light text-muted">
                                                    Terakhir:
                                                    {{ date('H:i', strtotime($latestMonitoring->jam_implementasi)) }}
                                                </span>
                                            @endif
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
                                <small>Data di bawah ini diambil dari pengisian terakhir. Jangan diubah jika tidak
                                    diperlukan.</small>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    @if (in_array($dataMedis->kd_unit, ['10015', '10016', '10132']))
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Indikasi {{ $subTitle }}</label>
                                            <textarea class="form-control bg-light" name="indikasi_iccu" rows="3">{{ $latestMonitoring->indikasi_iccu ?? '' }}</textarea>
                                        </div>
                                    @endif

                                </div>

                                {{-- Field khusus untuk NICU --}}
                                @if ($dataMedis->kd_unit == '10131')
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Hari Rawat Ke-</label>
                                                    <div class="input-group">
                                                        <input type="number" min="1" class="form-control bg-light"
                                                            name="hari_rawat"
                                                            value="{{ $latestMonitoring->hari_rawat ?? '' }}">
                                                        <span class="input-group-text bg-light" data-bs-toggle="tooltip"
                                                            title="Hari Rawat Kunjungan">
                                                            <i class="bi bi-info-circle"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Usia Kelahiran</label>
                                                    <div class="input-group">
                                                        <input type="number" min="0" max="365"
                                                            class="form-control bg-light" name="usia_kelahiran"
                                                            placeholder="Hari"
                                                            value="{{ $latestMonitoring->usia_kelahiran ?? '' }}">
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
                                                        <input type="number" min="0" max="365"
                                                            class="form-control bg-light" name="umur_bayi"
                                                            placeholder="Hari"
                                                            value="{{ $latestMonitoring->umur_bayi ?? '' }}">
                                                        <span class="input-group-text">hari</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Umur Gestasi</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control bg-light"
                                                            name="umur_gestasi" placeholder="Minggu"
                                                            value="{{ $latestMonitoring->umur_gestasi ?? '' }}">
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
                                                        <input type="number" step="0.1"
                                                            class="form-control bg-light" name="berat_badan_lahir"
                                                            placeholder="Berat lahir"
                                                            value="{{ $latestMonitoring->berat_badan_lahir ?? '' }}">
                                                        <span class="input-group-text">gram</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Cara Persalinan</label>
                                                    <select class="form-select bg-light" name="cara_persalinan">
                                                        <option value="">- Pilih Cara Persalinan -</option>
                                                        <option value="Normal"
                                                            {{ ($latestMonitoring->cara_persalinan ?? '') == 'Normal' ? 'selected' : '' }}>
                                                            Normal/Spontan</option>
                                                        <option value="Vacuum"
                                                            {{ ($latestMonitoring->cara_persalinan ?? '') == 'Vacuum' ? 'selected' : '' }}>
                                                            Vacuum</option>
                                                        <option value="Forceps"
                                                            {{ ($latestMonitoring->cara_persalinan ?? '') == 'Forceps' ? 'selected' : '' }}>
                                                            Forceps</option>
                                                        <option value="SC"
                                                            {{ ($latestMonitoring->cara_persalinan ?? '') == 'SC' ? 'selected' : '' }}>
                                                            Sectio Caesarea (SC)</option>
                                                        <option value="Prematur"
                                                            {{ ($latestMonitoring->cara_persalinan ?? '') == 'Prematur' ? 'selected' : '' }}>
                                                            Prematur</option>
                                                        <option value="Lainnya"
                                                            {{ ($latestMonitoring->cara_persalinan ?? '') == 'Lainnya' ? 'selected' : '' }}>
                                                            Lainnya</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                {{-- End field khusus NICU --}}

                                @if (in_array($dataMedis->kd_unit, ['10015', '10016', '10132']))
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Berat Badan (kg)</label>
                                                    <input type="number" step="0.1" min="0"
                                                        class="form-control bg-light" name="berat_badan" placeholder="kg"
                                                        value="{{ $latestMonitoring && $latestMonitoring->berat_badan ? number_format($latestMonitoring->berat_badan, 1) : '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Tinggi Badan (cm)</label>
                                                    <input type="number" step="1" min="0"
                                                        class="form-control bg-light" name="tinggi_badan" placeholder="cm"
                                                        value="{{ $latestMonitoring && $latestMonitoring->tinggi_badan ? number_format($latestMonitoring->tinggi_badan, 0) : '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Hari Rawat Ke-</label>
                                                    <div class="input-group">
                                                        <input type="number" min="1" class="form-control bg-light"
                                                            name="hari_rawat"
                                                            value="{{ $latestMonitoring->hari_rawat ?? '' }}">
                                                        <span class="input-group-text bg-light" data-bs-toggle="tooltip"
                                                            title="Hari Rawat Kunjungan">
                                                            <i class="bi bi-info-circle"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Diagnosa</label>
                                                    <input type="text" class="form-control bg-light" name="diagnosa"
                                                        value="{{ $latestMonitoring->diagnosa ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label class="form-label fw-bold" for="alergi">Alergi</label>
                                    <div class="input-group">
                                        <input type="text" name="alergi_display" id="alergi_display"
                                            class="form-control" placeholder="Alergi pasien (jika ada)"
                                            value="{{ $allergiesDisplay ?? '' }}" readonly>
                                        <input type="hidden" name="alergi" id="alergi"
                                            value="{{ $allergiesJson ?? '' }}">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#alergiModal">
                                            <i class="ti-plus"></i> Tambah Alergi
                                        </button>
                                    </div>
                                </div>
                                @include('unit-pelayanan.rawat-inap.pelayanan.monitoring.alergi')
                            </div>



                            <!-- Informasi Tenaga Medis -->
                            <!-- Informasi Tenaga Medis -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h6 class="mb-3 border-bottom pb-2 fw-bold">
                                        <i class="bi bi-people-fill me-1"></i> Informasi Tenaga Medis
                                    </h6>
                                </div>

                                {{-- Form untuk NICU (10131) --}}
                                @if ($dataMedis->kd_unit == '10131')
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Dokter Diagnosa 1</label>
                                            <select class="form-select select2 bg-light" style="width: 100%"
                                                name="dokter_diagnosa_1">
                                                <option value="">- Pilih -</option>
                                                @foreach ($dokter as $d)
                                                    <option value="{{ $d->kd_dokter }}"
                                                        {{ $latestMonitoring && $latestMonitoring->dokter_diagnosa_1 == $d->kd_dokter ? 'selected' : '' }}>
                                                        {{ $d->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Dokter Diagnosa 2</label>
                                            <select class="form-select select2 bg-light" style="width: 100%"
                                                name="dokter_diagnosa_2">
                                                <option value="">- Pilih -</option>
                                                @foreach ($dokter as $d)
                                                    <option value="{{ $d->kd_dokter }}"
                                                        {{ $latestMonitoring && $latestMonitoring->dokter_diagnosa_2 == $d->kd_dokter ? 'selected' : '' }}>
                                                        {{ $d->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Dokter NICU 1</label>
                                            <select class="form-select select2 bg-light" style="width: 100%"
                                                name="dokter_nicu_1">
                                                <option value="">- Pilih -</option>
                                                @foreach ($dokter as $d)
                                                    <option value="{{ $d->kd_dokter }}"
                                                        {{ $latestMonitoring && $latestMonitoring->dokter_nicu_1 == $d->kd_dokter ? 'selected' : '' }}>
                                                        {{ $d->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Dokter NICU 2</label>
                                            <select class="form-select select2 bg-light" style="width: 100%"
                                                name="dokter_nicu_2">
                                                <option value="">- Pilih -</option>
                                                @foreach ($dokter as $d)
                                                    <option value="{{ $d->kd_dokter }}"
                                                        {{ $latestMonitoring && $latestMonitoring->dokter_nicu_2 == $d->kd_dokter ? 'selected' : '' }}>
                                                        {{ $d->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Dokter Konsul 1</label>
                                            <select class="form-select select2 bg-light" style="width: 100%"
                                                name="dokter_konsul_1">
                                                <option value="">- Pilih -</option>
                                                @foreach ($dokter as $d)
                                                    <option value="{{ $d->kd_dokter }}"
                                                        {{ $latestMonitoring && $latestMonitoring->dokter_konsul_1 == $d->kd_dokter ? 'selected' : '' }}>
                                                        {{ $d->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Dokter Konsul 2</label>
                                            <select class="form-select select2 bg-light" style="width: 100%"
                                                name="dokter_konsul_2">
                                                <option value="">- Pilih -</option>
                                                @foreach ($dokter as $d)
                                                    <option value="{{ $d->kd_dokter }}"
                                                        {{ $latestMonitoring && $latestMonitoring->dokter_konsul_2 == $d->kd_dokter ? 'selected' : '' }}>
                                                        {{ $d->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @elseif(in_array($dataMedis->kd_unit, ['10015', '10016', '10132']))
                                    {{-- Form untuk ICCU (10015), ICU (10016), PICU (10132) --}}
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Dokter</label>
                                            <select class="form-select select2 bg-light" style="width: 100%"
                                                name="dokter">
                                                <option value="">- Pilih -</option>
                                                @foreach ($dokter as $d)
                                                    <option value="{{ $d->kd_dokter }}"
                                                        {{ $latestMonitoring && $latestMonitoring->dokter == $d->kd_dokter ? 'selected' : '' }}>
                                                        {{ $d->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Konsulen</label>
                                            <select class="form-select select2 bg-light" style="width: 100%"
                                                name="konsulen">
                                                <option value="">- Pilih -</option>
                                                @foreach ($dokter as $d)
                                                    <option value="{{ $d->kd_dokter }}"
                                                        {{ $latestMonitoring && $latestMonitoring->konsulen == $d->kd_dokter ? 'selected' : '' }}>
                                                        {{ $d->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Anastesi/RB</label>
                                            <select class="form-select select2 bg-light" style="width: 100%"
                                                name="anastesi_rb">
                                                <option value="">- Pilih -</option>
                                                @foreach ($dokter as $d)
                                                    <option value="{{ $d->kd_dokter }}"
                                                        {{ $latestMonitoring && $latestMonitoring->anastesi_rb == $d->kd_dokter ? 'selected' : '' }}>
                                                        {{ $d->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Dokter Jaga</label>
                                            <select class="form-select select2 bg-light" style="width: 100%"
                                                name="dokter_jaga">
                                                <option value="">- Pilih -</option>
                                                @foreach ($dokter as $d)
                                                    <option value="{{ $d->kd_dokter }}"
                                                        {{ $latestMonitoring && $latestMonitoring->dokter_jaga == $d->kd_dokter ? 'selected' : '' }}>
                                                        {{ $d->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
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
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Diastolik (mmHg)</label>
                                        <input type="number" class="form-control" name="diastolik" id="diastolik">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">MAP</label>
                                        <input type="number" class="form-control" name="map" id="map"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Heart Rate (HR) <small>bpm</small></label>
                                        <input type="number" class="form-control" name="hr">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Resp. Rate (RR) <small>x/menit</small></label>
                                        <input type="number" class="form-control" name="rr">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Suhu (°C)</label>
                                        <input type="number" step="0.1" class="form-control" name="temp">
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
                                        <input type="number" step="1" class="form-control" name="cvp">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">EKG Record</label>
                                        <select class="form-select" name="ekg_record">
                                            <option value="">- Pilih -</option>
                                            <option value="Ada">Ada</option>
                                            <option value="Tidak">Tidak</option>
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
                                Masukkan jumlah obat yang diberikan dalam satuan cc/ml untuk setiap terapi obat yang telah
                                ditambahkan.
                            </div>

                            <!-- Terapi Oral -->
                            <div class="mb-4">
                                <h6 class="mb-3 border-bottom pb-2 fw-bold">Terapi Oral</h6>
                                @if ($therapies->where('jenis_terapi', 1)->isEmpty())
                                    <div class="text-center text-muted">
                                        Tidak ada obat untuk jenis terapi ini, Tambahkan Obat pada menu Therapy Obat.
                                    </div>
                                @else
                                    <div class="row">
                                        @foreach ($therapies->where('jenis_terapi', 1) as $therapy)
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">{{ $therapy->nama_obat }}</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.1" min="0"
                                                            class="form-control"
                                                            name="therapy_doses[{{ $therapy->id }}]"
                                                            placeholder="Jumlah dalam ml/mg">
                                                        <span class="input-group-text">ml/mg</span>
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
                                        Tidak ada obat untuk jenis terapi ini, Tambahkan Obat pada menu Therapy Obat.
                                    </div>
                                @else
                                    <div class="row">
                                        @foreach ($therapies->where('jenis_terapi', 2) as $therapy)
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">{{ $therapy->nama_obat }}</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.1" min="0"
                                                            class="form-control"
                                                            name="therapy_doses[{{ $therapy->id }}]"
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
                                        Tidak ada obat untuk jenis terapi ini, Tambahkan Obat pada menu Therapy Obat.
                                    </div>
                                @else
                                    <div class="row">
                                        @foreach ($therapies->where('jenis_terapi', 3) as $therapy)
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">{{ $therapy->nama_obat }}</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.1" min="0"
                                                            class="form-control"
                                                            name="therapy_doses[{{ $therapy->id }}]"
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
                                        Tidak ada obat untuk jenis terapi ini, Tambahkan Obat pada menu Therapy Obat.
                                    </div>
                                @else
                                    <div class="row">
                                        @foreach ($therapies->where('jenis_terapi', 4) as $therapy)
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">{{ $therapy->nama_obat }}</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.1" min="0"
                                                            class="form-control"
                                                            name="therapy_doses[{{ $therapy->id }}]"
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
                                        <input type="number" step="1" class="form-control" name="oral">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">NGT</label>
                                        <input type="number" step="1" class="form-control" name="ngt">
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
                                        <input type="number" class="form-control" name="bab">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Urine (ml)</label>
                                        <input type="number" step="0.1" class="form-control" name="urine">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">IWL (ml)</label>
                                        <input type="number" step="1" class="form-control" name="iwl">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Muntahan/CMS (ml)</label>
                                        <input type="number" step="1" class="form-control" name="muntahan_cms">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Drain (ml)</label>
                                        <input type="number" step="1" class="form-control" name="drain">
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
                                            <option value="4">4 - Spontan</option>
                                            <option value="3">3 - Terhadap Suara</option>
                                            <option value="2">2 - Terhadap Nyeri</option>
                                            <option value="1">1 - Tidak Ada Respon</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Respon Verbal (V)</label>
                                        <select class="form-select gcs-component" name="gcs_verbal" id="gcs_verbal">
                                            <option value="">- Pilih -</option>
                                            <option value="5">5 - Orientasi Baik</option>
                                            <option value="4">4 - Bingung</option>
                                            <option value="3">3 - Kata-kata Tidak Jelas</option>
                                            <option value="2">2 - Suara Tidak Jelas</option>
                                            <option value="1">1 - Tidak Ada Respon</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Respon Motorik (M)</label>
                                        <select class="form-select gcs-component" name="gcs_motor" id="gcs_motor">
                                            <option value="">- Pilih -</option>
                                            <option value="6">6 - Mengikuti Perintah</option>
                                            <option value="5">5 - Melokalisasi Nyeri</option>
                                            <option value="4">4 - Withdrawal</option>
                                            <option value="3">3 - Fleksi Abnormal</option>
                                            <option value="2">2 - Ekstensi Abnormal</option>
                                            <option value="1">1 - Tidak Ada Respon</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Total GCS</label>
                                        <input type="number" class="form-control" name="gcs_total" id="gcs_total"
                                            readonly>
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
                                            <option value="isokor">Isokor</option>
                                            <option value="anisokor">Anisokor</option>
                                            <option value="midriasis">Midriasis</option>
                                            <option value="miosis">Miosis</option>
                                            <option value="pinpoint">Pinpoint</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pupil Kiri</label>
                                        <select class="form-select" name="pupil_kiri">
                                            <option value="">- Pilih -</option>
                                            <option value="isokor">Isokor</option>
                                            <option value="anisokor">Anisokor</option>
                                            <option value="midriasis">Midriasis</option>
                                            <option value="miosis">Miosis</option>
                                            <option value="pinpoint">Pinpoint</option>
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
                                        <input type="number" step="0.01" class="form-control" name="ph">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">PO<sub>2</sub> (mmHg)</label>
                                        <input type="number" step="0.1" class="form-control" name="po2">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">PCO<sub>2</sub> (mmHg)</label>
                                        <input type="number" step="0.1" class="form-control" name="pco2">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">BE (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="be">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">HCO<sub>3</sub> (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="hco3">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Saturasi O<sub>2</sub> (%)</label>
                                        <input type="number" step="0.1" class="form-control" name="saturasi_o2">
                                    </div>
                                </div>
                            </div>

                            <!-- Elektrolit Parameters -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Na (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="na">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">K (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="k">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Cl (mmol/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="cl">
                                    </div>
                                </div>
                            </div>

                            <!-- Renal Function Parameters -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ureum (mg/dL)</label>
                                        <input type="number" step="0.1" class="form-control" name="ureum">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Creatinin (mg/dL)</label>
                                        <input type="number" step="0.01" class="form-control" name="creatinin">
                                    </div>
                                </div>
                            </div>

                            <!-- Hematology Parameters -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Hb (g/dL)</label>
                                        <input type="number" step="0.1" class="form-control" name="hb">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Ht (%)</label>
                                        <input type="number" step="0.1" class="form-control" name="ht">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Leukosit (10³/µL)</label>
                                        <input type="number" step="0.01" class="form-control" name="leukosit">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Trombosit (10³/µL)</label>
                                        <input type="number" class="form-control" name="trombosit">
                                    </div>
                                </div>
                            </div>

                            <!-- Liver Function Parameters -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SGOT (U/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="sgot">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SGPT (U/L)</label>
                                        <input type="number" step="0.1" class="form-control" name="sgpt">
                                    </div>
                                </div>
                            </div>

                            <!-- Other Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Parameter Tambahan</h6>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">KDGS (mg/dL)</label>
                                        <input type="number" step="1" class="form-control" name="kdgs">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Terapi Oksigen</label>
                                        <input type="text" class="form-control" name="terapi_oksigen">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Albumin (g/dL)</label>
                                        <input type="number" step="0.1" class="form-control" name="albumin">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Kesadaran</label>
                                        <select class="form-select" name="kesadaran">
                                            <option value="">- Pilih -</option>
                                            <option value="1">Compos Mentis</option>
                                            <option value="2">Somnolence</option>
                                            <option value="3">Sopor</option>
                                            <option value="4">Coma</option>
                                            <option value="5">Delirium</option>
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
                                        <input type="text" class="form-control" name="ventilator_mode">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">MV (L/min)</label>
                                        <input type="number" step="0.1" class="form-control" name="ventilator_mv">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">TV (mL)</label>
                                        <input type="number" step="1" class="form-control" name="ventilator_tv">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">FiO2 (%)</label>
                                        <input type="number" step="1" class="form-control"
                                            name="ventilator_fio2">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">I:E Ratio</label>
                                        <input type="text" class="form-control" name="ventilator_ie_ratio"
                                            placeholder="e.g., 1:2">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">P Max (cmH2O)</label>
                                        <input type="number" step="1" class="form-control"
                                            name="ventilator_pmax">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">PEEP/PS (cmH2O)</label>
                                        <input type="number" step="1" class="form-control"
                                            name="ventilator_peep_ps">
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
                                            placeholder="Nomor ETT">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Batas Bibir (cm)</label>
                                        <input type="number" step="0.1" class="form-control" name="batas_bibir"
                                            min="0" placeholder="cm">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">NGT No</label>
                                        <input type="text" class="form-control" name="ngt_no"
                                            placeholder="Nomor NGT">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">CVC</label>
                                        <input type="text" class="form-control" name="cvc"
                                            placeholder="Jenis CVC">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Urine Catch No</label>
                                        <input type="text" class="form-control" name="urine_catch_no"
                                            placeholder="Nomor Urine Catch">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">IV Line</label>
                                        <input type="text" class="form-control" name="iv_line"
                                            placeholder="Jenis IV Line">
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
                const requiredFields = [
                    'tgl_implementasi',
                    'jam_implementasi',
                    'sistolik' // Tambahkan sistolik sebagai field wajib
                ];

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
