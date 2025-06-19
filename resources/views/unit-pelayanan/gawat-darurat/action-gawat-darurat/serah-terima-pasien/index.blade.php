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
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Serah Terima Pasien Antar Ruang</h5>
            </div>

            <hr>
            <div class="form-section">

                <form
                    action="{{ route('serah-terima-pasien.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($serahTerimaData->id)]) }}"
                    method="post">
                    @csrf
                    @method('put')

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-4">
                                <h5 class="fw-bold">SBAR</h5>
                                <div class="row g-3">
                                    <div class="col-12 mb-3">
                                        <label>Subjective</label>
                                        <textarea name="subjective" placeholder="Data subjektif" class="form-control" rows="5" required
                                            @disabled($serahTerimaData->status != 0)>{{ old('subjective', $serahTerimaData->subjective ?? '') }}</textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Background</label>
                                        <textarea name="background" placeholder="Background" class="form-control" rows="5" required
                                            @disabled($serahTerimaData->status != 0)>{{ old('background', $serahTerimaData->background ?? '') }}</textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Assessment</label>
                                        <textarea name="assessment" placeholder="Assessment" class="form-control" rows="5" required
                                            @disabled($serahTerimaData->status != 0)>{{ old('assessment', $serahTerimaData->assessment ?? '') }}</textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Recommendation</label>
                                        <textarea name="recomendation" placeholder="Recommendation" class="form-control" rows="5" required
                                            @disabled($serahTerimaData->status != 0)>{{ old('recomendation', $serahTerimaData->recomendation ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-4">
                                <h5 class="fw-bold">Yang Menyerahkan:</h5>
                                <div class="mb-3">
                                    <label for="kd_unit_asal">Dari Unit/ Ruang</label>
                                    <select name="kd_unit_asal" id="kd_unit_asal" class="form-select select2" disabled>
                                        <option value="">--Pilih--</option>
                                        @foreach ($unit as $item)
                                            <option value="{{ $item->kd_unit }}" @selected($item->kd_unit == 3)>
                                                {{ $item->nama_unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="kd_unit_tujuan">Tujuan ke Unit/ Ruang</label>
                                    <select name="kd_unit_tujuan" id="kd_unit_tujuan" class="form-select select2" disabled>
                                        <option value="">--Pilih--</option>
                                        @foreach ($unitTujuan as $item)
                                            <option value="{{ $item->kd_unit }}" @selected($item->kd_unit == $serahTerimaData->kd_unit_tujuan)>
                                                {{ $item->nama_unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="petugas_menyerahkan">Petugas yang Menyerahkan</label>
                                    <select name="petugas_menyerahkan" id="petugas_menyerahkan" class="form-select select2">
                                        <option value="">--Pilih--</option>
                                        <option
                                            value="{{ $serahTerimaData->petugas_menyerahkan ?? auth()->user()->kd_karyawan }}"
                                            selected>
                                            {{ $serahTerimaData->petugasAsal->name ?? auth()->user()->name }}
                                        </option>

                                        @foreach ($petugasIGD as $item)
                                            @if ($item->kd_karyawan != auth()->user()->kd_karyawan && $item->kd_karyawan != $serahTerimaData->petugas_menyerahkan)
                                                <option value="{{ $item->kd_karyawan }}">
                                                    {{ $item->gelar_depan . ' ' . str()->title($item->nama) . ' ' . $item->gelar_belakang }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label>Tanggal</label>
                                        <input type="date" name="tanggal_menyerahkan"
                                            value="{{ !empty($serahTerimaData->tanggal_menyerahkan) ? date('Y-m-d', strtotime($serahTerimaData->tanggal_menyerahkan)) : date('Y-m-d') }}"
                                            class="form-control" required @disabled($serahTerimaData->status != 0)>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Jam</label>
                                        <input type="time" name="jam_menyerahkan"
                                            value="{{ !empty($serahTerimaData->jam_menyerahkan) ? date('H:i', strtotime($serahTerimaData->jam_menyerahkan)) : date('H:i') }}"
                                            class="form-control" required @disabled($serahTerimaData->status != 0)>
                                    </div>
                                </div>
                                {{-- <button type="button" class="btn btn-primary w-100">Validasi petugas yang menerima</button> --}}
                            </div>

                            <div class="mb-4">
                                <h5 class="fw-bold">Yang Menerima:</h5>
                                <div class="mb-3">
                                    <label>Diterima di Ruang/ Unit Pelayanan</label>
                                    <input type="text" class="form-control"
                                        value="{{ $serahTerimaData->unitTujuan->nama_unit ?? '' }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label>Petugas yang Menerima</label>
                                    <input type="text" class="form-control"
                                        value="{{ $serahTerimaData->petugasTerima->name ?? '' }}" disabled>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label>Tanggal</label>
                                        <input type="date"
                                            value="{{ !empty($serahTerimaData->tanggal_terima) ? date('H:i', strtotime($serahTerimaData->tanggal_terima)) : '' }}"
                                            class="form-control" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Jam</label>
                                        <input type="time"
                                            value="{{ !empty($serahTerimaData->jam_terima) ? date('H:i', strtotime($serahTerimaData->jam_terima)) : '' }}"
                                            class="form-control" disabled>
                                    </div>
                                </div>
                                {{-- <button type="button" class="btn btn-primary w-100">Validasi petugas yang menerima</button> --}}
                            </div>
                        </div>
                    </div>

                    @if ($serahTerimaData->status == 0)
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-danger">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        @cannot('is-admin')
            $('#petugas_menyerahkan').on('mousedown focusin touchstart', function(e) {
                e.preventDefault();
            });
        @endcannot
    </script>
@endpush
