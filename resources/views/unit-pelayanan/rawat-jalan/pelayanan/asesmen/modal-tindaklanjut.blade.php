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
                        <input type="radio" name="tindakLanjut" value="rujukKeluar" id="rujukKeluar"> Rujuk Keluar RS
                        Bagian
                    </div>
                    <div>
                        <input type="radio" name="tindakLanjut" value="pulangKontrol" id="pulangKontrol"> Pulang
                        Kontrol di Klinik
                    </div>
                    <div>
                        <input type="radio" name="tindakLanjut" value="menolakRawatInap" id="menolakRawatInap">
                        Menolak Rawat Inap
                    </div>
                    <div>
                        <input type="radio" name="tindakLanjut" value="meninggalDunia" id="meninggalDunia"> Meninggal
                        Dunia
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

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var tindakLanjutModal = new bootstrap.Modal(document.getElementById('tindakLanjut'));
    var tindakLanjutData = null;
    var openTindakLanjutButton = document.getElementById('openTindakLanjut');

    openTindakLanjutButton.addEventListener('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        resetForm();
        tindakLanjutModal.show();
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
            tindakLanjutData = {
                option: selectedOption.value,
                keterangan: keterangan,
                tanggalMeninggal: tanggalMeninggal,
                jamMeninggal: jamMeninggal
            };

            displayTindakLanjut();
            tindakLanjutModal.hide();
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
        toggleInputFields(null);
    }

    function toggleInputFields(selectedOption) {
        document.getElementById('textareaInput').style.display = 'none';
        document.getElementById('tanggalJamInput').style.display = 'none';

        if (['rawatInap', 'kamarOperasi', 'rujukKeluar', 'pulangKontrol', 'menolakRawatInap'].includes(selectedOption)) {
            document.getElementById('textareaInput').style.display = 'block';
        }

        if (selectedOption === 'meninggalDunia') {
            document.getElementById('tanggalJamInput').style.display = 'block';
        }
    }

    function displayTindakLanjut() {
        var tindakLanjutInfo = document.getElementById('tindakLanjutInfo');
        tindakLanjutInfo.innerHTML = ''; // Kosongkan div terlebih dahulu
        if (tindakLanjutData) {
            var div = document.createElement('div');
            div.classList.add('mb-2', 'd-flex', 'justify-content-between', 'align-items-center');
            var infoText = `Tindak Lanjut: ${tindakLanjutData.option}`;

            if (tindakLanjutData.keterangan) {
                infoText += ` | Keterangan: ${tindakLanjutData.keterangan}`;
            }
            if (tindakLanjutData.tanggalMeninggal) {
                infoText += ` | Tanggal: ${tindakLanjutData.tanggalMeninggal}`;
            }
            if (tindakLanjutData.jamMeninggal) {
                infoText += ` | Jam: ${tindakLanjutData.jamMeninggal}`;
            }

            var textSpan = document.createElement('span');
            textSpan.innerText = infoText;
            div.appendChild(textSpan);

            var buttonGroup = document.createElement('div');
            
            var editButton = document.createElement('button');
            editButton.innerHTML = '<i class="bi bi-pencil-fill"></i>';
            editButton.className = 'btn btn-sm btn-outline-primary me-2';
            editButton.addEventListener('click', editTindakLanjut);

            var deleteButton = document.createElement('button');
            deleteButton.innerHTML = '<i class="bi bi-trash-fill"></i>';
            deleteButton.className = 'btn btn-sm btn-outline-danger';
            deleteButton.addEventListener('click', deleteTindakLanjut);

            buttonGroup.appendChild(editButton);
            buttonGroup.appendChild(deleteButton);
            div.appendChild(buttonGroup);

            tindakLanjutInfo.appendChild(div);
        }
    }

    function editTindakLanjut() {
        if (tindakLanjutData) {
            document.querySelector(`input[name="tindakLanjut"][value="${tindakLanjutData.option}"]`).checked = true;
            document.getElementById('keteranganTindakLanjut').value = tindakLanjutData.keterangan || '';
            document.getElementById('tanggalMeninggal').value = tindakLanjutData.tanggalMeninggal || '';
            document.getElementById('jamMeninggal').value = tindakLanjutData.jamMeninggal || '';
            toggleInputFields(tindakLanjutData.option);
            tindakLanjutModal.show();
        }
    }

    function deleteTindakLanjut() {
        if (confirm('Apakah Anda yakin ingin menghapus tindak lanjut ini?')) {
            tindakLanjutData = null;
            displayTindakLanjut();
            openTindakLanjutButton.disabled = false;
        }
    }

    window.getTindakLanjutData = function() {
        return JSON.stringify(tindakLanjutData);
    };
});
</script>
@endpush