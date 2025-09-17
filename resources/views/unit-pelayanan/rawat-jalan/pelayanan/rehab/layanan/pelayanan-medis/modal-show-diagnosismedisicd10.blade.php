<div class="modal fade" id="modal-diagnosis-medis-icd10" tabindex="-1" aria-labelledby="verticalCenterLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="verticalCenterLabel">Input Diagnosis Medis ICD 10</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong class="fw-bold">Tambah Diagnosis Medis ICD 10</strong>
                    <div class="input-group mt-2">
                        <input type="text" class="form-control" id="searchDiagnosisInput"
                            placeholder="Diagnosis Medis ICD 10">
                        <button type="button" class="btn btn-primary" id="btnAddDiagnosis">
                            <i class="bi bi-plus"></i> Tambah
                        </button>
                    </div>
                </div>

                <div class="mt-3">
                    <strong class="fw-bold">Daftar Diagnosis Medis ICD 10</strong>
                    <div class="bg-light p-2 border rounded mt-2" style="max-height: 300px; overflow-y: auto;">
                        <ol type="1" id="diagnosisList" class="list-group list-group-flush"></ol>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="btnSaveDiagnose" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#btn-diagnosis-medis-icd10').on('click', function() {
            $('#modal-diagnosis-medis-icd10').modal('show');
        });

        $(document).ready(function() {
            // Initialize dataDiagnosis from server data or empty array
            let dataDiagnosis = @json($layanan->diagnosis_medis ?? []);

            // Function to display diagnoses in both modal and main view
            function displayDiagnosis() {
                let diagnosisList = '';
                let diagnoseDisplay = '';

                if (dataDiagnosis && Array.isArray(dataDiagnosis)) {
                    dataDiagnosis.forEach((diagnosis, index) => {
                        const uniqueId = `diagnosis-${index}`;

                        // Modal list item
                        diagnosisList += `
                        <li class="list-group-item d-flex justify-content-between align-items-center" id="${uniqueId}">
                            <span class="diagnosis-text">${diagnosis}</span>
                            <div>
                                <a href="javascript:void(0)" class="edit-diagnosis me-2" data-id="${uniqueId}">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" class="remove-diagnosis text-danger" data-id="${uniqueId}">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </li>
                    `;

                        // Main view display
                        diagnoseDisplay += `
                        <div class="d-flex justify-content-between align-items-center mb-2" id="main-${uniqueId}">
                            <span class="diagnosis-text">${diagnosis}</span>
                            <input type="hidden" name="diagnosis_medis[]" value="${diagnosis}">
                        </div>
                    `;
                    });
                }

                $('#diagnosisList').html(diagnosisList ||
                    '<p class="text-muted text-center my-3">Belum ada diagnosis Medis</p>');
                $('#diagnoseDisplay').html(diagnoseDisplay ||
                    '<p class="text-muted text-center my-3">Belum ada diagnosis Medis</p>');
            }

            // Open main modal
            $('#btn-diagnosis-medis-icd10').on('click', function() {
                displayDiagnosis();
                $('#modal-diagnosis-medis-icd10').modal('show');
            });

            // Add new diagnosis
            $('#btnAddDiagnosis').click(function() {
                const diagnosis = $('#searchDiagnosisInput').val().trim();

                if (diagnosis) {
                    dataDiagnosis.push(diagnosis);
                    displayDiagnosis();
                    $('#searchDiagnosisInput').val('').focus();
                }
            });

            // Enter key handling for input
            $('#searchDiagnosisInput').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btnAddDiagnosis').click();
                }
            });

            // Edit diagnosis
            $(document).on('click', '.edit-diagnosis', function() {
                const diagnosisId = $(this).data('id');
                const index = parseInt(diagnosisId.split('-')[1]);

                $('#editDiagnosisTextarea').val(dataDiagnosis[index]);
                $('#editDiagnosisId').val(index);
                $('#modal-daftar-input-diagnosis').modal('show');
            });

            // Update diagnosis
            $('#btnUpdateDiagnosis').click(function() {
                const updatedDiagnosis = $('#editDiagnosisTextarea').val().trim();
                const index = parseInt($('#editDiagnosisId').val());

                if (updatedDiagnosis) {
                    dataDiagnosis[index] = updatedDiagnosis;
                    displayDiagnosis();
                    $('#modal-daftar-input-diagnosis').modal('hide');
                }
            });

            // Remove diagnosis
            $(document).on('click', '.remove-diagnosis, .remove-main-diagnosis', function() {
                if (confirm('Apakah Anda yakin ingin menghapus diagnosis ini?')) {
                    const diagnosisId = $(this).data('id');
                    const index = parseInt(diagnosisId.split('-')[1]);

                    dataDiagnosis.splice(index, 1);
                    displayDiagnosis();
                }
            });

            // Save diagnosis
            $('#btnSaveDiagnose').click(function() {
                displayDiagnosis();
                $('#modal-diagnosis-medis-icd10').modal('hide');
            });

            // Initial display
            displayDiagnosis();
        });
    </script>
@endpush
