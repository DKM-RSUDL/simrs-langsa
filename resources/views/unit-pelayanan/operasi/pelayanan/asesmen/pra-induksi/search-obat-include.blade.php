@push('css')
    <style>
        /* Container untuk positioning relatif */
        .obat-search-wrapper {
            position: relative;
            width: 100%;
        }

        /* Dropdown styling */
        .obat-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 1050;
            display: none;
            max-height: 300px;
            overflow-y: auto;
            margin-top: 2px;
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        /* Show dropdown */
        .obat-dropdown.show {
            display: block;
        }

        /* Dropdown item styling */
        .obat-dropdown .dropdown-item {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
        }

        .obat-dropdown .dropdown-item:last-child {
            border-bottom: none;
        }

        .obat-dropdown .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .obat-dropdown .dropdown-item.active,
        .obat-dropdown .dropdown-item:active {
            background-color: #e9ecef;
        }

        /* Loading state */
        .obat-dropdown .loading-item {
            text-align: center;
            padding: 1rem;
            color: #6c757d;
        }

        /* Empty state */
        .obat-dropdown .empty-item {
            padding: 1rem;
            color: #6c757d;
            text-align: center;
        }

        /* Error state */
        .obat-dropdown .error-item {
            padding: 1rem;
            color: #dc3545;
            text-align: center;
        }

        /* Badge dalam dropdown */
        .obat-dropdown .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Scrollbar styling untuk dropdown */
        .obat-dropdown::-webkit-scrollbar {
            width: 6px;
        }

        .obat-dropdown::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .obat-dropdown::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .obat-dropdown::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            let searchTimeout;

            // ============================================
            // HANDLE EDIT MODE (Check existing values)
            // ============================================
            $('.obat-search').each(function() {
                const $input = $(this);
                const hiddenId = $input.data('target');
                const clearBtnId = $input.data('clear');
                const obatId = $(`#${hiddenId}`).val();

                // Kalau ada value obat dan ID obat (mode edit)
                if ($input.val().trim() !== '' && obatId) {
                    $input.prop('readonly', true);
                    $(`#${clearBtnId}`).show();
                }
            });

            // ============================================
            // EVENT: Input Search (Universal)
            // ============================================
            $(document).on('input', '.obat-search', function() {
                const $input = $(this);

                if ($input.prop('readonly')) {
                    $(`#${$input.data('dropdown')}`).removeClass('show');
                    return;
                }

                const query = $input.val().trim();
                const $dropdown = $(`#${$input.data('dropdown')}`);
                const $clearBtn = $(`#${$input.data('clear')}`);

                clearTimeout(searchTimeout);

                if (query.length === 0) {
                    $dropdown.removeClass('show').empty();
                    $clearBtn.hide();
                    return;
                }

                if (query.length < 2) {
                    $dropdown.html(
                        '<div class="dropdown-item empty-item">Ketik minimal 2 karakter...</div>'
                    ).addClass('show');
                    return;
                }

                // Show loading
                $dropdown.html(`
                    <div class="dropdown-item loading-item">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="mt-2">Mencari obat...</div>
                    </div>
                `).addClass('show');

                // Ambil URL dari data attribute (untuk support multiple routes)
                const searchUrl = $input.data('search-url') ||
                    '{{ route('operasi.pelayanan.asesmen.pra-induksi.searchObat', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}';

                // Debounce AJAX
                searchTimeout = setTimeout(() => {
                    $.ajax({
                        url: searchUrl,
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
                                        <a href="#" class="dropdown-item obat-item"
                                           data-id="${obat.id || ''}"
                                           data-name="${obat.text || ''}"
                                           data-harga="${obat.harga || ''}"
                                           data-satuan="${obat.satuan || ''}"
                                           data-input="${$input.attr('id')}"
                                           data-hidden="${$input.data('target')}"
                                           data-dropdown="${$input.data('dropdown')}"
                                           data-clear="${$input.data('clear')}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="fw-medium">${obat.text || 'Tidak ada nama'}</div>
                                                <span class="badge bg-light text-dark">${obat.satuan || 'N/A'}</span>
                                            </div>
                                        </a>`;
                                });
                            } else {
                                html =
                                    '<div class="dropdown-item empty-item">Tidak ada hasil yang ditemukan</div>';
                            }
                            $dropdown.html(html).addClass('show');
                        },
                        error: function(xhr) {
                            $dropdown.html(
                                '<div class="dropdown-item error-item"><i class="bi bi-exclamation-triangle me-2"></i>Terjadi kesalahan saat mencari obat</div>'
                            ).addClass('show');
                        }
                    });
                }, 300);
            });

            // ============================================
            // EVENT: Pilih Obat
            // ============================================
            $(document).on('click', '.obat-item', function(e) {
                e.preventDefault();
                const $this = $(this);
                const obatId = $this.data('id');
                const obatName = $this.data('name');
                const inputId = $this.data('input');
                const hiddenId = $this.data('hidden');
                const dropdownId = $this.data('dropdown');
                const clearId = $this.data('clear');

                if (!obatId) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Obat tidak memiliki ID. Silakan coba obat lain.',
                        position: 'topRight'
                    });
                    return;
                }

                $(`#${inputId}`).val(obatName).prop('readonly', true);
                $(`#${hiddenId}`).val(obatId);
                $(`#${dropdownId}`).removeClass('show').empty();
                $(`#${clearId}`).show();
            });

            // ============================================
            // EVENT: Clear Button
            // ============================================
            $(document).on('click', '.obat-clear', function() {
                const $btn = $(this);
                const inputId = $btn.data('input');
                const hiddenId = $btn.data('hidden');
                const dropdownId = $(`#${inputId}`).data('dropdown');

                $(`#${inputId}`).val('').prop('readonly', false).focus();
                $(`#${hiddenId}`).val('');
                $(`#${dropdownId}`).removeClass('show').empty();
                $btn.hide();
            });

            // ============================================
            // EVENT: Click Outside
            // ============================================
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.obat-search-wrapper').length) {
                    $('.obat-dropdown').removeClass('show').empty();
                }
            });

            // ============================================
            // EVENT: Submit Form (Universal - Cari form terdekat)
            // ============================================
            $(document).on('click', '.btn-save-form', function() {
                const $btn = $(this);
                const $form = $btn.closest('form');

                if (!$form.length) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Form tidak ditemukan!',
                        position: 'topRight'
                    });
                    return;
                }

                if ($form[0].checkValidity()) {
                    const originalBtnText = $btn.html();
                    $btn.html(`
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...
                    `).prop('disabled', true);

                    // Cari loading overlay terdekat (jika ada)
                    const $loadingOverlay = $form.find('.loading-overlay').length ?
                        $form.find('.loading-overlay') :
                        $('#loadingOverlay');

                    $loadingOverlay.removeClass('d-none');

                    $.ajax({
                        url: $form.attr('action'),
                        method: 'POST',
                        data: $form.serialize(),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $btn.html(originalBtnText).prop('disabled', false);
                            $loadingOverlay.addClass('d-none');

                            if (response.success) {
                                iziToast.success({
                                    title: 'Sukses',
                                    message: response.message ||
                                        'Data berhasil disimpan',
                                    position: 'topRight'
                                });

                                // Tutup modal jika ada
                                const $modal = $form.closest('.modal');
                                if ($modal.length) {
                                    $modal.modal('hide');
                                }

                                // Reset form jika mode tambah
                                if ($form.find('input[name="_method"]').val() !== 'PUT') {
                                    $form[0].reset();
                                    $('.obat-clear').trigger('click');
                                }

                                // Reload atau redirect
                                if (response.redirect) {
                                    window.location.href = response.redirect;
                                } else {
                                    location.reload();
                                }
                            } else {
                                iziToast.error({
                                    title: 'Error',
                                    message: response.message || 'Terjadi kesalahan',
                                    position: 'topRight'
                                });
                            }
                        },
                        error: function(xhr) {
                            $btn.html(originalBtnText).prop('disabled', false);
                            $loadingOverlay.addClass('d-none');

                            let errorMessage = 'Terjadi kesalahan saat menyimpan data.';
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                errorMessage = Object.values(xhr.responseJSON.errors).flat()
                                    .join('<br>');
                            } else if (xhr.responseJSON && xhr.responseJSON.message) {
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
                    $form[0].reportValidity();
                }
            });
        });
    </script>
@endpush
