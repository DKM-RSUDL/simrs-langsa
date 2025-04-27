<div class="modal fade" id="tambahObatCatatan" tabindex="-1" aria-labelledby="tambahObatCatatanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="obatModalLabel">Tambah Catatan Pemberian Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body position-relative">
                <form id="catatanObatForm"
                    action="{{ route('rawat-inap.farmasi.catatanObat', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf
                    <!-- Cari Nama Obat -->
                    <div class="mb-3 position-relative">
                        <label for="cariObatCatatan" class="form-label">Cari Nama Obat</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="cariObatCatatan"
                                placeholder="Ketik nama obat..." autocomplete="off" required>
                            <button class="btn btn-outline-secondary" type="button" id="clearObatCatatan"
                                style="display:none;">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <input type="hidden" id="selectedObatIdCatatan" name="obat_id">
                        <input type="hidden" id="nama_obat" name="nama_obat">
                        <div id="obatListCatatan" class="dropdown-menu w-100"></div>
                    </div>

                    <!-- Aturan Pakai -->
                    <div class="mb-3">
                        <label class="form-label">Aturan Pakai</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label small">Frekuensi/Interval</label>
                                <select class="form-select form-select-sm" id="frekuensi" name="frekuensi" required>
                                    <option value="1 x 1 hari">1 x 1 hari</option>
                                    <option value="2 x 1 hari">2 x 1 hari</option>
                                    <option value="3 x 1 hari" selected>3 x 1 hari</option>
                                    <option value="4 x 1 hari">4 x 1 hari</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Keterangan</label>
                                <select class="form-select form-select-sm" id="keterangan" name="keterangan" required>
                                    <option value="Sebelum Makan">Sebelum Makan</option>
                                    <option value="Sesudah Makan" selected>Sesudah Makan</option>
                                    <option value="Saat Makan">Saat Makan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Dosis, Satuan, Freak -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label small">Dosis Sekali Minum</label>
                            <select class="form-select form-select-sm" id="dosis" name="dosis" required>
                                <option value="1/4">1/4</option>
                                <option value="1/2" selected>1/2</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Satuan</label>
                            <input type="text" class="form-control form-control-sm" id="satuan" name="satuan"
                                value="Tablet" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Freak</label>
                            <input type="number" class="form-control form-control-sm" id="freak" name="freak"
                                value="1" min="1" required>
                        </div>
                    </div>

                    <!-- Tanggal dan Jam -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small">Tanggal</label>
                            <input type="date" class="form-control form-control-sm" id="tanggal" name="tanggal"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Jam</label>
                            <input type="time" class="form-control form-control-sm" id="jam" name="jam"
                                required>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan Pemberian Obat</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3"
                            placeholder="Masukkan catatan pemberian obat..."></textarea>
                    </div>

                    <!-- Hidden Input untuk kd_petugas -->
                    <input type="hidden" name="kd_petugas" value="{{ auth()->user()->id }}">

                    <!-- Overlay Loading -->
                    <div id="loadingOverlay"
                        class="d-none position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                        style="background: rgba(255, 255, 255, 0.8); z-index: 1051;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Tutup
                </button>
                <button type="button" class="btn btn-success" id="btnSaveObatCatatan">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        #obatListCatatan {
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

        #obatListCatatan a {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-bottom: 1px solid #e9ecef;
        }

        #obatListCatatan a:last-child {
            border-bottom: none;
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

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
@endpush

