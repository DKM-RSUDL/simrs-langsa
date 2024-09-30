<!-- Button untuk membuka modal kedua -->
<button type="button" class="btn btn-sm" id="openVerticalCenterModal"><i class="bi bi-plus-square"></i> Tambah</button>

<div class="modal fade" id="verticalCenter" tabindex="-1" aria-labelledby="verticalCenterLabel" aria-hidden="true"
    style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="verticalCenterLabel">Input Diagnosis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <h6 class="fw-bold">
                        Tambah Diagnosis
                    </h6>
                    <p class="text-muted">
                        (Isi diagnosis pada kolom dibawah dan Tekan Enter untuk menambah ke daftar diagnosis. Satu baris
                        untuk satu diagnosis )
                    </p>
                    <div class="dropdown">
                        <input type="text" class="form-control dropdown-toggle" id="searchInput" placeholder="Cari data..." aria-expanded="false" autocomplete="off">
                        <ul class="dropdown-menu" id="dataList" aria-labelledby="searchInput">
                            <!-- Daftar data -->
                            <li><a class="dropdown-item" href="#">Deman</a></li>
                            <li><a class="dropdown-item" href="#">Flu</a></li>
                            <li><a class="dropdown-item" href="#">Batuk</a></li>
                            <li><a class="dropdown-item" href="#">Demam Bedahak</a></li>
                            <li><a class="dropdown-item" href="#">Sakit Gigi</a></li>
                        </ul>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary mt-2 float-end">Tambah</button>
                </form>

                <h6 class="fw-bold mt-5">Daftar Diagnosis</h6>
                <ol type="1">
                    <li>HYPERTENSI KRONIS</li>
                    <li>DYSPEPSIA</li>
                    <li>DEPRESIVE EPISODE</li>
                </ol>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('openVerticalCenterModal').addEventListener('click', function() {
        var modalKedua = new bootstrap.Modal(document.getElementById('verticalCenter'), {
            backdrop: 'static',
            keyboard: false
        });
        modalKedua.show();
    });
</script>
