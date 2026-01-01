@extends('layouts.administrator.master')

@push('css')
    <style>
        .tab-minimal {
            border-bottom: 1px solid #e5e7eb;
        }

        .tab-minimal .tab-link {
            background: none;
            border: 1px solid transparent;
            padding: 6px 12px;
            font-size: 14px;
            color: #9ca3af;
            font-weight: 500;
            position: relative;
            cursor: pointer;

            /* rounded di atas saja */
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .tab-minimal .tab-link.active {
            color: #111827;
            font-weight: 600;
            background-color: #ffffff;
            border-color: #e5e7eb;
            border-bottom-color: transparent;
            /* nyatu ke konten */
        }

        .tab-minimal .tab-link.active::after {
            content: "";
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #3b82f6;
        }


        /* Profile */
        .profile {
            display: flex;
            align-items: center;
        }

        .profile img {
            margin-right: 10px;
            border-radius: 50%;
        }

        .profile .info {
            display: flex;
            flex-direction: column;
        }

        .profile .info strong {
            font-size: 14px;
        }

        .profile .info span {
            font-size: 12px;
            color: #777;
        }
    </style>
@endpush

@section('content')
    @php
        $tabReq = $_GET['pel'] ?? 'ri';
        $tabArr = ['ri', 'rj']; // 'ri' for Rawat Inap, 'rj' for Rawat Jalan
        $tab = in_array($tabReq, $tabArr) ? $tabReq : 'ri';
    @endphp

    <x-content-card>

        {{-- Tab --}}
        <div class="row">
            <div class="col">
                <ul class="nav tab-minimal">
                    <li class="nav-item py-2">
                        <a href="?pel=ri" class="tab-link text-decoration-none {{ $tab == 'ri' ? 'active' : '' }}">Rawat
                            Inap</a>
                    </li>

                    <li class="nav-item py-2">
                        <a href="?pel=rj" class="tab-link text-decoration-none {{ $tab == 'rj' ? 'active' : '' }}">Rawat
                            Jalan</a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="row">
            <div class="col">
                <div class="row mb-3" id="filter-section">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="unit_filter">{{ $tab == 'rj' ? 'Poli' : 'Ruang' }}</label>
                            <select class="form-select select2" id="unit_filter">
                                <option value="">--Pilih Ruang--</option>
                                @foreach ($unit as $item)
                                    <option value="{{ $item->kd_unit }}">{{ $item->nama_unit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="customer_filter" class="form-label">Jenis Bayar</label>
                            <select id="customer_filter" class="form-select select2">
                                <option value="">--Pilih Jenis Bayar--</option>
                                @foreach ($customer as $item)
                                    <option value="{{ $item->kd_customer }}">{{ $item->customer }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status_filter" class="form-label">Status Klaim</label>
                            <select id="status_filter" class="form-select select2">
                                <option value="">--Pilih Status Klaim--</option>
                                <option value="0">Belum Selesai</option>
                                <option value="1">Selesai</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="periode_filter" class="form-label">Periode</label>
                        <div class="input-group input-daterange">
                            <input type="text" class="form-control" id="startdate_filter" readonly
                                value="{{ date('Y-m-d') }}">
                            <div class="input-group-addon">to</div>
                            <input type="text" class="form-control" id="enddate_filter" readonly
                                value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>Pasien</th>
                                <th>No RM / Tgl Masuk</th>
                                <th>{{ $tab == 'rj' ? 'Poli' : 'Ruang' }}</th>
                                <th>DPJP</th>
                                <th>Alamat</th>
                                <th>Jaminan</th>
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
            $('.input-daterange input').each(function() {
                $(this).datepicker({
                    format: 'yyyy-mm-dd',
                });
            });


            // DATATABLE
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('berkas-digital.dokumen.index') }}?pel={{ $tab }}",
                    data: function(d) {
                        d.unit_filter = $('#unit_filter').val();
                        d.customer_filter = $('#customer_filter').val();
                        d.status_filter = $('#status_filter').val();
                        d.startdate_filter = $('#startdate_filter').val();
                        d.enddate_filter = $('#enddate_filter').val();
                    }
                },
                columns: [{
                        data: 'profile',
                        name: 'profile',
                        render: function(data, type, row) {
                            let imageUrl = row.foto_pasien ?
                                "{{ asset('storage/') }}" + '/' + row.foto_pasien :
                                "{{ asset('assets/images/avatar1.png') }}";
                            let gender = row.pasien.jenis_kelamin == '1' ? 'Laki-Laki' :
                                'Perempuan';
                            return `
                                <div class="profile">
                                    <img src="${imageUrl}" alt="Profile" width="50" height="50" class="rounded-circle"/>
                                    <div class="info">
                                        <strong>${row.pasien.nama}</strong>
                                        <span>${gender} / ${row.umur} Tahun</span>
                                    </div>
                                </div>
                            `;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kd_pasien',
                        name: 'kd_pasien',
                        render: function(data, type, row) {
                            return `
                                <div class="rm-reg">
                                    RM: ${row.kd_pasien ? row.kd_pasien : 'N/A'}<br>
                                    Tgl: ${row.tgl_masuk ? row.tgl_masuk : 'N/A'}
                                </div>
                            `;
                        },
                        defaultContent: ''
                    },
                    {
                        data: 'ruang',
                        name: '',
                        defaultContent: ''
                    },
                    {
                        data: 'dokter.nama_lengkap',
                        name: '',
                        defaultContent: ''
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                        defaultContent: ''
                    },
                    {
                        data: 'jaminan',
                        name: 'jaminan',
                        defaultContent: ''
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
            });
        });

        $('#filter-section select, input').on('change', function() {
            $('#dataTable').DataTable().ajax.reload();
        });

        $('#dataTable').on('click', '.btnUnggahBerkas', function() {
            let $this = $(this);
            let ref = $this.attr('data-ref');
            console.log(ref);
        });
    </script>
@endpush
