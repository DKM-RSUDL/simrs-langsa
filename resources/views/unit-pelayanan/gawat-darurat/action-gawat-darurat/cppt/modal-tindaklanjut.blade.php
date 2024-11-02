{{-- START: KONSULTASI MODAL --}}
<div class="modal fade second-modal konsul-modal" id="konsulModal" tabindex="-1" aria-labelledby="konsulModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="konsulModalLabel">Konsultasi/ Rujukan Intern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-5">
                        <label for="dokter_pengirim" class="form-label fw-bold h5 text-dark">Dokter
                            Pengirim:</label>
                        <select id="dokter_pengirim" name="dokter_pengirim"
                            class="form-select select2 @error('dokter_pengirim') is-invalid @enderror">
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
                                        class="form-control @error('tgl_konsul') is-invalid @enderror">
                                </div>
                                <div class="col-5">
                                    <label for="jam_konsul" class="form-label fw-bold h5 text-dark">Jam :</label>
                                    <input type="time" id="jam_konsul" name="jam_konsul"
                                        class="form-control @error('jam_konsul') is-invalid @enderror">
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
                                class="form-select select2 @error('unit_tujuan') is-invalid @enderror">
                                <option value="">-Pilih Unit Pelayanan-</option>
                                @foreach ($unitKonsul as $unt)
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
                                class="form-select select2 @error('dokter_unit_tujuan') is-invalid @enderror">
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
                                    type="radio" name="konsulen_harap" value="1" id="konsul-sewaktu">
                                <label class="form-check-label" for="konsul-sewaktu">
                                    Konsul Sewaktu
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                    type="radio" name="konsulen_harap" value="2" id="rawat-bersama">
                                <label class="form-check-label" for="rawat-bersama">
                                    Rawat Bersama
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                    type="radio" name="konsulen_harap" value="3" id="alih-rawat">
                                <label class="form-check-label" for="alih-rawat">
                                    Alih Rawat
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                    type="radio" name="konsulen_harap" value="4" id="kembali-unit-asal">
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
                        <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan" id="catatan" rows="3"></textarea>
                        @error('catatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="mt-3">
                            <strong class="fw-bold">Konsul yang di minta</strong>
                            <textarea class="form-control @error('konsul') is-invalid @enderror" name="konsul" id="konsul" rows="5"></textarea>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-save-konsul">Simpan</button>
            </div>
        </div>
    </div>
</div>
{{-- END: KONSULTASI MODAL --}}

{{-- START: KONTROL ULANG MODAL --}}
<div class="modal fade second-modal konsul-modal" id="kontrolModal" tabindex="-1"
    aria-labelledby="kontrolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="kontrolModalLabel">Kontrol Ulang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="form-group">
                        <label for="tgl_kontrol" class="form-label">Tanggal Kontrol</label>
                        <input type="date" name="tgl_kontrol" id="tgl_kontrol" class="form-control">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-save-kontrol">Simpan</button>
            </div>
        </div>
    </div>
</div>
{{-- END: KONTROL ULANG MODAL --}}

{{-- START: RS LAIN MODAL --}}
<div class="modal fade second-modal konsul-modal" id="rsLainModal" tabindex="-1" aria-labelledby="rsLainModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="rsLainModalLabel">Rujuk Ke Rumah Sakit Lain</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="form-group">
                        <label for="nama_rs" class="form-label">Nama RS</label>
                        <input type="text" name="nama_rs" id="nama_rs" class="form-control">
                    </div>

                    <div class="form-group mt-3">
                        <label for="bagian_rs" class="form-label">Bagian RS Tujuan</label>
                        <input type="text" name="bagian_rs" id="bagian_rs" class="form-control">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-save-rs-lain">Simpan</button>
            </div>
        </div>
    </div>
</div>
{{-- END: RS LAIN MODAL --}}
