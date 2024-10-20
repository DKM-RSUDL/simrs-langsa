<div class="d-flex justify-content-start align-items-center m-3">
    <div class="row g-3 w-100">
        <!-- Select PPA Option -->
        <div class="col-md-2">
            <select class="form-select" id="SelectOption" aria-label="Pilih...">
                <option value="semua" selected>Semua PPA</option>
                <option value="option1">Dokter Spesialis</option>
                <option value="option2">Dokter Umum</option>
                <option value="option3">Perawat/bidan</option>
                <option value="option4">Nutrisionis</option>
                <option value="option5">Apoteker</option>
                <option value="option6">Fisioterapis</option>
            </select>
        </div>

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
        <div class="col-md-2">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control" placeholder="Cari" aria-label="Cari"
                    aria-describedby="basic-addon1">
            </div>
        </div>

        <!-- Button "Tambah" di sebelah kanan -->
        <div class="col-md-2 d-grid gap-2">
            <button class="btn mb-2 btn-primary" data-bs-toggle="modal" data-bs-target="#detailPasienModal"
                type="button">
                <i class="ti-plus"></i> Tambah
            </button>
        </div>
    </div>
</div>

<ul class="list-group">
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <div class="m-2">
                <span class="fw-bold text-primary">29</span> <br>
                <span class="fw-bold">Mar-24</span> <br>
                <span class="fw">08:00</span>
            </div>
            <img src="{{ asset('assets/images/avatar1.png') }}" class="rounded-circle me-3" alt="Foto Pasien"
                width="70" height="70">
            <div>
                <span class="text-primary fw-bold">Asesmen Awal Keperawatan-Pasien
                    Umum/Dewasa</span> <br>
                By : <span class="fw-bold">Ns. Aleyndra, S.Kep</span> - Perawat Klinik
                Internis
            </div>
        </div>
        <div>
            <button class="btn btn-success">Lihat</button>
            <button class="btn btn-secondary">Edit</button>
        </div>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <div class="m-2">
                <span class="fw-bold text-primary">29</span> <br>
                <span class="fw-bold">Mar-24</span> <br>
                <span class="fw">08:00</span>
            </div>
            <img src="{{ asset('assets/images/avatar1.png') }}" class="rounded-circle me-3" alt="Foto Pasien"
                width="70" height="70">
            <div>
                <span class="text-primary fw-bold">Asesmen Awal Keperawatan-Pasien
                    Umum/Dewasa</span> <br>
                By : <span class="fw-bold">Ns. Aleyndra, S.Kep</span> - Perawat Klinik
                Internis
            </div>
        </div>
        <div>
            <button class="btn btn-success">Lihat</button>
            <button class="btn btn-secondary">Edit</button>
        </div>
    </li>
</ul>
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.modalasesmen')
