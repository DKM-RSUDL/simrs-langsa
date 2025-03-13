<!-- Modal for Adding Family Medical History -->
<div class="modal fade" id="modalCreateRiwayatPenyakitKeluarga" tabindex="-1" aria-labelledby="riwayatPenyakitKeluargaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="riwayatPenyakitKeluargaModalLabel">Input Riwayat Penyakit Keluarga</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <strong class="fw-bold">Tambah Riwayat Penyakit Keluarga</strong>
                <p>
                    (Isi riwayat penyakit keluarga pada kolom dibawah dan <span class="fw-bold">Tekan Enter</span> untuk menambah ke
                    daftar. Satu baris untuk satu item)
                </p>
                <div class="dropdown">
                    <input type="text" class="form-control" id="searchRiwayatPenyakitKeluargaInput" placeholder="Riwayat Penyakit Keluarga">
                </div>
                <div class="mt-2 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary mt-2" id="btnAddRiwayatPenyakitKeluarga">Tambah</button>
                </div>

                <div class="mt-3">
                    <strong class="fw-bold">Daftar Riwayat Penyakit Keluarga</strong>
                    <div class="bg-light p-3 border rounded">
                        <ol type="1" id="riwayatPenyakitKeluargaList">
                            <!-- List of Family Medical History Items -->
                        </ol>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnSaveRiwayatPenyakitKeluarga" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Family Medical History -->
