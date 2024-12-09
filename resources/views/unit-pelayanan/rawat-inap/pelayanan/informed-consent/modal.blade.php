<!-- Modal Tambah Resep -->
<div class="modal fade" id="addInformedConsentModal" tabindex="-1" aria-labelledby="addInformedConsentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addInformedConsentModalLabel">Buat Informed Consent</h5>
                <button type="button" class="btn-close btn-close-modified" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <form action="#" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam" class="form-label">Jam</label>
                                <input type="time" name="jam" id="jam" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">Informasi Tindakan</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_pemberi_informasi" class="form-label">Nama Pemberi Informasi</label>
                                <input type="text" name="nama_pemberi_informasi" id="nama_pemberi_informasi"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_penerima_informasi" class="form-label">Nama Penerima Informasi</label>
                                <input type="text" name="nama_penerima_informasi" id="nama_penerima_informasi"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_tindakan" class="form-label">Nama Tindakan</label>
                                <textarea name="nama_tindakan" id="nama_tindakan" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">Identitas Yang Bertanda Tangan</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_pj" class="form-label">Nama</label>
                                <input type="text" name="nama_pj" id="nama_pj" class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="tgl_lahir_pj" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir_pj" id="tgl_lahir_pj" class="form-control"
                                    required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="alamat_pj" class="form-label">Alamat</label>
                                <textarea name="alamat_pj" id="alamat_pj" class="form-control" required></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_hp_pj" class="form-label">No HP</label>
                                <input type="number" name="no_hp_pj" id="no_hp_pj" class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="hubungan_pasien_pj" class="form-label">Hubungan Pasien</label>
                                <select name="hubungan_pasien_pj" id="hubungan_pasien_pj" class="form-select"
                                    required>
                                    <option value="">--Pilih--</option>
                                    <option value="0">Diri Sendiri</option>
                                    <option value="1">Orang Tua</option>
                                    <option value="2">Anak</option>
                                    <option value="3">Saudara Kandung</option>
                                    <option value="4">Suami</option>
                                    <option value="5">Istri</option>
                                    <option value="6">Kakek</option>
                                    <option value="7">Nenek</option>
                                    <option value="8">Cucu</option>
                                    <option value="9">Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                </div>

                <!-- Jumlah dan Total di Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('.ttd-canvas').css('background-color', '#bdbdbd');

        // canvas petugas
        let canvasPetugas = $("#canvasPetugas")[0];
        let resetCanvasPetugas = $("#resetCanvasPetugas")[0];

        // Call signature with the root element and the options object, saving its reference in a variable
        let componentPetugas = Signature(canvasPetugas, {
            width: 500,
            height: 100,
            instructions: "Petugas"
        });

        $(resetCanvasPetugas).click(() => {
            componentPetugas.value = [];
        });

        // canvas PJ
        let canvasPJ = $("#canvasPJ")[0];
        let resetCanvasPJ = $("#resetCanvasPJ")[0];

        // Call signature with the root element and the options object, saving its reference in a variable
        let componentPJ = Signature(canvasPJ, {
            width: 500,
            height: 100,
            instructions: "Penanggung Jawab Pasien"
        });

        $(resetCanvasPJ).click(() => {
            componentPJ.value = [];
        });

        // canvas Saksi
        let canvasSaksi = $("#canvasSaksi")[0];
        let resetCanvasSaksi = $("#resetCanvasSaksi")[0];

        // Call signature with the root element and the options object, saving its reference in a variable
        let componentSaksi = Signature(canvasSaksi, {
            width: 500,
            height: 100,
            instructions: "Saksi"
        });

        $(resetCanvasSaksi).click(() => {
            componentSaksi.value = [];
        });
    </script>
@endpush
