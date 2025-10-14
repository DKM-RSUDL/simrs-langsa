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
                    btn.addEventListener('click', function() {
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

            // Load existing data
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

            // Event listeners
            btnAdd.addEventListener('click', addCairan);

            inputJumlah.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addCairan();
                }
            });

            inputLainnya.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addCairan();
                }
            });

            // Initialize - load existing data
            loadData();

        })();
    </script>
@endpush
