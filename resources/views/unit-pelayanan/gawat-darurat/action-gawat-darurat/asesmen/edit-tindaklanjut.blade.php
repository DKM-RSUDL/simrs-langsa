<!-- Button to open modal -->
<button class="btn btn-sm" type="button" id="openEditTindakLanjut">
    <i class="bi bi-plus-square"></i> Tambah Tindak Lanjut
</button>

<!-- Modal -->
<div class="modal fade" id="editTindakLanjutModal" tabindex="-1" aria-labelledby="editTindakLanjutModalLabel"
    aria-hidden="true">
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
                        <input type="radio" name="editTindakLanjut" value="rawatInap" id="editRawatInap">
                        <label for="editRawatInap">Rawat Inap</label>
                    </div>
                    <div>
                        <input type="radio" name="editTindakLanjut" value="kamarOperasi" id="editKamarOperasi">
                        <label for="editKamarOperasi">Kamar Operasi</label>
                    </div>
                    <div>
                        <input type="radio" name="editTindakLanjut" value="rujukKeluar" id="editRujukKeluar">
                        <label for="editRujukKeluar">Rujuk Keluar RS</label>
                    </div>
                    <div>
                        <input type="radio" name="editTindakLanjut" value="pulangKontrol" id="editPulangKontrol">
                        <label for="editPulangKontrol">Pulang Kontrol di Klinik</label>
                    </div>
                    <div>
                        <input type="radio" name="editTindakLanjut" value="menolakRawatInap"
                            id="editMenolakRawatInap">
                        <label for="editMenolakRawatInap">Menolak Rawat Inap</label>
                    </div>
                    <div>
                        <input type="radio" name="editTindakLanjut" value="meninggalDunia" id="editMeninggalDunia">
                        <label for="editMeninggalDunia">Meninggal Dunia</label>
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
                <button type="button" class="btn btn-warning me-2" onclick="handleKosongkan()">Kosongkan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanEditTindakLanjut">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editTindakLanjutModal = new bootstrap.Modal(document.getElementById('editTindakLanjutModal'));
        var editTindakLanjutData = {
            option: '',
            keterangan: '',
            tanggalMeninggal: '',
            jamMeninggal: ''
        };

        // Event handler untuk membuka modal
        document.getElementById('openEditTindakLanjut').addEventListener('click', function(event) {
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

            editTindakLanjutData = {
                option: selectedOption ? selectedOption.value : '',
                keterangan: keterangan || '',
                tanggalMeninggal: tanggalMeninggal || '',
                jamMeninggal: jamMeninggal || ''
            };

            displayEditTindakLanjut();
            editTindakLanjutModal.hide();
        });

        function resetEditForm() {
            document.querySelectorAll('input[name="editTindakLanjut"]').forEach(function(radio) {
                radio.checked = false;
            });
            document.getElementById('editKeteranganTindakLanjut').value = '';
            document.getElementById('editTanggalMeninggal').value = '';
            document.getElementById('editJamMeninggal').value = '';
            toggleEditInputFields(null);
        }

        function toggleEditInputFields(selectedOption) {
            document.getElementById('editTextareaInput').style.display = 'none';
            document.getElementById('editTanggalJamInput').style.display = 'none';

            if (['rawatInap', 'kamarOperasi', 'rujukKeluar', 'pulangKontrol', 'menolakRawatInap'].includes(
                    selectedOption)) {
                document.getElementById('editTextareaInput').style.display = 'block';
            }

            if (selectedOption === 'meninggalDunia') {
                document.getElementById('editTanggalJamInput').style.display = 'block';
            }
        }

        function displayEditTindakLanjut() {
            var tindakLanjutInfo = document.getElementById('editTindakLanjutInfo');
            if (!tindakLanjutInfo) return;

            tindakLanjutInfo.innerHTML = '';

            var div = document.createElement('div');
            div.classList.add('mb-2', 'd-flex', 'justify-content-between', 'align-items-center');

            var textSpan = document.createElement('span');
            if (editTindakLanjutData && editTindakLanjutData.option) {
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
                textSpan.innerText = infoText;
            } else {
                textSpan.innerText = 'Tindak Lanjut: (Kosong)';
            }
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

        function editTindakLanjut() {
            editTindakLanjutModal.show();

            if (editTindakLanjutData.option) {
                const radioButton = document.querySelector(
                    `input[name="editTindakLanjut"][value="${editTindakLanjutData.option}"]`);
                if (radioButton) {
                    radioButton.checked = true;
                    toggleEditInputFields(editTindakLanjutData.option);
                }
            }

            document.getElementById('editKeteranganTindakLanjut').value = editTindakLanjutData.keterangan || '';
            document.getElementById('editTanggalMeninggal').value = editTindakLanjutData.tanggalMeninggal || '';
            document.getElementById('editJamMeninggal').value = editTindakLanjutData.jamMeninggal || '';
        }

        window.handleKosongkan = function() {
            editTindakLanjutData = {
                option: '',
                keterangan: '',
                tanggalMeninggal: '',
                jamMeninggal: ''
            };
            displayEditTindakLanjut();
            editTindakLanjutModal.hide();
        };

        window.collectEditTindakLanjut = function() {
            return JSON.stringify(editTindakLanjutData);
        };

        window.fillEditTindakLanjut = function(data) {
            try {
                if (data) {
                    editTindakLanjutData = typeof data === 'string' ? JSON.parse(data) : data;
                } else {
                    editTindakLanjutData = {
                        option: '',
                        keterangan: '',
                        tanggalMeninggal: '',
                        jamMeninggal: ''
                    };
                }
                displayEditTindakLanjut();
            } catch (e) {
                console.error('Error parsing tindak lanjut data:', e);
                editTindakLanjutData = {
                    option: '',
                    keterangan: '',
                    tanggalMeninggal: '',
                    jamMeninggal: ''
                };
                displayEditTindakLanjut();
            }
        };
    });
</script>
