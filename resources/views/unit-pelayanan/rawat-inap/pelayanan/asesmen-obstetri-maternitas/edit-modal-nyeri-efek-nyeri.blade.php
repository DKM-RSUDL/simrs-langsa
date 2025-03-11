<!-- Modal Efek Nyeri -->
<div class="modal fade" id="modalEfekNyeri" tabindex="-1" aria-labelledby="modalEfekNyeriLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalEfekNyeriLabel">
                    <i class="bi bi-activity me-2"></i>Pilih Efek Nyeri
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div>Pilih efek nyeri yang dirasakan pasien. Anda dapat memilih lebih dari satu opsi.</div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>Efek Nyeri Umum</strong>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="list-group-item border-0 px-0">
                                        <div class="form-check">
                                            <input class="form-check-input efek-nyeri-checkbox" type="checkbox" value="Tidur" id="efekTidur">
                                            <label class="form-check-label" for="efekTidur">
                                                <i class="bi bi-moon text-dark me-2"></i> Tidur
                                            </label>
                                        </div>
                                    </div>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="form-check">
                                            <input class="form-check-input efek-nyeri-checkbox" type="checkbox" value="Nafsu makan" id="efekNafsuMakan">
                                            <label class="form-check-label" for="efekNafsuMakan">
                                                <i class="bi bi-cup-hot text-warning me-2"></i> Nafsu makan
                                            </label>
                                        </div>
                                    </div>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="form-check">
                                            <input class="form-check-input efek-nyeri-checkbox" type="checkbox" value="Mual/ muntah" id="efekMual">
                                            <label class="form-check-label" for="efekMual">
                                                <i class="bi bi-moisture text-success me-2"></i> Mual/ muntah
                                            </label>
                                        </div>
                                    </div>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="form-check">
                                            <input class="form-check-input efek-nyeri-checkbox" type="checkbox" value="Aktivitas" id="efekAktivitas">
                                            <label class="form-check-label" for="efekAktivitas">
                                                <i class="bi bi-person-walking text-primary me-2"></i> Aktivitas
                                            </label>
                                        </div>
                                    </div>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="form-check">
                                            <input class="form-check-input efek-nyeri-checkbox" type="checkbox" value="Konsentrasi" id="efekKonsentrasi">
                                            <label class="form-check-label" for="efekKonsentrasi">
                                                <i class="bi bi-bullseye text-danger me-2"></i> Konsentrasi
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="list-group-item border-0 px-0">
                                        <div class="form-check">
                                            <input class="form-check-input efek-nyeri-checkbox" type="checkbox" value="Pergerakan" id="efekPergerakan">
                                            <label class="form-check-label" for="efekPergerakan">
                                                <i class="bi bi-arrow-left-right text-secondary me-2"></i> Pergerakan
                                            </label>
                                        </div>
                                    </div>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="form-check">
                                            <input class="form-check-input efek-nyeri-checkbox" type="checkbox" value="Mood" id="efekMood">
                                            <label class="form-check-label" for="efekMood">
                                                <i class="bi bi-emoji-smile text-warning me-2"></i> Mood
                                            </label>
                                        </div>
                                    </div>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="form-check">
                                            <input class="form-check-input efek-nyeri-checkbox" type="checkbox" value="Emosi" id="efekEmosi">
                                            <label class="form-check-label" for="efekEmosi">
                                                <i class="bi bi-emoji-angry text-danger me-2"></i> Emosi
                                            </label>
                                        </div>
                                    </div>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="form-check">
                                            <input class="form-check-input efek-nyeri-checkbox" type="checkbox" value="Sosialisasi" id="efekSosialisasi">
                                            <label class="form-check-label" for="efekSosialisasi">
                                                <i class="bi bi-people text-info me-2"></i> Sosialisasi
                                            </label>
                                        </div>
                                    </div>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="form-check">
                                            <input class="form-check-input efek-nyeri-checkbox" type="checkbox" value="Interaksi" id="efekInteraksi">
                                            <label class="form-check-label" for="efekInteraksi">
                                                <i class="bi bi-chat-dots text-primary me-2"></i> Interaksi
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lainnya -->
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="lainnya" id="efekNyeriLainnya">
                            <label class="form-check-label fw-bold" for="efekNyeriLainnya">
                                Efek Nyeri Lainnya
                            </label>
                        </div>
                    </div>
                    <div id="efekNyeriLainnyaContainer" class="card-body d-none">
                        <p class="text-muted small mb-3">Tambahkan efek nyeri lain yang tidak tercantum di atas</p>
                        <div class="efekNyeriLainnyaItems">
                            <div class="lainnya-item mb-2">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-plus-circle text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control efekNyeriLainnyaInput" placeholder="Masukkan efek nyeri lainnya">
                                    <button class="btn btn-outline-danger remove-efekNyeriLainnya" type="button" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addMoreEfekNyeriLainnya">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Efek Nyeri Lainnya
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="btnSimpanEfekNyeri">
                    <i class="bi bi-check-lg me-1"></i> Simpan Pilihan
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.selected-items .badge {
    border-radius: 50px;
    padding: 8px 16px;
    margin: 0 8px 8px 0;
    font-weight: normal;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
}

