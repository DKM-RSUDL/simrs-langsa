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
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="diagnosis" class="form-label">Diagnosis (WD dan DD)</label>
                                <textarea name="diagnosis" id="diagnosis" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="dasar_diagnosis" class="form-label">Dasar Diagnosis</label>
                                <textarea name="dasar_diagnosis" id="dasar_diagnosis" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="tindakan_kedokteran" class="form-label">Tindakan Kedokteran</label>
                                <textarea name="tindakan_kedokteran" id="tindakan_kedokteran" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="indikasi_tindakan" class="form-label">Indikasi Tindakan</label>
                                <textarea name="indikasi_tindakan" id="indikasi_tindakan" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="tata_cara" class="form-label">Tata Cara</label>
                                <textarea name="tata_cara" id="tata_cara" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tujuan" class="form-label">Tujuan</label>
                                <textarea name="tujuan" id="tujuan" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="resiko_komplikasi" class="form-label">Resiko / Komplikasi</label>
                                <textarea name="resiko_komplikasi" id="resiko_komplikasi" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="prognosis" class="form-label">Prognosis</label>
                                <textarea name="prognosis" id="prognosis" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="alternatif" class="form-label">Alternatif</label>
                                <textarea name="alternatif" id="alternatif" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="lainnya" class="form-label">Lain - lain</label>
                                <textarea name="lainnya" id="lainnya" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">Identitas Pasien/Keluarga</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_pj" class="form-label">Nama</label>
                                <input type="text" name="nama_pj" id="nama_pj" class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="umur_pj" class="form-label">Umur</label>
                                <input type="number" name="umur_pj" id="umur_pj" class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="jenis_kelamin_pj" class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin_pj" id="jenis_kelamin_pj" class="form-select" required>
                                    <option value="">--Pilih--</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alamat_pj" class="form-label">Alamat</label>
                                <textarea name="alamat_pj" id="alamat_pj" class="form-control" required></textarea>
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

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">Identitas Saksi 1</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_saksi" class="form-label">Nama</label>
                                <input type="text" name="nama_saksi" id="nama_saksi" class="form-control"
                                    required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="tgl_lahir_saksi" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir_saksi" id="tgl_lahir_saksi"
                                    class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="alamat_saksi" class="form-label">Alamat</label>
                                <textarea name="alamat_saksi" id="alamat_saksi" class="form-control" required></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_hp_saksi" class="form-label">No HP</label>
                                <input type="number" name="no_hp_saksi" id="no_hp_saksi" class="form-control"
                                    required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="hubungan_pasien_saksi" class="form-label">Hubungan Pasien</label>
                                <select name="hubungan_pasien_saksi" id="hubungan_pasien_saksi" class="form-select"
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

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">Identitas Saksi 2</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_saksi_2" class="form-label">Nama</label>
                                <input type="text" name="nama_saksi_2" id="nama_saksi_2" class="form-control">
                            </div>

                            <div class="form-group mt-3">
                                <label for="tgl_lahir_saksi_2" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir_saksi_2" id="tgl_lahir_saksi_2"
                                    class="form-control">
                            </div>

                            <div class="form-group mt-3">
                                <label for="alamat_saksi_2" class="form-label">Alamat</label>
                                <textarea name="alamat_saksi_2" id="alamat_saksi_2" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_hp_saksi_2" class="form-label">No HP</label>
                                <input type="number" name="no_hp_saksi_2" id="no_hp_saksi_2" class="form-control">
                            </div>

                            <div class="form-group mt-3">
                                <label for="hubungan_pasien_saksi_2" class="form-label">Hubungan Pasien</label>
                                <select name="hubungan_pasien_saksi_2" id="hubungan_pasien_saksi_2"
                                    class="form-select">
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

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">Persetujuan/Penolakan</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="petugas_telah_memberi_informasi" class="form-label">Petugas/Dokter telah
                                    menerangkan informasi</label>
                                <select name="petugas_telah_memberi_informasi" id="petugas_telah_memberi_informasi"
                                    class="form-select" required>
                                    <option value="">--Pilih--</option>
                                    <option value="1">Sudah</option>
                                    <option value="0">Belum</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status_persetujuan_tindakan" class="form-label">Status Persetujuan
                                    Pasien/Keluarga</label>
                                <select name="status_persetujuan_tindakan" id="status_persetujuan_tindakan"
                                    class="form-select" required>
                                    <option value="">--Pilih--</option>
                                    <option value="1">Setuju</option>
                                    <option value="0">Menolak</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">TANDA TANGAN PASIEN/KELUARGA</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <div id='canvasPJ' class="ttd-canvas"></div>
                            <button type="button" class="btn btn-secondary btn-sm mt-2 "
                                id="resetCanvasPJ">Reset</button>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div id='canvasSaksi1' class="ttd-canvas"></div>
                            <button type="button" class="btn btn-secondary btn-sm mt-2 "
                                id="resetCanvasSaksi1">Reset</button>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div id='canvasSaksi2' class="ttd-canvas"></div>
                            <button type="button" class="btn btn-secondary btn-sm mt-2 "
                                id="resetCanvasSaksi2">Reset</button>
                        </div>
                    </div>

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

        // canvas Saksi 1
        let canvasSaksi1 = $("#canvasSaksi1")[0];
        let resetCanvasSaksi1 = $("#resetCanvasSaksi1")[0];

        // Call signature with the root element and the options object, saving its reference in a variable
        let componentSaksi1 = Signature(canvasSaksi1, {
            width: 500,
            height: 100,
            instructions: "Saksi 1"
        });

        $(resetCanvasSaksi1).click(() => {
            componentSaksi1.value = [];
        });


        // canvas Saksi 2
        let canvasSaksi2 = $("#canvasSaksi2")[0];
        let resetCanvasSaksi2 = $("#resetCanvasSaksi2")[0];

        // Call signature with the root element and the options object, saving its reference in a variable
        let componentSaksi2 = Signature(canvasSaksi2, {
            width: 500,
            height: 100,
            instructions: "Saksi 2"
        });

        $(resetCanvasSaksi2).click(() => {
            componentSaksi2.value = [];
        });
    </script>
@endpush
