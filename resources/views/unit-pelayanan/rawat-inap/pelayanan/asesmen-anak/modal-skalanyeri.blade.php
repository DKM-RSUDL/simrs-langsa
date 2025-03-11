<!-- Modal NRS -->
<div class="modal fade" id="modalNRS" tabindex="-1" aria-labelledby="modalNRSLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">NYERI SKALA : NUMERIC RATING SCALE (NRS)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-4">Berikan pertanyaan kepada pasien dari skala 0 sd 10, untuk skala 0 (nol) tidak nyeri sampai 10 (sepuluh) nyeri sangat hebat.</p>
                
                <!-- Nilai Nyeri Input -->
                <div class="mb-4">
                    <label class="form-label">NILAI NYERI:</label>
                    <div class="d-flex align-items-center gap-3">
                        <input type="number" class="form-control" id="nrs_value" min="0" max="10" style="width: 30%;">
                        <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}" alt="Skala Nyeri" class="img-fluid" style="max-width: 70%;">
                    </div>
                </div>

                <!-- Kesimpulan Section -->
                <div class="mb-4">
                    <label class="form-label">KESIMPULAN:</label>
                    <div id="nrs_kesimpulan" class="alert alert-info">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-emoji-smile fs-4"></i>
                            <span>Pilih nilai nyeri terlebih dahulu</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="simpanNRS">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal FLACC -->
