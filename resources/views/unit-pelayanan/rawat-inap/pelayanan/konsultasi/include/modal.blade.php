<div class="modal fade" id="addKonsulModal" tabindex="-1" aria-labelledby="addKonsulModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addKonsulModalLabel">Konsultasi/ Rujukan Intern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form
                action="{{ route('rawat-inap.konsultasi.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                method="post">
                @csrf

                <div class="modal-body">

                    <div class="row">
                        <div class="col-5">
                            <label for="dokter_pengirim" class="form-label fw-bold h5 text-dark">Dokter
                                Pengirim:</label>
                            <select id="dokter_pengirim" name="dokter_pengirim"
                                class="form-select @error('dokter_pengirim') is-invalid @enderror" required>
                                <option value="">--Pilih Dokter--</option>
                                @foreach ($dokterPengirim as $dok)
                                    <option value="{{ $dok->dokter->kd_dokter }}" @selected($dok->dokter->kd_karyawan == auth()->user()->kd_karyawan)>
                                        {{ $dok->dokter->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>

                            @error('dokter_pengirim')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-7">
                                        <label for="tgl_konsul" class="form-label fw-bold h5 text-dark">Tanggal Konsul
                                            :</label>
                                        <input type="date" id="tgl_konsul" name="tgl_konsul"
                                            class="form-control @error('tgl_konsul') is-invalid @enderror" required>
                                    </div>
                                    <div class="col-5">
                                        <label for="jam_konsul" class="form-label fw-bold h5 text-dark">Jam :</label>
                                        <input type="time" id="jam_konsul" name="jam_konsul"
                                            class="form-control @error('jam_konsul') is-invalid @enderror" required>
                                    </div>
                                </div>

                                @error('tgl_konsul')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                @error('jam_konsul')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="unit_tujuan" class="form-label fw-bold h5 text-dark">Kepada Unit Pelayanan
                                    :</label>
                                <select id="unit_tujuan" name="unit_tujuan"
                                    class="form-select select2 @error('unit_tujuan') is-invalid @enderror" required>
                                    <option value="">-Pilih Unit Pelayanan-</option>
                                    @foreach ($unit as $unt)
                                        <option value="{{ $unt->kd_unit }}">{{ $unt->nama_unit }}</option>
                                    @endforeach
                                </select>
                                @error('unit_tujuan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="dokter_unit_tujuan" class="form-label fw-bold h5 text-dark">Yth Dokter
                                    :</label>
                                <select id="dokter_unit_tujuan" name="dokter_unit_tujuan"
                                    class="form-select select2 @error('dokter_unit_tujuan') is-invalid @enderror"
                                    required>
                                    <option value="">--Pilih Dokter--</option>
                                </select>
                                @error('dokter_unit_tujuan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <h6 class="fw-bold">Konsulen diharapkan</h6>
                                <div class="form-check">
                                    <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                        type="radio" name="konsulen_harap" value="1" id="konsul-sewaktu"
                                        required>
                                    <label class="form-check-label" for="konsul-sewaktu">
                                        Konsul Sewaktu
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                        type="radio" name="konsulen_harap" value="2" id="rawat-bersama" required>
                                    <label class="form-check-label" for="rawat-bersama">
                                        Rawat Bersama
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                        type="radio" name="konsulen_harap" value="3" id="alih-rawat" required>
                                    <label class="form-check-label" for="alih-rawat">
                                        Alih Rawat
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                        type="radio" name="konsulen_harap" value="4" id="kembali-unit-asal"
                                        required>
                                    <label class="form-check-label" for="kembali-unit-asal">
                                        kembali ke unit yang meminta untuk persetujuan tindakan & pengobatan
                                    </label>
                                </div>
                                @error('konsulen_harap')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>
                        <div class="col-7">
                            <strong class="fw-bold">Catatan Klinik/Diagnosis</strong>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan" id="catatan" rows="3"
                                required></textarea>
                            @error('catatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="mt-3">
                                <strong class="fw-bold">Konsul yang di minta</strong>
                                <textarea class="form-control @error('konsul') is-invalid @enderror" name="konsul" id="konsul" rows="5"
                                    required></textarea>
                                @error('konsul')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editKonsulModal" tabindex="-1" aria-labelledby="editKonsulModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editKonsulModalLabel">Konsultasi/ Rujukan Intern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form
                action="{{ route('rawat-inap.konsultasi.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                method="post">
                @csrf
                @method('put')

                <input type="hidden" name="old_kd_unit_tujuan" id="old_kd_unit_tujuan">
                <input type="hidden" name="old_tgl_konsul" id="old_tgl_konsul">
                <input type="hidden" name="old_jam_konsul" id="old_jam_konsul">
                <input type="hidden" name="urut_konsul" id="urut_konsul">

                <div class="modal-body">

                    <div class="row">
                        <div class="col-5">
                            <label for="dokter_pengirim" class="form-label fw-bold h5 text-dark">Dokter
                                Pengirim:</label>
                            <select id="dokter_pengirim" name="dokter_pengirim"
                                class="form-select select2 @error('dokter_pengirim') is-invalid @enderror" required
                                disabled>
                                <option value="">--Pilih Dokter--</option>
                                @foreach ($dokterPengirim as $dok)
                                    <option value="{{ $dok->dokter->kd_dokter }}">{{ $dok->dokter->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>

                            @error('dokter_pengirim')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-7">
                                        <label for="tgl_konsul" class="form-label fw-bold h5 text-dark">Tanggal Konsul
                                            :</label>
                                        <input type="date" id="tgl_konsul" name="tgl_konsul"
                                            class="form-control @error('tgl_konsul') is-invalid @enderror" required
                                            disabled>
                                    </div>
                                    <div class="col-5">
                                        <label for="jam_konsul" class="form-label fw-bold h5 text-dark">Jam :</label>
                                        <input type="time" id="jam_konsul" name="jam_konsul"
                                            class="form-control @error('jam_konsul') is-invalid @enderror" required
                                            disabled>
                                    </div>
                                </div>

                                @error('tgl_konsul')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                @error('jam_konsul')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="unit_tujuan" class="form-label fw-bold h5 text-dark">Kepada Unit Pelayanan
                                    :</label>
                                <select id="unit_tujuan" name="unit_tujuan"
                                    class="form-select select2 @error('unit_tujuan') is-invalid @enderror" required
                                    disabled>
                                    <option value="">-Pilih Unit Pelayanan-</option>
                                    @foreach ($unit as $unt)
                                        <option value="{{ $unt->kd_unit }}">{{ $unt->nama_unit }}</option>
                                    @endforeach
                                </select>
                                @error('unit_tujuan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="dokter_unit_tujuan" class="form-label fw-bold h5 text-dark">Yth Dokter
                                    :</label>
                                <select id="dokter_unit_tujuan" name="dokter_unit_tujuan"
                                    class="form-select select2 @error('dokter_unit_tujuan') is-invalid @enderror"
                                    required disabled>
                                    <option value="">--Pilih Dokter--</option>
                                </select>
                                @error('dokter_unit_tujuan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <h6 class="fw-bold">Konsulen diharapkan</h6>
                                <div class="form-check">
                                    <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                        type="radio" name="konsulen_harap" value="1" id="konsul-sewaktu"
                                        required>
                                    <label class="form-check-label" for="konsul-sewaktu">
                                        Konsul Sewaktu
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                        type="radio" name="konsulen_harap" value="2" id="rawat-bersama"
                                        required>
                                    <label class="form-check-label" for="rawat-bersama">
                                        Rawat Bersama
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                        type="radio" name="konsulen_harap" value="3" id="alih-rawat"
                                        required>
                                    <label class="form-check-label" for="alih-rawat">
                                        Alih Rawat
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                        type="radio" name="konsulen_harap" value="4" id="kembali-unit-asal"
                                        required>
                                    <label class="form-check-label" for="kembali-unit-asal">
                                        kembali ke unit yang meminta untuk persetujuan tindakan & pengobatan
                                    </label>
                                </div>
                                @error('konsulen_harap')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>
                        <div class="col-7">
                            <strong class="fw-bold">Catatan Klinik/Diagnosis</strong>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan" id="catatan" rows="3"
                                required></textarea>
                            @error('catatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="mt-3">
                                <strong class="fw-bold">Konsul yang di minta</strong>
                                <textarea class="form-control @error('konsul') is-invalid @enderror" name="konsul" id="konsul" rows="5"
                                    required></textarea>
                                @error('konsul')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
