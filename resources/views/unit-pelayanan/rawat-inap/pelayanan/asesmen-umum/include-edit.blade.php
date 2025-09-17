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

        /*  */
        .form-check {
            flex: 0 0 25%;
        }

        /*  */
        .risk-form {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px solid #dee2e6;
            border-radius: 15px;
            padding: 2rem;
            margin-top: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .conclusion {
            margin-top: 1.5rem;
            padding: 1.5rem;
            border-radius: 12px;
            border-left: 5px solid;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .section-separator {
            margin: 2rem 0;
            padding: 2rem;
            border: 2px solid #dee2e6;
            border-radius: 15px;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            color: #0d6efd;
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 0.5rem;
            margin-bottom: 2rem;
            font-weight: 700;
        }

        .score-display {
            font-size: 2rem;
            font-weight: bold;
            color: white;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .factor-card {
            background: white;
            border: 1px solid #e3e6f0;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .factor-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
        }

        .factor-title {
            font-weight: 600;
            color: #495057;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .score-badge {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            display: inline-block;
            min-width: 60px;
            text-align: center;
        }

        .total-score-card {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.3);
            margin: 2rem 0;
        }

        .risk-level-cards {
            display: flex;
            gap: 1rem;
            margin: 1.5rem 0;
            flex-wrap: wrap;
        }

        .risk-card {
            flex: 1;
            min-width: 200px;
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .risk-card.active {
            transform: scale(1.05);
            border-color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .risk-low {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .risk-medium {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
        }

        .risk-high {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        .question-card {
            background: white;
            border-left: 4px solid #007bff;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .question-text {
            font-weight: 500;
            margin-bottom: 1rem;
            color: #495057;
        }

        .custom-select {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .custom-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .sub-question-card {
            background: #f8f9fa;
            border-left: 3px solid #6c757d;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            margin-left: 1rem;
        }

        .parameter-section {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            background: white;
        }

        .parameter-title {
            font-weight: 700;
            color: #495057;
            margin-bottom: 1rem;
            font-size: 1.2rem;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 0.5rem;
        }
    </style>
@endpush

@push('js')
    <script>
        // Riwayat Konsumsi
        document.addEventListener('DOMContentLoaded', function () {
            // Handle alkohol/obat radio buttons
            const alkoholRadios = document.querySelectorAll('input[name="alkohol_obat"]');
            const alkoholDetail = document.querySelector('.alkohol-detail');

            alkoholRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === 'ya') {
                        alkoholDetail.style.display = 'block';
                    } else {
                        alkoholDetail.style.display = 'none';
                        // Clear inputs when hidden
                        alkoholDetail.querySelectorAll('input').forEach(input => {
                            input.value = '';
                        });
                    }
                });

                // Trigger initial state for alkohol/obat
                if (radio.checked && radio.value === 'ya') {
                    alkoholDetail.style.display = 'block';
                }
            });

            // Handle merokok radio buttons
            const merokokRadios = document.querySelectorAll('input[name="merokok"]');
            const merokokDetail = document.querySelector('.merokok-detail');

            merokokRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === 'ya') {
                        merokokDetail.style.display = 'block';
                    } else {
                        merokokDetail.style.display = 'none';
                        // Clear inputs when hidden
                        merokokDetail.querySelectorAll('input').forEach(input => {
                            input.value = '';
                        });
                    }
                });

                // Trigger initial state for merokok
                if (radio.checked && radio.value === 'ya') {
                    merokokDetail.style.display = 'block';
                }
            });
        });

        // 5. PENGKAJIAN STATUS NUTRISI
        // Script untuk menghitung total skor otomatis
        document.addEventListener('DOMContentLoaded', function () {
            const radioInputs = document.querySelectorAll('input[type="radio"]');
            const totalSkorInput = document.getElementById('total_skor_nutrisi');
            const totalSkorDisplay = document.getElementById('total_skor_display');

            function calculateTotal() {
                let total = 0;

                // Skor dari penurunan BB
                const bbTurunRadio = document.querySelector('input[name="bb_turun"]:checked');
                if (bbTurunRadio) {
                    total += parseInt(bbTurunRadio.value);
                }

                // Skor dari range penurunan BB
                const bbRangeRadio = document.querySelector('input[name="bb_turun_range"]:checked');
                if (bbRangeRadio) {
                    total += parseInt(bbRangeRadio.value);
                }

                // Skor dari nafsu makan
                const nafsuMakanRadio = document.querySelector('input[name="nafsu_makan"]:checked');
                if (nafsuMakanRadio) {
                    total += parseInt(nafsuMakanRadio.value);
                }

                // Update total score input and display
                totalSkorInput.value = total;
                totalSkorDisplay.textContent = total;

                // Display the result based on the score
                let resultMessage = total >= 2 ? '' : '';
                totalSkorDisplay.textContent += ' ' + resultMessage; // Append result message

                // Highlight jika skor >= 2
                if (total >= 2) {
                    totalSkorDisplay.className = 'display-1 text-danger fw-bold';
                } else {
                    totalSkorDisplay.className = 'display-1 text-primary fw-bold';
                }
            }

            radioInputs.forEach(radio => {
                radio.addEventListener('change', calculateTotal);
            });
        });

        // 6. SKALA NYERI
        $(document).ready(function () {
            initSkalaNyeri();

            // show correct active class for scale buttons on load
            const currentScale = $('#tipeSkalaHidden').val() || 'numeric';
            if (currentScale === 'wong-baker') {
                $('#wongBakerBtn').removeClass('btn-outline-primary').addClass('btn-primary');
                $('#numericBtn').removeClass('btn-primary').addClass('btn-outline-primary');
            } else {
                $('#numericBtn').removeClass('btn-outline-primary').addClass('btn-primary');
                $('#wongBakerBtn').removeClass('btn-primary').addClass('btn-outline-primary');
            }
        });

        function initSkalaNyeri() {
            const input = $('#skalaNyeriInput');
            const button = $('#skalaNyeriBtn');
            const tipeSkalaHidden = $('#tipeSkalaHidden');
            const numericBtn = $('#numericBtn');
            const wongBakerBtn = $('#wongBakerBtn');
            const numericScale = $('#numericScale');
            const wongBakerScale = $('#wongBakerScale');

            const debugNilai = $('#debugNilai');
            const debugTipe = $('#debugTipe');

            const currentScale = tipeSkalaHidden.val();
            if (currentScale === 'wong-baker') {
                showWongBakerScale();
            } else {
                showNumericScale();
            }

            updateDebugInfo();
            updateButton(parseInt(input.val()) || 0);

            input.on('input change', function () {
                let nilai = parseInt($(this).val()) || 0;
                nilai = Math.min(Math.max(nilai, 0), 10);
                $(this).val(nilai);
                updateButton(nilai);
                updateDebugInfo();
            });

            numericBtn.on('click', function () {
                showNumericScale();
                tipeSkalaHidden.val('numeric');
                updateDebugInfo();
            });

            wongBakerBtn.on('click', function () {
                showWongBakerScale();
                tipeSkalaHidden.val('wong-baker');
                updateDebugInfo();
            });

            function showNumericScale() {
                numericBtn.removeClass('btn-outline-primary').addClass('btn-primary');
                wongBakerBtn.removeClass('btn-primary').addClass('btn-outline-primary');
                numericScale.show();
                wongBakerScale.hide();
            }

            function showWongBakerScale() {
                wongBakerBtn.removeClass('btn-outline-primary').addClass('btn-primary');
                numericBtn.removeClass('btn-primary').addClass('btn-outline-primary');
                wongBakerScale.show();
                numericScale.hide();
            }

            function updateButton(nilai) {
                let buttonClass = 'btn-success', textNyeri = 'Tidak Nyeri';
                if (nilai === 0) { buttonClass = 'btn-success'; textNyeri = 'Tidak Nyeri'; }
                else if (nilai >= 1 && nilai <= 3) { buttonClass = 'btn-success'; textNyeri = 'Nyeri Ringan'; }
                else if (nilai >= 4 && nilai <= 5) { buttonClass = 'btn-warning'; textNyeri = 'Nyeri Sedang'; }
                else if (nilai >= 6 && nilai <= 7) { buttonClass = 'btn-warning'; textNyeri = 'Nyeri Berat'; }
                else if (nilai >= 8 && nilai <= 9) { buttonClass = 'btn-danger'; textNyeri = 'Nyeri Sangat Berat'; }
                else if (nilai >= 10) { buttonClass = 'btn-danger'; textNyeri = 'Nyeri Tak Tertahankan'; }

                button.removeClass('btn-success btn-warning btn-danger').addClass(buttonClass).text(textNyeri);
            }

            function updateDebugInfo() {
                debugNilai.text(input.val() || '0');
                debugTipe.text(tipeSkalaHidden.val());
            }

            input.add(tipeSkalaHidden).on('change', function () {
                console.log({ skala_nyeri: input.val(), tipe_skala_nyeri: tipeSkalaHidden.val() });
            });
        }

        // Enable/disable logic for menjalar and 'lainnya' inputs
        $(document).ready(function () {
            // menjalar radios -> controls nyeri_menjalar_lokasi
            $('input[name="nyeri_menjalar"]').on('change', function () {
                const lokasiInput = $('#nyeri_menjalar_lokasi');
                if ($(this).val() === 'Ya' || $(this).val() === 'ya') {
                    lokasiInput.prop('disabled', false).focus();
                } else {
                    lokasiInput.prop('disabled', true).val('');
                }
            });

            // faktor_peringan_lainnya
            $('#faktor_peringan_lainnya').on('change', function () {
                const lainnyaInput = $('#faktor_peringan_lainnya_text');
                if ($(this).is(':checked')) {
                    lainnyaInput.prop('disabled', false).focus();
                } else {
                    lainnyaInput.prop('disabled', true).val('');
                }
            });

            // efek_nyeri_lainnya
            $('#efek_nyeri_lainnya').on('change', function () {
                const lainnyaInput = $('#efek_nyeri_lainnya_text');
                if ($(this).is(':checked')) {
                    lainnyaInput.prop('disabled', false).focus();
                } else {
                    lainnyaInput.prop('disabled', true).val('');
                }
            });

            // initialize
            if ($('input[name="nyeri_menjalar"]:checked').val() !== 'Ya' && $('input[name="nyeri_menjalar"]:checked').val() !== 'ya') {
                $('#nyeri_menjalar_lokasi').prop('disabled', true);
            }

            if (!$('#faktor_peringan_lainnya').is(':checked')) {
                $('#faktor_peringan_lainnya_text').prop('disabled', true);
            }

            if (!$('#efek_nyeri_lainnya').is(':checked')) {
                $('#efek_nyeri_lainnya_text').prop('disabled', true);
            }
        });


        //============================================================//
