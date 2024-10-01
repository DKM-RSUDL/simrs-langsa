<div>
    <div class="d-flex justify-content-between align-items-center m-3">

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
                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.labor.modal')
            </div>

        </div>
    </div>

    <table class="table table-bordered">
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
            <tr>
                <td>000973</td>
                <td>KGDS, Fungsi Hati, Fungsi Ginjal, Darah Rutin</td>
                <td>03 Apr 2024 11:30</td>
                <td>-</td>
                <td>dr. Gunardi, Sp.PD (Klinik Internis Pria)</td>
                <td>Cito</td>
                <td>
                    <span class="btn btn-sm btn-outline-secondary rounded-circle"><i class="bi bi-check"></i></span>
                    <p>Diorder</p>
                </td>
                <td >
                    <a href="#" class="btn btn-sm btn-secondary"><i class="bi bi-pencil"></i></a>
                    <a href="#"><i class="bi bi-x-circle-fill text-danger m-2"></i></a>
                </td>
            </tr>
            <tr>
                <td>002273</td>
                <td>KGDS, Darah Rutin</td>
                <td>01 Apr 2024 12:30</td>
                <td>01 Apr 2024 15:00</td>
                <td>dr. Nuansa Chalid (Gawat Darurat)</td>
                <td>Non Cito</td>
                <td>
                    <span class="btn btn-sm btn-success rounded-circle"><i class="bi bi-check"></i></span>
                    Selesai
                </td>
                <td>
                    <a href="#" class="btn btn-sm btn-primary"><i class="bi bi-eye-fill"></i></a>
                    <a href="#"><i class="bi bi-x-circle-fill text-secondary m-2"></i></a>
                </td>
            </tr>
            <tr>
                <td>000573</td>
                <td>Darah Rutin</td>
                <td>03 Mar 2024 14:00</td>
                <td>03 Mar 2024 19:00</td>
                <td>dr. Gunardi, Sp.PD (Rawat Inap KUB)</td>
                <td>Non Cito</td>
                <td>
                    <span class="btn btn-sm btn-success rounded-circle"><i class="bi bi-check"></i></span>
                    Selesai
                </td>
                <td>
                    <a href="#" class="btn btn-sm btn-primary"><i class="bi bi-eye-fill"></i></a>
                    <a href="#"><i class="bi bi-x-circle-fill text-secondary m-2"></i></a>
                </td>
            </tr>
        </tbody>
    </table>

</div>
