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
                                                        <td>{{ $observasi->perawat ? $observasi->perawat->nama : '-' }}</td>
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
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
        });
    </script>
@endpush
