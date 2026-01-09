@extends('layouts.administrator.master')

@push('css')
    <style>
        .tab-minimal {
            border-bottom: 1px solid #e5e7eb;
        }

        .tab-minimal .tab-link {
            background: none;
            border: 1px solid transparent;
            padding: 6px 12px;
            font-size: 14px;
            color: #9ca3af;
            font-weight: 500;
            position: relative;
            cursor: pointer;

            /* rounded di atas saja */
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .tab-minimal .tab-link.active {
            color: #111827;
            font-weight: 600;
            background-color: #ffffff;
            border-color: #e5e7eb;
            border-bottom-color: transparent;
            /* nyatu ke konten */
        }

        .tab-minimal .tab-link.active::after {
            content: "";
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #3b82f6;
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
    </style>
@endpush

@section('content')
    @php
        $tabReq = request()->get('pel');
        $tabArr = ['ri', 'rj']; // 'ri' for Rawat Inap, 'rj' for Rawat Jalan
        $tab = in_array($tabReq, $tabArr) ? $tabReq : 'ri';
    @endphp

    <x-content-card>

        {{-- Tab --}}
        <div class="row">
            <div class="col">
                <ul class="nav tab-minimal">
                    <li class="nav-item py-2">
                        <a href="?pel=ri" class="tab-link text-decoration-none {{ $tab == 'ri' ? 'active' : '' }}">Rawat
                            Inap</a>
                    </li>

                    <li class="nav-item py-2">
                        <a href="?pel=rj" class="tab-link text-decoration-none {{ $tab == 'rj' ? 'active' : '' }}">Rawat
                            Jalan</a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="row">
            <div class="col">
                <div class="row mb-3" id="filter-section">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="unit_filter">{{ $tab == 'rj' ? 'Poli' : 'Ruang' }}</label>
                            <select class="form-select select2" id="unit_filter">
                                <option value="">--Pilih Ruang--</option>
                                @foreach ($unit as $item)
                                    <option value="{{ $item->kd_unit }}" @selected($item->kd_unit == request()->get('unit'))>{{ $item->nama_unit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="customer_filter" class="form-label">Jenis Bayar</label>
                            <select id="customer_filter" class="form-select select2">
                                <option value="">--Pilih Jenis Bayar--</option>
                                @foreach ($customer as $item)
                                    <option value="{{ $item->kd_customer }}" @selected($item->kd_customer == request()->get('cust'))>
                                        {{ $item->customer }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status_filter" class="form-label">Status Klaim</label>
                            <select id="status_filter" class="form-select select2">
                                <option value="">--Pilih Status Klaim--</option>
                                <option value="0" @selected(request()->get('stat') == '0')>Belum Selesai</option>
                                <option value="1" @selected(request()->get('stat') == '1')>Selesai</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="periode_filter" class="form-label">Periode</label>
                        <div class="input-group input-daterange">
                            <input type="text" class="form-control" id="startdate_filter" readonly
                                value="{{ request()->get('startdate') ?? date('Y-m-d') }}">
                            <div class="input-group-addon">to</div>
                            <input type="text" class="form-control" id="enddate_filter" readonly
                                value="{{ request()->get('enddate') ?? date('Y-m-d') }}">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>Pasien</th>
                                <th>No RM / Tgl Masuk</th>
                                <th>{{ $tab == 'rj' ? 'Poli' : 'Ruang' }}</th>
                                <th>DPJP</th>
                                <th>Alamat</th>
                                <th>Jaminan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-content-card>

    <x-modal id="uploadDokumenModal" size="lg" title="Unggah Berkas Pasien" confirm="true" action="#"
        enctype="multipart/form-data" backdrop="static" idForm="uploadDokumenForm">
        @csrf

        <div class="row mb-3">
            <div class="col">
                <div class="form-control">
                    <table class="table">
                        <tr>
                            <th>Nama Pasien</th>
                            <td id="namaPasienLabel"></td>
                        </tr>
                        <tr>
                            <th>No. RM</th>
                            <td id="rmPasienLabel"></td>
                        </tr>
                        <tr>
                            <th>Poli/Ruang</th>
                            <td id="ruangPasienLabel"></td>
                        </tr>
                        <tr>
                            <th>Tgl Masuk</th>
                            <td id="tglMasukPasienLabel"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">

                <div class="form-group mb-3">
                    <label for="jenis_berkas" class="fw-bold">Jenis Berkas</label>
                    <select name="jenis_berkas" id="jenis_berkas" class="form-select select2" required>
                        <option value="">--Pilih Jenis Berkas--</option>

                        @foreach ($jenisBerkas as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="file_berkas" class="fw-bold">File Berkas (PDF), max = 3MB</label>
                    <input type="file" name="file_berkas" id="file_berkas" class="form-control" accept=".pdf" required>
                </div>

            </div>
        </div>

    </x-modal>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('.input-daterange input').each(function() {
                $(this).datepicker({
                    format: 'yyyy-mm-dd',
                });
            });

            // Initialize Select2 for non-modal selects (use Bootstrap 5 theme)
            $('#uploadDokumenModal .select2').each(function() {
                let $s = $(this);
                if ($s.closest('.modal').length === 0) {
                    if (!$s.data('select2')) {
                        $s.select2({
                            width: '100%',
                            allowClear: true,
                            theme: 'bootstrap-5'
                        });
                    }
                }
            });


            // DATATABLE
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('berkas-digital.dokumen.index') }}?pel={{ $tab }}",
                    data: function(d) {
                        d.unit_filter = $('#unit_filter').val();
                        d.customer_filter = $('#customer_filter').val();
                        d.status_filter = $('#status_filter').val();
                        d.startdate_filter = $('#startdate_filter').val();
                        d.enddate_filter = $('#enddate_filter').val();
                    }
                },
                columns: [{
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
                                    Tgl: ${row.tgl_masuk ? row.tgl_masuk : 'N/A'}
                                </div>
                            `;
                        },
                        defaultContent: ''
                    },
                    {
                        data: 'ruang',
                        name: '',
                        defaultContent: ''
                    },
                    {
                        data: 'dokter.nama_lengkap',
                        name: '',
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            let actionHtml = data;
                            // Jika ada id dokumen berkas digital dan ref_detail, tambahkan tombol detail dengan ref terenkripsi
                            if (row.id_berkas_digital && row.ref_detail) {
                                actionHtml +=
                                    `<a href="/berkas-digital/dokumen/show?ref=${row.ref_detail}" class="btn btn-info btn-sm mt-2">Detail Berkas</a>`;
                            }
                            return actionHtml;
                        }
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

        $('#filter-section select, input').on('change', function() {
            $('#dataTable').DataTable().ajax.reload();
        });

        // When modal is shown, (re)initialize Select2 inside modal with dropdownParent
        $('#uploadDokumenModal').on('shown.bs.modal', function() {
            $(this).find('.select2').each(function() {
                var $s = $(this);
                if ($s.data('select2')) {
                    $s.select2('destroy');
                }
                $s.select2({
                    width: '100%',
                    dropdownParent: $('#uploadDokumenModal'),
                    allowClear: true,
                    theme: 'bootstrap-5'
                });
            });
        });

        // Destroy Select2 instances inside modal to avoid duplicate instances
        $('#uploadDokumenModal').on('hidden.bs.modal', function() {
            $(this).find('.select2').each(function() {
                var $s = $(this);
                if ($s.data('select2')) {
                    $s.select2('destroy');
                }
            });
        });

        $('#dataTable').on('click', '.btnUnggahBerkas', function() {
            let $this = $(this);
            let ref = $this.attr('data-ref');
            let namaPasien = $this.attr('data-nama');
            let rmPasien = $this.attr('data-rm');
            let ruangPasien = $this.attr('data-unit');
            let tglMasukPasien = $this.attr('data-tgl');
            let $modal = $('#uploadDokumenModal');

            let unit_filter = $('#unit_filter').val();
            let customer_filter = $('#customer_filter').val();
            let status_filter = $('#status_filter').val();
            let startdate_filter = $('#startdate_filter').val();
            let enddate_filter = $('#enddate_filter').val();

            $modal.find('#namaPasienLabel').text(namaPasien);
            $modal.find('#rmPasienLabel').text(rmPasien);
            $modal.find('#ruangPasienLabel').text(ruangPasien);
            $modal.find('#tglMasukPasienLabel').text(tglMasukPasien);
            $modal.find('form').attr('action',
                `{{ route('berkas-digital.dokumen.store') }}?ref=${ref}&pel={{ $tab }}&unit=${unit_filter}&cust=${customer_filter}&stat=${status_filter}&startdate=${startdate_filter}&enddate=${enddate_filter}`
            );

            $modal.find('select, input').val('');
            $modal.modal('show');
        });

        $('#uploadDokumenForm').on('submit', function() {
            let $this = $(this);
            $this.find('input[name="_token"]').val("{{ csrf_token() }}");
        });
    </script>
@endpush
