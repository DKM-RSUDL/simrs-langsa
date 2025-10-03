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
                @include('unit-pelayanan.rawat-inap.pelayanan.farmasi.tab-admisi.modal-admisi')
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
                                <td>
                                    <button class="btn btn-sm btn-danger btn-delete-rekonsiliasi" data-id="{{ $obat->id }}">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </td>
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
        jQuery.noConflict();
        (function($) {
            $(document).ready(function() {
                $(document).on('click', '.btn-delete-rekonsiliasi', function() {
                    const id = $(this).data('id');
                    console.log('ID yang akan dihapus (Rekonsiliasi):', id);

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Rekonsiliasi obat ini akan dihapus secara permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const url = "{{ route('rawat-inap.farmasi.rekonsiliasiObatDelete', [$dataMedis->kd_pasien, $dataMedis->kd_unit, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}";
                            console.log('URL yang dikirim (Rekonsiliasi):', url);

                            $.ajax({
                                url: url,
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: { id: id },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire(
                                            'Terhapus!',
                                            response.message,
                                            'success'
                                        ).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire(
                                            'Gagal!',
                                            response.message || 'Gagal menghapus rekonsiliasi obat',
                                            'error'
                                        );
                                    }
                                },
                                error: function(xhr) {
                                    console.error('Error saat menghapus (Rekonsiliasi):', xhr);
                                    let errorMessage = 'Terjadi kesalahan saat menghapus data.';
                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                        errorMessage = xhr.responseJSON.message;
                                    }
                                    Swal.fire(
                                        'Error!',
                                        errorMessage,
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });
            });
        })(jQuery);
    </script>
@endpush
