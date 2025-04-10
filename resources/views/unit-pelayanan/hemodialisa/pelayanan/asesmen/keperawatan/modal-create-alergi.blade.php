<!-- Modal Alergi -->
<div class="modal fade" id="alergiModal" tabindex="-1" aria-labelledby="alergiModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="alergiModalLabel">Input Alergi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form Section -->
                <div class="form-section mb-4">
                    <h6 class="fw-bold">Tambah Alergi</h6>
                    <p class="text-muted small">Isi informasi alergi pada kolom di bawah dan tekan tambah untuk menambah ke daftar alergi</p>

                    <form id="formAlergi">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="alergenInput" placeholder="Alergen" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="reaksiInput" placeholder="Reaksi" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <select class="form-select" id="severeInput">
                                <option value="">Pilih Tingkat Keparahan</option>
                                <option value="Ringan">Ringan</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Berat">Berat</option>
                            </select>
                        </div>
                        <div class="text-end">
                            <button type="button" id="btnAddAlergi" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>

                <!-- List Section -->
                <div class="list-section">
                    <h6 class="fw-bold">Daftar Alergi</h6>
                    <div class="list-group" id="listAlergi">
                        <!-- Daftar alergi akan ditampilkan di sini -->
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="btnSaveAlergi" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
$(document).ready(function() {
    // ===== VARIABEL & INISIALISASI =====
    // Inisialisasi data dari database jika ada
    let dataAlergi = @json($dataResume->alergi ?? []);
    let editMode = false;
    let editIndex = null;

    // ===== FUNGSI HELPER =====
    // Memperbarui tampilan tabel utama
    function updateMainTable() {
        let tableBody = '';

        if (dataAlergi.length === 0) {
            tableBody = '<tr><td colspan="4" class="text-center">Belum ada data alergi</td></tr>';
        } else {
            dataAlergi.forEach((alergi, index) => {
                tableBody += `
                    <tr>
                        <td>${alergi.alergen}</td>
                        <td>${alergi.reaksi}</td>
                        <td>${alergi.severe}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-link edit-alergi" data-index="${index}">
                                    <i class="bi bi-pencil text-primary"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-link delete-alergi" data-index="${index}">
                                    <i class="bi bi-trash text-danger"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        }

        $('#createAlergiTable tbody').html(tableBody);
        updateHiddenInput();
    }

    // Memperbarui daftar di modal
    function updateModalList() {
        let listItems = '';

        if (dataAlergi.length === 0) {
            listItems = '<div class="list-group-item text-center text-muted">Belum ada data alergi</div>';
        } else {
            dataAlergi.forEach((alergi, index) => {
                listItems += `
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${alergi.alergen}</strong> - ${alergi.reaksi}
                            <span class="badge bg-secondary ms-2">${alergi.severe}</span>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-link edit-modal-alergi" data-index="${index}">
                                <i class="bi bi-pencil text-primary"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-link remove-alergi" data-index="${index}">
                                <i class="bi bi-trash text-danger"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
        }

        $('#listAlergi').html(listItems);
    }

    // Memperbarui hidden input
    function updateHiddenInput() {
        $('input[name="alergi"]').val(JSON.stringify(dataAlergi));
    }

    // Reset form
    function resetForm() {
        $('#formAlergi')[0].reset();
        editMode = false;
        editIndex = null;
        $('#btnAddAlergi').text('Tambah');
    }

    // ===== EVENT HANDLERS =====
    // Tambah/update alergi
    $('#btnAddAlergi').click(function() {
        const alergi = {
            alergen: $('#alergenInput').val().trim(),
            reaksi: $('#reaksiInput').val().trim(),
            severe: $('#severeInput').val()
        };

        // Validasi form
        if (!alergi.alergen || !alergi.reaksi || !alergi.severe) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Semua field harus diisi!'
            });
            return;
        }

        if (editMode) {
            // Update data yang sudah ada
            dataAlergi[editIndex] = alergi;
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data alergi berhasil diperbarui',
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            // Cek data duplikat saat menambah data baru
            const isDuplicate = dataAlergi.some(item =>
                item.alergen.toLowerCase() === alergi.alergen.toLowerCase()
            );

            if (isDuplicate) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Alergi ini sudah ada dalam daftar!'
                });
                return;
            }

            // Tambah data baru
            dataAlergi.push(alergi);
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data alergi berhasil ditambahkan',
                timer: 1500,
                showConfirmButton: false
            });
        }

        updateModalList();
        resetForm();
    });

    // Edit alergi dari modal dan tabel
    $(document).on('click', '.edit-alergi, .edit-modal-alergi', function() {
        const index = $(this).data('index');
        const alergi = dataAlergi[index];

        editMode = true;
        editIndex = index;

        $('#alergenInput').val(alergi.alergen);
        $('#reaksiInput').val(alergi.reaksi);
        $('#severeInput').val(alergi.severe);
        $('#btnAddAlergi').text('Update');

        // Jika tombol edit dari tabel, buka modal
        if ($(this).hasClass('edit-alergi')) {
            $('#alergiModal').modal('show');
        }

        // Scroll ke form jika di dalam modal
        $('.modal-body').scrollTop(0);
    });

    // Hapus alergi dari modal dan tabel
    $(document).on('click', '.delete-alergi, .remove-alergi', function() {
        const index = $(this).data('index');
        const alergi = dataAlergi[index];

        Swal.fire({
            title: 'Hapus Alergi',
            text: `Apakah Anda yakin ingin menghapus alergi "${alergi.alergen}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                dataAlergi.splice(index, 1);
                updateMainTable();
                updateModalList();

                Swal.fire({
                    icon: 'success',
                    title: 'Terhapus!',
                    text: 'Data alergi berhasil dihapus',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });

    // Simpan dan tutup modal
    $('#btnSaveAlergi').click(function() {
        updateMainTable();
        $('#alergiModal').modal('hide');

        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data alergi berhasil disimpan',
            timer: 1500,
            showConfirmButton: false
        });
    });

    // Buka modal
    $('#openAlergiModal').click(function() {
        resetForm();
        updateModalList();
        $('#alergiModal').modal('show');
    });

    // Reset form saat modal ditutup
    $('#alergiModal').on('hidden.bs.modal', function() {
        resetForm();
    });

    // Inisialisasi tampilan awal
    updateMainTable();
});
</script>
@endpush
