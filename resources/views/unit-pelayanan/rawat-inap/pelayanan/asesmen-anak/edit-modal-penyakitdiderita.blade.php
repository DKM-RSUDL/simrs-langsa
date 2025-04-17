<!-- Modal for adding diseases -->
<div class="modal fade" id="penyakitModal" tabindex="-1" aria-labelledby="penyakitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="penyakitModalLabel">Tambah Penyakit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="penyakitInput" class="form-label">Nama Penyakit</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="penyakitInput"
                            placeholder="Masukkan nama penyakit">
                        <button class="btn btn-outline-secondary" type="button" id="tambahKeList">
                            <i class="ti-plus"></i>
                        </button>
                    </div>
                </div>
                <!-- Temporary list in modal -->
                <div id="modalPenyakitList" class="d-flex flex-column gap-2">
                    <div id="modalEmptyState"
                        class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                        <p class="mb-0">Belum ada penyakit dalam list sementara</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanPenyakit"
                    data-bs-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        // Array to store the diseases
        let penyakitList = [];
        let tempPenyakitList = [];
        const existingData = document.getElementById('penyakitDideritaInput').value;

        try {
            // Parse data jika dalam bentuk string JSON
            if (existingData) {
                penyakitList = typeof existingData === 'string' ? JSON.parse(existingData) : existingData;
            }
        } catch (e) {
            console.error('Error parsing penyakit data:', e);
            penyakitList = [];
        }

        // Function to update the main UI and hidden input
        function updatePenyakitList() {
            const listContainer = document.getElementById('selectedPenyakitList');
            const hiddenInput = document.getElementById('penyakitDideritaInput');
            const emptyState = document.getElementById('emptyState');

            // Clear the current list
            listContainer.innerHTML = '';

            if (penyakitList.length === 0) {
                listContainer.appendChild(emptyState);
            } else {
                // Add each disease to the list
                penyakitList.forEach((penyakit, index) => {
                    const item = document.createElement('div');
                    item.className = 'p-2 bg-light rounded d-flex justify-content-between align-items-center';
                    item.innerHTML = `
                    <span>${penyakit}</span>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removePenyakit(${index})">
                        <i class="ti-trash"></i>
                    </button>
                `;
                    listContainer.appendChild(item);
                });
            }

            // Update hidden input with JSON string
            hiddenInput.value = JSON.stringify(penyakitList);
        }

        // Function to update the modal's temporary list
        function updateModalList() {
            const modalList = document.getElementById('modalPenyakitList');
            // Buat ulang empty state element
            const modalEmptyState = document.createElement('div');
            modalEmptyState.id = 'modalEmptyState';
            modalEmptyState.className = 'border border-dashed border-secondary rounded p-3 text-center text-muted';
            modalEmptyState.innerHTML = '<p class="mb-0">Belum ada penyakit dalam list sementara</p>';

            // Clear the current list
            modalList.innerHTML = '';

            if (tempPenyakitList.length === 0) {
                modalList.appendChild(modalEmptyState);
            } else {
                // Add each disease to the temporary list
                tempPenyakitList.forEach((penyakit, index) => {
                    const item = document.createElement('div');
                    item.className = 'p-2 bg-light rounded d-flex justify-content-between align-items-center';
                    item.innerHTML = `
                        <span>${penyakit}</span>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeTempPenyakit(${index})">
                            <i class="ti-trash"></i>
                        </button>
                    `;
                    modalList.appendChild(item);
                });
            }
        }

        // Function to add a new disease to temporary list
        function addToTempList() {
            const input = document.getElementById('penyakitInput');
            const penyakit = input.value.trim();

            if (penyakit) {
                tempPenyakitList.push(penyakit);
                updateModalList();
                input.value = '';
                input.focus();
            }
        }

        // Function to save temporary list to main list
        function savePenyakit() {
            if (tempPenyakitList.length > 0) {
                penyakitList = [...penyakitList, ...tempPenyakitList];
                tempPenyakitList = []; // Clear temporary list
                updatePenyakitList();

                // Tutup modal
                document.querySelector('[data-bs-dismiss="modal"]').click();

                // Update list setelah modal tertutup
                updateModalList();
            }
        }

        // Function to remove a disease from main list
        function removePenyakit(index) {
            penyakitList.splice(index, 1);
            updatePenyakitList();
        }

        // Function to remove a disease from temporary list
        function removeTempPenyakit(index) {
            tempPenyakitList.splice(index, 1);
            updateModalList();
        }

        // Add event listeners
        document.getElementById('tambahKeList').addEventListener('click', addToTempList);
        document.getElementById('simpanPenyakit').addEventListener('click', savePenyakit);

        // Add event listener for enter key in input
        document.getElementById('penyakitInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addToTempList();
            }
        });

        // Reset temporary list when modal is opened
        document.getElementById('penyakitModal').addEventListener('show.bs.modal', function() {
            tempPenyakitList = [];
            updateModalList();
            document.getElementById('penyakitInput').value = '';
        });

        // Initial update
        updatePenyakitList();
        updateModalList();
    </script>
@endpush
