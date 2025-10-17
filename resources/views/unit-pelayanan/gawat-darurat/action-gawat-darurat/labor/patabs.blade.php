<div class="d-flex flex-column gap-2">
    <div class="d-flex justify-content-start align-items-center m-3">
        <div class="col-md-9 d-flex flex-wrap flex-md-nowrap gap-2">
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
                <button id="filterButton" class="btn btn-secondary"><i class="bi bi-funnel-fill"></i></button>
            </div>

            <!-- Search Bar -->
            <form method="GET"
                action="{{ route('labor.index', ['kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d')]) }}">

                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control" placeholder="Cari" aria-label="Cari"
                        value="{{ request('search') }}" aria-describedby="basic-addon1">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>
        <div class="col-md-3 text-end">
            <!-- Add Button -->
            <!-- Include the modal file -->
            <button class="btn btn-primary">Tambah</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-sm table-hover">
            <thead class="table-primary">
                <tr>
                    <th width="100px"># order</th>
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
                @foreach ($dataLabor as $laborPA)
                    <tr>
                        <td>{{ $laborPA->kd_order }}</td>
                        <td>-</td>
                        <td>{{ \Carbon\Carbon::parse($laborPA->tgl_order)->format('d M Y H:i') }}</td>
                        <td>-</td>
                        <td>{{ $laborPA->dokter->nama }}</td>
                        <td>{{ $laborPA->cyto == 1 ? 'Cyto' : 'Non-Cyto' }}</td>
                        <td>
                            @if ($laborPA->status == 1)
                                <i class="bi bi-check-circle-fill text-success"></i>
                                selesai
                            @else
                                <i class="bi bi-check-circle-fill text-secondary"></i>
                                Diorder
                            @endif
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary"><i class="bi bi-eye-fill"></i></a>
                            <a href="#"><i class="bi bi-x-circle-fill text-secondary m-2"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $dataLabor->withQueryString()->links() }}
    </div>
</div>

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#SelectOption').change(function() {
                // Mendapatkan nilai dari dropdown
                var periode = $(this).val();

                // Redirect dengan parameter periode
                var queryString = '?periode=' + periode;
                window.location.href =
                    "{{ route('labor.index', ['kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d')]) }}" +
                    queryString;
            });
        });


        $(document).ready(function() {
            // Event listener untuk tombol filter
            $('#filterButton').click(function(e) {
                e.preventDefault(); // Mencegah default behavior dari button

                // Mengambil nilai dari input tanggal
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();

                // Validasi apakah tanggal telah dipilih
                if (!startDate || !endDate) {
                    alert('Silakan pilih tanggal awal dan tanggal akhir terlebih dahulu.');
                    return;
                }

                // Membuat query string untuk redirect dengan parameter
                var queryString = '?start_date=' + startDate + '&end_date=' + endDate;

                // Redirect ke URL dengan query string yang terbentuk
                window.location.href =
                    "{{ route('labor.index', ['kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d')]) }}" +
                    queryString;
            });
        });
    </script>
@endpush
