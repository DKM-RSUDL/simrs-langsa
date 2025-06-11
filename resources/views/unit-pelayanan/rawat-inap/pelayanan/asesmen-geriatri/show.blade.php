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
                                        <h4 class="header-asesmen">Asesmen Medis Geriatri</h4>
                                        <p class="mb-0">
                                            Detail asesmen medis geriatri pasien
                                        </p>
                                    </div>
                                    <div>
                                        <a href="{{ route('rawat-inap.asesmen.medis.geriatri.edit', [
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
                                        <p>{{ Carbon\Carbon::parse($asesmenGeriatri->waktu_masuk)->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Kondisi Masuk</label>
                                        <p>{{ $asesmenGeriatri->kondisi_masuk ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Diagnosis Masuk</label>
                                        <p>{{ $asesmenGeriatri->diagnosis_masuk ?: '-' }}</p>
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
                                        <p class="text-justify">{{ $asesmenGeriatri->keluhan_utama ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Sensorium</label>
                                        <p>{{ $asesmenGeriatri->sensorium ?: '-' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Skala Nyeri</label>
                                        <p>{{ $asesmen->skala_nyeri ? $asesmen->skala_nyeri . '/10' : '-' }}</p>
                                    </div>
                                </div>

                                <!-- Vital Signs -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Vital Signs</label>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Tekanan Darah</label>
                                        <p>{{ $asesmenGeriatri->sistole && $asesmenGeriatri->diastole ? $asesmenGeriatri->sistole . '/' . $asesmenGeriatri->diastole . ' mmHg' : '-' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Suhu</label>
                                        <p>{{ $asesmenGeriatri->suhu ? $asesmenGeriatri->suhu . ' °C' : '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Respirasi</label>
                                        <p>{{ $asesmenGeriatri->respirasi ? $asesmenGeriatri->respirasi . ' x/menit' : '-' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Nadi</label>
                                        <p>{{ $asesmenGeriatri->nadi ? $asesmenGeriatri->nadi . ' x/menit' : '-' }}</p>
                                    </div>
                                </div>

                                <!-- Antropometri -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Berat Badan</label>
                                        <p>{{ $asesmenGeriatri->berat_badan ? $asesmenGeriatri->berat_badan . ' kg' : '-' }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Tinggi Badan</label>
                                        <p>{{ $asesmenGeriatri->tinggi_badan ? $asesmenGeriatri->tinggi_badan . ' cm' : '-' }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">IMT</label>
                                        <p>{{ $asesmenGeriatri->imt ? $asesmenGeriatri->imt . ' kg/m²' : '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Kategori IMT</label>
                                        @if ($kategoriImt && count($kategoriImt) > 0)
                                            <div class="d-flex gap-2 flex-wrap">
                                                @foreach ($kategoriImt as $kategori)
                                                    <span class="badge bg-primary">{{ $kategori }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">Tidak ada kategori IMT</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Riwayat Kesehatan -->
                            <div class="section-separator" id="riwayat-kesehatan">
                                <h5 class="section-title">3. Riwayat Kesehatan</h5>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Riwayat Penyakit Sekarang</label>
                                        <p class="text-justify">{{ $asesmenGeriatri->riwayat_penyakit_sekarang ?: '-' }}</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Riwayat Penyakit Terdahulu</label>
                                        <p>{{ $asesmenGeriatri->riwayat_penyakit_terdahulu ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Data Psikologi dan Sosial Ekonomi -->
                            <div class="section-separator" id="psikologi-sosial">
                                <h5 class="section-title">4. Data Psikologi dan Sosial Ekonomi</h5>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Kondisi Psikologi</label>
                                        <p>{{ $asesmenGeriatri->kondisi_psikologi ?: '-' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Kondisi Sosial Ekonomi</label>
                                        <p>{{ $asesmenGeriatri->kondisi_sosial_ekonomi ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- 5. Asesmen Geriatri -->
                            <div class="section-separator" id="asesmen-geriatri">
                                <h5 class="section-title">5. Asesmen Geriatri</h5>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">ADL (Activities of Daily Living)</label>
                                        @if ($adl && count($adl) > 0)
                                            <div class="d-flex gap-2 flex-wrap">
                                                @foreach ($adl as $item)
                                                    <span class="badge bg-info">{{ $item }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">Belum dinilai</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Kognitif</label>
                                        @if ($kognitif && count($kognitif) > 0)
                                            <div class="d-flex gap-2 flex-wrap">
                                                @foreach ($kognitif as $item)
                                                    <span class="badge {{ $item == 'Normal' ? 'bg-success' : 'bg-warning' }}">{{ $item }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">Belum dinilai</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Depresi</label>
                                        @if ($depresi && count($depresi) > 0)
                                            <div class="d-flex gap-2 flex-wrap">
                                                @foreach ($depresi as $item)
                                                    <span class="badge {{ $item == 'Normal' ? 'bg-success' : 'bg-warning' }}">{{ $item }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">Belum dinilai</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Inkontinensia</label>
                                        @if ($inkontinensia && count($inkontinensia) > 0)
                                            <div class="d-flex gap-2 flex-wrap">
                                                @foreach ($inkontinensia as $item)
                                                    <span class="badge {{ $item == 'Tidak Ada Inkontinensia' ? 'bg-success' : 'bg-warning' }}">{{ $item }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">Belum dinilai</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Insomnia</label>
                                        @if ($insomnia && count($insomnia) > 0)
                                            <div class="d-flex gap-2 flex-wrap">
                                                @foreach ($insomnia as $item)
                                                    <span class="badge {{ $item == 'Normal' ? 'bg-success' : 'bg-warning' }}">{{ $item }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">Belum dinilai</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- 6. Alergi -->
                            <div class="section-separator" id="alergi">
                                <h5 class="section-title">6. Alergi</h5>

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
                                                                @else bg-secondary @endif">
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

                            <!-- 7. Pemeriksaan Fisik -->
                            <div class="section-separator" id="pemeriksaan-fisik">
                                <h5 class="section-title">7. Pemeriksaan Fisik</h5>

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
                                                        @if ($pemeriksaan)
                                                            @if ($pemeriksaan->is_normal)
                                                                <span class="badge bg-success">Normal</span>
                                                            @else
                                                                <span class="badge bg-warning">Tidak Normal</span>
                                                            @endif
                                                        @else
                                                            <span class="badge bg-secondary">Tidak Diperiksa</span>
                                                        @endif
                                                    </div>
                                                    @if ($pemeriksaan && !$pemeriksaan->is_normal && $pemeriksaan->keterangan)
                                                        <p class="text-muted mt-2 mb-0">{{ $pemeriksaan->keterangan }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- 8. Discharge Planning -->
                            @if ($rencanaPulang)
                                <div class="section-separator" id="discharge-planning">
                                    <h5 class="section-title">8. Discharge Planning</h5>

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
                                            <label class="form-label fw-bold">Ketergantungan Aktivitas Harian</label>
                                            <p>{{ ucfirst($rencanaPulang->ketergantungan_aktivitas ?: '-') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Memerlukan Keterampilan Khusus</label>
                                            <p>{{ ucfirst($rencanaPulang->memerlukan_keterampilan_khusus ?: '-') }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Memerlukan Alat Bantu</label>
                                            <p>{{ ucfirst($rencanaPulang->memerlukan_alat_bantu ?: '-') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Memiliki Nyeri Kronis</label>
                                            <p>{{ ucfirst($rencanaPulang->memiliki_nyeri_kronis ?: '-') }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Perkiraan Lama Dirawat</label>
                                            <p>{{ $rencanaPulang->perkiraan_lama_dirawat ? $rencanaPulang->perkiraan_lama_dirawat . ' hari' : '-' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Rencana Tanggal Pulang</label>
                                            <p>{{ $rencanaPulang->rencana_pulang ? Carbon\Carbon::parse($rencanaPulang->rencana_pulang)->format('d/m/Y') : '-' }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label fw-bold">Kesimpulan</label>
                                            @if ($rencanaPulang->kesimpulan)
                                                @if (str_contains($rencanaPulang->kesimpulan, 'Mebutuhkan rencana pulang khusus'))
                                                    <span class="badge bg-warning fs-6">{{ $rencanaPulang->kesimpulan }}</span>
                                                @elseif (str_contains($rencanaPulang->kesimpulan, 'Tidak mebutuhkan rencana pulang khusus'))
                                                    <span class="badge bg-success fs-6">{{ $rencanaPulang->kesimpulan }}</span>
                                                @else
                                                    <span class="badge bg-info fs-6">{{ $rencanaPulang->kesimpulan }}</span>
                                                @endif
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- 9. Diagnosis -->
                            <div class="section-separator" id="diagnosis">
                                <h5 class="section-title">9. Diagnosis</h5>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-primary">Diagnosis Banding</label>
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
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-primary">Diagnosis Kerja</label>
                                        @if (!empty($diagnosisKerja) && count($diagnosisKerja) > 0)
                                            <ol class="ps-3">
                                                @foreach ($diagnosisKerja as $diagnosis)
                                                    <li>{{ $diagnosis }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="text-muted">Tidak ada diagnosis kerja</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

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

        /* Custom badge colors for better visibility */
        .badge.bg-info {
            background-color: #0dcaf0 !important;
        }

        .badge.bg-warning {
            background-color: #ffc107 !important;
            color: #000 !important;
        }

        .badge.bg-success {
            background-color: #198754 !important;
        }

        .badge.bg-danger {
            background-color: #dc3545 !important;
        }

        .badge.bg-primary {
            background-color: #0d6efd !important;
        }

        .badge.fs-6 {
            font-size: 1rem !important;
            padding: 0.5rem 1rem;
        }

        /* Responsive badges */
        @media (max-width: 768px) {
            .badge {
                font-size: 0.7rem;
                margin: 2px;
            }
        }
    </style>
@endpush