<div class="modal fade" id="modalFLACC" tabindex="-1" aria-labelledby="modalFLACCLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">NYERI SKALA : FACE, LEGS, ACTIVITY, CRY, CONSOLABILITY (FLACC)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-4">Informasi: (skala FLACC dapat digunakan untuk anak usia 2 bulan sd 7 tahun)</p>

                <!-- 1. WAJAH -->
                <div class="mb-4">
                    <h6 class="mb-3">1. WAJAH (FACE)</h6>
                    <div class="ms-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input flacc-check" type="checkbox" name="wajah[]" value="0" data-category="wajah" id="wajah1">
                            <label class="form-check-label" for="wajah1">Tersenyum tidak ada ekspresi</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input flacc-check" type="checkbox" name="wajah[]" value="1" data-category="wajah" id="wajah2">
                            <label class="form-check-label" for="wajah2">Kadang meringis, mengerutkan kening, menarik diri, kurang merespond dengan baik/ekspresi datar</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input flacc-check" type="checkbox" name="wajah[]" value="2" data-category="wajah" id="wajah3">
                            <label class="form-check-label" for="wajah3">Sering cemberut konstan, rahang terkutup, dagu bergetar, kerutan yang dalam di dahi, mata tertutup, mulut terbuka, garing yang dalam disekitar hidung/ bibir</label>
                        </div>
                    </div>
                </div>

                <!-- 2. KAKI -->
                <div class="mb-4">
                    <h6 class="mb-3">2. KAKI (LEG)</h6>
                    <div class="ms-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input flacc-check" type="checkbox" name="kaki[]" value="0" data-category="kaki" id="kaki1">
                            <label class="form-check-label" for="kaki1">Posisi normal atau santai</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input flacc-check" type="checkbox" name="kaki[]" value="1" data-category="kaki" id="kaki2">
                            <label class="form-check-label" for="kaki2">Tidak nyaman, gelisah, tegang, tonus meningkat, kaku, fleksi / ekstensi anggota badan intermiten</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input flacc-check" type="checkbox" name="kaki[]" value="2" data-category="kaki" id="kaki3">
                            <label class="form-check-label" for="kaki3">Menendang atau kaki disusun, hipertonisitas fleksi / ekstensi anggota badan secara berlebihan, tremor</label>
                        </div>
                    </div>
                </div>

                <!-- 3. AKTIVITAS -->
                <div class="mb-4">
                    <h6 class="mb-3">3. AKTIVITAS (ACTIVITY)</h6>
                    <div class="ms-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input flacc-check" type="checkbox" name="aktivitas[]" value="0" data-category="aktivitas" id="aktivitas1">
                            <label class="form-check-label" for="aktivitas1">Berbaring dengan tenang, posisi normal, bergerak dengan mudah dan bebas</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input flacc-check" type="checkbox" name="aktivitas[]" value="1" data-category="aktivitas" id="aktivitas2">
                            <label class="form-check-label" for="aktivitas2">Menggeliat, menggeser maju mundur, tegang, ragu-ragu untuk bergerak, menjaga, tekanan pada bagian tubuh</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input flacc-check" type="checkbox" name="aktivitas[]" value="2" data-category="aktivitas" id="aktivitas3">
                            <label class="form-check-label" for="aktivitas3">Melengkung, kaku, atau menyentak, posisi tetap, goyang, gerakan kepala dari sisi ke sisi, menggosokan bagian tubuh</label>
                        </div>
                    </div>
                </div>

                <!-- 4. MENANGIS -->
                <div class="mb-4">
                    <h6 class="mb-3">4. MENANGIS (CRY)</h6>
                    <div class="ms-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input flacc-check" type="checkbox" name="menangis[]" value="1" data-category="menangis" id="menangis1">
                            <label class="form-check-label" for="menangis1">Tidak menangis (pada saat terjaga atau saat tidur)</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input flacc-check" type="checkbox" name="menangis[]" value="2" data-category="menangis" id="menangis2">
                            <label class="form-check-label" for="menangis2">Erangan atau rengakan, sesekali menangis, mendesah, sesekali mengeluh</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input flacc-check" type="checkbox" name="menangis[]" value="3" data-category="menangis" id="menangis3">
                            <label class="form-check-label" for="menangis3">Terus menerus menangis, menjerit, isak tangis, menggerang, menggerarn, sering mengeluh</label>
                        </div>
                    </div>
                </div>

                <!-- 5. KONSOLABILITAS -->
                <div class="mb-4">
                    <h6 class="mb-3">5. KONSOLABILITAS (CONSOLABILITY)</h6>
                    <div class="ms-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input flacc-check" type="checkbox" name="konsolabilitas[]" value="1" data-category="konsolabilitas" id="konsolabilitas1">
                            <label class="form-check-label" for="konsolabilitas1">Tenang, santai dan riang</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input flacc-check" type="checkbox" name="konsolabilitas[]" value="2" data-category="konsolabilitas" id="konsolabilitas2">
                            <label class="form-check-label" for="konsolabilitas2">Perlu diyakinkan dengan sentuhan pelukan, mengajak berbicara, Perhatian dapat dialihkan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input flacc-check" type="checkbox" name="konsolabilitas[]" value="3" data-category="konsolabilitas" id="konsolabilitas3">
                            <label class="form-check-label" for="konsolabilitas3">Sulit untuk dibujuk atau dibuat nyaman</label>
                        </div>
                    </div>
                </div>

                <!-- TOTAL & KESIMPULAN -->
                <div class="mt-4">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2">
                                <label class="form-label mb-0">JUMLAH SKALA:</label>
                                <input type="text" class="form-control" name="flaccTotal" id="flaccTotal" readonly style="width: 80px;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex align-items-center gap-2">
                                <label class="form-label mb-0">KESIMPULAN:</label>
                                <div id="flaccKesimpulan" class="alert alert-info py-1 px-3 mb-0">Pilih semua kategori terlebih dahulu</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="simpanFLACC">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal CRIES -->
