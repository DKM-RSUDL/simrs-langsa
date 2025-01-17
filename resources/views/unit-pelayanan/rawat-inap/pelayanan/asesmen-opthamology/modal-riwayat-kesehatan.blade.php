<!-- Modal Riwayat Kesehatan -->
<div class="modal fade" id="riwayatKesehatanModal" tabindex="-1" aria-labelledby="riwayatKesehatanModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="riwayatKesehatanModalLabel">Input Riwayat Penyakit Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold">Tambah Riwayat Penyakit Pasien</h6>
                <p class="text-muted">(Isi riwayat penyakit pada kolom di bawah dan Tekan tambah untuk menambah ke daftar riwayat penyakit)</p>
                
                <div class="mb-3">
                    <textarea class="form-control" id="riwayatInput" rows="3" placeholder="Masukkan riwayat penyakit"></textarea>
                </div>
                
                <button type="button" id="btnAddRiwayat" class="btn btn-sm btn-primary mt-2 float-end">Tambah</button>

                <h6 class="fw-bold mt-5">Daftar Riwayat Penyakit</h6>
                <div id="listRiwayat" class="list-group mt-3">
                    <!-- Daftar riwayat akan ditampilkan di sini -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="btnSaveRiwayat" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var riwayatModal = new bootstrap.Modal(document.getElementById('riwayatKesehatanModal'));
    var daftarRiwayatContainer = document.getElementById('daftarRiwayatContainer');
    var listRiwayat = document.getElementById('listRiwayat');
    var riwayats = []; // Array untuk menyimpan daftar riwayat

    function updateMainView() {
        daftarRiwayatContainer.innerHTML = riwayats.map((r, index) => `
            <div class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                <div class="flex-grow-1">
                    <i class="bi bi-clipboard2-pulse text-primary me-2"></i>
                    <span class="fw-bold text-decoration-underline">${r.text}</span>
                </div>
                <button class="btn btn-sm btn-outline-danger delete-riwayat" data-index="${index}" style="min-width: 60px;">
                    <i class="bi bi-trash me-1"></i>Hapus
                </button>
                <input type="hidden" name="riwayat_kesehatan[]" value="${r.text}">
            </div>
        `).join('');

        if (riwayats.length === 0) {
            daftarRiwayatContainer.innerHTML = `
                <div class="text-center text-muted p-3">
                    <i class="bi bi-clipboard2-x mb-2" style="font-size: 1.5rem;"></i>
                    <p class="mb-0">Belum ada riwayat kesehatan</p>
                </div>
            `;
        }
    }

    function updateModalView() {
        listRiwayat.innerHTML = riwayats.map((r, index) => `
            <div class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                <div class="flex-grow-1">
                    <i class="bi bi-clipboard2-pulse text-primary me-2"></i>
                    <span class="fw-bold text-decoration-underline">${r.text}</span>
                </div>
                <button class="btn btn-sm btn-outline-danger delete-modal-riwayat" data-index="${index}" style="min-width: 60px;">
                    <i class="bi bi-trash me-1"></i>Hapus
                </button>
            </div>
        `).join('');

        if (riwayats.length === 0) {
            listRiwayat.innerHTML = `
                <div class="text-center text-muted p-3">
                    <i class="bi bi-clipboard2-x mb-2" style="font-size: 1.5rem;"></i>
                    <p class="mb-0">Belum ada riwayat kesehatan</p>
                </div>
            `;
        }
    }

    document.getElementById('openRiwayatModal').addEventListener('click', function() {
        updateModalView();
        riwayatModal.show();
    });

    document.getElementById('btnAddRiwayat').addEventListener('click', function() {
        var riwayatInput = document.getElementById('riwayatInput');
        
        if (riwayatInput.value.trim() !== '') {
            riwayats.push({
                text: riwayatInput.value.trim()
            });
            updateModalView();
            riwayatInput.value = '';
        } else {
            alert('Harap isi riwayat penyakit');
        }
    });

    document.getElementById('btnSaveRiwayat').addEventListener('click', function() {
        updateMainView();
        riwayatModal.hide();
    });

    // Event delegation for delete buttons in main view
    daftarRiwayatContainer.addEventListener('click', function(e) {
        if (e.target.closest('.delete-riwayat')) {
            var item = e.target.closest('.list-group-item');
            var index = Array.from(item.parentElement.children).indexOf(item);
            riwayats.splice(index, 1);
            updateMainView();
        }
    });

    // Event delegation for delete buttons in modal
    listRiwayat.addEventListener('click', function(e) {
        if (e.target.closest('.delete-modal-riwayat')) {
            var item = e.target.closest('.list-group-item');
            var index = Array.from(item.parentElement.children).indexOf(item);
            riwayats.splice(index, 1);
            updateModalView();
        }
    });

    riwayats = [];
    updateMainView();
});
</script>