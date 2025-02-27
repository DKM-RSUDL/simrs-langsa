<!-- Pastikan struktur modal ini sudah tersedia di halaman Anda -->
<div class="modal fade" id="downScoreModal" tabindex="-1" aria-labelledby="downScoreModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="downScoreModalLabel">DOWN SCORE PADA DADA DAN PARU-PARU</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <p>nilai akhir < 3: tidak gawat nafas, 3-6 : gawat nafas, > 6 : gawat nafas mengancam</p>
                </div>
                
                <div class="mb-4">
                    <h6 class="fw-bold">1. FREKUENSI NAFAS</h6>
                    <div class="ps-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input down-score-check" type="checkbox" value="0" name="frekuensi_nafas" id="frekuensi1">
                            <label class="form-check-label" for="frekuensi1">< 60 x/ menit</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input down-score-check" type="checkbox" value="1" name="frekuensi_nafas" id="frekuensi2">
                            <label class="form-check-label" for="frekuensi2">60-80 x/ menit</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input down-score-check" type="checkbox" value="2" name="frekuensi_nafas" id="frekuensi3">
                            <label class="form-check-label" for="frekuensi3">> 80 x/menit</label>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="fw-bold">2. RETRAKSI</h6>
                    <div class="ps-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input down-score-check" type="checkbox" value="0" name="retraksi" id="retraksi1">
                            <label class="form-check-label" for="retraksi1">Tidak ada</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input down-score-check" type="checkbox" value="1" name="retraksi" id="retraksi2">
                            <label class="form-check-label" for="retraksi2">Retraksi ringan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input down-score-check" type="checkbox" value="2" name="retraksi" id="retraksi3">
                            <label class="form-check-label" for="retraksi3">Retraksi berat</label>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="fw-bold">3. SIANOSIS</h6>
                    <div class="ps-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input down-score-check" type="checkbox" value="0" name="sianosis" id="sianosis1">
                            <label class="form-check-label" for="sianosis1">Tidak ada</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input down-score-check" type="checkbox" value="1" name="sianosis" id="sianosis2">
                            <label class="form-check-label" for="sianosis2">Hilang dengan O2</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input down-score-check" type="checkbox" value="2" name="sianosis" id="sianosis3">
                            <label class="form-check-label" for="sianosis3">Menetap dengan O2</label>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="fw-bold">4. AIRWAY/ UDARA MASUK</h6>
                    <div class="ps-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input down-score-check" type="checkbox" value="0" name="airway" id="airway1">
                            <label class="form-check-label" for="airway1">Ada</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input down-score-check" type="checkbox" value="1" name="airway" id="airway2">
                            <label class="form-check-label" for="airway2">Menurun</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input down-score-check" type="checkbox" value="2" name="airway" id="airway3">
                            <label class="form-check-label" for="airway3">Tidak terdengar</label>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="fw-bold">5. MERINTIH</h6>
                    <div class="ps-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input down-score-check" type="checkbox" value="0" name="merintih" id="merintih1">
                            <label class="form-check-label" for="merintih1">Tidak ada</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input down-score-check" type="checkbox" value="1" name="merintih" id="merintih2">
                            <label class="form-check-label" for="merintih2">Terdengar dgn stetoskop</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input down-score-check" type="checkbox" value="2" name="merintih" id="merintih3">
                            <label class="form-check-label" for="merintih3">Terdengar tanpa alat bantu</label>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <div>
                        <label class="fw-bold">JUMLAH SKALA:</label>
                        <input type="text" class="form-control" id="totalScore" readonly>
                    </div>
                    <div>
                        <label class="fw-bold">KESIMPULAN:</label>
                        <div id="kesimpulanBox" class="form-control bg-success text-white">TIDAK GAWAT NAFAS</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanScore">Simpan</button>
            </div>
        </div>
    </div>
</div>