<!-- Modal for Diagnoses (Penyakit yang Pernah Diderita) -->
<div class="modal fade" id="modal-diagnosis-diderita" tabindex="-1" aria-labelledby="diagnosisDideritaLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="diagnosisDideritaLabel">Riwayat Penyakit yang Pernah Diderita</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="searchDiagnosisInputDiderita" class="form-label fw-bold">Tambah Penyakit</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchDiagnosisInputDiderita"
                            placeholder="Masukkan nama penyakit">
                        <button class="btn btn-primary" type="button" id="btnAddDiagnosisDiderita">
                            <i class="bi bi-plus"></i> Tambah
                        </button>
                    </div>
                </div>

                <div class="mt-3">
                    <strong class="fw-bold mb-2 d-block">Daftar Penyakit</strong>
                    <div class="bg-light p-3 border rounded diagnosis-container">
                        <div id="diagnosisListDiderita" class="diagnosis-list-diderita">
                            <!-- Diagnosis list will be dynamically populated here -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="btnSaveDiagnosisDiderita" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Specific Diagnosis -->
<div class="modal fade" id="modal-edit-diagnosis-diderita" tabindex="-1" aria-labelledby="editDiagnosisLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editDiagnosisLabel">Edit Penyakit</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="editDiagnosisInput" class="form-label fw-bold">Nama Penyakit</label>
                    <input type="text" class="form-control" id="editDiagnosisInput">
                    <input type="hidden" id="editDiagnosisIndex">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btnUpdateDiagnosisDiderita" class="btn btn-primary">Perbarui</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        function safeParseJson(value, defaultValue = []) {
            if (Array.isArray(value)) return value;

            if (typeof value === 'string') {
                try {
                    const parsed = JSON.parse(value);
                    return Array.isArray(parsed) ? parsed : defaultValue;
                } catch (error) {
                    console.error('Error parsing diagnosis JSON:', error);
                    return defaultValue;
                }
            }

            return defaultValue;
        }

        // Initialize diagnoses from the database
        let diagnosisDiderita = safeParseJson(
            @json($asesmen->rmeAsesmenThtRiwayatKesehatanObatAlergi[0]['riwayat_kesehatan_penyakit_diderita'] ?? [])
        );

        function removeDuplicates(arr) {
            return Array.from(new Set(arr.filter(item => item && item.trim() !== '')));
        }

        // Function to render diagnosis list
        function renderDiagnosisDiderita() {
            diagnosisDiderita = removeDuplicates(diagnosisDiderita);

            const diagnosisList = $('#diagnosisListDiderita');
            const displayList = $('#diagnosisListDisplay');
            diagnosisList.empty();
            displayList.empty();

            // Populate lists with current diagnoses
            diagnosisDiderita.forEach((diagnosis, index) => {
                const diagnosisItem = $(`
                    <div class="d-flex justify-content-between align-items-center mb-2 diagnosis-item" data-index="${index}" data-diagnosis="${diagnosis}">
                        <div class="d-flex align-items-center">
                            <span class="diagnosis-drag-handle me-2" style="cursor: move;">
                                <i class="bi bi-grip-vertical"></i>
                            </span>
                            <span class="diagnosis-text">${diagnosis}</span>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary me-2 edit-diagnosis" data-index="${index}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger remove-diagnosis" data-index="${index}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                `);
                diagnosisList.append(diagnosisItem);

                const displayItem = $(`
                    <div class="diagnosis-display-item mb-2 d-flex justify-content-between align-items-center" data-diagnosis="${diagnosis}">
                        <div class="d-flex align-items-center w-100">
                            <span class="diagnosis-drag-handle me-2" style="cursor: move;">
                                <i class="bi bi-grip-vertical"></i>
                            </span>
                            <span class="flex-grow-1">${diagnosis}</span>
                        </div>
                    </div>
                `);
                displayList.append(displayItem);
            });

            $('#diagnosisDataDiderit').val(JSON.stringify(diagnosisDiderita));

            initializeSortable();
        }

        // Initialize Sortable for drag and drop
        function initializeSortable() {
            if (window.diagnosisDideritaSortableModal) {
                window.diagnosisDideritaSortableModal.destroy();
            }
            if (window.diagnosisDideritaSortableDisplay) {
                window.diagnosisDideritaSortableDisplay.destroy();
            }

            // Sortable for modal list
            const modalList = document.getElementById('diagnosisListDiderita');
            if (modalList && window.Sortable) {
                window.diagnosisDideritaSortableModal = new Sortable(modalList, {
                    animation: 150,
                    handle: '.diagnosis-drag-handle',
                    onEnd: function (evt) {
                        const newOrder = [];
                        $('#diagnosisListDiderita .diagnosis-item').each(function () {
                            const diagnosis = $(this).data('diagnosis');
                            if (diagnosis && !newOrder.includes(diagnosis)) {
                                newOrder.push(diagnosis);
                            }
                        });

                        diagnosisDiderita = newOrder;
                        renderDiagnosisDiderita();
                    }
                });
            }

            // Sortable for display list
            const displayList = document.getElementById('diagnosisListDisplay');
            if (displayList && window.Sortable) {
                window.diagnosisDideritaSortableDisplay = new Sortable(displayList, {
                    animation: 150,
                    handle: '.diagnosis-drag-handle',
                    onEnd: function (evt) {
                        const newOrder = [];
                        $('#diagnosisListDisplay .diagnosis-display-item').each(function () {
                            const diagnosis = $(this).data('diagnosis');
                            if (diagnosis && !newOrder.includes(diagnosis)) {
                                newOrder.push(diagnosis);
                            }
                        });

                        diagnosisDiderita = newOrder;
                        renderDiagnosisDiderita();
                    }
                });
            }
        }        

        // Open modal to add/edit diagnoses
        $('#btn-diagnosis-diderit').on('click', function () {
            renderDiagnosisDiderita();
            $('#modal-diagnosis-diderita').modal('show');
        });

        // Add new diagnosis
        $('#btnAddDiagnosisDiderita').on('click', function () {
            const newDiagnosis = $('#searchDiagnosisInputDiderita').val().trim();
            if (newDiagnosis) {
                if (!diagnosisDiderita.some(d => d.toLowerCase() === newDiagnosis.toLowerCase())) {
                    diagnosisDiderita.push(newDiagnosis);
                    renderDiagnosisDiderita();
                    $('#searchDiagnosisInputDiderita').val('');
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Penyakit sudah ada dalam daftar',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            }
        });

        // Handle Enter key for adding diagnosis
        $('#searchDiagnosisInputDiderita').on('keypress', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#btnAddDiagnosisDiderita').click();
            }
        });

        // Open edit diagnosis modal
        $(document).on('click', '.edit-diagnosis', function () {
            const index = $(this).data('index');
            const diagnosis = diagnosisDiderita[index];

            $('#editDiagnosisInput').val(diagnosis);
            $('#editDiagnosisIndex').val(index);
            $('#modal-edit-diagnosis-diderita').modal('show');
        });

        // Update diagnosis
        $('#btnUpdateDiagnosisDiderita').on('click', function () {
            const index = $('#editDiagnosisIndex').val();
            const updatedDiagnosis = $('#editDiagnosisInput').val().trim();

            if (updatedDiagnosis) {
                const duplicateIndex = diagnosisDiderita.findIndex(
                    (d, i) => d.toLowerCase() === updatedDiagnosis.toLowerCase() && i !== parseInt(index)
                );

                if (duplicateIndex === -1) {
                    diagnosisDiderita[index] = updatedDiagnosis;
                    renderDiagnosisDiderita();
                    $('#modal-edit-diagnosis-diderita').modal('hide');
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Penyakit sudah ada dalam daftar',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            }
        });

        // Remove diagnosis
        $(document).on('click', '.remove-diagnosis', function () {
            const index = $(this).data('index');
            diagnosisDiderita.splice(index, 1);
            renderDiagnosisDiderita();
        });

        // Save diagnoses
        $('#btnSaveDiagnosisDiderita').on('click', function () {
            diagnosisDiderita = removeDuplicates(diagnosisDiderita);
            renderDiagnosisDiderita();
            $('#modal-diagnosis-diderita').modal('hide');
        });

        renderDiagnosisDiderita();
    });
</script>