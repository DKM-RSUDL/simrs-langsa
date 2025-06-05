{{-- Modal Riwayat Obstetrik --}}
<div class="modal fade" id="obstetrikModal" tabindex="-1" aria-labelledby="obstetrikModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="obstetrikModalLabel">Input Riwayat Obstetrik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold">Tambah Riwayat Obstetrik</h6>
                <p class="text-muted">Isi informasi riwayat obstetrik pada kolom di bawah</p>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Keadaan</label>
                            <select class="form-select" id="keadaanInput">
                                <option value="">Pilih Keadaan</option>
                                <option value="Normal">Normal</option>
                                <option value="Komplikasi">Komplikasi</option>
                                <option value="Prematur">Prematur</option>
                                <option value="Aterm">Aterm</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Kehamilan</label>
                            <input type="text" class="form-control" id="kehamilanInput" placeholder="Kehamilan ke-">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Cara Persalinan</label>
                            <select class="form-select" id="caraPersalinanInput">
                                <option value="">Pilih Cara Persalinan</option>
                                <option value="Normal/Spontan">Normal/Spontan</option>
                                <option value="Sectio Caesarea">Sectio Caesarea</option>
                                <option value="Vakum">Vakum</option>
                                <option value="Forceps">Forceps</option>
                                <option value="Keguguran">Keguguran</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Keadaan Nifas</label>
                            <select class="form-select" id="keadaanNifasInput">
                                <option value="">Pilih Keadaan Nifas</option>
                                <option value="Normal">Normal</option>
                                <option value="Infeksi">Infeksi</option>
                                <option value="Perdarahan">Perdarahan</option>
                                <option value="Demam">Demam</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggalLahirInput">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Keadaan Anak</label>
                            <select class="form-select" id="keadaanAnakInput">
                                <option value="">Pilih Keadaan Anak</option>
                                <option value="Hidup dan Sehat">Hidup dan Sehat</option>
                                <option value="Hidup dengan Kelainan">Hidup dengan Kelainan</option>
                                <option value="Meninggal">Meninggal</option>
                                <option value="Keguguran">Keguguran</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tempat dan Penolong</label>
                    <textarea class="form-control" id="tempatPenolongInput" rows="3"
                        placeholder="Contoh: RS Bunda - Dr. Ahmad (SpOG)"></textarea>
                </div>

                <button type="button" id="btnAddObstetrik"
                    class="btn btn-sm btn-primary mt-2 float-end">Tambah</button>

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
            // Riwayat Obstetrik Modal Handler
            const obstetrikModal = new bootstrap.Modal(document.getElementById('obstetrikModal'));
            const obstetrikTable = document.querySelector('#obstetrikTable tbody');
            const listObstetrik = document.getElementById('listObstetrik');
            const obstetrikInput = document.getElementById('obstetrikInput');

            // Initialize riwayatArray with existing data
            let riwayatArray = [];

            // Load existing data on page load
            function loadExistingData() {
                if (obstetrikInput && obstetrikInput.value && obstetrikInput.value !== '[]') {
                    try {
                        riwayatArray = JSON.parse(obstetrikInput.value);
                        console.log('Loaded existing obstetrik data:', riwayatArray);
                    } catch (e) {
                        console.error('Error parsing existing obstetrik data:', e);
                        riwayatArray = [];
                    }
                }
                updateObstetrikTable();
            }

            function updateObstetrikTable() {
                if (!obstetrikTable) return;

                if (riwayatArray.length === 0) {
                    obstetrikTable.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center text-muted">Tidak ada riwayat obstetrik, silahkan tambah</td>
                    </tr>
                `;
                } else {
                    obstetrikTable.innerHTML = riwayatArray.map((item, index) => {
                        // Handle both camelCase and snake_case properties
                        const keadaan = item.keadaan || '-';
                        const kehamilan = item.kehamilan || '-';
                        const caraPersalinan = item.caraPersalinan || item.cara_persalinan || '-';
                        const keadaanNifas = item.keadaanNifas || item.keadaan_nifas || '-';
                        const tanggalLahir = item.tanggalLahir || item.tanggal_lahir || '-';
                        const keadaanAnak = item.keadaanAnak || item.keadaan_anak || '-';
                        const tempatPenolong = item.tempatPenolong || item.tempat_penolong || '-';

                        return `
                        <tr>
                            <td>${keadaan}</td>
                            <td>${kehamilan}</td>
                            <td>${caraPersalinan}</td>
                            <td>${keadaanNifas}</td>
                            <td>${tanggalLahir}</td>
                            <td>${keadaanAnak}</td>
                            <td>${tempatPenolong}</td>
                            <td>
                                <button class="btn btn-sm btn-link delete-obstetrik" data-index="${index}" title="Hapus">
                                    <i class="bi bi-trash text-danger"></i>
                                </button>
                            </td>
                        </tr>
                        `;
                    }).join('');
                }

                // Update input hidden
                if (obstetrikInput) {
                    obstetrikInput.value = JSON.stringify(riwayatArray);
                }
            }

            function updateObstetrikList() {
                if (!listObstetrik) return;

                if (riwayatArray.length === 0) {
                    listObstetrik.innerHTML = '<small class="text-muted">Tidak ada riwayat</small>';
                } else {
                    listObstetrik.innerHTML = riwayatArray.map((item, index) => {
                        // Handle both camelCase and snake_case properties
                        const kehamilan = item.kehamilan || 'Tidak diketahui';
                        const caraPersalinan = item.caraPersalinan || item.cara_persalinan || 'Tidak diketahui';
                        const tanggalLahir = item.tanggalLahir || item.tanggal_lahir || 'Tidak ada';
                        const keadaanAnak = item.keadaanAnak || item.keadaan_anak || 'Tidak diketahui';

                        return `
                        <div class="border-bottom pb-2 mb-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>Kehamilan ${kehamilan}</strong> - ${caraPersalinan}<br>
                                    <small>Tanggal: ${tanggalLahir} | Anak: ${keadaanAnak}</small>
                                </div>
                                <button class="btn btn-sm btn-outline-danger delete-obstetrik-modal" data-index="${index}" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        `;
                    }).join('');

                    // Add event listeners for delete buttons in modal
                    document.querySelectorAll('.delete-obstetrik-modal').forEach(button => {
                        button.addEventListener('click', function() {
                            const index = parseInt(this.getAttribute('data-index'));
                            if (confirm('Apakah Anda yakin ingin menghapus riwayat obstetrik ini?')) {
                                riwayatArray.splice(index, 1);
                                updateObstetrikList();
                                console.log('Deleted obstetrik item, remaining:', riwayatArray);
                            }
                        });
                    });
                }
            }

            // Open modal - load current data first
            const openObstetrikModalBtn = document.getElementById('openObstetrikModal');
            if (openObstetrikModalBtn) {
                openObstetrikModalBtn.addEventListener('click', function() {
                    // Reload data from hidden input before showing modal
                    if (obstetrikInput && obstetrikInput.value && obstetrikInput.value !== '[]') {
                        try {
                            riwayatArray = JSON.parse(obstetrikInput.value);
                        } catch (e) {
                            console.error('Error parsing obstetrik data for modal:', e);
                            riwayatArray = [];
                        }
                    }
                    updateObstetrikList();
                    obstetrikModal.show();
                });
            }

            // Add obstetrik - Improved validation
            const btnAddObstetrik = document.getElementById('btnAddObstetrik');
            if (btnAddObstetrik) {
                btnAddObstetrik.addEventListener('click', function() {
                    const keadaan = document.getElementById('keadaanInput').value.trim();
                    const kehamilan = document.getElementById('kehamilanInput').value.trim();
                    const caraPersalinan = document.getElementById('caraPersalinanInput').value.trim();
                    const keadaanNifas = document.getElementById('keadaanNifasInput').value.trim();
                    const tanggalLahir = document.getElementById('tanggalLahirInput').value.trim();
                    const keadaanAnak = document.getElementById('keadaanAnakInput').value.trim();
                    const tempatPenolong = document.getElementById('tempatPenolongInput').value.trim();

                    // Validation dengan pesan yang lebih spesifik
                    let missingFields = [];

                    if (!keadaan) missingFields.push('Keadaan');
                    if (!kehamilan) missingFields.push('Kehamilan');
                    if (!caraPersalinan) missingFields.push('Cara Persalinan');
                    if (!keadaanNifas) missingFields.push('Keadaan Nifas');
                    if (!keadaanAnak) missingFields.push('Keadaan Anak');
                    if (!tempatPenolong) missingFields.push('Tempat dan Penolong');

                    if (missingFields.length > 0) {
                        alert('Harap isi field berikut: ' + missingFields.join(', '));
                        return;
                    }

                    // Create new obstetrik entry with consistent property names
                    const newEntry = {
                        keadaan: keadaan,
                        kehamilan: kehamilan,
                        caraPersalinan: caraPersalinan,
                        keadaanNifas: keadaanNifas,
                        tanggalLahir: tanggalLahir,
                        keadaanAnak: keadaanAnak,
                        tempatPenolong: tempatPenolong
                    };

                    // Add to array
                    riwayatArray.push(newEntry);

                    // Clear inputs
                    document.getElementById('keadaanInput').value = '';
                    document.getElementById('kehamilanInput').value = '';
                    document.getElementById('caraPersalinanInput').value = '';
                    document.getElementById('keadaanNifasInput').value = '';
                    document.getElementById('tanggalLahirInput').value = '';
                    document.getElementById('keadaanAnakInput').value = '';
                    document.getElementById('tempatPenolongInput').value = '';

                    // Update displays
                    updateObstetrikList();

                    console.log('Added new obstetrik entry:', newEntry);
                    console.log('Current riwayatArray:', riwayatArray);

                    // Show success message
                    alert('Data riwayat obstetrik berhasil ditambahkan!');
                });
            }

            // Save obstetrik - update table and close modal
            const btnSaveObstetrik = document.getElementById('btnSaveObstetrik');
            if (btnSaveObstetrik) {
                btnSaveObstetrik.addEventListener('click', function() {
                    updateObstetrikTable();
                    obstetrikModal.hide();
                    console.log('Saved obstetrik data to table:', riwayatArray);
                });
            }

            // Delete obstetrik from main table (event delegation)
            if (obstetrikTable) {
                obstetrikTable.addEventListener('click', function(e) {
                    if (e.target.closest('.delete-obstetrik')) {
                        const index = parseInt(e.target.closest('.delete-obstetrik').getAttribute('data-index'));
                        if (confirm('Apakah Anda yakin ingin menghapus riwayat obstetrik ini?')) {
                            riwayatArray.splice(index, 1);
                            updateObstetrikTable();
                            console.log('Deleted from main table, remaining:', riwayatArray);
                        }
                    }
                });
            }

            // Initialize on page load
            loadExistingData();
        });
    </script>
@endpush
