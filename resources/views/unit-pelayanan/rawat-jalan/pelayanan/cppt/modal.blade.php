{{-- START : ADD CPPT MODAL --}}
<div class="modal fade" id="addCpptModal" tabindex="-1" aria-labelledby="addCpptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form
                action="{{ route('rawat-jalan.cppt.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                method="post" id="formAddCppt">
                @csrf
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="addCpptModalLabel">Catatan Perkembangan Pasien Terintegrasi
                        (CPPT)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <p class="fw-bold">
                                    Anamnesis/ Keluhan Utama
                                    <label for="anamnesis"></label>
                                </p>
                                <textarea class="form-control @error('anamnesis') is-invalid @enderror" name="anamnesis" id="anamnesis" required>{{ old('anamnesis') }}</textarea>
                                @error('anamnesis')
                                    <div class="invalid-feedback">
                                        {{ $error }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <p class="fw-bold">Tanda Vital</p>
                                <div class="row">

                                    @foreach ($tandaVital as $item)
                                        <div class="col-md-4">
                                            <label for="kondisi{{ $item->id_kondisi }}"
                                                class="form-label">{{ $item->kondisi }}</label>
                                            <input type="text" name="tanda_vital[]" class="form-control"
                                                id="kondisi{{ $item->id_kondisi }}">
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="fw-bold">
                                            Skala Nyeri
                                            <label for="skala_nyeri"></label>
                                        </p>
                                        <input type="number" name="skala_nyeri"
                                            class="form-control @error('skala_nyeri') is-invalid @enderror"
                                            min="0" max="10" id="skala_nyeri"
                                            value="{{ old('skala_nyeri', 0) }}">
                                        @error('skala_nyeri')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                        <button type="button" class="btn btn-sm btn-success mt-2"
                                            id="skalaNyeriBtn">Tidak Nyeri</button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <img src="{{ asset('assets/img/cppt/cppt.jpeg') }}" alt="Descriptive Alt Text"
                                        style="width: 100%; height: auto;">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                        name="lokasi" id="lokasi" value="{{ old('lokasi') }}" placeholder="Lokasi">
                                    @error('lokasi')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>

                                <label for="durasi" class="col-sm-2 col-form-label">Durasi</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('durasi') is-invalid @enderror"
                                        name="durasi" id="durasi" placeholder="Durasi" value="{{ old('durasi') }}">
                                    @error('durasi')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="pemberat" class="col-sm-2 col-form-label">Pemberat</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('pemberat') is-invalid @enderror" name="pemberat"
                                        id="pemberat" aria-label="---Pilih---">
                                        <option value="">--Pilih--</option>
                                        @foreach ($faktorPemberat as $pemberat)
                                            <option value="{{ $pemberat->id }}" @selected(old('pemberat') == $pemberat->id)>
                                                {{ $pemberat->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('pemberat')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>

                                <label for="peringan" class="col-sm-2 col-form-label">Peringan</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('peringan') is-invalid @enderror" name="peringan"
                                        id="peringan" aria-label="---Pilih---">
                                        <option value="">--Pilih--</option>
                                        @foreach ($faktorPeringan as $peringan)
                                            <option value="{{ $peringan->id }}" @selected(old('peringan') == $peringan->id)>
                                                {{ $peringan->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('peringan')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="kualitas_nyeri" class="col-sm-2 col-form-label">Kualitas</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('kualitas_nyeri') is-invalid @enderror"
                                        name="kualitas_nyeri" id="kualitas_nyeri" aria-label="---Pilih---">
                                        <option value="">--Pilih--</option>
                                        @foreach ($kualitasNyeri as $kualitas)
                                            <option value="{{ $kualitas->id }}" @selected(old('kualitas_nyeri') == $kualitas->id)>
                                                {{ $kualitas->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('kualitas_nyeri')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                                <label for="frekuensi_nyeri" class="col-sm-2 col-form-label">Frekuensi</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('frekuensi_nyeri') is-invalid @enderror"
                                        name="frekuensi_nyeri" id="frekuensi_nyeri" aria-label="---Pilih---">
                                        <option value="">--Pilih--</option>
                                        @foreach ($frekuensiNyeri as $frekuensi)
                                            <option value="{{ $frekuensi->id }}" @selected(old('frekuensi_nyeri') == $frekuensi->id)>
                                                {{ $frekuensi->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('frekuensi_nyeri')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="menjalar" class="col-sm-2 col-form-label">Menjalar</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('menjalar') is-invalid @enderror"
                                        name="menjalar" id="menjalar" aria-label="---Pilih---">
                                        <option value="">--Pilih--</option>
                                        @foreach ($menjalar as $mjlr)
                                            <option value="{{ $mjlr->id }}" @selected(old('menjalar') == $mjlr->id)>
                                                {{ $mjlr->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('menjalar')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                                <label for="jenis_nyeri" class="col-sm-2 col-form-label">Jenis</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('jenis_nyeri') is-invalid @enderror"
                                        name="jenis_nyeri" id="jenis_nyeri" aria-label="---Pilih---">
                                        <option value="">--Pilih--</option>
                                        @foreach ($jenisNyeri as $jenis)
                                            <option value="{{ $jenis->id }}" @selected(old('jenis_nyeri') == $jenis->id)>
                                                {{ $jenis->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis_nyeri')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="row">
                                <p class="fw-bold col-sm-5">
                                    Pemeriksaan Fisik
                                    <label for="pemeriksaan_fisik"></label>
                                </p>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-secondary-subtle rounded-2">
                                        <textarea class="form-control @error('pemeriksaan_fisik') is-invalid @enderror" name="pemeriksaan_fisik"
                                            id="pemeriksaan_fisik">{{ old('pemeriksaan_fisik') }}</textarea>
                                        @error('pemeriksaan_fisik')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <p class="fw-bold">
                                        Data Objektif Lainnya
                                        <label for="data_objektif"></label>
                                    </p>
                                    <div class="bg-secondary-subtle rounded-2">
                                        <textarea class="form-control @error('data_objektif') is-invalid @enderror" name="data_objektif" id="data_objektif">{{ old('data_objektif') }}</textarea>
                                        @error('data_objektif')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <p class="fw-bold col-sm-5">Asesmen /Diagnosis</p>
                                <div class="col-sm-6">
                                    <!-- Modal 2 -->
                                    @include('unit-pelayanan.rawat-jalan.pelayanan.cppt.create-diagnosis')
                                    {{-- <a href="#" class="btn btn-sm"><i class="bi bi-plus-square"></i>
                                        ICD-10</a> --}}
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="bg-secondary-subtle rounded-2 p-3" id="diagnoseList">
                                            {{-- <a href="#" class="fw-bold">HYPERTENSI KRONIS</a> <br>
                                            <a href="#" class="fw-bold">DYSPEPSIA</a> <br>
                                            <a href="#" class="fw-bold">DEPRESIVE EPISODE</a> <br> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <p class="fw-bold col-sm-12">
                                    Planning/ Rencana Tatalaksana
                                    <label for="planning"></label>
                                </p>
                                <div class="row">
                                    <div class="col-12">
                                        <textarea class="form-control @error('planning') is-invalid @enderror" name="planning" id="planning">{{ old('planning') }}</textarea>
                                        @error('planning')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @include('unit-pelayanan.rawat-jalan.pelayanan.cppt.modal-tindaklanjut')

                            <div class="row mt-3">
                                <div class="checkbox-container">
                                    <div class="input-group">
                                        <input type="radio" @error('tindak_lanjut') class="is-invalid" @enderror
                                            id="plan_konrol_ulang" name="tindak_lanjut" value="2"
                                            @checked(old('tindak_lanjut') == 2) required>
                                        <label for="plan_konrol_ulang">Kontrol ulang, tgl: <span
                                                id="tgl-kontrol-label"></span></label>
                                    </div>
                                    <div class="input-group">
                                        <input type="radio" @error('tindak_lanjut') class="is-invalid" @enderror
                                            id="plan_rujuk_internal" name="tindak_lanjut" value="4"
                                            @checked(old('tindak_lanjut') == 4) required>
                                        <label for="plan_rujuk_internal">Konsul/Rujuk Internal Ke: <span
                                                id="unit-rujuk-internal-label"></span></label>
                                    </div>
                                    <div class="input-group">
                                        <input type="radio" @error('tindak_lanjut') class="is-invalid" @enderror
                                            id="plan_selesai" name="tindak_lanjut" value="3"
                                            @checked(old('tindak_lanjut') == 3) required>
                                        <label for="plan_selesai">Selesai di Klinik ini</label>
                                    </div>

                                    <div class="input-group">
                                        <input type="radio" @error('tindak_lanjut') class="is-invalid" @enderror
                                            id="plan_rujuk" name="tindak_lanjut" value="5"
                                            @checked(old('tindak_lanjut') == 5) required>
                                        <label for="plan_rujuk">Rujuk RS lain bagian: <span
                                                id="rs-tujuan-label"></span></label>
                                    </div>
                                    <div class="input-group">
                                        <input type="radio" @error('tindak_lanjut') class="is-invalid" @enderror
                                            id="plan_rawat_inap" name="tindak_lanjut" value="1"
                                            @checked(old('tindak_lanjut') == 1) required>
                                        <label for="plan_rawat_inap">Rawat Inap</label>
                                    </div>
                                    <div class="input-grou">
                                        @error('tindak_lanjut')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- END : ADD CPPT MODAL --}}

{{-- START : EDIT CPPT MODAL --}}
<div class="modal fade" id="editCpptModal" tabindex="-1" aria-labelledby="editCpptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form
                action="{{ route('rawat-jalan.cppt.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                method="post" id="formEditCppt">
                @csrf
                @method('put')

                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="editCpptModalLabel">Edit Catatan Perkembangan Pasien
                        Terintegrasi (CPPT)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <p class="fw-bold">
                                    Anamnesis/ Keluhan Utama
                                    <label for="anamnesis"></label>
                                </p>
                                <input type="hidden" name="tgl_cppt">
                                <input type="hidden" name="urut_cppt">
                                <input type="hidden" name="urut_total_cppt">
                                <input type="hidden" name="unit_cppt">
                                <input type="hidden" name="no_transaksi">
                                <textarea class="form-control @error('anamnesis') is-invalid @enderror" name="anamnesis" id="anamnesis" required>{{ old('anamnesis') }}</textarea>
                                @error('anamnesis')
                                    <div class="invalid-feedback">
                                        {{ $error }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <p class="fw-bold">Tanda Vital</p>
                                <div class="row">

                                    @foreach ($tandaVital as $item)
                                        <div class="col-md-4">
                                            <label for="kondisi{{ $item->id_kondisi }}"
                                                class="form-label">{{ $item->kondisi }}</label>
                                            <input type="text" name="tanda_vital[]" class="form-control"
                                                id="kondisi{{ $item->id_kondisi }}">
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="fw-bold">
                                            Skala Nyeri
                                            <label for="skala_nyeri"></label>
                                        </p>
                                        <input type="number" name="skala_nyeri"
                                            class="form-control @error('skala_nyeri') is-invalid @enderror"
                                            min="0" max="10" id="skala_nyeri"
                                            value="{{ old('skala_nyeri') }}">
                                        @error('skala_nyeri')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                        <button type="button" class="btn btn-sm btn-success mt-2"
                                            id="skalaNyeriBtn">Tidak Nyeri</button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <img src="{{ asset('assets/img/cppt/cppt.jpeg') }}" alt="Descriptive Alt Text"
                                        style="width: 100%; height: auto;">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                        name="lokasi" id="lokasi" value="{{ old('lokasi') }}"
                                        placeholder="Lokasi">
                                    @error('lokasi')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>

                                <label for="durasi" class="col-sm-2 col-form-label">Durasi</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('durasi') is-invalid @enderror"
                                        name="durasi" id="durasi" placeholder="Durasi"
                                        value="{{ old('durasi') }}">
                                    @error('durasi')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="pemberat" class="col-sm-2 col-form-label">Pemberat</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('pemberat') is-invalid @enderror"
                                        name="pemberat" id="pemberat" aria-label="---Pilih---">
                                        <option value="">--Pilih--</option>
                                        @foreach ($faktorPemberat as $pemberat)
                                            <option value="{{ $pemberat->id }}" @selected(old('pemberat') == $pemberat->id)>
                                                {{ $pemberat->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('pemberat')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>

                                <label for="peringan" class="col-sm-2 col-form-label">Peringan</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('peringan') is-invalid @enderror"
                                        name="peringan" id="peringan" aria-label="---Pilih---">
                                        <option value="">--Pilih--</option>
                                        @foreach ($faktorPeringan as $peringan)
                                            <option value="{{ $peringan->id }}" @selected(old('peringan') == $peringan->id)>
                                                {{ $peringan->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('peringan')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="kualitas_nyeri" class="col-sm-2 col-form-label">Kualitas</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('kualitas_nyeri') is-invalid @enderror"
                                        name="kualitas_nyeri" id="kualitas_nyeri" aria-label="---Pilih---">
                                        <option value="">--Pilih--</option>
                                        @foreach ($kualitasNyeri as $kualitas)
                                            <option value="{{ $kualitas->id }}" @selected(old('kualitas_nyeri') == $kualitas->id)>
                                                {{ $kualitas->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('kualitas_nyeri')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                                <label for="frekuensi_nyeri" class="col-sm-2 col-form-label">Frekuensi</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('frekuensi_nyeri') is-invalid @enderror"
                                        name="frekuensi_nyeri" id="frekuensi_nyeri" aria-label="---Pilih---">
                                        <option value="">--Pilih--</option>
                                        @foreach ($frekuensiNyeri as $frekuensi)
                                            <option value="{{ $frekuensi->id }}" @selected(old('frekuensi_nyeri') == $frekuensi->id)>
                                                {{ $frekuensi->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('frekuensi_nyeri')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <label for="menjalar" class="col-sm-2 col-form-label">Menjalar</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('menjalar') is-invalid @enderror"
                                        name="menjalar" id="menjalar" aria-label="---Pilih---">
                                        <option value="">--Pilih--</option>
                                        @foreach ($menjalar as $mjlr)
                                            <option value="{{ $mjlr->id }}" @selected(old('menjalar') == $mjlr->id)>
                                                {{ $mjlr->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('menjalar')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                                <label for="jenis_nyeri" class="col-sm-2 col-form-label">Jenis</label>
                                <div class="col-sm-4">
                                    <select class="form-select @error('jenis_nyeri') is-invalid @enderror"
                                        name="jenis_nyeri" id="jenis_nyeri" aria-label="---Pilih---">
                                        <option value="">--Pilih--</option>
                                        @foreach ($jenisNyeri as $jenis)
                                            <option value="{{ $jenis->id }}" @selected(old('jenis_nyeri') == $jenis->id)>
                                                {{ $jenis->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis_nyeri')
                                        <div class="invalid-feedback">
                                            {{ $error }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="row">
                                <p class="fw-bold col-sm-5">
                                    Pemeriksaan Fisik
                                    <label for="pemeriksaan_fisik"></label>
                                </p>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-secondary-subtle rounded-2">
                                        <textarea class="form-control @error('pemeriksaan_fisik') is-invalid @enderror" name="pemeriksaan_fisik"
                                            id="pemeriksaan_fisik">{{ old('pemeriksaan_fisik') }}</textarea>
                                        @error('pemeriksaan_fisik')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <p class="fw-bold">
                                        Data Objektif Lainnya
                                        <label for="data_objektif"></label>
                                    </p>
                                    <div class="bg-secondary-subtle rounded-2">
                                        <textarea class="form-control @error('data_objektif') is-invalid @enderror" name="data_objektif" id="data_objektif">{{ old('data_objektif') }}</textarea>
                                        @error('data_objektif')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <p class="fw-bold col-sm-5">Asesmen /Diagnosis</p>
                                <div class="col-sm-6">
                                    <!-- Modal 2 -->
                                    @include('unit-pelayanan.rawat-jalan.pelayanan.cppt.edit-diagnosis')
                                    {{-- <a href="#" class="btn btn-sm"><i class="bi bi-plus-square"></i>
                                        ICD-10</a> --}}
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="bg-secondary-subtle rounded-2 p-3" id="diagnoseList">
                                            {{-- <a href="#" class="fw-bold">HYPERTENSI KRONIS</a> <br>
                                            <a href="#" class="fw-bold">DYSPEPSIA</a> <br>
                                            <a href="#" class="fw-bold">DEPRESIVE EPISODE</a> <br> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <p class="fw-bold col-sm-12">
                                    Planning/ Rencana Tatalaksana
                                    <label for="planning"></label>
                                </p>
                                <div class="row">
                                    <div class="col-12">
                                        <textarea class="form-control @error('planning') is-invalid @enderror" name="planning" id="planning">{{ old('planning') }}</textarea>
                                        @error('planning')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @include('unit-pelayanan.rawat-jalan.pelayanan.cppt.modal-tindaklanjut')

                            <div class="row mt-3">
                                <div class="checkbox-container">
                                    <div class="input-group">
                                        <input type="radio" @error('tindak_lanjut') class="is-invalid" @enderror
                                            id="plan_konrol_ulang" name="tindak_lanjut" value="2"
                                            @checked(old('tindak_lanjut') == 2) required>
                                        <label for="">Kontrol ulang, tgl: <span
                                                id="tgl-kontrol-label"></span></label>
                                    </div>
                                    <div class="input-group">
                                        <input type="radio" @error('tindak_lanjut') class="is-invalid" @enderror
                                            id="plan_rujuk_internal" name="tindak_lanjut" value="4"
                                            @checked(old('tindak_lanjut') == 4) required>
                                        <label for="">Konsul/Rujuk Internal Ke: <span
                                                id="unit-rujuk-internal-label"></span></label>
                                    </div>
                                    <div class="input-group">
                                        <input type="radio" @error('tindak_lanjut') class="is-invalid" @enderror
                                            id="plan_selesai" name="tindak_lanjut" value="3"
                                            @checked(old('tindak_lanjut') == 3) required>
                                        <label for="">Selesai di Klinik ini</label>
                                    </div>

                                    <div class="input-group">
                                        <input type="radio" @error('tindak_lanjut') class="is-invalid" @enderror
                                            id="plan_rujuk" name="tindak_lanjut" value="5"
                                            @checked(old('tindak_lanjut') == 5) required>
                                        <label for="">Rujuk RS lain bagian: <span
                                                id="rs-tujuan-label"></span></label>
                                    </div>
                                    <div class="input-group">
                                        <input type="radio" @error('tindak_lanjut') class="is-invalid" @enderror
                                            id="plan_rawat_inap" name="tindak_lanjut" value="1"
                                            @checked(old('tindak_lanjut') == 1) required>
                                        <label for="">Rawat Inap</label>
                                    </div>
                                    <div class="input-grou">
                                        @error('tindak_lanjut')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- END : EDIT CPPT MODAL --}}
