<div>
    <div class="d-flex justify-content-start align-items-center m-3">
        <div class="row">
            <!-- Select PA Option -->
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
                    action="#">

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
            <!-- Include the modal file -->
            <div class="col-md-2">
                <a href="javascript:void(0)" id="btn-create-program" class="btn btn-primary">Tambah</a>
            </div>

        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-sm table-hover">
            <thead class="table-primary">
                <tr>
                    <th width="100px">No</th>
                    <th>Tanggal</th>
                    <th>Program</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>098</td>
                    <td>08 Desember 2024</td>
                    <td>Program 1</td>
                    <td>
                        <a href="javascript:void(0)" id="btn-asuhan-edit" class="mb-2 btn btn-sm btn-warning">
                            <i class="ti-pencil"></i>
                        </a>
                        <a href="javascript:void(0)" class="mb-2 btn btn-sm btn-danger btn-delete">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@include("unit-pelayanan.rehab-medis.pelayanan.layanan.program.modal-create-program")
@push('js')
    <script type="text/javascript">

    </script>
@endpush