// Event handler untuk skala risiko jatuh - Improved for Edit Mode
//============================================================//

document.addEventListener('DOMContentLoaded', function() {
    // Initialize forms based on existing selections
    initializeExistingForms();
    
    // Calculate existing values for all visible forms
    calculateExistingValues();
});

// Initialize existing forms based on current selections
function initializeExistingForms() {
    // Mark selectors as initialized to prevent unwanted resets
    const selectors = ['risikoJatuhSkala', 'risikoDecubitusSkala', 'aktivitasHarianSkala'];
    selectors.forEach(id => {
        const element = document.getElementById(id);
        if (element && element.value) {
            element.dataset.initialized = 'true';
        }
    });

    // Initialize risk assessment form
    const risikoJatuhSelect = document.getElementById('risikoJatuhSkala');
    if (risikoJatuhSelect && risikoJatuhSelect.value) {
        showForm(risikoJatuhSelect.value);
    }
    
    // Initialize decubitus form
    const risikoDecubitusSelect = document.getElementById('risikoDecubitusSkala');
    if (risikoDecubitusSelect && risikoDecubitusSelect.value) {
        showDecubitusForm(risikoDecubitusSelect.value);
    }
    
    // Initialize ADL form
    const aktivitasHarianSelect = document.getElementById('aktivitasHarianSkala');
    if (aktivitasHarianSelect && aktivitasHarianSelect.value) {
        showADLForm(aktivitasHarianSelect.value);
    }
    
    // Remove initialization flag after a delay to allow normal operation
    setTimeout(() => {
        selectors.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                delete element.dataset.initialized;
            }
        });
    }, 1000);
}

