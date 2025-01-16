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
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Persetujuan Tindakan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark"
                        href="{{ route('operasi.pelayanan', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">Asesmen
                        Pra Operasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark fw-bold active"
                        href="{{ route('operasi.pelayanan.asesmen-pra-anestesi', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">Asesmen
                        Pra Anestesi dan Sedasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Catatan Sedasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Ceklist Kesiapan Anastesia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Edukasi Anastesi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Asesmen Pra Operasi (Perawat)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Penandaan Daerah Operasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Ceklist Keselamatan Pasien Operasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Laporan Operasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">Catatan Intra dan Pasca Operasi</a>
                </li>
            </ul>

            <div class="container-fluid py-3">
                <!-- Form Header -->
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <h5 class="mb-0 text-secondary fw-bold">ASESMEN PRA ANESTESI DAN SEDASI</h5>
                </div>

                <!-- Kebiasaan & Pengobatan -->
                <div class="form-section">
                    <div class="section-title">KEBIASAAN:</div>
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

                    <div class="section-title mt-4">PENGOBATAN:</div>
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

                        <div class="radio-group">
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

                        <div class="radio-group">
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

                        <div class="radio-group">
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
                    </div>
                </div>

                <!-- Riwayat Keluarga -->
                <div class="form-section">
                    <div class="section-title">RIWAYAT KELUARGA: Apakah keluarga mendapat permasalahan seperti di bawah
                        ini:</div>
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
                            <div class="radio-group">
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
                            <div class="radio-group">
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
                            <div class="radio-group">
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
                            <div class="radio-group">
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
            </div>
        </div>
    </div>
@endsection
