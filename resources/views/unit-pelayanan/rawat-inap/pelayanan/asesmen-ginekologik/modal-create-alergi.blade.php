{{-- Modal Riwayat Obstetrik --}}
<div class="modal fade" id="obstetrikModal" tabindex="-1" aria-labelledby="obstetrikModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="obstetrikModalLabel">Input Riwayat Obstetrik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold" id="modalTitle">Tambah Riwayat Obstetrik</h6>
                <p class="text-muted">Isi informasi riwayat obstetrik pada kolom di bawah</p>

                <form id="obstetrikForm" novalidate>
                    <input type="hidden" id="editIndex" value="-1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Keadaan <span class="text-danger">*</span></label>
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
                                <label class="form-label">Kehamilan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="kehamilanInput" placeholder="Kehamilan ke-" required>
                                <div class="invalid-feedback">
                                    Kehamilan harus diisi
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cara Persalinan <span class="text-danger">*</span></label>
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
                                <label class="form-label">Keadaan Nifas <span class="text-danger">*</span></label>
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
                                <small class="text-muted">Opsional</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Keadaan Anak <span class="text-danger">*</span></label>
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
                        <label class="form-label">Tempat dan Penolong <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="tempatPenolongInput" rows="3" placeholder="Contoh: RS Bunda - Dr. Ahmad (SpOG)" required></textarea>
                        <div class="invalid-feedback">
                            Tempat dan penolong harus diisi
                        </div>
                    </div>

                    <button type="button" id="btnAddObstetrik" class="btn btn-sm btn-primary mt-2 float-end">
                        <span id="btnText">Tambah</span>
                    </button>
                </form>

                <h6 class="fw-bold mt-5">Daftar Riwayat Obstetrik</h6>
                <div id="listObstetrik" class="text-muted">
                    <small>Tidak ada riwayat</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnSaveObstetrik" class="btn btn-primary">Simpan</button>
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
        obstetrikTable.innerHTML = riwayatObstetrik.length === 0 ? `
            <tr>
                <td colspan="8" class="text-center text-muted">Tidak ada riwayat obstetrik, silahkan tambah</td>
            </tr>
        ` : riwayatObstetrik.map((item, index) => `
            <tr>
                <td>${item.keadaan}</td>
                <td>${item.kehamilan}</td>
                <td>${item.caraPersalinan}</td>
                <td>${item.keadaanNifas}</td>
                <td>${item.tanggalLahir ? new Date(item.tanggalLahir).toLocaleDateString('id-ID') : '-'}</td>
                <td>${item.keadaanAnak}</td>
                <td>${item.tempatPenolong}</td>
                <td>
                    <button class="btn btn-sm btn-link edit-obstetrik" data-index="${index}">
                        <i class="fas fa-edit text-primary"></i>
                    </button>
                    <button class="btn btn-sm btn-link delete-obstetrik" data-index="${index}">
                        <i class="fas fa-times text-danger"></i>
                    </button>
                </td>
            </tr>
        `).join('');

        obstetrikInput.value = JSON.stringify(riwayatObstetrik);
    }

    // Update list in modal
    function updateObstetrikList() {
        listObstetrik.innerHTML = riwayatObstetrik.length === 0 ? '<small class="text-muted">Tidak ada riwayat</small>' :
            riwayatObstetrik.map((item, index) => `
                <div class="border-bottom pb-2 mb-2">
                    <strong>Kehamilan ${item.kehamilan}</strong> - ${item.caraPersalinan}
                    <div class="float-end">
                        <button class="btn btn-sm btn-link edit-obstetrik-modal" data-index="${index}">
                            <i class="fas fa-edit text-primary"></i>
                        </button>
                        <button class="btn btn-sm btn-link delete-obstetrik-modal" data-index="${index}">
                            <i class="fas fa-trash text-danger"></i>
                        </button>
                    </div>
                    <br>
                    <small>Tanggal: ${item.tanggalLahir ? new Date(item.tanggalLahir).toLocaleDateString('id-ID') : 'Tidak ada'} | Anak: ${item.keadaanAnak}</small>
                </div>
            `).join('');
    }

    // Clear and reset form
    function clearForm() {
        const form = document.getElementById('obstetrikForm');
        form.reset();
        form.classList.remove('was-validated');
        document.getElementById('editIndex').value = '-1';
        document.getElementById('modalTitle').textContent = 'Tambah Riwayat Obstetrik';
        document.getElementById('btnText').textContent = 'Tambah';
        
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
        document.getElementById('btnText').textContent = 'Update';
    }

    // Validate form
    function validateForm() {
        const form = document.getElementById('obstetrikForm');
        const isValid = form.checkValidity();
        form.classList.add('was-validated');
        return isValid;
    }

    // Show success alert
    function showAlert(message, type = 'success') {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertDiv);
        
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

    document.getElementById('btnAddObstetrik').addEventListener('click', function(e) {
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
            showAlert('Data berhasil diperbarui!');
        } else {
            riwayatObstetrik.push(data);
            showAlert('Data berhasil ditambahkan!');
        }

        clearForm();
        updateObstetrikList();
    });

    document.getElementById('btnSaveObstetrik').addEventListener('click', function(e) {
        e.preventDefault();
        updateObstetrikTable();
        obstetrikModal.hide();
        showAlert('Data riwayat obstetrik berhasil disimpan!');
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
                showAlert('Data berhasil dihapus!');
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
                showAlert('Data berhasil dihapus!');
            }
        }
    });

    // Real-time validation
    document.querySelectorAll('#obstetrikForm input, #obstetrikForm select, #obstetrikForm textarea').forEach(input => {
        input.addEventListener('input', function() {
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
            }
        });
    });

    // Initialize
    updateObstetrikTable();
    updateObstetrikList();
});
</script>
@endpush