// Calculate existing values for all forms
function calculateExistingValues() {
    // Calculate Morse if visible
    if (document.getElementById('skala_morseForm').style.display === 'block') {
        updateConclusion('morse');
    }
    
    // Calculate Ontario if visible
    if (document.getElementById('skala_ontarioForm').style.display === 'block') {
        updateConclusion('ontario');
    }
    
    // Calculate Norton if visible
    if (document.getElementById('skala_nortonForm').style.display === 'block') {
        updateConclusion('norton');
    }
    
    // Calculate ADL if visible
    if (document.getElementById('skala_adlForm').style.display === 'block') {
        updateConclusion('adl');
    }
    
    // Calculate Umum if visible
    if (document.getElementById('skala_umumForm').style.display === 'block') {
        updateConclusion('umum');
    }
}

// Show form based on selection
function showForm(formType) {
    // Hide only fall risk forms, not all risk forms
    const fallRiskForms = ['skala_umumForm', 'skala_morseForm', 'skala_humptyForm', 'skala_ontarioForm'];
    fallRiskForms.forEach(formId => {
        const form = document.getElementById(formId);
        if (form) {
            form.style.display = 'none';
        }
    });

    // Reset only fall risk cards
    const fallRiskSection = document.getElementById('risiko_jatuh');
    if (fallRiskSection) {
        fallRiskSection.querySelectorAll('.risk-card').forEach(card => card.classList.remove('active'));
    }

    // Handle "Lainnya" option
    if (formType === '5') {
        alert('Perhatian: Pasien tidak dapat dinilai status resiko jatuh');
        return;
    }

    // Form mapping
    const formMapping = {
        '1': 'skala_umumForm',
        '2': 'skala_morseForm',
        '3': 'skala_humptyForm',
        '4': 'skala_ontarioForm'
    };

    // Show selected form
    if (formType && formMapping[formType]) {
        const formElement = document.getElementById(formMapping[formType]);
        formElement.style.display = 'block';
        
        // Only reset if this is a new selection (not during initialization)
        const selectElement = document.getElementById('risikoJatuhSkala');
        if (!selectElement.dataset.initialized) {
            resetForm(formMapping[formType]);
        }
        
        // Calculate existing values after showing form
        setTimeout(() => {
            const formTypeMap = {
                'skala_umumForm': 'umum',
                'skala_morseForm': 'morse',
                'skala_humptyForm': 'humpty',
                'skala_ontarioForm': 'ontario'
            };
            if (formTypeMap[formMapping[formType]]) {
                updateConclusion(formTypeMap[formMapping[formType]]);
            }
        }, 100);
    }
}

function showDecubitusForm(formType) {
    // Hide only decubitus forms
    const decubitusForms = ['skala_nortonForm'];
    decubitusForms.forEach(formId => {
        const form = document.getElementById(formId);
        if (form) {
            form.style.display = 'none';
        }
    });
    
    if (formType === 'norton') {
        const formElement = document.getElementById('skala_nortonForm');
        if (formElement) {
            formElement.style.display = 'block';
            
            // Only reset if this is a new selection
            const selectElement = document.getElementById('risikoDecubitusSkala');
            if (selectElement && !selectElement.dataset.initialized) {
                resetForm('skala_nortonForm');
            }
            
            // Calculate existing values
            setTimeout(() => updateConclusion('norton'), 100);
        }
    }
}

function showADLForm(formType) {
    // Hide only ADL forms
    const adlForms = ['skala_adlForm'];
    adlForms.forEach(formId => {
        const form = document.getElementById(formId);
        if (form) {
            form.style.display = 'none';
        }
    });
    
    if (formType === 'adl') {
        const formElement = document.getElementById('skala_adlForm');
        if (formElement) {
            formElement.style.display = 'block';
            
            // Only reset if this is a new selection
            const selectElement = document.getElementById('aktivitasHarianSkala');
            if (selectElement && !selectElement.dataset.initialized) {
                resetForm('skala_adlForm');
            }
            
            // Calculate existing values
            setTimeout(() => updateConclusion('adl'), 100);
        }
    }
}

