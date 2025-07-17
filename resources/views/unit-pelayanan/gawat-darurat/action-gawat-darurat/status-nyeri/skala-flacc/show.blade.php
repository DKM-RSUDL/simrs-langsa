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

        .flacc-breakdown-display {
            background-color: #f8f9fa;
            border: 2px solid #097dd6;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
        }

        .flacc-score-item {
            display: inline-block;
            margin: 0.25rem;
            padding: 0.5rem 0.75rem;
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            font-weight: 600;
            text-align: center;
        }

        .flacc-total-score {
            text-align: center;
            background: linear-gradient(135deg, #097dd6, #0056b3);
            color: white;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
        }

        .flacc-total-value {
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

        .flacc-letter {
            font-size: 1.2rem;
            font-weight: bold;
            color: #097dd6;
        }

        .flacc-category-name {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }

        .flacc-score-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #097dd6;
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
            <a href="{{ route('status-nyeri.skala-flacc.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" 
               class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="card">
                <div class="card-header">
                    <h5>Detail Asesmen Status Nyeri Skala FLACC</h5>
                </div>
                <div class="card-body">
                    
                    {{-- Informasi Dasar --}}
                    <h6 class="mb-3">Informasi Dasar</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <tr>
                            <td width="30%"><strong>Tanggal Implementasi</strong></td>
                            <td>{{ \Carbon\Carbon::parse($skalaFlacc->tanggal_implementasi)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jam Implementasi</strong></td>
                            <td>{{ date('H:i', strtotime($skalaFlacc->jam_implementasi)) }} WIB</td>
                        </tr>
                        <tr>
                            <td><strong>Total Nilai Nyeri</strong></td>
                            <td><h5 class="mb-0 text-primary">{{ $skalaFlacc->pain_value }}/10</h5></td>
                        </tr>
                        <tr>
                            <td><strong>Kategori Nyeri</strong></td>
                            <td>
                                @php
                                    $painValue = $skalaFlacc->pain_value;
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
                            <td>{{ $skalaFlacc->userCreated->name ?? 'N/A' }}</td>
                        </tr>
                    </table>

                    {{-- FLACC Score Breakdown --}}
                    <h6 class="mb-3">Detail Skor FLACC</h6>
                    <div class="flacc-breakdown-display">
                        <div class="row text-center">
                            <div class="col">
                                <div class="flacc-score-item">
                                    <div class="flacc-letter">F</div>
                                    <div class="flacc-category-name">Face</div>
                                    <div class="flacc-score-value">{{ $skalaFlacc->face }}</div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="flacc-score-item">
                                    <div class="flacc-letter">L</div>
                                    <div class="flacc-category-name">Legs</div>
                                    <div class="flacc-score-value">{{ $skalaFlacc->legs }}</div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="flacc-score-item">
                                    <div class="flacc-letter">A</div>
                                    <div class="flacc-category-name">Activity</div>
                                    <div class="flacc-score-value">{{ $skalaFlacc->activity }}</div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="flacc-score-item">
                                    <div class="flacc-letter">C</div>
                                    <div class="flacc-category-name">Cry</div>
                                    <div class="flacc-score-value">{{ $skalaFlacc->cry }}</div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="flacc-score-item">
                                    <div class="flacc-letter">C</div>
                                    <div class="flacc-category-name">Consolability</div>
                                    <div class="flacc-score-value">{{ $skalaFlacc->consolability }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flacc-total-score">
                            <div class="flacc-total-value">{{ $skalaFlacc->pain_value }}</div>
                            <div>Total Skor FLACC</div>
                        </div>
                    </div>

                    {{-- Detail Nyeri --}}
                    <h6 class="mb-3">Detail Nyeri</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <tr>
                            <td width="30%"><strong>Lokasi Nyeri</strong></td>
                            <td>{{ $skalaFlacc->lokasi_nyeri ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Durasi Nyeri</strong></td>
                            <td>{{ $skalaFlacc->durasi_nyeri ? $skalaFlacc->durasi_nyeri . ' menit' : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Apakah Nyeri Menjalar?</strong></td>
                            <td>{{ $skalaFlacc->menjalar ? ucfirst($skalaFlacc->menjalar) : '-' }}</td>
                        </tr>
                        @if($skalaFlacc->menjalar === 'ya' && $skalaFlacc->menjalar_keterangan)
                        <tr>
                            <td><strong>Menjalar Ke</strong></td>
                            <td>{{ $skalaFlacc->menjalar_keterangan }}</td>
                        </tr>
                        @endif
                    </table>

                    {{-- Karakteristik Nyeri --}}
                    <h6 class="mb-3">Karakteristik Nyeri</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <tr>
                            <td width="30%"><strong>Kualitas Nyeri</strong></td>
                            <td>{{ $skalaFlacc->kualitasNyeri->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Faktor Pemberat</strong></td>
                            <td>{{ $skalaFlacc->faktorPemberat->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Faktor Peringan</strong></td>
                            <td>{{ $skalaFlacc->faktorPeringan->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Efek Nyeri</strong></td>
                            <td>{{ $skalaFlacc->efekNyeri->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Nyeri</strong></td>
                            <td>{{ $skalaFlacc->jenisNyeri->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Frekuensi Nyeri</strong></td>
                            <td>{{ $skalaFlacc->frekuensiNyeri->name ?? '-' }}</td>
                        </tr>
                    </table>

                    {{-- Protokol Intervensi --}}
                    @if($skalaFlacc->pain_value > 0)
                        <h6 class="mb-3">Protokol Intervensi Status Nyeri</h6>
                        
                        {{-- Intervensi Nyeri Ringan --}}
                        @if($skalaFlacc->pain_value >= 1 && $skalaFlacc->pain_value <= 3)
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
                                            @if($skalaFlacc->nr_kaji_ulang_8jam)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Kaji ulang nyeri setiap 8 Jam</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaFlacc->nr_edukasi_pasien)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Edukasi pasien dan keluarga pasien mengenai nyeri</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaFlacc->nr_teknik_relaksasi)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Ajarkan tehnik relaksasi seperti tarik nafas dalam & panjang, tehnik distraksi</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaFlacc->nr_posisi_nyaman)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Beri posisi yang nyaman</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaFlacc->nr_nsaid)
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
                        @if($skalaFlacc->pain_value >= 4 && $skalaFlacc->pain_value <= 7)
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
                                            @if($skalaFlacc->ns_beritahu_tim_nyeri)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Bila pasien sudah ditangani oleh tim tatalaksana nyeri, maka beritahukan ke tim tatalaksana nyeri</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaFlacc->ns_rujuk_tim_nyeri)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Bila pasien belum pernah dirujuk ke tim tatalaksana nyeri, maka beritahukan ke DPJP untuk tatalaksana nyeri</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaFlacc->ns_kolaborasi_obat)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Kolaborasi dengan dokter untuk pemberian NSAID, Paracetamol, Opioid lemah (setelah persetujuan DPJP atau tim tatalaksana nyeri)</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaFlacc->ns_teknik_relaksasi)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Beritahukan pasien untuk tetap melakukan tehnik relaksasi dan tehnik distraksi yang disukai</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaFlacc->ns_posisi_nyaman)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Pertahankan posisi yang nyaman sesuai dengan kondisi pasien</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaFlacc->ns_edukasi_pasien)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Edukasi pasien dan keluarga pasien mengenai nyeri</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaFlacc->ns_kaji_ulang_2jam)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Kaji ulang derajat nyeri setiap 2 jam, sampai nyeri teratasi (&lt;4)</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaFlacc->ns_konsultasi_tim)
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
                        @if($skalaFlacc->pain_value >= 8 && $skalaFlacc->pain_value <= 10)
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
                                            @if($skalaFlacc->nt_semua_langkah_sedang)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Lakukan seluruh langkah derajat sedang</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaFlacc->nt_kaji_ulang_1jam)
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
                            <td>{{ $skalaFlacc->created_at ? \Carbon\Carbon::parse($skalaFlacc->created_at)->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Terakhir Diubah</strong></td>
                            <td>{{ $skalaFlacc->updated_at ? \Carbon\Carbon::parse($skalaFlacc->updated_at)->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                    </table>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('status-nyeri.skala-flacc.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" 
                           class="btn btn-secondary">
                            <i class="ti-arrow-left"></i> Kembali
                        </a>
                        <div>
                            <a href="{{ route('status-nyeri.skala-flacc.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $skalaFlacc->id]) }}" 
                               class="btn btn-warning">
                                <i class="ti-pencil"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection