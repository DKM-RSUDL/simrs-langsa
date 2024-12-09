<div class="modal fade" id="modal-edit-diagnosis-fungsi" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editModalLabel">Edit Diagnosis Fungsi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="editDiagnosisTextareaFungsi" class="form-label">Diagnosis Fungsi ICD 10</label>
                    <textarea class="form-control" id="editDiagnosisTextareaFungsi" rows="3"></textarea>
                    <input type="hidden" id="editDiagnosisIdFungsi">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btnUpdateDiagnosisFungsi" class="btn btn-primary">Perbarui</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#btn-edit-diagnosis-fungsi').on('click', function() {
        $('#modal-edit-diagnosis-fungsi').modal('show');
    });
</script>
