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
                            <div class="list-group-item border-0 px-0">
                                <div class="form-check">
                                    <input class="form-check-input efek-nyeri-checkbox" type="checkbox" value="Mual/ muntah"
                                        id="efekNyeriMual">
                                    <label class="form-check-label" for="efekNyeriMual">
                                        <i class="bi bi-emoji-frown text-warning me-2"></i> Mual/ muntah
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="form-check">
                                    <input class="form-check-input efek-nyeri-checkbox" type="checkbox" value="Tidur"
                                        id="efekNyeriTidur">
                                    <label class="form-check-label" for="efekNyeriTidur">
                                        <i class="bi bi-moon text-primary me-2"></i> Tidur
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="form-check">
                                    <input class="form-check-input efek-nyeri-checkbox" type="checkbox" value="Nafsu makan"
                                        id="efekNyeriNafsu">
                                    <label class="form-check-label" for="efekNyeriNafsu">
                                        <i class="bi bi-cup-hot text-danger me-2"></i> Nafsu makan
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="form-check">
                                    <input class="form-check-input efek-nyeri-checkbox" type="checkbox" value="Muntah"
                                        id="efekNyeriMuntah">
                                    <label class="form-check-label" for="efekNyeriMuntah">
                                        <i class="bi bi-droplet text-warning me-2"></i> Muntah
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="form-check">
                                    <input class="form-check-input efek-nyeri-checkbox" type="checkbox" value="Aktivitas"
                                        id="efekNyeriAktivitas">
                                    <label class="form-check-label" for="efekNyeriAktivitas">
                                        <i class="bi bi-person-walking text-success me-2"></i> Aktivitas
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="form-check">
                                    <input class="form-check-input efek-nyeri-checkbox" type="checkbox" value="Emosi"
                                        id="efekNyeriEmosi">
                                    <label class="form-check-label" for="efekNyeriEmosi">
                                        <i class="bi bi-emoji-angry text-danger me-2"></i> Emosi
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
                            <input class="form-check-input" type="checkbox" value="lainnya"
                                id="efekNyeriLainnya">
                            <label class="form-check-label fw-bold" for="efekNyeriLainnya">
                                Efek Nyeri Lainnya
                            </label>
                        </div>
                    </div>

                    <!-- untuk "Lainnya" -->
                    <div id="efekNyeriLainnyaContainer" class="card-body d-none">
                        <p class="text-muted small">Tambahkan efek nyeri lain yang tidak tercantum pada pilihan di atas</p>

                        <div class="lainnya-items">
                            <div class="lainnya-item mb-2">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-plus-circle text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control lainnya-input"
                                        placeholder="Masukkan efek nyeri lainnya">
                                    <button class="btn btn-outline-danger remove-lainnya" type="button">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addMoreLainnya">
                            <i class="bi bi-plus-lg"></i> Tambah Efek Lainnya
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
    margin-right: 8px;
    margin-bottom: 8px;
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
    transition: opacity 0.2s;
    cursor: pointer;
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
    padding-top: 10px;
    padding-bottom: 10px;
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
</style>

