<div>
    <div class="d-flex justify-content-start align-items-center m-3">
        <div class="row g-3 w-100">
            <div class="col-md-2">
                <input type="date" name="start_date" id="startDate" class="form-control" placeholder="Dari Tanggal">
            </div>
            <div class="col-md-2">
                <input type="date" name="end_date" id="endDate" class="form-control" placeholder="S.d Tanggal">
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari" aria-label="Cari"
                        aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahObatCatatan" type="button">
                    <i class="ti-plus"></i> Tambah
                </button>
                @include('unit-pelayanan.rawat-inap.pelayanan.farmasi.modalcatatan')
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="resepTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal dan Jam</th>
                    <th>Nama Obat</th>
                    <th>Dosis</th>
                    <th>Frek</th>
                    <th>Petugas</th>
                    <th>Keterangan</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($riwayatCatatanObat) && count($riwayatCatatanObat) > 0)
                    @foreach($riwayatCatatanObat as $index => $catatan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($catatan->tanggal)->format('d/m/Y H:i') }}</td>
                        <td>{{ $catatan->nama_obat }}</td>
                        <td>{{ $catatan->dosis }} {{ $catatan->satuan }}</td>
                        <td>{{ $catatan->freak }}</td>
                        <td>{{ $catatan->petugas->name ?? $catatan->kd_petugas ?? 'Tidak Diketahui' }}</td>
                        <td>{{ $catatan->keterangan }}</td>
                        <td>{{ $catatan->catatan }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $catatan->id }}">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada catatan pemberian obat</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if (isset($error))
        <div class="alert alert-warning">{{ $error }}</div>
    @elseif(!isset($riwayatCatatanObat) || $riwayatCatatanObat->isEmpty())
        <div class="alert alert-info">
            Tidak ada riwayat pemberian obat untuk pasien ini.
        </div>
    @endif
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    console.log('ID yang akan dihapus:', id); // Debug ID

                    // Ganti confirm dengan SweetAlert
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Catatan ini akan dihapus secara permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const url = "{{ route('rawat-inap.farmasi.hapusCatatanObat', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, ':id']) }}".replace(':id', id);
                            console.log('URL yang dikirim:', url); // Debug URL

                            fetch(url, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Response:', data); // Debug response
                                if (data.message.includes('berhasil')) {
                                    Swal.fire(
                                        'Terhapus!',
                                        'Catatan berhasil dihapus.',
                                        'success'
                                    ).then(() => {
                                        this.closest('tr').remove();
                                        document.querySelectorAll('#resepTable tbody tr').forEach((row, index) => {
                                            row.cells[0].textContent = index + 1;
                                        });
                                    });
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        'Gagal menghapus: ' + data.error,
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus.',
                                    'error'
                                );
                            });
                        }
                    });
                });
            });
        });
    </script>
@endpush
