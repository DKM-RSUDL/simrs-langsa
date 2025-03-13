<!-- NRS Modal -->
<div class="modal fade" id="nrsModal" tabindex="-1" aria-labelledby="nrsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nrsModalLabel">Scale NRS, VAS, VRS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Berikan pertanyaan kepada pasien dari skala 0 sd 10, untuk skala 0 (nol) tidak nyeri sampai 10
                    (sepuluh) nyeri sangat hebat.</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-4">
                            <div class="d-flex align-items-center gap-3" style="min-width: 350px;">
                                <input type="number"
                                    class="form-control flex-grow-1 @error('nrs_skala_nyeri') is-invalid @enderror"
                                    id="nrs_skala_nyeri" name="nrs_skala_nyeri" style="width: 100px;"
                                    value="{{ old('nrs_skala_nyeri', 0) }}" min="0" max="10">
                                @error('nrs_skala_nyeri')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <button type="button" class="btn btn-sm btn-success" id="skalaNyeriBtn">
                                    Tidak Nyeri
                                </button>
                                <input type="hidden" name="nrs_skala_nyeri_nilai" id="nrs_skala_nyeri_nilai" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Button Controls -->
                        <div class="btn-group mb-3">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-scale="numeric">
                                A. Numeric Rating Pain Scale
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-scale="wong-baker">
                                B. Wong Baker Faces Pain Scale
                            </button>
                        </div>

                        <!-- Pain Scale Images -->
                        <div id="wongBakerScale" class="pain-scale-image flex-grow-1" style="display: none;">
                            <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}" alt="Wong Baker Pain Scale"
                                style="width: 100%; height: auto;">
                        </div>

                        <div id="numericScale" class="pain-scale-image flex-grow-1" style="display: none;">
                            <img src="{{ asset('assets/img/asesmen/numerik.png') }}" alt="Numeric Pain Scale"
                                style="width: 100%; height: auto;">
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

