<!-- Modal GCS -->
<div class="modal fade" id="gcsModal" tabindex="-1" aria-labelledby="gcsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gcsModalLabel">Glasgow Coma Scale (GCS)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6>E: Eye Opening</h6>
                        <div class="form-check">
                            <input class="form-check-input gcs-checkbox" type="checkbox" name="e_spontan" value="4" data-category="E" data-description="Spontan">
                            <label class="form-check-label">Spontan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input gcs-checkbox" type="checkbox" name="e_reaksi_suara" value="3" data-category="E" data-description="Reaksi thd suara">
                            <label class="form-check-label">Reaksi thd suara</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input gcs-checkbox" type="checkbox" name="e_reaksi_nyeri" value="2" data-category="E" data-description="Reaksi thd nyeri">
                            <label class="form-check-label">Reaksi thd nyeri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input gcs-checkbox" type="checkbox" name="e_tidak_terbuka" value="1" data-category="E" data-description="Tidak terbuka">
                            <label class="form-check-label">Tidak terbuka</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6>V: Verbal</h6>
                        <div class="form-check">
                            <input class="form-check-input gcs-checkbox" type="checkbox" name="v_normal" value="5" data-category="V" data-description="Normal/bicara">
                            <label class="form-check-label">Normal/bicara</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input gcs-checkbox" type="checkbox" name="v_bingung" value="4" data-category="V" data-description="Bingung/mengiritasi">
                            <label class="form-check-label">Bingung/mengiritasi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input gcs-checkbox" type="checkbox" name="v_tidak_tepat" value="3" data-category="V" data-description="Tidak tepat">
                            <label class="form-check-label">Tidak tepat</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input gcs-checkbox" type="checkbox" name="v_tidak_jelas" value="2" data-category="V" data-description="Tidak jelas">
                            <label class="form-check-label">Tidak jelas</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input gcs-checkbox" type="checkbox" name="v_tidak_ada" value="1" data-category="V" data-description="Tidak ada">
                            <label class="form-check-label">Tidak ada</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6>M: Motor</h6>
                        <div class="form-check">
                            <input class="form-check-input gcs-checkbox" type="checkbox" name="m_perintah" value="6" data-category="M" data-description="Memenuhi perintah/gerakan spontan">
                            <label class="form-check-label">Memenuhi perintah/gerakan spontan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input gcs-checkbox" type="checkbox" name="m_lokalisasi" value="5" data-category="M" data-description="Melokalisasi nyeri">
                            <label class="form-check-label">Melokalisasi nyeri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input gcs-checkbox" type="checkbox" name="m_fleksi" value="4" data-category="M" data-description="Fleksi">
                            <label class="form-check-label">Fleksi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input gcs-checkbox" type="checkbox" name="m_abnormal_fleksi" value="3" data-category="M" data-description="Abnormal fleksi">
                            <label class="form-check-label">Abnormal fleksi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input gcs-checkbox" type="checkbox" name="m_ekstensi" value="2" data-category="M" data-description="Ekstensi thd nyeri">
                            <label class="form-check-label">Ekstensi thd nyeri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input gcs-checkbox" type="checkbox" name="m_tidak_ada" value="1" data-category="M" data-description="Tidak ada">
                            <label class="form-check-label">Tidak ada</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-between w-100">
                    <div>
                        <strong>Total GCS: </strong>
                        <span id="total-gcs-display">0</span>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="simpan-gcs">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.gcs-checkbox');
        const totalGcsDisplay = document.getElementById('total-gcs-display');
        const gcsNilaiInput = document.querySelector('input[name="gcs_nilai"]');
        const gcsTotalInput = document.getElementById('gcs_total_input');
        const simpanGcsButton = document.getElementById('simpan-gcs');

        let selectedScores = {
            'E': [],
            'V': [],
            'M': []
        };

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const category = this.dataset.category;
                const value = parseInt(this.value);
                const description = this.dataset.description;

                if (this.checked) {
                    // Tambahkan ke array jika belum ada
                    const existingIndex = selectedScores[category].findIndex(
                        item => item.value === value
                    );

                    if (existingIndex === -1) {
                        selectedScores[category].push({
                            value: value,
                            description: description
                        });
                    }
                } else {
                    // Hapus dari array
                    selectedScores[category] = selectedScores[category].filter(
                        item => item.value !== value
                    );
                }

                // Hitung total dengan mengambil nilai tertinggi dari setiap kategori
                const total = Object.keys(selectedScores).reduce((sum, category) => {
                    const categoryMax = selectedScores[category].length > 0
                        ? Math.max(...selectedScores[category].map(item => item.value))
                        : 0;
                    return sum + categoryMax;
                }, 0);

                totalGcsDisplay.textContent = total || '0';
            });
        });

        simpanGcsButton.addEventListener('click', function() {
            // Validasi semua kategori dipilih
            const allCategoriesSelected = Object.values(selectedScores).every(
                category => category.length > 0
            );

            if (allCategoriesSelected) {
                // Ambil skor tertinggi untuk setiap kategori
                const eMax = Math.max(...selectedScores['E'].map(item => item.value));
                const vMax = Math.max(...selectedScores['V'].map(item => item.value));
                const mMax = Math.max(...selectedScores['M'].map(item => item.value));

                // Ambil deskripsi untuk skor tertinggi
                const eDesc = selectedScores['E'].find(item => item.value === eMax).description;
                const vDesc = selectedScores['V'].find(item => item.value === vMax).description;
                const mDesc = selectedScores['M'].find(item => item.value === mMax).description;

                const total = eMax + vMax + mMax;

                // Konstruksi string deskriptif
                const outputString = `E:${eDesc} (${eMax}), V:${vDesc} (${vMax}), M:${mDesc} (${mMax}) - Total: ${total}`;

                // Set input values
                gcsNilaiInput.value = outputString;
                gcsTotalInput.value = total;

                // Tambahkan detail pilihan untuk referensi
                const detailedSelections = Object.keys(selectedScores).map(category => {
                    const selections = selectedScores[category]
                        .map(item => `${item.description} (${item.value})`)
                        .join(', ');
                    return `${category}: ${selections}`;
                }).join(' | ');

                console.log('Detailed Selections:', detailedSelections);

                // Tutup modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('gcsModal'));
                modal.hide();
            } else {
                // Tampilkan pesan error jika belum semua kategori dipilih
                alert('Harap pilih skor untuk semua kategori (E, V, M)');
            }
        });
    });
    </script>
