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
                gap: 5px;
            }

            .all__patients {
                background: linear-gradient(to bottom, #e0f7ff, #a5d8ff);
                border: 2px solid #a100c9;
            }

            .Pending {
                background: linear-gradient(to bottom, #ffe499, #FFE31A);
                border: 2px solid #ffbb00;
            }

            .Completed {
                background: linear-gradient(to bottom, #e6ffe6, #99ff99);
                border: 2px solid #48fa07;
            }

            .custom__icon {
                margin-bottom: 5px;
            }

            .card__content {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .warning__icon {
                color: #ff9900;
                font-style: normal;
                font-weight: bold;
                background-color: #fff9e6;
                border: 2px solid #ff9900;
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
        </style>
    @endpush

    <div class="row">
        <div class="col-md-12">
            <div class="emergency__container">
                <h4 class="fw-bold">{{ $unit->nama_unit }}</h4>
                <div class="custom__card all__patients">
                    <div class="card__content">
                        <div class="custom__icon">
                            <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="40">
                        </div>
                        <div class="text-center">Semua Pasien</div>
                    </div>
                    <div class="text-center">55</div>
                </div>

                <div class="custom__card Pending">
                    <div class="card__content">
                        <div class="custom__icon">
                            <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="40">
                        </div>
                        <div class="text-center">Belum Selesai</div>
                    </div>
                    <div class="text-center">
                        <i class="warning__icon">!</i>
                        33
                    </div>
                </div>

                <div class="custom__card Completed">
                    <div class="card__content">
                        <div class="custom__icon">
                            <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="40">
                        </div>
                        <div class="text-center">Selesai</div>
                    </div>
                    <div class="text-center">
                        <i class="check-icon">✓</i>
                        22
                    </div>
                </div>
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
@endsection

@push('js')
    <script>
        let pelayananUrl = "{{ url('unit-pelayanan/rawat-jalan/unit') }}/";

        $(document).ready(function() {
            $('#patientUnitDatatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('rawat-jalan.unit', $unit->kd_unit) }}",
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
                                    </a>`;
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
