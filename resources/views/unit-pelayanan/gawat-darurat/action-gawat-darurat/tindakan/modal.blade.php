<div class="modal fade" id="addTindakanModal" tabindex="-1" aria-labelledby="addTindakanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form
                action="{{ route('tindakan.store', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                method="post" enctype="multipart/form-data" id="addTindakanForm">
                @csrf

                <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="addTindakanModalLabel">
                        Laporan Hasil Tindakan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class="form-label">
                                    <p class="m-0 p-0 text-primary fw-bold">Nama Tindakan</p>
                                </label>
                                <select name="tindakan" id="tindakan"
                                    class="form-control select2 @error('tindakan') is-invalid @enderror" required>
                                    <option value="">--Pilih Tindakan--</option>
                                    @foreach ($produk as $prd)
                                        <option data-tarif="{{ $prd->tarif }}" data-tgl="{{ $prd->tgl_berlaku }}"
                                            value="{{ $prd->kd_produk }}">{{ $prd->deskripsi }}</option>
                                    @endforeach
                                </select>

                                @error('tindakan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <input type="hidden" name="tarif_tindakan" id="tarif_tindakan">
                            <input type="hidden" name="tgl_berlaku" id="tgl_berlaku">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-7">
                            <div class="form-group">
                                <label for="" class="form-label">
                                    <p class="m-0 p-0 text-primary fw-bold">PPA</p>
                                </label>
                                <select name="ppa" id="ppa"
                                    class="form-control @error('ppa') is-invalid @enderror" required
                                    onfocus="this.blur()">
                                    <option value="">--Pilih PPA--</option>
                                    @foreach ($dokter as $dok)
                                        <option value="{{ $dok->dokter->kd_dokter }}" @selected($dok->dokter->kd_karyawan == auth()->user()->kd_karyawan)>
                                            {{ $dok->dokter->nama_lengkap }}</option>
                                    @endforeach
                                </select>

                                @error('ppa')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label for="" class="form-label">
                                    <p class="m-0 p-0 text-primary fw-bold">Tanggal Jam</p>
                                </label>

                                <div class="row">
                                    <div class="col-7">
                                        <input type="date" name="tgl_tindakan" id="tgl_tindakan"
                                            class="form-control @error('tgl_tindakan') is-invalid @enderror" required>
                                    </div>
                                    <div class="col-5">
                                        <input type="time" name="jam_tindakan" id="jam_tindakan"
                                            class="form-control @error('jam_tindakan') is-invalid @enderror" required>
                                    </div>
                                </div>

                                @error('tgl_tindakan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @error('jam_tindakan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="" class="form-label">
                                        <p class="m-0 p-0 text-primary fw-bold">laporan Hasil Tindakan</p>
                                    </label>
                                    <textarea name="laporan" id="laporan" cols="30" rows="7"
                                        class="form-control @error('laporan') is-invalid @enderror"></textarea>
                                </div>
                                @error('laporan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="" class="form-label">
                                        <p class="m-0 p-0 text-primary fw-bold">Kesimpulan</p>
                                    </label>
                                    <textarea name="kesimpulan" id="kesimpulan" cols="30" rows="5"
                                        class="form-control @error('kesimpulan') is-invalid @enderror"></textarea>
                                </div>
                                @error('kesimpulan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="" class="form-label">
                                        <p class="m-0 p-0 text-primary fw-bold">Gambar</p>
                                    </label>

                                    <div id="gambarTindakanLabel" tabindex="0"
                                        class="form-control text-center px-5 @error('gambar_tindakan') is-invalid @enderror">
                                        <p class="text-primary m-0 p-0">Upload gambar</p>
                                        <div class="py-5 img-tindakan-wrap">
                                            <img src="{{ asset('assets/images/avatar1.png') }}" alt=""
                                                width="70">
                                        </div>
                                    </div>

                                    <input type="file" name="gambar_tindakan" id="gambar_tindakan"
                                        class="d-none">
                                </div>

                                @error('gambar_tindakan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <x-button-submit />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editTindakanModal" tabindex="-1" aria-labelledby="editTindakanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('tindakan.update', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                method="post" enctype="multipart/form-data" id="editTindakanForm">
                @csrf
                @method('put')

                <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="editTindakanModalLabel">
                        Edit Laporan Hasil Tindakan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class="form-label">
                                    <p class="m-0 p-0 text-primary fw-bold">Nama Tindakan</p>
                                </label>
                                <select name="tindakan" id="tindakan"
                                    class="form-control select2 @error('tindakan') is-invalid @enderror" required>
                                    <option value="">--Pilih Tindakan--</option>
                                    @foreach ($produk as $prd)
                                        <option data-tarif="{{ $prd->tarif }}" data-tgl="{{ $prd->tgl_berlaku }}"
                                            value="{{ $prd->kd_produk }}">{{ $prd->deskripsi }}</option>
                                    @endforeach
                                </select>

                                @error('tindakan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <input type="hidden" name="no_transaksi" id="no_transaksi"
                                value="{{ $dataMedis->no_transaksi }}">
                            <input type="hidden" name="urut_masuk" id="urut_masuk"
                                value="{{ $dataMedis->urut_masuk }}">
                            <input type="hidden" name="old_kd_produk" id="old_kd_produk">
                            <input type="hidden" name="urut_list" id="urut_list">
                            <input type="hidden" name="tarif_tindakan" id="tarif_tindakan">
                            <input type="hidden" name="tgl_berlaku" id="tgl_berlaku">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-7">
                            <div class="form-group">
                                <label for="" class="form-label">
                                    <p class="m-0 p-0 text-primary fw-bold">PPA</p>
                                </label>
                                <select name="ppa" id="ppa"
                                    class="form-control @error('ppa') is-invalid @enderror" required>
                                    <option value="">--Pilih PPA--</option>
                                    @foreach ($dokter as $dok)
                                        <option value="{{ $dok->dokter->kd_dokter }}">
                                            {{ $dok->dokter->nama_lengkap }}</option>
                                    @endforeach
                                </select>

                                @error('ppa')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label for="" class="form-label">
                                    <p class="m-0 p-0 text-primary fw-bold">Tanggal Jam</p>
                                </label>

                                <div class="row">
                                    <div class="col-7">
                                        <input type="date" name="tgl_tindakan" id="tgl_tindakan"
                                            class="form-control @error('tgl_tindakan') is-invalid @enderror" required>
                                    </div>
                                    <div class="col-5">
                                        <input type="time" name="jam_tindakan" id="jam_tindakan"
                                            class="form-control @error('jam_tindakan') is-invalid @enderror" required>
                                    </div>
                                </div>

                                @error('tgl_tindakan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @error('jam_tindakan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="" class="form-label">
                                        <p class="m-0 p-0 text-primary fw-bold">laporan Hasil Tindakan</p>
                                    </label>
                                    <textarea name="laporan" id="laporan" cols="30" rows="7"
                                        class="form-control @error('laporan') is-invalid @enderror" required></textarea>
                                </div>
                                @error('laporan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="" class="form-label">
                                        <p class="m-0 p-0 text-primary fw-bold">Kesimpulan</p>
                                    </label>
                                    <textarea name="kesimpulan" id="kesimpulan" cols="30" rows="5"
                                        class="form-control @error('kesimpulan') is-invalid @enderror" required></textarea>
                                </div>
                                @error('kesimpulan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="" class="form-label">
                                        <p class="m-0 p-0 text-primary fw-bold">Gambar</p>
                                    </label>

                                    <div id="gambarTindakanLabel" tabindex="0"
                                        class="form-control text-center px-5 @error('gambar_tindakan') is-invalid @enderror">
                                        <p class="text-primary m-0 p-0">Upload gambar</p>
                                        <div class="py-5 img-tindakan-wrap">
                                            <img src="{{ asset('assets/images/avatar1.png') }}" alt=""
                                                width="70">
                                        </div>
                                    </div>

                                    <input type="file" name="gambar_tindakan" id="gambar_tindakan"
                                        class="d-none">
                                </div>

                                @error('gambar_tindakan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <x-button-submit>Perbarui</x-button-submit>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="showTindakanModal" tabindex="-1" aria-labelledby="showTindakanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="editTindakanModalLabel">
                    Laporan Hasil Tindakan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-primary fw-bold">Nama Tindakan :</p>
                                <p id="tindakan"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-7">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-primary fw-bold">PPA :</p>
                                <p id="ppa"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-primary fw-bold">Waktu Tindakan :</p>
                                <p id="waktu_tindakan"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-primary fw-bold">Laporan Hasil Tindakan :</p>
                                <p id="laporan"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-primary fw-bold">Kesimpulan :</p>
                                <p id="kesimpulan"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-primary fw-bold">Gambar :</p>
                                <div class="img-tindakan-wrap">
                                    <img src="{{ asset('assets/images/avatar1.png') }}" alt=""
                                        id="gambar_tindakan" width="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
