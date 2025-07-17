@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .badge-nyeri-tidak {
            background-color: #28a745;
            color: white;
        }
        .badge-nyeri-ringan {
            background-color: #17a2b8;
            color: white;
        }
        .badge-nyeri-sedang {
            background-color: #ffc107;
            color: black;
        }
        .badge-nyeri-berat {
            background-color: #fd7e14;
            color: white;
        }
        .badge-nyeri-sangat-berat {
            background-color: #dc3545;
            color: white;
        }

        .cries-breakdown-display {
            background-color: #f8f9fa;
            border: 2px solid #097dd6;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
        }

        .cries-score-item {
            display: inline-block;
            margin: 0.25rem;
            padding: 0.5rem 0.75rem;
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            font-weight: 600;
        }

        .cries-total-score {
            text-align: center;
            background: linear-gradient(135deg, #097dd6, #0056b3);
            color: white;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
        }

        .cries-total-value {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .intervention-item {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 0.8rem;
            margin-bottom: 0.5rem;
            border-left: 4px solid #097dd6;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        {{-- Patient Card Column --}}
        <div class="col-md-3">
            @include('components.patient-card', ['dataMedis' => $dataMedis])
        </div>

        {{-- Detail Column --}}
        <div class="col-md-9">
            <a href="{{ route('rawat-jalan.status-nyeri.skala-cries.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" 
               class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="card">
                <div class="card-header">
                    <h5>Detail Asesmen Status Nyeri Skala CRIES</h5>
                </div>
                <div class="card-body">
                    
                    {{-- Informasi Dasar --}}
                    <h6 class="mb-3">Informasi Dasar</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <tr>
                            <td width="30%"><strong>Tanggal Implementasi</strong></td>
                            <td>{{ \Carbon\Carbon::parse($skalaCries->tanggal_implementasi)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jam Implementasi</strong></td>
                            <td>{{ $skalaCries->jam_implementasi }} WIB</td>
                        </tr>
                        <tr>
                            <td><strong>Total Nilai Nyeri</strong></td>
                            <td><h5 class="mb-0 text-primary">{{ $skalaCries->pain_value }}/10</h5></td>
                        </tr>
                        <tr>
                            <td><strong>Kategori Nyeri</strong></td>
                            <td>
                                @php
                                    $painValue = $skalaCries->pain_value;
                                    if ($painValue == 0) {
                                        $kategori = 'Tidak Nyeri';
                                        $badgeClass = 'badge-nyeri-tidak';
                                    } elseif ($painValue >= 1 && $painValue <= 3) {
                                        $kategori = 'Nyeri Ringan';
                                        $badgeClass = 'badge-nyeri-ringan';
                                    } elseif ($painValue >= 4 && $painValue <= 7) {
                                        $kategori = 'Nyeri Sedang';
                                        $badgeClass = 'badge-nyeri-sedang';
                                    } elseif ($painValue >= 8 && $painValue <= 10) {
                                        $kategori = 'Nyeri Berat';
                                        $badgeClass = 'badge-nyeri-berat';
                                    } else {
                                        $kategori = 'Invalid';
                                        $badgeClass = 'badge-secondary';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $kategori }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Petugas</strong></td>
                            <td>{{ $skalaCries->userCreated->name ?? 'N/A' }}</td>
                        </tr>
                    </table>

                    {{-- CRIES Score Breakdown --}}
                    <h6 class="mb-3">Detail Skor CRIES</h6>
                    <div class="cries-breakdown-display">
                        <div class="row text-center">
                            <div class="col">
                                <div class="cries-score-item">
                                    <strong>C</strong><br>
                                    Crying<br>
                                    <span class="text-primary fs-5">{{ $skalaCries->crying }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="cries-score-item">
                                    <strong>R</strong><br>
                                    Requires<br>
                                    <span class="text-primary fs-5">{{ $skalaCries->requires }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="cries-score-item">
                                    <strong>I</strong><br>
                                    Increased<br>
                                    <span class="text-primary fs-5">{{ $skalaCries->increased }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="cries-score-item">
                                    <strong>E</strong><br>
                                    Expression<br>
                                    <span class="text-primary fs-5">{{ $skalaCries->expression }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="cries-score-item">
                                    <strong>S</strong><br>
                                    Sleepless<br>
                                    <span class="text-primary fs-5">{{ $skalaCries->sleepless }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="cries-total-score">
                            <div class="cries-total-value">{{ $skalaCries->pain_value }}</div>
                            <div>Total Skor CRIES</div>
                        </div>
                    </div>

                    {{-- Detail Nyeri --}}
                    <h6 class="mb-3">Detail Nyeri</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <tr>
                            <td width="30%"><strong>Lokasi Nyeri</strong></td>
                            <td>{{ $skalaCries->lokasi_nyeri ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Durasi Nyeri</strong></td>
                            <td>{{ $skalaCries->durasi_nyeri ? $skalaCries->durasi_nyeri . ' menit' : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Apakah Nyeri Menjalar?</strong></td>
                            <td>{{ $skalaCries->menjalar ? ucfirst($skalaCries->menjalar) : '-' }}</td>
                        </tr>
                        @if($skalaCries->menjalar === 'ya' && $skalaCries->menjalar_keterangan)
                        <tr>
                            <td><strong>Menjalar Ke</strong></td>
                            <td>{{ $skalaCries->menjalar_keterangan }}</td>
                        </tr>
                        @endif
                    </table>

                    {{-- Karakteristik Nyeri --}}
                    <h6 class="mb-3">Karakteristik Nyeri</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <tr>
                            <td width="30%"><strong>Kualitas Nyeri</strong></td>
                            <td>{{ $skalaCries->kualitasNyeri->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Faktor Pemberat</strong></td>
                            <td>{{ $skalaCries->faktorPemberat->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Faktor Peringan</strong></td>
                            <td>{{ $skalaCries->faktorPeringan->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Efek Nyeri</strong></td>
                            <td>{{ $skalaCries->efekNyeri->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Nyeri</strong></td>
                            <td>{{ $skalaCries->jenisNyeri->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Frekuensi Nyeri</strong></td>
                            <td>{{ $skalaCries->frekuensiNyeri->name ?? '-' }}</td>
                        </tr>
                    </table>

                    {{-- Protokol Intervensi --}}
                    @if($skalaCries->pain_value > 0)
                        <h6 class="mb-3">Protokol Intervensi Status Nyeri</h6>
                        
                        {{-- Intervensi Nyeri Ringan --}}
                        @if($skalaCries->pain_value >= 1 && $skalaCries->pain_value <= 3)
                            <div class="alert alert-info">
                                <strong>Protokol Derajat Nyeri Ringan (Skor 1-3)</strong>
                            </div>
                            <table class="table table-bordered table-sm mb-4">
                                <thead class="table-light">
                                    <tr>
                                        <th width="10%">Status</th>
                                        <th>Intervensi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaCries->nr_kaji_ulang_8jam)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Kaji ulang nyeri setiap 8 Jam</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaCries->nr_edukasi_pasien)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Edukasi pasien dan keluarga pasien mengenai nyeri</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaCries->nr_teknik_relaksasi)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Ajarkan tehnik relaksasi seperti tarik nafas dalam & panjang, tehnik distraksi</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaCries->nr_posisi_nyaman)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Beri posisi yang nyaman</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaCries->nr_nsaid)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Bila perlu berikan Non Steroid Anti Inflammatory Drugs (NSAID)</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif

                        {{-- Intervensi Nyeri Sedang --}}
                        @if($skalaCries->pain_value >= 4 && $skalaCries->pain_value <= 7)
                            <div class="alert alert-warning">
                                <strong>Protokol Derajat Nyeri Sedang (Skor 4-7)</strong>
                            </div>
                            <table class="table table-bordered table-sm mb-4">
                                <thead class="table-light">
                                    <tr>
                                        <th width="10%">Status</th>
                                        <th>Intervensi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaCries->ns_beritahu_tim_nyeri)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Bila pasien sudah ditangani oleh tim tatalaksana nyeri, maka beritahukan ke tim tatalaksana nyeri</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaCries->ns_rujuk_tim_nyeri)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Bila pasien belum pernah dirujuk ke tim tatalaksana nyeri, maka beritahukan ke DPJP untuk tatalaksana nyeri</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaCries->ns_kolaborasi_obat)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Kolaborasi dengan dokter untuk pemberian NSAID, Paracetamol, Opioid lemah (setelah persetujuan DPJP atau tim tatalaksana nyeri)</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaCries->ns_teknik_relaksasi)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Beritahukan pasien untuk tetap melakukan tehnik relaksasi dan tehnik distraksi yang disukai</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaCries->ns_posisi_nyaman)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Pertahankan posisi yang nyaman sesuai dengan kondisi pasien</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaCries->ns_edukasi_pasien)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Edukasi pasien dan keluarga pasien mengenai nyeri</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaCries->ns_kaji_ulang_2jam)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Kaji ulang derajat nyeri setiap 2 jam, sampai nyeri teratasi (&lt;4)</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaCries->ns_konsultasi_tim)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Bila nyeri masih ada, konsultasikan ke Tim Tatalaksana Nyeri</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif

                        {{-- Intervensi Nyeri Berat --}}
                        @if($skalaCries->pain_value >= 8 && $skalaCries->pain_value <= 10)
                            <div class="alert alert-danger">
                                <strong>Protokol Derajat Nyeri Berat (Skor 8-10)</strong>
                            </div>
                            <table class="table table-bordered table-sm mb-4">
                                <thead class="table-light">
                                    <tr>
                                        <th width="10%">Status</th>
                                        <th>Intervensi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaCries->nt_semua_langkah_sedang)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Lakukan seluruh langkah derajat sedang</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaCries->nt_kaji_ulang_1jam)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Kaji ulang derajat nyeri setiap 1 jam, sampai nyeri menjadi nyeri sedang dikaji setiap 2 jam, dan bila nyeri telah teratasi setiap 8 jam</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    @endif

                    {{-- Informasi Tambahan --}}
                    <h6 class="mb-3">Informasi Tambahan</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <tr>
                            <td width="30%"><strong>Tanggal Pembuatan</strong></td>
                            <td>{{ $skalaCries->created_at ? \Carbon\Carbon::parse($skalaCries->created_at)->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Terakhir Diubah</strong></td>
                            <td>{{ $skalaCries->updated_at ? \Carbon\Carbon::parse($skalaCries->updated_at)->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                    </table>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('rawat-jalan.status-nyeri.skala-cries.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" 
                           class="btn btn-secondary">
                            <i class="ti-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection