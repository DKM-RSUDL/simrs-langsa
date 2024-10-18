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
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKonsulModal"><i
                    class="bi bi-plus"></i>Tambah</button>
        </div>

    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-sm table-hover" id="rawatDaruratKonsultasiTable">
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
                <td>03 Apr 2024 11:30</td>
                <td>Dr. Gunardi, SP.PD (Internist Pria)</td>
                <td>Mata</td>
                <td>
                    <p class="text-primary fw-bold m-0 p-0" id="konsulenHarapLabel">Konsul Sewaktu</p>
                    <p class="m-0 p-0" id="konsulDimintaLabel">Mohon pemeriksaan selanjutnya atas keluhan pasien di
                        bagian dada atas</p>
                </td>
                <td>
                    <p class="text-primary fw-bold m-0 p-0" id="konsulenStatusLabel">Dijawab Konsulen</p>
                    <p class="m-0 p-0" id="konsulenKetLabel">Saran untuk dilakukan pemeriksaan</p>
                </td>
                <td>
                    <button class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-sm">
                        <i class="bi bi-x-circle-fill text-danger"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.konsultasi.include.modal')
