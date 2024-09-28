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
        </style>
    @endpush

    <div class="row">
        <div class="col-md-12">
            <h4 class="fw-bold">Gawat Darurat</h4>
            <div class="d-flex justify-content-end align-items-end gap-3">
                <div class="d-flex align-items-center">
                    <label for="dokterSelect" class="form-label me-2">Dokter:</label>
                    <select class="form-select" id="dokterSelect" aria-label="Pilih dokter">
                        <option value="semua" selected>Semua</option>
                        <option value="dokter1">dr. A</option>
                        <option value="dokter2">dr. B</option>
                        <option value="dokter3">dr. C</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary btn-sm" id="createRawatDarurat">
                    <i class="ti-plus"></i> Tambah Data
                </button>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="table-responsive text-left">
                <table class="table table-bordered dataTable">
                    <thead>
                        <tr>
                            <th width="100px">Action</th>
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
                        @foreach ($DataKunjungan as $item)
                            <tr>
                                <td>
                                    <a href="" class="btn btn-sm btn-secondary"><i class="ti-pencil-alt"></i></a>
                                    <a href="" class="btn btn-sm btn-secondary">...</a>
                                </td>

                                <td class="d-flex align-items-center">
                                    <img class="rounded-circle" src="{{ asset('assets/images/avatar1.png') }}" alt="person" width="50" height="50">
                                    <div class="ms-3">
                                        <span class="d-block fw-bold" style="font-size: 16px;">M.Anas</span>
                                        <span class="text-muted" style="font-size: 14px;">Laki-Laki/ 43 Tahun</span>
                                    </div>
                                </td>
                                <td><span class="badge badge-triage-green"> </span></td>
                                <td>12</td>
                                <td>RM: {{ $item->kd_pasien }} <br> Reg : 00000001</td>
                                <td>{{ $item->alamat }}</td>
                                <td>BPJS Kesehatan</td>
                                <td>{{ \Carbon\Carbon::parse($item->tgl_masuk)->translatedFormat('d F Y') }}</td>
                                <td>{{ $item->kd_dokter }}</td>
                                <td>Instruksi</td>
                                <td>
                                    <form action="" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
<<<<<<< HEAD
<<<<<<< HEAD
        var gawatDaruratIndexUrl = "{{ route('gawat-darurat.index') }}";        
        var medisGawatDaruratIndexUrl = "{{ url('unit-pelayanan/gawat-darurat/pelayanan/') }}/";

        $(document).ready(function() {
            $('#rawatDaruratTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: gawatDaruratIndexUrl,
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<a href="' + medisGawatDaruratIndexUrl + row.kd_pasien + '" class="edit btn btn-primary btn-sm m-2"><i class="ti-pencil-alt"></i></a>' +
                                '<a href="#" class="btn btn-secondary btn-sm">...</a>';
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
                        data: 'tgl_masuk',
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
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
=======
        $(document).ready(function() {
            $('#rawatDaruratTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
        $(function() {
            // ajax table
            var table = $('.dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('roles.index') }}",
                columnDefs: [{
                    "targets": "_all",
                    "className": "text-start"
                }],
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: true,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // create
            $('#createRole').click(function() {
                $.get("{{ route('roles.create') }}", function(response) {
                    $('#modalAction .modal-title').html('Tambah Role');
                    $('#modalAction .modal-body').html(response);

                    $('#modalAction').modal('show');
                })
            })

            // edit
            $('body').on('click', '.editRole', function() {
                var roleId = $(this).data('id');
                $.get("{{ route('roles.index') }}" + '/' + roleId + '/edit', function(response) {
                    $('#modalAction .modal-title').html('Edit Role');
                    $('#modalAction .modal-body').html(response);

                    $('#modalAction').modal('show');
                })
            });

            // delete
            $('body').on('click', '.deleteRole', function() {
                var roleId = $(this).data('id');
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang di hapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#82868',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('roles') }}/" + roleId,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                table.draw();
                                showToast('success', response.message);
                            },
                            error: function(response) {
                                var errorMessage = response.responseJSON
                                    .message;
                                showToast('error',
                                    errorMessage);
                            }
                        });
                    }
                });
            });

            // save
            $('#save-modal').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');
                $(this).addClass('disabled');
                var id = $('#roleId').val();

                $.ajax({
                    data: $('#form-modalAction').serialize(),
                    url: `{{ url('roles/') }}/${id}`,
                    type: "POST",
                    dataType: 'json',
                    success: function(response) {
                        $('#modalAction').modal('hide');
                        table.draw();
                        showToast('success', response.message);
                        $('#save-modal').html('Save');
                        $('#save-modal').removeClass('disabled');
                    },
                    error: function(response) {
                        var errors = response.responseJSON.errors;
                        if (errors) {
                            Object.keys(errors).forEach(function(key) {
                                var errorMessage = errors[key][0];
                                $('#' + key).siblings('.text-danger').text(
                                    errorMessage);
                            });
                        }
                        $('#save-modal').html('Save');
                        $('#save-modal').removeClass('disabled');
                    }
                });
            });
        });
    </script>
@endpush

