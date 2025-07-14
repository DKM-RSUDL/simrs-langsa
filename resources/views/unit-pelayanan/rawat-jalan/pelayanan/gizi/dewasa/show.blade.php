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

        .badge-energy { background-color: #007bff; }
        .badge-protein { background-color: #28a745; }
        .badge-carb { background-color: #ffc107; color: #212529; }
        .badge-fat { background-color: #dc3545; }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ url("unit-pelayanan/rawat-jalan/unit/{$dataMedis->kd_unit}/pelayanan/{$dataMedis->kd_pasien}/" . date('Y-m-d', strtotime($dataMedis->tgl_masuk)) . "/{$dataMedis->urut_masuk}/gizi/dewasa") }}"
                    class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('rawat-jalan.gizi.dewasa.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $dataGiziDewasa->id]) }}" 
                   class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Detail Pengkajian Gizi Dewasa</h5>
                </div>
                <div class="card-body">
                    
                    {{-- Info Dasar --}}
                    <table class="table table-bordered">
                        <tr>
                            <td width="200px"><strong>Tanggal Asesmen</strong></td>
                            <td>{{ \Carbon\Carbon::parse($dataGiziDewasa->waktu_asesmen)->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diagnosis Medis</strong></td>
                            <td>{{ $dataGiziDewasa->diagnosis_medis ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Petugas</strong></td>
                            <td>{{ $dataGiziDewasa->userCreate->name ?? 'Tidak Diketahui' }}</td>
                        </tr>
                    </table>

                    <hr>

                    {{-- Kebiasaan Makan --}}
                    <h6>Riwayat Gizi - Kebiasaan Makan</h6>
                    <table class="table table-bordered">
                        <tr>
                            <td width="200px"><strong>Makan Pagi</strong></td>
                            <td>{{ ucfirst($dataGiziDewasa->makan_pagi ?: 'Tidak') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Makan Siang</strong></td>
                            <td>{{ ucfirst($dataGiziDewasa->makan_siang ?: 'Tidak') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Makan Malam</strong></td>
                            <td>{{ ucfirst($dataGiziDewasa->makan_malam ?: 'Tidak') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Frekuensi Ngemil</strong></td>
                            <td>{{ $dataGiziDewasa->frekuensi_ngemil ?? 0 }} kali/hari</td>
                        </tr>
                    </table>

                    <hr>

                    {{-- Alergi & Pantangan --}}
                    <h6>Alergi & Pantangan</h6>
                    <table class="table table-bordered">
                        <tr>
                            <td width="200px"><strong>Alergi Makanan</strong></td>
                            <td>{{ ucfirst($dataGiziDewasa->alergi_makanan ?: 'Tidak') }}</td>
                        </tr>
                        @if($dataGiziDewasa->alergi_makanan == 'ya')
                        <tr>
                            <td><strong>Jenis Alergi</strong></td>
                            <td>{{ $dataGiziDewasa->jenis_alergi ?: '-' }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>Pantangan Makanan</strong></td>
                            <td>{{ ucfirst($dataGiziDewasa->pantangan_makanan ?: 'Tidak') }}</td>
                        </tr>
                        @if($dataGiziDewasa->pantangan_makanan == 'ya')
                        <tr>
                            <td><strong>Jenis Pantangan</strong></td>
                            <td>{{ $dataGiziDewasa->jenis_pantangan ?: '-' }}</td>
                        </tr>
                        @endif
                    </table>

                    <hr>

                    {{-- Gangguan GI --}}
                    <h6>Gangguan Gastrointestinal</h6>
                    <table class="table table-bordered">
                        <tr>
                            <td width="200px"><strong>Gangguan</strong></td>
                            <td>
                                @if($dataGiziDewasa->gangguan_gi)
                                    @php
                                        $gangguanList = explode(',', $dataGiziDewasa->gangguan_gi);
                                        $gangguanFormatted = array_map(function($item) {
                                            return str_replace('_', ' ', ucfirst(trim($item)));
                                        }, $gangguanList);
                                    @endphp
                                    {{ implode(', ', $gangguanFormatted) }}
                                @else
                                    Tidak ada
                                @endif
                            </td>
                        </tr>
                    </table>

                    <hr>

                    {{-- Frekuensi Makan RS --}}
                    <h6>Frekuensi Makan Sebelum RS</h6>
                    <table class="table table-bordered">
                        <tr>
                            <td width="200px"><strong>Frekuensi</strong></td>
                            <td>
                                @if($dataGiziDewasa->frekuensi_makan_rs == 'lebih_3x')
                                    Makan > 3x/hari
                                @elseif($dataGiziDewasa->frekuensi_makan_rs == 'kurang_3x')
                                    Makan < 3x/hari
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>

                    <hr>

                    {{-- Bahan Makanan --}}
                    <h6>Bahan Makanan yang Bisa Dikonsumsi</h6>
                    <table class="table table-bordered">
                        <tr>
                            <td width="200px"><strong>Makanan Pokok</strong></td>
                            <td>{{ $dataGiziDewasa->makanan_pokok ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Lauk Hewani</strong></td>
                            <td>{{ $dataGiziDewasa->lauk_hewani ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Lauk Nabati</strong></td>
                            <td>{{ $dataGiziDewasa->lauk_nabati ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Sayuran</strong></td>
                            <td>{{ $dataGiziDewasa->sayuran ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Buah-buahan</strong></td>
                            <td>{{ $dataGiziDewasa->buah_buahan ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Minuman</strong></td>
                            <td>{{ $dataGiziDewasa->minuman ?: '-' }}</td>
                        </tr>
                    </table>

                    <hr>

                    {{-- Recall 24 Jam --}}
                    <h6>Recall Makanan 24 Jam</h6>
                    <table class="table table-bordered">
                        <tr>
                            <td width="200px"><strong>Makan Pagi</strong></td>
                            <td>{{ $dataGiziDewasa->recall_makan_pagi ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Snack Pagi</strong></td>
                            <td>{{ $dataGiziDewasa->recall_snack_pagi ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Makan Siang</strong></td>
                            <td>{{ $dataGiziDewasa->recall_makan_siang ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Snack Sore</strong></td>
                            <td>{{ $dataGiziDewasa->recall_snack_sore ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Makan Malam</strong></td>
                            <td>{{ $dataGiziDewasa->recall_makan_malam ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Snack Malam</strong></td>
                            <td>{{ $dataGiziDewasa->recall_snack_malam ?: '-' }}</td>
                        </tr>
                    </table>

                    <hr>

                    {{-- Asupan Sebelum RS --}}
                    <h6>Asupan Sebelum Masuk RS</h6>
                    <table class="table table-bordered">
                        <tr>
                            <td width="200px"><strong>Penilaian Asupan</strong></td>
                            <td>
                                @if($dataGiziDewasa->asupan_sebelum_rs)
                                    <span class="badge 
                                        @if($dataGiziDewasa->asupan_sebelum_rs == 'lebih') bg-success
                                        @elseif($dataGiziDewasa->asupan_sebelum_rs == 'baik') bg-primary
                                        @elseif($dataGiziDewasa->asupan_sebelum_rs == 'kurang') bg-warning
                                        @elseif($dataGiziDewasa->asupan_sebelum_rs == 'buruk') bg-danger
                                        @else bg-secondary
                                        @endif">
                                        {{ strtoupper($dataGiziDewasa->asupan_sebelum_rs) }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>

                    <hr>

                    {{-- Asesmen Gizi --}}
                    @if($dataGiziDewasa->asesmenGizi)
                    <h6>Asesmen Gizi</h6>
                    <table class="table table-bordered">
                        <tr>
                            <td width="200px"><strong>Berat Badan</strong></td>
                            <td>{{ $dataGiziDewasa->asesmenGizi->berat_badan ? number_format((float)$dataGiziDewasa->asesmenGizi->berat_badan, 1, '.', '') : '-' }} kg</td>
                        </tr>
                        <tr>
                            <td><strong>Tinggi Badan</strong></td>
                            <td>{{ $dataGiziDewasa->asesmenGizi->tinggi_badan ? number_format((float)$dataGiziDewasa->asesmenGizi->tinggi_badan, 1, '.', '') : '-' }} cm</td>
                        </tr>
                        <tr>
                            <td><strong>IMT</strong></td>
                            <td>
                                @if($dataGiziDewasa->asesmenGizi->imt)
                                    {{ number_format((float)$dataGiziDewasa->asesmenGizi->imt, 2, '.', '') }} kg/m²
                                    <span class="badge ms-2
                                        @if($dataGiziDewasa->asesmenGizi->imt < 18.5) bg-warning
                                        @elseif($dataGiziDewasa->asesmenGizi->imt >= 18.5 && $dataGiziDewasa->asesmenGizi->imt < 25) bg-success
                                        @elseif($dataGiziDewasa->asesmenGizi->imt >= 25 && $dataGiziDewasa->asesmenGizi->imt < 30) bg-warning
                                        @else bg-danger
                                        @endif">
                                        @if($dataGiziDewasa->asesmenGizi->imt < 18.5) Underweight
                                        @elseif($dataGiziDewasa->asesmenGizi->imt >= 18.5 && $dataGiziDewasa->asesmenGizi->imt < 25) Normal
                                        @elseif($dataGiziDewasa->asesmenGizi->imt >= 25 && $dataGiziDewasa->asesmenGizi->imt < 30) Overweight
                                        @else Obesitas
                                        @endif
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>BBI</strong></td>
                            <td>{{ $dataGiziDewasa->asesmenGizi->bbi ? number_format((float)$dataGiziDewasa->asesmenGizi->bbi, 1, '.', '') : '-' }} kg</td>
                        </tr>
                        <tr>
                            <td><strong>Biokimia</strong></td>
                            <td>{{ $dataGiziDewasa->asesmenGizi->biokimia ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kimia/Fisik</strong></td>
                            <td>{{ $dataGiziDewasa->asesmenGizi->kimia_fisik ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Riwayat Gizi</strong></td>
                            <td>{{ $dataGiziDewasa->asesmenGizi->riwayat_gizi ?: '-' }}</td>
                        </tr>
                    </table>
                    @endif

                    <hr>

                    {{-- Riwayat Alergi --}}
                    <h6>Riwayat Alergi Pasien</h6>
                    @if($alergiPasien && $alergiPasien->count() > 0)
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
                                                <span class="badge 
                                                    @if(strtolower($alergi->tingkat_keparahan) == 'ringan') bg-success
                                                    @elseif(strtolower($alergi->tingkat_keparahan) == 'sedang') bg-warning
                                                    @elseif(strtolower($alergi->tingkat_keparahan) == 'berat') bg-danger
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
                        <p class="text-muted">Tidak ada riwayat alergi yang tercatat.</p>
                    @endif

                    <hr>

                    {{-- Diagnosa Gizi --}}
                    <h6>Diagnosa Gizi</h6>
                    <table class="table table-bordered">
                        <tr>
                            <td width="200px"><strong>Diagnosa</strong></td>
                            <td>{{ $dataGiziDewasa->diagnosa_gizi ?: '-' }}</td>
                        </tr>
                    </table>

                    <hr>

                    {{-- Intervensi Gizi --}}
                    @if($dataGiziDewasa->intervensiGizi)
                    <h6>Intervensi Gizi</h6>
                    
                    {{-- Data Dasar Perhitungan --}}
                    <div class="mb-4">
                        <h6 class="text-primary">Data Dasar Perhitungan</h6>
                        <table class="table table-bordered">
                            <tr>
                                <td width="200px"><strong>Umur</strong></td>
                                <td>{{ $dataGiziDewasa->intervensiGizi->umur ?? '-' }} tahun</td>
                            </tr>
                            <tr>
                                <td><strong>Faktor Aktivitas</strong></td>
                                <td>{{ $dataGiziDewasa->intervensiGizi->faktor_aktivitas ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Faktor Stress</strong></td>
                                <td>{{ $dataGiziDewasa->intervensiGizi->faktor_stress ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- Perhitungan Kebutuhan Energi --}}
                    <div class="mb-4">
                        <h6 class="text-primary">Perhitungan Kebutuhan Energi</h6>
                        <table class="table table-bordered">
                            <tr>
                                <td width="200px"><strong>BEE</strong></td>
                                <td>{{ $dataGiziDewasa->intervensiGizi->bee ? number_format($dataGiziDewasa->intervensiGizi->bee, 0) : '-' }} Kkal</td>
                            </tr>
                            <tr>
                                <td><strong>BMR</strong></td>
                                <td>{{ $dataGiziDewasa->intervensiGizi->bmr ? number_format($dataGiziDewasa->intervensiGizi->bmr, 0) : '-' }} Kkal</td>
                            </tr>
                            <tr>
                                <td><strong>TEE</strong></td>
                                <td>{{ $dataGiziDewasa->intervensiGizi->tee ? number_format($dataGiziDewasa->intervensiGizi->tee, 0) : '-' }} Kkal</td>
                            </tr>
                            <tr>
                                <td><strong>Kebutuhan Kalori</strong></td>
                                <td>
                                    @if($dataGiziDewasa->intervensiGizi->kebutuhan_kalori)
                                        <span class="badge badge-energy fs-6">{{ number_format($dataGiziDewasa->intervensiGizi->kebutuhan_kalori, 0) }} Kkal</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                    {{-- Bentuk Makanan & Cara Pemberian --}}
                    <div class="mb-4">
                        <h6 class="text-primary">Bentuk Makanan & Cara Pemberian</h6>
                        <table class="table table-bordered">
                            <tr>
                                <td width="200px"><strong>Bentuk Makanan</strong></td>
                                <td>{{ ucfirst($dataGiziDewasa->intervensiGizi->bentuk_makanan ?? '-') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Cara Pemberian</strong></td>
                                <td>{{ strtoupper($dataGiziDewasa->intervensiGizi->cara_pemberian ?? '-') }}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- Kebutuhan Makronutrien --}}
                    <div class="mb-4">
                        <h6 class="text-primary">Kebutuhan Makronutrien</h6>
                        <table class="table table-bordered">
                            <tr>
                                <td width="200px"><strong>Protein</strong></td>
                                <td>
                                    @if($dataGiziDewasa->intervensiGizi->protein_persen && $dataGiziDewasa->intervensiGizi->protein_gram)
                                        <span class="badge badge-protein">{{ number_format($dataGiziDewasa->intervensiGizi->protein_persen, 1) }}% ({{ number_format($dataGiziDewasa->intervensiGizi->protein_gram, 1) }} gram)</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Lemak</strong></td>
                                <td>
                                    @if($dataGiziDewasa->intervensiGizi->lemak_persen && $dataGiziDewasa->intervensiGizi->lemak_gram)
                                        <span class="badge badge-fat">{{ number_format($dataGiziDewasa->intervensiGizi->lemak_persen, 1) }}% ({{ number_format($dataGiziDewasa->intervensiGizi->lemak_gram, 1) }} gram)</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Karbohidrat</strong></td>
                                <td>
                                    @if($dataGiziDewasa->intervensiGizi->kh_persen && $dataGiziDewasa->intervensiGizi->kh_gram)
                                        <span class="badge badge-carb">{{ $dataGiziDewasa->intervensiGizi->kh_persen }}% ({{ number_format($dataGiziDewasa->intervensiGizi->kh_gram, 1) }} gram)</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                    {{-- Rencana Diet & Monitoring --}}
                    <div class="mb-4">
                        <h6 class="text-primary">Rencana Diet & Monitoring</h6>
                        <table class="table table-bordered">
                            <tr>
                                <td width="200px"><strong>Jenis Diet</strong></td>
                                <td>{{ $dataGiziDewasa->intervensiGizi->jenis_diet ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Rencana Monitoring</strong></td>
                                <td>{{ $dataGiziDewasa->intervensiGizi->rencana_monitoring ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Catatan Intervensi</strong></td>
                                <td>{{ $dataGiziDewasa->intervensiGizi->catatan_intervensi ?: '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    @endif

                    <hr>

                    {{-- Data Monitoring Gizi (jika ada) --}}
                    <h6>Data Monitoring dan Evaluasi Gizi</h6>
                    @if($monitoringGizi && $monitoringGizi->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal/Jam</th>
                                        <th>Energi (Kkal)</th>
                                        <th>Protein (g)</th>
                                        <th>KH (g)</th>
                                        <th>Lemak (g)</th>
                                        <th>Masalah Perkembangan</th>
                                        <th>Tindak Lanjut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($monitoringGizi as $index => $monitoring)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($monitoring->tanggal_monitoring)->format('d/m/Y H:i') }}</td>
                                            <td>{{ number_format($monitoring->energi, 1) }}</td>
                                            <td>{{ number_format($monitoring->protein, 1) }}</td>
                                            <td>{{ number_format($monitoring->karbohidrat, 1) }}</td>
                                            <td>{{ number_format($monitoring->lemak, 1) }}</td>
                                            <td>{{ $monitoring->masalah_perkembangan ?: '-' }}</td>
                                            <td>{{ $monitoring->tindak_lanjut ?: '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Belum ada data monitoring gizi.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection