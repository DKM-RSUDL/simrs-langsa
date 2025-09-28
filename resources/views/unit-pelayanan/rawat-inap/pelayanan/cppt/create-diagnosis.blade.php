<!-- Button untuk membuka modal kedua -->
<button type="button" class="btn btn-primary btn-sm" id="openVerticalCenterModal"><i class="bi bi-plus-square"></i>
    Tambah</button>

<div class="modal fade" id="addDiagnosisModal" tabindex="-1" aria-labelledby="addDiagnosisModal" aria-hidden="true"
    style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDiagnosisModal">Input Asesmen/Diagnosis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Diagnosis Sebelumnya -->
                @if(isset($lastDiagnoses) && count($lastDiagnoses) > 0)
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary">
                            <i class="bi bi-clock-history me-2"></i>Diagnosis Sebelumnya
                            @can('is-dokter-umum')
                                (Dokter)
                            @elsecan('is-dokter-spesialis')
                                (Dokter)
                            @elsecan('is-perawat')
                                (Perawat)
                            @elsecan('is-bidan')
                                (Bidan)
                            @elsecan('is-farmasi')
                                (Farmasi)
                            @elsecan('is-gizi')
                                (Gizi)
                            @endcan
                        </h6>
                        <div class="border rounded p-3 bg-light">
                            @foreach($lastDiagnoses as $diagnosis)
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted">{{ $diagnosis }}</span>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-use-previous"
                                        data-diagnosis="{{ $diagnosis }}">
                                        <i class="bi bi-plus-circle me-1"></i>Gunakan
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <hr>
                    </div>
                @endif

                <h6 class="fw-bold">Tambah Asesmen/Diagnosis Baru</h6>
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
                    class="btn btn-sm btn-primary mt-2 float-end">Tambah</button>

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