@push('js')
    <script>
        jQuery.noConflict();
        (function($) {
            $(document).ready(function() {
                // Inisialisasi tanggal dan jam
                function initDateTime() {
                    $('#tanggal').val(new Date().toISOString().split('T')[0]);
                    const now = new Date();
                    $('#jam').val(now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0'));
                }

                // Debounce untuk event input
                let timeout;
                $('#cariObatCatatan').on('input', function() {
                    if ($(this).prop('readonly')) {
                        $('#obatListCatatan').hide();
                        return;
                    }

                    const query = $(this).val().trim();
                    clearTimeout(timeout);

                    if (query.length === 0) {
                        $('#obatListCatatan').hide().empty();
                        $('#clearObatCatatan').hide();
                        return;
                    }

                    if (query.length < 2) {
                        $('#obatListCatatan').html(
                            '<div class="dropdown-item text-muted">Ketik minimal 2 karakter...</div>'
                        ).show();
                        return;
                    }

                    $('#obatListCatatan').html(`
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
                            data: { term: query },
                            dataType: 'json',
                            success: function(data) {
                                let html = '';
                                if (data && data.length > 0) {
                                    data.forEach(function(obat) {
                                        html += `
                                            <a href="#" class="dropdown-item py-2" 
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
                                $('#obatListCatatan').html(html).show();
                            },
                            error: function(xhr) {
                                $('#obatListCatatan').html(
                                    '<div class="dropdown-item text-danger py-2">Terjadi kesalahan saat mencari obat</div>'
                                ).show();
                            }
                        });
                    }, 300);
                });

                // Pilih obat
                $(document).on('click', '#obatListCatatan a', function(e) {
                    e.preventDefault();
                    const $this = $(this);
                    const obatId = $this.data('id');
                    const obatNama = $this.data('nama');
                    const obatSatuan = $this.data('satuan').toLowerCase();

                    if (!obatId) {
                        iziToast.error({
                            title: 'Error',
                            message: 'Obat tidak memiliki ID. Silakan coba obat lain.',
                            position: 'topRight'
                        });
                        return;
                    }

                    $('#cariObatCatatan').val(obatNama).prop('readonly', true);
                    $('#selectedObatIdCatatan').val(obatId);
                    $('#nama_obat').val(obatNama); // Tambahkan nama obat ke input tersembunyi

                    const satuanMapping = {
                        'tablet': 'Tablet', 'tab': 'Tablet',
                        'kapsul': 'Kapsul', 'caps': 'Kapsul',
                        'botol': 'cc', 'btl': 'cc',
                        'bungkus': 'Bungkus', 'bks': 'Bungkus',
                        'ampul': 'Ampul', 'amp': 'Ampul',
                        'pcs': 'Unit', 'unit': 'Unit',
                        'tetes': 'Tetes', 'cc': 'cc', 'ml': 'cc'
                    };

                    const matchedSatuan = satuanMapping[obatSatuan] || 'Tablet';
                    $('#satuan').val(matchedSatuan);

                    $('#obatListCatatan').hide().empty();
                    $('#clearObatCatatan').show();
                });

                // Clear input
                $('#clearObatCatatan').on('click', function() {
                    $('#cariObatCatatan').val('').prop('readonly', false).focus();
                    $('#selectedObatIdCatatan').val('');
                    $('#nama_obat').val('');
                    $('#satuan').val('Tablet');
                    $('#obatListCatatan').hide().empty();
                    $('#clearObatCatatan').hide();
                });

                // Klik di luar dropdown
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('#cariObatCatatan, #obatListCatatan, #clearObatCatatan').length) {
                        $('#obatListCatatan').hide().empty();
                    }
                });

                // Submit form
                $('#btnSaveObatCatatan').on('click', function() {
                    const obatId = $('#selectedObatIdCatatan').val();
                    if (!obatId) {
                        iziToast.error({
                            title: 'Error',
                            message: 'Silakan pilih obat terlebih dahulu!',
                            position: 'topRight'
                        });
                        $('#cariObatCatatan').focus();
                        return;
                    }

                    if ($('#catatanObatForm')[0].checkValidity()) {
                        const $btn = $(this);
                        const originalBtnText = $btn.html();
                        $btn.html(`
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...
                        `).prop('disabled', true);
                        $('#loadingOverlay').removeClass('d-none');

                        $.ajax({
                            url: $('#catatanObatForm').attr('action'),
                            method: 'POST',
                            data: $('#catatanObatForm').serialize(),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                $btn.html(originalBtnText).prop('disabled', false);
                                $('#loadingOverlay').addClass('d-none');
                                iziToast.success({
                                    title: 'Sukses',
                                    message: response.message,
                                    position: 'topRight'
                                });
                                $('#tambahObatCatatan').modal('hide');
                                $('#catatanObatForm')[0].reset();
                                $('#clearObatCatatan').click();
                                location.reload();
                            },
                            error: function(xhr) {
                                $btn.html(originalBtnText).prop('disabled', false);
                                $('#loadingOverlay').addClass('d-none');
                                let errorMessage = 'Gagal menyimpan catatan.';
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                                } else if (xhr.responseJSON && xhr.responseJSONメッセージ) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                iziToast.error({
                                    title: 'Error',
                                    message: errorMessage,
                                    position: 'topRight'
                                });
                            }
                        });
                    } else {
                        $('#catatanObatForm')[0].reportValidity();
                    }
                });

                // Inisialisasi saat modal dibuka
                $('#tambahObatCatatan').on('show.bs.modal', function() {
                    initDateTime();
                    $('#cariObatCatatan').val('').prop('readonly', false);
                    $('#selectedObatIdCatatan').val('');
                    $('#nama_obat').val('');
                    $('#satuan').val('Tablet');
                    $('#clearObatCatatan').hide();
                    $('#obatListCatatan').hide().empty();
                });

                // Reset form saat modal ditutup
                $('#tambahObatCatatan').on('hidden.bs.modal', function() {
                    $('#catatanObatForm')[0].reset();
                    initDateTime();
                    $('#cariObatCatatan').val('').prop('readonly', false);
                    $('#selectedObatIdCatatan').val('');
                    $('#nama_obat').val('');
                    $('#satuan').val('Tablet');
                    $('#clearObatCatatan').hide();
                    $('#obatListCatatan').hide().empty();
                });
            });
        })(jQuery);
    </script>
@endpush
