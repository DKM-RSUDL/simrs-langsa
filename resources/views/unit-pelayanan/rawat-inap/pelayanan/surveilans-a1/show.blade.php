@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .badge-emergency {
            background-color: #dc3545;
            color: white;
        }
        .badge-elektif {
            background-color: #17a2b8;
            color: white;
        }
        .badge-rujukan {
            background-color: #ffc107;
            color: black;
        }
        .badge-rumah {
            background-color: #28a745;
            color: white;
        }
        
        .section-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        
        .section-header {
            background: linear-gradient(135deg, #097dd6 0%, #0056b3 100%);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 8px 8px 0 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .section-body {
            padding: 1rem;
        }
        
        .data-row {
            border-bottom: 1px solid #f1f3f4;
            padding: 0.5rem 0;
        }
        
        .data-row:last-child {
            border-bottom: none;
        }
        
        .room-transfer-item {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
        }
        
        .risk-factor-card {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .risk-factor-header {
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 0.75rem;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 0.25rem;
        }
        
        .sub-factor {
            background-color: white;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 0.75rem;
            margin-bottom: 0.75rem;
        }
        
        .sub-factor:last-child {
            margin-bottom: 0;
        }
        
        .sub-factor-title {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
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
            <a href="{{ route('rawat-inap.surveilans-ppi.a1.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" 
               class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="card">
                <div class="card-header">
                    <h5>Detail Surveilans PPI (PENCEGAHAN DAN PENGENDALIAN INFEKSI) A1</h5>
                </div>
                <div class="card-body">
                    
                    {{-- Informasi Dasar --}}
                    <div class="section-card">
                        <div class="section-header">
                            <i class="fas fa-info-circle"></i>
                            Informasi Dasar
                        </div>
                        <div class="section-body">
                            <table class="table table-bordered table-sm">
                                <tr>
                                    <td width="30%"><strong>Nama Pasien</strong></td>
                                    <td>{{ $dataMedis->pasien->nama ?? 'Tidak Diketahui' }}</td>
                                <tr>
                                    <td width="30%"><strong>Nomor Rekam Medis</strong></td>
                                    <td>{{ $dataMedis->pasien->kd_pasien }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Lahir</strong></td>
                                    <td>{{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : 'Tidak Diketahui' }}</td>
                                <tr>
                                    <td width="30%"><strong>Tanggal Implementasi</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($surveilans->tanggal_implementasi)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Cara Dirawat</strong></td>
                                    <td>
                                        <span class="badge {{ $surveilans->cara_dirawat == 'Emergency' ? 'badge-emergency' : 'badge-elektif' }}">
                                            {{ $surveilans->cara_dirawat }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Asal Masuk</strong></td>
                                    <td>
                                        <span class="badge {{ $surveilans->asal_masuk == 'Rujukan' ? 'badge-rujukan' : 'badge-rumah' }}">
                                            {{ $surveilans->asal_masuk }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Petugas</strong></td>
                                    <td>{{ $surveilans->userCreated->name ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Pindah ke Ruangan --}}
                    @if(!empty($pindahKeRuangan))
                        <div class="section-card">
                            <div class="section-header">
                                <i class="fas fa-exchange-alt"></i>
                                Riwayat Perpindahan Ruangan
                            </div>
                            <div class="section-body">
                                @foreach($pindahKeRuangan as $index => $room)
                                    <div class="room-transfer-item">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <strong>Perpindahan #{{ $index + 1 }}</strong>
                                            </div>
                                            <div class="col-md-5">
                                                <strong>Ruangan:</strong> {{ $room['ruangan'] ?? 'N/A' }}
                                            </div>
                                            <div class="col-md-5">
                                                <strong>Tanggal:</strong> 
                                                {{ $room['tanggal'] ? \Carbon\Carbon::parse($room['tanggal'])->format('d/m/Y') : 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Faktor Risiko --}}
                    <div class="section-card">
                        <div class="section-header">
                            <i class="fas fa-exclamation-triangle"></i>
                            Faktor Risiko Selama Dirawat
                        </div>
                        <div class="section-body">
                            
                            {{-- 1. Intra Vena Kateter --}}
                            @if(!empty($intraVenaKateter))
                                <div class="risk-factor-card">
                                    <div class="risk-factor-header">
                                        <i class="fas fa-syringe me-2"></i>
                                        1. Intra Vena Kateter
                                    </div>
                                    
                                    @if(isset($intraVenaKateter['vena_sentral']))
                                        <div class="sub-factor">
                                            <div class="sub-factor-title">a. Vena Sentral</div>
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr><td width="25%">Lokasi:</td><td>{{ $intraVenaKateter['vena_sentral']['lokasi'] ?? '-' }}</td></tr>
                                                <tr><td>Tanggal Mulai:</td><td>{{ $intraVenaKateter['vena_sentral']['tgl_mulai'] ? \Carbon\Carbon::parse($intraVenaKateter['vena_sentral']['tgl_mulai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Tanggal Selesai:</td><td>{{ $intraVenaKateter['vena_sentral']['tgl_selesai'] ? \Carbon\Carbon::parse($intraVenaKateter['vena_sentral']['tgl_selesai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Total Hari:</td><td>{{ $intraVenaKateter['vena_sentral']['total_hari'] ?? '-' }} hari</td></tr>
                                                <tr><td>Tanggal Infeksi:</td><td>{{ $intraVenaKateter['vena_sentral']['tgl_infeksi'] ? \Carbon\Carbon::parse($intraVenaKateter['vena_sentral']['tgl_infeksi'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Catatan:</td><td>{{ $intraVenaKateter['vena_sentral']['catatan'] ?? '-' }}</td></tr>
                                            </table>
                                        </div>
                                    @endif
                                    
                                    @if(isset($intraVenaKateter['vena_perifer']))
                                        <div class="sub-factor">
                                            <div class="sub-factor-title">b. Vena Perifer</div>
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr><td width="25%">Lokasi:</td><td>{{ $intraVenaKateter['vena_perifer']['lokasi'] ?? '-' }}</td></tr>
                                                <tr><td>Tanggal Mulai:</td><td>{{ $intraVenaKateter['vena_perifer']['tgl_mulai'] ? \Carbon\Carbon::parse($intraVenaKateter['vena_perifer']['tgl_mulai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Tanggal Selesai:</td><td>{{ $intraVenaKateter['vena_perifer']['tgl_selesai'] ? \Carbon\Carbon::parse($intraVenaKateter['vena_perifer']['tgl_selesai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Total Hari:</td><td>{{ $intraVenaKateter['vena_perifer']['total_hari'] ?? '-' }} hari</td></tr>
                                                <tr><td>Tanggal Infeksi:</td><td>{{ $intraVenaKateter['vena_perifer']['tgl_infeksi'] ? \Carbon\Carbon::parse($intraVenaKateter['vena_perifer']['tgl_infeksi'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Catatan:</td><td>{{ $intraVenaKateter['vena_perifer']['catatan'] ?? '-' }}</td></tr>
                                            </table>
                                        </div>
                                    @endif

                                    @if(isset($intraVenaKateter['heparin_log']))
                                        <div class="sub-factor">
                                            <div class="sub-factor-title">c. Heparin Log</div>
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr><td width="25%">Lokasi:</td><td>{{ $intraVenaKateter['heparin_log']['lokasi'] ?? '-' }}</td></tr>
                                                <tr><td>Tanggal Mulai:</td><td>{{ $intraVenaKateter['heparin_log']['tgl_mulai'] ? \Carbon\Carbon::parse($intraVenaKateter['heparin_log']['tgl_mulai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Tanggal Selesai:</td><td>{{ $intraVenaKateter['heparin_log']['tgl_selesai'] ? \Carbon\Carbon::parse($intraVenaKateter['heparin_log']['tgl_selesai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Total Hari:</td><td>{{ $intraVenaKateter['heparin_log']['total_hari'] ?? '-' }} hari</td></tr>
                                                <tr><td>Tanggal Infeksi:</td><td>{{ $intraVenaKateter['heparin_log']['tgl_infeksi'] ? \Carbon\Carbon::parse($intraVenaKateter['heparin_log']['tgl_infeksi'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Catatan:</td><td>{{ $intraVenaKateter['heparin_log']['catatan'] ?? '-' }}</td></tr>
                                            </table>
                                        </div>
                                    @endif

                                    @if(isset($intraVenaKateter['umbilikal']))
                                        <div class="sub-factor">
                                            <div class="sub-factor-title">d. Umbilikal</div>
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr><td width="25%">Lokasi:</td><td>{{ $intraVenaKateter['umbilikal']['lokasi'] ?? '-' }}</td></tr>
                                                <tr><td>Tanggal Mulai:</td><td>{{ $intraVenaKateter['umbilikal']['tgl_mulai'] ? \Carbon\Carbon::parse($intraVenaKateter['umbilikal']['tgl_mulai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Tanggal Selesai:</td><td>{{ $intraVenaKateter['umbilikal']['tgl_selesai'] ? \Carbon\Carbon::parse($intraVenaKateter['umbilikal']['tgl_selesai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Total Hari:</td><td>{{ $intraVenaKateter['umbilikal']['total_hari'] ?? '-' }} hari</td></tr>
                                                <tr><td>Tanggal Infeksi:</td><td>{{ $intraVenaKateter['umbilikal']['tgl_infeksi'] ? \Carbon\Carbon::parse($intraVenaKateter['umbilikal']['tgl_infeksi'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Catatan:</td><td>{{ $intraVenaKateter['umbilikal']['catatan'] ?? '-' }}</td></tr>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- 2. Kateter --}}
                            @if(!empty($kateter))
                                <div class="risk-factor-card">
                                    <div class="risk-factor-header">
                                        <i class="fas fa-procedures me-2"></i>
                                        2. Kateter
                                    </div>
                                    
                                    @if(isset($kateter['kateter_urine']))
                                        <div class="sub-factor">
                                            <div class="sub-factor-title">a. Kateter Urine</div>
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr><td width="25%">Lokasi:</td><td>{{ $kateter['kateter_urine']['lokasi'] ?? '-' }}</td></tr>
                                                <tr><td>Tanggal Mulai:</td><td>{{ $kateter['kateter_urine']['tgl_mulai'] ? \Carbon\Carbon::parse($kateter['kateter_urine']['tgl_mulai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Tanggal Selesai:</td><td>{{ $kateter['kateter_urine']['tgl_selesai'] ? \Carbon\Carbon::parse($kateter['kateter_urine']['tgl_selesai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Total Hari:</td><td>{{ $kateter['kateter_urine']['total_hari'] ?? '-' }} hari</td></tr>
                                                <tr><td>Tanggal Infeksi:</td><td>{{ $kateter['kateter_urine']['tgl_infeksi'] ? \Carbon\Carbon::parse($kateter['kateter_urine']['tgl_infeksi'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Catatan:</td><td>{{ $kateter['kateter_urine']['catatan'] ?? '-' }}</td></tr>
                                            </table>
                                        </div>
                                    @endif

                                    @if(isset($kateter['kateter_custom']))
                                        <div class="sub-factor">
                                            <div class="sub-factor-title">b. {{ $kateter['kateter_custom']['nama'] ?? 'Kateter Custom' }}</div>
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr><td width="25%">Lokasi:</td><td>{{ $kateter['kateter_custom']['lokasi'] ?? '-' }}</td></tr>
                                                <tr><td>Tanggal Mulai:</td><td>{{ $kateter['kateter_custom']['tgl_mulai'] ? \Carbon\Carbon::parse($kateter['kateter_custom']['tgl_mulai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Tanggal Selesai:</td><td>{{ $kateter['kateter_custom']['tgl_selesai'] ? \Carbon\Carbon::parse($kateter['kateter_custom']['tgl_selesai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Total Hari:</td><td>{{ $kateter['kateter_custom']['total_hari'] ?? '-' }} hari</td></tr>
                                                <tr><td>Tanggal Infeksi:</td><td>{{ $kateter['kateter_custom']['tgl_infeksi'] ? \Carbon\Carbon::parse($kateter['kateter_custom']['tgl_infeksi'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Catatan:</td><td>{{ $kateter['kateter_custom']['catatan'] ?? '-' }}</td></tr>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- 3. Ventilasi Mekanik --}}
                            @if(!empty($ventilasiMekanik))
                                <div class="risk-factor-card">
                                    <div class="risk-factor-header">
                                        <i class="fas fa-lungs me-2"></i>
                                        3. Ventilasi Mekanik
                                    </div>
                                    
                                    @if(isset($ventilasiMekanik['endotrakeal']))
                                        <div class="sub-factor">
                                            <div class="sub-factor-title">a. Endotrakeal Tube</div>
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr><td width="25%">Lokasi:</td><td>{{ $ventilasiMekanik['endotrakeal']['lokasi'] ?? '-' }}</td></tr>
                                                <tr><td>Tanggal Mulai:</td><td>{{ $ventilasiMekanik['endotrakeal']['tgl_mulai'] ? \Carbon\Carbon::parse($ventilasiMekanik['endotrakeal']['tgl_mulai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Tanggal Selesai:</td><td>{{ $ventilasiMekanik['endotrakeal']['tgl_selesai'] ? \Carbon\Carbon::parse($ventilasiMekanik['endotrakeal']['tgl_selesai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Total Hari:</td><td>{{ $ventilasiMekanik['endotrakeal']['total_hari'] ?? '-' }} hari</td></tr>
                                                <tr><td>Tanggal Infeksi:</td><td>{{ $ventilasiMekanik['endotrakeal']['tgl_infeksi'] ? \Carbon\Carbon::parse($ventilasiMekanik['endotrakeal']['tgl_infeksi'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Catatan:</td><td>{{ $ventilasiMekanik['endotrakeal']['catatan'] ?? '-' }}</td></tr>
                                            </table>
                                        </div>
                                    @endif

                                    @if(isset($ventilasiMekanik['trakeostomi']))
                                        <div class="sub-factor">
                                            <div class="sub-factor-title">b. Trakeostomi</div>
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr><td width="25%">Lokasi:</td><td>{{ $ventilasiMekanik['trakeostomi']['lokasi'] ?? '-' }}</td></tr>
                                                <tr><td>Tanggal Mulai:</td><td>{{ $ventilasiMekanik['trakeostomi']['tgl_mulai'] ? \Carbon\Carbon::parse($ventilasiMekanik['trakeostomi']['tgl_mulai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Tanggal Selesai:</td><td>{{ $ventilasiMekanik['trakeostomi']['tgl_selesai'] ? \Carbon\Carbon::parse($ventilasiMekanik['trakeostomi']['tgl_selesai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Total Hari:</td><td>{{ $ventilasiMekanik['trakeostomi']['total_hari'] ?? '-' }} hari</td></tr>
                                                <tr><td>Tanggal Infeksi:</td><td>{{ $ventilasiMekanik['trakeostomi']['tgl_infeksi'] ? \Carbon\Carbon::parse($ventilasiMekanik['trakeostomi']['tgl_infeksi'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Catatan:</td><td>{{ $ventilasiMekanik['trakeostomi']['catatan'] ?? '-' }}</td></tr>
                                            </table>
                                        </div>
                                    @endif

                                    @if(isset($ventilasiMekanik['tpiece']))
                                        <div class="sub-factor">
                                            <div class="sub-factor-title">c. T. Piece</div>
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr><td width="25%">Lokasi:</td><td>{{ $ventilasiMekanik['tpiece']['lokasi'] ?? '-' }}</td></tr>
                                                <tr><td>Tanggal Mulai:</td><td>{{ $ventilasiMekanik['tpiece']['tgl_mulai'] ? \Carbon\Carbon::parse($ventilasiMekanik['tpiece']['tgl_mulai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Tanggal Selesai:</td><td>{{ $ventilasiMekanik['tpiece']['tgl_selesai'] ? \Carbon\Carbon::parse($ventilasiMekanik['tpiece']['tgl_selesai'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Total Hari:</td><td>{{ $ventilasiMekanik['tpiece']['total_hari'] ?? '-' }} hari</td></tr>
                                                <tr><td>Tanggal Infeksi:</td><td>{{ $ventilasiMekanik['tpiece']['tgl_infeksi'] ? \Carbon\Carbon::parse($ventilasiMekanik['tpiece']['tgl_infeksi'])->format('d/m/Y') : '-' }}</td></tr>
                                                <tr><td>Catatan:</td><td>{{ $ventilasiMekanik['tpiece']['catatan'] ?? '-' }}</td></tr>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- 4. Lain-lain --}}
                            @if(!empty($lainLain))
                                <div class="risk-factor-card">
                                    <div class="risk-factor-header">
                                        <i class="fas fa-plus-circle me-2"></i>
                                        4. {{ $lainLain['nama'] ?? 'Lain-lain' }}
                                    </div>
                                    
                                    <div class="sub-factor">
                                        <table class="table table-sm table-borderless mb-0">
                                            <tr><td width="25%">Lokasi:</td><td>{{ $lainLain['lokasi'] ?? '-' }}</td></tr>
                                            <tr><td>Tanggal Mulai:</td><td>{{ $lainLain['tgl_mulai'] ? \Carbon\Carbon::parse($lainLain['tgl_mulai'])->format('d/m/Y') : '-' }}</td></tr>
                                            <tr><td>Tanggal Selesai:</td><td>{{ $lainLain['tgl_selesai'] ? \Carbon\Carbon::parse($lainLain['tgl_selesai'])->format('d/m/Y') : '-' }}</td></tr>
                                            <tr><td>Total Hari:</td><td>{{ $lainLain['total_hari'] ?? '-' }} hari</td></tr>
                                            <tr><td>Tanggal Infeksi:</td><td>{{ $lainLain['tgl_infeksi'] ? \Carbon\Carbon::parse($lainLain['tgl_infeksi'])->format('d/m/Y') : '-' }}</td></tr>
                                            <tr><td>Catatan:</td><td>{{ $lainLain['catatan'] ?? '-' }}</td></tr>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            {{-- Empty State --}}
                            @if(empty($intraVenaKateter) && empty($kateter) && empty($ventilasiMekanik) && empty($lainLain))
                                <div class="text-center py-4 text-muted">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Tidak ada faktor risiko yang tercatat
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Informasi Tambahan --}}
                    <div class="section-card">
                        <div class="section-header">
                            <i class="fas fa-clock"></i>
                            Informasi Tambahan
                        </div>
                        <div class="section-body">
                            <table class="table table-bordered table-sm">
                                <tr>
                                    <td width="30%"><strong>Tanggal Pembuatan</strong></td>
                                    <td>{{ $surveilans->created_at ? \Carbon\Carbon::parse($surveilans->created_at)->format('d/m/Y H:i') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Terakhir Diubah</strong></td>
                                    <td>
                                        {{ $surveilans->updated_at ? \Carbon\Carbon::parse($surveilans->updated_at)->format('d/m/Y H:i') : '-' }}
                                        @if($surveilans->userUpdated)
                                            <br><small class="text-muted">oleh {{ $surveilans->userUpdated->name }}</small>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('rawat-inap.surveilans-ppi.a1.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" 
                           class="btn btn-secondary">
                            <i class="ti-arrow-left"></i> Kembali
                        </a>
                        
                        <div>
                            <a href="{{ route('rawat-inap.surveilans-ppi.a1.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $surveilans->id]) }}"
                                class="btn btn-primary">
                                <i class="ti-pencil-alt"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection