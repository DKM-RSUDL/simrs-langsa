<!-- Modal Tambah/Edit Mitra -->
<div class="modal fade" id="tambahMitraModal" tabindex="-1" aria-labelledby="tambahMitraModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahMitraModalLabel">Tambah Data Keluarga / Mitra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="mitraForm">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>

                    <div class="mb-3">
                        <label for="hubungan" class="form-label">Hubungan</label>
                        <select class="form-select" id="hubungan" name="hubungan" required>
                            <option value="">Pilih Hubungan</option>
                            <option value="Suami">Suami</option>
                            <option value="Istri">Istri</option>
                            <option value="Anak">Anak</option>
                            <option value="Orangtua">Orangtua</option>
                            <option value="Saudara">Saudara</option>
                            <option value="Mitra Seksual">Mitra Seksual</option>
                            <option value="Mitra Penasun">Mitra Penasun</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="umur" class="form-label">Umur</label>
                        <input type="number" class="form-control" id="umur" name="umur" min="0" max="120" required>
                    </div>

                    <div class="mb-3">
                        <label for="status_hiv" class="form-label">Status HIV +/-</label>
                        <select class="form-select" id="status_hiv" name="status_hiv">
                            <option value="">Pilih Status</option>
                            <option value="Positif">Positif</option>
                            <option value="Negatif">Negatif</option>
                            <option value="Tidak Diketahui">Tidak Diketahui</option>
                            <option value="Belum Tes">Belum Tes</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status_art" class="form-label">Status ART Y/T</label>
                        <select class="form-select" id="status_art" name="status_art">
                            <option value="">Pilih Status</option>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                            <option value="Tidak Berlaku">Tidak Berlaku</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="no_reg_nas" class="form-label">NoRegNas</label>
                        <input type="text" class="form-control" id="no_reg_nas" name="no_reg_nas">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="simpanMitra">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    console.log('Mitra management script loaded...');

    // ===== INISIALISASI DATA MITRA =====
    let mitraData = [];
    let editIndex = -1;

    // Load existing data jika ada (untuk edit form)
    function initializeMitraData() {
        // Ambil data dari server jika edit mode
        const existingDataElement = document.getElementById('existing-mitra-data');
        if (existingDataElement && existingDataElement.value) {
            try {
                mitraData = JSON.parse(existingDataElement.value);
                console.log('Loaded existing mitra data:', mitraData);
                // Tidak perlu render table karena sudah di-render di server side
            } catch (e) {
                console.error('Error parsing existing mitra data:', e);
                mitraData = [];
            }
        }
        
        // Update hidden input dengan data existing
        saveToJSON();
        
        // Setup event listeners untuk existing buttons
        setupTableEventListeners();
    }

    // Setup event listeners untuk buttons yang sudah ada di table
    function setupTableEventListeners() {
        // Edit buttons
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const index = parseInt(this.getAttribute('data-index'));
                editMitra(index);
            });
        });

        // Delete buttons
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const index = parseInt(this.getAttribute('data-index'));
                deleteMitra(index);
            });
        });
    }

    // ===== UPDATE HIDDEN INPUT =====
    function saveToJSON() {
        const jsonData = JSON.stringify(mitraData);
        console.log('Data tersimpan ke JSON:', jsonData);

        // Update hidden input untuk dikirim ke server
        const hiddenInput = document.getElementById('dataKeluargaInput');
        if (hiddenInput) {
            hiddenInput.value = jsonData;
            console.log('Hidden input updated with JSON data');
        } else {
            console.warn('Hidden input for data_keluarga not found!');
        }

        // Global variables untuk debugging
        window.mitraDataJSON = jsonData;
        window.mitraDataArray = mitraData;
    }

    // Function to show toast notification
    function showToast(message, type = 'success') {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: type,
                title: message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        } else {
            alert(message);
        }
    }

    // Function to escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Badge class functions
    function getHivBadgeClass(status) {
        switch (status) {
            case 'Positif': return 'bg-danger';
            case 'Negatif': return 'bg-success';
            case 'Tidak Diketahui': return 'bg-warning text-dark';
            case 'Belum Tes': return 'bg-secondary';
            default: return 'bg-light text-dark';
        }
    }

    function getArtBadgeClass(status) {
        switch (status) {
            case 'Ya': return 'bg-success';
            case 'Tidak': return 'bg-danger';
            case 'Tidak Berlaku': return 'bg-secondary';
            default: return 'bg-light text-dark';
        }
    }

    // ===== RENDER TABLE =====
    function renderTable() {
        console.log('Rendering table with data:', mitraData);
        const tbody = document.querySelector('#mitraTable tbody');
        const noDataRow = document.getElementById('no-data-row');

        if (!tbody) {
            console.error('Table tbody not found');
            return;
        }

        // Clear existing rows
        tbody.innerHTML = '';

        if (mitraData.length === 0) {
            tbody.innerHTML = '<tr id="no-data-row"><td colspan="7" class="text-center text-muted">Tidak ada data</td></tr>';
            console.log('No data, showing no-data-row');
        } else {
            console.log('Data exists, rendering rows');

            mitraData.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${escapeHtml(item.nama)}</td>
                    <td>${escapeHtml(item.hubungan)}</td>
                    <td>${item.umur}</td>
                    <td>
                        <span class="badge ${getHivBadgeClass(item.status_hiv)}">
                            ${item.status_hiv || '-'}
                        </span>
                    </td>
                    <td>
                        <span class="badge ${getArtBadgeClass(item.status_art)}">
                            ${item.status_art || '-'}
                        </span>
                    </td>
                    <td>${escapeHtml(item.no_reg_nas) || '-'}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-warning edit-btn"
                                    data-index="${index}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn"
                                    data-index="${index}" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });

            // Setup event listeners untuk buttons baru
            setupTableEventListeners();
        }

        // Update hidden input setelah render
        saveToJSON();
    }

    // ===== FORM FUNCTIONS =====
    function resetForm() {
        const form = document.getElementById('mitraForm');
        if (form) {
            form.reset();
            form.classList.remove('was-validated');
        }
        editIndex = -1;
        document.getElementById('tambahMitraModalLabel').innerText = 'Tambah Data Keluarga / Mitra';
        const saveBtn = document.getElementById('simpanMitra');
        if (saveBtn) {
            saveBtn.innerHTML = '<i class="fas fa-save"></i> Simpan';
        }
    }

    // Edit function
    function editMitra(index) {
        console.log('Edit mitra called for index:', index);
        if (index < 0 || index >= mitraData.length) {
            console.error('Invalid index for edit:', index);
            return;
        }

        editIndex = index;
        const item = mitraData[index];

        // Populate form fields
        document.getElementById('nama').value = item.nama || '';
        document.getElementById('hubungan').value = item.hubungan || '';
        document.getElementById('umur').value = item.umur || '';
        document.getElementById('status_hiv').value = item.status_hiv || '';
        document.getElementById('status_art').value = item.status_art || '';
        document.getElementById('no_reg_nas').value = item.no_reg_nas || '';

        // Update modal title and button
        document.getElementById('tambahMitraModalLabel').innerText = 'Edit Data Keluarga / Mitra';
        document.getElementById('simpanMitra').innerHTML = '<i class="fas fa-save"></i> Update';

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('tambahMitraModal'));
        modal.show();
    }

    // Delete function
    function deleteMitra(index) {
        console.log('Delete mitra called for index:', index);
        if (index < 0 || index >= mitraData.length) {
            console.error('Invalid index for delete:', index);
            return;
        }

        const item = mitraData[index];

        // Confirm deletion
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus data "${item.nama}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    performDelete(index, item);
                }
            });
        } else {
            if (confirm(`Apakah Anda yakin ingin menghapus data "${item.nama}"?`)) {
                performDelete(index, item);
            }
        }
    }

    function performDelete(index, item) {
        console.log('Deleting item at index:', index);

        // Remove from array
        mitraData.splice(index, 1);

        // Re-render table
        renderTable();

        // Show success message
        showToast(`Data "${item.nama}" berhasil dihapus!`, 'success');
    }

    // ===== EVENT LISTENERS =====

    // Modal close event
    const tambahMitraModal = document.getElementById('tambahMitraModal');
    if (tambahMitraModal) {
        tambahMitraModal.addEventListener('hidden.bs.modal', function () {
            resetForm();
        });
    }

    // Form submission
    const simpanMitraBtn = document.getElementById('simpanMitra');
    if (simpanMitraBtn) {
        simpanMitraBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const form = document.getElementById('mitraForm');
            form.classList.add('was-validated');

            // Validate required fields
            const nama = document.getElementById('nama').value.trim();
            const hubungan = document.getElementById('hubungan').value;
            const umur = document.getElementById('umur').value;

            if (!nama || !hubungan || !umur) {
                showToast('Mohon lengkapi field Nama, Hubungan, dan Umur!', 'error');
                return;
            }

            if (form.checkValidity()) {
                const formData = new FormData(form);
                const newItem = {
                    id: editIndex >= 0 ? mitraData[editIndex].id : Date.now(),
                    nama: formData.get('nama').trim(),
                    hubungan: formData.get('hubungan'),
                    umur: parseInt(formData.get('umur')),
                    status_hiv: formData.get('status_hiv'),
                    status_art: formData.get('status_art'),
                    no_reg_nas: formData.get('no_reg_nas') ? formData.get('no_reg_nas').trim() : '',
                    created_at: editIndex >= 0 ? mitraData[editIndex].created_at : new Date().toISOString(),
                    updated_at: new Date().toISOString()
                };

                if (editIndex >= 0) {
                    mitraData[editIndex] = newItem;
                    showToast(`Data "${newItem.nama}" berhasil diupdate!`, 'success');
                } else {
                    mitraData.push(newItem);
                    showToast(`Data "${newItem.nama}" berhasil ditambahkan!`, 'success');
                }

                renderTable();

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('tambahMitraModal'));
                if (modal) {
                    modal.hide();
                }
            } else {
                showToast('Mohon lengkapi semua field yang wajib diisi!', 'error');
            }
        });
    }

    // ===== INITIALIZATION =====
    initializeMitraData();

    console.log('Mitra management script initialized successfully');
});
</script>
@endpush