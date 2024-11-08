<button class="btn btn-sm" type="button" id="openEditTindakLanjut">
</button>

<div class="modal fade" id="editTindakLanjutModal" tabindex="-1" aria-labelledby="editTindakLanjutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTindakLanjutModalLabel">Edit Tindak Lanjut</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tindak Lanjut</label>
                    <div>
                        <input type="radio" name="editTindakLanjut" value="rawatInap" id="editRawatInap"> Rawat Inap
                    </div>
                    <div>
                        <input type="radio" name="editTindakLanjut" value="kamarOperasi" id="editKamarOperasi"> Kamar Operasi
                    </div>
                    <div>
                        <input type="radio" name="editTindakLanjut" value="rujukKeluar" id="editRujukKeluar"> Rujuk Keluar RS
                    </div>
                    <div>
                        <input type="radio" name="editTindakLanjut" value="pulangKontrol" id="editPulangKontrol"> Pulang Kontrol di Klinik
                    </div>
                    <div>
                        <input type="radio" name="editTindakLanjut" value="menolakRawatInap" id="editMenolakRawatInap"> Menolak Rawat Inap
                    </div>
                    <div>
                        <input type="radio" name="editTindakLanjut" value="meninggalDunia" id="editMeninggalDunia"> Meninggal Dunia
                    </div>
                </div>

                <div class="mb-3" id="editTextareaInput" style="display: none;">
                    <label for="editKeteranganTindakLanjut" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="editKeteranganTindakLanjut" rows="3"></textarea>
                </div>

                <div class="mb-3" id="editTanggalJamInput" style="display: none;">
                    <label for="editTanggalMeninggal" class="form-label">Tanggal Meninggal</label>
                    <input type="date" class="form-control" id="editTanggalMeninggal">
                    <label for="editJamMeninggal" class="form-label mt-2">Jam Meninggal</label>
                    <input type="time" class="form-control" id="editJamMeninggal">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanEditTindakLanjut">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var editTindakLanjutModal = new bootstrap.Modal(document.getElementById('editTindakLanjutModal'));
    var editTindakLanjutData = null;
    var openEditTindakLanjutButton = document.getElementById('openEditTindakLanjut');

    // Event handler untuk membuka modal
    openEditTindakLanjutButton.addEventListener('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        resetEditForm();
        editTindakLanjutModal.show();
    });

    // Event handler untuk radio buttons
    document.querySelectorAll('input[name="editTindakLanjut"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            toggleEditInputFields(this.value);
        });
    });

    // Event handler untuk tombol simpan
    document.getElementById('simpanEditTindakLanjut').addEventListener('click', function() {
        var selectedOption = document.querySelector('input[name="editTindakLanjut"]:checked');
        var keterangan = document.getElementById('editKeteranganTindakLanjut').value;
        var tanggalMeninggal = document.getElementById('editTanggalMeninggal').value;
        var jamMeninggal = document.getElementById('editJamMeninggal').value;

        if (selectedOption) {
            editTindakLanjutData = {
                option: selectedOption.value,
                keterangan: keterangan,
                tanggalMeninggal: tanggalMeninggal,
                jamMeninggal: jamMeninggal
            };

            displayEditTindakLanjut();
            editTindakLanjutModal.hide();
            resetEditForm();
        } else {
            alert('Harap pilih salah satu tindak lanjut');
        }
    });

    // Fungsi reset form
    function resetEditForm() {
        document.querySelectorAll('input[name="editTindakLanjut"]').forEach(function(radio) {
            radio.checked = false;
        });
        document.getElementById('editKeteranganTindakLanjut').value = '';
        document.getElementById('editTanggalMeninggal').value = '';
        document.getElementById('editJamMeninggal').value = '';
        toggleEditInputFields(null);
    }

    // Fungsi toggle fields
    function toggleEditInputFields(selectedOption) {
        document.getElementById('editTextareaInput').style.display = 'none';
        document.getElementById('editTanggalJamInput').style.display = 'none';

        if (['rawatInap', 'kamarOperasi', 'rujukKeluar', 'pulangKontrol', 'menolakRawatInap'].includes(selectedOption)) {
            document.getElementById('editTextareaInput').style.display = 'block';
        }

        if (selectedOption === 'meninggalDunia') {
            document.getElementById('editTanggalJamInput').style.display = 'block';
        }
    }

    // Fungsi display tindak lanjut
    function displayEditTindakLanjut() {
        var tindakLanjutInfo = document.getElementById('editTindakLanjutInfo');
        tindakLanjutInfo.innerHTML = '';
        
        if (editTindakLanjutData) {
            var div = document.createElement('div');
            div.classList.add('mb-2', 'd-flex', 'justify-content-between', 'align-items-center');
            
            var infoText = `Tindak Lanjut: ${editTindakLanjutData.option}`;
            if (editTindakLanjutData.keterangan) {
                infoText += ` | Keterangan: ${editTindakLanjutData.keterangan}`;
            }
            if (editTindakLanjutData.tanggalMeninggal) {
                infoText += ` | Tanggal: ${editTindakLanjutData.tanggalMeninggal}`;
            }
            if (editTindakLanjutData.jamMeninggal) {
                infoText += ` | Jam: ${editTindakLanjutData.jamMeninggal}`;
            }

            var textSpan = document.createElement('span');
            textSpan.innerText = infoText;
            div.appendChild(textSpan);

            var buttonGroup = document.createElement('div');
            
            var editButton = document.createElement('button');
            editButton.innerHTML = '<i class="bi bi-pencil-fill"></i>';
            editButton.className = 'btn btn-sm btn-outline-primary me-2';
            editButton.addEventListener('click', editTindakLanjut);

            buttonGroup.appendChild(editButton);
            div.appendChild(buttonGroup);

            tindakLanjutInfo.appendChild(div);
        }
    }

    // Fungsi edit tindak lanjut
    function editTindakLanjut() {
        if (editTindakLanjutData) {
            // Set radio button
            document.querySelector(`input[name="editTindakLanjut"][value="${editTindakLanjutData.option}"]`).checked = true;
            
            // Set fields sesuai tipe
            document.getElementById('editKeteranganTindakLanjut').value = editTindakLanjutData.keterangan || '';
            document.getElementById('editTanggalMeninggal').value = editTindakLanjutData.tanggalMeninggal || '';
            document.getElementById('editJamMeninggal').value = editTindakLanjutData.jamMeninggal || '';
            
            // Tampilkan fields yang sesuai
            toggleEditInputFields(editTindakLanjutData.option);
            
            editTindakLanjutModal.show();
        }
    }

    }

    // Fungsi untuk collect data
    window.collectEditTindakLanjut = function() {
        if (!editTindakLanjutData) return null;

        return {
            option: editTindakLanjutData.option,
            keterangan: editTindakLanjutData.keterangan,
            tanggal_meninggal: editTindakLanjutData.tanggalMeninggal,
            jam_meninggal: editTindakLanjutData.jamMeninggal,
            rs_rujuk: editTindakLanjutData.rs_rujuk,
            rs_rujuk_bagian: editTindakLanjutData.rs_rujuk_bagian,
            tgl_kontrol_ulang: editTindakLanjutData.tgl_kontrol_ulang,
            unit_rawat_inap: editTindakLanjutData.unit_rawat_inap,
            unit_rujuk_internal: editTindakLanjutData.unit_rujuk_internal
        };
    };

    // Fungsi untuk mengisi data saat edit
    window.fillEditTindakLanjut = function(data) {
        if (data) {
            editTindakLanjutData = data;
            displayEditTindakLanjut();
        }
    };
});
</script>