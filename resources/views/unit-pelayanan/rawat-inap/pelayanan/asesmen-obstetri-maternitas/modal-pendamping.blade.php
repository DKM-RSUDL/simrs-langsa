<!-- Modal Pendamping -->
<div class="modal fade" id="modalPendamping" tabindex="-1" aria-labelledby="modalPendampingLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalPendampingLabel">
                    <i class="bi bi-people me-2"></i>Pilih Pendamping
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div>Pilih pendamping pasien. Anda dapat memilih lebih dari satu opsi.</div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>Pendamping</strong>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item border-0 px-0">
                                <div class="form-check">
                                    <input class="form-check-input pendampingCheckbox" type="checkbox" value="Suami" id="pendampingSuami">
                                    <label class="form-check-label" for="pendampingSuami">
                                        <i class="bi bi-person-fill text-success me-2"></i> Suami
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="form-check">
                                    <input class="form-check-input pendampingCheckbox" type="checkbox" value="Orang Tua" id="pendampingOrangTua">
                                    <label class="form-check-label" for="pendampingOrangTua">
                                        <i class="bi bi-people-fill text-warning me-2"></i> Orang Tua
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="form-check">
                                    <input class="form-check-input pendampingCheckbox" type="checkbox" value="Saudara" id="pendampingSaudara">
                                    <label class="form-check-label" for="pendampingSaudara">
                                        <i class="bi bi-person-lines-fill text-primary me-2"></i> Saudara
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
                            <input class="form-check-input" type="checkbox" value="lainnya" id="pendampingLainnya">
                            <label class="form-check-label fw-bold" for="pendampingLainnya">
                                Pendamping Lainnya
                            </label>
                        </div>
                    </div>
                    <div id="pendampingLainnyaContainer" class="card-body d-none">
                        <p class="text-muted small mb-3">Tambahkan pendamping lain yang tidak tercantum di atas</p>
                        <div class="pendampingLainnyaItems">
                            <div class="lainnya-item mb-2">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-plus-circle text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control pendampingLainnyaInput" placeholder="Masukkan pendamping lainnya">
                                    <button class="btn btn-outline-danger remove-pendampingLainnya" type="button" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addMorePendampingLainnya">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Pendamping Lainnya
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="btnSimpanPendamping">
                    <i class="bi bi-check-lg me-1"></i> Simpan Pilihan
                </button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Element references
            const modalPendampingElement = document.getElementById('modalPendamping');
            const btnPilihPendamping = document.getElementById('btnPilihPendamping');
            const pendampingLainnya = document.getElementById('pendampingLainnya');
            const pendampingLainnyaContainer = document.getElementById('pendampingLainnyaContainer');
            const addMorePendampingLainnyaBtn = document.getElementById('addMorePendampingLainnya');
            const btnSimpanPendamping = document.getElementById('btnSimpanPendamping');
            const pendampingDisplay = document.getElementById('pendampingDisplay');
            const pendampingInput = document.getElementById('pendampingInput');
            const pendampingPilihan = document.getElementById('pendampingPilihan');
            const checkboxPendamping = document.querySelectorAll('.pendampingCheckbox');
            const pendampingLainnyaItemsContainer = document.querySelector('.pendampingLainnyaItems');

            // Validation
            if (!modalPendampingElement || !btnSimpanPendamping || !pendampingPilihan || !pendampingDisplay || !pendampingInput) {
                console.error('One or more required elements are missing.');
                return;
            }

            // Initialize modal
            let modalPendamping;
            try {
                modalPendamping = new bootstrap.Modal(modalPendampingElement);
            } catch (error) {
                console.error('Failed to initialize modal:', error);
                return;
            }

            // Open modal
            if (btnPilihPendamping) {
                btnPilihPendamping.addEventListener('click', () => modalPendamping.show());
            } else {
                console.warn('Button to open modal not found.');
            }

            // Toggle "Lainnya" section
            if (pendampingLainnya && pendampingLainnyaContainer) {
                pendampingLainnya.addEventListener('change', function () {
                    if (this.checked) {
                        pendampingLainnyaContainer.classList.remove('d-none');
                        const firstInput = pendampingLainnyaContainer.querySelector('.pendampingLainnyaInput');
                        if (firstInput) {
                            setTimeout(() => firstInput.focus(), 100);
                        }
                    } else {
                        pendampingLainnyaContainer.classList.add('d-none');
                        document.querySelectorAll('.pendampingLainnyaInput').forEach(input => {
                            input.value = '';
                        });
                        const lainnyaItems = pendampingLainnyaContainer.querySelectorAll('.lainnya-item');
                        for (let i = 1; i < lainnyaItems.length; i++) {
                            lainnyaItems[i].remove();
                        }
                        if (lainnyaItems.length > 0) {
                            lainnyaItems[0].querySelector('.pendampingLainnyaInput').value = '';
                        }
                    }
                });
            } else {
                console.warn('Checkbox or container for "Pendamping Lainnya" not found.');
            }

            // Add new "Lainnya" input
            if (addMorePendampingLainnyaBtn && pendampingLainnyaItemsContainer) {
                addMorePendampingLainnyaBtn.addEventListener('click', function () {
                    addLainnyaItem();
                });
            } else {
                console.warn('Button or container for adding more "Lainnya" items not found.');
            }

            // Function to add lainnya item
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
                        <input type="text" class="form-control pendampingLainnyaInput" placeholder="Masukkan pendamping lainnya" value="${value}">
                        <button class="btn btn-outline-danger remove-pendampingLainnya" type="button" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;

                pendampingLainnyaItemsContainer.appendChild(newItem);

                void newItem.offsetWidth;

                newItem.style.opacity = '1';
                newItem.style.transform = 'translateY(0)';

                const removeBtn = newItem.querySelector('.remove-pendampingLainnya');
                if (removeBtn) {
                    removeBtn.addEventListener('click', function () {
                        newItem.style.opacity = '0';
                        newItem.style.transform = 'translateY(-10px)';
                        setTimeout(() => {
                            newItem.remove();
                        }, 300);
                    });
                }

                const newInput = newItem.querySelector('.pendampingLainnyaInput');
                if (newInput && !value) {
                    setTimeout(() => newInput.focus(), 100);
                }

                return newItem;
            }

            // Add event listeners to initial remove buttons
            document.querySelectorAll('.remove-pendampingLainnya').forEach(button => {
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
                    'Suami': '<i class="bi bi-person-fill text-light me-1"></i>',
                    'Orang Tua': '<i class="bi bi-people-fill text-light me-1"></i>',
                    'Saudara': '<i class="bi bi-person-lines-fill text-light me-1"></i>'
                };
                const icon = icons[value] || '<i class="bi bi-tag text-light me-1"></i>';

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
                                checkboxPendamping.forEach(cb => {
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
                const values = Array.from(pendampingPilihan.querySelectorAll('.badge'))
                    .map(badge => badge.textContent.replace('×', '').trim());
                const displayText = values.join(', ');
                pendampingDisplay.value = displayText;
                pendampingInput.value = displayText;
                if (pendampingDisplay) {
                    pendampingDisplay.classList.add('border-primary');
                    setTimeout(() => pendampingDisplay.classList.remove('border-primary'), 500);
                }
            }

            // Save selections
            if (btnSimpanPendamping) {
                btnSimpanPendamping.addEventListener('click', function () {
                    this.innerHTML = '<i class="bi bi-check2-all me-1"></i> Disimpan!';
                    this.classList.replace('btn-primary', 'btn-success');

                    setTimeout(() => {
                        this.innerHTML = '<i class="bi bi-check-lg me-1"></i> Simpan Pilihan';
                        this.classList.replace('btn-success', 'btn-primary');
                    }, 1000);

                    Array.from(pendampingPilihan.children).forEach(badge => {
                        badge.style.opacity = '0';
                        badge.style.transform = 'scale(0.8)';
                    });

                    setTimeout(() => {
                        pendampingPilihan.innerHTML = '';

                        checkboxPendamping.forEach(checkbox => {
                            if (checkbox.checked) {
                                pendampingPilihan.appendChild(createBadge(checkbox.value));
                            }
                        });

                        if (pendampingLainnya.checked) {
                            document.querySelectorAll('.pendampingLainnyaInput').forEach(input => {
                                const value = input.value.trim();
                                if (value) {
                                    pendampingPilihan.appendChild(createBadge(value, true));
                                }
                            });
                        }

                        updateInputValues();
                        modalPendamping.hide();
                    }, 300);
                });
            }

            // Reset on modal close
            if (modalPendampingElement) {
                modalPendampingElement.addEventListener('hidden.bs.modal', function () {
                    if (!pendampingInput.value) {
                        checkboxPendamping.forEach(checkbox => checkbox.checked = false);
                        if (pendampingLainnya) pendampingLainnya.checked = false;
                        if (pendampingLainnyaContainer) pendampingLainnyaContainer.classList.add('d-none');
                        document.querySelectorAll('.pendampingLainnyaInput').forEach(input => input.value = '');
                        const lainnyaItems = document.querySelectorAll('.lainnya-item');
                        for (let i = 1; i < lainnyaItems.length; i++) {
                            lainnyaItems[i].remove();
                        }
                        if (lainnyaItems.length > 0) {
                            lainnyaItems[0].querySelector('.pendampingLainnyaInput').value = '';
                        }
                    }
                });
            }

            // Load saved values
            if (pendampingInput && pendampingInput.value) {
                const savedValues = pendampingInput.value.split(', ').map(v => v.trim());
                pendampingDisplay.value = pendampingInput.value;

                savedValues.forEach(value => {
                    const checkbox = Array.from(checkboxPendamping).find(cb => cb.value === value);
                    if (checkbox) {
                        checkbox.checked = true;
                        pendampingPilihan.appendChild(createBadge(value));
                    } else {
                        pendampingLainnya.checked = true;
                        pendampingLainnyaContainer.classList.remove('d-none');
                        addLainnyaItem(value);
                        pendampingPilihan.appendChild(createBadge(value, true));
                    }
                });
            }
        });
    </script>
@endpush
