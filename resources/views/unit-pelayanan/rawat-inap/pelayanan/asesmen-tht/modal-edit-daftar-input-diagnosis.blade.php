<div class="modal fade" id="modal-daftar-input-diagnosis" tabindex="-1" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallModalLabel">Edit Diagnosis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" id="editDiagnosisTextarea" rows="3"></textarea>
                <input type="hidden" id="editDiagnosisId"> <!-- This will store the diagnosis ID -->
            </div>
            <div class="modal-footer">
                <button type="button" id="btnUpdateDiagnosis" class="btn btn-sm btn-primary">Ganti</button>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>


@push('js')
    <script>
        $('#btn-daftar-input-diagnosis').on('click', function() {
            $('#modal-daftar-input-diagnosis').modal('show');
        });
    </script>
@endpush
