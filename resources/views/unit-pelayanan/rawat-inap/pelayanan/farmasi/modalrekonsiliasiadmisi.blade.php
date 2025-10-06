{{-- Modal Tambah Rekonsiliasi Admisi --}}
<div class="modal fade" id="tambahRekonsiliasiAdmisi" tabindex="-1" aria-labelledby="tambahRekonsiliasiAdmisiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Rekonsiliasi Obat Admisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="rekonsiliasiAdmisiForm"
                    action="{{ route('rawat-inap.farmasi.rekonsiliasiObatAdmisi', [
                        $dataMedis->kd_pasien,
                        $dataMedis->kd_unit,
                        date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                        $dataMedis->urut_masuk,
                    ]) }}"
                    method="post">
                    @csrf
                    
                    <!-- Cari Nama Obat -->
                    <div class="mb-3 position-relative">
                        <label for="cariObatRekonAdmisi" class="form-label">Cari Nama Obat</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="cariObatRekonAdmisi" name="nama_obat"
                                placeholder="Ketik nama obat..." autocomplete="off" required>
                            <button class="btn btn-outline-secondary" type="button" id="clearObatRekonAdmisi"
                                style="display:none;">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <div id="obatListRekonAdmisi" class="dropdown-menu w-100"></div>
                    </div>

                    <!-- Aturan Pakai -->
                    <div class="mb-3">
                        <label class="form-label">Aturan Pakai</label>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label small">Frekuensi/Interval</label>
                                <input type="text" class="form-control form-control-sm" id="frekuensi_admisi"
                                    name="frekuensi" placeholder="Contoh: 3x1" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Keterangan</label>
                                <select class="form-select form-select-sm" id="keterangan_admisi" name="keterangan" required>
                                    <option value="Sebelum Makan">Sebelum Makan</option>
                                    <option value="Sesudah Makan" selected>Sesudah Makan</option>
                                    <option value="Saat Makan">Saat Makan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Dosis</label>
                                <input type="text" class="form-control form-control-sm" id="dosis_admisi" name="dosis"
                                    placeholder="Contoh: 500mg" required>
                            </div>
                        </div>
                    </div>

                    <!-- Satuan -->
                    <div class="mb-3">
                        <label for="satuan_admisi" class="form-label">Satuan</label>
                        <input type="text" class="form-control" id="satuan_admisi" name="satuan" 
                            placeholder="Contoh: Tablet, Kapsul" readonly>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-3">
                        <label for="catatan_admisi" class="form-label">Catatan</label>
                        <textarea class="form-control" id="catatan_admisi" name="catatan" rows="3"
                            placeholder="Masukkan catatan tambahan..."></textarea>
                    </div>

                    <!-- Hidden Input -->
                    <input type="hidden" name="kd_petugas" value="{{ auth()->user()->id }}">
                    <input type="hidden" id="selectedObatIdAdmisi" name="obat_id" value="">
                </form>
                
                <!-- Overlay loading -->
                <div id="loadingOverlayAdmisi"
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
                <button type="button" class="btn btn-success" id="btnSaveObatAdmisi">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Rekonsiliasi Admisi --}}
<div class="modal fade" id="editRekonsiliasiAdmisi" tabindex="-1" aria-labelledby="editRekonsiliasiAdmisiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Edit Rekonsiliasi Obat Admisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRekonsiliasiAdmisiForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_rekonsiliasi_admisi_id">
                    
                    <!-- Cari Nama Obat untuk Edit -->
                    <div class="mb-3 position-relative">
                        <label for="edit_cariObatRekonAdmisi" class="form-label">Cari Nama Obat</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="edit_cariObatRekonAdmisi" name="nama_obat"
                                placeholder="Ketik nama obat..." autocomplete="off" required>
                            <button class="btn btn-outline-secondary" type="button" id="edit_clearObatRekonAdmisi"
                                style="display:none;">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <div id="edit_obatListRekonAdmisi" class="dropdown-menu w-100"></div>
                    </div>

                    <!-- Aturan Pakai -->
                    <div class="mb-3">
                        <label class="form-label">Aturan Pakai</label>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label small">Frekuensi</label>
                                <input type="text" class="form-control form-control-sm" id="edit_frekuensi_admisi" name="frekuensi" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Keterangan</label>
                                <select class="form-select form-select-sm" id="edit_keterangan_admisi" name="keterangan" required>
                                    <option value="Sebelum Makan">Sebelum Makan</option>
                                    <option value="Sesudah Makan">Sesudah Makan</option>
                                    <option value="Saat Makan">Saat Makan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Dosis</label>
                                <input type="text" class="form-control form-control-sm" id="edit_dosis_admisi" name="dosis" required>
                            </div>
                        </div>
                    </div>

                    <!-- Satuan -->
                    <div class="mb-3">
                        <label for="edit_satuan_admisi" class="form-label">Satuan</label>
                        <input type="text" class="form-control" id="edit_satuan_admisi" name="satuan" readonly>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-3">
                        <label for="edit_catatan_admisi" class="form-label">Catatan</label>
                        <textarea class="form-control" id="edit_catatan_admisi" name="catatan" rows="3"></textarea>
                    </div>

                    <!-- Hidden Input -->
                    <input type="hidden" id="edit_selectedObatIdAdmisi" name="obat_id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </button>
                <button type="button" class="btn btn-warning" id="btnUpdateObatAdmisi">
                    <i class="bi bi-save me-1"></i>Update
                </button>
            </div>
        </div>
    </div>
