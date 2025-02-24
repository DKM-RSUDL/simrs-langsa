<!-- Allergy Management Modal -->
<div class="modal fade" id="modal-allergy-management" tabindex="-1" aria-labelledby="allergyManagementLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="allergyManagementLabel">Input Alergi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold">Tambah Alergi</h6>
                <p class="text-muted">(Isi informasi alergi pada kolom di bawah dan tekan tambah untuk menambah ke daftar alergi)</p>

                <form id="form-allergy-management">
                    <div class="mb-3">
                        <label class="form-label">Alergen</label>
                        <input type="text" class="form-control" id="allergy-alergen" placeholder="Masukkan alergen" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reaksi</label>
                        <input type="text" class="form-control" id="allergy-reaction" placeholder="Masukkan reaksi" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tingkat Keparahan</label>
                        <select class="form-select" id="allergy-severity">
                            <option value="">Pilih Tingkat Keparahan</option>
                            <option value="Ringan">Ringan</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Berat">Berat</option>
                        </select>
                    </div>
                    <div class="text-end">
                        <button type="button" id="btn-add-allergy" class="btn btn-primary">Tambah</button>
                    </div>
                </form>

                <h6 class="fw-bold mt-4">Daftar Alergi</h6>
                <div id="allergy-list-container" class="bg-light p-3 border rounded">
                    <div id="allergy-list">
                        <!-- Allergies will be dynamically populated here -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="btn-save-allergy" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function safeParseJson(value, defaultValue = []) {
        if (Array.isArray(value)) return value;

        if (typeof value === 'string') {
            try {
                const parsed = JSON.parse(value);
                return Array.isArray(parsed) ? parsed : defaultValue;
            } catch (error) {
                console.error('Error parsing allergy JSON:', error);
                return defaultValue;
            }
        }

        return defaultValue;
    }

    // Initialize allergy data from the database
    let allergyList = safeParseJson(
        @json($asesmen->rmeAsesmenThtRiwayatKesehatanObatAlergi[0]['alergi'] ?? [])
    );

    let editingIndex = -1;

    function resetAllergyForm() {
        $('#allergy-alergen').val('');
        $('#allergy-reaction').val('');
        $('#allergy-severity').val('');
        editingIndex = -1;
        $('#btn-add-allergy').text('Tambah');
    }

    function renderAllergyList() {
        const allergyListContainer = $('#allergy-list');
        const allergyTableBody = $('#createAlergiTable tbody');
        
        allergyListContainer.empty();
        allergyTableBody.empty();

        allergyList.forEach((allergy, index) => {
            const modalListItem = `
                <div class="d-flex justify-content-between align-items-center mb-2 allergy-item" data-index="${index}">
                    <div>
                        <strong>${allergy.alergen}</strong> - ${allergy.reaksi}
                        <span class="badge bg-secondary ms-2">${allergy.severe}</span>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-outline-primary me-2 edit-allergy" data-index="${index}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger remove-allergy" data-index="${index}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            allergyListContainer.append(modalListItem);

            const tableRow = `
                <tr>
                    <td>${allergy.alergen}</td>
                    <td>${allergy.reaksi}</td>
                    <td>${allergy.severe}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-link delete-allergy" data-index="${index}">
                                <i class="bi bi-trash text-danger"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            allergyTableBody.append(tableRow);
        });

        $('input[name="alergi"]').val(JSON.stringify(allergyList));
    }

    $('#openAlergiModal').on('click', function() {
        resetAllergyForm();
        renderAllergyList();
        $('#modal-allergy-management').modal('show');
    });

    // Add or update allergy
    $('#btn-add-allergy').on('click', function() {
        const allergy = {
            alergen: $('#allergy-alergen').val().trim(),
            reaksi: $('#allergy-reaction').val().trim(),
            severe: $('#allergy-severity').val()
        };

        if (!allergy.alergen || !allergy.reaksi || !allergy.severe) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Semua field harus diisi!'
            });
            return;
        }

        const isDuplicate = allergyList.some((item, index) => 
            item.alergen.toLowerCase() === allergy.alergen.toLowerCase() &&
            index !== editingIndex
        );

        if (isDuplicate) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Alergi ini sudah ada dalam daftar!'
            });
            return;
        }

        if (editingIndex === -1) {
            allergyList.push(allergy);
        } else {
            allergyList[editingIndex] = allergy;
        }

        renderAllergyList();

        resetAllergyForm();

        // Show success message
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: editingIndex === -1 ? 'Alergi berhasil ditambahkan' : 'Alergi berhasil diperbarui',
            timer: 1500,
            showConfirmButton: false
        });
    });

    // Edit allergy
    $(document).on('click', '.edit-allergy', function() {
        editingIndex = $(this).data('index');
        const allergy = allergyList[editingIndex];

        $('#allergy-alergen').val(allergy.alergen);
        $('#allergy-reaction').val(allergy.reaksi);
        $('#allergy-severity').val(allergy.severe);

        $('#btn-add-allergy').text('Update');

        $('.modal-body').scrollTop(0);
    });

    // Remove allergy
    $(document).on('click', '.remove-allergy, .delete-allergy', function() {
        const index = $(this).data('index');
        const allergy = allergyList[index];

        Swal.fire({
            title: 'Hapus Alergi',
            text: `Apakah Anda yakin ingin menghapus alergi "${allergy.alergen}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                allergyList.splice(index, 1);

                renderAllergyList();

                Swal.fire({
                    icon: 'success',
                    title: 'Terhapus!',
                    text: 'Alergi berhasil dihapus',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });

    // Save and close modal
    $('#btn-save-allergy').on('click', function() {
        renderAllergyList();
        $('#modal-allergy-management').modal('hide');

        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data alergi berhasil disimpan',
            timer: 1500,
            showConfirmButton: false
        });
    });

    $('#modal-allergy-management').on('hidden.bs.modal', function() {
        resetAllergyForm();
    });

    renderAllergyList();
});
</script>