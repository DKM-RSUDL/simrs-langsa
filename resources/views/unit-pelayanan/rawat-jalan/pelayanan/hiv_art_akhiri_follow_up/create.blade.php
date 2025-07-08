@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art_akhiri_follow_up.include')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Patient Card -->
            <div class="col-lg-3 col-md-4 mb-4">
                @include('components.patient-card')
            </div>

            <!-- Main Form -->
            <div class="col-lg-9 col-md-8">
                <div class="d-flex align-items-center mb-3">
                    <a href="{{ route('rawat-jalan.hiv_art_akhir_follow_up.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                        class="btn btn-outline-primary btn-sm me-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <form id="praAnestesiForm" method="POST"
                    action="{{ route('rawat-jalan.hiv_art_akhir_follow_up.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                    @csrf

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h5 class="mb-0 font-weight-bold">IKHTISAR FOLLOW-UP PERAWATAN PASIEN HIV DAN TERAPI
                                ANTIRETROVIRAL (ART)
                            </h5>
                        </div>

                        <div class="card-body p-4">
                            <div class="main-wrapper">
                                <!-- Progress Indicator -->
                                <div class="progress-indicator">
                                    <div class="progress-bar-custom">
                                        <div class="progress-fill" id="progressFill"></div>
                                    </div>
                                </div>

                                <!-- Toolbar -->
                                <div class="toolbar">
                                    <div class="visit-counter" id="visitCounter">
                                        <i class="fas fa-calendar-check me-2"></i>0 Kunjungan
                                    </div>
                                    <button type="button" class="btn btn-add-visit" onclick="addNewVisit()">
                                        <i class="fas fa-plus me-2"></i>Tambah Kunjungan Baru
                                    </button>
                                </div>

                                <!-- Info Card -->
                                <div class="form-container">
                                    <div class="info-card">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-info-circle text-primary me-3" style="font-size: 1.5rem;"></i>
                                            <div>
                                                <h6 class="mb-1">Panduan Pengisian Form</h6>
                                                <p class="mb-0">Isi data untuk setiap kunjungan follow-up pasien HIV. Field
                                                    berwarna kuning akan muncul otomatis jika Anda memilih "Ya" pada
                                                    pertanyaan
                                                    tertentu.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form -->
                                    <form id="hivArtForm">
                                        <div id="visitContainer">
                                            <!-- Visit cards akan ditambahkan di sini -->
                                        </div>
                                    </form>

                                    <!-- Legend -->
                                    <div class="legend-section">
                                        <h5 class="legend-title">
                                            <i class="fas fa-book"></i>Petunjuk & Kode
                                        </h5>
                                        <div class="legend-grid">
                                            <div class="legend-item">
                                                <h6><i class="fas fa-calendar-check me-2"></i>Tanggal Kunjungan [Kolom 1]</h6>
                                                <p>Tulis tanggal kunjungan yang sebenarnya sejak kunjungan pertama perawatan HIV</p>
                                            </div>

                                            <div class="legend-item">
                                                <h6><i class="fas fa-baby me-2"></i>Status Kehamilan [Kolom 7]</h6>
                                                <p>1 = Kehamilan baru</p>
                                                <p>2 = Kehamilan lama</p>
                                                <p>3 = Tidak hamil</p>
                                            </div>

                                            <div class="legend-item">
                                                <h6><i class="fas fa-virus me-2"></i>Infeksi Oportunistik [Kolom 8]</h6>
                                                <p>K = Kandidiasis | D = Diare cryptosporidia</p>
                                                <p>Cr = Meningitis cryptocococal | PCP = Pneumonia Pneumocystis</p>
                                                <p>CMV = Cytomegalovirus | P = Peniciliosis</p>
                                                <p>Z = Herpes zoster | S = Herpessimpleks</p>
                                                <p>T = Toxoplasmosis | H = Hepatitis</p>
                                                <p>Lain² = uraikan</p>
                                            </div>

                                            <div class="legend-item">
                                                <h6><i class="fas fa-lungs me-2"></i>Status TB [Kolom 10]</h6>
                                                <p>1 = Tdk ada gejala/tanda TB</p>
                                                <p>2 = Suspek TB (rujuk ke klinik DOTS atau pemeriksaan sputum)</p>
                                                <p>3 = Dalam terapi TB</p>
                                                <p>4 = Tidak dilakukan skrining</p>
                                            </div>

                                            <div class="legend-item">
                                                <h6><i class="fas fa-shield-alt me-2"></i>PPK [Kolom 11]</h6>
                                                <p>Pengobatan Pencegahan dengan Kotrimoksazol</p>
                                            </div>

                                            <div class="legend-item">
                                                <h6><i class="fas fa-pills me-2"></i>PP INH [Kolom 11]</h6>
                                                <p>Pengobatan Pencegahan dengan INH (Isoniazid)</p>
                                                <p><strong>Hasil Akhir PP INH:</strong></p>
                                                <p>1 = Serobat | 2 = Gagal sedalam PP INH</p>
                                                <p>3 = Pindah | 4 = Meninggal | 5 = Efek samping Berat</p>
                                            </div>

                                            <div class="legend-item">
                                                <h6><i class="fas fa-prescription-bottle-alt me-2"></i>Adherence ART [Kolom 14]</h6>
                                                <p>Perkiraan adherence dgn menanyakan apakah pasien melupakan dosis obat.</p>
                                                <p><strong>Tingkat adherence:</strong></p>
                                                <p>1 = (>95%) artinya < 3 dosis lupa diminum dalam 30 hari</p>
                                                <p>2 = (80-95%) artinya 3-12 dosis lupa diminum dalam 30 hari</p>
                                                <p>3 = (<80%) artinya >12 dosis lupa diminum dalam 30 hari</p>
                                                <p>Jika paduan ART yang diberikan terdiri dari berbagai dosis, maka pilihlah adherence obat yang terjelek</p>
                                            </div>

                                            <div class="legend-item">
                                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Efek Samping [Kolom 15]</h6>
                                                <p>R = Ruam kulit | Mua = Mual | Mun = Muntah</p>
                                                <p>D = Diare | N = Neuropati | Ikt = Ikterus</p>
                                                <p>An = Anemi</p>
                                                <p>Li = Lelah | SK = Sakit kepala | Dem = Demam</p>
                                                <p>Hip = Hipersensitifitas | Dep = Depresi</p>
                                                <p>P = Pankreatitis | Lip = Lipodistrof</p>
                                                <p>Ngan = Mengantuk | Ln = Lain² - uraikan</p>
                                            </div>

                                            <div class="legend-item">
                                                <h6><i class="fas fa-flag-checkered me-2"></i>Akhir Follow Up [Kolom 20]</h6>
                                                <p><strong>M</strong> = jika pasien meninggal → tulis tanggal meninggal</p>
                                                <p><strong>LFU</strong> = jika pasien >3 bulan tidak datang ke layanan → tulis tanggal terakhir</p>
                                                <p><strong>RK</strong> = jika pasien dirujuk keluar → tulis tanggal rujuk keluar dan nama klinik barunya</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Buttons -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>

