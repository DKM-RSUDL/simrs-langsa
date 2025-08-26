<button class="btn btn-sm" type="button" id="openAlatModal">
    <i class="bi bi-plus-square"></i> Tambah
</button>

<div class="modal fade" id="alatModal" tabindex="-1" aria-labelledby="alatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alatModalLabel">Tambah/Edit Alat yang Digunakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editIndex" value="-1">
                <div class="mb-3">
                    <label for="namaAlat" class="form-label">Alat yang Terpasang</label>
                    <select class="form-select" id="namaAlat">
                        <option value="">Pilih</option>
                        <option value="IV Line">IV Line</option>
                        <option value="Kateter">Kateter</option>
                        <option value="CVC">CVC</option>
                        <option value="NGT">NGT</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="lokasiAlat" class="form-label">Lokasi</label>
                    <input type="text" class="form-control" id="lokasiAlat">
                </div>
                <div class="mb-3">
                    <label for="keteranganAlat" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" id="keteranganAlat">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanAlat">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var alatModal = new bootstrap.Modal(document.getElementById('alatModal'));
        var alatData = [];

        document.getElementById('openAlatModal').addEventListener('click', function() {
            resetForm();
            alatModal.show();
        });

        document.getElementById('simpanAlat').addEventListener('click', function() {
            var namaAlat = document.getElementById('namaAlat');
            var lokasiAlat = document.getElementById('lokasiAlat');
            var keteranganAlat = document.getElementById('keteranganAlat');

            if (namaAlat.value && lokasiAlat.value && keteranganAlat.value) {
                var editIndex = document.getElementById('editIndex').value;
                var alat = {
                    nama: namaAlat.value,
                    lokasi: lokasiAlat.value,
                    keterangan: keteranganAlat.value,
                };

                if (editIndex === "-1") {
                    alatData.push(alat);
                } else {
                    alatData[parseInt(editIndex)] = alat;
                }

                updateAlatTable();
                alatModal.hide();
                resetForm();
            } else {
                alert('Harap isi semua field');
            }
        });

        function resetForm() {
            document.getElementById('namaAlat').value = '';
            document.getElementById('lokasiAlat').value = '';
            document.getElementById('keteranganAlat').value = '';
            document.getElementById('editIndex').value = "-1";
        }

        function editAlat(index) {
            var alat = alatData[index];
            document.getElementById('namaAlat').value = alat.nama;
            document.getElementById('lokasiAlat').value = alat.lokasi;
            document.getElementById('keteranganAlat').value = alat.keterangan;
            document.getElementById('editIndex').value = index;
            alatModal.show();
        }

        function updateAlatTable() {
            var tableBody = document.querySelector('#alatTable tbody');
            if (tableBody) {
                tableBody.innerHTML = '';

                // Check if there's no data
                if (alatData.length === 0) {
                    var emptyRow = tableBody.insertRow();
                    emptyRow.innerHTML = `
                    <td colspan="4" class="text-center text-muted">
                        <div class="py-3">
                            Tidak ada alat yang terpasang
                        </div>
                    </td>
                `;
                    return;
                }

                // If there is data, display it as before
                alatData.forEach(function(alat, index) {
                    var row = tableBody.insertRow();
                    row.innerHTML = `
                    <td>${alat.nama}</td>
                    <td>${alat.lokasi}</td>
                    <td>${alat.keterangan}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-link edit-alat" data-index="${index}">
                            <i class="bi bi-pencil-fill text-primary"></i>
                        </button>
                        <button class="btn btn-sm btn-link hapus-alat" data-index="${index}">
                            <i class="bi bi-trash-fill text-danger"></i>
                        </button>
                    </td>
                `;
                });

                // Add event listeners for edit and delete buttons
                document.querySelectorAll('.edit-alat').forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        var index = this.getAttribute('data-index');
                        editAlat(index);
                    });
                });

                document.querySelectorAll('.hapus-alat').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var index = this.getAttribute('data-index');
                        if (confirm('Apakah Anda yakin ingin menghapus alat ini?')) {
                            alatData.splice(index, 1);
                            updateAlatTable();
                        }
                    });
                });
            }
        }

        window.getAlatTerpasangData = function() {
            return JSON.stringify(alatData);
        };

        window.updateAlatTerpasangData = function(newData) {
            alatData = newData;
            updateAlatTable();
        };

        updateAlatTable();

    });

    if (typeof window.getAlatTerpasangData === 'undefined') {
        window.getAlatTerpasangData = function() {
            return JSON.stringify([]);
        };
    }
</script>