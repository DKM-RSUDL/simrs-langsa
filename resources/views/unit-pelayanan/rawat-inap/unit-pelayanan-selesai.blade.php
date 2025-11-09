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
    </style>
@endpush

@section('content')
    <x-content-card>
        <div class="row">
            <div class="col-md-12">
                {{-- Header + kartu ringkas (Bootstrap-only) --}}
                <div class="row g-3 align-items-start">
                    <div class="col-12 col-md-6">
                        <h4 class="fw-bold m-0">{{ $unit->nama_unit }} (Selesai)</h4>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="row g-2">
                            {{-- Aktif (Primary) --}}
                            <a href="{{ route('rawat-inap.unit.aktif', $unit->kd_unit) }}"
                                class="text-decoration-none col-12 col-md-4">
                                <div class="rounded bg-primary text-white">
                                    <div class="card-body d-flex align-items-center gap-3 px-3">
                                        <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="36"
                                            height="36">
                                        <div class="text-start">
                                            <div class="small mb-1">Aktif</div>
                                            <div class="fs-4 fw-bold">{{ countAktivePatientRanap($unit->kd_unit) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            {{-- Pending Order Masuk (Warning) --}}
                            <a href="{{ route('rawat-inap.unit.pending', $unit->kd_unit) }}"
                                class="text-decoration-none col-12 col-md-4">
                                <div class="rounded bg-warning text-white">
                                    <div class="card-body d-flex align-items-center gap-3 px-3">
                                        <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="36"
                                            height="36">
                                        <div class="text-start">
                                            <div class="small mb-1">Pending Masuk</div>
                                            <div class="fs-4 fw-bold">{{ countPendingPatientRanap($unit->kd_unit) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            {{-- Selesai --}}
                            <a href="{{ route('rawat-inap.unit.selesai', $unit->kd_unit) }}"
                                class="text-decoration-none col-12 col-md-4">
                                <div class="rounded bg-success text-white">
                                    <div class="card-body d-flex align-items-center gap-3 px-3">
                                        <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="36"
                                            height="36">
                                        <div class="text-start">
                                            <div class="small mb-1">Selesai</div>
                                            <div class="fs-4 fw-bold">{{ countAktivePatientRanap($unit->kd_unit) }}</div>
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
                                {{-- <th>Keterangan</th>
                                <th>Tindak Lanjut</th> --}}
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
        let pelayananUrl = "{{ url('unit-pelayanan/rawat-inap/unit') }}/";

        $(document).ready(function() {
            $('#patientUnitDatatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('rawat-inap.unit.selesai', $unit->kd_unit) }}",
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="d-flex justify-content-center">
                                    <a href="${pelayananUrl + row.kd_unit + '/pelayanan/' + row.kd_pasien + '/' + row.tgl_masuk + '/' + row.urut_masuk}" class="edit btn btn-primary">
                                        <i class="ti-pencil-alt"></i>
                                    </a>
                                </div>
                            `;
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
                        render: function(data, type, row) {
                            let bgBadge = 'secondary';
                            if (row.status_inap == 1) bgBadge = 'success';
                            return `<span class="badge text-bg-${bgBadge}">${row.keterangan_kunjungan ?? '-'}</span>`;
                        },
                        defaultContent: ''
                    },
                    // { data: 'keterangan', name: 'keterangan', defaultContent: '' },
                    // { data: 'tindak_lanjut', name: 'tindak_lanjut', defaultContent: '' },
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
