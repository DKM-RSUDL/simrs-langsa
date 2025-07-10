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
            min-width: 200px;
            flex-shrink: 0;
        }

        .form-group .form-control,
        .form-group .form-select {
            flex: 1;
        }

        /* Custom table styling */
        .table-asesmen {
            margin-bottom: 0;
        }

        .table-asesmen th {
            background-color: #f8f9fa;
            font-weight: 600;
            border: 1px solid #dee2e6;
            padding: 12px;
            vertical-align: middle;
        }

        .table-asesmen td {
            border: 1px solid #dee2e6;
            padding: 12px;
            vertical-align: top;
        }

        .table-asesmen .label-col {
            background-color: #f8f9fa;
            font-weight: 600;
            width: 200px;
        }

        /* Form control styling inside table */
        .table-asesmen .form-control,
        .table-asesmen .form-select {
            border: 1px solid #ced4da;
            box-shadow: none;
            background-color: transparent;
            padding: 8px 12px;
        }

        .table-asesmen .form-control:focus,
        .table-asesmen .form-select:focus {
            background-color: #fff;
            border: 1px solid #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        /* Checkbox and radio styling */
        .form-check-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
        }

        .form-check {
            margin: 0;
            padding-left: 1.5rem;
            min-height: auto;
        }

        .form-check-input {
            margin-top: 0.125rem;
        }

        .form-check label {
            margin-right: 0;
            padding-top: 0;
            cursor: pointer;
        }

        /* Inline input styling */
        .input-inline {
            width: auto;
            display: inline-block;
            margin: 0 5px;
        }

        .input-sm {
            width: 80px;
        }

        .input-md {
            width: 120px;
        }

        .input-lg {
            width: 200px;
        }

        /* Button styling */
        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-group {
                flex-direction: column;
                align-items: stretch;
            }

            .form-group label {
                min-width: auto;
                margin-bottom: 0.5rem;
            }

            .form-check-group {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .table-asesmen .label-col {
                width: auto;
            }

            .input-inline {
                width: 100%;
                margin: 5px 0;
            }
        }

        /* pemeriksaan fisik baru */
        .input-inline {
            width: auto;
            display: inline-block;
            min-width: 120px;
        }

        .table-asesmen td {
            vertical-align: middle;
        }

        .form-check {
            margin-bottom: 0;
        }

        .text-muted {
            font-size: 0.9em;
        }

        .section-separator {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .section-title {
            color: #495057;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .site-marking-container {
            border: 2px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            background: #f8f9fa;
            position: relative;
        }

        .paru-color-btn {
            transition: all 0.2s;
        }

        .paru-color-btn:hover {
            transform: scale(1.1);
            border-color: #6c757d !important;
        }

        .paru-color-btn.active {
            border-color: #fff !important;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.3);
            transform: scale(1.1);
        }

        .paru-marking-list-item {
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            margin-bottom: 8px;
            background: #fff;
            transition: background-color 0.2s;
        }

        .paru-marking-list-item:hover {
            background: #f8f9fa;
        }

        #paruMarkingCanvas {
            pointer-events: auto;
        }

        #paruAnatomyImage {
            display: block;
            max-width: 100%;
            height: auto;
        }
    </style>
@endpush

