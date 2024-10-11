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
                                <input type="number" class="form-control" id="editJumlahHari">
                            </div>
                            <div class="col-md-6">
                                <label for="editFrekuensi" class="form-label">Frekuensi/interval</label>
                                <select class="form-select" id="editFrekuensi">
                                    <option>3 x 1 hari</option>
                                    <option>2 x 1 hari</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editDosis" class="form-label">Dosis sekali minum</label>
                                <select class="form-select" id="editDosis">
                                    <option>1/2</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="editSatuanObat" class="form-label">Satuan Obat</label>
                                <select class="form-select" id="editSatuanObat">
                                    <option value="tablet">Tablet</option>
                                    <option value="kapsul">Kapsul (caps)</option>
                                    <option value="bungkus">Bungkus (bks)</option>
                                    <option value="sendok_makan">Sendok makan</option>
                                    <option value="sendok_teh">Sendok teh</option>
                                    <option value="tetes">Tetes</option>
                                    <option value="cc">CC</option>
                                    <option value="olesan">Olesan</option>
                                    <option value="taburan">Taburan</option>
                                    <option value="semprotan">Semprotan</option>
                                    <option value="kali">Kali</option>
                                    <option value="ampul">Ampul</option>
                                    <option value="unit">Unit</option>
                                    <option value="sub">Sub</option>
                                    <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editJumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="editJumlah">
                            </div>
                            <div class="col-md-6">
                                <label for="editSebelumSesudahMakan" class="form-label">Keterangan</label>
                                <select class="form-select" id="editSebelumSesudahMakan">
                                    <option selected>Sesudah Makan</option>
                                    <option>Sebelum Makan</option>
                                </select>
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
