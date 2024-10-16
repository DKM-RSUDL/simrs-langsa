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
                        {{-- <a href="javascript:void(0)" id="btn-daftar-input-diagnosis" class="fw-bold">HYPERTENSI
                            KRONIS</a> <br>
                        <a href="#" class="fw-bold">DYSPEPSIA</a> <br>
                        <a href="#" class="fw-bold">DEPRESIVE EPISODE</a> <br> --}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-sm btn-primary">Simpan</button> --}}
                <button type="button" id="btnSaveDiagnose" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-daftar-input-diagnosis')

<script>
    //button create post event
    $('#btn-diagnosis').on('click', function() {

        //open modal
        $('#modal-create-diagnosis').modal('show');
    });

    $(document).ready(function() {
    // Add diagnosis ke modal 2
    $('#btnAddDiagnosis').click(function() {
        var diagnosis = $('#searchDiagnosisInput').val();

        if (diagnosis !== '') {
            var uniqueId = 'diagnosis-' + Math.random().toString(36).substr(2, 9); // Generate unique ID
            $('#diagnosisList').append(`
                <li class="list-group-item d-flex justify-content-between align-items-center" id="${uniqueId}">
                    <a href="javascript:void(0)" class="fw-bold edit-diagnosis" data-id="${uniqueId}">${diagnosis}</a>
                    <button type="button" class="btn btn-sm btn-danger remove-diagnosis mt-1" data-id="${uniqueId}">X</button>
                </li>
            `);
            $('#searchDiagnosisInput').val('');
        }
    });

    // Open edit modal edit diagnosis
    $(document).on('click', '.edit-diagnosis', function() {
        var diagnosisText = $(this).text(); // Get  text
        var diagnosisId = $(this).data('id'); // Get ID

        $('#editDiagnosisTextarea').val(diagnosisText);
        $('#editDiagnosisId').val(diagnosisId);

        $('#modal-daftar-input-diagnosis').modal('show');
    });

    // Save edit diagnosis
    $('#btnUpdateDiagnosis').click(function() {
        var updatedDiagnosis = $('#editDiagnosisTextarea').val(); // Get text
        var diagnosisId = $('#editDiagnosisId').val(); // Get ID edit

        // Update diagnosismodal 2 dan modal 1
        $('#' + diagnosisId + ' .edit-diagnosis').text(updatedDiagnosis); // Update di modal 2
        $('#main-' + diagnosisId + ' .fw-bold').text(updatedDiagnosis); // Update di modal 1

        // Close edit modal
        $('#modal-daftar-input-diagnosis').modal('hide');
    });

    // Remove diagnosis list di modal 2
    $(document).on('click', '.remove-diagnosis', function() {
        var diagnosisId = $(this).data('id');
        $('#' + diagnosisId).remove();
        $('#main-' + diagnosisId).remove();
    });

    // Save diagnosis dan transfer modal 1
    $('#btnSaveDiagnose').click(function() {
        var diagnosisList = '';
        let diagnoses = $('#diagnosisList li');

        // Loop all diagnoses di modal 2
        $(diagnoses).each(function(i, e) {
            var diagnosisText = $(e).find('.edit-diagnosis').text().trim();
            var diagnosisId = $(e).attr('id');

            diagnosisList += `
                <div class="d-flex justify-content-between align-items-center" id="main-${diagnosisId}">
                    <a href="javascript:void(0)" class="fw-bold">${diagnosisText}</a>
                    <button type="button" class="btn btn-sm btn-danger remove-main-diagnosis" data-id="${diagnosisId}">X</button>
                </div><br>
            `;
        });

        // Transfer diagnosis list modal 1
        $('#diagnoseDisplay').html(diagnosisList);

        $('#modal-create-diagnosis').modal('hide');
    });

    // Remove diagnosis modal 1
    $(document).on('click', '.remove-main-diagnosis', function() {
        var diagnosisId = $(this).data('id');
        $('#main-' + diagnosisId).remove(); // Remove di modal 1
        $('#' + diagnosisId).remove(); // Remove di modal 2
    });
});

</script>