@push('js')
    <script>
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

        // 7. Diagnosis Diagnosis Banding
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
                        diagnosisItem.className =
                            'diagnosis-item d-flex justify-content-between align-items-center mb-2';

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
        document.addEventListener('DOMContentLoaded', function () {
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
                inputField.addEventListener('input', function () {
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
                            newOptionItem.innerHTML =
                                `<i class="bi bi-plus-circle me-1"></i> Tambah "${inputValue}"`;
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
                addButton.addEventListener('click', function () {
                    const itemText = inputField.value.trim();
                    if (itemText) {
                        addItem(itemText);
                    }
                });

                // Add item when Enter
                inputField.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const itemText = this.value.trim();
                        if (itemText) {
                            addItem(itemText);
                        }
                    }
                });

                // Close
                document.addEventListener('click', function (e) {
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
                        toast.addEventListener('hidden.bs.toast', function () {
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
                        itemElement.className =
                            'list-group-item d-flex justify-content-between align-items-center border-0 ps-0';

                        const itemSpan = document.createElement('span');
                        itemSpan.textContent = `${index + 1}. ${item}`;

                        const deleteButton = document.createElement('button');
                        deleteButton.className = 'btn btn-link text-danger p-0';
                        deleteButton.type = 'button';
                        deleteButton.innerHTML = '<i class="bi bi-trash"></i>';
                        deleteButton.addEventListener('click', function () {
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

        // 9. Perencanaan Pulang Pasien (Discharge Planning)
        // Script untuk menghitung kesimpulan discharge planning otomatis
        document.addEventListener('DOMContentLoaded', function () {
            // Ambil semua elemen yang mempengaruhi kesimpulan
            const ageSelect = document.querySelector('select[name="usia_lanjut"]');
            const mobilitySelect = document.querySelector('select[name="hambatan_mobilisasi"]');
            const medServiceSelect = document.querySelector('select[name="penggunaan_media_berkelanjutan"]');
            const medicationSelect = document.querySelector('select[name="ketergantungan_aktivitas"]');

            // Elemen kesimpulan
            const infoAlert = document.querySelector('.alert-info');
            const warningAlert = document.querySelector('.alert-warning');
            const successAlert = document.querySelector('.alert-success');
            const hiddenInput = document.querySelector('#kesimpulan');

            // Fungsi untuk menghitung dan menampilkan kesimpulan
            function calculateConclusion() {
                let needsSpecialPlan = false;
                let reasons = [];

                // Cek usia lanjut (Ya = 0, Tidak = 1)
                if (ageSelect.value === '0') {
                    needsSpecialPlan = true;
                    reasons.push('Pasien berusia lanjut (>60 tahun)');
                }

                // Cek hambatan mobilitas (Ya = 0, Tidak = 1)
                if (mobilitySelect.value === '0') {
                    needsSpecialPlan = true;
                    reasons.push('Terdapat hambatan mobilitas');
                }

                // Cek pelayanan medis berkelanjutan
                if (medServiceSelect.value === 'ya') {
                    needsSpecialPlan = true;
                    reasons.push('Membutuhkan pelayanan medis berkelanjutan');
                }

                // Cek ketergantungan aktivitas harian
                if (medicationSelect.value === 'ya') {
                    needsSpecialPlan = true;
                    reasons.push('Membutuhkan bantuan dalam konsumsi obat dan aktivitas harian');
                }

                // Reset tampilan alert
                infoAlert.classList.add('d-none');
                warningAlert.classList.add('d-none');
                successAlert.classList.add('d-none');

                // Tampilkan kesimpulan berdasarkan hasil evaluasi
                if (needsSpecialPlan) {
                    warningAlert.classList.remove('d-none');
                    infoAlert.classList.remove('d-none');
                    infoAlert.innerHTML = '<strong>Alasan:</strong><br>' + reasons.join('<br>- ');
                    hiddenInput.value = 'Membutuhkan rencana pulang khusus';
                } else {
                    successAlert.classList.remove('d-none');
                    hiddenInput.value = 'Tidak membutuhkan rencana pulang khusus';
                }
            }

            // Event listeners untuk setiap select
            ageSelect.addEventListener('change', calculateConclusion);
            mobilitySelect.addEventListener('change', calculateConclusion);
            medServiceSelect.addEventListener('change', calculateConclusion);
            medicationSelect.addEventListener('change', calculateConclusion);

            // Inisialisasi kesimpulan saat halaman dimuat
            calculateConclusion();
        });

        // Fungsi untuk reset form (opsional)
        function resetDischargePlanning() {
            document.querySelector('select[name="usia_lanjut"]').value = '';
            document.querySelector('select[name="hambatan_mobilisasi"]').value = '';
            document.querySelector('select[name="penggunaan_media_berkelanjutan"]').value = '';
            document.querySelector('select[name="ketergantungan_aktivitas"]').value = '';

            // Reset alerts
            document.querySelector('.alert-info').classList.add('d-none');
            document.querySelector('.alert-warning').classList.add('d-none');
            document.querySelector('.alert-success').classList.add('d-none');

            document.querySelector('#kesimpulan').value = 'Tidak membutuhkan rencana pulang khusus';
        }
    </script>
@endpush
