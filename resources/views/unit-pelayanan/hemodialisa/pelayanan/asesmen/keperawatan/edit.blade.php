@extends('layouts.administrator.master')

@section('content')
@include('unit-pelayanan.hemodialisa.pelayanan.asesmen.keperawatan.edit-include')
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
            <form action="{{ route('hemodialisa.pelayanan.asesmen.keperawatan.update', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $asesmen->id]) }}" method="post">
                @csrf
                @method('put')

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100">
                        <div class="card-body">
                            <div class="px-3">

                                {{-- FORM ASESMEN AWAL KEPERATAWAN --}}

                                <div class="px-3">
                                    <div>
                                        <div class="section-separator">
                                            <h5 class="section-title">1. Anamnesis</h5>

                                            <div class="form-group">
                                                <label for="anamnesis" style="min-width: 200px;">Anamnesis</label>
                                                <textarea name="anamnesis" id="anamnesis" class="form-control @error('anamnesis') is-invalid @enderror" rows="4">{{ old('anamnesis', $asesmen->keperawatan->anamnesis ?? '') }}</textarea>
                                                @error('anamnesis')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="section-separator">
                                            <h5 class="section-title">2. Pemeriksaan Fisik</h5>

                                            <div class="form-group align-items-center">
                                                <label style="min-width: 200px;">Tek. Darah (mmHg)</label>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="sistole" class="form-label">Sistole</label>
                                                        <input type="number" name="fisik_sistole" id="sistole" class="form-control @error('fisik_sistole') is-invalid @enderror" value="{{ old('fisik_sistole', $asesmen->keperawatanPemeriksaanFisik->fisik_sistole ?? '') }}">
                                                        @error('fisik_sistole')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="diastole" class="form-label">Diastole</label>
                                                        <input type="number" name="fisik_diastole" id="diastole" class="form-control @error('fisik_diastole') is-invalid @enderror" value="{{ old('fisik_diastole', $asesmen->keperawatanPemeriksaanFisik->fisik_diastole ?? '') }}">
                                                        @error('fisik_diastole')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="nadi" style="min-width: 200px;">Nadi (Per Menit)</label>
                                                <input type="number" name="fisik_nadi" id="nadi" class="form-control @error('fisik_nadi') is-invalid @enderror" value="{{ old('fisik_nadi', $asesmen->keperawatanPemeriksaanFisik->fisik_nadi ?? '') }}">
                                                @error('fisik_nadi')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="nafas" style="min-width: 200px;">Nafas (Per Menit)</label>
                                                <input type="number" name="fisik_nafas" id="nafas" class="form-control @error('fisik_nadi') is-invalid @enderror" value="{{ old('fisik_nafas', $asesmen->keperawatanPemeriksaanFisik->fisik_nafas ?? '') }}">
                                                @error('fisik_nafas')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="suhu" style="min-width: 200px;">Suhu (C)</label>
                                                <input type="number" name="fisik_suhu" id="suhu" class="form-control @error('fisik_suhu') is-invalid @enderror" value="{{ old('fisik_suhu', $asesmen->keperawatanPemeriksaanFisik->fisik_suhu ?? '') }}">
                                                @error('fisik_suhu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group align-items-center">
                                                <label style="min-width: 200px;">Saturasi Oksigen (%)</label>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="so_tb_o2" class="form-label">Tanpa bantuan O2</label>
                                                        <input type="number" name="so_tb_o2" id="so_tb_o2" class="form-control @error('so_tb_o2') is-invalid @enderror" value="{{ old('so_tb_o2', $asesmen->keperawatanPemeriksaanFisik->so_tb_o2 ?? '') }}">
                                                        @error('so_tb_o2')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="so_db_o2" class="form-label">Dengan bantuan O2</label>
                                                        <input type="number" name="so_db_o2" id="so_db_o2" class="form-control @error('so_db_o2') is-invalid @enderror" value="{{ old('so_db_o2', $asesmen->keperawatanPemeriksaanFisik->so_db_o2 ?? '') }}">
                                                        @error('so_db_o2')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="avpu" style="min-width: 200px;">AVPU</label>
                                                <select name="avpu" id="avpu" class="form-select @error('avpu') is-invalid @enderror">
                                                    <option value="">--Pilih--</option>
                                                    <option value="0" {{ old('avpu', $asesmen->keperawatanPemeriksaanFisik->avpu ?? '') === '0' ? 'selected' : '' }}>Sadar Baik/Alert: 0</option>
                                                    <option value="1" {{ old('avpu', $asesmen->keperawatanPemeriksaanFisik->avpu ?? '') === '1' ? 'selected' : '' }}>Berespon dengan kata-kata/Voice: 1</option>
                                                    <option value="2" {{ old('avpu', $asesmen->keperawatanPemeriksaanFisik->avpu ?? '') === '2' ? 'selected' : '' }}>Hanya berespons jika dirangsang nyeri/Pain: 2</option>
                                                    <option value="3" {{ old('avpu', $asesmen->keperawatanPemeriksaanFisik->avpu ?? '') === '3' ? 'selected' : '' }}>Pasien tidak sadar/Unresponsive: 3</option>
                                                    <option value="4" {{ old('avpu', $asesmen->keperawatanPemeriksaanFisik->avpu ?? '') === '4' ? 'selected' : '' }}>Gelisah atau bingung: 4</option>
                                                    <option value="5" {{ old('avpu', $asesmen->keperawatanPemeriksaanFisik->avpu ?? '') === '5' ? 'selected' : '' }}>Acute Confusional States: 5</option>
                                                </select>
                                                @error('avpu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="edema" style="min-width: 200px;">Edema</label>
                                                <select name="edema" id="edema" class="form-select @error('edema') is-invalid @enderror">
                                                    <option value="">--Pilih--</option>
                                                    <option value="0" {{ old('edema', $asesmen->keperawatanPemeriksaanFisik->edema ?? '') === '0' ? 'selected' : '' }}>Tidak</option>
                                                    <option value="1" {{ old('edema', $asesmen->keperawatanPemeriksaanFisik->edema ?? '') === '1' ? 'selected' : '' }}>Ya</option>
                                                </select>
                                                @error('edema')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="konjungtiva" style="min-width: 200px;">Konjungtiva</label>
                                                <select name="konjungtiva" id="konjungtiva" class="form-select @error('konjungtiva') is-invalid @enderror">
                                                    <option value="">--Pilih--</option>
                                                    <option value="0" {{ old('konjungtiva', $asesmen->keperawatanPemeriksaanFisik->konjungtiva ?? '') === '0' ? 'selected' : '' }}>Tidak Anemis</option>
                                                    <option value="1" {{ old('konjungtiva', $asesmen->keperawatanPemeriksaanFisik->konjungtiva ?? '') === '1' ? 'selected' : '' }}>Anemis</option>
                                                </select>
                                                @error('konjungtiva')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="dehidrasi" style="min-width: 200px;">Dehidrasi</label>
                                                <select name="dehidrasi" id="dehidrasi" class="form-select @error('dehidrasi') is-invalid @enderror">
                                                    <option value="">--Pilih--</option>
                                                    <option value="0" {{ old('dehidrasi', $asesmen->keperawatanPemeriksaanFisik->dehidrasi ?? '') === '0' ? 'selected' : '' }}>Tidak</option>
                                                    <option value="1" {{ old('dehidrasi', $asesmen->keperawatanPemeriksaanFisik->dehidrasi ?? '') === '1' ? 'selected' : '' }}>Ya</option>
                                                </select>
                                                @error('dehidrasi')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <p class="fw-bold">Antropometri</p>

                                            <div class="form-group">
                                                <label for="tinggi_badan" style="min-width: 200px;">Tinggi Badan (Cm)</label>
                                                <input type="number" name="tinggi_badan" id="tinggi_badan" class="form-control @error('tinggi_badan') is-invalid @enderror" value="{{ old('tinggi_badan', $asesmen->keperawatanPemeriksaanFisik->tinggi_badan ?? '') }}">
                                                @error('tinggi_badan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="berat_badan" style="min-width: 200px;">Berat Badan (Kg)</label>
                                                <input type="number" name="berat_badan" id="berat_badan" class="form-control @error('berat_badan') is-invalid @enderror" value="{{ old('berat_badan', $asesmen->keperawatanPemeriksaanFisik->berat_badan ?? '') }}">
                                                @error('berat_badan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="imt" style="min-width: 200px;">Index Massa Tubuh (IMT)</label>
                                                <input type="number" name="imt" id="imt" class="form-control" value="{{ old('imt', $asesmen->keperawatanPemeriksaanFisik->imt ?? '') }}" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="lpt" style="min-width: 200px;">Luas Permukaan Tubuh (LPT)</label>
                                                <input type="number" name="lpt" id="lpt" class="form-control" value="{{ old('lpt', $asesmen->keperawatanPemeriksaanFisik->lpt ?? '') }}" readonly>
                                            </div>


                                            <div class="alert alert-info mb-3">
                                                <p class="mb-0 small">
                                                    <i class="bi bi-info-circle me-2"></i>
                                                    Centang normal jika fisik yang dinilai normal, pilih tanda tambah untuk
                                                    menambah
                                                    keterangan fisik yang ditemukan tidak normal.
                                                    Jika tidak dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                                </p>
                                            </div>

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
                                                                $keterangan = $pemeriksaanData->keterangan;
                                                                $isNormal = empty($keterangan);
                                                                }
                                                                @endphp
                                                                <div class="pemeriksaan-item">
                                                                    <div class="d-flex align-items-center border-bottom pb-2">
                                                                        <div class="flex-grow-1">{{ $item->nama }}
                                                                        </div>
                                                                        <div class="form-check me-3">
                                                                            <input type="checkbox" class="form-check-input"
                                                                                id="{{ $item->id }}-normal"
                                                                                name="{{ $item->id }}-normal" {{ $isNormal
                                                                                ? 'checked' : '' }}>
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
                                                                    <div class="keterangan mt-2" id="{{ $item->id }}-keterangan"
                                                                        style="display:{{ $isNormal ? 'none' : 'block' }};">
                                                                        <input type="text" class="form-control"
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

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Jenis Skala Nyeri</label>
                                                <input type="text" class="form-control" value="Scale NRS, VAS, VRS" disabled>
                                            </div>

                                            <div class="form-group justify-content-center">
                                                <img src="{{ asset('assets/img/cppt/cppt.jpeg') }}" alt="" class="w-50">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Nilai Skala Nyeri</label>
                                                <input type="number" name="status_skala_nyeri" class="form-control" min="0" max="10"
                                                    value="{{ $asesmen->keperawatan->status_skala_nyeri ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="section-separator">
                                            <h5 class="section-title">4. Riwayat Kesehatan</h5>
                                            <div class="form-group">
                                                <label for="gagal_ginjal_stadium" style="min-width: 200px;">Gagal Ginjal Stadium</label>
                                                <input type="number" name="gagal_ginjal_stadium" class="form-control" value="{{ $asesmen->keperawatan->gagal_ginjal_stadium ?? '' }}">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="jenis_gagal_ginjal" style="min-width: 200px;">Jenis Gagal Ginjal</label>
                                                <select class="form-control" id="jenis_gagal_ginjal" name="jenis_gagal_ginjal">
                                                    <option value="">pilih</option>
                                                    <option value="akut" {{ ($asesmen->keperawatan->jenis_gagal_ginjal ?? '') == 'akut' ? 'selected' : '' }}>Akut</option>
                                                    <option value="kronis" {{ ($asesmen->keperawatan->jenis_gagal_ginjal ?? '') == 'kronis' ? 'selected' : '' }}>Kronis</option>
                                                    <option value="lainnya" {{ ($asesmen->keperawatan->jenis_gagal_ginjal ?? '') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="lama_menjalani_hd" style="min-width: 200px;">Lama Menjalani HD</label>
                                                <input type="number" class="form-control" id="lama_menjalani_hd" name="lama_menjalani_hd" value="{{ $asesmen->keperawatan->lama_menjalani_hd ?? '' }}">
                                                <input type="text" class="form-control" id="lama_menjalani_hd_unit" name="lama_menjalani_hd_unit" placeholder="tahun/bulan" value="{{ $asesmen->keperawatan->lama_menjalani_hd_unit ?? '' }}">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="jadwal_hd_rutin" style="min-width: 200px;">Jadwal HD Rutin</label>
                                                <input type="number" class="form-control" id="jadwal_hd_rutin" name="jadwal_hd_rutin" value="{{ $asesmen->keperawatan->jadwal_hd_rutin ?? '' }}">
                                                <input type="text" class="form-control" id="jadwal_hd_rutin_unit" name="jadwal_hd_rutin_unit" placeholder="Per minggu" value="{{ $asesmen->keperawatan->jadwal_hd_rutin_unit ?? '' }}">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="sesak_nafas" style="min-width: 200px;">Sesak Nafas/Nyeri Dada</label>
                                                <select class="form-control" id="sesak_nafas" name="sesak_nafas">
                                                    <option value="">pilih</option>
                                                    <option value="ya" {{ ($asesmen->keperawatan->sesak_nafas ?? '') == 'ya' ? 'selected' : '' }}>Ya</option>
                                                    <option value="tidak" {{ ($asesmen->keperawatan->sesak_nafas ?? '') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Riwayat penggunaan obat pada pasien -->
                                        <div class="section-separator">
                                            <h5 class="section-title">5. Riwayat Obat dan Rekomendasi Dokter</h5>

                                            <!-- Riwayat penggunaan obat pada pasien -->
                                            <div class="mb-4">
                                                <p class="mb-2">Riwayat penggunaan obat pada pasien</p>

                                                <button type="button"
                                                    class="btn btn-sm btn-outline-primary d-flex align-items-center mb-3"
                                                    data-bs-toggle="modal" data-bs-target="#modalTambahObat">
                                                    <i class="bi bi-plus-circle me-1"></i> Tambah
                                                </button>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th width="33%">Nama Obat</th>
                                                                <th width="33%">Dosis</th>
                                                                <th width="33%">Waktu penggunaan</th>
                                                                <th width="1%">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tableObatPasien">
                                                            <!-- Data obat pasien akan di-render secara dinamis dengan JavaScript -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- Hidden input untuk menyimpan data JSON obat pasien -->
                                                <input type="hidden" name="obat_pasien" id="obat_pasien_json" value="{{ $asesmen->keperawatan->obat_pasien ?? '' }}">
                                            </div>

                                            <!-- Obat tambahan dokter -->
                                            <div class="mb-4">
                                                <p class="mb-2">Jika terdapat obat tambahan dokter</p>

                                                <button type="button"
                                                    class="btn btn-sm btn-outline-primary d-flex align-items-center mb-3"
                                                    data-bs-toggle="modal" data-bs-target="#modalTambahObatDokter">
                                                    <i class="bi bi-plus-circle me-1"></i> Tambah
                                                </button>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th width="33%">Nama Obat</th>
                                                                <th width="33%">Dosis</th>
                                                                <th width="33%">Waktu penggunaan</th>
                                                                <th width="1%">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tableObatDokter">
                                                            <!-- Data obat dokter akan di-render secara dinamis dengan JavaScript -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- Hidden input untuk menyimpan data JSON obat dokter -->
                                                <input type="hidden" name="obat_dokter" id="obat_dokter_json" value="{{ $asesmen->keperawatan->obat_dokter ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="section-separator">
                                            <h5 class="section-title">6. Pemeriksaan Penunjang</h5>

                                            <!-- Pre Hemodialisis -->
                                            <div class="mb-4">
                                                <p class="fw-medium mb-3">Pre Hemodialisis</p>

                                                <div class="row mb-3">
                                                    <label for="pre-ekg" class="col-sm-2 col-form-label text-end">EKG</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="pre-ekg" name="pre_ekg"
                                                            placeholder="freetext" value="{{ $asesmen->keperawatanPempen->pre_ekg ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="pre-rontgent" class="col-sm-2 col-form-label text-end">Rontgent</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="pre-rontgent" name="pre_rontgent"
                                                            placeholder="freetext" value="{{ $asesmen->keperawatanPempen->pre_rontgent ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="pre-usg" class="col-sm-2 col-form-label text-end">USG</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="pre-usg" name="pre_usg"
                                                            placeholder="freetext" value="{{ $asesmen->keperawatanPempen->pre_usg ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="pre-dll" class="col-sm-2 col-form-label text-end">Dll</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="pre-dll" name="pre_dll"
                                                            placeholder="freetext" value="{{ $asesmen->keperawatanPempen->pre_dll ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Post Hemodialisis -->
                                            <div class="mb-4">
                                                <p class="fw-medium mb-3">Post Hemodialisis</p>

                                                <div class="row mb-3">
                                                    <label for="post-ekg" class="col-sm-2 col-form-label text-end">EKG</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="post-ekg" name="post_ekg"
                                                            placeholder="freetext" value="{{ $asesmen->keperawatanPempen->post_ekg ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="post-rontgent" class="col-sm-2 col-form-label text-end">Rontgent</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="post-rontgent" name="post_rontgent"
                                                            placeholder="freetext" value="{{ $asesmen->keperawatanPempen->post_rontgent ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="post-usg" class="col-sm-2 col-form-label text-end">USG</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="post-usg" name="post_usg"
                                                            placeholder="freetext" value="{{ $asesmen->keperawatanPempen->post_usg ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="post-dll" class="col-sm-2 col-form-label text-end">Dll</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="post-dll" name="post_dll"
                                                            placeholder="freetext" value="{{ $asesmen->keperawatanPempen->post_dll ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="section-separator" id="alergi">
                                            <h5 class="section-title">7. Alergi</h5>
                                            <input type="hidden" name="alergi"
                                                value="{{ $asesmen->keperawatan->alergi ?? '[]' }}">
                                            <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                                id="openAlergiModal">
                                                <i class="ti-plus"></i> Tambah
                                            </button>

                                            <div class="table-responsive">
                                                <table class="table" id="createAlergiTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Alergen</th>
                                                            <th>Reaksi</th>
                                                            <th>Severe</th>
                                                            <th>Aktion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Table content will be dynamically populated -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            @push('modals')
                                                @include('unit-pelayanan.hemodialisa.pelayanan.asesmen.keperawatan.modal-edit-alergi')
                                            @endpush
                                        </div>

                                        <div class="section-separator">
                                            <h5 class="section-title">8. Status Gizi</h5>

                                            <div class="row mb-3">
                                                <label for="gizi_tanggal_pengkajian" class="col-sm-3 col-form-label">Tanggal
                                                    Pengkajian</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="datetime-local" class="form-control"
                                                            id="gizi_tanggal_pengkajian" name="gizi_tanggal_pengkajian"
                                                            value="{{ old('gizi_tanggal_pengkajian', isset($asesmen->keperawatanStatusGizi->gizi_tanggal_pengkajian) ? Carbon\Carbon::parse($asesmen->keperawatanStatusGizi->gizi_tanggal_pengkajian)->format('Y-m-d\TH:i') : '') }}">
                                                    </div>
                                                    @error('gizi_tanggal_pengkajian')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="gizi_skore_mis" class="col-sm-3 col-form-label">Skore
                                                    MIS</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" id="gizi_skore_mis"
                                                        name="gizi_skore_mis" placeholder="Angka"
                                                        value="{{ $asesmen->keperawatanStatusGizi->gizi_skore_mis ?? '' }}">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="gizi_kesimpulan"
                                                    class="col-sm-3 col-form-label">Kesimpulan</label>
                                                <div class="col-sm-9">
                                                    <select class="form-select" id="gizi_kesimpulan" name="gizi_kesimpulan">
                                                        <option value="">pilih</option>
                                                        <option value="Tampa mainutrisi (<6)" {{ ($asesmen->keperawatanStatusGizi->gizi_kesimpulan ?? '') == 'Tampa mainutrisi (<6)' ? 'selected' : '' }}>Tampa mainutrisi (6)</option>
                                                        <option value="Malnutrisi(>6)" {{ ($asesmen->keperawatanStatusGizi->gizi_kesimpulan ?? '') == 'Malnutrisi(>6)' ? 'selected' : '' }}>Malnutrisi(>6)</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="gizi_rencana_pengkajian" class="col-sm-3 col-form-label">Rencana
                                                    Pengkajian Ulang MIS</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="gizi_rencana_pengkajian"
                                                        name="gizi_rencana_pengkajian" placeholder="jelaskan"
                                                        value="{{ $asesmen->keperawatanStatusGizi->gizi_rencana_pengkajian ?? '' }}">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="gizi_rekomendasi"
                                                    class="col-sm-3 col-form-label">Rekomendasi</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="gizi_rekomendasi"
                                                        name="gizi_rekomendasi" placeholder="jelaskan"
                                                        value="{{ $asesmen->keperawatanStatusGizi->gizi_rekomendasi ?? '' }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="section-separator">
                                            <h5 class="section-title">9. Risiko Jatuh</h5>

                                            <h6 class="mt-3 mb-3">Penilaian Risiko Jatuh Skala Morse</h6>

                                            <div class="form-group mb-3">
                                                <label class="form-label">Riwayat jatuh yang baru atau dalam bulan terakhir</label>
                                                <select class="form-select risiko-jatuh-select" id="riwayat_jatuh" name="riwayat_jatuh" data-skor="25">
                                                    <option value="">pilih</option>
                                                    <option value="Ya" data-skor="25" {{ ($asesmen->keperawatanRisikoJatuh->riwayat_jatuh ?? '') == 'Ya' ? 'selected' : '' }}>Ya</option>
                                                    <option value="Tidak" data-skor="0" {{ ($asesmen->keperawatanRisikoJatuh->riwayat_jatuh ?? '') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">Pasien memiliki Diagnosa medis sekunder > 1 ?</label>
                                                <select class="form-select risiko-jatuh-select" id="diagnosa_sekunder" name="diagnosa_sekunder" data-skor="15">
                                                    <option value="">pilih</option>
                                                    <option value="Ya" data-skor="15" {{ ($asesmen->keperawatanRisikoJatuh->diagnosa_sekunder ?? '') == 'Ya' ? 'selected' : '' }}>Ya</option>
                                                    <option value="Tidak" data-skor="0" {{ ($asesmen->keperawatanRisikoJatuh->diagnosa_sekunder ?? '') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">Pasien membutuhkan bantuan Alat bantu jalan ?</label>
                                                <select class="form-select risiko-jatuh-select" id="alat_bantu" name="alat_bantu" data-skor="30">
                                                    <option value="">pilih</option>
                                                    <option value="Tidak ada/ bed rest/ bantuan perawat" data-skor="0" {{ ($asesmen->keperawatanRisikoJatuh->alat_bantu ?? '') == 'Tidak ada/ bed rest/ bantuan perawat' ? 'selected' : '' }}>Tidak ada/ bed rest/ bantuan perawat</option>
                                                    <option value="kruk/ tongkat/ alat bantu berjalan" data-skor="15" {{ ($asesmen->keperawatanRisikoJatuh->alat_bantu ?? '') == 'kruk/ tongkat/ alat bantu berjalan' ? 'selected' : '' }}>kruk/ tongkat/ alat bantu berjalan</option>
                                                    <option value="Meja/ Kursi" data-skor="30" {{ ($asesmen->keperawatanRisikoJatuh->alat_bantu ?? '') == 'Meja/ Kursi' ? 'selected' : '' }}>Meja/ Kursi</option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">Pasien terpasang infus?</label>
                                                <select class="form-select risiko-jatuh-select" id="infus" name="infus" data-skor="20">
                                                    <option value="">pilih</option>
                                                    <option value="Ya" data-skor="20" {{ ($asesmen->keperawatanRisikoJatuh->infus ?? '') == 'Ya' ? 'selected' : '' }}>Ya</option>
                                                    <option value="Tidak" data-skor="0" {{ ($asesmen->keperawatanRisikoJatuh->infus ?? '') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">Bagaimana cara berjalan pasien?</label>
                                                <select class="form-select risiko-jatuh-select" id="cara_berjalan" name="cara_berjalan" data-skor="20">
                                                    <option value="">pilih</option>
                                                    <option value="Normal/ bed rest/ kursi roda" data-skor="0" {{ ($asesmen->keperawatanRisikoJatuh->cara_berjalan ?? '') == 'Normal/ bed rest/ kursi roda' ? 'selected' : '' }}>Normal/ bed rest/ kursi roda</option>
                                                    <option value="Lemah" data-skor="10" {{ ($asesmen->keperawatanRisikoJatuh->cara_berjalan ?? '') == 'Lemah' ? 'selected' : '' }}>Lemah</option>
                                                    <option value="Terganggu" data-skor="20" {{ ($asesmen->keperawatanRisikoJatuh->cara_berjalan ?? '') == 'Terganggu' ? 'selected' : '' }}>Terganggu</option>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">Bagaimana status mental pasien?</label>
                                                <select class="form-select risiko-jatuh-select" id="status_mental" name="status_mental" data-skor="15">
                                                    <option value="">pilih</option>
                                                    <option value="Orientasi sesuai kemampuan" data-skor="0" {{ ($asesmen->keperawatanRisikoJatuh->status_mental ?? '') == 'Orientasi sesuai kemampuan' ? 'selected' : '' }}>Orientasi sesuai kemampuan</option>
                                                    <option value="Lupa keterbatasan" data-skor="15" {{ ($asesmen->keperawatanRisikoJatuh->status_mental ?? '') == 'Lupa keterbatasan' ? 'selected' : '' }}>Lupa keterbatasan</option>
                                                </select>
                                            </div>

                                            <div class="alert alert-info mt-4 mb-3" id="total-skor-container">
                                                <strong>Total Skor: </strong> <span id="total-skor">{{ $asesmen->keperawatanRisikoJatuh->risiko_jatuh_skor ?? '0' }}</span>
                                            </div>

                                            <div class="alert alert-primary" id="kesimpulan-container">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <strong>Kesimpulan: </strong>
                                                    <span id="kesimpulan-text">{{ $asesmen->keperawatanRisikoJatuh->risiko_jatuh_kesimpulan ?? '-' }}</span>
                                                </div>
                                            </div>

                                            <!-- Hidden input untuk menyimpan data ke database -->
                                            <input type="hidden" name="risiko_jatuh_skor" id="risiko_jatuh_skor" value="{{ $asesmen->keperawatanRisikoJatuh->risiko_jatuh_skor ?? '0' }}">
                                            <input type="hidden" name="risiko_jatuh_kesimpulan" id="risiko_jatuh_kesimpulan" value="{{ $asesmen->keperawatanRisikoJatuh->risiko_jatuh_kesimpulan ?? '' }}">
                                        </div>

                                        <div class="section-separator">
                                            <h5 class="section-title">10. Status Psikososial</h5>

                                            <div class="row mb-3">
                                                <label for="tanggal_pengkajian_psiko" class="col-sm-3 col-form-label">Tanggal Pengkajian</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="date" class="form-control" id="tanggal_pengkajian_psiko" name="tanggal_pengkajian_psiko"
                                                            value="{{ old('tanggal_pengkajian_psiko', $asesmen->keperawatanStatusPsikososial->tanggal_pengkajian_psiko ?? '') }}"
                                                            autocomplete="off">
                                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                                    </div>
                                                    @error('tanggal_pengkajian_psiko')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="kendala_komunikasi" class="col-sm-3 col-form-label">Kendala Komunikasi</label>
                                                <div class="col-sm-9">
                                                    <select class="form-select" id="kendala_komunikasi" name="kendala_komunikasi">
                                                        <option value="">pilih</option>
                                                        <option value="Normal" {{ ($asesmen->keperawatanStatusPsikososial->kendala_komunikasi ?? '') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                                        <option value="Tidak jelas" {{ ($asesmen->keperawatanStatusPsikososial->kendala_komunikasi ?? '') == 'Tidak jelas' ? 'selected' : '' }}>Tidak Jelas</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="yang_merawat" class="col-sm-3 col-form-label">Yang Merawat di rumah</label>
                                                <div class="col-sm-9">
                                                    <select class="form-select" id="yang_merawat" name="yang_merawat">
                                                        <option value="">pilih</option>
                                                        <option value="Ada" {{ ($asesmen->keperawatanStatusPsikososial->yang_merawat ?? '') == 'Ada' ? 'selected' : '' }}>Ada</option>
                                                        <option value="Tidak" {{ ($asesmen->keperawatanStatusPsikososial->yang_merawat ?? '') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="kondisi_psikologis" class="col-sm-3 col-form-label">Kondisi Psikologis</label>
                                                <div class="col-sm-9">
                                                    <div class="btn-group" role="group">
                                                        @php
                                                            $kondisi_psikologis = $asesmen->keperawatanStatusPsikososial->kondisi_psikologis_json ?? '[]';
                                                            $kondisi_array = json_decode($kondisi_psikologis, true) ?? [];
                                                        @endphp

                                                        <input type="checkbox" class="btn-check" id="kondisi_cemas"
                                                            name="kondisi_psikologis[]" value="Cemas" autocomplete="off"
                                                            {{ in_array('Cemas', $kondisi_array) ? 'checked' : '' }}>
                                                        <label class="btn btn-outline-secondary" for="kondisi_cemas">
                                                            Cemas <i class="bi bi-check"></i>
                                                        </label>

                                                        <input type="checkbox" class="btn-check" id="kondisi_marah"
                                                            name="kondisi_psikologis[]" value="Marah" autocomplete="off"
                                                            {{ in_array('Marah', $kondisi_array) ? 'checked' : '' }}>
                                                        <label class="btn btn-outline-secondary" for="kondisi_marah">
                                                            Marah <i class="bi bi-check"></i>
                                                        </label>

                                                        <input type="checkbox" class="btn-check" id="kondisi_sedih"
                                                            name="kondisi_psikologis[]" value="Sedih" autocomplete="off"
                                                            {{ in_array('Sedih', $kondisi_array) ? 'checked' : '' }}>
                                                        <label class="btn btn-outline-secondary" for="kondisi_sedih">
                                                            Sedih <i class="bi bi-check"></i>
                                                        </label>

                                                        <input type="checkbox" class="btn-check" id="kondisi_takut"
                                                            name="kondisi_psikologis[]" value="Takut" autocomplete="off"
                                                            {{ in_array('Takut', $kondisi_array) ? 'checked' : '' }}>
                                                        <label class="btn btn-outline-secondary" for="kondisi_takut">
                                                            Takut <i class="bi bi-check"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="kepatuhan_layanan" class="col-sm-3 col-form-label">Apakah kepatuhan/ keterlibatan pasien berkaitan dengan pelayanan kesehatan yang akan diberikan</label>
                                                <div class="col-sm-9">
                                                    <select class="form-select" id="kepatuhan_layanan" name="kepatuhan_layanan" onchange="toggleJikaYa()">
                                                        <option value="">pilih</option>
                                                        <option value="Ya" {{ ($asesmen->keperawatanStatusPsikososial->kepatuhan_layanan ?? '') == 'Ya' ? 'selected' : '' }}>Ya</option>
                                                        <option value="Tidak" {{ ($asesmen->keperawatanStatusPsikososial->kepatuhan_layanan ?? '') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3" id="jika_ya_container" style="display: {{ ($asesmen->keperawatanStatusPsikososial->kepatuhan_layanan ?? '') == 'Ya' ? 'flex' : 'none' }};">
                                                <label for="jika_ya_jelaskan" class="col-sm-3 col-form-label">Jika Iya Jelaskan</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="jika_ya_jelaskan" name="jika_ya_jelaskan"
                                                        placeholder="jelaskan" value="{{ $asesmen->keperawatanStatusPsikososial->jika_ya_jelaskan ?? '' }}">
                                                </div>
                                            </div>

                                            <input type="hidden" name="kondisi_psikologis_json" id="kondisi_psikologis_json"
                                                value="{{ $asesmen->keperawatanStatusPsikososial->kondisi_psikologis_json ?? '[]' }}">
                                        </div>

                                        <div class="section-separator">
                                            <h5 class="section-title">11. Monitoring Hemodialisis</h5>

                                            <!-- 1. Preekripsi Hemodialisis -->
                                            <div class="preekripsi__hemodialisis">
                                                <!-- Hidden input untuk menyimpan data JSON -->
                                                <input type="hidden" id="monitoring_hemodialisis_data" name="monitoring_hemodialisis_data"
                                                    value="{{ $asesmen->keperawatanMonitoringPreekripsi->data ?? '{}' }}">
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
                                                        <label for="hd_ke" class="col-sm-2 col-form-label text-end">HD Ke</label>
                                                        <div class="col-sm-10">
                                                            <input type="number" class="form-control" id="hd_ke" name="inisiasi_hd_ke" placeholder="angka">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="nomor_mesin" class="col-sm-2 col-form-label text-end">Nomor Mesin</label>
                                                        <div class="col-sm-10">
                                                            <input type="number" class="form-control" id="nomor_mesin" name="inisiasi_nomor_mesin" placeholder="angka">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="bb_hd_lalu" class="col-sm-2 col-form-label text-end">BB HD Yang Lalu</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="bb_hd_lalu" name="inisiasi_bb_hd_lalu">
                                                                <span class="input-group-text">kg</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="tekanan_vena" class="col-sm-2 col-form-label text-end">Tekanan Vena</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="tekanan_vena" name="inisiasi_tekanan_vena">
                                                                <span class="input-group-text">ml/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="lama_hd" class="col-sm-2 col-form-label text-end">Lama HD</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="lama_hd" name="inisiasi_lama_hd">
                                                                <span class="input-group-text">Jam</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="program_profiling" class="col-sm-2 col-form-label text-end">Program Profiling</label>
                                                        <div class="col-sm-10">
                                                            <div class="row mb-2">
                                                                <div class="col-md-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" id="uf_profiling"
                                                                            name="program_profiling[]" value="UF Profiling Mode"
                                                                            {{ in_array('UF Profiling Mode', explode(',', $asesmen->keperawatanMonitoringPreekripsi->program_profiling ?? '')) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="uf_profiling">UF Profiling Mode</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" id="uf_profiling_detail"
                                                                        name="inisiasi_uf_profiling_detail" placeholder="Freetext"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_uf_profiling_detail ?? '' }}">
                                                                </div>
                                                            </div>

                                                            <div class="row mb-2">
                                                                <div class="col-md-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" id="bicarbonat_profiling"
                                                                            name="program_profiling[]" value="Bicarbonat Profiling"
                                                                            {{ in_array('Bicarbonat Profiling', explode(',', $asesmen->keperawatanMonitoringPreekripsi->program_profiling ?? '')) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="bicarbonat_profiling">Bicarbonat Profiling</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" id="bicarbonat_profiling_detail"
                                                                        name="inisiasi_bicarbonat_profiling_detail" placeholder="Freetext"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_bicarbonat_profiling_detail ?? '' }}">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" id="na_profiling"
                                                                            name="program_profiling[]" value="Na Profiling Mode"
                                                                            {{ in_array('Na Profiling Mode', explode(',', $asesmen->keperawatanMonitoringPreekripsi->program_profiling ?? '')) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="na_profiling">Na Profiling Mode</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" id="na_profiling_detail"
                                                                        name="inisiasi_na_profiling_detail" placeholder="Freetext"
                                                                        value="{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_na_profiling_detail ?? '' }}">
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
                                                        <label for="type_dializer" class="col-sm-2 col-form-label text-end">Type Dializer</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="type_dializer" name="akut_type_dializer" placeholder="freetext">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="uf_goal" class="col-sm-2 col-form-label text-end">UF Goal</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="uf_goal" name="akut_uf_goal" placeholder="freetext">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="bb_pre_hd" class="col-sm-2 col-form-label text-end">BB Pre HD</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="bb_pre_hd" name="akut_bb_pre_hd">
                                                                <span class="input-group-text">kg</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="tekanan_arteri" class="col-sm-2 col-form-label text-end">Tekanan Arteri</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="tekanan_arteri" name="akut_tekanan_arteri">
                                                                <span class="input-group-text">ml/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="laju_uf" class="col-sm-2 col-form-label text-end">laju UF</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="laju_uf" name="akut_laju_uf">
                                                                <span class="input-group-text">ml</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="lama_laju_uf" class="col-sm-2 col-form-label text-end">Lama laju UF</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="lama_laju_uf" name="akut_lama_laju_uf">
                                                                <span class="input-group-text">jam</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="rutin">
                                                    <!-- Rutin -->
                                                    <div class="row mt-5">
                                                        <div class="col-12 text-center mb-3">
                                                            <h6>Rutin</h6>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="nr_ke" class="col-sm-2 col-form-label text-end">N/R Ke</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="nr_ke" name="rutin_nr_ke" placeholder="freetext">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="bb_kering" class="col-sm-2 col-form-label text-end">BB Kering</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="bb_kering" name="rutin_bb_kering">
                                                                <span class="input-group-text">kg</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="bb_post_hd" class="col-sm-2 col-form-label text-end">BB Post HD</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="bb_post_hd" name="rutin_bb_post_hd">
                                                                <span class="input-group-text">kg</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="tmp" class="col-sm-2 col-form-label text-end">TMP (Transmembrane Pressure)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="tmp" name="rutin_tmp">
                                                                <span class="input-group-text">mmHg</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="program_aksesbilling" class="col-sm-2 col-form-label text-end">Program Vaskular Aksesbilling</label>
                                                        <div class="col-sm-10">
                                                            <div class="row mb-2">
                                                                <div class="col-md-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" id="av_shunt" name="program_aksesbilling[]" value="AV Shunt">
                                                                        <label class="form-check-label" for="av_shunt">AV Shunt</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <select class="form-select" id="av_shunt_detail" name="rutin_av_shunt_detail">
                                                                        <option value="">Pilih</option>
                                                                        <option value="Kiri">Kiri</option>
                                                                        <option value="Kanan">Kanan</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row mb-2">
                                                                <div class="col-md-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" id="cdl" name="program_aksesbilling[]" value="CDL">
                                                                        <label class="form-check-label" for="cdl">CDL</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <select class="form-select" id="cdl_detail" name="rutin_cdl_detail">
                                                                        <option value="">Pilih</option>
                                                                        <option value="Jugularis">Jugularis</option>
                                                                        <option value="Subelavia">Subelavia</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" id="femoral" name="program_aksesbilling[]" value="Femoral">
                                                                        <label class="form-check-label" for="femoral">Femoral</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <select class="form-select" id="femoral_detail" name="rutin_femoral_detail">
                                                                        <option value="">Pilih</option>
                                                                        <option value="Kiri">Kiri</option>
                                                                        <option value="Kanan">Kanan</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="preop">
                                                    <!-- Pre Op -->
                                                    <div class="row mt-5">
                                                        <div class="col-12 text-center mb-3">
                                                            <h6>Pre Op</h6>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="dialisat" class="col-sm-2 col-form-label text-end">Dialisat</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" id="dialisat_asetat"
                                                                            name="preop_dialisat" value="Asetat"
                                                                            {{ ($asesmen->keperawatanMonitoringPreekripsi->preop_dialisat ?? '') == 'Asetat' ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="dialisat_asetat">Asetat</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" id="dialisat_bicarbonat"
                                                                            name="preop_bicarbonat" value="Bicarbonat"
                                                                            {{ ($asesmen->keperawatanMonitoringPreekripsi->preop_bicarbonat ?? '') == 'Bicarbonat' ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="dialisat_bicarbonat">Bicarbonat</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-sm-2"></div>
                                                        <div class="col-sm-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="conductivity_check"
                                                                    name="conductivity_check" value="1"
                                                                    {{ !empty($asesmen->keperawatanMonitoringPreekripsi->preop_conductivity) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="conductivity_check">Conductivity</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="conductivity"
                                                                    name="preop_conductivity"
                                                                    value="{{ $asesmen->keperawatanMonitoringPreekripsi->preop_conductivity ?? '' }}">
                                                                <span class="input-group-text">MS/Cm</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-sm-2"></div>
                                                        <div class="col-sm-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="kalium_check"
                                                                    name="kalium_check" value="1"
                                                                    {{ !empty($asesmen->keperawatanMonitoringPreekripsi->preop_kalium) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="kalium_check">Kalium</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="kalium"
                                                                    name="preop_kalium"
                                                                    value="{{ $asesmen->keperawatanMonitoringPreekripsi->preop_kalium ?? '' }}">
                                                                <span class="input-group-text">MEq/L</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-sm-2"></div>
                                                        <div class="col-sm-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="suhu_dialisat_check"
                                                                    name="suhu_dialisat_check" value="1"
                                                                    {{ !empty($asesmen->keperawatanMonitoringPreekripsi->preop_suhu_dialisat) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="suhu_dialisat_check">Suhu Dialisat</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="suhu_dialisat"
                                                                    name="preop_suhu_dialisat"
                                                                    value="{{ $asesmen->keperawatanMonitoringPreekripsi->preop_suhu_dialisat ?? '' }}">
                                                                <span class="input-group-text">°C</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-sm-2"></div>
                                                        <div class="col-sm-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="base_na_check"
                                                                    name="base_na_check" value="1"
                                                                    {{ !empty($asesmen->keperawatanMonitoringPreekripsi->preop_base_na) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="base_na_check">Base Na</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="base_na"
                                                                    name="preop_base_na"
                                                                    value="{{ $asesmen->keperawatanMonitoringPreekripsi->preop_base_na ?? '' }}">
                                                                <span class="input-group-text">MEq/L</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- 2. Heparinisasi -->
                                            <div class="heparinisasi">
                                                <div class="row mt-5">
                                                    <div class="col-12 mb-3">
                                                        <h6 class="fw-bold">2. Heparinisasi</h6>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <label for="heparinisasi" class="col-form-label">Heparinisasi</label>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <!-- Row 1: Dosis Sirkulasi dan Dosis Awal -->
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label for="dosis_sirkulasi" class="form-label">Dosis Sirkulasi</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="dosis_sirkulasi" name="dosis_sirkulasi"
                                                                        value="{{ $asesmen->keperawatanMonitoringHeparinisasi->dosis_sirkulasi ?? '' }}">
                                                                    <span class="input-group-text">IU</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="dosis_awal" class="form-label">Dosis Awal</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="dosis_awal" name="dosis_awal"
                                                                        value="{{ $asesmen->keperawatanMonitoringHeparinisasi->dosis_awal ?? '' }}">
                                                                    <span class="input-group-text">IU</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Row 2: Maintenance Kontinyu dan Maintenance Intermiten -->
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label for="maintenance_kontinyu" class="form-label">Maintenance Kontinyu</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="maintenance_kontinyu" name="maintenance_kontinyu"
                                                                        value="{{ $asesmen->keperawatanMonitoringHeparinisasi->maintenance_kontinyu ?? '' }}">
                                                                    <span class="input-group-text">IU/jam</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="maintenance_intermiten" class="form-label">Maintenance Intermiten</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="maintenance_intermiten" name="maintenance_intermiten"
                                                                        value="{{ $asesmen->keperawatanMonitoringHeparinisasi->maintenance_intermiten ?? '' }}">
                                                                    <span class="input-group-text">IU/jam</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Row 3: Tanpa Heparin dan LMWH -->
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label for="tanpa_heparin" class="form-label">Tanpa Heparin (sc.)</label>
                                                                <input type="text" class="form-control" id="tanpa_heparin" name="tanpa_heparin" placeholder="Text"
                                                                    value="{{ $asesmen->keperawatanMonitoringHeparinisasi->tanpa_heparin ?? '' }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="lmwh" class="form-label">LMWH</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="lmwh" name="lmwh"
                                                                        value="{{ $asesmen->keperawatanMonitoringHeparinisasi->lmwh ?? '' }}">
                                                                    <span class="input-group-text">IU</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Row 4: Program Bilas NaCl -->
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <label for="program_bilas_nacl" class="form-label">Program Bilas NaCl 0,9% 100cc/Jam</label>
                                                                <select class="form-select" id="program_bilas_nacl" name="program_bilas_nacl">
                                                                    <option value="" disabled>pilih</option>
                                                                    <option value="Ya" {{ ($asesmen->keperawatanMonitoringHeparinisasi->program_bilas_nacl ?? '') == 'Ya' ? 'selected' : '' }}>Ya</option>
                                                                    <option value="Tidak" {{ ($asesmen->keperawatanMonitoringHeparinisasi->program_bilas_nacl ?? '') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tindakan__keperawatan">
                                                <!-- 3. Tindakan Keperawatan -->
                                                <div class="row mt-5">
                                                    <div class="col-12 mb-3">
                                                        <h6 class="fw-bold">3. Tindakan Keperawatan</h6>
                                                    </div>
                                                </div>

                                                <!-- Pre HD -->
                                                <div class="preHD">
                                                    <div class="row mt-3">
                                                        <div class="col-12 mb-2">
                                                            <h6 class="fw-bold">Pre HD</h6>
                                                        </div>
                                                    </div>

                                                    <!-- Waktu Pre HD -->
                                                    <div class="row mb-3">
                                                        <label for="waktu_pre_hd" class="col-sm-2 col-form-label text-end">Waktu Pre HD</label>
                                                        <div class="col-sm-10">
                                                            <input type="time" class="form-control" id="waktu_pre_hd" name="prehd_waktu_pre_hd"
                                                                value="{{ isset($asesmen->keperawatanMonitoringTindakan->prehd_waktu_pre_hd) ? \Carbon\Carbon::parse($asesmen->keperawatanMonitoringTindakan->prehd_waktu_pre_hd)->format('H:i') : '' }}">
                                                        </div>
                                                    </div>

                                                    <!-- Parameter Mesin HD (QB dan QD) -->
                                                    <div class="row mb-3">
                                                        <label for="parameter_mesin_hd" class="col-sm-2 col-form-label text-end">Parameter Mesin HD</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">QB</span>
                                                                        <input type="text" class="form-control" id="qb" name="prehd_qb"
                                                                            value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_qb ?? '' }}">
                                                                        <span class="input-group-text">ml/menit</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">QD</span>
                                                                        <input type="text" class="form-control" id="qd" name="prehd_qd"
                                                                            value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_qd ?? '' }}">
                                                                        <span class="input-group-text">ml/menit</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- UF Rate -->
                                                    <div class="row mb-3">
                                                        <label for="uf_rate" class="col-sm-2 col-form-label text-end">UF Rate</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="uf_rate" name="prehd_uf_rate"
                                                                    value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_uf_rate ?? '' }}">
                                                                <span class="input-group-text">ml/menit</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tek. Darah (mmHg) - Sistole & Diastole -->
                                                    <div class="row mb-3">
                                                        <label for="tekanan_darah" class="col-sm-2 col-form-label text-end">Tek. Darah (mmHg)</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Sistole</span>
                                                                        <input type="number" class="form-control" id="sistole" name="prehd_sistole"
                                                                            value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_sistole ?? '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Diastole</span>
                                                                        <input type="number" class="form-control" id="diastole" name="prehd_diastole"
                                                                            value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_diastole ?? '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nadi (Per Menit) -->
                                                    <div class="row mb-3">
                                                        <label for="nadi" class="col-sm-2 col-form-label text-end">Nadi (Per Menit)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" id="nadi" name="prehd_nadi"
                                                                    value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_nadi ?? '' }}">
                                                                <span class="input-group-text">x/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nafas (Per Menit) -->
                                                    <div class="row mb-3">
                                                        <label for="nafas" class="col-sm-2 col-form-label text-end">Nafas (Per Menit)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" id="nafas" name="prehd_nafas"
                                                                    value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_nafas ?? '' }}">
                                                                <span class="input-group-text">x/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Suhu (C) -->
                                                    <div class="row mb-3">
                                                        <label for="suhu" class="col-sm-2 col-form-label text-end">Suhu (C)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" id="suhu" name="prehd_suhu"
                                                                    value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_suhu ?? '' }}">
                                                                <span class="input-group-text">°C</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Pemantauan Cairan Intake -->
                                                    <div class="row mb-3">
                                                        <label for="pemantauan_cairan_intake" class="col-sm-2 col-form-label text-end">Pemantauan Cairan Intake</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">NaCl</span>
                                                                        <input type="text" class="form-control" id="nacl" name="prehd_nacl"
                                                                            value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_nacl ?? '' }}">
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Minum</span>
                                                                        <input type="text" class="form-control" id="minum" name="prehd_minum"
                                                                            value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_minum ?? '' }}">
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-12">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Lain-Lain</span>
                                                                        <input type="text" class="form-control" id="intake_lain" name="prehd_intake_lain"
                                                                            value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_intake_lain ?? '' }}">
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Pemantauan Cairan Output -->
                                                    <div class="row mb-3">
                                                        <label for="pemantauan_cairan_output" class="col-sm-2 col-form-label text-end">Pemantauan Cairan Output</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="output" name="prehd_output"
                                                                    value="{{ $asesmen->keperawatanMonitoringTindakan->prehd_output ?? '' }}">
                                                                <span class="input-group-text">ml</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="intraHD">
                                                <!-- Intra HD -->
                                                <div class="row mt-4">
                                                    <div class="col-12 mb-2">
                                                        <h6 class="fw-bold">Intra HD</h6>
                                                    </div>
                                                </div>

                                                <!-- Waktu Intra Pre HD -->
                                                <div class="row mb-3">
                                                    <label for="waktu_intra_pre_hd" class="col-sm-2 col-form-label text-end">Waktu Intra Pre HD</label>
                                                    <div class="col-sm-10">
                                                        <input type="time" class="form-control" id="waktu_intra_pre_hd" name="waktu_intra_pre_hd"
                                                            value="{{ isset($asesmen->keperawatanMonitoringIntrahd->waktu_intra_pre_hd) ? \Carbon\Carbon::parse($asesmen->keperawatanMonitoringIntrahd->waktu_intra_pre_hd)->format('H:i') : '' }}">
                                                    </div>
                                                </div>

                                                <!-- Parameter Mesin HD (QB dan QD) -->
                                                <div class="row mb-3">
                                                    <label for="parameter_mesin_hd_intra" class="col-sm-2 col-form-label text-end">Parameter Mesin HD</label>
                                                    <div class="col-sm-10">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-text">QB</span>
                                                                    <input type="number" class="form-control" id="qb_intra" name="qb_intra"
                                                                        value="{{ $asesmen->keperawatanMonitoringIntrahd->qb_intra ?? '' }}">
                                                                    <span class="input-group-text">ml/menit</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-text">QD</span>
                                                                    <input type="number" class="form-control" id="qd_intra" name="qd_intra"
                                                                        value="{{ $asesmen->keperawatanMonitoringIntrahd->qd_intra ?? '' }}">
                                                                    <span class="input-group-text">ml/menit</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- UF Rate -->
                                                <div class="row mb-3">
                                                    <label for="uf_rate_intra" class="col-sm-2 col-form-label text-end">UF Rate</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="uf_rate_intra" name="uf_rate_intra"
                                                                value="{{ $asesmen->keperawatanMonitoringIntrahd->uf_rate_intra ?? '' }}">
                                                            <span class="input-group-text">ml/menit</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Tek. Darah (mmHg) - Sistole & Diastole -->
                                                <div class="row mb-3">
                                                    <label for="tekanan_darah_intra" class="col-sm-2 col-form-label text-end">Tek. Darah (mmHg)</label>
                                                    <div class="col-sm-10">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-text">Sistole</span>
                                                                    <input type="number" class="form-control" id="sistole_intra" name="sistole_intra"
                                                                        value="{{ $asesmen->keperawatanMonitoringIntrahd->sistole_intra ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-text">Diastole</span>
                                                                    <input type="number" class="form-control" id="diastole_intra" name="diastole_intra"
                                                                        value="{{ $asesmen->keperawatanMonitoringIntrahd->diastole_intra ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Nadi (Per Menit) -->
                                                <div class="row mb-3">
                                                    <label for="nadi_intra" class="col-sm-2 col-form-label text-end">Nadi (Per Menit)</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="nadi_intra" name="nadi_intra"
                                                                value="{{ $asesmen->keperawatanMonitoringIntrahd->nadi_intra ?? '' }}">
                                                            <span class="input-group-text">x/mnt</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Nafas (Per Menit) -->
                                                <div class="row mb-3">
                                                    <label for="nafas_intra" class="col-sm-2 col-form-label text-end">Nafas (Per Menit)</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="nafas_intra" name="nafas_intra"
                                                                value="{{ $asesmen->keperawatanMonitoringIntrahd->nafas_intra ?? '' }}">
                                                            <span class="input-group-text">x/mnt</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Suhu (C) -->
                                                <div class="row mb-3">
                                                    <label for="suhu_intra" class="col-sm-2 col-form-label text-end">Suhu (C)</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="suhu_intra" name="suhu_intra"
                                                                value="{{ $asesmen->keperawatanMonitoringIntrahd->suhu_intra ?? '' }}">
                                                            <span class="input-group-text">°C</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Pemantauan Cairan Intake -->
                                                <div class="row mb-3">
                                                    <label for="pemantauan_cairan_intake_intra" class="col-sm-2 col-form-label text-end">Pemantauan Cairan Intake</label>
                                                    <div class="col-sm-10">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-text">NaCl</span>
                                                                    <input type="number" class="form-control" id="nacl_intra" name="nacl_intra"
                                                                        value="{{ $asesmen->keperawatanMonitoringIntrahd->nacl_intra ?? '' }}">
                                                                    <span class="input-group-text">ml</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-text">Minum</span>
                                                                    <input type="number" class="form-control" id="minum_intra" name="minum_intra"
                                                                        value="{{ $asesmen->keperawatanMonitoringIntrahd->minum_intra ?? '' }}">
                                                                    <span class="input-group-text">ml</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-12">
                                                                <div class="input-group">
                                                                    <span class="input-group-text">Lain-Lain</span>
                                                                    <input type="text" class="form-control" id="intake_lain_intra" name="intake_lain_intra"
                                                                        value="{{ $asesmen->keperawatanMonitoringIntrahd->intake_lain_intra ?? '' }}">
                                                                    <span class="input-group-text">ml</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Pemantauan Cairan Output -->
                                                <div class="row mb-3">
                                                    <label for="pemantauan_cairan_output_intra" class="col-sm-2 col-form-label text-end">Pemantauan Cairan Output</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="output_intra" name="output_intra"
                                                                value="{{ $asesmen->keperawatanMonitoringIntrahd->output_intra ?? '' }}">
                                                            <span class="input-group-text">ml</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Tombol Simpan untuk Intra HD -->
                                                <div class="row mt-4">
                                                    <div class="col-sm-10 offset-sm-2">
                                                        <button type="button" class="btn btn-primary btn-simpan-intra-hd">Simpan ke Tabel</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="daftarObservasiIntraTindakanHD">
                                                <!-- Daftar Observasi Intra Tindakan HD -->
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
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="observasiTableBody">
                                                            <!-- Baris akan ditambahkan dari data form -->
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- Hidden input for observasi_data -->
                                                <input type="hidden" name="observasi_data" id="observasi_data"
                                                    value="{{ $asesmen->keperawatanMonitoringIntrahd->observasi_data ?? '' }}">
                                            </div>

                                            <div class="post__HD">
                                                <!-- Post HD -->
                                                <div class="row mt-4">
                                                    <div class="col-12 mb-2">
                                                        <h6 class="fw-bold">Post HD</h6>
                                                    </div>
                                                </div>

                                                <!-- Lama Waktu Post HD -->
                                                <div class="row mb-3">
                                                    <label for="lama_waktu_post_hd" class="col-sm-2 col-form-label text-end">Lama Waktu Post HD</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" class="form-control" id="lama_waktu_post_hd" name="lama_waktu_post_hd"
                                                            placeholder="menit" value="{{ $asesmen->keperawatanMonitoringPosthd->lama_waktu_post_hd ?? '' }}">
                                                    </div>
                                                </div>

                                                <!-- Parameter Mesin HD (QB dan QD) -->
                                                <div class="row mb-3">
                                                    <label for="parameter_mesin_hd_post" class="col-sm-2 col-form-label text-end">Parameter Mesin HD</label>
                                                    <div class="col-sm-10">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-text">QB</span>
                                                                    <input type="number" class="form-control" id="qb_post" name="qb_post"
                                                                        value="{{ $asesmen->keperawatanMonitoringPosthd->qb_post ?? '' }}">
                                                                    <span class="input-group-text">ml/menit</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-text">QD</span>
                                                                    <input type="number" class="form-control" id="qd_post" name="qd_post"
                                                                        value="{{ $asesmen->keperawatanMonitoringPosthd->qd_post ?? '' }}">
                                                                    <span class="input-group-text">ml/menit</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- UF Rate -->
                                                <div class="row mb-3">
                                                    <label for="uf_rate_post" class="col-sm-2 col-form-label text-end">UF Rate</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="uf_rate_post" name="uf_rate_post"
                                                                value="{{ $asesmen->keperawatanMonitoringPosthd->uf_rate_post ?? '' }}">
                                                            <span class="input-group-text">ml/menit</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Tek. Darah (mmHg) - Sistole & Diastole -->
                                                <div class="row mb-3">
                                                    <label for="tekanan_darah_post" class="col-sm-2 col-form-label text-end">Tek. Darah (mmHg)</label>
                                                    <div class="col-sm-10">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-text">Sistole</span>
                                                                    <input type="number" class="form-control" id="sistole_post" name="sistole_post"
                                                                        value="{{ $asesmen->keperawatanMonitoringPosthd->sistole_post ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-text">Diastole</span>
                                                                    <input type="number" class="form-control" id="diastole_post" name="diastole_post"
                                                                        value="{{ $asesmen->keperawatanMonitoringPosthd->diastole_post ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Nadi (Per Menit) -->
                                                <div class="row mb-3">
                                                    <label for="nadi_post" class="col-sm-2 col-form-label text-end">Nadi (Per Menit)</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="nadi_post" name="nadi_post"
                                                                value="{{ $asesmen->keperawatanMonitoringPosthd->nadi_post ?? '' }}">
                                                            <span class="input-group-text">x/mnt</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Nafas (Per Menit) -->
                                                <div class="row mb-3">
                                                    <label for="nafas_post" class="col-sm-2 col-form-label text-end">Nafas (Per Menit)</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="nafas_post" name="nafas_post"
                                                                value="{{ $asesmen->keperawatanMonitoringPosthd->nafas_post ?? '' }}">
                                                            <span class="input-group-text">x/mnt</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Suhu (C) -->
                                                <div class="row mb-3">
                                                    <label for="suhu_post" class="col-sm-2 col-form-label text-end">Suhu (C)</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="suhu_post" name="suhu_post"
                                                                value="{{ $asesmen->keperawatanMonitoringPosthd->suhu_post ?? '' }}">
                                                            <span class="input-group-text">°C</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Pemantauan Cairan Intake -->
                                                <div class="row mb-3">
                                                    <label for="pemantauan_cairan_intake_post" class="col-sm-2 col-form-label text-end">Pemantauan Cairan Intake</label>
                                                    <div class="col-sm-10">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-text">NaCl</span>
                                                                    <input type="number" class="form-control" id="nacl_post" name="nacl_post"
                                                                        value="{{ $asesmen->keperawatanMonitoringPosthd->nacl_post ?? '' }}">
                                                                    <span class="input-group-text">ml</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-text">Minum</span>
                                                                    <input type="number" class="form-control" id="minum_post" name="minum_post"
                                                                        value="{{ $asesmen->keperawatanMonitoringPosthd->minum_post ?? '' }}">
                                                                    <span class="input-group-text">ml</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-12">
                                                                <div class="input-group">
                                                                    <span class="input-group-text">Lain-Lain</span>
                                                                    <input type="number" class="form-control" id="intake_lain_post" name="intake_lain_post"
                                                                        value="{{ $asesmen->keperawatanMonitoringPosthd->intake_lain_post ?? '' }}">
                                                                    <span class="input-group-text">ml</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Pemantauan Cairan Output -->
                                                <div class="row mb-3">
                                                    <label for="pemantauan_cairan_output_post" class="col-sm-2 col-form-label text-end">Pemantauan Cairan Output</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="output_post" name="output_post"
                                                                value="{{ $asesmen->keperawatanMonitoringPosthd->output_post ?? '' }}">
                                                            <span class="input-group-text">ml</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Jumlah Cairan Intake -->
                                                <div class="row mb-3">
                                                    <label for="jumlah_cairan_intake" class="col-sm-2 col-form-label text-end">Jumlah Cairan Intake</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="jumlah_cairan_intake" name="jumlah_cairan_intake"
                                                                value="{{ $asesmen->keperawatanMonitoringPosthd->jumlah_cairan_intake ?? '' }}">
                                                            <span class="input-group-text">ml</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Jumlah Cairan Output -->
                                                <div class="row mb-3">
                                                    <label for="jumlah_cairan_output" class="col-sm-2 col-form-label text-end">Jumlah Cairan Output</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="jumlah_cairan_output" name="jumlah_cairan_output"
                                                                value="{{ $asesmen->keperawatanMonitoringPosthd->jumlah_cairan_output ?? '' }}">
                                                            <span class="input-group-text">ml</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Ultrafiltration Total -->
                                                <div class="row mb-3">
                                                    <label for="ultrafiltration_total" class="col-sm-2 col-form-label text-end">Ultrafiltration Total</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="ultrafiltration_total" name="ultrafiltration_total"
                                                            placeholder="input angka, otomatis menghitung total cairan yang diambil selama HD ml"
                                                            value="{{ $asesmen->keperawatanMonitoringPosthd->ultrafiltration_total ?? '' }}">
                                                    </div>
                                                </div>

                                                <!-- Keterangan SOAPIE -->
                                                <div class="row mb-3">
                                                    <label for="keterangan_soapie" class="col-sm-2 col-form-label text-end">Keterangan SOAPIE</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" id="keterangan_soapie" name="keterangan_soapie" rows="3" placeholder="text">{{ $asesmen->keperawatanMonitoringPosthd->keterangan_soapie ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="section-separator mt-5">
                                            <h5 class="section-title">12. Penyulit Selama HD</h5>

                                            <div class="row mb-3">
                                                <label for="klinis" class="col-sm-2 col-form-label text-end">Klinis</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="klinis_display" readonly
                                                            placeholder="pilih" data-bs-toggle="modal"
                                                            data-bs-target="#klinisModal">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-bs-toggle="modal" data-bs-target="#klinisModal">
                                                            <i class="fas fa-list"></i>
                                                        </button>
                                                    </div>
                                                    <div id="klinis_selected_items" class="mt-2 small text-muted"></div>
                                                    <!-- Hidden input untuk menyimpan nilai yang dipilih -->
                                                    <input type="hidden" id="klinis_values" name="klinis_values"
                                                        value="{{ $asesmen->keperawatan->klinis_values ?? '[]' }}">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="teknis" class="col-sm-2 col-form-label text-end">Teknis</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="teknis_display" readonly
                                                            placeholder="pilih" data-bs-toggle="modal"
                                                            data-bs-target="#teknisModal">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-bs-toggle="modal" data-bs-target="#teknisModal">
                                                            <i class="fas fa-list"></i>
                                                        </button>
                                                    </div>
                                                    <div id="teknis_selected_items" class="mt-2 small text-muted"></div>
                                                    <!-- Hidden input untuk menyimpan nilai yang dipilih -->
                                                    <input type="hidden" id="teknis_values" name="teknis_values"
                                                        value="{{ $asesmen->keperawatan->teknis_values ?? '[]' }}">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="mesin" class="col-sm-2 col-form-label text-end">Mesin</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="mesin" name="mesin"
                                                        placeholder="Freetext" value="{{ $asesmen->keperawatan->mesin ?? '' }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="section-separator mt-5">
                                            <h5 class="section-title">13. Disharge Planning</h5>

                                            <div class="row mb-3">
                                                <label for="rencana_pulang" class="col-sm-2 col-form-label text-end">Rencana Pulang</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="rencana_pulang_display"
                                                            readonly placeholder="Pemulangan Asupan Cairan"
                                                            data-bs-toggle="modal" data-bs-target="#rencanaPulangModal">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-bs-toggle="modal" data-bs-target="#rencanaPulangModal">
                                                            <i class="fas fa-list"></i>
                                                        </button>
                                                    </div>
                                                    <div id="rencana_pulang_selected_items" class="mt-2 small text-muted">
                                                    </div>
                                                    <!-- Hidden input untuk menyimpan nilai yang dipilih -->
                                                    <input type="hidden" id="rencana_pulang_values" name="rencana_pulang_values"
                                                        value="{{ $asesmen->keperawatan->rencana_pulang_values ?? '[]' }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="section-separator" id="diagnosis">
                                            <h5 class="fw-semibold mb-4">14. Diagnosis</h5>

                                            @php
                                            // Parse existing diagnosis data from database
                                            $diagnosisBanding =
                                            !empty($asesmen->keperawatan->diagnosis_banding)
                                            ? json_decode(
                                            $asesmen->keperawatan->diagnosis_banding,
                                            true
                                            )
                                            : [];
                                            $diagnosisKerja =
                                            !empty($asesmen->keperawatan->diagnosis_kerja)
                                            ? json_decode(
                                            $asesmen->keperawatan->diagnosis_kerja,
                                            true
                                            )
                                            : [];
                                            @endphp

                                            <!-- Diagnosis Banding -->
                                            <div class="mb-4">
                                                <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
                                                <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                    diagnosis banding,
                                                    apabila tidak ada, Pilih tanda tambah untuk menambah keterangan diagnosis
                                                    banding yang tidak ditemukan.</small>

                                                <div class="input-group mb-3">
                                                    <span class="input-group-text bg-white border-end-0">
                                                        <i class="bi bi-search text-secondary"></i>
                                                    </span>
                                                    <input type="text" id="diagnosis-banding-input"
                                                        class="form-control border-start-0 ps-0"
                                                        placeholder="Cari dan tambah Diagnosis Banding">
                                                    <span class="input-group-text bg-white" id="add-diagnosis-banding">
                                                        <i class="bi bi-plus-circle text-primary"></i>
                                                    </span>
                                                </div>

                                                <div id="diagnosis-banding-list" class="diagnosis-list bg-light p-3 rounded">
                                                    <!-- Existing diagnosis will be loaded here -->
                                                </div>

                                                <!-- Hidden input for form submission -->
                                                <input type="hidden" id="diagnosis_banding" name="diagnosis_banding"
                                                    value="{{ json_encode($diagnosisBanding) }}">
                                            </div>

                                            <!-- Diagnosis Kerja -->
                                            <div class="mb-4">
                                                <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
                                                <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                    diagnosis kerja,
                                                    apabila tidak ada, Pilih tanda tambah untuk menambah keterangan diagnosis
                                                    kerja yang tidak ditemukan.</small>

                                                <div class="input-group mb-3">
                                                    <span class="input-group-text bg-white border-end-0">
                                                        <i class="bi bi-search text-secondary"></i>
                                                    </span>
                                                    <input type="text" id="diagnosis-kerja-input"
                                                        class="form-control border-start-0 ps-0"
                                                        placeholder="Cari dan tambah Diagnosis Kerja">
                                                    <span class="input-group-text bg-white" id="add-diagnosis-kerja">
                                                        <i class="bi bi-plus-circle text-primary"></i>
                                                    </span>
                                                </div>

                                                <div id="diagnosis-kerja-list" class="diagnosis-list bg-light p-3 rounded">
                                                    <!-- Existing diagnosis will be loaded here -->
                                                </div>

                                                <!-- Hidden input for form submission -->
                                                <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja"
                                                    value="{{ json_encode($diagnosisKerja) }}">
                                            </div>
                                        </div>

                                        <div class="section-separator" style="margin-bottom: 2rem;">
                                            <h5 class="fw-semibold mb-4">15. Implementasi</h5>

                                            @php
                                            // Parse existing implementation data
                                            $implementationData = [
                                            'observasi' => !empty($asesmen->keperawatan->observasi)
                                            ? json_decode($asesmen->keperawatan->observasi, true) :
                                            [],
                                            'terapeutik' =>
                                            !empty($asesmen->keperawatan->terapeutik)
                                            ? json_decode($asesmen->keperawatan->terapeutik, true) :
                                            [],
                                            'edukasi' => !empty($asesmen->keperawatan->edukasi)
                                            ? json_decode($asesmen->keperawatan->edukasi, true) :
                                            [],
                                            'kolaborasi' =>
                                            !empty($asesmen->keperawatan->kolaborasi)
                                            ? json_decode($asesmen->keperawatan->kolaborasi, true) :
                                            [],
                                            'prognosis' => !empty($asesmen->keperawatan->prognosis)
                                            ? json_decode($asesmen->keperawatan->prognosis, true) :
                                            []
                                            ];
                                            @endphp

                                            <!-- Rencana Penatalaksanaan dan Pengobatan -->
                                            <div class="mb-4">
                                                <label class="text-primary fw-semibold">Rencana Penatalaksanaan dan
                                                    Pengobatan</label>
                                                <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                    rencana, apabila tidak ada,
                                                    Pilih tanda tambah untuk menambah keterangan rencana yang tidak
                                                    ditemukan.</small>
                                            </div>

                                            <!-- Observasi Section -->
                                            <div class="mb-4">
                                                <label class="fw-semibold mb-2">Observasi</label>
                                                <div class="input-group mt-2">
                                                    <span class="input-group-text bg-white border-end-0">
                                                        <i class="bi bi-search text-secondary"></i>
                                                    </span>
                                                    <input type="text" id="observasi-input"
                                                        class="form-control border-start-0 ps-0"
                                                        placeholder="Cari dan tambah Observasi">
                                                    <span class="input-group-text bg-white" id="add-observasi">
                                                        <i class="bi bi-plus-circle text-primary"></i>
                                                    </span>
                                                </div>
                                                <div id="observasi-list" class="list-group mb-2 mt-2 bg-light p-3 rounded">
                                                    <!-- Items will be added here dynamically -->
                                                </div>
                                                <input type="hidden" id="observasi" name="observasi"
                                                    value="{{ json_encode($implementationData['observasi']) }}">
                                            </div>

                                            <!-- Terapeutik Section -->
                                            <div class="mb-4">
                                                <label class="fw-semibold mb-2">Terapeutik</label>
                                                <div class="input-group mt-2">
                                                    <span class="input-group-text bg-white border-end-0">
                                                        <i class="bi bi-search text-secondary"></i>
                                                    </span>
                                                    <input type="text" id="terapeutik-input"
                                                        class="form-control border-start-0 ps-0"
                                                        placeholder="Cari dan tambah Terapeutik">
                                                    <span class="input-group-text bg-white" id="add-terapeutik">
                                                        <i class="bi bi-plus-circle text-primary"></i>
                                                    </span>
                                                </div>
                                                <div id="terapeutik-list" class="list-group mb-2 mt-2 bg-light p-3 rounded">
                                                    <!-- Items will be added here dynamically -->
                                                </div>
                                                <input type="hidden" id="terapeutik" name="terapeutik"
                                                    value="{{ json_encode($implementationData['terapeutik']) }}">
                                            </div>

                                            <!-- Edukasi Section -->
                                            <div class="mb-4">
                                                <label class="fw-semibold mb-2">Edukasi</label>
                                                <div class="input-group mt-2">
                                                    <span class="input-group-text bg-white border-end-0">
                                                        <i class="bi bi-search text-secondary"></i>
                                                    </span>
                                                    <input type="text" id="edukasi-input"
                                                        class="form-control border-start-0 ps-0"
                                                        placeholder="Cari dan tambah Edukasi">
                                                    <span class="input-group-text bg-white" id="add-edukasi">
                                                        <i class="bi bi-plus-circle text-primary"></i>
                                                    </span>
                                                </div>
                                                <div id="edukasi-list" class="list-group mb-2 mt-2 bg-light p-3 rounded">
                                                    <!-- Items will be added here dynamically -->
                                                </div>
                                                <input type="hidden" id="edukasi" name="edukasi"
                                                    value="{{ json_encode($implementationData['edukasi']) }}">
                                            </div>

                                            <!-- Kolaborasi Section -->
                                            <div class="mb-4">
                                                <label class="fw-semibold mb-2">Kolaborasi</label>
                                                <div class="input-group mt-2">
                                                    <span class="input-group-text bg-white border-end-0">
                                                        <i class="bi bi-search text-secondary"></i>
                                                    </span>
                                                    <input type="text" id="kolaborasi-input"
                                                        class="form-control border-start-0 ps-0"
                                                        placeholder="Cari dan tambah Kolaborasi">
                                                    <span class="input-group-text bg-white" id="add-kolaborasi">
                                                        <i class="bi bi-plus-circle text-primary"></i>
                                                    </span>
                                                </div>
                                                <div id="kolaborasi-list" class="list-group mb-2 mt-2 bg-light p-3 rounded">
                                                    <!-- Items will be added here dynamically -->
                                                </div>
                                                <input type="hidden" id="kolaborasi" name="kolaborasi"
                                                    value="{{ json_encode($implementationData['kolaborasi']) }}">
                                            </div>

                                            <!-- Prognosis Section -->
                                            <div class="mb-4">
                                                <label class="text-primary fw-semibold">Prognosis</label>
                                                <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                    Prognosis,
                                                    apabila tidak ada, Pilih tanda tambah untuk menambah keterangan Prognosis
                                                    yang tidak ditemukan.</small>
                                                <div class="input-group mt-2">
                                                    <span class="input-group-text bg-white border-end-0">
                                                        <i class="bi bi-search text-secondary"></i>
                                                    </span>
                                                    <input type="text" id="prognosis-input"
                                                        class="form-control border-start-0 ps-0"
                                                        placeholder="Cari dan tambah Prognosis">
                                                    <span class="input-group-text bg-white" id="add-prognosis">
                                                        <i class="bi bi-plus-circle text-primary"></i>
                                                    </span>
                                                </div>
                                                <div id="prognosis-list" class="list-group mb-2 mt-2 bg-light p-3 rounded">
                                                    <!-- Items will be added here dynamically -->
                                                </div>
                                                <input type="hidden" id="prognosis" name="prognosis"
                                                    value="{{ json_encode($implementationData['prognosis']) }}">
                                            </div>
                                        </div>

                                        <!-- 16. Evaluasi -->
                                        <div class="section-separator mt-5">
                                            <h5 class="section-title">16. Evaluasi</h5>

                                            <!-- Tambah Evaluasi Keperawatan -->
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label for="evaluasi_keperawatan" class="form-label">Tambah Evaluasi Keperawatan</label>
                                                    <textarea class="form-control" id="evaluasi_keperawatan" name="evaluasi_keperawatan" rows="4">{{ $asesmen->keperawatan->evaluasi_keperawatan ?? '' }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Tambah Evaluasi Medis -->
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <label for="evaluasi_medis" class="form-label">Tambah Evaluasi Medis</label>
                                                    <textarea class="form-control" id="evaluasi_medis" name="evaluasi_medis" rows="4">{{ $asesmen->keperawatan->evaluasi_medis ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- 17. Tanda Tangan dan Verifikasi -->
                                        <div class="section-separator mt-5">
                                            <h5 class="section-title">17. Tanda Tangan dan Verifikasi</h5>

                                            <!-- E-Signature Perawat Pemeriksa Akses Vaskular -->
                                            <div class="row mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label">E-Signature Nama Perawat Pemeriksa Akses Vaskular</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <select name="perawat_pemeriksa" id="perawat-pemeriksa" class="form-select select2">
                                                                <option value="">--Pilih--</option>
                                                                @foreach ($perawat as $prwt)
                                                                    <option value="{{ $prwt->kd_karyawan }}" {{ ($asesmen->keperawatan->perawat_pemeriksa ?? '') == $prwt->kd_karyawan ? 'selected' : '' }}>
                                                                        {{ "$prwt->gelar_depan $prwt->nama $prwt->gelar_belakang" }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 text-center">
                                                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKQAAACkCAYAAAAZtYVBAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAUESURBVHhe7dxBattQFIZR03W4/62l3YNbGsT3lTzwe0cH0APykaqi9uvz8/MXNPidv6GCIIkhSGIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhiCJIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJMZrQX59ff1YvV+PfZIgiSFIYrwW5J1/f//+qnXPWfNcd+3dY68+b/V56/3/EkESQ5DEmBbk3XPS3TljHpueT1b3hzmOnDMev++aIIkhSGJMC/LqeeOxq/ddrzt73fq5Nc9l4z5X91/d/9XrVgR5cwxBEmNakHfmqDmfzfGOcWyaH+d99/x49Jy5+twgSGIIkhivBTnOLatz0Hhunj/mdDr/V/Pz8ziPM/HV6x/V5wZBEkOQxHgtyPHcNZ6v7sxxq+e/u/HvrK6Zm4+r91sRJDEESYxpQc7Nefj76tz13/PJt39tzWvW+9yveZ7LVuvXz/hFZN1/RZAEud8eQ5DEeC3I+97vH66+UHs39Ptn+Pw0n7NW97t7/+q+dc35vuvePw779h9BEkOQxJgW5Pzcs3pOmeeX+dx05/w0P5ese81z6Dg3rnv8Ph8JkhiCJMZrQR45d62e01bXXc1Rt9X7d+fWcf/qy7n9614RJDEESYxpQV79ZM+YX8b9u/PHHXe/3Lv6vKvnnO+/IkhiCJIYrwV558g1q/PVvP/I9Xeuu5pfjzzy7itBEkOQxJgW5J3z1bzm6pd149q7P+9cvf96zeq+9Xw6X39FkMQQJDFeC/LIeWs+D62uW52f5591zv+ue8+H7/vf97hvgiSGIIkxLcjVuWec/1avu/qcq2vmOfB+zf21//758315Z96fz5XvGe+bIIkhSGK8FuR8vpvnoPn8OD/fHJmjbsf//P/PP4+d93+/5plrd+fO8fPN7xckMQyPEGPsgbEHpgV53/vjh3F3Th7Pc/N58c6cd+f5dHdu3Tueq3vnwKtz5njtfP8VQRJDkMSYFuTY9eZ5a56fVuf68V/GNfO/QHDnuXU+h/5zHfv/e+5ev3fO+6wIkhiCJMZrQc7nl/l5ap4j79fMX7a9G/r/9/8z1z3PdeN17/Pp+pz8vu94jnznnyAQJDEESYzXgtz9wm2eT8bz433tes48cj7dPXfOa+/Msfdr3q97RZDEECQxpgV55T/V3Lnf/Jy4nk/G/nfn/DvOsWOfv194rpnnybP7re5zRZDEECQxXgvy/vPBOF/Nz2HzHPfMvDn+C8Dr38j/5895jv3+fZw/x9dc/Ys+FwRJDEESY1qQ43PL+AXcPOfN89D8nPl9zXzNc+e81T3Xec76ZeDq/Y4QJDEESR5DE2PaL/euzm1H5rj7/vn8dOR5ctw37ltde3XN/PPYcS7eI0hiCJIYrwU5zzfzz/XG1/Pz1NX5bn4+nOe4/X3zHDp/AfdqPh3n0vk5+v7zjiCJIUhiTAvyzsuy+Xlmnpvm55vx/Dk/f67nwN33Ga+5ml/nL/rm6+c5+IggCULEeC3IdS4az0/zOWg+Z41z8eocuPsl3jwHzufY+Xxbv/Rb5+I9giSGIIkxLcgn1ef1/n0ESQxBEuO1IMkkSDIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJIYgiSFIYgiSGIIkxm+kWDBIHCiGkAAAAABJRU5ErkJggg=="
                                                                alt="QR Code" class="img-fluid" style="width: 100px; height: 100px;">
                                                            <div class="mt-2">No..........................</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- E-Signature Perawat Yang Bertugas -->
                                            <div class="row mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label">E-Signature Nama Perawat Yang Bertugas</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <select name="perawat_bertugas" id="perawat" class="form-select select2">
                                                                <option value="">--Pilih--</option>
                                                                @foreach ($perawat as $prwt)
                                                                    <option value="{{ $prwt->kd_karyawan }}" {{ ($asesmen->keperawatan->perawat_bertugas ?? '') == $prwt->kd_karyawan ? 'selected' : '' }}>
                                                                        {{ "$prwt->gelar_depan $prwt->nama $prwt->gelar_belakang" }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 text-center">
                                                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKQAAACkCAYAAAAZtYVBAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAUESURBVHhe7dxBattQFIZR03W4/62l3YNbGsT3lTzwe0cH0APykaqi9uvz8/MXNPidv6GCIIkhSGIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhiCJIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJMZrQX59ff1YvV+PfZIgiSFIYrwW5J1/f//+qnXPWfNcd+3dY68+b/V56/3/EkESQ5DEmBbk3XPS3TljHpueT1b3hzmOnDMev++aIIkhSGJMC/LqeeOxq/ddrzt73fq5Nc9l4z5X91/d/9XrVgR5cwxBEmNakHfmqDmfzfGOcWyaH+d99/x49Jy5+twgSGIIkhivBTnOLatz0Hhunj/mdDr/V/Pz8ziPM/HV6x/V5wZBEkOQxHgtyPHcNZ6v7sxxq+e/u/HvrK6Zm4+r91sRJDEESYxpQc7Nefj76tz13/PJt39tzWvW+9yveZ7LVuvXz/hFZN1/RZAEud8eQ5DEeC3I+97vH66+UHs39Ptn+Pw0n7NW97t7/+q+dc35vuvePw779h9BEkOQxJgW5Pzcs3pOmeeX+dx05/w0P5ese81z6Dg3rnv8Ph8JkhiCJMZrQR45d62e01bXXc1Rt9X7d+fWcf/qy7n9614RJDEESYxpQV79ZM+YX8b9u/PHHXe/3Lv6vKvnnO+/IkhiCJIYrwV558g1q/PVvP/I9Xeuu5pfjzzy7itBEkOQxJgW5J3z1bzm6pd149q7P+9cvf96zeq+9Xw6X39FkMQQJDFeC/LIeWs+D62uW52f5591zv+ue8+H7/vf97hvgiSGIIkxLcjVuWec/1avu/qcq2vmOfB+zf21//758315Z96fz5XvGe+bIIkhSGK8FuR8vpvnoPn8OD/fHJmjbsf//P/PP4+d93+/5plrd+fO8fPN7xckMQyPEGPsgbEHpgV53/vjh3F3Th7Pc/N58c6cd+f5dHdu3Tueq3vnwKtz5njtfP8VQRJDkMSYFuTY9eZ5a56fVuf68V/GNfO/QHDnuXU+h/5zHfv/e+5ev3fO+6wIkhiCJMZrQc7nl/l5ap4j79fMX7a9G/r/9/8z1z3PdeN17/Pp+pz8vu94jnznnyAQJDEESYzXgtz9wm2eT8bz433tes48cj7dPXfOa+/Msfdr3q97RZDEECQxpgV55T/V3Lnf/Jy4nk/G/nfn/DvOsWOfv194rpnnybP7re5zRZDEECQxXgvy/vPBOF/Nz2HzHPfMvDn+C8Dr38j/5895jv3+fZw/x9dc/Ys+FwRJDEESY1qQ43PL+AXcPOfN89D8nPl9zXzNc+e81T3Xec76ZeDq/Y4QJDEESR5DE2PaL/euzm1H5rj7/vn8dOR5ctw37ltde3XN/PPYcS7eI0hiCJIYrwU5zzfzz/XG1/Pz1NX5bn4+nOe4/X3zHDp/AfdqPh3n0vk5+v7zjiCJIUhiTAvyzsuy+Xlmnpvm55vx/Dk/f67nwN33Ga+5ml/nL/rm6+c5+IggCULEeC3IdS4az0/zOWg+Z41z8eocuPsl3jwHzufY+Xxbv/Rb5+I9giSGIIkxLcgn1ef1/n0ESQxBEuO1IMkkSDIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJIYgiSFIYgiSGIIkxm+kWDBIHCiGkAAAAABJRU5ErkJggg=="
                                                                alt="QR Code" class="img-fluid" style="width: 100px; height: 100px;">
                                                            <div class="mt-2">No..........................</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- E-Signature Dokter DPJP -->
                                            <div class="row mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label">E-Signature Nama Dokter (DPJP)</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <select name="dokter_pelaksana" id="dokter_pelaksana" class="form-select">
                                                                <option value="">--Pilih--</option>
                                                                @foreach ($dokterPelaksana as $item)
                                                                    <option value="{{ $item->dokter->kd_dokter }}" {{ ($asesmen->keperawatan->dokter_pelaksana ?? '') == $item->dokter->kd_dokter ? 'selected' : '' }}>
                                                                        {{ $item->dokter->nama_lengkap }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 text-center">
                                                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKQAAACkCAYAAAAZtYVBAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAUESURBVHhe7dxBattQFIZR03W4/62l3YNbGsT3lTzwe0cH0APykaqi9uvz8/MXNPidv6GCIIkhSGIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhiCJIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJMZrQX59ff1YvV+PfZIgiSFIYrwW5J1/f//+qnXPWfNcd+3dY68+b/V56/3/EkESQ5DEmBbk3XPS3TljHpueT1b3hzmOnDMev++aIIkhSGJMC/LqeeOxq/ddrzt73fq5Nc9l4z5X91/d/9XrVgR5cwxBEmNakHfmqDmfzfGOcWyaH+d99/x49Jy5+twgSGIIkhivBTnOLatz0Hhunj/mdDr/V/Pz8ziPM/HV6x/V5wZBEkOQxHgtyPHcNZ6v7sxxq+e/u/HvrK6Zm4+r91sRJDEESYxpQc7Nefj76tz13/PJt39tzWvW+9yveZ7LVuvXz/hFZN1/RZAEud8eQ5DEeC3I+97vH66+UHs39Ptn+Pw0n7NW97t7/+q+dc35vuvePw779h9BEkOQxJgW5Pzcs3pOmeeX+dx05/w0P5ese81z6Dg3rnv8Ph8JkhiCJMZrQR45d62e01bXXc1Rt9X7d+fWcf/qy7n9614RJDEESYxpQV79ZM+YX8b9u/PHHXe/3Lv6vKvnnO+/IkhiCJIYrwV558g1q/PVvP/I9Xeuu5pfjzzy7itBEkOQxJgW5J3z1bzm6pd149q7P+9cvf96zeq+9Xw6X39FkMQQJDFeC/LIeWs+D62uW52f5591zv+ue8+H7/vf97hvgiSGIIkxLcjVuWec/1avu/qcq2vmOfB+zf21//758315Z96fz5XvGe+bIIkhSGK8FuR8vpvnoPn8OD/fHJmjbsf//P/PP4+d93+/5plrd+fO8fPN7xckMQyPEGPsgbEHpgV53/vjh3F3Th7Pc/N58c6cd+f5dHdu3Tueq3vnwKtz5njtfP8VQRJDkMSYFuTY9eZ5a56fVuf68V/GNfO/QHDnuXU+h/5zHfv/e+5ev3fO+6wIkhiCJMZrQc7nl/l5ap4j79fMX7a9G/r/9/8z1z3PdeN17/Pp+pz8vu94jnznnyAQJDEESYzXgtz9wm2eT8bz433tes48cj7dPXfOa+/Msfdr3q97RZDEECQxpgV55T/V3Lnf/Jy4nk/G/nfn/DvOsWOfv194rpnnybP7re5zRZDEECQxXgvy/vPBOF/Nz2HzHPfMvDn+C8Dr38j/5895jv3+fZw/x9dc/Ys+FwRJDEESY1qQ43PL+AXcPOfN89D8nPl9zXzNc+e81T3Xec76ZeDq/Y4QJDEESR5DE2PaL/euzm1H5rj7/vn8dOR5ctw37ltde3XN/PPYcS7eI0hiCJIYrwU5zzfzz/XG1/Pz1NX5bn4+nOe4/X3zHDp/AfdqPh3n0vk5+v7zjiCJIUhiTAvyzsuy+Xlmnpvm55vx/Dk/f67nwN33Ga+5ml/nL/rm6+c5+IggCULEeC3IdS4az0/zOWg+Z41z8eocuPsl3jwHzufY+Xxbv/Rb5+I9giSGIIkxLcgn1ef1/n0ESQxBEuO1IMkkSDIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJIYgiSFIYgiSGIIkhiCJIUhiCJIYgiSGIIkhSGIIkhiCJIYgiSFIYgiSGIIkxm+kWDBIHCiGkAAAAABJRU5ErkJggg=="
                                                                alt="QR Code" class="img-fluid" style="width: 100px; height: 100px;">
                                                            <div class="mt-2">No..........................</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-end mt-5">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </form>
        </div>
    </div>

    <!-- Modal Tambah Obat Pasien -->
    <div class="modal fade" id="modalTambahObat" tabindex="-1" aria-labelledby="modalTambahObatLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahObatLabel">Tambah Obat Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="obat-pasien-id">
                    <div class="mb-3">
                        <label for="obat-pasien-nama" class="form-label">Nama Obat</label>
                        <input type="text" class="form-control" id="obat-pasien-nama">
                    </div>
                    <div class="mb-3">
                        <label for="obat-pasien-dosis" class="form-label">Dosis</label>
                        <input type="text" class="form-control" id="obat-pasien-dosis">
                    </div>
                    <div class="mb-3">
                        <label for="obat-pasien-waktu" class="form-label">Waktu Penggunaan</label>
                        <input type="text" class="form-control" id="obat-pasien-waktu">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btn-simpan-obat-pasien">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Obat Dokter -->
    <div class="modal fade" id="modalTambahObatDokter" tabindex="-1" aria-labelledby="modalTambahObatDokterLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahObatDokterLabel">Tambah Obat Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="obat-dokter-id">
                    <div class="mb-3">
                        <label for="obat-dokter-nama" class="form-label">Nama Obat</label>
                        <input type="text" class="form-control" id="obat-dokter-nama">
                    </div>
                    <div class="mb-3">
                        <label for="obat-dokter-dosis" class="form-label">Dosis</label>
                        <input type="text" class="form-control" id="obat-dokter-dosis">
                    </div>
                    <div class="mb-3">
                        <label for="obat-dokter-waktu" class="form-label">Waktu Penggunaan</label>
                        <input type="text" class="form-control" id="obat-dokter-waktu">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btn-simpan-obat-dokter">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 12. Penyulit Selama HD -->
    <!-- Modal untuk Teknis -->
    <div class="modal fade" id="teknisModal" tabindex="-1" aria-labelledby="teknisModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teknisModalLabel">Pilih Penyulit Teknis Selama HD</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input teknis-option" type="checkbox" id="masalah_akses"
                            value="Masalah akses">
                        <label class="form-check-label" for="masalah_akses">Masalah akses</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input teknis-option" type="checkbox" id="clotting" value="Clotting">
                        <label class="form-check-label" for="clotting">Clotting</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input teknis-option" type="checkbox" id="leak_dialyzer"
                            value="Leak dialyzer">
                        <label class="form-check-label" for="leak_dialyzer">Leak dialyzer</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input teknis-option" type="checkbox" id="emboli_udara"
                            value="Emboli udara">
                        <label class="form-check-label" for="emboli_udara">Emboli udara</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input teknis-option" type="checkbox" id="lainnya" value="Lainnya">
                        <label class="form-check-label" for="lainnya">Lainnya</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveTeknisButton"
                        data-bs-dismiss="modal">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal untuk Klinis -->
    <div class="modal fade" id="klinisModal" tabindex="-1" aria-labelledby="klinisModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="klinisModalLabel">Pilih Penyulit Klinis Selama HD</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="bg-light p-3 rounded">
                        <div class="form-check mb-2">
                            <input class="form-check-input klinis-option" type="checkbox" id="hipotensi" value="Hipotensi">
                            <label class="form-check-label" for="hipotensi">Hipotensi</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input klinis-option" type="checkbox" id="hipertensi"
                                value="Hipertensi">
                            <label class="form-check-label" for="hipertensi">Hipertensi</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input klinis-option" type="checkbox" id="sakit_kepala"
                                value="Sakit kepala">
                            <label class="form-check-label" for="sakit_kepala">Sakit kepala</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input klinis-option" type="checkbox" id="mual_muntah"
                                value="Mual/muntah">
                            <label class="form-check-label" for="mual_muntah">Mual/muntah</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input klinis-option" type="checkbox" id="perdarahan"
                                value="Perdarahan">
                            <label class="form-check-label" for="perdarahan">Perdarahan</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input klinis-option" type="checkbox" id="nyeri" value="Nyeri">
                            <label class="form-check-label" for="nyeri">Nyeri</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveKlinisButton"
                        data-bs-dismiss="modal">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 13. Disharge Planning -->
    <!-- Modal untuk Rencana Pulang -->
    <div class="modal fade" id="rencanaPulangModal" tabindex="-1" aria-labelledby="rencanaPulangModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rencanaPulangModalLabel">Pilih Rencana Pulang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input rencana-pulang-option" type="checkbox"
                                            id="pembatasan_asupan_cairan" value="Pembatasan Asupan Cairan">
                                        <label class="form-check-label" for="pembatasan_asupan_cairan">Pembatasan Asupan
                                            Cairan</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input rencana-pulang-option" type="checkbox"
                                            id="pembatasan_asupan_tinggi_kalium" value="Pembatasan Asupan Tinggi Kalium">
                                        <label class="form-check-label" for="pembatasan_asupan_tinggi_kalium">Pembatasan
                                            Asupan Tinggi Kalium</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input rencana-pulang-option" type="checkbox"
                                            id="kepatuhan_minum_obat" value="Kepatuhan Minum Obat">
                                        <label class="form-check-label" for="kepatuhan_minum_obat">Kepatuhan Minum
                                            Obat</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveRencanaPulangButton"
                        data-bs-dismiss="modal">Simpan</button>
                </div>
            </div>
        </div>
    </div>

@endsection

