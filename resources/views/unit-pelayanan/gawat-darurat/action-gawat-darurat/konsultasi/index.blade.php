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
            @include('components.navigation')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold" id="resep-tab" data-bs-toggle="tab"
                                    data-bs-target="#resep" type="button" role="tab" aria-controls="resep"
                                    aria-selected="true">
                                    Konsultasi/Rujuk Inten
                                </button>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="resep" role="tabpanel"
                                aria-labelledby="resep-tab">
                                {{-- TAB 1. buatlah list disini --}}
                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.konsultasi.include.konsultasi')
                            </div>
                            <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                                {{-- TAB 2. buatlah list disini --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            initSelect2();
        });

        // Reinisialisasi Select2 ketika modal dibuka
        $('#addKonsulModal').on('shown.bs.modal', function() {
            // Destroy existing Select2 instance before reinitializing
            initSelect2();
        });

        function initSelect2() {
            $('#addKonsulModal select').select2({
                dropdownParent: $('#addKonsulModal'),
                width: '100%'
            });
        }

        // unit di pilih / diubah
        $('#addKonsulModal #unit_tujuan').on('select2:select', function(e) {
            let $selectedOption = $(e.currentTarget).find("option:selected");
            let optVal = $selectedOption.val();

            $.ajax({
                type: "post",
                url: "{{ route('konsultasi.get-dokter-unit', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk]) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "kd_unit": optVal
                },
                dataType: "json",
                beforeSend: function() {
                    $('#addKonsulModal #dokter_unit_tujuan').prop('disabled', true);
                },
                complete: function() {
                    $('#addKonsulModal #dokter_unit_tujuan').prop('disabled', false);
                },
                success: function(res) {

                    if (res.status == 'success') {
                        let data = res.data;
                        let optHtml = '<option value="">--Pilih Dokter--</option>';

                        data.forEach(e => {
                            optHtml +=
                                `<option value="${e.dokter.kd_dokter}">${e.dokter.nama_lengkap}</option>`;
                        });

                        $('#addKonsulModal #dokter_unit_tujuan').html(optHtml);
                    } else {
                        showToast('error', 'Internet server error');
                    }

                },
                error: function(xhr, status, error) {
                    showToast('error', 'Internal server error');
                }
            });

        });
    </script>
@endpush
