@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <<style>
            .badge {
                width: 30px;
                height: 30px;
                border-radius: 50%;
            }
            .badge-triage-yellow {
                background-color: #ffeb3b;
            }
            .badge-triage-red {
                background-color: #f44336;
            }
            .badge-triage-green {
                background-color: #4caf50;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-12">
            <h4 class="fw-bold">Gawat Darurat</h4>
            <div class="d-flex justify-content-end align-items-end gap-3">
                <div class="d-flex align-items-center">
                    <label for="dokterSelect" class="form-label me-2">Dokter:</label>
                    <select class="form-select" id="dokterSelect" aria-label="Pilih dokter">
                        <option value="semua" selected>Semua</option>
                        <option value="dokter1">dr. A</option>
                        <option value="dokter2">dr. B</option>
                        <option value="dokter3">dr. C</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary btn-sm" id="createRawatDarurat">
                    <i class="ti-plus"></i>
                    Tambah Data
                </button>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="table-responsive text-left">
                <table class="table table-bordered dataTable" id="rawatDaruratTable">
                    <thead>
                        <tr>
                            <th width="100px">Action</th>
                            <th>Pasien</th>
                            <th>Triase</th>
                            <th>Bed</th>
                            <th>No RM/ Reg</th>
                            <th>Alamat</th>
                            <th>Jaminan</th>
                            <th>Tgl Masuk</th>
                            <th>Dokter</th>
                            <th>Instruksi</th>
                            <th>Del</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($DataKunjungan as $item)
                            <tr>
                                <td>
                                    <a href="" class="btn btn-sm btn-secondary"><i class="ti-pencil-alt"></i></a>
                                    <a href="" class="btn btn-sm btn-secondary">...</a>
                                </td>

                                <td class="d-flex align-items-center">
                                    <img class="rounded-circle" src="{{ asset('assets/images/avatar1.png') }}" alt="person" width="50" height="50">
                                    <div class="ms-3">
                                        <span class="d-block fw-bold" style="font-size: 16px;">M.Anas</span>
                                        <span class="text-muted" style="font-size: 14px;">Laki-Laki/ 43 Tahun</span>
                                    </div>
                                </td>
                                <td><span class="badge badge-triage-green"> </span></td>
                                <td>12</td>
                                <td>RM: {{ $item->kd_pasien }} <br> Reg : 00000001</td>
                                <td>{{ $item->alamat }}</td>
                                <td>BPJS Kesehatan</td>
                                <td>{{ \Carbon\Carbon::parse($item->tgl_masuk)->translatedFormat('d F Y') }}</td>
                                <td>{{ $item->kd_dokter }}</td>
                                <td>Instruksi</td>
                                <td>
                                    <form action="" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#rawatDaruratTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endpush
