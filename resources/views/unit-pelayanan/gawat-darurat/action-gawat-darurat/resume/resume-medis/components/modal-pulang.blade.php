<div class="modal fade" id="selesaiKlinikModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="selesaiKlinikModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="selesaiKlinikModalLabel">Pasien Pulang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tgl_pulang" class="form-label">Tanggal Pulang</label>
                    <input type="date" name="tgl_pulang" id="tgl_pulang" value="{{ $dataResume->rmeResumeDet->tgl_pulang ?? date('Y-m-d') }}" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <label for="jam_pulang" class="form-label">Jam Pulang</label>
                    <input type="time" name="jam_pulang" id="jam_pulang" value="{{ $dataResume->rmeResumeDet->jam_pulang ? date('H:i', strtotime($dataResume->rmeResumeDet->jam_pulang)) : date('H:i') }}" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <label for="alasan_pulang" class="form-label">Alasan Pulang</label>
                    <select name="alasan_pulang" id="alasan_pulang" class="form-select">
                        <option value="">--Pilih Alasan--</option>
                        <option value="1" @selected($dataResume->rmeResumeDet->alasan_pulang == 1)>Sembuh</option>
                        <option value="2" @selected($dataResume->rmeResumeDet->alasan_pulang == 2)>Indikasi Medis</option>
                        <option value="3" @selected($dataResume->rmeResumeDet->alasan_pulang == 3)>Atas Permintaan Sendiri</option>
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label for="kondisi_pulang" class="form-label">Kondisi Pulang</label>
                    <select name="kondisi_pulang" id="kondisi_pulang" class="form-select">
                        <option value="">--Pilih Kondisi--</option>
                        <option value="1" @selected($dataResume->rmeResumeDet->kondisi_pulang == 1)>Mandiri</option>
                        <option value="2" @selected($dataResume->rmeResumeDet->kondisi_pulang == 2)>Tidak Mandiri</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSaveSelesaiKlinik">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#btnPulang').click(function() {
            $('#selesaiKlinikModal').modal('show');
        });

        $('#btnSaveSelesaiKlinik').click(function() {
            let $this = $(this);
            let $modal = $('#selesaiKlinikModal');
            let tglPulang = $modal.find('#tgl_pulang').val();
            let jamPulang = $modal.find('#jam_pulang').val();
            let alasanPulang = $modal.find('#alasan_pulang').val();
            let kondisiPulang = $modal.find('#kondisi_pulang').val();

            if(tglPulang == '' || jamPulang == '' || alasanPulang == '' || kondisiPulang == '') {
                Swal.fire({
                    title: "Error",
                    text: 'Harap mengisi semua inputan pulang !',
                    icon: "error",
                    allowOutsideClick: false
                });

                return false;
            }

            $('#btnPulang span').text(`(${tglPulang} ${jamPulang})`);
            $modal.modal('hide');
        });
    </script>
@endpush
