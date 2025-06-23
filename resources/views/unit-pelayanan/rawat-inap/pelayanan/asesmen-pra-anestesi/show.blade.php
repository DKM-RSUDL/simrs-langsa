@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .card {
            border-radius: 10px;
        }

        .card-header {
            border-radius: 10px 10px 0 0;
        }

        .form-label {
            font-size: 0.9rem;
            color: #333;
        }

        .form-control,
        .form-check-input {
            border-radius: 5px;
        }

        .btn {
            border-radius: 5px;
        }

        .text-primary {
            color: #007bff !important;
        }

        .shadow-sm {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Patient Card -->
            <div class="col-lg-3 col-md-4 mb-4">
                @include('components.patient-card')
            </div>

            <!-- Main Form -->
            <div class="col-lg-9 col-md-8">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm me-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('rawat-inap.asesmen-pra-anestesi.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $asesmenPraAnestesi->id]) }}"
                        class="btn btn-warning btn-sm ms-2">
                        <i class="ti-pencil"></i> Edit
                    </a>
                </div>

                <form id="praAnestesiForm" method="POST"
                    action="{{ route('rawat-inap.asesmen-pra-anestesi.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                    @csrf

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h5 class="mb-0 font-weight-bold">ASESMEN PRA ANESTESI DAN SEDASI</h5>
                        </div>

                        <div class="card-body p-4">
                            <!-- Data Demografi -->
                            <h5 class="text-primary font-weight-bold mb-3"><i class="fas fa-user me-2"></i>Data Demografi
                            </h5>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Umur</label>
                                        <input type="number" class="form-control" name="umur" placeholder="Masukkan umur">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Jenis Kelamin</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                    id="laki_laki" value="1">
                                                <label class="form-check-label" for="laki_laki">Laki-laki</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                    id="perempuan" value="0">
                                                <label class="form-check-label" for="perempuan">Perempuan</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Status Menikah</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="menikah" id="menikah_ya"
                                                    value="Ya">
                                                <label class="form-check-label" for="menikah_ya">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="menikah"
                                                    id="menikah_tidak" value="Tidak">
                                                <label class="form-check-label" for="menikah_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Pekerjaan</label>
                                        <input type="text" class="form-control" name="pekerjaan"
                                            placeholder="Masukkan pekerjaan">
                                    </div>
                                </div>
                            </div>

                            <!-- Kebiasaan -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-smoking me-2"></i>Kebiasaan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Merokok</label>
                                                <input type="text" class="form-control" name="merokok">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Alkohol</label>
                                                <input type="text" class="form-control" name="alkohol">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pengobatan -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-pills me-2"></i>Pengobatan</h6>
                                    <small class="text-muted">Sebutkan dosis atau jumlah pil per hari</small>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Obat Resep</label>
                                                <textarea class="form-control" name="obat_resep" rows="3"
                                                    placeholder="Nama obat dan dosis"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Obat Bebas (Vitamin, Herbal)</label>
                                                <textarea class="form-control" name="obat_bebas" rows="3"
                                                    placeholder="Nama obat dan dosis"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border rounded p-3 mb-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold">Penggunaan Aspirin Rutin</label>
                                                    <div class="d-flex gap-3 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="aspirin_rutin" id="aspirin_ya" value="Ya">
                                                            <label class="form-check-label" for="aspirin_ya">Ya</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="aspirin_rutin" id="aspirin_tidak" value="Tidak">
                                                            <label class="form-check-label"
                                                                for="aspirin_tidak">Tidak</label>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" name="aspirin_dosis"
                                                        placeholder="Dosis dan frekuensi">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold">Obat Anti Sakit</label>
                                                    <div class="d-flex gap-3 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="obat_anti_sakit" id="anti_sakit_ya" value="Ya">
                                                            <label class="form-check-label" for="anti_sakit_ya">Ya</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="obat_anti_sakit" id="anti_sakit_tidak" value="Tidak">
                                                            <label class="form-check-label"
                                                                for="anti_sakit_tidak">Tidak</label>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" name="anti_sakit_dosis"
                                                        placeholder="Dosis dan frekuensi">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">Injeksi Steroid Tahun-tahun Terakhir</label>
                                            <div class="d-flex gap-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="injeksi_steroid"
                                                        id="steroid_ya" value="Ya">
                                                    <label class="form-check-label" for="steroid_ya">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="injeksi_steroid"
                                                        id="steroid_tidak" value="Tidak">
                                                    <label class="form-check-label" for="steroid_tidak">Tidak</label>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" name="steroid_lokasi"
                                                placeholder="Tanggal dan lokasi injeksi">
                                        </div>
                                    </div>

                                    <div class="border rounded p-3">
                                        <h6 class="fw-bold text-danger mb-3"><i
                                                class="fas fa-exclamation-triangle me-2"></i>Informasi Alergi</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold">Alergi Obat</label>
                                                    <div class="d-flex gap-3 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="alergi_obat"
                                                                id="alergi_obat_ya" value="Ya">
                                                            <label class="form-check-label" for="alergi_obat_ya">Ya</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="alergi_obat"
                                                                id="alergi_obat_tidak" value="Tidak">
                                                            <label class="form-check-label"
                                                                for="alergi_obat_tidak">Tidak</label>
                                                        </div>
                                                    </div>
                                                    <textarea class="form-control" name="alergi_obat_detail" rows="3"
                                                        placeholder="Daftar obat dan tipe reaksi"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label fw-bold small">Alergi Lateks</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="alergi_lateks" id="lateks_ya" value="Ya">
                                                                <label class="form-check-label small"
                                                                    for="lateks_ya">Ya</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="alergi_lateks" id="lateks_tidak" value="Tidak">
                                                                <label class="form-check-label small"
                                                                    for="lateks_tidak">Tidak</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label fw-bold small">Alergi Plester</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="alergi_plester" id="plester_ya" value="Ya">
                                                                <label class="form-check-label small"
                                                                    for="plester_ya">Ya</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="alergi_plester" id="plester_tidak" value="Tidak">
                                                                <label class="form-check-label small"
                                                                    for="plester_tidak">Tidak</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label fw-bold small">Alergi Makanan</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="alergi_makanan" id="makanan_ya" value="Ya">
                                                                <label class="form-check-label small"
                                                                    for="makanan_ya">Ya</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="alergi_makanan" id="makanan_tidak" value="Tidak">
                                                                <label class="form-check-label small"
                                                                    for="makanan_tidak">Tidak</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Riwayat Keluarga -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-users me-2"></i>Riwayat Keluarga
                                    </h6>
                                    <small class="text-muted">Apakah keluarga mendapat permasalahan seperti di bawah
                                        ini</small>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Perdarahan yang Tidak Normal</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rk_perdarahan"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rk_perdarahan"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Pembekuan Darah Tidak Normal</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rk_pembekuan"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rk_pembekuan"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Permasalahan dalam Pembiusan</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rk_anestesi"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rk_anestesi"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Operasi Jantung Koroner</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="rk_operasi_jantung" value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="rk_operasi_jantung" value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Diabetes Mellitus</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rk_diabetes"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rk_diabetes"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Serangan Jantung</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="rk_serangan_jantung" value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="rk_serangan_jantung" value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Hipertensi</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rk_hipertensi"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rk_hipertensi"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tuberkulosis</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rk_tuberkulosis"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rk_tuberkulosis"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Penyakit Berat Lainnya</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rk_penyakit_lain"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rk_penyakit_lain"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Jelaskan Penyakit Keluarga Apabila Dijawab
                                            "Ya"</label>
                                        <textarea class="form-control" name="rk_keterangan" rows="4"
                                            placeholder="Jelaskan detail penyakit keluarga"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Komunikasi -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-comments me-2"></i>Komunikasi
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Bahasa</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="bahasa"
                                                        id="bahasa_indonesia" value="Indonesia">
                                                    <label class="form-check-label" for="bahasa_indonesia">Indonesia</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="bahasa"
                                                        id="bahasa_lain" value="Bahasa Lainnya">
                                                    <label class="form-check-label" for="bahasa_lain">Lainnya:</label>
                                                    <input type="text" class="form-control mt-2" name="bahasa_lain"
                                                        placeholder="Sebutkan bahasa lain">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Gangguan Penglihatan/Buta</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="gangguan_penglihatan" value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="gangguan_penglihatan" value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Gangguan Pendengaran/Tuli</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="gangguan_pendengaran" value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="gangguan_pendengaran" value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Gangguan Bicara</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="gangguan_bicara"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="gangguan_bicara"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Riwayat Penyakit Pasien -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-user-injured me-2"></i>Riwayat
                                        Penyakit Pasien</h6>
                                    <small class="text-muted">Apakah pernah menderita penyakit di bawah ini</small>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Perdarahan yang Tidak Normal</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_perdarahan"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_perdarahan"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Pembekuan Darah Tidak Normal</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_pembekuan"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_pembekuan"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Sakit Maag</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_maag"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_maag"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Anemia</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_anemia"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_anemia"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Sesak Nafas</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_sesak"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_sesak"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Asma</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_asma"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_asma"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Diabetes Mellitus</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_diabetes"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_diabetes"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Pingsan</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_pingsan"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_pingsan"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Serangan Jantung</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="rp_serangan_jantung" value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="rp_serangan_jantung" value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Hepatitis</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_hepatitis"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_hepatitis"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Hipertensi</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_hipertensi"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_hipertensi"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Sumbatan Jalan Nafas</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="rp_sumbatan_nafas" value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="rp_sumbatan_nafas" value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tidur Mengorok</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_mengorok"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_mengorok"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Penyakit Berat Lainnya</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_penyakit_lain"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="rp_penyakit_lain"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Jelaskan Penyakit Pasien Apabila Dijawab
                                            "Ya"</label>
                                        <textarea class="form-control" name="rp_keterangan" rows="4"
                                            placeholder="Jelaskan detail penyakit yang pernah diderita"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Riwayat Medis Lain -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-notes-medical me-2"></i>Riwayat
                                        Medis Lainnya</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Apakah Pasien Pernah Mendapat Transfusi
                                                    Darah?</label>
                                                <div class="d-flex gap-3 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="transfusi_darah"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="transfusi_darah"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control" name="transfusi_tahun"
                                                    placeholder="Bila Ya, tahun berapa?">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Apakah Pasien Pernah Diperiksa untuk
                                                    Diagnosis HIV?</label>
                                                <div class="d-flex gap-3 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="periksa_hiv"
                                                            value="Ya">
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="periksa_hiv"
                                                            value="Tidak">
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control" name="hiv_tahun"
                                                    placeholder="Bila Ya, tahun berapa?">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Hasil Pemeriksaan HIV</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hasil_hiv"
                                                        value="Positif">
                                                    <label class="form-check-label">Positif</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hasil_hiv"
                                                        value="Negatif">
                                                    <label class="form-check-label">Negatif</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Apakah Pasien Memakai:</label>
                                                <div class="row mt-2">
                                                    <div class="col-4">
                                                        <label class="form-label fw-bold small">Lensa Kontak</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="lensa_kontak"
                                                                value="Ya">
                                                            <label class="form-check-label small">Ya</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="lensa_kontak"
                                                                value="Tidak">
                                                            <label class="form-check-label small">Tidak</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label fw-bold small">Alat Bantu Dengar</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="alat_bantu_dengar" value="Ya">
                                                            <label class="form-check-label small">Ya</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="alat_bantu_dengar" value="Tidak">
                                                            <label class="form-check-label small">Tidak</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label fw-bold small">Gigi Palsu</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="gigi_palsu"
                                                                value="Ya">
                                                            <label class="form-check-label small">Ya</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="gigi_palsu"
                                                                value="Tidak">
                                                            <label class="form-check-label small">Tidak</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Riwayat, Tahun, dan Jenis Operasi</label>
                                        <textarea class="form-control" name="riwayat_operasi" rows="3"
                                            placeholder="Sebutkan jenis operasi dan tahunnya"></textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Jenis Anestesi yang Digunakan dan
                                            Komplikasi/Reaksi yang Dialami</label>
                                        <textarea class="form-control" name="jenis_anestesi_sebelum" rows="3"
                                            placeholder="Jelaskan jenis anestesi dan komplikasi jika ada"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tanggal Terakhir Diperiksa Kesehatan ke
                                                    Dokter</label>
                                                <input type="date" class="form-control" name="tanggal_periksa_terakhir">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Di</label>
                                                <input type="text" class="form-control" name="tempat_periksa_terakhir"
                                                    placeholder="Tempat pemeriksaan">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Untuk Penyakit Gangguan Apa</label>
                                        <textarea class="form-control" name="gangguan_periksa" rows="3"
                                            placeholder="Jelaskan gangguan/penyakit yang diperiksa"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Khusus Pasien Perempuan -->
                            <div class="card mb-4 shadow-sm" id="pasien-perempuan">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-female me-2"></i>Khusus Pasien
                                        Perempuan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jumlah Kehamilan</label>
                                                <input type="number" class="form-control" name="jumlah_kehamilan"
                                                    placeholder="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jumlah Anak</label>
                                                <input type="number" class="form-control" name="jumlah_anak"
                                                    placeholder="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Menstruasi Terakhir</label>
                                                <input type="date" class="form-control" name="menstruasi_terakhir">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Menyusui</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="menyusui" value="Ya">
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="menyusui" value="Tidak">
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kajian Sistem -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <p class="fw-bold">Diisi Oleh Dokter</p>
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-stethoscope me-2"></i>Kajian Sistem</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Hilangnya Gigi</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hilangnya_gigi" value="Ya">
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hilangnya_gigi" value="Tidak">
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Masalah Mobilitas Leher</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="masalah_mobilitas_leher" value="Ya">
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="masalah_mobilitas_leher" value="Tidak">
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Leher Pendek</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="leher_pendek" value="Ya">
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="leher_pendek" value="Tidak">
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Batuk</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="batuk" value="Ya">
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="batuk" value="Tidak">
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Sesak Nafas</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sesak_nafas" value="Ya">
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sesak_nafas" value="Tidak">
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Baru Saja Menderita Infeksi</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="baru_saja_infeksi" value="Ya">
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="baru_saja_infeksi" value="Tidak">
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Menstruasi Tidak Normal</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="menstruasi_tidak_normal" value="Ya">
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="menstruasi_tidak_normal" value="Tidak">
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Pingsan</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="pingsan" value="Ya">
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="pingsan" value="Tidak">
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Sakit Dada</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sakit_dada" value="Ya">
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sakit_dada" value="Tidak">
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Denyut Jantung Tidak Normal</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="denyut_jantung_tidak_normal" value="Ya">
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="denyut_jantung_tidak_normal" value="Tidak">
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Muntah</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="muntah" value="Ya">
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="muntah" value="Tidak">
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Susaah BAK</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="susaah_bak" value="Ya">
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="susaah_bak" value="Tidak">
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Kejang</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kejang" value="Ya">
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="kejang" value="Tidak">
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Sedang Hamil</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sedang_hamil" value="Ya">
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sedang_hamil" value="Tidak">
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Stroke</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="stroke" value="Ya">
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="stroke" value="Tidak">
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Obesitas</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="obesitas" value="Ya">
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="obesitas" value="Tidak">
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Saluran nafas atas:</label>
                                        <textarea class="form-control" name="saluran_nafas_atas" rows="4"
                                            placeholder="Jelaskan detail penyakit yang pernah diderita"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Keadaan Umum -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-heartbeat me-2"></i>Keadaan Umum
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Kesadaran</label>
                                                <input type="text" class="form-control" name="kesadaran"
                                                    placeholder="Masukkan kesadaran">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Visus</label>
                                                <input type="text" class="form-control" name="visus"
                                                    placeholder="Masukkan visus">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Faring</label>
                                                <input type="text" class="form-control" name="faring"
                                                    placeholder="Masukkan faring">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Gigi Palus</label>
                                                <input type="text" class="form-control" name="gigi_palus"
                                                    placeholder="Masukkan gigi palus">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Keterangan:</label>
                                                <textarea class="form-control" name="keadaan_umum_keterangan" rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pemeriksaan Fisik -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-stethoscope me-2"></i>Pemeriksaan
                                        Fisik</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">BB</label>
                                                <input type="number" class="form-control" name="bb"
                                                    placeholder="Berat Badan (kg)">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">TD</label>
                                                <input type="number" class="form-control" name="td"
                                                    placeholder="Tekanan Darah (mmHg)">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Nadi</label>
                                                <input type="number" class="form-control" name="nadi"
                                                    placeholder="Nadi (x/menit)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Suhu</label>
                                                <input type="number" class="form-control" name="suhu" placeholder="Suhu (°C)">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Paru-Paru</label>
                                                <input type="number" class="form-control" name="paru"
                                                    placeholder="Pernapasan (x/menit)">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jantung</label>
                                                <input type="text" class="form-control" name="jantung"
                                                    placeholder="Kondisi jantung">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Abdomen</label>
                                                <input type="text" class="form-control" name="abdomen"
                                                    placeholder="Kondisi abdomen">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Ekstremitas</label>
                                                <input type="text" class="form-control" name="ekstremitas"
                                                    placeholder="Kondisi ekstremitas">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Neurologi (jika ada ditemukan)</label>
                                                <input type="text" class="form-control" name="neurologi"
                                                    placeholder="Kondisi neurologi">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Keterangan:</label>
                                        <textarea class="form-control" name="pemeriksaan_fisik_keterangan" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Laboratorium -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-text-primary"><i class="fas fa-vial me-2"></i>Laboratorium
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Hb/Leuco/Thrombo</label>
                                                <input type="text" class="form-control" name="hb_leuco_thrombo"
                                                    placeholder="Hasil pemeriksaan">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">PT/APTT</label>
                                                <input type="text" class="form-control" name="pt_aptt"
                                                    placeholder="Hasil pemeriksaan">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tes Kreatinin</label>
                                                <input type="text" class="form-control" name="tes_kreatinin"
                                                    placeholder="Hasil pemeriksaan">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Ureum</label>
                                                <input type="text" class="form-control" name="ureum"
                                                    placeholder="Hasil pemeriksaan">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">EKG</label>
                                                <input type="text" class="form-control" name="ekg"
                                                    placeholder="Hasil pemeriksaan">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Na/Cl/K</label>
                                                <input type="text" class="form-control" name="na_cl_k"
                                                    placeholder="Hasil pemeriksaan">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">CO2</label>
                                                <input type="text" class="form-control" name="co2"
                                                    placeholder="Hasil pemeriksaan">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">CT Scan</label>
                                                <input type="text" class="form-control" name="ct_scan"
                                                    placeholder="Hasil pemeriksaan">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">MRI</label>
                                                <input type="text" class="form-control" name="mri"
                                                    placeholder="Hasil pemeriksaan">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">USG</label>
                                                <input type="text" class="form-control" name="usg"
                                                    placeholder="Hasil pemeriksaan">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Lain-lain</label>
                                                <input type="text" class="form-control" name="laboratorium_lain"
                                                    placeholder="Hasil pemeriksaan lain">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Keterangan:</label>
                                        <textarea class="form-control" name="laboratorium_keterangan" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Diagnostik -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-diagnoses me-2"></i>Diagnosis
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Klasifikasi berdasarkan ASA</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="asa_klasifikasi"
                                                value="ASA 1">
                                            <label class="form-check-label">ASA 1 - Pasien sehat normal dan sehat</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="asa_klasifikasi"
                                                value="ASA 2">
                                            <label class="form-check-label">ASA 2 - Pasien dengan penyakit sitemik ringan</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="asa_klasifikasi"
                                                value="ASA 3">
                                            <label class="form-check-label">ASA 3 - Pasien dengan penyakit sitemik berat</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="asa_klasifikasi"
                                                value="ASA 4">
                                            <label class="form-check-label">ASA 4 - Pasien dengan penyakit sitamik berat yang mengancam nyawa</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pusa Mulai -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-calendar me-2"></i>Pusa Mulai
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Pusa mulai</label>
                                                <input type="date" class="form-control" name="pusa_mulai">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jam</label>
                                                <input type="time" class="form-control" name="pusa_mulai_jam">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Rencana tindakan OK -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-stethoscope me-2"></i>Rencana
                                        tindakan OK</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Rencana tindakan</label>
                                                <input type="text" class="form-control" name="rencana_tindakan"
                                                    placeholder="Masukkan rencana tindakan">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tanggal</label>
                                                <input type="date" class="form-control" name="rencana_tanggal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jam</label>
                                                <input type="time" class="form-control" name="rencana_jam">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Rencana Operasi -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-syringe me-2"></i>Rencana Operasi
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Rencana Operasi</label>
                                                <input type="text" class="form-control" name="rencana_operasi"
                                                    placeholder="Masukkan rencana operasi">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tanggal</label>
                                                <input type="date" class="form-control" name="rencana_operasi_tanggal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jam</label>
                                                <input type="time" class="form-control" name="rencana_operasi_jam">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Buttons -->
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Asesmen
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
