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
@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-perinatology.include-edit')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-kep-anak')
        </div>

        <div class="col-md-9">
            <x-content-card>
            <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Edit Asesmen Awal Keperawatan Perinatology',
                    'description' => 'Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan',
                ])

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
                                <label style="min-width: 200px;">Sidik Jari Ibu</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Jari Kiri</label>
                                        <div class="input-group mb-2">
                                            <input type="file" 
                                                class="form-control @error('sidik_jari_ibu_kiri') is-invalid @enderror"
                                                name="sidik_jari_ibu_kiri">
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
                                        @error('sidik_jari_ibu_kiri')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Jari Kanan</label>
                                        <div class="input-group mb-2">
                                            <input type="file" 
                                                class="form-control @error('sidik_jari_ibu_kanan') is-invalid @enderror"
                                                name="sidik_jari_ibu_kanan">
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
                                        @error('sidik_jari_ibu_kanan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Sidik Jari Bayi</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Jari Kiri</label>
                                        <div class="input-group mb-2">
                                            <input type="file" 
                                                class="form-control @error('sidik_jari_bayi_kiri') is-invalid @enderror"
                                                name="sidik_jari_bayi_kiri">
                                        </div>
                                        @if($asesmen->rmeAsesmenPerinatology->sidik_jari_bayi_kiri ?? '')
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                <small class="text-success">File sudah diunggah sebelumnya</small>
                                                <a href="{{ Storage::url($asesmen->rmeAsesmenPerinatology->sidik_jari_bayi_kiri) }}"
                                                class="btn btn-sm btn-info ms-2" target="_blank">
                                                    <i class="bi bi-eye"></i> Lihat
                                                </a>
                                            </div>
                                        @endif
                                        <small class="text-muted">Format: JPG, PNG, PDF | Maks: 10MB</small>
                                        @error('sidik_jari_bayi_kiri')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Jari Kanan</label>
                                        <div class="input-group mb-2">
                                            <input type="file" 
                                                class="form-control @error('sidik_jari_bayi_kanan') is-invalid @enderror"
                                                name="sidik_jari_bayi_kanan">
                                        </div>
                                        @if($asesmen->rmeAsesmenPerinatology->sidik_jari_bayi_kanan ?? '')
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                <small class="text-success">File sudah diunggah sebelumnya</small>
                                                <a href="{{ Storage::url($asesmen->rmeAsesmenPerinatology->sidik_jari_bayi_kanan) }}"
                                                class="btn btn-sm btn-info ms-2" target="_blank">
                                                    <i class="bi bi-eye"></i> Lihat
                                                </a>
                                            </div>
                                        @endif
                                        <small class="text-muted">Format: JPG, PNG, PDF | Maks: 10MB</small>
                                        @error('sidik_jari_bayi_kanan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                            <option value="kuat" {{ optional($asesmen->rmeAsesmenPerinatologyFisik)->status_frekuensi == 'kuat' ? 'selected' : '' }} >kuat</option>
                                            <option value="lemah" {{ optional($asesmen->rmeAsesmenPerinatologyFisik)->status_frekuensi == 'lemah' ? 'selected' : ''}} >lemah</option>
                                            <option value="teratur" {{ optional($asesmen->rmeAsesmenPerinatologyFisik)->status_frekuensi == 'teratur' ? 'selected' : ''}} >teratur</option>
                                            <option value="tidak teratur" {{ optional($asesmen->rmeAsesmenPerinatologyFisik)->status_frekuensi == 'tidak teratur' ? 'selected' : ''}} >tidak teratur</option>
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
                                        <input type="number" class="form-control" name="spo2_tanpa_bantuan"
                                            value="{{ $asesmen->rmeAsesmenPerinatologyFisik->spo2_tanpa_bantuan }}"
                                            placeholder="Tanpa bantuan O2">
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-label">Dengan Bantuan O2</label>
                                        <input type="number" class="form-control" name="spo2_dengan_bantuan"
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
                                        <option value="" selected>--Pilih--</option>
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
                                        <option value="" selected>--Pilih--</option>
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
                                    <option value="norton" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->jenis_skala == 1 ? 'selected' : '' }}>Skala Norton</option>
                                    <option value="braden" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->jenis_skala == 2 ? 'selected' : '' }}>Skala Braden</option>
                                </select>
                            </div>

                            <!-- Form Skala Norton -->
                            <div id="formNorton" class="decubitus-form" style="display: none;">
                                <h6 class="mb-4">Penilaian Risiko DECUBITUS Skala Norton</h6>

                                <div class="mb-4">
                                    <label class="form-label">Kondisi Fisik</label>
                                    <select class="form-select bg-light" name="kondisi_fisik">
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="4" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_kondisi_fisik == '4' ? 'selected' : '' }}>Baik</option>
                                        <option value="3" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_kondisi_fisik == '3' ? 'selected' : '' }}>Sedang</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_kondisi_fisik == '2' ? 'selected' : '' }}>Buruk</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_kondisi_fisik == '1' ? 'selected' : '' }}>Sangat Buruk</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Kondisi mental</label>
                                    <select class="form-select bg-light" name="kondisi_mental">
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="4" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_kondisi_mental == '4' ? 'selected' : '' }}>Sadar</option>
                                        <option value="3" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_kondisi_mental == '3' ? 'selected' : '' }}>Apatis</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_kondisi_mental == '2' ? 'selected' : '' }}>Bingung</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_kondisi_mental == '1' ? 'selected' : '' }}>Stupor</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Aktivitas</label>
                                    <select class="form-select bg-light" name="norton_aktivitas">
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="4" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_aktivitas == '4' ? 'selected' : '' }}>Aktif</option>
                                        <option value="3" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_aktivitas == '3' ? 'selected' : '' }}>Jalan dengan bantuan</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_aktivitas == '2' ? 'selected' : '' }}>Terbatas di kursi</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_aktivitas == '1' ? 'selected' : '' }}>Terbatas di tempat tidur</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Mobilitas</label>
                                    <select class="form-select bg-light" name="norton_mobilitas">
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="4" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_mobilitas == '4' ? 'selected' : '' }}>Bebas bergerak</option>
                                        <option value="3" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_mobilitas == '3' ? 'selected' : '' }}>Agak terbatas</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_mobilitas == '2' ? 'selected' : '' }}>Sangat terbatas</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_mobilitas == '1' ? 'selected' : '' }}>Tidak dapat bergerak</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Inkontinensia</label>
                                    <select class="form-select bg-light" name="inkontinensia">
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="4" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_inkontenesia == '4' ? 'selected' : '' }}>Tidak ada</option>
                                        <option value="3" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_inkontenesia == '3' ? 'selected' : '' }}>Kadang-kadang</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_inkontenesia == '2' ? 'selected' : '' }}>Biasanya urin</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->norton_inkontenesia == '1' ? 'selected' : '' }}>Urin dan feses</option>
                                    </select>
                                </div>

                                <div class="mt-4">
                                    <div class="d-flex gap-2">
                                        <span class="fw-bold">Kesimpulan :</span>
                                        <div id="kesimpulanNorton"
                                            class="alert {{ strpos(optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->decubitus_kesimpulan ?? '', 'Tinggi') !== false ? 'alert-danger' : (strpos(optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->decubitus_kesimpulan ?? '', 'Sedang') !== false ? 'alert-warning' : 'alert-success') }} mb-0 flex-grow-1">
                                            {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->decubitus_kesimpulan ?? 'Risiko Rendah' }}
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
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_persepsi == '1' ? 'selected' : '' }}>Keterbatasan Penuh</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_persepsi == '2' ? 'selected' : '' }}>Sangat Terbatas</option>
                                        <option value="3" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_persepsi == '3' ? 'selected' : '' }}>Keterbatasan Ringan</option>
                                        <option value="4" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_persepsi == '4' ? 'selected' : '' }}>Tidak Ada Gangguan</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Kelembapan</label>
                                    <select class="form-select bg-light" name="kelembapan">
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_kelembapan == '1' ? 'selected' : '' }}>Selalu Lembap</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_kelembapan == '2' ? 'selected' : '' }}>Umumnya Lembap</option>
                                        <option value="3" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_kelembapan == '3' ? 'selected' : '' }}>Kadang-Kadang Lembap</option>
                                        <option value="4" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_kelembapan == '4' ? 'selected' : '' }}>Jarang Lembap</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Aktivitas</label>
                                    <select class="form-select bg-light" name="braden_aktivitas">
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_aktivitas == '1' ? 'selected' : '' }}>Total di Tempat Tidur</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_aktivitas == '2' ? 'selected' : '' }}>Dapat Duduk</option>
                                        <option value="3" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_aktivitas == '3' ? 'selected' : '' }}>Berjalan Kadang-kadang</option>
                                        <option value="4" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_aktivitas == '4' ? 'selected' : '' }}>Dapat Berjalan-jalan</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Mobilitas</label>
                                    <select class="form-select bg-light" name="braden_mobilitas">
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_mobilitas == '1' ? 'selected' : '' }}>Tidak Mampu Bergerak Sama sekali</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_mobilitas == '2' ? 'selected' : '' }}>Sangat Terbatas</option>
                                        <option value="3" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_mobilitas == '3' ? 'selected' : '' }}>Tidak Ada Masalah</option>
                                        <option value="4" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_mobilitas == '4' ? 'selected' : '' }}>Tanpa Keterbatasan</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Nutrisi</label>
                                    <select class="form-select bg-light" name="nutrisi">
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_nutrisi == '1' ? 'selected' : '' }}>Sangat Buruk</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_nutrisi == '2' ? 'selected' : '' }}>Kurang Menucukup</option>
                                        <option value="3" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_nutrisi == '3' ? 'selected' : '' }}>Mencukupi</option>
                                        <option value="4" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_nutrisi == '4' ? 'selected' : '' }}>Sangat Baik</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Pergesekan dan Pergeseran</label>
                                    <select class="form-select bg-light" name="pergesekan">
                                        <option value="" disabled>--Pilih--</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_pergesekan == '1' ? 'selected' : '' }}>Bermasalah</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_pergesekan == '2' ? 'selected' : '' }}>Potensial Bermasalah</option>
                                        <option value="3" {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->braden_pergesekan == '3' ? 'selected' : '' }}>Keterbatasan Ringan</option>
                                    </select>
                                </div>

                                <div class="mt-4">
                                    <div class="d-flex gap-2">
                                        <span class="fw-bold">Kesimpulan :</span>
                                        <div id="kesimpulanBraden"
                                            class="alert {{ strpos(optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->decubitus_kesimpulan ?? '', 'Tinggi') !== false ? 'alert-danger' : (strpos(optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->decubitus_kesimpulan ?? '', 'Sedang') !== false ? 'alert-warning' : 'alert-success') }} mb-0 flex-grow-1">
                                            {{ optional($asesmen->rmeAsesmenPerinatologyResikoDekubitus)->decubitus_kesimpulan ?? 'Kesimpulan Skala Braden' }}
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
                                    <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_jenis == 1 ? 'selected' : '' }}>Malnutrition Screening Tool (MST)</option>
                                    <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_jenis == 2 ? 'selected' : '' }}>The Mini Nutritional Assessment (MNA)</option>
                                    <option value="3" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_jenis == 3 ? 'selected' : '' }}>Strong Kids (1 bln - 18 Tahun)</option>
                                    <option value="5" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_jenis == 5 ? 'selected' : '' }}>Tidak Dapat Dinilai</option>
                                </select>
                            </div>

                            <!-- MST Form -->
                            <div id="mst" class="assessment-form" style="display: none;">
                                <h6 class="mb-3">Penilaian Gizi Malnutrition Screening Tool (MST)</h6>
                                <div class="mb-3">
                                    <label class="form-label">Apakah pasien mengalami penurunan BB yang tidak diinginkan dalam 6 bulan terakhir?</label>
                                    <select class="form-select" name="gizi_mst_penurunan_bb">
                                        <option value="">pilih</option>
                                        <option value="0" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mst_penurunan_bb == '0' ? 'selected' : '' }}>Tidak ada penurunan Berat Badan (BB)</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mst_penurunan_bb == '2' ? 'selected' : '' }}>Tidak yakin/ tidak tahu/ terasa baju lebi longgar</option>
                                        <option value="3" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mst_penurunan_bb == '3' ? 'selected' : '' }}>Ya ada penurunan BB</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jika jawaban di atas "Ya ada penurunan BB", berapa penurunan BB tersebut?</label>
                                    <select class="form-select" name="gizi_mst_jumlah_penurunan_bb">
                                        <option value="0">pilih</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mst_jumlah_penurunan_bb == '1' ? 'selected' : '' }}>1-5 kg</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mst_jumlah_penurunan_bb == '2' ? 'selected' : '' }}>6-10 kg</option>
                                        <option value="3" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mst_jumlah_penurunan_bb == '3' ? 'selected' : '' }}>11-15 kg</option>
                                        <option value="4" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mst_jumlah_penurunan_bb == '4' ? 'selected' : '' }}>>15 kg</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Apakah asupan makan berkurang karena tidak nafsu makan?</label>
                                    <select class="form-select" name="gizi_mst_nafsu_makan_berkurang">
                                        <option value="">pilih</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mst_nafsu_makan_berkurang == '1' ? 'selected' : '' }}>Ya</option>
                                        <option value="0" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mst_nafsu_makan_berkurang == '0' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pasien didiagnosa khusus seperti: DM, Cancer (kemoterapi), Geriatri, GGk (hemodialisis), Penurunan Imun</label>
                                    <select class="form-select" name="gizi_mst_diagnosis_khusus">
                                        <option value="">pilih</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mst_diagnosis_khusus == '1' ? 'selected' : '' }}>Ya</option>
                                        <option value="0" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mst_diagnosis_khusus == '0' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>
                                <!-- Nilai -->
                                <div id="mstConclusion" class="risk-indicators mt-4">
                                    <div class="alert alert-success">Kesimpulan: 0-1 tidak berisiko malnutrisi</div>
                                    <div class="alert alert-warning">Kesimpulan: ≥ 2 berisiko malnutrisi</div>
                                    <input type="hidden" name="gizi_mst_kesimpulan" id="gizi_mst_kesimpulan" value="{{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mst_kesimpulan }}">
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
                                        <option value="0" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_penurunan_asupan_3_bulan == '0' ? 'selected' : '' }}>Mengalami penurunan asupan makanan yang parah</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_penurunan_asupan_3_bulan == '1' ? 'selected' : '' }}>Mengalami penurunan asupan makanan sedang</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_penurunan_asupan_3_bulan == '2' ? 'selected' : '' }}>Tidak mengalami penurunan asupan makanan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Apakah pasien mengalami kehilangan Berat Badan (BB) selama 3 bulan terakhir?
                                    </label>
                                    <select class="form-select" name="gizi_mna_kehilangan_bb_3_bulan">
                                        <option value="">-- Pilih --</option>
                                        <option value="0" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_kehilangan_bb_3_bulan == '0' ? 'selected' : '' }}>Kehilangan BB lebih dari 3 Kg</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_kehilangan_bb_3_bulan == '1' ? 'selected' : '' }}>Tidak tahu</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_kehilangan_bb_3_bulan == '2' ? 'selected' : '' }}>Kehilangan BB antara 1 s.d 3 Kg</option>
                                        <option value="3" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_kehilangan_bb_3_bulan == '3' ? 'selected' : '' }}>Tidak ada kehilangan BB</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Bagaimana mobilisasi atau pergerakan pasien?</label>
                                    <select class="form-select" name="gizi_mna_mobilisasi">
                                        <option value="">-- Pilih --</option>
                                        <option value="0" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_mobilisasi == '0' ? 'selected' : '' }}>Hanya di tempat tidur atau kursi roda</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_mobilisasi == '1' ? 'selected' : '' }}>Dapat turun dari tempat tidur tapi tidak dapat jalan-jalan</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_mobilisasi == '2' ? 'selected' : '' }}>Dapat jalan-jalan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Apakah Pasien mengalami stres psikologi atau penyakit akut selama 3 bulan terakhir?
                                    </label>
                                    <select class="form-select" name="gizi_mna_stress_penyakit_akut">
                                        <option value="">-- Pilih --</option>
                                        <option value="0" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_stress_penyakit_akut == '0' ? 'selected' : '' }}>Ya</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_stress_penyakit_akut == '1' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Apakah pasien mengalami masalah neuropsikologi?</label>
                                    <select class="form-select" name="gizi_mna_status_neuropsikologi">
                                        <option value="">-- Pilih --</option>
                                        <option value="0" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_status_neuropsikologi == '0' ? 'selected' : '' }}>Demensia atau depresi berat</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_status_neuropsikologi == '1' ? 'selected' : '' }}>Demensia ringan</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_status_neuropsikologi == '2' ? 'selected' : '' }}>Tidak mengalami masalah neuropsikologi</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Berapa Berat Badan (BB) pasien? (Kg)</label>
                                    <input type="number" name="gizi_mna_berat_badan" class="form-control" id="mnaWeight" min="1" step="0.1" placeholder="Masukkan berat badan dalam Kg" value="{{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_berat_badan }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Berapa Tinggi Badan (TB) pasien? (cm)</label>
                                    <input type="number" name="gizi_mna_tinggi_badan" class="form-control" id="mnaHeight" min="1" step="0.1" placeholder="Masukkan tinggi badan dalam cm" value="{{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_tinggi_badan }}">
                                </div>

                                <!-- IMT -->
                                <div class="mb-3">
                                    <label class="form-label">Indeks Massa Tubuh (IMT)</label>
                                    <div class="text-muted small mb-2">
                                        <i>Rumus IMT = BB (Kg) / (TB (m))²</i>
                                    </div>
                                    <input type="number" name="gizi_mna_imt" class="form-control bg-light" id="mnaBMI" readonly placeholder="IMT akan terhitung otomatis" value="{{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_imt }}">
                                </div>

                                <!-- Kesimpulan -->
                                <div id="mnaConclusion" class="risk-indicators mt-4">
                                    <div class="alert alert-info mb-3" style="{{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_kesimpulan ? 'display: none;' : '' }}">
                                        Silakan isi semua parameter di atas untuk melihat kesimpulan
                                    </div>
                                    <div class="alert alert-success" style="{{ strpos(optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_kesimpulan ?? '', 'Tidak Beresiko') !== false ? '' : 'display: none;' }}">
                                        Kesimpulan: Total Skor ≥ 12 (Tidak Beresiko Malnutrisi)
                                    </div>
                                    <div class="alert alert-warning" style="{{ strpos(optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_kesimpulan ?? '', 'Beresiko') !== false ? '' : 'display: none;' }}">
                                        Kesimpulan: Total Skor ≤ 11 (Beresiko Malnutrisi)
                                    </div>
                                    <input type="hidden" name="gizi_mna_kesimpulan" id="gizi_mna_kesimpulan" value="{{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_mna_kesimpulan }}">
                                </div>
                            </div>

                            <!-- Strong Kids Form -->
                            <div id="strong-kids" class="assessment-form" style="display: none;">
                                <h6 class="mb-3">Penilaian Gizi Strong Kids</h6>
                                <div class="mb-3">
                                    <label class="form-label">Apakah anak tampa kurus kehilangan lemak subkutan, kehilangan massa otot, dan/ atau wajah cekung?</label>
                                    <select class="form-select" name="gizi_strong_status_kurus">
                                        <option value="">pilih</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_strong_status_kurus == '1' ? 'selected' : '' }}>Ya</option>
                                        <option value="0" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_strong_status_kurus == '0' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Apakah terdapat penurunan BB selama satu bulan terakhir (untuk semua usia)?
                                        (berdasarkan penilaian objektif data BB bila ada/penilaian subjektif dari orang tua pasien ATAU tidak ada peningkatan berat badan atau tinggi badan (pada bayi < 1 tahun) selama 3 bulan terakhir)</label>
                                    <select class="form-select" name="gizi_strong_penurunan_bb">
                                        <option value="">pilih</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_strong_penurunan_bb == '1' ? 'selected' : '' }}>Ya</option>
                                        <option value="0" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_strong_penurunan_bb == '0' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Apakah salah satu dari hal berikut ini ada? <br>
                                        - Diare berlabihan (>= 5 kali perhari) dan/atau muntah(>3 klai perhari) selama 1-3 hari terakhir
                                        - Penurunan asupan makanan selama 1-3 hari terakhir
                                        - Intervensi gizi yang sudah ada sebelumnya (misalnya, ONS atau pemberian maka selang)</label>
                                    <select class="form-select" name="gizi_strong_gangguan_pencernaan">
                                        <option value="">pilih</option>
                                        <option value="1" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_strong_gangguan_pencernaan == '1' ? 'selected' : '' }}>Ya</option>
                                        <option value="0" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_strong_gangguan_pencernaan == '0' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Apakah terdapat penyakit atau keadaan yang mengakibatkan pasien berisiko mengalaman mainutrisi? <br>
                                        <a href="#"><i>Lihat penyakit yang berisiko malnutrisi</i></a></label>
                                    <select class="form-select" name="gizi_strong_penyakit_berisiko">
                                        <option value="">pilih</option>
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_strong_penyakit_berisiko == '2' ? 'selected' : '' }}>Ya</option>
                                        <option value="0" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_strong_penyakit_berisiko == '0' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>
                                <!-- Nilai -->
                                <div id="strongKidsConclusion" class="risk-indicators mt-4">
                                    <div class="alert alert-success" style="{{ strpos(optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_strong_kesimpulan ?? '', 'rendah') !== false ? '' : 'display: none;' }}">Kesimpulan: 0 (Beresiko rendah)</div>
                                    <div class="alert alert-warning" style="{{ strpos(optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_strong_kesimpulan ?? '', 'sedang') !== false ? '' : 'display: none;' }}">Kesimpulan: 1-3 (Beresiko sedang)</div>
                                    <div class="alert alert-danger" style="{{ strpos(optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_strong_kesimpulan ?? '', 'Tinggi') !== false ? '' : 'display: none;' }}">Kesimpulan: 4-5 (Beresiko Tinggi)</div>
                                    <input type="hidden" name="gizi_strong_kesimpulan" id="gizi_strong_kesimpulan" value="{{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_strong_kesimpulan }}">
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
                                        <option value="2" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_nrs_jatuh_saat_masuk_rs == '2' ? 'selected' : '' }}>Ya</option>
                                        <option value="0" {{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_nrs_jatuh_saat_masuk_rs == '0' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>

                                <!-- Add more NRS form fields here -->

                                <!-- Nilai -->
                                <div id="nrsConclusion" class="risk-indicators mt-4">
                                    <div class="alert alert-success" style="{{ strpos(optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_nrs_kesimpulan ?? '', 'rendah') !== false ? '' : 'display: none;' }}">Kesimpulan: Beresiko rendah</div>
                                    <div class="alert alert-warning" style="{{ strpos(optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_nrs_kesimpulan ?? '', 'sedang') !== false ? '' : 'display: none;' }}">Kesimpulan: Beresiko sedang</div>
                                    <div class="alert alert-danger" style="{{ strpos(optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_nrs_kesimpulan ?? '', 'Tinggi') !== false ? '' : 'display: none;' }}">Kesimpulan: Beresiko Tinggi</div>
                                    <input type="hidden" name="gizi_nrs_kesimpulan" id="gizi_nrs_kesimpulan" value="{{ optional($asesmen->rmeAsesmenPerinatologyGizi)->gizi_nrs_kesimpulan }}">
                                </div>
                            </div>
                        </div>

                        <!-- 11. Status Fungsional -->
                        <div class="section-separator" id="status-fungsional">
                                <h5 class="section-title">11. Status Fungsional</h5>

                                <div class="mb-4">
                                    <label class="form-label">Pilih jenis Skala Pengkajian Aktivitas Harian (ADL) sesuai kondisi pasien</label>
                                    <select class="form-select" name="skala_fungsional" id="skala_fungsional">
                                        <option value="" selected disabled>Pilih Skala Fungsional</option>
                                        <option value="1" {{ isset($asesmen->rmeAsesmenPerinatologyStatusFungsional) && $asesmen->rmeAsesmenPerinatologyStatusFungsional->jenis_skala == 1 ? 'selected' : '' }}>Pengkajian Aktivitas Harian</option>
                                        <option value="2" {{ isset($asesmen->rmeAsesmenPerinatologyStatusFungsional) && $asesmen->rmeAsesmenPerinatologyStatusFungsional->jenis_skala == 2 ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Nilai Skala ADL</label>
                                    <input type="text" class="form-control" id="adl_total" name="adl_total" readonly value="{{ isset($asesmen->rmeAsesmenPerinatologyStatusFungsional) ? $asesmen->rmeAsesmenPerinatologyStatusFungsional->nilai_skala_adl : '' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Kesimpulan Fungsional</label>
                                    <div id="adl_kesimpulan" class="alert {{ isset($asesmen->rmeAsesmenPerinatologyStatusFungsional) && $asesmen->rmeAsesmenPerinatologyStatusFungsional->kesimpulan_fungsional ?
                                        (strpos($asesmen->rmeAsesmenPerinatologyStatusFungsional->kesimpulan_fungsional, 'Ketergantungan Total') !== false ? 'alert-danger' :
                                        (strpos($asesmen->rmeAsesmenPerinatologyStatusFungsional->kesimpulan_fungsional, 'Ketergantungan Berat') !== false ? 'alert-warning' :
                                        (strpos($asesmen->rmeAsesmenPerinatologyStatusFungsional->kesimpulan_fungsional, 'Ketergantungan Sedang') !== false ? 'alert-info' : 'alert-success')))
                                        : 'alert-info' }}">
                                        {{ isset($asesmen->rmeAsesmenPerinatologyStatusFungsional) && $asesmen->rmeAsesmenPerinatologyStatusFungsional->kesimpulan_fungsional ? $asesmen->rmeAsesmenPerinatologyStatusFungsional->kesimpulan_fungsional : 'Pilih skala aktivitas harian terlebih dahulu' }}
                                    </div>
                                </div>
                                
                                <!-- Hidden fields untuk menyimpan data ADL -->
                                <input type="hidden" id="adl_makan" name="adl_makan" value="{{ isset($asesmen->rmeAsesmenPerinatologyStatusFungsional) ? $asesmen->rmeAsesmenPerinatologyStatusFungsional->makan : '' }}">
                                <input type="hidden" id="adl_berjalan" name="adl_berjalan" value="{{ isset($asesmen->rmeAsesmenPerinatologyStatusFungsional) ? $asesmen->rmeAsesmenPerinatologyStatusFungsional->berjalan : '' }}">
                                <input type="hidden" id="adl_mandi" name="adl_mandi" value="{{ isset($asesmen->rmeAsesmenPerinatologyStatusFungsional) ? $asesmen->rmeAsesmenPerinatologyStatusFungsional->mandi : '' }}">
                                <input type="hidden" id="adl_kesimpulan_value" name="adl_kesimpulan_value" value="{{ isset($asesmen->rmeAsesmenPerinatologyStatusFungsional) ? $asesmen->rmeAsesmenPerinatologyStatusFungsional->kesimpulan_fungsional : '' }}">
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

                        <!-- MASALAH/ DIAGNOSIS KEPERAWATAN  -->
                        <div class="section-separator" id="masalah_diagnosis">
                            <h5 class="section-title">16. MASALAH/ DIAGNOSIS KEPERAWATAN</h5>
                            <p class="text-muted mb-4">(Diisi berdasarkan hasil asesmen dan berurut sesuai masalah yang dominan terlebih dahulu)</p>

                            <!-- Diagnosis Keperawatan Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th width="50%">DIAGNOSA KEPERAWATAN</th>
                                            <th width="50%">RENCANA KEPERAWATAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- 1. Bersihan Jalan Nafas Tidak Efektif -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input rencana-perawatan-row-1"
                                                        type="checkbox"
                                                        name="diagnosis[]"
                                                        value="bersihan_jalan_nafas"
                                                        id="diag_bersihan_jalan_nafas"
                                                        onchange="toggleRencana('bersihan_jalan_nafas')"
                                                        {{ in_array('bersihan_jalan_nafas', old('diagnosis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_bersihan_jalan_nafas">
                                                        <strong>Bersihan jalan nafas tidak efektif</strong> berhubungan dengan spasme jalan nafas...
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input rencana-perawatan-row-1"
                                                        type="checkbox"
                                                        name="diagnosis[]"
                                                        value="risiko_aspirasi"
                                                        id="diag_risiko_aspirasi"
                                                        onchange="toggleRencana('risiko_aspirasi')"
                                                        {{ in_array('risiko_aspirasi', old('diagnosis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_risiko_aspirasi">
                                                        <strong>Risiko aspirasi</strong> berhubungan dengan tingkat kesadaran...
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input rencana-perawatan-row-1"
                                                        type="checkbox"
                                                        name="diagnosis[]"
                                                        value="pola_nafas_tidak_efektif"
                                                        id="diag_pola_nafas_tidak_efektif"
                                                        onchange="toggleRencana('pola_nafas_tidak_efektif')"
                                                        {{ in_array('pola_nafas_tidak_efektif', old('diagnosis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_pola_nafas_tidak_efektif">
                                                        <strong>Pola nafas tidak efektif</strong> berhubungan dengan depresi pusat pernafasan...
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_bersihan_jalan_nafas" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_pola_nafas"
                                                        {{ in_array('monitor_pola_nafas', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor pola nafas ( frekuensi , kedalaman, usaha nafas )</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_bunyi_nafas"
                                                        {{ in_array('monitor_bunyi_nafas', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor bunyi nafas tambahan ( mengi, wheezing, rhonchi )</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_sputum"
                                                        {{ in_array('monitor_sputum', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor sputum ( jumlah, warna, aroma )</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_tingkat_kesadaran"
                                                        {{ in_array('monitor_tingkat_kesadaran', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tingkat kesadaran, batuk, muntah dan kemampuan menelan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_kemampuan_batuk"
                                                        {{ in_array('monitor_kemampuan_batuk', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor kemampuan batuk efektif</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="pertahankan_kepatenan"
                                                        {{ in_array('pertahankan_kepatenan', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertahankan kepatenan jalan nafas dengan head-tilt dan chin -lift ( jaw – thrust jika curiga trauma servikal ) </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="posisikan_semi_fowler"
                                                        {{ in_array('posisikan_semi_fowler', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Posisikan semi fowler atau fowler</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="berikan_minum_hangat"
                                                        {{ in_array('berikan_minum_hangat', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan minum hangat</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="fisioterapi_dada"
                                                        {{ in_array('fisioterapi_dada', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan fisioterapi dada, jika perlu</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="keluarkan_benda_padat"
                                                        {{ in_array('keluarkan_benda_padat', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Keluarkan benda padat dengan forcep</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="penghisapan_lendir"
                                                        {{ in_array('penghisapan_lendir', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan penghisapan lendir</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="berikan_oksigen"
                                                        {{ in_array('berikan_oksigen', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan oksigen</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="anjuran_asupan_cairan"
                                                        {{ in_array('anjuran_asupan_cairan', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjuran asupan cairan 2000 ml/hari, jika tidak kontra indikasi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="ajarkan_teknik_batuk"
                                                        {{ in_array('ajarkan_teknik_batuk', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan teknik batuk efektif</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="kolaborasi_pemberian_obat"
                                                        {{ in_array('kolaborasi_pemberian_obat', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian bronkodilator, ekspektoran, mukolitik, jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 2. Penurunan Curah Jantung -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="diagnosis[]" value="penurunan_curah_jantung" id="diag_penurunan_curah_jantung" onchange="toggleRencana('penurunan_curah_jantung')"
                                                    {{ in_array('penurunan_curah_jantung', old('diagnosis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}
                                                    onchange="toggleRencana('diag_penurunan_curah_jantung')">
                                                    <label class="form-check-label" for="diag_penurunan_curah_jantung">
                                                        <strong>Penurunan curah jantung</strong> berhubungan dengan perubahan irama jantung, perubahan frekuensi jantung.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_penurunan_curah_jantung" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="identifikasi_tanda_gejala"
                                                        {{ in_array('identifikasi_tanda_gejala', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi tanda/gejala primer penurunan curah jantung (meliputi dipsnea, kelelahan, edema)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_tekanan_darah"
                                                        {{ in_array('monitor_tekanan_darah', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tekanan darah</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_intake_output"
                                                        {{ in_array('monitor_intake_output', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor intake dan output cairan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_saturasi_oksigen"
                                                        {{ in_array('monitor_saturasi_oksigen', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor saturasi oksigen</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_keluhan_nyeri"
                                                        {{ in_array('monitor_keluhan_nyeri', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor keluhan nyeri dada (intensitas, lokasi, durasi, presivitasi yang mengurangi nyeri)</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_aritmia"
                                                        {{ in_array('monitor_aritmia', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor aritmia (kelainan irama dan frekuensi)</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="posisikan_pasien"
                                                        {{ in_array('posisikan_pasien', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Posisikan pasien semi fowler atau fowler dengan kaki kebawah atau posisi nyaman</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="berikan_terapi_relaksasi"
                                                        {{ in_array('berikan_terapi_relaksasi', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan therapi relaksasi untuk mengurangi stres, jika perlu</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="berikan_dukungan_emosional"
                                                        {{ in_array('berikan_dukungan_emosional', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan dukungan emosional dan spirital</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="berikan_oksigen_saturasi"
                                                        {{ in_array('berikan_oksigen_saturasi', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan oksigen untuk mempertahankan saturasi oksigen >94%</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="anjurkan_beraktifitas"
                                                        {{ in_array('anjurkan_beraktifitas', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan beraktifitas fisik sesuai toleransi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="anjurkan_berhenti_merokok"
                                                        {{ in_array('anjurkan_berhenti_merokok', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan berhenti merokok</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="ajarkan_mengukur_intake"
                                                        {{ in_array('ajarkan_mengukur_intake', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan pasien dan keluarga mengukur intake dan output cairan harian</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="kolaborasi_pemberian_terapi"
                                                        {{ in_array('kolaborasi_pemberian_terapi', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Koborasi pemberian therapi</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 3. Perfusi Perifer Tidak Efektif -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="diagnosis[]" value="perfusi_perifer" id="diag_perfusi_perifer" onchange="toggleRencana('perfusi_perifer')"
                                                    {{ in_array('perfusi_perifer', old('diagnosis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_perfusi_perifer">
                                                        <strong>Perfusi perifer tidak efektif</strong> berhubungan dengan hyperglikemia, penurunan konsentrasi hemoglobin, peningkatan tekanan darah, kekurangan volume cairan, penurunan aliran arteri dan/atau vena, kurang terpapar informasi tentang proses penyakit (misal: diabetes melitus, hiperlipidmia).
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_perfusi_perifer" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="periksa_sirkulasi"
                                                        {{ in_array('periksa_sirkulasi', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa sirkulasi perifer (edema, pengisian kapiler/CRT, suhu)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="identifikasi_faktor_risiko"
                                                        {{ in_array('identifikasi_faktor_risiko', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor risiko gangguan sirkulasi (diabetes, perokok, hipertensi, kadar kolesterol tinggi)</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="monitor_suhu_kemerahan"
                                                        {{ in_array('monitor_suhu_kemerahan', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor suhu, kemerahan, nyeri atau bengkak pada ekstremitas.</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="hindari_pemasangan_infus"
                                                        {{ in_array('hindari_pemasangan_infus', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hindari pemasangan infus atau pengambilan darah di area keterbatasan perfusi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="hindari_pengukuran_tekanan"
                                                        {{ in_array('hindari_pengukuran_tekanan', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hindari pengukuran tekanan darah pada ekstremitas dengan keterbatasan perfusi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="hindari_penekanan"
                                                        {{ in_array('hindari_penekanan', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hindari penekanan dan pemasangan tourniqet pada area yang cedera</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="lakukan_pencegahan_infeksi"
                                                        {{ in_array('lakukan_pencegahan_infeksi', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan pencegahan infeksi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="perawatan_kaki_kuku"
                                                        {{ in_array('perawatan_kaki_kuku', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan perawatan kaki dan kuku</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="anjurkan_berhenti_merokok_perfusi"
                                                        {{ in_array('anjurkan_berhenti_merokok_perfusi', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan berhenti merokok</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="anjurkan_berolahraga"
                                                        {{ in_array('anjurkan_berolahraga', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan berolahraga rutin</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="anjurkan_minum_obat"
                                                        {{ in_array('anjurkan_minum_obat', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan minum obat pengontrol tekanan darah secara teratur</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="kolaborasi_terapi_perfusi"
                                                        {{ in_array('kolaborasi_terapi_perfusi', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Koborasi pemberian therapi</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 4. Hipovolemia -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="diagnosis[]" value="hipovolemia" id="diag_hipovolemia" onchange="toggleRencana('hipovolemia')"
                                                    {{ in_array('hipovolemia', old('diagnosis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_hipovolemia">
                                                        <strong>Hipovolemia</strong> berhubungan dengan kehilangan cairan aktif, peningkatan permeabilitas kapiler, kekurangan intake cairan, evaporasi.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_hipovolemia" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="periksa_tanda_gejala"
                                                        {{ in_array('periksa_tanda_gejala', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa tanda dan gejala hipovolemia (frekuensi nadi meningkat, nadi teraba lemah, tekanan darah penurun, turgor kulit menurun, membran mukosa kering, volume urine menurun, haus, lemah)</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="monitor_intake_output_hipovolemia"
                                                        {{ in_array('monitor_intake_output_hipovolemia', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor intake dan output cairan</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="berikan_asupan_cairan"
                                                        {{ in_array('berikan_asupan_cairan', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan asupan cairan oral</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="posisi_trendelenburg"
                                                        {{ in_array('posisi_trendelenburg', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Posisi modified trendelenburg</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="anjurkan_memperbanyak_cairan"
                                                        {{ in_array('anjurkan_memperbanyak_cairan', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan memperbanyak asupan cairan oral</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="hindari_perubahan_posisi"
                                                        {{ in_array('hindari_perubahan_posisi', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menghindari perubahan posisi mendadak</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="kolaborasi_terapi_hipovolemia"
                                                        {{ in_array('kolaborasi_terapi_hipovolemia', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Koborasi pemberian therapi</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 5. Hipervolemia -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="diagnosis[]" value="hipervolemia" id="diag_hipervolemia" onchange="toggleRencana('hipervolemia')"
                                                    {{ in_array('hipervolemia', old('diagnosis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_hipervolemia">
                                                        <strong>Hipervolemia</strong> berhubungan dengan kelebihan asupan cairan, kelebihan asupan natrium, gangguan aliran balik vena.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_hipervolemia" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="periksa_tanda_hipervolemia"
                                                        {{ in_array('periksa_tanda_hipervolemia', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa tanda dan gejala hipervolemia (dipsnea, edema, suara nafas tambahan)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="identifikasi_penyebab_hipervolemia"
                                                        {{ in_array('identifikasi_penyebab_hipervolemia', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi penyebab hipervolemia</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="monitor_hemodinamik"
                                                        {{ in_array('monitor_hemodinamik', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor status hemodinamik (frekuensi jantung, tekanan darah)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="monitor_intake_output_hipervolemia"
                                                        {{ in_array('monitor_intake_output_hipervolemia', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor intake dan output cairan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="monitor_efek_diuretik"
                                                        {{ in_array('monitor_efek_diuretik', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor efek samping diuretik (hipotensi ortostatik, hipovolemia, hipokalemia, hiponatremia)</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="timbang_berat_badan"
                                                        {{ in_array('timbang_berat_badan', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Timbang berat badan setiap hari pada waktu yang sama</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="batasi_asupan_cairan"
                                                        {{ in_array('batasi_asupan_cairan', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Batasi asupan cairan dan garam</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="tinggi_kepala_tempat_tidur"
                                                        {{ in_array('tinggi_kepala_tempat_tidur', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tinggi kepala tempat tidur 30 – 40 º</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="ajarkan_mengukur_cairan"
                                                        {{ in_array('ajarkan_mengukur_cairan', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara mengukur dan mencatat asupan dan haluaran cairan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="ajarkan_membatasi_cairan"
                                                        {{ in_array('ajarkan_membatasi_cairan', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara membatasi cairan</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="kolaborasi_terapi_hipervolemia"
                                                        {{ in_array('kolaborasi_terapi_hipervolemia', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Koborasi pemberian therapi</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 6. Diare -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="diagnosis[]" value="diare" id="diag_diare" onchange="toggleRencana('diare')"
                                                    {{ in_array('diare', old('diagnosis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_diare">
                                                        <strong>Diare</strong> berhubungan dengan inflamasi gastrointestinal, iritasi gastrointestinal, proses infeksi, malabsorpsi.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_diare" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="identifikasi_penyebab_diare"
                                                        {{ in_array('identifikasi_penyebab_diare', old('rencana_diare', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi penyebab diare (inflamasi gastrointestinal, iritasi gastrointestinal, proses infeksi, malabsorpsi, ansietas, stres, efek samping obat)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="identifikasi_riwayat_makanan"
                                                        {{ in_array('identifikasi_riwayat_makanan', old('rencana_diare', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi riwayat pemberian makanan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="identifikasi_gejala_invaginasi"
                                                        {{ in_array('identifikasi_gejala_invaginasi', old('rencana_diare', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi riwayat gejala invaginasi (tangisan keras, kepucatan pada bayi)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="monitor_warna_volume_tinja"
                                                        {{ in_array('monitor_warna_volume_tinja', old('rencana_diare', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor warna, volume, frekuensi dan konsistensi tinja</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="monitor_tanda_hipovolemia"
                                                        {{ in_array('monitor_tanda_hipovolemia', old('rencana_diare', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tanda dan gejala hipovolemia (takikardi, nadi teraba lemah, tekanan darah turun, turgor kulit turun, mukosa mulit kering, CRT melambat, BB menurun)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="monitor_iritasi_kulit"
                                                        {{ in_array('monitor_iritasi_kulit', old('rencana_diare', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor iritasi dan ulserasi kulit di daerah perianal</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="monitor_jumlah_diare"
                                                        {{ in_array('monitor_jumlah_diare', old('rencana_diare', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor jumlah pengeluaran diare</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="berikan_asupan_cairan_oral"
                                                        {{ in_array('berikan_asupan_cairan_oral', old('rencana_diare', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan asupan cairan oral (larutan garam gula, oralit, pedialyte)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="pasang_jalur_intravena"
                                                        {{ in_array('pasang_jalur_intravena', old('rencana_diare', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pasang jalur intravena</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="berikan_cairan_intravena"
                                                        {{ in_array('berikan_cairan_intravena', old('rencana_diare', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan cairan intravena</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="anjurkan_makanan_porsi_kecil"
                                                        {{ in_array('anjurkan_makanan_porsi_kecil', old('rencana_diare', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan makanan porsi kecil dan sering secara bertahap</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="hindari_makanan_gas"
                                                        {{ in_array('hindari_makanan_gas', old('rencana_diare', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menghindari makanan pembentuk gas, pedas dan mengandung laktosa</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="lanjutkan_asi"
                                                        {{ in_array('lanjutkan_asi', old('rencana_diare', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan melanjutkan pemberian ASI</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="kolaborasi_terapi_diare"
                                                        {{ in_array('kolaborasi_terapi_diare', old('rencana_diare', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Koborasi pemberian therapi</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 7. Retensi Urine -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="diagnosis[]" value="retensi_urine" id="diag_retensi_urine" onchange="toggleRencana('retensi_urine')"
                                                    {{ in_array('retensi_urine', old('diagnosis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_retensi_urine">
                                                        <strong>Retensi urine</strong> berhubungan dengan peningkatan tekanan uretra, kerusakan arkus refleks, Blok spingter, disfungsi neurologis (trauma, penyakit saraf), efek agen farmakologis (atropine, belladona, psikotropik, antihistamin, opiate).
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_retensi_urine" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="identifikasi_tanda_retensi"
                                                        {{ in_array('identifikasi_tanda_retensi', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi tanda dan gejala retensi atau inkontinensia urine</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="identifikasi_faktor_penyebab"
                                                        {{ in_array('identifikasi_faktor_penyebab', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor yang menyebabkan retensi atau inkontinensia urine</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="monitor_eliminasi_urine"
                                                        {{ in_array('monitor_eliminasi_urine', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor eliminasi urine (frekuensi, konsistensi, aroma, volume dan warna)</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="catat_waktu_berkemih"
                                                        {{ in_array('catat_waktu_berkemih', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Catat waktu-waktu dan haluaran berkemih</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="batasi_asupan_cairan"
                                                        {{ in_array('batasi_asupan_cairan', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Batasi asupan cairan, jika perlu</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ambil_sampel_urine"
                                                        {{ in_array('ambil_sampel_urine', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ambil sampel urine tengah (midstream) atau kultur</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_tanda_infeksi"
                                                        {{ in_array('ajarkan_tanda_infeksi', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan tanda dan gejala infeksi saluran kemih</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_mengukur_asupan"
                                                        {{ in_array('ajarkan_mengukur_asupan', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan mengukur asupan cairan dan haluaran urine</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_spesimen_midstream"
                                                        {{ in_array('ajarkan_spesimen_midstream', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan mengambil spesimen urine midstream</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_tanda_berkemih"
                                                        {{ in_array('ajarkan_tanda_berkemih', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan mengenali tanda berkemih dan waktu yang tepat untuk berkemih</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_minum_cukup"
                                                        {{ in_array('ajarkan_minum_cukup', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan minum yang cukup, jika tidak ada kontraindikasi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="kurangi_minum_tidur"
                                                        {{ in_array('kurangi_minum_tidur', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan mengurangi minum menjelang tidur</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="kolaborasi_supositoria"
                                                        {{ in_array('kolaborasi_supositoria', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian obat supositoria uretra, jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 8. Nyeri Akut -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="diagnosis[]" value="nyeri_akut" id="diag_nyeri_akut" onchange="toggleRencana('nyeri_akut')"
                                                    {{ in_array('nyeri_akut', old('diagnosis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_nyeri_akut">
                                                        <strong>Nyeri akut</strong> b.d agen pencedera fisiologis (inflamsi, iskemia, neoplasma), agen pencedera kimiawi (terbakar, bahan kimia iritan), agen pencedera fisik (abses, amputasi, terbakar, terpotong, mengangkat berat, prosedur operasi, trauma, latihan fisik berlebihan).
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_nyeri_akut" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_lokasi_nyeri"
                                                        {{ in_array('identifikasi_lokasi_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi lokasi, karakteristik, durasi, frekuensi, kualitas, intensitas nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_skala_nyeri"
                                                        {{ in_array('identifikasi_skala_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi skala nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_respons_nonverbal"
                                                        {{ in_array('identifikasi_respons_nonverbal', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi respons nyeri non verbal</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_faktor_nyeri"
                                                        {{ in_array('identifikasi_faktor_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor yang memperberat dan memperingan nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_pengetahuan_nyeri"
                                                        {{ in_array('identifikasi_pengetahuan_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengetahuan dan keyaninan tentang nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_pengaruh_budaya"
                                                        {{ in_array('identifikasi_pengaruh_budaya', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengaruh budaya terhadap respon nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_pengaruh_kualitas_hidup"
                                                        {{ in_array('identifikasi_pengaruh_kualitas_hidup', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengaruh nyeri pada kualitas hidup</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="monitor_keberhasilan_terapi"
                                                        {{ in_array('monitor_keberhasilan_terapi', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor keberhasilan terapi komplementer yang sudah diberikan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="monitor_efek_samping_analgetik"
                                                        {{ in_array('monitor_efek_samping_analgetik', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor efek samping penggunaan analgetil</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="berikan_teknik_nonfarmakologis"
                                                        {{ in_array('berikan_teknik_nonfarmakologis', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan teknik nonfarmakologis untuk mengurangi rasa nyeri (TENS, hipnosis, akupresur, terapi musik, biofeedback, terapi pijat, aromaterapi, teknik imajinasi terbimbing, kompres hangat/dingin, terapi bermain)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="kontrol_lingkungan_nyeri"
                                                        {{ in_array('kontrol_lingkungan_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kontrol lingkungan yang memperberat rasa nyeri (suhu ruangan, pencahayaan, kebisingan)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="fasilitasi_istirahat"
                                                        {{ in_array('fasilitasi_istirahat', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Fasilitasi istirahat dan tidur</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="pertimbangkan_strategi_nyeri"
                                                        {{ in_array('pertimbangkan_strategi_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertimbangkan jenis dan sumber nyeri dalam pemilihan strategi meredakan nyeri</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="jelaskan_penyebab_nyeri"
                                                        {{ in_array('jelaskan_penyebab_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan penyebab, periode, dan pemicu nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="jelaskan_strategi_nyeri"
                                                        {{ in_array('jelaskan_strategi_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan strategi meredakan nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="anjurkan_monitor_nyeri"
                                                        {{ in_array('anjurkan_monitor_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan memonitor nyeri secara mandiri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="anjurkan_analgetik"
                                                        {{ in_array('anjurkan_analgetik', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menggunakan analgetik secara tepat</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="ajarkan_teknik_nonfarmakologis"
                                                        {{ in_array('ajarkan_teknik_nonfarmakologis', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan teknik nonfarmakologis untuk mengurangin rasa nyeri</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="kolaborasi_analgetik"
                                                        {{ in_array('kolaborasi_analgetik', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian analgetik, jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 9. Nyeri Kronis -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="diagnosis[]" value="nyeri_kronis" id="diag_nyeri_kronis" onchange="toggleRencana('nyeri_kronis')"
                                                    {{ in_array('nyeri_kronis', old('diagnosis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_nyeri_kronis">
                                                        <strong>Nyeri kronis</strong> b.d kondisi muskuloskeletal kronis, kerusakan sistem saraf, penekanan saraf, infiltrasi tumor, ketidakseimbangan neurotransmiter, neuromodulator, dan reseptor, gangguan imunitas, (neuropati terkait HIV, virus varicella-zoster), gangguan fungsi metabolik, riwayat posisi kerja statis, peningkatan indeks masa tubuh, kondisi pasca trauma, tekanan emosional, riwayat penganiayaan (fisik, psikologis, seksual), riwayat penyalahgunaan obat/zat.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_nyeri_kronis" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_lokasi_nyeri_kronis"
                                                        {{ in_array('identifikasi_lokasi_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi lokasi, karakteristik, durasi, frekuensi, kualitas, intensitas nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_skala_nyeri_kronis"
                                                        {{ in_array('identifikasi_skala_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi skala nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_respons_nonverbal_kronis"
                                                        {{ in_array('identifikasi_respons_nonverbal_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi respons nyeri non verbal</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_faktor_nyeri_kronis"
                                                        {{ in_array('identifikasi_faktor_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor yang memperberat dan memperingan nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_pengetahuan_nyeri_kronis"
                                                        {{ in_array('identifikasi_pengetahuan_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengetahuan dan keyaninan tentang nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_pengaruh_budaya_kronis"
                                                        {{ in_array('identifikasi_pengaruh_budaya_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengaruh budaya terhadap respon nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_pengaruh_kualitas_hidup_kronis"
                                                        {{ in_array('identifikasi_pengaruh_kualitas_hidup_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengaruh nyeri pada kualitas hidup</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="monitor_keberhasilan_terapi_kronis"
                                                        {{ in_array('monitor_keberhasilan_terapi_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor keberhasilan terapi komplementer yang sudah diberikan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="monitor_efek_samping_analgetik_kronis"
                                                        {{ in_array('monitor_efek_samping_analgetik_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor efek samping penggunaan analgetil</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="berikan_teknik_nonfarmakologis_kronis"
                                                        {{ in_array('berikan_teknik_nonfarmakologis_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan teknik nonfarmakologis untuk mengurangi rasa nyeri (TENS, hipnosis, akupresur, terapi musik, biofeedback, terapi pijat, aromaterapi, teknik imajinasi terbimbing, kompres hangat/dingin, terapi bermain)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="kontrol_lingkungan_nyeri_kronis"
                                                        {{ in_array('kontrol_lingkungan_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kontrol lingkungan yang memperberat rasa nyeri (suhu ruangan, pencahayaan, kebisingan)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="fasilitasi_istirahat_kronis"
                                                        {{ in_array('fasilitasi_istirahat_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Fasilitasi istirahat dan tidur</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="pertimbangkan_strategi_nyeri_kronis"
                                                        {{ in_array('pertimbangkan_strategi_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertimbangkan jenis dan sumber nyeri dalam pemilihan strategi meredakan nyeri</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="jelaskan_penyebab_nyeri_kronis"
                                                        {{ in_array('jelaskan_penyebab_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan penyebab, periode, dan pemicu nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="jelaskan_strategi_nyeri_kronis"
                                                        {{ in_array('jelaskan_strategi_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan strategi meredakan nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="anjurkan_monitor_nyeri_kronis"
                                                        {{ in_array('anjurkan_monitor_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan memonitor nyeri secara mandiri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="anjurkan_analgetik_kronis"
                                                        {{ in_array('anjurkan_analgetik_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menggunakan analgetik secara tepat</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="ajarkan_teknik_nonfarmakologis_kronis"
                                                        {{ in_array('ajarkan_teknik_nonfarmakologis_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan teknik nonfarmakologis untuk mengurangin rasa nyeri</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="kolaborasi_analgetik_kronis"
                                                        {{ in_array('kolaborasi_analgetik_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian analgetik, jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 10. Hipertermia -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="diagnosis[]" value="hipertermia" id="diag_hipertermia" onchange="toggleRencana('hipertermia')"
                                                    {{ in_array('hipertermia', old('diagnosis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_hipertermia">
                                                        <strong>Hipertermia</strong> b.d dehidrasi, terpapar lingkungan panas, peroses penyakit (infeksi, kanker), ketidaksesuaian pakaian dengan suhu lingkungan, peningkatan laju metabolisme, respon trauma, aktivitas berlebihan, penggunaan inkubator.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_hipertermia" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="identifikasi_penyebab_hipertermia"
                                                        {{ in_array('identifikasi_penyebab_hipertermia', old('rencana_hipertermia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi penyebab hipertermia (dehidrasi, terpapar lingkungan panas, penggunaan inkubator)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="monitor_suhu_tubuh"
                                                        {{ in_array('monitor_suhu_tubuh', old('rencana_hipertermia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor suhu tubuh</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="monitor_kadar_elektrolit"
                                                        {{ in_array('monitor_kadar_elektrolit', old('rencana_hipertermia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor kadar elektrolit</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="monitor_haluaran_urine"
                                                        {{ in_array('monitor_haluaran_urine', old('rencana_hipertermia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor haluaran urine</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="monitor_komplikasi_hipertermia"
                                                        {{ in_array('monitor_komplikasi_hipertermia', old('rencana_hipertermia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor komplikasi akibat hipertermia</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="sediakan_lingkungan_dingin"
                                                        {{ in_array('sediakan_lingkungan_dingin', old('rencana_hipertermia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Sediakan lingkungan yang dingin</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="longgarkan_pakaian"
                                                        {{ in_array('longgarkan_pakaian', old('rencana_hipertermia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Longgarkan atau lepaskan pakaian</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="basahi_kipasi_tubuh"
                                                        {{ in_array('basahi_kipasi_tubuh', old('rencana_hipertermia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Basahi dan kipasi permukaan tubuh</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="berikan_cairan_oral_hipertermia"
                                                        {{ in_array('berikan_cairan_oral_hipertermia', old('rencana_hipertermia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan cairan oral</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="ganti_linen_hiperhidrosis"
                                                        {{ in_array('ganti_linen_hiperhidrosis', old('rencana_hipertermia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ganti linen setiap hari atau lebih sering jika mengalami hiperhidrosis (keringat berlebih)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="pendinginan_eksternal"
                                                        {{ in_array('pendinginan_eksternal', old('rencana_hipertermia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan pendinginan eksternal (selimut hipotermia atau kompres dingin pada dahi, leher, dada, abdomen, aksila)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="hindari_antipiretik"
                                                        {{ in_array('hindari_antipiretik', old('rencana_hipertermia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hindari pemberian antipiretik atau aspirin</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="berikan_oksigen_hipertermia"
                                                        {{ in_array('berikan_oksigen_hipertermia', old('rencana_hipertermia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan oksigen, jika perlu</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="anjurkan_tirah_baring"
                                                        {{ in_array('anjurkan_tirah_baring', old('rencana_hipertermia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan tirah baring</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="kolaborasi_cairan_elektrolit"
                                                        {{ in_array('kolaborasi_cairan_elektrolit', old('rencana_hipertermia', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian cairan dan elektrolit intravena, jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 11. Gangguan Mobilitas Fisik -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="diagnosis[]" value="gangguan_mobilitas_fisik" id="diag_gangguan_mobilitas_fisik" onchange="toggleRencana('gangguan_mobilitas_fisik')"
                                                    {{ in_array('gangguan_mobilitas_fisik', old('diagnosis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_gangguan_mobilitas_fisik">
                                                        <strong>Gangguan mobilitas fisik</strong> b.d kerusakan intergritas struktur tulang, perubahan metabolisme, ketidakbugaran fisik, penurunan kendali otot, penurunan massa otot, penurunan kekuatan otot, keterlambatan perkembangan, kekakuan sendi, kontraktur, malnutrisi, gangguan muskuloskeletal, gangguan neuromuskular, indeks masa tubuh diatas persentil ke-75 seusai usia, efek agen farmakologis, program pembatasan gerak, nyeri, kurang terpapar informasi tentang aktivitas fisik, kecemasan, gangguan kognitif, keengganan melakukan pergerakan, gangguan sensoripersepsi.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_gangguan_mobilitas_fisik" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="identifikasi_nyeri_keluhan"
                                                        {{ in_array('identifikasi_nyeri_keluhan', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Indentifikasi adanya nyeri atau keluhan fisik lainnya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="identifikasi_toleransi_ambulasi"
                                                        {{ in_array('identifikasi_toleransi_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Indetifikasi toleransi fisik melakukan ambulasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="monitor_frekuensi_jantung_ambulasi"
                                                        {{ in_array('monitor_frekuensi_jantung_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor frekuensi jantung dan tekanan darah sebelum memulai ambulasi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="monitor_kondisi_umum_ambulasi"
                                                        {{ in_array('monitor_kondisi_umum_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor kondiri umum selama melakukan ambulasi</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="fasilitasi_aktivitas_ambulasi"
                                                        {{ in_array('fasilitasi_aktivitas_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Fasilitasi aktivitas ambulasi dengan alat bantu (tongkat, kruk)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="fasilitasi_mobilisasi_fisik"
                                                        {{ in_array('fasilitasi_mobilisasi_fisik', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Fasilitasi melakukan mobilisasi fisik, jika perlu</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="libatkan_keluarga_ambulasi"
                                                        {{ in_array('libatkan_keluarga_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Libatkan keluarga untuk membantu pasien dalam meningkatkan ambulasi</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="jelaskan_tujuan_ambulasi"
                                                        {{ in_array('jelaskan_tujuan_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan tujuan dan prosedur ambulasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="anjurkan_ambulasi_dini"
                                                        {{ in_array('anjurkan_ambulasi_dini', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan melakukan ambulasi dini</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="ajarkan_ambulasi_sederhana"
                                                        {{ in_array('ajarkan_ambulasi_sederhana', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan ambulasi sederhana yang harus dilakukan (berjalan dari tempat tidur ke kursi roda, berjalan dari tempat tidur ke kamar mandi, berjalan sesuai toleransi)</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 12. Resiko Infeksi -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="diagnosis[]" value="resiko_infeksi" id="diag_resiko_infeksi" onchange="toggleRencana('resiko_infeksi')"
                                                    {{ in_array('resiko_infeksi', old('diagnosis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_resiko_infeksi">
                                                        <strong>Resiko infeksi</strong> b.d efek prosedur invasif, penyakit kronis (diabetes melitus), malnutrisi, peningkatan paparan organisme patogen lingkungan, ketidakadekuatan pertahanan tubuh primer (gangguan persitaltik, kerusakan integritas kulit, perubahan sekresi PH, penurunan kerja siliaris, ketuban pecah lama, ketuban pecah sebelum waktunya, merokok, statis cairan tubuh), ketidakadekuatan pertahanan tubuh sekunder (penurunan hemoglobin, imununosupresi, leukopenia, supresi respon inflamasi, vaksinasi tidak adekuat).
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_resiko_infeksi" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="monitor_tanda_infeksi_sistemik"
                                                        {{ in_array('monitor_tanda_infeksi_sistemik', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tanda dan gejala infeksi lokal dan sistemik</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="batasi_pengunjung"
                                                        {{ in_array('batasi_pengunjung', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Batasi jumlah pengunjung</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="perawatan_kulit_edema"
                                                        {{ in_array('perawatan_kulit_edema', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan perawatan kulit pada area edema</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="cuci_tangan_kontak"
                                                        {{ in_array('cuci_tangan_kontak', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Cuci tangan sebelum dan sesudah kontak dengan pasien dan lingkungan pasien</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="pertahankan_teknik_aseptik"
                                                        {{ in_array('pertahankan_teknik_aseptik', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertahankan teknik aseptik pada pasien beresiko tinggi</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="jelaskan_tanda_infeksi_edukasi"
                                                        {{ in_array('jelaskan_tanda_infeksi_edukasi', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan tanda dan gejala infeksi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="ajarkan_cuci_tangan"
                                                        {{ in_array('ajarkan_cuci_tangan', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara mencuci tangan dengan benar</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="ajarkan_etika_batuk"
                                                        {{ in_array('ajarkan_etika_batuk', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan etika batuk</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="ajarkan_periksa_luka"
                                                        {{ in_array('ajarkan_periksa_luka', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara memeriksa kondisi luka atau luka operasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="anjurkan_asupan_nutrisi"
                                                        {{ in_array('anjurkan_asupan_nutrisi', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan meningkatkan asupan nutrisi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="anjurkan_asupan_cairan_infeksi"
                                                        {{ in_array('anjurkan_asupan_cairan_infeksi', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan meningkatkan asupan cairan</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="kolaborasi_imunisasi"
                                                        {{ in_array('kolaborasi_imunisasi', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian imunisasi, jika perlu.</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 13. Konstipasi -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="diagnosis[]" value="konstipasi" id="diag_konstipasi" onchange="toggleRencana('konstipasi')"
                                                    {{ in_array('konstipasi', old('diagnosis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_konstipasi">
                                                        <strong>Konstipasi</strong> b.d penurunan motilitas gastrointestinal, ketidaadekuatan pertumbuhan gigi, ketidakcukupan diet, ketidakcukupan asupan serat, ketidakcukupan asupan serat, ketidakcukupan asupan cairan, aganglionik (penyakit Hircsprung), kelemahan otot abdomen.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_konstipasi" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="periksa_tanda_gejala_konstipasi"
                                                        {{ in_array('periksa_tanda_gejala_konstipasi', old('rencana_konstipasi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa tanda dan gejala</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="periksa_pergerakan_usus"
                                                        {{ in_array('periksa_pergerakan_usus', old('rencana_konstipasi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa pergerakan usus, karakteristik feses</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="identifikasi_faktor_risiko_konstipasi"
                                                        {{ in_array('identifikasi_faktor_risiko_konstipasi', old('rencana_konstipasi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor risiko konstipasi</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="anjurkan_diet_tinggi_serat"
                                                        {{ in_array('anjurkan_diet_tinggi_serat', old('rencana_konstipasi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan diet tinggi serat</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="masase_abdomen"
                                                        {{ in_array('masase_abdomen', old('rencana_konstipasi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan masase abdomen, jika perlu</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="evakuasi_feses_manual"
                                                        {{ in_array('evakuasi_feses_manual', old('rencana_konstipasi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan evakuasi feses secara manual, jika perlu</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="berikan_enema"
                                                        {{ in_array('berikan_enema', old('rencana_konstipasi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan enema atau intigasi, jika perlu</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="jelaskan_etiologi_konstipasi"
                                                        {{ in_array('jelaskan_etiologi_konstipasi', old('rencana_konstipasi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan etiologi masalah dan alasan tindakan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="anjurkan_peningkatan_cairan_konstipasi"
                                                        {{ in_array('anjurkan_peningkatan_cairan_konstipasi', old('rencana_konstipasi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan peningkatan asupan cairan, jika tidak ada kontraindikasi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="ajarkan_mengatasi_konstipasi"
                                                        {{ in_array('ajarkan_mengatasi_konstipasi', old('rencana_konstipasi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara mengatasi konstipasi/impaksi</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="kolaborasi_obat_pencahar"
                                                        {{ in_array('kolaborasi_obat_pencahar', old('rencana_konstipasi', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi penggunaan obat pencahar, jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 14. Resiko Jatuh -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="diagnosis[]" value="resiko_jatuh" id="diag_resiko_jatuh" onchange="toggleRencana('resiko_jatuh')"
                                                    {{ in_array('resiko_jatuh', old('diagnosis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_resiko_jatuh">
                                                        <strong>Resiko jatuh</strong> b.d usia lebih dari sama dengan 65 tahun (pada dewasa) atau kurang dari sama dengan 2 tahun (pada anak) Riwayat jatuh, anggota gerak bawah prostesis (buatan), penggunaan alat bantu berjalan, penurunan tingkat kesadaran, perubahan fungsi kognitif, lingkungan tidak aman (licin, gelap, lingkungan asing), kondisi pasca operasi, hipotensi ortostatik, perubahan kadar glukosa darah, anemia, kekuatan otot menurun, gangguan pendengaran, gangguan keseimbangan, gangguan penglihatan (glaukoma, katarak, ablasio retina, neuritis optikus), neuropati, efek agen farmakologis (sedasi, alkohol, anastesi umum).
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_resiko_jatuh" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="identifikasi_faktor_risiko_jatuh"
                                                        {{ in_array('identifikasi_faktor_risiko_jatuh', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor risiko jatuh (usia >65 tahun, penurunan tingkat kesadaran, defisit kognitif, hipotensi ortostatik, gangguan keseimbangan, gangguan penglihatan, neuropati)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="identifikasi_risiko_setiap_shift"
                                                        {{ in_array('identifikasi_risiko_setiap_shift', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi risiko jatuh setidaknya sekali setiap shift atau sesuai dengan kebijakan institusi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="identifikasi_faktor_lingkungan"
                                                        {{ in_array('identifikasi_faktor_lingkungan', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor lingkungan yang meningkatkan risiko jatuh (lantai licin, penerangan kurang)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="hitung_risiko_jatuh"
                                                        {{ in_array('hitung_risiko_jatuh', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hitung risiko jatuh dengan menggunakan skala (Fall Morse Scale, humpty dumpty scale), jika perlu</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="monitor_kemampuan_berpindah"
                                                        {{ in_array('monitor_kemampuan_berpindah', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor kemampuan berpindah dari tempat tidur ke kursi roda dan sebaliknya</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="orientasikan_ruangan"
                                                        {{ in_array('orientasikan_ruangan', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Orientasikan ruangan pada pasien dan keluarga</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="pastikan_roda_terkunci"
                                                        {{ in_array('pastikan_roda_terkunci', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pastikan roda tempat tidur dan kursi roda selalu dalam kondisi terkunci</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="pasang_handrail"
                                                        {{ in_array('pasang_handrail', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pasang handrail tempat tidur</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="atur_tempat_tidur"
                                                        {{ in_array('atur_tempat_tidur', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Atur tempat tidur mekanis pada posisi terendah</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="tempatkan_dekat_perawat"
                                                        {{ in_array('tempatkan_dekat_perawat', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tempatkan pasien berisiko tinggi jatuh dekat dengan pantauan perawat dari nurse station</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="gunakan_alat_bantu"
                                                        {{ in_array('gunakan_alat_bantu', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Gunakan alat bantu berjalan (kursi roda, walker)</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="dekatkan_bel"
                                                        {{ in_array('dekatkan_bel', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Dekatkan bel pemanggil dalam jangkauan pasien</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="anjurkan_memanggil_perawat"
                                                        {{ in_array('anjurkan_memanggil_perawat', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan memanggil perawat jika membutuhkan bantuan untuk berpindah</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="anjurkan_alas_kaki"
                                                        {{ in_array('anjurkan_alas_kaki', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menggunakan alas kaki yang tidak licin</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="anjurkan_berkonsentrasi"
                                                        {{ in_array('anjurkan_berkonsentrasi', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan berkonsentrasi untuk menjaga keseimbangan tubuh</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="anjurkan_melebarkan_jarak"
                                                        {{ in_array('anjurkan_melebarkan_jarak', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan melebarkan jarak kedua kaki untuk meningkatkan keseimbangan saat berdiri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="ajarkan_bel_pemanggil"
                                                        {{ in_array('ajarkan_bel_pemanggil', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara menggunakan bel pemanggil untuk memanggil perawat</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 15. Gangguan Integritas Kulit/Jaringan -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="diagnosis[]" value="gangguan_integritas_kulit" id="diag_gangguan_integritas_kulit" onchange="toggleRencana('gangguan_integritas_kulit')"
                                                    {{ in_array('gangguan_integritas_kulit', old('diagnosis', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_gangguan_integritas_kulit">
                                                        <strong>Gangguan integritas kulit/jaringan</strong> b.d perubahan sirkulasi, perubahan status nutrisi (kelebihan atau kekurangan), kekurangan/kelebihan volume cairan, penurunan mobilitas, bahan kimia iritatif, suhu lingkungan yang ekstream, faktor mekanis (penekanan pada tonjolan tulang, gesekan) atau faktor elektris (elektrodiatermi, energi listrik bertegangan tinggi), efek samping terapi radiasi, kelembapan, proses penuaan, neuropati perifer, perubahan pigmentasi, perubahan hormonal, kurang terpapar informasi tentang upaya mempertahankan/melindungi integritas jaringan.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_gangguan_integritas_kulit" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="monitor_karakteristik_luka"
                                                        {{ in_array('monitor_karakteristik_luka', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor karakteristik luka</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="monitor_tanda_infeksi"
                                                        {{ in_array('monitor_tanda_infeksi', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tanda-tanda infeksi</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="lepaskan_balutan"
                                                        {{ in_array('lepaskan_balutan', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lepaskan balutan dan plester secara perlahan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="bersihkan_nacl"
                                                        {{ in_array('bersihkan_nacl', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Bersihkan dengan cairan NaCl atau pembersih nontoksik</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="bersihkan_jaringan_nekrotik"
                                                        {{ in_array('bersihkan_jaringan_nekrotik', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Bersihkan jaringan nekrotik</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="berikan_salep"
                                                        {{ in_array('berikan_salep', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan salep yang sesuai ke kulit/lesi, jika perlu</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="pasang_balutan"
                                                        {{ in_array('pasang_balutan', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pasang balutan sesuai jenis luka</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="pertahankan_teknik_steril"
                                                        {{ in_array('pertahankan_teknik_steril', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertahankan teknik steril saat melakukan perawatan luka</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="jelaskan_tanda_infeksi"
                                                        {{ in_array('jelaskan_tanda_infeksi', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan tanda dan gejala infeksi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="anjurkan_makanan_tinggi_protein"
                                                        {{ in_array('anjurkan_makanan_tinggi_protein', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan mengkonsumsi makanan tinggi kalori dan protein</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="kolaborasi_debridement"
                                                        {{ in_array('kolaborasi_debridement', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi prosedur debridement</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="kolaborasi_antibiotik"
                                                        {{ in_array('kolaborasi_antibiotik', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepPerinatologyKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian antibiotik</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>

                        {{-- Final section - Submit button --}}
                        <div class="text-end">
                            <x-button-submit>Perbarui</x-button-submit>
                        </div>
                    </div>
                </form>
            </x-content-card>
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