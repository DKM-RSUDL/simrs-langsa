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
            console.log('ART Form scripts loaded...');

            // ===== VARIABLES =====
            let artSectionCounter = 1;

            // Count existing sections
            const existingSections = document.querySelectorAll('.art-section');
            if (existingSections.length > 0) {
                artSectionCounter = existingSections.length;
            }

            console.log('Initial section counter:', artSectionCounter);

            // ===== FUNCTION: Collect ART Data =====
            function collectArtData() {
                const artSections = document.querySelectorAll('.art-section');
                const artData = [];

                console.log('Collecting ART data from', artSections.length, 'sections');

                artSections.forEach((section, index) => {
                    const sectionNumber = section.getAttribute('data-section') || (index + 1);

                    // Get all data from this section
                    const namaPaduanArt = document.querySelector(`input[name="nama_paduan_art_${sectionNumber}"]:checked`)?.value || '';
                    const artLainnya = document.querySelector(`input[name="art_lainnya_${sectionNumber}"]`)?.value || '';
                    const substitusiTanggal = document.querySelector(`input[name="substitusi_tanggal_${sectionNumber}"]`)?.value || '';
                    const substitusi = document.querySelector(`input[name="substitusi_${sectionNumber}"]`)?.value || '';
                    const switchData = document.querySelector(`input[name="switch_${sectionNumber}"]`)?.value || '';
                    const stop = document.querySelector(`input[name="stop_${sectionNumber}"]`)?.value || '';
                    const restart = document.querySelector(`input[name="restart_${sectionNumber}"]`)?.value || '';
                    const alasan = document.querySelector(`select[name="alasan_${sectionNumber}"]`)?.value || '';
                    const namaPaduanBaru = document.querySelector(`input[name="nama_paduan_baru_${sectionNumber}"]`)?.value || '';

                    // Only add if there's at least some data
                    if (namaPaduanArt || substitusiTanggal || substitusi || switchData || stop || restart || alasan || namaPaduanBaru) {
                        const artSection = {
                            nama_paduan_art: namaPaduanArt,
                            art_lainnya: namaPaduanArt === 'lainnya' ? artLainnya : '',
                            substitusi_tanggal: substitusiTanggal,
                            substitusi: substitusi,
                            switch: switchData,
                            stop: stop,
                            restart: restart,
                            alasan: alasan,
                            nama_paduan_baru: namaPaduanBaru
                        };
                        artData.push(artSection);
                    }
                });

                // Convert to appropriate format
                let finalData;
                if (artData.length === 1) {
                    // Single object format to match your DB structure
                    finalData = artData[0];
                } else if (artData.length > 1) {
                    // Array format
                    finalData = artData;
                } else {
                    // Empty object
                    finalData = {};
                }

                const jsonData = JSON.stringify(finalData);
                console.log('Collected ART data:', jsonData);

                // Update hidden input
                const hiddenInput = document.getElementById('dataARTInput') || document.querySelector('input[name="data_terapi_art"]');
                if (hiddenInput) {
                    hiddenInput.value = jsonData;
                }

                return finalData;
            }

            // ===== FUNCTION: Setup ART Section =====
            function setupArtSection(sectionId) {
                console.log('Setting up ART section:', sectionId);

                const artRadios = document.querySelectorAll(`input[name="nama_paduan_art_${sectionId}"]`);
                const lainnyaDetails = document.getElementById(`lainnya-art-details-${sectionId}`);

                if (artRadios.length > 0 && lainnyaDetails) {
                    artRadios.forEach(radio => {
                        radio.addEventListener('change', function () {
                            if (this.value === 'lainnya') {
                                lainnyaDetails.classList.remove('d-none');
                                const lainnyaInput = lainnyaDetails.querySelector('input');
                                if (lainnyaInput) {
                                    setTimeout(() => lainnyaInput.focus(), 100);
                                }
                            } else {
                                lainnyaDetails.classList.add('d-none');
                                const input = lainnyaDetails.querySelector('input');
                                if (input) {
                                    input.value = '';
                                }
                            }
                            // Auto collect data
                            collectArtData();
                        });
                    });
                }

                // Setup auto-save for all inputs
                const inputs = document.querySelectorAll(`
                input[name^="substitusi_tanggal_${sectionId}"],
                input[name^="substitusi_${sectionId}"],
                input[name^="switch_${sectionId}"],
                input[name^="stop_${sectionId}"],
                input[name^="restart_${sectionId}"],
                input[name^="nama_paduan_baru_${sectionId}"],
                input[name^="art_lainnya_${sectionId}"],
                select[name^="alasan_${sectionId}"]
            `);

                inputs.forEach(input => {
                    input.addEventListener('change', collectArtData);
                    input.addEventListener('blur', collectArtData);
                });
            }

            // ===== FUNCTION: Add New ART Section =====
            window.addArtSection = function () {
                artSectionCounter++;
                const artSections = document.getElementById('artSections');

                if (!artSections) {
                    console.error('artSections container not found');
                    return;
                }

                const borderColors = ['primary', 'success', 'warning', 'info', 'secondary', 'danger'];
                const borderColor = borderColors[(artSectionCounter - 1) % borderColors.length];

                const newSection = document.createElement('div');
                newSection.className = 'art-section mb-4';
                newSection.setAttribute('data-section', artSectionCounter);
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
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Nama Paduan ART Original</label>
                                <div class="bg-light-subtle">
                                    <div class="card-body p-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="nama_paduan_art_${artSectionCounter}" value="TDF+3TC+EFV" id="art1_${artSectionCounter}">
                                            <label class="form-check-label" for="art1_${artSectionCounter}">1. TDF+3TC+EFV</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="nama_paduan_art_${artSectionCounter}" value="TDF+FTC+EFV" id="art2_${artSectionCounter}">
                                            <label class="form-check-label" for="art2_${artSectionCounter}">2. TDF+FTC+EFV</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="nama_paduan_art_${artSectionCounter}" value="TDF+3TC+NVP" id="art3_${artSectionCounter}">
                                            <label class="form-check-label" for="art3_${artSectionCounter}">3. TDF+3TC+NVP</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="nama_paduan_art_${artSectionCounter}" value="TDF+FTC+NVP" id="art4_${artSectionCounter}">
                                            <label class="form-check-label" for="art4_${artSectionCounter}">4. TDF+FTC+NVP</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="nama_paduan_art_${artSectionCounter}" value="AZT+3TC+EFV" id="art5_${artSectionCounter}">
                                            <label class="form-check-label" for="art5_${artSectionCounter}">5. AZT+3TC+EFV</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="nama_paduan_art_${artSectionCounter}" value="AZT+3TC+NVP" id="art6_${artSectionCounter}">
                                            <label class="form-check-label" for="art6_${artSectionCounter}">6. AZT+3TC+NVP</label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="nama_paduan_art_${artSectionCounter}" value="lainnya" id="art7_${artSectionCounter}">
                                            <label class="form-check-label" for="art7_${artSectionCounter}">7. Lainnya</label>
                                        </div>
                                        <div id="lainnya-art-details-${artSectionCounter}" class="d-none">
                                            <input type="text" name="art_lainnya_${artSectionCounter}" class="form-control form-control-sm" placeholder="Sebutkan nama paduan ART lainnya">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-dark">SUBSTITUSI dalam lini-1, SWITCH ke lini-2, STOP</label>
                                <div class="row g-3 mb-3">
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
                                <div class="row g-3 mb-3">
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
                updateRemoveButtons();

                // Scroll to new section
                newSection.scrollIntoView({ behavior: 'smooth', block: 'center' });

                console.log('Added new ART section #' + artSectionCounter);
            };

            // ===== FUNCTION: Remove ART Section =====
            window.removeArtSection = function (sectionId) {
                const section = document.querySelector(`[data-section="${sectionId}"]`);
                if (section && document.querySelectorAll('.art-section').length > 1) {
                    if (confirm('Yakin ingin menghapus section ART ini?')) {
                        section.remove();
                        updateRemoveButtons();
                        collectArtData();
                        console.log('Removed ART section #' + sectionId);
                    }
                } else {
                    alert('Tidak dapat menghapus section terakhir');
                }
            };

            // ===== FUNCTION: Update Remove Buttons =====
            function updateRemoveButtons() {
                const sections = document.querySelectorAll('.art-section');
                const removeButtons = document.querySelectorAll('.remove-art-btn');

                if (sections.length > 1) {
                    removeButtons.forEach(btn => btn.classList.remove('d-none'));
                } else {
                    removeButtons.forEach(btn => btn.classList.add('d-none'));
                }
            }

            // ===== FUNCTION: Initialize All Sections =====
            function initializeAllSections() {
                const sections = document.querySelectorAll('.art-section');

                sections.forEach((section, index) => {
                    const sectionNumber = section.getAttribute('data-section') || (index + 1);
                    setupArtSection(sectionNumber);
                });

                updateRemoveButtons();

                // Initial data collection
                setTimeout(() => {
                    collectArtData();
                }, 100);

                console.log('Initialized all ART sections:', sections.length);
            }

            // ===== FORM SUBMISSION HANDLER =====
            const forms = document.querySelectorAll('#hivArtForm, #praAnestesiForm, #hivArtEditForm, form');
            forms.forEach(form => {
                if (form) {
                    form.addEventListener('submit', function (e) {
                        console.log('Form submission triggered');

                        // Final data collection
                        const finalData = collectArtData();
                        console.log('Final ART data before submit:', finalData);
                    });
                }
            });

            // ===== OTHER TOGGLE HANDLERS =====

            // Entry Point Handlers
            function setupEntryPointHandlers() {
                const entryPointRadios = document.querySelectorAll('input[name="kia_details[]"]');

                entryPointRadios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        const detailSections = ['rujukan-details', 'jangkauan-details', 'lainnya-kia-details'];

                        detailSections.forEach(sectionId => {
                            const section = document.getElementById(sectionId);
                            if (section) {
                                section.classList.add('d-none');
                                const textarea = section.querySelector('textarea');
                                if (textarea) {
                                    let shouldClear = true;
                                    if (this.value === 'rujukan_jalan_tb' && sectionId === 'rujukan-details') shouldClear = false;
                                    if (this.value === 'jangkauan' && sectionId === 'jangkauan-details') shouldClear = false;
                                    if (this.value === 'lainnya_uraikan' && sectionId === 'lainnya-kia-details') shouldClear = false;
                                    if (shouldClear) textarea.value = '';
                                }
                            }
                        });

                        if (this.checked) {
                            let targetSection = null;
                            switch (this.value) {
                                case 'rujukan_jalan_tb': targetSection = 'rujukan-details'; break;
                                case 'jangkauan': targetSection = 'jangkauan-details'; break;
                                case 'lainnya_uraikan': targetSection = 'lainnya-kia-details'; break;
                            }
                            if (targetSection) {
                                const section = document.getElementById(targetSection);
                                if (section) section.classList.remove('d-none');
                            }
                        }
                    });
                });
            }

            // ART Details Toggle
            const artRadios = document.querySelectorAll('input[name="menerima_art"]');
            const artDetails = document.getElementById('art_details');
            if (artRadios.length > 0 && artDetails) {
                artRadios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        if (this.value === 'Ya') {
                            artDetails.style.display = 'block';
                        } else {
                            artDetails.style.display = 'none';
                            const inputs = artDetails.querySelectorAll('input, select, textarea');
                            inputs.forEach(input => {
                                if (input.type === 'radio' || input.type === 'checkbox') {
                                    input.checked = false;
                                } else {
                                    input.value = '';
                                }
                            });
                        }
                    });
                });
            }

            // Faktor Risiko Toggle
            const faktorrisikoCheckbox = document.getElementById('lain_lainnya');
            if (faktorrisikoCheckbox) {
                faktorrisikoCheckbox.addEventListener('change', function () {
                    const details = document.getElementById('lain-lainnya-details');
                    if (details) {
                        if (this.checked) {
                            details.classList.remove('d-none');
                        } else {
                            details.classList.add('d-none');
                            const textarea = details.querySelector('textarea');
                            if (textarea) textarea.value = '';
                        }
                    }
                });
            }

            // TB Classification Toggle
            const tbRadios = document.querySelectorAll('input[name="klasifikasi_tb"]');
            if (tbRadios.length > 0) {
                tbRadios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        const lokasiTbEkstra = document.getElementById('lokasi_tb_ekstra');
                        if (lokasiTbEkstra) {
                            if (this.value === 'tb_ekstra_paru') {
                                lokasiTbEkstra.classList.remove('d-none');
                            } else {
                                lokasiTbEkstra.classList.add('d-none');
                                const input = lokasiTbEkstra.querySelector('input');
                                if (input) input.value = '';
                            }
                        }
                    });
                });
            }

            // ===== DEBUG FUNCTIONS =====
            window.debugArtData = function () {
                console.log('=== ART DEBUG ===');

                const sections = document.querySelectorAll('.art-section');
                console.log('Total sections:', sections.length);

                sections.forEach((section, index) => {
                    const sectionId = section.getAttribute('data-section');
                    const selectedRadio = section.querySelector(`input[name="nama_paduan_art_${sectionId}"]:checked`);
                    console.log(`Section ${sectionId}: Selected = ${selectedRadio ? selectedRadio.value : 'none'}`);
                });

                const artInput = document.getElementById('dataARTInput');
                if (artInput) {
                    console.log('Hidden input value:', artInput.value);
                }

                const existingData = document.getElementById('existing-art-data');
                if (existingData) {
                    console.log('Existing data:', existingData.value);
                }

                console.log('=== END DEBUG ===');
            };

            window.forceCollectData = function () {
                const data = collectArtData();
                console.log('Force collected data:', data);
                return data;
            };

            // Function untuk mengumpulkan data Keluarga/Mitra
            window.updateMitraDataJSON = function (mitraData) {
                const jsonData = JSON.stringify(mitraData);
                console.log('Clean Mitra data:', jsonData);

                const hiddenInput = document.getElementById('dataKeluargaInput') || document.querySelector('input[name="data_keluarga"]');
                if (hiddenInput) {
                    hiddenInput.value = jsonData;
                }
            };

            // Function untuk mengumpulkan data Alergi
            window.updateAlergiDataJSON = function (alergiData) {
                const jsonData = JSON.stringify(alergiData);
                console.log('Clean Alergi data:', jsonData);

                const hiddenInput = document.getElementById('alergisInput') || document.querySelector('input[name="alergis"]');
                if (hiddenInput) {
                    hiddenInput.value = jsonData;
                }
            };

            // ===== INITIALIZATION =====
            setupEntryPointHandlers();
            initializeAllSections();

            console.log('ART Form scripts initialized successfully');
            console.log('Total sections:', artSectionCounter);

            // Check if we have existing data
            const existingDataElement = document.getElementById('existing-art-data');
            if (existingDataElement && existingDataElement.value && existingDataElement.value !== '[]' && existingDataElement.value !== '{}') {
                console.log('Existing data detected:', existingDataElement.value);

                // Verify radio buttons are checked
                setTimeout(() => {
                    const checkedRadios = document.querySelectorAll('input[type="radio"]:checked');
                    console.log('Checked radios found:', checkedRadios.length);

                    checkedRadios.forEach(radio => {
                        console.log('Checked radio:', radio.name, '=', radio.value);

                        // Trigger change event to show lainnya field if needed
                        if (radio.value === 'lainnya') {
                            radio.dispatchEvent(new Event('change'));
                        }
                    });
                }, 200);
            }

            // Expose functions globally
            window.collectArtData = collectArtData;
            window.setupArtSection = setupArtSection;
        });

        document.addEventListener('DOMContentLoaded', function () {
            const tbEkstraParuRadio = document.getElementById('tb_ekstra_paru');
            const lokasiTbEkstraDiv = document.getElementById('lokasi_tb_ekstra');

            function toggleLokasiTbEkstra() {
                if (tbEkstraParuRadio.checked) {
                    lokasiTbEkstraDiv.classList.remove('d-none');
                } else {
                    lokasiTbEkstraDiv.classList.add('d-none');
                }
            }

            // Initial check
            toggleLokasiTbEkstra();

            // Add event listener for radio button changes
            document.querySelectorAll('input[name="klasifikasi_tb"]').forEach(radio => {
                radio.addEventListener('change', toggleLokasiTbEkstra);
            });
        });
    </script>
@endpush
