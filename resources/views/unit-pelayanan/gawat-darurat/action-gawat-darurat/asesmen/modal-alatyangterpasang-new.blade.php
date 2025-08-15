<!-- Modal Tambah/Edit Alat -->
<div class="modal fade" id="alatModal" tabindex="-1" aria-labelledby="alatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alatModalLabel">Tambah Alat yang Terpasang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="alatForm">
                    <input type="hidden" id="editAlatIndex" value="-1">
                    
                    <div class="form-group mb-3">
                        <label for="namaAlat" class="form-label required">Alat yang Terpasang</label>
                        <select class="form-select" id="namaAlat" required>
                            <option value="">--Pilih Alat--</option>
                            <option value="IV Line">IV Line</option>
                            <option value="Kateter">Kateter</option>
                            <option value="CVC">CVC</option>
                            <option value="NGT">NGT</option>
                            <option value="Ventilator">Ventilator</option>
                            <option value="Monitor">Monitor</option>
                            <option value="Oksigen">Oksigen</option>
                            <option value="Infus Pump">Infus Pump</option>
                            <option value="Syringe Pump">Syringe Pump</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group mb-3" id="alatLainnyaGroup" style="display: none;">
                        <label for="alatLainnya" class="form-label">Nama Alat Lainnya</label>
                        <input type="text" class="form-control" id="alatLainnya" placeholder="Masukkan nama alat">
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="lokasiAlat" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="lokasiAlat" placeholder="Contoh: Tangan kanan, Hidung, dll">
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="keteranganAlat" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keteranganAlat" rows="2" placeholder="Keterangan tambahan (opsional)"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanAlat">
                    <i class="ti-check"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>