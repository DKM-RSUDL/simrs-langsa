@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Detail Pelayanan Medis',
                    'description' => 'Lihat informasi lengkap mengenai pelayanan medis pasien.',
                ])

                <div class="d-flex flex-column gap-4">
                    <!-- Waktu Pelayanan -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="waktu_pelayanan">Waktu Pelayanan</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="date" class="form-control"
                                        value="{{ date('Y-m-d', strtotime($layanan->tgl_pelayanan)) }}" disabled>
                                </div>
                                <div class="col-6">
                                    <input type="time" class="form-control"
                                        value="{{ date('H:i', strtotime($layanan->jam_pelayanan)) }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="dokter">Dokter</label>
                            <select class="form-control" id="dokter" name="dokter" disabled>
                                <option value="{{ $layanan->kd_dokter }}" selected>
                                    {{ $layanan->dokter->nama_lengkap ?? '-' }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <hr>

                    <!-- Anamnesa & Pemeriksaan -->
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="fw-bold">Anamesa</label>
                            <textarea class="form-control" style="height: 100px" disabled>{{ $layanan->subjective ?? '-' }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="fw-bold">Objective</label>
                            <textarea class="form-control" style="height: 100px" disabled>{{ $layanan->objective ?? '-' }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="fw-bold">Assessment</label>
                            <textarea class="form-control" style="height: 100px" disabled>{{ $layanan->assessment ?? '-' }}</textarea>
                        </div>

                        <!-- Program / Tindakan -->
                        <div class="col-md-12">
                            <label class="fw-bold">Procedure</label>
                            <div class="w-100 mt-3 border rounded p-3 bg-light" id="program-container">
                                @if ($program && count($program->detail) > 0)
                                    @foreach ($program->detail as $item)
                                        <div
                                            class="d-flex justify-content-between align-items-center border rounded p-2 mb-2 bg-white shadow-sm">
                                            <p class="fw-bold text-primary m-0">{{ $item->produk->deskripsi }}</p>
                                            <small class="text-muted">
                                                {{ $item->kd_produk }} — Rp{{ number_format($item->tarif, 0, ',', '.') }}
                                            </small>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-muted m-0 small">Belum ada tindakan dipilih.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </x-content-card>
        </div>
    </div>
@endsection
