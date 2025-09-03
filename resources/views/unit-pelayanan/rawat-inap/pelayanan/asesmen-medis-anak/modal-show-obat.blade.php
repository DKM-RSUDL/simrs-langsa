<!-- Modal Riwayat Obat -->
<div class="modal fade" id="obatModal" tabindex="-1" aria-labelledby="obatModalLabel" aria-hidden="true"
    style="z-index: 1060;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="obatModalLabel">Kelola Riwayat Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Tambah/Edit Obat -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0" id="formTitle">Tambah Obat Baru</h6>
                    </div>
                    <div class="card-body">
                        <form id="formRiwayatObat">
                            <input type="hidden" id="editIndex" value="-1">
                            <div class="mb-3">
                                <label class="form-label">Nama Obat</label>
                                <input type="text" class="form-control" id="namaObat" placeholder="Nama obat" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Aturan Pakai</label>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="form-label small">Frekuensi/interval</label>
                                        <input type="text" class="form-control" id="frekuensi" placeholder="3x sehari" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">Keterangan</label>
                                        <select class="form-select" id="keterangan">
                                            <option value="Sebelum Makan">Sebelum Makan</option>
                                            <option value="Sesudah Makan" selected>Sesudah Makan</option>
                                            <option value="Saat Makan">Saat Makan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Dosis sekali minum</label>
                                    <input type="text" class="form-control" id="dosis" placeholder="1 tablet" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Satuan</label>
                                    <select class="form-select" id="satuan">
                                        <option value="Tablet">Tablet</option>
                                        <option value="Kapsul">Kapsul</option>
                                        <option value="ml">ml</option>
                                        <option value="mg">mg</option>
                                        <option value="Sachet">Sachet</option>
                                        <option value="Sendok">Sendok</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary" id="btnTambahObat">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                                <button type="button" class="btn btn-success d-none" id="btnUpdateObat">
                                    <i class="fas fa-save"></i> Update
                                </button>
                                <button type="button" class="btn btn-secondary d-none" id="btnCancelEdit">
                                    <i class="fas fa-times"></i> Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Daftar Obat -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Daftar Riwayat Obat</h6>
                        <span class="badge bg-info" id="obatCount">0 obat</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm" id="modalObatTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th>Dosis</th>
                                        <th>Aturan Pakai</th>
                                        <th width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="modalObatBody">
                                    <!-- Dynamic content -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" id="btnSaveAllObat">
                    <i class="fas fa-save"></i> Simpan Semua
                </button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const obatModal = new bootstrap.Modal(document.getElementById('obatModal'));
    const obatTable = document.querySelector('#createRiwayatObatTable tbody');
    const modalObatBody = document.getElementById('modalObatBody');
    const riwayatObatDataInput = document.getElementById('riwayatObatData');
    const isReadonly = {{ ($readonly ?? false) ? 'true' : 'false' }};

    let riwayatObat = [];
    let editingIndex = -1;

    // Load existing data saat pertama kali
    function loadExistingObatData() {
        try {
            const existingData = riwayatObatDataInput.value;
            if (existingData && existingData !== '[]') {
                riwayatObat = JSON.parse(existingData);
                updateMainObatTable();
            }
        } catch (e) {
            console.error('Error parsing existing obat data:', e);
            riwayatObat = [];
        }
    }

    // Update main table (di form utama)
    function updateMainObatTable() {
        const colSpan = isReadonly ? '3' : '4';

        if (riwayatObat.length === 0) {
            obatTable.innerHTML = `
                <tr>
                    <td colspan="${colSpan}" class="text-center py-3">
                        <div class="text-muted">
                            <i class="bi bi-exclamation-circle mb-2" style="font-size: 1.5rem;"></i>
                            <p class="mb-0">Belum ada data riwayat obat</p>
                        </div>
                    </td>
                </tr>
            `;
        } else {
            obatTable.innerHTML = riwayatObat.map((obat, index) => `
                <tr>
                    <td>
                        <strong>${obat.namaObat}</strong>
                    </td>
                    <td>${obat.dosis} ${obat.satuan}</td>
                    <td>
                        <span class="badge bg-primary">${obat.frekuensi}</span>
                        <br><small class="text-muted">${obat.keterangan}</small>
                    </td>
                    `
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-danger delete-obat" data-index="${index}" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                    ` : ''}
                </tr>
            `).join('');
        }

        // Update hidden input
        riwayatObatDataInput.value = JSON.stringify(riwayatObat);
    }

    // Update modal table
    function updateModalObatTable() {
        document.getElementById('obatCount').textContent = `${riwayatObat.length} obat`;

        if (riwayatObat.length === 0) {
            modalObatBody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-3 text-muted">
                        <i class="fas fa-pills mb-2" style="font-size: 2rem;"></i>
                        <p class="mb-0">Belum ada obat yang ditambahkan</p>
                    </td>
                </tr>
            `;
        } else {
            modalObatBody.innerHTML = riwayatObat.map((obat, index) => `
                <tr>
                    <td><strong>${obat.namaObat}</strong></td>
                    <td>${obat.dosis} ${obat.satuan}</td>
                    <td>
                        <span class="badge bg-primary">${obat.frekuensi}</span>
                        <br><small class="text-muted">${obat.keterangan}</small>
                    </td>
                </tr>
            `).join('');
        }
    }

    // Reset form
    function resetObatForm() {
        document.getElementById('formRiwayatObat').reset();
        document.getElementById('editIndex').value = '-1';
        document.getElementById('formTitle').textContent = 'Tambah Obat Baru';
        document.getElementById('btnTambahObat').classList.remove('d-none');
        document.getElementById('btnUpdateObat').classList.add('d-none');
        document.getElementById('btnCancelEdit').classList.add('d-none');
        document.getElementById('satuan').value = 'Tablet';
        document.getElementById('keterangan').value = 'Sesudah Makan';
        editingIndex = -1;
    }

    // Open modal
    document.getElementById('openObatModal').addEventListener('click', function() {
        updateModalObatTable();
        resetObatForm();
        obatModal.show();
    });

    // Add obat
    document.getElementById('btnTambahObat').addEventListener('click', function() {
        const namaObat = document.getElementById('namaObat').value.trim();
        const frekuensi = document.getElementById('frekuensi').value.trim();
        const keterangan = document.getElementById('keterangan').value;
        const dosis = document.getElementById('dosis').value.trim();
        const satuan = document.getElementById('satuan').value;

        if (!namaObat || !frekuensi || !dosis) {
            alert('Harap isi semua field yang wajib diisi');
            return;
        }

        // Check for duplicate
        const isDuplicate = riwayatObat.some(obat =>
            obat.namaObat.toLowerCase() === namaObat.toLowerCase()
        );

        if (isDuplicate) {
            alert('Obat dengan nama tersebut sudah ada');
            return;
        }

        riwayatObat.push({
            namaObat: namaObat,
            frekuensi: frekuensi,
            keterangan: keterangan,
            dosis: dosis,
            satuan: satuan
        });

        updateModalObatTable();
        resetObatForm();

        // Show success message
        const toast = document.createElement('div');
        toast.className = 'alert alert-success alert-dismissible fade show position-fixed';
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
        toast.innerHTML = `
            ${namaObat} berhasil ditambahkan
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    });

    // Edit obat
    modalObatBody.addEventListener('click', function(e) {
        if (e.target.closest('.edit-obat')) {
            const index = parseInt(e.target.closest('.edit-obat').dataset.index);
            const obat = riwayatObat[index];

            document.getElementById('namaObat').value = obat.namaObat;
            document.getElementById('frekuensi').value = obat.frekuensi;
            document.getElementById('keterangan').value = obat.keterangan;
            document.getElementById('dosis').value = obat.dosis;
            document.getElementById('satuan').value = obat.satuan;
            document.getElementById('editIndex').value = index;

            document.getElementById('formTitle').textContent = 'Edit Obat';
            document.getElementById('btnTambahObat').classList.add('d-none');
            document.getElementById('btnUpdateObat').classList.remove('d-none');
            document.getElementById('btnCancelEdit').classList.remove('d-none');

            editingIndex = index;
        }

        if (e.target.closest('.delete-modal-obat')) {
            const index = parseInt(e.target.closest('.delete-modal-obat').dataset.index);
            const obatName = riwayatObat[index].namaObat;

            if (confirm(`Apakah Anda yakin ingin menghapus obat "${obatName}"?`)) {
                riwayatObat.splice(index, 1);
                updateModalObatTable();
                resetObatForm();
            }
        }
    });

    // Update obat
    document.getElementById('btnUpdateObat').addEventListener('click', function() {
        const index = parseInt(document.getElementById('editIndex').value);
        const namaObat = document.getElementById('namaObat').value.trim();
        const frekuensi = document.getElementById('frekuensi').value.trim();
        const keterangan = document.getElementById('keterangan').value;
        const dosis = document.getElementById('dosis').value.trim();
        const satuan = document.getElementById('satuan').value;

        if (!namaObat || !frekuensi || !dosis) {
            alert('Harap isi semua field yang wajib diisi');
            return;
        }

        // Check for duplicate (except current item)
        const isDuplicate = riwayatObat.some((obat, idx) =>
            idx !== index && obat.namaObat.toLowerCase() === namaObat.toLowerCase()
        );

        if (isDuplicate) {
            alert('Obat dengan nama tersebut sudah ada');
            return;
        }

        riwayatObat[index] = {
            namaObat: namaObat,
            frekuensi: frekuensi,
            keterangan: keterangan,
            dosis: dosis,
            satuan: satuan
        };

        updateModalObatTable();
        resetObatForm();

        // Show success message
        const toast = document.createElement('div');
        toast.className = 'alert alert-info alert-dismissible fade show position-fixed';
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
        toast.innerHTML = `
            ${namaObat} berhasil diperbarui
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    });

    // Cancel edit
    document.getElementById('btnCancelEdit').addEventListener('click', function() {
        resetObatForm();
    });

    // Save all and close modal
    document.getElementById('btnSaveAllObat').addEventListener('click', function() {
        updateMainObatTable();
        obatModal.hide();

        // Show success message
        const toast = document.createElement('div');
        toast.className = 'alert alert-success alert-dismissible fade show position-fixed';
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
        toast.innerHTML = `
            <i class="fas fa-check-circle"></i> Data riwayat obat berhasil disimpan
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    });

    // Delete from main table
    obatTable.addEventListener('click', function(e) {
        if (e.target.closest('.delete-obat')) {
            const index = parseInt(e.target.closest('.delete-obat').dataset.index);
            const obatName = riwayatObat[index].namaObat;

            if (confirm(`Apakah Anda yakin ingin menghapus obat "${obatName}"?`)) {
                riwayatObat.splice(index, 1);
                updateMainObatTable();
            }
        }
    });

    // Initialize with existing data
    loadExistingObatData();
});
</script>
@endpush
