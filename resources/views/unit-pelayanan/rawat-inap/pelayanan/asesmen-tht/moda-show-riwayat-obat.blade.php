<!-- Modal for Adding/Editing Medication History -->
<div class="modal fade" id="modal-medication-history" tabindex="-1" aria-labelledby="medicationHistoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="medicationHistoryLabel">Tambah Obat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-medication-history">
                    <div class="mb-3">
                        <label class="form-label">Nama Obat</label>
                        <input type="text" class="form-control" id="medication-name" placeholder="Masukkan nama obat">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Aturan Pakai</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label small">Frekuensi/interval</label>
                                <input type="text" class="form-control" id="medication-frequency" placeholder="medication frequency">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Keterangan</label>
                                <select class="form-select" id="medication-timing">
                                    <option value="Sebelum Makan">Sebelum Makan</option>
                                    <option value="Sesudah Makan" selected>Sesudah Makan</option>
                                    <option value="Saat Makan">Saat Makan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Dosis sekali minum</label>
                            <input type="text" class="form-control" id="medication-dose" placeholder="medication dose">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="medication-unit" value="Tablet">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-save-medication">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
    $(document).ready(function() {
        function safeParseJson(value, defaultValue = []) {
            if (Array.isArray(value)) return value;

            if (typeof value === 'string') {
                try {
                    const parsed = JSON.parse(value);
                    return Array.isArray(parsed) ? parsed : defaultValue;
                } catch (error) {
                    console.error('Error parsing medication history JSON:', error);
                    return defaultValue;
                }
            }

            return defaultValue;
        }

        // Initialize medication history from the database
        let medicationHistory = safeParseJson(
            @json($asesmen->rmeAsesmenThtRiwayatKesehatanObatAlergi[0]['riwayat_penggunaan_obat'] ?? [])
        );

        let editingIndex = -1;

        function resetMedicationForm() {
            $('#medication-name').val('');
            $('#medication-frequency').val('3 x 1 hari');
            $('#medication-timing').val('Sesudah Makan');
            $('#medication-dose').val('1/2');
            $('#medication-unit').val('Tablet');
            editingIndex = -1;
        }

        // Function to render medication history table
        function renderMedicationHistory() {
            const tableBody = $('#medication-history-table tbody');
            tableBody.empty();

            medicationHistory.forEach((medication, index) => {
                const dosisDisplay = `${medication.dosis} ${medication.satuan} ${medication.frekuensi}`;

                const tableRow = `
                    <tr>
                        <td>${medication.namaObat}</td>
                        <td>${dosisDisplay}</td>
                        <td>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>${medication.keterangan}</span>
                            </div>
                        </td>
                    </tr>
                `;
                tableBody.append(tableRow);
            });

            // Update hidden input
            $('#riwayatObatData').val(JSON.stringify(medicationHistory));
        }

        $('#btn-riwayat-obat').on('click', function() {
            resetMedicationForm();
            $('#medicationHistoryLabel').text('Tambah Obat');
            $('#modal-medication-history').modal('show');
        });

        // Save
        $('#btn-save-medication').on('click', function() {
            const medication = {
                namaObat: $('#medication-name').val().trim(),
                frekuensi: $('#medication-frequency').val(),
                dosis: $('#medication-dose').val(),
                satuan: $('#medication-unit').val(),
                keterangan: $('#medication-timing').val()
            };

            if (!medication.namaObat) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Nama obat harus diisi!'
                });
                return;
            }

            const isDuplicate = medicationHistory.some((item, index) =>
                item.namaObat.toLowerCase() === medication.namaObat.toLowerCase() &&
                item.dosis === medication.dosis &&
                item.satuan === medication.satuan &&
                index !== editingIndex
            );

            if (isDuplicate) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Obat dengan dosis yang sama sudah ada dalam daftar!'
                });
                return;
            }

            if (editingIndex === -1) {
                medicationHistory.push(medication);
            } else {
                medicationHistory[editingIndex] = medication;
            }

            renderMedicationHistory();

            $('#modal-medication-history').modal('hide');

            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: editingIndex === -1 ? 'Data obat berhasil ditambahkan' : 'Data obat berhasil diperbarui',
                timer: 1500,
                showConfirmButton: false
            });

            resetMedicationForm();
        });

        // Edit medication
        $(document).on('click', '.edit-medication', function() {
            editingIndex = $(this).data('index');
            const medication = medicationHistory[editingIndex];

            $('#medication-name').val(medication.namaObat);
            $('#medication-frequency').val(medication.frekuensi);
            $('#medication-timing').val(medication.keterangan);
            $('#medication-dose').val(medication.dosis);
            $('#medication-unit').val(medication.satuan);

            $('#medicationHistoryLabel').text('Edit Obat');

            $('#modal-medication-history').modal('show');
        });

        // Remove medication
        $(document).on('click', '.remove-medication', function() {
            const index = $(this).data('index');
            const medication = medicationHistory[index];

            Swal.fire({
                title: 'Hapus Obat',
                text: `Apakah Anda yakin ingin menghapus ${medication.namaObat}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    medicationHistory.splice(index, 1);

                    renderMedicationHistory();

                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: 'Data obat berhasil dihapus',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        });

        renderMedicationHistory();
    });
    </script>
@endpush
