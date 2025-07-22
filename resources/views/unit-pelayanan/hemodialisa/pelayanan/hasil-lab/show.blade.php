@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: #2c3e50;
            font-size: 0.85rem;
        }

        .header-asesmen {
            margin-top: 0.5rem;
            font-size: 1.3rem;
            font-weight: 600;
            color: #0c82dc;
            text-align: center;
            margin-bottom: 1.2rem;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        .form-section {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1.2rem;
        }

        .section-title {
            font-weight: 600;
            color: #004b85;
            margin-bottom: 1rem;
            font-size: 1rem;
            border-bottom: 2px solid #097dd6;
            padding-bottom: 0.3rem;
        }

        .data-table {
            width: 100%;
            margin-bottom: 0;
        }

        .data-table th {
            background-color: #e9ecef;
            border: 1px solid #dee2e6;
            padding: 0.5rem;
            font-weight: 600;
            color: #495057;
            font-size: 0.8rem;
            width: 30%;
        }

        .data-table td {
            border: 1px solid #dee2e6;
            padding: 0.5rem;
            font-size: 0.85rem;
            color: #212529;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .data-table tbody tr:hover {
            background-color: #e9ecef;
        }

        .value-with-unit {
            font-weight: 500;
            color: #495057;
        }

        .unit {
            color: #6c757d;
            font-size: 0.75rem;
            margin-left: 4px;
        }

        .badge-status {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        .badge-info {
            background-color: #17a2b8;
            color: white;
        }

        .datetime-info {
            background-color: #e3f2fd;
            border: 1px solid #2196f3;
            border-radius: 4px;
            padding: 0.75rem;
            margin-bottom: 1rem;
        }

        .datetime-info h6 {
            color: #1976d2;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .datetime-value {
            font-size: 0.9rem;
            color: #333;
            font-weight: 500;
        }

        .empty-value {
            color: #6c757d;
            font-style: italic;
        }

        .pre-post-table {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .pre-post-item {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            overflow: hidden;
        }

        .pre-post-header {
            background-color: #097dd6;
            color: white;
            padding: 0.5rem;
            font-weight: 600;
            text-align: center;
            font-size: 0.8rem;
        }

        .pre-post-body {
            padding: 0.5rem;
            text-align: center;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .pre-post-table {
                grid-template-columns: 1fr;
            }
            
            .data-table th {
                width: 40%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ route('hemodialisa.pelayanan.hasil-lab.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="btn btn-outline-primary mb-2">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="header-asesmen">Detail Data Hasil Lab</h4>

                    <!-- Tanggal dan Jam Implementasi -->
                    <div class="datetime-info">
                        <h6><i class="ti-calendar mr-2"></i>Waktu Implementasi</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Tanggal:</strong> 
                                <span class="datetime-value">{{ date('d F Y', strtotime($dataHasilLab->tanggal_implementasi)) }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Jam:</strong> 
                                <span class="datetime-value">{{ date('H:i', strtotime($dataHasilLab->jam_implementasi)) }} WIB</span>
                            </div>
                        </div>
                    </div>

                    @if($dataHasilLab->detail)
                        @php $detail = $dataHasilLab->detail; @endphp

                        <!-- Bagian Hematologi -->
                        <div class="form-section">
                            <h5 class="section-title">Hematologi</h5>
                            <table class="table data-table">
                                <tbody>
                                    <tr>
                                        <th>Hemoglobin (Hb)</th>
                                        <td>
                                            @if($detail->hb)
                                                <span class="value-with-unit">{{ number_format($detail->hb, 1) }}<span class="unit">g/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Leukosit</th>
                                        <td>
                                            @if($detail->leukosit)
                                                <span class="value-with-unit">{{ number_format($detail->leukosit, 1) }}<span class="unit">10³/µL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Thrombosit</th>
                                        <td>
                                            @if($detail->thrombosit)
                                                <span class="value-with-unit">{{ number_format($detail->thrombosit) }}<span class="unit">10³/µL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Hematokrit</th>
                                        <td>
                                            @if($detail->hematokrit)
                                                <span class="value-with-unit">{{ number_format($detail->hematokrit, 1) }}<span class="unit">%</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Eritrosit</th>
                                        <td>
                                            @if($detail->eritrosit)
                                                <span class="value-with-unit">{{ number_format($detail->eritrosit, 1) }}<span class="unit">10⁶/µL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>LED</th>
                                        <td>
                                            @if($detail->led)
                                                <span class="value-with-unit">{{ number_format($detail->led) }}<span class="unit">mm/jam</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Golongan Darah</th>
                                        <td>
                                            @if($detail->golongan_darah)
                                                <span class="badge badge-info badge-status">{{ $detail->golongan_darah }}</span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Bagian Fungsi Ginjal -->
                        <div class="form-section">
                            <h5 class="section-title">Fungsi Ginjal</h5>
                            
                            <!-- Ureum Pre/Post -->
                            <div class="mb-3">
                                <h6 class="mb-2">Ureum</h6>
                                <div class="pre-post-table">
                                    <div class="pre-post-item">
                                        <div class="pre-post-header">Pre-Dialisis</div>
                                        <div class="pre-post-body">
                                            @if($detail->ureum_pre)
                                                {{ number_format($detail->ureum_pre, 1) }} <span class="unit">mg/dL</span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="pre-post-item">
                                        <div class="pre-post-header">Post-Dialisis</div>
                                        <div class="pre-post-body">
                                            @if($detail->ureum_post)
                                                {{ number_format($detail->ureum_post, 1) }} <span class="unit">mg/dL</span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kreatinin Pre/Post -->
                            <div class="mb-3">
                                <h6 class="mb-2">Kreatinin</h6>
                                <div class="pre-post-table">
                                    <div class="pre-post-item">
                                        <div class="pre-post-header">Pre-Dialisis</div>
                                        <div class="pre-post-body">
                                            @if($detail->kreatinin_pre)
                                                {{ number_format($detail->kreatinin_pre, 1) }} <span class="unit">mg/dL</span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="pre-post-item">
                                        <div class="pre-post-header">Post-Dialisis</div>
                                        <div class="pre-post-body">
                                            @if($detail->kreatinin_post)
                                                {{ number_format($detail->kreatinin_post, 1) }} <span class="unit">mg/dL</span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <table class="table data-table">
                                <tbody>
                                    <tr>
                                        <th>URR (Urea Reduction Ratio)</th>
                                        <td>
                                            @if($detail->urr)
                                                <span class="value-with-unit">{{ number_format($detail->urr, 1) }}<span class="unit">%</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Asam Urat</th>
                                        <td>
                                            @if($detail->asam_urat)
                                                <span class="value-with-unit">{{ number_format($detail->asam_urat, 1) }}<span class="unit">mg/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Bagian Anemia -->
                        <div class="form-section">
                            <h5 class="section-title">Anemia</h5>
                            <table class="table data-table">
                                <tbody>
                                    <tr>
                                        <th>Besi (Fe)</th>
                                        <td>
                                            @if($detail->besi_fe)
                                                <span class="value-with-unit">{{ number_format($detail->besi_fe, 1) }}<span class="unit">µg/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>TIBC</th>
                                        <td>
                                            @if($detail->tibc)
                                                <span class="value-with-unit">{{ number_format($detail->tibc, 1) }}<span class="unit">µg/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Saturasi Transferin</th>
                                        <td>
                                            @if($detail->saturasi_transferin)
                                                <span class="value-with-unit">{{ number_format($detail->saturasi_transferin, 1) }}<span class="unit">%</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Feritin</th>
                                        <td>
                                            @if($detail->feritin)
                                                <span class="value-with-unit">{{ number_format($detail->feritin, 1) }}<span class="unit">ng/mL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Bagian Fungsi Hati -->
                        <div class="form-section">
                            <h5 class="section-title">Fungsi Hati</h5>
                            <table class="table data-table">
                                <tbody>
                                    <tr>
                                        <th>SGOT</th>
                                        <td>
                                            @if($detail->sgot)
                                                <span class="value-with-unit">{{ number_format($detail->sgot, 1) }}<span class="unit">U/L</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>SGPT</th>
                                        <td>
                                            @if($detail->sgpt)
                                                <span class="value-with-unit">{{ number_format($detail->sgpt, 1) }}<span class="unit">U/L</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Bilirubin Total</th>
                                        <td>
                                            @if($detail->bilirubin_total)
                                                <span class="value-with-unit">{{ number_format($detail->bilirubin_total, 1) }}<span class="unit">mg/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Bilirubin Direct</th>
                                        <td>
                                            @if($detail->bilirubin_direct)
                                                <span class="value-with-unit">{{ number_format($detail->bilirubin_direct, 1) }}<span class="unit">mg/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Protein Total</th>
                                        <td>
                                            @if($detail->protein_total)
                                                <span class="value-with-unit">{{ number_format($detail->protein_total, 1) }}<span class="unit">g/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Albumin</th>
                                        <td>
                                            @if($detail->albumin)
                                                <span class="value-with-unit">{{ number_format($detail->albumin, 1) }}<span class="unit">g/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Fosfatase Alkali</th>
                                        <td>
                                            @if($detail->fosfatase_alkali)
                                                <span class="value-with-unit">{{ number_format($detail->fosfatase_alkali, 1) }}<span class="unit">U/L</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Gamma GT</th>
                                        <td>
                                            @if($detail->gamma_gt)
                                                <span class="value-with-unit">{{ number_format($detail->gamma_gt, 1) }}<span class="unit">U/L</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Bagian Diabetes Melitus -->
                        <div class="form-section">
                            <h5 class="section-title">Diabetes Melitus</h5>
                            <table class="table data-table">
                                <tbody>
                                    <tr>
                                        <th>Glukosa Puasa</th>
                                        <td>
                                            @if($detail->glukosa_puasa)
                                                <span class="value-with-unit">{{ number_format($detail->glukosa_puasa, 1) }}<span class="unit">mg/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Glukosa 2 Jam PP</th>
                                        <td>
                                            @if($detail->glukosa_2jam_pp)
                                                <span class="value-with-unit">{{ number_format($detail->glukosa_2jam_pp, 1) }}<span class="unit">mg/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Glukosa Sewaktu</th>
                                        <td>
                                            @if($detail->glukosa_sewaktu)
                                                <span class="value-with-unit">{{ number_format($detail->glukosa_sewaktu, 1) }}<span class="unit">mg/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>HbA1c</th>
                                        <td>
                                            @if($detail->hb1a1c)
                                                <span class="value-with-unit">{{ number_format($detail->hb1a1c, 1) }}<span class="unit">%</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Bagian Lemak -->
                        <div class="form-section">
                            <h5 class="section-title">Lemak</h5>
                            <table class="table data-table">
                                <tbody>
                                    <tr>
                                        <th>Kolesterol Total</th>
                                        <td>
                                            @if($detail->kolesterol_total)
                                                <span class="value-with-unit">{{ number_format($detail->kolesterol_total, 1) }}<span class="unit">mg/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>LDL-C</th>
                                        <td>
                                            @if($detail->ldl_c)
                                                <span class="value-with-unit">{{ number_format($detail->ldl_c, 1) }}<span class="unit">mg/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>HDL-C</th>
                                        <td>
                                            @if($detail->hdl_c)
                                                <span class="value-with-unit">{{ number_format($detail->hdl_c, 1) }}<span class="unit">mg/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Trigliserida</th>
                                        <td>
                                            @if($detail->trigliserida)
                                                <span class="value-with-unit">{{ number_format($detail->trigliserida, 1) }}<span class="unit">mg/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Bagian Faal Jantung -->
                        <div class="form-section">
                            <h5 class="section-title">Faal Jantung</h5>
                            <table class="table data-table">
                                <tbody>
                                    <tr>
                                        <th>CK</th>
                                        <td>
                                            @if($detail->ck)
                                                <span class="value-with-unit">{{ number_format($detail->ck, 1) }}<span class="unit">U/L</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>CK-MB</th>
                                        <td>
                                            @if($detail->ck_mb)
                                                <span class="value-with-unit">{{ number_format($detail->ck_mb, 1) }}<span class="unit">U/L</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Troponin T</th>
                                        <td>
                                            @if($detail->troponin_t)
                                                <span class="value-with-unit">{{ number_format($detail->troponin_t, 2) }}<span class="unit">ng/mL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Troponin I</th>
                                        <td>
                                            @if($detail->troponin_i)
                                                <span class="value-with-unit">{{ number_format($detail->troponin_i, 2) }}<span class="unit">ng/mL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>LDH</th>
                                        <td>
                                            @if($detail->ldh)
                                                <span class="value-with-unit">{{ number_format($detail->ldh, 1) }}<span class="unit">U/L</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Bagian Elektrolit -->
                        <div class="form-section">
                            <h5 class="section-title">Elektrolit</h5>
                            <table class="table data-table">
                                <tbody>
                                    <tr>
                                        <th>Natrium</th>
                                        <td>
                                            @if($detail->natrium)
                                                <span class="value-with-unit">{{ number_format($detail->natrium, 1) }}<span class="unit">mEq/L</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Kalium</th>
                                        <td>
                                            @if($detail->kalium)
                                                <span class="value-with-unit">{{ number_format($detail->kalium, 1) }}<span class="unit">mEq/L</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Calcium Ion</th>
                                        <td>
                                            @if($detail->calcium_ion)
                                                <span class="value-with-unit">{{ number_format($detail->calcium_ion, 2) }}<span class="unit">mmol/L</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Clorida</th>
                                        <td>
                                            @if($detail->clorida)
                                                <span class="value-with-unit">{{ number_format($detail->clorida, 1) }}<span class="unit">mEq/L</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Magnesium</th>
                                        <td>
                                            @if($detail->magnesium)
                                                <span class="value-with-unit">{{ number_format($detail->magnesium, 2) }}<span class="unit">mg/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Calcium Total</th>
                                        <td>
                                            @if($detail->calcium_total)
                                                <span class="value-with-unit">{{ number_format($detail->calcium_total, 1) }}<span class="unit">mg/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Phospor</th>
                                        <td>
                                            @if($detail->phospor)
                                                <span class="value-with-unit">{{ number_format($detail->phospor, 1) }}<span class="unit">mg/dL</span></span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Bagian Imunoserology -->
                        <div class="form-section">
                            <h5 class="section-title">Imunoserology</h5>
                            <table class="table data-table">
                                <tbody>
                                    <tr>
                                        <th>HbsAg Rapid</th>
                                        <td>
                                            @if($detail->hbsag_rapid)
                                                <span class="badge badge-status {{ $detail->hbsag_rapid == 'Reactive (+)' ? 'badge-danger' : 'badge-success' }}">
                                                    {{ $detail->hbsag_rapid }}
                                                </span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>HbsAg Elisa</th>
                                        <td>
                                            @if($detail->hbsag_elisa)
                                                <span class="badge badge-status {{ $detail->hbsag_elisa == 'Reactive (+)' ? 'badge-danger' : 'badge-success' }}">
                                                    {{ $detail->hbsag_elisa }}
                                                </span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Anti HCV Rapid</th>
                                        <td>
                                            @if($detail->anti_hcv_rapid)
                                                <span class="badge badge-status {{ $detail->anti_hcv_rapid == 'Reactive (+)' ? 'badge-danger' : 'badge-success' }}">
                                                    {{ $detail->anti_hcv_rapid }}
                                                </span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Anti HIV Rapid</th>
                                        <td>
                                            @if($detail->anti_hiv_rapid)
                                                <span class="badge badge-status {{ $detail->anti_hiv_rapid == 'Reactive (+)' ? 'badge-danger' : 'badge-success' }}">
                                                    {{ $detail->anti_hiv_rapid }}
                                                </span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Anti HIV 3 Metode</th>
                                        <td>
                                            @if($detail->anti_hiv_3_metode)
                                                <span class="badge badge-status {{ $detail->anti_hiv_3_metode == 'Reactive (+)' ? 'badge-danger' : 'badge-success' }}">
                                                    {{ $detail->anti_hiv_3_metode }}
                                                </span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>FOB</th>
                                        <td>
                                            @if($detail->fob)
                                                <span class="badge badge-status {{ $detail->fob == 'Positif (+)' ? 'badge-danger' : 'badge-success' }}">
                                                    {{ $detail->fob }}
                                                </span>
                                            @else
                                                <span class="empty-value">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <!-- Bagian Pemeriksaan Tambahan -->
                    @if($dataHasilLab->pemeriksaan_urine_rutin || $dataHasilLab->pemeriksaan_feres_rutin || $dataHasilLab->pemeriksaan_lain_lain)
                        <div class="form-section">
                            <h5 class="section-title">Pemeriksaan Tambahan</h5>
                            
                            @if($dataHasilLab->pemeriksaan_urine_rutin)
                                <div class="mb-3">
                                    <h6 class="mb-2"><i class="ti-dropbox mr-2"></i>Pemeriksaan Urine Rutin</h6>
                                    <div class="p-3" style="background-color: white; border: 1px solid #dee2e6; border-radius: 4px;">
                                        {!! nl2br(e($dataHasilLab->pemeriksaan_urine_rutin)) !!}
                                    </div>
                                </div>
                            @endif

                            @if($dataHasilLab->pemeriksaan_feres_rutin)
                                <div class="mb-3">
                                    <h6 class="mb-2"><i class="ti-package mr-2"></i>Pemeriksaan Feres Rutin</h6>
                                    <div class="p-3" style="background-color: white; border: 1px solid #dee2e6; border-radius: 4px;">
                                        {!! nl2br(e($dataHasilLab->pemeriksaan_feres_rutin)) !!}
                                    </div>
                                </div>
                            @endif

                            @if($dataHasilLab->pemeriksaan_lain_lain)
                                <div class="mb-3">
                                    <h6 class="mb-2"><i class="ti-clipboard mr-2"></i>Pemeriksaan Lain-Lain</h6>
                                    <div class="p-3" style="background-color: white; border: 1px solid #dee2e6; border-radius: 4px;">
                                        {!! nl2br(e($dataHasilLab->pemeriksaan_lain_lain)) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('hemodialisa.pelayanan.hasil-lab.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" 
                           class="btn btn-secondary">
                            <i class="ti-arrow-left mr-2"></i> Kembali ke Daftar
                        </a>
                        
                        <div>
                            <a href="{{ route('hemodialisa.pelayanan.hasil-lab.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $dataHasilLab->id]) }}" 
                               class="btn btn-warning mr-2">
                                <i class="ti-pencil mr-2"></i> Edit Data
                            </a>
                            
                            <button type="button" class="btn btn-primary" onclick="window.print()">
                                <i class="ti-printer mr-2"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Loading state for Edit button
            $('.btn-warning').on('click', function(e) {
                const $btn = $(this);
                
                // Show loading state
                $btn.prop('disabled', true);
                $btn.html('<i class="spinner-border spinner-border-sm mr-2" role="status"></i> Memuat...');
                $btn.addClass('btn-loading');
            });

            // Loading state for Back button
            $('.btn-secondary').on('click', function(e) {
                const $btn = $(this);
                
                // Show loading state
                $btn.prop('disabled', true);
                $btn.html('<i class="spinner-border spinner-border-sm mr-2" role="status"></i> Memuat...');
                $btn.addClass('btn-loading');
            });

            // Print functionality
            $('#printBtn').on('click', function() {
                window.print();
            });

            // Re-enable buttons if user navigates back
            $(window).on('pageshow', function(event) {
                if (event.originalEvent.persisted) {
                    $('.btn-loading').each(function() {
                        const $btn = $(this);
                        $btn.prop('disabled', false);
                        $btn.removeClass('btn-loading');
                        
                        if ($btn.hasClass('btn-warning')) {
                            $btn.html('<i class="ti-pencil mr-2"></i> Edit Data');
                        } else if ($btn.hasClass('btn-secondary')) {
                            $btn.html('<i class="ti-arrow-left mr-2"></i> Kembali ke Daftar');
                        }
                    });
                }
            });
        });

        // CSS untuk print
        const printStyles = `
            @media print {
                .btn, .card-header, nav, .sidebar {
                    display: none !important;
                }
                .card {
                    border: none !important;
                    box-shadow: none !important;
                }
                .form-section {
                    break-inside: avoid;
                    margin-bottom: 15px;
                }
                .data-table {
                    font-size: 12px;
                }
                .header-asesmen {
                    color: #000 !important;
                }
                .section-title {
                    color: #000 !important;
                    border-bottom: 1px solid #000 !important;
                }
            }
        `;
        
        // Tambahkan style untuk print
        const styleSheet = document.createElement("style");
        styleSheet.type = "text/css";
        styleSheet.innerText = printStyles;
        document.head.appendChild(styleSheet);
    </script>
@endpush