@push('js')
    <script>
        (function() {
            'use strict';

            let cairanData = [];

            const selectCairan = document.getElementById('cairan-select');
            const inputJumlah = document.getElementById('cairan-jumlah');
            const inputLainnya = document.getElementById('cairan-lainnya');
            const btnAdd = document.getElementById('btn-add-cairan');
            const listContainer = document.getElementById('list-pemakaian-cairan');
            const emptyMessage = document.getElementById('empty-cairan');
            const hiddenInput = document.getElementById('hidden-pemakaian-cairan');

            // Check if elements exist
            if (!selectCairan || !inputJumlah || !btnAdd || !listContainer || !hiddenInput) {
                console.error('Pemakaian cairan elements not found');
                return;
            }

            // Toggle input lainnya
            selectCairan.addEventListener('change', function() {
                if (this.value === 'Lainnya') {
                    inputLainnya.classList.remove('d-none');
                } else {
                    inputLainnya.classList.add('d-none');
                    inputLainnya.value = '';
                }
            });

            // Add item
            function addCairan() {
                let jenisCairan = selectCairan.value;
                const jumlah = inputJumlah.value.trim();

                // Jika pilih "Lainnya"
                if (jenisCairan === 'Lainnya') {
                    const lainnyaText = inputLainnya.value.trim();
                    if (!lainnyaText) {
                        alert('Sebutkan jenis cairan lainnya!');
                        inputLainnya.focus();
                        return;
                    }
                    jenisCairan = lainnyaText;
                }

                // Validation
                if (!jenisCairan) {
                    alert('Pilih jenis cairan terlebih dahulu!');
                    selectCairan.focus();
                    return;
                }

                if (!jumlah) {
                    alert('Masukkan jumlah cairan!');
                    inputJumlah.focus();
                    return;
                }

                // Add to array
                cairanData.push({
                    jenis: jenisCairan,
                    jumlah: jumlah
                });

                updateHidden();
                renderList();

                // Reset form
                selectCairan.value = '';
                inputJumlah.value = '';
                inputLainnya.value = '';
                inputLainnya.classList.add('d-none');
                selectCairan.focus();
            }

            // Remove item
            function removeCairan(index) {
                cairanData.splice(index, 1);
                updateHidden();
                renderList();
            }

            // Render list
            function renderList() {
                // Clear list kecuali empty message
                Array.from(listContainer.children).forEach(child => {
                    if (child.id !== 'empty-cairan') {
                        child.remove();
                    }
                });

                // Show/hide empty message
                if (cairanData.length === 0) {
                    emptyMessage.style.display = 'block';
                    return;
                }
                emptyMessage.style.display = 'none';

                // Render items
                cairanData.forEach((item, index) => {
                    const div = document.createElement('div');
                    div.className = 'd-flex justify-content-between align-items-center mb-2 gap-2';
                    div.innerHTML = `
                <span class="border rounded px-2 py-1 w-100 bg-white">
                    <strong>${escapeHtml(item.jenis)}</strong>: ${escapeHtml(item.jumlah)} Liter
                </span>
                <button type="button" class="btn btn-sm btn-danger btn-remove-cairan" data-index="${index}">
                    <i class="bi bi-trash"></i>
                </button>
            `;
                    listContainer.appendChild(div);
                });

                // Add remove event listeners
                document.querySelectorAll('.btn-remove-cairan').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const idx = parseInt(this.getAttribute('data-index'));
                        removeCairan(idx);
                    });
                });
            }

            // Update hidden input
            function updateHidden() {
                hiddenInput.value = JSON.stringify(cairanData);
            }

            // Escape HTML
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            // Load existing data (untuk edit)
            function loadData() {
                try {
                    const data = hiddenInput.value;
                    if (data && data !== '[]') {
                        cairanData = JSON.parse(data);
                        renderList();
                    }
                } catch (e) {
                    console.error('Error loading data:', e);
                    cairanData = [];
                }
            }

            // Event listeners dengan preventDefault
            btnAdd.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                addCairan();
            });

            inputJumlah.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    e.stopPropagation();
                    addCairan();
                }
            });

            inputLainnya.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    e.stopPropagation();
                    addCairan();
                }
            });

            selectCairan.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });

            // Initialize
            loadData();

        })();
    </script>
    <!-- Script Spesimen dengan Checkbox -->
    <script>
        (function() {
            'use strict';

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initSpesimen);
            } else {
                initSpesimen();
            }

            function initSpesimen() {
                let spesimenData = [];

                const selectSpesimen = document.getElementById('spesimen-select');
                const inputJenis = document.getElementById('spesimen-jenis');
                const btnAdd = document.getElementById('btn-add-spesimen');
                const listContainer = document.getElementById('list-spesimen');
                const emptyMessage = document.getElementById('empty-spesimen');
                const hiddenInput = document.getElementById('hidden-spesimen');
                const checkboxWrapper = document.getElementById('spesimen-checkbox-wrapper');
                const checkbox = document.getElementById('spesimen-checkbox');

                if (!selectSpesimen || !inputJenis || !btnAdd || !listContainer || !hiddenInput) {
                    console.log('Spesimen elements not found');
                    return;
                }

                console.log('Spesimen initialized');

                // Show/hide checkbox based on selection
                selectSpesimen.addEventListener('change', function() {
                    const value = this.value;

                    if (value === 'Sitologi' || value === 'Lainnya') {
                        checkboxWrapper.style.display = 'flex';
                        checkbox.checked = false;
                    } else {
                        checkboxWrapper.style.display = 'none';
                        checkbox.checked = false;
                    }
                });

                function addSpesimen() {
                    const kategori = selectSpesimen.value;
                    const jenis = inputJenis.value.trim();
                    const isChecked = (kategori === 'Sitologi' || kategori === 'Lainnya') ? checkbox.checked : null;

                    if (!kategori) {
                        alert('Pilih kategori spesimen!');
                        selectSpesimen.focus();
                        return;
                    }

                    if (!jenis) {
                        alert('Masukkan jenis spesimen!');
                        inputJenis.focus();
                        return;
                    }

                    // Simpan data dengan info checkbox (hanya untuk Sitologi dan Lainnya)
                    const data = {
                        kategori: kategori,
                        jenis: jenis
                    };

                    if (kategori === 'Sitologi' || kategori === 'Lainnya') {
                        data.checked = isChecked;
                    }

                    spesimenData.push(data);
                    updateHidden();
                    renderList();

                    // Reset form
                    selectSpesimen.value = '';
                    inputJenis.value = '';
                    checkboxWrapper.style.display = 'none';
                    checkbox.checked = false;
                    selectSpesimen.focus();
                }

                function removeSpesimen(index) {
                    spesimenData.splice(index, 1);
                    updateHidden();
                    renderList();
                }

                function renderList() {
                    Array.from(listContainer.children).forEach(child => {
                        if (child.id !== 'empty-spesimen') child.remove();
                    });

                    if (spesimenData.length === 0) {
                        emptyMessage.style.display = 'block';
                        return;
                    }
                    emptyMessage.style.display = 'none';

                    spesimenData.forEach((item, index) => {
                        const div = document.createElement('div');
                        div.className = 'd-flex justify-content-between align-items-center mb-2 gap-2';

                        // Tampilkan checkbox icon kalau ada
                        let checkIcon = '';
                        if (item.checked !== undefined) {
                            checkIcon = item.checked ? ' ✓' : ' ✗';
                        }

                        div.innerHTML = `
                    <span class="border rounded px-2 py-1 w-100 bg-white">
                        <strong>${escapeHtml(item.kategori)}</strong>${checkIcon}: ${escapeHtml(item.jenis)}
                    </span>
                    <button type="button" class="btn btn-sm btn-danger btn-remove-spesimen" data-index="${index}">
                        <i class="bi bi-trash"></i>
                    </button>
                `;
                        listContainer.appendChild(div);
                    });

                    document.querySelectorAll('.btn-remove-spesimen').forEach(btn => {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            removeSpesimen(parseInt(this.getAttribute('data-index')));
                        });
                    });
                }

                function updateHidden() {
                    hiddenInput.value = JSON.stringify(spesimenData);
                }

                function escapeHtml(text) {
                    const div = document.createElement('div');
                    div.textContent = text;
                    return div.innerHTML;
                }

                function loadData() {
                    try {
                        const data = hiddenInput.value;
                        if (data && data !== '[]') {
                            spesimenData = JSON.parse(data);
                            renderList();
                        }
                    } catch (e) {
                        console.error('Error loading spesimen:', e);
                    }
                }

                btnAdd.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    addSpesimen();
                });

                inputJenis.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        e.stopPropagation();
                        addSpesimen();
                    }
                });

                selectSpesimen.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                });

                loadData();
            }

        })();
    </script>
@endpush
