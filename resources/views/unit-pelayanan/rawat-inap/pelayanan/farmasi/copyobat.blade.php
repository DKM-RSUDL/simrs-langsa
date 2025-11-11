<button type="button" class="btn btn-success btn-sm copy-obat" data-obat='@json($resep)'>Copy Obat</button>

<div class="modal fade" id="editObatModal" tabindex="-1" aria-labelledby="editObatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editObatModalLabel">Copy Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editObatForm">
                    <div class="mb-3">
                        <label for="editNamaObat" class="form-label">Nama Obat</label>
                        <input type="text" class="form-control" id="editNamaObat" readonly>
                    </div>
                    <div class="form-group border p-3">
                        <h5>Aturan Pakai</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editJumlahHari" class="form-label">Jumlah hari</label>
                                <input type="text" class="form-control" id="editJumlahHari">
                            </div>
                            <div class="col-md-6">
                                <label for="editFrekuensi" class="form-label">Frekuensi/interval</label>
                                <input type="text" class="form-control" id="editFrekuensi">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editDosis" class="form-label">Dosis sekali minum</label>
                                <input type="text" class="form-control" id="editDosis">
                            </div>
                            <div class="col-md-6">
                                <label for="editSatuanObat" class="form-label">Satuan Obat</label>
                                <input type="text" class="form-control" id="editSatuanObat">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editJumlah" class="form-label">Jumlah</label>
                                <input type="text" class="form-control" id="editJumlah">
                            </div>
                            <div class="col-md-6">
                                <label for="editSebelumSesudahMakan" class="form-label">Keterangan</label>
                                <input type="text" class="form-control" id="editSebelumSesudahMakan">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editKeterangan" class="form-label">Aturan tambahan</label>
                            <textarea class="form-control" id="editKeterangan"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveEditObat">Copy Obat</button>
            </div>
        </div>
    </div>
</div>