<div class="modal fade" id="modalCRIES" tabindex="-1" aria-labelledby="modalCRIESLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">NYERI SKALA : CRYING, REQUIRES, INCREASED, EXPRESSION, SLEEPLESS (CRIES)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-4">Informasi: (skala CRIES dapat digunakan untuk anak usia 32 minggu sd 60 minggu)</p>

                <!-- 1. MENANGIS -->
                <div class="mb-4">
                    <h6 class="mb-3">1. MENANGIS (CRY)</h6>
                    <div class="ms-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="menangis[]" value="1" data-category="menangis" id="cries_menangis1">
                            <label class="form-check-label" for="cries_menangis1">Tidak menangis atau tangisan tidak melengking</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="menangis[]" value="2" data-category="menangis" id="cries_menangis2">
                            <label class="form-check-label" for="cries_menangis2">Tangisan melengking tetapi mudah dihibur</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input cries-check" type="checkbox" name="menangis[]" value="3" data-category="menangis" id="cries_menangis3">
                            <label class="form-check-label" for="cries_menangis3">Tangisan melengking dan tidak mudah dihibur</label>
                        </div>
                    </div>
                </div>

                <!-- 2. KEBUTUHAN OKSIGEN -->
                <div class="mb-4">
                    <h6 class="mb-3">2. KEBUTUHAN OKSIGEN (REQUIRES)</h6>
                    <div class="ms-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="oksigen[]" value="1" data-category="oksigen" id="cries_oksigen1">
                            <label class="form-check-label" for="cries_oksigen1">Tidak membutuhkan oksigen</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="oksigen[]" value="2" data-category="oksigen" id="cries_oksigen2">
                            <label class="form-check-label" for="cries_oksigen2">Membutuhkan oksigen < 30%</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input cries-check" type="checkbox" name="oksigen[]" value="3" data-category="oksigen" id="cries_oksigen3">
                            <label class="form-check-label" for="cries_oksigen3">Membutuhkan oksigen > 30%</label>
                        </div>
                    </div>
                </div>

                <!-- 3. PENINGKATAN TANDA VITAL -->
                <div class="mb-4">
                    <h6 class="mb-3">3. PENINGKATAN TANDA-TANDA VITAL (INCREASED)</h6>
                    <div class="ms-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="vital[]" value="1" data-category="vital" id="cries_vital1">
                            <label class="form-check-label" for="cries_vital1">Berdenyut jantung dan TD tidak mengalami perubahan</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="vital[]" value="2" data-category="vital" id="cries_vital2">
                            <label class="form-check-label" for="cries_vital2">Denyut jantung dan TD meningkata < 20% dari baseline</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input cries-check" type="checkbox" name="vital[]" value="3" data-category="vital" id="cries_vital3">
                            <label class="form-check-label" for="cries_vital3">Denyut jantung dan TD meningkata > 20% dari baseline</label>
                        </div>
                    </div>
                </div>

                <!-- 4. WAJAH -->
                <div class="mb-4">
                    <h6 class="mb-3">4. WAJAH (EXPRESSION)</h6>
                    <div class="ms-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="wajah[]" value="1" data-category="wajah" id="cries_wajah1">
                            <label class="form-check-label" for="cries_wajah1">Tidak ada seringai</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="wajah[]" value="2" data-category="wajah" id="cries_wajah2">
                            <label class="form-check-label" for="cries_wajah2">Seringai ada</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input cries-check" type="checkbox" name="wajah[]" value="3" data-category="wajah" id="cries_wajah3">
                            <label class="form-check-label" for="cries_wajah3">Seringai ada dan tidak ada tangisan dengkur</label>
                        </div>
                    </div>
                </div>

                <!-- 5. SULIT TIDUR -->
                <div class="mb-4">
                    <h6 class="mb-3">5. SULIT TIDUR (SLEEPLESS)</h6>
                    <div class="ms-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="tidur[]" value="1" data-category="tidur" id="cries_tidur1">
                            <label class="form-check-label" for="cries_tidur1">Terus menerus tidur</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="tidur[]" value="2" data-category="tidur" id="cries_tidur2">
                            <label class="form-check-label" for="cries_tidur2">Terbangun pada interval berulang</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input cries-check" type="checkbox" name="tidur[]" value="3" data-category="tidur" id="cries_tidur3">
                            <label class="form-check-label" for="cries_tidur3">Terjaga/terbangun terus menerus</label>
                        </div>
                    </div>
                </div>

                <!-- TOTAL & KESIMPULAN -->
                <div class="mt-4">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2">
                                <label class="form-label mb-0">JUMLAH SKALA:</label>
                                <input type="text" class="form-control" name="criesTotal" id="criesTotal" readonly style="width: 80px;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex align-items-center gap-2">
                                <label class="form-label mb-0">KESIMPULAN:</label>
                                <div id="criesKesimpulan" class="alert alert-info py-1 px-3 mb-0">Pilih semua kategori terlebih dahulu</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="simpanCRIES">Simpan</button>
            </div>
        </div>
    </div>
</div>