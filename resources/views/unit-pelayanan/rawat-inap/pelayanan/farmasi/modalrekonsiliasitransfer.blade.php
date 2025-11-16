{{-- Modal Tambah Rekonsiliasi Transfer --}}
<div class="modal fade" id="tambahRekonsiliasiTransfer" tabindex="-1" aria-labelledby="tambahRekonsiliasiTransferLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Rekonsiliasi Obat Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="rekonsiliasiTransferForm"
                    action="{{ route('rawat-inap.farmasi.rekonsiliasiObatTransfer', [
                        $dataMedis->kd_pasien,
                        $dataMedis->kd_unit,
                        date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                        $dataMedis->urut_masuk,
                    ]) }}"
                    method="post">
                    @csrf

                    <!-- Cari Nama Obat -->
                    <div class="mb-3 position-relative">
                        <label for="cariObatRekonTransfer" class="form-label">Nama Obat</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="cariObatRekonTransfer" name="nama_obat"
                                placeholder="Ketik nama obat..." autocomplete="off" required>
                            <button class="btn btn-outline-secondary" type="button" id="clearObatRekonTransfer"
                                style="display:none;">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <div id="obatListRekonTransfer" class="dropdown-menu w-100"></div>
                    </div>

                    <!-- Dosis dan Frekuensi -->
                    <div class="mb-3">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label">Dosis</label>
                                <input type="text" class="form-control" id="dosis_transfer" name="dosis"
                                    placeholder="Contoh: 500mg" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Frekuensi</label>
                                <input type="text" class="form-control" id="frekuensi_transfer" name="frekuensi"
                                    placeholder="Contoh: 3x1" required>
                            </div>
                        </div>
                    </div>

                    <!-- Cara Pemberian -->
                    <div class="mb-3">
                        <label class="form-label">Cara Pemberian</label>
                        <input type="text" class="form-control" id="keterangan_transfer" name="keterangan"
                            autocomplete="off" required>
                    </div>

                    <!-- Tindak Lanjut oleh DPJP -->
                    <div class="mb-3">
                        <label class="form-label">Tindak Lanjut oleh DPJP</label>
                        <div class="card border-light">
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="tindak_lanjut"
                                        id="lanjutSama_transfer" value="Lanjut aturan pakai sama" required>
                                    <label class="form-check-label" for="lanjutSama_transfer">
                                        Lanjut aturan pakai sama
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="tindak_lanjut"
                                        id="lanjutBerubah_transfer" value="Lanjut aturan pakai berubah">
                                    <label class="form-check-label" for="lanjutBerubah_transfer">
                                        Lanjut aturan pakai berubah
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tindak_lanjut"
                                        id="stop_transfer" value="Stop">
                                    <label class="form-check-label" for="stop_transfer">
                                        Stop
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Perubahan Aturan Pakai -->
                    <div class="mb-3">
                        <label for="perubahanpakai_transfer" class="form-label">Perubahan Aturan Pakai</label>
                        <textarea class="form-control" id="perubahanpakai_transfer" name="perubahanpakai" rows="3"
                            placeholder="Masukkan perubahan aturan pakai jika ada..."></textarea>
                        <small class="text-muted">*Opsional - Isi hanya jika ada perubahan</small>
                    </div>

                    <!-- Hidden Input -->
                    <input type="hidden" id="selectedObatIdTransfer" name="obat_id" value="">
                </form>

                <!-- Overlay loading -->
                <div id="loadingOverlayTransfer"
                    class="d-none position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                    style="background: rgba(255, 255, 255, 0.8); z-index: 1051;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Tutup
                </button>
                <button type="button" class="btn btn-success" id="btnSaveObatTransfer">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Rekonsiliasi Transfer --}}
