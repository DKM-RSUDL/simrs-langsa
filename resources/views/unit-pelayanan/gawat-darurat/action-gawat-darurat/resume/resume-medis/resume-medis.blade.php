<div>
    <div class="d-flex justify-content-between m-3">
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
            <div class="col-md-2">
                <a href="#" class="btn btn-secondary rounded-3"><i class="bi bi-funnel-fill"></i></a>
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

    <table class="table table-bordered table-sm table-hover">
        <thead class="table-primary">
            <tr>
                <th>Jenis Pelayanan</th>
                <th>Dokter (DPJP)</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Keluar</th>
                <th>LOS</th>
                <th>Kinik/Ruang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Rawat Jalan</td>
                <td>dr. Gunardi, Sp.PD</td>
                <td>03 Apr 2024</td>
                <td>03 Apr 2024</td>
                <td>1 Hari</td>
                <td>Klinik Internis</td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-sm btn-success mb-2" id="btn-validasi-resume">Validasi</a>
                </td>
            </tr>
            <tr>
                <td>Rawat Inap</td>
                <td>dr. Helmiza Fahry, Sp.OT</td>
                <td>01 Apr 2024</td>
                <td>03 Apr 2024</td>
                <td>3 Hari</td>
                <td>Ruang Kelas Utama B</td>
                <td>
                    <a href="#" class="btn btn-sm btn-info">Lihat</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-create')
