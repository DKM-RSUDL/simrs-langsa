@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold">{{ $title ?? '' }}</h4>
                @can('create navigation')
                    <button type="button" name="Add" class="btn btn-primary btn-sm" id="createMenu">
                        <i class="ti-plus"></i>
                        Tambah Data
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive text-left">
                <table class="table table-bordered dataTable nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Url</th>
                            <th>Icon</th>
                            <th>Type menu</th>
                            <th>Position</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th width="100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-modal id="modalAction" title="Modal title" size="lg"></x-modal>

    {{-- <div class="modal fade" id="createNavigationModal" tabindex="-1" aria-labelledby="createNavigationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createNavigationModalLabel">Tambah Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form" action="{{ route('navigation.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type_menu" class="form-label">Type Menu</label>
                                    <select class="form-select select2" id="type_menu" name="type_menu" required>
                                        <option value="single">
                                            Single Menu
                                        </option>
                                        <option value="child">
                                            Child Menu
                                        </option>
                                        <option value="parent">
                                            Parent Menu
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 d-none" id="main_menu">
                                <div class="mb-3">
                                    <label for="main_menu" class="form-label">Parent Menu</label>
                                    <select class="form-select select2" name="main_menu" id="main_menu"
                                        aria-label="Default select example">
                                        <option value="">Open this select menu</option>
                                        @foreach ($parent as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Menu</label>
                                    <input type="text" placeholder="Input Here" name="name" class="form-control" id="name" required>
                                    <small class="text-danger" id="name-error"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="url" class="form-label">URL</label>
                                    <input type="text" placeholder="Input Here" name="url" class="form-control" id="url" value="#" required>
                                    <small class="text-danger" id="url-error"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="icon" class="form-label">Icon</label>
                                    <input type="text" placeholder="Input Here" name="icon" class="form-control" id="icon">
                                    <small class="text-muted">Font awesome 6.5.2</small>
                                    <small class="text-danger" id="icon-error"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort" class="form-label">Position</label>
                                    <input type="text" placeholder="Input Here" name="sort" class="form-control" id="sort" value="0">
                                    <small class="text-danger" id="sort-error"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select select2" name="role[]" id="role"
                                        aria-label="Default select example" multiple>
                                        @foreach ($role as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="role-error"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" id="save-modal" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
@endsection

@push('js')
    <script type="text/javascript">
        $(function() {
            // ajax table
            var table = $('.dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('navigation.index') }}",
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
                        data: 'url',
                        name: 'url'
                    },
                    {
                        data: 'icon',
                        name: 'icon'
                    },
                    {
                        data: 'main_menu',
                        name: 'main_menu'
                    },
                    {
                        data: 'sort',
                        name: 'sort'
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

            // Loading spinner HTML
            const loadingSpinner = `
                <div class="text-center my-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Sedang memuat data...</p>
                </div>
            `;

            // create
            $('#createMenu').click(function() {
                const button = $(this);
                // Disable button and show loading
                button.prop('disabled', true)
                    .html('<i class="spinner-border spinner-border-sm"></i> Loading...');

                // Show modal with loading spinner
                $('#modalAction').modal('show');
                $('#modalAction .modal-title').html('Tambah Menu');
                $('#modalAction .modal-body').html(loadingSpinner);

                $.get("{{ route('navigation.create') }}", function(response) {
                        $('#modalAction .modal-body').html(response);
                    })
                    .fail(function(xhr) {
                        $('#modalAction .modal-body').html(`
                            <div class="alert alert-danger">
                                Terjadi kesalahan saat memuat form. Silakan coba lagi.
                            </div>
                        `);
                    })
                    .always(function() {
                        // Restore button state
                        button.prop('disabled', false)
                            .html('<i class="ti-plus"></i> Tambah Data');
                    });
            });

            // edit
            $('body').on('click', '.editRole', function() {
                const button = $(this);
                const roleId = $(this).data('id');

                // Disable button and show loading
                button.prop('disabled', true)
                    .html('<i class="spinner-border spinner-border-sm"></i>');

                // Show modal with loading spinner
                $('#modalAction').modal('show');
                $('#modalAction .modal-title').html('Edit Menu');
                $('#modalAction .modal-body').html(loadingSpinner);

                $.get("{{ route('navigation.index') }}" + '/' + roleId + '/edit', function(response) {
                        $('#modalAction .modal-body').html(response);
                    })
                    .fail(function(xhr) {
                        $('#modalAction .modal-body').html(`
                <div class="alert alert-danger">
                    Terjadi kesalahan saat memuat data. Silakan coba lagi.
                </div>
            `);
                    })
                    .always(function() {
                        // Restore button state
                        button.prop('disabled', false)
                            .html('<i class="ti-pencil"></i>');
                    });
            });

            // delete
            $('body').on('click', '.deleteRole', function() {
                const button = $(this);
                const roleId = $(this).data('id');

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
                        // Disable button and show loading
                        button.prop('disabled', true)
                            .html('<i class="spinner-border spinner-border-sm"></i>');

                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('navigation') }}/" + roleId,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                table.draw();
                                showToast('success', response.message);
                            },
                            error: function(response) {
                                var errorMessage = response.responseJSON.message;
                                showToast('error', errorMessage);
                            },
                            complete: function() {
                                // Restore button state
                                button.prop('disabled', false)
                                    .html('<i class="ti-trash"></i>');
                            }
                        });
                    }
                });
            });

            // save
            $('#save-modal').click(function(e) {
                e.preventDefault();
                const button = $(this);
                const id = $('#navigationId').val();


                // Show loading state
                button.html('<i class="spinner-border spinner-border-sm"></i> Menyimpan...')
                    .addClass('disabled');

                $.ajax({
                    data: $('#form-modalAction').serialize(),
                    url: `{{ url('navigation/') }}/${id}`,
                    type: "POST",
                    dataType: 'json',
                    success: function(response) {
                        $('#modalAction').modal('hide');
                        table.draw();
                        showToast(response.status, response.message);
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
                    },
                    complete: function() {
                        // Restore button state
                        button.html('Save').removeClass('disabled');
                    }
                });
            });

            // Handle type menu change
            $(document).on('change', '#type_menu', function() {
                let value = $(this).val()

                if (value == 'child') {
                    $('#main_menu').removeClass('d-none')
                    $('#icon').prop('readonly', true);
                    $('#url').prop('readonly', false)
                    $('#url').val('');
                    $('#icon').val('');
                } else if (value == 'parent') {
                    $('#icon').prop('readonly', false)
                    $('#url').prop('readonly', true)
                    $('#url').val('#');
                    $('#main_menu').addClass('d-none')
                } else {
                    $('#icon').prop('readonly', false)
                    $('#url').prop('readonly', false)
                    $('#url').val('');
                    $('#main_menu').addClass('d-none')
                }
            });

            // Handle name input
            $(document).on('input', '#name', function() {
                let value = $(this).val()
                let type_menu = $('#type_menu').val()

                if (type_menu == 'parent') {
                    $('#url').val('#');
                }
            });
        });
    </script>
@endpush
