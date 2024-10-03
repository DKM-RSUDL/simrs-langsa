<div>
    <div class="d-flex justify-content-start align-items-center m-3">
        <div class="row">
            <!-- Select PPA Option -->
            <div class="col-md-2">
                <select class="form-select" id="SelectOption" aria-label="Pilih...">
                    <option value="semua" selected>Semua Episode</option>
                    <option value="option1">Episode Sekarang</option>
                    <option value="option2">1 Bulan/option>
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
            <div class="col-md-1">
                <a href="#" class="btn btn-secondary rounded-3"><i class="bi bi-funnel-fill"></i></a>
            </div>

            <!-- Search Bar -->
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Cari" aria-label="Cari"
                        aria-describedby="basic-addon1">
                </div>
            </div>

            <!-- Add Button -->
            <!-- Include the modal file -->
            <div class="col-md-2">
                <button class="btn btn-primary">Tambah</button>
            </div>

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
                        <td>Darah Rutin</td>
                        <td>{{ \Carbon\Carbon::parse($laborPA->tgl_order)->format('d M Y H:i') }}</td>
                        <td>05 Apr 2024 11:00</td>
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
    </div>
</div>


