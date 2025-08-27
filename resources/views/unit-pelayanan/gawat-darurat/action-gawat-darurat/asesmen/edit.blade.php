@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        /* =================== BASE STYLES =================== */
        .header-asesmen {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .text-muted {
            color: #6c757d !important;
        }

        /* =================== FORM STYLES =================== */
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .form-label.required::after {
            content: " *";
            color: #dc3545;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-control,
        .form-select {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        /* =================== SECTION STYLES =================== */
        .section-separator {
            border-top: 2px solid #097dd6;
            margin: 2rem 0;
            padding-top: 1.5rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .section-title::before {
            content: "";
            width: 4px;
            height: 24px;
            background-color: #097dd6;
            margin-right: 0.75rem;
            border-radius: 2px;
        }

        /* =================== TABLE STYLES =================== */
        .table {
            margin-bottom: 0;
        }

        .table-light {
            background-color: #f8f9fa;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
            padding: 0.75rem;
            vertical-align: middle;
        }

        .table-responsive {
            border-radius: 0.375rem;
            overflow: hidden;
        }

        /* =================== CHECKBOX STYLES =================== */
        .form-check {
            margin-bottom: 0.5rem;
            padding-left: 1.5rem;
        }

        .form-check-input {
            margin-top: 0.125rem;
        }

        .form-check-label {
            margin-bottom: 0;
            cursor: pointer;
        }

        /* =================== INPUT GROUP STYLES =================== */
        .input-group {
            border-radius: 0.375rem;
            overflow: hidden;
        }

        .input-group .form-control {
            border-right: none;
        }

        .input-group .btn {
            border-left: 1px solid #ced4da;
            white-space: nowrap;
        }

        .input-group .form-control:focus {
            border-color: #097dd6;
            box-shadow: none;
        }

        .input-group .form-control:focus+.btn {
            border-color: #097dd6;
        }

        /* GCS Input specific styling */
        .input-group .form-control[readonly] {
            background-color: #f8f9fa;
            cursor: pointer;
        }

        .input-group .form-control.is-valid {
            border-color: #28a745;
            background-color: #f8fff9;
        }

        /* =================== VITAL SIGN STYLES =================== */
        .vital-sign-group {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 0.5rem;
            border: 1px solid #e9ecef;
        }

        .vital-sign-group .form-group:last-child {
            margin-bottom: 0;
        }

        /* =================== PAIN SCALE STYLES =================== */
        .pain-scale-input {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
            border: 1px solid #e9ecef;
        }

        .pain-scale-buttons .btn-group {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .pain-scale-images {
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            overflow: hidden;
            background-color: #fff;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pain-scale-image {
            padding: 1rem;
            text-align: center;
        }

        .pain-scale-image img {
            max-width: 100%;
            height: auto;
            border-radius: 0.375rem;
        }

        #skalaNyeriBtn {
            min-width: 150px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        /* =================== PEMERIKSAAN FISIK STYLES =================== */
        .pemeriksaan-fisik-info {
            background-color: #e7f3ff;
            padding: 1rem;
            border-radius: 0.5rem;
            border-left: 4px solid #097dd6;
        }

        .pemeriksaan-item {
            transition: all 0.2s ease;
        }

        .pemeriksaan-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .pemeriksaan-item .border {
            border-color: #e9ecef !important;
            transition: border-color 0.2s ease;
        }

        .pemeriksaan-item:hover .border {
            border-color: #097dd6 !important;
        }

        .keterangan input {
            border-color: #ffc107;
            background-color: #fff8e1;
        }

        .keterangan input:focus {
            border-color: #ff9800;
            box-shadow: 0 0 0 0.2rem rgba(255, 152, 0, 0.25);
        }

        /* =================== DIAGNOSIS STYLES =================== */
        .diagnosis-item {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 0.75rem;
            transition: all 0.2s ease;
            cursor: move;
        }

        .diagnosis-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-color: #097dd6;
        }

        .diagnosis-item.dragging {
            opacity: 0.5;
            transform: rotate(5deg);
        }

        .diagnosis-content {
            background-color: white;
            padding: 0.75rem;
            border-radius: 0.375rem;
            border-left: 4px solid #097dd6;
        }

        .diagnosis-number {
            background-color: #097dd6;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.875rem;
        }

        .drag-handle {
            cursor: move;
            color: #6c757d;
            font-size: 1.2rem;
        }

        .drag-handle:hover {
            color: #097dd6;
        }

        .diagnosis-list {
            min-height: 50px;
        }

        .diagnosis-item .btn-group {
            gap: 0.25rem;
        }

        .sortable-ghost {
            opacity: 0.4;
        }

        .sortable-chosen {
            transform: scale(1.02);
        }

        /* =================== ALAT TERPASANG STYLES =================== */
        .alat-item {
            transition: all 0.2s ease;
        }

        .alat-item:hover {
            background-color: #f8f9fa;
        }

        #alatTerpasangTable .btn-group {
            gap: 0.25rem;
        }

        /* =================== TINDAK LANJUT SPECIFIC STYLES =================== */
        .tindak-lanjut-options {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            padding: 1.5rem;
        }

        .conditional-form {
            margin-top: 1.5rem;
            animation: fadeIn 0.3s ease;
        }

        .conditional-form .card {
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .conditional-form .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 0.75rem 1rem;
        }

        .conditional-form .card-header h6 {
            color: #097dd6;
            font-weight: 600;
            margin-bottom: 0;
        }

        .conditional-form .card-body {
            padding: 1.5rem;
        }

        /* Alert styling */
        .alert-info {
            background-color: #e7f3ff;
            border-color: #b8daff;
            color: #0c5460;
        }


        /* =================== BUTTON STYLES =================== */
        .btn {
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: #097dd6;
            border-color: #097dd6;
        }

        .btn-primary:hover {
            background-color: #0866b3;
            border-color: #0866b3;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(9, 125, 214, 0.3);
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            border-color: #097dd6;
            color: white;
        }

        .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1.125rem;
        }

        /* =================== RESPONSIVE DESIGN =================== */
        @media (max-width: 768px) {
            .header-asesmen {
                font-size: 1.25rem;
            }

            .section-title {
                font-size: 1.1rem;
            }

            .vital-sign-group {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .pain-scale-buttons .btn-group {
                flex-direction: column;
            }

            .pain-scale-buttons .btn {
                margin-bottom: 0.5rem;
            }

            .pain-scale-input {
                margin-bottom: 1rem;
            }

            .pemeriksaan-item {
                margin-bottom: 1rem;
            }

            .d-flex.align-items-center.gap-3 {
                flex-direction: column;
                align-items: stretch !important;
                gap: 1rem !important;
            }

            #skalaNyeriBtn {
                min-width: 100%;
            }

            .tindak-lanjut-options {
                padding: 1rem;
            }

            .radio-option {
                padding: 0.75rem;
                margin-bottom: 0.5rem;
            }

            .conditional-form .card-body {
                padding: 1rem;
            }

        }

        /* =================== UTILITY CLASSES =================== */
        .text-small {
            font-size: 0.875rem;
        }

        .border-rounded {
            border-radius: 0.5rem;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .gap-3 {
            gap: 1rem !important;
        }

        /* =================== DROPDOWN STYLES =================== */
        .dropdown-menu {
            display: none;
            position: absolute;
            min-width: 300px;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, .15);
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
            z-index: 1000;
            max-height: 400px;
            overflow-y: auto;
        }

        .dropdown-wrapper {
            position: relative;
            display: inline-block;
        }

        /* =================== COLOR BUTTON STYLES =================== */
        .color-btn {
            width: 35px;
            height: 35px;
            border: 2px solid #dee2e6;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .color-btn:hover {
            transform: scale(1.1);
            border-color: #6c757d;
        }

        .color-btn.active {
            border-color: #fff;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.3);
            transform: scale(1.1);
        }

        /* =================== ANIMATION STYLES =================== */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .keterangan {
            animation: fadeIn 0.3s ease;
        }

        /* =================== FOCUS STYLES =================== */
        .form-control:focus,
        .form-select:focus,
        .btn:focus {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        /* =================== PRINT STYLES =================== */
        @media print {

            .btn,
            .pain-scale-buttons {
                display: none !important;
            }

            .section-separator {
                break-inside: avoid;
            }

            .pemeriksaan-item {
                break-inside: avoid;
            }
        }
    </style>
@endpush

@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ route('asesmen.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                class="btn btn-outline-secondary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="card">
                <div class="card-body">
                    <div class="px-3">
                        {{-- Form opening tag --}}
                        <form method="POST"
                            action="{{ route('asesmen.update', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $asesmen->id]) }}">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <h4 class="header-asesmen">Edit Asesmen Awal Gawat Darurat Medis</h4>
                                    <p class="text-muted">
                                        Edit Asesmen medis dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>

                                {{-- DATA TRIASE --}}
                                <div class="section-separator" id="data-triase">
                                    <h5 class="section-title">Data Triase</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Tanggal/Jam</th>
                                                    <th>Dokter</th>
                                                    <th>Triage</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($dataMedis->dataTriase)
                                                    <tr>
                                                        <td>{{ date('d-m-Y H:i', strtotime($dataMedis->dataTriase->tanggal_triase)) }}
                                                        </td>
                                                        <td>
                                                            @if ($dataMedis->dataTriase->dokter)
                                                                {{ $dataMedis->dataTriase->dokter->nama_lengkap }}
                                                            @else
                                                                Tidak Ada Dokter
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="rounded-circle {{ $triageClass ?? 'bg-secondary' }}"
                                                                style="width: 35px; height: 35px;"></div>
                                                        </td>
                                                        <td>
                                                            <a href="#"
                                                                class="btn btn-sm btn-outline-primary">Detail</a>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted py-3">
                                                            <i class="bi bi-info-circle me-2"></i>
                                                            Tidak ada data triase untuk pasien ini
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- TANGGAL DAN JAM PENGISIAN --}}
                                <div class="section-separator" id="data-masuk">
                                    <h6 class="mb-3">Tanggal dan Jam Pengisian</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Tanggal</label>
                                                <input type="date" class="form-control" name="tanggal_masuk"
                                                    id="tanggal_masuk"
                                                    value="{{ $asesmen->waktu_asesmen ? date('Y-m-d', strtotime($asesmen->waktu_asesmen)) : date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Jam</label>
                                                <input type="time" class="form-control" name="jam_masuk" id="jam_masuk"
                                                    value="{{ $asesmen->waktu_asesmen ? date('H:i', strtotime($asesmen->waktu_asesmen)) : date('H:i') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    {{-- TINDAKAN RESUSITASI --}}
                                    <h6 class="mb-3">Tindakan Resusitasi</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-center">Air Way</th>
                                                    <th class="text-center">Breathing</th>
                                                    <th class="text-center">Circulation</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    @php
                                                        // Handle tindakan_resusitasi dengan pengecekan tipe data yang aman
                                                        $tindakanResusitasi = [];
                                                        if (isset($asesmen->tindakan_resusitasi)) {
                                                            if (is_array($asesmen->tindakan_resusitasi)) {
                                                                $tindakanResusitasi = $asesmen->tindakan_resusitasi;
                                                            } elseif (is_string($asesmen->tindakan_resusitasi)) {
                                                                $decoded = json_decode(
                                                                    $asesmen->tindakan_resusitasi,
                                                                    true,
                                                                );
                                                                $tindakanResusitasi = is_array($decoded)
                                                                    ? $decoded
                                                                    : [];
                                                            }
                                                        }

                                                        $airWay = $tindakanResusitasi['air_way'] ?? [];
                                                        $breathing = $tindakanResusitasi['breathing'] ?? [];
                                                        $circulation = $tindakanResusitasi['circulation'] ?? [];

                                                        // Pastikan setiap array adalah array, bukan string
                                                        $airWay = is_array($airWay) ? $airWay : [];
                                                        $breathing = is_array($breathing) ? $breathing : [];
                                                        $circulation = is_array($circulation) ? $circulation : [];
                                                    @endphp
                                                    <td class="p-3">
                                                        <div class="form-check mb-2">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="tindakan_resusitasi[air_way][]" value="Hyperekstesi"
                                                                id="hyperekstesi_edit"
                                                                {{ in_array('Hyperekstesi', $airWay) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="hyperekstesi_edit">Hyperekstesi</label>
                                                        </div>
                                                        <div class="form-check mb-2">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="tindakan_resusitasi[air_way][]"
                                                                value="Bersihkan jalan nafas" id="bersihkanJalanNafas_edit"
                                                                {{ in_array('Bersihkan jalan nafas', $airWay) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="bersihkanJalanNafas_edit">Bersihkan jalan nafas</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="tindakan_resusitasi[air_way][]" value="Intubasi"
                                                                id="intubasi_edit"
                                                                {{ in_array('Intubasi', $airWay) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="intubasi_edit">Intubasi</label>
                                                        </div>
                                                    </td>
                                                    <td class="p-3">
                                                        <div class="form-check mb-2">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="tindakan_resusitasi[breathing][]" value="Bag and Mask"
                                                                id="bagAndMask_edit"
                                                                {{ in_array('Bag and Mask', $breathing) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="bagAndMask_edit">Bag and
                                                                Mask</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="tindakan_resusitasi[breathing][]" value="Bag and Tube"
                                                                id="bagAndTube_edit"
                                                                {{ in_array('Bag and Tube', $breathing) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="bagAndTube_edit">Bag and
                                                                Tube</label>
                                                        </div>
                                                    </td>
                                                    <td class="p-3">
                                                        <div class="form-check mb-2">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="tindakan_resusitasi[circulation][]"
                                                                value="Kompresi jantung" id="kompresiJantung_edit"
                                                                {{ in_array('Kompresi jantung', $circulation) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="kompresiJantung_edit">Kompresi jantung</label>
                                                        </div>
                                                        <div class="form-check mb-2">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="tindakan_resusitasi[circulation][]"
                                                                value="Balut tekan" id="balutTekan_edit"
                                                                {{ in_array('Balut tekan', $circulation) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="balutTekan_edit">Balut
                                                                tekan</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="tindakan_resusitasi[circulation][]" value="Operasi"
                                                                id="operasi_edit"
                                                                {{ in_array('Operasi', $circulation) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="operasi_edit">Operasi</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- ANAMNESIS --}}
                                <div class="section-separator" id="anamnesis">
                                    <h5 class="section-title">1. Anamnesis</h5>
                                    <div class="form-group">
                                        <label class="form-label">Keluhan Utama</label>
                                        <textarea class="form-control" name="keluhan_utama" rows="3" placeholder="Masukkan keluhan utama pasien...">{{ $asesmen->anamnesis ?? '' }}</textarea>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="form-label">Riwayat Penyakit</label>
                                        <textarea class="form-control" name="riwayat_penyakit" rows="3"
                                            placeholder="Masukkan riwayat penyakit pasien...">{{ $asesmen->riwayat_penyakit ?? '' }}</textarea>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="form-label">Riwayat Penyakit Keluarga</label>
                                        <textarea class="form-control" name="riwayat_penyakit_keluarga" rows="3"
                                            placeholder="Masukkan riwayat penyakit keluarga...">{{ $asesmen->riwayat_penyakit_keluarga ?? '' }}</textarea>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="form-label">Riwayat Pengobatan</label>
                                        <textarea class="form-control" name="riwayat_pengobatan" rows="3"
                                            placeholder="Masukkan riwayat pengobatan...">{{ $asesmen->riwayat_pengobatan ?? '' }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <button type="button" class="btn btn-outline-primary mb-3" id="openAlergiModal"
                                            data-bs-toggle="modal" data-bs-target="#alergiModal">
                                            <i class="ti-plus"></i> Tambah Alergi
                                        </button>
                                        <input type="hidden" name="alergis" id="alergisInput" value="[]">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="createAlergiTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Jenis Alergi</th>
                                                        <th>Alergen</th>
                                                        <th>Reaksi</th>
                                                        <th>Tingkat Keparahan</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="no-alergi-row">
                                                        <td colspan="5" class="text-center text-muted">Tidak ada data
                                                            alergi</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                {{-- 2. VITAL SIGN --}}
                                <div class="section-separator" id="vital-sign">
                                    <h5 class="section-title">2. Vital Sign</h5>

                                    @php
                                        // Parse data vital sign dan antropometri dari controller
                                        $vitalSignData = $vitalSign ?? [];
                                        $antropometriData = $antropometri ?? [];
                                    @endphp

                                    @if ($triaseVitalSign)
                                        <div class="alert alert-info mb-3">
                                            <i class="bi bi-info-circle me-2"></i>
                                            <strong>Data dari Triase Terakhir:</strong> Form telah diisi otomatis dengan
                                            data
                                            vital sign dari triase terakhir. Anda dapat mengubah nilai sesuai kebutuhan.
                                        </div>
                                    @endif

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="vital-sign-group">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">TD Sistole (mmHg)</label>
                                                    <input type="number" class="form-control"
                                                        name="vital_sign[td_sistole]"
                                                        value="{{ $vitalSignData['td_sistole'] ?? ($triaseVitalSign['sistole'] ?? '') }}">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">TD Diastole (mmHg)</label>
                                                    <input type="number" class="form-control"
                                                        name="vital_sign[td_diastole]"
                                                        value="{{ $vitalSignData['td_diastole'] ?? ($triaseVitalSign['diastole'] ?? '') }}">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Nadi (x/menit)</label>
                                                    <input type="number" class="form-control" name="vital_sign[nadi]"
                                                        value="{{ $vitalSignData['nadi'] ?? ($triaseVitalSign['nadi'] ?? '') }}">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Suhu (°C)</label>
                                                    <input type="number" step="0.1" class="form-control"
                                                        name="vital_sign[suhu]"
                                                        value="{{ $vitalSignData['temp'] ?? ($triaseVitalSign['suhu'] ?? '') }}">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">TB (cm)</label>
                                                    <input type="number" class="form-control" name="antropometri[tb]"
                                                        id="tbInput" onchange="hitungIMT()"
                                                        value="{{ $antropometriData['tb'] ?? ($triaseVitalSign['tinggi_badan'] ?? '') }}">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">BB (kg)</label>
                                                    <input type="number" step="0.1" class="form-control"
                                                        name="antropometri[bb]" id="bbInput" onchange="hitungIMT()"
                                                        value="{{ $antropometriData['bb'] ?? ($triaseVitalSign['berat_badan'] ?? '') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="vital-sign-group">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">Respirasi (x/menit)</label>
                                                    <input type="number" class="form-control"
                                                        name="vital_sign[respirasi]"
                                                        value="{{ $vitalSignData['rr'] ?? ($triaseVitalSign['respiration'] ?? '') }}">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">SpO2 tanpa O2 (%)</label>
                                                    <input type="number" class="form-control"
                                                        name="vital_sign[spo2_tanpa_o2]"
                                                        value="{{ $vitalSignData['spo2_tanpa_o2'] ?? ($triaseVitalSign['spo2_tanpa_o2'] ?? '') }}">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">SpO2 dengan O2 (%)</label>
                                                    <input type="number" class="form-control"
                                                        name="vital_sign[spo2_dengan_o2]"
                                                        value="{{ $vitalSignData['spo2_dengan_o2'] ?? ($triaseVitalSign['spo2_dengan_o2'] ?? '') }}">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">GCS</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="vital_sign[gcs]"
                                                            id="gcsInput" placeholder="Contoh: 15 E4 V5 M6" readonly
                                                            value="{{ $vitalSignData['gcs'] ?? '' }}">
                                                        <button type="button" class="btn btn-outline-primary"
                                                            onclick="openGCSModal()" title="Buka Kalkulator GCS">
                                                            <i class="ti-calculator"></i> Hitung GCS
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Lingkar Kepala (cm)</label>
                                                    <input type="number" step="0.1" class="form-control"
                                                        name="antropometri[lpt]"
                                                        value="{{ $antropometriData['lpt'] ?? '' }}">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">IMT (kg/m²)</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="antropometri[imt]" id="imtInput" readonly
                                                            value="{{ $antropometriData['imt'] ?? '' }}">
                                                        <span class="input-group-text" id="imtKategori">Normal</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- PENGKAJIAN STATUS NYERI --}}
                                <div class="section-separator" id="status-nyeri">
                                    <h5 class="section-title">3. Pengkajian Status Nyeri</h5>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="pain-scale-input">
                                                <label class="form-label">Skala Nyeri (0-10)</label>
                                                <div class="d-flex align-items-center gap-3">
                                                    <input type="number" class="form-control" name="skala_nyeri"
                                                        style="width: 100px;" value="{{ $asesmen->skala_nyeri ?? 0 }}"
                                                        min="0" max="10">
                                                    <button type="button" class="btn btn-success" id="skalaNyeriBtn">
                                                        @php
                                                            $skala = $asesmen->skala_nyeri ?? 0;
                                                            if ($skala == 0) {
                                                                echo 'Tidak Nyeri';
                                                            } elseif ($skala <= 3) {
                                                                echo 'Nyeri Ringan';
                                                            } elseif ($skala <= 6) {
                                                                echo 'Nyeri Sedang';
                                                            } else {
                                                                echo 'Nyeri Berat';
                                                            }
                                                        @endphp
                                                    </button>
                                                    <input type="hidden" name="skala_nyeri_nilai"
                                                        value="{{ $asesmen->skala_nyeri ?? 0 }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="pain-scale-buttons mb-3">
                                                <div class="btn-group w-100">
                                                    <button type="button" class="btn btn-outline-primary"
                                                        data-scale="numeric">
                                                        A. Numeric Rating Pain Scale
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary"
                                                        data-scale="wong-baker">
                                                        B. Wong Baker Faces Pain Scale
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="pain-scale-images">
                                                <div id="numericScale" class="pain-scale-image" style="display: none;">
                                                    <img src="{{ asset('assets/img/asesmen/numerik.png') }}"
                                                        alt="Numeric Pain Scale" class="img-fluid">
                                                </div>
                                                <div id="wongBakerScale" class="pain-scale-image" style="display: none;">
                                                    <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}"
                                                        alt="Wong Baker Pain Scale" class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Lokasi</label>
                                                <input type="text" class="form-control" name="lokasi"
                                                    placeholder="Contoh: Kepala, Dada"
                                                    value="{{ $asesmen->lokasi ?? '' }}">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">Pemberat</label>
                                                <select class="form-select" name="faktor_pemberat">
                                                    <option value="">--Pilih--</option>
                                                    @foreach ($faktorpemberat as $pemberat)
                                                        <option value="{{ $pemberat->id }}"
                                                            {{ $asesmen->faktor_pemberat_id == $pemberat->id ? 'selected' : '' }}>
                                                            {{ $pemberat->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">Kualitas</label>
                                                <select class="form-select" name="kualitas">
                                                    <option value="">--Pilih--</option>
                                                    @foreach ($kualitasnyeri as $kualitas)
                                                        <option value="{{ $kualitas->id }}"
                                                            {{ $asesmen->kualitas_nyeri_id == $kualitas->id ? 'selected' : '' }}>
                                                            {{ $kualitas->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">Menjalar</label>
                                                <select class="form-select" name="menjalar">
                                                    <option value="">--Pilih--</option>
                                                    @foreach ($menjalar as $menj)
                                                        <option value="{{ $menj->id }}"
                                                            {{ $asesmen->menjalar_id == $menj->id ? 'selected' : '' }}>
                                                            {{ $menj->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">Efek Nyeri</label>
                                                <select class="form-select" name="efek_nyeri">
                                                    <option value="">--Pilih--</option>
                                                    @foreach ($efeknyeri as $efek)
                                                        <option value="{{ $efek->id }}"
                                                            {{ $asesmen->efek_nyeri == $efek->id ? 'selected' : '' }}>
                                                            {{ $efek->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Durasi</label>
                                                <input type="text" class="form-control" name="durasi"
                                                    placeholder="Contoh: 2 jam, 30 menit"
                                                    value="{{ $asesmen->durasi ?? '' }}">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">Peringan</label>
                                                <select class="form-select" name="faktor_peringan">
                                                    <option value="">--Pilih--</option>
                                                    @foreach ($faktorperingan as $peringan)
                                                        <option value="{{ $peringan->id }}"
                                                            {{ $asesmen->faktor_peringan_id == $peringan->id ? 'selected' : '' }}>
                                                            {{ $peringan->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">Frekuensi</label>
                                                <select class="form-select" name="frekuensi">
                                                    <option value="">--Pilih--</option>
                                                    @foreach ($frekuensinyeri as $frekuensi)
                                                        <option value="{{ $frekuensi->id }}"
                                                            {{ $asesmen->frekuensi_nyeri_id == $frekuensi->id ? 'selected' : '' }}>
                                                            {{ $frekuensi->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">Jenis</label>
                                                <select class="form-select" name="jenis_nyeri">
                                                    <option value="">--Pilih--</option>
                                                    @foreach ($jenisnyeri as $jenis)
                                                        <option value="{{ $jenis->id }}"
                                                            {{ $asesmen->jenis_nyeri_id == $jenis->id ? 'selected' : '' }}>
                                                            {{ $jenis->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- PEMERIKSAAN FISIK --}}
                                <div class="section-separator" id="pemeriksaan-fisik">
                                    <h5 class="section-title">4. Pemeriksaan Fisik</h5>
                                    <div class="pemeriksaan-fisik-info mb-4">
                                        <p class="text-muted small">
                                            Centang "Normal" jika pemeriksaan fisik normal. Klik tombol "+" untuk menambah
                                            keterangan
                                            jika ditemukan kelainan. Jika tidak dipilih salah satunya, maka pemeriksaan
                                            tidak
                                            dilakukan.
                                        </p>
                                    </div>

                                    <div class="row">
                                        @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                            <div class="col-md-6">
                                                @foreach ($chunk as $item)
                                                    @php
                                                        // Get existing physical examination data for this item
                                                        $pemeriksaanData = $pemeriksaanFisikData->get($item->id);
                                                        $isNormal = $pemeriksaanData
                                                            ? $pemeriksaanData->is_normal
                                                            : false;
                                                        $keterangan = $pemeriksaanData
                                                            ? $pemeriksaanData->keterangan
                                                            : '';
                                                    @endphp
                                                    <div class="pemeriksaan-item mb-3">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between border rounded p-3">
                                                            <div class="flex-grow-1">
                                                                <strong>{{ $item->nama }}</strong>
                                                            </div>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="{{ $item->id }}-normal"
                                                                        name="{{ $item->id }}-normal"
                                                                        {{ $isNormal ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="{{ $item->id }}-normal">
                                                                        Normal
                                                                    </label>
                                                                </div>
                                                                <button
                                                                    class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                    type="button"
                                                                    data-target="{{ $item->id }}-keterangan">
                                                                    <i class="bi bi-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="keterangan mt-2" id="{{ $item->id }}-keterangan"
                                                            style="display:{{ !$isNormal || $keterangan ? 'block' : 'none' }};">
                                                            <input type="text" class="form-control"
                                                                name="{{ $item->id }}_keterangan"
                                                                placeholder="Tambah keterangan jika tidak normal..."
                                                                value="{{ $keterangan }}">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- PEMERIKSAAN PENUNJANG KLINIS --}}
                                <div class="section-separator" id="pemeriksaan-penunjang">
                                    <h5 class="section-title">5. Pemeriksaan Penunjang Klinis</h5>

                                    {{-- LABORATORIUM --}}
                                    <h6 class="mb-3">Laboratorium</h6>
                                    <div class="table-responsive mb-4">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Nama Pemeriksaan</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($laborData ?? [] as $data)
                                                    <tr>
                                                        <td>{{ $data['Tanggal-Jam'] ?? '-' }}</td>
                                                        <td>{{ $data['Nama pemeriksaan'] ?? '-' }}</td>
                                                        <td>{{ $data['Status'] ?? '-' }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center text-muted">Tidak ada data
                                                            laboratorium</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- RADIOLOGI --}}
                                    <h6 class="mb-3">Radiologi</h6>
                                    <div class="table-responsive mb-4">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Tanggal dan Jam</th>
                                                    <th>Nama Pemeriksaan</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($radiologiData ?? [] as $rad)
                                                    <tr>
                                                        <td>{{ $rad['Tanggal-Jam'] ?? '-' }}</td>
                                                        <td>{{ $rad['Nama Pemeriksaan'] ?? '-' }}</td>
                                                        <td>{{ $rad['Status'] ?? '-' }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center text-muted">Tidak ada data
                                                            radiologi</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- TINDAKAN --}}
                                    <h6 class="mb-3">Tindakan</h6>
                                    <div class="table-responsive mb-4">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Tanggal dan Jam</th>
                                                    <th>Nama Tindakan</th>
                                                    <th>Dokter</th>
                                                    <th>Unit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($tindakanData ?? [] as $tindakan)
                                                    <tr>
                                                        <td>{{ $tindakan['Tanggal-Jam'] ?? '-' }}</td>
                                                        <td>{{ $tindakan['Nama Tindakan'] ?? '-' }}</td>
                                                        <td>{{ $tindakan['Dokter'] ?? '-' }}</td>
                                                        <td>{{ $tindakan['Unit'] ?? '-' }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted">Tidak ada data
                                                            tindakan</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- E-RESEP --}}
                                    <h6 class="mb-3">E-Resep</h6>
                                    <div class="table-responsive mb-4">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Nama Obat</th>
                                                    <th>Dosis</th>
                                                    <th>Cara Pemberian</th>
                                                    <th>PPA</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($riwayatObat ?? [] as $resep)
                                                    @php
                                                        $cara_pakai_parts = explode(',', $resep->cara_pakai ?? '');
                                                        $frekuensi = trim($cara_pakai_parts[0] ?? '');
                                                        $keterangan = trim($cara_pakai_parts[1] ?? '');
                                                    @endphp
                                                    <tr>
                                                        <td>{{ isset($resep->tgl_order) ? \Carbon\Carbon::parse($resep->tgl_order)->format('d M Y H:i') : '-' }}
                                                        </td>
                                                        <td>{{ $resep->nama_obat ?? 'Tidak ada informasi' }}</td>
                                                        <td>{{ $resep->jumlah_takaran ?? '' }}
                                                            {{ isset($resep->satuan_takaran) ? Str::title($resep->satuan_takaran) : '' }}
                                                        </td>
                                                        <td>{{ $keterangan ?: '-' }}</td>
                                                        <td>{{ $resep->nama_dokter ?? '-' }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted">Tidak ada resep
                                                            obat
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- DIAGNOSIS --}}
                                <div class="section-separator" id="diagnosis">
                                    <h5 class="section-title">6. Diagnosis</h5>

                                    <div class="mb-3">
                                        <button type="button" class="btn btn-outline-primary" id="btnTambahDiagnosis">
                                            <i class="ti-plus"></i> Tambah Diagnosis
                                        </button>
                                    </div>

                                    <div id="diagnosisInputContainer">
                                        @if (isset($diagnosis) && is_array($diagnosis) && count($diagnosis) > 0)
                                            @foreach ($diagnosis as $index => $diag)
                                                <input type="hidden" name="diagnosa_data[]"
                                                    value="{{ is_array($diag) ? $diag['nama'] ?? '' : $diag }}">
                                            @endforeach
                                        @endif
                                    </div>

                                    <div id="diagnosisList" class="diagnosis-list">
                                        @if (isset($diagnosis) && is_array($diagnosis) && count($diagnosis) > 0)
                                            @foreach ($diagnosis as $index => $diag)
                                                @php
                                                    $diagnosisName = is_array($diag) ? $diag['nama'] ?? '' : $diag;
                                                @endphp
                                                <div class="diagnosis-item" data-index="{{ $index }}">
                                                    <div class="d-flex align-items-start gap-3">
                                                        <div class="drag-handle">
                                                            <i class="ti-menu"></i>
                                                        </div>
                                                        <div class="diagnosis-number">
                                                            {{ $index + 1 }}
                                                        </div>
                                                        <div class="diagnosis-content flex-grow-1">
                                                            <div class="fw-medium text-dark">{{ $diagnosisName }}</div>
                                                        </div>
                                                        <div class="btn-group">
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-primary edit-diagnosis"
                                                                data-index="{{ $index }}" title="Edit">
                                                                <i class="ti-pencil"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-danger delete-diagnosis"
                                                                data-index="{{ $index }}" title="Hapus">
                                                                <i class="ti-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div id="noDiagnosisMessage" class="text-center text-muted py-2"
                                        style="border: 2px dashed #dee2e6; border-radius: 0.5rem; {{ isset($diagnosis) && is_array($diagnosis) && count($diagnosis) > 0 ? 'display: none;' : '' }}">
                                        <i class="ti-file-text" style="font-size: 2rem; opacity: 0.5;"></i>
                                        <p class="mb-0 mt-2">Belum ada diagnosis yang ditambahkan</p>
                                        <small>Klik tombol "Tambah Diagnosis" untuk menambah diagnosis</small>
                                    </div>
                                </div>

                                {{-- MODAL DIAGNOSIS --}}
                                <div class="modal fade" id="diagnosisModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="diagnosisModalTitle">Tambah Diagnosis</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="form-label required">Nama Diagnosis</label>
                                                    <input class="form-control" id="namaDiagnosis" name="namaDiagnosis"
                                                        placeholder="Masukkan nama diagnosis...">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="button" class="btn btn-primary" id="btnSimpanDiagnosis">
                                                    <i class="ti-check"></i> Simpan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- ALAT YANG TERPASANG --}}
                                <div class="section-separator" id="alat-terpasang">
                                    <h5 class="section-title">7. Alat yang Terpasang</h5>

                                    <div class="mb-3">
                                        <button type="button" class="btn btn-outline-primary" id="btnTambahAlat"
                                            data-bs-toggle="modal" data-bs-target="#alatModal">
                                            <i class="ti-plus"></i> Tambah Alat
                                        </button>
                                    </div>

                                    <input type="hidden" name="alat_terpasang_data" id="alatTerpasangData"
                                        value="{{ isset($alatTerpasang) ? json_encode($alatTerpasang) : '[]' }}">

                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="alatTerpasangTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Alat yang Terpasang</th>
                                                    <th>Lokasi</th>
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($alatTerpasang) && is_array($alatTerpasang) && count($alatTerpasang) > 0)
                                                    @foreach ($alatTerpasang as $index => $alat)
                                                        <tr class="alat-item">
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $alat['nama_display'] ?? ($alat['nama'] ?? '-') }}</td>
                                                            <td>{{ $alat['lokasi'] ?? '-' }}</td>
                                                            <td>{{ $alat['keterangan'] ?? '-' }}</td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-outline-primary edit-alat"
                                                                        data-index="{{ $index }}" title="Edit">
                                                                        <i class="ti-pencil"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-outline-danger delete-alat"
                                                                        data-index="{{ $index }}" title="Hapus">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr id="no-alat-row">
                                                        <td colspan="5" class="text-center text-muted">Tidak ada alat
                                                            yang terpasang</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- RETRIASE/OBSERVASI LANJUTAN --}}
                                <div class="section-separator" id="retriase">
                                    <h5 class="section-title">8. Retriase/Observasi Lanjutan</h5>

                                    <div class="mb-3">
                                        <button type="button" class="btn btn-outline-primary" id="btnTambahRetriase"
                                            data-bs-toggle="modal" data-bs-target="#retriaseModal">
                                            <i class="ti-plus"></i> Tambah Retriase
                                        </button>
                                    </div>

                                    <input type="hidden" name="retriase_data" id="retriaseData"
                                        value="{{ isset($retriaseData)
                                            ? json_encode(
                                                $retriaseData->map(function ($item) {
                                                    return [
                                                        'tanggal' => date('Y-m-d', strtotime($item->tanggal_triase)),
                                                        'jam' => date('H:i', strtotime($item->tanggal_triase)),
                                                        'tanggal_jam' => date('d/m/Y H:i', strtotime($item->tanggal_triase)),
                                                        'gcs' => $item->vitalsign_retriase ? json_decode($item->vitalsign_retriase, true)['gcs'] ?? '-' : '-',
                                                        'temp' => $item->vitalsign_retriase ? json_decode($item->vitalsign_retriase, true)['temp'] ?? '-' : '-',
                                                        'rr' => $item->vitalsign_retriase ? json_decode($item->vitalsign_retriase, true)['rr'] ?? '-' : '-',
                                                        'spo2_tanpa_o2' => $item->vitalsign_retriase
                                                            ? json_decode($item->vitalsign_retriase, true)['spo2_tanpa_o2'] ?? '-'
                                                            : '-',
                                                        'spo2_dengan_o2' => $item->vitalsign_retriase
                                                            ? json_decode($item->vitalsign_retriase, true)['spo2_dengan_o2'] ?? '-'
                                                            : '-',
                                                        'td_sistole' => $item->vitalsign_retriase
                                                            ? json_decode($item->vitalsign_retriase, true)['td_sistole'] ?? '-'
                                                            : '-',
                                                        'td_diastole' => $item->vitalsign_retriase
                                                            ? json_decode($item->vitalsign_retriase, true)['td_diastole'] ?? '-'
                                                            : '-',
                                                        'keluhan' => $item->anamnesis_retriase ?? '-',
                                                        'kesimpulan_triase' => $item->kode_triase ?? '-',
                                                        'kesimpulan_triase_text' => $item->hasil_triase ?? '-',
                                                    ];
                                                }),
                                            )
                                            : '[]' }}">

                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="retriaseTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Waktu</th>
                                                    <th>GCS</th>
                                                    <th>Temp</th>
                                                    <th>RR</th>
                                                    <th>SpO2 (tanpa O2)</th>
                                                    <th>SpO2 (dengan O2)</th>
                                                    <th>TD (Sistole)</th>
                                                    <th>TD (Diastole)</th>
                                                    <th>Keluhan</th>
                                                    <th>Retriase</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($retriaseData) && $retriaseData->count() > 0)
                                                    @foreach ($retriaseData as $index => $retriase)
                                                        @php
                                                            $vitalSigns = $retriase->vitalsign_retriase
                                                                ? json_decode($retriase->vitalsign_retriase, true)
                                                                : [];
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ date('d/m/Y H:i', strtotime($retriase->tanggal_triase)) }}
                                                            </td>
                                                            <td>{{ $vitalSigns['gcs'] ?? '-' }}</td>
                                                            <td>{{ ($vitalSigns['temp'] ?? '-') !== '-' ? $vitalSigns['temp'] . '°C' : '-' }}
                                                            </td>
                                                            <td>{{ ($vitalSigns['rr'] ?? '-') !== '-' ? $vitalSigns['rr'] . 'x/mnt' : '-' }}
                                                            </td>
                                                            <td>{{ ($vitalSigns['spo2_tanpa_o2'] ?? '-') !== '-' ? $vitalSigns['spo2_tanpa_o2'] . '%' : '-' }}
                                                            </td>
                                                            <td>{{ ($vitalSigns['spo2_dengan_o2'] ?? '-') !== '-' ? $vitalSigns['spo2_dengan_o2'] . '%' : '-' }}
                                                            </td>
                                                            <td>{{ ($vitalSigns['td_sistole'] ?? '-') !== '-' ? $vitalSigns['td_sistole'] . 'mmHg' : '-' }}
                                                            </td>
                                                            <td>{{ ($vitalSigns['td_diastole'] ?? '-') !== '-' ? $vitalSigns['td_diastole'] . 'mmHg' : '-' }}
                                                            </td>
                                                            <td style="max-width: 200px;">
                                                                <div class="text-truncate"
                                                                    title="{{ $retriase->anamnesis_retriase ?? '-' }}">
                                                                    {{ $retriase->anamnesis_retriase ?? '-' }}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $badgeClass = '';
                                                                    switch ($retriase->kode_triase) {
                                                                        case '1':
                                                                            $badgeClass = 'bg-success';
                                                                            break;
                                                                        case '2':
                                                                            $badgeClass = 'bg-warning';
                                                                            break;
                                                                        case '3':
                                                                            $badgeClass = 'bg-danger';
                                                                            break;
                                                                        case '4':
                                                                            $badgeClass = 'bg-dark';
                                                                            break;
                                                                        case '5':
                                                                            $badgeClass = 'bg-secondary';
                                                                            break;
                                                                        default:
                                                                            $badgeClass = 'bg-light';
                                                                            break;
                                                                    }
                                                                @endphp
                                                                <span class="badge {{ $badgeClass }}">
                                                                    {{ $retriase->hasil_triase ?? '-' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-outline-primary edit-retriase"
                                                                        data-index="{{ $index }}" title="Edit">
                                                                        <i class="ti-pencil"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-outline-danger delete-retriase"
                                                                        data-index="{{ $index }}" title="Hapus">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr id="no-alat-row">
                                                        <td colspan="12" class="text-center text-muted">Tidak ada
                                                            retriase</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- KONDISI PASIEN MENINGGALKAN IGD --}}
                                <div class="section-separator" id="kondisi-pasien">
                                    <h5 class="section-title">9. Kondisi Pasien Meninggalkan IGD</h5>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Kondisi Pasien</label>
                                        <textarea class="form-control" name="kondisi_pasien" rows="3"
                                            placeholder="Deskripsikan kondisi pasien saat meninggalkan IGD...">{{ $asesmen->kondisi_pasien ?? '' }}</textarea>
                                    </div>
                                </div>

                                {{-- TINDAK LANJUT PELAYANAN --}}
                                <div class="section-separator" id="tindak-lanjut">
                                    <h5 class="section-title">10. Tindak Lanjut Pelayanan</h5>

                                    <div class="mb-3">
                                        <div class="alert alert-info">
                                            <i class="ti-info-alt"></i>
                                            <span class="text-muted">Pilih salah satu tindak lanjut pelayanan yang sesuai
                                                dengan kondisi pasien saat meninggalkan IGD.</span>
                                        </div>
                                    </div>

                                    @php
                                        // Get existing tindak lanjut data
                                        $tindakLanjutData = $asesmen->tindaklanjut ?? null;
                                        $selectedOption = '';

                                        // Determine selected option based on tindak_lanjut_code
                                        if ($tindakLanjutData) {
                                            switch ($tindakLanjutData->tindak_lanjut_code) {
                                                case 1:
                                                    $selectedOption = 'rawatInap';
                                                    break;
                                                case 5:
                                                    $selectedOption = 'rujukKeluar';
                                                    break;
                                                case 6:
                                                    $selectedOption = 'pulangSembuh';
                                                    break;
                                                case 8:
                                                    $selectedOption = 'berobatJalan';
                                                    break;
                                                case 9:
                                                    $selectedOption = 'menolakRawatInap';
                                                    break;
                                                case 10:
                                                    $selectedOption = 'meninggalDunia';
                                                    break;
                                                case 11:
                                                    $selectedOption = 'deathoffarrival';
                                                    break;
                                            }
                                        }
                                    @endphp

                                    <div class="tindak-lanjut-options mb-4">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="radio-option {{ $selectedOption == 'rawatInap' ? 'selected' : '' }}"
                                                    data-target="formRawatInap">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input"
                                                            name="tindakLanjut" value="rawatInap" id="rawatInap"
                                                            {{ $selectedOption == 'rawatInap' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="rawatInap">
                                                            <i class="ti-home me-2"></i>Rawat Inap
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="radio-option {{ $selectedOption == 'rujukKeluar' ? 'selected' : '' }}"
                                                    data-target="formRujukKeluar">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input"
                                                            name="tindakLanjut" value="rujukKeluar" id="rujukKeluar"
                                                            {{ $selectedOption == 'rujukKeluar' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="rujukKeluar">
                                                            <i class="ti-export me-2"></i>Rujuk Keluar RS Lain
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="radio-option {{ $selectedOption == 'pulangSembuh' ? 'selected' : '' }}"
                                                    data-target="formpulangSembuh">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input"
                                                            name="tindakLanjut" value="pulangSembuh" id="pulangSembuh"
                                                            {{ $selectedOption == 'pulangSembuh' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pulangSembuh">
                                                            <i class="ti-check me-2"></i>Pulang
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="radio-option {{ $selectedOption == 'berobatJalan' ? 'selected' : '' }}"
                                                    data-target="formberobatJalan">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input"
                                                            name="tindakLanjut" value="berobatJalan" id="berobatJalan"
                                                            {{ $selectedOption == 'berobatJalan' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="berobatJalan">
                                                            <i class="ti-calendar me-2"></i>Berobat Jalan Ke Poli
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="radio-option {{ $selectedOption == 'menolakRawatInap' ? 'selected' : '' }}"
                                                    data-target="formMenolakRawatInap">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input"
                                                            name="tindakLanjut" value="menolakRawatInap"
                                                            id="menolakRawatInap"
                                                            {{ $selectedOption == 'menolakRawatInap' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="menolakRawatInap">
                                                            <i class="ti-close me-2"></i>Menolak Rawat Inap
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="radio-option {{ $selectedOption == 'meninggalDunia' ? 'selected' : '' }}"
                                                    data-target="formmeninggalDunia">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input"
                                                            name="tindakLanjut" value="meninggalDunia"
                                                            id="meninggalDunia"
                                                            {{ $selectedOption == 'meninggalDunia' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="meninggalDunia">
                                                            <i class="ti-heart-broken me-2"></i>Meninggal Dunia
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="radio-option {{ $selectedOption == 'deathoffarrival' ? 'selected' : '' }}"
                                                    data-target="formDOA">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input"
                                                            name="tindakLanjut" value="deathoffarrival"
                                                            id="deathoffarrival"
                                                            {{ $selectedOption == 'deathoffarrival' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="deathoffarrival">
                                                            <i class="ti-pulse me-2"></i>DOA (Death on Arrival)
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FORM RAWAT INAP --}}
                                    <div class="conditional-form" id="formRawatInap"
                                        style="display: {{ $selectedOption == 'rawatInap' ? 'block' : 'none' }};">
                                        <div class="">
                                            <div class="card-header">
                                                <h6 class="mb-0"><i class="ti-home me-2"></i>Detail Rawat Inap</h6>
                                            </div>
                                            <div class="card-body">
                                                @if ($selectedOption == 'rawatInap' && $asesmen->tindaklanjut && $asesmen->tindaklanjut->spri)
                                                    @php $spriData = $asesmen->tindaklanjut->spri; @endphp
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label required">Tanggal</label>
                                                                <input type="date" class="form-control"
                                                                    name="tanggalRawatInap"
                                                                    value="{{ $spriData->tanggal_ranap ?? date('Y-m-d') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label required">Jam</label>
                                                                <input type="time" class="form-control"
                                                                    name="jamRawatInap"
                                                                    value="{{ $spriData->jam_ranap ?? date('H:i') }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label">Keluhan Utama & Riwayat Penyakit</label>
                                                        <textarea class="form-control" name="keluhanUtama_ranap" rows="3"
                                                            placeholder="Deskripsikan keluhan utama dan riwayat penyakit pasien...">{{ $spriData->keluhan_utama ?? '' }}</textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label">Hasil Pemeriksaan Penunjang
                                                            Klinis</label>
                                                        <textarea class="form-control" name="hasilPemeriksaan_ranap" rows="3"
                                                            placeholder="Hasil laboratorium, radiologi, dan pemeriksaan penunjang lainnya...">{{ $spriData->hasil_pemeriksaan ?? '' }}</textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label">Jalannya Penyakit & Hasil
                                                            Konsultasi</label>
                                                        <textarea class="form-control" name="jalannyaPenyakit_ranap" rows="3"
                                                            placeholder="Perjalanan penyakit dan hasil konsultasi dengan dokter spesialis...">{{ $spriData->jalannya_penyakit ?? '' }}</textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label">Diagnosis</label>
                                                        <textarea class="form-control" name="diagnosis_ranap" rows="3"
                                                            placeholder="Diagnosis utama dan diagnosis sekunder...">{{ $spriData->diagnosis ?? '' }}</textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label">Tindakan yang Telah Dilakukan</label>
                                                        <textarea class="form-control" name="tindakan_ranap" rows="3"
                                                            placeholder="Tindakan medis yang telah dilakukan di IGD...">{{ $spriData->tindakan ?? '' }}</textarea>
                                                    </div>

                                                    <div class="form-group mb-0">
                                                        <label class="form-label">Anjuran</label>
                                                        <textarea class="form-control" name="anjuran_ranap" rows="3"
                                                            placeholder="Anjuran untuk perawatan selanjutnya...">{{ $spriData->anjuran ?? '' }}</textarea>
                                                    </div>
                                                @else
                                                    {{-- Default empty form for rawat inap --}}
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label required">Tanggal</label>
                                                                <input type="date" class="form-control"
                                                                    name="tanggalRawatInap" value="{{ date('Y-m-d') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label required">Jam</label>
                                                                <input type="time" class="form-control"
                                                                    name="jamRawatInap" value="{{ date('H:i') }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label">Keluhan Utama & Riwayat Penyakit</label>
                                                        <textarea class="form-control" name="keluhanUtama_ranap" rows="3"
                                                            placeholder="Deskripsikan keluhan utama dan riwayat penyakit pasien..."></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label">Hasil Pemeriksaan Penunjang
                                                            Klinis</label>
                                                        <textarea class="form-control" name="hasilPemeriksaan_ranap" rows="3"
                                                            placeholder="Hasil laboratorium, radiologi, dan pemeriksaan penunjang lainnya..."></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label">Jalannya Penyakit & Hasil
                                                            Konsultasi</label>
                                                        <textarea class="form-control" name="jalannyaPenyakit_ranap" rows="3"
                                                            placeholder="Perjalanan penyakit dan hasil konsultasi dengan dokter spesialis..."></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label">Diagnosis</label>
                                                        <textarea class="form-control" name="diagnosis_ranap" rows="3"
                                                            placeholder="Diagnosis utama dan diagnosis sekunder..."></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label">Tindakan yang Telah Dilakukan</label>
                                                        <textarea class="form-control" name="tindakan_ranap" rows="3"
                                                            placeholder="Tindakan medis yang telah dilakukan di IGD..."></textarea>
                                                    </div>

                                                    <div class="form-group mb-0">
                                                        <label class="form-label">Anjuran</label>
                                                        <textarea class="form-control" name="anjuran_ranap" rows="3"
                                                            placeholder="Anjuran untuk perawatan selanjutnya..."></textarea>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FORM RUJUK KELUAR --}}
                                    <div class="conditional-form" id="formRujukKeluar"
                                        style="display: {{ $selectedOption == 'rujukKeluar' ? 'block' : 'none' }};">
                                        <div class="">
                                            <div class="card-header">
                                                <h6 class="mb-0"><i class="ti-export me-2"></i>Detail Rujukan</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label class="form-label required">Tujuan Rujuk</label>
                                                    <input type="text" class="form-control" name="tujuan_rujuk"
                                                        placeholder="Nama rumah sakit/fasilitas kesehatan tujuan"
                                                        value="{{ $selectedOption == 'rujukKeluar' ? $tindakLanjutData->tujuan_rujuk ?? '' : '' }}">
                                                </div>

                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label required">Alasan Rujuk</label>
                                                            <select class="form-select" name="alasan_rujuk">
                                                                <option value="">Pilih Alasan Rujuk</option>
                                                                <option value="1"
                                                                    {{ $selectedOption == 'rujukKeluar' && $tindakLanjutData->alasan_rujuk == '1' ? 'selected' : '' }}>
                                                                    Indikasi Medis</option>
                                                                <option value="2"
                                                                    {{ $selectedOption == 'rujukKeluar' && $tindakLanjutData->alasan_rujuk == '2' ? 'selected' : '' }}>
                                                                    Kamar Penuh</option>
                                                                <option value="3"
                                                                    {{ $selectedOption == 'rujukKeluar' && $tindakLanjutData->alasan_rujuk == '3' ? 'selected' : '' }}>
                                                                    Permintaan Pasien</option>
                                                                <option value="4"
                                                                    {{ $selectedOption == 'rujukKeluar' && $tindakLanjutData->alasan_rujuk == '4' ? 'selected' : '' }}>
                                                                    Keterbatasan Fasilitas</option>
                                                                <option value="5"
                                                                    {{ $selectedOption == 'rujukKeluar' && $tindakLanjutData->alasan_rujuk == '5' ? 'selected' : '' }}>
                                                                    Lainnya</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label required">Transportasi Rujuk</label>
                                                            <select class="form-select" name="transportasi_rujuk">
                                                                <option value="">Pilih Transportasi Rujuk</option>
                                                                <option value="1"
                                                                    {{ $selectedOption == 'rujukKeluar' && $tindakLanjutData->transportasi_rujuk == '1' ? 'selected' : '' }}>
                                                                    Ambulance</option>
                                                                <option value="2"
                                                                    {{ $selectedOption == 'rujukKeluar' && $tindakLanjutData->transportasi_rujuk == '2' ? 'selected' : '' }}>
                                                                    Kendaraan Pribadi</option>
                                                                <option value="3"
                                                                    {{ $selectedOption == 'rujukKeluar' && $tindakLanjutData->transportasi_rujuk == '3' ? 'selected' : '' }}>
                                                                    Kendaraan Umum</option>
                                                                <option value="4"
                                                                    {{ $selectedOption == 'rujukKeluar' && $tindakLanjutData->transportasi_rujuk == '4' ? 'selected' : '' }}>
                                                                    Lainnya</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-0">
                                                    <label class="form-label">Keterangan Tambahan</label>
                                                    <textarea class="form-control" name="keterangan_rujuk" rows="3"
                                                        placeholder="Keterangan tambahan mengenai rujukan...">{{ $selectedOption == 'rujukKeluar' ? $tindakLanjutData->keterangan ?? '' : '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FORM PULANG --}}
                                    <div class="conditional-form" id="formpulangSembuh"
                                        style="display: {{ $selectedOption == 'pulangSembuh' ? 'block' : 'none' }};">
                                        <div class="">
                                            <div class="card-header">
                                                <h6 class="mb-0"><i class="ti-check me-2"></i>Detail Kepulangan</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label required">Tanggal Pulang</label>
                                                            <input type="date" class="form-control"
                                                                name="tanggalPulang"
                                                                value="{{ $selectedOption == 'pulangSembuh' ? $tindakLanjutData->tanggal_pulang ?? date('Y-m-d') : date('Y-m-d') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label required">Jam Pulang</label>
                                                            <input type="time" class="form-control" name="jamPulang"
                                                                value="{{ $selectedOption == 'pulangSembuh' ? $tindakLanjutData->jam_pulang ?? date('H:i') : date('H:i') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label required">Alasan Pulang</label>
                                                            <select class="form-select" name="alasan_pulang">
                                                                <option value="">Pilih Alasan Pulang</option>
                                                                <option value="1"
                                                                    {{ $selectedOption == 'pulangSembuh' && $tindakLanjutData->alasan_pulang == '1' ? 'selected' : '' }}>
                                                                    Sembuh</option>
                                                                <option value="2"
                                                                    {{ $selectedOption == 'pulangSembuh' && $tindakLanjutData->alasan_pulang == '2' ? 'selected' : '' }}>
                                                                    Indikasi Medis</option>
                                                                <option value="3"
                                                                    {{ $selectedOption == 'pulangSembuh' && $tindakLanjutData->alasan_pulang == '3' ? 'selected' : '' }}>
                                                                    Permintaan Pasien</option>
                                                                <option value="4"
                                                                    {{ $selectedOption == 'pulangSembuh' && $tindakLanjutData->alasan_pulang == '4' ? 'selected' : '' }}>
                                                                    Pulang Paksa</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label required">Kondisi Pulang</label>
                                                            <select class="form-select" name="kondisi_pulang">
                                                                <option value="">Pilih Kondisi Pulang</option>
                                                                <option value="1"
                                                                    {{ $selectedOption == 'pulangSembuh' && $tindakLanjutData->kondisi_pulang == '1' ? 'selected' : '' }}>
                                                                    Mandiri</option>
                                                                <option value="2"
                                                                    {{ $selectedOption == 'pulangSembuh' && $tindakLanjutData->kondisi_pulang == '2' ? 'selected' : '' }}>
                                                                    Tidak Mandiri</option>
                                                                <option value="3"
                                                                    {{ $selectedOption == 'pulangSembuh' && $tindakLanjutData->kondisi_pulang == '3' ? 'selected' : '' }}>
                                                                    Dengan Bantuan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FORM BEROBAT JALAN --}}
                                    <div class="conditional-form" id="formberobatJalan"
                                        style="display: {{ $selectedOption == 'berobatJalan' ? 'block' : 'none' }};">
                                        <div class="">
                                            <div class="card-header">
                                                <h6 class="mb-0"><i class="ti-calendar me-2"></i>Detail Berobat Jalan
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label required">Tanggal Berobat</label>
                                                            <input type="date" class="form-control"
                                                                name="tanggal_rajal"
                                                                value="{{ $selectedOption == 'berobatJalan' ? $tindakLanjutData->tanggal_rajal ?? '' : '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label required">Poli Tujuan</label>
                                                            <select class="form-select" name="poli_unit_tujuan">
                                                                <option value="">Pilih Poli</option>
                                                                @foreach ($unitPoli as $poli)
                                                                    <option value="{{ $poli->kd_unit }}"
                                                                        {{ $selectedOption == 'berobatJalan' && $tindakLanjutData->poli_unit_tujuan == $poli->kd_unit ? 'selected' : '' }}>
                                                                        {{ $poli->nama_unit }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-0">
                                                    <label class="form-label">Catatan untuk Poli</label>
                                                    <textarea class="form-control" name="catatan_rajal" rows="3"
                                                        placeholder="Catatan khusus untuk poli tujuan...">{{ $selectedOption == 'berobatJalan' ? $tindakLanjutData->keterangan ?? '' : '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FORM MENOLAK RAWAT INAP --}}
                                    <div class="conditional-form" id="formMenolakRawatInap"
                                        style="display: {{ $selectedOption == 'menolakRawatInap' ? 'block' : 'none' }};">
                                        <div class="">
                                            <div class="card-header">
                                                <h6 class="mb-0"><i class="ti-close me-2"></i>Detail Penolakan Rawat
                                                    Inap</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label class="form-label required">Alasan Menolak</label>
                                                    <textarea class="form-control" name="alasanMenolak" rows="3"
                                                        placeholder="Jelaskan alasan pasien/keluarga menolak rawat inap...">{{ $selectedOption == 'menolakRawatInap' ? $tindakLanjutData->keterangan ?? '' : '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FORM MENINGGAL DUNIA --}}
                                    <div class="conditional-form" id="formmeninggalDunia"
                                        style="display: {{ $selectedOption == 'meninggalDunia' ? 'block' : 'none' }};">
                                        <div class="">
                                            <div class="card-header">
                                                <h6 class="mb-0"><i class="ti-heart-broken me-2"></i>Detail Kematian
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label required">Tanggal Meninggal</label>
                                                            <input type="date" class="form-control"
                                                                name="tanggalMeninggal"
                                                                value="{{ $selectedOption == 'meninggalDunia' ? $tindakLanjutData->tanggal_meninggal ?? date('Y-m-d') : date('Y-m-d') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label required">Jam Meninggal</label>
                                                            <input type="time" class="form-control"
                                                                name="jamMeninggal"
                                                                value="{{ $selectedOption == 'meninggalDunia' ? $tindakLanjutData->jam_meninggal ?? date('H:i') : date('H:i') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-label">Keterangan Kematian</label>
                                                    <textarea class="form-control" name="penyebab_kematian" rows="3"
                                                        placeholder="Jelaskan penyebab kematian berdasarkan kondisi klinis...">{{ $selectedOption == 'meninggalDunia' ? $tindakLanjutData->keterangan ?? '' : '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FORM DOA --}}
                                    <div class="conditional-form" id="formDOA"
                                        style="display: {{ $selectedOption == 'deathoffarrival' ? 'block' : 'none' }};">
                                        <div class="">
                                            <div class="card-header">
                                                <h6 class="mb-0"><i class="ti-pulse me-2"></i>Detail DOA (Death on
                                                    Arrival)</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label required">Tanggal Tiba</label>
                                                            <input type="date" class="form-control" name="tanggalDoa"
                                                                value="{{ $selectedOption == 'deathoffarrival' ? $tindakLanjutData->tanggal_meninggal ?? date('Y-m-d') : date('Y-m-d') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label required">Jam Tiba</label>
                                                            <input type="time" class="form-control" name="jamDoa"
                                                                value="{{ $selectedOption == 'deathoffarrival' ? $tindakLanjutData->jam_meninggal ?? date('H:i') : date('H:i') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-0">
                                                    <label class="form-label">Keterangan</label>
                                                    <textarea class="form-control" name="keterangan_doa" rows="3"
                                                        placeholder="Tindakan yang telah dilakukan (jika ada)...">{{ $selectedOption == 'deathoffarrival' ? $tindakLanjutData->keterangan ?? '' : '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="tindak_lanjut_data" id="tindakLanjutData"
                                        value="">
                                </div>

                                {{-- SUBMIT BUTTON --}}
                                <div class="section-separator" id="submit">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('asesmen.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                            class="btn btn-secondary">Batal</a>
                                        <button type="submit" class="btn btn-primary">Update Asesmen</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.modal-alatyangterpasang-new')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.modal-create-alergi')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.gcs-modal')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.modal-retriase-edit')


@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // =================== PEMERIKSAAN FISIK ===================
            initPemeriksaanFisik();

            // =================== RIWAYAT ===================
            initRiwayat();

            // =================== SKALA NYERI ===================
            initSkalaNyeri();

            // =================== PAIN SCALE IMAGES ===================
            initPainScaleImages();

            // =================== DIAGNOSIS ===================
            initDiagnosis();

            // =================== ALAT TERPASANG ===================
            initAlatTerpasang();

            // =================== TINDAK LANJUT ===================
            initTindakLanjut();

        });

        // =================== PEMERIKSAAN FISIK FUNCTIONS ===================
        function initPemeriksaanFisik() {
            // Event listener untuk tombol tambah keterangan
            document.querySelectorAll('.tambah-keterangan').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const keteranganDiv = document.getElementById(targetId);
                    const normalCheckbox = this.closest('.pemeriksaan-item')?.querySelector(
                        '.form-check-input');

                    if (keteranganDiv && normalCheckbox) {
                        toggleKeterangan(keteranganDiv, normalCheckbox);
                    }
                });
            });

            // Event listener untuk checkbox normal
            document.querySelectorAll('.pemeriksaan-item .form-check-input').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const keteranganDiv = this.closest('.pemeriksaan-item')?.querySelector('.keterangan');
                    if (keteranganDiv && this.checked) {
                        hideKeterangan(keteranganDiv);
                    }
                });
            });

            // DON'T call setDefaultPemeriksaanState() for edit form
            // The PHP template already sets the correct values from database
        }

        function toggleKeterangan(keteranganDiv, normalCheckbox) {
            if (keteranganDiv.style.display === 'none') {
                keteranganDiv.style.display = 'block';
                normalCheckbox.checked = false;
                keteranganDiv.querySelector('input')?.focus();
            } else {
                keteranganDiv.style.display = 'block';
            }
        }

        function hideKeterangan(keteranganDiv) {
            keteranganDiv.style.display = 'none';
            const input = keteranganDiv.querySelector('input');
            if (input) input.value = '';
        }

        // Only use this function for CREATE form, not EDIT form
        function setDefaultPemeriksaanState() {
            // This should only be called in create form
            if (!document.querySelector('input[name="_method"][value="PUT"]')) {
                document.querySelectorAll('.pemeriksaan-item .form-check-input').forEach(checkbox => {
                    checkbox.checked = true;
                    const keteranganDiv = checkbox.closest('.pemeriksaan-item')?.querySelector('.keterangan');
                    if (keteranganDiv) {
                        hideKeterangan(keteranganDiv);
                    }
                });
            }
        }

        // =================== RIWAYAT FUNCTIONS ===================
        function initRiwayat() {
            let riwayatArray = [];

            // Event listeners
            const btnTambahRiwayat = document.getElementById('btnTambahRiwayat');
            const btnTambahRiwayatModal = document.getElementById('btnTambahRiwayatModal');
            const riwayatModal = document.getElementById('riwayatModal');

            if (btnTambahRiwayat) {
                btnTambahRiwayat.addEventListener('click', resetRiwayatModal);
            }

            if (btnTambahRiwayatModal) {
                btnTambahRiwayatModal.addEventListener('click', function() {
                    handleTambahRiwayat(riwayatArray);
                });
            }

            if (riwayatModal) {
                riwayatModal.addEventListener('hidden.bs.modal', resetRiwayatModal);
            }
        }

        function resetRiwayatModal() {
            const namaPenyakit = document.getElementById('namaPenyakit');
            const namaObat = document.getElementById('namaObat');

            if (namaPenyakit) namaPenyakit.value = '';
            if (namaObat) namaObat.value = '';
        }

        function handleTambahRiwayat(riwayatArray) {
            const namaPenyakit = document.getElementById('namaPenyakit')?.value.trim();
            const namaObat = document.getElementById('namaObat')?.value.trim();
            const tbody = document.querySelector('#riwayatTable tbody');

            if (!namaPenyakit && !namaObat) {
                showAlert('Mohon isi setidaknya salah satu field (Penyakit atau Obat)');
                return;
            }

            const riwayatEntry = {
                penyakit: namaPenyakit || '-',
                obat: namaObat || '-'
            };

            riwayatArray.push(riwayatEntry);
            addRiwayatToTable(tbody, riwayatEntry, riwayatArray);
            updateRiwayatJson(riwayatArray);
            closeModal('riwayatModal');
        }

        function addRiwayatToTable(tbody, entry, riwayatArray) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${entry.penyakit}</td>
                <td>${entry.obat}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm hapus-riwayat">
                        <i class="ti-trash"></i> Hapus
                    </button>
                </td>
            `;

            tbody.appendChild(row);

            // Event listener untuk hapus
            row.querySelector('.hapus-riwayat')?.addEventListener('click', function() {
                removeRiwayat(row, entry, riwayatArray);
            });
        }

        function removeRiwayat(row, entry, riwayatArray) {
            const index = riwayatArray.findIndex(item =>
                item.penyakit === entry.penyakit && item.obat === entry.obat
            );

            if (index !== -1) {
                riwayatArray.splice(index, 1);
            }

            row.remove();
            updateRiwayatJson(riwayatArray);
        }

        function updateRiwayatJson(riwayatArray) {
            const riwayatJsonInput = document.getElementById('riwayatJson');
            if (riwayatJsonInput) {
                riwayatJsonInput.value = JSON.stringify(riwayatArray);
            }
        }

        // =================== SKALA NYERI FUNCTIONS ===================
        function initSkalaNyeri() {
            const inputSkalaNyeri = document.querySelector('input[name="skala_nyeri"]');
            const button = document.getElementById('skalaNyeriBtn');

            if (!inputSkalaNyeri || !button) return;

            // Set initial state
            updateNyeriButton(parseInt(inputSkalaNyeri.value) || 0, button);

            // Event listeners
            inputSkalaNyeri.addEventListener('input', function() {
                handleNyeriInput(this, button);
            });

            inputSkalaNyeri.addEventListener('change', function() {
                handleNyeriInput(this, button);
            });
        }

        function handleNyeriInput(input, button) {
            let nilai = parseInt(input.value) || 0;
            nilai = Math.min(Math.max(nilai, 0), 10);
            input.value = nilai;
            updateNyeriButton(nilai, button);
        }

        function updateNyeriButton(nilai, button) {
            const config = getNyeriConfig(nilai);

            button.className = `btn ${config.class}`;
            button.textContent = config.text;

            const nilaiInput = document.querySelector('input[name="skala_nyeri_nilai"]');
            if (nilaiInput) {
                nilaiInput.value = nilai;
            }
        }

        function getNyeriConfig(nilai) {
            switch (true) {
                case nilai === 0:
                    return {
                        class: 'btn-success', text: 'Tidak Nyeri'
                    };
                case nilai >= 1 && nilai <= 3:
                    return {
                        class: 'btn-success', text: 'Nyeri Ringan'
                    };
                case nilai >= 4 && nilai <= 5:
                    return {
                        class: 'btn-warning', text: 'Nyeri Sedang'
                    };
                case nilai >= 6 && nilai <= 7:
                    return {
                        class: 'btn-warning', text: 'Nyeri Berat'
                    };
                case nilai >= 8 && nilai <= 9:
                    return {
                        class: 'btn-danger', text: 'Nyeri Sangat Berat'
                    };
                case nilai >= 10:
                    return {
                        class: 'btn-danger', text: 'Nyeri Tak Tertahankan'
                    };
                default:
                    return {
                        class: 'btn-success', text: 'Tidak Nyeri'
                    };
            }
        }

        // =================== DIAGNOSIS FUNCTIONS ===================
        function initDiagnosis() {
            // Parse existing diagnosis data from PHP
            let diagnosisArray = [];

            // Get existing diagnosis data from the rendered HTML
            const existingItems = document.querySelectorAll('.diagnosis-item');
            existingItems.forEach(item => {
                const diagnosisText = item.querySelector('.diagnosis-content .fw-medium').textContent.trim();
                if (diagnosisText) {
                    diagnosisArray.push({
                        nama: diagnosisText
                    });
                }
            });

            let editIndex = -1;

            // Initialize sortable
            const diagnosisList = document.getElementById('diagnosisList');
            if (diagnosisList && typeof Sortable !== 'undefined') {
                new Sortable(diagnosisList, {
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    handle: '.drag-handle',
                    onEnd: function(evt) {
                        updateDiagnosisOrder(diagnosisArray);
                    }
                });
            }

            // Add event listeners for existing items
            addDiagnosisEventListeners();

            // Event listeners for modal
            const btnTambahDiagnosis = document.getElementById('btnTambahDiagnosis');
            const btnSimpanDiagnosis = document.getElementById('btnSimpanDiagnosis');
            const diagnosisModal = document.getElementById('diagnosisModal');

            if (btnTambahDiagnosis) {
                btnTambahDiagnosis.addEventListener('click', function() {
                    openDiagnosisModal('add', diagnosisArray);
                });
            }

            if (btnSimpanDiagnosis) {
                btnSimpanDiagnosis.addEventListener('click', function() {
                    saveDiagnosis(diagnosisArray, editIndex);
                });
            }

            if (diagnosisModal) {
                diagnosisModal.addEventListener('hidden.bs.modal', function() {
                    resetDiagnosisModal();
                    editIndex = -1;
                });
            }

            function addDiagnosisEventListeners() {
                document.querySelectorAll('.edit-diagnosis').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        openDiagnosisModal('edit', diagnosisArray, index);
                    });
                });

                document.querySelectorAll('.delete-diagnosis').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        deleteDiagnosis(diagnosisArray, index);
                    });
                });
            }

            // Functions (keep the existing ones but update renderDiagnosisList to call addDiagnosisEventListeners)
            function openDiagnosisModal(mode, diagnosisArray, index = -1) {
                const modal = new bootstrap.Modal(document.getElementById('diagnosisModal'));
                const modalTitle = document.getElementById('diagnosisModalTitle');
                const namaDiagnosis = document.getElementById('namaDiagnosis');

                if (mode === 'add') {
                    modalTitle.textContent = 'Tambah Diagnosis';
                    namaDiagnosis.value = '';
                    editIndex = -1;
                } else if (mode === 'edit' && index !== -1) {
                    modalTitle.textContent = 'Edit Diagnosis';
                    namaDiagnosis.value = diagnosisArray[index].nama;
                    editIndex = index;
                }

                modal.show();
                setTimeout(() => namaDiagnosis.focus(), 300);
            }

            function saveDiagnosis(diagnosisArray, editIndex) {
                const namaDiagnosis = document.getElementById('namaDiagnosis').value.trim();

                if (!namaDiagnosis) {
                    showAlert('Nama diagnosis harus diisi');
                    return;
                }

                const diagnosisData = {
                    nama: namaDiagnosis
                };

                if (editIndex === -1) {
                    diagnosisArray.push(diagnosisData);
                } else {
                    diagnosisArray[editIndex] = diagnosisData;
                }

                renderDiagnosisList(diagnosisArray);
                updateDiagnosisJson(diagnosisArray);
                closeModal('diagnosisModal');
                editIndex = -1;
            }

            function renderDiagnosisList(diagnosisArray) {
                const diagnosisList = document.getElementById('diagnosisList');
                const noDiagnosisMessage = document.getElementById('noDiagnosisMessage');

                if (diagnosisArray.length === 0) {
                    diagnosisList.innerHTML = '';
                    noDiagnosisMessage.style.display = 'block';
                    return;
                }

                noDiagnosisMessage.style.display = 'none';

                diagnosisList.innerHTML = diagnosisArray.map((diagnosis, index) => `
                    <div class="diagnosis-item" data-index="${index}">
                        <div class="d-flex align-items-start gap-3">
                            <div class="drag-handle">
                                <i class="ti-menu"></i>
                            </div>
                            <div class="diagnosis-number">
                                ${index + 1}
                            </div>
                            <div class="diagnosis-content flex-grow-1">
                                <div class="fw-medium text-dark">${diagnosis.nama}</div>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-primary edit-diagnosis"
                                        data-index="${index}" title="Edit">
                                    <i class="ti-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger delete-diagnosis"
                                        data-index="${index}" title="Hapus">
                                    <i class="ti-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('');

                // Re-add event listeners
                addDiagnosisEventListeners();
            }

            function deleteDiagnosis(diagnosisArray, index) {
                if (confirm('Apakah Anda yakin ingin menghapus diagnosis ini?')) {
                    diagnosisArray.splice(index, 1);
                    renderDiagnosisList(diagnosisArray);
                    updateDiagnosisJson(diagnosisArray);
                }
            }

            function updateDiagnosisOrder(diagnosisArray) {
                const items = document.querySelectorAll('.diagnosis-item');
                const newOrder = [];

                items.forEach(item => {
                    const index = parseInt(item.dataset.index);
                    newOrder.push(diagnosisArray[index]);
                });

                diagnosisArray.splice(0, diagnosisArray.length, ...newOrder);
                renderDiagnosisList(diagnosisArray);
                updateDiagnosisJson(diagnosisArray);
            }

            function updateDiagnosisJson(diagnosisArray) {
                const container = document.getElementById('diagnosisInputContainer');
                container.innerHTML = '';

                diagnosisArray.forEach((diagnosis, index) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'diagnosa_data[]';
                    input.value = diagnosis.nama;
                    container.appendChild(input);
                });
            }

            function resetDiagnosisModal() {
                const namaDiagnosis = document.getElementById('namaDiagnosis');
                if (namaDiagnosis) namaDiagnosis.value = '';
            }
        }


        // =================== ALAT TERPASANG FUNCTIONS ===================
        function initAlatTerpasang() {
            // Parse existing alat data from the hidden input
            let alatArray = [];
            const alatTerpasangData = document.getElementById('alatTerpasangData');
            if (alatTerpasangData && alatTerpasangData.value) {
                try {
                    const parsedData = JSON.parse(alatTerpasangData.value);
                    if (Array.isArray(parsedData)) {
                        alatArray = parsedData;
                    }
                } catch (e) {
                    console.log('Error parsing alat data:', e);
                    alatArray = [];
                }
            }

            let editAlatIndex = -1;

            // Add event listeners for existing items
            addAlatEventListeners();

            // Event listeners for modal
            const btnTambahAlat = document.getElementById('btnTambahAlat');
            const btnSimpanAlat = document.getElementById('btnSimpanAlat');
            const alatModal = document.getElementById('alatModal');
            const namaAlat = document.getElementById('namaAlat');
            const alatLainnyaGroup = document.getElementById('alatLainnyaGroup');

            if (btnTambahAlat) {
                btnTambahAlat.addEventListener('click', function() {
                    openAlatModal('add');
                });
            }

            if (btnSimpanAlat) {
                btnSimpanAlat.addEventListener('click', function() {
                    saveAlat();
                });
            }

            if (alatModal) {
                alatModal.addEventListener('hidden.bs.modal', function() {
                    resetAlatModal();
                    editAlatIndex = -1;
                });
            }

            if (namaAlat) {
                namaAlat.addEventListener('change', function() {
                    toggleAlatLainnya();
                });
            }

            function addAlatEventListeners() {
                document.querySelectorAll('.edit-alat').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        openAlatModal('edit', index);
                    });
                });

                document.querySelectorAll('.delete-alat').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        deleteAlat(index);
                    });
                });
            }

            // Functions
            function openAlatModal(mode, index = -1) {
                const modalLabel = document.getElementById('alatModalLabel');
                const namaAlatSelect = document.getElementById('namaAlat');
                const alatLainnyaInput = document.getElementById('alatLainnya');
                const lokasiAlatInput = document.getElementById('lokasiAlat');
                const keteranganAlatInput = document.getElementById('keteranganAlat');

                if (mode === 'add') {
                    modalLabel.textContent = 'Tambah Alat yang Terpasang';
                    resetAlatModal();
                    editAlatIndex = -1;
                } else if (mode === 'edit' && index !== -1) {
                    modalLabel.textContent = 'Edit Alat yang Terpasang';
                    const alat = alatArray[index];

                    namaAlatSelect.value = alat.nama || '';
                    if (alat.nama === 'Lainnya' && alat.nama_lainnya) {
                        alatLainnyaGroup.style.display = 'block';
                        alatLainnyaInput.value = alat.nama_lainnya;
                    }
                    lokasiAlatInput.value = alat.lokasi || '';
                    keteranganAlatInput.value = alat.keterangan || '';
                    editAlatIndex = index;
                }

                setTimeout(() => namaAlatSelect.focus(), 300);
            }

            function saveAlat() {
                const namaAlatSelect = document.getElementById('namaAlat');
                const alatLainnyaInput = document.getElementById('alatLainnya');
                const lokasiAlatInput = document.getElementById('lokasiAlat');
                const keteranganAlatInput = document.getElementById('keteranganAlat');

                const namaAlatValue = namaAlatSelect.value.trim();
                const lokasiValue = lokasiAlatInput.value.trim();
                const keteranganValue = keteranganAlatInput.value.trim();

                if (!namaAlatValue) {
                    showAlert('Nama alat harus dipilih');
                    return;
                }

                let namaAlatFinal = namaAlatValue;
                let namaLainnya = '';

                if (namaAlatValue === 'Lainnya') {
                    const alatLainnyaValue = alatLainnyaInput.value.trim();
                    if (!alatLainnyaValue) {
                        showAlert('Nama alat lainnya harus diisi');
                        return;
                    }
                    namaAlatFinal = alatLainnyaValue;
                    namaLainnya = alatLainnyaValue;
                }

                const alatData = {
                    nama: namaAlatValue === 'Lainnya' ? 'Lainnya' : namaAlatValue,
                    nama_lainnya: namaLainnya,
                    nama_display: namaAlatFinal,
                    lokasi: lokasiValue,
                    keterangan: keteranganValue
                };

                if (editAlatIndex === -1) {
                    // Add new
                    alatArray.push(alatData);
                } else {
                    // Edit existing
                    alatArray[editAlatIndex] = alatData;
                }

                renderAlatTable();
                updateAlatJson();
                closeModal('alatModal');
                editAlatIndex = -1;
            }

            function renderAlatTable() {
                const tbody = document.querySelector('#alatTerpasangTable tbody');
                const noAlatRow = document.getElementById('no-alat-row');

                if (alatArray.length === 0) {
                    if (noAlatRow) {
                        noAlatRow.style.display = 'table-row';
                    }
                    // Remove all rows except the no-data row
                    const rows = tbody.querySelectorAll('tr:not(#no-alat-row)');
                    rows.forEach(row => row.remove());
                    return;
                }

                if (noAlatRow) {
                    noAlatRow.style.display = 'none';
                }

                // Clear existing rows except no-data row
                const existingRows = tbody.querySelectorAll('tr:not(#no-alat-row)');
                existingRows.forEach(row => row.remove());

                // Add new rows
                alatArray.forEach((alat, index) => {
                    const row = document.createElement('tr');
                    row.className = 'alat-item';
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${alat.nama_display || alat.nama || '-'}</td>
                        <td>${alat.lokasi || '-'}</td>
                        <td>${alat.keterangan || '-'}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-primary edit-alat"
                                        data-index="${index}" title="Edit">
                                    <i class="ti-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger delete-alat"
                                        data-index="${index}" title="Hapus">
                                    <i class="ti-trash"></i>
                                </button>
                            </div>
                        </td>
                    `;

                    tbody.appendChild(row);
                });

                // Re-add event listeners
                addAlatEventListeners();
            }

            function deleteAlat(index) {
                if (confirm('Apakah Anda yakin ingin menghapus alat ini?')) {
                    alatArray.splice(index, 1);
                    renderAlatTable();
                    updateAlatJson();
                }
            }

            function updateAlatJson() {
                const alatDataInput = document.getElementById('alatTerpasangData');
                if (alatDataInput) {
                    alatDataInput.value = JSON.stringify(alatArray);
                }
            }

            function resetAlatModal() {
                const namaAlat = document.getElementById('namaAlat');
                const alatLainnya = document.getElementById('alatLainnya');
                const lokasiAlat = document.getElementById('lokasiAlat');
                const keteranganAlat = document.getElementById('keteranganAlat');

                if (namaAlat) namaAlat.value = '';
                if (alatLainnya) alatLainnya.value = '';
                if (lokasiAlat) lokasiAlat.value = '';
                if (keteranganAlat) keteranganAlat.value = '';

                const alatLainnyaGroup = document.getElementById('alatLainnyaGroup');
                if (alatLainnyaGroup) {
                    alatLainnyaGroup.style.display = 'none';
                }
            }

            function toggleAlatLainnya() {
                const namaAlatValue = document.getElementById('namaAlat').value;
                const alatLainnyaGroup = document.getElementById('alatLainnyaGroup');

                if (namaAlatValue === 'Lainnya') {
                    alatLainnyaGroup.style.display = 'block';
                    document.getElementById('alatLainnya').focus();
                } else {
                    alatLainnyaGroup.style.display = 'none';
                    document.getElementById('alatLainnya').value = '';
                }
            }

            // Expose functions globally if needed by other scripts
            window.openAlatModal = openAlatModal;
            window.saveAlat = saveAlat;
            window.deleteAlat = deleteAlat;
        }


        // =================== IMT FUNCTIONS ===================
        function hitungIMT() {
            const tbInput = document.getElementById('tbInput');
            const bbInput = document.getElementById('bbInput');
            const imtInput = document.getElementById('imtInput');
            const imtKategori = document.getElementById('imtKategori');

            const tb = parseFloat(tbInput.value);
            const bb = parseFloat(bbInput.value);

            if (tb && bb && tb > 0) {
                // Konversi TB dari cm ke meter
                const tbMeter = tb / 100;

                // Hitung IMT
                const imt = bb / (tbMeter * tbMeter);

                // Set nilai IMT dengan 2 decimal places
                imtInput.value = imt.toFixed(2);

                // Tentukan kategori IMT
                let kategori = '';
                let kategoriClass = '';

                if (imt < 18.5) {
                    kategori = 'Underweight';
                    kategoriClass = 'bg-info text-white';
                } else if (imt >= 18.5 && imt < 25) {
                    kategori = 'Normal';
                    kategoriClass = 'bg-success text-white';
                } else if (imt >= 25 && imt < 30) {
                    kategori = 'Overweight';
                    kategoriClass = 'bg-warning text-dark';
                } else {
                    kategori = 'Obesitas';
                    kategoriClass = 'bg-danger text-white';
                }

                // Update kategori IMT
                imtKategori.textContent = kategori;
                imtKategori.className = `input-group-text ${kategoriClass}`;
            } else {
                // Reset jika input tidak valid
                imtInput.value = '';
                imtKategori.textContent = 'Normal';
                imtKategori.className = 'input-group-text';
            }
        }

        // =================== TINDAK LANJUT FUNCTIONS ===================

        function initTindakLanjut() {
            const radioOptions = document.querySelectorAll('.radio-option');
            const radioInputs = document.querySelectorAll('input[name="tindakLanjut"]');

            // Check pre-selected option pada page load (untuk edit mode)
            const preSelectedRadio = document.querySelector('input[name="tindakLanjut"]:checked');
            if (preSelectedRadio) {
                const targetForm = preSelectedRadio.closest('.radio-option')?.dataset.target;
                if (targetForm) {
                    showConditionalForm(targetForm);
                    updateRadioOptionStates();
                    // Update data setelah form ditampilkan
                    setTimeout(updateTindakLanjutData, 100);
                }
            }

            // Event listener untuk radio options (div click)
            radioOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const radioInput = this.querySelector('input[type="radio"]');
                    if (radioInput && !radioInput.disabled) {
                        radioInputs.forEach(r => r.checked = false);
                        radioInput.checked = true;

                        const targetForm = this.dataset.target;
                        handleTindakLanjutChange(radioInput.value, targetForm);
                    }
                });
            });

            // Event listener untuk radio inputs
            radioInputs.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        const targetForm = this.closest('.radio-option')?.dataset.target;
                        handleTindakLanjutChange(this.value, targetForm);
                    }
                });
            });

            // Event listeners untuk form changes
            document.addEventListener('input', function(e) {
                if (e.target.closest('.conditional-form')) {
                    setTimeout(updateTindakLanjutData, 100);
                }
            });

            document.addEventListener('change', function(e) {
                if (e.target.closest('.conditional-form')) {
                    setTimeout(updateTindakLanjutData, 100);
                }
            });

            function handleTindakLanjutChange(value, targetForm) {
                updateRadioOptionStates();
                hideAllConditionalForms();

                if (targetForm) {
                    showConditionalForm(targetForm);
                }

                // Hanya set default values jika bukan edit mode atau tidak ada data sebelumnya
                const isEditMode = document.querySelector('input[name="_method"][value="PUT"]');
                if (!isEditMode || !preSelectedRadio) {
                    setDefaultValues(value);
                }

                setTimeout(updateTindakLanjutData, 100);
            }

            function updateRadioOptionStates() {
                radioOptions.forEach(option => {
                    const radioInput = option.querySelector('input[type="radio"]');

                    if (radioInput && radioInput.checked) {
                        option.classList.add('selected');
                        option.style.backgroundColor = '#e3f2fd';
                        option.style.borderColor = '#2196f3';
                    } else {
                        option.classList.remove('selected');
                        option.style.backgroundColor = '';
                        option.style.borderColor = '';
                    }
                });
            }

            function hideAllConditionalForms() {
                document.querySelectorAll('.conditional-form').forEach(form => {
                    form.style.display = 'none';
                });
            }

            function showConditionalForm(formId) {
                const form = document.getElementById(formId);
                if (form) {
                    form.style.display = 'block';
                }
            }

            function setDefaultValues(tindakLanjut) {
                const currentDate = new Date().toISOString().split('T')[0];
                const currentTime = new Date().toTimeString().slice(0, 5);

                switch (tindakLanjut) {
                    case 'rawatInap':
                        const tanggalRawatInput = document.querySelector('input[name="tanggalRawatInap"]');
                        const jamRawatInput = document.querySelector('input[name="jamRawatInap"]');
                        if (tanggalRawatInput && !tanggalRawatInput.value) {
                            tanggalRawatInput.value = currentDate;
                        }
                        if (jamRawatInput && !jamRawatInput.value) {
                            jamRawatInput.value = currentTime;
                        }
                        break;

                    case 'pulangSembuh':
                        const tanggalPulangInput = document.querySelector('input[name="tanggalPulang"]');
                        const jamPulangInput = document.querySelector('input[name="jamPulang"]');
                        if (tanggalPulangInput && !tanggalPulangInput.value) {
                            tanggalPulangInput.value = currentDate;
                        }
                        if (jamPulangInput && !jamPulangInput.value) {
                            jamPulangInput.value = currentTime;
                        }
                        break;

                    case 'meninggalDunia':
                        const tanggalMeninggalInput = document.querySelector('input[name="tanggalMeninggal"]');
                        const jamMeninggalInput = document.querySelector('input[name="jamMeninggal"]');
                        if (tanggalMeninggalInput && !tanggalMeninggalInput.value) {
                            tanggalMeninggalInput.value = currentDate;
                        }
                        if (jamMeninggalInput && !jamMeninggalInput.value) {
                            jamMeninggalInput.value = currentTime;
                        }
                        break;

                    case 'deathoffarrival':
                        const tanggalDoaInput = document.querySelector('input[name="tanggalDoa"]');
                        const jamDoaInput = document.querySelector('input[name="jamDoa"]');
                        if (tanggalDoaInput && !tanggalDoaInput.value) {
                            tanggalDoaInput.value = currentDate;
                        }
                        if (jamDoaInput && !jamDoaInput.value) {
                            jamDoaInput.value = currentTime;
                        }
                        break;
                }
            }
        }

        function updateTindakLanjutData() {
            const checkedRadio = document.querySelector('input[name="tindakLanjut"]:checked');

            if (!checkedRadio) {
                document.getElementById('tindakLanjutData').value = '';
                return;
            }

            const selectedOption = checkedRadio.value;
            const tindakLanjutData = {
                option: selectedOption
            };

            // Kumpulkan data berdasarkan option yang dipilih
            switch (selectedOption) {
                case 'rawatInap':
                    tindakLanjutData.tanggalRawatInap = document.querySelector('input[name="tanggalRawatInap"]')?.value ||
                        '';
                    tindakLanjutData.jamRawatInap = document.querySelector('input[name="jamRawatInap"]')?.value || '';
                    tindakLanjutData.keluhanUtama_ranap = document.querySelector('textarea[name="keluhanUtama_ranap"]')
                        ?.value || '';
                    tindakLanjutData.hasilPemeriksaan_ranap = document.querySelector(
                        'textarea[name="hasilPemeriksaan_ranap"]')?.value || '';
                    tindakLanjutData.jalannyaPenyakit_ranap = document.querySelector(
                        'textarea[name="jalannyaPenyakit_ranap"]')?.value || '';
                    tindakLanjutData.diagnosis_ranap = document.querySelector('textarea[name="diagnosis_ranap"]')?.value ||
                        '';
                    tindakLanjutData.tindakan_ranap = document.querySelector('textarea[name="tindakan_ranap"]')?.value ||
                        '';
                    tindakLanjutData.anjuran_ranap = document.querySelector('textarea[name="anjuran_ranap"]')?.value || '';
                    break;
                case 'rujukKeluar':
                    tindakLanjutData.tujuan_rujuk = document.querySelector('input[name="tujuan_rujuk"]')?.value || '';
                    tindakLanjutData.alasan_rujuk = document.querySelector('select[name="alasan_rujuk"]')?.value || '';
                    tindakLanjutData.transportasi_rujuk = document.querySelector('select[name="transportasi_rujuk"]')
                        ?.value || '';
                    tindakLanjutData.keterangan_rujuk = document.querySelector('textarea[name="keterangan_rujuk"]')
                        ?.value || '';
                    break;
                case 'pulangSembuh':
                    tindakLanjutData.tanggalPulang = document.querySelector('input[name="tanggalPulang"]')?.value || '';
                    tindakLanjutData.jamPulang = document.querySelector('input[name="jamPulang"]')?.value || '';
                    tindakLanjutData.alasan_pulang = document.querySelector('select[name="alasan_pulang"]')?.value || '';
                    tindakLanjutData.kondisi_pulang = document.querySelector('select[name="kondisi_pulang"]')?.value || '';
                    break;
                case 'berobatJalan':
                    tindakLanjutData.tanggal_rajal = document.querySelector('input[name="tanggal_rajal"]')?.value || '';
                    tindakLanjutData.poli_unit_tujuan = document.querySelector('select[name="poli_unit_tujuan"]')?.value ||
                        '';
                    tindakLanjutData.catatan_rajal = document.querySelector('textarea[name="catatan_rajal"]')?.value || '';
                    break;
                case 'menolakRawatInap':
                    tindakLanjutData.alasanMenolak = document.querySelector('textarea[name="alasanMenolak"]')?.value || '';
                    break;
                case 'meninggalDunia':
                    tindakLanjutData.tanggalMeninggal = document.querySelector('input[name="tanggalMeninggal"]')?.value ||
                        '';
                    tindakLanjutData.jamMeninggal = document.querySelector('input[name="jamMeninggal"]')?.value || '';
                    tindakLanjutData.penyebab_kematian = document.querySelector('textarea[name="penyebab_kematian"]')
                        ?.value || '';
                    break;
                case 'deathoffarrival':
                    tindakLanjutData.tanggalDoa = document.querySelector('input[name="tanggalDoa"]')?.value || '';
                    tindakLanjutData.jamDoa = document.querySelector('input[name="jamDoa"]')?.value || '';
                    tindakLanjutData.keterangan_doa = document.querySelector('textarea[name="keterangan_doa"]')?.value ||
                        '';
                    break;
            }

            // Update hidden input
            document.getElementById('tindakLanjutData').value = JSON.stringify(tindakLanjutData);
        }


        // =================== PAIN SCALE IMAGE FUNCTIONS ===================
        function initPainScaleImages() {
            const buttons = document.querySelectorAll('[data-scale]');
            const numericScale = document.getElementById('numericScale');
            const wongBakerScale = document.getElementById('wongBakerScale');

            if (buttons.length === 0) return;

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    handleScaleButtonClick(this, buttons, numericScale, wongBakerScale);
                });
            });

            // Show first scale by default
            if (buttons[0]) {
                buttons[0].click();
            }
        }

        function handleScaleButtonClick(clickedButton, allButtons, numericScale, wongBakerScale) {
            // Update button states
            allButtons.forEach(btn => {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-primary');
            });

            clickedButton.classList.remove('btn-outline-primary');
            clickedButton.classList.add('btn-primary');

            // Show appropriate scale
            showSelectedScale(clickedButton.dataset.scale, numericScale, wongBakerScale);
        }

        function showSelectedScale(scale, numericScale, wongBakerScale) {
            if (!numericScale || !wongBakerScale) return;

            numericScale.style.display = 'none';
            wongBakerScale.style.display = 'none';

            if (scale === 'numeric') {
                numericScale.style.display = 'block';
            } else if (scale === 'wong-baker') {
                wongBakerScale.style.display = 'block';
            }
        }

        // =================== UTILITY FUNCTIONS ===================
        function showAlert(message, type = 'warning') {
            alert(message); // Simple alert for now, can be replaced with custom modal
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal && window.bootstrap) {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            }
        }

        // =================== FORM VALIDATION ===================
        function validateForm() {
            const requiredFields = document.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            return isValid;
        }

        // Add form validation on submit
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!validateForm()) {
                        e.preventDefault();
                        showAlert('Mohon lengkapi semua field yang wajib diisi');
                    }
                });
            }

        });
    </script>
@endpush
