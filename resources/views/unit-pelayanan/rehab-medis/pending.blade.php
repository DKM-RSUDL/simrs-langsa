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
                    <div class="col-12 col-md-7">
                        <h4 class="fw-bold m-0">Rehab Medik (Pending Order)</h4>
                    </div>

                    <div class="col-12 col-md-5">
                        <div class="row g-2">
                            @include('unit-pelayanan.rehab-medis.components.stats-card')
                        </div>
                    </div>
                </div>
                {{-- End Header --}}
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="table-responsive text-left">
                    <table class="table table-bordered dataTable" id="rehabMedikTable">
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
        var hdIndexUrl = "{{ route('rehab-medis.pending') }}";
        var hdPelayananUrl = "{{ url('unit-pelayanan/rehab-medis/pelayanan/') }}/";

        $(document).ready(function() {
            $('#rehabMedikTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: hdIndexUrl
                },
                columns: [{
                        data: 'id',
                        name: 'no_transaksi_asal',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            const terimaUrl =
                                `{{ route('rehab-medis.terima-order', [':id_hash']) }}`.replace(
                                    ':id_hash', row.id_hash);
                            return `
                                <div class="d-flex justify-content-center">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="${terimaUrl}">Terima Order</a></li>
                                        </ul>
                                    </div>
                                </div>`;
                        }
                    },
                    {
                        data: 'nama_pasien',
                        name: 'no_transaksi_asal',
                        render: function(data, type, row) {
                            let imageUrl = row.foto_pasien ?
                                "{{ asset('storage/') }}" + '/' + row.foto_pasien :
                                "{{ asset('assets/images/avatar1.png') }}";
                            let gender = row.jenis_kelamin == '1' ? 'Laki-Laki' : 'Perempuan';
                            return `
                                <div class="profile">
                                    <img src="${imageUrl}" alt="Profile" width="50" height="50" class="rounded-circle"/>
                                    <div class="info">
                                        <strong>${row.nama_pasien}</strong>
                                        <span>${gender} / ${row.umur} Tahun</span>
                                    </div>
                                </div>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kd_pasien',
                        name: 'no_transaksi_asal',
                        render: function(data, type, row) {
                            return `
                                <div class="rm-reg">
                                    RM: ${row.kd_pasien ? row.kd_pasien : 'N/A'}
                                </div>`;
                        }
                    },
                    {
                        data: 'alamat',
                        name: 'no_transaksi_asal'
                    },
                    {
                        data: 'jaminan',
                        name: 'no_transaksi_asal'
                    },
                    {
                        data: 'waktu_order',
                        name: 'no_transaksi_asal'
                    },
                    {
                        data: 'unit_order',
                        name: 'kd_unit_order'
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
