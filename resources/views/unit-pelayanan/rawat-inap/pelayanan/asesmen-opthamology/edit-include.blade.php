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
            //==================================================================================================//
            // i. Inisialisasi LTP IMT
            //==================================================================================================//
            function hitungIMT_LPT() {
                let tinggi = parseFloat(document.getElementById("tinggi_badan").value) / 100; // Konversi ke meter
                let berat = parseFloat(document.getElementById("berat_badan").value);

                if (!isNaN(tinggi) && !isNaN(berat) && tinggi > 0) {
                    let imt = berat / (tinggi * tinggi);
                    let lpt = (tinggi * 100 * berat) / 3600; // Tinggi dikonversi ke cm

                    document.getElementById("imt").value = imt.toFixed(2); // Menampilkan 2 desimal
                    document.getElementById("lpt").value = lpt.toFixed(2);
                } else {
                    document.getElementById("imt").value = "";
                    document.getElementById("lpt").value = "";
                }
            }

            document.getElementById("tinggi_badan").addEventListener("input", hitungIMT_LPT);
            document.getElementById("berat_badan").addEventListener("input", hitungIMT_LPT);

            //==================================================================================================//
            // ii. Inisialisasi Pemeriksaan Fisik
            //==================================================================================================//
            document.querySelectorAll('.tambah-keterangan').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const keteranganDiv = document.getElementById(targetId);
                    const normalCheckbox = this.closest('.pemeriksaan-item').querySelector(
                        '.form-check-input');

                    // Toggle tampilan keterangan
                    if (keteranganDiv.style.display === 'none') {
                        keteranganDiv.style.display = 'block';
                        normalCheckbox.checked = false; // Uncheck normal checkbox
                    } else {
                        keteranganDiv.style.display = 'block';
                    }
                });
            });

            document.querySelectorAll('.form-check-input').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const pemeriksaanItem = this.closest('.pemeriksaan-item');
                    if (pemeriksaanItem) {
                        const keteranganDiv = pemeriksaanItem.querySelector('.keterangan');
                        if (keteranganDiv) {
                            if (this.checked) {
                                keteranganDiv.style.display = 'none';
                                const input = keteranganDiv.querySelector('input');
                                if (input) input.value = '';
                            }
                        }
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.pemeriksaan-item').forEach(item => {
                    const keteranganInput = item.querySelector('.keterangan input');
                    const normalCheckbox = item.querySelector('.form-check-input');
                    const keteranganDiv = item.querySelector('.keterangan');

                    // Jika ada nilai keterangan
                    if (keteranganInput && keteranganInput.value) {
                        normalCheckbox.checked = false;
                        keteranganDiv.style.display = 'block';
                    }
                });
            });

            //==================================================================================================//
            // iii. Inisialisasi Tanggal Jam Masuk
            //==================================================================================================//
            const currentDate = new Date();
            const formattedDate = currentDate.toISOString().split('T')[0];
            document.getElementById('tanggal_masuk').value = formattedDate;
            
            const hours = String(currentDate.getHours()).padStart(2, '0');
            const minutes = String(currentDate.getMinutes()).padStart(2, '0');
            document.getElementById('jam_masuk').value = `${hours}:${minutes}`;


            //==================================================================================================//
            // 4. Inisialisasi Status Nyeri
            //==================================================================================================//
            const skalaSelect = document.getElementById('jenis_skala_nyeri');
            const nrsModal = document.getElementById('modalNRS');
            const flaccModal = document.getElementById('modalFLACC');
            const criesModal = document.getElementById('modalCRIES');
            const nrsValue = document.getElementById('nrs_value');
            const nrsKesimpulan = document.getElementById('nrs_kesimpulan');
            const simpanNRS = document.getElementById('simpanNRS');
            const nilaiSkalaNyeri = document.getElementById('nilai_skala_nyeri');
            const kesimpulanNyeri = document.getElementById('kesimpulan_nyeri');
            const kesimpulanNyeriAlert = document.getElementById('kesimpulan_nyeri_alert');

            if (skalaSelect) {
                skalaSelect.addEventListener('change', function() {
                    // Close any open modals first
                    const openModals = document.querySelectorAll('.modal.show');
                    openModals.forEach(modal => {
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        if (modalInstance) modalInstance.hide();
                    });

                    // Show the selected modal
                    if (this.value === 'NRS') {
                        const modal = new bootstrap.Modal(nrsModal);
                        modal.show();
                    } else if (this.value === 'FLACC') {
                        const modal = new bootstrap.Modal(flaccModal);
                        modal.show();
                    } else if (this.value === 'CRIES') {
                        const modal = new bootstrap.Modal(criesModal);
                        modal.show();
                    }
                });
            }

            // NRS value handler
            if (nrsValue) {
                nrsValue.addEventListener('input', function() {
                    let value = parseInt(this.value);

                    // Validate range
                    if (value < 0) this.value = 0;
                    if (value > 10) this.value = 10;
                    value = parseInt(this.value);

                    // Set kesimpulan
                    let kesimpulan = '';
                    let alertClass = '';
                    let emoji = '';

                    if (value >= 0 && value <= 3) {
                        kesimpulan = 'Nyeri Ringan';
                        alertClass = 'alert-success';
                        emoji = 'bi-emoji-smile';
                    } else if (value >= 4 && value <= 6) {
                        kesimpulan = 'Nyeri Sedang';
                        alertClass = 'alert-warning';
                        emoji = 'bi-emoji-neutral';
                    } else if (value >= 7 && value <= 10) {
                        kesimpulan = 'Nyeri Berat';
                        alertClass = 'alert-danger';
                        emoji = 'bi-emoji-frown';
                    }

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
            }

            // Save NRS value
            if (simpanNRS) {
                simpanNRS.addEventListener('click', function() {
                    if (nilaiSkalaNyeri && nrsValue && kesimpulanNyeri && kesimpulanNyeriAlert) {
                        const value = parseInt(nrsValue.value);
                        nilaiSkalaNyeri.value = value;

                        let kesimpulan = '';
                        let alertClass = '';
                        let emoji = '';

                        if (value >= 0 && value <= 3) {
                            kesimpulan = 'Nyeri Ringan';
                            alertClass = 'alert-success';
                            emoji = 'bi-emoji-smile';
                        } else if (value >= 4 && value <= 6) {
                            kesimpulan = 'Nyeri Sedang';
                            alertClass = 'alert-warning';
                            emoji = 'bi-emoji-neutral';
                        } else if (value >= 7 && value <= 10) {
                            kesimpulan = 'Nyeri Berat';
                            alertClass = 'alert-danger';
                            emoji = 'bi-emoji-frown';
                        }

                        // Update both the input and alert
                        kesimpulanNyeri.value = kesimpulan;
                        kesimpulanNyeriAlert.innerHTML = `
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi ${emoji} fs-4"></i>
                                <span>${kesimpulan}</span>
                            </div>
                        `;
                        kesimpulanNyeriAlert.className = `alert ${alertClass}`;

                        bootstrap.Modal.getInstance(nrsModal).hide();
                    }
                });
            }

            // Reset form when modal is closed
            if (nrsModal) {
                nrsModal.addEventListener('hidden.bs.modal', function() {
                    if (nrsValue && nrsKesimpulan) {
                        nrsValue.value = '';
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

            // FLACC Handler
            const updateFLACCTotal = () => {
                const flaccChecks = document.querySelectorAll('.flacc-check:checked');
                const flaccTotal = document.getElementById('flaccTotal');
                const flaccKesimpulan = document.getElementById('flaccKesimpulan');

                let total = 0;
                flaccChecks.forEach(check => {
                    total += parseInt(check.value);
                });

                flaccTotal.value = total;

                // Update kesimpulan
                let kesimpulan = '';
                let alertClass = '';
                let emoji = '';

                if (total >= 0 && total <= 3) {
                    kesimpulan = 'Nyeri Ringan';
                    alertClass = 'alert-success';
                    emoji = 'bi-emoji-smile';
                } else if (total >= 4 && total <= 6) {
                    kesimpulan = 'Nyeri Sedang';
                    alertClass = 'alert-warning';
                    emoji = 'bi-emoji-neutral';
                } else {
                    kesimpulan = 'Nyeri Berat';
                    alertClass = 'alert-danger';
                    emoji = 'bi-emoji-frown';
                }

                // Update kesimpulan di modal FLACC
                if (flaccKesimpulan) {
                    flaccKesimpulan.textContent = kesimpulan;
                    flaccKesimpulan.className = `alert py-1 px-3 mb-0 ${alertClass}`;
                }
            };

            // Add event listeners to FLACC checkboxes
            document.querySelectorAll('.flacc-check').forEach(check => {
                check.addEventListener('change', updateFLACCTotal);
            });

            // Handle FLACC save button
            const simpanFLACC = document.getElementById('simpanFLACC');
            if (simpanFLACC) {
                simpanFLACC.addEventListener('click', function() {
                    const flaccTotal = document.getElementById('flaccTotal');

                    if (nilaiSkalaNyeri && flaccTotal && flaccTotal.value !== '') {
                        let total = parseInt(flaccTotal.value);
                        let kesimpulan = '';
                        let alertClass = '';
                        let emoji = '';

                        if (total >= 0 && total <= 3) {
                            kesimpulan = 'Nyeri Ringan';
                            alertClass = 'alert-success';
                            emoji = 'bi-emoji-smile';
                        } else if (total >= 4 && total <= 6) {
                            kesimpulan = 'Nyeri Sedang';
                            alertClass = 'alert-warning';
                            emoji = 'bi-emoji-neutral';
                        } else {
                            kesimpulan = 'Nyeri Berat';
                            alertClass = 'alert-danger';
                            emoji = 'bi-emoji-frown';
                        }

                        // Update all relevant fields
                        nilaiSkalaNyeri.value = total;
                        kesimpulanNyeri.value = kesimpulan;
                        kesimpulanNyeriAlert.innerHTML = `
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi ${emoji} fs-4"></i>
                                <span>${kesimpulan}</span>
                            </div>
                        `;
                        kesimpulanNyeriAlert.className = `alert ${alertClass}`;

                        bootstrap.Modal.getInstance(flaccModal).hide();
                    }
                });
            }

            // Reset FLACC form when modal is closed
            const modalFLACC = document.getElementById('modalFLACC');
            if (modalFLACC) {
                modalFLACC.addEventListener('hidden.bs.modal', function() {

                    const flaccKesimpulan = document.getElementById('flaccKesimpulan');
                    if (flaccKesimpulan) {
                        flaccKesimpulan.textContent = 'Pilih kategori untuk melihat kesimpulan';
                        flaccKesimpulan.className = 'alert alert-info py-1 px-3 mb-0';
                    }
                });
            }

            // CRIES Handler
            const updateCRIESTotal = () => {
                const criesChecks = document.querySelectorAll('.cries-check:checked');
                const criesTotal = document.getElementById('criesTotal');
                const criesKesimpulan = document.getElementById('criesKesimpulan');

                let total = 0;
                criesChecks.forEach(check => {
                    total += parseInt(check.value);
                });

                criesTotal.value = total;

                // Update kesimpulan
                let kesimpulan = '';
                let alertClass = '';
                let emoji = '';

                if (total >= 0 && total <= 3) {
                    kesimpulan = 'Nyeri Ringan';
                    alertClass = 'alert-success';
                    emoji = 'bi-emoji-smile';
                } else if (total >= 4 && total <= 6) {
                    kesimpulan = 'Nyeri Sedang';
                    alertClass = 'alert-warning';
                    emoji = 'bi-emoji-neutral';
                } else {
                    kesimpulan = 'Nyeri Berat';
                    alertClass = 'alert-danger';
                    emoji = 'bi-emoji-frown';
                }

                // Update kesimpulan di modal CRIES
                if (criesKesimpulan) {
                    criesKesimpulan.textContent = kesimpulan;
                    criesKesimpulan.className = `alert py-1 px-3 mb-0 ${alertClass}`;
                }
            };

            // Add event listeners to CRIES checkboxes
            document.querySelectorAll('.cries-check').forEach(check => {
                check.addEventListener('change', updateCRIESTotal);
            });

            // Handle CRIES save button
            const simpanCRIES = document.getElementById('simpanCRIES');
            if (simpanCRIES) {
                simpanCRIES.addEventListener('click', function() {
                    const criesTotal = document.getElementById('criesTotal');

                    if (nilaiSkalaNyeri && criesTotal && criesTotal.value !== '') {
                        let total = criesTotal.value ? parseInt(criesTotal.value) : null;
                        let kesimpulan = '';
                        let alertClass = '';
                        let emoji = '';

                        if (total >= 0 && total <= 3) {
                            kesimpulan = 'Nyeri Ringan';
                            alertClass = 'alert-success';
                            emoji = 'bi-emoji-smile';
                        } else if (total >= 4 && total <= 6) {
                            kesimpulan = 'Nyeri Sedang';
                            alertClass = 'alert-warning';
                            emoji = 'bi-emoji-neutral';
                        } else {
                            kesimpulan = 'Nyeri Berat';
                            alertClass = 'alert-danger';
                            emoji = 'bi-emoji-frown';
                        }

                        // Update all relevant fields
                        nilaiSkalaNyeri.value = total;
                        kesimpulanNyeri.value = kesimpulan;
                        kesimpulanNyeriAlert.innerHTML = `
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi ${emoji} fs-4"></i>
                                <span>${kesimpulan}</span>
                            </div>
                        `;
                        kesimpulanNyeriAlert.className = `alert ${alertClass}`;

                        bootstrap.Modal.getInstance(criesModal).hide();
                    }
                });
            }

            // Reset CRIES form when modal is closed
            const modalCRIES = document.getElementById('modalCRIES');
            if (modalCRIES) {
                modalCRIES.addEventListener('hidden.bs.modal', function() {

                    const criesKesimpulan = document.getElementById('criesKesimpulan');
                    if (criesKesimpulan) {
                        criesKesimpulan.textContent = 'Pilih semua kategori untuk melihat kesimpulan';
                        criesKesimpulan.className = 'alert alert-info py-1 px-3 mb-0';
                    }
                });
            }


            //==================================================================================================//
            // 5. Inisialisasi Discharge Planning
            //==================================================================================================//
            const dischargePlanningSection = document.getElementById('discharge-planning');
            const allSelects = dischargePlanningSection.querySelectorAll('select');
            const alertWarning = dischargePlanningSection.querySelector('.alert-warning');
            const alertSuccess = dischargePlanningSection.querySelector('.alert-success');
            const alertInfo = dischargePlanningSection.querySelector('.alert-info');

            function updateDischargePlanningConclusion() {
                let needsSpecialPlan = false;
                let allSelected = true;
                const kesimpulanInput = document.getElementById('kesimpulan');

                // Cek semua select
                allSelects.forEach(select => {
                    if (!select.value) {
                        allSelected = false;
                    } else if (select.value === 'ya') {
                        needsSpecialPlan = true;
                    }
                });

                // Jika belum semua dipilih, sembunyikan kedua alert
                if (!allSelected) {
                    alertInfo.style.display = 'block';
                    alertWarning.style.display = 'none';
                    alertSuccess.style.display = 'none';
                    kesimpulanInput.value = 'Pilih semua Planning';
                    return;
                }

                // Update tampilan kesimpulan
                if (needsSpecialPlan) {
                    alertWarning.style.display = 'block';
                    alertSuccess.style.display = 'none';
                    alertInfo.style.display = 'none';
                    kesimpulanInput.value = 'Mebutuhkan rencana pulang khusus';
                } else {
                    alertWarning.style.display = 'none';
                    alertSuccess.style.display = 'block';
                    alertInfo.style.display = 'none';
                    kesimpulanInput.value = 'Tidak mebutuhkan rencana pulang khusus';
                }
            }

            allSelects.forEach(select => {
                select.addEventListener('change', updateDischargePlanningConclusion);
            });

            updateDischargePlanningConclusion();


            //==================================================================================================//
            // 6. Inisialisasi Diagnosis Banding dan Kerja
            //==================================================================================================//
            const dbMasterDiagnosis = @json($rmeMasterDiagnosis->pluck('nama_diagnosis'));

            // Inisialisasi kedua bagian diagnosis
            initDiagnosisManagement('diagnosis-banding', 'diagnosis_banding');
            initDiagnosisManagement('diagnosis-kerja', 'diagnosis_kerja');

            function initDiagnosisManagement(prefix, hiddenFieldId) {
                const inputField = document.getElementById(`${prefix}-input`);
                const addButton = document.getElementById(`add-${prefix}`);
                const listContainer = document.getElementById(`${prefix}-list`);
                const hiddenInput = document.getElementById(hiddenFieldId);

                // Debugging: Log elemen untuk memastikan ada
                console.log(`Initializing ${prefix}:`, { inputField, addButton, listContainer, hiddenInput });

                // Create suggestions container
                const suggestionsList = document.createElement('div');
                suggestionsList.className = 'suggestions-list position-absolute bg-white border rounded shadow-sm';
                suggestionsList.style.cssText = 'z-index: 1000; max-height: 200px; overflow-y: auto; width: calc(100% - 30px); display: none;';
                inputField.parentNode.insertBefore(suggestionsList, inputField.nextSibling);

                // Initialize diagnosis list from hidden input
                let diagnosisList = [];
                try {
                    diagnosisList = JSON.parse(hiddenInput.value) || [];
                    console.log(`Initial ${prefix} data:`, diagnosisList); // Debugging: Cek data awal
                    renderDiagnosisList(); // Render daftar awal
                } catch (e) {
                    console.error(`Error parsing initial ${prefix} data:`, e);
                    diagnosisList = [];
                    updateHiddenInput();
                }

                // Handle input changes for suggestions
                inputField.addEventListener('input', function () {
                    const searchTerm = this.value.trim().toLowerCase();
                    if (!searchTerm) {
                        suggestionsList.style.display = 'none';
                        return;
                    }

                    const matches = dbMasterDiagnosis.filter(diagnosis =>
                        diagnosis.toLowerCase().includes(searchTerm)
                    );
                    showSuggestions(matches, searchTerm);
                });

                // Handle suggestion display
                function showSuggestions(matches, searchTerm) {
                    suggestionsList.innerHTML = '';
                    matches.forEach(match => {
                        const div = document.createElement('div');
                        div.className = 'suggestion-item p-2 cursor-pointer hover:bg-gray-100';
                        div.textContent = match;
                        div.addEventListener('click', () => {
                            addDiagnosis(match);
                            suggestionsList.style.display = 'none';
                        });
                        suggestionsList.appendChild(div);
                    });

                    if (!matches.some(m => m.toLowerCase() === searchTerm)) {
                        const newOption = document.createElement('div');
                        newOption.className = 'suggestion-item p-2 cursor-pointer text-primary hover:bg-gray-100';
                        newOption.textContent = `Tambah "${searchTerm}"`;
                        newOption.addEventListener('click', () => {
                            addDiagnosis(searchTerm);
                            suggestionsList.style.display = 'none';
                        });
                        suggestionsList.appendChild(newOption);
                    }

                    suggestionsList.style.display = matches.length || searchTerm ? 'block' : 'none';
                }

                // Add diagnosis handler
                function addDiagnosis(text) {
                    if (!diagnosisList.includes(text)) {
                        diagnosisList.push(text);
                        inputField.value = '';
                        renderDiagnosisList();
                        updateHiddenInput();
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Duplikasi',
                            text: `"${text}" sudah ada dalam daftar`,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                }

                // Render diagnosis list
                function renderDiagnosisList() {
                    listContainer.innerHTML = '';
                    console.log(`Rendering ${prefix} list:`, diagnosisList); // Debugging: Cek data sebelum render
                    diagnosisList.forEach((diagnosis, index) => {
                        const item = document.createElement('div');
                        item.className = 'diagnosis-item d-flex justify-content-between align-items-center mb-2';

                        const text = document.createElement('span');
                        text.textContent = `${index + 1}. ${diagnosis}`;

                        const deleteBtn = document.createElement('button');
                        deleteBtn.className = 'btn btn-sm text-danger';
                        deleteBtn.innerHTML = '<i class="bi bi-trash"></i>';
                        deleteBtn.type = 'button';
                        deleteBtn.onclick = () => {
                            diagnosisList.splice(index, 1);
                            renderDiagnosisList();
                            updateHiddenInput();
                        };

                        item.appendChild(text);
                        item.appendChild(deleteBtn);
                        listContainer.appendChild(item);
                    });
                }

                // Update hidden input
                function updateHiddenInput() {
                    hiddenInput.value = JSON.stringify(diagnosisList);
                    console.log(`Updated ${prefix} hidden input:`, hiddenInput.value); // Debugging: Cek nilai tersimpan
                }

                // Event listeners for add button and enter key
                addButton.addEventListener('click', () => {
                    const text = inputField.value.trim();
                    if (text) addDiagnosis(text);
                });

                inputField.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const text = inputField.value.trim();
                        if (text) addDiagnosis(text);
                    }
                });

                // Close suggestions on outside click
                document.addEventListener('click', (e) => {
                    if (!inputField.contains(e.target) && !suggestionsList.contains(e.target)) {
                        suggestionsList.style.display = 'none';
                    }
                });
            }

            //==================================================================================================//
            // 7. Inisialisasi Implemntasi
            //==================================================================================================//
            const sections = ['observasi', 'terapeutik', 'edukasi', 'kolaborasi', 'prognosis'];
            const masterImplementasi = @json($rmeMasterImplementasi);

            sections.forEach(section => {
                initImplementationSection(section);
            });

            function initImplementationSection(section) {
                const inputField = document.getElementById(`${section}-input`);
                const addButton = document.getElementById(`add-${section}`);
                const listContainer = document.getElementById(`${section}-list`);
                const hiddenInput = document.getElementById(section);

                // Create suggestions container
                const suggestionsList = document.createElement('div');
                suggestionsList.className = 'suggestions-list position-absolute bg-white border rounded shadow-sm';
                suggestionsList.style.cssText = 'z-index: 1000; max-height: 200px; overflow-y: auto; width: calc(100% - 40px); display: none;';
                inputField.parentNode.insertBefore(suggestionsList, inputField.nextSibling);

                // Get options from database
                const dbOptions = masterImplementasi
                    .filter(item => item[section] && item[section] !== '(N/A)' && item[section] !== '(Null)')
                    .map(item => item[section]);
                const uniqueOptions = [...new Set(dbOptions)];

                // Initialize list from hidden input
                let itemsList = [];
                try {
                    itemsList = JSON.parse(hiddenInput.value) || [];
                    renderItemsList();
                } catch (e) {
                    console.error(`Error parsing ${section} data:`, e);
                    itemsList = [];
                    updateHiddenInput();
                }

                // Handle input changes
                inputField.addEventListener('input', function () {
                    const searchTerm = this.value.trim().toLowerCase();
                    if (!searchTerm) {
                        suggestionsList.style.display = 'none';
                        return;
                    }

                    const matches = uniqueOptions.filter(option =>
                        option.toLowerCase().includes(searchTerm)
                    );
                    showSuggestions(matches, searchTerm);
                });

                function showSuggestions(matches, searchTerm) {
                    suggestionsList.innerHTML = '';

                    // Add matching items
                    matches.forEach(match => {
                        const div = document.createElement('div');
                        div.className = 'suggestion-item p-2 cursor-pointer hover:bg-gray-100';
                        div.textContent = match;
                        div.addEventListener('click', () => {
                            addItem(match);
                            suggestionsList.style.display = 'none';
                        });
                        suggestionsList.appendChild(div);
                    });

                    // Add "create new" option if no exact match
                    if (!matches.some(m => m.toLowerCase() === searchTerm)) {
                        const newOption = document.createElement('div');
                        newOption.className = 'suggestion-item p-2 cursor-pointer text-primary hover:bg-gray-100';
                        newOption.innerHTML = `<i class="bi bi-plus-circle me-1"></i>Tambah "${searchTerm}"`;
                        newOption.addEventListener('click', () => {
                            addItem(searchTerm);
                            suggestionsList.style.display = 'none';
                        });
                        suggestionsList.appendChild(newOption);
                    }

                    suggestionsList.style.display = 'block';
                }

                function addItem(text) {
                    if (!itemsList.includes(text)) {
                        itemsList.push(text);
                        inputField.value = '';
                        renderItemsList();
                        updateHiddenInput();
                    } else {
                        // Show duplicate warning
                        Swal.fire({
                            icon: 'warning',
                            title: 'Duplikasi',
                            text: `"${text}" sudah ada dalam daftar`,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                }

                function renderItemsList() {
                    listContainer.innerHTML = '';

                    if (itemsList.length === 0) {
                        const emptyMsg = document.createElement('div');
                        emptyMsg.className = 'text-muted fst-italic small';
                        emptyMsg.textContent = 'Belum ada data';
                        listContainer.appendChild(emptyMsg);
                        return;
                    }

                    itemsList.forEach((item, index) => {
                        const itemElement = document.createElement('div');
                        itemElement.className = 'd-flex justify-content-between align-items-center mb-2';

                        const itemSpan = document.createElement('span');
                        itemSpan.textContent = `${index + 1}. ${item}`;

                        const deleteBtn = document.createElement('button');
                        deleteBtn.className = 'btn btn-sm text-danger';
                        deleteBtn.innerHTML = '<i class="bi bi-trash"></i>';
                        deleteBtn.type = 'button';
                        deleteBtn.onclick = () => {
                            itemsList.splice(index, 1);
                            renderItemsList();
                            updateHiddenInput();
                        };

                        itemElement.appendChild(itemSpan);
                        itemElement.appendChild(deleteBtn);
                        listContainer.appendChild(itemElement);
                    });
                }

                function updateHiddenInput() {
                    hiddenInput.value = JSON.stringify(itemsList);
                }

                // Event listeners
                addButton.addEventListener('click', () => {
                    const text = inputField.value.trim();
                    if (text) addItem(text);
                });

                inputField.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const text = inputField.value.trim();
                        if (text) addItem(text);
                    }
                });

                // Close suggestions on outside click
                document.addEventListener('click', (e) => {
                    if (!inputField.contains(e.target) && !suggestionsList.contains(e.target)) {
                        suggestionsList.style.display = 'none';
                    }
                });
            }

        });
    </script>
@endpush