// Reset form to default state (only for new selections)
function resetForm(formId) {
    const form = document.getElementById(formId);
    const selects = form.querySelectorAll('select[name]:not([name$="_jenis"])');
    selects.forEach(select => {
        if (!select.value || select.value === '') {
            select.value = '';
        }
    });

    // Reset score badges only if values are empty
    form.querySelectorAll('.score-badge').forEach(badge => {
        if (!badge.textContent || badge.textContent === '0') {
            badge.textContent = '0';
        }
    });

    // Reset conclusions based on form type only if empty
    if (formId.includes('umum')) {
        const conclusionElement = document.getElementById('kesimpulanUmum');
        if (!conclusionElement.textContent || conclusionElement.textContent === '') {
            conclusionElement.textContent = 'Tidak berisiko jatuh';
            document.getElementById('risiko_jatuh_umum_kesimpulan').value = 'Tidak berisiko jatuh';
        }
    } else if (formId.includes('morse')) {
        const totalElement = document.getElementById('totalSkorMorse');
        if (!totalElement.textContent || totalElement.textContent === '0') {
            totalElement.textContent = '0';
            document.getElementById('kesimpulanMorse').textContent = 'Risiko Rendah';
        }
    } else if (formId.includes('ontario')) {
        const totalElement = document.getElementById('totalSkorOntario');
        if (!totalElement.textContent || totalElement.textContent === '0') {
            totalElement.textContent = '0';
            document.getElementById('kesimpulanOntario').textContent = 'Risiko Rendah';
        }
    } else if (formId.includes('norton')) {
        const totalElement = document.getElementById('totalSkorNorton');
        if (!totalElement.textContent || totalElement.textContent === '0') {
            totalElement.textContent = '0';
            document.getElementById('kesimpulanNorton').textContent = 'Risiko Rendah';
        }
    } else if (formId.includes('adl')) {
        const totalElement = document.getElementById('totalSkorADL');
        if (!totalElement.textContent || totalElement.textContent === '0') {
            totalElement.textContent = '0';
            document.getElementById('kesimpulanADL').textContent = 'Mandiri (Skor: 0)';
        }
    }

    // Reset risk cards
    form.querySelectorAll('.risk-card').forEach(card => card.classList.remove('active'));
}

// Update conclusion based on form type
function updateConclusion(formType) {
    if (formType === 'umum') {
        updateUmumConclusion();
    } else if (formType === 'morse') {
        updateMorseConclusion();
    } else if (formType === 'ontario') {
        updateOntarioConclusion();
    } else if (formType === 'norton') {
        updateNortonConclusion();
    } else if (formType === 'adl') {
        updateADLConclusion();
    }
}

// Update Umum conclusion
function updateUmumConclusion() {
    const form = document.getElementById('skala_umumForm');
    if (!form || form.style.display === 'none') return;
    
    const selects = form.querySelectorAll('select[name^="risiko_jatuh_umum_"]');
    let hasYes = false;

    selects.forEach(select => {
        if (select.value === '1') {
            hasYes = true;
        }
    });

    const conclusion = hasYes ? 'Berisiko jatuh' : 'Tidak berisiko jatuh';
    const alertClass = hasYes ? 'alert-danger' : 'alert-success';

    const kesimpulanElement = document.getElementById('kesimpulanUmum');
    const hiddenElement = document.getElementById('risiko_jatuh_umum_kesimpulan');
    
    if (kesimpulanElement) kesimpulanElement.textContent = conclusion;
    if (hiddenElement) hiddenElement.value = conclusion;

    const conclusionDiv = form.querySelector('.conclusion');
    if (conclusionDiv) {
        conclusionDiv.className = `conclusion alert ${alertClass}`;
    }
}

// Update Morse conclusion
function updateMorseConclusion() {
    const form = document.getElementById('skala_morseForm');
    if (!form || form.style.display === 'none') return;
    
    let totalScore = 0;

    // Update individual scores and calculate total
    const scoreElements = {
        'risiko_jatuh_morse_riwayat_jatuh': 'score_riwayat_jatuh',
        'risiko_jatuh_morse_diagnosis_sekunder': 'score_diagnosis_sekunder',
        'risiko_jatuh_morse_bantuan_ambulasi': 'score_bantuan_ambulasi',
        'risiko_jatuh_morse_terpasang_infus': 'score_terpasang_infus',
        'risiko_jatuh_morse_cara_berjalan': 'score_cara_berjalan',
        'risiko_jatuh_morse_status_mental': 'score_status_mental'
    };

    Object.entries(scoreElements).forEach(([name, elementId]) => {
        const select = form.querySelector(`select[name="${name}"]`);
        const score = parseInt(select?.value) || 0;
        const scoreElement = document.getElementById(elementId);
        if (scoreElement) scoreElement.textContent = score;
        totalScore += score;
    });

    const totalElement = document.getElementById('totalSkorMorse');
    if (totalElement) totalElement.textContent = totalScore;

    // Reset risk cards
    form.querySelectorAll('.risk-card').forEach(card => card.classList.remove('active'));

    let conclusion = '';
    let alertClass = '';

    if (totalScore >= 45) {
        conclusion = 'Risiko Tinggi';
        alertClass = 'alert-danger';
        const resikoTinggi = document.getElementById('resikoTinggiMorse');
        if (resikoTinggi) resikoTinggi.classList.add('active');
    } else if (totalScore >= 25) {
        conclusion = 'Risiko Sedang';
        alertClass = 'alert-warning';
        const resikoSedang = document.getElementById('resikoSedangMorse');
        if (resikoSedang) resikoSedang.classList.add('active');
    } else {
        conclusion = 'Risiko Rendah';
        alertClass = 'alert-success';
        const resikoRendah = document.getElementById('resikoRendahMorse');
        if (resikoRendah) resikoRendah.classList.add('active');
    }

    conclusion += ` (Skor: ${totalScore})`;

    const kesimpulanElement = document.getElementById('kesimpulanMorse');
    const hiddenElement = document.getElementById('risiko_jatuh_morse_kesimpulan');
    
    if (kesimpulanElement) kesimpulanElement.textContent = conclusion;
    if (hiddenElement) hiddenElement.value = conclusion;

    const conclusionDiv = form.querySelector('.conclusion');
    if (conclusionDiv) {
        conclusionDiv.className = `conclusion alert ${alertClass}`;
    }
}

