{{-- resources/views/tabs/resep.blade.php --}}

<div>
    {{-- Filter Tabel: Episode, Start Date, End Date, Pencarian, dan Tombol Tambah --}}
    <div class="d-flex justify-content-start align-items-center m-3">
        <div class="row g-3 w-100">

            <!-- Select Episode Option -->
            <div class="col-md-2">
                <select class="form-select" id="selectEpisode" aria-label="Pilih...">
                    <option value="semua" selected>Semua Episode</option>
                    <option value="1">Episode Sekarang</option>
                    <option value="30">1 Bulan</option>
                    <option value="90">3 Bulan</option>
                    <option value="180">6 Bulan</option>
                    <option value="270">9 Bulan</option>
                </select>
            </div>

            <!-- Start Date -->
            <div class="col-md-2">
                <input type="date" name="start_date" id="startDate" class="form-control" placeholder="Dari Tanggal">
            </div>

            <!-- End Date -->
            <div class="col-md-2">
                <input type="date" name="end_date" id="endDate" class="form-control" placeholder="S.d Tanggal">
            </div>

            <!-- Search Bar -->
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari" aria-label="Cari"
                        aria-describedby="basic-addon1">
                </div>
            </div>

        </div>
    </div>

    {{-- Tabel E-Resep Obat & BMHP --}}
    <div class="table-responsive">
        <table class="table table-bordered" id="resepTable">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Obat</th>
                    <th>Dosis</th>
                    <th>Frek</th>
                    <th>Qty</th>
                    <th>Rute</th>
                    <th>Keterangan</th>
                    <th>Nama Dokter</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayatObat as $resep)
                    @php
                        $cara_pakai_parts = explode(',', $resep->cara_pakai);
                        $frekuensi = trim($cara_pakai_parts[0] ?? '');
                        $keterangan = trim($cara_pakai_parts[1] ?? '');

                        switch($resep->status) {
                            case 0:
                                $statusText = 'Menunggu';
                                $statusIcon = '<i class="bi bi-hourglass text-warning"></i>';
                                $statusClass = 'text-warning';
                                break;
                            case 1:
                                $statusText = 'Sedang diracik';
                                $statusIcon = '<i class="bi bi-gear-fill text-primary"></i>';
                                $statusClass = 'text-primary';
                                break;
                            case 2:
                                $statusText = 'Selesai diracik';
                                $statusIcon = '<i class="bi bi-check-circle text-success"></i>';
                                $statusClass = 'text-success';
                                break;
                            case 3:
                                $statusText = 'Sudah diambil';
                                $statusIcon = '<i class="bi bi-bag-check-fill text-info"></i>';
                                $statusClass = 'text-info';
                                break;
                            case 99:
                                $statusText = 'Resep dibatalkan';
                                $statusIcon = '<i class="bi bi-x-circle text-danger"></i>';
                                $statusClass = 'text-danger';
                                break;
                            default:
                                $statusText = 'Status tidak diketahui';
                                $statusIcon = '<i class="bi bi-question-circle text-secondary"></i>';
                                $statusClass = 'text-secondary';
                        }
                    @endphp

                    <tr>
                        <td>{{ \Carbon\Carbon::parse($resep->tgl_order)->format('d/m/Y') }}</td>
                        <td>{{ $resep->nama_obat ?? 'Tidak ada informasi' }}</td>
                        <td>{{ $resep->jumlah_takaran }} {{ Str::title($resep->satuan_takaran) }}</td>
                        <td>{{ $frekuensi }}</td>
                        <td>{{ (int)$resep->jumlah ?? 'Tidak ada informasi' }}</td>
                        <td>Rute</td>
                        <td>{{ $keterangan }}</td>
                        <td>{{ $resep->nama_dokter }}</td>
                        <td class="{{ $statusClass }}">
                            {!! $statusIcon !!} {{ $statusText }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if (isset($error))
        <div class="alert alert-warning">{{ $error }}</div>
    @elseif($riwayatObat->isEmpty())
        <div class="alert alert-info">
            Tidak ada riwayat pembelian obat untuk pasien ini. Pasien belum pernah membeli obat.
        </div>
    @endif
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.getElementById('resepTable');
            const rows = table.getElementsByTagName('tr');
            const selectEpisode = document.getElementById('selectEpisode');
            const startDate = document.getElementById('startDate');
            const endDate = document.getElementById('endDate');
            const searchInput = document.getElementById('searchInput');

            function filterTable() {
                const episodeValue = selectEpisode.value;
                const startDateValue = new Date(startDate.value);
                const endDateValue = new Date(endDate.value);
                const searchValue = searchInput.value.toLowerCase();

                for (let i = 1; i < rows.length; i++) {
                    let row = rows[i];
                    let showRow = true;

                    // Filter by date
                    let dateCell = row.cells[0].innerText;
                    let rowDate = new Date(dateCell.split('/').reverse().join('-'));

                    if (episodeValue !== 'semua') {
                        let daysAgo = new Date();
                        daysAgo.setDate(daysAgo.getDate() - parseInt(episodeValue));
                        if (rowDate < daysAgo) {
                            showRow = false;
                        }
                    }

                    if (!isNaN(startDateValue.getTime()) && rowDate < startDateValue) {
                        showRow = false;
                    }

                    if (!isNaN(endDateValue.getTime()) && rowDate > endDateValue) {
                        showRow = false;
                    }

                    // Filter by search input
                    if (searchValue !== '') {
                        let rowText = row.innerText.toLowerCase();
                        if (rowText.indexOf(searchValue) === -1) {
                            showRow = false;
                        }
                    }

                    row.style.display = showRow ? '' : 'none';
                }
            }

            selectEpisode.addEventListener('change', filterTable);
            startDate.addEventListener('change', filterTable);
            endDate.addEventListener('change', filterTable);
            searchInput.addEventListener('input', filterTable);
        });
    </script>
@endpush
