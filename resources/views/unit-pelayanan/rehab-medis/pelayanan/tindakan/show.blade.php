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
            <x-content-card>
                <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Detail Data Hasil Tindakan',
                ])


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
                            <select name="ppa" id="ppa" class="form-control @error('ppa') is-invalid @enderror"
                                disabled>
                                <option value="">--Pilih PPA--</option>
                                @foreach ($petugas as $ptg)
                                    <option value="{{ $ptg->kd_karyawan }}" @selected($ptg->kd_karyawan == $tindakan->ppa)>
                                        {{ $ptg->gelar_depan . ' ' . str()->title($ptg->nama) . ' ' . $ptg->gelar_belakang }}
                                    </option>
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
                                        class="form-control @error('tgl_tindakan') is-invalid @enderror"
                                        value="{{ date('Y-m-d', strtotime($tindakan->tgl_tindakan)) }}" disabled>
                                </div>
                                <div class="col-5">
                                    <input type="time" name="jam_tindakan" id="jam_tindakan"
                                        class="form-control @error('jam_tindakan') is-invalid @enderror"
                                        value="{{ date('H:i', strtotime($tindakan->jam_tindakan)) }}" disabled>
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
                                    class="form-control @error('hasil') is-invalid @enderror" disabled>{{ $tindakan->hasil }}</textarea>
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
                                    class="form-control @error('kesimpulan') is-invalid @enderror" disabled>{{ $tindakan->kesimpulan }}</textarea>
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
                                    class="form-control @error('rekomendasi') is-invalid @enderror" disabled>{{ $tindakan->rekomendasi }}</textarea>
                            </div>
                            @error('rekomendasi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </div>
    </x-content-card>
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
