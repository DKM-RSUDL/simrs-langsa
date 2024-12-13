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
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //------------------------------------------------------------//
            // Event handler untuk tombol tambah keterangan di pemeriksaan fisik //
            document.querySelectorAll('.tambah-keterangan').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const keteranganDiv = document.getElementById(targetId);
                    const normalCheckbox = this.closest('.pemeriksaan-item').querySelector(
                        '.form-check-input');

                    // Toggle tampilan keterangan
                    if (keteranganDiv.style.display === 'none') {
                        keteranganDiv.style.display = 'block';
                        normalCheckbox.checked = false; // Uncheck normal checkbox
                    } else {
                        keteranganDiv.style.display = 'block';
                    }
                });
            });

            // Event handler untuk checkbox normal
            document.querySelectorAll('.form-check-input').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const keteranganDiv = this.closest('.pemeriksaan-item').querySelector(
                        '.keterangan');
                    if (this.checked) {
                        keteranganDiv.style.display = 'none';
                        keteranganDiv.querySelector('input').value = ''; // Reset input value
                    }
                });
            });
            //------------------------------------------------------------//

            //------------------------------------------------------------//
            // Event handler untuk skala risiko jatuh
            function handleSkalaRisikoJatuh() {
                const skalaSelect = document.getElementById('skalaRisikoJatuh');
                const allForms = document.querySelectorAll('.risk-form');

                if (!skalaSelect) {
                    console.error('Skala select not found');
                    return;
                }

                // Hide all forms initially
                allForms.forEach(form => {
                    form.style.display = 'none';
                });

                skalaSelect.addEventListener('change', function() {
                    const selectedValue = this.value;
                    console.log('Selected value:', selectedValue); // Debug log

                    // Hide all forms first
                    allForms.forEach(form => {
                        form.style.display = 'none';
                    });

                    // Show selected form
                    const formId = `form${selectedValue.charAt(0).toUpperCase()}${selectedValue.slice(1)}`;
                    const selectedForm = document.getElementById(formId);
                    console.log('Looking for form:', formId); // Debug log

                    if (selectedForm) {
                        selectedForm.style.display = 'block';
                        console.log('Form displayed:', formId); // Debug log
                    } else {
                        console.error('Form not found:', formId);
                    }
                });

                // Handle risk calculation
                allForms.forEach(form => {
                    const selects = form.querySelectorAll('select');
                    selects.forEach(select => {
                        select.addEventListener('change', () => {
                            calculateRisk(form);
                        });
                    });
                });
            }

            function calculateRisk(form) {
                const selects = form.querySelectorAll('select[name]'); // Only select elements with name attribute
                let riskCount = 0;

                selects.forEach(select => {
                    if (select.value === 'ya') {
                        riskCount++;
                    }
                });

                const kesimpulanEl = form.querySelector('.alert');
                if (kesimpulanEl) {
                    if (riskCount > 0) {
                        kesimpulanEl.textContent = 'Berisiko jatuh';
                        kesimpulanEl.className = 'alert alert-warning mb-0 flex-grow-1';
                    } else {
                        kesimpulanEl.textContent = 'Tidak berisiko jatuh';
                        kesimpulanEl.className = 'alert alert-success mb-0 flex-grow-1';
                    }
                }
            }

            // Initialize the risk assessment functionality
            handleSkalaRisikoJatuh();
            //------------------------------------------------------------//

            //------------------------------------------------------------//
            function handleRisikoDekubitus() {
                const skalaSelect = document.getElementById('skalaRisikoDekubitus');
                const allForms = document.querySelectorAll('.decubitus-form');

                if (!skalaSelect) {
                    console.error('Skala dekubitus select not found');
                    return;
                }

                // Hide all forms initially
                allForms.forEach(form => {
                    form.style.display = 'none';
                });

                skalaSelect.addEventListener('change', function() {
                    const selectedValue = this.value;

                    // Hide all forms
                    allForms.forEach(form => {
                        form.style.display = 'none';
                    });

                    // Show selected form
                    const formId = `form${selectedValue.charAt(0).toUpperCase()}${selectedValue.slice(1)}`;
                    const selectedForm = document.getElementById(formId);

                    if (selectedForm) {
                        selectedForm.style.display = 'block';
                        // Reset form values
                        selectedForm.querySelectorAll('select').forEach(select => {
                            select.selectedIndex = 0;
                        });
                    }
                });

                // Calculate Norton score
                function calculateNortonScore(form) {
                    const selects = form.querySelectorAll('select[name]');
                    let totalScore = 0;

                    selects.forEach(select => {
                        if (select.value) {
                            totalScore += parseInt(select.value);
                        }
                    });

                    const kesimpulanEl = form.querySelector('#kesimpulanNorton');
                    if (kesimpulanEl) {
                        let riskLevel = '';
                        let alertClass = '';

                        if (totalScore <= 12) {
                            riskLevel = 'Risiko Tinggi';
                            alertClass = 'alert-danger';
                        } else if (totalScore <= 14) {
                            riskLevel = 'Risiko Sedang';
                            alertClass = 'alert-warning';
                        } else {
                            riskLevel = 'Risiko Rendah';
                            alertClass = 'alert-success';
                        }

                        kesimpulanEl.textContent = riskLevel;
                        kesimpulanEl.className = `alert ${alertClass} mb-0 flex-grow-1`;
                    }
                }

                // Add event listeners for Norton scale inputs
                const nortonForm = document.getElementById('formNorton');
                if (nortonForm) {
                    nortonForm.querySelectorAll('select').forEach(select => {
                        select.addEventListener('change', () => calculateNortonScore(nortonForm));
                    });
                }
            }

            // Initialize the decubitus risk assessment
            handleRisikoDekubitus();
            //------------------------------------------------------------//

            //------------------------------------------------------------//
            // Handler untuk Status Psikologis dropdown
            function handlePsikologisDropdown() {
                const btnKondisiPsikologis = document.getElementById('btnKondisiPsikologis');
                const dropdownKondisiPsikologis = document.getElementById('dropdownKondisiPsikologis');
                const selectedKondisiPsikologis = document.getElementById('selectedKondisiPsikologis');
                let selectedItems = new Set();

                if (!btnKondisiPsikologis || !dropdownKondisiPsikologis || !selectedKondisiPsikologis) {
                    console.error('Some elements for psikologis dropdown not found');
                    return;
                }

                function updateSelectedItems() {
                    selectedKondisiPsikologis.innerHTML = '';
                    selectedItems.forEach(item => {
                        const badge = document.createElement('span');
                        badge.className = 'selected-item';
                        badge.innerHTML =
                            `${item}<i class="ti-close remove-item" data-value="${item}"></i>`;
                        selectedKondisiPsikologis.appendChild(badge);
                    });
                }

                btnKondisiPsikologis.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const rect = this.getBoundingClientRect();
                    const buttonHeight = this.offsetHeight;

                    dropdownKondisiPsikologis.style.position = 'absolute';
                    dropdownKondisiPsikologis.style.top = `${buttonHeight + 5}px`; // 5px offset
                    dropdownKondisiPsikologis.style.left = '0';
                    dropdownKondisiPsikologis.style.display = dropdownKondisiPsikologis.style.display ===
                        'none' ? 'block' : 'none';

                    // Memastikan dropdown tidak keluar dari viewport
                    const dropdownRect = dropdownKondisiPsikologis.getBoundingClientRect();
                    const viewportHeight = window.innerHeight;
                    const viewportWidth = window.innerWidth;

                    if (dropdownRect.bottom > viewportHeight) {
                        dropdownKondisiPsikologis.style.top = 'auto';
                        dropdownKondisiPsikologis.style.bottom = `${buttonHeight + 5}px`;
                    }

                    if (dropdownRect.right > viewportWidth) {
                        dropdownKondisiPsikologis.style.left = 'auto';
                        dropdownKondisiPsikologis.style.right = '0';
                    }
                });

                document.querySelectorAll('.kondisi-options .form-check-input').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            selectedItems.add(this.value);
                        } else {
                            selectedItems.delete(this.value);
                        }
                        updateSelectedItems();
                    });
                });

                selectedKondisiPsikologis.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-item')) {
                        const value = e.target.dataset.value;
                        selectedItems.delete(value);
                        const checkbox = document.querySelector(`.form-check-input[value="${value}"]`);
                        if (checkbox) checkbox.checked = false;
                        updateSelectedItems();
                    }
                });

                document.addEventListener('click', function(e) {
                    if (!dropdownKondisiPsikologis.contains(e.target) && e.target !==
                        btnKondisiPsikologis) {
                        dropdownKondisiPsikologis.style.display = 'none';
                    }
                });
            }

            // Initialize psikologis dropdown
            handlePsikologisDropdown();
            //------------------------------------------------------------//


        });
    </script>
@endpush