.selected-items .badge:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.selected-items .badge .badge-remove {
    margin-left: 8px;
    opacity: 0.7;
    cursor: pointer;
    transition: opacity 0.2s;
}

.selected-items .badge .badge-remove:hover {
    opacity: 1;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.card {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.modal-content {
    border-radius: 10px;
    overflow: hidden;
}

.form-control:focus, .btn:focus {
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    border-color: #86b7fe;
}

.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-outline-danger {
    color: #dc3545;
    border-color: #dc3545;
}

.btn-outline-danger:hover {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545;
}

.list-group-item {
    padding: 10px 0;
    transition: background-color 0.2s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

.form-check-label {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.lainnya-item {
    transition: all 0.3s ease;
}

.input-group-text {
    background-color: #e9ecef;
    border-color: #ced4da;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Element references
        const modalEfekNyeriElement = document.getElementById('modalEfekNyeri');
        const btnPilihEfekNyeri = document.getElementById('btnPilihEfekNyeri');
        const efekNyeriLainnya = document.getElementById('efekNyeriLainnya');
        const efekNyeriLainnyaContainer = document.getElementById('efekNyeriLainnyaContainer');
        const addMoreEfekNyeriLainnyaBtn = document.getElementById('addMoreEfekNyeriLainnya');
        const btnSimpanEfekNyeri = document.getElementById('btnSimpanEfekNyeri');
        const efekNyeriDisplay = document.getElementById('efekNyeriDisplay');
        const efekNyeriInput = document.getElementById('efekNyeriInput');
        const efekNyeriPilihan = document.getElementById('efekNyeriPilihan');
        const checkboxEfekNyeri = document.querySelectorAll('.efek-nyeri-checkbox');
        const efekNyeriLainnyaItemsContainer = document.querySelector('.efekNyeriLainnyaItems');

        // Validation
        if (!modalEfekNyeriElement || !btnSimpanEfekNyeri || !efekNyeriPilihan || !efekNyeriDisplay || !efekNyeriInput) {
            console.error('One or more required elements are missing.');
            return;
        }

        // Initialize modal
        let modalEfekNyeri;
        try {
            modalEfekNyeri = new bootstrap.Modal(modalEfekNyeriElement);
        } catch (error) {
            console.error('Failed to initialize modal:', error);
            return;
        }

        // Parse the stored data - handle both string and JSON formats
        function parseEfekNyeriData(inputData) {
            let result = [];

            try {
                // Try to clean and parse as JSON first
                if (inputData && typeof inputData === 'string') {
                    // Clean the string from any unwanted characters
                    const cleanedInput = inputData
                        .replace(/\\/g, '')    // Remove backslashes
                        .replace(/^\"/g, '')   // Remove opening quote
                        .replace(/\"$/g, '')   // Remove closing quote
                        .trim();

                    // Check if it looks like JSON array
                    if (cleanedInput.startsWith('[') && cleanedInput.endsWith(']')) {
                        // Parse as JSON
                        result = JSON.parse(cleanedInput);
                    } else {
                        // Split by comma if it's a comma-separated string
                        result = cleanedInput.split(',').map(item => item.trim());
                    }
                } else if (Array.isArray(inputData)) {
                    // It's already an array
                    result = inputData;
                }
            } catch (error) {
                console.error('Error parsing efek nyeri data:', error);

                // Fallback: treat as comma-separated string
                if (typeof inputData === 'string') {
                    result = inputData.split(',').map(item => item.trim());
                }
            }

            // Filter out empty values and ensure we have an array
            return Array.isArray(result) ? result.filter(item => item && item.trim() !== '') : [];
        }

        // Function to add a new custom item
        function addLainnyaItem(value = '') {
            const newItem = document.createElement('div');
            newItem.className = 'lainnya-item mb-2';
            newItem.style.opacity = '0';
            newItem.style.transform = 'translateY(-10px)';
            newItem.style.transition = 'all 0.3s ease';

            newItem.innerHTML = `
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-plus-circle text-primary"></i>
                    </span>
                    <input type="text" class="form-control efekNyeriLainnyaInput" placeholder="Masukkan efek nyeri lainnya" value="${value}">
                    <button class="btn btn-outline-danger remove-efekNyeriLainnya" type="button" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;

            efekNyeriLainnyaItemsContainer.appendChild(newItem);

            void newItem.offsetWidth;

            newItem.style.opacity = '1';
            newItem.style.transform = 'translateY(0)';

            const removeBtn = newItem.querySelector('.remove-efekNyeriLainnya');
            if (removeBtn) {
                removeBtn.addEventListener('click', function () {
                    newItem.style.opacity = '0';
                    newItem.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        newItem.remove();
                    }, 300);
                });
            }

            return newItem;
        }

        // Open modal
        if (btnPilihEfekNyeri) {
            btnPilihEfekNyeri.addEventListener('click', () => modalEfekNyeri.show());
        }

        // Toggle "Lainnya" section
        if (efekNyeriLainnya && efekNyeriLainnyaContainer) {
            efekNyeriLainnya.addEventListener('change', function () {
                if (this.checked) {
                    efekNyeriLainnyaContainer.classList.remove('d-none');
                    // Ensure there's at least one input
                    if (efekNyeriLainnyaItemsContainer.children.length === 0) {
                        addLainnyaItem();
                    }
                    const firstInput = efekNyeriLainnyaContainer.querySelector('.efekNyeriLainnyaInput');
                    if (firstInput) {
                        setTimeout(() => firstInput.focus(), 100);
                    }
                } else {
                    efekNyeriLainnyaContainer.classList.add('d-none');
                    // Clear all inputs
                    efekNyeriLainnyaItemsContainer.innerHTML = '';
                }
            });
        }

        // Add new "Lainnya" input
        if (addMoreEfekNyeriLainnyaBtn && efekNyeriLainnyaItemsContainer) {
            addMoreEfekNyeriLainnyaBtn.addEventListener('click', function () {
                const newItem = addLainnyaItem();
                const newInput = newItem.querySelector('.efekNyeriLainnyaInput');
                if (newInput) {
                    setTimeout(() => newInput.focus(), 100);
                }
            });
        }

        // Create badge
        function createBadge(value, isLainnya = false) {
            const bgColor = isLainnya ? 'bg-info' : 'bg-primary';
            const icons = {
                'Tidur': '<i class="bi bi-moon text-light me-1"></i>',
                'Nafsu makan': '<i class="bi bi-cup-hot text-light me-1"></i>',
                'Mual/ muntah': '<i class="bi bi-moisture text-light me-1"></i>',
                'Aktivitas': '<i class="bi bi-person-walking text-light me-1"></i>',
                'Konsentrasi': '<i class="bi bi-bullseye text-light me-1"></i>',
                'Pergerakan': '<i class="bi bi-arrow-left-right text-light me-1"></i>',
                'Mood': '<i class="bi bi-emoji-smile text-light me-1"></i>',
                'Emosi': '<i class="bi bi-emoji-angry text-light me-1"></i>',
                'Sosialisasi': '<i class="bi bi-people text-light me-1"></i>',
                'Interaksi': '<i class="bi bi-chat-dots text-light me-1"></i>'
            };
            const icon = icons[value] || '<i class="bi bi-tag text-light me-1"></i>';

            const badge = document.createElement('span');
            badge.className = `badge ${bgColor} me-2 mb-2`;
            badge.innerHTML = `${icon}${value}<span class="badge-remove ms-2"><i class="bi bi-x"></i></span>`;
            badge.dataset.value = value;

            const removeBtn = badge.querySelector('.badge-remove');
            if (removeBtn) {
                removeBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    badge.style.opacity = '0';
                    badge.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        badge.remove();
                        if (!isLainnya) {
                            checkboxEfekNyeri.forEach(cb => {
                                if (cb.value === value) cb.checked = false;
                            });
                        }
                        updateInputValues();
                    }, 200);
                });
            }

            badge.style.transition = 'all 0.3s ease';
            badge.style.opacity = '0';
            badge.style.transform = 'scale(0.8)';
            setTimeout(() => {
                badge.style.opacity = '1';
                badge.style.transform = 'scale(1)';
            }, 50);

            return badge;
        }

        // Update input values
        function updateInputValues() {
            const values = Array.from(efekNyeriPilihan.querySelectorAll('.badge'))
                .map(badge => badge.dataset.value);

            // Update the display with comma-separated list
            const displayText = values.join(', ');
            efekNyeriDisplay.value = displayText;

            // Update the hidden input with JSON array format
            efekNyeriInput.value = JSON.stringify(values);

            if (efekNyeriDisplay) {
                efekNyeriDisplay.classList.add('border-primary');
                setTimeout(() => efekNyeriDisplay.classList.remove('border-primary'), 500);
            }
        }

        // Save selections
        if (btnSimpanEfekNyeri) {
            btnSimpanEfekNyeri.addEventListener('click', function () {
                this.innerHTML = '<i class="bi bi-check2-all me-1"></i> Disimpan!';
                this.classList.replace('btn-primary', 'btn-success');

                setTimeout(() => {
                    this.innerHTML = '<i class="bi bi-check-lg me-1"></i> Simpan Pilihan';
                    this.classList.replace('btn-success', 'btn-primary');
                }, 1000);

                // Clear existing badges with animation
                Array.from(efekNyeriPilihan.children).forEach(badge => {
                    badge.style.opacity = '0';
                    badge.style.transform = 'scale(0.8)';
                });

                setTimeout(() => {
                    efekNyeriPilihan.innerHTML = '';

                    // Add badges for checked checkboxes
                    checkboxEfekNyeri.forEach(checkbox => {
                        if (checkbox.checked) {
                            efekNyeriPilihan.appendChild(createBadge(checkbox.value));
                        }
                    });

                    // Add badges for custom items
                    if (efekNyeriLainnya.checked) {
                        document.querySelectorAll('.efekNyeriLainnyaInput').forEach(input => {
                            const value = input.value.trim();
                            if (value) {
                                efekNyeriPilihan.appendChild(createBadge(value, true));
                            }
                        });
                    }

                    updateInputValues();
                    modalEfekNyeri.hide();
                }, 300);
            });
        }

        // Initial load - parse saved data from the input
        function loadSavedData() {
            // Clear current selections
            checkboxEfekNyeri.forEach(checkbox => checkbox.checked = false);
            efekNyeriLainnya.checked = false;
            efekNyeriLainnyaContainer.classList.add('d-none');
            efekNyeriLainnyaItemsContainer.innerHTML = '';
            efekNyeriPilihan.innerHTML = '';

            // Parse the input value
            const inputValue = efekNyeriInput.value;
            if (!inputValue) return;

            // Parse the data (handles both JSON array and comma-separated formats)
            const savedValues = parseEfekNyeriData(inputValue);
            if (savedValues.length === 0) return;

            // Update the display with clean format
            efekNyeriDisplay.value = savedValues.join(', ');

            let hasCustomItems = false;

            savedValues.forEach(value => {
                // Check if it's one of the predefined options
                const checkbox = Array.from(checkboxEfekNyeri).find(cb => cb.value === value);

                if (checkbox) {
                    checkbox.checked = true;
                    efekNyeriPilihan.appendChild(createBadge(value));
                } else {
                    // It's a custom item
                    if (!hasCustomItems) {
                        efekNyeriLainnya.checked = true;
                        efekNyeriLainnyaContainer.classList.remove('d-none');
                        hasCustomItems = true;
                    }

                    addLainnyaItem(value);
                    efekNyeriPilihan.appendChild(createBadge(value, true));
                }
            });
        }

        // Load saved data when the page loads
        loadSavedData();

        // Add event listeners to initial remove buttons
        document.querySelectorAll('.remove-efekNyeriLainnya').forEach(button => {
            button.addEventListener('click', function () {
                const item = this.closest('.lainnya-item');
                item.style.opacity = '0';
                item.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    item.remove();
                }, 300);
            });
        });
    });
    </script>
