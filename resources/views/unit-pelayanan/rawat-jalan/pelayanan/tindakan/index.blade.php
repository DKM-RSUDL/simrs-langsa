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

            <div class="row">
                <div class="d-flex justify-content-between align-items-center m-3">

                    <div class="row">
                        <!-- Select Option -->
                        <div class="col-md-2">
                            <select class="form-select" id="SelectOption" aria-label="Pilih...">
                                <option value="semua" selected>Semua Episode</option>
                                <option value="option1">Episode Sekarang</option>
                                <option value="option2">1 Bulan</option>
                                <option value="option3">3 Bulan</option>
                                <option value="option4">6 Bulan</option>
                                <option value="option5">9 Bulan</option>
                            </select>
                        </div>

                        <!-- Start Date -->
                        <div class="col-md-2">
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                placeholder="Dari Tanggal">
                        </div>

                        <!-- End Date -->
                        <div class="col-md-2">
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                placeholder="S.d Tanggal">
                        </div>

                        <!-- Button Filter -->
                        <div class="col-md-1">
                            <button id="filterButton" class="btn btn-secondary rounded-3"><i
                                    class="bi bi-funnel-fill"></i></button>
                        </div>

                        <!-- Search Bar -->
                        <div class="col-md-3">
                            <form method="GET"
                                action="{{ route('rawat-jalan.tindakan.index', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk]) }}">

                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="dokter & Tindakan" aria-label="Cari" value="{{ request('search') }}"
                                        aria-describedby="basic-addon1">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </form>
                        </div>

                        <!-- Add Button -->
                        <!-- Include the modal file -->
                        <div class="col-md-2">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTindakanModal"
                                    type="button">
                                    <i class="ti-plus"></i> Tambah
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Tindakan</th>
                                <th>Unit Pelayanan</th>
                                <th>PPA</th>
                                <th>Keterangan</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tindakan as $tdk)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($tdk->tgl_tindakan)->format('d M Y') }}
                                        {{ \Carbon\Carbon::parse($tdk->jam_tindakan)->format('H:i') }}</td>
                                    <td>
                                        <span class="text-primary fw-bold text-decoration-underline">
                                            {{ $tdk->produk->deskripsi }}
                                        </span>
                                    </td>
                                    <td>{{ $tdk->unit->nama_unit }} / {{ $tdk->produk->klas->klasifikasi }}</td>
                                    <td>{{ $tdk->ppa->nama_lengkap }}</td>
                                    <td>{{ $tdk->keterangan }}</td>
                                    <td>
                                        <img src="{{ asset("storage/$tdk->gambar") }}" alt="" width="50">
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-success btn-show-tindakan"
                                            data-bs-target="#showTindakanModal" data-produk="{{ $tdk->kd_produk }}"
                                            data-urut="{{ $tdk->urut_list }}"><i class="bi bi-eye"></i></button>
                                        <button class="btn btn-sm btn-warning btn-edit-tindakan"
                                            data-bs-target="#editTindakanModal" data-produk="{{ $tdk->kd_produk }}"
                                            data-urut="{{ $tdk->urut_list }}"><i class="bi bi-pencil-square"></i></button>
                                        <button class="btn btn-sm btn-delete-tindakan" data-produk="{{ $tdk->kd_produk }}"
                                            data-urut="{{ $tdk->urut_list }}"><i
                                                class="bi bi-x-circle-fill text-danger"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @include('unit-pelayanan.rawat-jalan.pelayanan.tindakan.modal')
    </div>
@endsection

