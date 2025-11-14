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
            <x-content-card>
            <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Asesmen Awal Keperawatan Anak',
                    'description' => 'Edit Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan',
                ])

                    {{-- FORM ASESMEN KEPERATAWAN ANAK --}}
                    <form method="POST"
                        action="{{ route('rawat-inap.asesmen.keperawatan.anak.update', [
                            'kd_unit' => $kd_unit,
                            'kd_pasien' => $kd_pasien,
                            'tgl_masuk' => $tgl_masuk,
                            'urut_masuk' => $urut_masuk,
                            'id' => $asesmen->id,
                        ]) }}">
                        @csrf
                        @method('PUT')
                        <div class="px-3">
                            {{-- 1. Data Masuk --}}
                            <div class="section-separator" id="data-masuk">
                                <h5 class="section-title">1. Data masuk</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tanggal Dan Jam Pengisian</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <input type="date" class="form-control" name="tanggal_masuk"
                                            id="tanggal_masuk"
                                            value="{{ date('Y-m-d', strtotime($asesmen->waktu_asesmen)) }}">
                                        <input type="time" class="form-control" name="jam_masuk" id="jam_masuk"
                                            value="{{ date('H:i', strtotime($asesmen->waktu_asesmen)) }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tiba Di Ruang Rawat Dengan Cara</label>
                                    <select class="form-select" name="cara_masuk">
                                        <option disabled
                                            {{ empty($asesmen->rmeAsesmenKepAnak->cara_masuk) ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="Mandiri"
                                            {{ $asesmen->rmeAsesmenKepAnak->cara_masuk == 'Mandiri' ? 'selected' : '' }}>
                                            Mandiri</option>
                                        <option value="Tempat Tidur"
                                            {{ $asesmen->rmeAsesmenKepAnak->cara_masuk == 'Tempat Tidur' ? 'selected' : '' }}>
                                            Tempat Tidur</option>
                                        <option value="Jalan Kaki"
                                            {{ $asesmen->rmeAsesmenKepAnak->cara_masuk == 'Jalan Kaki' ? 'selected' : '' }}>
                                            Jalan Kaki</option>
                                        <option value="Kursi Roda"
                                            {{ $asesmen->rmeAsesmenKepAnak->cara_masuk == 'Kursi Roda' ? 'selected' : '' }}>
                                            Kursi Roda</option>
                                        <option value="Brankar"
                                            {{ $asesmen->rmeAsesmenKepAnak->cara_masuk == 'Brankar' ? 'selected' : '' }}>
                                            Brankar</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Kasus Trauma</label>
                                    <select class="form-select" name="kasus_trauma">
                                        <option disabled
                                            {{ empty($asesmen->rmeAsesmenKepAnak->kasus_trauma) ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="Kecelakaan Lalu Lintas"
                                            {{ $asesmen->rmeAsesmenKepAnak->kasus_trauma == 'Kecelakaan Lalu Lintas' ? 'selected' : '' }}>
                                            Kecelakaan Lalu Lintas</option>
                                        <option value="Kecelakaan Anak"
                                            {{ $asesmen->rmeAsesmenKepAnak->kasus_trauma == 'Kecelakaan Anak' ? 'selected' : '' }}>
                                            Kecelakaan Anak</option>
                                        <option value="Kecelakaan Rumah Tangga"
                                            {{ $asesmen->rmeAsesmenKepAnak->kasus_trauma == 'Kecelakaan Rumah Tangga' ? 'selected' : '' }}>
                                            Kecelakaan Rumah Tangga</option>
                                        <option value="Non Trauma"
                                            {{ $asesmen->rmeAsesmenKepAnak->kasus_trauma == 'Non Trauma' ? 'selected' : '' }}>
                                            Non Trauma</option>
                                    </select>
                                </div>
                            </div>

                            {{-- 2. Anamnesis --}}
                            <div class="section-separator" id="anamnesis">
                                <h5 class="section-title">2. Anamnesis</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Anamnesis</label>
                                    <textarea class="form-control" name="anamnesis" rows="4"
                                        placeholder="keluhan utama dan riwayat penyakit sekarang">{{ $asesmen->anamnesis }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Keluhan Utama</label>
                                    <input type="text" class="form-control" name="keluhan_utama"
                                        value="{{ $asesmen->rmeAsesmenKepAnak->keluhan_utama }}"
                                        placeholder="keluhan utama">
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 200px;">Riwayat Kesehatan Sekarang</label>
                                    <input type="text" class="form-control" name="riwayat_kesehatan_sekarang"
                                        value="{{ $asesmen->rmeAsesmenKepAnak->riwayat_kesehatan_sekarang }}"
                                        placeholder="riwayat kesehatan sekarang">
                                </div>

                            </div>

                            {{-- 5. Riwayat Kesehatan --}}
                            <div class="section-separator" id="riwayat-kesehatan">
                                <h5 class="section-title">5. Riwayat Kesehatan</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Penyakit Yang Pernah Diderita</label>
                                    <div class="w-100">
                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            data-bs-toggle="modal" data-bs-target="#penyakitModal">
                                            <i class="ti-plus"></i> Tambah
                                        </button>
                                        <div id="selectedPenyakitList" class="d-flex flex-column gap-2">
                                            <!-- List will be populated via JavaScript -->
                                            <div id="emptyState"
                                                class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                <i class="ti-info-circle mb-2"></i>
                                                <p class="mb-0">Belum ada penyakit yang ditambahkan</p>
                                            </div>
                                        </div>
                                        <input type="hidden" name="penyakit_diderita" id="penyakitDideritaInput"
                                            value='{{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->penyakit_yang_diderita ?? '[]' }}'>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Riwayat Kecelakaan</label>
                                    <div class="w-100">
                                        <div class="d-flex gap-3 flex-wrap mb-2">
                                            @php
                                                // Parse data dari database - bisa berupa JSON string atau array
                                                $riwayatKecelakaanLalu = [];
                                                if (
                                                    !empty(
                                                        $asesmen->rmeAsesmenKepAnakRiwayatKesehatan
                                                            ->riwayat_kecelakaan_lalu
                                                    )
                                                ) {
                                                    $riwayatKecelakaanLalu = is_string(
                                                        $asesmen->rmeAsesmenKepAnakRiwayatKesehatan
                                                            ->riwayat_kecelakaan_lalu,
                                                    )
                                                        ? json_decode(
                                                            $asesmen->rmeAsesmenKepAnakRiwayatKesehatan
                                                                ->riwayat_kecelakaan_lalu,
                                                            true,
                                                        )
                                                        : $asesmen->rmeAsesmenKepAnakRiwayatKesehatan
                                                            ->riwayat_kecelakaan_lalu;
                                                }
                                                // Pastikan $riwayatKecelakaanLalu adalah array
                                                $riwayatKecelakaanLalu = is_array($riwayatKecelakaanLalu)
                                                    ? $riwayatKecelakaanLalu
                                                    : [];
                                            @endphp

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="riwayat_kecelakaan_lalu[]" value="Jatuh" id="jatuh_lalu"
                                                    {{ in_array('Jatuh', $riwayatKecelakaanLalu) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="jatuh_lalu">Jatuh</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="riwayat_kecelakaan_lalu[]" value="Tenggelam"
                                                    id="tenggelam_lalu"
                                                    {{ in_array('Tenggelam', $riwayatKecelakaanLalu) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="tenggelam_lalu">Tenggelam</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="riwayat_kecelakaan_lalu[]" value="KLL" id="kll_lalu"
                                                    {{ in_array('KLL', $riwayatKecelakaanLalu) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kll_lalu">KLL</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="riwayat_kecelakaan_lalu[]" value="Keracunan"
                                                    id="keracunan_lalu"
                                                    {{ in_array('Keracunan', $riwayatKecelakaanLalu) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="keracunan_lalu">Keracunan</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="riwayat_kecelakaan_lalu[]" value="Tidak Ada"
                                                    id="tidak_ada_kecelakaan"
                                                    {{ in_array('Tidak Ada', $riwayatKecelakaanLalu) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="tidak_ada_kecelakaan">Tidak
                                                    Ada</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label style="min-width: 200px;">Riwayat Rawat Inap</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <select class="form-select flex-grow-1" name="riwayat_rawat_inap">
                                            <option disabled
                                                {{ empty($asesmen->rmeAsesmenKepAnakRiwayatKesehatan->riwayat_rawat_inap) ? 'selected' : '' }}>
                                                --Pilih--</option>
                                            <option value="Ya"
                                                {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->riwayat_rawat_inap == 'Ya' ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="Tidak"
                                                {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->riwayat_rawat_inap == 'Tidak' ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                        <input type="date" class="form-control" name="tanggal_rawat_inap"
                                            value="{{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->tanggal_riwayat_rawat_inap }}"
                                            style="width: 200px;">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Riwayat Operasi</label>
                                    <select class="form-select" name="riwayat_operasi">
                                        <option disabled
                                            {{ empty($asesmen->rmeAsesmenKepAnakRiwayatKesehatan->riwayat_operasi) ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="Ya"
                                            {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->riwayat_operasi == 'Ya' ? 'selected' : '' }}>
                                            Ya</option>
                                        <option value="Tidak"
                                            {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->riwayat_operasi == 'Tidak' ? 'selected' : '' }}>
                                            Tidak</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Jenis/Nama Operasi</label>
                                    <div class="w-100">
                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            data-bs-toggle="modal" data-bs-target="#operasiModal">
                                            <i class="ti-plus"></i> Tambah
                                        </button>
                                        <div id="selectedOperasiList" class="d-flex flex-column gap-2">
                                            <div id="emptyStateOperasi"
                                                class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                <i class="ti-info-circle mb-2"></i>
                                                <p class="mb-0">Belum ada operasi yang ditambahkan</p>
                                            </div>
                                        </div>
                                        <input type="hidden" name="jenis_operasi" id="jenisOperasiInput"
                                            value='{{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->nama_operasi ?? '[]' }}'>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Riwayat Kesehatan Keluarga</label>
                                    <div class="w-100">
                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            data-bs-toggle="modal" data-bs-target="#riwayatKeluargaModal">
                                            <i class="ti-plus"></i> Tambah
                                        </button>
                                        <div id="selectedRiwayatList" class="d-flex flex-column gap-2">
                                            @if ($asesmen->rmeAsesmenKepAnakRiwayatKesehatan->riwayat_penyakit_keluarga)
                                                <!-- List riwayat kesehatan keluarga akan di-populate via JavaScript -->
                                            @else
                                                <div id="emptyStateRiwayat"
                                                    class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                    <i class="ti-info-circle mb-2"></i>
                                                    <p class="mb-0">Belum ada riwayat kesehatan keluarga yang
                                                        ditambahkan.</p>
                                                </div>
                                            @endif
                                        </div>
                                        <input type="hidden" name="riwayat_kesehatan_keluarga"
                                            id="riwayatKesehatanInput"
                                            value="{{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->riwayat_penyakit_keluarga }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Konsumsi Obat-Obatan</label>
                                    <input type="text" class="form-control" name="konsumsi_obat"
                                        value="{{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->konsumsi_obat }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tumbuh Kembang Dibanding
                                        Saudara-Saudaranya</label>
                                    <select class="form-select" name="tumbuh_kembang">
                                        <option disabled
                                            {{ empty($asesmen->rmeAsesmenKepAnakRiwayatKesehatan->tumbuh_kembang) ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="Sama"
                                            {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->tumbuh_kembang == 'Sama' ? 'selected' : '' }}>
                                            Sama</option>
                                        <option value="Cepat"
                                            {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->tumbuh_kembang == 'Cepat' ? 'selected' : '' }}>
                                            Cepat</option>
                                        <option value="Lambat"
                                            {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->tumbuh_kembang == 'Lambat' ? 'selected' : '' }}>
                                            Lambat</option>
                                    </select>
                                </div>
                            </div>

                            {{-- 6. Alergi --}}
                            <div class="section-separator" id="alergi">
                                <h5 class="section-title">6. Alergi</h5>

                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                    id="openAlergiModal" data-bs-toggle="modal" data-bs-target="#alergiModal">
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

                            {{-- 3. Pemeriksaan Fisik --}}
                            <div class="section-separator" id="pemeriksaan-fisik">
                                <h5 class="section-title">3. Pemeriksaan fisik</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tek. Darah (mmHg)</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <div class="flex-grow-1">
                                            <label class="form-label">Sistole</label>
                                            <input type="number" class="form-control" name="sistole"
                                                value="{{ $asesmen->rmeAsesmenKepAnakFisik->sistole }}"
                                                placeholder="Sistole">
                                        </div>
                                        <div class="flex-grow-1">
                                            <label class="form-label">Diastole</label>
                                            <input type="number" class="form-control" name="diastole"
                                                value="{{ $asesmen->rmeAsesmenKepAnakFisik->diastole }}"
                                                placeholder="Diastole">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Nadi (Per Menit)</label>
                                    <input type="number" class="form-control" name="nadi"
                                        value="{{ $asesmen->rmeAsesmenKepAnakFisik->nadi }}"
                                        placeholder="frekuensi nadi per menit">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Nafas (Per Menit)</label>
                                    <input type="number" class="form-control" name="nafas"
                                        value="{{ $asesmen->rmeAsesmenKepAnakFisik->nafas }}"
                                        placeholder="frekuensi nafas per menit">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Suhu (C)</label>
                                    <input type="text" class="form-control" name="suhu"
                                        value="{{ $asesmen->rmeAsesmenKepAnakFisik->suhu }}"
                                        placeholder="suhu dalam celcius">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Saturasi Oksigen (%)</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <div class="flex-grow-1">
                                            <label class="form-label">Tanpa Bantuan O2</label>
                                            <input type="number" class="form-control" name="saturasi_o2_tanpa"
                                                value="{{ $asesmen->rmeAsesmenKepAnakFisik->spo2_tanpa_bantuan }}"
                                                placeholder="Tanpa bantuan O2">
                                        </div>
                                        <div class="flex-grow-1">
                                            <label class="form-label">Dengan Bantuan O2</label>
                                            <input type="number" class="form-control" name="saturasi_o2_dengan"
                                                value="{{ $asesmen->rmeAsesmenKepAnakFisik->spo2_dengan_bantuan }}"
                                                placeholder="Dengan bantuan O2">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Kesadaran</label>
                                    <select class="form-select" name="kesadaran">
                                        <option disabled
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->kesadaran == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="Compos Mentis"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->kesadaran == 'Compos Mentis' ? 'selected' : '' }}>
                                            Compos Mentis</option>
                                        <option value="Apatis"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->kesadaran == 'Apatis' ? 'selected' : '' }}>
                                            Apatis</option>
                                        <option value="Sopor"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->kesadaran == 'Sopor' ? 'selected' : '' }}>
                                            Sopor</option>
                                        <option value="Coma"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->kesadaran == 'Coma' ? 'selected' : '' }}>
                                            Coma</option>
                                        <option value="Somnolen"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->kesadaran == 'Somnolen' ? 'selected' : '' }}>
                                            Somnolen</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">GCS (Glasgow Coma Scale)</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <input type="text" class="form-control bg-light" name="gcs"
                                            id="gcs_display" placeholder="Klik untuk input GCS" readonly
                                            style="cursor: pointer;">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#gcsModal">
                                            Input GCS
                                        </button>
                                    </div>
                                    <input type="hidden" name="gcs_value" id="gcs_value">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Penglihatan</label>
                                    <select class="form-select" name="penglihatan">
                                        <option disabled
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->penglihatan == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->penglihatan == '1' ? 'selected' : '' }}>
                                            Baik</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->penglihatan == '2' ? 'selected' : '' }}>
                                            Rusak</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->penglihatan == '3' ? 'selected' : '' }}>
                                            Alat Bantu</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Pendengaran</label>
                                    <select class="form-select" name="pendengaran">
                                        <option disabled
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->pendengaran == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->pendengaran == '1' ? 'selected' : '' }}>
                                            Baik</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->pendengaran == '2' ? 'selected' : '' }}>
                                            Rusak</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->pendengaran == '3' ? 'selected' : '' }}>
                                            Alat Bantu</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Bicara</label>
                                    <select class="form-select" name="bicara">
                                        <option disabled
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->bicara == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->bicara == '1' ? 'selected' : '' }}>
                                            Normal</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->bicara == '2' ? 'selected' : '' }}>
                                            Gangguan</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Refleks Menelan</label>
                                    <select class="form-select" name="refleks_menelan">
                                        <option disabled
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->refleksi_menelan == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->refleksi_menelan == '1' ? 'selected' : '' }}>
                                            Normal</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->refleksi_menelan == '3' ? 'selected' : '' }}>
                                            Rusak</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->refleksi_menelan == '2' ? 'selected' : '' }}>
                                            Sulit</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Pola Tidur</label>
                                    <select class="form-select" name="pola_tidur">
                                        <option disabled
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->pola_tidur == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->pola_tidur == '1' ? 'selected' : '' }}>
                                            Normal</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->pola_tidur == '2' ? 'selected' : '' }}>
                                            Masalah</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Luka</label>
                                    <select class="form-select" name="luka">
                                        <option disabled
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->luka == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->luka == '1' ? 'selected' : '' }}>
                                            Normal</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->luka == '2' ? 'selected' : '' }}>
                                            Gangguan</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->luka == '3' ? 'selected' : '' }}>Tidak
                                            Ada Luka</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Defekasi</label>
                                    <select class="form-select" name="defekasi">
                                        <option disabled
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->defekasi == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->defekasi == '1' ? 'selected' : '' }}>
                                            Tidak Ada</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->defekasi == '2' ? 'selected' : '' }}>
                                            Ada, Normal</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->defekasi == '3' ? 'selected' : '' }}>
                                            Konsitipasi</option>
                                        <option value="4"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->defekasi == '4' ? 'selected' : '' }}>
                                            Inkontinesia Alvi</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Miksi</label>
                                    <select class="form-select" name="miksi">
                                        <option disabled
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->miksi == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->miksi == '1' ? 'selected' : '' }}>
                                            Normal</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->miksi == '2' ? 'selected' : '' }}>
                                            Retensio</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->miksi == '3' ? 'selected' : '' }}>
                                            Inkontinesia Urine</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Gastrointestinal</label>
                                    <select class="form-select" name="gastrointestinal">
                                        <option disabled
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->gastrointestinal == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->gastrointestinal == '1' ? 'selected' : '' }}>
                                            Normal</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->gastrointestinal == '2' ? 'selected' : '' }}>
                                            Nausea</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakFisik->gastrointestinal == '3' ? 'selected' : '' }}>
                                            Muntah</option>
                                    </select>
                                </div>



                                <div class="mt-4">
                                    <h6>Pemeriksaan Lanjutan</h6>

                                    <div class="form-group">
                                    <label style="min-width: 200px;">Lahir Umur Kehamilan</label>
                                    <input type="text" class="form-control" name="umur_kehamilan"
                                        value="{{ $asesmen->rmeAsesmenKepAnakFisik->lahir_umur_kehamilan }}"
                                        placeholder="minggu/bulan">
                                </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">ASI Sampai Umur</label>
                                        <input type="text" class="form-control" name="Asi_Sampai_Umur"
                                            value="{{ $asesmen->rmeAsesmenKepAnakFisik->asi_Sampai_Umur }}"
                                            placeholder="minggu/bulan">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Alasan Berhenti Menyusui</label>
                                        <input type="text" class="form-control" name="alasan_berhenti_menyusui"
                                            value="{{ $asesmen->rmeAsesmenKepAnakFisik->alasan_berhenti_menyusui }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Masalah Neonatus</label>
                                        <input type="text" class="form-control" name="masalah_neonatus"
                                            value="{{ $asesmen->rmeAsesmenKepAnakFisik->masalah_neonatus }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kelainan Kongenital</label>
                                        <input type="text" class="form-control" name="kelainan_kongenital"
                                            value="{{ $asesmen->rmeAsesmenKepAnakFisik->kelainan_kongenital }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tengkurap</label>
                                        <input type="text" class="form-control" name="tengkurap"
                                            value="{{ $asesmen->rmeAsesmenKepAnakFisik->tengkurap }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Merangkak</label>
                                        <input type="text" class="form-control" name="merangkak"
                                            value="{{ $asesmen->rmeAsesmenKepAnakFisik->merangkak }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Duduk</label>
                                        <input type="text" class="form-control" name="duduk"
                                            value="{{ $asesmen->rmeAsesmenKepAnakFisik->duduk }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Berdiri</label>
                                        <input type="text" class="form-control" name="berdiri"
                                            value="{{ $asesmen->rmeAsesmenKepAnakFisik->berdiri }}">
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <h6>Antropometri</h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tinggi Badan (Cm)</label>
                                        <input type="number" id="tinggi_badan" name="tinggi_badan"
                                            class="form-control"
                                            value="{{ $asesmen->rmeAsesmenKepAnakFisik->tinggi_badan }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Berat Badan (Kg)</label>
                                        <input type="number" id="berat_badan" name="berat_badan"
                                            class="form-control"
                                            value="{{ $asesmen->rmeAsesmenKepAnakFisik->berat_badan }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">IMT</label>
                                        <input type="text" class="form-control bg-light" id="imt"
                                            name="imt" readonly
                                            value="{{ $asesmen->rmeAsesmenKepAnakFisik->imt }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">LPT</label>
                                        <input type="text" class="form-control bg-light" id="lpt"
                                            name="lpt" readonly
                                            value="{{ $asesmen->rmeAsesmenKepAnakFisik->lpt }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lingkar Kepala (Cm)</label>
                                        <input type="text" class="form-control" name="lingkar_kepala"
                                            value="{{ $asesmen->rmeAsesmenKepAnakFisik->lingkar_kepala }}">
                                    </div>
                                </div>

                                <div class="alert alert-info mb-3 mt-4">
                                    <p class="mb-0 small">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Centang normal jika fisik yang dinilai normal, pilih tanda tambah untuk menambah
                                        keterangan fisik yang ditemukan tidak normal.
                                        Jika tidak dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                    </p>
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
                                                                    <div class="flex-grow-1">{{ $item->nama }}
                                                                    </div>
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

                            {{-- 4. Status Nyeri --}}
                            <div class="section-separator" id="status-nyeri">
                                <h5 class="section-title">4. Status nyeri</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Jenis Skala NYERI</label>
                                    <select class="form-select" name="jenis_skala_nyeri" id="jenis_skala_nyeri">
                                        <option disabled
                                            {{ empty($asesmen->rmeAsesmenKepAnakStatusNyeri?->jenis_skala_nyeri) ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="NRS"
                                            {{ $asesmen->rmeAsesmenKepAnakStatusNyeri?->jenis_skala_nyeri == 1 ? 'selected' : '' }}>
                                            Numeric Rating Scale (NRS)
                                        </option>
                                        <option value="FLACC"
                                            {{ $asesmen->rmeAsesmenKepAnakStatusNyeri?->jenis_skala_nyeri == 2 ? 'selected' : '' }}>
                                            Face, Legs, Activity, Cry, Consolability (FLACC)
                                        </option>
                                        <option value="CRIES"
                                            {{ $asesmen->rmeAsesmenKepAnakStatusNyeri?->jenis_skala_nyeri == 3 ? 'selected' : '' }}>
                                            Crying, Requires, Increased, Expression, Sleepless (CRIES)
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Nilai Skala Nyeri</label>
                                    <input type="text" class="form-control" id="nilai_skala_nyeri"
                                        name="nilai_skala_nyeri" readonly
                                        value="{{ $asesmen->rmeAsesmenKepAnakStatusNyeri?->nilai_nyeri ?? '' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Kesimpulan Nyeri</label>
                                    <input type="hidden" class="form-control" id="kesimpulan_nyeri"
                                        name="kesimpulan_nyeri"
                                        value="{{ $asesmen->rmeAsesmenKepAnakStatusNyeri?->kesimpulan_nyeri ?? '' }}">
                                    <div class="alert alert-success" id="kesimpulan_nyeri_alert">
                                        {{ $asesmen->rmeAsesmenKepAnakStatusNyeri?->kesimpulan_nyeri ?? 'Pilih skala nyeri terlebih dahulu' }}
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <h6 class="mb-3">Karakteristik Nyeri</h6>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label class="form-label">Lokasi</label>
                                            <input type="text" class="form-control" name="lokasi_nyeri"
                                                value="{{ $asesmen->rmeAsesmenKepAnakStatusNyeri?->lokasi ?? '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Durasi</label>
                                            <input type="text" class="form-control" name="durasi_nyeri"
                                                value="{{ $asesmen->rmeAsesmenKepAnakStatusNyeri?->durasi ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label class="form-label">Jenis nyeri</label>
                                            <select class="form-select" name="jenis_nyeri">
                                                <option disabled
                                                    {{ empty($asesmen->rmeAsesmenKepAnakStatusNyeri?->jenis_nyeri) ? 'selected' : '' }}>
                                                    --Pilih--</option>
                                                @foreach ($jenisnyeri as $jenis)
                                                    <option value="{{ $jenis->id }}"
                                                        {{ $asesmen->rmeAsesmenKepAnakStatusNyeri?->jenis_nyeri == $jenis->id ? 'selected' : '' }}>
                                                        {{ $jenis->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Frekuensi</label>
                                            <select class="form-select" name="frekuensi_nyeri">
                                                <option disabled
                                                    {{ empty($asesmen->rmeAsesmenKepAnakStatusNyeri?->frekuensi) ? 'selected' : '' }}>
                                                    --Pilih--</option>
                                                @foreach ($frekuensinyeri as $frekuensi)
                                                    <option value="{{ $frekuensi->id }}"
                                                        {{ $asesmen->rmeAsesmenKepAnakStatusNyeri?->frekuensi == $frekuensi->id ? 'selected' : '' }}>
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
                                                <option disabled
                                                    {{ empty($asesmen->rmeAsesmenKepAnakStatusNyeri?->menjalar) ? 'selected' : '' }}>
                                                    --Pilih--</option>
                                                @foreach ($menjalar as $menjalarItem)
                                                    <option value="{{ $menjalarItem->id }}"
                                                        {{ $asesmen->rmeAsesmenKepAnakStatusNyeri?->menjalar == $menjalarItem->id ? 'selected' : '' }}>
                                                        {{ $menjalarItem->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Kualitas</label>
                                            <select class="form-select" name="kualitas_nyeri">
                                                <option disabled
                                                    {{ empty($asesmen->rmeAsesmenKepAnakStatusNyeri?->kualitas) ? 'selected' : '' }}>
                                                    --Pilih--</option>
                                                @foreach ($kualitasnyeri as $kualitas)
                                                    <option value="{{ $kualitas->id }}"
                                                        {{ $asesmen->rmeAsesmenKepAnakStatusNyeri?->kualitas == $kualitas->id ? 'selected' : '' }}>
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
                                                <option disabled
                                                    {{ empty($asesmen->rmeAsesmenKepAnakStatusNyeri?->faktor_pemberat) ? 'selected' : '' }}>
                                                    --Pilih--</option>
                                                @foreach ($faktorpemberat as $pemberat)
                                                    <option value="{{ $pemberat->id }}"
                                                        {{ $asesmen->rmeAsesmenKepAnakStatusNyeri?->faktor_pemberat == $pemberat->id ? 'selected' : '' }}>
                                                        {{ $pemberat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Faktor peringan</label>
                                            <select class="form-select" name="faktor_peringan">
                                                <option disabled
                                                    {{ empty($asesmen->rmeAsesmenKepAnakStatusNyeri?->faktor_peringan) ? 'selected' : '' }}>
                                                    --Pilih--</option>
                                                @foreach ($faktorperingan as $peringan)
                                                    <option value="{{ $peringan->id }}"
                                                        {{ $asesmen->rmeAsesmenKepAnakStatusNyeri?->faktor_peringan == $peringan->id ? 'selected' : '' }}>
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
                                                <option disabled
                                                    {{ empty($asesmen->rmeAsesmenKepAnakStatusNyeri?->efek_nyeri) ? 'selected' : '' }}>
                                                    --Pilih--</option>
                                                @foreach ($efeknyeri as $efek)
                                                    <option value="{{ $efek->id }}"
                                                        {{ $asesmen->rmeAsesmenKepAnakStatusNyeri?->efek_nyeri == $efek->id ? 'selected' : '' }}>
                                                        {{ $efek->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- 7. Risiko Jatuh --}}
                            <div class="section-separator" id="risiko_jatuh">
                                <h5 class="section-title">7. Risiko Jatuh</h5>

                                <div class="mb-4">
                                    <label class="form-label">Pilih jenis penilaian risiko jatuh sesuai dengan kondisi
                                        pasien:</label>
                                    <select class="form-select" id="risikoJatuhSkala" name="resiko_jatuh_jenis"
                                        onchange="showForm(this.value)">
                                        <option value="">--Pilih Skala--</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->resiko_jatuh_jenis == 1 ? 'selected' : '' }}>
                                            Skala Umum</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->resiko_jatuh_jenis == 2 ? 'selected' : '' }}>
                                            Skala Morse</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->resiko_jatuh_jenis == 3 ? 'selected' : '' }}>
                                            Skala Humpty-Dumpty / Pediatrik</option>
                                        <option value="4"
                                            {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->resiko_jatuh_jenis == 4 ? 'selected' : '' }}>
                                            Skala Ontario Modified Stratify Sydney / Lansia</option>
                                        <option value="5"
                                            {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->resiko_jatuh_jenis == 5 ? 'selected' : '' }}>
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
                                                        {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_usia == 1 ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0"
                                                        {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_usia == 0 ? 'selected' : '' }}>
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
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_kondisi_khusus == 1 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_kondisi_khusus == 0 ? 'selected' : '' }}>
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
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson == 1 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson == 0 ? 'selected' : '' }}>
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
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko == 1 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko == 0 ? 'selected' : '' }}>
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
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko == 1 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko == 0 ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>
                                    <div
                                        class="conclusion {{ strpos($asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_umum ?? '', 'Berisiko') !== false ? 'bg-danger' : 'bg-success' }}">
                                        <p class="conclusion-text">Kesimpulan: <span
                                                id="kesimpulanTextForm">{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_umum ?? 'Tidak berisiko jatuh' }}</span>
                                        </p>
                                        <input type="hidden" name="risiko_jatuh_umum_kesimpulan"
                                            id="risiko_jatuh_umum_kesimpulan"
                                            value="{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_umum ?? 'Tidak berisiko jatuh' }}">
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
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh == 0 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh == 1 ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Pasien memiliki diagnosis skunder?</label>
                                        <select class="form-select" name="risiko_jatuh_morse_diagnosis_sekunder"
                                            onchange="updateConclusion('morse')">
                                            <option value="">pilih</option>
                                            <option value="15"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder == 0 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder == 1 ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Pasien membutuhkan bantuan ambulasi?</label>
                                        <select class="form-select" name="risiko_jatuh_morse_bantuan_ambulasi"
                                            onchange="updateConclusion('morse')">
                                            <option value="">pilih</option>
                                            <option value="30"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi == 0 ? 'selected' : '' }}>
                                                Meja/ kursi</option>
                                            <option value="15"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi == 1 ? 'selected' : '' }}>
                                                Kruk/ tongkat/ alat bantu berjalan</option>
                                            <option value="0"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi == 2 ? 'selected' : '' }}>
                                                Tidak ada/ bed rest/ bantuan perawat</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Pasien terpasang infus?</label>
                                        <select class="form-select" name="risiko_jatuh_morse_terpasang_infus"
                                            onchange="updateConclusion('morse')">
                                            <option value="">pilih</option>
                                            <option value="20"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_terpasang_infus) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_terpasang_infus == 0 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_terpasang_infus) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_terpasang_infus == 1 ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Bagaimana cara berjalan pasien?</label>
                                        <select class="form-select" name="risiko_jatuh_morse_cara_berjalan"
                                            onchange="updateConclusion('morse')">
                                            <option value="">pilih</option>
                                            <option value="0"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_cara_berjalan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_cara_berjalan == 0 ? 'selected' : '' }}>
                                                Normal/ bed rest/ kursi roda</option>
                                            <option value="20"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_cara_berjalan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_cara_berjalan == 1 ? 'selected' : '' }}>
                                                Terganggu</option>
                                            <option value="10"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_cara_berjalan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_cara_berjalan == 2 ? 'selected' : '' }}>
                                                Lemah</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Bagaimana status mental pasien?</label>
                                        <select class="form-select" name="risiko_jatuh_morse_status_mental"
                                            onchange="updateConclusion('morse')">
                                            <option value="">pilih</option>
                                            <option value="0"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_status_mental) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_status_mental == 0 ? 'selected' : '' }}>
                                                Beroroentasi pada kemampuannya</option>
                                            <option value="15"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_status_mental) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_status_mental == 1 ? 'selected' : '' }}>
                                                Lupa akan keterbatasannya</option>
                                        </select>
                                    </div>
                                    <div
                                        class="conclusion {{ strpos($asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_morse ?? '', 'Tinggi') !== false ? 'bg-danger' : (strpos($asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_morse ?? '', 'Sedang') !== false ? 'bg-warning' : 'bg-success') }}">
                                        <p class="conclusion-text">Kesimpulan: <span
                                                id="kesimpulanTextForm">{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_morse ?? 'Risiko Rendah' }}</span>
                                        </p>
                                        <input type="hidden" name="risiko_jatuh_morse_kesimpulan"
                                            id="risiko_jatuh_morse_kesimpulan"
                                            value="{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_morse ?? 'Risiko Rendah' }}">
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
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak == 0 ? 'selected' : '' }}>
                                                Dibawah 3 tahun</option>
                                            <option value="3"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak == 1 ? 'selected' : '' }}>
                                                3-7 tahun</option>
                                            <option value="2"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak == 2 ? 'selected' : '' }}>
                                                7-13 tahun</option>
                                            <option value="1"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak == 3 ? 'selected' : '' }}>
                                                Diatas 13 tahun</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jenis kelamin</label>
                                        <select class="form-select" name="risiko_jatuh_pediatrik_jenis_kelamin"
                                            onchange="updateConclusion('humpty')">
                                            <option value="">pilih</option>
                                            <option value="2"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin == 0 ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="1"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin == 1 ? 'selected' : '' }}>
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
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis == 0 ? 'selected' : '' }}>
                                                Diagnosis Neurologis</option>
                                            <option value="3"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis == 1 ? 'selected' : '' }}>
                                                Perubahan oksigennasi (diangnosis respiratorik, dehidrasi, anemia,
                                                syncope, pusing, dsb)</option>
                                            <option value="2"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis == 2 ? 'selected' : '' }}>
                                                Gangguan perilaku /psikiatri</option>
                                            <option value="1"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis == 3 ? 'selected' : '' }}>
                                                Diagnosis lainnya</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Gangguan Kognitif</label>
                                        <select class="form-select" name="risiko_jatuh_pediatrik_gangguan_kognitif"
                                            onchange="updateConclusion('humpty')">
                                            <option value="">pilih</option>
                                            <option value="3"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif == 0 ? 'selected' : '' }}>
                                                Tidak menyadari keterbatasan dirinya</option>
                                            <option value="2"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif == 1 ? 'selected' : '' }}>
                                                Lupa akan adanya keterbatasan</option>
                                            <option value="1"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif == 2 ? 'selected' : '' }}>
                                                Orientasi baik terhadap dari sendiri</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Faktor Lingkungan</label>
                                        <select class="form-select" name="risiko_jatuh_pediatrik_faktor_lingkungan"
                                            onchange="updateConclusion('humpty')">
                                            <option value="">pilih</option>
                                            <option value="4"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan == 0 ? 'selected' : '' }}>
                                                Riwayat jatuh /bayi diletakkan di tempat tidur dewasa</option>
                                            <option value="3"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan == 1 ? 'selected' : '' }}>
                                                Pasien menggunakan alat bantu /bayi diletakkan di tempat tidur bayi /
                                                perabot rumah</option>
                                            <option value="2"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan == 2 ? 'selected' : '' }}>
                                                Pasien diletakkan di tempat tidur</option>
                                            <option value="1"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan == 3 ? 'selected' : '' }}>
                                                Area di luar rumah sakit</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Pembedahan/ sedasi/ Anestesi</label>
                                        <select class="form-select" name="risiko_jatuh_pediatrik_pembedahan"
                                            onchange="updateConclusion('humpty')">
                                            <option value="">pilih</option>
                                            <option value="3"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_pembedahan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_pembedahan == 0 ? 'selected' : '' }}>
                                                Dalam 24 jam</option>
                                            <option value="2"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_pembedahan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_pembedahan == 1 ? 'selected' : '' }}>
                                                Dalam 48 jam</option>
                                            <option value="1"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_pembedahan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_pembedahan == 2 ? 'selected' : '' }}>
                                                > 48 jam atau tidak menjalani pembedahan/sedasi/anestesi</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Penggunaan Medika mentosa</label>
                                        <select class="form-select" name="risiko_jatuh_pediatrik_penggunaan_mentosa"
                                            onchange="updateConclusion('humpty')">
                                            <option value="">pilih</option>
                                            <option value="3"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa == 0 ? 'selected' : '' }}>
                                                Penggunaan multiple: sedative, obat hipnosis, barbiturate, fenotiazi,
                                                antidepresan, pencahar, diuretik, narkose</option>
                                            <option value="2"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa == 1 ? 'selected' : '' }}>
                                                Penggunaan salah satu obat diatas</option>
                                            <option value="1"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa == 2 ? 'selected' : '' }}>
                                                Penggunaan medikasi lainnya/tidak ada mediksi</option>
                                        </select>
                                    </div>

                                    <div
                                        class="conclusion {{ strpos($asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_pediatrik ?? '', 'Tinggi') !== false ? 'bg-danger' : 'bg-success' }}">
                                        <p class="conclusion-text">Kesimpulan: <span
                                                id="kesimpulanTextForm">{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_pediatrik ?? 'Risiko Rendah' }}</span>
                                        </p>
                                        <input type="hidden" name="risiko_jatuh_pediatrik_kesimpulan"
                                            id="risiko_jatuh_pediatrik_kesimpulan"
                                            value="{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_pediatrik ?? 'Risiko Rendah' }}">
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
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs == 0 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs == 1 ? 'selected' : '' }}>
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
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan == 0 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan == 1 ? 'selected' : '' }}>
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
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_bingung) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_bingung == 0 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_bingung) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_bingung == 1 ? 'selected' : '' }}>
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
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_disorientasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_disorientasi == 0 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_disorientasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_disorientasi == 1 ? 'selected' : '' }}>
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
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_agitasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_agitasi == 0 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_agitasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_agitasi == 1 ? 'selected' : '' }}>
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
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_kacamata == 1 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_kacamata == 0 ? 'selected' : '' }}>
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
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan == 1 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan == 0 ? 'selected' : '' }}>
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
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_glukoma == 1 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_glukoma == 0 ? 'selected' : '' }}>
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
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih == 0 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih == 1 ? 'selected' : '' }}>
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
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_mandiri == 1 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_mandiri == 0 ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Memerlukan sedikit bantuan (1 orang) / dalam
                                            pengawasan</label>
                                        <select class="form-select"
                                            name="risiko_jatuh_lansia_transfer_bantuan_sedikit"
                                            onchange="updateConclusion('ontario')">
                                            <option value="">pilih</option>
                                            <option value="1"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit == 1 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit == 0 ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Memerlukan bantuan yang nyata (2 orang)</label>
                                        <select class="form-select" name="risiko_jatuh_lansia_transfer_bantuan_nyata"
                                            onchange="updateConclusion('ontario')">
                                            <option value="">pilih</option>
                                            <option value="2"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata == 0 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata == 1 ? 'selected' : '' }}>
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
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total == 0 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total == 1 ? 'selected' : '' }}>
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
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri == 1 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri == 0 ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">berjalan dengan bantuan 1 orang (verbal/
                                            fisik)</label>
                                        <select class="form-select"
                                            name="risiko_jatuh_lansia_mobilitas_bantuan_1_orang"
                                            onchange="updateConclusion('ontario')">
                                            <option value="">pilih</option>
                                            <option value="1"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang == 1 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang == 0 ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Menggunakan kusi roda</label>
                                        <select class="form-select" name="risiko_jatuh_lansia_mobilitas_kursi_roda"
                                            onchange="updateConclusion('ontario')">
                                            <option value="">pilih</option>
                                            <option value="2"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda == 0 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda == 1 ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Imobilisasi</label>
                                        <select class="form-select" name="risiko_jatuh_lansia_mobilitas_imobilisasi"
                                            onchange="updateConclusion('ontario')">
                                            <option value="">pilih</option>
                                            <option value="3"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi == 0 ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi == 1 ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>

                                    <div
                                        class="conclusion {{ strpos($asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_lansia ?? '', 'Tinggi') !== false ? 'bg-danger' : (strpos($asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_lansia ?? '', 'Sedang') !== false ? 'bg-warning' : 'bg-success') }}">
                                        <p class="conclusion-text">Kesimpulan: <span
                                                id="kesimpulanTextForm">{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_lansia ?? 'Risiko Rendah' }}</span>
                                        </p>
                                        <input type="hidden" name="risiko_jatuh_lansia_kesimpulan"
                                            id="risiko_jatuh_lansia_kesimpulan"
                                            value="{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_lansia ?? 'Risiko Rendah' }}">
                                    </div>
                                </div>

                                <!-- Bagian Intervensi Risiko Jatuh -->
                                <div class="mb-4">
                                    <h6 class="mb-3">Intervensi Risiko Jatuh</h6>
                                    <p class="mb-2">Tambah tindakan intervensi risiko jatuh:</p>

                                    <button type="button"
                                        class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3"
                                        data-bs-toggle="modal" data-bs-target="#tindakanKeperawatanRisikoJatuhModal">
                                        <i class="ti-plus"></i> Tambah
                                    </button>
                                    <div id="selectedTindakanList-risikojatuh" class="d-flex flex-column gap-2">
                                        @if ($asesmen->rmeAsesmenKepAnakRisikoJatuh->intervensi_risiko_jatuh)
                                            @php
                                                $intervensiList = json_decode(
                                                    $asesmen->rmeAsesmenKepAnakRisikoJatuh->intervensi_risiko_jatuh,
                                                    true,
                                                );
                                            @endphp
                                            @foreach ($intervensiList as $index => $item)
                                                <div
                                                    class="p-2 bg-light rounded d-flex justify-content-between align-items-center">
                                                    <span>{{ $item }}</span>
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger delete-tindakan"
                                                        data-index="{{ $index }}" data-target="risikojatuh">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <input type="hidden" name="intervensi_risiko_jatuh_json"
                                        id="intervensi_risiko_jatuh_json"
                                        value='{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->intervensi_risiko_jatuh ?? '[]' }}'>
                                </div>
                                <!-- Hidden input for lainnya -->
                                <input type="hidden" id="skala_lainnya" name="risiko_jatuh_lainnya"
                                    value="{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->resiko_jatuh_lainnya ?? '' }}">
                            </div>
                        </div>

                        <!-- 8. Risiko dekubitus -->
                        <div class="section-separator" id="decubitus">
                            <h5 class="section-title">8. Risiko dekubitus</h5>
                            <p class="text-muted">Pilih jenis Skala Risiko Dekubitus sesuai kondisi pasien</p>

                            <div class="form-group mb-4">
                                <select class="form-select" id="skalaRisikoDekubitus" name="jenis_skala_dekubitus">
                                    <option value="" disabled
                                        {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->jenis_skala == null ? 'selected' : '' }}>
                                        --Pilih Skala--</option>
                                    <option value="norton"
                                        {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->jenis_skala == 1 ? 'selected' : '' }}>
                                        Skala Norton</option>
                                    <option value="braden"
                                        {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->jenis_skala == 2 ? 'selected' : '' }}>
                                        Skala Braden</option>
                                </select>
                            </div>

                            <!-- Form Skala Norton -->
                            <div id="formNorton" class="decubitus-form" style="display: none;">
                                <h6 class="mb-4">Penilaian Risiko DECUBITUS Skala Norton</h6>

                                <div class="mb-4">
                                    <label class="form-label">Kondisi Fisik</label>
                                    <select class="form-select bg-light" name="kondisi_fisik">
                                        <option value="" disabled
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_fisik == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="4"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_fisik == '4' ? 'selected' : '' }}>
                                            Baik</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_fisik == '3' ? 'selected' : '' }}>
                                            Sedang</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_fisik == '2' ? 'selected' : '' }}>
                                            Buruk</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_fisik == '1' ? 'selected' : '' }}>
                                            Sangat Buruk</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Kondisi mental</label>
                                    <select class="form-select bg-light" name="kondisi_mental">
                                        <option value="" disabled
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_mental == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="4"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_mental == '4' ? 'selected' : '' }}>
                                            Sadar</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_mental == '3' ? 'selected' : '' }}>
                                            Apatis</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_mental == '2' ? 'selected' : '' }}>
                                            Bingung</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_mental == '1' ? 'selected' : '' }}>
                                            Stupor</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Aktivitas</label>
                                    <select class="form-select bg-light" name="norton_aktivitas">
                                        <option value="" disabled
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_aktivitas == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="4"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_aktivitas == '4' ? 'selected' : '' }}>
                                            Aktif</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_aktivitas == '3' ? 'selected' : '' }}>
                                            Jalan dengan bantuan</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_aktivitas == '2' ? 'selected' : '' }}>
                                            Terbatas di kursi</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_aktivitas == '1' ? 'selected' : '' }}>
                                            Terbatas di tempat tidur</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Mobilitas</label>
                                    <select class="form-select bg-light" name="norton_mobilitas">
                                        <option value="" disabled
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_mobilitas == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="4"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_mobilitas == '4' ? 'selected' : '' }}>
                                            Bebas bergerak</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_mobilitas == '3' ? 'selected' : '' }}>
                                            Agak terbatas</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_mobilitas == '2' ? 'selected' : '' }}>
                                            Sangat terbatas</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_mobilitas == '1' ? 'selected' : '' }}>
                                            Tidak dapat bergerak</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Inkontinensia</label>
                                    <select class="form-select bg-light" name="inkontinensia">
                                        <option value="" disabled
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_inkontenesia == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="4"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_inkontenesia == '4' ? 'selected' : '' }}>
                                            Tidak ada</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_inkontenesia == '3' ? 'selected' : '' }}>
                                            Kadang-kadang</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_inkontenesia == '2' ? 'selected' : '' }}>
                                            Biasanya urin</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_inkontenesia == '1' ? 'selected' : '' }}>
                                            Urin dan feses</option>
                                    </select>
                                </div>

                                <div class="mt-4">
                                    <div class="d-flex gap-2">
                                        <span class="fw-bold">Kesimpulan :</span>
                                        <div id="kesimpulanNorton"
                                            class="alert {{ strpos($asesmen->rmeAsesmenKepAnakResikoDekubitus->decubitus_kesimpulan ?? '', 'Tinggi') !== false ? 'alert-danger' : (strpos($asesmen->rmeAsesmenKepAnakResikoDekubitus->decubitus_kesimpulan ?? '', 'Sedang') !== false ? 'alert-warning' : 'alert-success') }} mb-0 flex-grow-1">
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->decubitus_kesimpulan ?? 'Risiko Rendah' }}
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
                                        <option value="" disabled
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_persepsi == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_persepsi == '1' ? 'selected' : '' }}>
                                            Keterbatasan Penuh</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_persepsi == '2' ? 'selected' : '' }}>
                                            Sangat Terbatas</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_persepsi == '3' ? 'selected' : '' }}>
                                            Keterbatasan Ringan</option>
                                        <option value="4"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_persepsi == '4' ? 'selected' : '' }}>
                                            Tidak Ada Gangguan</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Kelembapan</label>
                                    <select class="form-select bg-light" name="kelembapan">
                                        <option value="" disabled
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_kelembapan == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_kelembapan == '1' ? 'selected' : '' }}>
                                            Selalu Lembap</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_kelembapan == '2' ? 'selected' : '' }}>
                                            Umumnya Lembap</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_kelembapan == '3' ? 'selected' : '' }}>
                                            Kadang-Kadang Lembap</option>
                                        <option value="4"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_kelembapan == '4' ? 'selected' : '' }}>
                                            Jarang Lembap</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Aktivitas</label>
                                    <select class="form-select bg-light" name="braden_aktivitas">
                                        <option value="" disabled
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_aktivitas == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_aktivitas == '1' ? 'selected' : '' }}>
                                            Total di Tempat Tidur</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_aktivitas == '2' ? 'selected' : '' }}>
                                            Dapat Duduk</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_aktivitas == '3' ? 'selected' : '' }}>
                                            Berjalan Kadang-kadang</option>
                                        <option value="4"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_aktivitas == '4' ? 'selected' : '' }}>
                                            Dapat Berjalan-jalan</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Mobilitas</label>
                                    <select class="form-select bg-light" name="braden_mobilitas">
                                        <option value="" disabled
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_mobilitas == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_mobilitas == '1' ? 'selected' : '' }}>
                                            Tidak Mampu Bergerak Sama sekali</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_mobilitas == '2' ? 'selected' : '' }}>
                                            Sangat Terbatas</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_mobilitas == '3' ? 'selected' : '' }}>
                                            Tidak Ada Masalah</option>
                                        <option value="4"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_mobilitas == '4' ? 'selected' : '' }}>
                                            Tanpa Keterbatasan</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Nutrisi</label>
                                    <select class="form-select bg-light" name="nutrisi">
                                        <option value="" disabled
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_nutrisi == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_nutrisi == '1' ? 'selected' : '' }}>
                                            Sangat Buruk</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_nutrisi == '2' ? 'selected' : '' }}>
                                            Kurang Menucukup</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_nutrisi == '3' ? 'selected' : '' }}>
                                            Mencukupi</option>
                                        <option value="4"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_nutrisi == '4' ? 'selected' : '' }}>
                                            Sangat Baik</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Pergesekan dan Pergeseran</label>
                                    <select class="form-select bg-light" name="pergesekan">
                                        <option value="" disabled
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_pergesekan == null ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_pergesekan == '1' ? 'selected' : '' }}>
                                            Bermasalah</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_pergesekan == '2' ? 'selected' : '' }}>
                                            Potensial Bermasalah</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_pergesekan == '3' ? 'selected' : '' }}>
                                            Keterbatasan Ringan</option>
                                    </select>
                                </div>

                                <div class="mt-4">
                                    <div class="d-flex gap-2">
                                        <span class="fw-bold">Kesimpulan :</span>
                                        <div id="kesimpulanBraden"
                                            class="alert {{ strpos($asesmen->rmeAsesmenKepAnakResikoDekubitus->decubitus_kesimpulan ?? '', 'Tinggi') !== false ? 'alert-danger' : (strpos($asesmen->rmeAsesmenKepAnakResikoDekubitus->decubitus_kesimpulan ?? '', 'Sedang') !== false ? 'alert-warning' : 'alert-success') }} mb-0 flex-grow-1">
                                            {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->decubitus_kesimpulan ?? 'Kesimpulan Skala Braden' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 9. Status Psikologis -->
                        <div class="section-separator" id="statusPsikologis">
                            <h5 class="section-title">9. Status Psikologis</h5>

                            <div class="mb-4">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <label>Kondisi Psikologis</label>
                                    <div class="dropdown-wrapper" style="position: relative;">
                                        <button type="button" class="btn btn-sm btn-primary"
                                            id="btnKondisiPsikologis">
                                            <i class="ti-plus"></i>
                                        </button>
                                        <div class="dropdown-menu" id="dropdownKondisiPsikologis"
                                            style="display: none; position: absolute; z-index: 1000;">
                                            <div class="p-2">
                                                <div class="fw-bold mb-2">STATUS PSIKOLOGIS PASIEN</div>
                                                <div class="kondisi-options">
                                                    @php
                                                        $kondisiPsikologis = json_decode(
                                                            $asesmen->rmeAsesmenKepAnakStatusPsikologis
                                                                ->kondisi_psikologis ?? '[]',
                                                            true,
                                                        );
                                                    @endphp
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="Tidak ada kelainan" id="kondisi1"
                                                            {{ in_array('Tidak ada kelainan', $kondisiPsikologis) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="kondisi1">Tidak ada
                                                            kelainan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="Cemas" id="kondisi2"
                                                            {{ in_array('Cemas', $kondisiPsikologis) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="kondisi2">Cemas</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="Takut" id="kondisi3"
                                                            {{ in_array('Takut', $kondisiPsikologis) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="kondisi3">Takut</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="Marah" id="kondisi4"
                                                            {{ in_array('Marah', $kondisiPsikologis) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="kondisi4">Marah</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="Sedih" id="kondisi5"
                                                            {{ in_array('Sedih', $kondisiPsikologis) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="kondisi5">Sedih</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="Tenang" id="kondisi6"
                                                            {{ in_array('Tenang', $kondisiPsikologis) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="kondisi6">Tenang</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="Tidak semangat" id="kondisi7"
                                                            {{ in_array('Tidak semangat', $kondisiPsikologis) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="kondisi7">Tidak
                                                            semangat</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="Tertekan" id="kondisi8"
                                                            {{ in_array('Tertekan', $kondisiPsikologis) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="kondisi8">Tertekan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="Depresi" id="kondisi9"
                                                            {{ in_array('Depresi', $kondisiPsikologis) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="kondisi9">Depresi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="Sulit tidur" id="kondisi10"
                                                            {{ in_array('Sulit tidur', $kondisiPsikologis) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="kondisi10">Sulit
                                                            tidur</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="selectedKondisiPsikologis" class="d-flex gap-2 flex-wrap">
                                        <!-- Selected items will be displayed here as badges -->
                                    </div>
                                </div>
                                <input type="hidden" name="kondisi_psikologis_json" id="kondisi_psikologis_json"
                                    value='{{ $asesmen->rmeAsesmenKepAnakStatusPsikologis->kondisi_psikologis ?? '[]' }}'>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-start gap-2 mb-2">
                                    <label>Gangguan Perilaku</label>
                                    <div class="dropdown-wrapper" style="position: relative;">
                                        <button type="button" class="btn btn-sm btn-primary"
                                            id="btnGangguanPerilaku">
                                            <i class="ti-plus"></i>
                                        </button>

                                        <!-- Dropdown Menu -->
                                        <div class="dropdown-menu p-2 shadow-sm" id="dropdownGangguanPerilaku"
                                            style="display: none; position: absolute; z-index: 1000; min-width: 250px; background: white; border: 1px solid rgba(0,0,0,.15); border-radius: 4px;">
                                            <div class="fw-bold mb-2">GANGGUAN PERILAKU</div>
                                            <div class="perilaku-options">
                                                @php
                                                    $gangguanPerilaku = json_decode(
                                                        $asesmen->rmeAsesmenKepAnakStatusPsikologis
                                                            ->gangguan_perilaku ?? '[]',
                                                        true,
                                                    );
                                                @endphp
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="Tidak Ada Gangguan" id="perilaku1"
                                                        {{ in_array('Tidak Ada Gangguan', $gangguanPerilaku) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="perilaku1">Tidak Ada
                                                        Gangguan</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="Perilaku Kekerasan" id="perilaku2"
                                                        {{ in_array('Perilaku Kekerasan', $gangguanPerilaku) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="perilaku2">Perilaku
                                                        Kekerasan</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="Halusinasi" id="perilaku3"
                                                        {{ in_array('Halusinasi', $gangguanPerilaku) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="perilaku3">Halusinasi</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="selectedGangguanPerilaku"
                                        class="d-flex gap-2 flex-wrap align-items-center">
                                        <!-- Selected items will be displayed here as badges -->
                                    </div>
                                </div>
                                <input type="hidden" name="gangguan_perilaku_json" id="gangguan_perilaku_json"
                                    value='{{ $asesmen->rmeAsesmenKepAnakStatusPsikologis->gangguan_perilaku ?? '[]' }}'>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Potensi menyakiti diri sendiri/orang lain</label>
                                <select class="form-select" name="potensi_menyakiti">
                                    <option value="" disabled>pilih</option>
                                    <option value="0"
                                        {{ $asesmen->rmeAsesmenKepAnakStatusPsikologis->potensi_menyakiti == 0 ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="1"
                                        {{ $asesmen->rmeAsesmenKepAnakStatusPsikologis->potensi_menyakiti == 1 ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Anggota Keluarga Gangguan Jiwa</label>
                                <select class="form-select" name="anggota_keluarga_gangguan_jiwa">
                                    <option value="" disabled
                                        {{ $asesmen->rmeAsesmenKepAnakStatusPsikologis->anggota_keluarga_gangguan_jiwa == null ? 'selected' : '' }}>
                                        --Pilih--</option>
                                    <option value="0"
                                        {{ $asesmen->rmeAsesmenKepAnakStatusPsikologis->keluarga_gangguan_jiwa == 0 ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="1"
                                        {{ $asesmen->rmeAsesmenKepAnakStatusPsikologis->keluarga_gangguan_jiwa == 1 ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Lainnya</label>
                                <input type="text" class="form-control" name="psikologis_lainnya"
                                    value="{{ $asesmen->rmeAsesmenKepAnakStatusPsikologis->lainnya }}">
                            </div>
                        </div>

                        <!-- 10. Statsu Spiritual -->
                        <div class="section-separator" id="status_spiritual">
                            <h5 class="section-title">10. Status Spiritual</h5>
                            <div class="form-group">
                                <label style="min-width: 200px;">Keyakinan Agama</label>
                                <select class="form-select" name="keyakinan_agama">
                                    <option value="" disabled
                                        {{ $asesmen->rmeAsesmenKepAnak->keyakinan_agama == null ? 'selected' : '' }}>
                                        --Pilih--</option>
                                    <option value="Islam"
                                        {{ $asesmen->rmeAsesmenKepAnak->agama == 'Islam' ? 'selected' : '' }}>Islam
                                    </option>
                                    <option value="Protestan"
                                        {{ $asesmen->rmeAsesmenKepAnak->agama == 'Protestan' ? 'selected' : '' }}>
                                        Protestan</option>
                                    <option value="Khatolik"
                                        {{ $asesmen->rmeAsesmenKepAnak->agama == 'Khatolik' ? 'selected' : '' }}>
                                        Khatolik</option>
                                    <option value="Budha"
                                        {{ $asesmen->rmeAsesmenKepAnak->agama == 'Budha' ? 'selected' : '' }}>Budha
                                    </option>
                                    <option value="Hindu"
                                        {{ $asesmen->rmeAsesmenKepAnak->agama == 'Hindu' ? 'selected' : '' }}>Hindu
                                    </option>
                                    <option value="Konghucu"
                                        {{ $asesmen->rmeAsesmenKepAnak->agama == 'Konghucu' ? 'selected' : '' }}>
                                        Konghucu</option>
                                    <option value="Lainnya"
                                        {{ $asesmen->rmeAsesmenKepAnak->agama == 'Lainnya' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="min-width: 200px;">Pandangan Pasien Terhadap Penyakit Nya</label>
                                <select class="form-select" name="pandangan_terhadap_penyakit">
                                    <option value="" disabled
                                        {{ $asesmen->rmeAsesmenKepAnak->pandangan_terhadap_penyakit == null ? 'selected' : '' }}>
                                        --Pilih--</option>
                                    <option value="Takdir"
                                        {{ $asesmen->rmeAsesmenKepAnak->pandangan_terhadap_penyakit == 'Takdir' ? 'selected' : '' }}>
                                        Takdir</option>
                                    <option value="Hukuman"
                                        {{ $asesmen->rmeAsesmenKepAnak->pandangan_terhadap_penyakit == 'Hukuman' ? 'selected' : '' }}>
                                        Hukuman</option>
                                    <option value="Tidak Ada"
                                        {{ $asesmen->rmeAsesmenKepAnak->pandangan_terhadap_penyakit == 'Tidak Ada' ? 'selected' : '' }}>
                                        Tidak Ada</option>
                                    <option value="Lainnya"
                                        {{ $asesmen->rmeAsesmenKepAnak->pandangan_terhadap_penyakit == 'Lainnya' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <!-- 11. Statsu Ekonomi -->
                        <div class="section-separator" id="status_sosial_ekonomi">
                            <h5 class="section-title">11. Status Sosial Ekonomi</h5>

                            <div class="form-group">
                                <label style="min-width: 200px;">Pekerjaan</label>
                                <select class="form-select" name="pekerjaan_pasien">
                                    <option value=""
                                        {{ !$asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_pekerjaan ? 'selected' : '' }}>
                                        --Pilih--</option>
                                    <option value="Belum Bekerja"
                                        {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_pekerjaan == 'Belum Bekerja' ? 'selected' : '' }}>
                                        Belum Bekerja</option>
                                    <option value="Purnawaktu"
                                        {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_pekerjaan == 'Purnawaktu' ? 'selected' : '' }}>
                                        Purnawaktu</option>
                                    <option value="Paruh Waktu"
                                        {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_pekerjaan == 'Paruh Waktu' ? 'selected' : '' }}>
                                        Paruh Waktu</option>
                                    <option value="Pensiunan"
                                        {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_pekerjaan == 'Pensiunan' ? 'selected' : '' }}>
                                        Pensiunan</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Status Pernikahan</label>
                                <div class="d-flex gap-3" style="width: 100%;">
                                    <select class="form-select flex-grow-1" name="status_pernikahan">
                                        <option value=""
                                            {{ !$asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_status_pernikahan ? 'selected' : '' }}>
                                            --Pilih--</option>
                                        <option value="Menikah"
                                            {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_status_pernikahan == 'Menikah' ? 'selected' : '' }}>
                                            Menikah</option>
                                        <option value="Belum Menikah"
                                            {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_status_pernikahan == 'Belum Menikah' ? 'selected' : '' }}>
                                            Belum Menikah</option>
                                        <option value="Cerai"
                                            {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_status_pernikahan == 'Cerai' ? 'selected' : '' }}>
                                            Cerai</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Tempat Tinggal</label>
                                <select class="form-select" name="tempat_tinggal">
                                    <option value=""
                                        {{ !$asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_tempat_tinggal ? 'selected' : '' }}>
                                        --Pilih--</option>
                                    <option value="Rumah"
                                        {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_tempat_tinggal == 'Rumah' ? 'selected' : '' }}>
                                        Rumah</option>
                                    <option value="Asrama"
                                        {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_tempat_tinggal == 'Asrama' ? 'selected' : '' }}>
                                        Asrama</option>
                                    <option value="Lainnya"
                                        {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_tempat_tinggal == 'Lainnya' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Curiga Penganiayaan</label>
                                <select class="form-select" name="curiga_penganiayaan">
                                    <option value=""
                                        {{ !$asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_curiga_penganiayaan ? 'selected' : '' }}>
                                        --Pilih--</option>
                                    <option value="Ya"
                                        {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_curiga_penganiayaan == 'Ya' ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="Tidak"
                                        {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_curiga_penganiayaan == 'Tidak' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Status Tinggal Dengan Keluarga</label>
                                <select class="form-select" name="status_tinggal">
                                    <option value=""
                                        {{ !$asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_tinggal_dengan_keluarga ? 'selected' : '' }}>
                                        --Pilih--</option>
                                    <option value="Orang Tua"
                                        {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_tinggal_dengan_keluarga == 'Orang Tua' ? 'selected' : '' }}>
                                        Orang Tua</option>
                                    <option value="Wali"
                                        {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_tinggal_dengan_keluarga == 'Wali' ? 'selected' : '' }}>
                                        Wali</option>
                                    <option value="Lainnya"
                                        {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_tinggal_dengan_keluarga == 'Lainnya' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <!-- 12. Status Gizi -->
                        <div class="section-separator" id="status_gizi">
                            <h5 class="section-title">12. Status Gizi</h5>
                            <div class="form-group mb-4">
                                <select class="form-select" name="gizi_jenis" id="nutritionAssessment">
                                    <option value="">--Pilih--</option>
                                    <option value="1"
                                        {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_jenis == 1 ? 'selected' : '' }}>
                                        Malnutrition Screening Tool (MST)</option>
                                    <option value="2"
                                        {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_jenis == 2 ? 'selected' : '' }}>The
                                        Mini Nutritional Assessment (MNA)</option>
                                    <option value="3"
                                        {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_jenis == 3 ? 'selected' : '' }}>
                                        Strong Kids (1 bln - 18 Tahun)</option>
                                    <option value="5"
                                        {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_jenis == 5 ? 'selected' : '' }}>Tidak
                                        Dapat Dinilai</option>
                                </select>
                            </div>

                            <!-- MST Form -->
                            <div id="mst" class="assessment-form" style="display: none;">
                                <h6 class="mb-3">Penilaian Gizi Malnutrition Screening Tool (MST)</h6>
                                <div class="mb-3">
                                    <label class="form-label">Apakah pasien mengalami penurunan BB yang tidak
                                        diinginkan dalam 6 bulan terakhir?</label>
                                    <select class="form-select" name="gizi_mst_penurunan_bb">
                                        <option value="">pilih</option>
                                        <option value="0"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_penurunan_bb == '0' ? 'selected' : '' }}>
                                            Tidak ada penurunan Berat Badan (BB)</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_penurunan_bb == '2' ? 'selected' : '' }}>
                                            Tidak yakin/ tidak tahu/ terasa baju lebi longgar</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_penurunan_bb == '3' ? 'selected' : '' }}>
                                            Ya ada penurunan BB</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jika jawaban di atas "Ya ada penurunan BB", berapa
                                        penurunan BB tersebut?</label>
                                    <select class="form-select" name="gizi_mst_jumlah_penurunan_bb">
                                        <option value="0">pilih</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_jumlah_penurunan_bb == '1' ? 'selected' : '' }}>
                                            1-5 kg</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_jumlah_penurunan_bb == '2' ? 'selected' : '' }}>
                                            6-10 kg</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_jumlah_penurunan_bb == '3' ? 'selected' : '' }}>
                                            11-15 kg</option>
                                        <option value="4"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_jumlah_penurunan_bb == '4' ? 'selected' : '' }}>
                                            >15 kg</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Apakah asupan makan berkurang karena tidak nafsu
                                        makan?</label>
                                    <select class="form-select" name="gizi_mst_nafsu_makan_berkurang">
                                        <option value="">pilih</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_nafsu_makan_berkurang == '1' ? 'selected' : '' }}>
                                            Ya</option>
                                        <option value="0"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_nafsu_makan_berkurang == '0' ? 'selected' : '' }}>
                                            Tidak</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pasien didiagnosa khusus seperti: DM, Cancer
                                        (kemoterapi), Geriatri, GGk (hemodialisis), Penurunan Imun</label>
                                    <select class="form-select" name="gizi_mst_diagnosis_khusus">
                                        <option value="">pilih</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_diagnosis_khusus == '1' ? 'selected' : '' }}>
                                            Ya</option>
                                        <option value="0"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_diagnosis_khusus == '0' ? 'selected' : '' }}>
                                            Tidak</option>
                                    </select>
                                </div>
                                <!-- Nilai -->
                                <div id="mstConclusion" class="risk-indicators mt-4">
                                    <div class="alert alert-success">Kesimpulan: 0-1 tidak berisiko malnutrisi</div>
                                    <div class="alert alert-warning">Kesimpulan: ≥ 2 berisiko malnutrisi</div>
                                    <input type="hidden" name="gizi_mst_kesimpulan" id="gizi_mst_kesimpulan"
                                        value="{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_kesimpulan }}">
                                </div>
                            </div>

                            <!-- MNA Form -->
                            <div id="mna" class="assessment-form" style="display: none;">
                                <h6 class="mb-3">Penilaian Gizi The Mini Nutritional Assessment (MNA) / Lansia</h6>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Apakah pasien mengalami penurunan asupan makanan selama 3 bulan terakhir karena
                                        hilang selera makan, masalah pencernaan, kesulitan mengunyah atau menelan?
                                    </label>
                                    <select class="form-select" name="gizi_mna_penurunan_asupan_3_bulan">
                                        <option value="">--Pilih--</option>
                                        <option value="0"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_penurunan_asupan_3_bulan == '0' ? 'selected' : '' }}>
                                            Mengalami penurunan asupan makanan yang parah</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_penurunan_asupan_3_bulan == '1' ? 'selected' : '' }}>
                                            Mengalami penurunan asupan makanan sedang</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_penurunan_asupan_3_bulan == '2' ? 'selected' : '' }}>
                                            Tidak mengalami penurunan asupan makanan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Apakah pasien mengalami kehilangan Berat Badan (BB) selama 3 bulan terakhir?
                                    </label>
                                    <select class="form-select" name="gizi_mna_kehilangan_bb_3_bulan">
                                        <option value="">-- Pilih --</option>
                                        <option value="0"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_kehilangan_bb_3_bulan == '0' ? 'selected' : '' }}>
                                            Kehilangan BB lebih dari 3 Kg</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_kehilangan_bb_3_bulan == '1' ? 'selected' : '' }}>
                                            Tidak tahu</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_kehilangan_bb_3_bulan == '2' ? 'selected' : '' }}>
                                            Kehilangan BB antara 1 s.d 3 Kg</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_kehilangan_bb_3_bulan == '3' ? 'selected' : '' }}>
                                            Tidak ada kehilangan BB</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Bagaimana mobilisasi atau pergerakan pasien?</label>
                                    <select class="form-select" name="gizi_mna_mobilisasi">
                                        <option value="">-- Pilih --</option>
                                        <option value="0"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_mobilisasi == '0' ? 'selected' : '' }}>
                                            Hanya di tempat tidur atau kursi roda</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_mobilisasi == '1' ? 'selected' : '' }}>
                                            Dapat turun dari tempat tidur tapi tidak dapat jalan-jalan</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_mobilisasi == '2' ? 'selected' : '' }}>
                                            Dapat jalan-jalan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Apakah Pasien mengalami stres psikologi atau penyakit akut selama 3 bulan
                                        terakhir?
                                    </label>
                                    <select class="form-select" name="gizi_mna_stress_penyakit_akut">
                                        <option value="">-- Pilih --</option>
                                        <option value="0"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_stress_penyakit_akut == '0' ? 'selected' : '' }}>
                                            Ya</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_stress_penyakit_akut == '1' ? 'selected' : '' }}>
                                            Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Apakah pasien mengalami masalah neuropsikologi?</label>
                                    <select class="form-select" name="gizi_mna_status_neuropsikologi">
                                        <option value="">-- Pilih --</option>
                                        <option value="0"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_status_neuropsikologi == '0' ? 'selected' : '' }}>
                                            Demensia atau depresi berat</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_status_neuropsikologi == '1' ? 'selected' : '' }}>
                                            Demensia ringan</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_status_neuropsikologi == '2' ? 'selected' : '' }}>
                                            Tidak mengalami masalah neuropsikologi</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Berapa Berat Badan (BB) pasien? (Kg)</label>
                                    <input type="number" name="gizi_mna_berat_badan" class="form-control"
                                        id="mnaWeight" min="1" step="0.1"
                                        placeholder="Masukkan berat badan dalam Kg"
                                        value="{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_berat_badan }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Berapa Tinggi Badan (TB) pasien? (cm)</label>
                                    <input type="number" name="gizi_mna_tinggi_badan" class="form-control"
                                        id="mnaHeight" min="1" step="0.1"
                                        placeholder="Masukkan tinggi badan dalam cm"
                                        value="{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_tinggi_badan }}">
                                </div>

                                <!-- IMT -->
                                <div class="mb-3">
                                    <label class="form-label">Indeks Massa Tubuh (IMT)</label>
                                    <div class="text-muted small mb-2">
                                        <i>Rumus IMT = BB (Kg) / (TB (m))²</i>
                                    </div>
                                    <input type="number" name="gizi_mna_imt" class="form-control bg-light"
                                        id="mnaBMI" readonly placeholder="IMT akan terhitung otomatis"
                                        value="{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_imt }}">
                                </div>

                                <!-- Kesimpulan -->
                                <div id="mnaConclusion" class="risk-indicators mt-4">
                                    <div class="alert alert-info mb-3"
                                        style="{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_kesimpulan ? 'display: none;' : '' }}">
                                        Silakan isi semua parameter di atas untuk melihat kesimpulan
                                    </div>
                                    <div class="alert alert-success"
                                        style="{{ strpos($asesmen->rmeAsesmenKepAnakGizi->gizi_mna_kesimpulan ?? '', 'Tidak Beresiko') !== false ? '' : 'display: none;' }}">
                                        Kesimpulan: Total Skor ≥ 12 (Tidak Beresiko Malnutrisi)
                                    </div>
                                    <div class="alert alert-warning"
                                        style="{{ strpos($asesmen->rmeAsesmenKepAnakGizi->gizi_mna_kesimpulan ?? '', 'Beresiko') !== false ? '' : 'display: none;' }}">
                                        Kesimpulan: Total Skor ≤ 11 (Beresiko Malnutrisi)
                                    </div>
                                    <input type="hidden" name="gizi_mna_kesimpulan" id="gizi_mna_kesimpulan"
                                        value="{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_kesimpulan }}">
                                </div>
                            </div>

                            <!-- Strong Kids Form -->
                            <div id="strong-kids" class="assessment-form" style="display: none;">
                                <h6 class="mb-3">Penilaian Gizi Strong Kids</h6>
                                <div class="mb-3">
                                    <label class="form-label">Apakah anak tampa kurus kehilangan lemak subkutan,
                                        kehilangan massa otot, dan/ atau wajah cekung?</label>
                                    <select class="form-select" name="gizi_strong_status_kurus">
                                        <option value="">pilih</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_status_kurus == '1' ? 'selected' : '' }}>
                                            Ya</option>
                                        <option value="0"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_status_kurus == '0' ? 'selected' : '' }}>
                                            Tidak</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Apakah terdapat penurunan BB selama satu bulan terakhir
                                        (untuk semua usia)?
                                        (berdasarkan penilaian objektif data BB bila ada/penilaian subjektif dari orang
                                        tua pasien ATAU tidak ada peningkatan berat badan atau tinggi badan (pada bayi <
                                            1 tahun) selama 3 bulan terakhir)</label>
                                            <select class="form-select" name="gizi_strong_penurunan_bb">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_penurunan_bb == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_penurunan_bb == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Apakah salah satu dari hal berikut ini ada? <br>
                                        - Diare berlabihan (>= 5 kali perhari) dan/atau muntah(>3 klai perhari) selama
                                        1-3 hari terakhir
                                        - Penurunan asupan makanan selama 1-3 hari terakhir
                                        - Intervensi gizi yang sudah ada sebelumnya (misalnya, ONS atau pemberian maka
                                        selang)</label>
                                    <select class="form-select" name="gizi_strong_gangguan_pencernaan">
                                        <option value="">pilih</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_gangguan_pencernaan == '1' ? 'selected' : '' }}>
                                            Ya</option>
                                        <option value="0"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_gangguan_pencernaan == '0' ? 'selected' : '' }}>
                                            Tidak</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Apakah terdapat penyakit atau keadaan yang mengakibatkan
                                        pasien berisiko mengalaman mainutrisi? <br>
                                        <a href="#"><i>Lihat penyakit yang berisiko malnutrisi</i></a></label>
                                    <select class="form-select" name="gizi_strong_penyakit_berisiko">
                                        <option value="">pilih</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_penyakit_berisiko == '2' ? 'selected' : '' }}>
                                            Ya</option>
                                        <option value="0"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_penyakit_berisiko == '0' ? 'selected' : '' }}>
                                            Tidak</option>
                                    </select>
                                </div>
                                <!-- Nilai -->
                                <div id="strongKidsConclusion" class="risk-indicators mt-4">
                                    <div class="alert alert-success"
                                        style="{{ strpos($asesmen->rmeAsesmenKepAnakGizi->gizi_strong_kesimpulan ?? '', 'rendah') !== false ? '' : 'display: none;' }}">
                                        Kesimpulan: 0 (Beresiko rendah)</div>
                                    <div class="alert alert-warning"
                                        style="{{ strpos($asesmen->rmeAsesmenKepAnakGizi->gizi_strong_kesimpulan ?? '', 'sedang') !== false ? '' : 'display: none;' }}">
                                        Kesimpulan: 1-3 (Beresiko sedang)</div>
                                    <div class="alert alert-danger"
                                        style="{{ strpos($asesmen->rmeAsesmenKepAnakGizi->gizi_strong_kesimpulan ?? '', 'Tinggi') !== false ? '' : 'display: none;' }}">
                                        Kesimpulan: 4-5 (Beresiko Tinggi)</div>
                                    <input type="hidden" name="gizi_strong_kesimpulan"
                                        id="gizi_strong_kesimpulan"
                                        value="{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_kesimpulan }}">
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
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_nrs_jatuh_saat_masuk_rs == '2' ? 'selected' : '' }}>
                                            Ya</option>
                                        <option value="0"
                                            {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_nrs_jatuh_saat_masuk_rs == '0' ? 'selected' : '' }}>
                                            Tidak</option>
                                    </select>
                                </div>

                                <!-- Add more NRS form fields here -->

                                <!-- Nilai -->
                                <div id="nrsConclusion" class="risk-indicators mt-4">
                                    <div class="alert alert-success"
                                        style="{{ strpos($asesmen->rmeAsesmenKepAnakGizi->gizi_nrs_kesimpulan ?? '', 'rendah') !== false ? '' : 'display: none;' }}">
                                        Kesimpulan: Beresiko rendah</div>
                                    <div class="alert alert-warning"
                                        style="{{ strpos($asesmen->rmeAsesmenKepAnakGizi->gizi_nrs_kesimpulan ?? '', 'sedang') !== false ? '' : 'display: none;' }}">
                                        Kesimpulan: Beresiko sedang</div>
                                    <div class="alert alert-danger"
                                        style="{{ strpos($asesmen->rmeAsesmenKepAnakGizi->gizi_nrs_kesimpulan ?? '', 'Tinggi') !== false ? '' : 'display: none;' }}">
                                        Kesimpulan: Beresiko Tinggi</div>
                                    <input type="hidden" name="gizi_nrs_kesimpulan" id="gizi_nrs_kesimpulan"
                                        value="{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_nrs_kesimpulan }}">
                                </div>
                            </div>
                        </div>

                        <!-- 13. Status Fungsional -->
                        <div class="section-separator" id="status-fungsional">
                            <h5 class="section-title">13. Status Fungsional</h5>

                            <div class="mb-4">
                                <label class="form-label">Pilih jenis Skala Pengkajian Aktivitas Harian (ADL) sesuai
                                    kondisi pasien</label>
                                <select class="form-select" name="skala_fungsional" id="skala_fungsional">
                                    <option value="" disabled>Pilih Skala Fungsional</option>
                                    <option value="Pengkajian Aktivitas"
                                        {{ $asesmen->rmeAsesmenKepAnakStatusFungsional?->jenis_skala == 1 ? 'selected' : '' }}>
                                        Pengkajian Aktivitas Harian
                                    </option>
                                    <option value="Lainnya"
                                        {{ $asesmen->rmeAsesmenKepAnakStatusFungsional?->jenis_skala == 2 ? 'selected' : '' }}>
                                        Lainnya
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Nilai Skala ADL</label>
                                <input type="text" class="form-control" id="adl_total" name="adl_total"
                                    readonly
                                    value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional?->nilai_skala_adl ?? '' }}">
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Kesimpulan Fungsional</label>
                                <div id="adl_kesimpulan"
                                    class="alert {{ $asesmen->rmeAsesmenKepAnakStatusFungsional?->kesimpulan_fungsional
                                        ? (strpos($asesmen->rmeAsesmenKepAnakStatusFungsional?->kesimpulan_fungsional, 'Ketergantungan Total') !== false
                                            ? 'alert-danger'
                                            : (strpos($asesmen->rmeAsesmenKepAnakStatusFungsional?->kesimpulan_fungsional, 'Ketergantungan Berat') !== false
                                                ? 'alert-warning'
                                                : (strpos($asesmen->rmeAsesmenKepAnakStatusFungsional?->kesimpulan_fungsional, 'Ketergantungan Sedang') !==
                                                false
                                                    ? 'alert-info'
                                                    : 'alert-success')))
                                        : 'alert-info' }}">
                                    {{ $asesmen->rmeAsesmenKepAnakStatusFungsional?->kesimpulan_fungsional ?? 'Pilih skala aktivitas harian terlebih dahulu' }}
                                </div>
                            </div>

                            <!-- Hidden fields untuk menyimpan data ADL -->
                            <input type="hidden" id="adl_jenis_skala" name="adl_jenis_skala"
                                value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional?->jenis_skala ?? '' }}">
                            <input type="hidden" id="adl_makan" name="adl_makan"
                                value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional?->makan ?? '' }}">
                            <input type="hidden" id="adl_makan_value" name="adl_makan_value"
                                value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional?->makan_value ?? '' }}">
                            <input type="hidden" id="adl_berjalan" name="adl_berjalan"
                                value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional?->berjalan ?? '' }}">
                            <input type="hidden" id="adl_berjalan_value" name="adl_berjalan_value"
                                value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional?->berjalan_value ?? '' }}">
                            <input type="hidden" id="adl_mandi" name="adl_mandi"
                                value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional?->mandi ?? '' }}">
                            <input type="hidden" id="adl_mandi_value" name="adl_mandi_value"
                                value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional?->mandi_value ?? '' }}">
                            <input type="hidden" id="adl_kesimpulan_value" name="adl_kesimpulan_value"
                                value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional?->kesimpulan_fungsional ?? '' }}">
                        </div>

                        <!-- 14. Kebutuhan Edukasi -->
                        <div class="section-separator" id="kebutuhan-edukasi">
                            <h5 class="section-title">14. Status Kebutuhan Edukasi, Pendidikan dan Pengajaran</h5>

                            <div class="form-group">
                                <label style="min-width: 200px;">Gaya Bicara</label>
                                <select class="form-select" name="gaya_bicara">
                                    <option value="" disabled
                                        {{ !$asesmen->rmeAsesmenKepAnak || !$asesmen->rmeAsesmenKepAnak->gaya_bicara ? 'selected' : '' }}>
                                        --Pilih--</option>
                                    <option value="normal"
                                        {{ $asesmen->rmeAsesmenKepAnak->gaya_bicara == 'normal' ? 'selected' : '' }}>
                                        Normal</option>
                                    <option value="lambat"
                                        {{ $asesmen->rmeAsesmenKepAnak->gaya_bicara == 'lambat' ? 'selected' : '' }}>
                                        Lambat</option>
                                    <option value="cepat"
                                        {{ $asesmen->rmeAsesmenKepAnak->gaya_bicara == 'cepat' ? 'selected' : '' }}>
                                        Cepat</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Bahasa Sehari-Hari</label>
                                <select class="form-select" name="bahasa_sehari_hari">
                                    <option value="" disabled
                                        {{ !$asesmen->rmeAsesmenKepAnak || !$asesmen->rmeAsesmenKepAnak->bahasa ? 'selected' : '' }}>
                                        --Pilih--</option>
                                    <option value="Bahasa Indonesia"
                                        {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Bahasa Indonesia' ? 'selected' : '' }}>
                                        Bahasa Indonesia</option>
                                    <option value="Aceh"
                                        {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Aceh' ? 'selected' : '' }}>Aceh
                                    </option>
                                    <option value="Batak"
                                        {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Batak' ? 'selected' : '' }}>Batak
                                    </option>
                                    <option value="Minangkabau"
                                        {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Minangkabau' ? 'selected' : '' }}>
                                        Minangkabau</option>
                                    <option value="Melayu"
                                        {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Melayu' ? 'selected' : '' }}>Melayu
                                    </option>
                                    <option value="Sunda"
                                        {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Sunda' ? 'selected' : '' }}>Sunda
                                    </option>
                                    <option value="Jawa"
                                        {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Jawa' ? 'selected' : '' }}>Jawa
                                    </option>
                                    <option value="Madura"
                                        {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Madura' ? 'selected' : '' }}>Madura
                                    </option>
                                    <option value="Bali"
                                        {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Bali' ? 'selected' : '' }}>Bali
                                    </option>
                                    <option value="Sasak"
                                        {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Sasak' ? 'selected' : '' }}>Sasak
                                    </option>
                                    <option value="Banjar"
                                        {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Banjar' ? 'selected' : '' }}>Banjar
                                    </option>
                                    <option value="Bugis"
                                        {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Bugis' ? 'selected' : '' }}>Bugis
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Perlu Penerjemah</label>
                                <select class="form-select" name="perlu_penerjemah">
                                    <option value="" disabled
                                        {{ !$asesmen->rmeAsesmenKepAnak || !$asesmen->rmeAsesmenKepAnak->perlu_penerjemahan ? 'selected' : '' }}>
                                        --Pilih--</option>
                                    <option value="ya"
                                        {{ $asesmen->rmeAsesmenKepAnak->perlu_penerjemahan == 'ya' ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="tidak"
                                        {{ $asesmen->rmeAsesmenKepAnak->perlu_penerjemahan == 'tidak' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Hambatan Komunikasi</label>
                                <select class="form-select" name="hambatan_komunikasi">
                                    <option value="" disabled>--Pilih--</option>
                                    <option value="tidak_ada"
                                        {{ $asesmen->rmeAsesmenKepAnak->hambatan_komunikasi == 'tidak_ada' ? 'selected' : '' }}>
                                        Tidak Ada</option>
                                    <option value="pendengaran"
                                        {{ $asesmen->rmeAsesmenKepAnak->hambatan_komunikasi == 'pendengaran' ? 'selected' : '' }}>
                                        Gangguan Pendengaran</option>
                                    <option value="bicara"
                                        {{ $asesmen->rmeAsesmenKepAnak->hambatan_komunikasi == 'bicara' ? 'selected' : '' }}>
                                        Gangguan Bicara</option>
                                    <option value="bahasa"
                                        {{ $asesmen->rmeAsesmenKepAnak->hambatan_komunikasi == 'bahasa' ? 'selected' : '' }}>
                                        Perbedaan Bahasa</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Media Disukai</label>
                                <select class="form-select" name="media_disukai">
                                    <option value="" disabled
                                        {{ !$asesmen->rmeAsesmenKepAnak || !$asesmen->rmeAsesmenKepAnak->media_disukai ? 'selected' : '' }}>
                                        --Pilih--</option>
                                    <option value="cetak"
                                        {{ $asesmen->rmeAsesmenKepAnak->media_disukai == 'cetak' ? 'selected' : '' }}>
                                        Media Cetak</option>
                                    <option value="video"
                                        {{ $asesmen->rmeAsesmenKepAnak->media_disukai == 'video' ? 'selected' : '' }}>
                                        Video</option>
                                    <option value="diskusi"
                                        {{ $asesmen->rmeAsesmenKepAnak->media_disukai == 'diskusi' ? 'selected' : '' }}>
                                        Diskusi Langsung</option>
                                    <option value="demonstrasi"
                                        {{ $asesmen->rmeAsesmenKepAnak->media_disukai == 'demonstrasi' ? 'selected' : '' }}>
                                        Demonstrasi</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Tingkat Pendidikan</label>
                                <select class="form-select" name="tingkat_pendidikan">
                                    <option value="" disabled
                                        {{ !$asesmen->rmeAsesmenKepAnak || !$asesmen->rmeAsesmenKepAnak->tingkat_pendidikan ? 'selected' : '' }}>
                                        --Pilih--</option>
                                    <option value="SD"
                                        {{ $asesmen->rmeAsesmenKepAnak->tingkat_pendidikan == 'SD' ? 'selected' : '' }}>
                                        SD</option>
                                    <option value="SMP"
                                        {{ $asesmen->rmeAsesmenKepAnak->tingkat_pendidikan == 'SMP' ? 'selected' : '' }}>
                                        SMP</option>
                                    <option value="SMA"
                                        {{ $asesmen->rmeAsesmenKepAnak->tingkat_pendidikan == 'SMA' ? 'selected' : '' }}>
                                        SMA</option>
                                    <option value="Diploma"
                                        {{ $asesmen->rmeAsesmenKepAnak->tingkat_pendidikan == 'Diploma' ? 'selected' : '' }}>
                                        Diploma</option>
                                    <option value="Sarjana"
                                        {{ $asesmen->rmeAsesmenKepAnak->tingkat_pendidikan == 'Sarjana' ? 'selected' : '' }}>
                                        Sarjana</option>
                                    <option value="Tidak Sekolah"
                                        {{ $asesmen->rmeAsesmenKepAnak->tingkat_pendidikan == 'Tidak Sekolah' ? 'selected' : '' }}>
                                        Tidak Sekolah</option>
                                </select>
                            </div>
                        </div>

                        <!-- 15. Plan -->

                        <div class="section-separator" id="discharge-planning">
                            <h5 class="section-title">15. Discharge Planning</h5>

                            {{-- <div class="mb-4">
                                <label class="form-label">Diagnosis medis</label>
                                <input type="text" class="form-control" name="diagnosis_medis"
                                    placeholder="Diagnosis"
                                    value="{{ $asesmen->rmeAsesmenKepAnakRencanaPulang->diagnosis_medis ?? '' }}">
                            </div> --}}

                            <div class="mb-4">
                                <label class="form-label">Usia lanjut</label>
                                <select class="form-select" name="usia_lanjut">
                                    <option selected disabled>--Pilih--</option>
                                    <option value="0"
                                        {{ isset($asesmen->rmeAsesmenKepAnakRencanaPulang) && $asesmen->rmeAsesmenKepAnakRencanaPulang->usia_lanjut === '0' ? 'selected' : '' }}>
                                        Ya
                                    </option>
                                    <option value="1"
                                        {{ isset($asesmen->rmeAsesmenKepAnakRencanaPulang) && $asesmen->rmeAsesmenKepAnakRencanaPulang->usia_lanjut === '1' ? 'selected' : '' }}>
                                        Tidak
                                    </option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Hambatan mobilisasi</label>
                                <select class="form-select" name="hambatan_mobilisasi">
                                    <option selected disabled>--Pilih--</option>
                                    <option value="0"
                                        {{ isset($asesmen->rmeAsesmenKepAnakRencanaPulang) && $asesmen->rmeAsesmenKepAnakRencanaPulang->hambatan_mobilisasi === '0' ? 'selected' : '' }}>
                                        Ya
                                    </option>
                                    <option value="1"
                                        {{ isset($asesmen->rmeAsesmenKepAnakRencanaPulang) && $asesmen->rmeAsesmenKepAnakRencanaPulang->hambatan_mobilisasi === '1' ? 'selected' : '' }}>
                                        Tidak
                                    </option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Membutuhkan penggunaan media berkelanjutan</label>
                                <select class="form-select" name="penggunaan_media_berkelanjutan">
                                    <option selected disabled>--Pilih--</option>
                                    <option value="ya"
                                        {{ isset($asesmen->rmeAsesmenKepAnakRencanaPulang) && $asesmen->rmeAsesmenKepAnakRencanaPulang->membutuhkan_pelayanan_medis === 'ya' ? 'selected' : '' }}>
                                        Ya
                                    </option>
                                    <option value="tidak"
                                        {{ isset($asesmen->rmeAsesmenKepAnakRencanaPulang) && $asesmen->rmeAsesmenKepAnakRencanaPulang->membutuhkan_pelayanan_medis === 'tidak' ? 'selected' : '' }}>
                                        Tidak
                                    </option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Ketergantungan dengan orang lain dalam aktivitas
                                    harian</label>
                                <select class="form-select" name="ketergantungan_aktivitas">
                                    <option selected disabled>--Pilih--</option>
                                    <option value="ya">Ya</option>
                                    <option value="tidak">Tidak</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Pasien / Keluarga Memerlukan Keterampilan Khusus Setelah
                                    Pulang</label>
                                <select class="form-select" name="keterampilan_khusus">
                                    <option selected disabled>--Pilih--</option>
                                    <option value="ya"
                                        {{ isset($asesmen->rmeAsesmenKepAnakRencanaPulang) && $asesmen->rmeAsesmenKepAnakRencanaPulang->memerlukan_keterampilan_khusus === 'ya' ? 'selected' : '' }}>
                                        Ya
                                    </option>
                                    <option value="tidak"
                                        {{ isset($asesmen->rmeAsesmenKepAnakRencanaPulang) && $asesmen->rmeAsesmenKepAnakRencanaPulang->memerlukan_keterampilan_khusus === 'tidak' ? 'selected' : '' }}>
                                        Tidak
                                    </option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Pasien Memerlukan Alat Bantu Setelah Keluar Rumah
                                    Sakit</label>
                                <select class="form-select" name="alat_bantu">
                                    <option selected disabled>--Pilih--</option>
                                    <option value="ya"
                                        {{ isset($asesmen->rmeAsesmenKepAnakRencanaPulang) && $asesmen->rmeAsesmenKepAnakRencanaPulang->memerlukan_alat_bantu === 'ya' ? 'selected' : '' }}>
                                        Ya
                                    </option>
                                    <option value="tidak"
                                        {{ isset($asesmen->rmeAsesmenKepAnakRencanaPulang) && $asesmen->rmeAsesmenKepAnakRencanaPulang->memerlukan_alat_bantu === 'tidak' ? 'selected' : '' }}>
                                        Tidak
                                    </option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Pasien Memiliki Nyeri Kronis Dan / Kebiasaan Setelah
                                    Pulang</label>
                                <select class="form-select" name="nyeri_kronis">
                                    <option selected disabled>--Pilih--</option>
                                    <option value="ya"
                                        {{ isset($asesmen->rmeAsesmenKepAnakRencanaPulang) && $asesmen->rmeAsesmenKepAnakRencanaPulang->memiliki_nyeri_kronis === 'ya' ? 'selected' : '' }}>
                                        Ya
                                    </option>
                                    <option value="tidak"
                                        {{ isset($asesmen->rmeAsesmenKepAnakRencanaPulang) && $asesmen->rmeAsesmenKepAnakRencanaPulang->memiliki_nyeri_kronis === 'tidak' ? 'selected' : '' }}>
                                        Tidak
                                    </option>
                                </select>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Perkiraan lama hari dirawat</label>
                                    <input type="text" class="form-control" name="perkiraan_hari"
                                        placeholder="hari"
                                        value="{{ isset($asesmen->rmeAsesmenKepAnakRencanaPulang) ? $asesmen->rmeAsesmenKepAnakRencanaPulang->perkiraan_lama_dirawat : '' }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Rencana Tanggal Pulang</label>
                                    <input type="date" class="form-control" name="tanggal_pulang"
                                        value="{{ isset($asesmen->rmeAsesmenKepAnakRencanaPulang) ? $asesmen->rmeAsesmenKepAnakRencanaPulang->rencana_pulang : '' }}">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="form-label">KESIMPULAN</label>
                                <div class="d-flex flex-column gap-2">
                                    <div class="alert alert-info">

                                    </div>
                                    <div class="alert alert-warning">
                                        Mebutuhkan rencana pulang khusus
                                    </div>
                                    <div class="alert alert-success">
                                        Tidak mebutuhkan rencana pulang khusus
                                    </div>
                                </div>
                                <input type="hidden" id="kesimpulan" name="kesimpulan_planing"
                                    value="{{ isset($asesmen->rmeAsesmenKepAnakRencanaPulang) ? $asesmen->rmeAsesmenKepAnakRencanaPulang->kesimpulan : 'Tidak mebutuhkan rencana pulang khusus' }}">
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
                                                        {{ in_array('bersihan_jalan_nafas', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
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
                                                        {{ in_array('risiko_aspirasi', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
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
                                                        {{ in_array('pola_nafas_tidak_efektif', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
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
                                                        {{ in_array('monitor_pola_nafas', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor pola nafas ( frekuensi , kedalaman, usaha nafas )</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_bunyi_nafas"
                                                        {{ in_array('monitor_bunyi_nafas', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor bunyi nafas tambahan ( mengi, wheezing, rhonchi )</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_sputum"
                                                        {{ in_array('monitor_sputum', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor sputum ( jumlah, warna, aroma )</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_tingkat_kesadaran"
                                                        {{ in_array('monitor_tingkat_kesadaran', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tingkat kesadaran, batuk, muntah dan kemampuan menelan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_kemampuan_batuk"
                                                        {{ in_array('monitor_kemampuan_batuk', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor kemampuan batuk efektif</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="pertahankan_kepatenan"
                                                        {{ in_array('pertahankan_kepatenan', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertahankan kepatenan jalan nafas dengan head-tilt dan chin -lift ( jaw – thrust jika curiga trauma servikal ) </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="posisikan_semi_fowler"
                                                        {{ in_array('posisikan_semi_fowler', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Posisikan semi fowler atau fowler</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="berikan_minum_hangat"
                                                        {{ in_array('berikan_minum_hangat', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan minum hangat</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="fisioterapi_dada"
                                                        {{ in_array('fisioterapi_dada', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan fisioterapi dada, jika perlu</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="keluarkan_benda_padat"
                                                        {{ in_array('keluarkan_benda_padat', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Keluarkan benda padat dengan forcep</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="penghisapan_lendir"
                                                        {{ in_array('penghisapan_lendir', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan penghisapan lendir</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="berikan_oksigen"
                                                        {{ in_array('berikan_oksigen', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan oksigen</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="anjuran_asupan_cairan"
                                                        {{ in_array('anjuran_asupan_cairan', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjuran asupan cairan 2000 ml/hari, jika tidak kontra indikasi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="ajarkan_teknik_batuk"
                                                        {{ in_array('ajarkan_teknik_batuk', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan teknik batuk efektif</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="kolaborasi_pemberian_obat"
                                                        {{ in_array('kolaborasi_pemberian_obat', old('rencana_bersihan_jalan_nafas', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
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
                                                    {{ in_array('penurunan_curah_jantung', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}
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
                                                        {{ in_array('identifikasi_tanda_gejala', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi tanda/gejala primer penurunan curah jantung (meliputi dipsnea, kelelahan, edema)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_tekanan_darah"
                                                        {{ in_array('monitor_tekanan_darah', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tekanan darah</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_intake_output"
                                                        {{ in_array('monitor_intake_output', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor intake dan output cairan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_saturasi_oksigen"
                                                        {{ in_array('monitor_saturasi_oksigen', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor saturasi oksigen</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_keluhan_nyeri"
                                                        {{ in_array('monitor_keluhan_nyeri', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor keluhan nyeri dada (intensitas, lokasi, durasi, presivitasi yang mengurangi nyeri)</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_aritmia"
                                                        {{ in_array('monitor_aritmia', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor aritmia (kelainan irama dan frekuensi)</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="posisikan_pasien"
                                                        {{ in_array('posisikan_pasien', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Posisikan pasien semi fowler atau fowler dengan kaki kebawah atau posisi nyaman</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="berikan_terapi_relaksasi"
                                                        {{ in_array('berikan_terapi_relaksasi', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan therapi relaksasi untuk mengurangi stres, jika perlu</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="berikan_dukungan_emosional"
                                                        {{ in_array('berikan_dukungan_emosional', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan dukungan emosional dan spirital</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="berikan_oksigen_saturasi"
                                                        {{ in_array('berikan_oksigen_saturasi', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan oksigen untuk mempertahankan saturasi oksigen >94%</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="anjurkan_beraktifitas"
                                                        {{ in_array('anjurkan_beraktifitas', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan beraktifitas fisik sesuai toleransi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="anjurkan_berhenti_merokok"
                                                        {{ in_array('anjurkan_berhenti_merokok', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan berhenti merokok</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="ajarkan_mengukur_intake"
                                                        {{ in_array('ajarkan_mengukur_intake', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan pasien dan keluarga mengukur intake dan output cairan harian</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="kolaborasi_pemberian_terapi"
                                                        {{ in_array('kolaborasi_pemberian_terapi', old('rencana_penurunan_curah_jantung', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
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
                                                    {{ in_array('perfusi_perifer', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
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
                                                        {{ in_array('periksa_sirkulasi', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa sirkulasi perifer (edema, pengisian kapiler/CRT, suhu)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="identifikasi_faktor_risiko"
                                                        {{ in_array('identifikasi_faktor_risiko', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor risiko gangguan sirkulasi (diabetes, perokok, hipertensi, kadar kolesterol tinggi)</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="monitor_suhu_kemerahan"
                                                        {{ in_array('monitor_suhu_kemerahan', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor suhu, kemerahan, nyeri atau bengkak pada ekstremitas.</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="hindari_pemasangan_infus"
                                                        {{ in_array('hindari_pemasangan_infus', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hindari pemasangan infus atau pengambilan darah di area keterbatasan perfusi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="hindari_pengukuran_tekanan"
                                                        {{ in_array('hindari_pengukuran_tekanan', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hindari pengukuran tekanan darah pada ekstremitas dengan keterbatasan perfusi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="hindari_penekanan"
                                                        {{ in_array('hindari_penekanan', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hindari penekanan dan pemasangan tourniqet pada area yang cedera</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="lakukan_pencegahan_infeksi"
                                                        {{ in_array('lakukan_pencegahan_infeksi', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan pencegahan infeksi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="perawatan_kaki_kuku"
                                                        {{ in_array('perawatan_kaki_kuku', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan perawatan kaki dan kuku</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="anjurkan_berhenti_merokok_perfusi"
                                                        {{ in_array('anjurkan_berhenti_merokok_perfusi', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan berhenti merokok</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="anjurkan_berolahraga"
                                                        {{ in_array('anjurkan_berolahraga', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan berolahraga rutin</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="anjurkan_minum_obat"
                                                        {{ in_array('anjurkan_minum_obat', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan minum obat pengontrol tekanan darah secara teratur</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="kolaborasi_terapi_perfusi"
                                                        {{ in_array('kolaborasi_terapi_perfusi', old('rencana_perfusi_perifer', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
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
                                                    {{ in_array('hipovolemia', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
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
                                                        {{ in_array('periksa_tanda_gejala', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa tanda dan gejala hipovolemia (frekuensi nadi meningkat, nadi teraba lemah, tekanan darah penurun, turgor kulit menurun, membran mukosa kering, volume urine menurun, haus, lemah)</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="monitor_intake_output_hipovolemia"
                                                        {{ in_array('monitor_intake_output_hipovolemia', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor intake dan output cairan</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="berikan_asupan_cairan"
                                                        {{ in_array('berikan_asupan_cairan', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan asupan cairan oral</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="posisi_trendelenburg"
                                                        {{ in_array('posisi_trendelenburg', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Posisi modified trendelenburg</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="anjurkan_memperbanyak_cairan"
                                                        {{ in_array('anjurkan_memperbanyak_cairan', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan memperbanyak asupan cairan oral</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="hindari_perubahan_posisi"
                                                        {{ in_array('hindari_perubahan_posisi', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menghindari perubahan posisi mendadak</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="kolaborasi_terapi_hipovolemia"
                                                        {{ in_array('kolaborasi_terapi_hipovolemia', old('rencana_hipovolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
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
                                                    {{ in_array('hipervolemia', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
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
                                                        {{ in_array('periksa_tanda_hipervolemia', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa tanda dan gejala hipervolemia (dipsnea, edema, suara nafas tambahan)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="identifikasi_penyebab_hipervolemia"
                                                        {{ in_array('identifikasi_penyebab_hipervolemia', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi penyebab hipervolemia</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="monitor_hemodinamik"
                                                        {{ in_array('monitor_hemodinamik', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor status hemodinamik (frekuensi jantung, tekanan darah)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="monitor_intake_output_hipervolemia"
                                                        {{ in_array('monitor_intake_output_hipervolemia', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor intake dan output cairan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="monitor_efek_diuretik"
                                                        {{ in_array('monitor_efek_diuretik', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor efek samping diuretik (hipotensi ortostatik, hipovolemia, hipokalemia, hiponatremia)</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="timbang_berat_badan"
                                                        {{ in_array('timbang_berat_badan', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Timbang berat badan setiap hari pada waktu yang sama</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="batasi_asupan_cairan"
                                                        {{ in_array('batasi_asupan_cairan', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Batasi asupan cairan dan garam</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="tinggi_kepala_tempat_tidur"
                                                        {{ in_array('tinggi_kepala_tempat_tidur', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tinggi kepala tempat tidur 30 – 40 º</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="ajarkan_mengukur_cairan"
                                                        {{ in_array('ajarkan_mengukur_cairan', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara mengukur dan mencatat asupan dan haluaran cairan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="ajarkan_membatasi_cairan"
                                                        {{ in_array('ajarkan_membatasi_cairan', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara membatasi cairan</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="kolaborasi_terapi_hipervolemia"
                                                        {{ in_array('kolaborasi_terapi_hipervolemia', old('rencana_hipervolemia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
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
                                                    {{ in_array('diare', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
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
                                                        {{ in_array('identifikasi_penyebab_diare', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi penyebab diare (inflamasi gastrointestinal, iritasi gastrointestinal, proses infeksi, malabsorpsi, ansietas, stres, efek samping obat)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="identifikasi_riwayat_makanan"
                                                        {{ in_array('identifikasi_riwayat_makanan', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi riwayat pemberian makanan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="identifikasi_gejala_invaginasi"
                                                        {{ in_array('identifikasi_gejala_invaginasi', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi riwayat gejala invaginasi (tangisan keras, kepucatan pada bayi)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="monitor_warna_volume_tinja"
                                                        {{ in_array('monitor_warna_volume_tinja', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor warna, volume, frekuensi dan konsistensi tinja</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="monitor_tanda_hipovolemia"
                                                        {{ in_array('monitor_tanda_hipovolemia', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tanda dan gejala hipovolemia (takikardi, nadi teraba lemah, tekanan darah turun, turgor kulit turun, mukosa mulit kering, CRT melambat, BB menurun)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="monitor_iritasi_kulit"
                                                        {{ in_array('monitor_iritasi_kulit', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor iritasi dan ulserasi kulit di daerah perianal</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="monitor_jumlah_diare"
                                                        {{ in_array('monitor_jumlah_diare', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor jumlah pengeluaran diare</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="berikan_asupan_cairan_oral"
                                                        {{ in_array('berikan_asupan_cairan_oral', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan asupan cairan oral (larutan garam gula, oralit, pedialyte)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="pasang_jalur_intravena"
                                                        {{ in_array('pasang_jalur_intravena', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pasang jalur intravena</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="berikan_cairan_intravena"
                                                        {{ in_array('berikan_cairan_intravena', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan cairan intravena</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="anjurkan_makanan_porsi_kecil"
                                                        {{ in_array('anjurkan_makanan_porsi_kecil', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan makanan porsi kecil dan sering secara bertahap</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="hindari_makanan_gas"
                                                        {{ in_array('hindari_makanan_gas', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menghindari makanan pembentuk gas, pedas dan mengandung laktosa</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="lanjutkan_asi"
                                                        {{ in_array('lanjutkan_asi', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan melanjutkan pemberian ASI</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="kolaborasi_terapi_diare"
                                                        {{ in_array('kolaborasi_terapi_diare', old('rencana_diare', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
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
                                                    {{ in_array('retensi_urine', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
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
                                                        {{ in_array('identifikasi_tanda_retensi', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi tanda dan gejala retensi atau inkontinensia urine</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="identifikasi_faktor_penyebab"
                                                        {{ in_array('identifikasi_faktor_penyebab', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor yang menyebabkan retensi atau inkontinensia urine</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="monitor_eliminasi_urine"
                                                        {{ in_array('monitor_eliminasi_urine', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor eliminasi urine (frekuensi, konsistensi, aroma, volume dan warna)</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="catat_waktu_berkemih"
                                                        {{ in_array('catat_waktu_berkemih', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Catat waktu-waktu dan haluaran berkemih</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="batasi_asupan_cairan"
                                                        {{ in_array('batasi_asupan_cairan', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Batasi asupan cairan, jika perlu</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ambil_sampel_urine"
                                                        {{ in_array('ambil_sampel_urine', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ambil sampel urine tengah (midstream) atau kultur</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_tanda_infeksi"
                                                        {{ in_array('ajarkan_tanda_infeksi', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan tanda dan gejala infeksi saluran kemih</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_mengukur_asupan"
                                                        {{ in_array('ajarkan_mengukur_asupan', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan mengukur asupan cairan dan haluaran urine</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_spesimen_midstream"
                                                        {{ in_array('ajarkan_spesimen_midstream', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan mengambil spesimen urine midstream</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_tanda_berkemih"
                                                        {{ in_array('ajarkan_tanda_berkemih', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan mengenali tanda berkemih dan waktu yang tepat untuk berkemih</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_minum_cukup"
                                                        {{ in_array('ajarkan_minum_cukup', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan minum yang cukup, jika tidak ada kontraindikasi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="kurangi_minum_tidur"
                                                        {{ in_array('kurangi_minum_tidur', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan mengurangi minum menjelang tidur</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="kolaborasi_supositoria"
                                                        {{ in_array('kolaborasi_supositoria', old('rencana_retensi_urine', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
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
                                                    {{ in_array('nyeri_akut', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
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
                                                        {{ in_array('identifikasi_lokasi_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi lokasi, karakteristik, durasi, frekuensi, kualitas, intensitas nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_skala_nyeri"
                                                        {{ in_array('identifikasi_skala_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi skala nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_respons_nonverbal"
                                                        {{ in_array('identifikasi_respons_nonverbal', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi respons nyeri non verbal</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_faktor_nyeri"
                                                        {{ in_array('identifikasi_faktor_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor yang memperberat dan memperingan nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_pengetahuan_nyeri"
                                                        {{ in_array('identifikasi_pengetahuan_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengetahuan dan keyaninan tentang nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_pengaruh_budaya"
                                                        {{ in_array('identifikasi_pengaruh_budaya', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengaruh budaya terhadap respon nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_pengaruh_kualitas_hidup"
                                                        {{ in_array('identifikasi_pengaruh_kualitas_hidup', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengaruh nyeri pada kualitas hidup</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="monitor_keberhasilan_terapi"
                                                        {{ in_array('monitor_keberhasilan_terapi', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor keberhasilan terapi komplementer yang sudah diberikan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="monitor_efek_samping_analgetik"
                                                        {{ in_array('monitor_efek_samping_analgetik', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor efek samping penggunaan analgetil</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="berikan_teknik_nonfarmakologis"
                                                        {{ in_array('berikan_teknik_nonfarmakologis', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan teknik nonfarmakologis untuk mengurangi rasa nyeri (TENS, hipnosis, akupresur, terapi musik, biofeedback, terapi pijat, aromaterapi, teknik imajinasi terbimbing, kompres hangat/dingin, terapi bermain)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="kontrol_lingkungan_nyeri"
                                                        {{ in_array('kontrol_lingkungan_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kontrol lingkungan yang memperberat rasa nyeri (suhu ruangan, pencahayaan, kebisingan)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="fasilitasi_istirahat"
                                                        {{ in_array('fasilitasi_istirahat', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Fasilitasi istirahat dan tidur</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="pertimbangkan_strategi_nyeri"
                                                        {{ in_array('pertimbangkan_strategi_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertimbangkan jenis dan sumber nyeri dalam pemilihan strategi meredakan nyeri</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="jelaskan_penyebab_nyeri"
                                                        {{ in_array('jelaskan_penyebab_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan penyebab, periode, dan pemicu nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="jelaskan_strategi_nyeri"
                                                        {{ in_array('jelaskan_strategi_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan strategi meredakan nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="anjurkan_monitor_nyeri"
                                                        {{ in_array('anjurkan_monitor_nyeri', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan memonitor nyeri secara mandiri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="anjurkan_analgetik"
                                                        {{ in_array('anjurkan_analgetik', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menggunakan analgetik secara tepat</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="ajarkan_teknik_nonfarmakologis"
                                                        {{ in_array('ajarkan_teknik_nonfarmakologis', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan teknik nonfarmakologis untuk mengurangin rasa nyeri</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="kolaborasi_analgetik"
                                                        {{ in_array('kolaborasi_analgetik', old('rencana_nyeri_akut', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
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
                                                    {{ in_array('nyeri_kronis', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
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
                                                        {{ in_array('identifikasi_lokasi_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi lokasi, karakteristik, durasi, frekuensi, kualitas, intensitas nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_skala_nyeri_kronis"
                                                        {{ in_array('identifikasi_skala_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi skala nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_respons_nonverbal_kronis"
                                                        {{ in_array('identifikasi_respons_nonverbal_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi respons nyeri non verbal</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_faktor_nyeri_kronis"
                                                        {{ in_array('identifikasi_faktor_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor yang memperberat dan memperingan nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_pengetahuan_nyeri_kronis"
                                                        {{ in_array('identifikasi_pengetahuan_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengetahuan dan keyaninan tentang nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_pengaruh_budaya_kronis"
                                                        {{ in_array('identifikasi_pengaruh_budaya_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengaruh budaya terhadap respon nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_pengaruh_kualitas_hidup_kronis"
                                                        {{ in_array('identifikasi_pengaruh_kualitas_hidup_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengaruh nyeri pada kualitas hidup</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="monitor_keberhasilan_terapi_kronis"
                                                        {{ in_array('monitor_keberhasilan_terapi_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor keberhasilan terapi komplementer yang sudah diberikan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="monitor_efek_samping_analgetik_kronis"
                                                        {{ in_array('monitor_efek_samping_analgetik_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor efek samping penggunaan analgetil</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="berikan_teknik_nonfarmakologis_kronis"
                                                        {{ in_array('berikan_teknik_nonfarmakologis_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan teknik nonfarmakologis untuk mengurangi rasa nyeri (TENS, hipnosis, akupresur, terapi musik, biofeedback, terapi pijat, aromaterapi, teknik imajinasi terbimbing, kompres hangat/dingin, terapi bermain)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="kontrol_lingkungan_nyeri_kronis"
                                                        {{ in_array('kontrol_lingkungan_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kontrol lingkungan yang memperberat rasa nyeri (suhu ruangan, pencahayaan, kebisingan)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="fasilitasi_istirahat_kronis"
                                                        {{ in_array('fasilitasi_istirahat_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Fasilitasi istirahat dan tidur</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="pertimbangkan_strategi_nyeri_kronis"
                                                        {{ in_array('pertimbangkan_strategi_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertimbangkan jenis dan sumber nyeri dalam pemilihan strategi meredakan nyeri</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="jelaskan_penyebab_nyeri_kronis"
                                                        {{ in_array('jelaskan_penyebab_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan penyebab, periode, dan pemicu nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="jelaskan_strategi_nyeri_kronis"
                                                        {{ in_array('jelaskan_strategi_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan strategi meredakan nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="anjurkan_monitor_nyeri_kronis"
                                                        {{ in_array('anjurkan_monitor_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan memonitor nyeri secara mandiri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="anjurkan_analgetik_kronis"
                                                        {{ in_array('anjurkan_analgetik_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menggunakan analgetik secara tepat</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="ajarkan_teknik_nonfarmakologis_kronis"
                                                        {{ in_array('ajarkan_teknik_nonfarmakologis_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan teknik nonfarmakologis untuk mengurangin rasa nyeri</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="kolaborasi_analgetik_kronis"
                                                        {{ in_array('kolaborasi_analgetik_kronis', old('rencana_nyeri_kronis', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
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
                                                    {{ in_array('hipertermia', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
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
                                                        {{ in_array('identifikasi_penyebab_hipertermia', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi penyebab hipertermia (dehidrasi, terpapar lingkungan panas, penggunaan inkubator)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="monitor_suhu_tubuh"
                                                        {{ in_array('monitor_suhu_tubuh', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor suhu tubuh</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="monitor_kadar_elektrolit"
                                                        {{ in_array('monitor_kadar_elektrolit', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor kadar elektrolit</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="monitor_haluaran_urine"
                                                        {{ in_array('monitor_haluaran_urine', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor haluaran urine</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="monitor_komplikasi_hipertermia"
                                                        {{ in_array('monitor_komplikasi_hipertermia', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor komplikasi akibat hipertermia</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="sediakan_lingkungan_dingin"
                                                        {{ in_array('sediakan_lingkungan_dingin', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Sediakan lingkungan yang dingin</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="longgarkan_pakaian"
                                                        {{ in_array('longgarkan_pakaian', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Longgarkan atau lepaskan pakaian</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="basahi_kipasi_tubuh"
                                                        {{ in_array('basahi_kipasi_tubuh', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Basahi dan kipasi permukaan tubuh</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="berikan_cairan_oral_hipertermia"
                                                        {{ in_array('berikan_cairan_oral_hipertermia', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan cairan oral</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="ganti_linen_hiperhidrosis"
                                                        {{ in_array('ganti_linen_hiperhidrosis', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ganti linen setiap hari atau lebih sering jika mengalami hiperhidrosis (keringat berlebih)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="pendinginan_eksternal"
                                                        {{ in_array('pendinginan_eksternal', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan pendinginan eksternal (selimut hipotermia atau kompres dingin pada dahi, leher, dada, abdomen, aksila)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="hindari_antipiretik"
                                                        {{ in_array('hindari_antipiretik', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hindari pemberian antipiretik atau aspirin</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="berikan_oksigen_hipertermia"
                                                        {{ in_array('berikan_oksigen_hipertermia', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan oksigen, jika perlu</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="anjurkan_tirah_baring"
                                                        {{ in_array('anjurkan_tirah_baring', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan tirah baring</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="kolaborasi_cairan_elektrolit"
                                                        {{ in_array('kolaborasi_cairan_elektrolit', old('rencana_hipertermia', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
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
                                                    {{ in_array('gangguan_mobilitas_fisik', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
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
                                                        {{ in_array('identifikasi_nyeri_keluhan', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Indentifikasi adanya nyeri atau keluhan fisik lainnya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="identifikasi_toleransi_ambulasi"
                                                        {{ in_array('identifikasi_toleransi_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Indetifikasi toleransi fisik melakukan ambulasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="monitor_frekuensi_jantung_ambulasi"
                                                        {{ in_array('monitor_frekuensi_jantung_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor frekuensi jantung dan tekanan darah sebelum memulai ambulasi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="monitor_kondisi_umum_ambulasi"
                                                        {{ in_array('monitor_kondisi_umum_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor kondiri umum selama melakukan ambulasi</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="fasilitasi_aktivitas_ambulasi"
                                                        {{ in_array('fasilitasi_aktivitas_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Fasilitasi aktivitas ambulasi dengan alat bantu (tongkat, kruk)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="fasilitasi_mobilisasi_fisik"
                                                        {{ in_array('fasilitasi_mobilisasi_fisik', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Fasilitasi melakukan mobilisasi fisik, jika perlu</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="libatkan_keluarga_ambulasi"
                                                        {{ in_array('libatkan_keluarga_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Libatkan keluarga untuk membantu pasien dalam meningkatkan ambulasi</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="jelaskan_tujuan_ambulasi"
                                                        {{ in_array('jelaskan_tujuan_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan tujuan dan prosedur ambulasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="anjurkan_ambulasi_dini"
                                                        {{ in_array('anjurkan_ambulasi_dini', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan melakukan ambulasi dini</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="ajarkan_ambulasi_sederhana"
                                                        {{ in_array('ajarkan_ambulasi_sederhana', old('rencana_gangguan_mobilitas_fisik', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
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
                                                    {{ in_array('resiko_infeksi', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
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
                                                        {{ in_array('monitor_tanda_infeksi_sistemik', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tanda dan gejala infeksi lokal dan sistemik</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="batasi_pengunjung"
                                                        {{ in_array('batasi_pengunjung', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Batasi jumlah pengunjung</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="perawatan_kulit_edema"
                                                        {{ in_array('perawatan_kulit_edema', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan perawatan kulit pada area edema</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="cuci_tangan_kontak"
                                                        {{ in_array('cuci_tangan_kontak', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Cuci tangan sebelum dan sesudah kontak dengan pasien dan lingkungan pasien</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="pertahankan_teknik_aseptik"
                                                        {{ in_array('pertahankan_teknik_aseptik', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertahankan teknik aseptik pada pasien beresiko tinggi</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="jelaskan_tanda_infeksi_edukasi"
                                                        {{ in_array('jelaskan_tanda_infeksi_edukasi', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan tanda dan gejala infeksi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="ajarkan_cuci_tangan"
                                                        {{ in_array('ajarkan_cuci_tangan', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara mencuci tangan dengan benar</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="ajarkan_etika_batuk"
                                                        {{ in_array('ajarkan_etika_batuk', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan etika batuk</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="ajarkan_periksa_luka"
                                                        {{ in_array('ajarkan_periksa_luka', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara memeriksa kondisi luka atau luka operasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="anjurkan_asupan_nutrisi"
                                                        {{ in_array('anjurkan_asupan_nutrisi', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan meningkatkan asupan nutrisi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="anjurkan_asupan_cairan_infeksi"
                                                        {{ in_array('anjurkan_asupan_cairan_infeksi', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan meningkatkan asupan cairan</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="kolaborasi_imunisasi"
                                                        {{ in_array('kolaborasi_imunisasi', old('rencana_resiko_infeksi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
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
                                                    {{ in_array('konstipasi', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
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
                                                        {{ in_array('periksa_tanda_gejala_konstipasi', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa tanda dan gejala</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="periksa_pergerakan_usus"
                                                        {{ in_array('periksa_pergerakan_usus', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa pergerakan usus, karakteristik feses</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="identifikasi_faktor_risiko_konstipasi"
                                                        {{ in_array('identifikasi_faktor_risiko_konstipasi', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor risiko konstipasi</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="anjurkan_diet_tinggi_serat"
                                                        {{ in_array('anjurkan_diet_tinggi_serat', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan diet tinggi serat</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="masase_abdomen"
                                                        {{ in_array('masase_abdomen', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan masase abdomen, jika perlu</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="evakuasi_feses_manual"
                                                        {{ in_array('evakuasi_feses_manual', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan evakuasi feses secara manual, jika perlu</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="berikan_enema"
                                                        {{ in_array('berikan_enema', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan enema atau intigasi, jika perlu</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="jelaskan_etiologi_konstipasi"
                                                        {{ in_array('jelaskan_etiologi_konstipasi', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan etiologi masalah dan alasan tindakan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="anjurkan_peningkatan_cairan_konstipasi"
                                                        {{ in_array('anjurkan_peningkatan_cairan_konstipasi', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan peningkatan asupan cairan, jika tidak ada kontraindikasi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="ajarkan_mengatasi_konstipasi"
                                                        {{ in_array('ajarkan_mengatasi_konstipasi', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara mengatasi konstipasi/impaksi</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="kolaborasi_obat_pencahar"
                                                        {{ in_array('kolaborasi_obat_pencahar', old('rencana_konstipasi', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
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
                                                    {{ in_array('resiko_jatuh', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
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
                                                        {{ in_array('identifikasi_faktor_risiko_jatuh', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor risiko jatuh (usia >65 tahun, penurunan tingkat kesadaran, defisit kognitif, hipotensi ortostatik, gangguan keseimbangan, gangguan penglihatan, neuropati)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="identifikasi_risiko_setiap_shift"
                                                        {{ in_array('identifikasi_risiko_setiap_shift', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi risiko jatuh setidaknya sekali setiap shift atau sesuai dengan kebijakan institusi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="identifikasi_faktor_lingkungan"
                                                        {{ in_array('identifikasi_faktor_lingkungan', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor lingkungan yang meningkatkan risiko jatuh (lantai licin, penerangan kurang)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="hitung_risiko_jatuh"
                                                        {{ in_array('hitung_risiko_jatuh', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hitung risiko jatuh dengan menggunakan skala (Fall Morse Scale, humpty dumpty scale), jika perlu</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="monitor_kemampuan_berpindah"
                                                        {{ in_array('monitor_kemampuan_berpindah', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor kemampuan berpindah dari tempat tidur ke kursi roda dan sebaliknya</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="orientasikan_ruangan"
                                                        {{ in_array('orientasikan_ruangan', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Orientasikan ruangan pada pasien dan keluarga</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="pastikan_roda_terkunci"
                                                        {{ in_array('pastikan_roda_terkunci', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pastikan roda tempat tidur dan kursi roda selalu dalam kondisi terkunci</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="pasang_handrail"
                                                        {{ in_array('pasang_handrail', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pasang handrail tempat tidur</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="atur_tempat_tidur"
                                                        {{ in_array('atur_tempat_tidur', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Atur tempat tidur mekanis pada posisi terendah</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="tempatkan_dekat_perawat"
                                                        {{ in_array('tempatkan_dekat_perawat', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tempatkan pasien berisiko tinggi jatuh dekat dengan pantauan perawat dari nurse station</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="gunakan_alat_bantu"
                                                        {{ in_array('gunakan_alat_bantu', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Gunakan alat bantu berjalan (kursi roda, walker)</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="dekatkan_bel"
                                                        {{ in_array('dekatkan_bel', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Dekatkan bel pemanggil dalam jangkauan pasien</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="anjurkan_memanggil_perawat"
                                                        {{ in_array('anjurkan_memanggil_perawat', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan memanggil perawat jika membutuhkan bantuan untuk berpindah</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="anjurkan_alas_kaki"
                                                        {{ in_array('anjurkan_alas_kaki', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menggunakan alas kaki yang tidak licin</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="anjurkan_berkonsentrasi"
                                                        {{ in_array('anjurkan_berkonsentrasi', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan berkonsentrasi untuk menjaga keseimbangan tubuh</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="anjurkan_melebarkan_jarak"
                                                        {{ in_array('anjurkan_melebarkan_jarak', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan melebarkan jarak kedua kaki untuk meningkatkan keseimbangan saat berdiri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="ajarkan_bel_pemanggil"
                                                        {{ in_array('ajarkan_bel_pemanggil', old('rencana_resiko_jatuh', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
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
                                                    {{ in_array('gangguan_integritas_kulit', old('diagnosis', $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
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
                                                        {{ in_array('monitor_karakteristik_luka', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor karakteristik luka</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="monitor_tanda_infeksi"
                                                        {{ in_array('monitor_tanda_infeksi', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tanda-tanda infeksi</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="lepaskan_balutan"
                                                        {{ in_array('lepaskan_balutan', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lepaskan balutan dan plester secara perlahan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="bersihkan_nacl"
                                                        {{ in_array('bersihkan_nacl', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Bersihkan dengan cairan NaCl atau pembersih nontoksik</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="bersihkan_jaringan_nekrotik"
                                                        {{ in_array('bersihkan_jaringan_nekrotik', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Bersihkan jaringan nekrotik</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="berikan_salep"
                                                        {{ in_array('berikan_salep', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan salep yang sesuai ke kulit/lesi, jika perlu</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="pasang_balutan"
                                                        {{ in_array('pasang_balutan', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pasang balutan sesuai jenis luka</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="pertahankan_teknik_steril"
                                                        {{ in_array('pertahankan_teknik_steril', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertahankan teknik steril saat melakukan perawatan luka</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="jelaskan_tanda_infeksi"
                                                        {{ in_array('jelaskan_tanda_infeksi', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan tanda dan gejala infeksi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="anjurkan_makanan_tinggi_protein"
                                                        {{ in_array('anjurkan_makanan_tinggi_protein', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan mengkonsumsi makanan tinggi kalori dan protein</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="kolaborasi_debridement"
                                                        {{ in_array('kolaborasi_debridement', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi prosedur debridement</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="kolaborasi_antibiotik"
                                                        {{ in_array('kolaborasi_antibiotik', old('rencana_gangguan_integritas_kulit', $asesmen->rmeAsesmenKepAnakKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
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
                        <div class="text-end mt-2">
                            <x-button-submit>Perbarui</x-button-submit>
                        </div>
                    </form>
            </x-content-card>
        </div>
    </div>

    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-skalanyeri')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.edit-modal-jenisoperasi')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-riwayatkeluarga')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-intervensirisikojatuh')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-skala-adl')

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

    <!-- Modal for adding diseases -->
    <div class="modal fade" id="penyakitModal" tabindex="-1" aria-labelledby="penyakitModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="penyakitModalLabel">Tambah Penyakit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="penyakitInput" class="form-label">Nama Penyakit</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="penyakitInput"
                                placeholder="Masukkan nama penyakit">
                            <button class="btn btn-outline-secondary" type="button" id="tambahKeList">
                                <i class="ti-plus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Temporary list in modal -->
                    <div id="modalPenyakitList" class="d-flex flex-column gap-2">
                        <div id="modalEmptyState"
                            class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                            <p class="mb-0">Belum ada penyakit dalam list sementara</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="simpanPenyakit"
                        data-bs-dismiss="modal">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- GCS Modal -->
    <div class="modal fade" id="gcsModal" tabindex="-1" aria-labelledby="gcsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gcsModalLabel">Glasgow Coma Scale (GCS)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Eye Opening (E) -->
                        <div class="col-md-4">
                            <h6 class="fw-bold mb-3">Eye Opening (E)</h6>
                            <div class="gcs-section" data-category="eye">
                                <div class="form-check mb-2">
                                    <input class="form-check-input gcs-check" type="radio"
                                        name="gcs_eye" value="4" id="eye4">
                                    <label class="form-check-label" for="eye4">
                                        <strong>4</strong> - Spontan
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input gcs-check" type="radio"
                                        name="gcs_eye" value="3" id="eye3">
                                    <label class="form-check-label" for="eye3">
                                        <strong>3</strong> - Terhadap suara
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input gcs-check" type="radio"
                                        name="gcs_eye" value="2" id="eye2">
                                    <label class="form-check-label" for="eye2">
                                        <strong>2</strong> - Terhadap nyeri
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input gcs-check" type="radio"
                                        name="gcs_eye" value="1" id="eye1">
                                    <label class="form-check-label" for="eye1">
                                        <strong>1</strong> - Tidak ada respon
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Verbal Response (V) -->
                        <div class="col-md-4">
                            <h6 class="fw-bold mb-3">Verbal Response (V)</h6>
                            <div class="gcs-section" data-category="verbal">
                                <div class="form-check mb-2">
                                    <input class="form-check-input gcs-check" type="radio"
                                        name="gcs_verbal" value="5" id="verbal5">
                                    <label class="form-check-label" for="verbal5">
                                        <strong>5</strong> - Orientasi baik
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input gcs-check" type="radio"
                                        name="gcs_verbal" value="4" id="verbal4">
                                    <label class="form-check-label" for="verbal4">
                                        <strong>4</strong> - Bingung
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input gcs-check" type="radio"
                                        name="gcs_verbal" value="3" id="verbal3">
                                    <label class="form-check-label" for="verbal3">
                                        <strong>3</strong> - Kata-kata tidak tepat
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input gcs-check" type="radio"
                                        name="gcs_verbal" value="2" id="verbal2">
                                    <label class="form-check-label" for="verbal2">
                                        <strong>2</strong> - Suara tidak jelas
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input gcs-check" type="radio"
                                        name="gcs_verbal" value="1" id="verbal1">
                                    <label class="form-check-label" for="verbal1">
                                        <strong>1</strong> - Tidak ada respon
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Motor Response (M) -->
                        <div class="col-md-4">
                            <h6 class="fw-bold mb-3">Motor Response (M)</h6>
                            <div class="gcs-section" data-category="motor">
                                <div class="form-check mb-2">
                                    <input class="form-check-input gcs-check" type="radio"
                                        name="gcs_motor" value="6" id="motor6">
                                    <label class="form-check-label" for="motor6">
                                        <strong>6</strong> - Mengikuti perintah
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input gcs-check" type="radio"
                                        name="gcs_motor" value="5" id="motor5">
                                    <label class="form-check-label" for="motor5">
                                        <strong>5</strong> - Melokalisir nyeri
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input gcs-check" type="radio"
                                        name="gcs_motor" value="4" id="motor4">
                                    <label class="form-check-label" for="motor4">
                                        <strong>4</strong> - Menarik dari nyeri
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input gcs-check" type="radio"
                                        name="gcs_motor" value="3" id="motor3">
                                    <label class="form-check-label" for="motor3">
                                        <strong>3</strong> - Fleksi abnormal
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input gcs-check" type="radio"
                                        name="gcs_motor" value="2" id="motor2">
                                    <label class="form-check-label" for="motor2">
                                        <strong>2</strong> - Ekstensi abnormal
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input gcs-check" type="radio"
                                        name="gcs_motor" value="1" id="motor1">
                                    <label class="form-check-label" for="motor1">
                                        <strong>1</strong> - Tidak ada respon
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- GCS Summary -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <div class="row">
                            <div class="col-md-8">
                                <h6 class="mb-2">Total GCS:</h6>
                                <div class="d-flex gap-3 mb-2">
                                    <span>E: <span id="gcs_eye_display">-</span></span>
                                    <span>V: <span id="gcs_verbal_display">-</span></span>
                                    <span>M: <span id="gcs_motor_display">-</span></span>
                                </div>
                                <div class="alert alert-info mb-0" id="gcs_total_display">
                                    <strong>Total: - </strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h6 class="mb-2">Interpretasi:</h6>
                                <div class="alert alert-secondary mb-0" id="gcs_interpretation">
                                    Pilih semua komponen
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="simpanGCS">Simpan
                        GCS</button>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('js')
    <script>
        /**
         * JavaScript untuk Form Asesmen Keperawatan Anak
         * Diorganisir berdasarkan modul dan fungsi
         */

        document.addEventListener('DOMContentLoaded', function() {
            // ===================================================================
            // 1. MODUL DASAR - Inisialisasi waktu dan perhitungan dasar
            // ===================================================================

            const BasicModule = {
                init() {
                    this.initAnthropometricCalculation();
                    this.initPhysicalExamination();
                },

                initAnthropometricCalculation() {
                    const tinggiInput = document.getElementById("tinggi_badan");
                    const beratInput = document.getElementById("berat_badan");
                    const imtInput = document.getElementById("imt");
                    const lptInput = document.getElementById("lpt");

                    if (!tinggiInput || !beratInput) return;

                    const calculate = () => {
                        const tinggi = parseFloat(tinggiInput.value) / 100; // Konversi ke meter
                        const berat = parseFloat(beratInput.value);

                        if (tinggi > 0 && berat > 0) {
                            const imt = berat / (tinggi * tinggi);
                            const lpt = (tinggi * 100 * berat) / 3600;

                            if (imtInput) imtInput.value = imt.toFixed(2);
                            if (lptInput) lptInput.value = lpt.toFixed(2);
                        } else {
                            if (imtInput) imtInput.value = "";
                            if (lptInput) lptInput.value = "";
                        }
                    };

                    tinggiInput.addEventListener("input", calculate);
                    beratInput.addEventListener("input", calculate);
                },

                initPhysicalExamination() {
                    // Handler untuk tombol tambah keterangan
                    document.querySelectorAll('.tambah-keterangan').forEach(button => {
                        button.addEventListener('click', function() {
                            const targetId = this.getAttribute('data-target');
                            const keteranganDiv = document.getElementById(targetId);
                            const normalCheckbox = this.closest('.pemeriksaan-item')
                                .querySelector('.form-check-input');

                            if (keteranganDiv) {
                                keteranganDiv.style.display = 'block';
                                if (normalCheckbox) normalCheckbox.checked = false;
                            }
                        });
                    });

                    // Handler untuk checkbox normal
                    document.querySelectorAll('.form-check-input').forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            const pemeriksaanItem = this.closest('.pemeriksaan-item');
                            if (pemeriksaanItem) {
                                const keteranganDiv = pemeriksaanItem.querySelector(
                                    '.keterangan');
                                if (keteranganDiv && this.checked) {
                                    keteranganDiv.style.display = 'none';
                                    const input = keteranganDiv.querySelector('input');
                                    if (input) input.value = '';
                                }
                            }
                        });
                    });
                }
            };

            // ===================================================================
            // 2. MODUL SKALA NYERI
            // ===================================================================

            const PainScaleModule = {
                init() {
                    this.initScaleSelection();
                    this.initNRSScale();
                    this.initFLACCScale();
                    this.initCRIESScale();
                },

                initScaleSelection() {
                    const skalaSelect = document.getElementById('jenis_skala_nyeri');
                    if (!skalaSelect) return;

                    skalaSelect.addEventListener('change', function() {
                        // Tutup modal yang terbuka
                        document.querySelectorAll('.modal.show').forEach(modal => {
                            const modalInstance = bootstrap.Modal.getInstance(modal);
                            if (modalInstance) modalInstance.hide();
                        });

                        // Buka modal yang dipilih
                        const modalMap = {
                            'NRS': 'modalNRS',
                            'FLACC': 'modalFLACC',
                            'CRIES': 'modalCRIES'
                        };

                        const modalId = modalMap[this.value];
                        if (modalId) {
                            const modal = document.getElementById(modalId);
                            if (modal) {
                                new bootstrap.Modal(modal).show();
                            }
                        }
                    });
                },

                initNRSScale() {
                    const nrsValue = document.getElementById('nrs_value');
                    const nrsKesimpulan = document.getElementById('nrs_kesimpulan');
                    const simpanNRS = document.getElementById('simpanNRS');

                    if (!nrsValue) return;

                    nrsValue.addEventListener('input', function() {
                        let value = parseInt(this.value);
                        if (value < 0) this.value = 0;
                        if (value > 10) this.value = 10;
                        value = parseInt(this.value);

                        const conclusion = this.getConclusionByScore(value);
                        this.updateNRSConclusion(nrsKesimpulan, conclusion);
                    }.bind(this));

                    if (simpanNRS) {
                        simpanNRS.addEventListener('click', () => {
                            this.saveNRSValue();
                        });
                    }
                },

                initFLACCScale() {
                    document.querySelectorAll('.flacc-check').forEach(check => {
                        check.addEventListener('change', () => this.updateFLACCTotal());
                    });

                    const simpanFLACC = document.getElementById('simpanFLACC');
                    if (simpanFLACC) {
                        simpanFLACC.addEventListener('click', () => this.saveFLACCValue());
                    }
                },

                initCRIESScale() {
                    document.querySelectorAll('.cries-check').forEach(check => {
                        check.addEventListener('change', () => this.updateCRIESTotal());
                    });

                    const simpanCRIES = document.getElementById('simpanCRIES');
                    if (simpanCRIES) {
                        simpanCRIES.addEventListener('click', () => this.saveCRIESValue());
                    }
                },

                getConclusionByScore(score) {
                    if (score >= 0 && score <= 3) {
                        return {
                            text: 'Nyeri Ringan',
                            class: 'alert-success',
                            emoji: 'bi-emoji-smile'
                        };
                    } else if (score >= 4 && score <= 6) {
                        return {
                            text: 'Nyeri Sedang',
                            class: 'alert-warning',
                            emoji: 'bi-emoji-neutral'
                        };
                    } else {
                        return {
                            text: 'Nyeri Berat',
                            class: 'alert-danger',
                            emoji: 'bi-emoji-frown'
                        };
                    }
                },

                updateNRSConclusion(element, conclusion) {
                    if (!element) return;

                    element.className = `alert ${conclusion.class}`;
                    element.innerHTML = `
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi ${conclusion.emoji} fs-4"></i>
                            <span>${conclusion.text}</span>
                        </div>
                    `;
                },

                saveNRSValue() {
                    const nrsValue = document.getElementById('nrs_value');
                    const nilaiSkalaNyeri = document.getElementById('nilai_skala_nyeri');
                    const kesimpulanNyeri = document.getElementById('kesimpulan_nyeri');
                    const kesimpulanNyeriAlert = document.getElementById('kesimpulan_nyeri_alert');

                    if (!nrsValue || !nilaiSkalaNyeri) return;

                    const value = parseInt(nrsValue.value);
                    const conclusion = this.getConclusionByScore(value);

                    nilaiSkalaNyeri.value = value;
                    if (kesimpulanNyeri) kesimpulanNyeri.value = conclusion.text;

                    if (kesimpulanNyeriAlert) {
                        kesimpulanNyeriAlert.innerHTML = `
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi ${conclusion.emoji} fs-4"></i>
                                <span>${conclusion.text}</span>
                            </div>
                        `;
                        kesimpulanNyeriAlert.className = `alert ${conclusion.class}`;
                    }

                    const modal = document.getElementById('modalNRS');
                    if (modal) {
                        bootstrap.Modal.getInstance(modal).hide();
                    }
                },

                updateFLACCTotal() {
                    const flaccChecks = document.querySelectorAll('.flacc-check:checked');
                    const flaccTotal = document.getElementById('flaccTotal');
                    const flaccKesimpulan = document.getElementById('flaccKesimpulan');

                    let total = 0;
                    flaccChecks.forEach(check => {
                        total += parseInt(check.value);
                    });

                    if (flaccTotal) flaccTotal.value = total;

                    const conclusion = this.getConclusionByScore(total);
                    if (flaccKesimpulan) {
                        flaccKesimpulan.textContent = conclusion.text;
                        flaccKesimpulan.className = `alert py-1 px-3 mb-0 ${conclusion.class}`;
                    }
                },

                saveFLACCValue() {
                    const flaccTotal = document.getElementById('flaccTotal');
                    const nilaiSkalaNyeri = document.getElementById('nilai_skala_nyeri');
                    const kesimpulanNyeri = document.getElementById('kesimpulan_nyeri');
                    const kesimpulanNyeriAlert = document.getElementById('kesimpulan_nyeri_alert');

                    if (!flaccTotal || !nilaiSkalaNyeri) return;

                    const total = parseInt(flaccTotal.value);
                    const conclusion = this.getConclusionByScore(total);

                    nilaiSkalaNyeri.value = total;
                    if (kesimpulanNyeri) kesimpulanNyeri.value = conclusion.text;

                    if (kesimpulanNyeriAlert) {
                        kesimpulanNyeriAlert.innerHTML = `
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi ${conclusion.emoji} fs-4"></i>
                                <span>${conclusion.text}</span>
                            </div>
                        `;
                        kesimpulanNyeriAlert.className = `alert ${conclusion.class}`;
                    }

                    const modal = document.getElementById('modalFLACC');
                    if (modal) {
                        bootstrap.Modal.getInstance(modal).hide();
                    }
                },

                updateCRIESTotal() {
                    const criesChecks = document.querySelectorAll('.cries-check:checked');
                    const criesTotal = document.getElementById('criesTotal');
                    const criesKesimpulan = document.getElementById('criesKesimpulan');

                    let total = 0;
                    criesChecks.forEach(check => {
                        total += parseInt(check.value);
                    });

                    if (criesTotal) criesTotal.value = total;

                    const conclusion = this.getConclusionByScore(total);
                    if (criesKesimpulan) {
                        criesKesimpulan.textContent = conclusion.text;
                        criesKesimpulan.className = `alert py-1 px-3 mb-0 ${conclusion.class}`;
                    }
                },

                saveCRIESValue() {
                    const criesTotal = document.getElementById('criesTotal');
                    const nilaiSkalaNyeri = document.getElementById('nilai_skala_nyeri');
                    const kesimpulanNyeri = document.getElementById('kesimpulan_nyeri');
                    const kesimpulanNyeriAlert = document.getElementById('kesimpulan_nyeri_alert');

                    if (!criesTotal || !nilaiSkalaNyeri) return;

                    const total = parseInt(criesTotal.value);
                    const conclusion = this.getConclusionByScore(total);

                    nilaiSkalaNyeri.value = total;
                    if (kesimpulanNyeri) kesimpulanNyeri.value = conclusion.text;

                    if (kesimpulanNyeriAlert) {
                        kesimpulanNyeriAlert.innerHTML = `
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi ${conclusion.emoji} fs-4"></i>
                                <span>${conclusion.text}</span>
                            </div>
                        `;
                        kesimpulanNyeriAlert.className = `alert ${conclusion.class}`;
                    }

                    const modal = document.getElementById('modalCRIES');
                    if (modal) {
                        bootstrap.Modal.getInstance(modal).hide();
                    }
                }
            };

            // ===================================================================
            // 3. MODUL RISIKO JATUH
            // ===================================================================

            const FallRiskModule = {
                init() {
                    const risikoJatuhSkala = document.getElementById('risikoJatuhSkala');
                    if (risikoJatuhSkala) {
                        const initialValue = risikoJatuhSkala.value;
                        if (initialValue) {
                            this.showForm(initialValue);
                        }
                    }
                },

                showForm(formType) {
                    // Sembunyikan semua form
                    document.querySelectorAll('.risk-form').forEach(form => {
                        form.style.display = 'none';
                    });

                    if (formType === '5') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Pasien tidak dapat dinilai status resiko jatuh',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        });
                        document.getElementById('skala_lainnya').value = 'resiko jatuh lainnya';
                        return;
                    }

                    const formMapping = {
                        '1': 'skala_umumForm',
                        '2': 'skala_morseForm',
                        '3': 'skala_humptyForm',
                        '4': 'skala_ontarioForm'
                    };

                    const selectedForm = document.getElementById(formMapping[formType]);
                    if (selectedForm) {
                        selectedForm.style.display = 'block';
                        const formTypeMap = {
                            '1': 'umum',
                            '2': 'morse',
                            '3': 'humpty',
                            '4': 'ontario'
                        };
                        this.updateConclusion(formTypeMap[formType]);
                    }
                },

                updateConclusion(formType) {
                    const form = document.getElementById('skala_' + formType + 'Form');
                    if (!form) return;

                    const selects = form.querySelectorAll('select');
                    let score = 0;
                    let hasYes = false;

                    selects.forEach(select => {
                        if (select.value === '1') hasYes = true;
                        score += parseInt(select.value) || 0;
                    });

                    const conclusionDiv = form.querySelector('.conclusion');
                    if (!conclusionDiv) return;

                    const conclusionSpan = conclusionDiv.querySelector('#kesimpulanTextForm');
                    const conclusionInput = conclusionDiv.querySelector('input[type="hidden"]');

                    let conclusion = '';
                    let bgClass = '';

                    switch (formType) {
                        case 'umum':
                            conclusion = hasYes ? 'Berisiko jatuh' : 'Tidak berisiko jatuh';
                            bgClass = hasYes ? 'bg-danger' : 'bg-success';
                            if (conclusionInput) conclusionInput.value = conclusion;
                            break;

                        case 'morse':
                            if (score >= 45) {
                                conclusion = 'Risiko Tinggi';
                                bgClass = 'bg-danger';
                            } else if (score >= 25) {
                                conclusion = 'Risiko Sedang';
                                bgClass = 'bg-warning';
                            } else {
                                conclusion = 'Risiko Rendah';
                                bgClass = 'bg-success';
                            }
                            conclusion += ' (Skor: ' + score + ')';
                            const morseInput = document.getElementById('risiko_jatuh_morse_kesimpulan');
                            if (morseInput) morseInput.value = conclusion;
                            break;

                        case 'humpty':
                            conclusion = score >= 12 ? 'Risiko Tinggi' : 'Risiko Rendah';
                            bgClass = score >= 12 ? 'bg-danger' : 'bg-success';
                            conclusion += ' (Skor: ' + score + ')';
                            const humptyInput = document.getElementById('risiko_jatuh_pediatrik_kesimpulan');
                            if (humptyInput) humptyInput.value = conclusion;
                            break;

                        case 'ontario':
                            if (score >= 9) {
                                conclusion = 'Risiko Tinggi';
                                bgClass = 'bg-danger';
                            } else if (score >= 4) {
                                conclusion = 'Risiko Sedang';
                                bgClass = 'bg-warning';
                            } else {
                                conclusion = 'Risiko Rendah';
                                bgClass = 'bg-success';
                            }
                            conclusion += ' (Skor: ' + score + ')';
                            const ontarioInput = document.getElementById('risiko_jatuh_lansia_kesimpulan');
                            if (ontarioInput) ontarioInput.value = conclusion;
                            break;
                    }

                    if (conclusionDiv) {
                        conclusionDiv.className = 'conclusion ' + bgClass;
                        if (conclusionSpan) conclusionSpan.textContent = conclusion;
                    }
                }
            };

            // ===================================================================
            // 4. MODUL RISIKO DEKUBITUS
            // ===================================================================

            const DecubitusRiskModule = {
                init() {
                    const skalaDecubitusSelect = document.getElementById('skalaRisikoDekubitus');
                    if (skalaDecubitusSelect) {
                        if (skalaDecubitusSelect.value) {
                            this.showDecubitusForm(skalaDecubitusSelect.value);
                        }

                        skalaDecubitusSelect.addEventListener('change', (e) => {
                            this.showDecubitusForm(e.target.value);
                        });
                    }

                    this.initFormListeners();
                },

                showDecubitusForm(formType) {
                    document.querySelectorAll('.decubitus-form').forEach(form => {
                        form.style.display = 'none';
                    });

                    let formElement = null;
                    if (formType === 'norton') {
                        formElement = document.getElementById('formNorton');
                    } else if (formType === 'braden') {
                        formElement = document.getElementById('formBraden');
                    }

                    if (formElement) {
                        formElement.style.display = 'block';
                        this.updateDecubitusConclusion(formType);
                    }
                },

                initFormListeners() {
                    const formNorton = document.getElementById('formNorton');
                    if (formNorton) {
                        formNorton.querySelectorAll('select').forEach(select => {
                            select.addEventListener('change', () => this.updateDecubitusConclusion(
                                'norton'));
                        });
                    }

                    const formBraden = document.getElementById('formBraden');
                    if (formBraden) {
                        formBraden.querySelectorAll('select').forEach(select => {
                            select.addEventListener('change', () => this.updateDecubitusConclusion(
                                'braden'));
                        });
                    }
                },

                updateDecubitusConclusion(formType) {
                    const form = document.getElementById('form' + formType.charAt(0).toUpperCase() + formType
                        .slice(1));
                    if (!form) return;

                    const kesimpulanDiv = form.querySelector('#kesimpulanNorton') || form.querySelector(
                        '#kesimpulanBraden');
                    if (!kesimpulanDiv) return;

                    let total = 0;
                    let allFilled = true;
                    let fields = [];

                    if (formType === 'norton') {
                        fields = ['kondisi_fisik', 'kondisi_mental', 'norton_aktivitas', 'norton_mobilitas',
                            'inkontinensia'
                        ];
                    } else if (formType === 'braden') {
                        fields = ['persepsi_sensori', 'kelembapan', 'braden_aktivitas', 'braden_mobilitas',
                            'nutrisi', 'pergesekan'
                        ];
                    }

                    fields.forEach(field => {
                        const select = form.querySelector(`select[name="${field}"]`);
                        if (!select || !select.value) {
                            allFilled = false;
                            return;
                        }
                        total += parseInt(select.value);
                    });

                    if (!allFilled) {
                        kesimpulanDiv.className = 'alert alert-info mb-0 flex-grow-1';
                        kesimpulanDiv.textContent = 'Pilih semua kriteria untuk melihat kesimpulan';
                        return;
                    }

                    let conclusion = '';
                    let alertClass = '';

                    if (formType === 'norton') {
                        if (total <= 12) {
                            conclusion = 'Risiko Tinggi';
                            alertClass = 'alert-danger';
                        } else if (total <= 14) {
                            conclusion = 'Risiko Sedang';
                            alertClass = 'alert-warning';
                        } else {
                            conclusion = 'Risiko Rendah';
                            alertClass = 'alert-success';
                        }
                    } else if (formType === 'braden') {
                        if (total <= 12) {
                            conclusion = 'Risiko Tinggi';
                            alertClass = 'alert-danger';
                        } else if (total <= 16) {
                            conclusion = 'Risiko Sedang';
                            alertClass = 'alert-warning';
                        } else {
                            conclusion = 'Risiko Rendah';
                            alertClass = 'alert-success';
                        }
                    }

                    conclusion += ` (Skor: ${total})`;
                    kesimpulanDiv.className = `alert ${alertClass} mb-0 flex-grow-1`;
                    kesimpulanDiv.textContent = conclusion;
                }
            };

            // ===================================================================
            // 5. MODUL STATUS PSIKOLOGIS
            // ===================================================================

            const PsychologicalStatusModule = {
                init() {
                    this.initKondisiPsikologis();
                    this.initGangguanPerilaku();
                    this.initEventListeners();
                },

                initKondisiPsikologis() {
                    try {
                        const kondisiPsikologisData = document.getElementById('kondisi_psikologis_json')?.value;
                        if (kondisiPsikologisData && kondisiPsikologisData !== '[]') {
                            const data = JSON.parse(kondisiPsikologisData);
                            this.updateSelectedItems('selectedKondisiPsikologis', data, 'kondisi');
                            this.handleNoKelainanLogic();
                        }
                    } catch (e) {
                        console.error('Error parsing kondisi psikologis data:', e);
                    }
                },

                initGangguanPerilaku() {
                    try {
                        const gangguanPerilakuData = document.getElementById('gangguan_perilaku_json')?.value;
                        if (gangguanPerilakuData && gangguanPerilakuData !== '[]') {
                            const data = JSON.parse(gangguanPerilakuData);
                            this.updateSelectedItems('selectedGangguanPerilaku', data, 'perilaku');
                            this.handleNoGangguanLogic();
                        }
                    } catch (e) {
                        console.error('Error parsing gangguan perilaku data:', e);
                    }
                },

                initEventListeners() {
                    const btnKondisiPsikologis = document.getElementById('btnKondisiPsikologis');
                    const btnGangguanPerilaku = document.getElementById('btnGangguanPerilaku');

                    if (btnKondisiPsikologis) {
                        btnKondisiPsikologis.addEventListener('click', () =>
                            this.toggleDropdown('dropdownKondisiPsikologis'));
                    }

                    if (btnGangguanPerilaku) {
                        btnGangguanPerilaku.addEventListener('click', () =>
                            this.toggleDropdown('dropdownGangguanPerilaku'));
                    }

                    // Event listeners untuk checkbox
                    document.querySelectorAll('.kondisi-options input[type="checkbox"]').forEach(checkbox => {
                        checkbox.addEventListener('change', () => this.handleKondisiPsikologis());
                    });

                    document.querySelectorAll('.perilaku-options input[type="checkbox"]').forEach(checkbox => {
                        checkbox.addEventListener('change', () => this.handleGangguanPerilaku());
                    });

                    // Click outside to close dropdowns
                    document.addEventListener('click', (event) => {
                        if (!event.target.closest('.dropdown-wrapper')) {
                            document.getElementById('dropdownKondisiPsikologis')?.setAttribute('style',
                                'display: none');
                            document.getElementById('dropdownGangguanPerilaku')?.setAttribute('style',
                                'display: none');
                        }
                    });
                },

                toggleDropdown(dropdownId) {
                    const dropdown = document.getElementById(dropdownId);
                    if (dropdown) {
                        const isVisible = dropdown.style.display === 'block';
                        dropdown.style.display = isVisible ? 'none' : 'block';
                    }
                },

                updateSelectedItems(containerId, items, type) {
                    const container = document.getElementById(containerId);
                    if (!container) return;

                    container.innerHTML = items.map(item => `
                        <div class="alert alert-light border d-flex justify-content-between align-items-center py-1 px-2 mb-1">
                            <span>${item}</span>
                            <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-2"
                                    onclick="removeItem('${containerId}', '${item}')">
                                <i class="bi bi-x" style="font-size: 1.2rem;"></i>
                            </button>
                        </div>
                    `).join('');

                    const hiddenInputId = type === 'kondisi' ? 'kondisi_psikologis_json' :
                        'gangguan_perilaku_json';
                    const hiddenInput = document.getElementById(hiddenInputId);
                    if (hiddenInput) {
                        hiddenInput.value = JSON.stringify(items);
                    }
                },

                handleKondisiPsikologis() {
                    const kondisiCheckboxes = document.querySelectorAll(
                        '.kondisi-options input[type="checkbox"]');
                    const selectedItems = [];

                    kondisiCheckboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            selectedItems.push(checkbox.value);
                        }
                    });

                    this.updateSelectedItems('selectedKondisiPsikologis', selectedItems, 'kondisi');
                    this.handleNoKelainanLogic();
                },

                handleGangguanPerilaku() {
                    const perilakuCheckboxes = document.querySelectorAll(
                        '.perilaku-options input[type="checkbox"]');
                    const selectedItems = [];

                    perilakuCheckboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            selectedItems.push(checkbox.value);
                        }
                    });

                    this.updateSelectedItems('selectedGangguanPerilaku', selectedItems, 'perilaku');
                    this.handleNoGangguanLogic();
                },

                handleNoKelainanLogic() {
                    const noKelainanCheckbox = document.getElementById('kondisi1');
                    const kondisiCheckboxes = document.querySelectorAll(
                        '.kondisi-options input[type="checkbox"]');

                    if (noKelainanCheckbox?.checked) {
                        kondisiCheckboxes.forEach(cb => {
                            if (cb !== noKelainanCheckbox) {
                                cb.checked = false;
                                cb.disabled = true;
                            }
                        });
                    } else {
                        kondisiCheckboxes.forEach(cb => {
                            if (cb) cb.disabled = false;
                        });
                    }
                },

                handleNoGangguanLogic() {
                    const noGangguanCheckbox = document.getElementById('perilaku1');
                    const perilakuCheckboxes = document.querySelectorAll(
                        '.perilaku-options input[type="checkbox"]');

                    if (noGangguanCheckbox?.checked) {
                        perilakuCheckboxes.forEach(cb => {
                            if (cb !== noGangguanCheckbox) {
                                cb.checked = false;
                                cb.disabled = true;
                            }
                        });
                    } else {
                        perilakuCheckboxes.forEach(cb => {
                            if (cb) cb.disabled = false;
                        });
                    }
                }
            };

            // ===================================================================
            // 6. MODUL STATUS GIZI
            // ===================================================================

            const NutritionModule = {
                init() {
                    const nutritionSelect = document.getElementById('nutritionAssessment');
                    if (nutritionSelect) {
                        if (nutritionSelect.value) {
                            this.showSelectedNutritionForm();
                        }
                        nutritionSelect.addEventListener('change', () => this.showSelectedNutritionForm());
                    }
                },

                showSelectedNutritionForm() {
                    const nutritionSelect = document.getElementById('nutritionAssessment');
                    const selectedValue = nutritionSelect?.value;

                    // Sembunyikan semua form
                    document.querySelectorAll('.assessment-form').forEach(form => {
                        form.style.display = 'none';
                    });

                    if (selectedValue === '5') return;

                    const formMapping = {
                        '1': 'mst',
                        '2': 'mna',
                        '3': 'strong-kids',
                        '4': 'nrs'
                    };

                    const formId = formMapping[selectedValue];
                    if (formId) {
                        const selectedForm = document.getElementById(formId);
                        if (selectedForm) {
                            selectedForm.style.display = 'block';
                            this.initializeFormListeners(formId);
                        }
                    }
                },

                initializeFormListeners(formId) {
                    const form = document.getElementById(formId);
                    if (!form) return;

                    const selects = form.querySelectorAll('select');

                    switch (formId) {
                        case 'mst':
                            selects.forEach(select => {
                                select.addEventListener('change', () => this.calculateMSTScore(form));
                            });
                            this.calculateMSTScore(form);
                            break;
                        case 'mna':
                            selects.forEach(select => {
                                select.addEventListener('change', () => this.calculateMNAScore(form));
                            });
                            this.initializeBMICalculation();
                            this.calculateMNAScore(form);
                            break;
                        case 'strong-kids':
                            selects.forEach(select => {
                                select.addEventListener('change', () => this.calculateStrongKidsScore(
                                    form));
                            });
                            this.calculateStrongKidsScore(form);
                            break;
                        case 'nrs':
                            selects.forEach(select => {
                                select.addEventListener('change', () => this.calculateNRSScore(form));
                            });
                            this.calculateNRSScore(form);
                            break;
                    }
                },

                calculateMSTScore(form) {
                    if (!form) return;

                    const selects = form.querySelectorAll('select');
                    let total = 0;
                    let allSelected = true;

                    selects.forEach(select => {
                        if (select.value === '') {
                            allSelected = false;
                        } else {
                            total += parseInt(select.value || 0);
                        }
                    });

                    if (!allSelected) return;

                    const kesimpulan = total <= 1 ? 'Tidak berisiko malnutrisi' : 'Berisiko malnutrisi';
                    const kesimpulanInput = document.getElementById('gizi_mst_kesimpulan');
                    if (kesimpulanInput) kesimpulanInput.value = kesimpulan;

                    const conclusions = form.querySelectorAll('.risk-indicators .alert');
                    conclusions.forEach(alert => {
                        if ((total <= 1 && alert.classList.contains('alert-success')) ||
                            (total >= 2 && alert.classList.contains('alert-warning'))) {
                            alert.style.display = 'block';
                        } else {
                            alert.style.display = 'none';
                        }
                    });
                },

                initializeBMICalculation() {
                    const weightInput = document.getElementById('mnaWeight');
                    const heightInput = document.getElementById('mnaHeight');
                    const bmiInput = document.getElementById('mnaBMI');

                    if (!weightInput || !heightInput || !bmiInput) return;

                    const calculateBMI = () => {
                        const weight = parseFloat(weightInput.value || 0);
                        const height = parseFloat(heightInput.value || 0);

                        if (weight > 0 && height > 0) {
                            const heightInMeters = height / 100;
                            const bmi = weight / (heightInMeters * heightInMeters);
                            bmiInput.value = bmi.toFixed(2);
                        }
                    };

                    weightInput.addEventListener('input', calculateBMI);
                    heightInput.addEventListener('input', calculateBMI);
                },

                calculateMNAScore(form) {
                    const selects = form.querySelectorAll('select[name^="gizi_mna_"]');
                    let total = 0;

                    selects.forEach(select => {
                        const value = parseInt(select.value || 0);
                        total += value;
                    });

                    const kesimpulan = total >= 12 ? '≥ 12 Tidak Beresiko' : '≤ 11 Beresiko malnutrisi';
                    const kesimpulanInput = document.getElementById('gizi_mna_kesimpulan');
                    if (kesimpulanInput) kesimpulanInput.value = kesimpulan;

                    const conclusionDiv = document.getElementById('mnaConclusion');
                    if (conclusionDiv) {
                        const alertClass = total >= 12 ? 'alert-success' : 'alert-warning';
                        conclusionDiv.innerHTML = `
                            <div class="alert ${alertClass}">
                                Kesimpulan: ${kesimpulan} (Total Score: ${total})
                            </div>
                            <input type="hidden" name="gizi_mna_kesimpulan" id="gizi_mna_kesimpulan" value="${kesimpulan}">
                        `;
                    }
                },

                calculateStrongKidsScore(form) {
                    const selects = form.querySelectorAll('select');
                    let total = 0;

                    selects.forEach(select => {
                        total += parseInt(select.value || 0);
                    });

                    let kesimpulan, kesimpulanText, type;
                    if (total === 0) {
                        kesimpulan = 'Beresiko rendah';
                        kesimpulanText = '0 (Beresiko rendah)';
                        type = 'success';
                    } else if (total >= 1 && total <= 3) {
                        kesimpulan = 'Beresiko sedang';
                        kesimpulanText = '1-3 (Beresiko sedang)';
                        type = 'warning';
                    } else {
                        kesimpulan = 'Beresiko Tinggi';
                        kesimpulanText = '4-5 (Beresiko Tinggi)';
                        type = 'danger';
                    }

                    const kesimpulanInput = document.getElementById('gizi_strong_kesimpulan');
                    if (kesimpulanInput) kesimpulanInput.value = kesimpulanText;

                    const conclusionDiv = document.getElementById('strongKidsConclusion');
                    if (conclusionDiv) {
                        conclusionDiv.innerHTML = `
                            <div class="alert alert-${type}">
                                Kesimpulan: ${kesimpulanText} (Total Score: ${total})
                            </div>
                            <input type="hidden" name="gizi_strong_kesimpulan" id="gizi_strong_kesimpulan" value="${kesimpulanText}">
                        `;
                    }
                },

                calculateNRSScore(form) {
                    const selects = form.querySelectorAll('select');
                    let total = 0;

                    selects.forEach(select => {
                        total += parseInt(select.value || 0);
                    });

                    let kesimpulan, kesimpulanText, type;
                    if (total <= 5) {
                        kesimpulan = 'Beresiko rendah';
                        kesimpulanText = '≤ 5 (Beresiko rendah)';
                        type = 'success';
                    } else if (total <= 10) {
                        kesimpulan = 'Beresiko sedang';
                        kesimpulanText = '6-10 (Beresiko sedang)';
                        type = 'warning';
                    } else {
                        kesimpulan = 'Beresiko Tinggi';
                        kesimpulanText = '> 10 (Beresiko Tinggi)';
                        type = 'danger';
                    }

                    const kesimpulanInput = document.getElementById('gizi_nrs_kesimpulan');
                    if (kesimpulanInput) kesimpulanInput.value = kesimpulanText;

                    const conclusionDiv = document.getElementById('nrsConclusion');
                    if (conclusionDiv) {
                        conclusionDiv.innerHTML = `
                            <div class="alert alert-${type}">
                                Kesimpulan: ${kesimpulanText} (Total Score: ${total})
                            </div>
                            <input type="hidden" name="gizi_nrs_kesimpulan" id="gizi_nrs_kesimpulan" value="${kesimpulanText}">
                        `;
                    }
                }
            };

            // ===================================================================
            // 7. MODUL STATUS FUNGSIONAL (ADL)
            // ===================================================================

            const FunctionalStatusModule = {
                init() {
                    const statusFungsionalSelect = document.getElementById('skala_fungsional');
                    if (statusFungsionalSelect) {
                        statusFungsionalSelect.addEventListener('change', (e) => this.handleScaleSelection(e
                            .target.value));
                    }

                    this.initADLHandlers();
                },

                handleScaleSelection(value) {
                    const adlTotal = document.getElementById('adl_total');
                    const adlKesimpulanAlert = document.getElementById('adl_kesimpulan');

                    if (value === 'Pengkajian Aktivitas') {
                        // Reset nilai sebelum menampilkan modal
                        if (adlTotal) adlTotal.value = '';
                        if (adlKesimpulanAlert) {
                            adlKesimpulanAlert.className = 'alert alert-info';
                            adlKesimpulanAlert.textContent = 'Pilih skala aktivitas harian terlebih dahulu';
                        }

                        const modal = document.getElementById('modalADL');
                        if (modal) {
                            new bootstrap.Modal(modal).show();
                        }
                    } else if (value === 'Lainnya') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Skala pengukuran lainnya belum tersedia',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        }).then(() => {
                            if (statusFungsionalSelect) statusFungsionalSelect.value = '';
                            if (adlTotal) adlTotal.value = '';
                            if (adlKesimpulanAlert) {
                                adlKesimpulanAlert.className = 'alert alert-info';
                                adlKesimpulanAlert.textContent =
                                    'Pilih skala aktivitas harian terlebih dahulu';
                            }
                        });
                    }
                },

                initADLHandlers() {
                    document.querySelectorAll('.adl-check').forEach(check => {
                        check.addEventListener('change', () => this.updateADLTotal());
                    });

                    const simpanADL = document.getElementById('simpanADL');
                    if (simpanADL) {
                        simpanADL.addEventListener('click', () => this.saveADLData());
                    }
                },

                updateADLTotal() {
                    const adlChecks = document.querySelectorAll('.adl-check:checked');
                    const adlModalTotal = document.getElementById('adlTotal');
                    const adlModalKesimpulan = document.getElementById('adlKesimpulan');

                    let total = 0;
                    adlChecks.forEach(check => {
                        total += parseInt(check.value);
                    });

                    if (adlModalTotal) adlModalTotal.value = total;

                    // Hitung jumlah kategori yang sudah dipilih
                    const checkedCategories = new Set(Array.from(adlChecks).map(check =>
                        check.getAttribute('data-category')));
                    const allCategoriesSelected = checkedCategories.size === 3; // 3 kategori

                    if (!allCategoriesSelected) {
                        if (adlModalKesimpulan) {
                            adlModalKesimpulan.className = 'alert alert-info py-1 px-3 mb-0';
                            adlModalKesimpulan.textContent = 'Pilih semua kategori terlebih dahulu';
                        }
                        return;
                    }

                    let kesimpulan = '';
                    let alertClass = '';

                    if (total <= 4) {
                        kesimpulan = 'Mandiri';
                        alertClass = 'alert-success';
                    } else if (total <= 8) {
                        kesimpulan = 'Ketergantungan Ringan';
                        alertClass = 'alert-info';
                    } else if (total <= 11) {
                        kesimpulan = 'Ketergantungan Sedang';
                        alertClass = 'alert-warning';
                    } else {
                        kesimpulan = 'Ketergantungan Berat';
                        alertClass = 'alert-danger';
                    }

                    if (adlModalKesimpulan) {
                        adlModalKesimpulan.className = `alert ${alertClass} py-1 px-3 mb-0`;
                        adlModalKesimpulan.textContent = kesimpulan;
                    }
                },

                saveADLData() {
                    const adlModalTotal = document.getElementById('adlTotal');
                    const adlModalKesimpulan = document.getElementById('adlKesimpulan');
                    const adlTotal = document.getElementById('adl_total');
                    const adlKesimpulanAlert = document.getElementById('adl_kesimpulan');

                    if (!adlModalTotal || !adlModalTotal.value || !adlKesimpulanAlert) return;

                    // Update nilai total
                    if (adlTotal) adlTotal.value = adlModalTotal.value;

                    // Update kesimpulan di form utama
                    if (adlModalKesimpulan) {
                        adlKesimpulanAlert.className = adlModalKesimpulan.className.replace('py-1 px-3 mb-0',
                            '');
                        adlKesimpulanAlert.textContent = adlModalKesimpulan.textContent;
                    }

                    // Simpan nilai-nilai tersembunyi
                    const adlValues = this.getSelectedADLValues();
                    this.updateHiddenADLInputs(adlValues, adlModalKesimpulan?.textContent);

                    // Tutup modal
                    const modal = document.getElementById('modalADL');
                    if (modal) {
                        bootstrap.Modal.getInstance(modal).hide();
                    }
                },

                getSelectedADLValues() {
                    const makanValue = document.querySelector('input[name="makan"]:checked')?.value || '';
                    const berjalanValue = document.querySelector('input[name="berjalan"]:checked')?.value || '';
                    const mandiValue = document.querySelector('input[name="mandi"]:checked')?.value || '';

                    const getTextValue = (value) => {
                        switch (value) {
                            case '1':
                                return 'Mandiri';
                            case '2':
                                return '25% Dibantu';
                            case '3':
                                return '50% Dibantu';
                            case '4':
                                return '75% Dibantu';
                            default:
                                return '';
                        }
                    };

                    return {
                        makan: getTextValue(makanValue),
                        makanValue: makanValue,
                        berjalan: getTextValue(berjalanValue),
                        berjalanValue: berjalanValue,
                        mandi: getTextValue(mandiValue),
                        mandiValue: mandiValue
                    };
                },

                updateHiddenADLInputs(adlValues, kesimpulan) {
                    const hiddenInputs = {
                        'adl_makan': adlValues.makan,
                        'adl_makan_value': adlValues.makanValue,
                        'adl_berjalan': adlValues.berjalan,
                        'adl_berjalan_value': adlValues.berjalanValue,
                        'adl_mandi': adlValues.mandi,
                        'adl_mandi_value': adlValues.mandiValue,
                        'adl_kesimpulan_value': kesimpulan,
                        'adl_jenis_skala': '1'
                    };

                    Object.entries(hiddenInputs).forEach(([id, value]) => {
                        const input = document.getElementById(id);
                        if (input) input.value = value || '';
                    });
                }
            };

            // ===================================================================
            // 8. MODUL DISCHARGE PLANNING
            // ===================================================================

            const DischargePlanningModule = {
                init() {
                    const dischargePlanningSection = document.getElementById('discharge-planning');
                    if (!dischargePlanningSection) return;

                    const allSelects = dischargePlanningSection.querySelectorAll('select');
                    allSelects.forEach(select => {
                        select.addEventListener('change', () => this.updateConclusion());
                    });

                    this.updateConclusion();
                },

                updateConclusion() {
                    const dischargePlanningSection = document.getElementById('discharge-planning');
                    if (!dischargePlanningSection) return;

                    const allSelects = dischargePlanningSection.querySelectorAll('select');
                    const alertWarning = dischargePlanningSection.querySelector('.alert-warning');
                    const alertSuccess = dischargePlanningSection.querySelector('.alert-success');
                    const alertInfo = dischargePlanningSection.querySelector('.alert-info');
                    const kesimpulanInput = document.getElementById('kesimpulan');

                    let needsSpecialPlan = false;
                    let allSelected = true;

                    allSelects.forEach(select => {
                        if (!select.value) {
                            allSelected = false;
                        } else if (select.value === 'ya') {
                            needsSpecialPlan = true;
                        }
                    });

                    if (!allSelected) {
                        this.showAlert(alertInfo, 'block');
                        this.showAlert(alertWarning, 'none');
                        this.showAlert(alertSuccess, 'none');
                        if (kesimpulanInput) kesimpulanInput.value = 'Pilih semua Planning';
                        return;
                    }

                    if (needsSpecialPlan) {
                        this.showAlert(alertWarning, 'block');
                        this.showAlert(alertSuccess, 'none');
                        this.showAlert(alertInfo, 'none');
                        if (kesimpulanInput) kesimpulanInput.value = 'Mebutuhkan rencana pulang khusus';
                    } else {
                        this.showAlert(alertWarning, 'none');
                        this.showAlert(alertSuccess, 'block');
                        this.showAlert(alertInfo, 'none');
                        if (kesimpulanInput) kesimpulanInput.value = 'Tidak mebutuhkan rencana pulang khusus';
                    }
                },

                showAlert(alertElement, display) {
                    if (alertElement) alertElement.style.display = display;
                }
            };

            // ===================================================================
            // 9. MODUL PENYAKIT YANG PERNAH DIDERITA
            // ===================================================================

            const PenyakitModule = {
                penyakitList: [],
                tempPenyakitList: [],

                init() {
                    this.loadExistingData();
                    this.initEventListeners();
                    this.updatePenyakitList();
                },

                loadExistingData() {
                    const existingData = document.getElementById('penyakitDideritaInput')?.value;

                    try {
                        if (existingData && existingData !== '[]') {
                            this.penyakitList = typeof existingData === 'string' ?
                                JSON.parse(existingData) : existingData;
                        }
                    } catch (e) {
                        console.error('Error parsing penyakit data:', e);
                        this.penyakitList = [];
                    }
                },

                initEventListeners() {
                    const tambahKeListBtn = document.getElementById('tambahKeList');
                    if (tambahKeListBtn) {
                        tambahKeListBtn.addEventListener('click', () => this.addToTempList());
                    }

                    const simpanPenyakitBtn = document.getElementById('simpanPenyakit');
                    if (simpanPenyakitBtn) {
                        simpanPenyakitBtn.addEventListener('click', () => this.savePenyakit());
                    }

                    const penyakitInput = document.getElementById('penyakitInput');
                    if (penyakitInput) {
                        penyakitInput.addEventListener('keypress', (e) => {
                            if (e.key === 'Enter') {
                                e.preventDefault();
                                this.addToTempList();
                            }
                        });
                    }

                    const penyakitModal = document.getElementById('penyakitModal');
                    if (penyakitModal) {
                        penyakitModal.addEventListener('show.bs.modal', () => {
                            this.resetTempList();
                        });
                    }
                },

                updatePenyakitList() {
                    const listContainer = document.getElementById('selectedPenyakitList');
                    const hiddenInput = document.getElementById('penyakitDideritaInput');
                    const emptyState = document.getElementById('emptyState');

                    if (!listContainer || !hiddenInput) return;

                    listContainer.innerHTML = '';

                    if (this.penyakitList.length === 0) {
                        if (emptyState) {
                            const emptyStateClone = emptyState.cloneNode(true);
                            emptyStateClone.style.display = 'block';
                            listContainer.appendChild(emptyStateClone);
                        }
                    } else {
                        this.penyakitList.forEach((penyakit, index) => {
                            const item = document.createElement('div');
                            item.className =
                                'p-2 bg-light rounded d-flex justify-content-between align-items-center mb-2';
                            item.innerHTML = `
                                <span>${this.escapeHtml(penyakit)}</span>
                                <button type="button" class="btn btn-sm btn-danger delete-penyakit" data-index="${index}">
                                    <i class="ti-trash"></i>
                                </button>
                            `;

                            // Add event listener to delete button
                            const deleteBtn = item.querySelector('.delete-penyakit');
                            deleteBtn.addEventListener('click', () => this.removePenyakit(index));

                            listContainer.appendChild(item);
                        });
                    }

                    hiddenInput.value = JSON.stringify(this.penyakitList);
                },

                updateModalList() {
                    const modalList = document.getElementById('modalPenyakitList');
                    if (!modalList) return;

                    modalList.innerHTML = '';

                    if (this.tempPenyakitList.length === 0) {
                        const modalEmptyState = document.createElement('div');
                        modalEmptyState.className =
                            'border border-dashed border-secondary rounded p-3 text-center text-muted';
                        modalEmptyState.innerHTML =
                            '<p class="mb-0">Belum ada penyakit dalam list sementara</p>';
                        modalList.appendChild(modalEmptyState);
                    } else {
                        this.tempPenyakitList.forEach((penyakit, index) => {
                            const item = document.createElement('div');
                            item.className =
                                'p-2 bg-light rounded d-flex justify-content-between align-items-center mb-2';
                            item.innerHTML = `
                                <span>${this.escapeHtml(penyakit)}</span>
                                <button type="button" class="btn btn-sm btn-danger delete-temp-penyakit" data-index="${index}">
                                    <i class="ti-trash"></i>
                                </button>
                            `;

                            // Add event listener to delete button
                            const deleteBtn = item.querySelector('.delete-temp-penyakit');
                            deleteBtn.addEventListener('click', () => this.removeTempPenyakit(index));

                            modalList.appendChild(item);
                        });
                    }
                },

                addToTempList() {
                    const input = document.getElementById('penyakitInput');
                    if (!input) return;

                    const penyakit = input.value.trim();

                    if (penyakit) {
                        if (!this.tempPenyakitList.includes(penyakit) && !this.penyakitList.includes(
                            penyakit)) {
                            this.tempPenyakitList.push(penyakit);
                            this.updateModalList();
                            input.value = '';
                            input.focus();
                        }
                    }
                },

                savePenyakit() {
                    if (this.tempPenyakitList.length > 0) {
                        this.penyakitList = [...this.penyakitList, ...this.tempPenyakitList];
                        this.tempPenyakitList = [];
                        this.updatePenyakitList();

                        // Close modal
                        const penyakitModal = document.getElementById('penyakitModal');
                        if (penyakitModal) {
                            const modal = bootstrap.Modal.getInstance(penyakitModal);
                            if (modal) {
                                modal.hide();
                            }
                        }
                    }
                },

                removePenyakit(index) {
                    if (index >= 0 && index < this.penyakitList.length) {
                        this.penyakitList.splice(index, 1);
                        this.updatePenyakitList();
                    }
                },

                removeTempPenyakit(index) {
                    if (index >= 0 && index < this.tempPenyakitList.length) {
                        this.tempPenyakitList.splice(index, 1);
                        this.updateModalList();
                    }
                },

                resetTempList() {
                    this.tempPenyakitList = [];
                    this.updateModalList();
                    const penyakitInput = document.getElementById('penyakitInput');
                    if (penyakitInput) {
                        penyakitInput.value = '';
                    }
                },

                escapeHtml(text) {
                    const div = document.createElement('div');
                    div.textContent = text;
                    return div.innerHTML;
                }
            };

            // ===================================================================
            // 10. MODUL MANAJEMEN ALERGI
            // ===================================================================

            const AllergyModule = {
                alergiDataArray: [],

                init() {
                    this.loadExistingData();
                    this.initEventListeners();
                    this.updateMainAlergiTable();
                },

                loadExistingData() {
                    try {
                        // Ambil data alergi dari variable yang dikirim dari controller
                        const alergiPasien = @json($alergiPasien ?? []);

                        this.alergiDataArray = alergiPasien.map(item => ({
                            jenis_alergi: item.jenis_alergi || '',
                            alergen: item.nama_alergi || '',
                            reaksi: item.reaksi || '',
                            tingkat_keparahan: item.tingkat_keparahan || '',
                            is_existing: true,
                            id: item.id || null
                        }));
                    } catch (e) {
                        console.error('Error loading existing alergi data:', e);
                        this.alergiDataArray = [];
                    }
                },

                initEventListeners() {
                    const openAlergiModal = document.getElementById('openAlergiModal');
                    if (openAlergiModal) {
                        openAlergiModal.addEventListener('click', () => this.updateModalAlergiList());
                    }

                    const addToAlergiList = document.getElementById('addToAlergiList');
                    if (addToAlergiList) {
                        addToAlergiList.addEventListener('click', () => this.addAlergiToList());
                    }

                    const saveAlergiData = document.getElementById('saveAlergiData');
                    if (saveAlergiData) {
                        saveAlergiData.addEventListener('click', () => this.saveAlergiData());
                    }
                },

                addAlergiToList() {
                    const jenisAlergi = document.getElementById('modal_jenis_alergi')?.value?.trim();
                    const alergen = document.getElementById('modal_alergen')?.value?.trim();
                    const reaksi = document.getElementById('modal_reaksi')?.value?.trim();
                    const tingkatKeparahan = document.getElementById('modal_tingkat_keparahan')?.value?.trim();

                    if (!jenisAlergi || !alergen || !reaksi || !tingkatKeparahan) return;

                    const isDuplicate = this.alergiDataArray.some(item =>
                        item.jenis_alergi === jenisAlergi &&
                        item.alergen.toLowerCase() === alergen.toLowerCase()
                    );

                    if (isDuplicate) return;

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
                    const noAlergiRow = document.getElementById('no-alergi-row');

                    if (!tbody || !noAlergiRow) return;

                    const existingRows = tbody.querySelectorAll('tr:not(#no-alergi-row)');
                    existingRows.forEach(row => row.remove());

                    if (this.alergiDataArray.length === 0) {
                        noAlergiRow.style.display = 'table-row';
                    } else {
                        noAlergiRow.style.display = 'none';

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
                },

                resetAlergiForm() {
                    const fields = ['modal_jenis_alergi', 'modal_alergen', 'modal_reaksi',
                        'modal_tingkat_keparahan'
                    ];
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
                    switch (keparahan.toLowerCase()) {
                        case 'ringan':
                            return 'bg-success';
                        case 'sedang':
                            return 'bg-warning';
                        case 'berat':
                            return 'bg-danger';
                        default:
                            return 'bg-secondary';
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

            // ===================================================================
            // 11. MODUL GCS
            // ===================================================================
            // Fungsi global untuk GCS
            const GCSModule = {
                init() {
                    this.loadExistingGCSData();
                    this.initEventListeners();
                },

                loadExistingGCSData() {
                    // Load data GCS yang sudah ada
                    @if(isset($asesmen->gcs_parsed))
                        const gcsData = @json($asesmen->gcs_parsed);

                        if (gcsData.eye) {
                            document.querySelector(`input[name="gcs_eye"][value="${gcsData.eye}"]`)?.setAttribute('checked', 'checked');
                            document.getElementById('gcs_eye_display').textContent = gcsData.eye;
                        }

                        if (gcsData.verbal) {
                            document.querySelector(`input[name="gcs_verbal"][value="${gcsData.verbal}"]`)?.setAttribute('checked', 'checked');
                            document.getElementById('gcs_verbal_display').textContent = gcsData.verbal;
                        }

                        if (gcsData.motor) {
                            document.querySelector(`input[name="gcs_motor"][value="${gcsData.motor}"]`)?.setAttribute('checked', 'checked');
                            document.getElementById('gcs_motor_display').textContent = gcsData.motor;
                        }

                        if (gcsData.total) {
                            const gcsDisplay = document.getElementById('gcs_display');
                            if (gcsDisplay) {
                                gcsDisplay.value = `${gcsData.total} E${gcsData.eye} V${gcsData.verbal} M${gcsData.motor}`;
                            }

                            const gcsValue = document.getElementById('gcs_value');
                            if (gcsValue) {
                                gcsValue.value = `${gcsData.total} E${gcsData.eye} V${gcsData.verbal} M${gcsData.motor}`;
                            }

                            this.updateGCSTotal();
                        }
                    @endif
                },

                initEventListeners() {
                    document.querySelectorAll('.gcs-check').forEach(check => {
                        check.addEventListener('change', () => this.updateGCSTotal());
                    });

                    const simpanGCS = document.getElementById('simpanGCS');
                    if (simpanGCS) {
                        simpanGCS.addEventListener('click', () => this.saveGCSData());
                    }
                },

                updateGCSTotal() {
                    const eyeChecked = document.querySelector('input[name="gcs_eye"]:checked');
                    const verbalChecked = document.querySelector('input[name="gcs_verbal"]:checked');
                    const motorChecked = document.querySelector('input[name="gcs_motor"]:checked');

                    const eyeValue = eyeChecked ? parseInt(eyeChecked.value) : 0;
                    const verbalValue = verbalChecked ? parseInt(verbalChecked.value) : 0;
                    const motorValue = motorChecked ? parseInt(motorChecked.value) : 0;

                    const total = eyeValue + verbalValue + motorValue;

                    // Update displays
                    document.getElementById('gcs_eye_display').textContent = eyeValue || '-';
                    document.getElementById('gcs_verbal_display').textContent = verbalValue || '-';
                    document.getElementById('gcs_motor_display').textContent = motorValue || '-';

                    const totalDisplay = document.getElementById('gcs_total_display');
                    const interpretation = document.getElementById('gcs_interpretation');

                    if (total > 0) {
                        totalDisplay.innerHTML = `<strong>Total: ${total}</strong>`;

                        let interpretationText = '';
                        if (total >= 13) {
                            interpretationText = 'Cedera kepala ringan';
                            interpretation.className = 'alert alert-success mb-0';
                        } else if (total >= 9) {
                            interpretationText = 'Cedera kepala sedang';
                            interpretation.className = 'alert alert-warning mb-0';
                        } else {
                            interpretationText = 'Cedera kepala berat';
                            interpretation.className = 'alert alert-danger mb-0';
                        }

                        interpretation.textContent = interpretationText;
                    } else {
                        totalDisplay.innerHTML = '<strong>Total: - </strong>';
                        interpretation.textContent = 'Pilih semua komponen';
                        interpretation.className = 'alert alert-secondary mb-0';
                    }
                },

                saveGCSData() {
                    const eyeChecked = document.querySelector('input[name="gcs_eye"]:checked');
                    const verbalChecked = document.querySelector('input[name="gcs_verbal"]:checked');
                    const motorChecked = document.querySelector('input[name="gcs_motor"]:checked');

                    if (!eyeChecked || !verbalChecked || !motorChecked) {
                        alert('Harap pilih semua komponen GCS');
                        return;
                    }

                    const eyeValue = eyeChecked.value;
                    const verbalValue = verbalChecked.value;
                    const motorValue = motorChecked.value;
                    const total = parseInt(eyeValue) + parseInt(verbalValue) + parseInt(motorValue);

                    const gcsString = `${total} E${eyeValue} V${verbalValue} M${motorValue}`;

                    // Update form fields
                    const gcsDisplay = document.getElementById('gcs_display');
                    const gcsValue = document.getElementById('gcs_value');

                    if (gcsDisplay) gcsDisplay.value = gcsString;
                    if (gcsValue) gcsValue.value = gcsString;

                    // Close modal
                    const modal = document.getElementById('gcsModal');
                    if (modal) {
                        bootstrap.Modal.getInstance(modal).hide();
                    }
                }
            };

            // ===================================================================
            // 11. MODUL DIAGNOSIS KEPERAWATAN
            // ===================================================================

            const DiagnosisKeperawatanModule = {
                init() {
                    this.loadExistingData();
                    this.initEventListeners();
                },

                loadExistingData() {
                    // Load masalah diagnosis
                    @if(isset($asesmen->masalah_diagnosis_parsed) && !empty($asesmen->masalah_diagnosis_parsed))
                        const masalahData = @json($asesmen->masalah_diagnosis_parsed);
                        this.populateMasalahDiagnosis(masalahData);
                    @endif

                    // Load intervensi rencana
                    @if(isset($asesmen->intervensi_rencana_parsed) && !empty($asesmen->intervensi_rencana_parsed))
                        const intervensiData = @json($asesmen->intervensi_rencana_parsed);
                        this.populateIntervensiRencana(intervensiData);
                    @endif
                },

                populateMasalahDiagnosis(data) {
                    const container = document.getElementById('masalahContainer');
                    if (!container || !data.length) return;

                    // Clear existing items
                    container.innerHTML = '';

                    data.forEach((item, index) => {
                        const masalahItem = this.createMasalahItem(item, index > 0);
                        container.appendChild(masalahItem);
                    });
                },

                populateIntervensiRencana(data) {
                    const container = document.getElementById('intervensiContainer');
                    if (!container || !data.length) return;

                    // Clear existing items
                    container.innerHTML = '';

                    data.forEach((item, index) => {
                        const intervensiItem = this.createIntervensiItem(item, index > 0);
                        container.appendChild(intervensiItem);
                    });
                },

                createMasalahItem(value = '', showRemove = false) {
                    const div = document.createElement('div');
                    div.className = 'masalah-item mb-2';

                    div.innerHTML = `
                        <div class="d-flex gap-2">
                            <textarea class="form-control" name="masalah_diagnosis[]" rows="2"
                                placeholder="Tuliskan masalah atau diagnosis keperawatan...">${value}</textarea>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-masalah"
                                onclick="DiagnosisKeperawatanModule.removeMasalah(this)"
                                style="display: ${showRemove ? 'block' : 'none'};">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;

                    return div;
                },

                createIntervensiItem(value = '', showRemove = false) {
                    const div = document.createElement('div');
                    div.className = 'intervensi-item mb-2';

                    div.innerHTML = `
                        <div class="d-flex gap-2">
                            <textarea class="form-control" name="intervensi_rencana[]" rows="3"
                                placeholder="Tuliskan intervensi, rencana asuhan, dan target yang terukur...">${value}</textarea>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-intervensi"
                                onclick="DiagnosisKeperawatanModule.removeIntervensi(this)"
                                style="display: ${showRemove ? 'block' : 'none'};">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;

                    return div;
                },

                initEventListeners() {
                    // Button tambah masalah
                    const btnTambahMasalah = document.getElementById('btnTambahMasalah');
                    if (btnTambahMasalah) {
                        btnTambahMasalah.addEventListener('click', () => {
                            this.addMasalahItem();
                        });
                    }

                    // Button tambah intervensi
                    const btnTambahIntervensi = document.getElementById('btnTambahIntervensi');
                    if (btnTambahIntervensi) {
                        btnTambahIntervensi.addEventListener('click', () => {
                            this.addIntervensiItem();
                        });
                    }
                },

                addMasalahItem() {
                    const container = document.getElementById('masalahContainer');
                    if (!container) return;

                    const masalahItem = this.createMasalahItem('', true);
                    container.appendChild(masalahItem);

                    // Update visibility of remove buttons
                    this.updateRemoveButtonsVisibility('masalah');
                },

                addIntervensiItem() {
                    const container = document.getElementById('intervensiContainer');
                    if (!container) return;

                    const intervensiItem = this.createIntervensiItem('', true);
                    container.appendChild(intervensiItem);

                    // Update visibility of remove buttons
                    this.updateRemoveButtonsVisibility('intervensi');
                },

                removeMasalah(button) {
                    const masalahItem = button.closest('.masalah-item');
                    if (masalahItem) {
                        masalahItem.remove();
                        this.updateRemoveButtonsVisibility('masalah');
                    }
                },

                removeIntervensi(button) {
                    const intervensiItem = button.closest('.intervensi-item');
                    if (intervensiItem) {
                        intervensiItem.remove();
                        this.updateRemoveButtonsVisibility('intervensi');
                    }
                },

                updateRemoveButtonsVisibility(type) {
                    const container = document.getElementById(type === 'masalah' ? 'masalahContainer' : 'intervensiContainer');
                    if (!container) return;

                    const items = container.querySelectorAll(`.${type}-item`);
                    items.forEach((item, index) => {
                        const removeBtn = item.querySelector(`.remove-${type}`);
                        if (removeBtn) {
                            removeBtn.style.display = items.length > 1 ? 'block' : 'none';
                        }
                    });
                }
            };


            // ===================================================================
            // 10. FUNGSI GLOBAL
            // ===================================================================


            // Fungsi global untuk risiko jatuh
            window.showForm = function(formType) {
                FallRiskModule.showForm(formType);
            };

            window.updateConclusion = function(formType) {
                FallRiskModule.updateConclusion(formType);
            };

            // Fungsi global untuk dekubitus
            window.showDecubitusForm = function(formType) {
                DecubitusRiskModule.showDecubitusForm(formType);
            };

            window.updateDecubitusConclusion = function(formType) {
                DecubitusRiskModule.updateDecubitusConclusion(formType);
            };

            // Fungsi global untuk status psikologis
            window.removeItem = function(containerId, item) {
                const container = document.getElementById(containerId);
                if (!container) return;

                // Uncheck checkbox yang sesuai
                if (containerId === 'selectedKondisiPsikologis') {
                    document.querySelectorAll('.kondisi-options input[type="checkbox"]').forEach(checkbox => {
                        if (checkbox.value === item) {
                            checkbox.checked = false;
                            checkbox.dispatchEvent(new Event('change'));
                        }
                    });
                } else if (containerId === 'selectedGangguanPerilaku') {
                    document.querySelectorAll('.perilaku-options input[type="checkbox"]').forEach(checkbox => {
                        if (checkbox.value === item) {
                            checkbox.checked = false;
                            checkbox.dispatchEvent(new Event('change'));
                        }
                    });
                }
            };

            // Fungsi helper untuk dekubitus
            window.getRiskConclusion = function(totalScore) {
                // Implementasi berdasarkan logik yang ada di controller
                if (totalScore <= 12) {
                    return 'Risiko Tinggi (Skor: ' + totalScore + ')';
                } else if (totalScore <= 16) {
                    return 'Risiko Sedang (Skor: ' + totalScore + ')';
                } else {
                    return 'Risiko Rendah (Skor: ' + totalScore + ')';
                }
            };

            window.removeMasalah = function(button) {
                DiagnosisKeperawatanModule.removeMasalah(button);
            };

            window.removeIntervensi = function(button) {
                DiagnosisKeperawatanModule.removeIntervensi(button);
            };

            // ===================================================================
            // INISIALISASI SEMUA MODUL
            // ===================================================================

            BasicModule.init();
            PainScaleModule.init();
            FallRiskModule.init();
            DecubitusRiskModule.init();
            PsychologicalStatusModule.init();
            NutritionModule.init();
            FunctionalStatusModule.init();
            DischargePlanningModule.init();
            PenyakitModule.init();
            AllergyModule.init();
            GCSModule.init();
            DiagnosisKeperawatanModule.init();

            console.log('Asesmen Keperawatan Anak - JavaScript modules initialized successfully');
        });

        // 13. MASALAH/ DIAGNOSIS KEPERAWATAN

        function toggleRencana(diagnosisType) {
            // Handle special case for respiratory group (3 diagnosis yang menggunakan 1 rencana)
            const respiratoryGroup = ['bersihan_jalan_nafas', 'risiko_aspirasi', 'pola_nafas_tidak_efektif'];

            if (respiratoryGroup.includes(diagnosisType)) {
                // Check if any of the 3 respiratory checkboxes is checked
                const anyRespChecked = respiratoryGroup.some(diagnosis => {
                    const checkbox = document.getElementById('diag_' + diagnosis);
                    return checkbox && checkbox.checked;
                });

                const rencanaDiv = document.getElementById('rencana_bersihan_jalan_nafas');
                if (rencanaDiv) {
                    if (anyRespChecked) {
                        rencanaDiv.style.display = 'block';
                    } else {
                        rencanaDiv.style.display = 'none';
                        // Uncheck all rencana checkboxes when no respiratory diagnosis is checked
                        const rencanaCheckboxes = rencanaDiv.querySelectorAll('input[type="checkbox"]');
                        rencanaCheckboxes.forEach(cb => cb.checked = false);
                    }
                }
            } else {
                // Handle normal case (1 diagnosis = 1 rencana)
                const checkbox = document.getElementById('diag_' + diagnosisType);
                const rencanaDiv = document.getElementById('rencana_' + diagnosisType);

                if (checkbox && rencanaDiv) {
                    if (checkbox.checked) {
                        rencanaDiv.style.display = 'block';
                    } else {
                        rencanaDiv.style.display = 'none';
                        // Uncheck all rencana checkboxes when diagnosis is unchecked
                        const rencanaCheckboxes = rencanaDiv.querySelectorAll('input[type="checkbox"]');
                        rencanaCheckboxes.forEach(cb => cb.checked = false);
                    }
                }
            }
        }

        // KODE BARU: Initialize untuk mode EDIT - tampilkan rencana yang sudah tercentang
        document.addEventListener('DOMContentLoaded', function() {
            // Daftar semua diagnosis
            const allDiagnosis = [
                'bersihan_jalan_nafas',
                'risiko_aspirasi',
                'pola_nafas_tidak_efektif',
                'penurunan_curah_jantung',
                'perfusi_perifer',
                'hipovolemia',
                'hipervolemia',
                'diare',
                'retensi_urine',
                'nyeri_akut',
                'nyeri_kronis',
                'hipertermia',
                'gangguan_mobilitas_fisik',
                'resiko_infeksi',
                'konstipasi',
                'resiko_jatuh',
                'gangguan_integritas_kulit'
            ];

            // Loop semua diagnosis dan trigger toggleRencana jika checkbox sudah tercentang
            allDiagnosis.forEach(diagnosis => {
                const checkbox = document.getElementById('diag_' + diagnosis);
                if (checkbox && checkbox.checked) {
                    toggleRencana(diagnosis);
                }
            });
        });
    </script>
@endpush
