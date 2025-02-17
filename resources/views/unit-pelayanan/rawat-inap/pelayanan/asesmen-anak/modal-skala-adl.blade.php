<!-- Modal CRIES -->
<div class="modal fade" id="" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">PENGKAJIAN AKTIVITAS HARIAN (ADL)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-4">Informasi: (Nilai dari Pengkajian terdiri dari 0,1,2 dan 3)</p>

                <!-- 1. MAKAN -->
                <div class="mb-4">
                    <h6 class="mb-3">1. MAKAN / MEMAKAI BAJU</h6>
                    <div class="ms-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="makan[]" value="1" data-category="makan" id="adl_makan1">
                            <label class="form-check-label" for="adl_makan1">Mandiri</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="makan[]" value="2" data-category="makan" id="adl_makan2">
                            <label class="form-check-label" for="adl_makan2">25% Dibantu</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="makan[]" value="3" data-category="makan" id="adl_makan3">
                            <label class="form-check-label" for="adl_makan3">50% Dibantu</label>
                        </div>
                        <div class="from-check">
                            <input class="form-check-input cries-check" type="checkbox" name="makan[]" value="4" data-category="makan" id="adl_makan4">
                            <label class="form-check-label" for="adl_makan4">75% Dibantu</label>
                        </div>
                    </div>
                </div>

                <!-- 2. BERJALAN -->
                <div class="mb-4">
                    <h6 class="mb-3">2. BERJALAN</h6>
                    <div class="ms-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="berjalan[]" value="1" data-category="berjalan" id="adl_berjalan1">
                            <label class="form-check-label" for="adl_berjalan1">Mandiri</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="berjalan[]" value="2" data-category="berjalan" id="adl_berjalan2">
                            <label class="form-check-label" for="adl_berjalan2">25% Dibantu</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="berjalan[]" value="3" data-category="berjalan" id="adl_berjalan3">
                            <label class="form-check-label" for="adl_berjalan3">50% Dibantu</label>
                        </div>
                        <div class="from-check">
                            <input class="form-check-input cries-check" type="checkbox" name="berjalan[]" value="4" data-category="berjalan" id="adl_berjalan4">
                            <label class="form-check-label" for="adl_berjalan4">75% Dibantu</label>
                        </div>
                    </div>
                </div>

                <!-- 3. MANDI -->
                <div class="mb-4">
                    <h6 class="mb-3">3. MANDI / BUANG AIR</h6>
                    <div class="ms-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="mandi[]" value="1" data-category="mandi" id="adl_mandi1">
                            <label class="form-check-label" for="adl_mandi1">Mandiri</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="mandi[]" value="2" data-category="mandi" id="adl_mandi2">
                            <label class="form-check-label" for="adl_mandi2">25% Dibantu</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input cries-check" type="checkbox" name="mandi[]" value="3" data-category="mandi" id="adl_mandi3">
                            <label class="form-check-label" for="adl_mandi3">50% Dibantu</label>
                        </div>
                        <div class="from-check">
                            <input class="form-check-input cries-check" type="checkbox" name="mandi[]" value="4" data-category="mandi" id="adl_mandi4">
                            <label class="form-check-label" for="adl_mandi4">75% Dibantu</label>
                        </div>
                    </div>
                </div>

                <!-- TOTAL & KESIMPULAN -->
                <div class="mt-4">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2">
                                <label class="form-label mb-0">JUMLAH SKALA:</label>
                                <input type="text" class="form-control" id="criesTotal" readonly style="width: 80px;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex align-items-center gap-2">
                                <label class="form-label mb-0">KESIMPULAN:</label>
                                <div id="criesKesimpulan" class="alert alert-info py-1 px-3 mb-0">Pilih semua kategori terlebih dahulu</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="simpanCRIES">Simpan</button>
            </div>
        </div>
    </div>
</div>