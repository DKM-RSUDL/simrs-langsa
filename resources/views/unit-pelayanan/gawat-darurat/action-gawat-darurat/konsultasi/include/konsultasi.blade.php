<div class="d-flex justify-content-between align-items-center m-3">

    <div class="row">
        <!-- Select Option -->
        <div class="col-md-2">
            <select class="form-select" id="SelectOption" aria-label="Pilih...">
                <option value="semua" selected>Semua PPA</option>
                <option value="option1">Semua PPA</option>
                <option value="option2">Dokter Spesialis</option>
                <option value="option3">Dokter Umum</option>
                <option value="option4">Perawat/Bidan</option>
                <option value="option5">Nutrisionis</option>
                <option value="option6">Apoteker</option>
                <option value="option7">Fisioterapis</option>
            </select>
        </div>

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
        <div class="col-md-1">
            <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Dari Tanggal">
        </div>

        <!-- End Date -->
        <div class="col-md-1">
            <input type="date" name="end_date" id="end_date" class="form-control" placeholder="S.d Tanggal">
        </div>

        <!-- Button Filter -->
        <div class="col-md-1">
            <button id="filterButton" class="btn btn-secondary rounded-3"><i class="bi bi-funnel-fill"></i></button>
        </div>

        <!-- Search Bar -->
        <div class="col-md-3">
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

        <!-- Add Button -->
        <div class="col-md-2">
            <a href="javascript:void(0)" class="btn btn-primary" id="btn-created"><i class="bi bi-plus"></i>Tambah</a>
        </div>

    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-sm table-hover" id="rawatDaruratTable">
        <thead class="table-primary">
            <tr>
                <th>Tanggal</th>
                <th>Dari PPA</th>
                <th>Konsulen</th>
                <th>Konsul yang diminta</th>
                <th>Status Konsul</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>03 Apri 2024 <br> 11:30</td>
                <td>Dr. Gunardi, SP.PD <br> klinik: Internis</td>
                <td>klinik: Bedah Thorax</td>
                <td>
                    <Strong class="fw-bold">Konsul Sewaktu</Strong>
                    Mohon Pemeriksaan selanjutnya atas keluhan pasien di bagian dada atas
                </td>
                <td>
                    <strong class="fw-bold">Dijawab Konsulen</strong>
                    (dr.Shira..) Saran untuk dilakukan pemeriksaan
                </td>
                <td>
                    <a href="#" class="btn btn-sm btn-secondary">Edit</a>
                    <i class="bi bi-x-circle text-secondary"></i>
                </td>
            </tr>
            <tr>
                <td>01 Apri 2024 <br> 11:30</td>
                <td>Dr. Gunardi, SP.PD <br> klinik: Internis</td>
                <td>klinik: Bedah Thorax</td>
                <td>
                    <Strong class="fw-bold">Konsul Sewaktu</Strong>
                    Mohon Pemeriksaan selanjutnya atas keluhan pasien di bagian dada atas
                </td>
                <td>
                    <strong class="fw-bold">Dikirim</strong>

                </td>
                <td>
                    <a href="#" class="btn btn-sm btn-success">Edit</a>
                    <i class="bi bi-x-circle text-danger"></i>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.konsultasi.include.modal-created')
