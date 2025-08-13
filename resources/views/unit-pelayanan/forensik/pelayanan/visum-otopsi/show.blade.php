@extends('layouts.administrator.master')

@push('css')
    <style>
        .header-asesmen {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px 15px;
            border-radius: 8px;
            border-left: 5px solid #007bff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card {
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 12px 15px;
            font-weight: 600;
            border-radius: 8px 8px 0 0 !important;
            font-size: 0.95rem;
        }

        .card-body {
            padding: 15px;
        }

        .patient-info-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 15px;
        }

        .patient-info-item {
            display: flex;
            margin-bottom: 8px;
            align-items: flex-start;
        }

        .patient-info-label {
            font-weight: 600;
            min-width: 180px;
            color: #495057;
            flex-shrink: 0;
        }

        .patient-info-value {
            color: #212529;
            flex: 1;
        }

        .info-table {
            margin-bottom: 0;
        }

        .info-table th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            font-weight: 600;
            width: 200px;
            vertical-align: top;
        }

        .info-table td {
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            vertical-align: top;
        }

        .content-box {
            min-height: 60px;
            background: #f8f9fa;
            border-radius: 4px;
            padding: 10px;
            border: 1px solid #e9ecef;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            padding: 10px 25px;
            font-weight: 500;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid #007bff;
            color: #007bff;
            font-weight: 500;
            padding: 8px 20px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: #007bff;
            color: white;
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .patient-info-item {
                flex-direction: column;
                margin-bottom: 12px;
            }

            .patient-info-label {
                min-width: unset;
                margin-bottom: 2px;
                font-weight: 600;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-12 mb-3">
                @include('components.patient-card')
            </div>

            <div class="col-xl-9 col-lg-8 col-md-12">
                <div class="mb-3">
                    <a href="{{ route('forensik.unit.pelayanan.visum-otopsi.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                        class="btn btn-outline-primary">
                        <i class="ti-arrow-left"></i> <span class="d-none d-sm-inline">Kembali</span>
                    </a>
                    <a href="{{ route('forensik.unit.pelayanan.visum-otopsi.print', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $visumOtopsi->id]) }}"
                        class="btn btn-primary" target="_blank">
                        <i class="ti-printer"></i> <span class="d-none d-sm-inline">Cetak</span>
                    </a>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <!-- Header Section -->
                        <div class="text-center mb-4">
                            <div class="header-asesmen">
                                <h3 class="font-weight-bold mb-2">VISUM ET REPERTUM OTOPSI</h3>
                                <p class="mb-1 text-muted">INSTALASI KEDOKTERAN FORENSIK</p>
                                <p class="mb-0 text-muted">RUMAH SAKIT UMUM DAERAH LANGSA</p>
                            </div>
                        </div>

                        <!-- Basic Information Section -->
                        <div class=" mb-4">
                            <div class="card-header">
                                <i class="ti-calendar"></i> Informasi Dasar Pemeriksaan
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered info-table">
                                    <tr>
                                        <th>Tanggal Pengisian</th>
                                        <td>{{ $visumOtopsi->tanggal ? date('d/m/Y', strtotime($visumOtopsi->tanggal)) : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jam Pengisian</th>
                                        <td>{{ $visumOtopsi->jam ? date('H:i', strtotime($visumOtopsi->jam)) : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nomor</th>
                                        <td>{{ $visumOtopsi->nomor ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Perihal</th>
                                        <td>{{ $visumOtopsi->perihal ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Lampiran</th>
                                        <td>{{ $visumOtopsi->lampiran ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Patient Information Section -->
                        <div class=" mb-4">
                            <div class="card-header">
                                <i class="ti-user"></i> Data Pasien/Korban
                            </div>
                            <div class="card-body">
                                <div class="patient-info-card">
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Nama:</span>
                                        <span class="patient-info-value">{{ $dataMedis->pasien->nama ?? '-' }}</span>
                                    </div>
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Tempat/Tanggal Lahir:</span>
                                        <span class="patient-info-value">{{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }}
                                            Thn
                                            ({{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : 'Tidak Diketahui' }})</span>
                                    </div>
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Jenis Kelamin:</span>
                                        <span
                                            class="patient-info-value">{{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}</span>
                                    </div>
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Agama:</span>
                                        <span
                                            class="patient-info-value">{{ $dataMedis->pasien->agama->agama ?? '-' }}</span>
                                    </div>
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Alamat:</span>
                                        <span class="patient-info-value">{{ $dataMedis->pasien->alamat ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Visum et Repertum Section -->
                        <div class=" mb-4">
                            <div class="card-header">
                                <i class="ti-file-text"></i> VISUM ET REPERTUM
                            </div>
                            <div class="card-body">
                                <div class="content-box">
                                    {!! $visumOtopsi->visum_et_repertum ?? '<em>Tidak ada data</em>' !!}
                                </div>
                            </div>
                        </div>

                        <!-- Interview Section -->
                        <div class=" mb-4">
                            <div class="card-header">
                                <i class="ti-comment"></i> WAWANCARA
                            </div>
                            <div class="card-body">
                                <div class="content-box">
                                    {!! $visumOtopsi->wawancara ?? '<em>Tidak ada data</em>' !!}
                                </div>
                            </div>
                        </div>

                        <!-- External Examination Section -->
                        <div class=" mb-4">
                            <div class="card-header">
                                <i class="ti-search"></i> PEMERIKSAAN LUAR
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered info-table">
                                    <tr>
                                        <th>Penutup Mayat</th>
                                        <td>
                                            <div class="content-box">
                                                {!! $visumOtopsi->penutup_mayat ?? '<em>Tidak ada data</em>' !!}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Label Mayat</th>
                                        <td>
                                            <div class="content-box">
                                                {!! $visumOtopsi->label_mayat ?? '<em>Tidak ada data</em>' !!}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Pakaian Mayat</th>
                                        <td>
                                            <div class="content-box">
                                                {!! $visumOtopsi->pakaian_mayat ?? '<em>Tidak ada data</em>' !!}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Benda di Samping Mayat</th>
                                        <td>{{ $visumOtopsi->benda_disamping ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Aksesoris</th>
                                        <td>{{ $visumOtopsi->aksesoris ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Continue with other sections using similar table format -->
                        <!-- Identifikasi, Hasil Pemeriksaan, etc. -->

                        <!-- Dibuat oleh -->
                        <div class=" mb-4">
                            <div class="card-header">
                                <i class="ti-user"></i> Informasi Pembuat
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered info-table">
                                    <tr>
                                        <th>Dibuat oleh</th>
                                        <td>{{ $visumOtopsi->userCreated->name ?? 'System' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Dibuat</th>
                                        <td>{{ $visumOtopsi->created_at ? $visumOtopsi->created_at->format('d/m/Y H:i:s') : '-' }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
