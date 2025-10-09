@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.hemodialisa.pelayanan.asesmen.keperawatan.create-include')

    <div class="row">
        <div class="col-md-3">
            @include('unit-pelayanan.hemodialisa.component.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />
                    @include('components.page-header', [
                        'title' => 'Asesmen Keperawatan',
                        'description' =>
                        'Tambah data asesmen keperawatan pasien hemodialisa di unit pelayanan hemodialisa.',
                    ])
                <form action="{{ route('hemodialisa.pelayanan.asesmen.keperawatan.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" method="post">
                    @csrf

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
                                                    <textarea name="anamnesis" id="anamnesis" class="form-control"></textarea>
                                                </div>
                                            </div>

                                            <div class="section-separator">
                                                <h5 class="section-title">2. Pemeriksaan Fisik</h5>

                                                <div class="form-group align-items-center">
                                                    <label style="min-width: 200px;">Tek. Darah (mmHg)</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label for="sistole" class="form-label">Sistole</label>
                                                            <input type="number" name="fisik_sistole" id="sistole"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="diastole" class="form-label">Diastole</label>
                                                            <input type="number" name="fisik_diastole" id="diastole"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="nadi" style="min-width: 200px;">Nadi (Per Menit)</label>
                                                    <input type="number" name="fisik_nadi" id="nadi" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="nafas" style="min-width: 200px;">Nafas (Per Menit)</label>
                                                    <input type="number" name="fisik_nafas" id="nafas" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="suhu" style="min-width: 200px;">Suhu (C)</label>
                                                    <input type="number" name="fisik_suhu" id="suhu" class="form-control">
                                                </div>

                                                <div class="form-group align-items-center">
                                                    <label style="min-width: 200px;">Saturasi Oksigen (%)</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label for="so_tb_o2" class="form-label">Tanpa bantuan O2</label>
                                                            <input type="number" name="so_tb_o2" id="so_tb_o2"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="so_db_o2" class="form-label">Dengan bantuan O2</label>
                                                            <input type="number" name="so_db_o2" id="so_db_o2"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="avpu" style="min-width: 200px;">AVPU</label>

                                                    <select name="avpu" id="avpu" class="form-select">
                                                        <option value="">--Pilih--</option>
                                                        <option value="0">Sadar Baik/Alert: 0</option>
                                                        <option value="1">Berespon dengan kata-kata/Voice: 1</option>
                                                        <option value="2">Hanya berespons jika dirangsang nyeri/Pain: 2</option>
                                                        <option value="3">Pasien tidak sadar/Unresponsive: 3</option>
                                                        <option value="4">Gelisah atau bingung: 4</option>
                                                        <option value="5">Acute Confusional States: 5</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="edema" style="min-width: 200px;">Edema</label>
                                                    <select name="edema" id="edema" class="form-select">
                                                        <option value="">--Pilih--</option>
                                                        <option value="0">Tidak</option>
                                                        <option value="1">Ya</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="konjungtiva" style="min-width: 200px;">Konjungtiva</label>
                                                    <select name="konjungtiva" id="konjungtiva" class="form-select">
                                                        <option value="">--Pilih--</option>
                                                        <option value="0">Tidak Anemis</option>
                                                        <option value="1">Anemis</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="dehidrasi" style="min-width: 200px;">Dehidrasi</label>
                                                    <select name="dehidrasi" id="dehidrasi" class="form-select">
                                                        <option value="">--Pilih--</option>
                                                        <option value="0">Tidak</option>
                                                        <option value="1">Ya</option>
                                                    </select>
                                                </div>

                                                <p class="fw-bold">Antropometri</p>

                                                <div class="form-group">
                                                    <label for="tinggi_badan" style="min-width: 200px;">Tinggi Badan
                                                        (Cm)</label>
                                                    <input type="number" name="tinggi_badan" id="tinggi_badan"
                                                        class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="berat_badan" style="min-width: 200px;">Berat Badan (Kg)</label>
                                                    <input type="number" name="berat_badan" id="berat_badan"
                                                        class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="imt" style="min-width: 200px;">Index Massa Tubuh (IMT)</label>
                                                    <input type="number" name="imt" id="imt" class="form-control" readonly>
                                                </div>

                                                <div class="form-group">
                                                    <label for="lpt" style="min-width: 200px;">Luas Permukaan Tubuh
                                                        (LPT)</label>
                                                    <input type="number" name="lpt" id="lpt" class="form-control" readonly>
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
                                                    @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                    <div class="col-md-6">
                                                        <div class="d-flex flex-column gap-3">
                                                            @foreach ($chunk as $item)
                                                                <div class="pemeriksaan-item">
                                                                    <div
                                                                        class="d-flex align-items-center border-bottom pb-2">
                                                                        <div class="flex-grow-1">{{ $item->nama }}
                                                                        </div>
                                                                        <div class="form-check me-3">
                                                                            <input type="checkbox" class="form-check-input"
                                                                                id="{{ $item->id }}-normal"
                                                                                name="{{ $item->id }}-normal" checked>
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
                                                                        style="display:none;">
                                                                        <input type="text" class="form-control"
                                                                            name="{{ $item->id }}_keterangan"
                                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                                </div>

                                            </div>

                                            <div class="section-separator">
                                                <h5 class="section-title">3. Status Nyeri</h5>

                                                <div class="form-group">
                                                    <label style="min-width: 200px;">Jenis Skala Nyeri</label>
                                                    <input type="text" class="form-control" value="Scale NRS, VAS, VRS"
                                                        disabled>
                                                </div>

                                                <div class="form-group justify-content-center">
                                                    <img src="{{ asset('assets/img/cppt/cppt.jpeg') }}" alt="" class="w-50">
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 200px;">Nilai Skala Nyeri</label>
                                                    <input type="number" name="status_skala_nyeri" class="form-control" min="0" max="10">
                                                </div>

                                            </div>

                                            <div class="section-separator">
                                                <h5 class="section-title">4. Riwayat Kesehatan</h5>
                                                <div class="form-group">
                                                    <label for="gagal_ginjal_stadium" style="min-width: 200px;">Gagal Ginjal
                                                        Stadium</label>
                                                    <input type="number" name="gagal_ginjal_stadium" class="form-control">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="jenis_gagal_ginjal" style="min-width: 200px;">Jenis Gagal
                                                        Ginjal</label>
                                                    <select class="form-control" id="jenis_gagal_ginjal"
                                                        name="jenis_gagal_ginjal">
                                                        <option value="" selected disabled>pilih</option>
                                                        <option value="akut">Akut</option>
                                                        <option value="kronis">Kronis</option>
                                                        <option value="lainnya">Lainnya</option>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="lama_menjalani_hd" style="min-width: 200px;">Lama Menjalani
                                                        HD</label>
                                                    <input type="number" class="form-control" id="lama_menjalani_hd"
                                                        name="lama_menjalani_hd">
                                                    <input type="text" class="form-control" id="lama_menjalani_hd_unit"
                                                        name="lama_menjalani_hd_unit" placeholder="tahun/bulan">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="jadwal_hd_rutin" style="min-width: 200px;">Jadwal HD
                                                        Rutin</label>
                                                    <input type="number" class="form-control" id="jadwal_hd_rutin"
                                                        name="jadwal_hd_rutin">
                                                    <input type="text" class="form-control" id="jadwal_hd_rutin_unit"
                                                        name="jadwal_hd_rutin_unit" placeholder="Per minggu">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="sesak_nafas" style="min-width: 200px;">Sesak Nafas/Nyeri
                                                        Dada</label>
                                                    <select class="form-control" id="sesak_nafas" name="sesak_nafas">
                                                        <option value="" selected disabled>pilih</option>
                                                        <option value="ya">Ya</option>
                                                        <option value="tidak">Tidak</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Riwayat penggunaan obat pada pasien -->
                                            {{-- <div class="section-separator">
                                                <h5 class="section-title">5. Riwayat Obat dan Rekomendasi Dokter</h5>

                                                <!-- Riwayat penggunaan obat pada pasien -->
                                                <div class="mb-4">
                                                    <p class="mb-2">Riwayat penggunaan obat pada pasien</p>

                                                    <button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center mb-3"
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
                                                    <input type="hidden" name="obat_pasien" id="obat_pasien_json">
                                                </div>

                                                <!-- Obat tambahan dokter -->
                                                <div class="mb-4">
                                                    <p class="mb-2">Jika terdapat obat tambahan dokter</p>

                                                    <button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center mb-3"
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
                                                    <input type="hidden" name="obat_dokter" id="obat_dokter_json">
                                                </div>
                                            </div> --}}

                                            <div class="section-separator">
                                                <h5 class="section-title">5. Pemeriksaan Penunjang</h5>

                                                <!-- Pre Hemodialisis -->
                                                <div class="mb-4">
                                                    <p class="fw-medium mb-3">Pre Hemodialisis</p>

                                                    <div class="row mb-3">
                                                        <label for="pre-ekg" class="col-sm-2 col-form-label text-end">EKG</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="pre-ekg" name="pre_ekg" placeholder="freetext">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="pre-rontgent" class="col-sm-2 col-form-label text-end">Rontgent</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="pre-rontgent" name="pre_rontgent" placeholder="freetext">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="pre-usg" class="col-sm-2 col-form-label text-end">USG</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="pre-usg" name="pre_usg" placeholder="freetext">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="pre-dll" class="col-sm-2 col-form-label text-end">Dll</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="pre-dll" name="pre_dll" placeholder="freetext">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Post Hemodialisis -->
                                                <div class="mb-4">
                                                    <p class="fw-medium mb-3">Post Hemodialisis</p>

                                                    <div class="row mb-3">
                                                        <label for="post-ekg" class="col-sm-2 col-form-label text-end">EKG</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="post-ekg" name="post_ekg" placeholder="freetext">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="post-rontgent" class="col-sm-2 col-form-label text-end">Rontgent</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="post-rontgent" name="post_rontgent" placeholder="freetext">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="post-usg" class="col-sm-2 col-form-label text-end">USG</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="post-usg" name="post_usg" placeholder="freetext">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="post-dll" class="col-sm-2 col-form-label text-end">Dll</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="post-dll" name="post_dll" placeholder="freetext">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="section-separator" id="alergi">
                                                <h5 class="section-title">6. Alergi</h5>
                                                <input type="hidden" name="alergi" value="{{ isset($dataResume->alergi) ? json_encode($dataResume->alergi) : '[]' }}">
                                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3" id="openAlergiModal">
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
                                                    @include('unit-pelayanan.hemodialisa.pelayanan.asesmen.keperawatan.modal-create-alergi')
                                                @endpush
                                            </div>

                                            <div class="section-separator">
                                                <h5 class="section-title">7. Status Gizi</h5>

                                                <div class="row mb-3">
                                                    <label for="gizi_tanggal_pengkajian" class="col-sm-3 col-form-label">Tanggal Pengkajian</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <input type="datetime-local" class="form-control"
                                                                id="gizi_tanggal_pengkajian"
                                                                name="gizi_tanggal_pengkajian"
                                                                value="{{ old('gizi_tanggal_pengkajian', isset($keperawatanStatusGizi) ? Carbon\Carbon::parse($keperawatanStatusGizi->gizi_tanggal_pengkajian)->format('Y-m-d\TH:i') : '') }}">
                                                        </div>
                                                        @error('gizi_tanggal_pengkajian')
                                                            <div class="invalid-feedback d-block">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="gizi_skore_mis" class="col-sm-3 col-form-label">Skore MIS</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" id="gizi_skore_mis" name="gizi_skore_mis"
                                                            placeholder="Angka">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="gizi_kesimpulan" class="col-sm-3 col-form-label">Kesimpulan</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-select" id="gizi_kesimpulan" name="gizi_kesimpulan">
                                                            <option value="" selected disabled>pilih</option>
                                                            <option value="Tampa mainutrisi (<6)">Tampa mainutrisi (6)</option>
                                                            <option value="Malnutrisi(>6)">Malnutrisi(>6)</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="gizi_rencana_pengkajian" class="col-sm-3 col-form-label">Rencana
                                                        Pengkajian Ulang MIS</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="gizi_rencana_pengkajian"
                                                            name="gizi_rencana_pengkajian" placeholder="jelaskan">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="gizi_rekomendasi" class="col-sm-3 col-form-label">Rekomendasi</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="gizi_rekomendasi"
                                                            name="gizi_rekomendasi" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="section-separator">
                                                <h5 class="section-title">8. Risiko Jatuh</h5>

                                                <h6 class="mt-3 mb-3">Penilaian Risiko Jatuh Skala Morse</h6>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Riwayat jatuh yang baru atau dalam bulan
                                                        terakhir</label>
                                                    <select class="form-select risiko-jatuh-select" id="riwayat_jatuh"
                                                        name="riwayat_jatuh" data-skor="25">
                                                        <option value="" selected disabled>pilih</option>
                                                        <option value="Ya" data-skor="25">Ya</option>
                                                        <option value="Tidak" data-skor="0">Tidak</option>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Pasien memiliki Diagnosa medis sekunder > 1
                                                        ?</label>
                                                    <select class="form-select risiko-jatuh-select" id="diagnosa_sekunder"
                                                        name="diagnosa_sekunder" data-skor="15">
                                                        <option value="" selected disabled>pilih</option>
                                                        <option value="Ya" data-skor="15">Ya</option>
                                                        <option value="Tidak" data-skor="0">Tidak</option>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Pasien membutuhkan bantuan Alat bantu jalan
                                                        ?</label>
                                                    <select class="form-select risiko-jatuh-select" id="alat_bantu"
                                                        name="alat_bantu" data-skor="30">
                                                        <option value="" selected disabled>pilih</option>
                                                        <option value="Tidak ada/ bed rest/ bantuan perawat" data-skor="0">Tidak
                                                            ada/ bed rest/ bantuan perawat</option>
                                                        <option value="kruk/ tongkat/ alat bantu berjalan" data-skor="15">kruk/
                                                            tongkat/ alat bantu berjalan</option>
                                                        <option value="Meja/ Kursi" data-skor="30">Meja/ Kursi</option>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Pasien terpasang infus?</label>
                                                    <select class="form-select risiko-jatuh-select" id="infus" name="infus"
                                                        data-skor="20">
                                                        <option value="" selected disabled>pilih</option>
                                                        <option value="Ya" data-skor="20">Ya</option>
                                                        <option value="Tidak" data-skor="0">Tidak</option>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Bagaimana cara berjalan pasien?</label>
                                                    <select class="form-select risiko-jatuh-select" id="cara_berjalan"
                                                        name="cara_berjalan" data-skor="20">
                                                        <option value="" selected disabled>pilih</option>
                                                        <option value="Normal/ bed rest/ kursi roda" data-skor="0">Normal/ bed
                                                            rest/ kursi roda</option>
                                                        <option value="Lemah" data-skor="10">Lemah</option>
                                                        <option value="Terganggu" data-skor="20">Terganggu</option>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="form-label">Bagaimana status mental pasien?</label>
                                                    <select class="form-select risiko-jatuh-select" id="status_mental"
                                                        name="status_mental" data-skor="15">
                                                        <option value="" selected disabled>pilih</option>
                                                        <option value="Orientasi sesuai kemampuan" data-skor="0">Orientasi
                                                            sesuai kemampuan</option>
                                                        <option value="Lupa keterbatasan" data-skor="15">Lupa keterbatasan
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="alert alert-info mt-4 mb-3" id="total-skor-container">
                                                    <strong>Total Skor: </strong> <span id="total-skor">0</span>
                                                </div>

                                                <div class="alert alert-primary" id="kesimpulan-container">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <strong>Kesimpulan: </strong>
                                                        <span id="kesimpulan-text">-</span>
                                                    </div>
                                                </div>

                                                <!-- Hidden input untuk menyimpan data ke database -->
                                                <input type="hidden" name="risiko_jatuh_skor" id="risiko_jatuh_skor" value="0">
                                                <input type="hidden" name="risiko_jatuh_kesimpulan" id="risiko_jatuh_kesimpulan"
                                                    value="">
                                            </div>

                                            <div class="section-separator">
                                                <h5 class="section-title">9. Status Psikososial</h5>

                                                <div class="row mb-3">
                                                    <label for="tanggal_pengkajian_psiko" class="col-sm-3 col-form-label">Tanggal Pengkajian</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <input type="date" class="form-control"
                                                                id="tanggal_pengkajian_psiko" name="tanggal_pengkajian_psiko"
                                                                value="{{ old('tanggal_pengkajian_psiko') }}" autocomplete="off">
                                                        </div>
                                                        @error('tanggal_pengkajian_psiko')
                                                            <div class="invalid-feedback d-block">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="kendala_komunikasi" class="col-sm-3 col-form-label">Kendala
                                                        Komunikasi</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-select" id="kendala_komunikasi"
                                                            name="kendala_komunikasi">
                                                            <option value="" selected disabled>pilih</option>
                                                            <option value="Normal">Normal</option>
                                                            <option value="Tidak jelas">Tidak Jelas</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="yang_merawat" class="col-sm-3 col-form-label">Yang Merawat di
                                                        rumah</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-select" id="yang_merawat" name="yang_merawat">
                                                            <option value="" selected disabled>pilih</option>
                                                            <option value="Ada">Ada</option>
                                                            <option value="Tidak">Tidak</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="kondisi_psikologis" class="col-sm-3 col-form-label">Kondisi
                                                        Psikologis</label>
                                                    <div class="col-sm-9">
                                                        <div class="btn-group" role="group">
                                                            <input type="checkbox" class="btn-check" id="kondisi_cemas"
                                                                name="kondisi_psikologis[]" value="Cemas" autocomplete="off">
                                                            <label class="btn btn-outline-secondary" for="kondisi_cemas">
                                                                Cemas <i class="bi bi-check"></i>
                                                            </label>

                                                            <input type="checkbox" class="btn-check" id="kondisi_marah"
                                                                name="kondisi_psikologis[]" value="Marah" autocomplete="off">
                                                            <label class="btn btn-outline-secondary" for="kondisi_marah">
                                                                Marah <i class="bi bi-check"></i>
                                                            </label>

                                                            <input type="checkbox" class="btn-check" id="kondisi_sedih"
                                                                name="kondisi_psikologis[]" value="Sedih" autocomplete="off">
                                                            <label class="btn btn-outline-secondary" for="kondisi_sedih">
                                                                Sedih <i class="bi bi-check"></i>
                                                            </label>

                                                            <input type="checkbox" class="btn-check" id="kondisi_takut"
                                                                name="kondisi_psikologis[]" value="Takut" autocomplete="off">
                                                            <label class="btn btn-outline-secondary" for="kondisi_takut">
                                                                Takut <i class="bi bi-check"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="kepatuhan_layanan" class="col-sm-3 col-form-label">Apakah
                                                        kepatuhan/ keterlibatan pasien berkaitan dengan pelayanan kesehatan yang
                                                        akan diberikan</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-select" id="kepatuhan_layanan"
                                                            name="kepatuhan_layanan" onchange="toggleJikaYa()">
                                                            <option value="" selected disabled>pilih</option>
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row mb-3" id="jika_ya_container" style="display: none;">
                                                    <label for="jika_ya_jelaskan" class="col-sm-3 col-form-label">Jika Iya
                                                        Jelaskan</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="jika_ya_jelaskan"
                                                            name="jika_ya_jelaskan" placeholder="jelaskan">
                                                    </div>
                                                </div>

                                                <input type="hidden" name="kondisi_psikologis_json" id="kondisi_psikologis_json">
                                            </div>

                                            <div class="section-separator">
                                                <h5 class="section-title">10. Monitoring Hemodialisis</h5>

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
                                                            <label for="hd_ke" class="col-sm-2 col-form-label text-end">HD
                                                                Ke</label>
                                                            <div class="col-sm-10">
                                                                <input type="number" class="form-control" id="hd_ke" name="inisiasi_hd_ke"
                                                                    placeholder="angka">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="nomor_mesin"
                                                                class="col-sm-2 col-form-label text-end">Nomor
                                                                Mesin</label>
                                                            <div class="col-sm-10">
                                                                <input type="number" class="form-control" id="nomor_mesin"
                                                                    name="inisiasi_nomor_mesin" placeholder="angka">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="bb_hd_lalu" class="col-sm-2 col-form-label text-end">BB
                                                                HD
                                                                Yang
                                                                Lalu</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="bb_hd_lalu"
                                                                        name="inisiasi_bb_hd_lalu">
                                                                    <span class="input-group-text">kg</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="tekanan_vena"
                                                                class="col-sm-2 col-form-label text-end">Tekanan
                                                                Vena</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="tekanan_vena"
                                                                        name="inisiasi_tekanan_vena">
                                                                    <span class="input-group-text">ml/mnt</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="lama_hd" class="col-sm-2 col-form-label text-end">Lama
                                                                HD</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="lama_hd"
                                                                        name="inisiasi_lama_hd">
                                                                    <span class="input-group-text">Jam</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="program_profiling"
                                                                class="col-sm-2 col-form-label text-end">Program
                                                                Profiling</label>
                                                            <div class="col-sm-10">
                                                                <div class="row mb-2">
                                                                    <div class="col-md-3">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                id="uf_profiling" name="program_profiling[]"
                                                                                value="UF Profiling Mode">
                                                                            <label class="form-check-label"
                                                                                for="uf_profiling">UF
                                                                                Profiling Mode</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control"
                                                                            id="uf_profiling_detail" name="inisiasi_uf_profiling_detail"
                                                                            placeholder="Freetext">
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-2">
                                                                    <div class="col-md-3">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                id="bicarbonat_profiling"
                                                                                name="program_profiling[]"
                                                                                value="Bicarbonat Profiling">
                                                                            <label class="form-check-label"
                                                                                for="bicarbonat_profiling">Bicarbonat
                                                                                Profiling</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control"
                                                                            id="bicarbonat_profiling_detail"
                                                                            name="inisiasi_bicarbonat_profiling_detail"
                                                                            placeholder="Freetext">
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                id="na_profiling" name="program_profiling[]"
                                                                                value="Na Profiling Mode">
                                                                            <label class="form-check-label"
                                                                                for="na_profiling">Na
                                                                                Profiling Mode</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" class="form-control"
                                                                            id="na_profiling_detail" name="inisiasi_na_profiling_detail"
                                                                            placeholder="Freetext">
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
                                                            <label for="type_dializer"
                                                                class="col-sm-2 col-form-label text-end">Type
                                                                Dializer</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="type_dializer"
                                                                    name="akut_type_dializer" placeholder="freetext">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="uf_goal" class="col-sm-2 col-form-label text-end">UF
                                                                Goal</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="uf_goal"
                                                                    name="akut_uf_goal" placeholder="freetext">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="bb_pre_hd" class="col-sm-2 col-form-label text-end">BB
                                                                Pre
                                                                HD</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="bb_pre_hd"
                                                                        name="akut_bb_pre_hd">
                                                                    <span class="input-group-text">kg</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="tekanan_arteri"
                                                                class="col-sm-2 col-form-label text-end">Tekanan
                                                                Arteri</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="tekanan_arteri"
                                                                        name="akut_tekanan_arteri">
                                                                    <span class="input-group-text">ml/mnt</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="laju_uf" class="col-sm-2 col-form-label text-end">ISO UF</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="laju_uf"
                                                                        name="akut_laju_uf">
                                                                    <span class="input-group-text">ml</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="lama_laju_uf"
                                                                class="col-sm-2 col-form-label text-end">Lama ISO UF</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="lama_laju_uf"
                                                                        name="akut_lama_laju_uf">
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
                                                            <label for="nr_ke" class="col-sm-2 col-form-label text-end">N/R
                                                                Ke</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="nr_ke" name="rutin_nr_ke"
                                                                    placeholder="freetext">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="bb_kering" class="col-sm-2 col-form-label text-end">BB
                                                                Kering</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="bb_kering"
                                                                        name="rutin_bb_kering">
                                                                    <span class="input-group-text">kg</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="bb_post_hd" class="col-sm-2 col-form-label text-end">BB
                                                                Post
                                                                HD</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="bb_post_hd"
                                                                        name="rutin_bb_post_hd">
                                                                    <span class="input-group-text">kg</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="tmp" class="col-sm-2 col-form-label text-end">TMP
                                                                (Transmembrane Pressure)</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="tmp" name="rutin_tmp">
                                                                    <span class="input-group-text">mmHg</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="program_aksesbilling"
                                                                class="col-sm-2 col-form-label text-end">Program Vaskular
                                                                Aksesbilling</label>
                                                            <div class="col-sm-10">
                                                                <div class="row mb-2">
                                                                    <div class="col-md-3">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                id="av_shunt" name="program_aksesbilling[]"
                                                                                value="AV Shunt">
                                                                            <label class="form-check-label" for="av_shunt">AV
                                                                                Shunt</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <select class="form-select" id="av_shunt_detail"
                                                                            name="rutin_av_shunt_detail">
                                                                            <option value="" selected disabled>Pilih</option>
                                                                            <option value="Kiri">Kiri</option>
                                                                            <option value="Kanan">Kanan</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-2">
                                                                    <div class="col-md-3">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                id="cdl" name="program_aksesbilling[]"
                                                                                value="CDL">
                                                                            <label class="form-check-label"
                                                                                for="cdl">CDL</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <select class="form-select" id="cdl_detail"
                                                                            name="rutin_cdl_detail">
                                                                            <option value="" selected disabled>Pilih</option>
                                                                            <option value="Jugularis">Jugularis</option>
                                                                            <option value="Subelavia">Subelavia</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                id="femoral" name="program_aksesbilling[]"
                                                                                value="Femoral">
                                                                            <label class="form-check-label"
                                                                                for="femoral">Femoral</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <select class="form-select" id="femoral_detail"
                                                                            name="rutin_femoral_detail">
                                                                            <option value="" selected disabled>Pilih</option>
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
                                                            <label for="dialisat"
                                                                class="col-sm-2 col-form-label text-end">Dialisat</label>
                                                            <div class="col-sm-10">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                id="dialisat_asetat" name="preop_dialisat"
                                                                                value="Asetat">
                                                                            <label class="form-check-label"
                                                                                for="dialisat_asetat">Asetat</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                id="dialisat_bicarbonat" name="preop_bicarbonat"
                                                                                value="Bicarbonat">
                                                                            <label class="form-check-label"
                                                                                for="dialisat_bicarbonat">Bicarbonat</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-2"></div>
                                                            <div class="col-sm-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="conductivity_check" name="conductivity_check"
                                                                        value="1">
                                                                    <label class="form-check-label"
                                                                        for="conductivity_check">Conductivity</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="conductivity"
                                                                        name="preop_conductivity">
                                                                    <span class="input-group-text">MS/Cm</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-2"></div>
                                                            <div class="col-sm-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="kalium_check" name="kalium_check" value="1">
                                                                    <label class="form-check-label"
                                                                        for="kalium_check">Kalium</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="kalium"
                                                                        name="preop_kalium">
                                                                    <span class="input-group-text">MEq/L</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-2"></div>
                                                            <div class="col-sm-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="suhu_dialisat_check" name="suhu_dialisat_check"
                                                                        value="1">
                                                                    <label class="form-check-label"
                                                                        for="suhu_dialisat_check">Suhu Dialisat</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="suhu_dialisat"
                                                                        name="preop_suhu_dialisat">
                                                                    <span class="input-group-text">°C</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-2"></div>
                                                            <div class="col-sm-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="base_na_check" name="base_na_check" value="1">
                                                                    <label class="form-check-label" for="base_na_check">Base
                                                                        Na</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="base_na"
                                                                        name="preop_base_na">
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
                                                            <label for="heparinisasi"
                                                                class="col-form-label">Heparinisasi</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <!-- Row 1: Dosis Sirkulasi dan Dosis Awal -->
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label for="dosis_sirkulasi" class="form-label">Dosis
                                                                        Sirkulasi</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            id="dosis_sirkulasi" name="dosis_sirkulasi">
                                                                        <span class="input-group-text">IU</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="dosis_awal" class="form-label">Dosis
                                                                        Awal</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" id="dosis_awal"
                                                                            name="dosis_awal">
                                                                        <span class="input-group-text">IU</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Row 2: Maintenance Kontinyu dan Maintenance Intermiten -->
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label for="maintenance_kontinyu"
                                                                        class="form-label">Maintenance Kontinyu</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            id="maintenance_kontinyu"
                                                                            name="maintenance_kontinyu">
                                                                        <span class="input-group-text">IU/jam</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="maintenance_intermiten"
                                                                        class="form-label">Maintenance Intermiten</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            id="maintenance_intermiten"
                                                                            name="maintenance_intermiten">
                                                                        <span class="input-group-text">IU/jam</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Row 3: Tanpa Heparin dan LMWH -->
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label for="tanpa_heparin" class="form-label">Tanpa Heparin
                                                                        (sc.)</label>
                                                                    <input type="text" class="form-control" id="tanpa_heparin"
                                                                        name="tanpa_heparin" placeholder="Text">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="lmwh" class="form-label">LMWH</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" id="lmwh"
                                                                            name="lmwh">
                                                                        <span class="input-group-text">IU</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Row 4: Program Bilas NaCl -->
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <label for="program_bilas_nacl" class="form-label">Program
                                                                        Bilas NaCl 0,9% 100cc/Jam</label>
                                                                    <select class="form-select" id="program_bilas_nacl"
                                                                        name="program_bilas_nacl">
                                                                        <option value="" selected disabled>pilih</option>
                                                                        <option value="Ya">Ya</option>
                                                                        <option value="Tidak">Tidak</option>
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
                                                                <h6 class="fw-bold">Pra HD</h6>
                                                            </div>
                                                        </div>

                                                        <!-- Waktu Pre HD -->
                                                        <div class="row mb-3">
                                                            <label for="waktu_pre_hd"
                                                                class="col-sm-2 col-form-label text-end">Waktu
                                                                Pra HD</label>
                                                            <div class="col-sm-10">
                                                                <input type="time" class="form-control" id="waktu_pre_hd"
                                                                    name="prehd_waktu_pre_hd">
                                                            </div>
                                                        </div>

                                                        <!-- Parameter Mesin HD (QB dan QD) -->
                                                        <div class="row mb-3">
                                                            <label for="parameter_mesin_hd"
                                                                class="col-sm-2 col-form-label text-end">Parameter Mesin
                                                                HD</label>
                                                            <div class="col-sm-10">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">QB</span>
                                                                            <input type="text" class="form-control" id="qb"
                                                                                name="prehd_qb">
                                                                            <span class="input-group-text">ml/menit</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">QD</span>
                                                                            <input type="text" class="form-control" id="qd"
                                                                                name="prehd_qd">
                                                                            <span class="input-group-text">ml/menit</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- UF Rate -->
                                                        <div class="row mb-3">
                                                            <label for="uf_rate" class="col-sm-2 col-form-label text-end">UF
                                                                Rate</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="uf_rate"
                                                                        name="prehd_uf_rate">
                                                                    <span class="input-group-text">ml/menit</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Tek. Darah (mmHg) - Sistole & Diastole -->
                                                        <div class="row mb-3">
                                                            <label for="tekanan_darah"
                                                                class="col-sm-2 col-form-label text-end">Tek.
                                                                Darah (mmHg)</label>
                                                            <div class="col-sm-10">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">Sistole</span>
                                                                            <input type="number" class="form-control" id="sistole"
                                                                                name="prehd_sistole">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">Diastole</span>
                                                                            <input type="number" class="form-control"
                                                                                id="diastole" name="prehd_diastole">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Nadi (Per Menit) -->
                                                        <div class="row mb-3">
                                                            <label for="nadi" class="col-sm-2 col-form-label text-end">Nadi (Per
                                                                Menit)</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control" id="nadi"
                                                                        name="prehd_nadi">
                                                                    <span class="input-group-text">x/mnt</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Nafas (Per Menit) -->
                                                        <div class="row mb-3">
                                                            <label for="nafas" class="col-sm-2 col-form-label text-end">Nafas
                                                                (Per
                                                                Menit)</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control" id="nafas"
                                                                        name="prehd_nafas">
                                                                    <span class="input-group-text">x/mnt</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Suhu (C) -->
                                                        <div class="row mb-3">
                                                            <label for="suhu" class="col-sm-2 col-form-label text-end">Suhu
                                                                (C)</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control" id="suhu"
                                                                        name="prehd_suhu">
                                                                    <span class="input-group-text">°C</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Pemantauan Cairan Intake -->
                                                        <div class="row mb-3">
                                                            <label for="pemantauan_cairan_intake"
                                                                class="col-sm-2 col-form-label text-end">Pemantauan Cairan
                                                                Intake</label>
                                                            <div class="col-sm-10">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">NaCl</span>
                                                                            <input type="text" class="form-control" id="nacl"
                                                                                name="prehd_nacl">
                                                                            <span class="input-group-text">ml</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">Minum</span>
                                                                            <input type="text" class="form-control" id="minum"
                                                                                name="prehd_minum">
                                                                            <span class="input-group-text">ml</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col-12">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">Lain-Lain</span>
                                                                            <input type="text" class="form-control"
                                                                                id="intake_lain" name="prehd_intake_lain">
                                                                            <span class="input-group-text">ml</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Pemantauan Cairan Output -->
                                                        <div class="row mb-3">
                                                            <label for="pemantauan_cairan_output"
                                                                class="col-sm-2 col-form-label text-end">Pemantauan Cairan
                                                                Output</label>
                                                            <div class="col-sm-10">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="output"
                                                                        name="prehd_output">
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
                                                        <label for="waktu_intra_pre_hd"
                                                            class="col-sm-2 col-form-label text-end">Waktu Intra Pre HD</label>
                                                        <div class="col-sm-10">
                                                            <input type="time" class="form-control" id="waktu_intra_pre_hd"
                                                                name="waktu_intra_pre_hd">
                                                        </div>
                                                    </div>

                                                    <!-- Parameter Mesin HD (QB dan QD) -->
                                                    <div class="row mb-3">
                                                        <label for="parameter_mesin_hd_intra"
                                                            class="col-sm-2 col-form-label text-end">Parameter Mesin HD</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">QB</span>
                                                                        <input type="number" class="form-control" id="qb_intra"
                                                                            name="qb_intra">
                                                                        <span class="input-group-text">ml/menit</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">QD</span>
                                                                        <input type="number" class="form-control" id="qd_intra"
                                                                            name="qd_intra">
                                                                        <span class="input-group-text">ml/menit</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- UF Rate -->
                                                    <div class="row mb-3">
                                                        <label for="uf_rate_intra" class="col-sm-2 col-form-label text-end">UF
                                                            Rate</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" id="uf_rate_intra"
                                                                    name="uf_rate_intra">
                                                                <span class="input-group-text">ml/menit</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tek. Darah (mmHg) - Sistole & Diastole -->
                                                    <div class="row mb-3">
                                                        <label for="tekanan_darah_intra"
                                                            class="col-sm-2 col-form-label text-end">Tek. Darah (mmHg)</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Sistole</span>
                                                                        <input type="number" class="form-control"
                                                                            id="sistole_intra" name="sistole_intra">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Diastole</span>
                                                                        <input type="number" class="form-control"
                                                                            id="diastole_intra" name="diastole_intra">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nadi (Per Menit) -->
                                                    <div class="row mb-3">
                                                        <label for="nadi_intra" class="col-sm-2 col-form-label text-end">Nadi
                                                            (Per Menit)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" id="nadi_intra"
                                                                    name="nadi_intra">
                                                                <span class="input-group-text">x/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nafas (Per Menit) -->
                                                    <div class="row mb-3">
                                                        <label for="nafas_intra" class="col-sm-2 col-form-label text-end">Nafas
                                                            (Per Menit)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" id="nafas_intra"
                                                                    name="nafas_intra">
                                                                <span class="input-group-text">x/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Suhu (C) -->
                                                    <div class="row mb-3">
                                                        <label for="suhu_intra" class="col-sm-2 col-form-label text-end">Suhu
                                                            (C)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" id="suhu_intra"
                                                                    name="suhu_intra">
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
                                                                        <input type="number" class="form-control" id="nacl_intra"
                                                                            name="nacl_intra">
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Minum</span>
                                                                        <input type="number" class="form-control" id="minum_intra"
                                                                            name="minum_intra">
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-12">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Lain-Lain</span>
                                                                        <input type="text" class="form-control"
                                                                            id="intake_lain_intra" name="intake_lain_intra">
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
                                                                <input type="number" class="form-control" id="output_intra"
                                                                    name="output_intra">
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
                                                        <table class="table table-bordered table-sm" id="observasiTable" style="min-width: 1500px;">
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
                                                                    <th style="min-width: 100px;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="observasiTableBody">
                                                                <!-- Baris akan ditambahkan dari data form -->
                                                            </tbody>
                                                            <tfoot class="table-secondary">
                                                                <tr class="text-center fw-bold align-middle">
                                                                    <td colspan="8" class="text-end">TOTAL:</td>
                                                                    <td id="total-nacl">0</td>
                                                                    <td id="total-minum">0</td>
                                                                    <td id="total-lain">0</td>
                                                                    <td id="total-output">0</td>
                                                                    <td></td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>

                                                    <!-- Hidden input for observasi_data -->
                                                    <input type="hidden" name="observasi_data" id="observasi_data" value="">

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
                                                        <label for="lama_waktu_post_hd"
                                                            class="col-sm-2 col-form-label text-end">Lama Waktu Post HD</label>
                                                        <div class="col-sm-10">
                                                            <input type="number" class="form-control" id="lama_waktu_post_hd"
                                                                name="lama_waktu_post_hd" placeholder="menit">
                                                        </div>
                                                    </div>

                                                    <!-- Parameter Mesin HD (QB dan QD) -->
                                                    <div class="row mb-3">
                                                        <label for="parameter_mesin_hd_post"
                                                            class="col-sm-2 col-form-label text-end">Parameter Mesin HD</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">QB</span>
                                                                        <input type="number" class="form-control" id="qb_post"
                                                                            name="qb_post">
                                                                        <span class="input-group-text">ml/menit</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">QD</span>
                                                                        <input type="number" class="form-control" id="qd_post"
                                                                            name="qd_post">
                                                                        <span class="input-group-text">ml/menit</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- UF Rate -->
                                                    <div class="row mb-3">
                                                        <label for="uf_rate_post" class="col-sm-2 col-form-label text-end">UF
                                                            Rate</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" id="uf_rate_post"
                                                                    name="uf_rate_post">
                                                                <span class="input-group-text">ml/menit</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tek. Darah (mmHg) - Sistole & Diastole -->
                                                    <div class="row mb-3">
                                                        <label for="tekanan_darah_post"
                                                            class="col-sm-2 col-form-label text-end">Tek. Darah (mmHg)</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Sistole</span>
                                                                        <input type="number" class="form-control"
                                                                            id="sistole_post" name="sistole_post">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Diastole</span>
                                                                        <input type="number" class="form-control"
                                                                            id="diastole_post" name="diastole_post">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nadi (Per Menit) -->
                                                    <div class="row mb-3">
                                                        <label for="nadi_post" class="col-sm-2 col-form-label text-end">Nadi
                                                            (Per Menit)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" id="nadi_post"
                                                                    name="nadi_post">
                                                                <span class="input-group-text">x/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Nafas (Per Menit) -->
                                                    <div class="row mb-3">
                                                        <label for="nafas_post" class="col-sm-2 col-form-label text-end">Nafas
                                                            (Per Menit)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" id="nafas_post"
                                                                    name="nafas_post">
                                                                <span class="input-group-text">x/mnt</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Suhu (C) -->
                                                    <div class="row mb-3">
                                                        <label for="suhu_post" class="col-sm-2 col-form-label text-end">Suhu
                                                            (C)</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" id="suhu_post"
                                                                    name="suhu_post">
                                                                <span class="input-group-text">°C</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Pemantauan Cairan Intake -->
                                                    <div class="row mb-3">
                                                        <label for="pemantauan_cairan_intake_post"
                                                            class="col-sm-2 col-form-label text-end">Pemantauan Cairan
                                                            Intake</label>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">NaCl</span>
                                                                        <input type="number" class="form-control" id="nacl_post"
                                                                            name="nacl_post">
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Minum</span>
                                                                        <input type="number" class="form-control" id="minum_post"
                                                                            name="minum_post">
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-12">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">Lain-Lain</span>
                                                                        <input type="number" class="form-control"
                                                                            id="intake_lain_post" name="intake_lain_post">
                                                                        <span class="input-group-text">ml</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Pemantauan Cairan Output -->
                                                    <div class="row mb-3">
                                                        <label for="pemantauan_cairan_output_post"
                                                            class="col-sm-2 col-form-label text-end">Pemantauan Cairan
                                                            Output</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control" id="output_post"
                                                                    name="output_post">
                                                                <span class="input-group-text">ml</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Jumlah Cairan Intake -->
                                                    <div class="row mb-3">
                                                        <label for="jumlah_cairan_intake"
                                                            class="col-sm-2 col-form-label text-end">Jumlah Cairan
                                                            Intake</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="number" class="form-control"
                                                                    id="jumlah_cairan_output" name="jumlah_cairan_intake">
                                                                <span class="input-group-text">ml</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Jumlah Cairan Output -->
                                                    <div class="row mb-3">
                                                        <label for="jumlah_cairan_output"
                                                            class="col-sm-2 col-form-label text-end">Jumlah Cairan
                                                            Output</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    id="ultrafiltration_total" name="jumlah_cairan_output">
                                                                <span class="input-group-text">ml</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Ultrafiltration Total -->
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label text-end">Ultrafiltration Total</label>
                                                        <div class="col-sm-10">
                                                            <input type="number" class="form-control" id="jumlah_cairan_intake"
                                                                name="ultrafiltration_total"
                                                                placeholder="input angka, otomatis menghitung total cairan yang diambil selama HD ml" readonly>
                                                        </div>
                                                    </div>

                                                    <!-- Keterangan SOAPIE -->
                                                    <div class="row mb-3">
                                                        <label for="keterangan_soapie"
                                                            class="col-sm-2 col-form-label text-end">Keterangan SOAPIE</label>
                                                        <div class="col-sm-10">
                                                            <textarea class="form-control" id="keterangan_soapie"
                                                                name="keterangan_soapie" rows="3" placeholder="text"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="section-separator mt-5">
                                                <h5 class="section-title">11. Penyulit Selama HD</h5>

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
                                                        <input type="hidden" id="klinis_values" name="klinis_values">
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
                                                        <input type="hidden" id="teknis_values" name="teknis_values">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="mesin" class="col-sm-2 col-form-label text-end">Mesin</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="mesin" name="mesin"
                                                            placeholder="Freetext">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="section-separator mt-5">
                                                <h5 class="section-title">12. Disharge Planning</h5>

                                                <div class="row mb-3">
                                                    <label for="rencana_pulang" class="col-sm-2 col-form-label text-end">Rencana
                                                        Pulang</label>
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
                                                        <input type="hidden" id="rencana_pulang_values"
                                                            name="rencana_pulang_values">
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="section-separator" id="diagnosis">
                                                <h5 class="fw-semibold mb-4">14. Diagnosis</h5>

                                                <!-- Diagnosis Banding -->
                                                <div class="mb-4">
                                                    <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
                                                    <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                        diagnosis banding,
                                                        apabila tidak ada, Pilih tanda tambah untuk menambah
                                                        keterangan diagnosis banding yang tidak ditemukan.</small>

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

                                                    <div id="diagnosis-banding-list"
                                                        class="diagnosis-list bg-light p-3 rounded">
                                                        <!-- Diagnosis items will be added here dynamically -->
                                                    </div>

                                                    <!-- Hidden input to store JSON data -->
                                                    <input type="hidden" id="diagnosis_banding" name="diagnosis_banding"
                                                        value="[]">
                                                </div>

                                                <!-- Diagnosis Kerja -->
                                                <div class="mb-4">
                                                    <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
                                                    <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                        diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                        keterangan diagnosis kerja yang tidak ditemukan.</small>

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
                                                        <!-- Diagnosis items will be added here dynamically -->
                                                    </div>

                                                    <!-- Hidden input to store JSON data -->
                                                    <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja" value="[]">
                                                </div>
                                            </div> --}}

                                            {{-- <div class="section-separator" style="margin-bottom: 2rem;" id="implementasi">
                                                <h5 class="fw-semibold mb-4">15. Implementasi</h5>

                                                <!-- Rencana Penatalaksanaan dan Pengobatan -->
                                                <div class="mb-4">
                                                    <label class="text-primary fw-semibold">Rencana Penatalaksanaan dan
                                                        Pengobatan</label>
                                                    <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                        rencana, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                                        rencana Penatalaksanaan dan Pengobatan kerja yang tidak
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
                                                    <div id="observasi-list" class="list-group mb-2">
                                                        <!-- Items will be added here dynamically -->
                                                    </div>
                                                    <!-- Hidden input to store JSON data -->
                                                    <input type="hidden" id="observasi" name="observasi" value="[]">
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
                                                    <div id="terapeutik-list" class="list-group mb-2">
                                                        <!-- Items will be added here dynamically -->
                                                    </div>
                                                    <!-- Hidden input to store JSON data -->
                                                    <input type="hidden" id="terapeutik" name="terapeutik" value="[]">
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
                                                    <div id="edukasi-list" class="list-group mb-2">
                                                        <!-- Items will be added here dynamically -->
                                                    </div>
                                                    <!-- Hidden input to store JSON data -->
                                                    <input type="hidden" id="edukasi" name="edukasi" value="[]">
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
                                                    <div id="kolaborasi-list" class="list-group mb-2">
                                                        <!-- Items will be added here dynamically -->
                                                    </div>
                                                    <!-- Hidden input to store JSON data -->
                                                    <input type="hidden" id="kolaborasi" name="kolaborasi" value="[]">
                                                </div>

                                                <!-- Kolaborasi Section -->
                                                <div class="mb-4">
                                                    <label class="text-primary fw-semibold">Prognosis</label>
                                                    <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                        Prognosis, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                        keterangan
                                                        Prognosis yang tidak ditemukan.</small>
                                                    <!-- sudah terlanjut buat ke rpp jadi yang di ubah hanya name sesuai DB saja ke prognosis -->
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text bg-white border-end-0">
                                                            <i class="bi bi-search text-secondary"></i>
                                                        </span>
                                                        <input type="text" id="rencana-input"
                                                            class="form-control border-start-0 ps-0"
                                                            placeholder="Cari dan tambah Rencana Penatalaksanaan">
                                                        <span class="input-group-text bg-white" id="add-rencana">
                                                            <i class="bi bi-plus-circle text-primary"></i>
                                                        </span>
                                                    </div>

                                                    <div id="rencana-list" class="list-group mb-3">
                                                        <!-- Items will be added here dynamically -->
                                                    </div>
                                                    <!-- Hidden input to store JSON data -->
                                                    <input type="hidden" id="rencana_penatalaksanaan" name="prognosis"
                                                        value="[]">
                                                </div>
                                            </div> --}}

                                            <!-- 16. Evaluasi -->
                                            <div class="section-separator mt-5">
                                                <h5 class="section-title">13. Evaluasi</h5>

                                                <!-- Tambah Evaluasi Keperawatan -->
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <label for="soap_s" class="form-label">Subjective (Subjektif)</label>
                                                        <textarea class="form-control" id="soap_s"
                                                            name="soap_s" rows="4"></textarea>
                                                    </div>
                                                </div>

                                                <!-- Tambah Evaluasi Medis -->
                                                <div class="row mb-4">
                                                    <div class="col-12">
                                                        <label for="soap_o" class="form-label">Objective (Objektif)</label>
                                                        <textarea class="form-control" id="soap_o" name="soap_o"
                                                            rows="4"></textarea>
                                                    </div>
                                                </div>
                                                <!-- Tambah Evaluasi Medis -->
                                                <div class="row mb-4">
                                                    <div class="col-12">
                                                        <label for="soap_a" class="form-label">Assessment (Penilaian)</label>
                                                        <textarea class="form-control" id="soap_a" name="soap_a"
                                                            rows="4"></textarea>
                                                    </div>
                                                </div>
                                                <!-- Tambah Evaluasi Medis -->
                                                <div class="row mb-4">
                                                    <div class="col-12">
                                                        <label for="soap_p" class="form-label">Plan (Perencanaan)</label>
                                                        <textarea class="form-control" id="soap_p" name="soap_p"
                                                            rows="4"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 17. Tanda Tangan dan Verifikasi -->
                                            <div class="section-separator mt-5">
                                                <h5 class="section-title">14. Tanda Tangan dan Verifikasi</h5>

                                                <!-- E-Signature Perawat Pemeriksa Akses Vaskular (Single) -->
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
                                                                        <option value="{{ $prwt->kd_karyawan }}">
                                                                            {{ "$prwt->gelar_depan $prwt->nama $prwt->gelar_belakang" }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 text-center">
                                                                <div id="qr-pemeriksa"></div>
                                                                <div class="mt-2" id="no-pemeriksa">No..........................</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- E-Signature Perawat Yang Bertugas (Multiple) -->
                                                <div class="row mb-4">
                                                    <div class="col-md-3">
                                                        <label class="form-label">E-Signature Nama Perawat Yang Bertugas</label>
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
                                                            <div class="col-md-4">
                                                                <button type="button" id="btn-tambah-perawat" class="btn btn-primary w-100">
                                                                    <i class="fas fa-plus"></i> Tambah
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <!-- List Perawat yang Dipilih -->
                                                        <div id="list-perawat-bertugas" class="border rounded bg-white">
                                                            <div class="text-muted text-center py-2" id="empty-message">
                                                                Belum ada perawat yang ditambahkan
                                                            </div>
                                                        </div>

                                                        <!-- Hidden input untuk menyimpan data JSON -->
                                                        <input type="hidden" name="perawat_bertugas" id="perawat-bertugas-json" value="">
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
                                                                <select name="dokter_pelaksana" id="dokter-pelaksana" class="form-select">
                                                                    <option value="">--Pilih--</option>
                                                                    @foreach ($dokterPelaksana as $item)
                                                                        <option value="{{ $item->dokter->kd_dokter }}">{{ $item->dokter->nama_lengkap }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 text-center">
                                                                <div id="qr-dokter"></div>
                                                                <div class="mt-2" id="no-dokter">No..........................</div>
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
                    </div>

                </form>
            </x-content-card>
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
    <div class="modal fade" id="modalTambahObatDokter" tabindex="-1" aria-labelledby="modalTambahObatDokterLabel" aria-hidden="true">
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
