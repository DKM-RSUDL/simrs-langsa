<div class="modal fade" id="modal-rs-rujuk-bagian" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Rujuk Ke Rumah Sakit Lain</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="rs-rujuk" class="form-label">Tujuan Rujuk</label>
                <input type="text" class="form-control" id="rs-rujuk" name="rs_rujuk"
                    value="{{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '5' ? $dataResume->rmeResumeDet->rs_rujuk : '' }}">

                <label for="alasan_rujuk" class="form-label">Alasan Rujuk</label>
                <select class="form-select" id="alasan_rujuk" name="alasan_rujuk">
                    <option value="">--Pilih--</option>
                    <option value="1" {{ ($dataResume->rmeResumeDet->alasan_rujuk ?? '') == '1' ? 'selected' : '' }}>Indikasi Medis</option>
                    <option value="2" {{ ($dataResume->rmeResumeDet->alasan_rujuk ?? '') == '2' ? 'selected' : '' }}>Kamar Penuh</option>
                    <option value="3" {{ ($dataResume->rmeResumeDet->alasan_rujuk ?? '') == '3' ? 'selected' : '' }}>Permintaan Pasien</option>
                </select>

                <label for="transportasi_rujuk" class="form-label">Transportasi Rujuk</label>
                <select class="form-select" id="transportasi_rujuk" name="transportasi_rujuk">
                    <option value="">--Pilih--</option>
                    <option value="1" {{ ($dataResume->rmeResumeDet->transportasi_rujuk ?? '') == '1' ? 'selected' : '' }}>Ambulance</option>
                    <option value="2" {{ ($dataResume->rmeResumeDet->transportasi_rujuk ?? '') == '2' ? 'selected' : '' }}>Kendaraan Pribadi</option>
                    <option value="3" {{ ($dataResume->rmeResumeDet->transportasi_rujuk ?? '') == '3' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-simpan-rs-rujuk-bagian">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        // Inisialisasi nilai yang sudah ada
        const savedRsRujuk = $('#rs-rujuk').val();
        const savedAlasanRujuk = $('#alasan_rujuk option:selected').text();
        const savedTransportasiRujuk = $('#transportasi_rujuk option:selected').text();

        // Update span di modal utama jika ada data tersimpan
        if (savedRsRujuk || savedAlasanRujuk || savedTransportasiRujuk) {
            updateRujukDisplay(savedRsRujuk, savedAlasanRujuk, savedTransportasiRujuk);
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
            const selectedAlasan = $('#alasan_rujuk option:selected').text();
            const selectedTransportasi = $('#transportasi_rujuk option:selected').text();

            if (selectedRs && selectedAlasan && selectedTransportasi) {
                updateRujukDisplay(selectedRs, selectedAlasan, selectedTransportasi);
                $('#modal-rs-rujuk-bagian').modal('hide');
            } else {
                alert('Silahkan lengkapi semua data rujukan');
            }
        });

        // Fungsi untuk update tampilan rujukan
        function updateRujukDisplay(rs, alasan, transportasi) {
            // Update span di modal utama
            $('#selected-rs-info').text(`${rs} - ${alasan} - ${transportasi}`);
            // Update value radio button
            $('#rujuk').val(`Rujuk RS lain: ${rs} - ${alasan} - ${transportasi}`);
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
@endpush
