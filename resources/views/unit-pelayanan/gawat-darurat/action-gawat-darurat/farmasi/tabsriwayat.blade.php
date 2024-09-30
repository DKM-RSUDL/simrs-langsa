{{-- resources/views/tabs/resep.blade.php --}}

<div>
    {{-- Filter Tabel: Episode, Start Date, End Date, Pencarian, dan Tombol Tambah --}}
    <div class="d-flex justify-content-start align-items-center m-3">
        <div class="row g-3 w-100">

            <!-- Select Episode Option -->
            <div class="col-md-2">
                <select class="form-select" id="SelectEpisode" aria-label="Pilih...">
                    <option value="semua" selected>Semua Episode</option>
                    <option value="Episode1">Episode Sekarang</option>
                    <option value="Episode2">1 Bulan</option>
                    <option value="Episode3">3 Bulan</option>
                    <option value="Episode4">6 Bulan</option>
                    <option value="Episode5">9 Bulan</option>
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

            <!-- Search Bar -->
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Cari" aria-label="Cari"
                        aria-describedby="basic-addon1">
                </div>
            </div>

        </div>
    </div>

    {{-- Tabel E-Resep Obat & BMHP --}}
    @if ($riwayatObat->isEmpty())
        <p>Tidak ada riwayat pemberian obat.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode Pasien</th>
                    <th>No Resep</th>
                    <th>Dokter</th>
                    <th>Jumlah Item</th>
                    <th>Resep</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayatObat as $obat)
                    <tr>
                         <td>{{ $obat->KD_PASIENAPT }}</td>
                        <td>{{ $obat->NO_RESEP }}</td>
                        <td>{{ $obat->DOKTER }}</td>
                        <td>{{ $obat->JML_ITEM }}</td>
                        <td>{{ $obat->RESEP }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
@endif
