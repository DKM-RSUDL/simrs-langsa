{{-- Modal Riwayat Obstetrik --}}
<div class="modal fade" id="obstetrikModal" tabindex="-1" aria-labelledby="obstetrikModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="obstetrikModalLabel">
                    <i class="fas fa-baby me-2"></i>
                    <span id="modalTitle">Tambah Riwayat Obstetrik</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Isi informasi riwayat obstetrik dengan lengkap dan akurat
                </div>

                <form id="obstetrikForm" novalidate>
                    <input type="hidden" id="editIndex" value="-1">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Keadaan <span class="text-danger">*</span></label>
                                <select class="form-select" id="keadaanInput" required>
                                    <option value="">Pilih Keadaan</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Komplikasi">Komplikasi</option>
                                    <option value="Prematur">Prematur</option>
                                    <option value="Aterm">Aterm</option>
                                    <option value="Post Term">Post Term</option>
                                </select>
                                <div class="invalid-feedback">
                                    Keadaan harus dipilih
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Kehamilan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="kehamilanInput" 
                                       placeholder="Contoh: Kehamilan ke-1" required maxlength="50">
                                <div class="invalid-feedback">
                                    Kehamilan harus diisi
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Cara Persalinan <span class="text-danger">*</span></label>
                                <select class="form-select" id="caraPersalinanInput" required>
                                    <option value="">Pilih Cara Persalinan</option>
                                    <option value="Normal/Spontan">Normal/Spontan</option>
                                    <option value="Sectio Caesarea">Sectio Caesarea</option>
                                    <option value="Vakum">Vakum</option>
                                    <option value="Forceps">Forceps</option>
                                    <option value="Keguguran">Keguguran</option>
                                    <option value="Kuretase">Kuretase</option>
                                </select>
                                <div class="invalid-feedback">
                                    Cara persalinan harus dipilih
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Keadaan Nifas <span class="text-danger">*</span></label>
                                <select class="form-select" id="keadaanNifasInput" required>
                                    <option value="">Pilih Keadaan Nifas</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Infeksi">Infeksi</option>
                                    <option value="Perdarahan">Perdarahan</option>
                                    <option value="Demam">Demam</option>
                                    <option value="Komplikasi Lain">Komplikasi Lain</option>
                                </select>
                                <div class="invalid-feedback">
                                    Keadaan nifas harus dipilih
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggalLahirInput">
                                <small class="text-muted">Opsional - kosongkan jika tidak ada</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Keadaan Anak <span class="text-danger">*</span></label>
                                <select class="form-select" id="keadaanAnakInput" required>
                                    <option value="">Pilih Keadaan Anak</option>
                                    <option value="Hidup dan Sehat">Hidup dan Sehat</option>
                                    <option value="Hidup dengan Kelainan">Hidup dengan Kelainan</option>
                                    <option value="Meninggal">Meninggal</option>
                                    <option value="Keguguran">Keguguran</option>
                                    <option value="Lahir Mati">Lahir Mati</option>
                                </select>
                                <div class="invalid-feedback">
                                    Keadaan anak harus dipilih
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Tempat dan Penolong <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="tempatPenolongInput" rows="3" 
                                  placeholder="Contoh: RS Bunda - Dr. Ahmad (SpOG)" required maxlength="255"></textarea>
                        <div class="invalid-feedback">
                            Tempat dan penolong harus diisi
                        </div>
                        <small class="text-muted">Maksimal 255 karakter</small>
                    </div>
                </form>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <button type="button" class="btn btn-secondary" id="btnCancelObstetrik">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="button" id="btnSaveObstetrik" class="btn btn-primary">
                        <i class="fas fa-save"></i> <span id="btnSaveText">Simpan</span>
                    </button>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-list me-2"></i>
                        Daftar Riwayat Obstetrik
                    </h6>
                    <span class="badge bg-primary" id="badgeCount">0</span>
                </div>
                
                <div id="listObstetrik" class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                    <div class="text-center text-muted">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <p>Belum ada riwayat obstetrik</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const obstetrikModal = new bootstrap.Modal(document.getElementById('obstetrikModal'));
    const obstetrikTable = document.querySelector('#obstetrikTable tbody');
    const listObstetrik = document.getElementById('listObstetrik');
    const obstetrikInput = document.getElementById('obstetrikInput');
    const totalObstetrik = document.getElementById('totalObstetrik');
    const badgeCount = document.getElementById('badgeCount');
    
    // Initialize data
    let riwayatObstetrik = [];
    try {
        const savedData = obstetrikInput.value;
        riwayatObstetrik = savedData ? JSON.parse(savedData) : [];
    } catch (e) {
        console.error('Error parsing obstetrik data:', e);
        riwayatObstetrik = [];
    }

    // Update table in main form
    function updateObstetrikTable() {
        const tableBody = obstetrikTable;
        
        if (riwayatObstetrik.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        Tidak ada riwayat obstetrik, silahkan tambah
                    </td>
                </tr>
            `;
        } else {
            tableBody.innerHTML = riwayatObstetrik.map((item, index) => `
                <tr>
                    <td>
                        <span class="badge bg-light text-dark">${item.keadaan}</span>
                    </td>
                    <td>${item.kehamilan}</td>
                    <td>${item.caraPersalinan}</td>
                    <td>${item.keadaanNifas}</td>
                    <td>${item.tanggalLahir ? new Date(item.tanggalLahir).toLocaleDateString('id-ID') : '-'}</td>
                    <td>
                        <span class="badge ${getAnakBadgeClass(item.keadaanAnak)}">${item.keadaanAnak}</span>
                    </td>
                    <td>
                        <small title="${item.tempatPenolong}">
                            ${item.tempatPenolong.length > 30 ? item.tempatPenolong.substring(0, 30) + '...' : item.tempatPenolong}
                        </small>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-outline-primary edit-obstetrik" data-index="${index}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete-obstetrik" data-index="${index}" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Update hidden input
        obstetrikInput.value = JSON.stringify(riwayatObstetrik);
        
        // Update counters
        totalObstetrik.textContent = riwayatObstetrik.length;
    }

    // Update list in modal
    function updateObstetrikList() {
        badgeCount.textContent = riwayatObstetrik.length;
        
        if (riwayatObstetrik.length === 0) {
            listObstetrik.innerHTML = `
                <div class="text-center text-muted">
                    <i class="fas fa-inbox fa-2x mb-2"></i>
                    <p>Belum ada riwayat obstetrik</p>
                </div>
            `;
        } else {
            listObstetrik.innerHTML = riwayatObstetrik.map((item, index) => `
                <div class="card mb-2">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="card-title mb-1">
                                    <span class="badge bg-primary me-2">${index + 1}</span>
                                    ${item.kehamilan}
                                </h6>
                                <p class="card-text mb-1">
                                    <strong>Cara:</strong> ${item.caraPersalinan} | 
                                    <strong>Keadaan:</strong> ${item.keadaan}
                                </p>
                                <p class="card-text mb-1">
                                    <strong>Nifas:</strong> ${item.keadaanNifas} | 
                                    <strong>Anak:</strong> <span class="badge ${getAnakBadgeClass(item.keadaanAnak)}">${item.keadaanAnak}</span>
                                </p>
                                <p class="card-text mb-1">
                                    <strong>Tanggal:</strong> ${item.tanggalLahir ? new Date(item.tanggalLahir).toLocaleDateString('id-ID') : 'Tidak ada'}
                                </p>
                                <p class="card-text mb-0">
                                    <strong>Tempat:</strong> ${item.tempatPenolong}
                                </p>
                            </div>
                            <div class="btn-group-vertical">
                                <button class="btn btn-sm btn-outline-primary edit-obstetrik-modal" data-index="${index}" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-obstetrik-modal" data-index="${index}" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }
    }

    // Get badge class for anak status
    function getAnakBadgeClass(status) {
        switch (status) {
            case 'Hidup dan Sehat': return 'bg-success';
            case 'Hidup dengan Kelainan': return 'bg-warning';
            case 'Meninggal': case 'Lahir Mati': return 'bg-danger';
            case 'Keguguran': return 'bg-secondary';
            default: return 'bg-light text-dark';
        }
    }

    // Clear and reset form
    function clearForm() {
        const form = document.getElementById('obstetrikForm');
        form.reset();
        form.classList.remove('was-validated');
        document.getElementById('editIndex').value = '-1';
        document.getElementById('modalTitle').textContent = 'Tambah Riwayat Obstetrik';
        document.getElementById('btnSaveText').textContent = 'Simpan';
        
        // Clear validation states
        form.querySelectorAll('.form-control, .form-select').forEach(input => {
            input.classList.remove('is-valid', 'is-invalid');
        });
    }

    // Populate form for editing
    function populateForm(index) {
        const item = riwayatObstetrik[index];
        document.getElementById('keadaanInput').value = item.keadaan;
        document.getElementById('kehamilanInput').value = item.kehamilan;
        document.getElementById('caraPersalinanInput').value = item.caraPersalinan;
        document.getElementById('keadaanNifasInput').value = item.keadaanNifas;
        document.getElementById('tanggalLahirInput').value = item.tanggalLahir || '';
        document.getElementById('keadaanAnakInput').value = item.keadaanAnak;
        document.getElementById('tempatPenolongInput').value = item.tempatPenolong;
        document.getElementById('editIndex').value = index;
        document.getElementById('modalTitle').textContent = 'Edit Riwayat Obstetrik';
        document.getElementById('btnSaveText').textContent = 'Update';
    }

    // Validate form
    function validateForm() {
        const form = document.getElementById('obstetrikForm');
        const isValid = form.checkValidity();
        form.classList.add('was-validated');
        return isValid;
    }

    // Show success message
    function showSuccess(message) {
        // Create toast or alert
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed';
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `
            <i class="fas fa-check-circle me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertDiv);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 3000);
    }

    // Event Listeners
    document.getElementById('openObstetrikModal').addEventListener('click', function(e) {
        e.preventDefault();
        clearForm();
        updateObstetrikList();
        obstetrikModal.show();
    });

    document.getElementById('btnCancelObstetrik').addEventListener('click', function() {
        clearForm();
    });

    document.getElementById('btnSaveObstetrik').addEventListener('click', function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return;
        }

        const data = {
            keadaan: document.getElementById('keadaanInput').value.trim(),
            kehamilan: document.getElementById('kehamilanInput').value.trim(),
            caraPersalinan: document.getElementById('caraPersalinanInput').value.trim(),
            keadaanNifas: document.getElementById('keadaanNifasInput').value.trim(),
            tanggalLahir: document.getElementById('tanggalLahirInput').value || null,
            keadaanAnak: document.getElementById('keadaanAnakInput').value.trim(),
            tempatPenolong: document.getElementById('tempatPenolongInput').value.trim()
        };

        const editIndex = parseInt(document.getElementById('editIndex').value);

        if (editIndex >= 0) {
            riwayatObstetrik[editIndex] = data;
            showSuccess('Data riwayat obstetrik berhasil diperbarui!');
        } else {
            riwayatObstetrik.push(data);
            showSuccess('Data riwayat obstetrik berhasil ditambahkan!');
        }

        clearForm();
        updateObstetrikList();
        updateObstetrikTable();
    });

    // Event delegation for edit and delete buttons in modal
    document.getElementById('listObstetrik').addEventListener('click', function(e) {
        e.preventDefault();
        const target = e.target.closest('.edit-obstetrik-modal, .delete-obstetrik-modal');
        if (!target) return;

        const index = parseInt(target.getAttribute('data-index'));

        if (target.classList.contains('edit-obstetrik-modal')) {
            populateForm(index);
        } else if (target.classList.contains('delete-obstetrik-modal')) {
            if (confirm('Apakah Anda yakin ingin menghapus riwayat obstetrik ini?')) {
                riwayatObstetrik.splice(index, 1);
                updateObstetrikList();
                updateObstetrikTable();
                showSuccess('Data riwayat obstetrik berhasil dihapus!');
            }
        }
    });

    // Event delegation for table buttons
    obstetrikTable.addEventListener('click', function(e) {
        e.preventDefault();
        const target = e.target.closest('.edit-obstetrik, .delete-obstetrik');
        if (!target) return;

        const index = parseInt(target.getAttribute('data-index'));

        if (target.classList.contains('edit-obstetrik')) {
            populateForm(index);
            updateObstetrikList();
            obstetrikModal.show();
        } else if (target.classList.contains('delete-obstetrik')) {
            if (confirm('Apakah Anda yakin ingin menghapus riwayat obstetrik ini?')) {
                riwayatObstetrik.splice(index, 1);
                updateObstetrikTable();
                updateObstetrikList();
                showSuccess('Data riwayat obstetrik berhasil dihapus!');
            }
        }
    });

    // Initialize on page load
    updateObstetrikTable();
    updateObstetrikList();
});
</script>
@endpush