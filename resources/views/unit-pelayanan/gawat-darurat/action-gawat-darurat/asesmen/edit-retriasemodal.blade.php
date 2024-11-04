<button class="btn btn-sm" type="button" id="editOpenReTriaseModal">
    <i class="bi bi-plus-square"></i> Tambah
</button>

<div class="modal fade" id="reTriagePatientEdit" tabindex="-1" aria-labelledby="editReTriagePatientLabel" aria-hidden="true">
    <div class="container-fluid">
        <div class="modal-dialog modal-fullscreen h-auto w-100">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editReTriagePatientLabel">
                        Observarsi Lanjutan/Re-Triase Pasien Gawat Darurat
                    </h5>
                    <button type="button" class="btn-close btn-close-modified" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">

                            <div class="card">
                                <div class="card-body">
                                    <div class="form-line">
                                        <h6>Keluhan/Anamnesis</h6>
                                        <textarea class="form-control mb-2" rows="3" name="edit_anamnesis_retriage"
                                            placeholder="Isikan keluhan dan anamnesis pasien, jika terjadi cidera jelaskan mekanisme cideranya"></textarea>
                                    </div>

                                    <div class="form-line">
                                        <h6>Vital Sign</h6>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label>TD (Sistole)</label>
                                                <input type="number" class="form-control"
                                                    name="td_sistole_retriage_edit">
                                            </div>
                                            <div class="col">
                                                <label>TD (Diastole)</label>
                                                <input type="number" class="form-control"
                                                    name="td_diastole_retriage_edit">
                                            </div>
                                            <div class="col">
                                                <label>Nadi (x/mnt)</label>
                                                <input type="number" class="form-control" name="nadi_retriage_edit">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label>Resp (x/mnt)</label>
                                                <input type="number" class="form-control" name="resp_retriage_edit">
                                            </div>
                                            <div class="col">
                                                <label>Suhu (°C)</label>
                                                <input type="number" class="form-control" name="suhu_retriage_edit">
                                            </div>
                                            <div class="col">
                                                <label>SpO2 (tanpa O2)</label>
                                                <input type="number" class="form-control"
                                                    name="spo2_tanpa_o2_retriage_edit">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label>SpO2 (dengan O2)</label>
                                                <input type="number" class="form-control"
                                                    name="spo2_dengan_o2_retriage_edit">
                                            </div>
                                            <div class="col-4">
                                                <label>GCS</label>
                                                <input type="number" class="form-control" name="gcs_retriage_edit">
                                            </div>
                                            <div class="col-4">
                                                <label>AVPU</label>
                                                <select class="form-select" name="avpu_retriage_edit">
                                                    <option selected disabled>Pilih</option>
                                                    <option>Sadar Baik/Alert : 0</option>
                                                    <option>Berespon dengan kata-kata/Voice: 1</option>
                                                    <option>Hanya berespon jika dirangsang nyeri/pain: 2
                                                    </option>
                                                    <option>Pasien tidak sadar/unresponsive: 3</option>
                                                    <option>Gelisah atau bingung: 4</option>
                                                    <option>Acute Confusional States: 5</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-line">
                                        <h6>Catatan</h6>
                                        <textarea class="form-control mb-2" rows="3" name="catatan_retriage_edit" placeholder="Isikan Catatan"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-9">

                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h4 class="text-white mb-2">Triase Pasien Gawat Darurat (Skala ATS)</h4>
                                    <p class="text-white m-0 p-0 fw-light">Isikan triase pada saat pasien masuk
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div class="row mt-5">
                                        <div class="col-3">

                                            <div class="card mb-3">
                                                <div class="card-header border-bottom">
                                                    <p class="m-0 p-0 fw-bold">Air Way</p>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input false-emergency-check"
                                                            type="checkbox" name="airway[]" value="Bebas"
                                                            id="airway_bebas">
                                                        <label class="form-check-label" for="airway_bebas">
                                                            Bebas
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input emergency-check" type="checkbox"
                                                            name="airway[]" value="Ancaman" id="airway_ancaman">
                                                        <label class="form-check-label" for="airway_ancaman">
                                                            Ancaman
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input resusitasi-check"
                                                            type="checkbox" name="airway[]" value="Sumbatan"
                                                            id="airway_sumbatan">
                                                        <label class="form-check-label" for="airway_sumbatan">
                                                            Sumbatan
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input doa-check" type="checkbox"
                                                            name="airway[]" value="Tidak ada tanda-tanda kehidupan"
                                                            id="airway_mati">
                                                        <label class="form-check-label" for="airway_mati">
                                                            Tidak ada tanda-tanda kehidupan
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-3">

                                            <div class="card mb-3">
                                                <div class="card-header border-bottom">
                                                    <p class="m-0 p-0 fw-bold">Breathing</p>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input false-emergency-check"
                                                            type="checkbox" name="breathing[]" value="Normal"
                                                            id="breathing_normal">
                                                        <label class="form-check-label" for="breathing_normal">
                                                            Normal
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input urgent-check" type="checkbox"
                                                            name="breathing[]" value="Mengi" id="breathing_Mengi">
                                                        <label class="form-check-label" for="breathing_Mengi">
                                                            Mengi
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input emergency-check"
                                                            type="checkbox" name="breathing[]" value="Takipnoe"
                                                            id="breathing_takipnoe">
                                                        <label class="form-check-label" for="breathing_takipnoe">
                                                            Takipnoe
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input emergency-check"
                                                            type="checkbox" name="breathing[]" value="RR > 20 X/mnt"
                                                            id="breathing_rr">
                                                        <label class="form-check-label" for="breathing_rr">
                                                            RR > 20 X/mnt
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input resusitasi-check"
                                                            type="checkbox" name="breathing[]" value="Henti Nafas"
                                                            id="breathing_henti_nafas">
                                                        <label class="form-check-label" for="breathing_henti_nafas">
                                                            Henti Nafas
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input resusitasi-check"
                                                            type="checkbox" name="breathing[]" value="Bradipnoe"
                                                            id="breathing_bradipnoe">
                                                        <label class="form-check-label" for="breathing_bradipnoe">
                                                            Bradipnoe
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-3">

                                            <div class="card mb-3">
                                                <div class="card-header border-bottom">
                                                    <p class="m-0 p-0 fw-bold">Circulation</p>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input false-emergency-check"
                                                            type="checkbox" name="circulation[]" value="Nadi Kuat"
                                                            id="circulation_nadi_kuat">
                                                        <label class="form-check-label" for="circulation_nadi_kuat">
                                                            Nadi Kuat
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input false-emergency-check"
                                                            type="checkbox" name="circulation[]"
                                                            value="Frekuensi Normal"
                                                            id="circulation_frekuensi_normal">
                                                        <label class="form-check-label"
                                                            for="circulation_frekuensi_normal">
                                                            Frekuensi Normal
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input false-emergency-check"
                                                            type="checkbox" name="circulation[]"
                                                            value="TD sistole 90-159 mmHg"
                                                            id="circulation_sistole_90_159">
                                                        <label class="form-check-label"
                                                            for="circulation_sistole_90_159">
                                                            TD sistole 90-159 mmHg
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input urgent-check" type="checkbox"
                                                            name="circulation[]" value="TD sistole >= 160 atau <= 90"
                                                            id="circulation_sistole_160_90">
                                                        <label class="form-check-label"
                                                            for="circulation_sistole_160_90">
                                                            TD sistole >= 160 atau <= 90 </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input emergency-check"
                                                            type="checkbox" name="circulation[]" value="Nadi Lemah"
                                                            id="circulation_nadi_lemah">
                                                        <label class="form-check-label" for="circulation_nadi_lemah">
                                                            Nadi Lemah
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input emergency-check"
                                                            type="checkbox" name="circulation[]" value="Bradikardia"
                                                            id="circulation_bradikardia">
                                                        <label class="form-check-label" for="circulation_bradikardia">
                                                            Bradikardia
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input emergency-check"
                                                            type="checkbox" name="circulation[]" value="Takikardi"
                                                            id="circulation_takikardi">
                                                        <label class="form-check-label" for="circulation_takikardi">
                                                            Takikardi
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input emergency-check"
                                                            type="checkbox" name="circulation[]" value="Pucat"
                                                            id="circulation_pucat">
                                                        <label class="form-check-label" for="circulation_pucat">
                                                            Pucat
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input emergency-check"
                                                            type="checkbox" name="circulation[]"
                                                            value="CRT > 2 detik" id="circulation_crt">
                                                        <label class="form-check-label" for="circulation_crt">
                                                            CRT > 2 detik
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input emergency-check"
                                                            type="checkbox" name="circulation[]"
                                                            value="Tanda-tanda dehidrasi sedang-berat"
                                                            id="circulation_dehidrasi">
                                                        <label class="form-check-label" for="circulation_dehidrasi">
                                                            Tanda-tanda dehidrasi sedang-berat
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input emergency-check"
                                                            type="checkbox" name="circulation[]" value="Suhu > 40 C"
                                                            id="circulation_suhu">
                                                        <label class="form-check-label" for="circulation_suhu">
                                                            Suhu > 40 C
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input resusitasi-check"
                                                            type="checkbox" name="circulation[]"
                                                            value="Henti Jantung / Ketiadaan Sirkulasi"
                                                            id="circulation_henti_jantung">
                                                        <label class="form-check-label"
                                                            for="circulation_henti_jantung">
                                                            Henti Jantung / Ketiadaan Sirkulasi
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input resusitasi-check"
                                                            type="checkbox" name="circulation[]"
                                                            value="Nadi tak teraba" id="circulation_nadi_tak_teraba">
                                                        <label class="form-check-label"
                                                            for="circulation_nadi_tak_teraba">
                                                            Nadi tak teraba
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input resusitasi-check"
                                                            type="checkbox" name="circulation[]" value="Cianosis"
                                                            id="circulation_cianosis">
                                                        <label class="form-check-label" for="circulation_cianosis">
                                                            Cianosis
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input doa-check" type="checkbox"
                                                            name="circulation[]" value="R/C (-/-)"
                                                            id="breathing_mati">
                                                        <label class="form-check-label" for="breathing_mati">
                                                            R/C (-/-)
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input doa-check" type="checkbox"
                                                            name="circulation[]" value="EKG Flat"
                                                            id="breathing_mati">
                                                        <label class="form-check-label" for="breathing_mati">
                                                            EKG Flat
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input doa-check" type="checkbox"
                                                            name="circulation[]" value="Tidak ada denyut nadi"
                                                            id="breathing_mati">
                                                        <label class="form-check-label" for="breathing_mati">
                                                            Tidak ada denyut nadi
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-3">

                                            <div class="card mb-3">
                                                <div class="card-header border-bottom">
                                                    <p class="m-0 p-0 fw-bold">Disability</p>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input false-emergency-check"
                                                            type="checkbox" name="disability[]" value="Sadar"
                                                            id="disability_sadar">
                                                        <label class="form-check-label" for="disability_sadar">
                                                            Sadar
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input false-emergency-check"
                                                            type="checkbox" name="disability[]" value="GCS 15"
                                                            id="disability_gcs_15">
                                                        <label class="form-check-label" for="disability_gcs_15">GCS 15
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input urgent-check" type="checkbox"
                                                            name="disability[]" value="GCS >= 12"
                                                            id="disability_gcs_12">
                                                        <label class="form-check-label" for="disability_gcs_12">
                                                            GCS >= 12
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input emergency-check"
                                                            type="checkbox" name="disability[]" value="GCS 9-12"
                                                            id="disability_gcs_9_12">
                                                        <label class="form-check-label" for="disability_gcs_9_12">
                                                            GCS 9-12
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input emergency-check"
                                                            type="checkbox" name="disability[]" value="Gelisah"
                                                            id="disability_gelisah">
                                                        <label class="form-check-label" for="disability_gelisah">
                                                            Gelisah
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input emergency-check"
                                                            type="checkbox" name="disability[]" value="Nyeri Dada"
                                                            id="disability_nyeri_dada">
                                                        <label class="form-check-label" for="disability_nyeri_dada">
                                                            Nyeri Dada
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input emergency-check"
                                                            type="checkbox" name="disability[]"
                                                            value="Hemiparese Akut" id="disability_hemiparese_akut">
                                                        <label class="form-check-label"
                                                            for="disability_hemiparese_akut">
                                                            Hemiparese Akut
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input resusitasi-check"
                                                            type="checkbox" name="disability[]" value="GCS < 9"
                                                            id="disability_gcs_under_9">
                                                        <label class="form-check-label" for="disability_gcs_under_9">
                                                            GCS < 9 </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input resusitasi-check"
                                                            type="checkbox" name="disability[]"
                                                            value="Tidak ada respon" id="disability_no_respon">
                                                        <label class="form-check-label" for="disability_no_respon">
                                                            Tidak ada respon
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input resusitasi-check"
                                                            type="checkbox" name="disability[]" value="Kejang"
                                                            id="disability_kejang">
                                                        <label class="form-check-label" for="disability_kejang">
                                                            Kejang
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-12">
                                            <div class="d-flex align-items-center w-100">
                                                <p class="fw-medium text-primary m-0 p-0">Kesimpulan Triase :
                                                </p>
                                                <button type="button" id="editTriaseStatusLabel"
                                                    class="btn btn-block ms-3 w-100"></button>
                                                <input type="hidden" name="kode_triase" id="kode_triase">
                                                <input type="hidden" name="ket_triase" id="ket_triase">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="simpanReTriaseEdit">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var reTriaseModal = new bootstrap.Modal(document.getElementById('reTriagePatientEdit'));
            var reTriaseTable = document.querySelector('#reTriaseTable tbody');
            var reTriaseData = [];

            // Fungsi untuk mengumpulkan data form secara manual
            function getFormData(container) {
                const data = {};
                container.querySelectorAll('input, textarea, select').forEach((input) => {
                    if (input.type === 'checkbox') {
                        if (input.checked) {
                            if (!data[input.name]) {
                                data[input.name] = [];
                            }
                            data[input.name].push(input.value);
                        }
                    } else {
                        data[input.name] = input.value;
                    }
                });

                // Organisasi ulang data triase sesuai dengan format JSON yang diperlukan
                const triaseData = {
                    hasil_triase: data.ket_triase || '',
                    kode_triase: data.kode_triase || '',
                    air_way: data['airway[]'] || [],
                    breathing: data['breathing[]'] || [],
                    circulation: data['circulation[]'] || [],
                    disability: data['disability[]'] || []
                };

                data['triase'] = triaseData;
                return data;
            }


            // Event listener untuk membuka modal re-triase
            document.getElementById('editOpenReTriaseModal').addEventListener('click', function() {
                resetReTriaseForm();
                const reTriaseModal = new bootstrap.Modal(document.getElementById('reTriagePatientEdit'));
                reTriaseModal.show();
            });

            // Perubahan pada checkbox DOA
            document.querySelectorAll('#reTriagePatientEdit .doa-check').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    let doaChecked = document.querySelectorAll(
                        '#reTriagePatientEdit .doa-check:checked').length > 0;
                    document.querySelectorAll(
                        '#reTriagePatientEdit input[type="checkbox"]:not(.doa-check)').forEach(
                        function(cb) {
                            cb.disabled = doaChecked;
                        });
                    updateTriaseStatus();
                });
            });

            // Perubahan pada checkbox non-DOA
            document.querySelectorAll('#reTriagePatientEdit input[type="checkbox"]:not(.doa-check)').forEach(function(
                checkbox) {
                checkbox.addEventListener('change', function() {
                    let nonDoaChecked = document.querySelectorAll(
                            '#reTriagePatientEdit input[type="checkbox"]:checked:not(.doa-check)')
                        .length > 0;
                    document.querySelectorAll('#reTriagePatientEdit input[type="checkbox"].doa-check')
                        .forEach(function(cb) {
                            cb.disabled = nonDoaChecked;
                        });
                    updateTriaseStatus();
                });
            });

            // Fungsi untuk memperbarui status triase dan kode triase
            function updateTriaseStatus() {
                var status = '';
                var kode_triase = '';

                if (document.querySelectorAll('#reTriagePatientEdit .doa-check:checked').length > 0) {
                    status = 'DOA';
                    kode_triase = 5;
                } else if (document.querySelectorAll('#reTriagePatientEdit .resusitasi-check:checked').length > 0) {
                    status = 'RESUSITASI (segera)';
                    kode_triase = 4;
                } else if (document.querySelectorAll('#reTriagePatientEdit .emergency-check:checked').length > 0) {
                    status = 'EMERGENCY (10 menit)';
                    kode_triase = 3;
                } else if (document.querySelectorAll('#reTriagePatientEdit .urgent-check:checked').length > 0) {
                    status = 'URGENT (30 menit)';
                    kode_triase = 2;
                } else if (document.querySelectorAll('#reTriagePatientEdit .false-emergency-check:checked').length >
                    0) {
                    status = 'FALSE EMERGENCY (60 menit)';
                    kode_triase = 1;
                }

                document.getElementById('editTriaseStatusLabel').textContent = status;
                document.getElementById('editTriaseStatusLabel').className = determineClass(status);
                document.getElementById('kode_triase').value = kode_triase;
                document.getElementById('ket_triase').value = status;
            }

            // Fungsi untuk menentukan kelas berdasarkan status triase (dengan warna)
            function determineClass(status) {
                switch (status) {
                    case 'RESUSITASI (segera)':
                    case 'EMERGENCY (10 menit)':
                        return 'btn btn-block btn-danger ms-3 w-100';
                    case 'URGENT (30 menit)':
                        return 'btn btn-block btn-warning ms-3 w-100';
                    case 'FALSE EMERGENCY (60 menit)':
                        return 'btn btn-block btn-success ms-3 w-100';
                    case 'DOA':
                        return 'btn btn-block btn-dark ms-3 w-100';
                    default:
                        return 'btn btn-block ms-3 w-100';
                }
            }

            function resetReTriaseForm() {
                const modalBody = document.getElementById('reTriagePatientEdit').querySelector('.modal-body');

                // Reset semua input
                modalBody.querySelectorAll('input, textarea, select').forEach(function(input) {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false;
                        input.disabled = false; // Reset disabled state
                    } else if (input.tagName === 'SELECT') {
                        input.selectedIndex = 0;
                    } else {
                        input.value = '';
                    }
                });

                // Reset status triase
                document.getElementById('editTriaseStatusLabel').textContent = '';
                document.getElementById('editTriaseStatusLabel').className = 'btn btn-block ms-3 w-100';
                document.getElementById('kode_triase').value = '';
                document.getElementById('ket_triase').value = '';
            }

            const simpanReTriaseEditBtn = document.getElementById('simpanReTriaseEdit');
            if (simpanReTriaseEditBtn) {
                // Hapus event listener yang mungkin sudah ada sebelumnya
                simpanReTriaseEditBtn.replaceWith(simpanReTriaseEditBtn.cloneNode(true));

                // Tambahkan event listener baru
                document.getElementById('simpanReTriaseEdit').addEventListener('click', function() {
                    const modalBody = document.getElementById('reTriagePatientEdit').querySelector(
                        '.modal-body');
                    let formData = getFormData(modalBody);

                    // Validasi input yang diperlukan
                    const requiredFields = [{
                            field: 'td_sistole_retriage_edit',
                            label: 'TD Sistole'
                        },
                        {
                            field: 'td_diastole_retriage_edit',
                            label: 'TD Diastole'
                        },
                        {
                            field: 'nadi_retriage_edit',
                            label: 'Nadi'
                        },
                        {
                            field: 'resp_retriage_edit',
                            label: 'Respirasi'
                        },
                        {
                            field: 'suhu_retriage_edit',
                            label: 'Suhu'
                        },
                        {
                            field: 'spo2_tanpa_o2_retriage_edit',
                            label: 'SpO2 (tanpa O2)'
                        },
                        {
                            field: 'spo2_dengan_o2_retriage_edit',
                            label: 'SpO2 (dengan O2)'
                        },
                        {
                            field: 'gcs_retriage_edit',
                            label: 'GCS'
                        },
                        {
                            field: 'avpu_retriage_edit',
                            label: 'AVPU'
                        }
                    ];

                    const emptyFields = requiredFields.filter(field => !formData[field.field])
                        .map(field => field.label);

                    if (emptyFields.length > 0) {
                        iziToast.error({
                            title: 'Error',
                            message: 'Field berikut masih kosong: ' + emptyFields.join(', '),
                            position: 'topRight',
                            timeout: 5000
                        });
                        return;
                    }

                    // Validasi status triase
                    if (!formData.kode_triase || !formData.ket_triase) {
                        iziToast.error({
                            title: 'Error',
                            message: 'Pilih minimal satu kondisi triase',
                            position: 'topRight',
                            timeout: 5000
                        });
                        return;
                    }

                    // Format data retriase baru
                    const newReTriase = {
                        tanggal_triase: new Date().toISOString(),
                        anamnesis_retriase: formData.edit_anamnesis_retriage || '-',
                        catatan_retriase: formData.catatan_retriage_edit || '-',
                        kode_triase: formData.kode_triase,
                        hasil_triase: formData.ket_triase,
                        vitalsign_retriase: JSON.stringify({
                            td_sistole: formData.td_sistole_retriage_edit,
                            td_diastole: formData.td_diastole_retriage_edit,
                            nadi: formData.nadi_retriage_edit,
                            resp: formData.resp_retriage_edit,
                            suhu: formData.suhu_retriage_edit,
                            spo2_tanpa_o2: formData.spo2_tanpa_o2_retriage_edit,
                            spo2_dengan_o2: formData.spo2_dengan_o2_retriage_edit,
                            gcs: formData.gcs_retriage_edit,
                            avpu: formData.avpu_retriage_edit
                        }),
                        triase: JSON.stringify({
                            hasil_triase: formData.ket_triase,
                            kode_triase: formData.kode_triase,
                            air_way: formData.triase.air_way,
                            breathing: formData.triase.breathing,
                            circulation: formData.triase.circulation,
                            disability: formData.triase.disability
                        })
                    };

                    // Inisialisasi array jika belum ada
                    if (!Array.isArray(originalReTriaseData)) {
                        originalReTriaseData = [];
                    }

                    // Tambahkan data baru
                    originalReTriaseData.push(newReTriase);

                    // Update tampilan tabel
                    updateEditReTriaseTable();

                    // Reset form dan tutup modal
                    resetReTriaseForm();
                    const reTriaseModal = bootstrap.Modal.getInstance(document.getElementById(
                        'reTriagePatientEdit'));
                    reTriaseModal.hide();

                    // Tampilkan notifikasi sukses
                    iziToast.success({
                        title: 'Sukses',
                        message: 'Data Re-Triase berhasil ditambahkan',
                        position: 'topRight',
                        timeout: 3000
                    });
                });
            }

            // Fungsi untuk update tampilan tabel retriase
            function updateEditReTriaseTable() {
                const tbody = $('#editreTriaseTable tbody');
                tbody.empty();

                if (!originalReTriaseData || originalReTriaseData.length === 0) {
                    tbody.html(`
                        <tr>
                            <td colspan="4" class="text-center">
                                <em>Tidak ada data re-triase</em>
                            </td>
                        </tr>
                    `);
                    return;
                }

                originalReTriaseData.forEach((data, index) => {
                    // Parse vital sign data
                    let vitalSignData;
                    try {
                        vitalSignData = typeof data.vitalsign_retriase === 'string' ?
                            JSON.parse(data.vitalsign_retriase) : data.vitalsign_retriase;
                    } catch (e) {
                        console.error('Error parsing vital sign data:', e);
                        vitalSignData = {};
                    }

                    // Format tanggal
                    const formattedDate = new Date(data.tanggal_triase).toLocaleString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    // Format vital signs untuk tampilan
                    const formattedVitalSigns = `
                        <div class="vital-signs-container">
                            <ul class="list-unstyled mb-0">
                                ${vitalSignData.td_sistole ? `<li><strong>TD:</strong> ${vitalSignData.td_sistole}/${vitalSignData.td_diastole} mmHg</li>` : ''}
                                ${vitalSignData.nadi ? `<li><strong>Nadi:</strong> ${vitalSignData.nadi} x/mnt</li>` : ''}
                                ${vitalSignData.resp ? `<li><strong>Respirasi:</strong> ${vitalSignData.resp} x/mnt</li>` : ''}
                                ${vitalSignData.suhu ? `<li><strong>Suhu:</strong> ${vitalSignData.suhu}°C</li>` : ''}
                                ${vitalSignData.spo2_tanpa_o2 ? `<li><strong>SpO2 (tanpa O2):</strong> ${vitalSignData.spo2_tanpa_o2}%</li>` : ''}
                                ${vitalSignData.spo2_dengan_o2 ? `<li><strong>SpO2 (dengan O2):</strong> ${vitalSignData.spo2_dengan_o2}%</li>` : ''}
                                ${vitalSignData.gcs ? `<li><strong>GCS:</strong> ${vitalSignData.gcs}</li>` : ''}
                                ${vitalSignData.avpu ? `<li><strong>AVPU:</strong> ${vitalSignData.avpu}</li>` : ''}
                            </ul>
                        </div>
                    `;

                    const row = `
                        <tr>
                            <td class="align-middle" style="min-width: 140px;">
                                ${formattedDate}
                            </td>
                            <td class="align-middle">
                                ${data.anamnesis_retriase || '-'}
                                ${data.catatan_retriase ? `<br><small class="text-muted">Catatan: ${data.catatan_retriase}</small>` : ''}
                            </td>
                            <td class="align-middle">
                                ${formattedVitalSigns}
                            </td>
                            <td class="align-middle text-center" style="min-width: 160px;">
                                <span class="badge ${getTriaseClass(data.kode_triase)} px-3 py-2">
                                    ${data.hasil_triase || '-'}
                                </span>
                            </td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            }

            // Fungsi untuk mendapatkan kelas badge triase
            function getTriaseClass(kodeTriase) {
                switch (parseInt(kodeTriase)) {
                    case 5:
                        return 'bg-dark text-white'; // Meninggal
                    case 4:
                        return 'bg-danger text-white'; // Emergency
                    case 3:
                        return 'bg-danger text-white'; // Emergency
                    case 2:
                        return 'bg-warning text-dark'; // Urgency
                    case 1:
                        return 'bg-success text-white'; // False Emergency
                    default:
                        return 'bg-secondary text-white';
                }
            }

            // Fungsi untuk mengirim data re-triase dalam bentuk JSON ke server
            window.getReTriageData = function() {
                return JSON.stringify(reTriaseData);
            };
        });
    </script>
@endpush
