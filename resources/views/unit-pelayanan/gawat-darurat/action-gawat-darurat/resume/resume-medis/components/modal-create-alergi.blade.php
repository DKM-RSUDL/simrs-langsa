<div class="modal fade" id="modal-create-alergi" tabindex="-1" aria-labelledby="smallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallModalLabel">Input ALERGI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="elergi" class="form-label">Input ALERGI</label>
                <input class="form-control" id="elergi" name=""></input>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"
                aria-label="Close">Close</button>
                <button type="button" class="btn btn-sm btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    //button create post event
    $('#btn-create-alergi').on('click', function() {

        //open modal
        $('#modal-create-alergi').modal('show');
    });
</script>
