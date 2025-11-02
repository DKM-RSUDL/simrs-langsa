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

        /* Tambahkan ini ke file CSS Anda */
        .loading-spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #22a6b3;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            margin-left: 10px;
        }

        button.loading {
            position: relative;
            pointer-events: none;
        }

        button.loading .loading-spinner {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
        }

        button.loading .loading-text {
            opacity: 0.6;
        }

        /* untuk button dropdownd di awal asesmen */
        .custom__dropdown {
            position: relative;
            display: inline-block;
            width: 250px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        .custom__dropdown__btn {
            background: #2563eb;
            color: white;
            padding: 12px 16px;
            border: none;
            border-radius: 8px;
            width: 100%;
            text-align: left;
            position: relative;
            font-size: 15px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.1);
        }

        .custom__dropdown__btn:hover {
            background: #1d4ed8;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
        }

        .custom__dropdown__btn::after {
            content: '';
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 6px solid rgba(255, 255, 255, 0.9);
            transition: transform 0.2s ease;
        }

        .custom__dropdown__btn.active::after {
            transform: translateY(-50%) rotate(180deg);
        }

        .custom__dropdown__menu {
            display: none;
            position: absolute;
            background: white;
            width: 100%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 8px;
            padding: 8px 0;
            z-index: 1000;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }

        .custom__dropdown__menu.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .custom__dropdown__item {
            display: block;
            padding: 10px 16px;
            text-decoration: none;
            color: #374151;
            font-size: 14px;
            transition: all 0.15s ease;
            position: relative;
        }

        .custom__dropdown__item:hover {
            background: #f3f4f6;
            color: #2563eb;
            padding-left: 20px;
        }

        /* List styling */
        .custom__dropdown__menu li {
            list-style: none;
        }

        /* Remove default padding from ul */
        .custom__dropdown__menu {
            padding: 8px 0;
            margin: 0;
        }

        #asesmenList .list-group-item:nth-child(even) {
            background-color: #edf7ff;
        }

        /* Background putih untuk item ganjil */
        #asesmenList .list-group-item:nth-child(odd) {
            background-color: #ffffff;
        }

        /* Efek hover tetap sama untuk konsistensi */
        #asesmenList .list-group-item:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .list-group-item {
            margin-bottom: 0.2rem;
            border-radius: 0.5rem !important;
            padding: 0.5rem;
            border: 1px solid #dee2e6;
            background: white;
            transition: all 0.2s;
        }

        .list-group-item:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .gap-2 {
            gap: 0.5rem !important;
        }

        .gap-3 {
            gap: 1rem !important;
        }

        .gap-4 {
            gap: 1.5rem !important;
        }

        .btn-sm {
            padding: 0.4rem 1rem;
            font-size: 0.875rem;
        }

        .btn i {
            font-size: 0.875rem;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-hemodialisa')
        </div>

        <div class="col-md-9">
            @include('components.navigation-hemodialisa')
            <x-content-card>
                @include('components.page-header', [
                    'title' => 'Daftar Asesmen',
                    'description' => 'Daftar asesmen hemodialisa.',
                ])
                {{-- TAB 1. buatlah list disini --}}
                @include('unit-pelayanan.hemodialisa.pelayanan.asesmen.asesmen-awal')
            </x-content-card>
        </div>
    </div>
@endsection
