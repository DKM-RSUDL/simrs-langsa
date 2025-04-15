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
            @include('unit-pelayanan.hemodialisa.component.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">

                            {{-- FORM ASESMEN AWAL KEPERATAWAN --}}

                            <div class="px-3">
                                <div>
                                    <div class="section-separator">
                                        <h5 class="section-title">1. Anamnesis</h5>

                                        @if($asesmen->keperawatan)
                                            <div class="form-group">
                                                <label for="anamnesis" style="min-width: 200px;">Anamnesis</label>
                                                <textarea name="anamnesis" id="anamnesis" class="form-control"
                                                    disabled>{{ $asesmen->keperawatan->anamnesis ?? 'Tidak ada data' }}</textarea>
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                Tidak ada data anamnesis yang tersedia.
                                            </div>
                                        @endif
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">2. Pemeriksaan Fisik</h5>

                                        @if($asesmen->keperawatanPemeriksaanFisik)
                                            <div class="form-group align-items-center mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Tek. Darah (mmHg)</label>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">Sistole</label>
                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanPemeriksaanFisik->fisik_sistole ?? '-' }}" disabled>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">Diastole</label>
                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanPemeriksaanFisik->fisik_diastole ?? '-' }}" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Nadi (Per Menit)</label>
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanPemeriksaanFisik->fisik_nadi ?? '-' }}" disabled>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Nafas (Per Menit)</label>
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanPemeriksaanFisik->fisik_nafas ?? '-' }}" disabled>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Suhu (C)</label>
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanPemeriksaanFisik->fisik_suhu ?? '-' }}" disabled>
                                            </div>

                                            <div class="form-group align-items-center mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Saturasi Oksigen (%)</label>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">Tanpa bantuan O2</label>
                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanPemeriksaanFisik->so_tb_o2 ?? '-' }}" disabled>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">Dengan bantuan O2</label>
                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanPemeriksaanFisik->so_db_o2 ?? '-' }}" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">AVPU</label>
                                                <input type="text" class="form-control" value="@if($asesmen->keperawatanPemeriksaanFisik->avpu == '0') Sadar Baik/Alert: 0
                                                    @elseif($asesmen->keperawatanPemeriksaanFisik->avpu == '1') Berespon dengan kata-kata/Voice: 1
                                                    @elseif($asesmen->keperawatanPemeriksaanFisik->avpu == '2') Hanya berespons jika dirangsang nyeri/Pain: 2
                                                    @elseif($asesmen->keperawatanPemeriksaanFisik->avpu == '3') Pasien tidak sadar/Unresponsive: 3
                                                    @elseif($asesmen->keperawatanPemeriksaanFisik->avpu == '4') Gelisah atau bingung: 4
                                                    @elseif($asesmen->keperawatanPemeriksaanFisik->avpu == '5') Acute Confusional States: 5
                                                    @else -
                                                    @endif" disabled>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Edema</label>
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanPemeriksaanFisik->edema == '0' ? 'Tidak' : ($asesmen->keperawatanPemeriksaanFisik->edema == '1' ? 'Ya' : '-') }}" disabled>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Konjungtiva</label>
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanPemeriksaanFisik->konjungtiva == '0' ? 'Tidak Anemis' : ($asesmen->keperawatanPemeriksaanFisik->konjungtiva == '1' ? 'Anemis' : '-') }}" disabled>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Dehidrasi</label>
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanPemeriksaanFisik->dehidrasi == '0' ? 'Tidak' : ($asesmen->keperawatanPemeriksaanFisik->dehidrasi == '1' ? 'Ya' : '-') }}" disabled>
                                            </div>

                                            <p class="fw-bold">Antropometri</p>

                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Tinggi Badan (Cm)</label>
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanPemeriksaanFisik->tinggi_badan ?? '-' }}" disabled>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Berat Badan (Kg)</label>
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanPemeriksaanFisik->berat_badan ?? '-' }}" disabled>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Index Massa Tubuh (IMT)</label>
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanPemeriksaanFisik->imt ?? '-' }}" disabled>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Luas Permukaan Tubuh (LPT)</label>
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanPemeriksaanFisik->lpt ?? '-' }}" disabled>
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                Tidak ada data pemeriksaan fisik yang tersedia.
                                            </div>
                                        @endif

                                        <div class="row">
                                            <div class="col-12">
                                                <h5>Pemeriksaan Fisik</h5>
                                                <p class="mb-3 small bg-info text-white rounded-3 p-2">
                                                    <i class="bi bi-info-circle me-2"></i>
                                                    Centang normal jika fisik yang dinilai normal. Jika tidak dipilih, maka
                                                    pemeriksaan tidak dilakukan.
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    @php
                                                        $pemeriksaanFisikData = $asesmen->pemeriksaanFisik;
                                                        $itemFisikNames = [];
                                                        foreach ($itemFisik as $item) {
                                                            $itemFisikNames[$item->id] = $item->nama;
                                                        }

                                                        $totalItems = count($pemeriksaanFisikData);
                                                        $halfCount = ceil($totalItems / 2);
                                                        $firstColumn = $pemeriksaanFisikData->take($halfCount);
                                                        $secondColumn = $pemeriksaanFisikData->skip($halfCount);
                                                    @endphp
                                                    <div class="col-md-6">
                                                        @foreach ($firstColumn as $item)
                                                            @php
                                                                $status = $item->is_normal;
                                                                $keterangan = $item->keterangan;
                                                                $itemId = $item->id_item_fisik;
                                                                $namaItem = $itemFisikNames[$itemId] ?? 'Item #' . $itemId;
                                                            @endphp
                                                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                                <span>{{ $namaItem }}</span>
                                                                <div class="d-flex align-items-center">
                                                                    @if ($status == '0' || $status == 0)
                                                                        <span class="badge bg-warning text-dark me-2">Tidak Normal</span>
                                                                    @elseif ($status == '1' || $status == 1)
                                                                        <span class="badge bg-success me-2">Normal</span>
                                                                    @else
                                                                        <span class="badge bg-secondary me-2">Tidak Diperiksa</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @if ($keterangan && ($status == '0' || $status == 0))
                                                                <div class="mt-1 mb-2">
                                                                    <small class="text-muted">Keterangan: {{ $keterangan }}</small>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    <div class="col-md-6">
                                                        @foreach ($secondColumn as $item)
                                                            @php
                                                                $status = $item->is_normal;
                                                                $keterangan = $item->keterangan;
                                                                $itemId = $item->id_item_fisik;
                                                                $namaItem = $itemFisikNames[$itemId] ?? 'Item #' . $itemId;
                                                            @endphp
                                                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                                <span>{{ $namaItem }}</span>
                                                                <div class="d-flex align-items-center">
                                                                    @if ($status == '0' || $status == 0)
                                                                        <span class="badge bg-warning text-dark me-2">Tidak Normal</span>
                                                                    @elseif ($status == '1' || $status == 1)
                                                                        <span class="badge bg-success me-2">Normal</span>
                                                                    @else
                                                                        <span class="badge bg-secondary me-2">Tidak Diperiksa</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @if ($keterangan && ($status == '0' || $status == 0))
                                                                <div class="mt-1 mb-2">
                                                                    <small class="text-muted">Keterangan: {{ $keterangan }}</small>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">3. Status Nyeri</h5>

                                        <div class="form-group mb-3">
                                            <label style="min-width: 200px;" class="fw-bold">Jenis Skala Nyeri</label>
                                            <input type="text" class="form-control" value="Scale NRS, VAS, VRS" disabled>
                                        </div>

                                        <div class="form-group justify-content-center mb-3">
                                            <img src="{{ asset('assets/img/cppt/cppt.jpeg') }}" alt="Skala Nyeri" class="w-50">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label style="min-width: 200px;" class="fw-bold">Nilai Skala Nyeri</label>

                                            @if($asesmen->keperawatan)
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatan->status_skala_nyeri ?? 'Tidak ada data' }}" disabled>
                                            @else
                                                <input type="text" class="form-control" value="Tidak ada data" disabled>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">4. Riwayat Kesehatan</h5>

                                        @if($asesmen->keperawatan)
                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Gagal Ginjal Stadium</label>
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatan->gagal_ginjal_stadium ?? 'Tidak ada data' }}" disabled>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Jenis Gagal Ginjal</label>
                                                <input type="text" class="form-control" value="@if($asesmen->keperawatan->jenis_gagal_ginjal == 'akut') Akut
                                                    @elseif($asesmen->keperawatan->jenis_gagal_ginjal == 'kronis') Kronis
                                                    @elseif($asesmen->keperawatan->jenis_gagal_ginjal == 'lainnya') Lainnya
                                                    @else Tidak ada data
                                                    @endif" disabled>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Lama Menjalani HD</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatan->lama_menjalani_hd ?? 'Tidak ada data' }}" disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatan->lama_menjalani_hd_unit ?? 'Tidak ada data' }}" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Jadwal HD Rutin</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatan->jadwal_hd_rutin ?? 'Tidak ada data' }}" disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatan->jadwal_hd_rutin_unit ?? 'Tidak ada data' }}" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label style="min-width: 200px;" class="fw-bold">Sesak Nafas/Nyeri Dada</label>
                                                <input type="text" class="form-control" value="@if($asesmen->keperawatan->sesak_nafas == 'ya') Ya
                                                    @elseif($asesmen->keperawatan->sesak_nafas == 'tidak') Tidak
                                                    @else Tidak ada data
                                                    @endif" disabled>
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                Tidak ada data riwayat kesehatan yang tersedia.
                                            </div>
                                        @endif
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">5. Riwayat Obat dan Rekomendasi Dokter</h5>

                                        @if($asesmen->keperawatan)
                                            <!-- Riwayat penggunaan obat pada pasien -->
                                            <div class="mb-4">
                                                <p class="fw-bold mb-2">Riwayat penggunaan obat pada pasien</p>

                                                @if($asesmen->keperawatan->obat_pasien)
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

                                                                @if(is_array($obatPasien) && count($obatPasien) > 0)
                                                                    @foreach($obatPasien as $obat)
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

                                                @if($asesmen->keperawatan->obat_dokter)
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

                                                                @if(is_array($obatDokter) && count($obatDokter) > 0)
                                                                    @foreach($obatDokter as $obat)
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
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">6. Pemeriksaan Penunjang</h5>

                                        @if($asesmen->keperawatanPempen)
                                            <!-- Pre Hemodialisis -->
                                            <div class="mb-4">
                                                <p class="fw-bold mb-3">Pre Hemodialisis</p>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label text-end fw-bold">EKG</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanPempen->pre_ekg ?? 'Tidak ada data' }}" disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label text-end fw-bold">Rontgent</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanPempen->pre_rontgent ?? 'Tidak ada data' }}" disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label text-end fw-bold">USG</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanPempen->pre_usg ?? 'Tidak ada data' }}" disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label text-end fw-bold">Dll</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanPempen->pre_dll ?? 'Tidak ada data' }}" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Post Hemodialisis -->
                                            <div class="mb-4">
                                                <p class="fw-bold mb-3">Post Hemodialisis</p>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label text-end fw-bold">EKG</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanPempen->post_ekg ?? 'Tidak ada data' }}" disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label text-end fw-bold">Rontgent</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanPempen->post_rontgent ?? 'Tidak ada data' }}" disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label text-end fw-bold">USG</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanPempen->post_usg ?? 'Tidak ada data' }}" disabled>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label text-end fw-bold">Dll</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanPempen->post_dll ?? 'Tidak ada data' }}" disabled>
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
                                        <h5 class="section-title">7. Alergi</h5>

                                        @if($asesmen->keperawatan && $asesmen->keperawatan->alergi)
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
                                                            $alergiData = json_decode($asesmen->keperawatan->alergi, true);
                                                        @endphp
                                                        @if(is_array($alergiData) && count($alergiData) > 0)
                                                            @foreach($alergiData as $alergi)
                                                                <tr>
                                                                    <td>{{ $alergi['alergen'] ?? '-' }}</td>
                                                                    <td>{{ $alergi['reaksi'] ?? '-' }}</td>
                                                                    <td>{{ $alergi['severe'] ?? '-' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="3" class="text-center">Tidak ada data alergi</td>
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
                                        <h5 class="section-title">8. Status Gizi</h5>

                                        @if($asesmen->keperawatanStatusGizi)
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label fw-bold">Tanggal Pengkajian</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanStatusGizi->gizi_tanggal_pengkajian ? \Carbon\Carbon::parse($asesmen->keperawatanStatusGizi->gizi_tanggal_pengkajian)->format('d-m-Y H:i') : '-' }}" disabled>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label fw-bold">Skore MIS</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanStatusGizi->gizi_skore_mis ?? '-' }}" disabled>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label fw-bold">Kesimpulan</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanStatusGizi->gizi_kesimpulan ?? '-' }}" disabled>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label fw-bold">Rencana Pengkajian Ulang MIS</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanStatusGizi->gizi_rencana_pengkajian ?? '-' }}" disabled>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label fw-bold">Rekomendasi</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanStatusGizi->gizi_rekomendasi ?? '-' }}" disabled>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                Tidak ada data status gizi yang tersedia.
                                            </div>
                                        @endif
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">9. Risiko Jatuh</h5>

                                        <h6 class="mt-3 mb-3">Penilaian Risiko Jatuh Skala Morse</h6>

                                        @if($asesmen->keperawatanRisikoJatuh)
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Riwayat jatuh yang baru atau dalam bulan terakhir</label>
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanRisikoJatuh->riwayat_jatuh ?? '-' }}" disabled>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Pasien memiliki Diagnosa medis sekunder > 1 ?</label>
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanRisikoJatuh->diagnosa_sekunder ?? '-' }}" disabled>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Pasien membutuhkan bantuan Alat bantu jalan ?</label>
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanRisikoJatuh->alat_bantu ?? '-' }}" disabled>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Pasien terpasang infus?</label>
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanRisikoJatuh->infus ?? '-' }}" disabled>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Bagaimana cara berjalan pasien?</label>
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanRisikoJatuh->cara_berjalan ?? '-' }}" disabled>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Bagaimana status mental pasien?</label>
                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanRisikoJatuh->status_mental ?? '-' }}" disabled>
                                            </div>

                                            <div class="alert alert-info mt-4 mb-3">
                                                <strong>Total Skor: </strong> <span>{{ $asesmen->keperawatanRisikoJatuh->risiko_jatuh_skor ?? '-' }}</span>
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
                                        <h5 class="section-title">10. Status Psikososial</h5>

                                        @if($asesmen->keperawatanStatusPsikososial)
                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label fw-bold">Tanggal Pengkajian</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanStatusPsikososial->tanggal_pengkajian_psiko ? \Carbon\Carbon::parse($asesmen->keperawatanStatusPsikososial->tanggal_pengkajian_psiko)->format('d-m-Y') : '-' }}" disabled>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label fw-bold">Kendala Komunikasi</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanStatusPsikososial->kendala_komunikasi ?? '-' }}" disabled>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label fw-bold">Yang Merawat di Rumah</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanStatusPsikososial->yang_merawat ?? '-' }}" disabled>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label fw-bold">Kondisi Psikologis</label>
                                                <div class="col-sm-9">
                                                    @php
                                                        $kondisiPsikologis = $asesmen->keperawatanStatusPsikososial->kondisi_psikologis_json ? json_decode($asesmen->keperawatanStatusPsikososial->kondisi_psikologis_json, true) : [];
                                                    @endphp
                                                    <input type="text" class="form-control" value="{{ !empty($kondisiPsikologis) ? implode(', ', $kondisiPsikologis) : '-' }}" disabled>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label fw-bold">Apakah kepatuhan/keterlibatan pasien berkaitan dengan pelayanan kesehatan yang akan diberikan</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanStatusPsikososial->kepatuhan_layanan ?? '-' }}" disabled>
                                                </div>
                                            </div>

                                            @if($asesmen->keperawatanStatusPsikososial->kepatuhan_layanan === 'Ya' && $asesmen->keperawatanStatusPsikososial->jika_ya_jelaskan)
                                                <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label fw-bold">Jika Iya Jelaskan</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanStatusPsikososial->jika_ya_jelaskan ?? '-' }}" disabled>
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
                                        <h5 class="section-title">11. Monitoring Hemodialisis</h5>

                                        @if($asesmen->keperawatanMonitoringPreekripsi)
                                            <!-- 1. Preekripsi Hemodialisis -->
                                            <div class="preekripsi__hemodialisis">
                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <h6 class="fw-bold">1. Preekripsi Hemodialisis</h6>
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
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">HD Ke</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_hd_ke ?? '-' }}" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Nomor Mesin</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_nomor_mesin ?? '-' }}" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">BB HD Yang Lalu</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_bb_hd_lalu ?? '-' }}" disabled>
                                                                <span class="input-group-text">kg</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Tekanan Vena</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_tekanan_vena ?? '-' }}" disabled>
                                                                <span class="input-group-text">ml/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Lama HD</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_lama_hd ?? '-' }}" disabled>
                                                                <span class="input-group-text">Jam</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Program Profiling</label>
                                                        <div class="col-sm-10">
                                                            <div class="row mb-2">
                                                                <div class="col-md-3">
                                                                    <label class="form-check-label">UF Profiling Mode</label>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_uf_profiling_detail ?? '-' }}" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-md-3">
                                                                    <label class="form-check-label">Bicarbonat Profiling</label>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_bicarbonat_profiling_detail ?? '-' }}" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label class="form-check-label">Na Profiling Mode</label>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_na_profiling_detail ?? '-' }}" disabled>
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
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Type Dializer</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->akut_type_dializer ?? '-' }}" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">UF Goal</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->akut_uf_goal ?? '-' }}" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">BB Pre HD</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->akut_bb_pre_hd ?? '-' }}" disabled>
                                                                <span class="input-group-text">kg</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Tekanan Arteri</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->akut_tekanan_arteri ?? '-' }}" disabled>
                                                                <span class="input-group-text">ml/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Laju UF</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->akut_laju_uf ?? '-' }}" disabled>
                                                                <span class="input-group-text">ml</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Lama Laju UF</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->akut_lama_laju_uf ?? '-' }}" disabled>
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
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">N/R Ke</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_nr_ke ?? '-' }}" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">BB Kering</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_bb_kering ?? '-' }}" disabled>
                                                                <span class="input-group-text">kg</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">BB Post HD</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_bb_post_hd ?? '-' }}" disabled>
                                                                <span class="input-group-text">kg</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">TMP (Transmembrane Pressure)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_tmp ?? '-' }}" disabled>
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
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">N/R Ke</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_nr_ke ?? '-' }}" disabled>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">BB Kering</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_bb_kering ?? '-' }}" disabled>
                                                                    <span class="input-group-text">kg</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">BB Post HD</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_bb_post_hd ?? '-' }}" disabled>
                                                                    <span class="input-group-text">kg</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">TMP (Transmembrane Pressure)</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_tmp ?? '-' }}" disabled>
                                                                    <span class="input-group-text">mmHg</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label text-end fw-bold">Program Vaskular Aksesbilling</label>
                                                            <div class="col-sm-10">
                                                                <div class="row mb-2">
                                                                    <div class="col-md-3">
                                                                        <label class="form-check-label">AV Shunt</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_av_shunt_detail ?? '-' }}" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2">
                                                                    <div class="col-md-3">
                                                                        <label class="form-check-label">CDL</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_cdl_detail ?? '-' }}" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <label class="form-check-label">Femoral</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_femoral_detail ?? '-' }}" disabled>
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
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Dialisat</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->preop_dialisat ?? ($asesmen->keperawatanMonitoringPreekripsi->preop_bicarbonat ?? '-') }}" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-sm-2"></div>
                                                        <div class="col-sm-4">
                                                            <label class="form-check-label">Conductivity</label>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->preop_conductivity ?? '-' }}" disabled>
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
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->preop_kalium ?? '-' }}" disabled>
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
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->preop_suhu_dialisat ?? '-' }}" disabled>
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
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPreekripsi->preop_base_na ?? '-' }}" disabled>
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

                                            @if($asesmen->keperawatanMonitoringHeparinisasi)
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <label class="col-form-label fw-bold">Heparinisasi</label>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <!-- Row 1: Dosis Sirkulasi dan Dosis Awal -->
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Dosis Sirkulasi</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringHeparinisasi->dosis_sirkulasi ?? '-' }}" disabled>
                                                                    <span class="input-group-text">IU</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Dosis Awal</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringHeparinisasi->dosis_awal ?? '-' }}" disabled>
                                                                    <span class="input-group-text">IU</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Row 2: Maintenance Kontinyu dan Maintenance Intermiten -->
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Maintenance Kontinyu</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringHeparinisasi->maintenance_kontinyu ?? '-' }}" disabled>
                                                                    <span class="input-group-text">IU/jam</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Maintenance Intermiten</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringHeparinisasi->maintenance_intermiten ?? '-' }}" disabled>
                                                                    <span class="input-group-text">IU/jam</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Row 3: Tanpa Heparin dan LMWH -->
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Tanpa Heparin (sc.)</label>
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringHeparinisasi->tanpa_heparin ?? '-' }}" disabled>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">LMWH</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringHeparinisasi->lmwh ?? '-' }}" disabled>
                                                                    <span class="input-group-text">IU</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Row 4: Program Bilas NaCl -->
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <label class="form-label fw-bold">Program Bilas NaCl 0,9% 100cc/Jam</label>
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringHeparinisasi->program_bilas_nacl ?? '-' }}" disabled>
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

                                            @if($asesmen->keperawatanMonitoringTindakan)
                                                <!-- Pre HD -->
                                                <div class="preHD">
                                                    <div class="row mt-3">
                                                        <div class="col-12 mb-2">
                                                            <h6 class="fw-bold">Pre HD</h6>
                                                        </div>
                                                    </div>

                                                    <!-- Waktu Pre HD -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Waktu Pre HD</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_waktu_pre_hd ? \Carbon\Carbon::parse($asesmen->keperawatanMonitoringTindakan->prehd_waktu_pre_hd)->format('H:i') : '-' }}" disabled>
                                                        </div>
                                                    </div>

                                                    <!-- Parameter Mesin HD (QB dan QD) -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Parameter Mesin HD</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">QB</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_qb ?? '-' }}" disabled>
                                                                        <span class="input-group-text">ml/menit</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">QD</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_qd ?? '-' }}" disabled>
                                                                        <span class="input-group-text">ml/menit</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- UF Rate -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">UF Rate</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_uf_rate ?? '-' }}" disabled>
                                                                <span class="input-group-text">ml/menit</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tek. Darah (mmHg) - Sistole & Diastole -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Tek. Darah (mmHg)</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Sistole</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_sistole ?? '-' }}" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Diastole</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_diastole ?? '-' }}" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nadi (Per Menit) -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Nadi (Per Menit)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_nadi ?? '-' }}" disabled>
                                                                <span class="input-group-text">x/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nafas (Per Menit) -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Nafas (Per Menit)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_nafas ?? '-' }}" disabled>
                                                                <span class="input-group-text">x/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Suhu (C) -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Suhu (C)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_suhu ?? '-' }}" disabled>
                                                                <span class="input-group-text">°C</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Pemantauan Cairan Intake -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Pemantauan Cairan Intake</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">NaCl</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_nacl ?? '-' }}" disabled>
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Minum</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_minum ?? '-' }}" disabled>
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-12">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Lain-Lain</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_intake_lain ?? '-' }}" disabled>
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Pemantauan Cairan Output -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Pemantauan Cairan Output</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_output ?? '-' }}" disabled>
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

                                            <!-- Intra HD -->
                                            <div class="intraHD">
                                                <div class="row mt-4">
                                                    <div class="col-12 mb-2">
                                                        <h6 class="fw-bold">Intra HD</h6>
                                                    </div>
                                                </div>

                                                @if($asesmen->keperawatanMonitoringIntrahd)
                                                    <!-- Waktu Intra Pre HD -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Waktu Intra Pre HD</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringIntrahd->waktu_intra_pre_hd ? \Carbon\Carbon::parse($asesmen->keperawatanMonitoringIntrahd->waktu_intra_pre_hd)->format('H:i') : '-' }}" disabled>
                                                        </div>
                                                    </div>

                                                    <!-- Parameter Mesin HD (QB dan QD) -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Parameter Mesin HD</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">QB</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringIntrahd->qb_intra ?? '-' }}" disabled>
                                                                        <span class="input-group-text">ml/menit</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">QD</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringIntrahd->qd_intra ?? '-' }}" disabled>
                                                                        <span class="input-group-text">ml/menit</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- UF Rate -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">UF Rate</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringIntrahd->uf_rate_intra ?? '-' }}" disabled>
                                                                <span class="input-group-text">ml/menit</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tek. Darah (mmHg) - Sistole & Diastole -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Tek. Darah (mmHg)</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Sistole</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringIntrahd->sistole_intra ?? '-' }}" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Diastole</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringIntrahd->diastole_intra ?? '-' }}" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nadi (Per Menit) -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Nadi (Per Menit)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringIntrahd->nadi_intra ?? '-' }}" disabled>
                                                                <span class="input-group-text">x/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nafas (Per Menit) -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Nafas (Per Menit)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringIntrahd->nafas_intra ?? '-' }}" disabled>
                                                                <span class="input-group-text">x/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Suhu (C) -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Suhu (C)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringIntrahd->suhu_intra ?? '-' }}" disabled>
                                                                <span class="input-group-text">°C</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Pemantauan Cairan Intake -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Pemantauan Cairan Intake</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">NaCl</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringIntrahd->nacl_intra ?? '-' }}" disabled>
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Minum</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringIntrahd->minum_intra ?? '-' }}" disabled>
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-12">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Lain-Lain</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringIntrahd->intake_lain_intra ?? '-' }}" disabled>
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Pemantauan Cairan Output -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Pemantauan Cairan Output</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringIntrahd->output_intra ?? '-' }}" disabled>
                                                                <span class="input-group-text">ml</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="alert alert-info">
                                                        Tidak ada data Intra HD yang tersedia.
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Daftar Observasi Intra Tindakan HD -->
                                            <div class="daftarObservasiIntraTindakanHD">
                                                <div class="row mt-4">
                                                    <div class="col-12 mb-2">
                                                        <h6 class="fw-bold">Daftar Observasi Intra Tindakan HD</h6>
                                                    </div>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped" id="observasiTable">
                                                        <thead class="table-primary">
                                                            <tr class="text-center">
                                                                <th>Waktu</th>
                                                                <th>QB</th>
                                                                <th>QD</th>
                                                                <th>UF Rate</th>
                                                                <th>TD (mmHg)</th>
                                                                <th>Nadi / Menit</th>
                                                                <th>S°</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="observasiTableBody">
                                                            @if($asesmen->keperawatanMonitoringIntrahd && $asesmen->keperawatanMonitoringIntrahd->observasi_data)
                                                                @php
                                                                    $observasiData = json_decode($asesmen->keperawatanMonitoringIntrahd->observasi_data, true);
                                                                @endphp
                                                                @foreach($observasiData as $data)
                                                                    <tr class="text-center">
                                                                        <td>{{ $data['waktu'] ?? '-' }}</td>
                                                                        <td>{{ $data['qb'] ?? '-' }}</td>
                                                                        <td>{{ $data['qd'] ?? '-' }}</td>
                                                                        <td>{{ $data['uf_rate'] ?? '-' }}</td>
                                                                        <td>{{ $data['td'] ?? '-' }}</td>
                                                                        <td>{{ $data['nadi'] ?? '-' }}</td>
                                                                        <td>{{ $data['suhu'] ?? '-' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="7" class="text-center">Tidak ada data observasi tersedia.</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- Post HD -->
                                            <div class="post__HD">
                                                <div class="row mt-4">
                                                    <div class="col-12 mb-2">
                                                        <h6 class="fw-bold">Post HD</h6>
                                                    </div>
                                                </div>

                                                @if($asesmen->keperawatanMonitoringPosthd)
                                                    <!-- Lama Waktu Post HD -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Lama Waktu Post HD</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPosthd->lama_waktu_post_hd ?? '-' }}" disabled>
                                                                <span class="input-group-text">menit</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Parameter Mesin HD (QB dan QD) -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Parameter Mesin HD</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">QB</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPosthd->qb_post ?? '-' }}" disabled>
                                                                        <span class="input-group-text">ml/menit</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">QD</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPosthd->qd_post ?? '-' }}" disabled>
                                                                        <span class="input-group-text">ml/menit</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- UF Rate -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">UF Rate</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPosthd->uf_rate_post ?? '-' }}" disabled>
                                                                <span class="input-group-text">ml/menit</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tek. Darah (mmHg) - Sistole & Diastole -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Tek. Darah (mmHg)</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Sistole</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPosthd->sistole_post ?? '-' }}" disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Diastole</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPosthd->diastole_post ?? '-' }}" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nadi (Per Menit) -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Nadi (Per Menit)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPosthd->nadi_post ?? '-' }}" disabled>
                                                                <span class="input-group-text">x/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nafas (Per Menit) -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Nafas (Per Menit)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPosthd->nafas_post ?? '-' }}" disabled>
                                                                <span class="input-group-text">x/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Suhu (C) -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Suhu (C)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPosthd->suhu_post ?? '-' }}" disabled>
                                                                <span class="input-group-text">°C</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Pemantauan Cairan Intake -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Pemantauan Cairan Intake</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">NaCl</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPosthd->nacl_post ?? '-' }}" disabled>
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Minum</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPosthd->minum_post ?? '-' }}" disabled>
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-12">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Lain-Lain</span>
                                                                        <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPosthd->intake_lain_post ?? '-' }}" disabled>
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Pemantauan Cairan Output -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Pemantauan Cairan Output</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPosthd->output_post ?? '-' }}" disabled>
                                                                <span class="input-group-text">ml</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Jumlah Cairan Intake -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Jumlah Cairan Intake</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPosthd->jumlah_cairan_intake ?? '-' }}" disabled>
                                                                <span class="input-group-text">ml</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Jumlah Cairan Output -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Jumlah Cairan Output</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPosthd->jumlah_cairan_output ?? '-' }}" disabled>
                                                                <span class="input-group-text">ml</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Ultrafiltration Total -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Ultrafiltration Total</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" value="{{ $asesmen->keperawatanMonitoringPosthd->ultrafiltration_total ?? '-' }}" disabled>
                                                                <span class="input-group-text">ml</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Keterangan SOAPIE -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end fw-bold">Keterangan SOAPIE</label>
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
                                        <h5 class="section-title">12. Penyulit Selama HD</h5>

                                        @if($asesmen->keperawatan)
                                            <!-- Klinis -->
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label text-end fw-bold">Klinis</label>
                                                <div class="col-sm-10">
                                                    @php
                                                        $klinisValues = $asesmen->keperawatan->klinis_values ? json_decode($asesmen->keperawatan->klinis_values, true) : [];
                                                        $klinisDisplay = !empty($klinisValues) ? implode(', ', $klinisValues) : '-';
                                                    @endphp
                                                    <input type="text" class="form-control" value="{{ $klinisDisplay }}" disabled>
                                                </div>
                                            </div>

                                            <!-- Teknis -->
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label text-end fw-bold">Teknis</label>
                                                <div class="col-sm-10">
                                                    @php
                                                        $teknisValues = $asesmen->keperawatan->teknis_values ? json_decode($asesmen->keperawatan->teknis_values, true) : [];
                                                        $teknisDisplay = !empty($teknisValues) ? implode(', ', $teknisValues) : '-';
                                                    @endphp
                                                    <input type="text" class="form-control" value="{{ $teknisDisplay }}" disabled>
                                                </div>
                                            </div>

                                            <!-- Mesin -->
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label text-end fw-bold">Mesin</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" value="{{ $asesmen->keperawatan->mesin ?? '-' }}" disabled>
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
                                        <h5 class="section-title">13. Discharge Planning</h5>

                                        @if($asesmen->keperawatan)
                                            <!-- Rencana Pulang -->
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label text-end fw-bold">Rencana Pulang</label>
                                                <div class="col-sm-10">
                                                    @php
                                                        $rencanaPulangValues = $asesmen->keperawatan->rencana_pulang_values ? json_decode($asesmen->keperawatan->rencana_pulang_values, true) : [];
                                                        $rencanaPulangDisplay = !empty($rencanaPulangValues) ? implode(', ', $rencanaPulangValues) : '-';
                                                    @endphp
                                                    <input type="text" class="form-control" value="{{ $rencanaPulangDisplay }}" disabled>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                Tidak ada data discharge planning yang tersedia.
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Diagnosis -->
                                    <div class="section-separator" id="diagnosis">
                                        <h5 class="fw-semibold mb-4">14. Diagnosis</h5>

                                        @if($asesmen->keperawatan)
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
                                    </div>

                                    <!-- Implementasi -->
                                    <div class="section-separator" style="margin-bottom: 2rem;" id="implementasi">
                                        <h5 class="fw-semibold mb-4">15. Implementasi</h5>

                                        @if($asesmen->keperawatan)
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
                                    </div>

                                    <!-- Evaluasi -->
                                    <div class="section-separator mt-5">
                                        <h5 class="section-title">16. Evaluasi</h5>

                                        @if($asesmen->keperawatan)
                                            <!-- Evaluasi Keperawatan -->
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label class="form-label fw-bold">Evaluasi Keperawatan</label>
                                                    <textarea class="form-control" rows="4" disabled>{{ $asesmen->keperawatan->evaluasi_keperawatan ?? '-' }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Evaluasi Medis -->
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <label class="form-label fw-bold">Evaluasi Medis</label>
                                                    <textarea class="form-control" rows="4" disabled>{{ $asesmen->keperawatan->evaluasi_medis ?? '-' }}</textarea>
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
                                        <h5 class="section-title">17. Tanda Tangan dan Verifikasi</h5>

                                        @if($asesmen->keperawatan)
                                            <!-- E-Signature Perawat Pemeriksa Akses Vaskular -->
                                            <div class="row mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label fw-bold">E-Signature Nama Perawat Pemeriksa Akses Vaskular</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" value="{{ $asesmen->keperawatan->perawat_pemeriksa ? ($perawat->firstWhere('kd_karyawan', $asesmen->keperawatan->perawat_pemeriksa)->gelar_depan . ' ' . $perawat->firstWhere('kd_karyawan', $asesmen->keperawatan->perawat_pemeriksa)->nama . ' ' . $perawat->firstWhere('kd_karyawan', $asesmen->keperawatan->perawat_pemeriksa)->gelar_belakang) : '-' }}" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- E-Signature Perawat Yang Bertugas -->
                                            <div class="row mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label fw-bold">E-Signature Nama Perawat Yang Bertugas</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" value="{{ $asesmen->keperawatan->perawat_bertugas ? ($perawat->firstWhere('kd_karyawan', $asesmen->keperawatan->perawat_bertugas)->gelar_depan . ' ' . $perawat->firstWhere('kd_karyawan', $asesmen->keperawatan->perawat_bertugas)->nama . ' ' . $perawat->firstWhere('kd_karyawan', $asesmen->keperawatan->perawat_bertugas)->gelar_belakang) : '-' }}" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- E-Signature Dokter DPJP -->
                                            <div class="row mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label fw-bold">E-Signature Nama Dokter (DPJP)</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" value="{{ $asesmen->keperawatan->dokter_pelaksana ? ($dokterPelaksana->firstWhere('dokter.kd_dokter', $asesmen->keperawatan->dokter_pelaksana)->dokter->nama_lengkap ?? '-') : '-' }}" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                Tidak ada data tanda tangan dan verifikasi yang tersedia.
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