<script>

    document.addEventListener('DOMContentLoaded', function () {
        const btnPilihEfekNyeri = document.getElementById('btnPilihEfekNyeri');
        const modalEfekNyeriElement = document.getElementById('modalEfekNyeri');
        const efekNyeriLainnya = document.getElementById('efekNyeriLainnya');
        const efekNyeriLainnyaContainer = document.getElementById('efekNyeriLainnyaContainer');
        const addMoreLainnyaBtn = document.getElementById('addMoreLainnya');

        if (!modalEfekNyeriElement) {
            console.error('Modal element not found');
            return;
        }

        let modalEfekNyeri;
        try {
            modalEfekNyeri = new bootstrap.Modal(modalEfekNyeriElement);
        } catch (error) {
            console.error('Failed to initialize modal:', error);
            return;
        }

        const checkboxEfekNyeri = document.querySelectorAll('.efek-nyeri-checkbox');
        const btnSimpanEfekNyeri = document.getElementById('btnSimpanEfekNyeri');
        const efekNyeriDisplay = document.getElementById('efekNyeriDisplay');
        const efekNyeriInput = document.getElementById('efekNyeriInput');
        const efekNyeriPilihan = document.getElementById('efekNyeriPilihan');

        if (btnPilihEfekNyeri) {
            btnPilihEfekNyeri.addEventListener('click', function () {
                modalEfekNyeri.show();
            });
        } else {
            console.error('Button element not found');
        }

        // Toggle lainnya
        if (efekNyeriLainnya && efekNyeriLainnyaContainer) {
            efekNyeriLainnya.addEventListener('change', function () {
                if (this.checked) {
                    efekNyeriLainnyaContainer.classList.remove('d-none');
                    const firstInput = efekNyeriLainnyaContainer.querySelector('.lainnya-input');
                    if (firstInput) {
                        setTimeout(() => firstInput.focus(), 100);
                    }
                } else {
                    efekNyeriLainnyaContainer.classList.add('d-none');
                    document.querySelectorAll('.lainnya-input').forEach(input => {
                        input.value = '';
                    });
                    const lainnyaItems = document.querySelectorAll('.lainnya-item');
                    for (let i = 1; i < lainnyaItems.length; i++) {
                        lainnyaItems[i].remove();
                    }
                }
            });
        }

        // Add lainnya input
        if (addMoreLainnyaBtn) {
            addMoreLainnyaBtn.addEventListener('click', function() {
                const lainnyaItemsContainer = document.querySelector('.lainnya-items');
                if (!lainnyaItemsContainer) return;

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
                        <input type="text" class="form-control lainnya-input"
                            placeholder="Masukkan efek nyeri lainnya">
                        <button class="btn btn-outline-danger remove-lainnya" type="button">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;

                lainnyaItemsContainer.appendChild(newItem);

                void newItem.offsetWidth;

                newItem.style.opacity = '1';
                newItem.style.transform = 'translateY(0)';

                const removeBtn = newItem.querySelector('.remove-lainnya');
                if (removeBtn) {
                    removeBtn.addEventListener('click', function() {
                        newItem.style.opacity = '0';
                        newItem.style.transform = 'translateY(-10px)';

                        setTimeout(() => {
                            newItem.remove();
                        }, 300);
                    });
                }

                const newInput = newItem.querySelector('.lainnya-input');
                if (newInput) {
                    setTimeout(() => newInput.focus(), 100);
                }
            });
        }

        // Add event listeners to initial remove buttons
        document.querySelectorAll('.remove-lainnya').forEach(button => {
            button.addEventListener('click', function() {
                const item = this.closest('.lainnya-item');

                item.style.opacity = '0';
                item.style.transform = 'translateY(-10px)';

                setTimeout(() => {
                    item.remove();
                }, 300);
            });
        });

        function createBadge(value, isLainnya = false) {
            let bgColor = isLainnya ? 'bg-info' : 'bg-primary';
            let icon = '';

            // Add specific icons based on value
            if (value === 'Mual/ muntah' || value === 'Muntah') {
                icon = '<i class="bi bi-emoji-frown me-1"></i>';
            } else if (value === 'Tidur') {
                icon = '<i class="bi bi-moon me-1"></i>';
            } else if (value === 'Nafsu makan') {
                icon = '<i class="bi bi-cup-hot me-1"></i>';
            } else if (value === 'Aktivitas') {
                icon = '<i class="bi bi-person-walking me-1"></i>';
            } else if (value === 'Emosi') {
                icon = '<i class="bi bi-emoji-angry me-1"></i>';
            } else {
                icon = '<i class="bi bi-tag me-1"></i>';
            }

            const badge = document.createElement('span');
            badge.className = `badge ${bgColor} me-2 mb-2`;
            badge.innerHTML = `${icon}${value} <span class="badge-remove ms-2"><i class="bi bi-x"></i></span>`;

            // Add click event to remove button
            const removeBtn = badge.querySelector('.badge-remove');
            if (removeBtn) {
                removeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();

                    // Animate removal
                    badge.style.opacity = '0';
                    badge.style.transform = 'scale(0.8)';

                    setTimeout(() => {
                        efekNyeriPilihan.removeChild(badge);

                        // Update checkbox
                        if (!isLainnya) {
                            checkboxEfekNyeri.forEach(function(cb) {
                                if (cb.value === value) {
                                    cb.checked = false;
                                }
                            });
                        }

                        updateInputValues();
                    }, 200);
                });
            }

            // Add animation styles
            badge.style.transition = 'all 0.3s ease';
            badge.style.opacity = '0';
            badge.style.transform = 'scale(0.8)';

            setTimeout(() => {
                badge.style.opacity = '1';
                badge.style.transform = 'scale(1)';
            }, 50);

            return badge;
        }

        // Update input fields based on selected badges
        function updateInputValues() {
            const badges = efekNyeriPilihan.querySelectorAll('.badge');
            const values = [];

            badges.forEach(function(badge) {
                const textContent = badge.textContent.trim().replace('×', '').trim();
                values.push(textContent);
            });

            const displayText = values.join(', ');
            efekNyeriDisplay.value = displayText;
            efekNyeriInput.value = displayText;

            if (efekNyeriDisplay) {
                efekNyeriDisplay.classList.add('border-primary');
                setTimeout(() => {
                    efekNyeriDisplay.classList.remove('border-primary');
                }, 500);
            }
        }

        // Handle saving selected options with better feedback
        if (btnSimpanEfekNyeri && efekNyeriPilihan && efekNyeriDisplay && efekNyeriInput) {
            btnSimpanEfekNyeri.addEventListener('click', function () {
                this.innerHTML = '<i class="bi bi-check2-all me-1"></i> Disimpan!';
                this.classList.add('btn-success');
                this.classList.remove('btn-primary');

                setTimeout(() => {
                    this.innerHTML = '<i class="bi bi-check-lg me-1"></i> Simpan Pilihan';
                    this.classList.remove('btn-success');
                    this.classList.add('btn-primary');
                }, 1000);

                const existingBadges = efekNyeriPilihan.querySelectorAll('.badge');
                existingBadges.forEach(badge => {
                    badge.style.opacity = '0';
                    badge.style.transform = 'scale(0.8)';
                });

                setTimeout(() => {
                    efekNyeriPilihan.innerHTML = '';

                    checkboxEfekNyeri.forEach(function (checkbox) {
                        if (checkbox.checked) {
                            const badge = createBadge(checkbox.value);
                            efekNyeriPilihan.appendChild(badge);
                        }
                    });

                    // Add "lainnya" selections if any
                    if (efekNyeriLainnya.checked) {
                        const lainnyaInputs = document.querySelectorAll('.lainnya-input');

                        lainnyaInputs.forEach(function(input) {
                            if (input.value.trim() !== '') {
                                const badge = createBadge(input.value.trim(), true);
                                efekNyeriPilihan.appendChild(badge);
                            }
                        });
                    }

                    updateInputValues();

                    modalEfekNyeri.hide();
                }, 300);
            });
        }

        // Reset form when modal is hidden (if no selections)
        if (modalEfekNyeriElement) {
            modalEfekNyeriElement.addEventListener('hidden.bs.modal', function () {
                if (efekNyeriInput && !efekNyeriInput.value) {
                    checkboxEfekNyeri.forEach(function (checkbox) {
                        checkbox.checked = false;
                    });

                    if (efekNyeriLainnya) efekNyeriLainnya.checked = false;
                    if (efekNyeriLainnyaContainer) efekNyeriLainnyaContainer.classList.add('d-none');

                    document.querySelectorAll('.lainnya-input').forEach(input => {
                        input.value = '';
                    });

                    const lainnyaItems = document.querySelectorAll('.lainnya-item');
                    for (let i = 1; i < lainnyaItems.length; i++) {
                        lainnyaItems[i].remove();
                    }
                }
            });
        }

        if (efekNyeriInput && efekNyeriInput.value && efekNyeriPilihan) {
            const savedValues = efekNyeriInput.value.split(', ');
            if (efekNyeriDisplay) efekNyeriDisplay.value = efekNyeriInput.value;

            const standardValues = [];
            const lainnyaValues = [];

            savedValues.forEach(value => {
                let found = false;

                checkboxEfekNyeri.forEach(checkbox => {
                    if (value === checkbox.value) {
                        checkbox.checked = true;
                        found = true;
                        standardValues.push(value);

                        const badge = createBadge(value);
                        efekNyeriPilihan.appendChild(badge);
                    }
                });

                if (!found) {
                    lainnyaValues.push(value);

                    const badge = createBadge(value, true);
                    efekNyeriPilihan.appendChild(badge);
                }
            });

            if (lainnyaValues.length > 0) {
                efekNyeriLainnya.checked = true;
                efekNyeriLainnyaContainer.classList.remove('d-none');

                const lainnyaItemsContainer = document.querySelector('.lainnya-items');
                if (lainnyaItemsContainer) {
                    lainnyaItemsContainer.innerHTML = '';

                    lainnyaValues.forEach(value => {
                        const newItem = document.createElement('div');
                        newItem.className = 'lainnya-item mb-2';
                        newItem.innerHTML = `
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-plus-circle text-primary"></i>
                                </span>
                                <input type="text" class="form-control lainnya-input"
                                    value="${value}" placeholder="Masukkan efek nyeri lainnya">
                                <button class="btn btn-outline-danger remove-lainnya" type="button">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        `;

                        lainnyaItemsContainer.appendChild(newItem);

                        const removeBtn = newItem.querySelector('.remove-lainnya');
                        if (removeBtn) {
                            removeBtn.addEventListener('click', function() {
                                newItem.style.opacity = '0';
                                newItem.style.transform = 'translateY(-10px)';

                                setTimeout(() => {
                                    newItem.remove();
                                }, 300);
                            });
                        }
                    });
                }
            }
        }
    });
</script>
