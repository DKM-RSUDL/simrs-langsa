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
                <textarea class="form-control" rows="3"></textarea>
                <div class="mt-2 d-flex justify-content-end">
                    <button type="submit" class="btn btn-sm btn-primary">Tambah/Enter</button>
                </div>

                <div class="mt-3">
                    <strong class="fw-bold">Daftar Diagnosis</strong>
                    <div class="bg-light p-3 border rounded">
                        <a href="javascript:void(0)" id="btn-daftar-input-diagnosis" class="fw-bold">HYPERTENSI KRONIS</a> <br>
                        <a href="#" class="fw-bold">DYSPEPSIA</a> <br>
                        <a href="#" class="fw-bold">DEPRESIVE EPISODE</a> <br>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary">Simpan</button>
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
</script>
