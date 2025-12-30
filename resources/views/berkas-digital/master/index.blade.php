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
                        <th width="10%">Kode Berkas</th>
                        <th>Nama Berkas</th>
                        <th>Alias Folder Di Sistem</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($berkas as $item)
                        <tr>
                            <td>{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $item->nama_berkas }}</td>
                            <td><code>{{ $item->slug }}</code></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit{{ $item->id }}">
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

                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('berkas-digital.master.update', $item->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Master Berkas</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Nama Berkas</label>
                                                <input type="text" name="nama_berkas" class="form-control"
                                                    value="{{ $item->nama_berkas }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-content-card>

    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('berkas-digital.master.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Master Berkas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Berkas</label>
                            <input type="text" name="nama_berkas" id="input_nama" class="form-control"
                                placeholder="Contoh: KARTU KELUARGA" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Preview Alias Folder (Otomatis):</label>
                            <input type="text" id="preview_slug" class="form-control bg-light border-0" readonly
                                placeholder="alias_folder_akan_muncul_disini">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            // Logika Live Preview Slug (Generate Otomatis)
            const inputNama = document.getElementById('input_nama');
            const previewSlug = document.getElementById('preview_slug');

            if (inputNama) {
                inputNama.addEventListener('keyup', function() {
                    let slug = inputNama.value.toLowerCase()
                        .replace(/ /g, '_') // Ganti spasi dengan underscore (_)
                        .replace(/[^\w-]+/g, ''); // Hapus karakter selain huruf dan angka
                    previewSlug.value = slug;
                });
            }
        </script>
    @endpush
@endsection
