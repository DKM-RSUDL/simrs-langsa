<!-- Modal Riwayat Obat -->
<div class="modal fade" id="obatModal" tabindex="-1" aria-labelledby="obatModalLabel" aria-hidden="true"
    style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="obatModalLabel">Tambah Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRiwayatObat">
                    <div class="mb-3">
                        <label class="form-label">Nama Obat</label>
                        <input type="text" class="form-control" id="namaObat" placeholder="Nama obat">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Aturan Pakai</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label small">Frekuensi/interval</label>
                                <select class="form-select" id="frekuensi">
                                    <option value="1 x 1 hari">1 x 1 hari</option>
                                    <option value="2 x 1 hari">2 x 1 hari</option>
                                    <option value="3 x 1 hari" selected>3 x 1 hari</option>
                                    <option value="4 x 1 hari">4 x 1 hari</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Keterangan</label>
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
                            <select class="form-select" id="dosis">
                                <option value="1/4">1/4</option>
                                <option value="1/2" selected>1/2</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="satuan" value="Tablet">
                        </div>
                    </div>
                </form>

                <h6 class="fw-bold mt-4">Daftar Riwayat Obat</h6>
                <ul id="listObat"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnTambahObat">Tambah Obat</button>
                <button type="button" class="btn btn-success" id="btnSaveObat">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var obatModal = new bootstrap.Modal(document.getElementById('obatModal'));
            var obatTable = document.querySelector('#createRiwayatObatTable tbody');
            var listObat = document.getElementById('listObat');
            var riwayatObat = [];

            function updateMainView() {
                if (riwayatObat.length === 0) {
                    obatTable.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center py-3">
                                <div class="text-muted">
                                    <i class="bi bi-exclamation-circle mb-2" style="font-size: 1.5rem;"></i>
                                    <p class="mb-0">Belum ada data riwayat obat</p>
                                </div>
                            </td>
                        </tr>
                    `;
                } else {
                    obatTable.innerHTML = riwayatObat.map((o, index) => `
                        <tr>
                            <td>${o.namaObat}</td>
                            <td>${o.dosis} ${o.satuan}</td>
                            <td>${o.frekuensi} (${o.keterangan})</td>
                            <td>
                                <button class="btn btn-sm btn-link delete-obat" data-index="${index}">
                                    <i class="ti-trash text-danger"></i>
                                </button>
                            </td>
                        </tr>
                    `).join('');
                }
            }

            function updateModalView() {
                if (riwayatObat.length === 0) {
                    listObat.innerHTML = `
                        <div class="text-center text-muted p-3">
                            <i class="bi bi-exclamation-circle mb-2" style="font-size: 1.5rem;"></i>
                            <p class="mb-0">Belum ada data riwayat obat</p>
                        </div>
                    `;
                } else {
                    listObat.innerHTML = riwayatObat.map(o => `
                        <li class="mb-2">
                            <span class="fw-bold">${o.namaObat}</span> -
                            <span class="text-muted">${o.dosis} ${o.satuan}</span>
                            <span class="badge bg-warning">${o.frekuensi} (${o.keterangan})</span>
                        </li>
                    `).join('');
                }
            }

            document.getElementById('openObatModal').addEventListener('click', function() {
                updateModalView();
                obatModal.show();
            });

            document.getElementById('btnTambahObat').addEventListener('click', function() {
                var namaObat = document.getElementById('namaObat').value.trim();
                var frekuensi = document.getElementById('frekuensi').value;
                var keterangan = document.getElementById('keterangan').value;
                var dosis = document.getElementById('dosis').value;
                var satuan = document.getElementById('satuan').value.trim();

                if (namaObat !== '' && satuan !== '') {
                    riwayatObat.push({
                        namaObat: namaObat,
                        frekuensi: frekuensi,
                        keterangan: keterangan,
                        dosis: dosis,
                        satuan: satuan
                    });
                    updateModalView();

                    // Reset form kecuali satuan (default "Tablet")
                    document.getElementById('namaObat').value = '';
                    document.getElementById('frekuensi').value = '3 x 1 hari';
                    document.getElementById('keterangan').value = 'Sesudah Makan';
                    document.getElementById('dosis').value = '1/2';
                } else {
                    alert('Harap isi Nama Obat dan Satuan');
                }
            });

            document.getElementById('btnSaveObat').addEventListener('click', function() {
                updateMainView();
                document.getElementById('riwayatObatData').value = JSON.stringify(riwayatObat);
                obatModal.hide();
            });

            obatTable.addEventListener('click', function(e) {
                if (e.target.closest('.delete-obat')) {
                    var row = e.target.closest('tr');
                    var index = Array.from(row.parentElement.children).indexOf(row);
                    riwayatObat.splice(index, 1);
                    updateMainView();
                }
            });

            riwayatObat = [];
            updateMainView();
        });
    </script>
@endpush
