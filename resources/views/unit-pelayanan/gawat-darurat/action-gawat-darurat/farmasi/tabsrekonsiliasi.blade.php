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
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahRekonsiliasi"
                    type="button">
                    <i class="ti-plus"></i> Tambah
                </button>
                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.farmasi.modalrekonsiliasi')
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="resepTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Dosis</th>
                    <th>Frek</th>
                    <th>Keterangan</th>
                    <th>Tindak Lanjut</th>
                    <th>Perubahan Aturan Pakai</th>
                    <th>Dibawa Pasien</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($rekonsiliasiObat->isEmpty())
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data</td>
                    </tr>
                @else
                    @foreach ($rekonsiliasiObat as $index => $obat)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $obat->nama_obat }}</td>
                            <td>{{ $obat->dosis_obat }}</td>
                            <td>{{ $obat->frekuensi_obat }}</td>
                            <td>{{ $obat->keterangan_obat }}</td>
                            <td>
                                @if ($obat->tindak_lanjut_dpjp == 1)
                                    Lanjut aturan pakai sama
                                @elseif ($obat->tindak_lanjut_dpjp == 2)
                                    Lanjut aturan pakai berubah
                                @else
                                    Stop
                                @endif
                            </td>
                            <td>{{ $obat->perubahan_aturan_pakai ?? '-' }}</td>
                            <td>{{ $obat->obat_dibawa_pulang ? 'Ya' : 'Tidak' }}</td>
                            <td>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $obat->id }}">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            // Delete button click
            $(document).on('click', '.btn-delete', function() {
                const id = $(this).data('id');


                if (confirm('Apakah Anda yakin ingin menghapus rekonsiliasi obat ini?')) {
                    $.ajax({
                        url: "{{ route('farmasi.rekonsiliasiObatDelete', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}",
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(response) {
                            if (response.success) {
                                iziToast.success({
                                    title: 'Sukses',
                                    message: response.message,
                                    position: 'topRight'
                                });
                                location.reload(); // Refresh halaman untuk memperbarui tabel
                            } else {
                                iziToast.error({
                                    title: 'Error',
                                    message: response.message,
                                    position: 'topRight'
                                });
                            }
                        },
                        error: function(xhr) {
                            iziToast.error({
                                title: 'Error',
                                message: 'Terjadi kesalahan saat menghapus data.',
                                position: 'topRight'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
