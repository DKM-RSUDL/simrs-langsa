<!-- Modal NRS -->
<div class="modal fade" id="modalNRS" tabindex="-1" aria-labelledby="modalNRSLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">NYERI SKALA : NUMERIC RATING SCALE (NRS)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-4">Berikan pertanyaan kepada pasien dari skala 0 sd 10, untuk skala 0 (nol) tidak nyeri sampai 10 (sepuluh) nyeri sangat hebat.</p>
                
                <!-- Nilai Nyeri Input -->
                <div class="mb-4">
                    <label class="form-label">NILAI NYERI:</label>
                    <div class="d-flex align-items-center gap-3">
                        <input type="number" class="form-control" id="nrs_value" min="0" max="10" style="width: 30%;">
                        <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}" alt="Skala Nyeri" class="img-fluid" style="max-width: 70%;">
                    </div>
                </div>

                <!-- Kesimpulan Section -->
                <div class="mb-4">
                    <label class="form-label">KESIMPULAN:</label>
                    <div id="nrs_kesimpulan" class="alert alert-info">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-emoji-smile fs-4"></i>
                            <span>Pilih nilai nyeri terlebih dahulu</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="simpanNRS">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal FLACC -->
<div class="modal fade" id="modalFLACC" tabindex="-1" aria-labelledby="modalFLACCLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">NYERI SKALA : FACE, LEGS, ACTIVITY, CRY, CONSOLABILITY (FLACC)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add FLACC content here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="simpanFLACC">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal CRIES -->
<div class="modal fade" id="modalCRIES" tabindex="-1" aria-labelledby="modalCRIESLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">NYERI SKALA : CRYING, REQUIRES, INCREASED, EXPRESSION, SLEEPLESS (CRIES)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add CRIES content here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="simpanCRIES">Simpan</button>
            </div>
        </div>
    </div>
</div>