```blade
@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
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
        .info-group {
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
        }
        .info-group label {
            font-weight: 500;
            color: #333;
            margin-bottom: 0.3rem;
        }
        .info-group span {
            font-size: 1rem;
            color: #555;
        }
        .vital-signs-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        .vital-signs-table th,
        .vital-signs-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        .vital-signs-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        .vital-signs-table td {
            color: #555;
        }
        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }
        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 2rem;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ route('rawat-inap.observasi.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="card w-100 shadow-sm">
                <div class="card-body">
                    <div class="px-3">
                        <h4 class="header-asesmen">Detail Observasi</h4>
                    </div>

                    <div class="px-3">
                        {{-- Observation Information --}}
                        <div class="section-separator">
                            <h4 class="section-title">Informasi Observasi</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <label>Tanggal</label>
                                        <span>{{ $observasi->tanggal->format('d-m-Y') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <label>Perawat</label>
                                        <span>{{ $observasi->perawat ? $observasi->perawat->nama : '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Patient Information --}}
                        <div class="section-separator">
                            <h4 class="section-title">Informasi Pasien</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <label>Berat Badan (kg)</label>
                                        <span>{{ $observasi->berat_badan ?? '-' }}</span>
                                    </div>
                                    <div class="info-group">
                                        <label>Sensorium</label>
                                        <span>{{ $observasi->sensorium ?? '-' }}</span>
                                    </div>
                                    <div class="info-group">
                                        <label>Alat Invasive</label>
                                        <span>{{ $observasi->alat_invasive ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <label>NGT</label>
                                        <span>{{ $observasi->ngt ?? '-' }}</span>
                                    </div>
                                    <div class="info-group">
                                        <label>Catheter</label>
                                        <span>{{ $observasi->catheter ?? '-' }}</span>
                                    </div>
                                    <div class="info-group">
                                        <label>Diet</label>
                                        <span>{{ $observasi->diet ?? '-' }}</span>
                                    </div>
                                    <div class="info-group">
                                        <label>Alergi</label>
                                        <span>{{ $observasi->alergi ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Vital Signs --}}
                        <div class="section-separator">
                            <h4 class="section-title">Vital Signs</h4>
                            @if ($observasi->details->isEmpty())
                                <p>Tidak ada data vital signs tersedia.</p>
                            @else
                                <table class="vital-signs-table">
                                    <thead>
                                        <tr>
                                            <th>Waktu</th>
                                            <th>Suhu (°C)</th>
                                            <th>Nadi (x/mnt)</th>
                                            <th>Tekanan Darah (mmHg)</th>
                                            <th>Respirasi (x/mnt)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (['06:00', '12:00', '18:00', '24:00'] as $waktu)
                                            @php
                                                $detail = $observasi->details->where('waktu', $waktu)->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $waktu }}</td>
                                                <td>{{ $detail ? ($detail->suhu ?? '-') : '-' }}</td>
                                                <td>{{ $detail ? ($detail->nadi ?? '-') : '-' }}</td>
                                                <td>{{ $detail ? ($detail->tekanan_darah_sistole && $detail->tekanan_darah_diastole ? $detail->tekanan_darah_sistole . '/' . $detail->tekanan_darah_diastole : '-') : '-' }}</td>
                                                <td>{{ $detail ? ($detail->respirasi ?? '-') : '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
```