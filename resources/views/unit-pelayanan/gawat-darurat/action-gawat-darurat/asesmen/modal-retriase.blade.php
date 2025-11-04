{{-- MODAL RETRIASE/OBSERVASI LANJUTAN --}}
<div class="modal fade" id="retriaseModal" tabindex="-1" aria-labelledby="retriaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="retriaseModalLabel">Tambah Retriase/Observasi Lanjutan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="retriaseForm">
                    <div class="row g-3">
                        {{-- Tanggal dan Jam --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">Tanggal</label>
                                <input type="date" class="form-control" id="retriaseTanggal"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">Jam</label>
                                <input type="time" class="form-control" id="retriaseJam" value="{{ date('H:i') }}"
                                    required>
                            </div>
                        </div>

                        {{-- GCS --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">GCS</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="retriaseGCS"
                                        placeholder="Contoh: 15 E4 V5 M6" readonly>
                                    <button type="button" class="btn btn-outline-primary"
                                        onclick="openGCSModalForRetriase()" title="Buka Kalkulator GCS">
                                        <i class="ti-calculator"></i> Hitung GCS
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Suhu --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Suhu (°C)</label>
                                <input type="number" step="0.1" class="form-control" id="retriaseTemp"
                                    placeholder="suhu" min="20" max="50">
                            </div>
                        </div>

                        {{-- Respirasi --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">RR (x/menit)</label>
                                <input type="number" class="form-control" id="retriaseRR" placeholder="rr"
                                    min="0" max="100">
                            </div>
                        </div>

                        {{-- SpO2 tanpa O2 --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">SpO2 tanpa O2 (%)</label>
                                <input type="number" class="form-control" id="retriaseSpo2TanpaO2"
                                    placeholder="spo2 tanpa o2" min="0" max="150">
                            </div>
                        </div>

                        {{-- SpO2 dengan O2 --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">SpO2 dengan O2 (%)</label>
                                <input type="number" class="form-control" id="retriaseSpo2DenganO2"
                                    placeholder="spo2 dengan o2" min="0" max="150">
                            </div>
                        </div>

                        {{-- TD Sistole --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">TD Sistole (mmHg)</label>
                                <input type="number" class="form-control" id="retriaseTdSistole" placeholder="sistole"
                                    min="0" max="400">
                            </div>
                        </div>

                        {{-- TD Diastole --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">TD Diastole (mmHg)</label>
                                <input type="number" class="form-control" id="retriaseTdDiastole"
                                    placeholder="diastole" min="0" max="300">
                            </div>
                        </div>

                        {{-- Keluhan --}}
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Keluhan</label>
                                <textarea class="form-control" id="retriaseKeluhan" rows="3"
                                    placeholder="Deskripsikan keluhan pasien saat observasi..."></textarea>
                            </div>
                        </div>

                        {{-- Kesimpulan Triase --}}
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Kesimpulan Triase</label>
                                <select class="form-select" id="retriaseKesimpulanTriase" name="kesimpulan_triase">
                                    <option value="">--Pilih Kesimpulan Triase--</option>
                                    <option value="1">FALSE EMERGENCY (60 menit)</option>
                                    <option value="2">URGENT (30 menit)</option>
                                    <option value="3">EMERGENCY (10 menit)</option>
                                    <option value="4">RESUSITASI (segera)</option>
                                    <option value="5">DOA</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    {{-- Alert untuk validasi vital sign --}}
                    <div class="alert alert-info mt-3">
                        <i class="ti-info-alt"></i>
                        <small>Pastikan nilai vital sign dalam rentang normal. Sistem akan memberikan peringatan jika
                            ada nilai yang tidak normal.</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanRetriase">
                    <i class="ti-check"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- GCS Modal untuk Retriase --}}
<div class="modal fade" id="gcsRetriaseModal" tabindex="-1" aria-labelledby="gcsRetriaseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gcsRetriaseModalLabel">Kalkulator GCS - Retriase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="gcs-calculator">
                    {{-- Eye Opening (E) --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Eye Opening (E)</label>
                        <div class="gcs-options">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gcsEyeRetriase" value="4"
                                    id="eyeRetriase4">
                                <label class="form-check-label" for="eyeRetriase4">
                                    4 - Spontan
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gcsEyeRetriase" value="3"
                                    id="eyeRetriase3">
                                <label class="form-check-label" for="eyeRetriase3">
                                    3 - Terhadap suara
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gcsEyeRetriase" value="2"
                                    id="eyeRetriase2">
                                <label class="form-check-label" for="eyeRetriase2">
                                    2 - Terhadap nyeri
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gcsEyeRetriase" value="1"
                                    id="eyeRetriase1">
                                <label class="form-check-label" for="eyeRetriase1">
                                    1 - Tidak ada respon
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Verbal Response (V) --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Verbal Response (V)</label>
                        <div class="gcs-options">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gcsVerbalRetriase"
                                    value="5" id="verbalRetriase5">
                                <label class="form-check-label" for="verbalRetriase5">
                                    5 - Orientasi baik
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gcsVerbalRetriase"
                                    value="4" id="verbalRetriase4">
                                <label class="form-check-label" for="verbalRetriase4">
                                    4 - Bingung
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gcsVerbalRetriase"
                                    value="3" id="verbalRetriase3">
                                <label class="form-check-label" for="verbalRetriase3">
                                    3 - Kata-kata tidak tepat
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gcsVerbalRetriase"
                                    value="2" id="verbalRetriase2">
                                <label class="form-check-label" for="verbalRetriase2">
                                    2 - Suara tidak jelas
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gcsVerbalRetriase"
                                    value="1" id="verbalRetriase1">
                                <label class="form-check-label" for="verbalRetriase1">
                                    1 - Tidak ada respon
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Motor Response (M) --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Motor Response (M)</label>
                        <div class="gcs-options">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gcsMotorRetriase"
                                    value="6" id="motorRetriase6">
                                <label class="form-check-label" for="motorRetriase6">
                                    6 - Mengikuti perintah
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gcsMotorRetriase"
                                    value="5" id="motorRetriase5">
                                <label class="form-check-label" for="motorRetriase5">
                                    5 - Melokalisir nyeri
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gcsMotorRetriase"
                                    value="4" id="motorRetriase4">
                                <label class="form-check-label" for="motorRetriase4">
                                    4 - Menghindari nyeri
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gcsMotorRetriase"
                                    value="3" id="motorRetriase3">
                                <label class="form-check-label" for="motorRetriase3">
                                    3 - Fleksi abnormal
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gcsMotorRetriase"
                                    value="2" id="motorRetriase2">
                                <label class="form-check-label" for="motorRetriase2">
                                    2 - Ekstensi abnormal
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gcsMotorRetriase"
                                    value="1" id="motorRetriase1">
                                <label class="form-check-label" for="motorRetriase1">
                                    1 - Tidak ada respon
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Hasil GCS --}}
                    <div class="gcs-result">
                        <div class="alert alert-primary text-center">
                            <h5 class="mb-0">Total GCS: <span id="gcsRetriaseTotal">0</span></h5>
                            <small id="gcsRetriaseDetail">E0 V0 M0</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanGCSRetriase">
                    <i class="ti-check"></i> Gunakan GCS
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        initRetriase();
    });

    function initRetriase() {
        let retriaseArray = [];
        let editRetriaseIndex = -1;

        // Event listeners
        const btnSimpanRetriase = document.getElementById('btnSimpanRetriase');
        const retriaseModal = document.getElementById('retriaseModal');
        const btnSimpanGCSRetriase = document.getElementById('btnSimpanGCSRetriase');

        if (btnSimpanRetriase) {
            btnSimpanRetriase.addEventListener('click', function() {
                saveRetriase();
            });
        }

        if (retriaseModal) {
            retriaseModal.addEventListener('hidden.bs.modal', function() {
                resetRetriaseModal();
                editRetriaseIndex = -1;
            });
        }

        if (btnSimpanGCSRetriase) {
            btnSimpanGCSRetriase.addEventListener('click', function() {
                applyGCSToRetriase();
            });
        }

        // GCS Calculator untuk Retriase
        initGCSRetriaseCalculator();

        function getKesimpulanTriaseText(kode) {
            const mapping = {
                '1': 'FALSE EMERGENCY (60 menit)',
                '2': 'URGENT (30 menit)',
                '3': 'EMERGENCY (10 menit)',
                '4': 'RESUSITASI (segera)',
                '5': 'DOA'
            };
            return mapping[kode] || '-';
        }

        function getTriaseBadgeClass(kode) {
            const mapping = {
                '1': 'bg-success', // FALSE EMERGENCY - hijau
                '2': 'bg-warning', // URGENT - kuning
                '3': 'bg-danger', // EMERGENCY - merah
                '4': 'bg-dark', // RESUSITASI - hitam
                '5': 'bg-secondary' // DOA - abu-abu
            };
            return mapping[kode] || 'bg-light';
        }

        function saveRetriase() {
            const tanggal = document.getElementById('retriaseTanggal').value;
            const jam = document.getElementById('retriaseJam').value;
            const gcs = document.getElementById('retriaseGCS').value;
            const temp = document.getElementById('retriaseTemp').value;
            const rr = document.getElementById('retriaseRR').value;
            const spo2TanpaO2 = document.getElementById('retriaseSpo2TanpaO2').value;
            const spo2DenganO2 = document.getElementById('retriaseSpo2DenganO2').value;
            const tdSistole = document.getElementById('retriaseTdSistole').value;
            const tdDiastole = document.getElementById('retriaseTdDiastole').value;
            const keluhan = document.getElementById('retriaseKeluhan').value.trim();
            const kesimpulanTriase = document.getElementById('retriaseKesimpulanTriase').value;

            if (!tanggal || !jam) {
                showAlert('Tanggal dan jam harus diisi');
                return;
            }

            // Validasi vital sign
            const validationResult = validateVitalSigns({
                temp: parseFloat(temp),
                rr: parseInt(rr),
                spo2TanpaO2: parseInt(spo2TanpaO2),
                spo2DenganO2: parseInt(spo2DenganO2),
                tdSistole: parseInt(tdSistole),
                tdDiastole: parseInt(tdDiastole)
            });

            if (!validationResult.isValid) {
                if (confirm(
                        `Terdapat nilai vital sign yang abnormal:\n${validationResult.warnings.join('\n')}\n\nLanjutkan menyimpan?`
                    )) {
                    // Continue saving
                } else {
                    return;
                }
            }

            const retriaseData = {
                tanggal: tanggal,
                jam: jam,
                tanggal_jam: `${tanggal} ${jam}`,
                gcs: gcs || '-',
                temp: temp || '-',
                rr: rr || '-',
                spo2_tanpa_o2: spo2TanpaO2 || '-',
                spo2_dengan_o2: spo2DenganO2 || '-',
                td_sistole: tdSistole || '-',
                td_diastole: tdDiastole || '-',
                keluhan: keluhan || '-',
                kesimpulan_triase: kesimpulanTriase || '-',
                kesimpulan_triase_text: getKesimpulanTriaseText(kesimpulanTriase)
            };

            if (editRetriaseIndex === -1) {
                // Add new
                retriaseArray.push(retriaseData);
            } else {
                // Edit existing
                retriaseArray[editRetriaseIndex] = retriaseData;
            }

            renderRetriaseTable();
            updateRetriaseJson();
            closeModal('retriaseModal');
            editRetriaseIndex = -1;
        }

        function validateVitalSigns(vitals) {
            const warnings = [];
            let isValid = true;

            // Validasi suhu
            if (vitals.temp && (vitals.temp < 28.0 || vitals.temp > 45.0)) {
                warnings.push(`Suhu ${vitals.temp}°C (Normal: 36.0-37.5°C)`);
                isValid = false;
            }

            // Validasi respirasi
            if (vitals.rr && (vitals.rr < 10 || vitals.rr > 30)) {
                warnings.push(`Respirasi ${vitals.rr}x/menit (Normal: 16-24x/menit)`);
                isValid = false;
            }

            // Validasi SpO2
            if (vitals.spo2TanpaO2 && vitals.spo2TanpaO2 < 95) {
                warnings.push(`SpO2 tanpa O2 ${vitals.spo2TanpaO2}% (Normal: ≥95%)`);
                isValid = false;
            }

            // Validasi tekanan darah
            if (vitals.tdSistole && (vitals.tdSistole < 90 || vitals.tdSistole > 140)) {
                warnings.push(`TD Sistole ${vitals.tdSistole}mmHg (Normal: 90-140mmHg)`);
                isValid = false;
            }

            if (vitals.tdDiastole && (vitals.tdDiastole < 60 || vitals.tdDiastole > 90)) {
                warnings.push(`TD Diastole ${vitals.tdDiastole}mmHg (Normal: 60-90mmHg)`);
                isValid = false;
            }

            return {
                isValid,
                warnings
            };
        }

        function renderRetriaseTable() {
            const tbody = document.querySelector('#retriaseTable tbody');
            const noAlatRow = tbody.querySelector('tr');

            if (retriaseArray.length === 0) {
                noAlatRow.style.display = 'table-row';
                const existingRows = tbody.querySelectorAll('tr:not(:first-child)');
                existingRows.forEach(row => row.remove());
                return;
            }

            noAlatRow.style.display = 'none';

            // Clear existing rows except no-data row
            const existingRows = tbody.querySelectorAll('tr:not(:first-child)');
            existingRows.forEach(row => row.remove());

            // Add new rows
            retriaseArray.forEach((retriase, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${index + 1}</td>
                <td>${retriase.tanggal_jam}</td>
                <td>${retriase.gcs}</td>
                <td>${retriase.temp}${retriase.temp !== '-' ? '°C' : ''}</td>
                <td>${retriase.rr}${retriase.rr !== '-' ? 'x/mnt' : ''}</td>
                <td>${retriase.spo2_tanpa_o2}${retriase.spo2_tanpa_o2 !== '-' ? '%' : ''}</td>
                <td>${retriase.spo2_dengan_o2}${retriase.spo2_dengan_o2 !== '-' ? '%' : ''}</td>
                <td>${retriase.td_sistole}${retriase.td_sistole !== '-' ? 'mmHg' : ''}</td>
                <td>${retriase.td_diastole}${retriase.td_diastole !== '-' ? 'mmHg' : ''}</td>
                <td style="max-width: 200px;">
                    <div class="text-truncate" title="${retriase.keluhan}">
                        ${retriase.keluhan}
                    </div>
                </td>
                <td>
                    <span class="badge ${getTriaseBadgeClass(retriase.kesimpulan_triase)}">
                        ${retriase.kesimpulan_triase_text}
                    </span>
                </td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-primary edit-retriase"
                                data-index="${index}" title="Edit">
                            <i class="ti-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger delete-retriase"
                                data-index="${index}" title="Hapus">
                            <i class="ti-trash"></i>
                        </button>
                    </div>
                </td>
            `;

                tbody.appendChild(row);
            });

            // Add event listeners for new buttons
            tbody.querySelectorAll('.edit-retriase').forEach(btn => {
                btn.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    openRetriaseModal('edit', index);
                });
            });

            tbody.querySelectorAll('.delete-retriase').forEach(btn => {
                btn.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    deleteRetriase(index);
                });
            });
        }

        function openRetriaseModal(mode, index = -1) {
            const modalLabel = document.getElementById('retriaseModalLabel');

            if (mode === 'add') {
                modalLabel.textContent = 'Tambah Retriase/Observasi Lanjutan';
                resetRetriaseModal();
                editRetriaseIndex = -1;
            } else if (mode === 'edit' && index !== -1) {
                modalLabel.textContent = 'Edit Retriase/Observasi Lanjutan';
                const retriase = retriaseArray[index];

                document.getElementById('retriaseTanggal').value = retriase.tanggal;
                document.getElementById('retriaseJam').value = retriase.jam;
                document.getElementById('retriaseGCS').value = retriase.gcs === '-' ? '' : retriase.gcs;
                document.getElementById('retriaseTemp').value = retriase.temp === '-' ? '' : retriase.temp;
                document.getElementById('retriaseRR').value = retriase.rr === '-' ? '' : retriase.rr;
                document.getElementById('retriaseSpo2TanpaO2').value = retriase.spo2_tanpa_o2 === '-' ? '' : retriase
                    .spo2_tanpa_o2;
                document.getElementById('retriaseSpo2DenganO2').value = retriase.spo2_dengan_o2 === '-' ? '' : retriase
                    .spo2_dengan_o2;
                document.getElementById('retriaseTdSistole').value = retriase.td_sistole === '-' ? '' : retriase
                    .td_sistole;
                document.getElementById('retriaseTdDiastole').value = retriase.td_diastole === '-' ? '' : retriase
                    .td_diastole;
                document.getElementById('retriaseKeluhan').value = retriase.keluhan === '-' ? '' : retriase.keluhan;
                document.getElementById('retriaseKesimpulanTriase').value = retriase.kesimpulan_triase === '-' ? '' :
                    retriase.kesimpulan_triase;

                editRetriaseIndex = index;
            }

            const modal = new bootstrap.Modal(document.getElementById('retriaseModal'));
            modal.show();
        }

        function deleteRetriase(index) {
            if (confirm('Apakah Anda yakin ingin menghapus data retriase ini?')) {
                retriaseArray.splice(index, 1);
                renderRetriaseTable();
                updateRetriaseJson();
            }
        }

        function updateRetriaseJson() {
            const retriaseDataInput = document.getElementById('retriaseData');
            if (retriaseDataInput) {
                retriaseDataInput.value = JSON.stringify(retriaseArray);
            }
        }

        function resetRetriaseModal() {
            document.getElementById('retriaseTanggal').value = new Date().toISOString().split('T')[0];
            document.getElementById('retriaseJam').value = new Date().toTimeString().slice(0, 5);
            document.getElementById('retriaseGCS').value = '';
            document.getElementById('retriaseTemp').value = '';
            document.getElementById('retriaseRR').value = '';
            document.getElementById('retriaseSpo2TanpaO2').value = '';
            document.getElementById('retriaseSpo2DenganO2').value = '';
            document.getElementById('retriaseTdSistole').value = '';
            document.getElementById('retriaseTdDiastole').value = '';
            document.getElementById('retriaseKeluhan').value = '';
            document.getElementById('retriaseKesimpulanTriase').value = '';

        }

        // Expose functions globally
        window.openRetriaseModal = openRetriaseModal;
        window.saveRetriase = saveRetriase;
        window.deleteRetriase = deleteRetriase;
    }

    function initGCSRetriaseCalculator() {
        const eyeInputs = document.querySelectorAll('input[name="gcsEyeRetriase"]');
        const verbalInputs = document.querySelectorAll('input[name="gcsVerbalRetriase"]');
        const motorInputs = document.querySelectorAll('input[name="gcsMotorRetriase"]');

        function calculateGCSRetriase() {
            const eyeScore = parseInt(document.querySelector('input[name="gcsEyeRetriase"]:checked')?.value || 0);
            const verbalScore = parseInt(document.querySelector('input[name="gcsVerbalRetriase"]:checked')?.value || 0);
            const motorScore = parseInt(document.querySelector('input[name="gcsMotorRetriase"]:checked')?.value || 0);

            const total = eyeScore + verbalScore + motorScore;

            document.getElementById('gcsRetriaseTotal').textContent = total;
            document.getElementById('gcsRetriaseDetail').textContent = `E${eyeScore} V${verbalScore} M${motorScore}`;
        }

        // Add event listeners
        [...eyeInputs, ...verbalInputs, ...motorInputs].forEach(input => {
            input.addEventListener('change', calculateGCSRetriase);
        });
    }

    function openGCSModalForRetriase() {
        const modal = new bootstrap.Modal(document.getElementById('gcsRetriaseModal'));
        modal.show();
    }

    function applyGCSToRetriase() {
        const total = document.getElementById('gcsRetriaseTotal').textContent;
        const detail = document.getElementById('gcsRetriaseDetail').textContent;

        if (total && total !== '0') {
            document.getElementById('retriaseGCS').value = `${total} ${detail}`;
            closeModal('gcsRetriaseModal');
        } else {
            showAlert('Mohon pilih nilai untuk semua komponen GCS');
        }
    }

    function showAlert(message) {
        alert(message);
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal && window.bootstrap) {
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) {
                modalInstance.hide();
            }
        }
    }
</script>

<style>
    .gcs-options {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 0.375rem;
        border: 1px solid #e9ecef;
    }

    .gcs-options .form-check {
        margin-bottom: 0.5rem;
    }

    .gcs-options .form-check:last-child {
        margin-bottom: 0;
    }

    .gcs-result {
        margin-top: 1rem;
    }

    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #retriaseTable td {
        vertical-align: middle;
    }

    .alert-info {
        background-color: #e7f3ff;
        border-color: #b8daff;
        color: #0c5460;
    }
</style>
