<div class="modal fade" id="tambahRekonsiliasi" tabindex="-1" aria-labelledby="tambahRekonsiliasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="rekonsiliasiModalLabel">Tambah Admisi Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="rekonsiliasiForm"
                    action="{{ route('rawat-inap.farmasi.rekonsiliasiObat', [
                        $dataMedis->kd_pasien,
                        $dataMedis->kd_unit,
                        date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                        $dataMedis->urut_masuk,
                    ]) }}"
                    method="post">
                    @csrf
                    <!-- Cari Nama Obat -->
                    <div class="mb-3 position-relative">
                        <label for="cariObatRekon" class="form-label">Cari Nama Obat</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="cariObatRekon" name="nama_obat"
                                placeholder="Ketik nama obat..." autocomplete="off" required>
                            <button class="btn btn-outline-secondary" type="button" id="clearObatRekon"
                                style="display:none;">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <div id="obatListRekon" class="dropdown-menu w-100"></div>
                    </div>

                    <!-- Aturan Pakai -->
                    <div class="mb-3">
                        <label class="form-label">Aturan Pakai</label>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label small">Frekuensi/Interval</label>
                                <input type="text" class="form-control form-control-sm" id="frekuensi"
                                    name="frekuensi" placeholder="Frekuensi/Interval" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Keterangan</label>
                                <select class="form-select form-select-sm" id="keterangan" name="keterangan" required>
                                    <option value="Sebelum Makan">Sebelum Makan</option>
                                    <option value="Sesudah Makan" selected>Sesudah Makan</option>
                                    <option value="Saat Makan">Saat Makan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Dosis</label>
                                <input type="text" class="form-control form-control-sm" id="dosis" name="dosis"
                                    placeholder="Dosis" required>
                            </div>
                        </div>
                    </div>

                    <!-- Tindak Lanjut dan Obat Dibawa -->
                    <div class="mb-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card border-light h-100">
                                    <div class="card-header bg-light">Tindak Lanjut Oleh DPJP</div>
                                    <div class="card-body">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="tindak_lanjut"
                                                id="lanjutSama" value="Lanjut aturan pakai sama" required>
                                            <label class="form-check-label" for="lanjutSama">Lanjut aturan pakai
                                                sama</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="tindak_lanjut"
                                                id="lanjutBerubah" value="Lanjut aturan pakai berubah">
                                            <label class="form-check-label" for="lanjutBerubah">Lanjut aturan pakai
                                                berubah</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tindak_lanjut"
                                                id="stop" value="Stop">
                                            <label class="form-check-label" for="stop">Stop</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-light h-100">
                                    <div class="card-header bg-light">Obat Dibawa Pulang?</div>
                                    <div class="card-body">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="dibawa" id="bawaYa"
                                                value="1" required>
                                            <label class="form-check-label" for="bawaYa">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="dibawa"
                                                id="bawaTidak" value="0">
                                            <label class="form-check-label" for="bawaTidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Perubahan Aturan Pakai -->
                    <div class="mb-3">
                        <label for="perubahanpakai" class="form-label">Perubahan Aturan Pakai</label>
                        <textarea class="form-control" id="perubahanpakai" name="perubahanpakai" rows="3"
                            placeholder="Masukkan perubahan aturan pakai obat..."></textarea>
                    </div>

                    <!-- Hidden Input untuk kd_petugas -->
                    <input type="hidden" name="kd_petugas" value="{{ auth()->user()->id }}">
                    <input type="hidden" id="selectedObatId" name="obat_id" value="">
                </form>
                <!-- Overlay loading -->
                <div id="loadingOverlay"
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
                <button type="button" class="btn btn-success" id="btnSaveObat">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    #obatListRekon {
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

    #obatListRekon a {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        border-bottom: 1px solid #e9ecef;
    }

    #obatListRekon a:last-child {
        border-bottom: none;
    }

    .position-relative {
        position: relative !important;
    }

    .modal-content {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .modal-header {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .card-header {
        font-weight: 500;
        padding: 0.5rem 1rem;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>

@push('js')
    <script>
        jQuery.noConflict();
        (function($) {
            $(document).ready(function() {

                // Debounce untuk event input
                let timeout;
                $(document).on('input', '#cariObatRekon', function() {
                    if ($(this).prop('readonly')) {
                        $('#obatListRekon').hide();
                        return;
                    }

                    const query = $(this).val().trim();
                    clearTimeout(timeout);

                    if (query.length === 0) {
                        $('#obatListRekon').hide().empty();
                        $('#clearObatRekon').hide();
                        return;
                    }

                    if (query.length < 2) {
                        $('#obatListRekon').html(
                            '<div class="dropdown-item text-muted">Ketik minimal 2 karakter...</div>'
                        ).show();
                        return;
                    }

                    $('#obatListRekon').html(`
                    <div class="dropdown-item text-center py-3">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `).show();

                    timeout = setTimeout(() => {
                        $.ajax({
                            url: '{{ route('farmasi.searchObat', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}',
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
                                        <a href="#" class="dropdown-item py-2" 
                                           data-id="${obat.id || ''}" 
                                           data-harga="${obat.harga || ''}" 
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
                                $('#obatListRekon').html(html).show();
                            },
                            error: function(xhr) {
                                $('#obatListRekon').html(
                                    '<div class="dropdown-item text-danger py-2">Terjadi kesalahan saat mencari obat</div>'
                                ).show();
                            }
                        });
                    }, 300);
                });

                // Pilih obat
                $(document).on('click', '#obatListRekon a', function(e) {
                    e.preventDefault();
                    const $this = $(this);
                    const obatId = $this.data('id');
                    const obatName = $this.find('.fw-medium').text();

                    if (!obatId) {
                        iziToast.error({
                            title: 'Error',
                            message: 'Obat tidak memiliki ID. Silakan coba obat lain.',
                            position: 'topRight'
                        });
                        Actions
                        return;
                    }

                    $('#cariObatRekon').val(obatName).prop('readonly', true);
                    $('#selectedObatId').val(obatId);
                    $('#obatListRekon').hide().empty();
                    $('#clearObatRekon').show();
                });

                // Clear input
                $(document).on('click', '#clearObatRekon', function() {
                    $('#cariObatRekon').val('').prop('readonly', false).focus();
                    $('#selectedObatId').val('');
                    $('#obatListRekon').hide().empty();
                    $('#clearObatRekon').hide();
                });

                // Klik di luar dropdown
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('#cariObatRekon, #obatListRekon, #clearObatRekon')
                        .length) {
                        $('#obatListRekon').hide().empty();
                    }
                });

                // Submit form
                $(document).on('click', '#btnSaveObat', function() {

                    const obatId = $('#selectedObatId').val();
                    if (!obatId) {
                        iziToast.error({
                            title: 'Error',
                            message: 'Silakan pilih obat terlebih dahulu!',
                            position: 'topRight'
                        });
                        $('#cariObatRekon').focus();
                        return;
                    }

                    if ($('#rekonsiliasiForm')[0].checkValidity()) {
                        const $btn = $(this);
                        const originalBtnText = $btn.html();
                        $btn.html(`
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...
                    `).prop('disabled', true);
                        $('#loadingOverlay').removeClass('d-none');

                        $.ajax({
                            url: $('#rekonsiliasiForm').attr('action'),
                            method: 'POST',
                            data: $('#rekonsiliasiForm').serialize(),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                $btn.html(originalBtnText).prop('disabled', false);
                                $('#loadingOverlay').addClass('d-none');

                                if (response.success) {
                                    iziToast.success({
                                        title: 'Sukses',
                                        message: response.message,
                                        position: 'topRight'
                                    });
                                    $('#tambahRekonsiliasi').modal('hide');
                                    $('#rekonsiliasiForm')[0].reset();
                                    $('#clearObatRekon').click();
                                    location.reload();
                                } else {
                                    iziToast.error({
                                        title: 'Error',
                                        message: response.message,
                                        position: 'topRight'
                                    });
                                }
                            },
                            error: function(xhr) {
                                $btn.html(originalBtnText).prop('disabled', false);
                                $('#loadingOverlay').addClass('d-none');

                                let errorMessage = 'Terjadi kesalahan saat menyimpan data.';
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    errorMessage = Object.values(xhr.responseJSON.errors)
                                        .flat().join('<br>');
                                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                iziToast.error({
                                    title: 'Error',
                                    message: errorMessage,
                                    position: 'topRight'
                                });
                                console.error('Error AJAX:', xhr);
                            }
                        });
                    } else {
                        $('#rekonsiliasiForm')[0].reportValidity();
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
