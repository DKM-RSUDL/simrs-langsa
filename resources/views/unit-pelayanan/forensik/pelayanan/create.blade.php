@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .header-background {
                height: 100%;
                background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
            }
        </style>
    @endpush

    @include('unit-pelayanan.forensik.pelayanan.include')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Pemeriksaan</label>
                                        <input type="date" name="tgl_forensik_klinik" id="tgl_forensik_klinik"
                                            class="form-control" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="time" name="jam_forensik_klinik" id="jam_forensik_klinik"
                                            class="form-control" value="{{ date('H:i') }}">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="progress-wrapper">
                                        <div class="progress-status">
                                            <span class="progress-label">Progress Pengisian</span>
                                            <span class="progress-percentage">60%</span>
                                        </div>
                                        <div class="custom-progress">
                                            <div class="progress-bar-custom" style="width: 60%"></div>
                                        </div>
                                        <div class="mt-2">
                                            <small class="text-muted">6/10 bagian telah diisi</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="header-asesmen">Pemeriksaan Forensik Klinik</h4>
                            <p>
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sed reiciendis minus odio
                                cupiditate repellat, voluptatum assumenda recusandae veritatis molestiae non incidunt eius,
                                delectus ab. Minus impedit velit culpa et nobis.
                            </p>
                        </div>

                        {{-- FORM ASESMEN AWAL KEPERATAWAN --}}

                        <div class="px-3">
                            <div>
                                <div class="section-separator">
                                    <h5 class="section-title">1. Identitas Pasien/Korban/Jenazah</h5>
                                    <!-- Cara Datang -->
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Cara Datang</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="sendiri"
                                                    name="cara_datang[]" value="sendiri">
                                                <label class="form-check-label" for="sendiri">Sendiri</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="diantar_keluarga"
                                                    name="cara_datang[]" value="diantar_keluarga">
                                                <label class="form-check-label" for="diantar_keluarga">Diantar
                                                    keluarga</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="ambulance"
                                                    name="cara_datang[]" value="ambulance">
                                                <label class="form-check-label" for="ambulance">Ambulance</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="polisi"
                                                    name="cara_datang[]" value="polisi">
                                                <label class="form-check-label" for="polisi">Polisi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="pmi"
                                                    name="cara_datang[]" value="pmi">
                                                <label class="form-check-label" for="pmi">PMI</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="lainnya"
                                                    name="cara_datang[]" value="lainnya">
                                                <label class="form-check-label" for="lainnya">Lainnya</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Asal Rujukan -->
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Asal Rujukan</label>
                                        <input type="text" name="asal_rujukan" id="asal_rujukan" class="form-control">
                                    </div>


                                    <!-- Jenis Kasus -->
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Jenis Kasus</label>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="laka_lantas"
                                                        name="jenis_kasus[]" value="laka_lantas">
                                                    <label class="form-check-label" for="laka_lantas">Laka lantas</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="pemukulan"
                                                        name="jenis_kasus[]" value="pemukulan">
                                                    <label class="form-check-label" for="pemukulan">Pemukulan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="kesusilaan"
                                                        name="jenis_kasus[]" value="kesusilaan">
                                                    <label class="form-check-label" for="kesusilaan">Kesusilaan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="kdrt"
                                                        name="jenis_kasus[]" value="kdrt">
                                                    <label class="form-check-label" for="kdrt">KDRT</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="keracunan"
                                                        name="jenis_kasus[]" value="keracunan">
                                                    <label class="form-check-label" for="keracunan">Keracunan</label>
                                                </div>
                                                <div class="d-flex gap-2 align-items-center">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="kasus_lainnya" name="jenis_kasus[]" value="lainnya">
                                                        <label class="form-check-label"
                                                            for="kasus_lainnya">Lainnya</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Identitas Penyidik -->
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Identitas Penyidik</label>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">1. Nomor</label>
                                        <input type="text" class="form-control" name="nomor_penyidik">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">2. Nama</label>
                                        <input type="text" class="form-control" name="nama_penyidik">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">3. Tanggal</label>
                                        <input type="text" class="form-control" name="tanggal_penyidik"
                                            placeholder="dd/mm/yyyy">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">4. Instansi</label>
                                        <input type="text" class="form-control" name="instansi_penyidik">
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">2. Pemeriksaan Dokter Forensik Klinik</h5>

                                    <!-- Pemeriksaan -->
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pemeriksaan</label>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="pemeriksaan_umum"
                                                    name="pemeriksaan[]" value="pemeriksaan_umum">
                                                <label class="form-check-label" for="pemeriksaan_umum">Pemeriksaan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="sampel_darah"
                                                    name="pemeriksaan[]" value="sampel_darah">
                                                <label class="form-check-label" for="sampel_darah">Pemeriksaan sampel
                                                    darah</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="barang_bukti"
                                                    name="pemeriksaan[]" value="barang_bukti">
                                                <label class="form-check-label" for="barang_bukti">Pemeriksaan/Pemaketan
                                                    Barang Bukti</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="toksikologi"
                                                    name="pemeriksaan[]" value="toksikologi">
                                                <label class="form-check-label" for="toksikologi">Pemeriksaan
                                                    toksikologi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="molekuler"
                                                    name="pemeriksaan[]" value="molekuler">
                                                <label class="form-check-label" for="molekuler">Pemeriksaan
                                                    molekuler</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="foto_rontgen"
                                                    name="pemeriksaan[]" value="foto_rontgen">
                                                <label class="form-check-label" for="foto_rontgen">Foto rontgent</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="ct_scan"
                                                    name="pemeriksaan[]" value="ct_scan">
                                                <label class="form-check-label" for="ct_scan">Pemeriksaan CT-Scan</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="pemeriksaan_lainnya"
                                                    name="pemeriksaan[]" value="lainnya">
                                                <label class="form-check-label" for="pemeriksaan_lainnya">Lainnya</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Anamnesis -->
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Anamnesis</label>
                                        <textarea class="form-control" name="anamnesis" rows="5"></textarea>
                                    </div>

                                    <!-- Hasil Pemeriksaan -->
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Hasil Pemeriksaan</label>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat kesadaran</label>
                                        <input type="text" class="form-control" name="tingkat_kesadaran">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Denyut nadi</label>
                                        <input type="text" class="form-control" name="denyut_nadi">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pernafasan</label>
                                        <input type="text" class="form-control" name="pernafasan">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tekanan darah</label>
                                        <input type="text" class="form-control" name="tekanan_darah">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Suhu badan</label>
                                        <input type="text" class="form-control" name="suhu_badan">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pemeriksaan lain-lain</label>
                                        <textarea class="form-control" name="pemeriksaan_lain" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">3. Kelainan Kelainan Fisik</h5>

                                    <div class="alert alert-info mb-3">
                                        <p class="mb-0 small">
                                            <i class="bi bi-info-circle me-2"></i>
                                            Centang normal jika fisik yang dinilai normal, pilih tanda tambah untuk menambah
                                            keterangan fisik yang ditemukan tidak normal.
                                            Jika tidak dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                        </p>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Kolom Kiri -->
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column gap-3">
                                                <!-- Item Pemeriksaan -->
                                                <div class="pemeriksaan-item">
                                                    <div class="d-flex align-items-center border-bottom pb-2">
                                                        <div class="flex-grow-1">Kepala</div>
                                                        <div class="form-check me-3">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="kepala-normal">
                                                            <label class="form-check-label"
                                                                for="kepala-normal">Normal</label>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                            type="button" data-target="kepala-keterangan">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="keterangan mt-2" id="kepala-keterangan"
                                                        style="display:none;">
                                                        <input type="text" class="form-control"
                                                            name="kepala_keterangan"
                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                    </div>
                                                </div>

                                                <div class="pemeriksaan-item">
                                                    <div class="d-flex align-items-center border-bottom pb-2">
                                                        <div class="flex-grow-1">Mata</div>
                                                        <div class="form-check me-3">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="mata-normal">
                                                            <label class="form-check-label"
                                                                for="mata-normal">Normal</label>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                            type="button" data-target="mata-keterangan">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="keterangan mt-2" id="mata-keterangan"
                                                        style="display:none;">
                                                        <input type="text" class="form-control" name="mata_keterangan"
                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                    </div>
                                                </div>
                                                <div class="pemeriksaan-item">
                                                    <div class="d-flex align-items-center border-bottom pb-2">
                                                        <div class="flex-grow-1">Kepala</div>
                                                        <div class="form-check me-3">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="kepala-normal">
                                                            <label class="form-check-label"
                                                                for="kepala-normal">Normal</label>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                            type="button" data-target="kepala-keterangan">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="keterangan mt-2" id="kepala-keterangan"
                                                        style="display:none;">
                                                        <input type="text" class="form-control"
                                                            name="kepala_keterangan"
                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                    </div>
                                                </div>

                                                <div class="pemeriksaan-item">
                                                    <div class="d-flex align-items-center border-bottom pb-2">
                                                        <div class="flex-grow-1">Mata</div>
                                                        <div class="form-check me-3">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="mata-normal">
                                                            <label class="form-check-label"
                                                                for="mata-normal">Normal</label>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                            type="button" data-target="mata-keterangan">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="keterangan mt-2" id="mata-keterangan"
                                                        style="display:none;">
                                                        <input type="text" class="form-control" name="mata_keterangan"
                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Kolom Kanan -->
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column gap-3">
                                                <div class="pemeriksaan-item">
                                                    <div class="d-flex align-items-center border-bottom pb-2">
                                                        <div class="flex-grow-1">Telinga</div>
                                                        <div class="form-check me-3">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="telinga-normal">
                                                            <label class="form-check-label"
                                                                for="telinga-normal">Normal</label>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                            type="button" data-target="telinga-keterangan">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="keterangan mt-2" id="telinga-keterangan"
                                                        style="display:none;">
                                                        <input type="text" class="form-control"
                                                            name="telinga_keterangan"
                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                    </div>
                                                </div>

                                                <div class="pemeriksaan-item">
                                                    <div class="d-flex align-items-center border-bottom pb-2">
                                                        <div class="flex-grow-1">Hidung</div>
                                                        <div class="form-check me-3">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="hidung-normal">
                                                            <label class="form-check-label"
                                                                for="hidung-normal">Normal</label>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                            type="button" data-target="hidung-keterangan">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="keterangan mt-2" id="hidung-keterangan"
                                                        style="display:none;">
                                                        <input type="text" class="form-control"
                                                            name="hidung_keterangan"
                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                    </div>
                                                </div>
                                                <div class="pemeriksaan-item">
                                                    <div class="d-flex align-items-center border-bottom pb-2">
                                                        <div class="flex-grow-1">Telinga</div>
                                                        <div class="form-check me-3">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="telinga-normal">
                                                            <label class="form-check-label"
                                                                for="telinga-normal">Normal</label>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                            type="button" data-target="telinga-keterangan">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="keterangan mt-2" id="telinga-keterangan"
                                                        style="display:none;">
                                                        <input type="text" class="form-control"
                                                            name="telinga_keterangan"
                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                    </div>
                                                </div>

                                                <div class="pemeriksaan-item">
                                                    <div class="d-flex align-items-center border-bottom pb-2">
                                                        <div class="flex-grow-1">Hidung</div>
                                                        <div class="form-check me-3">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="hidung-normal">
                                                            <label class="form-check-label"
                                                                for="hidung-normal">Normal</label>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                            type="button" data-target="hidung-keterangan">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="keterangan mt-2" id="hidung-keterangan"
                                                        style="display:none;">
                                                        <input type="text" class="form-control"
                                                            name="hidung_keterangan"
                                                            placeholder="Tambah keterangan jika tidak normal...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Penatalaksanaan -->
                                <div class="section-separator">
                                    <h5 class="section-title">F. Penatalaksanaan</h5>

                                    <div class="form-group">
                                        <div class="d-flex flex-column gap-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="visum"
                                                    name="penatalaksanaan[]" value="visum">
                                                <label class="form-check-label" for="visum">Pembuatan Visum et
                                                    repertum</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="surat_medik"
                                                    name="penatalaksanaan[]" value="surat_medik">
                                                <label class="form-check-label" for="surat_medik">Pembuatan surat
                                                    keterangan medik</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="surat_asuransi"
                                                    name="penatalaksanaan[]" value="surat_asuransi">
                                                <label class="form-check-label" for="surat_asuransi">Pembuatan surat
                                                    keterangan asuransi</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="toksikologi"
                                                    name="penatalaksanaan[]" value="toksikologi">
                                                <label class="form-check-label" for="toksikologi">Pemeriksaan
                                                    Toksikologi</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="penatalaksanaan_lainnya" name="penatalaksanaan[]"
                                                        value="lainnya">
                                                    <label class="form-check-label"
                                                        for="penatalaksanaan_lainnya">Pemeriksaan Lainnya:</label>
                                                </div>
                                                <input type="text" class="form-control"
                                                    name="penatalaksanaan_lainnya_detail" style="width: 300px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Keadaan Pulang -->
                                <div class="section-separator">
                                    <h5 class="section-title">G. Keadaan Pulang</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Diagnosos Ahli Forensik</label>
                                        <input type="text" class="form-control" name="diagnosos_forensik">
                                    </div>

                                    <div class="form-group mt-3">
                                        <label style="min-width: 200px;">Dibawa oleh:</label>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="dibawa_keluarga"
                                                    name="dibawa_oleh[]" value="keluarga">
                                                <label class="form-check-label" for="dibawa_keluarga">Keluarga</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="dibawa_kepolisian"
                                                    name="dibawa_oleh[]" value="kepolisian">
                                                <label class="form-check-label" for="dibawa_kepolisian">Kepolisian</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="dibawa_lainnya"
                                                        name="dibawa_oleh[]" value="lainnya">
                                                    <label class="form-check-label"
                                                        for="dibawa_lainnya">Lain-lain:</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal</label>
                                        <input type="text" class="form-control" name="tanggal_pulang"
                                            placeholder="dd/mm/yyyy">
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
