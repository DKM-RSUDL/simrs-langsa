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
// Arrays to store the health history
let riwayatList = [];
let tempRiwayatList = [];

// Function to update the main UI and hidden input
function updateRiwayatList() {
    const listContainer = document.getElementById('selectedRiwayatList');
    const hiddenInput = document.getElementById('riwayatKesehatanInput');
    const emptyState = document.getElementById('emptyStateRiwayat');
    
    // Clear the current list
    listContainer.innerHTML = '';
    
    if (riwayatList.length === 0) {
        listContainer.appendChild(emptyState);
    } else {
        // Add each health history to the list
        riwayatList.forEach((riwayat, index) => {
            const item = document.createElement('div');
            item.className = 'p-2 bg-light rounded d-flex justify-content-between align-items-center';
            item.innerHTML = `
                <span>${riwayat}</span>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeRiwayat(${index})">
                    <i class="ti-trash"></i>
                </button>
            `;
            listContainer.appendChild(item);
        });
    }
    
    // Update hidden input with JSON string
    hiddenInput.value = JSON.stringify(riwayatList);
}

// Function to update the modal's temporary list
function updateModalRiwayatList() {
    const modalList = document.getElementById('modalRiwayatList');
    // Buat ulang empty state element
    const modalEmptyState = document.createElement('div');
    modalEmptyState.id = 'modalEmptyStateRiwayat';
    modalEmptyState.className = 'border border-dashed border-secondary rounded p-3 text-center text-muted';
    modalEmptyState.innerHTML = '<p class="mb-0">Belum ada riwayat dalam list sementara</p>';
    
    // Clear the current list
    modalList.innerHTML = '';
    
    if (tempRiwayatList.length === 0) {
        modalList.appendChild(modalEmptyState);
    } else {
        // Add each health history to the temporary list
        tempRiwayatList.forEach((riwayat, index) => {
            const item = document.createElement('div');
            item.className = 'p-2 bg-light rounded d-flex justify-content-between align-items-center';
            item.innerHTML = `
                <span>${riwayat}</span>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeTempRiwayat(${index})">
                    <i class="ti-trash"></i>
                </button>
            `;
            modalList.appendChild(item);
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

// Add event listeners
document.getElementById('tambahKeListRiwayat').addEventListener('click', addToTempRiwayatList);
document.getElementById('simpanRiwayat').addEventListener('click', saveRiwayat);

// Add event listener for enter key in input
document.getElementById('riwayatInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        addToTempRiwayatList();
    }
});

// Reset temporary list when modal is opened
document.getElementById('riwayatKeluargaModal').addEventListener('show.bs.modal', function () {
    tempRiwayatList = [];
    updateModalRiwayatList();
    document.getElementById('riwayatInput').value = '';
});

// Initial update
updateRiwayatList();
updateModalRiwayatList();
</script>