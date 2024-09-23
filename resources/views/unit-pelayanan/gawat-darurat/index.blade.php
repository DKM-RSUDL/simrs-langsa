@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <style>
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
                            <th>Dokter</th>
                            <th>Tgl Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Tabel diisi oleh DataTables --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            // Server-side processing DataTables
            $('#rawatDaruratTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('gawat-darurat.index') }}", // Sesuaikan dengan route yang sesuai
                "columns": [
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    {data: 'kd_pasien', name: 'kd_pasien'},
                    {data: 'kd_dokter', name: 'kd_dokter'},
                    {data: 'tgl_masuk', name: 'tgl_masuk'},
                ],
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