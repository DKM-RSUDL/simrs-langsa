<div class="modal fade" id="modalKebiasaanHamil" tabindex="-1" aria-labelledby="modalKebiasaanHamilLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalKebiasaanHamilLabel">
                    <i class="bi bi-activity me-2"></i>Pilih Kebiasaan Ibu Sewaktu Hamil
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div>Pilih kebiasaan ibu sewaktu hamil. Anda dapat memilih lebih dari satu opsi.</div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>Kebiasaan Umum</strong>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item border-0 px-0">
                                <div class="form-check">
                                    <input class="form-check-input kebiasaanHamilCheckbox" type="checkbox" value="Jamu" id="kebiasaanHamilJamu">
                                    <label class="form-check-label" for="kebiasaanHamilJamu">
                                        <i class="bi bi-leaf text-success me-2"></i> Jamu
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="form-check">
                                    <input class="form-check-input kebiasaanHamilCheckbox" type="checkbox" value="Merokok" id="kebiasaanHamilMerokok">
                                    <label class="form-check-label" for="kebiasaanHamilMerokok">
                                        <i class="bi bi-cloud-haze2 text-danger me-2"></i> Merokok
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="form-check">
                                    <input class="form-check-input kebiasaanHamilCheckbox" type="checkbox" value="Obat" id="kebiasaanHamilObat">
                                    <label class="form-check-label" for="kebiasaanHamilObat">
                                        <i class="bi bi-capsule text-primary me-2"></i> Obat
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lainnya -->
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="lainnya" id="kebiasaanHamilLainnya">
                            <label class="form-check-label fw-bold" for="kebiasaanHamilLainnya">
                                Kebiasaan Lainnya
                            </label>
                        </div>
                    </div>
                    <div id="kebiasaanHamilLainnyaContainer" class="card-body d-none">
                        <p class="text-muted small mb-3">Tambahkan kebiasaan lain yang tidak tercantum di atas</p>
                        <div class="kebiasaanHamilLainnyaItems">
                            <div class="lainnya-item mb-2">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-plus-circle text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control kebiasaanHamilLainnyaInput" placeholder="Masukkan kebiasaan lainnya">
                                    <button class="btn btn-outline-danger remove-kebiasaanHamilLainnya" type="button" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addMoreKebiasaanHamilLainnya">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Kebiasaan Lainnya
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="btnSimpanKebiasaanHamil">
                    <i class="bi bi-check-lg me-1"></i> Simpan Pilihan
                </button>
            </div>
        </div>
    </div>
</div>

