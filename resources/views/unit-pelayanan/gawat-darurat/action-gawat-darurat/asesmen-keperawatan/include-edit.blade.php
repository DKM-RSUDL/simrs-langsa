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
            // Disable
            $('.diagnosis-row input[type="radio"]').prop('disabled', true);

            // Tindakan
            $('.btn-tindakan-keperawatan').click(function(e) {
                let target = $(this).attr('data-bs-target');
                $(target).modal('show');
            });

            // Save
            $('.btn-save-tindakan-keperawatan').click(function(e) {
                let section = $(this).attr('data-section');
                let modal = $(this).closest('.modal');
                let selectedTindakanArr = [];

                // Collect
                modal.find('.form-check-input:checked').each(function() {
                    selectedTindakanArr.push($(this).val());
                });

                // Update
                updateSelectedTindakan(selectedTindakanArr, section);
                modal.modal('hide');
            });

            // Function to update
            function updateSelectedTindakan(dataArr, tindakanListEl) {
                let elListTindakan = $(`#selectedTindakanList-${tindakanListEl}`);
                let existingTindakan = elListTindakan.find('.selected-item span')
                    .map(function() {
                        return $(this).text().trim();
                    })
                    .get();

                // Combine existing
                let allTindakan = [...new Set([...dataArr, ...existingTindakan])];

                let listHtml = '';
                let jsonArray = [];
                allTindakan.forEach(tindakan => {
                    if (tindakan.trim()) {
                        jsonArray.push(tindakan);
                        listHtml += `
                            <div class="selected-item d-flex align-items-center justify-content-between gap-2 bg-light p-2 rounded">
                                <span>${tindakan}</span>
                                <button type="button" class="btn btn-sm btn-del-tindakan-keperawatan-list text-danger p-0">
                                    <i class="ti-close"></i>
                                </button>
                                <input type="hidden" name="airway_tindakan[]" value='${JSON.stringify(jsonArray)}'>
                            </div>`;
                    }
                });

                elListTindakan.html(listHtml);
            }

            // Remove
            $(document).on('click', '.btn-del-tindakan-keperawatan-list', function() {
                $(this).closest('.selected-item').remove();
            });

            // Initialize
            function initExistingTindakan() {
                let sections = ['airway'];

                sections.forEach(section => {
                    let existingTindakanInput = $(`#existingTindakan-${section}`);
                    let existingTindakanValue = existingTindakanInput.val();

                    if (existingTindakanValue) {
                        try {
                            let tindakanArray = JSON.parse(existingTindakanValue);
                            updateSelectedTindakan(tindakanArray, section);
                        } catch (e) {
                            let tindakanArray = existingTindakanValue.split(',').map(t => t.trim()).filter(
                                t => t);
                            updateSelectedTindakan(tindakanArray, section);
                        }
                    }
                });
            }
            initExistingTindakan();

            // Checkbox Handling
            $('.diagnose-prwt-checkbox').change(function() {
                let diagnosisWrap = $(this).closest('.diagnosis-row');
                let radioInputs = diagnosisWrap.find('input[type="radio"]');

                if ($(this).is(':checked')) {
                    radioInputs.prop('disabled', false);
                    radioInputs.prop('required', false);
                } else {
                    radioInputs.prop('disabled', true);
                    radioInputs.prop('checked', false);
                    radioInputs.prop('required', false);
                }
            });
        });

        // 2. Status Breathing
        $(document).ready(function() {
            const breathingInterventionManager = {
                init: function() {
                    let sections = ['breathing'];

                    sections.forEach(section => {
                        this.initExistingInterventions(section);
                        this.setupEventListeners(section);
                    });

                    $('.diagnosis-row input[type="radio"]').prop('disabled', true);
                },

                // Setup event listeners
                setupEventListeners: function(section) {
                    // Modal trigger
                    $(`.btn-tindakan-keperawatan[data-bs-target="#tindakanKeperawatan${section.charAt(0).toUpperCase() + section.slice(1)}Modal"]`)
                        .on('click', function() {
                            let target = $(this).attr('data-bs-target');
                            $(target).modal('show');
                        });

                    // Save
                    $(`#tindakanKeperawatan${section.charAt(0).toUpperCase() + section.slice(1)}Modal .btn-save-tindakan-keperawatan`)
                        .on('click', function() {
                            let modal = $(this).closest('.modal');
                            let selectedTindakanArr = [];

                            modal.find('.form-check-input:checked').each(function() {
                                selectedTindakanArr.push($(this).val());
                            });

                            // Update
                            breathingInterventionManager.updateSelectedInterventions(
                                selectedTindakanArr, section);
                            modal.modal('hide');
                        });

                    // Remove
                    $(`#selectedTindakanList-${section}`).on('click', '.btn-del-tindakan-keperawatan-list',
                        function() {
                            $(this).closest('.selected-item').remove();
                        });

                    // Diagnosis checkbox
                    $('.diagnose-prwt-checkbox').change(function() {
                        let diagnosisWrap = $(this).closest('.diagnosis-row');
                        let radioInputs = diagnosisWrap.find('input[type="radio"]');

                        if ($(this).is(':checked')) {
                            radioInputs.prop('disabled', false);
                            radioInputs.prop('required', false);
                        } else {
                            radioInputs.prop('disabled', true);
                            radioInputs.prop('checked', false);
                            radioInputs.prop('required', false);
                        }
                    });
                },

                // Initialize existing
                initExistingInterventions: function(section) {
                    let existingTindakanInput = $(`#existingTindakan-${section}`);
                    let existingTindakanValue = existingTindakanInput.val();

                    if (existingTindakanValue) {
                        try {
                            let tindakanArray = JSON.parse(existingTindakanValue);
                            this.updateSelectedInterventions(tindakanArray, section);
                        } catch (e) {
                            let tindakanArray = existingTindakanValue.split(',').map(t => t.trim()).filter(
                                t => t);
                            this.updateSelectedInterventions(tindakanArray, section);
                        }
                    }
                },

                // Update
                updateSelectedInterventions: function(dataArr, tindakanListEl) {
                    let elListTindakan = $(`#selectedTindakanList-${tindakanListEl}`);
                    let existingTindakan = elListTindakan.find('.selected-item span')
                        .map(function() {
                            return $(this).text().trim();
                        })
                        .get();

                    let allTindakan = [...new Set([...dataArr, ...existingTindakan])];

                    let listHtml = '';
                    let jsonArray = [];
                    allTindakan.forEach(tindakan => {
                        if (tindakan.trim()) {
                            jsonArray.push(tindakan);
                            listHtml += `
                                <div class="selected-item d-flex align-items-center justify-content-between gap-2 bg-light p-2 rounded">
                                    <span>${tindakan}</span>
                                    <button type="button" class="btn btn-sm btn-del-tindakan-keperawatan-list text-danger p-0">
                                        <i class="ti-close"></i>
                                    </button>
                                    <input type="hidden" name="${tindakanListEl}_tindakan[]" value='${JSON.stringify(jsonArray)}'>
                                </div>`;
                        }
                    });

                    elListTindakan.html(listHtml);
                }
            };

            // Initialize
            breathingInterventionManager.init();
        });

        // 3. Status Circulation
        $(document).ready(function() {
            const circulationInterventionManager = {
                init: function() {
                    let sections = ['circulation'];

                    sections.forEach(section => {
                        this.initExistingInterventions(section);
                        this.setupEventListeners(section);
                    });

                    $('.diagnosis-row input[type="radio"]').prop('disabled', true);
                },

                // Setup event listeners
                setupEventListeners: function(section) {
                    // Modal
                    $(`.btn-tindakan-keperawatan[data-bs-target="#tindakanKeperawatan${section.charAt(0).toUpperCase() + section.slice(1)}Modal"]`)
                        .on('click', function() {
                            let target = $(this).attr('data-bs-target');
                            $(target).modal('show');
                        });

                    // Save
                    $(`#tindakanKeperawatan${section.charAt(0).toUpperCase() + section.slice(1)}Modal .btn-save-tindakan-keperawatan`)
                        .on('click', function() {
                            let modal = $(this).closest('.modal');
                            let selectedTindakanArr = [];

                            modal.find('.form-check-input:checked').each(function() {
                                selectedTindakanArr.push($(this).val());
                            });

                            // Update
                            circulationInterventionManager.updateSelectedInterventions(
                                selectedTindakanArr, section);
                            modal.modal('hide');
                        });

                    // Remove
                    $(`#selectedTindakanList-${section}`).on('click', '.btn-del-tindakan-keperawatan-list',
                        function() {
                            $(this).closest('.selected-item').remove();
                        });

                    // Diagnosis checkbox handling
                    $('.diagnose-prwt-checkbox').change(function() {
                        let diagnosisWrap = $(this).closest('.diagnosis-row');
                        let radioInputs = diagnosisWrap.find('input[type="radio"]');

                        if ($(this).is(':checked')) {
                            radioInputs.prop('disabled', false);
                            radioInputs.prop('required', false);
                        } else {
                            radioInputs.prop('disabled', true);
                            radioInputs.prop('checked', false);
                            radioInputs.prop('required', false);
                        }
                    });
                },

                // Initialize existing
                initExistingInterventions: function(section) {
                    let existingTindakanInput = $(`#existingTindakan-${section}`);
                    let existingTindakanValue = existingTindakanInput.val();

                    if (existingTindakanValue) {
                        try {
                            let tindakanArray = JSON.parse(existingTindakanValue);
                            this.updateSelectedInterventions(tindakanArray, section);
                        } catch (e) {
                            let tindakanArray = existingTindakanValue.split(',').map(t => t.trim()).filter(
                                t => t);
                            this.updateSelectedInterventions(tindakanArray, section);
                        }
                    }
                },

                // Update selected
                updateSelectedInterventions: function(dataArr, tindakanListEl) {
                    let elListTindakan = $(`#selectedTindakanList-${tindakanListEl}`);
                    let existingTindakan = elListTindakan.find('.selected-item span')
                        .map(function() {
                            return $(this).text().trim();
                        })
                        .get();

                    let allTindakan = [...new Set([...dataArr, ...existingTindakan])];

                    let listHtml = '';
                    let jsonArray = [];
                    allTindakan.forEach(tindakan => {
                        if (tindakan.trim()) {
                            jsonArray.push(tindakan);
                            listHtml += `
                                <div class="selected-item d-flex align-items-center justify-content-between gap-2 bg-light p-2 rounded">
                                    <span>${tindakan}</span>
                                    <button type="button" class="btn btn-sm btn-del-tindakan-keperawatan-list text-danger p-0">
                                        <i class="ti-close"></i>
                                    </button>
                                    <input type="hidden" name="${tindakanListEl}_tindakan[]" value='${JSON.stringify(jsonArray)}'>
                                </div>`;
                        }
                    });

                    elListTindakan.html(listHtml);
                }
            };

            // Initialize
            circulationInterventionManager.init();
        });

        // 4. Status Disability
        $(document).ready(function() {
            const disabilityInterventionManager = {
                init: function() {
                    let sections = ['disability'];

                    sections.forEach(section => {
                        this.initExistingInterventions(section);
                        this.setupEventListeners(section);
                    });

                    $('.diagnosis-row input[type="radio"]').prop('disabled', true);
                },

                // Setup event listeners
                setupEventListeners: function(section) {
                    $(`.btn-tindakan-keperawatan[data-bs-target="#tindakanKeperawatan${section.charAt(0).toUpperCase() + section.slice(1)}Modal"]`)
                        .on('click', function() {
                            let target = $(this).attr('data-bs-target');
                            $(target).modal('show');
                        });

                    // Save
                    $(`#tindakanKeperawatan${section.charAt(0).toUpperCase() + section.slice(1)}Modal .btn-save-tindakan-keperawatan`)
                        .on('click', function() {
                            let modal = $(this).closest('.modal');
                            let selectedTindakanArr = [];

                            modal.find('.form-check-input:checked').each(function() {
                                selectedTindakanArr.push($(this).val());
                            });

                            // Update
                            disabilityInterventionManager.updateSelectedInterventions(
                                selectedTindakanArr, section);
                            modal.modal('hide');
                        });

                    // Remove
                    $(`#selectedTindakanList-${section}`).on('click', '.btn-del-tindakan-keperawatan-list',
                        function() {
                            $(this).closest('.selected-item').remove();
                        });

                    // Diagnosis checkbox
                    $('.diagnose-prwt-checkbox').change(function() {
                        let diagnosisWrap = $(this).closest('.diagnosis-row');
                        let radioInputs = diagnosisWrap.find('input[type="radio"]');

                        if ($(this).is(':checked')) {
                            radioInputs.prop('disabled', false);
                            radioInputs.prop('required', false);
                        } else {
                            radioInputs.prop('disabled', true);
                            radioInputs.prop('checked', false);
                            radioInputs.prop('required', false);
                        }
                    });
                },

                // Initialize
                initExistingInterventions: function(section) {
                    let existingTindakanInput = $(`#existingTindakan-${section}`);
                    let existingTindakanValue = existingTindakanInput.val();

                    if (existingTindakanValue) {
                        try {
                            let tindakanArray = JSON.parse(existingTindakanValue);
                            this.updateSelectedInterventions(tindakanArray, section);
                        } catch (e) {
                            let tindakanArray = existingTindakanValue.split(',').map(t => t.trim()).filter(
                                t => t);
                            this.updateSelectedInterventions(tindakanArray, section);
                        }
                    }
                },

                // Update
                updateSelectedInterventions: function(dataArr, tindakanListEl) {
                    let elListTindakan = $(`#selectedTindakanList-${tindakanListEl}`);
                    let existingTindakan = elListTindakan.find('.selected-item span')
                        .map(function() {
                            return $(this).text().trim();
                        })
                        .get();

                    let allTindakan = [...new Set([...dataArr, ...existingTindakan])];

                    let listHtml = '';
                    let jsonArray = [];
                    allTindakan.forEach(tindakan => {
                        if (tindakan.trim()) {
                            jsonArray.push(tindakan);
                            listHtml += `
                                <div class="selected-item d-flex align-items-center justify-content-between gap-2 bg-light p-2 rounded">
                                    <span>${tindakan}</span>
                                    <button type="button" class="btn btn-sm btn-del-tindakan-keperawatan-list text-danger p-0">
                                        <i class="ti-close"></i>
                                    </button>
                                    <input type="hidden" name="${tindakanListEl}_tindakan_keperawatan[]" value='${JSON.stringify(jsonArray)}'>
                                </div>`;
                        }
                    });

                    elListTindakan.html(listHtml);
                }
            };

            // Initialize
            disabilityInterventionManager.init();
        });

        // 5. Status Exposure
        $(document).ready(function() {
            const exposureInterventionManager = {
                init: function() {
                    let sections = ['exposure'];

                    sections.forEach(section => {
                        this.initExistingInterventions(section);
                        this.setupEventListeners(section);
                    });
                },

                setupEventListeners: function(section) {
                    $(`.btn-tindakan-keperawatan[data-bs-target="#tindakanKeperawatan${section.charAt(0).toUpperCase() + section.slice(1)}Modal"]`)
                        .on('click', function() {
                            let target = $(this).attr('data-bs-target');
                            $(target).modal('show');
                        });

                    $(`#tindakanKeperawatan${section.charAt(0).toUpperCase() + section.slice(1)}Modal .btn-save-tindakan-keperawatan`)
                        .on('click', function() {
                            let modal = $(this).closest('.modal');
                            let selectedTindakanArr = [];

                            modal.find('.form-check-input:checked').each(function() {
                                selectedTindakanArr.push($(this).val());
                            });

                            exposureInterventionManager.updateSelectedInterventions(selectedTindakanArr,
                                section);
                            modal.modal('hide');
                        });

                    $(`#selectedTindakanList-${section}`).on('click', '.btn-del-tindakan-keperawatan-list',
                        function() {
                            $(this).closest('.selected-item').remove();
                        });
                },

                initExistingInterventions: function(section) {
                    let existingTindakanInput = $(`#existingTindakan-${section}`);
                    let existingTindakanValue = existingTindakanInput.val();

                    if (existingTindakanValue) {
                        try {
                            let tindakanArray = JSON.parse(existingTindakanValue);
                            this.updateSelectedInterventions(tindakanArray, section);
                        } catch (e) {
                            let tindakanArray = existingTindakanValue.split(',').map(t => t.trim()).filter(
                                t => t);
                            this.updateSelectedInterventions(tindakanArray, section);
                        }
                    }
                },

                updateSelectedInterventions: function(dataArr, tindakanListEl) {
                    let elListTindakan = $(`#selectedTindakanList-${tindakanListEl}`);
                    let existingTindakan = elListTindakan.find('.selected-item span')
                        .map(function() {
                            return $(this).text().trim();
                        })
                        .get();

                    let allTindakan = [...new Set([...dataArr, ...existingTindakan])];

                    let listHtml = '';
                    let jsonArray = [];
                    allTindakan.forEach(tindakan => {
                        if (tindakan.trim()) {
                            jsonArray.push(tindakan);
                            listHtml += `
                            <div class="selected-item d-flex align-items-center justify-content-between gap-2 bg-light p-2 rounded">
                                <span>${tindakan}</span>
                                <button type="button" class="btn btn-sm btn-del-tindakan-keperawatan-list text-danger p-0">
                                    <i class="ti-close"></i>
                                </button>
                                <input type="hidden" name="${tindakanListEl}_tindakan_keperawatan[]" value='${JSON.stringify(jsonArray)}'>
                            </div>`;
                        }
                    });

                    elListTindakan.html(listHtml);
                }
            };

            exposureInterventionManager.init();
        });

        // 7. Risiko Jatuh Tindakan
        $(document).ready(function() {
        // Fungsi untuk inisialisasi tindakan yang sudah ada
        function initExistingTindakan() {
            let existingTindakanInput = $('#existingTindakan-risikojatuh');
            let existingTindakanValue = existingTindakanInput.val();

            if (existingTindakanValue) {
                try {
                    let tindakanArray = JSON.parse(existingTindakanValue);
                    updateSelectedTindakan(tindakanArray, 'risikojatuh');
                } catch (e) {
                    let tindakanArray = existingTindakanValue.split(',')
                        .map(t => t.trim())
                        .filter(t => t);
                    updateSelectedTindakan(tindakanArray, 'risikojatuh');
                }
            }
        }

        // Event untuk tombol tambah
        $('.btn-tindakan-keperawatan').click(function(e) {
            let target = $(this).attr('data-bs-target');
            $(target).modal('show');
        });

        // Event untuk tombol simpan di modal
        $('.btn-save-tindakan-keperawatan').click(function(e) {
            let section = $(this).attr('data-section');
            let modal = $(this).closest('.modal');
            let selectedTindakanArr = [];

            // Mengumpulkan tindakan yang dipilih
            modal.find('.form-check-input:checked').each(function() {
                selectedTindakanArr.push($(this).val());
            });

            // Update tampilan tindakan
            updateSelectedTindakan(selectedTindakanArr, section);
            modal.modal('hide');
        });

        // Fungsi untuk update tampilan tindakan yang dipilih
        function updateSelectedTindakan(dataArr, tindakanListEl) {
            let elListTindakan = $(`#selectedTindakanList-${tindakanListEl}`);
            let existingTindakan = elListTindakan.find('.selected-item span')
                .map(function() {
                    return $(this).text().trim();
                })
                .get();

            // Gabungkan dengan yang sudah ada
            let allTindakan = [...new Set([...dataArr, ...existingTindakan])];

            let listHtml = '';
            let jsonArray = [];

            allTindakan.forEach(tindakan => {
                if (tindakan.trim()) {
                    jsonArray.push(tindakan);
                    listHtml += `
                        <div class="selected-item d-flex align-items-center justify-content-between gap-2 bg-light p-2 rounded">
                            <span>${tindakan}</span>
                            <button type="button" class="btn btn-sm btn-del-tindakan-keperawatan-list text-danger p-0">
                                <i class="ti-close"></i>
                            </button>
                            <input type="hidden" name="risik_jatuh_tindakan[]" value='${tindakan}'>
                        </div>`;
                }
            });

            elListTindakan.html(listHtml);
        }

        // Event untuk tombol hapus tindakan
        $(document).on('click', '.btn-del-tindakan-keperawatan-list', function() {
            $(this).closest('.selected-item').remove();
        });

        // Inisialisasi saat halaman dimuat
        initExistingTindakan();
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
                        initializeBMICalculation(true); // true untuk mode edit
                        break;
                    case '3':
                        calculateStrongKidsScore();
                        break;
                    case '4':
                        calculateNRSScore();
                        break;
                }
            }

            // Event listener untuk perubahan select
            nutritionSelect.addEventListener('change', function() {
                const selectedValue = this.value;
                showSelectedForm(selectedValue);
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
                    document.getElementById('cannot-assess').value = 'tidak ada status gizi';
                    return;
                }

                // Mapping ID form sesuai value
                const formMapping = {
                    '1': 'mst',
                    '2': 'mna',
                    '3': 'strong-kids',
                    '4': 'nrs'
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
                    }
                }

                if (weightInput && heightInput) {
                    weightInput.addEventListener('input', calculateBMI);
                    heightInput.addEventListener('input', calculateBMI);

                    // Hitung BMI saat edit jika data sudah ada
                    if (isEdit && weightInput.value && heightInput.value) {
                        calculateBMI();
                    }
                }
            }

            // Fungsi perhitungan MST dengan dukungan edit
            function calculateMSTScore() {
                const form = document.getElementById('mst');
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
                    if ((total <= 1 && alert.classList.contains('alert-success')) ||
                        (total >= 2 && alert.classList.contains('alert-warning'))) {
                        alert.style.display = 'block';
                    } else {
                        alert.style.display = 'none';
                    }
                });
            }

            // Fungsi perhitungan MNA dengan dukungan edit
            function calculateMNAScore() {
                const form = document.getElementById('mna');
                const selects = form.querySelectorAll('select[name^="gizi_mna_"]');
                let total = 0;

                // Hitung total dari select yang sudah ada nilainya
                selects.forEach(select => {
                    if (select.value) {
                        total += parseInt(select.value);
                    }
                });

                // Update kesimpulan
                const kesimpulan = total >= 12 ? '≥ 12 Tidak Beresiko' : '≤ 11 Beresiko malnutrisi';
                const kesimpulanInput = document.getElementById('gizi_mna_kesimpulan');

                if (kesimpulanInput) {
                    kesimpulanInput.value = kesimpulan;

                    // Update tampilan kesimpulan
                    const conclusionDiv = document.getElementById('mnaConclusion');
                    if (conclusionDiv) {
                        const alertClass = total >= 12 ? 'alert-success' : 'alert-warning';
                        conclusionDiv.querySelector(`.alert-${alertClass}`).style.display = 'block';
                    }
                }
            }

            // Panggil fungsi inisialisasi untuk mode edit
            initializeEditMode();
        });

        // 14. Discharge Planning
        document.addEventListener('DOMContentLoaded', function() {
            // Get DOM elements
            const selects = document.querySelectorAll('.discharge-select');
            const kesimpulanKhusus = document.getElementById('kesimpulan_khusus');
            const kesimpulanTidakKhusus = document.getElementById('kesimpulan_tidak_khusus');
            const kesimpulanValue = document.getElementById('kesimpulan_value');
            const diagnosisMedis = document.getElementById('diagnosis_medis');

            // Function to validate diagnosis medis
            function validateDiagnosisMedis() {
                const value = diagnosisMedis.value.trim();
                if (value === '') {
                    diagnosisMedis.classList.add('is-invalid');
                    diagnosisMedis.setCustomValidity('Harap isi diagnosis medis');
                    return false;
                } else {
                    diagnosisMedis.classList.remove('is-invalid');
                    diagnosisMedis.setCustomValidity('');
                    return true;
                }
            }

            // Function to update conclusion
            function updateKesimpulan() {
                const semuaTerisi = Array.from(selects).every(select => select.value !== '');

                // Reset display first
                kesimpulanKhusus.style.display = 'none';
                kesimpulanTidakKhusus.style.display = 'none';
                kesimpulanValue.value = '';

                if (semuaTerisi) {
                    const jumlahYa = Array.from(selects).filter(select => select.value === 'ya').length;

                    if (jumlahYa > 0) {
                        kesimpulanKhusus.style.display = 'block';
                        kesimpulanValue.value = 'butuh_rencana_khusus';
                    } else {
                        kesimpulanTidakKhusus.style.display = 'block';
                        kesimpulanValue.value = 'tidak_butuh_rencana_khusus';
                    }
                }
            }

            // Function to validate form
            function validateForm() {
                const diagnosisValid = validateDiagnosisMedis();
                const selectsValid = Array.from(selects).every(select => select.value !== '');
                return diagnosisValid && selectsValid;
            }

            // Event Listeners
            diagnosisMedis.addEventListener('input', function() {
                validateDiagnosisMedis();
                this.classList.toggle('is-invalid', !validateDiagnosisMedis());
            });

            selects.forEach(select => {
                select.addEventListener('change', function() {
                    updateKesimpulan();
                    this.classList.toggle('is-invalid', !this.value);
                });
            });

            // Initial setup for edit mode
            function setupInitialState() {
                // Validate diagnosis medis
                validateDiagnosisMedis();

                // Check existing select values and update conclusion
                const hasExistingValues = Array.from(selects).some(select => select.value !== '');
                if (hasExistingValues) {
                    updateKesimpulan();
                }

                // Add invalid class to empty required selects
                selects.forEach(select => {
                    select.classList.toggle('is-invalid', !select.value);
                });
            }

            // Form submission handler
            const form = diagnosisMedis.closest('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!validateForm()) {
                        e.preventDefault();
                        // Show validation messages
                        validateDiagnosisMedis();
                        selects.forEach(select => {
                            select.classList.toggle('is-invalid', !select.value);
                        });
                    }
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
