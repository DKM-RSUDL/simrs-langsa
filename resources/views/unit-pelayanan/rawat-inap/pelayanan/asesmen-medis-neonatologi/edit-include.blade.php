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
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi data awal dari model
        const initialApgarData = @json($asesmen->asesmenMedisNeonatologiDtl->apgar_data ?? []);
        const initialTotal1 = {{ $asesmen->asesmenMedisNeonatologiDtl->total_1_minute ?? 0 }};
        const initialTotal5 = {{ $asesmen->asesmenMedisNeonatologiDtl->total_5_minute ?? 0 }};
        const initialTotalCombined = {{ $asesmen->asesmenMedisNeonatologiDtl->total_combined ?? 0 }};
        const initialInterpretation = "{{ $asesmen->asesmenMedisNeonatologiDtl->apgar_interpretation ?? '' }}";

        // Calculate totals and update interpretation
        function calculateTotal() {
            // Calculate 1 minute total
            let total1 = 0;
            let filled1 = 0;
            const categories1 = ['appearance_1', 'pulse_1', 'grimace_1', 'activity_1', 'respiration_1'];
            const data1 = {};

            categories1.forEach(category => {
                const select = document.querySelector(`select[name="${category}"]`);
                if (select && select.value !== '') {
                    const value = parseInt(select.value);
                    total1 += value;
                    filled1++;
                    data1[category] = {
                        value: value,
                        text: select.options[select.selectedIndex].text
                    };
                } else {
                    data1[category] = {
                        value: null,
                        text: null
                    };
                }
            });

            // Calculate 5 minute total
            let total5 = 0;
            let filled5 = 0;
            const categories5 = ['appearance_5', 'pulse_5', 'grimace_5', 'activity_5', 'respiration_5'];
            const data5 = {};

            categories5.forEach(category => {
                const select = document.querySelector(`select[name="${category}"]`);
                if (select && select.value !== '') {
                    const value = parseInt(select.value);
                    total5 += value;
                    filled5++;
                    data5[category] = {
                        value: value,
                        text: select.options[select.selectedIndex].text
                    };
                } else {
                    data5[category] = {
                        value: null,
                        text: null
                    };
                }
            });

            // Calculate combined total
            const totalCombined = total1 + total5;

            // Create complete data object
            const apgarData = {
                minute_1: {
                    categories: data1,
                    total: total1,
                    filled_count: filled1,
                    is_complete: filled1 === 5
                },
                minute_5: {
                    categories: data5,
                    total: total5,
                    filled_count: filled5,
                    is_complete: filled5 === 5
                },
                combined: {
                    total: totalCombined,
                    both_complete: filled1 === 5 && filled5 === 5
                },
                timestamp: new Date().toISOString()
            };

            // Update display
            document.getElementById('total_1_minute_display').textContent = total1;
            document.getElementById('total_5_minute_display').textContent = total5;
            document.getElementById('total_combined_display').textContent = totalCombined;

            // Update hidden inputs
            document.getElementById('total_1_minute').value = total1;
            document.getElementById('total_5_minute').value = total5;
            document.getElementById('total_combined').value = totalCombined;
            document.getElementById('apgar_data').value = JSON.stringify(apgarData);

            // Update badge colors based on scores
            updateBadgeColor('total_1_minute_display', total1, filled1);
            updateBadgeColor('total_5_minute_display', total5, filled5);
            updateCombinedBadgeColor('total_combined_display', totalCombined, filled1, filled5);

            // Show interpretation and save it
            const interpretation = updateInterpretation(total1, total5, totalCombined, filled1, filled5);
            document.getElementById('apgar_interpretation').value = interpretation;

            // Log data untuk debugging (bisa dihapus di production)
            console.log('APGAR Data:', apgarData);
        }

        // Update badge color based on score
        function updateBadgeColor(elementId, score, filledCount) {
            const badge = document.getElementById(elementId);

            if (filledCount < 5) {
                badge.className = 'badge bg-secondary fs-5';
            } else {
                if (score >= 8) {
                    badge.className = 'badge bg-success fs-5';
                } else if (score >= 4) {
                    badge.className = 'badge bg-warning fs-5';
                } else {
                    badge.className = 'badge bg-danger fs-5';
                }
            }
        }

        // Update combined badge color
        function updateCombinedBadgeColor(elementId, totalScore, filled1, filled5) {
            const badge = document.getElementById(elementId);

            if (filled1 < 5 || filled5 < 5) {
                badge.className = 'badge bg-secondary fs-5';
            } else {
                if (totalScore >= 16) {
                    badge.className = 'badge bg-success fs-5';
                } else if (totalScore >= 8) {
                    badge.className = 'badge bg-warning fs-5';
                } else {
                    badge.className = 'badge bg-danger fs-5';
                }
            }
        }

        // Update interpretation text and return the interpretation string
        function updateInterpretation(total1, total5, totalCombined, filled1, filled5) {
            const interpretation = document.getElementById('interpretation');
            const interpretationText = document.getElementById('interpretation_text');

            if (filled1 === 0 && filled5 === 0) {
                interpretation.style.display = 'none';
                return '';
            }

            let text = '';
            let alertClass = 'alert alert-secondary';

            // Interpretation based on individual scores
            if (filled1 === 5 && filled5 === 5) {
                const maxScore = Math.max(total1, total5);

                if (maxScore >= 8) {
                    text = `Kondisi bayi baik/normal. Skor 1 menit: ${total1}, Skor 5 menit: ${total5}, Total gabungan: ${totalCombined}. `;
                    if (total5 > total1) {
                        text += 'Kondisi membaik dari 1 ke 5 menit.';
                    } else if (total5 === total1) {
                        text += 'Kondisi stabil.';
                    }
                    alertClass = 'alert alert-success';
                } else if (maxScore >= 4) {
                    text = `Bayi memerlukan pengawasan khusus. Skor 1 menit: ${total1}, Skor 5 menit: ${total5}, Total gabungan: ${totalCombined}. `;
                    if (total5 > total1) {
                        text += 'Ada perbaikan dari 1 ke 5 menit.';
                    } else {
                        text += 'Perlu perhatian berkelanjutan.';
                    }
                    alertClass = 'alert alert-warning';
                } else {
                    text = `Bayi dalam kondisi kritis, memerlukan resusitasi segera. Skor 1 menit: ${total1}, Skor 5 menit: ${total5}, Total gabungan: ${totalCombined}. `;
                    if (total5 > total1) {
                        text += 'Ada sedikit perbaikan tapi masih memerlukan intervensi medis.';
                    } else {
                        text += 'Kondisi tetap kritis.';
                    }
                    alertClass = 'alert alert-danger';
                }
            } else if (filled1 === 5) {
                text = `Skor 1 menit: ${total1} (${getScoreStatus(total1)}). Lengkapi penilaian 5 menit untuk evaluasi menyeluruh.`;
                alertClass = 'alert alert-info';
            } else if (filled5 === 5) {
                text = `Skor 5 menit: ${total5} (${getScoreStatus(total5)}). Lengkapi penilaian 1 menit untuk evaluasi menyeluruh.`;
                alertClass = 'alert alert-info';
            } else {
                text = `Penilaian belum lengkap. Lengkapi semua parameter untuk mendapatkan interpretasi yang akurat.`;
                alertClass = 'alert alert-warning';
            }

            interpretation.className = alertClass;
            interpretationText.textContent = text;
            interpretation.style.display = 'block';

            return text;
        }

        // Get score status helper function
        function getScoreStatus(score) {
            if (score >= 8) return 'Baik/Normal';
            if (score >= 4) return 'Perlu Perhatian';
            return 'Kritis';
        }

        // Add event listeners to all select elements
        const allSelects = document.querySelectorAll('select[name*="_1"], select[name*="_5"]');
        allSelects.forEach(select => {
            select.addEventListener('change', calculateTotal);
        });

        // Quick action buttons (tidak ada elemen di HTML, jadi dikomentari)
        /*
        document.getElementById('fillNormal').addEventListener('click', function() {
            allSelects.forEach(select => {
                select.value = '2';
            });
            calculateTotal();
        });

        document.getElementById('copy1to5').addEventListener('click', function() {
            const categories = ['appearance', 'pulse', 'grimace', 'activity', 'respiration'];
            categories.forEach(category => {
                const select1 = document.querySelector(`select[name="${category}_1"]`);
                const select5 = document.querySelector(`select[name="${category}_5"]`);
                if (select1 && select5 && select1.value) {
                    select5.value = select1.value;
                }
            });
            calculateTotal();
        });

        document.getElementById('resetAll').addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin mereset semua nilai APGAR?')) {
                allSelects.forEach(select => {
                    select.value = '';
                });
                calculateTotal();
            }
        });
        */

        // Function to get APGAR data
        window.getApgarData = function() {
            const apgarDataInput = document.getElementById('apgar_data');
            if (apgarDataInput && apgarDataInput.value) {
                try {
                    return JSON.parse(apgarDataInput.value);
                } catch (e) {
                    console.error('Error parsing apgar_data:', e);
                    return null;
                }
            }
            return null;
        };

        // Initial calculation to display model data
        calculateTotal();
    });

    // diagnosis-kerja dan diagnosis-banding - PERBAIKAN LENGKAP
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
                const hiddenValue = hiddenInput.value.trim();
                if (hiddenValue) {
                    diagnosisList = JSON.parse(hiddenValue);
                    // PERBAIKAN: Pastikan diagnosisList adalah array
                    if (!Array.isArray(diagnosisList)) {
                        diagnosisList = [];
                    }
                }
            } catch (e) {
                console.error('Error parsing diagnosis data:', e);
                diagnosisList = [];
            }

            // Create suggestions container
            const suggestionsList = createSuggestionsList(inputField);

            // PERBAIKAN KUNCI: Render existing data saat pertama kali load
            renderDiagnosisList();

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

            function addDiagnosis(text) {
                const trimmedText = text.trim();
                if (trimmedText && !diagnosisList.includes(trimmedText)) {
                    diagnosisList.push(trimmedText);
                    inputField.value = '';
                    renderDiagnosisList();
                    updateHiddenInput();
                    suggestionsList.style.display = 'none';
                } else if (diagnosisList.includes(trimmedText)) {
                    showDuplicateWarning(trimmedText);
                }
            }

            function removeDiagnosis(index) {
                if (index >= 0 && index < diagnosisList.length) {
                    diagnosisList.splice(index, 1);
                    renderDiagnosisList();
                    updateHiddenInput();
                }
            }

            function renderDiagnosisList() {
                listContainer.innerHTML = '';

                if (diagnosisList.length === 0) {
                    const emptyMsg = document.createElement('div');
                    emptyMsg.className = 'text-muted fst-italic small p-2';
                    emptyMsg.textContent = 'Belum ada diagnosis';
                    listContainer.appendChild(emptyMsg);
                    return;
                }

                diagnosisList.forEach((diagnosis, index) => {
                    const item = createDiagnosisItem(diagnosis, index, () => removeDiagnosis(index));
                    listContainer.appendChild(item);
                });
            }

            function updateHiddenInput() {
                hiddenInput.value = JSON.stringify(diagnosisList);
            }

            // Event listeners
            addButton.addEventListener('click', (e) => {
                e.preventDefault();
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
                const hiddenValue = hiddenInput.value.trim();
                if (hiddenValue) {
                    itemsList = JSON.parse(hiddenValue);
                    // PERBAIKAN: Pastikan itemsList adalah array
                    if (!Array.isArray(itemsList)) {
                        itemsList = [];
                    }
                }
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

            // PERBAIKAN KUNCI: Render existing data saat pertama kali load
            renderItemsList();

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

            function addItem(text) {
                const trimmedText = text.trim();
                if (trimmedText && !itemsList.includes(trimmedText)) {
                    itemsList.push(trimmedText);
                    inputField.value = '';
                    renderItemsList();
                    updateHiddenInput();
                    suggestionsList.style.display = 'none';
                } else if (itemsList.includes(trimmedText)) {
                    showDuplicateWarning(trimmedText);
                }
            }

            function removeItem(index) {
                if (index >= 0 && index < itemsList.length) {
                    itemsList.splice(index, 1);
                    renderItemsList();
                    updateHiddenInput();
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
                    const itemElement = createImplementationItem(item, index, () => removeItem(index));
                    listContainer.appendChild(itemElement);
                });
            }

            function updateHiddenInput() {
                hiddenInput.value = JSON.stringify(itemsList);
            }

            // Event listeners
            addButton.addEventListener('click', (e) => {
                e.preventDefault();
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
            item.className = 'diagnosis-item d-flex justify-content-between align-items-center mb-2 p-2 border rounded bg-white';

            const text = document.createElement('span');
            text.className = 'flex-grow-1';
            text.textContent = `${index + 1}. ${diagnosis}`;

            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'btn btn-sm btn-outline-danger ms-2';
            deleteBtn.innerHTML = '<i class="bi bi-x"></i>';
            deleteBtn.type = 'button';
            deleteBtn.title = 'Hapus diagnosis';
            deleteBtn.addEventListener('click', (e) => {
                e.preventDefault();
                removeCallback();
            });

            item.appendChild(text);
            item.appendChild(deleteBtn);
            return item;
        }

        function createImplementationItem(itemText, index, removeCallback) {
            const itemElement = document.createElement('div');
            itemElement.className = 'list-group-item d-flex justify-content-between align-items-center bg-white';

            const itemSpan = document.createElement('span');
            itemSpan.className = 'flex-grow-1';
            itemSpan.textContent = `${index + 1}. ${itemText}`;

            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'btn btn-sm btn-outline-danger ms-2';
            deleteBtn.innerHTML = '<i class="bi bi-x"></i>';
            deleteBtn.type = 'button';
            deleteBtn.title = 'Hapus item';
            deleteBtn.addEventListener('click', (e) => {
                e.preventDefault();
                removeCallback();
            });

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

    // Discharge Planning
    document.addEventListener('DOMContentLoaded', function() {

        // Handler untuk usia yang menarik bayi
        const usiaRadios = document.querySelectorAll('input[name="usia_menarik_bayi"]');
        const keteranganUsia = document.querySelector('input[name="keterangan_usia"]');
        const keteranganTidakUsia = document.querySelector('input[name="keterangan_tidak_usia"]');

        usiaRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'ya') {
                    keteranganUsia.disabled = false;
                    keteranganTidakUsia.disabled = true;
                    keteranganTidakUsia.value = '';
                } else {
                    keteranganUsia.disabled = true;
                    keteranganUsia.value = '';
                    keteranganTidakUsia.disabled = false;
                }
            });
        });

        // Handler untuk masalah saat pulang
        const masalahRadios = document.querySelectorAll('input[name="masalah_pulang"]');
        const keteranganMasalah = document.querySelector('textarea[name="keterangan_masalah_pulang"]');

        masalahRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'ya') {
                    keteranganMasalah.disabled = false;
                } else {
                    keteranganMasalah.disabled = true;
                    keteranganMasalah.value = '';
                }
            });
        });

        // Handler untuk edukasi lainnya
        const edukasiLainnya = document.querySelector('#edukasi_lainnya');
        const edukasiLainnyaKeterangan = document.querySelector('input[name="edukasi_lainnya_keterangan"]');

        edukasiLainnya.addEventListener('change', function() {
            if (this.checked) {
                edukasiLainnyaKeterangan.disabled = false;
            } else {
                edukasiLainnyaKeterangan.disabled = true;
                edukasiLainnyaKeterangan.value = '';
            }
        });

        // Handler untuk ada yang membantu
        const membrantuRadios = document.querySelectorAll('input[name="ada_membantu"]');
        const keteranganMembantu = document.querySelector('input[name="keterangan_membantu"]');

        membrantuRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'ada') {
                    keteranganMembantu.disabled = false;
                } else {
                    keteranganMembantu.disabled = true;
                    keteranganMembantu.value = '';
                }
            });
        });
    });

</script>
@endPush