@endsection

@push('js')
    <script>
        let visitCount = 0; // Mulai dari 0 karena akan ditambah di addNewVisit

        // Fungsi untuk menambah kunjungan baru
        function addNewVisit() {
            visitCount++;
            updateVisitCounter();
            updateProgressBar();

            const container = document.getElementById('visitContainer');
            const visitCard = document.createElement('div');
            visitCard.className = 'visit-card';
            visitCard.setAttribute('data-visit', visitCount);

            // Tentukan apakah tombol hapus ditampilkan (tidak tampil untuk kunjungan pertama)
            const removeButton = visitCount === 1 ? '' : `
            <button type="button" class="btn btn-remove" onclick="removeVisit(${visitCount})">
                <i class="fas fa-trash-alt me-1"></i>Hapus
            </button>
        `;

            visitCard.innerHTML = `
            <div class="visit-header">
                <div class="visit-title">
                    <div class="visit-number">${visitCount}</div>
                    <div>
                        <h5 class="mb-0">Kunjungan Follow-Up #${visitCount}</h5>
                        <small class="opacity-75">Data kunjungan pasien HIV/ART</small>
                    </div>
                </div>
                ${removeButton}
            </div>

            <div class="form-section">
                <!-- Section 1: Informasi Kunjungan -->
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="section-title">Informasi Kunjungan</h3>
                </div>

                <div class="two-col">
                    <div class="form-group">
                        <label class="form-label">Tanggal Kunjungan Follow-Up</label>
                        <input type="date" name="tanggal_kunjungan_${visitCount}" class="form-control">
                        <div class="help-text">Masukkan tanggal kunjungan yang sebenarnya</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Rencana Tanggal Kunjungan y.a.d.?</label>
                        <input type="date" name="tanggal_rencana_${visitCount}" class="form-control">
                    </div>
                </div>

                <!-- Section 2: Status Rujukan -->
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <h3 class="section-title">Status Rujukan Pasien</h3>
                </div>

                <div class="two-col">
                    <div class="form-group">
                        <label class="form-label">Apakah pasien merupakan rujukan masuk?</label>
                        <select name="pasien_rujuk_masuk_${visitCount}" class="form-select" onchange="toggleRujukanFields(this, ${visitCount})">
                            <option value="">-- Pilih --</option>
                            <option value="ya">Ya, pasien rujukan</option>
                            <option value="tidak">Tidak, pasien langsung</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" id="rujukan_container_${visitCount}" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Nama Klinik ART Sebelumnya</label>
                            <input type="text" name="nama_klinik_art_${visitCount}" id="nama_klinik_art_${visitCount}"
                                    class="form-control" placeholder="Masukkan nama klinik ART sebelumnya">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dengan ART</label>
                            <input type="text" name="dengan_art_${visitCount}" id="dengan_art_${visitCount}"
                            class="form-control" placeholder="Masukkan dengan ART">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Data Fisik & Klinis -->
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-weight"></i>
                    </div>
                    <h3 class="section-title">Data Fisik & Status Klinis</h3>
                </div>

                <div class="four-col">
                    <div class="form-group">
                        <label class="form-label">Berat Badan</label>
                        <div class="input-group">
                            <input type="number" name="bb_${visitCount}" class="form-control" step="0.1" placeholder="0">
                            <span class="input-group-text">kg</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tinggi Badan (untuk anak)</label>
                        <div class="input-group">
                            <input type="number" name="tb_${visitCount}" class="form-control" step="0.1" placeholder="0">
                            <span class="input-group-text">cm</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status Fungsional</label>
                        <select name="status_fungsional_${visitCount}" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="1">1 - Kerja</option>
                            <option value="2">2 - Ambulatori</option>
                            <option value="3">3 - Baring</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Stadium Klinis</label>
                        <input type="text" name="stad_klinis_${visitCount}" class="form-control">
                    </div>
                </div>

                <div class="two-col">
                    <div class="form-group">
                        <label class="form-label">Hamil</label>
                        <select name="hamil_${visitCount}" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="1">1 - Hamilan Baru</option>
                            <option value="2">2 - Kehamilan Lama</option>
                            <option value="3">3 - Tidak Hamil</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Infeksi Opportunistik</label>
                        <select name="infeksi_opportunistik_${visitCount}" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="K">K - kandidiasis</option>
                            <option value="D">D - Diare Cryptosporidia</option>
                            <option value="Cr">Cr - Meningitis Cryptocococal</option>
                            <option value="PCP">PCP - Pneumonia Pneumocystis</option>
                            <option value="CMV">CMV - Cytomeg alovirus</option>
                            <option value="P">P - Peniciliosis</option>
                            <option value="Z">Z - Herpes Zoster</option>
                            <option value="S">S - Herpessimpleks</option>
                            <option value="T">T - Toxoplasmosis</option>
                            <option value="H">H - Hepatitis</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="two-col">
                    <div class="form-group">
                        <label class="form-label">Obat untuk IO</label>
                        <input type="text" name="obat_io_${visitCount}" class="form-control">
                    </div>
                </div>

                <!-- Section 4: Status TB -->
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-lungs"></i>
                    </div>
                    <h3 class="section-title">Status (TB)</h3>
                </div>

                <div class="two-col">
                    <div class="form-group">
                        <label class="form-label">Status TB</label>
                        <select name="status_tb_${visitCount}" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="1">1 - Tidak ada gejala/tanda TB</option>
                            <option value="2">2 - Suspek TB (rujuk DOTS)</option>
                            <option value="3">3 - Dalam terapi TB</option>
                            <option value="4">4 - Tidak dilakukan skrining</option>
                        </select>
                    </div>
                </div>

                <!-- Section 5: Pengobatan Pencegahan -->
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-pills"></i>
                    </div>
                    <h3 class="section-title">Pengobatan Pencegahan (PP INH)</h3>
                </div>

                <div class="three-col">
                    <div class="form-group">
                        <label class="form-label">Apakah mendapat PP INH?</label>
                        <select name="pp_inh_${visitCount}" class="form-select" onchange="toggleField(this, 'pp_inh_kode_${visitCount}')">
                            <option value="">-- Pilih --</option>
                            <option value="ya">Ya</option>
                            <option value="tidak">Tidak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Apakah mendapat PPK?</label>
                        <select name="ppk_${visitCount}" class="form-select" onchange="toggleField(this, 'ppk_hasil_${visitCount}')">
                            <option value="">-- Pilih --</option>
                            <option value="ya">Ya</option>
                            <option value="tidak">Tidak</option>
                        </select>
                        <div class="help-text">PPK = Pengobatan Pencegahan Kotrimoksazol</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Hasil Akhir PP INH</label>
                        <select name="pp_inh_hasil_${visitCount}" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="1">1 - Serobat</option>
                            <option value="2">2 - Gagal</option>
                            <option value="3">3 - Pindah</option>
                            <option value="4">4 - Meninggal</option>
                            <option value="5">5 - Efek samping</option>
                        </select>
                    </div>
                </div>

                <div class="two-col">
                    <div class="form-group">
                        <input type="text" name="pp_inh_kode_${visitCount}" id="pp_inh_kode_${visitCount}"
                               class="form-control conditional-field" placeholder="Masukkan kode PP INH">
                    </div>
                    <div class="form-group">
                        <input type="text" name="ppk_hasil_${visitCount}" id="ppk_hasil_${visitCount}"
                               class="form-control conditional-field" placeholder="Hasil akhir PPK">
                    </div>
                </div>

                <!-- Section 6: Obat ARV -->
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-prescription-bottle-alt"></i>
                    </div>
                    <h3 class="section-title">Obat ARV & Adherence</h3>
                </div>

                <div class="form-group">
                    <label class="form-label">Obat ARV dan Dosis yang Diberikan</label>
                    <textarea name="obat_arv_${visitCount}" class="form-control" rows="3"
                              placeholder="Contoh: TDF+3TC+EFV 1x1 tablet per hari"></textarea>
                    <div class="help-text">Tuliskan nama obat dan dosis lengkap</div>
                </div>

                <div class="three-col">
                    <div class="form-group">
                        <label class="form-label">Sisa Obat ART</label>
                        <input type="text" name="sisa_obat_${visitCount}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Adherence ART</label>
                        <select name="adherence_art_${visitCount}" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="1">1 - Sangat Baik (>95%)</option>
                            <option value="2">2 - Baik (80-95%)</option>
                            <option value="3">3 - Kurang (<80%)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Efek Samping ART</label>
                        <input type="text" name="efek_samping_${visitCount}" class="form-control">
                    </div>
                </div>

                <!-- Section 7: Laboratorium -->
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-flask"></i>
                    </div>
                    <h3 class="section-title">Hasil Laboratorium</h3>
                </div>

                <div class="two-col">
                    <div class="form-group">
                        <label class="form-label">Jumlah CD4</label>
                        <div class="input-group">
                            <input type="number" name="cd4_${visitCount}" class="form-control" placeholder="0">
                            <span class="input-group-text">sel/mm³</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Hasil Lab</label>
                        <input type="text" name="hasil_lab_${visitCount}" class="form-control"
                               placeholder="Hasil pemeriksaan lab lain">
                    </div>
                </div>

                <!-- Section 8: Follow-Up & Rujukan -->
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <h3 class="section-title">Follow-Up & Rujukan</h3>
                </div>

                <div class="two-col">
                    <div class="form-group">
                        <label class="form-label">Diberikan Kondom?</label>
                        <select name="diberikan_kondom_${visitCount}" class="form-select" onchange="toggleField(this, 'diberikan_kondom_detail_${visitCount}')">
                            <option value="">-- Pilih --</option>
                            <option value="ya">Ya</option>
                            <option value="tidak">Tidak</option>
                            <option value="tt">TT - Tidak Tersedia</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Apakah dirujuk ke spesialis (MRS)?</label>
                        <input type="text" name="rujuk_spesialis_${visitCount}" class="form-control">
                    </div>
                </div>

                <div class="two-col">
                    <div class="form-group">
                        <input type="text" name="diberikan_kondom_detail_${visitCount}" id="diberikan_kondom_detail_${visitCount}"
                               class="form-control conditional-field" placeholder="tuliskan jumlah">
                    </div>
                </div>

                <!-- Section 9: Akhir Follow-Up -->
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-flag-checkered"></i>
                    </div>
                    <h3 class="section-title">Status Akhir Follow-Up</h3>
                </div>

                <div class="two-col">
                    <div class="form-group">
                        <label class="form-label">Status Akhir Follow-Up</label>
                        <select name="akhir_followup_${visitCount}" class="form-select" onchange="toggleField(this, 'akhir_detail_${visitCount}')">
                            <option value="">-- Pilih --</option>
                            <option value="aktif">Aktif - Masih dalam perawatan</option>
                            <option value="m">M - Meninggal</option>
                            <option value="lfu">LFU - Lost Follow Up</option>
                            <option value="rk">RK - Rujuk Keluar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catatan Kunjungan</label>
                        <textarea name="catatan_${visitCount}" class="form-control" rows="3"
                                  placeholder="Catatan kondisi pasien, efek samping, atau rencana tindak lanjut..."></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <input type="text" name="akhir_detail_${visitCount}" id="akhir_detail_${visitCount}"
                           class="form-control conditional-field"
                           placeholder="Detail: tanggal meninggal / tanggal terakhir datang / tempat rujuk">
                    <div class="help-text">Isi sesuai status yang dipilih di atas</div>
                </div>
            </div>
        `;

            container.appendChild(visitCard);

            // Smooth scroll to new card
            setTimeout(() => {
                visitCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 100);

            // Add fade-in animation
            visitCard.style.opacity = '0';
            visitCard.style.transform = 'translateY(20px)';
            setTimeout(() => {
                visitCard.style.transition = 'all 0.5s ease';
                visitCard.style.opacity = '1';
                visitCard.style.transform = 'translateY(0)';
            }, 10);
        }

        // Fungsi untuk menghapus kunjungan (tidak bisa hapus kunjungan pertama)
        function removeVisit(visitId) {
            // Cegah penghapusan kunjungan pertama
            if (visitId === 1) {
                alert('Kunjungan pertama tidak bisa dihapus!');
                return;
            }

            if (confirm('Apakah Anda yakin ingin menghapus data kunjungan ini?')) {
                const card = document.querySelector(`[data-visit="${visitId}"]`);
                if (card) {
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(-20px)';

                    setTimeout(() => {
                        card.remove();
                        updateVisitCounter();
                        updateProgressBar();
                        renumberVisits();
                    }, 300);
                }
            }
        }

        // Fungsi untuk mengupdate nomor kunjungan setelah penghapusan
        function renumberVisits() {
            const cards = document.querySelectorAll('.visit-card');
            visitCount = 0;

            cards.forEach((card, index) => {
                const newNumber = index + 1;
                visitCount = Math.max(visitCount, newNumber);

                const visitNumber = card.querySelector('.visit-number');
                const visitTitle = card.querySelector('.visit-title h5');
                const removeButton = card.querySelector('.btn-remove');

                if (visitNumber) visitNumber.textContent = newNumber;
                if (visitTitle) visitTitle.textContent = `Kunjungan Follow-Up #${newNumber}`;

                // Update data-visit attribute
                const oldDataVisit = card.getAttribute('data-visit');
                card.setAttribute('data-visit', newNumber);

                // Update all form field names and IDs
                const inputs = card.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    if (input.name) {
                        input.name = input.name.replace(/_\d+$/, `_${newNumber}`);
                    }
                    if (input.id) {
                        input.id = input.id.replace(/_\d+$/, `_${newNumber}`);
                    }
                });

                // Update onclick functions
                if (removeButton) {
                    if (newNumber === 1) {
                        // Hapus tombol hapus untuk kunjungan pertama
                        removeButton.style.display = 'none';
                    } else {
                        removeButton.style.display = 'block';
                        removeButton.onclick = () => removeVisit(newNumber);
                    }
                }

                // Update onchange functions
                const selectsWithOnchange = card.querySelectorAll('select[onchange]');
                selectsWithOnchange.forEach(select => {
                    const onchangeAttr = select.getAttribute('onchange');
                    if (onchangeAttr) {
                        // Handle special case for rujukan fields
                        if (onchangeAttr.includes('toggleRujukanFields')) {
                            select.setAttribute('onchange', `toggleRujukanFields(this, ${newNumber})`);
                        } else {
                            const newOnchange = onchangeAttr.replace(/_\d+/g, `_${newNumber}`);
                            select.setAttribute('onchange', newOnchange);
                        }
                    }
                });

                // Update IDs for containers
                const rujukanContainer = card.querySelector('[id^="rujukan_container_"]');
                if (rujukanContainer) {
                    rujukanContainer.id = `rujukan_container_${newNumber}`;
                }
            });
        }

        // Fungsi untuk toggle field conditional
        function toggleField(selectElement, targetId) {
            const targetField = document.getElementById(targetId);
            if (!targetField) return;

            if (selectElement.value === 'ya') {
                targetField.classList.add('show');
                targetField.required = true;
                targetField.focus();
            } else {
                targetField.classList.remove('show');
                targetField.required = false;
                targetField.value = '';
            }
        }

        // Fungsi khusus untuk toggle rujukan fields (2 input sekaligus)
        function toggleRujukanFields(selectElement, visitCount) {
            const container = document.getElementById(`rujukan_container_${visitCount}`);
            const namaKlinikField = document.getElementById(`nama_klinik_art_${visitCount}`);
            const denganArtField = document.getElementById(`dengan_art_${visitCount}`);

            if (!container) return;

            if (selectElement.value === 'ya') {
                container.style.display = 'block';
                if (namaKlinikField) {
                    namaKlinikField.required = true;
                }
                if (denganArtField) {
                    denganArtField.required = true;
                }
                // Focus pada field pertama
                if (namaKlinikField) {
                    setTimeout(() => namaKlinikField.focus(), 100);
                }
            } else {
                container.style.display = 'none';
                if (namaKlinikField) {
                    namaKlinikField.required = false;
                    namaKlinikField.value = '';
                }
                if (denganArtField) {
                    denganArtField.required = false;
                    denganArtField.value = '';
                }
            }
        }

        // Fungsi untuk update visit counter
        function updateVisitCounter() {
            const actualCount = document.querySelectorAll('.visit-card').length;
            document.getElementById('visitCounter').innerHTML =
                `<i class="fas fa-calendar-check me-2"></i>${actualCount} Kunjungan`;
        }

        // Fungsi untuk update progress bar
        function updateProgressBar() {
            const actualCount = document.querySelectorAll('.visit-card').length;
            const progress = Math.min((actualCount / 5) * 100, 100); // Max 100% at 5 visits
            document.getElementById('progressFill').style.width = progress + '%';
        }

        // Fungsi untuk menampilkan toast
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');

            if (toast && toastMessage) {
                toastMessage.textContent = message;
                toast.className = `toast ${type}`;
                toast.classList.add('show');

                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            }
        }

        // Fungsi untuk mendapatkan teks status
        function getStatusText(status) {
            const statusMap = {
                'aktif': 'Aktif dalam perawatan',
                'm': 'Meninggal',
                'lfu': 'Lost Follow Up',
                'rk': 'Rujuk Keluar'
            };
            return statusMap[status] || status;
        }

        // Auto-save draft functionality
        let autoSaveTimer;
        function autoSave() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(() => {
                const form = document.getElementById('hivArtForm');
                if (form) {
                    const formData = new FormData(form);
                    const data = {};

                    for (let [key, value] of formData.entries()) {
                        if (value.trim()) {
                            data[key] = value;
                        }
                    }

                    localStorage.setItem('hivArtDraft', JSON.stringify(data));
                }
            }, 2000);
        }

        // Fungsi untuk load draft
        function loadDraft() {
            const draft = localStorage.getItem('hivArtDraft');
            if (draft) {
                try {
                    const data = JSON.parse(draft);

                    // Count visits needed
                    const visitNumbers = new Set();
                    Object.keys(data).forEach(key => {
                        const match = key.match(/_(\d+)$/);
                        if (match) {
                            visitNumbers.add(parseInt(match[1]));
                        }
                    });

                    // Add visits (dimulai dari 1 karena kunjungan pertama sudah ada)
                    const maxVisit = Math.max(...visitNumbers);
                    for (let i = 2; i <= maxVisit; i++) {
                        addNewVisit();
                    }

                    // Fill data
                    setTimeout(() => {
                        Object.keys(data).forEach(name => {
                            const field = document.querySelector(`[name="${name}"]`);
                            if (field) {
                                field.value = data[name];

                                // Trigger change for conditional fields
                                if (field.onchange) {
                                    field.onchange();
                                }
                            }
                        });
                        showToast('Draft data berhasil dimuat');
                    }, 500);
                } catch (e) {
                    console.log('Error loading draft:', e);
                }
            }
        }

        // Event listeners
        document.addEventListener('input', function (e) {
            if (e.target.matches('input, select, textarea')) {
                autoSave();
            }
        });

        document.addEventListener('keydown', function (e) {
            // Ctrl + S to save
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                if (typeof submitForm === 'function') {
                    submitForm();
                }
            }

            // Ctrl + N to add visit
            if (e.ctrlKey && e.key === 'n') {
                e.preventDefault();
                addNewVisit();
            }
        });

        // Initialize - Buat 1 kunjungan default saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function () {
            // Check for draft
            if (localStorage.getItem('hivArtDraft')) {
                if (confirm('Ditemukan data draft sebelumnya. Apakah ingin memuat data tersebut?')) {
                    // Buat 1 kunjungan default dulu
                    addNewVisit();
                    loadDraft();
                } else {
                    // Buat 1 kunjungan default
                    addNewVisit();
                }
            } else {
                // Buat 1 kunjungan default
                addNewVisit();
            }
        });

        // Clear draft on successful submission
        function clearDraft() {
            localStorage.removeItem('hivArtDraft');
        }
    </script>
@endpush
