<button class="btn btn-sm" type="button" id="openTindakLanjut">
    <i class="bi bi-plus-square"></i> Tambah Tindak Lanjut
</button>

<div class="modal fade" id="tindakLanjut" tabindex="-1" aria-labelledby="tindakLanjutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tindakLanjutModalLabel">Tambah/Edit Tindak Lanjut</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editIndex" value="-1">
                
                <div class="mb-3">
                    <label class="form-label">Tindak Lanjut</label>
                    <div>
                        <input type="radio" name="tindakLanjut" value="rawatInap" id="rawatInap"> Rawat Inap
                    </div>
                    <div>
                        <input type="radio" name="tindakLanjut" value="kamarOperasi" id="kamarOperasi"> Kamar Operasi
                    </div>
                    <div>
                        <input type="radio" name="tindakLanjut" value="rujukKeluar" id="rujukKeluar"> Rujuk Keluar RS Bagian
                    </div>
                    <div>
                        <input type="radio" name="tindakLanjut" value="pulangKontrol" id="pulangKontrol"> Pulang Kontrol di Klinik
                    </div>
                    <div>
                        <input type="radio" name="tindakLanjut" value="menolakRawatInap" id="menolakRawatInap"> Menolak Rawat Inap
                    </div>
                    <div>
                        <input type="radio" name="tindakLanjut" value="meninggalDunia" id="meninggalDunia"> Meninggal Dunia
                    </div>
                </div>

                <div class="mb-3" id="textareaInput" style="display: none;">
                    <label for="keteranganTindakLanjut" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keteranganTindakLanjut" rows="3"></textarea>
                </div>

                <div class="mb-3" id="tanggalJamInput" style="display: none;">
                    <label for="tanggalMeninggal" class="form-label">Tanggal Meninggal</label>
                    <input type="date" class="form-control" id="tanggalMeninggal">
                    <label for="jamMeninggal" class="form-label mt-2">Jam Meninggal</label>
                    <input type="time" class="form-control" id="jamMeninggal">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanTindakLanjut">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var tindakLanjut = new bootstrap.Modal(document.getElementById('tindakLanjut'));
    var tindakLanjutData = [];

    document.getElementById('openTindakLanjut').addEventListener('click', function() {
        resetForm();
        tindakLanjut.show();
    });

    document.querySelectorAll('input[name="tindakLanjut"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            toggleInputFields(this.value);
        });
    });

    document.getElementById('simpanTindakLanjut').addEventListener('click', function() {
        var selectedOption = document.querySelector('input[name="tindakLanjut"]:checked');
        var keterangan = document.getElementById('keteranganTindakLanjut').value;
        var tanggalMeninggal = document.getElementById('tanggalMeninggal').value;
        var jamMeninggal = document.getElementById('jamMeninggal').value;

        if (selectedOption) {
            var editIndex = document.getElementById('editIndex').value;
            var tindakLanjut = {
                option: selectedOption.value,
                keterangan: keterangan,
                tanggalMeninggal: tanggalMeninggal,
                jamMeninggal: jamMeninggal
            };

            if (editIndex === "-1") {
                tindakLanjutData.push(tindakLanjut);
            } else {
                tindakLanjutData[parseInt(editIndex)] = tindakLanjut;
            }

            updateTindakLanjutTable();
            tindakLanjut.hide();
            resetForm();
        } else {
            alert('Harap pilih salah satu tindak lanjut');
        }
    });

    function resetForm() {
        document.querySelectorAll('input[name="tindakLanjut"]').forEach(function(radio) {
            radio.checked = false;
        });
        document.getElementById('keteranganTindakLanjut').value = '';
        document.getElementById('tanggalMeninggal').value = '';
        document.getElementById('jamMeninggal').value = '';
        document.getElementById('editIndex').value = "-1";
        toggleInputFields(null);
    }

    function toggleInputFields(selectedOption) {
        document.getElementById('textareaInput').style.display = 'none';
        document.getElementById('tanggalJamInput').style.display = 'none';

        if (selectedOption === 'rawatInap' || selectedOption === 'kamarOperasi' || 
            selectedOption === 'rujukKeluar' || selectedOption === 'pulangKontrol' || 
            selectedOption === 'menolakRawatInap') {
            document.getElementById('textareaInput').style.display = 'block';
        }

        if (selectedOption === 'meninggalDunia') {
            document.getElementById('tanggalJamInput').style.display = 'block';
        }
    }

    function updateTindakLanjutTable() {
        var tableBody = document.querySelector('#tindakLanjutTable tbody');
        if (tableBody) {
            tableBody.innerHTML = '';
            tindakLanjutData.forEach(function(tindakLanjut, index) {
                var row = tableBody.insertRow();
                row.innerHTML = `
                <td>${tindakLanjut.option}</td>
                <td>${tindakLanjut.keterangan || ''}</td>
                <td>${tindakLanjut.tanggalMeninggal || ''}</td>
                <td>${tindakLanjut.jamMeninggal || ''}</td>
                <td>
                    <button class="btn btn-sm btn-link edit-tindakLanjut" data-index="${index}">
                    <i class="bi bi-pencil-fill text-primary"></i>
                    </button>
                    <button class="btn btn-sm btn-link hapus-tindakLanjut" data-index="${index}">
                        <i class="bi bi-trash-fill text-danger"></i>
                    </button>
                </td>
            `;
            });

            // Tambahkan event listener untuk tombol edit dan hapus
            document.querySelectorAll('.edit-tindakLanjut').forEach(function(button) {
                button.addEventListener('click', function() {
                    var index = this.getAttribute('data-index');
                    editTindakLanjut(index);
                });
            });

            document.querySelectorAll('.hapus-tindakLanjut').forEach(function(button) {
                button.addEventListener('click', function() {
                    var index = this.getAttribute('data-index');
                    tindakLanjutData.splice(index, 1);
                    updateTindakLanjutTable();
                });
            });
        }
    }

    function editTindakLanjut(index) {
        var tindakLanjut = tindakLanjutData[index];
        document.querySelector(`input[name="tindakLanjut"][value="${tindakLanjut.option}"]`).checked = true;
        toggleInputFields(tindakLanjut.option);
        document.getElementById('keteranganTindakLanjut').value = tindakLanjut.keterangan;
        document.getElementById('tanggalMeninggal').value = tindakLanjut.tanggalMeninggal;
        document.getElementById('jamMeninggal').value = tindakLanjut.jamMeninggal;
        document.getElementById('editIndex').value = index;
        tindakLanjut.show();
    }
});
</script>
