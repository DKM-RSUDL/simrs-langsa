{{-- Modal Riwayat Obstetrik --}}
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
            let riwayatObstetrik = []; // Array untuk menyimpan riwayat obstetrik

            function updateObstetrikTable() {
                if (riwayatObstetrik.length === 0) {
                    obstetrikTable.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center text-muted">Tidak ada riwayat obstetrik, silahkan tambah</td>
                    </tr>
                `;
                } else {
                    obstetrikTable.innerHTML = riwayatObstetrik.map((item, index) => `
                    <tr>
                        <td>${item.keadaan}</td>
                        <td>${item.kehamilan}</td>
                        <td>${item.caraPersalinan}</td>
                        <td>${item.keadaanNifas}</td>
                        <td>${item.tanggalLahir || '-'}</td>
                        <td>${item.keadaanAnak}</td>
                        <td>${item.tempatPenolong}</td>
                        <td>
                            <button class="btn btn-sm btn-link delete-obstetrik" data-index="${index}">
                                <i class="fas fa-times text-danger"></i>
                            </button>
                        </td>
                    </tr>
                `).join('');
                }

                // Update input hidden
                document.getElementById('obstetrikInput').value = JSON.stringify(riwayatObstetrik);
            }

            function updateObstetrikList() {
                if (riwayatObstetrik.length === 0) {
                    listObstetrik.innerHTML = '<small class="text-muted">Tidak ada riwayat</small>';
                } else {
                    listObstetrik.innerHTML = riwayatObstetrik.map((item, index) => `
                    <div class="border-bottom pb-2 mb-2">
                        <strong>Kehamilan ${item.kehamilan}</strong> - ${item.caraPersalinan}<br>
                        <small>Tanggal: ${item.tanggalLahir || 'Tidak ada'} | Anak: ${item.keadaanAnak}</small>
                    </div>
                `).join('');
                }
            }

            // Open modal
            document.getElementById('openObstetrikModal').addEventListener('click', function() {
                updateObstetrikList();
                obstetrikModal.show();
            });

            // Add obstetrik - Improved validation
            document.getElementById('btnAddObstetrik').addEventListener('click', function() {
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

                // Semua field sudah diisi, tambah ke array
                riwayatObstetrik.push({
                    keadaan: keadaan,
                    kehamilan: kehamilan,
                    caraPersalinan: caraPersalinan,
                    keadaanNifas: keadaanNifas,
                    tanggalLahir: tanggalLahir,
                    keadaanAnak: keadaanAnak,
                    tempatPenolong: tempatPenolong
                });

                // Clear inputs
                document.getElementById('keadaanInput').value = '';
                document.getElementById('kehamilanInput').value = '';
                document.getElementById('caraPersalinanInput').value = '';
                document.getElementById('keadaanNifasInput').value = '';
                document.getElementById('tanggalLahirInput').value = '';
                document.getElementById('keadaanAnakInput').value = '';
                document.getElementById('tempatPenolongInput').value = '';

                updateObstetrikList();

                // Show success message
                alert('Data riwayat obstetrik berhasil ditambahkan!');
            });

            // Save obstetrik
            document.getElementById('btnSaveObstetrik').addEventListener('click', function() {
                updateObstetrikTable();
                obstetrikModal.hide();
            });

            // Delete obstetrik (event delegation)
            obstetrikTable.addEventListener('click', function(e) {
                if (e.target.closest('.delete-obstetrik')) {
                    const index = e.target.closest('.delete-obstetrik').getAttribute('data-index');
                    if (confirm('Apakah Anda yakin ingin menghapus riwayat obstetrik ini?')) {
                        riwayatObstetrik.splice(index, 1);
                        updateObstetrikTable();
                    }
                }
            });

            // Initialize
            updateObstetrikTable();
        });
    </script>
@endpush
