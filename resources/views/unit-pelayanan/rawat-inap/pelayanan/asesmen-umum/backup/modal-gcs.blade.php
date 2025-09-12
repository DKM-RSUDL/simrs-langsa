<!-- Pastikan struktur modal ini sudah tersedia di halaman Anda -->
<div class="modal fade" id="gcsModal" tabindex="-1" aria-labelledby="gcsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gcsModalLabel">DOWN SCORE PADA DADA DAN PARU-PARU</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="mb-3">
                    <label>E: Eye</label><br>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="eye_4" name="gcs_eye" value="4" data-text="Spontan">
                        <label class="form-check-label" for="eye_4">Spontan</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="eye_3" name="gcs_eye" value="3" data-text="Reaksi thd suara">
                        <label class="form-check-label" for="eye_3">Reaksi thd suara</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="eye_2" name="gcs_eye" value="2" data-text="Reaksi thd tekanan">
                        <label class="form-check-label" for="eye_2">Reaksi thd tekanan</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="eye_1" name="gcs_eye" value="1" data-text="Tidak terbuka">
                        <label class="form-check-label" for="eye_1">Tidak terbuka</label>
                    </div>
                </div>
                <div id="eyeValueDisplay">Eye: -</div>

                <div class="mb-3 mt-3">
                    <label>V: Verbal</label><br>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="verbal_5" name="gcs_verbal" value="5" data-text="Normal/berceloteh">
                        <label class="form-check-label" for="verbal_5">Normal/berceloteh</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="verbal_4" name="gcs_verbal" value="4" data-text="Bingung/menangis iritasi">
                        <label class="form-check-label" for="verbal_4">Bingung/menangis iritasi</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="verbal_3" name="gcs_verbal" value="3" data-text="Erangan/menggerang thd nyeri">
                        <label class="form-check-label" for="verbal_3">Erangan/menggerang thd nyeri</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="verbal_1" name="gcs_verbal" value="1" data-text="Tidak bersuara/merespon suara">
                        <label class="form-check-label" for="verbal_1">Tidak bersuara/merespon suara</label>
                    </div>
                </div>
                <div id="verbalValueDisplay">Verbal: -</div>

                <div class="mb-3 mt-3">
                    <label>M: Motoric</label><br>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="motoric_6" name="gcs_motoric" value="6" data-text="Mematuhi perintah/gerakan spontan">
                        <label class="form-check-label" for="motoric_6">Mematuhi perintah/gerakan spontan</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="motoric_5" name="gcs_motoric" value="5" data-text="Melokalisasi nyeri/menghindari sentuhan">
                        <label class="form-check-label" for="motoric_5">Melokalisasi nyeri/menghindari sentuhan</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="motoric_4" name="gcs_motoric" value="4" data-text="Fleksi">
                        <label class="form-check-label" for="motoric_4">Fleksi</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="motoric_3" name="gcs_motoric" value="3" data-text="Abnormal fleksi">
                        <label class="form-check-label" for="motoric_3">Abnormal fleksi</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="motoric_2" name="gcs_motoric" value="2" data-text="Ekstensi thd nyeri">
                        <label class="form-check-label" for="motoric_2">Ekstensi thd nyeri</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="motoric_1" name="gcs_motoric" value="1" data-text="Tidak ada gerakan">
                        <label class="form-check-label" for="motoric_1">Tidak ada gerakan</label>
                    </div>
                </div>
                <div id="motoricValueDisplay">Motoric: -</div>

                <div class="mt-3">
                    <strong>Nilai GCS: <span id="totalGCSDisplay">0</span></strong>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanScore">Simpan</button>
            </div>
        </div>
    </div>
</div>