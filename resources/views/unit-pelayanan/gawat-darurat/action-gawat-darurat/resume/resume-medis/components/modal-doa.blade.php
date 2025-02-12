<!-- Modal DOA -->
<div class="modal fade" id="modal-doa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">DOA (Death on Arrival)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="tgl-meninggal-doa" class="form-label">Tanggal Meninggal</label>
                        <input type="date" class="form-control" id="tgl-meninggal-doa" name="tgl_meninggal_doa"
                            value="{{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '11' ? $dataResume->rmeResumeDet->tgl_meninggal_doa : '' }}">
                    </div>
                    <div class="col-md-6">
                        <label for="jam-meninggal-doa" class="form-label">Jam Meninggal</label>
                        <input type="time" class="form-control" id="jam-meninggal-doa" name="jam_meninggal_doa"
                            value="{{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '11' ? $dataResume->rmeResumeDet->jam_meninggal_doa : '' }}">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-simpan-doa">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        // Inisialisasi nilai yang sudah ada
        const savedTglDoa = $('#tgl-meninggal-doa').val();
        const savedJamDoa = $('#jam-meninggal-doa').val();

        // Update span di modal utama jika ada data tersimpan
        if (savedTglDoa && savedJamDoa) {
            updateDoaDisplay(savedTglDoa, savedJamDoa);
        }

        // Handler untuk membuka modal
        $('#btn-doa').on('click', function(e) {
            e.preventDefault();
            // Check radio button
            $('#doa-radio').prop('checked', true);
            // Tampilkan modal
            $('#modal-doa').modal('show');
        });

        // Handler untuk tombol simpan
        $('#btn-simpan-doa').on('click', function() {
            const selectedTgl = $('#tgl-meninggal-doa').val();
            const selectedJam = $('#jam-meninggal-doa').val();

            if (selectedTgl && selectedJam) {
                updateDoaDisplay(selectedTgl, selectedJam);
                $('#modal-doa').modal('hide');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Error',
                    text: 'Silahkan lengkapi tanggal dan jam meninggal'
                });
            }
        });

        // Fungsi untuk update tampilan DOA
        function updateDoaDisplay(tanggal, jam) {
            // Format tanggal untuk display
            const formattedDate = new Date(tanggal).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            // Format jam
            const formattedTime = new Date(`2000-01-01T${jam}`).toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });

            // Update span di modal utama
            $('#selected-doa-info').text(`(${formattedDate} ${formattedTime})`).removeAttr('hidden');
            // Update value radio button
            $('#doa-radio').val(`DOA (Death on Arrival): ${formattedDate} ${formattedTime}`);
            // Check radio button
            $('#doa-radio').prop('checked', true);
        }

        // Handler untuk reset form saat modal ditutup
        $('#modal-doa').on('hidden.bs.modal', function() {
            if (!$('#selected-doa-info').text()) {
                $('#doa-radio').prop('checked', false);
            }
        });

        // Validasi tanggal dan jam
        $('#tgl-meninggal-doa, #jam-meninggal-doa').on('change', function() {
            const selectedDate = new Date($('#tgl-meninggal-doa').val());
            const now = new Date();

            if (selectedDate > now) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Error',
                    text: 'Tanggal tidak boleh lebih dari hari ini'
                });
                $(this).val('');
            }
        });
    });
</script>
@endpush
