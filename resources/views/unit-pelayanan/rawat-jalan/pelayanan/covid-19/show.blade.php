@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-jalan.pelayanan.covid-19.include')

@push('css')
    <style>
        .covid-detail {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .detail-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom: 4px solid #5a67d8;
        }

        .detail-section {
            margin-bottom: 30px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }

        .section-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-content {
            padding: 20px;
        }

        .info-row {
            display: flex;
            margin-bottom: 15px;
            border-bottom: 1px solid #f1f1f1;
            padding-bottom: 10px;
        }

        .info-label {
            font-weight: 600;
            color: #2d3748;
            min-width: 200px;
            margin-right: 20px;
        }

        .info-value {
            color: #4a5568;
            flex: 1;
        }

        .list-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 15px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .list-item i {
            color: #667eea;
        }

        .badge-large {
            font-size: 0.9rem;
            padding: 8px 15px;
        }

        .print-btn {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(72, 187, 120, 0.4);
            transition: all 0.3s ease;
        }

        .print-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(72, 187, 120, 0.6);
        }

        .btn-back {
            background: #e2e8f0;
            color: #4a5568;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-back:hover {
            background: #cbd5e0;
            color: #2d3748;
        }

        .btn-edit {
            background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(237, 137, 54, 0.4);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(237, 137, 54, 0.6);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #718096;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .covid-detail {
                box-shadow: none;
                border: 1px solid #ccc;
            }
        }

        /* Assessment Display Styles */
        .assessment-display {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-top: 5px;
        }

        .assessment-display.kontak-erat {
            border-left: 4px solid #f6ad55;
            background: #fffbeb;
        }

        .assessment-display.suspek {
            border-left: 4px solid #f56565;
            background: #fef5e7;
        }

        .assessment-display.non-suspek {
            border-left: 4px solid #48bb78;
            background: #f0fff4;
        }

        .assessment-display-title {
            font-size: 1rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .assessment-display-desc {
            font-size: 0.9rem;
            color: #4a5568;
            line-height: 1.5;
        }

        .assessment-display-desc ul {
            padding-left: 15px;
        }

        .assessment-display-desc ul li {
            margin-bottom: 3px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-start mb-3 no-print">
                <a href="{{ route('rawat-jalan.covid-19.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    class="btn-back me-2">
                    <i class="ti-arrow-left"></i> Kembali
                </a>

                <a href="{{ route('rawat-jalan.covid-19.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $covidData->id]) }}"
                    class="btn-edit me-2">
                    <i class="ti-pencil"></i> Edit Data
                </a>
                <a href="{{ route('rawat-jalan.covid-19.print-pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $covidData->id]) }}"
                    class="print-btn me-2" target="_blank">
                    <i class="ti-printer"></i> Cetak
                </a>

            </div>

            <div class="covid-detail">
                <!-- Header -->
                <div class="detail-header">
                    <h5><i class="fas fa-virus"></i> FORMULIR DETEKSI DINI CORONA VIRUS DISEASE (COVID-19) REVISI 5</h5>
                    <small>Detail Data Tanggal {{ $covidData->tanggal_formatted }} - {{ $covidData->jam_formatted }}</small>
                </div>

                <div class="p-4">
                    <!-- Informasi Umum -->
                    <div class="detail-section">
                        <div class="section-header">
                            <i class="fas fa-info-circle text-primary"></i>
                            <span>INFORMASI UMUM</span>
                        </div>
                        <div class="section-content">
                            <div class="info-row">
                                <div class="info-label">Tanggal Pemeriksaan</div>
                                <div class="info-value">{{ $covidData->tanggal_formatted }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Jam Pemeriksaan</div>
                                <div class="info-value">{{ $covidData->jam_formatted }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Tanggal Pertama Gejala</div>
                                <div class="info-value">
                                    @if($covidData->tgl_gejala)
                                        {{ Carbon\Carbon::parse($covidData->tgl_gejala)->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Petugas Input</div>
                                <div class="info-value">{{ $covidData->userCreate->name ?? 'Tidak Diketahui' }}</div>
                            </div>
                            @if($covidData->user_edit)
                                <div class="info-row">
                                    <div class="info-label">Terakhir Diubah</div>
                                    <div class="info-value">{{ $covidData->userEdit->name ?? 'Tidak Diketahui' }}</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Gejala -->
                    <div class="detail-section">
                        <div class="section-header">
                            <i class="fas fa-thermometer-half text-danger"></i>
                            <span>GEJALA</span>
                        </div>
                        <div class="section-content">
                            @if(count($covidData->gejala_list) > 0)
                                @foreach($covidData->gejala_list as $gejala)
                                    <div class="list-item">
                                        <i class="fas fa-check-circle text-success"></i>
                                        <span>{{ $gejala }}</span>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-thermometer-half"></i>
                                    <p>Tidak ada gejala yang tercatat</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Faktor Risiko -->
                    <div class="detail-section">
                        <div class="section-header">
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                            <span>FAKTOR RISIKO PENULARAN</span>
                        </div>
                        <div class="section-content">
                            @if(count($covidData->faktor_risiko_list) > 0)
                                @foreach($covidData->faktor_risiko_list as $risiko)
                                    <div class="list-item">
                                        <i class="fas fa-exclamation-circle text-warning"></i>
                                        <span>{{ $risiko }}</span>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-shield-alt"></i>
                                    <p>Tidak ada faktor risiko yang tercatat</p>
                                </div>
                            @endif

                            @if($covidData->lokasi_perjalanan)
                                <hr>
                                <div class="info-row">
                                    <div class="info-label">Lokasi Negara/ Propinsi/ Kota : </div>
                                    <div class="info-value">{{ $covidData->lokasi_perjalanan }}</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Komorbid -->
                    <div class="detail-section">
                        <div class="section-header">
                            <i class="fas fa-heartbeat text-info"></i>
                            <span>FAKTOR KOMORBID</span>
                        </div>
                        <p style="margin-left: 10px; margin-top: 5px;">Mempunyai riwayat : </p>
                        <div class="section-content">
                            @if(count($covidData->komorbid_list) > 0)
                                @foreach($covidData->komorbid_list as $komorbid)
                                    <div class="list-item">
                                        <i class="fas fa-heartbeat text-info"></i>
                                        <span>{{ $komorbid }}</span>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-heart"></i>
                                    <p>Tidak ada komorbid yang tercatat</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Persetujuan -->
                    <div class="consent-card">
                        <div class="consent-title fw-bold">
                            <i class="ti-help"></i> Pernyataan Persetujuan Informed Consent COVID-19
                        </div>
                        <p class="mb-3">Dengan ini Saya telah mendapat penjelasan dan memahami penjelasan tersebut di atas dan menyatakan:</p>
                        <div class="mt-3">
                            @if($covidData->persetujuan === 'setuju')
                                <span class="badge bg-success fs-6 px-4 py-2">
                                    <i class="ti-check"></i> YA, SETUJU
                                </span>
                            @else
                                <span class="badge bg-danger fs-6 px-4 py-2">
                                    <i class="ti-close"></i> TIDAK SETUJU
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Kesimpulan -->
                    <div class="detail-section mt-4">
                        <div class="section-header">
                            <i class="fas fa-clipboard-check text-purple"></i>
                            <span>KESIMPULAN PENILAIAN</span>
                        </div>
                        <div class="section-content">
                            <div class="info-row">
                                <div class="info-label">Cara Penilaian</div>
                                <div class="info-value">
                                    @if($covidData->cara_penilaian == 'kontak_erat')
                                        <div class="assessment-display kontak-erat">
                                            <div class="assessment-display-title">
                                                <i class="fas fa-user-friends text-warning me-2"></i>
                                                <strong>KONTAK ERAT</strong>
                                            </div>
                                            <div class="assessment-display-desc">
                                                Tanpa gejala + Faktor risiko utama no. 2 (Kasus konfirmasi*/ Probable**)
                                            </div>
                                        </div>
                                    @elseif($covidData->cara_penilaian == 'suspek')
                                        <div class="assessment-display suspek">
                                            <div class="assessment-display-title">
                                                <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                                                <strong>SUSPEK</strong>
                                            </div>
                                            <div class="assessment-display-desc">
                                                <ul class="mb-0" style="margin-left: 5px">
                                                    <li>Gejala No.1 atau No.2 + Faktor risiko utama No.1 atau No.2</li>
                                                    <li>Gejala No.1 atau No.2 + Faktor risiko utama No.2 (kasus konfirmasi*)
                                                    </li>
                                                    <li>Gejala No.4 DAN tidak ada penyebab lain berdasarkan gambaran klinis yang
                                                        meyakinkan.</li>
                                                </ul>
                                            </div>
                                        </div>
                                    @elseif($covidData->cara_penilaian == 'non_suspek')
                                        <div class="assessment-display non-suspek">
                                            <div class="assessment-display-title">
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                <strong>NON SUSPEK</strong>
                                            </div>
                                            <div class="assessment-display-desc">
                                                Tidak memenuhi kriteria kontak erat, kasus suspek.
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Kesimpulan</div>
                                <div class="info-value">{!! $covidData->kesimpulan_badge !!}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Persetujuan -->
                    <div class="detail-section">
                        <div class="section-header">
                            <i class="fas fa-user-check text-success"></i>
                            <span>DATA PERSETUJUAN</span>
                        </div>
                        <div class="section-content">
                            <div class="info-row">
                                <div class="info-label">Persetujuan Untuk</div>
                                <div class="info-value">{!! $covidData->persetujuan_untuk_badge !!}</div>
                            </div>

                            @if($covidData->persetujuan_untuk === 'keluarga')
                                        <hr>
                                        <h6 class="fw-bold mb-3">Saksi:</h6>
                                        <div class="info-row">
                                            <div class="info-label">Nama Lengkap</div>
                                            <div class="info-value">{{ $covidData->nama_saksi1 }}</div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Tanggal Lahir</div>
                                            <div class="info-value">
                                                @if($covidData->tgl_lahir_saksi1)
                                                    {{ Carbon\Carbon::parse($covidData->tgl_lahir_saksi1)->format('d/m/Y') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Alamat</div>
                                            <div class="info-value">{{ $covidData->alamat_saksi1 ?? '-' }}</div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Jenis Kelamin</div>
                                            <div class="info-value">{{ $covidData->jenis_kelamin_saksi1 }}</div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">No. Telepon</div>
                                            <div class="info-value">{{ $covidData->no_telp_saksi1 ?? '-' }}</div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">No. KTP/SIM</div>
                                            <div class="info-value">{{ $covidData->no_ktp_saksi1 ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Print functionality
        window.addEventListener('beforeprint', function () {
            document.title = 'COVID-19 Form - {{ $dataMedis->pasien->nama_lengkap }} - {{ $covidData->tanggal_formatted }}';
        });

        window.addEventListener('afterprint', function () {
            document.title = 'Detail COVID-19 Form';
        });
    </script>
@endpush
