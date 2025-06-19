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
    <div class="row">
        <div class="col-md-12">
            <div class="emergency__container">
                <h4 class="fw-bold">{{ $unit->nama_unit }}</h4>

                <a href="{{ route('rawat-inap.unit.aktif', $unit->kd_unit) }}">
                    <div class="custom__card all__patients">
                        <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="40">
                        <div class="text-center">
                            <p class="m-0 p-0">Aktif</p>
                            <p class="m-0 p-0 fs-4 fw-bold">{{ countAktivePatientRanap($unit->kd_unit) }}</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('rawat-inap.unit.pending', $unit->kd_unit) }}">
                    <div class="custom__card Pending">
                        <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="40">
                        <div class="text-center">
                            <p class="m-0 p-0">Pending Order Masuk</p>
                            <p class="m-0 p-0 fs-4 fw-bold">{{ countPendingPatientRanap($unit->kd_unit) }}</p>
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
        let pelayananUrl = "{{ url('unit-pelayanan/rawat-inap/unit') }}/";

        $(document).ready(function() {
            $('#patientUnitDatatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('rawat-inap.unit', $unit->kd_unit) }}",
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `<div class="d-flex justify-content-center">
                                        <a href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk}" class="edit btn btn-outline-primary btn-sm">
                                            <i class="ti-pencil-alt"></i>
                                        </a>

                                        <div class="dropdown ms-1">
                                                <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots"></i>
                                                </button>

                                                <ul class="dropdown-menu shadow-lg">
                                                    <li><a class="dropdown-item m-1" href="#">Update Informasi Pasien</a></li>
                                                    <li><a class="dropdown-item m-1" href="#">Identitas Pasien</a></li>
                                                    <li class="dropdown-submenu">
                                                        <a class="dropdown-item m-1 dropdown-toggle" href="#">Persetujuan</a>
                                                        <ul class="dropdown-menu shadow-lg">
                                                            <li><a class="dropdown-item m-1" href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/informed-consent'}">Informed Concent</a></li>
                                                            <li><a class="dropdown-item m-1" href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/anestesi-sedasi'}">Anestesi dan Sedasi</a></li>
                                                        </ul>
                                                    </li>
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
                                                        <a class="dropdown-item m-1 dropdown-toggle" href="#">Surat-Surat</a>
                                                        <ul class="dropdown-menu shadow-lg">
                                                            <li><a class="dropdown-item m-1" href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/surat-kematian'}">Surat Kematian</a></li>
                                                            <li><a class="dropdown-item m-1" href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/pernyataan-dpjp'}">Pernyataan DPJP</a></li>
                                                            <li><a class="dropdown-item m-1" href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/paps'}">PAPS</a></li>
                                                            <li><a class="dropdown-item m-1" href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/meninggalkan-perawatan'}">Meninggalkan Perawatan</a></li>
                                                            <li><a class="dropdown-item m-1" href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/rohani'}">Pelayanan Rohani</a></li>
                                                            <li><a class="dropdown-item m-1" href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/privasi'}">Permintaan Privasi</a></li>
                                                            <li><a class="dropdown-item m-1" href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/penundaan'}">Penundaan Pelayanan</a></li>
                                                            <li><a class="dropdown-item m-1" href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/dnr'}">Penolakan Resusitasi</a></li>
                                                            <li><a class="dropdown-item m-1" href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/permintaan-second-opinion'}">Permintaan Second Opinion</a></li>
                                                            <li><a class="dropdown-item m-1" href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/pengawasan-transportasi'}">Pengawasan Transportasi</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a class="dropdown-item m-1" href="#">Billing System</a></li>
                                                    <li><a class="dropdown-item m-1" href="#">Finalisasi</a></li>
                                                    <li><a class="dropdown-item m-1" href="#">Status Pasien</a></li>
                                                    <li class="dropdown-submenu">
                                                        <a class="dropdown-item m-1 dropdown-toggle" href="#">Transfusi Darah</a>
                                                        <ul class="dropdown-menu shadow-lg">
                                                            <li><a class="dropdown-item m-1" href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/permintaan-darah'}">Order</a></li>
                                                            <li><a class="dropdown-item m-1" href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/pengawasan-darah'}">Pengawasan</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a class="dropdown-item m-1" href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/asuhan-keperawatan'}">Asuhan Keperawatan</a></li>
                                                    <li><a class="dropdown-item m-1" href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk + '/orientasi-pasien-baru'}">Orientasi Pasien Baru</a></li>
                                                </ul>
                                            </div>
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
