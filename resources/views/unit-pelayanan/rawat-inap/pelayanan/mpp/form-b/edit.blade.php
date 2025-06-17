@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .card-header {
                font-weight: bold;
            }

            .form-label {
                font-weight: 600;
                margin-bottom: 0.3rem;
            }

            .required::after {
                content: '*';
                color: red;
                margin-left: 0.2rem;
            }

            .invalid-feedback {
                display: none;
            }

            .is-invalid~.invalid-feedback {
                display: block;
            }

            .form-section {
                max-width: 100%;
            }

            .section-title {
                color: #2c3e50;
                font-weight: 700;
                margin-bottom: 1rem;
                border-bottom: 2px solid #e9ecef;
                padding-bottom: 0.5rem;
            }

            .mpp-table {
                border-collapse: collapse;
                width: 100%;
                border: 1px solid #dee2e6;
            }

            .mpp-table th,
            .mpp-table td {
                border: 1px solid #dee2e6;
                padding: 6px;
                vertical-align: top;
            }

            .mpp-table th {
                background-color: #f8f9fa;
                font-weight: 700;
                text-align: center;
            }

            .datetime-column {
                width: 150px;
                text-align: center;
            }

            .criteria-column {
                width: 75%;
            }

            .datetime-inputs {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .datetime-inputs input {
                font-size: 0.85rem;
                padding: 0.375rem 0.5rem;
            }

            .form-control-textarea {
                min-height: 100px;
                resize: vertical;
                width: 100%;
                border: 1px solid #ced4da;
                border-radius: 0.375rem;
                padding: 0.5rem;
            }

            .section-header {
                background-color: #ffffff;
                font-weight: bold;
                text-align: center;
            }

            .rencana-row {
                background-color: #fff9f080;
            }

            .monitoring-row {
                background-color: #f0fff473;
            }

            .koordinasi-row {
                background-color: #f0f8ff7e;
            }

            .advokasi-row {
                background-color: #fff0f57c;
            }

            .hasil-row {
                background-color: #f8f9fa68;
            }

            .terminasi-row {
                background-color: #fdf2e983;
            }

            .criteria-item {
                display: flex;
                align-items: flex-start;
                margin-bottom: 8px;
                padding: 4px 0;
            }

            .criteria-item:last-child {
                margin-bottom: 0;
            }

            .criteria-checkbox {
                margin-right: 8px;
                margin-top: 2px;
                flex-shrink: 0;
                cursor: pointer;
            }

            .criteria-label {
                flex: 1;
                font-size: 0.9rem;
                line-height: 1.4;
                color: #495057;
                cursor: pointer;
            }

            .dokter-tambahan-item {
                position: relative;
            }

            .dokter-tambahan-item .input-group {
                display: flex;
                align-items: stretch;
            }

            .dokter-tambahan-item .form-select {
                flex: 1;
            }

            .dokter-tambahan-item .btn {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                z-index: 1;
            }

            .petugas-terkait-item {
                position: relative;
            }

            .petugas-terkait-item .input-group {
                display: flex;
                align-items: stretch;
            }

            .petugas-terkait-item .form-select {
                flex: 1;
            }

            .petugas-terkait-item .btn {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                z-index: 1;
            }

            .select2-dokter-tambahan + .select2-container {
                width: calc(100% - 42px) !important;
            }

            .select2-petugas-terkait + .select2-container {
                width: calc(100% - 42px) !important;
            }

            .input-group .select2-container {
                flex: 1;
            }

            .input-group .select2-container .select2-selection {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
                height: calc(2.25rem + 2px);
                border-right: 0;
            }

            .input-group .btn {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">FORM B - CATATAN IMPLEMENTASI MPP (EDIT)</h5>
            </div>

            <hr>

            <div class="form-section">
                <form
                    action="{{ route('rawat-inap.mpp.form-b.update', [
                        'kd_unit' => $kd_unit,
                        'kd_pasien' => $kd_pasien,
                        'tgl_masuk' => $tgl_masuk,
                        'urut_masuk' => $urut_masuk,
                        'id' => $id,
                    ]) }}"
                    method="post" id="mppImplementationForm">
                    @csrf
                    @method('PUT')

                    <!-- Section Dokter -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="section-title mb-0">Informasi Dokter dan Petugas</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">DPJP Utama</label>
                                        <select name="dpjp_utama" class="form-select select2" style="width: 100%">
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $dok)
                                                <option value="{{ $dok->kd_dokter }}" 
                                                    {{ $mppData->dpjp_utama == $dok->kd_dokter ? 'selected' : '' }}>
                                                    {{ $dok->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Dokter Tambahan</label>
                                        <div id="dokter-tambahan-container">
                                            @if($mppData->dokter_tambahan)
                                                @php
                                                    $dokterTambahanArray = json_decode($mppData->dokter_tambahan, true);
                                                    if (!is_array($dokterTambahanArray)) {
                                                        // Handle old format
                                                        $dokterTambahanArray = [$mppData->dokter_tambahan];
                                                    }
                                                @endphp
                                                @foreach($dokterTambahanArray as $index => $dokterTambahan)
                                                    <div class="dokter-tambahan-item mb-2" data-index="{{ $index }}">
                                                        <div class="input-group">
                                                            <select name="dokter_tambahan[]" class="form-select select2-dokter-tambahan">
                                                                <option value="">--Pilih--</option>
                                                                @foreach ($dokter as $dok)
                                                                    <option value="{{ $dok->kd_dokter }}" 
                                                                        {{ $dokterTambahan == $dok->kd_dokter ? 'selected' : '' }}>
                                                                        {{ $dok->nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <button type="button" class="btn btn-outline-danger remove-dokter-tambahan" 
                                                                    {{ $index == 0 ? 'style=display:none;' : '' }}>
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="dokter-tambahan-item mb-2" data-index="0">
                                                    <div class="input-group">
                                                        <select name="dokter_tambahan[]" class="form-select select2-dokter-tambahan">
                                                            <option value="">--Pilih--</option>
                                                            @foreach ($dokter as $dok)
                                                                <option value="{{ $dok->kd_dokter }}">{{ $dok->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" class="btn btn-outline-danger remove-dokter-tambahan" style="display: none;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-dokter-tambahan">
                                            <i class="bi bi-plus"></i> Tambah Dokter
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Petugas Terkait</label>
                                        <div id="petugas-terkait-container">
                                            @if($mppData->petugas_terkait)
                                                @php
                                                    $petugasTerkaitArray = json_decode($mppData->petugas_terkait, true);
                                                    if (!is_array($petugasTerkaitArray)) {
                                                        // Handle old format
                                                        $petugasTerkaitArray = [$mppData->petugas_terkait];
                                                    }
                                                @endphp
                                                @foreach($petugasTerkaitArray as $index => $petugasTerkait)
                                                    <div class="petugas-terkait-item mb-2" data-index="{{ $index }}">
                                                        <div class="input-group">
                                                            <select name="petugas_terkait[]" class="form-select select2-petugas-terkait">
                                                                <option value="">--Pilih--</option>
                                                                @foreach ($perawat as $prwt)
                                                                    <option value="{{ $prwt->kd_karyawan }}" 
                                                                        {{ $petugasTerkait == $prwt->kd_karyawan ? 'selected' : '' }}>
                                                                        {{ "$prwt->gelar_depan $prwt->nama $prwt->gelar_belakang" }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <button type="button" class="btn btn-outline-danger remove-petugas-terkait" 
                                                                    {{ $index == 0 ? 'style=display:none;' : '' }}>
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="petugas-terkait-item mb-2" data-index="0">
                                                    <div class="input-group">
                                                        <select name="petugas_terkait[]" class="form-select select2-petugas-terkait">
                                                            <option value="">--Pilih--</option>
                                                            @foreach ($perawat as $prwt)
                                                                <option value="{{ $prwt->kd_karyawan }}">
                                                                    {{ "$prwt->gelar_depan $prwt->nama $prwt->gelar_belakang" }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" class="btn btn-outline-danger remove-petugas-terkait" style="display: none;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-outline-success btn-sm mt-2" id="add-petugas-terkait">
                                            <i class="bi bi-plus"></i> Tambah Petugas
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Implementation Table -->
                    <div class="card mb-4">
                        <div class="card-body p-0">
                            <table class="mpp-table">
                                <thead>
                                    <tr>
                                        <th class="datetime-column">TANGGAL DAN JAM</th>
                                        <th class="criteria-column">CATATAN</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- 1. Rencana Pelayanan Pasien -->
                                    <tr class="rencana-row">
                                        <td class="datetime-column">
                                            <div class="datetime-inputs">
                                                <input type="text" name="rencana_date"
                                                    class="form-control form-control-sm rencana-date date"
                                                    value="{{ $mppData->rencana_date }}" placeholder="yyyy/mm/dd" readonly>
                                                <input type="time" name="rencana_time"
                                                    class="form-control form-control-sm rencana-time"
                                                    value="{{ $mppData->rencana_time ? \Carbon\Carbon::parse($mppData->rencana_time)->format('H:i') : '' }}">
                                            </div>
                                        </td>
                                        <td class="criteria-column">
                                            <strong>1. Rencana Pelayanan Pasien</strong><br><br>
                                            <textarea name="rencana_pelayanan" class="form-control-textarea" placeholder="Tuliskan rencana pelayanan pasien...">{{ $mppData->rencana_pelayanan }}</textarea>
                                        </td>
                                    </tr>

                                    <!-- 2. Monitoring Pelayanan/Asuhan Pasien -->
                                    <tr class="monitoring-row">
                                        <td class="datetime-column">
                                            <div class="datetime-inputs">
                                                <input type="text" name="monitoring_date"
                                                    class="form-control form-control-sm monitoring-date date"
                                                    value="{{ $mppData->monitoring_date }}" placeholder="yyyy/mm/dd"
                                                    readonly>
                                                <input type="time" name="monitoring_time"
                                                    class="form-control form-control-sm monitoring-time"
                                                    value="{{ $mppData->monitoring_time ? \Carbon\Carbon::parse($mppData->monitoring_time)->format('H:i') : '' }}">
                                            </div>
                                        </td>
                                        <td class="criteria-column">
                                            <strong>2. Monitoring Pelayanan/Asuhan Pasien Seluruh PPA</strong><br>
                                            <small class="text-muted">(Perkembangan, Kolaborasi, Verifikasi respon terhadap
                                                intervensi yang diberikan, revisi rencana asuhan termasuk preferensi
                                                perubahan, transisi pelayanan dan kendala pelayanan)</small><br><br>
                                            <textarea name="monitoring_pelayanan" class="form-control-textarea"
                                                placeholder="Tuliskan hasil monitoring pelayanan/asuhan pasien...">{{ $mppData->monitoring_pelayanan }}</textarea>
                                        </td>
                                    </tr>

                                    <!-- 3. Koordinasi Komunikasi dan Kolaborasi -->
                                    <tr class="koordinasi-row">
                                        <td class="datetime-column">
                                            <div class="datetime-inputs">
                                                <input type="text" name="koordinasi_date"
                                                    class="form-control form-control-sm koordinasi-date date"
                                                    value="{{ $mppData->koordinasi_date }}" placeholder="yyyy/mm/dd"
                                                    readonly>
                                                <input type="time" name="koordinasi_time"
                                                    class="form-control form-control-sm koordinasi-time"
                                                    value="{{ $mppData->koordinasi_time ? \Carbon\Carbon::parse($mppData->koordinasi_time)->format('H:i') : '' }}">
                                            </div>
                                        </td>
                                        <td class="criteria-column">
                                            <strong>3. Koordinasi Komunikasi dan Kolaborasi</strong><br><br>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="koordinasi[]" value="konsultasi_kolaborasi"
                                                    class="criteria-checkbox koordinasi-checkbox" id="k1"
                                                    {{ $mppData->konsultasi_kolaborasi ? 'checked' : '' }}>
                                                <label class="criteria-label" for="k1">Konsultasi/Kolaborasi</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="koordinasi[]" value="second_opinion"
                                                    class="criteria-checkbox koordinasi-checkbox" id="k2"
                                                    {{ $mppData->second_opinion ? 'checked' : '' }}>
                                                <label class="criteria-label" for="k2">Second Opinion</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="koordinasi[]" value="rawat_bersama"
                                                    class="criteria-checkbox koordinasi-checkbox" id="k3"
                                                    {{ $mppData->rawat_bersama ? 'checked' : '' }}>
                                                <label class="criteria-label" for="k3">Rawat Bersama/Alih
                                                    Rawat</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="koordinasi[]" value="komunikasi_edukasi"
                                                    class="criteria-checkbox koordinasi-checkbox" id="k4"
                                                    {{ $mppData->komunikasi_edukasi ? 'checked' : '' }}>
                                                <label class="criteria-label" for="k4">Komunikasi/Edukasi</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="koordinasi[]" value="rujukan"
                                                    class="criteria-checkbox koordinasi-checkbox" id="k5"
                                                    {{ $mppData->rujukan ? 'checked' : '' }}>
                                                <label class="criteria-label" for="k5">Rujukan</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 4. Advokasi Pelayanan Pasien -->
                                    <tr class="advokasi-row">
                                        <td class="datetime-column">
                                            <div class="datetime-inputs">
                                                <input type="text" name="advokasi_date"
                                                    class="form-control form-control-sm advokasi-date date"
                                                    value="{{ $mppData->advokasi_date }}" placeholder="yyyy/mm/dd"
                                                    readonly>
                                                <input type="time" name="advokasi_time"
                                                    class="form-control form-control-sm advokasi-time"
                                                    value="{{ $mppData->advokasi_time ? \Carbon\Carbon::parse($mppData->advokasi_time)->format('H:i') : '' }}">
                                            </div>
                                        </td>
                                        <td class="criteria-column">
                                            <strong>4. Advokasi Pelayanan Pasien</strong><br><br>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="advokasi[]" value="diskusi_ppa"
                                                    class="criteria-checkbox advokasi-checkbox" id="a1"
                                                    {{ $mppData->diskusi_ppa ? 'checked' : '' }}>
                                                <label class="criteria-label" for="a1">Diskusi dengan PPA staf lain
                                                    tentang kebutuhan pasien</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="advokasi[]" value="fasilitasi_akses"
                                                    class="criteria-checkbox advokasi-checkbox" id="a2"
                                                    {{ $mppData->fasilitasi_akses ? 'checked' : '' }}>
                                                <label class="criteria-label" for="a2">Memfasilitasi akses ke
                                                    pelayanan sesuai kebutuhan pasien berkoordinasi dengan PPA dan pemangku
                                                    kepentingan</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="advokasi[]" value="kemandirian_keputusan"
                                                    class="criteria-checkbox advokasi-checkbox" id="a3"
                                                    {{ $mppData->kemandirian_keputusan ? 'checked' : '' }}>
                                                <label class="criteria-label" for="a3">Meningkatkan kemandirian
                                                    untuk menentukan pilihan/pengambilan keputusan</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="advokasi[]" value="pencegahan_disparitas"
                                                    class="criteria-checkbox advokasi-checkbox" id="a4"
                                                    {{ $mppData->pencegahan_disparitas ? 'checked' : '' }}>
                                                <label class="criteria-label" for="a4">Mengenali, mencegah,
                                                    menghindari disparitas untuk mengakses mutu dan hasil pelayanan terkait
                                                    dengan ras, etnik, agama, gender, budaya, status pernikahan, usia,
                                                    politik, disabilitas fisik mental-kognitif</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="advokasi[]" value="pemenuhan_kebutuhan"
                                                    class="criteria-checkbox advokasi-checkbox" id="a5"
                                                    {{ $mppData->pemenuhan_kebutuhan ? 'checked' : '' }}>
                                                <label class="criteria-label" for="a5">Pemenuhan kebutuhan pelayanan
                                                    yang berkembang/bertambah karena perubahan kondisi</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- 5. Hasil Pelayanan -->
                                    <tr class="hasil-row">
                                        <td class="datetime-column">
                                            <div class="datetime-inputs">
                                                <input type="text" name="hasil_date"
                                                    class="form-control form-control-sm hasil-date date"
                                                    value="{{ $mppData->hasil_date }}" placeholder="yyyy/mm/dd" readonly>
                                                <input type="time" name="hasil_time"
                                                    class="form-control form-control-sm hasil-time"
                                                    value="{{ $mppData->hasil_time ? \Carbon\Carbon::parse($mppData->hasil_time)->format('H:i') : '' }}">
                                            </div>
                                        </td>
                                        <td class="criteria-column">
                                            <strong>5. Hasil Pelayanan</strong><br><br>
                                            <textarea name="hasil_pelayanan" class="form-control-textarea" placeholder="Tuliskan hasil pelayanan...">{{ $mppData->hasil_pelayanan }}</textarea>
                                        </td>
                                    </tr>

                                    <!-- 6. Terminasi Manajemen Pelayanan -->
                                    <tr class="terminasi-row">
                                        <td class="datetime-column">
                                            <div class="datetime-inputs">
                                                <input type="text" name="terminasi_date"
                                                    class="form-control form-control-sm terminasi-date date"
                                                    value="{{ $mppData->terminasi_date }}" placeholder="yyyy/mm/dd"
                                                    readonly>
                                                <input type="time" name="terminasi_time"
                                                    class="form-control form-control-sm terminasi-time"
                                                    value="{{ $mppData->terminasi_time ? \Carbon\Carbon::parse($mppData->terminasi_time)->format('H:i') : '' }}">
                                            </div>
                                        </td>
                                        <td class="criteria-column">
                                            <strong>6. Terminasi Manajemen Pelayanan Pasien, Catatan kepuasan
                                                pasien/keluarga dengan MPP</strong><br>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="terminasi[]" value="puas"
                                                    class="criteria-checkbox terminasi-checkbox" id="t1"
                                                    {{ $mppData->puas ? 'checked' : '' }}>
                                                <label class="criteria-label" for="t1">Puas</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="terminasi[]" value="tidak_puas"
                                                    class="criteria-checkbox terminasi-checkbox" id="t2"
                                                    {{ $mppData->tidak_puas ? 'checked' : '' }}>
                                                <label class="criteria-label" for="t2">Tidak Puas</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="terminasi[]" value="abstain"
                                                    class="criteria-checkbox terminasi-checkbox" id="t3"
                                                    {{ $mppData->abstain ? 'checked' : '' }}>
                                                <label class="criteria-label" for="t3">Abstain</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="terminasi[]" value="konflik_komplain"
                                                    class="criteria-checkbox terminasi-checkbox" id="t4"
                                                    {{ $mppData->konflik_komplain ? 'checked' : '' }}>
                                                <label class="criteria-label" for="t4">Konflik/Komplain</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="terminasi[]" value="keuangan"
                                                    class="criteria-checkbox terminasi-checkbox" id="t5"
                                                    {{ $mppData->keuangan ? 'checked' : '' }}>
                                                <label class="criteria-label" for="t5">Masalah Keuangan</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="terminasi[]" value="pulang_sembuh"
                                                    class="criteria-checkbox terminasi-checkbox" id="t6"
                                                    {{ $mppData->pulang_sembuh ? 'checked' : '' }}>
                                                <label class="criteria-label" for="t6">Pasien Pulang Sembuh</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="terminasi[]" value="rujuk"
                                                    class="criteria-checkbox terminasi-checkbox" id="t7"
                                                    {{ $mppData->rujuk ? 'checked' : '' }}>
                                                <label class="criteria-label" for="t7">Rujuk</label>
                                            </div>
                                            <div class="criteria-item">
                                                <input type="checkbox" name="terminasi[]" value="meninggal"
                                                    class="criteria-checkbox terminasi-checkbox" id="t8"
                                                    {{ $mppData->meninggal ? 'checked' : '' }}>
                                                <label class="criteria-label" for="t8">Meninggal</label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Update
                            </button>
                            <a href="{{ route('rawat-inap.mpp.form-b.index', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                            ]) }}"
                                class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let dokterTambahanIndex = document.querySelectorAll('.dokter-tambahan-item').length;
            let petugasTerkaitIndex = document.querySelectorAll('.petugas-terkait-item').length;
            
            // Store doctor options
            const doctorOptions = [];
            @foreach ($dokter as $dok)
                doctorOptions.push({
                    value: '{{ addslashes($dok->kd_dokter) }}', 
                    text: '{{ addslashes($dok->nama) }}'
                });
            @endforeach

            // Store perawat options
            const perawatOptions = [];
            @foreach ($perawat as $prwt)
                perawatOptions.push({
                    value: '{{ addslashes($prwt->kd_karyawan) }}', 
                    text: '{{ addslashes("$prwt->gelar_depan $prwt->nama $prwt->gelar_belakang") }}'
                });
            @endforeach

            // Function to build doctor options HTML
            function buildDoctorOptionsHtml(selectedValue = '') {
                let html = '<option value="">--Pilih--</option>';
                doctorOptions.forEach(function(doctor) {
                    const selected = selectedValue === doctor.value ? 'selected' : '';
                    html += `<option value="${doctor.value}" ${selected}>${doctor.text}</option>`;
                });
                return html;
            }

            // Function to build perawat options HTML
            function buildPerawatOptionsHtml(selectedValue = '') {
                let html = '<option value="">--Pilih--</option>';
                perawatOptions.forEach(function(perawat) {
                    const selected = selectedValue === perawat.value ? 'selected' : '';
                    html += `<option value="${perawat.value}" ${selected}>${perawat.text}</option>`;
                });
                return html;
            }

            // Function to initialize Select2
            function initializeSelect2(element, type = 'default') {
                if (typeof $.fn.select2 !== 'undefined') {
                    $(element).select2({
                        theme: 'bootstrap-5',
                        placeholder: '--Pilih--',
                        width: '100%'
                    });
                }
            }

            // Function to reinitialize existing selects
            function reinitializeExistingSelects() {
                $('.select2-dokter-tambahan').each(function() {
                    const currentValue = $(this).val();
                    
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        $(this).select2('destroy');
                    }
                    
                    $(this).html(buildDoctorOptionsHtml(currentValue));
                    initializeSelect2(this);
                });

                $('.select2-petugas-terkait').each(function() {
                    const currentValue = $(this).val();
                    
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        $(this).select2('destroy');
                    }
                    
                    $(this).html(buildPerawatOptionsHtml(currentValue));
                    initializeSelect2(this);
                });
            }

            // Initialize existing Select2 elements
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    placeholder: '--Pilih--'
                });
                
                setTimeout(function() {
                    reinitializeExistingSelects();
                }, 100);
            }

            // Add new Dokter Tambahan
            document.getElementById('add-dokter-tambahan').addEventListener('click', function() {
                const container = document.getElementById('dokter-tambahan-container');
                const newItem = document.createElement('div');
                newItem.className = 'dokter-tambahan-item mb-2';
                newItem.setAttribute('data-index', dokterTambahanIndex);
                
                newItem.innerHTML = `
                    <div class="input-group">
                        <select name="dokter_tambahan[]" class="form-select select2-dokter-tambahan">
                            ${buildDoctorOptionsHtml()}
                        </select>
                        <button type="button" class="btn btn-outline-danger remove-dokter-tambahan">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
                
                container.appendChild(newItem);
                
                const newSelect = newItem.querySelector('select');
                initializeSelect2(newSelect);
                
                dokterTambahanIndex++;
                updateRemoveButtons();
            });

            // Add new Petugas Terkait
            document.getElementById('add-petugas-terkait').addEventListener('click', function() {
                const container = document.getElementById('petugas-terkait-container');
                const newItem = document.createElement('div');
                newItem.className = 'petugas-terkait-item mb-2';
                newItem.setAttribute('data-index', petugasTerkaitIndex);
                
                newItem.innerHTML = `
                    <div class="input-group">
                        <select name="petugas_terkait[]" class="form-select select2-petugas-terkait">
                            ${buildPerawatOptionsHtml()}
                        </select>
                        <button type="button" class="btn btn-outline-danger remove-petugas-terkait">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
                
                container.appendChild(newItem);
                
                const newSelect = newItem.querySelector('select');
                initializeSelect2(newSelect);
                
                petugasTerkaitIndex++;
                updateRemoveButtons();
            });

            // Remove handlers
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-dokter-tambahan') || e.target.closest('.remove-dokter-tambahan')) {
                    const button = e.target.classList.contains('remove-dokter-tambahan') ? e.target : e.target.closest('.remove-dokter-tambahan');
                    const item = button.closest('.dokter-tambahan-item');
                    
                    const select = item.querySelector('select');
                    if (typeof $.fn.select2 !== 'undefined' && $(select).hasClass('select2-hidden-accessible')) {
                        $(select).select2('destroy');
                    }
                    
                    item.remove();
                    updateRemoveButtons();
                }

                if (e.target.classList.contains('remove-petugas-terkait') || e.target.closest('.remove-petugas-terkait')) {
                    const button = e.target.classList.contains('remove-petugas-terkait') ? e.target : e.target.closest('.remove-petugas-terkait');
                    const item = button.closest('.petugas-terkait-item');
                    
                    const select = item.querySelector('select');
                    if (typeof $.fn.select2 !== 'undefined' && $(select).hasClass('select2-hidden-accessible')) {
                        $(select).select2('destroy');
                    }
                    
                    item.remove();
                    updateRemoveButtons();
                }
            });

            // Update remove buttons visibility
            function updateRemoveButtons() {
                // Update dokter tambahan buttons
                const dokterItems = document.querySelectorAll('.dokter-tambahan-item');
                dokterItems.forEach((item, index) => {
                    const removeBtn = item.querySelector('.remove-dokter-tambahan');
                    if (index === 0 && dokterItems.length === 1) {
                        removeBtn.style.display = 'none';
                    } else {
                        removeBtn.style.display = 'block';
                    }
                });

                // Update petugas terkait buttons
                const petugasItems = document.querySelectorAll('.petugas-terkait-item');
                petugasItems.forEach((item, index) => {
                    const removeBtn = item.querySelector('.remove-petugas-terkait');
                    if (index === 0 && petugasItems.length === 1) {
                        removeBtn.style.display = 'none';
                    } else {
                        removeBtn.style.display = 'block';
                    }
                });
            }

            // Initial update of remove buttons
            updateRemoveButtons();

            // Initialize Select2 if available
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    placeholder: '--Pilih--'
                });
            }

            // Form validation
            document.getElementById('mppImplementationForm').addEventListener('submit', function(e) {
                let isValid = true;

                // Define sections for validation
                const sections = [{
                        textareaName: 'rencana_pelayanan',
                        dateClass: 'rencana-date',
                        timeClass: 'rencana-time'
                    },
                    {
                        textareaName: 'monitoring_pelayanan',
                        dateClass: 'monitoring-date',
                        timeClass: 'monitoring-time'
                    },
                    {
                        checkboxClass: 'koordinasi-checkbox',
                        dateClass: 'koordinasi-date',
                        timeClass: 'koordinasi-time'
                    },
                    {
                        checkboxClass: 'advokasi-checkbox',
                        dateClass: 'advokasi-date',
                        timeClass: 'advokasi-time'
                    },
                    {
                        textareaName: 'hasil_pelayanan',
                        dateClass: 'hasil-date',
                        timeClass: 'hasil-time'
                    },
                    {
                        checkboxClass: 'terminasi-checkbox',
                        dateClass: 'terminasi-date',
                        timeClass: 'terminasi-time'
                    }
                ];

                sections.forEach(section => {
                    const dateInput = document.querySelector(`.${section.dateClass}`);
                    const timeInput = document.querySelector(`.${section.timeClass}`);
                    let hasContent = false;

                    if (section.textareaName) {
                        const textarea = document.querySelector(
                            `textarea[name="${section.textareaName}"]`);
                        hasContent = textarea.value.trim();
                    } else if (section.checkboxClass) {
                        const checkboxes = document.querySelectorAll(
                            `.${section.checkboxClass}:checked`);
                        hasContent = checkboxes.length > 0;
                    }

                    if (hasContent) {
                        if (!dateInput.value.trim()) {
                            dateInput.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            dateInput.classList.remove('is-invalid');
                        }
                        if (!timeInput.value.trim()) {
                            timeInput.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            timeInput.classList.remove('is-invalid');
                        }
                    } else {
                        dateInput.classList.remove('is-invalid');
                        timeInput.classList.remove('is-invalid');
                    }
                });

                // Time format validation
                document.querySelectorAll('input[type="time"]').forEach(timeInput => {
                    if (timeInput.value && !/^([01]\d|2[0-3]):([0-5]\d)$/.test(timeInput.value)) {
                        timeInput.classList.add('is-invalid');
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert(
                        'Mohon lengkapi tanggal dan jam untuk setiap seksi yang memiliki data yang diisi.'
                    );
                }
            });

            // Real-time validation
            const sections = [{
                    textareaName: 'rencana_pelayanan',
                    dateClass: 'rencana-date',
                    timeClass: 'rencana-time'
                },
                {
                    textareaName: 'monitoring_pelayanan',
                    dateClass: 'monitoring-date',
                    timeClass: 'monitoring-time'
                },
                {
                    checkboxClass: 'koordinasi-checkbox',
                    dateClass: 'koordinasi-date',
                    timeClass: 'koordinasi-time'
                },
                {
                    checkboxClass: 'advokasi-checkbox',
                    dateClass: 'advokasi-date',
                    timeClass: 'advokasi-time'
                },
                {
                    textareaName: 'hasil_pelayanan',
                    dateClass: 'hasil-date',
                    timeClass: 'hasil-time'
                },
                {
                    checkboxClass: 'terminasi-checkbox',
                    dateClass: 'terminasi-date',
                    timeClass: 'terminasi-time'
                }
            ];

            sections.forEach(section => {
                const dateInput = document.querySelector(`.${section.dateClass}`);
                const timeInput = document.querySelector(`.${section.timeClass}`);

                if (section.textareaName) {
                    const textarea = document.querySelector(`textarea[name="${section.textareaName}"]`);
                    textarea.addEventListener('input', function() {
                        const hasContent = this.value.trim();
                        if (hasContent) {
                            if (!dateInput.value.trim()) {
                                dateInput.classList.add('is-invalid');
                            } else {
                                dateInput.classList.remove('is-invalid');
                            }
                            if (!timeInput.value.trim()) {
                                timeInput.classList.add('is-invalid');
                            }
                        } else {
                            dateInput.classList.remove('is-invalid');
                            timeInput.classList.remove('is-invalid');
                        }
                    });
                }

                if (section.checkboxClass) {
                    const checkboxes = document.querySelectorAll(`.${section.checkboxClass}`);
                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            const anyChecked = Array.from(checkboxes).some(cb => cb
                                .checked);
                            if (anyChecked) {
                                if (!dateInput.value.trim()) {
                                    dateInput.classList.add('is-invalid');
                                }
                                if (!timeInput.value.trim()) {
                                    timeInput.classList.add('is-invalid');
                                }
                            } else {
                                dateInput.classList.remove('is-invalid');
                                timeInput.classList.remove('is-invalid');
                            }
                        });
                    });
                }

                // Date and time input validation
                dateInput.addEventListener('change', function() {
                    let hasContent = false;
                    if (section.textareaName) {
                        const textarea = document.querySelector(
                            `textarea[name="${section.textareaName}"]`);
                        hasContent = textarea.value.trim();
                    } else if (section.checkboxClass) {
                        const checkboxes = document.querySelectorAll(`.${section.checkboxClass}`);
                        hasContent = Array.from(checkboxes).some(cb => cb.checked);
                    }
                    if (hasContent && this.value.trim()) {
                        this.classList.remove('is-invalid');
                    } else if (hasContent && !this.value.trim()) {
                        this.classList.add('is-invalid');
                    }
                });

                timeInput.addEventListener('change', function() {
                    let hasContent = false;
                    if (section.textareaName) {
                        const textarea = document.querySelector(
                            `textarea[name="${section.textareaName}"]`);
                        hasContent = textarea.value.trim();
                    } else if (section.checkboxClass) {
                        const checkboxes = document.querySelectorAll(`.${section.checkboxClass}`);
                        hasContent = Array.from(checkboxes).some(cb => cb.checked);
                    }
                    if (hasContent && this.value.trim() && /^([01]\d|2[0-3]):([0-5]\d)$/.test(this
                            .value)) {
                        this.classList.remove('is-invalid');
                    } else if (hasContent && !this.value.trim()) {
                        this.classList.add('is-invalid');
                    }
                });
            });
        });
    </script>
@endpush
