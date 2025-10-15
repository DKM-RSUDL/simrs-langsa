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
                <p class="text-muted">Isi informasi riwayat obstetrik pada kolom di bawah (semua field bersifat
                    opsional)</p>

                <form id="obstetrikForm">
                    <input type="hidden" id="editIndex" value="-1">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Keadaan Kehamilan</label>
                                <input type="text" class="form-control" id="keadaanInput"
                                    placeholder="Contoh: Normal, Komplikasi, dll">
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kehamilan</label>
                                <input type="text" class="form-control" id="kehamilanInput"
                                    placeholder="Contoh: Kehamilan ke-1, Primi, dll">
                            </div>
                        </div> --}}
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cara Persalinan</label>
                                <input type="text" class="form-control" id="caraPersalinanInput"
                                    placeholder="Contoh: Normal, Caesar, Vakum, dll">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Keadaan Nifas</label>
                                <input type="text" class="form-control" id="keadaanNifasInput"
                                    placeholder="Contoh: Normal, Infeksi, dll">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggalLahirInput">
                                <small class="text-muted">Opsional - kosongkan jika tidak diketahui</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Keadaan Anak</label>
                                <input type="text" class="form-control" id="keadaanAnakInput"
                                    placeholder="Contoh: Hidup sehat, Meninggal, dll">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tempat dan Penolong</label>
                        <textarea class="form-control" id="tempatPenolongInput" rows="3"
                            placeholder="Contoh: RS Bunda - Dr. Ahmad (SpOG), Puskesmas - Bidan Sari, Rumah - Dukun Paraji, dll"></textarea>
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
        document.addEventListener('DOMContentLoaded', function () {
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
                    <td>${item.keadaan || '-'}</td>
                    <td>${item.kehamilan || '-'}</td>
                    <td>${item.caraPersalinan || '-'}</td>
                    <td>${item.keadaanNifas || '-'}</td>
                    <td>${item.tanggalLahir ? new Date(item.tanggalLahir).toLocaleDateString('id-ID') : '-'}</td>
                    <td>${item.keadaanAnak || '-'}</td>
                    <td>${item.tempatPenolong || '-'}</td>
                    <td>
                        <button class="btn btn-sm btn-link edit-obstetrik" data-index="${index}" title="Edit">
                            <i class="fas fa-edit text-primary"></i>
                        </button>
                        <button class="btn btn-sm btn-link delete-obstetrik" data-index="${index}" title="Hapus">
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
                    <div class="border rounded p-3 mb-2 bg-light">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <strong>Kehamilan:</strong> ${item.kehamilan || 'Tidak diisi'} | 
                                    <strong>Persalinan:</strong> ${item.caraPersalinan || 'Tidak diisi'}
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small><strong>Keadaan:</strong> ${item.keadaan || 'Tidak diisi'}</small><br>
                                        <small><strong>Keadaan Nifas:</strong> ${item.keadaanNifas || 'Tidak diisi'}</small><br>
                                        <small><strong>Keadaan Anak:</strong> ${item.keadaanAnak || 'Tidak diisi'}</small>
                                    </div>
                                    <div class="col-md-6">
                                        <small><strong>Tanggal Lahir:</strong> ${item.tanggalLahir ? new Date(item.tanggalLahir).toLocaleDateString('id-ID') : 'Tidak diisi'}</small><br>
                                        <small><strong>Tempat & Penolong:</strong><br>${item.tempatPenolong || 'Tidak diisi'}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="ms-3">
                                <button class="btn btn-sm btn-outline-primary edit-obstetrik-modal me-1" data-index="${index}" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-obstetrik-modal" data-index="${index}" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            // Clear and reset form
            function clearForm() {
                const form = document.getElementById('obstetrikForm');
                form.reset();
                document.getElementById('editIndex').value = '-1';
                document.getElementById('modalTitle').textContent = 'Tambah Riwayat Obstetrik';
                document.getElementById('btnText').textContent = 'Tambah';
            }

            // Populate form for editing
            function populateForm(index) {
                const item = riwayatObstetrik[index];
                document.getElementById('keadaanInput').value = item.keadaan || '';
                document.getElementById('kehamilanInput').value = item.kehamilan || '';
                document.getElementById('caraPersalinanInput').value = item.caraPersalinan || '';
                document.getElementById('keadaanNifasInput').value = item.keadaanNifas || '';
                document.getElementById('tanggalLahirInput').value = item.tanggalLahir || '';
                document.getElementById('keadaanAnakInput').value = item.keadaanAnak || '';
                document.getElementById('tempatPenolongInput').value = item.tempatPenolong || '';
                document.getElementById('editIndex').value = index;
                document.getElementById('modalTitle').textContent = 'Edit Riwayat Obstetrik';
                document.getElementById('btnText').textContent = 'Update';
            }

            // Check if form has data (at least one field filled)
            function hasFormData() {
                const inputs = [
                    'keadaanInput', 'kehamilanInput', 'caraPersalinanInput',
                    'keadaanNifasInput', 'tanggalLahirInput', 'keadaanAnakInput', 'tempatPenolongInput'
                ];

                return inputs.some(id => {
                    const value = document.getElementById(id).value.trim();
                    return value !== '';
                });
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
            document.getElementById('openObstetrikModal').addEventListener('click', function (e) {
                e.preventDefault();
                clearForm();
                updateObstetrikList();
                obstetrikModal.show();
            });

            document.getElementById('btnAddObstetrik').addEventListener('click', function (e) {
                e.preventDefault();

                // Check if at least one field is filled
                if (!hasFormData()) {
                    showAlert('Minimal isi satu field untuk menambah riwayat obstetrik!', 'danger');
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

            document.getElementById('btnSaveObstetrik').addEventListener('click', function (e) {
                e.preventDefault();
                updateObstetrikTable();
                obstetrikModal.hide();
                showAlert('Data riwayat obstetrik berhasil disimpan!');
            });

            // Event delegation for edit and delete buttons in modal
            document.getElementById('listObstetrik').addEventListener('click', function (e) {
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
            if (obstetrikTable) {
                obstetrikTable.addEventListener('click', function (e) {
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
            }

            // Initialize
            updateObstetrikTable();
            updateObstetrikList();
        });
    </script>
@endpush