<div class="modal fade" id="editRekonsiliasiTransfer" tabindex="-1" aria-labelledby="editRekonsiliasiTransferLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Edit Rekonsiliasi Obat Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRekonsiliasiTransferForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_rekonsiliasi_transfer_id">

                    <!-- Cari Nama Obat untuk Edit -->
                    <div class="mb-3 position-relative">
                        <label for="edit_cariObatRekonTransfer" class="form-label">Nama Obat</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="edit_cariObatRekonTransfer"
                                name="nama_obat" placeholder="Ketik nama obat..." autocomplete="off" required>
                            <button class="btn btn-outline-secondary" type="button" id="edit_clearObatRekonTransfer"
                                style="display:none;">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <div id="edit_obatListRekonTransfer" class="dropdown-menu w-100"></div>
                    </div>

                    <!-- Dosis dan Frekuensi -->
                    <div class="mb-3">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label">Dosis</label>
                                <input type="text" class="form-control" id="edit_dosis_transfer" name="dosis"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Frekuensi</label>
                                <input type="text" class="form-control" id="edit_frekuensi_transfer"
                                    name="frekuensi" required>
                            </div>
                        </div>
                    </div>

                    <!-- Cara Pemberian -->
                    <div class="mb-3">
                        <label class="form-label">Cara Pemberian</label>
                        <input type="text" class="form-control" id="edit_keterangan_transfer" name="keterangan"
                            autocomplete="off" required>
                    </div>

                    <!-- Tindak Lanjut oleh DPJP -->
                    <div class="mb-3">
                        <label class="form-label">Tindak Lanjut oleh DPJP</label>
                        <div class="card border-light">
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="tindak_lanjut"
                                        id="edit_lanjutSama_transfer" value="Lanjut aturan pakai sama" required>
                                    <label class="form-check-label" for="edit_lanjutSama_transfer">
                                        Lanjut aturan pakai sama
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="tindak_lanjut"
                                        id="edit_lanjutBerubah_transfer" value="Lanjut aturan pakai berubah">
                                    <label class="form-check-label" for="edit_lanjutBerubah_transfer">
                                        Lanjut aturan pakai berubah
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tindak_lanjut"
                                        id="edit_stop_transfer" value="Stop">
                                    <label class="form-check-label" for="edit_stop_transfer">
                                        Stop
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Perubahan Aturan Pakai -->
                    <div class="mb-3">
                        <label for="edit_perubahanpakai_transfer" class="form-label">Perubahan Aturan Pakai</label>
                        <textarea class="form-control" id="edit_perubahanpakai_transfer" name="perubahanpakai" rows="3"></textarea>
                        <small class="text-muted">*Opsional - Isi hanya jika ada perubahan</small>
                    </div>

                    <!-- Hidden Input -->
                    <input type="hidden" id="edit_selectedObatIdTransfer" name="obat_id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </button>
                <button type="button" class="btn btn-warning" id="btnUpdateObatTransfer">
                    <i class="bi bi-save me-1"></i>Update
                </button>
            </div>
        </div>
    </div>
</div>

