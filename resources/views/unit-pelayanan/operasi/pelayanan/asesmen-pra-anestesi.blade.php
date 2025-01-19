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

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('unit-pelayanan.operasi.pelayanan.include.nav')


            <div class="container-fluid py-3">
                <!-- Form Header -->
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <h5 class="mb-0 text-secondary fw-bold">ASESMEN PRA ANESTESI DAN SEDASI</h5>
                </div>

                <!-- Kebiasaan & Pengobatan -->
                <div class="form-section">
                    <div class="section-title fw-bold">KEBIASAAN:</div>
                    <div class="mb-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Merokok</label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alkohol</label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>

                    <div class="section-title fw-bold mt-4">PENGOBATAN:</div>
                    <div class="mb-3">
                        <small class="text-muted">Sebutkan dosis atau jumlah pil per hari</small>
                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label class="form-label">Obat resep</label>
                                <textarea class="form-control form-control-sm" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Obat bebas (vitamin, herbal)</label>
                                <textarea class="form-control form-control-sm" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="radio-group">
                            <span class="radio-label">Penggunaan aspirin rutin</span>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="aspirin" id="aspirinY">
                                <label class="form-check-label" for="aspirinY">Y</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="aspirin" id="aspirinT">
                                <label class="form-check-label" for="aspirinT">T</label>
                            </div>
                            <div class="input-addon">
                                <input type="text" class="form-control form-control-sm border-0"
                                    placeholder="Dosis dan frekuensi">
                            </div>
                        </div>

                        <div class="radio-group mt-3">
                            <span class="radio-label">Obat anti sakit</span>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="antisakit" id="antisakitY">
                                <label class="form-check-label" for="antisakitY">Y</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="antisakit" id="antisakitT">
                                <label class="form-check-label" for="antisakitT">T</label>
                            </div>
                            <div class="input-addon">
                                <input type="text" class="form-control form-control-sm border-0"
                                    placeholder="Dosis dan frekuensi">
                            </div>
                        </div>

                        <div class="radio-group mt-3">
                            <span class="radio-label">Injeksi steroid tahun-tahun terakhir</span>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="steroid" id="steroidY">
                                <label class="form-check-label" for="steroidY">Y</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="steroid" id="steroidT">
                                <label class="form-check-label" for="steroidT">T</label>
                            </div>
                            <div class="input-addon">
                                <input type="text" class="form-control form-control-sm border-0"
                                    placeholder="Tanggal dan lokasi injeksi">
                            </div>
                        </div>

                        <div class="radio-group mt-3">
                            <span class="radio-label">Alergi Obat</span>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="alergi_obat" id="alergiObatY">
                                <label class="form-check-label" for="alergiObatY">Y</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="alergi_obat" id="alergiObatT">
                                <label class="form-check-label" for="alergiObatT">T</label>
                            </div>
                            <div class="input-addon">
                                <input type="text" class="form-control form-control-sm border-0"
                                    placeholder="Daftar obat dan tipe reaksi">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="radio-group">
                                    <span class="radio-label">Alergi Lateks</span>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="alergi_lateks"
                                            id="alergiLateksY">
                                        <label class="form-check-label" for="alergiLateksY">Y</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="alergi_lateks"
                                            id="alergiLateksT">
                                        <label class="form-check-label" for="alergiLateksT">T</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="radio-group">
                                    <span class="radio-label">Alergi Plester</span>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="alergi_plester"
                                            id="alergiPlesterY">
                                        <label class="form-check-label" for="alergiPlesterY">Y</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="alergi_plester"
                                            id="alergiPlesterT">
                                        <label class="form-check-label" for="alergiPlesterT">T</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="radio-group">
                                    <span class="radio-label">Alergi Makanan</span>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="alergi_makanan"
                                            id="alergiMakananY">
                                        <label class="form-check-label" for="alergiMakananY">Y</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="alergi_makanan"
                                            id="alergiMakananT">
                                        <label class="form-check-label" for="alergiMakananT">T</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Keluarga -->
                <div class="form-section mt-5">
                    <div class="section-title"><span class="fw-bold">RIWAYAT KELUARGA</span>: Apakah keluarga mendapat
                        permasalahan seperti di bawah
                        ini:
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="radio-group">
                                <span class="radio-label">Perdarahan yang tidak normal</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="perdarahan" id="perdarahanY">
                                    <label class="form-check-label" for="perdarahanY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="perdarahan" id="perdarahanT">
                                    <label class="form-check-label" for="perdarahanT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Pembekuan darah tidak normal</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pembekuan" id="pembekuanY">
                                    <label class="form-check-label" for="pembekuanY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pembekuan" id="pembekuanT">
                                    <label class="form-check-label" for="pembekuanT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Operasi jantung koroner</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jantung" id="jantungY">
                                    <label class="form-check-label" for="jantungY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jantung" id="jantungT">
                                    <label class="form-check-label" for="jantungT">T</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="radio-group">
                                <span class="radio-label">Serangan jantung</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="seranganJantung"
                                        id="seranganJantungY">
                                    <label class="form-check-label" for="seranganJantungY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="seranganJantung"
                                        id="seranganJantungT">
                                    <label class="form-check-label" for="seranganJantungT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Hipertensi</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hipertensi" id="hipertensiY">
                                    <label class="form-check-label" for="hipertensiY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hipertensi" id="hipertensiT">
                                    <label class="form-check-label" for="hipertensiT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Penyakit berat lainnya</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="penyakitBerat"
                                        id="penyakitBeratY">
                                    <label class="form-check-label" for="penyakitBeratY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="penyakitBerat"
                                        id="penyakitBeratT">
                                    <label class="form-check-label" for="penyakitBeratT">T</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Jelaskan penyakit keluarga apabila dijawab "Ya"</label>
                        <textarea class="form-control form-control-sm" rows="2"></textarea>
                    </div>
                </div>

                <!-- Komunikasi -->
                <div class="form-section mt-5">
                    <div class="section-title fw-bold">
                        KOMUNIKASI
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <div class="radio-group mt-3">
                                <span class="radio-label">Bahasa</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="bahasa" id="bahasaIndo">
                                    <label class="form-check-label" for="bahasaIndo">Indonesia</label>
                                </div>
                                <div class="input-addon">
                                    <input type="text" class="form-control form-control-sm border-0"
                                        placeholder="Lainnya">
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Gangguan penglihatan/buta</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="buta" id="butaY">
                                    <label class="form-check-label" for="butaY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="buta" id="butaT">
                                    <label class="form-check-label" for="butaT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Gangguan penedengaran/tuli</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tuli" id="tuliY">
                                    <label class="form-check-label" for="tuliY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tuli" id="tuliT">
                                    <label class="form-check-label" for="tuliT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Gangguan bicara</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="bisu" id="bisuY">
                                    <label class="form-check-label" for="bisuY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="bisu" id="bisuT">
                                    <label class="form-check-label" for="bisuT">T</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Penyakit Pasien -->
                <div class="form-section mt-5">
                    <div class="section-title"><span class="fw-bold">RIWAYAT PENYAKIT PASIEN</span>: Apakah pernah
                        menderita penyakit di bawah ini:
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="radio-group">
                                <span class="radio-label">Perdarahan yang tidak normal</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_perdarahan"
                                        id="pasienPerdarahanY">
                                    <label class="form-check-label" for="pasienPerdarahanY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_perdarahan"
                                        id="pasienPerdarahanT">
                                    <label class="form-check-label" for="pasienPerdarahanT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Pembekuan darah tidak normal</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_pembekuan"
                                        id="pasienPembekuanY">
                                    <label class="form-check-label" for="pasienPembekuanY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_pembekuan"
                                        id="pasienPembekuanT">
                                    <label class="form-check-label" for="pasienPembekuanT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Sakit maag</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_maag" id="pasienMaagY">
                                    <label class="form-check-label" for="pasienMaagY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_maag" id="pasienMaagT">
                                    <label class="form-check-label" for="pasienMaagT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Anemia</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_anemia"
                                        id="pasienAnemiaY">
                                    <label class="form-check-label" for="pasienAnemiaY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_anemia"
                                        id="pasienAnemiaT">
                                    <label class="form-check-label" for="pasienAnemiaT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Sesak nafas</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_sesak"
                                        id="pasienSesakY">
                                    <label class="form-check-label" for="pasienSesakY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_sesak"
                                        id="pasienSesakT">
                                    <label class="form-check-label" for="pasienSesakT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Asma</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_asma" id="AsmaY">
                                    <label class="form-check-label" for="AsmaY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_asma" id="AsmaT">
                                    <label class="form-check-label" for="AsmaT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Diabetes mellitus</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_diabetes"
                                        id="pasienDiabetesY">
                                    <label class="form-check-label" for="pasienDiabetesY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_diabetes"
                                        id="pasienDiabetesT">
                                    <label class="form-check-label" for="pasienDiabetesT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Pingsan</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_pingsan"
                                        id="pasienPingsanY">
                                    <label class="form-check-label" for="pasienPingsanY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_pingsan"
                                        id="pasienPingsanT">
                                    <label class="form-check-label" for="pasienPingsanT">T</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="radio-group">
                                <span class="radio-label">Serangan jantung</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_serangan_jantung"
                                        id="pasienSeranganJantungY">
                                    <label class="form-check-label" for="pasienSeranganJantungY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_serangan_jantung"
                                        id="pasienSeranganJantungT">
                                    <label class="form-check-label" for="pasienSeranganJantungT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Hepatitis</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_hepatitis"
                                        id="pasienHepatitisY">
                                    <label class="form-check-label" for="pasienHepatitisY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_hepatitis"
                                        id="pasienHepatitisT">
                                    <label class="form-check-label" for="pasienHepatitisT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Hipertensi</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_hipertensi"
                                        id="pasienHipertensiY">
                                    <label class="form-check-label" for="pasienHipertensiY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_hipertensi"
                                        id="pasienHipertensiT">
                                    <label class="form-check-label" for="pasienHipertensiT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Sumbatan Jalan Nafas</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_sumbatan"
                                        id="pasienSumbatanY">
                                    <label class="form-check-label" for="pasienSumbatanY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_sumbatan"
                                        id="pasienSumbatanT">
                                    <label class="form-check-label" for="pasienSumbatanT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Tidur Mengorok</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_ngorok"
                                        id="pasienNgorokY">
                                    <label class="form-check-label" for="pasienNgorokY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_ngorok"
                                        id="pasienNgorokT">
                                    <label class="form-check-label" for="pasienNgorokT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Penyakit berat lainnya</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_sakit_berat_lainnya"
                                        id="pasienSakitBeratLainnyaY">
                                    <label class="form-check-label" for="pasienSakitBeratLainnyaY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_sakit_berat_lainnya"
                                        id="pasienSakitBeratLainnyaT">
                                    <label class="form-check-label" for="pasienSakitBeratLainnyaT">T</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Jelaskan penyakit pasien apabila dijawab "Ya"</label>
                        <textarea class="form-control form-control-sm" rows="2"></textarea>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="radio-group">
                                <span class="radio-label">Apakah pasien pernah mendapat transfusi darah</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_transfusi"
                                        id="pasienTransfusiY">
                                    <label class="form-check-label" for="pasienTransfusiY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_transfusi"
                                        id="pasienTransfusiT">
                                    <label class="form-check-label" for="pasienTransfusiT">T</label>
                                </div>
                                <div class="input-addon">
                                    <input type="text" class="form-control form-control-sm border-0"
                                        placeholder="Bila ya tahun berapa">
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Apakah pasien pernah diperiksa untuk diagnosis HIV</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_diag_hiv"
                                        id="pasienDiagHIVY">
                                    <label class="form-check-label" for="pasienDiagHIVY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_diag_hiv"
                                        id="pasienDiagHIVT">
                                    <label class="form-check-label" for="pasienDiagHIVT">T</label>
                                </div>
                                <div class="input-addon">
                                    <input type="text" class="form-control form-control-sm border-0"
                                        placeholder="Bila ya tahun berapa">
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Hasil pemeriksaan HIV</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_hasil_hiv"
                                        id="pasienHasilHIVY">
                                    <label class="form-check-label" for="pasienHasilHIVY">Positif</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pasien_hasil_hiv"
                                        id="pasienHasilHIVT">
                                    <label class="form-check-label" for="pasienHasilHIVT">Negatif</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kajian Sistem -->
                <div class="form-section mt-5">
                    <div class="section-title fw-bold">
                        KAJIAN SISTEM
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="radio-group">
                                <span class="radio-label">Hilangnya gigi</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_gigi" id="kajianGigiY">
                                    <label class="form-check-label" for="kajianGigiY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_gigi" id="kajianGigiT">
                                    <label class="form-check-label" for="kajianGigiT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Masalah mobilisasi leher </span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_leher"
                                        id="kajianLeherY">
                                    <label class="form-check-label" for="kajianLeherY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_leher"
                                        id="kajianLeherT">
                                    <label class="form-check-label" for="kajianLeherT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Leher pendek</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_leher_pendek"
                                        id="kajianLeherPendekY">
                                    <label class="form-check-label" for="kajianLeherPendekY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_leher_pendek"
                                        id="kajianLeherPendekT">
                                    <label class="form-check-label" for="kajianLeherPendekT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Batuk</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_batuk"
                                        id="kajianBatukY">
                                    <label class="form-check-label" for="kajianBatukY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_batuk"
                                        id="kajianBatukT">
                                    <label class="form-check-label" for="kajianBatukT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Sesak Nafas</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_sesak"
                                        id="kajianSesakY">
                                    <label class="form-check-label" for="kajianSesakY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_sesak"
                                        id="kajianSesakT">
                                    <label class="form-check-label" for="kajianSesakT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Baru saja menderita infeksi</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_infeksi"
                                        id="kajianInfeksiY">
                                    <label class="form-check-label" for="kajianInfeksiY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_infeksi"
                                        id="kajianInfeksiT">
                                    <label class="form-check-label" for="kajianInfeksiT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Menstruasi tidak normal</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_menstruasi"
                                        id="kajianMenstruasiY">
                                    <label class="form-check-label" for="kajianMenstruasiY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_menstruasi"
                                        id="kajianMenstruasiT">
                                    <label class="form-check-label" for="kajianMenstruasiT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Pingsan</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_pingsan"
                                        id="kajianPingsanY">
                                    <label class="form-check-label" for="kajianPingsanY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_pingsan"
                                        id="kajianPingsanT">
                                    <label class="form-check-label" for="kajianPingsanT">T</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="radio-group">
                                <span class="radio-label">Sakit Dada</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_dada" id="kajianDadaY">
                                    <label class="form-check-label" for="kajianDadaY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_dada" id="kajianDadaT">
                                    <label class="form-check-label" for="kajianDadaT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Denyut jantung tidak normal</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_jantung"
                                        id="kajianJantungY">
                                    <label class="form-check-label" for="kajianJantungY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_jantung"
                                        id="kajianJantungT">
                                    <label class="form-check-label" for="kajianJantungT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Muntah</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_muntah"
                                        id="kajianMuntahY">
                                    <label class="form-check-label" for="kajianMuntahY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_muntah"
                                        id="kajianMuntahT">
                                    <label class="form-check-label" for="kajianMuntahT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Susah BAK</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_bak" id="kajianBAKY">
                                    <label class="form-check-label" for="kajianBAKY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_bak" id="kajianBAKT">
                                    <label class="form-check-label" for="kajianBAKT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Kejang</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_kejang"
                                        id="kajianKejangY">
                                    <label class="form-check-label" for="kajianKejangY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_kejang"
                                        id="kajianKejangT">
                                    <label class="form-check-label" for="kajianKejangT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Sedang Hamil</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_hamil"
                                        id="kajianHamilY">
                                    <label class="form-check-label" for="kajianHamilY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_hamil"
                                        id="kajianHamilT">
                                    <label class="form-check-label" for="kajianHamilT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Stroke</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_stroke"
                                        id="kajianStrokeY">
                                    <label class="form-check-label" for="kajianStrokeY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_stroke"
                                        id="kajianStrokeT">
                                    <label class="form-check-label" for="kajianStrokeT">T</label>
                                </div>
                            </div>
                            <div class="radio-group mt-3">
                                <span class="radio-label">Obesitas</span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_obesitas"
                                        id="kajianObesitasY">
                                    <label class="form-check-label" for="kajianObesitasY">Y</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kajian_obesitas"
                                        id="kajianObesitasT">
                                    <label class="form-check-label" for="kajianObesitasT">T</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
