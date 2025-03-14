<!-- Modal for Adding Pregnancy History -->
<div class="modal fade" id="modalCreateRiwayatKehamilan" tabindex="-1" aria-labelledby="riwayatKehamilanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="riwayatKehamilanModalLabel">Input Riwayat Kehamilan Sekarang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <strong class="fw-bold">Tambah Riwayat Kehamilan</strong>
                <p>
                    (Isi riwayat kehamilan pada kolom dibawah dan <span class="fw-bold">Tekan Enter</span> untuk menambah ke
                    daftar. Satu baris untuk satu item)
                </p>
                <div class="dropdown">
                    <input type="text" class="form-control" id="searchRiwayatKehamilanInput" placeholder="Riwayat Kehamilan">
                </div>
                <div class="mt-2 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary mt-2" id="btnAddRiwayatKehamilan">Tambah</button>
                </div>

                <div class="mt-3">
                    <strong class="fw-bold">Daftar Riwayat Kehamilan</strong>
                    <div class="bg-light p-3 border rounded">
                        <ol type="1" id="riwayatKehamilanList">
                            <!-- List of Pregnancy History Items -->
                        </ol>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnSaveRiwayatKehamilan" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Pregnancy History -->
<div class="modal fade" id="modalEditRiwayatKehamilan" tabindex="-1" aria-labelledby="editRiwayatKehamilanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editRiwayatKehamilanModalLabel">Edit Riwayat Kehamilan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="editRiwayatKehamilanTextarea" class="form-label">Riwayat Kehamilan</label>
                    <textarea class="form-control" id="editRiwayatKehamilanTextarea" rows="3"></textarea>
                    <input type="hidden" id="editRiwayatKehamilanId">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnUpdateRiwayatKehamilan" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inisialisasi data dari database jika ada
        let dataRiwayatKehamilan = @json($dataResume->riwayat_kehamilan_sekarang ?? []);
    
        // Fungsi untuk menghapus duplikat dari array
        function removeDuplicates(arr) {
            return [...new Set(arr)];
        }
    
        // Fungsi untuk memperbarui hidden input dan tampilan
        function displayRiwayatKehamilan() {
            // Bersihkan duplikat sebelum menampilkan
            dataRiwayatKehamilan = removeDuplicates(dataRiwayatKehamilan);
    
            let riwayatKehamilanList = '';
            let riwayatKehamilanDisplay = '';
    
            if (dataRiwayatKehamilan && Array.isArray(dataRiwayatKehamilan)) {
                dataRiwayatKehamilan.forEach((history, index) => {
                    let uniqueId = 'riwayat-kehamilan-' + index;
    
                    // Untuk modal riwayat kehamilan
                    riwayatKehamilanList += `
                    <li class="list-group-item d-flex justify-content-between align-items-center" id="${uniqueId}">
                        <span class="fw-bold">${history}</span>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-link edit-riwayat-kehamilan" data-id="${uniqueId}">
                                <i class="bi bi-pencil text-primary"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-link remove-riwayat-kehamilan" data-id="${uniqueId}">
                                <i class="bi bi-trash text-danger"></i>
                            </button>
                        </div>
                    </li>`;
    
                    // Untuk tampilan utama
                    riwayatKehamilanDisplay += `
                    <div class="riwayat-kehamilan-item d-flex justify-content-between align-items-center mb-2"
                        id="main-${uniqueId}" data-riwayat-kehamilan="${history}">
                        <div class="d-flex align-items-center gap-2">
                            <span class="drag-handle" style="cursor: move;">
                                <i class="bi bi-grip-vertical"></i>
                            </span>
                            <span class="fw-bold">${history}</span>
                        </div>
                        <button type="button" class="btn btn-sm btn-link remove-main-riwayat-kehamilan" data-id="${uniqueId}">
                            <i class="bi bi-x-circle text-danger"></i>
                        </button>
                    </div>`;
                });
            }
    
            // Update tampilan
            $('#riwayatKehamilanList').html(riwayatKehamilanList);
            $('.riwayat-kehamilan-list').html(riwayatKehamilanDisplay);
    
            // Update hidden input dengan JSON string
            $('#riwayatKehamilanSekarangInput').val(JSON.stringify(dataRiwayatKehamilan));
    
            // Initialize Sortable
            initializeSortable();
        }
    
        // Inisialisasi Sortable
        function initializeSortable() {
            let riwayatKehamilanList = document.querySelector('.riwayat-kehamilan-list');
            if (riwayatKehamilanList) {
                new Sortable(riwayatKehamilanList, {
                    animation: 150,
                    handle: '.drag-handle',
                    onEnd: function(evt) {
                        // Buat array baru dari urutan setelah drag
                        let newOrder = [];
                        $('.riwayat-kehamilan-item').each(function() {
                            let history = $(this).data('riwayat-kehamilan');
                            if (history && !newOrder.includes(history)) {
                                newOrder.push(history);
                            }
                        });
    
                        // Update dataRiwayatKehamilan dengan array baru tanpa duplikat
                        dataRiwayatKehamilan = newOrder;
    
                        // Update hidden input
                        $('#riwayatKehamilanSekarangInput').val(JSON.stringify(dataRiwayatKehamilan));
                    }
                });
            }
        }
    
        // Tampilkan data awal
        displayRiwayatKehamilan();
    
        // Buka modal
        $('#btnRiwayatKehamilan').on('click', function() {
            displayRiwayatKehamilan();
            $('#modalCreateRiwayatKehamilan').modal('show');
        });
    
        // Tambah riwayat kehamilan
        $('#btnAddRiwayatKehamilan').click(function() {
            var history = $('#searchRiwayatKehamilanInput').val().trim();
            if (history !== '') {
                // Cek apakah riwayat sudah ada
                if (!dataRiwayatKehamilan.includes(history)) {
                    dataRiwayatKehamilan.push(history);
                    displayRiwayatKehamilan();
                }
                $('#searchRiwayatKehamilanInput').val('');
            }
        });
    
        // Handle enter key
        $('#searchRiwayatKehamilanInput').keypress(function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#btnAddRiwayatKehamilan').click();
            }
        });
    
        // Open edit modal
        $(document).on('click', '.edit-riwayat-kehamilan', function() {
            var historyId = $(this).data('id');
            var index = historyId.split('-')[2];
            var historyText = dataRiwayatKehamilan[index];
    
            $('#editRiwayatKehamilanTextarea').val(historyText);
            $('#editRiwayatKehamilanId').val(index);
    
            $('#modalEditRiwayatKehamilan').modal('show');
        });
    
        // Save edit pregnancy history
        $('#btnUpdateRiwayatKehamilan').click(function() {
            var updatedHistory = $('#editRiwayatKehamilanTextarea').val().trim();
            var index = $('#editRiwayatKehamilanId').val();
    
            if (updatedHistory !== '') {
                dataRiwayatKehamilan[index] = updatedHistory;
                displayRiwayatKehamilan();
            }
    
            $('#modalEditRiwayatKehamilan').modal('hide');
        });
    
        // Hapus riwayat kehamilan
        $(document).on('click', '.remove-riwayat-kehamilan, .remove-main-riwayat-kehamilan', function() {
            var historyId = $(this).data('id');
            var index = historyId.split('-')[2];
            if (index >= 0 && index < dataRiwayatKehamilan.length) {
                dataRiwayatKehamilan.splice(index, 1);
                displayRiwayatKehamilan();
            }
        });
    
        // Simpan riwayat kehamilan
        $('#btnSaveRiwayatKehamilan').click(function() {
            // Pastikan tidak ada duplikat sebelum menyimpan
            dataRiwayatKehamilan = removeDuplicates(dataRiwayatKehamilan);
            displayRiwayatKehamilan();
            $('#modalCreateRiwayatKehamilan').modal('hide');
        });
    });
    </script>