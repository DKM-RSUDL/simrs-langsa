<div>
    <div class="d-flex justify-content-start align-items-center m-3">
        <div class="row g-3 w-100">
            <div class="col-md-2">
                <input type="date" name="start_date" id="startDate" class="form-control" placeholder="Dari Tanggal">
            </div>
            <div class="col-md-2">
                <input type="date" name="end_date" id="endDate" class="form-control" placeholder="S.d Tanggal">
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari" aria-label="Cari"
                        aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahRekonsiliasi" type="button">
                    <i class="ti-plus"></i> Tambah
                </button>
                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.farmasi.modalrekonsiliasi')
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="resepTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Dosis</th>
                    <th>Frek</th>
                    <th>Keterangan</th>
                    <th>Dosis</th>
                    <th>Perubahan Aturan Pakai</th>
                    <th>Dibawa Pasien</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data</td>
                </tr>
            </tbody>
        </table>
    </div>    
</div>