</div>

@push('css')
    <style>
        #obatListRekonAdmisi,
        #edit_obatListRekonAdmisi {
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

        #obatListRekonAdmisi a,
        #edit_obatListRekonAdmisi a {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-bottom: 1px solid #e9ecef;
        }

        #obatListRekonAdmisi a:last-child,
        #edit_obatListRekonAdmisi a:last-child {
            border-bottom: none;
        }

        .position-relative {
            position: relative !important;
        }
    </style>
@endpush

@push('js')
    <script>
        jQuery.noConflict();
        (function($) {
            $(document).ready(function() {

                // =================== AUTOCOMPLETE SEARCH OBAT CREATE ADMISI ===================
                let timeoutAdmisi;
                $(document).on('input', '#cariObatRekonAdmisi', function() {
                    if ($(this).prop('readonly')) {
                        $('#obatListRekonAdmisi').hide();
                        return;
                    }

                    const query = $(this).val().trim();
                    clearTimeout(timeoutAdmisi);

                    if (query.length === 0) {
                        $('#obatListRekonAdmisi').hide().empty();
                        $('#clearObatRekonAdmisi').hide();
                        return;
                    }

                    if (query.length < 2) {
                        $('#obatListRekonAdmisi').html(
                            '<div class="dropdown-item text-muted">Ketik minimal 2 karakter...</div>'
                        ).show();
                        return;
                    }

                    $('#obatListRekonAdmisi').html(`
                        <div class="dropdown-item text-center py-3">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    `).show();

                    timeoutAdmisi = setTimeout(() => {
                        $.ajax({
                            url: '{{ route('rawat-inap.farmasi.searchObat', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}',
                            method: 'GET',
                            data: { term: query },
                            dataType: 'json',
                            success: function(data) {
                                let html = '';
                                if (data && data.length > 0) {
                                    data.forEach(function(obat) {
                                        html += `
                                            <a href="#" class="dropdown-item py-2 obat-item-admisi"
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
                                    html = '<div class="dropdown-item text-muted py-2">Tidak ada hasil yang ditemukan</div>';
                                }
                                $('#obatListRekonAdmisi').html(html).show();
                            },
                            error: function(xhr) {
                                $('#obatListRekonAdmisi').html(
                                    '<div class="dropdown-item text-danger py-2">Terjadi kesalahan saat mencari obat</div>'
                                ).show();
                            }
                        });
                    }, 300);
                });

                // Pilih obat dari dropdown CREATE
                $(document).on('click', '.obat-item-admisi', function(e) {
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

                    $('#cariObatRekonAdmisi').val(obatName).prop('readonly', true);
                    $('#selectedObatIdAdmisi').val(obatId);
                    $('#satuan_admisi').val(obatSatuan);
                    $('#obatListRekonAdmisi').hide().empty();
                    $('#clearObatRekonAdmisi').show();
                });

                // Clear input CREATE
                $(document).on('click', '#clearObatRekonAdmisi', function() {
                    $('#cariObatRekonAdmisi').val('').prop('readonly', false).focus();
                    $('#selectedObatIdAdmisi').val('');
                    $('#satuan_admisi').val('');
                    $('#obatListRekonAdmisi').hide().empty();
                    $('#clearObatRekonAdmisi').hide();
                });

                // =================== AUTOCOMPLETE SEARCH OBAT EDIT ADMISI ===================
                let timeoutEditAdmisi;
                $(document).on('input', '#edit_cariObatRekonAdmisi', function() {
                    if ($(this).prop('readonly')) {
                        $('#edit_obatListRekonAdmisi').hide();
                        return;
                    }

                    const query = $(this).val().trim();
                    clearTimeout(timeoutEditAdmisi);

                    if (query.length === 0) {
                        $('#edit_obatListRekonAdmisi').hide().empty();
                        $('#edit_clearObatRekonAdmisi').hide();
                        return;
                    }

                    if (query.length < 2) {
                        $('#edit_obatListRekonAdmisi').html(
                            '<div class="dropdown-item text-muted">Ketik minimal 2 karakter...</div>'
                        ).show();
                        return;
                    }

                    $('#edit_obatListRekonAdmisi').html(`
                        <div class="dropdown-item text-center py-3">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    `).show();

                    timeoutEditAdmisi = setTimeout(() => {
                        $.ajax({
                            url: '{{ route('rawat-inap.farmasi.searchObat', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}',
                            method: 'GET',
                            data: { term: query },
                            dataType: 'json',
                            success: function(data) {
                                let html = '';
                                if (data && data.length > 0) {
                                    data.forEach(function(obat) {
                                        html += `
                                            <a href="#" class="dropdown-item py-2 edit-obat-item-admisi"
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
                                    html = '<div class="dropdown-item text-muted py-2">Tidak ada hasil yang ditemukan</div>';
                                }
                                $('#edit_obatListRekonAdmisi').html(html).show();
                            },
                            error: function(xhr) {
                                $('#edit_obatListRekonAdmisi').html(
                                    '<div class="dropdown-item text-danger py-2">Terjadi kesalahan saat mencari obat</div>'
                                ).show();
                            }
                        });
                    }, 300);
                });

                // Pilih obat dari dropdown EDIT
                $(document).on('click', '.edit-obat-item-admisi', function(e) {
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

                    $('#edit_cariObatRekonAdmisi').val(obatName).prop('readonly', true);
                    $('#edit_selectedObatIdAdmisi').val(obatId);
                    $('#edit_satuan_admisi').val(obatSatuan);
                    $('#edit_obatListRekonAdmisi').hide().empty();
                    $('#edit_clearObatRekonAdmisi').show();
                });

                // Clear input EDIT
                $(document).on('click', '#edit_clearObatRekonAdmisi', function() {
                    $('#edit_cariObatRekonAdmisi').val('').prop('readonly', false).focus();
                    $('#edit_selectedObatIdAdmisi').val('');
                    $('#edit_satuan_admisi').val('');
                    $('#edit_obatListRekonAdmisi').hide().empty();
                    $('#edit_clearObatRekonAdmisi').hide();
                });

                // Klik di luar dropdown
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('#cariObatRekonAdmisi, #obatListRekonAdmisi, #clearObatRekonAdmisi').length) {
                        $('#obatListRekonAdmisi').hide().empty();
                    }
                    if (!$(e.target).closest('#edit_cariObatRekonAdmisi, #edit_obatListRekonAdmisi, #edit_clearObatRekonAdmisi').length) {
                        $('#edit_obatListRekonAdmisi').hide().empty();
                    }
                });

                // =================== SAVE REKONSILIASI ADMISI ===================
                $(document).on('click', '#btnSaveObatAdmisi', function() {
                    if ($('#rekonsiliasiAdmisiForm')[0].checkValidity()) {
                        const $btn = $(this);
                        const originalBtnText = $btn.html();
                        $btn.html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...').prop('disabled', true);
                        $('#loadingOverlayAdmisi').removeClass('d-none');

                        $.ajax({
                            url: $('#rekonsiliasiAdmisiForm').attr('action'),
                            method: 'POST',
                            data: $('#rekonsiliasiAdmisiForm').serialize(),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                $btn.html(originalBtnText).prop('disabled', false);
                                $('#loadingOverlayAdmisi').addClass('d-none');

                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message
                                    }).then(() => {
                                        $('#tambahRekonsiliasiAdmisi').modal('hide');
                                        $('#rekonsiliasiAdmisiForm')[0].reset();
                                        $('#clearObatRekonAdmisi').click();
                                        location.reload();
                                    });
                                }
                            },
                            error: function(xhr) {
                                $btn.html(originalBtnText).prop('disabled', false);
                                $('#loadingOverlayAdmisi').addClass('d-none');

                                let errorMessage = 'Terjadi kesalahan saat menyimpan data.';
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                                } else if (xhr.responseJSON && xhr.responseJSON.message) {
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
                        $('#rekonsiliasiAdmisiForm')[0].reportValidity();
                    }
                });

                // =================== HANDLE EDIT BUTTON ===================
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
                                $('#edit_cariObatRekonAdmisi').val(data.nama_obat).prop('readonly', true);
                                $('#edit_selectedObatIdAdmisi').val(data.id);
                                $('#edit_frekuensi_admisi').val(data.frekuensi);
                                $('#edit_keterangan_admisi').val(data.keterangan);
                                $('#edit_dosis_admisi').val(data.dosis);
                                $('#edit_satuan_admisi').val(data.satuan);
                                $('#edit_catatan_admisi').val(data.catatan);
                                $('#edit_clearObatRekonAdmisi').show();

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

                // =================== HANDLE UPDATE BUTTON ===================
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

                // Reset form saat modal ditutup
                $('#editRekonsiliasiAdmisi').on('hidden.bs.modal', function() {
                    $('#edit_cariObatRekonAdmisi').prop('readonly', false);
                    $('#edit_clearObatRekonAdmisi').hide();
                    $('#edit_obatListRekonAdmisi').hide().empty();
                });
            });
        })(jQuery);
    </script>
@endpush