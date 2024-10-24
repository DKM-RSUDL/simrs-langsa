<div class="modal fade" id="modal-create-diagnosis" tabindex="-1" aria-labelledby="verticalCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="verticalCenterLabel">Input Diagnosis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <strong class="fw-bold">Tambah Diagnosis</strong>
                <p>
                    (Isi diagnosis pada kolom dibawah dan <span class="fw-bold">Tekan Enter</span> untuk menambah ke
                    daftar diagnosis. Satu baris untuk satu diagnosis )
                </p>
                <div class="dropdown">
                    <input type="text" class="form-control" id="searchDiagnosisInput" placeholder="Nama Diagnosis">
                </div>
                <div class="mt-2 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary mt-2" id="btnAddDiagnosis">Tambah</button>
                </div>

                <div class="mt-3">
                    <strong class="fw-bold">Daftar Diagnosis</strong>
                    <div class="bg-light p-3 border rounded">
                        <ol type="1" id="diagnosisList">
                            <!-- List of Diagnoses -->
                        </ol>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnSaveDiagnose" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
@include('unit-pelayanan.rawat-jalan.pelayanan.resume.resume-medis.components.modal-daftar-input-diagnosis')

<script>
    $('#btn-diagnosis').on('click', function() {
        $('#modal-create-diagnosis').modal('show');
    });

    let dataDiagnosis = @json($dataResume->diagnosis ?? []);
    // console.log(dataDiagnosis);

    $(document).ready(function() {
        function displayDiagnosis() {
            let diagnosisList = '';
            let diagnoseDisplay = '';

            if (dataDiagnosis && Array.isArray(dataDiagnosis)) {
                dataDiagnosis.forEach((diagnosis, index) => {
                    let uniqueId = 'diagnosis-' + index;

                    diagnosisList += `
                    <li class="list-group-item d-flex justify-content-between align-items-center" id="${uniqueId}">
                        <a href="javascript:void(0)" class="fw-bold edit-diagnosis" data-id="${uniqueId}">${diagnosis}</a>
                        <button type="button" class="btn btn-sm btn-danger remove-diagnosis mt-1" data-id="${uniqueId}">X</button>
                    </li>
                `;

                    diagnoseDisplay += `
                    <div class="d-flex justify-content-between align-items-center" id="main-${uniqueId}">
                        <a href="javascript:void(0)" class="fw-bold">${diagnosis}</a>
                        <button type="button" class="btn btn-sm btn-danger remove-main-diagnosis" data-id="${uniqueId}">X</button>
                    </div><br>
                `;
                });
            }

            $('#diagnosisList').html(diagnosisList);
            $('#diagnoseDisplay').html(diagnoseDisplay);
        }

        displayDiagnosis();

        $('#btn-diagnosis').on('click', function() {
            displayDiagnosis();
            $('#modal-create-diagnosis').modal('show');
        });

        $('#btnAddDiagnosis').click(function() {
            var diagnosis = $('#searchDiagnosisInput').val();

            if (diagnosis !== '') {
                dataDiagnosis.push(diagnosis);
                displayDiagnosis();
                $('#searchDiagnosisInput').val('');
            }
        });

        $(document).on('click', '.edit-diagnosis', function() {
            var diagnosisId = $(this).data('id');
            var index = diagnosisId.split('-')[1];
            var diagnosisText = dataDiagnosis[index];

            $('#editDiagnosisTextarea').val(diagnosisText);
            $('#editDiagnosisId').val(index);

            $('#modal-daftar-input-diagnosis').modal('show');
        });

        $('#btnUpdateDiagnosis').click(function() {
            var updatedDiagnosis = $('#editDiagnosisTextarea').val();
            var index = $('#editDiagnosisId').val();

            dataDiagnosis[index] = updatedDiagnosis;
            displayDiagnosis();

            $('#modal-daftar-input-diagnosis').modal('hide');
        });

        $(document).on('click', '.remove-diagnosis, .remove-main-diagnosis', function() {
            var diagnosisId = $(this).data('id');
            var index = diagnosisId.split('-')[1];

            dataDiagnosis.splice(index, 1);
            displayDiagnosis();
        });

        $('#btnSaveDiagnose').click(function() {
            displayDiagnosis();
            $('#modal-create-diagnosis').modal('hide');
        });
    });
</script>
