@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .table-responsive {
            overflow-x: auto;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .badge-filled {
            background-color: #28a745;
            color: white;
        }
        .badge-empty {
            background-color: #dc3545;
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-ranap')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#" class="nav-link active" aria-selected="true">Evaluasi Harian/Catatan Observasi</a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                <div class="d-flex justify-content-end mb-3">
                                    <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#printModal">
                                        <i class="fa fa-print"></i> Print Laporan
                                    </button>
                                    <a href="{{ route('rawat-inap.observasi.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                        class="btn btn-primary">
                                        <i class="ti-plus"></i> Tambah
                                    </a>
                                </div>

                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr align="middle">
                                                    <th width="50px">No</th>
                                                    <th>Tanggal</th>
                                                    <th>Berat Badan</th>
                                                    <th>Sensorium</th>
                                                    <th>Waktu Pengisian</th>
                                                    <th>Petugas</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($observasiList as $index => $observasi)
                                                    <tr>
                                                        <td align="middle">{{ $index + 1 }}</td>
                                                        <td align="middle">{{ $observasi->tanggal->format('d-m-Y') }}</td>
                                                        <td align="middle">{{ $observasi->berat_badan }} kg</td>
                                                        <td align="middle">{{ $observasi->sensorium }}</td>
                                                        <td align="middle">
                                                            @php
                                                                $details = $observasi->details->pluck('waktu')->toArray();
                                                            @endphp
                                                            <span class="badge {{ in_array('06:00', $details) ? 'badge-filled' : 'badge-empty' }}">06:00</span>
                                                            <span class="badge {{ in_array('12:00', $details) ? 'badge-filled' : 'badge-empty' }}">12:00</span>
                                                            <span class="badge {{ in_array('18:00', $details) ? 'badge-filled' : 'badge-empty' }}">18:00</span>
                                                            <span class="badge {{ in_array('24:00', $details) ? 'badge-filled' : 'badge-empty' }}">24:00</span>
                                                        </td>
                                                        <td>{{ $observasi->creator->name ?? 'Tidak Diketahui' }}</td>
                                                        <td align="middle">
                                                            <a href="{{ route('rawat-inap.observasi.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $observasi->id]) }}"
                                                                class="btn btn-sm btn-success ms-1">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('rawat-inap.observasi.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $observasi->id]) }}"
                                                                class="btn btn-sm btn-warning mx-1">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <button class="btn btn-sm btn-danger btn-delete"
                                                                data-id="{{ $observasi->id }}"
                                                                data-url="{{ route('rawat-inap.observasi.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $observasi->id]) }}">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" align="middle">Belum ada data observasi.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Modal -->
    <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printModalLabel">Print Laporan Observasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rawat-inap.observasi.print', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" method="GET" target="_blank">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" 
                                        value="{{ $minDate ? date('Y-m-d', strtotime($minDate)) : '' }}"
                                        min="{{ $minDate ? date('Y-m-d', strtotime($minDate)) : '' }}"
                                        max="{{ $maxDate ? date('Y-m-d', strtotime($maxDate)) : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="{{ $maxDate ? date('Y-m-d', strtotime($maxDate)) : '' }}"
                                        min="{{ $minDate ? date('Y-m-d', strtotime($minDate)) : '' }}"
                                        max="{{ $maxDate ? date('Y-m-d', strtotime($maxDate)) : '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-info">
                            <p class="mb-1"><i class="fa fa-info-circle"></i> Catatan: Pastikan rentang tanggal sudah benar, Data akan diurutkan berdasarkan tanggal (dari terlama ke terbaru)</p>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-print"></i> Generate PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Delete button functionality
            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const url = this.getAttribute('data-url');
                    const id = this.getAttribute('data-id');
                    console.log('Delete URL:', url); // Debug the URL

                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: 'Apakah Anda yakin ingin menghapus data observasi ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = url;

                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = csrfToken;
                            form.appendChild(csrfInput);

                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';
                            form.appendChild(methodInput);

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });

            // Print modal date validation
            document.getElementById('start_date').addEventListener('change', function() {
                document.getElementById('end_date').min = this.value;
                
                // If end date is before start date, update it
                if (document.getElementById('end_date').value < this.value) {
                    document.getElementById('end_date').value = this.value;
                }
            });
            
            // Set maximum start date based on end date selection
            document.getElementById('end_date').addEventListener('change', function() {
                document.getElementById('start_date').max = this.value;
                
                // If start date is after end date, update it
                if (document.getElementById('start_date').value > this.value) {
                    document.getElementById('start_date').value = this.value;
                }
            });
        });
    </script>
@endpush