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

        .color-btn {
            width: 35px;
            height: 35px;
            border: 2px solid #dee2e6;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .color-btn:hover {
            transform: scale(1.1);
            border-color: #6c757d;
        }

        .color-btn.active {
            border-color: #fff;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.3);
            transform: scale(1.1);
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // ============================================================================
            // SECTION 1: DATETIME & BASIC FORM HANDLERS
            // ============================================================================
            initializeDateTimeDefaults();
            initializeAnthropometryCalculation();
            initializePemeriksaanFisikHandlers();
            
            // ============================================================================
            // SECTION 2: RIWAYAT KESEHATAN HANDLERS
            // ============================================================================
            initializeRiwayatKesehatanHandlers();
            initializeGCSHandlers();
            
            // ============================================================================
            // SECTION 3: PAIN SCALE MANAGEMENT
            // ============================================================================
            initializePainScaleHandlers();
            
            // ============================================================================
            // SECTION 4: RISK ASSESSMENT (FALL & DECUBITUS)
            // ============================================================================
            initializeFallRiskHandlers();
            initializeDecubitusRiskHandlers();
            
            // ============================================================================
            // SECTION 5: PSYCHOLOGICAL STATUS
            // ============================================================================
            initializePsychologicalStatusHandlers();
            
            // ============================================================================
            // SECTION 6: NUTRITIONAL STATUS
            // ============================================================================
            initializeNutritionalStatusHandlers();
            
            // ============================================================================
            // SECTION 7: FUNCTIONAL STATUS (ADL)
            // ============================================================================
            initializeFunctionalStatusHandlers();
            
            // ============================================================================
            // SECTION 8: DISCHARGE PLANNING
            // ============================================================================
            initializeDischargePlanningHandlers();
            initializeDiagnosisKeperawatanHandlers();

        });

        // ============================================================================
        // SECTION 1: DATETIME & BASIC FORM HANDLERS
        // ============================================================================
        
        /**
         * Initialize default datetime values
         */
        function initializeDateTimeDefaults() {
            const currentDate = new Date();
            const formattedDate = currentDate.toISOString().split('T')[0];
            const hours = String(currentDate.getHours()).padStart(2, '0');
            const minutes = String(currentDate.getMinutes()).padStart(2, '0');
            
            const tanggalMasukInput = document.getElementById('tanggal_masuk');
            const jamMasukInput = document.getElementById('jam_masuk');
            
            if (tanggalMasukInput) tanggalMasukInput.value = formattedDate;
            if (jamMasukInput) jamMasukInput.value = `${hours}:${minutes}`;
        }

        /**
         * Initialize anthropometry calculation (BMI & LPT)
         */
        function initializeAnthropometryCalculation() {
            const tinggiBadanInput = document.getElementById("tinggi_badan");
            const beratBadanInput = document.getElementById("berat_badan");
            const imtInput = document.getElementById("imt");
            const lptInput = document.getElementById("lpt");

            if (!tinggiBadanInput || !beratBadanInput || !imtInput || !lptInput) return;

            function hitungIMT_LPT() {
                const tinggi = parseFloat(tinggiBadanInput.value) / 100; // Convert to meters
                const berat = parseFloat(beratBadanInput.value);

                if (!isNaN(tinggi) && !isNaN(berat) && tinggi > 0) {
                    const imt = berat / (tinggi * tinggi);
                    const lpt = (tinggi * 100 * berat) / 3600; // Height converted to cm
                    
                    imtInput.value = imt.toFixed(2);
                    lptInput.value = lpt.toFixed(2);
                } else {
                    imtInput.value = "";
                    lptInput.value = "";
                }
            }

            tinggiBadanInput.addEventListener("input", hitungIMT_LPT);
            beratBadanInput.addEventListener("input", hitungIMT_LPT);
        }

        /**
         * Initialize physical examination handlers
         */
        function initializePemeriksaanFisikHandlers() {
            // Add keterangan button handlers
            document.querySelectorAll('.tambah-keterangan').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const keteranganDiv = document.getElementById(targetId);
                    const normalCheckbox = this.closest('.pemeriksaan-item').querySelector('.form-check-input');

                    if (keteranganDiv.style.display === 'none') {
                        keteranganDiv.style.display = 'block';
                        normalCheckbox.checked = false;
                    } else {
                        keteranganDiv.style.display = 'block';
                    }
                });
            });

            // Normal checkbox handlers
            document.querySelectorAll('.form-check-input').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const pemeriksaanItem = this.closest('.pemeriksaan-item');
                    if (pemeriksaanItem) {
                        const keteranganDiv = pemeriksaanItem.querySelector('.keterangan');
                        if (keteranganDiv && this.checked) {
                            keteranganDiv.style.display = 'none';
                            const input = keteranganDiv.querySelector('input');
                            if (input) input.value = '';
                        }
                    }
                });
            });

            // Initialize all checkboxes as checked and hide keterangan
            document.querySelectorAll('.form-check-input').forEach(checkbox => {
                const pemeriksaanItem = checkbox.closest('.pemeriksaan-item');
                if (pemeriksaanItem) {
                    checkbox.checked = true;
                    const keteranganDiv = pemeriksaanItem.querySelector('.keterangan');
                    if (keteranganDiv) {
                        keteranganDiv.style.display = 'none';
                        const input = keteranganDiv.querySelector('input');
                        if (input) input.value = '';
                    }
                }
            });
        }

        // ============================================================================
        // SECTION 2: RIWAYAT KESEHATAN HANDLERS
        // ============================================================================
        
        /**
         * Initialize handlers for medical history section
         */
        function initializeRiwayatKesehatanHandlers() {
            // Handle "Lainnya" checkbox for penyakit
            const penyakitLainnyaCheckbox = document.getElementById('penyakit_lainnya');
            if (penyakitLainnyaCheckbox) {
                penyakitLainnyaCheckbox.addEventListener('change', function() {
                    const textInput = document.querySelector('input[name="penyakit_diderita_lainnya"]');
                    if (textInput) {
                        textInput.disabled = !this.checked;
                        if (!this.checked) {
                            textInput.value = '';
                        }
                    }
                });
            }

            // Handle "Lainnya" checkbox for riwayat keluarga
            const keluargaLainnyaCheckbox = document.getElementById('keluarga_lainnya');
            if (keluargaLainnyaCheckbox) {
                keluargaLainnyaCheckbox.addEventListener('change', function() {
                    const textInput = document.querySelector('input[name="riwayat_keluarga_lainnya_text"]');
                    if (textInput) {
                        textInput.disabled = !this.checked;
                        if (!this.checked) {
                            textInput.value = '';
                        }
                    }
                });
            }

            // Handle rawat inap/operasi details
            document.querySelectorAll('input[name="pernah_rawat_operasi"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    const detailDiv = document.getElementById('rawat_detail');
                    if (detailDiv) {
                        if (this.value === 'Ya') {
                            detailDiv.style.display = 'block';
                        } else {
                            detailDiv.style.display = 'none';
                            detailDiv.querySelectorAll('input').forEach(input => input.value = '');
                        }
                    }
                });
            });

            // Handle konsumsi obat details
            document.querySelectorAll('input[name="konsumsi_obat_lalu"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    const detailDiv = document.getElementById('obat_detail');
                    if (detailDiv) {
                        if (this.value === 'Ya') {
                            detailDiv.style.display = 'block';
                        } else {
                            detailDiv.style.display = 'none';
                            const textarea = detailDiv.querySelector('textarea');
                            if (textarea) textarea.value = '';
                        }
                    }
                });
            });
        }

        // ============================================================================
        // SECTION 3: PAIN SCALE MANAGEMENT
        // ============================================================================
        
        /**
         * Initialize pain scale handlers
         */
        function initializePainScaleHandlers() {
            const skalaSelect = document.getElementById('jenis_skala_nyeri');
            const nilaiSkalaNyeri = document.getElementById('nilai_skala_nyeri');
            const kesimpulanNyeri = document.getElementById('kesimpulan_nyeri');
            const kesimpulanNyeriAlert = document.getElementById('kesimpulan_nyeri_alert');

            if (!skalaSelect) return;

            // Handle scale selection
            skalaSelect.addEventListener('change', function() {
                const openModals = document.querySelectorAll('.modal.show');
                openModals.forEach(modal => {
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    if (modalInstance) modalInstance.hide();
                });

                const modalMap = {
                    'NRS': 'modalNRS',
                    'FLACC': 'modalFLACC',
                    'CRIES': 'modalCRIES'
                };

                const modalId = modalMap[this.value];
                if (modalId) {
                    const modal = new bootstrap.Modal(document.getElementById(modalId));
                    modal.show();
                }
            });

            // Initialize NRS handlers
            initializeNRSHandlers(nilaiSkalaNyeri, kesimpulanNyeri, kesimpulanNyeriAlert);
            
            // Initialize FLACC handlers
            initializeFLACCHandlers(nilaiSkalaNyeri, kesimpulanNyeri, kesimpulanNyeriAlert);
            
            // Initialize CRIES handlers
            initializeCRIESHandlers(nilaiSkalaNyeri, kesimpulanNyeri, kesimpulanNyeriAlert);
        }

        /**
         * Initialize NRS pain scale handlers
         */
        function initializeNRSHandlers(nilaiSkalaNyeri, kesimpulanNyeri, kesimpulanNyeriAlert) {
            const nrsModal = document.getElementById('modalNRS');
            const nrsValue = document.getElementById('nrs_value');
            const nrsKesimpulan = document.getElementById('nrs_kesimpulan');
            const simpanNRS = document.getElementById('simpanNRS');

            if (!nrsValue || !nrsKesimpulan || !simpanNRS) return;

            // NRS value change handler
            nrsValue.addEventListener('input', function() {
                let value = parseInt(this.value);
                
                if (value < 0) this.value = 0;
                if (value > 10) this.value = 10;
                value = parseInt(this.value);

                const { kesimpulan, alertClass, emoji } = getPainConclusion(value);
                
                nrsKesimpulan.className = 'alert ' + alertClass;
                nrsKesimpulan.innerHTML = `
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi ${emoji} fs-4"></i>
                        <span>${kesimpulan}</span>
                    </div>
                `;
            });

            // Save NRS value
            simpanNRS.addEventListener('click', function() {
                if (nilaiSkalaNyeri && kesimpulanNyeri && kesimpulanNyeriAlert) {
                    const value = parseInt(nrsValue.value);
                    const { kesimpulan, alertClass, emoji } = getPainConclusion(value);
                    
                    nilaiSkalaNyeri.value = value;
                    kesimpulanNyeri.value = kesimpulan;
                    kesimpulanNyeriAlert.innerHTML = `
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi ${emoji} fs-4"></i>
                            <span>${kesimpulan}</span>
                        </div>
                    `;
                    kesimpulanNyeriAlert.className = `alert ${alertClass}`;
                    
                    bootstrap.Modal.getInstance(nrsModal).hide();
                }
            });

            // Reset form when modal is closed
            nrsModal.addEventListener('hidden.bs.modal', function() {
                nrsValue.value = '';
                nrsKesimpulan.innerHTML = `
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-emoji-smile fs-4"></i>
                        <span>Pilih nilai nyeri terlebih dahulu</span>
                    </div>
                `;
                nrsKesimpulan.className = 'alert alert-info';
            });
        }

        /**
         * Initialize FLACC pain scale handlers
         */
        function initializeFLACCHandlers(nilaiSkalaNyeri, kesimpulanNyeri, kesimpulanNyeriAlert) {
            const flaccModal = document.getElementById('modalFLACC');
            const simpanFLACC = document.getElementById('simpanFLACC');

            if (!flaccModal || !simpanFLACC) return;

            const updateFLACCTotal = () => {
                const flaccChecks = document.querySelectorAll('.flacc-check:checked');
                const flaccTotal = document.getElementById('flaccTotal');
                const flaccKesimpulan = document.getElementById('flaccKesimpulan');
                
                let total = 0;
                flaccChecks.forEach(check => {
                    total += parseInt(check.value);
                });
                
                if (flaccTotal) flaccTotal.value = total;

                const { kesimpulan, alertClass } = getPainConclusion(total);
                
                if (flaccKesimpulan) {
                    flaccKesimpulan.textContent = kesimpulan;
                    flaccKesimpulan.className = `alert py-1 px-3 mb-0 ${alertClass}`;
                }
            };

            document.querySelectorAll('.flacc-check').forEach(check => {
                check.addEventListener('change', updateFLACCTotal);
            });

            simpanFLACC.addEventListener('click', function() {
                const flaccTotal = document.getElementById('flaccTotal');
                
                if (nilaiSkalaNyeri && flaccTotal && flaccTotal.value !== '') {
                    const total = parseInt(flaccTotal.value);
                    const { kesimpulan, alertClass, emoji } = getPainConclusion(total);
                    
                    nilaiSkalaNyeri.value = total;
                    kesimpulanNyeri.value = kesimpulan;
                    kesimpulanNyeriAlert.innerHTML = `
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi ${emoji} fs-4"></i>
                            <span>${kesimpulan}</span>
                        </div>
                    `;
                    kesimpulanNyeriAlert.className = `alert ${alertClass}`;

                    bootstrap.Modal.getInstance(flaccModal).hide();
                }
            });
        }

        /**
         * Initialize CRIES pain scale handlers
         */
        function initializeCRIESHandlers(nilaiSkalaNyeri, kesimpulanNyeri, kesimpulanNyeriAlert) {
            const criesModal = document.getElementById('modalCRIES');
            const simpanCRIES = document.getElementById('simpanCRIES');

            if (!criesModal || !simpanCRIES) return;

            const updateCRIESTotal = () => {
                const criesChecks = document.querySelectorAll('.cries-check:checked');
                const criesTotal = document.getElementById('criesTotal');
                const criesKesimpulan = document.getElementById('criesKesimpulan');
                
                let total = 0;
                criesChecks.forEach(check => {
                    total += parseInt(check.value);
                });
                
                if (criesTotal) criesTotal.value = total;

                const { kesimpulan, alertClass } = getPainConclusion(total);
                
                if (criesKesimpulan) {
                    criesKesimpulan.textContent = kesimpulan;
                    criesKesimpulan.className = `alert py-1 px-3 mb-0 ${alertClass}`;
                }
            };

            document.querySelectorAll('.cries-check').forEach(check => {
                check.addEventListener('change', updateCRIESTotal);
            });

            simpanCRIES.addEventListener('click', function() {
                const criesTotal = document.getElementById('criesTotal');
                
                if (nilaiSkalaNyeri && criesTotal && criesTotal.value !== '') {
                    const total = parseInt(criesTotal.value);
                    const { kesimpulan, alertClass, emoji } = getPainConclusion(total);
                    
                    nilaiSkalaNyeri.value = total;
                    kesimpulanNyeri.value = kesimpulan;
                    kesimpulanNyeriAlert.innerHTML = `
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi ${emoji} fs-4"></i>
                            <span>${kesimpulan}</span>
                        </div>
                    `;
                    kesimpulanNyeriAlert.className = `alert ${alertClass}`;

                    bootstrap.Modal.getInstance(criesModal).hide();
                }
            });
        }

        /**
         * Get pain conclusion based on score
         */
        function getPainConclusion(value) {
            if (value >= 0 && value <= 3) {
                return {
                    kesimpulan: 'Nyeri Ringan',
                    alertClass: 'alert-success',
                    emoji: 'bi-emoji-smile'
                };
            } else if (value >= 4 && value <= 6) {
                return {
                    kesimpulan: 'Nyeri Sedang',
                    alertClass: 'alert-warning',
                    emoji: 'bi-emoji-neutral'
                };
            } else {
                return {
                    kesimpulan: 'Nyeri Berat',
                    alertClass: 'alert-danger',
                    emoji: 'bi-emoji-frown'
                };
            }
        }


        // ============================================================================
        // GCS MANAGEMENT
        // ============================================================================

        /**
         * Initialize GCS handlers
         */
        function initializeGCSHandlers() {
            const gcsDisplay = document.getElementById('gcs_display');
            const simpanGCS = document.getElementById('simpanGCS');
            const gcsModal = document.getElementById('gcsModal');

            if (!gcsDisplay || !simpanGCS || !gcsModal) return;

            // Make GCS display clickable
            gcsDisplay.addEventListener('click', function() {
                const modal = new bootstrap.Modal(gcsModal);
                modal.show();
            });

            // GCS radio button handlers
            document.querySelectorAll('.gcs-check').forEach(radio => {
                radio.addEventListener('change', updateGCSDisplay);
            });

            // Save GCS
            simpanGCS.addEventListener('click', function() {
                const eyeValue = document.querySelector('input[name="gcs_eye"]:checked')?.value;
                const verbalValue = document.querySelector('input[name="gcs_verbal"]:checked')?.value;
                const motorValue = document.querySelector('input[name="gcs_motor"]:checked')?.value;

                if (eyeValue && verbalValue && motorValue) {
                    const total = parseInt(eyeValue) + parseInt(verbalValue) + parseInt(motorValue);
                    const gcsString = `${total} E${eyeValue} V${verbalValue} M${motorValue}`;
                    
                    // Update display fields
                    gcsDisplay.value = gcsString;
                    document.getElementById('gcs_value').value = gcsString;
                    
                    // Close modal
                    bootstrap.Modal.getInstance(gcsModal).hide();
                    
                    // Show success message
                    showToast('success', 'GCS berhasil disimpan');
                } else {
                    showToast('warning', 'Harap pilih semua komponen GCS');
                }
            });

            // Reset modal when closed
            gcsModal.addEventListener('hidden.bs.modal', function() {
                resetGCSModal();
            });
        }

        /**
         * Update GCS display in modal
         */
        function updateGCSDisplay() {
            const eyeValue = document.querySelector('input[name="gcs_eye"]:checked')?.value;
            const verbalValue = document.querySelector('input[name="gcs_verbal"]:checked')?.value;
            const motorValue = document.querySelector('input[name="gcs_motor"]:checked')?.value;

            // Update individual displays
            document.getElementById('gcs_eye_display').textContent = eyeValue || '-';
            document.getElementById('gcs_verbal_display').textContent = verbalValue || '-';
            document.getElementById('gcs_motor_display').textContent = motorValue || '-';

            // Calculate total and interpretation
            if (eyeValue && verbalValue && motorValue) {
                const total = parseInt(eyeValue) + parseInt(verbalValue) + parseInt(motorValue);
                
                // Update total display
                const totalDisplay = document.getElementById('gcs_total_display');
                totalDisplay.innerHTML = `<strong>Total: ${total} (E${eyeValue} V${verbalValue} M${motorValue})</strong>`;
                totalDisplay.className = getGCSAlertClass(total);

                // Update interpretation
                const interpretation = document.getElementById('gcs_interpretation');
                interpretation.textContent = getGCSInterpretation(total);
                interpretation.className = getGCSAlertClass(total);
            } else {
                document.getElementById('gcs_total_display').innerHTML = '<strong>Total: - </strong>';
                document.getElementById('gcs_total_display').className = 'alert alert-info mb-0';
                document.getElementById('gcs_interpretation').textContent = 'Pilih semua komponen';
                document.getElementById('gcs_interpretation').className = 'alert alert-secondary mb-0';
            }
        }

        /**
         * Get GCS interpretation based on total score
         */
        function getGCSInterpretation(total) {
            if (total >= 13 && total <= 15) {
                return 'Cedera Kepala Ringan';
            } else if (total >= 9 && total <= 12) {
                return 'Cedera Kepala Sedang';
            } else if (total >= 3 && total <= 8) {
                return 'Cedera Kepala Berat';
            }
            return 'Invalid Score';
        }

        /**
         * Get alert class based on GCS score
         */
        function getGCSAlertClass(total) {
            if (total >= 13 && total <= 15) {
                return 'alert alert-success mb-0';
            } else if (total >= 9 && total <= 12) {
                return 'alert alert-warning mb-0';
            } else if (total >= 3 && total <= 8) {
                return 'alert alert-danger mb-0';
            }
            return 'alert alert-secondary mb-0';
        }

        /**
         * Reset GCS modal
         */
        function resetGCSModal() {
            // Uncheck all radio buttons
            document.querySelectorAll('.gcs-check').forEach(radio => {
                radio.checked = false;
            });

            // Reset displays
            document.getElementById('gcs_eye_display').textContent = '-';
            document.getElementById('gcs_verbal_display').textContent = '-';
            document.getElementById('gcs_motor_display').textContent = '-';
            document.getElementById('gcs_total_display').innerHTML = '<strong>Total: - </strong>';
            document.getElementById('gcs_total_display').className = 'alert alert-info mb-0';
            document.getElementById('gcs_interpretation').textContent = 'Pilih semua komponen';
            document.getElementById('gcs_interpretation').className = 'alert alert-secondary mb-0';
        }



        // ============================================================================
        // SECTION 4: RISK ASSESSMENT (FALL & DECUBITUS)
        // ============================================================================
        
        /**
         * Initialize fall risk assessment handlers
         */
        function initializeFallRiskHandlers() {
            const risikoJatuhSkala = document.getElementById('risikoJatuhSkala');
            
            if (risikoJatuhSkala) {
                risikoJatuhSkala.addEventListener('change', function() {
                    showForm(this.value);
                });
                showForm(''); // Hide all forms initially
            }
        }

        /**
         * Initialize decubitus risk assessment handlers
         */
        function initializeDecubitusRiskHandlers() {
            const skalaDecubitusSelect = document.getElementById('skalaRisikoDekubitus');
            
            if (skalaDecubitusSelect) {
                skalaDecubitusSelect.addEventListener('change', function() {
                    showDecubitusForm(this.value);
                });
                showDecubitusForm(''); // Hide all forms initially
            }

            // Norton form handlers
            const formNorton = document.getElementById('formNorton');
            if (formNorton) {
                formNorton.querySelectorAll('select').forEach(select => {
                    select.addEventListener('change', () => updateDecubitusConclusion('norton'));
                });
            }

            // Braden form handlers
            const formBraden = document.getElementById('formBraden');
            if (formBraden) {
                formBraden.querySelectorAll('select').forEach(select => {
                    select.addEventListener('change', () => updateDecubitusConclusion('braden'));
                });
            }
        }

        // ============================================================================
        // SECTION 5: PSYCHOLOGICAL STATUS
        // ============================================================================
        
        /**
         * Initialize psychological status handlers
         */
        function initializePsychologicalStatusHandlers() {
            const btnKondisiPsikologis = document.getElementById('btnKondisiPsikologis');
            const btnGangguanPerilaku = document.getElementById('btnGangguanPerilaku');

            if (btnKondisiPsikologis) {
                btnKondisiPsikologis.addEventListener('click', () => toggleDropdown('dropdownKondisiPsikologis'));
            }

            if (btnGangguanPerilaku) {
                btnGangguanPerilaku.addEventListener('click', () => toggleDropdown('dropdownGangguanPerilaku'));
            }

            // Kondisi psikologis checkbox handlers
            document.querySelectorAll('.kondisi-options input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', handleKondisiPsikologis);
            });

            // Gangguan perilaku checkbox handlers
            document.querySelectorAll('.perilaku-options input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', handleGangguanPerilaku);
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.dropdown-wrapper')) {
                    const dropdownKondisi = document.getElementById('dropdownKondisiPsikologis');
                    const dropdownPerilaku = document.getElementById('dropdownGangguanPerilaku');
                    
                    if (dropdownKondisi) dropdownKondisi.style.display = 'none';
                    if (dropdownPerilaku) dropdownPerilaku.style.display = 'none';
                }
            });

            // Initialize
            handleKondisiPsikologis();
            handleGangguanPerilaku();
        }

        /**
         * Toggle dropdown visibility
         */
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                const isVisible = dropdown.style.display === 'block';
                dropdown.style.display = isVisible ? 'none' : 'block';
            }
        }

        /**
         * Handle kondisi psikologis checkboxes
         */
        function handleKondisiPsikologis() {
            const kondisiCheckboxes = document.querySelectorAll('.kondisi-options input[type="checkbox"]');
            const selectedItems = [];

            kondisiCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedItems.push(checkbox.value);
                }
            });

            updateSelectedItems('selectedKondisiPsikologis', selectedItems, 'kondisi');

            // Handle "Tidak ada kelainan" logic
            const noKelainanCheckbox = document.getElementById('kondisi1');
            if (noKelainanCheckbox && noKelainanCheckbox.checked) {
                kondisiCheckboxes.forEach(cb => {
                    if (cb !== noKelainanCheckbox) {
                        cb.checked = false;
                        cb.disabled = true;
                    }
                });
            } else {
                kondisiCheckboxes.forEach(cb => {
                    if (cb) cb.disabled = false;
                });
            }
        }

        /**
         * Handle gangguan perilaku checkboxes
         */
        function handleGangguanPerilaku() {
            const perilakuCheckboxes = document.querySelectorAll('.perilaku-options input[type="checkbox"]');
            const selectedItems = [];

            perilakuCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedItems.push(checkbox.value);
                }
            });

            updateSelectedItems('selectedGangguanPerilaku', selectedItems, 'perilaku');

            // Handle "Tidak Ada Gangguan" logic
            const noGangguanCheckbox = document.getElementById('perilaku1');
            if (noGangguanCheckbox && noGangguanCheckbox.checked) {
                perilakuCheckboxes.forEach(cb => {
                    if (cb !== noGangguanCheckbox) {
                        cb.checked = false;
                        cb.disabled = true;
                    }
                });
            } else {
                perilakuCheckboxes.forEach(cb => {
                    if (cb) cb.disabled = false;
                });
            }
        }

        /**
         * Update selected items display
         */
        function updateSelectedItems(containerId, items, type) {
            const container = document.getElementById(containerId);
            if (!container) return;

            container.innerHTML = items.map(item => `
                <div class="alert alert-light border d-flex justify-content-between align-items-center py-1 px-2 mb-1">
                    <span>${item}</span>
                    <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-2" 
                            onclick="removeItem('${containerId}', '${item}')">
                        <i class="bi bi-x" style="font-size: 1.2rem;"></i>
                    </button>
                </div>
            `).join('');

            const hiddenInputId = type === 'kondisi' ? 'kondisi_psikologis_json' : 'gangguan_perilaku_json';
            const hiddenInput = document.getElementById(hiddenInputId);
            if (hiddenInput) {
                hiddenInput.value = JSON.stringify(items);
            }
        }

        // ============================================================================
        // SECTION 6: NUTRITIONAL STATUS
        // ============================================================================
        
        /**
         * Initialize nutritional status handlers
         */
        function initializeNutritionalStatusHandlers() {
            const nutritionSelect = document.getElementById('nutritionAssessment');
            const allForms = document.querySelectorAll('.assessment-form');

            if (!nutritionSelect) return;

            nutritionSelect.addEventListener('change', function() {
                const selectedValue = this.value;

                // Hide all forms
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
                    const cannotAssessInput = document.getElementById('cannot-assess');
                    if (cannotAssessInput) cannotAssessInput.value = 'tidak ada status gizi';
                    return;
                }

                // Form mapping
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
            });
        }

        /**
         * Initialize form listeners for nutrition assessment
         */
        function initializeFormListeners(formId) {
            const form = document.getElementById(formId);
            if (!form) return;

            const selects = form.querySelectorAll('select');

            switch (formId) {
                case 'mst':
                    selects.forEach(select => {
                        select.addEventListener('change', () => calculateMSTScore(form));
                    });
                    break;
                case 'mna':
                    selects.forEach(select => {
                        select.addEventListener('change', () => calculateMNAScore(form));
                    });
                    initializeBMICalculation();
                    break;
                case 'strong-kids':
                    selects.forEach(select => {
                        select.addEventListener('change', () => calculateStrongKidsScore(form));
                    });
                    break;
                case 'nrs':
                    selects.forEach(select => {
                        select.addEventListener('change', () => calculateNRSScore(form));
                    });
                    break;
            }
        }

        /**
         * Calculate MST score
         */
        function calculateMSTScore() {
            const form = document.getElementById('mst');
            const selects = form.querySelectorAll('select');
            let total = 0;

            selects.forEach(select => {
                total += parseInt(select.value || 0);
            });

            const kesimpulan = total <= 1 ? 'Tidak berisiko malnutrisi' : 'Berisiko malnutrisi';
            const kesimpulanInput = document.getElementById('gizi_mst_kesimpulan');
            if (kesimpulanInput) kesimpulanInput.value = kesimpulan;

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

        /**
         * Calculate MNA score
         */
        function calculateMNAScore(form) {
            const selects = form.querySelectorAll('select[name^="gizi_mna_"]');
            let total = 0;

            selects.forEach(select => {
                const value = parseInt(select.value || 0);
                total += value;
            });

            const kesimpulan = total >= 12 ? '≥ 12 Tidak Beresiko' : '≤ 11 Beresiko malnutrisi';
            const kesimpulanInput = document.getElementById('gizi_mna_kesimpulan');
            if (kesimpulanInput) kesimpulanInput.value = kesimpulan;

            const conclusionDiv = document.getElementById('mnaConclusion');
            if (conclusionDiv) {
                const alertClass = total >= 12 ? 'alert-success' : 'alert-warning';
                conclusionDiv.innerHTML = `
                    <div class="alert ${alertClass}">
                        Kesimpulan: ${kesimpulan} (Total Score: ${total})
                    </div>
                    <input type="hidden" name="gizi_mna_kesimpulan" id="gizi_mna_kesimpulan" value="${kesimpulan}">
                `;
            }
        }

        /**
         * Calculate Strong Kids score
         */
        function calculateStrongKidsScore(form) {
            const selects = form.querySelectorAll('select');
            let total = 0;

            selects.forEach(select => {
                total += parseInt(select.value || 0);
            });

            let kesimpulan, kesimpulanText, type;
            if (total === 0) {
                kesimpulan = 'Beresiko rendah';
                kesimpulanText = '0 (Beresiko rendah)';
                type = 'success';
            } else if (total >= 1 && total <= 3) {
                kesimpulan = 'Beresiko sedang';
                kesimpulanText = '1-3 (Beresiko sedang)';
                type = 'warning';
            } else {
                kesimpulan = 'Beresiko Tinggi';
                kesimpulanText = '4-5 (Beresiko Tinggi)';
                type = 'danger';
            }

            const kesimpulanInput = document.getElementById('gizi_strong_kesimpulan');
            if (kesimpulanInput) kesimpulanInput.value = kesimpulanText;

            const conclusionDiv = document.getElementById('strongKidsConclusion');
            if (conclusionDiv) {
                conclusionDiv.innerHTML = `
                    <div class="alert alert-${type}">
                        Kesimpulan: ${kesimpulanText} (Total Score: ${total})
                    </div>
                    <input type="hidden" name="gizi_strong_kesimpulan" id="gizi_strong_kesimpulan" value="${kesimpulanText}">
                `;
            }

            updateFormConclusion(form, kesimpulan, type);
        }

        /**
         * Calculate NRS score
         */
        function calculateNRSScore(form) {
            const selects = form.querySelectorAll('select');
            let total = 0;

            selects.forEach(select => {
                total += parseInt(select.value || 0);
            });

            let kesimpulan, kesimpulanText, type;
            if (total <= 5) {
                kesimpulan = 'Beresiko rendah';
                kesimpulanText = '≤ 5 (Beresiko rendah)';
                type = 'success';
            } else if (total <= 10) {
                kesimpulan = 'Beresiko sedang';
                kesimpulanText = '6-10 (Beresiko sedang)';
                type = 'warning';
            } else {
                kesimpulan = 'Beresiko Tinggi';
                kesimpulanText = '> 10 (Beresiko Tinggi)';
                type = 'danger';
            }

            const kesimpulanInput = document.getElementById('gizi_nrs_kesimpulan');
            if (kesimpulanInput) kesimpulanInput.value = kesimpulanText;

            const conclusionDiv = document.getElementById('nrsConclusion');
            if (conclusionDiv) {
                conclusionDiv.innerHTML = `
                    <div class="alert alert-${type}">
                        Kesimpulan: ${kesimpulanText} (Total Score: ${total})
                    </div>
                    <input type="hidden" name="gizi_nrs_kesimpulan" id="gizi_nrs_kesimpulan" value="${kesimpulanText}">
                `;
            }

            updateFormConclusion(form, kesimpulan, type);
        }

        /**
         * Update form conclusion display
         */
        function updateFormConclusion(form, text, type) {
            const conclusions = form.querySelectorAll('.alert');
            conclusions.forEach(alert => {
                if (alert.classList.contains(`alert-${type}`)) {
                    alert.style.display = 'block';
                } else {
                    alert.style.display = 'none';
                }
            });

            const hiddenInput = form.querySelector('input[type="hidden"]');
            if (hiddenInput) {
                hiddenInput.value = text;
            }
        }

        /**
         * Initialize BMI calculation for MNA
         */
        function initializeBMICalculation() {
            const weightInput = document.getElementById('mnaWeight');
            const heightInput = document.getElementById('mnaHeight');
            const bmiInput = document.getElementById('mnaBMI');

            if (!weightInput || !heightInput || !bmiInput) return;

            function calculateBMI() {
                const weight = parseFloat(weightInput.value || 0);
                const height = parseFloat(heightInput.value || 0);

                if (weight > 0 && height > 0) {
                    const heightInMeters = height / 100;
                    const bmi = weight / (heightInMeters * heightInMeters);
                    bmiInput.value = bmi.toFixed(2);
                } else {
                    bmiInput.value = '';
                }
            }

            weightInput.addEventListener('input', calculateBMI);
            heightInput.addEventListener('input', calculateBMI);
        }

        // ============================================================================
        // SECTION 7: FUNCTIONAL STATUS (ADL)
        // ============================================================================
        
        /**
         * Initialize functional status handlers
         */
        function initializeFunctionalStatusHandlers() {
            const statusFungsionalSelect = document.getElementById('skala_fungsional');
            const adlTotal = document.getElementById('adl_total');
            const adlKesimpulanAlert = document.getElementById('adl_kesimpulan');

            if (!statusFungsionalSelect) return;

            statusFungsionalSelect.addEventListener('change', function() {
                if (this.value === 'Pengkajian Aktivitas') {
                    adlTotal.value = '';
                    adlKesimpulanAlert.className = 'alert alert-info';
                    adlKesimpulanAlert.textContent = 'Pilih skala aktivitas harian terlebih dahulu';
                    
                    const modal = new bootstrap.Modal(document.getElementById('modalADL'));
                    modal.show();
                } else if (this.value === 'Lainnya') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Skala pengukuran lainnya belum tersedia',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    }).then(() => {
                        this.value = '';
                        adlTotal.value = '';
                        adlKesimpulanAlert.className = 'alert alert-info';
                        adlKesimpulanAlert.textContent = 'Pilih skala aktivitas harian terlebih dahulu';
                    });
                }
            });

            initializeADLHandlers(adlTotal, adlKesimpulanAlert);
        }

        /**
         * Initialize ADL handlers
         */
        function initializeADLHandlers(adlTotal, adlKesimpulanAlert) {
            const updateADLTotal = () => {
                const adlChecks = document.querySelectorAll('.adl-check:checked');
                const adlModalTotal = document.getElementById('adlTotal');
                const adlModalKesimpulan = document.getElementById('adlKesimpulan');
                
                let total = 0;
                adlChecks.forEach(check => {
                    total += parseInt(check.value);
                });
                
                if (adlModalTotal) adlModalTotal.value = total;

                const checkedCategories = new Set(Array.from(adlChecks).map(check => check.getAttribute('data-category')));
                const allCategoriesSelected = checkedCategories.size === 3;

                if (!allCategoriesSelected) {
                    if (adlModalKesimpulan) {
                        adlModalKesimpulan.className = 'alert alert-info py-1 px-3 mb-0';
                        adlModalKesimpulan.textContent = 'Pilih semua kategori terlebih dahulu';
                    }
                    return;
                }

                let kesimpulan, alertClass;
                
                if (total <= 4) {
                    kesimpulan = 'Mandiri';
                    alertClass = 'alert-success';
                } else if (total <= 8) {
                    kesimpulan = 'Ketergantungan Ringan';
                    alertClass = 'alert-info';
                } else if (total <= 11) {
                    kesimpulan = 'Ketergantungan Sedang';
                    alertClass = 'alert-warning';
                } else {
                    kesimpulan = 'Ketergantungan Berat';
                    alertClass = 'alert-danger';
                }

                if (adlModalKesimpulan) {
                    adlModalKesimpulan.className = `alert ${alertClass} py-1 px-3 mb-0`;
                    adlModalKesimpulan.textContent = kesimpulan;
                }
            };

            document.querySelectorAll('.adl-check').forEach(check => {
                check.addEventListener('change', updateADLTotal);
            });

            const simpanADL = document.getElementById('simpanADL');
            if (simpanADL) {
                simpanADL.addEventListener('click', function() {
                    const adlModalTotal = document.getElementById('adlTotal');
                    const adlModalKesimpulan = document.getElementById('adlKesimpulan');
                    
                    if (adlModalTotal && adlModalTotal.value !== '' && adlKesimpulanAlert) {
                        adlTotal.value = adlModalTotal.value;
                        adlKesimpulanAlert.className = adlModalKesimpulan.className.replace('py-1 px-3 mb-0', '');
                        adlKesimpulanAlert.textContent = adlModalKesimpulan.textContent;
                        
                        const adlValues = getSelectedADLValues();
                        updateADLHiddenInputs(adlValues, adlModalKesimpulan.textContent);
                        
                        bootstrap.Modal.getInstance(document.getElementById('modalADL')).hide();
                    }
                });
            }
        }

        /**
         * Get selected ADL values
         */
        function getSelectedADLValues() {
            const makanValue = document.querySelector('input[name="makan"]:checked')?.value || '';
            const berjalanValue = document.querySelector('input[name="berjalan"]:checked')?.value || '';
            const mandiValue = document.querySelector('input[name="mandi"]:checked')?.value || '';
            
            const getTextValue = (value) => {
                switch (value) {
                    case '1': return 'Mandiri';
                    case '2': return '25% Dibantu';
                    case '3': return '50% Dibantu';
                    case '4': return '75% Dibantu';
                    default: return '';
                }
            };
            
            return {
                makan: getTextValue(makanValue),
                makanValue: makanValue,
                berjalan: getTextValue(berjalanValue),
                berjalanValue: berjalanValue,
                mandi: getTextValue(mandiValue),
                mandiValue: mandiValue
            };
        }

        /**
         * Update ADL hidden inputs
         */
        function updateADLHiddenInputs(adlValues, kesimpulan) {
            const hiddenInputs = {
                'adl_makan': adlValues.makan,
                'adl_makan_value': adlValues.makanValue,
                'adl_berjalan': adlValues.berjalan,
                'adl_berjalan_value': adlValues.berjalanValue,
                'adl_mandi': adlValues.mandi,
                'adl_mandi_value': adlValues.mandiValue,
                'adl_kesimpulan_value': kesimpulan,
                'adl_jenis_skala': '1'
            };

            Object.entries(hiddenInputs).forEach(([id, value]) => {
                const input = document.getElementById(id);
                if (input) input.value = value;
            });
        }

        // ============================================================================
        // SECTION 8: DISCHARGE PLANNING
        // ============================================================================
        
        /**
         * Initialize discharge planning handlers
         */
        function initializeDischargePlanningHandlers() {
            const dischargePlanningSection = document.getElementById('discharge-planning');
            if (!dischargePlanningSection) return;

            const allSelects = dischargePlanningSection.querySelectorAll('select');
            const alertWarning = dischargePlanningSection.querySelector('.alert-warning');
            const alertSuccess = dischargePlanningSection.querySelector('.alert-success');
            const alertInfo = dischargePlanningSection.querySelector('.alert-info');

            function updateDischargePlanningConclusion() {
                let needsSpecialPlan = false;
                let allSelected = true;
                const kesimpulanInput = document.getElementById('kesimpulan');

                allSelects.forEach(select => {
                    if (!select.value) {
                        allSelected = false;
                    } else if (select.value === 'ya') {
                        needsSpecialPlan = true;
                    }
                });

                if (!allSelected) {
                    if (alertInfo) alertInfo.style.display = 'block';
                    if (alertWarning) alertWarning.style.display = 'none';
                    if (alertSuccess) alertSuccess.style.display = 'none';
                    if (kesimpulanInput) kesimpulanInput.value = 'Pilih semua Planning';
                    return;
                }

                if (needsSpecialPlan) {
                    if (alertWarning) alertWarning.style.display = 'block';
                    if (alertSuccess) alertSuccess.style.display = 'none';
                    if (alertInfo) alertInfo.style.display = 'none';
                    if (kesimpulanInput) kesimpulanInput.value = 'Mebutuhkan rencana pulang khusus';
                } else {
                    if (alertWarning) alertWarning.style.display = 'none';
                    if (alertSuccess) alertSuccess.style.display = 'block';
                    if (alertInfo) alertInfo.style.display = 'none';
                    if (kesimpulanInput) kesimpulanInput.value = 'Tidak mebutuhkan rencana pulang khusus';
                }
            }

            allSelects.forEach(select => {
                select.addEventListener('change', updateDischargePlanningConclusion);
            });

            updateDischargePlanningConclusion();
        }


        // ============================================================================
        // SECTION 9: EVLAUASI
        // ============================================================================
        /**
         * Initialize diagnosis keperawatan handlers
         */
        function initializeDiagnosisKeperawatanHandlers() {
            const btnTambahMasalah = document.getElementById('btnTambahMasalah');
            const btnTambahIntervensi = document.getElementById('btnTambahIntervensi');
            const masalahContainer = document.getElementById('masalahContainer');
            const intervensiContainer = document.getElementById('intervensiContainer');
            
            if (!btnTambahMasalah || !btnTambahIntervensi || !masalahContainer || !intervensiContainer) return;

            // Add masalah field
            btnTambahMasalah.addEventListener('click', function() {
                addMasalahField();
                updateMasalahRemoveButtons();
            });

            // Add intervensi field
            btnTambahIntervensi.addEventListener('click', function() {
                addIntervensiField();
                updateIntervensiRemoveButtons();
            });

            /**
             * Add new masalah field
             */
            function addMasalahField() {
                const newField = document.createElement('div');
                newField.className = 'masalah-item mb-2';
                newField.innerHTML = `
                    <div class="d-flex gap-2">
                        <textarea class="form-control" name="masalah_diagnosis[]" rows="2" 
                                placeholder="Tuliskan masalah atau diagnosis keperawatan..."></textarea>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-masalah" onclick="removeMasalah(this)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
                masalahContainer.appendChild(newField);
            }

            /**
             * Add new intervensi field
             */
            function addIntervensiField() {
                const newField = document.createElement('div');
                newField.className = 'intervensi-item mb-2';
                newField.innerHTML = `
                    <div class="d-flex gap-2">
                        <textarea class="form-control" name="intervensi_rencana[]" rows="3" 
                                placeholder="Tuliskan intervensi, rencana asuhan, dan target yang terukur..."></textarea>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-intervensi" onclick="removeIntervensi(this)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
                intervensiContainer.appendChild(newField);
            }

            /**
             * Update masalah remove button visibility
             */
            function updateMasalahRemoveButtons() {
                const masalahItems = masalahContainer.querySelectorAll('.masalah-item');
                masalahItems.forEach(item => {
                    const removeBtn = item.querySelector('.remove-masalah');
                    if (removeBtn) {
                        removeBtn.style.display = masalahItems.length > 1 ? 'block' : 'none';
                    }
                });
            }

            /**
             * Update intervensi remove button visibility
             */
            function updateIntervensiRemoveButtons() {
                const intervensiItems = intervensiContainer.querySelectorAll('.intervensi-item');
                intervensiItems.forEach(item => {
                    const removeBtn = item.querySelector('.remove-intervensi');
                    if (removeBtn) {
                        removeBtn.style.display = intervensiItems.length > 1 ? 'block' : 'none';
                    }
                });
            }

            /**
             * Remove masalah field (global function)
             */
            window.removeMasalah = function(button) {
                const masalahItem = button.closest('.masalah-item');
                const masalahItems = masalahContainer.querySelectorAll('.masalah-item');
                
                // Don't remove if it's the only field
                if (masalahItems.length <= 1) {
                    showToast('warning', 'Minimal harus ada satu masalah diagnosis');
                    return;
                }
                
                masalahItem.remove();
                updateMasalahRemoveButtons();
                showToast('success', 'Masalah diagnosis berhasil dihapus');
            };

            /**
             * Remove intervensi field (global function)
             */
            window.removeIntervensi = function(button) {
                const intervensiItem = button.closest('.intervensi-item');
                const intervensiItems = intervensiContainer.querySelectorAll('.intervensi-item');
                
                // Don't remove if it's the only field
                if (intervensiItems.length <= 1) {
                    showToast('warning', 'Minimal harus ada satu intervensi rencana');
                    return;
                }
                
                intervensiItem.remove();
                updateIntervensiRemoveButtons();
                showToast('success', 'Intervensi rencana berhasil dihapus');
            };

            // Initial setup
            updateMasalahRemoveButtons();
            updateIntervensiRemoveButtons();
        }

        // ============================================================================
        // GLOBAL UTILITY FUNCTIONS
        // ============================================================================

        /**
         * Show form for fall risk assessment
         */
        function showForm(formType) {
            document.querySelectorAll('.risk-form').forEach(form => {
                form.style.display = 'none';
            });

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
                    backdrop: 'rgba(244, 244, 244, 0.7)'
                });
                const skalaLainnyaInput = document.getElementById('skala_lainnya');
                if (skalaLainnyaInput) skalaLainnyaInput.value = 'resiko jatuh lainnya';
                return;
            }

            const formMapping = {
                '1': 'skala_umumForm',
                '2': 'skala_morseForm',
                '3': 'skala_humptyForm',
                '4': 'skala_ontarioForm'
            };

            if (formType && formMapping[formType]) {
                const selectedForm = document.getElementById(formMapping[formType]);
                if (selectedForm) {
                    selectedForm.style.display = 'block';
                    resetForm(selectedForm);
                }
            }
        }

        /**
         * Reset fall risk form
         */
        function resetForm(form) {
            form.querySelectorAll('select').forEach(select => select.value = '');
            const formType = form.id.replace('skala_', '').replace('Form', '');
            const conclusionDiv = form.querySelector('.conclusion');
            const defaultConclusion = formType === 'umum' ? 'Tidak berisiko jatuh' : 'Risiko Rendah';

            if (conclusionDiv) {
                conclusionDiv.className = 'conclusion bg-success';
                const conclusionSpan = conclusionDiv.querySelector('p span');
                if (conclusionSpan) conclusionSpan.textContent = defaultConclusion;

                const hiddenInput = conclusionDiv.querySelector('input[type="hidden"]');
                if (hiddenInput) hiddenInput.value = defaultConclusion;
            }
        }

        /**
         * Update fall risk conclusion
         */
        function updateConclusion(formType) {
            const form = document.getElementById('skala_' + formType + 'Form');
            const selects = form.querySelectorAll('select');
            let score = 0;
            let hasYes = false;

            selects.forEach(select => {
                if (select.value === '1') {
                    hasYes = true;
                }
                score += parseInt(select.value) || 0;
            });

            const conclusionDiv = form.querySelector('.conclusion');
            const conclusionSpan = conclusionDiv.querySelector('#kesimpulanTextForm');
            const conclusionInput = conclusionDiv.querySelector('input[type="hidden"]');
            let conclusion = '';
            let bgClass = '';

            switch (formType) {
                case 'umum':
                    if (hasYes) {
                        conclusion = 'Berisiko jatuh';
                        bgClass = 'bg-danger';
                    } else {
                        conclusion = 'Tidak berisiko jatuh';
                        bgClass = 'bg-success';
                    }
                    if (conclusionInput) conclusionInput.value = conclusion;
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
                    const morseInput = document.getElementById('risiko_jatuh_morse_kesimpulan');
                    if (morseInput) morseInput.value = conclusion;
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
                    const humptyInput = document.getElementById('risiko_jatuh_pediatrik_kesimpulan');
                    if (humptyInput) humptyInput.value = conclusion;
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
                    const ontarioInput = document.getElementById('risiko_jatuh_lansia_kesimpulan');
                    if (ontarioInput) ontarioInput.value = conclusion;
                    break;
            }

            if (conclusionDiv) {
                conclusionDiv.className = 'conclusion ' + bgClass;
                if (conclusionSpan) conclusionSpan.textContent = conclusion;
            }
        }

        /**
         * Show decubitus form
         */
        function showDecubitusForm(formType) {
            document.querySelectorAll('.decubitus-form').forEach(form => {
                form.style.display = 'none';
            });

            let formElement = null;
            if (formType === 'norton') {
                formElement = document.getElementById('formNorton');
            } else if (formType === 'braden') {
                formElement = document.getElementById('formBraden');
            }

            if (formElement) {
                formElement.style.display = 'block';
                resetDecubitusForm(formElement);
            }
        }

        /**
         * Reset decubitus form
         */
        function resetDecubitusForm(form) {
            if (!form) return;
            
            form.querySelectorAll('select').forEach(select => select.value = '');
            const kesimpulanDiv = form.querySelector('#kesimpulanNorton');
            if (kesimpulanDiv) {
                kesimpulanDiv.className = 'alert alert-success mb-0 flex-grow-1';
                kesimpulanDiv.textContent = 'Risiko Rendah';
            }
        }

        /**
         * Update decubitus conclusion
         */
        function updateDecubitusConclusion(formType) {
            const form = document.getElementById('form' + formType.charAt(0).toUpperCase() + formType.slice(1));
            if (!form) return;

            const kesimpulanDiv = form.querySelector('#kesimpulanNorton');
            if (!kesimpulanDiv) return;

            if (formType === 'norton') {
                let total = 0;
                let allFilled = true;
                const fields = ['kondisi_fisik', 'kondisi_mental', 'norton_aktivitas', 'norton_mobilitas', 'inkontinensia'];

                fields.forEach(field => {
                    const select = form.querySelector(`select[name="${field}"]`);
                    if (!select || !select.value) {
                        allFilled = false;
                        return;
                    }
                    total += parseInt(select.value);
                });

                if (!allFilled) {
                    kesimpulanDiv.className = 'alert alert-info mb-0 flex-grow-1';
                    kesimpulanDiv.textContent = 'Pilih semua kriteria untuk melihat kesimpulan';
                    return;
                }

                let conclusion = '';
                let alertClass = '';

                if (total <= 12) {
                    conclusion = 'Risiko Tinggi';
                    alertClass = 'alert-danger';
                } else if (total <= 14) {
                    conclusion = 'Risiko Sedang';
                    alertClass = 'alert-warning';
                } else {
                    conclusion = 'Risiko Rendah';
                    alertClass = 'alert-success';
                }

                conclusion += ` (Skor: ${total})`;
                kesimpulanDiv.className = `alert ${alertClass} mb-0 flex-grow-1`;
                kesimpulanDiv.textContent = conclusion;
            }
            else if (formType === 'braden') {
                let total = 0;
                let allFilled = true;
                const fields = ['persepsi_sensori', 'kelembapan', 'braden_aktivitas', 'braden_mobilitas', 'nutrisi', 'pergesekan'];

                fields.forEach(field => {
                    const select = form.querySelector(`select[name="${field}"]`);
                    if (!select || !select.value) {
                        allFilled = false;
                        return;
                    }
                    total += parseInt(select.value);
                });

                if (!allFilled) {
                    kesimpulanDiv.className = 'alert alert-info mb-0 flex-grow-1';
                    kesimpulanDiv.textContent = 'Pilih semua kriteria untuk melihat kesimpulan';
                    return;
                }

                let conclusion = '';
                let alertClass = '';

                if (total <= 12) {
                    conclusion = 'Risiko Tinggi';
                    alertClass = 'alert-danger';
                } else if (total <= 16) {
                    conclusion = 'Risiko Sedang';
                    alertClass = 'alert-warning';
                } else {
                    conclusion = 'Risiko Rendah';
                    alertClass = 'alert-success';
                }

                conclusion += ` (Skor: ${total})`;
                kesimpulanDiv.className = `alert ${alertClass} mb-0 flex-grow-1`;
                kesimpulanDiv.textContent = conclusion;
            }
        }

        /**
         * Remove selected psychological item
         */
        function removeItem(containerId, item) {
            const container = document.getElementById(containerId);
            
            if (containerId === 'selectedKondisiPsikologis') {
                document.querySelectorAll('.kondisi-options input[type="checkbox"]').forEach(checkbox => {
                    if (checkbox.value === item) {
                        checkbox.checked = false;
                        const event = new Event('change');
                        checkbox.dispatchEvent(event);
                    }
                });
            } else if (containerId === 'selectedGangguanPerilaku') {
                document.querySelectorAll('.perilaku-options input[type="checkbox"]').forEach(checkbox => {
                    if (checkbox.value === item) {
                        checkbox.checked = false;
                        const event = new Event('change');
                        checkbox.dispatchEvent(event);
                    }
                });
            }
        }

        // Make functions globally available
        window.showForm = showForm;
        window.updateConclusion = updateConclusion;
        window.showDecubitusForm = showDecubitusForm;
        window.updateDecubitusConclusion = updateDecubitusConclusion;
        window.removeItem = removeItem;
    </script>
@endpush