<!-- FLACC Modal -->
<div class="modal fade" id="flaccModal" tabindex="-1" aria-labelledby="flaccModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="flaccModalLabel">Face, Legs, Activity, Cry, Consolability (FLACC)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="informasi mb-3">
                    <p class="text-muted"><i>Informasi: (Skala FLACC dapat digunakan untuk anak usia 2 bulan sd 7
                            tahun)</i></p>
                </div>

                <div id="flaccForm">
                    <!-- 1. WAJAH (FACE) -->
                    <div class="mb-3">
                        <h6 class="fw-bold">1. WAJAH (FACE)</h6>
                        <div class="ms-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input flacc-input" type="radio" name="flacc_face" id="face0"
                                    value="0">
                                <label class="form-check-label" for="face0">
                                    Tersenyum tidak ada ekspresi
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input flacc-input" type="radio" name="flacc_face" id="face1"
                                    value="1">
                                <label class="form-check-label" for="face1">
                                    Kadang meringis, mengerutkan kening, menarik diri, kurang merespond dengan baik/
                                    ekspresi datar
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input flacc-input" type="radio" name="flacc_face" id="face2"
                                    value="2">
                                <label class="form-check-label" for="face2">
                                    Sering cemberut konstan, rahang terkatup, dagu bergetar, kerutan yang dalam di dahi,
                                    mata terkatup, mulut terbuka, garing yang dalam disadari hidung bibir
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- 2. KAKI (LEGS) -->
                    <div class="mb-3">
                        <h6 class="fw-bold">2. KAKI (LEGS)</h6>
                        <div class="ms-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input flacc-input" type="radio" name="flacc_legs" id="legs0"
                                    value="0">
                                <label class="form-check-label" for="legs0">
                                    Posisi normal atau santai
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input flacc-input" type="radio" name="flacc_legs" id="legs1"
                                    value="1">
                                <label class="form-check-label" for="legs1">
                                    Tidak nyaman, gelisah, tegang, tonus meningkat, kaku, fleksi / ekstensi anggota
                                    badan intermiten
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input flacc-input" type="radio" name="flacc_legs" id="legs2"
                                    value="2">
                                <label class="form-check-label" for="legs2">
                                    Menendang atau kaki dinaikkan, hipertonus/fleksi / ekstensi anggota badan secara
                                    berlebihan, tremor
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- 3. AKTIVITAS (ACTIVITY) -->
                    <div class="mb-3">
                        <h6 class="fw-bold">3. AKTIVITAS (ACTIVITY)</h6>
                        <div class="ms-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input flacc-input" type="radio" name="flacc_activity"
                                    id="activity0" value="0">
                                <label class="form-check-label" for="activity0">
                                    Berbaring dengan tenang, posisi normal, bergerak dengan mudah dan bebas
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input flacc-input" type="radio" name="flacc_activity"
                                    id="activity1" value="1">
                                <label class="form-check-label" for="activity1">
                                    Menggeliat, menggeser maju mundur, tegang, ragu-ragu untuk bergerak, menjaga tekanan
                                    pada bagian tubuh
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input flacc-input" type="radio" name="flacc_activity"
                                    id="activity2" value="2">
                                <label class="form-check-label" for="activity2">
                                    Melengkung, kaku, atau menyentak, posisi tetap, goyang, gerakan kepala dari sisi ke
                                    sisi, menggosok bagian tubuh
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- 4. MENANGIS (CRY) -->
                    <div class="mb-3">
                        <h6 class="fw-bold">4. MENANGIS (CRY)</h6>
                        <div class="ms-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input flacc-input" type="radio" name="flacc_cry" id="cry0"
                                    value="0">
                                <label class="form-check-label" for="cry0">
                                    Tidak menangis (pada saat terjaga atau saat tidur)
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input flacc-input" type="radio" name="flacc_cry" id="cry1"
                                    value="1">
                                <label class="form-check-label" for="cry1">
                                    Erangan atau rengekan, sesekali menangis, mendesis, sesekali mengeluh
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input flacc-input" type="radio" name="flacc_cry" id="cry2"
                                    value="2">
                                <label class="form-check-label" for="cry2">
                                    Terus menerus menangis, berteriak, saat nafas, sering mengeluh, sering mengejut
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- 5. KONSOLABILITAS (CONSOLABILITY) -->
                    <div class="mb-3">
                        <h6 class="fw-bold">5. KONSOLABILITAS (CONSOLABILITY)</h6>
                        <div class="ms-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input flacc-input" type="radio" name="flacc_consolability"
                                    id="consolability0" value="0">
                                <label class="form-check-label" for="consolability0">
                                    Tenang, santai dan riang
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input flacc-input" type="radio" name="flacc_consolability"
                                    id="consolability1" value="1">
                                <label class="form-check-label" for="consolability1">
                                    Perlu dijadikan denga perhatian perilaku, menggajak berbicara, Perhatian dapat
                                    dialihkan
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input flacc-input" type="radio" name="flacc_consolability"
                                    id="consolability2" value="2">
                                <label class="form-check-label" for="consolability2">
                                    Sulit untuk dibujuk atau dibuat nyaman
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- JUMLAH SKALA & KESIMPULAN -->
                    <div class="d-flex justify-content-between align-items-center mt-4 p-2 border-top pt-3">
                        <div>
                            <span class="fw-bold">JUMLAH SKALA: </span>
                            <span id="flaccTotal" class="fw-bold">0</span>
                        </div>
                        <div>
                            <span class="fw-bold me-2">KESIMPULAN:</span>
                            <span id="flaccCategory" class="badge bg-success px-3 py-2">NYERI RINGAN</span>
                            <input type="hidden" name="flacc_score" id="flaccScoreInput" value="0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-dark" id="simpanFlacc">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- CRIES Modal -->
