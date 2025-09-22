@push('css')
    <style>
        trix-toolbar {
            display: none;
        }
    </style>
@endpush


<div class="modal fade" id="addKonsulModal" tabindex="-1" aria-labelledby="addKonsulModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addKonsulModalLabel">Konsultasi Dokter Umum Ke Spesialis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form
                action="{{ route('konsultasi.store', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                method="post">
                @csrf

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6 border p-3">
                            <p class="fw-bold h5">SOAP</p>

                            <div class="form-group mt-4">
                                <label for="subjective">Subjective</label>
                                <textarea name="subjective" id="subjective" class="form-control">{{ $subjectiveCreate ?? '' }}</textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="background">Objective</label>
                                <textarea name="background" id="background" class="form-control">{{ $backgroundCreate ?? '' }}</textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="assesment">Assesment</label>
                                <textarea name="assesment" id="assesment" class="form-control">{{ $asesmenCreate ?? '' }}</textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="recomendation">Planning</label>
                                <textarea name="recomendation" id="recomendation" class="form-control"></textarea>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <div class="form-group">
                                        <label for="dokter_pengirim" class="fw-bold text-primary">Dokter yang
                                            konsul</label>
                                        <select name="dokter_pengirim" id="dokter_pengirim" class="form-control select2"
                                            required>
                                            <option value="">--Pilih Dokter Pengirim--</option>
                                            @foreach ($dokterPengirim as $dok)
                                                <option value="{{ $dok->dokter->kd_dokter }}"
                                                    @selected($dok->dokter->kd_karyawan == auth()->user()->kd_karyawan)>
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
                                            <input type="date" name="tgl_konsul" id="tgl_konsul"
                                                class="form-control me-1" value="{{ date('Y-m-d') }}" required>
                                            <input type="time" name="jam_konsul" id="jam_konsul" class="form-control"
                                                value="{{ date('H:i') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="dokter_tujuan" class="fw-bold text-primary">Kepada Dokter Spesialis</label>
                                <select name="dokter_tujuan" id="dokter_tujuan" class="form-control select2" required>
                                    <option value="">--Pilih Dokter Tujuan--</option>
                                    @foreach ($dokterSpesialis as $dokSpesial)
                                        <option value="{{ $dokSpesial->kd_dokter }}">
                                            {{ $dokSpesial->dokter->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="form-group mt-3">
                                <label for="konsultasi" class="fw-bold text-primary">Konsul Yang Diminta</label>
                                <textarea name="konsultasi" id="konsultasi" class="form-control" rows="5"></textarea>
                            </div> --}}

                            <div class="form-group mt-3">
                                <label for="instruksi" class="fw-bold text-primary">Instruksi Dokter Spesialis</label>
                                <label class="form-label text-dark">Tuliskan instruksi dengan TBAK (Tulis
                                    instruksi, bacakan kembali untuk konfirmasi)</label>
                                {{-- <textarea name="instruksi" id="instruksi" class="form-control" rows="5"></textarea> --}}
                                <input id="instruksi" type="hidden" name="instruksi">
                                <trix-editor input="instruksi"></trix-editor>
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


<div class="modal fade" id="editKonsulModal" tabindex="-1" aria-labelledby="editKonsulModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editKonsulModalLabel">Konsultasi/ Rujukan Intern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form
                action="{{ route('konsultasi.update', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                method="post">
                @csrf
                @method('put')

                <input type="hidden" name="id_konsul" id="id_konsul">

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6 border p-3">
                            <p class="fw-bold h5">SOAP</p>

                            <div class="form-group mt-4">
                                <label for="subjective">Subjective</label>
                                <textarea name="subjective" id="subjective" class="form-control"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="background">Objective</label>
                                <textarea name="background" id="background" class="form-control"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="assesment">Assesment</label>
                                <textarea name="assesment" id="assesment" class="form-control"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="recomendation">Planning</label>
                                <textarea name="recomendation" id="recomendation" class="form-control"></textarea>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <div class="form-group">
                                        <label for="dokter_pengirim" class="fw-bold text-primary">Dokter yang
                                            konsul</label>
                                        <select name="dokter_pengirim" id="dokter_pengirim"
                                            class="form-control select2" required>
                                            <option value="">--Pilih Dokter Pengirim--</option>
                                            @foreach ($dokterPengirim as $dok)
                                                <option value="{{ $dok->dokter->kd_dokter }}"
                                                    @selected($dok->dokter->kd_karyawan == auth()->user()->kd_karyawan)>
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
                                            <input type="date" name="tgl_konsul" id="tgl_konsul"
                                                class="form-control me-1" required>
                                            <input type="time" name="jam_konsul" id="jam_konsul"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="dokter_tujuan" class="fw-bold text-primary">Kepada Dokter
                                    Spesialis</label>
                                <select name="dokter_tujuan" id="dokter_tujuan" class="form-control select2"
                                    required>
                                    <option value="">--Pilih Dokter Tujuan--</option>
                                    @foreach ($dokterSpesialis as $dokSpesial)
                                        <option value="{{ $dokSpesial->kd_dokter }}">
                                            {{ $dokSpesial->dokter->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="form-group mt-3">
                                <label for="konsultasi" class="fw-bold text-primary">Konsul Yang Diminta</label>
                                <textarea name="konsultasi" id="konsultasi" class="form-control" rows="5"></textarea>
                            </div> --}}

                            <div class="form-group mt-3">
                                <label for="instruksi" class="fw-bold text-primary">Instruksi Dokter Spesialis</label>
                                <label for="" class="form-label text-dark">Tuliskan instruksi dengan TBAK
                                    (Tulis instruksi, bacakan kembali untuk konfirmasi)</label>
                                {{-- <textarea name="instruksi" id="instruksi" class="form-control" rows="5"></textarea> --}}
                                <input id="instruksi-edit" type="hidden" name="instruksi">
                                <trix-editor input="instruksi-edit"></trix-editor>
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
