@extends('layouts.administrator.master')

@section('content')
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

            /* Select2 — samakan dengan Bootstrap & z-index di modal */
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

            .select2-container+.select2-container {
                display: none;
            }

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
                transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
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
                background-color: #0d6efd;
            }

            .select2-container--default.select2-container--focus .select2-selection--single {
                border-color: #80bdff;
                outline: 0;
                box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .25);
            }
        </style>
    @endpush

    <x-content-card>
        <div class="row">
            <div class="col-md-12">
                {{-- Header + kartu ringkas (Bootstrap-only) --}}
                <div class="row g-3 align-items-start">
                    <div class="col-12 col-md-8">
                        <h4 class="fw-bold m-0">Rehabilitasi Medik</h4>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="row gap-2">
                            {{-- Aktif (Primary) --}}
                            <a href="{{ route('rehab-medis.index') }}" class="text-decoration-none col-6 ms-auto">
                                <div class="rounded bg-primary text-white">
                                    <div class="card-body d-flex align-items-center gap-3 px-3">
                                        <img src="{{ asset('assets/img/icons/Sick.png') }}" alt="Icon" width="36"
                                            height="36">
                                        <div class="text-start">
                                            <div class="small mb-1">Aktif</div>
                                            <div class="fs-4 fw-bold">{{ countUnfinishedPatientWithTglKeluar(74) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            {{-- Filter Dokter --}}
                            <div class="col-12 d-flex align-items-center justify-content-md-end mt-3 mt-lg-0">
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
                            {{-- Diisi oleh DataTables --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-content-card>
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
                            return `
                                <div class="d-flex justify-content-center">
                                    <a href="${medisGawatDaruratIndexUrl + row.kd_pasien}/${row.tgl_masuk}/${row.urut_masuk}" class="edit btn btn-primary">
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

            // Select2 init kalau kamu pakai (panggil fungsi init milikmu)
            if (typeof initSelect2 === 'function') initSelect2();

            // filter dokter
            $('#dokterSelect').on('change', function() {
                $('#rawatDaruratTable').DataTable().ajax.reload();
            });
        });
    </script>
@endpush
