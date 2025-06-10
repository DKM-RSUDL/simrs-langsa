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
                                        <h4 class="header-asesmen">Asesmen Medis Kulit dan Kelamin</h4>
                                        <p class="mb-0">
                                            Detail asesmen medis kulit dan kelamin pasien
                                        </p>
                                    </div>
                                    <div>
                                        <a href="{{ route('rawat-inap.asesmen.medis.kulit-kelamin.edit', [
                                            'kd_unit' => $kd_unit,
                                            'kd_pasien' => $kd_pasien,
                                            'tgl_masuk' => $tgl_masuk,
                                            'urut_masuk' => $urut_masuk,
                                            'id' => $asesmen->id,
                                        ]) }}" class="btn btn-warning">
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
                                        <p>{{ Carbon\Carbon::parse($asesmenKulitKelamin->waktu_masuk)->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Kondisi Masuk</label>
                                        <p>{{ $asesmenKulitKelamin->kondisi_masuk ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Diagnosis Masuk</label>
                                        <p>{{ $asesmenKulitKelamin->diagnosis_masuk ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Anamnesis -->
                            <div class="section-separator" id="anamnesis">
                                <h5 class="section-title">2. Anamnesis</h5>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Anamnesis</label>
                                        <p>{{ $asesmen->anamnesis ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Keluhan Utama/Alasan Masuk RS</label>
                                        <p class="text-justify">{{ $asesmenKulitKelamin->keluhan_utama ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Riwayat Kesehatan -->
                            <div class="section-separator" id="riwayat-kesehatan">
                                <h5 class="section-title">3. Riwayat Kesehatan</h5>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Riwayat Penyakit Sekarang</label>
                                        <p class="text-justify">{{ $asesmenKulitKelamin->riwayat_penyakit_sekarang ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Riwayat Penyakit Terdahulu</label>
                                        <p>{{ $asesmenKulitKelamin->riwayat_penyakit_terdahulu ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Riwayat Kesehatan Keluarga</label>
                                        @php
                                            $riwayatKeluarga = json_decode($asesmenKulitKelamin->riwayat_penyakit_keluarga ?? '[]', true);
                                        @endphp
                                        @if(!empty($riwayatKeluarga) && is_array($riwayatKeluarga) && count($riwayatKeluarga) > 0)
                                            <ol class="ps-3">
                                                @foreach($riwayatKeluarga as $riwayat)
                                                    <li>{{ $riwayat }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada riwayat kesehatan keluarga</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Riwayat Penggunaan Obat -->
                            <div class="section-separator" id="riwayat-obat">
                                <h5 class="section-title">4. Riwayat Penggunaan Obat</h5>

                                @if(!empty($riwayatPenggunaanObat) && count($riwayatPenggunaanObat) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Obat</th>
                                                    <th>Dosis</th>
                                                    <th>Aturan Pakai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($riwayatPenggunaanObat as $index => $obat)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $obat['namaObat'] ?? '-' }}</td>
                                                        <td>{{ ($obat['dosis'] ?? '-') . ' ' . ($obat['satuan'] ?? '') }}</td>
                                                        <td>
                                                            {{ ($obat['frekuensi'] ?? '-') }}
                                                            @if(isset($obat['keterangan']) && $obat['keterangan'])
                                                                ({{ $obat['keterangan'] }})
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">Tidak ada riwayat penggunaan obat</p>
                                @endif
                            </div>

                            <!-- 5. Alergi -->
                            <div class="section-separator" id="alergi">
                                <h5 class="section-title">5. Alergi</h5>

                                @if($alergiPasien->count() > 0)
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
                                                @foreach($alergiPasien as $index => $alergi)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $alergi->jenis_alergi }}</td>
                                                        <td>{{ $alergi->nama_alergi }}</td>
                                                        <td>{{ $alergi->reaksi }}</td>
                                                        <td>{{ $alergi->tingkat_keparahan }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">Tidak ada data alergi</p>
                                @endif
                            </div>

                            <!-- 6. Pemeriksaan Fisik -->
                            <div class="section-separator" id="pemeriksaan-fisik">
                                <h5 class="section-title">6. Pemeriksaan Fisik</h5>

                                <div class="row">
                                    @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                        <div class="col-md-6">
                                            @foreach ($chunk as $item)
                                                <div class="border-bottom py-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">{{ $item->nama }}</span>
                                                        @php
                                                            $pemeriksaan = $pemeriksaanFisik->get($item->id);
                                                        @endphp
                                                        @if($pemeriksaan)
                                                            @if($pemeriksaan->is_normal)
                                                                <span class="badge bg-success">Normal</span>
                                                            @else
                                                                <span class="badge bg-warning">Tidak Normal</span>
                                                            @endif
                                                        @else
                                                            <span class="badge bg-secondary">Tidak Diperiksa</span>
                                                        @endif
                                                    </div>
                                                    @if($pemeriksaan && !$pemeriksaan->is_normal && $pemeriksaan->keterangan)
                                                        <p class="text-muted mt-2 mb-0">{{ $pemeriksaan->keterangan }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- 7. Discharge Planning -->
                            @if($rencanaPulang)
                            <div class="section-separator" id="discharge-planning">
                                <h5 class="section-title">7. Discharge Planning</h5>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Diagnosis Medis</label>
                                        <p>{{ $rencanaPulang->diagnosis_medis ?: '-' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Usia Lanjut</label>
                                        <p>{{ $rencanaPulang->usia_lanjut == 0 ? 'Ya' : 'Tidak' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Hambatan Mobilisasi</label>
                                        <p>{{ $rencanaPulang->hambatan_mobilisasi == 0 ? 'Ya' : 'Tidak' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Membutuhkan Pelayanan Medis Berkelanjutan</label>
                                        <p>{{ ucfirst($rencanaPulang->membutuhkan_pelayanan_medis ?: '-') }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Memerlukan Keterampilan Khusus</label>
                                        <p>{{ ucfirst($rencanaPulang->memerlukan_keterampilan_khusus ?: '-') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Memerlukan Alat Bantu</label>
                                        <p>{{ ucfirst($rencanaPulang->memerlukan_alat_bantu ?: '-') }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Memiliki Nyeri Kronis</label>
                                        <p>{{ ucfirst($rencanaPulang->memiliki_nyeri_kronis ?: '-') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Perkiraan Lama Dirawat</label>
                                        <p>{{ $rencanaPulang->perkiraan_lama_dirawat ? $rencanaPulang->perkiraan_lama_dirawat . ' hari' : '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Rencana Tanggal Pulang</label>
                                        <p>{{ $rencanaPulang->rencana_pulang ? Carbon\Carbon::parse($rencanaPulang->rencana_pulang)->format('d/m/Y') : '-' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Kesimpulan</label>
                                        <p>{{ $rencanaPulang->kesimpulan ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- 8. Diagnosis -->
                            <div class="section-separator" id="diagnosis">
                                <h5 class="section-title">8. Diagnosis</h5>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-primary">Diagnosis Banding</label>
                                        @if(!empty($diagnosisBanding) && count($diagnosisBanding) > 0)
                                            <ol class="ps-3">
                                                @foreach($diagnosisBanding as $diagnosis)
                                                    <li>{{ $diagnosis }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada diagnosis banding</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-primary">Diagnosis Kerja</label>
                                        @if(!empty($diagnosisKerja) && count($diagnosisKerja) > 0)
                                            <ol class="ps-3">
                                                @foreach($diagnosisKerja as $diagnosis)
                                                    <li>{{ $diagnosis }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada diagnosis kerja</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- 9. Implementasi -->
                            <div class="section-separator" id="implementasi">
                                <h5 class="section-title">9. Implementasi</h5>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Prognosis</label>
                                        @if(!empty($prognosis) && count($prognosis) > 0)
                                            <ol class="ps-3">
                                                @foreach($prognosis as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada data prognosis</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Observasi</label>
                                        @if(!empty($observasi) && count($observasi) > 0)
                                            <ol class="ps-3">
                                                @foreach($observasi as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada data observasi</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Terapeutik</label>
                                        @if(!empty($terapeutik) && count($terapeutik) > 0)
                                            <ol class="ps-3">
                                                @foreach($terapeutik as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada data terapeutik</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Edukasi</label>
                                        @if(!empty($edukasi) && count($edukasi) > 0)
                                            <ol class="ps-3">
                                                @foreach($edukasi as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada data edukasi</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Kolaborasi</label>
                                        @if(!empty($kolaborasi) && count($kolaborasi) > 0)
                                            <ol class="ps-3">
                                                @foreach($kolaborasi as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada data kolaborasi</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Info Tambahan -->
                            <div class="section-separator">
                                <h6 class="fw-bold">Informasi Asesmen</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">Waktu Asesmen: {{ Carbon\Carbon::parse($asesmen->waktu_asesmen)->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">Dibuat oleh: {{ $asesmen->user->name ?? 'Unknown' }}</small>
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
    </style>
@endpush