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
            // Function to handle radio button changes
            function setupRadioControl(radioName, countInputName) {
                const radioButtons = document.querySelectorAll(`input[name="${radioName}"]`);
                const countInput = document.querySelector(`input[name="${countInputName}"]`);
                
                radioButtons.forEach(radio => {
                    radio.addEventListener('change', function() {
                        countInput.disabled = this.value !== '1';
                        if (this.value !== '1') {
                            countInput.value = '';
                        }
                    });
                });
            }
            
            // Setup for RS Langsa
            setupRadioControl('antenatal_rs', 'antenatal_rs_count');
            
            // Setup for tempat lain
            setupRadioControl('antenatal_lain', 'antenatal_lain_count');
            
            // Check current state on page load (for existing records)
            const rsRadioYes = document.getElementById('rs_ya');
            const lainRadioYes = document.getElementById('lain_ya');
            const rsCountInput = document.querySelector('input[name="antenatal_rs_count"]');
            const lainCountInput = document.querySelector('input[name="antenatal_lain_count"]');
            
            // Initialize input states
            rsCountInput.disabled = !rsRadioYes.checked;
            lainCountInput.disabled = !lainRadioYes.checked;
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

        //pemeriksaan fisik
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
        });

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

                if (!previewContainer || !fileInfo) {
                    console.error('Preview container or file info element not found');
                    return;
                }

                previewContainer.innerHTML = '';

                if (file && validateFile(file)) {
                    // Update file info
                    fileInfo.innerHTML = `
                        <span class="text-primary">File dipilih: ${file.name}</span>
                        <button type="button" class="btn btn-link text-danger p-0 ms-2 clear-file" data-input="${input.id}">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    `;

                    // Remove existing hidden input for removal flag
                    const removeInput = document.querySelector(`input[name="remove_${input.name}"]`);
                    if (removeInput) {
                        removeInput.parentNode.removeChild(removeInput);
                    }

                    // Create preview
                    if (file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.style.maxWidth = '100px';
                        img.style.maxHeight = '100px';
                        img.className = 'mt-2 rounded';

                        const reader = new FileReader();
                        reader.onload = (e) => {
                            // Create clickable preview
                            const link = document.createElement('a');
                            link.href = 'javascript:void(0)';
                            link.onclick = function () {
                                // Open image in new tab
                                const newTab = window.open();
                                newTab.document.write(`<img src="${e.target.result}" style="max-width: 100%;">`);
                                newTab.document.title = file.name;
                            };
                            link.title = "Klik untuk melihat ukuran penuh";

                            img.src = e.target.result;
                            link.appendChild(img);
                            previewContainer.appendChild(link);
                        };
                        reader.readAsDataURL(file);
                    } else if (file.type === 'application/pdf') {
                        const pdfIcon = document.createElement('i');
                        pdfIcon.className = 'bi bi-file-pdf text-danger fs-1 mt-2';

                        // We can't preview the PDF directly, but we can make it clickable
                        const link = document.createElement('a');
                        link.href = 'javascript:void(0)';
                        link.onclick = function () {
                            // Can't preview PDF from file input directly
                            alert('PDF dapat dilihat setelah disimpan.');
                        };
                        link.title = "PDF dapat dilihat setelah disimpan";

                        link.appendChild(pdfIcon);
                        previewContainer.appendChild(link);
                    }
                } else if (!file) {
                    fileInfo.innerHTML = '<span>Format: PDF, JPG, PNG (Max 2MB)</span>';
                }
            }

            // Load existing previews when page loads
            function loadExistingPreviews() {
                const previewContainers = document.querySelectorAll('.preview-container');

                previewContainers.forEach(container => {
                    // Check if there are any child elements (preview exists)
                    if (container.children.length > 0) {
                        // Make sure the container is visible
                        container.style.display = 'block';
                    }
                });
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

                    if (!input) {
                        console.error('Input element not found');
                        return;
                    }

                    const previewContainer = document.getElementById(input.dataset.previewContainer);
                    const fieldName = input.name;

                    // Clear file input
                    input.value = '';
                    if (previewContainer) {
                        previewContainer.innerHTML = '';
                    }

                    const fileInfo = document.getElementById(`${inputId}Info`);
                    if (fileInfo) {
                        fileInfo.innerHTML = '<span>Format: PDF, JPG, PNG (Max 2MB)</span>';
                    }

                    // Remove existing hidden input
                    const existingHidden = document.querySelector(`input[name="existing_${fieldName}"]`);
                    if (existingHidden) {
                        existingHidden.parentNode.removeChild(existingHidden);
                    }

                    // Add hidden input to indicate file removal
                    const removeInput = document.createElement('input');
                    removeInput.type = 'hidden';
                    removeInput.name = `remove_${fieldName}`;
                    removeInput.value = '1';
                    input.parentNode.appendChild(removeInput);
                }
            });

            // Initialize on page load
            loadExistingPreviews();
        });

        // 7. Discharge Planning
        document.addEventListener('DOMContentLoaded', function () {
            // Get references to elements
            const riskFactors = document.querySelectorAll('.risk-factor');
            const specialPlanAlert = document.getElementById('needSpecialPlanAlert');
            const noSpecialPlanAlert = document.getElementById('noSpecialPlanAlert');
            const needSpecialRadio = document.getElementById('need_special');
            const noSpecialRadio = document.getElementById('no_special');
            const conclusionHidden = document.getElementById('dp_kesimpulan_hidden');
            const conclusionSection = document.getElementById('conclusionSection');
            const conclusionText = document.getElementById('conclusionText');

            // Function to update discharge planning conclusion
            function updateDischargeConclusion() {
                let needsSpecialPlan = false;

                // Count how many risk factors are selected with "Ya" (value = 1)
                let riskCount = 0;
                riskFactors.forEach(factor => {
                    if (factor.value === '1') {
                        riskCount++;
                    }
                });

                // If 2 or more risk factors, patient needs special discharge plan
                needsSpecialPlan = riskCount >= 2;

                // Update UI
                if (needsSpecialPlan) {
                    specialPlanAlert.style.display = 'block';
                    noSpecialPlanAlert.style.display = 'none';
                    needSpecialRadio.checked = true;
                    conclusionHidden.value = 'Membutuhkan rencana pulang khusus';
                    conclusionText.textContent = 'Membutuhkan rencana pulang khusus';
                } else {
                    specialPlanAlert.style.display = 'none';
                    noSpecialPlanAlert.style.display = 'block';
                    noSpecialRadio.checked = true;
                    conclusionHidden.value = 'Tidak membutuhkan rencana pulang khusus';
                    conclusionText.textContent = 'Tidak membutuhkan rencana pulang khusus';
                }

                conclusionSection.style.display = 'block';
            }

            // Event listeners for risk factors
            riskFactors.forEach(factor => {
                factor.addEventListener('change', updateDischargeConclusion);
            });

            // Initialize date picker for discharge plan date
            const rencanaPulang = document.getElementById('rencanaPulang');
            const datePickerToggle = document.getElementById('datePickerToggle');

            if (rencanaPulang && datePickerToggle) {
                // Initialize flatpickr or your preferred date picker
                const datePicker = flatpickr(rencanaPulang, {
                    dateFormat: "d M Y",
                    altInput: true,
                    altFormat: "d M Y",
                    allowInput: true
                });

                // Toggle date picker when button is clicked
                datePickerToggle.addEventListener('click', function () {
                    datePicker.toggle();
                });
            }

            // If risk factors already have values on page load, calculate conclusion
            let hasValues = false;
            riskFactors.forEach(factor => {
                if (factor.value) {
                    hasValues = true;
                }
            });

            // Only auto-update if we don't already have a conclusion
            const currentConclusion = conclusionHidden.value;
            if (hasValues && !currentConclusion) {
                updateDischargeConclusion();
            }

            // Handle diagnosis management for diagnosis kerja and diagnosis banding
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
                    const hiddenValue = hiddenInput.value.trim();
                    if (hiddenValue) {
                        diagnosisList = JSON.parse(hiddenValue) || [];
                    }
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

        // 8. Diagnosis Diagnosis Banding
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

        // 9.Implementasi
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
