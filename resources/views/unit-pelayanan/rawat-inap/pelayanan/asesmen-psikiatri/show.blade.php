@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum") }}"
                class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-12 d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="header-asesmen">Asesmen Medis Psikiatri</h4>
                                        <p class="mb-0">
                                            Detail asesmen medis psikiatri pasien
                                        </p>
                                    </div>
                                    <div>
                                        <a href="{{ route('rawat-inap.asesmen.medis.psikiatri.edit', [
                                            'kd_unit' => $kd_unit,
                                            'kd_pasien' => $kd_pasien,
                                            'tgl_masuk' => $tgl_masuk,
                                            'urut_masuk' => $urut_masuk,
                                            'id' => $asesmen->id,
                                        ]) }}"
                                            class="btn btn-warning">
                                            <i class="ti-pencil"></i> Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-3">
                            <!-- 1. Data Masuk -->
                            <div class="section-separator" id="data-masuk">
                                <h5 class="section-title">1. Data Masuk</h5>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Tanggal Dan Jam Masuk</label>
                                        <p>{{ Carbon\Carbon::parse($asesmenPsikiatri->waktu_masuk)->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Kondisi Masuk</label>
                                        <p>{{ $asesmenPsikiatri->kondisi_masuk ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Diagnosis Masuk</label>
                                        <p>{{ $asesmenPsikiatri->diagnosis_masuk ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Pengkajian Keperawatan -->
                            <div class="section-separator" id="pengkajian-keperawatan">
                                <h5 class="section-title">2. Pengkajian Keperawatan</h5>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Anamnesis</label>
                                        <p>{{ $asesmen->anamnesis ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Keluhan Utama/Alasan Masuk RS</label>
                                        <p class="text-justify">{{ $asesmenPsikiatri->keluhan_utama ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Sensorium</label>
                                        <p>{{ $asesmenPsikiatri->sensorium ?: '-' }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Tekanan Darah</label>
                                        <p>{{ $asesmenPsikiatri->tekanan_darah_sistole ?: '-' }}/{{ $asesmenPsikiatri->tekanan_darah_diastole ?: '-' }} mmHg</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Suhu</label>
                                        <p>{{ $asesmenPsikiatri->suhu ?: '-' }}°C</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Respirasi</label>
                                        <p>{{ $asesmenPsikiatri->respirasi ?: '-' }} /menit</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Nadi</label>
                                        <p>{{ $asesmenPsikiatri->nadi ?: '-' }} /menit</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Skala Nyeri</label>
                                        <p>{{ $asesmenPsikiatri->skala_nyeri ?: '-' }} 
                                            @if($asesmenPsikiatri->kategori_nyeri)
                                                <span class="badge bg-info">{{ $asesmenPsikiatri->kategori_nyeri }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Alat Bantu</label>
                                        <p>{{ $asesmenPsikiatri->alat_bantu ?: '-' }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Cacat Tubuh</label>
                                        <p>{{ $asesmenPsikiatri->cacat_tubuh ?: '-' }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">ADL</label>
                                        <p>{{ $asesmenPsikiatri->adl ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Resiko Jatuh</label>
                                        <p>{{ $asesmenPsikiatri->resiko_jatuh ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Alergi -->
                            <div class="section-separator" id="alergi">
                                <h5 class="section-title">3. Alergi</h5>

                                @if ($alergiPasien->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Jenis Alergi</th>
                                                    <th>Alergen</th>
                                                    <th>Reaksi</th>
                                                    <th>Tingkat Keparahan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($alergiPasien as $index => $alergi)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $alergi->jenis_alergi }}</td>
                                                        <td>{{ $alergi->nama_alergi }}</td>
                                                        <td>{{ $alergi->reaksi }}</td>
                                                        <td>
                                                            <span class="badge 
                                                                @if($alergi->tingkat_keparahan == 'Ringan') bg-success
                                                                @elseif($alergi->tingkat_keparahan == 'Sedang') bg-warning
                                                                @elseif($alergi->tingkat_keparahan == 'Berat') bg-danger
                                                                @else bg-secondary
                                                                @endif">
                                                                {{ $alergi->tingkat_keparahan }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">Tidak ada data alergi</p>
                                @endif
                            </div>

                            <!-- 4. Pengkajian Medis -->
                            @if($asesmenPsikiatriDtl)
                            <div class="section-separator" id="pengkajian-medis">
                                <h5 class="section-title">4. Pengkajian Medis</h5>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Riwayat Penyakit Sekarang</label>
                                        <p class="text-justify">{{ $asesmenPsikiatriDtl->riwayat_penyakit_sekarang ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Riwayat Penyakit Terdahulu</label>
                                        <p>{{ $asesmenPsikiatriDtl->riwayat_penyakit_terdahulu ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Riwayat Perkembangan Masa Kanak</label>
                                        <p>{{ $asesmenPsikiatriDtl->riwayat_penyakit_perkembangan_masa_kanak ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Riwayat Penyakit Masa Dewasa</label>
                                        <p>{{ $asesmenPsikiatriDtl->riwayat_penyakit_masa_dewasa ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Riwayat Kesehatan Keluarga</label>
                                        @php
                                            $riwayatKeluarga = json_decode(
                                                $asesmenPsikiatriDtl->riwayat_kesehatan_keluarga ?? '[]',
                                                true,
                                            );
                                        @endphp
                                        @if (!empty($riwayatKeluarga) && is_array($riwayatKeluarga) && count($riwayatKeluarga) > 0)
                                            <ol class="ps-3">
                                                @foreach ($riwayatKeluarga as $riwayat)
                                                    <li>{{ $riwayat }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada riwayat kesehatan keluarga</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Terapi yang Diberikan</label>
                                        <p class="text-justify">{{ $asesmenPsikiatriDtl->terapi_diberikan ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- 5. Pemeriksaan Fisik -->
                            @if($asesmenPsikiatriDtl)
                            <div class="section-separator" id="pemeriksaan-fisik">
                                <h5 class="section-title">5. Pemeriksaan Fisik</h5>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Pemeriksaan Psikiatri</label>
                                        <p class="text-justify">{{ $asesmenPsikiatriDtl->pemeriksaan_psikiatri ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Status Internis</label>
                                        <p class="text-justify">{{ $asesmenPsikiatriDtl->status_internis ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Status Neurologi</label>
                                        <p class="text-justify">{{ $asesmenPsikiatriDtl->status_neorologi ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Pemeriksaan Penunjang</label>
                                        <p class="text-justify">{{ $asesmenPsikiatriDtl->pemeriksaan_penunjang ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- 6. Diagnosis -->
                            @if($asesmenPsikiatriDtl)
                            <div class="section-separator" id="diagnosis">
                                <h5 class="section-title">6. Diagnosis</h5>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold text-primary">Diagnosis Banding</label>
                                        @php
                                            $diagnosisBanding = json_decode($asesmenPsikiatriDtl->diagnosis_banding ?? '[]', true);
                                        @endphp
                                        @if (!empty($diagnosisBanding) && count($diagnosisBanding) > 0)
                                            <ol class="ps-3">
                                                @foreach ($diagnosisBanding as $diagnosis)
                                                    <li>{{ $diagnosis }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada diagnosis banding</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Axis I</label>
                                        <p>{{ $asesmenPsikiatriDtl->axis_i ?: '-' }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Axis II</label>
                                        <p>{{ $asesmenPsikiatriDtl->axis_ii ?: '-' }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Axis III</label>
                                        <p>{{ $asesmenPsikiatriDtl->axis_iii ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Axis IV</label>
                                        <p>{{ $asesmenPsikiatriDtl->axis_iv ?: '-' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Axis V</label>
                                        <p>{{ $asesmenPsikiatriDtl->axis_v ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- 7. Prognosis dan Therapy -->
                            @if($asesmenPsikiatriDtl)
                            <div class="section-separator" id="prognosis-therapy">
                                <h5 class="section-title">7. Prognosis dan Therapy</h5>

                                <div class="row mb-3">
                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold">Prognosis</label>
                                        <div class="form-control bg-light" style="min-height: 38px; display: flex; align-items: center;">
                                                <span class="text-dark">{{ $asesmenPsikiatriDtl->prognosisValue->value ?? "Belum ada Prognosis" }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Terapi</label>
                                        <p class="text-justify">{{ $asesmenPsikiatriDtl->therapi ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Info Tambahan -->
                            <div class="section-separator">
                                <h6 class="fw-bold">Informasi Asesmen</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">Waktu Asesmen:
                                            {{ Carbon\Carbon::parse($asesmen->waktu_asesmen)->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">Dibuat oleh:
                                            {{ $asesmen->user->name ?? 'Unknown' }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .section-separator {
            border-top: 2px solid #097dd6;
            margin: 2rem 0;
            padding-top: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-label.fw-bold {
            font-weight: 600 !important;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .text-justify {
            text-align: justify;
        }

        .badge {
            font-size: 0.75rem;
        }

        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }

        .ps-3 {
            padding-left: 1rem !important;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .text-primary {
            color: #0d6efd !important;
        }
    </style>
@endpush