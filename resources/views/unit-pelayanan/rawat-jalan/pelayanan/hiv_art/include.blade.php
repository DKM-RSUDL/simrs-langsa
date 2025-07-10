@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-section {
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
        }

        .section-header {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-bottom: 1px solid #dee2e6;
            font-weight: bold;
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .patient-id-boxes {
            display: flex;
            gap: 5px;
        }

        .id-box {
            width: 30px;
            height: 30px;
            text-align: center;
            border: 1px solid #ccc;
        }

        .vital-signs-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .vital-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Animation styles */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .was-validated .form-control:invalid {
            border-color: #dc3545;
        }

        .was-validated .form-control:valid {
            border-color: #198754;
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ===== BAGIAN 1: Entry Point Handlers =====
            function handleRadioWithDetails(radioId, detailsId) {
                const radio = document.getElementById(radioId);
                const details = document.getElementById(detailsId);

                console.log('Setting up handler for:', radioId, detailsId);
                console.log('Radio found:', radio);
                console.log('Details found:', details);

                if (radio && details) {
                    radio.addEventListener('change', function () {
                        console.log('Radio changed:', radioId, this.checked);
                        if (this.checked) {
                            details.classList.remove('d-none');
                        } else {
                            details.classList.add('d-none');
                            const textarea = details.querySelector('textarea');
                            if (textarea) {
                                textarea.value = '';
                            }
                        }
                    });
                } else {
                    console.warn('Element not found:', radioId, detailsId);
                }
            }

            // Function to hide all detail sections when other radio buttons are selected
            function hideAllDetailsExcept(exceptId) {
                const detailSections = ['rujukan-details', 'jangkauan-details', 'lainnya-kia-details'];
                detailSections.forEach(sectionId => {
                    if (sectionId !== exceptId) {
                        const section = document.getElementById(sectionId);
                        if (section) {
                            section.classList.add('d-none');
                            const textarea = section.querySelector('textarea');
                            if (textarea) {
                                textarea.value = '';
                            }
                        }
                    }
                });
            }

            // Enhanced radio handler that also hides other details
            function handleRadioWithDetailsEnhanced(radioId, detailsId) {
                const radio = document.getElementById(radioId);
                const details = document.getElementById(detailsId);

                if (radio && details) {
                    radio.addEventListener('change', function () {
                        if (this.checked) {
                            // Hide all other detail sections first
                            hideAllDetailsExcept(detailsId);
                            // Then show this one
                            details.classList.remove('d-none');
                        }
                    });
                }
            }

            // Initialize entry point handlers with enhanced functionality
            handleRadioWithDetailsEnhanced('kia_rujukan_jalan_tb', 'rujukan-details');
            handleRadioWithDetailsEnhanced('kia_jangkauan', 'jangkauan-details');
            handleRadioWithDetailsEnhanced('kia_lainnya', 'lainnya-kia-details');

            // Handle other radio buttons that don't have details (hide all details when selected)
            const otherRadios = ['kia', 'kia_rawat_inap', 'kia_praktek_swasta', 'kia_lsm', 'kia_datang_sendiri'];
            otherRadios.forEach(radioId => {
                const radio = document.getElementById(radioId);
                if (radio) {
                    radio.addEventListener('change', function () {
                        if (this.checked) {
                            hideAllDetailsExcept(null); // Hide all details
                        }
                    });
                }
            });
        });

        // ===== Bagian : 4. Riwayat Terapi Antiretroviral =====
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Riwayat Terapi Antiretroviral script initialized');

            // Handle radio button change for "Pernah Menerima ART"
            const artRadios = document.querySelectorAll('input[name="menerima_art"]');
            const artDetails = document.getElementById('art_details');

            // Function to show/hide ART details
            function toggleArtDetails(show) {
                if (artDetails) {
                    if (show) {
                        artDetails.style.display = 'block';
                        artDetails.style.animation = 'fadeIn 0.3s ease-in';
                    } else {
                        artDetails.style.display = 'none';
                        // Clear form values when hiding
                        clearArtDetailsForm();
                    }
                }
            }

            // Function to clear ART details form
            function clearArtDetailsForm() {
                const inputs = artDetails.querySelectorAll('input, textarea');
                inputs.forEach(input => {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });
            }

            // Add event listeners to ART radio buttons
            artRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    console.log('ART radio changed:', this.value);
                    if (this.value === 'Ya') {
                        toggleArtDetails(true);
                    } else {
                        toggleArtDetails(false);
                    }
                });
            });

            // Debug: Log elements
            console.log('Elements found:');
            console.log('- artDetails:', artDetails);
            console.log('- artRadios:', artRadios.length);

            console.log('Riwayat Terapi Antiretroviral script initialized successfully');
        });

        // ===== Bagian : 2. Data Riwayat Pribadi untuk Faktor Risiko =====
        document.addEventListener('DOMContentLoaded', function () {
            // Handle checkbox "Lain-lainnya" dengan textarea
            const lainLainnyaCheckbox = document.getElementById('lain_lainnya');
            const lainLainnyaDetails = document.getElementById('lain-lainnya-details');

            if (lainLainnyaCheckbox && lainLainnyaDetails) {
                lainLainnyaCheckbox.addEventListener('change', function () {
                    if (this.checked) {
                        lainLainnyaDetails.classList.remove('d-none');
                    } else {
                        lainLainnyaDetails.classList.add('d-none');
                        const textarea = lainLainnyaDetails.querySelector('textarea');
                        if (textarea) {
                            textarea.value = '';
                        }
                    }
                });
            }
        });

        // ===== Bagian 6. Terapi ANtiretroviral (ART)
        let artSectionCounter = 1;

        // Handle "Lainnya" option for ART
        document.addEventListener('DOMContentLoaded', function () {
            setupArtSection(1);
        });

        function setupArtSection(sectionId) {
            const artRadios = document.querySelectorAll(`input[name="nama_paduan_art_${sectionId}"]`);
            const lainnyaDetails = document.getElementById(`lainnya-art-details-${sectionId}`);

            artRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === 'lainnya') {
                        lainnyaDetails.classList.remove('d-none');
                    } else {
                        lainnyaDetails.classList.add('d-none');
                        document.querySelector(`input[name="art_lainnya_${sectionId}"]`).value = '';
                    }
                });
            });
        }

        function addArtSection() {
            artSectionCounter++;
            const artSections = document.getElementById('artSections');

            // Create new section
            const newSection = document.createElement('div');
            newSection.className = 'art-section mb-4';
            newSection.setAttribute('data-section', artSectionCounter);

            // Determine border color
            const borderColors = ['primary', 'success', 'warning', 'info', 'secondary', 'danger'];
            const borderColor = borderColors[(artSectionCounter - 1) % borderColors.length];

            newSection.innerHTML = `
                    <div class="card border-start border-${borderColor} border-4">
                        <div class="card-header bg-body-secondary d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 text-${borderColor}">
                                <i class="fas fa-pills me-2"></i>
                                Terapi ART #${artSectionCounter}
                            </h6>
                            <button type="button" class="btn btn-outline-danger btn-sm remove-art-btn" onclick="removeArtSection(${artSectionCounter})">
                                <i class="fas fa-trash me-1"></i>
                                Hapus
                            </button>
                        </div>
                        <div class="card-body">
                            <!-- Nama Paduan ART -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Nama Paduan ART Original</label>
                                    <div class="bg-light-subtle">
                                        <div class="card-body p-3">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="nama_paduan_art_${artSectionCounter}" value="TDF+3TC+EFV" id="art1_${artSectionCounter}">
                                                <label class="form-check-label" for="art1_${artSectionCounter}">
                                                    1. TDF+3TC+EFV
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="nama_paduan_art_${artSectionCounter}" value="TDF+FTC+EFV" id="art2_${artSectionCounter}">
                                                <label class="form-check-label" for="art2_${artSectionCounter}">
                                                    2. TDF+FTC+EFV
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="nama_paduan_art_${artSectionCounter}" value="TDF+3TC+NVP" id="art3_${artSectionCounter}">
                                                <label class="form-check-label" for="art3_${artSectionCounter}">
                                                    3. TDF+3TC+NVP
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="nama_paduan_art_${artSectionCounter}" value="TDF+FTC+NVP" id="art4_${artSectionCounter}">
                                                <label class="form-check-label" for="art4_${artSectionCounter}">
                                                    4. TDF+FTC+NVP
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="nama_paduan_art_${artSectionCounter}" value="AZT+3TC+EFV" id="art5_${artSectionCounter}">
                                                <label class="form-check-label" for="art5_${artSectionCounter}">
                                                    5. AZT+3TC+EFV
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="nama_paduan_art_${artSectionCounter}" value="AZT+3TC+NVP" id="art6_${artSectionCounter}">
                                                <label class="form-check-label" for="art6_${artSectionCounter}">
                                                    6. AZT+3TC+NVP
                                                </label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="nama_paduan_art_${artSectionCounter}" value="lainnya" id="art7_${artSectionCounter}">
                                                <label class="form-check-label" for="art7_${artSectionCounter}">
                                                    7. Lainnya
                                                </label>
                                            </div>
                                            <div id="lainnya-art-details-${artSectionCounter}" class="d-none">
                                                <input type="text" name="art_lainnya_${artSectionCounter}" class="form-control form-control-sm" placeholder="Sebutkan nama paduan ART lainnya">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label fw-bold">SUBSTITUSI dalam lini-1, SWITCH ke lini-2, STOP</label>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Tanggal</label>
                                            <input type="date" name="substitusi_tanggal_${artSectionCounter}" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Substitusi</label>
                                            <input type="text" name="substitusi_${artSectionCounter}" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Switch</label>
                                            <input type="text" name="switch_${artSectionCounter}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Stop</label>
                                            <input type="text" name="stop_${artSectionCounter}" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Restart</label>
                                            <input type="text" name="restart_${artSectionCounter}" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Alasan</label>
                                            <select name="alasan_${artSectionCounter}" class="form-select">
                                                <option value="">Pilih alasan</option>
                                                <option value="1">1. Toksisitas/efek samping</option>
                                                <option value="2">2. Hamil</option>
                                                <option value="3">3. Risiko hamil</option>
                                                <option value="4">4. TB baru</option>
                                                <option value="5">5. Ada obat baru</option>
                                                <option value="6">6. Stok obat habis</option>
                                                <option value="7">7. Alasan lain</option>
                                                <option value="8">8. Gagal pengobatan klinis</option>
                                                <option value="9">9. Gagal imunologis</option>
                                                <option value="10">10. Gagal virologis</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Nama Paduan Baru</label>
                                            <input type="text" name="nama_paduan_baru_${artSectionCounter}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

            artSections.appendChild(newSection);
            setupArtSection(artSectionCounter);

            // Show remove buttons if more than 1 section
            updateRemoveButtons();
        }

        function removeArtSection(sectionId) {
            const section = document.querySelector(`[data-section="${sectionId}"]`);
            if (section) {
                section.remove();
                updateRemoveButtons();
            }
        }

        function updateRemoveButtons() {
            const sections = document.querySelectorAll('.art-section');
            const removeButtons = document.querySelectorAll('.remove-art-btn');

            if (sections.length > 1) {
                removeButtons.forEach(btn => btn.classList.remove('d-none'));
            } else {
                removeButtons.forEach(btn => btn.classList.add('d-none'));
            }
        }

        // ===== Bagian : 7. Pengobatan TB selama perawatan HIV
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Bootstrap tooltips
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

            // Handle TB Ekstra Paru selection
            const tbEkstraParu = document.getElementById('tb_ekstra_paru');
            const lokasiTbEkstra = document.getElementById('lokasi_tb_ekstra');
            const klasifikasiTbRadios = document.querySelectorAll('input[name="klasifikasi_tb"]');

            klasifikasiTbRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === 'tb_ekstra_paru') {
                        lokasiTbEkstra.classList.remove('d-none');
                    } else {
                        lokasiTbEkstra.classList.add('d-none');
                        document.querySelector('input[name="lokasi_tb_ekstra"]').value = '';
                    }
                });
            });

            // Auto-format date inputs
            const dateInputs = document.querySelectorAll('input[type="number"][name*="tgl_"]');
            dateInputs.forEach(input => {
                input.addEventListener('input', function () {
                    // Auto-move to next field when max length reached
                    if (this.value.length >= parseInt(this.getAttribute('maxlength'))) {
                        const nextInput = this.closest('.col-3, .col-4').nextElementSibling?.querySelector('input');
                        if (nextInput) {
                            nextInput.focus();
                        }
                    }
                });
            });

            // Calculate treatment duration when both dates are filled
            function calculateDuration() {
                const mulaiDD = document.querySelector('input[name="tgl_mulai_dd"]').value;
                const mulaiMM = document.querySelector('input[name="tgl_mulai_mm"]').value;
                const mulaiYYYY = document.querySelector('input[name="tgl_mulai_yyyy"]').value;
                const selesaiDD = document.querySelector('input[name="tgl_selesai_dd"]').value;
                const selesaiMM = document.querySelector('input[name="tgl_selesai_mm"]').value;
                const selesaiYYYY = document.querySelector('input[name="tgl_selesai_yyyy"]').value;

                if (mulaiDD && mulaiMM && mulaiYYYY && selesaiDD && selesaiMM && selesaiYYYY) {
                    const startDate = new Date(mulaiYYYY, mulaiMM - 1, mulaiDD);
                    const endDate = new Date(selesaiYYYY, selesaiMM - 1, selesaiDD);
                    const diffTime = Math.abs(endDate - startDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    const diffMonths = Math.floor(diffDays / 30);

                    if (diffDays > 0) {
                        showDurationInfo(diffDays, diffMonths);
                    }
                }
            }

            function showDurationInfo(days, months) {
                const existingInfo = document.getElementById('duration-info');
                if (existingInfo) {
                    existingInfo.remove();
                }

                const durationDiv = document.createElement('div');
                durationDiv.id = 'duration-info';
                durationDiv.className = 'alert alert-success mt-3';
                durationDiv.innerHTML = `
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calculator me-2"></i>
                            <strong>Durasi Pengobatan: ${days} hari (${months} bulan)</strong>
                        </div>
                    `;

                document.querySelector('.card-body').appendChild(durationDiv);
            }

            // Add event listeners for date calculation
            dateInputs.forEach(input => {
                input.addEventListener('blur', calculateDuration);
            });
        });
    </script>
@endpush