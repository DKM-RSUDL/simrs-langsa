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

        .pain-scale-image {
            text-align: center;
            margin: 1rem 0;
        }

        .pain-scale-image img {
            width: 400px;
            height: 120px;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
            <a href="{{ route('rawat-jalan.status-nyeri.skala-numerik.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" 
               class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="card">
                <div class="card-header">
                    <h5>Detail Asesmen Status Nyeri Skala Numerik</h5>
                </div>
                <div class="card-body">
                    
                    {{-- Informasi Dasar --}}
                    <h6 class="mb-3">Informasi Dasar</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <tr>
                            <td width="30%"><strong>Tanggal Implementasi</strong></td>
                            <td>{{ \Carbon\Carbon::parse($skalaNumerik->tanggal_implementasi)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jam Implementasi</strong></td>
                            <td>{{ $skalaNumerik->jam_implementasi }} WIB</td>
                        </tr>
                        <tr>
                            <td><strong>Tipe Skala Nyeri</strong></td>
                            <td><span class="badge bg-info text-white">{{ ucfirst(str_replace('_', ' ', $skalaNumerik->pain_scale_type)) }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Nilai Nyeri</strong></td>
                            <td><h5 class="mb-0 text-primary">{{ $skalaNumerik->pain_value }}/10</h5></td>
                        </tr>
                        <tr>
                            <td><strong>Kategori Nyeri</strong></td>
                            <td>
                                @php
                                    $painValue = $skalaNumerik->pain_value;
                                    if ($painValue == 0) {
                                        $kategori = 'Tidak Nyeri';
                                        $badgeClass = 'badge-nyeri-tidak';
                                    } elseif ($painValue >= 1 && $painValue <= 3) {
                                        $kategori = 'Ringan';
                                        $badgeClass = 'badge-nyeri-ringan';
                                    } elseif ($painValue >= 4 && $painValue <= 6) {
                                        $kategori = 'Sedang';
                                        $badgeClass = 'badge-nyeri-sedang';
                                    } elseif ($painValue >= 7 && $painValue <= 9) {
                                        $kategori = 'Berat';
                                        $badgeClass = 'badge-nyeri-berat';
                                    } else {
                                        $kategori = 'Sangat Berat';
                                        $badgeClass = 'badge-nyeri-sangat-berat';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $kategori }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Petugas</strong></td>
                            <td>{{ $skalaNumerik->userCreated->name ?? 'N/A' }}</td>
                        </tr>
                    </table>

                    {{-- Pain Scale Image --}}
                    <div class="pain-scale-image mb-4">
                        @if($skalaNumerik->pain_scale_type === 'numerik')
                            <img src="{{ asset('assets/img/asesmen/numerik.png') }}" alt="Numerik Pain Scale">
                        @else
                            <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}" alt="Wong Baker Face Pain Scale">
                        @endif
                    </div>

                    {{-- Detail Nyeri --}}
                    <h6 class="mb-3">Detail Nyeri</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <tr>
                            <td width="30%"><strong>Lokasi Nyeri</strong></td>
                            <td>{{ $skalaNumerik->lokasi_nyeri ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Durasi Nyeri</strong></td>
                            <td>{{ $skalaNumerik->durasi_nyeri ? $skalaNumerik->durasi_nyeri . ' menit' : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Apakah Nyeri Menjalar?</strong></td>
                            <td>{{ $skalaNumerik->menjalar ? ucfirst($skalaNumerik->menjalar) : '-' }}</td>
                        </tr>
                        @if($skalaNumerik->menjalar === 'ya' && $skalaNumerik->menjalar_keterangan)
                        <tr>
                            <td><strong>Menjalar Ke</strong></td>
                            <td>{{ $skalaNumerik->menjalar_keterangan }}</td>
                        </tr>
                        @endif
                    </table>

                    {{-- Karakteristik Nyeri --}}
                    <h6 class="mb-3">Karakteristik Nyeri</h6>
                    <table class="table table-bordered table-sm mb-4">
                        <tr>
                            <td width="30%"><strong>Kualitas Nyeri</strong></td>
                            <td>{{ $skalaNumerik->kualitasNyeri->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Faktor Pemberat</strong></td>
                            <td>{{ $skalaNumerik->faktorPemberat->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Faktor Peringan</strong></td>
                            <td>{{ $skalaNumerik->faktorPeringan->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Efek Nyeri</strong></td>
                            <td>{{ $skalaNumerik->efekNyeri->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Nyeri</strong></td>
                            <td>{{ $skalaNumerik->jenisNyeri->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Frekuensi Nyeri</strong></td>
                            <td>{{ $skalaNumerik->frekuensiNyeri->name ?? '-' }}</td>
                        </tr>
                    </table>

                    {{-- Protokol Intervensi --}}
                    @if($skalaNumerik->pain_value > 0)
                        <h6 class="mb-3">Protokol Intervensi Status Nyeri</h6>
                        
                        {{-- Intervensi Nyeri Ringan --}}
                        @if($skalaNumerik->pain_value >= 1 && $skalaNumerik->pain_value <= 3)
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
                                            @if($skalaNumerik->nr_kaji_ulang_8jam)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Kaji ulang nyeri setiap 8 Jam</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaNumerik->nr_edukasi_pasien)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Edukasi pasien dan keluarga pasien mengenai nyeri</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaNumerik->nr_teknik_relaksasi)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Ajarkan tehnik relaksasi seperti tarik nafas dalam & panjang, tehnik distraksi</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaNumerik->nr_posisi_nyaman)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Beri posisi yang nyaman</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaNumerik->nr_nsaid)
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
                        @if($skalaNumerik->pain_value >= 4 && $skalaNumerik->pain_value <= 6)
                            <div class="alert alert-warning">
                                <strong>Protokol Derajat Nyeri Sedang (Skor 4-6)</strong>
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
                                            @if($skalaNumerik->ns_beritahu_tim_nyeri)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Bila pasien sudah ditangani oleh tim tatalaksana nyeri, maka beritahukan ke tim tatalaksana nyeri</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaNumerik->ns_rujuk_tim_nyeri)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Bila pasien belum pernah dirujuk ke tim tatalaksana nyeri, maka beritahukan ke DPJP untuk tatalaksana nyeri</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaNumerik->ns_kolaborasi_obat)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Kolaborasi dengan dokter untuk pemberian NSAID, Paracetamol, Opioid lemah (setelah persetujuan DPJP atau tim tatalaksana nyeri)</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaNumerik->ns_teknik_relaksasi)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Beritahukan pasien untuk tetap melakukan tehnik relaksasi dan tehnik distraksi yang disukai</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaNumerik->ns_posisi_nyaman)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Pertahankan posisi yang nyaman sesuai dengan kondisi pasien</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaNumerik->ns_edukasi_pasien)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Edukasi pasien dan keluarga pasien mengenai nyeri</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaNumerik->ns_kaji_ulang_2jam)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Kaji ulang derajat nyeri setiap 2 jam, sampai nyeri teratasi (&lt;4)</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaNumerik->ns_konsultasi_tim)
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

                        {{-- Intervensi Nyeri Tinggi --}}
                        @if($skalaNumerik->pain_value >= 7 && $skalaNumerik->pain_value <= 10)
                            <div class="alert alert-danger">
                                <strong>Protokol Derajat Nyeri Tinggi (Skor 7-10)</strong>
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
                                            @if($skalaNumerik->nt_semua_langkah_sedang)
                                                <span class="badge bg-success">✓</span>
                                            @else
                                                <span class="badge bg-danger">✗</span>
                                            @endif
                                        </td>
                                        <td>Lakukan seluruh langkah derajat sedang</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($skalaNumerik->nt_kaji_ulang_1jam)
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
                            <td>{{ $skalaNumerik->created_at ? \Carbon\Carbon::parse($skalaNumerik->created_at)->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Terakhir Diubah</strong></td>
                            <td>{{ $skalaNumerik->updated_at ? \Carbon\Carbon::parse($skalaNumerik->updated_at)->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                    </table>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('rawat-jalan.status-nyeri.skala-numerik.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" 
                           class="btn btn-secondary">
                            <i class="ti-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection