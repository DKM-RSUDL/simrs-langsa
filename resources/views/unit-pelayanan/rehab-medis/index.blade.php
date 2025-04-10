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

            .select2-container {
                z-index: 9999;
            }

            .modal-dialog {
                z-index: 1050 !important;
            }

            .modal-content {
                overflow: visible !important;
            }

            .select2-dropdown {
                z-index: 99999 !important;
            }

            /* Menghilangkan elemen Select2 yang tidak diinginkan */
            .select2-container+.select2-container {
                display: none;
            }

            /* Menyamakan tampilan Select2 dengan Bootstrap */
            .select2-container--default .select2-selection--single {
                height: calc(1.5em + 0.75rem + 2px);
                padding: 0.375rem 0.75rem;
                font-size: 1rem;
                font-weight: 400;
                line-height: 1.5;
                color: #495057;
                background-color: #fff;
                border: 1px solid #ced4da;
                border-radius: 0.25rem;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 1.5;
                padding-left: 0;
                padding-right: 0;
                color: #495057;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: calc(1.5em + 0.75rem);
                position: absolute;
                top: 1px;
                right: 1px;
                width: 20px;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow b {
                border-color: #6c757d transparent transparent transparent;
            }

            .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
                border-color: transparent transparent #6c757d transparent;
            }

            .select2-container--default .select2-dropdown {
                border-color: #80bdff;
                border-radius: 0.25rem;
            }

            .select2-container--default .select2-results__option--highlighted[aria-selected] {
                background-color: #007bff;
            }

            /* Fokus */
            .select2-container--default.select2-container--focus .select2-selection--single {
                border-color: #80bdff;
                outline: 0;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }

            .emergency__container {
                display: flex;
                align-items: center;
                gap: 20px;
            }

            .custom__card {
                background: linear-gradient(to bottom, #e0f7ff, #a5d8ff);
                border: 2px solid #a100c9;
                border-radius: 15px;
                padding: 8px 15px;
                width: fit-content;
                min-width: 150px;
                display: flex;
                align-items: center;
                gap: 20px;
            }

            .user__icon {
                width: 40px;
                height: 40px;
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

    <div class="row">
        <div class="col-md-12">
            <div class="emergency__container">
                <h4 class="fw-bold">Rehabilitasi Medik</h4>
                <div class="custom__card">
                    <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="User Icon" class="user__icon">
                    <div class="text-center">
                        <p class="m-0 p-0">Aktif</p>
                        <p class="m-0 p-0 fs-4 fw-bold">{{ countUnfinishedPatientWithTglKeluar(74) }}</p>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end align-items-end gap-3">
                <div class="d-flex align-items-center">
                    <label for="dokterSelect" class="form-label me-2">Dokter:</label>
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

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="table-responsive text-left">
                <table class="table table-bordered dataTable" id="rawatDaruratTable">
                    <thead>
                        <tr>
                            <th width="100px">Aksi</th>
                            <th>Pasien</th>
                            <th>Triase</th>
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
@endsection

@push('js')
    <script>
        var gawatDaruratIndexUrl = "{{ route('rehab-medis.index') }}";
        var medisGawatDaruratIndexUrl = "{{ url('unit-pelayanan/rehab-medis/pelayanan/') }}/";

        $(document).ready(function() {
            $('#rawatDaruratTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: gawatDaruratIndexUrl,
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
                            return `<div class="d-flex justify-content-center">
                                        <a href="${medisGawatDaruratIndexUrl + row.kd_pasien}/${row.tgl_masuk}/${row.urut_masuk}" class="edit btn btn-outline-primary btn-sm">
                                                <i class="ti-pencil-alt"></i>
                                        </a>

                                        <div class="dropdown ms-1">
                                            <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="dropdown" onclick="$(this).dropdown('toggle')">
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
                                                        <li><a class="dropdown-item m-1" href="#">Rujuk Keluar RS</a></li>
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
                        data: 'triase',
                        name: 'triase',
                        render: function(data, type, row) {
                            let kdTriase = row.kd_triase;
                            let classEl = '';

                            if (kdTriase == 5) classEl = 'bg-dark';
                            if (kdTriase == 4 || kdTriase == 3) classEl = 'bg-danger';
                            if (kdTriase == 2) classEl = 'bg-warning';
                            if (kdTriase == 1) classEl = 'bg-success';

                            return `<div class="rounded-circle ${classEl}" style="width: 35px; height: 35px;"></div>`;
                        },
                        defaultContent: 'null'
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
                        render: function(data, type, row) {
                            return '<a href="#" class="edit btn btn-danger btn-sm"><i class="bi bi-x-circle"></i></a>';
                        }
                    },
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

            initSelect2();

            let rujukanVal = $('#addPatientTriage input[name="rujukan"]').val();
            if (rujukanVal == '1') $('#addPatientTriage #rujukan_ket').prop('required', true);
        });


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

        $('#dokterSelect').on('change', function() {
            $('#rawatDaruratTable').DataTable().ajax.reload();
        });
    </script>
@endpush
