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
                    'title' => 'Rincian Operasi (IBS)',
                    'description' => 'Rincian data operasi (IBS) pasien rawat inap.',
                ])

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Tgl. Registrasi</label>
                        <div>{{ $operasi->tgl_op ? date('Y-m-d', strtotime($operasi->tgl_op)) : '-' }} {{ $operasi->jam_op ? date('H:i', strtotime($operasi->jam_op)) : '' }}</div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Tgl. Jadwal</label>
                        <div>{{ $operasi->tgl_jadwal ? date('Y-m-d', strtotime($operasi->tgl_jadwal)) : '-' }}</div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <div>
                            @if ($operasi->status === 0 || $operasi->status === '0')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif ($operasi->status === 1 || $operasi->status === '1')
                                <span class="badge bg-primary">Disetujui</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jenis Tindakan</label>
                        <div>{{ optional($operasi->produk)->deskripsi ?? ($operasi->kd_produk ?? '-') }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jenis Operasi</label>
                        <div>{{ optional($operasi->jenisOperasi)->jenis_op ?? ($operasi->kd_jenis_op ?? '-') }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Spesialisasi</label>
                        <div>{{ optional($operasi->spesialisasi)->spesialisasi ?? ($operasi->kd_spc ?? '-') }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Sub Spesialisasi</label>
                        <div>{{ optional($operasi->subSpesialisasi)->sub_spesialisasi ?? ($operasi->kd_sub_spc ?? '-') }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kamar Operasi</label>
                        <div>{{ optional($operasi->kamar)->nama_kamar ?? ($operasi->no_kamar ?? ($operasi->kd_unit_kamar ?? '-')) }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Dokter</label>
                        <div>{{ optional($operasi->dokter)->nama ?? ($operasi->kd_dokter ?? '-') }}</div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Diagnosis Medis</label>
                        <div>{{ $operasi->diagnosis ?? '-' }}</div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Catatan</label>
                        <div>{{ $operasi->catatan ?? '-' }}</div>
                    </div>
                </div>
            </x-content-card>
        </div>
    </div>
@endsection
