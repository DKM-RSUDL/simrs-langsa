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
        // Universal JSON formatting function
        function formatJsonForSubmission(data) {
            if (typeof data === 'string') {
                try {
                    const parsed = JSON.parse(data);
                    return JSON.stringify(parsed);
                } catch (error) {
                    console.error('JSON parsing error:', error);
                    return '[]';
                }
            } else if (Array.isArray(data)) {
                return JSON.stringify(data);
            }
            return '[]';
        }

        // Enhanced Obat Management
        window.obatManagement = {
            data: [],

            addObat: function (obatData) {
                const formattedObat = {
                    namaObat: obatData.namaObat || '',
                    dosis: obatData.dosis || '',
                    satuan: obatData.satuan || '',
                    frekuensi: obatData.frekuensi || '',
                    keterangan: obatData.keterangan || ''
                };

                this.data.push(formattedObat);
                this.updateHiddenInput();
                this.renderTable();
            },

            removeObat: function (index) {
                this.data.splice(index, 1);
                this.updateHiddenInput();
                this.renderTable();
            },

            updateHiddenInput: function () {
                const hiddenInput = document.getElementById('riwayatObatData');
                if (hiddenInput) {
                    hiddenInput.value = formatJsonForSubmission(this.data);
                    console.log('Updated obat data:', hiddenInput.value);
                }
            },

            renderTable: function () {
                const tableBody = document.querySelector('#createRiwayatObatTable tbody');
                if (!tableBody) return;

                tableBody.innerHTML = '';

                if (this.data.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Tidak ada data obat</td></tr>';
                    return;
                }

                this.data.forEach((obat, index) => {
                    const row = `
                    <tr>
                        <td>${obat.namaObat}</td>
                        <td>${obat.dosis} ${obat.satuan}</td>
                        <td>${obat.frekuensi} - ${obat.keterangan}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" onclick="obatManagement.removeObat(${index})">
                                <i class="ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                    tableBody.innerHTML += row;
                });
            },

            init: function () {
                const hiddenInput = document.getElementById('riwayatObatData');
                if (hiddenInput && hiddenInput.value && hiddenInput.value !== '[]') {
                    try {
                        this.data = JSON.parse(hiddenInput.value);
                        this.renderTable();
                    } catch (error) {
                        console.error('Error parsing existing obat data:', error);
                        this.data = [];
                        hiddenInput.value = '[]';
                    }
                }
            }
        };

        // Enhanced Alergi Management
        window.alergiManagement = {
            data: [],

            addAlergi: function (alergiData) {
                const formattedAlergi = {
                    jenis_alergi: alergiData.jenis_alergi || '',
                    alergen: alergiData.alergen || '',
                    reaksi: alergiData.reaksi || '',
                    tingkat_keparahan: alergiData.tingkat_keparahan || ''
                };

                this.data.push(formattedAlergi);
                this.updateHiddenInput();
                this.renderTable();
            },

            removeAlergi: function (index) {
                this.data.splice(index, 1);
                this.updateHiddenInput();
                this.renderTable();
            },

            updateHiddenInput: function () {
                const hiddenInput = document.getElementById('alergisInput');
                if (hiddenInput) {
                    hiddenInput.value = formatJsonForSubmission(this.data);
                    console.log('Updated alergi data:', hiddenInput.value);
                }
            },

            renderTable: function () {
                const tableBody = document.querySelector('#createAlergiTable tbody');
                if (!tableBody) return;

                tableBody.innerHTML = '';

                if (this.data.length === 0) {
                    tableBody.innerHTML = '<tr id="no-alergi-row"><td colspan="5" class="text-center text-muted">Tidak ada data alergi</td></tr>';
                    return;
                }

                this.data.forEach((alergi, index) => {
                    const row = `
                    <tr>
                        <td>${alergi.jenis_alergi}</td>
                        <td>${alergi.alergen}</td>
                        <td>${alergi.reaksi}</td>
                        <td>${alergi.tingkat_keparahan}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" onclick="alergiManagement.removeAlergi(${index})">
                                <i class="ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                    tableBody.innerHTML += row;
                });
            },

            init: function () {
                const hiddenInput = document.getElementById('alergisInput');
                if (hiddenInput && hiddenInput.value && hiddenInput.value !== '[]') {
                    try {
                        this.data = JSON.parse(hiddenInput.value);
                        this.renderTable();
                    } catch (error) {
                        console.error('Error parsing existing alergi data:', error);
                        this.data = [];
                        hiddenInput.value = '[]';
                    }
                }
            }
        };

        // 6. Apgar Skor
        document.addEventListener('DOMContentLoaded', function() {
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

                if (filled1 < 5 && filled5 < 5) {
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

            // Quick action buttons
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

            // Function to get APGAR data (bisa dipanggil dari luar)
            window.getApgarData = function() {
                const apgarDataInput = document.getElementById('apgar_data');
                if (apgarDataInput && apgarDataInput.value) {
                    return JSON.parse(apgarDataInput.value);
                }
                return null;
            };

            // Initial calculation
            calculateTotal();
        });

        // 7. Enhanced Diagnosis Management
        document.addEventListener('DOMContentLoaded', function () {
            initDiagnosisManagement('diagnosis-banding', 'diagnosis_banding');
            initDiagnosisManagement('diagnosis-kerja', 'diagnosis_kerja');

            function initDiagnosisManagement(prefix, hiddenFieldId) {
                const inputField = document.getElementById(`${prefix}-input`);
                const addButton = document.getElementById(`add-${prefix}`);
                const listContainer = document.getElementById(`${prefix}-list`);
                const hiddenInput = document.getElementById(hiddenFieldId);

                if (!inputField || !addButton || !listContainer || !hiddenInput) {
                    console.warn(`Diagnosis ${prefix} elements not found`);
                    return;
                }

                const suggestionsList = document.createElement('div');
                suggestionsList.className = 'suggestions-list position-absolute bg-white border rounded';
                suggestionsList.style.zIndex = '1000';
                suggestionsList.style.maxHeight = '200px';
                suggestionsList.style.overflowY = 'auto';
                suggestionsList.style.width = 'calc(100% - 30px)';
                suggestionsList.style.display = 'none';

                inputField.parentNode.insertBefore(suggestionsList, inputField.nextSibling);

                const dbMasterDiagnosis = {!! json_encode($rmeMasterDiagnosis->pluck('nama_diagnosis')) !!};
                const diagnosisOptions = dbMasterDiagnosis.map(text => ({
                    id: text.toLowerCase().replace(/\s+/g, '_'),
                    text: text
                }));

                let diagnosisList = [];
                try {
                    const hiddenValue = hiddenInput.value;
                    if (hiddenValue && hiddenValue !== '[]' && hiddenValue !== 'null') {
                        diagnosisList = JSON.parse(hiddenValue);
                    }
                    renderDiagnosisList();
                } catch (e) {
                    console.error('Error parsing diagnosis data:', e);
                    diagnosisList = [];
                    updateHiddenInput();
                }

                inputField.addEventListener('input', function () {
                    const inputValue = this.value.trim().toLowerCase();
                    if (inputValue) {
                        const filteredOptions = diagnosisOptions.filter(option =>
                            option.text.toLowerCase().includes(inputValue)
                        );
                        showSuggestions(filteredOptions, inputValue);
                    } else {
                        suggestionsList.style.display = 'none';
                    }
                });

                function showSuggestions(options, inputValue) {
                    suggestionsList.innerHTML = '';

                    if (options.length > 0) {
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

                addButton.addEventListener('click', function () {
                    const diagnosisText = inputField.value.trim();
                    if (diagnosisText) {
                        addDiagnosis(diagnosisText);
                    }
                });

                inputField.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const diagnosisText = this.value.trim();
                        if (diagnosisText) {
                            addDiagnosis(diagnosisText);
                        }
                    }
                });

                document.addEventListener('click', function (e) {
                    if (!inputField.contains(e.target) && !suggestionsList.contains(e.target)) {
                        suggestionsList.style.display = 'none';
                    }
                });

                function addDiagnosis(diagnosisText) {
                    if (!diagnosisList.includes(diagnosisText)) {
                        diagnosisList.push(diagnosisText);
                        inputField.value = '';
                        renderDiagnosisList();
                        updateHiddenInput();
                        suggestionsList.style.display = 'none';
                    } else {
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
                    hiddenInput.value = formatJsonForSubmission(diagnosisList);
                    console.log(`${hiddenFieldId} updated:`, hiddenInput.value);
                }
            }
        });

        // Form submission handler
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function (e) {
                    console.log('Form submitting, formatting JSON data...');

                    // Format all JSON hidden inputs
                    const jsonInputs = [
                        'riwayatObatData',
                        'alergisInput',
                        'diagnosis_banding',
                        'diagnosis_kerja'
                    ];

                    jsonInputs.forEach(inputId => {
                        const input = document.getElementById(inputId);
                        if (input && input.value) {
                            input.value = formatJsonForSubmission(input.value);
                            console.log(`${inputId}:`, input.value);
                        }
                    });

                    // Handle checkbox arrays
                    const kulitCheckboxes = document.querySelectorAll('input[name="kulit[]"]:checked');
                    const kukuCheckboxes = document.querySelectorAll('input[name="kuku[]"]:checked');
                    const imunisasiCheckboxes = document.querySelectorAll('input[name="riwayat_imunisasi[]"]:checked');

                    console.log('Kulit:', Array.from(kulitCheckboxes).map(cb => cb.value));
                    console.log('Kuku:', Array.from(kukuCheckboxes).map(cb => cb.value));
                    console.log('Imunisasi:', Array.from(imunisasiCheckboxes).map(cb => cb.value));
                });
            }

            // Initialize management systems
            if (typeof obatManagement !== 'undefined') {
                obatManagement.init();
            }

            if (typeof alergiManagement !== 'undefined') {
                alergiManagement.init();
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
@endpush
