<div class="d-flex flex-column gap-2">
    <div class="row">
        <div class="col-10 d-flex flex-md-row flex-wrap flex-md-nowrap gap-2">
            <!-- Select PA Option -->
            <div>
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
            <div>
                <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Dari Tanggal">
            </div>

            <!-- End Date -->
            <div>
                <input type="date" name="end_date" id="end_date" class="form-control" placeholder="S.d Tanggal">
            </div>

            <!-- Button Filter -->
            <div>
                <button id="filterButton" class="btn btn-secondary rounded-3"><i class="bi bi-funnel-fill"></i></button>
            </div>

            <!-- Search Bar -->
            <div>
                <form method="GET" action="#">

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
        </div>
        <!-- Add Button -->
        <div class="col-md-2 text-end">
            <a href="{{ route('rehab-medis.pelayanan.terapi.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-sm table-hover">
            <thead class="table-primary">
                <tr align="middle">
                    <th width="100px">No</th>
                    <th>Tanggal</th>
                    <th>Dokter</th>
                    <th>Petugas</th>
                    <th min-width="50px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($layanan as $item)
                    <tr>
                        <td align="middle">{{ $loop->iteration }}</td>
                        <td>{{ date('Y-m-d', strtotime($item->tgl_pelayanan)) }}
                            {{ date('H:i', strtotime($item->jam_pelayanan)) }}</td>
                        <td>{{ str()->title($item->dokter->nama_lengkap) }}</td>
                        <td>{{ str()->title($item->userCreate->name) }}</td>
                        <td min-width="50px">
                            <x-table-action>
                                <a href="{{ route('rehab-medis.pelayanan.terapi.print', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                    class="mb-2 btn btn-sm btn-success">
                                    <i class="ti-printer"></i>
                                </a>
                                <a href="{{ route('rehab-medis.pelayanan.terapi.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                    class="mb-2 btn btn-sm btn-info">
                                    <i class="ti-eye"></i>
                                </a>
                                <a href="{{ route('rehab-medis.pelayanan.terapi.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                    class="mb-2 btn btn-sm btn-warning">
                                    <i class="ti-pencil"></i>
                                </a>
                                <form
                                    action="{{ route('rehab-medis.pelayanan.terapi.destroy', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="id" value="{{ encrypt($item->id) }}">

                                    <button type="submit" class="btn btn-sm btn-danger" data-confirm
                                        data-confirm-title="Anda yakin?"
                                        data-confirm-text="Data yang dihapus tidak dapat dikembalikan"
                                        title="Hapus operasi" aria-label="Hapus operasi">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </x-table-action>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('js')
    <script src="{{ asset('js/helpers/confirm.js') }}"></script>
@endpush
