@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .progress-wrapper {
            background: #f8f9fa;
            border-radius: 8px;
        }

        .progress-status {
            display: flex;
            justify-content: space-between;
        }

        .progress-label {
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
        }

        .progress-percentage {
            color: #198754;
            font-weight: 600;
        }

        .custom-progress {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-custom {
            height: 100%;
            background-color: #097dd6;
            transition: width 0.6s ease;
        }

        .section-separator {
            border-top: 2px solid #097dd6;
            margin: 2rem 0;
            padding-top: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
        }

        .form-group label {
            margin-right: 1rem;
            padding-top: 0.5rem;
        }

        .diagnosis-section {
            margin-top: 1.5rem;
        }

        .diagnosis-row {
            padding: 0.5rem 1rem;
            border-color: #dee2e6 !important;
        }

        .diagnosis-item {
            background-color: transparent;
        }

        .border-top {
            border-top: 1px solid #dee2e6 !important;
        }

        .border-bottom {
            border-bottom: 1px solid #dee2e6 !important;
        }

        .form-check {
            margin: 0;
            padding-left: 1.5rem;
            min-height: auto;
        }

        .form-check-input {
            margin-top: 0.3rem;
        }

        .form-check label {
            margin-right: 0;
            padding-top: 0;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        .pain-scale-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        .pain-scale-image {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .dropdown-menu {
            display: none;
            position: fixed;
            /* Ubah ke absolute */
            min-width: 300px;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, .15);
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
            z-index: 1000;
            transform: translateY(5px);
            /* Tambahkan sedikit offset */
            max-height: 400px;
            overflow-y: auto;
        }

        /* Tambahkan wrapper untuk positioning yang lebih baik */
        .dropdown-wrapper {
            position: relative;
            display: inline-block;
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ============================================================================
            // UTILITIES
            // ============================================================================

            /**
             * Show toast notification
             */
            function showToast(type, message) {
                // Create toast if doesn't exist
                if (!document.getElementById('toast-container')) {
                    const toastContainer = document.createElement('div');
                    toastContainer.id = 'toast-container';
                    toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                    toastContainer.style.zIndex = '1050';
                    document.body.appendChild(toastContainer);
                }

                const toast = document.createElement('div');
                toast.className = `toast align-items-center text-bg-${type} border-0`;
                toast.setAttribute('role', 'alert');
                toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;

                document.getElementById('toast-container').appendChild(toast);
                const bsToast = new bootstrap.Toast(toast);
                bsToast.show();

                toast.addEventListener('hidden.bs.toast', () => toast.remove());
            }

            /**
             * Safe element selector
             */
            function safeQuery(selector) {
                return document.querySelector(selector);
            }

            /**
             * Safe element selector all
             */
            function safeQueryAll(selector) {
                return document.querySelectorAll(selector) || [];
            }

            // ============================================================================
            // ANTROPOMETRI CALCULATION
            // ============================================================================

            function initializeAntropometriCalculation() {
                const tinggiBadan = safeQuery('#tinggi_badan');
                const beratBadan = safeQuery('#berat_badan');
                const imtInput = safeQuery('#imt');
                const lptInput = safeQuery('#lpt');

                function hitungIMT_LPT() {
                    const tinggi = parseFloat(tinggiBadan?.value) / 100;
                    const berat = parseFloat(beratBadan?.value);

                    if (!isNaN(tinggi) && !isNaN(berat) && tinggi > 0) {
                        const imt = berat / (tinggi * tinggi);
                        const lpt = (tinggi * 100 * berat) / 3600;

                        if (imtInput) imtInput.value = imt.toFixed(2);
                        if (lptInput) lptInput.value = lpt.toFixed(2);
                    } else {
                        if (imtInput) imtInput.value = "";
                        if (lptInput) lptInput.value = "";
                    }
                }

                tinggiBadan?.addEventListener("input", hitungIMT_LPT);
                beratBadan?.addEventListener("input", hitungIMT_LPT);
            }

            // ============================================================================
            // PEMERIKSAAN FISIK
            // ============================================================================

            function initializePemeriksaanFisik() {
                // Toggle keterangan form
                safeQueryAll('.tambah-keterangan').forEach(button => {
                    button.addEventListener('click', function() {
                        const targetId = this.getAttribute('data-target');
                        const keteranganDiv = safeQuery(`#${targetId}`);
                        const normalCheckbox = this.closest('.pemeriksaan-item')?.querySelector(
                            '.form-check-input');

                        if (keteranganDiv && normalCheckbox) {
                            keteranganDiv.style.display = 'block';
                            normalCheckbox.checked = false;
                        }
                    });
                });

                // Handle normal checkbox change
                safeQueryAll('.pemeriksaan-item .form-check-input').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const keteranganDiv = this.closest('.pemeriksaan-item')?.querySelector(
                            '.keterangan');
                        if (keteranganDiv && this.checked) {
                            keteranganDiv.style.display = 'none';
                            const input = keteranganDiv.querySelector('input');
                            if (input) input.value = '';
                        }
                    });
                });

                // Set default checked state
                safeQueryAll('.pemeriksaan-item .form-check-input').forEach(checkbox => {
                    checkbox.checked = true;
                    const keteranganDiv = checkbox.closest('.pemeriksaan-item')?.querySelector(
                        '.keterangan');
                    if (keteranganDiv) {
                        keteranganDiv.style.display = 'none';
                        const input = keteranganDiv.querySelector('input');
                        if (input) input.value = '';
                    }
                });
            }

            // ============================================================================
            // DOWN SCORE MODAL
            // ============================================================================

            function initializeDownScore() {
                const downScoreModal = safeQuery('#downScoreModal');
                const checkboxes = safeQueryAll('.down-score-check');
                const totalScore = safeQuery('#totalScore');
                const kesimpulan = safeQuery('#kesimpulanBox');
                const downScoreInput = safeQuery('#down_score');
                const simpanBtn = safeQuery('#btnSimpanScore');

                if (!downScoreModal) return;

                function hitungSkor() {
                    let skor = 0;
                    const kategori = ['frekuensi_nafas', 'retraksi', 'sianosis', 'airway', 'merintih'];

                    kategori.forEach(kat => {
                        const checked = safeQuery(`input[name="${kat}"]:checked`);
                        if (checked) {
                            skor += parseInt(checked.value);
                        }
                    });

                    if (totalScore) totalScore.value = skor;

                    if (kesimpulan) {
                        let text = '';
                        let bgColor = '';
                        let textColor = '';

                        if (skor < 3) {
                            text = 'TIDAK GAWAT NAFAS';
                            bgColor = '#28a745';
                            textColor = 'white';
                        } else if (skor >= 3 && skor <= 6) {
                            text = 'GAWAT NAFAS';
                            bgColor = '#ffc107';
                            textColor = 'black';
                        } else {
                            text = 'GAWAT NAFAS MENGANCAM';
                            bgColor = '#dc3545';
                            textColor = 'white';
                        }

                        kesimpulan.textContent = text;
                        kesimpulan.style.backgroundColor = bgColor;
                        kesimpulan.style.color = textColor;
                    }
                }

                // Event checkbox change
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const nama = this.name;
                        safeQueryAll(`input[name="${nama}"]`).forEach(cb => {
                            if (cb !== this) cb.checked = false;
                        });
                        hitungSkor();
                    });
                });

                // Event simpan
                simpanBtn?.addEventListener('click', function() {
                    const skor = parseInt(totalScore?.value) || 0;
                    if (downScoreInput) downScoreInput.value = skor;

                    const modal = bootstrap.Modal.getInstance(downScoreModal);
                    if (modal) {
                        modal.hide();
                    }
                });

                // Reset saat modal dibuka
                downScoreModal.addEventListener('shown.bs.modal', function() {
                    checkboxes.forEach(cb => cb.checked = false);
                    if (totalScore) totalScore.value = '0';
                    hitungSkor();
                });
            }

            // ============================================================================
            // RIWAYAT PENYAKIT DAN PENGOBATAN
            // ============================================================================

            function initializeRiwayatPenyakit() {
                let riwayatArray = [];

                const btnTambahRiwayat = safeQuery('#btnTambahRiwayat');
                const btnTambahRiwayatModal = safeQuery('#btnTambahRiwayatModal');
                const riwayatModal = safeQuery('#riwayatModal');
                const namaPenyakitInput = safeQuery('#namaPenyakit');
                const namaObatInput = safeQuery('#namaObat');
                const riwayatJsonInput = safeQuery('#riwayatJson');

                function updateRiwayatJson() {
                    if (riwayatJsonInput) {
                        riwayatJsonInput.value = JSON.stringify(riwayatArray);
                    }
                }

                // Reset input saat modal dibuka
                btnTambahRiwayat?.addEventListener('click', function() {
                    if (namaPenyakitInput) namaPenyakitInput.value = '';
                    if (namaObatInput) namaObatInput.value = '';
                });

                // Tambah riwayat
                btnTambahRiwayatModal?.addEventListener('click', function() {
                    const namaPenyakit = namaPenyakitInput?.value.trim() || '';
                    const namaObat = namaObatInput?.value.trim() || '';
                    const tbody = safeQuery('#riwayatTable tbody');

                    if (!namaPenyakit && !namaObat) {
                        showToast('warning', 'Mohon isi setidaknya salah satu field (Penyakit atau Obat)');
                        return;
                    }

                    if (tbody) {
                        const riwayatEntry = {
                            penyakit: namaPenyakit || '-',
                            obat: namaObat || '-'
                        };

                        riwayatArray.push(riwayatEntry);

                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td>${namaPenyakit || '-'}</td>
                    <td>${namaObat || '-'}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm hapus-riwayat">Hapus</button>
                    </td>
                `;

                        tbody.appendChild(row);

                        // Event hapus
                        row.querySelector('.hapus-riwayat')?.addEventListener('click', function() {
                            const index = riwayatArray.findIndex(item =>
                                item.penyakit === (namaPenyakit || '-') &&
                                item.obat === (namaObat || '-')
                            );
                            if (index !== -1) {
                                riwayatArray.splice(index, 1);
                            }
                            row.remove();
                            updateRiwayatJson();
                            showToast('success', 'Riwayat berhasil dihapus');
                        });

                        updateRiwayatJson();

                        if (riwayatModal) {
                            bootstrap.Modal.getInstance(riwayatModal)?.hide();
                        }

                        showToast('success', 'Riwayat berhasil ditambahkan');
                    }
                });

                // Reset modal saat ditutup
                riwayatModal?.addEventListener('hidden.bs.modal', function() {
                    if (namaPenyakitInput) namaPenyakitInput.value = '';
                    if (namaObatInput) namaObatInput.value = '';
                });
            }

            // ============================================================================
            // STATUS NYERI
            // ============================================================================

            function initializeStatusNyeri() {
                const skalaSelect = safeQuery('#jenis_skala_nyeri');
                const nilaiSkalaNyeri = safeQuery('#nilai_skala_nyeri');
                const kesimpulanNyeri = safeQuery('#kesimpulan_nyeri');
                const kesimpulanNyeriAlert = safeQuery('#kesimpulan_nyeri_alert');

                if (!skalaSelect) return;

                // Handle skala selection
                skalaSelect.addEventListener('change', function() {
                    const openModals = safeQueryAll('.modal.show');
                    openModals.forEach(modal => {
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        if (modalInstance) modalInstance.hide();
                    });

                    const modalId = {
                        'NRS': '#modalNRS',
                        'FLACC': '#modalFLACC',
                        'CRIES': '#modalCRIES'
                    } [this.value];

                    if (modalId) {
                        const modal = safeQuery(modalId);
                        if (modal) {
                            new bootstrap.Modal(modal).show();
                        }
                    }
                });

                // NRS Handler
                initializeNRS();

                // FLACC Handler
                initializeFLACC();

                // CRIES Handler
                initializeCRIES();

                function initializeNRS() {
                    const nrsModal = safeQuery('#modalNRS');
                    const nrsValue = safeQuery('#nrs_value');
                    const nrsKesimpulan = safeQuery('#nrs_kesimpulan');
                    const simpanNRS = safeQuery('#simpanNRS');

                    if (!nrsModal) return;

                    nrsValue?.addEventListener('input', function() {
                        let value = parseInt(this.value);

                        if (value < 0) this.value = 0;
                        if (value > 10) this.value = 10;
                        value = parseInt(this.value);

                        const {
                            kesimpulan,
                            alertClass,
                            emoji
                        } = getNyeriKesimpulan(value);

                        if (nrsKesimpulan) {
                            nrsKesimpulan.className = 'alert ' + alertClass;
                            nrsKesimpulan.innerHTML = `
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi ${emoji} fs-4"></i>
                            <span>${kesimpulan}</span>
                        </div>
                    `;
                        }
                    });

                    simpanNRS?.addEventListener('click', function() {
                        const value = parseInt(nrsValue?.value);
                        if (isNaN(value)) return;

                        const {
                            kesimpulan,
                            alertClass,
                            emoji
                        } = getNyeriKesimpulan(value);

                        if (nilaiSkalaNyeri) nilaiSkalaNyeri.value = value;
                        if (kesimpulanNyeri) kesimpulanNyeri.value = kesimpulan;

                        if (kesimpulanNyeriAlert) {
                            kesimpulanNyeriAlert.innerHTML = `
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi ${emoji} fs-4"></i>
                            <span>${kesimpulan}</span>
                        </div>
                    `;
                            kesimpulanNyeriAlert.className = `alert ${alertClass}`;
                        }

                        bootstrap.Modal.getInstance(nrsModal)?.hide();
                        showToast('success', 'Nilai nyeri berhasil disimpan');
                    });

                    nrsModal.addEventListener('hidden.bs.modal', function() {
                        if (nrsValue) nrsValue.value = '';
                        if (nrsKesimpulan) {
                            nrsKesimpulan.innerHTML = `
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-emoji-smile fs-4"></i>
                            <span>Pilih nilai nyeri terlebih dahulu</span>
                        </div>
                    `;
                            nrsKesimpulan.className = 'alert alert-info';
                        }
                    });
                }

                function initializeFLACC() {
                    const flaccModal = safeQuery('#modalFLACC');
                    const flaccTotal = safeQuery('#flaccTotal');
                    const flaccKesimpulan = safeQuery('#flaccKesimpulan');
                    const simpanFLACC = safeQuery('#simpanFLACC');

                    if (!flaccModal) return;

                    function updateFLACCTotal() {
                        const flaccChecks = safeQueryAll('.flacc-check:checked');
                        let total = 0;

                        flaccChecks.forEach(check => {
                            total += parseInt(check.value);
                        });

                        if (flaccTotal) flaccTotal.value = total;

                        const {
                            kesimpulan,
                            alertClass
                        } = getNyeriKesimpulan(total);

                        if (flaccKesimpulan) {
                            flaccKesimpulan.textContent = kesimpulan;
                            flaccKesimpulan.className = `alert py-1 px-3 mb-0 ${alertClass}`;
                        }
                    }

                    safeQueryAll('.flacc-check').forEach(check => {
                        check.addEventListener('change', updateFLACCTotal);
                    });

                    simpanFLACC?.addEventListener('click', function() {
                        const total = parseInt(flaccTotal?.value);
                        if (isNaN(total)) return;

                        const {
                            kesimpulan,
                            alertClass,
                            emoji
                        } = getNyeriKesimpulan(total);

                        if (nilaiSkalaNyeri) nilaiSkalaNyeri.value = total;
                        if (kesimpulanNyeri) kesimpulanNyeri.value = kesimpulan;

                        if (kesimpulanNyeriAlert) {
                            kesimpulanNyeriAlert.innerHTML = `
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi ${emoji} fs-4"></i>
                            <span>${kesimpulan}</span>
                        </div>
                    `;
                            kesimpulanNyeriAlert.className = `alert ${alertClass}`;
                        }

                        bootstrap.Modal.getInstance(flaccModal)?.hide();
                        showToast('success', 'Nilai nyeri FLACC berhasil disimpan');
                    });

                    flaccModal.addEventListener('shown.bs.modal', function() {
                        safeQueryAll('.flacc-check').forEach(check => check.checked = false);
                        if (flaccTotal) flaccTotal.value = '0';
                        if (flaccKesimpulan) {
                            flaccKesimpulan.textContent = 'Pilih kategori untuk melihat kesimpulan';
                            flaccKesimpulan.className = 'alert alert-info py-1 px-3 mb-0';
                        }
                    });
                }

                function initializeCRIES() {
                    const criesModal = safeQuery('#modalCRIES');
                    const criesTotal = safeQuery('#criesTotal');
                    const criesKesimpulan = safeQuery('#criesKesimpulan');
                    const simpanCRIES = safeQuery('#simpanCRIES');

                    if (!criesModal) return;

                    function updateCRIESTotal() {
                        const criesChecks = safeQueryAll('.cries-check:checked');
                        let total = 0;

                        criesChecks.forEach(check => {
                            total += parseInt(check.value);
                        });

                        if (criesTotal) criesTotal.value = total;

                        const {
                            kesimpulan,
                            alertClass
                        } = getNyeriKesimpulan(total);

                        if (criesKesimpulan) {
                            criesKesimpulan.textContent = kesimpulan;
                            criesKesimpulan.className = `alert py-1 px-3 mb-0 ${alertClass}`;
                        }
                    }

                    safeQueryAll('.cries-check').forEach(check => {
                        check.addEventListener('change', updateCRIESTotal);
                    });

                    simpanCRIES?.addEventListener('click', function() {
                        const total = parseInt(criesTotal?.value);
                        if (isNaN(total)) return;

                        const {
                            kesimpulan,
                            alertClass,
                            emoji
                        } = getNyeriKesimpulan(total);

                        if (nilaiSkalaNyeri) nilaiSkalaNyeri.value = total;
                        if (kesimpulanNyeri) kesimpulanNyeri.value = kesimpulan;

                        if (kesimpulanNyeriAlert) {
                            kesimpulanNyeriAlert.innerHTML = `
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi ${emoji} fs-4"></i>
                            <span>${kesimpulan}</span>
                        </div>
                    `;
                            kesimpulanNyeriAlert.className = `alert ${alertClass}`;
                        }

                        bootstrap.Modal.getInstance(criesModal)?.hide();
                        showToast('success', 'Nilai nyeri CRIES berhasil disimpan');
                    });

                    criesModal.addEventListener('shown.bs.modal', function() {
                        safeQueryAll('.cries-check').forEach(check => check.checked = false);
                        if (criesTotal) criesTotal.value = '0';
                        if (criesKesimpulan) {
                            criesKesimpulan.textContent = 'Pilih semua kategori untuk melihat kesimpulan';
                            criesKesimpulan.className = 'alert alert-info py-1 px-3 mb-0';
                        }
                    });
                }

                function getNyeriKesimpulan(value) {
                    if (value >= 0 && value <= 3) {
                        return {
                            kesimpulan: 'Nyeri Ringan',
                            alertClass: 'alert-success',
                            emoji: 'bi-emoji-smile'
                        };
                    } else if (value >= 4 && value <= 6) {
                        return {
                            kesimpulan: 'Nyeri Sedang',
                            alertClass: 'alert-warning',
                            emoji: 'bi-emoji-neutral'
                        };
                    } else {
                        return {
                            kesimpulan: 'Nyeri Berat',
                            alertClass: 'alert-danger',
                            emoji: 'bi-emoji-frown'
                        };
                    }
                }
            }

            // ============================================================================
            // RISIKO JATUH
            // ============================================================================

            function initializeRisikoJatuh() {
                const risikoJatuhSkala = safeQuery('#risikoJatuhSkala');

                if (!risikoJatuhSkala) return;

                risikoJatuhSkala.addEventListener('change', function() {
                    showRisikoJatuhForm(this.value);
                });

                // Initialize form listeners
                initializeRisikoJatuhForms();

                // Hide all forms initially
                showRisikoJatuhForm('');

                function showRisikoJatuhForm(formType) {
                    safeQueryAll('.risk-form').forEach(form => {
                        form.style.display = 'none';
                    });

                    if (formType === '5') {
                        showToast('warning', 'Pasien tidak dapat dinilai status risiko jatuh');
                        return;
                    }

                    const formMapping = {
                        '1': 'skala_umumForm',
                        '2': 'skala_morseForm',
                        '3': 'skala_humptyForm',
                        '4': 'skala_ontarioForm'
                    };

                    if (formType && formMapping[formType]) {
                        const selectedForm = safeQuery(`#${formMapping[formType]}`);
                        if (selectedForm) {
                            selectedForm.style.display = 'block';
                            resetRisikoJatuhForm(selectedForm);
                        }
                    }
                }

                function resetRisikoJatuhForm(form) {
                    form.querySelectorAll('select').forEach(select => select.value = '');
                    const formType = form.id.replace('skala_', '').replace('Form', '');
                    const conclusionDiv = form.querySelector('.conclusion');
                    const defaultConclusion = formType === 'umum' ? 'Tidak berisiko jatuh' : 'Risiko Rendah';

                    if (conclusionDiv) {
                        conclusionDiv.className = 'conclusion bg-success';
                        const span = conclusionDiv.querySelector('span');
                        if (span) span.textContent = defaultConclusion;

                        const hiddenInput = conclusionDiv.querySelector('input[type="hidden"]');
                        if (hiddenInput) hiddenInput.value = defaultConclusion;
                    }
                }

                function initializeRisikoJatuhForms() {
                    // Umum form
                    const umumForm = safeQuery('#skala_umumForm');
                    if (umumForm) {
                        umumForm.querySelectorAll('select').forEach(select => {
                            select.addEventListener('change', () => updateRisikoJatuhConclusion('umum'));
                        });
                    }

                    // Morse form
                    const morseForm = safeQuery('#skala_morseForm');
                    if (morseForm) {
                        morseForm.querySelectorAll('select').forEach(select => {
                            select.addEventListener('change', () => updateRisikoJatuhConclusion('morse'));
                        });
                    }

                    // Humpty form
                    const humptyForm = safeQuery('#skala_humptyForm');
                    if (humptyForm) {
                        humptyForm.querySelectorAll('select').forEach(select => {
                            select.addEventListener('change', () => updateRisikoJatuhConclusion('humpty'));
                        });
                    }

                    // Ontario form
                    const ontarioForm = safeQuery('#skala_ontarioForm');
                    if (ontarioForm) {
                        ontarioForm.querySelectorAll('select').forEach(select => {
                            select.addEventListener('change', () => updateRisikoJatuhConclusion('ontario'));
                        });
                    }
                }

                function updateRisikoJatuhConclusion(formType) {
                    const form = safeQuery('#skala_' + formType + 'Form');
                    if (!form) return;

                    const selects = form.querySelectorAll('select');
                    let score = 0;
                    let hasYes = false;

                    selects.forEach(select => {
                        if (select.value === '1') hasYes = true;
                        score += parseInt(select.value) || 0;
                    });

                    const conclusionDiv = form.querySelector('.conclusion');
                    const conclusionSpan = conclusionDiv?.querySelector('span');
                    const conclusionInput = conclusionDiv?.querySelector('input[type="hidden"]');

                    let conclusion = '';
                    let bgClass = '';

                    switch (formType) {
                        case 'umum':
                            conclusion = hasYes ? 'Berisiko jatuh' : 'Tidak berisiko jatuh';
                            bgClass = hasYes ? 'bg-danger' : 'bg-success';
                            if (conclusionInput) conclusionInput.value = conclusion;
                            break;

                        case 'morse':
                            if (score >= 45) {
                                conclusion = 'Risiko Tinggi';
                                bgClass = 'bg-danger';
                            } else if (score >= 25) {
                                conclusion = 'Risiko Sedang';
                                bgClass = 'bg-warning';
                            } else {
                                conclusion = 'Risiko Rendah';
                                bgClass = 'bg-success';
                            }
                            conclusion += ` (Skor: ${score})`;
                            const morseInput = safeQuery('#risiko_jatuh_morse_kesimpulan');
                            if (morseInput) morseInput.value = conclusion;
                            break;

                        case 'humpty':
                            conclusion = score >= 12 ? 'Risiko Tinggi' : 'Risiko Rendah';
                            bgClass = score >= 12 ? 'bg-danger' : 'bg-success';
                            conclusion += ` (Skor: ${score})`;
                            const humptyInput = safeQuery('#risiko_jatuh_pediatrik_kesimpulan');
                            if (humptyInput) humptyInput.value = conclusion;
                            break;

                        case 'ontario':
                            if (score >= 9) {
                                conclusion = 'Risiko Tinggi';
                                bgClass = 'bg-danger';
                            } else if (score >= 4) {
                                conclusion = 'Risiko Sedang';
                                bgClass = 'bg-warning';
                            } else {
                                conclusion = 'Risiko Rendah';
                                bgClass = 'bg-success';
                            }
                            conclusion += ` (Skor: ${score})`;
                            const ontarioInput = safeQuery('#risiko_jatuh_lansia_kesimpulan');
                            if (ontarioInput) ontarioInput.value = conclusion;
                            break;
                    }

                    if (conclusionDiv) {
                        conclusionDiv.className = 'conclusion ' + bgClass;
                        if (conclusionSpan) conclusionSpan.textContent = conclusion;
                    }
                }
            }

            // ============================================================================
            // RISIKO DEKUBITUS
            // ============================================================================

            function initializeRisikoDekubitus() {
                const skalaDecubitusSelect = safeQuery('#skalaRisikoDekubitus');

                if (!skalaDecubitusSelect) return;

                skalaDecubitusSelect.addEventListener('change', function() {
                    showDecubitusForm(this.value);
                });

                // Initialize form listeners
                const formNorton = safeQuery('#formNorton');
                if (formNorton) {
                    formNorton.querySelectorAll('select').forEach(select => {
                        select.addEventListener('change', () => updateDecubitusConclusion('norton'));
                    });
                }

                const formBraden = safeQuery('#formBraden');
                if (formBraden) {
                    formBraden.querySelectorAll('select').forEach(select => {
                        select.addEventListener('change', () => updateDecubitusConclusion('braden'));
                    });
                }

                showDecubitusForm('');

                function showDecubitusForm(formType) {
                    safeQueryAll('.decubitus-form').forEach(form => {
                        form.style.display = 'none';
                    });

                    const formElement = safeQuery(`#form${formType.charAt(0).toUpperCase() + formType.slice(1)}`);
                    if (formElement) {
                        formElement.style.display = 'block';
                        resetDecubitusForm(formElement);
                    }
                }

                function resetDecubitusForm(form) {
                    if (!form) return;

                    form.querySelectorAll('select').forEach(select => select.value = '');
                    const kesimpulanDiv = form.querySelector('#kesimpulanNorton');
                    if (kesimpulanDiv) {
                        kesimpulanDiv.className = 'alert alert-success mb-0 flex-grow-1';
                        kesimpulanDiv.textContent = 'Risiko Rendah';
                    }
                }

                function updateDecubitusConclusion(formType) {
                    const form = safeQuery(`#form${formType.charAt(0).toUpperCase() + formType.slice(1)}`);
                    if (!form) return;

                    const kesimpulanDiv = form.querySelector('#kesimpulanNorton');
                    if (!kesimpulanDiv) return;

                    if (formType === 'norton') {
                        let total = 0;
                        let allFilled = true;
                        const fields = ['kondisi_fisik', 'kondisi_mental', 'norton_aktivitas', 'norton_mobilitas',
                            'inkontinensia'
                        ];

                        fields.forEach(field => {
                            const select = form.querySelector(`select[name="${field}"]`);
                            if (!select || !select.value) {
                                allFilled = false;
                                return;
                            }
                            total += parseInt(select.value);
                        });

                        if (!allFilled) {
                            kesimpulanDiv.className = 'alert alert-info mb-0 flex-grow-1';
                            kesimpulanDiv.textContent = 'Pilih semua kriteria untuk melihat kesimpulan';
                            return;
                        }

                        let conclusion = '';
                        let alertClass = '';

                        if (total <= 12) {
                            conclusion = 'Risiko Tinggi';
                            alertClass = 'alert-danger';
                        } else if (total <= 14) {
                            conclusion = 'Risiko Sedang';
                            alertClass = 'alert-warning';
                        } else {
                            conclusion = 'Risiko Rendah';
                            alertClass = 'alert-success';
                        }

                        conclusion += ` (Skor: ${total})`;
                        kesimpulanDiv.className = `alert ${alertClass} mb-0 flex-grow-1`;
                        kesimpulanDiv.textContent = conclusion;
                    } else if (formType === 'braden') {
                        let total = 0;
                        let allFilled = true;
                        const fields = ['persepsi_sensori', 'kelembapan', 'braden_aktivitas', 'braden_mobilitas',
                            'nutrisi', 'pergesekan'
                        ];

                        fields.forEach(field => {
                            const select = form.querySelector(`select[name="${field}"]`);
                            if (!select || !select.value) {
                                allFilled = false;
                                return;
                            }
                            total += parseInt(select.value);
                        });

                        if (!allFilled) {
                            kesimpulanDiv.className = 'alert alert-info mb-0 flex-grow-1';
                            kesimpulanDiv.textContent = 'Pilih semua kriteria untuk melihat kesimpulan';
                            return;
                        }

                        let conclusion = '';
                        let alertClass = '';

                        if (total <= 12) {
                            conclusion = 'Risiko Tinggi';
                            alertClass = 'alert-danger';
                        } else if (total <= 16) {
                            conclusion = 'Risiko Sedang';
                            alertClass = 'alert-warning';
                        } else {
                            conclusion = 'Risiko Rendah';
                            alertClass = 'alert-success';
                        }

                        conclusion += ` (Skor: ${total})`;
                        kesimpulanDiv.className = `alert ${alertClass} mb-0 flex-grow-1`;
                        kesimpulanDiv.textContent = conclusion;
                    }
                }
            }

            // ============================================================================
            // STATUS GIZI
            // ============================================================================

            function initializeStatusGizi() {
                const nutritionSelect = safeQuery('#nutritionAssessment');
                const allForms = safeQueryAll('.assessment-form');

                if (!nutritionSelect) return;

                nutritionSelect.addEventListener('change', function() {
                    const selectedValue = this.value;

                    // Hide all forms
                    allForms.forEach(form => {
                        form.style.display = 'none';
                    });

                    if (selectedValue === '5') {
                        showToast('warning', 'Pasien tidak dapat dinilai status gizinya');
                        return;
                    }

                    const formMapping = {
                        '1': 'mst',
                        '2': 'mna',
                        '3': 'strong-kids',
                        '4': 'nrs'
                    };

                    const formId = formMapping[selectedValue];
                    if (formId) {
                        const selectedForm = safeQuery(`#${formId}`);
                        if (selectedForm) {
                            selectedForm.style.display = 'block';
                            initializeFormListeners(formId);
                        }
                    }
                });

                function initializeFormListeners(formId) {
                    const form = safeQuery(`#${formId}`);
                    if (!form) return;

                    const selects = form.querySelectorAll('select');

                    switch (formId) {
                        case 'mst':
                            selects.forEach(select => {
                                select.addEventListener('change', () => calculateMSTScore());
                            });
                            break;
                        case 'mna':
                            selects.forEach(select => {
                                select.addEventListener('change', () => calculateMNAScore());
                            });
                            initializeBMICalculation();
                            break;
                        case 'strong-kids':
                            selects.forEach(select => {
                                select.addEventListener('change', () => calculateStrongKidsScore());
                            });
                            break;
                        case 'nrs':
                            selects.forEach(select => {
                                select.addEventListener('change', () => calculateNRSScore());
                            });
                            break;
                    }
                }

                function calculateMSTScore() {
                    const form = safeQuery('#mst');
                    if (!form) return;

                    const selects = form.querySelectorAll('select');
                    let total = 0;

                    selects.forEach(select => {
                        total += parseInt(select.value || 0);
                    });

                    const kesimpulan = total <= 1 ? 'Tidak berisiko malnutrisi' : 'Berisiko malnutrisi';
                    const kesimpulanInput = safeQuery('#gizi_mst_kesimpulan');
                    if (kesimpulanInput) kesimpulanInput.value = kesimpulan;

                    const conclusions = form.querySelectorAll('.alert');
                    conclusions.forEach(alert => {
                        if ((total <= 1 && alert.classList.contains('alert-success')) ||
                            (total >= 2 && alert.classList.contains('alert-warning'))) {
                            alert.style.display = 'block';
                        } else {
                            alert.style.display = 'none';
                        }
                    });
                }

                function initializeBMICalculation() {
                    const weightInput = safeQuery('#mnaWeight');
                    const heightInput = safeQuery('#mnaHeight');
                    const bmiInput = safeQuery('#mnaBMI');

                    function calculateBMI() {
                        const weight = parseFloat(weightInput?.value || 0);
                        const height = parseFloat(heightInput?.value || 0);

                        if (weight > 0 && height > 0) {
                            const heightInMeters = height / 100;
                            const bmi = weight / (heightInMeters * heightInMeters);
                            if (bmiInput) bmiInput.value = bmi.toFixed(2);
                            calculateMNAScore(); // Recalculate MNA when BMI changes
                        }
                    }

                    weightInput?.addEventListener('input', calculateBMI);
                    heightInput?.addEventListener('input', calculateBMI);
                }

                function calculateMNAScore() {
                    const form = safeQuery('#mna');
                    if (!form) return;

                    const selects = form.querySelectorAll('select[name^="gizi_mna_"]');
                    let total = 0;

                    selects.forEach(select => {
                        const value = parseInt(select.value || 0);
                        total += value;
                    });

                    const kesimpulan = total >= 12 ? '≥ 12 Tidak Beresiko' : '≤ 11 Beresiko malnutrisi';
                    const kesimpulanInput = safeQuery('#gizi_mna_kesimpulan');
                    if (kesimpulanInput) kesimpulanInput.value = kesimpulan;

                    const conclusionDiv = safeQuery('#mnaConclusion');
                    if (conclusionDiv) {
                        const alertClass = total >= 12 ? 'alert-success' : 'alert-warning';
                        conclusionDiv.innerHTML = `
                    <div class="alert ${alertClass}">
                        Kesimpulan: ${kesimpulan} (Total Score: ${total})
                    </div>
                `;
                    }
                }

                function calculateStrongKidsScore() {
                    const form = safeQuery('#strong-kids');
                    if (!form) return;

                    const selects = form.querySelectorAll('select');
                    let total = 0;

                    selects.forEach(select => {
                        total += parseInt(select.value || 0);
                    });

                    let kesimpulan, type, kesimpulanText;
                    if (total === 0) {
                        kesimpulan = 'Beresiko rendah';
                        kesimpulanText = '0 (Beresiko rendah)';
                        type = 'success';
                    } else if (total >= 1 && total <= 3) {
                        kesimpulan = 'Beresiko sedang';
                        kesimpulanText = '1-3 (Beresiko sedang)';
                        type = 'warning';
                    } else {
                        kesimpulan = 'Beresiko Tinggi';
                        kesimpulanText = '4-5 (Beresiko Tinggi)';
                        type = 'danger';
                    }

                    const kesimpulanInput = safeQuery('#gizi_strong_kesimpulan');
                    if (kesimpulanInput) kesimpulanInput.value = kesimpulanText;

                    const conclusionDiv = safeQuery('#strongKidsConclusion');
                    if (conclusionDiv) {
                        conclusionDiv.innerHTML = `
                    <div class="alert alert-${type}">
                        Kesimpulan: ${kesimpulanText} (Total Score: ${total})
                    </div>
                `;
                    }
                }

                function calculateNRSScore() {
                    const form = safeQuery('#nrs');
                    if (!form) return;

                    const selects = form.querySelectorAll('select');
                    let total = 0;

                    selects.forEach(select => {
                        total += parseInt(select.value || 0);
                    });

                    let kesimpulan, type, kesimpulanText;
                    if (total <= 5) {
                        kesimpulan = 'Beresiko rendah';
                        kesimpulanText = '≤ 5 (Beresiko rendah)';
                        type = 'success';
                    } else if (total <= 10) {
                        kesimpulan = 'Beresiko sedang';
                        kesimpulanText = '6-10 (Beresiko sedang)';
                        type = 'warning';
                    } else {
                        kesimpulan = 'Beresiko Tinggi';
                        kesimpulanText = '> 10 (Beresiko Tinggi)';
                        type = 'danger';
                    }

                    const kesimpulanInput = safeQuery('#gizi_nrs_kesimpulan');
                    if (kesimpulanInput) kesimpulanInput.value = kesimpulanText;

                    const conclusionDiv = safeQuery('#nrsConclusion');
                    if (conclusionDiv) {
                        conclusionDiv.innerHTML = `
                    <div class="alert alert-${type}">
                        Kesimpulan: ${kesimpulanText} (Total Score: ${total})
                    </div>
                `;
                    }
                }
            }

            // ============================================================================
            // STATUS FUNGSIONAL ADL
            // ============================================================================

            function initializeStatusFungsional() {
                const statusFungsionalSelect = safeQuery('#skala_fungsional');
                const adlTotal = safeQuery('#adl_total');
                const adlKesimpulanAlert = safeQuery('#adl_kesimpulan');

                if (!statusFungsionalSelect) return;

                statusFungsionalSelect.addEventListener('change', function() {
                    if (this.value === 'Pengkajian Aktivitas') {
                        // Reset values
                        if (adlTotal) adlTotal.value = '';
                        if (adlKesimpulanAlert) {
                            adlKesimpulanAlert.className = 'alert alert-info';
                            adlKesimpulanAlert.textContent = 'Pilih skala aktivitas harian terlebih dahulu';
                        }

                        const modal = safeQuery('#modalADL');
                        if (modal) {
                            new bootstrap.Modal(modal).show();
                        }
                    } else if (this.value === 'Lainnya') {
                        showToast('warning', 'Skala pengukuran lainnya belum tersedia');
                        this.value = '';
                        if (adlTotal) adlTotal.value = '';
                        if (adlKesimpulanAlert) {
                            adlKesimpulanAlert.className = 'alert alert-info';
                            adlKesimpulanAlert.textContent = 'Pilih skala aktivitas harian terlebih dahulu';
                        }
                    }
                });

                // Initialize ADL modal handlers
                initializeADLModal();

                function initializeADLModal() {
                    const modalADL = safeQuery('#modalADL');
                    const adlModalTotal = safeQuery('#adlTotal');
                    const adlModalKesimpulan = safeQuery('#adlKesimpulan');
                    const simpanADL = safeQuery('#simpanADL');

                    if (!modalADL) return;

                    function updateADLTotal() {
                        const adlChecks = safeQueryAll('.adl-check:checked');
                        let total = 0;

                        adlChecks.forEach(check => {
                            total += parseInt(check.value);
                        });

                        if (adlModalTotal) adlModalTotal.value = total;

                        // Check if all categories are selected
                        const checkedCategories = new Set(Array.from(adlChecks).map(check => check.getAttribute(
                            'data-category')));
                        const allCategoriesSelected = checkedCategories.size ===
                        3; // 3 categories: makan, berjalan, mandi

                        if (!allCategoriesSelected) {
                            if (adlModalKesimpulan) {
                                adlModalKesimpulan.className = 'alert alert-info py-1 px-3 mb-0';
                                adlModalKesimpulan.textContent = 'Pilih semua kategori terlebih dahulu';
                            }
                            return;
                        }

                        let kesimpulan = '';
                        let alertClass = '';

                        if (total <= 4) {
                            kesimpulan = 'Mandiri';
                            alertClass = 'alert-success';
                        } else if (total <= 8) {
                            kesimpulan = 'Ketergantungan Ringan';
                            alertClass = 'alert-info';
                        } else if (total <= 11) {
                            kesimpulan = 'Ketergantungan Sedang';
                            alertClass = 'alert-warning';
                        } else {
                            kesimpulan = 'Ketergantungan Berat';
                            alertClass = 'alert-danger';
                        }

                        if (adlModalKesimpulan) {
                            adlModalKesimpulan.className = `alert ${alertClass} py-1 px-3 mb-0`;
                            adlModalKesimpulan.textContent = kesimpulan;
                        }
                    }

                    safeQueryAll('.adl-check').forEach(check => {
                        check.addEventListener('change', updateADLTotal);
                    });

                    simpanADL?.addEventListener('click', function() {
                        const total = adlModalTotal?.value;
                        const kesimpulan = adlModalKesimpulan?.textContent;

                        if (!total || !kesimpulan || kesimpulan.includes('Pilih')) {
                            showToast('warning', 'Pilih semua kategori terlebih dahulu');
                            return;
                        }

                        // Update main form
                        if (adlTotal) adlTotal.value = total;
                        if (adlKesimpulanAlert) {
                            adlKesimpulanAlert.className = adlModalKesimpulan.className.replace(
                                'py-1 px-3 mb-0', '');
                            adlKesimpulanAlert.textContent = kesimpulan;
                        }

                        // Save hidden values
                        saveADLHiddenValues();

                        bootstrap.Modal.getInstance(modalADL)?.hide();
                        showToast('success', 'Data ADL berhasil disimpan');
                    });

                    modalADL.addEventListener('shown.bs.modal', function() {
                        safeQueryAll('.adl-check').forEach(check => check.checked = false);
                        if (adlModalTotal) adlModalTotal.value = '0';
                        if (adlModalKesimpulan) {
                            adlModalKesimpulan.textContent =
                            'Pilih semua kategori untuk melihat kesimpulan';
                            adlModalKesimpulan.className = 'alert alert-info py-1 px-3 mb-0';
                        }
                    });

                    function saveADLHiddenValues() {
                        const getSelectedADLValues = () => {
                            const makanValue = safeQuery('input[name="makan"]:checked')?.value || '';
                            const berjalanValue = safeQuery('input[name="berjalan"]:checked')?.value || '';
                            const mandiValue = safeQuery('input[name="mandi"]:checked')?.value || '';

                            const getTextValue = (value) => {
                                switch (value) {
                                    case '1':
                                        return 'Mandiri';
                                    case '2':
                                        return '25% Dibantu';
                                    case '3':
                                        return '50% Dibantu';
                                    case '4':
                                        return '75% Dibantu';
                                    default:
                                        return '';
                                }
                            };

                            return {
                                makan: getTextValue(makanValue),
                                makanValue: makanValue,
                                berjalan: getTextValue(berjalanValue),
                                berjalanValue: berjalanValue,
                                mandi: getTextValue(mandiValue),
                                mandiValue: mandiValue
                            };
                        };

                        const adlValues = getSelectedADLValues();

                        const hiddenInputs = {
                            'adl_makan': adlValues.makan,
                            'adl_makan_value': adlValues.makanValue,
                            'adl_berjalan': adlValues.berjalan,
                            'adl_berjalan_value': adlValues.berjalanValue,
                            'adl_mandi': adlValues.mandi,
                            'adl_mandi_value': adlValues.mandiValue,
                            'adl_kesimpulan_value': adlKesimpulanAlert?.textContent || '',
                            'adl_jenis_skala': '1'
                        };

                        Object.entries(hiddenInputs).forEach(([id, value]) => {
                            const input = safeQuery(`#${id}`);
                            if (input) input.value = value;
                        });
                    }
                }
            }

            // ============================================================================
            // DISCHARGE PLANNING
            // ============================================================================

            function initializeDischargePlanning() {
                const dischargePlanningSection = safeQuery('#discharge-planning');
                if (!dischargePlanningSection) return;

                const allSelects = dischargePlanningSection.querySelectorAll('select');
                const alertWarning = dischargePlanningSection.querySelector('.alert-warning');
                const alertSuccess = dischargePlanningSection.querySelector('.alert-success');

                function updateDischargePlanningConclusion() {
                    let needsSpecialPlan = false;
                    let allSelected = true;

                    allSelects.forEach(select => {
                        if (!select.value) {
                            allSelected = false;
                        } else if (select.value === '1') { // Ya
                            needsSpecialPlan = true;
                        }
                    });

                    if (!allSelected) {
                        if (alertWarning) alertWarning.style.display = 'none';
                        if (alertSuccess) alertSuccess.style.display = 'none';
                        return;
                    }

                    if (needsSpecialPlan) {
                        if (alertWarning) alertWarning.style.display = 'block';
                        if (alertSuccess) alertSuccess.style.display = 'none';
                    } else {
                        if (alertWarning) alertWarning.style.display = 'none';
                        if (alertSuccess) alertSuccess.style.display = 'block';
                    }
                }

                allSelects.forEach(select => {
                    select.addEventListener('change', updateDischargePlanningConclusion);
                });

                updateDischargePlanningConclusion();
            }

            // ============================================================================
            // DIAGNOSIS KEPERAWATAN
            // ============================================================================

            function initializeDiagnosisKeperawatan() {
                const btnTambahMasalah = safeQuery('#btnTambahMasalah');
                const btnTambahIntervensi = safeQuery('#btnTambahIntervensi');
                const masalahContainer = safeQuery('#masalahContainer');
                const intervensiContainer = safeQuery('#intervensiContainer');

                if (!btnTambahMasalah || !btnTambahIntervensi || !masalahContainer || !intervensiContainer) return;

                // Add masalah field
                btnTambahMasalah.addEventListener('click', function() {
                    addMasalahField();
                    updateMasalahRemoveButtons();
                });

                // Add intervensi field
                btnTambahIntervensi.addEventListener('click', function() {
                    addIntervensiField();
                    updateIntervensiRemoveButtons();
                });

                function addMasalahField() {
                    const newField = document.createElement('div');
                    newField.className = 'masalah-item mb-2';
                    newField.innerHTML = `
                <div class="d-flex gap-2">
                    <textarea class="form-control" name="masalah_diagnosis[]" rows="2" 
                            placeholder="Tuliskan masalah atau diagnosis keperawatan..."></textarea>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-masalah" onclick="removeMasalah(this)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
                    masalahContainer.appendChild(newField);
                }

                function addIntervensiField() {
                    const newField = document.createElement('div');
                    newField.className = 'intervensi-item mb-2';
                    newField.innerHTML = `
                <div class="d-flex gap-2">
                    <textarea class="form-control" name="intervensi_rencana[]" rows="3" 
                            placeholder="Tuliskan intervensi, rencana asuhan, dan target yang terukur..."></textarea>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-intervensi" onclick="removeIntervensi(this)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
                    intervensiContainer.appendChild(newField);
                }

                function updateMasalahRemoveButtons() {
                    const masalahItems = masalahContainer.querySelectorAll('.masalah-item');
                    masalahItems.forEach(item => {
                        const removeBtn = item.querySelector('.remove-masalah');
                        if (removeBtn) {
                            removeBtn.style.display = masalahItems.length > 1 ? 'block' : 'none';
                        }
                    });
                }

                function updateIntervensiRemoveButtons() {
                    const intervensiItems = intervensiContainer.querySelectorAll('.intervensi-item');
                    intervensiItems.forEach(item => {
                        const removeBtn = item.querySelector('.remove-intervensi');
                        if (removeBtn) {
                            removeBtn.style.display = intervensiItems.length > 1 ? 'block' : 'none';
                        }
                    });
                }

                // Global functions for remove buttons
                window.removeMasalah = function(button) {
                    const masalahItem = button.closest('.masalah-item');
                    const masalahItems = masalahContainer.querySelectorAll('.masalah-item');

                    if (masalahItems.length <= 1) {
                        showToast('warning', 'Minimal harus ada satu masalah diagnosis');
                        return;
                    }

                    masalahItem.remove();
                    updateMasalahRemoveButtons();
                    showToast('success', 'Masalah diagnosis berhasil dihapus');
                };

                window.removeIntervensi = function(button) {
                    const intervensiItem = button.closest('.intervensi-item');
                    const intervensiItems = intervensiContainer.querySelectorAll('.intervensi-item');

                    if (intervensiItems.length <= 1) {
                        showToast('warning', 'Minimal harus ada satu intervensi rencana');
                        return;
                    }

                    intervensiItem.remove();
                    updateIntervensiRemoveButtons();
                    showToast('success', 'Intervensi rencana berhasil dihapus');
                };

                // Initial setup
                updateMasalahRemoveButtons();
                updateIntervensiRemoveButtons();
            }

            // ============================================================================
            // ALERGI MANAGEMENT
            // ============================================================================

            function initializeAlergiManagement() {
                const openAlergiModal = safeQuery('#openAlergiModal');

                if (openAlergiModal) {
                    openAlergiModal.addEventListener('click', function() {
                        const modal = safeQuery('#createAlergiModal');
                        if (modal) {
                            new bootstrap.Modal(modal).show();
                        }
                    });
                }
            }

            // ============================================================================
            // MAIN INITIALIZATION
            // ============================================================================

            // Initialize all modules
            initializeAntropometriCalculation();
            initializePemeriksaanFisik();
            initializeDownScore();
            initializeRiwayatPenyakit();
            initializeStatusNyeri();
            initializeRisikoJatuh();
            initializeRisikoDekubitus();
            initializeStatusGizi();
            initializeStatusFungsional();
            initializeDischargePlanning();
            initializeDiagnosisKeperawatan();
            initializeAlergiManagement();

            console.log('Asesmen Perinatology form initialized successfully');
        });
    </script>
@endpush
