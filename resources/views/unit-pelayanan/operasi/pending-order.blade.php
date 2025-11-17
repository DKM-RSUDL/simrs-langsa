@extends('layouts.administrator.master')

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

        /* Custom CSS for profile */
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

        .emergency__container {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .custom__card {
            border-radius: 15px;
            padding: 8px 15px;
            width: fit-content;
            min-width: 150px;
            display: flex;
            align-items: center;
            gap: 20px
        }

        .all__patients {
            background: linear-gradient(to bottom, #e0f7ff, #a5d8ff);
            border: 2px solid #a100c9;
        }

        .Pending {
            background: linear-gradient(to bottom, #ffffff, #ffe499);
            border: 2px solid #ffbb00;
        }

        .custom__icon {
            margin-bottom: 5px;
        }

        .card__content {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .check__icon {
            color: #00cc00;
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
        }

        .emergency__container a {
            text-decoration: none;
            color: #000;
        }

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu>.dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -6px;
            margin-left: -1px;
        }

        .dropdown-submenu:hover>.dropdown-menu {
            display: block;
        }

        .dropdown-submenu>a.dropdown-toggle {
            position: relative;
            padding-right: 30px;
        }

        .dropdown-submenu>a.dropdown-toggle::after {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .dropdown-submenu:hover>a.dropdown-toggle::after {
            transform: translateY(-50%) rotate(-90deg);
        }
    </style>
@endpush

@section('content')
    <x-content-card>
        <div class="row">
            <div class="col-md-12">
                <div class="row g-3 align-items-start">
                    <div class="col-12 col-md-7">
                        <h4 class="fw-bold">Bedah Sentral</h4>
                    </div>

                    <div class="col-12 col-md-5">
                        <div class="row g-2">
                            {{-- Aktif (Primary) --}}
                            <a href="{{ route('operasi.index') }}" class="text-decoration-none col-12 col-md-6">
                                <div class="rounded bg-primary text-white">
                                    <div class="card-body d-flex align-items-center gap-3 px-3">
                                        <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="36"
                                            height="36">
                                        <div class="text-start">
                                            <div class="small mb-1">Aktif</div>
                                            <div class="fs-4 fw-bold">3</div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            {{-- Pending Order Masuk (Warning) --}}
                            <a href="{{ route('operasi.pending-order') }}" class="text-decoration-none col-12 col-md-6">
                                <div class="rounded bg-warning text-white">
                                    <div class="card-body d-flex align-items-center gap-3 px-3">
                                        <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="36"
                                            height="36">
                                        <div class="text-start">
                                            <div class="small mb-1">Pending Order Masuk</div>
                                            <div class="fs-4 fw-bold">33</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="table-responsive text-left">
                    <table class="table table-bordered dataTable" id="operasiTable">
                        <thead>
                            <tr>
                                <th width="100px">Aksi</th>
                                <th>Pasien</th>
                                <th>No RM</th>
                                <th>Alamat</th>
                                <th>Jaminan</th>
                                <th>Waktu Order</th>
                                <th>Ruang/Unit Asal</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Tabel diisi oleh DataTables --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-content-card>
@endsection

@push('js')
    <script>
        var hdIndexUrl = "{{ route('operasi.pending-order') }}";
        var hdPelayananUrl = "{{ url('unit-pelayanan/operasi/pelayanan/') }}/";

        $(document).ready(function() {
            $('#operasiTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: hdIndexUrl,
                },
                columns: [{
                        data: 'id',
                        name: 'no_transaksi_asal',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                        <div class="d-flex justify-content-center">
                            <div class="dropdown"></div>
                                <button class="btn btn-outline-secondary btn-sm" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('operasi.terima-order', [':kd_kasir', ':no_transaksi', ':tgl_op', ':jam_op']) }}">Terima Order</a></li>
                                </ul>
                            </div>
                        </div>`.replace(':kd_kasir', row.kd_kasir)
                                .replace(':no_transaksi', row.no_transaksi)
                                .replace(':tgl_op', row.tgl_op)
                                .replace(':jam_op', row.jam_op);
                        }
                    },
                    {
                        data: 'nama_pasien',
                        name: 'no_transaksi_asal',
                        render: function(data, type, row) {
                            let imageUrl = row.foto_pasien ? "{{ asset('storage/') }}" + '/' + row
                                .foto_pasien : "{{ asset('assets/images/avatar1.png') }}";
                            let gender = row.jenis_kelamin == '1' ? 'Laki-Laki' :
                                'Perempuan';
                            return `
                                <div class="profile">
                                    <img src="${imageUrl}" alt="Profile" width="50" height="50" class="rounded-circle"/>
                                    <div class="info">
                                        <strong>${row.nama_pasien}</strong>
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
                        name: 'no_transaksi_asal',
                        render: function(data, type, row) {
                            // Assuming row.kd_pasien is the "RM" and row.reg_number is the "Reg" value
                            return `
                            <div class="rm-reg">
                                RM: ${row.kd_pasien ? row.kd_pasien : 'N/A'}<br>
                            </div>
                        `;
                        },
                    },
                    {
                        data: 'alamat',
                        name: 'no_transaksi_asal',
                    },
                    {
                        data: 'jaminan',
                        name: 'no_transaksi_asal',
                    },
                    {
                        data: 'waktu_order',
                        name: 'no_transaksi_asal',
                    },
                    {
                        data: 'unit_order',
                        name: 'kd_unit_order',
                    },
                ],
                // deferRender: true,
                // pageLength: 25,
                // lengthMenu: [
                //     [10, 25, 50, 100],
                //     [10, 25, 50, 100]
                // ],
                // paging: true,
                // lengthChange: true,
                // searching: true,
                // orderCellsTop: true,
                // ordering: true,
                // info: true,
                // autoWidth: false,
                // responsive: true,
            });

            $('.dropdown-submenu').hover(
                function() {
                    $(this).find('.dropdown-menu').addClass('show');
                },
                function() {
                    $(this).find('.dropdown-menu').removeClass('show');
                }
            );
        });
    </script>
@endpush
