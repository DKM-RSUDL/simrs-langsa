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
    // diagnosis
        document.addEventListener('DOMContentLoaded', function () {
            // PERBAIKAN: Pastikan data master tersedia
            const dbMasterDiagnosis = @json($rmeMasterDiagnosis ? $rmeMasterDiagnosis->pluck('nama_diagnosis') : []);
            const masterImplementasi = @json($rmeMasterImplementasi ?? []);

            // Initialize diagnosis sections
            initDiagnosisManagementEdit('diagnosis-banding', 'diagnosis_banding');
            initDiagnosisManagementEdit('diagnosis-kerja', 'diagnosis_kerja');

            // Initialize implementation sections
            const sections = ['observasi', 'terapeutik', 'edukasi', 'kolaborasi'];
            sections.forEach(section => {
                initImplementationSectionEdit(section);
            });

            // Special handling for prognosis (maps to rencana-input)
            initImplementationSectionEdit('prognosis', 'rencana');

            function initDiagnosisManagementEdit(prefix, hiddenFieldId) {
                const inputField = document.getElementById(`${prefix}-input`);
                const addButton = document.getElementById(`add-${prefix}`);
                const listContainer = document.getElementById(`${prefix}-list`);
                const hiddenInput = document.getElementById(hiddenFieldId);

                if (!inputField || !addButton || !listContainer || !hiddenInput) {
                    console.warn(`Diagnosis elements not found for ${prefix}`);
                    return;
                }

                // PERBAIKAN: Get current list from hidden input and existing DOM
                let diagnosisList = [];
                try {
                    diagnosisList = JSON.parse(hiddenInput.value) || [];
                } catch (e) {
                    console.error('Error parsing diagnosis data:', e);
                    diagnosisList = [];
                }

                // Create suggestions container
                const suggestionsList = createSuggestionsList(inputField);

                // Handle input changes for suggestions
                inputField.addEventListener('input', function () {
                    const searchTerm = this.value.trim().toLowerCase();
                    if (!searchTerm) {
                        suggestionsList.style.display = 'none';
                        return;
                    }

                    const matches = dbMasterDiagnosis.filter(diagnosis =>
                        diagnosis.toLowerCase().includes(searchTerm) &&
                        !diagnosisList.includes(diagnosis)
                    );

                    showSuggestions(matches, searchTerm, suggestionsList, addDiagnosis);
                });

                // Handle existing remove buttons
                setupExistingRemoveButtons();

                function addDiagnosis(text) {
                    if (!diagnosisList.includes(text.trim())) {
                        diagnosisList.push(text.trim());
                        inputField.value = '';
                        renderDiagnosisList();
                        updateHiddenInput();
                        suggestionsList.style.display = 'none';
                    } else {
                        showDuplicateWarning(text);
                    }
                }

                function renderDiagnosisList() {
                    listContainer.innerHTML = '';
                    diagnosisList.forEach((diagnosis, index) => {
                        const item = createDiagnosisItem(diagnosis, index, () => {
                            diagnosisList.splice(index, 1);
                            renderDiagnosisList();
                            updateHiddenInput();
                        });
                        listContainer.appendChild(item);
                    });
                }

                function updateHiddenInput() {
                    hiddenInput.value = JSON.stringify(diagnosisList);
                }

                function setupExistingRemoveButtons() {
                    listContainer.addEventListener('click', function(e) {
                        if (e.target.closest('.remove-diagnosis')) {
                            e.preventDefault();
                            const item = e.target.closest('.diagnosis-item');
                            const index = Array.from(listContainer.children).indexOf(item);
                            if (index !== -1) {
                                diagnosisList.splice(index, 1);
                                renderDiagnosisList();
                                updateHiddenInput();
                            }
                        }
                    });
                }

                // Event listeners
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

            function initImplementationSectionEdit(section, inputPrefix = null) {
                const prefix = inputPrefix || section;
                const inputField = document.getElementById(`${prefix}-input`);
                const addButton = document.getElementById(`add-${prefix}`);
                const listContainer = document.getElementById(`${prefix}-list`);
                const hiddenInput = document.getElementById(section === 'prognosis' ? 'rencana_penatalaksanaan' : section);

                if (!inputField || !addButton || !listContainer || !hiddenInput) {
                    console.warn(`Implementation elements not found for ${section}`);
                    return;
                }

                // PERBAIKAN: Get current list from hidden input
                let itemsList = [];
                try {
                    itemsList = JSON.parse(hiddenInput.value) || [];
                } catch (e) {
                    console.error(`Error parsing ${section} data:`, e);
                    itemsList = [];
                }

                // Get options from database
                const dbOptions = masterImplementasi
                    .filter(item => item[section] && item[section] !== '(N/A)' && item[section] !== '(Null)')
                    .map(item => item[section]);
                const uniqueOptions = [...new Set(dbOptions)];

                // Create suggestions container
                const suggestionsList = createSuggestionsList(inputField);

                // Handle input changes
                inputField.addEventListener('input', function () {
                    const searchTerm = this.value.trim().toLowerCase();
                    if (!searchTerm) {
                        suggestionsList.style.display = 'none';
                        return;
                    }

                    const matches = uniqueOptions.filter(option =>
                        option.toLowerCase().includes(searchTerm) &&
                        !itemsList.includes(option)
                    );

                    showSuggestions(matches, searchTerm, suggestionsList, addItem);
                });

                // Handle existing remove buttons
                setupExistingRemoveButtons();

                function addItem(text) {
                    if (!itemsList.includes(text.trim())) {
                        itemsList.push(text.trim());
                        inputField.value = '';
                        renderItemsList();
                        updateHiddenInput();
                        suggestionsList.style.display = 'none';
                    } else {
                        showDuplicateWarning(text);
                    }
                }

                function renderItemsList() {
                    listContainer.innerHTML = '';

                    if (itemsList.length === 0) {
                        const emptyMsg = document.createElement('div');
                        emptyMsg.className = 'text-muted fst-italic small p-2';
                        emptyMsg.textContent = 'Belum ada data';
                        listContainer.appendChild(emptyMsg);
                        return;
                    }

                    itemsList.forEach((item, index) => {
                        const itemElement = createImplementationItem(item, index, () => {
                            itemsList.splice(index, 1);
                            renderItemsList();
                            updateHiddenInput();
                        });
                        listContainer.appendChild(itemElement);
                    });
                }

                function updateHiddenInput() {
                    hiddenInput.value = JSON.stringify(itemsList);
                }

                function setupExistingRemoveButtons() {
                    listContainer.addEventListener('click', function(e) {
                        if (e.target.closest('.remove-item')) {
                            e.preventDefault();
                            const item = e.target.closest('.list-group-item');
                            const index = Array.from(listContainer.children).indexOf(item);
                            if (index !== -1) {
                                itemsList.splice(index, 1);
                                renderItemsList();
                                updateHiddenInput();
                            }
                        }
                    });
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

            // Helper functions
            function createSuggestionsList(inputField) {
                const suggestionsList = document.createElement('div');
                suggestionsList.className = 'suggestions-list position-absolute bg-white border rounded shadow-sm';
                suggestionsList.style.cssText = 'z-index: 1000; max-height: 200px; overflow-y: auto; width: calc(100% - 60px); display: none; margin-left: 40px;';
                inputField.parentNode.insertBefore(suggestionsList, inputField.nextSibling);
                return suggestionsList;
            }

            function showSuggestions(matches, searchTerm, suggestionsList, addCallback) {
                suggestionsList.innerHTML = '';

                // Add matching items
                matches.slice(0, 10).forEach(match => { // Limit to 10 suggestions
                    const div = document.createElement('div');
                    div.className = 'suggestion-item p-2 cursor-pointer border-bottom';
                    div.style.cursor = 'pointer';
                    div.textContent = match;
                    div.addEventListener('click', () => addCallback(match));
                    div.addEventListener('mouseenter', () => div.classList.add('bg-light'));
                    div.addEventListener('mouseleave', () => div.classList.remove('bg-light'));
                    suggestionsList.appendChild(div);
                });

                // Add "create new" option if no exact match
                if (!matches.some(m => m.toLowerCase() === searchTerm.toLowerCase())) {
                    const newOption = document.createElement('div');
                    newOption.className = 'suggestion-item p-2 cursor-pointer text-primary';
                    newOption.style.cursor = 'pointer';
                    newOption.innerHTML = `<i class="bi bi-plus-circle me-1"></i>Tambah "${searchTerm}"`;
                    newOption.addEventListener('click', () => addCallback(searchTerm));
                    newOption.addEventListener('mouseenter', () => newOption.classList.add('bg-light'));
                    newOption.addEventListener('mouseleave', () => newOption.classList.remove('bg-light'));
                    suggestionsList.appendChild(newOption);
                }

                suggestionsList.style.display = 'block';
            }

            function createDiagnosisItem(diagnosis, index, removeCallback) {
                const item = document.createElement('div');
                item.className = 'diagnosis-item d-flex justify-content-between align-items-center mb-2 p-2 border rounded';

                const text = document.createElement('span');
                text.textContent = `${index + 1}. ${diagnosis}`;

                const deleteBtn = document.createElement('button');
                deleteBtn.className = 'btn btn-sm btn-outline-danger remove-diagnosis';
                deleteBtn.innerHTML = '<i class="bi bi-x"></i>';
                deleteBtn.type = 'button';
                deleteBtn.onclick = removeCallback;

                item.appendChild(text);
                item.appendChild(deleteBtn);
                return item;
            }

            function createImplementationItem(itemText, index, removeCallback) {
                const itemElement = document.createElement('div');
                itemElement.className = 'list-group-item d-flex justify-content-between align-items-center';

                const itemSpan = document.createElement('span');
                itemSpan.textContent = `${index + 1}. ${itemText}`;

                const deleteBtn = document.createElement('button');
                deleteBtn.className = 'btn btn-sm btn-outline-danger remove-item';
                deleteBtn.innerHTML = '<i class="bi bi-x"></i>';
                deleteBtn.type = 'button';
                deleteBtn.onclick = removeCallback;

                itemElement.appendChild(itemSpan);
                itemElement.appendChild(deleteBtn);
                return itemElement;
            }

            function showDuplicateWarning(text) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplikasi',
                        text: `"${text}" sudah ada dalam daftar`,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    alert(`"${text}" sudah ada dalam daftar`);
                }
            }
        });

    // PERBAIKAN: JavaScript untuk Edit Discharge Planning
        document.addEventListener('DOMContentLoaded', function () {
            // PERBAIKAN: Ambil semua elemen dengan ID yang spesifik
            const ageSelect = document.getElementById('usia_lanjut');
            const mobilitySelect = document.getElementById('hambatan_mobilisasi');
            const medServiceSelect = document.getElementById('penggunaan_media_berkelanjutan');
            const medicationSelect = document.getElementById('ketergantungan_aktivitas');

            // PERBAIKAN: Elemen kesimpulan dengan ID yang spesifik
            const infoAlert = document.getElementById('alert-info');
            const warningAlert = document.getElementById('alert-warning');
            const successAlert = document.getElementById('alert-success');
            const reasonsList = document.getElementById('reasons-list');
            const hiddenInput = document.getElementById('kesimpulan');

            // PERBAIKAN: Pastikan semua elemen tersedia sebelum menjalankan script
            if (!ageSelect || !mobilitySelect || !medServiceSelect || !medicationSelect) {
                console.warn('Discharge Planning: Beberapa elemen tidak ditemukan');
                return;
            }

            // PERBAIKAN: Fungsi untuk menghitung dan menampilkan kesimpulan
            function calculateDischargePlanningConclusion() {
                let needsSpecialPlan = false;
                let reasons = [];

                // PERBAIKAN: Cek usia lanjut (Ya = 0, Tidak = 1)
                if (ageSelect.value === '0') {
                    needsSpecialPlan = true;
                    reasons.push('Pasien berusia lanjut (>60 tahun)');
                }

                // PERBAIKAN: Cek hambatan mobilitas (Ya = 0, Tidak = 1)
                if (mobilitySelect.value === '0') {
                    needsSpecialPlan = true;
                    reasons.push('Terdapat hambatan mobilitas');
                }

                // PERBAIKAN: Cek pelayanan medis berkelanjutan
                if (medServiceSelect.value === 'ya') {
                    needsSpecialPlan = true;
                    reasons.push('Membutuhkan pelayanan medis berkelanjutan');
                }

                // PERBAIKAN: Cek ketergantungan aktivitas harian - LOGIC FIX
                if (medicationSelect.value === 'tidak') { // Jika TIDAK teratur = butuh bantuan
                    needsSpecialPlan = true;
                    reasons.push('Tidak teratur dalam konsumsi obat dan aktivitas harian');
                }

                // PERBAIKAN: Reset tampilan alert dengan null check
                if (infoAlert) infoAlert.classList.add('d-none');
                if (warningAlert) warningAlert.classList.add('d-none');
                if (successAlert) successAlert.classList.add('d-none');

                // PERBAIKAN: Tampilkan kesimpulan berdasarkan hasil evaluasi
                if (needsSpecialPlan && reasons.length > 0) {
                    if (warningAlert) warningAlert.classList.remove('d-none');
                    if (infoAlert) {
                        infoAlert.classList.remove('d-none');
                        if (reasonsList) {
                            reasonsList.innerHTML = '- ' + reasons.join('<br>- ');
                        }
                    }
                    if (hiddenInput) hiddenInput.value = 'Membutuhkan rencana pulang khusus';
                } else {
                    if (successAlert) successAlert.classList.remove('d-none');
                    if (hiddenInput) hiddenInput.value = 'Tidak membutuhkan rencana pulang khusus';
                }

                // PERBAIKAN: Debug log untuk troubleshooting
                console.log('Discharge Planning Calculation:', {
                    needsSpecialPlan,
                    reasons,
                    values: {
                        age: ageSelect.value,
                        mobility: mobilitySelect.value,
                        medService: medServiceSelect.value,
                        medication: medicationSelect.value
                    }
                });
            }

            // PERBAIKAN: Event listeners untuk setiap select dengan null check
            if (ageSelect) ageSelect.addEventListener('change', calculateDischargePlanningConclusion);
            if (mobilitySelect) mobilitySelect.addEventListener('change', calculateDischargePlanningConclusion);
            if (medServiceSelect) medServiceSelect.addEventListener('change', calculateDischargePlanningConclusion);
            if (medicationSelect) medicationSelect.addEventListener('change', calculateDischargePlanningConclusion);

            // PERBAIKAN: Inisialisasi kesimpulan saat halaman dimuat (dengan delay untuk memastikan DOM ready)
            setTimeout(() => {
                calculateDischargePlanningConclusion();
            }, 100);
        });

        // PERBAIKAN: Fungsi untuk reset form dengan nama yang unik
        function resetDischargePlanningEdit() {
            // PERBAIKAN: Reset dengan null check
            const ageSelect = document.getElementById('usia_lanjut');
            const mobilitySelect = document.getElementById('hambatan_mobilisasi');
            const medServiceSelect = document.getElementById('penggunaan_media_berkelanjutan');
            const medicationSelect = document.getElementById('ketergantungan_aktivitas');
            const rencanaPulangKhusus = document.querySelector('input[name="rencana_pulang_khusus"]');
            const rencanaLamaPerawatan = document.querySelector('input[name="rencana_lama_perawatan"]');
            const rencanaTglPulang = document.querySelector('input[name="rencana_tgl_pulang"]');

            // Reset select values
            if (ageSelect) ageSelect.selectedIndex = 0;
            if (mobilitySelect) mobilitySelect.selectedIndex = 0;
            if (medServiceSelect) medServiceSelect.selectedIndex = 0;
            if (medicationSelect) medicationSelect.selectedIndex = 0;

            // Reset input values
            if (rencanaPulangKhusus) rencanaPulangKhusus.value = '';
            if (rencanaLamaPerawatan) rencanaLamaPerawatan.value = '';
            if (rencanaTglPulang) rencanaTglPulang.value = '';

            // Reset alerts
            const infoAlert = document.getElementById('alert-info');
            const warningAlert = document.getElementById('alert-warning');
            const successAlert = document.getElementById('alert-success');
            const hiddenInput = document.getElementById('kesimpulan');

            if (infoAlert) infoAlert.classList.add('d-none');
            if (warningAlert) warningAlert.classList.add('d-none');
            if (successAlert) successAlert.classList.remove('d-none');
            if (hiddenInput) hiddenInput.value = 'Tidak membutuhkan rencana pulang khusus';

            // PERBAIKAN: Trigger calculation after reset
            setTimeout(() => {
                const event = new Event('change');
                if (ageSelect) ageSelect.dispatchEvent(event);
            }, 50);
        }
    </script>
@endpush
