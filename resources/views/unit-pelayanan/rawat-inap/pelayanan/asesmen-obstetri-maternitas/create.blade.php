@extends('layouts.administrator.master')


@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
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
                                <div class="col-md-8">
                                    <h4 class="header-asesmen">Asesmen Awal Medis Obstetri</h4>
                                    <p>
                                        Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>
                                <div class="col-md-4">
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
                        </div>

                        {{-- FORM ASESMEN AWAL KEPERATAWAN --}}

                        <div class="px-3">
                            <div>
                                <div class="section-separator" id="data-masuk">
                                    <h5 class="section-title">1. Data Masuk</h5>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Tanggal dan Jam Masuk</label>
                                        <div class="col-sm-8 d-flex gap-3">
                                            <input type="date" class="form-control" name="tanggal_masuk">
                                            <input type="time" class="form-control" name="jam_masuk">
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3">
                                        <label class="col-sm-3 col-form-label">Pemeriksaan antenatal di RS Langsa</label>
                                        <div class="col-sm-8 d-flex align-items-center gap-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="antenatal_rs"
                                                    id="rs_tidak" value="Tidak">
                                                <label class="form-check-label" for="rs_tidak">Tidak</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="antenatal_rs"
                                                    id="rs_ya" value="Ya">
                                                <label class="form-check-label" for="rs_ya">Ya</label>
                                            </div>
                                            <div class="input-group" style="width: 150px;">
                                                <input type="number" class="form-control" name="antenatal_rs_count"
                                                    placeholder="Berapa kali">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3">
                                        <label class="col-sm-3 col-form-label">Pemeriksaan antenatal di tempat lain</label>
                                        <div class="col-sm-8 d-flex align-items-center gap-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="antenatal_lain"
                                                    id="lain_tidak" value="Tidak">
                                                <label class="form-check-label" for="lain_tidak">Tidak</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="antenatal_lain"
                                                    id="lain_ya" value="Ya">
                                                <label class="form-check-label" for="lain_ya">Ya</label>
                                            </div>
                                            <div class="input-group" style="width: 150px;">
                                                <input type="number" class="form-control" name="antenatal_lain_count"
                                                    placeholder="Berapa kali">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3">
                                        <label class="col-sm-3 col-form-label">Nama Pemeriksa</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="nama_pemeriksa"
                                                placeholder="Nama dokter/bidan/perawat">
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator" id="anamnesis">
                                    <h5 class="section-title">2. Anamnesis</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Anamnesis</label>
                                        <textarea class="form-control" name="anamnesis" rows="4" placeholder="keluhan utama pasien"></textarea>
                                    </div>
                                </div>

                                <div class="section-separator" id="pemeriksaan-fisik">
                                    <h5 class="section-title">3. Pemeriksaan fisik</h5>

                                    <!-- Pemeriksaan Awal -->
                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Keadaan Umum</label>
                                        <input type="text" class="form-control" name="keadaan_umum"
                                            placeholder="jelaskan">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Tek Darah (mmHg)</label>
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" name="tekanan_sistole"
                                                placeholder="Sistole">
                                            <input type="text" class="form-control" name="tekanan_diastole"
                                                placeholder="Diastole">
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Nadi (Per Menit)</label>
                                        <input type="text" class="form-control" name="nadi"
                                            placeholder="frekuensi nadi per menit">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Pernafasan (Per Menit)</label>
                                        <input type="text" class="form-control" name="pernafasan"
                                            placeholder="frekuensi nafas per menit">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Suhu (C)</label>
                                        <input type="text" class="form-control" name="suhu"
                                            placeholder="suhu dalam celcius">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Kesadaran</label>
                                        <select class="form-select" name="kesadaran">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">AVPU</label>
                                        <select class="form-select" name="avpu">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <!-- Pemeriksaan Fisik Komprehensif -->
                                    <div class="mt-4 mb-3">
                                        <h6>Pemeriksaan Fisik Komprehensif</h6>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Posisi Janin</label>
                                        <select class="form-select" name="posisi_janin">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Tinggi Fundus Uteri (Cm)</label>
                                        <input type="text" class="form-control" name="tinggi_fundus"
                                            placeholder="dalam cm">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Kontraksi (HIS)</label>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Frekuensi</label>
                                        <input type="text" class="form-control" name="frekuensi" placeholder="/...">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Kekuatan</label>
                                        <select class="form-select" name="kekuatan">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Irama</label>
                                        <select class="form-select" name="irama">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Letak Janin</label>
                                        <select class="form-select" name="letak_janin">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Presentasi Janin</label>
                                        <select class="form-select" name="presentasi_janin">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Sikap Janin</label>
                                        <select class="form-select" name="sikap_janin">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Denyut Jantung Janin (DJJ)</label>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Frekuensi</label>
                                        <input type="text" class="form-control" name="frekuensi_djj"
                                            placeholder="pilih">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Irama</label>
                                        <select class="form-select" name="irama_djj">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Serviks</label>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Konsistensi</label>
                                        <select class="form-select" name="konsistensi_serviks">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Station</label>
                                        <div class="d-flex gap-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="station"
                                                    value="-3" id="station-3">
                                                <label class="form-check-label" for="station-3">-3</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="station"
                                                    value="-2" id="station-2">
                                                <label class="form-check-label" for="station-2">-2</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="station"
                                                    value="-1" id="station-1">
                                                <label class="form-check-label" for="station-1">-1</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="station"
                                                    value="0" id="station0">
                                                <label class="form-check-label" for="station0">0</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="station"
                                                    value="+1" id="station1">
                                                <label class="form-check-label" for="station1">+1</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="station"
                                                    value="+2" id="station2">
                                                <label class="form-check-label" for="station2">+2</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="station"
                                                    value="+3" id="station3">
                                                <label class="form-check-label" for="station3">+3</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Penurunan</label>
                                        <select class="form-select" name="penurunan">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Pembukaan</label>
                                        <input type="text" class="form-control" name="pembukaan" placeholder="">
                                        <label class="d-block mr-2">Jam</label>
                                        <input type="time" class="form-control" name="jam_pembukaan">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Posisi</label>
                                        <select class="form-select" name="posisi">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Irama</label>
                                        <select class="form-select" name="irama_pembukaan">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label class="d-block mb-2" style="min-width: 200px;">Promontorium</label>
                                            <select class="form-select" name="promontorium">
                                                <option value="" selected>pilih</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="d-block mb-2" style="min-width: 200px;">Line Terminalis</label>
                                            <select class="form-select" name="line_terminalis">
                                                <option value="" selected>pilih</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label class="d-block mb-2" style="min-width: 200px;">Spina Ischiadika</label>
                                            <select class="form-select" name="spina_ischiadika">
                                                <option value="" selected>pilih</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="d-block mb-2" style="min-width: 200px;">Arkus Pubis</label>
                                            <select class="form-select" name="arkus_pubis">
                                                <option value="" selected>pilih</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label class="d-block mb-2" style="min-width: 200px;">Lengkung Sakrum</label>
                                            <select class="form-select" name="lengkung_sakrum">
                                                <option value="" selected>pilih</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="d-block mb-2" style="min-width: 200px;">Dinding Samping</label>
                                            <select class="form-select" name="dinding_samping">
                                                <option value="" selected>pilih</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Simpulan</label>
                                        <select class="form-select" name="simpulan">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Pembukaan (Cm)</label>
                                        <input type="text" class="form-control" name="pembukaan_cm"
                                            placeholder="dalam cm">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Selaput Ketuban</label>
                                        <select class="form-select" name="selaput_ketuban">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Air Ketuban</label>
                                        <select class="form-select" name="air_ketuban">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-4" >
                                        <label class="d-block mb-2" style="min-width: 200px;">Presentasi</label>
                                        <input type="text" class="form-control" name="presentasi">
                                    </div>

                                    <!-- Antropometri -->
                                    <div class="mt-4 mb-3">
                                        <h6>Antropometri</h6>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Tinggi Badan (kg)</label>
                                        <input type="text" class="form-control" name="tinggi_badan">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Berat Badan (kg)</label>
                                        <input type="text" class="form-control" name="berat_badan">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Indeks Massa Tubuh (IMT)</label>
                                        <input type="text" class="form-control bg-light"
                                            placeholder="rumus: IMT = berat (kg) / tinggi (m)²" readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Luas Permukaan Tubuh (LPT)</label>
                                        <input type="text" class="form-control bg-light"
                                            placeholder="rumus: LPT = tinggi (m2) x berat (kg) / 3600" readonly>
                                    </div>

                                    <div class="mb-3 row align-items-center">
                                        <p class="col-3">
                                            Pemeriksaan Fisik
                                        </p>
                                        <div class="col-9">
                                            <div class="alert alert-info mb-3 mt-4">
                                                <p class="mb-0 small">
                                                    <i class="bi bi-info-circle me-2"></i>
                                                    Centang normal jika fisik yang dinilai normal, pilih tanda tambah untuk
                                                    menambah
                                                    keterangan fisik yang ditemukan tidak normal.
                                                    Jika tidak dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                                </p>
                                            </div>
                                        </div>
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
                                                        @foreach ($chunk as $item)
                                                            <div class="pemeriksaan-item">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-grow-1">
                                                                        {{ $item->nama }}</div>
                                                                    <div class="form-check me-2">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="{{ $item->id }}-normal-index">
                                                                        <label class="form-check-label"
                                                                            for="{{ $item->id }}-normal-index">Normal</label>
                                                                    </div>
                                                                    <button
                                                                        class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                        type="button"
                                                                        data-target="{{ $item->id }}-keterangan-index">+</button>
                                                                </div>
                                                                <div class="keterangan mt-2"
                                                                    id="{{ $item->id }}-keterangan-index"
                                                                    style="display:none;">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Keterangan">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator" id="status-nyeri">
                                    <h5 class="section-title mb-4">4. Status Nyeri</h5>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Jenis Skala NYERI</label>
                                        <select class="form-select" name="jenis_skala_nyeri">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Nilai Skala Nyeri</label>
                                        <select class="form-select" name="nilai_skala_nyeri">
                                            <option value="" selected>Pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Kesimpulan Nyeri</label>
                                        <div class="p-3 bg-success text-white rounded">Nyeri Ringan</div>
                                    </div>

                                    <div class="mt-4 mb-3">
                                        <h6>Karakteristik Nyeri</h6>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="d-block mb-2" style="min-width: 100px;">Lokasi</label>
                                                <input type="text" class="form-control bg-light" name="lokasi_nyeri">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="d-block mb-2" style="min-width: 100px;">Durasi</label>
                                                <input type="text" class="form-control bg-light" name="durasi_nyeri">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="d-block mb-2" style="min-width: 100px;">Jenis nyeri</label>
                                                <select class="form-select" name="jenis_nyeri">
                                                    <option value="" selected>Pilih</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="d-block mb-2" style="min-width: 100px;">Frekuensi</label>
                                                <select class="form-select" name="frekuensi_nyeri">
                                                    <option value="" selected>Pilih</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="d-block mb-2" style="min-width: 100px;">Menjalar?</label>
                                                <select class="form-select" name="menjalar">
                                                    <option value="" selected>Pilih</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="d-block mb-2" style="min-width: 100px;">Kualitas</label>
                                                <select class="form-select" name="kualitas_nyeri">
                                                    <option value="" selected>Pilih</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="d-block mb-2" style="min-width: 100px;">Faktor pemberat</label>
                                                <select class="form-select" name="faktor_pemberat">
                                                    <option value="" selected>Pilih</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="d-block mb-2" style="min-width: 100px;">Faktor peringan</label>
                                                <select class="form-select" name="faktor_peringan">
                                                    <option value="" selected>Pilih</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 100px;">Efek Nyeri</label>
                                        <select class="form-select" name="efek_nyeri">
                                            <option value="" selected>Pilih</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">5. Riwayat Kesehatan</h5>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Status Obstetri</label>
                                        <div class="d-flex gap-3">
                                            <input type="text" class="form-control" name="gravid"
                                                placeholder="Gravid">
                                            <input type="text" class="form-control" name="partus"
                                                placeholder="Partus">
                                            <input type="text" class="form-control" name="abortus"
                                                placeholder="Abortus">
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Siklus</label>
                                        <select class="form-select" name="siklus">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Lama Haid</label>
                                        <input type="text" class="form-control" name="lama_haid" placeholder="Hari">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Hari Pertama Haid Terakhir</label>
                                        <input type="date" class="form-control" name="hpht">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Usia Kehamilan</label>
                                        <input type="text" class="form-control" name="usia_kehamilan">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Perkawinan</label>
                                        <div class="d-flex gap-3">
                                            <div style="flex: 1;">
                                                <input type="text" class="form-control" name="perkawinan_kali"
                                                    placeholder="Kali">
                                            </div>
                                            <div style="flex: 1;">
                                                <input type="text" class="form-control" name="perkawinan_usia"
                                                    placeholder="Tahun">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong class="fw-normal" >
                                                Riwayat kehamilan Sekarang
                                            </strong>
                                        </div>
                                        <div class="col-md-9">
                                            <a href="javascript:void(0)"
                                                class="text-secondary text-decoration-none fw-bold ms-3"
                                                id="btn-diagnosis">
                                                <i class="bi bi-plus-square"></i> Tambah
                                            </a>
                                            <div class="bg-light p-3 border rounded">
                                                <div style="max-height: 150px; overflow-y: auto;" id="diagnoseDisplay">
                                                    <div class="diagnosis-list">
                                                        <!-- Items will be inserted here -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.modal-create-diagnosi')
                                    </div>

                                    <div class="form-group mb-3 mt-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Kebiasaan Ibu Sewaktu Hamil</label>
                                        <select class="form-select" name="kebiasaan_ibu">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Penambahan BB Selama Hamil (Kg)</label>
                                        <input type="text" class="form-control" name="penambahan_bb">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Kehamilan Diinginkan</label>
                                        <select class="form-select" name="kehamilan_diinginkan">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Dukungan Sosial</label>
                                        <select class="form-select" name="dukungan_sosial">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Pengambilan Keputusan</label>
                                        <select class="form-select" name="pengambilan_keputusan">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Pendamping</label>
                                        <select class="form-select" name="pendamping">
                                            <option value="" selected>Pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Eliminasi (Defekasi)</label>
                                        <input type="text" class="form-control" name="eliminasi"
                                            placeholder="Masukkan informasi terkait defekasi...">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Riwayat Rawat Inap</label>
                                        <div class="d-flex gap-3">
                                            <select class="form-select" name="riwayat_rawat_inap" style="flex: 2;">
                                                <option value="" selected>pilih</option>
                                            </select>
                                            <input type="date" class="form-control" name="tanggal_rawat"
                                                style="flex: 1;">
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Konsumsi Obat-Obatan (Jika Ada)</label>
                                        <select class="form-select" name="konsumsi_obat">
                                            <option value="" selected>pilih</option>
                                        </select>
                                    </div>

                                    <div class="row mt-3 mt-3">
                                        <div class="col-md-3">
                                            <strong class="fw-normal">Riwayat Penyakit Keluarga</strong>
                                        </div>
                                        <div class="col-md-9">
                                            <a href="javascript:void(0)"
                                                class="text-secondary text-decoration-none fw-bold ms-3"
                                                id="btn-diagnosis-keluarga">
                                                <i class="bi bi-plus-square"></i> Tambah
                                            </a>
                                            <div class="bg-light p-3 border rounded">
                                                <div style="max-height: 150px; overflow-y: auto;">
                                                    <div class="diagnosis-list-keluarga">
                                                        <!-- Data akan ditampilkan disini -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-tht.modal-create-diagnosi-keluarga')
                                    </div>

                                    <div class="form-group mb-3 mt-3">
                                        <label class="d-block mb-2" style="min-width: 200px;">Pemeriksaan antenatal di tempat lain</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="antenatal_lain"
                                                    id="antenatal_tidak">
                                                <label class="form-check-label" for="antenatal_tidak">Tidak</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="antenatal_lain"
                                                    id="antenatal_ya">
                                                <label class="form-check-label" for="antenatal_ya">Ya</label>
                                            </div>
                                            <input type="text" class="form-control" style="width: 120px;"
                                                placeholder="berapa kali">
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="d-block mb-2 text-primary" style="min-width: 200px;">Riwayat Obstetrik</label>
                                        <small class="text-muted d-block mb-2">Pilih tanda tambah untuk menambah keterangan
                                            Riwayat Obstetrik yang ada.</small>
                                    </div>

                                    <div class="form-group mb-3">
                                        <div class="table-responsive">
                                            <a href="javascript:void(0)" class="text-secondary text-decoration-none fw-bold ms-3" id="btn-riwayat-obstetrik">
                                                <i class="bi bi-plus-square"></i> Tambah
                                            </a>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Keadaan Kehamilan</th>
                                                    <th>Cara Persalinan</th>
                                                    <th>Keadaan Nifas</th>
                                                    <th>Tanggal Lahir</th>
                                                    <th>Keadaan Anak</th>
                                                    <th>Tempat dan Penolong</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Baik</td>
                                                    <td>Normal</td>
                                                    <td>Normal</td>
                                                    <td>12/03/2020</td>
                                                    <td>Sehat</td>
                                                    <td>RS Langsa, dr. Ahmad</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Baik</td>
                                                    <td>Sectio Caesarea</td>
                                                    <td>Normal</td>
                                                    <td>15/06/2022</td>
                                                    <td>Sehat</td>
                                                    <td>RS Langsa, dr. Sarah</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>

                                </div>

                                <div class="section-separator" style="margin-bottom: 2rem;">
                                    <h5 class="fw-semibold mb-4">6. Hasil Pemeriksaan Penunjang</h5>

                                    <div class="mt-4">
                                        <!-- Darah Result -->
                                        <div class="row align-items-center mb-3">
                                            <div class="col-3 col-md-2">
                                                <span class="text-secondary">Darah</span>
                                            </div>
                                            <div class="col col-md-8">
                                                <div class="border rounded p-2 bg-white d-flex align-items-center">
                                                    <i class="bi bi-file-text text-primary me-2"></i>
                                                    <span class="text-secondary small">lab/rsp...</span>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-link text-primary text-decoration-none p-2">
                                                    Preview <i class="bi bi-eye-fill ms-1"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Urine Result -->
                                        <div class="row align-items-center mb-3">
                                            <div class="col-3 col-md-2">
                                                <span class="text-secondary">Urine</span>
                                            </div>
                                            <div class="col col-md-8">
                                                <div class="border rounded p-2 bg-white d-flex align-items-center">
                                                    <i class="bi bi-file-text text-primary me-2"></i>
                                                    <span class="text-secondary small">lab/rsp...</span>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-link text-primary text-decoration-none p-2">
                                                    Preview <i class="bi bi-eye-fill ms-1"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Rontgent Result -->
                                        <div class="row align-items-center mb-3">
                                            <div class="col-3 col-md-2">
                                                <span class="text-secondary">Rontgent</span>
                                            </div>
                                            <div class="col col-md-8">
                                                <div class="border rounded p-2 bg-white d-flex align-items-center">
                                                    <i class="bi bi-file-text text-primary me-2"></i>
                                                    <span class="text-secondary small">hasil/hasil-rontgent...</span>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-link text-primary text-decoration-none p-2">
                                                    Preview <i class="bi bi-eye-fill ms-1"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Histopatology Result -->
                                        <div class="row align-items-center mb-3">
                                            <div class="col-3 col-md-2">
                                                <span class="text-secondary">Histopatology</span>
                                            </div>
                                            <div class="col col-md-8">
                                                <div class="border rounded p-2 bg-white d-flex align-items-center">
                                                    <i class="bi bi-file-text text-primary me-2"></i>
                                                    <span class="text-secondary small">lab/rsp...</span>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-link text-primary text-decoration-none p-2">
                                                    Preview <i class="bi bi-eye-fill ms-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator" style="margin-bottom: 2rem;">
                                    <h5 class="fw-semibold mb-4">7. Disharge Planning</h5>

                                    <div class="mb-3 row align-items-center">
                                        <label class="col-md-3 text-secondary">Diagnosis medis</label>
                                        <div class="col-md-9">
                                            <select class="form-select bg-light">
                                                <option selected>Lokalis nyeri</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row align-items-center">
                                        <label class="col-md-3 text-secondary">Usia lanjut</label>
                                        <div class="col-md-9">
                                            <select class="form-select bg-light">
                                                <option selected>pilih</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row align-items-center">
                                        <label class="col-md-3 text-secondary">Hambatan mobilisasi</label>
                                        <div class="col-md-9">
                                            <select class="form-select bg-light">
                                                <option selected>pilih</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row align-items-center">
                                        <label class="col-md-3 text-secondary">Membutuhkan pelayanan medis
                                            berkelanjutan</label>
                                        <div class="col-md-9">
                                            <select class="form-select bg-light">
                                                <option selected>pilih</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row align-items-center">
                                        <label class="col-md-3 text-secondary">Ketergantungan dengan orang lain dalam
                                            aktivitas harian</label>
                                        <div class="col-md-9">
                                            <select class="form-select bg-light">
                                                <option selected>pilih</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-4 row align-items-center">
                                        <label class="col-md-3 text-secondary">Perkiraan lama hari dirawat</label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="number" class="form-control bg-light" placeholder="Hari">
                                                <span class="input-group-text bg-light">Hari</span>
                                            </div>
                                        </div>
                                        <label class="col-md-2 text-secondary text-end">Rencana Pulang</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light" value="31 Jan 2025"
                                                    readonly>
                                                <span class="input-group-text bg-light">
                                                    <i class="bi bi-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <div class="alert alert-warning mb-2" style="background-color: #fff3cd;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="discharge_planning"
                                                    id="need_special">
                                                <label class="form-check-label" for="need_special">
                                                    Membutuhkan rencana pulang khusus
                                                </label>
                                            </div>
                                        </div>
                                        <div class="alert alert-success mb-2" style="background-color: #d1e7dd;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="discharge_planning"
                                                    id="no_special">
                                                <label class="form-check-label" for="no_special">
                                                    Tidak membutuhkan rencana pulang khusus
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator" style="margin-bottom: 2rem;">
                                    <h5 class="fw-semibold mb-4">8. Diagnosis</h5>

                                    <!-- Diagnosis Banding -->
                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                            diagnosis banding, apabila tidak ada, Pilih tanda tambah untuk menambah
                                            keterangan diagnosis banding yang tidak ditemukan.</small>

                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 ps-0"
                                                placeholder="Cari dan tambah Diagnosis Banding">
                                            <span class="input-group-text bg-white">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>

                                        <div class="diagnosis-list bg-light p-3 rounded">
                                            <div class="diagnosis-item mb-2">
                                                <span>1. Deficit Perawatan Diri (Self-Care Deficit)</span>
                                            </div>
                                            <div class="diagnosis-item">
                                                <span>2. Risiko Infeksi (Risk for Infection)</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Diagnosis Kerja -->
                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                            diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                            diagnosis kerja yang tidak ditemukan.</small>

                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 ps-0"
                                                placeholder="Cari dan tambah Diagnosis Kerja">
                                            <span class="input-group-text bg-white">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>

                                        <div class="diagnosis-list bg-light p-3 rounded">
                                            <div class="diagnosis-item mb-2">
                                                <span>1. Deficit Perawatan Diri (Self-Care Deficit)</span>
                                            </div>
                                            <div class="diagnosis-item">
                                                <span>2. Risiko Infeksi (Risk for Infection)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator" style="margin-bottom: 2rem;">
                                    <h5 class="fw-semibold mb-4">9. Implementasi</h5>

                                    <!-- Rencana Penatalaksanaan dan Pengobatan -->
                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold">Rencana Penatalaksanaan dan
                                            Pengobatan</label>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                            rencana, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan rencana
                                            Penatalaksanaan dan Pengobatan kerja yang tidak ditemukan.</small>

                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 ps-0"
                                                placeholder="Cari dan tambah Observasi">
                                            <span class="input-group-text bg-white">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Observasi Section -->
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2">Observasi</label>
                                        <div class="list-group">
                                            <div
                                                class="list-group-item d-flex justify-content-between align-items-center border-0 ps-0">
                                                <span>1. Monitor pola nafas ( frekuensi, kedalaman, usaha nafas )</span>
                                                <button class="btn btn-link text-danger p-0">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="input-group mt-2">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 ps-0"
                                                placeholder="Cari dan tambah Terapeutik">
                                            <span class="input-group-text bg-white">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Terapeutik Section -->
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2">Terapeutik</label>
                                        <div class="list-group">
                                            <div
                                                class="list-group-item d-flex justify-content-between align-items-center border-0 ps-0">
                                                <span>1. Berikan minum hangat</span>
                                                <button class="btn btn-link text-danger p-0">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                            <div
                                                class="list-group-item d-flex justify-content-between align-items-center border-0 ps-0">
                                                <span>2. Posisikan semi fowler atau fowler</span>
                                                <button class="btn btn-link text-danger p-0">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                            <div
                                                class="list-group-item d-flex justify-content-between align-items-center border-0 ps-0">
                                                <span>3. Perhatikan kepatenan jalan nafas dengan head-tilt dan chin-lift
                                                    (jaw — thrust jika curiga trauma servika)</span>
                                                <button class="btn btn-link text-danger p-0">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="input-group mt-2">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 ps-0"
                                                placeholder="Cari dan tambah Edukasi">
                                            <span class="input-group-text bg-white">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Edukasi Section -->
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2">Edukasi</label>
                                        <div class="list-group">
                                            <div
                                                class="list-group-item d-flex justify-content-between align-items-center border-0 ps-0">
                                                <span>1. Anjuran asupan cairan 2000 ml/hari, jika tidak kontra
                                                    indikasi</span>
                                                <button class="btn btn-link text-danger p-0">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                            <div
                                                class="list-group-item d-flex justify-content-between align-items-center border-0 ps-0">
                                                <span>2. Ajarkan teknik batuk efektif</span>
                                                <button class="btn btn-link text-danger p-0">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="input-group mt-2">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 ps-0"
                                                placeholder="Cari dan tambah Kolaborasi">
                                            <span class="input-group-text bg-white">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Kolaborasi Section -->
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2">Kolaborasi</label>
                                        <div class="list-group">
                                            <div
                                                class="list-group-item d-flex justify-content-between align-items-center border-0 ps-0">
                                                <span>1. Kolaborasi pemberian bronkodilator, ekspektoran, mukolitik, jika
                                                    perlu</span>
                                                <button class="btn btn-link text-danger p-0">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Prognosis Section -->
                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold">Prognosis</label>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                            Prognosis, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                            Prognosis yang tidak ditemukan.</small>

                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 ps-0"
                                                placeholder="Cari dan tambah Prognosis">
                                            <span class="input-group-text bg-white">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>

                                        <div class="list-group">
                                            <div
                                                class="list-group-item d-flex justify-content-between align-items-center border-0 ps-0">
                                                <span>1. Memberikan antibiotik intravena sesuai jadwal</span>
                                                <button class="btn btn-link text-danger p-0">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                            <div
                                                class="list-group-item d-flex justify-content-between align-items-center border-0 ps-0">
                                                <span>2. Mengajarkan pasien cara menggunakan inhaler untuk asma</span>
                                                <button class="btn btn-link text-danger p-0">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                            <div
                                                class="list-group-item d-flex justify-content-between align-items-center border-0 ps-0">
                                                <span>3. Membersihkan luka dengan cairan NaCl dan mengganti balutan setiap
                                                    hari</span>
                                                <button class="btn btn-link text-danger p-0">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator" style="margin-bottom: 2rem;">
                                    <h5 class="fw-semibold mb-4">10. Evaluasi</h5>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tambah Evaluasi Keperawatan</label>
                                        <textarea class="form-control" name="anamnesis" rows="4" placeholder="Evaluasi Keperawaran"></textarea>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary">Simpan</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