// Update Ontario conclusion
function updateOntarioConclusion() {
    const form = document.getElementById('skala_ontarioForm');
    if (!form || form.style.display === 'none') return;
    
    let totalScore = 0;

    // Calculate individual sections
    let riwayatJatuhScore = Math.max(
        parseInt(document.querySelector('select[name="ontario_jatuh_saat_masuk"]')?.value) || 0,
        parseInt(document.querySelector('select[name="ontario_jatuh_2_bulan"]')?.value) || 0
    );

    let statusMentalScore = Math.max(
        parseInt(document.querySelector('select[name="ontario_delirium"]')?.value) || 0,
        parseInt(document.querySelector('select[name="ontario_disorientasi"]')?.value) || 0,
        parseInt(document.querySelector('select[name="ontario_agitasi"]')?.value) || 0
    );

    let penglihatanScore = Math.max(
        parseInt(document.querySelector('select[name="ontario_kacamata"]')?.value) || 0,
        parseInt(document.querySelector('select[name="ontario_penglihatan_buram"]')?.value) || 0,
        parseInt(document.querySelector('select[name="ontario_glaukoma"]')?.value) || 0
    );

    let berkemihScore = parseInt(document.querySelector('select[name="ontario_berkemih"]')?.value) || 0;

    let transferScore = parseInt(document.querySelector('select[name="ontario_transfer"]')?.value) || 0;
    let mobilitasScore = parseInt(document.querySelector('select[name="ontario_mobilitas"]')?.value) || 0;

    // Transfer + Mobilitas logic
    let transferMobilitasTotal = transferScore + mobilitasScore;
    let transferMobilitasScore = transferMobilitasTotal > 6 ? 3 : 0;

    // Update individual score displays
    const skorElements = {
        'skor_riwayat_jatuh': riwayatJatuhScore,
        'skor_status_mental': statusMentalScore,
        'skor_penglihatan': penglihatanScore,
        'skor_berkemih': berkemihScore,
        'skor_transfer_mobilitas': transferMobilitasScore
    };

    Object.entries(skorElements).forEach(([elementId, score]) => {
        const element = document.getElementById(elementId);
        if (element) element.textContent = score;
    });

    // Calculate total
    totalScore = riwayatJatuhScore + statusMentalScore + penglihatanScore + berkemihScore + transferMobilitasScore;
    const totalElement = document.getElementById('totalSkorOntario');
    if (totalElement) totalElement.textContent = totalScore;

    // Reset risk cards
    form.querySelectorAll('.risk-card').forEach(card => card.classList.remove('active'));

    let conclusion = '';
    let alertClass = '';

    if (totalScore >= 17) {
        conclusion = 'Risiko Tinggi';
        alertClass = 'alert-danger';
        const resikoTinggi = document.getElementById('resikoTinggiOntario');
        if (resikoTinggi) resikoTinggi.classList.add('active');
    } else if (totalScore >= 6) {
        conclusion = 'Risiko Sedang';
        alertClass = 'alert-warning';
        const resikoSedang = document.getElementById('resikoSedangOntario');
        if (resikoSedang) resikoSedang.classList.add('active');
    } else {
        conclusion = 'Risiko Rendah';
        alertClass = 'alert-success';
        const resikoRendah = document.getElementById('resikoRendahOntario');
        if (resikoRendah) resikoRendah.classList.add('active');
    }

    conclusion += ` (Skor: ${totalScore})`;

    const kesimpulanElement = document.getElementById('kesimpulanOntario');
    const hiddenElement = document.getElementById('risiko_jatuh_lansia_kesimpulan');
    
    if (kesimpulanElement) kesimpulanElement.textContent = conclusion;
    if (hiddenElement) hiddenElement.value = conclusion;

    const conclusionDiv = form.querySelector('.conclusion');
    if (conclusionDiv) {
        conclusionDiv.className = `conclusion alert ${alertClass}`;
    }
}

