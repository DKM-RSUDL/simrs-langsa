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

            /* Dropdown submenu */
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

    <x-content-card>
        <div class="row">
            <div class="col-md-12">
                {{-- Header + 3 kartu (Bootstrap-only) --}}
                <div class="row g-3 align-items-start">
                    <div class="col-12 col-md-6">
                        <h4 class="fw-bold m-0">{{ $unit->nama_unit }} (Belum Selesai)</h4>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="row">

                            {{-- Belum Selesai (Warning) --}}
                            <a href="{{ route('rawat-jalan.unit.belum-selesai', $unit->kd_unit) }}"
                                class="text-decoration-none col-4">
                                <div class="rounded bg-warning text-white">
                                    <div class="card-body d-flex align-items-center gap-3 px-3">
                                        <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="36"
                                            height="36">
                                        <div class="text-start">
                                            <div class="small mb-1">Belum Selesai</div>
                                            <div class="fs-4 fw-bold">{{ countUnfinishedPatientRajal($unit->kd_unit) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            {{-- Selesai (Success) --}}
                            <a href="{{ route('rawat-jalan.unit.selesai', $unit->kd_unit) }}"
                                class="text-decoration-none col-4">
                                <div class="rounded bg-success text-white">
                                    <div class="card-body d-flex align-items-center gap-3 px-3">
                                        <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="36"
                                            height="36">
                                        <div class="text-start">
                                            <div class="small mb-1">Selesai</div>
                                            <div class="fs-4 fw-bold">{{ countFinishedPatientRajal($unit->kd_unit) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            {{-- Semua Pasien (Primary) --}}
                            <a href="{{ route('rawat-jalan.unit', $unit->kd_unit) }}" class="text-decoration-none col-4">
                                <div class="rounded bg-primary text-white">
                                    <div class="card-body d-flex align-items-center gap-3 px-3">
                                        <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="36"
                                            height="36">
                                        <div class="text-start">
                                            <div class="small mb-1">Semua Pasien</div>
                                            <div class="fs-4 fw-bold">{{ countActivePatientRajal($unit->kd_unit) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- End Header --}}
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="table-responsive text-left">
                    <table class="table table-bordered dataTable" id="patientUnitDatatable">
                        <thead>
                            <tr>
                                <th width="100px">Aksi</th>
                                <th>Pasien</th>
                                <th>No RM / Reg</th>
                                <th>Alamat</th>
                                <th>Jaminan</th>
                                <th>Status Pelayanan</th>
                                <th>Keterangan</th>
                                <th>Tindak Lanjut</th>
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
        let pelayananUrl = "{{ url('unit-pelayanan/rawat-jalan/unit') }}/";

        document.addEventListener('DOMContentLoaded', function() {
            var dropdownSubmenus = document.querySelectorAll('.dropdown-submenu');
            dropdownSubmenus.forEach(function(submenu) {
                submenu.addEventListener('mouseover', function() {
                    submenu.querySelector('.dropdown-menu').classList.add('show');
                });
                submenu.addEventListener('mouseout', function() {
                    submenu.querySelector('.dropdown-menu').classList.remove('show');
                });
            });
        });

        $(document).ready(function() {
            $('#patientUnitDatatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('rawat-jalan.unit.belum-selesai', $unit->kd_unit) }}",
                columns: [
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `<a href="#" class="edit btn btn-primary btn-sm m-2">
                                        <i class="bi bi-volume-up-fill"></i>
                                    </a>
                                    <a href="#" class="edit btn btn-outline-secondary btn-sm m-2">
                                        <i class="bi bi-volume-mute-fill"></i>
                                    </a>
                                    <a href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk}" class="edit btn btn-outline-primary btn-sm m-2">
                                        <i class="ti-pencil-alt"></i>
                                    </a>`;
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
                        data: 'status_pelayanan',
                        name: 'status_pelayanan',
                        defaultContent: ''
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan',
                        defaultContent: ''
                    },
                    {
                        data: 'tindak_lanjut',
                        name: 'tindak_lanjut',
                        defaultContent: ''
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
    </script>
@endpush
