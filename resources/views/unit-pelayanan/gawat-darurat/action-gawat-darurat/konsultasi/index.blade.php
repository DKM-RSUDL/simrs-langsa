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

            <x-content-card>
                {{-- TAB 1. buatlah list disini --}}
                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.konsultasi.include.konsultasi')
            </x-content-card>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#SelectOption').change(function() {
                var periode = $(this).val();
                var queryString = '?periode=' + periode;
                window.location.href =
                    "{{ route('konsultasi.index', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" +
                    queryString;
            });

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
                    "{{ route('konsultasi.index', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" +
                    queryString;
            });
        });

        function initSelect2() {
            $('#addKonsulModal .select2').select2({
                dropdownParent: $('#addKonsulModal'),
                width: '100%'
            });
        }

        function initSelect2Edit() {
            $('#editKonsulModal .select2').select2({
                dropdownParent: $('#editKonsulModal'),
                width: '100%'
            });
        }

        // Reinisialisasi Select2 ketika modal dibuka
        $('#addKonsulModal').on('shown.bs.modal', function() {
            let $this = $(this);

            @cannot('is-admin')
                @cannot('is-perawat')
                    @cannot('is-bidan')
                        $this.find('#dokter_pengirim').removeClass('select2');
                        $this.find('#dokter_pengirim').removeClass('select2-hidden-accessible');
                        $this.find('#dokter_pengirim').mousedown(function(e) {
                            e.preventDefault();
                        });
                    @endcannot
                @endcannot
            @endcannot

            // Destroy existing Select2 instance before reinitializing
            initSelect2();
        });

        $('#addKonsulModal form').submit(function(e) {
            let $this = $(this);
            let btnSubmit = $this.find('button[type="submit"]');

            $(btnSubmit).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $(btnSubmit).prop('disabled', true);

        });

        // mencegah menekan enter agar tidak mengirim data form, kecuali pada textarea
        $('#addKonsulModal form').keypress(function(e) {
            if (e.key === "Enter" && !$(e.target).is('trix-editor')) {
                e.preventDefault();
            }
        });


        // edit
        function formatTime(dateString) {
            const date = new Date(dateString);
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        $('#editKonsulModal').on('shown.bs.modal', function() {
            let $this = $(this);


            @cannot('is-admin')
                @cannot('is-perawat')
                    @cannot('is-bidan')
                        $this.find('#dokter_pengirim').removeClass('select2');
                        $this.find('#dokter_pengirim').removeClass('select2-hidden-accessible');
                        $this.find('#dokter_pengirim').mousedown(function(e) {
                            e.preventDefault();
                        });
                    @endcannot
                @endcannot
            @endcannot

            // Destroy existing Select2 instance before reinitializing
            initSelect2Edit();
        });

        $('.btn-edit-konsultasi').click(function(e) {
            let $this = $(this);
            let $modal = $($this.attr('data-bs-target'));
            let dataKonsul = $this.attr('data-konsul');

            $.ajax({
                type: "post",
                url: "{{ route('konsultasi.get-konsul-ajax', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'data_konsul': dataKonsul
                },
                dataType: "json",
                beforeSend: function() {
                    // Ubah teks tombol dan tambahkan spinner
                    $this.html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                    );
                    $this.prop('disabled', true); // Nonaktifkan tombol selama proses berlangsung
                },
                complete: function() {
                    // Ubah teks tombol jadi icon search dan disable nonaktif
                    $this.html('<i class="bi bi-pencil-square"></i>');
                    $this.prop('disabled', false);
                },
                success: function(res) {

                    if (res.status == 'success') {
                        let data = res.data;
                        let konsultasi = data.konsultasi;

                        $modal.find('#id_konsul').val(konsultasi.id);
                        $modal.find('#subjective').val(konsultasi.subjective || '');
                        $modal.find('#background').val(konsultasi.background || '');
                        $modal.find('#assesment').val(konsultasi.assesment || '');
                        $modal.find('#recomendation').val(konsultasi.recomendation || '');
                        $modal.find('#dokter_pengirim').val(konsultasi.kd_dokter).trigger('change');
                        $modal.find('#tgl_konsul').val(konsultasi.tgl_konsul);
                        $modal.find('#jam_konsul').val(konsultasi.jam_konsul ? konsultasi.jam_konsul
                            .split('.')[0] : '');
                        $modal.find('#dokter_tujuan').val(konsultasi.kd_dokter_tujuan).trigger(
                            'change');
                        $modal.find('#konsultasi').val(konsultasi.konsultasi || '');

                        // Dapatkan element trix-editor
                        var trixEditor = $('trix-editor[input="instruksi-edit"]')[0];

                        // Set content menggunakan Trix API
                        if (trixEditor && trixEditor.editor) {
                            trixEditor.editor.loadHTML(konsultasi.instruksi || '');
                        }

                        $modal.modal('show');
                    } else {
                        showToast('error', res.message);
                    }

                },
                error: function(xhr, status, error) {
                    showToast('error', 'Internal server error');
                }
            });


        })

        $('#editKonsulModal form').submit(function(e) {
            let $this = $(this);
            let btnSubmit = $this.find('button[type="submit"]');

            $(btnSubmit).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $(btnSubmit).prop('disabled', true);

        });

        // mencegah menekan enter agar tidak mengirim data form
        $('#editKonsulModal form').keypress(function(e) {
            if (e.key === "Enter" && !$(e.target).is('trix-editor')) {
                e.preventDefault();
            }
        });


        // delete
        $('.btn-delete-konsultasi').click(function(e) {
            let $this = $(this);
            let dataKonsul = $this.attr('data-konsul');

            Swal.fire({
                title: "Apakah anda yakin ingin menghapus?",
                text: "Anda tidak akan dapat mengembalikannya!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('konsultasi.delete', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                        data: {
                            '_method': 'delete',
                            '_token': "{{ csrf_token() }}",
                            'data_konsul': dataKonsul
                        },
                        dataType: "json",
                        beforeSend: function() {
                            // Ubah teks tombol dan tambahkan spinner
                            $this.html(
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                            );
                            $this.prop('disabled', true);

                            // Show loading alert
                            Swal.fire({
                                title: 'Sedang Memproses',
                                html: 'Mohon tunggu sebentar...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        complete: function() {
                            // Ubah teks tombol jadi icon search dan disable nonaktif
                            $this.html('<i class="bi bi-x-circle-fill text-danger"></i>');
                            $this.prop('disabled', false);
                        },
                        success: function(res) {
                            showToast(res.status, res.message);

                            if (res.status == 'success') {
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            }
                        }
                    });
                }
            });


        })
    </script>
@endpush
