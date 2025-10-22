@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .select2-container {
            z-index: 9999;
        }

        .modal-dialog {
            z-index: 1050 !important;
        }

        .modal-content {
            overflow: visible !important;
        }

        .select2-dropdown {
            z-index: 99999 !important;
        }

        /* Menghilangkan elemen Select2 yang tidak diinginkan */
        .select2-container+.select2-container {
            display: none;
        }

        /* Menyamakan tampilan Select2 dengan Bootstrap */
        .select2-container--default .select2-selection--single {
            height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            padding-left: 0;
            padding-right: 0;
            color: #495057;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(1.5em + 0.75rem);
            position: absolute;
            top: 1px;
            right: 1px;
            width: 20px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #6c757d transparent transparent transparent;
        }

        .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent #6c757d transparent;
        }

        .select2-container--default .select2-dropdown {
            border-color: #80bdff;
            border-radius: 0.25rem;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #007bff;
        }

        /* Fokus */
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-rajal')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tabs --}}
                        @php
                            $currentRoute = Route::currentRouteName();
                        @endphp
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-jalan.konsultasi.index', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => carbon_parse($dataMedis->tgl_masuk, null, 'Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk]) }}"
                                    class="nav-link {{ $currentRoute === 'rawat-jalan.konsultasi.index' ? 'active' : '' }}"
                                    id="permintaan-tab" role="tab" aria-controls="permintaan"
                                    aria-selected="{{ $currentRoute === 'rawat-jalan.konsultasi.index' ? 'true' : 'false' }}">
                                    Permintaan
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-jalan.konsultasi.terima', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => carbon_parse($dataMedis->tgl_masuk, null, 'Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk]) }}"
                                    class="nav-link {{ $currentRoute === 'rawat-jalan.konsultasi.terima' ? 'active' : '' }}"
                                    id="terima-tab" role="tab" aria-controls="terima"
                                    aria-selected="{{ $currentRoute === 'rawat-jalan.konsultasi.terima' ? 'true' : 'false' }}">
                                    Terima
                                </a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            @if ($currentRoute === 'rawat-jalan.konsultasi.terima')
                                <div class="tab-pane fade show active" id="terima" role="tabpanel"
                                    aria-labelledby="terima-tab">
                                    {{-- TAB 2. list terima (RI → RJ) --}}
                                    @include('unit-pelayanan.rawat-jalan.pelayanan.konsultasi.include.terima')
                                </div>
                            @else
                                <div class="tab-pane fade show active" id="permintaan" role="tabpanel"
                                    aria-labelledby="permintaan-tab">
                                    {{-- TAB 1. list permintaan (RJ → RJ) --}}
                                    @include('unit-pelayanan.rawat-jalan.pelayanan.konsultasi.include.konsultasi')
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/helpers/confirm.js') }}"></script>

    {{-- Filter data to anas --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#SelectOption').change(function() {
                var periode = $(this).val();
                var queryString = '?periode=' + periode;
                window.location.href =
                    "{{ route('rawat-jalan.konsultasi.index', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => carbon_parse($dataMedis->tgl_masuk, null, 'Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk]) }}" +
                    queryString;
            });
        });

        $(document).ready(function() {
            $('#filterButton').click(function(e) {
                e.preventDefault();

                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();

                if (!startDate || !endDate) {
                    alert('Silakan pilih tanggal awal dan tanggal akhir terlebih dahulu.');
                    return;
                }

                var queryString = '?start_date=' + startDate + '&end_date=' + endDate;

                window.location.href =
                    "{{ route('rawat-jalan.konsultasi.index', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => carbon_parse($dataMedis->tgl_masuk, null, 'Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk]) }}" +
                    queryString;
            });
        });
    </script>

    <script>
        (function($) {
            "use strict";

            /*** ========= CONSTANTS ========= ***/
            const csrf = "{{ csrf_token() }}";
            const routeIndex =
                "{{ route('rawat-jalan.konsultasi.index', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => carbon_parse($dataMedis->tgl_masuk, null, 'Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk]) }}";
            const urlGetDokterByUnit =
                "{{ route('rawat-jalan.konsultasi.get-dokter-unit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}";
            const urlGetKonsulAjax =
                "{{ route('rawat-jalan.konsultasi.get-konsul-ajax', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}";

            /*** ========= HELPERS ========= ***/
            function formatTime(dateString) {
                const d = new Date(dateString);
                const hh = String(d.getHours()).padStart(2, '0');
                const mm = String(d.getMinutes()).padStart(2, '0');
                return `${hh}:${mm}`;
            }

            // Init/destroy Select2 per-modal supaya tidak dobel container
            function initSelect2In(modal) {
                const $m = $(modal);
                // destroy jika sudah pernah init
                $m.find('select.select2, select.select2-target').each(function() {
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        $(this).select2('destroy');
                    }
                });
                // re-init
                $m.find('select.select2, select.select2-target').select2({
                    dropdownParent: $m,
                    width: '100%'
                });
            }

            // Toggle loading state pada tombol submit & cegah double submit
            function lockSubmit($form, lock = true) {
                const $btn = $form.find('button[type="submit"]');
                $form.data('submitted', lock);
                $btn.prop('disabled', lock);
                // opsional: jika pakai spinner custom
                const $spinner = $btn.find('.spinner-border');
                if ($spinner.length) $spinner.toggleClass('d-none', !lock);
            }

            // Load daftar dokter berdasarkan unit ke select tujuan di modal terkait
            function loadDokterInto($modal, kdUnit) {
                const $dokterSelect = $modal.find('select[name="dokter_unit_tujuan"]');
                if (!kdUnit) {
                    $dokterSelect.html('<option value="">--Pilih Dokter--</option>').trigger('change');
                    return;
                }
                $dokterSelect.prop('disabled', true);

                $.ajax({
                        type: 'POST',
                        url: urlGetDokterByUnit,
                        dataType: 'json',
                        data: {
                            _token: csrf,
                            kd_unit: kdUnit
                        }
                    })
                    .done(function(res) {
                        let optHtml = '<option value="">--Pilih Dokter--</option>';
                        if (res?.status === 'success' && Array.isArray(res.data)) {
                            res.data.forEach(e => {
                                const kd = e?.dokter?.kd_dokter ?? '';
                                const nm = e?.dokter?.nama_lengkap ?? '';
                                optHtml += `<option value="${kd}">${nm}</option>`;
                            });
                        }
                        $dokterSelect.html(optHtml).trigger('change');
                    })
                    .fail(function() {
                        if (typeof showToast === 'function') showToast('error', 'Internal server error');
                        else console.error('Gagal memuat dokter unit.');
                    })
                    .always(function() {
                        $dokterSelect.prop('disabled', false);
                    });
            }

            /*** ========= FILTER BAR (tetap seperti semula, dirapikan) ========= ***/
            $(document).on('change', '#SelectOption', function() {
                const periode = $(this).val();
                const queryString = '?periode=' + encodeURIComponent(periode ?? '');
                window.location.href = routeIndex + queryString;
            });

            $(document).on('click', '#filterButton', function(e) {
                e.preventDefault();
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();

                if (!startDate || !endDate) {
                    alert('Silakan pilih tanggal awal dan tanggal akhir terlebih dahulu.');
                    return;
                }
                const qs =
                    `?start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`;
                window.location.href = routeIndex + qs;
            });

            /*** ========= ADD MODAL ========= ***/
            const $addModal = $('#addKonsulModal');
            const $editModal = $('#editKonsulModal');

            // shown/hidden → init/destroy Select2 + reset form
            $addModal.on('shown.bs.modal', function() {
                initSelect2In(this);
            });
            $addModal.on('hidden.bs.modal', function() {
                $(this).find('select.select2, select.select2-target').each(function() {
                    if ($(this).hasClass('select2-hidden-accessible')) $(this).select2('destroy');
                });
                this.querySelector('form')?.reset();
            });

            // Ketika unit tujuan diganti → muat dokter
            $addModal.on('change', 'select[name="unit_tujuan"]', function() {
                loadDokterInto($addModal, $(this).val());
            });

            // Cegah double submit di form add
            $addModal.on('submit', 'form', function(e) {
                const $form = $(this);
                if ($form.data('submitted')) {
                    e.preventDefault();
                    return;
                }
                lockSubmit($form, true);
            });

            /*** ========= EDIT MODAL ========= ***/
            $editModal.on('shown.bs.modal', function() {
                initSelect2In(this);
            });
            $editModal.on('hidden.bs.modal', function() {
                $(this).find('select.select2, select.select2-target').each(function() {
                    if ($(this).hasClass('select2-hidden-accessible')) $(this).select2('destroy');
                });
                this.querySelector('form')?.reset();
            });

            // (opsional) jika di edit modal kamu ingin reload dokter saat unit diubah dan field tidak disabled
            $editModal.on('change', 'select[name="unit_tujuan"]', function() {
                loadDokterInto($editModal, $(this).val());
            });

            // Cegah double submit di form edit
            $editModal.on('submit', 'form', function(e) {
                const $form = $(this);
                if ($form.data('submitted')) {
                    e.preventDefault();
                    return;
                }
                lockSubmit($form, true);
            });

            // Tombol Edit (delegated)
            $(document).on('click', '.btn-edit-konsultasi', function() {
                const $btn = $(this);
                const unitTujuan = $btn.attr('data-unittujuan');
                const tglKonsul = $btn.attr('data-tglkonsul');
                const jamKonsul = $btn.attr('data-jamkonsul');
                const urutKonsul = $btn.attr('data-urutkonsul');

                // loading state tombol
                const originalHtml = $btn.html();
                $btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                    );

                $.ajax({
                        type: "POST",
                        url: urlGetKonsulAjax,
                        dataType: "json",
                        data: {
                            _token: csrf,
                            kd_unit_tujuan: unitTujuan,
                            tgl_masuk_tujuan: tglKonsul,
                            jam_masuk_tujuan: jamKonsul,
                            urut_konsul: urutKonsul,
                        }
                    })
                    .done(function(res) {
                        if (res?.status !== 'success') {
                            if (typeof showToast === 'function') showToast('error', res?.message ??
                                'Gagal mengambil data.');
                            else console.error(res?.message || 'Gagal mengambil data.');
                            return;
                        }

                        const data = res.data;

                        // isi options dokter tujuan dulu
                        let optEl = '<option value="">--Pilih Dokter--</option>';
                        (data.dokter ?? []).forEach(e => {
                            optEl +=
                                `<option value="${e.dokter.kd_dokter}">${e.dokter.nama_lengkap}</option>`;
                        });
                        $editModal.find('select[name="dokter_unit_tujuan"]').html(optEl);

                        // hidden original keys
                        $editModal.find('input#old_kd_unit_tujuan, input#edit-old-kd-unit-tujuan').val(data
                            .konsultasi.kd_unit_tujuan);
                        $editModal.find('input#old_tgl_konsul, input#edit-old-tgl-konsul').val(data
                            .konsultasi.tgl_masuk_tujuan);
                        $editModal.find('input#old_jam_konsul, input#edit-old-jam-konsul').val(data
                            .konsultasi.jam_masuk_tujuan);
                        $editModal.find('input#urut_konsul, input#edit-urut-konsul').val(data.konsultasi
                            .urut_konsul);

                        // isi field (pakai scope modal supaya aman walau ID ganda)
                        $editModal.find('select#edit_dokter_pengirim, select#edit-dokter-pengirim')
                            .val(data.konsultasi.kd_dokter).trigger('change');

                        $editModal.find('input#tgl_konsul, input#edit-tgl-konsul')
                            .val(String(data.konsultasi.tgl_masuk_tujuan).split(' ')[0]);

                        $editModal.find('input#jam_konsul, input#edit-jam-konsul')
                            .val(formatTime(data.konsultasi.jam_masuk_tujuan));

                        $editModal.find('select#unit_tujuan, select#edit-unit-tujuan')
                            .val(data.konsultasi.kd_unit_tujuan).trigger('change');

                        $editModal.find('select#dokter_unit_tujuan, select#edit-dokter-unit-tujuan')
                            .val(data.konsultasi.kd_dokter_tujuan).trigger('change');

                        $editModal.find('input[name="konsulen_harap"]')
                            .prop('checked', false)
                            .filter(`[value="${data.konsultasi.kd_konsulen_diharapkan}"]`)
                            .prop('checked', true);

                        $editModal.find('textarea#catatan, textarea#edit-catatan')
                            .val(data.konsultasi.catatan);

                        $editModal.find('textarea#konsul, textarea#edit-konsul')
                            .val(data.konsultasi.konsul);

                        $editModal.modal('show');
                    })
                    .fail(function() {
                        if (typeof showToast === 'function') showToast('error', 'Internal server error');
                        else console.error('Gagal memuat data edit.');
                    })
                    .always(function() {
                        $btn.prop('disabled', false).html(originalHtml);
                    });
            });

        })(jQuery);
    </script>
@endpush
