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
                <button type="button" class="btn btn-primary" onclick="saveGCS()">Simpan</button>
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
});

function openGCSModal() {
    const gcsModal = new bootstrap.Modal(document.getElementById('gcsModal'));
    gcsModal.show();
    
    // Reset semua radio button
    document.querySelectorAll('#gcsModal input[type="radio"]').forEach(radio => {
        radio.checked = false;
    });
    
    // Reset displays
    document.getElementById('eyeValueDisplay').textContent = 'Eye: Belum dipilih';
    document.getElementById('verbalValueDisplay').textContent = 'Verbal: Belum dipilih';
    document.getElementById('motoricValueDisplay').textContent = 'Motor: Belum dipilih';
    document.getElementById('totalGCSDisplay').textContent = '0';
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
</script>{{-- File: gcs-modal.blade.php --}}
<div class="modal fade" id="gcsModal" tabindex="-1" aria-labelledby="gcsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="gcsModalLabel">
                    <i class="ti-calculator me-2"></i>Glasgow Coma Scale (GCS) Calculator
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <small><strong>Petunjuk:</strong> Pilih salah satu opsi dari setiap kategori (Eye, Verbal, Motoric) untuk menghitung nilai GCS total.</small>
                </div>

                {{-- Eye Response --}}
                <div class="gcs-section mb-4">
                    <h6 class="gcs-section-title">
                        <span class="badge bg-primary me-2">E</span>Eye Response (Mata)
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check gcs-option">
                                <input type="radio" class="form-check-input" id="eye_4" name="gcs_eye" value="4" data-text="Spontan">
                                <label class="form-check-label" for="eye_4">
                                    <span class="score-badge">4</span> Spontan
                                </label>
                            </div>
                            <div class="form-check gcs-option">
                                <input type="radio" class="form-check-input" id="eye_3" name="gcs_eye" value="3" data-text="Reaksi thd suara">
                                <label class="form-check-label" for="eye_3">
                                    <span class="score-badge">3</span> Reaksi terhadap suara
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check gcs-option">
                                <input type="radio" class="form-check-input" id="eye_2" name="gcs_eye" value="2" data-text="Reaksi thd tekanan">
                                <label class="form-check-label" for="eye_2">
                                    <span class="score-badge">2</span> Reaksi terhadap tekanan
                                </label>
                            </div>
                            <div class="form-check gcs-option">
                                <input type="radio" class="form-check-input" id="eye_1" name="gcs_eye" value="1" data-text="Tidak terbuka">
                                <label class="form-check-label" for="eye_1">
                                    <span class="score-badge">1</span> Tidak terbuka
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="selected-value mt-2" id="eyeValueDisplay">
                        <i class="ti-eye me-1"></i>Eye: <span class="text-muted">Belum dipilih</span>
                    </div>
                </div>

                {{-- Verbal Response --}}
                <div class="gcs-section mb-4">
                    <h6 class="gcs-section-title">
                        <span class="badge bg-success me-2">V</span>Verbal Response (Suara)
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check gcs-option">
                                <input type="radio" class="form-check-input" id="verbal_5" name="gcs_verbal" value="5" data-text="Normal/berceloteh">
                                <label class="form-check-label" for="verbal_5">
                                    <span class="score-badge">5</span> Normal/berceloteh
                                </label>
                            </div>
                            <div class="form-check gcs-option">
                                <input type="radio" class="form-check-input" id="verbal_4" name="gcs_verbal" value="4" data-text="Bingung/menangis iritasi">
                                <label class="form-check-label" for="verbal_4">
                                    <span class="score-badge">4</span> Bingung/menangis iritasi
                                </label>
                            </div>
                            <div class="form-check gcs-option">
                                <input type="radio" class="form-check-input" id="verbal_3" name="gcs_verbal" value="3" data-text="Erangan/menggerang thd nyeri">
                                <label class="form-check-label" for="verbal_3">
                                    <span class="score-badge">3</span> Erangan/menggerang terhadap nyeri
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check gcs-option">
                                <input type="radio" class="form-check-input" id="verbal_2" name="gcs_verbal" value="2" data-text="Suara tidak jelas">
                                <label class="form-check-label" for="verbal_2">
                                    <span class="score-badge">2</span> Suara tidak jelas
                                </label>
                            </div>
                            <div class="form-check gcs-option">
                                <input type="radio" class="form-check-input" id="verbal_1" name="gcs_verbal" value="1" data-text="Tidak bersuara/merespon suara">
                                <label class="form-check-label" for="verbal_1">
                                    <span class="score-badge">1</span> Tidak bersuara/merespon suara
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="selected-value mt-2" id="verbalValueDisplay">
                        <i class="ti-microphone me-1"></i>Verbal: <span class="text-muted">Belum dipilih</span>
                    </div>
                </div>

                {{-- Motor Response --}}
                <div class="gcs-section mb-4">
                    <h6 class="gcs-section-title">
                        <span class="badge bg-warning me-2">M</span>Motor Response (Gerakan)
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check gcs-option">
                                <input type="radio" class="form-check-input" id="motoric_6" name="gcs_motoric" value="6" data-text="Mematuhi perintah/gerakan spontan">
                                <label class="form-check-label" for="motoric_6">
                                    <span class="score-badge">6</span> Mematuhi perintah/gerakan spontan
                                </label>
                            </div>
                            <div class="form-check gcs-option">
                                <input type="radio" class="form-check-input" id="motoric_5" name="gcs_motoric" value="5" data-text="Melokalisasi nyeri/menghindari sentuhan">
                                <label class="form-check-label" for="motoric_5">
                                    <span class="score-badge">5</span> Melokalisasi nyeri/menghindari sentuhan
                                </label>
                            </div>
                            <div class="form-check gcs-option">
                                <input type="radio" class="form-check-input" id="motoric_4" name="gcs_motoric" value="4" data-text="Fleksi normal">
                                <label class="form-check-label" for="motoric_4">
                                    <span class="score-badge">4</span> Fleksi normal
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check gcs-option">
                                <input type="radio" class="form-check-input" id="motoric_3" name="gcs_motoric" value="3" data-text="Abnormal fleksi">
                                <label class="form-check-label" for="motoric_3">
                                    <span class="score-badge">3</span> Abnormal fleksi
                                </label>
                            </div>
                            <div class="form-check gcs-option">
                                <input type="radio" class="form-check-input" id="motoric_2" name="gcs_motoric" value="2" data-text="Ekstensi thd nyeri">
                                <label class="form-check-label" for="motoric_2">
                                    <span class="score-badge">2</span> Ekstensi terhadap nyeri
                                </label>
                            </div>
                            <div class="form-check gcs-option">
                                <input type="radio" class="form-check-input" id="motoric_1" name="gcs_motoric" value="1" data-text="Tidak ada gerakan">
                                <label class="form-check-label" for="motoric_1">
                                    <span class="score-badge">1</span> Tidak ada gerakan
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="selected-value mt-2" id="motoricValueDisplay">
                        <i class="ti-hand-point-up me-1"></i>Motor: <span class="text-muted">Belum dipilih</span>
                    </div>
                </div>

                {{-- Total Score Display --}}
                <div class="gcs-total-section">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-3">Total Nilai GCS</h5>
                            <div class="gcs-total-display">
                                <span class="gcs-total-number" id="totalGCSDisplay">0</span>
                                <span class="gcs-total-max">/15</span>
                            </div>
                            <div class="gcs-interpretation mt-2" id="gcsInterpretation">
                                <small class="text-muted">Silakan pilih semua kategori</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="ti-close me-1"></i>Batal
                </button>
                <button type="button" class="btn btn-primary" onclick="saveGCS()">
                    <i class="ti-check me-1"></i>Simpan GCS
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* GCS Modal Specific Styles */
.gcs-section {
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
    padding: 1rem;
    background-color: #f8f9fa;
}

.gcs-section-title {
    color: #495057;
    font-weight: 600;
    margin-bottom: 1rem;
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 0.5rem;
}

.gcs-option {
    margin-bottom: 0.75rem;
    padding: 0.5rem;
    border-radius: 0.375rem;
    transition: background-color 0.2s ease;
}

.gcs-option:hover {
    background-color: #e9ecef;
}

.gcs-option .form-check-input:checked + .form-check-label {
    font-weight: 600;
    color: #097dd6;
}

.score-badge {
    display: inline-block;
    background-color: #6c757d;
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    margin-right: 0.5rem;
    min-width: 24px;
    text-align: center;
}

.gcs-option .form-check-input:checked + .form-check-label .score-badge {
    background-color: #097dd6;
}

.selected-value {
    padding: 0.5rem;
    background-color: #fff;
    border-radius: 0.375rem;
    border: 1px dashed #dee2e6;
    font-size: 0.875rem;
}

.gcs-total-section {
    margin-top: 1.5rem;
}

.gcs-total-display {
    font-size: 3rem;
    font-weight: 700;
}

.gcs-total-number {
    color: #097dd6;
}

.gcs-total-max {
    color: #6c757d;
    font-size: 2rem;
}

.gcs-interpretation {
    font-weight: 500;
}

.interpretation-severe { color: #dc3545; }
.interpretation-moderate { color: #fd7e14; }
.interpretation-mild { color: #ffc107; }
.interpretation-normal { color: #28a745; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initGCSModal();
});

function initGCSModal() {
    // No event listeners needed since inputs are disabled
}

function openGCSModal() {
    const gcsModal = new bootstrap.Modal(document.getElementById('gcsModal'));
    gcsModal.show();
    
    // Reset displays
    resetGCSDisplay();

    // Get GCS data from input
    const gcsInput = document.getElementById('gcsInput').value;
    if (gcsInput) {
        // Parse GCS value (e.g., "15 E4 V5 M6")
        const gcsParts = gcsInput.match(/(\d+)\s*E(\d)\s*V(\d)\s*M(\d)/);
        if (gcsParts) {
            const [, total, eye, verbal, motoric] = gcsParts;

            // Set radio buttons
            const eyeRadio = document.querySelector(`input[name="gcs_eye"][value="${eye}"]`);
            const verbalRadio = document.querySelector(`input[name="gcs_verbal"][value="${verbal}"]`);
            const motoricRadio = document.querySelector(`input[name="gcs_motoric"][value="${motoric}"]`);

            if (eyeRadio) eyeRadio.checked = true;
            if (verbalRadio) verbalRadio.checked = true;
            if (motoricRadio) motoricRadio.checked = true;

            // Update displays
            updateGCSDisplay();
        }
    }
}

function resetGCSDisplay() {
    document.getElementById('eyeValueDisplay').innerHTML = 
        '<i class="ti-eye me-1"></i>Eye: <span class="text-muted">Belum dipilih</span>';
    document.getElementById('verbalValueDisplay').innerHTML = 
        '<i class="ti-microphone me-1"></i>Verbal: <span class="text-muted">Belum dipilih</span>';
    document.getElementById('motoricValueDisplay').innerHTML = 
        '<i class="ti-hand-point-up me-1"></i>Motor: <span class="text-muted">Belum dipilih</span>';
    document.getElementById('totalGCSDisplay').textContent = '0';
    document.getElementById('gcsInterpretation').innerHTML = 
        '<small class="text-muted">Data GCS tidak lengkap</small>';
}

function updateGCSDisplay() {
    const eye = document.querySelector('input[name="gcs_eye"]:checked');
    const verbal = document.querySelector('input[name="gcs_verbal"]:checked');
    const motoric = document.querySelector('input[name="gcs_motoric"]:checked');

    // Update individual displays
    if (eye) {
        document.getElementById('eyeValueDisplay').innerHTML = 
            `<i class="ti-eye me-1"></i>Eye: ${eye.getAttribute('data-text')} <span class="badge bg-primary">${eye.value}</span>`;
    }

    if (verbal) {
        document.getElementById('verbalValueDisplay').innerHTML = 
            `<i class="ti-microphone me-1"></i>Verbal: ${verbal.getAttribute('data-text')} <span class="badge bg-success">${verbal.value}</span>`;
    }

    if (motoric) {
        document.getElementById('motoricValueDisplay').innerHTML = 
            `<i class="ti-hand-point-up me-1"></i>Motor: ${motoric.getAttribute('data-text')} <span class="badge bg-warning">${motoric.value}</span>`;
    }

    // Calculate and display total
    const totalGCS = (eye ? parseInt(eye.value) : 0) + 
                    (verbal ? parseInt(verbal.value) : 0) + 
                    (motoric ? parseInt(motoric.value) : 0);
    
    document.getElementById('totalGCSDisplay').textContent = totalGCS;
    updateGCSInterpretation(totalGCS, eye, verbal, motoric);
}

function updateGCSInterpretation(total, eye, verbal, motoric) {
    const interpretationElement = document.getElementById('gcsInterpretation');
    
    if (!eye || !verbal || !motoric) {
        interpretationElement.innerHTML = '<small class="text-muted">Data GCS tidak lengkap</small>';
        return;
    }

    let interpretation = '';
    let className = '';

    if (total >= 13) {
        interpretation = 'Cedera Kepala Ringan';
        className = 'interpretation-mild';
    } else if (total >= 9) {
        interpretation = 'Cedera Kepala Sedang';
        className = 'interpretation-moderate';
    } else if (total >= 3) {
        interpretation = 'Cedera Kepala Berat';
        className = 'interpretation-severe';
    }

    interpretationElement.innerHTML = `<span class="${className}">${interpretation}</span>`;
}
</script>