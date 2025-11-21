@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .header-background {
            height: 100%;
            background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
        }
    </style>
@endpush

@section('content')
    @php
        $transferFormReady =
            !empty($serahTerima->kd_spesial) &&
            !empty($serahTerima->kd_dokter) &&
            !empty($serahTerima->kd_kelas) &&
            !empty($serahTerima->no_kamar);
    @endphp

    <div class="row">
        <div class="col-md-3">

            <div class="card h-auto sticky-top" style="top:1rem; z-index: 0;">
                <div class="card-body">
                    <div class="position-absolute top-0 end-0 p-3 d-flex flex-column align-items-center gap-1">
                        <span class="d-block rounded-circle bg-danger" style="width:8px;height:8px;"></span>
                        <span class="d-block rounded-circle bg-warning" style="width:8px;height:8px;"></span>
                        <span class="d-block rounded-circle bg-success" style="width:8px;height:8px;"></span>
                    </div>

                    <div class="row g-3">
                        {{-- Foto pasien --}}
                        <div class="col-5">
                            <img src="{{ asset('assets/img/profile.jpg') }}" alt="Patient Photo"
                                class="object-fit-cover rounded w-100 h-100">
                        </div>

                        {{-- Info pasien --}}
                        <div class="col-7 col-md-12 d-flex flex-column justify-content-center">
                            <h6 class="h6 mb-1 fw-semibold">
                                {{ $serahTerima->pasien->nama ?? 'Tidak Diketahui' }}
                            </h6>

                            <p class="mb-1">
                                @if (($serahTerima->pasien->jenis_kelamin ?? '') == 1)
                                    Laki-laki
                                @elseif (($serahTerima->pasien->jenis_kelamin ?? '') == 0)
                                    Perempuan
                                @else
                                    Tidak Diketahui
                                @endif
                            </p>

                            <div class="small text-body-secondary mb-2">
                                {{ !empty($serahTerima->pasien->tgl_lahir) ? hitungUmur($serahTerima->pasien->tgl_lahir) : 'Tidak Diketahui' }}
                                Thn
                                (
                                {{ $serahTerima->pasien->tgl_lahir
                                    ? \Carbon\Carbon::parse($serahTerima->pasien->tgl_lahir)->format('d/m/Y')
                                    : 'Tidak Diketahui' }}
                                )
                            </div>

                            <div class="d-flex flex-column gap-1">
                                <div class="fw-semibold">
                                    RM: {{ $serahTerima->pasien->kd_pasien ?? '-' }}
                                </div>

                                <div class="d-inline-flex align-items-start gap-2">
                                    <i class="bi bi-hospital"></i>
                                    <span>
                                        {{ $serahTerima->unitTujuan->bagian->bagian ?? '-' }}
                                        ({{ $serahTerima->unitTujuan->nama_unit ?? '-' }})
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-9">

            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Serah Terima Pasien Antar Ruang',
                    'description' => 'Lengkapi form serah terima pasien antar ruang berikut ini',
                ])

                <form
                    action="{{ route('rawat-inap.unit.serah-terima.store', [$serahTerima->kd_unit_tujuan, encrypt($serahTerima->id)]) }}"
                    method="post">
                    @csrf
                    @method('put')

                    <div class="row">
                        @if ($transferFormReady)
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h5 class="fw-bold">SBAR</h5>
                                    <div class="row g-3">
                                        <div class="col-12 mb-3">
                                            <label>Subjective</label>
                                            <textarea name="subjective" placeholder="Data subjektif" class="form-control" rows="5" disabled>{{ old('subjective', $serahTerima->subjective ?? '') }}</textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label>Background</label>
                                            <textarea name="background" placeholder="Background" class="form-control" rows="5" disabled>{{ old('background', $serahTerima->background ?? '') }}</textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label>Assessment</label>
                                            <textarea name="assessment" placeholder="Assessment" class="form-control" rows="5" disabled>{{ old('assessment', $serahTerima->assessment ?? '') }}</textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label>Recommendation</label>
                                            <textarea name="recomendation" placeholder="Recommendation" class="form-control" rows="5" disabled>{{ old('recomendation', $serahTerima->recomendation ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="{{ $transferFormReady ? 'col-md-6' : 'col-12' }}">
                            <div class="row">
                                <div class="{{ $transferFormReady ? 'mb-4' : 'col-md-6' }}">
                                    <h5 class="fw-bold">Yang Menyerahkan:</h5>
                                    <div class="mb-3">
                                        <label for="kd_unit_asal">Dari Unit/ Ruang</label>
                                        <input type="text" class="form-control"
                                            value="{{ $serahTerima->unitAsal->nama_unit ?? '' }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kd_unit_tujuan">Tujuan ke Unit/ Ruang</label>
                                        <input type="text" class="form-control"
                                            value="{{ $serahTerima->unitTujuan->nama_unit ?? '' }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="petugas_menyerahkan">Petugas yang Menyerahkan</label>
                                        <input type="text" class="form-control"
                                            value="{{ ($serahTerima->petugasAsal->gelar_depan ?? '') . ' ' . str()->title($serahTerima->petugasAsal->nama ?? '') . ' ' . ($serahTerima->petugasAsal->gelar_belakang ?? '') }}"
                                            disabled>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label>Tanggal</label>
                                            <input type="date" name="tanggal_menyerahkan"
                                                value="{{ !empty($serahTerima->tanggal_menyerahkan) ? date('Y-m-d', strtotime($serahTerima->tanggal_menyerahkan)) : '' }}"
                                                class="form-control" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Jam</label>
                                            <input type="time" name="jam_menyerahkan"
                                                value="{{ !empty($serahTerima->jam_menyerahkan) ? date('H:i', strtotime($serahTerima->jam_menyerahkan)) : date('H:i') }}"
                                                class="form-control" disabled>
                                        </div>
                                    </div>
                                    {{-- <button type="button" class="btn btn-primary w-100">Validasi petugas yang menerima</button> --}}
                                </div>

                                <div class="{{ $transferFormReady ? 'mb-4' : 'col-md-6' }}">
                                    <h5 class="fw-bold">Yang Menerima:</h5>
                                    <div class="mb-3">
                                        <label>Diterima di Ruang/ Unit Pelayanan</label>
                                        <input type="text" class="form-control"
                                            value="{{ $serahTerima->unitTujuan->nama_unit ?? '' }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label>Petugas yang Menerima</label>
                                        <select name="petugas_terima" id="petugas_terima" class="form-select select2">
                                            <option value="">--Pilih--</option>
                                            <option
                                                value="{{ $serahTerima->petugas_terima ?? auth()->user()->kd_karyawan }}"
                                                selected>
                                                {{ $serahTerima->petugasTerima->name ?? auth()->user()->name }}
                                            </option>

                                            @foreach ($petugas as $item)
                                                @if ($item->kd_karyawan != auth()->user()->kd_karyawan && $item->kd_karyawan != $serahTerima->petugas_terima)
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
                                            <input type="date" name="tanggal_terima"
                                                value="{{ !empty($serahTerima->tanggal_terima) ? date('Y-m-d', strtotime($serahTerima->tanggal_terima)) : date('Y-m-d') }}"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Jam</label>
                                            <input type="time" name="jam_terima"
                                                value="{{ !empty($serahTerima->jam_terima) ? date('H:i', strtotime($serahTerima->jam_terima)) : date('H:i') }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    {{-- <button type="button" class="btn btn-primary w-100">Validasi petugas yang menerima</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($serahTerima->status == 1)
                        <div class="d-flex justify-content-end gap-2">
                            <x-button-submit>Terima Order</x-button-submit>
                        </div>
                    @endif
                </form>
            </x-content-card>
        </div>
    </div>
@endsection
