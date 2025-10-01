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

        .progress-wrapper {
            background: #f8f9fa;
            border-radius: 8px;
        }

        .progress-status {
            display: flex;
            justify-content: space-between;
        }

        .progress-label {
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
        }

        .progress-percentage {
            color: #198754;
            font-weight: 600;
        }

        .custom-progress {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-custom {
            height: 100%;
            background-color: #097dd6;
            transition: width 0.6s ease;
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

        .form-group {
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
        }

        .form-group label {
            margin-right: 1rem;
            padding-top: 0.5rem;
        }

        .diagnosis-section {
            margin-top: 1.5rem;
        }

        .diagnosis-row {
            padding: 0.5rem 1rem;
            border-color: #dee2e6 !important;
        }

        .diagnosis-item {
            background-color: transparent;
        }

        .border-top {
            border-top: 1px solid #dee2e6 !important;
        }

        .border-bottom {
            border-bottom: 1px solid #dee2e6 !important;
        }

        .form-check {
            margin: 0;
            padding-left: 1.5rem;
            min-height: auto;
        }

        .form-check-input {
            margin-top: 0.3rem;
        }

        .form-check label {
            margin-right: 0;
            padding-top: 0;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        .pain-scale-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        .pain-scale-image {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .dropdown-menu {
            display: none;
            position: fixed;
            /* Ubah ke absolute */
            min-width: 300px;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, .15);
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
            z-index: 1000;
            transform: translateY(5px);
            /* Tambahkan sedikit offset */
            max-height: 400px;
            overflow-y: auto;
        }

        /* Tambahkan wrapper untuk positioning yang lebih baik */
        .dropdown-wrapper {
            position: relative;
            display: inline-block;
        }
    </style>
@endpush

@section('content')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-kep-anak')
        </div>

        <div class="col-md-9">
            <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum") }}" class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <h4 class="header-asesmen">Edit Asesmen Awal Keperawatan Perinatology</h4>
                                    <p>
                                        Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- FORM ASESMEN KEPERATAWAN perinatology --}}
                        <form method="POST"
                            action="{{ route('rawat-inap.asesmen.keperawatan.perinatology.update', [
                                $dataMedis->kd_unit,
                                $dataMedis->kd_pasien,
                                $dataMedis->tgl_masuk,
                                $dataMedis->urut_masuk,
                                $asesmen->id,
                            ]) }}">
                            @csrf
                            @method('PUT')
                            <div class="px-3">
                                {{-- 1. Data Masuk --}}
                                <div class="section-separator" id="data-masuk">
                                    <h5 class="section-title">1. Data masuk</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <input type="date" class="form-control" name="tanggal_masuk"
                                                id="tanggal_masuk"
                                                value="{{ Carbon\Carbon::parse($asesmen->waktu_asesmen)->format('Y-m-d') }}">
                                            <input type="time" class="form-control" name="jam_masuk" id="jam_masuk"
                                                value="{{ Carbon\Carbon::parse($asesmen->waktu_asesmen)->format('H:i') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2: Identitas Bayi -->
                                <div class="section-separator" id="identitas-bayi">
                                    <h5 class="section-title">2. Identitas Bayi</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal Lahir Dan Jam</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <input type="date" class="form-control" name="tanggal_lahir"
                                                value="{{ Carbon\Carbon::parse($asesmen->tgl_lahir_bayi)->format('Y-m-d') }}">
                                            <input type="time" class="form-control" name="jam_lahir"
                                                value="{{ Carbon\Carbon::parse($asesmen->tgl_lahir_bayi)->format('H:i') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nama Bayi</label>
                                        <input type="text" class="form-control" name="nama_bayi"
                                            placeholder="Masukkan nama bayi"
                                            value="{{ $asesmen->rmeAsesmenPerinatology->nama_bayi ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Jenis Kelamin</label>
                                        <select class="form-select" name="jenis_kelamin">
                                            <option value="" selected disabled>Pilih jenis kelamin</option>
                                            <option value="0" {{ ($asesmen->rmeAsesmenPerinatology->jenis_kelamin ?? '') == '0' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="1" {{ ($asesmen->rmeAsesmenPerinatology->jenis_kelamin ?? '') == '1' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nama Ibu</label>
                                        <input type="text" class="form-control" name="nama_ibu"
                                            placeholder="Masukkan nama ibu"
                                            value="{{ $asesmen->rmeAsesmenPerinatology->nama_ibu ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">NIK Ibu Kandung</label>
                                        <input type="text" class="form-control" name="nik_ibu"
                                            placeholder="Masukkan NIK ibu kandung"
                                            value="{{ $asesmen->rmeAsesmenPerinatology->nik_ibu ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Agama Orang Tua</label>
                                        <select class="form-select" name="agama_orang_tua">
                                            <option selected disabled>--Pilih--</option>
                                            <option value="Islam" {{ ($asesmen->rmeAsesmenPerinatology->agama_orang_tua ?? '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Kristen" {{ ($asesmen->rmeAsesmenPerinatology->agama_orang_tua ?? '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                            <option value="Katolik" {{ ($asesmen->rmeAsesmenPerinatology->agama_orang_tua ?? '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                            <option value="Hindu" {{ ($asesmen->rmeAsesmenPerinatology->agama_orang_tua ?? '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Budha" {{ ($asesmen->rmeAsesmenPerinatology->agama_orang_tua ?? '') == 'Budha' ? 'selected' : '' }}>Budha</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sidik Telapak Kaki Bayi</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Kaki Kiri</label>
                                                <div class="input-group mb-2">
                                                    <input type="file"
                                                        class="form-control @error('sidik_kaki_kiri') is-invalid @enderror"
                                                        name="sidik_kaki_kiri">
                                                </div>
                                                @if($asesmen->rmeAsesmenPerinatology->sidik_telapak_kaki_kiri ?? '')
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                        <small class="text-success">File sudah diunggah sebelumnya</small>
                                                        <a href="{{ Storage::url($asesmen->rmeAsesmenPerinatology->sidik_telapak_kaki_kiri) }}"
                                                        class="btn btn-sm btn-info ms-2" target="_blank">
                                                            <i class="bi bi-eye"></i> Lihat
                                                        </a>
                                                    </div>
                                                @endif
                                                <small class="text-muted">Format: JPG, PNG, PDF | Maks: 10MB</small>
                                                @error('sidik_kaki_kiri')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Kaki Kanan</label>
                                                <div class="input-group mb-2">
                                                    <input type="file"
                                                        class="form-control @error('sidik_kaki_kanan') is-invalid @enderror"
                                                        name="sidik_kaki_kanan">
                                                </div>
                                                @if($asesmen->rmeAsesmenPerinatology->sidik_telapak_kaki_kanan ?? '')
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                        <small class="text-success">File sudah diunggah sebelumnya</small>
                                                        <a href="{{ Storage::url($asesmen->rmeAsesmenPerinatology->sidik_telapak_kaki_kanan) }}"
                                                        class="btn btn-sm btn-info ms-2" target="_blank">
                                                            <i class="bi bi-eye"></i> Lihat
                                                        </a>
                                                    </div>
                                                @endif
                                                <small class="text-muted">Format: JPG, PNG, PDF | Maks: 10MB</small>
                                                @error('sidik_kaki_kanan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sidik Jari Ibu Bayi</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Jari Kiri</label>
                                                <div class="input-group mb-2">
                                                    <input type="file" class="form-control"
                                                        name="sidik_jari_kiri">
                                                </div>
                                                @if($asesmen->rmeAsesmenPerinatology->sidik_jari_ibu_kiri ?? '')
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                        <small class="text-success">File sudah diunggah sebelumnya</small>
                                                        <a href="{{ Storage::url($asesmen->rmeAsesmenPerinatology->sidik_jari_ibu_kiri) }}"
                                                        class="btn btn-sm btn-info ms-2" target="_blank">
                                                            <i class="bi bi-eye"></i> Lihat
                                                        </a>
                                                    </div>
                                                @endif
                                                <small class="text-muted">Format: JPG, PNG, PDF | Maks: 10MB</small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Jari Kanan</label>
                                                <div class="input-group mb-2">
                                                    <input type="file" class="form-control"
                                                        name="sidik_jari_kanan">
                                                </div>
                                                @if($asesmen->rmeAsesmenPerinatology->sidik_jari_ibu_kanan ?? '')
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                        <small class="text-success">File sudah diunggah sebelumnya</small>
                                                        <a href="{{ Storage::url($asesmen->rmeAsesmenPerinatology->sidik_jari_ibu_kanan) }}"
                                                        class="btn btn-sm btn-info ms-2" target="_blank">
                                                            <i class="bi bi-eye"></i> Lihat
                                                        </a>
                                                    </div>
                                                @endif
                                                <small class="text-muted">Format: JPG, PNG, PDF | Maks: 10MB</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Sidik Jari Ibu Bayi</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Jari Kiri</label>
                                                <div class="input-group">
                                                    <input type="file" class="form-control"
                                                        name="sidik_jari_kiri">
                                                    @if($asesmen->rmeAsesmenPerinatology->sidik_jari_kiri ?? '')
                                                        <div class="mt-2">
                                                            <small class="text-success">File sudah diunggah sebelumnya</small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Jari Kanan</label>
                                                <div class="input-group">
                                                    <input type="file" class="form-control"
                                                        name="sidik_jari_kanan">
                                                    @if($asesmen->rmeAsesmenPerinatology->sidik_jari_kanan ?? '')
                                                        <div class="mt-2">
                                                            <small class="text-success">File sudah diunggah sebelumnya</small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Alamat</label>
                                        <textarea class="form-control" name="alamat" rows="4" placeholder="Masukkan alamat">{{ $asesmen->rmeAsesmenPerinatology->alamat ?? '' }}</textarea>
                                    </div>
                                </div>

                                {{-- 3. Anamnesis --}}
                                <div class="section-separator" id="anamnesis">
                                    <h5 class="section-title">3. Anamnesis</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Anamnesis</label>
                                        <textarea class="form-control" name="anamnesis" rows="4"
                                            placeholder="keluhan utama dan riwayat penyakit sekarang">{{ $asesmen->anamnesis }}</textarea>
                                    </div>
                                </div>

                                {{-- 4. Pemeriksaan Fisik --}}
                                <div class="section-separator" id="pemeriksaan-fisik">
                                    <h5 class="section-title">4. Pemeriksaan fisik</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Frekuensi Denyut Nadi (X/Mnt)</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <input type="text" class="form-control" name="frekuensi_nadi"
                                                value="{{ $asesmen->rmeAsesmenPerinatologyFisik->frekuensi_nadi }}"
                                                    placeholder="frekuensi nadi per menit">
                                            </div>
                                            <div class="flex-grow-1">
                                                <select class="form-select" name="status_frekuensi">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="kuat" {{ $asesmen->rmeAsesmenPerinatologyFisik->status_frekuensi == 'kuat' ? 'selected' : '' }} >kuat</option>
                                                    <option value="lemah" {{$asesmen->rmeAsesmenPerinatologyFisik->status_frekuensi == 'lemah' ? 'selected' : ''}} >lemah</option>
                                                    <option value="teratur {{$asesmen->rmeAsesmenPerinatologyFisik->status_frekuensi == 'teratur' ? 'selected' : ''}} ">teratur</option>
                                                    <option value="tidak teratur" {{$asesmen->rmeAsesmenPerinatologyFisik->status_frekuensi == 'tidak teratur' ? 'selected' : ''}} >tidak teratur</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nafas (Per Menit)</label>
                                        <input type="number" class="form-control" name="nafas"
                                            value="{{ $asesmen->rmeAsesmenPerinatologyFisik->nafas }}"
                                            placeholder="frekuensi nafas per menit">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Suhu (C)</label>
                                        <input type="number" class="form-control" name="suhu"
                                            value="{{ $asesmen->rmeAsesmenPerinatologyFisik->suhu }}"
                                            placeholder="suhu dalam celcius">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Saturasi Oksigen (%)</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <label class="form-label">Tanpa Bantuan O2</label>
                                                <input type="number" class="form-control" name="saturasi_o2_tanpa"
                                                    value="{{ $asesmen->rmeAsesmenPerinatologyFisik->spo2_tanpa_bantuan }}"
                                                    placeholder="Tanpa bantuan O2">
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="form-label">Dengan Bantuan O2</label>
                                                <input type="number" class="form-control" name="saturasi_o2_dengan"
                                                    value="{{ $asesmen->rmeAsesmenPerinatologyFisik->spo2_dengan_bantuan }}"
                                                    placeholder="Dengan bantuan O2">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kesadaran</label>
                                        <select class="form-select" name="kesadaran">
                                            <option disabled>--Pilih--</option>
                                            <option value="Compos Mentis"
                                                {{ $asesmen->rmeAsesmenPerinatology->kesadaran == 'Compos Mentis' ? 'selected' : '' }}>
                                                Compos Mentis</option>
                                            <option value="Apatis"
                                                {{ $asesmen->rmeAsesmenPerinatology->kesadaran == 'Apatis' ? 'selected' : '' }}>
                                                Apatis</option>
                                            <option value="Sopor"
                                                {{ $asesmen->rmeAsesmenPerinatology->kesadaran == 'Sopor' ? 'selected' : '' }}>
                                                Sopor</option>
                                            <option value="Coma"
                                                {{ $asesmen->rmeAsesmenPerinatology->kesadaran == 'Coma' ? 'selected' : '' }}>
                                                Coma</option>
                                            <option value="Somnolen"
                                                {{ $asesmen->rmeAsesmenPerinatology->kesadaran == 'Somnolen' ? 'selected' : '' }}>
                                                Somnolen</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">AVPU</label>
                                        <select class="form-select" name="avpu">
                                            <option disabled>--Pilih--</option>
                                            <option value="0"
                                                {{ $asesmen->rmeAsesmenPerinatology->avpu == '0' ? 'selected' : '' }}>Sadar
                                                Baik/Alert</option>
                                            <option value="1"
                                                {{ $asesmen->rmeAsesmenPerinatology->avpu == '1' ? 'selected' : '' }}>
                                                Berespon dengan kata-kata/Voice</option>
                                            <option value="2"
                                                {{ $asesmen->rmeAsesmenPerinatology->avpu == '2' ? 'selected' : '' }}>Hanya
                                                berespon jika dirangsang nyeri/pain</option>
                                            <option value="3"
                                                {{ $asesmen->rmeAsesmenPerinatology->avpu == '3' ? 'selected' : '' }}>
                                                Pasien tidak sadar/unresponsive</option>
                                            <option value="4"
                                                {{ $asesmen->rmeAsesmenPerinatology->avpu == '4' ? 'selected' : '' }}>
                                                Gelisah atau bingung</option>
                                            <option value="5"
                                                {{ $asesmen->rmeAsesmenPerinatology->avpu == '5' ? 'selected' : '' }}>Acute
                                                Confusional States</option>
                                        </select>
                                    </div>

                                    <div class="mt-4">
                                        <h6>Pemeriksaan Lanjutan</h6>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Warna Kulit</label>
                                            <select class="form-select" name="warna_kulit">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Pink" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->warna_kulit == 'Pink' ? 'selected' : '' }}>Pink</option>
                                                <option value="Kuning" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->warna_kulit == 'Kuning' ? 'selected' : '' }}>Kuning</option>
                                                <option value="Pucat" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->warna_kulit == 'Pucat' ? 'selected' : '' }}>Pucat</option>
                                                <option value="Kuning dan Merah" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->warna_kulit == 'Kuning dan Merah' ? 'selected' : '' }}>Kuning dan Merah</option>
                                                <option value="Kuning dan Hijau" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->warna_kulit == 'Kuning dan Hijau' ? 'selected' : '' }}>Kuning dan Hijau</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Sianosis</label>
                                            <select class="form-select" name="sianosis">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Kuku" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->sianosis == 'Kuku' ? 'selected' : '' }}>Kuku</option>
                                                <option value="Sekitar Mulut" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->sianosis == 'Sekitar Mulut' ? 'selected' : '' }}>Sekitar Mulut</option>
                                                <option value="Sekitar Mata" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->sianosis == 'Sekitar Mata' ? 'selected' : '' }}>Sekitar Mata</option>
                                                <option value="Ekstremitas Atas" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->sianosis == 'Ekstremitas Atas' ? 'selected' : '' }}>Ekstremitas Atas</option>
                                                <option value="Ekstremitas Bawah" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->sianosis == 'Ekstremitas Bawah' ? 'selected' : '' }}>Ekstremitas Bawah</option>
                                                <option value="Seluruh Tubuh" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->sianosis == 'Seluruh Tubuh' ? 'selected' : '' }}>Seluruh Tubuh</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kemerahan/Rash</label>
                                            <select class="form-select" name="kemerahan">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Tidak Ada" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->kemerahan == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                                <option value="Ada" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->kemerahan == 'Ada' ? 'selected' : '' }}>Ada</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Turgor Kulit</label>
                                            <select class="form-select" name="turgor_kulit">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Elastis" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->turgor_kulit == 'Elastis' ? 'selected' : '' }}>Elastis</option>
                                                <option value="Tidak Elastis" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->turgor_kulit == 'Tidak Elastis' ? 'selected' : '' }}>Tidak Elastis</option>
                                                <option value="Edema" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->turgor_kulit == 'Edema' ? 'selected' : '' }}>Edema</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanda Lahir</label>
                                            <input type="text" class="form-control" name="tanda_lahir" placeholder="sebutkan" value="{{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->tanda_lahir ?? '' }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Fontanel Anterior</label>
                                            <select class="form-select" name="fontanel_anterior">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Lunak" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->fontanel_anterior == 'Lunak' ? 'selected' : '' }}>Lunak</option>
                                                <option value="Tegas" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->fontanel_anterior == 'Tegas' ? 'selected' : '' }}>Tegas</option>
                                                <option value="Datar" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->fontanel_anterior == 'Datar' ? 'selected' : '' }}>Datar</option>
                                                <option value="Menonjol" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->fontanel_anterior == 'Menonjol' ? 'selected' : '' }}>Menonjol</option>
                                                <option value="Cekung" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->fontanel_anterior == 'Cekung' ? 'selected' : '' }}>Cekung</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Sutura Sagitalis</label>
                                            <select class="form-select" name="sutura_sagitalis">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Tepat" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->sutura_sagitalis == 'Tepat' ? 'selected' : '' }}>Tepat</option>
                                                <option value="Terpisah" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->sutura_sagitalis == 'Terpisah' ? 'selected' : '' }}>Terpisah</option>
                                                <option value="Menjauh" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->sutura_sagitalis == 'Menjauh' ? 'selected' : '' }}>Menjauh</option>
                                                <option value="Tumpang Tindih" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->sutura_sagitalis == 'Tumpang Tindih' ? 'selected' : '' }}>Tumpang Tindih</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Gambaran Wajah</label>
                                            <select class="form-select" name="gambaran_wajah">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Simetris" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->gambaran_wajah == 'Simetris' ? 'selected' : '' }}>Simetris</option>
                                                <option value="Asimetris" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->gambaran_wajah == 'Asimetris' ? 'selected' : '' }}>Asimetris</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Cephalhemeton</label>
                                            <select class="form-select" name="cephalhemeton">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Ada" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->cephalhemeton == 'Ada' ? 'selected' : '' }}>Ada</option>
                                                <option value="Tidak Ada" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->cephalhemeton == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Caput Succedaneun</label>
                                            <select class="form-select" name="caput_succedaneun">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Ada" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->caput_succedaneun == 'Ada' ? 'selected' : '' }}>Ada</option>
                                                <option value="Tidak Ada" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->caput_succedaneun == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Mulut</label>
                                            <select class="form-select" name="mulut">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Normal" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->mulut == 'Normal' ? 'selected' : '' }}>Normal</option>
                                                <option value="Bibir Sumbing" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->mulut == 'Bibir Sumbing' ? 'selected' : '' }}>Bibir Sumbing</option>
                                                <option value="Sumbing Platum" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->mulut == 'Sumbing Platum' ? 'selected' : '' }}>Sumbing Platum</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Mucosa Mulut</label>
                                            <select class="form-select" name="mucosa_mulut">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Lembab" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->mucosa_mulut == 'Lembab' ? 'selected' : '' }}>Lembab</option>
                                                <option value="Kering" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->mucosa_mulut == 'Kering' ? 'selected' : '' }}>Kering</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Dada dan Paru-paru</label>
                                            <select class="form-select" name="dada_paru">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Simetris" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->dada_paru == 'Simetris' ? 'selected' : '' }}>Simetris</option>
                                                <option value="Asimetris" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->dada_paru == 'Asimetris' ? 'selected' : '' }}>Asimetris</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Suara Nafas</label>
                                            <select class="form-select" name="suara_nafas">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Kanan Kiri Sama" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->suara_nafas == 'Kanan Kiri Sama' ? 'selected' : '' }}>Kanan Kiri Sama</option>
                                                <option value="Tidak Sama" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->suara_nafas == 'Tidak Sama' ? 'selected' : '' }}>Tidak Sama</option>
                                                <option value="Bersih" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->suara_nafas == 'Bersih' ? 'selected' : '' }}>Bersih</option>
                                                <option value="Wheezing" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->suara_nafas == 'Wheezing' ? 'selected' : '' }}>Wheezing</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Respirasi</label>
                                            <select class="form-select" name="respirasi">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Spontan tanpa alat bantu" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->respirasi == 'Spontan tanpa alat bantu' ? 'selected' : '' }}>Spontan tanpa alat bantu
                                                </option>
                                                <option value="Spontan dengan alat bantu" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->respirasi == 'Spontan dengan alat bantu' ? 'selected' : '' }}>Spontan dengan alat bantu
                                                </option>
                                                <option value="Tidak Spontan" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->respirasi == 'Tidak Spontan' ? 'selected' : '' }}>Tidak Spontan</option>
                                            </select>
                                        </div>

                                        <!-- CHECK -->
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Down Score</label>
                                            <div class="d-flex">
                                                <input type="text" class="form-control" name="down_score" value="{{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->down_score }}"
                                                    id="down_score" readonly>
                                                <button type="button" class="btn btn-primary ms-2" id="btnDownScore"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#downScoreModal">Skor</button>
                                            </div>
                                        </div>
                                        <!-- CHECK -->

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Bunyi Jantung</label>
                                            <select class="form-select" name="bunyi_jantung">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Normal" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->bunyi_jantung == 'Normal' ? 'selected' : '' }}>Normal</option>
                                                <option value="Gallop" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->bunyi_jantung == 'Gallop' ? 'selected' : '' }}>Gallop</option>
                                                <option value="Friction" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->bunyi_jantung == 'Friction' ? 'selected' : '' }}>Friction</option>
                                                <option value="Rub" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->bunyi_jantung == 'Rub' ? 'selected' : '' }}>Rub</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Waktu Pengisian Kapiler (CRT)</label>
                                            <input type="number" class="form-control" name="waktu_pengisian_kapiler" placeholder="detik"
                                                value="{{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->waktu_pengisian_kapiler }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Keadaan Perut</label>
                                            <select class="form-select" name="keadaan_perut">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Lunak" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->keadaan_perut == 'Lunak' ? 'selected' : '' }}>Lunak</option>
                                                <option value="Datar" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->keadaan_perut == 'Datar' ? 'selected' : '' }}>Datar</option>
                                                <option value="Distensi" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->keadaan_perut == 'Distensi' ? 'selected' : '' }}>Distensi</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Umbilikus</label>
                                            <select class="form-select" name="umbilikus">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Basah" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->umbilikus == 'Basah' ? 'selected' : '' }}>Basah</option>
                                                <option value="Kering" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->umbilikus == 'Kering' ? 'selected' : '' }}>Kering</option>
                                                <option value="Bau" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->umbilikus == 'Bau' ? 'selected' : '' }}>Bau</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Warna Umbilikus</label>
                                            <select class="form-select" name="warna_umbilikus">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Putih" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->warna_umbilikus == 'Putih' ? 'selected' : '' }}>Putih</option>
                                                <option value="Kuning" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->warna_umbilikus == 'Kuning' ? 'selected' : '' }} >Kuning</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Genitalis</label>
                                            <select class="form-select" name="genitalis">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Perempuan, Normal" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->genitalis == 'Perempuan, Normal' ? 'selected' : '' }}>Perempuan, Normal</option>
                                                <option value="Laki-Laki, Normal" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->genitalis == 'Laki-Laki, Normal' ? 'selected' : '' }}>Laki-Laki, Normal</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Gerakan</label>
                                            <select class="form-select" name="gerakan">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Normal" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->gerakan == 'Normal' ? 'selected' : '' }}>Normal</option>
                                                <option value="Terbatas" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->gerakan == 'Terbatas' ? 'selected' : '' }}>Terbatas</option>
                                                <option value="Tidak Terkaji" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->gerakan == 'Tidak Terkaji' ? 'selected' : '' }}>Tidak Terkaji</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Ekstremitas Atas</label>
                                            <select class="form-select" name="ekstremitas_atas">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Normal" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->ekstremitas_atas == 'Normal' ? 'selected' : '' }}>Normal</option>
                                                <option value="Tidak Normal" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->ekstremitas_atas == 'Tidak Normal' ? 'selected' : '' }}>Tidak Normal</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Ekstremitas Bawah</label>
                                            <select class="form-select" name="ekstremitas_bawah">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Normal" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->ekstremitas_bawah == 'Normal' ? 'selected' : '' }}>Normal</option>
                                                <option value="Tidak Normal" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->ekstremitas_bawah == 'Tidak Normal' ? 'selected' : '' }}>Tidak Normal</option>
                                            </select>
                                        </div>

                                         <div class="form-group">
                                            <label style="min-width: 200px;">Tulang Belakang</label>
                                            <select class="form-select" name="tulang_belakang">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Normal" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->tulang_belakang == 'Normal' ? 'selected' : '' }}>Normal</option>
                                                <option value="Tidak Normal" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->tulang_belakang == 'Tidak Normal' ? 'selected' : '' }}>Tidak Normal</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Refleks</label>
                                            <select class="form-select" name="refleks">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Normal" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->refleks == 'Normal' ? 'selected' : '' }}>Normal</option>
                                                <option value="Tidak Normal" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->refleks == 'Tidak Normal' ? 'selected' : '' }}>Tidak Normal</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Genggaman</label>
                                            <select class="form-select" name="genggaman">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Kuat" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->genggaman == 'Kuat' ? 'selected' : '' }}>Kuat</option>
                                                <option value="Lemah" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->genggaman == 'Lemah' ? 'selected' : '' }}>Lemah</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Menghisap</label>
                                            <select class="form-select" name="menghisap">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Kuat" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->menghisap == 'Kuat' ? 'selected' : '' }}>Kuat</option>
                                                <option value="Lemah" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->menghisap == 'Lemah' ? 'selected' : '' }}>Lemah</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tonus/Aktivitas</label>
                                            <select class="form-select" name="aktivitas">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Aktif" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->aktivitas == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="Tenang" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->aktivitas == 'Tenang' ? 'selected' : '' }}>Tenang</option>
                                                <option value="Letargi" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->aktivitas == 'Letargi' ? 'selected' : '' }}>Letargi</option>
                                                <option value="Kejang" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->aktivitas == 'Kejang' ? 'selected' : '' }}>Kejang</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Menangis</label>
                                            <select class="form-select" name="menangis">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Keras" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->menangis == 'Keras' ? 'selected' : '' }}>Keras</option>
                                                <option value="Lemah" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->menangis == 'Lemah' ? 'selected' : '' }}>Lemah</option>
                                                <option value="Melengking" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->menangis == 'Melengking' ? 'selected' : '' }}>Melengking</option>
                                                <option value="Sulit Menangis" {{ $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut->menangis == 'Sulit Menangis' ? 'selected' : '' }}>Sulit Menangis</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="mt-4">
                                        <h6>Antropometri</h6>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tinggi Badan (Cm)</label>
                                            <input type="number" id="tinggi_badan" name="tinggi_badan"
                                                class="form-control"
                                                value="{{ $asesmen->rmeAsesmenPerinatologyFisik->tinggi_badan }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Berat Badan (Kg)</label>
                                            <input type="number" id="berat_badan" name="berat_badan"
                                                class="form-control"
                                                value="{{ $asesmen->rmeAsesmenPerinatologyFisik->berat_badan }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lingkar Kepala (Cm)</label>
                                            <input type="text" class="form-control" name="lingkar_kepala"
                                                value="{{ $asesmen->rmeAsesmenPerinatologyFisik->lingkar_kepala }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lingkar Dada (Cm)</label>
                                            <input type="text" class="form-control" name="lingkar_dada"
                                                value="{{ $asesmen->rmeAsesmenPerinatologyFisik->lingkar_dada }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lingkar Perut (Cm)</label>
                                            <input type="text" class="form-control" name="lingkar_perut"
                                                value="{{ $asesmen->rmeAsesmenPerinatologyFisik->lingkar_perut }}">
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="pemeriksaan-fisik">
                                            <h6>Pemeriksaan Fisik</h6>
                                            <p class="text-small">Centang normal jika fisik yang dinilai normal,
                                                pilih tanda tambah untuk menambah keterangan fisik yang ditemukan tidak
                                                normal.
                                                Jika tidak dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                            </p>
                                            <div class="row">
                                                @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                    <div class="col-md-6">
                                                        <div class="d-flex flex-column gap-3">
                                                            @foreach ($chunk as $item)
                                                                @php
                                                                    // Pastikan $item tersedia dan ambil data pemeriksaan fisik terkait
                                                                    if (!empty($asesmen->pemeriksaanFisik)) {
                                                                        $pemeriksaanFisik = $asesmen->pemeriksaanFisik
                                                                            ->where('id_item_fisik', $item->id)
                                                                            ->first();
                                                                        $isNormal = $pemeriksaanFisik
                                                                            ? $pemeriksaanFisik->is_normal
                                                                            : 1;
                                                                        $keterangan = $pemeriksaanFisik
                                                                            ? $pemeriksaanFisik->keterangan
                                                                            : '';
                                                                    } else {
                                                                        $isNormal = 1;
                                                                        $keterangan = '';
                                                                    }
                                                                @endphp
                                                                <div class="pemeriksaan-item">
                                                                    <div
                                                                        class="d-flex align-items-center border-bottom pb-2">
                                                                        <div class="flex-grow-1">{{ $item->nama }}</div>
                                                                        <div class="form-check me-3">
                                                                            <input type="checkbox"
                                                                                class="form-check-input"
                                                                                id="{{ $item->id }}-normal"
                                                                                name="{{ $item->id }}-normal"
                                                                                {{ $isNormal ? 'checked' : '' }}>
                                                                            <label class="form-check-label"
                                                                                for="{{ $item->id }}-normal">Normal</label>
                                                                        </div>
                                                                        <button
                                                                            class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                            type="button"
                                                                            data-target="{{ $item->id }}-keterangan">
                                                                            <i class="bi bi-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="keterangan mt-2"
                                                                        id="{{ $item->id }}-keterangan"
                                                                        style="display:{{ !$isNormal || $keterangan ? 'block' : 'none' }};">
                                                                        <input type="text" class="form-control"
                                                                            name="{{ $item->id }}_keterangan"
                                                                            value="{{ $keterangan }}"
                                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- 5. Riwayat Kesehatan IBU --}}
                                <div class="section-separator" id="riwayat-kesehatan">
                                    <h5 class="section-title">5. Riwayat Kesehatan Ibu</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pemeriksaan Kehamilan</label>
                                        <select class="form-select" name="pemeriksaan_kehamilan">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="teratur" {{ $asesmen->rmeAsesmenPerinatologyRiwayatIbu->pemeriksaan_kehamilan == 'teratur' ? 'selected' : '' }}>Teratur</option>
                                            <option value="tidak_teratur" {{ $asesmen->rmeAsesmenPerinatologyRiwayatIbu->pemeriksaan_kehamilan == 'tidak_teratur' ? 'selected' : '' }}>Tidak Teratur</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tempat Pemeriksaan</label>
                                        <select class="form-select" name="tempat_pemeriksaan">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="puskesmas" {{ $asesmen->rmeAsesmenPerinatologyRiwayatIbu->tempat_pemeriksaan == 'puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                                            <option value="rumah_sakit" {{ $asesmen->rmeAsesmenPerinatologyRiwayatIbu->tempat_pemeriksaan == 'rumah_sakit' ? 'selected' : '' }}>Rumah Sakit</option>
                                            <option value="klinik" {{ $asesmen->rmeAsesmenPerinatologyRiwayatIbu->tempat_pemeriksaan == 'klinik' ? 'selected' : '' }}>Klinik</option>
                                            <option value="dokter_praktek" {{ $asesmen->rmeAsesmenPerinatologyRiwayatIbu->tempat_pemeriksaan == 'dokter_praktek' ? 'selected' : '' }}>Dokter Praktek</option>
                                            <option value="bidan" {{ $asesmen->rmeAsesmenPerinatologyRiwayatIbu->tempat_pemeriksaan == 'bidan' ? 'selected' : '' }}>Bidan</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                            <label style="min-width: 200px;">Usia Kehamilan/Masa Gestasi</label>
                                            <input type="text" class="form-control" name="usia_kehamilan"
                                                placeholder="Masukkan usia kehamilan" value="{{ $asesmen->rmeAsesmenPerinatologyRiwayatIbu->usia_kehamilan }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Cara Persalinan</label>
                                        <select class="form-select" name="cara_persalinan">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="normal" {{ $asesmen->rmeAsesmenPerinatologyRiwayatIbu->cara_persalinan == 'normal' ? 'selected' : '' }}>Normal</option>
                                            <option value="sectio_caesaria" {{ $asesmen->rmeAsesmenPerinatologyRiwayatIbu->cara_persalinan == 'sectio_caesaria' ? 'selected' : '' }}>Sectio Caesaria</option>
                                            <option value="vakum" {{ $asesmen->rmeAsesmenPerinatologyRiwayatIbu->cara_persalinan == 'vakum' ? 'selected' : '' }}>Vakum</option>
                                            <option value="forcep" {{ $asesmen->rmeAsesmenPerinatologyRiwayatIbu->cara_persalinan == 'forcep' ? 'selected' : '' }}>Forcep</option>
                                        </select>
                                    </div>

                                </div>

                                {{-- 6. Status Nyeri --}}
                                <div class="section-separator" id="status-nyeri">
                                    <h5 class="section-title">4. Status nyeri</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Jenis Skala NYERI</label>
                                        <select class="form-select" name="jenis_skala_nyeri" id="jenis_skala_nyeri">
                                            <option disabled>--Pilih--</option>
                                            <option value="NRS"
                                                {{ $asesmen->rmeAsesmenPerinatologyStatusNyeri->jenis_skala_nyeri == 1 ? 'selected' : '' }}>
                                                Numeric Rating Scale (NRS)</option>
                                            <option value="FLACC"
                                                {{ $asesmen->rmeAsesmenPerinatologyStatusNyeri->jenis_skala_nyeri == 2 ? 'selected' : '' }}>
                                                Face, Legs, Activity, Cry, Consolability (FLACC)</option>
                                            <option value="CRIES"
                                                {{ $asesmen->rmeAsesmenPerinatologyStatusNyeri->jenis_skala_nyeri == 3 ? 'selected' : '' }}>
                                                Crying, Requires, Increased, Expression, Sleepless (CRIES)</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nilai Skala Nyeri</label>
                                        <input type="text" class="form-control" id="nilai_skala_nyeri"
                                            name="nilai_skala_nyeri" readonly
                                            value="{{ $asesmen->rmeAsesmenPerinatologyStatusNyeri->nilai_nyeri }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kesimpulan Nyeri</label>
                                        <input type="hidden" class="form-control" id="kesimpulan_nyeri"
                                            name="kesimpulan_nyeri"
                                            value="{{ $asesmen->rmeAsesmenPerinatologyStatusNyeri->kesimpulan_nyeri }}">
                                        <div class="alert alert-success" id="kesimpulan_nyeri_alert">
                                            {{ $asesmen->rmeAsesmenPerinatologyStatusNyeri->kesimpulan_nyeri ?? 'Pilih skala nyeri terlebih dahulu' }}
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6 class="mb-3">Karakteristik Nyeri</h6>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Lokasi</label>
                                                <input type="text" class="form-control" name="lokasi_nyeri"
                                                    value="{{ $asesmen->rmeAsesmenPerinatologyStatusNyeri->lokasi }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Durasi</label>
                                                <input type="text" class="form-control" name="durasi_nyeri"
                                                    value="{{ $asesmen->rmeAsesmenPerinatologyStatusNyeri->durasi }}">
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Jenis nyeri</label>
                                                <select class="form-select" name="jenis_nyeri">
                                                    <option disabled>--Pilih--</option>
                                                    @foreach ($jenisnyeri as $jenis)
                                                        <option value="{{ $jenis->id }}"
                                                            {{ $asesmen->rmeAsesmenPerinatologyStatusNyeri->jenis_nyeri == $jenis->id ? 'selected' : '' }}>
                                                            {{ $jenis->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Frekuensi</label>
                                                <select class="form-select" name="frekuensi_nyeri">
                                                    <option disabled>--Pilih--</option>
                                                    @foreach ($frekuensinyeri as $frekuensi)
                                                        <option value="{{ $frekuensi->id }}"
                                                            {{ $asesmen->rmeAsesmenPerinatologyStatusNyeri->frekuensi == $frekuensi->id ? 'selected' : '' }}>
                                                            {{ $frekuensi->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Menjalar?</label>
                                                <select class="form-select" name="nyeri_menjalar">
                                                    <option disabled>--Pilih--</option>
                                                    @foreach ($menjalar as $menjalarItem)
                                                        <option value="{{ $menjalarItem->id }}"
                                                            {{ $asesmen->rmeAsesmenPerinatologyStatusNyeri->menjalar == $menjalarItem->id ? 'selected' : '' }}>
                                                            {{ $menjalarItem->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Kualitas</label>
                                                <select class="form-select" name="kualitas_nyeri">
                                                    <option disabled>--Pilih--</option>
                                                    @foreach ($kualitasnyeri as $kualitas)
                                                        <option value="{{ $kualitas->id }}"
                                                            {{ $asesmen->rmeAsesmenPerinatologyStatusNyeri->kualitas == $kualitas->id ? 'selected' : '' }}>
                                                            {{ $kualitas->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Faktor pemberat</label>
                                                <select class="form-select" name="faktor_pemberat">
                                                    <option disabled>--Pilih--</option>
                                                    @foreach ($faktorpemberat as $pemberat)
                                                        <option value="{{ $pemberat->id }}"
                                                            {{ $asesmen->rmeAsesmenPerinatologyStatusNyeri->faktor_pemberat == $pemberat->id ? 'selected' : '' }}>
                                                            {{ $pemberat->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Faktor peringan</label>
                                                <select class="form-select" name="faktor_peringan">
                                                    <option disabled>--Pilih--</option>
                                                    @foreach ($faktorperingan as $peringan)
                                                        <option value="{{ $peringan->id }}"
                                                            {{ $asesmen->rmeAsesmenPerinatologyStatusNyeri->faktor_peringan == $peringan->id ? 'selected' : '' }}>
                                                            {{ $peringan->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <label class="form-label">Efek Nyeri</label>
                                                <select class="form-select" name="efek_nyeri">
                                                    <option disabled>--Pilih--</option>
                                                    @foreach ($efeknyeri as $efek)
                                                        <option value="{{ $efek->id }}"
                                                            {{ $asesmen->rmeAsesmenPerinatologyStatusNyeri->efek_nyeri == $efek->id ? 'selected' : '' }}>
                                                            {{ $efek->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- 7. Alergi sectio --}}
                                <div class="section-separator" id="alergi">
                                    <h5 class="section-title">7. Alergi</h5>
                                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                        id="openAlergiModal">
                                        <i class="ti-plus"></i> Tambah
                                    </button>
                                    <div class="table-responsive">
                                        <table class="table" id="createAlergiTable">
                                            <thead>
                                                <tr>
                                                    <th>Jenis</th>
                                                    <th>Alergen</th>
                                                    <th>Reaksi</th>
                                                    <th>Severe</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Table content will be dynamically populated -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <input type="hidden" name="alergis" id="alergisInput"
                                        value='{{ $asesmen->riwayat_alergi ?? '[]' }}'>

                                </div>

                                {{-- 8. Risiko Jatuh --}}
                                <div class="section-separator" id="risiko_jatuh">
                                    <h5 class="section-title">8. Risiko Jatuh</h5>

                                    <div class="mb-4">
                                        <label class="form-label">Pilih jenis penilaian risiko jatuh sesuai dengan kondisi
                                            pasien:</label>
                                        <select class="form-select" id="risikoJatuhSkala" name="resiko_jatuh_jenis"
                                            onchange="showForm(this.value)">
                                            <option value="">--Pilih Skala--</option>
                                            <option value="1"
                                                {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->resiko_jatuh_jenis == 1 ? 'selected' : '' }}>
                                                Skala Umum</option>
                                            <option value="2"
                                                {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->resiko_jatuh_jenis == 2 ? 'selected' : '' }}>
                                                Skala Morse</option>
                                            <option value="3"
                                                {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->resiko_jatuh_jenis == 3 ? 'selected' : '' }}>
                                                Skala Humpty-Dumpty / Pediatrik</option>
                                            <option value="4"
                                                {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->resiko_jatuh_jenis == 4 ? 'selected' : '' }}>
                                                Skala Ontario Modified Stratify Sydney / Lansia</option>
                                            <option value="5"
                                                {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->resiko_jatuh_jenis == 5 ? 'selected' : '' }}>
                                                Lainnya</option>
                                        </select>
                                    </div>

                                    <!-- Form Skala Umum 1 -->
                                    <div id="skala_umumForm" class="risk-form" style="display: none;">
                                        <h5 class="mb-4">Penilaian Risiko Jatuh Skala Umum</h5>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien berusia < dari 2 tahun?</label>
                                                <select class="form-select" name="risiko_jatuh_umum_usia"
                                                    onchange="updateConclusion('umum')">
                                                    <option value="">pilih</option>
                                                    <option value="1"
                                                        {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_umum_usia == 1 ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0"
                                                        {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_umum_usia == 0 ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien dalam kondisi sebagai geriatri,
                                                dizzines, vertigo, gangguan keseimbangan, gangguan penglihatan, penggunaan
                                                obat sedasi, status kesadaran dan atau kejiwaan, konsumsi alkohol?</label>
                                            <select class="form-select" onchange="updateConclusion('umum')"
                                                name="risiko_jatuh_umum_kondisi_khusus">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_umum_kondisi_khusus == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_umum_kondisi_khusus == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien didiagnosis sebagai pasien dengan
                                                penyakit parkinson?</label>
                                            <select class="form-select" onchange="updateConclusion('umum')"
                                                name="risiko_jatuh_umum_diagnosis_parkinson">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien sedang mendapatkan obat sedasi, riwayat
                                                tirah baring lama, perubahan posisi yang akan meningkatkan risiko
                                                jatuh?</label>
                                            <select class="form-select" onchange="updateConclusion('umum')"
                                                name="risiko_jatuh_umum_pengobatan_berisiko">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien saat ini sedang berada pada salah satu
                                                lokasi ini: rehab medik, ruangan dengan penerangan kurang dan
                                                bertangga?</label>
                                            <select class="form-select" onchange="updateConclusion('umum')"
                                                name="risiko_jatuh_umum_lokasi_berisiko">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div
                                            class="conclusion {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && strpos($asesmen->rmeAsesmenPerinatologyRisikoJatuh->kesimpulan_skala_umum ?? '', 'Berisiko') !== false ? 'bg-danger' : 'bg-success' }}">
                                            <p class="conclusion-text">Kesimpulan: <span
                                                    id="kesimpulanTextForm">{{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) ? ($asesmen->rmeAsesmenPerinatologyRisikoJatuh->kesimpulan_skala_umum ?? 'Tidak berisiko jatuh') : 'Tidak berisiko jatuh' }}</span>
                                            </p>
                                            <input type="hidden" name="risiko_jatuh_umum_kesimpulan"
                                                id="risiko_jatuh_umum_kesimpulan"
                                                value="{{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) ? ($asesmen->rmeAsesmenPerinatologyRisikoJatuh->kesimpulan_skala_umum ?? 'Tidak berisiko jatuh') : 'Tidak berisiko jatuh' }}">
                                        </div>
                                    </div>

                                    <!-- Form Skala Morse 2 -->
                                    <div id="skala_morseForm" class="risk-form" style="display: none;">
                                        <h5 class="mb-4">Penilaian Risiko Jatuh Skala Morse</h5>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien pernah mengalami Jatuh?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_riwayat_jatuh"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="25"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien memiliki diagnosis skunder?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_diagnosis_sekunder"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="15"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien membutuhkan bantuan ambulasi?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_bantuan_ambulasi"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="30"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi == 0 ? 'selected' : '' }}>
                                                    Meja/ kursi</option>
                                                <option value="15"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi == 1 ? 'selected' : '' }}>
                                                    Kruk/ tongkat/ alat bantu berjalan</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi == 2 ? 'selected' : '' }}>
                                                    Tidak ada/ bed rest/ bantuan perawat</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien terpasang infus?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_terpasang_infus"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="20"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_terpasang_infus) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_terpasang_infus == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_terpasang_infus) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_terpasang_infus == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Bagaimana cara berjalan pasien?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_cara_berjalan"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_cara_berjalan) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_cara_berjalan == 0 ? 'selected' : '' }}>
                                                    Normal/ bed rest/ kursi roda</option>
                                                <option value="20"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_cara_berjalan) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_cara_berjalan == 1 ? 'selected' : '' }}>
                                                    Terganggu</option>
                                                <option value="10"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_cara_berjalan) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_cara_berjalan == 2 ? 'selected' : '' }}>
                                                    Lemah</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Bagaimana status mental pasien?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_status_mental"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_status_mental) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_status_mental == 0 ? 'selected' : '' }}>
                                                    Beroroentasi pada kemampuannya</option>
                                                <option value="15"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_status_mental) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_morse_status_mental == 1 ? 'selected' : '' }}>
                                                    Lupa akan keterbatasannya</option>
                                            </select>
                                        </div>
                                        <div
                                            class="conclusion {{ strpos($asesmen->rmeAsesmenPerinatologyRisikoJatuh->kesimpulan_skala_morse ?? '', 'Tinggi') !== false ? 'bg-danger' : (strpos($asesmen->rmeAsesmenPerinatologyRisikoJatuh->kesimpulan_skala_morse ?? '', 'Sedang') !== false ? 'bg-warning' : 'bg-success') }}">
                                            <p class="conclusion-text">Kesimpulan: <span
                                                    id="kesimpulanTextForm">{{ $asesmen->rmeAsesmenPerinatologyRisikoJatuh->kesimpulan_skala_morse ?? 'Risiko Rendah' }}</span>
                                            </p>
                                            <input type="hidden" name="risiko_jatuh_morse_kesimpulan"
                                                id="risiko_jatuh_morse_kesimpulan"
                                                value="{{ $asesmen->rmeAsesmenPerinatologyRisikoJatuh->kesimpulan_skala_morse ?? 'Risiko Rendah' }}">
                                        </div>
                                    </div>

                                    <!-- Form Risiko Skala Humpty Dumpty 3 -->
                                    <div id="skala_humptyForm" class="risk-form" style="display: none;">
                                        <h5 class="mb-4">Penilaian Risiko Skala Humpty Dumpty/ Pediatrik</h5>
                                        <div class="mb-3">
                                            <label class="form-label">Usia Anak?</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_usia_anak"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="4"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_usia_anak) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_usia_anak == 0 ? 'selected' : '' }}>
                                                    Dibawah 3 tahun</option>
                                                <option value="3"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_usia_anak) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_usia_anak == 1 ? 'selected' : '' }}>
                                                    3-7 tahun</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_usia_anak) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_usia_anak == 2 ? 'selected' : '' }}>
                                                    7-13 tahun</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_usia_anak) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_usia_anak == 3 ? 'selected' : '' }}>
                                                    Diatas 13 tahun</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jenis kelamin</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_jenis_kelamin"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin == 0 ? 'selected' : '' }}>
                                                    Laki-laki</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin == 1 ? 'selected' : '' }}>
                                                    Perempuan</option>
                                            </select>
                                        </div>
                                        <!-- Lanjutkan dengan field Humpty Dumpty lainnya -->
                                        <div class="mb-3">
                                            <label class="form-label">Diagnosis</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_diagnosis"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="4"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_diagnosis) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_diagnosis == 0 ? 'selected' : '' }}>
                                                    Diagnosis Neurologis</option>
                                                <option value="3"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_diagnosis) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_diagnosis == 1 ? 'selected' : '' }}>
                                                    Perubahan oksigennasi (diangnosis respiratorik, dehidrasi, anemia,
                                                    syncope, pusing, dsb)</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_diagnosis) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_diagnosis == 2 ? 'selected' : '' }}>
                                                    Gangguan perilaku /psikiatri</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_diagnosis) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_diagnosis == 3 ? 'selected' : '' }}>
                                                    Diagnosis lainnya</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Gangguan Kognitif</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_gangguan_kognitif"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="3"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif == 0 ? 'selected' : '' }}>
                                                    Tidak menyadari keterbatasan dirinya</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif == 1 ? 'selected' : '' }}>
                                                    Lupa akan adanya keterbatasan</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif == 2 ? 'selected' : '' }}>
                                                    Orientasi baik terhadap dari sendiri</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Faktor Lingkungan</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_faktor_lingkungan"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="4"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan == 0 ? 'selected' : '' }}>
                                                    Riwayat jatuh /bayi diletakkan di tempat tidur dewasa</option>
                                                <option value="3"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan == 1 ? 'selected' : '' }}>
                                                    Pasien menggunakan alat bantu /bayi diletakkan di tempat tidur bayi /
                                                    perabot rumah</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan == 2 ? 'selected' : '' }}>
                                                    Pasien diletakkan di tempat tidur</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan == 3 ? 'selected' : '' }}>
                                                    Area di luar rumah sakit</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Pembedahan/ sedasi/ Anestesi</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_pembedahan"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="3"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_pembedahan) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_pembedahan == 0 ? 'selected' : '' }}>
                                                    Dalam 24 jam</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_pembedahan) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_pembedahan == 1 ? 'selected' : '' }}>
                                                    Dalam 48 jam</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_pembedahan) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_pembedahan == 2 ? 'selected' : '' }}>
                                                    > 48 jam atau tidak menjalani pembedahan/sedasi/anestesi</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Penggunaan Medika mentosa</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_penggunaan_mentosa"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="3"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa == 0 ? 'selected' : '' }}>
                                                    Penggunaan multiple: sedative, obat hipnosis, barbiturate, fenotiazi,
                                                    antidepresan, pencahar, diuretik, narkose</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa == 1 ? 'selected' : '' }}>
                                                    Penggunaan salah satu obat diatas</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa == 2 ? 'selected' : '' }}>
                                                    Penggunaan medikasi lainnya/tidak ada mediksi</option>
                                            </select>
                                        </div>

                                        <div
                                            class="conclusion {{ strpos($asesmen->rmeAsesmenPerinatologyRisikoJatuh->kesimpulan_skala_pediatrik ?? '', 'Tinggi') !== false ? 'bg-danger' : 'bg-success' }}">
                                            <p class="conclusion-text">Kesimpulan: <span
                                                    id="kesimpulanTextForm">{{ $asesmen->rmeAsesmenPerinatologyRisikoJatuh->kesimpulan_skala_pediatrik ?? 'Risiko Rendah' }}</span>
                                            </p>
                                            <input type="hidden" name="risiko_jatuh_pediatrik_kesimpulan"
                                                id="risiko_jatuh_pediatrik_kesimpulan"
                                                value="{{ $asesmen->rmeAsesmenPerinatologyRisikoJatuh->kesimpulan_skala_pediatrik ?? 'Risiko Rendah' }}">
                                        </div>
                                    </div>

                                    <div id="skala_ontarioForm" class="risk-form" style="display: none;">
                                        <h5 class="mb-4">Penilaian Risiko Jatuh Skala Ontario Modified Stratify Sydney/
                                            Lansia</h5>

                                        <!-- 1. Riwayat Jatuh -->
                                        <h6 class="mb-3">1. Riwayat Jatuh</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien datang kerumah sakit karena
                                                jatuh?</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_jatuh_saat_masuk_rs"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="6"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien memiliki 2 kali atau apakah pasien mengalami
                                                jatuh dalam 2 bulan terakhir ini/ diagnosis multiple?</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_riwayat_jatuh_2_bulan"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="6"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 2. Status Mental -->
                                        <h6 class="mb-3">2. Status Mental</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien bingung? (Tidak dapat membuat
                                                keputusan, jaga jarak tempatnya, gangguan daya ingat)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_status_bingung"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="14"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_status_bingung) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_status_bingung == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_status_bingung) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_status_bingung == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien disorientasi? (tidak menyadarkan waktu,
                                                tempat atau orang)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_status_disorientasi"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="14"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_status_disorientasi) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_status_disorientasi == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_status_disorientasi) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_status_disorientasi == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami agitasi? (keresahan, gelisah,
                                                dan cemas)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_status_agitasi"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="14"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_status_agitasi) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_status_agitasi == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_status_agitasi) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_status_agitasi == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 3. Penglihatan -->
                                        <h6 class="mb-3">3. Penglihatan</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien memakai Kacamata? </label>
                                            <select class="form-select" name="risiko_jatuh_lansia_kacamata"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_kacamata == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_kacamata == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami kelainya
                                                penglihatan/buram?</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_kelainan_penglihatan"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mempunyai glukoma/ katarak/ degenerasi
                                                makula?</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_glukoma"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_glukoma == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_glukoma == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 4. Kebiasaan Berkemih -->
                                        <h6 class="mb-3">4. Kebiasaan Berkemih</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah terdapat perubahan perilaku berkemih?
                                                (frekuensi, urgensi, inkontinensia, noktura)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_perubahan_berkemih"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke tempat tidur) -->
                                        <h6 class="mb-3">5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke
                                            tempat tidur)</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Mandiri (boleh menolak saat bantu jatuh)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_transfer_mandiri"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_transfer_mandiri == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_transfer_mandiri == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Memerlukan sedikit bantuan (1 orang) / dalam pengawasan</label>
                                            <select class="form-select"
                                                name="risiko_jatuh_lansia_transfer_bantuan_sedikit"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Memerlukan bantuan yang nyata (2 orang)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_transfer_bantuan_nyata"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tidak dapat duduk dengan seimbang, perlu bantuan
                                                total</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_transfer_bantuan_total"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="3"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 6. Mobilitas Pasien -->
                                        <h6 class="mb-3">6. Mobilitas Pasien</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Mandiri (dapat menggunakan alat bantu jalan)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_mobilitas_mandiri"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">berjalan dengan bantuan 1 orang (verbal/ fisik)</label>
                                            <select class="form-select"
                                                name="risiko_jatuh_lansia_mobilitas_bantuan_1_orang"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Menggunakan kusi roda</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_mobilitas_kursi_roda"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Imobilisasi</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_mobilitas_imobilisasi"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="3"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div
                                            class="conclusion {{ strpos($asesmen->rmeAsesmenPerinatologyRisikoJatuh->kesimpulan_skala_lansia ?? '', 'Tinggi') !== false ? 'bg-danger' : (strpos($asesmen->rmeAsesmenPerinatologyRisikoJatuh->kesimpulan_skala_lansia ?? '', 'Sedang') !== false ? 'bg-warning' : 'bg-success') }}">
                                            <p class="conclusion-text">Kesimpulan: <span
                                                    id="kesimpulanTextForm">{{ $asesmen->rmeAsesmenPerinatologyRisikoJatuh->kesimpulan_skala_lansia ?? 'Risiko Rendah' }}</span>
                                            </p>
                                            <input type="hidden" name="risiko_jatuh_lansia_kesimpulan"
                                                id="risiko_jatuh_lansia_kesimpulan"
                                                value="{{ $asesmen->rmeAsesmenPerinatologyRisikoJatuh->kesimpulan_skala_lansia ?? 'Risiko Rendah' }}">
                                        </div>
                                    </div>

                                    <!-- Bagian Intervensi Risiko Jatuh -->
                                    <div class="mb-4">
                                        <h6 class="mb-3">Intervensi Risiko Jatuh</h6>
                                        <p class="mb-2">Tambah tindakan intervensi risiko jatuh:</p>

                                        <button type="button" class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3" data-bs-toggle="modal" data-bs-target="#tindakanKeperawatanRisikoJatuhModal">
                                            <i class="ti-plus"></i> Tambah
                                        </button>
                                        <div id="selectedTindakanList-risikojatuh" class="d-flex flex-column gap-2">
                                            @if(isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) && $asesmen->rmeAsesmenPerinatologyRisikoJatuh->intervensi_risiko_jatuh)
                                                @php
                                                    $intervensiList = json_decode($asesmen->rmeAsesmenPerinatologyRisikoJatuh->intervensi_risiko_jatuh, true);
                                                @endphp
                                                @foreach($intervensiList as $index => $item)
                                                    <div class="p-2 bg-light rounded d-flex justify-content-between align-items-center">
                                                        <span>{{ $item }}</span>
                                                        <button type="button" class="btn btn-sm btn-danger delete-tindakan" data-index="{{ $index }}" data-target="risikojatuh">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <input type="hidden" name="intervensi_risiko_jatuh_json" id="intervensi_risiko_jatuh_json" value='{{ isset($asesmen->rmeAsesmenPerinatologyRisikoJatuh) ? ($asesmen->rmeAsesmenPerinatologyRisikoJatuh->intervensi_risiko_jatuh ?? "[]") : "[]" }}'>
                                    </div>
                                    <!-- Hidden input for lainnya -->
                                    <input type="hidden" id="skala_lainnya" name="risiko_jatuh_lainnya" value="{{ $asesmen->rmeAsesmenPerinatologyRisikoJatuh->resiko_jatuh_lainnya ?? '' }}">
                                    </div>
                                </div>

                                <!-- 9. Risiko dekubitus -->
                                <div class="section-separator" id="decubitus">
                                    <h5 class="section-title">9. Risiko dekubitus</h5>
                                    <p class="text-muted">Pilih jenis Skala Risiko Dekubitus sesuai kondisi pasien</p>

                                    <div class="form-group mb-4">
                                        <select class="form-select" id="skalaRisikoDekubitus" name="jenis_skala_dekubitus">
                                            <option value="" disabled>--Pilih Skala--</option>
                                            <option value="norton" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->jenis_skala == 1 ? 'selected' : '' }}>Skala Norton</option>
                                            <option value="braden" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->jenis_skala == 2 ? 'selected' : '' }}>Skala Braden</option>
                                        </select>
                                    </div>

                                    <!-- Form Skala Norton -->
                                    <div id="formNorton" class="decubitus-form" style="display: none;">
                                        <h6 class="mb-4">Penilaian Risiko DECUBITUS Skala Norton</h6>

                                        <div class="mb-4">
                                            <label class="form-label">Kondisi Fisik</label>
                                            <select class="form-select bg-light" name="kondisi_fisik">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_kondisi_fisik == '4' ? 'selected' : '' }}>Baik</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_kondisi_fisik == '3' ? 'selected' : '' }}>Sedang</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_kondisi_fisik == '2' ? 'selected' : '' }}>Buruk</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_kondisi_fisik == '1' ? 'selected' : '' }}>Sangat Buruk</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Kondisi mental</label>
                                            <select class="form-select bg-light" name="kondisi_mental">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_kondisi_mental == '4' ? 'selected' : '' }}>Sadar</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_kondisi_mental == '3' ? 'selected' : '' }}>Apatis</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_kondisi_mental == '2' ? 'selected' : '' }}>Bingung</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_kondisi_mental == '1' ? 'selected' : '' }}>Stupor</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Aktivitas</label>
                                            <select class="form-select bg-light" name="norton_aktivitas">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_aktivitas == '4' ? 'selected' : '' }}>Aktif</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_aktivitas == '3' ? 'selected' : '' }}>Jalan dengan bantuan</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_aktivitas == '2' ? 'selected' : '' }}>Terbatas di kursi</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_aktivitas == '1' ? 'selected' : '' }}>Terbatas di tempat tidur</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Mobilitas</label>
                                            <select class="form-select bg-light" name="norton_mobilitas">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_mobilitas == '4' ? 'selected' : '' }}>Bebas bergerak</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_mobilitas == '3' ? 'selected' : '' }}>Agak terbatas</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_mobilitas == '2' ? 'selected' : '' }}>Sangat terbatas</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_mobilitas == '1' ? 'selected' : '' }}>Tidak dapat bergerak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Inkontinensia</label>
                                            <select class="form-select bg-light" name="inkontinensia">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_inkontenesia == '4' ? 'selected' : '' }}>Tidak ada</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_inkontenesia == '3' ? 'selected' : '' }}>Kadang-kadang</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_inkontenesia == '2' ? 'selected' : '' }}>Biasanya urin</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->norton_inkontenesia == '1' ? 'selected' : '' }}>Urin dan feses</option>
                                            </select>
                                        </div>

                                        <div class="mt-4">
                                            <div class="d-flex gap-2">
                                                <span class="fw-bold">Kesimpulan :</span>
                                                <div id="kesimpulanNorton"
                                                    class="alert {{ strpos($asesmen->rmeAsesmenPerinatologyResikoDekubitus->decubitus_kesimpulan ?? '', 'Tinggi') !== false ? 'alert-danger' : (strpos($asesmen->rmeAsesmenPerinatologyResikoDekubitus->decubitus_kesimpulan ?? '', 'Sedang') !== false ? 'alert-warning' : 'alert-success') }} mb-0 flex-grow-1">
                                                    {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->decubitus_kesimpulan ?? 'Risiko Rendah' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Skala Braden -->
                                    <div id="formBraden" class="decubitus-form" style="display: none;">
                                        <h6 class="mb-4">Penilaian Risiko DECUBITUS Skala Braden</h6>
                                        <div class="mb-4">
                                            <label class="form-label">Persepsi Sensori</label>
                                            <select class="form-select bg-light" name="persepsi_sensori">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_persepsi == '1' ? 'selected' : '' }}>Keterbatasan Penuh</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_persepsi == '2' ? 'selected' : '' }}>Sangat Terbatas</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_persepsi == '3' ? 'selected' : '' }}>Keterbatasan Ringan</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_persepsi == '4' ? 'selected' : '' }}>Tidak Ada Gangguan</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Kelembapan</label>
                                            <select class="form-select bg-light" name="kelembapan">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_kelembapan == '1' ? 'selected' : '' }}>Selalu Lembap</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_kelembapan == '2' ? 'selected' : '' }}>Umumnya Lembap</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_kelembapan == '3' ? 'selected' : '' }}>Kadang-Kadang Lembap</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_kelembapan == '4' ? 'selected' : '' }}>Jarang Lembap</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Aktivitas</label>
                                            <select class="form-select bg-light" name="braden_aktivitas">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_aktivitas == '1' ? 'selected' : '' }}>Total di Tempat Tidur</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_aktivitas == '2' ? 'selected' : '' }}>Dapat Duduk</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_aktivitas == '3' ? 'selected' : '' }}>Berjalan Kadang-kadang</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_aktivitas == '4' ? 'selected' : '' }}>Dapat Berjalan-jalan</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Mobilitas</label>
                                            <select class="form-select bg-light" name="braden_mobilitas">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_mobilitas == '1' ? 'selected' : '' }}>Tidak Mampu Bergerak Sama sekali</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_mobilitas == '2' ? 'selected' : '' }}>Sangat Terbatas</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_mobilitas == '3' ? 'selected' : '' }}>Tidak Ada Masalah</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_mobilitas == '4' ? 'selected' : '' }}>Tanpa Keterbatasan</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Nutrisi</label>
                                            <select class="form-select bg-light" name="nutrisi">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_nutrisi == '1' ? 'selected' : '' }}>Sangat Buruk</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_nutrisi == '2' ? 'selected' : '' }}>Kurang Menucukup</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_nutrisi == '3' ? 'selected' : '' }}>Mencukupi</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_nutrisi == '4' ? 'selected' : '' }}>Sangat Baik</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Pergesekan dan Pergeseran</label>
                                            <select class="form-select bg-light" name="pergesekan">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_pergesekan == '1' ? 'selected' : '' }}>Bermasalah</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_pergesekan == '2' ? 'selected' : '' }}>Potensial Bermasalah</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->braden_pergesekan == '3' ? 'selected' : '' }}>Keterbatasan Ringan</option>
                                            </select>
                                        </div>

                                        <div class="mt-4">
                                            <div class="d-flex gap-2">
                                                <span class="fw-bold">Kesimpulan :</span>
                                                <div id="kesimpulanBraden"
                                                    class="alert {{ strpos($asesmen->rmeAsesmenPerinatologyResikoDekubitus->decubitus_kesimpulan ?? '', 'Tinggi') !== false ? 'alert-danger' : (strpos($asesmen->rmeAsesmenPerinatologyResikoDekubitus->decubitus_kesimpulan ?? '', 'Sedang') !== false ? 'alert-warning' : 'alert-success') }} mb-0 flex-grow-1">
                                                    {{ $asesmen->rmeAsesmenPerinatologyResikoDekubitus->decubitus_kesimpulan ?? 'Kesimpulan Skala Braden' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 10. Status Gizi -->
                                <div class="section-separator" id="status_gizi">
                                    <h5 class="section-title">10. Status Gizi</h5>
                                    <div class="form-group mb-4">
                                        <select class="form-select" name="gizi_jenis" id="nutritionAssessment">
                                            <option value="">--Pilih--</option>
                                            <option value="1" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_jenis == 1 ? 'selected' : '' }}>Malnutrition Screening Tool (MST)</option>
                                            <option value="2" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_jenis == 2 ? 'selected' : '' }}>The Mini Nutritional Assessment (MNA)</option>
                                            <option value="3" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_jenis == 3 ? 'selected' : '' }}>Strong Kids (1 bln - 18 Tahun)</option>
                                            <option value="5" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_jenis == 5 ? 'selected' : '' }}>Tidak Dapat Dinilai</option>
                                        </select>
                                    </div>

                                    <!-- MST Form -->
                                    <div id="mst" class="assessment-form" style="display: none;">
                                        <h6 class="mb-3">Penilaian Gizi Malnutrition Screening Tool (MST)</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami penurunan BB yang tidak diinginkan dalam 6 bulan terakhir?</label>
                                            <select class="form-select" name="gizi_mst_penurunan_bb">
                                                <option value="">pilih</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mst_penurunan_bb == '0' ? 'selected' : '' }}>Tidak ada penurunan Berat Badan (BB)</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mst_penurunan_bb == '2' ? 'selected' : '' }}>Tidak yakin/ tidak tahu/ terasa baju lebi longgar</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mst_penurunan_bb == '3' ? 'selected' : '' }}>Ya ada penurunan BB</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jika jawaban di atas "Ya ada penurunan BB", berapa penurunan BB tersebut?</label>
                                            <select class="form-select" name="gizi_mst_jumlah_penurunan_bb">
                                                <option value="0">pilih</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mst_jumlah_penurunan_bb == '1' ? 'selected' : '' }}>1-5 kg</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mst_jumlah_penurunan_bb == '2' ? 'selected' : '' }}>6-10 kg</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mst_jumlah_penurunan_bb == '3' ? 'selected' : '' }}>11-15 kg</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mst_jumlah_penurunan_bb == '4' ? 'selected' : '' }}>>15 kg</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah asupan makan berkurang karena tidak nafsu makan?</label>
                                            <select class="form-select" name="gizi_mst_nafsu_makan_berkurang">
                                                <option value="">pilih</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mst_nafsu_makan_berkurang == '1' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mst_nafsu_makan_berkurang == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien didiagnosa khusus seperti: DM, Cancer (kemoterapi), Geriatri, GGk (hemodialisis), Penurunan Imun</label>
                                            <select class="form-select" name="gizi_mst_diagnosis_khusus">
                                                <option value="">pilih</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mst_diagnosis_khusus == '1' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mst_diagnosis_khusus == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Nilai -->
                                        <div id="mstConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-success">Kesimpulan: 0-1 tidak berisiko malnutrisi</div>
                                            <div class="alert alert-warning">Kesimpulan: ≥ 2 berisiko malnutrisi</div>
                                            <input type="hidden" name="gizi_mst_kesimpulan" id="gizi_mst_kesimpulan" value="{{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mst_kesimpulan }}">
                                        </div>
                                    </div>

                                    <!-- MNA Form -->
                                    <div id="mna" class="assessment-form" style="display: none;">
                                        <h6 class="mb-3">Penilaian Gizi The Mini Nutritional Assessment (MNA) / Lansia</h6>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Apakah pasien mengalami penurunan asupan makanan selama 3 bulan terakhir karena hilang selera makan, masalah pencernaan, kesulitan mengunyah atau menelan?
                                            </label>
                                            <select class="form-select" name="gizi_mna_penurunan_asupan_3_bulan">
                                                <option value="">--Pilih--</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_penurunan_asupan_3_bulan == '0' ? 'selected' : '' }}>Mengalami penurunan asupan makanan yang parah</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_penurunan_asupan_3_bulan == '1' ? 'selected' : '' }}>Mengalami penurunan asupan makanan sedang</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_penurunan_asupan_3_bulan == '2' ? 'selected' : '' }}>Tidak mengalami penurunan asupan makanan</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Apakah pasien mengalami kehilangan Berat Badan (BB) selama 3 bulan terakhir?
                                            </label>
                                            <select class="form-select" name="gizi_mna_kehilangan_bb_3_bulan">
                                                <option value="">-- Pilih --</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_kehilangan_bb_3_bulan == '0' ? 'selected' : '' }}>Kehilangan BB lebih dari 3 Kg</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_kehilangan_bb_3_bulan == '1' ? 'selected' : '' }}>Tidak tahu</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_kehilangan_bb_3_bulan == '2' ? 'selected' : '' }}>Kehilangan BB antara 1 s.d 3 Kg</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_kehilangan_bb_3_bulan == '3' ? 'selected' : '' }}>Tidak ada kehilangan BB</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Bagaimana mobilisasi atau pergerakan pasien?</label>
                                            <select class="form-select" name="gizi_mna_mobilisasi">
                                                <option value="">-- Pilih --</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_mobilisasi == '0' ? 'selected' : '' }}>Hanya di tempat tidur atau kursi roda</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_mobilisasi == '1' ? 'selected' : '' }}>Dapat turun dari tempat tidur tapi tidak dapat jalan-jalan</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_mobilisasi == '2' ? 'selected' : '' }}>Dapat jalan-jalan</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Apakah Pasien mengalami stres psikologi atau penyakit akut selama 3 bulan terakhir?
                                            </label>
                                            <select class="form-select" name="gizi_mna_stress_penyakit_akut">
                                                <option value="">-- Pilih --</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_stress_penyakit_akut == '0' ? 'selected' : '' }}>Ya</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_stress_penyakit_akut == '1' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami masalah neuropsikologi?</label>
                                            <select class="form-select" name="gizi_mna_status_neuropsikologi">
                                                <option value="">-- Pilih --</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_status_neuropsikologi == '0' ? 'selected' : '' }}>Demensia atau depresi berat</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_status_neuropsikologi == '1' ? 'selected' : '' }}>Demensia ringan</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_status_neuropsikologi == '2' ? 'selected' : '' }}>Tidak mengalami masalah neuropsikologi</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Berapa Berat Badan (BB) pasien? (Kg)</label>
                                            <input type="number" name="gizi_mna_berat_badan" class="form-control" id="mnaWeight" min="1" step="0.1" placeholder="Masukkan berat badan dalam Kg" value="{{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_berat_badan }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Berapa Tinggi Badan (TB) pasien? (cm)</label>
                                            <input type="number" name="gizi_mna_tinggi_badan" class="form-control" id="mnaHeight" min="1" step="0.1" placeholder="Masukkan tinggi badan dalam cm" value="{{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_tinggi_badan }}">
                                        </div>

                                        <!-- IMT -->
                                        <div class="mb-3">
                                            <label class="form-label">Indeks Massa Tubuh (IMT)</label>
                                            <div class="text-muted small mb-2">
                                                <i>Rumus IMT = BB (Kg) / (TB (m))²</i>
                                            </div>
                                            <input type="number" name="gizi_mna_imt" class="form-control bg-light" id="mnaBMI" readonly placeholder="IMT akan terhitung otomatis" value="{{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_imt }}">
                                        </div>

                                        <!-- Kesimpulan -->
                                        <div id="mnaConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-info mb-3" style="{{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_kesimpulan ? 'display: none;' : '' }}">
                                                Silakan isi semua parameter di atas untuk melihat kesimpulan
                                            </div>
                                            <div class="alert alert-success" style="{{ strpos($asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_kesimpulan ?? '', 'Tidak Beresiko') !== false ? '' : 'display: none;' }}">
                                                Kesimpulan: Total Skor ≥ 12 (Tidak Beresiko Malnutrisi)
                                            </div>
                                            <div class="alert alert-warning" style="{{ strpos($asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_kesimpulan ?? '', 'Beresiko') !== false ? '' : 'display: none;' }}">
                                                Kesimpulan: Total Skor ≤ 11 (Beresiko Malnutrisi)
                                            </div>
                                            <input type="hidden" name="gizi_mna_kesimpulan" id="gizi_mna_kesimpulan" value="{{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_mna_kesimpulan }}">
                                        </div>
                                    </div>

                                    <!-- Strong Kids Form -->
                                    <div id="strong-kids" class="assessment-form" style="display: none;">
                                        <h6 class="mb-3">Penilaian Gizi Strong Kids</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah anak tampa kurus kehilangan lemak subkutan, kehilangan massa otot, dan/ atau wajah cekung?</label>
                                            <select class="form-select" name="gizi_strong_status_kurus">
                                                <option value="">pilih</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_strong_status_kurus == '1' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_strong_status_kurus == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah terdapat penurunan BB selama satu bulan terakhir (untuk semua usia)?
                                                (berdasarkan penilaian objektif data BB bila ada/penilaian subjektif dari orang tua pasien ATAU tidak ada peningkatan berat badan atau tinggi badan (pada bayi < 1 tahun) selama 3 bulan terakhir)</label>
                                            <select class="form-select" name="gizi_strong_penurunan_bb">
                                                <option value="">pilih</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_strong_penurunan_bb == '1' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_strong_penurunan_bb == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Apakah salah satu dari hal berikut ini ada? <br>
                                                - Diare berlabihan (>= 5 kali perhari) dan/atau muntah(>3 klai perhari) selama 1-3 hari terakhir
                                                - Penurunan asupan makanan selama 1-3 hari terakhir
                                                - Intervensi gizi yang sudah ada sebelumnya (misalnya, ONS atau pemberian maka selang)</label>
                                            <select class="form-select" name="gizi_strong_gangguan_pencernaan">
                                                <option value="">pilih</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_strong_gangguan_pencernaan == '1' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_strong_gangguan_pencernaan == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah terdapat penyakit atau keadaan yang mengakibatkan pasien berisiko mengalaman mainutrisi? <br>
                                                <a href="#"><i>Lihat penyakit yang berisiko malnutrisi</i></a></label>
                                            <select class="form-select" name="gizi_strong_penyakit_berisiko">
                                                <option value="">pilih</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_strong_penyakit_berisiko == '2' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_strong_penyakit_berisiko == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Nilai -->
                                        <div id="strongKidsConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-success" style="{{ strpos($asesmen->rmeAsesmenPerinatologyGizi->gizi_strong_kesimpulan ?? '', 'rendah') !== false ? '' : 'display: none;' }}">Kesimpulan: 0 (Beresiko rendah)</div>
                                            <div class="alert alert-warning" style="{{ strpos($asesmen->rmeAsesmenPerinatologyGizi->gizi_strong_kesimpulan ?? '', 'sedang') !== false ? '' : 'display: none;' }}">Kesimpulan: 1-3 (Beresiko sedang)</div>
                                            <div class="alert alert-danger" style="{{ strpos($asesmen->rmeAsesmenPerinatologyGizi->gizi_strong_kesimpulan ?? '', 'Tinggi') !== false ? '' : 'display: none;' }}">Kesimpulan: 4-5 (Beresiko Tinggi)</div>
                                            <input type="hidden" name="gizi_strong_kesimpulan" id="gizi_strong_kesimpulan" value="{{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_strong_kesimpulan }}">
                                        </div>
                                    </div>

                                    <!-- Form NRS -->
                                    <div id="nrs" class="assessment-form" style="display: none;">
                                        <h5 class="mb-4">Penilaian Risiko NRS</h5>

                                        <!-- NRS Form fields here -->
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien datang kerumah sakit karena jatuh?</label>
                                            <select class="form-select" name="gizi_nrs_jatuh_saat_masuk_rs">
                                                <option value="">pilih</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_nrs_jatuh_saat_masuk_rs == '2' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_nrs_jatuh_saat_masuk_rs == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>

                                        <!-- Add more NRS form fields here -->

                                        <!-- Nilai -->
                                        <div id="nrsConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-success" style="{{ strpos($asesmen->rmeAsesmenPerinatologyGizi->gizi_nrs_kesimpulan ?? '', 'rendah') !== false ? '' : 'display: none;' }}">Kesimpulan: Beresiko rendah</div>
                                            <div class="alert alert-warning" style="{{ strpos($asesmen->rmeAsesmenPerinatologyGizi->gizi_nrs_kesimpulan ?? '', 'sedang') !== false ? '' : 'display: none;' }}">Kesimpulan: Beresiko sedang</div>
                                            <div class="alert alert-danger" style="{{ strpos($asesmen->rmeAsesmenPerinatologyGizi->gizi_nrs_kesimpulan ?? '', 'Tinggi') !== false ? '' : 'display: none;' }}">Kesimpulan: Beresiko Tinggi</div>
                                            <input type="hidden" name="gizi_nrs_kesimpulan" id="gizi_nrs_kesimpulan" value="{{ $asesmen->rmeAsesmenPerinatologyGizi->gizi_nrs_kesimpulan }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- 11. Status Fungsional -->
                                <div class="section-separator" id="status-fungsional">
                                    <h5 class="section-title">11. Status Fungsional</h5>

                                    <div class="mb-4">
                                        <label class="form-label">Pilih jenis Skala Pengkajian Aktivitas Harian (ADL) sesuai kondisi pasien</label>
                                        <select class="form-select" name="skala_fungsional" id="skala_fungsional">
                                            <option value="" disabled selected>Pilih Skala Fungsional</option>
                                            <option value="Pengkajian Aktivitas" {{ isset($asesmen->rmeAsesmenPerinatologyFungsional) && $asesmen->rmeAsesmenPerinatologyFungsional->jenis_skala == 1 ? 'selected' : '' }}>Pengkajian Aktivitas Harian</option>
                                            <option value="Lainnya" {{ isset($asesmen->rmeAsesmenPerinatologyFungsional) && $asesmen->rmeAsesmenPerinatologyFungsional->jenis_skala == 2 ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nilai Skala ADL</label>
                                        <input type="text" class="form-control" id="adl_total" name="adl_total" readonly value="{{ isset($asesmen->rmeAsesmenPerinatologyFungsional) ? $asesmen->rmeAsesmenPerinatologyFungsional->nilai_skala_adl : '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kesimpulan Fungsional</label>
                                        <div id="adl_kesimpulan" class="alert {{ isset($asesmen->rmeAsesmenPerinatologyFungsional) && $asesmen->rmeAsesmenPerinatologyFungsional->kesimpulan_fungsional ?
                                            (strpos($asesmen->rmeAsesmenPerinatologyFungsional->kesimpulan_fungsional, 'Ketergantungan Total') !== false ? 'alert-danger' :
                                            (strpos($asesmen->rmeAsesmenPerinatologyFungsional->kesimpulan_fungsional, 'Ketergantungan Berat') !== false ? 'alert-warning' :
                                            (strpos($asesmen->rmeAsesmenPerinatologyFungsional->kesimpulan_fungsional, 'Ketergantungan Sedang') !== false ? 'alert-info' : 'alert-success')))
                                            : 'alert-info' }}">
                                            {{ isset($asesmen->rmeAsesmenPerinatologyFungsional) && $asesmen->rmeAsesmenPerinatologyFungsional->kesimpulan_fungsional ? $asesmen->rmeAsesmenPerinatologyFungsional->kesimpulan_fungsional : 'Pilih skala aktivitas harian terlebih dahulu' }}
                                        </div>
                                    </div>

                                    <!-- Hidden fields untuk menyimpan data ADL -->
                                    <input type="hidden" id="adl_jenis_skala" name="adl_jenis_skala" value="{{ isset($asesmen->rmeAsesmenPerinatologyFungsional) ? $asesmen->rmeAsesmenPerinatologyFungsional->jenis_skala : '' }}">
                                    <input type="hidden" id="adl_makan" name="adl_makan" value="{{ isset($asesmen->rmeAsesmenPerinatologyFungsional) ? $asesmen->rmeAsesmenPerinatologyFungsional->makan : '' }}">
                                    <input type="hidden" id="adl_makan_value" name="adl_makan_value" value="{{ isset($asesmen->rmeAsesmenPerinatologyFungsional) ? $asesmen->rmeAsesmenPerinatologyFungsional->makan_value : '' }}">
                                    <input type="hidden" id="adl_berjalan" name="adl_berjalan" value="{{ isset($asesmen->rmeAsesmenPerinatologyFungsional) ? $asesmen->rmeAsesmenPerinatologyFungsional->berjalan : '' }}">
                                    <input type="hidden" id="adl_berjalan_value" name="adl_berjalan_value" value="{{ isset($asesmen->rmeAsesmenPerinatologyFungsional) ? $asesmen->rmeAsesmenPerinatologyFungsional->berjalan_value : '' }}">
                                    <input type="hidden" id="adl_mandi" name="adl_mandi" value="{{ isset($asesmen->rmeAsesmenPerinatologyFungsional) ? $asesmen->rmeAsesmenPerinatologyFungsional->mandi : '' }}">
                                    <input type="hidden" id="adl_mandi_value" name="adl_mandi_value" value="{{ isset($asesmen->rmeAsesmenPerinatologyFungsional) ? $asesmen->rmeAsesmenPerinatologyFungsional->mandi_value : '' }}">
                                    <input type="hidden" id="adl_kesimpulan_value" name="adl_kesimpulan_value" value="{{ isset($asesmen->rmeAsesmenPerinatologyFungsional) ? $asesmen->rmeAsesmenPerinatologyFungsional->kesimpulan_fungsional : '' }}">
                                </div>

                                <!-- 12. Kebutuhan Edukasi -->
                                <div class="section-separator" id="kebutuhan-edukasi">
                                    <h5 class="section-title">12. Status Kebutuhan Edukasi, Pendidikan dan Pengajaran</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Gaya Bicara</label>
                                        <select class="form-select" name="gaya_bicara">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="normal" {{ $asesmen->rmeAsesmenPerinatology->gaya_bicara == 'normal' ? 'selected' : '' }}>Normal</option>
                                            <option value="lambat" {{ $asesmen->rmeAsesmenPerinatology->gaya_bicara == 'lambat' ? 'selected' : '' }}>Lambat</option>
                                            <option value="cepat" {{ $asesmen->rmeAsesmenPerinatology->gaya_bicara == 'cepat' ? 'selected' : '' }}>Cepat</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Bahasa Sehari-Hari</label>
                                        <select class="form-select" name="bahasa_sehari_hari">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="Bahasa Indonesia" {{ $asesmen->rmeAsesmenPerinatology->bahasa == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                            <option value="Aceh" {{ $asesmen->rmeAsesmenPerinatology->bahasa == 'Aceh' ? 'selected' : '' }}>Aceh</option>
                                            <option value="Batak" {{ $asesmen->rmeAsesmenPerinatology->bahasa == 'Batak' ? 'selected' : '' }}>Batak</option>
                                            <option value="Minangkabau" {{ $asesmen->rmeAsesmenPerinatology->bahasa == 'Minangkabau' ? 'selected' : '' }}>Minangkabau</option>
                                            <option value="Melayu" {{ $asesmen->rmeAsesmenPerinatology->bahasa == 'Melayu' ? 'selected' : '' }}>Melayu</option>
                                            <option value="Sunda" {{ $asesmen->rmeAsesmenPerinatology->bahasa == 'Sunda' ? 'selected' : '' }}>Sunda</option>
                                            <option value="Jawa" {{ $asesmen->rmeAsesmenPerinatology->bahasa == 'Jawa' ? 'selected' : '' }}>Jawa</option>
                                            <option value="Madura" {{ $asesmen->rmeAsesmenPerinatology->bahasa == 'Madura' ? 'selected' : '' }}>Madura</option>
                                            <option value="Bali" {{ $asesmen->rmeAsesmenPerinatology->bahasa == 'Bali' ? 'selected' : '' }}>Bali</option>
                                            <option value="Sasak" {{ $asesmen->rmeAsesmenPerinatology->bahasa == 'Sasak' ? 'selected' : '' }}>Sasak</option>
                                            <option value="Banjar" {{ $asesmen->rmeAsesmenPerinatology->bahasa == 'Banjar' ? 'selected' : '' }}>Banjar</option>
                                            <option value="Bugis" {{ $asesmen->rmeAsesmenPerinatology->bahasa == 'Bugis' ? 'selected' : '' }}>Bugis</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Perlu Penerjemah</label>
                                        <select class="form-select" name="perlu_penerjemah">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="ya" {{ $asesmen->rmeAsesmenPerinatology->perlu_penerjemahan == 'ya' ? 'selected' : '' }}>Ya</option>
                                            <option value="tidak" {{ $asesmen->rmeAsesmenPerinatology->perlu_penerjemahan == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Hambatan Komunikasi</label>
                                        <select class="form-select" name="hambatan_komunikasi">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="tidak_ada" {{ $asesmen->rmeAsesmenPerinatology->hambatan_komunikasi == 'tidak_ada' ? 'selected' : '' }}>Tidak Ada</option>
                                            <option value="pendengaran" {{ $asesmen->rmeAsesmenPerinatology->hambatan_komunikasi == 'pendengaran' ? 'selected' : '' }}>Gangguan Pendengaran</option>
                                            <option value="bicara" {{ $asesmen->rmeAsesmenPerinatology->hambatan_komunikasi == 'bicara' ? 'selected' : '' }}>Gangguan Bicara</option>
                                            <option value="bahasa" {{ $asesmen->rmeAsesmenPerinatology->hambatan_komunikasi == 'bahasa' ? 'selected' : '' }}>Perbedaan Bahasa</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media Disukai</label>
                                        <select class="form-select" name="media_disukai">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="cetak" {{ $asesmen->rmeAsesmenPerinatology->media_disukai == 'cetak' ? 'selected' : '' }}>Media Cetak</option>
                                            <option value="video" {{ $asesmen->rmeAsesmenPerinatology->media_disukai == 'video' ? 'selected' : '' }}>Video</option>
                                            <option value="diskusi" {{ $asesmen->rmeAsesmenPerinatology->media_disukai == 'diskusi' ? 'selected' : '' }}>Diskusi Langsung</option>
                                            <option value="demonstrasi" {{ $asesmen->rmeAsesmenPerinatology->media_disukai == 'demonstrasi' ? 'selected' : '' }}>Demonstrasi</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pendidikan</label>
                                        <select class="form-select" name="tingkat_pendidikan">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="SD" {{ $asesmen->rmeAsesmenPerinatology->tingkat_pendidikan == 'SD' ? 'selected' : '' }}>SD</option>
                                            <option value="SMP" {{ $asesmen->rmeAsesmenPerinatology->tingkat_pendidikan == 'SMP' ? 'selected' : '' }}>SMP</option>
                                            <option value="SMA" {{ $asesmen->rmeAsesmenPerinatology->tingkat_pendidikan == 'SMA' ? 'selected' : '' }}>SMA</option>
                                            <option value="Diploma" {{ $asesmen->rmeAsesmenPerinatology->tingkat_pendidikan == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                            <option value="Sarjana" {{ $asesmen->rmeAsesmenPerinatology->tingkat_pendidikan == 'Sarjana' ? 'selected' : '' }}>Sarjana</option>
                                            <option value="Tidak Sekolah" {{ $asesmen->rmeAsesmenPerinatology->tingkat_pendidikan == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- 13. Plan -->
                                <div class="section-separator" id="discharge-planning">
                                    <h5 class="section-title">13. Discharge Planning</h5>

                                    {{-- <div class="mb-4">
                                        <label class="form-label">Diagnosis medis</label>
                                        <input type="text" class="form-control" name="diagnosis_medis"
                                            placeholder="Diagnosis"
                                            value="{{ $asesmen->rmeAsesmenPerinatologyRencanaPulang->diagnosis_medis ?? '' }}">
                                    </div> --}}

                                    <div class="mb-4">
                                        <label class="form-label">Usia lanjut</label>
                                        <select class="form-select" name="usia_lanjut">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="0"
                                                {{ optional($asesmen->rmeAsesmenPerinatologyRencanaPulang)->usia_lanjut == '0' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="1"
                                                {{ optional($asesmen->rmeAsesmenPerinatologyRencanaPulang)->usia_lanjut == '1' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Hambatan mobilisasi</label>
                                        <select class="form-select" name="hambatan_mobilisasi">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="0"
                                                {{ optional($asesmen->rmeAsesmenPerinatologyRencanaPulang)->hambatan_mobilisasi == '0' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="1"
                                                {{ optional($asesmen->rmeAsesmenPerinatologyRencanaPulang)->hambatan_mobilisasi == '1' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Membutuhkan penggunaan media berkelanjutan</label>
                                        <select class="form-select" name="penggunaan_media_berkelanjutan">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="ya"
                                                {{ optional($asesmen->rmeAsesmenPerinatologyRencanaPulang)->membutuhkan_pelayanan_medis == 'ya' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="tidak"
                                                {{ optional($asesmen->rmeAsesmenPerinatologyRencanaPulang)->membutuhkan_pelayanan_medis == 'tidak' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Ketergantungan dengan orang lain dalam aktivitas harian</label>
                                        <select class="form-select" name="ketergantungan_aktivitas">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Pasien / Keluarga Memerlukan Keterampilan Khusus Setelah Pulang</label>
                                        <select class="form-select" name="keterampilan_khusus">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="ya"
                                                {{ optional($asesmen->rmeAsesmenPerinatologyRencanaPulang)->memerlukan_keterampilan_khusus == 'ya' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="tidak"
                                                {{ optional($asesmen->rmeAsesmenPerinatologyRencanaPulang)->memerlukan_keterampilan_khusus == 'tidak' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Pasien Memerlukan Alat Bantu Setelah Keluar Rumah Sakit</label>
                                        <select class="form-select" name="alat_bantu">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="ya"
                                                {{ optional($asesmen->rmeAsesmenPerinatologyRencanaPulang)->memerlukan_alat_bantu == 'ya' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="tidak"
                                                {{ optional($asesmen->rmeAsesmenPerinatologyRencanaPulang)->memerlukan_alat_bantu == 'tidak' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Pasien Memiliki Nyeri Kronis Dan / Kebiasaan Setelah Pulang</label>
                                        <select class="form-select" name="nyeri_kronis">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="ya"
                                                {{ optional($asesmen->rmeAsesmenPerinatologyRencanaPulang)->memiliki_nyeri_kronis == 'ya' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="tidak"
                                                {{ optional($asesmen->rmeAsesmenPerinatologyRencanaPulang)->memiliki_nyeri_kronis == 'tidak' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Perkiraan lama hari dirawat</label>
                                            <input type="text" class="form-control" name="perkiraan_hari"
                                                placeholder="hari"
                                                value="{{ optional($asesmen->rmeAsesmenPerinatologyRencanaPulang)->perkiraan_lama_dirawat ?? '' }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Rencana Tanggal Pulang</label>
                                            <input type="date" class="form-control" name="tanggal_pulang"
                                                value="{{ optional($asesmen->rmeAsesmenPerinatologyRencanaPulang)->rencana_pulang ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <label class="form-label">KESIMPULAN</label>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="alert alert-info">
                                                Pilih semua Planning
                                            </div>
                                            <div class="alert alert-warning">
                                                Mebutuhkan rencana pulang khusus
                                            </div>
                                            <div class="alert alert-success">
                                                Tidak mebutuhkan rencana pulang khusus
                                            </div>
                                        </div>
                                        <input type="hidden" id="kesimpulan" name="kesimpulan_planing"
                                            value="{{ optional($asesmen->rmeAsesmenPerinatologyRencanaPulang)->kesimpulan ?? 'Tidak mebutuhkan rencana pulang khusus' }}">
                                    </div>
                                </div>

                                <!-- 16. Masalah/Diagnosis Keperawatan -->
                                <div class="section-separator" id="diagnosis-keperawatan">
                                    <h5 class="section-title">16. Masalah/Diagnosis Keperawatan</h5>
                                    <p class="text-muted">Diisi berdasarkan hasil asesmen dan berurut sesuai masalah
                                        yang dominan terlebih dahulu</p>

                                    <!-- Field 1: Masalah/Diagnosis Keperawatan -->
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-label fw-bold">1. Masalah/Diagnosis Keperawatan</label>
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                id="btnTambahMasalah">
                                                <i class="bi bi-plus"></i> Tambah
                                            </button>
                                        </div>

                                        <div id="masalahContainer">
                                            <div class="masalah-item mb-2">
                                                <div class="d-flex gap-2">
                                                    <textarea class="form-control" name="masalah_diagnosis[]" rows="2"
                                                        placeholder="Tuliskan masalah atau diagnosis keperawatan..."></textarea>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger remove-masalah"
                                                        onclick="removeMasalah(this)" style="display: none;">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Field 2: Intervensi/Rencana Asuhan -->
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-label fw-bold">2. Intervensi/Rencana Asuhan dan Target
                                                Terukur</label>
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                id="btnTambahIntervensi">
                                                <i class="bi bi-plus"></i> Tambah
                                            </button>
                                        </div>

                                        <div id="intervensiContainer">
                                            <div class="intervensi-item mb-2">
                                                <div class="d-flex gap-2">
                                                    <textarea class="form-control" name="intervensi_rencana[]" rows="3"
                                                        placeholder="Tuliskan intervensi, rencana asuhan, dan target yang terukur..."></textarea>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger remove-intervensi"
                                                        onclick="removeIntervensi(this)" style="display: none;">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{-- Final section - Submit button --}}
                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary">Update Asesmen</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Include modals --}}
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-perinatology.modal-create-downscore')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-perinatology.modal-intervensirisikojatuh')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-perinatology.modal-skala-adl')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-skalanyeri')


    <!-- Modal Alergi -->
    <div class="modal fade" id="alergiModal" tabindex="-1" aria-labelledby="alergiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alergiModalLabel">Manajemen Data Alergi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Input Alergi -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Tambah Data Alergi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="modal_jenis_alergi" class="form-label">Jenis Alergi</label>
                                    <select class="form-select" id="modal_jenis_alergi">
                                        <option value="">-- Pilih Jenis Alergi --</option>
                                        <option value="Obat">Obat</option>
                                        <option value="Makanan">Makanan</option>
                                        <option value="Udara">Udara</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="modal_alergen" class="form-label">Alergen</label>
                                    <input type="text" class="form-control" id="modal_alergen"
                                        placeholder="Contoh: Paracetamol, Seafood, Debu">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="modal_reaksi" class="form-label">Reaksi</label>
                                    <input type="text" class="form-control" id="modal_reaksi"
                                        placeholder="Contoh: Gatal, Ruam, Sesak nafas">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="modal_tingkat_keparahan" class="form-label">Tingkat Keparahan</label>
                                    <select class="form-select" id="modal_tingkat_keparahan">
                                        <option value="">-- Pilih Tingkat Keparahan --</option>
                                        <option value="Ringan">Ringan</option>
                                        <option value="Sedang">Sedang</option>
                                        <option value="Berat">Berat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-primary btn-sm" id="addToAlergiList">
                                    <i class="bi bi-plus"></i> Tambah ke Daftar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Alergi -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0">Daftar Alergi Pasien</h6>
                            <span class="badge bg-primary" id="alergiCount">0</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="20%">Jenis Alergi</th>
                                            <th width="25%">Alergen</th>
                                            <th width="25%">Reaksi</th>
                                            <th width="20%">Tingkat Keparahan</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modalAlergiList">
                                        <!-- Data akan ditampilkan di sini -->
                                    </tbody>
                                </table>
                            </div>
                            <div id="noAlergiMessage" class="text-center text-muted py-3" style="display: none;">
                                <i class="bi bi-info-circle"></i> Belum ada data alergi
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="saveAlergiData">
                        <i class="bi bi-check"></i> Simpan Data Alergi
                    </button>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@push('js')
    <script>
        // Pass data from PHP to JavaScript
        window.alergiPasienData = @json($alergiPasien ?? []);
        
        // Parse masalah diagnosis data
        window.masalahDiagnosisData = [];
        window.intervensiRencanaData = [];
        
        @if(isset($asesmen->masalah_diagnosis_parsed))
            window.masalahDiagnosisData = @json($asesmen->masalah_diagnosis_parsed);
        @endif
        
        @if(isset($asesmen->intervensi_rencana_parsed))
            window.intervensiRencanaData = @json($asesmen->intervensi_rencana_parsed);
        @endif
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            'use strict';

            // ==================================================================================
            // CONFIGURATION AND UTILITIES
            // ==================================================================================
            
            const CONFIG = {
                STORAGE_KEYS: {
                    ALERGI: 'alergisInput',
                    MASALAH_DIAGNOSIS: 'masalah_diagnosis',
                    INTERVENSI_RENCANA: 'intervensi_rencana'
                }
            };

            function showAlert(message, type = 'info') {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: type,
                        title: type === 'error' ? 'Error' : 'Information',
                        text: message,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                } else {
                    alert(message);
                }
            }

            // ==================================================================================
            // ALLERGY MODULE - FIXED
            // ==================================================================================
            
            const AllergyModule = {
                alergiDataArray: [],
                
                init() {
                    console.log('Initializing Allergy Module...');
                    this.loadExistingData();
                    this.initEventListeners();
                    this.updateMainAlergiTable();
                    this.updateHiddenAlergiInput();
                },

                loadExistingData() {
                    try {
                        // Load from PHP variable passed to JavaScript
                        if (typeof window.alergiPasienData !== 'undefined') {
                            this.alergiDataArray = window.alergiPasienData.map(item => ({
                                jenis_alergi: item.jenis_alergi || '',
                                alergen: item.nama_alergi || '',
                                reaksi: item.reaksi || '',
                                tingkat_keparahan: item.tingkat_keparahan || '',
                                is_existing: true,
                                id: item.id || null
                            }));
                        } else {
                            // Fallback: try to load from hidden input
                            const hiddenInput = document.getElementById('alergisInput');
                            if (hiddenInput && hiddenInput.value) {
                                const data = JSON.parse(hiddenInput.value);
                                this.alergiDataArray = data || [];
                            }
                        }
                        
                        console.log('Loaded allergy data:', this.alergiDataArray);
                    } catch (e) {
                        console.error('Error loading existing alergi data:', e);
                        this.alergiDataArray = [];
                    }
                },

                initEventListeners() {
                    const openAlergiModal = document.getElementById('openAlergiModal');
                    const addToAlergiList = document.getElementById('addToAlergiList');
                    const saveAlergiData = document.getElementById('saveAlergiData');

                    if (openAlergiModal) {
                        openAlergiModal.addEventListener('click', () => {
                            this.updateModalAlergiList();
                        });
                    }

                    if (addToAlergiList) {
                        addToAlergiList.addEventListener('click', () => {
                            this.addAlergiToList();
                        });
                    }

                    if (saveAlergiData) {
                        saveAlergiData.addEventListener('click', () => {
                            this.saveAlergiData();
                        });
                    }
                },

                addAlergiToList() {
                    const jenisAlergi = document.getElementById('modal_jenis_alergi')?.value?.trim();
                    const alergen = document.getElementById('modal_alergen')?.value?.trim();
                    const reaksi = document.getElementById('modal_reaksi')?.value?.trim();
                    const tingkatKeparahan = document.getElementById('modal_tingkat_keparahan')?.value?.trim();

                    if (!jenisAlergi || !alergen || !reaksi || !tingkatKeparahan) {
                        showAlert('Semua field harus diisi', 'warning');
                        return;
                    }

                    // Check for duplicates
                    const isDuplicate = this.alergiDataArray.some(item =>
                        item.jenis_alergi === jenisAlergi &&
                        item.alergen.toLowerCase() === alergen.toLowerCase()
                    );

                    if (isDuplicate) {
                        showAlert('Alergi ini sudah ada dalam daftar', 'warning');
                        return;
                    }

                    this.alergiDataArray.push({
                        jenis_alergi: jenisAlergi,
                        alergen: alergen,
                        reaksi: reaksi,
                        tingkat_keparahan: tingkatKeparahan,
                        is_existing: false
                    });

                    this.updateModalAlergiList();
                    this.resetAlergiForm();
                },

                updateModalAlergiList() {
                    const tbody = document.getElementById('modalAlergiList');
                    const noDataMessage = document.getElementById('noAlergiMessage');
                    const countBadge = document.getElementById('alergiCount');

                    if (!tbody) return;

                    tbody.innerHTML = '';

                    if (this.alergiDataArray.length === 0) {
                        if (noDataMessage) noDataMessage.style.display = 'block';
                        const table = tbody.closest('table');
                        if (table) table.style.display = 'none';
                    } else {
                        if (noDataMessage) noDataMessage.style.display = 'none';
                        const table = tbody.closest('table');
                        if (table) table.style.display = 'table';

                        this.alergiDataArray.forEach((item, index) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${item.jenis_alergi}</td>
                                <td>${item.alergen}</td>
                                <td>${item.reaksi}</td>
                                <td>
                                    <span class="badge ${this.getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                        ${item.tingkat_keparahan}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="AllergyModule.removeAlergiFromModal(${index})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    ${item.is_existing ? '<small class="text-muted d-block">Dari DB</small>' : '<small class="text-success d-block">Baru</small>'}
                                </td>
                            `;
                            tbody.appendChild(row);
                        });
                    }

                    if (countBadge) countBadge.textContent = this.alergiDataArray.length;
                },

                updateMainAlergiTable() {
                    const tbody = document.querySelector('#createAlergiTable tbody');
                    if (!tbody) return;

                    // Remove existing rows except no-alergi-row
                    const existingRows = tbody.querySelectorAll('tr:not(#no-alergi-row)');
                    existingRows.forEach(row => row.remove());

                    const noAlergiRow = document.getElementById('no-alergi-row');

                    if (this.alergiDataArray.length === 0) {
                        if (!noAlergiRow) {
                            const emptyRow = document.createElement('tr');
                            emptyRow.id = 'no-alergi-row';
                            emptyRow.innerHTML = '<td colspan="5" class="text-center text-muted">Belum ada data alergi</td>';
                            tbody.appendChild(emptyRow);
                        } else {
                            noAlergiRow.style.display = 'table-row';
                        }
                    } else {
                        if (noAlergiRow) noAlergiRow.style.display = 'none';

                        this.alergiDataArray.forEach((item, index) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${item.jenis_alergi}</td>
                                <td>${item.alergen}</td>
                                <td>${item.reaksi}</td>
                                <td>
                                    <span class="badge ${this.getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                        ${item.tingkat_keparahan}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="AllergyModule.removeAlergiFromMain(${index})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            `;
                            tbody.appendChild(row);
                        });
                    }
                },

                saveAlergiData() {
                    this.updateMainAlergiTable();
                    this.updateHiddenAlergiInput();

                    const alergiModal = document.getElementById('alergiModal');
                    if (alergiModal && typeof bootstrap !== 'undefined') {
                        const modalInstance = bootstrap.Modal.getInstance(alergiModal);
                        if (modalInstance) modalInstance.hide();
                    }

                    showAlert('Data alergi berhasil disimpan', 'success');
                },

                resetAlergiForm() {
                    const fields = ['modal_jenis_alergi', 'modal_alergen', 'modal_reaksi', 'modal_tingkat_keparahan'];
                    fields.forEach(fieldId => {
                        const field = document.getElementById(fieldId);
                        if (field) field.value = '';
                    });
                },

                updateHiddenAlergiInput() {
                    const hiddenInput = document.getElementById('alergisInput');
                    if (hiddenInput) {
                        hiddenInput.value = JSON.stringify(this.alergiDataArray);
                    }
                },

                getKeparahanBadgeClass(keparahan) {
                    switch (keparahan?.toLowerCase()) {
                        case 'ringan': return 'bg-success';
                        case 'sedang': return 'bg-warning';
                        case 'berat': return 'bg-danger';
                        default: return 'bg-secondary';
                    }
                },

                removeAlergiFromModal(index) {
                    this.alergiDataArray.splice(index, 1);
                    this.updateModalAlergiList();
                },

                removeAlergiFromMain(index) {
                    this.alergiDataArray.splice(index, 1);
                    this.updateMainAlergiTable();
                    this.updateHiddenAlergiInput();
                }
            };

            // Make AllergyModule globally accessible
            window.AllergyModule = AllergyModule;

            // ==================================================================================
            // MASALAH DIAGNOSIS MODULE - FIXED
            // ==================================================================================
            
            const MasalahDiagnosisModule = {
                init() {
                    console.log('Initializing Masalah Diagnosis Module...');
                    this.initMasalahFields();
                    this.initIntervensiFields();
                },

                initMasalahFields() {
                    const masalahContainer = document.getElementById('masalahContainer');
                    const btnTambahMasalah = document.getElementById('btnTambahMasalah');

                    if (!masalahContainer) {
                        console.warn('masalahContainer not found');
                        return;
                    }

                    // Get existing data from PHP
                    let existingData = [];
                    if (typeof window.masalahDiagnosisData !== 'undefined') {
                        existingData = window.masalahDiagnosisData;
                    }

                    console.log('Masalah diagnosis existing data:', existingData);

                    // Clear container
                    masalahContainer.innerHTML = '';

                    // Add existing data or create first empty field
                    if (existingData && existingData.length > 0) {
                        existingData.forEach((masalah, index) => {
                            this.addMasalahField(masalahContainer, masalah, index === 0);
                        });
                    } else {
                        this.addMasalahField(masalahContainer, '', true);
                    }

                    // Add event listener for adding new masalah
                    if (btnTambahMasalah) {
                        btnTambahMasalah.addEventListener('click', () => {
                            this.addMasalahField(masalahContainer, '', false);
                        });
                    }
                },

                initIntervensiFields() {
                    const intervensiContainer = document.getElementById('intervensiContainer');
                    const btnTambahIntervensi = document.getElementById('btnTambahIntervensi');

                    if (!intervensiContainer) {
                        console.warn('intervensiContainer not found');
                        return;
                    }

                    // Get existing data from PHP
                    let existingData = [];
                    if (typeof window.intervensiRencanaData !== 'undefined') {
                        existingData = window.intervensiRencanaData;
                    }

                    console.log('Intervensi rencana existing data:', existingData);

                    // Clear container
                    intervensiContainer.innerHTML = '';

                    // Add existing data or create first empty field
                    if (existingData && existingData.length > 0) {
                        existingData.forEach((intervensi, index) => {
                            this.addIntervensiField(intervensiContainer, intervensi, index === 0);
                        });
                    } else {
                        this.addIntervensiField(intervensiContainer, '', true);
                    }

                    // Add event listener for adding new intervensi
                    if (btnTambahIntervensi) {
                        btnTambahIntervensi.addEventListener('click', () => {
                            this.addIntervensiField(intervensiContainer, '', false);
                        });
                    }
                },

                addMasalahField(container, value = '', isFirst = false) {
                    const masalahItem = document.createElement('div');
                    masalahItem.className = 'masalah-item mb-2';

                    masalahItem.innerHTML = `
                        <div class="d-flex gap-2">
                            <textarea class="form-control" name="masalah_diagnosis[]" rows="2"
                                placeholder="Tuliskan masalah atau diagnosis keperawatan...">${value}</textarea>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-masalah"
                                style="display: ${isFirst ? 'none' : 'block'};">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;

                    container.appendChild(masalahItem);

                    // Add remove event listener
                    const removeBtn = masalahItem.querySelector('.remove-masalah');
                    if (removeBtn) {
                        removeBtn.addEventListener('click', () => {
                            masalahItem.remove();
                            this.updateMasalahRemoveButtons();
                        });
                    }

                    this.updateMasalahRemoveButtons();
                },

                addIntervensiField(container, value = '', isFirst = false) {
                    const intervensiItem = document.createElement('div');
                    intervensiItem.className = 'intervensi-item mb-2';

                    intervensiItem.innerHTML = `
                        <div class="d-flex gap-2">
                            <textarea class="form-control" name="intervensi_rencana[]" rows="3"
                                placeholder="Tuliskan intervensi, rencana asuhan, dan target yang terukur...">${value}</textarea>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-intervensi"
                                style="display: ${isFirst ? 'none' : 'block'};">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;

                    container.appendChild(intervensiItem);

                    // Add remove event listener
                    const removeBtn = intervensiItem.querySelector('.remove-intervensi');
                    if (removeBtn) {
                        removeBtn.addEventListener('click', () => {
                            intervensiItem.remove();
                            this.updateIntervensiRemoveButtons();
                        });
                    }

                    this.updateIntervensiRemoveButtons();
                },

                updateMasalahRemoveButtons() {
                    const masalahItems = document.querySelectorAll('.masalah-item');
                    masalahItems.forEach((item, index) => {
                        const removeBtn = item.querySelector('.remove-masalah');
                        if (removeBtn) {
                            removeBtn.style.display = (index === 0 && masalahItems.length === 1) ? 'none' : 'block';
                        }
                    });
                },

                updateIntervensiRemoveButtons() {
                    const intervensiItems = document.querySelectorAll('.intervensi-item');
                    intervensiItems.forEach((item, index) => {
                        const removeBtn = item.querySelector('.remove-intervensi');
                        if (removeBtn) {
                            removeBtn.style.display = (index === 0 && intervensiItems.length === 1) ? 'none' : 'block';
                        }
                    });
                }
            };

            // ==================================================================================
            // OTHER EXISTING MODULES (keeping your existing functionality)
            // ==================================================================================
            
            function initPemeriksaanFisik() {
                // Handle "Tambah Keterangan" buttons
                document.querySelectorAll('.tambah-keterangan').forEach(button => {
                    button.addEventListener('click', function() {
                        const targetId = this.getAttribute('data-target');
                        const keteranganDiv = document.getElementById(targetId);
                        const normalCheckbox = this.closest('.pemeriksaan-item')?.querySelector('.form-check-input');

                        if (keteranganDiv) {
                            keteranganDiv.style.display = 'block';
                            if (normalCheckbox) normalCheckbox.checked = false;
                        }
                    });
                });

                // Handle normal checkboxes
                document.querySelectorAll('.form-check-input').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const pemeriksaanItem = this.closest('.pemeriksaan-item');
                        if (pemeriksaanItem) {
                            const keteranganDiv = pemeriksaanItem.querySelector('.keterangan');
                            if (keteranganDiv && this.checked) {
                                keteranganDiv.style.display = 'none';
                                const input = keteranganDiv.querySelector('input');
                                if (input) input.value = '';
                            }
                        }
                    });
                });

                // Initialize existing data
                document.querySelectorAll('.pemeriksaan-item').forEach(item => {
                    const keteranganInput = item.querySelector('.keterangan input');
                    const normalCheckbox = item.querySelector('.form-check-input');
                    const keteranganDiv = item.querySelector('.keterangan');

                    if (keteranganInput && keteranganInput.value && keteranganDiv) {
                        if (normalCheckbox) normalCheckbox.checked = false;
                        keteranganDiv.style.display = 'block';
                    }
                });
            }

            // ==================================================================================
            // INITIALIZE ALL MODULES
            // ==================================================================================

            function initializeApp() {
                console.log('Initializing Asesmen Perinatology Edit...');
                
                // Initialize core modules
                AllergyModule.init();
                MasalahDiagnosisModule.init();
                initPemeriksaanFisik();
                
                // Initialize other existing functionality
                if (typeof initDownScore === 'function') initDownScore();
                if (typeof initStatusNyeri === 'function') initStatusNyeri();
                if (typeof initRisikoJatuh === 'function') initRisikoJatuh();
                if (typeof initStatusGizi === 'function') initStatusGizi();
                if (typeof initStatusFungsional === 'function') initStatusFungsional();
                if (typeof initDischargePlanning === 'function') initDischargePlanning();
                if (typeof initDecubitus === 'function') initDecubitus();
                
                console.log('Asesmen Perinatology Edit initialized successfully');
            }

            // Start the application
            initializeApp();
        });
    </script>
@endpush
