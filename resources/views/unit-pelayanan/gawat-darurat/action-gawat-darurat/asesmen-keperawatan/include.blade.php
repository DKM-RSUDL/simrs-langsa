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
        </style>
    @endpush

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tglAsesmen = document.getElementById('tgl_asesmen_keperawatan');
                const jamAsesmen = document.getElementById('jam_asesmen_keperawatan');

                const tindakanModal = new bootstrap.Modal(document.getElementById('tindakanModal'));
                const btnTambahTindakan = document.getElementById('btnTambahTindakan');
                const btnSimpanTindakan = document.getElementById('btnSimpanTindakan');
                const selectedTindakanList = document.getElementById('selectedTindakanList');
                const tindakanLainnya = document.getElementById('tindakanLainnya');
                let selectedItems = new Set();

                const tindakanBreathingModal = new bootstrap.Modal(document.getElementById('tindakanBreathingModal'));
                const btnTambahTindakanBreathing = document.getElementById('tambahTindakanBreathing');
                const btnSimpanTindakanBreathing = document.getElementById('btnSimpanTindakanBreathing');
                const selectedTindakanBreathingList = document.getElementById('tindakanBreathingList');
                const tindakanBreathingLainnya = document.getElementById('tindakanBreathingLainnya');
                let selectedBreathingItems = new Set();

                const tindakanCirculationModal = new bootstrap.Modal(document.getElementById('tindakanCirculationModal'));
                const btnTambahTindakanCirculation = document.getElementById('tambahTindakanCirculation');
                const btnSimpanTindakanCirculation = document.getElementById('btnSimpanTindakanCirculation');
                const selectedTindakanCirculationList = document.getElementById('tindakanCirculationList');
                const tindakanCirculationLainnya = document.getElementById('tindakanCirculationLainnya');
                let selectedCirculationItems = new Set();

                //=======================================================================//


                //=================================================================//

                // Show modal when Tambah button is clicked
                btnTambahTindakan.addEventListener('click', function() {
                    tindakanModal.show();
                });

                // Handle "Lainnya" checkbox
                document.getElementById('tindakan10').addEventListener('change', function() {
                    const lainnyaInput = document.querySelector('.lainnya-input');
                    lainnyaInput.style.display = this.checked ? 'block' : 'none';
                    if (!this.checked) {
                        tindakanLainnya.value = '';
                    }
                });

                // Handle save button click
                btnSimpanTindakan.addEventListener('click', function() {
                    selectedItems.clear();
                    const checkboxes = document.querySelectorAll('.tindakan-options .form-check-input:checked');

                    checkboxes.forEach(checkbox => {
                        if (checkbox.value === 'Lainnya' && tindakanLainnya.value) {
                            selectedItems.add(tindakanLainnya.value);
                        } else if (checkbox.value !== 'Lainnya') {
                            selectedItems.add(checkbox.value);
                        }
                    });

                    // Update the display
                    updateSelectedTindakan();
                    tindakanModal.hide();
                });

                function updateSelectedTindakan() {
                    selectedTindakanList.innerHTML = '';
                    selectedItems.forEach(item => {
                        const itemElement = document.createElement('div');
                        itemElement.className =
                            'selected-item d-flex align-items-center gap-2 bg-light p-2 rounded';
                        itemElement.innerHTML = `
                            <span>${item}</span>
                            <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeTindakan('${item}')">
                                <i class="ti-close"></i>
                            </button>
                            <input type="hidden" name="tindakan_keperawatan[]" value="${item}">
                        `;
                        selectedTindakanList.appendChild(itemElement);
                    });
                }

                // Make removeTindakan function available globally
                window.removeTindakan = function(item) {
                    selectedItems.delete(item);
                    updateSelectedTindakan();
                };

                //=================================================================//

                // Show modal when Tambah button is clicked
                btnTambahTindakanBreathing.addEventListener('click', function() {
                    tindakanBreathingModal.show();
                });

                // Handle "Lainnya" checkbox for breathing
                document.getElementById('tindakanBreathing7').addEventListener('change', function() {
                    const lainnyaInput = document.querySelector('.lainnya-breathing-input');
                    lainnyaInput.style.display = this.checked ? 'block' : 'none';
                    if (!this.checked) {
                        tindakanBreathingLainnya.value = '';
                    }
                });

                // Handle save button click for breathing
                btnSimpanTindakanBreathing.addEventListener('click', function() {
                    selectedBreathingItems.clear();
                    const checkboxes = document.querySelectorAll(
                        '.tindakan-breathing-options .form-check-input:checked');

                    checkboxes.forEach(checkbox => {
                        if (checkbox.value === 'Lainnya' && tindakanBreathingLainnya.value) {
                            selectedBreathingItems.add(tindakanBreathingLainnya.value);
                        } else if (checkbox.value !== 'Lainnya') {
                            selectedBreathingItems.add(checkbox.value);
                        }
                    });

                    // Update the display
                    updateSelectedTindakanBreathing();
                    tindakanBreathingModal.hide();
                });

                function updateSelectedTindakanBreathing() {
                    selectedTindakanBreathingList.innerHTML = '';
                    selectedBreathingItems.forEach(item => {
                        const itemElement = document.createElement('div');
                        itemElement.className =
                            'selected-item d-flex align-items-center gap-2 bg-light p-2 rounded';
                        itemElement.innerHTML = `
                            <span>${item}</span>
                            <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeTindakanBreathing('${item}')">
                                <i class="ti-close"></i>
                            </button>
                            <input type="hidden" name="tindakan_keperawatan_breathing[]" value="${item}">
                        `;
                        selectedTindakanBreathingList.appendChild(itemElement);
                    });
                }

                // Make removeTindakanBreathing function available globally
                window.removeTindakanBreathing = function(item) {
                    selectedBreathingItems.delete(item);
                    updateSelectedTindakanBreathing();
                };

                //=================================================================//

                // Show modal when Tambah button is clicked
                btnTambahTindakanCirculation.addEventListener('click', function() {
                    tindakanCirculationModal.show();
                });

                // Handle "Lainnya" checkbox for circulation
                document.getElementById('tindakanCirculation13').addEventListener('change', function() {
                    const lainnyaInput = document.querySelector('.lainnya-circulation-input');
                    lainnyaInput.style.display = this.checked ? 'block' : 'none';
                    if (!this.checked) {
                        tindakanCirculationLainnya.value = '';
                    }
                });

                // Handle save button click for circulation
                btnSimpanTindakanCirculation.addEventListener('click', function() {
                    selectedCirculationItems.clear();
                    const checkboxes = document.querySelectorAll('.tindakan-circulation-options .form-check-input:checked');
                    
                    checkboxes.forEach(checkbox => {
                        if (checkbox.value === 'Lainnya' && tindakanCirculationLainnya.value) {
                            selectedCirculationItems.add(tindakanCirculationLainnya.value);
                        } else if (checkbox.value !== 'Lainnya') {
                            selectedCirculationItems.add(checkbox.value);
                        }
                    });

                    // Update the display
                    updateSelectedTindakanCirculation();
                    tindakanCirculationModal.hide();
                });

                function updateSelectedTindakanCirculation() {
                    selectedTindakanCirculationList.innerHTML = '';
                    selectedCirculationItems.forEach(item => {
                        const itemElement = document.createElement('div');
                        itemElement.className = 'selected-item d-flex align-items-center gap-2 bg-light p-2 rounded';
                        itemElement.innerHTML = `
                            <span>${item}</span>
                            <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeTindakanCirculation('${item}')">
                                <i class="ti-close"></i>
                            </button>
                            <input type="hidden" name="tindakan_keperawatan_circulation[]" value="${item}">
                        `;
                        selectedTindakanCirculationList.appendChild(itemElement);
                    });
                }

                // Make removeTindakanCirculation function available globally
                window.removeTindakanCirculation = function(item) {
                    selectedCirculationItems.delete(item);
                    updateSelectedTindakanCirculation();
                };

            });
        </script>

        <script></script>
    @endpush
