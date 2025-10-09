<!-- Button untuk membuka modal diagnosis -->
<button type="button" class="btn btn-primary btn-sm mb-3" id="openVerticalCenterModal">
    <i class="bi bi-plus-square"></i> Tambah
</button>

<div class="modal fade" id="addDiagnosisModal" tabindex="-1" aria-labelledby="addDiagnosisModal" aria-hidden="true"
    style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDiagnosisModal">Input Asesmen/Diagnosis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <h6 class="fw-bold">Tambah Asesmen/Diagnosis</h6>
                <p class="text-muted">
                    (Isi diagnosis pada kolom dibawah dan Tekan tambah untuk menambah ke daftar diagnosis. Satu baris
                    untuk satu diagnosis)
                </p>

                <div class="dropdown">
                    <input type="text" class="form-control dropdown-toggle" id="searchInput"
                        placeholder="Nama Diagnosis" aria-expanded="false" autocomplete="off">
                    <ul class="dropdown-menu" id="dataList" aria-labelledby="searchInput">
                        <!-- Daftar data dari AJAX -->
                    </ul>
                </div>
                <button type="button" id="btnAddListDiagnosa"
                    class="btn btn-sm btn-primary mt-2 float-end mb-3">Tambah</button>

                <h6 class="fw-bold mt-5">Daftar Diagnosis</h6>
                <ol type="1" id="listDiagnosa">
                    <!-- Diagnosis yang akan ditambahkan -->
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnSaveDiagnose" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('openVerticalCenterModal').addEventListener('click', function () {
        var modalKedua = new bootstrap.Modal(document.getElementById('addDiagnosisModal'), {
            backdrop: 'static', // Agar tidak menutup modal pertama ketika klik di luar modal kedua
            keyboard: false // Agar tidak bisa ditutup dengan tombol ESC
        });
        modalKedua.show();
    });
</script>
