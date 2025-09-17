<div>
    <div class="d-flex justify-content-start align-items-center m-3">
        <div class="row">
            <!-- Select PA Option -->
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
                <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Dari Tanggal">
            </div>

            <!-- End Date -->
            <div class="col-md-2">
                <input type="date" name="end_date" id="end_date" class="form-control" placeholder="S.d Tanggal">
            </div>

            <!-- Button Filter -->
            <div class="col-md-1">
                <button id="filterButton" class="btn btn-secondary rounded-3"><i class="bi bi-funnel-fill"></i></button>
            </div>

            <!-- Search Bar -->
            <div class="col-md-3">
                <form method="GET"
                    action="#">

                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control" placeholder="Cari" aria-label="Cari"
                            value="" aria-describedby="basic-addon1">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>


            <!-- Add Button -->
            <!-- Include the modal file -->
            <div class="col-md-2">
                @if (count($layanan) < 1)
                    <a href="{{ route('rawat-jalan.layanan-rehab-medik.program.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
                @endif
            </div>

        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-sm table-hover">
            <thead class="table-primary">
                <tr align="middle">
                    <th width="100px">No</th>
                    <th>Tanggal</th>
                    <th>Program</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($programs as $item)
                    <tr>
                        <td align="middle">{{ $loop->iteration }}</td>
                        <td>{{ date('Y-m-d', strtotime($item->tgl_pelayanan)) }} {{ date('H:i', strtotime($item->jam_pelayanan)) }}</td>
                        <td>
                            <ul class="ps-5">
                                @foreach ($item->detail as $detail)
                                    <li>{{ $detail->produk->deskripsi }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @if (count($layanan) < 1)
                                <a href="{{ route('rawat-jalan.layanan-rehab-medik.program.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}" class="mb-2 btn btn-sm btn-warning">
                                    <i class="ti-pencil"></i>
                                </a>
                                <button class="mb-2 btn btn-sm btn-danger btn-delete" data-program="{{ encrypt($item->id) }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@push('js')
    <script>
        $('.btn-delete').click(function(e) {
            let $this = $(this);
            let program = $this.attr('data-program');


            Swal.fire({
                title: "Anda yakin ingin menghapus?",
                text: "Data yang dihapus tidak dapat dikembalikan kembali !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('rawat-jalan.layanan-rehab-medik.program.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "delete",
                            program: program
                        },
                        dataType: "json",
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Sedang Memproses',
                                html: 'Mohon tunggu sebentar...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: function (res) {
                            let status = res.status;
                            let msg = res.message;
                            let data = res.data;

                            if(status == 'error') {
                                Swal.fire({
                                    title: "Gagal!",
                                    text: msg,
                                    icon: "error",
                                    allowOutsideClick: false,
                                });

                                return false;
                            }

                            Swal.fire({
                                title: "Berhasil!",
                                text: "Data program berhasil dihapus !",
                                icon: "success",
                                allowOutsideClick: false,
                            });

                            location.reload();
                        },
                        error: function() {
                            Swal.fire({
                                title: "Gagal!",
                                text: "Internal Server Error",
                                icon: "error",
                                allowOutsideClick: false,
                            });
                        }
                    });
                }
            });

        });
    </script>
@endpush
