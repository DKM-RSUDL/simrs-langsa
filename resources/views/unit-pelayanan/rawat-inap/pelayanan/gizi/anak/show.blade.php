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

            <div>
                <div class="card-header">
                    <h5>Detail Pengkajian Gizi Anak</h5>
                </div>
                <div class="card-body">
                    
                    {{-- Info Dasar --}}
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
                    </table>

                    <hr>

                    {{-- Kebiasaan Makan --}}
                    <h6>Kebiasaan Makan</h6>
                    <table class="table table-bordered">
                        <tr>
                            <td width="200px"><strong>Makan Pagi</strong></td>
                            <td>{{ ucfirst($dataPengkajianGizi->makan_pagi ?: 'Tidak') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Makan Siang</strong></td>
                            <td>{{ ucfirst($dataPengkajianGizi->makan_siang ?: 'Tidak') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Makan Malam</strong></td>
                            <td>{{ ucfirst($dataPengkajianGizi->makan_malam ?: 'Tidak') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Frekuensi Ngemil</strong></td>
                            <td>{{ $dataPengkajianGizi->frekuensi_ngemil ?? 0 }} kali/hari</td>
                        </tr>
                    </table>

                    <hr>

                    {{-- Alergi & Pantangan --}}
                    <h6>Alergi & Pantangan</h6>
                    <table class="table table-bordered">
                        <tr>
                            <td width="200px"><strong>Alergi Makanan</strong></td>
                            <td>{{ ucfirst($dataPengkajianGizi->alergi_makanan ?: 'Tidak') }}</td>
                        </tr>
                        @if($dataPengkajianGizi->alergi_makanan == 'ya')
                        <tr>
                            <td><strong>Jenis Alergi</strong></td>
                            <td>{{ $dataPengkajianGizi->jenis_alergi ?: '-' }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>Pantangan Makanan</strong></td>
                            <td>{{ ucfirst($dataPengkajianGizi->pantangan_makanan ?: 'Tidak') }}</td>
                        </tr>
                        @if($dataPengkajianGizi->pantangan_makanan == 'ya')
                        <tr>
                            <td><strong>Jenis Pantangan</strong></td>
                            <td>{{ $dataPengkajianGizi->jenis_pantangan ?: '-' }}</td>
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
                                @if($dataPengkajianGizi->gangguan_gi)
                                    {{ str_replace(',', ', ', $dataPengkajianGizi->gangguan_gi) }}
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
                                @if($dataPengkajianGizi->frekuensi_makan_rs == 'lebih_3x')
                                    Makan > 3x/hari
                                @elseif($dataPengkajianGizi->frekuensi_makan_rs == 'kurang_3x')
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
                            <td>{{ $dataPengkajianGizi->makanan_pokok ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Lauk Hewani</strong></td>
                            <td>{{ $dataPengkajianGizi->lauk_hewani ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Lauk Nabati</strong></td>
                            <td>{{ $dataPengkajianGizi->lauk_nabati ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Sayuran</strong></td>
                            <td>{{ $dataPengkajianGizi->sayuran ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Buah-buahan</strong></td>
                            <td>{{ $dataPengkajianGizi->buah_buahan ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Minuman</strong></td>
                            <td>{{ $dataPengkajianGizi->minuman ?: '-' }}</td>
                        </tr>
                    </table>

                    <hr>

                    {{-- Recall 24 Jam --}}
                    <h6>Recall Makanan 24 Jam</h6>
                    <table class="table table-bordered">
                        <tr>
                            <td width="200px"><strong>Makan Pagi</strong></td>
                            <td>{{ $dataPengkajianGizi->recall_makan_pagi ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Snack Pagi</strong></td>
                            <td>{{ $dataPengkajianGizi->recall_snack_pagi ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Makan Siang</strong></td>
                            <td>{{ $dataPengkajianGizi->recall_makan_siang ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Snack Sore</strong></td>
                            <td>{{ $dataPengkajianGizi->recall_snack_sore ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Makan Malam</strong></td>
                            <td>{{ $dataPengkajianGizi->recall_makan_malam ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Snack Malam</strong></td>
                            <td>{{ $dataPengkajianGizi->recall_snack_malam ?: '-' }}</td>
                        </tr>
                    </table>

                    <hr>

                    {{-- Asupan Sebelum RS --}}
                    <h6>Asupan Sebelum Masuk RS</h6>
                    <table class="table table-bordered">
                        <tr>
                            <td width="200px"><strong>Penilaian Asupan</strong></td>
                            <td>{{ ucfirst($dataPengkajianGizi->asupan_sebelum_rs ?: '-') }}</td>
                        </tr>
                    </table>

                    <hr>

                    {{-- Asesmen Gizi --}}
                    @if($dataPengkajianGizi->asesmenGizi)
                    <h6>Asesmen Gizi</h6>
                    <table class="table table-bordered">
                        <tr>
                            <td width="200px"><strong>Berat Badan</strong></td>
                            <td>{{ $dataPengkajianGizi->asesmenGizi->berat_badan ? number_format((float)$dataPengkajianGizi->asesmenGizi->berat_badan, 1, '.', '') : '-' }} kg</td>
                        </tr>
                        <tr>
                            <td><strong>Tinggi Badan</strong></td>
                            <td>{{ $dataPengkajianGizi->asesmenGizi->tinggi_badan ? number_format((float)$dataPengkajianGizi->asesmenGizi->tinggi_badan, 1, '.', '') : '-' }} cm</td>
                        </tr>
                        <tr>
                            <td><strong>IMT</strong></td>
                            <td>{{ $dataPengkajianGizi->asesmenGizi->imt ? number_format((float)$dataPengkajianGizi->asesmenGizi->imt, 2, '.', '') : '-' }} kg/m²</td>
                        </tr>
                        <tr>
                            <td><strong>BBI</strong></td>
                            <td>{{ $dataPengkajianGizi->asesmenGizi->bbi ? number_format((float)$dataPengkajianGizi->asesmenGizi->bbi, 1, '.', '') : '-' }} kg</td>
                        </tr>
                        <tr>
                            <td><strong>Status Gizi</strong></td>
                            <td>{{ $dataPengkajianGizi->asesmenGizi->status_gizi ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>BB/Usia (Z-Score)</strong></td>
                            <td>{{ $dataPengkajianGizi->asesmenGizi->bb_usia ? number_format((float)$dataPengkajianGizi->asesmenGizi->bb_usia, 2, '.', '') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>BB/TB (Z-Score)</strong></td>
                            <td>{{ $dataPengkajianGizi->asesmenGizi->bb_tb ? number_format((float)$dataPengkajianGizi->asesmenGizi->bb_tb, 2, '.', '') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>PB(TB)/Usia (Z-Score)</strong></td>
                            <td>{{ $dataPengkajianGizi->asesmenGizi->pb_tb_usia ? number_format((float)$dataPengkajianGizi->asesmenGizi->pb_tb_usia, 2, '.', '') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>IMT/Usia (Z-Score)</strong></td>
                            <td>{{ $dataPengkajianGizi->asesmenGizi->imt_usia ? number_format((float)$dataPengkajianGizi->asesmenGizi->imt_usia, 2, '.', '') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Lingkar Kepala</strong></td>
                            <td>{{ $dataPengkajianGizi->asesmenGizi->lingkar_kepala ? number_format((float)$dataPengkajianGizi->asesmenGizi->lingkar_kepala, 1, '.', '') : '-' }} cm</td>
                        </tr>
                        <tr>
                            <td><strong>Biokimia</strong></td>
                            <td>{{ $dataPengkajianGizi->asesmenGizi->biokimia ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kimia/Fisik</strong></td>
                            <td>{{ $dataPengkajianGizi->asesmenGizi->kimia_fisik ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Riwayat Gizi</strong></td>
                            <td>{{ $dataPengkajianGizi->asesmenGizi->riwayat_gizi ?: '-' }}</td>
                        </tr>
                    </table>
                    @endif

                    <hr>

                    {{-- Diagnosa Gizi --}}
                    <h6>Diagnosa Gizi</h6>
                    <table class="table table-bordered">
                        <tr>
                            <td width="200px"><strong>Diagnosa</strong></td>
                            <td>{{ $dataPengkajianGizi->diagnosa_gizi ?: '-' }}</td>
                        </tr>
                    </table>

                    <hr>

                    {{-- Data Monitoring Gizi --}}
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