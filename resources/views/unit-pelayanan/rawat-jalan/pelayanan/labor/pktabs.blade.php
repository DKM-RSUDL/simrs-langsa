<div>
    <div class="d-flex justify-content-between align-items-center m-3">

        <div class="row">
            <!-- Select PK Option -->
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
                    action="{{ route('rawat-jalan.lab-patologi-klinik.index', ['kd_unit' => $dataMedis->kd_unit,'kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk]) }}">

                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="dokter & no order" aria-label="Cari"
                            value="{{ request('search') }}" aria-describedby="basic-addon1">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>

            <!-- Add Button -->
            <!-- Include the modal file -->
            <div class="col-md-2">
                @include('unit-pelayanan.rawat-jalan.pelayanan.labor.createpk')
            </div>

        </div>
    </div>

    <div class="table-responsive">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <table class="table table-bordered table-sm table-hover" id="rawatDaruratTable">
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
                @foreach ($dataLabor as $laborPK)
                    <tr>
                        <td>{{ (int) $laborPK->kd_order }}</td>
                        <td>
                            @foreach ($laborPK->details as $detail)
                                {{ $detail->produk->deskripsi ?? '' }},
                            @endforeach
                        </td>
                        <td>{{ \Carbon\Carbon::parse($laborPK->tgl_order)->format('d M Y H:i') }}</td>
                        <td>
                            @php
                                $labHasil = $laborPK->labHasil->sortByDesc('tgl_otoritas_det')->first();
                            @endphp
                            @if ($labHasil && $labHasil->tgl_otoritas_det)
                                {{ \Carbon\Carbon::parse($labHasil->tgl_otoritas_det)->format('d M Y H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $laborPK->dokter->nama_lengkap }}</td>
                        <td>{{ $laborPK->cyto == 1 ? 'Cyto' : 'Non-Cyto' }}</td>
                        <td>
                            @if ($laborPK->status_order == 1)
                                <i class="bi bi-check-circle-fill text-secondary"></i> Diorder
                            @elseif ($laborPK->status == 0)
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <p class="text-success">Selesai</p>
                            @endif
                        </td>

                        <td>
                            @if ($laborPK->status_order == 1)
                                <a href="#" class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#extraLargeModal{{ str_replace('.', '_', $laborPK->kd_order) }}">
                                    <i class="ti-pencil"></i>
                                </a>
                                <a href="#" class="mb-2" onclick="confirmDelete('{{ $laborPK->kd_order }}')">
                                    <i class="bi bi-x-circle text-danger"></i>
                                </a>
                            @else
                                <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#laborModal{{ str_replace('.', '_', $laborPK->kd_order) }}">
                                    <i class="ti-eye"></i>
                                </a>
                                <a href="#" class="mb-2">
                                    <i class="bi bi-x-circle text-secondary"></i>
                                </a>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $dataLabor->withQueryString()->links() }}
    </div>

</div>

<!-- Include Modals Edit and Showand delete -->
@foreach ($dataLabor as $laborPK)
    @if ($laborPK->status_order == 1)
        @include('unit-pelayanan.rawat-jalan.pelayanan.labor.editpk', ['laborPK' => $laborPK])
        @include('unit-pelayanan.rawat-jalan.pelayanan.labor.deletepk', ['laborPK' => $laborPK])
    @else
        @include('unit-pelayanan.rawat-jalan.pelayanan.labor.showpk', ['laborPK' => $laborPK])
    @endif
@endforeach

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#SelectOption').change(function() {
                var periode = $(this).val();
                var queryString = '?periode=' + periode;
                window.location.href =
                    "{{ route('rawat-jalan.lab-patologi-klinik.index', ['kd_unit' => $dataMedis->kd_unit,'kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk]) }}" +
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
                    "{{ route('rawat-jalan.lab-patologi-klinik.index', ['kd_unit' => $dataMedis->kd_unit,'kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk]) }}" +
                    queryString;
            });
        });
    </script>
@endpush
