<div class="d-grid gap-2">
    <button class="btn mb-2 btn-primary" data-bs-toggle="modal" data-bs-target="#extraLargeModal" type="button">
        <i class="ti-plus"></i> Tambah
    </button>
</div>

<div class="modal fade" id="extraLargeModal" tabindex="-1" aria-labelledby="extraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="extraLargeModalLabel">Catatan Perkembangan Pasien Terintegrasi (CPPT)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <p class="fw-bold">
                                    Anamnesis/ Keluhan Utama
                                    <label for="anamnesis"></label>
                                </p>
                                <textarea class="form-control" id="anamnesis" required></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <p class="fw-bold">Tanda Vital</p>
                                <div class="row">

                                    @foreach ($tandaVital as $item)
                                        <div class="col-md-4">
                                            <label for="kondisi{{ $item->id_kondisi }}" class="form-label">{{ $item->kondisi }}</label>
                                            <input type="number" name="tanda_vital[]" class="form-control" id="kondisi{{ $item->id_kondisi }}" required>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="fw-bold">
                                            Skala Nyeri
                                            <label for="skala_nyeri"></label>
                                        </p>
                                        <input type="number" name="skala_nyeri" class="form-control" id="skala_nyeri" required>
                                        <button type="button" class="btn btn-sm btn-warning mt-2" id="skalaNyeriBtn">Nyeri Hebat</button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <img src="{{ asset('assets/img/cppt/cppt.jpeg') }}" alt="Descriptive Alt Text"
                                        style="width: 100%; height: auto;">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="lokasi" placeholder="Lokasi" required>
                                </div>

                                <label for="durasi" class="col-sm-2 col-form-label">Durasi</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="durasi" placeholder="Durasi" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="pemberat" class="col-sm-2 col-form-label">Pemberat</label>
                                <div class="col-sm-4">
                                    <select class="form-select" name="pemberat" id="pemberat" aria-label="---Pilih---" required>
                                        <option value="">--Pilih--</option>
                                        @foreach ($faktorPemberat as $pemberat)
                                            <option value="{{ $pemberat->id }}">{{ $pemberat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <label for="peringan" class="col-sm-2 col-form-label">Peringan</label>
                                <div class="col-sm-4">
                                    <select class="form-select" name="peringan" id="peringan" aria-label="---Pilih---" required>
                                        <option value="">--Pilih--</option>
                                        @foreach ($faktorPeringan as $peringan)
                                            <option value="{{ $peringan->id }}">{{ $peringan->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="kualitas_nyeri" class="col-sm-2 col-form-label">Kualitas</label>
                                <div class="col-sm-4">
                                    <select class="form-select" name="kualitas_nyeri" id="kualitas_nyeri" aria-label="---Pilih---" required>
                                        <option value="">--Pilih--</option>
                                        @foreach ($kualitasNyeri as $kualitas)
                                            <option value="{{ $kualitas->id }}">{{ $kualitas->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="frekuensi_nyeri" class="col-sm-2 col-form-label">Frekuensi</label>
                                <div class="col-sm-4">
                                    <select class="form-select" name="frekuensi_nyeri" id="frekuensi_nyeri" aria-label="---Pilih---" required>
                                        <option value="">--Pilih--</option>
                                        @foreach ($frekuensiNyeri as $frekuensi)
                                            <option value="{{ $frekuensi->id }}">{{ $frekuensi->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="menjalar" class="col-sm-2 col-form-label">Menjalar</label>
                                <div class="col-sm-4">
                                    <select class="form-select" name="menjalar" id="menjalar" aria-label="---Pilih---" required>
                                        <option value="">--Pilih--</option>
                                        @foreach ($menjalar as $mjlr)
                                            <option value="{{ $mjlr->id }}">{{ $mjlr->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="jenis_nyeri" class="col-sm-2 col-form-label">Jenis</label>
                                <div class="col-sm-4">
                                    <select class="form-select" name="jenis_nyeri" id="jenis_nyeri" aria-label="---Pilih---" required>
                                        <option value="">--Pilih--</option>
                                        @foreach ($jenisNyeri as $jenis)
                                            <option value="{{ $jenis->id }}">{{ $jenis->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="row">
                                <p class="fw-bold col-sm-5">
                                    Pemeriksaan Fisik
                                    <label for="pemeriksaan_fisik"></label>
                                </p>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-secondary-subtle rounded-2">
                                        <textarea class="form-control" name="pemeriksaan_fisik" id="pemeriksaan_fisik" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <p class="fw-bold">
                                        Data Objektif Lainnya
                                        <label for="data_objektif"></label>
                                    </p>
                                    <div class="bg-secondary-subtle rounded-2">
                                        <textarea class="form-control" name="data_objektif" id="data_objektif" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <p class="fw-bold col-sm-5">Asesmen /Diagnosis</p>
                                <div class="col-sm-6">
                                    <!-- Modal 2 -->
                                    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.cppt.create-diagnosis')
                                    <a href="#" class="btn btn-sm"><i class="bi bi-plus-square"></i>
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
                                <p class="fw-bold col-sm-12">
                                    Planning/ Rencana Tatalaksana
                                    <label for="planning"></label>
                                </p>
                                <div class="row">
                                    <div class="col-12">
                                        <textarea class="form-control" name="planning" id="planning" required></textarea>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