@push('js')
    {{-- Filter data to anas --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#SelectOption').change(function() {
                var periode = $(this).val();
                var queryString = '?periode=' + periode;
                window.location.href =
                    "{{ route('rawat-jalan.tindakan.index', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk]) }}" +
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
                    "{{ route('rawat-jalan.tindakan.index', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk]) }}" +
                    queryString;
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            initSelect2();
            editInitSelect2();
        });

        // Reinisialisasi Select2 ketika modal dibuka
        $('#addTindakanModal').on('shown.bs.modal', function() {
            // Destroy existing Select2 instance before reinitializing
            initSelect2();
        });

        function initSelect2() {
            $('#addTindakanModal select').select2({
                dropdownParent: $('#addTindakanModal'),
                width: '100%'
            });
        }


        // Foto Upload
        $('#addTindakanModal #gambarTindakanLabel').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#addTindakanModal #gambar_tindakan').trigger('click');
        });

        $('#addTindakanModal #gambar_tindakan').on('change', function(e) {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    if (e.target && e.target.result) {
                        $('#addTindakanModal #gambarTindakanLabel .img-tindakan-wrap').html(
                            `<img src="${e.target.result}" width="70">`);
                    } else {
                        showToast('error', 'Terjadi kesalahan server saat memilih file gambar!');
                    }
                }
                reader.readAsDataURL(this.files[0]);
            }
        });


        // Add Form
        $('#addTindakanForm').submit(function(e) {
            let $this = $(this);
            let gambarVal = $this.find('#gambar_tindakan').val();

            if (gambarVal == '') {
                showToast('error', 'Gambar tindakan harus dipilih!');
                return false;
            }
        });

        // Tindakan di pilih / diubah
        $('#addTindakanModal #tindakan').on('select2:select', function(e) {
            var $selectedOption = $(e.currentTarget).find("option:selected");
            var tarif = $selectedOption.data('tarif');
            var tglBerlaku = $selectedOption.data('tgl');
            $('#addTindakanModal #tarif_tindakan').val(parseInt(tarif));
            $('#addTindakanModal #tgl_berlaku').val(tglBerlaku);
        });


        // Edit
        function formatTime(dateString) {
            const date = new Date(dateString);
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        $('.btn-edit-tindakan').click(function(e) {
            let $this = $(this);
            let kdProduk = $this.attr('data-produk');
            let urut = $this.attr('data-urut');
            let target = $this.attr('data-bs-target');
            let $modal = $(target);

            $.ajax({
                type: "post",
                url: "{{ route('rawat-jalan.tindakan.get-tindakan-ajax', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "kd_produk": kdProduk,
                    "urut_list": urut,
                    "no_transaksi": "{{ $dataMedis->no_transaksi }}"
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

                        // set value
                        $modal.find('#old_kd_produk').val(data.kd_produk);
                        $modal.find('#urut_list').val(data.urut_list);
                        $modal.find('#tarif_tindakan').val(parseInt(data.harga));
                        $modal.find('#tgl_berlaku').val(data.tgl_berlaku);
                        $modal.find('#tgl_tindakan').val(data.tgl_tindakan.split(' ')[0]);
                        $modal.find('#jam_tindakan').val(formatTime(data.jam_tindakan));
                        $modal.find('#laporan').val(data.laporan_hasil);
                        $modal.find('#kesimpulan').val(data.kesimpulan);
                        $modal.find('.img-tindakan-wrap img').attr('src', "{{ url('/') }}/" +
                            `storage/${data.gambar}`);
                        $modal.find('#tindakan').val(data.kd_produk).trigger('change');
                        $modal.find('#ppa').val(data.kd_dokter).trigger('change');

                        $modal.modal('show');
                    } else {
                        showToast(res.status, res.message);
                    }
                },
                error: function(xhr, status, error) {
                    showToast('error', 'Internal server error');
                }
            });

        });

        // Reinisialisasi Select2 ketika modal dibuka
        $('#editTindakanModal').on('shown.bs.modal', function() {
            // Destroy existing Select2 instance before reinitializing
            editInitSelect2();
        });

        function editInitSelect2() {
            $('#editTindakanModal select').select2({
                dropdownParent: $('#editTindakanModal'),
                width: '100%'
            });
        }

        // Foto Upload
        $('#editTindakanModal #gambarTindakanLabel').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#editTindakanModal #gambar_tindakan').trigger('click');
        });

        $('#editTindakanModal #gambar_tindakan').on('change', function(e) {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    if (e.target && e.target.result) {
                        $('#editTindakanModal #gambarTindakanLabel .img-tindakan-wrap').html(
                            `<img src="${e.target.result}" width="70">`);
                    } else {
                        showToast('error', 'Terjadi kesalahan server saat memilih file gambar!');
                    }
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Tindakan di pilih / diubah
        $('#editTindakanModal #tindakan').on('select2:select', function(e) {
            var $selectedOption = $(e.currentTarget).find("option:selected");
            var tarif = $selectedOption.data('tarif');
            var tglBerlaku = $selectedOption.data('tgl');

            $('#editTindakanModal #tarif_tindakan').val(parseInt(tarif));
            $('#editTindakanModal #tgl_berlaku').val(tglBerlaku);
        });


        // Show
        $('.btn-show-tindakan').click(function(e) {
            let $this = $(this);
            let kdProduk = $this.attr('data-produk');
            let urut = $this.attr('data-urut');
            let target = $this.attr('data-bs-target');
            let $modal = $(target);

            $.ajax({
                type: "post",
                url: "{{ route('rawat-jalan.tindakan.get-tindakan-ajax', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "kd_produk": kdProduk,
                    "urut_list": urut,
                    "no_transaksi": "{{ $dataMedis->no_transaksi }}"
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
                    $this.html('<i class="bi bi-eye"></i>');
                    $this.prop('disabled', false);
                },
                success: function(res) {

                    if (res.status == 'success') {
                        let data = res.data;
                        console.log(data);

                        // set value
                        // format jadwal tindakan
                        let tglTindakan = data.tgl_tindakan;
                        let tglTindakanDateTime = new Date(tglTindakan);
                        let tindakanOptionDate = {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        };
                        let tglTindakanFormatted = tglTindakanDateTime.toLocaleDateString('id-ID',
                            tindakanOptionDate);

                        // format jadwal pemeriksaan
                        let jamTindakan = data.jam_tindakan;
                        let jamTindakanDateTime = new Date(jamTindakan);
                        let tindakanOptionTime = {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        };
                        let jamTindakanFormatted = jamTindakanDateTime.toLocaleTimeString('id-ID',
                            tindakanOptionTime);

                        $modal.find('#tindakan').text(data.produk.deskripsi);
                        $modal.find('#ppa').text(data.ppa.nama_lengkap);
                        $modal.find('#laporan').text(data.laporan_hasil);
                        $modal.find('#kesimpulan').text(data.kesimpulan);
                        $modal.find('#gambar_tindakan').attr('src',
                            `{{ url('/') }}/storage/${data.gambar}`);
                        $modal.find('#waktu_tindakan').text(
                            `${tglTindakanFormatted} ${jamTindakanFormatted}`);

                        $modal.modal('show');
                    } else {
                        showToast(res.status, res.message);
                    }
                },
                error: function(xhr, status, error) {
                    showToast('error', 'Internal server error');
                }
            });

        });


        // delete
        $('.btn-delete-tindakan').click(function(e) {
            let $this = $(this);
            let kdProduk = $this.attr('data-produk');
            let urut = $this.attr('data-urut');

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
                        url: "{{ route('rawat-jalan.tindakan.delete', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                        data: {
                            '_method': 'delete',
                            '_token': "{{ csrf_token() }}",
                            "kd_produk": kdProduk,
                            "urut_list": urut,
                            "no_transaksi": "{{ $dataMedis->no_transaksi }}"
                        },
                        dataType: "json",
                        beforeSend: function() {
                            // Ubah teks tombol dan tambahkan spinner
                            $this.html(
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                            );
                            $this.prop('disabled', true);
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
        });
    </script>
@endpush
