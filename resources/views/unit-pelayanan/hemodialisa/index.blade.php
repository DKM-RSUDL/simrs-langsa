@extends('layouts.administrator.master')

@push('css')
    <style>
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

        /* (Opsional) Dropdown submenu */
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
                {{-- Header + kartu ringkas (Bootstrap-only) --}}
                <div class="row g-3 align-items-center">
                    <div class="col-12 col-lg-7">
                        <h4 class="fw-bold m-0">Hemodialisa (Aktif)</h4>
                    </div>

                    <div class="col-12 col-lg-5">
                        <div class="row g-3 align-items-center">
                            {{-- Aktif (Primary) --}}
                            <div class="col-md-12">
                                <div class="row g-2">
                                    <a href="{{ route('hemodialisa.index') }}" class="text-decoration-none col-12 col-md-6">
                                        <div class="rounded bg-primary text-white">
                                            <div class="card-body d-flex align-items-center gap-3 px-3">
                                                <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon"
                                                    width="36" height="36">
                                                <div class="text-start">
                                                    <div class="small mb-1">Aktif</div>
                                                    <div class="fs-4 fw-bold">{{ countUnfinishedPatientWithTglKeluar(72) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    {{-- Pending Order Masuk (Warning) --}}
                                    <a href="{{ route('hemodialisa.pending-order') }}" class="text-decoration-none col-12 col-md-6">
                                        <div class="rounded bg-warning text-white">
                                            <div class="card-body d-flex align-items-center gap-3 px-3">
                                                <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon"
                                                    width="36" height="36">
                                                <div class="text-start">
                                                    <div class="small mb-1">Pending Order Masuk</div>
                                                    <div class="fs-4 fw-bold">{{ countPendingOrderHD() }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            {{-- Filter Dokter --}}
                            <div class="col-12 d-flex align-items-center justify-content-md-end">
                                <label for="dokterSelect" class="form-label me-2 mb-0">Dokter:</label>
                                <select class="form-select" id="dokterSelect" aria-label="Pilih dokter">
                                    <option value="" selected>Semua</option>
                                    @foreach ($dokter as $d)
                                        <option value="{{ $d->dokter->kd_dokter }}">{{ $d->dokter->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Header --}}
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="table-responsive text-left">
                    <table class="table table-bordered dataTable" id="hemodialisaTable">
                        <thead>
                            <tr>
                                <th width="100px">Aksi</th>
                                <th>Pasien</th>
                                <th>Bed</th>
                                <th>No RM / Reg</th>
                                <th>Alamat</th>
                                <th>Jaminan</th>
                                <th>Tgl Masuk</th>
                                <th>Dokter</th>
                                <th>Instruksi</th>
                                <th>Del</th>
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
        var hdIndexUrl = "{{ route('hemodialisa.index') }}";
        var hdPelayananUrl = "{{ url('unit-pelayanan/hemodialisa/pelayanan/') }}/";

        $(document).ready(function() {
            $('#hemodialisaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: hdIndexUrl,
                    data: function(d) {
                        d.dokter = $('#dokterSelect').val();
                    }
                },
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="d-flex justify-content-center">
                                    <a href="${hdPelayananUrl + row.kd_pasien}/${row.tgl_masuk}/${row.urut_masuk}"
                                       class="btn btn-primary" title="Layani Pasien">
                                        <i class="ti-pencil-alt"></i>
                                    </a>
                                </div>`;
                        }
                    },
                    {
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
                        data: 'bed',
                        name: 'bed',
                        defaultContent: ''
                    },
                    {
                        data: 'kd_pasien',
                        name: 'kd_pasien',
                        render: function(data, type, row) {
                            return `
                                <div class="rm-reg">
                                    RM: ${row.kd_pasien ? row.kd_pasien : 'N/A'}<br>
                                    Reg: ${row.reg_number ? row.reg_number : 'N/A'}
                                </div>
                            `;
                        },
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
                        data: 'waktu_masuk',
                        name: 'tgl_masuk',
                        defaultContent: 'null'
                    },
                    {
                        data: 'kd_dokter',
                        name: 'kd_dokter',
                        defaultContent: 'null'
                    },
                    {
                        data: 'instruksi',
                        name: 'instruksi',
                        defaultContent: ''
                    },
                    {
                        data: 'del',
                        name: 'del',
                        orderable: false,
                        searchable: false,
                        render: function() {
                            return '<a href="#" class="edit btn btn-danger btn-sm" title="Hapus"><i class="bi bi-x-circle"></i></a>';
                        }
                    },
                ],
                deferRender: true,
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                paging: true,
                lengthChange: true,
                searching: true,
                orderCellsTop: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
            });

            // reload saat filter dokter berubah
            $('#dokterSelect').on('change', function() {
                $('#hemodialisaTable').DataTable().ajax.reload();
            });
        });
    </script>
@endpush
