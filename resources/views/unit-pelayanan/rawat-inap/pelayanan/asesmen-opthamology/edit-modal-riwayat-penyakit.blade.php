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
                        <input type="text" class="form-control" id="penyakitInput" placeholder="Masukkan nama penyakit">
                        <button class="btn btn-outline-secondary" type="button" id="tambahKeList">
                            <i class="ti-plus"></i>
                        </button>
                    </div>
                </div>
                <!-- Temporary list in modal -->
                <div id="modalPenyakitList" class="d-flex flex-column gap-2">
                    <div id="modalEmptyState" class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                        <p class="mb-0">Belum ada penyakit dalam list sementara</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanPenyakit" data-bs-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for adding family health history -->
<div class="modal fade" id="riwayatKeluargaModal" tabindex="-1" aria-labelledby="riwayatKeluargaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="riwayatKeluargaModalLabel">Tambah Riwayat Kesehatan Keluarga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="riwayatInput" class="form-label">Riwayat Kesehatan</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="riwayatInput" placeholder="Masukkan riwayat kesehatan">
                        <button class="btn btn-outline-secondary" type="button" id="tambahKeListRiwayat">
                            <i class="ti-plus"></i>
                        </button>
                    </div>
                </div>
                <!-- Temporary list in modal -->
                <div id="modalRiwayatList" class="d-flex flex-column gap-2">
                    <div id="modalEmptyStateRiwayat" class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                        <p class="mb-0">Belum ada riwayat dalam list sementara</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanRiwayat" data-bs-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============= PENYAKIT YANG PERNAH DIDERITA =============
    // Arrays to store the diseases
    let penyakitList = [];
    let tempPenyakitList = [];
    
    // Load initial data for penyakit
    const penyakitInput = document.getElementById('penyakitDideritaInput');
    try {
        const penyakitData = penyakitInput.value.trim();
        if (penyakitData && penyakitData !== '[]') {
            penyakitList = JSON.parse(penyakitData);
        }
    } catch (error) {
        console.error('Error parsing penyakit data:', error);
    }

    // Function to update the main UI and hidden input for penyakit
    function updatePenyakitList() {
        const listContainer = document.getElementById('selectedPenyakitList');
        const hiddenInput = document.getElementById('penyakitDideritaInput');
        const emptyState = document.getElementById('emptyState');

        // Clear the current list
        listContainer.innerHTML = '';

        if (penyakitList.length === 0) {
            listContainer.appendChild(emptyState);
        } else {
            // Remove emptyState from DOM if it exists
            if (emptyState.parentNode === listContainer) {
                listContainer.removeChild(emptyState);
            }
            
            // Add each disease to the list
            penyakitList.forEach((penyakit, index) => {
                const item = document.createElement('div');
                item.className = 'p-2 bg-light rounded d-flex justify-content-between align-items-center';
                item.innerHTML = `
                    <span>${penyakit}</span>
                    <button type="button" class="btn btn-sm btn-danger delete-penyakit" data-index="${index}">
                        <i class="ti-trash"></i>
                    </button>
                `;
                listContainer.appendChild(item);
            });
            
            // Add event listeners to delete buttons
            document.querySelectorAll('.delete-penyakit').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    removePenyakit(index);
                });
            });
        }

        // Update hidden input with JSON string
        hiddenInput.value = JSON.stringify(penyakitList);
    }

    // Function to update the modal's temporary list for penyakit
    function updateModalList() {
        const modalList = document.getElementById('modalPenyakitList');
        const modalEmptyState = document.getElementById('modalEmptyState');

        // Clear the current list
        modalList.innerHTML = '';

        if (tempPenyakitList.length === 0) {
            // Create and append empty state
            const newEmptyState = document.createElement('div');
            newEmptyState.id = 'modalEmptyState';
            newEmptyState.className = 'border border-dashed border-secondary rounded p-3 text-center text-muted';
            newEmptyState.innerHTML = '<p class="mb-0">Belum ada penyakit dalam list sementara</p>';
            modalList.appendChild(newEmptyState);
        } else {
            // Add each disease to the temporary list
            tempPenyakitList.forEach((penyakit, index) => {
                const item = document.createElement('div');
                item.className = 'p-2 bg-light rounded d-flex justify-content-between align-items-center';
                item.innerHTML = `
                    <span>${penyakit}</span>
                    <button type="button" class="btn btn-sm btn-danger delete-temp-penyakit" data-index="${index}">
                        <i class="ti-trash"></i>
                    </button>
                `;
                modalList.appendChild(item);
            });
            
            // Add event listeners to delete buttons
            document.querySelectorAll('.delete-temp-penyakit').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    removeTempPenyakit(index);
                });
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

    // Add event listeners for penyakit
    document.getElementById('tambahKeList').addEventListener('click', addToTempList);
    document.getElementById('simpanPenyakit').addEventListener('click', savePenyakit);

    // Add event listener for enter key in input for penyakit
    document.getElementById('penyakitInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addToTempList();
        }
    });

    // Reset temporary list when modal is opened for penyakit
    document.getElementById('penyakitModal').addEventListener('show.bs.modal', function() {
        tempPenyakitList = [];
        updateModalList();
        document.getElementById('penyakitInput').value = '';
    });
    
    // ============= RIWAYAT KESEHATAN KELUARGA =============
    // Arrays to store the health history
    let riwayatList = [];
    let tempRiwayatList = [];
    
    // Load initial data for riwayat
    const riwayatInput = document.getElementById('riwayatKesehatanInput');
    try {
        const riwayatData = riwayatInput.value.trim();
        if (riwayatData && riwayatData !== '[]') {
            riwayatList = JSON.parse(riwayatData);
        }
    } catch (error) {
        console.error('Error parsing riwayat data:', error);
    }

    // Function to update the main UI and hidden input for riwayat
    function updateRiwayatList() {
        const listContainer = document.getElementById('selectedRiwayatList');
        const hiddenInput = document.getElementById('riwayatKesehatanInput');
        const emptyState = document.getElementById('emptyStateRiwayat');

        // Clear the current list
        listContainer.innerHTML = '';

        if (riwayatList.length === 0) {
            listContainer.appendChild(emptyState);
        } else {
            // Remove emptyState from DOM if it exists
            if (emptyState.parentNode === listContainer) {
                listContainer.removeChild(emptyState);
            }
            
            // Add each health history to the list
            riwayatList.forEach((riwayat, index) => {
                const item = document.createElement('div');
                item.className = 'p-2 bg-light rounded d-flex justify-content-between align-items-center';
                item.innerHTML = `
                    <span>${riwayat}</span>
                    <button type="button" class="btn btn-sm btn-danger delete-riwayat" data-index="${index}">
                        <i class="ti-trash"></i>
                    </button>
                `;
                listContainer.appendChild(item);
            });
            
            // Add event listeners to delete buttons
            document.querySelectorAll('.delete-riwayat').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    removeRiwayat(index);
                });
            });
        }

        // Update hidden input with JSON string
        hiddenInput.value = JSON.stringify(riwayatList);
    }

    // Function to update the modal's temporary list for riwayat
    function updateModalRiwayatList() {
        const modalList = document.getElementById('modalRiwayatList');
        const modalEmptyState = document.getElementById('modalEmptyStateRiwayat');

        // Clear the current list
        modalList.innerHTML = '';

        if (tempRiwayatList.length === 0) {
            // Create and append empty state
            const newEmptyState = document.createElement('div');
            newEmptyState.id = 'modalEmptyStateRiwayat';
            newEmptyState.className = 'border border-dashed border-secondary rounded p-3 text-center text-muted';
            newEmptyState.innerHTML = '<p class="mb-0">Belum ada riwayat dalam list sementara</p>';
            modalList.appendChild(newEmptyState);
        } else {
            // Add each health history to the temporary list
            tempRiwayatList.forEach((riwayat, index) => {
                const item = document.createElement('div');
                item.className = 'p-2 bg-light rounded d-flex justify-content-between align-items-center';
                item.innerHTML = `
                    <span>${riwayat}</span>
                    <button type="button" class="btn btn-sm btn-danger delete-temp-riwayat" data-index="${index}">
                        <i class="ti-trash"></i>
                    </button>
                `;
                modalList.appendChild(item);
            });
            
            // Add event listeners to delete buttons
            document.querySelectorAll('.delete-temp-riwayat').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    removeTempRiwayat(index);
                });
            });
        }
    }

    // Function to add a new health history to temporary list
    function addToTempRiwayatList() {
        const input = document.getElementById('riwayatInput');
        const riwayat = input.value.trim();

        if (riwayat) {
            tempRiwayatList.push(riwayat);
            updateModalRiwayatList();
            input.value = '';
            input.focus();
        }
    }

    // Function to save temporary list to main list
    function saveRiwayat() {
        if (tempRiwayatList.length > 0) {
            riwayatList = [...riwayatList, ...tempRiwayatList];
            tempRiwayatList = []; // Clear temporary list
            updateRiwayatList();
            updateModalRiwayatList();
        }
    }

    // Function to remove a health history from main list
    function removeRiwayat(index) {
        riwayatList.splice(index, 1);
        updateRiwayatList();
    }

    // Function to remove a health history from temporary list
    function removeTempRiwayat(index) {
        tempRiwayatList.splice(index, 1);
        updateModalRiwayatList();
    }

    // Add event listeners for riwayat
    document.getElementById('tambahKeListRiwayat').addEventListener('click', addToTempRiwayatList);
    document.getElementById('simpanRiwayat').addEventListener('click', saveRiwayat);

    // Add event listener for enter key in input for riwayat
    document.getElementById('riwayatInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addToTempRiwayatList();
        }
    });

    // Reset temporary list when modal is opened for riwayat
    document.getElementById('riwayatKeluargaModal').addEventListener('show.bs.modal', function() {
        tempRiwayatList = [];
        updateModalRiwayatList();
        document.getElementById('riwayatInput').value = '';
    });

    // Initial update for both lists
    updatePenyakitList();
    updateRiwayatList();
    updateModalList();
    updateModalRiwayatList();
});
</script>