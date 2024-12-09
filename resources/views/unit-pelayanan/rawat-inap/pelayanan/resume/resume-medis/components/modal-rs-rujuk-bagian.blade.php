<div class="modal fade" id="modal-rs-rujuk-bagian" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Rujuk Ke Rumah Sakit Lain</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="rs-rujuk" class="form-label">Nama RS</label>
                <input type="text" class="form-control" id="rs-rujuk" name="rs_rujuk"
                    value="{{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '5' ? $dataResume->rmeResumeDet->rs_rujuk : '' }}">

                <label for="rs-rujuk-bagian" class="form-label">Bagian RD Tujuan</label>
                <input type="text" class="form-control" id="rs-rujuk-bagian" name="rs_rujuk_bagian"
                    value="{{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '5' ? $dataResume->rmeResumeDet->rs_rujuk_bagian : '' }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-simpan-rs-rujuk-bagian">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inisialisasi nilai yang sudah ada
        const savedRsRujuk = $('#rs-rujuk').val();
        const savedRsRujukBagian = $('#rs-rujuk-bagian').val();

        // Update span di modal utama jika ada data tersimpan
        if (savedRsRujuk || savedRsRujukBagian) {
            updateRujukDisplay(savedRsRujuk, savedRsRujukBagian);
        }

        // Handler untuk membuka modal
        $('#btn-rs-rujuk-bagian').on('click', function(e) {
            e.preventDefault();
            // Check radio button
            $(this).find('input[type="radio"]').prop('checked', true);
            // Tampilkan modal
            $('#modal-rs-rujuk-bagian').modal('show');
        });

        // Handler untuk tombol simpan
        $('#btn-simpan-rs-rujuk-bagian').on('click', function() {
            const selectedRs = $('#rs-rujuk').val();
            const selectedBagian = $('#rs-rujuk-bagian').val();

            if (selectedRs && selectedBagian) {
                updateRujukDisplay(selectedRs, selectedBagian);
                $('#modal-rs-rujuk-bagian').modal('hide');
            } else {
                alert('Silahkan lengkapi data RS dan Bagian Rujukan');
            }
        });

        // Fungsi untuk update tampilan rujukan
        function updateRujukDisplay(rs, bagian) {
            // Update span di modal utama
            $('#selected-rs-info').text(`${bagian} - ${rs}`);
            // Update value radio button
            $('#rujuk').val(`Rujuk RS lain bagian: ${bagian} - ${rs}`);
            // Check radio button
            $('#rujuk').prop('checked', true);
        }

        // Handler untuk reset form saat modal ditutup
        $('#modal-rs-rujuk-bagian').on('hidden.bs.modal', function() {
            if (!$('#selected-rs-info').text()) {
                $('#rujuk').prop('checked', false);
            }
        });
    });
</script>
