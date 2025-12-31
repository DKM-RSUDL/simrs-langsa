@extends('layouts.administrator.master')

@section('content')
    <x-content-card>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold">Master Berkas Digital</h5>
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fas fa-plus me-1"></i> Buka Form Input
            </button>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <form action="{{ route('berkas-digital.master.index') }}" method="GET">
                    <label class="form-label small">Pencarian Dengan Keyword</label>
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="Masukkan Kata"
                            value="{{ request('keyword') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        @if (request('keyword'))
                            <a href="{{ route('berkas-digital.master.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="10%">Kode</th>
                        <th>Nama Berkas</th>
                        <th>Alias Folder</th>
                        <th width="15%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($berkas as $item)
                        <tr>
                            <td>{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $item->nama_berkas }}</td>
                            <td><code>{{ $item->slug }}</code></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-warning btn-sm" id="BtnEditBerkas"
                                    data-id="{{ $item->id }}">
                                    <i class="fas fa-edit text-white"></i>
                                </button>

                                <form action="{{ route('berkas-digital.master.destroy', $item->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus berkas ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-content-card>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('berkas-digital.master.store') }}" method="POST" onsubmit="disableButton(this)">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Master Berkas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Berkas</label>
                            <input type="text" name="nama_berkas" id="input_nama" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <x-button-submit-confirm label="Simpan" />
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- MODAL EDIT --}}
    <x-modal id="modalEditMaster" title="Edit Master Berkas" size="md" :confirm="true" action="#"
        idForm="FormUpdateBerkas">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Berkas</label>
            <input type="text" name="nama_berkas" id="Edit_Nama_Berkas" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="text-muted small">Alias Folder (Otomatis)</label>
            <input type="text" id="Edit_Slug" class="form-control bg-light" readonly>
        </div>
    </x-modal>
@endsection

@push('js')
    <script>
        $(document).on('click', '#BtnEditBerkas', function() {
            let $this = $(this);
            const id = $this.data('id');

            let urlShow = "{{ route('berkas-digital.master.show', ':id') }}";
            urlShow = urlShow.replace(':id', id);

            let urlUpdate = "{{ route('berkas-digital.master.update', ':id') }}";
            urlUpdate = urlUpdate.replace(':id', id);

            $.ajax({
                url: urlShow,
                type: 'GET',
                beforeSend: function() {
                    $this.data('orig-html', $this.html());
                    $this.html('<i class="fas fa-spinner fa-spin"></i>');
                    $this.prop('disabled', true);
                },
                success: function(res) {
                    if (res.status) {
                        const data = res.data;

                        $('#FormUpdateBerkas').attr('action', urlUpdate);

                        $('#Edit_Nama_Berkas').val(data.nama_berkas);
                        $('#Edit_Slug').val(data.slug);

                        $('#modalEditMaster').modal('show');
                    }
                },
                error: function(err) {
                    toastr.error("Gagal mengambil data berkas.", "Error");
                },
                complete: function() {
                    const orig = $this.data('orig-html');
                    if (orig) $this.html(orig);
                    $this.prop('disabled', false);
                }
            });
        });

        /**
         * Toastr Notification dari Session
         */
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
@endpush
