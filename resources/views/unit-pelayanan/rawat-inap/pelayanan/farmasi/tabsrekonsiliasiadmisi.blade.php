<div>
    <div class="d-flex justify-content-start align-items-center m-3">
        <div class="row g-3 w-100">
            <div class="col-md-2">
                <input type="date" name="start_date" id="startDateAdmisi" class="form-control" placeholder="Dari Tanggal">
            </div>
            <div class="col-md-2">
                <input type="date" name="end_date" id="endDateAdmisi" class="form-control" placeholder="S.d Tanggal">
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInputAdmisi" class="form-control" placeholder="Cari" aria-label="Cari">
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahRekonsiliasiAdmisi" type="button">
                    <i class="ti-plus"></i> Tambah
                </button>
                @include('unit-pelayanan.rawat-inap.pelayanan.farmasi.modalrekonsiliasiadmisi')
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="rekonsiliasiAdmisiTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Dosis</th>
                    <th>Frekuensi</th>
                    <th>Keterangan</th>
                    <th>Satuan</th>
                    <th>Catatan</th>
                    <th>Status Validasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($rekonsiliasiObatAdmisi->isEmpty())
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data</td>
                    </tr>
                @else
                    @foreach ($rekonsiliasiObatAdmisi as $index => $obat)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $obat->nama_obat }}</td>
                            <td>{{ $obat->dosis }}</td>
                            <td>{{ $obat->frekuensi }}</td>
                            <td>{{ $obat->keterangan }}</td>
                            <td>{{ $obat->satuan ?? '-' }}</td>
                            <td>{{ $obat->catatan ?? '-' }}</td>
                            <td>
                                @if ($obat->is_validasi)
                                    <span class="badge bg-success">Sudah Validasi</span>
                                @else
                                    <span class="badge bg-warning">Belum Validasi</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-edit-rekonsiliasi-admisi me-1" 
                                    data-id="{{ $obat->id }}"
                                    @if($obat->is_validasi) disabled @endif>
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="mt-2 btn btn-sm btn-danger btn-delete-rekonsiliasi-admisi" 
                                    data-id="{{ $obat->id }}"
                                    @if($obat->is_validasi) disabled @endif>
                                    <i class="bi bi-trash"></i>
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
        jQuery.noConflict();
        (function($) {
            $(document).ready(function() {
                
                // Handle Edit Button - ADMISI
                $(document).on('click', '.btn-edit-rekonsiliasi-admisi', function() {
                    const id = $(this).data('id');
                    const url = "{{ route('rawat-inap.farmasi.editRekonsiliasiObatAdmisi', [$dataMedis->kd_pasien, $dataMedis->kd_unit, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, ':id']) }}".replace(':id', id);

                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            if (response.success) {
                                const data = response.data;
                                $('#edit_rekonsiliasi_admisi_id').val(data.id);
                                $('#edit_nama_obat_admisi').val(data.nama_obat);
                                $('#edit_frekuensi_admisi').val(data.frekuensi);
                                $('#edit_keterangan_admisi').val(data.keterangan);
                                $('#edit_dosis_admisi').val(data.dosis);
                                $('#edit_satuan_admisi').val(data.satuan);
                                $('#edit_catatan_admisi').val(data.catatan);

                                $('#editRekonsiliasiAdmisi').modal('show');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal mengambil data'
                            });
                        }
                    });
                });

                // Handle Update - ADMISI
                $(document).on('click', '#btnUpdateObatAdmisi', function() {
                    const id = $('#edit_rekonsiliasi_admisi_id').val();
                    const url = "{{ route('rawat-inap.farmasi.updateRekonsiliasiObatAdmisi', [$dataMedis->kd_pasien, $dataMedis->kd_unit, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, ':id']) }}".replace(':id', id);

                    if ($('#editRekonsiliasiAdmisiForm')[0].checkValidity()) {
                        const $btn = $(this);
                        const originalBtnText = $btn.html();
                        $btn.html('<span class="spinner-border spinner-border-sm"></span> Updating...').prop('disabled', true);

                        $.ajax({
                            url: url,
                            method: 'PUT',
                            data: $('#editRekonsiliasiAdmisiForm').serialize(),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                $btn.html(originalBtnText).prop('disabled', false);

                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message
                                    }).then(() => {
                                        $('#editRekonsiliasiAdmisi').modal('hide');
                                        location.reload();
                                    });
                                }
                            },
                            error: function(xhr) {
                                $btn.html(originalBtnText).prop('disabled', false);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message || 'Gagal memperbarui data'
                                });
                            }
                        });
                    } else {
                        $('#editRekonsiliasiAdmisiForm')[0].reportValidity();
                    }
                });

                // Handle Delete Button - ADMISI
                $(document).on('click', '.btn-delete-rekonsiliasi-admisi', function() {
                    const id = $(this).data('id');
                    const url = "{{ route('rawat-inap.farmasi.deleteRekonsiliasiObatAdmisi', [$dataMedis->kd_pasien, $dataMedis->kd_unit, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, ':id']) }}".replace(':id', id);

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Rekonsiliasi obat admisi ini akan dihapus secara permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire(
                                            'Terhapus!',
                                            response.message,
                                            'success'
                                        ).then(() => {
                                            location.reload();
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire(
                                        'Error!',
                                        xhr.responseJSON?.message || 'Gagal menghapus data',
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