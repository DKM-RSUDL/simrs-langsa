<!-- Modal Alergi -->
<div class="modal fade" id="alergiModal" tabindex="-1" aria-labelledby="alergiModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alergiModalLabel">Input Alergi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold">Tambah Alergi</h6>
                <p class="text-muted">(Isi informasi alergi pada kolom di bawah dan Tekan tambah untuk menambah ke daftar alergi)</p>
                
                <div class="mb-3">
                    <input type="text" class="form-control" id="alergenInput" placeholder="Alergen" autocomplete="off">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="reaksiInput" placeholder="Reaksi" autocomplete="off">
                </div>
                <div class="mb-3">
                    <select class="form-select" id="severeInput">
                        <option value="">Pilih Tingkat Keparahan</option>
                        <option value="Ringan">Ringan</option>
                        <option value="Sedang">Sedang</option>
                        <option value="Berat">Berat</option>
                    </select>
                </div>
                <button type="button" id="btnAddAlergi" class="btn btn-sm btn-primary mt-2 float-end">Tambah</button>

                <h6 class="fw-bold mt-5">Daftar Alergi</h6>
                <ul id="listAlergi"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnSaveAlergi" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var alergiModal = new bootstrap.Modal(document.getElementById('alergiModal'));
    var alergiTable = document.querySelector('#createAlergiTable tbody');
    var listAlergi = document.getElementById('listAlergi');
    var alergis = []; // Array untuk menyimpan daftar alergi

    function updateMainView() {
        if (alergis.length === 0) {
            // Tampilkan pesan "Data kosong" jika tidak ada data
            alergiTable.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-3">
                        <div class="text-muted">
                            <i class="bi bi-exclamation-circle mb-2" style="font-size: 1.5rem;"></i>
                            <p class="mb-0">Belum ada data alergi</p>
                        </div>
                    </td>
                </tr>
            `;
        } else {
            // Tampilkan data jika ada
            alergiTable.innerHTML = alergis.map((a, index) => `
                <tr>
                    <td>${a.alergen}</td>
                    <td>${a.reaksi}</td>
                    <td>${a.severe}</td>
                    <td>
                        <button class="btn btn-sm btn-link delete-alergi" data-index="${index}">
                            <i class="ti-trash text-danger"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        }
    }

    function updateModalView() {
        if (alergis.length === 0) {
            // Tampilkan pesan "Data kosong" di modal
            listAlergi.innerHTML = `
                <div class="text-center text-muted p-3">
                    <i class="bi bi-exclamation-circle mb-2" style="font-size: 1.5rem;"></i>
                    <p class="mb-0">Belum ada data alergi</p>
                </div>
            `;
        } else {
            // Tampilkan data jika ada
            listAlergi.innerHTML = alergis.map(a => `
                <li class="mb-2">
                    <span class="fw-bold">${a.alergen}</span> - 
                    <span class="text-muted">${a.reaksi}</span> 
                    <span class="badge bg-warning">${a.severe}</span>
                </li>
            `).join('');
        }
    }

    document.getElementById('openAlergiModal').addEventListener('click', function() {
        updateModalView();
        alergiModal.show();
    });

    document.getElementById('btnAddAlergi').addEventListener('click', function() {
        var alergenInput = document.getElementById('alergenInput');
        var reaksiInput = document.getElementById('reaksiInput');
        var severeInput = document.getElementById('severeInput');
        
        if (alergenInput.value.trim() !== '' && reaksiInput.value.trim() !== '' && severeInput.value !== '') {
            alergis.push({
                alergen: alergenInput.value.trim(),
                reaksi: reaksiInput.value.trim(),
                severe: severeInput.value
            });
            updateModalView();

            // Clear inputs
            alergenInput.value = '';
            reaksiInput.value = '';
            severeInput.value = '';
        } else {
            alert('Harap isi semua field alergi');
        }
    });

    document.getElementById('btnSaveAlergi').addEventListener('click', function() {
        updateMainView();
        alergiModal.hide();
    });

    // Event delegation for delete buttons
    alergiTable.addEventListener('click', function(e) {
        if (e.target.closest('.delete-alergi')) {
            var row = e.target.closest('tr');
            var index = Array.from(row.parentElement.children).indexOf(row);
            alergis.splice(index, 1);
            updateMainView();
        }
    });

    alergis = [];
    updateMainView();
});
</script>