// Update Norton conclusion
function updateNortonConclusion() {
    const form = document.getElementById('skala_nortonForm');
    if (!form || form.style.display === 'none') return;
    
    let totalScore = 0;

    // Calculate scores for each factor
    const scoreElements = {
        'norton_kondisi_fisik': 'skor_kondisi_fisik',
        'norton_kondisi_mental': 'skor_kondisi_mental',
        'norton_aktivitas': 'skor_aktivitas',
        'norton_mobilitas': 'skor_mobilitas',
        'norton_inkontinensia': 'skor_inkontinensia'
    };

    Object.entries(scoreElements).forEach(([name, elementId]) => {
        const select = form.querySelector(`select[name="${name}"]`);
        const score = parseInt(select?.value) || 0;
        const scoreElement = document.getElementById(elementId);
        if (scoreElement) scoreElement.textContent = score;
        totalScore += score;
    });

    const totalElement = document.getElementById('totalSkorNorton');
    if (totalElement) totalElement.textContent = totalScore;

    // Reset risk cards
    form.querySelectorAll('.risk-card').forEach(card => card.classList.remove('active'));

    let conclusion = '';
    let alertClass = '';

    if (totalScore < 12) {
        conclusion = 'Risiko Tinggi';
        alertClass = 'alert-danger';
        const resikoTinggi = document.getElementById('resikoTinggiNorton');
        if (resikoTinggi) resikoTinggi.classList.add('active');
    } else if (totalScore <= 15) {
        conclusion = 'Risiko Sedang';
        alertClass = 'alert-warning';
        const resikoSedang = document.getElementById('resikoSedangNorton');
        if (resikoSedang) resikoSedang.classList.add('active');
    } else {
        conclusion = 'Risiko Rendah';
        alertClass = 'alert-success';
        const resikoRendah = document.getElementById('resikoRendahNorton');
        if (resikoRendah) resikoRendah.classList.add('active');
    }

    conclusion += ` (Skor: ${totalScore})`;

    const kesimpulanElement = document.getElementById('kesimpulanNorton');
    const hiddenElement = document.getElementById('risiko_norton_kesimpulan');
    
    if (kesimpulanElement) kesimpulanElement.textContent = conclusion;
    if (hiddenElement) hiddenElement.value = conclusion;

    const conclusionDiv = form.querySelector('.conclusion');
    if (conclusionDiv) {
        conclusionDiv.className = `conclusion alert ${alertClass}`;
    }
}

// Update ADL conclusion
function updateADLConclusion() {
    const form = document.getElementById('skala_adlForm');
    if (!form || form.style.display === 'none') return;
    
    let totalScore = 0;

    // Calculate scores for each activity
    const scoreElements = {
        'adl_makan': 'skor_makan',
        'adl_berjalan': 'skor_berjalan',
        'adl_mandi': 'skor_mandi'
    };

    Object.entries(scoreElements).forEach(([name, elementId]) => {
        const select = form.querySelector(`select[name="${name}"]`);
        const score = parseInt(select?.value) || 0;
        const scoreElement = document.getElementById(elementId);
        if (scoreElement) scoreElement.textContent = score;
        totalScore += score;
    });

    const totalElement = document.getElementById('totalSkorADL');
    if (totalElement) totalElement.textContent = totalScore;

    let conclusion = '';
    let alertClass = '';
    
    if (totalScore === 0) {
        conclusion = 'Mandiri';
        alertClass = 'alert-success';
    } else if (totalScore <= 3) {
        conclusion = 'Bantuan Minimal';
        alertClass = 'alert-info';
    } else if (totalScore <= 6) {
        conclusion = 'Bantuan Sedang';
        alertClass = 'alert-warning';
    } else {
        conclusion = 'Bantuan Total';
        alertClass = 'alert-danger';
    }

    conclusion += ` (Skor: ${totalScore})`;

    const kesimpulanElement = document.getElementById('kesimpulanADL');
    const hiddenElement = document.getElementById('adl_kesimpulan');
    
    if (kesimpulanElement) kesimpulanElement.textContent = conclusion;
    if (hiddenElement) hiddenElement.value = conclusion;

    const conclusionDiv = form.querySelector('.conclusion');
    if (conclusionDiv) {
        conclusionDiv.className = `conclusion alert ${alertClass}`;
    }
}

// Discharge Planning - Enhanced for edit mode
document.addEventListener('DOMContentLoaded', function () {
    // Wait a bit to ensure all elements are loaded
    setTimeout(function() {
        const selectElements = {
            age: document.querySelector('select[name="usia_lanjut"]'),
            mobility: document.querySelector('select[name="hambatan_mobilisasi"]'),
            medService: document.querySelector('select[name="penggunaan_media_berkelanjutan"]'),
            medication: document.querySelector('select[name="ketergantungan_aktivitas"]')
        };

        const alerts = {
            info: document.querySelector('#reason-alert'),
            warning: document.querySelector('#special-plan-alert'),
            success: document.querySelector('#no-special-plan-alert')
        };

        const hiddenInput = document.querySelector('#kesimpulan');

        // Check if all required elements exist
        if (!Object.values(selectElements).every(el => el) || !Object.values(alerts).every(el => el) || !hiddenInput) {
            console.log('Some discharge planning elements are missing - this is normal if not on that section');
            return;
        }

        function calculateConclusion() {
            let needsSpecialPlan = false;
            let reasons = [];

            // Check each condition
            if (selectElements.age.value === 'ya') {
                needsSpecialPlan = true;
                reasons.push('Pasien berusia lanjut (>60 tahun)');
            }
            if (selectElements.mobility.value === 'ya') {
                needsSpecialPlan = true;
                reasons.push('Terdapat hambatan mobilitas');
            }
            if (selectElements.medService.value === 'ya') {
                needsSpecialPlan = true;
                reasons.push('Membutuhkan pelayanan medis berkelanjutan');
            }
            if (selectElements.medication.value === 'ya') {
                needsSpecialPlan = true;
                reasons.push('Membutuhkan bantuan dalam konsumsi obat dan aktivitas harian');
            }

            // Reset alerts
            Object.values(alerts).forEach(alert => alert.classList.add('d-none'));

            // Update UI based on conditions
            if (needsSpecialPlan) {
                alerts.warning.classList.remove('d-none');
                alerts.info.classList.remove('d-none');
                alerts.info.innerHTML = '<strong>Alasan:</strong><br>- ' + (reasons.length > 0 ? reasons.join('<br>- ') : 'Tidak ada alasan spesifik');
                hiddenInput.value = 'Membutuhkan rencana pulang khusus';
            } else {
                alerts.success.classList.remove('d-none');
                hiddenInput.value = 'Tidak membutuhkan rencana pulang khusus';
            }
        }

        // Add event listeners to all select elements
        Object.values(selectElements).forEach(select => {
            select.addEventListener('change', calculateConclusion);
        });

        // Initial calculation for edit mode
        calculateConclusion();
    }, 500);
});

