@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <!-- Tambahkan ini ke tag <style> atau file CSS -->
    <style>
        /* Sticky untuk side kiri khusus di dalam modal #detailPasienModal */
        #detailPasienModal .patient-card {
            position: sticky;
            top: 0;
            max-height: 100vh;
            overflow-y: auto;
            padding-right: 10px;
        }

        /* Scroll untuk konten di sebelah kanan hanya dalam modal */
        #detailPasienModal .col-md-9 {
            max-height: 100vh;
            overflow-y: auto;
        }

        /* Garis pemisah tipis antar section */
        .form-line {
            border-bottom: 1px solid #e0e0e0;
            /* Ubah warna dan ketebalan sesuai kebutuhan */
            margin-bottom: 20px;
            /* Tambahkan margin bawah untuk spasi antar section */
            padding-bottom: 15px;
        }

        .pemeriksaan-fisik {
            margin-bottom: 20px;
        }

        .pemeriksaan-item {
            margin-bottom: 15px;
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        .pemeriksaan-item:last-child {
            border-bottom: none;
        }

        .tambah-keterangan {
            padding: 0px 5px;
        }

        .keterangan {
            margin-top: 10px;
        }

        .triase-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .triase-doa {
            background-color: #343a40;
        }

        .triase-resusitasi {
            background-color: #dc3545;
        }

        .triase-emergency {
            background-color: #dc3545;
        }

        .triase-urgent {
            background-color: #ffc107;
            color: black;
        }

        .triase-false-emergency {
            background-color: #28a745;
        }

        #reTriaseTable {
            table-layout: fixed;
            width: 100%;
        }

        #reTriaseTable td {
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        #reTriaseTable td:nth-child(1) {
            width: 15%;
        }

        /* Tanggal dan Jam */
        #reTriaseTable td:nth-child(2) {
            width: 20%;
        }

        /* Keluhan */
        #reTriaseTable td:nth-child(3) {
            width: 45%;
        }

        /* Vital Sign */
        #reTriaseTable td:nth-child(4) {
            width: 20%;
        }

        /* Re-Triase/EWS */

        #reTriaseTable ul {
            padding-left: 20px;
            margin: 0;
        }

        #reTriaseTable li {
            margin-bottom: 5px;
        }

        .triase-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="asesmen-tab" data-bs-toggle="tab"
                                    data-bs-target="#asesmen" type="button" role="tab" aria-controls="asesmen"
                                    aria-selected="true">Asesmen Awal
                                    Medis</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="skrining-tab" data-bs-toggle="tab" data-bs-target="#skrining"
                                    type="button" role="tab" aria-controls="skrining" aria-selected="false">Skrining
                                    Khusus</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="asesmen" role="tabpanel"
                                aria-labelledby="asesmen-tab">
                                {{-- TAB 1. buatlah list disini --}}
                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.asesmenawal')
                            </div>
                            <div class="tab-pane fade" id="skrining" role="tabpanel" aria-labelledby="skrining-tab">
                                {{-- TAB 2. buatlah list disini --}}
                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.skriningkhusus')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

