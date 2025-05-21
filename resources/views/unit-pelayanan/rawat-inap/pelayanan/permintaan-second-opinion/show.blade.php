@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">    
    <style>
        .form-control:disabled {
            background-color: #f8f9fa;
            opacity: 1;
        }
        .form-check-input:disabled {
            opacity: 1;
        }
    </style>
@endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ route('rawat-inap.permintaan-second-opinion.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="btn btn-outline-info">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Detail Permintaan Second Opinion</h5>
            </div>

            <hr>

            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('rawat-inap.permintaan-second-opinion.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $secondOpinion->id]) }}" class="btn btn-warning btn-sm me-2">
                    <i class="ti-pencil"></i> Edit
                </a>
                <a href="{{ route('rawat-inap.permintaan-second-opinion.print-pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $secondOpinion->id]) }}" class="btn btn-info btn-sm" target="_blank">
                    <i class="ti-print"></i> Print PDF
                </a>
            </div>

            <div class="form-section">
                <div class="card mb-4 border-primary">
                    <div class="card-header text-dark">
                        <h6 class="mb-0">INFORMASI UMUM</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="informasi-tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="informasi-tanggal"
                                        value="{{ date('Y-m-d', strtotime($secondOpinion->informasi_tanggal)) }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="informasi-jam" class="form-label">Jam</label>
                                    <input type="time" class="form-control" id="informasi-jam"
                                        value="{{ $secondOpinion->informasi_jam ? date('H:i', strtotime($secondOpinion->informasi_jam)) : '' }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_saksi" class="form-label">Nama Saksi</label>
                                    <input type="text" class="form-control" id="nama_saksi"
                                        value="{{ $secondOpinion->nama_saksi }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Rujukan</label>
                                    <div>
                                        @if($secondOpinion->is_rujuk == '1')
                                            <div class="d-flex">
                                                <div class="form-check me-3">
                                                    <input class="form-check-input" type="checkbox" checked disabled>
                                                    <label class="form-check-label">Rujuk RS Lain</label>
                                                </div>
                                                @if($secondOpinion->rs_second_opinion)
                                                    <span class="fw-bold">: {{ $secondOpinion->rs_second_opinion }}</span>
                                                @endif
                                            </div>
                                        @else
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" disabled>
                                                <label class="form-check-label">Rujuk RS Lain</label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian Dokumen</label>
                                    <input type="date" class="form-control" id="tanggal_pengembalian"
                                        value="{{ date('Y-m-d', strtotime($secondOpinion->tanggal_pengembalian)) }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status_peminjam" class="form-label">Status Peminjam</label>
                                    <input type="text" class="form-control" value="{{ $secondOpinion->status_peminjam == 'diri_sendiri' ? 'Diri Sendiri' : 'Keluarga' }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 border-primary">
                    <div class="card-header text-dark">
                        <h6 class="mb-0">DATA PEMINJAM</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="peminjam-nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="peminjam-nama"
                                        value="{{ $secondOpinion->peminjam_nama }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div class="d-flex">
                                        <div class="form-check me-4">
                                            <input class="form-check-input" type="radio" disabled
                                                {{ $secondOpinion->jenis_kelamin == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label">Laki-laki</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" disabled
                                                {{ $secondOpinion->jenis_kelamin == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tgl_lahir"
                                        value="{{ date('Y-m-d', strtotime($secondOpinion->tgl_lahir)) }}" disabled>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_kartu_identitas" class="form-label">No Kartu Identitas</label>
                                    <input type="text" class="form-control" id="no_kartu_identitas"
                                        value="{{ $secondOpinion->no_kartu_identitas }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat" rows="3" disabled>{{ $secondOpinion->alamat }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="hubungan" class="form-label">Hubungan dengan Pasien</label>
                                    <input type="text" class="form-control" id="hubungan"
                                        value="{{ $secondOpinion->hubungan }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 border-primary">
                    <div class="card-header text-dark">
                        <h6 class="mb-0">DOKUMEN</h6>
                    </div>
                    <div class="card-body">
                        @if($secondOpinion->nama_dokumen)
                            @php
                                // Decode JSON karena data disimpan sebagai JSON string di database
                                $dokumenArray = json_decode($secondOpinion->nama_dokumen, true);
                            @endphp

                            @if(is_array($dokumenArray) && count($dokumenArray) > 0)
                                <div id="dokumen_container">
                                    @foreach($dokumenArray as $index => $dokumen)
                                        <div class="row mb-3 dokumen-item">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Nama Dokumen {{ $loop->iteration }}</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $dokumen }}" disabled readonly>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="ti-info-alt me-1"></i> Tidak ada dokumen yang tercatat.
                                </div>
                            @endif
                        @else
                            <div class="alert alert-info">
                                <i class="ti-info-alt me-1"></i> Tidak ada dokumen yang tercatat.
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the DATA PEMINJAM card
        const dataPeminjamCard = document.querySelector('.card.mb-4.border-primary:nth-of-type(2)');
        
        // Check status_peminjam value
        const statusPeminjam = "{{ $secondOpinion->status_peminjam }}";
        
        // Show/hide DATA PEMINJAM card based on status
        if (statusPeminjam === 'keluarga') {
            dataPeminjamCard.style.display = 'block';
        } else {
            dataPeminjamCard.style.display = 'none';
        }
    });
</script>
@endpush