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
        // **PERBAIKAN: JavaScript dengan format JSON yang bersih**
        document.addEventListener('DOMContentLoaded', function () {
            console.log('HIV ART form scripts loaded with clean JSON format...');

            // ===== PERBAIKAN UTAMA: Function untuk mengumpulkan data ART dengan format bersih =====
            function collectArtData() {
                const artSections = document.querySelectorAll('.art-section');
                const artData = [];

                console.log('Collecting ART data from', artSections.length, 'sections');

                artSections.forEach((section, index) => {
                    const sectionNumber = section.getAttribute('data-section') || (index + 1);
                    const namaPaduanArt = document.querySelector(`input[name="nama_paduan_art_${sectionNumber}"]:checked`)?.value;

                    // Only include sections with valid data
                    if (namaPaduanArt) {
                        const artSection = {
                            nama_paduan_art: namaPaduanArt,
                            art_lainnya: namaPaduanArt === 'lainnya' ?
                                (document.querySelector(`input[name="art_lainnya_${sectionNumber}"]`)?.value || '') : '',
                            substitusi_tanggal: document.querySelector(`input[name="substitusi_tanggal_${sectionNumber}"]`)?.value || '',
                            substitusi: document.querySelector(`input[name="substitusi_${sectionNumber}"]`)?.value || '',
                            switch: document.querySelector(`input[name="switch_${sectionNumber}"]`)?.value || '',
                            stop: document.querySelector(`input[name="stop_${sectionNumber}"]`)?.value || '',
                            restart: document.querySelector(`input[name="restart_${sectionNumber}"]`)?.value || '',
                            alasan: document.querySelector(`select[name="alasan_${sectionNumber}"]`)?.value || '',
                            nama_paduan_baru: document.querySelector(`input[name="nama_paduan_baru_${sectionNumber}"]`)?.value || ''
                        };

                        // Only push if the section has meaningful data
                        if (Object.values(artSection).some(value => value)) {
                            artData.push(artSection);
                        }
                    }
                });

                const jsonData = JSON.stringify(artData, null, 2); // Pretty print for readability
                console.log('Clean ART data collected:', jsonData);

                const hiddenInput = document.getElementById('dataARTInput') || document.querySelector('input[name="data_terapi_art"]');
                if (hiddenInput) {
                    hiddenInput.value = jsonData;
                }

                return artData;
            }

            // ===== PERBAIKAN: Function untuk mengumpulkan data Keluarga/Mitra dengan format bersih =====
            function updateMitraDataJSON(mitraData) {
                // **PERBAIKAN: Format JSON tanpa escape characters**
                const jsonData = JSON.stringify(mitraData);
                console.log('Clean Mitra data:', jsonData);

                const hiddenInput = document.getElementById('dataKeluargaInput') ||
                    document.querySelector('input[name="data_keluarga"]');
                if (hiddenInput) {
                    hiddenInput.value = jsonData;
                }
            }

            // ===== PERBAIKAN: Function untuk mengumpulkan data Alergi dengan format bersih =====
            function updateAlergiDataJSON(alergiData) {
                // **PERBAIKAN: Format JSON tanpa escape characters**
                const jsonData = JSON.stringify(alergiData);
                console.log('Clean Alergi data:', jsonData);

                const hiddenInput = document.getElementById('alergisInput') ||
                    document.querySelector('input[name="alergis"]');
                if (hiddenInput) {
                    hiddenInput.value = jsonData;
                }
            }

            // ===== FORM SUBMISSION HANDLER =====
            const forms = document.querySelectorAll('#hivArtForm, #praAnestesiForm, #hivArtEditForm, form');
            forms.forEach(form => {
                if (form) {
                    form.addEventListener('submit', function (e) {
                        console.log('Form submission triggered');

                        // Kumpulkan semua data sebelum submit
                        collectArtData();

                        // Tidak perlu preventDefault karena kita ingin form tetap submit
                        console.log('Form data prepared for submission');
                    });
                }
            });

            // ===== ENTRY POINT HANDLERS (Perbaikan untuk handle radio button dengan detail) =====
            function setupEntryPointHandlers() {
                const entryPointRadios = document.querySelectorAll('input[name="kia_details[]"]');

                entryPointRadios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        // Hide semua detail sections
                        const detailSections = [
                            'rujukan-details',
                            'jangkauan-details',
                            'lainnya-kia-details'
                        ];

                        detailSections.forEach(sectionId => {
                            const section = document.getElementById(sectionId);
                            if (section) {
                                section.classList.add('d-none');
                                // Clear textarea value when hiding
                                const textarea = section.querySelector('textarea');
                                if (textarea && this.value !== section.id.replace('-details', '').replace('lainnya-kia', 'lainnya_uraikan').replace('-', '_')) {
                                    textarea.value = '';
                                }
                            }
                        });

                        // Show detail section yang sesuai
                        if (this.checked) {
                            let targetSection = null;
                            if (this.value === 'rujukan_jalan_tb') {
                                targetSection = 'rujukan-details';
                            } else if (this.value === 'jangkauan') {
                                targetSection = 'jangkauan-details';
                            } else if (this.value === 'lainnya_uraikan') {
                                targetSection = 'lainnya-kia-details';
                            }

                            if (targetSection) {
                                const section = document.getElementById(targetSection);
                                if (section) {
                                    section.classList.remove('d-none');
                                }
                            }
                        }
                    });
                });
            }

            // ===== ART SECTION HANDLERS =====
            let artSectionCounter = 1;

            // Setup ART section untuk handle "Lainnya" option
            function setupArtSection(sectionId) {
                const artRadios = document.querySelectorAll(`input[name="nama_paduan_art_${sectionId}"]`);
                const lainnyaDetails = document.getElementById(`lainnya-art-details-${sectionId}`);

                if (artRadios.length > 0 && lainnyaDetails) {
                    artRadios.forEach(radio => {
                        radio.addEventListener('change', function () {
                            if (this.value === 'lainnya') {
                                lainnyaDetails.classList.remove('d-none');
                            } else {
                                lainnyaDetails.classList.add('d-none');
                                const input = lainnyaDetails.querySelector('input');
                                if (input) {
                                    input.value = '';
                                }
                            }
                        });
                    });
                }
            }

            // Add new ART section
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
                updateRemoveButtons();

                // Scroll to new section
                newSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
            };

            // Remove ART section
            window.removeArtSection = function (sectionId) {
                const section = document.querySelector(`[data-section="${sectionId}"]`);
                if (section && document.querySelectorAll('.art-section').length > 1) {
                    section.remove();
                    updateRemoveButtons();
                }
            };

            // Update visibility of remove buttons
            function updateRemoveButtons() {
                const sections = document.querySelectorAll('.art-section');
                const removeButtons = document.querySelectorAll('.remove-art-btn');

                if (sections.length > 1) {
                    removeButtons.forEach(btn => btn.classList.remove('d-none'));
                } else {
                    removeButtons.forEach(btn => btn.classList.add('d-none'));
                }
            }

            // ===== ART DETAILS TOGGLE =====
            const artRadios = document.querySelectorAll('input[name="menerima_art"]');
            const artDetails = document.getElementById('art_details');

            if (artRadios.length > 0 && artDetails) {
                artRadios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        if (this.value === 'Ya') {
                            artDetails.style.display = 'block';
                        } else {
                            artDetails.style.display = 'none';
                            // Clear form when hiding
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

            // ===== FAKTOR RISIKO LAINNYA TOGGLE =====
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
                            if (textarea) {
                                textarea.value = '';
                            }
                        }
                    }
                });
            }

            // ===== TB CLASSIFICATION TOGGLE =====
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
                                if (input) {
                                    input.value = '';
                                }
                            }
                        }
                    });
                });
            }

            // ===== INITIALIZATION =====
            setupEntryPointHandlers();
            setupArtSection(1); // Setup initial ART section
            updateRemoveButtons();

            // ===== EXPOSE FUNCTIONS TO GLOBAL SCOPE FOR DEBUGGING =====
            window.collectArtData = collectArtData;
            window.updateMitraDataJSON = updateMitraDataJSON;
            window.updateAlergiDataJSON = updateAlergiDataJSON;

            console.log('HIV ART form scripts initialized successfully with clean JSON format');
        });

        // ===== ADDITIONAL HELPER FUNCTIONS =====

        // Function untuk debug - cek data yang akan dikirim
        function debugFormData() {
            console.log('=== FORM DATA DEBUG ===');

            // Check ART data
            const artInput = document.getElementById('dataARTInput');
            if (artInput) {
                console.log('ART Data:', artInput.value);
            }

            // Check Mitra data
            const mitraInput = document.getElementById('dataKeluargaInput');
            if (mitraInput) {
                console.log('Mitra Data:', mitraInput.value);
            }

            // Check Alergi data
            const alergiInput = document.getElementById('alergisInput');
            if (alergiInput) {
                console.log('Alergi Data:', alergiInput.value);
            }

            // Check Entry Point
            const entryPoint = document.querySelector('input[name="kia_details[]"]:checked');
            if (entryPoint) {
                console.log('Entry Point:', entryPoint.value);
            }

            // Check Faktor Risiko
            const faktorRisiko = [];
            document.querySelectorAll('input[name="faktor_risiko[]"]:checked').forEach(cb => {
                faktorRisiko.push(cb.value);
            });
            console.log('Faktor Risiko:', faktorRisiko);

            console.log('=== END DEBUG ===');
        }

        // Function untuk validate form sebelum submit
        function validateHivArtForm() {
            let isValid = true;
            const errors = [];

            // Check required fields
            const tanggal = document.querySelector('input[name="tanggal"]');
            if (!tanggal || !tanggal.value) {
                errors.push('Tanggal harus diisi');
                isValid = false;
            }

            const jam = document.querySelector('input[name="jam"]');
            if (!jam || !jam.value) {
                errors.push('Jam harus diisi');
                isValid = false;
            }

            // Check if at least one ART section has data
            const artSections = document.querySelectorAll('.art-section');
            let hasArtData = false;
            artSections.forEach(section => {
                const sectionNumber = section.getAttribute('data-section');
                const selectedArt = document.querySelector(`input[name="nama_paduan_art_${sectionNumber}"]:checked`);
                if (selectedArt) {
                    hasArtData = true;
                }
            });

            if (!hasArtData) {
                console.warn('No ART data selected, but this may be intentional');
            }

            if (!isValid) {
                console.error('Form validation failed:', errors);
                alert('Form belum lengkap:\n' + errors.join('\n'));
            }

            return isValid;
        }

        // Expose debug functions globally
        window.debugFormData = debugFormData;
        window.validateHivArtForm = validateHivArtForm;
    </script>
@endpush
