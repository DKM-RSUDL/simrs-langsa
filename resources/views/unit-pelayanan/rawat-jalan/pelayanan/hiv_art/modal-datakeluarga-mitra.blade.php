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
                            <input type="text" class="form-control" id="nama" name="nama">
                        </div>

                        <div class="mb-3">
                            <label for="hubungan" class="form-label">Hubungan</label>
                            <select class="form-select" id="hubungan" name="hubungan">
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
                            <input type="number" class="form-control" id="umur" name="umur" min="0" max="120">
                        </div>

                        <div class="mb-3">
                            <label for="status_hiv" class="form-label">Status HIV</label>
                            <select class="form-select" id="status_hiv" name="status_hiv">
                                <option value="">Pilih Status</option>
                                <option value="Positif">Positif</option>
                                <option value="Negatif">Negatif</option>
                                <option value="Tidak Diketahui">Tidak Diketahui</option>
                                <option value="Belum Tes">Belum Tes</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="status_art" class="form-label">Status ART</label>
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
                    <button type="button" class="btn btn-primary" id="simpanMitra">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing scripts...');

            // ===== BAGIAN 2: Mitra Table Management =====
            let mitraData = [];
            let editIndex = -1;

            // Function to save data to JSON format (in memory)
            function saveToJSON() {
                const jsonData = JSON.stringify(mitraData, null, 2);
                console.log('Data tersimpan ke JSON:', jsonData);
                window.mitraDataJSON = jsonData;
                window.mitraDataArray = mitraData;
            }

            // Function to show alert messages
            function showAlert(message, type = 'info') {
                // Remove existing alerts first
                const existingAlerts = document.querySelectorAll('.alert.position-fixed');
                existingAlerts.forEach(alert => alert.remove());

                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
                alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 300px;';
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
                    case 'Tidak Diketahui': return 'bg-warning';
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

            // Function to render table
            function renderTable() {
                const tbody = document.querySelector('#mitraTable tbody');
                const noDataRow = document.getElementById('no-data-row');

                if (mitraData.length === 0) {
                    noDataRow.style.display = 'table-row';
                } else {
                    noDataRow.style.display = 'none';
                    
                    // Clear existing rows except no-data-row
                    const existingRows = tbody.querySelectorAll('tr:not(#no-data-row)');
                    existingRows.forEach(row => row.remove());

                    mitraData.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.style.animation = 'fadeIn 0.3s ease-in';
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
                                    <button type="button" class="btn btn-sm btn-outline-warning edit-btn" data-index="${index}" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-index="${index}" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });

                    // Add event listeners to buttons after they're created
                    tbody.querySelectorAll('.edit-btn').forEach(btn => {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            const index = parseInt(this.getAttribute('data-index'));
                            editMitra(index);
                        });
                    });

                    tbody.querySelectorAll('.delete-btn').forEach(btn => {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            const index = parseInt(this.getAttribute('data-index'));
                            deleteMitra(index);
                        });
                    });
                }
                
                saveToJSON();
            }

            // Function to reset form
            function resetForm() {
                const form = document.getElementById('mitraForm');
                if (form) {
                    form.reset();
                    form.classList.remove('was-validated');
                }
                editIndex = -1;
                document.getElementById('tambahMitraModalLabel').innerText = 'Tambah Data Keluarga / Mitra';
                document.getElementById('simpanMitra').innerHTML = '<i class="fas fa-save"></i> Simpan';
            }

            // Edit function (no longer needs to be global)
            function editMitra(index) {
                console.log('Edit mitra called for index:', index);
                editIndex = index;
                const item = mitraData[index];
                
                document.getElementById('nama').value = item.nama;
                document.getElementById('hubungan').value = item.hubungan;
                document.getElementById('umur').value = item.umur;
                document.getElementById('status_hiv').value = item.status_hiv || '';
                document.getElementById('status_art').value = item.status_art || '';
                document.getElementById('no_reg_nas').value = item.no_reg_nas || '';
                
                document.getElementById('tambahMitraModalLabel').innerText = 'Edit Data Keluarga / Mitra';
                document.getElementById('simpanMitra').innerHTML = '<i class="fas fa-save"></i> Update';
                
                const modal = new bootstrap.Modal(document.getElementById('tambahMitraModal'));
                modal.show();
            }

            // Delete function (no longer needs to be global)
            function deleteMitra(index) {
                console.log('Delete mitra called for index:', index);
                const item = mitraData[index];
                if (confirm(`Apakah Anda yakin ingin menghapus data "${item.nama}"?`)) {
                    mitraData.splice(index, 1);
                    renderTable();
                    showAlert(`Data "${item.nama}" berhasil dihapus!`, 'warning');
                }
            }

            // Modal event handlers
            const tambahMitraModal = document.getElementById('tambahMitraModal');
            if (tambahMitraModal) {
                tambahMitraModal.addEventListener('hidden.bs.modal', function() {
                    resetForm();
                });
            }

            // Form submission handler
            const simpanMitraBtn = document.getElementById('simpanMitra');
            if (simpanMitraBtn) {
                simpanMitraBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const form = document.getElementById('mitraForm');
                    form.classList.add('was-validated');
                    
                    if (form.checkValidity()) {
                        const formData = new FormData(form);
                        const newItem = {
                            id: editIndex >= 0 ? mitraData[editIndex].id : Date.now(),
                            nama: formData.get('nama').trim(),
                            hubungan: formData.get('hubungan'),
                            umur: parseInt(formData.get('umur')),
                            status_hiv: formData.get('status_hiv'),
                            status_art: formData.get('status_art'),
                            no_reg_nas: formData.get('no_reg_nas').trim(),
                            created_at: editIndex >= 0 ? mitraData[editIndex].created_at : new Date().toISOString(),
                            updated_at: new Date().toISOString()
                        };

                        if (editIndex >= 0) {
                            mitraData[editIndex] = newItem;
                            showAlert(`Data "${newItem.nama}" berhasil diupdate!`, 'success');
                        } else {
                            mitraData.push(newItem);
                            showAlert(`Data "${newItem.nama}" berhasil ditambahkan!`, 'success');
                        }

                        renderTable();
                        
                        const modal = bootstrap.Modal.getInstance(document.getElementById('tambahMitraModal'));
                        if (modal) {
                            modal.hide();
                        }
                    } else {
                        showAlert('Mohon lengkapi semua field yang wajib diisi!', 'danger');
                    }
                });
            }

            // Prevent form submission on Enter key
            const mitraForm = document.getElementById('mitraForm');
            if (mitraForm) {
                mitraForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    document.getElementById('simpanMitra').click();
                });
            }

            // Initialize table
            renderTable();
            
            console.log('All scripts initialized successfully');
        });
    </script>
@endpush