@push('css')
    <style>
        #obatListRekonTransfer,
        #edit_obatListRekonTransfer {
            position: absolute;
            width: 100%;
            max-height: 250px;
            overflow-y: auto;
            z-index: 1050;
            display: block;
            margin-top: 0;
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        #obatListRekonTransfer a,
        #edit_obatListRekonTransfer a {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-bottom: 1px solid #e9ecef;
        }

        #obatListRekonTransfer a:last-child,
        #edit_obatListRekonTransfer a:last-child {
            border-bottom: none;
        }

        .position-relative {
            position: relative !important;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {

            // =================== AUTOCOMPLETE SEARCH OBAT CREATE TRANSFER ===================
            let timeoutTransfer;
            $(document).on('input', '#cariObatRekonTransfer', function() {
                if ($(this).prop('readonly')) {
                    $('#obatListRekonTransfer').hide();
                    return;
                }

                const query = $(this).val().trim();
                clearTimeout(timeoutTransfer);

                if (query.length === 0) {
                    $('#obatListRekonTransfer').hide().empty();
                    $('#clearObatRekonTransfer').hide();
                    return;
                }

                if (query.length < 2) {
                    $('#obatListRekonTransfer').html(
                        '<div class="dropdown-item text-muted">Ketik minimal 2 karakter...</div>'
                    ).show();
                    return;
                }

                $('#obatListRekonTransfer').html(`
                        <div class="dropdown-item text-center py-3">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    `).show();

                timeoutTransfer = setTimeout(() => {
                    $.ajax({
                        url: "{{ route('rawat-inap.farmasi.searchObat', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y - m - d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}",
                        method: 'GET',
                        data: {
                            term: query
                        },
                        dataType: 'json',
                        success: function(data) {
                            let html = '';
                            if (data && data.length > 0) {
                                data.forEach(function(obat) {
                                    html += `
                                            <a href="#" class="dropdown-item py-2 obat-item-transfer"
                                               data-id="${obat.id || ''}"
                                               data-nama="${obat.text || ''}"
                                               data-satuan="${obat.satuan || ''}">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fw-medium">${obat.text || 'Tidak ada nama'}</div>
                                                    <span class="badge bg-light text-dark">Satuan: ${obat.satuan || 'N/A'}</span>
                                                </div>
                                            </a>`;
                                });
                            } else {
                                html =
                                    '<div class="dropdown-item text-muted py-2">Tidak ada hasil yang ditemukan</div>';
                            }
                            $('#obatListRekonTransfer').html(html).show();
                        },
                        error: function(xhr) {
                            $('#obatListRekonTransfer').html(
                                '<div class="dropdown-item text-danger py-2">Terjadi kesalahan saat mencari obat</div>'
                            ).show();
                        }
                    });
                }, 300);
            });

            // Pilih obat dari dropdown CREATE TRANSFER
            $(document).on('click', '.obat-item-transfer', function(e) {
                e.preventDefault();
                const $this = $(this);
                const obatId = $this.data('id');
                const obatName = $this.data('nama');
                const obatSatuan = $this.data('satuan');

                if (!obatId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Obat tidak memiliki ID. Silakan coba obat lain.'
                    });
                    return;
                }

                $('#cariObatRekonTransfer').val(obatName).prop('readonly', true);
                $('#selectedObatIdTransfer').val(obatId);
                $('#obatListRekonTransfer').hide().empty();
                $('#clearObatRekonTransfer').show();
            });

            // Clear input CREATE TRANSFER
            $(document).on('click', '#clearObatRekonTransfer', function() {
                $('#cariObatRekonTransfer').val('').prop('readonly', false).focus();
                $('#selectedObatIdTransfer').val('');
                $('#obatListRekonTransfer').hide().empty();
                $('#clearObatRekonTransfer').hide();
            });

            // =================== AUTOCOMPLETE SEARCH OBAT EDIT TRANSFER ===================
            let timeoutEditTransfer;
            $(document).on('input', '#edit_cariObatRekonTransfer', function() {
                if ($(this).prop('readonly')) {
                    $('#edit_obatListRekonTransfer').hide();
                    return;
                }

                const query = $(this).val().trim();
                clearTimeout(timeoutEditTransfer);

                if (query.length === 0) {
                    $('#edit_obatListRekonTransfer').hide().empty();
                    $('#edit_clearObatRekonTransfer').hide();
                    return;
                }

                if (query.length < 2) {
                    $('#edit_obatListRekonTransfer').html(
                        '<div class="dropdown-item text-muted">Ketik minimal 2 karakter...</div>'
                    ).show();
                    return;
                }

                $('#edit_obatListRekonTransfer').html(`
                        <div class="dropdown-item text-center py-3">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    `).show();

                timeoutEditTransfer = setTimeout(() => {
                    $.ajax({
                        url: "{{ route('rawat-inap.farmasi.searchObat', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y - m - d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}",
                        method: "GET",
                        data: {
                            term: query
                        },
                        dataType: "json",
                        success: function(data) {
                            let html = '';
                            if (data && data.length > 0) {
                                data.forEach(function(obat) {
                                    html += `
                                            <a href="#" class="dropdown-item py-2 edit-obat-item-transfer"
                                               data-id="${obat.id || ''}"
                                               data-nama="${obat.text || ''}"
                                               data-satuan="${obat.satuan || ''}">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fw-medium">${obat.text || 'Tidak ada nama'}</div>
                                                    <span class="badge bg-light text-dark">Satuan: ${obat.satuan || 'N/A'}</span>
                                                </div>
                                            </a>`;
                                });
                            } else {
                                html =
                                    '<div class="dropdown-item text-muted py-2">Tidak ada hasil yang ditemukan</div>';
                            }
                            $('#edit_obatListRekonTransfer').html(html).show();
                        },
                        error: function(xhr) {
                            $('#edit_obatListRekonTransfer').html(
                                '<div class="dropdown-item text-danger py-2">Terjadi kesalahan saat mencari obat</div>'
                            ).show();
                        }
                    });
                }, 300);
            });

            // Pilih obat dari dropdown EDIT TRANSFER
            $(document).on('click', '.edit-obat-item-transfer', function(e) {
                e.preventDefault();
                const $this = $(this);
                const obatId = $this.data('id');
                const obatName = $this.data('nama');
                const obatSatuan = $this.data('satuan');

                if (!obatId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Obat tidak memiliki ID. Silakan coba obat lain.'
                    });
                    return;
                }

                $('#edit_cariObatRekonTransfer').val(obatName).prop('readonly', true);
                $('#edit_selectedObatIdTransfer').val(obatId);
                $('#edit_obatListRekonTransfer').hide().empty();
                $('#edit_clearObatRekonTransfer').show();
            });

            // Clear input EDIT TRANSFER
            $(document).on('click', '#edit_clearObatRekonTransfer', function() {
                $('#edit_cariObatRekonTransfer').val('').prop('readonly', false).focus();
                $('#edit_selectedObatIdTransfer').val('');
                $('#edit_obatListRekonTransfer').hide().empty();
                $('#edit_clearObatRekonTransfer').hide();
            });

            // Klik di luar dropdown TRANSFER
            $(document).on('click', function(e) {
                if (!$(e.target).closest(
                        '#cariObatRekonTransfer, #obatListRekonTransfer, #clearObatRekonTransfer').length) {
                    $('#obatListRekonTransfer').hide().empty();
                }
                if (!$(e.target).closest(
                        '#edit_cariObatRekonTransfer, #edit_obatListRekonTransfer, #edit_clearObatRekonTransfer'
                    ).length) {
                    $('#edit_obatListRekonTransfer').hide().empty();
                }
            });

            // =================== SAVE REKONSILIASI TRANSFER ===================
            $(document).on('click', '#btnSaveObatTransfer', function() {
                if ($('#rekonsiliasiTransferForm')[0].checkValidity()) {
                    const $btn = $(this);
                    const originalBtnText = $btn.html();
                    $btn.html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...').prop(
                        'disabled', true);
                    $('#loadingOverlayTransfer').removeClass('d-none');

                    $.ajax({
                        url: $('#rekonsiliasiTransferForm').attr('action'),
                        method: 'POST',
                        data: $('#rekonsiliasiTransferForm').serialize(),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $btn.html(originalBtnText).prop('disabled', false);
                            $('#loadingOverlayTransfer').addClass('d-none');

                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                }).then(() => {
                                    $('#tambahRekonsiliasiTransfer').modal('hide');
                                    $('#rekonsiliasiTransferForm')[0].reset();
                                    $('#clearObatRekonTransfer').click();
                                    location.reload();
                                });
                            }
                        },
                        error: function(xhr) {
                            $btn.html(originalBtnText).prop('disabled', false);
                            $('#loadingOverlayTransfer').addClass('d-none');

                            let errorMessage = 'Terjadi kesalahan saat menyimpan data.';
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                errorMessage = Object.values(xhr.responseJSON.errors).flat()
                                    .join('<br>');
                            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                html: errorMessage
                            });
                        }
                    });
                } else {
                    $('#rekonsiliasiTransferForm')[0].reportValidity();
                }
            });

            // =================== HANDLE EDIT BUTTON TRANSFER ===================
            $(document).on('click', '.btn-edit-rekonsiliasi-transfer', function() {
                const id = $(this).data('id');
                const url =
                    "{{ route('rawat-inap.farmasi.editRekonsiliasiObatTransfer', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, ':id']) }}"
                    .replace(':id', id);

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;

                            $('#edit_rekonsiliasi_transfer_id').val(data.id);
                            $('#edit_cariObatRekonTransfer').val(data.nama_obat).prop(
                                'readonly', true);
                            $('#edit_selectedObatIdTransfer').val(data.id);
                            $('#edit_dosis_transfer').val(data.dosis);
                            $('#edit_frekuensi_transfer').val(data.frekuensi);
                            $('#edit_keterangan_transfer').val(data.keterangan);
                            $('#edit_perubahanpakai_transfer').val(data.perubahanpakai);
                            $('#edit_clearObatRekonTransfer').show();

                            // Set radio button tindak lanjut
                            let tindakLanjut = '';
                            if (data.tindak_lanjut == 1) {
                                tindakLanjut = 'Lanjut aturan pakai sama';
                            } else if (data.tindak_lanjut == 2) {
                                tindakLanjut = 'Lanjut aturan pakai berubah';
                            } else {
                                tindakLanjut = 'Stop';
                            }
                            $('#editRekonsiliasiTransfer input[name="tindak_lanjut"][value="' +
                                tindakLanjut + '"]').prop('checked', true);

                            $('#editRekonsiliasiTransfer').modal('show');
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

            // =================== HANDLE UPDATE BUTTON TRANSFER ===================
            $(document).on('click', '#btnUpdateObatTransfer', function() {
                const id = $('#edit_rekonsiliasi_transfer_id').val();
                const url =
                    "{{ route('rawat-inap.farmasi.updateRekonsiliasiObatTransfer', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, ':id']) }}"
                    .replace(':id', id);

                if ($('#editRekonsiliasiTransferForm')[0].checkValidity()) {
                    const $btn = $(this);
                    const originalBtnText = $btn.html();
                    $btn.html('<span class="spinner-border spinner-border-sm"></span> Updating...').prop(
                        'disabled', true);

                    $.ajax({
                        url: url,
                        method: 'PUT',
                        data: $('#editRekonsiliasiTransferForm').serialize(),
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
                                    $('#editRekonsiliasiTransfer').modal('hide');
                                    location.reload();
                                });
                            }
                        },
                        error: function(xhr) {
                            $btn.html(originalBtnText).prop('disabled', false);
                            let errorMessage = 'Gagal memperbarui data';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: errorMessage
                            });
                        }
                    });
                } else {
                    $('#editRekonsiliasiTransferForm')[0].reportValidity();
                }
            });

            // =================== HANDLE DELETE BUTTON TRANSFER ===================
            $(document).on('click', '.btn-delete-rekonsiliasi-transfer', function() {
                const id = $(this).data('id');
                const url =
                    "{{ route('rawat-inap.farmasi.deleteRekonsiliasiObatTransfer', [$dataMedis->kd_pasien, $dataMedis->kd_unit, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, ':id']) }}"
                    .replace(':id', id);

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Rekonsiliasi obat transfer ini akan dihapus secara permanen!',
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
                                let errorMessage = 'Gagal menghapus data';
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

            // Reset form saat modal ditutup TRANSFER
            $('#editRekonsiliasiTransfer').on('hidden.bs.modal', function() {
                $('#edit_cariObatRekonTransfer').prop('readonly', false);
                $('#edit_clearObatRekonTransfer').hide();
                $('#edit_obatListRekonTransfer').hide().empty();
                $('#editRekonsiliasiTransferForm')[0].reset();
            });

            $('#tambahRekonsiliasiTransfer').on('hidden.bs.modal', function() {
                $('#rekonsiliasiTransferForm')[0].reset();
                $('#cariObatRekonTransfer').prop('readonly', false);
                $('#clearObatRekonTransfer').hide();
                $('#obatListRekonTransfer').hide().empty();
                $('#selectedObatIdTransfer').val('');
            });
        });
    </script>
@endpush