@push('css')
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
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Element references
            const modalKebiasaanHamilElement = document.getElementById('modalKebiasaanHamil');
            const btnPilihKebiasaanHamil = document.getElementById('btnPilihKebiasaanHamil');
            const kebiasaanHamilLainnya = document.getElementById('kebiasaanHamilLainnya');
            const kebiasaanHamilLainnyaContainer = document.getElementById('kebiasaanHamilLainnyaContainer');
            const addMoreKebiasaanHamilLainnyaBtn = document.getElementById('addMoreKebiasaanHamilLainnya');
            const btnSimpanKebiasaanHamil = document.getElementById('btnSimpanKebiasaanHamil');
            const kebiasaanHamilDisplay = document.getElementById('kebiasaanHamilDisplay');
            const kebiasaanHamilInput = document.getElementById('kebiasaanHamilInput');
            const kebiasaanHamilPilihan = document.getElementById('kebiasaanHamilPilihan');
            const checkboxKebiasaanHamil = document.querySelectorAll('.kebiasaanHamilCheckbox');
            const kebiasaanHamilLainnyaItemsContainer = document.querySelector('.kebiasaanHamilLainnyaItems');

            // Validation
            if (!modalKebiasaanHamilElement || !btnSimpanKebiasaanHamil || !kebiasaanHamilPilihan || !kebiasaanHamilDisplay || !kebiasaanHamilInput) {
                console.error('One or more required elements are missing.');
                return;
            }

            // Initialize modal
            let modalKebiasaanHamil;
            try {
                modalKebiasaanHamil = new bootstrap.Modal(modalKebiasaanHamilElement);
            } catch (error) {
                console.error('Failed to initialize modal:', error);
                return;
            }

            // Open modal
            if (btnPilihKebiasaanHamil) {
                btnPilihKebiasaanHamil.addEventListener('click', () => modalKebiasaanHamil.show());
            } else {
                console.warn('Button to open modal not found.');
            }

            // Toggle "Lainnya" section
            if (kebiasaanHamilLainnya && kebiasaanHamilLainnyaContainer) {
                kebiasaanHamilLainnya.addEventListener('change', function () {
                    if (this.checked) {
                        kebiasaanHamilLainnyaContainer.classList.remove('d-none');
                        const firstInput = kebiasaanHamilLainnyaContainer.querySelector('.kebiasaanHamilLainnyaInput');
                        if (firstInput) {
                            setTimeout(() => firstInput.focus(), 100);
                        }
                    } else {
                        kebiasaanHamilLainnyaContainer.classList.add('d-none');
                        document.querySelectorAll('.kebiasaanHamilLainnyaInput').forEach(input => {
                            input.value = '';
                        });
                        const lainnyaItems = document.querySelectorAll('.lainnya-item');
                        for (let i = 0; i < lainnyaItems.length; i++) {
                            lainnyaItems[i].remove();
                        }
                    }
                });
            } else {
                console.warn('Checkbox or container for "Kebiasaan Lainnya" not found.');
            }

            // Add new "Lainnya" input
            if (addMoreKebiasaanHamilLainnyaBtn && kebiasaanHamilLainnyaItemsContainer) {
                addMoreKebiasaanHamilLainnyaBtn.addEventListener('click', function () {
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
                            <input type="text" class="form-control kebiasaanHamilLainnyaInput" placeholder="Masukkan kebiasaan lainnya">
                            <button class="btn btn-outline-danger remove-kebiasaanHamilLainnya" type="button" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;

                    kebiasaanHamilLainnyaItemsContainer.appendChild(newItem);

                    void newItem.offsetWidth;

                    newItem.style.opacity = '1';
                    newItem.style.transform = 'translateY(0)';

                    const removeBtn = newItem.querySelector('.remove-kebiasaanHamilLainnya');
                    if (removeBtn) {
                        removeBtn.addEventListener('click', function () {
                            newItem.style.opacity = '0';
                            newItem.style.transform = 'translateY(-10px)';
                            setTimeout(() => {
                                newItem.remove();
                            }, 300);
                        });
                    }

                    const newInput = newItem.querySelector('.kebiasaanHamilLainnyaInput');
                    if (newInput) {
                        setTimeout(() => newInput.focus(), 100);
                    }
                });
            } else {
                console.warn('Button or container for adding more "Lainnya" items not found.');
            }

            // Add event listeners to initial remove buttons
            document.querySelectorAll('.remove-kebiasaanHamilLainnya').forEach(button => {
                button.addEventListener('click', function () {
                    const item = this.closest('.lainnya-item');
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        item.remove();
                    }, 300);
                });
            });

            // Create badge
            function createBadge(value, isLainnya = false) {
                const bgColor = isLainnya ? 'bg-info' : 'bg-primary';
                const icons = {
                    'Jamu': '<i class="bi bi-leaf text-success me-1"></i>',
                    'Merokok': '<i class="bi bi-cloud-haze2 text-danger me-1"></i>',
                    'Obat': '<i class="bi bi-capsule text-primary me-1"></i>'
                };
                const icon = icons[value] || '<i class="bi bi-tag text-secondary me-1"></i>';

                const badge = document.createElement('span');
                badge.className = `badge ${bgColor} me-2 mb-2`;
                badge.innerHTML = `${icon}${value}<span class="badge-remove ms-2"><i class="bi bi-x"></i></span>`;

                const removeBtn = badge.querySelector('.badge-remove');
                if (removeBtn) {
                    removeBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        badge.style.opacity = '0';
                        badge.style.transform = 'scale(0.8)';
                        setTimeout(() => {
                            badge.remove();
                            if (!isLainnya) {
                                checkboxKebiasaanHamil.forEach(cb => {
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
                const values = Array.from(kebiasaanHamilPilihan.querySelectorAll('.badge'))
                    .map(badge => badge.textContent.replace('×', '').trim());
                const displayText = values.join(', ');
                kebiasaanHamilDisplay.value = displayText;
                kebiasaanHamilInput.value = displayText;
                if (kebiasaanHamilDisplay) {
                    kebiasaanHamilDisplay.classList.add('border-primary');
                    setTimeout(() => kebiasaanHamilDisplay.classList.remove('border-primary'), 500);
                }
            }

            // Save selections
            if (btnSimpanKebiasaanHamil) {
                btnSimpanKebiasaanHamil.addEventListener('click', function () {
                    this.innerHTML = '<i class="bi bi-check2-all me-1"></i> Disimpan!';
                    this.classList.replace('btn-primary', 'btn-success');

                    setTimeout(() => {
                        this.innerHTML = '<i class="bi bi-check-lg me-1"></i> Simpan Pilihan';
                        this.classList.replace('btn-success', 'btn-primary');
                    }, 1000);

                    Array.from(kebiasaanHamilPilihan.children).forEach(badge => {
                        badge.style.opacity = '0';
                        badge.style.transform = 'scale(0.8)';
                    });
                    setTimeout(() => {
                        kebiasaanHamilPilihan.innerHTML = '';

                        checkboxKebiasaanHamil.forEach(checkbox => {
                            if (checkbox.checked) {
                                kebiasaanHamilPilihan.appendChild(createBadge(checkbox.value));
                            }
                        });

                        if (kebiasaanHamilLainnya.checked) {
                            document.querySelectorAll('.kebiasaanHamilLainnyaInput').forEach(input => {
                                const value = input.value.trim();
                                if (value) {
                                    kebiasaanHamilPilihan.appendChild(createBadge(value, true));
                                }
                            });
                        }

                        updateInputValues();
                        modalKebiasaanHamil.hide();
                    }, 300);
                });
            }

            // Reset on modal close
            if (modalKebiasaanHamilElement) {
                modalKebiasaanHamilElement.addEventListener('hidden.bs.modal', function () {
                    if (!kebiasaanHamilInput.value) {
                        checkboxKebiasaanHamil.forEach(checkbox => checkbox.checked = false);
                        if (kebiasaanHamilLainnya) kebiasaanHamilLainnya.checked = false;
                        if (kebiasaanHamilLainnyaContainer) kebiasaanHamilLainnyaContainer.classList.add('d-none');
                        document.querySelectorAll('.kebiasaanHamilLainnyaInput').forEach(input => input.value = '');
                        const lainnyaItems = document.querySelectorAll('.lainnya-item');
                        for (let i = 0; i < lainnyaItems.length; i++) {
                            lainnyaItems[i].remove();
                        }
                    }
                });
            }

            // Load saved values
            if (kebiasaanHamilInput && kebiasaanHamilInput.value) {
                const savedValues = kebiasaanHamilInput.value.split(', ').map(v => v.trim());
                kebiasaanHamilDisplay.value = kebiasaanHamilInput.value;

                savedValues.forEach(value => {
                    const checkbox = Array.from(checkboxKebiasaanHamil).find(cb => cb.value === value);
                    if (checkbox) {
                        checkbox.checked = true;
                        kebiasaanHamilPilihan.appendChild(createBadge(value));
                    } else {
                        kebiasaanHamilLainnya.checked = true;
                        kebiasaanHamilLainnyaContainer.classList.remove('d-none');
                        addLainnyaItem(value);
                        kebiasaanHamilPilihan.appendChild(createBadge(value, true));
                    }
                });
            }
        });
    </script>
@endpush
