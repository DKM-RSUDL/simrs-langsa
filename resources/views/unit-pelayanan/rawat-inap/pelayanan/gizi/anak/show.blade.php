@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .nav-link.active {
            background-color: #007bff !important;
            color: white !important;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
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

        .z-score-status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-normal { background-color: #d1e7dd; color: #0f5132; }
        .status-underweight { background-color: #fff3cd; color: #664d03; }
        .status-severely-underweight { background-color: #f8d7da; color: #721c24; }
        .status-overweight { background-color: #cff4fc; color: #055160; }
        .status-obese { background-color: #f8d7da; color: #721c24; }
        .status-stunted { background-color: #fff3cd; color: #664d03; }
        .status-severely-stunted { background-color: #f8d7da; color: #721c24; }
        .status-wasted { background-color: #fff3cd; color: #664d03; }
        .status-severely-wasted { background-color: #f8d7da; color: #721c24; }
        .status-tall { background-color: #cff4fc; color: #055160; }

        .alert-z-score {
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 8px;
            border-left: 4px solid;
        }

        .alert-success { border-left-color: #198754; background-color: #d1e7dd; }
        .alert-warning { border-left-color: #ffc107; background-color: #fff3cd; }
        .alert-danger { border-left-color: #dc3545; background-color: #f8d7da; }

        .nutrition-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .nutrition-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #495057;
        }

        .alergi-tag {
            display: inline-block;
            background-color: #f8d7da;
            color: #721c24;
            padding: 4px 8px;
            border-radius: 4px;
            margin: 2px;
            font-size: 0.875rem;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ url("unit-pelayanan/rawat-inap/unit/{$dataMedis->kd_unit}/pelayanan/{$dataMedis->kd_pasien}/" . date('Y-m-d', strtotime($dataMedis->tgl_masuk)) . "/{$dataMedis->urut_masuk}/gizi/anak") }}"
                    class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('rawat-inap.gizi.anak.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $dataPengkajianGizi->id]) }}" 
                   class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-clipboard-list"></i> Detail Pengkajian Gizi Anak</h5>
                </div>
                <div class="card-body">
                    
                    {{-- Info Dasar --}}
                    <div class="section-separator">
                        <h6 class="section-title">1. Informasi Dasar</h6>
                        <table class="table table-bordered">
                            <tr>
                                <td width="200px"><strong>Tanggal Asesmen</strong></td>
                                <td>{{ \Carbon\Carbon::parse($dataPengkajianGizi->waktu_asesmen)->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Diagnosis Medis</strong></td>
                                <td>{{ $dataPengkajianGizi->diagnosis_medis ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Petugas</strong></td>
                                <td>{{ $dataPengkajianGizi->userCreate->name ?? 'Tidak Diketahui' }}</td>
                            </tr>
                            @if($dataPengkajianGizi->userUpdate)
                            <tr>
                                <td><strong>Terakhir Diupdate</strong></td>
                                <td>{{ $dataPengkajianGizi->userUpdate->name ?? 'Tidak Diketahui' }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>

                    {{-- Kebiasaan Makan --}}
                    <div class="section-separator">
                        <h6 class="section-title">2. Asuhan Gizi Anak</h6>
                        
                        <h6>Kebiasaan Makan</h6>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="border rounded p-3 text-center">
                                    <h6 class="text-primary mb-2">Pagi</h6>
                                    <span class="badge {{ $dataPengkajianGizi->makan_pagi == 'ya' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($dataPengkajianGizi->makan_pagi ?: 'Tidak') }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 text-center">
                                    <h6 class="text-primary mb-2">Siang</h6>
                                    <span class="badge {{ $dataPengkajianGizi->makan_siang == 'ya' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($dataPengkajianGizi->makan_siang ?: 'Tidak') }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 text-center">
                                    <h6 class="text-primary mb-2">Malam</h6>
                                    <span class="badge {{ $dataPengkajianGizi->makan_malam == 'ya' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($dataPengkajianGizi->makan_malam ?: 'Tidak') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <tr>
                                <td width="200px"><strong>Frekuensi Ngemil</strong></td>
                                <td>{{ $dataPengkajianGizi->frekuensi_ngemil ?? 0 }} kali/hari</td>
                            </tr>
                        </table>

                        <h6 class="mt-4">Alergi & Pantangan</h6>
                        <table class="table table-bordered">
                            <tr>
                                <td width="200px"><strong>Alergi Makanan</strong></td>
                                <td>
                                    <span class="badge {{ $dataPengkajianGizi->alergi_makanan == 'ya' ? 'bg-warning' : 'bg-success' }}">
                                        {{ ucfirst($dataPengkajianGizi->alergi_makanan ?: 'Tidak') }}
                                    </span>
                                </td>
                            </tr>
                            @if($dataPengkajianGizi->alergi_makanan == 'ya')
                            <tr>
                                <td><strong>Jenis Alergi</strong></td>
                                <td>{{ $dataPengkajianGizi->jenis_alergi ?: '-' }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td><strong>Pantangan Makanan</strong></td>
                                <td>
                                    <span class="badge {{ $dataPengkajianGizi->pantangan_makanan == 'ya' ? 'bg-warning' : 'bg-success' }}">
                                        {{ ucfirst($dataPengkajianGizi->pantangan_makanan ?: 'Tidak') }}
                                    </span>
                                </td>
                            </tr>
                            @if($dataPengkajianGizi->pantangan_makanan == 'ya')
                            <tr>
                                <td><strong>Jenis Pantangan</strong></td>
                                <td>{{ $dataPengkajianGizi->jenis_pantangan ?: '-' }}</td>
                            </tr>
                            @endif
                        </table>

                        <h6 class="mt-4">Gangguan Gastrointestinal</h6>
                        <table class="table table-bordered">
                            <tr>
                                <td width="200px"><strong>Gangguan</strong></td>
                                <td>
                                    @if($dataPengkajianGizi->gangguan_gi_array && count($dataPengkajianGizi->gangguan_gi_array) > 0)
                                        @foreach($dataPengkajianGizi->gangguan_gi_array as $gangguan)
                                            <span class="badge bg-warning me-1">{{ ucwords(str_replace('_', ' ', $gangguan)) }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">Tidak ada gangguan</span>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <h6 class="mt-4">Frekuensi Makan Sebelum RS</h6>
                        <table class="table table-bordered">
                            <tr>
                                <td width="200px"><strong>Frekuensi</strong></td>
                                <td>
                                    @if($dataPengkajianGizi->frekuensi_makan_rs == 'lebih_3x')
                                        <span class="badge bg-success">Makan > 3x/hari</span>
                                    @elseif($dataPengkajianGizi->frekuensi_makan_rs == 'kurang_3x')
                                        <span class="badge bg-warning">Makan < 3x/hari</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                    {{-- Riwayat Alergi Detail --}}
                    @if($alergiPasien && $alergiPasien->count() > 0)
                    <div class="section-separator">
                        <h6 class="section-title">Riwayat Alergi Detail</h6>
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
                                        <td>
                                            <span class="alergi-tag">{{ $alergi->tingkat_keparahan }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    {{-- Bahan Makanan --}}
                    <div class="section-separator">
                        <h6 class="section-title">3. Bahan Makanan yang Bisa Dikonsumsi</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="nutrition-card">
                                    <h6 class="text-primary"><i class="fas fa-bread-slice"></i> Makanan Pokok</h6>
                                    <p class="mb-0">{{ $dataPengkajianGizi->makanan_pokok ?: 'Tidak disebutkan' }}</p>
                                </div>
                                <div class="nutrition-card">
                                    <h6 class="text-primary"><i class="fas fa-drumstick-bite"></i> Lauk Hewani</h6>
                                    <p class="mb-0">{{ $dataPengkajianGizi->lauk_hewani ?: 'Tidak disebutkan' }}</p>
                                </div>
                                <div class="nutrition-card">
                                    <h6 class="text-primary"><i class="fas fa-seedling"></i> Lauk Nabati</h6>
                                    <p class="mb-0">{{ $dataPengkajianGizi->lauk_nabati ?: 'Tidak disebutkan' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="nutrition-card">
                                    <h6 class="text-primary"><i class="fas fa-leaf"></i> Sayur-sayuran</h6>
                                    <p class="mb-0">{{ $dataPengkajianGizi->sayuran ?: 'Tidak disebutkan' }}</p>
                                </div>
                                <div class="nutrition-card">
                                    <h6 class="text-primary"><i class="fas fa-apple-alt"></i> Buah-buahan</h6>
                                    <p class="mb-0">{{ $dataPengkajianGizi->buah_buahan ?: 'Tidak disebutkan' }}</p>
                                </div>
                                <div class="nutrition-card">
                                    <h6 class="text-primary"><i class="fas fa-tint"></i> Minuman</h6>
                                    <p class="mb-0">{{ $dataPengkajianGizi->minuman ?: 'Tidak disebutkan' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Recall 24 Jam --}}
                    <div class="section-separator">
                        <h6 class="section-title">4. Recall Makanan 24 Jam</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Pagi Hari</h6>
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <td width="120px"><strong>Makan Pagi</strong></td>
                                        <td>{{ $dataPengkajianGizi->recall_makan_pagi ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Snack Pagi</strong></td>
                                        <td>{{ $dataPengkajianGizi->recall_snack_pagi ?: '-' }}</td>
                                    </tr>
                                </table>

                                <h6 class="text-primary mb-3 mt-4">Siang Hari</h6>
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <td width="120px"><strong>Makan Siang</strong></td>
                                        <td>{{ $dataPengkajianGizi->recall_makan_siang ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Snack Sore</strong></td>
                                        <td>{{ $dataPengkajianGizi->recall_snack_sore ?: '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Malam Hari</h6>
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <td width="120px"><strong>Makan Malam</strong></td>
                                        <td>{{ $dataPengkajianGizi->recall_makan_malam ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Snack Malam</strong></td>
                                        <td>{{ $dataPengkajianGizi->recall_snack_malam ?: '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Asupan Sebelum RS --}}
                    <div class="section-separator">
                        <h6 class="section-title">5. Asupan Sebelum Masuk RS</h6>
                        
                        @php
                            $asupan = $dataPengkajianGizi->asupan_sebelum_rs;
                            $badgeClass = '';
                            $statusText = ucfirst($asupan ?: 'Tidak Dinilai');
                            $description = '';
                            
                            switch($asupan) {
                                case 'lebih': 
                                    $badgeClass = 'bg-info text-white'; 
                                    $description = 'Asupan berlebihan dari kebutuhan normal';
                                    break;
                                case 'baik': 
                                    $badgeClass = 'bg-success text-white'; 
                                    $description = 'Asupan sesuai dengan kebutuhan';
                                    break;
                                case 'kurang': 
                                    $badgeClass = 'bg-warning text-dark'; 
                                    $description = 'Asupan kurang dari kebutuhan normal';
                                    break;
                                case 'buruk': 
                                    $badgeClass = 'bg-danger text-white'; 
                                    $description = 'Asupan sangat kurang dari kebutuhan';
                                    break;
                                default: 
                                    $badgeClass = 'bg-secondary text-white';
                                    $description = 'Status asupan belum dinilai';
                            }
                        @endphp
                        
                        <div class="card border-0" style="background-color: #f8f9fa;">
                            <div class="card-body py-4">
                                <div class="mb-3">
                                    <span class="badge {{ $badgeClass }} fs-5 px-4 py-2 rounded-pill">
                                        {{ $statusText }}
                                    </span>
                                </div>
                                <p class="text-muted mb-0 small">{{ $description }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Antropometri & Z-Score --}}
                    @if($dataPengkajianGizi->asesmenGizi)
                    <div class="section-separator">
                        <h6 class="section-title">6. Antropometri & Z-Score</h6>
                        
                        {{-- Data Dasar --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <td width="150px"><strong>Berat Badan</strong></td>
                                        <td class="nutrition-value">{{ $dataPengkajianGizi->asesmenGizi->berat_badan ? number_format((float)$dataPengkajianGizi->asesmenGizi->berat_badan, 1, '.', '') : '-' }} kg</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tinggi Badan</strong></td>
                                        <td class="nutrition-value">{{ $dataPengkajianGizi->asesmenGizi->tinggi_badan ? number_format((float)$dataPengkajianGizi->asesmenGizi->tinggi_badan, 1, '.', '') : '-' }} cm</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <td width="150px"><strong>BBI</strong></td>
                                        <td class="nutrition-value">{{ $dataPengkajianGizi->asesmenGizi->bbi ? number_format((float)$dataPengkajianGizi->asesmenGizi->bbi, 1, '.', '') : '-' }} kg</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Lingkar Kepala</strong></td>
                                        <td class="nutrition-value">{{ $dataPengkajianGizi->asesmenGizi->lingkar_kepala ? number_format((float)$dataPengkajianGizi->asesmenGizi->lingkar_kepala, 1, '.', '') : '-' }} cm</td>
                                    </tr>
                                    @if($dataPengkajianGizi->asesmenGizi->status_stunting)
                                    <tr>
                                        <td><strong>Status Stunting</strong></td>
                                        <td>
                                            <span class="badge {{ $dataPengkajianGizi->asesmenGizi->status_stunting == 'Stunting' ? 'bg-danger' : 'bg-success' }}">
                                                {{ $dataPengkajianGizi->asesmenGizi->status_stunting }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>

                        {{-- Z-Score Results --}}
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-chart-line"></i> Hasil Z-Score (WHO Child Growth Standards)
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">BB/Usia (Weight-for-Age)</h6>
                                        <p class="card-text">
                                            Z-Score: <strong>{{ $dataPengkajianGizi->asesmenGizi->bb_usia ? number_format((float)$dataPengkajianGizi->asesmenGizi->bb_usia, 2, '.', '') : '-' }}</strong>
                                        </p>
                                        @if($dataPengkajianGizi->asesmenGizi->bb_usia)
                                            @php
                                                $bbUsiaStatus = '';
                                                $bbUsiaZScore = (float)$dataPengkajianGizi->asesmenGizi->bb_usia;
                                                if ($bbUsiaZScore < -3) $bbUsiaStatus = 'Severely Underweight';
                                                elseif ($bbUsiaZScore < -2) $bbUsiaStatus = 'Underweight';
                                                elseif ($bbUsiaZScore > 1) $bbUsiaStatus = 'Overweight';
                                                else $bbUsiaStatus = 'Normal';
                                            @endphp
                                            <span class="z-score-status status-{{ strtolower(str_replace(' ', '-', $bbUsiaStatus)) }}">
                                                {{ $bbUsiaStatus }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">PB(TB)/Usia (Height-for-Age)</h6>
                                        <p class="card-text">
                                            Z-Score: <strong>{{ $dataPengkajianGizi->asesmenGizi->pb_tb_usia ? number_format((float)$dataPengkajianGizi->asesmenGizi->pb_tb_usia, 2, '.', '') : '-' }}</strong>
                                        </p>
                                        @if($dataPengkajianGizi->asesmenGizi->pb_tb_usia)
                                            @php
                                                $pbTbUsiaStatus = '';
                                                $pbTbUsiaZScore = (float)$dataPengkajianGizi->asesmenGizi->pb_tb_usia;
                                                if ($pbTbUsiaZScore < -3) $pbTbUsiaStatus = 'Severely Stunted';
                                                elseif ($pbTbUsiaZScore < -2) $pbTbUsiaStatus = 'Stunted';
                                                elseif ($pbTbUsiaZScore > 3) $pbTbUsiaStatus = 'Tall';
                                                else $pbTbUsiaStatus = 'Normal';
                                            @endphp
                                            <span class="z-score-status status-{{ strtolower(str_replace(' ', '-', $pbTbUsiaStatus)) }}">
                                                {{ $pbTbUsiaStatus }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">BB/TB(PB) (Weight-for-Height)</h6>
                                        <p class="card-text">
                                            Z-Score: <strong>{{ $dataPengkajianGizi->asesmenGizi->bb_tb ? number_format((float)$dataPengkajianGizi->asesmenGizi->bb_tb, 2, '.', '') : '-' }}</strong>
                                        </p>
                                        @if($dataPengkajianGizi->asesmenGizi->bb_tb)
                                            @php
                                                $bbTbStatus = '';
                                                $bbTbZScore = (float)$dataPengkajianGizi->asesmenGizi->bb_tb;
                                                if ($bbTbZScore < -3) $bbTbStatus = 'Severely Wasted';
                                                elseif ($bbTbZScore < -2) $bbTbStatus = 'Wasted';
                                                elseif ($bbTbZScore > 2) $bbTbStatus = 'Obese';
                                                elseif ($bbTbZScore > 1) $bbTbStatus = 'Overweight';
                                                else $bbTbStatus = 'Normal';
                                            @endphp
                                            <span class="z-score-status status-{{ strtolower(str_replace(' ', '-', $bbTbStatus)) }}">
                                                {{ $bbTbStatus }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">IMT/Usia (BMI-for-Age)</h6>
                                        <p class="card-text">
                                            Z-Score: <strong>{{ $dataPengkajianGizi->asesmenGizi->imt_usia ? number_format((float)$dataPengkajianGizi->asesmenGizi->imt_usia, 2, '.', '') : '-' }}</strong>
                                        </p>
                                        @if($dataPengkajianGizi->asesmenGizi->imt_usia)
                                            @php
                                                $imtUsiaStatus = '';
                                                $imtUsiaZScore = (float)$dataPengkajianGizi->asesmenGizi->imt_usia;
                                                if ($imtUsiaZScore < -3) $imtUsiaStatus = 'Severely Underweight';
                                                elseif ($imtUsiaZScore < -2) $imtUsiaStatus = 'Underweight';
                                                elseif ($imtUsiaZScore > 2) $imtUsiaStatus = 'Obese';
                                                elseif ($imtUsiaZScore > 1) $imtUsiaStatus = 'Overweight';
                                                else $imtUsiaStatus = 'Normal';
                                            @endphp
                                            <span class="z-score-status status-{{ strtolower(str_replace(' ', '-', $imtUsiaStatus)) }}">
                                                {{ $imtUsiaStatus }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Alert untuk status gizi khusus --}}
                        @if($dataPengkajianGizi->asesmenGizi->bb_tb && (float)$dataPengkajianGizi->asesmenGizi->bb_tb < -3)
                        <div class="alert-z-score alert-danger">
                            <h6><i class="fas fa-exclamation-triangle"></i> Peringatan: Status Gizi Buruk Terdeteksi</h6>
                            <p class="mb-0">Pasien mengalami severely wasted (BB/TB Z-Score < -3 SD). Diperlukan protokol rehabilitasi gizi buruk dengan monitoring ketat.</p>
                        </div>
                        @elseif($dataPengkajianGizi->asesmenGizi->pb_tb_usia && (float)$dataPengkajianGizi->asesmenGizi->pb_tb_usia < -2)
                        <div class="alert-z-score alert-warning">
                            <h6><i class="fas fa-info-circle"></i> Perhatian: Risiko Stunting</h6>
                            <p class="mb-0">Pasien mengalami stunting (PB/TB/Usia Z-Score < -2 SD). Diperlukan intervensi gizi dan monitoring pertumbuhan.</p>
                        </div>
                        @endif

                        <h6 class="mt-4">Asesmen Klinis Lainnya</h6>
                        <table class="table table-bordered">
                            <tr>
                                <td width="200px"><strong>Biokimia</strong></td>
                                <td>{{ $dataPengkajianGizi->asesmenGizi->biokimia ?: 'Tidak ada data' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kimia/Fisik</strong></td>
                                <td>{{ $dataPengkajianGizi->asesmenGizi->kimia_fisik ?: 'Tidak ada data' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Riwayat Gizi</strong></td>
                                <td>{{ $dataPengkajianGizi->asesmenGizi->riwayat_gizi ?: 'Tidak ada data' }}</td>
                            </tr>
                        </table>
                    </div>
                    @endif

                    {{-- Intervensi Gizi --}}
                    @if($dataPengkajianGizi->intervensiGizi)
                        <div class="section-separator">
                            <h6 class="section-title">Intervensi Gizi</h6>
                            
                            @php
                                $intervensi = $dataPengkajianGizi->intervensiGizi;
                                $isGiziBuruk = $intervensi->mode_perhitungan == 'gizi_buruk';
                                
                                // Map golongan_umur untuk display
                                $golonganUmurMap = [
                                    '1' => '0-1 Tahun',
                                    '2' => '1-3 Tahun', 
                                    '3' => '4-6 Tahun',
                                    '4' => '6-9 Tahun',
                                    '5' => '10-13 Tahun',
                                    '6' => '14-18 Tahun',
                                    '7' => 'Stabilisasi',
                                    '8' => 'Transisi',
                                    '9' => 'Rehabilitasi'
                                ];
                            @endphp

                            @if($isGiziBuruk)
                            <div class="alert alert-warning">
                                <h6><i class="fas fa-exclamation-triangle"></i> Mode Rehabilitasi Gizi Buruk</h6>
                                <p class="mb-0">Menggunakan protokol khusus untuk pasien dengan status gizi buruk (severely wasted)</p>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary">Kebutuhan Kalori</h6>
                                    <table class="table table-bordered table-sm">
                                        @if($isGiziBuruk)
                                        <tr>
                                            <td><strong>Fase Rehabilitasi</strong></td>
                                            <td>{{ $golonganUmurMap[$intervensi->golongan_umur] ?? 'Tidak Diketahui' }}</td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td><strong>Golongan Umur</strong></td>
                                            <td>{{ $golonganUmurMap[$intervensi->golongan_umur] ?? 'Tidak Diketahui' }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><strong>Rentang Kalori</strong></td>
                                            <td>{{ $intervensi->rentang_kalori ?: '-' }} Kkal/kg BB</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kebutuhan Kalori</strong></td>
                                            <td><strong>{{ $intervensi->kebutuhan_kalori_per_kg ?: '-' }} Kkal/kg BB</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Kebutuhan</strong></td>
                                            <td><strong>{{ $intervensi->total_kebutuhan_kalori ? number_format($intervensi->total_kebutuhan_kalori, 0) : '-' }} Kkal</strong></td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6 class="text-primary">Distribusi Makronutrien</h6>
                                    
                                    @if($isGiziBuruk)
                                    {{-- Mode Gizi Buruk: Gram per kg BB --}}
                                    <table class="table table-bordered table-sm">
                                        <tr>
                                            <td width="120px"><strong>Protein</strong></td>
                                            <td>{{ $intervensi->protein_gram_per_kg ? number_format($intervensi->protein_gram_per_kg, 1) : '-' }} gr/kg BB = {{ $intervensi->protein_gram ? number_format($intervensi->protein_gram, 1) : '-' }} gr</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Lemak</strong></td>
                                            <td>{{ $intervensi->lemak_gram_per_kg ? number_format($intervensi->lemak_gram_per_kg, 1) : '-' }} gr/kg BB = {{ $intervensi->lemak_gram ? number_format($intervensi->lemak_gram, 1) : '-' }} gr</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Karbohidrat</strong></td>
                                            <td>{{ $intervensi->kh_gram_per_kg ? number_format($intervensi->kh_gram_per_kg, 1) : '-' }} gr/kg BB = {{ $intervensi->kh_gram ? number_format($intervensi->kh_gram, 1) : '-' }} gr</td>
                                        </tr>
                                    </table>
                                    @else
                                    {{-- Mode Normal: Persentase --}}
                                    <table class="table table-bordered table-sm">
                                        <tr>
                                            <td width="120px"><strong>Protein</strong></td>
                                            <td>{{ $intervensi->protein_persen ? number_format($intervensi->protein_persen, 1) : '-' }}% = {{ $intervensi->protein_gram ? number_format($intervensi->protein_gram, 1) : '-' }} gr</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Lemak</strong></td>
                                            <td>{{ $intervensi->lemak_persen ? number_format($intervensi->lemak_persen, 1) : '-' }}% = {{ $intervensi->lemak_gram ? number_format($intervensi->lemak_gram, 1) : '-' }} gr</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Karbohidrat</strong></td>
                                            <td>{{ $intervensi->kh_persen ? number_format($intervensi->kh_persen, 1) : '-' }}% = {{ $intervensi->kh_gram ? number_format($intervensi->kh_gram, 1) : '-' }} gr</td>
                                        </tr>
                                    </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Diagnosa Gizi --}}
                    <div class="section-separator">
                        <h6 class="section-title">8. Diagnosa Gizi</h6>
                        <div class="alert alert-info">
                            <h6><i class="fas fa-stethoscope"></i> Diagnosa Gizi</h6>
                            <p class="mb-0">{{ $dataPengkajianGizi->diagnosa_gizi ?: 'Belum ada diagnosa gizi yang ditetapkan' }}</p>
                        </div>
                    </div>

                    {{-- Data Monitoring Gizi --}}
                    <div class="section-separator">
                        <h6 class="section-title">Data Monitoring dan Evaluasi Gizi</h6>
                        @if($monitoringGizi && $monitoringGizi->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="15%">Tanggal/Jam</th>
                                            <th width="12%">Energi (Kkal)</th>
                                            <th width="12%">Protein (g)</th>
                                            <th width="12%">KH (g)</th>
                                            <th width="12%">Lemak (g)</th>
                                            <th width="16%">Masalah Perkembangan</th>
                                            <th width="16%">Tindak Lanjut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($monitoringGizi as $index => $monitoring)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($monitoring->tanggal_monitoring)->format('d/m/Y H:i') }}</td>
                                                <td class="text-end">{{ number_format($monitoring->energi, 1) }}</td>
                                                <td class="text-end">{{ number_format($monitoring->protein, 1) }}</td>
                                                <td class="text-end">{{ number_format($monitoring->karbohidrat, 1) }}</td>
                                                <td class="text-end">{{ number_format($monitoring->lemak, 1) }}</td>
                                                <td>{{ $monitoring->masalah_perkembangan ?: '-' }}</td>
                                                <td>{{ $monitoring->tindak_lanjut ?: '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-chart-line"></i>
                                <h6>Belum ada data monitoring gizi</h6>
                                <p class="text-muted">Data monitoring dan evaluasi gizi akan ditampilkan di sini setelah dilakukan pemantauan berkala.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Summary/Ringkasan --}}
                    <div class="section-separator">
                        <h6 class="section-title">Ringkasan Pengkajian</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0"><i class="fas fa-user-md"></i> Status Gizi</h6>
                                    </div>
                                    <div class="card-body">
                                        @if($dataPengkajianGizi->asesmenGizi)
                                            @php
                                                $bbTbZScore = $dataPengkajianGizi->asesmenGizi->bb_tb ? (float)$dataPengkajianGizi->asesmenGizi->bb_tb : null;
                                                $pbTbUsiaZScore = $dataPengkajianGizi->asesmenGizi->pb_tb_usia ? (float)$dataPengkajianGizi->asesmenGizi->pb_tb_usia : null;
                                                
                                                $statusGizi = 'Normal';
                                                $badgeClass = 'bg-success';
                                                
                                                if ($bbTbZScore !== null) {
                                                    if ($bbTbZScore < -3) {
                                                        $statusGizi = 'Gizi Buruk (Severely Wasted)';
                                                        $badgeClass = 'bg-danger';
                                                    } elseif ($bbTbZScore < -2) {
                                                        $statusGizi = 'Gizi Kurang (Wasted)';
                                                        $badgeClass = 'bg-warning';
                                                    } elseif ($bbTbZScore > 2) {
                                                        $statusGizi = 'Obesitas';
                                                        $badgeClass = 'bg-danger';
                                                    } elseif ($bbTbZScore > 1) {
                                                        $statusGizi = 'Gizi Lebih (Overweight)';
                                                        $badgeClass = 'bg-info';
                                                    }
                                                }
                                                
                                                $statusPertumbuhan = 'Normal';
                                                $badgeClassPertumbuhan = 'bg-success';
                                                
                                                if ($pbTbUsiaZScore !== null) {
                                                    if ($pbTbUsiaZScore < -3) {
                                                        $statusPertumbuhan = 'Severely Stunted';
                                                        $badgeClassPertumbuhan = 'bg-danger';
                                                    } elseif ($pbTbUsiaZScore < -2) {
                                                        $statusPertumbuhan = 'Stunted';
                                                        $badgeClassPertumbuhan = 'bg-warning';
                                                    } elseif ($pbTbUsiaZScore > 3) {
                                                        $statusPertumbuhan = 'Tinggi';
                                                        $badgeClassPertumbuhan = 'bg-info';
                                                    }
                                                }
                                            @endphp
                                            
                                            <p><strong>Status Gizi:</strong><br>
                                            <span class="badge {{ $badgeClass }} fs-6">{{ $statusGizi }}</span></p>
                                            
                                            <p><strong>Status Pertumbuhan:</strong><br>
                                            <span class="badge {{ $badgeClassPertumbuhan }} fs-6">{{ $statusPertumbuhan }}</span></p>
                                            
                                            @if($dataPengkajianGizi->asesmenGizi->status_stunting)
                                            <p><strong>Analisis Stunting:</strong><br>
                                            <span class="badge {{ $dataPengkajianGizi->asesmenGizi->status_stunting == 'Stunting' ? 'bg-danger' : 'bg-success' }} fs-6">
                                                {{ $dataPengkajianGizi->asesmenGizi->status_stunting }}
                                            </span></p>
                                            @endif
                                        @else
                                            <p class="text-muted">Data asesmen gizi tidak tersedia</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card border-info">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0"><i class="fas fa-utensils"></i> Kebutuhan Gizi</h6>
                                    </div>
                                    <div class="card-body">
                                        @if($dataPengkajianGizi->intervensiGizi)
                                            <p><strong>Total Kalori:</strong><br>
                                            {{ $dataPengkajianGizi->intervensiGizi->total_kebutuhan_kalori ? number_format($dataPengkajianGizi->intervensiGizi->total_kebutuhan_kalori, 0) : '-' }} Kkal/hari</p>
                                            
                                            <p><strong>Protein:</strong> {{ $dataPengkajianGizi->intervensiGizi->protein_gram ? number_format($dataPengkajianGizi->intervensiGizi->protein_gram, 1) : '-' }} gr/hari</p>
                                            
                                            <p><strong>Lemak:</strong> {{ $dataPengkajianGizi->intervensiGizi->lemak_gram ? number_format($dataPengkajianGizi->intervensiGizi->lemak_gram, 1) : '-' }} gr/hari</p>
                                            
                                            <p class="mb-0"><strong>Karbohidrat:</strong> {{ $dataPengkajianGizi->intervensiGizi->kh_gram ? number_format($dataPengkajianGizi->intervensiGizi->kh_gram, 1) : '-' }} gr/hari</p>
                                            
                                            @if($dataPengkajianGizi->intervensiGizi->mode_perhitungan == 'gizi_buruk')
                                            <hr>
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle"></i> 
                                                Menggunakan protokol rehabilitasi gizi buruk
                                            </small>
                                            @endif
                                        @else
                                            <p class="text-muted">Data intervensi gizi tidak tersedia</p>
                                        @endif
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