// Rencana Perawatan - Enhanced for edit mode
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const rencanaRows = document.querySelectorAll('.rencana-perawatan-row-1');
        const rencanaDiv = document.getElementById('rencana_bersihan_jalan_nafas');
        
        if (rencanaRows.length > 0 && rencanaDiv) {
            function updateRencanaDisplay() {
                let rowCount = document.querySelectorAll('.rencana-perawatan-row-1:checked').length > 0;
                
                if(rowCount) {
                    rencanaDiv.style.display = 'block';
                } else {
                    rencanaDiv.style.display = 'none';
                }
            }
            
            // Add event listeners
            rencanaRows.forEach(row => {
                row.addEventListener('change', updateRencanaDisplay);
            });
            
            // Initial calculation for edit mode
            updateRencanaDisplay();
        }
    }, 500);
});

        // Discharge Planning
        document.addEventListener('DOMContentLoaded', function () {
            const selectElements = {
                age: document.querySelector('select[name="usia_lanjut"]'),
                mobility: document.querySelector('select[name="hambatan_mobilisasi"]'),
                medService: document.querySelector('select[name="penggunaan_media_berkelanjutan"]'),
                medication: document.querySelector('select[name="ketergantungan_aktivitas"]')
            };

            const alerts = {
                info: document.querySelector('#reason-alert'),
                warning: document.querySelector('#special-plan-alert'),
                success: document.querySelector('#no-special-plan-alert')
            };

            const hiddenInput = document.querySelector('#kesimpulan');

            // Check if all required elements exist
            if (!Object.values(selectElements).every(el => el) || !Object.values(alerts).every(el => el) || !hiddenInput) {
                console.error('One or more required elements are missing');
                return;
            }

            function calculateConclusion() {
                let needsSpecialPlan = false;
                let reasons = [];

                // Check each condition
                if (selectElements.age.value === 'ya' || selectElements.age.value === '0') {
                    needsSpecialPlan = true;
                    reasons.push('Pasien berusia lanjut (>60 tahun)');
                }
                if (selectElements.mobility.value === 'ya' || selectElements.mobility.value === '0') {
                    needsSpecialPlan = true;
                    reasons.push('Terdapat hambatan mobilitas');
                }
                if (selectElements.medService.value === 'ya') {
                    needsSpecialPlan = true;
                    reasons.push('Membutuhkan pelayanan medis berkelanjutan');
                }
                if (selectElements.medication.value === 'ya') {
                    needsSpecialPlan = true;
                    reasons.push('Membutuhkan bantuan dalam konsumsi obat dan aktivitas harian');
                }

                // Reset alerts
                Object.values(alerts).forEach(alert => alert.classList.add('d-none'));

                // Update UI based on conditions
                if (needsSpecialPlan) {
                    alerts.warning.classList.remove('d-none');
                    alerts.info.classList.remove('d-none');
                    alerts.info.innerHTML = '<strong>Alasan:</strong><br>- ' + (reasons.length > 0 ? reasons.join('<br>- ') : 'Tidak ada alasan spesifik');
                    hiddenInput.value = 'Membutuhkan rencana pulang khusus';
                } else {
                    alerts.success.classList.remove('d-none');
                    hiddenInput.value = 'Tidak membutuhkan rencana pulang khusus';
                }
            }

            // Add event listeners to all select elements
            Object.values(selectElements).forEach(select => {
                select.addEventListener('change', calculateConclusion);
            });

            // Initial calculation
            calculateConclusion();
        });


        $('.rencana-perawatan-row-1').change(function () {
            let rowCount = $('.rencana-perawatan-row-1:checked').length > 0;

            if (rowCount) {
                $('#rencana_bersihan_jalan_nafas').css('display', 'block');
            } else {
                $('#rencana_bersihan_jalan_nafas').css('display', 'none');
            }

        });

        // 13. MASALAH/ DIAGNOSIS KEPERAWATAN
        function toggleRencana(diagnosisType) {
            // Handle special case for respiratory group (3 diagnosis yang menggunakan 1 rencana)
            const respiratoryGroup = ['bersihan_jalan_nafas', 'risiko_aspirasi', 'pola_nafas_tidak_efektif'];
            
            if (respiratoryGroup.includes(diagnosisType)) {
                // Check if any of the 3 respiratory checkboxes is checked
                const anyRespChecked = respiratoryGroup.some(diagnosis => {
                    const checkbox = document.getElementById('diag_' + diagnosis);
                    return checkbox && checkbox.checked;
                });
                
                const rencanaDiv = document.getElementById('rencana_bersihan_jalan_nafas');
                if (rencanaDiv) {
                    if (anyRespChecked) {
                        rencanaDiv.style.display = 'block';
                    } else {
                        rencanaDiv.style.display = 'none';
                        // Uncheck all rencana checkboxes when no respiratory diagnosis is checked
                        const rencanaCheckboxes = rencanaDiv.querySelectorAll('input[type="checkbox"]');
                        rencanaCheckboxes.forEach(cb => cb.checked = false);
                    }
                }
            } else {
                // Handle normal case (1 diagnosis = 1 rencana)
                const checkbox = document.getElementById('diag_' + diagnosisType);
                const rencanaDiv = document.getElementById('rencana_' + diagnosisType);

                if (checkbox && rencanaDiv) {
                    if (checkbox.checked) {
                        rencanaDiv.style.display = 'block';
                    } else {
                        rencanaDiv.style.display = 'none';
                        // Uncheck all rencana checkboxes when diagnosis is unchecked
                        const rencanaCheckboxes = rencanaDiv.querySelectorAll('input[type="checkbox"]');
                        rencanaCheckboxes.forEach(cb => cb.checked = false);
                    }
                }
            }
        }

        // Initialize page on DOM load
        document.addEventListener('DOMContentLoaded', function() {
            // Set current date and time
            const now = new Date();
            const today = now.toISOString().split('T')[0];
            const currentTime = now.toTimeString().split(' ')[0].substring(0, 5);

            const tanggalInput = document.querySelector('input[name="tanggal_diagnosis"]');
            const jamInput = document.querySelector('input[name="jam_diagnosis"]');

            if (tanggalInput) tanggalInput.value = today;
            if (jamInput) jamInput.value = currentTime;

            // Add event listeners to diagnosis checkboxes that don't have onchange attribute
            const diagnosisCheckboxes = [
                'bersihan_jalan_nafas',
                'risiko_aspirasi', 
                'pola_nafas_tidak_efektif',
                'penurunan_curah_jantung',
                'perfusi_perifer',
                'hipovolemia',
                'hipervolemia',
                'diare',
                'retensi_urine',
                'nyeri_akut',
                'nyeri_kronis',
                'hipertermia',
                'gangguan_mobilitas_fisik',
                'resiko_infeksi',
                'konstipasi',
                'resiko_jatuh',
                'gangguan_integritas_kulit'
            ];

            diagnosisCheckboxes.forEach(diagnosis => {
                const checkbox = document.getElementById('diag_' + diagnosis);
                if (checkbox) {
                    // Remove existing onchange if any
                    checkbox.removeAttribute('onchange');
                    
                    // Add event listener
                    checkbox.addEventListener('change', function() {
                        toggleRencana(diagnosis);
                    });

                    // Initialize display based on current state
                    toggleRencana(diagnosis);
                }
            });

            // Handle special cases for grouped checkboxes (bersihan jalan nafas group)
            const bersihanGroupCheckboxes = [
                'bersihan_jalan_nafas',
                'risiko_aspirasi',
                'pola_nafas_tidak_efektif'
            ];

            bersihanGroupCheckboxes.forEach(diagnosis => {
                const checkbox = document.getElementById('diag_' + diagnosis);
                if (checkbox) {
                    checkbox.addEventListener('change', function() {
                        // Check if any checkbox in the bersihan group is checked
                        const anyBersihanChecked = bersihanGroupCheckboxes.some(d => {
                            const cb = document.getElementById('diag_' + d);
                            return cb && cb.checked;
                        });

                        const rencanaDiv = document.getElementById('rencana_bersihan_jalan_nafas');
                        if (rencanaDiv) {
                            if (anyBersihanChecked) {
                                rencanaDiv.style.display = 'block';
                            } else {
                                rencanaDiv.style.display = 'none';
                                // Uncheck all rencana checkboxes when no diagnosis is checked
                                const rencanaCheckboxes = rencanaDiv.querySelectorAll('input[type="checkbox"]');
                                rencanaCheckboxes.forEach(cb => cb.checked = false);
                            }
                        }
                    });
                }
            });
        });

        // Helper function to check/uncheck all rencana items for a diagnosis
        function toggleAllRencana(diagnosisType, checked) {
            const rencanaDiv = document.getElementById('rencana_' + diagnosisType);
            if (rencanaDiv) {
                const checkboxes = rencanaDiv.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(cb => cb.checked = checked);
            }
        }

        // Function to validate form before submission
        function validateDiagnosisForm() {
            const diagnosisCheckboxes = document.querySelectorAll('input[name="diagnosis[]"]:checked');
            
            if (diagnosisCheckboxes.length === 0) {
                alert('Silakan pilih minimal satu diagnosis keperawatan.');
                return false;
            }

            // Check if selected diagnoses have at least one rencana selected
            let hasRencana = false;
            diagnosisCheckboxes.forEach(cb => {
                const diagnosisValue = cb.value;
                let rencanaName;
                
                // Handle special case for bersihan jalan nafas group
                if (['bersihan_jalan_nafas', 'risiko_aspirasi', 'pola_nafas_tidak_efektif'].includes(diagnosisValue)) {
                    rencanaName = 'rencana_bersihan_jalan_nafas[]';
                } else {
                    rencanaName = 'rencana_' + diagnosisValue + '[]';
                }
                
                const rencanaCheckboxes = document.querySelectorAll(`input[name="${rencanaName}"]:checked`);
                if (rencanaCheckboxes.length > 0) {
                    hasRencana = true;
                }
            });

            if (!hasRencana) {
                alert('Silakan pilih minimal satu rencana keperawatan untuk diagnosis yang dipilih.');
                return false;
            }

            return true;
        }
    </script>
@endpush