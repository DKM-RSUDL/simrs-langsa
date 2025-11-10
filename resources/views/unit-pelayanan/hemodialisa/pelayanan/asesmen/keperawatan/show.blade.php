@extends('layouts.administrator.master')

@section('content')
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

            /* Optional: Styling untuk tombol aktif */
            .tambah-keterangan.active {
                background-color: #0d6efd;
                color: white;
            }
        </style>
    @endpush


    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-hemodialisa')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Asesmen Keperawatan',
                    'description' =>
                        'Detail data asesmen keperawatan pasien hemodialisa di unit pelayanan hemodialisa.',
                ])

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100">
                        <div class="card-body">
                            <div class="px-3">

                                {{-- FORM ASESMEN AWAL KEPERATAWAN --}}

                                <div class="px-3">
                                    <div>
                                        <div class="section-separator">
                                            <h5 class="section-title">1. Anamnesis</h5>

                                            @if ($asesmen->keperawatan)
                                                <div class="form-group">
                                                    <label for="anamnesis" style="min-width: 200px;">Anamnesis</label>
                                                    <textarea name="anamnesis" id="anamnesis" class="form-control" disabled>{{ $asesmen->keperawatan->anamnesis ?? 'Tidak ada data' }}</textarea>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    Tidak ada data anamnesis yang tersedia.
                                                </div>
                                            @endif
                                        </div>

                                        <div class="section-separator">
                                            <h5 class="section-title">2. Pemeriksaan Fisik</h5>

                                            @if ($asesmen->keperawatanPemeriksaanFisik)
                                                <div class="form-group align-items-center mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">Tek. Darah
                                                        (mmHg)</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="form-label">Sistole</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $asesmen->keperawatanPemeriksaanFisik->fisik_sistole ?? '-' }}"
                                                                disabled>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label">Diastole</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $asesmen->keperawatanPemeriksaanFisik->fisik_diastole ?? '-' }}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">Nadi (Per
                                                        Menit)</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatanPemeriksaanFisik->fisik_nadi ?? '-' }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">Nafas (Per
                                                        Menit)</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatanPemeriksaanFisik->fisik_nafas ?? '-' }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">Suhu (C)</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatanPemeriksaanFisik->fisik_suhu ?? '-' }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group align-items-center mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">Saturasi Oksigen
                                                        (%)</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="form-label">Tanpa bantuan O2</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $asesmen->keperawatanPemeriksaanFisik->so_tb_o2 ?? '-' }}"
                                                                disabled>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label">Dengan bantuan O2</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $asesmen->keperawatanPemeriksaanFisik->so_db_o2 ?? '-' }}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">AVPU</label>
                                                    <input type="text" class="form-control"
                                                        value="@if ($asesmen->keperawatanPemeriksaanFisik->avpu == '0') Sadar Baik/Alert: 0
                                                        @elseif($asesmen->keperawatanPemeriksaanFisik->avpu == '1') Berespon dengan kata-kata/Voice: 1
                                                        @elseif($asesmen->keperawatanPemeriksaanFisik->avpu == '2') Hanya berespons jika dirangsang nyeri/Pain: 2
                                                        @elseif($asesmen->keperawatanPemeriksaanFisik->avpu == '3') Pasien tidak sadar/Unresponsive: 3
                                                        @elseif($asesmen->keperawatanPemeriksaanFisik->avpu == '4') Gelisah atau bingung: 4
                                                        @elseif($asesmen->keperawatanPemeriksaanFisik->avpu == '5') Acute Confusional States: 5
                                                        @else - @endif"
                                                        disabled>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">Edema</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatanPemeriksaanFisik->edema == '0' ? 'Tidak' : ($asesmen->keperawatanPemeriksaanFisik->edema == '1' ? 'Ya' : '-') }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">Konjungtiva</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatanPemeriksaanFisik->konjungtiva == '0' ? 'Tidak Anemis' : ($asesmen->keperawatanPemeriksaanFisik->konjungtiva == '1' ? 'Anemis' : '-') }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">Dehidrasi</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatanPemeriksaanFisik->dehidrasi == '0' ? 'Tidak' : ($asesmen->keperawatanPemeriksaanFisik->dehidrasi == '1' ? 'Ya' : '-') }}"
                                                        disabled>
                                                </div>

                                                <p class="fw-bold">Antropometri</p>

                                                <div class="form-group mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">Tinggi Badan
                                                        (Cm)</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatanPemeriksaanFisik->tinggi_badan ?? '-' }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">Berat Badan
                                                        (Kg)</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatanPemeriksaanFisik->berat_badan ?? '-' }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">Index Massa Tubuh
                                                        (IMT)</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatanPemeriksaanFisik->imt ?? '-' }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">Luas Permukaan Tubuh
                                                        (LPT)</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatanPemeriksaanFisik->lpt ?? '-' }}"
                                                        disabled>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    Tidak ada data pemeriksaan fisik yang tersedia.
                                                </div>
                                            @endif

                                            <div class="row g-3">
                                                <div class="pemeriksaan-fisik">
                                                    <h6>Pemeriksaan Fisik</h6>
                                                    <p class="text-small">Centang normal jika fisik yang dinilai
                                                        normal,
                                                        pilih tanda tambah
                                                        untuk menambah keterangan fisik yang ditemukan tidak normal.
                                                        Jika
                                                        tidak dipilih salah satunya, maka pemeriksaan tidak
                                                        dilakukan.
                                                    </p>
                                                    <div class="row">
                                                        @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                            <div class="col-md-6">
                                                                <div class="d-flex flex-column gap-3">
                                                                    @foreach ($chunk as $item)
                                                                        @php
                                                                            // Cari data pemeriksaan fisik untuk item ini
                                                                            $pemeriksaanData = $asesmen->pemeriksaanFisik
                                                                                ->where('id_item_fisik', $item->id)
                                                                                ->first();
                                                                            $keterangan = '';
                                                                            $isNormal = true;

                                                                            if ($pemeriksaanData) {
                                                                                $keterangan =
                                                                                    $pemeriksaanData->keterangan;
                                                                                $isNormal = empty($keterangan);
                                                                            }
                                                                        @endphp
                                                                        <div class="pemeriksaan-item">
                                                                            <div
                                                                                class="d-flex align-items-center border-bottom pb-2">
                                                                                <div class="flex-grow-1">
                                                                                    {{ $item->nama }}
                                                                                </div>
                                                                                <div class="form-check me-3">
                                                                                    <input disabled type="checkbox"
                                                                                        class="form-check-input"
                                                                                        id="{{ $item->id }}-normal"
                                                                                        name="{{ $item->id }}-normal"
                                                                                        {{ $isNormal ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                        for="{{ $item->id }}-normal">Normal</label>
                                                                                </div>

                                                                            </div>
                                                                            <div class="keterangan mt-2"
                                                                                id="{{ $item->id }}-keterangan"
                                                                                style="display:{{ $isNormal ? 'none' : 'block' }};">
                                                                                <input disabled type="text"
                                                                                    class="form-control"
                                                                                    name="{{ $item->id }}_keterangan"
                                                                                    placeholder="Tambah keterangan jika tidak normal..."
                                                                                    value="{{ $keterangan }}">
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

                                        <div class="section-separator">
                                            <h5 class="section-title">3. Status Nyeri</h5>

                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Jenis Skala Nyeri</label>
                                                <input type="text" class="form-control" value="Scale NRS, VAS, VRS"
                                                    disabled>
                                            </div>

                                            <div class="form-group justify-content-center mb-3">
                                                <img src="{{ asset('assets/img/cppt/cppt.jpeg') }}" alt="Skala Nyeri"
                                                    class="w-50">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Nilai Skala Nyeri</label>

                                                @if ($asesmen->keperawatan)
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatan->status_skala_nyeri ?? 'Tidak ada data' }}"
                                                        disabled>
                                                @else
                                                    <input type="text" class="form-control" value="Tidak ada data"
                                                        disabled>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="section-separator">
                                            <h5 class="section-title">4. Riwayat Kesehatan</h5>

                                            @if ($asesmen->keperawatan)
                                                <div class="form-group mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">Gagal Ginjal
                                                        Stadium</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatan->gagal_ginjal_stadium ?? 'Tidak ada data' }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">Jenis Gagal
                                                        Ginjal</label>
                                                    <input type="text" class="form-control"
                                                        value="@if ($asesmen->keperawatan->jenis_gagal_ginjal == 'akut') Akut
                                                        @elseif($asesmen->keperawatan->jenis_gagal_ginjal == 'kronis') Kronis
                                                        @elseif($asesmen->keperawatan->jenis_gagal_ginjal == 'lainnya') Lainnya
                                                        @else Tidak ada data @endif"
                                                        disabled>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">Lama Menjalani
                                                        HD</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control"
                                                                value="{{ $asesmen->keperawatan->lama_menjalani_hd ?? 'Tidak ada data' }}"
                                                                disabled>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control"
                                                                value="{{ $asesmen->keperawatan->lama_menjalani_hd_unit ?? 'Tidak ada data' }}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">Jadwal HD
                                                        Rutin</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control"
                                                                value="{{ $asesmen->keperawatan->jadwal_hd_rutin ?? 'Tidak ada data' }}"
                                                                disabled>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control"
                                                                value="{{ $asesmen->keperawatan->jadwal_hd_rutin_unit ?? 'Tidak ada data' }}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label style="min-width: 200px;" class="fw-bold">Sesak Nafas/Nyeri
                                                        Dada</label>
                                                    <input type="text" class="form-control"
                                                        value="@if ($asesmen->keperawatan->sesak_nafas == 'ya') Ya
                                                        @elseif($asesmen->keperawatan->sesak_nafas == 'tidak') Tidak
                                                        @else Tidak ada data @endif"
                                                        disabled>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    Tidak ada data riwayat kesehatan yang tersedia.
                                                </div>
                                            @endif
                                        </div>

                                        {{-- <div class="section-separator">
                                            <h5 class="section-title">5. Riwayat Obat dan Rekomendasi Dokter</h5>

                                            @if ($asesmen->keperawatan)
                                                <!-- Riwayat penggunaan obat pada pasien -->
                                                <div class="mb-4">
                                                    <p class="fw-bold mb-2">Riwayat penggunaan obat pada pasien</p>

                                                    @if ($asesmen->keperawatan->obat_pasien)
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="33%">Nama Obat</th>
                                                                        <th width="33%">Dosis</th>
                                                                        <th width="33%">Waktu penggunaan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $obatPasien = json_decode($asesmen->keperawatan->obat_pasien, true);
                                                                    @endphp

                                                                    @if (is_array($obatPasien) && count($obatPasien) > 0)
                                                                        @foreach ($obatPasien as $obat)
                                                                            <tr>
                                                                                <td>{{ $obat['nama'] ?? '-' }}</td>
                                                                                <td>{{ $obat['dosis'] ?? '-' }}</td>
                                                                                <td>{{ $obat['waktu'] ?? '-' }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr>
                                                                            <td colspan="3" class="text-center">Tidak ada data obat pasien</td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @else
                                                        <div class="alert alert-info">
                                                            Tidak ada data riwayat penggunaan obat pasien.
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Obat tambahan dokter -->
                                                <div class="mb-4">
                                                    <p class="fw-bold mb-2">Obat tambahan dokter</p>

                                                    @if ($asesmen->keperawatan->obat_dokter)
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="33%">Nama Obat</th>
                                                                        <th width="33%">Dosis</th>
                                                                        <th width="33%">Waktu penggunaan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $obatDokter = json_decode($asesmen->keperawatan->obat_dokter, true);
                                                                    @endphp

                                                                    @if (is_array($obatDokter) && count($obatDokter) > 0)
                                                                        @foreach ($obatDokter as $obat)
                                                                            <tr>
                                                                                <td>{{ $obat['nama'] ?? '-' }}</td>
                                                                                <td>{{ $obat['dosis'] ?? '-' }}</td>
                                                                                <td>{{ $obat['waktu'] ?? '-' }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr>
                                                                            <td colspan="3" class="text-center">Tidak ada data obat tambahan dokter</td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @else
                                                        <div class="alert alert-info">
                                                            Tidak ada data obat tambahan dokter.
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    Tidak ada data riwayat obat dan rekomendasi dokter.
                                                </div>
                                            @endif
                                        </div> --}}

                                        <div class="section-separator">
                                            <h5 class="section-title">5. Pemeriksaan Penunjang</h5>

                                            @if ($asesmen->keperawatanPempen)
                                                <!-- Pre Hemodialisis -->
                                                <div class="mb-4">
                                                    <p class="fw-bold mb-3">Pre Hemodialisis</p>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">EKG</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control"
                                                                value="{{ $asesmen->keperawatanPempen->pre_ekg ?? 'Tidak ada data' }}"
                                                                disabled>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label
                                                            class="col-sm-2 col-form-label text-end fw-bold">Rontgent</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control"
                                                                value="{{ $asesmen->keperawatanPempen->pre_rontgent ?? 'Tidak ada data' }}"
                                                                disabled>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">USG</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control"
                                                                value="{{ $asesmen->keperawatanPempen->pre_usg ?? 'Tidak ada data' }}"
                                                                disabled>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Dll</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control"
                                                                value="{{ $asesmen->keperawatanPempen->pre_dll ?? 'Tidak ada data' }}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Post Hemodialisis -->
                                                <div class="mb-4">
                                                    <p class="fw-bold mb-3">Post Hemodialisis</p>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">EKG</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control"
                                                                value="{{ $asesmen->keperawatanPempen->post_ekg ?? 'Tidak ada data' }}"
                                                                disabled>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label
                                                            class="col-sm-2 col-form-label text-end fw-bold">Rontgent</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control"
                                                                value="{{ $asesmen->keperawatanPempen->post_rontgent ?? 'Tidak ada data' }}"
                                                                disabled>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">USG</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control"
                                                                value="{{ $asesmen->keperawatanPempen->post_usg ?? 'Tidak ada data' }}"
                                                                disabled>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Dll</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control"
                                                                value="{{ $asesmen->keperawatanPempen->post_dll ?? 'Tidak ada data' }}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    Tidak ada data pemeriksaan penunjang yang tersedia.
                                                </div>
                                            @endif
                                        </div>

                                        <div class="section-separator" id="alergi">
                                            <h5 class="section-title">6. Alergi</h5>

                                            @if ($asesmen->keperawatan && $asesmen->keperawatan->alergi)
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Alergen</th>
                                                                <th>Reaksi</th>
                                                                <th>Severe</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $alergiData = json_decode(
                                                                    $asesmen->keperawatan->alergi,
                                                                    true,
                                                                );
                                                            @endphp
                                                            @if (is_array($alergiData) && count($alergiData) > 0)
                                                                @foreach ($alergiData as $alergi)
                                                                    <tr>
                                                                        <td>{{ $alergi['alergen'] ?? '-' }}</td>
                                                                        <td>{{ $alergi['reaksi'] ?? '-' }}</td>
                                                                        <td>{{ $alergi['severe'] ?? '-' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="3" class="text-center">Tidak ada data
                                                                        alergi</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    Tidak ada data alergi yang tersedia.
                                                </div>
                                            @endif
                                        </div>

                                        <div class="section-separator">
                                            <h5 class="section-title">7. Status Gizi</h5>

                                            @if ($asesmen->keperawatanStatusGizi)
                                                <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label fw-bold">Tanggal
                                                        Pengkajian</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                            value="{{ $asesmen->keperawatanStatusGizi->gizi_tanggal_pengkajian ? \Carbon\Carbon::parse($asesmen->keperawatanStatusGizi->gizi_tanggal_pengkajian)->format('d-m-Y H:i') : '-' }}"
                                                            disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label fw-bold">Skore MIS</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                            value="{{ $asesmen->keperawatanStatusGizi->gizi_skore_mis ?? '-' }}"
                                                            disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label fw-bold">Kesimpulan</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                            value="{{ $asesmen->keperawatanStatusGizi->gizi_kesimpulan ?? '-' }}"
                                                            disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label fw-bold">Rencana Pengkajian Ulang
                                                        MIS</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                            value="{{ $asesmen->keperawatanStatusGizi->gizi_rencana_pengkajian ?? '-' }}"
                                                            disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label fw-bold">Rekomendasi</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                            value="{{ $asesmen->keperawatanStatusGizi->gizi_rekomendasi ?? '-' }}"
                                                            disabled>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    Tidak ada data status gizi yang tersedia.
                                                </div>
                                            @endif
                                        </div>

                                        <div class="section-separator">
                                            <h5 class="section-title">8. Risiko Jatuh</h5>

                                            <h6 class="mt-3 mb-3">Penilaian Risiko Jatuh Skala Morse</h6>

                                            @if ($asesmen->keperawatanRisikoJatuh)
                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold">Riwayat jatuh yang baru atau dalam
                                                        bulan terakhir</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatanRisikoJatuh->riwayat_jatuh ?? '-' }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold">Pasien memiliki Diagnosa medis
                                                        sekunder > 1 ?</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatanRisikoJatuh->diagnosa_sekunder ?? '-' }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold">Pasien membutuhkan bantuan Alat bantu
                                                        jalan ?</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatanRisikoJatuh->alat_bantu ?? '-' }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold">Pasien terpasang infus?</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatanRisikoJatuh->infus ?? '-' }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold">Bagaimana cara berjalan
                                                        pasien?</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatanRisikoJatuh->cara_berjalan ?? '-' }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold">Bagaimana status mental
                                                        pasien?</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $asesmen->keperawatanRisikoJatuh->status_mental ?? '-' }}"
                                                        disabled>
                                                </div>

                                                <div class="alert alert-info mt-4 mb-3">
                                                    <strong>Total Skor: </strong>
                                                    <span>{{ $asesmen->keperawatanRisikoJatuh->risiko_jatuh_skor ?? '-' }}</span>
                                                </div>

                                                <div class="alert alert-primary">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <strong>Kesimpulan: </strong>
                                                        <span>{{ $asesmen->keperawatanRisikoJatuh->risiko_jatuh_kesimpulan ?? '-' }}</span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    Tidak ada data risiko jatuh yang tersedia.
                                                </div>
                                            @endif
                                        </div>

                                        <div class="section-separator">
                                            <h5 class="section-title">9. Status Psikososial</h5>

                                            @if ($asesmen->keperawatanStatusPsikososial)
                                                <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label fw-bold">Tanggal
                                                        Pengkajian</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                            value="{{ $asesmen->keperawatanStatusPsikososial->tanggal_pengkajian_psiko ? \Carbon\Carbon::parse($asesmen->keperawatanStatusPsikososial->tanggal_pengkajian_psiko)->format('d-m-Y') : '-' }}"
                                                            disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label fw-bold">Kendala
                                                        Komunikasi</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                            value="{{ $asesmen->keperawatanStatusPsikososial->kendala_komunikasi ?? '-' }}"
                                                            disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label fw-bold">Yang Merawat di
                                                        Rumah</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                            value="{{ $asesmen->keperawatanStatusPsikososial->yang_merawat ?? '-' }}"
                                                            disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label fw-bold">Kondisi
                                                        Psikologis</label>
                                                    <div class="col-sm-9">
                                                        @php
                                                            $kondisiPsikologis = $asesmen->keperawatanStatusPsikososial
                                                                ->kondisi_psikologis_json
                                                                ? json_decode(
                                                                    $asesmen->keperawatanStatusPsikososial
                                                                        ->kondisi_psikologis_json,
                                                                    true,
                                                                )
                                                                : [];
                                                        @endphp
                                                        <input type="text" class="form-control"
                                                            value="{{ !empty($kondisiPsikologis) ? implode(', ', $kondisiPsikologis) : '-' }}"
                                                            disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label fw-bold">Apakah
                                                        kepatuhan/keterlibatan pasien berkaitan dengan pelayanan kesehatan
                                                        yang akan diberikan</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                            value="{{ $asesmen->keperawatanStatusPsikososial->kepatuhan_layanan ?? '-' }}"
                                                            disabled>
                                                    </div>
                                                </div>

                                                @if (
                                                    $asesmen->keperawatanStatusPsikososial->kepatuhan_layanan === 'Ya' &&
                                                        $asesmen->keperawatanStatusPsikososial->jika_ya_jelaskan)
                                                    <div class="row mb-3">
                                                        <label class="col-sm-3 col-form-label fw-bold">Jika Iya
                                                            Jelaskan</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control"
                                                                value="{{ $asesmen->keperawatanStatusPsikososial->jika_ya_jelaskan ?? '-' }}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="alert alert-info">
                                                    Tidak ada data status psikososial yang tersedia.
                                                </div>
                                            @endif
                                        </div>

                                        <div class="section-separator">
                                            <h5 class="section-title">10. Monitoring Hemodialisis</h5>

                                            @if ($asesmen->keperawatanMonitoringPreekripsi)
                                                <!-- 1. Preekripsi Hemodialisis -->
                                                <div class="preekripsi__hemodialisis">
                                                    <div class="row mt-3">
                                                        <div class="col-12">
                                                            <h6 class="fw-bold">1. Preskripsi Hemodialisis</h6>
                                                        </div>
                                                    </div>

                                                    <!-- Inisiasi -->
                                                    <div class="inisiasi">
                                                        <div class="row mt-4">
                                                            <div class="col-12 text-center mb-3">
                                                                <h6>Inisiasi</h6>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">HD
                                                                Ke</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control"
                                                                    value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_hd_ke ?? '-' }}"
                                                                    disabled>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Nomor
                                                                Mesin</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control"
                                                                    value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_nomor_mesin ?? '-' }}"
                                                                    disabled>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">BB HD
                                                                Yang Lalu</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_bb_hd_lalu ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">kg</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Tekanan
                                                                Vena</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_tekanan_vena ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">ml/mnt</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Lama
                                                                HD</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_lama_hd ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">Jam</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Program
                                                                Profiling</label>
                                                            <div class="col-sm-10">
                                                                <div class="row mb-2">
                                                                    <div class="col-md-3">
                                                                        <label class="form-check-label">UF Profiling
                                                                            Mode</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_uf_profiling_detail ?? '-' }}"
                                                                            disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-md-3">
                                                                        <label class="form-check-label">Bicarbonat
                                                                            Profiling</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_bicarbonat_profiling_detail ?? '-' }}"
                                                                            disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label class="form-check-label">Na Profiling
                                                                            Mode</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_na_profiling_detail ?? '-' }}"
                                                                            disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Akut -->
                                                    <div class="akut">
                                                        <div class="row mt-5">
                                                            <div class="col-12 text-center mb-3">
                                                                <h6>Akut</h6>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Type
                                                                Dializer</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control"
                                                                    value="{{ $asesmen->keperawatanMonitoringPreekripsi->akut_type_dializer ?? '-' }}"
                                                                    disabled>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">UF
                                                                Goal</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control"
                                                                    value="{{ $asesmen->keperawatanMonitoringPreekripsi->akut_uf_goal ?? '-' }}"
                                                                    disabled>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">BB Pre
                                                                HD</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->akut_bb_pre_hd ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">kg</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Tekanan
                                                                Arteri</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->akut_tekanan_arteri ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">ml/mnt</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">ISO
                                                                UF</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->akut_laju_uf ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">ml</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Lama
                                                                ISO UF</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->akut_lama_laju_uf ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">jam</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Rutin -->
                                                    <div class="rutin">
                                                        <div class="row mt-5">
                                                            <div class="col-12 text-center mb-3">
                                                                <h6>Rutin</h6>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">N/R
                                                                Ke</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control"
                                                                    value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_nr_ke ?? '-' }}"
                                                                    disabled>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">BB
                                                                Kering</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_bb_kering ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">kg</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">BB Post
                                                                HD</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_bb_post_hd ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">kg</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">TMP
                                                                (Transmembrane Pressure)</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_tmp ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">mmHg</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="rutin">
                                                            <div class="row mt-5">
                                                                <div class="col-12 text-center mb-3">
                                                                    <h6>Rutin</h6>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label text-end fw-bold">N/R
                                                                    Ke</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_nr_ke ?? '-' }}"
                                                                        disabled>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label text-end fw-bold">BB
                                                                    Kering</label>
                                                                <div class="col-sm-10">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_bb_kering ?? '-' }}"
                                                                            disabled>
                                                                        <span class="input-group-text">kg</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label text-end fw-bold">BB
                                                                    Post HD</label>
                                                                <div class="col-sm-10">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_bb_post_hd ?? '-' }}"
                                                                            disabled>
                                                                        <span class="input-group-text">kg</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label text-end fw-bold">TMP
                                                                    (Transmembrane Pressure)</label>
                                                                <div class="col-sm-10">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_tmp ?? '-' }}"
                                                                            disabled>
                                                                        <span class="input-group-text">mmHg</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label
                                                                    class="col-sm-2 col-form-label text-end fw-bold">Program
                                                                    Vaskular Aksesbilling</label>
                                                                <div class="col-sm-10">
                                                                    <div class="row mb-2">
                                                                        <div class="col-md-3">
                                                                            <label class="form-check-label">AV
                                                                                Shunt</label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_av_shunt_detail ?? '-' }}"
                                                                                disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <div class="col-md-3">
                                                                            <label class="form-check-label">CDL</label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_cdl_detail ?? '-' }}"
                                                                                disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <label class="form-check-label">Femoral</label>
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_femoral_detail ?? '-' }}"
                                                                                disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Pre Op -->
                                                    <div class="preop">
                                                        <div class="row mt-5">
                                                            <div class="col-12 text-center mb-3">
                                                                <h6>Pre Op</h6>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label
                                                                class="col-sm-2 col-form-label text-end fw-bold">Dialisat</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control"
                                                                    value="{{ $asesmen->keperawatanMonitoringPreekripsi->preop_dialisat ?? ($asesmen->keperawatanMonitoringPreekripsi->preop_bicarbonat ?? '-') }}"
                                                                    disabled>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-2"></div>
                                                            <div class="col-sm-4">
                                                                <label class="form-check-label">Conductivity</label>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->preop_conductivity ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">MS/Cm</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-2"></div>
                                                            <div class="col-sm-4">
                                                                <label class="form-check-label">Kalium</label>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->preop_kalium ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">MEq/L</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-2"></div>
                                                            <div class="col-sm-4">
                                                                <label class="form-check-label">Suhu Dialisat</label>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->preop_suhu_dialisat ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">°C</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-2"></div>
                                                            <div class="col-sm-4">
                                                                <label class="form-check-label">Base Na</label>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->preop_base_na ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">MEq/L</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    Tidak ada data monitoring hemodialisis yang tersedia.
                                                </div>
                                            @endif

                                            <!-- 2. Heparinisasi -->
                                            <div class="heparinisasi">
                                                <div class="row mt-5">
                                                    <div class="col-12 mb-3">
                                                        <h6 class="fw-bold">2. Heparinisasi</h6>
                                                    </div>
                                                </div>

                                                @if ($asesmen->keperawatanMonitoringHeparinisasi)
                                                    <div class="row">
                                                        <div class="col-sm-2">
                                                            <label class="col-form-label fw-bold">Heparinisasi</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <!-- Row 1: Dosis Sirkulasi dan Dosis Awal -->
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Dosis
                                                                        Sirkulasi</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $asesmen->keperawatanMonitoringHeparinisasi->dosis_sirkulasi ?? '-' }}"
                                                                            disabled>
                                                                        <span class="input-group-text">IU</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Dosis Awal</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $asesmen->keperawatanMonitoringHeparinisasi->dosis_awal ?? '-' }}"
                                                                            disabled>
                                                                        <span class="input-group-text">IU</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Row 2: Maintenance Kontinyu dan Maintenance Intermiten -->
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Maintenance
                                                                        Kontinyu</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $asesmen->keperawatanMonitoringHeparinisasi->maintenance_kontinyu ?? '-' }}"
                                                                            disabled>
                                                                        <span class="input-group-text">IU/jam</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Maintenance
                                                                        Intermiten</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $asesmen->keperawatanMonitoringHeparinisasi->maintenance_intermiten ?? '-' }}"
                                                                            disabled>
                                                                        <span class="input-group-text">IU/jam</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Row 3: Tanpa Heparin dan LMWH -->
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Tanpa Heparin
                                                                        (sc.)</label>
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringHeparinisasi->tanpa_heparin ?? '-' }}"
                                                                        disabled>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">LMWH</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $asesmen->keperawatanMonitoringHeparinisasi->lmwh ?? '-' }}"
                                                                            disabled>
                                                                        <span class="input-group-text">IU</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Row 4: Program Bilas NaCl -->
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <label class="form-label fw-bold">Program Bilas NaCl
                                                                        0,9% 100cc/Jam</label>
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringHeparinisasi->program_bilas_nacl ?? '-' }}"
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="alert alert-info">
                                                        Tidak ada data heparinisasi yang tersedia.
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- 3. Tindakan Keperawatan -->
                                            <div class="tindakan__keperawatan">
                                                <div class="row mt-5">
                                                    <div class="col-12 mb-3">
                                                        <h6 class="fw-bold">3. Tindakan Keperawatan</h6>
                                                    </div>
                                                </div>

                                                @if ($asesmen->keperawatanMonitoringTindakan)
                                                    <!-- Pre HD -->
                                                    <div class="preHD">
                                                        <div class="row mt-3">
                                                            <div class="col-12 mb-2">
                                                                <h6 class="fw-bold">Pra HD</h6>
                                                            </div>
                                                        </div>

                                                        <!-- Waktu Pre HD -->
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Waktu
                                                                Pra HD</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control"
                                                                    value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_waktu_pre_hd ? \Carbon\Carbon::parse($asesmen->keperawatanMonitoringTindakan->prehd_waktu_pre_hd)->format('H:i') : '-' }}"
                                                                    disabled>
                                                            </div>
                                                        </div>

                                                        <!-- Parameter Mesin HD (QB dan QD) -->
                                                        <div class="row mb-3">
                                                            <label
                                                                class="col-sm-2 col-form-label text-end fw-bold">Parameter
                                                                Mesin HD</label>
                                                            <div class="col-sm-10">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">QB</span>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_qb ?? '-' }}"
                                                                                disabled>
                                                                            <span class="input-group-text">ml/menit</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">QD</span>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_qd ?? '-' }}"
                                                                                disabled>
                                                                            <span class="input-group-text">ml/menit</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- UF Rate -->
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">UF
                                                                Rate</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_uf_rate ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">ml/menit</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Tek. Darah (mmHg) - Sistole & Diastole -->
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Tek.
                                                                Darah (mmHg)</label>
                                                            <div class="col-sm-10">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">Sistole</span>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_sistole ?? '-' }}"
                                                                                disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">Diastole</span>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_diastole ?? '-' }}"
                                                                                disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Nadi (Per Menit) -->
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Nadi
                                                                (Per Menit)</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_nadi ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">x/mnt</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Nafas (Per Menit) -->
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Nafas
                                                                (Per Menit)</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_nafas ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">x/mnt</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Suhu (C) -->
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Suhu
                                                                (C)</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_suhu ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">°C</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Pemantauan Cairan Intake -->
                                                        <div class="row mb-3">
                                                            <label
                                                                class="col-sm-2 col-form-label text-end fw-bold">Pemantauan
                                                                Cairan Intake</label>
                                                            <div class="col-sm-10">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">NaCl</span>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_nacl ?? '-' }}"
                                                                                disabled>
                                                                            <span class="input-group-text">ml</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">Minum</span>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_minum ?? '-' }}"
                                                                                disabled>
                                                                            <span class="input-group-text">ml</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col-12">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">Lain-Lain</span>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_intake_lain ?? '-' }}"
                                                                                disabled>
                                                                            <span class="input-group-text">ml</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Pemantauan Cairan Output -->
                                                        <div class="row mb-3">
                                                            <label
                                                                class="col-sm-2 col-form-label text-end fw-bold">Pemantauan
                                                                Cairan Output</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_output ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">ml</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="alert alert-info">
                                                        Tidak ada data tindakan keperawatan yang tersedia.
                                                    </div>
                                                @endif

                                                <div class="intraHD">
                                                    <!-- Intra HD EDIT-->
                                                    <div class="row mt-4">
                                                        <div class="col-12 mb-2">
                                                            <h6 class="fw-bold">Intra HD</h6>
                                                        </div>
                                                    </div>

                                                    <!-- Waktu Intra Pre HD -->
                                                    <div class="row mb-3">
                                                        <label for="waktu_intra_pre_hd"
                                                            class="col-sm-2 col-form-label text-end">Waktu Intra Pre
                                                            HD</label>
                                                        <div class="col-sm-10">
                                                            <input type="time" class="form-control"
                                                                id="waktu_intra_pre_hd" name="waktu_intra_pre_hd"
                                                                value="{{ isset($asesmen->keperawatanMonitoringIntrahd->waktu_intra_pre_hd) ? \Carbon\Carbon::parse($asesmen->keperawatanMonitoringIntrahd->waktu_intra_pre_hd)->format('H:i') : '' }}">
                                                        </div>
                                                    </div>

                                                    <!-- Parameter Mesin HD (QB dan QD) -->
                                                    <div class="row mb-3">
                                                        <label for="parameter_mesin_hd_intra"
                                                            class="col-sm-2 col-form-label text-end">Parameter Mesin
                                                            HD</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">QB</span>
                                                                        <input type="number" class="form-control"
                                                                            id="qb_intra" name="qb_intra"
                                                                            value="{{ $asesmen->keperawatanMonitoringIntrahd->qb_intra ?? '' }}">
                                                                        <span class="input-group-text">ml/menit</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">QD</span>
                                                                        <input type="number" class="form-control"
                                                                            id="qd_intra" name="qd_intra"
                                                                            value="{{ $asesmen->keperawatanMonitoringIntrahd->qd_intra ?? '' }}">
                                                                        <span class="input-group-text">ml/menit</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- UF Rate -->
                                                    <div class="row mb-3">
                                                        <label for="uf_rate_intra"
                                                            class="col-sm-2 col-form-label text-end">UF Rate</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control"
                                                                    id="uf_rate_intra" name="uf_rate_intra"
                                                                    value="{{ $asesmen->keperawatanMonitoringIntrahd->uf_rate_intra ?? '' }}">
                                                                <span class="input-group-text">ml/menit</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tek. Darah (mmHg) - Sistole & Diastole -->
                                                    <div class="row mb-3">
                                                        <label for="tekanan_darah_intra"
                                                            class="col-sm-2 col-form-label text-end">Tek. Darah
                                                            (mmHg)</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Sistole</span>
                                                                        <input type="number" class="form-control"
                                                                            id="sistole_intra" name="sistole_intra"
                                                                            value="{{ $asesmen->keperawatanMonitoringIntrahd->sistole_intra ?? '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Diastole</span>
                                                                        <input type="number" class="form-control"
                                                                            id="diastole_intra" name="diastole_intra"
                                                                            value="{{ $asesmen->keperawatanMonitoringIntrahd->diastole_intra ?? '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nadi (Per Menit) -->
                                                    <div class="row mb-3">
                                                        <label for="nadi_intra"
                                                            class="col-sm-2 col-form-label text-end">Nadi (Per
                                                            Menit)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control"
                                                                    id="nadi_intra" name="nadi_intra"
                                                                    value="{{ $asesmen->keperawatanMonitoringIntrahd->nadi_intra ?? '' }}">
                                                                <span class="input-group-text">x/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nafas (Per Menit) -->
                                                    <div class="row mb-3">
                                                        <label for="nafas_intra"
                                                            class="col-sm-2 col-form-label text-end">Nafas (Per
                                                            Menit)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control"
                                                                    id="nafas_intra" name="nafas_intra"
                                                                    value="{{ $asesmen->keperawatanMonitoringIntrahd->nafas_intra ?? '' }}">
                                                                <span class="input-group-text">x/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Suhu (C) -->
                                                    <div class="row mb-3">
                                                        <label for="suhu_intra"
                                                            class="col-sm-2 col-form-label text-end">Suhu (C)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control"
                                                                    id="suhu_intra" name="suhu_intra"
                                                                    value="{{ $asesmen->keperawatanMonitoringIntrahd->suhu_intra ?? '' }}"
                                                                    step="0.1">
                                                                <span class="input-group-text">°C</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Pemantauan Cairan Intake -->
                                                    <div class="row mb-3">
                                                        <label for="pemantauan_cairan_intake_intra"
                                                            class="col-sm-2 col-form-label text-end">Pemantauan Cairan
                                                            Intake</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">NaCl</span>
                                                                        <input type="number" class="form-control"
                                                                            id="nacl_intra" name="nacl_intra"
                                                                            value="{{ $asesmen->keperawatanMonitoringIntrahd->nacl_intra ?? '' }}">
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Minum</span>
                                                                        <input type="number" class="form-control"
                                                                            id="minum_intra" name="minum_intra"
                                                                            value="{{ $asesmen->keperawatanMonitoringIntrahd->minum_intra ?? '' }}">
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-12">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Lain-Lain</span>
                                                                        <input type="text" class="form-control"
                                                                            id="intake_lain_intra"
                                                                            name="intake_lain_intra"
                                                                            value="{{ $asesmen->keperawatanMonitoringIntrahd->intake_lain_intra ?? '' }}">
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Pemantauan Cairan Output -->
                                                    <div class="row mb-3">
                                                        <label for="pemantauan_cairan_output_intra"
                                                            class="col-sm-2 col-form-label text-end">Pemantauan Cairan
                                                            Output</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control"
                                                                    id="output_intra" name="output_intra"
                                                                    value="{{ $asesmen->keperawatanMonitoringIntrahd->output_intra ?? '' }}">
                                                                <span class="input-group-text">ml</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tombol Simpan untuk Intra HD -->
                                                    {{-- <div class="row mt-4">
                                                        <div class="col-sm-10 offset-sm-2">
                                                            <button type="button" class="btn btn-primary btn-simpan-intra-hd">Simpan ke Tabel</button>
                                                        </div>
                                                    </div> --}}
                                                </div>

                                                <div class="daftarObservasiIntraTindakanHD">
                                                    <!-- Daftar Observasi Intra Tindakan HD -->
                                                    <div class="row mt-4">
                                                        <div class="col-12 mb-2">
                                                            <h6 class="fw-bold">Daftar Observasi Intra Tindakan HD</h6>
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm" id="observasiTable"
                                                            style="min-width: 1500px;">
                                                            <thead class="table-primary">
                                                                <tr class="text-center align-middle">
                                                                    <th style="min-width: 120px;">Waktu</th>
                                                                    <th style="min-width: 80px;">QB</th>
                                                                    <th style="min-width: 80px;">QD</th>
                                                                    <th style="min-width: 90px;">UF Rate</th>
                                                                    <th style="min-width: 110px;">TD (mmHg)</th>
                                                                    <th style="min-width: 80px;">Nadi</th>
                                                                    <th style="min-width: 80px;">Nafas</th>
                                                                    <th style="min-width: 80px;">Suhu</th>
                                                                    <th style="min-width: 90px;">NaCl (ml)</th>
                                                                    <th style="min-width: 90px;">Minum (ml)</th>
                                                                    <th style="min-width: 100px;">Lain-Lain (ml)</th>
                                                                    <th style="min-width: 90px;">Output (ml)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="observasiTableBody">
                                                                <!-- Baris akan ditambahkan dari data form atau loaded dari database -->
                                                            </tbody>
                                                            <tfoot class="table-secondary">
                                                                <tr class="text-center fw-bold align-middle">
                                                                    <td colspan="8" class="text-end">TOTAL:</td>
                                                                    <td id="total-nacl">0</td>
                                                                    <td id="total-minum">0</td>
                                                                    <td id="total-lain">0</td>
                                                                    <td id="total-output">0</td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>

                                                    <!-- Hidden input for observasi_data -->
                                                    <input type="hidden" name="observasi_data" id="observasi_data"
                                                        value="{{ $asesmen->keperawatanMonitoringIntrahd->observasi_data ?? '' }}">
                                                </div>

                                                <!-- Post HD -->
                                                <div class="post__HD">
                                                    <div class="row mt-4">
                                                        <div class="col-12 mb-2">
                                                            <h6 class="fw-bold">Post HD</h6>
                                                        </div>
                                                    </div>

                                                    @if ($asesmen->keperawatanMonitoringPosthd)
                                                        <!-- Lama Waktu Post HD -->
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Lama
                                                                Waktu Post HD</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPosthd->lama_waktu_post_hd ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">menit</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Parameter Mesin HD (QB dan QD) -->
                                                        <div class="row mb-3">
                                                            <label
                                                                class="col-sm-2 col-form-label text-end fw-bold">Parameter
                                                                Mesin HD</label>
                                                            <div class="col-sm-10">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">QB</span>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asesmen->keperawatanMonitoringPosthd->qb_post ?? '-' }}"
                                                                                disabled>
                                                                            <span class="input-group-text">ml/menit</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">QD</span>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asesmen->keperawatanMonitoringPosthd->qd_post ?? '-' }}"
                                                                                disabled>
                                                                            <span class="input-group-text">ml/menit</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- UF Rate -->
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">UF
                                                                Rate</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPosthd->uf_rate_post ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">ml/menit</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Tek. Darah (mmHg) - Sistole & Diastole -->
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Tek.
                                                                Darah (mmHg)</label>
                                                            <div class="col-sm-10">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">Sistole</span>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asesmen->keperawatanMonitoringPosthd->sistole_post ?? '-' }}"
                                                                                disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">Diastole</span>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asesmen->keperawatanMonitoringPosthd->diastole_post ?? '-' }}"
                                                                                disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Nadi (Per Menit) -->
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Nadi
                                                                (Per Menit)</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPosthd->nadi_post ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">x/mnt</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Nafas (Per Menit) -->
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Nafas
                                                                (Per Menit)</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPosthd->nafas_post ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">x/mnt</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Suhu (C) -->
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Suhu
                                                                (C)</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPosthd->suhu_post ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">°C</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Pemantauan Cairan Intake -->
                                                        <div class="row mb-3">
                                                            <label
                                                                class="col-sm-2 col-form-label text-end fw-bold">Pemantauan
                                                                Cairan Intake</label>
                                                            <div class="col-sm-10">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">NaCl</span>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asesmen->keperawatanMonitoringPosthd->nacl_post ?? '-' }}"
                                                                                disabled>
                                                                            <span class="input-group-text">ml</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">Minum</span>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asesmen->keperawatanMonitoringPosthd->minum_post ?? '-' }}"
                                                                                disabled>
                                                                            <span class="input-group-text">ml</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col-12">
                                                                        <div class="input-group">
                                                                            <span
                                                                                class="input-group-text">Lain-Lain</span>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $asesmen->keperawatanMonitoringPosthd->intake_lain_post ?? '-' }}"
                                                                                disabled>
                                                                            <span class="input-group-text">ml</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Pemantauan Cairan Output -->
                                                        <div class="row mb-3">
                                                            <label
                                                                class="col-sm-2 col-form-label text-end fw-bold">Pemantauan
                                                                Cairan Output</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $asesmen->keperawatanMonitoringPosthd->output_post ?? '-' }}"
                                                                        disabled>
                                                                    <span class="input-group-text">ml</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Jumlah Cairan Intake -->
                                                        <div class="row mb-3">
                                                            <label for="jumlah_cairan_intake"
                                                                class="col-sm-2 col-form-label text-end fw-bold">Jumlah
                                                                Cairan
                                                                Intake</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input disabled type="number" class="form-control"
                                                                        id="jumlah_cairan_output"
                                                                        name="jumlah_cairan_intake"
                                                                        value="{{ $asesmen->keperawatanMonitoringPosthd->jumlah_cairan_intake ?? '' }}">
                                                                    <span class="input-group-text">ml</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Jumlah Cairan Output -->
                                                        <div class="row mb-3">
                                                            <label for="jumlah_cairan_output"
                                                                class="col-sm-2 col-form-label text-end fw-bold">Jumlah
                                                                Cairan
                                                                Output</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input disabled type="text" class="form-control"
                                                                        id="ultrafiltration_total"
                                                                        name="jumlah_cairan_output"
                                                                        value="{{ $asesmen->keperawatanMonitoringPosthd->jumlah_cairan_output ?? '' }}">
                                                                    <span class="input-group-text">ml</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Ultrafiltration Total -->
                                                        <div class="row mb-3">
                                                            <label
                                                                class="col-sm-2 col-form-label text-end fw-bold">Ultrafiltration
                                                                Total</label>
                                                            <div class="col-sm-10">
                                                                <input disabled type="number" class="form-control"
                                                                    id="jumlah_cairan_intake"
                                                                    name="ultrafiltration_total"
                                                                    placeholder="input angka, otomatis menghitung total cairan yang diambil selama HD ml"
                                                                    readonly
                                                                    value="{{ $asesmen->keperawatanMonitoringPosthd->ultrafiltration_total ?? '' }}">
                                                            </div>
                                                        </div>

                                                        <!-- Keterangan SOAPIE -->
                                                        <div class="row mb-3">
                                                            <label
                                                                class="col-sm-2 col-form-label text-end fw-bold">Keterangan
                                                                SOAPIE</label>
                                                            <div class="col-sm-10">
                                                                <textarea class="form-control" rows="3" disabled>{{ $asesmen->keperawatanMonitoringPosthd->keterangan_soapie ?? '-' }}</textarea>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="alert alert-info">
                                                            Tidak ada data Post HD yang tersedia.
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Penyulit Selama HD -->
                                        <div class="section-separator mt-5">
                                            <h5 class="section-title">11. Penyulit Selama HD</h5>

                                            @if ($asesmen->keperawatan)
                                                <!-- Klinis -->
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label text-end fw-bold">Klinis</label>
                                                    <div class="col-sm-10">
                                                        @php
                                                            $klinisValues = $asesmen->keperawatan->klinis_values
                                                                ? json_decode(
                                                                    $asesmen->keperawatan->klinis_values,
                                                                    true,
                                                                )
                                                                : [];
                                                            $klinisDisplay = !empty($klinisValues)
                                                                ? implode(', ', $klinisValues)
                                                                : '-';
                                                        @endphp
                                                        <input type="text" class="form-control"
                                                            value="{{ $klinisDisplay }}" disabled>
                                                    </div>
                                                </div>

                                                <!-- Teknis -->
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label text-end fw-bold">Teknis</label>
                                                    <div class="col-sm-10">
                                                        @php
                                                            $teknisValues = $asesmen->keperawatan->teknis_values
                                                                ? json_decode(
                                                                    $asesmen->keperawatan->teknis_values,
                                                                    true,
                                                                )
                                                                : [];
                                                            $teknisDisplay = !empty($teknisValues)
                                                                ? implode(', ', $teknisValues)
                                                                : '-';
                                                        @endphp
                                                        <input type="text" class="form-control"
                                                            value="{{ $teknisDisplay }}" disabled>
                                                    </div>
                                                </div>

                                                <!-- Mesin -->
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label text-end fw-bold">Mesin</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control"
                                                            value="{{ $asesmen->keperawatan->mesin ?? '-' }}" disabled>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    Tidak ada data penyulit selama HD yang tersedia.
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Discharge Planning -->
                                        <div class="section-separator mt-5">
                                            <h5 class="section-title">12. Discharge Planning</h5>

                                            @if ($asesmen->keperawatan)
                                                <!-- Rencana Pulang -->
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label text-end fw-bold">Rencana
                                                        Pulang</label>
                                                    <div class="col-sm-10">
                                                        @php
                                                            $rencanaPulangValues = $asesmen->keperawatan
                                                                ->rencana_pulang_values
                                                                ? json_decode(
                                                                    $asesmen->keperawatan->rencana_pulang_values,
                                                                    true,
                                                                )
                                                                : [];
                                                            $rencanaPulangDisplay = !empty($rencanaPulangValues)
                                                                ? implode(', ', $rencanaPulangValues)
                                                                : '-';
                                                        @endphp
                                                        <input type="text" class="form-control"
                                                            value="{{ $rencanaPulangDisplay }}" disabled>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    Tidak ada data discharge planning yang tersedia.
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Diagnosis -->
                                        {{-- <div class="section-separator" id="diagnosis">
                                            <h5 class="fw-semibold mb-4">14. Diagnosis</h5>

                                            @if ($asesmen->keperawatan)
                                                <!-- Diagnosis Banding -->
                                                <div class="mb-4">
                                                    <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
                                                    <div class="mt-2">
                                                        @php
                                                            $diagnosisBandingValues = $asesmen->keperawatan->diagnosis_banding ? json_decode($asesmen->keperawatan->diagnosis_banding, true) : [];
                                                            $diagnosisBandingDisplay = !empty($diagnosisBandingValues) ? implode(', ', $diagnosisBandingValues) : '-';
                                                        @endphp
                                                        <input type="text" class="form-control" value="{{ $diagnosisBandingDisplay }}" disabled>
                                                    </div>
                                                </div>

                                                <!-- Diagnosis Kerja -->
                                                <div class="mb-4">
                                                    <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
                                                    <div class="mt-2">
                                                        @php
                                                            $diagnosisKerjaValues = $asesmen->keperawatan->diagnosis_kerja ? json_decode($asesmen->keperawatan->diagnosis_kerja, true) : [];
                                                            $diagnosisKerjaDisplay = !empty($diagnosisKerjaValues) ? implode(', ', $diagnosisKerjaValues) : '-';
                                                        @endphp
                                                        <input type="text" class="form-control" value="{{ $diagnosisKerjaDisplay }}" disabled>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    Tidak ada data diagnosis yang tersedia.
                                                </div>
                                            @endif
                                        </div> --}}

                                        <!-- Implementasi -->
                                        {{-- <div class="section-separator" style="margin-bottom: 2rem;" id="implementasi">
                                            <h5 class="fw-semibold mb-4">15. Implementasi</h5>

                                            @if ($asesmen->keperawatan)
                                                <!-- Rencana Penatalaksanaan dan Pengobatan -->
                                                <div class="mb-4">
                                                    <label class="text-primary fw-semibold">Rencana Penatalaksanaan dan Pengobatan</label>
                                                </div>

                                                <!-- Observasi Section -->
                                                <div class="mb-4">
                                                    <label class="fw-semibold mb-2">Observasi</label>
                                                    <div class="mt-2">
                                                        @php
                                                            $observasiValues = $asesmen->keperawatan->observasi ? json_decode($asesmen->keperawatan->observasi, true) : [];
                                                            $observasiDisplay = !empty($observasiValues) ? implode(', ', $observasiValues) : '-';
                                                        @endphp
                                                        <input type="text" class="form-control" value="{{ $observasiDisplay }}" disabled>
                                                    </div>
                                                </div>

                                                <!-- Terapeutik Section -->
                                                <div class="mb-4">
                                                    <label class="fw-semibold mb-2">Terapeutik</label>
                                                    <div class="mt-2">
                                                        @php
                                                            $terapeutikValues = $asesmen->keperawatan->terapeutik ? json_decode($asesmen->keperawatan->terapeutik, true) : [];
                                                            $terapeutikDisplay = !empty($terapeutikValues) ? implode(', ', $terapeutikValues) : '-';
                                                        @endphp
                                                        <input type="text" class="form-control" value="{{ $terapeutikDisplay }}" disabled>
                                                    </div>
                                                </div>

                                                <!-- Edukasi Section -->
                                                <div class="mb-4">
                                                    <label class="fw-semibold mb-2">Edukasi</label>
                                                    <div class="mt-2">
                                                        @php
                                                            $edukasiValues = $asesmen->keperawatan->edukasi ? json_decode($asesmen->keperawatan->edukasi, true) : [];
                                                            $edukasiDisplay = !empty($edukasiValues) ? implode(', ', $edukasiValues) : '-';
                                                        @endphp
                                                        <input type="text" class="form-control" value="{{ $edukasiDisplay }}" disabled>
                                                    </div>
                                                </div>

                                                <!-- Kolaborasi Section -->
                                                <div class="mb-4">
                                                    <label class="fw-semibold mb-2">Kolaborasi</label>
                                                    <div class="mt-2">
                                                        @php
                                                            $kolaborasiValues = $asesmen->keperawatan->kolaborasi ? json_decode($asesmen->keperawatan->kolaborasi, true) : [];
                                                            $kolaborasiDisplay = !empty($kolaborasiValues) ? implode(', ', $kolaborasiValues) : '-';
                                                        @endphp
                                                        <input type="text" class="form-control" value="{{ $kolaborasiDisplay }}" disabled>
                                                    </div>
                                                </div>

                                                <!-- Prognosis Section -->
                                                <div class="mb-4">
                                                    <label class="text-primary fw-semibold">Prognosis</label>
                                                    <div class="mt-2">
                                                        @php
                                                            $prognosisValues = $asesmen->keperawatan->prognosis ? json_decode($asesmen->keperawatan->prognosis, true) : [];
                                                            $prognosisDisplay = !empty($prognosisValues) ? implode(', ', $prognosisValues) : '-';
                                                        @endphp
                                                        <input type="text" class="form-control" value="{{ $prognosisDisplay }}" disabled>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    Tidak ada data implementasi yang tersedia.
                                                </div>
                                            @endif
                                        </div> --}}

                                        <!-- Evaluasi -->
                                        <div class="section-separator mt-5">
                                            <h5 class="section-title">13. SOAP</h5>

                                            @if ($asesmen->keperawatan)
                                                <!-- Evaluasi Keperawatan -->
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold">Subjective (Subjektif)</label>
                                                        <textarea class="form-control" rows="4" disabled>{{ $asesmen->keperawatan->soap_s ?? '-' }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Evaluasi Medis -->
                                                <div class="row mb-4">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold">Objective (Objektif)</label>
                                                        <textarea class="form-control" rows="4" disabled>{{ $asesmen->keperawatan->soap_o ?? '-' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold">Assessment (Penilaian)</label>
                                                        <textarea class="form-control" rows="4" disabled>{{ $asesmen->keperawatan->soap_a ?? '-' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold">Plan (Perencanaan)</label>
                                                        <textarea class="form-control" rows="4" disabled>{{ $asesmen->keperawatan->soap_p ?? '-' }}</textarea>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-info">
                                                    Tidak ada data evaluasi yang tersedia.
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Tanda Tangan dan Verifikasi -->
                                        <div class="section-separator mt-5">
                                            <h5 class="section-title">14. Tanda Tangan dan Verifikasi</h5>

                                            <!-- E-Signature Perawat Pemeriksa Akses Vaskular (Single) -->
                                            <div class="row mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label">E-Signature Nama Perawat Pemeriksa Akses
                                                        Vaskular</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <select name="perawat_pemeriksa" id="perawat-pemeriksa"
                                                                class="form-select select2">
                                                                <option value="">--Pilih--</option>
                                                                @foreach ($perawat as $prwt)
                                                                    <option value="{{ $prwt->kd_karyawan }}"
                                                                        {{ ($asesmen->keperawatan->perawat_pemeriksa ?? '') == $prwt->kd_karyawan ? 'selected' : '' }}>
                                                                        {{ "$prwt->gelar_depan $prwt->nama $prwt->gelar_belakang" }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 text-center">
                                                            <div id="qr-pemeriksa"></div>
                                                            <div class="mt-2" id="no-pemeriksa">
                                                                No..........................</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- E-Signature Perawat Yang Bertugas (Multiple) -->
                                            <div class="row mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label">E-Signature Nama Perawat Yang
                                                        Bertugas</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row mb-3">
                                                        <div class="col-md-8">
                                                            <select id="perawat-selector" class="form-select select2">
                                                                <option value="">--Pilih Perawat--</option>
                                                                @foreach ($perawat as $prwt)
                                                                    <option value="{{ $prwt->kd_karyawan }}"
                                                                        data-nama="{{ $prwt->gelar_depan }} {{ $prwt->nama }} {{ $prwt->gelar_belakang }}">
                                                                        {{ "$prwt->gelar_depan $prwt->nama $prwt->gelar_belakang" }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        {{-- <div class="col-md-4">
                                                                <button type="button" id="btn-tambah-perawat" class="btn btn-primary w-100">
                                                                    <i class="fas fa-plus"></i> Tambah
                                                                </button>
                                                            </div> --}}
                                                    </div>

                                                    <!-- List Perawat yang Dipilih -->
                                                    <div id="list-perawat-bertugas" class="border rounded p-3 bg-light">
                                                        <div class="text-muted text-center py-3" id="empty-message">
                                                            Belum ada perawat yang ditambahkan
                                                        </div>
                                                    </div>

                                                    <!-- Hidden input untuk menyimpan data JSON -->
                                                    <input type="hidden" name="perawat_bertugas"
                                                        id="perawat-bertugas-json" value="">
                                                </div>
                                            </div>

                                            <!-- E-Signature Dokter DPJP (Single) -->
                                            <div class="row mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label">E-Signature Nama Dokter (DPJP)</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <select name="dokter_pelaksana" id="dokter-pelaksana"
                                                                class="form-select">
                                                                <option value="">--Pilih--</option>
                                                                @foreach ($dokterPelaksana as $item)
                                                                    <option value="{{ $item->dokter->kd_dokter }}"
                                                                        {{ ($asesmen->keperawatan->dokter_pelaksana ?? '') == $item->dokter->kd_dokter ? 'selected' : '' }}>
                                                                        {{ $item->dokter->nama_lengkap }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 text-center">
                                                            <div id="qr-dokter"></div>
                                                            <div class="mt-2" id="no-dokter">
                                                                No..........................</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </x-content-card>
        </div>
    </div>
@endsection


@push('js')
    <script>
        //pemeriksaan fisik
        document.addEventListener('DOMContentLoaded', function() {
            //------------------------------------------------------------//
            // Event handler untuk tombol tambah keterangan di pemeriksaan fisik //
            document.querySelectorAll('.tambah-keterangan').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const keteranganDiv = document.getElementById(targetId);
                    const normalCheckbox = this.closest('.pemeriksaan-item').querySelector(
                        '.form-check-input');

                    // Toggle tampilan keterangan
                    if (keteranganDiv.style.display === 'none') {
                        keteranganDiv.style.display = 'block';
                        normalCheckbox.checked = false; // Uncheck normal checkbox
                    } else {
                        keteranganDiv.style.display = 'block';
                    }
                });
            });

            // Event handler untuk checkbox normal
            document.querySelectorAll('.form-check-input').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const keteranganDiv = this.closest('.pemeriksaan-item').querySelector(
                        '.keterangan');
                    if (this.checked) {
                        keteranganDiv.style.display = 'none';
                        keteranganDiv.querySelector('input').value = ''; // Reset input value
                    }
                });
            });
        });

        // 17. Tanda Tangan dan Verifikasi
        document.addEventListener('DOMContentLoaded', function() {
            let petugasCounter = 0;
            const petugasList = []; // Array untuk menyimpan data perawat
            let qrPemeriksa = null;
            let qrDokter = null;

            // Cek apakah QRCode library ada
            function waitForQRCode(callback) {
                if (typeof QRCode !== 'undefined') {
                    callback();
                } else {
                    setTimeout(() => waitForQRCode(callback), 100);
                }
            }

            // Fungsi untuk update JSON di hidden input
            function updateJSONInput() {
                const jsonInput = document.getElementById('perawat-bertugas-json');
                if (jsonInput) {
                    jsonInput.value = JSON.stringify(petugasList);
                    // console.log('Data JSON:', jsonInput.value);
                }
            }

            // Fungsi untuk render item perawat
            function renderPetugasItem(perawat) {
                const listContainer = document.getElementById('list-perawat-bertugas');
                if (!listContainer) return;

                const petugasItem = document.createElement('div');
                petugasItem.className = 'border-bottom pb-2 mb-2';
                petugasItem.dataset.kode = perawat.kd_karyawan;
                petugasItem.innerHTML = `
                    <div class="row align-items-center py-2">
                        <div class="col-auto">
                            <span class="badge bg-primary rounded-circle" style="width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; font-size: 13px;">
                                ${perawat.urutan}
                            </span>
                        </div>
                        <div class="col">
                            <strong>${perawat.nama}</strong>
                        </div>
                        <div class="col-auto">
                            <div id="qr-bertugas-${perawat.kd_karyawan}" class="d-inline-block"></div>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">No. ${perawat.kd_karyawan}</small>
                        </div>
                    </div>
                `;

                listContainer.appendChild(petugasItem);

                // Generate QR Code - tunggu library ready
                waitForQRCode(() => {
                    const qrContainer = document.getElementById(`qr-bertugas-${perawat.kd_karyawan}`);
                    if (qrContainer) {
                        new QRCode(qrContainer, {
                            text: `PERAWAT_BERTUGAS:${perawat.kd_karyawan}`,
                            width: 60,
                            height: 60,
                            colorDark: "#000000",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });
                    }
                });
            }

            // Fungsi hapus petugas
            function removePetugas(kdKaryawan) {
                if (confirm('Apakah Anda yakin ingin menghapus perawat ini?')) {
                    // Hapus dari array
                    const index = petugasList.findIndex(p => p.kd_karyawan === kdKaryawan);
                    if (index > -1) {
                        petugasList.splice(index, 1);
                    }

                    // Update JSON input
                    updateJSONInput();

                    // Hapus elemen dari DOM
                    const item = document.querySelector(`[data-kode="${kdKaryawan}"]`);
                    if (item) {
                        item.remove();
                    }

                    // Update nomor urut
                    updatePetugasNumbers();

                    // Tampilkan pesan kosong jika tidak ada petugas
                    const emptyMsg = document.getElementById('empty-message');
                    if (petugasList.length === 0 && emptyMsg) {
                        emptyMsg.style.display = 'block';
                        petugasCounter = 0;
                    }
                }
            }

            // Expose ke window agar bisa dipanggil dari onclick
            window.removePetugasHandler = removePetugas;

            // Fungsi update nomor urut
            function updatePetugasNumbers() {
                const items = document.querySelectorAll('#list-perawat-bertugas > div[data-kode]');
                items.forEach((item, index) => {
                    const badge = item.querySelector('.badge');
                    const kdKaryawan = item.dataset.kode;

                    if (badge) {
                        badge.textContent = index + 1;
                    }

                    // Update urutan di array
                    const petugas = petugasList.find(p => p.kd_karyawan === kdKaryawan);
                    if (petugas) {
                        petugas.urutan = index + 1;
                    }
                });
                petugasCounter = items.length;

                // Update JSON input
                updateJSONInput();
            }

            // ===== LOAD DATA EXISTING (UNTUK EDIT) =====
            @if (isset($asesmen->keperawatan->perawat_bertugas) && !empty($asesmen->keperawatan->perawat_bertugas))
                try {
                    const existingData = @json(json_decode($asesmen->keperawatan->perawat_bertugas, true));

                    if (existingData && Array.isArray(existingData) && existingData.length > 0) {
                        existingData.forEach((perawat) => {
                            petugasList.push(perawat);
                            petugasCounter = Math.max(petugasCounter, perawat.urutan);
                            renderPetugasItem(perawat);
                        });

                        const emptyMsg = document.getElementById('empty-message');
                        if (emptyMsg) {
                            emptyMsg.style.display = 'none';
                        }
                        updateJSONInput();
                    }
                } catch (e) {
                    console.error('Error loading existing data:', e);
                }
            @endif

            // ===== LOAD QR CODE PERAWAT PEMERIKSA (JIKA ADA) =====
            @if (isset($asesmen->keperawatan->perawat_pemeriksa) && !empty($asesmen->keperawatan->perawat_pemeriksa))
                waitForQRCode(() => {
                    const kdPemeriksa = '{{ $asesmen->keperawatan->perawat_pemeriksa }}';
                    const qrContainerPemeriksa = document.getElementById('qr-pemeriksa');
                    const noContainerPemeriksa = document.getElementById('no-pemeriksa');

                    if (kdPemeriksa && qrContainerPemeriksa) {
                        qrPemeriksa = new QRCode(qrContainerPemeriksa, {
                            text: `PERAWAT_PEMERIKSA:${kdPemeriksa}`,
                            width: 100,
                            height: 100,
                            colorDark: "#000000",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });
                        if (noContainerPemeriksa) {
                            noContainerPemeriksa.textContent = `No. ${kdPemeriksa}`;
                        }
                    }
                });
            @endif

            // ===== LOAD QR CODE DOKTER DPJP (JIKA ADA) =====
            @if (isset($asesmen->keperawatan->dokter_pelaksana) && !empty($asesmen->keperawatan->dokter_pelaksana))
                waitForQRCode(() => {
                    const kdDokter = '{{ $asesmen->keperawatan->dokter_pelaksana }}';
                    const qrContainerDokter = document.getElementById('qr-dokter');
                    const noContainerDokter = document.getElementById('no-dokter');

                    if (kdDokter && qrContainerDokter) {
                        qrDokter = new QRCode(qrContainerDokter, {
                            text: `DOKTER_DPJP:${kdDokter}`,
                            width: 100,
                            height: 100,
                            colorDark: "#000000",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });
                        if (noContainerDokter) {
                            noContainerDokter.textContent = `No. ${kdDokter}`;
                        }
                    }
                });
            @endif

            // ===== PERAWAT PEMERIKSA (Single Select dengan QR) =====
            const perawatPemeriksaEl = document.getElementById('perawat-pemeriksa');
            if (perawatPemeriksaEl) {
                perawatPemeriksaEl.addEventListener('change', function() {
                    const kdKaryawan = this.value;
                    const qrContainer = document.getElementById('qr-pemeriksa');
                    const noContainer = document.getElementById('no-pemeriksa');

                    if (!qrContainer) return;

                    // Clear previous QR
                    qrContainer.innerHTML = '';

                    if (kdKaryawan) {
                        waitForQRCode(() => {
                            qrPemeriksa = new QRCode(qrContainer, {
                                text: `PERAWAT_PEMERIKSA:${kdKaryawan}`,
                                width: 100,
                                height: 100,
                                colorDark: "#000000",
                                colorLight: "#ffffff",
                                correctLevel: QRCode.CorrectLevel.H
                            });

                            if (noContainer) {
                                noContainer.textContent = `No. ${kdKaryawan}`;
                            }
                        });
                    } else if (noContainer) {
                        noContainer.textContent = 'No..........................';
                    }
                });
            }

            // ===== DOKTER DPJP (Single Select dengan QR) =====
            const dokterPelaksanaEl = document.getElementById('dokter-pelaksana');
            if (dokterPelaksanaEl) {
                dokterPelaksanaEl.addEventListener('change', function() {
                    const kdDokter = this.value;
                    const qrContainer = document.getElementById('qr-dokter');
                    const noContainer = document.getElementById('no-dokter');

                    if (!qrContainer) return;

                    // Clear previous QR
                    qrContainer.innerHTML = '';

                    if (kdDokter) {
                        waitForQRCode(() => {
                            qrDokter = new QRCode(qrContainer, {
                                text: `DOKTER_DPJP:${kdDokter}`,
                                width: 100,
                                height: 100,
                                colorDark: "#000000",
                                colorLight: "#ffffff",
                                correctLevel: QRCode.CorrectLevel.H
                            });

                            if (noContainer) {
                                noContainer.textContent = `No. ${kdDokter}`;
                            }
                        });
                    } else if (noContainer) {
                        noContainer.textContent = 'No..........................';
                    }
                });
            }

            // ===== PERAWAT BERTUGAS (Multiple Select dengan QR) =====
            const btnTambahPerawat = document.getElementById('btn-tambah-perawat');
            if (btnTambahPerawat) {
                btnTambahPerawat.addEventListener('click', function() {
                    const selector = document.getElementById('perawat-selector');
                    if (!selector) return;

                    const selectedOption = selector.options[selector.selectedIndex];
                    const kdKaryawan = selectedOption.value;
                    const namaPetugas = selectedOption.text;

                    if (!kdKaryawan) {
                        alert('Silakan pilih perawat terlebih dahulu!');
                        return;
                    }

                    // Cek apakah sudah ada
                    const exists = petugasList.find(p => p.kd_karyawan === kdKaryawan);
                    if (exists) {
                        alert('Perawat ini sudah ditambahkan!');
                        return;
                    }

                    petugasCounter++;

                    // Tambahkan ke array
                    const petugasData = {
                        kd_karyawan: kdKaryawan,
                        nama: namaPetugas,
                        urutan: petugasCounter,
                        timestamp: new Date().toISOString()
                    };
                    petugasList.push(petugasData);

                    // Update JSON input
                    updateJSONInput();

                    // Sembunyikan pesan kosong
                    const emptyMsg = document.getElementById('empty-message');
                    if (emptyMsg) {
                        emptyMsg.style.display = 'none';
                    }

                    // Render item
                    renderPetugasItem(petugasData);

                    // Reset selector
                    selector.value = '';
                    if (typeof $ !== 'undefined' && typeof $(selector).select2 !== 'undefined') {
                        $(selector).val(null).trigger('change');
                    }
                });
            }
        });

        // Edit lanjutan bagian Intra HD
        $(document).ready(function() {
            // Save button for Intra HD form
            $('.btn-simpan-intra-hd').click(function(e) {
                e.preventDefault();
                addDataToTable();
            });

            // Auto-calculate on input change in table
            $('#observasiTableBody').on('input',
                '.observasi-nacl, .observasi-minum, .observasi-lain, .observasi-output',
                function() {
                    calculateTotals();
                    updateObservasiData();
                });

            // Update observasi_data setiap ada perubahan di tabel
            $('#observasiTableBody').on('input', 'input', function() {
                updateObservasiData();
            });

            // Form submission handler
            $('form').on('submit', function(e) {
                // Pastikan observasi_data ter-update sebelum submit
                updateObservasiData();

                // Validasi apakah ada data observasi
                const observasiData = $('#observasi_data').val();
                if (!observasiData || observasiData === '[]' || observasiData === '') {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Belum ada data observasi yang ditambahkan. Silakan tambahkan minimal 1 data observasi.'
                    });
                    return false;
                }

                return true;
            });

            // Load existing data on page load
            loadExistingData();
        });

        // Load existing data if available
        function loadExistingData() {
            const existingData = $('#observasi_data').val();
            if (existingData) {
                try {
                    const observasiData = JSON.parse(existingData);

                    // Populate table with rows
                    if (Array.isArray(observasiData) && observasiData.length > 0) {
                        observasiData.forEach(item => {
                            addRowToTable(
                                item.waktu || '',
                                item.qb || '',
                                item.qd || '',
                                item.uf_rate || '',
                                item.td || '',
                                item.nadi || '',
                                item.nafas || '',
                                item.suhu || '',
                                item.nacl || '',
                                item.minum || '',
                                item.lain_lain || '',
                                item.output || ''
                            );
                        });

                        // Calculate totals after loading
                        calculateTotals();
                    }
                } catch (e) {
                    console.error('Error parsing existing data:', e);
                }
            }
        }

        function addDataToTable() {
            const waktu = $('#waktu_intra_pre_hd').val();
            const qb = $('#qb_intra').val();
            const qd = $('#qd_intra').val();
            const ufRate = $('#uf_rate_intra').val();
            const sistole = $('#sistole_intra').val();
            const diastole = $('#diastole_intra').val();
            const td = (sistole || diastole) ? `${sistole || ''}/${diastole || ''}` : '';
            const nadi = $('#nadi_intra').val();
            const nafas = $('#nafas_intra').val();
            const suhu = $('#suhu_intra').val();
            const nacl = $('#nacl_intra').val();
            const minum = $('#minum_intra').val();
            const lainLain = $('#intake_lain_intra').val();
            const output = $('#output_intra').val();

            // Validate minimum data
            if (!waktu) {
                Swal.fire({
                    icon: 'error',
                    title: 'Data Tidak Lengkap',
                    text: 'Waktu Intra Pre HD harus diisi!'
                });
                return;
            }

            // Check if in edit mode
            const editMode = $('.btn-simpan-intra-hd').data('mode') === 'edit';

            if (editMode) {
                // Update the row being edited
                const editingRow = $('#observasiTableBody tr.editing');
                if (editingRow.length) {
                    editingRow.find('.observasi-waktu').val(waktu);
                    editingRow.find('.observasi-qb').val(qb);
                    editingRow.find('.observasi-qd').val(qd);
                    editingRow.find('.observasi-uf-rate').val(ufRate);
                    editingRow.find('.observasi-td').val(td);
                    editingRow.find('.observasi-nadi').val(nadi);
                    editingRow.find('.observasi-nafas').val(nafas);
                    editingRow.find('.observasi-suhu').val(suhu);
                    editingRow.find('.observasi-nacl').val(nacl);
                    editingRow.find('.observasi-minum').val(minum);
                    editingRow.find('.observasi-lain').val(lainLain);
                    editingRow.find('.observasi-output').val(output);

                    // Remove editing class
                    editingRow.removeClass('editing');

                    // Reset button to "Save"
                    $('.btn-simpan-intra-hd').text('Simpan ke Tabel').removeData('mode');

                    // Show success notification
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data observasi berhasil diperbarui!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            } else {
                // Add new data to the table
                addRowToTable(waktu, qb, qd, ufRate, td, nadi, nafas, suhu, nacl, minum, lainLain, output);

                // Show success notification
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data observasi berhasil ditambahkan!',
                    timer: 1500,
                    showConfirmButton: false
                });
            }

            // Calculate totals
            calculateTotals();

            // Update observasi_data JSON
            updateObservasiData();

            // Reset form fields untuk input baru
            $('#waktu_intra_pre_hd').val('');
            $('#qb_intra').val('');
            $('#qd_intra').val('');
            $('#uf_rate_intra').val('');
            $('#sistole_intra').val('');
            $('#diastole_intra').val('');
            $('#nadi_intra').val('');
            $('#nafas_intra').val('');
            $('#suhu_intra').val('');
            $('#nacl_intra').val('');
            $('#minum_intra').val('');
            $('#intake_lain_intra').val('');
            $('#output_intra').val('');

            // Focus ke field waktu untuk input berikutnya
            $('#waktu_intra_pre_hd').focus();
        }

        function addRowToTable(waktu, qb, qd, ufRate, td, nadi, nafas, suhu, nacl, minum, lainLain, output) {
            const rowHtml = `
                <tr>
                    <td style="min-width: 120px;">
                        <input type="time"
                            class="form-control form-control-sm observasi-waktu"
                            value="${waktu || ''}"
                            style="min-width: 110px; font-size: 13px;">
                    </td>
                    <td style="min-width: 80px;">
                        <input type="number"
                            class="form-control form-control-sm observasi-qb text-center"
                            value="${qb || ''}"
                            style="min-width: 70px; font-size: 13px;">
                    </td>
                    <td style="min-width: 80px;">
                        <input type="number"
                            class="form-control form-control-sm observasi-qd text-center"
                            value="${qd || ''}"
                            style="min-width: 70px; font-size: 13px;">
                    </td>
                    <td style="min-width: 90px;">
                        <input type="number"
                            class="form-control form-control-sm observasi-uf-rate text-center"
                            value="${ufRate || ''}"
                            style="min-width: 80px; font-size: 13px;">
                    </td>
                    <td style="min-width: 110px;">
                        <input type="text"
                            class="form-control form-control-sm observasi-td text-center"
                            value="${td || ''}"
                            placeholder="120/80"
                            style="min-width: 100px; font-size: 13px;">
                    </td>
                    <td style="min-width: 80px;">
                        <input type="number"
                            class="form-control form-control-sm observasi-nadi text-center"
                            value="${nadi || ''}"
                            style="min-width: 70px; font-size: 13px;">
                    </td>
                    <td style="min-width: 80px;">
                        <input type="number"
                            class="form-control form-control-sm observasi-nafas text-center"
                            value="${nafas || ''}"
                            style="min-width: 70px; font-size: 13px;">
                    </td>
                    <td style="min-width: 80px;">
                        <input type="number"
                            class="form-control form-control-sm observasi-suhu text-center"
                            value="${suhu || ''}"
                            step="0.1"
                            style="min-width: 70px; font-size: 13px;">
                    </td>
                    <td style="min-width: 90px;">
                        <input type="number"
                            class="form-control form-control-sm observasi-nacl text-center"
                            value="${nacl || ''}"
                            style="min-width: 80px; font-size: 13px;">
                    </td>
                    <td style="min-width: 90px;">
                        <input type="number"
                            class="form-control form-control-sm observasi-minum text-center"
                            value="${minum || ''}"
                            style="min-width: 80px; font-size: 13px;">
                    </td>
                    <td style="min-width: 100px;">
                        <input type="number"
                            class="form-control form-control-sm observasi-lain text-center"
                            value="${lainLain || ''}"
                            style="min-width: 90px; font-size: 13px;">
                    </td>
                    <td style="min-width: 90px;">
                        <input type="number"
                            class="form-control form-control-sm observasi-output text-center"
                            value="${output || ''}"
                            style="min-width: 80px; font-size: 13px;">
                    </td>
                </tr>
            `;

            $('#observasiTableBody').append(rowHtml);
        }

        function calculateTotals() {
            let totalNacl = 0;
            let totalMinum = 0;
            let totalLain = 0;
            let totalOutput = 0;

            // Loop through all rows and sum up the values
            $('#observasiTableBody tr').each(function() {
                const row = $(this);

                const nacl = parseFloat(row.find('.observasi-nacl').val()) || 0;
                const minum = parseFloat(row.find('.observasi-minum').val()) || 0;
                const lain = parseFloat(row.find('.observasi-lain').val()) || 0;
                const output = parseFloat(row.find('.observasi-output').val()) || 0;

                totalNacl += nacl;
                totalMinum += minum;
                totalLain += lain;
                totalOutput += output;
            });

            // Update footer totals
            $('#total-nacl').text(totalNacl);
            $('#total-minum').text(totalMinum);
            $('#total-lain').text(totalLain);
            $('#total-output').text(totalOutput);

            // Calculate intake and ultrafiltration
            const totalIntake = totalNacl + totalMinum + totalLain;
            const ultrafiltrationTotal = totalIntake - totalOutput;

            // Update the summary fields (jika ada di form Anda)
            $('#jumlah_cairan_intake').val(totalIntake);
            $('#jumlah_cairan_output').val(totalOutput);
            $('#ultrafiltration_total').val(ultrafiltrationTotal);
        }

        function updateObservasiData() {
            const tableRows = [];

            // Collect the table data
            $('#observasiTableBody tr').each(function() {
                const row = $(this);
                const rowData = {
                    waktu: row.find('.observasi-waktu').val() || '',
                    qb: row.find('.observasi-qb').val() || '',
                    qd: row.find('.observasi-qd').val() || '',
                    uf_rate: row.find('.observasi-uf-rate').val() || '',
                    td: row.find('.observasi-td').val() || '',
                    nadi: row.find('.observasi-nadi').val() || '',
                    nafas: row.find('.observasi-nafas').val() || '',
                    suhu: row.find('.observasi-suhu').val() || '',
                    nacl: row.find('.observasi-nacl').val() || '',
                    minum: row.find('.observasi-minum').val() || '',
                    lain_lain: row.find('.observasi-lain').val() || '',
                    output: row.find('.observasi-output').val() || ''
                };

                // Only add rows that have at least time
                if (rowData.waktu) {
                    tableRows.push(rowData);
                }
            });

            // Set the JSON string to the hidden input
            $('#observasi_data').val(JSON.stringify(tableRows));

            // Debug: tampilkan di console
            console.log('Observasi Data Updated:', tableRows);
        }

        // Helper function untuk debug
        function checkObservasiData() {
            const data = $('#observasi_data').val();
            console.log('Current observasi_data:', data);
            try {
                const parsed = JSON.parse(data);
                console.log('Parsed data:', parsed);
            } catch (e) {
                console.log('Not valid JSON');
            }
            return data;
        }
    </script>
@endpush
