<div class="modal fade" id="modal-edit-tatalaksana" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editModalLabel">Edit Tatalaksana KFR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="editTatalaksanaTextarea" class="form-label">Tatalaksana KFR (ICD-9 CM)</label>
                    <textarea class="form-control" id="editTatalaksanaTextarea" rows="3"></textarea>
                    <input type="hidden" id="editTatalaksanaId">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btnUpdateTatalaksana" class="btn btn-primary">Perbarui</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#btn-edit-tatalaksana').on('click', function() {
        $('#modal-edit-tatalaksana').modal('show');
    });
</script>
