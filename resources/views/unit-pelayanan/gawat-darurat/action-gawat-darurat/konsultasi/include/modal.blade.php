<div class="modal fade" id="addKonsulModal" tabindex="-1" aria-labelledby="addKonsulModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addKonsulModalLabel">Konsultasi/ Rujukan Intern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="post">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-5">
                            <label for="dokter_pengirim" class="form-label fw-bold h5 text-dark">Dokter
                                Pengirim:</label>
                            <select id="dokter_pengirim" name="dokter_pengirim" class="form-select select2" required>
                                <option value="">--Pilih Dokter--</option>
                                @foreach ($dokterPengirim as $dok)
                                    <option value="{{ $dok->dokter->kd_dokter }}">{{ $dok->dokter->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-7">
                                        <label for="tgl_konsul" class="form-label fw-bold h5 text-dark">Tanggal Konsul
                                            :</label>
                                        <input type="date" id="tgl_konsul" name="tgl_konsul" class="form-control"
                                            required>
                                    </div>
                                    <div class="col-5">
                                        <label for="jam_konsul" class="form-label fw-bold h5 text-dark">Jam :</label>
                                        <input type="time" id="jam_konsul" name="jam_konsul" class="form-control"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label for="unit_tujuan" class="form-label fw-bold h5 text-dark">Kepada Unit Pelayanan
                                    :</label>
                                <select id="unit_tujuan" name="unit_tujuan" class="form-select select2" required>
                                    <option value="">-Pilih Unit Pelayanan-</option>
                                    @foreach ($unit as $unt)
                                        <option value="{{ $unt->kd_unit }}">{{ $unt->nama_unit }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-3">
                                <label for="dokter_unit_tujuan" class="form-label fw-bold h5 text-dark">Yth Dokter
                                    :</label>
                                <select id="dokter_unit_tujuan" name="dokter_unit_tujuan" class="form-select select2"
                                    aria-label="Pilih dokter pengirim">
                                    <option value="">--Pilih Dokter--</option>
                                </select>
                            </div>

                            <div class="mt-3">
                                <h6 class="fw-bold">Konsulen diharapkan</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="konsulen_harap" value="1"
                                        id="konsul-sewaktu">
                                    <label class="form-check-label" for="konsul-sewaktu">
                                        Konsul Sewaktu
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="konsulen_harap" value="2"
                                        id="rawat-bersama">
                                    <label class="form-check-label" for="rawat-bersama">
                                        Rawat Bersama
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="konsulen_harap" value="3"
                                        id="alih-rawat">
                                    <label class="form-check-label" for="alih-rawat">
                                        Alih Rawat
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="konsulen_harap" value="4"
                                        id="kembali-unit-asal">
                                    <label class="form-check-label" for="kembali-unit-asal">
                                        kembali ke unit yang meminta untuk persetujuan tindakan & pengobatan
                                    </label>
                                </div>
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
            </form>
        </div>
    </div>
</div>
