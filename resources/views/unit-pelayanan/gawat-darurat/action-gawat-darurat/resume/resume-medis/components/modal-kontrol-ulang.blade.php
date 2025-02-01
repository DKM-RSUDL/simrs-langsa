<div class="modal fade" id="modal-create-kontrol-ulang" tabindex="-1" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallModalLabel">Kontrol Ulang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="kontrol-ulang" class="form-label">Tanggal Kontrol</label>
                <input type="date" class="form-control flatpickr" id="kontrol-ulang" name="tgl_kontrol_ulang"
                    value="{{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '2' ? $dataResume->rmeResumeDet->tgl_kontrol_ulang : '' }}"
                    min="{{ date('Y-m-d') }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" id="btn-simpan-kontrol">Simpan</button>
            </div>
        </div>
    </div>
</div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            const savedDate = $('#kontrol-ulang').val();
            if (savedDate) {
                $('#selected-date').text(savedDate);
            }

            // Handler modal
            $('#btn-tgl-kontrol-ulang').on('click', function(e) {
                e.preventDefault();
                $(this).find('input[type="radio"]').prop('checked', true);
                $('#modal-create-kontrol-ulang').modal('show');
            });

            // Handler tombol simpan
            $('#btn-simpan-kontrol').on('click', function() {
                const selectedDate = $('#kontrol-ulang').val();
                if (selectedDate) {
                    $('#selected-date').text(selectedDate);
                    $('#kontrol').val('Kontrol ulang, tgl: ' + selectedDate);
                    $('#modal-create-kontrol-ulang').modal('hide');
                } else {
                    alert('Silahkan pilih tanggal kontrol');
                }
            });

            // Handler modal ditutup
            $('#modal-create-kontrol-ulang').on('hidden.bs.modal', function() {
                if (!$('#selected-date').text()) {
                    $('#kontrol').prop('checked', false);
                }
            });
        });
    </script>
@endpush
