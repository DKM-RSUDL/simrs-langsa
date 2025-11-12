@extends('layouts.administrator.master')


@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-kep-anak')
        </div>

        <div class="col-md-9">
            <x-content-card>
            <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Asesmen Awal Keperawatan Anak',
                    'description' =>
                    'Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan',
                ])

                    {{-- FORM ASESMEN AWAL KEPERATAWAN --}}
                    <form method="POST"
                        action="{{ route('rawat-inap.asesmen.keperawatan.anak.index', [
                            'kd_unit' => $kd_unit,
                            'kd_pasien' => $kd_pasien,
                            'tgl_masuk' => $tgl_masuk,
                            'urut_masuk' => $urut_masuk,
                        ]) }}">
                        @csrf
                        <div class="px-3">
                            <div>
                                <div class="section-separator" id="data-masuk">
                                    <h5 class="section-title">1. Data masuk</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal Dan Jam Pengerjaan</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <input type="date" class="form-control" name="tanggal_masuk"
                                                id="tanggal_masuk" value="{{ date('Y-m-d') }}">
                                            <input type="time" class="form-control" name="jam_masuk" id="jam_masuk"
                                                value="{{ date('H:i') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tiba Di Ruang Rawat Dengan Cara</label>
                                        <select class="form-select" name="cara_masuk">
                                            <option selected disabled>--Pilih--</option>
                                            <option value="Mandiri">Mandiri</option>
                                            <option value="Tempat Tidur">Tempat Tidur</option>
                                            <option value="Jalan Kaki">Jalan Kaki</option>
                                            <option value="Kursi Roda">Kursi Roda</option>
                                            <option value="Brankar">Brankar</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kasus Trauma</label>
                                        <select class="form-select" name="kasus_trauma">
                                            <option selected disabled>--Pilih--</option>
                                            <option value="Kecelakaan Lalu Lintas">Kecelakaan Lalu Lintas</option>
                                            <option value="Kecelakaan Anak">Kecelakaan Anak</option>
                                            <option value="Kecelakaan Rumah Tangga">Kecelakaan Rumah Tangga</option>
                                            <option value="Non Trauma">Non Trauma</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="section-separator" id="anamnesis">
                                    <h5 class="section-title">2. Anamnesis</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Anamnesis</label>
                                        <textarea class="form-control" name="anamnesis" rows="4"
                                            placeholder="keluhan utama dan riwayat penyakit sekarang"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Keluhan Utama</label>
                                        <input type="text" class="form-control" name="keluhan_utama"
                                            placeholder="keluhan utama">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Riwayat Kesehatan Sekarang</label>
                                        <input type="text" class="form-control" name="riwayat_kesehatan_sekarang"
                                            placeholder="riwayat kesehatan sekarang">
                                    </div>
                                </div>

                                <div class="section-separator" id="riwayat-kesehatan">
                                    <h5 class="section-title">5. Riwayat Kesehatan</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Penyakit Yang Pernah Diderita</label>
                                        <div class="w-100">
                                            <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                                data-bs-toggle="modal" data-bs-target="#penyakitModal">
                                                <i class="ti-plus"></i> Tambah Penyakit
                                            </button>
                                            <div id="selectedPenyakitList" class="d-flex flex-column gap-2">
                                                <!-- Empty state message -->
                                                <div id="emptyStatePenyakit"
                                                    class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                    <i class="ti-info-circle mb-2"></i>
                                                    <p class="mb-0">Belum ada penyakit yang ditambahkan.</p>
                                                </div>
                                            </div>
                                            <!-- Hidden input to store the JSON data -->
                                            <input type="hidden" name="penyakit_diderita" id="penyakitDideritaInput">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Riwayat Kecelakaan</label>
                                        <div class="w-100">
                                            <div class="d-flex gap-3 flex-wrap mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="riwayat_kecelakaan_lalu[]" value="Jatuh"
                                                        id="jatuh_lalu">
                                                    <label class="form-check-label" for="jatuh_lalu">Jatuh</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="riwayat_kecelakaan_lalu[]" value="Tenggelam"
                                                        id="tenggelam">
                                                    <label class="form-check-label" for="tenggelam">Tenggelam</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="riwayat_kecelakaan_lalu[]" value="KLL"
                                                        id="kll">
                                                    <label class="form-check-label" for="kll">KLL</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="riwayat_kecelakaan_lalu[]" value="Keracunan"
                                                        id="keracunan">
                                                    <label class="form-check-label" for="keracunan">Keracunan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Riwayat Rawat Inap</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <select class="form-select flex-grow-1" name="riwayat_rawat_inap">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Ya">Ya</option>
                                                <option value="Tidak">Tidak</option>
                                            </select>
                                            <input type="date" class="form-control" name="tanggal_rawat_inap"
                                                style="width: 200px;">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Riwayat Operasi</label>
                                        <select class="form-select" name="riwayat_operasi">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="Ya">Ya</option>
                                            <option value="Tidak">Tidak</option>
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
                                                <!-- Empty state message -->
                                                <div id="emptyStateOperasi"
                                                    class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                    <i class="ti-info-circle mb-2"></i>
                                                    <p class="mb-0">Belum ada operasi yang ditambahkan.</p>
                                                </div>
                                            </div>
                                            <!-- Hidden input to store the JSON data -->
                                            <input type="hidden" name="jenis_operasi" id="jenisOperasiInput">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Konsumsi Obat-Obatan</label>
                                        <input type="text" class="form-control" name="konsumsi_obat">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tumbuh Kembang Dibanding
                                            Saudara-Saudaranya</label>
                                        <select class="form-select" name="tumbuh_kembang">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="Sama">Sama</option>
                                            <option value="Cepat">Cepat</option>
                                            <option value="Lambat">Lambat</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Riwayat Penyakit Keluarga</label>
                                        <div class="w-100">
                                            <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                                data-bs-toggle="modal" data-bs-target="#riwayatKeluargaModal">
                                                <i class="ti-plus"></i> Tambah
                                            </button>
                                            <div id="selectedRiwayatList" class="d-flex flex-column gap-2">
                                                <!-- Empty state message -->
                                                <div id="emptyStateRiwayat"
                                                    class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                    <i class="ti-info-circle mb-2"></i>
                                                    <p class="mb-0">Belum ada riwayat Penyakit keluarga yang
                                                        ditambahkan.</p>
                                                </div>
                                            </div>
                                            <!-- Hidden input to store the JSON data -->
                                            <input type="hidden" name="riwayat_kesehatan_keluarga"
                                                id="riwayatKesehatanInput">
                                        </div>
                                    </div>
                                </div>

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
                                                    <th width="20%">Jenis Alergi</th>
                                                    <th width="25%">Alergen</th>
                                                    <th width="25%">Reaksi</th>
                                                    <th width="20%">Tingkat Keparahan</th>
                                                    <th width="10%">Aksi</th>
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


                                <div class="section-separator" id="pemeriksaan-fisik">
                                    <h5 class="section-title">3. Pemeriksaan fisik</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tek. Darah (mmHg)</label>
                                        <div class="d-flex gap-3" style="width: 100%;">

                                            <div class="flex-grow-1">
                                                <label class="form-label">Sistole</label>
                                                <input type="number" class="form-control" name="sistole"
                                                    placeholder="Sistole"
                                                    value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->sistole : '' }}">
                                            </div>

                                            <div class="flex-grow-1">
                                                <label class="form-label">Diastole</label>
                                                <input type="number" class="form-control" name="diastole"
                                                    placeholder="Diastole"
                                                    value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->diastole : '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nadi (Per Menit)</label>
                                        <input type="number" class="form-control" name="nadi"
                                            placeholder="frekuensi nadi per menit"
                                            value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->nadi : '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nafas (Per Menit)</label>
                                        <input type="number" class="form-control" name="nafas"
                                            placeholder="frekuensi nafas per menit"
                                            value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->respiration : '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Suhu (C)</label>
                                        <input type="text" class="form-control" name="suhu"
                                            placeholder="suhu dalam celcius"
                                            value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->suhu : '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Saturasi Oksigen (%)</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <label class="form-label">Tanpa Bantuan O2</label>
                                                <input type="number" class="form-control" name="saturasi_o2_tanpa"
                                                    placeholder="Tanpa bantuan O2"
                                                    value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->spo2_tanpa_o2 : '' }}">
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="form-label">Dengan Bantuan O2</label>
                                                <input type="number" class="form-control" name="saturasi_o2_dengan"
                                                    placeholder="Dengan bantuan O2"
                                                    value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->spo2_dengan_o2 : '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kesadaran</label>
                                        <select class="form-select" name="kesadaran">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="Compos Mentis">Compos Mentis</option>
                                            <option value="Apatis">Apatis</option>
                                            <option value="Sopor">Sopor</option>
                                            <option value="Coma">Coma</option>
                                            <option value="Somnolen">Somnolen</option>
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
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="1">Baik</option>
                                            <option value="2">Rusak</option>
                                            <option value="3">Alat Bantu</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pendengaran</label>
                                        <select class="form-select" name="pendengaran">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="1">Baik</option>
                                            <option value="2">Rusak</option>
                                            <option value="3">Alat Bantu</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Bicara</label>
                                        <select class="form-select" name="bicara">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="1">Normal</option>
                                            <option value="2">Gangguan</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Refleks Menelan</label>
                                        <select class="form-select" name="refleks_menelan">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="1">Normal</option>
                                            <option value="3">Rusak</option>
                                            <option value="2">Sulit</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pola Tidur</label>
                                        <select class="form-select" name="pola_tidur">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="1">Normal</option>
                                            <option value="2">Masalah</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Luka</label>
                                        <select class="form-select" name="luka">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="1">Normal</option>
                                            <option value="2">Gangguan</option>
                                            <option value="3">Tidak Ada Luka</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Defekasi</label>
                                        <select class="form-select" name="defekasi">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="1">Tidak Ada</option>
                                            <option value="2">Ada, Normal</option>
                                            <option value="3">Konsitipasi</option>
                                            <option value="4">Inkontinesia Alvi</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Miksi</label>
                                        <select class="form-select" name="miksi">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="1">Normal</option>
                                            <option value="2">Retensio</option>
                                            <option value="3">Inkontinesia Urine</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Gastrointestinal</label>
                                        <select class="form-select" name="gastrointestinal">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="1">Normal</option>
                                            <option value="2">Nausea</option>
                                            <option value="3">Muntah</option>
                                        </select>
                                    </div>



                                    <div class="mt-4">
                                        <h6>Riwayat tumbuh kembang</h6>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lahir Umur Kehamilan</label>
                                            <input type="text" class="form-control" name="umur_kehamilan"
                                                placeholder="minggu/bulan">
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">ASI Sampai Umur</label>
                                            <input type="text" class="form-control" name="Asi_Sampai_Umur"
                                                placeholder="minggu/bulan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Alasan Berhenti Menyusui</label>
                                            <input type="text" class="form-control"
                                                name="alasan_berhenti_menyusui">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Masalah Neonatus</label>
                                            <input type="text" class="form-control" name="masalah_neonatus">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kelainan Kongenital</label>
                                            <input type="text" class="form-control" name="kelainan_kongenital">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tengkurap</label>
                                            <input type="text" class="form-control" name="tengkurap">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Merangkak</label>
                                            <input type="text" class="form-control" name="merangkak">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Duduk</label>
                                            <input type="text" class="form-control" name="duduk">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Berdiri</label>
                                            <input type="text" class="form-control" name="berdiri">
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6>Antropometri</h6>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tinggi Badan (Cm)</label>
                                            <input type="number" id="tinggi_badan" name="tinggi_badan"
                                                class="form-control"
                                                value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->tinggi_badan : '' }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Berat Badan (Kg)</label>
                                            <input type="number" id="berat_badan" name="berat_badan"
                                                class="form-control"
                                                value="{{ isset($vitalSignsData) && $vitalSignsData ? $vitalSignsData->berat_badan : '' }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">IMT</label>
                                            <input type="text" class="form-control bg-light" id="imt"
                                                name="imt" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">LPT</label>
                                            <input type="text" class="form-control bg-light" id="lpt"
                                                name="lpt" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lingkar Kepala (Cm)</label>
                                            <input type="text" class="form-control" name="lingkar_kepala">
                                        </div>
                                    </div>

                                    <div class="alert alert-info mb-3 mt-4">
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
                                                                                checked>
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
                                    </div>
                                </div>

                                <div class="section-separator" id="status-nyeri">
                                    <h5 class="section-title">4. Status nyeri</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Jenis Skala NYERI</label>
                                        <select class="form-select" name="jenis_skala_nyeri" id="jenis_skala_nyeri">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="NRS">Numeric Rating Scale (NRS)</option>
                                            <option value="FLACC">Face, Legs, Activity, Cry, Consolability (FLACC)
                                            </option>
                                            <option value="CRIES">Crying, Requires, Increased, Expression, Sleepless
                                                (CRIES)</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nilai Skala Nyeri</label>
                                        <input type="text" class="form-control" id="nilai_skala_nyeri"
                                            name="nilai_skala_nyeri" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kesimpulan Nyeri</label>
                                        <input type="hidden" class="form-control" id="kesimpulan_nyeri"
                                            name="kesimpulan_nyeri">
                                        <div class="alert alert-success" id="kesimpulan_nyeri_alert">
                                            Pilih skala nyeri terlebih dahulu
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6 class="mb-3">Karakteristik Nyeri</h6>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Lokasi</label>
                                                <input type="text" class="form-control" name="lokasi_nyeri">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Durasi</label>
                                                <input type="text" class="form-control" name="durasi_nyeri">
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Jenis nyeri</label>
                                                <select class="form-select" name="jenis_nyeri">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    @foreach ($jenisnyeri as $jenis)
                                                        <option value="{{ $jenis->id }}">{{ $jenis->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Frekuensi</label>
                                                <select class="form-select" name="frekuensi_nyeri">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    @foreach ($frekuensinyeri as $frekuensi)
                                                        <option value="{{ $frekuensi->id }}">{{ $frekuensi->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Menjalar?</label>
                                                <select class="form-select" name="nyeri_menjalar">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    @foreach ($menjalar as $menjalar)
                                                        <option value="{{ $menjalar->id }}">{{ $menjalar->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Kualitas</label>
                                                <select class="form-select" name="kualitas_nyeri">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    @foreach ($kualitasnyeri as $kualitas)
                                                        <option value="{{ $kualitas->id }}">{{ $kualitas->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Faktor pemberat</label>
                                                <select class="form-select" name="faktor_pemberat">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    @foreach ($faktorpemberat as $pemberat)
                                                        <option value="{{ $pemberat->id }}">{{ $pemberat->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Faktor peringan</label>
                                                <select class="form-select" name="faktor_peringan">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    @foreach ($faktorperingan as $peringan)
                                                        <option value="{{ $peringan->id }}">{{ $peringan->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <label class="form-label">Efek Nyeri</label>
                                                <select class="form-select" name="efek_nyeri">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    @foreach ($efeknyeri as $efek)
                                                        <option value="{{ $efek->id }}">{{ $efek->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="section-separator" id="risiko_jatuh">
                                    <h5 class="section-title">7. Risiko Jatuh</h5>

                                    <div class="mb-4">
                                        <label class="form-label">Pilih jenis penilaian risiko jatuh sesuai dengan
                                            kondisi
                                            pasien:</label>
                                        <select class="form-select" id="risikoJatuhSkala" name="resiko_jatuh_jenis"
                                            onchange="showForm(this.value)">
                                            <option value="">--Pilih Skala--</option>
                                            <option value="1">Skala Umum</option>
                                            <option value="2">Skala Morse</option>
                                            <option value="3">Skala Humpty-Dumpty / Pediatrik</option>
                                            <option value="4">Skala Ontario Modified Stratify Sydney / Lansia
                                            </option>
                                            <option value="5">Lainnya</option>
                                        </select>
                                    </div>

                                    <!-- Form Skala Umum 1 -->
                                    <div id="skala_umumForm" class="risk-form">
                                        <h5 class="mb-4">Penilaian Risiko Jatuh Skala Umum</h5>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien berusia < dari 2 tahun?</label>
                                                    <select class="form-select" name="risiko_jatuh_umum_usia"
                                                        onchange="updateConclusion('umum')">
                                                        <option value="">pilih</option>
                                                        <option value="1">Ya</option>
                                                        <option value="0">Tidak</option>
                                                    </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien dalam kondisi sebagai geriatri,
                                                dizzines, vertigo,
                                                gangguan keseimbangan, gangguan penglihatan, penggunaan obat sedasi,
                                                status
                                                kesadaran dan
                                                atau kejiwaan, konsumsi alkohol?</label>
                                            <select class="form-select" onchange="updateConclusion('umum')"
                                                name="risiko_jatuh_umum_kondisi_khusus">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien didiagnosis sebagai pasien dengan
                                                penyakit
                                                parkinson?</label>
                                            <select class="form-select" onchange="updateConclusion('umum')"
                                                name="risiko_jatuh_umum_diagnosis_parkinson">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien sedang mendapatkan obat sedasi,
                                                riwayat
                                                tirah baring
                                                lama, perubahan posisi yang akan meningkatkan risiko jatuh?</label>
                                            <select class="form-select" onchange="updateConclusion('umum')"
                                                name="risiko_jatuh_umum_pengobatan_berisiko">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien saat ini sedang berada pada salah
                                                satu
                                                lokasi ini: rehab
                                                medik, ruangan dengan penerangan kurang dan bertangga?</label>
                                            <select class="form-select" onchange="updateConclusion('umum')"
                                                name="risiko_jatuh_umum_lokasi_berisiko">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="conclusion bg-success">
                                            <p class="conclusion-text">Kesimpulan: <span
                                                    id="kesimpulanTextForm"></span></p>
                                            <input type="hidden" name="risiko_jatuh_umum_kesimpulan"
                                                id="risiko_jatuh_umum_kesimpulan">
                                        </div>
                                    </div>

                                    <!-- Memperbaiki bagian Form Skala Morse 2 -->
                                    <div id="skala_morseForm" class="risk-form">
                                        <h5 class="mb-4">Penilaian Risiko Jatuh Skala Morse</h5>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien pernah mengalami Jatuh?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_riwayat_jatuh"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="25">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien memiliki diagnosis skunder?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_diagnosis_sekunder"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="15">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien membutuhkan bantuan ambulasi?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_bantuan_ambulasi"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="30">Meja/ kursi</option>
                                                <option value="15">Kruk/ tongkat/ alat bantu berjalan</option>
                                                <option value="0">Tidak ada/ bed rest/ bantuan perawat</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien terpasang infus?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_terpasang_infus"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="20">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Bagaimana cara berjalan pasien?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_cara_berjalan"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="0">Normal/ bed rest/ kursi roda</option>
                                                <option value="20">Terganggu</option>
                                                <option value="10">Lemah</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Bagaimana status mental pasien?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_status_mental"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="0">Beroroentasi pada kemampuannya</option>
                                                <option value="15">Lupa akan keterbatasannya</option>
                                            </select>
                                        </div>
                                        <div class="conclusion bg-success">
                                            <p class="conclusion-text">Kesimpulan: <span
                                                    id="kesimpulanTextForm"></span></p>
                                            <input type="hidden" name="risiko_jatuh_morse_kesimpulan"
                                                id="risiko_jatuh_morse_kesimpulan">
                                        </div>
                                    </div>

                                    <!-- Form Risiko Skala Humpty Dumpty 3 -->
                                    <div id="skala_humptyForm" class="risk-form">
                                        <h5 class="mb-4">Penilaian Risiko Skala Humpty Dumpty/ Pediatrik</h5>
                                        <div class="mb-3">
                                            <label class="form-label">Usia Anak?</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_usia_anak"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="4">Dibawah 3 tahun</option>
                                                <option value="3">3-7 tahun</option>
                                                <option value="2">7-13 tahun</option>
                                                <option value="1">Diatas 13 tahun</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jenis kelamin</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_jenis_kelamin"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="2">Laki-laki</option>
                                                <option value="1">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Diagnosis</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_diagnosis"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="4">Diagnosis Neurologis</option>
                                                <option value="3">Perubahan oksigennasi (diangnosis respiratorik,
                                                    dehidrasi, anemia,
                                                    syncope, pusing, dsb)</option>
                                                <option value="2">Gangguan perilaku /psikiatri</option>
                                                <option value="1">Diagnosis lainnya</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Gangguan Kognitif</label>
                                            <select class="form-select"
                                                name="risiko_jatuh_pediatrik_gangguan_kognitif"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="3">Tidak menyadari keterbatasan dirinya</option>
                                                <option value="2">Lupa akan adanya keterbatasan</option>
                                                <option value="1">Orientasi baik terhadap dari sendiri</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Faktor Lingkungan</label>
                                            <select class="form-select"
                                                name="risiko_jatuh_pediatrik_faktor_lingkungan"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="4">Riwayat jatuh /bayi diletakkan di tempat tidur
                                                    dewasa</option>
                                                <option value="3">Pasien menggunakan alat bantu /bayi diletakkan
                                                    di
                                                    tempat tidur bayi /
                                                    perabot rumah</option>
                                                <option value="2">Pasien diletakkan di tempat tidur</option>
                                                <option value="1">Area di luar rumah sakit</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pembedahan/ sedasi/ Anestesi</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_pembedahan"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="3">Dalam 24 jam</option>
                                                <option value="2">Dalam 48 jam</option>
                                                <option value="1">> 48 jam atau tidak menjalani
                                                    pembedahan/sedasi/anestesi</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Penggunaan Medika mentosa</label>
                                            <select class="form-select"
                                                name="risiko_jatuh_pediatrik_penggunaan_mentosa"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="3">Penggunaan multiple: sedative, obat hipnosis,
                                                    barbiturate, fenotiazi,
                                                    antidepresan, pencahar, diuretik, narkose</option>
                                                <option value="2">Penggunaan salah satu obat diatas</option>
                                                <option value="1">Penggunaan medikasi lainnya/tidak ada mediksi
                                                </option>
                                            </select>
                                        </div>
                                        <div class="conclusion bg-success">
                                            <p class="conclusion-text">Kesimpulan: <span
                                                    id="kesimpulanTextForm"></span></p>
                                            <input type="hidden" name="risiko_jatuh_pediatrik_kesimpulan"
                                                id="risiko_jatuh_pediatrik_kesimpulan">
                                        </div>
                                    </div>

                                    <!-- Form Skala Humpty Dumpty 4 -->
                                    <div id="skala_ontarioForm" class="risk-form">
                                        <h5 class="mb-4">Penilaian Risiko Jatuh Skala Ontario Modified Stratify
                                            Sydney/
                                            Lansia</h5>

                                        <!-- 1. Riwayat Jatuh -->
                                        <h6 class="mb-3">1. Riwayat Jatuh</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien datang kerumah sakit karena
                                                jatuh?</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_jatuh_saat_masuk_rs"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="6">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien memiliki 2 kali atau apakah pasien
                                                mengalami
                                                jatuh dalam 2
                                                bulan terakhir ini/ diagnosis multiple?</label>
                                            <select class="form-select"
                                                name="risiko_jatuh_lansia_riwayat_jatuh_2_bulan"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="6">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 2. Status Mental -->
                                        <h6 class="mb-3">2. Status Mental</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien bingung? (Tidak dapat membuat
                                                keputusan, jaga jarak
                                                tempatnya, gangguan daya ingat)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_status_bingung"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="14">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien disorientasi? (tidak menyadarkan
                                                waktu, tempat atau
                                                orang)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_status_disorientasi"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="14">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami agitasi? (keresahan,
                                                gelisah, dan
                                                cemas)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_status_agitasi"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="14">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 3. Penglihatan -->
                                        <h6 class="mb-3">3. Penglihatan</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien memakai Kacamata? </label>
                                            <select class="form-select" name="risiko_jatuh_lansia_kacamata"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami kelainya
                                                penglihatan/buram?</label>
                                            <select class="form-select"
                                                name="risiko_jatuh_lansia_kelainan_penglihatan"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mempunyai glukoma/ katarak/
                                                degenerasi
                                                makula?</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_glukoma"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 4. Kebiasaan Berkemih -->
                                        <h6 class="mb-3">4. Kebiasaan Berkemih</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah terdapat perubahan perilaku berkemih?
                                                (frekuensi, urgensi,
                                                inkontinensia, noktura)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_perubahan_berkemih"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="2">Ya</option>
                                                <option value="0">Tidak</option>
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
                                                <option value="0">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Memerlukan sedikit bantuan (1 orang) / dalam
                                                pengawasan</label>
                                            <select class="form-select"
                                                name="risiko_jatuh_lansia_transfer_bantuan_sedikit"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Memerlukan bantuan yang nyata (2 orang)</label>
                                            <select class="form-select"
                                                name="risiko_jatuh_lansia_transfer_bantuan_nyata"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="2">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tidak dapat duduk dengan seimbang, perlu bantuan
                                                total</label>
                                            <select class="form-select"
                                                name="risiko_jatuh_lansia_transfer_bantuan_total"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="3">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 6. Mobilitas Pasien -->
                                        <h6 class="mb-3">6. Mobilitas Pasien</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Mandiri (dapat menggunakan alat bantu
                                                jalan)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_mobilitas_mandiri"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="0">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">berjalan dengan bantuan 1 orang (verbal/
                                                fisik)</label>
                                            <select class="form-select"
                                                name="risiko_jatuh_lansia_mobilitas_bantuan_1_orang"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Menggunakan kusi roda</label>
                                            <select class="form-select"
                                                name="risiko_jatuh_lansia_mobilitas_kursi_roda"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="2">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Imobilisasi</label>
                                            <select class="form-select"
                                                name="risiko_jatuh_lansia_mobilitas_imobilisasi"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="3">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="conclusion bg-success">
                                            <p class="conclusion-text">Kesimpulan: <span
                                                    id="kesimpulanTextForm"></span></p>
                                            <input type="hidden" name="risiko_jatuh_lansia_kesimpulan"
                                                id="risiko_jatuh_lansia_kesimpulan">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h6 class="mb-3">Intervensi Risiko Jatuh</h6>
                                        <p class="mb-2">Tambah tindakan intervensi risiko jatuh:</p>

                                        <button type="button"
                                            class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3"
                                            data-bs-target="#tindakanKeperawatanRisikoJatuhModal">
                                            <i class="ti-plus"></i> Tambah
                                        </button>
                                        <div id="selectedTindakanList-risikojatuh" class="d-flex flex-column gap-2">
                                        </div>
                                        <input type="hidden" name="intervensi_risiko_jatuh_json"
                                            id="intervensi_risiko_jatuh_json" value="[]">
                                    </div>
                                </div>


                                <div class="section-separator" id="decubitus">
                                    <h5 class="section-title">8. Risiko dekubitus</h5>
                                    <p class="text-muted">Pilih jenis Skala Risiko Dekubitus sesuai kondisi pasien</p>

                                    <div class="form-group mb-4">
                                        <select class="form-select" id="skalaRisikoDekubitus"
                                            name="jenis_skala_dekubitus">
                                            <option value="" selected disabled>--Pilih Skala--</option>
                                            <option value="norton">Skala Norton</option>
                                            <option value="braden">Skala Braden</option>
                                        </select>
                                    </div>

                                    <!-- Form Skala Norton -->
                                    <div id="formNorton" class="decubitus-form" style="display: none;">
                                        <h6 class="mb-4">Penilaian Risiko DECUBITUS Skala Norton</h6>

                                        <div class="mb-4">
                                            <label class="form-label">Kondisi Fisik</label>
                                            <select class="form-select bg-light" name="kondisi_fisik">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="4">Baik</option>
                                                <option value="3">Sedang</option>
                                                <option value="2">Buruk</option>
                                                <option value="1">Sangat Buruk</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Kondisi mental</label>
                                            <select class="form-select bg-light" name="kondisi_mental">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="4">Sadar</option>
                                                <option value="3">Apatis</option>
                                                <option value="2">Bingung</option>
                                                <option value="1">Stupor</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Aktivitas</label>
                                            <select class="form-select bg-light" name="norton_aktivitas">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="4">Aktif</option>
                                                <option value="3">Jalan dengan bantuan</option>
                                                <option value="2">Terbatas di kursi</option>
                                                <option value="1">Terbatas di tempat tidur</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Mobilitas</label>
                                            <select class="form-select bg-light" name="norton_mobilitas">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="4">Bebas bergerak</option>
                                                <option value="3">Agak terbatas</option>
                                                <option value="2">Sangat terbatas</option>
                                                <option value="1">Tidak dapat bergerak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Inkontinensia</label>
                                            <select class="form-select bg-light" name="inkontinensia">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="4">Tidak ada</option>
                                                <option value="3">Kadang-kadang</option>
                                                <option value="2">Biasanya urin</option>
                                                <option value="1">Urin dan feses</option>
                                            </select>
                                        </div>

                                        <div class="mt-4">
                                            <div class="d-flex gap-2">
                                                <span class="fw-bold">Kesimpulan :</span>
                                                <div id="kesimpulanNorton"
                                                    class="alert alert-success mb-0 flex-grow-1">
                                                    Risiko Rendah
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
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="1">Keterbatasan Penuh</option>
                                                <option value="2">Sangat Terbatas</option>
                                                <option value="3">Keterbatasan Ringan</option>
                                                <option value="4">Tidak Ada Gangguan</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Kelembapan</label>
                                            <select class="form-select bg-light" name="kelembapan">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="1">Selalu Lembap</option>
                                                <option value="2">Umumnya Lembap</option>
                                                <option value="3">Kadang-Kadang Lembap</option>
                                                <option value="4">Jarang Lembap</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Aktivitas</label>
                                            <select class="form-select bg-light" name="braden_aktivitas">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="1">Total di Tempat Tidur</option>
                                                <option value="2">Dapat Duduk</option>
                                                <option value="3">Berjalan Kadang-kadang</option>
                                                <option value="4">Dapat Berjalan-jalan</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Mobilitas</label>
                                            <select class="form-select bg-light" name="braden_mobilitas">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="1">Tidak Mampu Bergerak Sama sekali</option>
                                                <option value="2">Sangat Terbatas</option>
                                                <option value="3">Tidak Ada Masalah</option>
                                                <option value="4">Tanpa Keterbatasan</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Nutrisi</label>
                                            <select class="form-select bg-light" name="nutrisi">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="1">Sangat Buruk</option>
                                                <option value="2">Kurang Menucukup</option>
                                                <option value="3">Mencukupi</option>
                                                <option value="4">Sangat Baik</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Pergesekan dan Pergeseran</label>
                                            <select class="form-select bg-light" name="pergesekan">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="1">Bermasalah</option>
                                                <option value="2">Potensial Bermasalah</option>
                                                <option value="3">Keterbatasan Ringan</option>
                                            </select>
                                        </div>

                                        <div class="mt-4">
                                            <div class="d-flex gap-2">
                                                <span class="fw-bold">Kesimpulan :</span>
                                                <div id="kesimpulanNorton"
                                                    class="alert alert-success mb-0 flex-grow-1">
                                                    Kesimpulan Skala Braden
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

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
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Tidak ada kelainan" id="kondisi1">
                                                                <label class="form-check-label" for="kondisi1">Tidak
                                                                    ada
                                                                    kelainan</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Cemas" id="kondisi2">
                                                                <label class="form-check-label"
                                                                    for="kondisi2">Cemas</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Takut" id="kondisi3">
                                                                <label class="form-check-label"
                                                                    for="kondisi3">Takut</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Marah" id="kondisi4">
                                                                <label class="form-check-label"
                                                                    for="kondisi4">Marah</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Sedih" id="kondisi5">
                                                                <label class="form-check-label"
                                                                    for="kondisi5">Sedih</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Tenang" id="kondisi6">
                                                                <label class="form-check-label"
                                                                    for="kondisi6">Tenang</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Tidak semangat" id="kondisi7">
                                                                <label class="form-check-label" for="kondisi7">Tidak
                                                                    semangat</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Tertekan" id="kondisi8">
                                                                <label class="form-check-label"
                                                                    for="kondisi8">Tertekan</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Depresi" id="kondisi9">
                                                                <label class="form-check-label"
                                                                    for="kondisi9">Depresi</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Sulit tidur" id="kondisi10">
                                                                <label class="form-check-label"
                                                                    for="kondisi10">Sulit
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
                                        <input type="hidden" name="kondisi_psikologis_json"
                                            id="kondisi_psikologis_json" value="[]">
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
                                                <div class="dropdown-menu p-2 shadow-sm"
                                                    id="dropdownGangguanPerilaku"
                                                    style="display: none; position: absolute; z-index: 1000; min-width: 250px; background: white; border: 1px solid rgba(0,0,0,.15); border-radius: 4px;">
                                                    <div class="fw-bold mb-2">GANGGUAN PERILAKU</div>
                                                    <div class="perilaku-options">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="Tidak Ada Gangguan" id="perilaku1">
                                                            <label class="form-check-label" for="perilaku1">Tidak
                                                                Ada
                                                                Gangguan</label>
                                                        </div>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="Perilaku Kekerasan" id="perilaku2">
                                                            <label class="form-check-label" for="perilaku2">Perilaku
                                                                Kekerasan</label>
                                                        </div>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="Halusinasi" id="perilaku3">
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
                                        <input type="hidden" name="gangguan_perilaku_json"
                                            id="gangguan_perilaku_json" value="[]">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Potensi menyakiti diri sendiri/orang lain</label>
                                        <select class="form-select" name="potensi_menyakiti">
                                            <option value="" selected disabled>pilih</option>
                                            <option value="0">Ya</option>
                                            <option value="1">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Anggota Keluarga Gangguan Jiwa</label>
                                        <select class="form-select" name="anggota_keluarga_gangguan_jiwa">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="0">Ya</option>
                                            <option value="1">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Lainnya</label>
                                        <input type="text" class="form-control" name="psikologis_lainnya">
                                    </div>
                                </div>

                                <div class="section-separator" id="status_spiritual">
                                    <h5 class="section-title">10. Status Spiritual</h5>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Keyakinan Agama</label>
                                        <select class="form-select" name="keyakinan_agama">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Protestan">Protestan</option>
                                            <option value="Khatolik">Khatolik</option>
                                            <option value="Budha">Budha</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Konghucu">Konghucu</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pandangan Pasien Terhadap Penyakit
                                            Nya</label>
                                        <select class="form-select" name="pandangan_terhadap_penyakit">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="Takdir">Takdir</option>
                                            <option value="Hukuman">Hukuman</option>
                                            <option value="Tidak Ada">Tidak Ada</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="section-separator" id="status_sosial_ekonomi">
                                    <h5 class="section-title">11. Status Sosial Ekonomi</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pekerjaan</label>
                                        <select class="form-select" name="pekerjaan_pasien">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="Belum Bekerja">Belum Bekerja</option>
                                            <option value="Purnawaktu">Purnawaktu</option>
                                            <option value="Paruh Waktu">Paruh Waktu</option>
                                            <option value="Pensiunan">Pensiunan</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Status Pernikahan</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <select class="form-select flex-grow-1" name="status_pernikahan">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Menikah">Menikah</option>
                                                <option value="Belum Menikah">Belum Menikah</option>
                                                <option value="Cerai">Cerai</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tempat Tinggal</label>
                                        <select class="form-select" name="tempat_tinggal">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="Rumah">Rumah</option>
                                            <option value="Asrama">Asrama</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Curiga Penganiayaan</label>
                                        <select class="form-select" name="curiga_penganiayaan">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="Ya">Ya</option>
                                            <option value="Tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Status Tinggal Dengan Keluarga</label>
                                        <select class="form-select" name="status_tinggal">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="Orang Tua">Orang Tua</option>
                                            <option value="Wali">Wali</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="section-separator" id="status_gizi">
                                    <h5 class="section-title">12. Status Gizi</h5>
                                    <div class="form-group mb-4">
                                        <select class="form-select" name="gizi_jenis" id="nutritionAssessment">
                                            <option value="">--Pilih--</option>
                                            <option value="1">Malnutrition Screening Tool (MST)</option>
                                            <option value="2">The Mini Nutritional Assessment (MNA)</option>
                                            <option value="3">Strong Kids (1 bln - 18 Tahun)</option>
                                            <option value="5">Tidak Dapat Dinilai</option>
                                        </select>
                                    </div>

                                    <!-- MST Form -->
                                    <div id="mst" class="assessment-form" style="display: none;">
                                        <h6 class="mb-3">Penilaian Gizi Malnutrition Screening Tool (MST)</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami penurunan BB yang tidak
                                                diinginkan dalam 6 bulan
                                                terakhir?</label>
                                            <select class="form-select" name="gizi_mst_penurunan_bb">
                                                <option value="">pilih</option>
                                                <option value="0">Tidak ada penurunan Berat Badan (BB)</option>
                                                <option value="2">Tidak yakin/ tidak tahu/ terasa baju lebi
                                                    longgar</option>
                                                <option value="3">Ya ada penurunan BB</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jika jawaban di atas "Ya ada penurunan BB",
                                                berapa
                                                penurunan BB
                                                tersebut?</label>
                                            <select class="form-select" name="gizi_mst_jumlah_penurunan_bb">
                                                <option value="0">pilih</option>
                                                <option value="1">1-5 kg</option>
                                                <option value="2">6-10 kg</option>
                                                <option value="3">11-15 kg</option>
                                                <option value="4">>15 kg</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah asupan makan berkurang karena tidak nafsu
                                                makan?</label>
                                            <select class="form-select" name="gizi_mst_nafsu_makan_berkurang">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien didiagnosa khusus seperti: DM, Cancer
                                                (kemoterapi), Geriatri, GGk
                                                (hemodialisis), Penurunan Imum</label>
                                            <select class="form-select" name="gizi_mst_diagnosis_khusus">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Nilai -->
                                        <div id="mstConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-success">Kesimpulan: 0-1 tidak berisiko malnutrisi
                                            </div>
                                            <div class="alert alert-warning">Kesimpulan: ≥ 2 berisiko malnutrisi</div>
                                            <input type="hidden" name="gizi_mst_kesimpulan"
                                                id="gizi_mst_kesimpulan">
                                        </div>
                                    </div>

                                    <!-- MNA Form -->
                                    <div id="mna" class="assessment-form" style="display: none;">
                                        <h6 class="mb-3">Penilaian Gizi The Mini Nutritional Assessment (MNA) /
                                            Lansia</h6>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Apakah pasien mengalami penurunan asupan makanan selama 3 bulan terakhir
                                                karena hilang selera makan, masalah pencernaan, kesulitan mengunyah atau
                                                menelan?
                                            </label>
                                            <select class="form-select" name="gizi_mna_penurunan_asupan_3_bulan">
                                                <option value="">--Pilih--</option>
                                                <option value="0">Mengalami penurunan asupan makanan yang parah
                                                </option>
                                                <option value="1">Mengalami penurunan asupan makanan sedang
                                                </option>
                                                <option value="2">Tidak mengalami penurunan asupan makanan
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Apakah pasien mengalami kehilangan Berat Badan (BB) selama 3 bulan
                                                terakhir?
                                            </label>
                                            <select class="form-select" name="gizi_mna_kehilangan_bb_3_bulan">
                                                <option value="">-- Pilih --</option>
                                                <option value="0">Kehilangan BB lebih dari 3 Kg</option>
                                                <option value="1">Tidak tahu</option>
                                                <option value="2">Kehilangan BB antara 1 s.d 3 Kg</option>
                                                <option value="3">Tidak ada kehilangan BB</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Bagaimana mobilisasi atau pergerakan
                                                pasien?</label>
                                            <select class="form-select" name="gizi_mna_mobilisasi">
                                                <option value="">-- Pilih --</option>
                                                <option value="0">Hanya di tempat tidur atau kursi roda</option>
                                                <option value="1">Dapat turun dari tempat tidur tapi tidak dapat
                                                    jalan-jalan</option>
                                                <option value="2">Dapat jalan-jalan</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Apakah Pasien mengalami stres psikologi atau penyakit akut selama 3
                                                bulan terakhir?
                                            </label>
                                            <select class="form-select" name="gizi_mna_stress_penyakit_akut">
                                                <option value="">-- Pilih --</option>
                                                <option value="1">Tidak</option>
                                                <option value="0">Ya</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami masalah
                                                neuropsikologi?</label>
                                            <select class="form-select" name="gizi_mna_status_neuropsikologi">
                                                <option value="">-- Pilih --</option>
                                                <option value="0">Demensia atau depresi berat</option>
                                                <option value="1">Demensia ringan</option>
                                                <option value="2">Tidak mengalami masalah neuropsikologi</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Berapa Berat Badan (BB) pasien? (Kg)</label>
                                            <input type="number" name="gizi_mna_berat_badan" class="form-control"
                                                id="mnaWeight" min="1" step="0.1"
                                                placeholder="Masukkan berat badan dalam Kg">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Berapa Tinggi Badan (TB) pasien? (cm)</label>
                                            <input type="number" name="gizi_mna_tinggi_badan"
                                                class="form-control" id="mnaHeight" min="1"
                                                step="0.1" placeholder="Masukkan tinggi badan dalam cm">
                                        </div>

                                        <!-- IMT -->
                                        <div class="mb-3">
                                            <label class="form-label">Indeks Massa Tubuh (IMT)</label>
                                            <div class="text-muted small mb-2">
                                                <i>Rumus IMT = BB (Kg) / (TB (m))²</i>
                                            </div>
                                            <input type="number" name="gizi_mna_imt"
                                                class="form-control bg-light" id="mnaBMI" readonly
                                                placeholder="IMT akan terhitung otomatis">
                                        </div>

                                        <!-- Kesimpulan -->
                                        <div id="mnaConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-info mb-3">
                                                Silakan isi semua parameter di atas untuk melihat kesimpulan
                                            </div>
                                            <div class="alert alert-success" style="display: none;">
                                                Kesimpulan: Total Skor ≥ 12 (Tidak Beresiko Malnutrisi)
                                            </div>
                                            <div class="alert alert-warning" style="display: none;">
                                                Kesimpulan: Total Skor ≤ 11 (Beresiko Malnutrisi)
                                            </div>
                                            <input type="hidden" name="gizi_mna_kesimpulan"
                                                id="gizi_mna_kesimpulan">
                                        </div>
                                    </div>

                                    <!-- Strong Kids Form -->
                                    <div id="strong-kids" class="assessment-form" style="display: none;">
                                        <h6 class="mb-3">Penilaian Gizi Strong Kids</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah anak tampa kurus kehilangan lemak
                                                subkutan, kehilangan massa otot, dan/ atau wajah cekung?</label>
                                            <select class="form-select" name="gizi_strong_status_kurus">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah terdapat penurunan BB selama satu bulan
                                                terakhir (untuk semua usia)?
                                                (berdasarkan penilaian objektif data BB bila ada/penilaian subjektif
                                                dari
                                                orang tua pasien ATAu
                                                tidak ada peningkatan berat badan atau tinggi badan (pada bayi < 1
                                                    tahun) selama 3 bulan terakhir)</label>
                                                    <select class="form-select" name="gizi_strong_penurunan_bb">
                                                        <option value="">pilih</option>
                                                        <option value="1">Ya</option>
                                                        <option value="0">Tidak</option>
                                                    </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Apakah salah satu dari hal berikut ini ada? <br>
                                                - Diare berlabihan (>= 5 kali perhari) dan/atau muntah(>3 klai perhari)
                                                selama 1-3 hari terakhir
                                                - Penurunan asupan makanan selama 1-3 hari terakhir
                                                - Intervensi gizi yang sudah ada sebelumnya (misalnya, ONS atau
                                                pemberian
                                                maka selang)</label>
                                            <select class="form-select" name="gizi_strong_gangguan_pencernaan">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah terdapat penyakit atau keadaan yang
                                                mengakibatkan pasien berisiko
                                                mengalaman mainutrisi? <br>
                                                <a href="#"><i>Lihat penyakit yang berisiko
                                                        malnutrisi</i></a></label>
                                            <select class="form-select" name="gizi_strong_penyakit_berisiko">
                                                <option value="">pilih</option>
                                                <option value="2">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Nilai -->
                                        <div id="strongKidsConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-success">Kesimpulan: 0 (Beresiko rendah)</div>
                                            <div class="alert alert-warning">Kesimpulan: 1-3 (Beresiko sedang)</div>
                                            <div class="alert alert-success">Kesimpulan: 4-5 (Beresiko Tinggi)</div>
                                            <input type="hidden" name="gizi_strong_kesimpulan"
                                                id="gizi_strong_kesimpulan">
                                        </div>
                                    </div>

                                    <!-- Form NRS -->
                                    <div id="nrs" class="risk-form">
                                        <h5 class="mb-4">Penilaian Risiko Jatuh Skala Ontario Modified Stratify
                                            Sydney/
                                            Lansia</h5>

                                        <!-- 1. Riwayat Jatuh -->
                                        <h6 class="mb-3">1. Riwayat Jatuh</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien datang kerumah sakit karena
                                                jatuh?</label>
                                            <select class="form-select" name="gizi_nrs_jatuh_saat_masuk_rs"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="2">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien memiliki jika tidak, apakah pasien
                                                mengalami
                                                jatuh dalam 2 bulan
                                                terakhir ini? diagnosis skunder?</label>
                                            <select class="form-select" name="gizi_nrs_jatuh_2_bulan_terakhir"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="2">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 2. Status Mental -->
                                        <h6 class="mb-3">2. Status Mental</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien delirium? (Tidak dapat membuat
                                                keputusan, pola pikir tidak
                                                terorganisir, gangguan daya ingat)</label>
                                            <select class="form-select" name="gizi_nrs_status_delirium"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien disorientasi? (tidak menyadarkan
                                                waktu, tempat atau
                                                orang)</label>
                                            <select class="form-select" name="gizi_nrs_status_disorientasi"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami agitasi? (keresahan,
                                                gelisah, dan
                                                cemas)</label>
                                            <select class="form-select" name="gizi_nrs_status_agitasi"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 3. Penglihatan -->
                                        <h6 class="mb-3">3. Penglihatan</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien memakai kacamata?</label>
                                            <select class="form-select" name="gizi_nrs_menggunakan_kacamata"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengaluh adanya penglihatan
                                                buram?</label>
                                            <select class="form-select" name="gizi_nrs_keluhan_penglihatan_buram"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien menpunyai glaukoma/ katarak/
                                                degenerasi makula?</label>
                                            <select class="form-select" name="gizi_nrs_degenerasi_makula"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 4. Kebiasaan Berkemih -->
                                        <h6 class="mb-3">4. Kebiasaan Berkemih</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah terdapat perubahan perilaku berkemih?
                                                (frekuensi, urgensi,
                                                inkontinensia, nokturia)</label>
                                            <select class="form-select" name="gizi_nrs_perubahan_berkemih"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke tempat tidur) -->
                                        <h6 class="mb-3">5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke
                                            tempat tidur)</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Mandiri (boleh menolak saat bantu jatuh)</label>
                                            <select class="form-select" name="gizi_nrs_transfer_mandiri"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="0">Ya</option>
                                                <option value="1">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Memerlukan sedikit bantuan (1 orang) / dalam
                                                pengawasan</label>
                                            <select class="form-select" name="gizi_nrs_transfer_bantuan_1_orang"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Memerlukan bantuan yang nyata (2 orang)</label>
                                            <select class="form-select" name="gizi_nrs_transfer_bantuan_2_orang"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tidak dapat duduk dengan seimbang, perlu bantuan
                                                total</label>
                                            <select class="form-select" name="gizi_nrs_transfer_bantuan_total"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 6. Mobilitas Pasien -->
                                        <h6 class="mb-3">6. Mobilitas Pasien</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Mandiri (dapat menggunakan alat bantu
                                                jalan)</label>
                                            <select class="form-select" name="gizi_nrs_mobilitas_mandiri"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="0">Ya</option>
                                                <option value="1">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">berjalan dengan bantuan 1 orang (verbal/
                                                fisik)</label>
                                            <select class="form-select" name="gizi_nrs_mobilitas_bantuan_1_orang"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Menggunakan kusi roda</label>
                                            <select class="form-select" name="gizi_nrs_mobilitas_kursi_roda"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Imobilisasi</label>
                                            <select class="form-select" name="gizi_nrs_mobilitas_imobilisasi"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Nilai -->
                                        <div id="nrsConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-success">Kesimpulan: Beresiko rendah</div>
                                            <div class="alert alert-warning">Kesimpulan: Beresiko sedang</div>
                                            <div class="alert alert-danger">Kesimpulan: Beresiko Tinggi</div>
                                            <input type="hidden" name="gizi_nrs_kesimpulan"
                                                id="gizi_nrs_kesimpulan">
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator" id="status-fungsional">
                                    <h5 class="section-title">13. Status Fungsional</h5>

                                    <div class="mb-4">
                                        <label class="form-label">Pilih jenis Skala Pengkajian Aktivitas Harian (ADL)
                                            sesuai kondisi pasien</label>
                                        <select class="form-select" name="skala_fungsional" id="skala_fungsional">
                                            <option value="" selected disabled>Pilih Skala Fungsional</option>
                                            <option value="Pengkajian Aktivitas">Pengkajian Aktivitas Harian</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nilai Skala ADL</label>
                                        <input type="text" class="form-control" id="adl_total"
                                            name="adl_total" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kesimpulan Fungsional</label>
                                        <div id="adl_kesimpulan" class="alert alert-info">
                                            Pilih skala aktivitas harian terlebih dahulu
                                        </div>
                                    </div>
                                    <!-- Hidden fields untuk menyimpan data ADL -->
                                    <input type="hidden" id="adl_jenis_skala" name="adl_jenis_skala"
                                        value="">
                                    <input type="hidden" id="adl_makan" name="adl_makan" value="">
                                    <input type="hidden" id="adl_makan_value" name="adl_makan_value"
                                        value="">
                                    <input type="hidden" id="adl_berjalan" name="adl_berjalan" value="">
                                    <input type="hidden" id="adl_berjalan_value" name="adl_berjalan_value"
                                        value="">
                                    <input type="hidden" id="adl_mandi" name="adl_mandi" value="">
                                    <input type="hidden" id="adl_mandi_value" name="adl_mandi_value"
                                        value="">
                                    <input type="hidden" id="adl_kesimpulan_value" name="adl_kesimpulan_value"
                                        value="">
                                </div>

                                <div class="section-separator" id="kebutuhan-edukasi">
                                    <h5 class="section-title">14. Status Kebutuhan Edukasi, Pendidikan dan Pengajaran
                                    </h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Gaya Bicara</label>
                                        <select class="form-select" name="gaya_bicara">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="normal">Normal</option>
                                            <option value="lambat">Lambat</option>
                                            <option value="cepat">Cepat</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Bahasa Sehari-Hari</label>
                                        <select class="form-select" name="bahasa_sehari_hari">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="Bahasa Indoneisa" selected>Bahasa Indonesia</option>
                                            <option value="Aceh">Aceh</option>
                                            <option value="Batak">Batak</option>
                                            <option value="Minangkabau">Minangkabau</option>
                                            <option value="Melayu">Melayu</option>
                                            <option value="Sunda">Sunda</option>
                                            <option value="Jawa">Jawa</option>
                                            <option value="Madura">Madura</option>
                                            <option value="Bali">Bali</option>
                                            <option value="Sasak">Sasak</option>
                                            <option value="Banjar">Banjar</option>
                                            <option value="Bugis">Bugis</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Perlu Penerjemah</label>
                                        <select class="form-select" name="perlu_penerjemah">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Hambatan Komunikasi</label>
                                        <select class="form-select" name="hambatan_komunikasi">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="tidak_ada">Tidak Ada</option>
                                            <option value="pendengaran">Gangguan Pendengaran</option>
                                            <option value="bicara">Gangguan Bicara</option>
                                            <option value="bahasa">Perbedaan Bahasa</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media Disukai</label>
                                        <select class="form-select" name="media_disukai">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="cetak">Media Cetak</option>
                                            <option value="video">Video</option>
                                            <option value="diskusi">Diskusi Langsung</option>
                                            <option value="demonstrasi">Demonstrasi</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pendidikan</label>
                                        <select class="form-select" name="tingkat_pendidikan">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="SD">SD</option>
                                            <option value="SMP">SMP</option>
                                            <option value="SMA">SMA</option>
                                            <option value="Diploma">Diploma</option>
                                            <option value="Sarjana">Sarjana</option>
                                            <option value="Tidak Sekolah">Tidak Sekolah</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="section-separator" id="discharge-planning">
                                    <h5 class="section-title">15. Discharge Planning</h5>

                                    {{-- <div class="mb-4">
                                        <label class="form-label">Diagnosis medis</label>
                                        <input type="text" class="form-control" name="diagnosis_medis"
                                            placeholder="Diagnosis">
                                    </div> --}}

                                    <div class="mb-4">
                                        <label class="form-label">Usia lanjut</label>
                                        <select class="form-select" name="usia_lanjut">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="0">Ya</option>
                                            <option value="1">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Hambatan mobilisasi</label>
                                        <select class="form-select" name="hambatan_mobilisasi">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="0">Ya</option>
                                            <option value="1">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Membutuhkan penggunaan media berkelanjutan</label>
                                        <select class="form-select" name="penggunaan_media_berkelanjutan">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Ketergantungan dengan orang lain dalam aktivitas
                                            harian</label>
                                        <select class="form-select" name="ketergantungan_aktivitas">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Pasien / Keluarga Memerlukan Keterampilan Khusus
                                            Setelah
                                            Pulang</label>
                                        <select class="form-select" name="keterampilan_khusus">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Pasien Memerlukan Alat Bantu Setelah Keluar Rumah
                                            Sakit</label>
                                        <select class="form-select" name="alat_bantu">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Pasien Memiliki Nyeri Kronis Dan / Kebiasaan Setelah
                                            Pulang</label>
                                        <select class="form-select" name="nyeri_kronis">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Perkiraan lama hari dirawat</label>
                                            <input type="text" class="form-control" name="perkiraan_hari"
                                                placeholder="hari">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Rencana Tanggal Pulang</label>
                                            <input type="date" class="form-control" name="tanggal_pulang">
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
                                            value="Tidak mebutuhkan rencana pulang khusus">
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
                                                            <input class="form-check-input rencana-perawatan-row-1" type="checkbox" name="diagnosis[]" value="bersihan_jalan_nafas" id="diag_bersihan_jalan_nafas">
                                                            <label class="form-check-label" for="diag_bersihan_jalan_nafas">
                                                                <strong>Bersihan jalan nafas tidak efektif</strong> berhubungan dengan spasme jalan nafas, hipersekresi jalan nafas,adanya benda asing pada jalan nafas, secret tertahan di saluran nafas, proses infeksi.
                                                            </label>
                                                        </div>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input rencana-perawatan-row-1" type="checkbox" name="diagnosis[]" value="risiko_aspirasi" id="diag_risiko_aspirasi">
                                                            <label class="form-check-label" for="diag_risiko_aspirasi">
                                                                <strong>Risiko aspirasi</strong>  berhubungan dengan tingkat kesadaran, penurunan reflek muntah dan/ atau batuk, gangguan menelan, terpasang slang nasogastrik, dan ketidak matangan koordinasi menghisap,menelan dan bernafas.
                                                            </label>
                                                        </div>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input rencana-perawatan-row-1" type="checkbox" name="diagnosis[]" value="pola_nafas_tidak_efektif" id="diag_pola_nafas_tidak_efektif">
                                                            <label class="form-check-label" for="diag_pola_nafas_tidak_efektif">
                                                                <strong>Pola nafas tidak efekti</strong>  berhubungan dengan depresi pusat pernafasan, hambatan upaya nafas, deformitas tulang dada, posisi tubuh yang menghambat ekspansi paru, kecemasan.
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="align-top">
                                                        <div id="rencana_bersihan_jalan_nafas" style="display: none;">
                                                            <strong>Observasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_pola_nafas">
                                                                <label class="form-check-label">Monitor pola nafas ( frekuensi , kedalaman, usaha nafas )</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_bunyi_nafas">
                                                                <label class="form-check-label">Monitor bunyi nafas tambahan ( mengi, wheezing, rhonchi )</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_sputum">
                                                                <label class="form-check-label">Monitor sputum ( jumlah, warna, aroma )</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_tingkat_kesadaran">
                                                                <label class="form-check-label">Monitor tingkat kesadaran, batuk, muntah dan kemampuan menelan</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="monitor_kemampuan_batuk">
                                                                <label class="form-check-label">Monitor kemampuan batuk efektif</label>
                                                            </div>

                                                            <strong>Terapeutik:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="pertahankan_kepatenan">
                                                                <label class="form-check-label">Pertahankan kepatenan jalan nafas dengan head-tilt dan chin -lift ( jaw – thrust jika curiga trauma servikal ) </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="posisikan_semi_fowler">
                                                                <label class="form-check-label">Posisikan semi fowler atau fowler</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="berikan_minum_hangat">
                                                                <label class="form-check-label">Berikan minum hangat</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="fisioterapi_dada">
                                                                <label class="form-check-label">Lakukan fisioterapi dada, jika perlu</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="keluarkan_benda_padat">
                                                                <label class="form-check-label">Keluarkan benda padat dengan forcep</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="penghisapan_lendir">
                                                                <label class="form-check-label">Lakukan penghisapan lendir</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="berikan_oksigen">
                                                                <label class="form-check-label">Berikan oksigen</label>
                                                            </div>

                                                            <strong>Edukasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="anjuran_asupan_cairan">
                                                                <label class="form-check-label">Anjuran asupan cairan 2000 ml/hari, jika tidak kontra indikasi</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="ajarkan_teknik_batuk">
                                                                <label class="form-check-label">Ajarkan teknik batuk efektif</label>
                                                            </div>

                                                            <strong>Kolaborasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]" value="kolaborasi_pemberian_obat">
                                                                <label class="form-check-label">Kolaborasi pemberian bronkodilator, ekspektoran, mukolitik, jika perlu</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- 2. Penurunan Curah Jantung -->
                                                <tr>
                                                    <td class="align-top">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="diagnosis[]" value="penurunan_curah_jantung" id="diag_penurunan_curah_jantung" onchange="toggleRencana('penurunan_curah_jantung')">
                                                            <label class="form-check-label" for="diag_penurunan_curah_jantung">
                                                                <strong>Penurunan curah jantung</strong> berhubungan dengan perubahan irama jantung, perubahan frekuensi jantung.
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="align-top">
                                                        <div id="rencana_penurunan_curah_jantung" style="display: none;">
                                                            <strong>Observasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="identifikasi_tanda_gejala">
                                                                <label class="form-check-label">Identifikasi tanda/gejala primer penurunan curah jantung (meliputi dipsnea, kelelahan, edema)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_tekanan_darah">
                                                                <label class="form-check-label">Monitor tekanan darah</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_intake_output">
                                                                <label class="form-check-label">Monitor intake dan output cairan</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_saturasi_oksigen">
                                                                <label class="form-check-label">Monitor saturasi oksigen</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_keluhan_nyeri">
                                                                <label class="form-check-label">Monitor keluhan nyeri dada (intensitas, lokasi, durasi, presivitasi yang mengurangi nyeri)</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="monitor_aritmia">
                                                                <label class="form-check-label">Monitor aritmia (kelainan irama dan frekuensi)</label>
                                                            </div>

                                                            <strong>Terapeutik:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="posisikan_pasien">
                                                                <label class="form-check-label">Posisikan pasien semi fowler atau fowler dengan kaki kebawah atau posisi nyaman</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="berikan_terapi_relaksasi">
                                                                <label class="form-check-label">Berikan therapi relaksasi untuk mengurangi stres, jika perlu</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="berikan_dukungan_emosional">
                                                                <label class="form-check-label">Berikan dukungan emosional dan spirital</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="berikan_oksigen_saturasi">
                                                                <label class="form-check-label">Berikan oksigen untuk mempertahankan saturasi oksigen >94%</label>
                                                            </div>

                                                            <strong>Edukasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="anjurkan_beraktifitas">
                                                                <label class="form-check-label">Anjurkan beraktifitas fisik sesuai toleransi</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="anjurkan_berhenti_merokok">
                                                                <label class="form-check-label">Anjurkan berhenti merokok</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="ajarkan_mengukur_intake">
                                                                <label class="form-check-label">Ajarkan pasien dan keluarga mengukur intake dan output cairan harian</label>
                                                            </div>

                                                            <strong>Kolaborasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_penurunan_curah_jantung[]" value="kolaborasi_pemberian_terapi">
                                                                <label class="form-check-label">Koborasi pemberian therapi</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- 3. Perfusi Perifer Tidak Efektif -->
                                                <tr>
                                                    <td class="align-top">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="diagnosis[]" value="perfusi_perifer" id="diag_perfusi_perifer" onchange="toggleRencana('perfusi_perifer')">
                                                            <label class="form-check-label" for="diag_perfusi_perifer">
                                                                <strong>Perfusi perifer tidak efektif</strong> berhubungan dengan hyperglikemia, penurunan konsentrasi hemoglobin, peningkatan tekanan darah, kekurangan volume cairan, penurunan aliran arteri dan/atau vena, kurang terpapar informasi tentang proses penyakit (misal: diabetes melitus, hiperlipidmia).
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="align-top">
                                                        <div id="rencana_perfusi_perifer" style="display: none;">
                                                            <strong>Observasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="periksa_sirkulasi">
                                                                <label class="form-check-label">Periksa sirkulasi perifer (edema, pengisian kapiler/CRT, suhu)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="identifikasi_faktor_risiko">
                                                                <label class="form-check-label">Identifikasi faktor risiko gangguan sirkulasi (diabetes, perokok, hipertensi, kadar kolesterol tinggi)</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="monitor_suhu_kemerahan">
                                                                <label class="form-check-label">Monitor suhu, kemerahan, nyeri atau bengkak pada ekstremitas.</label>
                                                            </div>

                                                            <strong>Terapeutik:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="hindari_pemasangan_infus">
                                                                <label class="form-check-label">Hindari pemasangan infus atau pengambilan darah di area keterbatasan perfusi</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="hindari_pengukuran_tekanan">
                                                                <label class="form-check-label">Hindari pengukuran tekanan darah pada ekstremitas dengan keterbatasan perfusi</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="hindari_penekanan">
                                                                <label class="form-check-label">Hindari penekanan dan pemasangan tourniqet pada area yang cedera</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="lakukan_pencegahan_infeksi">
                                                                <label class="form-check-label">Lakukan pencegahan infeksi</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="perawatan_kaki_kuku">
                                                                <label class="form-check-label">Lakukan perawatan kaki dan kuku</label>
                                                            </div>

                                                            <strong>Edukasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="anjurkan_berhenti_merokok_perfusi">
                                                                <label class="form-check-label">Anjurkan berhenti merokok</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="anjurkan_berolahraga">
                                                                <label class="form-check-label">Anjurkan berolahraga rutin</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="anjurkan_minum_obat">
                                                                <label class="form-check-label">Anjurkan minum obat pengontrol tekanan darah secara teratur</label>
                                                            </div>

                                                            <strong>Kolaborasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]" value="kolaborasi_terapi_perfusi">
                                                                <label class="form-check-label">Koborasi pemberian therapi</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- 4. Hipovolemia -->
                                                <tr>
                                                    <td class="align-top">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="diagnosis[]" value="hipovolemia" id="diag_hipovolemia" onchange="toggleRencana('hipovolemia')">
                                                            <label class="form-check-label" for="diag_hipovolemia">
                                                                <strong>Hipovolemia</strong> berhubungan dengan kehilangan cairan aktif, peningkatan permeabilitas kapiler, kekurangan intake cairan, evaporasi.
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="align-top">
                                                        <div id="rencana_hipovolemia" style="display: none;">
                                                            <strong>Observasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="periksa_tanda_gejala">
                                                                <label class="form-check-label">Periksa tanda dan gejala hipovolemia (frekuensi nadi meningkat, nadi teraba lemah, tekanan darah penurun, turgor kulit menurun, membran mukosa kering, volume urine menurun, haus, lemah)</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="monitor_intake_output_hipovolemia">
                                                                <label class="form-check-label">Monitor intake dan output cairan</label>
                                                            </div>

                                                            <strong>Terapeutik:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="berikan_asupan_cairan">
                                                                <label class="form-check-label">Berikan asupan cairan oral</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="posisi_trendelenburg">
                                                                <label class="form-check-label">Posisi modified trendelenburg</label>
                                                            </div>

                                                            <strong>Edukasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="anjurkan_memperbanyak_cairan">
                                                                <label class="form-check-label">Anjurkan memperbanyak asupan cairan oral</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="hindari_perubahan_posisi">
                                                                <label class="form-check-label">Anjurkan menghindari perubahan posisi mendadak</label>
                                                            </div>

                                                            <strong>Kolaborasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]" value="kolaborasi_terapi_hipovolemia">
                                                                <label class="form-check-label">Koborasi pemberian therapi</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- 5. Hipervolemia -->
                                                <tr>
                                                    <td class="align-top">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="diagnosis[]" value="hipervolemia" id="diag_hipervolemia" onchange="toggleRencana('hipervolemia')">
                                                            <label class="form-check-label" for="diag_hipervolemia">
                                                                <strong>Hipervolemia</strong> berhubungan dengan kelebihan asupan cairan, kelebihan asupan natrium, gangguan aliran balik vena.
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="align-top">
                                                        <div id="rencana_hipervolemia" style="display: none;">
                                                            <strong>Observasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="periksa_tanda_hipervolemia">
                                                                <label class="form-check-label">Periksa tanda dan gejala hipervolemia (dipsnea, edema, suara nafas tambahan)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="identifikasi_penyebab_hipervolemia">
                                                                <label class="form-check-label">Identifikasi penyebab hipervolemia</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="monitor_hemodinamik">
                                                                <label class="form-check-label">Monitor status hemodinamik (frekuensi jantung, tekanan darah)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="monitor_intake_output_hipervolemia">
                                                                <label class="form-check-label">Monitor intake dan output cairan</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="monitor_efek_diuretik">
                                                                <label class="form-check-label">Monitor efek samping diuretik (hipotensi ortostatik, hipovolemia, hipokalemia, hiponatremia)</label>
                                                            </div>

                                                            <strong>Terapeutik:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="timbang_berat_badan">
                                                                <label class="form-check-label">Timbang berat badan setiap hari pada waktu yang sama</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="batasi_asupan_cairan">
                                                                <label class="form-check-label">Batasi asupan cairan dan garam</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="tinggi_kepala_tempat_tidur">
                                                                <label class="form-check-label">Tinggi kepala tempat tidur 30 – 40 º</label>
                                                            </div>

                                                            <strong>Edukasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="ajarkan_mengukur_cairan">
                                                                <label class="form-check-label">Ajarkan cara mengukur dan mencatat asupan dan haluaran cairan</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="ajarkan_membatasi_cairan">
                                                                <label class="form-check-label">Ajarkan cara membatasi cairan</label>
                                                            </div>

                                                            <strong>Kolaborasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]" value="kolaborasi_terapi_hipervolemia">
                                                                <label class="form-check-label">Koborasi pemberian therapi</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- 6. Diare -->
                                                <tr>
                                                    <td class="align-top">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="diagnosis[]" value="diare" id="diag_diare" onchange="toggleRencana('diare')">
                                                            <label class="form-check-label" for="diag_diare">
                                                                <strong>Diare</strong> berhubungan dengan inflamasi gastrointestinal, iritasi gastrointestinal, proses infeksi, malabsorpsi.
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="align-top">
                                                        <div id="rencana_diare" style="display: none;">
                                                            <strong>Observasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="identifikasi_penyebab_diare">
                                                                <label class="form-check-label">Identifikasi penyebab diare (inflamasi gastrointestinal, iritasi gastrointestinal, proses infeksi, malabsorpsi, ansietas, stres, efek samping obat)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="identifikasi_riwayat_makanan">
                                                                <label class="form-check-label">Identifikasi riwayat pemberian makanan</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="identifikasi_gejala_invaginasi">
                                                                <label class="form-check-label">Identifikasi riwayat gejala invaginasi (tangisan keras, kepucatan pada bayi)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="monitor_warna_volume_tinja">
                                                                <label class="form-check-label">Monitor warna, volume, frekuensi dan konsistensi tinja</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="monitor_tanda_hipovolemia">
                                                                <label class="form-check-label">Monitor tanda dan gejala hipovolemia (takikardi, nadi teraba lemah, tekanan darah turun, turgor kulit turun, mukosa mulit kering, CRT melambat, BB menurun)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="monitor_iritasi_kulit">
                                                                <label class="form-check-label">Monitor iritasi dan ulserasi kulit di daerah perianal</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="monitor_jumlah_diare">
                                                                <label class="form-check-label">Monitor jumlah pengeluaran diare</label>
                                                            </div>

                                                            <strong>Terapeutik:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="berikan_asupan_cairan_oral">
                                                                <label class="form-check-label">Berikan asupan cairan oral (larutan garam gula, oralit, pedialyte)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="pasang_jalur_intravena">
                                                                <label class="form-check-label">Pasang jalur intravena</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="berikan_cairan_intravena">
                                                                <label class="form-check-label">Berikan cairan intravena</label>
                                                            </div>

                                                            <strong>Edukasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="anjurkan_makanan_porsi_kecil">
                                                                <label class="form-check-label">Anjurkan makanan porsi kecil dan sering secara bertahap</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="hindari_makanan_gas">
                                                                <label class="form-check-label">Anjurkan menghindari makanan pembentuk gas, pedas dan mengandung laktosa</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="lanjutkan_asi">
                                                                <label class="form-check-label">Anjurkan melanjutkan pemberian ASI</label>
                                                            </div>

                                                            <strong>Kolaborasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_diare[]" value="kolaborasi_terapi_diare">
                                                                <label class="form-check-label">Koborasi pemberian therapi</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- 7. Retensi Urine -->
                                                <tr>
                                                    <td class="align-top">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="diagnosis[]" value="retensi_urine" id="diag_retensi_urine" onchange="toggleRencana('retensi_urine')">
                                                            <label class="form-check-label" for="diag_retensi_urine">
                                                                <strong>Retensi urine</strong> berhubungan dengan peningkatan tekanan uretra, kerusakan arkus refleks, Blok spingter, disfungsi neurologis (trauma, penyakit saraf), efek agen farmakologis (atropine, belladona, psikotropik, antihistamin, opiate).
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="align-top">
                                                        <div id="rencana_retensi_urine" style="display: none;">
                                                            <strong>Observasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="identifikasi_tanda_retensi">
                                                                <label class="form-check-label">Identifikasi tanda dan gejala retensi atau inkontinensia urine</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="identifikasi_faktor_penyebab">
                                                                <label class="form-check-label">Identifikasi faktor yang menyebabkan retensi atau inkontinensia urine</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="monitor_eliminasi_urine">
                                                                <label class="form-check-label">Monitor eliminasi urine (frekuensi, konsistensi, aroma, volume dan warna)</label>
                                                            </div>

                                                            <strong>Terapeutik:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="catat_waktu_berkemih">
                                                                <label class="form-check-label">Catat waktu-waktu dan haluaran berkemih</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="batasi_asupan_cairan">
                                                                <label class="form-check-label">Batasi asupan cairan, jika perlu</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ambil_sampel_urine">
                                                                <label class="form-check-label">Ambil sampel urine tengah (midstream) atau kultur</label>
                                                            </div>

                                                            <strong>Edukasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_tanda_infeksi">
                                                                <label class="form-check-label">Ajarkan tanda dan gejala infeksi saluran kemih</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_mengukur_asupan">
                                                                <label class="form-check-label">Ajarkan mengukur asupan cairan dan haluaran urine</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_spesimen_midstream">
                                                                <label class="form-check-label">Ajarkan mengambil spesimen urine midstream</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_tanda_berkemih">
                                                                <label class="form-check-label">Ajarkan mengenali tanda berkemih dan waktu yang tepat untuk berkemih</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="ajarkan_minum_cukup">
                                                                <label class="form-check-label">Ajarkan minum yang cukup, jika tidak ada kontraindikasi</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="kurangi_minum_tidur">
                                                                <label class="form-check-label">Anjurkan mengurangi minum menjelang tidur</label>
                                                            </div>

                                                            <strong>Kolaborasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]" value="kolaborasi_supositoria">
                                                                <label class="form-check-label">Kolaborasi pemberian obat supositoria uretra, jika perlu</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- 8. Nyeri Akut -->
                                                <tr>
                                                    <td class="align-top">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="diagnosis[]" value="nyeri_akut" id="diag_nyeri_akut" onchange="toggleRencana('nyeri_akut')">
                                                            <label class="form-check-label" for="diag_nyeri_akut">
                                                                <strong>Nyeri akut</strong> b.d agen pencedera fisiologis (inflamsi, iskemia, neoplasma), agen pencedera kimiawi (terbakar, bahan kimia iritan), agen pencedera fisik (abses, amputasi, terbakar, terpotong, mengangkat berat, prosedur operasi, trauma, latihan fisik berlebihan).
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="align-top">
                                                        <div id="rencana_nyeri_akut" style="display: none;">
                                                            <strong>Observasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_lokasi_nyeri">
                                                                <label class="form-check-label">Identifikasi lokasi, karakteristik, durasi, frekuensi, kualitas, intensitas nyeri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_skala_nyeri">
                                                                <label class="form-check-label">Identifikasi skala nyeri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_respons_nonverbal">
                                                                <label class="form-check-label">Identifikasi respons nyeri non verbal</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_faktor_nyeri">
                                                                <label class="form-check-label">Identifikasi faktor yang memperberat dan memperingan nyeri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_pengetahuan_nyeri">
                                                                <label class="form-check-label">Identifikasi pengetahuan dan keyaninan tentang nyeri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_pengaruh_budaya">
                                                                <label class="form-check-label">Identifikasi pengaruh budaya terhadap respon nyeri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="identifikasi_pengaruh_kualitas_hidup">
                                                                <label class="form-check-label">Identifikasi pengaruh nyeri pada kualitas hidup</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="monitor_keberhasilan_terapi">
                                                                <label class="form-check-label">Monitor keberhasilan terapi komplementer yang sudah diberikan</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="monitor_efek_samping_analgetik">
                                                                <label class="form-check-label">Monitor efek samping penggunaan analgetil</label>
                                                            </div>

                                                            <strong>Terapeutik:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="berikan_teknik_nonfarmakologis">
                                                                <label class="form-check-label">Berikan teknik nonfarmakologis untuk mengurangi rasa nyeri (TENS, hipnosis, akupresur, terapi musik, biofeedback, terapi pijat, aromaterapi, teknik imajinasi terbimbing, kompres hangat/dingin, terapi bermain)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="kontrol_lingkungan_nyeri">
                                                                <label class="form-check-label">Kontrol lingkungan yang memperberat rasa nyeri (suhu ruangan, pencahayaan, kebisingan)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="fasilitasi_istirahat">
                                                                <label class="form-check-label">Fasilitasi istirahat dan tidur</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="pertimbangkan_strategi_nyeri">
                                                                <label class="form-check-label">Pertimbangkan jenis dan sumber nyeri dalam pemilihan strategi meredakan nyeri</label>
                                                            </div>

                                                            <strong>Edukasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="jelaskan_penyebab_nyeri">
                                                                <label class="form-check-label">Jelaskan penyebab, periode, dan pemicu nyeri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="jelaskan_strategi_nyeri">
                                                                <label class="form-check-label">Jelaskan strategi meredakan nyeri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="anjurkan_monitor_nyeri">
                                                                <label class="form-check-label">Anjurkan memonitor nyeri secara mandiri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="anjurkan_analgetik">
                                                                <label class="form-check-label">Anjurkan menggunakan analgetik secara tepat</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="ajarkan_teknik_nonfarmakologis">
                                                                <label class="form-check-label">Ajarkan teknik nonfarmakologis untuk mengurangin rasa nyeri</label>
                                                            </div>

                                                            <strong>Kolaborasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]" value="kolaborasi_analgetik">
                                                                <label class="form-check-label">Kolaborasi pemberian analgetik, jika perlu</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- 9. Nyeri Kronis -->
                                                <tr>
                                                    <td class="align-top">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="diagnosis[]" value="nyeri_kronis" id="diag_nyeri_kronis" onchange="toggleRencana('nyeri_kronis')">
                                                            <label class="form-check-label" for="diag_nyeri_kronis">
                                                                <strong>Nyeri kronis</strong> b.d kondisi muskuloskeletal kronis, kerusakan sistem saraf, penekanan saraf, infiltrasi tumor, ketidakseimbangan neurotransmiter, neuromodulator, dan reseptor, gangguan imunitas, (neuropati terkait HIV, virus varicella-zoster), gangguan fungsi metabolik, riwayat posisi kerja statis, peningkatan indeks masa tubuh, kondisi pasca trauma, tekanan emosional, riwayat penganiayaan (fisik, psikologis, seksual), riwayat penyalahgunaan obat/zat.
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="align-top">
                                                        <div id="rencana_nyeri_kronis" style="display: none;">
                                                            <strong>Observasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_lokasi_nyeri_kronis">
                                                                <label class="form-check-label">Identifikasi lokasi, karakteristik, durasi, frekuensi, kualitas, intensitas nyeri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_skala_nyeri_kronis">
                                                                <label class="form-check-label">Identifikasi skala nyeri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_respons_nonverbal_kronis">
                                                                <label class="form-check-label">Identifikasi respons nyeri non verbal</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_faktor_nyeri_kronis">
                                                                <label class="form-check-label">Identifikasi faktor yang memperberat dan memperingan nyeri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_pengetahuan_nyeri_kronis">
                                                                <label class="form-check-label">Identifikasi pengetahuan dan keyaninan tentang nyeri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_pengaruh_budaya_kronis">
                                                                <label class="form-check-label">Identifikasi pengaruh budaya terhadap respon nyeri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="identifikasi_pengaruh_kualitas_hidup_kronis">
                                                                <label class="form-check-label">Identifikasi pengaruh nyeri pada kualitas hidup</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="monitor_keberhasilan_terapi_kronis">
                                                                <label class="form-check-label">Monitor keberhasilan terapi komplementer yang sudah diberikan</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="monitor_efek_samping_analgetik_kronis">
                                                                <label class="form-check-label">Monitor efek samping penggunaan analgetil</label>
                                                            </div>

                                                            <strong>Terapeutik:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="berikan_teknik_nonfarmakologis_kronis">
                                                                <label class="form-check-label">Berikan teknik nonfarmakologis untuk mengurangi rasa nyeri (TENS, hipnosis, akupresur, terapi musik, biofeedback, terapi pijat, aromaterapi, teknik imajinasi terbimbing, kompres hangat/dingin, terapi bermain)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="kontrol_lingkungan_nyeri_kronis">
                                                                <label class="form-check-label">Kontrol lingkungan yang memperberat rasa nyeri (suhu ruangan, pencahayaan, kebisingan)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="fasilitasi_istirahat_kronis">
                                                                <label class="form-check-label">Fasilitasi istirahat dan tidur</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="pertimbangkan_strategi_nyeri_kronis">
                                                                <label class="form-check-label">Pertimbangkan jenis dan sumber nyeri dalam pemilihan strategi meredakan nyeri</label>
                                                            </div>

                                                            <strong>Edukasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="jelaskan_penyebab_nyeri_kronis">
                                                                <label class="form-check-label">Jelaskan penyebab, periode, dan pemicu nyeri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="jelaskan_strategi_nyeri_kronis">
                                                                <label class="form-check-label">Jelaskan strategi meredakan nyeri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="anjurkan_monitor_nyeri_kronis">
                                                                <label class="form-check-label">Anjurkan memonitor nyeri secara mandiri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="anjurkan_analgetik_kronis">
                                                                <label class="form-check-label">Anjurkan menggunakan analgetik secara tepat</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="ajarkan_teknik_nonfarmakologis_kronis">
                                                                <label class="form-check-label">Ajarkan teknik nonfarmakologis untuk mengurangin rasa nyeri</label>
                                                            </div>

                                                            <strong>Kolaborasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]" value="kolaborasi_analgetik_kronis">
                                                                <label class="form-check-label">Kolaborasi pemberian analgetik, jika perlu</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- 10. Hipertermia -->
                                                <tr>
                                                    <td class="align-top">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="diagnosis[]" value="hipertermia" id="diag_hipertermia" onchange="toggleRencana('hipertermia')">
                                                            <label class="form-check-label" for="diag_hipertermia">
                                                                <strong>Hipertermia</strong> b.d dehidrasi, terpapar lingkungan panas, peroses penyakit (infeksi, kanker), ketidaksesuaian pakaian dengan suhu lingkungan, peningkatan laju metabolisme, respon trauma, aktivitas berlebihan, penggunaan inkubator.
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="align-top">
                                                        <div id="rencana_hipertermia" style="display: none;">
                                                            <strong>Observasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="identifikasi_penyebab_hipertermia">
                                                                <label class="form-check-label">Identifikasi penyebab hipertermia (dehidrasi, terpapar lingkungan panas, penggunaan inkubator)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="monitor_suhu_tubuh">
                                                                <label class="form-check-label">Monitor suhu tubuh</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="monitor_kadar_elektrolit">
                                                                <label class="form-check-label">Monitor kadar elektrolit</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="monitor_haluaran_urine">
                                                                <label class="form-check-label">Monitor haluaran urine</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="monitor_komplikasi_hipertermia">
                                                                <label class="form-check-label">Monitor komplikasi akibat hipertermia</label>
                                                            </div>

                                                            <strong>Terapeutik:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="sediakan_lingkungan_dingin">
                                                                <label class="form-check-label">Sediakan lingkungan yang dingin</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="longgarkan_pakaian">
                                                                <label class="form-check-label">Longgarkan atau lepaskan pakaian</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="basahi_kipasi_tubuh">
                                                                <label class="form-check-label">Basahi dan kipasi permukaan tubuh</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="berikan_cairan_oral_hipertermia">
                                                                <label class="form-check-label">Berikan cairan oral</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="ganti_linen_hiperhidrosis">
                                                                <label class="form-check-label">Ganti linen setiap hari atau lebih sering jika mengalami hiperhidrosis (keringat berlebih)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="pendinginan_eksternal">
                                                                <label class="form-check-label">Lakukan pendinginan eksternal (selimut hipotermia atau kompres dingin pada dahi, leher, dada, abdomen, aksila)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="hindari_antipiretik">
                                                                <label class="form-check-label">Hindari pemberian antipiretik atau aspirin</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="berikan_oksigen_hipertermia">
                                                                <label class="form-check-label">Berikan oksigen, jika perlu</label>
                                                            </div>

                                                            <strong>Edukasi:</strong>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="anjurkan_tirah_baring">
                                                                <label class="form-check-label">Anjurkan tirah baring</label>
                                                            </div>

                                                            <strong>Kolaborasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]" value="kolaborasi_cairan_elektrolit">
                                                                <label class="form-check-label">Kolaborasi pemberian cairan dan elektrolit intravena, jika perlu</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- 11. Gangguan Mobilitas Fisik -->
                                                <tr>
                                                    <td class="align-top">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="diagnosis[]" value="gangguan_mobilitas_fisik" id="diag_gangguan_mobilitas_fisik" onchange="toggleRencana('gangguan_mobilitas_fisik')">
                                                            <label class="form-check-label" for="diag_gangguan_mobilitas_fisik">
                                                                <strong>Gangguan mobilitas fisik</strong> b.d kerusakan intergritas struktur tulang, perubahan metabolisme, ketidakbugaran fisik, penurunan kendali otot, penurunan massa otot, penurunan kekuatan otot, keterlambatan perkembangan, kekakuan sendi, kontraktur, malnutrisi, gangguan muskuloskeletal, gangguan neuromuskular, indeks masa tubuh diatas persentil ke-75 seusai usia, efek agen farmakologis, program pembatasan gerak, nyeri, kurang terpapar informasi tentang aktivitas fisik, kecemasan, gangguan kognitif, keengganan melakukan pergerakan, gangguan sensoripersepsi.
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="align-top">
                                                        <div id="rencana_gangguan_mobilitas_fisik" style="display: none;">
                                                            <strong>Observasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="identifikasi_nyeri_keluhan">
                                                                <label class="form-check-label">Indentifikasi adanya nyeri atau keluhan fisik lainnya</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="identifikasi_toleransi_ambulasi">
                                                                <label class="form-check-label">Indetifikasi toleransi fisik melakukan ambulasi</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="monitor_frekuensi_jantung_ambulasi">
                                                                <label class="form-check-label">Monitor frekuensi jantung dan tekanan darah sebelum memulai ambulasi</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="monitor_kondisi_umum_ambulasi">
                                                                <label class="form-check-label">Monitor kondiri umum selama melakukan ambulasi</label>
                                                            </div>

                                                            <strong>Terapeutik:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="fasilitasi_aktivitas_ambulasi">
                                                                <label class="form-check-label">Fasilitasi aktivitas ambulasi dengan alat bantu (tongkat, kruk)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="fasilitasi_mobilisasi_fisik">
                                                                <label class="form-check-label">Fasilitasi melakukan mobilisasi fisik, jika perlu</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="libatkan_keluarga_ambulasi">
                                                                <label class="form-check-label">Libatkan keluarga untuk membantu pasien dalam meningkatkan ambulasi</label>
                                                            </div>

                                                            <strong>Edukasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="jelaskan_tujuan_ambulasi">
                                                                <label class="form-check-label">Jelaskan tujuan dan prosedur ambulasi</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="anjurkan_ambulasi_dini">
                                                                <label class="form-check-label">Anjurkan melakukan ambulasi dini</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_mobilitas_fisik[]" value="ajarkan_ambulasi_sederhana">
                                                                <label class="form-check-label">Ajarkan ambulasi sederhana yang harus dilakukan (berjalan dari tempat tidur ke kursi roda, berjalan dari tempat tidur ke kamar mandi, berjalan sesuai toleransi)</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- 12. Resiko Infeksi -->
                                                <tr>
                                                    <td class="align-top">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="diagnosis[]" value="resiko_infeksi" id="diag_resiko_infeksi" onchange="toggleRencana('resiko_infeksi')">
                                                            <label class="form-check-label" for="diag_resiko_infeksi">
                                                                <strong>Resiko infeksi</strong> b.d efek prosedur invasif, penyakit kronis (diabetes melitus), malnutrisi, peningkatan paparan organisme patogen lingkungan, ketidakadekuatan pertahanan tubuh primer (gangguan persitaltik, kerusakan integritas kulit, perubahan sekresi PH, penurunan kerja siliaris, ketuban pecah lama, ketuban pecah sebelum waktunya, merokok, statis cairan tubuh), ketidakadekuatan pertahanan tubuh sekunder (penurunan hemoglobin, imununosupresi, leukopenia, supresi respon inflamasi, vaksinasi tidak adekuat).
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="align-top">
                                                        <div id="rencana_resiko_infeksi" style="display: none;">
                                                            <strong>Observasi:</strong>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="monitor_tanda_infeksi_sistemik">
                                                                <label class="form-check-label">Monitor tanda dan gejala infeksi lokal dan sistemik</label>
                                                            </div>

                                                            <strong>Terapeutik:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="batasi_pengunjung">
                                                                <label class="form-check-label">Batasi jumlah pengunjung</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="perawatan_kulit_edema">
                                                                <label class="form-check-label">Berikan perawatan kulit pada area edema</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="cuci_tangan_kontak">
                                                                <label class="form-check-label">Cuci tangan sebelum dan sesudah kontak dengan pasien dan lingkungan pasien</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="pertahankan_teknik_aseptik">
                                                                <label class="form-check-label">Pertahankan teknik aseptik pada pasien beresiko tinggi</label>
                                                            </div>

                                                            <strong>Edukasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="jelaskan_tanda_infeksi_edukasi">
                                                                <label class="form-check-label">Jelaskan tanda dan gejala infeksi</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="ajarkan_cuci_tangan">
                                                                <label class="form-check-label">Ajarkan cara mencuci tangan dengan benar</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="ajarkan_etika_batuk">
                                                                <label class="form-check-label">Ajarkan etika batuk</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="ajarkan_periksa_luka">
                                                                <label class="form-check-label">Ajarkan cara memeriksa kondisi luka atau luka operasi</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="anjurkan_asupan_nutrisi">
                                                                <label class="form-check-label">Anjurkan meningkatkan asupan nutrisi</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="anjurkan_asupan_cairan_infeksi">
                                                                <label class="form-check-label">Anjurkan meningkatkan asupan cairan</label>
                                                            </div>

                                                            <strong>Kolaborasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]" value="kolaborasi_imunisasi">
                                                                <label class="form-check-label">Kolaborasi pemberian imunisasi, jika perlu.</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- 13. Konstipasi -->
                                                <tr>
                                                    <td class="align-top">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="diagnosis[]" value="konstipasi" id="diag_konstipasi" onchange="toggleRencana('konstipasi')">
                                                            <label class="form-check-label" for="diag_konstipasi">
                                                                <strong>Konstipasi</strong> b.d penurunan motilitas gastrointestinal, ketidaadekuatan pertumbuhan gigi, ketidakcukupan diet, ketidakcukupan asupan serat, ketidakcukupan asupan serat, ketidakcukupan asupan cairan, aganglionik (penyakit Hircsprung), kelemahan otot abdomen.
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="align-top">
                                                        <div id="rencana_konstipasi" style="display: none;">
                                                            <strong>Observasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="periksa_tanda_gejala_konstipasi">
                                                                <label class="form-check-label">Periksa tanda dan gejala</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="periksa_pergerakan_usus">
                                                                <label class="form-check-label">Periksa pergerakan usus, karakteristik feses</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="identifikasi_faktor_risiko_konstipasi">
                                                                <label class="form-check-label">Identifikasi faktor risiko konstipasi</label>
                                                            </div>

                                                            <strong>Terapeutik:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="anjurkan_diet_tinggi_serat">
                                                                <label class="form-check-label">Anjurkan diet tinggi serat</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="masase_abdomen">
                                                                <label class="form-check-label">Lakukan masase abdomen, jika perlu</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="evakuasi_feses_manual">
                                                                <label class="form-check-label">Lakukan evakuasi feses secara manual, jika perlu</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="berikan_enema">
                                                                <label class="form-check-label">Berikan enema atau intigasi, jika perlu</label>
                                                            </div>

                                                            <strong>Edukasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="jelaskan_etiologi_konstipasi">
                                                                <label class="form-check-label">Jelaskan etiologi masalah dan alasan tindakan</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="anjurkan_peningkatan_cairan_konstipasi">
                                                                <label class="form-check-label">Anjurkan peningkatan asupan cairan, jika tidak ada kontraindikasi</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="ajarkan_mengatasi_konstipasi">
                                                                <label class="form-check-label">Ajarkan cara mengatasi konstipasi/impaksi</label>
                                                            </div>

                                                            <strong>Kolaborasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]" value="kolaborasi_obat_pencahar">
                                                                <label class="form-check-label">Kolaborasi penggunaan obat pencahar, jika perlu</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- 14. Resiko Jatuh -->
                                                <tr>
                                                    <td class="align-top">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="diagnosis[]" value="resiko_jatuh" id="diag_resiko_jatuh" onchange="toggleRencana('resiko_jatuh')">
                                                            <label class="form-check-label" for="diag_resiko_jatuh">
                                                                <strong>Resiko jatuh</strong> b.d usia lebih dari sama dengan 65 tahun (pada dewasa) atau kurang dari sama dengan 2 tahun (pada anak) Riwayat jatuh, anggota gerak bawah prostesis (buatan), penggunaan alat bantu berjalan, penurunan tingkat kesadaran, perubahan fungsi kognitif, lingkungan tidak aman (licin, gelap, lingkungan asing), kondisi pasca operasi, hipotensi ortostatik, perubahan kadar glukosa darah, anemia, kekuatan otot menurun, gangguan pendengaran, gangguan keseimbangan, gangguan penglihatan (glaukoma, katarak, ablasio retina, neuritis optikus), neuropati, efek agen farmakologis (sedasi, alkohol, anastesi umum).
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="align-top">
                                                        <div id="rencana_resiko_jatuh" style="display: none;">
                                                            <strong>Observasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="identifikasi_faktor_risiko_jatuh">
                                                                <label class="form-check-label">Identifikasi faktor risiko jatuh (usia >65 tahun, penurunan tingkat kesadaran, defisit kognitif, hipotensi ortostatik, gangguan keseimbangan, gangguan penglihatan, neuropati)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="identifikasi_risiko_setiap_shift">
                                                                <label class="form-check-label">Identifikasi risiko jatuh setidaknya sekali setiap shift atau sesuai dengan kebijakan institusi</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="identifikasi_faktor_lingkungan">
                                                                <label class="form-check-label">Identifikasi faktor lingkungan yang meningkatkan risiko jatuh (lantai licin, penerangan kurang)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="hitung_risiko_jatuh">
                                                                <label class="form-check-label">Hitung risiko jatuh dengan menggunakan skala (Fall Morse Scale, humpty dumpty scale), jika perlu</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="monitor_kemampuan_berpindah">
                                                                <label class="form-check-label">Monitor kemampuan berpindah dari tempat tidur ke kursi roda dan sebaliknya</label>
                                                            </div>

                                                            <strong>Terapeutik:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="orientasikan_ruangan">
                                                                <label class="form-check-label">Orientasikan ruangan pada pasien dan keluarga</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="pastikan_roda_terkunci">
                                                                <label class="form-check-label">Pastikan roda tempat tidur dan kursi roda selalu dalam kondisi terkunci</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="pasang_handrail">
                                                                <label class="form-check-label">Pasang handrail tempat tidur</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="atur_tempat_tidur">
                                                                <label class="form-check-label">Atur tempat tidur mekanis pada posisi terendah</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="tempatkan_dekat_perawat">
                                                                <label class="form-check-label">Tempatkan pasien berisiko tinggi jatuh dekat dengan pantauan perawat dari nurse station</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="gunakan_alat_bantu">
                                                                <label class="form-check-label">Gunakan alat bantu berjalan (kursi roda, walker)</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="dekatkan_bel">
                                                                <label class="form-check-label">Dekatkan bel pemanggil dalam jangkauan pasien</label>
                                                            </div>

                                                            <strong>Edukasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="anjurkan_memanggil_perawat">
                                                                <label class="form-check-label">Anjurkan memanggil perawat jika membutuhkan bantuan untuk berpindah</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="anjurkan_alas_kaki">
                                                                <label class="form-check-label">Anjurkan menggunakan alas kaki yang tidak licin</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="anjurkan_berkonsentrasi">
                                                                <label class="form-check-label">Anjurkan berkonsentrasi untuk menjaga keseimbangan tubuh</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="anjurkan_melebarkan_jarak">
                                                                <label class="form-check-label">Anjurkan melebarkan jarak kedua kaki untuk meningkatkan keseimbangan saat berdiri</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]" value="ajarkan_bel_pemanggil">
                                                                <label class="form-check-label">Ajarkan cara menggunakan bel pemanggil untuk memanggil perawat</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- 15. Gangguan Integritas Kulit/Jaringan -->
                                                <tr>
                                                    <td class="align-top">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="diagnosis[]" value="gangguan_integritas_kulit" id="diag_gangguan_integritas_kulit" onchange="toggleRencana('gangguan_integritas_kulit')">
                                                            <label class="form-check-label" for="diag_gangguan_integritas_kulit">
                                                                <strong>Gangguan integritas kulit/jaringan</strong> b.d perubahan sirkulasi, perubahan status nutrisi (kelebihan atau kekurangan), kekurangan/kelebihan volume cairan, penurunan mobilitas, bahan kimia iritatif, suhu lingkungan yang ekstream, faktor mekanis (penekanan pada tonjolan tulang, gesekan) atau faktor elektris (elektrodiatermi, energi listrik bertegangan tinggi), efek samping terapi radiasi, kelembapan, proses penuaan, neuropati perifer, perubahan pigmentasi, perubahan hormonal, kurang terpapar informasi tentang upaya mempertahankan/melindungi integritas jaringan.
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="align-top">
                                                        <div id="rencana_gangguan_integritas_kulit" style="display: none;">
                                                            <strong>Observasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="monitor_karakteristik_luka">
                                                                <label class="form-check-label">Monitor karakteristik luka</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="monitor_tanda_infeksi">
                                                                <label class="form-check-label">Monitor tanda-tanda infeksi</label>
                                                            </div>

                                                            <strong>Terapeutik:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="lepaskan_balutan">
                                                                <label class="form-check-label">Lepaskan balutan dan plester secara perlahan</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="bersihkan_nacl">
                                                                <label class="form-check-label">Bersihkan dengan cairan NaCl atau pembersih nontoksik</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="bersihkan_jaringan_nekrotik">
                                                                <label class="form-check-label">Bersihkan jaringan nekrotik</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="berikan_salep">
                                                                <label class="form-check-label">Berikan salep yang sesuai ke kulit/lesi, jika perlu</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="pasang_balutan">
                                                                <label class="form-check-label">Pasang balutan sesuai jenis luka</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="pertahankan_teknik_steril">
                                                                <label class="form-check-label">Pertahankan teknik steril saat melakukan perawatan luka</label>
                                                            </div>

                                                            <strong>Edukasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="jelaskan_tanda_infeksi">
                                                                <label class="form-check-label">Jelaskan tanda dan gejala infeksi</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="anjurkan_makanan_tinggi_protein">
                                                                <label class="form-check-label">Anjurkan mengkonsumsi makanan tinggi kalori dan protein</label>
                                                            </div>

                                                            <strong>Kolaborasi:</strong>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="kolaborasi_debridement">
                                                                <label class="form-check-label">Kolaborasi prosedur debridement</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="rencana_gangguan_integritas_kulit[]" value="kolaborasi_antibiotik">
                                                                <label class="form-check-label">Kolaborasi pemberian antibiotik</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                        </div>

                        @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-create-alergi')
                        @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-skalanyeri')
                        @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-penyakitdiderita')
                        @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-jenisoperasi')
                        @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-riwayatkeluarga')
                        @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-intervensirisikojatuh')
                        @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-skala-adl')

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

                        <div class="text-end">
                            <x-button-submit />
                        </div>

                    </form>
            </x-content-card>
        </div>
    </div>
@endsection
