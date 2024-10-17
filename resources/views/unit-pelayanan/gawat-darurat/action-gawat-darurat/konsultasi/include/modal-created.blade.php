<div class="modal fade" id="modal-created" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Konsultasi/ Rujukan Intern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-5">
                        <label for="kd_dokter" class="form-label fw-bold h5 text-dark">Dokter Pengirim:</label>
                        <select id="kd_dokter" name="kd_dokter" class="form-select" aria-label="Pilih dokter pengirim"
                            required>
                            <option value="" disabled selected>-Pilih Dokter Pengirim-</option>
                            @foreach ($dataDokter as $dokter)
                                <option value="{{ $dokter->kd_dokter }}"
                                    {{ old('kd_dokter') == $dokter->kd_dokter ? 'selected' : '' }}>
                                    {{ $dokter->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>

                        <div class="mt-3">
                            <div class="row">
                                <div class="col-7">
                                <label for="tgl_order" class="form-label fw-bold h5 text-dark">Tanggal Konsul :</label>
                                <input type="date" id="tgl_order" name="tgl_order" class="form-control"
                                    value="">
                                </div>
                                <div class="col-5">
                                    <label for="tgl_order" class="form-label fw-bold h5 text-dark">Jam :</label>
                                <input type="time" id="tgl_order" name="tgl_order" class="form-control"
                                    value="">
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="kd_unit_pelayanan" class="form-label fw-bold h5 text-dark">Kepada Unit Pelayanan
                                :</label>
                            <select id="kd_unit_pelayanan" name="" class="form-select"
                                aria-label="Pilih Unit Pelayanan">
                                <option value="" disabled selected>-Pilih Unit Pelayanan-</option>
                                <option value="">layanan 1</option>
                                <option value="">layanan 2</option>
                                <option value="">layanan 3</option>
                            </select>
                        </div>

                        <div class="mt-3">
                            <label for="kd_dokter" class="form-label fw-bold h5 text-dark">Yht Dokter :</label>
                            <select id="kd_dokter" name="kd_dokter" class="form-select"
                                aria-label="Pilih dokter pengirim">
                                <option value="" disabled selected>-Pilih Dokter-</option>
                                @foreach ($dataDokter as $dokter)
                                    <option value="{{ $dokter->kd_dokter }}"
                                        {{ old('kd_dokter') == $dokter->kd_dokter ? 'selected' : '' }}>
                                        {{ $dokter->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-3">
                            <h6 class="fw-bold">Konsulen diharapkan</h6>
                            <form>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="konsul-sewaktu" checked>
                                    <label class="form-check-label" for="konsul-sewaktu">
                                        Konsul Sewaktu
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rawat-bersama">
                                    <label class="form-check-label" for="rawat-bersama">
                                        Rawat Bersama
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="alih-rawat">
                                    <label class="form-check-label" for="alih-rawat">
                                        Alih Rawat
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="persetujuan-tindakan">
                                    <label class="form-check-label" for="persetujuan-tindakan">
                                        Kembali ke unit yang meminta untuk persetujuan tindakan & pengobatan
                                    </label>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="col-7">
                        <strong class="fw-bold">Catatan Klinik/Diagnosis</strong>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>

                        <div class="mt-3">
                            <strong class="fw-bold">Konsul yang di minta</strong>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Kirim</button>
            </div>
        </div>
    </div>
</div>

<script>
    //button create post event
    $('#btn-created').on('click', function() {

        //open modal
        $('#modal-created').modal('show');
    });
</script>
