<div class="modal fade" id="modal-input-diagnosis" tabindex="-1" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallModalLabel">Input Diagnosa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" name="" rows="3">HYPERTENSI KRONIS</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary">Ganti</button>
                <button type="button" class="btn btn-sm btn-primary">Hapus</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#btn-input-diagnosis').on('click', function() {
            $('#modal-input-diagnosis').modal('show');
        });
    </script>
@endpush
