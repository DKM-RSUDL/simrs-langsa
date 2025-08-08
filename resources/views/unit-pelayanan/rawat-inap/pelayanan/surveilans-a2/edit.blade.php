@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: #2c3e50;
        }

        .header-asesmen {
            margin-top: 0.5rem;
            font-size: 1.5rem;
            font-weight: 600;
            color: #00223b;
            text-align: center;
            margin-bottom: 1rem;
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
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            border-bottom: 2px solid #097dd6;
            padding-bottom: 0.25rem;
        }

        .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        .datetime-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .datetime-item label {
            font-weight: 500;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .field-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .field-item {
            display: flex;
            flex-direction: column;
        }

        .field-item label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 0.3rem;
        }

        .field-item input,
        .field-item textarea,
        .field-item select {
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 0.5rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .field-item input:focus,
        .field-item textarea:focus,
        .field-item select:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
            outline: none;
        }

        .field-item.full-width {
            grid-column: 1 / -1;
        }

        .resiko-section {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 1rem;
            background: white;
        }

        .resiko-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 0.75rem 1rem;
            font-weight: 600;
            color: #495057;
            border-radius: 8px 8px 0 0;
        }

        .resiko-body {
            padding: 1rem;
        }

        .resiko-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            gap: 1rem;
        }

        .resiko-item label {
            margin: 0;
            font-weight: 500;
            color: #495057;
            min-width: 200px;
            font-size: 0.95rem;
        }

        .resiko-item input,
        .resiko-item select {
            flex: 1;
            min-width: 200px;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 0.9rem;
        }

        .resiko-item .d-flex input {
            min-width: 120px;
            max-width: 150px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .datetime-group {
                grid-template-columns: 1fr;
            }

            .field-group {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .resiko-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }

            .resiko-item label {
                min-width: auto;
            }

            .resiko-item input {
                width: 100%;
                max-width: none;
            }
        }

        @media (max-width: 576px) {
            .form-section {
                padding: 0.5rem;
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
            <a href="{{ route('rawat-inap.surveilans-ppi.a2.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form id="painAssessmentForm" method="POST"
                action="{{ route('rawat-inap.surveilans-ppi.a2.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $dataSurveilans->id]) }}">
                @csrf
                @method('PUT')

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="header-asesmen">Edit Form Surveilans PPI (PENCEGAHAN DAN PENGENDALIAN INFEKSI) A2</h4>

                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <h5 class="section-title">Informasi Dasar</h5>

                            <div class="form-group">
                                <label class="form-label">Tanggal dan Jam Implementasi</label>
                                <div class="datetime-group">
                                    <div class="datetime-item">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_implementasi"
                                            id="tanggal_implementasi" value="{{ $dataSurveilans->tanggal_implementasi }}" required>
                                    </div>
                                    <div class="datetime-item">
                                        <label>Jam</label>
                                        <input type="time" class="form-control" name="jam_implementasi"
                                            id="jam_implementasi" value="{{ date('H:i:s', strtotime($dataSurveilans->jam_implementasi)) }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tempat Rawat Section -->
                        <div class="form-section">
                            <h5 class="section-title">Tempat Rawat</h5>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Ruang/Kamar</th>
                                            <th>Tanggal & Jam Masuk</th>
                                            <th>Tanggal & Jam Keluar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($dataRawat) && $dataRawat->count() > 0)
                                            @foreach ($dataRawat as $index => $rawat)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>
                                                        <input type="text"
                                                            class="form-control form-control-sm border-0 bg-transparent"
                                                            value="{{ $rawat->unitKamar->nama_unit ?? 'N/A' }}" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="date"
                                                            class="form-control form-control-sm border-0 bg-transparent"
                                                            value="{{ $rawat->tgl_inap ? date('Y-m-d', strtotime($rawat->tgl_inap)) : '' }}"
                                                            readonly><input type="time"
                                                            class="form-control form-control-sm border-0 bg-transparent"
                                                            value="{{ $rawat->jam_inap ? date('H:i', strtotime($rawat->jam_inap)) : '' }}"
                                                            readonly>
                                                    </td>
                                                    <td>
                                                        <input type="date"
                                                            class="form-control form-control-sm border-0 bg-transparent"
                                                            value="{{ $rawat->tgl_keluar ? date('Y-m-d', strtotime($rawat->tgl_keluar)) : '' }}"
                                                            readonly><input type="time"
                                                            class="form-control form-control-sm border-0 bg-transparent"
                                                            value="{{ $rawat->jam_keluar ? date('H:i', strtotime($rawat->jam_keluar)) : '' }}"
                                                            readonly>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Tidak ada data rawat inap
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Informasi Keluar Section -->
                        <div class="form-section">
                            <h5 class="section-title">Informasi Keluar</h5>
                            <div class="field-group">
                                <div class="field-item">
                                    <label>Tanggal Keluar</label>
                                    <input type="date" class="form-control" name="tanggal_keluar" value="{{ $dataSurveilans->tanggal_keluar }}" required>
                                </div>
                                <div class="field-item full-width">
                                    <label>Sebab Keluar</label>
                                    <textarea class="form-control" name="sebab_keluar" rows="3" placeholder="Masukkan sebab keluar pasien...">{{ $dataSurveilans->sebab_keluar }}</textarea>
                                </div>
                                <div class="field-item full-width">
                                    <label>Diagnosa Akhir</label>
                                    <textarea class="form-control" name="diagnosa_akhir" rows="3" placeholder="Masukkan diagnosa akhir...">{{ $dataSurveilans->diagnosa_akhir }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Pindah Resiko Section -->
                        <div class="form-section">
                            <h5 class="section-title">III. Pindah Resiko</h5>

                            <!-- Operasi -->
                            <div class="resiko-section">
                                <div class="resiko-header">Operasi</div>
                                <div class="resiko-body">
                                    <div class="resiko-item">
                                        <label>Ahli Bedah:</label>
                                        <input type="text" class="form-control" name="ahli_bedah" value="{{ $dataSurveilans->ahli_bedah }}">
                                    </div>
                                    <div class="resiko-item">
                                        <label>Jenis Operasi:</label>
                                        <input type="text" class="form-control" name="jenis_operasi" value="{{ $dataSurveilans->jenis_operasi }}">
                                    </div>
                                    <div class="resiko-item">
                                        <label>Scrub Nurse:</label>
                                        <input type="text" class="form-control" name="scrub_nurse" value="{{ $dataSurveilans->scrub_nurse }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Apendiks/CABG/Hernia -->
                            <div class="resiko-section">
                                <div class="resiko-header">Apendiks/CABG/Hernia/...</div>
                                <div class="resiko-body">
                                    <div class="resiko-item">
                                        <label>Tipe Operasi:</label>
                                        <select class="form-control" name="tipe_operasi">
                                            <option value="">Pilih Tipe Operasi</option>
                                            <option value="Terbuka" {{ $dataSurveilans->tipe_operasi == 'Terbuka' ? 'selected' : '' }}>Terbuka</option>
                                            <option value="Tertutup" {{ $dataSurveilans->tipe_operasi == 'Tertutup' ? 'selected' : '' }}>Tertutup</option>
                                        </select>
                                    </div>
                                    <div class="resiko-item">
                                        <label>Jenis Luka:</label>
                                        <select class="form-control" name="jenis_luka">
                                            <option value="">Pilih Jenis Luka</option>
                                            <option value="Bersih" {{ $dataSurveilans->jenis_luka == 'Bersih' ? 'selected' : '' }}>Bersih</option>
                                            <option value="Bersih kontaminasi" {{ $dataSurveilans->jenis_luka == 'Bersih kontaminasi' ? 'selected' : '' }}>Bersih kontaminasi</option>
                                            <option value="Kontaminasi" {{ $dataSurveilans->jenis_luka == 'Kontaminasi' ? 'selected' : '' }}>Kontaminasi</option>
                                            <option value="Kotor" {{ $dataSurveilans->jenis_luka == 'Kotor' ? 'selected' : '' }}>Kotor</option>
                                        </select>
                                    </div>
                                    <div class="resiko-item">
                                        <label>Lama Operasi:</label>
                                        <select class="form-control" name="lama_operasi">
                                            <option value="">Pilih Lama Operasi</option>
                                            <option value="1 jam" {{ $dataSurveilans->lama_operasi == '1 jam' ? 'selected' : '' }}>1 jam</option>
                                            <option value="2 jam" {{ $dataSurveilans->lama_operasi == '2 jam' ? 'selected' : '' }}>2 jam</option>
                                            <option value="5 jam" {{ $dataSurveilans->lama_operasi == '5 jam' ? 'selected' : '' }}>5 jam</option>
                                        </select>
                                    </div>
                                    <div class="resiko-item">
                                        <label>ASA Score:</label>
                                        <input type="text" class="form-control" name="asa_score" value="{{ $dataSurveilans->asa_score }}">
                                    </div>
                                    <div class="resiko-item">
                                        <label>Risk Score:</label>
                                        <input type="text" class="form-control" name="risk_score" value="{{ $dataSurveilans->risk_score }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Pemasangan Alat -->
                            <div class="resiko-section">
                                <div class="resiko-header">Pemasangan Alat</div>
                                <div class="resiko-body">
                                    <div class="resiko-item">
                                        <label>Intra vena cateter perifer:</label>
                                        <div class="d-flex gap-2">
                                            <input type="date" class="form-control" name="iv_perifer_tgl" value="{{ $dataSurveilans->iv_perifer_tgl }}">
                                            <span>/</span>
                                            <input type="date" class="form-control" name="iv_perifer_sd" value="{{ $dataSurveilans->iv_perifer_sd }}">
                                        </div>
                                    </div>
                                    <div class="resiko-item">
                                        <label>Intra vena cateter sentral:</label>
                                        <div class="d-flex gap-2">
                                            <input type="date" class="form-control" name="iv_sentral_tgl" value="{{ $dataSurveilans->iv_sentral_tgl }}">
                                            <span>/</span>
                                            <input type="date" class="form-control" name="iv_sentral_sd" value="{{ $dataSurveilans->iv_sentral_sd }}">
                                        </div>
                                    </div>
                                    <div class="resiko-item">
                                        <label>Kateter Urine:</label>
                                        <div class="d-flex gap-2">
                                            <input type="date" class="form-control" name="kateter_urine_tgl" value="{{ $dataSurveilans->kateter_urine_tgl }}">
                                            <span>/</span>
                                            <input type="date" class="form-control" name="kateter_urine_sd" value="{{ $dataSurveilans->kateter_urine_sd }}">
                                        </div>
                                    </div>
                                    <div class="resiko-item">
                                        <label>Ventilasi Mekanik:</label>
                                        <div class="d-flex gap-2">
                                            <input type="date" class="form-control" name="ventilasi_mekanik_tgl" value="{{ $dataSurveilans->ventilasi_mekanik_tgl }}">
                                            <span>/</span>
                                            <input type="date" class="form-control" name="ventilasi_mekanik_sd" value="{{ $dataSurveilans->ventilasi_mekanik_sd }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Penggunaan Antibiotika Section -->
                        <div class="form-section">
                            <h5 class="section-title">Penggunaan Antibiotika</h5>
                            <div class="field-group">
                                <div class="field-item">
                                    <label>Pemakaian Antibiotika</label>
                                    <select class="form-control" name="pemakaian_antibiotika">
                                        <option value="">Pilih</option>
                                        <option value="Ada" {{ $dataSurveilans->pemakaian_antibiotika == 'Ada' ? 'selected' : '' }}>Ada</option>
                                        <option value="Tidak ada" {{ $dataSurveilans->pemakaian_antibiotika == 'Tidak ada' ? 'selected' : '' }}>Tidak ada</option>
                                    </select>
                                </div>
                                <div class="field-item">
                                    <label>Nama Jenis Obat</label>
                                    <input type="text" class="form-control" name="nama_jenis_obat"
                                        placeholder="Masukkan nama antibiotika" value="{{ $dataSurveilans->nama_jenis_obat }}">
                                </div>
                                <div class="field-item">
                                    <label>Tujuan Penggunaan</label>
                                    <select class="form-control" name="tujuan_penggunaan">
                                        <option value="">Pilih</option>
                                        <option value="Profilaksis" {{ $dataSurveilans->tujuan_penggunaan == 'Profilaksis' ? 'selected' : '' }}>Profilaksis</option>
                                        <option value="Pengobatan" {{ $dataSurveilans->tujuan_penggunaan == 'Pengobatan' ? 'selected' : '' }}>Pengobatan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Pemeriksaan Kultur Section -->
                        <div class="form-section">
                            <h5 class="section-title">Pemeriksaan Kultur</h5>
                            <div class="field-group">
                                <div class="field-item">
                                    <label>Pemeriksaan Kultur</label>
                                    <select class="form-control" name="pemeriksaan_kultur">
                                        <option value="">Pilih</option>
                                        <option value="Darah" {{ $dataSurveilans->pemeriksaan_kultur == 'Darah' ? 'selected' : '' }}>Darah</option>
                                        <option value="Urine" {{ $dataSurveilans->pemeriksaan_kultur == 'Urine' ? 'selected' : '' }}>Urine</option>
                                        <option value="Sputum" {{ $dataSurveilans->pemeriksaan_kultur == 'Sputum' ? 'selected' : '' }}>Sputum</option>
                                        <option value="Pus Luka" {{ $dataSurveilans->pemeriksaan_kultur == 'Pus Luka' ? 'selected' : '' }}>Pus Luka</option>
                                    </select>
                                </div>
                                <div class="field-item">
                                    <label>Temp</label>
                                    <input type="number" class="form-control" name="temp"
                                        placeholder="Masukkan Temperatur" value="{{ $dataSurveilans->temp }}">
                                </div>
                            </div>
                            <div class="field-group">
                                <div class="field-item">
                                    <label>Hasil Kultur</label>
                                    <input type="text" class="form-control" name="hasil_kultur"
                                        placeholder="Masukkan hasil kultur" value="{{ $dataSurveilans->hasil_kultur }}">
                                </div>
                            </div>
                        </div>

                        <!-- Infeksi Nosokomial yang Terjadi Section -->
                        <div class="form-section">
                            <h5 class="section-title">Infeksi Nosokomial yang Terjadi</h5>
                            <div class="field-group">
                                <div class="field-item">
                                    <label>Bakteremia/Sepsis</label>
                                    <input type="text" class="form-control" name="bakteremia_sepsis"
                                        placeholder="Masukkan Bakteremia/Sepsis" value="{{ $dataSurveilans->bakteremia_sepsis }}">
                                </div>
                                <div class="field-item">
                                    <label>VAP</label>
                                    <input type="text" class="form-control" name="vap"
                                        placeholder="Masukkan VAP" value="{{ $dataSurveilans->vap }}">
                                </div>
                                <div class="field-item">
                                    <label>Infeksi Saluran Kemih</label>
                                    <input type="text" class="form-control" name="infeksi_saluran_kemih"
                                        placeholder="Masukkan Infeksi Saluran Kemih" value="{{ $dataSurveilans->infeksi_saluran_kemih }}">
                                </div>
                            </div>

                            <div class="field-group">
                                <div class="field-item">
                                    <label>Infeksi Luka Operasi</label>
                                    <input type="text" class="form-control" name="infeksi_luka_operasi"
                                        placeholder="Masukkan Infeksi Luka Operasi" value="{{ $dataSurveilans->infeksi_luka_operasi }}">
                                </div>
                                <div class="field-item">
                                    <label>Dekubitus</label>
                                    <input type="text" class="form-control" name="dekubitus"
                                        placeholder="Masukkan Dekubitus" value="{{ $dataSurveilans->dekubitus }}">
                                </div>
                                <div class="field-item">
                                    <label>Plebitis</label>
                                    <input type="text" class="form-control" name="plebitis"
                                        placeholder="Masukkan Plebitis" value="{{ $dataSurveilans->plebitis }}">
                                </div>
                            </div>
                        </div>

                        <!-- Infeksi Lain Section -->
                        <div class="form-section">
                            <h5 class="section-title">Infeksi Lain</h5>
                            <div class="field-group">
                                <div class="field-item full-width">
                                    <label>Infeksi Lain (HIV, HBC, HCV)</label>
                                    <input type="text" class="form-control" name="infeksi_lain"
                                        placeholder="Masukkan infeksi lain (HIV, HBC, HCV)" value="{{ $dataSurveilans->infeksi_lain }}">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('rawat-inap.surveilans-ppi.a2.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                class="btn btn-secondary px-4">
                                <i class="ti-arrow-left mr-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4" id="update">
                                <i class="ti-save mr-2"></i> Update Data
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection