{{-- File: gcs-modal.blade.php --}}
<div class="modal fade" id="gcsModal" tabindex="-1" aria-labelledby="gcsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gcsModalLabel">Glasgow Coma Scale (GCS)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Eye Response --}}
                <div class="mb-3">
                    <label><strong>E: Eye Response</strong></label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="eye_4" name="gcs_eye" value="4" data-text="Spontan" disabled>
                        <label class="form-check-label" for="eye_4">4 - Spontan</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="eye_3" name="gcs_eye" value="3" data-text="Reaksi thd suara" disabled>
                        <label class="form-check-label" for="eye_3">3 - Reaksi terhadap suara</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="eye_2" name="gcs_eye" value="2" data-text="Reaksi thd tekanan" disabled>
                        <label class="form-check-label" for="eye_2">2 - Reaksi terhadap tekanan</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="eye_1" name="gcs_eye" value="1" data-text="Tidak terbuka" disabled>
                        <label class="form-check-label" for="eye_1">1 - Tidak terbuka</label>
                    </div>
                    <div class="mt-2">
                        <small id="eyeValueDisplay" class="text-muted">Eye: Belum dipilih</small>
                    </div>
                </div>

                {{-- Verbal Response --}}
                <div class="mb-3">
                    <label><strong>V: Verbal Response</strong></label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="verbal_5" name="gcs_verbal" value="5" data-text="Normal/berceloteh" disabled>
                        <label class="form-check-label" for="verbal_5">5 - Normal/berceloteh</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="verbal_4" name="gcs_verbal" value="4" data-text="Bingung/menangis iritasi" disabled>
                        <label class="form-check-label" for="verbal_4">4 - Bingung/menangis iritasi</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="verbal_3" name="gcs_verbal" value="3" data-text="Erangan/menggerang thd nyeri" disabled>
                        <label class="form-check-label" for="verbal_3">3 - Erangan/menggerang terhadap nyeri</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="verbal_2" name="gcs_verbal" value="2" data-text="Suara tidak jelas" disabled>
                        <label class="form-check-label" for="verbal_2">2 - Suara tidak jelas</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="verbal_1" name="gcs_verbal" value="1" data-text="Tidak bersuara/merespon suara" disabled>
                        <label class="form-check-label" for="verbal_1">1 - Tidak bersuara/merespon suara</label>
                    </div>
                    <div class="mt-2">
                        <small id="verbalValueDisplay" class="text-muted">Verbal: Belum dipilih</small>
                    </div>
                </div>

                {{-- Motor Response --}}
                <div class="mb-3">
                    <label><strong>M: Motor Response</strong></label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="motoric_6" name="gcs_motoric" value="6" data-text="Mematuhi perintah/gerakan spontan" disabled>
                        <label class="form-check-label" for="motoric_6">6 - Mematuhi perintah/gerakan spontan</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="motoric_5" name="gcs_motoric" value="5" data-text="Melokalisasi nyeri/menghindari sentuhan" disabled>
                        <label class="form-check-label" for="motoric_5">5 - Melokalisasi nyeri/menghindari sentuhan</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="motoric_4" name="gcs_motoric" value="4" data-text="Fleksi normal" disabled>
                        <label class="form-check-label" for="motoric_4">4 - Fleksi normal</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="motoric_3" name="gcs_motoric" value="3" data-text="Abnormal fleksi" disabled>
                        <label class="form-check-label" for="motoric_3">3 - Abnormal fleksi</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="motoric_2" name="gcs_motoric" value="2" data-text="Ekstensi thd nyeri" disabled>
                        <label class="form-check-label" for="motoric_2">2 - Ekstensi terhadap nyeri</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="motoric_1" name="gcs_motoric" value="1" data-text="Tidak ada gerakan" disabled>
                        <label class="form-check-label" for="motoric_1">1 - Tidak ada gerakan</label>
                    </div>
                    <div class="mt-2">
                        <small id="motoricValueDisplay" class="text-muted">Motor: Belum dipilih</small>
                    </div>
                </div>

                {{-- Total Score --}}
                <div class="alert alert-info text-center">
                    <strong>Total Nilai GCS: <span id="totalGCSDisplay">0</span>/15</strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                {{-- <button type="button" class="btn btn-primary" onclick="saveGCS()">Simpan</button> --}}
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to all GCS radio buttons
    document.querySelectorAll('input[name="gcs_eye"], input[name="gcs_verbal"], input[name="gcs_motoric"]')
        .forEach(input => {
            input.addEventListener('change', updateGCSDisplay);
        });
    
    // Load existing data saat halaman dimuat
    loadExistingGCSData();
});

/**
 * Fungsi untuk memuat data GCS yang sudah ada dari input field
 */
function loadExistingGCSData() {
    const gcsInput = document.getElementById('gcsInput');
    if (gcsInput && gcsInput.value && gcsInput.value.trim()) {
        parseAndSetGCSData(gcsInput.value.trim());
    }
}

/**
 * Parse format GCS "5 E1 V2 M2" dan set ke radio buttons
 */
function parseAndSetGCSData(gcsString) {
    try {
        // Parse format: "5 E1 V2 M2"
        const parts = gcsString.split(' ');
        
        let eyeValue = null;
        let verbalValue = null;
        let motoricValue = null;
        
        parts.forEach(part => {
            if (part.startsWith('E')) {
                eyeValue = part.substring(1);
            } else if (part.startsWith('V')) {
                verbalValue = part.substring(1);
            } else if (part.startsWith('M')) {
                motoricValue = part.substring(1);
            }
        });
        
        // Set radio buttons berdasarkan nilai yang di-parse
        if (eyeValue) {
            const eyeRadio = document.querySelector(`input[name="gcs_eye"][value="${eyeValue}"]`);
            if (eyeRadio) {
                eyeRadio.checked = true;
            }
        }
        
        if (verbalValue) {
            const verbalRadio = document.querySelector(`input[name="gcs_verbal"][value="${verbalValue}"]`);
            if (verbalRadio) {
                verbalRadio.checked = true;
            }
        }
        
        if (motoricValue) {
            const motoricRadio = document.querySelector(`input[name="gcs_motoric"][value="${motoricValue}"]`);
            if (motoricRadio) {
                motoricRadio.checked = true;
            }
        }
        
        // Update display setelah set radio buttons
        updateGCSDisplay();
        
    } catch (error) {
        console.error('Error parsing GCS data:', error);
    }
}

function openGCSModal() {
    const gcsModal = new bootstrap.Modal(document.getElementById('gcsModal'));
    gcsModal.show();
    
    // Cek apakah ada data existing
    const gcsInput = document.getElementById('gcsInput');
    const hasExistingData = gcsInput && gcsInput.value && gcsInput.value.trim();
    
    if (!hasExistingData) {
        // Reset semua radio button jika tidak ada data existing
        document.querySelectorAll('#gcsModal input[type="radio"]').forEach(radio => {
            radio.checked = false;
        });
        
        // Reset displays
        document.getElementById('eyeValueDisplay').textContent = 'Eye: Belum dipilih';
        document.getElementById('verbalValueDisplay').textContent = 'Verbal: Belum dipilih';
        document.getElementById('motoricValueDisplay').textContent = 'Motor: Belum dipilih';
        document.getElementById('totalGCSDisplay').textContent = '0';
    } else {
        // Load data existing jika ada
        parseAndSetGCSData(gcsInput.value.trim());
    }
}

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
            `Motor: ${motoric.getAttribute('data-text')} (${motoric.value})`;
    }

    const totalGCS = (eye ? parseInt(eye.value) : 0) + 
                    (verbal ? parseInt(verbal.value) : 0) + 
                    (motoric ? parseInt(motoric.value) : 0);
    document.getElementById('totalGCSDisplay').textContent = totalGCS;
}

function saveGCS() {
    const eye = document.querySelector('input[name="gcs_eye"]:checked');
    const verbal = document.querySelector('input[name="gcs_verbal"]:checked');
    const motoric = document.querySelector('input[name="gcs_motoric"]:checked');

    if (eye && verbal && motoric) {
        const totalGCS = parseInt(eye.value) + parseInt(verbal.value) + parseInt(motoric.value);
        const gcsFormat = `${totalGCS} E${eye.value} V${verbal.value} M${motoric.value}`;

        // Update input field
        const gcsInput = document.getElementById('gcsInput');
        if (gcsInput) {
            gcsInput.value = gcsFormat;
        }

        // Store GCS data globally if needed
        window.gcsData = {
            eye: { value: parseInt(eye.value), description: eye.getAttribute('data-text') },
            verbal: { value: parseInt(verbal.value), description: verbal.getAttribute('data-text') },
            motoric: { value: parseInt(motoric.value), description: motoric.getAttribute('data-text') },
            total: totalGCS,
            formatted: gcsFormat
        };

        // Close modal
        const gcsModal = bootstrap.Modal.getInstance(document.getElementById('gcsModal'));
        if (gcsModal) {
            gcsModal.hide();
        }
    } else {
        alert("Harap pilih semua kategori untuk menghitung nilai GCS.");
    }
}
</script>