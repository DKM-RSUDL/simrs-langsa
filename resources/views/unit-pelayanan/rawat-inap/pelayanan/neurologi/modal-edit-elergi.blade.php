<!-- Modal Create/Edit Alergi -->
<div class="modal fade" id="modal-create-elergi-neurologi" tabindex="-1" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallModalLabel">Input Alergi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_index" value="-1">
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis Alergi</label>
                    <select class="form-select" id="jenis" name="jenis">
                        <option value="">Pilih Jenis</option>
                        <option value="Obat">Obat</option>
                        <option value="Makanan">Makanan</option>
                        <option value="Udara">Udara</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="alergen" class="form-label">Alergen</label>
                    <input type="text" class="form-control" id="alergen" name="alergen">
                </div>
                <div class="mb-3">
                    <label for="reaksi" class="form-label">Reaksi</label>
                    <input type="text" class="form-control" id="reaksi" name="reaksi">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" id="btn-simpan-alergi">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi array untuk menyimpan data alergi
    let alergiList = [];

    // Cek apakah ada data alergi yang sudah tersimpan sebelumnya
    @if(isset($asesmen->rmeAsesmenNeurologi->riwayat_alergi) && $asesmen->rmeAsesmenNeurologi->riwayat_alergi)
        try {
            alergiList = JSON.parse(`{!! $asesmen->rmeAsesmenNeurologi->riwayat_alergi !!}`);
            // Jika data tidak dalam bentuk array, konversi ke array kosong
            if (!Array.isArray(alergiList)) {
                alergiList = [];
            }
        } catch (e) {
            console.error("Error parsing allergy data:", e);
            alergiList = [];
        }
    @endif

    // Function untuk menampilkan list alergi
    function displayAlergi() {
        const listContainer = document.getElementById('list-alergi');
        let html = '';

        if (alergiList.length === 0) {
            html = `
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada data alergi</td>
                </tr>
            `;
        } else {
            alergiList.forEach((item, index) => {
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.jenis}</td>
                        <td>${item.alergen}</td>
                        <td>${item.reaksi}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning edit-alergi me-1" data-index="${index}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger remove-alergi" data-index="${index}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        }

        listContainer.innerHTML = html;

        // Update hidden input value
        document.getElementById('riwayat_alergi_hidden').value = JSON.stringify(alergiList);

        // Reinitialize delete and edit buttons
        document.querySelectorAll('.remove-alergi').forEach(button => {
            button.addEventListener('click', handleDelete);
        });

        document.querySelectorAll('.edit-alergi').forEach(button => {
            button.addEventListener('click', handleEdit);
        });
    }

    // Handle edit
    function handleEdit(e) {
        const index = e.currentTarget.dataset.index;
        const item = alergiList[index];

        // Set values in form
        document.getElementById('edit_index').value = index;
        document.getElementById('jenis').value = item.jenis;
        document.getElementById('alergen').value = item.alergen;
        document.getElementById('reaksi').value = item.reaksi;

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('modal-create-elergi-neurologi'));
        modal.show();
    }

    // Handle delete
    function handleDelete(e) {
        const index = e.currentTarget.dataset.index;

        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin menghapus data alergi ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                alergiList.splice(index, 1);
                displayAlergi();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data alergi berhasil dihapus',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    }

    // Show modal button for adding new allergy
    const addButton = document.getElementById('btn-add-elergi-neurologi');
    if (addButton) {
        addButton.addEventListener('click', function() {
            // Reset form and set edit index to -1 (indicating new entry)
            document.getElementById('edit_index').value = -1;
            document.getElementById('jenis').value = '';
            document.getElementById('alergen').value = '';
            document.getElementById('reaksi').value = '';

            const modal = new bootstrap.Modal(document.getElementById('modal-create-elergi-neurologi'));
            modal.show();
        });
    }

    // Save button
    const saveButton = document.getElementById('btn-simpan-alergi');
    if (saveButton) {
        saveButton.addEventListener('click', function() {
            const editIndex = parseInt(document.getElementById('edit_index').value);
            const jenis = document.getElementById('jenis').value;
            const alergen = document.getElementById('alergen').value.trim();
            const reaksi = document.getElementById('reaksi').value.trim();

            if (!jenis || !alergen || !reaksi) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Semua field harus diisi!'
                });
                return;
            }

            const newData = {
                jenis: jenis,
                alergen: alergen,
                reaksi: reaksi
            };

            if (editIndex >= 0) {
                // Update existing item
                alergiList[editIndex] = newData;
                successMessage = 'Data alergi berhasil diperbarui';
            } else {
                // Add new item
                alergiList.push(newData);
                successMessage = 'Data alergi berhasil ditambahkan';
            }

            // Update display
            displayAlergi();

            // Reset and close modal
            document.getElementById('edit_index').value = -1;
            document.getElementById('jenis').value = '';
            document.getElementById('alergen').value = '';
            document.getElementById('reaksi').value = '';

            const modal = bootstrap.Modal.getInstance(document.getElementById('modal-create-elergi-neurologi'));
            modal.hide();

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: successMessage,
                timer: 1500,
                showConfirmButton: false
            });
        });
    }

    // Reset form when modal is closed
    const modal = document.getElementById('modal-create-elergi-neurologi');
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            document.getElementById('edit_index').value = -1;
            document.getElementById('jenis').value = '';
            document.getElementById('alergen').value = '';
            document.getElementById('reaksi').value = '';
        });
    }

    // Initial display
    displayAlergi();
});
</script>
@endpush
