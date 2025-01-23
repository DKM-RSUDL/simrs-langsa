<div class="modal fade" id="tindakanKeperawatanRisikoJatuhModal" tabindex="-1"
    aria-labelledby="tindakanKeperawatanRisikoJatuhModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tindakanKeperawatanRisikoJatuhModalLabel">Intervensi Risiko Jatuh</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="intervensi-risiko-jatuh-options">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="intervensiRisikoJatuh1"
                            value="Edukasi pasien dan keluarga">
                        <label class="form-check-label" for="intervensiRisikoJatuh1">Edukasi pasien dan
                            keluarga</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="intervensiRisikoJatuh2"
                            value="Pasang pita kuning">
                        <label class="form-check-label" for="intervensiRisikoJatuh2">Pasang pita kuning</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="intervensiRisikoJatuh3"
                            value="Beri bantuan berjalan">
                        <label class="form-check-label" for="intervensiRisikoJatuh3">Beri bantuan berjalan</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="intervensiRisikoJatuh4"
                            value="Tidak ada intervensi">
                        <label class="form-check-label" for="intervensiRisikoJatuh4">Tidak ada intervensi</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-save-tindakan-keperawatan"
                    data-section="risikojatuh">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi modal risiko jatuh
    const modal = new bootstrap.Modal(document.getElementById('tindakanKeperawatanRisikoJatuhModal'));
    
    // Event listener untuk tombol tambah
    document.querySelector('.btn-tindakan-keperawatan').addEventListener('click', function() {
        modal.show();
    });

    // Event listener untuk tombol simpan di modal
    document.querySelector('.btn-save-tindakan-keperawatan').addEventListener('click', function() {
        const selectedIntervensi = [];
        document.querySelectorAll('.intervensi-risiko-jatuh-options input[type="checkbox"]:checked').forEach(checkbox => {
            selectedIntervensi.push(checkbox.value);
        });

        // Tampilkan intervensi yang dipilih
        const selectedList = document.getElementById('selectedTindakanList-risikojatuh');
        selectedList.innerHTML = selectedIntervensi.map(item => `
            <div class="alert alert-light border d-flex justify-content-between align-items-center py-2 mb-1">
                <span>${item}</span>
                <button type="button" class="btn btn-sm btn-link text-danger delete-intervensi p-0 m-0" onclick="deleteIntervensi(this)">
                    <i class="ti-trash"></i>
                </button>
            </div>
        `).join('');

        // Reset checkbox jika "Tidak ada intervensi" dipilih
        const noIntervensiCheckbox = document.getElementById('intervensiRisikoJatuh4');
        if (noIntervensiCheckbox.checked) {
            document.querySelectorAll('.intervensi-risiko-jatuh-options input[type="checkbox"]').forEach(checkbox => {
                if (checkbox.id !== 'intervensiRisikoJatuh4') {
                    checkbox.checked = false;
                }
            });
        }

        modal.hide();
    });

    // Event listener untuk "Tidak ada intervensi" checkbox
    document.getElementById('intervensiRisikoJatuh4').addEventListener('change', function() {
        if (this.checked) {
            document.querySelectorAll('.intervensi-risiko-jatuh-options input[type="checkbox"]').forEach(checkbox => {
                if (checkbox.id !== 'intervensiRisikoJatuh4') {
                    checkbox.checked = false;
                    checkbox.disabled = true;
                }
            });
        } else {
            document.querySelectorAll('.intervensi-risiko-jatuh-options input[type="checkbox"]').forEach(checkbox => {
                checkbox.disabled = false;
            });
        }
    });

    // Event listener untuk checkbox lainnya
    document.querySelectorAll('.intervensi-risiko-jatuh-options input[type="checkbox"]').forEach(checkbox => {
        if (checkbox.id !== 'intervensiRisikoJatuh4') {
            checkbox.addEventListener('change', function() {
                const noIntervensiCheckbox = document.getElementById('intervensiRisikoJatuh4');
                if (this.checked) {
                    noIntervensiCheckbox.checked = false;
                    noIntervensiCheckbox.disabled = true;
                } else {
                    const anyChecked = Array.from(document.querySelectorAll('.intervensi-risiko-jatuh-options input[type="checkbox"]'))
                        .some(cb => cb.id !== 'intervensiRisikoJatuh4' && cb.checked);
                    noIntervensiCheckbox.disabled = anyChecked;
                }
            });
        }
    });
});

// Fungsi untuk menghapus intervensi
function deleteIntervensi(button) {
    const interventionText = button.parentElement.querySelector('span').textContent;
    // Uncheck checkbox yang sesuai
    document.querySelectorAll('.intervensi-risiko-jatuh-options input[type="checkbox"]').forEach(checkbox => {
        if (checkbox.value === interventionText) {
            checkbox.checked = false;
            // Trigger change event untuk update status "Tidak ada intervensi" checkbox
            const event = new Event('change');
            checkbox.dispatchEvent(event);
        }
    });
    button.parentElement.remove();
}
</script>