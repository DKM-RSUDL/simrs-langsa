<!-- Modal for adding operations -->
<div class="modal fade" id="operasiModal" tabindex="-1" aria-labelledby="operasiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="operasiModalLabel">Tambah Operasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="operasiInput" class="form-label">Nama/Jenis Operasi</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="operasiInput"
                            placeholder="Masukkan nama/jenis operasi">
                        <button class="btn btn-outline-secondary" type="button" id="tambahKeListOperasi">
                            <i class="ti-plus"></i>
                        </button>
                    </div>
                </div>
                <!-- Temporary list in modal -->
                <div id="modalOperasiList" class="d-flex flex-column gap-2">
                    <div id="modalEmptyStateOperasi"
                        class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                        <p class="mb-0">Belum ada operasi dalam list sementara</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanOperasi"
                    data-bs-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Arrays to store the operations
    let operasiList = [];
    let tempOperasiList = [];
    const existingOperasiData = document.getElementById('jenisOperasiInput').value;

    try {
        // Parse data if it's in JSON string format
        if (existingOperasiData) {
            operasiList = typeof existingOperasiData === 'string' ? JSON.parse(existingOperasiData) :
                existingOperasiData;
        }
    } catch (e) {
        console.error('Error parsing operasi data:', e);
        operasiList = [];
    }

    // Function to update the main UI and hidden input
    function updateOperasiList() {
        const listContainer = document.getElementById('selectedOperasiList');
        const hiddenInput = document.getElementById('jenisOperasiInput');
        const emptyState = document.getElementById('emptyStateOperasi');

        // Clear the current list
        listContainer.innerHTML = '';

        if (operasiList.length === 0) {
            listContainer.appendChild(emptyState);
        } else {
            // Add each operation to the list
            operasiList.forEach((operasi, index) => {
                const item = document.createElement('div');
                item.className = 'p-2 bg-light rounded d-flex justify-content-between align-items-center';
                item.innerHTML = `
                <span>${operasi}</span>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeOperasi(${index})">
                    <i class="ti-trash"></i>
                </button>
            `;
                listContainer.appendChild(item);
            });
        }

        // Update hidden input with JSON string
        hiddenInput.value = JSON.stringify(operasiList);
    }

    // Function to update the modal's temporary list
    function updateModalOperasiList() {
        const modalList = document.getElementById('modalOperasiList');
        // Create empty state element
        const modalEmptyState = document.createElement('div');
        modalEmptyState.id = 'modalEmptyStateOperasi';
        modalEmptyState.className = 'border border-dashed border-secondary rounded p-3 text-center text-muted';
        modalEmptyState.innerHTML = '<p class="mb-0">Belum ada operasi dalam list sementara</p>';

        // Clear the current list
        modalList.innerHTML = '';

        if (tempOperasiList.length === 0) {
            modalList.appendChild(modalEmptyState);
        } else {
            // Add each operation to the temporary list
            tempOperasiList.forEach((operasi, index) => {
                const item = document.createElement('div');
                item.className = 'p-2 bg-light rounded d-flex justify-content-between align-items-center';
                item.innerHTML = `
                <span>${operasi}</span>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeTempOperasi(${index})">
                    <i class="ti-trash"></i>
                </button>
            `;
                modalList.appendChild(item);
            });
        }
    }

    // Function to add a new operation to temporary list
    function addToTempOperasiList() {
        const input = document.getElementById('operasiInput');
        const operasi = input.value.trim();

        if (operasi) {
            tempOperasiList.push(operasi);
            updateModalOperasiList();
            input.value = '';
            input.focus();
        }
    }

    // Function to save temporary list to main list
    function saveOperasi() {
        if (tempOperasiList.length > 0) {
            operasiList = [...operasiList, ...tempOperasiList];
            tempOperasiList = []; // Clear temporary list
            updateOperasiList();

            // Close modal automatically handled by data-bs-dismiss attribute
        }
    }

    // Function to remove an operation from main list
    function removeOperasi(index) {
        operasiList.splice(index, 1);
        updateOperasiList();
    }

    // Function to remove an operation from temporary list
    function removeTempOperasi(index) {
        tempOperasiList.splice(index, 1);
        updateModalOperasiList();
    }

    // Add event listeners
    document.getElementById('tambahKeListOperasi').addEventListener('click', addToTempOperasiList);
    document.getElementById('simpanOperasi').addEventListener('click', saveOperasi);

    // Add event listener for enter key in input
    document.getElementById('operasiInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addToTempOperasiList();
        }
    });

    // Reset temporary list when modal is opened
    document.getElementById('operasiModal').addEventListener('show.bs.modal', function() {
        tempOperasiList = [];
        updateModalOperasiList();
        document.getElementById('operasiInput').value = '';
    });

    // Initial update
    updateOperasiList();
    updateModalOperasiList();
</script>
