<!-- Modified Form Group for Penyakit Yang Pernah Diderita -->
<div class="form-group">
    <label style="min-width: 200px;">Penyakit Yang Pernah Diderita</label>
    <div class="w-100">
        <button type="button" class="btn btn-sm btn-outline-secondary mb-3" data-bs-toggle="modal"
            data-bs-target="#penyakitModal">
            <i class="ti-plus"></i> Tambah
        </button>
        <div id="selectedPenyakitList" class="d-flex flex-column gap-2">
            <!-- Empty state message -->
            <div id="emptyState" class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                <i class="ti-info-circle mb-2"></i>
                <p class="mb-0">Belum ada penyakit yang ditambahkan. Klik tombol tambah untuk menambahkan penyakit.
                </p>
            </div>
        </div>
        <!-- Hidden input to store the JSON data -->
        <input type="hidden" name="penyakit_diderita" id="penyakitDideritaInput">
    </div>
</div>

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
                <button type="button" class="btn btn-primary" id="simpanPenyakit">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Array to store the diseases
    let penyakitList = [];
    let tempPenyakitList = [];

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
        const modalEmptyState = document.getElementById('modalEmptyState');

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
            updateModalList();

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('penyakitModal'));
            modal.hide();
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
