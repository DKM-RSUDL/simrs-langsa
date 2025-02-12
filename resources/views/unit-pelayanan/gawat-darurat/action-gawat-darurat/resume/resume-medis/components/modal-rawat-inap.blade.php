<!-- Modal Menolak Rawat Inap -->
<div class="modal fade" id="modal-menolak-rawat-inap" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Menolak Rawat Inap</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="alasan-menolak" class="form-label">Alasan Menolak</label>
                <textarea class="form-control" id="alasan-menolak" name="alasan_menolak_inap" rows="3"
                    placeholder="Masukkan alasan menolak rawat inap">{{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '9' ? $dataResume->rmeResumeDet->alasan_menolak : '' }}</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-simpan-menolak">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            // Inisialisasi nilai yang sudah ada
            const savedAlasanMenolak = $('#alasan-menolak').val();

            // Update span di modal utama jika ada data tersimpan
            if (savedAlasanMenolak) {
                updateMenolakDisplay(savedAlasanMenolak);
            }

            // Handler untuk membuka modal
            $('#btn-menolak-rawat-inap').on('click', function(e) {
                e.preventDefault();
                // Check radio button
                $('#menolak-rawat-inap-radio').prop('checked', true);
                // Tampilkan modal
                $('#modal-menolak-rawat-inap').modal('show');
            });

            // Handler untuk tombol simpan
            $('#btn-simpan-menolak').on('click', function() {
                const selectedAlasan = $('#alasan-menolak').val().trim();

                if (selectedAlasan) {
                    updateMenolakDisplay(selectedAlasan);
                    $('#modal-menolak-rawat-inap').modal('hide');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Error',
                        text: 'Silahkan isi alasan menolak rawat inap'
                    });
                }
            });

            // Fungsi untuk update tampilan menolak rawat inap
            function updateMenolakDisplay(alasan) {
                // Update span di modal utama
                $('#selected-menolak-info').text(`(${alasan})`);
                // Update value radio button
                $('#menolak-rawat-inap-radio').val(`Menolak Rawat Inap: ${alasan}`);
                // Check radio button
                $('#menolak-rawat-inap-radio').prop('checked', true);
            }

            // Handler untuk reset form saat modal ditutup
            $('#modal-menolak-rawat-inap').on('hidden.bs.modal', function() {
                if (!$('#selected-menolak-info').text()) {
                    $('#menolak-rawat-inap-radio').prop('checked', false);
                }
            });

            // Validasi panjang alasan
            $('#alasan-menolak').on('input', function() {
                const maxLength = 255;
                const currentLength = $(this).val().length;

                if (currentLength > maxLength) {
                    $(this).val($(this).val().substring(0, maxLength));
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: `Maksimal ${maxLength} karakter`
                    });
                }
            });
        });
    </script>
@endpush
