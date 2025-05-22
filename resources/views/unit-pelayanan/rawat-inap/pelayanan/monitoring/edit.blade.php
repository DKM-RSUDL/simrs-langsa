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

        <div class="col-md-9">
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Edit Monitoring Intensive Care Unit (ICCU)</h5>
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
                                    <div class="mb-3">
                                        <label class="form-label fw-bold required">Indikasi ICCU</label>
                                        <textarea class="form-control bg-light" name="indikasi_iccu" rows="3" required>{{ $monitoring->indikasi_iccu }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Berat Badan (kg)</label>
                                                <input type="number" step="0.1" min="0" class="form-control bg-light"
                                                    name="berat_badan" placeholder="kg" value="{{ $monitoring->berat_badan ? number_format($monitoring->berat_badan, 1) : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tinggi Badan (cm)</label>
                                                <input type="number" step="1" min="0" class="form-control bg-light"
                                                    name="tinggi_badan" placeholder="cm" value="{{ $monitoring->tinggi_badan ? number_format($monitoring->tinggi_badan, 0) : '' }}">
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
                                <div class="form-group">
                                    <label for="alergi">Alergi</label>
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
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h6 class="mb-3 border-bottom pb-2 fw-bold">
                                        <i class="bi bi-people-fill me-1"></i> Informasi Tenaga Medis
                                    </h6>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Dokter</label>
                                        <select class="form-select select2 bg-light" style="width: 100%" name="dokter">
                                            <option value="">- Pilih -</option>
                                            @foreach ($dokter as $d)
                                                <option value="{{ $d->kd_dokter }}" {{ $monitoring->dokter == $d->kd_dokter ? 'selected' : '' }}>
                                                    {{ $d->nama_lengkap }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Konsulen</label>
                                        <input type="text" class="form-control bg-light" name="konsulen" value="{{ $monitoring->konsulen ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Anastesi/RB</label>
                                        <input type="text" class="form-control bg-light" name="anastesi_rb" value="{{ $monitoring->anastesi_rb ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Dokter Jaga</label>
                                        <select class="form-select select2 bg-light" style="width: 100%" name="dokter_jaga">
                                            <option value="">- Pilih -</option>
                                            @foreach ($dokter as $d)
                                                <option value="{{ $d->kd_dokter }}" {{ $monitoring->dokter_jaga == $d->kd_dokter ? 'selected' : '' }}>
                                                    {{ $d->nama_lengkap }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                Monitoring ICCU Parameters
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
                            <h6 class="mb-3 border-bottom pb-2">Fungsi Hati</h6>
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
                            <h6 class="mb-3 border-bottom pb-2">Parameter Ventilator</h6>
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
            ///===============================================================================================//
            // Add random data generation button to the form
            ///===============================================================================================//
            $('.row .col-12.text-end').prepend(`
                <button type="button" id="generateRandomData" class="btn btn-warning me-2">
                    <i class="bi bi-shuffle me-1"></i> Isi Data Random
                </button>
            `);

            // Random data generation functionality
            $('#generateRandomData').on('click', function() {
                // Helper function to get random number within range
                function randomNumber(min, max, decimals = 0) {
                    const factor = Math.pow(10, decimals);
                    return Math.round((Math.random() * (max - min) + min) * factor) / factor;
                }

                // Helper function to get random item from array
                function randomItem(array) {
                    return array[Math.floor(Math.random() * array.length)];
                }

                // Output
                $('[name="bab"]').val(randomNumber(0, 3));
                $('[name="urine"]').val(randomNumber(500, 2000));
                $('[name="iwl"]').val(randomNumber(300, 800));
                $('[name="muntahan_cms"]').val(randomNumber(0, 200));
                $('[name="drain"]').val(randomNumber(0, 150));

                // Vital signs
                const sistolik = randomNumber(90, 180);
                const diastolik = randomNumber(60, 110);
                const map = Math.round((sistolik + 2 * diastolik) / 3);

                $('[name="sistolik"]').val(sistolik);
                $('[name="diastolik"]').val(diastolik);
                $('[name="map"]').val(map);
                $('[name="hr"]').val(randomNumber(60, 120));
                $('[name="rr"]').val(randomNumber(12, 30));
                $('[name="temp"]').val(randomNumber(36, 39, 1));

                // Therapy Doses (Random values for each therapy)
                @foreach ($therapies as $therapy)
                    $('[name="therapy_doses[{{ $therapy->id }}]"]').val(randomNumber(1, 100, 1));
                @endforeach

                // GCS - Glasgow Coma Scale
                const eyeValues = ["", "1", "2", "3", "4"];
                const verbalValues = ["", "1", "2", "3", "4", "5"];
                const motorValues = ["", "1", "2", "3", "4", "5", "6"];

                const eyeValue = randomItem(eyeValues);
                const verbalValue = randomItem(verbalValues);
                const motorValue = randomItem(motorValues);

                $('#gcs_eye').val(eyeValue);
                $('#gcs_verbal').val(verbalValue);
                $('#gcs_motor').val(motorValue);

                // Calculate GCS total if all values are selected
                if (eyeValue && verbalValue && motorValue) {
                    const totalGCS = parseInt(eyeValue) + parseInt(verbalValue) + parseInt(motorValue);
                    $('#gcs_total').val(totalGCS);
                }

                // Pupil status
                const pupilStatus = ["", "isokor", "anisokor", "midriasis", "miosis", "pinpoint"];
                $('[name="pupil_kanan"]').val(randomItem(pupilStatus));
                $('[name="pupil_kiri"]').val(randomItem(pupilStatus));

                // AGD - Analisis Gas Darah
                $('[name="ph"]').val(randomNumber(7.30, 7.50, 2));
                $('[name="po2"]').val(randomNumber(80, 100, 1));
                $('[name="pco2"]').val(randomNumber(35, 45, 1));
                $('[name="be"]').val(randomNumber(-3, 3, 1));
                $('[name="hco3"]').val(randomNumber(22, 28, 1));
                $('[name="saturasi_o2"]').val(randomNumber(90, 99, 1));

                // Elektrolit
                $('[name="na"]').val(randomNumber(135, 145, 1));
                $('[name="k"]').val(randomNumber(3.5, 5.5, 1));
                $('[name="cl"]').val(randomNumber(98, 108, 1));

                // Fungsi Ginjal
                $('[name="ureum"]').val(randomNumber(15, 40, 1));
                $('[name="creatinin"]').val(randomNumber(0.6, 1.3, 2));

                // Hematologi
                $('[name="hb"]').val(randomNumber(11, 17, 1));
                $('[name="ht"]').val(randomNumber(35, 50, 1));
                $('[name="leukosit"]').val(randomNumber(4, 11, 2));
                $('[name="trombosit"]').val(randomNumber(150, 400));

                // Fungsi Hati
                $('[name="sgot"]').val(randomNumber(10, 40, 1));
                $('[name="sgpt"]').val(randomNumber(10, 40, 1));

                // Parameter Tambahan
                $('[name="kdgs"]').val(randomNumber(80, 180));

                const terapiOksigen = ["Nasal Kanula 2 lpm", "Nasal Kanula 4 lpm",
                    "Non-Rebreathing Mask 10 lpm", "Simple Mask 6 lpm", "Ventilator"
                ];
                $('[name="terapi_oksigen"]').val(randomItem(terapiOksigen));
                $('[name="albumin"]').val(randomNumber(3.5, 5.0, 1));

                const kesadaran = ["", "1", "2", "3", "4", "5"];
                $('[name="kesadaran"]').val(randomItem(kesadaran));

                // Ventilator Parameters
                const ventModes = ["SIMV", "CPAP", "BiPAP", "AC", "PC", "PSV"];
                $('[name="ventilator_mode"]').val(randomItem(ventModes));
                $('[name="ventilator_mv"]').val(randomNumber(6, 12, 1));
                $('[name="ventilator_tv"]').val(randomNumber(350, 650));
                $('[name="ventilator_fio2"]').val(randomNumber(21, 80));

                const ieRatios = ["1:2", "1:1.5", "1:3", "1:4"];
                $('[name="ventilator_ie_ratio"]').val(randomItem(ieRatios));
                $('[name="ventilator_pmax"]').val(randomNumber(15, 30));
                $('[name="ventilator_peep_ps"]').val(randomNumber(5, 12));

                // Medical Devices
                const ettSizes = ["7.0", "7.5", "8.0", "8.5"];
                const ngtSizes = ["14", "16", "18"];
                const cvcTypes = ["Subclavian", "Jugularis", "Femoralis", ""];
                const ivLineTypes = ["Perifer", "Central", "PICC", ""];

                $('[name="ett_no"]').val(randomItem(ettSizes));
                $('[name="batas_bibir"]').val(randomNumber(19, 24, 1));
                $('[name="ngt_no"]').val(randomItem(ngtSizes));
                $('[name="cvc"]').val(randomItem(cvcTypes));
                $('[name="urine_catch_no"]').val(randomNumber(14, 18));
                $('[name="iv_line"]').val(randomItem(ivLineTypes));

                // Trigger input events to calculate derived values
                $('#sistolik, #diastolik').trigger('input');
                $('.gcs-component').trigger('change');
            });

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
                    'indikasi_iccu',
                    'diagnosa',
                    'sistolik'
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