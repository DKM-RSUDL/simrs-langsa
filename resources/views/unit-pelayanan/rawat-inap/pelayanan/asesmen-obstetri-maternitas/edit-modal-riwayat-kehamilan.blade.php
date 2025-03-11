<!-- Modal for Adding Pregnancy History -->
<div class="modal fade" id="modalCreateRiwayatKehamilan" tabindex="-1" aria-labelledby="riwayatKehamilanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="riwayatKehamilanModalLabel">Input Riwayat Kehamilan Sekarang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <strong class="fw-bold">Tambah Riwayat Kehamilan</strong>
                <p>
                    (Isi riwayat kehamilan pada kolom dibawah dan <span class="fw-bold">Tekan Enter</span> untuk
                    menambah ke
                    daftar. Satu baris untuk satu item)
                </p>
                <div class="dropdown">
                    <input type="text" class="form-control" id="searchRiwayatKehamilanInput"
                        placeholder="Riwayat Kehamilan">
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
<div class="modal fade" id="modalEditRiwayatKehamilan" tabindex="-1" aria-labelledby="editRiwayatKehamilanModalLabel"
    aria-hidden="true">
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
        let riwayatKehamilanJson = $('#riwayatKehamilanSekarangInput').val();
        let dataRiwayatKehamilan = [];

        try {
            // Fungsi untuk membersihkan string JSON yang tidak valid
            function cleanJsonString(str) {
                // Hapus escape sequences dan karakter yang tidak perlu
                return str.replace(/\\/g, '')
                          .replace(/\"\[/g, '[')
                          .replace(/\]\"/g, ']')
                          .replace(/\"\"/g, '"')
                          .replace(/\n/g, ',')
                          .trim();
            }

            if (riwayatKehamilanJson && riwayatKehamilanJson !== '[]' && riwayatKehamilanJson !== '') {
                // Bersihkan string JSON terlebih dahulu
                const cleanedJson = cleanJsonString(riwayatKehamilanJson);

                // Coba parse sebagai JSON
                try {
                    dataRiwayatKehamilan = JSON.parse(cleanedJson);
                } catch (err) {
                    // Jika masih gagal, coba cara lain
                    // Bersihkan format khusus untuk kasus "[\"elergi udang\"\n\"gatel\"]"
                    const cleanedData = riwayatKehamilanJson
                        .replace(/\\/g, '')    // Hapus backslash
                        .replace(/^\"/g, '')   // Hapus kutip di awal
                        .replace(/\"$/g, '')   // Hapus kutip di akhir
                        .replace(/\[/g, '')    // Hapus tanda [
                        .replace(/\]/g, '')    // Hapus tanda ]
                        .replace(/\"\n\"/g, ','); // Ganti newline di antara kutip dengan koma

                    // Split berdasarkan koma untuk mendapatkan array
                    dataRiwayatKehamilan = cleanedData.split(',').map(item => item.trim());

                    // Hapus tanda kutip yang tersisa di awal dan akhir setiap item
                    dataRiwayatKehamilan = dataRiwayatKehamilan.map(item =>
                        item.replace(/^\"/, '').replace(/\"$/, '')
                    );
                }
            }

            // Pastikan dataRiwayatKehamilan adalah array
            if (!Array.isArray(dataRiwayatKehamilan)) {
                dataRiwayatKehamilan = [];
            }

            // Filter item kosong
            dataRiwayatKehamilan = dataRiwayatKehamilan.filter(item => item && item.trim() !== '');
        } catch (error) {
            console.error('Error parsing JSON:', error);
            dataRiwayatKehamilan = [];
        }

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
                    // Skip item kosong atau tidak valid
                    if (!history || history === '' || history === '[]') return;

                    let uniqueId = 'riwayat-kehamilan-' + index;

                    // Untuk modal riwayat kehamilan
                    riwayatKehamilanList += `
                    <li class="list-group-item" id="${uniqueId}">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>${history}</span>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-link edit-riwayat-kehamilan" data-id="${uniqueId}">
                                    <i class="bi bi-pencil text-primary"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-link remove-riwayat-kehamilan" data-id="${uniqueId}">
                                    <i class="bi bi-trash text-danger"></i>
                                </button>
                            </div>
                        </div>
                    </li>`;

                    // Untuk tampilan utama - tambahkan data-riwayat-kehamilan untuk sortable
                    riwayatKehamilanDisplay += `
                    <div class="riwayat-kehamilan-item mb-2" id="main-${uniqueId}" data-riwayat-kehamilan="${history}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <span class="drag-handle me-2" style="cursor: move;">
                                    <i class="bi bi-grip-vertical"></i>
                                </span>
                                <span>${history}</span>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-link edit-riwayat-kehamilan" data-id="${uniqueId}">
                                    <i class="bi bi-pencil text-primary"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-link remove-riwayat-kehamilan" data-id="${uniqueId}">
                                    <i class="bi bi-trash text-danger"></i>
                                </button>
                            </div>
                        </div>
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
        $(document).on('click', '.remove-riwayat-kehamilan', function() {
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
