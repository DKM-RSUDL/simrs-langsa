<div class="modal fade" id="modal-daftar-input-diagnosis" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editModalLabel">Edit Diagnosis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="editDiagnosisTextarea" class="form-label">Diagnosis Medis ICD 10</label>
                    <textarea class="form-control" id="editDiagnosisTextarea" rows="3"></textarea>
                    <input type="hidden" id="editDiagnosisId">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btnUpdateDiagnosis" class="btn btn-primary">Perbarui</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#btn-daftar-input-diagnosis').on('click', function() {
        $('#modal-daftar-input-diagnosis').modal('show');
    });
</script>
