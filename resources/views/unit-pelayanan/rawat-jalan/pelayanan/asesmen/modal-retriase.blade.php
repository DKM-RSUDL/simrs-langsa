<button class="btn btn-sm" type="button" id="openReTriaseModal">
    <i class="bi bi-plus-square"></i> Tambah
</button>

<div class="modal fade" id="reTriagePatient" tabindex="-1" aria-labelledby="reTriagePatientLabel" aria-hidden="true">
    <div class="container-fluid">
        <div class="modal-dialog modal-fullscreen h-auto w-100">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="reTriagePatientLabel">
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
                                        <textarea class="form-control mb-2" rows="3" name="anamnesis_retriage"
                                            placeholder="Isikan keluhan dan anamnesis pasien, jika terjadi cidera jelaskan mekanisme cideranya"></textarea>
                                    </div>

                                    <div class="form-line">
                                        <h6>Vital Sign</h6>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label>TD (Sistole)</label>
                                                <input type="number" class="form-control" name="td_sistole_retriage">
                                            </div>
                                            <div class="col">
                                                <label>TD (Diastole)</label>
                                                <input type="number" class="form-control" name="td_diastole_retriage">
                                            </div>
                                            <div class="col">
                                                <label>Nadi (x/mnt)</label>
                                                <input type="number" class="form-control" name="nadi_retriage">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label>Resp (x/mnt)</label>
                                                <input type="number" class="form-control" name="resp_retriage">
                                            </div>
                                            <div class="col">
                                                <label>Suhu (°C)</label>
                                                <input type="number" class="form-control" name="suhu_retriage">
                                            </div>
                                            <div class="col">
                                                <label>SpO2 (tanpa O2)</label>
                                                <input type="number" class="form-control"
                                                    name="spo2_tanpa_o2_retriage">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-4">
                                                <label>SpO2 (dengan O2)</label>
                                                <input type="number" class="form-control"
                                                    name="spo2_dengan_o2_retriage">
                                            </div>
                                            <div class="col-4">
                                                <label>GCS</label>
                                                <input type="number" class="form-control"
                                                    name="gcs_retriage">
                                            </div>
                                            <div class="col-4">
                                                <label>AVPU</label>
                                                <select class="form-select" name="avpu_retriage">
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
                                        <textarea class="form-control mb-2" rows="3" name="catatan_retriage" placeholder="Isikan Catatan"></textarea>
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
                                                <button type="button" id="triaseStatusLabel"
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
                    <button type="button" class="btn btn-primary" id="simpanReTriase">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var reTriaseModal = new bootstrap.Modal(document.getElementById('reTriagePatient'));
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
            document.getElementById('openReTriaseModal').addEventListener('click', function(event) {
                event.preventDefault();
                reTriaseModal.show();
            });

            // Perubahan pada checkbox DOA
            document.querySelectorAll('#reTriagePatient .doa-check').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    let doaChecked = document.querySelectorAll(
                        '#reTriagePatient .doa-check:checked').length > 0;
                    document.querySelectorAll(
                        '#reTriagePatient input[type="checkbox"]:not(.doa-check)').forEach(
                        function(cb) {
                            cb.disabled = doaChecked;
                        });
                    updateTriaseStatus();
                });
            });

            // Perubahan pada checkbox non-DOA
            document.querySelectorAll('#reTriagePatient input[type="checkbox"]:not(.doa-check)').forEach(function(
                checkbox) {
                checkbox.addEventListener('change', function() {
                    let nonDoaChecked = document.querySelectorAll(
                            '#reTriagePatient input[type="checkbox"]:checked:not(.doa-check)')
                        .length > 0;
                    document.querySelectorAll('#reTriagePatient input[type="checkbox"].doa-check')
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

                if (document.querySelectorAll('#reTriagePatient .doa-check:checked').length > 0) {
                    status = 'DOA';
                    kode_triase = 5;
                } else if (document.querySelectorAll('#reTriagePatient .resusitasi-check:checked').length > 0) {
                    status = 'RESUSITASI (segera)';
                    kode_triase = 4;
                } else if (document.querySelectorAll('#reTriagePatient .emergency-check:checked').length > 0) {
                    status = 'EMERGENCY (10 menit)';
                    kode_triase = 3;
                } else if (document.querySelectorAll('#reTriagePatient .urgent-check:checked').length > 0) {
                    status = 'URGENT (30 menit)';
                    kode_triase = 2;
                } else if (document.querySelectorAll('#reTriagePatient .false-emergency-check:checked').length >
                    0) {
                    status = 'FALSE EMERGENCY (60 menit)';
                    kode_triase = 1;
                }

                document.getElementById('triaseStatusLabel').textContent = status;
                document.getElementById('triaseStatusLabel').className = determineClass(status);
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
                var modalBody = document.getElementById('reTriagePatient').querySelector('.modal-body');
                modalBody.querySelectorAll('input, textarea, select').forEach(function(input) {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false; // Untuk checkbox dan radio
                    } else if (input.tagName === 'SELECT') {
                        input.selectedIndex = 0; // Untuk select box
                    } else {
                        input.value = ''; // Untuk input teks, number, textarea
                    }
                });
            }

            // Fungsi untuk menyimpan data re-triase dan menambahkan ke tabel
            document.getElementById('simpanReTriase').addEventListener('click', function() {
                updateTriaseStatus(); // Pastikan status triase diperbarui sebelum data disimpan

                var modalBody = document.getElementById('reTriagePatient').querySelector('.modal-body');
                var formData = getFormData(modalBody);
                console.log(formData); // Debugging untuk melihat formData yang dikumpulkan

                var emptyFields = [];
                var requiredFields = [
                    'td_sistole_retriage', 'td_diastole_retriage', 'nadi_retriage',
                    'resp_retriage', 'suhu_retriage', 'spo2_tanpa_o2_retriage',
                    'spo2_dengan_o2_retriage', 'gcs_retriage', 'avpu_retriage'
                ];

                // Validasi input yang diperlukan
                requiredFields.forEach(function(field) {
                    if (!formData[field]) {
                        emptyFields.push(field);
                    }
                });

                if (emptyFields.length > 0) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Field berikut masih kosong: ' + emptyFields.join(', '),
                        position: 'topRight'
                    });
                    return;
                }

                var newData = {
                    tanggalJam: new Date().toLocaleString(),
                    keluhan: formData.anamnesis_retriage || 'Tidak ada keluhan',
                    vitalSigns: {
                        td_sistole: formData.td_sistole_retriage,
                        td_diastole: formData.td_diastole_retriage,
                        nadi: formData.nadi_retriage,
                        resp: formData.resp_retriage,
                        suhu: formData.suhu_retriage,
                        spo2_tanpa_o2: formData.spo2_tanpa_o2_retriage,
                        spo2_dengan_o2: formData.spo2_dengan_o2_retriage,
                        gcs: formData.gcs_retriage,
                        avpu: formData.avpu_retriage,
                    },
                    triase: {
                        kode_triase: document.getElementById('kode_triase')
                        .value, // Ambil nilai kode triase terbaru
                        ket_triase: document.getElementById('ket_triase')
                        .value, // Ambil nilai ket triase terbaru
                        air_way: formData.triase.air_way,
                        breathing: formData.triase.breathing,
                        circulation: formData.triase.circulation,
                        disability: formData.triase.disability
                    },
                    catatan: formData.catatan_retriage || 'Tidak ada catatan'
                };

                // Tambahkan data ke array reTriaseData
                reTriaseData.push(newData);
                updateReTriaseTable();
                resetReTriaseForm();
                reTriaseModal.hide();
            });


            // Fungsi untuk memperbarui tabel re-triase
            function updateReTriaseTable() {
                var tbody = document.querySelector('#reTriaseTable tbody');
                tbody.innerHTML = ''; // Kosongkan tabel sebelum menambahkan data baru

                console.log("Updating table with data:", reTriaseData); // Debugging line

                reTriaseData.forEach(function(data, index) {
                    var row = `
                    <tr>
                        <td>${data.tanggalJam}</td>
                        <td>${data.keluhan}</td>
                        <td>
                            <ul>
                                <li>TD Sistole: ${data.vitalSigns.td_sistole}</li>
                                <li>TD Diastole: ${data.vitalSigns.td_diastole}</li>
                                <li>Nadi: ${data.vitalSigns.nadi}</li>
                                <li>Resp: ${data.vitalSigns.resp}</li>
                                <li>Suhu: ${data.vitalSigns.suhu}</li>
                                <li>SpO2 (tanpa O2): ${data.vitalSigns.spo2_tanpa_o2}</li>
                                <li>SpO2 (dengan O2): ${data.vitalSigns.spo2_dengan_o2}</li>
                                <li>GCS: ${data.vitalSigns.gcs}</li>
                                <li>AVPU: ${data.vitalSigns.avpu}</li>
                            </ul>
                        </td>
                        <td>
                            <div class="triase-circle ${getTriaseClass(data.triase.kode_triase)}"></div>
                            <div class="triase-label">${data.triase.ket_triase}</div>
                        </td>
                    </tr>
                `;
                    tbody.innerHTML += row;
                });
            }


            // Fungsi untuk memberikan kelas warna berdasarkan kode triase
            function getTriaseClass(kode_triase) {
                switch (parseInt(kode_triase)) {
                    case 5:
                        return 'triase-doa';
                    case 4:
                        return 'triase-resusitasi';
                    case 3:
                        return 'triase-emergency';
                    case 2:
                        return 'triase-urgent';
                    case 1:
                        return 'triase-false-emergency';
                    default:
                        return '';
                }
            }

            // Fungsi untuk mengirim data re-triase dalam bentuk JSON ke server
            window.getReTriageData = function() {
                return JSON.stringify(reTriaseData);
            };
        });
    </script>
@endpush
