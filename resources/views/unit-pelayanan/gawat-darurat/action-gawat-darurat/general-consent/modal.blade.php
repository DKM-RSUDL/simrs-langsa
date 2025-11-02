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
            <form
                action="{{ route('general-consent.store', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                method="post" enctype="multipart/form-data">
                @csrf

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
                                <label for="pj_nama" class="form-label">Nama</label>
                                <input type="text" name="pj_nama" id="pj_nama" class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="pj_tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="pj_tgl_lahir" id="pj_tgl_lahir" class="form-control"
                                    required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="pj_alamat" class="form-label">Alamat</label>
                                <textarea name="pj_alamat" id="pj_alamat" class="form-control" required></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pj_nohp" class="form-label">No HP</label>
                                <input type="number" name="pj_nohp" id="pj_nohp" class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="pj_hubungan_pasien" class="form-label">Hubungan Pasien</label>
                                <select name="pj_hubungan_pasien" id="pj_hubungan_pasien" class="form-select" required>
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
                                <label for="saksi_nama" class="form-label">Nama</label>
                                <input type="text" name="saksi_nama" id="saksi_nama" class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="saksi_tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="saksi_tgl_lahir" id="saksi_tgl_lahir"
                                    class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="saksi_alamat" class="form-label">Alamat</label>
                                <textarea name="saksi_alamat" id="saksi_alamat" class="form-control" required></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="saksi_nohp" class="form-label">No HP</label>
                                <input type="number" name="saksi_nohp" id="saksi_nohp" class="form-control"
                                    required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="saksi_hubungan_pasien" class="form-label">Hubungan Pasien</label>
                                <select name="saksi_hubungan_pasien" id="saksi_hubungan_pasien" class="form-select"
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
                                <label for="setuju_perawatan" class="form-label fw-bold">Setuju / Tidak Setuju</label>
                                <select name="setuju_perawatan" id="setuju_perawatan" class="form-select" required>
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
                                <label for="setuju_barang" class="form-label fw-bold">Setuju / Tidak Setuju</label>
                                <select name="setuju_barang" id="setuju_barang" class="form-select" required>
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
                                                        <label for="info_nama_1"
                                                            class="form-label fw-bold">Nama</label>
                                                        <input type="text" name="info_nama_1" id="info_nama_1"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="info_hubungan_pasien_1"
                                                            class="form-label fw-bold">Hubungan dengan pasien</label>
                                                        <select name="info_hubungan_pasien_1"
                                                            id="info_hubungan_pasien_1" class="form-select">
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
                                                        <label for="info_nama_2"
                                                            class="form-label fw-bold">Nama</label>
                                                        <input type="text" name="info_nama_2" id="info_nama_2"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="info_hubungan_pasien_2"
                                                            class="form-label fw-bold">Hubungan dengan pasien</label>
                                                        <select name="info_hubungan_pasien_2"
                                                            id="info_hubungan_pasien_2" class="form-select">
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
                                                        <label for="info_nama_3"
                                                            class="form-label fw-bold">Nama</label>
                                                        <input type="text" name="info_nama_3" id="info_nama_3"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="info_hubungan_pasien_3"
                                                            class="form-label fw-bold">Hubungan dengan pasien</label>
                                                        <select name="info_hubungan_pasien_3"
                                                            id="info_hubungan_pasien_3" class="form-select">
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
                                <label for="setuju_hak" class="form-label fw-bold">Setuju / Tidak Setuju</label>
                                <select name="setuju_hak" id="setuju_hak" class="form-select" required>
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

                                    <select name="setuju_akses_privasi" required>
                                        <option value="1">mengijinkan</option>
                                        <option value="0">tidak mengijinkan</option>
                                    </select>

                                    Rumah Sakit memberi akses bagi
                                    keluarga dan handai taulan serta orang – orang yang akan menjenguk saya. (sebutkan
                                    nama /
                                    profesi bila ada permintaan khusus)

                                    <input type="text" name="akses_privasi_keterangan" class="form-control">
                                </li>

                                <li>
                                    Saya

                                    <select name="setuju_privasi_khusus" required>
                                        <option value="0">tidak menginginkan</option>
                                        <option value="1">menginginkan</option>
                                    </select>

                                    privasi khusus. Sebutkan bila ada permintaan privasi khusus.

                                    <input type="text" name="privasi_khusus_keterangan" class="form-control">
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
                                <label for="rawat_inap_keterangan" class="form-label fw-bold">Tambahan</label>
                                <textarea name="rawat_inap_keterangan" id="rawat_inap_keterangan" class="form-control"></textarea>
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
                                    <input type="radio" name="biaya_status" id="vii_biaya_umum"
                                        class="form-check-input" value="1" required>
                                    <label for="vii_biaya_umum">
                                        <strong>STATUS UMUM</strong> dengan membayar total biaya perawatan sesuai dengan
                                        rincian dan ketentuan RSUD Langsa;
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" name="biaya_status" id="vii_biaya_asuransi"
                                        class="form-check-input" value="2" required>
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
                                <label for="biaya_setuju" class="form-label fw-bold">Setuju / Tidak Setuju</label>
                                <select name="biaya_setuju" id="biaya_setuju" class="form-select" required>
                                    <option value="">--Pilih--</option>
                                    <option value="1">Setuju</option>
                                    <option value="0">Tidak Setuju</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="border-bottom border-primary mt-3"></div>

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
                    </div> --}}
                </div>

                <!-- Jumlah dan Total di Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <x-button-submit />
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Show Resep -->
<div class="modal fade" id="showGeneralConsentModal" tabindex="-1" aria-labelledby="showGeneralConsentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="showGeneralConsentModalLabel">General Consent</h5>
                <button type="button" class="btn-close btn-close-modified" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal" class="form-label">Tanggal dan Jam</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jam" class="form-label">Jam</label>
                            <input type="time" name="jam" id="jam" class="form-control" disabled>
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
                            <label for="pj_nama" class="form-label">Nama</label>
                            <input type="text" name="pj_nama" id="pj_nama" class="form-control" disabled>
                        </div>

                        <div class="form-group mt-3">
                            <label for="pj_tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="pj_tgl_lahir" id="pj_tgl_lahir" class="form-control"
                                disabled>
                        </div>

                        <div class="form-group mt-3">
                            <label for="pj_alamat" class="form-label">Alamat</label>
                            <textarea name="pj_alamat" id="pj_alamat" class="form-control" disabled></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pj_nohp" class="form-label">No HP</label>
                            <input type="number" name="pj_nohp" id="pj_nohp" class="form-control" disabled>
                        </div>

                        <div class="form-group mt-3">
                            <label for="pj_hubungan_pasien" class="form-label">Hubungan Pasien</label>
                            <select name="pj_hubungan_pasien" id="pj_hubungan_pasien" class="form-select" disabled>
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
                            <label for="saksi_nama" class="form-label">Nama</label>
                            <input type="text" name="saksi_nama" id="saksi_nama" class="form-control" disabled>
                        </div>

                        <div class="form-group mt-3">
                            <label for="saksi_tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="saksi_tgl_lahir" id="saksi_tgl_lahir" class="form-control"
                                disabled>
                        </div>

                        <div class="form-group mt-3">
                            <label for="saksi_alamat" class="form-label">Alamat</label>
                            <textarea name="saksi_alamat" id="saksi_alamat" class="form-control" disabled></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="saksi_nohp" class="form-label">No HP</label>
                            <input type="number" name="saksi_nohp" id="saksi_nohp" class="form-control" disabled>
                        </div>

                        <div class="form-group mt-3">
                            <label for="saksi_hubungan_pasien" class="form-label">Hubungan Pasien</label>
                            <select name="saksi_hubungan_pasien" id="saksi_hubungan_pasien" class="form-select"
                                disabled>
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
                            <label for="setuju_perawatan" class="form-label fw-bold">Setuju / Tidak Setuju</label>
                            <select name="setuju_perawatan" id="setuju_perawatan" class="form-select" disabled>
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
                            <label for="setuju_barang" class="form-label fw-bold">Setuju / Tidak Setuju</label>
                            <select name="setuju_barang" id="setuju_barang" class="form-select" disabled>
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
                                                    <label for="info_nama_1" class="form-label fw-bold">Nama</label>
                                                    <input type="text" name="info_nama_1" id="info_nama_1"
                                                        class="form-control" disabled>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="info_hubungan_pasien_1"
                                                        class="form-label fw-bold">Hubungan dengan pasien</label>
                                                    <select name="info_hubungan_pasien_1" id="info_hubungan_pasien_1"
                                                        class="form-select" disabled>
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
                                                    <label for="info_nama_2" class="form-label fw-bold">Nama</label>
                                                    <input type="text" name="info_nama_2" id="info_nama_2"
                                                        class="form-control" disabled>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="info_hubungan_pasien_2"
                                                        class="form-label fw-bold">Hubungan dengan pasien</label>
                                                    <select name="info_hubungan_pasien_2" id="info_hubungan_pasien_2"
                                                        class="form-select" disabled>
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
                                                    <label for="info_nama_3" class="form-label fw-bold">Nama</label>
                                                    <input type="text" name="info_nama_3" id="info_nama_3"
                                                        class="form-control" disabled>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="info_hubungan_pasien_3"
                                                        class="form-label fw-bold">Hubungan dengan pasien</label>
                                                    <select name="info_hubungan_pasien_3" id="info_hubungan_pasien_3"
                                                        class="form-select" disabled>
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
                            <label for="setuju_hak" class="form-label fw-bold">Setuju / Tidak Setuju</label>
                            <select name="setuju_hak" id="setuju_hak" class="form-select" disabled>
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

                                <select name="setuju_akses_privasi" disabled>
                                    <option value="1">mengijinkan</option>
                                    <option value="0">tidak mengijinkan</option>
                                </select>

                                Rumah Sakit memberi akses bagi
                                keluarga dan handai taulan serta orang – orang yang akan menjenguk saya. (sebutkan
                                nama /
                                profesi bila ada permintaan khusus)

                                <input type="text" name="akses_privasi_keterangan" class="form-control" disabled>
                            </li>

                            <li>
                                Saya

                                <select name="setuju_privasi_khusus" disabled>
                                    <option value="0">tidak menginginkan</option>
                                    <option value="1">menginginkan</option>
                                </select>

                                privasi khusus. Sebutkan bila ada permintaan privasi khusus.

                                <input type="text" name="privasi_khusus_keterangan" class="form-control" disabled>
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
                            <label for="rawat_inap_keterangan" class="form-label fw-bold">Tambahan</label>
                            <textarea name="rawat_inap_keterangan" id="rawat_inap_keterangan" class="form-control" disabled></textarea>
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
                                <input type="radio" name="biaya_status" id="vii_biaya_umum"
                                    class="form-check-input" value="1" disabled>
                                <label for="vii_biaya_umum">
                                    <strong>STATUS UMUM</strong> dengan membayar total biaya perawatan sesuai dengan
                                    rincian dan ketentuan RSUD Langsa;
                                </label>
                            </li>
                            <li>
                                <input type="radio" name="biaya_status" id="vii_biaya_asuransi"
                                    class="form-check-input" value="2" disabled>
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
                            <label for="biaya_setuju" class="form-label fw-bold">Setuju / Tidak Setuju</label>
                            <select name="biaya_setuju" id="biaya_setuju" class="form-select" disabled>
                                <option value="">--Pilih--</option>
                                <option value="1">Setuju</option>
                                <option value="0">Tidak Setuju</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Jumlah dan Total di Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
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

        $(canvasPetugas).mouseup(function(e) {
            setTimeout(() => {

                // Dapatkan data tanda tangan
                const dataURLpetugas = componentPetugas.getImage().split(',')[1];

                // Konversi ke file
                const blobBinaryPetugas = atob(dataURLpetugas);
                const arrayPetugas = [];

                for (let i = 0; i < blobBinaryPetugas.length; i++) {
                    arrayPetugas.push(blobBinaryPetugas.charCodeAt(i));
                }

                const filePetugas = new File([new Uint8Array(arrayPetugas)], 'signature-petugas.png', {
                    type: 'image/png'
                });

                // Buat DataTransfer object
                const dataTransferPetugas = new DataTransfer();
                dataTransferPetugas.items.add(filePetugas);

                // Masukkan ke input file
                $('#ttd_petugas').prop('files', dataTransferPetugas.files);

            }, 1000);
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


        $(canvasPJ).mouseup(function(e) {
            setTimeout(() => {

                // Dapatkan data tanda tangan
                const dataURLpj = componentPJ.getImage().split(',')[1];

                // Konversi ke file
                const blobBinaryPj = atob(dataURLpj);
                const arrayPj = [];

                for (let i = 0; i < blobBinaryPj.length; i++) {
                    arrayPj.push(blobBinaryPj.charCodeAt(i));
                }

                const filePj = new File([new Uint8Array(arrayPj)], 'signature-pj.png', {
                    type: 'image/png'
                });

                // Buat DataTransfer object
                const dataTransferPj = new DataTransfer();
                dataTransferPj.items.add(filePj);

                // Masukkan ke input file
                $('#ttd_pj').prop('files', dataTransferPj.files);

            }, 1000);
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


        $(canvasSaksi).mouseup(function(e) {
            setTimeout(() => {

                // Dapatkan data tanda tangan
                const dataURLsaksi = componentSaksi.getImage().split(',')[1];

                // Konversi ke file
                const blobBinarySaksi = atob(dataURLsaksi);
                const arraySaksi = [];

                for (let i = 0; i < blobBinarySaksi.length; i++) {
                    arraySaksi.push(blobBinarySaksi.charCodeAt(i));
                }

                const fileSaksi = new File([new Uint8Array(arraySaksi)], 'signature-saksi.png', {
                    type: 'image/png'
                });

                // Buat DataTransfer object
                const dataTransferSaksi = new DataTransfer();
                dataTransferSaksi.items.add(fileSaksi);

                // Masukkan ke input file
                $('#ttd_saksi').prop('files', dataTransferSaksi.files);

            }, 1000);
        });
    </script>
@endpush
