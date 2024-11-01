@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        /* .header-background {
                        background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
                    } */
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation')

            <div class="row">
                <div class="d-flex justify-content-between align-items-center m-3">

                    <div class="row">
                        <!-- Select PPA Option -->
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
                        <div class="col-md-1">
                            <a href="#" class="btn btn-secondary rounded-3"><i class="bi bi-funnel-fill"></i></a>
                        </div>

                        <!-- Search Bar -->
                        <div class="col-md-3">
                            <form method="GET" action="#">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari"
                                        aria-label="Cari" value="{{ request('search') }}" aria-describedby="basic-addon1">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                                </div>
                            </form>
                        </div>

                        <!-- Add Button -->
                        <!-- Include the modal file -->
                        <div class="col-md-2">
                            @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.radiologi.modal')
                        </div>

                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th width="100px">No order</th>
                                <th>Nama Pemeriksaan</th>
                                <th>Waktu Permintaan</th>
                                <th>Waktu Hasil</th>
                                <th>Dokter Pengirim</th>
                                <th>Cito/Non Cito</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($radList as $rad)
                                <tr>
                                    <td>{{ (int) $rad->kd_order }}</td>
                                    <td>
                                        @php
                                            $namaPemeriksaan = '';

                                            foreach ($rad->details as $dtl) {
                                                $namaPemeriksaan .= empty($namaPemeriksaan)
                                                    ? $dtl->produk->deskripsi
                                                    : ', ' . $dtl->produk->deskripsi;
                                            }
                                        @endphp

                                        {{ $namaPemeriksaan }}
                                    </td>
                                    <td>{{ date('d M Y H:i', strtotime($rad->tgl_order)) }}</td>
                                    <td></td>
                                    <td>{{ $rad->dokter->nama_lengkap . '(' . $rad->unit->nama_unit . ')' }}</td>
                                    <td align="middle">
                                        {{ $rad->cyto == 1 ? 'Cito' : 'Non Cito' }}
                                    </td>
                                    <td>
                                        @php
                                            $statusOrder = $rad->status_order;
                                            $statusLabel = '';

                                            if ($statusOrder == 0) {
                                                $statusLabel = '<span class="text-warning">Diproses</span>';
                                            }
                                            if ($statusOrder == 1) {
                                                $statusLabel = '<span class="text-secondary">Diorder</span>';
                                            }
                                            if ($statusOrder == 2) {
                                                $statusLabel = '<span class="text-success">Selesai</span>';
                                            }
                                        @endphp

                                        {!! $statusLabel !!}
                                    </td>

                                    <td>
                                        @if ($rad->status_order == 1)
                                            <button class="btn btn-sm btn-secondary btn-edit-rad"
                                                data-kode="{{ intval($rad->kd_order) }}"
                                                data-bs-target="#editRadiologiModal"><i class="ti-pencil"></i></button>
                                        @else
                                            <button class="btn btn-sm btn-primary btn-show-rad"
                                                data-kode="{{ intval($rad->kd_order) }}"
                                                data-bs-target="#showRadiologiModal"><i class="ti-eye"></i></button>
                                        @endif
                                        <button class="btn btn-sm {{ $rad->status_order == 1 ? 'btn-delete-rad' : '' }}"
                                            data-kode="{{ intval($rad->kd_order) }}"><i
                                                class="bi bi-x-circle {{ $rad->status_order == 1 ? 'text-danger' : 'text-secondary' }}"></i></button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {{-- Filter data --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#SelectOption').change(function() {
                var periode = $(this).val();
                var queryString = '?periode=' + periode;
                window.location.href = "{{ route('radiologi.index', [$dataMedis->kd_pasien, \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d')]) }}" + queryString;
            });
        });
    </script>

    <script>
        let typingTimer;
        let debounceTime = 500;

        // Edit
        $('.btn-edit-rad').click(function(e) {
            e.preventDefault()
            let $this = $(this);
            let target = $this.attr('data-bs-target');
            let kdOrder = $this.attr('data-kode');
            let $modal = $(target);
            let url =
                "{{ route('radiologi.get-rad-detail-ajax', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk]) }}";

            // Ubah teks tombol dan tambahkan spinner
            $this.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $this.prop('disabled', true);

            $.ajax({
                type: "post",
                url: url,
                data: {
                    '_token': "{{ csrf_token() }}",
                    'kd_order': kdOrder
                },
                dataType: "json",
                success: function(response) {
                    if (response.status == 'success') {
                        let orderData = response.data.order;
                        let orderDetailData = response.data.order_detail

                        // set value
                        let tglOrder = orderData.tgl_order;
                        let tglOrderObj = new Date(tglOrder);
                        const hoursOrder = tglOrderObj.getHours().toString().padStart(2, '0');
                        const minutesOrder = tglOrderObj.getMinutes().toString().padStart(2, '0');
                        let jamOrder = `${hoursOrder}:${minutesOrder}`;

                        let tglPemeriksaan = orderData.jadwal_pemeriksaan;
                        let tglPemeriksaanObj = new Date(tglPemeriksaan);
                        const hoursPemeriksaan = tglPemeriksaanObj.getHours().toString().padStart(2,
                            '0');
                        const minutesPemeriksaan = tglPemeriksaanObj.getMinutes().toString().padStart(2,
                            '0');
                        let jamPemeriksaan = `${hoursPemeriksaan}:${minutesPemeriksaan}`;

                        $modal.find('#kd_order').val(Math.floor(orderData.kd_order));
                        $modal.find('#urut_masuk').val(orderData.urut_masuk);
                        $modal.find('#kd_dokter').val(orderData.kd_dokter);
                        if (tglOrder) {
                            $modal.find('#tgl_order').val(tglOrder.split('T')[0]);
                            $modal.find('#jam_order').val(jamOrder);
                        }
                        $modal.find(`input[name="cyto"][value="${orderData.cyto}"]`).attr('checked',
                            'checked');
                        $modal.find(`input[name="puasa"][value="${orderData.puasa}"]`).attr('checked',
                            'checked');
                        if (tglPemeriksaan) {
                            $modal.find('#tgl_pemeriksaan').val(tglPemeriksaan.split('T')[0]);
                            $modal.find('#jam_pemeriksaan').val(jamPemeriksaan);
                        }
                        $modal.find('#diagnosis').val(orderData.diagnosis);

                        let listProduk = '';

                        orderDetailData.forEach(dtl => {
                            listProduk += `<li class="list-group-item">
                                                    ${dtl.produk.deskripsi}
                                                    <input type="hidden" name="kd_produk[]" value="${dtl.kd_produk}">
                                                    <span class="remove-item" style="color: red; cursor: pointer;">
                                                        <i class="bi bi-x-circle"></i>
                                                    </span>
                                                </li>`

                        });

                        $modal.find('#orderList').html(listProduk);
                        $modal.modal('show');
                    } else {
                        showToast(response.status, response.message);
                    }

                    $this.html('<i class="ti-pencil"></i>');
                    $this.prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    showToast('error', 'internal server error');
                }
            });

        })

        function dataPemeriksaanItemEdit() {
            let dataPemeriksaan = @json($produk);
            var listHtml = '';


            dataPemeriksaan.forEach(item => {
                listHtml +=
                    `<a class="dropdown-item" href="#" data-kd-produk="${item.kp_produk}">${item.deskripsi}</a>`;
            });

            $('#editRadiologiModal #dataList').html(listHtml);
            $('#editRadiologiModal #dataList').show();
        }

        $('#editRadiologiModal #searchInput').on('focus', function() {
            dataPemeriksaanItemEdit();
        });

        function searchDataPemeriksaan(keyword) {
            let dataPemeriksaan = @json($produk);

            return dataPemeriksaan.filter(function(item) {
                return item.deskripsi.toLowerCase().includes(keyword.toLowerCase());
            });
        }

        $('#editRadiologiModal #searchInput').keyup(function() {
            let $this = $(this);
            let search = $this.val();

            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {

                let dataSearch = searchDataPemeriksaan(search);
                let listHtml = '';

                dataSearch.forEach(item => {
                    listHtml +=
                        `<a class="dropdown-item" href="#" data-kd-produk="${item.kp_produk}">${item.deskripsi}</a>`;
                });

                $('#editRadiologiModal #dataList').html(listHtml);
                $('#editRadiologiModal #dataList').show();
            }, debounceTime)
        });

        $(document).on('click', '#editRadiologiModal #dataList .dropdown-item', function(e) {
            e.preventDefault();

            const selectedItemText = $(this).text();
            const kdProduk = $(this).attr('data-kd-produk');

            if (kdProduk) {
                let listItem = `<li class="list-group-item">
                                        ${selectedItemText}
                                        <input type="hidden" name="kd_produk[]" value="${kdProduk}">
                                        <span class="remove-item" style="color: red; cursor: pointer;">
                                            <i class="bi bi-x-circle"></i>
                                        </span>
                                    </li>`;

                $('#editRadiologiModal #orderList').append(listItem);

                $('#editRadiologiModal #searchInput').val('');
                $('#editRadiologiModal #dataList').hide();
            } else {
                console.error('Error: kd_produk is undefined');
            }
        });

        $(document).on('click', '#editRadiologiModal #orderList .list-group-item .remove-item', function(e) {
            e.preventDefault();
            $(this).parent().remove();
        });

        // show
        $('.btn-show-rad').click(function(e) {
            e.preventDefault()
            let $this = $(this);
            let target = $this.attr('data-bs-target');
            let kdOrder = $this.attr('data-kode');
            let $modal = $(target);
            let url =
                "{{ route('radiologi.get-rad-detail-ajax', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk]) }}";

            // Ubah teks tombol dan tambahkan spinner
            $this.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $this.prop('disabled', true);

            $.ajax({
                type: "post",
                url: url,
                data: {
                    '_token': "{{ csrf_token() }}",
                    'kd_order': kdOrder
                },
                dataType: "json",
                success: function(response) {
                    if (response.status == 'success') {
                        let orderData = response.data.order;
                        let orderDetailData = response.data.order_detail

                        // set value
                        // format jadwal order
                        let tglOrder = orderData.tgl_order;
                        let orderDatetime = new Date(tglOrder);
                        let orderOptionsDate = {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        };
                        let orderFormattedDate = orderDatetime.toLocaleDateString('id-ID',
                            orderOptionsDate);
                        let orderOptionsTime = {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        };
                        let orderFormattedTime = orderDatetime.toLocaleTimeString('id-ID',
                            orderOptionsTime);
                        let jadwalOrder = `${orderFormattedDate} ${orderFormattedTime}`;
                        // format jadwal pemeriksaan
                        let tglPemeriksaan = orderData.jadwal_pemeriksaan;
                        let pemeriksaanDatetime = new Date(tglPemeriksaan);
                        let pemeriksaanOptionsDate = {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        };
                        let pemeriksaanFormattedDate = pemeriksaanDatetime.toLocaleDateString('id-ID',
                            pemeriksaanOptionsDate);
                        let pemeriksaanOptionsTime = {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        };
                        let pemeriksaanFormattedTime = pemeriksaanDatetime.toLocaleTimeString('id-ID',
                            pemeriksaanOptionsTime);
                        let jadwalPemeriksaan =
                            `${pemeriksaanFormattedDate} ${pemeriksaanFormattedTime}`;

                        // cito format
                        let cytoLabel = (orderData.cyto == 1) ? 'Ya' : 'Tidak';
                        let puasaLabel = (orderData.puasa == 1) ? 'Ya' : 'Tidak';


                        $modal.find('#dokter').text(orderData.dokter.nama_lengkap);
                        if (tglOrder) $modal.find('#jadwal_order').text(jadwalOrder);
                        $modal.find('#cyto').text(cytoLabel);
                        $modal.find('#puasa').text(puasaLabel);
                        if (tglPemeriksaan) $modal.find('#jadwal_pemeriksaan').text(jadwalPemeriksaan);
                        $modal.find('#diagnosis').text(orderData.diagnosis);

                        let listProduk = '';

                        orderDetailData.forEach(dtl => {
                            listProduk +=
                                `<li class="list-group-item">${dtl.produk.deskripsi}</li>`
                        });

                        $modal.find('#orderList').html(listProduk);
                        $modal.modal('show');
                    } else {
                        showToast(response.status, response.message);
                    }

                    $this.html('<i class="ti-eye"></i>');
                    $this.prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    showToast('error', 'internal server error');
                }
            });

        })

        // delete
        $('.btn-delete-rad').click(function(e) {
            let $this = $(this);
            let kdOrder = $this.attr('data-kode');

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
                        url: "{{ route('radiologi.delete', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk]) }}",
                        data: {
                            '_method': 'delete',
                            '_token': "{{ csrf_token() }}",
                            'kd_order': kdOrder
                        },
                        dataType: "json",
                        success: function(res) {
                            showToast(res.status, res.message);

                            if (res.status == 'success') {
                                setTimeout(function() {
                                    location.reload();
                                }, 3000);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