<div class="modal fade" id="modalEditRiwayatPenyakitKeluarga" tabindex="-1" aria-labelledby="editRiwayatPenyakitKeluargaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editRiwayatPenyakitKeluargaModalLabel">Edit Riwayat Penyakit Keluarga</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="editRiwayatPenyakitKeluargaTextarea" class="form-label">Riwayat Penyakit Keluarga</label>
                    <textarea class="form-control" id="editRiwayatPenyakitKeluargaTextarea" rows="3"></textarea>
                    <input type="hidden" id="editRiwayatPenyakitKeluargaId">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnUpdateRiwayatPenyakitKeluarga" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Fungsi untuk parse data dari input yang mungkin dalam berbagai format
        function parseRiwayatPenyakitKeluarga(inputData) {
            let result = [];

            try {
                // Coba parse sebagai JSON
                if (inputData && typeof inputData === 'string') {
                    // Bersihkan string dari karakter yang tidak diinginkan
                    const cleanedInput = inputData
                        .replace(/\\/g, '')    // Hapus backslash
                        .replace(/^\"/g, '')   // Hapus kutip pembuka
                        .replace(/\"$/g, '')   // Hapus kutip penutup
                        .trim();

                    // Periksa jika seperti JSON array
                    if (cleanedInput.startsWith('[') && cleanedInput.endsWith(']')) {
                        // Parse sebagai JSON
                        result = JSON.parse(cleanedInput);
                    } else {
                        // Split berdasarkan koma jika string dengan pemisah koma
                        result = cleanedInput.split(',').map(item => item.trim());
                    }
                } else if (Array.isArray(inputData)) {
                    // Sudah dalam bentuk array
                    result = inputData;
                }
            } catch (error) {
                console.error('Error parsing riwayat penyakit keluarga:', error);

                // Fallback: perlakukan sebagai string dengan pemisah koma
                if (typeof inputData === 'string') {
                    result = inputData.split(',').map(item => item.trim());
                }
            }

            // Filter nilai kosong dan pastikan hasilnya array
            return Array.isArray(result) ? result.filter(item => item && item.trim() !== '') : [];
        }

        // Inisialisasi data dari database jika ada
        let inputValue = $('#riwayatPenyakinKeluarwaInput').val();
        let dataRiwayatPenyakitKeluarga = parseRiwayatPenyakitKeluarga(inputValue);

        // Fungsi untuk menghapus duplikat dari array
        function removeDuplicates(arr) {
            return [...new Set(arr)];
        }

        // Fungsi untuk memperbarui hidden input dan tampilan
        function displayRiwayatPenyakitKeluarga() {
            // Bersihkan duplikat sebelum menampilkan
            dataRiwayatPenyakitKeluarga = removeDuplicates(dataRiwayatPenyakitKeluarga);

            let riwayatPenyakitKeluargaList = '';
            let riwayatPenyakitKeluargaDisplay = '';

            if (dataRiwayatPenyakitKeluarga && Array.isArray(dataRiwayatPenyakitKeluarga)) {
                dataRiwayatPenyakitKeluarga.forEach((history, index) => {
                    let uniqueId = 'riwayat-penyakit-keluarga-' + index;

                    // Untuk modal riwayat penyakit keluarga
                    riwayatPenyakitKeluargaList += `
                    <li class="list-group-item d-flex justify-content-between align-items-center" id="${uniqueId}">
                        <span class="fw-bold">${history}</span>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-link edit-riwayat-penyakit-keluarga" data-id="${uniqueId}">
                                <i class="bi bi-pencil text-primary"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-link remove-riwayat-penyakit-keluarga" data-id="${uniqueId}">
                                <i class="bi bi-trash text-danger"></i>
                            </button>
                        </div>
                    </li>`;

                    // Untuk tampilan utama
                    riwayatPenyakitKeluargaDisplay += `
                    <div class="riwayat-penyakit-keluarga-item d-flex justify-content-between align-items-center mb-2"
                        id="main-${uniqueId}" data-riwayat-penyakit-keluarga="${history}">
                        <div class="d-flex align-items-center gap-2">
                            <span class="drag-handle" style="cursor: move;">
                                <i class="bi bi-grip-vertical"></i>
                            </span>
                            <span class="fw-bold">${history}</span>
                        </div>
                        <button type="button" class="btn btn-sm btn-link remove-main-riwayat-penyakit-keluarga" data-id="${uniqueId}">
                            <i class="bi bi-x-circle text-danger"></i>
                        </button>
                    </div>`;
                });
            }

            // Update tampilan
            $('#riwayatPenyakitKeluargaList').html(riwayatPenyakitKeluargaList);
            $('.riwayat-penyakin-keluarwa-list').html(riwayatPenyakitKeluargaDisplay);

            // Update hidden input dengan JSON string
            $('#riwayatPenyakinKeluarwaInput').val(JSON.stringify(dataRiwayatPenyakitKeluarga));

            // Initialize Sortable
            initializeSortable();
        }

        // Inisialisasi Sortable
        function initializeSortable() {
            let riwayatPenyakitKeluargaList = document.querySelector('.riwayat-penyakin-keluarwa-list');
            if (riwayatPenyakitKeluargaList) {
                new Sortable(riwayatPenyakitKeluargaList, {
                    animation: 150,
                    handle: '.drag-handle',
                    onEnd: function(evt) {
                        // Buat array baru dari urutan setelah drag
                        let newOrder = [];
                        $('.riwayat-penyakit-keluarga-item').each(function() {
                            let history = $(this).data('riwayat-penyakit-keluarga');
                            if (history && !newOrder.includes(history)) {
                                newOrder.push(history);
                            }
                        });

                        // Update dataRiwayatPenyakitKeluarga dengan array baru tanpa duplikat
                        dataRiwayatPenyakitKeluarga = newOrder;

                        // Update hidden input
                        $('#riwayatPenyakinKeluarwaInput').val(JSON.stringify(dataRiwayatPenyakitKeluarga));
                    }
                });
            }
        }

        // Tampilkan data awal
        displayRiwayatPenyakitKeluarga();

        // Buka modal
        $('#btnRiwayatPenyakinKeluarwa').on('click', function() {
            displayRiwayatPenyakitKeluarga();
            $('#modalCreateRiwayatPenyakitKeluarga').modal('show');
        });

        // Tambah riwayat penyakit keluarga
        $('#btnAddRiwayatPenyakitKeluarga').click(function() {
            var history = $('#searchRiwayatPenyakitKeluargaInput').val().trim();
            if (history !== '') {
                // Cek apakah riwayat sudah ada
                if (!dataRiwayatPenyakitKeluarga.includes(history)) {
                    dataRiwayatPenyakitKeluarga.push(history);
                    displayRiwayatPenyakitKeluarga();
                }
                $('#searchRiwayatPenyakitKeluargaInput').val('');
            }
        });

        // Handle enter key
        $('#searchRiwayatPenyakitKeluargaInput').keypress(function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#btnAddRiwayatPenyakitKeluarga').click();
            }
        });

        // Open edit modal
        $(document).on('click', '.edit-riwayat-penyakit-keluarga', function() {
            var historyId = $(this).data('id');
            var index = historyId.split('-')[3];
            var historyText = dataRiwayatPenyakitKeluarga[index];

            $('#editRiwayatPenyakitKeluargaTextarea').val(historyText);
            $('#editRiwayatPenyakitKeluargaId').val(index);

            $('#modalEditRiwayatPenyakitKeluarga').modal('show');
        });

        // Save edit family medical history
        $('#btnUpdateRiwayatPenyakitKeluarga').click(function() {
            var updatedHistory = $('#editRiwayatPenyakitKeluargaTextarea').val().trim();
            var index = $('#editRiwayatPenyakitKeluargaId').val();

            if (updatedHistory !== '') {
                dataRiwayatPenyakitKeluarga[index] = updatedHistory;
                displayRiwayatPenyakitKeluarga();
            }

            $('#modalEditRiwayatPenyakitKeluarga').modal('hide');
        });

        // Hapus riwayat penyakit keluarga
        $(document).on('click', '.remove-riwayat-penyakit-keluarga, .remove-main-riwayat-penyakit-keluarga', function() {
            var historyId = $(this).data('id');
            var index = historyId.split('-')[3];
            if (index >= 0 && index < dataRiwayatPenyakitKeluarga.length) {
                dataRiwayatPenyakitKeluarga.splice(index, 1);
                displayRiwayatPenyakitKeluarga();
            }
        });

        // Simpan riwayat penyakit keluarga
        $('#btnSaveRiwayatPenyakitKeluarga').click(function() {
            // Pastikan tidak ada duplikat sebelum menyimpan
            dataRiwayatPenyakitKeluarga = removeDuplicates(dataRiwayatPenyakitKeluarga);
            displayRiwayatPenyakitKeluarga();
            $('#modalCreateRiwayatPenyakitKeluarga').modal('hide');
        });
    });
</script>
