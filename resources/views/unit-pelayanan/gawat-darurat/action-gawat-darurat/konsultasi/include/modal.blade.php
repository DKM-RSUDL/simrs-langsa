{{-- <div class="modal fade" id="addKonsulModal" tabindex="-1" aria-labelledby="addKonsulModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addKonsulModalLabel">Konsultasi/ Rujukan Intern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('konsultasi.store', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk]) }}"
                method="post">
                @csrf

                <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">

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
</div> --}}


<div class="modal fade" id="addKonsulModal" tabindex="-1" aria-labelledby="addKonsulModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addKonsulModalLabel">Konsultasi Dokter Umum Ke Spesialis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('konsultasi.store', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                method="post">
                @csrf

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6 border p-3">
                            <p class="fw-bold h5">SBAR</p>

                            <div class="form-group mt-4">
                                <label for="subjective">Subjective</label>
                                <textarea name="subjective" id="subjective" class="form-control"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="background">Backgroud</label>
                                <textarea name="background" id="background" class="form-control"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="assesment">Assesment</label>
                                <textarea name="assesment" id="assesment" class="form-control"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="recomendation">Recomendation</label>
                                <textarea name="recomendation" id="recomendation" class="form-control"></textarea>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <div class="form-group">
                                        <label for="dokter_pengirim" class="fw-bold text-primary">Dokter yang konsul</label>
                                        <select name="dokter_pengirim" id="dokter_pengirim" class="form-control select2" required>
                                            <option value="">--Pilih Dokter Pengirim--</option>
                                            @foreach ($dokterPengirim as $dok)
                                                <option value="{{ $dok->dokter->kd_dokter }}" @selected($dok->dokter->kd_karyawan == auth()->user()->kd_karyawan)>
                                                    {{ $dok->dokter->nama_lengkap }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label for="" class="form-label">Tanggal Jam</label>
                                        <div class="d-flex">
                                            <input type="date" name="tgl_konsul" id="tgl_konsul" class="form-control me-1" value="{{ date('Y-m-d') }}" required>
                                            <input type="time" name="jam_konsul" id="jam_konsul" class="form-control" value="{{ date('H:i') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="dokter_tujuan" class="fw-bold text-primary">Kepada Dokter Spesialis</label>
                                <select name="dokter_tujuan" id="dokter_tujuan" class="form-control select2" required>
                                    <option value="">--Pilih Dokter Tujuan--</option>
                                    @foreach ($dokterSpesialis as $dokSpesial)
                                        <option value="{{ $dokSpesial->kd_dokter }}">{{ $dokSpesial->dokter->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <label for="konsultasi" class="fw-bold text-primary">Konsul Yang Diminta</label>
                                <textarea name="konsultasi" id="konsultasi" class="form-control" rows="5" required></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="instruksi" class="fw-bold text-primary">Instruksi Dokter Spesialis</label>
                                <label for="" class="form-label text-dark">Tuliskan instruksi dengan TBAK (Tulis instruksi, bacakan kembali untuk konfirmasi)</label>
                                <textarea name="instruksi" id="instruksi" class="form-control" rows="5"></textarea>
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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editKonsulModalLabel">Konsultasi/ Rujukan Intern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('konsultasi.update', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                method="post">
                @csrf
                @method('put')

                <input type="hidden" name="id_konsul" id="id_konsul">

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6 border p-3">
                            <p class="fw-bold h5">SBAR</p>

                            <div class="form-group mt-4">
                                <label for="subjective">Subjective</label>
                                <textarea name="subjective" id="subjective" class="form-control"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="background">Backgroud</label>
                                <textarea name="background" id="background" class="form-control"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="assesment">Assesment</label>
                                <textarea name="assesment" id="assesment" class="form-control"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="recomendation">Recomendation</label>
                                <textarea name="recomendation" id="recomendation" class="form-control"></textarea>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <div class="form-group">
                                        <label for="dokter_pengirim" class="fw-bold text-primary">Dokter yang konsul</label>
                                        <select name="dokter_pengirim" id="dokter_pengirim" class="form-control select2" required>
                                            <option value="">--Pilih Dokter Pengirim--</option>
                                            @foreach ($dokterPengirim as $dok)
                                                <option value="{{ $dok->dokter->kd_dokter }}" @selected($dok->dokter->kd_karyawan == auth()->user()->kd_karyawan)>
                                                    {{ $dok->dokter->nama_lengkap }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label for="" class="form-label">Tanggal Jam</label>
                                        <div class="d-flex">
                                            <input type="date" name="tgl_konsul" id="tgl_konsul" class="form-control me-1" required>
                                            <input type="time" name="jam_konsul" id="jam_konsul" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="dokter_tujuan" class="fw-bold text-primary">Kepada Dokter Spesialis</label>
                                <select name="dokter_tujuan" id="dokter_tujuan" class="form-control select2" required>
                                    <option value="">--Pilih Dokter Tujuan--</option>
                                    @foreach ($dokterSpesialis as $dokSpesial)
                                        <option value="{{ $dokSpesial->kd_dokter }}">{{ $dokSpesial->dokter->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <label for="konsultasi" class="fw-bold text-primary">Konsul Yang Diminta</label>
                                <textarea name="konsultasi" id="konsultasi" class="form-control" rows="5" required></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="instruksi" class="fw-bold text-primary">Instruksi Dokter Spesialis</label>
                                <label for="" class="form-label text-dark">Tuliskan instruksi dengan TBAK (Tulis instruksi, bacakan kembali untuk konfirmasi)</label>
                                <textarea name="instruksi" id="instruksi" class="form-control" rows="5"></textarea>
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
