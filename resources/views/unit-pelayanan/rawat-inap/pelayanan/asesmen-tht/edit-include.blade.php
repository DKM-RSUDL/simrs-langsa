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
        document.addEventListener('DOMContentLoaded', function () {
            //------------------------------------------------------------//
            // Event handler untuk tombol tambah keterangan di pemeriksaan fisik //
            document.querySelectorAll('.tambah-keterangan').forEach(button => {
                button.addEventListener('click', function () {
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

            // Event handler untuk checkbox normal
            document.querySelectorAll('.form-check-input').forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const keteranganDiv = this.closest('.pemeriksaan-item').querySelector(
                        '.keterangan');
                    if (this.checked) {
                        keteranganDiv.style.display = 'none';
                        keteranganDiv.querySelector('input').value = ''; // Reset input value
                    }
                });
            });
            //------------------------------------------------------------//

            //------------------------------------------------------------//
            // Event handler untuk skala risiko jatuh
            function handleSkalaRisikoJatuh() {
                const skalaSelect = document.getElementById('skalaRisikoJatuh');
                const allForms = document.querySelectorAll('.risk-form');

                if (!skalaSelect) {
                    console.error('Skala select not found');
                    return;
                }

                // Hide all forms initially
                allForms.forEach(form => {
                    form.style.display = 'none';
                });

                skalaSelect.addEventListener('change', function () {
                    const selectedValue = this.value;
                    console.log('Selected value:', selectedValue); // Debug log

                    // Hide all forms first
                    allForms.forEach(form => {
                        form.style.display = 'none';
                    });

                    // Show selected form
                    const formId = `form${selectedValue.charAt(0).toUpperCase()}${selectedValue.slice(1)}`;
                    const selectedForm = document.getElementById(formId);
                    console.log('Looking for form:', formId); // Debug log

                    if (selectedForm) {
                        selectedForm.style.display = 'block';
                        console.log('Form displayed:', formId); // Debug log
                    } else {
                        console.error('Form not found:', formId);
                    }
                });

                // Handle risk calculation
                allForms.forEach(form => {
                    const selects = form.querySelectorAll('select');
                    selects.forEach(select => {
                        select.addEventListener('change', () => {
                            calculateRisk(form);
                        });
                    });
                });
            }

            function calculateRisk(form) {
                const selects = form.querySelectorAll('select[name]'); // Only select elements with name attribute
                let riskCount = 0;

                selects.forEach(select => {
                    if (select.value === 'ya') {
                        riskCount++;
                    }
                });

                const kesimpulanEl = form.querySelector('.alert');
                if (kesimpulanEl) {
                    if (riskCount > 0) {
                        kesimpulanEl.textContent = 'Berisiko jatuh';
                        kesimpulanEl.className = 'alert alert-warning mb-0 flex-grow-1';
                    } else {
                        kesimpulanEl.textContent = 'Tidak berisiko jatuh';
                        kesimpulanEl.className = 'alert alert-success mb-0 flex-grow-1';
                    }
                }
            }

            // Initialize the risk assessment functionality
            handleSkalaRisikoJatuh();
            //------------------------------------------------------------//

            //------------------------------------------------------------//
            function handleRisikoDekubitus() {
                const skalaSelect = document.getElementById('skalaRisikoDekubitus');
                const allForms = document.querySelectorAll('.decubitus-form');

                if (!skalaSelect) {
                    console.error('Skala dekubitus select not found');
                    return;
                }

                // Hide all forms initially
                allForms.forEach(form => {
                    form.style.display = 'none';
                });

                skalaSelect.addEventListener('change', function () {
                    const selectedValue = this.value;

                    // Hide all forms
                    allForms.forEach(form => {
                        form.style.display = 'none';
                    });

                    // Show selected form
                    const formId = `form${selectedValue.charAt(0).toUpperCase()}${selectedValue.slice(1)}`;
                    const selectedForm = document.getElementById(formId);

                    if (selectedForm) {
                        selectedForm.style.display = 'block';
                        // Reset form values
                        selectedForm.querySelectorAll('select').forEach(select => {
                            select.selectedIndex = 0;
                        });
                    }
                });

                // Calculate Norton score
                function calculateNortonScore(form) {
                    const selects = form.querySelectorAll('select[name]');
                    let totalScore = 0;

                    selects.forEach(select => {
                        if (select.value) {
                            totalScore += parseInt(select.value);
                        }
                    });

                    const kesimpulanEl = form.querySelector('#kesimpulanNorton');
                    if (kesimpulanEl) {
                        let riskLevel = '';
                        let alertClass = '';

                        if (totalScore <= 12) {
                            riskLevel = 'Risiko Tinggi';
                            alertClass = 'alert-danger';
                        } else if (totalScore <= 14) {
                            riskLevel = 'Risiko Sedang';
                            alertClass = 'alert-warning';
                        } else {
                            riskLevel = 'Risiko Rendah';
                            alertClass = 'alert-success';
                        }

                        kesimpulanEl.textContent = riskLevel;
                        kesimpulanEl.className = `alert ${alertClass} mb-0 flex-grow-1`;
                    }
                }

                // Add event listeners for Norton scale inputs
                const nortonForm = document.getElementById('formNorton');
                if (nortonForm) {
                    nortonForm.querySelectorAll('select').forEach(select => {
                        select.addEventListener('change', () => calculateNortonScore(nortonForm));
                    });
                }
            }

            // Initialize the decubitus risk assessment
            handleRisikoDekubitus();
            //------------------------------------------------------------//

            //------------------------------------------------------------//
            // Handler untuk Status Psikologis dropdown
            function handlePsikologisDropdown() {
                const btnKondisiPsikologis = document.getElementById('btnKondisiPsikologis');
                const dropdownKondisiPsikologis = document.getElementById('dropdownKondisiPsikologis');
                const selectedKondisiPsikologis = document.getElementById('selectedKondisiPsikologis');
                let selectedItems = new Set();

                if (!btnKondisiPsikologis || !dropdownKondisiPsikologis || !selectedKondisiPsikologis) {
                    console.error('Some elements for psikologis dropdown not found');
                    return;
                }

                function updateSelectedItems() {
                    selectedKondisiPsikologis.innerHTML = '';
                    selectedItems.forEach(item => {
                        const badge = document.createElement('span');
                        badge.className = 'selected-item';
                        badge.innerHTML =
                            `${item}<i class="ti-close remove-item" data-value="${item}"></i>`;
                        selectedKondisiPsikologis.appendChild(badge);
                    });
                }

                btnKondisiPsikologis.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const rect = this.getBoundingClientRect();
                    const buttonHeight = this.offsetHeight;

                    dropdownKondisiPsikologis.style.position = 'absolute';
                    dropdownKondisiPsikologis.style.top = `${buttonHeight + 5}px`; // 5px offset
                    dropdownKondisiPsikologis.style.left = '0';
                    dropdownKondisiPsikologis.style.display = dropdownKondisiPsikologis.style.display ===
                        'none' ? 'block' : 'none';

                    // Memastikan dropdown tidak keluar dari viewport
                    const dropdownRect = dropdownKondisiPsikologis.getBoundingClientRect();
                    const viewportHeight = window.innerHeight;
                    const viewportWidth = window.innerWidth;

                    if (dropdownRect.bottom > viewportHeight) {
                        dropdownKondisiPsikologis.style.top = 'auto';
                        dropdownKondisiPsikologis.style.bottom = `${buttonHeight + 5}px`;
                    }

                    if (dropdownRect.right > viewportWidth) {
                        dropdownKondisiPsikologis.style.left = 'auto';
                        dropdownKondisiPsikologis.style.right = '0';
                    }
                });

                document.querySelectorAll('.kondisi-options .form-check-input').forEach(checkbox => {
                    checkbox.addEventListener('change', function () {
                        if (this.checked) {
                            selectedItems.add(this.value);
                        } else {
                            selectedItems.delete(this.value);
                        }
                        updateSelectedItems();
                    });
                });

                selectedKondisiPsikologis.addEventListener('click', function (e) {
                    if (e.target.classList.contains('remove-item')) {
                        const value = e.target.dataset.value;
                        selectedItems.delete(value);
                        const checkbox = document.querySelector(`.form-check-input[value="${value}"]`);
                        if (checkbox) checkbox.checked = false;
                        updateSelectedItems();
                    }
                });

                document.addEventListener('click', function (e) {
                    if (!dropdownKondisiPsikologis.contains(e.target) && e.target !==
                        btnKondisiPsikologis) {
                        dropdownKondisiPsikologis.style.display = 'none';
                    }
                });
            }

            // Initialize psikologis dropdown
            handlePsikologisDropdown();
            //------------------------------------------------------------//


        });

        // Ambil referensi input elements
        document.addEventListener('DOMContentLoaded', function () {
            const tinggiInput = document.querySelector('input[name="antropometri_tinggi_badan"]');
            const beratInput = document.querySelector('input[name="antropometr_berat_badan"]');
            const imtInput = document.querySelector('input[name="antropometri_imt"]');
            const lptInput = document.querySelector('input[name="antropometri_lpt"]');

            // Fungsi untuk menghitung IMT
            function hitungIMT(berat, tinggi) {
                // Konversi tinggi dari cm ke meter
                const tinggiMeter = tinggi / 100;
                return berat / (tinggiMeter * tinggiMeter);
            }

            // Fungsi untuk menghitung LPT
            function hitungLPT(berat, tinggi) {
                // Konversi tinggi dari cm ke meter
                const tinggiMeter = tinggi / 100;
                return Math.sqrt((tinggiMeter * berat) / 3600);
            }

            // Fungsi untuk memformat angka
            function formatNumber(number) {
                return number.toFixed(2);
            }

            // Fungsi untuk memvalidasi input
            function validateInput(value) {
                return !isNaN(value) && value > 0;
            }

            // Fungsi untuk update hasil perhitungan
            function updateHasil() {
                const tinggi = parseFloat(tinggiInput.value);
                const berat = parseFloat(beratInput.value);

                if (validateInput(tinggi) && validateInput(berat)) {
                    const imt = hitungIMT(berat, tinggi);
                    const lpt = hitungLPT(berat, tinggi);

                    imtInput.value = formatNumber(imt);
                    lptInput.value = formatNumber(lpt);
                } else {
                    imtInput.value = '';
                    lptInput.value = '';
                }
            }

            // Tambahkan event listener untuk input
            if (tinggiInput && beratInput) {
                tinggiInput.addEventListener('input', updateHasil);
                beratInput.addEventListener('input', updateHasil);

                // Tambahkan validasi untuk hanya menerima angka
                function validateNumberInput(event) {
                    const input = event.target;
                    input.value = input.value.replace(/[^0-9.]/g, '');
                }

                tinggiInput.addEventListener('input', validateNumberInput);
                beratInput.addEventListener('input', validateNumberInput);

                // Inisialisasi perhitungan saat halaman dimuat jika data sudah ada
                if (tinggiInput.value && beratInput.value) {
                    updateHasil();
                }
            }
        });


        // 7. Hasil Pemeriksaan Penunjang
        document.addEventListener('DOMContentLoaded', function () {
            const maxFileSize = 2 * 1024 * 1024; // 2MB
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            const storageBasePath = '/storage/uploads/gawat-inap/asesmen-tht/';

            function validateFile(file) {
                if (!file) return false;

                if (file.size > maxFileSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File terlalu besar',
                        text: 'Ukuran file maksimal 2MB'
                    });
                    return false;
                }

                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format tidak didukung',
                        text: 'Format yang diizinkan: PDF, JPG, PNG'
                    });
                    return false;
                }

                return true;
            }

            function isFileImage(fileName) {
                return /\.(jpg|jpeg|png)$/i.test(fileName);
            }

            function previewFile(input) {
                const previewContainer = document.getElementById(input.dataset.previewContainer);
                const fileInfo = document.getElementById(`${input.id}Info`);
                const currentFile = input.dataset.currentFile;
                const file = input.files[0];

                previewContainer.innerHTML = '';

                // Handle existing file display
                if (currentFile && !file) {
                    const fileUrl = `${storageBasePath}${currentFile}`;

                    if (isFileImage(currentFile)) {
                        previewContainer.innerHTML = `
                                <img src="${fileUrl}" class="mt-2 rounded" style="max-width: 100px; max-height: 100px;">
                            `;
                    } else {
                        previewContainer.innerHTML = `
                                <i class="bi bi-file-pdf text-danger fs-1 mt-2"></i>
                            `;
                    }

                    fileInfo.innerHTML = `
                            <span class="text-primary">File tersimpan: ${currentFile}</span>
                            <button type="button" class="btn btn-link text-info p-0 ms-2 view-file" data-url="${fileUrl}">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button type="button" class="btn btn-link text-danger p-0 ms-2 remove-file" data-input="${input.id}">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        `;
                    return;
                }

                // Handle new file selection
                if (file && validateFile(file)) {
                    fileInfo.innerHTML = `
                            <span class="text-primary">File dipilih: ${file.name}</span>
                            <button type="button" class="btn btn-link text-danger p-0 ms-2 clear-file" data-input="${input.id}">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        `;

                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            previewContainer.innerHTML = `
                                    <img src="${e.target.result}" class="mt-2 rounded" style="max-width: 100px; max-height: 100px;">
                                `;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        previewContainer.innerHTML = `
                                <i class="bi bi-file-pdf text-danger fs-1 mt-2"></i>
                            `;
                    }
                } else {
                    fileInfo.innerHTML = '<span>Format: PDF, JPG, PNG (Max 2MB)</span>';
                }
            }

            // Initialize file previews
            document.querySelectorAll('input[type="file"]').forEach(input => {
                if (input.dataset.currentFile) {
                    previewFile(input);
                }

                input.addEventListener('change', function () {
                    previewFile(this);
                });
            });

            // Handle view file button
            document.addEventListener('click', function (e) {
                if (e.target.closest('.view-file')) {
                    const url = e.target.closest('.view-file').dataset.url;
                    window.open(url, '_blank');
                }
            });

            // Handle clear new file button
            document.addEventListener('click', function (e) {
                if (e.target.closest('.clear-file')) {
                    const btn = e.target.closest('.clear-file');
                    const input = document.getElementById(btn.dataset.input);
                    input.value = '';
                    previewFile(input);
                }
            });

            // Handle remove existing file button
            document.addEventListener('click', function (e) {
                if (e.target.closest('.remove-file')) {
                    const btn = e.target.closest('.remove-file');
                    const input = document.getElementById(btn.dataset.input);

                    // Add hidden input to mark file for deletion
                    const deleteInput = document.createElement('input');
                    deleteInput.type = 'hidden';
                    deleteInput.name = `delete_${input.name}`;
                    deleteInput.value = '1';
                    input.parentNode.appendChild(deleteInput);

                    // Clear the current file
                    input.dataset.currentFile = '';
                    input.value = '';
                    previewFile(input);
                }
            });
        });

        // 8. Discharge Planning
        document.addEventListener('DOMContentLoaded', function () {
            const lamaDirawatInput = document.getElementById('lamaDirawat');
            const rencanaPulangInput = document.getElementById('rencanaPulang');
            const riskFactorInputs = document.querySelectorAll('.risk-factor');
            const needSpecialPlanAlert = document.getElementById('needSpecialPlanAlert');
            const noSpecialPlanAlert = document.getElementById('noSpecialPlanAlert');
            const needSpecialRadio = document.getElementById('need_special');
            const noSpecialRadio = document.getElementById('no_special');
            const conclusionSection = document.getElementById('conclusionSection');
            const conclusionText = document.getElementById('conclusionText');
            const dpKesimpulanHidden = document.getElementById('dp_kesimpulan_hidden');

            // Initialize date picker
            const datePickerOptions = {
                format: 'dd M yyyy',
                autoclose: true,
                todayHighlight: true,
                language: 'id'
            };

            $(rencanaPulangInput).datepicker(datePickerOptions);

            $('#datePickerToggle').click(function () {
                $(rencanaPulangInput).datepicker('show');
            });

            // Update rencana pulang date when lama dirawat changes
            lamaDirawatInput.addEventListener('change', function () {
                updateRencanaPulang();
            });

            // Add change event listeners to all risk factor inputs
            riskFactorInputs.forEach(input => {
                input.addEventListener('change', calculateConclusion);
            });

            function updateRencanaPulang() {
                const days = parseInt(lamaDirawatInput.value) || 0;
                if (days > 0) {
                    const today = new Date();
                    const futureDate = new Date(today);
                    futureDate.setDate(today.getDate() + days);

                    const options = { day: '2-digit', month: 'short', year: 'numeric' };
                    rencanaPulangInput.value = futureDate.toLocaleDateString('id-ID', options);
                    $(rencanaPulangInput).datepicker('update', futureDate);
                }
            }

            function calculateConclusion() {
                let allCompleted = true;
                let hasYesAnswer = false;

                riskFactorInputs.forEach(input => {
                    if (input.value === '') {
                        allCompleted = false;
                    } else if (input.value === '1') {
                        hasYesAnswer = true;
                    }
                });

                if (allCompleted) {
                    displayConclusion(hasYesAnswer);
                } else {
                    hideConclusion();
                }
            }

            function displayConclusion(needsSpecialPlan) {
                conclusionSection.style.display = 'block';

                if (needsSpecialPlan) {
                    needSpecialPlanAlert.style.display = 'block';
                    noSpecialPlanAlert.style.display = 'none';
                    needSpecialRadio.checked = true;
                    dpKesimpulanHidden.value = "Membutuhkan rencana pulang khusus";

                    conclusionSection.style.backgroundColor = '#fff3cd';
                    conclusionText.innerHTML = 'Pasien membutuhkan rencana pulang khusus. Rekomendasi: konsultasi dengan tim multidisiplin, edukasi keluarga, dan pengaturan kunjungan lanjutan.';
                } else {
                    needSpecialPlanAlert.style.display = 'none';
                    noSpecialPlanAlert.style.display = 'block';
                    noSpecialRadio.checked = true;
                    dpKesimpulanHidden.value = "Tidak membutuhkan rencana pulang khusus";

                    conclusionSection.style.backgroundColor = '#d1e7dd';
                    conclusionText.innerHTML = 'Pasien tidak membutuhkan rencana pulang khusus. Pasien dapat menjalani prosedur pemulangan standar.';
                }
            }

            function hideConclusion() {
                conclusionSection.style.display = 'none';
                needSpecialPlanAlert.style.display = 'none';
                noSpecialPlanAlert.style.display = 'none';
                needSpecialRadio.checked = false;
                noSpecialRadio.checked = false;
                dpKesimpulanHidden.value = '';
            }

            // Set up readonly radio buttons
            function setupReadonlyRadios() {
                [needSpecialRadio, noSpecialRadio].forEach(radio => {
                    radio.addEventListener('click', function (e) {
                        if (!this.checked) {
                            e.preventDefault();
                        }
                    });
                });
            }

            // Initialize the form
            setupReadonlyRadios();
            calculateConclusion();

            // If there's an existing conclusion, display it
            if (dpKesimpulanHidden.value) {
                const needsSpecialPlan = dpKesimpulanHidden.value === "Membutuhkan rencana pulang khusus";
                displayConclusion(needsSpecialPlan);
            }
        });

        // 9. Diagnosis Diagnosis Banding
        document.addEventListener('DOMContentLoaded', function () {
            // Get master diagnosis data from PHP
            const dbMasterDiagnosis = @json($rmeMasterDiagnosis->pluck('nama_diagnosis'));

            // Initialize both diagnosis sections
            initDiagnosisManagement('diagnosis-banding', 'diagnosis_banding');
            initDiagnosisManagement('diagnosis-kerja', 'diagnosis_kerja');

            function initDiagnosisManagement(prefix, hiddenFieldId) {
                const inputField = document.getElementById(`${prefix}-input`);
                const addButton = document.getElementById(`add-${prefix}`);
                const listContainer = document.getElementById(`${prefix}-list`);
                const hiddenInput = document.getElementById(hiddenFieldId);

                // Create suggestions container
                const suggestionsList = document.createElement('div');
                suggestionsList.className = 'suggestions-list position-absolute bg-white border rounded shadow-sm';
                suggestionsList.style.cssText = 'z-index: 1000; max-height: 200px; overflow-y: auto; width: calc(100% - 30px); display: none;';
                inputField.parentNode.insertBefore(suggestionsList, inputField.nextSibling);

                // Initialize diagnosis list from hidden input
                let diagnosisList = [];
                try {
                    diagnosisList = JSON.parse(hiddenInput.value) || [];
                    renderDiagnosisList();
                } catch (e) {
                    console.error('Error parsing initial diagnosis data:', e);
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

                    // Filter suggestions from master data
                    const matches = dbMasterDiagnosis.filter(diagnosis =>
                        diagnosis.toLowerCase().includes(searchTerm)
                    );

                    // Show suggestions
                    showSuggestions(matches, searchTerm);
                });

                // Handle suggestion display
                function showSuggestions(matches, searchTerm) {
                    suggestionsList.innerHTML = '';

                    // Add matching items
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

                    // Add option to create new if no exact match
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
        });

        // 10.Implementasi
        document.addEventListener('DOMContentLoaded', function () {
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
