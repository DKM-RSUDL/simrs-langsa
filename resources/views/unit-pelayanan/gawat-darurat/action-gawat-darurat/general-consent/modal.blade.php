<!-- Modal Tambah Resep -->
<div class="modal fade" id="addGeneralConsentModal" tabindex="-1" aria-labelledby="addGeneralConsentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addGeneralConsentModalLabel">Buat General Consent</h5>
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
                                <select name="hubungan_pasien_pj" id="hubungan_pasien_pj" class="form-select" required>
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
                            <p class="fs-4 fw-bold">Identitas Saksi</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_saksi" class="form-label">Nama</label>
                                <input type="text" name="nama_saksi" id="nama_saksi" class="form-control" required>
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
                            <p class="fs-4 fw-bold">I. PERSETUJUAN UNTUK PERAWATAN DAN PENGOBATAN</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <ol>
                                <li>
                                    Saya mengetahui bahwa saya memiliki kondisi yang membutuhkan perawatan medis, saya
                                    mengizinkan dokter dan profesional kesehatan lainnya untuk melakukan prosedur
                                    diagnostik dan untuk memberikan pengobatan medis seperti yang diperlukan dalam
                                    penilaian profesional mereka. Prosedur diagnostik dan perawatan medis termasuk
                                    terapi tidak terbatas pada electrocardiograms, x-ray, tes darah, terapi fisik, dan
                                    pemberian obat
                                </li>
                                <li>
                                    Saya sadar bahwa praktik kedokteran bukanlah ilmu pasti dan saya mengakui bahwa
                                    tidak ada jaminan atas hasil apapun terhadap perawatan prosedur atau pemeriksaan
                                    apapun yang dilakukan terhadap saya
                                </li>
                                <li>
                                    Saya mengerti dan memahami bahwa :
                                    <ol type="a">
                                        <li>
                                            Saya memiliki hak untuk mengajukan pertanyaan tentang pengobatan yang
                                            diusulkan (termasuk identitas setiap orang yang memberikan atau mengamati
                                            pengobatan) setiap saat.
                                        </li>
                                        <li>
                                            Saya mengerti dan memahami bahwa saya memiliki hak untuk menyetujui atau
                                            menolak setiap prosedur medis dan/atau terapi.
                                        </li>
                                        <li>
                                            Saya mengerti bahwa RSUD Langsa merupakan rumah sakit yang menyelenggarakan
                                            pendidikan dan praktik klinik bagi mahasiswa kedokteran dan tenaga
                                            profesional lainnya dan saya bersedia berpartisipasi dan terlibat dalam
                                            perawatan dan pengembangan ilmu pengetahuan dibawah supervisi dokter
                                            penanggungjawab pelayanan (DPJP);
                                        </li>
                                    </ol>
                                </li>
                            </ol>

                            <div class="form-group">
                                <label for="i_status" class="form-label fw-bold">Setuju / Tidak Setuju</label>
                                <select name="i_status" id="i_status" class="form-select" required>
                                    <option value="">--Pilih--</option>
                                    <option value="1">Setuju</option>
                                    <option value="0">Tidak Setuju</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">II. BARANG – BARANG MILIK PASIEN</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p>
                                Rumah Sakit Umum Daerah Langsa tidak memperkenankan pasien/ keluarga
                                membawa
                                barang-barang berharga yang tidak diperlukan ke ruang rawat inap. Pasien yang tidak
                                memiliki
                                keluarga/ tidak mampu untuk melindungi barang-barangnya, atau tidak mampu membuat
                                keputusan
                                mengenai barang pribadinya, RSUD Langsa menyediakan tempat penitipan barang pada pos
                                satpam
                                sesuai dengan peraturan penyimpanan barang milik pasien di RSUD Langsa
                            </p>

                            <div class="form-group">
                                <label for="ii_status" class="form-label fw-bold">Setuju / Tidak Setuju</label>
                                <select name="ii_status" id="ii_status" class="form-select" required>
                                    <option value="">--Pilih--</option>
                                    <option value="1">Setuju</option>
                                    <option value="0">Tidak Setuju</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">III. PERSETUJUAN PELEPASAN INFORMASI</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <ol>
                                <li>
                                    Saya memahami informasi yang ada didalam diri saya termasuk Diagnosis,hasil
                                    laboratorium, dan
                                    hasil tes diagnostik yang akan digunakan untuk perawatan medis. Rumah Sakit Umum
                                    Langsa
                                    akan menjamin kerahasiannya;
                                </li>
                                <li>
                                    Saya memberi wewenang kepada rumah Sakit untuk memberikan informasi tentang
                                    diagnosis
                                    hasil pelayanan dan pengobatan bila diperlukan untuk memproses klaim
                                    <strong>asuransi/BPJS/Jasaraharja/ perusahaan dan atau lembaga pemerintah.</strong>
                                </li>
                                <li>
                                    Saya memberi wewenang kepada RSUD Langsa untuk memberikan informasi tentang
                                    diagnosis, hasil pelayanan dan pengobatan saya kepada:

                                    <ol>
                                        <li>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="iii_nama_1"
                                                            class="form-label fw-bold">Nama</label>
                                                        <input type="text" name="iii_nama_1" id="iii_nama_1"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="iii_hubungan_1"
                                                            class="form-label fw-bold">Hubungan dengan pasien</label>
                                                        <select name="iii_hubungan_1" id="iii_hubungan_1"
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
                                        </li>

                                        <li>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="iii_nama_2"
                                                            class="form-label fw-bold">Nama</label>
                                                        <input type="text" name="iii_nama_2" id="iii_nama_2"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="iii_hubungan_2"
                                                            class="form-label fw-bold">Hubungan dengan pasien</label>
                                                        <select name="iii_hubungan_2" id="iii_hubungan_2"
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
                                        </li>

                                        <li>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="iii_nama_3"
                                                            class="form-label fw-bold">Nama</label>
                                                        <input type="text" name="iii_nama_3" id="iii_nama_3"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="iii_hubungan_3"
                                                            class="form-label fw-bold">Hubungan dengan pasien</label>
                                                        <select name="iii_hubungan_3" id="iii_hubungan_3"
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
                                        </li>
                                    </ol>

                                </li>
                            </ol>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">IV. HAK DAN TANGGUNG JAWAB PASIEN</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">

                            <ol>
                                <li>
                                    Saya memiliki hak untuk mengambil bagian dalam keputusan mengenai penyakit saya dan
                                    dalam
                                    hal perawatan medis dan rencana pengobatan
                                </li>
                                <li>
                                    Saya telah mendapat informasi tentang “HAK DAN TANGGUNG JAWAB PASIEN” di Rumah Sakit
                                    Umum Langsa melalui <strong>leaflet dan banner</strong> yang disediakan oleh
                                    petugas.
                                </li>
                            </ol>

                            <div class="form-group">
                                <label for="iv_status" class="form-label fw-bold">Setuju / Tidak Setuju</label>
                                <select name="iv_status" id="iv_status" class="form-select" required>
                                    <option value="">--Pilih--</option>
                                    <option value="1">Setuju</option>
                                    <option value="0">Tidak Setuju</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">V. KEINGINAN PRIVASI PASIEN</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">

                            <ol>
                                <li>
                                    Saya

                                    <select name="v_status_1" required>
                                        <option value="1">mengijinkan</option>
                                        <option value="0">tidak mengijinkan</option>
                                    </select>

                                    Rumah Sakit memberi akses bagi
                                    keluarga dan handai taulan serta orang – orang yang akan menjenguk saya. (sebutkan
                                    nama /
                                    profesi bila ada permintaan khusus)

                                    <input type="text" name="v_permintaan_1" class="form-control">
                                </li>

                                <li>
                                    Saya

                                    <select name="v_status_2" required>
                                        <option value="0">tidak menginginkan</option>
                                        <option value="1">menginginkan</option>
                                    </select>

                                    privasi khusus. Sebutkan bila ada permintaan privasi khusus.

                                    <input type="text" name="v_permintaan_2" class="form-control">
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">VI. INFORMASI RAWAT INAP</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p>
                                Saya telah menerima informasi tentang peraturan yang diberlakukan oleh rumah sakit dan
                                saya
                                beserta keluarga bersedia untuk mematuhinya, termasuk akan mematuhi jam berkunjung
                                pasien
                                sesuai dengan aturan di rumah sakit.
                            </p>

                            <div class="form-group mt-3">
                                <label for="vi_tambahan" class="form-label fw-bold">Tambahan</label>
                                <textarea name="vi_tambahan" id="vi_tambahan" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">VII. INFORMASI BIAYA</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">

                            <p>
                                Saya menyatakan setuju sebagai pasien dengan status:
                            </p>

                            <ol type="a">
                                <li>
                                    <input type="radio" name="vii_biaya" id="vii_biaya_umum"
                                        class="form-check-input" required>
                                    <label for="vii_biaya_umum">
                                        <strong>STATUS UMUM</strong> dengan membayar total biaya perawatan sesuai dengan
                                        rincian dan ketentuan RSUD Langsa;
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" name="vii_biaya" id="vii_biaya_asuransi"
                                        class="form-check-input" required>
                                    <label for="vii_biaya_asuransi">
                                        <strong>DITANGGUNG PENJAMIN (*BPJS/PLN/JASA-RAHARJA/ </strong> ………) dengan
                                        segera
                                        melengkapi
                                        persyaratan administrasi menurut ketentuan penjamin dan/atau peraturan yang
                                        berlaku (3x
                                        24 jam);
                                    </label>
                                </li>
                                <li>
                                    Apabila saya tidak melengkapi persyaratan pada batas waktu yang ditentukan penjamin
                                    dan/atau peraturan yang berlaku maka saya bersedia membayar seluruh biaya perawatan
                                    yang timbul selama saya dirawat di RSUD Kota Langsa.
                                </li>
                            </ol>

                            <div class="form-group">
                                <label for="vii_status" class="form-label fw-bold">Setuju / Tidak Setuju</label>
                                <select name="vii_status" id="vii_status" class="form-select" required>
                                    <option value="">--Pilih--</option>
                                    <option value="1">Setuju</option>
                                    <option value="0">Tidak Setuju</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">TANDA TANGAN</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <div id='canvasPetugas' class="ttd-canvas"></div>
                            <button type="button" class="btn btn-secondary btn-sm mt-2 "
                                id="resetCanvasPetugas">Reset</button>
                        </div>

                        <div class="col-md-6 mt-3">
                            <div id='canvasPJ' class="ttd-canvas"></div>
                            <button type="button" class="btn btn-secondary btn-sm mt-2 "
                                id="resetCanvasPJ">Reset</button>
                        </div>

                        <div class="col-md-6 mt-3">
                            <div id='canvasSaksi' class="ttd-canvas"></div>
                            <button type="button" class="btn btn-secondary btn-sm mt-2 "
                                id="resetCanvasSaksi">Reset</button>
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
