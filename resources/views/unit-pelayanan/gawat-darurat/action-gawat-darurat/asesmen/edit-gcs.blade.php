<div class="modal fade" id="edit_gcsModal" tabindex="-1" aria-labelledby="gcsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gcsModalLabel">Glasgow Coma Scale (GCS) - Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>E: Eye</label><br>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="edit_eye_4" name="edit_gcs_eye" value="4" data-text="Spontan">
                        <label class="form-check-label" for="edit_eye_4">Spontan</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="edit_eye_3" name="edit_gcs_eye" value="3" data-text="Reaksi thd suara">
                        <label class="form-check-label" for="edit_eye_3">Reaksi thd suara</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="edit_eye_2" name="edit_gcs_eye" value="2" data-text="Reaksi thd tekanan">
                        <label class="form-check-label" for="edit_eye_2">Reaksi thd tekanan</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="edit_eye_1" name="edit_gcs_eye" value="1" data-text="Tidak terbuka">
                        <label class="form-check-label" for="edit_eye_1">Tidak terbuka</label>
                    </div>
                </div>
                <div id="edit_eyeValueDisplay">Eye: -</div>

                <div class="mb-3 mt-3">
                    <label>V: Verbal</label><br>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="edit_verbal_5" name="edit_gcs_verbal" value="5" data-text="Normal/berceloteh">
                        <label class="form-check-label" for="edit_verbal_5">Normal/berceloteh</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="edit_verbal_4" name="edit_gcs_verbal" value="4" data-text="Bingung/menangis iritasi">
                        <label class="form-check-label" for="edit_verbal_4">Bingung/menangis iritasi</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="edit_verbal_3" name="edit_gcs_verbal" value="3" data-text="Erangan/menggerang thd nyeri">
                        <label class="form-check-label" for="edit_verbal_3">Erangan/menggerang thd nyeri</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="edit_verbal_1" name="edit_gcs_verbal" value="1" data-text="Tidak bersuara/merespon suara">
                        <label class="form-check-label" for="edit_verbal_1">Tidak bersuara/merespon suara</label>
                    </div>
                </div>
                <div id="edit_verbalValueDisplay">Verbal: -</div>

                <div class="mb-3 mt-3">
                    <label>M: Motoric</label><br>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="edit_motoric_6" name="edit_gcs_motoric" value="6" data-text="Mematuhi perintah/gerakan spontan">
                        <label class="form-check-label" for="edit_motoric_6">Mematuhi perintah/gerakan spontan</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="edit_motoric_5" name="edit_gcs_motoric" value="5" data-text="Melokalisasi nyeri/menghindari sentuhan">
                        <label class="form-check-label" for="edit_motoric_5">Melokalisasi nyeri/menghindari sentuhan</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="edit_motoric_4" name="edit_gcs_motoric" value="4" data-text="Fleksi">
                        <label class="form-check-label" for="edit_motoric_4">Fleksi</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="edit_motoric_3" name="edit_gcs_motoric" value="3" data-text="Abnormal fleksi">
                        <label class="form-check-label" for="edit_motoric_3">Abnormal fleksi</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="edit_motoric_2" name="edit_gcs_motoric" value="2" data-text="Ekstensi thd nyeri">
                        <label class="form-check-label" for="edit_motoric_2">Ekstensi thd nyeri</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="edit_motoric_1" name="edit_gcs_motoric" value="1" data-text="Tidak ada gerakan">
                        <label class="form-check-label" for="edit_motoric_1">Tidak ada gerakan</label>
                    </div>
                </div>
                <div id="edit_motoricValueDisplay">Motoric: -</div>

                <div class="mt-3">
                    <strong>Nilai GCS: <span id="edit_totalGCSDisplay">0</span></strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveEditGCS()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openEditGCSModal() {
        const gcsModal = new bootstrap.Modal(document.getElementById('edit_gcsModal'));
        gcsModal.show();

        // Ambil nilai GCS yang sudah ada
        const gcsValueInput = document.getElementById('edit_gcsValue');
        const existingGCSData = window.gcsData;

        if (existingGCSData) {
            // Set nilai Eye
            const eyeRadio = document.querySelector(`input[name="edit_gcs_eye"][value="${existingGCSData.eye.value}"]`);
            if (eyeRadio) {
                eyeRadio.checked = true;
                document.getElementById('edit_eyeValueDisplay').textContent = 
                    `Eye: ${eyeRadio.getAttribute('data-text')} (${eyeRadio.value})`;
            }

            // Set nilai Verbal
            const verbalRadio = document.querySelector(`input[name="edit_gcs_verbal"][value="${existingGCSData.verbal.value}"]`);
            if (verbalRadio) {
                verbalRadio.checked = true;
                document.getElementById('edit_verbalValueDisplay').textContent = 
                    `Verbal: ${verbalRadio.getAttribute('data-text')} (${verbalRadio.value})`;
            }

            // Set nilai Motoric
            const motoricRadio = document.querySelector(`input[name="edit_gcs_motoric"][value="${existingGCSData.motoric.value}"]`);
            if (motoricRadio) {
                motoricRadio.checked = true;
                document.getElementById('edit_motoricValueDisplay').textContent = 
                    `Motoric: ${motoricRadio.getAttribute('data-text')} (${motoricRadio.value})`;
            }

            // Update total GCS display
            document.getElementById('edit_totalGCSDisplay').textContent = existingGCSData.total;
        }
    }

    function updateEditGCSDisplay() {
        const eye = document.querySelector('input[name="edit_gcs_eye"]:checked');
        const verbal = document.querySelector('input[name="edit_gcs_verbal"]:checked');
        const motoric = document.querySelector('input[name="edit_gcs_motoric"]:checked');

        if (eye) {
            document.getElementById('edit_eyeValueDisplay').textContent = 
                `Eye: ${eye.getAttribute('data-text')} (${eye.value})`;
        }

        if (verbal) {
            document.getElementById('edit_verbalValueDisplay').textContent = 
                `Verbal: ${verbal.getAttribute('data-text')} (${verbal.value})`;
        }

        if (motoric) {
            document.getElementById('edit_motoricValueDisplay').textContent = 
                `Motoric: ${motoric.getAttribute('data-text')} (${motoric.value})`;
        }

        const totalGCS = (eye ? parseInt(eye.value) : 0) + 
                        (verbal ? parseInt(verbal.value) : 0) + 
                        (motoric ? parseInt(motoric.value) : 0);
        document.getElementById('edit_totalGCSDisplay').textContent = totalGCS;
    }

    document.querySelectorAll('input[name="edit_gcs_eye"], input[name="edit_gcs_verbal"], input[name="edit_gcs_motoric"]')
        .forEach(input => {
            input.addEventListener('change', updateEditGCSDisplay);
        });

    function saveEditGCS() {
        const eye = document.querySelector('input[name="edit_gcs_eye"]:checked');
        const verbal = document.querySelector('input[name="edit_gcs_verbal"]:checked');
        const motoric = document.querySelector('input[name="edit_gcs_motoric"]:checked');

        if (eye && verbal && motoric) {
            const totalGCS = parseInt(eye.value) + parseInt(verbal.value) + parseInt(motoric.value);

            const gcsValueInput = document.getElementById('edit_gcsValue');
            if (gcsValueInput) {
                gcsValueInput.value = totalGCS;
            }

            window.gcsData = {
                eye: {
                    value: parseInt(eye.value),
                    description: eye.getAttribute('data-text')
                },
                verbal: {
                    value: parseInt(verbal.value),
                    description: verbal.getAttribute('data-text')
                },
                motoric: {
                    value: parseInt(motoric.value),
                    description: motoric.getAttribute('data-text')
                },
                total: totalGCS
            };

            const gcsModal = bootstrap.Modal.getInstance(document.getElementById('edit_gcsModal'));
            if (gcsModal) {
                gcsModal.hide();
            }
        } else {
            alert("Harap pilih semua kategori untuk menghitung nilai GCS.");
        }
    }
</script>