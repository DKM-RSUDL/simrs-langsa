<div class="d-grid gap-2">
    <button class="btn mb-2 btn-primary" data-bs-toggle="modal" data-bs-target="#extraLargeModal" type="button"><i
            class="ti-plus"></i> Tambah</button>
</div>

<div class="card-body">
    <div class="modal fade" id="extraLargeModal" tabindex="-1" aria-labelledby="extraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="extraLargeModalLabel">Catatan Perkembangan Pasien Terintegrasi (CPPT)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div>
                                <p class="fw-bold">Anamnesis/ Keluhan Utama</p>
                                <div class="bg-secondary-subtle rounded-2">
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="mt-3">
                                <p class="fw-bold">Tanda Vital</p>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="basicInput" class="form-label">TD Sistole</label>
                                        <input type="number" class="form-control" id="basicInput">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="basicInput" class="form-label">TD Diastole</label>
                                        <input type="number" class="form-control" id="basicInput">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="basicInput" class="form-label">Resp (per mnt)</label>
                                        <input type="number" class="form-control" id="basicInput">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="basicInput" class="form-label">Nadi (per mnt)</label>
                                        <input type="number" class="form-control" id="basicInput">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="basicInput" class="form-label">Suhu (C)</label>
                                        <input type="number" class="form-control" id="basicInput">
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <label for="basicInput" class="form-label">SpO2 - tanpa bantuan O2(%)</label>
                                        <input type="number" class="form-control" id="basicInput">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="basicInput" class="form-label">SpO2 - dgn bantuan O2(%)</label>
                                        <input type="number" class="form-control" id="basicInput">
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-3">
                                        <label for="basicInput" class="form-label">TB (cm)</label>
                                        <input type="number" class="form-control" id="basicInput">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="basicInput" class="form-label">BB (Kg)</label>
                                        <input type="number" class="form-control" id="basicInput">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="basicInput" class="form-label">IMT</label>
                                        <input type="text" class="form-control" id="basicInput">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="basicInput" class="form-label">LPT</label>
                                        <input type="text" class="form-control" id="basicInput">
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <label for="basicInput" class="form-label">Gol. Darah</label>
                                        <input type="text" class="form-control" id="basicInput">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <p class="fw-bold">Skala Nyeri</p>
                                    <input type="number" class="form-control" id="basicInput">
                                    <button type="submit" class="btn btn-sm btn-warning mt-2">Nyeri Hebat</button>
                                </div>
                                <div class="col-md-8">
                                    <img src="{{ asset('assets/img/cppt/cppt.jpeg') }}" alt="Descriptive Alt Text"
                                        style="width: 100%; height: auto;">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="lokasi" placeholder="Lokasi">
                                </div>

                                <label for="durasi" class="col-sm-2 col-form-label">Durasi</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="durasi" placeholder="Durasi">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="Pemberat" class="col-sm-2 col-form-label">Pemberat</label>
                                <div class="col-sm-4">
                                    <select class="form-select" id="Pemberat" aria-label="---Pilih---">
                                        <option value="semua" selected>Semua Pemberat</option>
                                        <option value="Pemberat1">Pilihan 1</option>
                                        <option value="Pembera2">Pilihan 2</option>
                                        <option value="Pembera3">Pilihan 3</option>
                                        <option value="Pembera4">Pilihan 4</option>
                                        <option value="Pembera5">Pilihan 5</option>
                                    </select>
                                </div>
                                <label for="Peringan" class="col-sm-2 col-form-label">Peringan</label>
                                <div class="col-sm-4">
                                    <select class="form-select" id="Peringan" aria-label="---Pilih---">
                                        <option value="semua" selected>Semua Peringan</option>
                                        <option value="Peringan1">Pilihan 1</option>
                                        <option value="Peringan2">Pilihan 2</option>
                                        <option value="Peringan3">Pilihan 3</option>
                                        <option value="Peringan4">Pilihan 4</option>
                                        <option value="Peringan5">Pilihan 5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="Kualitas" class="col-sm-2 col-form-label">Kualitas</label>
                                <div class="col-sm-4">
                                    <select class="form-select" id="Kualitas" aria-label="---Pilih---">
                                        <option value="semua" selected>Semua Kualitas</option>
                                        <option value="Kualitas1">Pilihan 1</option>
                                        <option value="Kualitas2">Pilihan 2</option>
                                        <option value="Kualitas3">Pilihan 3</option>
                                        <option value="Kualitas4">Pilihan 4</option>
                                        <option value="Kualitas5">Pilihan 5</option>
                                    </select>
                                </div>
                                <label for="Frekuensi" class="col-sm-2 col-form-label">Frekuensi</label>
                                <div class="col-sm-4">
                                    <select class="form-select" id="Frekuensi" aria-label="---Pilih---">
                                        <option value="semua" selected>Semua Peringan</option>
                                        <option value="Frekuensi1">Pilihan 1</option>
                                        <option value="Frekuensi2">Pilihan 2</option>
                                        <option value="Frekuensi3">Pilihan 3</option>
                                        <option value="Frekuensi4">Pilihan 4</option>
                                        <option value="Frekuensi5">Pilihan 5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="Menjalar" class="col-sm-2 col-form-label">Menjalar</label>
                                <div class="col-sm-4">
                                    <select class="form-select" id="Menjalar" aria-label="---Pilih---">
                                        <option value="semua" selected>Semua Menjalar</option>
                                        <option value="Menjalar1">Pilihan 1</option>
                                        <option value="Menjalar2">Pilihan 2</option>
                                        <option value="Menjalar3">Pilihan 3</option>
                                        <option value="Menjalar4">Pilihan 4</option>
                                        <option value="Menjalar5">Pilihan 5</option>
                                    </select>
                                </div>
                                <label for="Jenis" class="col-sm-2 col-form-label">Jenis</label>
                                <div class="col-sm-4">
                                    <select class="form-select" id="Jenis" aria-label="---Pilih---">
                                        <option value="semua" selected>Semua Jenis </option>
                                        <option value="Jenis1">Pilihan 1</option>
                                        <option value="Jenis2">Pilihan 2</option>
                                        <option value="Jenis3">Pilihan 3</option>
                                        <option value="Jenis4">Pilihan 4</option>
                                        <option value="Jenis5">Pilihan 5</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="row">
                                <p class="fw-bold col-sm-5">Pemeriksaan Fisik</p>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-secondary-subtle rounded-2">
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <p class="fw-bold">Data Objektif Lainnya</p>
                                    <div class="bg-secondary-subtle rounded-2">
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <p class="fw-bold col-sm-5">Asesmen /Diagnosis</p>
                                <div class="col-sm-6">
                                    <!-- Modal 2 -->
                                    {{-- @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.cppt.create-diagnosis') --}}

                                    <a href="#" class=" text-secondary"><i class="bi bi-plus-square"></i>
                                        Tambah</a>
                                    <a href="#" class=" text-secondary"><i class="bi bi-plus-square"></i>
                                        ICD-10</a>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="bg-secondary-subtle rounded-2 p-3">
                                            <a href="#" class="fw-bold">HYPERTENSI KRONIS</a> <br>
                                            <a href="#" class="fw-bold">DYSPEPSIA</a> <br>
                                            <a href="#" class="fw-bold">DEPRESIVE EPISODE</a> <br>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <p class="fw-bold col-sm-12">Planning/ Rencana Tatalaksana</p>
                                <div class="row">
                                    <div class="col-12">
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="checkbox-container">
                                    <div class="input-group">
                                        <input type="checkbox" id="kontrl" name="kontrl">
                                        <label for="kontrl">Kontrol ulang, tgl:</label>
                                    </div>
                                    <div class="input-group">
                                        <input type="checkbox" id="Internal" name="Internal">
                                        <label for="Internal">Konsul/Rujuk Internal Ke:</label>
                                    </div>
                                    <div class="input-group">
                                        <input type="checkbox" id="Selesai" name="Selesai">
                                        <label for="Selesai">Selesai di Klinik ini</label>
                                    </div>

                                    <div class="input-group">
                                        <input type="checkbox" id="Rujuk" name="Rujuk">
                                        <label for="Rujuk">Rujuk RS lain bagian:</label>
                                    </div>
                                    <div class="input-group">
                                        <input type="checkbox" id="RawatInap" name="RawatInap">
                                        <label for="RawatInap">Rawat Inap</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
