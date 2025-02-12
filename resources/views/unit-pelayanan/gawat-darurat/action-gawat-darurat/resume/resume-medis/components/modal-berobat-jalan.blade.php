<!-- Modal -->
<div class="modal fade" id="modal-berobat-jalanke-poli" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Berobat Jalan Ke Poli</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="tgl-rajal" class="form-label">Tanggal Rajal</label>
                <input type="date" class="form-control" id="tgl-rajal" name="tgl_rajal"
                    value="{{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '8' ? $dataResume->rmeResumeDet->tgl_rajal : '' }}">

                <label for="unit_rajal" class="form-label mt-3">Unit Rajal</label>
                <select class="form-select" id="unit_rajal" name="unit_rajal">
                    <option value="">-Pilih Unit Pelayanan-</option>
                    @foreach ($unitKonsul as $unt)
                        <option value="{{ $unt->kd_unit }}"
                            {{ ($dataResume->rmeResumeDet->unit_rajal ?? '') == $unt->kd_unit ? 'selected' : '' }}>
                            {{ $unt->nama_unit }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-simpan-berobat-jalan">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            // Inisialisasi nilai yang sudah ada
            const savedTglRajal = $('#tgl-rajal').val();
            const savedUnitRajal = $('#unit_rajal option:selected').text();

            // Update span di modal utama jika ada data tersimpan
            if (savedTglRajal && savedUnitRajal) {
                updateBerobatJalanDisplay(savedTglRajal, savedUnitRajal);
            }

            // Handler untuk membuka modal
            $('#btn-berobat-jalanke-poli').on('click', function(e) {
                e.preventDefault();
                // Check radio button
                $('#berobat-jalanke-poli').prop('checked', true);
                // Tampilkan modal
                $('#modal-berobat-jalanke-poli').modal('show');
            });

            // Handler untuk tombol simpan
            $('#btn-simpan-berobat-jalan').on('click', function() {
                const selectedTglRajal = $('#tgl-rajal').val();
                const selectedUnitRajal = $('#unit_rajal option:selected').text();
                const selectedUnitRajalCode = $('#unit_rajal').val();

                if (selectedTglRajal && selectedUnitRajalCode) {
                    updateBerobatJalanDisplay(selectedTglRajal, selectedUnitRajal);
                    $('#modal-berobat-jalanke-poli').modal('hide');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Error',
                        text: 'Silahkan lengkapi tanggal dan unit pelayanan'
                    });
                }
            });

            // Fungsi untuk update tampilan berobat jalan
            function updateBerobatJalanDisplay(tglRajal, unitRajal) {
                // Format tanggal untuk display
                const formattedDate = new Date(tglRajal).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

                // Update span di modal utama
                $('#selected-poli-info').text(`${formattedDate} - ${unitRajal}`);
                // Update value radio button
                $('#berobat-jalanke-poli').val(`Berobat Jalan ke Poli: ${formattedDate} - ${unitRajal}`);
                // Check radio button
                $('#berobat-jalanke-poli').prop('checked', true);
            }

            // Handler untuk reset form saat modal ditutup
            $('#modal-berobat-jalanke-poli').on('hidden.bs.modal', function() {
                if (!$('#selected-poli-info').text()) {
                    $('#berobat-jalanke-poli').prop('checked', false);
                }
            });

            // Tambahkan validasi tanggal tidak boleh kurang dari hari ini
            $('#tgl-rajal').on('change', function() {
                const selectedDate = new Date($(this).val());
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                if (selectedDate < today) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Error',
                        text: 'Tanggal tidak boleh kurang dari hari ini'
                    });
                    $(this).val('');
                }
            });
        });
    </script>
@endpush
