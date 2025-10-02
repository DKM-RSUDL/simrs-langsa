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
        // Pass data from PHP to JavaScript
        window.alergiPasienData = @json($alergiPasien ?? []);
        window.masalahDiagnosisData = @json($asesmen->masalah_diagnosis_parsed ?? []);
        window.intervensiRencanaData = @json($asesmen->intervensi_rencana_parsed ?? []);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            'use strict';

            // ============================================================================
            // UTILITIES
            // ============================================================================

            function showToast(message, type = 'info') {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: type,
                        title: type === 'error' ? 'Error' : type === 'success' ? 'Berhasil' : 'Informasi',
                        text: message,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                        timer: 3000
                    });
                } else {
                    alert(message);
                }
            }

            function safeQuery(selector) {
                return document.querySelector(selector);
            }

            function safeQueryAll(selector) {
                return document.querySelectorAll(selector) || [];
            }

            // ============================================================================
            // ALLERGY MODULE
            // ============================================================================

            const AllergyModule = {
                alergiDataArray: [],

                init() {
                    console.log('Initializing Allergy Module...');
                    this.loadExistingData();
                    this.initEventListeners();
                    this.updateMainAlergiTable();
                    this.updateHiddenAlergiInput();
                },

                loadExistingData() {
                    try {
                        if (typeof window.alergiPasienData !== 'undefined' && Array.isArray(window.alergiPasienData)) {
                            this.alergiDataArray = window.alergiPasienData.map(item => ({
                                jenis_alergi: item.jenis_alergi || '',
                                alergen: item.nama_alergi || item.alergen || '',
                                reaksi: item.reaksi || '',
                                tingkat_keparahan: item.tingkat_keparahan || item.severe || '',
                                is_existing: true,
                                id: item.id || null
                            }));
                            console.log('Loaded allergy data:', this.alergiDataArray);
                        }
                    } catch (e) {
                        console.error('Error loading existing alergi data:', e);
                        this.alergiDataArray = [];
                    }
                },

                initEventListeners() {
                    const openAlergiModal = safeQuery('#openAlergiModal');
                    const addToAlergiList = safeQuery('#addToAlergiList');
                    const saveAlergiData = safeQuery('#saveAlergiData');

                    if (openAlergiModal) {
                        openAlergiModal.addEventListener('click', () => {
                            this.updateModalAlergiList();
                            const modal = safeQuery('#alergiModal');
                            if (modal) new bootstrap.Modal(modal).show();
                        });
                    }

                    if (addToAlergiList) {
                        addToAlergiList.addEventListener('click', () => this.addAlergiToList());
                    }

                    if (saveAlergiData) {
                        saveAlergiData.addEventListener('click', () => this.saveAlergiData());
                    }
                },

                addAlergiToList() {
                    const jenisAlergi = safeQuery('#modal_jenis_alergi')?.value?.trim();
                    const alergen = safeQuery('#modal_alergen')?.value?.trim();
                    const reaksi = safeQuery('#modal_reaksi')?.value?.trim();
                    const tingkatKeparahan = safeQuery('#modal_tingkat_keparahan')?.value?.trim();

                    if (!jenisAlergi || !alergen || !reaksi || !tingkatKeparahan) {
                        showToast('Semua field harus diisi', 'warning');
                        return;
                    }

                    const isDuplicate = this.alergiDataArray.some(item =>
                        item.jenis_alergi === jenisAlergi &&
                        item.alergen.toLowerCase() === alergen.toLowerCase()
                    );

                    if (isDuplicate) {
                        showToast('Alergi ini sudah ada dalam daftar', 'warning');
                        return;
                    }

                    this.alergiDataArray.push({
                        jenis_alergi: jenisAlergi,
                        alergen: alergen,
                        reaksi: reaksi,
                        tingkat_keparahan: tingkatKeparahan,
                        is_existing: false
                    });

                    this.updateModalAlergiList();
                    this.resetAlergiForm();
                    showToast('Alergi berhasil ditambahkan', 'success');
                },

                updateModalAlergiList() {
                    const tbody = safeQuery('#modalAlergiList');
                    const noDataMessage = safeQuery('#noAlergiMessage');
                    const countBadge = safeQuery('#alergiCount');

                    if (!tbody) return;

                    tbody.innerHTML = '';

                    if (this.alergiDataArray.length === 0) {
                        if (noDataMessage) noDataMessage.style.display = 'block';
                        const table = tbody.closest('table');
                        if (table) table.style.display = 'none';
                    } else {
                        if (noDataMessage) noDataMessage.style.display = 'none';
                        const table = tbody.closest('table');
                        if (table) table.style.display = 'table';

                        this.alergiDataArray.forEach((item, index) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                            <td>${item.jenis_alergi}</td>
                            <td>${item.alergen}</td>
                            <td>${item.reaksi}</td>
                            <td>
                                <span class="badge ${this.getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                    ${item.tingkat_keparahan}
                                </span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm" onclick="AllergyModule.removeAlergiFromModal(${index})">
                                    <i class="bi bi-trash"></i>
                                </button>
                                ${item.is_existing ? '<div><small class="text-muted">Data Lama</small></div>' : '<div><small class="text-success">Baru</small></div>'}
                            </td>
                        `;
                            tbody.appendChild(row);
                        });
                    }

                    if (countBadge) countBadge.textContent = this.alergiDataArray.length;
                },

                updateMainAlergiTable() {
                    const tbody = safeQuery('#createAlergiTable tbody');
                    if (!tbody) return;

                    const existingRows = tbody.querySelectorAll('tr:not(#no-alergi-row)');
                    existingRows.forEach(row => row.remove());

                    const noAlergiRow = safeQuery('#no-alergi-row');

                    if (this.alergiDataArray.length === 0) {
                        if (noAlergiRow) {
                            noAlergiRow.style.display = 'table-row';
                        } else {
                            const emptyRow = document.createElement('tr');
                            emptyRow.id = 'no-alergi-row';
                            emptyRow.innerHTML = '<td colspan="5" class="text-center text-muted">Belum ada data alergi</td>';
                            tbody.appendChild(emptyRow);
                        }
                    } else {
                        if (noAlergiRow) noAlergiRow.style.display = 'none';

                        this.alergiDataArray.forEach((item, index) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                            <td>${item.jenis_alergi}</td>
                            <td>${item.alergen}</td>
                            <td>${item.reaksi}</td>
                            <td>
                                <span class="badge ${this.getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                    ${item.tingkat_keparahan}
                                </span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="AllergyModule.removeAlergiFromMain(${index})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        `;
                            tbody.appendChild(row);
                        });
                    }
                },

                saveAlergiData() {
                    this.updateMainAlergiTable();
                    this.updateHiddenAlergiInput();

                    const alergiModal = safeQuery('#alergiModal');
                    if (alergiModal && typeof bootstrap !== 'undefined') {
                        const modalInstance = bootstrap.Modal.getInstance(alergiModal);
                        if (modalInstance) modalInstance.hide();
                    }

                    showToast('Data alergi berhasil disimpan', 'success');
                },

                resetAlergiForm() {
                    const fields = ['modal_jenis_alergi', 'modal_alergen', 'modal_reaksi', 'modal_tingkat_keparahan'];
                    fields.forEach(fieldId => {
                        const field = safeQuery(`#${fieldId}`);
                        if (field) field.value = '';
                    });
                },

                updateHiddenAlergiInput() {
                    const hiddenInput = safeQuery('#alergisInput');
                    if (hiddenInput) {
                        hiddenInput.value = JSON.stringify(this.alergiDataArray);
                        console.log('Updated hidden alergi input:', hiddenInput.value);
                    }
                },

                getKeparahanBadgeClass(keparahan) {
                    switch (keparahan?.toLowerCase()) {
                        case 'ringan': return 'bg-success';
                        case 'sedang': return 'bg-warning';
                        case 'berat': return 'bg-danger';
                        default: return 'bg-secondary';
                    }
                },

                removeAlergiFromModal(index) {
                    if (confirm('Hapus alergi ini dari daftar?')) {
                        this.alergiDataArray.splice(index, 1);
                        this.updateModalAlergiList();
                        showToast('Alergi berhasil dihapus dari daftar', 'success');
                    }
                },

                removeAlergiFromMain(index) {
                    if (confirm('Hapus alergi ini?')) {
                        this.alergiDataArray.splice(index, 1);
                        this.updateMainAlergiTable();
                        this.updateHiddenAlergiInput();
                        showToast('Alergi berhasil dihapus', 'success');
                    }
                }
            };

            window.AllergyModule = AllergyModule;

            // ============================================================================
            // DOWN SCORE MODULE
            // ============================================================================

            function initializeDownScore() {
                const downScoreModal = safeQuery('#downScoreModal');
                const checkboxes = safeQueryAll('.down-score-check');
                const totalScore = safeQuery('#totalScore');
                const kesimpulan = safeQuery('#kesimpulanBox');
                const downScoreInput = safeQuery('#down_score');
                const simpanBtn = safeQuery('#btnSimpanScore');
                const btnDownScore = safeQuery('#btnDownScore');

                if (!downScoreModal) return;

                // Load existing score when modal opens
                if (btnDownScore) {
                    btnDownScore.addEventListener('click', function () {
                        const existingScore = downScoreInput?.value;
                        if (existingScore) {
                            // Try to restore selections based on score
                            // This is a simplified approach - you may need to enhance this
                            console.log('Existing down score:', existingScore);
                        }
                    });
                }

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

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function () {
                        const nama = this.name;
                        safeQueryAll(`input[name="${nama}"]`).forEach(cb => {
                            if (cb !== this) cb.checked = false;
                        });
                        hitungSkor();
                    });
                });

                simpanBtn?.addEventListener('click', function () {
                    const skor = parseInt(totalScore?.value) || 0;
                    if (downScoreInput) downScoreInput.value = skor;

                    const modal = bootstrap.Modal.getInstance(downScoreModal);
                    if (modal) modal.hide();

                    showToast('Down score berhasil disimpan', 'success');
                });

                downScoreModal.addEventListener('shown.bs.modal', function () {
                    const existingScore = downScoreInput?.value;
                    if (!existingScore) {
                        checkboxes.forEach(cb => cb.checked = false);
                        if (totalScore) totalScore.value = '0';
                        hitungSkor();
                    }
                });
            }

            // ============================================================================
            // STATUS NYERI MODULE
            // ============================================================================

            function initializeStatusNyeri() {
                const skalaSelect = safeQuery('#jenis_skala_nyeri');
                const nilaiSkalaNyeri = safeQuery('#nilai_skala_nyeri');
                const kesimpulanNyeri = safeQuery('#kesimpulan_nyeri');
                const kesimpulanNyeriAlert = safeQuery('#kesimpulan_nyeri_alert');

                if (!skalaSelect) return;

                // Load existing value
                const existingValue = skalaSelect.value;
                console.log('Existing skala nyeri:', existingValue);

                skalaSelect.addEventListener('change', function () {
                    const openModals = safeQueryAll('.modal.show');
                    openModals.forEach(modal => {
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        if (modalInstance) modalInstance.hide();
                    });

                    const modalId = {
                        'NRS': '#modalNRS',
                        'FLACC': '#modalFLACC',
                        'CRIES': '#modalCRIES'
                    }[this.value];

                    if (modalId) {
                        const modal = safeQuery(modalId);
                        if (modal) {
                            new bootstrap.Modal(modal).show();
                        }
                    }
                });

                initializeNRS();
                initializeFLACC();
                initializeCRIES();

                function initializeNRS() {
                    const nrsModal = safeQuery('#modalNRS');
                    const nrsValue = safeQuery('#nrs_value');
                    const nrsKesimpulan = safeQuery('#nrs_kesimpulan');
                    const simpanNRS = safeQuery('#simpanNRS');

                    if (!nrsModal) return;

                    nrsValue?.addEventListener('input', function () {
                        let value = parseInt(this.value);

                        if (value < 0) this.value = 0;
                        if (value > 10) this.value = 10;
                        value = parseInt(this.value);

                        const { kesimpulan, alertClass, emoji } = getNyeriKesimpulan(value);

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

                    simpanNRS?.addEventListener('click', function () {
                        const value = parseInt(nrsValue?.value);
                        if (isNaN(value)) {
                            showToast('Pilih nilai nyeri terlebih dahulu', 'warning');
                            return;
                        }

                        const { kesimpulan, alertClass, emoji } = getNyeriKesimpulan(value);

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
                        showToast('Nilai nyeri berhasil disimpan', 'success');
                    });

                    nrsModal.addEventListener('shown.bs.modal', function () {
                        // Load existing value if available
                        const existing = nilaiSkalaNyeri?.value;
                        if (existing && nrsValue) {
                            nrsValue.value = existing;
                            nrsValue.dispatchEvent(new Event('input'));
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

                        const { kesimpulan, alertClass } = getNyeriKesimpulan(total);

                        if (flaccKesimpulan) {
                            flaccKesimpulan.textContent = kesimpulan;
                            flaccKesimpulan.className = `alert py-1 px-3 mb-0 ${alertClass}`;
                        }
                    }

                    safeQueryAll('.flacc-check').forEach(check => {
                        check.addEventListener('change', updateFLACCTotal);
                    });

                    simpanFLACC?.addEventListener('click', function () {
                        const total = parseInt(flaccTotal?.value);
                        if (isNaN(total)) {
                            showToast('Pilih semua kategori terlebih dahulu', 'warning');
                            return;
                        }

                        const { kesimpulan, alertClass, emoji } = getNyeriKesimpulan(total);

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
                        showToast('Nilai nyeri FLACC berhasil disimpan', 'success');
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

                        const { kesimpulan, alertClass } = getNyeriKesimpulan(total);

                        if (criesKesimpulan) {
                            criesKesimpulan.textContent = kesimpulan;
                            criesKesimpulan.className = `alert py-1 px-3 mb-0 ${alertClass}`;
                        }
                    }

                    safeQueryAll('.cries-check').forEach(check => {
                        check.addEventListener('change', updateCRIESTotal);
                    });

                    simpanCRIES?.addEventListener('click', function () {
                        const total = parseInt(criesTotal?.value);
                        if (isNaN(total)) {
                            showToast('Pilih semua kategori terlebih dahulu', 'warning');
                            return;
                        }

                        const { kesimpulan, alertClass, emoji } = getNyeriKesimpulan(total);

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
                        showToast('Nilai nyeri CRIES berhasil disimpan', 'success');
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
            // STATUS FUNGSIONAL ADL MODULE
            // ============================================================================

            function initializeStatusFungsional() {
                const statusFungsionalSelect = safeQuery('#skala_fungsional');
                const adlTotal = safeQuery('#adl_total');
                const adlKesimpulanAlert = safeQuery('#adl_kesimpulan');

                if (!statusFungsionalSelect) return;

                // Load existing value
                const existingValue = statusFungsionalSelect.value;
                console.log('Existing skala fungsional:', existingValue);

                statusFungsionalSelect.addEventListener('change', function () {
                    if (this.value === 'Pengkajian Aktivitas') {
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
                        showToast('Skala pengukuran lainnya belum tersedia', 'warning');
                        this.value = '';
                        if (adlTotal) adlTotal.value = '';
                        if (adlKesimpulanAlert) {
                            adlKesimpulanAlert.className = 'alert alert-info';
                            adlKesimpulanAlert.textContent = 'Pilih skala aktivitas harian terlebih dahulu';
                        }
                    }
                });

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

                        const checkedCategories = new Set(Array.from(adlChecks).map(check => check.getAttribute('data-category')));
                        const allCategoriesSelected = checkedCategories.size === 3;

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

                    simpanADL?.addEventListener('click', function () {
                        const total = adlModalTotal?.value;
                        const kesimpulan = adlModalKesimpulan?.textContent;

                        if (!total || !kesimpulan || kesimpulan.includes('Pilih')) {
                            showToast('Pilih semua kategori terlebih dahulu', 'warning');
                            return;
                        }

                        if (adlTotal) adlTotal.value = total;
                        if (adlKesimpulanAlert) {
                            adlKesimpulanAlert.className = adlModalKesimpulan.className.replace('py-1 px-3 mb-0', '');
                            adlKesimpulanAlert.textContent = kesimpulan;
                        }

                        saveADLHiddenValues();

                        bootstrap.Modal.getInstance(modalADL)?.hide();
                        showToast('Data ADL berhasil disimpan', 'success');
                    });

                    modalADL.addEventListener('shown.bs.modal', function () {
                        // Load existing values if available
                        const existingTotal = adlTotal?.value;
                        if (existingTotal) {
                            console.log('Loading existing ADL data:', existingTotal);
                            // You might want to restore checkbox selections here
                        }
                    });

                    function saveADLHiddenValues() {
                        const getSelectedADLValues = () => {
                            const makanValue = safeQuery('input[name="makan"]:checked')?.value || '';
                            const berjalanValue = safeQuery('input[name="berjalan"]:checked')?.value || '';
                            const mandiValue = safeQuery('input[name="mandi"]:checked')?.value || '';

                            const getTextValue = (value) => {
                                switch (value) {
                                    case '1': return 'Mandiri';
                                    case '2': return '25% Dibantu';
                                    case '3': return '50% Dibantu';
                                    case '4': return '75% Dibantu';
                                    default: return '';
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
            // RISIKO JATUH MODULE
            // ============================================================================

            function initializeRisikoJatuh() {
                const skalaSelect = safeQuery('#risikoJatuhSkala');

                if (!skalaSelect) return;

                // Load existing form on page load
                const existingValue = skalaSelect.value;
                if (existingValue) {
                    showForm(existingValue);
                }

                skalaSelect.addEventListener('change', function () {
                    showForm(this.value);
                });

                // Initialize all risk assessment forms
                initSkalaUmum();
                initSkalaMorse();
                initSkalaHumpty();
                initSkalaOntario();

                function initSkalaUmum() {
                    const form = safeQuery('#skala_umumForm');
                    if (!form) return;

                    const selects = form.querySelectorAll('select');
                    selects.forEach(select => {
                        select.addEventListener('change', () => updateConclusion('umum'));
                    });
                }

                function initSkalaMorse() {
                    const form = safeQuery('#skala_morseForm');
                    if (!form) return;

                    const selects = form.querySelectorAll('select');
                    selects.forEach(select => {
                        select.addEventListener('change', () => updateConclusion('morse'));
                    });
                }

                function initSkalaHumpty() {
                    const form = safeQuery('#skala_humptyForm');
                    if (!form) return;

                    const selects = form.querySelectorAll('select');
                    selects.forEach(select => {
                        select.addEventListener('change', () => updateConclusion('humpty'));
                    });
                }

                function initSkalaOntario() {
                    const form = safeQuery('#skala_ontarioForm');
                    if (!form) return;

                    const selects = form.querySelectorAll('select');
                    selects.forEach(select => {
                        select.addEventListener('change', () => updateConclusion('ontario'));
                    });
                }
            }

            window.showForm = function (value) {
                const forms = safeQueryAll('.risk-form');
                forms.forEach(form => form.style.display = 'none');

                const formMap = {
                    '1': 'skala_umumForm',
                    '2': 'skala_morseForm',
                    '3': 'skala_humptyForm',
                    '4': 'skala_ontarioForm'
                };

                const formId = formMap[value];
                if (formId) {
                    const form = safeQuery(`#${formId}`);
                    if (form) form.style.display = 'block';
                }
            };

            window.updateConclusion = function (type) {
                if (type === 'umum') {
                    const answers = [
                        safeQuery('select[name="risiko_jatuh_umum_usia"]')?.value,
                        safeQuery('select[name="risiko_jatuh_umum_kondisi_khusus"]')?.value,
                        safeQuery('select[name="risiko_jatuh_umum_diagnosis_parkinson"]')?.value,
                        safeQuery('select[name="risiko_jatuh_umum_pengobatan_berisiko"]')?.value,
                        safeQuery('select[name="risiko_jatuh_umum_lokasi_berisiko"]')?.value
                    ];

                    const hasRisk = answers.some(val => val === '1');
                    const conclusion = hasRisk ? 'Berisiko jatuh' : 'Tidak berisiko jatuh';
                    const bgColor = hasRisk ? 'bg-danger' : 'bg-success';

                    const conclusionDiv = safeQuery('#skala_umumForm .conclusion');
                    if (conclusionDiv) {
                        conclusionDiv.className = `conclusion ${bgColor}`;
                        const textSpan = conclusionDiv.querySelector('#kesimpulanTextForm');
                        if (textSpan) textSpan.textContent = conclusion;
                    }

                    const hiddenInput = safeQuery('#risiko_jatuh_umum_kesimpulan');
                    if (hiddenInput) hiddenInput.value = conclusion;

                } else if (type === 'morse') {
                    const values = [
                        parseInt(safeQuery('select[name="risiko_jatuh_morse_riwayat_jatuh"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_morse_diagnosis_sekunder"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_morse_bantuan_ambulasi"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_morse_terpasang_infus"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_morse_cara_berjalan"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_morse_status_mental"]')?.value) || 0
                    ];

                    const total = values.reduce((sum, val) => sum + val, 0);
                    let conclusion, bgColor;

                    if (total <= 24) {
                        conclusion = 'Risiko Rendah';
                        bgColor = 'bg-success';
                    } else if (total <= 50) {
                        conclusion = 'Risiko Sedang';
                        bgColor = 'bg-warning';
                    } else {
                        conclusion = 'Risiko Tinggi';
                        bgColor = 'bg-danger';
                    }

                    const conclusionDiv = safeQuery('#skala_morseForm .conclusion');
                    if (conclusionDiv) {
                        conclusionDiv.className = `conclusion ${bgColor}`;
                        const textSpan = conclusionDiv.querySelector('#kesimpulanTextForm');
                        if (textSpan) textSpan.textContent = conclusion;
                    }

                    const hiddenInput = safeQuery('#risiko_jatuh_morse_kesimpulan');
                    if (hiddenInput) hiddenInput.value = conclusion;

                } else if (type === 'humpty') {
                    const values = [
                        parseInt(safeQuery('select[name="risiko_jatuh_pediatrik_usia_anak"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_pediatrik_jenis_kelamin"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_pediatrik_diagnosis"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_pediatrik_gangguan_kognitif"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_pediatrik_faktor_lingkungan"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_pediatrik_pembedahan"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_pediatrik_penggunaan_mentosa"]')?.value) || 0
                    ];

                    const total = values.reduce((sum, val) => sum + val, 0);
                    const conclusion = total >= 12 ? 'Risiko Tinggi' : 'Risiko Rendah';
                    const bgColor = total >= 12 ? 'bg-danger' : 'bg-success';

                    const conclusionDiv = safeQuery('#skala_humptyForm .conclusion');
                    if (conclusionDiv) {
                        conclusionDiv.className = `conclusion ${bgColor}`;
                        const textSpan = conclusionDiv.querySelector('#kesimpulanTextForm');
                        if (textSpan) textSpan.textContent = conclusion;
                    }

                    const hiddenInput = safeQuery('#risiko_jatuh_pediatrik_kesimpulan');
                    if (hiddenInput) hiddenInput.value = conclusion;

                } else if (type === 'ontario') {
                    const values = [
                        parseInt(safeQuery('select[name="risiko_jatuh_lansia_jatuh_saat_masuk_rs"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_lansia_riwayat_jatuh_2_bulan"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_lansia_status_bingung"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_lansia_status_disorientasi"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_lansia_status_agitasi"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_lansia_kacamata"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_lansia_kelainan_penglihatan"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_lansia_glukoma"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_lansia_perubahan_berkemih"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_lansia_transfer_bantuan_sedikit"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_lansia_transfer_bantuan_nyata"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_lansia_transfer_bantuan_total"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_lansia_mobilitas_bantuan_1_orang"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_lansia_mobilitas_kursi_roda"]')?.value) || 0,
                        parseInt(safeQuery('select[name="risiko_jatuh_lansia_mobilitas_imobilisasi"]')?.value) || 0
                    ];

                    const total = values.reduce((sum, val) => sum + val, 0);
                    let conclusion, bgColor;

                    if (total <= 5) {
                        conclusion = 'Risiko Rendah';
                        bgColor = 'bg-success';
                    } else if (total <= 15) {
                        conclusion = 'Risiko Sedang';
                        bgColor = 'bg-warning';
                    } else {
                        conclusion = 'Risiko Tinggi';
                        bgColor = 'bg-danger';
                    }

                    const conclusionDiv = safeQuery('#skala_ontarioForm .conclusion');
                    if (conclusionDiv) {
                        conclusionDiv.className = `conclusion ${bgColor}`;
                        const textSpan = conclusionDiv.querySelector('#kesimpulanTextForm');
                        if (textSpan) textSpan.textContent = conclusion;
                    }

                    const hiddenInput = safeQuery('#risiko_jatuh_lansia_kesimpulan');
                    if (hiddenInput) hiddenInput.value = conclusion;
                }
            };

            // ============================================================================
            // STATUS GIZI MODULE
            // ============================================================================

            function initializeStatusGizi() {
                const giziSelect = safeQuery('#nutritionAssessment');

                if (!giziSelect) return;

                // Load existing form
                const existingValue = giziSelect.value;
                if (existingValue) {
                    showGiziForm(existingValue);
                }

                giziSelect.addEventListener('change', function () {
                    showGiziForm(this.value);
                });

                initMSTForm();
                initMNAForm();
                initStrongKidsForm();

                function showGiziForm(value) {
                    const forms = safeQueryAll('.assessment-form');
                    forms.forEach(form => form.style.display = 'none');

                    const formMap = {
                        '1': 'mst',
                        '2': 'mna',
                        '3': 'strong-kids'
                    };

                    const formId = formMap[value];
                    if (formId) {
                        const form = safeQuery(`#${formId}`);
                        if (form) form.style.display = 'block';
                    }
                }

                function initMSTForm() {
                    const form = safeQuery('#mst');
                    if (!form) return;

                    const selects = form.querySelectorAll('select');
                    selects.forEach(select => {
                        select.addEventListener('change', updateMSTConclusion);
                    });

                    function updateMSTConclusion() {
                        const penurunanBB = parseInt(safeQuery('select[name="gizi_mst_penurunan_bb"]')?.value) || 0;
                        const jumlahPenurunan = parseInt(safeQuery('select[name="gizi_mst_jumlah_penurunan_bb"]')?.value) || 0;
                        const nafsuMakan = parseInt(safeQuery('select[name="gizi_mst_nafsu_makan_berkurang"]')?.value) || 0;
                        const diagnosisKhusus = parseInt(safeQuery('select[name="gizi_mst_diagnosis_khusus"]')?.value) || 0;

                        const total = penurunanBB + jumlahPenurunan + nafsuMakan + diagnosisKhusus;
                        const kesimpulan = total >= 2 ? '≥ 2 berisiko malnutrisi' : '0-1 tidak berisiko malnutrisi';

                        const conclusionDiv = safeQuery('#mstConclusion');
                        if (conclusionDiv) {
                            const alerts = conclusionDiv.querySelectorAll('.alert');
                            alerts.forEach(alert => alert.style.display = 'none');

                            if (total >= 2) {
                                const warningAlert = conclusionDiv.querySelector('.alert-warning');
                                if (warningAlert) warningAlert.style.display = 'block';
                            } else {
                                const successAlert = conclusionDiv.querySelector('.alert-success');
                                if (successAlert) successAlert.style.display = 'block';
                            }
                        }

                        const hiddenInput = safeQuery('#gizi_mst_kesimpulan');
                        if (hiddenInput) hiddenInput.value = kesimpulan;
                    }
                }

                function initMNAForm() {
                    const form = safeQuery('#mna');
                    if (!form) return;

                    const weightInput = safeQuery('#mnaWeight');
                    const heightInput = safeQuery('#mnaHeight');
                    const bmiInput = safeQuery('#mnaBMI');

                    function calculateBMI() {
                        const weight = parseFloat(weightInput?.value);
                        const height = parseFloat(heightInput?.value);

                        if (weight && height && height > 0) {
                            const heightInMeters = height / 100;
                            const bmi = (weight / (heightInMeters * heightInMeters)).toFixed(2);
                            if (bmiInput) bmiInput.value = bmi;
                            updateMNAConclusion();
                        }
                    }

                    weightInput?.addEventListener('input', calculateBMI);
                    heightInput?.addEventListener('input', calculateBMI);

                    const selects = form.querySelectorAll('select');
                    selects.forEach(select => {
                        select.addEventListener('change', updateMNAConclusion);
                    });

                    function updateMNAConclusion() {
                        const values = [
                            parseInt(safeQuery('select[name="gizi_mna_penurunan_asupan_3_bulan"]')?.value) || 0,
                            parseInt(safeQuery('select[name="gizi_mna_kehilangan_bb_3_bulan"]')?.value) || 0,
                            parseInt(safeQuery('select[name="gizi_mna_mobilisasi"]')?.value) || 0,
                            parseInt(safeQuery('select[name="gizi_mna_stress_penyakit_akut"]')?.value) || 0,
                            parseInt(safeQuery('select[name="gizi_mna_status_neuropsikologi"]')?.value) || 0
                        ];

                        const bmi = parseFloat(bmiInput?.value);
                        let bmiScore = 0;
                        if (bmi < 19) bmiScore = 0;
                        else if (bmi >= 19 && bmi < 21) bmiScore = 1;
                        else if (bmi >= 21 && bmi < 23) bmiScore = 2;
                        else if (bmi >= 23) bmiScore = 3;

                        const total = values.reduce((sum, val) => sum + val, 0) + bmiScore;
                        const kesimpulan = total >= 12 ? 'Total Skor ≥ 12 (Tidak Beresiko Malnutrisi)' : 'Total Skor ≤ 11 (Beresiko Malnutrisi)';

                        const conclusionDiv = safeQuery('#mnaConclusion');
                        if (conclusionDiv) {
                            const alerts = conclusionDiv.querySelectorAll('.alert');
                            alerts.forEach(alert => alert.style.display = 'none');

                            if (total >= 12) {
                                const successAlert = conclusionDiv.querySelector('.alert-success');
                                if (successAlert) successAlert.style.display = 'block';
                            } else {
                                const warningAlert = conclusionDiv.querySelector('.alert-warning');
                                if (warningAlert) warningAlert.style.display = 'block';
                            }

                            const infoAlert = conclusionDiv.querySelector('.alert-info');
                            if (infoAlert && values.some(v => v > 0) && bmi) {
                                infoAlert.style.display = 'none';
                            }
                        }

                        const hiddenInput = safeQuery('#gizi_mna_kesimpulan');
                        if (hiddenInput) hiddenInput.value = kesimpulan;
                    }
                }

                function initStrongKidsForm() {
                    const form = safeQuery('#strong-kids');
                    if (!form) return;

                    const selects = form.querySelectorAll('select');
                    selects.forEach(select => {
                        select.addEventListener('change', updateStrongKidsConclusion);
                    });

                    function updateStrongKidsConclusion() {
                        const values = [
                            parseInt(safeQuery('select[name="gizi_strong_status_kurus"]')?.value) || 0,
                            parseInt(safeQuery('select[name="gizi_strong_penurunan_bb"]')?.value) || 0,
                            parseInt(safeQuery('select[name="gizi_strong_gangguan_pencernaan"]')?.value) || 0,
                            parseInt(safeQuery('select[name="gizi_strong_penyakit_berisiko"]')?.value) || 0
                        ];

                        const total = values.reduce((sum, val) => sum + val, 0);
                        let kesimpulan;

                        if (total === 0) kesimpulan = '0 (Beresiko rendah)';
                        else if (total <= 3) kesimpulan = '1-3 (Beresiko sedang)';
                        else kesimpulan = '4-5 (Beresiko Tinggi)';

                        const conclusionDiv = safeQuery('#strongKidsConclusion');
                        if (conclusionDiv) {
                            const alerts = conclusionDiv.querySelectorAll('.alert');
                            alerts.forEach(alert => alert.style.display = 'none');

                            if (total === 0) {
                                const successAlert = conclusionDiv.querySelector('.alert-success');
                                if (successAlert) successAlert.style.display = 'block';
                            } else if (total <= 3) {
                                const warningAlert = conclusionDiv.querySelector('.alert-warning');
                                if (warningAlert) warningAlert.style.display = 'block';
                            } else {
                                const dangerAlert = conclusionDiv.querySelector('.alert-danger');
                                if (dangerAlert) dangerAlert.style.display = 'block';
                            }
                        }

                        const hiddenInput = safeQuery('#gizi_strong_kesimpulan');
                        if (hiddenInput) hiddenInput.value = kesimpulan;
                    }
                }
            }

            // ============================================================================
            // DECUBITUS MODULE
            // ============================================================================

            function initializeDecubitus() {
                const skalaSelect = safeQuery('#skalaRisikoDekubitus');

                if (!skalaSelect) return;

                // Load existing form
                const existingValue = skalaSelect.value;
                if (existingValue) {
                    showDecubitusForm(existingValue);
                }

                skalaSelect.addEventListener('change', function () {
                    showDecubitusForm(this.value);
                });

                initNortonForm();
                initBradenForm();

                function showDecubitusForm(value) {
                    const forms = safeQueryAll('.decubitus-form');
                    forms.forEach(form => form.style.display = 'none');

                    if (value === 'norton') {
                        const form = safeQuery('#formNorton');
                        if (form) form.style.display = 'block';
                    } else if (value === 'braden') {
                        const form = safeQuery('#formBraden');
                        if (form) form.style.display = 'block';
                    }
                }

                function initNortonForm() {
                    const form = safeQuery('#formNorton');
                    if (!form) return;

                    const selects = form.querySelectorAll('select');
                    selects.forEach(select => {
                        select.addEventListener('change', updateNortonConclusion);
                    });

                    function updateNortonConclusion() {
                        const values = [
                            parseInt(safeQuery('select[name="kondisi_fisik"]')?.value) || 0,
                            parseInt(safeQuery('select[name="kondisi_mental"]')?.value) || 0,
                            parseInt(safeQuery('select[name="norton_aktivitas"]')?.value) || 0,
                            parseInt(safeQuery('select[name="norton_mobilitas"]')?.value) || 0,
                            parseInt(safeQuery('select[name="inkontinensia"]')?.value) || 0
                        ];

                        const total = values.reduce((sum, val) => sum + val, 0);
                        let kesimpulan, alertClass;

                        if (total <= 14) {
                            kesimpulan = 'Risiko Tinggi';
                            alertClass = 'alert-danger';
                        } else if (total <= 18) {
                            kesimpulan = 'Risiko Sedang';
                            alertClass = 'alert-warning';
                        } else {
                            kesimpulan = 'Risiko Rendah';
                            alertClass = 'alert-success';
                        }

                        const kesimpulanDiv = safeQuery('#kesimpulanNorton');
                        if (kesimpulanDiv) {
                            kesimpulanDiv.textContent = kesimpulan;
                            kesimpulanDiv.className = `alert ${alertClass} mb-0 flex-grow-1`;
                        }

                        // Update hidden input (if exists)
                        const hiddenInput = safeQuery('input[name="decubitus_kesimpulan"]');
                        if (hiddenInput) hiddenInput.value = kesimpulan;
                    }
                }

                function initBradenForm() {
                    const form = safeQuery('#formBraden');
                    if (!form) return;

                    const selects = form.querySelectorAll('select');
                    selects.forEach(select => {
                        select.addEventListener('change', updateBradenConclusion);
                    });

                    function updateBradenConclusion() {
                        const values = [
                            parseInt(safeQuery('select[name="persepsi_sensori"]')?.value) || 0,
                            parseInt(safeQuery('select[name="kelembapan"]')?.value) || 0,
                            parseInt(safeQuery('select[name="braden_aktivitas"]')?.value) || 0,
                            parseInt(safeQuery('select[name="braden_mobilitas"]')?.value) || 0,
                            parseInt(safeQuery('select[name="nutrisi"]')?.value) || 0,
                            parseInt(safeQuery('select[name="pergesekan"]')?.value) || 0
                        ];

                        const total = values.reduce((sum, val) => sum + val, 0);
                        let kesimpulan, alertClass;

                        if (total <= 12) {
                            kesimpulan = 'Risiko Tinggi';
                            alertClass = 'alert-danger';
                        } else if (total <= 16) {
                            kesimpulan = 'Risiko Sedang';
                            alertClass = 'alert-warning';
                        } else {
                            kesimpulan = 'Risiko Rendah';
                            alertClass = 'alert-success';
                        }

                        const kesimpulanDiv = safeQuery('#kesimpulanBraden');
                        if (kesimpulanDiv) {
                            kesimpulanDiv.textContent = kesimpulan;
                            kesimpulanDiv.className = `alert ${alertClass} mb-0 flex-grow-1`;
                        }

                        // Update hidden input (if exists)
                        const hiddenInput = safeQuery('input[name="decubitus_kesimpulan"]');
                        if (hiddenInput) hiddenInput.value = kesimpulan;
                    }
                }
            }

            // ============================================================================
            // PEMERIKSAAN FISIK
            // ============================================================================

            function initializePemeriksaanFisik() {
                // Set default checked state DULU sebelum menambahkan event listener
                safeQueryAll('.pemeriksaan-item .form-check-input').forEach(checkbox => {
                    // Hanya set default jika belum ada value (untuk form create)
                    if (checkbox.checked === undefined || checkbox.checked === null) {
                        checkbox.checked = true;
                    }
                    
                    const keteranganDiv = checkbox.closest('.pemeriksaan-item')?.querySelector('.keterangan');
                    if (keteranganDiv && checkbox.checked) {
                        keteranganDiv.style.display = 'none';
                        const input = keteranganDiv.querySelector('input');
                        if (input) input.value = '';
                    }
                });

                // Toggle keterangan form saat button "+" diklik
                safeQueryAll('.tambah-keterangan').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault(); // Mencegah form submit
                        
                        const targetId = this.getAttribute('data-target');
                        const keteranganDiv = safeQuery(`#${targetId}`);
                        const pemeriksaanItem = this.closest('.pemeriksaan-item');
                        const normalCheckbox = pemeriksaanItem?.querySelector('.form-check-input');

                        if (keteranganDiv && normalCheckbox) {
                            // Toggle display
                            if (keteranganDiv.style.display === 'none' || keteranganDiv.style.display === '') {
                                keteranganDiv.style.display = 'block';
                                normalCheckbox.checked = false;
                                
                                // Focus pada input
                                const input = keteranganDiv.querySelector('input');
                                if (input) {
                                    setTimeout(() => input.focus(), 100);
                                }
                            } else {
                                keteranganDiv.style.display = 'none';
                            }
                        }
                    });
                });

                // Handle normal checkbox change
                safeQueryAll('.pemeriksaan-item .form-check-input').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const pemeriksaanItem = this.closest('.pemeriksaan-item');
                        const keteranganDiv = pemeriksaanItem?.querySelector('.keterangan');
                        
                        if (keteranganDiv) {
                            if (this.checked) {
                                // Jika dicentang normal, sembunyikan keterangan dan reset input
                                keteranganDiv.style.display = 'none';
                                const input = keteranganDiv.querySelector('input');
                                if (input) input.value = '';
                            } else {
                                // Jika uncheck, tampilkan keterangan
                                keteranganDiv.style.display = 'block';
                                const input = keteranganDiv.querySelector('input');
                                if (input) {
                                    setTimeout(() => input.focus(), 100);
                                }
                            }
                        }
                    });
                });
            }

            // ============================================================================
            // MASALAH DIAGNOSIS & INTERVENSI MODULE
            // ============================================================================

            const MasalahDiagnosisModule = {
                init() {
                    console.log('Initializing Masalah Diagnosis Module...');
                    this.initMasalahFields();
                    this.initIntervensiFields();
                },

                initMasalahFields() {
                    const masalahContainer = safeQuery('#masalahContainer');
                    const btnTambahMasalah = safeQuery('#btnTambahMasalah');

                    if (!masalahContainer) {
                        console.warn('masalahContainer not found');
                        return;
                    }

                    let existingData = [];
                    if (typeof window.masalahDiagnosisData !== 'undefined') {
                        existingData = window.masalahDiagnosisData;
                    }

                    masalahContainer.innerHTML = '';

                    if (existingData && existingData.length > 0) {
                        existingData.forEach((masalah, index) => {
                            this.addMasalahField(masalahContainer, masalah, index === 0);
                        });
                    } else {
                        this.addMasalahField(masalahContainer, '', true);
                    }

                    btnTambahMasalah?.addEventListener('click', () => {
                        this.addMasalahField(masalahContainer, '', false);
                    });
                },

                initIntervensiFields() {
                    const intervensiContainer = safeQuery('#intervensiContainer');
                    const btnTambahIntervensi = safeQuery('#btnTambahIntervensi');

                    if (!intervensiContainer) {
                        console.warn('intervensiContainer not found');
                        return;
                    }

                    let existingData = [];
                    if (typeof window.intervensiRencanaData !== 'undefined') {
                        existingData = window.intervensiRencanaData;
                    }

                    intervensiContainer.innerHTML = '';

                    if (existingData && existingData.length > 0) {
                        existingData.forEach((intervensi, index) => {
                            this.addIntervensiField(intervensiContainer, intervensi, index === 0);
                        });
                    } else {
                        this.addIntervensiField(intervensiContainer, '', true);
                    }

                    btnTambahIntervensi?.addEventListener('click', () => {
                        this.addIntervensiField(intervensiContainer, '', false);
                    });
                },

                addMasalahField(container, value = '', isFirst = false) {
                    const masalahItem = document.createElement('div');
                    masalahItem.className = 'masalah-item mb-2';

                    masalahItem.innerHTML = `
                    <div class="d-flex gap-2">
                        <textarea class="form-control" name="masalah_diagnosis[]" rows="2"
                            placeholder="Tuliskan masalah atau diagnosis keperawatan...">${value}</textarea>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-masalah"
                            style="display: ${isFirst ? 'none' : 'block'};">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;

                    container.appendChild(masalahItem);

                    const removeBtn = masalahItem.querySelector('.remove-masalah');
                    if (removeBtn) {
                        removeBtn.addEventListener('click', () => {
                            masalahItem.remove();
                            this.updateMasalahRemoveButtons();
                        });
                    }

                    this.updateMasalahRemoveButtons();
                },

                addIntervensiField(container, value = '', isFirst = false) {
                    const intervensiItem = document.createElement('div');
                    intervensiItem.className = 'intervensi-item mb-2';

                    intervensiItem.innerHTML = `
                    <div class="d-flex gap-2">
                        <textarea class="form-control" name="intervensi_rencana[]" rows="3"
                            placeholder="Tuliskan intervensi, rencana asuhan, dan target yang terukur...">${value}</textarea>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-intervensi"
                            style="display: ${isFirst ? 'none' : 'block'};">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;

                    container.appendChild(intervensiItem);

                    const removeBtn = intervensiItem.querySelector('.remove-intervensi');
                    if (removeBtn) {
                        removeBtn.addEventListener('click', () => {
                            intervensiItem.remove();
                            this.updateIntervensiRemoveButtons();
                        });
                    }

                    this.updateIntervensiRemoveButtons();
                },

                updateMasalahRemoveButtons() {
                    const masalahItems = safeQueryAll('.masalah-item');
                    masalahItems.forEach((item, index) => {
                        const removeBtn = item.querySelector('.remove-masalah');
                        if (removeBtn) {
                            removeBtn.style.display = (index === 0 && masalahItems.length === 1) ? 'none' : 'block';
                        }
                    });
                },

                updateIntervensiRemoveButtons() {
                    const intervensiItems = safeQueryAll('.intervensi-item');
                    intervensiItems.forEach((item, index) => {
                        const removeBtn = item.querySelector('.remove-intervensi');
                        if (removeBtn) {
                            removeBtn.style.display = (index === 0 && intervensiItems.length === 1) ? 'none' : 'block';
                        }
                    });
                }
            };

            // ============================================================================
            // DISCHARGE PLANNING MODULE
            // ============================================================================

            function initializeDischargePlanning() {
                const fields = [
                    'usia_lanjut',
                    'hambatan_mobilisasi',
                    'penggunaan_media_berkelanjutan',
                    'ketergantungan_aktivitas',
                    'keterampilan_khusus',
                    'alat_bantu',
                    'nyeri_kronis'
                ];

                fields.forEach(fieldName => {
                    const select = safeQuery(`select[name="${fieldName}"]`);
                    if (select) {
                        select.addEventListener('change', updateDischargePlanningKesimpulan);
                    }
                });

                function updateDischargePlanningKesimpulan() {
                    const values = fields.map(field => {
                        const select = safeQuery(`select[name="${field}"]`);
                        return select?.value;
                    });

                    const allFilled = values.every(val => val !== '' && val !== null);
                    const hasYa = values.some(val => val === 'ya' || val === '0');

                    const kesimpulanInput = safeQuery('#kesimpulan');

                    if (!allFilled) {
                        // Show info alert
                        showDischargePlanningAlert('info', 'Pilih semua Planning');
                        if (kesimpulanInput) kesimpulanInput.value = 'Pilih semua Planning';
                    } else if (hasYa) {
                        // Show warning alert
                        showDischargePlanningAlert('warning', 'Membutuhkan rencana pulang khusus');
                        if (kesimpulanInput) kesimpulanInput.value = 'Membutuhkan rencana pulang khusus';
                    } else {
                        // Show success alert
                        showDischargePlanningAlert('success', 'Tidak membutuhkan rencana pulang khusus');
                        if (kesimpulanInput) kesimpulanInput.value = 'Tidak membutuhkan rencana pulang khusus';
                    }
                }

                function showDischargePlanningAlert(type, message) {
                    const container = safeQuery('#discharge-planning .mt-4');
                    if (!container) return;

                    const alerts = container.querySelectorAll('.alert');
                    alerts.forEach(alert => alert.style.display = 'none');

                    const alertClass = {
                        'info': 'alert-info',
                        'warning': 'alert-warning',
                        'success': 'alert-success'
                    }[type];

                    let targetAlert;
                    if (type === 'info') {
                        targetAlert = container.querySelector('.alert-info');
                    } else if (type === 'warning') {
                        targetAlert = container.querySelector('.alert-warning');
                    } else {
                        targetAlert = container.querySelector('.alert-success');
                    }

                    if (targetAlert) {
                        targetAlert.style.display = 'block';
                    }
                }

                // Initialize on load
                updateDischargePlanningKesimpulan();
            }

            // ============================================================================
            // INTERVENSI RISIKO JATUH MODULE
            // ============================================================================

            function initializeIntervensiRisikoJatuh() {
                const modal = safeQuery('#tindakanKeperawatanRisikoJatuhModal');
                if (!modal) return;

                const saveBtn = modal.querySelector('.btn-save-tindakan-keperawatan');

                saveBtn?.addEventListener('click', function () {
                    const selectedIntervensi = [];
                    modal.querySelectorAll('.intervensi-risiko-jatuh-options input[type="checkbox"]:checked').forEach(checkbox => {
                        selectedIntervensi.push(checkbox.value);
                    });

                    const selectedList = safeQuery('#selectedTindakanList-risikojatuh');
                    if (selectedList) {
                        selectedList.innerHTML = selectedIntervensi.map(item => `
                        <div class="alert alert-light border d-flex justify-content-between align-items-center py-2 mb-1">
                            <span>${item}</span>
                            <button type="button" class="btn btn-sm btn-link text-danger delete-intervensi p-0 m-0" onclick="deleteIntervensi(this)">
                                <i class="ti-trash"></i>
                            </button>
                        </div>
                    `).join('');
                    }

                    const hiddenInput = safeQuery('#intervensi_risiko_jatuh_json');
                    if (hiddenInput) {
                        hiddenInput.value = JSON.stringify(selectedIntervensi);
                    }

                    const noIntervensiCheckbox = safeQuery('#intervensiRisikoJatuh4');
                    if (noIntervensiCheckbox && noIntervensiCheckbox.checked) {
                        modal.querySelectorAll('.intervensi-risiko-jatuh-options input[type="checkbox"]').forEach(checkbox => {
                            if (checkbox.id !== 'intervensiRisikoJatuh4') {
                                checkbox.checked = false;
                            }
                        });
                    }

                    bootstrap.Modal.getInstance(modal)?.hide();
                    showToast('Intervensi risiko jatuh berhasil disimpan', 'success');
                });

                // Handle "Tidak ada intervensi" checkbox
                const noIntervensiCheckbox = safeQuery('#intervensiRisikoJatuh4');
                noIntervensiCheckbox?.addEventListener('change', function () {
                    modal.querySelectorAll('.intervensi-risiko-jatuh-options input[type="checkbox"]').forEach(checkbox => {
                        if (checkbox.id !== 'intervensiRisikoJatuh4') {
                            checkbox.disabled = this.checked;
                            if (this.checked) checkbox.checked = false;
                        }
                    });
                });

                // Handle other checkboxes
                modal.querySelectorAll('.intervensi-risiko-jatuh-options input[type="checkbox"]').forEach(checkbox => {
                    if (checkbox.id !== 'intervensiRisikoJatuh4') {
                        checkbox.addEventListener('change', function () {
                            const noIntervensiCheckbox = safeQuery('#intervensiRisikoJatuh4');
                            if (this.checked && noIntervensiCheckbox) {
                                noIntervensiCheckbox.checked = false;
                                noIntervensiCheckbox.disabled = true;
                            } else {
                                const anyChecked = Array.from(modal.querySelectorAll('.intervensi-risiko-jatuh-options input[type="checkbox"]'))
                                    .some(cb => cb.id !== 'intervensiRisikoJatuh4' && cb.checked);
                                if (noIntervensiCheckbox) {
                                    noIntervensiCheckbox.disabled = anyChecked;
                                }
                            }
                        });
                    }
                });
            }

            window.deleteIntervensi = function (button) {
                const interventionText = button.parentElement.querySelector('span').textContent;

                const modal = safeQuery('#tindakanKeperawatanRisikoJatuhModal');
                if (modal) {
                    modal.querySelectorAll('.intervensi-risiko-jatuh-options input[type="checkbox"]').forEach(checkbox => {
                        if (checkbox.value === interventionText) {
                            checkbox.checked = false;
                            checkbox.dispatchEvent(new Event('change'));
                        }
                    });
                }

                button.parentElement.remove();

                const remainingIntervensi = [];
                safeQueryAll('#selectedTindakanList-risikojatuh span').forEach(span => {
                    remainingIntervensi.push(span.textContent);
                });

                const hiddenInput = safeQuery('#intervensi_risiko_jatuh_json');
                if (hiddenInput) {
                    hiddenInput.value = JSON.stringify(remainingIntervensi);
                }

                showToast('Intervensi berhasil dihapus', 'success');
            };

            // ============================================================================
            // MAIN INITIALIZATION
            // ============================================================================

            function initializeApp() {
                console.log('Initializing Asesmen Perinatology Edit Page...');

                try {
                    // Core modules
                    AllergyModule.init();
                    MasalahDiagnosisModule.init();

                    // Feature modules
                    initializeDownScore();
                    initializeStatusNyeri();
                    initializeStatusFungsional();
                    initializeRisikoJatuh();
                    initializeStatusGizi();
                    initializeDecubitus();
                    initializePemeriksaanFisik();
                    initializeDischargePlanning();
                    initializeIntervensiRisikoJatuh();

                    console.log('All modules initialized successfully');
                } catch (error) {
                    console.error('Error during initialization:', error);
                    showToast('Terjadi kesalahan saat menginisialisasi halaman', 'error');
                }
            }

            // Start the application
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initializeApp);
            } else {
                initializeApp();
            }

            console.log('Asesmen Perinatology Edit script loaded');
        });

        // ============================================================================
        // MASALAH/ DIAGNOSIS KEPERAWATAN
        // ============================================================================
        function toggleRencana(diagnosisType) {
            // Handle special case for respiratory group (3 diagnosis yang menggunakan 1 rencana)
            const respiratoryGroup = ['bersihan_jalan_nafas', 'risiko_aspirasi', 'pola_nafas_tidak_efektif'];
            
            if (respiratoryGroup.includes(diagnosisType)) {
                // Check if any of the 3 respiratory checkboxes is checked
                const anyRespChecked = respiratoryGroup.some(diagnosis => {
                    const checkbox = document.getElementById('diag_' + diagnosis);
                    return checkbox && checkbox.checked;
                });
                
                const rencanaDiv = document.getElementById('rencana_bersihan_jalan_nafas');
                if (rencanaDiv) {
                    if (anyRespChecked) {
                        rencanaDiv.style.display = 'block';
                    } else {
                        rencanaDiv.style.display = 'none';
                        // Uncheck all rencana checkboxes when no respiratory diagnosis is checked
                        const rencanaCheckboxes = rencanaDiv.querySelectorAll('input[type="checkbox"]');
                        rencanaCheckboxes.forEach(cb => cb.checked = false);
                    }
                }
            } else {
                // Handle normal case (1 diagnosis = 1 rencana)
                const checkbox = document.getElementById('diag_' + diagnosisType);
                const rencanaDiv = document.getElementById('rencana_' + diagnosisType);

                if (checkbox && rencanaDiv) {
                    if (checkbox.checked) {
                        rencanaDiv.style.display = 'block';
                    } else {
                        rencanaDiv.style.display = 'none';
                        // Uncheck all rencana checkboxes when diagnosis is unchecked
                        const rencanaCheckboxes = rencanaDiv.querySelectorAll('input[type="checkbox"]');
                        rencanaCheckboxes.forEach(cb => cb.checked = false);
                    }
                }
            }
        }

        // KODE BARU: Initialize untuk mode EDIT - tampilkan rencana yang sudah tercentang
        document.addEventListener('DOMContentLoaded', function() {
            // Daftar semua diagnosis
            const allDiagnosis = [
                'bersihan_jalan_nafas', 
                'risiko_aspirasi', 
                'pola_nafas_tidak_efektif',
                'penurunan_curah_jantung',
                'perfusi_perifer',
                'hipovolemia',
                'hipervolemia',
                'diare',
                'retensi_urine',
                'nyeri_akut',
                'nyeri_kronis',
                'hipertermia',
                'gangguan_mobilitas_fisik',
                'resiko_infeksi',
                'konstipasi',
                'resiko_jatuh',
                'gangguan_integritas_kulit'
            ];

            // Loop semua diagnosis dan trigger toggleRencana jika checkbox sudah tercentang
            allDiagnosis.forEach(diagnosis => {
                const checkbox = document.getElementById('diag_' + diagnosis);
                if (checkbox && checkbox.checked) {
                    toggleRencana(diagnosis);
                }
            });
        });
    </script>
@endpush