@extends('layouts.administrator.master')

@section('content')
    <x-content-card>
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold">List Permintaan Darah</h4>

                    <div class="d-flex align-items-center" id="filter-list">
                        <div class="form-group">
                            <label for="kd_unit" class="form-label">Unit</label>
                            <select name="kd_unit" id="kd_unit" class="form-select select2" data-table-target="#dataTable">
                                <option value="">--Pilih--</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->kd_unit }}">{{ $unit->nama_unit }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mx-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" data-table-target="#dataTable">
                                <option value="">--Pilih--</option>
                                <option value="0">Order</option>
                                <option value="1">Diproses</option>
                                <option value="2">Diserahkan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Rentang Waktu</label>
                            <div class="input-group">
                                <input class="form-control date" type="text" id="tgl_awal" name="tgl_awal"
                                    value="" readonly="" data-table-target="#dataTable">
                                <span class="bg-primary text-light px-3 justify-content-center align-items-center d-flex">
                                    <i class="fa-solid fa-arrows-left-right"></i>
                                </span>
                                <input class="form-control date" type="text" id="tgl_akhir" name="tgl_akhir"
                                    value="" readonly="" data-table-target="#dataTable">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive text-left">
                    <table class="table table-bordered table-hover table-striped" id="dataTable">
                        <thead>
                            <tr align="middle">
                                <th>No</th>
                                <th>Tgl Permintaan</th>
                                <th>Pasien</th>
                                <th>Unit</th>
                                <th>Dokter</th>
                                <th>Petugas</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-content-card>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#dataTable').dataTable({
                ordering: true,
                processing: true,
                serverSide: true,
                ajax: {
                    'url': "{{ route('transfusi-darah.permintaan.datatable') }}",
                    'data': function(d) {
                        d.kd_unit = $('#filter-list #kd_unit').val();
                        d.status = $('#filter-list #status').val();
                        d.tgl_awal = $('#filter-list #tgl_awal').val();
                        d.tgl_akhir = $('#filter-list #tgl_akhir').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tgl_order',
                        name: 'tgl_order',
                    },
                    {
                        data: 'pasien.nama',
                        name: 'pasien.nama',
                    },
                    {
                        data: 'unit.nama_unit',
                        name: 'unit.nama_unit',
                    },
                    {
                        data: 'dokter.nama_lengkap',
                        name: 'dokter.nama_lengkap',
                    },
                    {
                        data: 'petugas_pengambilan_sampel',
                        name: 'petugas_pengambilan_sampel',
                    },
                    {
                        data: 'statuslabel',
                        name: 'status',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                'columnDefs': [{
                        "targets": 0,
                        "className": "text-center",
                    },
                    {
                        "targets": 2,
                        "className": "text-center",
                    },
                    {
                        "targets": 3,
                        "className": "text-center",
                    },
                    {
                        "targets": 6,
                        "className": "text-center",
                    },
                    {
                        "targets": 7,
                        "className": "text-center",
                    },
                ]
            });

            $('#filter-list select,input').on('change', function(e) {
                const $this = $(this);
                reloadDatatables($this.attr('data-table-target'));
            });
        });

        function reloadDatatables(tbl) {
            var table = $(tbl).DataTable();
            table.cleanData;
            table.ajax.reload();
        }
    </script>
@endpush
