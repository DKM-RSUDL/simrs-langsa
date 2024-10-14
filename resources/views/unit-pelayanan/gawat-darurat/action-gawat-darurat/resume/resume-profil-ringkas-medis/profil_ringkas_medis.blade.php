<div>
    <div class="d-flex justify-content-between m-3">
        <div class="row">
            <!-- Select PPA Option -->
            <div class="col-md-2">
                <select class="form-select" id="SelectOption" aria-label="Pilih...">
                    <option value="semua" selected>Semua PPA</option>
                    <option value="option1">PPA Sekarang</option>
                    <option value="option2">1 PPA</option>
                    <option value="option3">3 PPA</option>
                    <option value="option4">6 PPA</option>
                    <option value="option5">9 PPA</option>
                </select>
            </div>

            <!-- Select Episode Option -->
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

        </div>
    </div>
</div>
