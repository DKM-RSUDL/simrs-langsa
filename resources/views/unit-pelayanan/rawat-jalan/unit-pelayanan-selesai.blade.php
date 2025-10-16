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
                gap: 20px;
            }

            .all__patients {
                background: linear-gradient(to bottom, #a5d8ff, #e0f7ff);
                border: 2px solid #a100c9;
            }

            .Pending {
                background: linear-gradient(to bottom, #FFE31A, #fbedc3);
                border: 2px solid #ffbb00;
            }

            .Completed {
                background: linear-gradient(to bottom, #99ff99, #e6ffe6);
                border: 2px solid #48fa07;
            }

            .emergency__container a {
                text-decoration: none;
                color: #000
            }

            .custom__icon {
                width: 28px;
            }

            .card__content {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .warning__icon {
                color: #ff0000;
                font-style: normal;
                font-weight: bold;
                background-color: #fff9e6;
                border: 2px solid #ff0000;
                border-radius: 50%;
                width: 20px;
                height: 20px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
            }

            .check__icon {
                color: #00cc00;
                font-style: normal;
                font-weight: bold;
                font-size: 14px;
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
    <x-content-card>
        <div class="row">
            <div class="col-md-12">
                <div class="emergency__container ">
                    <h4 class="fw-bold">{{ $unit->nama_unit }}</h4>
                    <a class="text-black" href="{{ route('rawat-jalan.unit', $unit->kd_unit) }}">
                        <div class="custom__card all__patients">
                            <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="40">
                            <div class="text-center">
                                <p class="m-0 p-0">Semua Pasien</p>
                                <p class="m-0 p-0 fs-4 fw-bold">{{ countActivePatientRajal($unit->kd_unit) }}</p>
                            </div>
                        </div>
                    </a>
                    <a class="text-black" href="{{ route('rawat-jalan.unit.belum-selesai', $unit->kd_unit) }}">
                        <div class="custom__card Pending">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="40">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#d10404"
                                    class="bi bi-exclamation-diamond-fill custom__icon" viewBox="0 0 16 16">
                                    <path
                                        d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098zM8 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                </svg>
                            </div>
                            <div class="text-center">
                                <p class="m-0 p-0">Belum Selesai</p>
                                <p class="m-0 p-0 fs-4 fw-bold">{{ countUnfinishedPatientRajal($unit->kd_unit) }}</p>
                            </div>
                        </div>
                    </a>

                    <a class="text-black" href="{{ route('rawat-jalan.unit.selesai', $unit->kd_unit) }}">
                        <div class="custom__card Completed">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="40">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="green" class="bi bi-check-lg custom__icon"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                                </svg>
                            </div>
                            <div class="text-center">
                                <p class="m-0 p-0">Selesai</p>
                                <p class="m-0 p-0 fs-4 fw-bold">{{ countFinishedPatientRajal($unit->kd_unit) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="table-responsive text-left">
                    <table class="table table-bordered dataTable" id="patientUnitDatatable">
                        <thead>
                            <tr>
                                <th width="100px">No</th>
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
                ajax: "{{ route('rawat-jalan.unit.selesai', $unit->kd_unit) }}",
                columns: [{
                        data: 'antrian',
                        name: 'no',
                        orderable: false,
                        searchable: false,
                        defaultContent: ''
                    },
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
                                    </a>

                                    <div class="dropdown ms-2">
                                            <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>

                                            <ul class="dropdown-menu shadow-lg">
                                                <li><a class="dropdown-item m-1" href="#">Update Informasi Pasien</a></li>
                                                <li><a class="dropdown-item m-1" href="#">Identitas Pasien</a></li>
                                                <li><a class="dropdown-item m-1" href="#">General Concent</a></li>
                                                <li><a class="dropdown-item m-1" href="#">Edukasi dan Informasi</a></li>
                                                <li><a class="dropdown-item m-1" href="#">Jaminan/Asuransi</a></li>
                                                <li><a class="dropdown-item m-1" href="#">Registrasi Rawat Inap</a></li>
                                                <li class="dropdown-submenu">
                                                    <a class="dropdown-item m-1 dropdown-toggle" href="#">Mutasi Pasien</a>
                                                    <ul class="dropdown-menu shadow-lg">
                                                        <li><a class="dropdown-item m-1" href="#">Pindah Ruangan / Rawat Inap</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Pulangkan (Berobat Jalan)</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Pulangkan (APS)</a></li>
                                                        <li><a class="dropdown-item m-1" href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/rujuk-antar-rs' }">Rujuk Keluar RS</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Meninggal Dunia</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Batal Berobat</a></li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown-submenu">
                                                    <a class="dropdown-item m-1 dropdown-toggle" href="#">Order Pelayanan</a>
                                                    <ul class="dropdown-menu shadow-lg">
                                                        <li><a class="dropdown-item m-1" href="#">Operasi</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Rehabilitasi Medis</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Hemodialisa</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Forensik</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Cath Lab</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Rujukan/Ambulance</a></li>
                                                        <li><a class="dropdown-item m-1" href="#">Tindakan Klinik</a></li>
                                                    </ul>
                                                </li>
                                                <li><a class="dropdown-item m-1" href="#">Billing System</a></li>
                                                <li><a class="dropdown-item m-1" href="#">Finalisasi</a></li>
                                                <li><a class="dropdown-item m-1" href="#">Status Pasien</a></li>
                                            </ul>
                                        </div>
                                    `;
                        }
                    },
                    {
                        data: 'profile',
                        name: 'profile',
                        render: function(data, type, row) {
                            let imageUrl = row.foto_pasien ? "{{ asset('storage/') }}" + '/' + row
                                .foto_pasien : "{{ asset('assets/images/avatar1.png') }}";
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
                            // Assuming row.kd_pasien is the "RM" and row.reg_number is the "Reg" value
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
