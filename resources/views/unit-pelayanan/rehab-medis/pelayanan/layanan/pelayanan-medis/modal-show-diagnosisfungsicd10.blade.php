<div class="modal fade" id="modal-diagnosis-fungsi-icd10" tabindex="-1" aria-labelledby="verticalCenterLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="verticalCenterLabel">Input Diagnosis Fungsi ICD 10</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong class="fw-bold">Tambah Diagnosis Fungsi ICD 10</strong>
                    <div class="input-group mt-2">
                        <input type="text" class="form-control" id="searchDiagnosisInputFungsi"
                            placeholder="Diagnosis Fungsi ICD 10">
                        <button type="button" class="btn btn-primary" id="btnAddDiagnosisFungsi">
                            Tambah
                        </button>
                    </div>
                </div>

                <div class="mt-3">
                    <strong class="fw-bold">Daftar Diagnosis Fungsi ICD 10</strong>
                    <div class="bg-light p-2 border rounded mt-2" style="max-height: 300px; overflow-y: auto;">
                        <ol type="1" id="diagnosisListFungsi" class="list-group list-group-flush"></ol>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="btnSaveDiagnoseFungsi" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#btn-diagnosis-fungsi-icd10').on('click', function() {
            $('#modal-diagnosis-fungsi-icd10').modal('show');
        });

        $(document).ready(function() {
            // Initialize dataDiagnosisFungsi from server data or empty array
            let dataDiagnosisFungsi = @json($layanan->diagnosis_fungsi ?? []);

            // Function to display function diagnoses in both modal and main view
            // Function to display function diagnoses in both modal and main view
            function displayDiagnosisFungsi() {
                let diagnosisList = '';
                let diagnoseDisplay = '';

                dataDiagnosisFungsi.forEach((diagnosis, index) => {
                    const uniqueId = `diagnosis-fungsi-${index}`;

                    // Modal list item
                    diagnosisList += `
                <li class="list-group-item d-flex justify-content-between align-items-center" id="${uniqueId}">
                    <span class="diagnosis-text">${diagnosis}</span>
                    <div>
                        <a href="javascript:void(0)" class="edit-diagnosis-fungsi me-2" data-id="${uniqueId}">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="javascript:void(0)" class="remove-diagnosis-fungsi text-danger" data-id="${uniqueId}">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </li>
            `;

                    // Main view display
                    diagnoseDisplay += `
                <div class="d-flex justify-content-between align-items-center mb-2" id="main-${uniqueId}">
                    <span class="diagnosis-text">${diagnosis}</span>
                        <input type="hidden" name="diagnosis_fungsi[]" value="${diagnosis}">
                </div>
            `;
                });

                $('#diagnosisListFungsi').html(diagnosisList ||
                    '<p class="text-muted text-center my-3">Belum ada diagnosis fungsi</p>');
                $('#diagnoseDisplayFungsi').html(diagnoseDisplay ||
                    '<p class="text-muted text-center my-3">Belum ada diagnosis fungsi</p>');
            }

            // Open main modal
            $('#btn-diagnosis-fungsi-icd10').on('click', function() {
                displayDiagnosisFungsi();
                $('#modal-diagnosis-fungsi-icd10').modal('show');
            });

            // Add new diagnosis
            $('#btnAddDiagnosisFungsi').click(function() {
                const diagnosis = $('#searchDiagnosisInputFungsi').val().trim();

                if (diagnosis) {
                    dataDiagnosisFungsi.push(diagnosis);
                    displayDiagnosisFungsi();
                    $('#searchDiagnosisInputFungsi').val('').focus();
                }
            });

            // Enter key handling for input
            $('#searchDiagnosisInputFungsi').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#btnAddDiagnosisFungsi').click();
                }
            });

            // Edit diagnosis
            $(document).on('click', '.edit-diagnosis-fungsi', function() {
                const diagnosisId = $(this).data('id');
                const index = parseInt(diagnosisId.split('-')[2]);

                $('#editDiagnosisTextareaFungsi').val(dataDiagnosisFungsi[index]);
                $('#editDiagnosisIdFungsi').val(index);
                $('#modal-edit-diagnosis-fungsi').modal('show');
            });

            // Update diagnosis
            $('#btnUpdateDiagnosisFungsi').click(function() {
                const updatedDiagnosis = $('#editDiagnosisTextareaFungsi').val().trim();
                const index = parseInt($('#editDiagnosisIdFungsi').val());

                if (updatedDiagnosis) {
                    dataDiagnosisFungsi[index] = updatedDiagnosis;
                    displayDiagnosisFungsi();
                    $('#modal-edit-diagnosis-fungsi').modal('hide');
                }
            });

            // Remove diagnosis
            $(document).on('click', '.remove-diagnosis-fungsi, .remove-main-diagnosis-fungsi', function() {
                if (confirm('Apakah Anda yakin ingin menghapus diagnosis fungsi ini?')) {
                    const diagnosisId = $(this).data('id');
                    const index = parseInt(diagnosisId.split('-')[2]);

                    dataDiagnosisFungsi.splice(index, 1);
                    displayDiagnosisFungsi();
                }
            });

            // Save diagnosis fungsi
            $('#btnSaveDiagnoseFungsi').click(function() {
                displayDiagnosisFungsi();
                $('#modal-diagnosis-fungsi-icd10').modal('hide');
            });

            // Initial display
            displayDiagnosisFungsi();
        });
    </script>
@endpush
