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
                <div class="d-flex align-items-center mb-3">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm me-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <form id="praAnestesiForm" method="POST"
                    action="{{ route('rawat-inap.asesmen-pra-anestesi.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $asesmenPraAnestesi->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h5 class="mb-0 font-weight-bold">EDIT ASESMEN PRA ANESTESI DAN SEDASI</h5>
                        </div>

                        <div class="card-body p-4">
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
                                                <input type="text"
                                                    class="form-control @error('merokok') is-invalid @enderror"
                                                    name="merokok"
                                                    value="{{ old('merokok', $asesmenPraAnestesi->merokok ?? '') }}"
                                                    placeholder="Opsional - masukkan kebiasaan merokok">
                                                @error('merokok')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Alkohol</label>
                                                <input type="text"
                                                    class="form-control @error('alkohol') is-invalid @enderror"
                                                    name="alkohol"
                                                    value="{{ old('alkohol', $asesmenPraAnestesi->alkohol ?? '') }}"
                                                    placeholder="Opsional - masukkan kebiasaan alkohol">
                                                @error('alkohol')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
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
                                                <textarea class="form-control @error('obat_resep') is-invalid @enderror"
                                                    name="obat_resep" rows="3"
                                                    placeholder="Nama obat dan dosis">{{ old('obat_resep', $asesmenPraAnestesi->obat_resep ?? '') }}</textarea>
                                                @error('obat_resep')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Obat Bebas (Vitamin, Herbal)</label>
                                                <textarea class="form-control @error('obat_bebas') is-invalid @enderror"
                                                    name="obat_bebas" rows="3"
                                                    placeholder="Nama obat dan dosis">{{ old('obat_bebas', $asesmenPraAnestesi->obat_bebas ?? '') }}</textarea>
                                                @error('obat_bebas')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
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
                                                            <input
                                                                class="form-check-input @error('aspirin_rutin') is-invalid @enderror"
                                                                type="radio" name="aspirin_rutin" id="aspirin_ya" value="Ya"
                                                                {{ old('aspirin_rutin', $asesmenPraAnestesi->aspirin_rutin ?? '') == 'Ya' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="aspirin_ya">Ya</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input @error('aspirin_rutin') is-invalid @enderror"
                                                                type="radio" name="aspirin_rutin" id="aspirin_tidak"
                                                                value="Tidak" {{ old('aspirin_rutin', $asesmenPraAnestesi->aspirin_rutin ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="aspirin_tidak">Tidak</label>
                                                        </div>
                                                    </div>
                                                    @error('aspirin_rutin')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                    <input type="text"
                                                        class="form-control @error('aspirin_dosis') is-invalid @enderror"
                                                        name="aspirin_dosis" placeholder="Dosis dan frekuensi"
                                                        value="{{ old('aspirin_dosis', $asesmenPraAnestesi->aspirin_dosis ?? '') }}">
                                                    @error('aspirin_dosis')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold">Obat Anti Sakit</label>
                                                    <div class="d-flex gap-3 mb-2">
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input @error('obat_anti_sakit') is-invalid @enderror"
                                                                type="radio" name="obat_anti_sakit" id="anti_sakit_ya"
                                                                value="Ya" {{ old('obat_anti_sakit', $asesmenPraAnestesi->obat_anti_sakit ?? '') == 'Ya' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="anti_sakit_ya">Ya</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input @error('obat_anti_sakit') is-invalid @enderror"
                                                                type="radio" name="obat_anti_sakit" id="anti_sakit_tidak"
                                                                value="Tidak" {{ old('obat_anti_sakit', $asesmenPraAnestesi->obat_anti_sakit ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="anti_sakit_tidak">Tidak</label>
                                                        </div>
                                                    </div>
                                                    @error('obat_anti_sakit')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                    <input type="text"
                                                        class="form-control @error('anti_sakit_dosis') is-invalid @enderror"
                                                        name="anti_sakit_dosis" placeholder="Dosis dan frekuensi"
                                                        value="{{ old('anti_sakit_dosis', $asesmenPraAnestesi->anti_sakit_dosis ?? '') }}">
                                                    @error('anti_sakit_dosis')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">Injeksi Steroid Tahun-tahun Terakhir</label>
                                            <div class="d-flex gap-3 mb-2">
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('injeksi_steroid') is-invalid @enderror"
                                                        type="radio" name="injeksi_steroid" id="steroid_ya" value="Ya" {{ old('injeksi_steroid', $asesmenPraAnestesi->injeksi_steroid ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="steroid_ya">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('injeksi_steroid') is-invalid @enderror"
                                                        type="radio" name="injeksi_steroid" id="steroid_tidak" value="Tidak"
                                                        {{ old('injeksi_steroid', $asesmenPraAnestesi->injeksi_steroid ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="steroid_tidak">Tidak</label>
                                                </div>
                                            </div>
                                            @error('injeksi_steroid')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <input type="text"
                                                class="form-control @error('steroid_lokasi') is-invalid @enderror"
                                                name="steroid_lokasi" placeholder="Tanggal dan lokasi injeksi"
                                                value="{{ old('steroid_lokasi', $asesmenPraAnestesi->steroid_lokasi ?? '') }}">
                                            @error('steroid_lokasi')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
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
                                                            <input
                                                                class="form-check-input @error('alergi_obat') is-invalid @enderror"
                                                                type="radio" name="alergi_obat" id="alergi_obat_ya"
                                                                value="Ya" {{ old('alergi_obat', $asesmenPraAnestesi->alergi_obat ?? '') == 'Ya' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="alergi_obat_ya">Ya</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input @error('alergi_obat') is-invalid @enderror"
                                                                type="radio" name="alergi_obat" id="alergi_obat_tidak"
                                                                value="Tidak" {{ old('alergi_obat', $asesmenPraAnestesi->alergi_obat ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="alergi_obat_tidak">Tidak</label>
                                                        </div>
                                                    </div>
                                                    @error('alergi_obat')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                    <textarea
                                                        class="form-control @error('alergi_obat_detail') is-invalid @enderror"
                                                        name="alergi_obat_detail" rows="3"
                                                        placeholder="Daftar obat dan tipe reaksi">{{ old('alergi_obat_detail', $asesmenPraAnestesi->alergi_obat_detail ?? '') }}</textarea>
                                                    @error('alergi_obat_detail')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label fw-bold small">Alergi Lateks</label>
                                                            <div class="form-check">
                                                                <input
                                                                    class="form-check-input @error('alergi_lateks') is-invalid @enderror"
                                                                    type="radio" name="alergi_lateks" id="lateks_ya"
                                                                    value="Ya" {{ old('alergi_lateks', $asesmenPraAnestesi->alergi_lateks ?? '') == 'Ya' ? 'checked' : '' }}>
                                                                <label class="form-check-label small"
                                                                    for="lateks_ya">Ya</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input
                                                                    class="form-check-input @error('alergi_lateks') is-invalid @enderror"
                                                                    type="radio" name="alergi_lateks" id="lateks_tidak"
                                                                    value="Tidak" {{ old('alergi_lateks', $asesmenPraAnestesi->alergi_lateks ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                                <label class="form-check-label small"
                                                                    for="lateks_tidak">Tidak</label>
                                                            </div>
                                                            @error('alergi_lateks')
                                                                <div class="invalid-feedback d-block">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label fw-bold small">Alergi Plester</label>
                                                            <div class="form-check">
                                                                <input
                                                                    class="form-check-input @error('alergi_plester') is-invalid @enderror"
                                                                    type="radio" name="alergi_plester" id="plester_ya"
                                                                    value="Ya" {{ old('alergi_plester', $asesmenPraAnestesi->alergi_plester ?? '') == 'Ya' ? 'checked' : '' }}>
                                                                <label class="form-check-label small"
                                                                    for="plester_ya">Ya</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input
                                                                    class="form-check-input @error('alergi_plester') is-invalid @enderror"
                                                                    type="radio" name="alergi_plester" id="plester_tidak"
                                                                    value="Tidak" {{ old('alergi_plester', $asesmenPraAnestesi->alergi_plester ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                                <label class="form-check-label small"
                                                                    for="plester_tidak">Tidak</label>
                                                            </div>
                                                            @error('alergi_plester')
                                                                <div class="invalid-feedback d-block">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label fw-bold small">Alergi Makanan</label>
                                                            <div class="form-check">
                                                                <input
                                                                    class="form-check-input @error('alergi_makanan') is-invalid @enderror"
                                                                    type="radio" name="alergi_makanan" id="makanan_ya"
                                                                    value="Ya" {{ old('alergi_makanan', $asesmenPraAnestesi->alergi_makanan ?? '') == 'Ya' ? 'checked' : '' }}>
                                                                <label class="form-check-label small"
                                                                    for="makanan_ya">Ya</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input
                                                                    class="form-check-input @error('alergi_makanan') is-invalid @enderror"
                                                                    type="radio" name="alergi_makanan" id="makanan_tidak"
                                                                    value="Tidak" {{ old('alergi_makanan', $asesmenPraAnestesi->alergi_makanan ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                                <label class="form-check-label small"
                                                                    for="makanan_tidak">Tidak</label>
                                                            </div>
                                                            @error('alergi_makanan')
                                                                <div class="invalid-feedback d-block">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
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
                                                        <input
                                                            class="form-check-input @error('rk_perdarahan') is-invalid @enderror"
                                                            type="radio" name="rk_perdarahan" value="Ya" {{ old('rk_perdarahan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_perdarahan ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rk_perdarahan') is-invalid @enderror"
                                                            type="radio" name="rk_perdarahan" value="Tidak" {{ old('rk_perdarahan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_perdarahan ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rk_perdarahan')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Pembekuan Darah Tidak Normal</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rk_pembekuan') is-invalid @enderror"
                                                            type="radio" name="rk_pembekuan" value="Ya" {{ old('rk_pembekuan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_pembekuan ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rk_pembekuan') is-invalid @enderror"
                                                            type="radio" name="rk_pembekuan" value="Tidak" {{ old('rk_pembekuan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_pembekuan ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rk_pembekuan')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Permasalahan dalam Pembiusan</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rk_anestesi') is-invalid @enderror"
                                                            type="radio" name="rk_anestesi" value="Ya" {{ old('rk_anestesi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_anestesi ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rk_anestesi') is-invalid @enderror"
                                                            type="radio" name="rk_anestesi" value="Tidak" {{ old('rk_anestesi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_anestesi ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rk_anestesi')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Operasi Jantung Koroner</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rk_operasi_jantung') is-invalid @enderror"
                                                            type="radio" name="rk_operasi_jantung" value="Ya" {{ old('rk_operasi_jantung', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_operasi_jantung ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rk_operasi_jantung') is-invalid @enderror"
                                                            type="radio" name="rk_operasi_jantung" value="Tidak" {{ old('rk_operasi_jantung', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_operasi_jantung ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rk_operasi_jantung')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Diabetes Mellitus</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rk_diabetes') is-invalid @enderror"
                                                            type="radio" name="rk_diabetes" value="Ya" {{ old('rk_diabetes', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_diabetes ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rk_diabetes') is-invalid @enderror"
                                                            type="radio" name="rk_diabetes" value="Tidak" {{ old('rk_diabetes', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_diabetes ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rk_diabetes')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Serangan Jantung</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rk_serangan_jantung') is-invalid @enderror"
                                                            type="radio" name="rk_serangan_jantung" value="Ya" {{ old('rk_serangan_jantung', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_serangan_jantung ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rk_serangan_jantung') is-invalid @enderror"
                                                            type="radio" name="rk_serangan_jantung" value="Tidak" {{ old('rk_serangan_jantung', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_serangan_jantung ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rk_serangan_jantung')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Hipertensi</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rk_hipertensi') is-invalid @enderror"
                                                            type="radio" name="rk_hipertensi" value="Ya" {{ old('rk_hipertensi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_hipertensi ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rk_hipertensi') is-invalid @enderror"
                                                            type="radio" name="rk_hipertensi" value="Tidak" {{ old('rk_hipertensi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_hipertensi ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rk_hipertensi')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tuberkulosis</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rk_tuberkulosis') is-invalid @enderror"
                                                            type="radio" name="rk_tuberkulosis" value="Ya" {{ old('rk_tuberkulosis', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_tuberkulosis ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rk_tuberkulosis') is-invalid @enderror"
                                                            type="radio" name="rk_tuberkulosis" value="Tidak" {{ old('rk_tuberkulosis', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_tuberkulosis ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rk_tuberkulosis')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Penyakit Berat Lainnya</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rk_penyakit_lain') is-invalid @enderror"
                                                            type="radio" name="rk_penyakit_lain" value="Ya" {{ old('rk_penyakit_lain', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_penyakit_lain ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rk_penyakit_lain') is-invalid @enderror"
                                                            type="radio" name="rk_penyakit_lain" value="Tidak" {{ old('rk_penyakit_lain', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_penyakit_lain ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rk_penyakit_lain')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Jelaskan Penyakit Keluarga Apabila Dijawab
                                            "Ya"</label>
                                        <textarea class="form-control @error('rk_keterangan') is-invalid @enderror"
                                            name="rk_keterangan" rows="4"
                                            placeholder="Jelaskan detail penyakit keluarga">{{ old('rk_keterangan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->rk_keterangan ?? '') }}</textarea>
                                        @error('rk_keterangan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                                                    <input class="form-check-input @error('bahasa') is-invalid @enderror"
                                                        type="radio" name="bahasa" id="bahasa_indonesia" value="Indonesia"
                                                        {{ old('bahasa', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->bahasa ?? '') == 'Indonesia' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="bahasa_indonesia">Indonesia</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('bahasa') is-invalid @enderror"
                                                        type="radio" name="bahasa" id="bahasa_lain" value="Bahasa Lainnya"
                                                        {{ old('bahasa', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->bahasa ?? '') == 'Bahasa Lainnya' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="bahasa_lain">Lainnya:</label>
                                                    <input type="text"
                                                        class="form-control mt-2 @error('bahasa_lain') is-invalid @enderror"
                                                        name="bahasa_lain" placeholder="Sebutkan bahasa lain"
                                                        value="{{ old('bahasa_lain', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->bahasa_lain ?? '') }}">
                                                    @error('bahasa_lain')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                @error('bahasa')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Gangguan Penglihatan/Buta</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('gangguan_penglihatan') is-invalid @enderror"
                                                            type="radio" name="gangguan_penglihatan" value="Ya" {{ old('gangguan_penglihatan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->gangguan_penglihatan ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('gangguan_penglihatan') is-invalid @enderror"
                                                            type="radio" name="gangguan_penglihatan" value="Tidak" {{ old('gangguan_penglihatan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->gangguan_penglihatan ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('gangguan_penglihatan')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Gangguan Pendengaran/Tuli</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('gangguan_pendengaran') is-invalid @enderror"
                                                            type="radio" name="gangguan_pendengaran" value="Ya" {{ old('gangguan_pendengaran', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->gangguan_pendengaran ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('gangguan_pendengaran') is-invalid @enderror"
                                                            type="radio" name="gangguan_pendengaran" value="Tidak" {{ old('gangguan_pendengaran', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->gangguan_pendengaran ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('gangguan_pendengaran')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Gangguan Bicara</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('gangguan_bicara') is-invalid @enderror"
                                                            type="radio" name="gangguan_bicara" value="Ya" {{ old('gangguan_bicara', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->gangguan_bicara ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('gangguan_bicara') is-invalid @enderror"
                                                            type="radio" name="gangguan_bicara" value="Tidak" {{ old('gangguan_bicara', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRiwayatKeluarga->gangguan_bicara ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('gangguan_bicara')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
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
                                                        <input
                                                            class="form-check-input @error('rp_perdarahan') is-invalid @enderror"
                                                            type="radio" name="rp_perdarahan" value="Ya" {{ old('rp_perdarahan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_perdarahan ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_perdarahan') is-invalid @enderror"
                                                            type="radio" name="rp_perdarahan" value="Tidak" {{ old('rp_perdarahan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_perdarahan ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rp_perdarahan')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Pembekuan Darah Tidak Normal</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_pembekuan') is-invalid @enderror"
                                                            type="radio" name="rp_pembekuan" value="Ya" {{ old('rp_pembekuan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_pembekuan ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_pembekuan') is-invalid @enderror"
                                                            type="radio" name="rp_pembekuan" value="Tidak" {{ old('rp_pembekuan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_pembekuan ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rp_pembekuan')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Sakit Maag</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_maag') is-invalid @enderror"
                                                            type="radio" name="rp_maag" value="Ya" {{ old('rp_maag', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_maag ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_maag') is-invalid @enderror"
                                                            type="radio" name="rp_maag" value="Tidak" {{ old('rp_maag', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_maag ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rp_maag')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Anemia</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_anemia') is-invalid @enderror"
                                                            type="radio" name="rp_anemia" value="Ya" {{ old('rp_anemia', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_anemia ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_anemia') is-invalid @enderror"
                                                            type="radio" name="rp_anemia" value="Tidak" {{ old('rp_anemia', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_anemia ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rp_anemia')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Sesak Nafas</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_sesak') is-invalid @enderror"
                                                            type="radio" name="rp_sesak" value="Ya" {{ old('rp_sesak', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_sesak ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_sesak') is-invalid @enderror"
                                                            type="radio" name="rp_sesak" value="Tidak" {{ old('rp_sesak', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_sesak ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rp_sesak')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Asma</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_asma') is-invalid @enderror"
                                                            type="radio" name="rp_asma" value="Ya" {{ old('rp_asma', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_asma ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_asma') is-invalid @enderror"
                                                            type="radio" name="rp_asma" value="Tidak" {{ old('rp_asma', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_asma ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rp_asma')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Diabetes Mellitus</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_diabetes') is-invalid @enderror"
                                                            type="radio" name="rp_diabetes" value="Ya" {{ old('rp_diabetes', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_diabetes ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_diabetes') is-invalid @enderror"
                                                            type="radio" name="rp_diabetes" value="Tidak" {{ old('rp_diabetes', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_diabetes ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rp_diabetes')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Pingsan</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_pingsan') is-invalid @enderror"
                                                            type="radio" name="rp_pingsan" value="Ya" {{ old('rp_pingsan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_pingsan ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_pingsan') is-invalid @enderror"
                                                            type="radio" name="rp_pingsan" value="Tidak" {{ old('rp_pingsan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_pingsan ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rp_pingsan')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Serangan Jantung</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_serangan_jantung') is-invalid @enderror"
                                                            type="radio" name="rp_serangan_jantung" value="Ya" {{ old('rp_serangan_jantung', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_serangan_jantung ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_serangan_jantung') is-invalid @enderror"
                                                            type="radio" name="rp_serangan_jantung" value="Tidak" {{ old('rp_serangan_jantung', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_serangan_jantung ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rp_serangan_jantung')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Hepatitis</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_hepatitis') is-invalid @enderror"
                                                            type="radio" name="rp_hepatitis" value="Ya" {{ old('rp_hepatitis', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_hepatitis ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_hepatitis') is-invalid @enderror"
                                                            type="radio" name="rp_hepatitis" value="Tidak" {{ old('rp_hepatitis', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_hepatitis ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rp_hepatitis')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Hipertensi</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_hipertensi') is-invalid @enderror"
                                                            type="radio" name="rp_hipertensi" value="Ya" {{ old('rp_hipertensi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_hipertensi ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_hipertensi') is-invalid @enderror"
                                                            type="radio" name="rp_hipertensi" value="Tidak" {{ old('rp_hipertensi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_hipertensi ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rp_hipertensi')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Sumbatan Jalan Nafas</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_sumbatan_nafas') is-invalid @enderror"
                                                            type="radio" name="rp_sumbatan_nafas" value="Ya" {{ old('rp_sumbatan_nafas', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_sumbatan_nafas ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_sumbatan_nafas') is-invalid @enderror"
                                                            type="radio" name="rp_sumbatan_nafas" value="Tidak" {{ old('rp_sumbatan_nafas', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_sumbatan_nafas ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rp_sumbatan_nafas')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tidur Mengorok</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_mengorok') is-invalid @enderror"
                                                            type="radio" name="rp_mengorok" value="Ya" {{ old('rp_mengorok', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_mengorok ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_mengorok') is-invalid @enderror"
                                                            type="radio" name="rp_mengorok" value="Tidak" {{ old('rp_mengorok', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_mengorok ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rp_mengorok')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Penyakit Berat Lainnya</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_penyakit_lain') is-invalid @enderror"
                                                            type="radio" name="rp_penyakit_lain" value="Ya" {{ old('rp_penyakit_lain', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_penyakit_lain ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('rp_penyakit_lain') is-invalid @enderror"
                                                            type="radio" name="rp_penyakit_lain" value="Tidak" {{ old('rp_penyakit_lain', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_penyakit_lain ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('rp_penyakit_lain')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Jelaskan Penyakit Pasien Apabila Dijawab
                                            "Ya"</label>
                                        <textarea class="form-control @error('rp_keterangan') is-invalid @enderror"
                                            name="rp_keterangan" rows="4"
                                            placeholder="Jelaskan detail penyakit yang pernah diderita">{{ old('rp_keterangan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->rp_keterangan ?? '') }}</textarea>
                                        @error('rp_keterangan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                                                        <input
                                                            class="form-check-input @error('transfusi_darah') is-invalid @enderror"
                                                            type="radio" name="transfusi_darah" value="Ya" {{ old('transfusi_darah', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->transfusi_darah ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('transfusi_darah') is-invalid @enderror"
                                                            type="radio" name="transfusi_darah" value="Tidak" {{ old('transfusi_darah', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->transfusi_darah ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('transfusi_darah')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <input type="text"
                                                    class="form-control @error('transfusi_tahun') is-invalid @enderror"
                                                    name="transfusi_tahun" placeholder="Bila Ya, tahun berapa?"
                                                    value="{{ old('transfusi_tahun', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->transfusi_tahun ?? '') }}">
                                                @error('transfusi_tahun')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Apakah Pasien Pernah Diperiksa untuk
                                                    Diagnosis HIV?</label>
                                                <div class="d-flex gap-3 mb-2">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('periksa_hiv') is-invalid @enderror"
                                                            type="radio" name="periksa_hiv" value="Ya" {{ old('periksa_hiv', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->periksa_hiv ?? '') == 'Ya' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input @error('periksa_hiv') is-invalid @enderror"
                                                            type="radio" name="periksa_hiv" value="Tidak" {{ old('periksa_hiv', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->periksa_hiv ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tidak</label>
                                                    </div>
                                                </div>
                                                @error('periksa_hiv')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <input type="text"
                                                    class="form-control @error('hiv_tahun') is-invalid @enderror"
                                                    name="hiv_tahun" placeholder="Bila Ya, tahun berapa?"
                                                    value="{{ old('hiv_tahun', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->hiv_tahun ?? '') }}">
                                                @error('hiv_tahun')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Hasil Pemeriksaan HIV</label>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('hasil_hiv') is-invalid @enderror"
                                                        type="radio" name="hasil_hiv" value="Positif" {{ old('hasil_hiv', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->hasil_hiv ?? '') == 'Positif' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Positif</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('hasil_hiv') is-invalid @enderror"
                                                        type="radio" name="hasil_hiv" value="Negatif" {{ old('hasil_hiv', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->hasil_hiv ?? '') == 'Negatif' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Negatif</label>
                                                </div>
                                                @error('hasil_hiv')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Apakah Pasien Memakai:</label>
                                                <div class="row mt-2">
                                                    <div class="col-4">
                                                        <label class="form-label fw-bold small">Lensa Kontak</label>
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input @error('lensa_kontak') is-invalid @enderror"
                                                                type="radio" name="lensa_kontak" value="Ya" {{ old('lensa_kontak', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->lensa_kontak ?? '') == 'Ya' ? 'checked' : '' }}>
                                                            <label class="form-check-label small">Ya</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input @error('lensa_kontak') is-invalid @enderror"
                                                                type="radio" name="lensa_kontak" value="Tidak" {{ old('lensa_kontak', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->lensa_kontak ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                            <label class="form-check-label small">Tidak</label>
                                                        </div>
                                                        @error('lensa_kontak')
                                                            <div class="invalid-feedback d-block">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label fw-bold small">Alat Bantu Dengar</label>
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input @error('alat_bantu_dengar') is-invalid @enderror"
                                                                type="radio" name="alat_bantu_dengar" value="Ya" {{ old('alat_bantu_dengar', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->alat_bantu_dengar ?? '') == 'Ya' ? 'checked' : '' }}>
                                                            <label class="form-check-label small">Ya</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input @error('alat_bantu_dengar') is-invalid @enderror"
                                                                type="radio" name="alat_bantu_dengar" value="Tidak" {{ old('alat_bantu_dengar', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->alat_bantu_dengar ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                            <label class="form-check-label small">Tidak</label>
                                                        </div>
                                                        @error('alat_bantu_dengar')
                                                            <div class="invalid-feedback d-block">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label fw-bold small">Gigi Palsu</label>
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input @error('gigi_palsu') is-invalid @enderror"
                                                                type="radio" name="gigi_palsu" value="Ya" {{ old('gigi_palsu', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->gigi_palsu ?? '') == 'Ya' ? 'checked' : '' }}>
                                                            <label class="form-check-label small">Ya</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input @error('gigi_palsu') is-invalid @enderror"
                                                                type="radio" name="gigi_palsu" value="Tidak" {{ old('gigi_palsu', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->gigi_palsu ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                            <label class="form-check-label small">Tidak</label>
                                                        </div>
                                                        @error('gigi_palsu')
                                                            <div class="invalid-feedback d-block">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Riwayat, Tahun, dan Jenis Operasi</label>
                                        <textarea class="form-control @error('riwayat_operasi') is-invalid @enderror"
                                            name="riwayat_operasi" rows="3"
                                            placeholder="Sebutkan jenis operasi dan tahunnya">{{ old('riwayat_operasi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->riwayat_operasi ?? '') }}</textarea>
                                        @error('riwayat_operasi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Jenis Anestesi yang Digunakan dan
                                            Komplikasi/Reaksi yang Dialami</label>
                                        <textarea class="form-control @error('jenis_anestesi_sebelum') is-invalid @enderror"
                                            name="jenis_anestesi_sebelum" rows="3"
                                            placeholder="Jelaskan jenis anestesi dan komplikasi jika ada">{{ old('jenis_anestesi_sebelum', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->jenis_anestesi_sebelum ?? '') }}</textarea>
                                        @error('jenis_anestesi_sebelum')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tanggal Terakhir Diperiksa Kesehatan ke
                                                    Dokter</label>
                                                <input type="date"
                                                    class="form-control @error('tanggal_periksa_terakhir') is-invalid @enderror"
                                                    name="tanggal_periksa_terakhir"
                                                    value="{{ old('tanggal_periksa_terakhir', optional($asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml)->tanggal_periksa_terakhir ? \Carbon\Carbon::parse($asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->tanggal_periksa_terakhir)->format('Y-m-d') : '') }}">
                                                @error('tanggal_periksa_terakhir')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Di</label>
                                                <input type="text"
                                                    class="form-control @error('tempat_periksa_terakhir') is-invalid @enderror"
                                                    name="tempat_periksa_terakhir" placeholder="Tempat pemeriksaan"
                                                    value="{{ old('tempat_periksa_terakhir', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->tempat_periksa_terakhir ?? '') }}">
                                                @error('tempat_periksa_terakhir')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Untuk Penyakit Gangguan Apa</label>
                                        <textarea class="form-control @error('gangguan_periksa') is-invalid @enderror"
                                            name="gangguan_periksa" rows="3"
                                            placeholder="Jelaskan gangguan/penyakit yang diperiksa">{{ old('gangguan_periksa', $asesmenPraAnestesi->rmeAsesmenPraAnestesiRppRml->gangguan_periksa ?? '') }}</textarea>
                                        @error('gangguan_periksa')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                                                <input type="number"
                                                    class="form-control @error('jumlah_kehamilan') is-invalid @enderror"
                                                    name="jumlah_kehamilan" placeholder="0" min="0"
                                                    value="{{ old('jumlah_kehamilan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->jumlah_kehamilan ?? '') }}">
                                                @error('jumlah_kehamilan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jumlah Anak</label>
                                                <input type="number"
                                                    class="form-control @error('jumlah_anak') is-invalid @enderror"
                                                    name="jumlah_anak" placeholder="0" min="0"
                                                    value="{{ old('jumlah_anak', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->jumlah_anak ?? '') }}">
                                                @error('jumlah_anak')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Menstruasi Terakhir</label>
                                                <input type="date"
                                                    class="form-control @error('menstruasi_terakhir') is-invalid @enderror"
                                                    name="menstruasi_terakhir"
                                                    value="{{ old('menstruasi_terakhir', optional($asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs)->menstruasi_terakhir ? \Carbon\Carbon::parse($asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->menstruasi_terakhir)->format('Y-m-d') : '') }}">
                                                @error('menstruasi_terakhir')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Menyusui</label>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('menyusui') is-invalid @enderror"
                                                        type="radio" name="menyusui" value="Ya" {{ old('menyusui', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->menyusui ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('menyusui') is-invalid @enderror"
                                                        type="radio" name="menyusui" value="Tidak" {{ old('menyusui', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->menyusui ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                                @error('menyusui')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kajian Sistem -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <p class="fw-bold">Diisi Oleh Dokter</p>
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-stethoscope me-2"></i>Kajian
                                        Sistem</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Hilangnya Gigi</label>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('hilangnya_gigi') is-invalid @enderror"
                                                        type="radio" name="hilangnya_gigi" value="Ya" {{ old('hilangnya_gigi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->hilangnya_gigi ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('hilangnya_gigi') is-invalid @enderror"
                                                        type="radio" name="hilangnya_gigi" value="Tidak" {{ old('hilangnya_gigi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->hilangnya_gigi ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                                @error('hilangnya_gigi')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Masalah Mobilitas Leher</label>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('masalah_mobilitas_leher') is-invalid @enderror"
                                                        type="radio" name="masalah_mobilitas_leher" value="Ya" {{ old('masalah_mobilitas_leher', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->masalah_mobilitas_leher ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('masalah_mobilitas_leher') is-invalid @enderror"
                                                        type="radio" name="masalah_mobilitas_leher" value="Tidak" {{ old('masalah_mobilitas_leher', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->masalah_mobilitas_leher ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                                @error('masalah_mobilitas_leher')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Leher Pendek</label>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('leher_pendek') is-invalid @enderror"
                                                        type="radio" name="leher_pendek" value="Ya" {{ old('leher_pendek', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->leher_pendek ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('leher_pendek') is-invalid @enderror"
                                                        type="radio" name="leher_pendek" value="Tidak" {{ old('leher_pendek', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->leher_pendek ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                                @error('leher_pendek')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Batuk</label>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('batuk') is-invalid @enderror"
                                                        type="radio" name="batuk" value="Ya" {{ old('batuk', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->batuk ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('batuk') is-invalid @enderror"
                                                        type="radio" name="batuk" value="Tidak" {{ old('batuk', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->batuk ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                                @error('batuk')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Sesak Nafas</label>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('sesak_nafas') is-invalid @enderror"
                                                        type="radio" name="sesak_nafas" value="Ya" {{ old('sesak_nafas', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->sesak_nafas ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('sesak_nafas') is-invalid @enderror"
                                                        type="radio" name="sesak_nafas" value="Tidak" {{ old('sesak_nafas', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->sesak_nafas ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                                @error('sesak_nafas')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Baru Saja Menderita Infeksi</label>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('baru_saja_infeksi') is-invalid @enderror"
                                                        type="radio" name="baru_saja_infeksi" value="Ya" {{ old('baru_saja_infeksi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->baru_saja_infeksi ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('baru_saja_infeksi') is-invalid @enderror"
                                                        type="radio" name="baru_saja_infeksi" value="Tidak" {{ old('baru_saja_infeksi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->baru_saja_infeksi ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                                @error('baru_saja_infeksi')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Menstruasi Tidak Normal</label>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('menstruasi_tidak_normal') is-invalid @enderror"
                                                        type="radio" name="menstruasi_tidak_normal" value="Ya" {{ old('menstruasi_tidak_normal', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->menstruasi_tidak_normal ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('menstruasi_tidak_normal') is-invalid @enderror"
                                                        type="radio" name="menstruasi_tidak_normal" value="Tidak" {{ old('menstruasi_tidak_normal', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->menstruasi_tidak_normal ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                                @error('menstruasi_tidak_normal')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Pingsan</label>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('pingsan') is-invalid @enderror"
                                                        type="radio" name="pingsan" value="Ya" {{ old('pingsan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->pingsan ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('pingsan') is-invalid @enderror"
                                                        type="radio" name="pingsan" value="Tidak" {{ old('pingsan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->pingsan ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                                @error('pingsan')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Sakit Dada</label>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('sakit_dada') is-invalid @enderror"
                                                        type="radio" name="sakit_dada" value="Ya" {{ old('sakit_dada', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->sakit_dada ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('sakit_dada') is-invalid @enderror"
                                                        type="radio" name="sakit_dada" value="Tidak" {{ old('sakit_dada', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->sakit_dada ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                                @error('sakit_dada')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Denyut Jantung Tidak Normal</label>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('denyut_jantung_tidak_normal') is-invalid @enderror"
                                                        type="radio" name="denyut_jantung_tidak_normal" value="Ya" {{ old('denyut_jantung_tidak_normal', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->denyut_jantung_tidak_normal ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('denyut_jantung_tidak_normal') is-invalid @enderror"
                                                        type="radio" name="denyut_jantung_tidak_normal" value="Tidak" {{ old('denyut_jantung_tidak_normal', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->denyut_jantung_tidak_normal ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                                @error('denyut_jantung_tidak_normal')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Muntah</label>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('muntah') is-invalid @enderror"
                                                        type="radio" name="muntah" value="Ya" {{ old('muntah', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->muntah ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('muntah') is-invalid @enderror"
                                                        type="radio" name="muntah" value="Tidak" {{ old('muntah', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->muntah ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                                @error('muntah')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Susah BAK</label>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('susaah_bak') is-invalid @enderror"
                                                        type="radio" name="susaah_bak" value="Ya" {{ old('susaah_bak', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->susaah_bak ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('susaah_bak') is-invalid @enderror"
                                                        type="radio" name="susaah_bak" value="Tidak" {{ old('susaah_bak', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->susaah_bak ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                                @error('susaah_bak')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Kejang</label>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('kejang') is-invalid @enderror"
                                                        type="radio" name="kejang" value="Ya" {{ old('kejang', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->kejang ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('kejang') is-invalid @enderror"
                                                        type="radio" name="kejang" value="Tidak" {{ old('kejang', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->kejang ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                                @error('kejang')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Sedang Hamil</label>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('sedang_hamil') is-invalid @enderror"
                                                        type="radio" name="sedang_hamil" value="Ya" {{ old('sedang_hamil', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->sedang_hamil ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input @error('sedang_hamil') is-invalid @enderror"
                                                        type="radio" name="sedang_hamil" value="Tidak" {{ old('sedang_hamil', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->sedang_hamil ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                                @error('sedang_hamil')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Stroke</label>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('stroke') is-invalid @enderror"
                                                        type="radio" name="stroke" value="Ya" {{ old('stroke', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->stroke ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('stroke') is-invalid @enderror"
                                                        type="radio" name="stroke" value="Tidak" {{ old('stroke', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->stroke ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                                @error('stroke')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Obesitas</label>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('obesitas') is-invalid @enderror"
                                                        type="radio" name="obesitas" value="Ya" {{ old('obesitas', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->obesitas ?? '') == 'Ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input @error('obesitas') is-invalid @enderror"
                                                        type="radio" name="obesitas" value="Tidak" {{ old('obesitas', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->obesitas ?? '') == 'Tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label">Tidak</label>
                                                </div>
                                                @error('obesitas')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Saluran nafas atas:</label>
                                        <textarea class="form-control @error('saluran_nafas_atas') is-invalid @enderror"
                                            name="saluran_nafas_atas" rows="4"
                                            placeholder="Jelaskan detail penyakit yang pernah diderita">{{ old('saluran_nafas_atas', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKppKs->saluran_nafas_atas ?? '') }}</textarea>
                                        @error('saluran_nafas_atas')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                                                <select class="form-select" name="kesadaran">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="Compos Mentis" {{ old('kesadaran', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->kesadaran ?? '') == 'Compos Mentis' ? 'selected' : '' }}>Compos Mentis</option>
                                                    <option value="Apatis" {{ old('kesadaran', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->kesadaran ?? '') == 'Apatis' ? 'selected' : '' }}>Apatis</option>
                                                    <option value="Sopor" {{ old('kesadaran', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->kesadaran ?? '') == 'Sopor' ? 'selected' : '' }}>Sopor</option>
                                                    <option value="Coma" {{ old('kesadaran', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->kesadaran ?? '') == 'Coma' ? 'selected' : '' }}>Coma</option>
                                                    <option value="Somnolen" {{ old('kesadaran', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->kesadaran ?? '') == 'Somnolen' ? 'selected' : '' }}>Somnolen</option>
                                                </select>
                                            </div>                                            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Visus</label>
                                                <input type="text" class="form-control @error('visus') is-invalid @enderror"
                                                    name="visus" placeholder="Masukkan visus"
                                                    value="{{ old('visus', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->visus ?? '') }}">
                                                @error('visus')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Faring</label>
                                                <input type="text"
                                                    class="form-control @error('faring') is-invalid @enderror" name="faring"
                                                    placeholder="Masukkan faring"
                                                    value="{{ old('faring', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->faring ?? '') }}">
                                                @error('faring')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Gigi Palsu</label>
                                                <input type="text"
                                                    class="form-control @error('gigi_palus') is-invalid @enderror"
                                                    name="gigi_palus" placeholder="Masukkan gigi palsu"
                                                    value="{{ old('gigi_palus', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->gigi_palus ?? '') }}">
                                                @error('gigi_palus')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Keterangan:</label>
                                                <textarea
                                                    class="form-control @error('keadaan_umum_keterangan') is-invalid @enderror"
                                                    name="keadaan_umum_keterangan" rows="4"
                                                    placeholder="Masukkan keterangan keadaan umum">{{ old('keadaan_umum_keterangan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->keadaan_umum_keterangan ?? '') }}</textarea>
                                                @error('keadaan_umum_keterangan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
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
                                                <input type="text" class="form-control @error('bb') is-invalid @enderror"
                                                    name="bb" placeholder="Berat Badan (kg)"
                                                    value="{{ old('bb', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->bb ?? '') }}">
                                                @error('bb')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">TD</label>
                                                <input type="text" class="form-control @error('td') is-invalid @enderror"
                                                    name="td" placeholder="Tekanan Darah (contoh: 120/80)"
                                                    value="{{ old('td', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->td ?? '') }}">
                                                @error('td')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Nadi</label>
                                                <input type="text" class="form-control @error('nadi') is-invalid @enderror"
                                                    name="nadi" placeholder="Nadi (x/menit)"
                                                    value="{{ old('nadi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->nadi ?? '') }}">
                                                @error('nadi')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Suhu</label>
                                                <input type="text" class="form-control @error('suhu') is-invalid @enderror"
                                                    name="suhu" placeholder="Suhu (°C)"
                                                    value="{{ old('suhu', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->suhu ?? '') }}">
                                                @error('suhu')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Paru-Paru</label>
                                                <input type="text" class="form-control @error('paru') is-invalid @enderror"
                                                    name="paru" placeholder="Pernapasan (x/menit)"
                                                    value="{{ old('paru', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->paru ?? '') }}">
                                                @error('paru')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jantung</label>
                                                <input type="text"
                                                    class="form-control @error('jantung') is-invalid @enderror"
                                                    name="jantung" placeholder="Kondisi jantung"
                                                    value="{{ old('jantung', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->jantung ?? '') }}">
                                                @error('jantung')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Abdomen</label>
                                                <input type="text"
                                                    class="form-control @error('abdomen') is-invalid @enderror"
                                                    name="abdomen" placeholder="Kondisi abdomen"
                                                    value="{{ old('abdomen', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->abdomen ?? '') }}">
                                                @error('abdomen')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Ekstremitas</label>
                                                <input type="text"
                                                    class="form-control @error('ekstremitas') is-invalid @enderror"
                                                    name="ekstremitas" placeholder="Kondisi ekstremitas"
                                                    value="{{ old('ekstremitas', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->ekstremitas ?? '') }}">
                                                @error('ekstremitas')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Neurologi (jika ada ditemukan)</label>
                                                <input type="text"
                                                    class="form-control @error('neurologi') is-invalid @enderror"
                                                    name="neurologi" placeholder="Kondisi neurologi"
                                                    value="{{ old('neurologi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->neurologi ?? '') }}">
                                                @error('neurologi')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Keterangan:</label>
                                        <textarea
                                            class="form-control @error('pemeriksaan_fisik_keterangan') is-invalid @enderror"
                                            name="pemeriksaan_fisik_keterangan" rows="4"
                                            placeholder="Masukkan keterangan pemeriksaan fisik">{{ old('pemeriksaan_fisik_keterangan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->pemeriksaan_fisik_keterangan ?? '') }}</textarea>
                                        @error('pemeriksaan_fisik_keterangan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Laboratorium -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-vial me-2"></i>Laboratorium</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Hb/Leuco/Thrombo</label>
                                                <input type="text"
                                                    class="form-control @error('hb_leuco_thrombo') is-invalid @enderror"
                                                    name="hb_leuco_thrombo" placeholder="Hasil pemeriksaan"
                                                    value="{{ old('hb_leuco_thrombo', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->hb_leuco_thrombo ?? '') }}">
                                                @error('hb_leuco_thrombo')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">PT/APTT</label>
                                                <input type="text"
                                                    class="form-control @error('pt_aptt') is-invalid @enderror"
                                                    name="pt_aptt" placeholder="Hasil pemeriksaan"
                                                    value="{{ old('pt_aptt', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->pt_aptt ?? '') }}">
                                                @error('pt_aptt')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tes Kreatinin</label>
                                                <input type="text"
                                                    class="form-control @error('tes_kreatinin') is-invalid @enderror"
                                                    name="tes_kreatinin" placeholder="Hasil pemeriksaan"
                                                    value="{{ old('tes_kreatinin', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->tes_kreatinin ?? '') }}">
                                                @error('tes_kreatinin')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Ureum</label>
                                                <input type="text" class="form-control @error('ureum') is-invalid @enderror"
                                                    name="ureum" placeholder="Hasil pemeriksaan"
                                                    value="{{ old('ureum', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->ureum ?? '') }}">
                                                @error('ureum')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">EKG</label>
                                                <input type="text" class="form-control @error('ekg') is-invalid @enderror"
                                                    name="ekg" placeholder="Hasil pemeriksaan"
                                                    value="{{ old('ekg', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->ekg ?? '') }}">
                                                @error('ekg')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Na/Cl/K</label>
                                                <input type="text"
                                                    class="form-control @error('na_cl_k') is-invalid @enderror"
                                                    name="na_cl_k" placeholder="Hasil pemeriksaan"
                                                    value="{{ old('na_cl_k', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->na_cl_k ?? '') }}">
                                                @error('na_cl_k')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">CO2</label>
                                                <input type="text" class="form-control @error('co2') is-invalid @enderror"
                                                    name="co2" placeholder="Hasil pemeriksaan"
                                                    value="{{ old('co2', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->co2 ?? '') }}">
                                                @error('co2')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">CT Scan</label>
                                                <input type="text"
                                                    class="form-control @error('ct_scan') is-invalid @enderror"
                                                    name="ct_scan" placeholder="Hasil pemeriksaan"
                                                    value="{{ old('ct_scan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->ct_scan ?? '') }}">
                                                @error('ct_scan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">MRI</label>
                                                <input type="text" class="form-control @error('mri') is-invalid @enderror"
                                                    name="mri" placeholder="Hasil pemeriksaan"
                                                    value="{{ old('mri', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->mri ?? '') }}">
                                                @error('mri')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">USG</label>
                                                <input type="text" class="form-control @error('usg') is-invalid @enderror"
                                                    name="usg" placeholder="Hasil pemeriksaan"
                                                    value="{{ old('usg', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->usg ?? '') }}">
                                                @error('usg')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Lain-lain</label>
                                                <input type="text"
                                                    class="form-control @error('laboratorium_lain') is-invalid @enderror"
                                                    name="laboratorium_lain" placeholder="Hasil pemeriksaan lain"
                                                    value="{{ old('laboratorium_lain', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->laboratorium_lain ?? '') }}">
                                                @error('laboratorium_lain')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Keterangan:</label>
                                        <textarea
                                            class="form-control @error('laboratorium_keterangan') is-invalid @enderror"
                                            name="laboratorium_keterangan" rows="4"
                                            placeholder="Masukkan keterangan hasil laboratorium">{{ old('laboratorium_keterangan', $asesmenPraAnestesi->rmeAsesmenPraAnestesiKuPfLaboratorium->laboratorium_keterangan ?? '') }}</textarea>
                                        @error('laboratorium_keterangan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                                            <input class="form-check-input @error('asa_klasifikasi') is-invalid @enderror"
                                                type="radio" name="asa_klasifikasi" value="ASA 1" {{ old('asa_klasifikasi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo->asa_klasifikasi ?? '') == 'ASA 1' ? 'checked' : '' }}>
                                            <label class="form-check-label">ASA 1 - Pasien sehat normal dan sehat</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input @error('asa_klasifikasi') is-invalid @enderror"
                                                type="radio" name="asa_klasifikasi" value="ASA 2" {{ old('asa_klasifikasi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo->asa_klasifikasi ?? '') == 'ASA 2' ? 'checked' : '' }}>
                                            <label class="form-check-label">ASA 2 - Pasien dengan penyakit sistemik
                                                ringan</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input @error('asa_klasifikasi') is-invalid @enderror"
                                                type="radio" name="asa_klasifikasi" value="ASA 3" {{ old('asa_klasifikasi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo->asa_klasifikasi ?? '') == 'ASA 3' ? 'checked' : '' }}>
                                            <label class="form-check-label">ASA 3 - Pasien dengan penyakit sistemik
                                                berat</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input @error('asa_klasifikasi') is-invalid @enderror"
                                                type="radio" name="asa_klasifikasi" value="ASA 4" {{ old('asa_klasifikasi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo->asa_klasifikasi ?? '') == 'ASA 4' ? 'checked' : '' }}>
                                            <label class="form-check-label">ASA 4 - Pasien dengan penyakit sistemik berat
                                                yang mengancam nyawa</label>
                                        </div>
                                        @error('asa_klasifikasi')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">Rekomendasi tindakan anestesi yang dipilih</label>
                                        <div class="mt-2">
                                            @php
                                                // Ambil data yang sudah ada (untuk mode edit)
                                                $selectedOptions = [];
                                                
                                                // Perbaikan: Menggunakan relasi yang benar berdasarkan controller
                                                if (isset($asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo->rekomendasi_tindakan_anestesi)) {
                                                    $jsonData = $asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo->rekomendasi_tindakan_anestesi;
                                                    if (!empty($jsonData)) {
                                                        $selectedOptions = json_decode($jsonData, true) ?? [];
                                                    }
                                                }
                                                
                                                // Jika ada old input (setelah validation error) - prioritas lebih tinggi
                                                if (old('rekomendasi_tindakan_anestesi')) {
                                                    $selectedOptions = old('rekomendasi_tindakan_anestesi');
                                                }
                                            @endphp

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="rekomendasi_tindakan_anestesi[]" 
                                                    value="Anestesi umum Intravena" id="anestesi_umum_intravena"
                                                    {{ in_array('Anestesi umum Intravena', $selectedOptions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="anestesi_umum_intravena">
                                                    Anestesi umum Intravena
                                                </label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="rekomendasi_tindakan_anestesi[]" 
                                                    value="Sungkup muka" id="sungkup_muka"
                                                    {{ in_array('Sungkup muka', $selectedOptions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="sungkup_muka">
                                                    Sungkup muka
                                                </label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="rekomendasi_tindakan_anestesi[]" 
                                                    value="Laringeal mask airway" id="laringeal_mask_airway"
                                                    {{ in_array('Laringeal mask airway', $selectedOptions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="laringeal_mask_airway">
                                                    Laringeal mask airway
                                                </label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="rekomendasi_tindakan_anestesi[]" 
                                                    value="Pipa endotrakeal tube" id="pipa_endotrakeal_tube"
                                                    {{ in_array('Pipa endotrakeal tube', $selectedOptions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pipa_endotrakeal_tube">
                                                    Pipa endotrakeal tube
                                                </label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="rekomendasi_tindakan_anestesi[]" 
                                                    value="Regional anestesi: Spinal Anastesi Blok" id="regional_spinal"
                                                    {{ in_array('Regional anestesi: Spinal Anastesi Blok', $selectedOptions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="regional_spinal">
                                                    Regional anestesi: Spinal Anastesi Blok
                                                </label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="rekomendasi_tindakan_anestesi[]" 
                                                    value="Epidural" id="epidural"
                                                    {{ in_array('Epidural', $selectedOptions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="epidural">
                                                    Epidural
                                                </label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="rekomendasi_tindakan_anestesi[]" 
                                                    value="Kombinasi Spinal Epidural" id="kombinasi_spinal_epidural"
                                                    {{ in_array('Kombinasi Spinal Epidural', $selectedOptions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kombinasi_spinal_epidural">
                                                    Kombinasi Spinal Epidural
                                                </label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="rekomendasi_tindakan_anestesi[]" 
                                                    value="Peripheral Nerve Block" id="peripheral_nerve_block"
                                                    {{ in_array('Peripheral Nerve Block', $selectedOptions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="peripheral_nerve_block">
                                                    Peripheral Nerve Block
                                                </label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="rekomendasi_tindakan_anestesi[]" 
                                                    value="Anestesi umum + Regional Anestesi" id="anestesi_kombinasi"
                                                    {{ in_array('Anestesi umum + Regional Anestesi', $selectedOptions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="anestesi_kombinasi">
                                                    Anestesi umum + Regional Anestesi
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Puasa mulai -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-calendar me-2"></i>Puasa mulai
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Puasa mulai</label>
                                                <input type="date"
                                                    class="form-control @error('pusa_mulai') is-invalid @enderror"
                                                    name="pusa_mulai"
                                                    value="{{ old('pusa_mulai', optional($asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo)->pusa_mulai ? \Carbon\Carbon::parse($asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo->pusa_mulai)->format('Y-m-d') : '') }}">
                                                @error('pusa_mulai')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jam</label>
                                                <input type="time"
                                                    class="form-control @error('pusa_mulai_jam') is-invalid @enderror"
                                                    name="pusa_mulai_jam"
                                                    value="{{ old('pusa_mulai_jam', optional($asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo)->pusa_mulai_jam ? \Carbon\Carbon::parse($asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo->pusa_mulai_jam)->format('H:i') : '') }}">
                                                @error('pusa_mulai_jam')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Rencana tiba di OK -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-stethoscope me-2"></i>Rencana
                                        tiba di OK</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tanggal</label>
                                                <input type="date"
                                                    class="form-control @error('rencana_tanggal') is-invalid @enderror"
                                                    name="rencana_tanggal"
                                                    value="{{ old('rencana_tanggal', optional($asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo)->rencana_tanggal ? \Carbon\Carbon::parse($asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo->rencana_tanggal)->format('Y-m-d') : '') }}">
                                                @error('rencana_tanggal')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jam</label>
                                                <input type="time"
                                                    class="form-control @error('rencana_jam') is-invalid @enderror"
                                                    name="rencana_jam"
                                                    value="{{ old('rencana_jam', optional($asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo)->rencana_jam ? \Carbon\Carbon::parse($asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo->rencana_jam)->format('H:i') : '') }}">
                                                @error('rencana_jam')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
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
                                        {{-- <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Rencana Operasi</label>
                                                <input type="text"
                                                    class="form-control @error('rencana_operasi') is-invalid @enderror"
                                                    name="rencana_operasi" placeholder="Masukkan rencana operasi"
                                                    value="{{ old('rencana_operasi', $asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo->rencana_operasi ?? '') }}">
                                                @error('rencana_operasi')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div> --}}
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tanggal</label>
                                                <input type="date"
                                                    class="form-control @error('rencana_operasi_tanggal') is-invalid @enderror"
                                                    name="rencana_operasi_tanggal"
                                                    value="{{ old('rencana_operasi_tanggal', optional($asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo)->rencana_operasi_tanggal ? \Carbon\Carbon::parse($asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo->rencana_operasi_tanggal)->format('Y-m-d') : '') }}">
                                                @error('rencana_operasi_tanggal')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jam</label>
                                                <input type="time"
                                                    class="form-control @error('rencana_operasi_jam') is-invalid @enderror"
                                                    name="rencana_operasi_jam"
                                                    value="{{ old('rencana_operasi_jam', optional($asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo)->rencana_operasi_jam ? \Carbon\Carbon::parse($asesmenPraAnestesi->rmeAsesmenPraAnestesiDiagnosisPmRtRo->rencana_operasi_jam)->format('H:i') : '') }}">
                                                @error('rencana_operasi_jam')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
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
