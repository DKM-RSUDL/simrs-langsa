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

        /* 7. resiko jatuh */
        .risk-form {
            display: none;
        }

        .conclusion {
            background-color: #198754;
            color: white;
            padding: 10px;
            border-radius: 4px;
            margin-top: 20px;
        }

        .conclusion.warning {
            background-color: #ffc107;
        }

        .conclusion.danger {
            background-color: #dc3545;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .form-section h6 {
            color: #0d6efd;
            margin-bottom: 1rem;
        }

        .suggestions-list {
            position: absolute;
            z-index: 1000;
            width: calc(100% - 2rem);
            max-height: 200px;
            overflow-y: auto;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            display: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .suggestion-item {
            padding: 8px 12px;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background-color: #f8f9fa;
        }

        .selected-items {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .selected-item {
            display: inline-flex;
            align-items: center;
            background: #e9ecef;
            padding: 4px 8px;
            border-radius: 4px;
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .selected-item .delete-btn {
            margin-left: 8px;
            color: #dc3545;
            cursor: pointer;
            border: none;
            background: none;
            padding: 0 4px;
        }
    </style>
@endpush

@push('js')
    <script>
        // 1. Status Air way
        $(document).ready(function() {
            // Initialize state management for airway
            let airwayTindakanState = [];

            // Handle modal show
            $('.btn-tindakan-airway').click(function(e) {
                let target = $(this).attr('data-bs-target');
                $(target).modal('show');
            });

            // Function to update airway tindakan display
            function updateAirwayTindakan(dataArr, append = false) {
                const airwayListEl = $('#selectedTindakanList-airway');
                let airwayCurrent = [];

                // Jika append true, ambil data yang sudah ada
                if (append) {
                    airwayCurrent = airwayListEl.find('.airway-item span')
                        .map(function() {
                            return $(this).text().trim();
                        }).get();
                }

                // Gabungkan data lama dengan data baru dan hilangkan duplikat
                let airwayAll = [...new Set([...airwayCurrent, ...dataArr])];
                let airwayHtml = '';

                if (airwayAll.length > 0) {
                    airwayAll.forEach(item => {
                        if (item.trim()) {
                            airwayHtml += `
                                <div class="airway-item d-flex align-items-center justify-content-between gap-2 bg-light p-2 rounded">
                                    <span>${item}</span>
                                    <button type="button" class="btn btn-sm btn-airway-delete text-danger p-0">
                                        <i class="ti-close"></i>
                                    </button>
                                </div>`;
                        }
                    });

                    // Add hidden input with all airway tindakan
                    airwayHtml += `<input type="hidden" name="airway_tindakan" value='${JSON.stringify(airwayAll)}'>`;
                }

                airwayListEl.html(airwayHtml);
                airwayTindakanState = airwayAll;
            }

            // Save airway tindakan from modal
            $('.btn-save-tindakan-airway').click(function(e) {
                let modal = $(this).closest('.modal');
                let airwaySelected = [];

                // Collect checked items
                modal.find('.form-check-input:checked').each(function() {
                    airwaySelected.push($(this).val());
                });

                // Update dengan append = true untuk menambahkan ke data yang sudah ada
                updateAirwayTindakan(airwaySelected, true);
                modal.modal('hide');

                // Reset checkboxes setelah simpan
                modal.find('.form-check-input').prop('checked', false);
            });

            // Handle removal of airway item
            $(document).on('click', '.btn-airway-delete', function() {
                let airwayItem = $(this).closest('.airway-item');
                let airwayContainer = airwayItem.parent();
                let airwayRemovedText = airwayItem.find('span').text().trim();

                // Uncheck the corresponding checkbox if exists
                $(`#tindakanKeperawatanAirwayModal .form-check-input[value="${airwayRemovedText}"]`).prop('checked', false);

                airwayItem.remove();

                // Update hidden input after removal
                let airwayRemaining = airwayContainer.find('.airway-item span').map(function() {
                    return $(this).text().trim();
                }).get();

                if (airwayRemaining.length > 0) {
                    let airwayHiddenInput = `<input type="hidden" name="airway_tindakan" value='${JSON.stringify(airwayRemaining)}'>`;
                    airwayContainer.find('input[type="hidden"]').remove();
                    airwayContainer.append(airwayHiddenInput);
                } else {
                    airwayContainer.find('input[type="hidden"]').remove();
                }

                airwayTindakanState = airwayRemaining;
            });

            // Initialize existing airway data
            function initializeAirwayData() {
                let airwayExisting = $('#existingTindakan-airway').val();

                if (airwayExisting) {
                    try {
                        let airwayArray = JSON.parse(airwayExisting);
                        if (Array.isArray(airwayArray)) {
                            airwayTindakanState = airwayArray;
                            updateAirwayTindakan(airwayArray, false);

                            // Pre-check modal checkboxes for existing items
                            airwayArray.forEach(item => {
                                let airwayCheckbox = $('.modal .form-check-input[value="' + item + '"]');
                                if (airwayCheckbox.length) {
                                    airwayCheckbox.prop('checked', true);
                                }
                            });
                        }
                    } catch (e) {
                        console.error('Error parsing airway data:', e);
                    }
                }
            }

            // Reset airway modal when closed
            $('#tindakanKeperawatanAirwayModal').on('hidden.bs.modal', function() {
                let modal = $(this);
                if (!modal.find('.airway-item').length) {
                    modal.find('.form-check-input').prop('checked', false);
                }
            });

            // Form submission handler
            $('#asesmenForm').on('submit', function(e) {
                if (airwayTindakanState.length > 0) {
                    const airwayInput = $('input[name="airway_tindakan"]');
                    if (!airwayInput.length) {
                        $(this).append(`<input type="hidden" name="airway_tindakan" value='${JSON.stringify(airwayTindakanState)}'>`);
                    }
                }
            });

            // Initialize on page load
            initializeAirwayData();

            // Handle checkbox changes for diagnosis (tetap sama karena tidak terkait dengan airway)
            $('.diagnose-prwt-checkbox').change(function() {
                let diagnosisWrap = $(this).closest('.diagnosis-row');
                let radioInputs = diagnosisWrap.find('input[type="radio"]');

                if ($(this).is(':checked')) {
                    radioInputs.prop('disabled', false);
                    radioInputs.prop('required', true);
                } else {
                    radioInputs.prop('disabled', true);
                    radioInputs.prop('checked', false);
                    radioInputs.prop('required', false);
                }
            });
        });

        $(document).ready(function() {
            // Initial state for radio buttons
            function initDiagnosisState() {
                $('.diagnose-prwt-checkbox').each(function() {
                    let diagnosisWrap = $(this).closest('.diagnosis-row');
                    let radioInputs = diagnosisWrap.find('input[type="radio"]');

                    if ($(this).is(':checked')) {
                        radioInputs.prop('disabled', false);
                        // Hapus required
                        radioInputs.prop('required', false);
                    } else {
                        radioInputs.prop('disabled', true);
                        radioInputs.prop('required', false);
                    }
                });
            }

            // Run initialization
            initDiagnosisState();

            // Handle checkbox changes
            $('.diagnose-prwt-checkbox').change(function() {
                let diagnosisWrap = $(this).closest('.diagnosis-row');
                let radioInputs = diagnosisWrap.find('input[type="radio"]');

                if ($(this).is(':checked')) {
                    radioInputs.prop('disabled', false);
                    // Hapus required
                    radioInputs.prop('required', false);

                    // Opsional: Tambahkan default pilihan jika belum ada yang dipilih
                    if (!radioInputs.filter(':checked').length) {
                        diagnosisWrap.find('#airway_aktual').prop('checked', true);
                    }
                } else {
                    radioInputs.prop('disabled', true);
                    radioInputs.prop('checked', false);
                    radioInputs.prop('required', false);
                }
            });

            // Modifikasi form submission
            $('#asesmenForm').submit(function(e) {
                // Hapus validasi paksa
                // Biarkan form submit tanpa syarat
                return true;
            });

            // Handle radio button changes
            $('input[name="airway_diagnosis_type"]').change(function() {
                if ($(this).is(':checked')) {
                    $(this).closest('.diagnosis-row')
                        .find('input[name="airway_diagnosis"]')
                        .prop('checked', true);
                }
            });
        });

        // 2. Status Breathing
        $(document).ready(function() {
            // Initialize state management
            let breathingTindakanState = [];

            // Handle modal show
            $('.btn-tindakan-breathing').click(function() {
                let target = $(this).data('bs-target');
                $(target).modal('show');
            });

            // Function to update breathing tindakan display
            function updateBreathingTindakan(dataArr, append = false) {
                const breathingListEl = $('#selectedTindakanList-breathing');
                let breathingCurrent = [];

                // If append is true, get existing data
                if (append) {
                    breathingCurrent = breathingListEl.find('.breathing-item span')
                        .map(function() {
                            return $(this).text().trim();
                        }).get();
                }

                // Combine old and new data, remove duplicates
                let breathingAll = [...new Set([...breathingCurrent, ...dataArr])];
                let breathingHtml = '';

                if (breathingAll.length > 0) {
                    breathingAll.forEach(item => {
                        if (item.trim()) {
                            breathingHtml += `
                                <div class="breathing-item d-flex align-items-center justify-content-between gap-2 bg-light p-2 rounded">
                                    <span>${item}</span>
                                    <button type="button" class="btn btn-sm btn-breathing-delete text-danger p-0">
                                        <i class="ti-close"></i>
                                    </button>
                                </div>`;
                        }
                    });

                    breathingHtml += `<input type="hidden" name="breathing_tindakan" value='${JSON.stringify(breathingAll)}'>`;
                }

                breathingListEl.html(breathingHtml);
                breathingTindakanState = breathingAll;
            }

            // Handle checkbox changes in breathing modal
            $('#tindakanKeperawatanBreathingModal .form-check-input').change(function() {
                let modal = $(this).closest('.modal');
                let breathingSelected = [];

                // Collect all checked items
                modal.find('.form-check-input:checked').each(function() {
                    breathingSelected.push($(this).val());
                });

                // Update display immediately
                updateBreathingTindakan(breathingSelected, false);
            });

            // Save breathing from modal
            $('.btn-save-tindakan-breathing').click(function() {
                let modal = $(this).closest('.modal');
                modal.modal('hide');
            });

            // Handle removal of breathing item
            $(document).on('click', '.btn-breathing-delete', function() {
                const breathingItem = $(this).closest('.breathing-item');
                const breathingText = breathingItem.find('span').text().trim();

                // Uncheck the corresponding checkbox if exists
                $(`#tindakanKeperawatanBreathingModal .form-check-input[value="${breathingText}"]`).prop('checked', false);

                // Update state
                breathingTindakanState = breathingTindakanState.filter(text => text !== breathingText);

                // Update display
                updateBreathingTindakan(breathingTindakanState, false);
            });

            // Initialize existing breathing data
            function initializeBreathingData() {
                const breathingExisting = $('#existingTindakan-breathing').val();

                if (breathingExisting) {
                    try {
                        const breathingParsed = JSON.parse(breathingExisting);
                        if (Array.isArray(breathingParsed)) {
                            breathingTindakanState = breathingParsed;
                            updateBreathingTindakan(breathingParsed, false);

                            // Pre-check modal checkboxes
                            breathingParsed.forEach(item => {
                                const breathingCheck = $('#tindakanKeperawatanBreathingModal .form-check-input[value="' + item + '"]');
                                if (breathingCheck.length) {
                                    breathingCheck.prop('checked', true);
                                }
                            });
                        }
                    } catch (error) {
                        console.error('Error parsing breathing data:', error);
                    }
                }
            }

            // Reset breathing modal when closed
            $('#tindakanKeperawatanBreathingModal').on('hidden.bs.modal', function() {
                const modal = $(this);
                if (breathingTindakanState.length === 0) {
                    modal.find('.form-check-input').prop('checked', false);
                }
            });

            // Form submission handler
            $('#asesmenForm').on('submit', function(e) {
                if (breathingTindakanState.length > 0) {
                    const breathingInput = $('input[name="breathing_tindakan"]');
                    if (!breathingInput.length) {
                        $(this).append(`<input type="hidden" name="breathing_tindakan" value='${JSON.stringify(breathingTindakanState)}'>`);
                    }
                }
            });

            // Initialize on page load
            initializeBreathingData();
        });

        // 3. Status Circulation
        $(document).ready(function() {
            // Initialize state
            let circulationState = [];

            // Handle modal show
            $('.btn-tindakan-circulation').click(function() {
                let target = $(this).data('bs-target');
                $(target).modal('show');
            });

            // Update circulation list
            function updateCirculation(dataArr, append = false) {
                const listEl = $('#selectedTindakanList-circulation');
                let currentItems = [];

                if (append) {
                    currentItems = listEl.find('.circulation-item span')
                        .map(function() {
                            return $(this).text().trim();
                        }).get();
                }

                let allItems = [...new Set([...currentItems, ...dataArr])];
                let html = '';

                if (allItems.length > 0) {
                    allItems.forEach(item => {
                        if (item.trim()) {
                            html += `
                                <div class="circulation-item d-flex align-items-center justify-content-between gap-2 bg-light p-2 rounded">
                                    <span>${item}</span>
                                    <button type="button" class="btn btn-sm btn-delete-circulation text-danger p-0">
                                        <i class="ti-close"></i>
                                    </button>
                                </div>`;
                        }
                    });

                    html += `<input type="hidden" name="circulation_tindakan" value='${JSON.stringify(allItems)}'>`;
                }

                listEl.html(html);
                circulationState = allItems;
            }

            // Handle checkbox changes
            $('#tindakanKeperawatanCirculationModal .form-check-input').change(function() {
                let modal = $(this).closest('.modal');
                let selected = [];

                modal.find('.form-check-input:checked').each(function() {
                    selected.push($(this).val());
                });

                updateCirculation(selected, false);
            });

            // Save from modal
            $('.btn-save-circulation').click(function() {
                let modal = $(this).closest('.modal');
                modal.modal('hide');
            });

            // Handle item removal
            $(document).on('click', '.btn-delete-circulation', function() {
                const item = $(this).closest('.circulation-item');
                const text = item.find('span').text().trim();

                // Uncheck the corresponding checkbox
                $(`#tindakanKeperawatanCirculationModal .form-check-input[value="${text}"]`).prop('checked', false);

                // Update state and display
                circulationState = circulationState.filter(t => t !== text);
                updateCirculation(circulationState, false);
            });

            // Initialize existing data
            function initializeCirculation() {
                const existing = $('#existingTindakan-circulation').val();

                if (existing) {
                    try {
                        const parsed = JSON.parse(existing);
                        if (Array.isArray(parsed)) {
                            circulationState = parsed;
                            updateCirculation(parsed, false);

                            parsed.forEach(item => {
                                const checkbox = $(`#tindakanKeperawatanCirculationModal .form-check-input[value="${item}"]`);
                                if (checkbox.length) {
                                    checkbox.prop('checked', true);
                                }
                            });
                        }
                    } catch (error) {
                        console.error('Error parsing circulation data:', error);
                    }
                }
            }

            // Reset modal when closed
            $('#tindakanKeperawatanCirculationModal').on('hidden.bs.modal', function() {
                const modal = $(this);
                if (circulationState.length === 0) {
                    modal.find('.form-check-input').prop('checked', false);
                }
            });

            // Handle form submission
            $('#asesmenForm').on('submit', function(e) {
                if (circulationState.length > 0) {
                    const input = $('input[name="circulation_tindakan"]');
                    if (!input.length) {
                        $(this).append(`<input type="hidden" name="circulation_tindakan" value='${JSON.stringify(circulationState)}'>`);
                    }
                }
            });

            // Initialize on page load
            initializeCirculation();
        });

        // 4. Status Disability
        $(document).ready(function() {
            // Initialize state
            let disabilityState = [];

            // Handle modal show
            $('.btn-tindakan-disability').click(function() {
                let target = $(this).data('bs-target');
                $(target).modal('show');
            });

            // Update disability list
            function updateDisability(dataArr, append = false) {
                const listEl = $('#selectedTindakanList-disability');
                let currentItems = [];

                if (append) {
                    currentItems = listEl.find('.disability-item span')
                        .map(function() {
                            return $(this).text().trim();
                        }).get();
                }

                let allItems = [...new Set([...currentItems, ...dataArr])];
                let html = '';

                if (allItems.length > 0) {
                    allItems.forEach(item => {
                        if (item.trim()) {
                            html += `
                                <div class="disability-item d-flex align-items-center justify-content-between gap-2 bg-light p-2 rounded">
                                    <span>${item}</span>
                                    <button type="button" class="btn btn-sm btn-delete-disability text-danger p-0">
                                        <i class="ti-close"></i>
                                    </button>
                                </div>`;
                        }
                    });

                    html += `<input type="hidden" name="disability_tindakan" value='${JSON.stringify(allItems)}'>`;
                }

                listEl.html(html);
                disabilityState = allItems;
            }

            // Handle checkbox changes
            $('#tindakanKeperawatanDisabilityModal .form-check-input').change(function() {
                let modal = $(this).closest('.modal');
                let selected = [];

                modal.find('.form-check-input:checked').each(function() {
                    selected.push($(this).val());
                });

                updateDisability(selected, false);
            });

            // Save from modal
            $('.btn-save-disability').click(function() {
                let modal = $(this).closest('.modal');
                modal.modal('hide');
            });

            // Handle item removal
            $(document).on('click', '.btn-delete-disability', function() {
                const item = $(this).closest('.disability-item');
                const text = item.find('span').text().trim();

                // Uncheck the corresponding checkbox
                $(`#tindakanKeperawatanDisabilityModal .form-check-input[value="${text}"]`).prop('checked', false);

                // Update state and display
                disabilityState = disabilityState.filter(t => t !== text);
                updateDisability(disabilityState, false);
            });

            // Initialize existing data
            function initializeDisability() {
                const existing = $('#existingTindakan-disability').val();

                if (existing) {
                    try {
                        const parsed = JSON.parse(existing);
                        if (Array.isArray(parsed)) {
                            disabilityState = parsed;
                            updateDisability(parsed, false);

                            parsed.forEach(item => {
                                const checkbox = $(`#tindakanKeperawatanDisabilityModal .form-check-input[value="${item}"]`);
                                if (checkbox.length) {
                                    checkbox.prop('checked', true);
                                }
                            });
                        }
                    } catch (error) {
                        console.error('Error parsing disability data:', error);
                    }
                }
            }

            // Reset modal when closed
            $('#tindakanKeperawatanDisabilityModal').on('hidden.bs.modal', function() {
                const modal = $(this);
                if (disabilityState.length === 0) {
                    modal.find('.form-check-input').prop('checked', false);
                }
            });

            // Handle form submission
            $('#asesmenForm').on('submit', function(e) {
                if (disabilityState.length > 0) {
                    const input = $('input[name="disability_tindakan"]');
                    if (!input.length) {
                        $(this).append(`<input type="hidden" name="disability_tindakan" value='${JSON.stringify(disabilityState)}'>`);
                    }
                }
            });

            // Initialize on page load
            initializeDisability();
        });

        // 5. Status Exposure
        $(document).ready(function() {
            // Initialize state
            let exposureState = [];

            // Handle modal show
            $('.btn-tindakan-exposure').click(function() {
                let target = $(this).data('bs-target');
                $(target).modal('show');
            });

            // Update exposure list
            function updateExposure(dataArr, append = false) {
                const listEl = $('#selectedTindakanList-exposure');
                let currentItems = [];

                if (append) {
                    currentItems = listEl.find('.exposure-item span')
                        .map(function() {
                            return $(this).text().trim();
                        }).get();
                }

                let allItems = [...new Set([...currentItems, ...dataArr])];
                let html = '';

                if (allItems.length > 0) {
                    allItems.forEach(item => {
                        if (item.trim()) {
                            html += `
                                <div class="exposure-item d-flex align-items-center justify-content-between gap-2 bg-light p-2 rounded">
                                    <span>${item}</span>
                                    <button type="button" class="btn btn-sm btn-delete-exposure text-danger p-0">
                                        <i class="ti-close"></i>
                                    </button>
                                </div>`;
                        }
                    });

                    html += `<input type="hidden" name="exposure_tindakan" value='${JSON.stringify(allItems)}'>`;
                }

                listEl.html(html);
                exposureState = allItems;
            }

            // Handle checkbox changes
            $('#tindakanKeperawatanExposureModal .form-check-input').change(function() {
                let modal = $(this).closest('.modal');
                let selected = [];

                modal.find('.form-check-input:checked').each(function() {
                    selected.push($(this).val());
                });

                updateExposure(selected, false);
            });

            // Save from modal
            $('.btn-save-exposure').click(function() {
                let modal = $(this).closest('.modal');
                modal.modal('hide');
            });

            // Handle item removal
            $(document).on('click', '.btn-delete-exposure', function() {
                const item = $(this).closest('.exposure-item');
                const text = item.find('span').text().trim();

                // Uncheck the corresponding checkbox
                $(`#tindakanKeperawatanExposureModal .form-check-input[value="${text}"]`).prop('checked', false);

                // Update state and display
                exposureState = exposureState.filter(t => t !== text);
                updateExposure(exposureState, false);
            });

            // Initialize existing data
            function initializeExposure() {
                const existing = $('#existingTindakan-exposure').val();

                if (existing) {
                    try {
                        const parsed = JSON.parse(existing);
                        if (Array.isArray(parsed)) {
                            exposureState = parsed;
                            updateExposure(parsed, false);

                            parsed.forEach(item => {
                                const checkbox = $(`#tindakanKeperawatanExposureModal .form-check-input[value="${item}"]`);
                                if (checkbox.length) {
                                    checkbox.prop('checked', true);
                                }
                            });
                        }
                    } catch (error) {
                        console.error('Error parsing exposure data:', error);
                    }
                }
            }

            // Reset modal when closed
            $('#tindakanKeperawatanExposureModal').on('hidden.bs.modal', function() {
                const modal = $(this);
                if (exposureState.length === 0) {
                    modal.find('.form-check-input').prop('checked', false);
                }
            });

            // Handle form submission
            $('#asesmenForm').on('submit', function(e) {
                if (exposureState.length > 0) {
                    const input = $('input[name="exposure_tindakan"]');
                    if (!input.length) {
                        $(this).append(`<input type="hidden" name="exposure_tindakan" value='${JSON.stringify(exposureState)}'>`);
                    }
                }
            });

            // Initialize on page load
            initializeExposure();
        });

        // 7. Risiko Jatuh Tindakan
        $(document).ready(function() {
            // Initialize state
            let risikoJatuhState = [];

            // Handle modal show
            $('.btn-tindakan-keperawatan[data-section="risikojatuh"]').click(function() {
                let target = $(this).data('bs-target');
                $(target).modal('show');
            });

            // Update risiko jatuh list
            function updateRisikoJatuh(dataArr, append = false) {
                const listEl = $('#selectedTindakanList-risikojatuh');
                let currentItems = [];

                if (append) {
                    currentItems = listEl.find('.risikojatuh-item span')
                        .map(function() {
                            return $(this).text().trim();
                        }).get();
                }

                let allItems = [...new Set([...currentItems, ...dataArr])];
                let html = '';

                if (allItems.length > 0) {
                    allItems.forEach(item => {
                        if (item.trim()) {
                            html += `
                                <div class="risikojatuh-item d-flex align-items-center justify-content-between gap-2 bg-light p-2 rounded">
                                    <span>${item}</span>
                                    <button type="button" class="btn btn-sm btn-delete-risikojatuh text-danger p-0">
                                        <i class="ti-close"></i>
                                    </button>
                                </div>`;
                        }
                    });

                    html += `<input type="hidden" name="risik_jatuh_tindakan" value='${JSON.stringify(allItems)}'>`;
                }

                listEl.html(html);
                risikoJatuhState = allItems;
            }

            // Handle checkbox changes
            $('#tindakanKeperawatanRisikoJatuhModal .form-check-input').change(function() {
                let modal = $(this).closest('.modal');
                let selected = [];

                // Special handling for "Tidak ada intervensi"
                if ($(this).val() === "Tidak ada intervensi" && $(this).is(':checked')) {
                    // Uncheck all other checkboxes
                    modal.find('.form-check-input').not(this).prop('checked', false);
                    selected = ["Tidak ada intervensi"];
                } else if ($(this).is(':checked')) {
                    // If checking any other option, uncheck "Tidak ada intervensi"
                    modal.find('#intervensiRisikoJatuh4').prop('checked', false);

                    // Collect all checked items
                    modal.find('.form-check-input:checked').each(function() {
                        selected.push($(this).val());
                    });
                } else {
                    // Normal collection of checked items
                    modal.find('.form-check-input:checked').each(function() {
                        selected.push($(this).val());
                    });
                }

                updateRisikoJatuh(selected, false);
            });

            // Save from modal
            $('.btn-save-tindakan-keperawatan[data-section="risikojatuh"]').click(function() {
                let modal = $(this).closest('.modal');
                modal.modal('hide');
            });

            // Handle item removal
            $(document).on('click', '.btn-delete-risikojatuh', function() {
                const item = $(this).closest('.risikojatuh-item');
                const text = item.find('span').text().trim();

                // Uncheck the corresponding checkbox
                $(`#tindakanKeperawatanRisikoJatuhModal .form-check-input[value="${text}"]`).prop('checked', false);

                // Update state and display
                risikoJatuhState = risikoJatuhState.filter(t => t !== text);
                updateRisikoJatuh(risikoJatuhState, false);
            });

            // Initialize existing data
            function initializeRisikoJatuh() {
                const existing = $('#existingTindakan-risikojatuh').val();

                if (existing) {
                    try {
                        const parsed = JSON.parse(existing);
                        if (Array.isArray(parsed)) {
                            risikoJatuhState = parsed;
                            updateRisikoJatuh(parsed, false);

                            parsed.forEach(item => {
                                const checkbox = $(`#tindakanKeperawatanRisikoJatuhModal .form-check-input[value="${item}"]`);
                                if (checkbox.length) {
                                    checkbox.prop('checked', true);
                                }
                            });
                        }
                    } catch (error) {
                        console.error('Error parsing risiko jatuh data:', error);
                    }
                }
            }

            // Reset modal when closed
            $('#tindakanKeperawatanRisikoJatuhModal').on('hidden.bs.modal', function() {
                const modal = $(this);
                if (risikoJatuhState.length === 0) {
                    modal.find('.form-check-input').prop('checked', false);
                }
            });

            // Handle form submission
            $('#asesmenForm').on('submit', function(e) {
                if (risikoJatuhState.length > 0) {
                    const input = $('input[name="risik_jatuh_tindakan"]');
                    if (!input.length) {
                        $(this).append(`<input type="hidden" name="risik_jatuh_tindakan" value='${JSON.stringify(risikoJatuhState)}'>`);
                    }
                }
            });

            // Initialize on page load
            initializeRisikoJatuh();
        });

        // 7. Resiko Jantung
        // Definisi forms untuk skor dan tipe
        const forms = {
            umum: {
                threshold: 1,
                type: 'boolean'
            },
            morse: {
                low: 0,
                medium: 25,
                high: 45,
                type: 'score'
            },
            ontario: {
                low: 0,
                medium: 4,
                high: 9,
                type: 'score'
            },
            humpty: {
                low: 0,
                high: 12,
                type: 'score'
            }
        };

        // Fungsi untuk menampilkan form yang dipilih
        function showForm(formType) {
            // Sembunyikan semua form terlebih dahulu
            document.querySelectorAll('.risk-form').forEach(form => {
                form.style.display = 'none';
            });

            // Handle untuk opsi "Lainnya"
            if (formType === '5') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Pasien tidak dapat dinilai status resiko jatuh',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                    showCancelButton: false,
                    allowOutsideClick: false,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        popup: 'animated fadeInDown faster'
                    },
                    backdrop: `
        rgba(244, 244, 244, 0.7)
    `
                });
                document.getElementById('skala_lainnya').value = 'resiko jatuh lainnya';
                return;
            }

            // Mapping nilai select ke id form
            const formMapping = {
                '1': 'skala_umumForm',
                '2': 'skala_morseForm',
                '3': 'skala_humptyForm',
                '4': 'skala_ontarioForm'
            };

            // Tampilkan form yang dipilih
            if (formType && formMapping[formType]) {
                const selectedForm = document.getElementById(formMapping[formType]);
                if (selectedForm) {
                    selectedForm.style.display = 'block';
                    resetForm(selectedForm);
                }
            }
        }

        // Reset form saat berganti
        function resetForm(form) {
            form.querySelectorAll('select').forEach(select => select.value = '');
            const formType = form.id.replace('skala_', '').replace('Form', '');
            const conclusionDiv = form.querySelector('.conclusion');
            const defaultConclusion = formType === 'umum' ? 'Tidak berisiko jatuh' : 'Risiko Rendah';

            // Reset kesimpulan ke default
            if (conclusionDiv) {
                conclusionDiv.className = 'conclusion bg-success';
                conclusionDiv.querySelector('p span').textContent = defaultConclusion;

                // Reset hidden input value
                const hiddenInput = conclusionDiv.querySelector('input[type="hidden"]');
                if (hiddenInput) {
                    hiddenInput.value = defaultConclusion;
                }
            }
        }

        // Update kesimpulan berdasarkan pilihan
        function updateConclusion(formType) {
            const form = document.getElementById('skala_' + formType + 'Form');
            const selects = form.querySelectorAll('select');
            let score = 0;
            let hasYes = false;

            // Hitung skor
            selects.forEach(select => {
                if (select.value === '1') {
                    hasYes = true;
                }
                score += parseInt(select.value) || 0;
            });

            // Dapatkan div kesimpulan dari form yang aktif
            const conclusionDiv = form.querySelector('.conclusion');
            const conclusionSpan = conclusionDiv.querySelector('#kesimpulanTextForm');
            const conclusionInput = conclusionDiv.querySelector('input[type="hidden"]');
            let conclusion = '';
            let bgClass = '';

            // Tentukan kesimpulan berdasarkan tipe form
            switch (formType) {
                case 'umum':
                    if (hasYes) {
                        conclusion = 'Berisiko jatuh';
                        bgClass = 'bg-danger';
                    } else {
                        conclusion = 'Tidak berisiko jatuh';
                        bgClass = 'bg-success';
                    }
                    // Update hidden input untuk form umum
                    if (conclusionInput) {
                        conclusionInput.value = conclusion;
                    }
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
                    conclusion += ' (Skor: ' + score + ')';
                    // Update hidden input untuk form morse
                    document.getElementById('risiko_jatuh_morse_kesimpulan').value = conclusion;
                    break;

                case 'humpty':
                    if (score >= 12) {
                        conclusion = 'Risiko Tinggi';
                        bgClass = 'bg-danger';
                    } else {
                        conclusion = 'Risiko Rendah';
                        bgClass = 'bg-success';
                    }
                    conclusion += ' (Skor: ' + score + ')';
                    document.getElementById('risiko_jatuh_pediatrik_kesimpulan').value = conclusion;
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
                    conclusion += ' (Skor: ' + score + ')';
                    document.getElementById('risiko_jatuh_lansia_kesimpulan').value = conclusion;
                    break;
            }

            // Update tampilan kesimpulan
            if (conclusionDiv) {
                conclusionDiv.className = 'conclusion ' + bgClass;
                conclusionSpan.textContent = conclusion;
            }
        }

        // 11. Status Gizi
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi elemen
            const nutritionSelect = document.getElementById('nutritionAssessment');
            const allForms = document.querySelectorAll('.assessment-form');

            // Fungsi inisialisasi untuk mode edit
            function initializeEditMode() {
                const selectedValue = nutritionSelect.value;
                if (selectedValue) {
                    // Tampilkan form yang sesuai
                    showSelectedForm(selectedValue);
                    // Hitung nilai awal berdasarkan data yang ada
                    calculateInitialValues(selectedValue);
                }
            }

            // Fungsi untuk menghitung nilai awal saat edit
            function calculateInitialValues(formType) {
                switch(formType) {
                    case '1':
                        calculateMSTScore();
                        break;
                    case '2':
                        calculateMNAScore();
                        initializeBMICalculation(true);
                        break;
                    case '3':
                        calculateStrongKidsScore();
                        break;
                }
            }

            // Event listener untuk perubahan select
            nutritionSelect.addEventListener('change', function() {
                const selectedValue = this.value;
                showSelectedForm(selectedValue);

                // Reset dan sembunyikan semua alert kesimpulan
                document.querySelectorAll('.risk-indicators .alert').forEach(alert => {
                    alert.style.display = 'none';
                });

                // Kalkulasi ulang nilai sesuai form yang dipilih
                if (selectedValue !== '5') {
                    calculateInitialValues(selectedValue);
                }
            });

            // Fungsi untuk menampilkan form yang dipilih
            function showSelectedForm(selectedValue) {
                // Sembunyikan semua form
                allForms.forEach(form => {
                    form.style.display = 'none';
                });

                if (selectedValue === '5') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Pasien tidak dapat dinilai status gizinya',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                    return;
                }

                // Mapping ID form sesuai value
                const formMapping = {
                    '1': 'mst',
                    '2': 'mna',
                    '3': 'strong-kids'
                };

                const formId = formMapping[selectedValue];
                if (formId) {
                    const selectedForm = document.getElementById(formId);
                    if (selectedForm) {
                        selectedForm.style.display = 'block';
                        initializeFormListeners(formId);
                    }
                }
            }

            // Inisialisasi listener untuk setiap form
            function initializeFormListeners(formId) {
                const form = document.getElementById(formId);
                if (!form) return;

                // Tambahkan event listener untuk semua select dalam form
                const selects = form.querySelectorAll('select');
                selects.forEach(select => {
                    select.addEventListener('change', () => {
                        switch(formId) {
                            case 'mst':
                                calculateMSTScore();
                                break;
                            case 'mna':
                                calculateMNAScore();
                                break;
                            case 'strong-kids':
                                calculateStrongKidsScore();
                                break;
                        }
                    });
                });

                // Khusus untuk MNA, initialize BMI calculation
                if (formId === 'mna') {
                    initializeBMICalculation();
                }
            }

            // Fungsi BMI yang diperbaiki untuk edit
            function initializeBMICalculation(isEdit = false) {
                const weightInput = document.getElementById('mnaWeight');
                const heightInput = document.getElementById('mnaHeight');
                const bmiInput = document.getElementById('mnaBMI');

                function calculateBMI() {
                    const weight = parseFloat(weightInput.value || 0);
                    const height = parseFloat(heightInput.value || 0);

                    if (weight > 0 && height > 0) {
                        const heightInMeters = height / 100;
                        const bmi = weight / (heightInMeters * heightInMeters);
                        bmiInput.value = bmi.toFixed(2);
                        // Trigger MNA calculation after BMI update
                        calculateMNAScore();
                    }
                }

                if (weightInput && heightInput) {
                    weightInput.addEventListener('input', calculateBMI);
                    heightInput.addEventListener('input', calculateBMI);

                    if (isEdit && weightInput.value && heightInput.value) {
                        calculateBMI();
                    }
                }
            }

            // Fungsi perhitungan MST dengan dukungan edit
            function calculateMSTScore() {
                const form = document.getElementById('mst');
                if (!form) return;

                const selects = form.querySelectorAll('select');
                let total = 0;

                // Hitung total dari select yang sudah ada nilainya
                selects.forEach(select => {
                    if (select.value) {
                        total += parseInt(select.value);
                    }
                });

                // Update kesimpulan
                const kesimpulan = total <= 1 ? 'Tidak berisiko malnutrisi' : 'Berisiko malnutrisi';
                const kesimpulanInput = document.getElementById('gizi_mst_kesimpulan');

                if (kesimpulanInput) {
                    kesimpulanInput.value = kesimpulan;
                }

                // Update tampilan alert
                const conclusions = form.querySelectorAll('.alert');
                conclusions.forEach(alert => {
                    if (alert.classList.contains('alert-success')) {
                        alert.style.display = total <= 1 ? 'block' : 'none';
                    }
                    if (alert.classList.contains('alert-warning')) {
                        alert.style.display = total >= 2 ? 'block' : 'none';
                    }
                });
            }

            // Fungsi perhitungan MNA dengan dukungan edit
            function calculateMNAScore() {
                const form = document.getElementById('mna');
                if (!form) return;

                const selects = form.querySelectorAll('select[name^="gizi_mna_"]');
                let total = 0;

                // Hitung total dari select yang sudah ada nilainya
                selects.forEach(select => {
                    if (select.value) {
                        total += parseInt(select.value);
                    }
                });

                // Update kesimpulan
                const kesimpulan = total >= 12 ? '≥ 12 Tidak Beresiko Malnutrisi' : '≤ 11 Beresiko Malnutrisi';
                const kesimpulanInput = document.getElementById('gizi_mna_kesimpulan');
                const conclusionDiv = document.getElementById('mnaConclusion');

                if (kesimpulanInput) {
                    kesimpulanInput.value = kesimpulan;
                }

                if (conclusionDiv) {
                    const successAlert = conclusionDiv.querySelector('.alert-success');
                    const warningAlert = conclusionDiv.querySelector('.alert-warning');

                    if (successAlert && warningAlert) {
                        successAlert.style.display = total >= 12 ? 'block' : 'none';
                        warningAlert.style.display = total < 12 ? 'block' : 'none';
                    }
                }
            }

            // Fungsi perhitungan Strong Kids
            function calculateStrongKidsScore() {
                const form = document.getElementById('strong-kids');
                if (!form) return;

                const selects = form.querySelectorAll('select');
                let total = 0;

                selects.forEach(select => {
                    if (select.value) {
                        total += parseInt(select.value);
                    }
                });

                const conclusionDiv = document.getElementById('strongKidsConclusion');
                const kesimpulanInput = document.getElementById('gizi_strong_kesimpulan');

                let kesimpulan = '';
                if (total === 0) {
                    kesimpulan = 'Beresiko rendah';
                } else if (total >= 1 && total <= 3) {
                    kesimpulan = 'Beresiko sedang';
                } else {
                    kesimpulan = 'Beresiko Tinggi';
                }

                if (kesimpulanInput) {
                    kesimpulanInput.value = kesimpulan;
                }

                if (conclusionDiv) {
                    const successAlert = conclusionDiv.querySelector('.alert-success');
                    const warningAlert = conclusionDiv.querySelector('.alert-warning');
                    const dangerAlert = conclusionDiv.querySelector('.alert-danger');

                    if (successAlert && warningAlert && dangerAlert) {
                        successAlert.style.display = total === 0 ? 'block' : 'none';
                        warningAlert.style.display = (total >= 1 && total <= 3) ? 'block' : 'none';
                        dangerAlert.style.display = total >= 4 ? 'block' : 'none';
                    }
                }
            }

            // Inisialisasi saat halaman dimuat
            initializeEditMode();

            // Tambahkan event listeners untuk semua input/select
            document.querySelectorAll('select, input').forEach(element => {
                element.addEventListener('change', function() {
                    const formType = nutritionSelect.value;
                    if (formType) {
                        calculateInitialValues(formType);
                    }
                });
            });
        });

        // 14. Discharge Planning
        document.addEventListener('DOMContentLoaded', function() {
            // Get DOM elements
            const selects = document.querySelectorAll('.discharge-select');
            const kesimpulanKhusus = document.getElementById('kesimpulan_khusus');
            const kesimpulanTidakKhusus = document.getElementById('kesimpulan_tidak_khusus');
            const kesimpulanValue = document.getElementById('kesimpulan_value');
            const diagnosisMedis = document.getElementById('diagnosis_medis');

            // Function to update conclusion
            function updateKesimpulan() {
                // Reset display first
                kesimpulanKhusus.style.display = 'none';
                kesimpulanTidakKhusus.style.display = 'none';
                kesimpulanValue.value = '';

                // Hitung berapa banyak field yang diisi dengan 'ya'
                const jumlahYa = Array.from(selects)
                    .filter(select => select.value === 'ya')
                    .length;

                if (jumlahYa > 0) {
                    kesimpulanKhusus.style.display = 'block';
                    kesimpulanValue.value = 'butuh_rencana_khusus';
                } else {
                    kesimpulanTidakKhusus.style.display = 'block';
                    kesimpulanValue.value = 'tidak_butuh_rencana_khusus';
                }
            }

            // Event Listeners
            diagnosisMedis.addEventListener('input', function() {
                // Tidak perlu validasi wajib
            });

            selects.forEach(select => {
                select.addEventListener('change', function() {
                    updateKesimpulan();
                });
            });

            // Initial setup for edit mode
            function setupInitialState() {
                // Cek apakah ada nilai yang sudah dipilih
                const hasExistingValues = Array.from(selects).some(select => select.value === 'ya');
                if (hasExistingValues) {
                    updateKesimpulan();
                }
            }

            // Form submission handler
            const form = diagnosisMedis.closest('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Hapus validasi paksa
                    // Biarkan form submit tanpa syarat
                });
            }

            // Run initial setup
            setupInitialState();
        });

        // 15.Masalah Keperawatan
        document.addEventListener('DOMContentLoaded', function() {
            // Mendapatkan data dari database dan membuat array options yang siap digunakan


            // Set untuk menyimpan unique values
            const masalahSet = new Set();
            const implementasiSet = new Set();

            // Mengumpulkan semua nilai unik
            // dbData.forEach(item => {
            //     try {
            //         // Parse masalah_keperawatan
            //         if (item.masalah_keperawatan) {
            //             const masalahArray = JSON.parse(item.masalah_keperawatan);
            //             masalahArray.forEach(text => masalahSet.add(text));
            //         }

            //         // Parse implementasi
            //         if (item.implementasi) {
            //             const implementasiArray = JSON.parse(item.implementasi);
            //             implementasiArray.forEach(text => implementasiSet.add(text));
            //         }
            //     } catch (e) {
            //         console.error('Error parsing JSON:', e);
            //     }
            // });

            // Konversi Set ke array options
            const masalahOptions = Array.from(masalahSet).map(text => ({
                id: text.toLowerCase().replace(/\s+/g, '_'),
                text: text
            }));

            const implementasiOptions = Array.from(implementasiSet).map(text => ({
                id: text.toLowerCase().replace(/\s+/g, '_'),
                text: text
            }));

            console.log('Masalah Options:', masalahOptions); // Debug
            console.log('Implementasi Options:', implementasiOptions); // Debug

            function initializeAutocomplete(inputId, suggestionsId, listId, valueId, options) {
                const input = document.getElementById(inputId);
                const suggestionsList = document.getElementById(suggestionsId);
                const selectedList = document.getElementById(listId);
                const valueInput = document.getElementById(valueId);
                const selectedItems = new Map();

                // Tambahkan CSS untuk memastikan suggestions list terlihat
                // suggestionsList.style.position = 'absolute';
                // suggestionsList.style.backgroundColor = 'white';
                // suggestionsList.style.border = '1px solid #ddd';
                // suggestionsList.style.maxHeight = '200px';
                // suggestionsList.style.overflowY = 'auto';
                // suggestionsList.style.width = '100%';
                // suggestionsList.style.zIndex = '1000';

                function updateHiddenInput() {
                    const items = Array.from(selectedItems.values())
                        .map(item => item.text)
                        .map(text => text.replace('Tambah "', '').replace('"', ''));
                    valueInput.value = JSON.stringify(items);
                }

                // Modifikasi fungsi showSuggestions untuk menangani item baru
                function showSuggestions(suggestions) {
                    suggestionsList.innerHTML = '';
                    if (suggestions.length > 0) {
                        suggestions.forEach(item => {
                            const div = document.createElement('div');
                            div.className = 'suggestion-item';
                            div.style.padding = '8px 12px';
                            div.style.cursor = 'pointer';
                            div.style.borderBottom = '1px solid #eee';

                            // Jika item baru, tambahkan style khusus
                            if (item.isNew) {
                                div.style.color = '#0066cc';
                                div.innerHTML =
                                    `<i class="fas fa-plus"></i> ${item.text}`; // Jika menggunakan Font Awesome
                                // Atau tanpa icon:
                                // div.textContent = `+ ${item.text}`;
                            } else {
                                div.textContent = item.text;
                            }

                            div.onmouseover = () => div.style.backgroundColor = '#f0f0f0';
                            div.onmouseout = () => div.style.backgroundColor = 'white';
                            div.onclick = () => {
                                // Jika item baru, hapus prefix "Tambah"
                                if (item.isNew) {
                                    const newText = item.text.replace('Tambah "', '').replace('"', '');
                                    addItem(item.id, newText);
                                } else {
                                    addItem(item.id, item.text);
                                }
                            };
                            suggestionsList.appendChild(div);
                        });
                        suggestionsList.style.display = 'block';
                    } else {
                        suggestionsList.style.display = 'none';
                    }
                }

                function addItem(id, text) {
                    if (!selectedItems.has(id)) {
                        const cleanText = text.startsWith('Tambah "') ?
                            text.replace('Tambah "', '').replace('"', '') : text;

                        selectedItems.set(id, {
                            id,
                            text: cleanText
                        });
                        const itemDiv = document.createElement('div');
                        itemDiv.className = 'selected-item';
                        itemDiv.style.backgroundColor = '#e9ecef';
                        itemDiv.style.padding = '4px 8px';
                        itemDiv.style.borderRadius = '4px';
                        itemDiv.style.marginRight = '8px';
                        itemDiv.style.marginBottom = '8px';
                        itemDiv.style.display = 'inline-block';
                        itemDiv.innerHTML = `
                    ${cleanText}
                    <button type="button" class="delete-btn" style="margin-left: 8px; color: #red; border: none; background: none; cursor: pointer;" data-id="${id}">×</button>
                `;
                        selectedList.appendChild(itemDiv);
                        updateHiddenInput();
                    }
                    input.value = '';
                    suggestionsList.style.display = 'none';
                }

                // input.addEventListener('input', function() {
                //     const value = this.value.toLowerCase();
                //     console.log('Input value:', value); // Debug
                //     if (value) {
                //         const filtered = options.filter(item =>
                //             item.text.toLowerCase().includes(value)
                //         );

                //         // Menambahkan opsi "Tambah baru" jika input tidak cocok dengan data yang ada
                //         if (filtered.length === 0 && value.trim() !== '') {
                //             filtered.push({
                //                 id: value.replace(/\s+/g, '_'),
                //                 text: `Tambah "${value.trim()}"`,
                //                 isNew: true
                //             });
                //         }

                //         console.log('Filtered suggestions:', filtered); // Debug
                //         showSuggestions(filtered);
                //     } else {
                //         suggestionsList.style.display = 'none';
                //     }
                // });

                // Sisa kode event listener tetap sama...
                // selectedList.addEventListener('click', function(e) {
                //     if (e.target.classList.contains('delete-btn')) {
                //         const id = e.target.dataset.id;
                //         selectedItems.delete(id);
                //         e.target.parentElement.remove();
                //         updateHiddenInput();
                //     }
                // });

                // document.addEventListener('click', function(e) {
                //     if (!input.contains(e.target) && !suggestionsList.contains(e.target)) {
                //         suggestionsList.style.display = 'none';
                //     }
                // });

                // input.removeEventListener('keypress', function(e) {
                //     if (e.key === 'Enter') {
                //         e.preventDefault();
                //         if (this.value) {
                //             const id = this.value.toLowerCase().replace(/\s+/g, '_');
                //             addItem(id, this.value);
                //         }
                //     }
                // });
            }

            // Inisialisasi autocomplete
            initializeAutocomplete('inputMasalah', 'masalahSuggestions', 'selectedMasalahList',
                'masalahKeperawatanValue', masalahOptions);
            initializeAutocomplete('inputImplementasi', 'implementasiSuggestions', 'selectedImplementasiList',
                'implementasiValue', implementasiOptions);
        });

        // 6. Fungsi Skala Nyeri
        $(document).ready(function() {
            initSkalaNyeri();
        });

        // 6. Fungsi Skala Nyeri
        function initSkalaNyeri() {
            const input = $('input[name="skala_nyeri"]');
            const button = $('#skalaNyeriBtn');

            // Trigger saat pertama kali load
            updateButton(parseInt(input.val()) || 0);

            // Event handler untuk input
            input.on('input change', function() {
                let nilai = parseInt($(this).val()) || 0;

                // Batasi nilai antara 0-10
                nilai = Math.min(Math.max(nilai, 0), 10);
                $(this).val(nilai);

                updateButton(nilai);
            });

            // Fungsi untuk update button
            function updateButton(nilai) {
                let buttonClass, textNyeri;

                switch (true) {
                    case nilai === 0:
                        buttonClass = 'btn-success';
                        textNyeri = 'Tidak Nyeri';
                        break;
                    case nilai >= 1 && nilai <= 3:
                        buttonClass = 'btn-success';
                        textNyeri = 'Nyeri Ringan';
                        break;
                    case nilai >= 4 && nilai <= 5:
                        buttonClass = 'btn-warning';
                        textNyeri = 'Nyeri Sedang';
                        break;
                    case nilai >= 6 && nilai <= 7:
                        buttonClass = 'btn-warning';
                        textNyeri = 'Nyeri Berat';
                        break;
                    case nilai >= 8 && nilai <= 9:
                        buttonClass = 'btn-danger';
                        textNyeri = 'Nyeri Sangat Berat';
                        break;
                    case nilai >= 10:
                        buttonClass = 'btn-danger';
                        textNyeri = 'Nyeri Tak Tertahankan';
                        break;
                }

                button
                    .removeClass('btn-success btn-warning btn-danger')
                    .addClass(buttonClass)
                    .text(textNyeri);
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            // Get the buttons and images
            const buttons = document.querySelectorAll('[data-scale]');
            const numericScale = document.getElementById('numericScale');
            const wongBakerScale = document.getElementById('wongBakerScale');

            // Add click event to buttons
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    buttons.forEach(btn => {
                        btn.classList.remove('btn-primary');
                        btn.classList.add('btn-outline-primary');
                    });

                    // Add active class to clicked button
                    this.classList.remove('btn-outline-primary');
                    this.classList.add('btn-primary');

                    // Hide both images first
                    numericScale.style.display = 'none';
                    wongBakerScale.style.display = 'none';

                    // Show the selected image
                    if (this.dataset.scale === 'numeric') {
                        numericScale.style.display = 'block';
                    } else {
                        wongBakerScale.style.display = 'block';
                    }
                });
            });

            // Show numeric scale by default
            buttons[0].click();
        });
    </script>
@endpush
