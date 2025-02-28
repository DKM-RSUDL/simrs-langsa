<!-- Modal Pengambilan Keputusan -->
<div class="modal fade" id="modalPengambilanKeputusan" tabindex="-1" aria-labelledby="modalPengambilanKeputusanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalPengambilanKeputusanLabel">
                    <i class="bi bi-list-check me-2"></i>Pilih Pengambilan Keputusan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div>Pilih opsi pengambilan keputusan. Anda dapat memilih lebih dari satu opsi.</div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>Pengambilan Keputusan</strong>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item border-0 px-0">
                                <div class="form-check">
                                    <input class="form-check-input pengambilanKeputusanCheckbox" type="checkbox" value="Pasien Sendiri" id="pengambilanKeputusanPasien">
                                    <label class="form-check-label" for="pengambilanKeputusanPasien">
                                        <i class="bi bi-person text-primary me-2"></i> Pasien Sendiri
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="form-check">
                                    <input class="form-check-input pengambilanKeputusanCheckbox" type="checkbox" value="Suami" id="pengambilanKeputusanSuami">
                                    <label class="form-check-label" for="pengambilanKeputusanSuami">
                                        <i class="bi bi-person-fill text-success me-2"></i> Suami
                                    </label>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="form-check">
                                    <input class="form-check-input pengambilanKeputusanCheckbox" type="checkbox" value="Keluarga" id="pengambilanKeputusanKeluarga">
                                    <label class="form-check-label" for="pengambilanKeputusanKeluarga">
                                        <i class="bi bi-people-fill text-warning me-2"></i> Keluarga
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
                            <input class="form-check-input" type="checkbox" value="lainnya" id="pengambilanKeputusanLainnya">
                            <label class="form-check-label fw-bold" for="pengambilanKeputusanLainnya">
                                Pengambilan Keputusan Lainnya
                            </label>
                        </div>
                    </div>
                    <div id="pengambilanKeputusanLainnyaContainer" class="card-body d-none">
                        <p class="text-muted small mb-3">Tambahkan pengambil keputusan lain yang tidak tercantum di atas</p>
                        <div class="pengambilanKeputusanLainnyaItems">
                            <div class="lainnya-item mb-2">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-plus-circle text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control pengambilanKeputusanLainnyaInput" placeholder="Masukkan pengambil keputusan lainnya">
                                    <button class="btn btn-outline-danger remove-pengambilanKeputusanLainnya" type="button" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addMorePengambilanKeputusanLainnya">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Pengambil Keputusan Lainnya
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="btnSimpanPengambilanKeputusan">
                    <i class="bi bi-check-lg me-1"></i> Simpan Pilihan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Element references
    const modalPengambilanKeputusanElement = document.getElementById('modalPengambilanKeputusan');
    const btnPilihPengambilanKeputusan = document.getElementById('btnPilihPengambilanKeputusan');
    const pengambilanKeputusanLainnya = document.getElementById('pengambilanKeputusanLainnya');
    const pengambilanKeputusanLainnyaContainer = document.getElementById('pengambilanKeputusanLainnyaContainer');
    const addMorePengambilanKeputusanLainnyaBtn = document.getElementById('addMorePengambilanKeputusanLainnya');
    const btnSimpanPengambilanKeputusan = document.getElementById('btnSimpanPengambilanKeputusan');
    const pengambilanKeputusanDisplay = document.getElementById('pengambilanKeputusanDisplay');
    const pengambilanKeputusanInput = document.getElementById('PengambilanKeputusanlInput');
    const pengambilanKeputusanPilihan = document.getElementById('PengambilanKeputusanPilihan');
    const checkboxPengambilanKeputusan = document.querySelectorAll('.pengambilanKeputusanCheckbox');
    const pengambilanKeputusanLainnyaItemsContainer = document.querySelector('.pengambilanKeputusanLainnyaItems');

    // Validation
    if (!modalPengambilanKeputusanElement || !btnSimpanPengambilanKeputusan || !pengambilanKeputusanPilihan || !pengambilanKeputusanDisplay || !pengambilanKeputusanInput) {
        console.error('One or more required elements are missing.');
        return;
    }

    // Initialize modal
    let modalPengambilanKeputusan;
    try {
        modalPengambilanKeputusan = new bootstrap.Modal(modalPengambilanKeputusanElement);
    } catch (error) {
        console.error('Failed to initialize modal:', error);
        return;
    }

    // Open modal
    if (btnPilihPengambilanKeputusan) {
        btnPilihPengambilanKeputusan.addEventListener('click', () => modalPengambilanKeputusan.show());
    } else {
        console.warn('Button to open modal not found.');
    }

    // Toggle "Lainnya" section
    if (pengambilanKeputusanLainnya && pengambilanKeputusanLainnyaContainer) {
        pengambilanKeputusanLainnya.addEventListener('change', function () {
            if (this.checked) {
                pengambilanKeputusanLainnyaContainer.classList.remove('d-none');
                const firstInput = pengambilanKeputusanLainnyaContainer.querySelector('.pengambilanKeputusanLainnyaInput');
                if (firstInput) {
                    setTimeout(() => firstInput.focus(), 100);
                }
            } else {
                pengambilanKeputusanLainnyaContainer.classList.add('d-none');
                document.querySelectorAll('.pengambilanKeputusanLainnyaInput').forEach(input => {
                    input.value = '';
                });
                const lainnyaItems = pengambilanKeputusanLainnyaContainer.querySelectorAll('.lainnya-item');
                for (let i = 1; i < lainnyaItems.length; i++) {
                    lainnyaItems[i].remove();
                }
                if (lainnyaItems.length > 0) {
                    lainnyaItems[0].querySelector('.pengambilanKeputusanLainnyaInput').value = '';
                }
            }
        });
    } else {
        console.warn('Checkbox or container for "Pengambilan Keputusan Lainnya" not found.');
    }

    // Add new "Lainnya" input
    if (addMorePengambilanKeputusanLainnyaBtn && pengambilanKeputusanLainnyaItemsContainer) {
        addMorePengambilanKeputusanLainnyaBtn.addEventListener('click', function () {
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
                <input type="text" class="form-control pengambilanKeputusanLainnyaInput" placeholder="Masukkan pengambil keputusan lainnya" value="${value}">
                <button class="btn btn-outline-danger remove-pengambilanKeputusanLainnya" type="button" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;

        pengambilanKeputusanLainnyaItemsContainer.appendChild(newItem);

        void newItem.offsetWidth;

        newItem.style.opacity = '1';
        newItem.style.transform = 'translateY(0)';

        const removeBtn = newItem.querySelector('.remove-pengambilanKeputusanLainnya');
        if (removeBtn) {
            removeBtn.addEventListener('click', function () {
                newItem.style.opacity = '0';
                newItem.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    newItem.remove();
                }, 300);
            });
        }

        const newInput = newItem.querySelector('.pengambilanKeputusanLainnyaInput');
        if (newInput && !value) {
            setTimeout(() => newInput.focus(), 100);
        }

        return newItem;
    }

    // Add event listeners to initial remove buttons
    document.querySelectorAll('.remove-pengambilanKeputusanLainnya').forEach(button => {
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
            'Pasien Sendiri': '<i class="bi bi-person text-light me-1"></i>',
            'Suami': '<i class="bi bi-person-fill text-light me-1"></i>',
            'Keluarga': '<i class="bi bi-people-fill text-light me-1"></i>'
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
                        checkboxPengambilanKeputusan.forEach(cb => {
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
        const values = Array.from(pengambilanKeputusanPilihan.querySelectorAll('.badge'))
            .map(badge => badge.textContent.replace('×', '').trim());
        const displayText = values.join(', ');
        pengambilanKeputusanDisplay.value = displayText;
        pengambilanKeputusanInput.value = displayText;
        if (pengambilanKeputusanDisplay) {
            pengambilanKeputusanDisplay.classList.add('border-primary');
            setTimeout(() => pengambilanKeputusanDisplay.classList.remove('border-primary'), 500);
        }
    }

    // Save selections
    if (btnSimpanPengambilanKeputusan) {
        btnSimpanPengambilanKeputusan.addEventListener('click', function () {
            this.innerHTML = '<i class="bi bi-check2-all me-1"></i> Disimpan!';
            this.classList.replace('btn-primary', 'btn-success');

            setTimeout(() => {
                this.innerHTML = '<i class="bi bi-check-lg me-1"></i> Simpan Pilihan';
                this.classList.replace('btn-success', 'btn-primary');
            }, 1000);

            Array.from(pengambilanKeputusanPilihan.children).forEach(badge => {
                badge.style.opacity = '0';
                badge.style.transform = 'scale(0.8)';
            });

            setTimeout(() => {
                pengambilanKeputusanPilihan.innerHTML = '';

                checkboxPengambilanKeputusan.forEach(checkbox => {
                    if (checkbox.checked) {
                        pengambilanKeputusanPilihan.appendChild(createBadge(checkbox.value));
                    }
                });

                if (pengambilanKeputusanLainnya.checked) {
                    document.querySelectorAll('.pengambilanKeputusanLainnyaInput').forEach(input => {
                        const value = input.value.trim();
                        if (value) {
                            pengambilanKeputusanPilihan.appendChild(createBadge(value, true));
                        }
                    });
                }

                updateInputValues();
                modalPengambilanKeputusan.hide();
            }, 300);
        });
    }

    // Reset on modal close
    if (modalPengambilanKeputusanElement) {
        modalPengambilanKeputusanElement.addEventListener('hidden.bs.modal', function () {
            if (!pengambilanKeputusanInput.value) {
                checkboxPengambilanKeputusan.forEach(checkbox => checkbox.checked = false);
                if (pengambilanKeputusanLainnya) pengambilanKeputusanLainnya.checked = false;
                if (pengambilanKeputusanLainnyaContainer) pengambilanKeputusanLainnyaContainer.classList.add('d-none');
                document.querySelectorAll('.pengambilanKeputusanLainnyaInput').forEach(input => input.value = '');
                const lainnyaItems = document.querySelectorAll('.lainnya-item');
                for (let i = 1; i < lainnyaItems.length; i++) {
                    lainnyaItems[i].remove();
                }
                if (lainnyaItems.length > 0) {
                    lainnyaItems[0].querySelector('.pengambilanKeputusanLainnyaInput').value = '';
                }
            }
        });
    }

    // Load saved values
    if (pengambilanKeputusanInput && pengambilanKeputusanInput.value) {
        const savedValues = pengambilanKeputusanInput.value.split(', ').map(v => v.trim());
        pengambilanKeputusanDisplay.value = pengambilanKeputusanInput.value;

        savedValues.forEach(value => {
            const checkbox = Array.from(checkboxPengambilanKeputusan).find(cb => cb.value === value);
            if (checkbox) {
                checkbox.checked = true;
                pengambilanKeputusanPilihan.appendChild(createBadge(value));
            } else {
                pengambilanKeputusanLainnya.checked = true;
                pengambilanKeputusanLainnyaContainer.classList.remove('d-none');
                addLainnyaItem(value);
                pengambilanKeputusanPilihan.appendChild(createBadge(value, true));
            }
        });
    }
});
</script>
