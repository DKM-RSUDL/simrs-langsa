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
        tinggiInput.addEventListener('input', updateHasil);
        beratInput.addEventListener('input', updateHasil);

        // Tambahkan validasi untuk hanya menerima angka
        function validateNumberInput(event) {
            const input = event.target;
            input.value = input.value.replace(/[^0-9.]/g, '');
        }

        tinggiInput.addEventListener('input', validateNumberInput);
        beratInput.addEventListener('input', validateNumberInput);


        // 7. Hasil Pemeriksaan Penunjang
        document.addEventListener('DOMContentLoaded', function () {
            const maxFileSize = 2 * 1024 * 1024; // 2MB
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];

            // Fungsi untuk validasi file
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

            // Fungsi untuk preview file
            function previewFile(input) {
                const previewContainer = document.getElementById(input.dataset.previewContainer);
                const fileInfo = document.getElementById(`${input.id}Info`);
                const file = input.files[0];

                previewContainer.innerHTML = '';

                if (file && validateFile(file)) {
                    // Update file info
                    fileInfo.innerHTML = `
                            <span class="text-primary">File dipilih: ${file.name}</span>
                            <button type="button" class="btn btn-link text-danger p-0 ms-2 clear-file" data-input="${input.id}">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        `;

                    // Create preview
                    if (file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.style.maxWidth = '100px';
                        img.style.maxHeight = '100px';
                        img.className = 'mt-2 rounded';

                        const reader = new FileReader();
                        reader.onload = (e) => {
                            img.src = e.target.result;
                        };
                        reader.readAsDataURL(file);

                        previewContainer.appendChild(img);
                    } else if (file.type === 'application/pdf') {
                        const pdfIcon = document.createElement('i');
                        pdfIcon.className = 'bi bi-file-pdf text-danger fs-1 mt-2';
                        previewContainer.appendChild(pdfIcon);
                    }
                } else {
                    fileInfo.innerHTML = '<span>Format: PDF, JPG, PNG (Max 2MB)</span>';
                }
            }

            // Event listener untuk file inputs
            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.addEventListener('change', function () {
                    previewFile(this);
                });
            });

            // Event listener untuk tombol clear
            document.addEventListener('click', function (e) {
                if (e.target.closest('.clear-file')) {
                    const btn = e.target.closest('.clear-file');
                    const inputId = btn.dataset.input;
                    const input = document.getElementById(inputId);
                    const previewContainer = document.getElementById(input.dataset.previewContainer);

                    input.value = '';
                    previewContainer.innerHTML = '';
                    document.getElementById(`${inputId}Info`).innerHTML =
                        '<span>Format: PDF, JPG, PNG (Max 2MB)</span>';
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

            // Update rencana pulang date
            lamaDirawatInput.addEventListener('change', function () {
                updateRencanaPulang();
            });

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
                }
            }

            function calculateConclusion() {
                // Check if all completed
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
                    if (hasYesAnswer) {
                        displayConclusion(true);
                    } else {
                        displayConclusion(false);
                    }
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

                    needSpecialRadio.disabled = false;
                    needSpecialRadio.readOnly = true;

                    if (dpKesimpulanHidden) {
                        dpKesimpulanHidden.value = "Membutuhkan rencana pulang khusus";
                    }

                    conclusionSection.style.backgroundColor = '#fff3cd';
                    conclusionText.innerHTML = 'Pasien membutuhkan rencana pulang khusus. Rekomendasi: konsultasi dengan tim multidisiplin, edukasi keluarga, dan pengaturan kunjungan lanjutan.';
                } else {
                    needSpecialPlanAlert.style.display = 'none';
                    noSpecialPlanAlert.style.display = 'block';
                    noSpecialRadio.checked = true;

                    noSpecialRadio.disabled = false;
                    noSpecialRadio.readOnly = true;

                    if (dpKesimpulanHidden) {
                        dpKesimpulanHidden.value = "Tidak membutuhkan rencana pulang khusus";
                    }

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

                if (dpKesimpulanHidden) {
                    dpKesimpulanHidden.value = '';
                }
            }

            function setupReadonlyRadios() {
                // Mencegah perubahan manual pada radio button
                needSpecialRadio.addEventListener('click', function (e) {
                    if (!this.checked) {
                        e.preventDefault();
                    }
                });

                noSpecialRadio.addEventListener('click', function (e) {
                    if (!this.checked) {
                        e.preventDefault();
                    }
                });
            }

            setupReadonlyRadios();
            calculateConclusion();
        });

        // 9. Diagnosis Diagnosis Banding
        document.addEventListener('DOMContentLoaded', function () {
            initDiagnosisManagement('diagnosis-banding', 'diagnosis_banding');
            initDiagnosisManagement('diagnosis-kerja', 'diagnosis_kerja');

            function initDiagnosisManagement(prefix, hiddenFieldId) {
                const inputField = document.getElementById(`${prefix}-input`);
                const addButton = document.getElementById(`add-${prefix}`);
                const listContainer = document.getElementById(`${prefix}-list`);
                const hiddenInput = document.getElementById(hiddenFieldId);
                const suggestionsList = document.createElement('div');

                // Style suggestions list
                suggestionsList.className = 'suggestions-list position-absolute bg-white border rounded';
                suggestionsList.style.zIndex = '1000';
                suggestionsList.style.maxHeight = '200px';
                suggestionsList.style.overflowY = 'auto';
                suggestionsList.style.width = 'calc(100% - 30px)';
                suggestionsList.style.display = 'none';

                // Insert suggestions list after input
                inputField.parentNode.insertBefore(suggestionsList, inputField.nextSibling);

                // Database options
                const dbMasterDiagnosis = {!! json_encode($rmeMasterDiagnosis->pluck('nama_diagnosis')) !!};

                // Prepare options array
                const diagnosisOptions = dbMasterDiagnosis.map(text => ({
                    id: text.toLowerCase().replace(/\s+/g, '_'),
                    text: text
                }));

                // Load initial data if available
                let diagnosisList = [];
                try {
                    diagnosisList = JSON.parse(hiddenInput.value) || [];
                    renderDiagnosisList();
                } catch (e) {
                    diagnosisList = [];
                    updateHiddenInput();
                }

                // Input event listener for suggestions
                inputField.addEventListener('input', function () {
                    const inputValue = this.value.trim().toLowerCase();

                    if (inputValue) {
                        // Filter database options
                        const filteredOptions = diagnosisOptions.filter(option =>
                            option.text.toLowerCase().includes(inputValue)
                        );

                        // Show suggestions
                        showSuggestions(filteredOptions, inputValue);
                    } else {
                        // Hide suggestions if input is empty
                        suggestionsList.style.display = 'none';
                    }
                });

                // Function to show suggestions
                function showSuggestions(options, inputValue) {
                    suggestionsList.innerHTML = '';

                    if (options.length > 0) {
                        // Render existing options
                        options.forEach(option => {
                            const suggestionItem = document.createElement('div');
                            suggestionItem.className = 'suggestion-item p-2 cursor-pointer';
                            suggestionItem.textContent = option.text;
                            suggestionItem.addEventListener('click', () => {
                                addDiagnosis(option.text);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(suggestionItem);
                        });

                        // Add option to create new if no exact match
                        if (!options.some(opt => opt.text.toLowerCase() === inputValue)) {
                            const newOptionItem = document.createElement('div');
                            newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                            newOptionItem.textContent = `Tambah "${inputValue}"`;
                            newOptionItem.addEventListener('click', () => {
                                addDiagnosis(inputValue);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(newOptionItem);
                        }

                        suggestionsList.style.display = 'block';
                    } else {
                        // If no options, show add new option
                        const newOptionItem = document.createElement('div');
                        newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                        newOptionItem.textContent = `Tambah "${inputValue}"`;
                        newOptionItem.addEventListener('click', () => {
                            addDiagnosis(inputValue);
                            suggestionsList.style.display = 'none';
                        });
                        suggestionsList.appendChild(newOptionItem);
                        suggestionsList.style.display = 'block';
                    }
                }

                // Add diagnosis when plus button is clicked
                addButton.addEventListener('click', function () {
                    const diagnosisText = inputField.value.trim();
                    if (diagnosisText) {
                        addDiagnosis(diagnosisText);
                    }
                });

                // Add diagnosis when Enter key is pressed
                inputField.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const diagnosisText = this.value.trim();
                        if (diagnosisText) {
                            addDiagnosis(diagnosisText);
                        }
                    }
                });

                // Close suggestions when clicking outside
                document.addEventListener('click', function (e) {
                    if (!inputField.contains(e.target) && !suggestionsList.contains(e.target)) {
                        suggestionsList.style.display = 'none';
                    }
                });

                function addDiagnosis(diagnosisText) {
                    // Check for duplicates
                    if (!diagnosisList.includes(diagnosisText)) {
                        diagnosisList.push(diagnosisText);
                        inputField.value = '';
                        renderDiagnosisList();
                        updateHiddenInput();
                        suggestionsList.style.display = 'none';
                    } else {
                        // Optional: Show feedback that it's a duplicate
                        alert(`"${diagnosisText}" sudah ada dalam daftar`);
                    }
                }

                function renderDiagnosisList() {
                    listContainer.innerHTML = '';

                    diagnosisList.forEach((diagnosis, index) => {
                        const diagnosisItem = document.createElement('div');
                        diagnosisItem.className = 'diagnosis-item d-flex justify-content-between align-items-center mb-2';

                        const diagnosisSpan = document.createElement('span');
                        diagnosisSpan.textContent = `${index + 1}. ${diagnosis}`;

                        const deleteButton = document.createElement('button');
                        deleteButton.className = 'btn btn-sm text-danger';
                        deleteButton.innerHTML = '<i class="bi bi-trash"></i>';
                        deleteButton.type = 'button';
                        deleteButton.addEventListener('click', function () {
                            diagnosisList.splice(index, 1);
                            renderDiagnosisList();
                            updateHiddenInput();
                        });

                        diagnosisItem.appendChild(diagnosisSpan);
                        diagnosisItem.appendChild(deleteButton);
                        listContainer.appendChild(diagnosisItem);
                    });
                }

                function updateHiddenInput() {
                    hiddenInput.value = JSON.stringify(diagnosisList);
                }
            }
        });

        // 10.Implementasi
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all sections
            initImplementationSection('rencana', 'rencana_penatalaksanaan', 'prognosis');
            initImplementationSection('observasi', 'observasi', 'observasi');
            initImplementationSection('terapeutik', 'terapeutik', 'terapeutik');
            initImplementationSection('edukasi', 'edukasi', 'edukasi');
            initImplementationSection('kolaborasi', 'kolaborasi', 'kolaborasi');

            /**
             * Initialize implementation section with dynamic options
             * @param {string} prefix - The prefix for element IDs
             * @param {string} hiddenFieldId - The ID of the hidden input field
             * @param {string} dbColumn - The column name in database
             */
            function initImplementationSection(prefix, hiddenFieldId, dbColumn) {
                const inputField = document.getElementById(`${prefix}-input`);
                const addButton = document.getElementById(`add-${prefix}`);
                const listContainer = document.getElementById(`${prefix}-list`);
                const hiddenInput = document.getElementById(hiddenFieldId);
                const suggestionsList = document.createElement('div');

                // Style suggestions list
                suggestionsList.className = 'suggestions-list position-absolute bg-white border rounded shadow';
                suggestionsList.style.zIndex = '1000';
                suggestionsList.style.maxHeight = '200px';
                suggestionsList.style.overflowY = 'auto';
                suggestionsList.style.width = 'calc(100% - 40px)';
                suggestionsList.style.display = 'none';

                // Insert
                inputField.parentNode.insertBefore(suggestionsList, inputField.nextSibling);

                // Get database
                const rmeMasterImplementasi = {!! json_encode($rmeMasterImplementasi) !!};

                // Filter out non-null values
                let optionsFromDb = [];
                if (rmeMasterImplementasi && rmeMasterImplementasi.length > 0) {
                    optionsFromDb = rmeMasterImplementasi
                        .filter(item => item[dbColumn] !== null &&
                                    item[dbColumn] !== '(N/A)' &&
                                    item[dbColumn] !== '(Null)')
                        .map(item => item[dbColumn]);
                }

                // Remove duplicates
                const uniqueOptions = [...new Set(optionsFromDb)];

                // Prepare options array
                const options = uniqueOptions.map(text => ({
                    id: text.toLowerCase().replace(/\s+/g, '_'),
                    text: text
                }));

                // Load initial data if available
                let itemsList = [];
                try {
                    itemsList = JSON.parse(hiddenInput.value) || [];
                    renderItemsList();
                } catch (e) {
                    itemsList = [];
                    updateHiddenInput();
                }

                // Input event listener for suggestions
                inputField.addEventListener('input', function() {
                    const inputValue = this.value.trim().toLowerCase();

                    if (inputValue) {
                        const filteredOptions = options.filter(option =>
                            option.text.toLowerCase().includes(inputValue)
                        );

                        const exactMatch = options.some(opt =>
                            opt.text.toLowerCase() === inputValue
                        );

                        showSuggestions(filteredOptions, inputValue, exactMatch);
                    } else {
                        suggestionsList.style.display = 'none';
                    }
                });

                // Function to show
                function showSuggestions(filtered, inputValue, exactMatch) {
                    suggestionsList.innerHTML = '';

                    if (filtered.length > 0) {
                        filtered.forEach(option => {
                            const suggestionItem = document.createElement('div');
                            suggestionItem.className = 'suggestion-item p-2 cursor-pointer hover:bg-light';
                            suggestionItem.style.cursor = 'pointer';

                            const text = option.text;
                            const lowerText = text.toLowerCase();
                            const lowerInput = inputValue.toLowerCase();
                            const index = lowerText.indexOf(lowerInput);

                            if (index >= 0) {
                                const before = text.substring(0, index);
                                const match = text.substring(index, index + inputValue.length);
                                const after = text.substring(index + inputValue.length);
                                suggestionItem.innerHTML = `${before}<strong>${match}</strong>${after}`;
                            } else {
                                suggestionItem.textContent = text;
                            }

                            suggestionItem.addEventListener('click', () => {
                                addItem(option.text);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(suggestionItem);
                        });

                        // Add option to create new if no exact match
                        if (!exactMatch) {
                            const newOptionItem = document.createElement('div');
                            newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                            newOptionItem.style.cursor = 'pointer';
                            newOptionItem.innerHTML = `<i class="bi bi-plus-circle me-1"></i> Tambah "${inputValue}"`;
                            newOptionItem.addEventListener('click', () => {
                                addItem(inputValue);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(newOptionItem);
                        }

                        suggestionsList.style.display = 'block';
                    } else {
                        // If no options, show add new option
                        const newOptionItem = document.createElement('div');
                        newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                        newOptionItem.style.cursor = 'pointer';
                        newOptionItem.innerHTML = `<i class="bi bi-plus-circle me-1"></i> Tambah "${inputValue}"`;
                        newOptionItem.addEventListener('click', () => {
                            addItem(inputValue);
                            suggestionsList.style.display = 'none';
                        });
                        suggestionsList.appendChild(newOptionItem);
                        suggestionsList.style.display = 'block';
                    }
                }

                // Add item
                addButton.addEventListener('click', function() {
                    const itemText = inputField.value.trim();
                    if (itemText) {
                        addItem(itemText);
                    }
                });

                // Add item when Enter
                inputField.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const itemText = this.value.trim();
                        if (itemText) {
                            addItem(itemText);
                        }
                    }
                });

                // Close
                document.addEventListener('click', function(e) {
                    if (!inputField.contains(e.target) && !suggestionsList.contains(e.target)) {
                        suggestionsList.style.display = 'none';
                    }
                });

                /**
                * Add item to the list
                * @param {string} itemText - The text to add
                */
                function addItem(itemText) {
                    // Check for duplicates
                    if (!itemsList.includes(itemText)) {
                        // Check if in database
                        const existsInDb = optionsFromDb.includes(itemText);

                        itemsList.push(itemText);
                        inputField.value = '';
                        renderItemsList();
                        updateHiddenInput();
                        suggestionsList.style.display = 'none';

                        if (existsInDb) {
                            const notification = document.createElement('div');
                            notification.className = 'alert alert-info alert-dismissible fade show mt-2';
                            notification.innerHTML = `
                                <small>Item "${itemText}" sudah ada di database dan akan digunakan.</small>
                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                            `;
                            listContainer.parentNode.insertBefore(notification, listContainer.nextSibling);

                            // Auto-dismiss after 3 seconds
                            setTimeout(() => {
                                notification.classList.remove('show');
                                setTimeout(() => notification.remove(), 150);
                            }, 3000);
                        }
                    } else {
                        // Show feedback that it's a duplicate
                        const toastContainer = document.createElement('div');
                        toastContainer.className = 'position-fixed top-0 end-0 p-3';
                        toastContainer.style.zIndex = '1050';

                        const toast = document.createElement('div');
                        toast.className = 'toast align-items-center text-white bg-danger border-0';
                        toast.setAttribute('role', 'alert');
                        toast.innerHTML = `
                            <div class="d-flex">
                                <div class="toast-body">
                                    <i class="bi bi-exclamation-circle me-2"></i>
                                    "${itemText}" sudah ada dalam daftar
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                            </div>
                        `;

                        toastContainer.appendChild(toast);
                        document.body.appendChild(toastContainer);

                        // Show toast
                        const bsToast = new bootstrap.Toast(toast, {
                            delay: 3000
                        });
                        bsToast.show();

                        // Remove container after toast is hidden
                        toast.addEventListener('hidden.bs.toast', function() {
                            document.body.removeChild(toastContainer);
                        });
                    }
                }

                /**
                * Render items list in the container
                */
                function renderItemsList() {
                    listContainer.innerHTML = '';

                    itemsList.forEach((item, index) => {
                        const itemElement = document.createElement('div');
                        itemElement.className = 'list-group-item d-flex justify-content-between align-items-center border-0 ps-0';

                        const itemSpan = document.createElement('span');
                        itemSpan.textContent = `${index + 1}. ${item}`;

                        const deleteButton = document.createElement('button');
                        deleteButton.className = 'btn btn-link text-danger p-0';
                        deleteButton.type = 'button';
                        deleteButton.innerHTML = '<i class="bi bi-x"></i>';
                        deleteButton.addEventListener('click', function() {
                            itemsList.splice(index, 1);
                            renderItemsList();
                            updateHiddenInput();
                        });

                        itemElement.appendChild(itemSpan);
                        itemElement.appendChild(deleteButton);
                        listContainer.appendChild(itemElement);
                    });

                    // Show "Tidak ada data" message if the list is empty
                    if (itemsList.length === 0) {
                        const emptyMessage = document.createElement('div');
                        emptyMessage.className = 'text-muted fst-italic small';
                        emptyMessage.textContent = 'Belum ada data';
                        listContainer.appendChild(emptyMessage);
                    }
                }

                /**
                * Update hidden input with JSON data
                */
                function updateHiddenInput() {
                    hiddenInput.value = JSON.stringify(itemsList);
                }
            }
        });
    </script>
@endpush