<div class="modal fade" id="criesModal" tabindex="-1" aria-labelledby="criesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="criesModalLabel">Crying, Requires, Increased, Expression, Sleepless (CRIES)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="informasi mb-3">
                    <p class="text-muted"><i>Informasi: (Skala CRIES dapat digunakan untuk anak usia 32 minggu sd 60
                            minggu)</i></p>
                </div>

                <div id="criesForm">
                    <!-- 1. MENANGIS (CRY) -->
                    <div class="mb-3">
                        <h6 class="fw-bold">1. MENANGIS (CRY)</h6>
                        <div class="ms-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input cries-input" type="radio" name="cries_cry" id="cry0"
                                    value="0">
                                <label class="form-check-label" for="cry0">
                                    Tidak menangis atau tangisan tidak melelahkan
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input cries-input" type="radio" name="cries_cry" id="cry1"
                                    value="1">
                                <label class="form-check-label" for="cry1">
                                    Tangisan melengking tetapi mudah dihibur
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input cries-input" type="radio" name="cries_cry" id="cry2"
                                    value="2">
                                <label class="form-check-label" for="cry2">
                                    Tangisan melengking dan tidak mudah dihibur
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- 2. KEBUTUHAN OKSIGEN (REQUIRES) -->
                    <div class="mb-3">
                        <h6 class="fw-bold">2. KEBUTUHAN OKSIGEN (REQUIRES)</h6>
                        <div class="ms-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input cries-input" type="radio" name="cries_requires"
                                    id="requires0" value="0">
                                <label class="form-check-label" for="requires0">
                                    Tidak membutuhkan oksigen
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input cries-input" type="radio" name="cries_requires"
                                    id="requires1" value="1">
                                <label class="form-check-label" for="requires1">
                                    Membutuhkan oksigen < 30% </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input cries-input" type="radio" name="cries_requires"
                                    id="requires2" value="2">
                                <label class="form-check-label" for="requires2">
                                    Membutuhkan oksigen > 30%
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- 3. PENINGKATAN TANDA-TANDA VITAL (INCREASED) -->
                    <div class="mb-3">
                        <h6 class="fw-bold">3. PENINGKATAN TANDA-TANDA VITAL (INCREASED)</h6>
                        <div class="ms-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input cries-input" type="radio" name="cries_increased"
                                    id="increased0" value="0">
                                <label class="form-check-label" for="increased0">
                                    Denyut jantung dan TD tidak mengalami perubahan
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input cries-input" type="radio" name="cries_increased"
                                    id="increased1" value="1">
                                <label class="form-check-label" for="increased1">
                                    Denyut jantung dan TD meningkata < 20% dari baseline </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input cries-input" type="radio" name="cries_increased"
                                    id="increased2" value="2">
                                <label class="form-check-label" for="increased2">
                                    Denyut jantung dan TD meningkata > 20% dari baseline
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- 4. WAJAH (EXPRESSION) -->
                    <div class="mb-3">
                        <h6 class="fw-bold">4. WAJAH (EXPRESSION)</h6>
                        <div class="ms-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input cries-input" type="radio" name="cries_expression"
                                    id="expression0" value="0">
                                <label class="form-check-label" for="expression0">
                                    Tidak ada senyum
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input cries-input" type="radio" name="cries_expression"
                                    id="expression1" value="1">
                                <label class="form-check-label" for="expression1">
                                    Seringai ada
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input cries-input" type="radio" name="cries_expression"
                                    id="expression2" value="2">
                                <label class="form-check-label" for="expression2">
                                    Seringai ada dan tidak ada. tangisan dengkur
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- 5. SULIT TIDUR (SLEEPLESS) -->
                    <div class="mb-3">
                        <h6 class="fw-bold">5. SULIT TIDUR (SLEEPLESS)</h6>
                        <div class="ms-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input cries-input" type="radio" name="cries_sleepless"
                                    id="sleepless0" value="0">
                                <label class="form-check-label" for="sleepless0">
                                    Terus menerus tidur
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input cries-input" type="radio" name="cries_sleepless"
                                    id="sleepless1" value="1">
                                <label class="form-check-label" for="sleepless1">
                                    Terbangun pada interval berulang
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input cries-input" type="radio" name="cries_sleepless"
                                    id="sleepless2" value="2">
                                <label class="form-check-label" for="sleepless2">
                                    Terjaga/terbangun terus menerus
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- JUMLAH SKALA & KESIMPULAN -->
                    <div class="d-flex justify-content-between align-items-center mt-4 p-2 border-top pt-3">
                        <div>
                            <span class="fw-bold">JUMLAH SKALA: </span>
                            <span id="criesTotal" class="fw-bold">0</span>
                        </div>
                        <div>
                            <span class="fw-bold me-2">KESIMPULAN:</span>
                            <span id="criesCategory" class="badge bg-success px-3 py-2">NYERI RINGAN</span>
                            <input type="hidden" name="cries_score" id="criesScoreInput" value="0">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-dark" id="simpanCries">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ----- VARIABEL GLOBAL ----- //
        // Elemen-elemen DOM utama
        const jenisSkalaSelect = document.getElementById('jenisSkalaSelect');
        const selectedScaleInfo = document.getElementById('selectedScaleInfo');
        const scaleInfoBtn = document.getElementById('scaleInfoBtn');
        const selectedScaleDisplay = document.getElementById('selectedScaleDisplay');
        const kesimpulanNyeri = document.getElementById('kesimpulanNyeri');
        const kesimpulanNyeriInput = document.getElementById('kesimpulanNyeriInput');
        const skalaNyeriMain = document.getElementById('skala_nyeri_main');

        // Bootstrap Modal objects
        let nrsModal, flaccModal, criesModal;

        // Inisialisasi modals jika elemen ada
        if (document.getElementById('nrsModal')) {
            nrsModal = new bootstrap.Modal(document.getElementById('nrsModal'));
        }
        if (document.getElementById('flaccModal')) {
            flaccModal = new bootstrap.Modal(document.getElementById('flaccModal'));
        }
        if (document.getElementById('criesModal')) {
            criesModal = new bootstrap.Modal(document.getElementById('criesModal'));
        }

        // ----- FUNGSI UTAMA UNTUK SEMUA SKALA ----- //

        // Fungsi untuk menampilkan modal yang sesuai
        function showModalForScale(scale) {
            switch (scale) {
                case 'nrs':
                    if (nrsModal) nrsModal.show();
                    break;
                case 'flacc':
                    if (flaccModal) flaccModal.show();
                    break;
                case 'cries':
                    if (criesModal) criesModal.show();
                    break;
            }
        }

        // Fungsi untuk update kesimpulan nyeri di halaman utama
        function updateKesimpulanNyeri(skalaType, skor, kategori) {
            // Simpan nilai skor ke input hidden utama
            skalaNyeriMain.value = skor;

            // Tampilkan skor skala nyeri yang dipilih
            selectedScaleDisplay.innerHTML = `
                <div class="alert alert-info">
                    <strong>${skalaType}:</strong> Skor ${skor} - ${kategori}
                </div>
            `;
            selectedScaleDisplay.classList.remove('d-none');

            // Update kesimpulan nyeri
            kesimpulanNyeri.textContent = kategori;
            kesimpulanNyeriInput.value = kategori;

            // Update warna background kesimpulan nyeri
            kesimpulanNyeri.className = 'p-3 rounded text-white';

            if (kategori === 'NYERI RINGAN' || kategori === 'Nyeri Ringan' || kategori === 'Tidak Nyeri') {
                kesimpulanNyeri.classList.add('bg-success');
            } else if (kategori === 'NYERI SEDANG' || kategori === 'Nyeri Sedang') {
                kesimpulanNyeri.classList.add('bg-warning');
                kesimpulanNyeri.classList.remove('text-white');
                kesimpulanNyeri.classList.add('text-dark');
            } else {
                kesimpulanNyeri.classList.add('bg-danger');
            }
        }

        // Event listener untuk pemilihan skala
        jenisSkalaSelect.addEventListener('change', function () {
            const selectedValue = this.value;

            if (selectedValue) {
                selectedScaleInfo.classList.remove('d-none');
                showModalForScale(selectedValue);
            } else {
                selectedScaleInfo.classList.add('d-none');
            }
        });

        // Event listener untuk tombol info
        scaleInfoBtn.addEventListener('click', function () {
            const selectedValue = jenisSkalaSelect.value;
            showModalForScale(selectedValue);
        });

        // ----- FUNGSI SKALA NRS ----- //
        const nrsInput = document.getElementById('nrs_skala_nyeri');
        const nrsBtn = document.getElementById('skalaNyeriBtn');
        const nrsNilaiInput = document.getElementById('nrs_skala_nyeri_nilai');
        const simpanNRSBtn = document.getElementById('simpanNRS');

        if (nrsInput && nrsBtn && simpanNRSBtn) {
            // Inisialisasi nilai awal NRS
            updateNRSButton(parseInt(nrsInput.value) || 0);

            // Event handler untuk input NRS
            nrsInput.addEventListener('input', function () {
                let nilai = parseInt(this.value) || 0;

                // Batasi nilai antara 0-10
                nilai = Math.min(Math.max(nilai, 0), 10);
                this.value = nilai;
                nrsNilaiInput.value = nilai;

                updateNRSButton(nilai);
            });

            // Event handler untuk tombol simpan NRS
            simpanNRSBtn.addEventListener('click', function () {
                const nilai = parseInt(nrsInput.value) || 0;
                let kategori;

                if (nilai === 0) {
                    kategori = 'Tidak Nyeri';
                } else if (nilai >= 1 && nilai <= 3) {
                    kategori = 'Nyeri Ringan';
                } else if (nilai >= 4 && nilai <= 6) {
                    kategori = 'Nyeri Sedang';
                } else {
                    kategori = 'Nyeri Berat';
                }

                // Update kesimpulan nyeri di halaman utama
                updateKesimpulanNyeri('NRS', nilai, kategori);

                // Tutup modal
                if (nrsModal) nrsModal.hide();
            });

            // Fungsi untuk update tombol NRS
            function updateNRSButton(nilai) {
                let buttonClass, textNyeri;

                switch (true) {
                    case nilai === 0:
                        buttonClass = 'btn-success';
                        textNyeri = 'Tidak Nyeri';
                        break;
                    case nilai >= 1 && nilai <= 3:
                        buttonClass = 'btn-success';
                        textNyeri = 'Nyeri Ringan';
                        break;
                    case nilai >= 4 && nilai <= 6:
                        buttonClass = 'btn-warning';
                        textNyeri = 'Nyeri Sedang';
                        break;
                    case nilai >= 7 && nilai <= 9:
                        buttonClass = 'btn-danger';
                        textNyeri = 'Nyeri Berat';
                        break;
                    case nilai >= 10:
                        buttonClass = 'btn-danger';
                        textNyeri = 'Nyeri Tak Tertahankan';
                        break;
                }

                nrsBtn.classList.remove('btn-success', 'btn-warning', 'btn-danger');
                nrsBtn.classList.add(buttonClass);
                nrsBtn.textContent = textNyeri;
            }

            // Inisialisasi tombol dan gambar pada modal NRS
            const scaleButtons = document.querySelectorAll('[data-scale]');
            const numericScale = document.getElementById('numericScale');
            const wongBakerScale = document.getElementById('wongBakerScale');

            if (scaleButtons.length && numericScale && wongBakerScale) {
                // Add click event to buttons
                scaleButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        // Remove active class from all buttons
                        scaleButtons.forEach(btn => {
                            btn.classList.remove('btn-primary');
                            btn.classList.add('btn-outline-primary');
                        });

                        // Add active class to clicked button
                        this.classList.remove('btn-outline-primary');
                        this.classList.add('btn-primary');

                        // Hide both images first
                        numericScale.style.display = 'none';
                        wongBakerScale.style.display = 'none';

                        // Show the selected image
                        if (this.dataset.scale === 'numeric') {
                            numericScale.style.display = 'block';
                        } else {
                            wongBakerScale.style.display = 'block';
                        }
                    });
                });

                // Show numeric scale by default
                scaleButtons[0].click();
            }
        }

        // ----- FUNGSI SKALA FLACC ----- //
        const flaccInputs = document.querySelectorAll('.flacc-input');
        const flaccTotal = document.getElementById('flaccTotal');
        const flaccCategory = document.getElementById('flaccCategory');
        const flaccScoreInput = document.getElementById('flaccScoreInput');
        const simpanFlaccBtn = document.getElementById('simpanFlacc');

        if (flaccInputs.length && flaccTotal && flaccCategory && flaccScoreInput && simpanFlaccBtn) {
            // Event listener untuk perubahan nilai FLACC
            flaccInputs.forEach(input => {
                input.addEventListener('change', calculateFlaccScore);
            });

            // Hitung skor FLACC awal
            calculateFlaccScore();

            // Fungsi untuk menghitung skor FLACC
            function calculateFlaccScore() {
                let total = 0;
                let categories = ['flacc_face', 'flacc_legs', 'flacc_activity', 'flacc_cry', 'flacc_consolability'];

                categories.forEach(category => {
                    const selectedInput = document.querySelector(`input[name="${category}"]:checked`);
                    if (selectedInput) {
                        total += parseInt(selectedInput.value) || 0;
                    }
                });

                // Update tampilan skor
                flaccTotal.textContent = total;
                flaccScoreInput.value = total;

                // Update kategori nyeri
                let kategoriFlacc;
                if (total <= 3) {
                    kategoriFlacc = 'NYERI RINGAN';
                    flaccCategory.className = 'badge bg-success px-3 py-2';
                } else if (total <= 6) {
                    kategoriFlacc = 'NYERI SEDANG';
                    flaccCategory.className = 'badge bg-warning text-dark px-3 py-2';
                } else {
                    kategoriFlacc = 'NYERI BERAT';
                    flaccCategory.className = 'badge bg-danger px-3 py-2';
                }

                flaccCategory.textContent = kategoriFlacc;
            }

            // Event listener untuk tombol simpan FLACC
            simpanFlaccBtn.addEventListener('click', function () {
                const skor = flaccTotal.textContent;
                const kategori = flaccCategory.textContent;

                // Update kesimpulan nyeri di halaman utama
                updateKesimpulanNyeri('FLACC', skor, kategori);

                // Tutup modal
                if (flaccModal) flaccModal.hide();
            });
        }

        // ----- FUNGSI SKALA CRIES ----- //
        const criesInputs = document.querySelectorAll('.cries-input');
        const criesTotal = document.getElementById('criesTotal');
        const criesCategory = document.getElementById('criesCategory');
        const criesScoreInput = document.getElementById('criesScoreInput');
        const simpanCriesBtn = document.getElementById('simpanCries');

        if (criesInputs.length && criesTotal && criesCategory && criesScoreInput && simpanCriesBtn) {
            // Event listener untuk perubahan nilai CRIES
            criesInputs.forEach(input => {
                input.addEventListener('change', calculateCriesScore);
            });

            // Hitung skor CRIES awal
            calculateCriesScore();

            // Fungsi untuk menghitung skor CRIES
            function calculateCriesScore() {
                let total = 0;
                let categories = ['cries_cry', 'cries_requires', 'cries_increased', 'cries_expression', 'cries_sleepless'];

                categories.forEach(category => {
                    const selectedInput = document.querySelector(`input[name="${category}"]:checked`);
                    if (selectedInput) {
                        total += parseInt(selectedInput.value) || 0;
                    }
                });

                // Update tampilan skor
                criesTotal.textContent = total;
                criesScoreInput.value = total;

                // Update kategori nyeri
                let kategoriCries;
                if (total <= 3) {
                    kategoriCries = 'NYERI RINGAN';
                    criesCategory.className = 'badge bg-success px-3 py-2';
                } else if (total <= 6) {
                    kategoriCries = 'NYERI SEDANG';
                    criesCategory.className = 'badge bg-warning text-dark px-3 py-2';
                } else {
                    kategoriCries = 'NYERI BERAT';
                    criesCategory.className = 'badge bg-danger px-3 py-2';
                }

                criesCategory.textContent = kategoriCries;
            }

            // Event listener untuk tombol simpan CRIES
            simpanCriesBtn.addEventListener('click', function () {
                const skor = criesTotal.textContent;
                const kategori = criesCategory.textContent;

                // Update kesimpulan nyeri di halaman utama
                updateKesimpulanNyeri('CRIES', skor, kategori);

                // Tutup modal
                if (criesModal) criesModal.hide();
            });
        }

    });
</script>
