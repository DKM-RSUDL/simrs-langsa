@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .header-background {
                height: 100%;
                background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form action="{{ route('rawat-jalan.tindakan-rehab-medik.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($tindakan->id)]) }}" method="post">
                @csrf
                @method('put')

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100">
                        <div class="card-header text-center border-bottom">
                            <h5 class="text-secondary fw-bold">Laporan Hasil Tindakan</h5>
                        </div>

                        <div class="card-body mt-3">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="" class="form-label">
                                            <p class="m-0 p-0 text-primary fw-bold">Nama Tindakan</p>
                                        </label>

                                        <ul class="ps-5">
                                            @foreach ($programs as $program)
                                                <li>{{ $program->produk->deskripsi }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
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
                                            @foreach ($petugas as $ptg)
                                                <option value="{{ $ptg->kd_karyawan }}" @selected($ptg->kd_karyawan == $tindakan->ppa)>{{ $ptg->gelar_depan .' '. str()->title($ptg->nama) .' '. $ptg->gelar_belakang }}</option>
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
                                                    class="form-control @error('tgl_tindakan') is-invalid @enderror" value="{{ date('Y-m-d', strtotime($tindakan->tgl_tindakan)) }}" required>
                                            </div>
                                            <div class="col-5">
                                                <input type="time" name="jam_tindakan" id="jam_tindakan"
                                                    class="form-control @error('jam_tindakan') is-invalid @enderror" value="{{ date('H:i', strtotime($tindakan->jam_tindakan)) }}" required>
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
                                                <p class="m-0 p-0 text-primary fw-bold">Hasil yang didapat</p>
                                            </label>
                                            <textarea name="hasil" id="hasil" cols="30" rows="7"
                                                class="form-control @error('hasil') is-invalid @enderror" required>{{ $tindakan->hasil }}</textarea>
                                        </div>
                                        @error('hasil')
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
                                                class="form-control @error('kesimpulan') is-invalid @enderror" required>{{ $tindakan->kesimpulan }}</textarea>
                                        </div>
                                        @error('kesimpulan')
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
                                                <p class="m-0 p-0 text-primary fw-bold">Rekomendasi</p>
                                            </label>
                                            <textarea name="rekomendasi" id="rekomendasi" cols="30" rows="5"
                                                class="form-control @error('rekomendasi') is-invalid @enderror" required>{{ $tindakan->rekomendasi }}</textarea>
                                        </div>
                                        @error('rekomendasi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection

@push('js')
    <script>
        @cannot('is-admin')
            $('#ppa').on('mousedown focusin touchstart', function(e) {
                e.preventDefault();
            });
        @endcannot
    </script>
@endpush
