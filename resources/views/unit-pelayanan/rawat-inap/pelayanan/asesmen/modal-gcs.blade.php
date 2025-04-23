<div class="modal fade" id="gcsModal" tabindex="-1" aria-labelledby="gcsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gcsModalLabel">Glasgow Coma Scale (GCS)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>E: Eye</label><br>
                    <input type="radio" name="gcs_eye" value="4" data-text="Spontan"> Spontan<br>
                    <input type="radio" name="gcs_eye" value="3" data-text="Reaksi thd suara"> Reaksi thd
                    suara<br>
                    <input type="radio" name="gcs_eye" value="2" data-text="Reaksi thd tekanan"> Reaksi thd
                    tekanan<br>
                    <input type="radio" name="gcs_eye" value="1" data-text="Tidak terbuka"> Tidak terbuka<br>
                </div>
                <div id="eyeValueDisplay">Eye: -</div>

                <div class="mb-3 mt-3">
                    <label>V: Verbal</label><br>
                    <input type="radio" name="gcs_verbal" value="5" data-text="Normal/berceloteh">
                    Normal/berceloteh<br>
                    <input type="radio" name="gcs_verbal" value="4" data-text="Bingung/menangis iritasi">
                    Bingung/menangis iritasi<br>
                    <input type="radio" name="gcs_verbal" value="3" data-text="Erangan/menggerang thd nyeri">
                    Erangan/menggerang thd nyeri<br>
                    <input type="radio" name="gcs_verbal" value="1" data-text="Tidak bersuara/merespon suara">
                    Tidak bersuara/merespon suara<br>
                </div>
                <div id="verbalValueDisplay">Verbal: -</div>

                <div class="mb-3 mt-3">
                    <label>M: Motoric</label><br>
                    <input type="radio" name="gcs_motoric" value="6"
                        data-text="Mematuhi perintah/gerakan spontan"> Mematuhi perintah/gerakan spontan<br>
                    <input type="radio" name="gcs_motoric" value="5"
                        data-text="Melokalisasi nyeri/menghindari sentuhan"> Melokalisasi nyeri/menghindari sentuhan<br>
                    <input type="radio" name="gcs_motoric" value="4" data-text="Fleksi"> Fleksi<br>
                    <input type="radio" name="gcs_motoric" value="3" data-text="Abnormal fleksi"> Abnormal
                    fleksi<br>
                    <input type="radio" name="gcs_motoric" value="2" data-text="Ekstensi thd nyeri"> Ekstensi thd
                    nyeri<br>
                    <input type="radio" name="gcs_motoric" value="1" data-text="Tidak ada gerakan"> Tidak ada
                    gerakan<br>
                </div>
                <div id="motoricValueDisplay">Motoric: -</div>

                <div class="mt-3">
                    <strong>Nilai GCS: <span id="totalGCSDisplay">-</span></strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveGCS()">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        function openGCSModal() {
            const gcsModal = new bootstrap.Modal(document.getElementById('gcsModal'));
            gcsModal.show();
        }

        // Fungsi untuk memperbarui tampilan GCS berdasarkan pilihan
        function updateGCSDisplay() {
            const eye = document.querySelector('input[name="gcs_eye"]:checked');
            const verbal = document.querySelector('input[name="gcs_verbal"]:checked');
            const motoric = document.querySelector('input[name="gcs_motoric"]:checked');

            if (eye) {
                document.getElementById('eyeValueDisplay').textContent =
                    `Eye: ${eye.getAttribute('data-text')} (${eye.value})`;
            }

            if (verbal) {
                document.getElementById('verbalValueDisplay').textContent =
                    `Verbal: ${verbal.getAttribute('data-text')} (${verbal.value})`;
            }

            if (motoric) {
                document.getElementById('motoricValueDisplay').textContent =
                    `Motoric: ${motoric.getAttribute('data-text')} (${motoric.value})`;
            }

            const totalGCS = (eye ? parseInt(eye.value) : 0) + (verbal ? parseInt(verbal.value) : 0) + (motoric ? parseInt(
                motoric.value) : 0);
            document.getElementById('totalGCSDisplay').textContent = totalGCS;
        }

        // Event listener untuk setiap input radio pada kategori GCS
        document.querySelectorAll('input[name="gcs_eye"], input[name="gcs_verbal"], input[name="gcs_motoric"]').forEach(
            input => {
                input.addEventListener('change', updateGCSDisplay);
            });

        function saveGCS() {

            const eye = document.querySelector('input[name="gcs_eye"]:checked');
            const verbal = document.querySelector('input[name="gcs_verbal"]:checked');
            const motoric = document.querySelector('input[name="gcs_motoric"]:checked');

            if (eye && verbal && motoric) {
                const totalGCS = parseInt(eye.value) + parseInt(verbal.value) + parseInt(motoric.value);

                // Pastikan elemen dengan ID gcsValue dan gcsScoreDisplay ada sebelum mengatur nilainya
                const gcsValueElement = document.getElementById('gcsValue');
                const gcsScoreDisplayElement = document.getElementById('gcsScoreDisplay');

                if (gcsValueElement) {
                    gcsValueElement.value = totalGCS;
                }

                if (gcsScoreDisplayElement) {
                    gcsScoreDisplayElement.value = totalGCS;
                }

                // Simpan objek GCS dalam format JSON yang diinginkan
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

                // Mendapatkan modal Bootstrap yang sedang terbuka dan menutupnya jika ada
                const gcsModal = bootstrap.Modal.getInstance(document.getElementById('gcsModal'));
                if (gcsModal) {
                    gcsModal.hide();
                }
            } else {
                alert("Harap pilih semua kategori untuk menghitung nilai GCS.");
            }
        }
    </script>
@endpush
