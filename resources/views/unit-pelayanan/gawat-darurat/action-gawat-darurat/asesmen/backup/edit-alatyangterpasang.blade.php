<button type="button" class="btn btn-sm" id="openEditAlatModal">
    <i class="bi bi-plus-square"></i> Tambah
</button>

<div class="modal fade" id="editAlatModal" tabindex="-1" aria-labelledby="editAlatModalLabel" aria-hidden="true"
    style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAlatModalLabel">Edit Alat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAlatForm">
                    <h6 class="fw-bold">Tambah Alat</h6>
                    <p class="text-muted">(Isi informasi alat pada kolom di bawah dan tekan tambah untuk menambah ke
                        daftar alat)</p>
                    <div class="mb-3">
                        <select class="form-select" id="editNamaAlatInput">
                            <option value="">Pilih Alat</option>
                            <option value="IV Line">IV Line</option>
                            <option value="Kateter">Kateter</option>
                            <option value="CVC">CVC</option>
                            <option value="NGT">NGT</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="editLokasiAlatInput" placeholder="Lokasi"
                            autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="editKeteranganAlatInput" placeholder="Keterangan"
                            autocomplete="off">
                    </div>
                    <button type="button" id="btnEditListAlat" class="btn btn-sm btn-primary mt-2">Tambah</button>
                </form>

                <h6 class="fw-bold mt-5">Daftar Alat</h6>
                <ul id="editListAlat" class="list-unstyled"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnSaveEditAlat" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Event handler untuk modal edit alat
    let editAlats = [];

    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk mengupdate tampilan list di modal
        function updateEditModalAlatView() {
            const editListAlat = document.getElementById('editListAlat');
            if (!editListAlat) return;

            if (editAlats.length === 0) {
                editListAlat.innerHTML = '<li class="text-muted">Tidak ada alat yang terpasang</li>';
                return;
            }

            editListAlat.innerHTML = editAlats.map((a, index) => `
            <li class="d-flex justify-content-between align-items-center mb-2">
                <span>${a.nama} - ${a.lokasi} - ${a.keterangan}</span>
                <button class="btn btn-sm btn-link delete-modal-alat p-0" data-index="${index}">
                    <i class="bi bi-trash-fill text-danger"></i>
                </button>
            </li>
        `).join('');
        }

        // Event handler untuk membuka modal
        $(document).on('click', '#openEditAlatModal', function(event) {
            event.preventDefault();
            event.stopPropagation();
            console.log('Opening alat modal with data:', originalAlatData);

            // Reset form dan copy data
            resetEditAlatForm();
            editAlats = Array.isArray(originalAlatData) ? [...originalAlatData] : [];

            updateEditModalAlatView();
            $('#editAlatModal').modal('show');
        });

        // Event handler untuk menambah alat di modal
        $(document).on('click', '#btnEditListAlat', function(e) {
            e.preventDefault();
            console.log('Add button clicked');

            const namaAlat = $('#editNamaAlatInput').val();
            const lokasi = $('#editLokasiAlatInput').val();
            const keterangan = $('#editKeteranganAlatInput').val();

            if (!namaAlat || !lokasi || !keterangan) {
                Swal.fire({
                    title: 'Peringatan',
                    text: 'Harap isi semua field alat',
                    icon: 'warning'
                });
                return;
            }

            editAlats.push({
                nama: namaAlat,
                lokasi: lokasi,
                keterangan: keterangan
            });

            console.log('Updated editAlats:', editAlats);
            resetEditAlatForm();
            updateEditModalAlatView();
        });

        // Event handler untuk simpan perubahan dari modal
        $(document).on('click', '#btnSaveEditAlat', function(e) {
            e.preventDefault();
            console.log('Saving alat data:', editAlats);

            originalAlatData = [...editAlats];
            fillEditAlatTable(originalAlatData);
            $('#editAlatModal').modal('hide');
        });

        // Event handler untuk delete dari modal
        $(document).on('click', '.delete-modal-alat', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const index = $(this).data('index');
            editAlats.splice(index, 1);
            updateEditModalAlatView();
        });

        // Event handler untuk delete dari tabel utama
        $(document).on('click', '.delete-edit-alat', function(e) {
            e.preventDefault();
            const index = $(this).data('index');
            originalAlatData.splice(index, 1);
            fillEditAlatTable(originalAlatData);
        });

        // Prevent modal from closing parent dan reset form
        $('#editAlatModal').on('hidden.bs.modal', function(event) {
            event.stopPropagation();
            resetEditAlatForm();
        });
    });

    // Fungsi mengisi tabel alat di form utama
    function fillEditAlatTable(alatData) {
        const tbody = $('#editalatTable tbody');
        tbody.empty();

        if (!alatData || !Array.isArray(alatData) || alatData.length === 0) {
            tbody.html(`
            <tr>
                <td colspan="4" class="text-center">
                    <em>Tidak ada alat yang terpasang</em>
                </td>
            </tr>
        `);
            return;
        }

        alatData.forEach((alat, index) => {
            const row = `
            <tr>
                <td>${alat.nama || '-'}</td>
                <td>${alat.lokasi || '-'}</td>
                <td>${alat.keterangan || '-'}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger delete-edit-alat" data-index="${index}">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;
            tbody.append(row);
        });
    }

    // Fungsi reset form
    function resetEditAlatForm() {
        $('#editNamaAlatInput').val('');
        $('#editLokasiAlatInput').val('');
        $('#editKeteranganAlatInput').val('');
    }

    // Fungsi untuk collect data alat
    function collectEditAlat() {
        console.log('Collecting alat data:', originalAlatData);
        return originalAlatData;
    }
</script>
