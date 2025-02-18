<div class="modal fade" id="modal-meninggal-dunia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Meninggal Dunia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="tgl-meninggal" class="form-label">Tanggal Meninggal</label>
                        <input type="date" class="form-control" id="tgl-meninggal" name="tgl_meninggal"
                            value="{{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '10' ? $dataResume->rmeResumeDet->tgl_meninggal : '' }}">
                    </div>
                    <div class="col-md-6">
                        <label for="jam-meninggal" class="form-label">Jam Meninggal</label>
                        <input type="time" class="form-control" id="jam-meninggal" name="jam_meninggal"
                            value="{{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '10' ? $dataResume->rmeResumeDet->jam_meninggal : '' }}">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-simpan-meninggal">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            // Inisialisasi nilai yang sudah ada
            const savedTglMeninggal = $('#tgl-meninggal').val();
            const savedJamMeninggal = $('#jam-meninggal').val();

            // Update span di modal utama jika ada data tersimpan
            if (savedTglMeninggal && savedJamMeninggal) {
                updateMeninggalDisplay(savedTglMeninggal, savedJamMeninggal);
            }

            // Handler untuk membuka modal
            $('#btn-meninggal-dunia').on('click', function(e) {
                e.preventDefault();
                // Check radio button
                $('#meninggal-dunia-radio').prop('checked', true);
                // Tampilkan modal
                $('#modal-meninggal-dunia').modal('show');
            });

            // Handler untuk tombol simpan
            $('#btn-simpan-meninggal').on('click', function() {
                const selectedTgl = $('#tgl-meninggal').val();
                const selectedJam = $('#jam-meninggal').val();

                if (selectedTgl && selectedJam) {
                    updateMeninggalDisplay(selectedTgl, selectedJam);
                    $('#modal-meninggal-dunia').modal('hide');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Error',
                        text: 'Silahkan lengkapi tanggal dan jam meninggal'
                    });
                }
            });

            // Fungsi untuk update tampilan meninggal dunia
            function updateMeninggalDisplay(tanggal, jam) {
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
                $('#selected-meninggal-info').text(`(${formattedDate} ${formattedTime})`);
                // Update value radio button
                $('#meninggal-dunia-radio').val(`Meninggal Dunia: ${formattedDate} ${formattedTime}`);
                // Check radio button
                $('#meninggal-dunia-radio').prop('checked', true);
            }

            // Handler untuk reset form saat modal ditutup
            $('#modal-meninggal-dunia').on('hidden.bs.modal', function() {
                if (!$('#selected-meninggal-info').text()) {
                    $('#meninggal-dunia-radio').prop('checked', false);
                }
            });

            // Validasi tanggal dan jam
            $('#tgl-meninggal, #jam-meninggal').on('change', function() {
                const selectedDate = new Date($('#tgl-meninggal').val());
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
